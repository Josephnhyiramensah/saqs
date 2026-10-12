<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//PAYMENT
function payment_dr_list()
{
    global $con;
    $count = $_POST['i'];
    $company_id = $_POST['company_id'];
    $value = "";
    $value = '<td>
                <input type="hidden" name="payment_dr_id[]" class="form-control bg-light" id="payment_dr_id'.$count.'">
                <select class="form-control payment_led_dr bg-light" name="payment_led_dr[]" id="payment_led_dr'.$count.'" data-id="'.$count.'" style="border-width:0px"> 
                    <option value="0">Please Select</option>';

                        $sql="SELECT * FROM ledgers WHERE (/*company_id = '$company_id' AND*/ tb_2 !=3 AND tb_4 !=6) OR (default_status = 'Yes' AND tb_4 !=10 AND tb_4 !=6) ORDER BY ledger_desc ASC";
                        $result = mysqli_query($con,$sql);
                        while($row = mysqli_fetch_array($result))
                        {
                            $value .= '<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
                        };
        $value .= '</select>
            </td>
            <td class = "action-td">
                <input type="text" name="payment_dr_amt[]" class="form-control bg-light payment_dr_amt amt-td" id="payment_dr_amt'.$count.'" data-id="'.$count.'" style="border-width:0px">
            </td>
            <td class = "action-td">
                <input type="text" name="payment_dr_narration[]" class="form-control bg-light payment_dr_narration" id="payment_dr_narration'.$count.'" data-id="'.$count.'" style="border-width:0px">
            </td>
            <td class = "action-td">
                <a href="#" id="delete_payment_dr" data-id="'.$count.'"><i class="fa fa-trash fa-sm"></i></a>
            </td>';

    echo $value;
}

function save_payment()
{
    global $con;
    $payment_id = $_POST['payment_id'];
    $user_id = $_POST['user_id'];
    $user_super_id = $_POST['user_super_id'];
    $payment_credit_ledger = $_POST['payment_credit_ledger'];
    $payment_ref = $_POST['payment_ref'];
    $payment_date = $_POST['payment_date'];
    $payment_amount = $_POST['payment_amount'];
    $payment_mode = $_POST['payment_mode'];
    $payment_inst_no = $_POST['payment_inst_no'];
    $payment_bank = $_POST['payment_bank'];
    $payment_branch = $_POST['payment_branch'];
    $payment_payee = $_POST['payment_payee'];
    $payment_narration = $_POST['payment_narration'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $branch_id = $_SESSION['branch_id'];

    $query_last_sno = "SELECT `sno` FROM `payment` WHERE `company_id` = '$company_id' ORDER BY `sno` DESC";
    $result_last_sno = mysqli_query($con,$query_last_sno);
    if(!empty($result_last_sno) && mysqli_num_rows($result_last_sno) > 0)
    {
        $row_last_sno = mysqli_fetch_assoc($result_last_sno);
        $last_sno = $row_last_sno['sno'];
        $next_sno = $last_sno + 1;
    }
    else
    {
        $next_sno = 1;
    };

    $query = "INSERT INTO `payment`(
    `sno`,`company_id`, `user_id`, `user_super_id`, `ledger_credit`, `date`, `amount`, `narration`, 
    `reference_no`, `mode`, `bank`, `branch`, `inst_no`, `payee`, `branch_id`, `created_by`, `created_time`) VALUES (
    '$next_sno','$company_id','$user_id','$user_super_id','$payment_credit_ledger','$payment_date',
    '$payment_amount','$payment_narration','$payment_ref','$payment_mode','$payment_bank',
    '$payment_branch','$payment_inst_no','$payment_payee','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);
    if ($query_run) 
    {
        //POST TRANSACTION
            $query = "SELECT * FROM payment WHERE `company_id`='$company_id' ORDER BY payment_id DESC";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_assoc($result);
            $payment_id = $row['payment_id'];

            //PAYMENT_ITEMS
                $number_as = count($_POST["payment_led_dr"]);  
                if($number_as > 0)  
                {  
                    for($i=0; $i<$number_as; $i++)  
                    {  
                        if(trim($_POST["payment_led_dr"][$i] != ''))
                        {  
                            $payment_led_dr = $_POST['payment_led_dr'][$i];
                            $payment_dr_amt = $_POST['payment_dr_amt'][$i];
                            $payment_dr_narration = $_POST['payment_dr_narration'][$i];

                            $query_dr = "INSERT INTO `transactions`(
                            `payment_id`,`ledger_id`, `ledger_id_contra`, `company_id`, `user_id`, `user_super_id`, `date`, `amt`, 
                            `amt_debit`, `amt_credit`, `narration`, `branch_id`, `created_by`, `created_datetime`) VALUES (
                            '$payment_id','$payment_led_dr','$payment_credit_ledger','$company_id','$user_id','$user_super_id','$payment_date',
                            '$payment_dr_amt','$payment_dr_amt',0,'$payment_dr_narration','$branch_id','$user_id',NOW())";
                            mysqli_query($con, $query_dr);

                            $query_cr = "INSERT INTO `transactions`(
                            `payment_id`,`ledger_id`, `ledger_id_contra`, `company_id`, `user_id`, `user_super_id`, `date`, `amt`, 
                            `amt_debit`, `amt_credit`, `narration`, `branch_id`, `created_by`, `created_datetime`) VALUES (
                            '$payment_id','$payment_credit_ledger','$payment_led_dr','$company_id','$user_id','$user_super_id','$payment_date',
                            '$payment_dr_amt',0,'$payment_dr_amt','$payment_dr_narration','$branch_id','$user_id',NOW())";
                            mysqli_query($con, $query_cr);
                        };
                    }; 
                };
    }
}

function edit_payment()
{
    global $con;
    $payment_id = $_POST['payment_id'];
    $payment_details=array();
    $query = "SELECT * FROM payment WHERE payment_id='$payment_id'";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_assoc($result))
    {
        array_push($payment_details, 
            $row['user_super_id'],$row['payment_id'],$row['company_id'],$row['user_id'],$row['ledger_credit'],
            $row['ledger_debit'],$row['payee'],$row['date'],$row['amount'],$row['narration'],$row['reference_no'],
            $row['mode'],$row['bank'],$row['branch'],$row['inst_no']
        );
    }
     echo json_encode($payment_details);
}

function edit_payment_dr()
{
    global $con;
    $payment_id = $_POST['payment_id'];
    $value = "";
    $value = '<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="payment_dr_list_table">
                    <tr>
                        <th width="30%">Debit Ledger(s)</th>
                        <th width="15%">Amount</th>
                        <th width="50%">Narration</th>
                        <th width="5%">Action</th>
                    </tr>';
    $query = "SELECT * FROM transactions WHERE payment_id='$payment_id' AND amt_debit > 0";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
        {
            $i=0;
            while($row_dr = mysqli_fetch_assoc($query_run))
            {
                $i=++$i;
                $value.='
                        <tr id="'.$i.'">
                                <td>
                                    <input type="hidden" name="payment_dr_id[]" class="form-control bg-light" id="payment_dr_id'.$i.'" value = "'.$i.'">
                                    <select class="form-control payment_led_dr bg-light" name="payment_led_dr[]" id="payment_led_dr'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                        <option value="0">Please Select</option>';
                                        
                                            $sql="SELECT * FROM ledgers WHERE ( tb_2 !=3 AND tb_4 !=6) OR (default_status = 'Yes' AND tb_4 !=10 AND tb_4 !=6) ORDER BY ledger_desc ASC";
                                            $result=mysqli_query($con,$sql);
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                       if ($row_dr['ledger_id'] == $row['ledger_id']) {
                                                           $value.='<option value = "'.$row['ledger_id'].'" selected="selected">'.$row['ledger_desc'].'</option>';
                                                       } 
                                                       else 
                                                       {
                                                        $value.='<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
                                                       };
                                                };
                                       
                           $value.='</select>
                                </td>
                                <td class = "action-td">
                                    <input type="text" name="payment_dr_amt[]" class="form-control bg-light payment_dr_amt amt-td" id="payment_dr_amt'.$i.'" data-id="'.$i.'" style="border-width:0px" value = "'.$row_dr['amt'].'">
                                </td>
                                <td class = "action-td">
                                    <input type="text" name="payment_dr_narration[]" class="form-control bg-light payment_dr_narration" id="payment_dr_narration'.$i.'" data-id="'.$i.'" style="border-width:0px" value = "'.$row_dr['narration'].'">
                                </td>
                                <td class = "action-td">
                                    <a href="#" id="delete_payment_dr" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                                </td>
                            </tr>';

            };

            $i=++$i;
                $value.='
                        <tr id="'.$i.'">
                                <td>
                                    <input type="hidden" name="payment_dr_id[]" class="form-control bg-light" id="payment_dr_id'.$i.'">
                                    <select class="form-control payment_led_dr bg-light" name="payment_led_dr[]" id="payment_led_dr'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                        <option value="0">Please Select</option>';
                                        
                                            $sql="SELECT * FROM ledgers WHERE ( tb_2 !=3 AND tb_4 !=6) OR (default_status = 'Yes' AND tb_4 !=10 AND tb_4 !=6) ORDER BY ledger_desc ASC";
                                            $result=mysqli_query($con,$sql);
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                       
                                                    $value.='<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
                                                };
                                       
                           $value.='</select>
                                </td>
                                <td class = "action-td">
                                    <input type="text" name="payment_dr_amt[]" class="form-control bg-light payment_dr_amt amt-td" id="payment_dr_amt'.$i.'" data-id="'.$i.'" style="border-width:0px">
                                </td>
                                <td class = "action-td">
                                    <input type="text" name="payment_dr_narration[]" class="form-control bg-light payment_dr_narration" id="payment_dr_narration'.$i.'" data-id="'.$i.'" style="border-width:0px">
                                </td>
                                <td class = "action-td">
                                    <a href="#" id="delete_payment_dr" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                                </td>
                            </tr>';

            $value.='</tbody>
            </table>';
        }
    echo $value;
}

function update_payment()
{
    global $con;
    $payment_id = $_POST['payment_id'];
    $user_super_id = $_POST['user_super_id'];
    $payment_credit_ledger = $_POST['payment_credit_ledger'];
    $payment_ref = $_POST['payment_ref'];
    $payment_date = $_POST['payment_date'];
    $payment_amount = $_POST['payment_amount'];
    $payment_mode = $_POST['payment_mode'];
    $payment_inst_no = $_POST['payment_inst_no'];
    $payment_bank = $_POST['payment_bank'];
    $payment_branch = $_POST['payment_branch'];
    $payment_payee = $_POST['payment_payee'];
    $payment_narration = $_POST['payment_narration'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $branch_id = $_SESSION['branch_id'];
    $query = "UPDATE `payment` SET
    `company_id`='$company_id', `user_id`='$user_id', `user_super_id`='$user_super_id', 
    `ledger_credit`='$payment_credit_ledger', `date`='$payment_date', `amount`='$payment_amount', 
    `narration`='$payment_narration', `reference_no`='$payment_ref', `mode`='$payment_mode', 
    `bank`='$payment_bank', `branch`='$payment_branch', `inst_no`='$payment_inst_no', 
    `payee`='$payment_payee', `altered_by`='$user_id', `altered_datetime`=NOW() 
    WHERE `payment_id`='$payment_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) 
    {

        //POST TRANSACTION
            $query = "DELETE FROM transactions WHERE `payment_id`='$payment_id'";
            $result = mysqli_query($con,$query);

        //RECEIPT_ITEMS
            $number_as = count($_POST["payment_led_dr"]);  
            if($number_as > 0)  
            {  
                for($i=0; $i<$number_as; $i++)  
                {  
                    if(trim($_POST["payment_led_dr"][$i] != ''))
                    {  
                        $payment_led_dr = $_POST['payment_led_dr'][$i];
                        $payment_dr_amt = $_POST['payment_dr_amt'][$i];
                        $payment_dr_narration = $_POST['payment_dr_narration'][$i];

                        $query_dr = "INSERT INTO `transactions`(
                        `payment_id`,`ledger_id`, `ledger_id_contra`, `company_id`, `user_id`, `user_super_id`, `date`, `amt`, 
                        `amt_debit`, `amt_credit`, `narration`,`branch_id`, `created_by`, `created_datetime`) VALUES (
                        '$payment_id','$payment_led_dr','$payment_credit_ledger','$company_id','$user_id','$user_super_id',
                        '$payment_date','$payment_dr_amt','$payment_dr_amt',0,'$payment_dr_narration','$branch_id','$user_id',NOW())";
                        mysqli_query($con, $query_dr);

                        $query_cr = "INSERT INTO `transactions`(
                        `payment_id`,`ledger_id`, `ledger_id_contra`, `company_id`, `user_id`, `user_super_id`, `date`, `amt`, `amt_debit`, 
                        `amt_credit`, `narration`,`branch_id`, `created_by`, `created_datetime`) VALUES (
                        '$payment_id','$payment_credit_ledger','$payment_led_dr','$company_id','$user_id','$user_super_id','$payment_date','$payment_dr_amt',
                        0,'$payment_dr_amt','$payment_dr_narration','$branch_id','$user_id',NOW())";
                        mysqli_query($con, $query_cr);
                    };
                }; 
            };
    }
}

function search_payment_by_name()
{
    global $con;
    $purchase_search_name = $_POST['purchase_search_name'];
    $company_id = $_POST['company_id'];
    $value = "";

    $query = "SELECT * FROM purchases WHERE company_id = '$company_id' AND supplier	LIKE '%".$purchase_search_name."%' ORDER BY date ASC";
    $query_run = mysqli_query($con, $query);

    $value = '<div class="table-responsive" id="purchases_list_table">
        <table class="table table-hover table-bordered table-sm" id="purchasesTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class = "action-td" width="5%">No</th>
                    <th class = "action-td" width="10%">Date</th>
                    <th width="20%">Paying Ledger</th>
                    <th width="10%">Supplied By</th>
                    <th class = "action-td" width="10%">Grams</th>
                    <th class = "action-td" width="10%">Water</th>
                    <th class = "action-td" width="10%">Price</th>
                    <th class = "action-td" width="5%">Karat</th>
                    <th class = "action-td" width="10%">Amount</th>
                    <th class = "action-td" width="10%">Action</th>
                </tr>
            </thead>
            <tbody class="pv-table-body">';
                
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                            $ledger_cr = $row['ledger_credit'];
                            $query_ledger = "SELECT * FROM ledgers WHERE ledger_id ='$ledger_cr'";
                            $query_ledger_run = mysqli_query($con, $query_ledger);
                            $row_ledger = mysqli_fetch_assoc($query_ledger_run);
               
                   $value.='<tr>
                                <td class = "action-td">
                                    <a href="#" id="btn_edit_purchase" data-id="'.$row['purchase_id'].'">'.$row['purchase_id'].'</a>
                                </td>
                                <td class = "action-td">'.$row['date'].'</td>
                                <td>'.$row_ledger['ledger_desc'].'</td>
                                <td>'.$row['supplier'].'</td>
                                <td class = "action-td">'.$row['weight'].'</td>
                                <td class = "action-td">'.$row['water'].'</td>';
                                
                                    $price_purchase = $row['price'];
                                    $price_purchase = number_format($price_purchase, 2, '.', ',');
                                
                       $value.='<td class = "action-td">'.$price_purchase.'</td>
                                <td class = "action-td">'.$row['karat'].'</td>';
                                
                                    $amount_purchase = $row['amount'];
                                    $amount_purchase = number_format($amount_purchase, 2, '.', ',');
                                
                       $value.='<td class = "amt-td">'.$amount_purchase.'</td>
                                <td class = "action-td">
                                    <a href="#" id="btn_edit_purchase" data-id="'.$row['purchase_id'].'">Edit</a>
                                    |
                                    <a href="#" id="btn_delete_purchase" data-id="'.$row['purchase_id'].'">Delete</a>
                                </td>
                            </tr>';
                
                        }
                    }
                    else
                    {
                            $value.='No Purchases Not Found';
                    };
                
            $value.='</tbody>
        </table>
    </div>';
    echo $value;
}

function search_payment_by_date()
{
    global $con;
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $company_id = $_POST['company_id'];
    $value = "";

    $query = "SELECT * FROM payment WHERE date BETWEEN '$start_date' AND '$end_date' AND  company_id = '$company_id' ORDER BY date ASC";
    $query_run = mysqli_query($con, $query);
        
    $value = '<div class="table-responsive" id="payment_list_table">
        <table class="table table-hover table-bordered table-sm" id="paymentTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th width="10%" class="action-td">Payment No</th>
                    <th width="10%" class="action-td">Date</th>
                    <th width="30%">Payee</th>
                    <th width="20%">Paying Ledger</th>
                    <th width="15%">Amount</th>
                    <th width="10%">Mode</th>
                    <th width="5%" class="action-td">Action</th>
                </tr>
            </thead>
            <tbody class="pv-table-body">';
                
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                            $ledger_cr = $row['ledger_credit'];
                            $query_ledger = "SELECT * FROM ledgers WHERE ledger_id ='$ledger_cr'";
                            $query_ledger_run = mysqli_query($con, $query_ledger);
                            $row_ledger = mysqli_fetch_assoc($query_ledger_run);
               
                   $value.='<tr>
                                <td class="action-td">'.$row['sno'].'</td>
                                <td class="action-td">'.$row['date'].'</td>
                                <td>'.$row['payee'].'</td>
                                <td>'.$row_ledger['ledger_desc'].'</td>';
                                
                                    $payment_amount = $row['amount'];
                                    $payment_amount = number_format($payment_amount, 2, '.', ',');
                                
                       $value.='<td class="amt-td">'.$payment_amount.'</td>
                                <td>'.$row['mode'].'</td>
                                <td class="action-td">';
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Payment'] == 'Yes')) 
                                      {
                                        $value.='<a href="#" id="btn_edit_payment" data-id="'.$row['payment_id'].'"><i class="fa fa-edit fa-sm"></i></a> |';
                                      };

                                      $value.='<a href="#" id="btn_payment_reprint" data-id="'.$row['payment_id'].'"><i class="fa fa-print fa-sm"></i></a>';

                                      if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Payment'] == 'Yes'))
                                      {
                                        $value.=' | <a href="#" id="btn_delete_payment" data-id2="'.$row['payment_id'].'"><i class="fa fa-trash fa-sm"></i></a>';
                                      };
                                $value.='</td>
                            </tr>';
                        }
                    }
                    else
                    {
                            $value.='No Payment Not Found';
                    };
                
            $value.='</tbody>
        </table>
    </div>';
    echo $value;
}

?>
