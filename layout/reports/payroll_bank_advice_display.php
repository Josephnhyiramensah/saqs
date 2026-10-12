<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    
    $company_id = $_SESSION['company_id'];
    $pay_sheet_id = $_SESSION['payroll_bank_advice_pay_sheet_id'];
    $location = $_SESSION['payroll_bank_advice_location'];
    $bank = $_SESSION['bank_advice_bank'];

    function amount_in_words($amount)
    {
        global $con;
        $pay_sheet_id = $_SESSION['payroll_bank_advice_pay_sheet_id'];
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

        $amount = round($amount,2);
        //$amount = number_format($amount,2,".",","); 
        $num_arr = explode(".",$amount);
        $number = $num_arr[0];
        if(isset($num_arr[1]))
        {
            $decimals_number = number_format($num_arr[1], 2);
            $decnum = substr($decimals_number,0,2);
            //$decnum = $num_arr[1];
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
                    $deci .= $decnum;
                    //$deci .= $decones[$decnum];
                }
                elseif($decnum < 100)
                { 
                    $deci .= $tens[substr($decnum,0,1)]; 
                    $deci .= "-".$ones[substr($decnum,1,1)]; 
                };
            };
            return $deci; 
            //return $decnum; 
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
            
            $this->Cell(189,5,'Printed by: '.$user_name.' on '.date('Y-m-d h:m:sa'),0,1,'C');
        }
    }
	date_default_timezone_set("Africa/Accra");

    $pdf = new PDF('P','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    $pdf->Image($image,10,10,15,15);
    
    if(isset($_SESSION['payroll_bank_advice_pay_sheet_id']))
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

        $month = date('F', strtotime($pay_sheet_date));
        $year = date('Y', strtotime($pay_sheet_date));

        //LOCATION
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
            
        //BANK
            if($bank != 'ALL')
            {
                $query_loc = "SELECT * FROM ledgers WHERE ledger_id = '$bank'";
                $query_run_loc = mysqli_query($con, $query_loc);
                if(!empty($query_run_loc) && mysqli_num_rows($query_run_loc) > 0 )
                {
                    $row_loc = mysqli_fetch_array($query_run_loc);
                    $pay_sheet_bank = $row_loc['ledger_desc'];
                    $pay_sheet_account = $row_loc['telephone'];
                }
                else
                {
                    $pay_sheet_bank = 'Not Specified';
                    $pay_sheet_account = 'Not Specified';
                };
            }
            else
            {
                $pay_sheet_bank = 'ALL BANKS';
                $pay_sheet_account = 'Not Specified';
            };


        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(189,10,$row_company['trading_name'],0,1,'C');
        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(189,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
        $pdf->Cell(189,5,$row_company['telephone'],0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(189,5,'',0,1,'C');
        $pdf->Cell(189,5,'Bank Advice',0,1,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(189,5,'FOR '.$pay_sheet_location.' FOR THE MONTH OF '.$month.' '.$year,0,1,'C');
        $pdf->Cell(189,5,'The Manager',0,1);
        $pdf->Cell(189,5,'Bank: '.$pay_sheet_bank,0,1);
        //$pdf->Cell(189,5,'Account No: '.$pay_sheet_account,0,1);
        $pdf->Cell(189,5,'',0,1,'C');

        //$pdf->Cell(274,5,'Debit Account No:'.$row_company['ssnit_file_no'],0,1,'R');
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(10,5,'NO',1,0,'C');
        $pdf->Cell(50,5,'NAME',1,0,'C');
        $pdf->Cell(45,5,'BANK BRANCH',1,0,'C');
        $pdf->Cell(35,5,'BANK',1,0,'C');
        $pdf->Cell(25,5,'ACCOUNT NO',1,0,'C');
        $pdf->Cell(24,5,'AMOUNT',1,1,'C');
        
        $employee_id = 0;
        $basic_salary = 0;
        $ssf_1st_tier = 0;
        $sum_basic_salary = 0;
        $sum_ssf_1st_tier = 0;
        /*if($location == 'ALL')
        {
            $query_location = "SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name ASC";
        }
        else
        {
            $query_location = "SELECT * FROM branch WHERE branch_id = '$location'";
        };
        $query_run_location = mysqli_query($con, $query_location);
        if(!empty($query_run_location) && mysqli_num_rows($query_run_location) > 0 )
        {*/
            $i=0;
            //while($row_location = mysqli_fetch_array($query_run_location))
            //{
                //$location = $row_location['branch_id'];

                $subt_net_salary = 0;
                $sum_net_salary = 0;
                if($location != 'ALL')
                {
                    if($bank != 'ALL')
                    {
                        $query_pay_slip = "SELECT * FROM payroll_pay_slip WHERE pay_sheet_id = '$pay_sheet_id' AND 
                        location ='$location' AND bank ='$bank' ORDER BY bank ASC";
                    }
                    else
                    {
                        $query_pay_slip = "SELECT * FROM payroll_pay_slip WHERE pay_sheet_id = '$pay_sheet_id' AND 
                        location ='$location' ORDER BY bank ASC";
                    };
                }
                else
                {
                    if($bank != 'ALL')
                    {
                        $query_pay_slip = "SELECT * FROM payroll_pay_slip WHERE pay_sheet_id = '$pay_sheet_id' AND 
                        bank ='$bank' ORDER BY bank ASC";
                    }
                    else
                    {
                        $query_pay_slip = "SELECT * FROM payroll_pay_slip WHERE pay_sheet_id = '$pay_sheet_id' 
                        ORDER BY bank ASC";
                    };
                };

                $query_run_pay_slip = mysqli_query($con, $query_pay_slip);
                if(!empty($query_run_pay_slip) && mysqli_num_rows($query_run_pay_slip) > 0 )
                {

                    //$pdf->SetFont('Arial','B',8);
                    //$pdf->Cell(274,5,$row_location['branch_name'],1,1);
                    while($row_pay_slip = mysqli_fetch_array($query_run_pay_slip))
                    {
                        $i++;
                        $employee_id = $row_pay_slip['employee_id'];
                        $bank_id = $row_pay_slip['bank'];
                        $basic_salary = $row_pay_slip['basic_salary'];
                        $fuel_allowance = $row_pay_slip['fuel_allowance'];
                        $clothing_allowance = $row_pay_slip['clothing_allowance'];
                        $salary_arrears = $row_pay_slip['salary_arrears'];
                        $other_allowance = $row_pay_slip['other_allowance'];
                        $normal_overtime = $row_pay_slip['normal_overtime'];
                        $holiday = $row_pay_slip['holiday'];
                        $day_67 = $row_pay_slip['day_67'];
                        $welfare = $row_pay_slip['welfare'];
                        $other_deductions = $row_pay_slip['other_deductions'];
                        $ssf_amount = $row_pay_slip['ssf_amount'];
                        $tax = $row_pay_slip['tax'];
                        $salary_advance = $row_pay_slip['salary_advance'];
                        $loan_repayment = $row_pay_slip['loan_repayment'];
                        $absent = $row_pay_slip['absent'];
                        $bonus = $row_pay_slip['bonus'];
                        $salary_arrears = $row_pay_slip['salary_arrears'];
                        $paid_leave = $row_pay_slip['paid_leave'];
                        
                        $total_allowance = $fuel_allowance + $clothing_allowance + $other_allowance +
                            $normal_overtime + $holiday + $day_67 + $bonus + $paid_leave + $salary_arrears;
                        $total_overtime = $normal_overtime + $holiday + $day_67;
                        $total_emolument = $basic_salary + $total_allowance;
                        $total_deductions = $welfare + $other_deductions + $ssf_amount + $tax + $loan_repayment + $salary_advance + $absent;
                        $net_salary = $total_emolument - $total_deductions;
                        
                        $subt_net_salary = $subt_net_salary + $net_salary;
                        $sum_net_salary = $sum_net_salary + $net_salary;

                        $f_net_salary = number_format($net_salary, 2, '.', ',');
                        
                        $sql_employee="SELECT * FROM payroll_employee WHERE employee_id = '$employee_id'";
                        $result_employee = mysqli_query($con, $sql_employee);
                        if(!empty($result_employee) && mysqli_num_rows($result_employee) > 0 )
                        {
                            $row_employee = mysqli_fetch_array($result_employee);
                            $employee_name = $row_employee['first_name'].' '.$row_employee['last_name'];
                            $phone_no = $row_employee['phone_no'];
                            if($row_employee['bank_branch'] !='')
                            {
                                $bank_branch = $row_employee['bank_branch'];
                            }
                            else
                            {
                                $bank_branch = '';
                            };
                        }
                        else
                        {
                            $employee_name = 'N/A';
                            $staff_id = 'N/A';
                            $bank_branch = '';
                            $phone_no = 'N/A';
                        };
                        
                        $sql_bank="SELECT * FROM ledgers WHERE ledger_id = '$bank_id'";
                        $result_bank = mysqli_query($con, $sql_bank);
                        if(!empty($result_bank) && mysqli_num_rows($result_bank) > 0 )
                        {
                            $row_bank = mysqli_fetch_array($result_bank);
                            $bank_name = $row_bank['ledger_desc'];
                        }
                        else
                        {
                            $bank_name = 'N/A';
                        };
                        $pdf->SetFont('Arial','I',8);
                        $pdf->Cell(10,5,$i,1,0,'C');
                        $pdf->Cell(50,5,$employee_name,1,0);
                        $pdf->Cell(45,5,$row_pay_slip['bank_branch'],1,0);
                        $pdf->Cell(35,5,$bank_name,1,0);
                        $pdf->Cell(25,5,$row_pay_slip['account_number'],1,0,'C');
                        $pdf->Cell(24,5,$f_net_salary,1,1,'R');
                    };
                    $f_subt_net_salary = number_format($subt_net_salary, 2, '.', ',');
                    
                    /*$pdf->SetFont('Arial','BI',8);
                    $pdf->Cell(249,5,'TOTAL',1,0);
                    $pdf->Cell(25,5,$f_subt_net_salary,1,1,'R');*/
                };
            //};
            $f_sum_net_salary = number_format($sum_net_salary, 2, '.', ',');
            
            $pdf->SetFont('Arial','BI',9);
            $pdf->Cell(165,5,'GRAND TOTAL',1,0);
            $pdf->Cell(24,5,$f_sum_net_salary,1,1,'R');
            
            $amount_in_words = amount_in_words($sum_net_salary);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(189,10,'Amount in words:',0,1);
            $pdf->SetFont('Arial','I',9);
            $pdf->SetLineWidth(0.1);
            $pdf->MultiCell(189,5,$amount_in_words,'B','L',false);

            $pdf->SetFont('Arial','I',8);
            $pdf->Cell(189,15,'',0,1);
            $pdf->Cell(140,5,'',0,0,'C');
            $pdf->Cell(49,5,'..............................................................',0,1,'C');
            
            $pdf->Cell(140,5,'',0,0,'C');
            $pdf->Cell(49,5,'Prepared By',0,1,'C');
        /*}
        else
        {
            $pdf->Cell(274,10,'No Pay Slip for the selected location',0,1,'C');
        };*/
        $pdf->Output();
    };