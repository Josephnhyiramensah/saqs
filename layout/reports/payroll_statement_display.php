<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    
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
            $this->SetY(-15);
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
            $this->Cell(400,5,'Printed by: '.$user_name.' on '.date('Y-m-d h:m:sa'),0,1,'C');
        }
    }
	date_default_timezone_set("Africa/Accra");

    $pdf = new PDF('L','mm','A3');
    //$pdf = new PDF('L','mm',array(900,600));
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    $pdf->Image($image,10,10,15,15);
    
    if(isset($_SESSION['payroll_statement_pay_sheet_id']))
    {
        $company_id = $_SESSION['company_id'];
        $pay_sheet_id = $_SESSION['payroll_statement_pay_sheet_id'];
        $location = $_SESSION['payroll_statement_location'];
    
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
        $pdf->Cell(400,10,$row_company['trading_name'],0,1,'C');
        $pdf->SetFont('Arial','I',12);
        $pdf->Cell(400,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
        $pdf->Cell(400,5,$row_company['telephone'],0,1,'C');
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(400,5,'',0,1,'C');
        $pdf->Cell(400,5,'PAYROLL STATEMENT',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(400,5,'FOR '.$pay_sheet_location.' AS AT '.$pay_sheet_date,0,1,'C');
        $pdf->Cell(400,5,'',0,1,'C');

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(10,5,'S/No',1,0,'C');
        $pdf->Cell(55,5,'Employee',1,0,'C');
        $pdf->Cell(45,5,'Position',1,0,'C');
        $pdf->Cell(25,5,'Basic Salary',1,0,'C');
        $pdf->Cell(15,5,'Fuel',1,0,'C');
        $pdf->Cell(15,5,'Clothing',1,0,'C');
        $pdf->Cell(15,5,'Other All.',1,0,'C');
        $pdf->Cell(15,5,'Salary Arr.',1,0,'C');
        $pdf->Cell(25,5,'Gross Salary',1,0,'C');
        $pdf->Cell(15,5,'Welfare',1,0,'C');
        $pdf->Cell(15,5,'SSF',1,0,'C');
        $pdf->Cell(15,5,'SSF Emp.',1,0,'C');
        $pdf->Cell(15,5,'Tax',1,0,'C');
        $pdf->Cell(15,5,'S. Adv',1,0,'C');
        $pdf->Cell(15,5,'Loan',1,0,'C');
        $pdf->Cell(15,5,'Absent',1,0,'C');
        $pdf->Cell(25,5,'Other Ded.',1,0,'C');
        $pdf->Cell(25,5,'Total Ded.',1,0,'C');
        $pdf->Cell(25,5,'Net Salary',1,1,'C');
        
        $employee_id = 0;
        $basic_salary = 0;
        $fuel_allowance = 0;
        $clothing_allowance = 0;
        $other_allowance = 0;
        $normal_overtime = 0;
        $holiday = 0;
        $day_67 = 0;
        $welfare = 0;
        $bonus = 0;
        $salary_arrears = 0;
        $paid_leave = 0;
        $other_deductions = 0;
        $ssf_amount = 0;
        $ssf_employer = 0;
        $tax = 0;
        $salary_advance = 0;
        $loan_repayment = 0;
        $absent = 0;
        
        $total_allowance = 0;
        $total_overtime = 0;
        $total_emolument = 0;
        $total_deductions = 0;
        $net_salary = 0;
        $sum_basic_salary = 0;
        $sum_fuel_allowance = 0;
        $sum_clothing_allowance = 0;
        $sum_other_allowance = 0;
        $sum_normal_overtime = 0;
        $sum_holiday = 0;
        $sum_day_67 = 0;
        $sum_welfare = 0;
        $sum_bonus = 0;
        $sum_salary_arrears = 0;
        $sum_paid_leave = 0;
        $sum_other_deductions = 0;
        $sum_ssf_amount = 0;
        $sum_ssf_employer = 0;
        $sum_tax = 0;
        $sum_salary_advance = 0;
        $sum_loan_repayment = 0;
        $sum_absent = 0;
        $sum_total_allowance = 0;
        $sum_total_overtime = 0;
        $sum_total_emolument = 0;
        $sum_total_deductions = 0;
        $sum_net_salary = 0;
        if($location == 'ALL')
        {
            $query_location = "SELECT * FROM branch ORDER BY branch_name ASC";
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
                    $subt_holiday = 0;
                    $subt_day_67 = 0;
                    $subt_welfare = 0;
                    $subt_bonus = 0;
                    $subt_salary_arrears = 0;
                    $subt_paid_leave = 0;
                    $subt_other_deductions = 0;
                    $subt_ssf_amount = 0;
                    $subt_ssf_employer = 0;
                    $subt_tax = 0;
                    $subt_salary_advance = 0;
                    $subt_loan_repayment = 0;
                    $subt_absent = 0;
                    $subt_total_allowance = 0;
                    $subt_total_overtime = 0;
                    $subt_total_emolument = 0;
                    $subt_total_deductions = 0;
                    $subt_net_salary = 0;

                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(400,5,$row_location['branch_name'],1,1);
                    while($row_pay_slip = mysqli_fetch_array($query_run_pay_slip))
                    {
                        $i++;
                        $employee_id = $row_pay_slip['employee_id'];
                        $basic_salary = $row_pay_slip['basic_salary'];
                        $fuel_allowance = $row_pay_slip['fuel_allowance'];
                        $clothing_allowance = $row_pay_slip['clothing_allowance'];
                        $other_allowance = $row_pay_slip['other_allowance'];
                        $normal_overtime = $row_pay_slip['normal_overtime'];
                        $holiday = $row_pay_slip['holiday'];
                        $day_67 = $row_pay_slip['day_67'];
                        $welfare = $row_pay_slip['welfare'];
                        $bonus = $row_pay_slip['bonus'];
                        $salary_arrears = $row_pay_slip['salary_arrears'];
                        $paid_leave = $row_pay_slip['paid_leave'];
                        $other_deductions = $row_pay_slip['other_deductions'];
                        //$ssf_amount = $row_pay_slip['ssf_amount'];
                        $ssf_employer = $row_pay_slip['ssf_employer'];
                        $tax = $row_pay_slip['tax'];
                        $salary_advance = $row_pay_slip['salary_advance'];
                        $loan_repayment = $row_pay_slip['loan_repayment'];
                        $absent = $row_pay_slip['absent'];

                        $total_allowance = $fuel_allowance + $clothing_allowance + $other_allowance +
                        $normal_overtime + $holiday + $day_67 + $bonus + $salary_arrears + $paid_leave;

                        $total_overtime = $normal_overtime + $holiday + $day_67;

                        $total_emolument = $basic_salary + $total_allowance;

                        /*if($ssnit_arrears_type == 'CURRENT_DEDUCTION')
                        {
                            if($row_pay_slip['ssf_amount'] != NULL){$ssf_amount = $row_pay_slip['ssf_amount']+$ssf_employee_arrears;}else{$ssf_amount = 0+$ssf_employee_arrears;};
                            $ssf_employer = $row_pay_slip['ssf_employer'] + $ssf_employer_arrears;

                            $total_deductions = $welfare + $ssf_amount + $tax + $loan_repayment + $salary_advance + 
                            $absentism + $other_deductions + $ssf_employee_arrears;
                        }
                        else
                        {*/
                            if($row_pay_slip['ssf_amount'] != NULL){$ssf_amount = $row_pay_slip['ssf_amount'];}else{$ssf_amount = 0;};
                            $ssf_employer = $row_pay_slip['ssf_employer'];

                            $total_deductions = $welfare + $ssf_amount + $tax + $loan_repayment + $salary_advance + 
                            $absent + $other_deductions;
                        //};
                        //$total_deductions = $pf_amount + $ssf_amount + $tax + $loan_repayment + $salary_advance + $absent;
                        
                        $net_salary = $total_emolument - $total_deductions;
                        
                        $subt_basic_salary = $subt_basic_salary + $row_pay_slip['basic_salary'];
                        $subt_fuel_allowance = $subt_fuel_allowance + $row_pay_slip['fuel_allowance'];
                        $subt_clothing_allowance = $subt_clothing_allowance + $row_pay_slip['clothing_allowance'];
                        $subt_other_allowance = $subt_other_allowance + $row_pay_slip['other_allowance'];
                        $subt_normal_overtime = $subt_normal_overtime + $row_pay_slip['normal_overtime'];
                        $subt_holiday = $subt_holiday + $row_pay_slip['holiday'];
                        $subt_day_67 = $subt_day_67 + $row_pay_slip['day_67'];
                        $subt_welfare = $subt_welfare + $row_pay_slip['welfare'];
                        $subt_bonus = $subt_bonus + $row_pay_slip['bonus'];
                        $subt_salary_arrears = $subt_salary_arrears + $row_pay_slip['salary_arrears'];
                        $subt_paid_leave = $subt_paid_leave + $row_pay_slip['paid_leave'];
                        $subt_ssf_employer = $subt_ssf_employer + $row_pay_slip['ssf_employer'];
                        $subt_other_deductions = $subt_other_deductions + $row_pay_slip['other_deductions'];
                        $subt_ssf_amount = $subt_ssf_amount + $ssf_amount;
                        $subt_tax = $subt_tax + $row_pay_slip['tax'];
                        $subt_salary_advance = $subt_salary_advance + $row_pay_slip['salary_advance'];
                        $subt_loan_repayment = $subt_loan_repayment + $row_pay_slip['loan_repayment'];
                        $subt_absent = $subt_absent + $row_pay_slip['absent'];
                        $subt_total_allowance = $subt_fuel_allowance + $subt_clothing_allowance + $subt_other_allowance +
                            $subt_normal_overtime + $subt_holiday + $subt_day_67;
                        $subt_total_overtime = $subt_normal_overtime + $subt_holiday + $subt_day_67;
                        $subt_total_emolument = $subt_basic_salary + $subt_total_allowance;
                        $subt_total_deductions = $subt_welfare + $subt_ssf_amount + $subt_tax + $subt_loan_repayment + $subt_salary_advance + $subt_absent + $subt_other_deductions;
                        $subt_net_salary = $subt_total_emolument - $subt_total_deductions;

                        $sum_basic_salary = $sum_basic_salary + $row_pay_slip['basic_salary'];
                        $sum_fuel_allowance = $sum_fuel_allowance + $row_pay_slip['fuel_allowance'];
                        $sum_clothing_allowance = $sum_clothing_allowance + $row_pay_slip['clothing_allowance'];
                        $sum_other_allowance = $sum_other_allowance + $row_pay_slip['other_allowance'];
                        $sum_normal_overtime = $sum_normal_overtime + $row_pay_slip['normal_overtime'];
                        $sum_holiday = $sum_holiday + $row_pay_slip['holiday'];
                        $sum_day_67 = $sum_day_67 + $row_pay_slip['day_67'];
                        $sum_welfare = $sum_welfare + $row_pay_slip['welfare'];
                        $sum_bonus = $sum_bonus + $row_pay_slip['bonus'];
                        $sum_salary_arrears = $sum_salary_arrears + $row_pay_slip['salary_arrears'];
                        $sum_paid_leave = $sum_paid_leave + $row_pay_slip['paid_leave'];
                        $sum_ssf_employer = $sum_ssf_employer + $row_pay_slip['ssf_employer'];
                        $sum_other_deductions = $sum_other_deductions + $row_pay_slip['other_deductions'];
                        $sum_ssf_amount = $sum_ssf_amount + $ssf_amount;
                        $sum_tax = $sum_tax + $row_pay_slip['tax'];
                        $sum_salary_advance = $sum_salary_advance + $row_pay_slip['salary_advance'];
                        $sum_loan_repayment = $sum_loan_repayment + $row_pay_slip['loan_repayment'];
                        $sum_absent = $sum_absent + $row_pay_slip['absent'];
                        $sum_total_allowance = $sum_total_allowance + $fuel_allowance + $clothing_allowance + $other_allowance +
                            $normal_overtime + $holiday + $day_67;
                        $sum_total_overtime = $sum_total_overtime + $normal_overtime + $holiday + $day_67;
                        $sum_total_emolument = $sum_total_emolument + $basic_salary + $total_allowance;
                        $sum_total_deductions = $sum_total_deductions + $welfare + $ssf_amount + $tax + $loan_repayment + $salary_advance + $absent + $other_deductions;
                        $sum_net_salary = $sum_net_salary + $total_emolument - $total_deductions;

                        $f_basic_salary = number_format($basic_salary, 2, '.', ',');
                        $f_fuel_allowance = number_format($fuel_allowance, 2, '.', ',');
                        $f_clothing_allowance = number_format($clothing_allowance, 2, '.', ',');
                        $f_other_allowance = number_format($other_allowance, 2, '.', ',');
                        $f_normal_overtime = number_format($normal_overtime, 2, '.', ',');
                        $f_holiday = number_format($holiday, 2, '.', ',');
                        $f_day_67 = number_format($day_67, 2, '.', ',');
                        $f_welfare = number_format($welfare, 2, '.', ',');
                        $f_bonus = number_format($bonus, 2, '.', ',');
                        $f_salary_arrears = number_format($salary_arrears, 2, '.', ',');
                        $f_paid_leave = number_format($paid_leave, 2, '.', ',');
                        $f_ssf_employer = number_format($ssf_employer, 2, '.', ',');
                        $f_other_deductions = number_format($other_deductions, 2, '.', ',');
                        $f_ssf_amount = number_format($ssf_amount, 2, '.', ',');
                        $f_tax = number_format($tax, 2, '.', ',');
                        $f_salary_advance = number_format($salary_advance, 2, '.', ',');
                        $f_loan_repayment = number_format($loan_repayment, 2, '.', ',');
                        $f_absent = number_format($absent, 2, '.', ',');
                        $f_total_allowance = number_format($total_allowance, 2, '.', ',');
                        $f_total_overtime = number_format($total_overtime, 2, '.', ',');
                        $f_total_emolument = number_format($total_emolument, 2, '.', ',');
                        $f_total_deductions = number_format($total_deductions, 2, '.', ',');
                        $f_net_salary = number_format($net_salary, 2, '.', ',');
                        
                        $sql_employee="SELECT * FROM payroll_employee WHERE employee_id = '$employee_id'";
                        $result_employee = mysqli_query($con, $sql_employee);
                        if(!empty($result_employee) && mysqli_num_rows($result_employee) > 0 )
                        {
                            $row_employee = mysqli_fetch_array($result_employee);
                            $employee_name = $row_employee['first_name'].' '.$row_employee['last_name'];
                            $position = $row_employee['position'];
                        }
                        else
                        {
                            $employee_name = 'Not Specified';
                            $position = 'Not Specified';
                        };
                        $pdf->SetFont('Arial','I',9);
                        $pdf->Cell(10,5,$i,1,0,'C');
                        $pdf->Cell(55,5,$employee_name,1,0);
                        $pdf->Cell(45,5,$position,1,0);
                        $pdf->Cell(25,5,$f_basic_salary,1,0,'R');
                        $pdf->Cell(15,5,$f_fuel_allowance,1,0,'R');
                        $pdf->Cell(15,5,$f_clothing_allowance,1,0,'R');
                        $pdf->Cell(15,5,$f_other_allowance,1,0,'R');
                        $pdf->Cell(15,5,$f_salary_arrears,1,0,'R');
                        $pdf->Cell(25,5,$f_total_emolument,1,0,'R');
                        $pdf->Cell(15,5,$f_welfare,1,0,'R');
                        $pdf->Cell(15,5,$f_ssf_amount,1,0,'R');
                        $pdf->Cell(15,5,$f_ssf_employer,1,0,'R');
                        $pdf->Cell(15,5,$f_tax,1,0,'R');
                        $pdf->Cell(15,5,$f_salary_advance,1,0,'R');
                        $pdf->Cell(15,5,$f_loan_repayment,1,0,'R');
                        $pdf->Cell(15,5,$f_absent,1,0,'R');
                        $pdf->Cell(25,5,$f_other_deductions,1,0,'R');
                        $pdf->Cell(25,5,$f_total_deductions,1,0,'R');
                        $pdf->Cell(25,5,$f_net_salary,1,1,'R');
                    };
                    $f_subt_basic_salary = number_format($subt_basic_salary, 2, '.', ',');
                    $f_subt_fuel_allowance = number_format($subt_fuel_allowance, 2, '.', ',');
                    $f_subt_clothing_allowance = number_format($subt_clothing_allowance, 2, '.', ',');
                    $f_subt_other_allowance = number_format($subt_other_allowance, 2, '.', ',');
                    $f_subt_normal_overtime = number_format($subt_normal_overtime, 2, '.', ',');
                    $f_subt_holiday = number_format($subt_holiday, 2, '.', ',');
                    $f_subt_day_67 = number_format($subt_day_67, 2, '.', ',');
                    $f_subt_welfare = number_format($subt_welfare, 2, '.', ',');
                    $f_subt_bonus = number_format($subt_bonus, 2, '.', ',');
                    $f_subt_salary_arrears = number_format($subt_salary_arrears, 2, '.', ',');
                    $f_subt_paid_leave = number_format($subt_paid_leave, 2, '.', ',');
                    $f_subt_other_deductions = number_format($subt_other_deductions, 2, '.', ',');
                    $f_subt_ssf_amount = number_format($subt_ssf_amount, 2, '.', ',');
                    $f_subt_ssf_employer = number_format($subt_ssf_employer, 2, '.', ',');
                    $f_subt_tax = number_format($subt_tax, 2, '.', ',');
                    $f_subt_salary_advance = number_format($subt_salary_advance, 2, '.', ',');
                    $f_subt_loan_repayment = number_format($subt_loan_repayment, 2, '.', ',');
                    $f_subt_absent = number_format($subt_absent, 2, '.', ',');
                    $f_subt_total_allowance = number_format($subt_total_allowance, 2, '.', ',');
                    $f_subt_total_overtime = number_format($subt_total_overtime, 2, '.', ',');
                    $f_subt_total_emolument = number_format($subt_total_emolument, 2, '.', ',');
                    $f_subt_total_deductions = number_format($subt_total_deductions, 2, '.', ',');
                    $f_subt_net_salary = number_format($subt_net_salary, 2, '.', ',');
                    
                    $pdf->SetFont('Arial','BI',9);
                    $pdf->Cell(110,5,'TOTAL',1,0);
                    $pdf->Cell(25,5,$f_subt_basic_salary,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_fuel_allowance,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_clothing_allowance,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_other_allowance,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_salary_arrears,1,0,'R');
                    $pdf->Cell(25,5,$f_subt_total_emolument,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_welfare,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_ssf_amount,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_ssf_employer,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_tax,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_salary_advance,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_loan_repayment,1,0,'R');
                    $pdf->Cell(15,5,$f_subt_absent,1,0,'R');
                    $pdf->Cell(25,5,$f_subt_other_deductions,1,0,'R');
                    $pdf->Cell(25,5,$f_subt_total_deductions,1,0,'R');
                    $pdf->Cell(25,5,$f_subt_net_salary,1,1,'R');
                };
            };
            $f_sum_basic_salary = number_format($sum_basic_salary, 2, '.', ',');
            $f_sum_fuel_allowance = number_format($sum_fuel_allowance, 2, '.', ',');
            $f_sum_clothing_allowance = number_format($sum_clothing_allowance, 2, '.', ',');
            $f_sum_other_allowance = number_format($sum_other_allowance, 2, '.', ',');
            $f_sum_normal_overtime = number_format($sum_normal_overtime, 2, '.', ',');
            $f_sum_holiday = number_format($sum_holiday, 2, '.', ',');
            $f_sum_day_67 = number_format($sum_day_67, 2, '.', ',');
            $f_sum_welfare = number_format($sum_welfare, 2, '.', ',');
            $f_sum_bonus = number_format($sum_bonus, 2, '.', ',');
            $f_sum_salary_arrears = number_format($sum_salary_arrears, 2, '.', ',');
            $f_sum_paid_leave = number_format($sum_paid_leave, 2, '.', ',');
            $f_sum_ssf_employer = number_format($sum_ssf_employer, 2, '.', ',');
            $f_sum_other_deductions = number_format($sum_other_deductions, 2, '.', ',');
            $f_sum_ssf_amount = number_format($sum_ssf_amount, 2, '.', ',');
            $f_sum_tax = number_format($sum_tax, 2, '.', ',');
            $f_sum_salary_advance = number_format($sum_salary_advance, 2, '.', ',');
            $f_sum_loan_repayment = number_format($sum_loan_repayment, 2, '.', ',');
            $f_sum_absent = number_format($sum_absent, 2, '.', ',');
            $f_sum_total_allowance = number_format($sum_total_allowance, 2, '.', ',');
            $f_sum_total_overtime = number_format($sum_total_overtime, 2, '.', ',');
            $f_sum_total_emolument = number_format($sum_total_emolument, 2, '.', ',');
            $f_sum_total_deductions = number_format($sum_total_deductions, 2, '.', ',');
            $f_sum_net_salary = number_format($sum_net_salary, 2, '.', ',');
            
            $pdf->SetFont('Arial','BI',9);
            $pdf->Cell(110,5,'GRAND TOTAL',1,0);
            $pdf->Cell(25,5,$f_sum_basic_salary,1,0,'R');
            $pdf->Cell(15,5,$f_sum_fuel_allowance,1,0,'R');
            $pdf->Cell(15,5,$f_sum_clothing_allowance,1,0,'R');
            $pdf->Cell(15,5,$f_sum_other_allowance,1,0,'R');
            $pdf->Cell(15,5,$f_sum_salary_arrears,1,0,'R');
            $pdf->Cell(25,5,$f_sum_total_emolument,1,0,'R');
            $pdf->Cell(15,5,$f_sum_welfare,1,0,'R');
            $pdf->Cell(15,5,$f_sum_ssf_amount,1,0,'R');
            $pdf->Cell(15,5,$f_sum_ssf_employer,1,0,'R');
            $pdf->Cell(15,5,$f_sum_tax,1,0,'R');
            $pdf->Cell(15,5,$f_sum_salary_advance,1,0,'R');
            $pdf->Cell(15,5,$f_sum_loan_repayment,1,0,'R');
            $pdf->Cell(15,5,$f_sum_absent,1,0,'R');
            $pdf->Cell(25,5,$f_sum_other_deductions,1,0,'R');
            $pdf->Cell(25,5,$f_sum_total_deductions,1,0,'R');
            $pdf->Cell(25,5,$f_sum_net_salary,1,1,'R');
        }
        else
        {
            $pdf->Cell(405,10,'No Pay Slip for the selected location',0,1,'C');
        };
        $pdf->Output();
    };
?>