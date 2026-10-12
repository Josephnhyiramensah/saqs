<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    $image = $_SERVER['DOCUMENT_ROOT'] .'/img/logo.png';
    global $con;

    class PDF extends FPDF
    {
        function Footer()
        {
            $this->SetY(-5);
            $this->SetFont('Arial','I',8);
        }
    }

    /*$no_of_items_sold = $_SESSION['no_of_items_sold'];
    if($no_of_items_sold < 3)
    {
        $h = 160;
    }
    else
    {
        $h = 90 + (20 * $no_of_items_sold);
    };
    $pdf = new PDF('P','mm',array(80,$h));*/

    $pdf = new PDF('P','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    $pdf->Image($image,10,5,35,20);

    $pdf->SetMargins(2.5,2.5,2.5);
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
        if(!empty($result_company) && mysqli_num_rows($result_company) > 0)
        {
            $row_company = mysqli_fetch_array($result_company);
            $trading_name = $row_company['trading_name'];
        }
        else
        {
            $trading_name = 'Not Specified';
        };

        $sql_branch = "SELECT * FROM branch WHERE branch_id = '$branch_id'";
        $result_branch = mysqli_query($con,$sql_branch);
        $row_branch = mysqli_fetch_array($result_branch);

        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(189,5,$row_branch['branch_name'],0,1,'C');
        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(189,5,$row_branch['branch_address'].', '.$row_branch['branch_location'].'. '.$row_branch['branch_telephone'],0,1,'C');

        $query = "SELECT * FROM stock_sales WHERE stock_sales_id = '$stock_sales_id'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            $row = mysqli_fetch_assoc($query_run);
            $company_id_to = $row['company_id_to'];
            $sql_company_to = "SELECT * FROM company WHERE company_id = '$company_id_to'";
            $result_company_to = mysqli_query($con,$sql_company_to);
            if(!empty($result_company_to) && mysqli_num_rows($result_company_to) > 0)
            {
                $row_company_to = mysqli_fetch_array($result_company_to);
                $trading_name_to = $row_company_to['trading_name'];
            }
            else
            {
                $trading_name_to = 'Not Specified';
            };

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
            $pdf->Cell(189,10,'',0,1,'C');
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(189,5,'SALES INVOICE',0,1,'C');
            $pdf->SetFont('Arial','BI',9);
            $pdf->Cell(94,5,'Invoice No:'.$row['stock_sales_id'],0,0);
            $pdf->Cell(95,5,'Date:'.$row['date'],0,1,'R');
            $pdf->Cell(189,10,'',0,1,'C');

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
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(95,5,'Shipped To: '.$trading_name_to,0,0);
            $pdf->Cell(94,5,'Shipped By: '.$trading_name,0,1);
            $pdf->Cell(95,5,'Tel: '.$customer_tel,0,0);
            $pdf->Cell(94,5,'',0,1);
            $pdf->Cell(189,5,'Cashier:'.$row['supplied_by'].', '.$row['created_datetime'],0,1);
            $pdf->Cell(199,5,'',0,1);

            $query_sales_items = "SELECT * FROM stock_sales_items WHERE stock_sales_id = '$stock_sales_id'";
            $query_run_sales_items = mysqli_query($con, $query_sales_items);
            if (mysqli_num_rows($query_run_sales_items) > 0)
            {
                $pdf->SetFont('Arial','B',10);
                $pdf->Cell(15,5,'S/No',1,0,'C');
                $pdf->Cell(109,5,'Stock Item',1,0);
                //$pdf->Cell(30,5,'Code',1,0,'C');
                $pdf->Cell(20,5,'Qty',1,0,'C');
                $pdf->Cell(25,5,'Price',1,0,'C');
                $pdf->Cell(30,5,'Amount(GH¢)',1,1,'C');
                $total_amount = 0;
                $i=0;
                while($row_sales_items = mysqli_fetch_assoc($query_run_sales_items))
                {
                    if($row_sales_items['stock_item_id'] > 0)
                    {
                        $i++;
                        $stock_item_id = $row_sales_items['stock_item_id'];
                        $query_stock_item = "SELECT * FROM stock_items WHERE stock_item_id = '$stock_item_id'";
                        $query_run_stock_item = mysqli_query($con, $query_stock_item);
                        if(!empty($query_run_stock_item) && mysqli_num_rows($query_run_stock_item) > 0)
                        {
                            $row_stock_item = mysqli_fetch_assoc($query_run_stock_item);
                            $brand_name = $row_stock_item['stock_item'];
                        }
                        else
                        {
                            $brand_name = 'Not Specified';
                        }
                        $pdf->SetFont('Arial','I',9);
                        //$pdf->MultiCell(189,5,$row_stock_item['brand_name'],'L,R',1);
                        $pdf->Cell(15,5,$i,1,0,'C');
                        $pdf->Cell(109,5,$brand_name,1,0);
                        //$pdf->Cell(30,5,$row_stock_item['code'],1,0,'C');
                        $pdf->Cell(20,5,$row_sales_items['qty'],1,0,'C');
                        $pdf->Cell(25,5,$row_sales_items['price'],1,0,'R');
                        $pdf->Cell(30,5,$row_sales_items['amount'],1,1,'R');
                        $total_amount = $total_amount + $row_sales_items['amount'];
                    };
                };
                $total_amount_f = number_format($total_amount, 2, '.', ',');

                $pdf->SetFont('Arial','B',9);
                $pdf->Cell(169,5,'TOTAL',1,0,'C');
                $pdf->Cell(30,5,$total_amount_f,1,1,'R');
                
                $pdf->SetFont('Arial','I',9);
                $pdf->Cell(199,20,'',0,1);
                $pdf->Cell(49,5,'..................................................',0,0,'C');
                $pdf->Cell(49,5,'..................................................',0,0,'C');
                $pdf->Cell(49,5,'..................................................',0,0,'C');
                $pdf->Cell(49,5,'..................................................',0,1,'C');

                $pdf->Cell(49,5,'Issued By',0,0,'C');
                $pdf->Cell(49,5,'Verified By',0,0,'C');
                $pdf->Cell(49,5,'Received By',0,0,'C');
                $pdf->Cell(49,5,'Approved By',0,1,'C');
                $pdf->SetFont('Arial','I',8);
                $pdf->Cell(189,5,'',0,1);
                $pdf->Cell(199,5,'Issued By:'.$row['supplied_by'].', '.$row['created_datetime'],0,1,'C');
            };
        };
    };

    $pdf->Output();
?>