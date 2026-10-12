<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    //include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    
    $company_id = $_SESSION['company_id'];
    $attend_id = $_SESSION['attend_id'];
    $patient_id = $_SESSION['patient_id'];

    $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
    $result_company = mysqli_query($con,$sql_company);
    $row_company = mysqli_fetch_array($result_company);

    $sql_attend = "SELECT * FROM attendance WHERE attend_id = '$attend_id'";
    $result_attend = mysqli_query($con,$sql_attend);
    $row_attend = mysqli_fetch_array($result_attend);

    $query_patient = "SELECT * FROM patients WHERE patient_id ='$patient_id'";
    $query_run_patient = mysqli_query($con, $query_patient);
    $row_patient = mysqli_fetch_assoc($query_run_patient);

    $gender_id = $row_patient['gender'];
    $query_gender = "SELECT * FROM `gender` WHERE `gender_id` = '$gender_id'";
    $query_run_gender = mysqli_query($con, $query_gender);
    $row_gender = mysqli_fetch_assoc($query_run_gender);

    
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
    $pdf->SetFont('Arial','B',14);
    //Cell(width, height, text, border, end line, align)
    $pdf->Cell(209,5,$row_company['trading_name'],0,1,'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(209,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
    $pdf->Cell(209,5,$row_company['telephone'],0,1,'C');
    //$pdf->Cell(75,10,'LOGO',0,1,'C');
    $pdf->Cell(209,10,'',0,1);

    $pdf->SetFont('Arial','BU',12);
    $pdf->Cell(209,8,'Drug Prescription Form',0,1,'C');
    $pdf->Cell(209,10,'',0,1);

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(89,5,'Patient Name: '.$row_patient['firstName'].' '.$row_patient['lastName'],0,0);
    $pdf->Cell(60,5,'Age: '.$row_attend['age'],0,0);
    $pdf->Cell(60,5,'Date: '.$row_attend['date_admit'],0,1);
    $pdf->Cell(89,5,'Gender: '.$row_gender['gender'],0,0);
    $pdf->Cell(60,5,'Telephone: '.$row_patient['telephone'],0,0);
    $pdf->Cell(209,15,'',0,1);

    $pdf->SetFont('Arial','BU',10);
    $pdf->Cell(139,5,'DRUG PRESCRIPTION',0,0);
    $pdf->Cell(35,5,'DOSAGE',0,0,'C');
    $pdf->Cell(35,5,'QTY',0,1,'C');

    $query = "SELECT * FROM drug_list WHERE attend_id='$attend_id' /*AND qty_presc > qty_dispensed*/";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        while($row_drug_list = mysqli_fetch_assoc($query_run))
        {
            $drug_id = $row_drug_list['drug_id'];
            $qty_presc = $row_drug_list['qty_presc'];
            //$qty_dispensed = $row_drug_list['qty_dispensed'];
            //$qty = $qty_presc - $qty_dispensed;
            $drug_list_id = $row_drug_list['drug_list_id'];

            $query_dispensed = "SELECT SUM(qty) AS qty_disp FROM drug_dispense_list 
                    WHERE attend_id='$attend_id'  
                    AND drug_list_id='$drug_list_id'";
            $query_run_dispensed = mysqli_query($con, $query_dispensed);
            if (mysqli_num_rows($query_run_dispensed) > 0)
            {
                $row_dispensed = mysqli_fetch_assoc($query_run_dispensed);
                $qty_dispensed = $row_dispensed['qty_disp'];
            }
            else
            {
                $qty_dispensed = 0;
            };
            
            $qty = $qty_presc - $qty_dispensed;
            
            if($qty > 0)
            {
                $query = "SELECT * FROM stock_items WHERE stock_item_id='$drug_id'";
                $query_run_drug = mysqli_query($con, $query);
                $row_drug = mysqli_fetch_assoc($query_run_drug);
                $pdf->SetFont('Arial','I',10);
                $pdf->Cell(139,5,$row_drug['stock_item'],0,0);
                $pdf->Cell(35,5,$row_drug_list['dosage'],0,0,'C');
                $pdf->Cell(35,5,$qty,0,1,'C');
            };
        };
    }
    else
    {
        $pdf->Cell(209,5,'No Drug on prescription',0,1,'C');
    };
$pdf->Cell(209,5,'',0,1);
$pdf->Cell(209,5,'',0,1);
$pdf->Cell(209,5,'',0,1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(209,5,'CLINICIAN/MEDICAL OFFICER',0,1,'C');
$pdf->Cell(209,5,'',0,1);
$pdf->Cell(209,5,'',0,1);
$pdf->Cell(209,5,'.......................................................................',0,1,'C');

$pdf->Output();
?>