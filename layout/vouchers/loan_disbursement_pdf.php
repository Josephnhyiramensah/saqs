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
            $this->Cell(189,5,'Printed by: '.$user_name.' on '.date('Y-m-d h:m:sa'),0,1,'C');
        }
    }
	date_default_timezone_set("Africa/Accra");

    $pdf = new PDF('P','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    $pdf->Image($image,10,10,15,15);
    
    if(isset($_SESSION['loan_disburse_id']))
    {
        $company_id = $_SESSION['company_id'];
        $loan_disburse_id = $_SESSION['loan_disburse_id'];
    
        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);

        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(189,10,$row_company['trading_name'],0,1,'C');
        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(189,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
        $pdf->Cell(189,5,$row_company['telephone'],0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(189,5,'',0,1,'C');
        $pdf->Cell(189,5,'LOAN DISBURSEMENT VOUCHER',0,1,'C');
        $pdf->Cell(189,5,'',0,1,'C');
        
        $query_loan_disburse = "SELECT * FROM payroll_loan_disburse WHERE loan_disburse_id = '$loan_disburse_id'";
        $query_run_loan_disburse = mysqli_query($con, $query_loan_disburse);
        if(!empty($query_run_loan_disburse) && mysqli_num_rows($query_run_loan_disburse) > 0 )
        {
            $row_loan_disburse = mysqli_fetch_array($query_run_loan_disburse);
            $employee_id = $row_loan_disburse['employee_id'];
            $principal = $row_loan_disburse['principal'];
            $interest_rate = $row_loan_disburse['interest_rate'];
            $duration = $row_loan_disburse['duration'];
            $interest_type = $row_loan_disburse['interest_type'];
            $effective_date = $row_loan_disburse['effective_date'];
            $date = $row_loan_disburse['date'];

            $sql_employee="SELECT * FROM payroll_employee WHERE employee_id = '$employee_id'";
            $result_employee = mysqli_query($con, $sql_employee);
            if(!empty($result_employee) && mysqli_num_rows($result_employee) > 0 )
            {
                $row_employee = mysqli_fetch_array($result_employee);
                $employee_name = $row_employee['first_name'].' '.$row_employee['last_name'];
            };
        }
        else
        {
            $principal = 0;
            $interest_rate = 0;
            $duration = 0;
            $interest_type = 0;
            $employee_name = 'Not Specified';
            $effective_date = 'Not Specified';
            $date = 'Not Specified';
        };

        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(189,5,'Address To: ',0,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->SetLineWidth(0.1);

        $pdf->Cell(10,5,'',0,0);
        $pdf->Cell(69,5,$employee_name,0,0);
        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(55,5,'Transaction Date: '.$date,0,0);
        $pdf->Cell(55,5,'Effective: '.$effective_date,0,1);

        $principal_f = number_format($principal, 2, '.', ',');
        $pdf->Cell(10,5,'',0,0);
        $pdf->Cell(69,5,'',0,0);
        $pdf->Cell(55,5,'Principal: '.$row_company['currency'].''.$principal_f,0,0);
        $pdf->Cell(55,5,'Percentage:'.$interest_rate.'%, '.$interest_type,0,1);

        $pdf->Cell(10,5,'',0,0);
        $pdf->Cell(69,5,'',0,0);
        $pdf->Cell(55,5,'Printed on:'.date('Y-m-d h-m-sa'),0,0);
        $pdf->Cell(55,5,'Duration:'.$duration.'month(s)',0,1);
        $pdf->Cell(189,5,'',0,1);

        $query = "SELECT * FROM payroll_loan_schedule WHERE loan_disburse_id = '$loan_disburse_id' ORDER BY date ASC";
        $query_run = mysqli_query($con, $query);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(10,5,'S/No',1,0,'C');
        $pdf->Cell(20,5,'Date',1,0,'C');
        $pdf->Cell(30,5,'Start Principal',1,0,'C');
        $pdf->Cell(20,5,'Repayment',1,0,'C');
        $pdf->Cell(20,5,'Extra',1,0,'C');
        $pdf->Cell(20,5,'Total Repay.',1,0,'C');
        $pdf->Cell(20,5,'Interest',1,0,'C');
        $pdf->Cell(20,5,'Princ. Paym.',1,0,'C');
        $pdf->Cell(29,5,'End Principal',1,1,'C');

        $pdf->SetFont('Arial','I',8);
        $i = 0;
        $sum_repayment = 0;
        $sum_interest_payment = 0;
        $sum_principal_payment = 0;

        if (!empty($query_run) && mysqli_num_rows($query_run) > 0)
        {
            while($row = mysqli_fetch_assoc($query_run))
            {
                $i++;
                $sum_repayment = $sum_repayment + $row['repayment'];
                $sum_interest_payment = $sum_interest_payment + $row['interest_payment'];
                $sum_principal_payment = $sum_principal_payment + $row['principal_payment'];

                $principal_begining_f = number_format($row['principal_begining'], 2, '.', ',');
                $repayment_f = number_format($row['repayment'], 2, '.', ',');
                $extra_payment_f = number_format($row['extra_payment'], 2, '.', ',');
                $total_payment_f = number_format($row['total_payment'], 2, '.', ',');
                $principal_payment_f = number_format($row['principal_payment'], 2, '.', ',');
                $interest_payment_f = number_format($row['interest_payment'], 2, '.', ',');
                $principal_remaining_f = number_format($row['principal_remaining'], 2, '.', ',');

                $pdf->Cell(10,5,$i,1,0,'C');
                $pdf->Cell(20,5,$row['date'],1,0,'C');
                $pdf->Cell(30,5,$principal_begining_f,1,0,'R');
                $pdf->Cell(20,5,$repayment_f,1,0,'R');
                $pdf->Cell(20,5,$extra_payment_f,1,0,'R');
                $pdf->Cell(20,5,$total_payment_f,1,0,'R');
                $pdf->Cell(20,5,$interest_payment_f,1,0,'R');
                $pdf->Cell(20,5,$principal_payment_f,1,0,'R');
                $pdf->Cell(29,5,$principal_remaining_f,1,1,'R');
            };
            
            $sum_repayment_f = number_format($sum_repayment, 2, '.', ',');
            $sum_interest_payment_f = number_format($sum_interest_payment, 2, '.', ',');
            $sum_principal_payment_f = number_format($sum_principal_payment, 2, '.', ',');

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(60,5,'Total',1,0,'C');
            $pdf->Cell(20,5,$sum_repayment_f,1,0,'R');
            $pdf->Cell(20,5,'',1,0,'R');
            $pdf->Cell(20,5,'',1,0,'R');
            $pdf->Cell(20,5,$sum_interest_payment_f,1,0,'R');
            $pdf->Cell(20,5,$sum_principal_payment_f,1,0,'R');
            $pdf->Cell(29,5,'',1,1,'R');
        };
        $pdf->Output();
    };
?>