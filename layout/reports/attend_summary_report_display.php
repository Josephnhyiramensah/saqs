<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
?>
<input type='hidden' id='session_company_id' value="<?php echo $_SESSION['company_id'];?>">
<input type='hidden' id='session_user_super_id' value="<?php echo $_SESSION['user_super_id'];?>">
<input type='hidden' id='session_user_id' value="<?php echo $_SESSION['user_id'];?>">
  <style type="text/css">
    .scroll-card-body {
            max-height: 700px;
            overflow-y: auto;
          }
    .amt-td {
            text-align:right;
          }
    .action-td {
            text-align:center;
          }
</style>
<div class="container-fluid">
    <?php 
        if(isset($_SESSION['attend_summary_report_start_date']))
        {           
            $company_id = $_SESSION['attend_summary_report_company_id'];
            $user_id = $_SESSION['attend_summary_report_user_id'];
            $user_super_id = $_SESSION['attend_summary_report_user_super_id'];
            $start_date = $_SESSION['attend_summary_report_start_date'];
            $end_date = $_SESSION['attend_summary_report_end_date'];
            $sponsor = $_SESSION['attend_summary_report_sponsor'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
            <table class="table table-hover table-bordered table-sm" id="attend_summary_report_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="15"><H2><?php echo $row_company['trading_name'];?></H2></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="15"><H6>LEDGER SUMMARY REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                    </tr>
                    <tr>
                        <th class="action-td">S/NO</th>
                        <th class="action-td">PATIENT</th>
                        <th class="action-td">STATUS</th>
                        <th class="action-td">TELEPHONE</th>
                        <th class="action-td">AGE</th>
                        <th class="action-td">GENDER</th>
                        <th class="action-td">TYPE OF SERVICE</th>
                        <th class="action-td">DATE ADMIT</th>
                        <th class="action-td">DATE DISCH.</th>
                        <th class="action-td">SPONSOR</th>
                        <th class="action-td" hidden="true">NHIS</th>
                        <th class="action-td" hidden="true">PRIVATE</th>
                        <th class="action-td">CASH</th>
                        <th class="action-td">RECEIPT</th>
                        <th class="action-td">REFUND</th>
                        <th class="action-td">DISCOUNT</th>
                        <th class="action-td">BALANCE</th>

                    </tr>
                </thead>
                <tbody class="pv-table-body" id="attend_summary_report_list_table_body">
            <?php
            if($sponsor == 'all')
            {
                /*$sql_attend = "SELECT * FROM attendance WHERE (tos_id = 1 AND date_admit BETWEEN '$start_date' AND 
                '$end_date') OR (tos_id = 2 AND outcome = 'on_admission')";*/

                $sql_attend = "SELECT * FROM attendance WHERE date_admit BETWEEN '$start_date' AND 
                '$end_date'";
            }
            else
            {
                /*$sql_attend = "SELECT a.*, pt.ledger_id, pt.principal FROM attendance a JOIN payment_type pt ON
                a.attend_id=pt.attend_id
                WHERE (a.tos_id = 1 AND a.date_admit BETWEEN '$start_date' AND '$end_date' AND pt.ledger_id='$sponsor' 
                AND pt.principal='Yes') OR (a.tos_id = 2 AND a.outcome = 'on_admission' AND pt.ledger_id='$sponsor' 
                AND pt.principal='Yes')";*/

                $sql_attend = "SELECT a.*, pt.ledger_id, pt.principal FROM attendance a JOIN payment_type pt ON
                a.attend_id=pt.attend_id
                WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' AND pt.ledger_id='$sponsor' 
                AND pt.principal='Yes'";
            };
            $result_attend = mysqli_query($con,$sql_attend);
            if (mysqli_num_rows($result_attend) > 0)
            {
                $i = 0;
                $amount_nhis_sum = 0;
                $amount_prvt_sum = 0;
                $amount_cash_sum = 0;
                $amount_receipt_sum = 0;
                $amount_refund_sum = 0;
                $amount_discount_sum = 0;
                $amount_balance_sum = 0;
                $total_new = 0;
                $total_old = 0;
                while($row_attend = mysqli_fetch_array($result_attend))
                {
                    $i++;
                    $status = $row_attend['status'];
                    if($status == 'New')
                    {
                        $total_new = $total_new + 1;
                    }
                    elseif($status == 'Old')
                    {
                        $total_old = $total_old + 1;
                    };
                    $attend_id = $row_attend['attend_id'];
                    $patient_id = $row_attend['patient_id'];
                    $sql_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
                    $result_patient = mysqli_query($con,$sql_patient);
                    $row_patient = mysqli_fetch_array($result_patient);

                    $gender_id = $row_patient['gender'];
                    $query_gender = "SELECT * FROM `gender` WHERE `gender_id` = '$gender_id'";
                    $query_run_gender = mysqli_query($con, $query_gender);
                    $row_gender = mysqli_fetch_assoc($query_run_gender);

                    $tos_id = $row_attend['tos_id'];
                    $query_tos = "SELECT * FROM `type_of_service` WHERE `tos_id` = '$tos_id'";
                    $query_run_tos = mysqli_query($con, $query_tos);
                    $row_tos = mysqli_fetch_assoc($query_run_tos);

                    $sql_payment_type = "SELECT * FROM payment_type WHERE attend_id = '$attend_id' AND principal = 'Yes'";
                    $result_payment_type = mysqli_query($con,$sql_payment_type);
                    $row_payment_type = mysqli_fetch_array($result_payment_type);

                    $ledger_id = $row_payment_type['ledger_id'];
                    $sql_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
                    $result_ledger = mysqli_query($con,$sql_ledger);
                    $row_ledger = mysqli_fetch_array($result_ledger);
                            
                    ?>
                    <tr>
                        <td class="action-td"><?php echo $i;?></td>
                        <td >
                            <a id="btn_open_attend_details" href="#"
                                data-id="<?php echo $row_attend['attend_id'];?>"
                                data-id1="<?php echo $row_attend['patient_id'];?>"
                                data-id2="<?php echo $company_id;?>"
                                data-id3="<?php echo $row_attend['date_admit'];?>"
                                data-id4="<?php echo $row_attend['date_disch'];?>"
                                data-id5="<?php echo $row_patient['firstName'].' '.$row_patient['lastName'];?>"
                                data-id6="<?php echo $start_date;?>"
                                data-id7="<?php echo $end_date;?>"
                            >
                                <?php echo $row_patient['firstName'].' '.$row_patient['lastName'];?>
                            </a></td>
                        <td class="action-td"><?php echo $row_attend['status'];?></td>
                        <td class="action-td"><?php echo $row_patient['telephone'];?></td>
                        <td class="action-td"><?php echo $row_attend['age'];?></td>
                        <td class="action-td"><?php echo $row_gender['gender'];?></td>
                        <td ><?php echo $row_tos['description'];?></td>
                        <td ><?php echo $row_attend['date_admit'];?></td>
                        <td ><?php echo $row_attend['date_disch'];?></td>
                        <td ><?php echo $row_ledger['ledger_desc'];?></td>
                        <?php
                            $amount_nhis = 0;
                            $amount_prvt = 0;
                            $amount_cash = 0;
                            $amount_receipt = 0;
                            $amount_refund = 0;
                            $amount_discount = 0;
                            $amount_balance = 0;
                            //DIAGNOSIS
                                $query_dl = "SELECT * FROM `diagnosis_list` WHERE `attend_id` = '$attend_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                $query_run_dl = mysqli_query($con, $query_dl);
                                if (mysqli_num_rows($query_run_dl) > 0)
                                {
                                    while($row_dl = mysqli_fetch_assoc($query_run_dl))
                                    {
                                        $amount_nhis = $amount_nhis + $row_dl['amount_nhis'];
                                        $amount_prvt = $amount_prvt + $row_dl['amount_prvt'];
                                        $amount_cash = $amount_cash + $row_dl['amount_cash'];
                                        $amount_nhis_sum = $amount_nhis_sum + $row_dl['amount_nhis'];
                                        $amount_prvt_sum = $amount_prvt_sum + $row_dl['amount_prvt'];
                                        $amount_cash_sum = $amount_cash_sum + $row_dl['amount_cash'];
                                    };
                                };
                            //SERVICES
                                $query_svl = "SELECT * FROM `service_list` WHERE `attend_id` = '$attend_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                $query_run_svl = mysqli_query($con, $query_svl);
                                if (mysqli_num_rows($query_run_svl) > 0)
                                {
                                    while($row_svl = mysqli_fetch_assoc($query_run_svl))
                                    {
                                        $amount_nhis = $amount_nhis + $row_svl['amount_nhis'];
                                        $amount_prvt = $amount_prvt + $row_svl['amount_prvt'];
                                        $amount_cash = $amount_cash + $row_svl['amount_cash'];
                                        $amount_nhis_sum = $amount_nhis_sum + $row_svl['amount_nhis'];
                                        $amount_prvt_sum = $amount_prvt_sum + $row_svl['amount_prvt'];
                                        $amount_cash_sum = $amount_cash_sum + $row_svl['amount_cash'];
                                    };
                                };
                            //LABS
                                $query_ll = "SELECT * FROM `lab_list` WHERE `attend_id` = '$attend_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                $query_run_ll = mysqli_query($con, $query_ll);
                                if (mysqli_num_rows($query_run_ll) > 0)
                                {
                                    while($row_ll = mysqli_fetch_assoc($query_run_ll))
                                    {
                                        $amount_nhis = $amount_nhis + $row_ll['amount_nhis'];
                                        $amount_prvt = $amount_prvt + $row_ll['amount_prvt'];
                                        $amount_cash = $amount_cash + $row_ll['amount_cash'];
                                        $amount_nhis_sum = $amount_nhis_sum + $row_ll['amount_nhis'];
                                        $amount_prvt_sum = $amount_prvt_sum + $row_ll['amount_prvt'];
                                        $amount_cash_sum = $amount_cash_sum + $row_ll['amount_cash'];
                                    };
                                };
                            //RADIOLOGY
                                $query_rl = "SELECT * FROM `radio_list` WHERE `attend_id` = '$attend_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                $query_run_rl = mysqli_query($con, $query_rl);
                                if (mysqli_num_rows($query_run_rl) > 0)
                                {
                                    while($row_rl = mysqli_fetch_assoc($query_run_rl))
                                    {
                                        $amount_nhis = $amount_nhis + $row_rl['amount_nhis'];
                                        $amount_prvt = $amount_prvt + $row_rl['amount_prvt'];
                                        $amount_cash = $amount_cash + $row_rl['amount_cash'];
                                        $amount_nhis_sum = $amount_nhis_sum + $row_rl['amount_nhis'];
                                        $amount_prvt_sum = $amount_prvt_sum + $row_rl['amount_prvt'];
                                        $amount_cash_sum = $amount_cash_sum + $row_rl['amount_cash'];
                                    };
                                };
                            //SURGERY
                                $query_sl = "SELECT * FROM `surgery_list` WHERE `attend_id` = '$attend_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                $query_run_sl = mysqli_query($con, $query_sl);
                                if (mysqli_num_rows($query_run_sl) > 0)
                                {
                                    while($row_sl = mysqli_fetch_assoc($query_run_sl))
                                    {
                                        $amount_nhis = $amount_nhis + $row_sl['amount_nhis'];
                                        $amount_prvt = $amount_prvt + $row_sl['amount_prvt'];
                                        $amount_cash = $amount_cash + $row_sl['amount_cash'];
                                        $amount_nhis_sum = $amount_nhis_sum + $row_sl['amount_nhis'];
                                        $amount_prvt_sum = $amount_prvt_sum + $row_sl['amount_prvt'];
                                        $amount_cash_sum = $amount_cash_sum + $row_sl['amount_cash'];
                                    };
                                };
                            //DRUGS
                                $query_drl = "SELECT * FROM `drug_dispense_list` WHERE `attend_id` = '$attend_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                $query_run_drl = mysqli_query($con, $query_drl);
                                if (mysqli_num_rows($query_run_drl) > 0)
                                {
                                    while($row_drl = mysqli_fetch_assoc($query_run_drl))
                                    {
                                        $amount_nhis = $amount_nhis + $row_drl['amt_nhis'];
                                        $amount_prvt = $amount_prvt + $row_drl['amt_prvt'];
                                        $amount_cash = $amount_cash + $row_drl['amt_cash'];
                                        $amount_nhis_sum = $amount_nhis_sum + $row_drl['amt_nhis'];
                                        $amount_prvt_sum = $amount_prvt_sum + $row_drl['amt_prvt'];
                                        $amount_cash_sum = $amount_cash_sum + $row_drl['amt_cash'];
                                    };
                                };
                            //CONSUMABLES
                                $query_cl = "SELECT * FROM `consumable_list` WHERE `attend_id` = '$attend_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                $query_run_cl = mysqli_query($con, $query_cl);
                                if (mysqli_num_rows($query_run_cl) > 0)
                                {
                                    while($row_cl = mysqli_fetch_assoc($query_run_cl))
                                    {
                                        $amount_nhis = $amount_nhis + $row_cl['amount_nhis'];
                                        $amount_prvt = $amount_prvt + $row_cl['amount_prvt'];
                                        $amount_cash = $amount_cash + $row_cl['amount_cash'];
                                        $amount_nhis_sum = $amount_nhis_sum + $row_cl['amount_nhis'];
                                        $amount_prvt_sum = $amount_prvt_sum + $row_cl['amount_prvt'];
                                        $amount_cash_sum = $amount_cash_sum + $row_cl['amount_cash'];
                                    };
                                };
                            //RECEIPT
                                $query_receipt = "SELECT * FROM `receipt` WHERE `attend_id` = '$attend_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                $query_run_receipt = mysqli_query($con, $query_receipt);
                                if (mysqli_num_rows($query_run_receipt) > 0)
                                {
                                    while($row_receipt = mysqli_fetch_assoc($query_run_receipt))
                                    {
                                        $amount_receipt = $amount_receipt + $row_receipt['amount'];
                                        $amount_receipt_sum = $amount_receipt_sum + $row_receipt['amount'];
                                    };
                                };
                            //REFUND
                                $query_refund = "SELECT * FROM `refund` WHERE `attend_id` = '$attend_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                $query_run_refund = mysqli_query($con, $query_refund);
                                if (mysqli_num_rows($query_run_refund) > 0)
                                {
                                    while($row_refund = mysqli_fetch_assoc($query_run_refund))
                                    {
                                        $amount_refund = $amount_refund + $row_refund['amount'];
                                        $amount_refund_sum = $amount_refund_sum + $row_refund['amount'];
                                    };
                                };
                            //DISCOUNT
                                $query_discount = "SELECT * FROM `discount` WHERE `attend_id` = '$attend_id' AND date BETWEEN '$start_date' AND '$end_date'";
                                $query_run_discount = mysqli_query($con, $query_discount);
                                if (mysqli_num_rows($query_run_discount) > 0)
                                {
                                    while($row_discount = mysqli_fetch_assoc($query_run_discount))
                                    {
                                        $amount_discount = $amount_discount + $row_discount['amount'];
                                        $amount_discount_sum = $amount_discount_sum + $row_discount['amount'];
                                    };
                                };
                            $amount_balance = $amount_cash - $amount_receipt + $amount_refund - $amount_discount;
                            $amount_nhis_f = number_format($amount_nhis, 2, '.', ',');
                            $amount_prvt_f = number_format($amount_prvt, 2, '.', ',');
                            $amount_cash_f = number_format($amount_cash, 2, '.', ',');
                            $amount_receipt_f = number_format($amount_receipt, 2, '.', ',');
                            $amount_refund_f = number_format($amount_refund, 2, '.', ',');
                            $amount_discount_f = number_format($amount_discount, 2, '.', ',');
                            $amount_balance_f = number_format($amount_balance, 2, '.', ',');
                        ?>
                        <td class="amt-td" hidden="true"><?php echo $amount_nhis_f;?></td>
                        <td class="amt-td" hidden="true"><?php echo $amount_prvt_f;?></td>
                        <td class="amt-td"><?php echo $amount_cash_f;?></td>
                        <td class="amt-td"><?php echo $amount_receipt_f;?></td>
                        <td class="amt-td"><?php echo $amount_refund_f;?></td>
                        <td class="amt-td"><?php echo $amount_discount_f;?></td>
                        <td class="amt-td"><?php echo $amount_balance_f;?></td>
                    </tr>
                    <?php
                };
            };
                            $amount_balance_sum = $amount_cash_sum - $amount_receipt_sum + $amount_refund_sum - $amount_discount_sum;
                            $amount_nhis_sum_f = number_format($amount_nhis_sum, 2, '.', ',');
                            $amount_prvt_sum_f = number_format($amount_prvt_sum, 2, '.', ',');
                            $amount_cash_sum_f = number_format($amount_cash_sum, 2, '.', ',');
                            $amount_receipt_sum_f = number_format($amount_receipt_sum, 2, '.', ',');
                            $amount_refund_sum_f = number_format($amount_refund_sum, 2, '.', ',');
                            $amount_discount_sum_f = number_format($amount_discount_sum, 2, '.', ',');
                            $amount_balance_sum_f = number_format($amount_balance_sum, 2, '.', ',');
        ?>
                    <tr>
                        <th class="action-td" colspan="10">GRAND TOTAL</th>
                        <th class="amt-td" hidden="true"><?php echo $amount_nhis_sum_f;?></th>
                        <th class="amt-td" hidden="true"><?php echo $amount_prvt_sum_f;?></th>
                        <th class="amt-td"><?php echo $amount_cash_sum_f;?></th>
                        <th class="amt-td"><?php echo $amount_receipt_sum_f;?></th>
                        <th class="amt-td"><?php echo $amount_refund_sum_f;?></th>
                        <th class="amt-td"><?php echo $amount_discount_sum_f;?></th>
                        <th class="amt-td"><?php echo $amount_balance_sum_f;?></th>
                    </tr>
                    <tr>
                        <th class="action-td" colspan="9">Total New Patients:<?php echo $total_new;?></th>
                        <th class="action-td" colspan="8">Total Old Patients:<?php echo $total_old;?></th>
                    </tr>
                </tbody>
        </table>
<?php    
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>