<?php 
include($_SERVER['DOCUMENT_ROOT'] .'/includes/functions.php');

global $con;
$price_level_id = $_SESSION['price_level_id'];
$filename = "Price_list_" . date('Y-m-d') . ".csv"; 
$delimiter = ","; 
$f = fopen('php://memory', 'w'); 
$fields = array('Item_Number', 'Item Name', 'Price', 'Price Branch', 'Price Insurance'); 
fputcsv($f, $fields, $delimiter); 

if($price_level_id < 1)
{
    $result = $con->query("SELECT * FROM stock_items ORDER BY stock_item ASC"); 

    if ($result->num_rows > 0) 
    { 
        while ($row = $result->fetch_assoc()) 
        { 
            $lineData = array($row['code'], $row['stock_item'], 0, 0, 0); 
            fputcsv($f, $lineData, $delimiter); 
        };
    };
}
else
{
    $result = $con->query("SELECT p.price, p.price_branch, p.price_insurance, s.code, s.stock_item 
    FROM price_list p JOIN stock_items s ON p.stock_item_id=s.stock_item_id WHERE 
    p.price_level_id = '$price_level_id' ORDER BY s.stock_item ASC"); 

    if ($result->num_rows > 0) 
    {
        while ($row = $result->fetch_assoc()) 
        { 
            $lineData = array($row['code'], $row['stock_item'], $row['price'], $row['price_branch'], $row['price_insurance']); 
            fputcsv($f, $lineData, $delimiter);
        };
    };
}

fseek($f, 0); 
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
fpassthru($f); 
exit();
?>
