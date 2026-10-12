<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    global $con;

    $company_id = $_SESSION['company_id'];
    $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
    $result_company = mysqli_query($con,$sql_company);
    $row_company = mysqli_fetch_array($result_company);

    $excuse_duty_id = $_SESSION['excuse_duty_id'];
    $query_ed = "SELECT * FROM excuse_duty WHERE excuse_duty_id ='$excuse_duty_id'";
    $query_run_ed = mysqli_query($con,$query_ed);
    $row_ed = mysqli_fetch_assoc($query_run_ed);

    $patient_id = $row_ed['patient_id'];
    $query_patient = "SELECT * FROM patients WHERE patient_id='$patient_id'";
    $query_run_patient = mysqli_query($con, $query_patient);
    $row_patient=mysqli_fetch_assoc($query_run_patient);

    $user_id = $row_ed['doctor'];
    $query_doctor = "SELECT * FROM users WHERE id='$user_id'";
    $query_run_doctor = mysqli_query($con, $query_doctor);
    $row_doctor = mysqli_fetch_assoc($query_run_doctor);

    $attend_id = $row_ed['attend_id'];
    $query_attend = "SELECT * FROM attendance WHERE attend_id ='$attend_id' AND patient_id ='$patient_id'";
    $query_run_attend = mysqli_query($con, $query_attend);
    $row_attend = mysqli_fetch_assoc($query_run_attend);
    
    $logo = $_SERVER['DOCUMENT_ROOT'] .'/img/logo.png';
    class PDF extends FPDF
    {
        function Footer()
        {
            // Go to 1.5 cm from bottom
            $this->SetY(-15);
            // Select Arial italic 8
            $this->SetFont('Arial','I',8);
            // Print centered page number
            //$this->Cell(0,10,'Page '.$this->PageNo().' - {pages}',0,0,'C');
        }
    }
    //A4 width: 219mm
    //default margin: 10mm each side
    //Writable horizontal: 219mm - (10mm*2) = 189mm
    $pdf = new PDF('P','mm','A4');
    $pdf->SetMargins(5,5,5);
    //$pdf->AliasNbPages('{pages}');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
    //Cell(width, height, text, border, end line, align)
	$pdf->Image($logo,10,10,40,15);
    $pdf->Cell(200,5,$row_company['trading_name'],0,1,'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(200,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
    $pdf->Cell(200,5,$row_company['telephone'],0,1,'C');
    $pdf->Cell(200,10,'',0,1);

    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(200,8,'EXCUSE DUTY',0,1,'C');
    $pdf->Cell(200,10,'',0,1);

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(100,5,'Patient Name:',0,0);
    $pdf->Cell(100,5,'Doctor:',0,1);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(100,7,$row_patient['firstName']." ".$row_patient['lastName'],1,0);
    $pdf->Cell(100,7,$row_doctor['first_name'],1,1);
    $pdf->Cell(200,5,'',0,1);
    
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(100,5,'Date Admitted:',0,0);
    $pdf->Cell(100,5,'Date Discharged:',0,1);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(100,7,$row_ed['date_admit'],1,0);
    $pdf->Cell(100,7,$row_ed['date_discharged'],1,1);
    $pdf->Cell(200,5,'',0,1);

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(200,5,'Diagnosis:',0,1);
    $pdf->SetFont('Arial','',8);
    $pdf->MultiCell(200,25,$row_ed['diagnosis'],1,1);
    $pdf->Cell(200,5,'',0,1);

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(200,5,'Remarks:',0,1);
    $pdf->SetFont('Arial','',8);
    $pdf->MultiCell(200,25,$row_ed['narration'],1,1);
    
    $pdf->Cell(200,15,'',0,1);
    $pdf->Cell(100,5,'',0,0);
    $pdf->Cell(100,5,'Doctor Signature.......................................................',0,1,'R');
    $pdf->Cell(200,5,'',0,1);
    $pdf->Cell(100,5,'',0,0);
    $pdf->Cell(100,5,'Date:.............................'.$row_ed['date'].'..........................',0,1,'R');

    $pdf->Output();
?>