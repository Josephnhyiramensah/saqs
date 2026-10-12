<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//JOURNAL
function save_journal()
{
    global $con;
    $journal_id = $_POST['journal_id'];
    $company_id = $_POST['company_id'];
    $user_id = $_POST['user_id'];
    $user_super_id = $_POST['user_super_id'];
    $journal_debit_ledger = $_POST['journal_debit_ledger'];
    $journal_credit_ledger = $_POST['journal_credit_ledger'];
    $journal_date = $_POST['journal_date'];
    $journal_amount = $_POST['journal_amount'];
    $journal_ref = $_POST['journal_ref'];
    $journal_narration = $_POST['journal_narration'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $branch_id = $_SESSION['branch_id'];

    $query_last_sno = "SELECT `sno` FROM `journal` WHERE `company_id` = '$company_id' ORDER BY `sno` DESC";
    $result_last_sno = mysqli_query($con,$query_last_sno);
    if(!empty($result_last_sno) && mysqli_num_rows($result_last_sno))
    {
        $row_last_sno = mysqli_fetch_assoc($result_last_sno);
        $last_sno = $row_last_sno['sno'];
        $next_sno = $last_sno + 1;
    }
    else
    {
        $next_sno = 1;
    };

    $query = "INSERT INTO `journal`(
    `sno`, `company_id`, `user_id`, `user_super_id`, `reference_no`, `narration`, `ledger_debit`, 
    `ledger_credit`, `amount`, `date`, `branch_id`, `created_by`, `created_datetime`) VALUES (
    '$next_sno','$company_id','$user_id','$user_super_id','$journal_ref','$journal_narration',
    '$journal_debit_ledger','$journal_credit_ledger','$journal_amount','$journal_date',
    '$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);
    if ($query_run) 
    {
        //POST TRANSACTION
            $query = "SELECT * FROM journal WHERE `company_id`='$company_id' ORDER BY journal_id DESC";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_assoc($result);
            $journal_id = $row['journal_id'];

            
            $query_dr = "INSERT INTO `transactions`(
            `journal_id`,`ledger_id`, `ledger_id_contra`, `company_id`, `user_id`, `user_super_id`, `date`, `amt`, 
            `amt_debit`, `amt_credit`, `narration`, `branch_id`, `created_by`, `created_datetime`) VALUES (
            '$journal_id','$journal_debit_ledger','$journal_credit_ledger','$company_id','$user_id','$user_super_id','$journal_date',
            '$journal_amount','$journal_amount',0,'$journal_narration','$branch_id','$user_id',NOW())";
            mysqli_query($con, $query_dr);

            $query_cr = "INSERT INTO `transactions`(
            `journal_id`,`ledger_id`, `ledger_id_contra`, `company_id`, `user_id`, `user_super_id`, `date`, `amt`, 
            `amt_debit`, `amt_credit`, `narration`, `branch_id`, `created_by`, `created_datetime`) VALUES (
            '$journal_id','$journal_credit_ledger','$journal_debit_ledger','$company_id','$user_id','$user_super_id','$journal_date',
            '$journal_amount',0,'$journal_amount','$journal_narration','$branch_id','$user_id',NOW())";
            mysqli_query($con, $query_cr);
    };
}

function edit_journal()
{
    global $con;
    $journal_id = $_POST['journal_id'];
    $journal_details=array();
    $query = "SELECT * FROM journal WHERE journal_id='$journal_id'";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_assoc($result))
    {
        array_push($journal_details, 
            $row['user_super_id'],$row['journal_id'],$row['company_id'],$row['user_id'],$row['ledger_credit'],
            $row['ledger_debit'],$row['date'],$row['amount'],$row['narration'],$row['reference_no']
        );
    }
     echo json_encode($journal_details);
}

function update_journal()
{
    global $con;
    $journal_id = $_POST['journal_id'];
    $user_id = $_POST['user_id'];
    $user_super_id = $_POST['user_super_id'];
    $journal_debit_ledger = $_POST['journal_debit_ledger'];
    $journal_credit_ledger = $_POST['journal_credit_ledger'];
    $journal_date = $_POST['journal_date'];
    $journal_amount = $_POST['journal_amount'];
    $journal_ref = $_POST['journal_ref'];
    $journal_narration = $_POST['journal_narration'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $branch_id = $_SESSION['branch_id'];

    $query = "UPDATE `journal`SET 
    `company_id`='$company_id', `user_id`='$user_id', `user_super_id`='$user_super_id', 
    `reference_no`='$journal_ref', `narration`='$journal_narration', 
    `ledger_debit`='$journal_debit_ledger', `ledger_credit`='$journal_credit_ledger', 
    `amount`='$journal_amount', `date`='$journal_date', `altered_by`='$user_id', `altered_datetime`=NOW()
    WHERE `journal_id`='$journal_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run) 
    {
        //POST TRANSACTION
            $query = "DELETE FROM `transactions` WHERE `journal_id`='$journal_id'";
            $result = mysqli_query($con,$query);

            
            $query_dr = "INSERT INTO `transactions`(
            `journal_id`,`ledger_id`, `ledger_id_contra`, `company_id`, `user_id`, `user_super_id`, `date`, `amount`, 
            `amount_debit`, `amount_credit`, `narration`, `branch_id`, `created_by`, `created_datetime`) VALUES (
            '$journal_id','$journal_debit_ledger','$journal_credit_ledger','$company_id','$user_id','$user_super_id','$journal_date',
            '$journal_amount','$journal_amount',0,'$journal_narration','$branch_id','$user_id',NOW())";
            mysqli_query($con, $query_dr);

            $query_cr = "INSERT INTO `transactions`(
            `journal_id`,`ledger_id`, `ledger_id_contra`, `company_id`, `user_id`, `user_super_id`, `date`, `amount`, 
            `amount_debit`, `amount_credit`, `narration`, `branch_id`, `created_by`, `created_datetime`) VALUES (
            '$journal_id','$journal_credit_ledger','$journal_debit_ledger','$company_id','$user_id','$user_super_id','$journal_date',
            '$journal_amount',0,'$journal_amount','$journal_narration','$branch_id','$user_id',NOW())";
            mysqli_query($con, $query_cr);
    };
}

function search_journal_by_name()
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

function search_journal_by_date()
{
    global $con;
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $company_id = $_POST['company_id'];
    $value = "";

    $query = "SELECT * FROM journal WHERE date BETWEEN '$start_date' AND '$end_date' AND  company_id = '$company_id' ORDER BY date ASC";
    $query_run = mysqli_query($con, $query);
        
    $value = '<div class="table-responsive" id="journal_list_table">
        <table class="table table-hover table-bordered table-sm" id="paymentTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th width="10%" class="action-td">Journal No</th>
                    <th width="10%" class="action-td">Date</th>
                    <th width="25%">Debit Ledger</th>
                    <th width="25%">Credit Ledger</th>
                    <th width="15%">Amount</th>
                    <th width="10%">Narration</th>
                    <th width="5%" class="action-td">Action</th>
                </tr>
            </thead>
            <tbody class="pv-table-body">';
                
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                            $ledger_id_dr = $row['ledger_debit'];
                            $query_ledger_dr="SELECT * FROM ledgers WHERE ledger_id ='$ledger_id_dr'";
                            $query_run_ledger_dr = mysqli_query($con,$query_ledger_dr);
                            $row_ledger_dr = mysqli_fetch_array($query_run_ledger_dr);
                            
                            $ledger_id_cr = $row['ledger_credit'];
                            $query_ledger_cr = "SELECT * FROM ledgers WHERE ledger_id ='$ledger_id_cr'";
                            $query_run_ledger_cr = mysqli_query($con,$query_ledger_cr);
                            $row_ledger_cr = mysqli_fetch_array($query_run_ledger_cr);
               
                               $journal_amount = $row['amount'];
                            $journal_amount = number_format($journal_amount, 2, '.', ',');
                   $value.='<tr>
                                <td class="action-td">'.$row['sno'].'</td>
                                <td class="action-td">'.$row['date'].'</td>
                                <td>'.$row_ledger_dr['ledger_desc'].'</td>
                                <td>'.$row_ledger_cr['ledger_desc'].'</td>
                                <td class="amt-td">'.$journal_amount.'</td>
                                <td>'.$row['narration'].'</td>
                                <td class="action-td">';
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Journal'] == 'Yes')) 
                                      {
                                        $value.='<a href="#" id="btn_edit_journal" data-id="'.$row['journal_id'].'"><i class="fa fa-edit fa-sm"></i></a> | ';
                                      };

                                      $value.='<a href="#" id="btn_journal_reprint" data-id="'.$row['journal_id'].'"><i class="fa fa-print fa-sm"></i></a>';

                                      if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Journal'] == 'Yes'))
                                      {
                                        $value.=' | <a href="#" id="btn_delete_journal" data-id2="'.$row['journal_id'].'"><i class="fa fa-trash fa-sm"></i></a>';
                                      };
                                $value.='</td>
                            </tr>';                        
                        }
                    }
                    else
                    {
                            $value.='No Journal Voucher Not Found';
                    };
                
            $value.='</tbody>
        </table>
    </div>';
    echo $value;
}

?>
