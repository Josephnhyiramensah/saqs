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
                    $i=0;
                    $total = 0;
                    $query_item = "SELECT * FROM stock_items ORDER BY stock_item ASC";
                    $query_run_item = mysqli_query($con, $query_item);
                    if(!empty($query_run_item) && mysqli_num_rows($query_run_item) > 0)
                    {
                        while($row_item = mysqli_fetch_assoc($query_run_item))
                        {
                            $item_desc = $row_item['stock_item'];
                            $item_id = $row_item['stock_item_id'];
                            if ($warehouse == 'all') 
                            {
                                $query="SELECT item_id, SUM(ob) AS ob, SUM(qty_in) AS qty_in, SUM(qty_out) AS qty_out FROM
                                (SELECT con_id AS item_id, warehouse_id, 0 - qty_issued AS ob,  0 AS qty_out, 0 AS qty_in FROM consumable_list 
                                WHERE con_id='$item_id' AND date < '$start_date'
                                UNION ALL SELECT drug_id AS item_id, warehouse_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM drug_patient_returns 
                                WHERE drug_id='$item_id' AND date < '$start_date'
                                UNION ALL SELECT drug_id AS item_id, warehouse_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in FROM drug_dispense_list 
                                WHERE drug_id='$item_id' AND date < '$start_date'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 - qty AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_sales_items 
                                WHERE stock_item_id='$item_id' AND date < '$start_date'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 - qty_out AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
                                WHERE stock_item_id='$item_id' AND  date < '$start_date'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 - qty_transferred AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
                                WHERE stock_item_id='$item_id' AND date_trans < '$start_date'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, qty_in - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
                                WHERE stock_item_id='$item_id' AND date < '$start_date'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, qty_received - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
                                WHERE stock_item_id='$item_id' AND date_trans < '$start_date'
                                UNION ALL SELECT item_id AS item_id, warehouse_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM purchase_items 
                                WHERE item_id='$item_id' AND date < '$start_date'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_sales_return_items 
                                WHERE stock_item_id='$item_id' AND date < '$start_date'
                                UNION ALL SELECT item_id AS item_id, warehouse_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in FROM purchase_return_items 
                                WHERE item_id='$item_id' AND date < '$start_date'

                                UNION ALL SELECT con_id AS item_id, warehouse_id, 0 AS ob,  qty_issued AS qty_out, 0 AS qty_in FROM consumable_list 
                                WHERE con_id='$item_id' AND date BETWEEN '$start_date' AND '$end_date'
                                UNION ALL SELECT drug_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM drug_patient_returns 
                                WHERE drug_id='$item_id' AND date BETWEEN '$start_date' AND '$end_date'
                                UNION ALL SELECT drug_id AS item_id, warehouse_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM drug_dispense_list 
                                WHERE drug_id='$item_id' AND date BETWEEN '$start_date' AND '$end_date'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM stock_sales_items 
                                WHERE stock_item_id='$item_id' AND date BETWEEN '$start_date' AND '$end_date'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  qty_out AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
                                WHERE stock_item_id='$item_id' AND  date BETWEEN '$start_date' AND '$end_date'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  qty_transferred AS qty_out, 0 AS qty_in FROM stock_transfer_items 
                                WHERE stock_item_id='$item_id' AND date_trans BETWEEN '$start_date' AND '$end_date'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty_in AS qty_in FROM stock_adjustment_items 
                                WHERE stock_item_id='$item_id' AND date BETWEEN '$start_date' AND '$end_date'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty_received AS qty_in FROM stock_transfer_items 
                                WHERE stock_item_id='$item_id' AND date_trans BETWEEN '$start_date' AND '$end_date'
                                UNION ALL SELECT item_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM purchase_items 
                                WHERE item_id='$item_id' AND date BETWEEN '$start_date' AND '$end_date'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM stock_sales_return_items 
                                WHERE stock_item_id='$item_id' AND date BETWEEN '$start_date' AND '$end_date'
                                UNION ALL SELECT item_id AS item_id, warehouse_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM purchase_return_items 
                                WHERE item_id='$item_id' AND date BETWEEN '$start_date' AND '$end_date') AS d GROUP BY item_id";
                            } 
                            else 
                            {
                                $query="SELECT item_id, SUM(ob) AS ob, SUM(qty_in) AS qty_in, SUM(qty_out) AS qty_out FROM
                                (SELECT con_id AS item_id, warehouse_id, category_id, 0 - qty_issued AS ob,  0 AS qty_out, 0 AS qty_in FROM consumable_list 
                                WHERE con_id=$item_id AND date < '$start_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM drug_patient_returns 
                                WHERE drug_id=$item_id AND date < '$start_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in FROM drug_dispense_list 
                                WHERE drug_id=$item_id AND date < '$start_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_sales_items 
                                WHERE stock_item_id=$item_id AND date < '$start_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 - qty_out AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
                                WHERE stock_item_id=$item_id AND  date < '$start_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 - qty_transferred AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
                                WHERE stock_item_id=$item_id AND date_trans < '$start_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, qty_in - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
                                WHERE stock_item_id=$item_id AND date < '$start_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, qty_received - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
                                WHERE stock_item_id=$item_id AND date_trans < '$start_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM purchase_items 
                                WHERE item_id=$item_id AND date < '$start_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_sales_return_items 
                                WHERE stock_item_id=$item_id AND date < '$start_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in FROM purchase_return_items 
                                WHERE item_id=$item_id AND date < '$start_date' AND warehouse_id ='$warehouse'

                                UNION ALL SELECT con_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty_issued AS qty_out, 0 AS qty_in FROM consumable_list 
                                WHERE con_id=$item_id AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM drug_patient_returns 
                                WHERE drug_id=$item_id AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT drug_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM drug_dispense_list 
                                WHERE drug_id=$item_id AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM stock_sales_items 
                                WHERE stock_item_id=$item_id AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty_out AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
                                WHERE stock_item_id=$item_id AND  date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty_transferred AS qty_out, 0 AS qty_in FROM stock_transfer_items 
                                WHERE stock_item_id=$item_id AND date_trans BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty_in AS qty_in FROM stock_adjustment_items 
                                WHERE stock_item_id=$item_id AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty_received AS qty_in FROM stock_transfer_items 
                                WHERE stock_item_id=$item_id AND date_trans BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM purchase_items 
                                WHERE item_id=$item_id AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT stock_item_id AS item_id, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM stock_sales_return_items 
                                WHERE stock_item_id=$item_id AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse'
                                UNION ALL SELECT item_id AS item_id, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM purchase_return_items 
                                WHERE item_id=$item_id AND date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse') AS d GROUP BY item_id";
                            };

                            $query_avg = "SELECT AVG(price) AS avg_cost FROM purchase_items WHERE item_id='$item_id' GROUP BY item_id";
                            $query_run_avg = mysqli_query($con, $query_avg);
                            if(!empty($query_run_avg) && mysqli_num_rows($query_run_avg) > 0)
                            {
                                $row_avg = mysqli_fetch_assoc($query_run_avg);
                                $avg_cost = $row_avg['avg_cost'];
                            }
                            else
                            {
                                $avg_cost = 0;
                            };

                            $query_run = mysqli_query($con, $query);
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    $i++;
                                    $cls_bal = $row['ob'] + $row['qty_in'] - $row['qty_out'];
                                    if($cls_bal > 0)
                                    {
                                        $cls_amt = $cls_bal*$avg_cost;
                                        $total = $total + $cls_amt;
                                    }
                                    else
                                    {
                                        $cls_amt = 0;
                                    };
                                    
                                    $avg_cost_f = number_format($avg_cost, 2, '.', ',');
                                    $cls_amt_f = number_format($cls_amt, 2, '.', ',');

                                    echo'<tr>
                                        <td class="action-td">'.$i.'</td>
                                        <td><a id="stock_report_item_tally_card" 
                                            href="#"
                                            data-id="'.$item_id.'"
                                            data-id2="'.$warehouse.'"
                                            data-id3="'.$start_date.'"
                                            data-id4="'.$end_date.'"
                                            data-id5="'.$company_id.'">
                                            '.$item_desc.'
                                            </a>
                                        </td>
                                        <td class="amt-td">'.$row['ob'].'</td>
                                        <td class="amt-td">'.$row['qty_in'].'</td>
                                        <td class="amt-td">'.$row['qty_out'].'</td>
                                        <td class="amt-td">'.$cls_bal.'</td>
                                        <td class="amt-td">'.$avg_cost_f.'</td>
                                        <td class="amt-td">'.$cls_amt_f.'</td>
                                    </tr>';
                                };
                            };
                        };
                    };
                    
                    $total_f = number_format($total, 2, '.', ',');
                    echo'<tr>
                        <th class="action-td" colspan="7">TOTAL</th>
                        <th class="amt-td">'.$total_f.'</th>
                    </tr>
                </tbody>
            </table>';
        };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>