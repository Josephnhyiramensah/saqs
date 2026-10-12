<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    global $con;
    $logo = $_SERVER['DOCUMENT_ROOT'] .'/img/company_logo.png';
    class PDF extends FPDF
    {
        function Footer()
        {
            // Go to 1.5 cm from bottom
            $this->SetY(-5);
            // Select Arial italic 8
            $this->SetFont('Arial','BI',5);
            // Print centered page number
            //$this->Cell(0,10,'Page '.$this->PageNo().' - {pages}',0,0,'C');
            $this->Cell(70,5,'HealthNotes: 0244897809, 0275690023',0,1,'C');
        }
    }
    //A4 width: 219mm
    //default margin: 10mm each side
    //Writable horizontal: 219mm - (10mm*2) = 189mm
    $pdf = new PDF('P','mm',array(80,150));
    $pdf->SetMargins(2.5,2.5,2.5);
    //$pdf->AliasNbPages('{pages}');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    //Cell(width, height, text, border, end line, align)
    if(isset($_SESSION['receipt_id']))
    {	
        date_default_timezone_set("Africa/Accra");
        $date_time = date('Y-m-d h:i:sa');
        $company_id = $_SESSION['company_id'];
        $receipt_id = $_SESSION['receipt_id'];

        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);

        $pdf->Cell(70,5,$row_company['trading_name'],0,1,'C');
        $pdf->Cell(70,5,$row_company['location'].' '.$row_company['telephone'],0,1,'C');
        //$pdf->Cell(70,5,$row_company['location'],0,1,'C');
        //$pdf->Image($logo,INDENT LR,INDENT TO,W,H);
        $pdf->Image($logo,30,13,15,15);
        $pdf->Cell(70,15,'',0,1);
        //$pdf->Cell(75,10,'LOGO',0,1,'C');
        $pdf->Cell(70,5,'',0,1);

        $pdf->SetFont('Arial','BU',14);
        $pdf->Cell(70,8,'OFFICIAL RECEIPT',0,1,'C');

        $query = "SELECT * FROM receipt WHERE receipt_id = '$receipt_id'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            $row = mysqli_fetch_assoc($query_run);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(35,5,'Receipt No: '.$row['receipt_id'],0,0);
            $pdf->Cell(35,5,'Date: '.$row['date'],0,1);
            $pdf->Cell(70,5,'Received from:'.$row['name'],0,1);
            $pdf->Cell(70,5,'Amount:Ghc'.$row['amount'],0,1);
            //$pdf->MultiCell(70,5,'Narration:'.$row['narration'],0,1);

            $query_receipt_items = "SELECT * FROM receipt_category_list WHERE receipt_id = '$receipt_id'";
            $query_run_receipt_items = mysqli_query($con, $query_receipt_items);
            if (mysqli_num_rows($query_run_receipt_items) > 0)
            {
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(45,5,'Category',1,0,'C');
                $pdf->Cell(25,5,'Amount',1,1,'C');
                $total_amount = 0;
                while($row_receipt_items = mysqli_fetch_assoc($query_run_receipt_items))
                {
                    $receipt_cat_id = $row_receipt_items['receipt_cat_id'];
                    $amount = $row_receipt_items['amount'];
                    $amount_f = number_format($amount, 2, '.', ',');

                    $query_item = "SELECT * FROM receipt_category WHERE receipt_category_id  = '$receipt_cat_id'";
                        $query_run_item = mysqli_query($con, $query_item);
                        $row_item = mysqli_fetch_assoc($query_run_item);
                        $category = $row_item['category'];

                    $pdf->SetFont('Arial','I',8);
                    $pdf->Cell(45,5,$category,1,0);
                    $pdf->Cell(25,5,$amount_f,1,1,'R');
                    $total_amount = $total_amount + $amount;
                };
                $total_amount_f = number_format($total_amount, 2, '.', ',');

                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(45,5,'Total',1,0);
                $pdf->Cell(25,5,$row_company['currency'].''.$total_amount_f,1,1,'R');
            };

            $query_pt = "SELECT * FROM transactions WHERE receipt_id = '$receipt_id' AND amt_debit > 0";
            $query_run_pt = mysqli_query($con, $query_pt);
            if (mysqli_num_rows($query_run_pt) > 0)
            {
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(45,5,'Mode of Payment',1,0,'C');
                $pdf->Cell(25,5,'Amount',1,1,'C');
                $pt_total_amount = 0;
                while($row_pt = mysqli_fetch_assoc($query_run_pt))
                {
                    $ledger_id = $row_pt['ledger_id'];
                    $pt_amount = $row_pt['amt_debit'];
                    $pt_amount_f = number_format($pt_amount, 2, '.', ',');

                    $query_led = "SELECT * FROM ledgers WHERE ledger_id  = '$ledger_id'";
                        $query_run_led = mysqli_query($con, $query_led);
                        $row_led = mysqli_fetch_assoc($query_run_led);
                        $ledger = $row_led['ledger_desc'];

                    $pdf->SetFont('Arial','I',8);
                    $pdf->Cell(45,5,$ledger,1,0);
                    $pdf->Cell(25,5,$pt_amount_f,1,1,'R');
                    $pt_total_amount = $pt_total_amount + $pt_amount;
                };
                $pt_total_amount_f = number_format($pt_total_amount, 2, '.', ',');

                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(45,5,'Total',1,0);
                $pdf->Cell(25,5,$row_company['currency'].''.$pt_total_amount_f,1,1,'R');
            };
            

            /*$query_receipt_items = "SELECT * FROM receipt_items WHERE receipt_id = '$receipt_id'";
            $query_run_receipt_items = mysqli_query($con, $query_receipt_items);
            if (mysqli_num_rows($query_run_receipt_items) > 0)
            {
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(45,5,'Item',1,0,'C');
                $pdf->Cell(25,5,'Amount',1,1,'C');
                $total_amount = 0;
                while($row_receipt_items = mysqli_fetch_assoc($query_run_receipt_items))
                {
                    $item_id = $row_receipt_items['item_id'];
                    $item_list_id = $row_receipt_items['item_list_id'];
                    $category_id = $row_receipt_items['category_id'];
                    if($category_id == 1)
                    {
                        $query_item = "SELECT * FROM services WHERE service_id = '$item_id'";
                        $query_run_item = mysqli_query($con, $query_item);
                        $row_item = mysqli_fetch_assoc($query_run_item);
                        $item = $row_item['service'];
                    }
                    else if($category_id == 2)
                    {
                        $query_item = "SELECT * FROM drugs WHERE drug_id = '$item_id'";
                        $query_run_item = mysqli_query($con, $query_item);
                        $row_item = mysqli_fetch_assoc($query_run_item);
                        $item = $row_item['brand_name'];
                    }
                    else if($category_id == 3)
                    {
                        $query_item = "SELECT * FROM lab WHERE lab_id = '$item_id'";
                        $query_run_item = mysqli_query($con, $query_item);
                        $row_item = mysqli_fetch_assoc($query_run_item);
                        $item = $row_item['lab'];
                    }
                    else if($category_id == 4)
                    {
                        $query_item = "SELECT * FROM radiology WHERE radio_id = '$item_id'";
                        $query_run_item = mysqli_query($con, $query_item);
                        $row_item = mysqli_fetch_assoc($query_run_item);
                        $item = $row_item['radiology'];
                    }
                    else if($category_id == 5)
                    {
                        $query_item = "SELECT * FROM surgery WHERE surgery_id = '$item_id'";
                        $query_run_item = mysqli_query($con, $query_item);
                        $row_item = mysqli_fetch_assoc($query_run_item);
                        $item = $row_item['surgery'];
                    }
                    else if($category_id == 7)
                    {
                        $query_item = "SELECT * FROM consumable WHERE con_id = '$item_id'";
                        $query_run_item = mysqli_query($con, $query_item);
                        $row_item = mysqli_fetch_assoc($query_run_item);
                        $item = $row_item['consumable'];
                    }

                    $pdf->SetFont('Arial','I',8);
                    $pdf->Cell(45,5,$item,1,0);
                    $pdf->Cell(25,5,$row_receipt_items['amount_rec'],1,1,'R');
                    $total_amount = $total_amount + $row_receipt_items['amount_rec'];
                };
                $total_amount_f = number_format($total_amount, 2, '.', ',');

                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(45,5,'Total',1,0);
                $pdf->Cell(25,5,$row_company['currency'].''.$total_amount_f,1,1,'R');
            };*/
            $entered_user = $row['created_by'];
            $query_entered_user = "SELECT * FROM users WHERE id = '$entered_user'";
            $query_run_entered_user = mysqli_query($con, $query_entered_user);
            $row_entered_user = mysqli_fetch_assoc($query_run_entered_user);
            $entered_user_name = $row_entered_user['first_name'];

            $printed_user = $_SESSION['user_id'];
            $query_printed_user = "SELECT * FROM users WHERE id = '$printed_user'";
            $query_run_printed_user = mysqli_query($con, $query_printed_user);
            $row_printed_user = mysqli_fetch_assoc($query_run_printed_user);
            $printed_user_name = $row_printed_user['first_name'];

            $pdf->SetFont('Arial','BI',6);
            //$pdf->Cell(70,5,'Received by:'.$entered_user_name.' - '.$row['created_time'],0,1,'C');
            $pdf->Cell(70,5,'Printed by:'.$printed_user_name.' - '.$date_time,0,1,'C');
            $pdf->Cell(70,5,'',0,1,'C');
            //$pdf->Cell(70,5,'Exceptional Care in Ghana!',0,1,'C');
        };
    };

    $pdf->Output();
?>