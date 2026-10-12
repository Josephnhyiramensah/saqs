<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    
    $company_id = $_SESSION['company_id'];
    $pay_sheet_id = $_SESSION['payroll_2nd_tier_pay_sheet_id'];
    $location = $_SESSION['payroll_2nd_tier_location'];

    function amount_in_words($amount)
    {
        global $con;
        $pay_sheet_id = $_SESSION['payroll_2nd_tier_pay_sheet_id'];
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
    
    if(isset($_SESSION['payroll_2nd_tier_pay_sheet_id']))
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
            $start_date = $row_ps['date_from'];
            $end_date = $row_ps['date_to'];
        }
        else
        {
            $pay_sheet_date = 'Not Specified';
            $start_date = '';
            $end_date = '';
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
        $pdf->Cell(274,5,'Social Security 2nd Tier Report',0,1,'C');
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(274,5,'FOR '.$pay_sheet_location.' AS AT '.$pay_sheet_date,0,1,'C');
        $pdf->Cell(274,5,'',0,1,'C');

        $pdf->Cell(274,5,'SSNIT File No:'.$row_company['ssnit_file_no'],0,1,'R');
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(20,5,'S/No',1,0,'C');
        $pdf->Cell(45,5,'First Name',1,0,'C');
        $pdf->Cell(45,5,'Last Name',1,0,'C');
        $pdf->Cell(40,5,'SSF No',1,0,'C');
        $pdf->Cell(40,5,'Ghanacard',1,0,'C');
        $pdf->Cell(40,5,'Basic Salary',1,0,'C');
        $pdf->Cell(44,5,'2nd Tier (5%)',1,1,'C');
        
        $employee_id = 0;
        $basic_salary = 0;
        $ssf_2nd_tier = 0;
        $sum_basic_salary = 0;
        $sum_ssf_2nd_tier = 0;
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
                $location_id = $row_location['branch_id'];

                $query_pay_slip = "SELECT * FROM payroll_pay_slip WHERE pay_sheet_id = '$pay_sheet_id' AND location = '$location_id'";
                $query_run_pay_slip = mysqli_query($con, $query_pay_slip);
                if(!empty($query_run_pay_slip) && mysqli_num_rows($query_run_pay_slip) > 0 )
                {
                    $subt_basic_salary = 0;
                    $subt_ssf_2nd_tier = 0;

                    $pdf->SetFont('Arial','B',8);
                    $pdf->Cell(274,5,$row_location['branch_name'],1,1);
                    while($row_pay_slip = mysqli_fetch_array($query_run_pay_slip))
                    {
                        $i++;
                        $employee_id = $row_pay_slip['employee_id'];
                        $basic_salary = $row_pay_slip['basic_salary'];
                        $ssf_2nd_tier = $row_pay_slip['ssf_2nd_tier'];
                        if($ssf_2nd_tier > 0)
                        {
                            $subt_basic_salary = $subt_basic_salary + $row_pay_slip['basic_salary'];
                            $subt_ssf_2nd_tier = $subt_ssf_2nd_tier + $row_pay_slip['ssf_2nd_tier'];

                            $sum_basic_salary = $sum_basic_salary + $row_pay_slip['basic_salary'];
                            $sum_ssf_2nd_tier = $sum_ssf_2nd_tier + $row_pay_slip['ssf_2nd_tier'];

                            $f_basic_salary = number_format($basic_salary, 2, '.', ',');
                            $f_ssf_2nd_tier = number_format($ssf_2nd_tier, 2, '.', ',');
                            
                            $sql_employee="SELECT * FROM payroll_employee WHERE employee_id = '$employee_id'";
                            $result_employee = mysqli_query($con, $sql_employee);
                            if(!empty($result_employee) && mysqli_num_rows($result_employee) > 0 )
                            {
                                $row_employee = mysqli_fetch_array($result_employee);
                                $first_name = $row_employee['first_name'];
                                $last_name = $row_employee['last_name'];
                                $employee_name = $row_employee['first_name'].' '.$row_employee['last_name'];
                                $ssnit_number = $row_employee['ssnit_number'];
                                $ghanacard = $row_employee['ghanacard'];
                                $date_join = $row_employee['date_join'];
                            }
                            else
                            {
                                $first_name = 'N/A';
                                $last_name = 'N/A';
                                $employee_name = 'N/A';
                                $ssnit_number = 'N/A';
                                $ghanacard = 'N/A';
                                $date_join = '';
                            };

                            $pdf->SetFont('Arial','I',8);
                            $pdf->SetFillColor(250,205,205);
                            if($date_join >= $start_date && $date_join <= $end_date)
                            {
                                $pdf->Cell(20,5,$i,1,0,'C',1);
                                $pdf->Cell(45,5,$first_name,1,0,'L',1);
                                $pdf->Cell(45,5,$last_name,1,0,'L',1);
                                $pdf->Cell(40,5,$ssnit_number,1,0,'C',1);
                                $pdf->Cell(40,5,$ghanacard,1,0,'C',1);
                                $pdf->Cell(40,5,$f_basic_salary,1,0,'R',1);
                                $pdf->Cell(44,5,$f_ssf_2nd_tier,1,1,'R',1);
                            }
                            else
                            {
                                $pdf->Cell(20,5,$i,1,0,'C');
                                $pdf->Cell(45,5,$first_name,1,0);
                                $pdf->Cell(45,5,$last_name,1,0);
                                $pdf->Cell(40,5,$ssnit_number,1,0,'C');
                                $pdf->Cell(40,5,$ghanacard,1,0,'C');
                                $pdf->Cell(40,5,$f_basic_salary,1,0,'R');
                                $pdf->Cell(44,5,$f_ssf_2nd_tier,1,1,'R');
                            };
                        };
                    };
                    $f_subt_basic_salary = number_format($subt_basic_salary, 2, '.', ',');
                    $f_subt_ssf_2nd_tier = number_format($subt_ssf_2nd_tier, 2, '.', ',');
                    
                    $pdf->SetFont('Arial','BI',8);
                    $pdf->Cell(190,5,'TOTAL',1,0);
                    $pdf->Cell(40,5,$f_subt_basic_salary,1,0,'R');
                    $pdf->Cell(44,5,$f_subt_ssf_2nd_tier,1,1,'R');
                };
            };
            $f_sum_basic_salary = number_format($sum_basic_salary, 2, '.', ',');
            $f_sum_ssf_2nd_tier = number_format($sum_ssf_2nd_tier, 2, '.', ',');
            
            $pdf->SetFont('Arial','BI',9);
            $pdf->Cell(190,5,'GRAND TOTAL',1,0);
            $pdf->Cell(40,5,$f_sum_basic_salary,1,0,'R');
            $pdf->Cell(44,5,$f_sum_ssf_2nd_tier,1,1,'R');
            
            $amount_in_words = amount_in_words($sum_ssf_2nd_tier);
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