<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//CONSUMABLES
function consumables_save()
{
    global $con;
    $con_id = $_POST['con_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $sponsor = $_POST['sponsor'];
    $comment = $_POST['comment'];
    $price = $_POST['price'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $qty = $_POST['qty'];
    $warehouse = $_POST['warehouse'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO `consumable_list`(
    `company_id`,`con_id`, `attend_id`, `patient_id`, `comment`, `date`, 
    `price_cash`, `amount_cash`, `qty_issued`, `ledger_id`, `warehouse_id`,
    `user_id`,`created_by`,`created_datetime`) VALUES (
    '$company_id','$con_id','$attend_id', '$patient_id', '$comment','$date','$price',
    '$amount', '$qty', '$sponsor', '$warehouse', '$user_id', '$user_id', NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        if ($_SESSION['user_type_id'] == 6) {
            doctor_attend_register();
        };
        //POST TRANSACTION
            $query_con_list = "SELECT * FROM `consumable_list` ORDER BY `con_list_id` DESC";
            $query_run_con_list = mysqli_query($con, $query_con_list);
            $row_con_list=mysqli_fetch_assoc($query_run_con_list);
            $con_list_id = $row_con_list['con_list_id'];
            $prvt_led_id = $row_con_list['ledger_id'];
            $amount_cash = $row_con_list['amount_cash'];
            $amount_prvt = $row_con_list['amount_prvt'];
            $amount_nhis = $row_con_list['amount_nhis'];
            $date = $row_con_list['date'];

            $query_trans = "SELECT * FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=7 AND `item_list_id`='$con_list_id'";
            $query_run_trans = mysqli_query($con, $query_trans);
            if (mysqli_num_rows($query_run_trans) > 0)
            {
                $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=7 AND `item_list_id`='$con_list_id'";
                mysqli_query($con, $query_trans_del);
                if ($amount_cash > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (1,10'$attend_id','$patient_id',7,'$date','$amount_cash','$amount_cash',0,'$con_list_id','$con_list_id','consumable for cash')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (10,1'$attend_id','$patient_id',7,'$date','$amount_cash',0,'$amount_cash','$con_list_id','$con_list_id','consumable for cash')";
                    mysqli_query($con, $query_cr);

                    //AUTO ITEMISED RECEIPT
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
                                    $item_list_id = $con_list_id;
                                    $item_id = $con_id;
                                    $category_id = 7;
                                    $price = $_POST['price'];
                                    $qty = $_POST['qty'];
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
                        };
                }
                if ($amount_prvt > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES ('$prvt_led_id',10,'$attend_id','$patient_id',7,'$date','$amount_prvt','$amount_prvt',0,'$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (10,'$prvt_led_id','$attend_id','$patient_id',7,'$date','$amount_prvt',0,'$amount_prvt','$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_cr);
                }
                if ($amount_nhis > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (2,10,'$attend_id','$patient_id',7,'$date','$amount_nhis','$amount_nhis',0,'$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (10,2,'$attend_id','$patient_id',7,'$date','$amount_nhis',0,'$amount_nhis','$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_cr);
                };
            }
            else
            {
                if ($amount_cash > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (1,10,'$attend_id','$patient_id',7,'$date','$amount_cash','$amount_cash',0,'$con_list_id','$con_list_id','consumable for cash')";
                    mysqli_query($con, $query_dr);
                    
                    $query_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (10,1,'$attend_id','$patient_id',7,'$date','$amount_cash',0,'$amount_cash','$con_list_id','$con_list_id','consumable for cash')";
                    mysqli_query($con, $query_cr);

                    //AUTO ITEMISED RECEIPT
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
                                    $item_list_id = $con_list_id;
                                    $item_id = $con_id;
                                    $category_id = 7;
                                    $price = $_POST['price'];
                                    $qty = $_POST['qty'];
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
                        };
                }
                if ($amount_prvt > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES ('$prvt_led_id',10,'$attend_id','$patient_id',7,'$date','$amount_prvt','$amount_prvt',0,'$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (10,'$prvt_led_id',,'$attend_id','$patient_id',7,'$date','$amount_prvt',0,'$amount_prvt','$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_cr);
                }
                if ($amount_nhis > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (2,10'$attend_id','$patient_id',7,'$date','$amount_nhis','$amount_nhis',0,'$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (10,2,'$attend_id','$patient_id',7,'$date','$amount_nhis',0,'$amount_nhis','$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_cr);
                };
            };
    }
    else
    {
        echo "Consumable NOT Added";
    };
}

function set_consumable_price()
{
    global $con;
    $price_list=array();
    $sponsor_id = $_POST['sponsor_id'];
    $con_id = $_POST['con_id'];
    $query = "SELECT * FROM consumable WHERE con_id='$con_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        while($row_cash = mysqli_fetch_assoc($query_run))
        {
            $cash_price = $row_cash['price_cash'];
            $nhis_id = $row_cash['nhis_id'];
        };
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
        $query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
        $query_run_nhis = mysqli_query($con, $query_nhis);
        if (mysqli_num_rows($query_run_nhis) > 0)
        {
            while($row_nhis=mysqli_fetch_assoc($query_run_nhis))
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
        $query_pl = "SELECT * FROM price_list WHERE ledger_id='$sponsor_id' AND item_id='$con_id' AND category_id=7";
        $query_run_pl = mysqli_query($con, $query_pl);
        if (mysqli_num_rows($query_run_pl) > 0)
        {
            while($row_pl=mysqli_fetch_assoc($query_run_pl))
            {
                //$cash_price = "";
                $price = "";
                $price_adult = "";
                $price_child = "";
                $price_topup = "";
                if($row_pl['price'] > 0)
                {
                    $price_prvt = $row_pl['price'];
                }
                else
                {
                    $price_prvt = $cash_price;
                };
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

function consumables_current_view()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">Date</th>
                            <th class="action-td">Consumable</th>
                            <th class="action-td">Qty</th>';
                        if (
                            $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                            $_SESSION['user_type'] == 'Super_User' OR 
                            ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
                            {
                                $value.='<th class="action-td">Price</th>
                                <th class="action-td">Amount - Cash</th>
                                <th class="action-td">Amount - Disc.</th>
                                <th class="action-td">Amount - Prvt</th>
                                <th class="action-td">Amount - NHIS</th>';
                            };

                            $value.='<th class="action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">';

                $query = "SELECT * FROM consumable_list WHERE attend_id='$attend_id' ORDER BY date DESC";
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
                            $con_id = $row['con_id'];
                            $query_con = "SELECT consumable FROM consumable WHERE con_id='$con_id'";
                            $query_run_con = mysqli_query($con, $query_con);
                            $row_con = mysqli_fetch_assoc($query_run_con);

                            $ledger_id = $row['ledger_id'];
                            $query_led = "SELECT ledger_desc FROM ledgers WHERE ledger_id='$ledger_id'";
                            $query_run_led = mysqli_query($con, $query_led);
                            $row_led = mysqli_fetch_assoc($query_run_led);

                            $con_list_id = $row['con_list_id'];
                            $query_disc = "SELECT SUM(amount) AS amount FROM discount WHERE con_list_id='$con_list_id'";
                            $query_run_disc = mysqli_query($con, $query_disc);
                            $row_disc = mysqli_fetch_assoc($query_run_disc);
                            if (isset($row_disc)) {
                                $amt_disc = $row_disc['amount'];
                            } else {
                                $amt_disc = 0;
                            };

                $value.='<tr>
                            <td class="action-td">'.$row['date'].'</td>
                            <td>'.$row_con['consumable'].'</td>
                            <td class="action-td">'.$row['qty_issued'].'</td>';
                            if (
                                $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                $_SESSION['user_type'] == 'Super_User' OR 
                                ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
                                {
                                    $value.='<td class="amt-td">'.$row['price_cash'].'</td>
                                    <td class="amt-td">'.$row['amount_cash'].'</td>
                                    <td class="amt-td">'.$amt_disc.'</td>
                                    <td class="amt-td">'.$row['amount_prvt'].'</td>
                                    <td class="amt-td">'.$row['amount_nhis'].'</td>';
                                };
                                $total_cash+=$row['amount_cash'];
                                $total_disc+=$amt_disc;
                                $total_prvt+=$row['amount_prvt'];
                                $total_nhis+=$row['amount_nhis'];
                $value.='<td class="action-td">';
                                if (
                                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Consumable_List'] == 'Yes')) 
                                {
                                    $value.='<a href="#" id="btn_consum_list_edit" 
                                        data-id12="'.$row['con_list_id'].'"
                                        data-id13="'.$row['con_id'].'" 
                                    >Edit</a>';
                                };

                                if (
                                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Discount'] == 'Yes')) 
                                {
                                    $value.='<a href="#" id="btn_discount_consum_list"
                                        class="data-toggle="tooltip" data-placement="left" title="Discount Consumable""
                                        data-id="'.$row['attend_id'].'"
                                        data-id1="'.$_SESSION['patient_id'].'"
                                        data-id2="'.$row['con_list_id'].'"
                                        data-id3="'.$_SESSION['name'].'"
                                        data-id4="'.$row['amount_cash'].'"
                                        data-id5="'.$amt_disc.'"
                                        > | 
                                            Disc.
                                        </a>';
                                };

                      if (
                            $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                            $_SESSION['user_type'] == 'Super_User' OR 
                            ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Consumable_List'] == 'Yes')) 
                        {
                            $value.=' | 
                                        <a href="#" id="btn_delete_consum_list" 
                                            data-id8="'.$row['con_list_id'].'"
                                            data-id9="'.$row['con_id'].'" 
                                            class="data-toggle="tooltip" data-placement="left" title="Delete Consumable""
                                        >
                                            Delete
                                        </a>';
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
                                    <td class="action-td" colspan="4">TOTAL</td>
                                    <td class="amt-td">'.$total_cash.'</td>
                                    <td class="amt-td">'.$total_disc.'</td>
                                    <td class="amt-td">'.$total_prvt.'</td>
                                    <td class="amt-td">'.$total_nhis.'</td>
                                    <td></td>
                                    </tr>';
                                };
                    };
    $value.='</tbody>
               </table>';
    echo $value;
}

function edit_consumable_sheet()
{
    global $con;
    $con_list_id = $_POST['con_list_id'];
    $consumable_data=array();
    $query = "SELECT * FROM consumable_list WHERE con_list_id='$con_list_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($consumable_data, 
            $row['date'],
            $row['con_id'],
            $row['attend_id'],
            $row['patient_id'],
            $row['con_list_id'],
            $row['comment'],
            $row['price_cash'],
            $row['amount_cash'],
            $row['qty_issued'],
            $row['ledger_id'],
            $row['warehouse_id']
        );
    };
     echo json_encode($consumable_data);
}

function consumables_update()
{
    global $con;
    $con_list_id = $_POST['con_list_id'];
    $con_id = $_POST['con_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $sponsor = $_POST['sponsor'];
    $comment = $_POST['comment'];
    $price = $_POST['price'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $qty = $_POST['qty'];
    $warehouse = $_POST['warehouse'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `consumable_list` SET
    `con_id`='$con_id', `attend_id`='$attend_id', `patient_id`='$patient_id', 
    `comment`='$comment', `date`='$date', `price_cash`='$price', 
    `amount_cash`='$amount', `qty_issued`='$qty', `ledger_id`='$sponsor', 
    `warehouse_id`='$warehouse',`altered_by`='$user_id',`altered_datetime`=NOW() 
    WHERE `con_list_id`='$con_list_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        //POST TRANSACTION
            $query_con_list = "SELECT * FROM `consumable_list` WHERE `con_list_id`='$con_list_id'";
            $query_run_con_list = mysqli_query($con, $query_con_list);
            $row_con_list=mysqli_fetch_assoc($query_run_con_list);
            $prvt_led_id = $row_con_list['ledger_id'];
            $amount_cash = $row_con_list['amount_cash'];
            $amount_prvt = $row_con_list['amount_prvt'];
            $amount_nhis = $row_con_list['amount_nhis'];
            $date = $row_con_list['date'];

            $query_trans = "SELECT * FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=7 AND `item_list_id`='$con_list_id'";
            $query_run_trans = mysqli_query($con, $query_trans);
            if (mysqli_num_rows($query_run_trans) > 0)
            {
                $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=7 AND `item_list_id`='$con_list_id'";
                mysqli_query($con, $query_trans_del);
                if ($amount_cash > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (1,10,'$attend_id','$patient_id',7,'$date','$amount_cash','$amount_cash',0,'$con_list_id','$con_list_id','consumable for cash')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (10,1,'$attend_id','$patient_id',7,'$date','$amount_cash',0,'$amount_cash','$con_list_id','$con_list_id','consumable for cash')";
                    mysqli_query($con, $query_cr);
                }
                if ($amount_prvt > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES ('$prvt_led_id',10,'$attend_id','$patient_id',7,'$date','$amount_prvt','$amount_prvt',0,'$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (10,'$prvt_led_id','$attend_id','$patient_id',7,'$date','$amount_prvt',0,'$amount_prvt','$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_cr);
                }
                if ($amount_nhis > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (2,10,'$attend_id','$patient_id',7,'$date','$amount_nhis','$amount_nhis',0,'$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (10,2,'$attend_id','$patient_id',7,'$date','$amount_nhis',0,'$amount_nhis','$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_cr);
                };
            }
            else
            {
                if ($amount_cash > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (1,10,'$attend_id','$patient_id',7,'$date','$amount_cash','$amount_cash',0,'$con_list_id','$con_list_id','consumable for cash')";
                    mysqli_query($con, $query_dr);
                    
                    $query_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (10,1,'$attend_id','$patient_id',7,'$date','$amount_cash',0,'$amount_cash','$con_list_id','$con_list_id','consumable for cash')";
                    mysqli_query($con, $query_cr);
                }
                if ($amount_prvt > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES ('$prvt_led_id',10,'$attend_id','$patient_id',7,'$date','$amount_prvt','$amount_prvt',0,'$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (10,'$prvt_led_id','$attend_id','$patient_id',7,'$date','$amount_prvt',0,'$amount_prvt','$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_cr);
                }
                if ($amount_nhis > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (2,10,'$attend_id','$patient_id',7,'$date','$amount_nhis','$amount_nhis',0,'$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) VALUES (10,2,'$attend_id','$patient_id',7,'$date','$amount_nhis',0,'$amount_nhis','$con_list_id','$con_list_id','consumable for NHIS')";
                    mysqli_query($con, $query_cr);
                };
            };
    }
    else
    {
        echo "Consumable NOT updated";
    };
}

?>
