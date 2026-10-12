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
    .scroll-card-body {max-height: 700px;overflow-y: auto;}
    .amt-td {text-align:right;}
    .action-td {text-align:center;}
</style>
<div class="container-fluid">
    <?php 
        if(isset($_SESSION['stock_report_start_date']))
        {           
            $company_id = $_SESSION['stock_report_company_id'];
            $user_id = $_SESSION['stock_report_user_id'];
            $user_super_id = $_SESSION['stock_report_user_super_id'];
            $warehouse = $_SESSION['stock_report_warehouse'];
            $start_date = $_SESSION['stock_report_start_date'];
            $end_date = $_SESSION['stock_report_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);

            $sql_warehouse = "SELECT * FROM warehouse WHERE warehouse_id = '$warehouse'";
            $result_warehouse = mysqli_query($con,$sql_warehouse);
            $row_warehouse = mysqli_fetch_array($result_warehouse);
    ?>
                    <table class="table table-hover table-bordered table-sm" id="stock_report_list_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class = "action-td" colspan="8"><H3><?php echo $row_company['trading_name'];?></H3></th>
                                </tr>
                                <tr>
                                    <th class = "action-td" colspan="8"><H6><?php if ($warehouse !== 'all'){echo $row_warehouse['warehouse_desc'].' ';}else{echo 'ALL WAREHOUSES ';};?> STOCK REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                                </tr>
                                <tr style="background-color:#E4DCCF; color:black">
                                    <th class="action-td">S/NO</th>
                                    <th class="action-td">ITEM</th>
                                    <th class="action-td">OPENING BALANCE</th>
                                    <th class="action-td">INWARDS</th>
                                    <th class="action-td">OUTWARDS</th>
                                    <th class="action-td">CLOSONG BALANCE</th>
                                    <th class="action-td">RATE</th>
                                    <th class="action-td">AMOUNT</th>
                                </tr>
                            </thead>
                                <tbody class="pv-table-body" id="stock_report_list_table_body">
                                 
<?php 
    if ($warehouse == 'all') 
    {
        $query="SELECT item_id, category_id, SUM(ob) AS ob, SUM(qty_in) AS qty_in, SUM(qty_out) AS qty_out FROM
        (SELECT con_id AS item_id, warehouse_id, category_id, 0 - qty_issued AS ob, 0 AS qty_out, 0 AS qty_in FROM consumable_list 
        WHERE category_id=7 AND date < '$start_date'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 - qty AS ob, 0 AS qty_out, 0 AS qty_in FROM drug_patient_returns 
        WHERE category_id=7 AND date < '$start_date'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 - qty AS ob, 0 AS qty_out, 0 AS qty_in FROM drug_dispense_list 
        WHERE category_id=7 AND date < '$start_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 - qty AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_sales_items 
        WHERE category_id=7 AND date < '$start_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 - qty_out AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE category_id=7 AND  date < '$start_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 - qty_transferred AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE category_id=7 AND date_trans < '$start_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, qty_in - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE category_id=7 AND date < '$start_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, qty_received - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE category_id=7 AND date_trans < '$start_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id,qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM purchase_items 
        WHERE category_id=7 AND date < '$start_date'

        UNION ALL SELECT con_id AS item_id, warehouse_id, category_id, 0 AS ob, qty_issued AS qty_out, 0 AS qty_in FROM consumable_list 
        WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM drug_patient_returns 
        WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM drug_dispense_list 
        WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM stock_sales_items 
        WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty_out AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE category_id=7 AND  date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty_transferred AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE category_id=7 AND date_trans BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty_in AS qty_in FROM stock_adjustment_items 
        WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty_received AS qty_in FROM stock_transfer_items 
        WHERE category_id=7 AND date_trans BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM purchase_items 
        WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date') AS c GROUP BY item_id UNION ALL

        SELECT item_id, category_id, SUM(ob) AS ob, SUM(qty_in) AS qty_in, SUM(qty_out) AS qty_out FROM
        (SELECT con_id AS item_id, warehouse_id, category_id, 0 - qty_issued AS ob,  0 AS qty_out, 0 AS qty_in FROM consumable_list 
        WHERE category_id=2 AND date < '$start_date'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM drug_patient_returns 
        WHERE category_id=2 AND date < '$start_date'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in FROM drug_dispense_list 
        WHERE category_id=2 AND date < '$start_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 - qty AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_sales_items 
        WHERE category_id=2 AND date < '$start_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 - qty_out AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE category_id=2 AND  date < '$start_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 - qty_transferred AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE category_id=2 AND date_trans < '$start_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, qty_in - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE category_id=2 AND date < '$start_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, qty_received - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE category_id=2 AND date_trans < '$start_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM purchase_items 
        WHERE category_id=2 AND date < '$start_date'

        UNION ALL SELECT con_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty_issued AS qty_out, 0 AS qty_in FROM consumable_list 
        WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM drug_patient_returns 
        WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM drug_dispense_list 
        WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM stock_sales_items 
        WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty_out AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE category_id=2 AND  date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty_transferred AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE category_id=2 AND date_trans BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty_in AS qty_in FROM stock_adjustment_items 
        WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty_received AS qty_in FROM stock_transfer_items 
        WHERE category_id=2 AND date_trans BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM purchase_items 
        WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date') AS d GROUP BY item_id";
    } 
    else 
    {
        $query="SELECT item_id, category_id, SUM(ob) AS ob, SUM(qty_in) AS qty_in, SUM(qty_out) AS qty_out FROM
        (SELECT con_id AS item_id, warehouse_id, category_id, 0 - qty_issued AS ob, 0 AS qty_out, 0 AS qty_in FROM consumable_list 
        WHERE category_id=7 AND date < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, qty - 0 AS ob, 0 AS qty_out, 0 AS qty_in FROM drug_patient_returns 
        WHERE category_id=7 AND date < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 - qty AS ob, 0 AS qty_out, 0 AS qty_in FROM drug_dispense_list 
        WHERE category_id=7 AND date < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 - qty AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_sales_items 
        WHERE category_id=7 AND date < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 - qty_out AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE category_id=7 AND  date < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 - qty_transferred AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE category_id=7 AND date_trans < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, qty_in - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE category_id=7 AND date < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, qty_received - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE category_id=7 AND date_trans < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id,qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM purchase_items 
        WHERE category_id=7 AND date < '$start_date' AND warehouse_id ='$warehouse'

        UNION ALL SELECT con_id AS item_id, warehouse_id, category_id, 0 AS ob, qty_issued AS qty_out, 0 AS qty_in FROM consumable_list 
        WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM drug_patient_returns 
        WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM drug_dispense_list 
        WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM stock_sales_items 
        WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty_out AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE category_id=7 AND  date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty_transferred AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE category_id=7 AND date_trans BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty_in AS qty_in FROM stock_adjustment_items 
        WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty_received AS qty_in FROM stock_transfer_items 
        WHERE category_id=7 AND date_trans BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM purchase_items 
        WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse') AS c GROUP BY item_id UNION ALL

        SELECT item_id, category_id, SUM(ob) AS ob, SUM(qty_in) AS qty_in, SUM(qty_out) AS qty_out FROM
        (SELECT con_id AS item_id, warehouse_id, category_id, 0 - qty_issued AS ob,  0 AS qty_out, 0 AS qty_in FROM consumable_list 
        WHERE category_id=2 AND date < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM drug_patient_returns 
        WHERE category_id=2 AND date < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in FROM drug_dispense_list 
        WHERE category_id=2 AND date < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_sales_items 
        WHERE category_id=2 AND date < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 - qty_out AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE category_id=2 AND  date < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 - qty_transferred AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE category_id=2 AND date_trans < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, qty_in - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE category_id=2 AND date < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, qty_received - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE category_id=2 AND date_trans < '$start_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM purchase_items 
        WHERE category_id=2 AND date < '$start_date' AND warehouse_id ='$warehouse'

        UNION ALL SELECT con_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty_issued AS qty_out, 0 AS qty_in FROM consumable_list 
        WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM drug_patient_returns 
        WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM drug_dispense_list 
        WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM stock_sales_items 
        WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty_out AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE category_id=2 AND  date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty_transferred AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE category_id=2 AND date_trans BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty_in AS qty_in FROM stock_adjustment_items 
        WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty_received AS qty_in FROM stock_transfer_items 
        WHERE category_id=2 AND date_trans BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
        UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM purchase_items 
        WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse') AS d GROUP BY item_id";
    };
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $i=0;
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                            ++$i;
                            $category_id = $row['category_id'];
                            $item_id = $row['item_id'];
                            if ($category_id == 2) 
                            {
                                $query_item = "SELECT * FROM drugs WHERE drug_id ='$item_id'";
                            } 
                            else if($row['category_id'] == 7) 
                            {
                                $query_item = "SELECT * FROM consumable WHERE con_id ='$item_id'";
                            };
                                $query_run_item = mysqli_query($con, $query_item);
                                $row_item = mysqli_fetch_assoc($query_run_item);

                            if ($row['category_id'] == 2) 
                            {
                                if(isset($row_item['brand_name']))
                                {
                                    $item_desc = $row_item['brand_name'];
                                }
                                else
                                {
                                    $item_desc = 'Drug Does Not Exist';
                                };
                            } 
                            else if($category_id == 7) 
                            {
                                $item_desc = $row_item['consumable'];
                            };
?>
                                <tr>
                                    <td class="action-td"><?php echo $i;?></td>
                                    <td><a id="stock_report_item_tally_card" 
                                        href="#"
                                        data-id="<?php echo $row['item_id'];?>"
                                        data-id1="<?php echo $row['category_id'];?>"
                                        data-id2="<?php echo $warehouse;?>"
                                        data-id3="<?php echo $start_date;?>"
                                        data-id4="<?php echo $end_date;?>"
                                        data-id5="<?php echo $company_id;?>">
                                        <?php echo $item_desc;?>
                                        </a>
                                    </td>
                                    <td class="amt-td"><?php echo $row['ob'];?></td>
                                    <td class="amt-td"><?php echo $row['qty_in'];?></td>
                                    <td class="amt-td"><?php echo $row['qty_out'];?></td>
                                    <td class="amt-td"><?php echo $row['ob'] + $row['qty_in'] - $row['qty_out'];?></td>
                                    <td></td>
                                    <td></td>
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