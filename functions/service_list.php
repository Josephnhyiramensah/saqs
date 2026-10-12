<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//SERVICES
function save_service_attend()
{
    global $con;
    $patient_total_balance = $_POST['patient_total_balance'];
    $service_id = $_POST['service_id'];
    $service_sponsor = $_POST['service_sponsor'];
    $service_doctor = $_POST['service_doctor'];
    $service_date = $_POST['service_date'];
    $service_qty = $_POST['service_qty'];
    $service_gdrg = $_POST['service_gdrg'];
    $service_price_cash = $_POST['service_price_cash'];
    $service_price_prvt = $_POST['service_price_prvt'];
    $service_price_nhis = $_POST['service_price_nhis'];
    $service_amt_cash = $_POST['service_amt_cash'];
    $service_amt_prvt = $_POST['service_amt_prvt'];
    $service_amt_nhis = $_POST['service_amt_nhis'];
    $service_comment = $_POST['service_comment'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $prvt_led_id = $_POST['service_sponsor'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "INSERT INTO `service_list`(
    `company_id`,`service_id`, `attend_id`, `patient_id`, `date`, `qty`, `g_drg`, 
    `price_cash`, `price_nhis`, `price_prvt`, `amount_cash`, `amount_nhis`, 
    `amount_prvt`, `comment`, `ledger_id`, `doctor_id`, `user_id`, `created_by`, `created_on`, `branch_id`) 
    VALUES (
    '$company_id','$service_id','$attend_id','$patient_id','$service_date','$service_qty',
    '$service_gdrg','$service_price_cash','$service_price_nhis','$service_price_prvt',
    '$service_amt_cash','$service_amt_nhis','$service_amt_prvt','$service_comment',
    '$service_sponsor','$service_doctor','$user_id','$user_id',NOW(),'$branch_id')";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        $query_sl = "SELECT * FROM service_list WHERE attend_id='$attend_id' ORDER BY service_list_id DESC";
        $query_run_sl = mysqli_query($con, $query_sl);
        $row_sl=mysqli_fetch_assoc($query_run_sl);
        $service_list_id = $row_sl['service_list_id'];
        $service_date = $row_sl['date'];

        $query_tr = "SELECT * FROM transactions WHERE attend_id='$attend_id' AND item_list_id='$service_list_id' AND category_id=1";
        $query_run_tr = mysqli_query($con, $query_tr);
        if (mysqli_num_rows($query_run_tr) > 0)
        {
            $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=1 AND `item_list_id`='$service_list_id'";
            mysqli_query($con, $query_trans_del);

            if ($service_amt_cash > 0) 
            {
                $query_cash_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                `amt_credit`, `narration`, `branch_id`) VALUES (1,9,'$attend_id','$service_list_id',
                '$service_list_id','$patient_id',1,'$service_date','$service_amt_cash','$service_amt_cash',0,
                'Cash Service','$branch_id')";
                mysqli_query($con, $query_cash_dr);
                
                $query_cash_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                `amt_credit`, `narration`, `branch_id`) VALUES (9,1,'$attend_id','$service_list_id',
                '$service_list_id','$patient_id',1,'$service_date','$service_amt_cash',0,'$service_amt_cash',
                'Cash Service','$branch_id')";
                mysqli_query($con, $query_cash_cr);
            } 
            if ($service_amt_prvt > 0)
            {
                $query_prvt_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                `amt_credit`, `narration`, `branch_id`) VALUES ('$prvt_led_id',9,'$attend_id',
                '$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt',
                '$service_amt_prvt',0,'Insured Service','$branch_id')";
                mysqli_query($con, $query_prvt_dr);

                $query_prvt_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                `amt_credit`, `narration`, `branch_id`) VALUES (9,'$prvt_led_id','$attend_id',
                '$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt',0,
                '$service_amt_prvt','Cash Service','$branch_id')";
                mysqli_query($con, $query_prvt_cr);
            }
            if ($service_amt_nhis > 0)
            {
                $query_nhis_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                `amt_credit`, `narration`, `branch_id`) VALUES (2,9,'$attend_id','$service_list_id',
                '$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis','$service_amt_nhis',
                0,'NHIS Service','$branch_id')";
                mysqli_query($con, $query_nhis_dr);

                $query_nhis_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                `amt_credit`, `narration`, `branch_id`) VALUES (9,2,'$attend_id','$service_list_id',
                '$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis',0,'$service_amt_nhis',
                'NHIS Service','$branch_id')";
                mysqli_query($con, $query_nhis_cr);
            }
        }
        else
        {
            if ($service_amt_cash > 0) 
            {
                $query_cash_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                `amt_credit`, `narration`, `branch_id`) VALUES (1,9,'$attend_id','$service_list_id',
                '$service_list_id','$patient_id',1,'$service_date','$service_amt_cash','$service_amt_cash',
                0,'Cash Service','$branch_id')";
                mysqli_query($con, $query_cash_dr);
                
                $query_cash_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                `amt_credit`, `narration`, `branch_id`) VALUES (9,1,'$attend_id','$service_list_id',
                '$service_list_id','$patient_id',1,'$service_date','$service_amt_cash',0,'$service_amt_cash',
                'Cash Service','$branch_id')";
                mysqli_query($con, $query_cash_cr);
            } 
            if ($service_amt_prvt > 0)
            {
                $query_prvt_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                `amt_credit`, `narration`, `branch_id`) VALUES ('$prvt_led_id',9,'$attend_id',
                '$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt',
                '$service_amt_prvt',0,'Insred Service','$branch_id')";
                mysqli_query($con, $query_prvt_dr);

                $query_prvt_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                `amt_credit`, `narration`, `branch_id`) VALUES (9,'$prvt_led_id','$attend_id',
                '$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt',
                0,'$service_amt_prvt','Insured Service','$branch_id')";
                mysqli_query($con, $query_prvt_cr);
            }
            if ($service_amt_nhis > 0)
            {
                $query_nhis_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                `amt_credit`, `narration`, `branch_id`) VALUES (2,9,'$attend_id','$service_list_id',
                '$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis','$service_amt_nhis',
                0,'NHIS Service','$branch_id')";
                mysqli_query($con, $query_nhis_dr);

                $query_nhis_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                `amt_credit`, `narration`, `branch_id`) VALUES (9,2,'$attend_id','$service_list_id',
                '$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis',0,'$service_amt_nhis',
                'NHIS Service','$branch_id')";
                mysqli_query($con, $query_nhis_cr);
            }
        }
    };
}

function edit_service_attend()
{
    global $con;
    $service_list_id = $_POST['service_list_id'];
    $Data=array();
    $query = "SELECT * FROM service_list WHERE service_list_id='$service_list_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Data, 
            $row['service_list_id'],
            $row['service_id'],
            $row['attend_id'],
            $row['patient_id'],
            $row['date'],
            $row['qty'],
            $row['g_drg'],
            $row['price_cash'],
            $row['price_nhis'],
            $row['price_prvt'],
            $row['amount_cash'],
            $row['amount_nhis'],
            $row['amount_prvt'],
            $row['comment'],
            $row['doctor_id'],
            $row['ledger_id']
        );
    }
     echo json_encode($Data);
}

function update_service_attend()
{
    global $con;
    $service_list_id = $_POST['service_list_id'];
    $service_id_old = $_POST['service_id_old'];
    $service_id = $_POST['service_id'];
    $service_sponsor = $_POST['service_sponsor'];
    $service_doctor = $_POST['service_doctor'];
    $service_date = $_POST['service_date'];
    $service_qty = $_POST['service_qty'];
    $service_gdrg = $_POST['service_gdrg'];
    $service_price_cash = $_POST['service_price_cash'];
    $service_price_prvt = $_POST['service_price_prvt'];
    $service_price_nhis = $_POST['service_price_nhis'];
    $service_amt_cash = $_POST['service_amt_cash'];
    $service_amt_prvt = $_POST['service_amt_prvt'];
    $service_amt_nhis = $_POST['service_amt_nhis'];
    $service_comment = $_POST['service_comment'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $prvt_led_id = $_POST['prvt_led_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "UPDATE `service_list` SET `service_id`='$service_id',`attend_id`='$attend_id',
    `patient_id`='$patient_id',`qty`='$service_qty',`g_drg`='$service_gdrg',
    `price_cash`='$service_price_cash',`date`='$service_date',`price_nhis`='$service_price_nhis',
    `price_prvt`='$service_price_prvt',`amount_cash`='$service_amt_cash',
    `amount_nhis`='$service_amt_nhis',`amount_prvt`='$service_amt_prvt',`comment`='$service_comment',
    `doctor_id`='$service_doctor',`ledger_id`='$service_sponsor',`altered_by`='$user_id',`altered_on`=NOW() 
    WHERE `service_list_id`='$service_list_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        $query_tr = "SELECT * FROM transactions WHERE attend_id='$attend_id' AND item_list_id='$service_list_id' AND category_id=1";
        $query_run_tr = mysqli_query($con, $query_tr);
        if (mysqli_num_rows($query_run_tr) > 0)
        {
            $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=1 AND `item_list_id`='$service_list_id'";
            mysqli_query($con, $query_trans_del);

            if ($service_amt_cash > 0) 
            {
                $query_cash_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (1,9,'$attend_id','$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_cash','$service_amt_cash',0,'Cash Service')";
                mysqli_query($con, $query_cash_dr);
                
                $query_cash_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (9,1,'$attend_id','$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_cash',0,'$service_amt_cash','Cash Service')";
                mysqli_query($con, $query_cash_cr);

                //AUTO ITEMISED RECEIPT
                        $item_list_id = $service_list_id;
                        $item_id_old = $service_id_old;
                        $item_id = $service_id;
                        $category_id = 1;
                        $price = $service_price_cash;
                        $qty = $service_qty;
                        $amount_cash_bill = $service_amt_cash;
                        $date = $service_date;

                        $query_receipt_item = "SELECT * FROM receipt_items WHERE `category_id`='$category_id' AND `item_list_id`='$item_list_id'";
                        $result_receipt_item = mysqli_query($con,$query_receipt_item);

                        if (mysqli_num_rows($result_receipt_item) > 0)
                        {
                            while ($row_receipt_item = mysqli_fetch_assoc($result_receipt_item))
                            {
                                $rec_item_id = $row_receipt_item['rec_item_id'];
                                if($amount_cash_bill < $row_receipt_item['amount_rec'])
                                {
                                    $amount_rec_1 = $amount_cash_bill;
                                }
                                else
                                {
                                    $amount_rec_1 = $row_receipt_item['amount_rec'];
                                };
                                
                                $query_rec_item = "UPDATE `receipt_items` SET `item_id`='$item_id',  `date`='$date', `qty`='$qty', `price`='$price', `amount_bill`='$service_amt_cash', `amount_rec`='$amount_rec_1', `type`='itemise' WHERE `rec_item_id`='$rec_item_id'";
                                mysqli_query($con, $query_rec_item);
                                $amount_cash_bill = $amount_cash_bill - $amount_rec_1;
                            };
                        };
            } 
            else if ($service_amt_prvt > 0)
            {
                $query_prvt_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`,
                `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                `amt_credit`, `narration`) VALUES ('$prvt_led_id',9,'$attend_id','$service_list_id',
                '$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt','$service_amt_prvt',
                0,'Insured Service')";
                mysqli_query($con, $query_prvt_dr);

                $query_prvt_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (9,'$prvt_led_id','$attend_id','$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt',0,'$service_amt_prvt','Insured Service')";
                mysqli_query($con, $query_prvt_cr);
            }
            else if ($service_amt_nhis > 0)
            {
                $query_nhis_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (2,9,'$attend_id','$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis','$service_amt_nhis',0,'NHIS Service')";
                mysqli_query($con, $query_nhis_dr);

                $query_nhis_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (9,2,'$attend_id','$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis',0,'$service_amt_nhis','NHIS Service')";
                mysqli_query($con, $query_nhis_cr);
            };
        }
        else
        {
            if ($service_amt_cash > 0) 
            {
                $query_cash_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (1,9,'$attend_id','$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_cash','$service_amt_cash',0,'Cash Service')";
                mysqli_query($con, $query_cash_dr);
                
                $query_cash_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (9,1,'$attend_id','$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_cash',0,'$service_amt_cash','Cash Service')";
                mysqli_query($con, $query_cash_cr);

                //AUTO ITEMISED RECEIPT
                        $item_list_id = $service_list_id;
                        $item_id_old = $service_id_old;
                        $item_id = $service_id;
                        $category_id = 1;
                        $price = $service_price_cash;
                        $qty = $service_qty;
                        $amount_cash_bill = $service_amt_cash;
                        $date = $service_date;

                        $query_receipt_item = "SELECT * FROM receipt_items WHERE `category_id`='$category_id' AND `item_list_id`='$item_list_id'";
                        $result_receipt_item = mysqli_query($con,$query_receipt_item);

                        if (mysqli_num_rows($result_receipt_item) > 0)
                        {
                            while ($row_receipt_item = mysqli_fetch_assoc($result_receipt_item))
                            {
                                $rec_item_id = $row_receipt_item['rec_item_id'];
                                if($amount_cash_bill < $row_receipt_item['amount_rec'])
                                {
                                    $amount_rec_1 = $amount_cash_bill;
                                }
                                else
                                {
                                    $amount_rec_1 = $row_receipt_item['amount_rec'];
                                };
                                
                                $query_rec_item = "UPDATE `receipt_items` SET `item_id`='$item_id',  `date`='$date', `qty`='$qty', `price`='$price', `amount_bill`='$service_amt_cash', `amount_rec`='$amount_rec_1', `type`='itemise' WHERE `rec_item_id`='$rec_item_id'";
                                mysqli_query($con, $query_rec_item);
                                $amount_cash_bill = $amount_cash_bill - $amount_rec_1;
                            };
                        };
            } 
            else if ($service_amt_prvt > 0)
            {
                $query_prvt_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES ('$prvt_led_id',9,'$attend_id','$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt','$service_amt_prvt',0,'Insured Service')";
                mysqli_query($con, $query_prvt_dr);

                $query_prvt_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (9,'$prvt_led_id','$attend_id','$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt',0,'$service_amt_prvt','Insured Service')";
                mysqli_query($con, $query_prvt_cr);
            }
            else if ($service_amt_nhis > 0)
            {
                $query_nhis_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (2,9,'$attend_id','$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis','$service_amt_nhis',0,'NHIS Service')";
                mysqli_query($con, $query_nhis_dr);

                $query_nhis_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (9,2,'$attend_id','$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis',0,'$service_amt_nhis','NHIS Service')";
                mysqli_query($con, $query_nhis_cr);
            };
        };
    }
    else
    {
        echo "Service NOT Updated";
    };
}

function view_current_service()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="action-td">Date</th>
                        <th class="action-td">Service</th>
                        <th class="action-td">Sponsor</th>
                        <th class="action-td">Qty</th>
                        <th class="action-td">Price</th>
                        <th class="action-td">Amount - Cash</th>
                        <th class="action-td">Amount - Disc</th>
                        <th class="action-td">Amount - Prvt</th>
                        <th class="action-td">Amount - NHIS</th>
                        <th class="action-td">Action</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM service_list WHERE attend_id='$attend_id' ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
    $total_cash=0;
    $total_disc=0;
    $total_prvt=0;
    $total_nhis=0;
    if (mysqli_num_rows($query_run) > 0)
    {
        $amt_cash=0;
        $amt_disc=0;
        $amt_prvt=0;
        $amt_nhis=0;
        while($row=mysqli_fetch_assoc($query_run))
        {
            $service_id = $row['service_id'];
            $query_serv = "SELECT * FROM services WHERE service_id='$service_id'";
            $query_run_serv = mysqli_query($con, $query_serv);
            $row_serv=mysqli_fetch_assoc($query_run_serv);

            $ledger_id = $row['ledger_id'];
            $query_led = "SELECT * FROM ledgers WHERE ledger_id='$ledger_id'";
            $query_run_led = mysqli_query($con, $query_led);
            $row_led = mysqli_fetch_assoc($query_run_led);

            $service_list_id = $row['service_list_id'];
            $query_disc = "SELECT SUM(amount) AS amount FROM discount WHERE service_list_id='$service_list_id'";
            $query_run_disc = mysqli_query($con, $query_disc);
            $row_disc = mysqli_fetch_assoc($query_run_disc);
            if (isset($row_disc)) {
                $amt_disc = $row_disc['amount'];
            } else {
                $amt_disc = 0;
            };

            $total_cash+=$row['amount_cash'];
            $total_disc+=$amt_disc ;
            $total_prvt+=$row['amount_prvt'];
            $total_nhis+=$row['amount_nhis'];

                $value.='<tr>
                            <td>';
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Service_List'] == 'Yes')) 
                            {
                                  $value.='<a href="#" id="btn_edit_service_list" data-id1="'.$row['service_list_id'].'">'.$row['date'].'</a>';
                            }
                            else
                            {
                                $value.= $row['date'];
                            };
                   $value.='</td>
                            <td>'.$row_serv['service'].'</td>
                            <td>'.$row_led['ledger_desc'].'</td>
                            <td class="action-td">'.$row['qty'].'</td>
                            <td class="amt-td">'.$row['price_cash'].'</td>
                            <td class="amt-td">'.$row['amount_cash'].'</td>
                            <td class="amt-td">'.$amt_disc.'</td>
                            <td class="amt-td">'.$row['amount_prvt'].'</td>
                            <td class="amt-td">'.$row['amount_nhis'].'</td>
                            <td class="action-td">';
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Discount'] == 'Yes')) 
                            {
                                  $value.='<a href="#" 
                                    id="btn_discount_service_list" 
                                    data-id="'.$row['attend_id'].'"
                                    data-id1="'.$_SESSION['patient_id'].'"
                                    data-id2="'.$row['service_list_id'].'"
                                    data-id3="'.$_SESSION['name'].'"
                                    data-id4="'.$row['amount_cash'].'"
                                    data-id5="'.$amt_disc.'"
                                    >Disc.</a>';
                            };

                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Service_List'] == 'Yes')) 
                            {
                                  $value.=' | 
                                <a href="#" id="btn_delete_service_list" data-id2="'.$row['service_list_id'].'"><i class="fa fa-trash fa-sm"></i></a>';
                            };

                            $value.='</td>
                        </tr>';
        }
                $value.='<tr>
                            <td class="action-td" colspan="5">TOTAL</td>
                            <td class="amt-td">'.$total_cash.'</td>
                            <td class="amt-td">'.$total_disc.'</td>
                            <td class="amt-td">'.$total_prvt.'</td>
                            <td class="amt-td">'.$total_nhis.'</td>
                            <td></td>
                        </tr>';
    };
    $value.='</tbody>
            </table>';
    echo $value;
}

function view_service_history()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Diagnosis</th>
                        <th>ICD 10</th>
                        <th>G-DRG</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM diagnosis_list WHERE patient_id=$patient_id ORDER BY date DESC";
    $query_run = mysqli_query($con,$query);
    if (mysqli_num_rows($query_run) > 0)
        {
            while($row=mysqli_fetch_assoc($query_run))
            {
                $diagnosis_id = $row['diagnosis_id'];
                $query = "SELECT * FROM diagnosis WHERE diagnosis_id=$diagnosis_id";
                $query_run_diag = mysqli_query($con, $query);
                $row_diag=mysqli_fetch_assoc($query_run_diag);
                $value.='
                        <tr>
                            <td>'.$row['date'].'</a></td>
                            <td>'.$row_diag['diagnosis'].'</td>
                            <td>'.$row_diag['icd_10'].'</td>
                            <td>'.$row_diag['g_drg'].'</td>
                            <td>'.$row['comment'].'</td>
                        </tr>';
            }
        }
        else
        {
                $value.='No Record Found';
        };
    $value.='</tbody>
            </table>';
    echo $value;
}

function set_service_price()
{
    global $con;
    $price_list=array();
    $sponsor_id = $_POST['sponsor_id'];
    $service_id = $_POST['service_id'];
    $query = "SELECT * FROM services WHERE service_id='$service_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        while($row_cash = mysqli_fetch_assoc($query_run))
        {
            $cash_price = $row_cash['price_cash'];
            $nhis_id = $row_cash['nhis_id'];
        }
    };

    if ($sponsor_id == 1)
    {
        $price = "";
        $price_adult = "";
        $price_child = "";
        $price_topup = "";
        $price_prvt = "";
        $price_prvt_topup = "";
        $remark = 'cash';
        array_push($price_list, $cash_price,$price,$price_adult,$price_child,$price_topup,$price_prvt,$price_prvt_topup,$remark);
        echo json_encode($price_list);
    }
    else if ($sponsor_id == 2)
    {
        $query = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            while($row_nhis=mysqli_fetch_assoc($query_run))
            {
                $cash_price = "";
                $price = $row_nhis['price'];
                $price_adult = $row_nhis['price_adult'];
                $price_child = $row_nhis['price_child'];
                $price_topup = $row_nhis['price_topup'];
                $price_prvt = "";
                $price_prvt_topup = "";
                $remark = 'nhia';
            }
            array_push($price_list, $cash_price,$price,$price_adult,$price_child,$price_topup,$price_prvt,$price_prvt_topup,$remark);
            echo json_encode($price_list);
        }
        else
        {
            $price = "";
            $price_adult = "";
            $price_child = "";
            $price_topup = "";
            $price_prvt = "";
            $price_prvt_topup = "";
            $remark = 'nhia_na';
            array_push($price_list, $cash_price,$price,$price_adult,$price_child,$price_topup,$price_prvt,$price_prvt_topup,$remark);
            echo json_encode($price_list);
        }
    }
    else if ($sponsor_id != 1 && $sponsor_id != 2)
    {
        $query = "SELECT * FROM price_list WHERE ledger_id='$sponsor_id' AND item_id='$service_id' AND category_id=1";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            while($row_pl=mysqli_fetch_assoc($query_run))
            {
                $cash_price = "";
                $price = "";
                $price_adult = "";
                $price_child = "";
                $price_topup = "";
                $price_prvt = $row_pl['price'];
                $price_prvt_topup = $row_pl['price_topup'];
                $remark = 'private_list';
            }
            array_push($price_list, $cash_price, $price, $price_adult, $price_child, $price_topup,
            $price_prvt, $price_prvt_topup, $remark);
            echo json_encode($price_list);
        }
        else
        {
            $price = "";
            $price_adult = "";
            $price_child = "";
            $price_topup = "";
            $price_prvt = $row_cash['price_private'];
            $price_prvt_topup = "";
            $remark = 'private_no_list';
            array_push($price_list, $cash_price, $price, $price_adult, $price_child, $price_topup,
            $price_prvt, $price_prvt_topup, $remark);
            echo json_encode($price_list);
        };
    };
}

function ipd_autobill_processing()
{
    global $con;
    $query = "SELECT * FROM attendance WHERE outcome = 'on_admission'";
    $result = mysqli_query($con,$query);
    
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $attend_id = $row['attend_id'];
            $company_id = $row['company_id'];
            $patient_id = $row['patient_id'];
            $doctor_id = $row['doctor_id'];
            $query_paytype = "SELECT * FROM `payment_type` WHERE `attend_id` = '$attend_id' AND `principal` = 'yes'";
            $query_run_paytype = mysqli_query($con, $query_paytype);
            if (mysqli_num_rows($query_run_paytype) > 0)
            {
                $row_paytype = mysqli_fetch_assoc($query_run_paytype);
                $paytype_ledger_id = $row_paytype['ledger_id'];
            };

            $query_ward_list = "SELECT * FROM wardlist WHERE attend_id = '$attend_id' ORDER BY wardlist_id DESC";
            $result_ward_list = mysqli_query($con, $query_ward_list);
            
            if(mysqli_num_rows($result_ward_list) > 0)
            {
                //while($row_ward_list = mysqli_fetch_assoc($result_ward_list))
                //{
                    $row_ward_list = mysqli_fetch_assoc($result_ward_list);
                    $ward_id = $row_ward_list['ward_id'];
                    $query_ward = "SELECT * FROM ward WHERE ward_id = '$ward_id'";
                    $result_ward = mysqli_query($con, $query_ward);
                    
                    if(mysqli_num_rows($result_ward) > 0)
                    {
                        while($row_ward = mysqli_fetch_assoc($result_ward))
                        {
                            if($paytype_ledger_id == 1)
                            {
                                $service_price_cash = $row_ward['price'];
                                $service_price_nhis = 0;
                                $service_price_prvt = 0;
                                $service_amt_cash = $row_ward['price'];
                                $service_amt_nhis = 0;
                                $service_amt_prvt = 0;
                            }
                            else if($paytype_ledger_id == 2)
                            {
                                $service_price_cash = $row_ward['price'];
                                $service_price_nhis = 0;
                                $service_price_prvt = 0;
                                $service_amt_cash = $row_ward['price'];
                                $service_amt_nhis = 0;
                                $service_amt_prvt = 0;
                            }
                            else if($paytype_ledger_id != 1 && $paytype_ledger_id != 2)
                            {
                                $service_price_cash = 0;
                                $service_price_nhis = 0;
                                $service_price_prvt = $row_ward['price'];
                                $service_amt_cash = 0;
                                $service_amt_nhis = 0;
                                $service_amt_prvt = $row_ward['price'];
                            };
                            $bill_date = date('Y-m-d');
                            $query_check_billed = "SELECT * FROM service_list WHERE attend_id='$attend_id' AND service_id = 24 AND date = '$bill_date'";
                            $query_run_check_billed = mysqli_query($con, $query_check_billed);
                            
                            if (mysqli_num_rows($query_run_check_billed) < 1)
                            {
                                $query = "INSERT INTO `service_list`(
                                `company_id`,`service_id`, `attend_id`, `patient_id`, `date`, `qty`, 
                                `price_cash`, `price_nhis`, `price_prvt`, `amount_cash`, `amount_nhis`, 
                                `amount_prvt`, `comment`, `ledger_id`, `doctor_id`, `user_id`, `created_by`, `created_on`) 
                                VALUES (
                                '$company_id',24,'$attend_id','$patient_id',NOW(),1,
                                '$service_price_cash','$service_price_nhis','$service_price_prvt',
                                '$service_amt_cash','$service_amt_nhis','$service_amt_prvt','accommodation auto bill',
                                1,'$doctor_id','$doctor_id','$doctor_id',NOW())";
                                $query_run = mysqli_query($con, $query);
                                if ($query_run)
                                {
                                    $query_sl = "SELECT * FROM service_list WHERE attend_id='$attend_id' ORDER BY service_list_id DESC";
                                    $query_run_sl = mysqli_query($con, $query_sl);
                                    $row_sl = mysqli_fetch_assoc($query_run_sl);
                                    $service_list_id = $row_sl['service_list_id'];
                                    $service_date = $row_sl['date'];
                
                                    $query_tr = "SELECT * FROM transactions WHERE attend_id='$attend_id' AND item_list_id='$service_list_id' AND category_id=1";
                                    $query_run_tr = mysqli_query($con, $query_tr);
                                    if (mysqli_num_rows($query_run_tr) > 0)
                                    {
                                        $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=1 AND `item_list_id`='$service_list_id'";
                                        mysqli_query($con, $query_trans_del);
                
                                        if ($service_amt_cash > 0) 
                                        {
                                            $query_cash_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                                            `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                            `amt_credit`, `narration`) VALUES (1,9,'$attend_id','$service_list_id','$service_list_id',
                                            '$patient_id',1,'$service_date','$service_amt_cash','$service_amt_cash',0,'Cash Service')";
                                            mysqli_query($con, $query_cash_dr);
                                            
                                            $query_cash_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                                            `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                            `amt_credit`, `narration`) VALUES (9,1,'$attend_id','$service_list_id','$service_list_id',
                                            '$patient_id',1,'$service_date','$service_amt_cash',0,'$service_amt_cash','Cash Service')";
                                            mysqli_query($con, $query_cash_cr);
                                        } 
                                        if ($service_amt_prvt > 0)
                                        {
                                            $query_prvt_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                                            `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                            `amt_credit`, `narration`) VALUES ('$prvt_led_id',9,'$attend_id','$service_list_id',
                                            '$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt','$service_amt_prvt',
                                            0,'Insured Service')";
                                            mysqli_query($con, $query_prvt_dr);
                
                                            $query_prvt_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                                            `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                            `amt_credit`, `narration`) VALUES (9,'$prvt_led_id','$attend_id','$service_list_id',
                                            '$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt',0,
                                            '$service_amt_prvt','Cash Service')";
                                            mysqli_query($con, $query_prvt_cr);
                                        }
                                        if ($service_amt_nhis > 0)
                                        {
                                            $query_nhis_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                                            `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                            `amt_credit`, `narration`) VALUES (2,9,'$attend_id','$service_list_id','$service_list_id',
                                            '$patient_id',1,'$service_date','$service_amt_nhis','$service_amt_nhis',0,'NHIS Service')";
                                            mysqli_query($con, $query_nhis_dr);
                
                                            $query_nhis_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                                            `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                            `amt_credit`, `narration`) VALUES (9,2,'$attend_id','$service_list_id','$service_list_id',
                                            '$patient_id',1,'$service_date','$service_amt_nhis',0,'$service_amt_nhis','NHIS Service')";
                                            mysqli_query($con, $query_nhis_cr);
                                        }
                                    }
                                    else
                                    {
                                        if ($service_amt_cash > 0) 
                                        {
                                            $query_cash_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                                            `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                            `amt_credit`, `narration`) VALUES (1,9,'$attend_id','$service_list_id','$service_list_id',
                                            '$patient_id',1,'$service_date','$service_amt_cash','$service_amt_cash',0,'Cash Service')";
                                            mysqli_query($con, $query_cash_dr);
                                            
                                            $query_cash_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                                            `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                            `amt_credit`, `narration`) VALUES (9,1,'$attend_id','$service_list_id','$service_list_id',
                                            '$patient_id',1,'$service_date','$service_amt_cash',0,'$service_amt_cash','Cash Service')";
                                            mysqli_query($con, $query_cash_cr);
                
                                            //AUTO ITEMISED RECEIPT
                                                /*$query_receipt_deposit = "SELECT * FROM receipt WHERE attend_id='$attend_id' AND patient_id='$patient_id' ORDER BY receipt_id ASC";
                                                $result_receipt_deposit = mysqli_query($con,$query_receipt_deposit);
                                                if (mysqli_num_rows($result_receipt_deposit) > 0)
                                                {
                                                    while($row_receipt_deposit = mysqli_fetch_assoc($result_receipt_deposit))
                                                    {
                                                        $receipt_id = $row_receipt_deposit['receipt_id'];
                                                        $amount_deposited = $row_receipt_deposit['amount'];
            
                                                        $query_receipt_item = "SELECT SUM(amount_rec) AS total_itemised FROM receipt_items WHERE receipt_id='$receipt_id'";
                                                        $result_receipt_item = mysqli_query($con,$query_receipt_item);
                                                        if (mysqli_num_rows($result_receipt_item) > 0)
                                                        {
                                                            $row_receipt_item = mysqli_fetch_assoc($result_receipt_item);
                                                            $amount_itemised = $row_receipt_item['total_itemised'];
                                                        }
                                                        else
                                                        {
                                                            $amount_itemised = 0;
                                                        };
                                                            $deposit_balance = $amount_deposited - $amount_itemised;
                                                            $item_list_id = $service_list_id;
                                                            $item_id = $service_id;
                                                            $category_id = 1;
                                                            $price = $service_price_cash;
                                                            $qty = $service_qty;
                                                            $amount_cash = $service_amt_cash;
                                                            $date = $service_date;
                                                        if($deposit_balance > $amount_cash)
                                                        {
                                                            $amount_rec = $amount_cash;
                                                        }
                                                        else
                                                        {
                                                            $amount_rec = $deposit_balance;
                                                        };
                                                        if($amount_rec > 0)
                                                        {
                                                            $query_rec_item = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,`attend_id`, `date`, `qty`, `price`, 
                                                            `amount_bill`, `amount_rec`, `type`) VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$qty',
                                                            '$price','$amount_cash','$amount_rec','itemise')";
                                                            $query_run_rec_item = mysqli_query($con, $query_rec_item);
                                                        };
                                                    };
                                                };*/
                                        } 
                                        if ($service_amt_prvt > 0)
                                        {
                                            $query_prvt_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                                            `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, 
                                            `amt_debit`, `amt_credit`, `narration`) VALUES ('$paytype_ledger_id',9,'$attend_id',
                                            '$service_list_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt',
                                            '$service_amt_prvt',0,'Insred Service')";
                                            mysqli_query($con, $query_prvt_dr);
                
                                            $query_prvt_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                                            `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                            `amt_credit`, `narration`) VALUES (9,'$paytype_ledger_id','$attend_id','$service_list_id',
                                            '$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt',0,
                                            '$service_amt_prvt','Insured Service')";
                                            mysqli_query($con, $query_prvt_cr);
                                        }
                                        if ($service_amt_nhis > 0)
                                        {
                                            $query_nhis_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                                            `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, 
                                            `amt_debit`, `amt_credit`, `narration`) VALUES (2,9,'$attend_id','$service_list_id',
                                            '$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis','$service_amt_nhis',
                                            0,'NHIS Service')";
                                            mysqli_query($con, $query_nhis_dr);
                
                                            $query_nhis_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                                            `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, 
                                            `amt_debit`, `amt_credit`, `narration`) VALUES (9,2,'$attend_id','$service_list_id',
                                            '$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis',0,
                                            '$service_amt_nhis','NHIS Service')";
                                            mysqli_query($con, $query_nhis_cr);
                                        }
                                    }
                                }
                                else
                                {
                                    echo "Service NOT Added";
                                };
                            };
                        };
                    };
                //};
            };
        };
    };
}

function delete_service_attend()
{
    global $con;
    $service_list_id = $_POST['service_list_id'];
    $attend_id = $_POST['attend_id'];
    $query = "DELETE FROM `service_list` WHERE service_list_id='$service_list_id'";
    $query_run = mysqli_query($con, $query);
    If ($query_run)
    {
        $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=1 AND `item_list_id`='$service_list_id'";
            mysqli_query($con, $query_trans_del);
    }
    else
    {
        echo "Service NOT Deleted";
    };
}

?>
