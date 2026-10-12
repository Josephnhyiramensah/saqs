<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    
    $company_id = $_SESSION['company_id'];
    $pay_sheet_id = $_SESSION['payroll_paye_pay_sheet_id'];
    $location = $_SESSION['payroll_paye_location'];

    function amount_in_words($amount)
    {
        global $con;
        $pay_sheet_id = $_SESSION['payroll_paye_pay_sheet_id'];
        $query = "SELECT * FROM payroll_pay_sheet WHERE pay_sheet_id = '$pay_sheet_id'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            $row = mysqli_fetch_assoc($query_run);
            if(isset($row['currency_id']) && $row['currency_id'] > 0)
            {
                $currency_id = $row['currency_id'];
            }
            else
            {
                $currency_id = 1;
            };
            
            $query_currency = "SELECT * FROM currency WHERE currency_id = '$currency_id'";
            $query_run_currency = mysqli_query($con, $query_currency);
            if(!empty($query_run_currency) && mysqli_num_rows($query_run_currency) > 0)
            {
                $row_currency = mysqli_fetch_assoc($query_run_currency);
                $currency = $row_currency['currency'];
                $decimals = $row_currency['decimals'];
            }
            else
            {
                $currency = 'N/A';
                $decimals = 'N/A';
            };
        }
        else
        {
            $currency = 'N/A';
            $decimals = 'N/A';
        };

        //$amount = number_format($amount,2,".",","); 
        $num_arr = explode(".",$amount);
        $number = $num_arr[0];
        if(isset($num_arr[1]))
        {
            $decnum = $num_arr[1];
        }
        else
        {
            $decnum = 0;
        };
        $result = "";
        function convert_number($number)
        {
            if (($number < 0) || ($number > 9999999999999))
            {
                return "$number";
            };

            $Tn = floor($number / 1000000000000); /* Trillions (giga) */
            $number -= $Tn * 1000000000000;
            $Bn = floor($number / 1000000000); /* Billions (giga) */
            $number -= $Bn * 1000000000;
            $Gn = floor($number / 1000000); /* Millions (giga) */
            $number -= $Gn * 1000000;
            $kn = floor($number / 1000); /* Thousands (kilo) */
            $number -= $kn * 1000;
            $Hn = floor($number / 100); /* Hundreds (hecto) */
            $number -= $Hn * 100;
            $Dn = floor($number / 10); /* Tens (deca) */
            $n = $number % 10; /* Ones */
            
            $res = "";
            
            if ($Tn){$res .= convert_number($Tn) . " Trillion";};
            if ($Bn){$res .= (empty($res) ? "" : " ") .convert_number($Bn) . " Billion";};
            if ($Gn){$res .= (empty($res) ? "" : " ") .convert_number($Gn) . " Million";};
            if ($kn){$res .= (empty($res) ? "" : " ") .convert_number($kn) . " Thousand";};
            if ($Hn){$res .= (empty($res) ? "" : " ") .convert_number($Hn) . " Hundred";};
            
            $ones = array("", "One", "Two", "Three", "Four", "Five", "Six","Seven", "Eight", "Nine", 
            "Ten", "Eleven", "Twelve", "Thirteen","Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
            "Nineteen");

            $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");

            $decones = array( '01' => "One", '02' => "Two", '03' => "Three", '04' => "Four", 
                '05' => "Five", '06' => "Six", '07' => "Seven", '08' => "Eight", '09' => "Nine", 
                10 => "Ten", 11 => "Eleven", 12 => "Twelve", 13 => "Thirteen",14 => "Fourteen", 
                15 => "Fifteen", 16 => "Sixteen", 17 => "Seventeen", 18 => "Eighteen", 19 => "Nineteen" 
            );
            
            if ($Dn || $n)
            {
                if (!empty($res)){$res .= " and ";};
                if ($Dn < 2)
                {$res .= $ones[$Dn * 10 + $n];}
                else{$res .= $tens[$Dn];if ($n){$res .= "-" . $ones[$n];};};
            };
            
            if (empty($res)){$res = "zero";};
        
            return $res;
        }

        function convert_decimals($decnum)
        {
            $ones = array("", "One", "Two", "Three", "Four", "Five", "Six","Seven", "Eight", "Nine", 
            "Ten", "Eleven", "Twelve", "Thirteen","Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
            "Nineteen");

            $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");

            $decones = array( '01' => "One", '02' => "Two", '03' => "Three", '04' => "Four", 
                '05' => "Five", '06' => "Six", '07' => "Seven", '08' => "Eight", '09' => "Nine", 
                10 => "Ten", 11 => "Eleven", 12 => "Twelve", 13 => "Thirteen",14 => "Fourteen", 
                15 => "Fifteen", 16 => "Sixteen", 17 => "Seventeen", 18 => "Eighteen", 19 => "Nineteen" 
            );
            $deci = "";
            if($decnum > 0)
            {
                if($decnum < 20)
                { 
                    $deci .= $decones[$decnum]; 
                }
                elseif($decnum < 100)
                { 
                    $deci .= $tens[substr($decnum,0,1)]; 
                    $deci .= "-".$ones[substr($decnum,1,1)]; 
                };
            };
            return $deci; 
        }
        $number_output = convert_number($number);
        $decimal_output = convert_decimals($decnum);
        if($decnum > 0)
        {
            $result = $number_output.' '.$currency.' '.$decimal_output.' '.$decimals;
        }
        else
        {
            $result = $number_output.' '.$currency;
        };
        return $result;
    }

    $image = $_SERVER['DOCUMENT_ROOT'] .'/img/logo.png';

    class PDF extends FPDF
    {
        function Header()
        {
            //Put the watermark
            //$image = $_SERVER['DOCUMENT_ROOT'] .'/img/aflia watermark.png';
            //$this->Image($image,55,110,100,95);
        }
        function Footer()
        {
            // Go to 1.5 cm from bottom
            $this->SetY(-20);
            // Select Arial italic 8
            
            /*$sign = $_SERVER['DOCUMENT_ROOT'] .'/img/ac_sign.png';
            $this->Image($sign,80,250,50,30);*/
            global $con;
            $user_id = $_SESSION['user_id'];
            $sql_users = "SELECT * FROM users WHERE id = '$user_id'";
            $result_users = mysqli_query($con,$sql_users);
            if(!empty($result_users) && mysqli_num_rows($result_users) > 0)
            {
                $row_users = mysqli_fetch_array($result_users);
                $user_name = $row_users['first_name'].' '.$row_users['last_name'];
            }
            else 
            {
                $user_name = 'No User';
            };
            $this->SetFont('Arial','I',8);
            $this->Cell(137,5,'..............................................................',0,0,'C');
            $this->Cell(137,5,'..............................................................',0,1,'C');
            
            $this->Cell(137,5,'Prepared By',0,0,'C');
            $this->Cell(137,5,'Approved By',0,1,'C');
            $this->Cell(273,5,'Printed by: '.$user_name.' on '.date('Y-m-d h:m:sa'),0,1,'C');
        }
    }
    
	date_default_timezone_set("Africa/Accra");

    $pdf = new PDF('L','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    $pdf->Image($image,10,10,15,15);
    
    if(isset($_SESSION['payroll_paye_pay_sheet_id']))
    {
        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);
    
        $sql_ps = "SELECT * FROM payroll_pay_sheet WHERE pay_sheet_id = '$pay_sheet_id'";
        $result_ps = mysqli_query($con,$sql_ps);
        if(!empty($result_ps) && mysqli_num_rows($result_ps))
        {
            $row_ps = mysqli_fetch_array($result_ps);
            $pay_sheet_date = $row_ps['date'];
        }
        else
        {
            $pay_sheet_date = 'Not Specified';
        };

        if($location != 'ALL')
        {
            $query_loc = "SELECT * FROM branch WHERE branch_id = '$location'";
            $query_run_loc = mysqli_query($con, $query_loc);
            if(!empty($query_run_loc) && mysqli_num_rows($query_run_loc) > 0 )
            {
                $row_loc = mysqli_fetch_array($query_run_loc);
                $pay_sheet_location = $row_loc['branch_name'];
            }
            else
            {
                $pay_sheet_location = 'Not Specified';
            };
        }
        else
        {
            $pay_sheet_location = 'ALL LOCATION';
        };


        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(274,10,$row_company['trading_name'],0,1,'C');
        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(274,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
        $pdf->Cell(274,5,$row_company['telephone'],0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(274,5,'',0,1,'C');
        $pdf->Cell(274,5,'P.A.Y.E. Report',0,1,'C');
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(274,5,'FOR '.$pay_sheet_location.' AS AT '.$pay_sheet_date,0,1,'C');
        $pdf->Cell(274,5,'',0,1,'C');

        $pdf->Cell(274,5,'GRA File No:'.$row_company['gra_file_no'],0,1,'R');
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(10,5,'S/No',1,0,'C');
        $pdf->Cell(69,5,'Employee',1,0,'C');
        $pdf->Cell(20,5,'Ghanacard',1,0,'C');
        $pdf->Cell(20,5,'Basic Salary',1,0,'C');
        $pdf->Cell(15,5,'Fuel All.',1,0,'C');
        $pdf->Cell(15,5,'Clothing All.',1,0,'C');
        $pdf->Cell(15,5,'Other All.',1,0,'C');
        $pdf->Cell(15,5,'Normal Day',1,0,'C');
        $pdf->Cell(15,5,'Day 6 and 7',1,0,'C');
        $pdf->Cell(15,5,'Holiday',1,0,'C');
        $pdf->Cell(15,5,'Total Earnings',1,0,'C');
        $pdf->Cell(15,5,'PF',1,0,'C');
        $pdf->Cell(15,5,'SSF',1,0,'C');
        $pdf->Cell(20,5,'P.A.Y.E.',1,1,'C');
        
        $employee_id = 0;
        $basic_salary = 0;
        $fuel_allowance = 0;
        $clothing_allowance = 0;
        $other_allowance = 0;
        $normal_overtime = 0;
        $holiday_overtime = 0;
        $day_67_overtime = 0;
        $welfare = 0;
        $ssf_amount = 0;
        $tax = 0;

        $total_emolument = 0;
        $sum_basic_salary = 0;
        $sum_fuel_allowance = 0;
        $sum_clothing_allowance = 0;
        $sum_other_allowance = 0;
        $sum_normal_overtime = 0;
        $sum_holiday_overtime = 0;
        $sum_day_67_overtime = 0;
        $sum_total_emolument = 0;
        $sum_welfare = 0;
        $sum_ssf_amount = 0;
        $sum_tax = 0;
        if($location == 'ALL')
        {
            $query_location = "SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name ASC";
        }
        else
        {
            $query_location = "SELECT * FROM branch WHERE branch_id = '$location'";
        };
        $query_run_location = mysqli_query($con, $query_location);
        if(!empty($query_run_location) && mysqli_num_rows($query_run_location) > 0 )
        {
            $i=0;
            while($row_location = mysqli_fetch_array($query_run_location))
            {
                $location = $row_location['branch_id'];

                $query_pay_slip = "SELECT * FROM payroll_pay_slip WHERE pay_sheet_id = '$pay_sheet_id' AND location = '$location'";
                $query_run_pay_slip = mysqli_query($con, $query_pay_slip);
                if(!empty($query_run_pay_slip) && mysqli_num_rows($query_run_pay_slip) > 0 )
                {
                    $subt_basic_salary = 0;
                    $subt_fuel_allowance = 0;
                    $subt_clothing_allowance = 0;
                    $subt_other_allowance = 0;
                    $subt_normal_overtime = 0;
                    $subt_holiday_overtime = 0;
                    $subt_day_67_overtime = 0;
                    $subt_total_emolument = 0;
                    $subt_welfare = 0;
                    $subt_ssf_amount = 0;
                    $subt_tax = 0;

                    $pdf->SetFont('Arial','B',7);
                    $pdf->Cell(274,5,$row_location['branch_name'],1,1);
                    while($row_pay_slip = mysqli_fetch_array($query_run_pay_slip))
                    {
                        $i++;
                        $employee_id = $row_pay_slip['employee_id'];
                        $basic_salary = $row_pay_slip['basic_salary'];
                        $fuel_allowance = $row_pay_slip['fuel_allowance'];
                        $clothing_allowance = $row_pay_slip['clothing_allowance'];
                        $other_allowance = $row_pay_slip['other_allowance'];
                        $normal_overtime = $row_pay_slip['normal_overtime'];
                        $holiday_overtime = $row_pay_slip['holiday_overtime'];
                        $day_67_overtime = $row_pay_slip['day_67_overtime'];
                        $welfare = $row_pay_slip['welfare'];
                        $ssf_amount = $row_pay_slip['ssf_amount'];
                        $tax = $row_pay_slip['tax'];
                        $total_emolument = $basic_salary + $fuel_allowance + $clothing_allowance +
                        $other_allowance + $normal_overtime + $holiday_overtime + $day_67_overtime;
                        
                        $subt_basic_salary = $subt_basic_salary + $row_pay_slip['basic_salary'];
                        $subt_fuel_allowance = $subt_fuel_allowance + $row_pay_slip['fuel_allowance'];
                        $subt_clothing_allowance = $subt_clothing_allowance + $row_pay_slip['clothing_allowance'];
                        $subt_other_allowance = $subt_other_allowance + $row_pay_slip['other_allowance'];
                        $subt_normal_overtime = $subt_normal_overtime + $row_pay_slip['normal_overtime'];
                        $subt_holiday_overtime = $subt_holiday_overtime + $row_pay_slip['holiday_overtime'];
                        $subt_day_67_overtime = $subt_day_67_overtime + $row_pay_slip['day_67_overtime'];
                        $subt_total_emolument = $subt_basic_salary + $subt_fuel_allowance + $subt_clothing_allowance + 
                        $subt_other_allowance + $subt_normal_overtime + $subt_holiday_overtime + $subt_day_67_overtime;
                        $subt_welfare = $subt_welfare + $row_pay_slip['welfare'];
                        $subt_ssf_amount = $subt_ssf_amount + $row_pay_slip['ssf_amount'];
                        $subt_tax = $subt_tax + $row_pay_slip['tax'];

                        $sum_basic_salary = $sum_basic_salary + $row_pay_slip['basic_salary'];
                        $sum_fuel_allowance = $sum_fuel_allowance + $row_pay_slip['fuel_allowance'];
                        $sum_clothing_allowance = $sum_clothing_allowance + $row_pay_slip['clothing_allowance'];
                        $sum_other_allowance = $sum_other_allowance + $row_pay_slip['other_allowance'];
                        $sum_normal_overtime = $sum_normal_overtime + $row_pay_slip['normal_overtime'];
                        $sum_holiday_overtime = $sum_holiday_overtime + $row_pay_slip['holiday_overtime'];
                        $sum_day_67_overtime = $sum_day_67_overtime + $row_pay_slip['day_67_overtime'];
                        $sum_total_emolument = $sum_total_emolument + $basic_salary + $fuel_allowance + $clothing_allowance + 
                        $other_allowance + $normal_overtime + $holiday_overtime + $day_67_overtime;
                        $sum_welfare = $sum_welfare + $row_pay_slip['welfare'];
                        $sum_ssf_amount = $sum_ssf_amount + $row_pay_slip['ssf_amount'];
                        $sum_tax = $sum_tax + $row_pay_slip['tax'];

                        $f_basic_salary = number_format($basic_salary, 2, '.', ',');
                        $f_fuel_allowance = number_format($fuel_allowance, 2, '.', ',');
                        $f_clothing_allowance = number_format($clothing_allowance, 2, '.', ',');
                        $f_other_allowance = number_format($other_allowance, 2, '.', ',');
                        $f_normal_overtime = number_format($normal_overtime, 2, '.', ',');
                        $f_holiday_overtime = number_format($holiday_overtime, 2, '.', ',');
                        $f_day_67_overtime = number_format($day_67_overtime, 2, '.', ',');
                        $f_total_emolument = number_format($total_emolument, 2, '.', ',');
                        $f_welfare = number_format($welfare, 2, '.', ',');
                        $f_ssf_amount = number_format($ssf_amount, 2, '.', ',');
                        $f_tax = number_format($tax, 2, '.', ',');
                        
                        $sql_employee="SELECT * FROM payroll_employee WHERE employee_id = '$employee_id'";
                        $result_employee = mysqli_query($con, $sql_employee);
                        if(!empty($result_employee) && mysqli_num_rows($result_employee) > 0 )
                        {
                            $row_employee = mysqli_fetch_array($result_employee);
                            $employee_name = $row_employee['first_name'].' '.$row_employee['last_name'];
                            $ssnit_number = $row_employee['ssnit_number'];
                            $ghanacard = $row_employee['ghanacard'];
                        }
                        else
                        {
                            $employee_name = 'N/A';
                            $ssnit_number = 'N/A';
                            $ghanacard = 'N/A';
                        };
                        $pdf->SetFont('Arial','I',6);
                        $pdf->Cell(10,5,$i,1,0,'C');
                        $pdf->Cell(84,5,$employee_name,1,0);
                        $pdf->Cell(20,5,$ghanacard,1,0,'C');
                        $pdf->Cell(20,5,$f_basic_salary,1,0,'R');
                        $pdf->Cell(15,5,$f_fuel_allowance,1,0,'R');
                        $pdf->Cell(15,5,$f_clothing_allowance,1,0,'R');
                        $pdf->Cell(15,5,$f_other_allowance,1,0,'R');
                        $pdf->Cell(15,5,$f_normal_overtime,1,0,'R');
                        $pdf->Cell(15,5,$f_day_67_overtime,1,0,'R');
                        $pdf->Cell(15,5,$f_holiday_overtime,1,0,'R');
                        $pdf->Cell(15,5,$f_total_emolument,1,0,'R');
                        $pdf->Cell(15,5,$f_ssf_amount,1,0,'R');
                        $pdf->Cell(20,5,$f_tax,1,1,'R');
                    };
                    $f_subt_basic_salary = number_format($subt_basic_salary, 2, '.', ',');
                    $f_subt_fuel_allowance = number_format($subt_fuel_allowance, 2, '.', ',');
                    $f_subt_clothing_allowance = number_format($subt_clothing_allowance, 2, '.', ',');
                    $f_subt_other_allowance = number_format($subt_other_allowance, 2, '.', ',');
                    $f_subt_normal_overtime = number_format($subt_normal_overtime, 2, '.', ',');
                    $f_subt_holiday_overtime = number_format($subt_holiday_overtime, 2, '.', ',');
                    $f_subt_day_67_overtime = number_format($subt_day_67_overtime, 2, '.', ',');
                    $f_subt_total_emolument = number_format($subt_total_emolument, 2, '.', ',');
                    $f_subt_welfare = number_format($subt_welfare, 2, '.', ',');
                    $f_subt_ssf_amount = number_format($subt_ssf_amount, 2, '.', ',');
                    $f_subt_tax = number_format($subt_tax, 2, '.', ',');
                    
                    $pdf->SetFont('Arial','BI',6);
                    $pdf->Cell(114,5,'TOTAL',1,0);
                    $pdf->Cell(20,5,$f_subt_basic_salary,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_fuel_allowance,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_clothing_allowance,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_other_allowance,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_normal_overtime,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_day_67_overtime,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_holiday_overtime,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_total_emolument,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_ssf_amount,1,0,'R');
                    $pdf->Cell(20,5,$f_subt_tax,1,1,'R');
                };
            };
            $f_sum_basic_salary = number_format($sum_basic_salary, 2, '.', ',');
            $f_sum_fuel_allowance = number_format($sum_fuel_allowance, 2, '.', ',');
            $f_sum_clothing_allowance = number_format($sum_clothing_allowance, 2, '.', ',');
            $f_sum_other_allowance = number_format($sum_other_allowance, 2, '.', ',');
            $f_sum_normal_overtime = number_format($sum_normal_overtime, 2, '.', ',');
            $f_sum_holiday_overtime = number_format($sum_holiday_overtime, 2, '.', ',');
            $f_sum_day_67_overtime = number_format($sum_day_67_overtime, 2, '.', ',');
            $f_sum_total_emolument = number_format($sum_total_emolument, 2, '.', ',');
            $f_sum_welfare = number_format($sum_welfare, 2, '.', ',');
            $f_sum_ssf_amount = number_format($sum_ssf_amount, 2, '.', ',');
            $f_sum_tax = number_format($sum_tax, 2, '.', ',');
            
            $pdf->SetFont('Arial','BI',6);
            $pdf->Cell(114,5,'GRAND TOTAL',1,0);
            $pdf->Cell(20,5,$f_sum_basic_salary,1,0,'R');
            $pdf->Cell(15,5,$f_sum_fuel_allowance,1,0,'R');
            $pdf->Cell(15,5,$f_sum_clothing_allowance,1,0,'R');
            $pdf->Cell(15,5,$f_sum_other_allowance,1,0,'R');
            $pdf->Cell(15,5,$f_sum_normal_overtime,1,0,'R');
            $pdf->Cell(15,5,$f_sum_day_67_overtime,1,0,'R');
            $pdf->Cell(15,5,$f_sum_holiday_overtime,1,0,'R');
            $pdf->Cell(15,5,$f_sum_total_emolument,1,0,'R');
            $pdf->Cell(15,5,$f_sum_ssf_amount,1,0,'R');
            $pdf->Cell(20,5,$f_sum_tax,1,1,'R');
            
            $amount_in_words = amount_in_words($sum_tax);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(274,10,'Amount in words:',0,1);
            $pdf->SetFont('Arial','I',10);
            $pdf->SetLineWidth(0.1);
            $pdf->MultiCell(274,5,$amount_in_words,'B','L',false);
        }
        else
        {
            $pdf->Cell(274,10,'No Pay Slip for the selected location',0,1,'C');
        };
        $pdf->Output();
    };
?>