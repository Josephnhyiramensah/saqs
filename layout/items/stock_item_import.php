<?php 
include($_SERVER['DOCUMENT_ROOT'] .'/includes/functions.php');
//stock_item_import();

if (isset($_POST['stock_item_import_post_btn'])) 
{
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 
    'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 
    'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 
    'text/plain');

    if (!empty($_FILES['stock_item_import_file']['name']) && in_array($_FILES['stock_item_import_file']['type'], $csvMimes)) 
    {
        if (is_uploaded_file($_FILES['stock_item_import_file']['tmp_name'])) 
        {
            $csvFile = fopen($_FILES['stock_item_import_file']['tmp_name'], 'r');
            fgetcsv($csvFile);
    
            $company_id = $_SESSION['company_id'];
            $branch_id = $_SESSION['branch_id'];

            $csvFile = fopen($_FILES['stock_item_import_file']['tmp_name'], 'r');
            fgetcsv($csvFile);
            while (($line = fgetcsv($csvFile)) !== false) 
            {
                $code = $line[0];
                $stock_item = $line[1];
                $barcode = $line[2];
                $price_cash = $line[3];
                $block_negative = $line[4];
                $block_expiry = $line[5];
                $maintain_batch = $line[6];
                $days_to_promt = $line[7];
                $min_level = $line[8];
                $max_level = $line[9];
                $re_order_level = $line[10];

                $query = "INSERT INTO `stock_items`(`company_id`,`branch_id`, `code`, `stock_item`, `barcode`, 
                `price_cash`, `block_negative`, `block_expiry`, `maintain_batch`, `days_to_promt`, `min_level`, 
                `max_level`, `re_order_level`, `unit_id`) VALUES ('$company_id','$branch_id','$code','$stock_item',
                '$barcode','$price_cash','$block_negative','$block_expiry','$maintain_batch','$days_to_promt',
                '$min_level','$max_level','$re_order_level',1)";
                mysqli_query($con, $query);
            };
            fclose($csvFile);
            $qstring = '?status=succ';
        } 
        else 
        {
            $qstring = '?status=err';
        };
    } 
    else 
    {
        $qstring = '?status=invalid_file';
    };
};

header("Location: /layout/items/stock_items_list.php".$qstring);