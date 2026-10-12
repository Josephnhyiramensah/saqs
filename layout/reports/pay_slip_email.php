<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    require_once($_SERVER['DOCUMENT_ROOT'] .'/vendor/autoload.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf.php');
    
    use Google\Client;
    use Google\Service\Gmail;
    
    function getClient()
    {
        $client = new Client();
        $client->setApplicationName('Ramoth Testing');
        $client->setScopes('https://www.googleapis.com/auth/gmail.modify');
        $client->setAuthConfig($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/client_secrets.json');
        //$client->setAuthConfig('client_secrets.json');
        $client->setAccessType('offline');
        $client->setPrompt('consent');
    
        $tokenPath = 'token.json';
        if(file_exists($tokenPath))
        {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        };
    
        if($client->isAccessTokenExpired())
        {
            if($client->getRefreshToken())
            {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            }
            else
            {
                if(isset($_GET['code']))
                {
                    @$authCode = trim($_GET['code']);
                }
                else
                {
                    $authUrl = $client->createAuthUrl();
                    header("Location:".$authUrl);
                };
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);
            };
            if(!file_exists(dirname($tokenPath)))
            {
                mkdir(dirname($tokenPath), 0700, true);
            };
            @file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        };
        return $client;
    }

    $image = $_SERVER['DOCUMENT_ROOT'] .'/img/logo.png';
    $sign = $_SERVER['DOCUMENT_ROOT'] .'/img/sign.jpg';
    $stamp = $_SERVER['DOCUMENT_ROOT'] .'/img/stamp.jpg';

    class PDF extends FPDF
    {
        function Header()
        {
            //Put the watermark
        }
        function Footer()
        {
            // Go to 1.5 cm from bottom
            $this->SetY(-15);
            // Select Arial italic 8
            
        }
    }
    date_default_timezone_set("Africa/Accra");

    if(isset($_SESSION['pay_slip_report_sending_type']))
    {
        $company_id = $_SESSION['company_id'];
        $type = $_SESSION['pay_slip_report_sending_type'];
        $employee = $_SESSION['pay_slip_report_sending_employee'];
        $branch = $_SESSION['pay_slip_report_sending_branch'];
        $start_date = $_SESSION['pay_slip_report_sending_start_date'];
        $end_date = $_SESSION['pay_slip_report_sending_end_date'];

        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);

        if($type == 'ALL')
        {
            $query_pay_slip = "SELECT * FROM payroll_pay_slip WHERE 
            date BETWEEN '$start_date' AND '$end_date'";
        }
        else if($type == 'EMPLOYEE')
        {
            $query_pay_slip = "SELECT * FROM payroll_pay_slip WHERE employee_id = '$employee' AND 
            date BETWEEN '$start_date' AND '$end_date'";
        }
        else if($type == 'BRANCH')
        {
            $query_pay_slip = "SELECT * FROM payroll_pay_slip WHERE location = '$branch' AND 
            date BETWEEN '$start_date' AND '$end_date'";
        };

        $query_run_pay_slip = mysqli_query($con, $query_pay_slip);
        if(!empty($query_run_pay_slip) && mysqli_num_rows($query_run_pay_slip) > 0 )
        {

            try {
                @$client = getClient();
                @$service = new Gmail($client);
                $message = new Gmail\Message();
                //code...
                //$zip = new ZipArchive;
                //$tmp_file = 'PaySlip.zip';
                //$zip->open($tmp_file, ZipArchive::OVERWRITE|ZipArchive::CREATE);
                $i=0;
                while($row_pay_slip = mysqli_fetch_array($query_run_pay_slip))
                {
                    $pdf = new PDF('P','mm','A4');
                    $pdf->AddPage();
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Image($sign,140,220,30,15);
                    $pdf->Image($stamp,20,230,40,40);
                    $pdf->Image($image,10,10,15,15);

                    $pdf->SetFont('Arial','B',18);
                    $pdf->Cell(189,10,$row_company['trading_name'],0,1,'C');
                    $pdf->SetFont('Arial','I',8);
                    $pdf->Cell(189,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
                    $pdf->Cell(189,5,$row_company['telephone'],0,1,'C');
                    $pdf->SetFont('Arial','B',12);
                    $pdf->Cell(189,5,'',0,1,'C');
                    $pdf->Cell(189,5,'PAY SLIP',0,1,'C');
                    $pdf->Cell(189,5,'',0,1,'C');
                    
                        //EMPLOYEE
                            $employee_id = $row_pay_slip['employee_id'];
                            $query_employee = "SELECT * FROM payroll_employee WHERE employee_id = '$employee_id'";
                            $query_run_employee = mysqli_query($con, $query_employee);
                            if(!empty($query_run_employee) && mysqli_num_rows($query_run_employee) > 0)
                            {
                                $row_employee = mysqli_fetch_assoc($query_run_employee);
                                $employee_name = $row_employee['first_name'].' '.$row_employee['last_name'];
                                $annual_leave = $row_employee['leave_annual'];
                                $sick_leave = $row_employee['leave_sick'];
                                $maternity_leave = $row_employee['leave_maternity'];
                                $bank = $row_employee['bank'];
                                $account_no = $row_employee['account_number'];
                            }
                            else
                            {
                                $employee_name = 'Not Specified';
                                $annual_leave = 0;
                                $sick_leave = 0;
                                $maternity_leave = 0;
                                $bank = 'Not Specified';
                                $account_no = 'Not Specified';
                            };

                        if ($employee_email !='' && filter_var($employee_email, FILTER_VALIDATE_EMAIL)) 
                        {
                            $i++;
                            //SITE
                                $branch_id = $row_pay_slip['location'];
                                $query_branch = "SELECT * FROM branch WHERE branch_id = '$branch_id'";
                                $query_run_branch = mysqli_query($con, $query_branch);
                                if(!empty($query_run_branch) && mysqli_num_rows($query_run_branch) > 0)
                                {
                                    $row_branch = mysqli_fetch_assoc($query_run_branch);
                                    $branch_name = $row_branch['branch_name'];
                                }
                                else
                                {
                                    $branch_name = 'Not Specified';
                                };
                            
                            //DEPARTMENT
                                $dept_id = $row_pay_slip['dept_id'];
                                $query_dept = "SELECT * FROM department WHERE dept_id = '$dept_id'";
                                $query_run_dept = mysqli_query($con, $query_dept);
                                if(!empty($query_run_dept) && mysqli_num_rows($query_run_dept) > 0)
                                {
                                    $row_dept = mysqli_fetch_assoc($query_run_dept);
                                    $dept_name = $row_dept['department'];
                                }
                                else
                                {
                                    $dept_name = 'Not Specified';
                                };
                            
                            //PAYSLIP DETAILS
                                if($row_pay_slip['basic_salary'] != NULL){$basic_salary = $row_pay_slip['basic_salary'];}else{$basic_salary = 0;};
                                if($row_pay_slip['resp_allowance'] != NULL){$resp_allowance = $row_pay_slip['resp_allowance'];}else{$resp_allowance = 0;};
                                if($row_pay_slip['accomm_allowance'] != NULL){$accomm_allowance = $row_pay_slip['accomm_allowance'];}else{$accomm_allowance = 0;};
                                if($row_pay_slip['duty_allowance'] != NULL){$duty_allowance = $row_pay_slip['duty_allowance'];}else{$duty_allowance = 0;};
                                if($row_pay_slip['normal_overtime'] != NULL){$normal_overtime_amount = $row_pay_slip['normal_overtime'];}else{$normal_overtime_amount = 0;};
                                if($row_pay_slip['holiday'] != NULL){$holiday_amount = $row_pay_slip['holiday'];}else{$holiday_amount = 0;};
                                if($row_pay_slip['day_67'] != NULL){$day_67_amount = $row_pay_slip['day_67'];}else{$day_67_amount = 0;};
                                if($row_pay_slip['pf_amount'] != NULL){$pf_amount = $row_pay_slip['pf_amount'];}else{$pf_amount = 0;};
                                if($row_pay_slip['bonus'] != NULL){$bonus = $row_pay_slip['bonus'];}else{$bonus = 0;};
                                if($row_pay_slip['paid_leave'] != NULL){$paid_leave = $row_pay_slip['paid_leave'];}else{$paid_leave = 0;};
                                if($row_pay_slip['tax'] != NULL){$tax = $row_pay_slip['tax'];}else{$tax = 0;};
                                if($row_pay_slip['salary_advance'] != NULL){$salary_advance = $row_pay_slip['salary_advance'];}else{$salary_advance = 0;};
                                if($row_pay_slip['loan_repayment'] != NULL){$loan_repayment = $row_pay_slip['loan_repayment'];}else{$loan_repayment = 0;};
                                if($row_pay_slip['student_loan'] != NULL){$student_loan = $row_pay_slip['student_loan'];}else{$student_loan = 0;};
                                if($row_pay_slip['absent'] != NULL){$absentism = $row_pay_slip['absent'];}else{$absentism = 0;};
                                if($row_pay_slip['top_up'] != NULL){$top_up = $row_pay_slip['top_up'];}else{$top_up = 0;};
                                if($row_pay_slip['salary_arrears'] != NULL){$salary_arrears = $row_pay_slip['salary_arrears'];}else{$salary_arrears = 0;};
                                if($row_pay_slip['tier_1_arrears'] != NULL){$tier_1_arrears = $row_pay_slip['tier_1_arrears'];}else{$tier_1_arrears = 0;};
                                if($row_pay_slip['tier_2_arrears'] != NULL){$tier_2_arrears = $row_pay_slip['tier_2_arrears'];}else{$tier_2_arrears = 0;};
                                if($row_pay_slip['ssf_employee_arrears'] != NULL){$ssf_employee_arrears = $row_pay_slip['ssf_employee_arrears'];}else{$ssf_employee_arrears = 0;};
                                if($row_pay_slip['ssf_employer_arrears'] != NULL){$ssf_employer_arrears = $row_pay_slip['ssf_employer_arrears'];}else{$ssf_employer_arrears = 0;};
                                if($row_pay_slip['ssnit_arrears_type'] != NULL){$ssnit_arrears_type = $row_pay_slip['ssnit_arrears_type'];}else{$ssnit_arrears_type = 0;};
                                if($row_pay_slip['hourly_rate'] != NULL){$hourly_rate = $row_pay_slip['hourly_rate'];}else{$hourly_rate = 0;};
                                if($row_pay_slip['daily_rate'] != NULL){$daily_rate = $row_pay_slip['daily_rate'];}else{$daily_rate = 0;};
                                if($row_pay_slip['pf_employer'] != NULL){$pf_employer = $row_pay_slip['pf_employer'];}else{$pf_employer = 0;};
                                if($row_pay_slip['overtime_rate'] != NULL){$overtime_rate = $row_pay_slip['overtime_rate'];}else{$overtime_rate = 0;};
                                if($row_pay_slip['day_67_rate'] != NULL){$day_67_rate = $row_pay_slip['day_67_rate'];}else{$day_67_rate = 0;};
                                if($row_pay_slip['holiday_rate'] != NULL){$holiday_rate = $row_pay_slip['holiday_rate'];}else{$holiday_rate = 0;};
                                
                                $total_allowance = $resp_allowance + $accomm_allowance + $duty_allowance +
                                $normal_overtime_amount + $holiday_amount + $day_67_amount + $top_up + $bonus + $paid_leave + $salary_arrears;

                                $total_overtime = $normal_overtime_amount + $holiday_amount + $day_67_amount;
                                $total_emolument = $basic_salary + $total_allowance;
                                
                                if($ssnit_arrears_type == 'CURRENT_DEDUCTION')
                                {
                                    if($row_pay_slip['ssf_amount'] != NULL){$ssf_amount = $row_pay_slip['ssf_amount'] + $ssf_employee_arrears;}else{$ssf_amount = 0 + $ssf_employee_arrears;};
                                    $ssf_employer = $row_pay_slip['ssf_employer'] + $ssf_employer_arrears;

                                    $total_deductions = $pf_amount + $ssf_amount + $tax + $loan_repayment + $salary_advance + 
                                    $absentism + $student_loan + $ssf_employee_arrears;
                                }
                                else
                                {
                                    if($row_pay_slip['ssf_amount'] != NULL){$ssf_amount = $row_pay_slip['ssf_amount'];}else{$ssf_amount = 0;};
                                    $ssf_employer = $row_pay_slip['ssf_employer'];

                                    $total_deductions = $pf_amount + $ssf_amount + $tax + $loan_repayment + $salary_advance + 
                                    $absentism + $student_loan;
                                };
                                $net_salary = $total_emolument - $total_deductions;

                                $pay_sheet_id = $row_pay_slip['pay_sheet_id'];
                                $query_pay_sheet = "SELECT * FROM payroll_pay_sheet WHERE pay_sheet_id = '$pay_sheet_id'";
                                $query_run_pay_sheet = mysqli_query($con, $query_pay_sheet);
                                if(!empty($query_run_pay_sheet) && mysqli_num_rows($query_run_pay_sheet) > 0)
                                {
                                    $row_pay_sheet = mysqli_fetch_assoc($query_run_pay_sheet);
                                    $date = $row_pay_sheet['date_to'];
                                    $start = $row_pay_sheet['date_from'];
                                    $end = $row_pay_sheet['date_to'];
                                }
                                else
                                {
                                    $date = $row_pay_slip['date'];
                                    $start = date("Y-m-01", strtotime($date));
                                    $end = date("Y-m-t", strtotime($date));
                                };

                                //$date = $row_pay_slip['date'];
                                $month = date("F",strtotime($date));
                                $year = date("Y",strtotime($date));
                                //$start = date("Y-m-01", strtotime($date));
                                //$end = date("Y-m-t", strtotime($date));
                                $start_date = date('Y-01-01');
                                $end_date = date('Y-12-31');
            
                            //LEAVE
                                $query_leave = "SELECT SUM(leave_annual) AS annual, SUM(leave_sick) AS sick, 
                                SUM(leave_maternity) AS maternity, date, employee_id FROM payroll_leave 
                                WHERE employee_id = '$employee_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                $result_leave = mysqli_query($con,$query_leave);
                                if(!empty($result_leave) && mysqli_num_rows($result_leave) > 0)
                                {
                                    $row_leave = mysqli_fetch_array($result_leave);
                                    $annual_gone = $row_leave['annual'];
                                    $sick_gone = $row_leave['sick'];
                                    $maternity_gone = $row_leave['maternity'];
                                    $annual_leave_bal = $annual_leave - $annual_gone;
                                    $sick_leave_bal = $sick_leave - $sick_gone;
                                    $maternity_leave_bal = $maternity_leave - $maternity_gone;
                
                                }
                                else
                                {
                                    $annual_gone = 0;
                                    $sick_gone = 0;
                                    $maternity_gone = 0;
                                    $annual_leave_bal = $annual_leave - $annual_gone;
                                    $sick_leave_bal = $sick_leave - $sick_gone;
                                    $maternity_leave_bal = $maternity_leave - $maternity_gone;
                
                                };
            
                            //TIME SHEET
                                $query_ts = "SELECT SUM(tsl.normal_overtime) AS overtime, SUM(tsl.day_67) AS day_67, 
                                SUM(tsl.holidays) AS holidays,SUM(tsl.absent) AS absent_days, ts.date, tsl.employee_id 
                                FROM payroll_time_sheet_list tsl JOIN payroll_time_sheet ts ON tsl.time_sheet_id = ts.time_sheet_id 
                                WHERE ts.approved_status = 'Approved' AND tsl.employee_id = '$employee_id' AND ts.date BETWEEN '$start' 
                                AND '$end'";
                                $query_run_ts = mysqli_query($con, $query_ts);
                                if(!empty($query_run_ts) && mysqli_num_rows($query_run_ts) > 0)
                                {
                                    $row_ts = mysqli_fetch_assoc($query_run_ts);
                                    if($row_ts['overtime'] != NULL){$overtime_hrs = $row_ts['overtime'];}else{$overtime_hrs = 0;};
                                    if($row_ts['day_67'] != NULL){$day_67_hrs = $row_ts['day_67'];}else{$day_67_hrs = 0;};
                                    if($row_ts['holidays'] != NULL){$holidays_hrs = $row_ts['holidays'];}else{$holidays_hrs = 0;};
                                    if($row_ts['absent_days'] != NULL){$absent_days = $row_ts['absent_days'];}else{$absent_days = 0;};
                                }
                                else
                                {
                                    $overtime_hrs = 0;
                                    $holidays_hrs = 0;
                                    $day_67_hrs = 0;
                                    $absent_days = 0;
                                };
                            //LOAN
                                $query_ld = "SELECT SUM(principal) AS principal FROM payroll_loan_disburse WHERE employee_id = '$employee_id' 
                                AND date < '$date'";
                                $query_run_ld = mysqli_query($con, $query_ld);
                                if(!empty($query_run_ld) && mysqli_num_rows($query_run_ld) > 0 )
                                {
                                    $row_ld = mysqli_fetch_array($query_run_ld);
                                    if($row_ld['principal'] != NULL){$principal = $row_ld['principal'];}else{$principal = 0;};
                                    $f_principal = number_format($principal, 2, '.', ',');
                                };

                                $query_ps = "SELECT SUM(loan_repayment) AS loan_repayment FROM payroll_pay_slip WHERE employee_id = '$employee_id' 
                                AND date < '$date'";
                                $query_run_ps = mysqli_query($con, $query_ps);
                                if(!empty($query_run_ps) && mysqli_num_rows($query_run_ps) > 0 )
                                {
                                    $row_ps = mysqli_fetch_array($query_run_ps);
                                    if($row_ps['loan_repayment'] != NULL)
                                    {
                                        $loan_repayment_bf = $row_ps['loan_repayment'];
                                    }
                                    else{
                                        $loan_repayment_bf = 0;
                                    };
                                    $f_loan_repayment_bf = number_format($loan_repayment_bf, 2, '.', ',');
                                };

                                $balance_bf = $principal - $loan_repayment_bf;
                                $balance_cf = $balance_bf - $row_pay_slip['loan_repayment'];
                                $f_balance_bf = number_format($balance_bf, 2, '.', ',');
                                $f_balance_cf = number_format($balance_cf, 2, '.', ',');

                            //PDF PAYSLIP
                                $f_hourly_rate = number_format($hourly_rate, 2, '.', ',');
                                $f_daily_rate = number_format($daily_rate, 2, '.', ',');
                                $f_pf_employer = number_format($pf_employer, 2, '.', ',');
                                $f_ssf_employer = number_format($ssf_employer, 2, '.', ',');
                                $f_bonus = number_format($bonus, 2, '.', ',');
                                $f_paid_leave = number_format($paid_leave, 2, '.', ',');
                                $f_salary_arrears = number_format($salary_arrears, 2, '.', ',');
                                $f_basic_salary = number_format($basic_salary, 2, '.', ',');
                                $f_resp_allowance = number_format($resp_allowance, 2, '.', ',');
                                $f_accomm_allowance = number_format($accomm_allowance, 2, '.', ',');
                                $f_duty_allowance = number_format($duty_allowance, 2, '.', ',');
                                $f_normal_overtime = number_format($normal_overtime_amount, 2, '.', ',');
                                $f_holiday = number_format($holiday_amount, 2, '.', ',');
                                $f_day_67 = number_format($day_67_amount, 2, '.', ',');
                                $f_absent_amount = number_format($absentism, 2, '.', ',');
                                $f_student_loan = number_format($student_loan, 2, '.', ',');
                                $f_top_up = number_format($top_up, 2, '.', ',');
                                $f_pf_amount = number_format($pf_amount, 2, '.', ',');
                                $f_ssf_amount = number_format($ssf_amount, 2, '.', ',');
                                $f_tax = number_format($tax, 2, '.', ',');
                                $f_salary_advance = number_format($salary_advance, 2, '.', ',');
                                $f_loan_repayment = number_format($loan_repayment, 2, '.', ',');
                                $f_total_allowance = number_format($total_allowance, 2, '.', ',');
                                $f_total_overtime = number_format($total_overtime, 2, '.', ',');
                                $f_total_emolument = number_format($total_emolument, 2, '.', ',');
                                $f_total_deductions = number_format($total_deductions, 2, '.', ',');
                                $f_net_salary = number_format($net_salary, 2, '.', ',');

                                $pdf->SetFont('Arial','I',8);
                                $pdf->Cell(189,5,'Address To: ',0,1);
                                $pdf->SetFont('Arial','B',10);
                                $pdf->SetLineWidth(0.1);

                                $pdf->Cell(10,5,'',0,0);
                                $pdf->Cell(60,5,$employee_name,0,0);
                                $pdf->SetFont('Arial','I',8);
                                $pdf->Cell(60,5,'Period: '.$month.', '.$year,0,0);
                                $pdf->Cell(59,5,'Bank: '.$bank,0,1);

                                $pdf->Cell(10,5,'',0,0);
                                $pdf->Cell(60,5,$row_pay_slip['position'],0,0);
                                $pdf->Cell(60,5,'Location: '.$branch_name,0,0);
                                $pdf->Cell(59,5,'A/C No: '.$account_no,0,1);

                                $pdf->Cell(10,5,'',0,0);
                                $pdf->Cell(60,5,'',0,0);
                                $pdf->Cell(60,5,'Department:'.$dept_name,0,0);
                                $pdf->Cell(59,5,'Payment Type:',0,1);

                                $pdf->Cell(189,5,'',0,1);

                                $pdf->SetFont('Arial','B',10);
                                $pdf->Cell(189,5,'EARNINGS',1,1,'L');
                                $pdf->SetFont('Arial','I',8);
                                $pdf->Cell(84,5,'Basic Salary',1,0,'L');
                                $pdf->Cell(35,5,'Daily Wage:'.$f_daily_rate,1,0,'L');
                                $pdf->Cell(35,5,'Hourly Rate:'.$f_hourly_rate,1,0,'L');
                                $pdf->Cell(35,5,$f_basic_salary,1,1,'R');

                                $pdf->SetFont('Arial','B',10);
                                $pdf->Cell(189,5,'Allowances',1,1,'L');
                                $pdf->SetFont('Arial','I',8);
                                $pdf->Cell(84,5,'Responsibility Allowance',1,0,'L');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,$f_resp_allowance,1,1,'R');
                                $pdf->Cell(84,5,'Accommodation Allowance',1,0,'L');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,$f_accomm_allowance,1,1,'R');
                                $pdf->Cell(84,5,'Duty Allowance',1,0,'L');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,$f_duty_allowance,1,1,'R');
                                $pdf->Cell(84,5,'Normal Overtime',1,0,'L');
                                $pdf->Cell(35,5,'Hours:'.$overtime_hrs,1,0,'R');
                                $pdf->Cell(35,5,'Rate:'.$overtime_rate,1,0,'R');
                                $pdf->Cell(35,5,$f_normal_overtime,1,1,'R');
                                $pdf->Cell(84,5,'Day 6 and 7 Overtime',1,0,'L');
                                $pdf->Cell(35,5,'Hours:'.$day_67_hrs,1,0,'R');
                                $pdf->Cell(35,5,'Rate:'.$day_67_rate,1,0,'R');
                                $pdf->Cell(35,5,$f_day_67,1,1,'R');
                                $pdf->Cell(84,5,'Holidays Overtime',1,0,'L');
                                $pdf->Cell(35,5,'Hours:'.$holidays_hrs,1,0,'R');
                                $pdf->Cell(35,5,'Rate:'.$holiday_rate,1,0,'R');
                                $pdf->Cell(35,5,$f_holiday,1,1,'R');
                                $pdf->Cell(84,5,'Top-Up',1,0,'L');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,$f_top_up,1,1,'R');
                                $pdf->Cell(84,5,'Bonus',1,0,'L');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,$f_bonus,1,1,'R');
                                $pdf->Cell(84,5,'Paid Leave',1,0,'L');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,$f_paid_leave,1,1,'R');
                                $pdf->Cell(84,5,'Salary Arrears',1,0,'L');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,$f_salary_arrears,1,1,'R');
                                $pdf->SetFont('Arial','B',10);
                                $pdf->Cell(154,5,'Total Allowances',1,0,'L');
                                $pdf->Cell(35,5,$f_total_allowance,1,1,'R');
                                $pdf->Cell(154,5,'TOTAL EARNINGS',1,0,'L');
                                $pdf->Cell(35,5,$f_total_emolument,1,1,'R');
                                $pdf->Cell(189,5,'',1,1,'L');
                                $pdf->Cell(189,5,'DEDUCTIONS',1,1,'L');
                                $pdf->SetFont('Arial','I',8);
                                $pdf->Cell(84,5,'SSF Employee',1,0,'L');
                                $pdf->Cell(35,5,'SSF Employer: '.$f_ssf_employer,1,0,'R');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,$f_ssf_amount,1,1,'R');
                                $pdf->Cell(84,5,'PF Employee',1,0,'L');
                                $pdf->Cell(35,5,'PF Employer: '.$f_pf_employer,1,0,'R');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,$f_pf_amount,1,1,'R');
                                $pdf->Cell(84,5,'Tax',1,0,'L');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,$f_tax,1,1,'R');
                                $pdf->Cell(84,5,'Absentism',1,0,'L');
                                $pdf->Cell(35,5,'Days:'.$absent_days,1,0,'R');
                                $pdf->Cell(35,5,'Rate:'.$row_pay_slip['daily_rate'],1,0,'R');
                                $pdf->Cell(35,5,$f_absent_amount,1,1,'R');
                                $pdf->Cell(84,5,'Salary Advance',1,0,'L');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,$f_salary_advance,1,1,'R');
                                $pdf->Cell(84,5,'Loan Repayment',1,0,'L');
                                $pdf->Cell(35,5,'Opn Bal: '.$f_balance_bf,1,0,'R');
                                $pdf->Cell(35,5,'Cls Bal: '.$f_balance_cf,1,0,'R');
                                $pdf->Cell(35,5,$f_loan_repayment,1,1,'R');
                                $pdf->Cell(84,5,'Student Loan',1,0,'L');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,'',1,0,'R');
                                $pdf->Cell(35,5,$f_student_loan,1,1,'R');
                                $pdf->SetFont('Arial','B',10);
                                $pdf->Cell(154,5,'Total Deduction',1,0,'L');
                                $pdf->Cell(35,5,$f_total_deductions,1,1,'R');
                                $pdf->Cell(189,5,'',1,1,'L');
                                $pdf->Cell(154,5,'NET SALARY',1,0,'L');
                                $pdf->Cell(35,5,$f_net_salary,1,1,'R');

                                $pdf->Cell(189,10,'',0,1);
                                $pdf->SetFont('Arial','B',8);
                                $pdf->Cell(48,5,'Leave',1,0,'C');
                                $pdf->Cell(47,5,'No of Days',1,0,'C');
                                $pdf->Cell(47,5,'Days Taken',1,0,'C');
                                $pdf->Cell(47,5,'Outstanding',1,1,'C');
                                $pdf->SetFont('Arial','I',8);
                                $pdf->Cell(48,5,'Annual Leave',1,0,'C');
                                $pdf->Cell(47,5,$annual_leave,1,0,'C');
                                $pdf->Cell(47,5,$annual_gone,1,0,'C');
                                $pdf->Cell(47,5,$annual_leave_bal,1,1,'C');
                                $pdf->Cell(48,5,'Sick Leave',1,0,'C');
                                $pdf->Cell(47,5,$sick_leave,1,0,'C');
                                $pdf->Cell(47,5,$sick_gone,1,0,'C');
                                $pdf->Cell(47,5,$sick_leave_bal,1,1,'C');
                                $pdf->Cell(48,5,'Maternity Leave',1,0,'C');
                                $pdf->Cell(47,5,$maternity_leave,1,0,'C');
                                $pdf->Cell(47,5,$maternity_gone,1,0,'C');
                                $pdf->Cell(47,5,$maternity_leave_bal,1,1,'C');

                                $pdf->Cell(189,10,'',0,1);
                                $pdf->Cell(95,5,'',0,0,'C');
                                $pdf->Cell(94,5,'..............................................................',0,1,'C');
                                $pdf->Cell(189,5,'',0,1);
                                $pdf->Cell(95,5,'',0,0,'C');
                                $pdf->Cell(94,5,'Manager Signature',0,1,'C');
                                $filename = $_SERVER['DOCUMENT_ROOT'] .'/img/pay_slip.pdf';
                                $pdf->Output($filename,'F');

                            //SEND_MAIL
                                $strMailContent = '<p>Dear Sir/Madam</p><br>'.

                                    '<p><b>'.$month .' '.$year.' Payslip</b></p>'.

                                    '<p>Please find attached your payslip for the month of '.$month .' '.$year.'</p><br>'.
                                    '<p>Many thanks</p><br>'.
                                    '<p>Isaac Kojo Annan Yalley, MCIT, MPhil, CA</p>'.
                                    '<p>Financial Analyst</p>'.
                                    '<p>Ramoth Services Ltd.</p>'.
                                    '<p>P. O. Box KS 4755, Kumasi</p>'.
                                    '<p>Plot 2 Block E, East Ring Road, Ahenema Kokoben, Kumasi</p>'.
                                    '<p>Tel: 0531012930 / 0322037939 / 0322026842</p><br>';
                                // $strMailTextVersion = strip_tags($strMailContent, '');

                                $mimeMessage = "";
                                $boundary = uniqid(rand(), true);
                                $subjectCharset = $charset = 'utf-8';
                                $strToMailName = $employee_name;
                                $strToMail = $employee_email;
                                $strSesFromName = 'RAMOTH PAYROLL';
                                $strSesFromEmail = 'ramothapp@gmail.com';
                                $strSubject = $month .' '.$year.' PAYSLIP';

                                $mimeMessage .= 'To: ' .$strToMailName . " <" . $strToMail . ">" . "\r\n";
                                $mimeMessage .= 'From: '.$strSesFromName . " <" . $strSesFromEmail . ">" . "\r\n";

                                $mimeMessage .= 'Subject: =?' . $subjectCharset . '?B?' . base64_encode($strSubject) . "?=\r\n";
                                $mimeMessage .= 'MIME-Version: 1.0' . "\r\n";
                                $mimeMessage .= 'Content-type: Multipart/Mixed; boundary="' . $boundary . '"' . "\r\n";

                                $filePath = $_SERVER['DOCUMENT_ROOT'] .'/img/pay_slip.pdf';
                                $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
                                $mimeType = finfo_file($finfo, $filePath);
                                $fileName = 'pay_slip.pdf';
                                $fileData = base64_encode(file_get_contents($filePath));

                                $mimeMessage .= "\r\n--{$boundary}\r\n";
                                $mimeMessage .= 'Content-Type: '. $mimeType .'; name="'. $fileName .'";' . "\r\n";            
                                $mimeMessage .= 'Content-ID: <' . $strSesFromEmail . '>' . "\r\n";            
                                $mimeMessage .= 'Content-Description: ' . $fileName . ';' . "\r\n";
                                $mimeMessage .= 'Content-Disposition: attachment; filename="' . $fileName . '"; size=' . filesize($filePath). ';' . "\r\n";
                                $mimeMessage .= 'Content-Transfer-Encoding: base64' . "\r\n\r\n";
                                $mimeMessage .= chunk_split(base64_encode(file_get_contents($filePath)), 76, "\n") . "\r\n";
                                $mimeMessage .= "--{$boundary}\r\n";
                                $mimeMessage .= 'Content-Type: text/html; charset=' . $charset . "\r\n";
                                $mimeMessage .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
                                $mimeMessage .= $strMailContent . "\r\n";

                                $encodedEmail = base64_encode($mimeMessage);
                                $message->setRaw($encodedEmail);
                                @$message=$service->users_messages->send('me',$message);
                                //echo "sent";
                        };
                };
            } 
            catch (\Throwable $th) 
            {
                echo $th->getMessage();
                echo $th->getTraceAsString();
            }
        }
        else
        {
            echo 'No Payslip';
        };
    }
    else
    {
        echo 'Not found';
    };
    echo  "<script type='text/javascript'>";
    echo "window.setTimeout(function() {window.close();}, 3000);";
    echo "</script>";