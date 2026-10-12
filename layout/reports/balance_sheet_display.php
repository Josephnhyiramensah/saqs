<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    function truncate($number, $precision = 2) 
    {
        $prec = 10 ** $precision;
        return intdiv(round($number * $prec, PHP_ROUND_HALF_DOWN), 1) / $prec;
    }
?>
<input type='hidden' id='session_company_id' value="<?php echo $_SESSION['company_id'];?>">
<input type='hidden' id='session_user_super_id' value="<?php echo $_SESSION['user_super_id'];?>">
<input type='hidden' id='session_user_id' value="<?php echo $_SESSION['user_id'];?>">
  <style type="text/css">
    .scroll-card-body {
            max-height: 700px;
            overflow-y: auto;
          }
    .amt-td {
            text-align:right;
          }
    .action-td {
            text-align:center;
          }
</style>
<div class="container-fluid">
    <?php 
        if(isset($_SESSION['balance_sheet_start_date']))
        {
            $company_id = $_SESSION['balance_sheet_company_id'];
            $start_date = $_SESSION['balance_sheet_start_date'];
            $end_date = $_SESSION['balance_sheet_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
            <table class="table table-hover table-borderless table-sm" id="balance_sheet_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="5"><H3><?php echo $row_company['trading_name'];?></H3></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="5"><H6>BALANCE SHEET AS AT  <?php echo $end_date;?></H6></th>
                    </tr>
                    <tr>
                        <th class="action-td"></th>
                        <th class="amt-td"><?php echo $row_company['currency'];?></th>
                        <th class="amt-td"><?php echo $row_company['currency'];?></th>
                        <th class="amt-td"><?php echo $row_company['currency'];?></th>
                        <th class="amt-td"><?php echo $row_company['currency'];?></th>
                    </tr>
                </thead>
                    <tbody class="pv-table-body" id="balance_sheet_list_table_body">
        <?php 
                        $previous_sales = 0;
                        $previous_opening_stock = 0;
                        $previous_closing_stock = 0;
                        $previous_purchases = 0;
                        $previous_cost_of_goods_available_for_sale = 0;
                        $previous_cost_of_goods_sold = 0;
                        $previous_gross_profit = 0;
                        $previous_other_income = 0;
                        $previous_expense_item = 0;
                        $previous_expense_amount = 0;
                        $previous_total_expenses = 0;
                        $previous_net_profit = 0;
                        $previous_total_other_income = 0;

                        $sales = 0;
                        $opening_stock = 0;
                        $closing_stock = 0;
                        $purchases = 0;
                        $cost_of_goods_available_for_sale = 0;
                        $cost_of_goods_sold = 0;
                        $gross_profit = 0;
                        $total_other_income = 
                        $expense_item = 0;
                        $expense_amount = 0;
                        $total_expenses = 0;
                        $net_profit = 0;

                        $total_fixed_asset = 0;
                        $total_current_asset = 0;
                        $total_current_liabilities = 0;
                        $total_reserves = 0;

                        //PREVIOUS STOCK TRANSACTION
                            //STOCK ITEMS
                            $query="
                                SELECT item_id, SUM(ob) AS ob, SUM(qty_in) AS qty_in, SUM(qty_out) AS qty_out FROM
                                (SELECT stock_item_id  AS item_id, warehouse_id, qty - 0 AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_purchase_items 
                                WHERE date < '$start_date' AND company_id = '$company_id'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 - qty AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_sales_items 
                                WHERE date < '$start_date' AND company_id = '$company_id'
                                UNION ALL SELECT stock_id AS item_id, warehouse_id, 0 - qty AS ob, 0 AS qty_out, 0 AS qty_in FROM mtce_stock_list 
                                WHERE date < '$start_date' AND company_id = '$company_id'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 - qty_out AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
                                WHERE date < '$start_date' AND company_id = '$company_id'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 - qty_transferred AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
                                WHERE date_trans < '$start_date' AND company_id = '$company_id'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, qty_in - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
                                WHERE date < '$start_date' AND company_id = '$company_id'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, qty_received - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
                                WHERE date_trans < '$start_date' AND company_id = '$company_id'
                        
                                UNION ALL SELECT stock_item_id  AS item_id, warehouse_id, 0 AS ob, 0 AS qty_out, qty AS qty_in FROM stock_purchase_items 
                                WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM stock_sales_items 
                                WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'
                                UNION ALL SELECT stock_id AS item_id, warehouse_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM mtce_stock_list 
                                WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  qty_out AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
                                WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  qty_transferred AS qty_out, 0 AS qty_in FROM stock_transfer_items 
                                WHERE date_trans BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty_in AS qty_in FROM stock_adjustment_items 
                                WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty_received AS qty_in FROM stock_transfer_items 
                                WHERE date_trans BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id') AS c GROUP BY item_id";
                                
                                $current_stock_closing_amount = 0;
                                $current_stock_opening_amount = 0;
                                $current_stock_purchase_amount = 0;
                                $current_stock_sold_amount = 0;

                                $current_total_stock_closing_amount = 0;
                                $current_total_stock_opening_amount = 0;
                                $current_total_stock_purchase_amount = 0;
                                $current_total_stock_sold_amount = 0;

                                $previous_total_stock_purchase_amount = 0;
                                $previous_total_stock_sold_amount = 0;

                                $query_run = mysqli_query($con, $query);
                                if (mysqli_num_rows($query_run) > 0)
                                {
                                    while($row = mysqli_fetch_assoc($query_run))
                                    {
                                        $item_id = $row['item_id'];
                                        $query_item = "SELECT * FROM stock_items WHERE stock_item_id ='$item_id'";
                                
                                        $query_run_item = mysqli_query($con, $query_item);
                                        if(mysqli_num_rows($query_run_item) > 0)
                                        {
                                            $row_item = mysqli_fetch_assoc($query_run_item);

                                            //CURRENT OPENING AND CLOSING STOCK
                                                $query_pap = "SELECT avg(price) AS avg_price FROM stock_purchase_items WHERE 
                                                stock_item_id ='$item_id' AND date BETWEEN '2000-01-01' AND '$end_date' 
                                                GROUP BY stock_item_id";
                                                $query_run_pap = mysqli_query($con, $query_pap);
                                                if(mysqli_num_rows($query_run_pap) > 0)
                                                {
                                                    $row_av_price = mysqli_fetch_assoc($query_run_pap);
                                                    $stock_average_price = $row_av_price['avg_price'];
                                                    $current_stock_opening_amount = $row['ob'] * $stock_average_price;
                                                    $current_stock_cls_bal = $row['ob'] + $row['qty_in'] - $row['qty_out'];
                                                    $current_stock_closing_amount = $current_stock_cls_bal * $stock_average_price;
                                                }
                                                else
                                                {
                                                    $stock_average_price = 0;
                                                    $current_stock_opening_amount = 0 * $stock_average_price;
                                                    $current_stock_cls_bal = 0;
                                                    $current_stock_closing_amount = $current_stock_cls_bal * $stock_average_price;
                                                };

                                            //PREVIOUS STOCK PURCHASES
                                                $query_pap_purchases = "SELECT * FROM stock_purchase_items WHERE 
                                                stock_item_id ='$item_id' AND date < '$start_date'";
                                                $query_run_pap_purchases = mysqli_query($con, $query_pap_purchases);
                                                if(mysqli_num_rows($query_run_pap_purchases) > 0)
                                                {
                                                    while($row_pap_purchases = mysqli_fetch_assoc($query_run_pap_purchases))
                                                    {
                                                        $stock_purchase_price = $row_pap_purchases['price'];
                                                        $stock_purchase_qty = $row_pap_purchases['qty'];
                                                        $previous_stock_purchase_amount = $stock_purchase_qty * $stock_purchase_price;
                                                        $previous_total_stock_purchase_amount = $previous_total_stock_purchase_amount + $previous_stock_purchase_amount;
                                                    };
                                                }
                                                else
                                                {
                                                    $stock_purchase_price = 0;
                                                    $stock_purchase_qty = 0;
                                                    $previous_stock_purchase_amount = $stock_purchase_qty * $stock_purchase_price;
                                                    $previous_total_stock_purchase_amount = $previous_total_stock_purchase_amount + $previous_stock_purchase_amount;
                                                };

                                            //CURRENT STOCK PURCHASES
                                                $query_pap_purchases = "SELECT * FROM stock_purchase_items WHERE 
                                                stock_item_id ='$item_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                                $query_run_pap_purchases = mysqli_query($con, $query_pap_purchases);
                                                if(mysqli_num_rows($query_run_pap_purchases) > 0)
                                                {
                                                    while($row_pap_purchases = mysqli_fetch_assoc($query_run_pap_purchases))
                                                    {
                                                        $stock_purchase_price = $row_pap_purchases['price'];
                                                        $stock_purchase_qty = $row_pap_purchases['qty'];
                                                        $current_stock_purchase_amount = $stock_purchase_qty * $stock_purchase_price;
                                                        $current_total_stock_purchase_amount = $current_total_stock_purchase_amount + $current_stock_purchase_amount;
                                                    };
                                                }
                                                else
                                                {
                                                    $stock_purchase_price = 0;
                                                    $stock_purchase_qty = 0;
                                                    $current_stock_purchase_amount = $stock_purchase_qty * $stock_purchase_price;
                                                    $current_total_stock_purchase_amount = $current_total_stock_purchase_amount + $current_stock_purchase_amount;
                                                };
                                            
                                            //PREVIOUS STOCK SOLD
                                                $query_pap_sold = "SELECT * FROM stock_sales_items WHERE 
                                                stock_item_id ='$item_id' AND date < '$start_date'";
                                                $query_run_pap_sold = mysqli_query($con, $query_pap_sold);
                                                if(mysqli_num_rows($query_run_pap_sold) > 0)
                                                {
                                                    while($row_pap_sold = mysqli_fetch_assoc($query_run_pap_sold))
                                                    {
                                                        $stock_sold_price = $row_pap_sold['price'];
                                                        $stock_sold_qty = $row_pap_sold['qty'];
                                                        $previous_stock_sold_amount = $stock_sold_qty * $stock_sold_price;
                                                        $previous_total_stock_sold_amount = $previous_total_stock_sold_amount + $previous_stock_sold_amount;
                                                    };
                                                }
                                                else
                                                {
                                                    $stock_sold_price = 0;
                                                    $stock_sold_qty = 0;
                                                    $previous_stock_sold_amount = $stock_sold_qty * $stock_sold_price;
                                                    $previous_total_stock_sold_amount = $previous_total_stock_sold_amount + $previous_stock_sold_amount;
                                                };
                                            
                                            //CURRENT STOCK SOLD
                                                $query_pap_sold = "SELECT * FROM stock_sales_items WHERE 
                                                stock_item_id ='$item_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                                $query_run_pap_sold = mysqli_query($con, $query_pap_sold);
                                                if(mysqli_num_rows($query_run_pap_sold) > 0)
                                                {
                                                    while($row_pap_sold = mysqli_fetch_assoc($query_run_pap_sold))
                                                    {
                                                        $stock_sold_price = $row_pap_sold['price'];
                                                        $stock_sold_qty = $row_pap_sold['qty'];
                                                        $current_stock_sold_amount = $stock_sold_qty * $stock_sold_price;
                                                        $current_total_stock_sold_amount = $current_total_stock_sold_amount + $current_stock_sold_amount;
                                                    };
                                                }
                                                else
                                                {
                                                    $stock_sold_price = 0;
                                                    $stock_sold_qty = 0;
                                                    $current_stock_sold_amount = $stock_sold_qty * $stock_sold_price;
                                                    $current_total_stock_sold_amount = $current_total_stock_sold_amount + $current_stock_sold_amount;
                                                };
                                        }
                                        else
                                        {
                                            $stock_average_price = 0;
                                            $current_stock_opening_amount = 0 * $stock_average_price;
                                            $current_stock_cls_bal = 0;
                                            $current_stock_closing_amount = $current_stock_cls_bal * $stock_average_price;
                                        };
                                        $current_total_stock_opening_amount = $current_total_stock_opening_amount + $current_stock_opening_amount;
                                        $current_total_stock_closing_amount = $current_total_stock_closing_amount + $current_stock_closing_amount;
                                    };
                                };
                        //PREVIOUS SALES
                            $query_previous_sales = "SELECT SUM(amount) AS sales_amount FROM sales WHERE 
                            company_id = '$company_id' AND date < '$start_date'";
                            $query_run_previous_sales = mysqli_query($con, $query_previous_sales);
                            if (mysqli_num_rows($query_run_previous_sales) > 0)
                            {
                                $row_previous_sales = mysqli_fetch_assoc($query_run_previous_sales);
                                $previous_sales = $row_previous_sales['sales_amount'];
                            }
                            else
                            {
                                $previous_sales = 0;
                            };
                            $total_previous_sales = $previous_sales + $previous_total_stock_sold_amount;
                        //PREVIOUS OTHER INCOME
                            $query_other_income_ledgers = "SELECT * FROM ledgers WHERE 
                            (company_id = '$company_id' AND tb_2 = 3 AND ledger_id != 4 AND ledger_id != 35) 
                            OR (default_status = 'Yes' AND tb_2 = 3 AND ledger_id != 4 AND ledger_id != 35)";
                            $query_run_other_income_ledgers = mysqli_query($con, $query_other_income_ledgers);
                            if (mysqli_num_rows($query_run_other_income_ledgers) > 0)
                            {
                                while($row_other_income_ledgers = mysqli_fetch_assoc($query_run_other_income_ledgers))
                                {
                                    $previous_other_income_amount = 0;
                                    $ledger_id = $row_other_income_ledgers['ledger_id'];
                                    $query_ledger_trans = "SELECT SUM(amount_debit) AS amount_debit,
                                    SUM(amount_credit) AS amount_credit FROM transactions WHERE 
                                    ledger_id = '$ledger_id' AND date < '$start_date' 
                                    AND company_id = '$company_id'";
                                    $query_run_ledger_trans = mysqli_query($con, $query_ledger_trans);
                                    if (mysqli_num_rows($query_run_ledger_trans) > 0)
                                    {
                                        $row_ledger_trans = mysqli_fetch_assoc($query_run_ledger_trans);
                                        $previous_other_income_amount = $previous_other_income_amount + $row_ledger_trans['amount_credit'] - 
                                        $row_ledger_trans['amount_debit'];
                                    }
                                    else
                                    {
                                        $previous_other_income_amount = 0;
                                    };
                                    $previous_total_other_income = $previous_total_other_income + $previous_other_income_amount;
                                };
                            };
                        //PREVIOUS OPENING STOCK
                            /*$query_previous_opening_stock = "SELECT * FROM purchases WHERE company_id = '$company_id' 
                            AND date < '$start_date'";
                            $query_run_previous_opening_stock = mysqli_query($con, $query_previous_opening_stock);
                            if (mysqli_num_rows($query_run_previous_opening_stock) > 0)
                            {
                                while($row_previous_opening_stock = mysqli_fetch_assoc($query_run_previous_opening_stock))
                                {
                                    $purchase_id = $row_previous_opening_stock['purchase_id'];
                                    $query_previous_pending = "SELECT * FROM sold_items WHERE purchase_id = '$purchase_id' 
                                    AND date < '$start_date'";
                                    $query_run_previous_pending = mysqli_query($con, $query_previous_pending);
                                    if (mysqli_num_rows($query_run_previous_pending) <= 0)
                                    {
                                        $previous_opening_stock = $previous_opening_stock + $row_previous_opening_stock['amount'];
                                    };
                                };
                            }
                            else
                            {
                                $previous_opening_stock = 0;
                            };*/
                        //PREVIOUS PURCHASES
                            $query_previous_purchases = "SELECT SUM(amount) AS purchase_amount FROM purchases WHERE 
                            company_id = '$company_id' AND date < '$start_date'";
                            $query_run_previous_purchases = mysqli_query($con, $query_previous_purchases);
                            if (mysqli_num_rows($query_run_previous_purchases) > 0)
                            {
                                $row_previous_purchases = mysqli_fetch_assoc($query_run_previous_purchases);
                                $previous_purchases = $row_previous_purchases['purchase_amount'];
                            }
                            else
                            {
                                $previous_purchases = 0;
                            };
                                $total_previous_purchases = $previous_purchases + $previous_total_stock_purchase_amount;
                                $previous_cost_of_goods_available_for_sale = $previous_opening_stock + 
                                $total_previous_purchases;
                            
                        //PREVIOUS CLOSING STOCK
                            $query_previous_closing_stock = "SELECT * FROM purchases WHERE company_id = '$company_id' 
                            AND date < '$start_date'";
                            $query_run_previous_closing_stock = mysqli_query($con, $query_previous_closing_stock);
                            if (mysqli_num_rows($query_run_previous_closing_stock) > 0)
                            {
                                while($row_previous_closing_stock = mysqli_fetch_assoc($query_run_previous_closing_stock))
                                {
                                    $purchase_id = $row_previous_closing_stock['purchase_id'];
                                    $query_previous_closing_pending = "SELECT * FROM sold_items WHERE purchase_id = '$purchase_id' 
                                    AND date < '$start_date'";
                                    $query_run_previous_closing_pending = mysqli_query($con, $query_previous_closing_pending);
                                    if (mysqli_num_rows($query_run_previous_closing_pending) <= 0)
                                    {
                                        $previous_closing_stock = $previous_closing_stock + 
                                        $row_previous_closing_stock['amount'];
                                    };
                                };
                            }
                            else
                            {
                                $previous_closing_stock = 0;
                            };
                                $total_previous_closing_stock = $previous_closing_stock + $current_stock_opening_amount;
                                $previous_cost_of_goods_sold = $previous_cost_of_goods_available_for_sale - $total_previous_closing_stock;
                                $previous_gross_profit = $total_previous_sales - $previous_cost_of_goods_sold;
                    
                        //PREVIOUS EXPENSES
                            $query_previous_expense_ledgers = "SELECT * FROM ledgers WHERE 
                            (company_id = '$company_id' AND tb_2 = 4 AND ledger_id != 3 AND ledger_id != 34)
                            OR (default_status = 'Yes' AND tb_2 = 4 AND ledger_id != 3 AND ledger_id != 34)";
                            $query_run_previous_expense_ledgers = mysqli_query($con, $query_previous_expense_ledgers);
                            if (mysqli_num_rows($query_run_previous_expense_ledgers) > 0)
                            {
                                while($row_previous_expense_ledgers = mysqli_fetch_assoc($query_run_previous_expense_ledgers))
                                {
                                    $previous_expense_amount = 0;
                                    $ledger_id = $row_previous_expense_ledgers['ledger_id'];
                                    $query_previous_ledger_trans = "SELECT SUM(amount_debit) AS amount_debit,
                                    SUM(amount_credit) AS amount_credit FROM 
                                    transactions WHERE ledger_id = '$ledger_id' AND date < '$start_date'
                                    AND company_id = '$company_id'";
                                    $query_run_previous_ledger_trans = mysqli_query($con, $query_previous_ledger_trans);
                                    if (mysqli_num_rows($query_run_previous_ledger_trans) > 0)
                                    {
                                        $row_previous_ledger_trans = mysqli_fetch_assoc($query_run_previous_ledger_trans);
                                        $previous_expense_amount = $previous_expense_amount + 
                                        $row_previous_ledger_trans['amount_debit'] - $row_previous_ledger_trans['amount_credit'];
                                    }
                                    else
                                    {
                                        $previous_expense_amount = 0;
                                    };
                                    $previous_expense_item = $row_previous_expense_ledgers['ledger_desc'];
                                    $previous_total_expenses = $previous_total_expenses + $previous_expense_amount;
                                };
                            };
                            $previous_net_profit = $previous_gross_profit + $previous_total_other_income - $previous_total_expenses;
                        
                        //CURRENT SALES
                            $query_sales = "SELECT SUM(amount) AS sales_amount FROM sales WHERE company_id = '$company_id' 
                            AND date BETWEEN '$start_date' AND '$end_date'";
                            $query_run_sales = mysqli_query($con, $query_sales);
                            if (mysqli_num_rows($query_run_sales) > 0)
                            {
                                $row_sales = mysqli_fetch_assoc($query_run_sales);
                                $sales = $row_sales['sales_amount'];
                            }
                            else
                            {
                                $sales = 0;
                            };
                            $total_sales = $sales + $current_total_stock_sold_amount;
                        //CURRENT OTHER INCOME
                            $query_other_income_ledgers = "SELECT * FROM ledgers WHERE 
                            (company_id = '$company_id' AND tb_2 = 3 AND ledger_id != 4 AND ledger_id != 35) 
                            OR (default_status = 'Yes' AND tb_2 = 3 AND ledger_id != 4 AND ledger_id != 35)";
                            $query_run_other_income_ledgers = mysqli_query($con, $query_other_income_ledgers);
                            if (mysqli_num_rows($query_run_other_income_ledgers) > 0)
                            {
                                while($row_other_income_ledgers = mysqli_fetch_assoc($query_run_other_income_ledgers))
                                {
                                    $other_income_amount = 0;
                                    $ledger_id = $row_other_income_ledgers['ledger_id'];
                                    $query_ledger_trans = "SELECT SUM(amount_debit) AS amount_debit,
                                    SUM(amount_credit) AS amount_credit FROM transactions WHERE 
                                    ledger_id = '$ledger_id' AND date BETWEEN '$start_date' AND '$end_date' 
                                    AND company_id = '$company_id'";
                                    $query_run_ledger_trans = mysqli_query($con, $query_ledger_trans);
                                    if (mysqli_num_rows($query_run_ledger_trans) > 0)
                                    {
                                        $row_ledger_trans = mysqli_fetch_assoc($query_run_ledger_trans);
                                        $other_income_amount = $other_income_amount + $row_ledger_trans['amount_credit'] - 
                                        $row_ledger_trans['amount_debit'];
                                    }
                                    else
                                    {
                                        $other_income_amount = 0;
                                    };
                                    $total_other_income = $total_other_income + $other_income_amount;
                                };
                            };
                        //CURRENT OPENING STOCK
                            $query_opening_stock = "SELECT * FROM purchases WHERE company_id = '$company_id' 
                            AND date < '$start_date'";
                            $query_run_opening_stock = mysqli_query($con, $query_opening_stock);
                            if (mysqli_num_rows($query_run_opening_stock) > 0)
                            {
                                while($row_opening_stock = mysqli_fetch_assoc($query_run_opening_stock))
                                {
                                    $purchase_id = $row_opening_stock['purchase_id'];
                                    $query_pending = "SELECT * FROM sold_items WHERE purchase_id = '$purchase_id' 
                                    AND date < '$start_date'";
                                    $query_run_pending = mysqli_query($con, $query_pending);
                                    if (mysqli_num_rows($query_run_pending) <= 0)
                                    {
                                        $opening_stock = $opening_stock + $row_opening_stock['amount'];
                                    };
                                };
                            }
                            else
                            {
                                $opening_stock = 0;
                            };
                            $total_opening_stock = $opening_stock + $current_stock_opening_amount;
                        //CURRENT PURCHASES
                            $query_purchases = "SELECT SUM(amount) AS purchase_amount FROM purchases WHERE 
                            company_id = '$company_id' AND date BETWEEN '$start_date' AND '$end_date'";
                            $query_run_purchases = mysqli_query($con, $query_purchases);
                            if (mysqli_num_rows($query_run_purchases) > 0)
                            {
                                $row_purchases = mysqli_fetch_assoc($query_run_purchases);
                                $purchases = $row_purchases['purchase_amount'];
                            }
                            else
                            {
                                $purchases = 0;
                            };
                                $total_purchases = $purchases + $current_total_stock_purchase_amount;
                                $purchases_f = number_format($total_purchases, 2, '.', ',');
                                $cost_of_goods_available_for_sale = $total_opening_stock + $total_purchases;
                                $cost_of_goods_available_for_sale_f = number_format($cost_of_goods_available_for_sale, 2, '.', ',');
                            
                        //CURRENT CLOSING STOCK
                            $query_closing_stock = "SELECT * FROM purchases WHERE company_id = '$company_id' 
                            AND date < '$end_date'";
                            $query_run_closing_stock = mysqli_query($con, $query_closing_stock);
                            if (mysqli_num_rows($query_run_closing_stock) > 0)
                            {
                                while($row_closing_stock = mysqli_fetch_assoc($query_run_closing_stock))
                                {
                                    $purchase_id = $row_closing_stock['purchase_id'];
                                    $query_closing_pending = "SELECT * FROM sold_items WHERE purchase_id = '$purchase_id' 
                                    AND date < '$end_date'";
                                    $query_run_closing_pending = mysqli_query($con, $query_closing_pending);
                                    if (mysqli_num_rows($query_run_closing_pending) <= 0)
                                    {
                                        $closing_stock = $closing_stock + $row_closing_stock['amount'];
                                    };
                                };
                            }
                            else
                            {
                                $closing_stock = 0;
                            };
                                $total_closing_stock = $closing_stock + $current_stock_closing_amount;
                                $cost_of_goods_sold = $cost_of_goods_available_for_sale - $total_closing_stock;
                                $gross_profit = $total_sales - $cost_of_goods_sold;
                                $closing_stock_f = number_format($total_closing_stock, 2, '.', ',');
                                $cost_of_goods_sold_f = number_format($cost_of_goods_sold, 2, '.', ',');
                                $gross_profit_f = number_format($gross_profit, 2, '.', ',');
                    
                        //CURRENT EXPENSES
                            $query_expense_ledgers = "SELECT * FROM ledgers WHERE 
                            (company_id = '$company_id' AND tb_2 = 4 AND ledger_id != 3 AND ledger_id != 34) 
                            OR (default_status = 'Yes' AND tb_2 = 4 AND ledger_id != 3 AND ledger_id != 34)";
                            $query_run_expense_ledgers = mysqli_query($con, $query_expense_ledgers);
                            if (mysqli_num_rows($query_run_expense_ledgers) > 0)
                            {
                                while($row_expense_ledgers = mysqli_fetch_assoc($query_run_expense_ledgers))
                                {
                                    $expense_amount = 0;
                                    $ledger_id = $row_expense_ledgers['ledger_id'];
                                    $query_ledger_trans = "SELECT SUM(amount_debit) AS amount_debit,
                                    SUM(amount_credit) AS amount_credit FROM transactions 
                                    WHERE ledger_id = '$ledger_id' AND date BETWEEN '$start_date' AND '$end_date'
                                    AND company_id = '$company_id'";
                                    $query_run_ledger_trans = mysqli_query($con, $query_ledger_trans);
                                    if (mysqli_num_rows($query_run_ledger_trans) > 0)
                                    {
                                        $row_ledger_trans = mysqli_fetch_assoc($query_run_ledger_trans);
                                        $expense_amount = $expense_amount + $row_ledger_trans['amount_debit'] -
                                        $row_ledger_trans['amount_credit'];
                                    }
                                    else
                                    {
                                        $expense_amount = 0;
                                    };
                                    $expense_item = $row_expense_ledgers['ledger_desc'];
                                    $expense_amount_f = number_format($expense_amount, 2, '.', ',');
                                    $total_expenses = $total_expenses + $expense_amount;
                                };
                            };
                            $net_profit = $gross_profit + $total_other_income - $total_expenses;
                            $total_expenses_f = number_format($total_expenses, 2, '.', ',');
                            $net_profit_f = number_format($net_profit, 2, '.', ',');
                        
                        //FIXED ASSETS
                            echo '<tr style="background-color:#E4DCCF; color:black">
                                    <th colspan="14"><H6><strong>FIXED ASSETS</strong></H6></th>
                                </tr>';
                            
                                $query_fixed_asset_ledgers = "SELECT * FROM ledgers WHERE 
                                (company_id = '$company_id' AND tb_3 = 1) OR (tb_3 = 1 AND default_status = 'Yes')";
                                $query_run_fixed_asset_ledgers = mysqli_query($con, $query_fixed_asset_ledgers);
                                if (mysqli_num_rows($query_run_fixed_asset_ledgers) > 0)
                                {
                                    while($row_fixed_asset_ledgers = mysqli_fetch_assoc($query_run_fixed_asset_ledgers))
                                    {
                                        $fixed_asset_amount = 0;
                                        $ledger_id = $row_fixed_asset_ledgers['ledger_id'];
                                        $query_fixed_asset_trans = "SELECT SUM(amount_debit) AS debit_amount, 
                                        SUM(amount_credit) AS credit_amount FROM transactions WHERE ledger_id = '$ledger_id' 
                                        AND date BETWEEN '2000-01-01' AND '$end_date' AND company_id = '$company_id'";
                                        $query_run_fixed_asset_trans = mysqli_query($con, $query_fixed_asset_trans);
                                        if (mysqli_num_rows($query_run_fixed_asset_trans) > 0)
                                        {
                                            $row_fixed_asset_trans = mysqli_fetch_assoc($query_run_fixed_asset_trans);
                                            $fixed_asset_amount = $row_fixed_asset_trans['debit_amount'] - $row_fixed_asset_trans['credit_amount'];
                                        }
                                        else
                                        {
                                            $fixed_asset_amount = 0;
                                        };
                                        $fixed_asset_item = $row_fixed_asset_ledgers['ledger_desc'];
                                        $fixed_asset_amount_f = number_format($fixed_asset_amount, 2, '.', ',');
                                        $total_fixed_asset = $total_fixed_asset + $fixed_asset_amount;
                                        
                                        if($fixed_asset_amount != 0)
                                        {
                                            echo'<tr>
                                                <td>'.$fixed_asset_item.'</td>
                                                <td></td>
                                                <td></td>
                                                <td class="amt-td">'.$fixed_asset_amount_f.'</td>
                                                <td></td>
                                            </tr>';
                                        };
                                    };
                                };
                                $total_fixed_asset_f = number_format($total_fixed_asset, 2, '.', ',');
                                echo'<tr>
                                        <td style="color:black"><strong>TOTAL FIXED ASSETS</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="amt-td" style="color:black"><strong>'.$total_fixed_asset_f.'</strong></td>
                                    </tr>';

                        //CURRENT ASSETS
                            echo'<tr style="background-color:#E4DCCF; color:black">
                                <th colspan="14"><H6><strong>CURRENT ASSETS</strong></H6></th>
                            </tr>';
                                $query_tb4 = "SELECT * FROM trial_bal_group_4 WHERE tb_3_id=2";
                                $query_run_tb_4 = mysqli_query($con, $query_tb4);
                                if (mysqli_num_rows($query_run_tb_4) > 0)
                                {
                                    while($row_tb_4 = mysqli_fetch_assoc($query_run_tb_4))
                                    {
                                        $tb_4_amount = 0;
                                        $tb_4 = $row_tb_4['id'];
                                        if($tb_4 != 3)
                                        {
                                            $query_current_asset_ledgers = "SELECT * FROM ledgers WHERE 
                                            (company_id = '$company_id' AND tb_4 = '$tb_4') OR (default_status = 'Yes' AND tb_4 = '$tb_4')";
                                            $query_run_current_asset_ledgers = mysqli_query($con, $query_current_asset_ledgers);
                                            if (mysqli_num_rows($query_run_current_asset_ledgers) > 0)
                                            {
                                                while($row_current_asset_ledgers = mysqli_fetch_assoc($query_run_current_asset_ledgers))
                                                {
                                                    $current_asset_amount = 0;
                                                    $ledger_id = $row_current_asset_ledgers['ledger_id'];
                                                    $query_current_asset_trans = "SELECT SUM(amount_debit) AS debit_amount, 
                                                    SUM(amount_credit) AS credit_amount FROM transactions WHERE ledger_id = '$ledger_id' 
                                                    AND date BETWEEN '2000-01-01' AND '$end_date' AND company_id = '$company_id'";
                                                    $query_run_current_asset_trans = mysqli_query($con, $query_current_asset_trans);
                                                    if (mysqli_num_rows($query_run_current_asset_trans) > 0)
                                                    {
                                                        $row_current_asset_trans = mysqli_fetch_assoc($query_run_current_asset_trans);
                                                        $current_asset_amount = $row_current_asset_trans['debit_amount'] - $row_current_asset_trans['credit_amount'];
                                                    }
                                                    else
                                                    {
                                                        $current_asset_amount = 0;
                                                    };
                                                    $current_asset_item = $row_current_asset_ledgers['ledger_desc'];
                                                    $current_asset_amount_f = number_format($current_asset_amount, 2, '.', ',');
                                                    $total_current_asset = $total_current_asset + $current_asset_amount;
                                                    $tb_4_amount = $tb_4_amount + $current_asset_amount;
                                                    if($current_asset_amount != 0)
                                                    {
                                                        echo'<tr>
                                                            <td>'.$current_asset_item.'</td>
                                                            <td class="amt-td">'.$current_asset_amount_f.'</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>';
                                                    };
                                                };
                                            };
                                        }
                                        else
                                        {
                                            $current_asset_item = 'CLOSING STOCK';
                                            $current_asset_amount = $total_closing_stock;
                                            $total_current_asset = $total_current_asset + $current_asset_amount;
                                            $tb_4_amount = $tb_4_amount + $current_asset_amount;
                                            $current_asset_amount_f = number_format($current_asset_amount, 2, '.', ',');
                                            echo'<tr>
                                                <td>'.$current_asset_item .'</td>
                                                <td class="amt-td">'.$current_asset_amount_f.'</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>';
                                        };
                                        $tb_4_amount_f = number_format($tb_4_amount, 2, '.', ',');
                                        if($tb_4_amount != 0)
                                        {
                                            echo'<tr>
                                                <td style="color:black;"><strong>TOTAL '.$row_tb_4['tb_4_desc'].'</strong></td>
                                                <td></td>
                                                <td class="amt-td" style="color:black;"><strong>'.$tb_4_amount_f.'</strong></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="amt-td"></td>
                                                <td></td>
                                                <td></td>
                                            </tr>';
                                        };
                                    };
                                };
                                
                                $total_current_asset_f = number_format($total_current_asset, 2, '.', ',');
                                echo'<tr>
                                        <td style="color:black;"><strong> TOTAL CURRENT ASSETS</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td class="amt-td" style="color:black;"><strong>'.$total_current_asset_f.'</strong></td>
                                        <td></td>
                                    </tr>';

                        //CURRENT LIABILITIES
                            echo '<tr style="background-color:#E4DCCF; color:black">
                                    <th colspan="14"><H6><strong>CURRENT LIABILITIES</strong></H6></th>
                                </tr>';
                                $query_tb4 = "SELECT * FROM trial_bal_group_4 WHERE tb_3_id=3";
                                $query_run_tb_4 = mysqli_query($con, $query_tb4);
                                if (mysqli_num_rows($query_run_tb_4) > 0)
                                {
                                    while($row_tb_4 = mysqli_fetch_assoc($query_run_tb_4))
                                    {
                                        $tb_4_amount = 0;
                                        $tb_4 = $row_tb_4['id'];
                                        $query_current_liabilities_ledgers = "SELECT * FROM ledgers WHERE 
                                        (company_id = '$company_id' AND tb_4 = '$tb_4') OR (tb_4 = '$tb_4' AND default_status = 'Yes')";
                                        $query_run_current_liabilities_ledgers = mysqli_query($con, $query_current_liabilities_ledgers);
                                        if (mysqli_num_rows($query_run_current_liabilities_ledgers) > 0)
                                        {
                                            while($row_current_liabilities_ledgers = mysqli_fetch_assoc($query_run_current_liabilities_ledgers))
                                            {
                                                $current_liabilities_amount = 0;
                                                $ledger_id = $row_current_liabilities_ledgers['ledger_id'];
                                                $query_current_liabilities_trans = "SELECT SUM(amount_debit) AS debit_amount, 
                                                SUM(amount_credit) AS credit_amount FROM transactions WHERE ledger_id = '$ledger_id' 
                                                AND date BETWEEN '2000-01-01' AND '$end_date' AND company_id = '$company_id'";
                                                $query_run_current_liabilities_trans = mysqli_query($con, $query_current_liabilities_trans);
                                                if (mysqli_num_rows($query_run_current_liabilities_trans) > 0)
                                                {
                                                    $row_current_liabilities_trans = mysqli_fetch_assoc($query_run_current_liabilities_trans);
                                                    $current_liabilities_amount = $row_current_liabilities_trans['credit_amount'] - $row_current_liabilities_trans['debit_amount'];
                                                }
                                                else
                                                {
                                                    $current_liabilities_amount = 0;
                                                };
                                                $current_liabilities_item = $row_current_liabilities_ledgers['ledger_desc'];
                                                $current_liabilities_amount_f = number_format($current_liabilities_amount, 2, '.', ',');
                                                $total_current_liabilities = $total_current_liabilities + $current_liabilities_amount;
                                                $tb_4_amount = $tb_4_amount + $current_liabilities_amount;
                                                if($current_liabilities_amount !=0)
                                                {
                                                    echo'<tr>
                                                        <td>'.$current_liabilities_item.'</td>
                                                        <td class="amt-td">'.$current_liabilities_amount_f.'</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>';
                                                };
                                            };
                                        };
                                        $tb_4_amount_f = number_format($tb_4_amount, 2, '.', ',');
                                        if($tb_4_amount != 0)
                                        {
                                            echo'<tr>
                                                <td style="color:black;"><strong>TOTAL '.$row_tb_4['tb_4_desc'].'</strong></td>
                                                <td></td>
                                                <td class="amt-td" style="color:black;"><strong>'.$tb_4_amount_f.'</strong></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="amt-td"></td>
                                                <td></td>
                                                <td></td>
                                            </tr>';
                                        };
                                    };
                                };
                                $total_current_liabilities_f = number_format($total_current_liabilities, 2, '.', ',');
                                $net_assets = 0;
                                $working_capital = $total_current_asset - $total_current_liabilities;
                                $net_assets = $working_capital + $total_fixed_asset;
                                $working_capital_f = number_format($working_capital, 2, '.', ',');
                                $net_assets_f = number_format($net_assets, 2, '.', ',');
                                echo'<tr>
                                    <td style="color:black;"><strong>TOTAL CURRENT LIABILITEIS</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td class="amt-td" style="color:black;"><strong>'.$total_current_liabilities_f.'</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="color:black;"><strong>WORKING CAPITAL</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="amt-td" style="color:black;"><strong>'.$working_capital_f.'</strong></td>
                                </tr>
                                <tr style="background-color:black; color:white">
                                    <td><h5><strong>NET ASSETS</strong></h5></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="amt-td"><h5><strong>'.$net_assets_f.'</strong></h5></td>
                                </tr>';
                        

                        //RESERVES
                            echo '<tr style="background-color:#E4DCCF; color:black">
                                <th colspan="14"><H6><strong>RESERVES</strong></H6></th>
                            </tr>';
                            
                                $query_reserves_ledgers = "SELECT * FROM ledgers WHERE 
                                (company_id = '$company_id' AND tb_3 = 4) OR (tb_3 = 4 AND default_status = 'Yes')";
                                $query_run_reserves_ledgers = mysqli_query($con, $query_reserves_ledgers);
                                if (mysqli_num_rows($query_run_reserves_ledgers) > 0)
                                {
                                    while($row_reserves_ledgers = mysqli_fetch_assoc($query_run_reserves_ledgers))
                                    {
                                        $reserves_amount = 0;
                                        $ledger_id = $row_reserves_ledgers['ledger_id'];
                                        $query_reserves_trans = "SELECT SUM(amount_debit) AS debit_amount, 
                                        SUM(amount_credit) AS credit_amount FROM transactions WHERE ledger_id = '$ledger_id' 
                                        AND date BETWEEN '2000-01-01' AND '$end_date' AND company_id = '$company_id'";
                                        $query_run_reserves_trans = mysqli_query($con, $query_reserves_trans);
                                        if (mysqli_num_rows($query_run_reserves_trans) > 0)
                                        {
                                            $row_reserves_trans = mysqli_fetch_assoc($query_run_reserves_trans);
                                            $reserves_amount = $row_reserves_trans['credit_amount'] - $row_reserves_trans['debit_amount'];
                                        }
                                        else
                                        {
                                            $reserves_amount = 0;
                                        };
                                        $reserves_item = $row_reserves_ledgers['ledger_desc'];
                                        $reserves_amount_f = number_format($reserves_amount, 2, '.', ',');
                                        $total_reserves = $total_reserves + $reserves_amount;
                                        if($reserves_amount != 0)
                                        {
                                            echo'<tr>
                                                <td>'.$reserves_item.'</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="amt-td">'.$reserves_amount_f.'</td>
                                            </tr>';
                                        };
                                    };
                                };
                                $total_reserves = $total_reserves + $net_profit + $previous_net_profit;
                                $previous_net_profit_f = number_format($previous_net_profit, 2, '.', ',');
                                $total_reserves_f = number_format($total_reserves, 2, '.', ',');
                                echo'<tr>
                                        <td>INCOME RESERVE (PREVIOUS)</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="amt-td">'.$previous_net_profit_f.'</td>
                                    </tr>
                                    <tr>
                                        <td>INCOME RESERVE (CURRENT)</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="amt-td">'.$net_profit_f.'</td>
                                    </tr>
                                    <tr style="background-color:black; color:white">
                                        <td><h5><strong>TOTAL RESERVES</strong></h5></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="amt-td"><h5><strong>'.$total_reserves_f.'</strong></h5></td>
                                    </tr>';
                        ?>
                    </tbody>
                </table>
        <?php
        };
        ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>