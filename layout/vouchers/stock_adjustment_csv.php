<?php 
include($_SERVER['DOCUMENT_ROOT'] .'/includes/functions.php');

$warehouse = $_SESSION['warehouse_id'];
$company_id = $_SESSION['company_id'];
$start_date = date('2000-01-01');
$end_date = date('Y-m-d');

$filename = "stock_take_" . date('Y-m-d') . ".csv"; 
$delimiter = ","; 
$f = fopen('php://memory', 'w'); 
$fields = array('Item_Number', 'Description', 'PC Qty', 'Physical Qty', 'Batch_No', 'Expiry_Date'); 
fputcsv($f, $fields, $delimiter); 

$result = $con->query("SELECT * FROM stock_items ORDER BY stock_item ASC"); 

if ($result->num_rows > 0) 
{ 
    while ($row_si = $result->fetch_assoc()) 
    {
        $stock_item_id = $row_si['stock_item_id'];
        
        $query="SELECT item_id, SUM(ob) AS ob, SUM(qty_in) AS qty_in, SUM(qty_out) AS qty_out FROM
        (SELECT con_id AS item_id, warehouse_id, 0 - qty_issued AS ob,  0 AS qty_out, 0 AS qty_in FROM consumable_list 
        WHERE con_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date < '$start_date'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM drug_patient_returns 
        WHERE drug_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date < '$start_date'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in FROM drug_dispense_list 
        WHERE drug_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date < '$start_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 - qty AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_sales_items 
        WHERE stock_item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date < '$start_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 - qty_out AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE stock_item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND  date < '$start_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 - qty_transferred AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE stock_item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date_trans < '$start_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, qty_in - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE stock_item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date < '$start_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, qty_received - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE stock_item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date_trans < '$start_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM purchase_items 
        WHERE item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date < '$start_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_sales_return_items 
        WHERE stock_item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date < '$start_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in FROM purchase_return_items 
        WHERE item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date < '$start_date'

        UNION ALL SELECT con_id AS item_id, warehouse_id, 0 AS ob,  qty_issued AS qty_out, 0 AS qty_in FROM consumable_list 
        WHERE con_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM drug_patient_returns 
        WHERE drug_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT drug_id AS item_id, warehouse_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM drug_dispense_list 
        WHERE drug_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM stock_sales_items 
        WHERE stock_item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  qty_out AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
        WHERE stock_item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND  date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  qty_transferred AS qty_out, 0 AS qty_in FROM stock_transfer_items 
        WHERE stock_item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date_trans BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty_in AS qty_in FROM stock_adjustment_items 
        WHERE stock_item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty_received AS qty_in FROM stock_transfer_items 
        WHERE stock_item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date_trans BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM purchase_items 
        WHERE item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM stock_sales_return_items 
        WHERE stock_item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date BETWEEN '$start_date' AND '$end_date'
        UNION ALL SELECT item_id AS item_id, warehouse_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM purchase_return_items 
        WHERE item_id='$stock_item_id' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND date BETWEEN '$start_date' AND '$end_date') AS d GROUP BY item_id";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            $row = mysqli_fetch_assoc($query_run);
            $cls_bal = $row['ob'] + $row['qty_in'] - $row['qty_out'];
        }
        else
        {
            $cls_bal = 0;
        };
        $lineData = array($row_si['code'], $row_si['stock_item'], $cls_bal, '', '', ''); 
        fputcsv($f, $lineData, $delimiter);
    };
} 

fseek($f, 0); 
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
fpassthru($f); 
exit();
?>