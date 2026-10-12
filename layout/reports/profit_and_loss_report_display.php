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
        if(isset($_SESSION['plr_start_date']))
        {           
            $company_id = $_SESSION['plr_company_id'];
            $start_date = $_SESSION['plr_start_date'];
            $end_date = $_SESSION['plr_end_date'];

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
                    
                    $sales = 0;
                    $opening_stock = 0;
                    $closing_stock = 0;
                    $purchases = 0;
                    $cost_of_goods_available_for_sale = 0;
                    $cost_of_goods_sold = 0;
                    $gross_profit = 0;
                    $total_other_income = 0;
                    $other_income = 0;
                    $expense_item = 0;
                    $expense_amount = 0;
                    $total_expenses = 0;
                    $net_profit = 0;
                    $total_stock_closing_amount = 0;
                    $total_stock_opening_amount = 0;
                    $stock_average_price = 0;
                    $stock_opening_amount = 0;
                    $stock_cls_bal = 0;
                    $stock_closing_amount = 0;
                    $stock_purchase_price = 0;
                    $stock_purchase_qty = 0;
                    $stock_purchase_amount = 0;
                    $total_stock_purchase_amount = 0;
                    $stock_sold_price = 0;
                    $stock_sold_qty = 0;
                    $stock_sold_amount = 0;;
                    $total_stock_sold_amount = 0;;

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
                                $query_pap = "SELECT avg(price) AS avg_price FROM stock_purchase_items WHERE 
                                stock_item_id ='$item_id' AND date BETWEEN '2000-01-01' AND '$end_date' 
                                GROUP BY stock_item_id";
                                $query_run_pap = mysqli_query($con, $query_pap);
                                if(mysqli_num_rows($query_run_pap) > 0)
                                {
                                    $row_av_price = mysqli_fetch_assoc($query_run_pap);
                                    $stock_average_price = $row_av_price['avg_price'];
                                    $stock_opening_amount = $row['ob'] * $stock_average_price;
                                    $stock_cls_bal = $row['ob'] + $row['qty_in'] - $row['qty_out'];
                                    $stock_closing_amount = $stock_cls_bal * $stock_average_price;
                                }
                                else
                                {
                                    $stock_average_price = 0;
                                    $stock_opening_amount = 0 * $stock_average_price;
                                    $stock_cls_bal = 0;
                                    $stock_closing_amount = $stock_cls_bal * $stock_average_price;
                                };
                                //STOCK PURCHASES
                                    $query_pap_purchases = "SELECT * FROM stock_purchase_items WHERE 
                                    stock_item_id ='$item_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                    $query_run_pap_purchases = mysqli_query($con, $query_pap_purchases);
                                    if(mysqli_num_rows($query_run_pap_purchases) > 0)
                                    {
                                        while($row_pap_purchases = mysqli_fetch_assoc($query_run_pap_purchases))
                                        {
                                            $stock_purchase_price = $row_pap_purchases['price'];
                                            $stock_purchase_qty = $row_pap_purchases['qty'];
                                            $stock_purchase_amount = $stock_purchase_qty * $stock_purchase_price;
                                            $total_stock_purchase_amount = $total_stock_purchase_amount + $stock_purchase_amount;
                                        };
                                    }
                                    else
                                    {
                                        $stock_purchase_price = 0;
                                        $stock_purchase_qty = 0;
                                        $stock_purchase_amount = $stock_purchase_qty * $stock_purchase_price;
                                        $total_stock_purchase_amount = $total_stock_purchase_amount + $stock_purchase_amount;
                                    };
                                
                                //STOCK SOLD
                                    $query_pap_sold = "SELECT * FROM stock_sales_items WHERE 
                                    stock_item_id ='$item_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                    $query_run_pap_sold = mysqli_query($con, $query_pap_sold);
                                    if(mysqli_num_rows($query_run_pap_sold) > 0)
                                    {
                                        while($row_pap_sold = mysqli_fetch_assoc($query_run_pap_sold))
                                        {
                                            $stock_sold_price = $row_pap_sold['price'];
                                            $stock_sold_qty = $row_pap_sold['qty'];
                                            $stock_sold_amount = $stock_sold_qty * $stock_sold_price;
                                            $total_stock_sold_amount = $total_stock_sold_amount + $stock_sold_amount;
                                        };
                                    }
                                    else
                                    {
                                        $stock_sold_price = 0;
                                        $stock_sold_qty = 0;
                                        $stock_sold_amount = $stock_sold_qty * $stock_sold_price;
                                        $total_stock_sold_amount = $total_stock_sold_amount + $stock_sold_amount;
                                    };
                            }
                            else
                            {
                                $stock_average_price = 0;
                                $stock_opening_amount = 0 * $stock_average_price;
                                $stock_cls_bal = 0;
                                $stock_closing_amount = $stock_cls_bal * $stock_average_price;
                            };
                            $total_stock_opening_amount = $total_stock_opening_amount + $stock_opening_amount;
                            $total_stock_closing_amount = $total_stock_closing_amount + $stock_closing_amount;
                        };
                    };


            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
            <table class="table table-hover table-borderless table-sm" id="profitability_report_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="7"><H3><?php echo $row_company['trading_name'];?></H3></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="7"><H6>PROFIT AND LOSS ACCOUNT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                    </tr>
                    <tr>
                        <th class="action-td"></th>
                        <th class="action-td"></th>
                        <th class="action-td"></th>
                        <th class="action-td"><?php echo $row_company['currency'];?></th>
                        <th class="action-td"><?php echo $row_company['currency'];?></th>
                        <th class="action-td"><?php echo $row_company['currency'];?></th>
                        <th class="action-td"><?php echo $row_company['currency'];?></th>
                    </tr>
                </thead>
                    <tbody class="pv-table-body" id="profitability_report_list_table_body">
        <?php 
                        echo '<tr style="background-color:#E4DCCF; color:black">
                        <th colspan="7"><H6><strong>SALES</strong></H6></th>
                            </tr>';
                            $query_sales = "SELECT SUM(amount) AS sales_amount FROM sales WHERE 
                            company_id = '$company_id' AND date BETWEEN '$start_date' AND '$end_date'";
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
                            $total_sales = $sales + $stock_sold_amount;
                            $sales_f = number_format($sales, 2, '.', ',');
                            $stock_sold_amount_f = number_format($stock_sold_amount, 2, '.', ',');
                            $total_sales_f = number_format($total_sales, 2, '.', ',');
                                echo'<tr>
                                        <td></td>
                                        <td></td>
                                        <td>SALES (GOLD)</td>
                                        <td class="action-td"></td>
                                        <td class="action-td"></td>
                                        <td class="amt-td">'.$sales_f.'</td>
                                        <td class="amt-td"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>SALES (OTHER ITEMS)</td>
                                        <td class="action-td"></td>
                                        <td class="action-td"></td>
                                        <td class="amt-td">'.$stock_sold_amount_f.'</td>
                                        <td class="amt-td"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>TOTAL SALES</strong></td>
                                        <td></td>
                                        <td class="action-td"></td>
                                        <td class="action-td"></td>
                                        <td class="amt-td"></td>
                                        <td class="amt-td"><strong>'.$total_sales_f.'</strong></td>
                                    </tr>';

                        echo '<tr style="background-color:#E4DCCF; color:black">
                        <th colspan="7"><H6><strong>COST OF SALES</strong></H6></th>
                            </tr>';
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
                            $total_opening_stock = $opening_stock + $stock_opening_amount;
                            $opening_stock_f = number_format($opening_stock, 2, '.', ',');
                            $stock_opening_amount_f = number_format($stock_opening_amount, 2, '.', ',');
                            $total_opening_stock_f = number_format($total_opening_stock, 2, '.', ',');
                        
                            echo'<tr>
                                    <td></td>
                                    <td></td>
                                    <td>OPENING STOCK (GOLD)</td>
                                    <td class="amt-td">'.$opening_stock_f.'</td>
                                    <td class="amt-td"></td>
                                    <td class="amt-td"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>OPENING STOCK (OTHER ITEMS)</td>
                                    <td class="amt-td">'.$stock_opening_amount_f.'</td>
                                    <td class="amt-td"></td>
                                    <td class="amt-td"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><strong>TOTAL OPENING STOCK</strong></td>
                                    <td></td>
                                    <td class="amt-td"></td>
                                    <td class="amt-td"><strong>'.$total_opening_stock_f.'</strong></td>
                                    <td class="amt-td"></td>
                                    <td></td>
                                </tr>';
                        
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
                                $total_purchases = $purchases + $stock_purchase_amount;
                                $stock_purchase_amount_f = number_format($stock_purchase_amount, 2, '.', ',');
                                $purchases_f = number_format($purchases, 2, '.', ',');
                                $total_purchases_f = number_format($total_purchases, 2, '.', ',');
                                $cost_of_goods_available_for_sale = $total_opening_stock + $total_purchases;
                                $cost_of_goods_available_for_sale_f = number_format($cost_of_goods_available_for_sale, 2, '.', ',');
                        
                                echo'<tr>
                                        <td></td>
                                        <td></td>
                                        <td>PURCHASES (GOLD)</td>
                                        <td class="amt-td">'.$purchases_f.'</td>
                                        <td></td>
                                        <td class="amt-td"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>PURCHASES (OTHER ITEMS)</td>
                                        <td class="amt-td">'.$stock_purchase_amount_f.'</td>
                                        <td></td>
                                        <td class="amt-td"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>Add: TOTAL PURCHASES</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td class="amt-td"><strong>'.$total_purchases_f.'</strong></td>
                                        <td class="amt-td"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>COST OF GOODS AVAILABLE SALE</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="amt-td"><strong>'.$cost_of_goods_available_for_sale_f.'</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>';
                            
                            
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
                                $total_closing_stock = $closing_stock + $stock_closing_amount;
                                $cost_of_goods_sold = $cost_of_goods_available_for_sale - $total_closing_stock;
                                $gross_profit = $total_sales - $cost_of_goods_sold;
                                $closing_stock_f = number_format($closing_stock, 2, '.', ',');
                                $stock_closing_amount_f = number_format($stock_closing_amount, 2, '.', ',');
                                $total_closing_stock_f = number_format($total_closing_stock, 2, '.', ',');
                                $cost_of_goods_sold_f = number_format($cost_of_goods_sold, 2, '.', ',');
                                $gross_profit_f = number_format($gross_profit, 2, '.', ',');
                            
                            
                                echo'<tr>
                                        <td></td>
                                        <td></td>
                                        <td>CLOSING STOCK (GOLD)</td>
                                        <td class="amt-td">'.$closing_stock_f.'</td>
                                        <td class="amt-td"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>CLOSING STOCK (OTHER ITEMS)</td>
                                        <td class="amt-td">'.$stock_closing_amount_f.'</td>
                                        <td class="amt-td"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><strong>Less:TOTAL CLOSING STOCK</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td class="amt-td"><strong>'.$total_closing_stock_f.'</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>COST OF GOOD SOLD</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="amt-td"><strong>'.$cost_of_goods_sold_f.'</strong></td>
                                    </tr>
                                    <tr style="color:black;">
                                        <td><strong>GROSS PROFIT</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="amt-td"><strong>'.$gross_profit_f.'</strong></td>
                                    </tr>';
                            
                            echo '<tr style="background-color:#E4DCCF; color:black">
                                        <th colspan="7"><H6><strong>OTHER INCOME</strong></H6></th>
                                    </tr>';
                                
                                $query_other_income_ledgers = "SELECT * FROM ledgers WHERE 
                                (company_id = '$company_id' AND tb_2 = 3 AND ledger_id != 4 AND ledger_id != 35) 
                                OR (default_status = 'Yes' AND tb_2 = 3 AND ledger_id != 4 AND ledger_id != 35)";
                                $query_run_other_income_ledgers = mysqli_query($con, $query_other_income_ledgers);
                                $total_other_income = 0;
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
                                        $other_income_item = $row_other_income_ledgers['ledger_desc'];
                                        $other_income_amount_f = number_format($other_income_amount, 2, '.', ',');
                                        if($other_income_amount != 0)
                                        {
                                            echo'<tr>
                                                <td>'.$other_income_item.'</td>
                                                <td></td>
                                                <td class="amt-td">'.$other_income_amount_f.'</td>
                                                <td></td>
                                            </tr>';
                                        }
                                        $total_other_income = $total_other_income + $other_income_amount;
                                    };
                                    
                                    $total_other_income_f = number_format($total_other_income, 2, '.', ',');
                                    if($total_other_income != 0)
                                    {
                                        echo'<tr>
                                            <td><strong>TOTAL OTHER INCOME</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="amt-td"><strong>'.$total_other_income_f.'</strong></td>
                                        </tr>';
                                    }
                                };
                                $total_income = $total_other_income + $gross_profit;
                                $total_income_f = number_format($total_income, 2, '.', ',');
                                if($total_income != 0)
                                {
                                    echo'<tr style="color:black">
                                        <td><strong>TOTAL INCOME</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="amt-td"><strong>'.$total_income_f.'</strong></td>
                                    </tr>';
                                }

                                echo '<tr style="background-color:#E4DCCF; color:black">
                                        <th colspan="7"><H6><strong>Less: EXPENSES</strong></H6></th>
                                    </tr>';
                                
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
                                        SUM(amount_credit) AS amount_credit FROM transactions WHERE 
                                        ledger_id = '$ledger_id' AND date BETWEEN '$start_date' AND '$end_date' 
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
                                        if($expense_amount != 0)
                                        {
                                            echo'<tr>
                                                <td></td>
                                                <td>'.$expense_item.'</td>
                                                <td></td>
                                                <td></td>
                                                <td class="amt-td">'.$expense_amount_f.'</td>
                                                <td></td>
                                                <td></td>
                                            </tr>';
                                        }
                                        $total_expenses = $total_expenses + $expense_amount;
                                    };
                                };
                                $net_profit = $total_income - $total_expenses;
                                $total_expenses_f = number_format($total_expenses, 2, '.', ',');
                                $net_profit_f = number_format($net_profit, 2, '.', ',');
                                echo'<tr>
                                        <td><strong>TOTAL EXPENSES</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="amt-td"><strong>'.$total_expenses_f.'</strong></td>
                                    </tr>
                                    <tr style="color:black;">
                                        <td><strong>NET PROFIT</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="amt-td"><strong>'.$net_profit_f.'</strong></td>
                                    </tr>';
                                ?>
                            </tbody>
                        </table>
        <?php
        };
        ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>