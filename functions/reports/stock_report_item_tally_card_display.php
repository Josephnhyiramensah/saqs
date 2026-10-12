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
    if(isset($_SESSION['stock_report_item_tally_card_end_date']))
    {
        $item_id = $_SESSION['stock_report_item_tally_card_item_id'];
        $category_id = $_SESSION['stock_report_item_tally_card_category_id'];
        $warehouse = $_SESSION['stock_report_item_tally_card_warehouse_id'];
        $start_date = $_SESSION['stock_report_item_tally_card_start_date'];
        $end_date = $_SESSION['stock_report_item_tally_card_end_date'];
        $company_id = $_SESSION['stock_report_item_tally_card_company_id'];

        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);

        $sql_warehouse = "SELECT * FROM warehouse WHERE warehouse_id = '$warehouse'";
        $result_warehouse = mysqli_query($con,$sql_warehouse);
        $row_warehouse = mysqli_fetch_array($result_warehouse);

        //if ($category_id == 2) 
        //{
            $query_item = "SELECT * FROM drugs WHERE drug_id ='$item_id'";
            $query_run_item = mysqli_query($con, $query_item);
            $row_item = mysqli_fetch_assoc($query_run_item);
            $item_desc = $row_item['brand_name'];
        /*} 
        else if($category_id == 7) 
        {
            $query_item = "SELECT * FROM consumable WHERE con_id ='$item_id'";
            $query_run_item = mysqli_query($con, $query_item);
            $row_item = mysqli_fetch_assoc($query_run_item);
            $item_desc = $row_item['consumable'];
        };*/
            
?>
                <table class="table table-hover table-bordered table-sm" id="stock_report_list_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class = "action-td" colspan="7"><H3><?php echo $row_company['trading_name'];?></H3></th>
                            </tr>
                            <tr>
                                <th class = "action-td" colspan="7"><H6><?php echo $item_desc;?> TALLY CARD FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                            </tr>
                            <tr style="background-color:#E4DCCF; color:black">
                                <th class="action-td">S/NO</th>
                                <th class="action-td">DATE</th>
                                <th class="action-td">PARTICULARS</th>
                                <th class="action-td">OPENING BALANCE</th>
                                <th class="action-td">INWARDS</th>
                                <th class="action-td">OUTWARDS</th>
                                <th class="action-td">CLOSONG BALANCE</th>
                            </tr>
                        </thead>
                            <tbody class="pv-table-body" id="stock_report_list_table_body">
                                 
<?php 
    if ($warehouse == 'all') 
    {
        if ($category_id == 7) 
        {
            $query="
            SELECT date, item_id, Reference, voucher, warehouse_id, category_id, ob, qty_out, qty_in FROM
            (
            SELECT con_id AS item_id, attend_id AS Reference, 'Consumable_Issue' AS voucher, warehouse_id, category_id, 0 AS ob, qty_issued AS qty_out, 0 AS qty_in, 
            date AS date FROM consumable_list WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND con_id = '$item_id' AND qty_issued > 0

            UNION ALL SELECT drug_id AS item_id, drug_pat_return_id AS Reference, 'Patient_Drug_Return' AS voucher, warehouse_id, category_id, 0 AS ob, 0 AS qty_out, 
            qty AS qty_in, date AS date FROM drug_patient_returns WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND drug_id = '$item_id' AND qty > 0

            UNION ALL SELECT drug_id AS item_id, attend_id AS Reference, 'Drug_Dispense' AS voucher, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in, 
            date AS date FROM drug_dispense_list WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND drug_id = '$item_id' AND qty > 0

            UNION ALL SELECT stock_item_id AS item_id, stock_sales_id AS Reference, 'Stock_Sales' AS voucher, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 
            0 AS qty_in, date AS date FROM stock_sales_items WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND stock_item_id = '$item_id' AND qty > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, 0 AS ob,  qty_out AS qty_out, 
            0 AS qty_in, date AS date FROM stock_adjustment_items WHERE category_id=7 AND  date BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND qty_out > 0

            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, 0 AS ob,  qty_transferred AS qty_out, 
            0 AS qty_in, date_trans AS date FROM stock_transfer_items WHERE category_id=7 AND date_trans BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND qty_transferred > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, 
            qty_in AS qty_in, date AS date FROM stock_adjustment_items WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND qty_in > 0

            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, 
            qty_received AS qty_in, date_trans AS date FROM stock_transfer_items WHERE category_id=7 AND date_trans BETWEEN '$start_date' AND '$end_date' AND 
            item_id = '$item_id' AND qty_received > 0

            UNION ALL SELECT item_id AS item_id, purchase_id AS Reference, 'Purchase_Invoice' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, 
            qty AS qty_in, date AS date FROM purchase_items WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND qty > 0) 
            AS c ORDER BY date ASC";

            $query_ob = "
            SELECT SUM(ob) AS ob FROM
            (SELECT con_id AS item_id, attend_id AS Reference, 'Consumable_Issue' AS voucher, warehouse_id, category_id, 0 - qty_issued AS ob,  0 AS qty_out, 0 AS qty_in
            FROM consumable_list WHERE category_id=7 AND date < '$start_date' AND con_id = '$item_id' AND qty_issued > 0

            UNION ALL SELECT drug_id AS item_id, drug_pat_return_id AS Reference, 'Patient_Drug_Return' AS voucher, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 
            0 AS qty_in FROM drug_patient_returns WHERE category_id=7 AND date < '$start_date' AND drug_id = '$item_id' AND qty > 0

            UNION ALL SELECT drug_id AS item_id, attend_id AS Reference, 'Drug_Dispense' AS voucher, warehouse_id, category_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in
            FROM drug_dispense_list WHERE category_id=7 AND date < '$start_date' AND drug_id = '$item_id' AND qty > 0

            UNION ALL SELECT stock_item_id AS item_id, stock_sales_id AS Reference, 'Stock_Sales' AS voucher, warehouse_id, category_id, 0 - qty AS ob,  0 AS qty_out, 
            0 AS qty_in FROM stock_sales_items WHERE category_id=7 AND date < '$start_date' AND stock_item_id = '$item_id' AND qty > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, 0 - qty_out AS ob,  0 AS qty_out, 
            0 AS qty_in FROM stock_adjustment_items WHERE category_id=7 AND  date < '$start_date' AND item_id = '$item_id' AND qty_out > 0

            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, 0 - qty_transferred AS ob,  
            0 AS qty_out, 0 AS qty_in FROM stock_transfer_items WHERE category_id=7 AND date_trans < '$start_date' AND item_id = '$item_id' AND qty_transferred > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, 
            qty_in - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items WHERE category_id=7 AND date < '$start_date' AND item_id = '$item_id' AND qty_in > 0

            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, qty_received - 0 AS ob,  0 AS qty_out, 
            0 AS qty_in FROM stock_transfer_items WHERE category_id=7 AND date_trans < '$start_date' AND item_id = '$item_id' AND qty_received > 0

            UNION ALL SELECT item_id AS item_id, purchase_id AS Reference, 'Purchase_Invoice' AS voucher, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in
            FROM purchase_items WHERE category_id=7 AND date < '$start_date' AND item_id = '$item_id' AND qty > 0) AS d";
        } 
        else if($category_id == 2)
        {
            $query="
            SELECT date, item_id, Reference, voucher, warehouse_id, category_id, ob, qty_out, qty_in FROM
            (
            SELECT con_id AS item_id, attend_id AS Reference, 'Consumable_Issue' AS voucher, warehouse_id, category_id, 0 AS ob,  qty_issued AS qty_out, 0 AS qty_in, 
            date AS date FROM consumable_list WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND con_id = '$item_id' AND qty_issued > 0

            UNION ALL SELECT drug_id AS item_id, drug_pat_return_id AS Reference, 'Patient_Drug_Return' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, 
            qty AS qty_in, date AS date FROM drug_patient_returns WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND drug_id = '$item_id' AND qty > 0

            UNION ALL SELECT drug_id AS item_id, attend_id AS Reference, 'Drug_Dispense' AS voucher, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in, 
            date AS date FROM drug_dispense_list WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND drug_id = '$item_id' AND qty > 0

            UNION ALL SELECT stock_item_id AS item_id, stock_sales_id AS Reference, 'Stock_Sales' AS voucher, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 
            0 AS qty_in, date AS date FROM stock_sales_items WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND stock_item_id = '$item_id' AND qty > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, 0 AS ob,  qty_out AS qty_out, 
            0 AS qty_in, date AS date FROM stock_adjustment_items WHERE category_id=2 AND  date BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND qty_out > 0

            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, 0 AS ob,  qty_transferred AS qty_out, 
            0 AS qty_in, date_trans AS date FROM stock_transfer_items WHERE category_id=2 AND date_trans BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND qty_transferred > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, 
            qty_in AS qty_in, date AS date FROM stock_adjustment_items WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND qty_in > 0

            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, 
            qty_received AS qty_in, date_trans AS date FROM stock_transfer_items WHERE category_id=2 AND date_trans BETWEEN '$start_date' AND '$end_date' AND 
            item_id = '$item_id' AND qty_received > 0

            UNION ALL SELECT item_id AS item_id, purchase_id AS Reference, 'Purchase_Invoice' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty AS qty_in,
            date AS date FROM purchase_items WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND qty > 0) AS c ORDER BY date ASC";

            $query_ob = "
            SELECT SUM(ob) AS ob FROM
            (SELECT con_id AS item_id, attend_id AS Reference, 'Consumable_Issue' AS voucher, warehouse_id, category_id, 0 - qty_issued AS ob,  0 AS qty_out, 0 AS qty_in
            FROM consumable_list WHERE category_id=2 AND date < '$start_date' AND con_id = '$item_id' AND qty_issued > 0
            
            UNION ALL SELECT drug_id AS item_id, drug_pat_return_id AS Reference, 'Patient_Drug_Return' AS voucher, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 
            0 AS qty_in FROM drug_patient_returns WHERE category_id=2 AND date < '$start_date' AND drug_id = '$item_id' AND qty > 0

            UNION ALL SELECT drug_id AS item_id, attend_id AS Reference, 'Drug_Dispense' AS voucher, warehouse_id, category_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in
            FROM drug_dispense_list WHERE category_id=2 AND date < '$start_date' AND drug_id = '$item_id' AND qty > 0

            UNION ALL SELECT stock_item_id AS item_id, stock_sales_id AS Reference, 'Stock_Sales' AS voucher, warehouse_id, category_id, 0 - qty AS ob,  0 AS qty_out, 
            0 AS qty_in FROM stock_sales_items WHERE category_id=2 AND date < '$start_date' AND stock_item_id = '$item_id' AND qty > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, 0 - qty_out AS ob,  0 AS qty_out, 
            0 AS qty_in FROM stock_adjustment_items WHERE category_id=2 AND  date < '$start_date' AND item_id = '$item_id' AND qty_out > 0

            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, 0 - qty_transferred AS ob,  
            0 AS qty_out, 0 AS qty_in FROM stock_transfer_items WHERE category_id=2 AND date_trans < '$start_date' AND item_id = '$item_id' AND qty_transferred > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, qty_in - 0 AS ob,  0 AS qty_out, 
            0 AS qty_in FROM stock_adjustment_items WHERE category_id=2 AND date < '$start_date' AND item_id = '$item_id' AND qty_in > 0

            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, qty_received - 0 AS ob,  0 AS qty_out, 
            0 AS qty_in FROM stock_transfer_items WHERE category_id=2 AND date_trans < '$start_date' AND item_id = '$item_id' AND qty_received > 0

            UNION ALL SELECT item_id AS item_id, purchase_id AS Reference, 'Purchase_Invoice' AS voucher, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in
            FROM purchase_items WHERE category_id=2 AND date < '$start_date' AND item_id = '$item_id' AND qty > 0) AS d";
        };
    } 
    else 
    {
        if ($category_id == 7) 
        {
            $query="
            SELECT date, item_id, Reference, voucher, warehouse_id, category_id, ob, qty_out, qty_in FROM
            (
            SELECT con_id AS item_id, attend_id AS Reference, 'Consumable_Issue' AS voucher, warehouse_id, category_id, 0 AS ob, qty_issued AS qty_out, 0 AS qty_in, 
            date AS date FROM consumable_list WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND con_id = '$item_id' AND warehouse_id = '$warehouse' AND qty_issued > 0

            UNION ALL SELECT drug_id AS item_id, drug_pat_return_id AS Reference, 'Patient_Drug_Return' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, 
            qty AS qty_in, date AS date FROM drug_patient_returns WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND drug_id = '$item_id' AND 
            warehouse_id = '$warehouse' AND qty > 0

            UNION ALL SELECT drug_id AS item_id, attend_id AS Reference, 'Drug_Dispense' AS voucher, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in, 
            date AS date FROM drug_dispense_list WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND drug_id = '$item_id' AND warehouse_id = '$warehouse' AND qty > 0

            UNION ALL SELECT stock_item_id AS item_id, stock_sales_id AS Reference, 'Stock_Sales' AS voucher, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 
            0 AS qty_in, date AS date FROM stock_sales_items WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND stock_item_id = '$item_id' AND 
            warehouse_id = '$warehouse' AND qty > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, 0 AS ob,  qty_out AS qty_out, 0
            AS qty_in, date AS date FROM stock_adjustment_items WHERE category_id=7 AND  date BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND 
            warehouse_id = '$warehouse' AND qty_out > 0

            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, 0 AS ob,  qty_transferred AS qty_out, 
            0 AS qty_in, date_trans AS date FROM stock_transfer_items WHERE category_id=7 AND date_trans BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND 
            warehouse_id = '$warehouse' AND qty_transferred > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty_in AS 
            qty_in, date AS date FROM stock_adjustment_items WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND 
            warehouse_id = '$warehouse' AND qty_in > 0

            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty_received AS 
            qty_in, date_trans AS date FROM stock_transfer_items WHERE category_id=7 AND date_trans BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND 
            warehouse_id = '$warehouse' AND qty_received > 0

            UNION ALL SELECT item_id AS item_id, purchase_id AS Reference, 'Purchase_Invoice' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty AS qty_in, 
            date AS date FROM purchase_items WHERE category_id=7 AND date BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND warehouse_id = '$warehouse' AND qty > 0) AS 
            c ORDER BY date ASC";

            $query_ob = "
            SELECT SUM(ob) AS ob FROM
            (SELECT con_id AS item_id, attend_id AS Reference, 'Consumable_Issue' AS voucher, warehouse_id, category_id, 0 - qty_issued AS ob,  0 AS qty_out, 0 AS qty_in
            FROM consumable_list WHERE category_id=7 AND date < '$start_date' AND con_id = '$item_id' AND warehouse_id = '$warehouse' AND qty_issued > 0

            UNION ALL SELECT drug_id AS item_id, drug_pat_return_id AS Reference, 'Patient_Drug_Return' AS voucher, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 
            0 AS qty_in FROM drug_patient_returns WHERE category_id=7 AND date < '$start_date' AND drug_id = '$item_id' AND warehouse_id = '$warehouse' AND qty > 0

            UNION ALL SELECT drug_id AS item_id, attend_id AS Reference, 'Drug_Dispense' AS voucher, warehouse_id, category_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in
            FROM drug_dispense_list WHERE category_id=7 AND date < '$start_date' AND drug_id = '$item_id' AND warehouse_id = '$warehouse' AND qty > 0

            UNION ALL SELECT stock_item_id AS item_id, stock_sales_id AS Reference, 'Stock_Sales' AS voucher, warehouse_id, category_id, 0 - qty AS ob,  0 AS qty_out, 
            0 AS qty_in FROM stock_sales_items WHERE category_id=7 AND date < '$start_date' AND stock_item_id = '$item_id' AND warehouse_id = '$warehouse' AND qty > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, 0 - qty_out AS ob,  0 AS qty_out, 
            0 AS qty_in FROM stock_adjustment_items WHERE category_id=7 AND  date < '$start_date' AND item_id = '$item_id' AND warehouse_id = '$warehouse' AND qty_out > 0

            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, 0 - qty_transferred AS ob,  
            0 AS qty_out, 0 AS qty_in FROM stock_transfer_items WHERE category_id=7 AND date_trans < '$start_date' AND item_id = '$item_id' AND warehouse_id = '$warehouse' AND qty_transferred > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, qty_in - 0 AS ob,  0 AS qty_out, 
            0 AS qty_in FROM stock_adjustment_items WHERE category_id=7 AND date < '$start_date' AND item_id = '$item_id' AND warehouse_id = '$warehouse' AND qty_in > 0

            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, qty_received - 0 AS ob,  0 AS qty_out, 
            0 AS qty_in FROM stock_transfer_items WHERE category_id=7 AND date_trans < '$start_date' AND item_id = '$item_id' AND warehouse_id = '$warehouse' AND qty_received > 0

            UNION ALL SELECT item_id AS item_id, purchase_id AS Reference, 'Purchase_Invoice' AS voucher, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in
            FROM purchase_items WHERE category_id=7 AND date < '$start_date' AND item_id = '$item_id' AND warehouse_id = '$warehouse' AND qty > 0) AS d";
        } 
        else if($category_id == 2) 
        {
            $query="
            SELECT date, item_id, Reference, voucher, warehouse_id, category_id, ob, qty_out, qty_in FROM
            (SELECT con_id AS item_id, attend_id AS Reference, 'Consumable_Issue' AS voucher, warehouse_id, category_id, 0 AS ob,  qty_issued AS qty_out, 0 AS qty_in, 
            date AS date FROM consumable_list WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND con_id = '$item_id' AND warehouse_id = '$warehouse' AND qty_issued > 0

            UNION ALL SELECT drug_id AS item_id, drug_pat_return_id AS Reference, 'Patient_Drug_Return' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, 
            qty AS qty_in, date AS date FROM drug_patient_returns WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND drug_id = '$item_id' AND 
            warehouse_id = '$warehouse' AND qty > 0

            UNION ALL SELECT drug_id AS item_id, attend_id AS Reference, 'Drug_Dispense' AS voucher, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in, 
            date AS date FROM drug_dispense_list WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND drug_id = '$item_id' AND warehouse_id = '$warehouse' AND qty > 0 

            UNION ALL SELECT stock_item_id AS item_id, stock_sales_id AS Reference, 'Stock_Sales' AS voucher, warehouse_id, category_id, 0 AS ob,  qty AS qty_out, 
            0 AS qty_in, date AS date FROM stock_sales_items WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND stock_item_id = '$item_id' AND 
            warehouse_id = '$warehouse' AND qty > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, 0 AS ob,  qty_out AS qty_out, 
            0 AS qty_in, date AS date FROM stock_adjustment_items WHERE category_id=2 AND  date BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND 
            warehouse_id = '$warehouse' AND qty_out > 0
            
            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, 0 AS ob,  qty_transferred AS qty_out, 
            0 AS qty_in, date_trans AS date FROM stock_transfer_items WHERE category_id=2 AND date_trans BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND 
            warehouse_id = '$warehouse' AND qty_transferred > 0
            
            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty_in AS 
            qty_in, date AS date FROM stock_adjustment_items WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND 
            warehouse_id = '$warehouse' AND qty_in > 0
            
            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, 
            qty_received AS qty_in, date_trans AS date FROM stock_transfer_items WHERE category_id=2 AND date_trans BETWEEN '$start_date' AND '$end_date' AND 
            item_id = '$item_id' AND warehouse_id = '$warehouse' AND qty_received > 0
            
            UNION ALL SELECT item_id AS item_id, purchase_id AS Reference, 'Purchase_Invoice' AS voucher, warehouse_id, category_id, 0 AS ob,  0 AS qty_out, qty AS qty_in, 
            date AS date FROM purchase_items WHERE category_id=2 AND date BETWEEN '$start_date' AND '$end_date' AND item_id = '$item_id' AND warehouse_id = '$warehouse' AND qty > 0) 
            AS c ORDER BY date ASC";
    
            $query_ob = "
            SELECT SUM(ob) AS ob FROM
            (SELECT con_id AS item_id, attend_id AS Reference, 'Consumable_Issue' AS voucher, warehouse_id, category_id, 0 - qty_issued AS ob,  0 AS qty_out, 0 AS qty_in
            FROM consumable_list WHERE category_id=2 AND date < '$start_date' AND con_id = '$item_id' AND warehouse_id = '$warehouse' AND qty_issued > 0

            UNION ALL SELECT drug_id AS item_id, drug_pat_return_id AS Reference, 'Patient_Drug_Return' AS voucher, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 
            0 AS qty_in FROM drug_patient_returns WHERE category_id=2 AND date < '$start_date' AND drug_id = '$item_id' AND warehouse_id = '$warehouse' AND qty > 0

            UNION ALL SELECT drug_id AS item_id, attend_id AS Reference, 'Drug_Dispense' AS voucher, warehouse_id, category_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in
            FROM drug_dispense_list WHERE category_id=2 AND date < '$start_date' AND drug_id = '$item_id' AND warehouse_id = '$warehouse' AND qty > 0 

            UNION ALL SELECT stock_item_id AS item_id, stock_sales_id AS Reference, 'Stock_Sales' AS voucher, warehouse_id, category_id, 
            0 - qty AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_sales_items WHERE category_id=2 AND date < '$start_date' AND stock_item_id = '$item_id' AND 
            warehouse_id = '$warehouse' AND qty > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, 0 - qty_out AS ob,  0 AS qty_out, 
            0 AS qty_in FROM stock_adjustment_items WHERE category_id=2 AND  date < '$start_date' AND item_id = '$item_id' AND warehouse_id = '$warehouse' AND qty_out > 0

            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, 0 - qty_transferred AS ob,  
            0 AS qty_out, 0 AS qty_in FROM stock_transfer_items WHERE category_id=2 AND date_trans < '$start_date' AND item_id = '$item_id' AND warehouse_id = '$warehouse' AND qty_transferred > 0

            UNION ALL SELECT item_id AS item_id, stock_adj_id AS Reference, 'Stock_Adjustment' AS voucher, warehouse_id, category_id, qty_in - 0 AS ob,  0 AS qty_out, 
            0 AS qty_in FROM stock_adjustment_items WHERE category_id=2 AND date < '$start_date' AND item_id = '$item_id' AND warehouse_id = '$warehouse' AND qty_in > 0

            UNION ALL SELECT item_id AS item_id, stock_trans_id AS Reference, 'Stock_Transfer' AS voucher, warehouse_id, category_id, qty_received - 0 AS ob,  0 AS qty_out, 
            0 AS qty_in FROM stock_transfer_items WHERE category_id=2 AND date_trans < '$start_date' AND item_id = '$item_id' AND warehouse_id = '$warehouse' AND qty_received > 0

            UNION ALL SELECT item_id AS item_id, purchase_id AS Reference, 'Purchase_Invoice' AS voucher, warehouse_id, category_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in
            FROM purchase_items WHERE category_id=2 AND date < '$start_date' AND item_id = '$item_id' AND warehouse_id = '$warehouse' AND qty > 0 ) AS d";
        };
    };
        $query_run_ob = mysqli_query($con, $query_ob);
        //$error = mysqli_error($con);
        //echo $error;
        $row_ob = mysqli_fetch_assoc($query_run_ob);
        $ob = $row_ob['ob'];
        $obl = $row_ob['ob'];
        $qty_in = 0;
        $qty_out = 0;
?>
        <tr>
            <td class="action-td"></td>
            <td></td>
            <td>OPENING BALANCE</td>
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
            $total_inward = 0;
            $total_outward = 0;
            while($row = mysqli_fetch_assoc($query_run))
            {
                $voucher_type = $row['voucher'];
                $voucher_id = $row['Reference'];
                $narration = '';
                
                if($voucher_type == 'Consumable_Issue'/*attend_id*/)
                {
                    $query_voucher = "SELECT * FROM attendance WHERE attend_id = '$voucher_id'";
                    $result_voucher = mysqli_query($con,$query_voucher);
                    if(isset($result_voucher) && $result_voucher != '')
                    {
                        $row_voucher = mysqli_fetch_assoc($result_voucher);
                        if(isset($patient_id) && $patient_id !='')
                        {
                            $patient_id = $row_voucher['patient_id'];
                            $query_voucher_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
                            $result_voucher_patient = mysqli_query($con,$query_voucher_patient);
                            $row_voucher_patient = mysqli_fetch_assoc($result_voucher_patient);
                            $narration = $row_voucher_patient['full_name'].': '.$row_voucher_patient['folderNo'];
                        }
                        else
                        {
                            $narration = 'N/A';
                        };
                    }
                    else
                    {
                        $narration = 'N/A';
                    };
                }
                else if($voucher_type == 'Patient_Drug_Return'/*drug_pat_return_id*/)
                {
                    $query_voucher = "SELECT * FROM drug_patient_returns WHERE drug_pat_return_id = '$voucher_id'";
                    $result_voucher = mysqli_query($con,$query_voucher);
                    
                    if(isset($result_voucher) && $result_voucher != '')
                    {
                        $row_voucher = mysqli_fetch_assoc($result_voucher);
                        $patient_id = $row_voucher['patient_id'];
                        $query_voucher_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
                        $result_voucher_patient = mysqli_query($con,$query_voucher_patient);
                        $row_voucher_patient = mysqli_fetch_assoc($result_voucher_patient);
                        $narration = $row_voucher_patient['full_name'].': '.$row_voucher_patient['folderNo'];
                    }
                    else
                    {
                        $narration = 'N/A';
                    };
                }
                else if($voucher_type == 'Drug_Dispense'/*attend_id*/)
                {
                    $query_voucher = "SELECT * FROM attendance WHERE attend_id = '$voucher_id'";
                    $result_voucher = mysqli_query($con,$query_voucher);
                    if(isset($result_voucher) && $result_voucher != '')
                    {
                        $row_voucher = mysqli_fetch_assoc($result_voucher);
                        $patient_id = $row_voucher['patient_id'];
                        $query_voucher_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
                        $result_voucher_patient = mysqli_query($con,$query_voucher_patient);
                        $row_voucher_patient = mysqli_fetch_assoc($result_voucher_patient);
                        $narration = 'Patient name: '.$row_voucher_patient['full_name'].', Folder No:'.$row_voucher_patient['folderNo'];
                    }
                    else
                    {
                        $narration = 'N/A';
                    };
                }
                else if($voucher_type == 'Stock_Sales'/*stock_sales_id*/)
                {
                    $query_voucher = "SELECT * FROM stock_sales WHERE stock_sales_id = '$voucher_id'";
                    $result_voucher = mysqli_query($con,$query_voucher);
                    $row_voucher = mysqli_fetch_assoc($result_voucher);
                    $narration = 'Sold to: '.$row_voucher['supplied_by'].', '.$row_voucher['received_by'];
                }
                else if($voucher_type == 'Stock_Adjustment'/*stock_adj_id*/)
                {
                    $query_voucher = "SELECT * FROM stock_adjustment WHERE stock_adj_id = '$voucher_id'";
                    $result_voucher = mysqli_query($con,$query_voucher);
                    $row_voucher = mysqli_fetch_assoc($result_voucher);
                    $narration = 'Adjusted By: '.$row_voucher['adjusted_by'].', '.$row_voucher['narration'];
                }
                else if($voucher_type == 'Stock_Transfer'/*stock_trans_id*/)
                {
                    $query_voucher = "SELECT * FROM stock_transfer WHERE stock_trans_id = '$voucher_id'";
                    $result_voucher = mysqli_query($con,$query_voucher);
                    $row_voucher = mysqli_fetch_assoc($result_voucher);
                    $narration = 'Transferred By: '.$row_voucher['transferred_by'].', Collected By: '.$row_voucher['collected_by'];
                }
                else if($voucher_type == 'Purchase_Invoice'/*purchase_id*/)
                {
                    $query_voucher = "SELECT * FROM purchases WHERE purchase_id = '$voucher_id'";
                    $result_voucher = mysqli_query($con,$query_voucher);
                    
                    if(isset($result_voucher) && $result_voucher != '')
                    {
                        $row_voucher = mysqli_fetch_assoc($result_voucher);
                        $ledger_id = $row_voucher['ledger_credit'];
                        $query_voucher_patient = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
                        $result_voucher_patient = mysqli_query($con,$query_voucher_patient);
                        $row_voucher_patient = mysqli_fetch_assoc($result_voucher_patient);
                        $narration = $row_voucher_patient['ledger_desc'].', Supplied by: '.$row_voucher['supplied_by'].', Invoice No:'.$row_voucher['reference_no'];
                    }
                    else
                    {
                        $narration = 'N/A';
                    };
                }
                ++$i;
                    $ob = $ob + $qty_in - $qty_out;
?>
                    <tr>
                        <td class="action-td"><?php echo $i;?></td>
                        <td><?php echo $row['date'];?></td>
                        <td><?php echo $row['voucher'].':-'.$narration;?>
                        <td class="amt-td"><?php echo $ob;?></td>
                        <td class="amt-td"><?php echo $row['qty_in'];?></td>
                        <td class="amt-td"><?php echo $row['qty_out'];?></td>
                        <td class="amt-td"><?php echo $ob + $row['qty_in'] - $row['qty_out'];?></td>
                    </tr>
<?php 
                $qty_in = $row['qty_in'];
                $qty_out = $row['qty_out'];
                $total_inward = $total_inward + $qty_in;
                $total_outward = $total_outward + $qty_out;
            };
        };

?>
        <tr>
            <td class="action-td"></td>
            <td></td>
            <td>CLOSING BALANCE</td>
            <td class="amt-td"></td>
            <td class="amt-td"></td>
            <td class="amt-td"></td>
            <td class="amt-td"><?php echo $ob = $ob + $qty_in - $qty_out;?></td>
        </tr>
        <tr>
            <td class="action-td"></td>
            <td></td>
            <td>TOTAL</td>
            <td class="amt-td"><?php echo $obl;?></td>
            <td class="amt-td"><?php echo $total_inward;?></td>
            <td class="amt-td"><?php echo $total_outward;?></td>
            <td class="amt-td"><?php echo $cb = $obl + $total_inward - $total_outward;?></td>
        </tr>
    </tbody>
</table>
<?php
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>