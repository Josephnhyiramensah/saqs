<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf.php');
    
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
            //$this->SetY(-15);
            // Select Arial italic 8
            
            /*$sign = $_SERVER['DOCUMENT_ROOT'] .'/img/ac_sign.png';
            $this->Image($sign,80,250,50,30);*/
        }
    }
	date_default_timezone_set("Africa/Accra");

    if(isset($_SESSION['pay_slip_report_type']))
    {
        $company_id = $_SESSION['company_id'];
        $type = $_SESSION['pay_slip_report_type'];
        $employee = $_SESSION['pay_slip_report_employee'];
        $branch = $_SESSION['pay_slip_report_branch'];
        $start_date = $_SESSION['pay_slip_report_start_date'];
        $end_date = $_SESSION['pay_slip_report_end_date'];
    
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
            while($row_pay_slip = mysqli_fetch_array($query_run_pay_slip))
            {
                $pdf = new PDF('P','mm','A4');
                $pdf->AddPage();
                $pdf->SetFont('Arial','B',8);
                $pdf->Image($image,10,10,15,15);
                
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
                }
                else
                {
                    $employee_name = 'Not Specified';
                    $annual_leave = 0;
                    $sick_leave = 0;
                    $maternity_leave = 0;
                };

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
                
                if($row_pay_slip['basic_salary'] != NULL){$basic_salary = $row_pay_slip['basic_salary'];}else{$basic_salary = 0;};
                if($row_pay_slip['resp_allowance'] != NULL){$resp_allowance = $row_pay_slip['resp_allowance'];}else{$resp_allowance = 0;};
                if($row_pay_slip['accomm_allowance'] != NULL){$accomm_allowance = $row_pay_slip['accomm_allowance'];}else{$accomm_allowance = 0;};
                if($row_pay_slip['duty_allowance'] != NULL){$duty_allowance = $row_pay_slip['duty_allowance'];}else{$duty_allowance = 0;};
                if($row_pay_slip['normal_overtime'] != NULL){$normal_overtime = $row_pay_slip['normal_overtime'];}else{$normal_overtime = 0;};
                if($row_pay_slip['holiday_overtime'] != NULL){$holiday_overtime = $row_pay_slip['holiday_overtime'];}else{$holiday_overtime = 0;};
                if($row_pay_slip['day_67_overtime'] != NULL){$day_67_overtime = $row_pay_slip['day_67_overtime'];}else{$day_67_overtime = 0;};
                if($row_pay_slip['pf_amount'] != NULL){$pf_amount = $row_pay_slip['pf_amount'];}else{$pf_amount = 0;};
                if($row_pay_slip['ssf_amount'] != NULL){$ssf_amount = $row_pay_slip['ssf_amount'];}else{$ssf_amount = 0;};
                if($row_pay_slip['tax'] != NULL){$tax = $row_pay_slip['tax'];}else{$tax = 0;};
                if($row_pay_slip['salary_advance'] != NULL){$salary_advance = $row_pay_slip['salary_advance'];}else{$salary_advance = 0;};
                if($row_pay_slip['loan_repayment'] != NULL){$loan_repayment = $row_pay_slip['loan_repayment'];}else{$loan_repayment = 0;};
                if($row_pay_slip['absent'] != NULL){$absentism = $row_pay_slip['absent'];}else{$absentism = 0;};
                if($row_pay_slip['top_up'] != NULL){$top_up = $row_pay_slip['top_up'];}else{$top_up = 0;};
                
                $total_allowance = $resp_allowance + $accomm_allowance + $duty_allowance +
                $normal_overtime + $holiday_overtime + $day_67_overtime + $top_up;

                $total_overtime = $normal_overtime + $holiday_overtime + $day_67_overtime;
                $total_emolument = $basic_salary + $total_allowance;
                $total_deductions = $pf_amount + $ssf_amount + $tax + $loan_repayment + $salary_advance + $absentism;
                $net_salary = $total_emolument - $total_deductions;
                $date = $row_pay_slip['date'];
                $month = date("F",strtotime($date));
                $year = date("Y",strtotime($date));
                
                $start = date("Y-m-01", strtotime($date));
                $end = date("Y-m-t", strtotime($date));


                $start_date = date('Y-01-01');
                $end_date = date('Y-12-31');

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

                $query_ts = "SELECT SUM(tsl.normal_overtime) AS overtime, SUM(tsl.day_67_overtime) AS day_67_overtime, 
                SUM(tsl.holidays) AS holidays,SUM(tsl.absent) AS absent_days, ts.date, tsl.employee_id FROM payroll_time_sheet_list tsl JOIN 
                payroll_time_sheet ts ON tsl.time_sheet_id = ts.time_sheet_id WHERE tsl.employee_id = '$employee_id' AND ts.date BETWEEN '$start' AND '$end'";
                $query_run_ts = mysqli_query($con, $query_ts);
                if(!empty($query_run_ts) && mysqli_num_rows($query_run_ts) > 0)
                {
                    $row_ts = mysqli_fetch_assoc($query_run_ts);
                    if($row_ts['overtime'] != NULL){$overtime = $row_ts['overtime'];}else{$overtime = 0;};
                    if($row_ts['day_67_overtime'] != NULL){$day_67 = $row_ts['day_67_overtime'];}else{$day_67 = 0;};
                    if($row_ts['holidays'] != NULL){$holidays = $row_ts['holidays'];}else{$holidays = 0;};
                    if($row_ts['absent_days'] != NULL){$absent_days = $row_ts['absent_days'];}else{$absent_days = 0;};
                    
                    $normal_overtime = $row_pay_slip['overtime_rate'] * $overtime;
                    $holiday_overtime = $row_pay_slip['holiday_rate'] * $holidays;
                    $day_67_overtime = $row_pay_slip['day_67_rate'] * $day_67;
                    $absent_amount = $row_pay_slip['daily_rate'] * $absent_days;
                }
                else
                {
                    $normal_overtime = 0;
                    $holiday_overtime = 0;
                    $day_67_overtime = 0;
                    $absent_amount = 0;
                };

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
                    if($row_ps['loan_repayment'] != NULL){$loan_repayment_bf = $row_ps['loan_repayment'];}else{$loan_repayment_bf = 0;};
                    $f_loan_repayment_bf = number_format($loan_repayment_bf, 2, '.', ',');
                };
                $balance_bf = $principal - $loan_repayment_bf;
                $balance_cf = $balance_bf - $row_pay_slip['loan_repayment'];
                $f_balance_bf = number_format($balance_bf, 2, '.', ',');
                $f_balance_cf = number_format($balance_cf, 2, '.', ',');
                $hourly_rate = $row_pay_slip['hourly_rate'];
                $daily_rate = $row_pay_slip['daily_rate'];
                $pf_employer = $row_pay_slip['pf_employer'];
                $ssf_employer = $row_pay_slip['ssf_employer'];
        
                $f_hourly_rate = number_format($hourly_rate, 2, '.', ',');
                $f_daily_rate = number_format($daily_rate, 2, '.', ',');
                $f_pf_employer = number_format($pf_employer, 2, '.', ',');
                $f_ssf_employer = number_format($ssf_employer, 2, '.', ',');
        
                $f_basic_salary = number_format($basic_salary, 2, '.', ',');
                $f_resp_allowance = number_format($resp_allowance, 2, '.', ',');
                $f_accomm_allowance = number_format($accomm_allowance, 2, '.', ',');
                $f_duty_allowance = number_format($duty_allowance, 2, '.', ',');
                $f_normal_overtime = number_format($normal_overtime, 2, '.', ',');
                $f_holiday_overtime = number_format($holiday_overtime, 2, '.', ',');
                $f_day_67_overtime = number_format($day_67_overtime, 2, '.', ',');
                $f_absent_amount = number_format($absent_amount, 2, '.', ',');
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
        
                $pdf->SetFont('Arial','B',18);
                $pdf->Cell(189,10,$row_company['trading_name'],0,1,'C');
                $pdf->SetFont('Arial','I',8);
                $pdf->Cell(189,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
                $pdf->Cell(189,5,$row_company['telephone'],0,1,'C');
                $pdf->SetFont('Arial','B',12);
                $pdf->Cell(189,5,'',0,1,'C');
                $pdf->Cell(189,5,'PAY SLIP',0,1,'C');
                $pdf->Cell(189,5,'',0,1,'C');
        
                $pdf->SetFont('Arial','I',8);
                $pdf->Cell(189,5,'Address To: ',0,1);
                $pdf->SetFont('Arial','B',10);
                $pdf->SetLineWidth(0.1);
        
                $pdf->Cell(10,5,'',0,0);
                $pdf->Cell(95,5,$employee_name,0,0);
                $pdf->SetFont('Arial','I',8);
                $pdf->Cell(84,5,'Period: '.$month.', '.$year,0,1);
        
                $pdf->Cell(10,5,'',0,0);
                $pdf->Cell(95,5,$row_pay_slip['position'],0,0);
                $pdf->Cell(84,5,'Location: '.$branch_name,0,1);
        
                $pdf->Cell(10,5,'',0,0);
                $pdf->Cell(95,5,'',0,0);
                $pdf->Cell(84,5,'Department:'.$dept_name,0,1);
        
                $pdf->Cell(10,5,'',0,0);
                $pdf->Cell(95,5,'',0,0);
                $pdf->Cell(84,5,'Payment Type:',0,1);
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
                $pdf->Cell(35,5,'Hours:'.$overtime,1,0,'R');
                $pdf->Cell(35,5,'Rate:'.$row_pay_slip['overtime_rate'],1,0,'R');
                $pdf->Cell(35,5,$f_normal_overtime,1,1,'R');
                $pdf->Cell(84,5,'Day 6 and 7 Overtime',1,0,'L');
                $pdf->Cell(35,5,'Hours:'.$day_67,1,0,'R');
                $pdf->Cell(35,5,'Rate:'.$row_pay_slip['day_67_rate'],1,0,'R');
                $pdf->Cell(35,5,$f_day_67_overtime,1,1,'R');
                $pdf->Cell(84,5,'Holidays Overtime',1,0,'L');
                $pdf->Cell(35,5,'Hours:'.$holidays,1,0,'R');
                $pdf->Cell(35,5,'Rate:'.$row_pay_slip['holiday_rate'],1,0,'R');
                $pdf->Cell(35,5,$f_holiday_overtime,1,1,'R');
                $pdf->Cell(84,5,'Top-Up',1,0,'L');
                $pdf->Cell(35,5,'',1,0,'R');
                $pdf->Cell(35,5,'',1,0,'R');
                $pdf->Cell(35,5,$f_top_up,1,1,'R');
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
                $filename = 'C:/Payslips/'.$employee_name.'_'.$date.'.pdf';
                $pdf->Output('F',"$filename");
            };
        };
    };
?>