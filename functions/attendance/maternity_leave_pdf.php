<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    global $con;

    $patient_id = $_SESSION['patient_id'];
    $preg_id = $_SESSION['preg_id'];
    $company_id = $_SESSION['company_id'];
    $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
    $result_company = mysqli_query($con,$sql_company);
    $row_company = mysqli_fetch_array($result_company);

    $query = "SELECT * FROM maternity_leave WHERE preg_id='$preg_id' AND patient_id='$patient_id'";
    $query_run = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($query_run);

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
    $pdf->Cell(200,8,'MATERNITY LEAVE',0,1,'C');
    $pdf->Cell(200,5,'',0,1);

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(100,5,'Patient Name:',0,0);
    $pdf->Cell(100,5,'Date of Delivery:',0,1);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(100,10,$row['name'],1,0);
    $pdf->Cell(100,10,$row['date_of_delivery'],1,1);
    $pdf->Cell(200,5,'',0,1);

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(200,5,'Remarks:',0,1);
    $pdf->SetFont('Arial','',8);
    //$pdf->MultiCell(200,25,$row['remarks'],1,1);
    $pdf->MultiCell(200,25,$row['remarks'],1,'L',false);
    $pdf->Cell(200,5,'',0,1);

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(100,5,'Date of Issue:',0,0);
    $pdf->Cell(100,5,'Medical Officer:',0,1);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(100,10,$row['date_issue'],1,0);
    $pdf->Cell(100,10,$row['medical_officer'],1,1);
    $pdf->Cell(200,15,'',0,1);
    
    $pdf->Cell(100,5,'',0,0);
    $pdf->Cell(100,5,'Doctor Signature.......................................................',0,1,'R');
   
    $pdf->Output();
?>