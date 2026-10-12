<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    global $con;

    $company_id = $_SESSION['company_id'];
    $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
    $result_company = mysqli_query($con,$sql_company);
    $row_company = mysqli_fetch_array($result_company);

    $lab_request_id = $_SESSION['lab_request_id'];
    $query_ed = "SELECT * FROM lab_request WHERE lab_request_id ='$lab_request_id'";
    $query_run_ed = mysqli_query($con,$query_ed);
    $row_ed = mysqli_fetch_assoc($query_run_ed);

    $patient_id = $row_ed['patient_id'];
    $query_patient = "SELECT * FROM patients WHERE patient_id='$patient_id'";
    $query_run_patient = mysqli_query($con, $query_patient);
    $row_patient=mysqli_fetch_assoc($query_run_patient);

    $gender_id = $row_patient['gender'];
    $query_gender = "SELECT * FROM gender WHERE gender_id='$gender_id'";
    $query_run_gender = mysqli_query($con, $query_gender);
    $row_gender = mysqli_fetch_assoc($query_run_gender);

    $user_id = $row_ed['doctor'];
    $query_doctor = "SELECT * FROM users WHERE id='$user_id'";
    $query_run_doctor = mysqli_query($con, $query_doctor);
    $row_doctor = mysqli_fetch_assoc($query_run_doctor);

    $attend_id = $row_ed['attend_id'];
    $query_attend = "SELECT * FROM attendance WHERE attend_id ='$attend_id' AND patient_id ='$patient_id'";
    $query_run_attend = mysqli_query($con, $query_attend);
    $row_attend = mysqli_fetch_assoc($query_run_attend);

    class PDF extends FPDF
    {
        function Header()
        {
            //Put the watermark
            $image = $_SERVER['DOCUMENT_ROOT'] .'/img/logo.png';
            $this->Image($image,10,5,40,20);
        }
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
    $pdf->Cell(200,5,$row_company['trading_name'],0,1,'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(200,5,$row_company['address'],0,1,'C');
    $pdf->Cell(200,5,$row_company['location'],0,1,'C');
    $pdf->Cell(200,5,$row_company['telephone'],0,1,'C');
    $pdf->Cell(200,5,'',0,1);

    $pdf->SetFont('Arial','BU',14);
    $pdf->Cell(200,8,'LABORATORY REQUEST',0,1,'C');
    $pdf->Cell(200,10,'',0,1);

    $pdf->SetFont('Arial','',10);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(100,7,'Name: '.$row_patient['firstName']." ".$row_patient['lastName'],0,0);
    $pdf->Cell(100,7,'Doctor: '.$row_ed['doctor'],0,1);
    
    $pdf->SetFont('Arial','B',10);
    $pdf->SetLineWidth(0.1);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(50,7,'Age: '.$row_ed['age'],0,0);
    $pdf->Cell(50,7,'Gender: '.$row_gender['gender'],0,0);
    $pdf->Cell(100,7,'Date: '.$row_ed['date'],0,1);
    $pdf->Cell(200,10,'',0,1);

    $pdf->SetFont('Arial','B',10);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(200,5,'Laboratory Test:',0,1);
    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(200,7,$row_ed['lab_test'],0,1);
    $pdf->Cell(200,5,'',0,1);
    
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(200,5,'Specimen:',0,1);
    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(200,7,$row_ed['specimen'],0,1);
    $pdf->Cell(200,5,'',0,1);

    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(200,5,'Specimen Date:',0,1);
    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(200,7,$row_ed['specimen_date'],0,1);
    $pdf->Cell(200,10,'',0,1);

    $pdf->SetFont('Arial','B',10);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(200,5,'Diagnosis:',0,1);
    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(200,7,$row_ed['diagnosis'],0,1);
    $pdf->Cell(200,10,'',0,1);

    $pdf->SetFont('Arial','B',10);
    $pdf->SetLineWidth(0.1);
    $pdf->Cell(200,5,'Clinical Summary:',0,1);
    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(200,7,$row_ed['clinical_summary'],0,1);
    $pdf->Cell(200,10,'',0,1);
    
    $pdf->Cell(200,10,'',0,1);
    $pdf->Cell(200,5,'Doctor Signature.......................................................',0,1,'R');
    $pdf->Cell(200,10,'',0,1);
    $pdf->Cell(200,5,'Date:.............................'.$row_ed['date'].'..........................',0,1,'R');

    $pdf->Output();
?>