<?php 
include($_SERVER['DOCUMENT_ROOT'] .'/includes/functions.php');

global $con;
//$fname = $_POST['filename'];
$filename = "Inventory_list_" . date('Y-m-d') . ".csv"; 
$delimiter = ","; 
$f = fopen('php://memory', 'w'); 
$fields = array('Item_Number', 'Item Name', 'Physical Quantity', 'Batch No', 'Expiry Date'); 
fputcsv($f, $fields, $delimiter); 

$result = $con->query("SELECT * FROM stock_items ORDER BY stock_item ASC"); 

if ($result->num_rows > 0) 
{ 
    while ($row = $result->fetch_assoc()) 
    { 
        $lineData = array($row['code'], $row['stock_item'], 0, 0, 0); 
        fputcsv($f, $lineData, $delimiter); 
    };
} 

fseek($f, 0); 
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
fpassthru($f); 
exit();
?>
