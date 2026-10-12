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
        if(isset($_SESSION['asset_report_start_date']))
        {           
            $company_id = $_SESSION['company_id'];
            //$user_id = $_SESSION['user_id'];
            //$user_super_id = $_SESSION['user_super_id'];
            $asset_id = $_SESSION['asset_report_asset'];
            $start_date = $_SESSION['asset_report_start_date'];
            $end_date = $_SESSION['asset_report_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);

            $sql_asset = "SELECT * FROM assets WHERE asset_id = '$asset_id' AND company_id = '$company_id'";
            $result_asset = mysqli_query($con,$sql_asset);
            $row_asset = mysqli_fetch_array($result_asset);
    ?>
                    <table class="table table-hover table-bordered table-sm" id="site_report_list_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class = "action-td" colspan="6"><H3><?php echo $row_company['trading_name'];?></H3></th>
                                </tr>
                                <tr>
                                    <th class = "action-td" colspan="6"><H6><?php if ($asset_id !== 'all'){echo $row_asset['brand'].' - '.$row_asset['model'];}else{echo 'ALL ASSETS ';};?> REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                                </tr>
                                <tr style="background-color:#E4DCCF; color:black">
                                    <th class="action-td">S/NO</th>
                                    <th class="action-td">PARTICULARS</th>
                                    <th class="action-td">OPENING SURPLUS/(DEFICIT)</th>
                                    <th class="action-td">REVENUE</th>
                                    <th class="action-td">EXPENDITURE</th>
                                    <th class="action-td">CLOSING SURPLUS/(DEFICIT)</th>
                                </tr>
                            </thead>
                                <tbody class="pv-table-body" id="asset_report_list_table_body">
                                 
<?php 
    if ($asset_id == 'all') 
    {
        $query="
        SELECT asset_id, SUM(ob) AS ob, SUM(revenue) AS revenue, SUM(expenditure) AS expenditure FROM
        (SELECT asset_id AS asset_id, amount - 0 AS ob, 0 AS expenditure, 0 AS revenue FROM hiring_list 
        WHERE date < '$start_date' AND company_id = '$company_id'

        UNION ALL SELECT asset_id AS asset_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue FROM mtce_led_list 
        WHERE date < '$start_date' AND company_id = '$company_id'

        UNION ALL SELECT asset_id AS asset_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue FROM mtce_stock_list 
        WHERE date < '$start_date' AND company_id = '$company_id'

        UNION ALL SELECT asset_id AS asset_id, 0 - amount_debit AS ob, 0 AS expenditure, 0 AS revenue FROM transactions 
        WHERE date < '$start_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0 AND asset_id != ''

        UNION ALL SELECT asset_id AS asset_id, 0 AS ob, 0 AS expenditure, amount AS revenue FROM hiring_list 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'

        UNION ALL SELECT asset_id AS asset_id, 0 AS ob, amount AS expenditure, 0 AS revenue FROM mtce_led_list 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'

        UNION ALL SELECT asset_id AS asset_id, 0 AS ob, amount AS expenditure, 0 AS revenue FROM mtce_stock_list 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'

        UNION ALL SELECT asset_id AS asset_id, 0 AS ob, amount_debit AS expenditure, 0 AS revenue FROM transactions 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0 AND asset_id != '') AS c GROUP BY asset_id";

    } 
    else 
    {
        $query="
        SELECT asset_id, SUM(ob) AS ob, SUM(revenue) AS revenue, SUM(expenditure) AS expenditure FROM
        (SELECT asset_id AS asset_id, amount - 0 AS ob, 0 AS expenditure, 0 AS revenue FROM hiring_list 
        WHERE date < '$start_date' AND company_id = '$company_id' AND asset_id = '$asset_id'

        UNION ALL SELECT asset_id AS asset_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue FROM mtce_led_list 
        WHERE date < '$start_date' AND company_id = '$company_id' AND asset_id = '$asset_id'

        UNION ALL SELECT asset_id AS asset_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue FROM mtce_stock_list 
        WHERE date < '$start_date' AND company_id = '$company_id' AND asset_id = '$asset_id'

        UNION ALL SELECT asset_id AS asset_id, 0 - amount_debit AS ob, 0 AS expenditure, 0 AS revenue FROM transactions 
        WHERE date < '$start_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0 AND asset_id = '$asset_id'

        UNION ALL SELECT asset_id AS asset_id, 0 AS ob, 0 AS expenditure, amount AS revenue FROM hiring_list 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND asset_id = '$asset_id'

        UNION ALL SELECT asset_id AS asset_id, 0 AS ob, amount AS expenditure, 0 AS revenue FROM mtce_led_list 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND asset_id = '$asset_id'

        UNION ALL SELECT asset_id AS asset_id, 0 AS ob, amount AS expenditure, 0 AS revenue FROM mtce_stock_list 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND asset_id = '$asset_id'

        UNION ALL SELECT asset_id AS asset_id, 0  AS ob, amount_debit AS expenditure, 0 AS revenue FROM transactions 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0 AND asset_id = '$asset_id') AS c GROUP BY asset_id";
    }
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $i=0;
                
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        ++$i;
                        $asset_id = $row['asset_id'];
                        $query_asset = "SELECT * FROM assets WHERE asset_id ='$asset_id'";
                  
                        $query_run_asset = mysqli_query($con, $query_asset);
                        $row_asset = mysqli_fetch_assoc($query_run_asset);
                        if(isset($row_asset)){$asset = $row_asset['brand'].' - '.$row_asset['model'];}else{$asset = 'No Asset';}

                        $ob = number_format($row['ob'], 2, '.', ',');
                        $revenue = number_format($row['revenue'], 2, '.', ',');
                        $expenditure = number_format($row['expenditure'], 2, '.', ',');
                        $cb = $row['ob'] + $row['revenue'] - $row['expenditure'];
                        $cb = number_format($cb, 2, '.', ',');
?>
                        <tr>
                            <td class="action-td"><?php echo $i;?></td>
                            <td><a id="asset_report_item_tally_card" 
                                href="#"
                                data-id="<?php echo $row['asset_id'];?>"
                                data-id3="<?php echo $start_date;?>"
                                data-id4="<?php echo $end_date;?>"
                                data-id5="<?php echo $company_id;?>">
                                <?php echo $asset;?>
                                </a>
                            </td>
                            <td class="amt-td"><?php echo $ob;?></td>
                            <td class="amt-td"><?php echo $revenue;?></td>
                            <td class="amt-td"><?php echo $expenditure;?></td>
                            <td class="amt-td"><?php echo $cb;?></td>
                        </tr>
<?php 
                        
                    };
                };
?>
                    </tbody>
                </table>
<?php
        };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>