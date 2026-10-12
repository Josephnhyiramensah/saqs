<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    $image = $_SERVER['DOCUMENT_ROOT'] .'/img/logo.png';
    global $con;

    class PDF extends FPDF
    {
        function Footer()
        {
            // Go to 1.5 cm from bottom
            $this->SetY(-5);
            // Select Arial italic 8
            $this->SetFont('Arial','I',8);
            // Print centered page number
            //$this->Cell(0,10,'Page '.$this->PageNo().' - {pages}',0,0,'C');
        }
    }
    //A4 width: 219mm
    //default margin: 10mm each side
    //Writable horizontal: 219mm - (10mm*2) = 189mm
    $no_of_items_sold = $_SESSION['no_of_items_sold'];
    if($no_of_items_sold < 3)
    {
        $h = 160;
    }
    else
    {
        $h = 90 + (20 * $no_of_items_sold);
    };
    $pdf = new PDF('P','mm',array(80,$h));
    $pdf->SetMargins(2.5,2.5,2.5);
    //$pdf->AliasNbPages('{pages}');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    //Cell(width, height, text, border, end line, align)
    if(isset($_SESSION['stock_sales_id']))
    {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $stock_sales_id = $_SESSION['stock_sales_id'];
        if(isset($_SESSION['customer_name']))
        {
            $customer_name = $_SESSION['customer_name'];
        }
        else
        {
            $customer_name = 'CASH CUSTOMER';
        };

        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);

        $sql_branch = "SELECT * FROM branch WHERE branch_id = '$branch_id'";
        $result_branch = mysqli_query($con,$sql_branch);
        $row_branch = mysqli_fetch_array($result_branch);

        $pdf->Image($image,15,2,50,20);
        $pdf->Cell(75,18,'',0,1);
        //$pdf->Cell(75,5,$row_company['trading_name'],0,1,'C');
        $pdf->Cell(75,5,$row_branch['branch_name'],0,1,'C');
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(75,5,$row_branch['branch_location'].', '.$row_branch['branch_telephone'],0,1,'C');
        
        $pdf->SetFont('Arial','BU',10);
        $pdf->Cell(75,8,'SALES RECIEPT',0,1,'C');

        $query = "SELECT * FROM stock_sales WHERE stock_sales_id = '$stock_sales_id'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            $row = mysqli_fetch_assoc($query_run);
            $insurance_id = $row['insurance_id'];
            $query_ins = "SELECT * FROM ledgers WHERE ledger_id = '$insurance_id'";
            $query_run_ins = mysqli_query($con, $query_ins);
            if (mysqli_num_rows($query_run_ins) > 0)
            {
                $row_ins = mysqli_fetch_assoc($query_run_ins);
                $insurance_company = $row_ins['ledger_desc'];
            }
            else
            {
                $insurance_company = '';
            };

            $customer_id = $row['customer_id'];
            $query_cust = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
            $query_run_cust = mysqli_query($con, $query_cust);
            if(mysqli_num_rows($query_run_cust) > 0)
            {
                $row_cust = mysqli_fetch_assoc($query_run_cust);
                $customer = $row_cust['first_name'].' '.$row_cust['last_name'];
                $customer_id = $row_cust['id_number'];
                $customer_tel = $row_cust['phone_number'];
            }
            else
            {
                $customer = '';
                $customer_id = '';
                $customer_tel = '';
            };
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(38,5,'Invoice No: '.$row['sno'],0,0);
            $pdf->Cell(37,5,'Date: '.$row['date'],0,1);
            $pdf->Cell(75,5,'Sold To: '.$customer,0,1);
            $pdf->Cell(40,5,'Customer ID: '.$customer_id,0,0);
            $pdf->Cell(35,5,'Tel: '.$customer_tel,0,1);
            $pdf->Cell(75,5,'Company: '.$insurance_company,0,1);
            $pdf->Cell(75,5,'Cashier:'.$row['supplied_by'].', '.$row['created_datetime'],0,1);

            $query_sales_items = "SELECT * FROM stock_sales_items WHERE stock_sales_id = '$stock_sales_id'";
            $query_run_sales_items = mysqli_query($con, $query_sales_items);
            if (mysqli_num_rows($query_run_sales_items) > 0)
            {
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(75,5,'ITEMS',0,1);
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(30,5,'Stock Item',1,0,'C');
                $pdf->Cell(15,5,'Qty',1,0,'C');
                $pdf->Cell(15,5,'Price',1,0,'C');
                $pdf->Cell(15,5,'Amount',1,1,'C');
                $total_amount = 0;
                while($row_sales_items = mysqli_fetch_assoc($query_run_sales_items))
                {
                    if($row_sales_items['stock_item_id'] > 0)
                    {
                        $stock_item_id = $row_sales_items['stock_item_id'];
                        $query_stock_item = "SELECT * FROM stock_items WHERE stock_item_id = '$stock_item_id'";
                        $query_run_stock_item = mysqli_query($con, $query_stock_item);
                        if(!empty($query_run_stock_item) && mysqli_num_rows($query_run_stock_item) > 0)
                        {
                            $row_stock_item = mysqli_fetch_assoc($query_run_stock_item);
                            $brand_name = $row_stock_item['stock_item'];
                            $code = $row_stock_item['code'];
                        }
                        else
                        {
                            $brand_name = 'Not Specified';
                            $code = 'Not Specified';
                        }
                        $pdf->SetFont('Arial','B',6);
                        $pdf->MultiCell(75,5,$brand_name,'L,R',1);
                        $pdf->SetFont('Arial','I',6);
                        $pdf->Cell(30,5,$code,'L,B',0,'C');
                        $pdf->Cell(15,5,$row_sales_items['qty'],'B',0,'C');
                        $pdf->Cell(15,5,$row_sales_items['price'],'B',0,'R');
                        $pdf->Cell(15,5,$row_sales_items['amount'],'B,R',1,'R');
                        $total_amount = $total_amount + $row_sales_items['amount'];
                    }
                };
                $discount_allowed = $row['discount'];
                $net_amount = $total_amount - $discount_allowed;
                $total_amount_f = number_format($total_amount, 2, '.', ',');
                $discount_allowed_f = number_format($discount_allowed, 2, '.', ',');
                $net_amount_f = number_format($net_amount, 2, '.', ',');

                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(45,5,'Gross Amount',1,0);
                $pdf->Cell(30,5,$row_company['currency'].''.$total_amount_f,1,1,'R');
                $pdf->SetFont('Arial','I',8);
                $pdf->Cell(45,5,'Discount Allowed',1,0);
                $pdf->Cell(30,5,$row_company['currency'].''.$discount_allowed_f,1,1,'R');
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(45,5,'Net Amount',1,0);
                $pdf->Cell(30,5,$row_company['currency'].''.$net_amount_f,1,1,'R');
            };

            $pdf->Cell(75,5,'',0,1,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(75,5,'TENDER',0,1);

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(45,5,'PAYMENT METHOD',1,0,'C');
            $pdf->Cell(30,5,'Amount',1,1,'C');
            $total_payment_amount = 0;

            $query_trans = "SELECT * FROM transactions WHERE stock_sales_id = '$stock_sales_id' AND amt_debit > 0";
            $query_run_trans = mysqli_query($con, $query_trans);
            if (mysqli_num_rows($query_run_trans) > 0)
            {
                while($row_trans = mysqli_fetch_assoc($query_run_trans))
                {
                    $ledger_id = $row_trans['ledger_id'];
                    $query_pay = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
                    $query_run_pay = mysqli_query($con, $query_pay);
                    if (mysqli_num_rows($query_run_pay) > 0)
                    {
                        $row_pay = mysqli_fetch_assoc($query_run_pay);
                        $payment_method = $row_pay['ledger_desc'];
                    }
                    else
                    {
                        $payment_method = '';
                    };
                    $payment_amount = $row_trans['amt_debit'];
                    $total_payment_amount = $total_payment_amount + $row_trans['amt_debit'];
                    $payment_amount_f = number_format($payment_amount, 2, '.', ',');
                    $pdf->SetFont('Arial','I',8);
                    $pdf->Cell(45,5,$payment_method,1,0);
                    $pdf->Cell(30,5,$payment_amount_f,1,1,'R');
                };
            };
            $total_payment_amount_f = number_format($total_payment_amount, 2, '.', ',');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(45,5,'TOTAL',1,0,'C');
            $pdf->Cell(30,5,$total_payment_amount_f,1,1,'R');

            $pdf->SetFont('Arial','BI',10);
            $pdf->Cell(75,5, $row_company['slogan'],0,1,'C');
        };
    };

    $pdf->Output();
?>