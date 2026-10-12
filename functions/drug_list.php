<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//DRUGS
function save_drug_attend()
{
    global $con;
    $drug = $_POST['drug'];
    $dosage = $_POST['dosage'];
    $qty_presc = $_POST['qty_presc'];
    $drug_comment = $_POST['drug_comment'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $drug_sponsor = $_POST['drug_sponsor'];
    if(isset($_POST['drug_price_est']))
    {$drug_price_est = $_POST['drug_price_est'];}else{$drug_price_est = 0;};
    if(isset($_POST['drug_amt_est']))
    {$drug_amt_est = $_POST['drug_amt_est'];}else{$drug_amt_est = 0;};
    $drug_date = $_POST['drug_date'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    
    /*$query_diagnosis_list = "SELECT * FROM diagnosis_list WHERE attend_id='$attend_id'";
    $result_diagnosis_list = mysqli_query($con, $query_diagnosis_list);
    $rows_diagnosis_list = mysqli_num_rows($result_diagnosis_list);
    if($rows_diagnosis_list > 0)
    {*/
        $query = "INSERT INTO `drug_list`(`company_id`, `attend_id`, `patient_id`, `drug_id`, 
        `qty_presc`, `dosage`, `comment_presc`, `date`, `ledger_id`, `price_est`, `amount_est`,
        `user_id`, `created_by`, `created_datetime`, `branch_id`) VALUES ('$company_id','$attend_id','$patient_id','$drug','$qty_presc','$dosage',
        '$drug_comment','$drug_date','$drug_sponsor','$drug_price_est','$drug_amt_est',
        '$user_id','$user_id',NOW(),'$branch_id')";
        $query_run = mysqli_query($con, $query);

        if ($query_run)
        {
            if ($_SESSION['user_type_id'] == 6) {
                doctor_attend_register();
            };
            view_current_drugs();
        }
        else
        {
            echo "Drug NOT Added";
        };
    /*}
    else
    {
        echo 'enter_diagnosis';
    };*/
}

function save_drug_attend_composite()
{
    global $con;
    $composite_drug_id = $_POST['composite_drug_select'];
    $composite_days = $_POST['composite_days'];
    $attend_id = $_POST['drug_attend_id'];
    $patient_id = $_POST['drug_patient_id'];
    $drug_sponsor = $_POST['drug_sponsor'];
    $drug_comment = $_POST['drug_comment'];
    $drug_date = $_POST['drug_date'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query_ward_list = "SELECT * FROM wardlist WHERE attend_id = '$attend_id' ORDER BY wardlist_id DESC";
    $result_ward_list = mysqli_query($con, $query_ward_list);
    
    if(($composite_days == 0 && mysqli_num_rows($result_ward_list) < 1 ) || ($composite_days > 0  && mysqli_num_rows($result_ward_list) > 0))
    {
        /*$query_diagnosis_list = "SELECT * FROM diagnosis_list WHERE attend_id='$attend_id'";
        $result_diagnosis_list = mysqli_query($con, $query_diagnosis_list);
        $rows_diagnosis_list = mysqli_num_rows($result_diagnosis_list);
        if($rows_diagnosis_list > 0)
        {*/
            $query_com_drug = "SELECT * FROM `composite_drugs` WHERE `composite_drug_id` = '$composite_drug_id'";
            $query_run_com_drug = mysqli_query($con, $query_com_drug);
            $row_com_drug = mysqli_fetch_assoc($query_run_com_drug);
            $composite_drug_price = $row_com_drug['price'];
            $comment = $row_com_drug['composite_drug'].' dispensed';

            $query_com_drug_list = "SELECT * FROM `composite_drug_list` WHERE `composite_drug_id` = '$composite_drug_id'";
            $query_run_com_drug_list = mysqli_query($con, $query_com_drug_list);
            if(mysqli_num_rows($query_run_com_drug_list) > 0)
            {
                while($row_com_drug_list = mysqli_fetch_assoc($query_run_com_drug_list))
                {
                    $drug_id  = $row_com_drug_list['drug_id'];
                    $qty_presc  = $row_com_drug_list['qty'];
                    $dosage  = $row_com_drug_list['dosage'];
                    $query_drug = "SELECT * FROM `drugs` WHERE `drug_id` = '$drug_id'";
                    $query_run_drug = mysqli_query($con, $query_drug);
                    $row_drug = mysqli_fetch_assoc($query_run_drug);
                    //$drug_price = $row_com_drug['price_cash'];
                    $drug_price_est = 0;
                    $drug_amt_est = 0;

                    $query = "INSERT INTO `drug_list`(`company_id`, `attend_id`, `patient_id`, `drug_id`, 
                    `qty_presc`, `dosage`, `comment_presc`, `date`, `ledger_id`, `price_est`, `amount_est`,
                    `user_id`, `created_by`, `created_datetime`, `branch_id`) VALUES ('$company_id','$attend_id','$patient_id',
                    '$drug_id','$qty_presc','$dosage','$comment','$drug_date','$drug_sponsor',
                    '$drug_price_est','$drug_amt_est','$user_id','$user_id',NOW(),'$branch_id')";
                    $query_run = mysqli_query($con, $query);
                    
                    if ($query_run)
                    {
                        $query_dl = "SELECT `drug_list_id` FROM `drug_list` ORDER BY `drug_list_id` DESC";
                        $query_run_dl = mysqli_query($con, $query_dl);
                        $row_dl = mysqli_fetch_assoc($query_run_dl);
                        $drug_list_id = $row_dl['drug_list_id'];

                        $query = "INSERT INTO `drug_dispense_list`(`company_id`,`drug_list_id`, `drug_presc_id`, 
                        `drug_id`, `patient_id`, `attend_id`, `warehouse_id`, `ledger_id`, `date`, `category_id`,
                        `dosage`, `qty`, `qty_nhis`, `price_cash`, `price_prvt`, `price_nhis`, 
                        `amt_cash`, `amt_prvt`, `amt_nhis`, `comment`, `user_id`, `created_by`, `created_timestamp`, `branch_id`) 
                        VALUES ('$company_id','$drug_list_id','$drug_id','$drug_id','$patient_id','$attend_id',
                        2,'$drug_sponsor','$drug_date',2,'$dosage','$qty_presc','$qty_presc',0,0,0,0,0,0,
                        '$comment','$user_id','$user_id',NOW(),'$branch_id')";
                        mysqli_query($con, $query);

                        /*$query_receipt_item = "INSERT INTO `receipt_items`(`company_id`, `attend_id`, `patient_id`, 
                        `receipt_id`, `date`, `category_id`, `item_id`, `item_list_id`, `qty`, `price`, `amount_rec`, 
                        `created_by`, `created_datetime`) 
                        VALUES ('$company_id','$attend_id','$patient_id',0,'$drug_date',2,'$drug_id','$drug_list_id',
                        '$qty_presc',0,0,'$user_id',NOW())";
                        mysqli_query($con, $query_receipt_item);*/

                        if ($_SESSION['user_type_id'] == 6) 
                        {
                            doctor_attend_register();
                        };
                    };
                };
                
                $bill_date = date('Y-m-d');
                $counter = 1;
                if($composite_days != '' && $composite_days != 0)
                {
                    while($composite_days >= $counter)
                    {
                        $query = "INSERT INTO `service_list`(
                        `company_id`,`service_id`, `attend_id`, `patient_id`, `date`, `qty`, 
                        `price_cash`, `price_nhis`, `price_prvt`, `amount_cash`, `amount_nhis`, 
                        `amount_prvt`, `comment`, `ledger_id`, `doctor_id`, `user_id`, `created_by`, `created_on`, `branch_id`) 
                        VALUES (
                        '$company_id',24,'$attend_id','$patient_id','$bill_date',1,0,0,0,0,0,0,'accommodation auto bill',
                        1,'$user_id','$user_id','$user_id',NOW(),'$branch_id')";
                        mysqli_query($con, $query);

                        $query_sl = "SELECT `service_list_id` FROM `service_list` ORDER BY `service_list_id` DESC";
                        $query_run_sl = mysqli_query($con, $query_sl);
                        $row_sl = mysqli_fetch_assoc($query_run_sl);
                        $service_list_id = $row_sl['service_list_id'];

                        /*$query_receipt_item = "INSERT INTO `receipt_items`(`company_id`, `attend_id`, `patient_id`, 
                        `receipt_id`, `date`, `category_id`, `item_id`, `item_list_id`, `qty`, `price`, `amount_rec`, 
                        `created_by`, `created_datetime`) 
                        VALUES ('$company_id','$attend_id','$patient_id',0,'$bill_date',1,
                        24,'$service_list_id',1,0,0,'$user_id',NOW())";
                        mysqli_query($con, $query_receipt_item);*/

                        $bill_date = date('Y-m-d', strtotime($bill_date.' + 1 day'));
                        $counter = $counter + 1;
                    };
                };
            };
        /*}
        else
        {
            echo 'enter_diagnosis';
        };*/
    }
    else
    {
        echo 'no_ward';
    };
}

function select_drug_attend()
{
    global $con;
    $drug_id = $_POST['drug_id'];
    $drug_data=array();
    $query = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($drug_data, 
            $row['gender'],
            $row['age_from'],
            $row['age_to'],
            $row['block_neg'],
            $row['expiry_date'],
            $row['batch'],
            $row['days_prompt']
        );
    }
     echo json_encode($drug_data);
}

function select_drug_attend_from_history()
{
    global $con;
    $drug_id = $_POST['drug_id'];
    $date = date('Y-m-d');
    $drug_data=array();
    $query = "SELECT * FROM drugs WHERE drug_id=$drug_id";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($drug_data, 
            $row['gender'],
            $row['age_from'],
            $row['age_to'],
            $date
        );
    }
     echo json_encode($drug_data);
}

function check_drug_attend_duplicate()
{
    global $con;
    $drug_id = $_POST['drug'];
    $attend_id = $_POST['attend_id'];
    $drug_dup=array();
    $query = "SELECT * FROM drug_list WHERE drug_id='$drug_id' AND attend_id='$attend_id'";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) > 0)
    {
        $query_drug = "SELECT * FROM drugs WHERE drug_id=$drug_id";
        $result_drug = mysqli_query($con,$query_drug);
        $row_drug=mysqli_fetch_assoc($result_drug);
        array_push($drug_dup, 
            'duplicate',
            $row_drug['brand_name']
        );
    }
    else
    {
         array_push($drug_dup, 
            'none'
        );

    }
    echo json_encode($drug_dup);
}

function edit_drug_attend()
{
    global $con;
    $drug_list_id = $_POST['drug_list_id'];
    $Drug_List_Data=array();
    $query = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Drug_List_Data, 
            $row['date'],
            $row['drug_id'],
            $row['drug_list_id'],
            $row['qty_presc'],
            $row['dosage'],
            $row['price_est'],
            $row['amount_est'],
            $row['comment_presc'],
            $row['ledger_id']
        );
    }
     echo json_encode($Drug_List_Data);
}

function update_drug_attend()
{
    global $con;
    $drug_list_id = $_POST['drug_list_id'];
    $drug_id = $_POST['drug_id'];
    $dosage = $_POST['dosage'];
    $qty_presc = $_POST['qty_presc'];
    $drug_price_est = $_POST['drug_price_est'];
    $drug_amt_est = $_POST['drug_amt_est'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $comment = $_POST['comment'];
    $drug_sponsor = $_POST['drug_sponsor'];
    $drug_date = $_POST['drug_date'];
    $user_id = $_SESSION['user_id'];
    
    $query = "UPDATE `drug_list` SET `attend_id`='$attend_id',`patient_id`='$patient_id',
    `drug_id`='$drug_id',`comment_presc`='$comment',`dosage`='$dosage',
    `qty_presc`='$qty_presc',`price_est`='$drug_price_est',`amount_est`='$drug_amt_est',
    `ledger_id`='$drug_sponsor',`date`='$drug_date',`altered_by`='$user_id',`altered_datetime`=NOW() WHERE `drug_list_id`='$drug_list_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        view_current_drug();
    }
    else
    {
        echo "Drug NOT Updated";
    };
}

function view_current_drugs()
{
    global $con;
    $attend_id = $_SESSION['attend_id'];
    $patient_id = $_SESSION['patient_id'];

    date_default_timezone_set("Africa/Accra");
    $date_today = date('Y-m-d');
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="action-td">Date</th>
                <th class="action-td">Time</th>
                <th class="action-td">Drug</th>
                <th class="action-td">Dosage</th>
                <th class="action-td">Qty Presc.</th>';
                if (
                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                    $_SESSION['user_type'] == 'Super_User' OR 
                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
                    {
                        $value.='<th class="action-td">Qty Disp.</th>
                                <th class="action-td">Amt-Estimate</th>
                                <th class="action-td">Amt-Cash</th>
                                <th class="action-td">Amt-Disc</th>
                                <th class="action-td" hidden="true">Amt-Prvt</th>
                                <th class="action-td" hidden="true">Amt-NHIS</th>';
                    };
                        $value.='<th class="action-td">Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">';
    $query = "SELECT * FROM drug_list WHERE attend_id='$attend_id' ORDER BY date DESC";
    $result = mysqli_query($con,$query);
    $total_est=0;
    $total_cash=0;
    $total_disc=0;
    $total_prvt=0;
    $total_nhis=0;
    if (mysqli_num_rows($result) > 0)
    {
        while($row=mysqli_fetch_assoc($result))
        {
            $amt_est=0;
            $amt_cash=0;
            $amt_disc=0;
            $amt_prvt=0;
            $amt_nhis=0;
            $drug_id = $row['drug_id'];
            $query = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
            $query_run_drug = mysqli_query($con, $query);
            $row_drug=mysqli_fetch_assoc($query_run_drug);

            $drug_list_id = $row['drug_list_id'];
            $query_ddisp = "SELECT SUM(amt_cash) AS amt_cash,MAX(price_cash) AS price_cash, SUM(amt_prvt) AS amt_prvt, SUM(amt_nhis) AS amt_nhis, SUM(qty) AS qty FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
            $query_run_ddisp = mysqli_query($con, $query_ddisp);
            $row_ddisp=mysqli_fetch_assoc($query_run_ddisp);

            /*$query_receipt_item = "SELECT * FROM `receipt_items` WHERE `attend_id` = '$attend_id' AND `category_id` = 2 
            AND `item_list_id`='$drug_list_id'";
            $query_run_receipt_item = mysqli_query($con, $query_receipt_item);
            $rows_receipt_item_count = mysqli_num_rows($query_run_receipt_item);*/

            $query_ddl = "SELECT drug_id FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
            $query_run_ddl = mysqli_query($con, $query_ddl);
            if(mysqli_num_rows($query_run_ddl) > 0)
            {
                $sup_drugs = '';
                while($row_ddl=mysqli_fetch_assoc($query_run_ddl))
                {
                    $drug_id_ddl = $row_ddl['drug_id'];
                    $query_drug_ddl = "SELECT * FROM drugs WHERE drug_id='$drug_id_ddl'";
                    $query_run_drug_ddl = mysqli_query($con, $query_drug_ddl);
                    $row_drug_ddl = mysqli_fetch_assoc($query_run_drug_ddl);
                    $sup_drugs .= $row_drug_ddl['brand_name'].'<br>';
                };
            }
            else
            {
                $sup_drugs = 'Not dispensed yet';
            };

            $query_dadmin = "SELECT SUM(qty_admin) AS qty_admin FROM  drug_admin WHERE drug_id='$drug_id' AND drug_list_id='$drug_list_id'";
            $query_run_dadmin = mysqli_query($con, $query_dadmin);
            if(isset($query_run_dadmin))
            {
                $row_dadmin = mysqli_fetch_assoc($query_run_dadmin);
                $qty_admin = $row_dadmin['qty_admin'];
            }
            else
            {
                $qty_admin = 0;
            };

            $query_returned = "SELECT SUM(qty) AS qty_returned FROM  drug_patient_returns WHERE drug_id='$drug_id' AND drug_list_id='$drug_list_id'";
            $query_run_returned = mysqli_query($con, $query_returned);
            if(isset($query_run_returned))
            {
                $row_returned = mysqli_fetch_assoc($query_run_returned);
                $qty_returned = $row_returned['qty_returned'];
            }
            else
            {
                $qty_returned = 0;
            };

            $query_disc = "SELECT SUM(amount) AS amount FROM discount WHERE drug_list_id='$drug_list_id'";
            $query_run_disc = mysqli_query($con, $query_disc);
            $row_disc = mysqli_fetch_assoc($query_run_disc);
            if (isset($row_disc)) {
                $amt_disc = $row_disc['amount'];
            } else {
                $amt_disc = 0;
            };

            $value.='<tr  id="'.$drug_list_id.'">
                        <td class="action-td">'.$row['date'].'</td>
                        <td class="action-td">'.$row['created_datetime'].'</td>
                        <td style="display: none;"><strong>'.$row_drug['brand_name'].'</strong></td>
                        <td><strong>'.$row_drug['brand_name'].'</strong><br><small>'.$sup_drugs.'</small></td>
                        <td class="action-td">';
                            if($row['qty_presc'] < 1)
                            {
                                $value.='<a href="#" 
                                            id="btn_drug_edit_qty" 
                                            data-id="'.$row['drug_list_id'].'"
                                            data-id1="'.$row_drug['brand_name'].'"
                                        >
                                            '.$row['dosage'].'
                                        </a>';
                            }
                            else
                            {
                                $value.= $row['dosage'];
                            };
                    $value.='</td>
                        <td class="action-td">'.$row['qty_presc'].'</td>';

                        if (
                            $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                            $_SESSION['user_type'] == 'Super_User' OR 
                            ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
                            {
                                $value.='<td class="action-td">'.$row_ddisp['qty'].'</td>
                                    <td class="amt-td">'.$row['amount_est'].'</td>
                                    <td class="amt-td">'.$row_ddisp['amt_cash'].'</td>
                                    <td class="amt-td">'.$amt_disc.'</td>
                                    <td class="amt-td" hidden="true">'.$row_ddisp['amt_prvt'].'</td>
                                    <td class="amt-td" hidden="true">'.$row_ddisp['amt_nhis'].'</td>';
                                    
                            };

                            $total_est+=$row['amount_est'];
                            $total_cash+=$row_ddisp['amt_cash'];
                            $total_disc+=$amt_disc;
                            $total_prvt+=$row_ddisp['amt_prvt'];
                            $total_nhis+=$row_ddisp['amt_nhis'];

                        $value.='<td class="action-td">';
                        if($row_ddisp['qty'] <= 0)
                        {
                            if ($_SESSION['user_id'] == $row['user_id']) 
                            {
                                if($row['date'] == $date_today)
                                {
                                    if (
                                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                        $_SESSION['user_type'] == 'Super_User' OR 
                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Prescription'] == 'Yes')) 
                                    {
                                        
                                        $value.='<a href="#" id="btn_edit_drug_list" data-id1="'.$row['drug_list_id'].'">Edit Presc.</a> | ';
                                    };
                                };
                            };
                        };

                           if (
                                $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                $_SESSION['user_type'] == 'Super_User' OR 
                                ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Dispense_Prescription'] == 'Yes')) 
                                {
                                    //if($rows_receipt_item_count > 0)
                                    //{
                                        $value.='
                                        <a href="#" id="btn_disp_drug_list" data-id1="'.$row['drug_list_id'].'" data-id2="'.$row_drug['drug_id'].'">
                                        Dispense</a> | ';
                                    //};
                                };

                        if (
                            $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                            $_SESSION['user_type'] == 'Super_User' OR 
                            ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Administer_Prescription'] == 'Yes')) 
                            {
                                $value.='
                                <a href="#" id="btn_admin_drug_list" data-id1="'.$row['drug_list_id'].'"  data-id2="'.$row_drug['drug_id'].'">
                                Administer</a>';
                            };

                        if ($row_ddisp['qty'] > 0) 
                        {
                            if (
                                $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                $_SESSION['user_type'] == 'Super_User' OR 
                                ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Label_Prescription'] == 'Yes')) 
                                {
                                    $value.=' | <a href="#" id="btn_label_drug_list" data-id1="'.$row['drug_list_id'].'"  data-id2="'.$row_drug['drug_id'].'">Label</a>';
                                };

                            if (
                                $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                $_SESSION['user_type'] == 'Super_User' OR 
                                ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Discount'] == 'Yes')) 
                                {
                                    $value.=' | <a href="#" id="btn_discount_drug_list" 
                                                data-id="'.$row['attend_id'].'"
                                                data-id1="'.$_SESSION['patient_id'].'"
                                                data-id2="'.$row['drug_list_id'].'"
                                                data-id3="'.$_SESSION['name'].'"
                                                data-id4="'.$row_ddisp['amt_cash'].'"
                                                data-id5="'.$amt_disc.'">
                                                Disc.
                                            </a>';
                                };

                            if (
                                $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                $_SESSION['user_type'] == 'Super_User' OR 
                                ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Patient_Drug_Returns'] == 'Yes')) 
                                {
                                    $value.=' | <a href="#" id="btn_patient_drug_returns" 
                                                data-id="'.$row['attend_id'].'"
                                                data-id1="'.$_SESSION['patient_id'].'"
                                                data-id2="'.$row['drug_list_id'].'"
                                                data-id3="'.$_SESSION['name'].'"
                                                data-id4="'.$row_ddisp['price_cash'].'"
                                                data-id5="'.$row['drug_id'].'"
                                                data-id6="'.$row_drug['brand_name'].'"
                                                data-id7="2"
                                                data-id8="'.$row_ddisp['qty'].'"
                                                data-id9="'.$qty_admin.'"
                                                data-id10="'.$qty_returned.'"
                                                >
                                                Drug Return
                                            </a>';
                                };
                        };
                         
                           if ($row_ddisp['qty'] <= 0) 
                        {
                            if ($_SESSION['user_id'] == $row['user_id'] OR $_SESSION['user_type'] == 'Ultra_Super_User') 
                            {
                                if($row['date'] == $date_today)
                                {
                                    if (
                                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Prescription'] == 'Yes')) 
                                    {
                                        $value.='
                                        | <a href="#" id="btn_delete_drug_list" data-id1="'.$row['drug_list_id'].'">Delete</a>';
                                    };
                                };
                            };
                        };

                    $value.='</td>
                    </tr>';
        };
            if (
                $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                $_SESSION['user_type'] == 'Super_User' OR 
                ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
                {
                    $value.='<tr>
                        <td class="action-td" colspan="6">TOTAL</td>
                        <td class="amt-td">'.$total_est.'</td>
                        <td class="amt-td">'.$total_cash.'</td>
                        <td class="amt-td">'.$total_disc.'</td>
                        <td class="amt-td" hidden="true">'.$total_prvt.'</td>
                        <td class="amt-td" hidden="true">'.$total_nhis.'</td>
                        <td class="action-td"></td>
                    </tr>';
                };
    };
        $value.='</tbody>
    </table>';
    echo $value;
}

function drug_bill_status()
{
    global $con;
    $drug_list_id = $_POST['drug_list_id'];
    $bill_status = $_POST['bill_status'];
    
    $query = "UPDATE `drug_list` SET `bill`='$bill_status' WHERE `drug_list_id`='$drug_list_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "drug Updated Successfully";
    }
    else
    {
        echo "drug NOT Updated";
    };
}

function drugs_edit_prescription_qty()
{
    global $con;
    $drug_list_id = $_POST['drug_list_id'];
    $qty_presc = $_POST['qty_presc'];
    
    $query = "UPDATE `drug_list` SET `qty_presc`='$qty_presc' WHERE `drug_list_id`='$drug_list_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        view_current_drug();
    }
    else
    {
        echo "Drug Prescription Qty NOT Updated";
    };
}

function view_drug_history()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Date</th>
                <th>Drug</th>
                <th>Qty Presc.</th>
                <th>Dosage</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">';
    $query = "SELECT * FROM drug_list WHERE patient_id='$patient_id' ORDER BY date DESC";
    $query_run = mysqli_query($con,$query);

    if (mysqli_num_rows($query_run) > 0)
        
            while($row=mysqli_fetch_assoc($query_run))
            {
                $drug_id = $row['drug_id'];
                $query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
                $query_run_drug = mysqli_query($con, $query_drug);
                $row_drug=mysqli_fetch_assoc($query_run_drug);
                
                $drug_list_id = $row['drug_list_id'];
                $query_ddl = "SELECT drug_id FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
                $query_run_ddl = mysqli_query($con, $query_ddl);
                if(mysqli_num_rows($query_run_ddl) > 0)
                {
                    $sup_drugs = '';
                    while($row_ddl=mysqli_fetch_assoc($query_run_ddl))
                    {
                        $drug_id_ddl = $row_ddl['drug_id'];
                        $query_drug_ddl = "SELECT * FROM drugs WHERE drug_id='$drug_id_ddl'";
                        $query_run_drug_ddl = mysqli_query($con, $query_drug_ddl);
                        $row_drug_ddl = mysqli_fetch_assoc($query_run_drug_ddl);
                        $sup_drugs .= $row_drug_ddl['brand_name'].'<br>';
                    };
                }
                else
                {
                    $sup_drugs = 'Not dispensed';
                };

                $value.='<tr>
                            <td><a href="#" id="btn_edit_drug" data-id1="'.$row['drug_list_id'].'">'.$row['date'].'</a></td>
                            <td><strong>'.$row_drug['brand_name'].'</strong><br><small>'.$sup_drugs.'</td>
                            <td>'.$row['qty_presc'].'</td>
                            <td>'.$row['dosage'].'</td>
                        </tr>';
            }
            $value.='</tbody>
                    </table>';
            echo $value;
}

function set_drug_dispense_modal()
{
    global $con;
    $drug_id = $_POST['drug_id'];
    $drug_list_id = $_POST['drug_list_id'];
    $drug_data=array();

    $query = "SELECT SUM(qty) AS total_qty_dispensed FROM drug_dispense_list WHERE drug_list_id='$drug_list_id' AND drug_presc_id='$drug_id'";
    $query_run = mysqli_query($con,$query);
    $row_dc=mysqli_fetch_assoc($query_run);
    $total_qty_dispensed = $row_dc['total_qty_dispensed'];
    array_push($drug_data, $total_qty_dispensed);

    $query = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($drug_data, 
            $row['block_neg'],
            $row['expiry_date'],
            $row['days_prompt'],
            $row['batch']
        );
    }
     echo json_encode($drug_data);
}

function set_substitute_drug_dispense()
{
    global $con;
    $drug_id = $_POST['drug_id'];
    $drug_data=array();
    $query = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($drug_data, 
            $row['gender'],
            $row['age_from'],
            $row['age_to'],
            $row['block_neg'],
            $row['expiry_date'],
            $row['batch'],
            $row['days_prompt']
        );
    }
     echo json_encode($drug_data);
}

function set_drug_price()
{
    global $con;
    $price_list = array();
    if(isset($_POST['sponsor_id']))
    {
        $sponsor_id = $_POST['sponsor_id'];
        $drug_id = $_POST['drug_id'];
        $drug_list_id = $_POST['drug_list_id'];
        
        $query_drug_list = "SELECT * FROM drug_list WHERE drug_list_id ='$drug_list_id'";
        $query_run_drug_list = mysqli_query($con, $query_drug_list);
        $row_drug_list = mysqli_fetch_assoc($query_run_drug_list);
        $cash_price = $row_drug_list['price_est'];

        $query = "SELECT * FROM drugs WHERE drug_id ='$drug_id'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            while($row_cash = mysqli_fetch_assoc($query_run))
            {
                //$cash_price = $row_cash['price_cash'];
                $private_price = $row_cash['price_prvt'];
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
            $query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
            $query_run_nhis = mysqli_query($con, $query_nhis);
            if (mysqli_num_rows($query_run_nhis) > 0)
            {
                while($row_nhis = mysqli_fetch_assoc($query_run_nhis))
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
            $query_pl = "SELECT * FROM price_list WHERE ledger_id='$sponsor_id' AND item_id='$drug_id' AND category_id=2";
            $query_run_pl = mysqli_query($con, $query_pl);
            if (mysqli_num_rows($query_run_pl) > 0)
            {
                while($row_pl = mysqli_fetch_assoc($query_run_pl))
                {
                    //$cash_price1 = "";
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
                        if($private_price > 0)
                        {
                            $price_prvt = $private_price;
                        }
                        else
                        {
                            $price_prvt = $cash_price;
                        };
                    };
                    $price_prvt_topup = $row_pl['price_topup'];
                    $remark = 'private_list';
                }
                array_push($price_list, $cash_price,$price,$price_adult,$price_child,$price_topup,$price_prvt,$price_prvt_topup,$remark);
                echo json_encode($price_list);
            }
            else
            {
                //$cash_price = "";
                $price = "";
                $price_adult = "";
                $price_child = "";
                $price_topup = "";
                if($private_price > 0)
                {
                    $price_prvt = $private_price;
                }
                else
                {
                    $price_prvt = $cash_price;
                };
                //$price_prvt = "";
                $price_prvt_topup = "";
                $remark = 'private_no_list';
                array_push($price_list, $cash_price,$price,$price_adult,$price_child,$price_topup,$price_prvt,$price_prvt_topup,$remark);
                echo json_encode($price_list);
            };
        };
    };
}

function drug_dispense()
{
    global $con;
    $drug_id_disp = $_POST['drug_id_disp'];
    $dosage_disp = $_POST['dosage_disp'];
    $date = $_POST['date_disp'];
    $drug_list_id = $_POST['drug_list_id'];
    $drug_id = $_POST['drug_id'];
    $qty_issue = $_POST['qty_issue'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $comment = $_POST['comment'];
    $batch = $_POST['batch'];
    $sponsor_id = $_POST['ledger'];
    $warehouse = $_POST['warehouse'];
    $price_cash = $_POST['price_cash'];
    $price_nhis = $_POST['price_nhis'];
    $price_prvt = $_POST['price_prvt'];
    $amount_cash = $_POST['amt_cash'];
    $amount_nhis = $_POST['amt_nhis'];
    $amount_prvt = $_POST['amt_prvt'];
    $prvt_led_id = $_POST['ledger'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO `drug_dispense_list`(`company_id`,`drug_list_id`, `drug_presc_id`, 
    `drug_id`, `patient_id`, `attend_id`, `warehouse_id`, `ledger_id`, `date`, `category_id`,
    `dosage`, `qty`, `qty_nhis`, `batch_no`, `price_cash`, `price_prvt`, `price_nhis`, 
    `amt_cash`, `amt_prvt`, `amt_nhis`, `comment`, `user_id`, `created_by`, `created_timestamp`, `branch_id`) 
    VALUES ('$company_id','$drug_list_id',
    '$drug_id','$drug_id_disp','$patient_id','$attend_id','$warehouse','$sponsor_id',
    '$date',2,'$dosage_disp','$qty_issue','$qty_issue','$batch','$price_cash','$price_prvt',
    '$price_nhis','$amount_cash','$amount_prvt','$amount_nhis','$comment','$user_id','$user_id',NOW(),'$branch_id')";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        $query_ddl = "SELECT SUM(qty) AS total_qty_dispensed, MAX(drug_disp_list_id) AS 
        drug_disp_list_id FROM `drug_dispense_list` WHERE `drug_list_id`='$drug_list_id'";
           $query_run_ddl = mysqli_query($con, $query_ddl);
           if (mysqli_num_rows($query_run_ddl) > 0)
        {
            $row_ddl = mysqli_fetch_assoc($query_run_ddl);
            $total_qty_dispensed = $row_ddl['total_qty_dispensed'];
            $drug_disp_list_id = $row_ddl['drug_disp_list_id'];
            if($sponsor_id == 2)
            {
                $query_dl = "UPDATE `drug_list` SET `qty_dispensed`='$total_qty_dispensed', 
                `qty_nhis`='$total_qty_dispensed',`price_cash`='$price_cash',`amount_cash`='$amount_cash' 
                WHERE `drug_list_id`='$drug_list_id' AND `drug_id`='$drug_id'";
            }
            else
            {
                $query_dl = "UPDATE `drug_list` SET `qty_dispensed`='$total_qty_dispensed',
                `price_cash`='$price_cash',`amount_cash`='$amount_cash' WHERE 
                `drug_list_id`='$drug_list_id' AND `drug_id`='$drug_id'";
            };
            
               $query_run_dl = mysqli_query($con, $query_dl);
        };

        //POST TRANSACTION
            $query_trans = "SELECT * FROM `transactions` WHERE `attend_id`='$attend_id' AND 
            `category_id`=2 AND `item_list_id`='$drug_list_id' AND drug_disp_list_id='$drug_disp_list_id'";
            $query_run_trans = mysqli_query($con, $query_trans);
            if (mysqli_num_rows($query_run_trans) > 0)
            {
                $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND 
                `category_id`=2 AND `item_list_id`='$drug_list_id' AND drug_disp_list_id='$drug_disp_list_id'";
                mysqli_query($con, $query_trans_del);
                if ($amount_cash > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES (1,5,
                    '$attend_id','$patient_id',2,'$date','$amount_cash','$amount_cash',0,'$drug_list_id',
                    'drug dispensed for cash','$drug_disp_list_id')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES (5,2,
                    '$attend_id','$patient_id',2,'$date','$amount_cash',0,'$amount_cash','$drug_list_id',
                    'drug dispensed for cash','$drug_disp_list_id')";
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
                                    $item_list_id = $drug_disp_list_id;
                                    $item_id = $_POST['drug_id'];
                                    $category_id = 2;
                                    $qty = $_POST['qty_issue'];
                                    $price = $_POST['price_cash'];
                                    $amount_cash = $_POST['amt_cash'];
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
                    `amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES (
                        '$prvt_led_id',2'$attend_id','$patient_id',2,'$date','$amount_prvt','$amount_prvt',0,
                        '$drug_list_id','drug dispensed for Insurance','$drug_disp_list_id')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES (2,
                    '$prvt_led_id','$attend_id','$patient_id',2,'$date','$amount_prvt',0,'$amount_prvt',
                    '$drug_list_id','drug dispensed for Insurance','$drug_disp_list_id')";
                    mysqli_query($con, $query_cr);
                }
                if ($amount_nhis > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES (2,5,
                    '$attend_id','$patient_id',2,'$date','$amount_nhis','$amount_nhis',0,'$drug_list_id',
                    'drug dispensed for NHIS','$drug_disp_list_id')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES (5,2,
                    '$attend_id','$patient_id',2,'$date','$amount_nhis',0,'$amount_nhis','$drug_list_id',
                    'drug dispensed for NHIS','$drug_disp_list_id')";
                    mysqli_query($con, $query_cr);
                };
            }
            else
            {
                if ($amount_cash > 0)
                {
                    //POST TRANSACTION
                        $query_dr = "INSERT INTO `transactions`(
                        `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                        `amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES (1,5,
                        '$attend_id','$patient_id',2,'$date','$amount_cash','$amount_cash',0,'$drug_list_id',
                        'drug dispensed for cash','$drug_disp_list_id')";
                        mysqli_query($con, $query_dr);
                        
                        $query_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                        `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
                        `narration`, `drug_disp_list_id`) VALUES (5,1,'$attend_id','$patient_id',2,'$date',
                        '$amount_cash',0,'$amount_cash','$drug_list_id','drug dispensed for cash',
                        '$drug_disp_list_id')";
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
                                    $item_list_id = $drug_disp_list_id;
                                    $item_id = $_POST['drug_id'];
                                    $category_id = 2;
                                    $qty = $_POST['qty_issue'];
                                    $price = $_POST['price_cash'];
                                    $amount_cash = $_POST['amt_cash'];
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
                    `amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES (
                        '$prvt_led_id',5,'$attend_id','$patient_id',2,'$date','$amount_prvt','$amount_prvt',0,
                        '$drug_list_id','drug dispensed for Insurance','$drug_disp_list_id')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES (5,
                    '$prvt_led_id','$attend_id','$patient_id',2,'$date','$amount_prvt',0,'$amount_prvt',
                    '$drug_list_id','drug dispensed for Insurance','$drug_disp_list_id')";
                    mysqli_query($con, $query_cr);
                }
                if ($amount_nhis > 0)
                {
                    $query_dr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES (2,5,
                    '$attend_id','$patient_id',2,'$date','$amount_nhis','$amount_nhis',0,'$drug_list_id',
                    'drug dispensed for NHIS','$drug_disp_list_id')";
                    mysqli_query($con, $query_dr);

                    $query_cr = "INSERT INTO `transactions`(
                    `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                    `amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES (5,2,
                    '$attend_id','$patient_id',2,'$date','$amount_nhis',0,'$amount_nhis','$drug_list_id',
                    'drug dispensed for NHIS','$drug_disp_list_id')";
                    mysqli_query($con, $query_cr);
                };
            };
    }
    else
    {
        echo "Drug NOT Dispensed";
    };
}

function view_drug_dispensed_list()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $drug_id = $_POST['drug_id'];
    $drug_list_id = $_POST['drug_list_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Date</th>
                <th>Drug</th>
                <th>Qty Disp.</th>
                <th>Dosage</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">';
    $query = "SELECT * FROM drug_dispense_list WHERE attend_id='$attend_id' AND patient_id='$patient_id' AND drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id' ORDER BY date DESC";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $drug_id = $row['drug_id'];
            $query = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
            $query_run_drug = mysqli_query($con, $query);
            $row_drug=mysqli_fetch_assoc($query_run_drug);

            $warehouse_id = $row['warehouse_id'];
            $query_wh = "SELECT * FROM warehouse WHERE warehouse_id='$warehouse_id'";
            $query_run_wh = mysqli_query($con, $query_wh);
            $row_wh=mysqli_fetch_assoc($query_run_wh);
            if(isset($row_wh)){$warehouse = $row_wh['warehouse_desc'];}else{$warehouse = 'N/A';};

            $value.='<tr>
                        <td>'.$row['date'].'</td>
                        <td>'.$row_drug['brand_name'].'</td>
                        <td>'.$row['qty'].'</td>
                        <td>'.$row['dosage'].'</td>
                        <td>'.$warehouse.'</td>';

               $value.='<td>';
                               /*if (
                            $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                            $_SESSION['user_type'] == 'Super_User' OR 
                            ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Dispensed_Presc'] == 'Yes')) 
                            {
                                $value.='
                                 <a href="#" id="btn_edit_drug_disp_list" data-id1="'.$row['drug_disp_list_id'].'">Edit</a> | ';
                            };*/

                            if (
                            $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                            $_SESSION['user_type'] == 'Super_User' OR 
                            ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Dispensed_Presc'] == 'Yes')) 
                            {
                                $value.='<a href="#" id="btn_delete_drug_disp_list" data-id="'.$row['drug_list_id'].'" data-id1="'.$row['drug_disp_list_id'].'">Delete</a>';
                            };
               $value.='</td>
                    </tr>';
        }
    }
        $value.='</tbody>
    </table>';
    echo $value;
}

function delete_drug_dispensed()
{
    global $con;
    $drug_disp_list_id = $_POST['drug_disp_list_id'];
    $drug_list_id = $_POST['drug_list_id'];
    $attend_id = $_POST['attend_id'];
    $query = "DELETE FROM `drug_dispense_list` WHERE drug_disp_list_id='$drug_disp_list_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=2 AND `item_list_id`='$drug_list_id' AND drug_disp_list_id='$drug_disp_list_id'";
        mysqli_query($con, $query_trans_del);
    }
    else
    {
        echo "Drug NOT Deleted";
    };
}

function view_drug_patient_return()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Date</th>
                <th>Drug</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Amount</th>
                <th>Batch</th>
                <th>Warehouse</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">';
    $query = "SELECT * FROM drug_patient_returns WHERE attend_id='$attend_id' ORDER BY date DESC";
    $query_run = mysqli_query($con,$query);

    if (mysqli_num_rows($query_run) > 0)
        
            while($row=mysqli_fetch_assoc($query_run))
            {
                $drug_id = $row['drug_id'];
                $query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
                $query_run_drug = mysqli_query($con, $query_drug);
                $row_drug=mysqli_fetch_assoc($query_run_drug);

                $warehouse_id = $row['warehouse_id'];
                $query_wh = "SELECT * FROM warehouse WHERE warehouse_id='$warehouse_id'";
                $query_run_wh = mysqli_query($con, $query_wh);
                $row_wh = mysqli_fetch_assoc($query_run_wh);
    
                $value.='<tr>
                            <td><a href="#" id="btn_edit_drug_patient_return" data-id="'.$row['drug_pat_return_id'].'">'.$row['date'].'</a></td>
                            <td>'.$row_drug['brand_name'].'</td>
                            <td>'.$row['qty'].'</td>
                            <td>'.$row['price'].'</td>
                            <td>'.$row['amount'].'</td>
                            <td>'.$row['batch_no'].'</td>
                            <td>'.$row_wh['warehouse_desc'].'</td>
                            <td><a href="#" id="btn_delete_drug_patient_return" data-id="'.$row['drug_pat_return_id'].'"><i class="fa fa-trash fa-sm"></i></a></td>
                        </tr>';
            }
            $value.='</tbody>
                    </table>';
            echo $value;
}

function save_drug_patient_return()
{
    global $con;
    $drug_id = $_POST['dpr_drug_id'];
    $drug_list_id = $_POST['dpr_drug_list_id'];
    $dpr_category = $_POST['dpr_category'];
    $dpr_warehouse_id = $_POST['dpr_warehouse_id'];
    $dpr_date = $_POST['dpr_date'];
    $dpr_batch_no = $_POST['dpr_batch_no'];
    $dpr_expiry_date = $_POST['dpr_expiry_date'];
    $dpr_qty = $_POST['dpr_qty'];
    $dpr_price = $_POST['dpr_price'];
    $dpr_amount = $_POST['dpr_amount'];
    $dpr_narration = $_POST['dpr_narration'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO `drug_patient_returns`(`attend_id`, `patient_id`, `drug_id`, 
    `drug_list_id`, `company_id`, `qty`, `date`, `price`, `amount`, `batch_no`, 
    `expiry_date`, `warehouse_id`, `narration`, `category_id`, `user_id`, `created_by`, 
    `created_datetime`) VALUES ('$attend_id',
    '$patient_id','$drug_id','$drug_list_id','$company_id','$dpr_qty','$dpr_date',
    '$dpr_price','$dpr_amount','$dpr_batch_no','$dpr_expiry_date','$dpr_warehouse_id',
    '$dpr_narration','$dpr_category','$user_id','$user_id',NOW())";
    $result = mysqli_query($con,$query);
}

function edit_drug_patient_return()
{
    global $con;
    $drug_pat_return_id = $_POST['drug_pat_return_id'];
    $Drug_List_Data = array();

    $query = "SELECT * FROM drug_patient_returns WHERE drug_pat_return_id ='$drug_pat_return_id'";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_assoc($result))
    {
        $drug_list_id = $row['drug_list_id'];
        $drug_id = $row['drug_id'];
        $query_ddisp = "SELECT SUM(amt_cash) AS amt_cash,MAX(price_cash) AS price_cash, SUM(amt_prvt) AS amt_prvt, SUM(amt_nhis) AS amt_nhis, SUM(qty) AS qty FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
        $query_run_ddisp = mysqli_query($con, $query_ddisp);
        $row_ddisp=mysqli_fetch_assoc($query_run_ddisp);

        $query_dadmin = "SELECT SUM(qty_admin) AS qty_admin FROM  drug_admin WHERE drug_id='$drug_id' AND drug_list_id='$drug_list_id'";
        $query_run_dadmin = mysqli_query($con, $query_dadmin);
        if(isset($query_run_dadmin))
        {
            $row_dadmin = mysqli_fetch_assoc($query_run_dadmin);
            $qty_admin = $row_dadmin['qty_admin'];
        }
        else
        {
            $qty_admin = 0;
        };

        $query_returned = "SELECT SUM(qty) AS qty_returned FROM  drug_patient_returns WHERE drug_id='$drug_id' AND drug_list_id='$drug_list_id'";
        $query_run_returned = mysqli_query($con, $query_returned);
        if(isset($query_run_returned))
        {
            $row_returned = mysqli_fetch_assoc($query_run_returned);
            $qty_returned = $row_returned['qty_returned'];
        }
        else
        {
            $qty_returned = 0;
        };

        array_push($Drug_List_Data, 
            $row['drug_pat_return_id'],
            $row['drug_id'],
            $row['drug_list_id'],
            $row['qty'],
            $row['price'],
            $row['amount'],
            $row['date'],
            $row['batch_no'],
            $row['expiry_date'],
            $row['warehouse_id'],
            $row['narration'],
            $row['category_id'],
            $row_ddisp['qty'],
            $qty_admin,
            $qty_returned
        );
    }
     echo json_encode($Drug_List_Data);
}

function update_drug_patient_return()
{
    global $con;
    $drug_pat_return_id = $_POST['drug_pat_return_id'];
    $drug_id = $_POST['dpr_drug_id'];
    $drug_list_id = $_POST['dpr_drug_list_id'];
    $dpr_category = $_POST['dpr_category'];
    $dpr_warehouse_id = $_POST['dpr_warehouse_id'];
    $dpr_date = $_POST['dpr_date'];
    $dpr_batch_no = $_POST['dpr_batch_no'];
    $dpr_expiry_date = $_POST['dpr_expiry_date'];
    $dpr_qty = $_POST['dpr_qty'];
    $dpr_price = $_POST['dpr_price'];
    $dpr_amount = $_POST['dpr_amount'];
    $dpr_narration = $_POST['dpr_narration'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `drug_patient_returns` SET `qty`='$dpr_qty', `date`='$dpr_date', 
    `price`='$dpr_price', `amount`='$dpr_amount', `batch_no`='$dpr_batch_no', 
    `expiry_date`='$dpr_expiry_date', `warehouse_id`= '$dpr_warehouse_id', 
    `narration`= '$dpr_narration',`altered_by`= '$user_id',`altered_datetime`= NOW()
    WHERE `drug_pat_return_id` = '$drug_pat_return_id'";
    $result = mysqli_query($con,$query);
}

function drug_admin_save()
{
    global $con;
    $drug_id = $_POST['drug_id'];
    $drug_list_id = $_POST['drug_list_id'];
    $route = $_POST['route'];
    $qty_admin = $_POST['qty_admin'];
    $initials = $_POST['initials'];
    $comment = $_POST['comment'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $user_id = $_SESSION['user_id'];
    $query = "INSERT INTO `drug_admin`(`attend_id`, `patient_id`, `drug_id`, 
    `drug_list_id`, `route_id`, `initials`, `comment`, `date`, `qty_admin`, 
    `time`,`user_id`,`created_by`,`created_datetime`) VALUES ('$attend_id','$patient_id','$drug_id',
    '$drug_list_id','$route','$initials','$comment','$date','$qty_admin',
    '$time','$user_id','$user_id',NOW())";
    $result = mysqli_query($con,$query);
}

function drug_admin_view()
{
    global $con;
    if(isset($_POST['drug_id']))
    {
        $drug_id = $_POST['drug_id'];
        $drug_list_id = $_POST['drug_list_id'];
        $value = "";
        $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Route</th>
                    <th>Qty Admin</th>
                    <th>Initials</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="pv-table-body">';
        $query = "SELECT * FROM drug_admin WHERE drug_list_id='$drug_list_id' ORDER BY date DESC, time DESC";
        $result = mysqli_query($con,$query);

        while($row=mysqli_fetch_assoc($result))
        {
            $route_id = $row['route_id'];
            $query = "SELECT * FROM drug_route WHERE route_id=$route_id";
            $query_run_route = mysqli_query($con, $query);
            $row_route=mysqli_fetch_assoc($query_run_route);
            $value.='<tr>
                        <td><a href="#" id="btn_edit_drug_admin" data-id1="'.$row['drug_admin_id'].'">'.$row['date'].'</a></td>
                        <td>'.$row['time'].'</td>
                        <td>'.$row_route['route'].'</td>
                        <td>'.$row['qty_admin'].'</td>
                        <td>'.$row['initials'].'</td>
                        <td>'.$row['comment'].'</td>
                        <td>';
                        
                    if ($_SESSION['user_id'] == $row['user_id']) 
                    {
                        if($row['date'] == $date_today)
                        {
                            if (
                                $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                $_SESSION['user_type'] == 'Super_User' OR 
                                ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Drug_admin'] == 'Yes')) 
                            {
                                $value.='<a href="#" id="btn_delete_drug_admin" data-id="'.$row['drug_admin_id'].'">Delete</a>';
                            };
                        };
                    };
                            
                            $value.='</td>
                    </tr>';
        }
        $value.='</tbody>
                </table>';
        echo $value;
    };
}

function drug_prescription()
{
    global $con;
    $_SESSION['attend_id'] = $_POST['attend_id'];
    $_SESSION['patient_id'] = $_POST['patient_id'];
}

function drug_admin_chart()
{
    global $con;
    $_SESSION['attend_id'] = $_POST['attend_id'];
    $_SESSION['patient_id'] = $_POST['patient_id'];
    /*$attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                <thead>
                    <tr style="background-color:#544f4d; color:white">
                        <th width="10%">Date</th>
                        <th width="10%">Time</th>
                        <th width="10%">Route</th>
                        <th width="10%">Dosage</th>
                        <th width="10%">Qty Admin</th>
                        <th width="30%">Drug</th>
                        <th width="10%">Admin By</th>
                        <th width="10%">Comment</th>
                    </tr>	
                </thead>
                <tbody class="pv-table-body">
                    <tr style="background-color:#E4E1E0">
                        <td colspan="8">
                            <strong>STAT</strong>
                        </td>
                    </tr>';

                    $query = "
                            SELECT * FROM drug_admin AS da 
                            JOIN drug_list AS dl 
                            ON da.drug_list_id=dl.drug_list_id
                            WHERE da.attend_id='$attend_id' 
                            AND dl.dosage LIKE '%st%' ORDER BY da.date DESC, da.time DESC";

                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row_drug_admin_stat=mysqli_fetch_assoc($query_run))
                        {
                            $drug_id = $row_drug_admin_stat['drug_id'];
                            $drug_list_id = $row_drug_admin_stat['drug_list_id'];
                            $route_id = $row_drug_admin_stat['route_id'];

                            $query = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
                            $query_run_drug = mysqli_query($con, $query);
                            $row_drug=mysqli_fetch_assoc($query_run_drug);
                            $drug = $row_drug['brand_name'];

                            $query = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
                            $query_run_drug_list = mysqli_query($con, $query);
                            $row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
                            $dosage = $row_drug_list['dosage'];

                            $query_ddl = "SELECT drug_id FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
                            $query_run_ddl = mysqli_query($con, $query_ddl);
                            if(mysqli_num_rows($query_run_ddl) > 0)
                            {
                                $sup_drugs = '';
                                while($row_ddl=mysqli_fetch_assoc($query_run_ddl))
                                {
                                    $drug_id_ddl = $row_ddl['drug_id'];
                                    $query_drug_ddl = "SELECT * FROM drugs WHERE drug_id='$drug_id_ddl'";
                                    $query_run_drug_ddl = mysqli_query($con, $query_drug_ddl);
                                    $row_drug_ddl = mysqli_fetch_assoc($query_run_drug_ddl);
                                    $sup_drugs .= $row_drug_ddl['brand_name'].'<br>';
                                };
                            }
                            else
                            {
                                $sup_drugs = 'Not dispensed';
                            };
                            $query = "SELECT * FROM drug_route WHERE route_id='$route_id'";
                            $query_run_route = mysqli_query($con, $query);
                            $row_route=mysqli_fetch_assoc($query_run_route);
                            $route = $row_route['route'];

                            $value.='
                                    <tr>
                                        <td>
                                            '.$row_drug_admin_stat['date'].'
                                        </td>
                                        <td>
                                            '.$row_drug_admin_stat['time'].'
                                        </td>
                                        <td>
                                            '.$route.'
                                        </td>
                                        <td>
                                            '.$dosage.'
                                        </td>
                                        <td>
                                            '.$row_drug_admin_stat['qty_admin'].'
                                        </td>
                                        <td>
                                            <strong>'.$drug.'</strong><br><small>'.$sup_drugs.'</small>
                                        </td>
                                        <td>
                                            '.$row_drug_admin_stat['initials'].'
                                        </td>
                                        <td>
                                            '.$row_drug_admin_stat['comment'].'
                                        </td>
                                    </tr>';
                        }
                    }
                    else
                    {
                        $value.='
                                <tr>
                                    <td>
                                    </td>
                                </tr>';
                    };
                    $value.='<tr style="background-color:#E4E1E0">
                                <td colspan="8">
                                    <strong>INFUSIONS</strong>
                                </td>
                            </tr>';
                    $query = "
                            SELECT * FROM drug_admin AS da 
                            JOIN drugs AS ds 
                            ON da.drug_id=ds.drug_id
                            WHERE da.attend_id='$attend_id' 
                            AND ds.category=3 ORDER BY ds.brand_name ASC, da.date DESC, da.time DESC";

                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row_drug_admin_stat=mysqli_fetch_assoc($query_run))
                        {
                            $drug_id = $row_drug_admin_stat['drug_id'];
                            $drug_list_id = $row_drug_admin_stat['drug_list_id'];
                            $route_id = $row_drug_admin_stat['route_id'];

                            $query = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
                            $query_run_drug = mysqli_query($con, $query);
                            $row_drug=mysqli_fetch_assoc($query_run_drug);
                            $drug = $row_drug['brand_name'];

                            $query = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
                            $query_run_drug_list = mysqli_query($con, $query);
                            $row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
                            $dosage = $row_drug_list['dosage'];

                            $query_ddl = "SELECT drug_id FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
                            $query_run_ddl = mysqli_query($con, $query_ddl);
                            if(mysqli_num_rows($query_run_ddl) > 0)
                            {
                                $sup_drugs = '';
                                while($row_ddl=mysqli_fetch_assoc($query_run_ddl))
                                {
                                    $drug_id_ddl = $row_ddl['drug_id'];
                                    $query_drug_ddl = "SELECT * FROM drugs WHERE drug_id='$drug_id_ddl'";
                                    $query_run_drug_ddl = mysqli_query($con, $query_drug_ddl);
                                    $row_drug_ddl = mysqli_fetch_assoc($query_run_drug_ddl);
                                    $sup_drugs .= $row_drug_ddl['brand_name'].'<br>';
                                };
                            }
                            else
                            {
                                $sup_drugs = 'Not dispensed';
                            };

                            $query = "SELECT * FROM drug_route WHERE route_id='$route_id'";
                            $query_run_route = mysqli_query($con, $query);
                            $row_route=mysqli_fetch_assoc($query_run_route);
                            $route = $row_route['route'];

                            $value.='
                                    <tr>
                                        <td>
                                            '.$row_drug_admin_stat['date'].'
                                        </td>
                                        <td>
                                            '.$row_drug_admin_stat['time'].'
                                        </td>
                                        <td>
                                            '.$route.'
                                        </td>
                                        <td>
                                            '.$dosage.'
                                        </td>
                                        <td>
                                            '.$row_drug_admin_stat['qty_admin'].'
                                        </td>
                                        <td>
                                            <strong>'.$drug.'</strong><br><small>'.$sup_drugs.'</small>
                                        </td>
                                        <td>
                                            '.$row_drug_admin_stat['initials'].'
                                        </td>
                                        <td>
                                            '.$row_drug_admin_stat['comment'].'
                                        </td>
                                    </tr>';
                        }
                    }else
                    {
                        $value.='
                                <tr>
                                    <td>
                                    </td>
                                </tr>';
                    };
                    $value.='<tr style="background-color:#E4E1E0">
                                <td colspan="8">
                                    <strong>OTHERS</strong>
                                </td>
                            </tr>';
                    $query = "
                            SELECT * FROM drug_admin AS da 
                            JOIN drugs AS ds 
                            ON da.drug_id=ds.drug_id
                            WHERE da.attend_id='$attend_id' 
                            AND ds.category<>3 ORDER BY ds.brand_name ASC, da.date DESC, da.time DESC";

                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row_drug_admin_stat=mysqli_fetch_assoc($query_run))
                        {
                            $drug_id = $row_drug_admin_stat['drug_id'];
                            $drug_list_id = $row_drug_admin_stat['drug_list_id'];
                            $route_id = $row_drug_admin_stat['route_id'];

                            $query = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
                            $query_run_drug = mysqli_query($con, $query);
                            $row_drug=mysqli_fetch_assoc($query_run_drug);
                            $drug = $row_drug['brand_name'];

                            $query = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
                            $query_run_drug_list = mysqli_query($con, $query);
                            $row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
                            $dosage = $row_drug_list['dosage'];

                            $query_ddl = "SELECT drug_id FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
                            $query_run_ddl = mysqli_query($con, $query_ddl);
                            if(mysqli_num_rows($query_run_ddl) > 0)
                            {
                                $sup_drugs = '';
                                while($row_ddl=mysqli_fetch_assoc($query_run_ddl))
                                {
                                    $drug_id_ddl = $row_ddl['drug_id'];
                                    $query_drug_ddl = "SELECT * FROM drugs WHERE drug_id='$drug_id_ddl'";
                                    $query_run_drug_ddl = mysqli_query($con, $query_drug_ddl);
                                    $row_drug_ddl = mysqli_fetch_assoc($query_run_drug_ddl);
                                    $sup_drugs .= $row_drug_ddl['brand_name'].'<br>';
                                };
                            }
                            else
                            {
                                $sup_drugs = 'Not dispensed';
                            };

                            $query = "SELECT * FROM drug_route WHERE route_id='$route_id'";
                            $query_run_route = mysqli_query($con, $query);
                            $row_route=mysqli_fetch_assoc($query_run_route);
                            $route = $row_route['route'];

                            $value.='
                                    <tr>
                                        <td>
                                            '.$row_drug_admin_stat['date'].'
                                        </td>
                                        <td>
                                            '.$row_drug_admin_stat['time'].'
                                        </td>
                                        <td>
                                            '.$route.'
                                        </td>
                                        <td>
                                            '.$dosage.'
                                        </td>
                                        <td>
                                            '.$row_drug_admin_stat['qty_admin'].'
                                        </td>
                                        <td>
                                            <strong>'.$drug.'</strong><br><small>'.$sup_drugs.'</small>
                                        </td>
                                        <td>
                                            '.$row_drug_admin_stat['initials'].'
                                        </td>
                                        <td>
                                            '.$row_drug_admin_stat['comment'].'
                                        </td>
                                    </tr>';
                        }
                    }
                    else
                    {
                        $value.='
                                <tr>
                                    <td>
                                    </td>
                                </tr>';
                    };
        $value.='</tbody>
            </table>';
        echo $value;*/
}

function drug_admin_delete()
{
    global $con;
    $drug_admin_id = $_POST['drug_admin_id'];
    $query = "DELETE FROM `drug_admin` WHERE drug_admin_id='$drug_admin_id'";
    $query_run = mysqli_query($con, $query);
}

function delete_drug_attend()
{
    global $con;
    $drug_list_id = $_POST['drug_list_id'];
    $attend_id = $_POST['attend_id'];
    $query = "DELETE FROM `drug_list` WHERE drug_list_id='$drug_list_id'";
    $query_run = mysqli_query($con, $query);
    /*if ($query_run)
    {
        $query_ddl_del = "DELETE FROM `drug_dispense_list` WHERE `drug_list_id`='$drug_list_id'";
        mysqli_query($con, $query_ddl_del);

        $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=2 AND `item_list_id`='$drug_list_id'";
        mysqli_query($con, $query_trans_del);
    }
    else
    {
        echo "Drug NOT Deleted";
    };*/
}

function drug_mur_modal()
{
    global $con;
    $Qlist=array();
    $patient_id = $_POST['patient_id'];
    $attend_id = $_POST['attend_id'];
    $drug_id = $_POST['drug_id'];
    $drug_list_id = $_POST['drug_list_id'];
    $query = "SELECT * FROM drug_list WHERE drug_list_id ='$drug_list_id'";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            array_push($Qlist, 
                $row['drug_id'],$row['drug_list_id'],
                $row['Q1'],$row['Q2'],$row['Q3'],$row['Q4'],$row['Q5'],$row['Q6'],$row['Q7'],$row['Q8'],$row['Q9'],$row['Q10'],
                $row['Q11'],$row['Q12'],$row['Q13'],$row['Q14'],$row['Q15'],$row['Q16'],$row['Q17'],$row['Q18'],$row['Q19'],$row['Q20'],$row['Q21']
            );
        }
         echo json_encode($Qlist);
    }
}

function drug_mur_save()
{
    global $con;
    $drug_list_id = $_POST['mur_drug_list_id'];
    $drug_id = $_POST['mur_drug_id'];
    $attend_id = $_POST['mur_attend_id'];
    $date = $_POST['mur_date'];
    $mur_q_1 = $_POST['mur_q_1'];
    $mur_q_2 = $_POST['mur_q_2'];
    $mur_q_3 = $_POST['mur_q_3'];
    $mur_q_4 = $_POST['mur_q_4'];
    $mur_q_5 = $_POST['mur_q_5'];
    $mur_q_6 = $_POST['mur_q_6'];
    $mur_q_7 = $_POST['mur_q_7'];
    $mur_q_8 = $_POST['mur_q_8'];
    $mur_q_9 = $_POST['mur_q_9'];
    $mur_q_10 = $_POST['mur_q_10'];
    $mur_q_11 = $_POST['mur_q_11'];
    $mur_q_12 = $_POST['mur_q_12'];
    $mur_q_13 = $_POST['mur_q_13'];
    $mur_q_14 = $_POST['mur_q_14'];
    $mur_q_15 = $_POST['mur_q_15'];
    $mur_q_16 = $_POST['mur_q_16'];
    $mur_q_17 = $_POST['mur_q_17'];
    $mur_q_18 = $_POST['mur_q_18'];
    $mur_q_19 = $_POST['mur_q_19'];
    $mur_q_20 = $_POST['mur_q_20'];
    $mur_q_21 = $_POST['mur_q_21'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `drug_list` SET `mur_attend_id`='$attend_id',`mur_date`='$date',
    `Q1`='$mur_q_1',`Q2`='$mur_q_2',`Q3`='$mur_q_3',`Q4`='$mur_q_4',`Q5`='$mur_q_5',`Q6`='$mur_q_6',
    `Q7`='$mur_q_7',`Q8`='$mur_q_8',`Q9`='$mur_q_9',`Q10`='$mur_q_10',`Q11`='$mur_q_11',
    `Q12`='$mur_q_12',`Q13`='$mur_q_13',`Q14`='$mur_q_14',`Q15`='$mur_q_15',`Q16`='$mur_q_16',
    `Q17`='$mur_q_17',`Q18`='$mur_q_18',`Q19`='$mur_q_19',`Q20`='$mur_q_20',`Q21`='$mur_q_21',
    `crested_mur_by`='$user_id',`created_mur_datetime`=NOW() WHERE `drug_list_id`='$drug_list_id'";

    $result = mysqli_query($con,$query);
}

function drug_label_modal()
{
    global $con;
    $Label = array();
    $drug_list_id = $_POST['drug_list_id'];
    $query = "SELECT * FROM drug_list WHERE drug_list_id ='$drug_list_id'";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            array_push($Label, 
                $row['label'],$row['drug_list_id'],$row['label_by']
            );
        }
         echo json_encode($Label);
    }
}

function drug_label_search()
{
    global $con;
    $input = $_POST['input'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Label</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT label FROM drug_label WHERE label LIKE '%".$input."%'";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $value.='<tr>
                        <td><a href="#" id="btn_drug_label_list" data-id="'.$row['label'].'">'.$row['label'].'</a></td>
                    </tr>';
        }
    }
    else
    {
        $value.='<tr>
                    <td>No label Found</td>
                </tr>';
    }
        $value.='</tbody>
            </table>';
    echo $value;
}

function drug_label_save()
{
    global $con;
    $label_drug_id = $_POST['label_drug_id'];
    $label_drug_list_id = $_POST['label_drug_list_id'];
    $label_view = $_POST['label_view'];
    $label_dispensed_by = $_POST['label_dispensed_by'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `drug_list` SET `label`='$label_view',
    `label_by`='$label_dispensed_by',`created_label_by`='$user_id',`created_label_datetime`=NOW() 
    WHERE `drug_list_id`='$label_drug_list_id'";
    $result = mysqli_query($con,$query);
    if (isset($result)) 
    {
        $_SESSION['label_drug_id'] = $label_drug_id;
        $_SESSION['label_drug_list_id'] = $label_drug_list_id;
    };
}

function search_drug_attend()
{
    global $con;
    $search = $_POST['search'];
    $sponsor_id = $_POST['sponsor_id'];
    $age = $_POST['age'];
    $price_topup_nhis = 0;
    $price_nhis = 0;
    $private_price = 0;
    $private_price_top = 0;
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Drug</th>
                        <th class="action-td">Dosage</th>
                        <th class="action-td">Qty</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    if(isset($_POST["search"]))
    {
        $query = "SELECT *  FROM `drugs` WHERE `brand_name` LIKE '%".$search."%'";
        $query_run = mysqli_query($con,$query);
        if (mysqli_num_rows($query_run) > 0)
        {
            while($row = mysqli_fetch_assoc($query_run))
            {
                $drug_id = $row['drug_id'];
                if($sponsor_id !=1 && $sponsor_id !=2)
                {
                    $query_pl = "SELECT * FROM price_list WHERE ledger_id='$sponsor_id' AND item_id='$drug_id' AND category_id=2";
                    $query_run_pl = mysqli_query($con, $query_pl);
                    if (mysqli_num_rows($query_run_pl) > 0)
                    {
                        while($row_pl = mysqli_fetch_assoc($query_run_pl))
                        {
                            $private_price = $row_pl['price'];
                            $private_price_top = $row_pl['price_topup'];
                            $price_topup_nhis = 0;
                            $price_nhis = 0;
                        };
                    }
                    else
                    {
                        $private_price = $row['price_prvt'];
                        $private_price_top = 0;
                        $price_topup_nhis = 0;
                        $price_nhis = 0;
                    };
                }
                else if($sponsor_id == 2)
                {
                    if(isset($row['nhis_id']))
                    {
                        $nhis_id = $row['nhis_id'];
                        $query_nhis = "SELECT * FROM nhis WHERE nhis_id ='$nhis_id'";
                        $query_run_nhis = mysqli_query($con, $query_nhis);
                        if(isset($query_run_nhis))
                        {
                            $row_nhis = mysqli_fetch_assoc($query_run_nhis);
                            if(isset($row_nhis['price_topup']))
                            {
                                $price_topup_nhis = $row_nhis['price_topup'];
                            }
                            else
                            {
                                $price_topup_nhis = 0;
                            };
                            if(isset($row_nhis['price']))
                            {
                                $price_nhis = $row_nhis['price'];
                            }
                            else
                            {
                                $price_nhis = 0;
                            };
                        }
                        else
                        {
                            $price_topup_nhis = 0;
                            $price_nhis = 0;
                        };
                            $private_price = 0;
                            $private_price_top = 0;
                    };
                };
                $value.='
                        <tr>
                            <td>
                                <a href="#" id="btn_save_drug_search_item" 
                                    data-id="'.$row['drug_id'].'"
                                    data-id1="'.$row['gender'].'"
                                    data-id2="'.$row['age_from'].'"
                                    data-id3="'.$row['age_to'].'"
                                    data-id4="'.$row['price_cash'].'"
                                    data-id5="'.$private_price.'"
                                    data-id6="'.$private_price_top.'"
                                    data-id7="'.$sponsor_id.'"
                                    data-id8="'.$price_nhis.'"
                                    data-id9="'.$price_topup_nhis.'"
                                >'.$row['brand_name'].'</a></td>
                            <td class="action-td"><input type="text" name="drug_search_dosage" class="form-control" id="drug_search_dosage"></td>
                            <td class="action-td"><input type="text" name="drug_search_qty" class="form-control" id="drug_search_qty"></td>
                        </tr>';
            };
        };
    
    };
    $value.='</tbody>
            </table>';
    echo $value;
}

?>
