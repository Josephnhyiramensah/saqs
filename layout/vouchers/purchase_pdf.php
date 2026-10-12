<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf.php');
    global $con;

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
    $pdf = new PDF('P','mm',array(80,140));
    $pdf->SetMargins(2.5,2.5,2.5);
    //$pdf->AliasNbPages('{pages}');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    //Cell(width, height, text, border, end line, align)
    if(isset($_SESSION['purch_display_purchase_id']))
    {
        $company_id = $_SESSION['purch_display_company_id'];
        $user_id = $_SESSION['purch_display_user_id'];
        $user_super_id = $_SESSION['purch_display_user_super_id'];
        $purchase_id = $_SESSION['purch_display_purchase_id'];
        $ledger_credit_id = $_SESSION['purch_display_ledger_credit_id'];

        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);

        $sql_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_credit_id'";
        $result_ledger = mysqli_query($con,$sql_ledger);
        $row_ledger = mysqli_fetch_array($result_ledger);

        $pdf->Cell(75,5,$row_company['trading_name'],0,1,'C');
        $pdf->Cell(75,5,$row_company['location'].', '. $row_company['telephone'],0,1,'C');
        //$pdf->Cell(75,10,'LOGO',0,1,'C');
        $pdf->Cell(75,5,'',0,1);

        $pdf->SetFont('Arial','BU',12);
        $pdf->Cell(75,8,'PURCHASE INVOICE',0,1,'C');

        $query = "SELECT * FROM purchases WHERE purchase_id = '$purchase_id'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            $row = mysqli_fetch_assoc($query_run);

            $pdf->SetFont('Arial','',8);
            $pdf->Cell(38,5,'Invoice No: '.$row['sno'],0,0);
            $pdf->Cell(37,5,'Date: '.$row['date'],0,1);
            $pdf->Cell(38,5,'Supplier:'.$row['supplier'],0,0);
            $pdf->Cell(37,5,'Telephone:'.$row['phone'],0,1);
            $pdf->Cell(20,5,'Location:'.$row['location'],0,1);
            $pdf->Cell(75,5,'',0,1);
            $pdf->Cell(20,5,'Grams:',0,0);

            $pdf->SetFont('Arial','BIU',15);
            $pdf->Cell(20,5,$row['weight_both'],0,1);

            $pdf->Cell(75,5,'',0,1);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(20,5,'Water Weight:',0,0);

            $pdf->SetFont('Arial','BI',15);
            $pdf->Cell(20,5,$row['water'],0,1);
            
            $pdf->Cell(75,5,'',0,1);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(38,5,'Pound:'.$row['pounds'],0,0);
            $pdf->Cell(37,5,'Karat:'.$row['karat'],0,1);
            $pdf->Cell(38,5,'Density:'.$row['density'],0,0);
            $pdf->Cell(37,5,'Purity:'.$row['purity'],0,1);
            $pdf->Cell(38,5,'Pieces:'.$row['pieces'],0,0);

            $price_purchase = $row['price'];
            $price_purchase = number_format($price_purchase, 2, '.', ',');
            $pdf->Cell(37,5,'Price:'.$row_company['currency'].''.$price_purchase,0,1);
    
            $pdf->Cell(75,5,'',0,1);
            $ppp_purchase = $row['price_per_pound'];
            $ppp_purchase = number_format($ppp_purchase, 2, '.', ',');
            $pdf->Cell(75,5,'Price Per Pound:'.$row_company['currency'].''.$ppp_purchase,0,1,'C');

            if($row_ledger['show_balance'] == 'yes')
            {
                $ledger_id = $row_ledger['ledger_id'];
                $total_debit = 0;
                $total_credit = 0;
                $balance = 0;
                $sql_trans = "SELECT * FROM transactions WHERE ledger_id = '$ledger_credit_id'";
                $result_trans = mysqli_query($con,$sql_trans);
                if(mysqli_num_rows($result_trans) > 0)
                {
                    while($row_trans = mysqli_fetch_array($result_trans))
                    {
                        $total_debit = $total_debit + $row_trans['amount_debit'];
                        $total_credit = $total_credit + $row_trans['amount_credit'];
                    };
                    if($row_ledger['tb_2'] == 1)
                    {
                        $balance = $total_debit - $total_credit;
                    }
                    else if($row_ledger['tb_2'] == 2)
                    {
                        $balance = $total_credit - $total_debit;
                    };
                }
                else
                {
                    $balance = 0;
                }
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(75,5,'',0,1);
                $balance_f = number_format($balance, 2, '.', ',');
                $pdf->Cell(75,5,$row_ledger['ledger_desc']."'s Balance:".$row_company['currency'].''.$balance_f,0,1,'C');
            };
            
            $pdf->Cell(75,5,'',0,1);
            $amount_purchase = $row['amount'];
            $amount_purchase = number_format($amount_purchase, 2, '.', ',');
            $pdf->SetFont('Arial','B',18);
            $pdf->Cell(75,5, $row_company['currency'].''.$amount_purchase,0,1,'C');
            $pdf->SetFont('Arial','I',6);
            $pdf->Cell(75,5, 'Thanks for doing business with us!',0,1,'C');
        };
    };

    $pdf->Output();
?>