<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    
    $company_id = $_SESSION['company_id'];
    $payment_id = $_SESSION['payment_id'];

    function amount_in_words($amount)
    { 
        global $con;
        $payment_id = $_SESSION['payment_id'];
        $query = "SELECT * FROM payment WHERE payment_id = '$payment_id'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            $row = mysqli_fetch_assoc($query_run);
            /*$currency_id = $row['currency_id'];
            $query_currency = "SELECT * FROM currency WHERE currency_id = '$currency_id'";
            $query_run_currency = mysqli_query($con, $query_currency);
            if(!empty($query_run_currency) && mysqli_num_rows($query_run_currency) > 0)
            {
                $row_currency = mysqli_fetch_assoc($query_run_currency);
                $currency = $row_currency['currency'];
                $decimals = $row_currency['decimals'];
            }
            else
            {
                $currency = 'N/A';
                $decimals = 'N/A';
            };*/
            $currency = 'Ghana Cedi';
            $decimals = 'Pesewa';
        }
        else
        {
            $currency = 'N/A';
            $decimals = 'N/A';
        };
    
        //$amount = number_format($amount,2,".",","); 
        $num_arr = explode(".",$amount);
        $number = $num_arr[0];
        if(isset($num_arr[1]))
        {
            $decnum = $num_arr[1];
        }
        else
        {
            $decnum = 0;
        };
        $result = "";
        function convert_number($number)
        {
            if (($number < 0) || ($number > 9999999999999))
            {
                return "$number";
            };

            $Tn = floor($number / 1000000000000); /* Trillions (giga) */
            $number -= $Tn * 1000000000000;
            $Bn = floor($number / 1000000000); /* Billions (giga) */
            $number -= $Bn * 1000000000;
            $Gn = floor($number / 1000000); /* Millions (giga) */
            $number -= $Gn * 1000000;
            $kn = floor($number / 1000); /* Thousands (kilo) */
            $number -= $kn * 1000;
            $Hn = floor($number / 100); /* Hundreds (hecto) */
            $number -= $Hn * 100;
            $Dn = floor($number / 10); /* Tens (deca) */
            $n = $number % 10; /* Ones */
            
            $res = "";
            
            if ($Tn){$res .= convert_number($Tn) . " Trillion";};
            if ($Bn){$res .= (empty($res) ? "" : " ") .convert_number($Bn) . " Billion";};
            if ($Gn){$res .= (empty($res) ? "" : " ") .convert_number($Gn) . " Million";};
            if ($kn){$res .= (empty($res) ? "" : " ") .convert_number($kn) . " Thousand";};
            if ($Hn){$res .= (empty($res) ? "" : " ") .convert_number($Hn) . " Hundred";};
            
            $ones = array("", "One", "Two", "Three", "Four", "Five", "Six","Seven", "Eight", "Nine", 
            "Ten", "Eleven", "Twelve", "Thirteen","Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
            "Nineteen");

            $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");

            $decones = array( '01' => "One", '02' => "Two", '03' => "Three", '04' => "Four", 
                '05' => "Five", '06' => "Six", '07' => "Seven", '08' => "Eight", '09' => "Nine", 
                10 => "Ten", 11 => "Eleven", 12 => "Twelve", 13 => "Thirteen",14 => "Fourteen", 
                15 => "Fifteen", 16 => "Sixteen", 17 => "Seventeen", 18 => "Eighteen", 19 => "Nineteen" 
            );
            
            if ($Dn || $n)
            {
                if (!empty($res)){$res .= " and ";};
                if ($Dn < 2)
                {$res .= $ones[$Dn * 10 + $n];}
                else{$res .= $tens[$Dn];if ($n){$res .= "-" . $ones[$n];};};
            };
            
            if (empty($res)){$res = "zero";};
        
            return $res;
        }

        function convert_decimals($decnum)
        {
            $ones = array("", "One", "Two", "Three", "Four", "Five", "Six","Seven", "Eight", "Nine", 
            "Ten", "Eleven", "Twelve", "Thirteen","Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
            "Nineteen");

            $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");

            $decones = array( '01' => "One", '02' => "Two", '03' => "Three", '04' => "Four", 
                '05' => "Five", '06' => "Six", '07' => "Seven", '08' => "Eight", '09' => "Nine", 
                10 => "Ten", 11 => "Eleven", 12 => "Twelve", 13 => "Thirteen",14 => "Fourteen", 
                15 => "Fifteen", 16 => "Sixteen", 17 => "Seventeen", 18 => "Eighteen", 19 => "Nineteen" 
            );
            $deci = "";
            if($decnum > 0)
            {
                if($decnum < 20)
                { 
                    $deci .= $decones[$decnum]; 
                }
                elseif($decnum < 100)
                { 
                    $deci .= $tens[substr($decnum,0,1)]; 
                    $deci .= "-".$ones[substr($decnum,1,1)]; 
                };
            };
            return $deci; 
        }
        $number_output = convert_number($number);
        $decimal_output = convert_decimals($decnum);
        if($decnum > 0)
        {
            $result = $number_output.' '.$currency.' '.$decimal_output.' '.$decimals;
        }
        else
        {
            $result = $number_output.' Ghana Cedis';
        };
        return $result;
    }
    
    $image = $_SERVER['DOCUMENT_ROOT'] .'/img/company_logo.png';
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
            $this->Image($sign,80,250,50,30);
            $this->SetFont('Arial','I',8);
            $this->Cell(189,5,'Please send payment notification to the Accountant via accountant@aflia.net ',0,1,'C');
            $this->Cell(189,5,"Connecting Africa's library communities",0,1,'C');*/
        }
    }

    $pdf = new PDF('P','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    $pdf->Image($image,10,5,20,20);

    $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
    $result_company = mysqli_query($con,$sql_company);
    $row_company = mysqli_fetch_array($result_company);
    if(isset($payment_id))
    {
        $query = "SELECT * FROM payment WHERE payment_id = '$payment_id'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            $row = mysqli_fetch_assoc($query_run);
            $branch_id = $row['branch_id'];
            $query_b = "SELECT * FROM branch WHERE branch_id='$branch_id'";
            $query_run_b = mysqli_query($con,$query_b);
            $row_b = mysqli_fetch_assoc($query_run_b);

            $pdf->SetFont('Arial','B',18);
            $pdf->Cell(189,5,$row_b['branch_name'],0,1,'C');
            $pdf->SetFont('Arial','I',8);
            $pdf->Cell(189,5,$row_b['branch_address'],0,1,'C');
            $pdf->Cell(189,5,$row_b['branch_location'],0,1,'C');
            $pdf->Cell(189,5,$row_b['branch_telephone'],0,1,'C');

            /*$pdf->Cell(189,5,$row_company['trading_name'],0,1,'C');
            $pdf->SetFont('Arial','I',8);
            $pdf->Cell(189,5,$row_company['address'],0,1,'C');
            $pdf->Cell(189,5,$row_company['location'],0,1,'C');
            $pdf->Cell(189,5,$row_company['telephone'],0,1,'C');*/

            $pdf->SetFont('Arial','BI',8);
            $pdf->Cell(94,5,'PV No:'.$row['payment_id'],0,0);
            $pdf->Cell(95,5,'Date:'.$row['date'],0,1,'R');
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(189,5,'Payment Voucher',0,1,'C');
            $pdf->Cell(189,10,'',0,1,'C');

            /*$currency_id = $row['currency_id'];
            $query_currency = "SELECT * FROM currency WHERE currency_id = '$currency_id'";
            $query_run_currency = mysqli_query($con, $query_currency);
            if(!empty($query_run_currency) && mysqli_num_rows($query_run_currency) > 0)
            {
                $row_currency = mysqli_fetch_assoc($query_run_currency);
                $currency = $row_currency['currency'];
                $symbol = $row_currency['symbol'];
            }
            else
            {
                $currency = 'N/A';
            };*/

            $ledger_credit = $row['ledger_credit'];
            $query_ledger_cr = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_credit'";
            $query_run_ledger_cr = mysqli_query($con, $query_ledger_cr);
            if(!empty($query_run_ledger_cr) && mysqli_num_rows($query_run_ledger_cr) > 0)
            {
                $row_ledger_cr = mysqli_fetch_assoc($query_run_ledger_cr);
                $ledger_cr = $row_ledger_cr['ledger_desc'];
            }
            else
            {
                $ledger_cr = 'N/A';
            };

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(49,5,'Cash/Bank Account:',0,0);
            $pdf->SetFont('Arial','I',10);
            $pdf->Cell(140,5,$ledger_cr,0,1);
            $pdf->Cell(189,5,'',0,1,'C');

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(80,5,'Description:',1,0);
            $pdf->Cell(69,5,'Receiving Ledger:',1,0);
            $pdf->Cell(40,5,'Amount',1,1,'R');
            $X=10;
            $Y=65;
            
            $query_amount_cr = "SELECT * FROM transactions WHERE payment_id = '$payment_id' AND amt_debit > 0";
            $query_run_amount_cr = mysqli_query($con, $query_amount_cr);
            if(!empty($query_run_amount_cr) && mysqli_num_rows($query_run_amount_cr) > 0)
            while ($row_amount_cr = mysqli_fetch_assoc($query_run_amount_cr))
            {
                $pdf->SetXY($X,$Y);

                $ledger_debit = $row_amount_cr['ledger_id'];
                $query_ledger_dr = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_debit'";
                $query_run_ledger_dr = mysqli_query($con, $query_ledger_dr);
                if(!empty($query_run_ledger_dr) && mysqli_num_rows($query_run_ledger_dr) > 0)
                {
                    $row_ledger_dr = mysqli_fetch_assoc($query_run_ledger_dr);
                    $ledger_dr = $row_ledger_dr['ledger_desc'];
                }
                else
                {
                    $ledger_dr = 'N/A';
                };

                /*if($row['currency_id'] != 1)
                {
                    $amount = round(($row_amount_cr['amount']/$row['exchange_rate']),2);
                }
                else
                {*/
                    $amount = $row_amount_cr['amt_debit'];
                //};
                $amount_f = number_format($amount, 2, '.', ',');
                $pdf->SetFont('Arial','I',8);
                $pdf->MultiCell(80,5,$row_amount_cr['narration'],1,1);
                $X=$X+80;
                $H = $pdf->GetY();
                $height= $H-$Y;
                $pdf->SetXY($X,$Y);
                $pdf->MultiCell(69,$height,$ledger_dr,1,1);
                $X=$X+69;
                $pdf->SetXY($X,$Y);
                $pdf->MultiCell(40,$height,$amount_f,1,'R',false);
                $X=10;
                $Y=$Y+5;
            };

            /*if($row['currency_id'] != 1)
            {
                $total_amount = $row['amount']/$row['exchange_rate'];
                $covid = $row['covid']/$row['exchange_rate'];
                $getfund = $row['getfund']/$row['exchange_rate'];
                $nhil = $row['nhil']/$row['exchange_rate'];
                $total_levies = $row['total_levies']/$row['exchange_rate'];
                $total_after_levies = $row['total_after_levies']/$row['exchange_rate'];
                $vat = $row['vat']/$row['exchange_rate'];
                $net_amount = $row['net_amount']/$row['exchange_rate'];
                $wht_amount = $row['wht_amount']/$row['exchange_rate'];
            }
            else
            {*/
                $total_amount = $row['amount'];
                /*$covid = $row['covid'];
                $getfund = $row['getfund'];
                $nhil = $row['nhil'];
                $total_levies = $row['total_levies'];
                $total_after_levies = $row['total_after_levies'];
                $vat = $row['vat'];
                $net_amount = $row['net_amount'];
                $wht_amount = $row['wht_amount'];*/
            //};
            $amount_paid = round(($total_amount),2);
            /*$covid_f = number_format($covid, 2, '.', ',');
            $getfund_f = number_format($getfund, 2, '.', ',');
            $nhil_f = number_format($nhil, 2, '.', ',');
            $total_levies_f = number_format($total_levies, 2, '.', ',');
            $total_after_levies_f = number_format($total_after_levies, 2, '.', ',');
            $vat_f = number_format($vat, 2, '.', ',');
            $net_amount_f = number_format($net_amount, 2, '.', ',');
            $wht_amount_f = number_format($wht_amount, 2, '.', ',');*/
            $amount_paid_f = number_format($amount_paid, 2, '.', ',');

            $total_amount_f = number_format($total_amount, 2, '.', ',');
            $pdf->SetFont('Arial','BI',10);
            $pdf->Cell(149,5,'TOTAL AMOUNT:',1,0,'C');
            $pdf->Cell(40,5,$total_amount_f,1,1,'R');

            $pdf->SetFont('Arial','I',8);
            /*$covid_perc = $row['covid_perc']*100;
            $nhil_perc = $row['nhil_perc']*100;
            $getfund_perc = $row['getfund_perc']*100;
            $vat_perc = $row['vat_perc']*100;
            $wht_rate = $row['wht_rate']*100;
            if($row['vat_type'] != 'None')
            {
                $pdf->Cell(129,5,'COVID',1,0,'R');
                $pdf->Cell(20,5,$covid_perc.'%',1,0,'C');
                $pdf->Cell(40,5,$covid_f,1,1,'R');
                $pdf->Cell(129,5,'NHIL',1,0,'R');
                $pdf->Cell(20,5,$nhil_perc.'%',1,0,'C');
                $pdf->Cell(40,5,$covid_f,1,1,'R');
                $pdf->Cell(129,5,'GETFUND',1,0,'R');
                $pdf->Cell(20,5,$getfund_perc.'%',1,0,'C');
                $pdf->Cell(40,5,$covid_f,1,1,'R');
                $pdf->Cell(129,5,'TOTAL LEVIES',1,0,'R');
                $pdf->Cell(20,5,'',1,0,'C');
                $pdf->Cell(40,5,$total_levies_f,1,1,'R');
                $pdf->Cell(129,5,'TOTAL AFTER LEVIES',1,0,'R');
                $pdf->Cell(20,5,'',1,0,'C');
                $pdf->Cell(40,5,$total_after_levies_f,1,1,'R');
                $pdf->Cell(129,5,'VAT',1,0,'R');
                $pdf->Cell(20,5,$vat_perc.'%',1,0,'C');
                $pdf->Cell(40,5,$vat_f,1,1,'R');
                $pdf->Cell(129,5,'NET AMOUNT',1,0,'R');
                $pdf->Cell(20,5,'',1,0,'C');
                $pdf->Cell(40,5,$net_amount_f,1,1,'R');
                $amount_paid = round(($net_amount - $wht_amount),2);
            };
            $pdf->Cell(129,5,'WITHOLDING TAX',1,0,'R');
            $pdf->Cell(20,5,$wht_rate.'%',1,0,'C');
            $pdf->Cell(40,5,$wht_amount_f,1,1,'R');*/

            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(149,10,'AMOUNT PAYABLE',1,0,'C');
            $pdf->Cell(40,10,$amount_paid_f,1,1,'R');

            /*if($row['vat_type'] != 'None')
            {
                $pdf->SetFont('Arial','BI',5);
                $pdf->Cell(189,10,'VAT:'.$row['vat_calc_type'].' '.$row['vat_type'],0,0,'R');
            };*/

            $pdf->SetFont('Arial','I',7);

            $amount_in_words = amount_in_words($amount_paid);

            $amount_total = $row['amount'];
            $amount_total_f = number_format($amount_total, 2, '.', ',');
            
            $pdf->Cell(189,5,'',0,1); 
            $pdf->SetFont('Arial','',8);
            $pdf->SetLineWidth(0.1);
            $pdf->Cell(189,10,'Amount in words:',0,1);
            $pdf->SetFont('Arial','I',10);
            $pdf->Cell(189,5,$amount_in_words,'B',1);
            $pdf->Cell(189,5,'',0,1);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(189,10,'Remarks:',0,1);
            $pdf->SetFont('Arial','I',10);
            $pdf->MultiCell(189,5,$row['narration'],'B',1);
            $pdf->Cell(189,5,'',0,1);
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(63,5,'Cheque No:'.$row['inst_no'],0,0,'C');
            $pdf->Cell(63,5,'Bank:'.$row['bank'],0,0,'C');
            $pdf->Cell(63,5,'Branch:'.$row['branch'],0,1,'C');
            $pdf->Cell(189,50,'',0,1);
            
            $pdf->SetFont('Arial','I',8);
            $pdf->Cell(50,5,'...........................................',0,0,'C');
            $pdf->Cell(50,5,'...........................................',0,0,'C');
            $pdf->Cell(50,5,'...........................................',0,0,'C');
            $pdf->Cell(50,5,'...........................................',0,1,'C');
            
            $pdf->Cell(50,5,$row['prepared_by'],0,0,'C');
            $pdf->Cell(50,5,$row['authorized_by'],0,0,'C');
            $pdf->Cell(50,5,$row['approved_by'],0,0,'C');
            $pdf->Cell(50,5,$row['received_by'],0,1,'C');
            $pdf->Cell(50,5,'(Prepared By)',0,0,'C');
            $pdf->Cell(50,5,'(Authorised By)',0,0,'C');
            $pdf->Cell(50,5,'(Approved By)',0,0,'C');
            $pdf->Cell(50,5,'(Received By)',0,1,'C');
        };
        $pdf->Output();
    };
?>