<?php 
include($_SERVER['DOCUMENT_ROOT'] .'/includes/functions.php');

$company_id = $_SESSION['company_id'];
$price_level_id = $_SESSION['price_level_id'];
$start_date = date('2000-01-01');
$end_date = date('Y-m-d');

$filename = "price_list_" . date('Y-m-d') . ".csv"; 
$delimiter = ","; 
$f = fopen('php://memory', 'w'); 
$fields = array('NO', 'CODE', 'ITEM_DESCRIPTION', 'PRICE', 'PRICE-INTER BRANCH', 'PRICE-INSURANCE'); 
fputcsv($f, $fields, $delimiter); 

$query = "SELECT l.*, d.stock_item, d.code FROM price_list l JOIN drugs d ON l.stock_item_id=d.stock_item_id 
WHERE price_level_id = '$price_level_id' ORDER BY d.stock_item ASC";
$query_run = mysqli_query($con, $query);

$i=0;
if (mysqli_num_rows($query_run) > 0)
{
    while($row = mysqli_fetch_assoc($query_run))
    {
        $i++;
        $stock_item = $row['stock_item'];
        $code = $row['code'];
        $price = $row['price'];
        $price_branch = $row['price_branch'];
        $price_insurance = $row['price_insurance'];
		$f_price = number_format($price, 2, '.', ',');
		$f_price_branch = number_format($price_branch, 2, '.', ',');
		$f_price_insurance = number_format($price_insurance, 2, '.', ',');

        $lineData = array( $i, $code, $stock_item, $f_price, $f_price_branch, $f_price_insurance); 
        fputcsv($f, $lineData, $delimiter); 
    };
};

fseek($f, 0); 
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
fpassthru($f); 
exit();
?>