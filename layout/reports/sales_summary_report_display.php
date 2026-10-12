<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    global $con;
    $company_id = $_SESSION['company_id'];

    class PDF extends FPDF
    {
        function Footer()
        {
            // Go to 1.5 cm from bottom
            $this->SetY(-20);
            
            $this->SetFont('Arial','I',9);
            $this->Cell(66,5,'..............................................................',0,0,'C');
            $this->Cell(66,5,'',0,0,'C');
            $this->Cell(68,5,'',0,1,'C');
            $this->Cell(66,5,'PREPARED BY',0,0,'C');
            $this->Cell(66,5,'',0,0,'C');
            $this->Cell(68,5,'',0,1,'C');
        }
    }
    //A4 width: 219mm
    //default margin: 10mm each side
    //Writable horizontal: 219mm - (10mm*2) = 189mm
    $pdf = new PDF('P','mm','A4');
    $pdf->SetMargins(2.5,2.5,2.5);
    //$pdf->AliasNbPages('{pages}');
    $pdf->AddPage();
    //Cell(width, height, text, border, end line, align)
    if(isset($_SESSION['sales_summary_report_start_date']))
    {           
        $company_id = $_SESSION['company_id'];
        $branch = $_SESSION['sales_summary_report_branch_id'];
        $type = $_SESSION['sales_summary_report_type'];
        $category = $_SESSION['sales_summary_report_category'];
        $start_date = $_SESSION['sales_summary_report_start_date'];
        $end_date = $_SESSION['sales_summary_report_end_date'];

        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);

        $i=0;
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(200,5,$row_company['trading_name'],0,1,'C');
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(200,5,$row_company['location'],0,1,'C');
        $pdf->Cell(200,5,$row_company['telephone'],0,1,'C');
        //$pdf->Cell(75,10,'LOGO',0,1,'C');
        $pdf->Cell(75,5,'',0,1);

        $pdf->SetFont('Arial','BU',14);
        $pdf->Cell(200,8,'SALES SUMMARY REPORT',0,1,'C');
        $pdf->SetFont('Arial','BU',8);
        $pdf->Cell(200,8,'FROM '.$start_date.' TO '.$end_date,0,1,'C');
        $pdf->Cell(200,5,'',0,1,'C');

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(10,7,'S/No',1,0,'C');
        $pdf->Cell(50,7,'Group',1,0,'C');
        $pdf->Cell(85,7,'Item',1,0,'C');
        $pdf->Cell(25,7,'Qty',1,0,'C');
        $pdf->Cell(30,7,'Amount',1,1,'C');
        if($branch=="ALL")
        {
            $sql_branch = "SELECT * FROM branch WHERE company_id = '$company_id'";
        }
        else
        {
            $sql_branch = "SELECT * FROM branch WHERE company_id = '$company_id' AND branch_id = '$branch'";
        }
        $result_branch = mysqli_query($con,$sql_branch);
        if(!empty($result_branch) && mysqli_num_rows($result_branch) > 0)
        {
            while($row_branch = mysqli_fetch_array($result_branch))
            {
                $branch_name = $row_branch['branch_name'];
                $branch_id = $row_branch['branch_id'];
                
                $pdf->SetFont('Arial','BI',10);
                $pdf->Cell(200,7,$branch_name,1,1);
        
                $group_qty = 0;
                $group_total = 0;
                $branch_total = 0;
                /*$sql_group = "SELECT * FROM stock_item_type WHERE company_id = '$company_id'";
                $result_group = mysqli_query($con,$sql_group);
                if(!empty($result_group) && mysqli_num_rows($result_group) > 0)
                {
                    while($row_group = mysqli_fetch_array($result_group))
                    {*/
                        $group_qty = 0;
                        $group_total = 0;

                        /*$stock_item_type_id = $row_group['stock_item_type_id'];
                        $stock_item_type = $row_group['stock_item_type'];

                        if($category == 'DETAILS')
                        {
                            $pdf->SetFont('Arial','BI',8);
                            $pdf->Cell(10,5,'',1,0,'C');
                            $pdf->Cell(190,5,$stock_item_type,1,1);
                        };
                        if($type == 'SALES')
                        {
                            $sql_sales = "SELECT SUM(ssi.qty) AS qty, SUM(ssi.amount) AS amount, ssi.stock_item_id, 
                            sit.stock_item_type_id FROM stock_sales_items ssi JOIN stock_items si ON 
                            ssi.stock_item_id=si.stock_item_id JOIN stock_item_type sit ON 
                            si.stock_item_type_id=sit.stock_item_type_id WHERE ssi.date BETWEEN '$start_date' AND '$end_date' 
                            AND sit.stock_item_type_id = '$stock_item_type_id' AND ssi.stock_sales_id > 0
                            AND ssi.branch_id = '$branch_id' AND ssi.company_id = '$company_id' GROUP BY ssi.stock_item_id";
                        }
                        else if($type == 'NDS')
                        {
                            $sql_sales = "SELECT SUM(ssi.qty_in) AS qty, SUM(ssi.amount) AS amount, ssi.stock_item_id, 
                            sit.stock_item_type_id FROM customer_warehouse ssi JOIN stock_items si ON 
                            ssi.stock_item_id=si.stock_item_id JOIN stock_item_type sit ON 
                            si.stock_item_type_id=sit.stock_item_type_id WHERE ssi.date BETWEEN '$start_date' AND '$end_date' 
                            AND sit.stock_item_type_id = '$stock_item_type_id' AND ssi.nds_sales_id > 0
                            AND ssi.branch_id = '$branch_id' AND ssi.company_id = '$company_id' GROUP BY ssi.stock_item_id";
                        }
                        else if($type == 'ALL')
                        {
                            $sql_sales = "SELECT stock_item_id, SUM(qty) AS qty, SUM(amount) AS amount FROM
                            (SELECT ssi.qty AS qty, ssi.amount AS amount, ssi.stock_item_id AS stock_item_id, 
                            sit.stock_item_type_id FROM stock_sales_items ssi JOIN stock_items si ON 
                            ssi.stock_item_id=si.stock_item_id JOIN stock_item_type sit ON 
                            si.stock_item_type_id=sit.stock_item_type_id WHERE ssi.date BETWEEN '$start_date' AND '$end_date' 
                            AND sit.stock_item_type_id = '$stock_item_type_id' AND ssi.stock_sales_id > 0
                            AND ssi.branch_id = '$branch_id' AND ssi.company_id = '$company_id'
                            UNION ALL SELECT ssi.qty_in AS qty, ssi.amount AS amount, ssi.stock_item_id AS stock_item_id, 
                            sit.stock_item_type_id FROM customer_warehouse ssi JOIN stock_items si ON 
                            ssi.stock_item_id=si.stock_item_id JOIN stock_item_type sit ON 
                            si.stock_item_type_id=sit.stock_item_type_id WHERE ssi.date BETWEEN '$start_date' AND '$end_date' 
                            AND sit.stock_item_type_id = '$stock_item_type_id' AND ssi.nds_sales_id > 0
                            AND ssi.branch_id = '$branch_id' AND ssi.company_id = '$company_id') AS c GROUP BY stock_item_id";
                        };*/
                    
                        if($type == 'SALES')
                        {
                            $sql_sales = "SELECT SUM(ssi.qty) AS qty, SUM(ssi.amount) AS amount, ssi.stock_item_id 
                            FROM stock_sales_items ssi JOIN stock_items si ON 
                            ssi.stock_item_id=si.stock_item_id  WHERE ssi.date BETWEEN '$start_date' AND '$end_date' 
                            AND ssi.stock_sales_id > 0
                            AND ssi.branch_id = '$branch_id' AND ssi.company_id = '$company_id' GROUP BY ssi.stock_item_id";
                        }
                        else if($type == 'ALL')
                        {
                            $sql_sales = "SELECT stock_item_id, SUM(qty) AS qty, SUM(amount) AS amount FROM
                            (SELECT ssi.qty AS qty, ssi.amount AS amount, ssi.stock_item_id AS stock_item_id 
                            FROM stock_sales_items ssi JOIN stock_items si ON 
                            ssi.stock_item_id=si.stock_item_id WHERE ssi.date BETWEEN '$start_date' AND '$end_date' 
                            AND ssi.stock_sales_id > 0
                            AND ssi.branch_id = '$branch_id' AND ssi.company_id = '$company_id') AS c GROUP BY stock_item_id";
                        };

                        $result_sales = mysqli_query($con,$sql_sales);
                        if(!empty($result_sales) && mysqli_num_rows($result_sales) > 0)
                        {
                            while($row_sales = mysqli_fetch_array($result_sales))
                            {
                                $i++;
                                $stock_item_id = $row_sales['stock_item_id'];
                                $qty = $row_sales['qty'];
                                $amount = $row_sales['amount'];
                                $group_qty = $group_qty + $qty;
                                $group_total = $group_total + $amount;
                                $branch_total = $branch_total + $amount;

                                $sql_stock = "SELECT * FROM stock_items WHERE stock_item_id = '$stock_item_id'";
                                $result_stock = mysqli_query($con,$sql_stock);
                                if(!empty($result_stock) && mysqli_num_rows($result_stock) > 0)
                                {
                                    $row_stock = mysqli_fetch_array($result_stock);
                                    $stock_item = $row_stock['stock_item'];
                                }
                                else
                                {
                                    $stock_item = 'Not Specified';
                                };

                                if($category == 'DETAILS')
                                {
                                    $amount_f = number_format($amount, 2, '.', ',');
                                    $pdf->SetFont('Arial','I',8);
                                    $pdf->Cell(10,7,$i,1,0,'C');
                                    $pdf->Cell(50,7,'',1,0,'C');
                                    $pdf->Cell(85,7,$stock_item,1,0);
                                    $pdf->Cell(25,7,$qty,1,0,'C');
                                    $pdf->Cell(30,7,$amount_f,1,1,'R');
                                };
                            };
                        }
                        else
                        {
                            $qty = 0;
                            $amount = 0;
                        };
                        $group_total_f = number_format($group_total, 2, '.', ',');

                        if($category == 'DETAILS')
                        {
                            $pdf->SetFont('Arial','B',7);
                        }else
                        {
                            $pdf->SetFont('Arial','I',8);
                        };
                        $pdf->Cell(170,7,'TOTAL '.$branch_name.' SALES',1,0);
                        $pdf->Cell(30,7,$group_total_f,1,1,'R');
                        /*$pdf->Cell(10,5,'',1,0);
                        if($category == 'DETAILS')
                        {
                            $pdf->Cell(135,5,$stock_item_type.' TOTAL',1,0);
                        }else
                        {
                            $pdf->Cell(135,5,$stock_item_type,1,0);
                        };
                        $pdf->Cell(25,5,$group_qty,1,0,'C');
                        $pdf->Cell(30,5,$group_total_f,1,1, 'R');*/
                    //};
                //};
                
                $sql_trans = "SELECT SUM(t.amt_debit) AS total_amount_debit, t.ledger_id, l.ledger_desc FROM 
                transactions t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE t.company_id = '$company_id' AND 
                t.branch_id = '$branch_id' AND t.date BETWEEN '$start_date' AND '$end_date' AND t.amt_debit >0 
                GROUP BY t.ledger_id";
                $result_trans = mysqli_query($con,$sql_trans);
                if(!empty($result_trans) && mysqli_num_rows($result_trans) > 0)
                {
                    $pdf->SetFont('Arial','B',7);
                    $pdf->Cell(200,7,$branch_name.' RECEIPT BREAKDOWN',1,1,'C');
                    $sum_amount = 0;
                    while($row_trans = mysqli_fetch_array($result_trans))
                    {
                        $ledger_desc = $row_trans['ledger_desc'];
                        $total_amount_debit = $row_trans['total_amount_debit'];
                        $sum_amount = $sum_amount + $total_amount_debit;
                        $total_amount_debit_f = number_format($total_amount_debit, 2, '.', ',');
                        $pdf->SetFont('Arial','I',7);
                        $pdf->Cell(170,5,$ledger_desc,1,0);
                        $pdf->Cell(30,5,$total_amount_debit_f,1,1, 'R');
                    }
                        $sum_amount_f = number_format($sum_amount, 2, '.', ',');
                        $pdf->SetFont('Arial','B',7);
                        $pdf->Cell(170,5,'TOTAL '.$branch_name.' RECEIPTS',1,0);
                        $pdf->Cell(30,5,$sum_amount_f,1,1, 'R');
                }
                $total_branch_amount = $branch_total;
                $pdf->SetFont('Arial','B',8);
                $total_branch_amount_f = number_format($total_branch_amount, 2, '.', ',');
                $pdf->Cell(145,5,$branch_name.' TOTAL',1,0);
                $pdf->Cell(25,5,'',1,0,'C');
                $pdf->Cell(30,5,$total_branch_amount_f,1,1, 'R');
                $pdf->Cell(200,7,'',1,1);
            };
        };
        

        /*if($_SESSION['company_type_id'] == 9)
        {
            $i=0;
            $total_order_amount = 0;
            $total_receipt_amount = 0;
            $total_balance = 0;
            if($branch=="ALL")
            {
                $sql_branch = "SELECT * FROM branch WHERE company_id = '$company_id'";
            }
            else
            {
                $sql_branch = "SELECT * FROM branch WHERE company_id = '$company_id' AND branch_id = '$branch'";
            }
            $result_branch = mysqli_query($con,$sql_branch);
            if(!empty($result_branch) && mysqli_num_rows($result_branch) > 0)
            {
                while($row_branch = mysqli_fetch_array($result_branch))
                {
                    $branch_order_amount = 0;
                    $branch_receipt_amount = 0;
                    $branch_balance = 0;
                    $branch_name = $row_branch['branch_name'];
                    $branch_id = $row_branch['branch_id'];

                    $sql_waiters = "SELECT * FROM users WHERE branch_id = '$branch_id' AND company_id = '$company_id' ORDER BY first_name";
                    $result_waiters = mysqli_query($con,$sql_waiters);
                    if(!empty($result_waiters) && mysqli_num_rows($result_waiters) > 0)
                    {
                        $pdf->Cell(200,5,'',0,1,'C');
                        $pdf->Cell(200,5,'ORDER ANALYSIS',1,1,'C');
                        $pdf->SetFont('Arial','BI',10);
                        $pdf->Cell(200,7,$branch_name,1,1);
                        $pdf->SetFont('Arial','B',8);
                        $pdf->Cell(10,7,'S/No',1,0,'C');
                        $pdf->Cell(40,7,'Waiter',1,0,'C');
                        $pdf->Cell(30,7,'Order No',1,0,'C');
                        $pdf->Cell(30,7,'Table',1,0,'C');
                        $pdf->Cell(30,7,'Order Amount',1,0,'C');
                        $pdf->Cell(30,7,'Receipt Amount',1,0,'C');
                        $pdf->Cell(30,7,'Balance',1,1,'C');
                        while($row_waiters = mysqli_fetch_array($result_waiters))
                        {
                            $waiter_id = $row_waiters['id'];
                            $waiter_order_amount = 0;
                            $waiter_receipt_amount = 0;
                            $waiter_balance = 0;
                            $waiter = $row_waiters['first_name'].' '.$row_waiters['last_name'];
                            if($branch == 'ALL')
                            {
                                $query_to = "SELECT * FROM table_order WHERE created_by = '$waiter_id' AND date BETWEEN 
                                '$start_date' AND '$end_date' AND company_id = '$company_id'";
                            }
                            else
                            {
                                $query_to = "SELECT * FROM table_order WHERE created_by = '$waiter_id' AND 
                                branch_id = '$branch_id' AND date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'";
                            };
                            $query_run_to = mysqli_query($con, $query_to);
                            if(!empty($query_run_to) && mysqli_num_rows($query_run_to) > 0)
                            {
                                while($row_to = mysqli_fetch_array($query_run_to))
                                {
                                    $i++;
                                    $table_order_id = $row_to['table_order_id'];
                                    $dining_table_id = $row_to['dining_table_id'];
                                    
                                    $query_dt = "SELECT * FROM dining_table WHERE dining_table_id = '$dining_table_id'";
                                    $query_run_dt = mysqli_query($con, $query_dt);
                                    if(!empty($query_run_dt) && mysqli_num_rows($query_run_dt) > 0)
                                    {
                                        while($row_dt = mysqli_fetch_array($query_run_dt))
                                        {
                                            $dining_table = $row_dt['dining_table'];
                                        };
                                    }
                                    else
                                    {
                                        $dining_table = 'Not Specified';
                                    };
                                    $query_receipt = "SELECT SUM(amount) AS receipt_amount FROM receipt WHERE table_order_id = '$table_order_id' AND company_id = '$company_id'";
                                    $query_run_receipt = mysqli_query($con, $query_receipt);
                                    if(!empty($query_run_receipt) && mysqli_num_rows($query_run_receipt) > 0)
                                    {
                                        while($row_receipt = mysqli_fetch_array($query_run_receipt))
                                        {
                                            $receipt_amount = $row_receipt['receipt_amount'];
                                        };
                                    }
                                    else
                                    {
                                        $receipt_amount = 0;
                                    };
                                    $order_amount = $row_to['amount'];
                                    $balance = $order_amount - $receipt_amount;

                                    $total_order_amount = $total_order_amount + $order_amount;
                                    $total_receipt_amount = $total_receipt_amount + $receipt_amount;
                                    $total_balance = $total_balance + $balance;

                                    $branch_order_amount = $branch_order_amount + $order_amount;
                                    $branch_receipt_amount = $branch_receipt_amount + $receipt_amount;
                                    $branch_balance = $branch_balance + $balance;

                                    $waiter_order_amount = $waiter_order_amount + $order_amount;
                                    $waiter_receipt_amount = $waiter_receipt_amount + $receipt_amount;
                                    $waiter_balance = $waiter_balance + $balance;

                                    $order_amount_f = number_format($order_amount, 2, '.', ',');
                                    $receipt_amount_f = number_format($receipt_amount, 2, '.', ',');
                                    $balance_f = number_format($balance, 2, '.', ',');

                                    $pdf->SetFont('Arial','I',8);
                                    $pdf->Cell(10,7,$i,1,0,'C');
                                    $pdf->Cell(40,7,$waiter,1,0);
                                    $pdf->Cell(30,7,$table_order_id,1,0,'C');
                                    $pdf->Cell(30,7,$dining_table,1,0,'C');
                                    $pdf->Cell(30,7,$order_amount_f,1,0,'R');
                                    $pdf->Cell(30,7,$receipt_amount_f,1,0,'R');
                                    $pdf->Cell(30,7,$balance_f,1,1,'R');
                                };
                            };
                        };
                        
                        $query_wr = "SELECT SUM(r.amount) AS waiter_rec_amount, r.ledger_credit, r.date, t.created_by 
                        FROM receipt r JOIN table_order t ON r.table_order_id = t.table_order_id WHERE t.created_by = '$waiter_id'
                        AND r.date BETWEEN '$start_date' AND '$end_date' AND r.company_id = '$company_id' GROUP BY r.ledger_credit";
                        $query_run_wr = mysqli_query($con, $query_wr);
                        if(!empty($query_run_wr) && mysqli_num_rows($query_run_wr) > 0)
                        {
                            while($row_wr = mysqli_fetch_array($query_run_wr))
                            {
                                $waiter_rec_amount = $row_wr['waiter_rec_amount'];
                                $waiter_rec_amount_f = number_format($waiter_rec_amount, 2, '.', ',');
                                $cash_ledger_id = $row_wr['ledger_credit'];
                                $sql_cash_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$cash_ledger_id'";
                                $result_cash_ledger = mysqli_query($con,$sql_cash_ledger);
                                if(!empty($result_cash_ledger) && mysqli_num_rows($result_cash_ledger) > 0)
                                {
                                    while($row_cash_ledger = mysqli_fetch_array($result_cash_ledger))
                                    {
                                        $cash_ledger = $row_cash_ledger['ledger_desc'];
                                        $pdf->SetFont('Arial','I',6);
                                        $pdf->Cell(140,5,$cash_ledger,1,0,'R');
                                        $pdf->Cell(30,5,$waiter_rec_amount_f,1,0,'R');
                                        $pdf->Cell(30,5,'',1,1,'R');
                                    };
                                };

                            };
                        }
                        else
                        {
                            $waiter_rec_amount = 0;
                        };
                        $waiter_order_amount_f = number_format($waiter_order_amount, 2, '.', ',');
                        $waiter_receipt_amount_f = number_format($waiter_receipt_amount, 2, '.', ',');
                        $waiter_balance_f = number_format($waiter_balance, 2, '.', ',');
                        $pdf->SetFont('Arial','B',8);
                        $pdf->Cell(110,7,$waiter. 'Total',1,0,'C');
                        $pdf->Cell(30,7,$waiter_order_amount_f,1,0,'R');
                        $pdf->Cell(30,7,$waiter_receipt_amount_f,1,0,'R');
                        $pdf->Cell(30,7,$waiter_balance_f,1,1,'R');
                    };

                    $query_br = "SELECT SUM(r.amount) AS branch_rec_amount, r.ledger_credit, r.date, t.created_by 
                    FROM receipt r JOIN table_order t ON r.table_order_id = t.table_order_id WHERE r.branch_id = '$branch_id'
                    AND r.date BETWEEN '$start_date' AND '$end_date' AND r.company_id = '$company_id' GROUP BY r.ledger_credit";
                    $query_run_br = mysqli_query($con, $query_br);
                    if(!empty($query_run_br) && mysqli_num_rows($query_run_br) > 0)
                    {
                        while($row_br = mysqli_fetch_array($query_run_br))
                        {
                            $branch_rec_amount = $row_br['branch_rec_amount'];
                            $branch_rec_amount_f = number_format($branch_rec_amount, 2, '.', ',');
                            $cash_ledger_id = $row_br['ledger_credit'];
                            $sql_cash_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$cash_ledger_id'";
                            $result_cash_ledger = mysqli_query($con,$sql_cash_ledger);
                            if(!empty($result_cash_ledger) && mysqli_num_rows($result_cash_ledger) > 0)
                            {
                                while($row_cash_ledger = mysqli_fetch_array($result_cash_ledger))
                                {
                                    $cash_ledger = $row_cash_ledger['ledger_desc'];
                                    $pdf->SetFont('Arial','I',6);
                                    $pdf->Cell(140,5,$cash_ledger,1,0,'R');
                                    $pdf->Cell(30,5,$branch_rec_amount_f,1,0,'R');
                                    $pdf->Cell(30,5,'',1,1,'R');
                                };
                            };

                        };
                    }
                    else
                    {
                        $branch_rec_amount = 0;
                    };
                    $branch_order_amount_f = number_format($branch_order_amount, 2, '.', ',');
                    $branch_receipt_amount_f = number_format($branch_receipt_amount, 2, '.', ',');
                    $branch_balance_f = number_format($branch_balance, 2, '.', ',');
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Cell(110,7,$branch_name.' Total',1,0,'C');
                    $pdf->Cell(30,7,$branch_order_amount_f,1,0,'R');
                    $pdf->Cell(30,7,$branch_receipt_amount_f,1,0,'R');
                    $pdf->Cell(30,7,$branch_balance_f,1,1,'R');
                };
                
                $query_tr = "SELECT SUM(amount) AS total_rec_amount, ledger_credit, date
                FROM receipt WHERE company_id='$company_id' AND date BETWEEN '$start_date' AND '$end_date' GROUP BY ledger_credit";
                $query_run_tr = mysqli_query($con, $query_tr);
                if(!empty($query_run_tr) && mysqli_num_rows($query_run_tr) > 0)
                {
                    while($row_tr = mysqli_fetch_array($query_run_tr))
                    {
                        $total_rec_amount = $row_tr['total_rec_amount'];
                        $total_rec_amount_f = number_format($total_rec_amount, 2, '.', ',');
                        $cash_ledger_id = $row_tr['ledger_credit'];
                        $sql_cash_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$cash_ledger_id'";
                        $result_cash_ledger = mysqli_query($con,$sql_cash_ledger);
                        if(!empty($result_cash_ledger) && mysqli_num_rows($result_cash_ledger) > 0)
                        {
                            while($row_cash_ledger = mysqli_fetch_array($result_cash_ledger))
                            {
                                $cash_ledger = $row_cash_ledger['ledger_desc'];
                                $pdf->SetFont('Arial','I',6);
                                $pdf->Cell(140,5,$cash_ledger,1,0,'R');
                                $pdf->Cell(30,5,$total_rec_amount_f,1,0,'R');
                                $pdf->Cell(30,5,'',1,1,'R');
                            };
                        };
                    };
                }
                else
                {
                    $total_rec_amount = 0;
                };
                $total_order_amount_f = number_format($total_order_amount, 2, '.', ',');
                $total_receipt_amount_f = number_format($total_receipt_amount, 2, '.', ',');
                $total_balance_f = number_format($total_balance, 2, '.', ',');
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(110,7,'Grand Total',1,0,'C');
                $pdf->Cell(30,7,$total_order_amount_f,1,0,'R');
                $pdf->Cell(30,7,$total_receipt_amount_f,1,0,'R');
                $pdf->Cell(30,7,$total_balance_f,1,1,'R');
            };
        };*/
    }
    $pdf->Output();