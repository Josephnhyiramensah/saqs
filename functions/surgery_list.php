<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//SURGERY AND PROCEDURES
function check_surgery_attend_duplicate()
{
    global $con;
    $surgery_id = $_POST['surgery_id'];
    $attend_id = $_POST['attend_id'];
    $surgery_dup=array();
    $query = "SELECT * FROM surgery_list WHERE surgery_id='$surgery_id' AND attend_id='$attend_id'";
    $result = mysqli_query($con,$query);
        if (mysqli_num_rows($result) > 0)
        {
            $query_surgery = "SELECT * FROM surgery WHERE surgery_id='$surgery_id'";
            $result_surgery = mysqli_query($con,$query_surgery);
            $row_surgery=mysqli_fetch_assoc($result_surgery);

            array_push($surgery_dup, 'duplicate',$row_surgery['surgery']);
        }
        else
        {
             array_push($surgery_dup, 'none');

        };
    echo json_encode($surgery_dup);
}

function save_surgery_attend()
{
    global $con;
    $surgery_id = $_POST['surgery_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    if(isset($_POST['procqty'])){$procqty = $_POST['procqty'];}else{$procqty = 0;};
    if(isset($_POST['proc_price_cash'])){$proc_price_cash = $_POST['proc_price_cash'];}else{$proc_price_cash = 0;};
    if(isset($_POST['proc_price_prvt'])){$proc_price_prvt = $_POST['proc_price_prvt'];}else{$proc_price_prvt = 0;};
    if(isset($_POST['proc_price_nhis'])){$proc_price_nhis = $_POST['proc_price_nhis'];}else{$proc_price_nhis = 0;};
    if(isset($_POST['proc_amt_cash'])){$proc_amt_cash = $_POST['proc_amt_cash'];}else{$proc_amt_cash = 0;};
    if(isset($_POST['proc_amt_prvt'])){$proc_amt_prvt = $_POST['proc_amt_prvt'];}else{$proc_amt_prvt = 0;};
    if(isset($_POST['proc_amt_nhis'])){$proc_amt_nhis = $_POST['proc_amt_nhis'];}else{$proc_amt_nhis = 0;};
    $surgery_sponsor = $_POST['surgery_sponsor'];
    //if(isset($_POST['surgery_sponsor'])){$surgery_sponsor = $_POST['surgery_sponsor'];}else{$surgery_sponsor = 0;};
    $surgery_comment = $_POST['surgery_comment'];
    $surgery_date = $_POST['surgery_date'];
    if(isset($_POST['surgery_sponsor'])){$prvt_led_id = $_POST['surgery_sponsor'];}else{$prvt_led_id = 0;};
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    
    $clinic = $_POST['clinic'];
    $age = $_POST['age'];
    $tos = $_POST['tos'];
    if($surgery_sponsor == 2)
    {
        if($tos == 1)
        {
            if($clinic != 7 || $clinic != 8 || $clinic != 17){$nhis_id = 820;}
            elseif($clinic == 7){$nhis_id = 819;}
            elseif($clinic == 8){$nhis_id = 817;}
            elseif($clinic == 17){$nhis_id = 816;}
        }
        elseif($tos == 2)
        {
            $query = "SELECT * FROM surgery WHERE surgery_id='$surgery_id'";
            $query_run_surgery = mysqli_query($con, $query);
            $row_surgery = mysqli_fetch_assoc($query_run_surgery);
            $nhis_id = $row_surgery['nhis_id'];
        };
    };

    //ENTER IS-PRINCIPAL
    $query_surgery_list = "SELECT * FROM surgery_list WHERE attend_id ='$attend_id' AND ledger_id = 2";
    $query_run_surgery_list = mysqli_query($con, $query_surgery_list);
    if(mysqli_num_rows($query_run_surgery_list) < 1)
    {
        $is_principal = 'Yes';
        $query_diagnosis_list = "UPDATE diagnosis_list SET is_principal = 'No' WHERE attend_id ='$attend_id'";
        $query_run_diagnosis_list = mysqli_query($con, $query_diagnosis_list);
    }
    else
    {
        $is_principal = 'No';
    };
    
    $query = "INSERT INTO `surgery_list`(`company_id`,`surgery_id`, `attend_id`, `patient_id`, 
    `comment`, `qty`, `price_cash`, `amount_cash`, `date`, `amount_prvt`, `amount_nhis`, 
    `price_prvt`, `price_nhis`, `ledger_id`, `nhis_id`, `is_principal`, `user_id`, `created_by`, 
    `created_datetime`, `branch_id`
    ) VALUES ('$company_id','$surgery_id','$attend_id','$patient_id','$surgery_comment',
    '$procqty','$proc_price_cash','$proc_amt_cash','$surgery_date','$proc_amt_prvt',
    '$proc_amt_nhis','$proc_price_prvt','$proc_price_nhis','$surgery_sponsor',
    '$nhis_id','$is_principal','$user_id','$user_id',NOW(),'$branch_id')";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        if ($_SESSION['user_type_id'] == 6) 
        {
            doctor_attend_register();
        };
        //POST TRANSACTION
            $query_surgery_list = "SELECT * FROM `surgery_list` ORDER BY `surgery_list_id` DESC";
            $query_run_surgery_list = mysqli_query($con, $query_surgery_list);
            $row_surgery_list=mysqli_fetch_assoc($query_run_surgery_list);
            $surgery_list_id = $row_surgery_list['surgery_list_id'];
            $amount_cash = $row_surgery_list['amount_cash'];
            $amount_prvt = $row_surgery_list['amount_prvt'];
            $amount_nhis = $row_surgery_list['amount_nhis'];
            $date = $row_surgery_list['date'];

            $query_trans = "SELECT * FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=5 AND `item_list_id`='$surgery_list_id'";
            $query_run_trans = mysqli_query($con, $query_trans);
            if (mysqli_num_rows($query_run_trans) > 0)
            {
                $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=5 AND `item_list_id`='$surgery_list_id'";
                mysqli_query($con, $query_trans_del);
                if ($amount_cash > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`, `branch_id`) 
                    VALUES (1,8,'$attend_id','$patient_id',5,'$date','$amount_cash','$amount_cash',0,
                    '$surgery_list_id','$surgery_list_id','surgery for cash','$branch_id')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`, `branch_id`) 
                    VALUES (8,1,'$attend_id','$patient_id',5,'$date','$amount_cash',0,'$amount_cash',
                    '$surgery_list_id','$surgery_list_id','surgery for cash','$branch_id')";
                    mysqli_query($con, $query_cr);

                    /*AUTO ITEMISED RECEIPT
                        $query_receipt_deposit = "SELECT * FROM receipt WHERE attend_id='$attend_id' AND patient_id='$patient_id' AND type='Deposit' ORDER BY receipt_id ASC";
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
                                    $item_list_id = $surgery_list_id;
                                    $item_id = $surgery_id;
                                    $category_id = 5;
                                    $price = $proc_amt_cash;
                                    $qty = 1;
                                    $amount_cash = $proc_amt_cash;
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
                if ($amount_prvt > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`, `branch_id`) 
                    VALUES ('$prvt_led_id',8,'$attend_id','$patient_id',5,'$date','$amount_prvt','$amount_prvt',
                    0,'$surgery_list_id','$surgery_list_id','surgery for NHIS','$branch_id')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`, `branch_id`) 
                    VALUES (8,'$prvt_led_id','$attend_id','$patient_id',5,'$date','$amount_prvt',0,
                    '$amount_prvt','$surgery_list_id','$surgery_list_id','surgery for NHIS','$branch_id')";
                    mysqli_query($con, $query_cr);
                }
                if ($amount_nhis > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`, `branch_id`) 
                    VALUES (2,8,'$attend_id','$patient_id',5,'$date','$amount_nhis','$amount_nhis',0,
                    '$surgery_list_id','$surgery_list_id','surgery for NHIS','$branch_id')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`, `branch_id`) 
                    VALUES (8,2,'$attend_id','$patient_id',5,'$date','$amount_nhis',0,'$amount_nhis',
                    '$surgery_list_id','$surgery_list_id','surgery for NHIS','$branch_id')";
                    mysqli_query($con, $query_cr);
                };
            }
            else
            {
                if ($amount_cash > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                    `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
                    `surgery_list_id`, `narration`, `branch_id`) VALUES (1,8,'$attend_id','$patient_id',5,
                    '$date','$amount_cash','$amount_cash',0,'$surgery_list_id','$surgery_list_id',
                    'surgery for cash','$branch_id')";
                    mysqli_query($con, $query_dr);
                    
                    $query_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                    `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
                    `surgery_list_id`, `narration`, `branch_id`) VALUES (8,1,'$attend_id','$patient_id',5,
                    '$date','$amount_cash',0,'$amount_cash','$surgery_list_id','$surgery_list_id',
                    'surgery for cash','$branch_id')";
                    mysqli_query($con, $query_cr);

                    /*AUTO ITEMISED RECEIPT
                        $query_receipt_deposit = "SELECT * FROM receipt WHERE attend_id='$attend_id' AND patient_id='$patient_id' AND type='Deposit' ORDER BY receipt_id ASC";
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
                                    $item_list_id = $surgery_list_id;
                                    $item_id = $surgery_id;
                                    $category_id = 5;
                                    $price = $proc_amt_cash;
                                    $qty = 1;
                                    $amount_cash = $proc_amt_cash;
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
                if ($amount_prvt > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`, `branch_id`) 
                    VALUES ('$prvt_led_id',8,'$attend_id','$patient_id',5,'$date','$amount_prvt','$amount_prvt',
                    0,'$surgery_list_id','$surgery_list_id','surgery for NHIS','$branch_id')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`, `branch_id`) 
                    VALUES (8,'$prvt_led_id','$attend_id','$patient_id',5,'$date','$amount_prvt',0,
                    '$amount_prvt','$surgery_list_id','$surgery_list_id','surgery for NHIS','$branch_id')";
                    mysqli_query($con, $query_cr);
                }
                if ($amount_nhis > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`, `branch_id`) 
                    VALUES (2,8,'$attend_id','$patient_id',5,'$date','$amount_nhis','$amount_nhis',0,
                    '$surgery_list_id','$surgery_list_id','surgery for NHIS','$branch_id')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`, `branch_id`) 
                    VALUES (8,2,'$attend_id','$patient_id',5,'$date','$amount_nhis',0,'$amount_nhis',
                    '$surgery_list_id','$surgery_list_id','surgery for NHIS','$branch_id')";
                    mysqli_query($con, $query_cr);
                };
            };
        view_current_surgery();
    }
    else
    {
        echo "Surgery NOT Added";
    };
}

function edit_surgery_attend()
{
    global $con;
    $surgery_list_id = $_POST['surgery_list_id'];
    $Surgery_Data=array();
    $query = "SELECT * FROM surgery_list WHERE surgery_list_id = $surgery_list_id";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Surgery_Data, 
            $row['surgery_list_id'],
            $row['surgery_id'],
            $row['comment'],
            $row['qty'],
            $row['price_cash'],
            $row['amount_cash'],
            $row['amount_prvt'],
            $row['amount_nhis'],
            $row['price_prvt'],
            $row['price_nhis'],
            $row['date'],
            $row['ledger_id']

        );
    }
     echo json_encode($Surgery_Data);
}

function update_surgery_attend()
{
    global $con;
    $surgery_list_id = $_POST['surgery_list_id'];
    $surgery_id = $_POST['surgery_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $procqty = $_POST['procqty'];
    $proc_price_cash = $_POST['proc_price_cash'];
    $proc_price_prvt = $_POST['proc_price_prvt'];
    $proc_price_nhis = $_POST['proc_price_nhis'];
    $proc_amt_cash = $_POST['proc_amt_cash'];
    $proc_amt_prvt = $_POST['proc_amt_prvt'];
    $proc_amt_nhis = $_POST['proc_amt_nhis'];
    $surgery_sponsor = $_POST['surgery_sponsor'];
    $surgery_comment = $_POST['surgery_comment'];
    $surgery_date = $_POST['surgery_date'];
    $user_id = $_SESSION['user_id'];
    
    $clinic = $_POST['clinic'];
    $age = $_POST['age'];
    $tos = $_POST['tos'];
    
    if($surgery_sponsor == 2)
    {
        if($tos == 1)
        {
            if($clinic != 7 || $clinic != 8 || $clinic != 17){$nhis_id = 820;}
            elseif($clinic == 7){$nhis_id = 819;}
            elseif($clinic == 8){$nhis_id = 817;}
            elseif($clinic == 17){$nhis_id = 816;}
        }
        elseif($tos == 2)
        {
            $query = "SELECT * FROM surgery WHERE surgery_id='$surgery_id'";
            $query_run_surgery = mysqli_query($con, $query);
            $row_surgery = mysqli_fetch_assoc($query_run_surgery);
            $nhis_id = $row_surgery['nhis_id'];
        };
    };
    $query = "UPDATE `surgery_list` SET `surgery_id`='$surgery_id',
    `attend_id`='$attend_id', `patient_id`='$patient_id', `comment`='$surgery_comment', `qty`='$procqty', 
    `price_cash`='$proc_price_cash', `amount_cash`='$proc_amt_cash', `date`='$surgery_date', 
    `amount_prvt`='$proc_amt_prvt', `amount_nhis`='$proc_amt_nhis', `price_prvt`='$proc_price_prvt', 
    `price_nhis`='$proc_price_nhis', `ledger_id`='$surgery_sponsor', `nhis_id`='$nhis_id', 
    `is_principal`='$is_principal', `altered_by`='$user_id', `altered_datetime`=NOW()
    WHERE `surgery_list_id`='$surgery_list_id'";
    
    /*$query = "UPDATE `surgery_list` SET `attend_id`='$attend_id',`patient_id`='$patient_id',
    `surgery_id`='$surgery_id',`comment`='$surgery_comment',`qty`='$procqty',
    `price_cash`='$proc_price_cash',`amount_cash`='$proc_amt_cash',`price_prvt`='$proc_price_prvt',
    `price_nhis`='$proc_price_nhis',`amount_prvt`='$proc_amt_prvt',`amount_nhis`='$proc_amt_nhis',
    `ledger_id`='$surgery_sponsor',`date`='$surgery_date',`nhis`='$nhis_id',
    `altered_by`='$user_id',`altered_datetime`=NOW() WHERE `surgery_list_id`='$surgery_list_id'";*/
    $query_run = mysqli_query($con, $query);
    
    if ($query_run)
    {
        //POST TRANSACTION
            $query_surgery_list = "SELECT * FROM `surgery_list` WHERE `surgery_list_id`='$surgery_list_id'";
            $query_run_surgery_list = mysqli_query($con, $query_surgery_list);
            $row_surgery_list = mysqli_fetch_assoc($query_run_surgery_list);
            $amount_cash = $row_surgery_list['amount_cash'];
            $amount_prvt = $row_surgery_list['amount_prvt'];
            $amount_nhis = $row_surgery_list['amount_nhis'];
            $prvt_led_id = $row_surgery_list['ledger_id'];
            $date = $row_surgery_list['date'];

            $query_trans = "SELECT * FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=5 AND `item_list_id`='$surgery_list_id'";
            $query_run_trans = mysqli_query($con, $query_trans);
            if (mysqli_num_rows($query_run_trans) > 0)
            {
                $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=5 AND `item_list_id`='$surgery_list_id'";
                mysqli_query($con, $query_trans_del);
                if ($amount_cash > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (1,8,'$attend_id','$patient_id',5,'$date','$amount_cash','$amount_cash',0,'$surgery_list_id','$surgery_list_id','surgery for cash')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (8,1,'$attend_id','$patient_id',5,'$date','$amount_cash',0,'$amount_cash','$surgery_list_id','$surgery_list_id','surgery for cash')";
                    mysqli_query($con, $query_cr);
                }
                if ($amount_prvt > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES ('$prvt_led_id',8,'$attend_id','$patient_id',5,'$date','$amount_prvt','$amount_prvt',0,'$surgery_list_id','$surgery_list_id','surgery for NHIS')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (8,'$prvt_led_id','$attend_id','$patient_id',5,'$date','$amount_prvt',0,'$amount_prvt','$surgery_list_id''$surgery_list_id','surgery for NHIS')";
                    mysqli_query($con, $query_cr);
                }
                if ($amount_nhis > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (2,8,'$attend_id','$patient_id',5,'$date','$amount_nhis','$amount_nhis',0,'$surgery_list_id','$surgery_list_id','surgery for NHIS')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (8,2,'$attend_id','$patient_id',5,'$date','$amount_nhis',0,'$amount_nhis','$surgery_list_id','$surgery_list_id','surgery for NHIS')";
                    mysqli_query($con, $query_cr);
                };
            }
            else
            {
                if ($amount_cash > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (1,8,'$attend_id','$patient_id',5,'$date','$amount_cash','$amount_cash',0,'$surgery_list_id','$surgery_list_id','surgery for cash')";
                    mysqli_query($con, $query_dr);
                    
                    $query_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (8,1,'$attend_id','$patient_id',5,'$date','$amount_cash',0,'$amount_cash','$surgery_list_id','$surgery_list_id','surgery for cash')";
                    mysqli_query($con, $query_cr);
                }
                if ($amount_prvt > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES ('$prvt_led_id',8,'$attend_id','$patient_id',5,'$date','$amount_prvt','$amount_prvt',0,'$surgery_list_id','$surgery_list_id','surgery for NHIS')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (8,'$prvt_led_id','$attend_id','$patient_id',5,'$date','$amount_prvt',0,'$amount_prvt','$surgery_list_id','$surgery_list_id','surgery for NHIS')";
                    mysqli_query($con, $query_cr);
                }
                if ($amount_nhis > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (2,8,'$attend_id','$patient_id',5,'$date','$amount_nhis','$amount_nhis',0,'$surgery_list_id','$surgery_list_id','surgery for NHIS')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (8,2,'$attend_id','$patient_id',5,'$date','$amount_nhis',0,'$amount_nhis','$surgery_list_id','$surgery_list_id','surgery for NHIS')";
                    mysqli_query($con, $query_cr);
                };
            };
        view_current_surgery();
    }
    else
    {
        echo "Surgery NOT Updated";
    };
}

function view_current_surgery()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    date_default_timezone_set("Africa/Accra");
    $date_today = date('Y-m-d');
    $age = $_POST['age'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Procedure/Surgery</th>';
                        if (
                            $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                            $_SESSION['user_type'] == 'Super_User' OR 
                            ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
                            {
                                $value .='
                                    <th>Sponsor</th>
                                    <th>Cash</th>
                                    <th>Disc.</th>
                                    <th>Private</th>
                                    <th>NHIS</th>
                                    <th>G-DRG</th>';
                            };
                        $value .='<th>Action</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM surgery_list WHERE attend_id = '$attend_id' ORDER BY date DESC";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0)
           {
            $total_cash=0;
            $total_disc=0;
            $total_prvt=0;
            $total_nhis=0;
            while($row=mysqli_fetch_assoc($result))
            {
                $surgery_id = $row['surgery_id'];
                $surgery_list_id = $row['surgery_list_id'];
                $ledger_id = $row['ledger_id'];

                $query = "SELECT * FROM surgery WHERE surgery_id='$surgery_id'";
                $query_run_surgery = mysqli_query($con, $query);
                $row_surgery=mysqli_fetch_assoc($query_run_surgery);

                $nhis_id = $row['nhis_id'];
                $query_gdrg = "SELECT * FROM nhis WHERE nhis_id ='$nhis_id'";
                $result_gdrg = mysqli_query($con,$query_gdrg);
                $row_gdrg = mysqli_fetch_array($result_gdrg);
                if($age < 12)
                {
                    if(isset($row_gdrg['gdrg_child']))
                    {$proc_gdrg = $row_gdrg['gdrg_child'];}else
                    {$proc_gdrg = 'N/A';};
                }
                else
                {
                    if(isset($row_gdrg['gdrg_adult']))
                    {$proc_gdrg = $row_gdrg['gdrg_adult'];}else
                    {$proc_gdrg = 'N/A';};
                };

                $query = "SELECT * FROM ledgers WHERE ledger_id ='$ledger_id'";
                $result_ledger = mysqli_query($con,$query);
                $ledger_rows = mysqli_fetch_assoc($result_ledger);


                $query = "SELECT * FROM operation_notes WHERE surgery_list_id='$surgery_list_id'";
                $result_surgery_list = mysqli_query($con,$query);
                $op_note_rows=mysqli_num_rows($result_surgery_list);

                $query = "SELECT * FROM anesthesia WHERE surgery_list_id='$surgery_list_id'";
                $result_anest_list = mysqli_query($con,$query);
                $op_anest_rows=mysqli_num_rows($result_anest_list);

                $query_disc = "SELECT SUM(amount) AS amount FROM discount WHERE surgery_list_id='$surgery_list_id'";
                $result_disc = mysqli_query($con,$query_disc);
                $rows_disc =mysqli_fetch_assoc($result_disc);
                if(isset($rows_disc))
                {
                    $amt_disc = $rows_disc['amount'];
                }
                else
                {
                    $amt_disc = 0;
                };

                $value.='<tr>
                            <td>'.$row['date'].'</td>
                            <td>'.$row_surgery['surgery'].'</td>';
                            if (
                                $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                $_SESSION['user_type'] == 'Super_User' OR 
                                ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
                                {
                                    $value.='<td>'.$ledger_rows['ledger_desc'].'</td>
                                    <td>'.$row['amount_cash'].'</td>
                                    <td>'.$amt_disc.'</td>
                                    <td>'.$row['amount_prvt'].'</td>
                                    <td>'.$row['amount_nhis'].'</td>
                                    <td>'.$proc_gdrg.'</td>';
                                };

                            $value.='<td>';
                            $total_cash+=$row['amount_cash'];
                            $total_disc+=$amt_disc;
                            $total_prvt+=$row['amount_prvt'];
                            $total_nhis+=$row['amount_nhis'];
                            if (/*$_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND*/ $_SESSION['user_id'] == $row['user_id']) 
                            {
                                if($row['date'] == $date_today)
                                {
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                        $_SESSION['user_type'] == 'Super_User' OR 
                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Surgery_List'] == 'Yes')) 
                                    {
                                        $value.='<a href="#" 
                                                    id="btn_edit_surgery_attend" 
                                                    data-id1="'.$row['surgery_list_id'].'">
                                                    Edit Surgery
                                                </a>';
                                    };
                                };
                            };

                            if ($op_anest_rows > 0) {
                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Surgery_Anestesia'] == 'Yes')) 
                                {
                                    $value.=' | <a href="#" 
                                                    id="btn_edit_anesthesia" 
                                                    data-id1="'.$row['surgery_list_id'].'" 
                                                    data-id2="'.$row['surgery_id'].'" 
                                                    class="data-toggle="tooltip" 
                                                    data-placement="left" 
                                                    title="Edit Anesthesia"">
                                                    Edit Anesthesia
                                                </a>';
                                };
                            } 
                            else 
                            {
                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Surgery_Anestesia'] == 'Yes')) 
                                {
                                    $value.=' | <a href="#" 
                                                    id="btn_enter_anesthesia" 
                                                    data-id1="'.$row['surgery_list_id'].'" 
                                                    data-id2="'.$row['surgery_id'].'" 
                                                    class="data-toggle="tooltip" 
                                                    data-placement="left" 
                                                    title="Enter Anesthesia"">
                                                    Enter Anesthesia
                                                </a>';
                                };
                            };	
                            if ($op_note_rows > 0) {
                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Surgery_Opt_Notes'] == 'Yes')) 
                                {
                                    $value.=' | <a href="#" 
                                                    id="btn_view_opt_notes" 
                                                    data-id1="'.$row['surgery_list_id'].'" 
                                                    data-id2="'.$row['surgery_id'].'" 
                                                    class="data-toggle="tooltip" 
                                                    data-placement="right" 
                                                    title="View Operation Notes"">
                                                    View Operation Notes
                                                </a>';
                                };
                            } 
                            else 
                            {
                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Surgery_Opt_Notes'] == 'Yes')) 
                                {
                                    $value.=' | <a href="#" 
                                                    id="btn_enter_opt_notes" 
                                                    data-id1="'.$row['surgery_list_id'].'" 
                                                    data-id2="'.$row['surgery_id'].'" 
                                                    class="data-toggle="tooltip" 
                                                    data-placement="right" 
                                                    title="Enter Operation Notes"">
                                                    Enter Operation Notes
                                                </a>';
                                };
                            };

                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                $_SESSION['user_type'] == 'Super_User' OR 
                                ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Surgery_Consent_Form'] == 'Yes')) 
                            {
                                $value.=' | <a href="#" id="consent_form_icon" 
                                                data-id1="'.$row['surgery_list_id'].'" 
                                                data-id2="'.$row['surgery_id'].'" 
                                                class="data-toggle="tooltip" 
                                                data-placement="right" 
                                                title="Consemt Form"">
                                                Consemt Form
                                            </a>
                                             | <a href="#" id="consent_form_pdf_icon" 
                                                data-id1="'.$row['surgery_list_id'].'" 
                                                data-id2="'.$row['surgery_id'].'" 
                                                data-id3="'.$_SESSION['patient_id'].'" 
                                                data-id3="'.$attend_id.'" 
                                                class="data-toggle="tooltip" 
                                                data-placement="right" 
                                                title="Print Consemt Form PDF"">
                                                Consemt Form PDF
                                            </a>';
                            };

                             if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Discount'] == 'Yes')) 
                            {
                                $value.=' | <a href="#" id="btn_discount_surgery_attend" 
                                                data-id="'.$attend_id.'" 
                                                data-id1="'.$_SESSION['patient_id'].'" 
                                                data-id2="'.$row['surgery_list_id'].'" 
                                                data-id3="'.$_SESSION['name'].'"
                                                data-id4="'.$row['amount_cash'].'"
                                                data-id5="'.$amt_disc.'"
                                                >Disc
                                            </a>';
                            };
                            
                            if (/*$_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND*/ $_SESSION['user_id'] == $row['user_id']) 
                            {
                                if($row['date'] == $date_today)
                                {
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Surgery_List'] == 'Yes')) 
                                    {
                                        $value.=' | <a href="#" id="btn_delete_surgery_attend" data-id2="'.$row['surgery_list_id'].'">Delete</a>';
                                    };
                                };
                            };

                    $value.='</td>
                        </tr>';
            }
        
                if (
                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                    $_SESSION['user_type'] == 'Super_User' OR 
                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
                    {
                        $value.='<tr>
                                <td colspan="3">TOTAL</td>
                                <td>'.$total_cash.'</td>
                                <td>'.$total_disc.'</td>
                                <td>'.$total_prvt.'</td>
                                <td>'.$total_nhis.'</td>
                                <td></td>
                                <td></td>
                            </tr>';
                    };
        };
           $value.='</tbody>
            </table>';
    echo $value;
}

function view_surgery_history()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Procedure/Surgery</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM surgery_list WHERE patient_id=$patient_id ORDER BY date DESC";
    $result = mysqli_query($con,$query);

    while($row=mysqli_fetch_assoc($result))
    {
        $surgery_id = $row['surgery_id'];
        $surgery_list_id = $row['surgery_list_id'];
        $query = "SELECT * FROM surgery WHERE surgery_id='$surgery_id'";
        $query_run = mysqli_query($con, $query);
        $row_surgery=mysqli_fetch_assoc($query_run);

        $query = "SELECT * FROM operation_notes WHERE surgery_list_id='$surgery_list_id'";
                $result_surgery_list = mysqli_query($con,$query);
                $op_note_rows=mysqli_num_rows($result_surgery_list);

                $query = "SELECT * FROM anesthesia WHERE surgery_list_id='$surgery_list_id'";
                $result_anest_list = mysqli_query($con,$query);
                $op_anest_rows=mysqli_num_rows($result_anest_list);

        $value.='<tr>
                    <td>'.$row['date'].'</a></td>
                    <td>'.$row_surgery['surgery'].'</td>
                    <td>'.$row['comment'].'</td>
                    <td>';
                            if ($op_anest_rows > 0) 
                            {
                                $value.='<a href="#" id="btn_view_anesthesia_sh" data-id1="'.$row['surgery_list_id'].'" data-id2="'.$row['surgery_id'].'" class="data-toggle="tooltip" data-placement="left" title="View Anesthesia"">
                                    <i class="fas fa-file-medical-alt"></i></a>';
                            } /*else {
                                $value.='<a href="#" id="btn_enter_anesthesia_sh" data-id1="'.$row['surgery_list_id'].'" data-id2="'.$row['surgery_id'].'" class="data-toggle="tooltip" data-placement="left" title="Enter Anesthesia"">
                                    <i class="fas fa-file-medical"></i></a>';
                            }*/;	
                            if ($op_note_rows > 0) 
                            {
                                $value.=' | <a href="#" id="btn_view_opt_notes_sh" data-id1="'.$row['surgery_list_id'].'" data-id2="'.$row['surgery_id'].'" class="data-toggle="tooltip" data-placement="right" title="View Operation Notes""><i class="fas fa-clipboard"></i></a>';
                            } /*else {
                                $value.=' | <a href="#" id="btn_enter_opt_notes_sh" data-id1="'.$row['surgery_list_id'].'" data-id2="'.$row['surgery_id'].'" class="data-toggle="tooltip" data-placement="right" title="Enter Operation Notes""><i class="fas fa-notes-medical"></i></a>';
                            }*/;
                    $value.='</td>
                </tr>';
    }
    $value.='</tbody>
            </table>';
    echo $value;
}

function save_operation_notes()
{
    global $con;
    $start_date = $_POST['surgery_date_start'];
    $time_start = $_POST['surgery_time_start'];
    $end_date = $_POST['surgery_date_end'];
    $time_end = $_POST['surgery_time_end'];
    $head_surgeon = $_POST['surgery_head'];
    $findings = $_POST['surgery_findings'];
    $findings = addslashes($findings);
    $surgery_id = $_POST['surgery_id_op'];
    $surgery_list_id = $_POST['surgery_list_id_op'];
    $procedure = $_POST['surgery_procedure'];
    $procedure = addslashes($procedure);
    $patient_id = $_POST['patient_id'];
    $attend_id = $_POST['attend_id'];
    $user_id = $_SESSION['user_id'];
    $query = "INSERT INTO `operation_notes`(`attend_id`, `patient_id`, `date_start`, 
    `time_start`, `date_end`, `time_end`, `head_surgeon`, `findings`, `instructions`, 
    `surgery_id`, `surgery_list_id`, `user_id`, `created_by`, `created_time`) 
    VALUES ('$attend_id','$patient_id','$start_date',
    '$time_start','$end_date','$time_end','$head_surgeon','$findings','$procedure','$surgery_id',
    '$surgery_list_id','$user_id','$user_id',NOW())";
        $query_run = mysqli_query($con, $query);

        if ($query_run) 
        {

            if ($_SESSION['user_type_id'] == 6) {doctor_attend_register();};

            $query = "SELECT * FROM operation_notes WHERE surgery_list_id=$surgery_list_id ORDER BY optnote_id DESC";
            $result = mysqli_query($con,$query);
            $row=mysqli_fetch_assoc($result);
            $optnote_id = $row['optnote_id'];

            $number_as = count($_POST["assistant_surgeon"]);  
                if($number_as > 0)  
                {  
                  for($i=0; $i<$number_as; $i++)  
                  {  
                       if(trim($_POST["assistant_surgeon"][$i] != ''))  
                       {  
                            $assistant_surgeon = $_POST['assistant_surgeon'][$i];
                            $query = "INSERT INTO `operation_surgeon_assist`(`op_note_id`, `surgery_list_id`, `surgery_id`, `patient_id`, 
                                `attend_id`, `surgery_assist`) 
                                VALUES ('$optnote_id','$surgery_list_id','$surgery_id','$patient_id','$attend_id','$assistant_surgeon')";
                            $query_run = mysqli_query($con, $query);
                       }  
                  }
                  echo "Assistant Surgeons Inserted";  
                }  
                else  
                {  
                  echo "Assistant Surgeons NOT Inserted";  
                }

            $number_sn = count($_POST["scrub_nurse"]);  
                if($number_sn > 0)  
                {  
                  for($i=0; $i<$number_sn; $i++)  
                  {  
                       if(trim($_POST["scrub_nurse"][$i] != ''))  
                       {  
                            $scrub_nurse = $_POST['scrub_nurse'][$i];
                            $query = "INSERT INTO `operation_nurses`(`op_note_id`, `surgery_list_id`, `surgery_id`, `patient_id`, 
                            `attend_id`, `scrub_nurse`) 
                            VALUES ('$optnote_id','$surgery_list_id','$surgery_id','$patient_id','$attend_id','$scrub_nurse')";
                            $query_run = mysqli_query($con, $query);
                       }  
                  }
                  echo "Scrub Nurses Inserted";  
                }  
                else  
                {  
                  echo "Scrub Nurses NOT Inserted";  
                }  
        }
}

function edit_operation_notes()
{
    global $con;
    $surgery_list_id = $_POST['surgery_list_id'];
    $opnotes=array();
    $query = "SELECT * FROM operation_notes WHERE surgery_list_id='$surgery_list_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($opnotes, 
            $row['optnote_id'],$row['attend_id'],$row['patient_id'],$row['date_start'],
            $row['date_end'],$row['time_start'],$row['time_end'],$row['head_surgeon'],
            $row['findings'],$row['instructions'],$row['surgery_id'],$row['surgery_list_id']
        );
    }
     echo json_encode($opnotes);
}

function edit_assist_surgeon()
{
    global $con;
    $opnote_id = $_POST['opnote_id'];
    $value = "";
    $value = '<table class="table table-bordered" id="assistant_surgeon_table">
                <tr>
                    <th colspan="2"><a href="#" id="add_assist_surg_link">Assistant Surgeon</a></th>
                </tr>';
    $query = "SELECT * FROM operation_surgeon_assist WHERE op_note_id='$opnote_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
        {
            $i=0;
            while($row=mysqli_fetch_assoc($query_run))
            {
                $i=++$i;
                $value.='
                        <tr id="row_as'.$i.'">
                            <td>
                                <input type="text" name="assistant_surgeon[]" class="form-control bg-light" id="assistant_surgeon" value="'.$row['surgery_assist'].'">
                                <input type="hidden" name="op_assist_surg_id[]" class="form-control bg-light" id="op_assist_surg_id" value="'.$row['surg_assist_id'].'">
                            </td>
                            <td>
                                <a href="#" id="delete_assist_surg_link" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                            </td>
                        </tr>';
            };
            $value.='</tbody>
            </table>';
        }
    echo $value;
}

function edit_scrub_nurses()
{
    global $con;
    $opnote_id = $_POST['opnote_id'];
    $value = "";
    $value = '<table class="table table-bordered" id="scrub_nurse_table">
                <tr>
                    <th colspan="2"><a href="#" id="add_scrub_nurse_link">Scrub Nurses</a></th>
                </tr>';
    $query = "SELECT * FROM operation_nurses WHERE op_note_id='$opnote_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
        {
            $i=0;
            while($row=mysqli_fetch_assoc($query_run))
            {
                $i=++$i;
                $value.='
                        <tr id="row_sn'.$i.'">
                            <td>
                                <input type="text" name="scrub_nurse[]" class="form-control bg-light" id="scrub_nurse" value="'.$row['scrub_nurse'].'">
                                <input type="hidden" name="op_scrub_nurse_id[]" class="form-control bg-light" id="op_scrub_nurse_id" value="'.$row['op_nurse_id'].'">
                            </td>
                            <td><a href="#" id="delete_scrub_nurse_link" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a></td>
                        </tr>';
            };
            $value.='</tbody>
            </table>';
        }
    echo $value;
}

function update_operation_notes()
{
    global $con;
    $optnote_id = $_POST['surgery_optnote_id'];
    $start_date = $_POST['surgery_date_start'];
    $time_start = $_POST['surgery_time_start'];
    $end_date = $_POST['surgery_date_end'];
    $time_end = $_POST['surgery_time_end'];
    $head_surgeon = $_POST['surgery_head'];
    $findings = $_POST['surgery_findings'];
    $findings = addslashes($findings);
    $surgery_id = $_POST['surgery_id_op'];
    $surgery_list_id = $_POST['surgery_list_id_op'];
    $procedure = $_POST['surgery_procedure'];
    $procedure = addslashes($procedure);
    $patient_id = $_POST['patient_id'];
    $attend_id = $_POST['attend_id'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `operation_notes` SET `attend_id`='$attend_id',
    `patient_id`='$patient_id',`date_start`='$start_date',`date_end`='$end_date',
    `time_start`='$time_start',`time_end`='$time_end',`head_surgeon`='$head_surgeon',
    `findings`='$findings',`instructions`='$procedure',`surgery_id`='$surgery_id',
    `surgery_list_id`='$surgery_list_id',`altered_by`='$user_id',`altered_time`=NOW() 
    WHERE `optnote_id`='$optnote_id'";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {

            $query = "UPDATE `operation_surgeon_assist` SET `status`='' WHERE `op_note_id`='$optnote_id'";
            $result = mysqli_query($con,$query);

            $number_as = count($_POST["assistant_surgeon"]);  
                if($number_as > 0)  
                {  
                  for($i=0; $i<$number_as; $i++)  
                  {  
                       if(trim($_POST["assistant_surgeon"][$i] != ''))  
                       {  
                            $assistant_surgeon = $_POST['assistant_surgeon'][$i];
                            $op_assist_surg_id = $_POST['op_assist_surg_id'][$i];
                            if ($op_assist_surg_id != '') {
                                $query = "UPDATE `operation_surgeon_assist` SET `surgery_assist`='$assistant_surgeon',`status`='updated' WHERE `surg_assist_id`='$op_assist_surg_id'";
                            } else {
                                $query = "INSERT INTO `operation_surgeon_assist`(`op_note_id`, `surgery_list_id`, `surgery_id`, `patient_id`, 
                                `attend_id`, `surgery_assist`, `status`) 
                                VALUES ('$optnote_id','$surgery_list_id','$surgery_id','$patient_id','$attend_id','$assistant_surgeon','updated')";
                            };
                            $query_run = mysqli_query($con, $query);
                       }  
                  }

                        $query = "DELETE FROM `operation_surgeon_assist` WHERE `status`='' AND `op_note_id`='$optnote_id'";
                        $result = mysqli_query($con,$query);
                  echo "Assistant Surgeons Updated";  
                }  
                else  
                {  
                  echo "Assistant Surgeons NOT Updated";  
                }

            $query = "UPDATE `operation_nurses` SET `status`='' WHERE `op_note_id`='$optnote_id'";
            $result = mysqli_query($con,$query);
            $number_sn = count($_POST["scrub_nurse"]);  
                if($number_sn > 0)  
                {  
                  for($i=0; $i<$number_sn; $i++)  
                  {  
                       if(trim($_POST["scrub_nurse"][$i] != ''))  
                       {  
                            $scrub_nurse = $_POST['scrub_nurse'][$i];
                            $op_scrub_nurse_id = $_POST['op_scrub_nurse_id'][$i];
                            if ($op_scrub_nurse_id != '') {
                                $query = "UPDATE `operation_nurses` SET `scrub_nurse`='$scrub_nurse',`status`='updated' WHERE `op_nurse_id`='$op_scrub_nurse_id'";
                            } else {
                                $query = "INSERT INTO `operation_nurses`(`op_note_id`, `surgery_list_id`, `surgery_id`, 
                                        `patient_id`, `attend_id`, `scrub_nurse`, `status`) 
                                        VALUES ('$optnote_id','$surgery_list_id','$surgery_id','$patient_id','$attend_id','$scrub_nurse','updated')";
                            }
                            $query_run = mysqli_query($con, $query);
                       }  
                  }

                    $query = "DELETE FROM `operation_nurses` WHERE `status`='' AND `op_note_id`='$optnote_id'";
                    $result = mysqli_query($con,$query);
                  echo "Scrub Nurses Updated";  
                }  
                else  
                {  
                  echo "Scrub Nurses NOT Updated";  
                }  
        }
}

function save_anesthesia()
{
    global $con;
    $surgery_rscp = $_POST['surgery_rscp'];
    $surgery_airway = $_POST['surgery_airway'];
    $surgery_etmethod = $_POST['surgery_etmethod'];
    $surgery_intubation = $_POST['surgery_intubation'];
    $surgery_tube_type = $_POST['surgery_tube_type'];
    $surgery_tube_size = $_POST['surgery_tube_size'];
    $surgery_taped = $_POST['surgery_taped'];
    $surgery_blade_size = $_POST['surgery_blade_size'];
    $surgery_blade_type = $_POST['surgery_blade_type'];
    $surgery_eye = $_POST['surgery_eye'];
    $surgery_circuit = $_POST['surgery_circuit'];
    $surgery_crystaloids = $_POST['surgery_crystaloids'];
    $surgery_colloid = $_POST['surgery_colloid'];
    $surgery_prbc = $_POST['surgery_prbc'];
    $surgery_platelets = $_POST['surgery_platelets'];
    $surgery_others = $_POST['surgery_others'];
    $surgery_ebl = $_POST['surgery_ebl'];
    $surgery_urine_output = $_POST['surgery_urine_output'];
    $surgery_exubated = $_POST['surgery_exubated'];
    $surgery_exubated_date = $_POST['surgery_exubated_date'];
    $surgery_exubated_time = $_POST['surgery_exubated_time'];
    $surgery_mask = $_POST['surgery_mask'];
    $surgery_mask_date = $_POST['surgery_mask_date'];
    $surgery_mask_time = $_POST['surgery_mask_time'];
    $surgery_blood_req = $_POST['surgery_blood_req'];
    $surgery_path_req = $_POST['surgery_path_req'];
    $surgery_usa = $_POST['surgery_usa'];
    $surgery_anesthetist = $_POST['surgery_anesthetist'];
    $surgery_id = $_POST['surgery_id_anes'];
    $surgery_list_id = $_POST['surgery_list_id_anes'];
    $surgery_usa = $_POST['surgery_usa'];
    $patient_id = $_POST['patient_id'];
    $attend_id = $_POST['attend_id'];
    $surgery_anest_remarks = $_POST['surgery_anest_remarks'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $query = "INSERT INTO `anesthesia`(
    `attend_id`, `patient_id`, `anesthetist`, `exubated`, `exubated_date`, `exubated_time`, `mask`, `mask_date`, 
    `mask_time`, `blood_requested`, `rapid_sequence`, `airway`, `et_method`, `intubation`, `tube_type`, 
    `tube_size`, `taped`, `blade_size`, `blade_type`, `eye`, `circuit`, `crystaloids`, `colloid`, `red_blood_cell`, `platelets`, 
    `others`, `est_blood_loss`, `urine_output`, `surgery_id`, `surgery_list_id`, `patho_request`, 
    `usa_status`,`user_id`,`created_by`,`created_time`,`company_id`,`remarks`) 
    VALUES ('$attend_id','$patient_id','$surgery_anesthetist','$surgery_exubated','$surgery_exubated_date','$surgery_exubated_time',
    '$surgery_mask','$surgery_mask_date','$surgery_mask_time','$surgery_blood_req','$surgery_rscp','$surgery_airway','$surgery_etmethod',
    '$surgery_intubation','$surgery_tube_type','$surgery_tube_size','$surgery_taped','$surgery_blade_size','$surgery_blade_type',
    '$surgery_eye','$surgery_circuit','$surgery_crystaloids','$surgery_colloid','$surgery_prbc','$surgery_platelets','$surgery_others',
    '$surgery_ebl','$surgery_urine_output','$surgery_id','$surgery_list_id','$surgery_path_req',
    '$surgery_usa','$user_id','$user_id',NOW(),'$company_id','$surgery_anest_remarks')";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        if ($_SESSION['user_type_id'] == 6) {doctor_attend_register();};
        $query = "SELECT * FROM anesthesia WHERE surgery_list_id='$surgery_list_id' ORDER BY anesthesia_id DESC";
        $result = mysqli_query($con,$query);
        $row=mysqli_fetch_assoc($result);
        $anesthesia_id = $row['anesthesia_id'];

        $number_as = count($_POST["assistant_anesthetist"]);  
            if($number_as > 0)  
            {  
                for($i=0; $i<$number_as; $i++)  
                {  
                    if(trim($_POST["assistant_anesthetist"][$i] != ''))  
                    {  
                        $assistant_anesthetist = $_POST['assistant_anesthetist'][$i];
                        $query = "INSERT INTO `anest_assist`(`anest_id`, `surgery_list_id`, `surgery_id`, `patient_id`, 
                            `attend_id`, `anest_assist`) 
                            VALUES ('$anesthesia_id','$surgery_list_id','$surgery_id','$patient_id','$attend_id','$assistant_anesthetist')";
                        $query_run = mysqli_query($con, $query);
                    }  
                }
                echo "Assistant Anesthetist Inserted";  
            }  
            else  
            {  
                echo "Assistant Anesthetist NOT Inserted";  
            }

        $number_sn = count($_POST["anest_tech_desc"]);  
            if($number_sn > 0)  
            {  
                for($i=0; $i<$number_sn; $i++)  
                {  
                    if(trim($_POST["anest_tech_desc"][$i] != ''))  
                    {  
                        $anest_tech_desc = $_POST['anest_tech_desc'][$i];
                        $anest_tech_date = $_POST['anest_tech_date'][$i];
                        $anest_tech_time = $_POST['anest_tech_time'][$i];
                        $query = "INSERT INTO `anest_tech`(`anest_id`, `surgery_list_id`, `surgery_id`, `patient_id`, 
                        `attend_id`, `tech_desc`, `date`, `time`) 
                        VALUES ('$anesthesia_id','$surgery_list_id','$surgery_id','$patient_id','$attend_id','$anest_tech_desc','$anest_tech_date','$anest_tech_time')";
                        $query_run = mysqli_query($con, $query);
                    }  
                }
                echo "Technique Inserted";  
            }  
            else  
            {  
                echo "Technique NOT Inserted";  
            }  
    }
}

function edit_anesthesia()
{
    global $con;
    $surgery_list_id = $_POST['surgery_list_id'];
    $opnotes=array();
    $query = "SELECT * FROM anesthesia WHERE surgery_list_id='$surgery_list_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($opnotes, 
            $row['anesthesia_id'],$row['anesthetist'],$row['exubated'],$row['exubated_date'],$row['exubated_time'],$row['mask'],
            $row['mask_date'],$row['mask_time'],$row['blood_requested'],$row['rapid_sequence'],$row['airway'],$row['et_method'],
            $row['intubation'],$row['tube_type'],$row['tube_size'],$row['taped'],$row['blade_size'],$row['blade_type'],$row['eye'],
            $row['circuit'],$row['crystaloids'],$row['colloid'],$row['red_blood_cell'],$row['platelets'],$row['others'],
            $row['est_blood_loss'],$row['urine_output'],$row['patho_request'],$row['usa_status'],$row['surgery_id'],$row['surgery_list_id'],
            $row['remarks']
        );
    }
     echo json_encode($opnotes);
}

function edit_anest_tech()
{
    global $con;
    $anest_id = $_POST['anest_id'];
    $value = "";
    $value = '<table class="table table-bordered" id="anest_tech_table">
                <tr>
                    <th><a href="#" id="add_anest_tech_link">Technique</a></th>
                    <th>Tech. Date</th>
                    <th colspan="4">Tech. Time</th>
                </tr>';
    $query = "SELECT * FROM anest_tech WHERE anest_id='$anest_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
        {
            $i=0;
            while($row=mysqli_fetch_assoc($query_run))
            {
                $i=++$i;
                $value.='
                        <tr id="row_at'.$i.'">
                            <td>
                                <select class="form-control bg-light" name="anest_tech_desc[]" id="anest_tech_desc"> 
                                    <option value="0">Please Select</option>
                                    <option value="Combined"'; if($row['tech_desc'] == 'Combined'){$value.='selected="selected"';} 
                                    $value.='>Combined</option>
                                    <option value="General"'; if($row['tech_desc'] == 'General'){$value.='selected="selected"';}
                                    $value.='>General</option>
                                    <option value="Local"'; if($row['tech_desc'] == 'Local'){$value.='selected="selected"';}
                                    $value.='>Local</option>
                                    <option value="Nerve_Blk"'; if($row['tech_desc'] == 'Nerve_Blk'){$value.='selected="selected"';} 
                                    $value.='>Nerve Blk</option>
                                    <option value="Spinal"'; if($row['tech_desc'] == 'Spinal'){$value.='selected="selected"';} 
                                    $value.='>Spinal</option>
                                </select>
                                <input type="hidden" name="anest_tech_id []" class="form-control bg-light" id="anest_tech_id " value="'.$row['anest_tech_id'].'">
                            </td>
                            <td>
                                <input type="date" name="anest_tech_date[]" class="form-control bg-light" id="anest_tech_date" value="'.$row['date'].'">
                            </td>
                            <td>
                                <input type="time" name="anest_tech_time[]" class="form-control bg-light" id="anest_tech_time" value="'.$row['time'].'">
                            </td>
                            <td>
                                <a href="#" id="delete_anest_tech_link" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                            </td>
                        </tr>';
            };
            $value.='</tbody>
            </table>';
        }
    echo $value;
}

function edit_anest_assist()
{
    global $con;
    $anest_id = $_POST['anest_id'];
    $value = "";
    $value = '<table class="table table-bordered" id="assist_anest_table">
                <tr>
                    <th colspan="2"><a href="#" id="add_assist_anest_link">Assistant Anesthetist</a></th>
                </tr>';
    $query = "SELECT * FROM anest_assist WHERE anest_id='$anest_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
        {
            $i=0;
            while($row=mysqli_fetch_assoc($query_run))
            {
                $i=++$i;
                $value.='
                        <tr id="row_aa'.$i.'">
                            <td>
                                <input type="text" name="assistant_anesthetist[]" class="form-control bg-light" id="assistant_anesthetist" value="'.$row['anest_assist'].'">
                                <input type="hidden" name="anest_assist_id []" class="form-control bg-light" id="anest_assist_id" value="'.$row['anest_assist_id'].'">
                            </td>
                            <td>
                                <a href="#" id="delete_assist_anest_link" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                            </td>
                        </tr>';
            };
            $value.='</tbody>
            </table>';
        }
    echo $value;
}

function update_anesthesia()
{
    global $con;
    $anest_id = $_POST['surgery_anest_id'];
    $surgery_rscp = $_POST['surgery_rscp'];
    $surgery_airway = $_POST['surgery_airway'];
    $surgery_etmethod = $_POST['surgery_etmethod'];
    $surgery_intubation = $_POST['surgery_intubation'];
    $surgery_tube_type = $_POST['surgery_tube_type'];
    $surgery_tube_size = $_POST['surgery_tube_size'];
    $surgery_taped = $_POST['surgery_taped'];
    $surgery_blade_size = $_POST['surgery_blade_size'];
    $surgery_blade_type = $_POST['surgery_blade_type'];
    $surgery_eye = $_POST['surgery_eye'];
    $surgery_circuit = $_POST['surgery_circuit'];
    $surgery_crystaloids = $_POST['surgery_crystaloids'];
    $surgery_colloid = $_POST['surgery_colloid'];
    $surgery_prbc = $_POST['surgery_prbc'];
    $surgery_platelets = $_POST['surgery_platelets'];
    $surgery_others = $_POST['surgery_others'];
    $surgery_ebl = $_POST['surgery_ebl'];
    $surgery_urine_output = $_POST['surgery_urine_output'];
    $surgery_exubated = $_POST['surgery_exubated'];
    $surgery_exubated_date = $_POST['surgery_exubated_date'];
    $surgery_exubated_time = $_POST['surgery_exubated_time'];
    $surgery_mask = $_POST['surgery_mask'];
    $surgery_mask_date = $_POST['surgery_mask_date'];
    $surgery_mask_time = $_POST['surgery_mask_time'];
    $surgery_blood_req = $_POST['surgery_blood_req'];
    $surgery_path_req = $_POST['surgery_path_req'];
    $surgery_usa = $_POST['surgery_usa'];
    $surgery_anesthetist = $_POST['surgery_anesthetist'];
    $surgery_id = $_POST['surgery_id_anes'];
    $surgery_list_id = $_POST['surgery_list_id_anes'];
    $surgery_path_req = $_POST['surgery_path_req'];
    $surgery_usa = $_POST['surgery_usa'];
    $patient_id = $_POST['patient_id'];
    $attend_id = $_POST['attend_id'];
    $user_id = $_SESSION['user_id'];
    $surgery_anest_remarks = $_POST['surgery_anest_remarks'];
    $company_id = $_SESSION['company_id'];

    $query = "UPDATE `anesthesia` SET `attend_id`='$attend_id',`patient_id`='$patient_id',
    `anesthetist`='$surgery_anesthetist',`exubated`='$surgery_exubated',
    `exubated_date`='$surgery_exubated_date',`exubated_time`='$surgery_exubated_time',
    `mask`='$surgery_mask',`mask_date`='$surgery_mask_date',`mask_time`='$surgery_mask_time',
    `blood_requested`='$surgery_blood_req',`rapid_sequence`='$surgery_rscp',
    `airway`='$surgery_airway',`et_method`='$surgery_etmethod',`intubation`='$surgery_intubation',
    `tube_type`='$surgery_tube_type',`tube_size`='$surgery_tube_size',`taped`='$surgery_taped',
    `blade_size`='$surgery_blade_size',`blade_type`='$surgery_blade_type',`eye`='$surgery_eye',
    `circuit`='$surgery_circuit',`crystaloids`='$surgery_crystaloids',`colloid`='$surgery_colloid',
    `red_blood_cell`='$surgery_prbc',`platelets`='$surgery_platelets',`others`='$surgery_others',
    `est_blood_loss`='$surgery_ebl',`urine_output`='$surgery_urine_output',
    `patho_request`='$surgery_path_req',`usa_status`='$surgery_usa',`surgery_id`='$surgery_id',
    `surgery_list_id`='$surgery_list_id',`altered_by`='$user_id',`altered_time`=NOW(),
    `remarks`='$surgery_anest_remarks' WHERE `anesthesia_id`='$anest_id'";

    $query_run = mysqli_query($con, $query);

    if ($query_run) {

        $query = "UPDATE `anest_assist` SET `status`='' WHERE `anest_id`='$anest_id'";
        $result = mysqli_query($con,$query);

        $number_aa = count($_POST["assistant_anesthetist"]);  
            if($number_aa > 0)  
            {  
                for($i=0; $i<$number_aa; $i++)  
                {  
                    if(trim($_POST["assistant_anesthetist"][$i] !== ''))  
                    {  
                        $assistant_anesthetist = $_POST['assistant_anesthetist'][$i];
                        $anest_assist_id = $_POST['anest_assist_id'][$i];
                        if ($anest_assist_id !== '') {
                            $query = "UPDATE `anest_assist` SET `anest_assist`='$assistant_anesthetist',`status`='updated' WHERE `anest_assist_id`='$anest_assist_id'";
                        } else {
                            $query = "INSERT INTO `anest_assist`(`anest_id`, `surgery_list_id`, `surgery_id`, `patient_id`, 
                            `attend_id`, `anest_assist`, `status`) 
                            VALUES ('$anest_id','$surgery_list_id','$surgery_id','$patient_id','$attend_id','$assistant_anesthetist','updated')";
                        };
                        $query_run = mysqli_query($con, $query);
                    }  
                }

                    $query = "DELETE FROM `anest_assist` WHERE `status`='' AND `anest_id`='$anest_id'";
                    $result = mysqli_query($con,$query);
                echo "Assistant Anesthetist Updated";  
            }  
            else  
            {  
                echo "Assistant Anesthetist NOT Updated";  
            }

        $query = "UPDATE `anest_tech` SET `status`='' WHERE `anest_id`='$anest_id'";
        $result = mysqli_query($con,$query);
        $number_at = count($_POST["anest_tech_desc"]);  
            if($number_at > 0)  
            {  
                for($i=0; $i<$number_at; $i++)  
                {  
                    if(trim($_POST["anest_tech_desc"][$i] != ''))  
                    {  
                        $anest_tech_desc = $_POST['anest_tech_desc'][$i];
                        $anest_tech_id = $_POST['anest_tech_id'][$i];
                        $anest_tech_date = $_POST['anest_tech_date'][$i];
                        $anest_tech_time = $_POST['anest_tech_time'][$i];
                        if ($anest_tech_id != '') {
                            $query = "UPDATE `anest_tech` SET `tech_desc`='$anest_tech_desc',`date`='$anest_tech_date',`time`='$anest_tech_time',`status`='updated' WHERE `anest_tech_id`='$anest_tech_id'";
                        } else {
                            $query = "INSERT INTO `anest_tech`(`anest_id`, `surgery_list_id`, `surgery_id`, 
                                    `patient_id`, `attend_id`, `tech_desc`, `date`, `time`, `status`) 
                                    VALUES ('$anest_id','$surgery_list_id','$surgery_id','$patient_id','$attend_id','$anest_tech_desc','$anest_tech_date','$anest_tech_time','updated')";
                        }
                        $query_run = mysqli_query($con, $query);
                    }  
                }

                $query = "DELETE FROM `anest_tech` WHERE `status`='' AND `anest_id`='$anest_id'";
                $result = mysqli_query($con,$query);
                echo "Anesthesia Technique Updated";  
            }  
            else  
            {  
                echo "Anesthesia Technique NOT Updated";  
            }  
    }
}

function consent_upload_div()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $surgery_id = $_POST['surgery_id'];
    $surgery_list_id = $_POST['surgery_list_id'];
    $query = "SELECT * FROM surgery_list WHERE attend_id='$attend_id'";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) > 0)
    {
        $query = "SELECT * FROM consent_form WHERE 
        attend_id='$attend_id' AND 
        patient_id = '$patient_id' AND
        surgery_id='$surgery_id' AND 
        surgery_list_id = '$surgery_list_id'
        ";
        $result = mysqli_query($con,$query);
        if (mysqli_num_rows($result) > 0)
        {
            echo 'created';
        }
        else
        {
            echo 'none';
        }
    }
    else
    {
        echo 'no_surgery';
    }	
}

function consent_img_upload()
{
    global $con;
    if (isset($_POST['consent_img_save_btn'])) 
    {
        $attend_id = $_POST['consent_attend_id'];
        $patient_id = $_POST['consent_patient_id'];
        $doctor = $_POST['consent_doctor'];
        $relative = $_POST['consent_relative'];
        $language = $_POST['consent_language'];
        $surgery_id = $_POST['consent_form_surgery_id'];
        $surgery_list_id = $_POST['consent_form_surgery_list_id'];
        $file = $_FILES['consent_file'];
        $fileName = $_FILES['consent_file']['name'];
        $fileType = $_FILES['consent_file']['type'];
        $fileError = $_FILES['consent_file']['error'];
        $fileSize = $_FILES['consent_file']['size'];
        $fileTmpName = $_FILES['consent_file']['tmp_name'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        if (in_array($fileActualExt, $allowed)) 
        {
            if ($fileError === 0) 
            {
                if ($fileSize < 1000000) 
                {
                    $fileNameNew = $attend_id.$patient_id.$surgery_id.$surgery_list_id."_".uniqid('',true).".".$fileActualExt;
                    //$fileNameNew = uniqid('',true).".".$fileActualExt;
                    $fileDestination = $_SERVER['DOCUMENT_ROOT'].'/img/consent/'.$fileNameNew;
                    $fileUrl = '/img/consent/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    $sql = "SELECT * FROM `consent_form` WHERE `surgery_list_id`='$surgery_list_id'";
                    $result = mysqli_query($con, $sql);
                    if(mysqli_num_rows($result) > 0)
                    {
                        $query = "UPDATE `consent_form` SET `attend_id`='$attend_id', `patient_id`='$patient_id',
                        `img`='$fileDestination', `img_url`='$fileUrl',`doctor`='$doctor', `relative`='$relative',
                        `language`='$language', `surgery_id`='$surgery_id'
                        WHERE `surgery_list_id`='$surgery_list_id'";
                    }
                    else
                    {
                        $query = "INSERT INTO `consent_form`(`attend_id`, `patient_id`, `img`, 
                        `img_url`,`doctor`, `relative`, `language`, `surgery_id`, `surgery_list_id`) 
                        VALUES ('$attend_id', '$patient_id','$fileDestination','$fileUrl', '$doctor',
                        '$relative','$language','$surgery_id','$surgery_list_id')";
                    };

                    mysqli_query($con, $query);
                    header("Location: /layout/attendance/surgery_sheet.php?uploadsuccess");
                } else 
                {
                    echo "Your file is too big";
                };
                
            } 
            else 
            {
                echo "There was an error uploading your file";
            };
        }
        else
        {
            echo "You cannot upload files of this type";
        };
    };
}

function consent_img_display()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $surgery_id = $_POST['surgery_id'];
    $surgery_list_id = $_POST['surgery_list_id'];
    $fileName = $attend_id.$patient_id.$surgery_id.$surgery_list_id;
    $img_list=array();
    $query = "SELECT * FROM `consent_form` WHERE `img`LIKE '%$fileName%'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        while($row=mysqli_fetch_assoc($query_run))
        {
            array_push($img_list,$row['img_url']);
        };
        echo json_encode($img_list);
    };
}

function consent_form_pdf_processing()
{
    global $con;
        $_SESSION['surgery_id'] = $_POST['surgery_id'];
        $_SESSION['surgery'] = $_POST['surgery'];
        $_SESSION['surgery_list_id'] = $_POST['surgery_list_id'];
}

function past_operation_notes()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $attend_id = $_POST['attend_id'];
    $surgery_list_id = $_POST['surgery_list_id'];
    $surgery_id = $_POST['surgery_id'];
    $query = "SELECT * FROM operation_notes WHERE surgery_list_id='$surgery_list_id'";
    $result_op_notes = mysqli_query($con,$query);
    $op_notes_rows=mysqli_fetch_assoc($result_op_notes);
    $opnote_id = $op_notes_rows['optnote_id'];

    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <tbody class="pv-table-body">
                    <tr style="background-color:#E4E1E0">
                        <td width="25%"><small>Start Date</small></td>
                        <td width="25%"><small>Start Time</small></td>
                        <td width="50%"><small>Findings</small></td>
                    </tr>
                    <tr>
                        <td>'.$op_notes_rows['date_start'].'</td>
                        <td>'.$op_notes_rows['time_start'].'</td>
                        <td rowspan="5">'.$op_notes_rows['findings'].'</td>
                    </tr>
                    <tr style="background-color:#E4E1E0">
                        <td><small>End Date</small></td>
                        <td><small>End Time</small></td>
                    </tr>
                    <tr>
                        <td>'.$op_notes_rows['date_end'].'</td>
                        <td>'.$op_notes_rows['time_end'].'</td>
                    </tr>
                    <tr style="background-color:#E4E1E0">
                        <td colspan="2"><small>Head Surgeon</small></td>
                    </tr>
                    <tr>
                        <td colspan="2">'.$op_notes_rows['head_surgeon'].'</td>
                    </tr>
                    <tr style="background-color:#E4E1E0">
                        <td colspan="3"><small>Procedure</small></td>
                    </tr>
                    <tr>
                        <td colspan="3">'.$op_notes_rows['instructions'].'</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                                <tr style="background-color:#E4E1E0">
                                    <td><small>Assistant Surgeons</small></td>
                                </tr>';
        $query_assist_surg = "SELECT * FROM operation_surgeon_assist WHERE op_note_id='$opnote_id'";
        $result_assist_surg = mysqli_query($con,$query_assist_surg);

            while($row_assist_surg=mysqli_fetch_assoc($result_assist_surg))
            {
                        $value.='<tr>
                                    <td>'.$row_assist_surg['surgery_assist'].'</td>
                                </tr>';
            }
                    $value.='</table>
                        </td>
                        <td colspan="1">
                            <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                                <tr style="background-color:#E4E1E0">
                                    <td colspan="3"><small>Scrub Nurses</small></td>
                                </tr>';
        $query_scrub_nurse = "SELECT * FROM operation_nurses WHERE op_note_id='$opnote_id'";
        $result_scrub_nurse = mysqli_query($con,$query_scrub_nurse);

            while($row_scrub_nurse=mysqli_fetch_assoc($result_scrub_nurse))
            {
                        $value.='<tr>
                                    <td colspan="3">'.$row_scrub_nurse['scrub_nurse'].'</td>
                                </tr>';
            }
                    $value.='</table>
                        </td>
                    </tr>
                </tbody>
            </table>';
    echo $value;
}

function past_anesthesia()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $attend_id = $_POST['attend_id'];
    $surgery_list_id = $_POST['surgery_list_id'];
    $surgery_id = $_POST['surgery_id'];
    $query = "SELECT * FROM anesthesia WHERE surgery_list_id='$surgery_list_id'";
    $result_anest_list = mysqli_query($con,$query);
    $op_anest_rows=mysqli_fetch_assoc($result_anest_list);
    $anesthesia_id = $op_anest_rows['anesthesia_id'];

    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <tbody class="pv-table-body">
                    <tr style="background-color:#E4E1E0">
                        <td><small>Rapid Seq. Cricoid Pres.</small></td>
                        <td><small>Air Way</small></td>
                        <td><small>ET Method</small></td>
                        <td><small>Intubation</small></td>
                        <td><small>Tube Type</small></td>
                        <td><small>Tube Size (mm)</small></td>
                    </tr>
                    <tr>
                        <td>'.$op_anest_rows['rapid_sequence'].'</td>
                        <td>'.$op_anest_rows['airway'].'</td>
                        <td>'.$op_anest_rows['et_method'].'</td>
                        <td>'.$op_anest_rows['intubation'].'</td>
                        <td>'.$op_anest_rows['tube_type'].'</td>
                        <td>'.$op_anest_rows['tube_size'].'</td>
                    </tr>
                    <tr style="background-color:#E4E1E0">
                        <td><small>Taped (cm)</small></td>
                        <td><small>Blade Size</small></td>
                        <td><small>Blade Type</small></td>
                        <td><small>Eye</small></td>
                        <td><small>Circuit</small></td>
                        <td><small>Crystaloids</small></td>
                    </tr>
                    <tr>
                        <td>'.$op_anest_rows['taped'].'</td>
                        <td>'.$op_anest_rows['blade_size'].'</td>
                        <td>'.$op_anest_rows['blade_type'].'</td>
                        <td>'.$op_anest_rows['eye'].'</td>
                        <td>'.$op_anest_rows['circuit'].'</td>
                        <td>'.$op_anest_rows['crystaloids'].'</td>
                    </tr>
                    <tr style="background-color:#E4E1E0">
                        <td><small>Colloid</small></td>
                        <td><small>Packed Red Blood Cells</small></td>
                        <td><small>Platelets</small></td>
                        <td><small>Others</small></td>
                        <td><small>Estimated Blood Loss</small></td>
                        <td><small>Urine Output</small></td>
                    </tr>
                    <tr>
                        <td>'.$op_anest_rows['colloid'].'</td>
                        <td>'.$op_anest_rows['red_blood_cell'].'</td>
                        <td>'.$op_anest_rows['platelets'].'</td>
                        <td>'.$op_anest_rows['others'].'</td>
                        <td>'.$op_anest_rows['est_blood_loss'].'</td>
                        <td>'.$op_anest_rows['urine_output'].'</td>
                    </tr>
                    <tr style="background-color:#E4E1E0">
                        <td><small>Exubated</small></td>
                        <td><small>Exubated Date</small></td>
                        <td><small>Exubated Time</small></td>
                        <td><small>Mask/Throat Pack</small></td>
                        <td><small>Mask Out @ Date</small></td>
                        <td><small>Mask Out @ Time</small></td>
                    </tr>
                    <tr>
                        <td>'.$op_anest_rows['exubated'].'</td>
                        <td>'.$op_anest_rows['exubated_date'].'</td>
                        <td>'.$op_anest_rows['exubated_time'].'</td>
                        <td>'.$op_anest_rows['mask'].'</td>
                        <td>'.$op_anest_rows['mask_date'].'</td>
                        <td>'.$op_anest_rows['mask_time'].'</td>
                    </tr>
                    <tr style="background-color:#E4E1E0">
                        <td><small>Blood Requested</small></td>
                        <td><small>Pathology Requested</small></td>
                        <td><small>USA Status</small></td>
                        <td colspan="3"><small>Head Anesthetist</small></td>
                    </tr>
                    <tr>
                        <td>'.$op_anest_rows['blood_requested'].'</td>
                        <td>'.$op_anest_rows['patho_request'].'</td>
                        <td>'.$op_anest_rows['usa_status'].'</td>
                        <td colspan="3">'.$op_anest_rows['anesthetist'].'</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                                <tr style="background-color:#E4E1E0">
                                    <td><small>Technique</small></td>
                                    <td><small>Tech. Date</small></td>
                                    <td><small>Tech. Time</small></td>
                                </tr>';
        $query_anest_tech = "SELECT * FROM anest_tech WHERE anest_id='$anesthesia_id'";
        $result_anest_tech = mysqli_query($con,$query_anest_tech);

            while($row_anest_tech=mysqli_fetch_assoc($result_anest_tech))
            {
                        $value.='<tr>
                                    <td>'.$row_anest_tech['tech_desc'].'</td>
                                    <td>'.$row_anest_tech['date'].'</td>
                                    <td>'.$row_anest_tech['time'].'</td>
                                </tr>';
            }
                    $value.='</table>
                        </td>
                        <td colspan="3">
                            <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                                <tr style="background-color:#E4E1E0">
                                    <td colspan="3"><small>Assistant Anesthetist</small></td>
                                </tr>';
        $query_anest_assist = "SELECT * FROM anest_assist WHERE anest_id='$anesthesia_id'";
        $result_anest_assist = mysqli_query($con,$query_anest_assist);

            while($row_anest_assist=mysqli_fetch_assoc($result_anest_assist))
            {
                        $value.='<tr>
                                    <td colspan="3">'.$row_anest_assist['anest_assist'].'</td>
                                </tr>';
            }
                    $value.='</table>
                        </td>
                    </tr>
                </tbody>
            </table>';
    echo $value;
}

function set_surgery_price()
{
    global $con;
    $price_list=array();
    $sponsor_id = $_POST['sponsor_id'];
    $surgery_id = $_POST['surgery_id'];
    $query = "SELECT * FROM surgery WHERE surgery_id='$surgery_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        while($row_cash=mysqli_fetch_assoc($query_run))
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
    else if ($sponsor_id !== 1 && $sponsor_id !== 2)
    {
        $query = "SELECT * FROM price_list WHERE ledger_id='$sponsor_id' AND item_id='$surgery_id' AND category_id=5";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            while($row_pl = mysqli_fetch_assoc($query_run))
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
            $remark = 'private_no_list';
            array_push($price_list, $cash_price,$price,$price_adult,$price_child,$price_topup,$price_prvt,$price_prvt_topup,$remark);
            echo json_encode($price_list);
        };
    };
}

function delete_surgery_attend()
{
    global $con;
    $surgery_list_id = $_POST['surgery_list_id'];
    $attend_id = $_POST['attend_id'];
    $query = "DELETE FROM `surgery_list` WHERE surgery_list_id='$surgery_list_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=5 AND `item_list_id`='$surgery_list_id'";
        mysqli_query($con, $query_trans_del);
    }
    else
    {
        echo "Surgery NOT Deleted";
    };
}

?>
