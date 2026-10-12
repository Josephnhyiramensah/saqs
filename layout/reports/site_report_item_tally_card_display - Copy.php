<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
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
    if(isset($_SESSION['site_report_item_tally_card_start_date']))
    {
        $site_id = $_SESSION['site_report_item_tally_card_site_id'];
        $start_date = $_SESSION['site_report_item_tally_card_start_date'];
        $end_date = $_SESSION['site_report_item_tally_card_end_date'];
        $company_id = $_SESSION['site_report_item_tally_card_company_id'];

        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);
        if ($site_id !=='all') 
        {
            $sql_site = "SELECT * FROM site WHERE site_id = '$site_id' AND company_id = '$company_id'";
            $result_site = mysqli_query($con,$sql_site);
            if (mysqli_num_rows($result_site) > 0)
            {
                $row_site = mysqli_fetch_array($result_site);
                $site_desc = $row_site['site'];
            }
            else
            {
                $site_desc = '--No Name Site--';
            };
        }
        else
        {
            $site_desc ='ALL SITES';
        };
        
            
?>
                <table class="table table-hover table-bordered table-sm" id="site_report_list_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class = "action-td" colspan="7"><H3><?php echo $row_company['trading_name'];?></H3></th>
                            </tr>
                            <tr>
                                <th class = "action-td" colspan="7"><H6><?php echo $site_desc;?> REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                            </tr>
                            <tr style="background-color:#E4DCCF; color:black">
                                <th class="action-td">S/NO</th>
                                <th class="action-td">DATE</th>
                                <th class="action-td">PARTICULARS</th>
                                <th class="action-td">OPENING BALANCE</th>
                                <th class="action-td">REVENUE</th>
                                <th class="action-td">EXPENDITURE</th>
                                <th class="action-td">CLOSONG BALANCE</th>
                            </tr>
                        </thead>
                            <tbody class="pv-table-body" id="site_report_list_table_body">
                                 
<?php 
    if ($site_id == 'all') 
    {
            $query="
            SELECT date, site_id, ob, expenditure, revenue, Reference, voucher_type, voucher_id FROM
            (
            SELECT  date AS date, site_id AS site_id, 0 AS ob, 0 AS expenditure, amount AS revenue, 
            'Purchases' AS Reference, 'purchases' AS voucher_type, purchase_id AS voucher_id FROM purchases 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'
            UNION ALL SELECT  date AS date, site_id AS site_id, 0 AS ob, amount AS expenditure, 0 AS revenue, 
            'Mtce Service Cost' AS Reference, 'mtce_led_list' AS voucher_type, 'mtce_led_list_id' AS voucher_id FROM mtce_led_list 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'
            UNION ALL SELECT  date AS date, site_id AS site_id, 0 AS ob, amount AS expenditure, 0 AS revenue, 
            'Mtce Stock Consumption' AS Reference, 'mtce_stock_list' AS voucher_type, mtce_stock_list_id AS voucher_id FROM mtce_stock_list 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'
            UNION ALL SELECT  date AS date, site_id AS site_id, 0  AS ob, amount_debit AS expenditure, 0 AS revenue, 
            'Other Expenses' AS Reference, 'payment' AS voucher_type, payment_id AS voucher_id FROM transactions 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0) AS c ORDER BY date ASC";

            $query_ob = "
            SELECT SUM(ob) AS ob FROM
            (
            SELECT site_id AS site_id, amount - 0 AS ob, 0 AS expenditure, 0 AS revenue, 
            'Purchases' AS Reference, 'purchases' AS voucher_type, purchase_id AS voucher_id FROM purchases 
            WHERE date < '$start_date' AND company_id = '$company_id'
            UNION ALL SELECT site_id AS site_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue, 
            'Mtce Service Cost' AS Reference, 'mtce_led_list' AS voucher_type, 'mtce_led_list_id' AS voucher_id FROM mtce_led_list 
            WHERE date < '$start_date' AND company_id = '$company_id'
            UNION ALL SELECT site_id AS site_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue, 
            'Mtce Stock Consumption' AS Reference, 'mtce_stock_list' AS voucher_type, mtce_stock_list_id AS voucher_id FROM mtce_stock_list 
            WHERE date < '$start_date' AND company_id = '$company_id'
            UNION ALL SELECT site_id AS site_id, 0 - amount_debit AS ob, 0 AS expenditure, 0 AS revenue, 
            'Other Expenses' AS Reference, 'payment' AS voucher_type, payment_id AS voucher_id FROM transactions 
            WHERE date < '$start_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0 ) AS d";
    } 
    else 
    {
            $query="
            SELECT date, site_id, Reference, ob, expenditure, revenue, voucher_type, voucher_id FROM
            (
            SELECT  date AS date, site_id AS site_id, 0 AS ob, 0 AS expenditure, amount AS revenue, 
            'Purchases' AS Reference, 'purchases' AS voucher_type, purchase_id AS voucher_id FROM purchases 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND site_id = '$site_id'
            UNION ALL SELECT  date AS date, site_id AS site_id, 0 AS ob, amount AS expenditure, 0 AS revenue, 
            'Mtce Service Cost' AS Reference, 'mtce_led_list' AS voucher_type, 'mtce_led_list_id' AS voucher_id FROM mtce_led_list 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND site_id = '$site_id'
            UNION ALL SELECT  date AS date, site_id AS site_id, 0 AS ob, amount AS expenditure, 0 AS revenue, 
            'Mtce Stock Consumption' AS Reference, 'mtce_stock_list' AS voucher_type, mtce_stock_list_id AS voucher_id FROM mtce_stock_list 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND site_id = '$site_id'
            UNION ALL SELECT  date AS date, site_id AS site_id, 0  AS ob, amount_debit AS expenditure, 0 AS revenue, 
            'Other Expenses' AS Reference, 'payment' AS voucher_type, payment_id AS voucher_id FROM transactions 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0 AND site_id = '$site_id')AS c ORDER BY date ASC";

            $query_ob = "
            SELECT SUM(ob) AS ob FROM
            (
            SELECT site_id AS site_id, amount - 0 AS ob, 0 AS expenditure, 0 AS revenue, 
            'Purchases' AS Reference, 'purchases' AS voucher_type, purchase_id AS voucher_id FROM purchases 
            WHERE date < '$start_date' AND company_id = '$company_id' AND site_id = '$site_id'
            UNION ALL SELECT site_id AS site_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue, 
            'Mtce Service Cost' AS Reference, 'mtce_led_list' AS voucher_type, 'mtce_led_list_id' AS voucher_id FROM mtce_led_list 
            WHERE date < '$start_date' AND company_id = '$company_id' AND site_id = '$site_id'
            UNION ALL SELECT site_id AS site_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue, 
            'Mtce Stock Consumption' AS Reference, 'mtce_stock_list' AS voucher_type, mtce_stock_list_id AS voucher_id  FROM mtce_stock_list 
            WHERE date < '$start_date' AND company_id = '$company_id' AND site_id = '$site_id'
            UNION ALL SELECT site_id AS site_id, 0 - amount_debit AS ob, 0 AS expenditure, 0 AS revenue, 
            'Other Expenses' AS Reference, 'payment' AS voucher_type, payment_id AS voucher_id FROM transactions 
            WHERE date < '$start_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0 AND site_id = '$site_id') AS d";
        
    };
        $query_run_ob = mysqli_query($con, $query_ob);
        $row_ob = mysqli_fetch_assoc($query_run_ob);
        $ob = $row_ob['ob'];
        $revenue = 0;
        $expenditure = 0;
?>
        <tr>
            <td class="action-td"></td>
            <td></td>
            <td>OPENING SURPLUS/(DEFICIT)</td>
            <td class="amt-td"><?php echo $ob;?></td>
            <td class="amt-td"></td>
            <td class="amt-td"></td>
            <td class="amt-td"></td>
        </tr>
<?php
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            $i=0;
            $total_revenue = 0;
            $total_expenditure = 0;
            while($row = mysqli_fetch_assoc($query_run))
            {
                ++$i;
                    $ob = $ob + $revenue - $expenditure;
                    $remarks = '';
                    if($row['voucher_type'] == 'purchases')
                    {
                        $remarks = '';
                        $purchase_id = $row['voucher_id'];
                        $sql_purchases = "SELECT * FROM purchases WHERE purchase_id = '$purchase_id'";
                        $result_purchases = mysqli_query($con,$sql_purchases);
                        $row_purchases = mysqli_fetch_array($result_purchases);
                        $remarks = 'TOP:'.$row_purchases['weight'].'DOWN:'.$row_purchases['water'].'PRICE:'.$row_purchases['price'].'AMOUNT'.$row_purchases['amount'];
                    }
                    else if($row['voucher_type'] == 'mtce_led_list')
                    {
                        $remarks = '';
                        $mtce_led_list_id = $row['voucher_id'];
                        $sql_mtce_led_list = "SELECT * FROM mtce_led_list WHERE mtce_led_list_id = '$mtce_led_list_id'";
                        $result_mtce_led_list = mysqli_query($con,$sql_mtce_led_list);
                        if (mysqli_num_rows($result_mtce_led_list) > 0)
                        {
                            while($row_mtce_led_list = mysqli_fetch_assoc($result_mtce_led_list))
                            {
                                $remarks .= 'REMARKS:'.$row_mtce_led_list['narration'].'AMOUNT:'.$row_mtce_led_list['amount'];
                            };
                        };
                    }
                    else if($row['voucher_type'] == 'mtce_stock_list')
                    {
                        $remarks = '';
                        $mtce_stock_list_id = $row['voucher_id'];
                        $sql_mtce_stock_list = "SELECT * FROM mtce_stock_list WHERE mtce_stock_list_id = '$mtce_stock_list_id'";
                        $result_mtce_stock_list = mysqli_query($con,$sql_mtce_stock_list);
                        if (mysqli_num_rows($result_mtce_stock_list) > 0)
                        {
                            $remarks .= '<table class="table table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="action-td"><small>ITEM</small></th>
                                    <th class="action-td"><small>QTY</small></th>
                                    <th class="action-td"><small>PRICE</small></th>
                                    <th class="action-td"><small>AMOUNT</small></th>
                                </tr>
                            </thead>
                                <tbody>';
                            while($row_mtce_stock_list = mysqli_fetch_assoc($result_mtce_stock_list))
                            {
                                $stock_id = $row_mtce_stock_list['stock_id'];
                                $sql_stock = "SELECT * FROM stock_items WHERE stock_item_id = '$stock_id'";
                                $result_stock = mysqli_query($con,$sql_stock);
                                if (mysqli_num_rows($result_stock) > 0)
                                {
                                    $row_stock = mysqli_fetch_assoc($result_stock);
                                    $stock_item = $row_stock['stock_item'];
                                }
                                else
                                {
                                    $stock_item = '--No Name Item--';
                                };
                                
                                $remarks .= '<tr>
                                                <td><small>'.$stock_item.'</small></td>
                                                <td class="action-td"><small>'.$row_mtce_stock_list['qty'].'</small></td>
                                                <td class="amt-td"><small>'.$row_mtce_stock_list['rate'].'</small></td>
                                                <td class="amt-td"><small>'.$row_mtce_stock_list['amount'].'</small></td>
                                            </tr>';
                                //$remarks .= $row_stock['stock_item'].' '.$row_mtce_stock_list['qty'].'@'.$row_mtce_stock_list['rate'].'='.$row_mtce_stock_list['amount'];
                            };
                        };
                        $remarks .= '</tbody>
                        </table>';
                    }
                    else if($row['voucher_type'] == 'payment')
                    {
                        $remarks = '';
                        $payment_id = $row['voucher_id'];
                        $sql_payment_item = "SELECT * FROM payment_items WHERE payment_id = '$payment_id'";
                        $result_payment_item = mysqli_query($con, $sql_payment_item);
                        if (mysqli_num_rows($result_payment_item) > 0)
                        {
                            while($row_payment_item = mysqli_fetch_assoc($result_payment_item))
                            {
                                $ledger_id = $row_payment_item['ledger_id'];
                                $sql_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
                                $result_ledger = mysqli_query($con,$sql_ledger);
                                $row_ledger= mysqli_fetch_assoc($result_ledger);
                                $remarks .= $row_ledger['ledger_desc'].': '.$row_payment_item['amount'].' NARRATION:'.$row_payment_item['narration'];
                            };
                        };
                    };
?>
                    <tr style="background-color:#E4E1E0; color:black">
                        <td class="action-td"><?php echo $i;?></td>
                        <td><?php echo $row['date'];?></td>
                        <td><?php echo $row['Reference'].': '.$row['voucher_id'];?>
                        <td class="amt-td"><?php echo number_format($ob, 2, '.', ',');?></td>
                        <td class="amt-td"><?php echo number_format($row['revenue'], 2, '.', ',');?></td>
                        <td class="amt-td"><?php echo number_format($row['expenditure'], 2, '.', ',');?></td>
                        <td class="amt-td"><?php echo number_format($ob + $row['revenue'] - $row['expenditure'], 2, '.', ',');?></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="4"><?php echo $remarks;?></td>
                        <td></td>
                    </tr>
<?php 
                $revenue = $row['revenue'];
                $expenditure = $row['expenditure'];
                $total_revenue = $total_revenue + $row['revenue'];
                $total_expenditure = $total_expenditure + $row['expenditure'];
            };
            $surplus = $row_ob['ob'] + $total_revenue - $total_expenditure;
            $total_revenue = number_format($total_revenue, 2, '.', ',');
            $total_expenditure = number_format($total_expenditure, 2, '.', ',');
            $surplus = number_format($surplus, 2, '.', ',');
        };

?>
        <tr>
            <td class="action-td"></td>
            <td></td>
            <td>CLOSING SURPLUS/(DEFICIT)</td>
            <td class="amt-td"></td>
            <td class="amt-td"></td>
            <td class="amt-td"></td>
            <td class="amt-td"><?php echo number_format($ob + $revenue - $expenditure, 2, '.', ',');?></td>
        </tr>
        <tr>
            <th class="amt-td" colspan="3">GRAND TOTAL</th>
            <th class="amt-td"><?php echo number_format($row_ob['ob'], 2, '.', ',');?></th>
            <th class="amt-td"><?php echo $total_revenue;?></th>
            <th class="amt-td"><?php echo $total_expenditure;?></th>
            <th class="amt-td"><?php echo $surplus;?></th>
        </tr>

    </tbody>
</table>
<?php
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>