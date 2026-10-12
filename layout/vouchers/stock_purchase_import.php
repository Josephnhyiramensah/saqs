<?php 
include($_SERVER['DOCUMENT_ROOT'] .'/includes/functions.php');
//stock_purchase_import();

if (isset($_POST['stock_purchase_import_post_btn'])) 
{
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 
    'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 
    'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 
    'text/plain');

    if (!empty($_FILES['stock_purchase_import_file']['name']) && in_array($_FILES['stock_purchase_import_file']['type'], $csvMimes)) 
    {
        if (is_uploaded_file($_FILES['stock_purchase_import_file']['tmp_name'])) 
        {
            $csvFile = fopen($_FILES['stock_purchase_import_file']['tmp_name'], 'r');
            fgetcsv($csvFile);
            $purch_debit = 3;
            $purch_credit = $_POST['stock_purchase_import_ledger_id'];
            $branch_id = $_SESSION['branch_id'];
            $purch_amount = 0;
        
            $query_credit_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$purch_credit'";
            $result_credit_ledger = mysqli_query($con,$query_credit_ledger);
            if(!empty($result_credit_ledger) && mysqli_num_rows($result_credit_ledger) > 0)
            {
                $row_credit_ledger = mysqli_fetch_assoc($result_credit_ledger);
                $purch_supplied_by = $row_credit_ledger['ledger_desc'];
            }
            else
            {
                $purch_supplied_by = 'Not Specified';
            };
            $purch_ref_no = $_POST['stock_purchase_import_reference_no'];
            $purch_date = $_POST['stock_purchase_import_applicable_date'];
            $purch_received_by = $_SESSION['full_mname'];
            $purch_narration = 'STOCK PURCHASES IMPORTED ON '.$purch_date;
            $company_id = $_SESSION['company_id'];
        
            $query = "SELECT sno FROM stock_purchases WHERE company_id = '$company_id' ORDER BY sno DESC";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_assoc($result);
            $sno = $row['sno'] + 1;

            $query = "INSERT INTO `stock_purchases`(
            `company_id`, `date`, `ledger_debit`, `ledger_credit`, `amount`, `reference_no`, 
            `supplied_by`, `received_by`, `narration`, `sno`, `branch_id`) 
            VALUES ('$company_id','$purch_date','$purch_debit','$purch_credit','$purch_amount',
            '$purch_ref_no','$purch_supplied_by',
            '$purch_received_by','$purch_narration','$sno','$branch_id')";
            $query_run = mysqli_query($con, $query);

            if ($query_run) 
            {
                //POST TRANSACTION
                    $query = "SELECT * FROM stock_purchases ORDER BY stock_purchase_id DESC";
                    $result = mysqli_query($con,$query);
                    $row = mysqli_fetch_assoc($result);
                    $stock_purchase_id = $row['stock_purchase_id'];

                $csvFile = fopen($_FILES['stock_purchase_import_file']['tmp_name'], 'r');
                fgetcsv($csvFile);
                while (($line = fgetcsv($csvFile)) !== false) 
                {
                    $ItemNo   = $line[0];
                    $query_stk = "SELECT * FROM stock_items WHERE code='$ItemNo'";
                    $result_stk = mysqli_query($con,$query_stk);
                    $row_stk = mysqli_fetch_assoc($result_stk);

                    $purch_desc = $row_stk['stock_item_id'];
                    $purch_loc = $_POST['stock_purchase_import_warehouse_id'];
                    $purch_qty = $line[2];
                    $purch_price = $line[3];
                    $purch_amt = round(($purch_qty*$purch_price),2);
                    $purch_batch = $line[5];
                    $purch_expiry_date = date("Y-m-j", strtotime($line[6]));
                    $purch_amount = $purch_amount + $line[4];
                    $query = "INSERT INTO `stock_purchase_items`
                    (`company_id`, `stock_purchase_id`, `stock_item_id`, `warehouse_id`, `date`, `price`, `amount`, `batch`, `expiry_date`, `qty`) VALUES 
                    ('$company_id','$stock_purchase_id','$purch_desc','$purch_loc','$purch_date','$purch_price','$purch_amt','$purch_batch',
                    '$purch_expiry_date','$purch_qty')";
                    mysqli_query($con, $query);
                };
        
                $query_dr = "INSERT INTO `transactions`(`company_id`,`stock_purchase_id`,`ledger_id`, 
                `ledger_id_contra`, `date`, `amount`, `amount_debit`, `narration`) VALUES ('$company_id',
                '$stock_purchase_id','$purch_debit','$purch_credit','$purch_date','$purch_amount',
                '$purch_amount','$purch_narration')";
                mysqli_query($con, $query_dr);

                $query_cr = "INSERT INTO `transactions`(`company_id`,`stock_purchase_id`,`ledger_id`, 
                `ledger_id_contra`, `date`, `amount`, `amount_credit`, `narration`) VALUES ('$company_id',
                '$stock_purchase_id','$purch_credit','$purch_debit','$purch_date','$purch_amount',
                '$purch_amount','$purch_narration')";
                mysqli_query($con, $query_cr);

                $query = "UPDATE `stock_purchases`SET `amount`='$purch_amount' WHERE `stock_purchase_id`='$stock_purchase_id'";
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

header("Location: /layout/vouchers/stock_purchases_list.php".$qstring);