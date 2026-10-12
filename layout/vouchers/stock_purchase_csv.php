<?php 

$filename = "purchases_" . date('Y-m-d') . ".csv"; 
$delimiter = ","; 
$f = fopen('php://memory', 'w'); 
$fields = array('Item Number', 'Name', 'Qty', 'Cost Price', 'Amount', 'Batch No', 'Expiry Date', 'New Selling Price'); 
fputcsv($f, $fields, $delimiter); 

$lineData = array('OTC-10000', 'PARACETAMOL 500MG TABLET', 100000, 0.10, 10000, 'AB-167T', '2027-09-15', 0.25); 
fputcsv($f, $lineData, $delimiter); 

fseek($f, 0); 
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
fpassthru($f); 
exit();
?>