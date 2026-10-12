<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    global $con;
    $company_id = $_SESSION['company_id'];
    $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
    $result_company = mysqli_query($con,$sql_company);
    $row_company = mysqli_fetch_array($result_company);

    $receipt_id = $_SESSION['receipt_id'];
    $query_receipt = "SELECT * FROM receipt WHERE receipt_id='$receipt_id'";
    $query_run_receipt = mysqli_query($con,$query_receipt);
    $row_receipt = mysqli_fetch_assoc($query_run_receipt);

    $patient_id = $row_receipt['patient_id'];
    $query_patient = "SELECT * FROM patients WHERE patient_id='$patient_id'";
    $query_run_patient = mysqli_query($con, $query_patient);
    $row_patient=mysqli_fetch_assoc($query_run_patient);

    $attend_id = $row_receipt['attend_id'];
    $query_attend = "SELECT * FROM attendance WHERE attend_id ='$attend_id' AND patient_id ='$patient_id'";
    $query_run_attend = mysqli_query($con, $query_attend);
    $row_attend = mysqli_fetch_assoc($query_run_attend);

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
    $pdf = new PDF('P','mm',array(80,200));
    $pdf->SetMargins(2.5,2.5,2.5);
    //$pdf->AliasNbPages('{pages}');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    //Cell(width, height, text, border, end line, align)
    $pdf->Cell(75,5,$row_company['trading_name'],0,1,'C');
    $pdf->Cell(75,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
    $pdf->Cell(75,5,$row_company['telephone'],0,1,'C');
    //$pdf->Cell(75,10,'LOGO',0,1,'C');
    $pdf->Cell(75,5,'',0,1);

    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(75,8,'OFFICIAL RECEIPT',0,1,'C');

    $pdf->SetFont('Arial','',8);
    $pdf->Cell(38,5,'Receipt No: '.$receipt_id,0,0);
    $pdf->Cell(37,5,'Date: '.$row_receipt['date'],0,1);
    $pdf->Cell(20,5,'Patient Name:',0,0);

    $fontsize = 8;
    $tempfontsize = $fontsize;
    $CellWidth = 55;
    $name = $row_patient['firstName']." ".$row_patient['lastName'];
    while ($pdf->GetStringWidth($name) > $CellWidth) {
        $pdf->SetFontSize($tempfontsize -=0.1);
    }
    $pdf->Cell($CellWidth,5,$name,0,1);
    $pdf->SetFontSize($fontsize);
    $pdf->Cell(75,5,'Folder No:'.$row_patient['folderNo'],0,1);
    $pdf->Cell(75,5,'',0,1);

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(55,5,'Description',1,0);
    $pdf->Cell(20,5,'Amount',1,1,'C');

    $pdf->SetFont('Arial','',8);
    $query_receipt_item = "SELECT * FROM receipt_items WHERE receipt_id='$receipt_id'";
    $query_run_receipt_item = mysqli_query($con,$query_receipt_item);
    if (mysqli_num_rows($query_run_receipt_item) > 0)
    {
        while($row_receipt_item = mysqli_fetch_assoc($query_run_receipt_item))
        {
            $item_id = $row_receipt_item['item_id'];
            $category_id = $row_receipt_item['category_id'];
            if ($category_id == 1 /*SERVICE*/) {
                $query_item = "SELECT * FROM services WHERE service_id ='$item_id'";
                $query_run_item = mysqli_query($con,$query_item);
                if (mysqli_num_rows($query_run_item) > 0)
                {
                    $row_item = mysqli_fetch_assoc($query_run_item);
                    $item = $row_item['service'];
                };
            }
            else if ($category_id == 2 /*DRUGS*/) {
                $query_item = "SELECT * FROM drugs WHERE drug_id ='$item_id'";
                $query_run_item = mysqli_query($con,$query_item);
                if (mysqli_num_rows($query_run_item) > 0)
                {
                    $row_item = mysqli_fetch_assoc($query_run_item);
                    $item = $row_item['brand_name'];
                };
            }
            else if ($category_id == 3 /*LAB*/) {
                $query_item = "SELECT * FROM lab WHERE lab_id ='$item_id'";
                $query_run_item = mysqli_query($con,$query_item);
                if (mysqli_num_rows($query_run_item) > 0)
                {
                    $row_item = mysqli_fetch_assoc($query_run_item);
                    $item = $row_item['lab'];
                };
            }
            else if ($category_id == 4 /*RADIOLOGY*/) {
                $query_item = "SELECT * FROM radiology WHERE radio_id  ='$item_id'";
                $query_run_item = mysqli_query($con,$query_item);
                if (mysqli_num_rows($query_run_item) > 0)
                {
                    $row_item = mysqli_fetch_assoc($query_run_item);
                    $item = $row_item['radiology'];
                };
            }
            else if ($category_id == 5 /*SURGERIES/PROCEDURES*/) {
                $query_item = "SELECT * FROM surgery WHERE surgery_id ='$item_id'";
                $query_run_item = mysqli_query($con,$query_item);
                if (mysqli_num_rows($query_run_item) > 0)
                {
                    $row_item = mysqli_fetch_assoc($query_run_item);
                    $item = $row_item['surgery'];
                };
            }
            else if ($category_id == 7 /*CONSUMABLES*/) {
                $query_item = "SELECT * FROM consumable WHERE con_id ='$item_id'";
                $query_run_item = mysqli_query($con,$query_item);
                if (mysqli_num_rows($query_run_item) > 0)
                {
                    $row_item = mysqli_fetch_assoc($query_run_item);
                    $item = $row_item['consumable'];
                };
            };
            if($item =='')
            {
                $particulars = 'Payment on account';
            }
            else
            {
                $particulars = $item;
            }
            $pdf->Cell(55,5,$particulars,1,0);
            $pdf->Cell(20,5,$row_receipt_item['amount_rec'],1,1,'R');
        };
    };
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(55,5,'TOTAL',0,0);
    $pdf->Cell(20,5,$row_receipt['amount'],1,1,'R');

    $pdf->Output();
?>