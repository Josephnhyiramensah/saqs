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
    if(isset($_SESSION['asset_report_item_tally_card_start_date']))
    {
        $asset_id = $_SESSION['asset_report_item_tally_card_asset_id'];
        $start_date = $_SESSION['asset_report_item_tally_card_start_date'];
        $end_date = $_SESSION['asset_report_item_tally_card_end_date'];
        $company_id = $_SESSION['asset_report_item_tally_card_company_id'];

        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);
        if ($asset_id !=='all') 
        {
            $sql_asset = "SELECT * FROM assets WHERE asset_id = '$asset_id' AND company_id = '$company_id'";
            $result_asset = mysqli_query($con,$sql_asset);
            $row_asset = mysqli_fetch_array($result_asset);
            $asset_desc = $row_asset['brand'].' - '.$row_asset['model'];
        }
        else
        {
            $site_desc ='ALL SITES';
        };
        
            
?>
                <table class="table table-hover table-bordered table-sm" id="asset_report_list_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class = "action-td" colspan="11"><H3><?php echo $row_company['trading_name'];?></H3></th>
                            </tr>
                            <tr>
                                <th class = "action-td" colspan="11"><H6><?php echo $asset_desc;?> REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                            </tr>
                            <tr style="background-color:#E4DCCF; color:black">
                                <th class="action-td">S/NO</th>
                                <th class="action-td">DATE</th>
                                <th class="action-td">PARTICULARS</th>
                                <th class="action-td">SITE</th>
                                <th class="action-td">QTY</th>
                                <th class="action-td">PRICE</th>
                                <th class="action-td">AMOUNT</th>
                                <th class="action-td">OPENING BALANCE</th>
                                <th class="action-td">REVENUE</th>
                                <th class="action-td">EXPENDITURE</th>
                                <th class="action-td">CLOSONG BALANCE</th>
                            </tr>
                        </thead>
                            <tbody class="pv-table-body" id="asset_report_list_table_body">
                                 
<?php 
    if ($asset_id == 'all') 
    {
            $query="
            SELECT date, asset_id, ob, expenditure, revenue, Reference, voucher_id FROM
            (
            SELECT  date AS date, asset_id AS asset_id, 0 AS ob, 0 AS expenditure, amount AS revenue, 'Hiring' AS Reference, hiring_list_id AS voucher_id FROM hiring_list 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'
            UNION ALL SELECT  date AS date, asset_id AS asset_id, 0 AS ob, amount AS expenditure, 0 AS revenue, 'Mtce Service Cost' AS Reference, mtce_led_list_id AS voucher_id FROM mtce_led_list 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'
            UNION ALL SELECT  date AS date, asset_id AS asset_id, 0 AS ob, amount AS expenditure, 0 AS revenue, 'Mtce Stock Consumption' AS Reference, mtce_stock_list_id AS voucher_id FROM mtce_stock_list 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'
            UNION ALL SELECT  date AS date, asset_id AS asset_id, 0  AS ob, amount_debit AS expenditure, 0 AS revenue, 'Other Expenses' AS Reference, payment_id AS voucher_id FROM transactions 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0) AS c ORDER BY date ASC";

            $query_ob = "
            SELECT SUM(ob) AS ob FROM
            (
            SELECT asset_id AS asset_id, amount - 0 AS ob, 0 AS expenditure, 0 AS revenue, 'Hiring' AS Reference FROM hiring_list 
            WHERE date < '$start_date' AND company_id = '$company_id'
            UNION ALL SELECT asset_id AS asset_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue, 'Mtce Service Cost' AS Reference FROM mtce_led_list 
            WHERE date < '$start_date' AND company_id = '$company_id'
            UNION ALL SELECT asset_id AS asset_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue, 'Mtce Stock Consumption' AS Reference  FROM mtce_stock_list 
            WHERE date < '$start_date' AND company_id = '$company_id'
            UNION ALL SELECT asset_id AS asset_id, 0 - amount_debit AS ob, 0 AS expenditure, 0 AS revenue, 'Other Expenses' AS Reference  FROM transactions 
            WHERE date < '$start_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0 ) AS d";
    } 
    else 
    {
            $query="
            SELECT date, asset_id, Reference, ob, expenditure, revenue, voucher_id FROM
            (
            SELECT  date AS date, asset_id AS asset_id, 0 AS ob, 0 AS expenditure, amount AS revenue, 'Hiring' AS Reference, hiring_list_id AS voucher_id FROM hiring_list 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND asset_id = '$asset_id'
            UNION ALL SELECT  date AS date, asset_id AS asset_id, 0 AS ob, amount AS expenditure, 0 AS revenue, 'Mtce Service Cost' AS Reference, mtce_led_list_id AS voucher_id FROM mtce_led_list 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND asset_id = '$asset_id'
            UNION ALL SELECT  date AS date, asset_id AS asset_id, 0 AS ob, amount AS expenditure, 0 AS revenue, 'Mtce Stock Consumption' AS Reference, mtce_stock_list_id AS voucher_id FROM mtce_stock_list 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND asset_id = '$asset_id'
            UNION ALL SELECT  date AS date, asset_id AS asset_id, 0  AS ob, amount_debit AS expenditure, 0 AS revenue, 'Other Expenses' AS Reference, payment_id AS voucher_id FROM transactions 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0 AND asset_id = '$asset_id')AS c ORDER BY date ASC";

            $query_ob = "
            SELECT SUM(ob) AS ob FROM
            (
            SELECT asset_id AS asset_id, amount - 0 AS ob, 0 AS expenditure, 0 AS revenue, 'Hiring' AS Reference FROM hiring_list 
            WHERE date < '$start_date' AND company_id = '$company_id' AND asset_id = '$asset_id'
            UNION ALL SELECT asset_id AS asset_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue, 'Mtce Service Cost' AS Reference FROM mtce_led_list 
            WHERE date < '$start_date' AND company_id = '$company_id' AND asset_id = '$asset_id'
            UNION ALL SELECT asset_id AS asset_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue, 'Mtce Stock Consumption' AS Reference  FROM mtce_stock_list 
            WHERE date < '$start_date' AND company_id = '$company_id' AND asset_id = '$asset_id'
            UNION ALL SELECT asset_id AS asset_id, 0 - amount_debit AS ob, 0 AS expenditure, 0 AS revenue, 'Other Expenses' AS Reference  FROM transactions 
            WHERE date < '$start_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0 AND asset_id = '$asset_id') AS d";
        
    };
        $query_run_ob = mysqli_query($con, $query_ob);
        $row_ob = mysqli_fetch_assoc($query_run_ob);
        $ob = $row_ob['ob'];
        $revenue = 0;
        $expenditure = 0;
?>
        <tr>
            <td class="amt-td" colspan="7">OPENING SURPLUS/(DEFICIT)</td>
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
                    if($row['Reference'] == 'Hiring')
                    {
                        $hiring_list_id = $row['voucher_id'];
                        $sql_hiring_list = "SELECT * FROM hiring_list WHERE hiring_list_id = '$hiring_list_id'";
                        $result_hiring_list = mysqli_query($con,$sql_hiring_list);
                        if (mysqli_num_rows($result_hiring_list) > 0)
                        {
                            $row_hiring_list = mysqli_fetch_array($result_hiring_list);
                            
                            $hiring_id = $row_hiring_list['hiring_id'];
                            $sql_hiring = "SELECT * FROM hiring WHERE hiring_id = '$hiring_id'";
                            $result_hiring = mysqli_query($con,$sql_hiring);
                            if (mysqli_num_rows($result_hiring) > 0)
                            {
                                $row_hiring = mysqli_fetch_array($result_hiring);
                                $PARTICULARS = 'HIRING:'.$row_hiring['hired_by'].', '.$row_hiring['narration'];
                            }
                            else
                            {
                                $PARTICULARS = 'HIRING';
                            };
                            
                            $site_id = $row_hiring_list['site_id'];
                            $sql_site = "SELECT * FROM site WHERE site_id = '$site_id'";
                            $result_site = mysqli_query($con,$sql_site);
                            if (mysqli_num_rows($result_site) > 0)
                            {
                                $row_site = mysqli_fetch_array($result_site);
                                $SITE = $row_site['site'];
                            }
                            else
                            {
                                $SITE = 'N/A';
                            };
                            $AMOUNT = $row_hiring_list['amount'];
                            $PRICE = $row_hiring_list['rate'];
                            $QTY = $row_hiring_list['qty'];
                        }
                        else
                        {
                            $PARTICULARS = 'HIRING';
                            $SITE = '--No Particulars--';
                            $AMOUNT = 0;
                            $QTY = 0;
                            $PRICE = 0;
                        };
                    }
                    else if($row['Reference'] == 'Mtce Service Cost')
                    {
                        $PARTICULARS = '';
                        $mtce_led_list_id = $row['voucher_id'];
                        $sql_mtce_led_list = "SELECT * FROM mtce_led_list WHERE mtce_led_list_id = '$mtce_led_list_id'";
                        $result_mtce_led_list = mysqli_query($con,$sql_mtce_led_list);
                        if (mysqli_num_rows($result_mtce_led_list) > 0)
                        {
                            $row_mtce_led_list = mysqli_fetch_assoc($result_mtce_led_list);
                            $PARTICULARS = 'MAINTENANCE:'.$row_mtce_led_list['narration'];
                            $AMOUNT = $row_mtce_led_list['amount'];

                            $site_id = $row_mtce_led_list['site_id'];
                            $sql_site = "SELECT * FROM site WHERE site_id = '$site_id'";
                            $result_site = mysqli_query($con,$sql_site);
                            if (mysqli_num_rows($result_site) > 0)
                            {
                                $row_site = mysqli_fetch_array($result_site);
                                $SITE = $row_site['site'];
                            }
                            else
                            {
                                $SITE = 'N/A';
                            };
                            $QTY = 0;
                            $PRICE = 0;
                        }
                        else
                        {
                            $PARTICULARS = '--No Particulars--';
                            $AMOUNT = 0;
                            $PRICE = 0;
                            $QTY = 0;
                            $SITE = 'N/A';
                        };
                    }
                    else if($row['Reference'] == 'Mtce Stock Consumption')
                    {
                        $mtce_stock_list_id = $row['voucher_id'];
                        $sql_mtce_stock_list = "SELECT * FROM mtce_stock_list WHERE mtce_stock_list_id = '$mtce_stock_list_id'";
                        $result_mtce_stock_list = mysqli_query($con,$sql_mtce_stock_list);
                        if (mysqli_num_rows($result_mtce_stock_list) > 0)
                        {
                            $row_mtce_stock_list = mysqli_fetch_assoc($result_mtce_stock_list);
                            $stock_id = $row_mtce_stock_list['stock_id'];
                            $sql_stock = "SELECT * FROM stock_items WHERE stock_item_id = '$stock_id'";
                            $result_stock = mysqli_query($con,$sql_stock);
                            if (mysqli_num_rows($result_stock) > 0)
                            {
                                $row_stock = mysqli_fetch_assoc($result_stock);
                                $PARTICULARS = $row_stock['stock_item'];
                                $PRICE = $row_mtce_stock_list['rate'];
                                $QTY = $row_mtce_stock_list['qty'];
                                $AMOUNT = $row_mtce_stock_list['amount'];
                            }
                            else
                            {
                                $PARTICULARS = '--No Name Item--';
                                $PRICE = $row_mtce_stock_list['rate'];
                                $QTY = $row_mtce_stock_list['qty'];
                                $AMOUNT = $row_mtce_stock_list['amount'];
                            };
                                
                            $site_id = $row_mtce_stock_list['site_id'];
                            $sql_site = "SELECT * FROM site WHERE site_id = '$site_id'";
                            $result_site = mysqli_query($con,$sql_site);
                            if (mysqli_num_rows($result_site) > 0)
                            {
                                $row_site = mysqli_fetch_array($result_site);
                                $SITE = $row_site['site'];
                            }
                            else
                            {
                                $SITE = 'N/A';
                            };
                        }
                        else
                        {
                            $PARTICULARS = '--No Particulars--';
                            $PRICE = 0;
                            $AMOUNT = 0;
                            $QTY = 0;
                            $SITE = 'N/A';
                        };
                    }
                    else if($row['Reference'] == 'Other Expenses')
                    {
                        $payment_id = $row['voucher_id'];
                        $sql_payment_item = "SELECT * FROM payment_items WHERE payment_id = '$payment_id'";
                        $result_payment_item = mysqli_query($con, $sql_payment_item);
                        if (mysqli_num_rows($result_payment_item) > 0)
                        {
                            $row_payment_item = mysqli_fetch_assoc($result_payment_item);
                            $ledger_id = $row_payment_item['ledger_id'];
                            $sql_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
                            $result_ledger = mysqli_query($con,$sql_ledger);
                            $row_ledger= mysqli_fetch_assoc($result_ledger);
                            $PARTICULARS = $row_ledger['ledger_desc'].': '.$row_payment_item['narration'];
                            $PRICE = $row_payment_item['amount'];
                            $AMOUNT = $row_payment_item['amount'];
                            $SITE = 'N/A';
                            $QTY = 0;
                        }
                        else
                        {
                            $PARTICULARS = '--No Particulars--';
                            $PRICE = 0;
                            $AMOUNT = 0;
                            $SITE = 'N/A';
                            $QTY = 0;
                        };
                    }
                    else if($row['Reference'] != 'Hiring' &&
                            $row['voucher_type'] != 'Mtce Service Cost' &&
                            $row['voucher_type'] != 'Mtce Stock Consumption' &&
                            $row['voucher_type'] != 'Other Expenses')
                    {
                        $PARTICULARS = '--No Particulars--';
                        $PRICE = 0;
                        $AMOUNT = 0;
                        $SITE = 'N/A';
                        $QTY = 0;
                    };
?>
                    <tr>
                        <td class="action-td"><?php echo $i;?></td>
                        <td><?php echo $row['date'];?></td>
                        <td><?php echo $PARTICULARS;?>
                        <td><?php echo $SITE;?>
                        <td class="action-td"><?php echo $QTY;?></td>
                        <td class="amt-td"><?php echo number_format($PRICE, 2, '.', ',');?></td>
                        <td class="amt-td"><?php echo number_format($AMOUNT, 2, '.', ',');?></td>
                        <td class="amt-td"><?php echo number_format($ob, 2, '.', ',');?></td>
                        <td class="amt-td"><?php echo number_format($row['revenue'], 2, '.', ',');?></td>
                        <td class="amt-td"><?php echo number_format($row['expenditure'], 2, '.', ',');?></td>
                        <td class="amt-td"><?php echo number_format($ob + $row['revenue'] - $row['expenditure'], 2, '.', ',');?></td>
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
            <td class="amt-td" colspan="7">CLOSING SURPLUS/(DEFICIT)</td>
            <td class="amt-td"></td>
            <td class="amt-td"></td>
            <td class="amt-td"></td>
            <td class="amt-td"><?php echo number_format($ob + $revenue - $expenditure, 2, '.', ',');?></td>
        </tr>
        <tr>
            <th class="amt-td" colspan="7">GRAND TOTAL</th>
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