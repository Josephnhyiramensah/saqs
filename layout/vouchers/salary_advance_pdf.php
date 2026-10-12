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
    
    if(isset($_SESSION['salary_advance_id']))
    {
        $company_id = $_SESSION['company_id'];
        $salary_advance_id = $_SESSION['salary_advance_id'];
    
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
        $pdf->Cell(189,5,'SALARY ADVANCE VOUCHER',0,1,'C');
        $pdf->Cell(189,5,'',0,1,'C');
        
        $query_sa = "SELECT * FROM payroll_salary_advance WHERE salary_advance_id = '$salary_advance_id'";
        $query_run_sa = mysqli_query($con, $query_sa);
        if(!empty($query_run_sa) && mysqli_num_rows($query_run_sa) > 0 )
        {
            $row_sa = mysqli_fetch_array($query_run_sa);
            $employee_id = $row_sa['employee_id'];
            $amount = $row_sa['amount'];
            $narration = $row_sa['narration'];
            $credit_ledger = $row_sa['credit_ledger'];
            $date = $row_sa['date'];

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
            $amount = 0;
            $credit_ledger = 0;
            $interest_type = 0;
            $employee_name = 'Not Specified';
            $narration = 'Not Specified';
            $date = 'Not Specified';
        };

        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(189,5,'Payee: ',0,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->SetLineWidth(0.1);

        $pdf->Cell(10,5,'',0,0);
        $pdf->Cell(69,5,$employee_name,0,0);
        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(55,5,'Transaction Date: '.$date,0,0);
        $pdf->Cell(55,5,'Effective: ',0,1);

        $amount_f = number_format($amount, 2, '.', ',');
        $pdf->Cell(10,5,'',0,0);
        $pdf->Cell(69,5,'',0,0);
        $pdf->Cell(55,5,'Amount: '.$row_company['currency'].''.$amount_f,0,0);
        $pdf->Cell(55,5,'Percentage:',0,1);

        $pdf->Cell(10,5,'',0,0);
        $pdf->Cell(69,5,'',0,0);
        $pdf->Cell(55,5,'Printed on:'.date('Y-m-d h-m-sa'),0,0);
        $pdf->Cell(55,5,'Duration:',0,1);
        $pdf->Cell(189,5,'',0,1);

        $pdf->Output();
    };
?>