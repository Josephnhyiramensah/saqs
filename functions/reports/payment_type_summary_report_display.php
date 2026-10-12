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
        if(isset($_SESSION['payment_type_report_ledger_id']))
        {           
            $company_id = $_SESSION['payment_type_report_company_id'];
            $user_id = $_SESSION['payment_type_report_user_id'];
            $user_super_id = $_SESSION['payment_type_report_user_super_id'];
            $ledger_id = $_SESSION['payment_type_report_ledger_id'];
            $start_date = $_SESSION['payment_type_report_start_date'];
            $end_date = $_SESSION['payment_type_report_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);

            $query_ledger = "SELECT * FROM `ledgers` WHERE `ledger_id` = '$ledger_id'";
            $query_run_ledger = mysqli_query($con, $query_ledger);
            $row_ledger = mysqli_fetch_assoc($query_run_ledger);
?>
            <table class="table table-hover table-bordered table-sm" id="payment_type_report_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="13"><H2><?php echo $row_company['trading_name'];?></H2></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="13"><H6><?php echo $row_ledger['ledger_desc'];?> REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                    </tr>
                </thead>
                <tbody class="pv-table-body" id="payment_type_report_list_table_body">
<?php
            $query_sponsor="SELECT pt.ledger_id, pt.attend_id, pt.patient_id, att.date_admit, att.date_disch
                FROM payment_type pt
                INNER JOIN attendance att ON pt.attend_id = att.attend_id WHERE att.date_admit BETWEEN '$start_date' AND '$end_date' AND  ledger_id='$ledger_id'";
            $query_run_sponsor = mysqli_query($con, $query_sponsor);
            if (mysqli_num_rows($query_run_sponsor) > 0)
            {
                echo '<tr style="background-color:#E4DCCF; color:black">
                            <th>NAME</th>
                            <th class="action-td">AGE</th>
                            <th class="action-td">GENDER</th>
                            <th class="action-td">TYPE OF SERVICE</th>
                            <th class="action-td">DATE ADMIT.</th>
                            <th class="action-td">DISCHARGE DATE</th>
                            <th class="action-td">SERVICE</th>
                            <th class="action-td">DIAGNOSIS</th>
                            <th class="action-td">LAB. TEST</th>
                            <th class="action-td">SCAN</th>
                            <th class="action-td">SURGERIES</th>
                            <th class="action-td">DRUGS</th>
                            <th class="action-td">TOTAL</th>
                        </tr>';
                $amount_grand = 0;
                $total_service = 0;
                $total_diagnosis = 0;
                $total_labs = 0;
                $total_radio = 0;
                $total_surgery = 0;
                $total_drugs = 0;
                while($row_sponsor = mysqli_fetch_assoc($query_run_sponsor))
                {
                    $amount_sum = 0;
                    $attend_id = $row_sponsor['attend_id'];
                    $query_attend = "SELECT * FROM `attendance` WHERE `attend_id` = '$attend_id'";
                    $query_run_attend = mysqli_query($con, $query_attend);
                    $row_attend = mysqli_fetch_assoc($query_run_attend);

                    $patient_id = $row_sponsor['patient_id'];
                    $query_patient = "SELECT * FROM `patients` WHERE `patient_id` = '$patient_id'";
                    $query_run_patient = mysqli_query($con, $query_patient);
                    $row_patient = mysqli_fetch_assoc($query_run_patient);

                    $gender_id = $row_patient['gender'];
                    $query_gender = "SELECT * FROM `gender` WHERE `gender_id` = '$gender_id'";
                    $query_run_gender = mysqli_query($con, $query_gender);
                    $row_gender = mysqli_fetch_assoc($query_run_gender);

                    $tos_id = $row_attend['tos_id'];
                    $query_tos = "SELECT * FROM `type_of_service` WHERE `tos_id` = '$tos_id'";
                    $query_run_tos = mysqli_query($con, $query_tos);
                    $row_tos = mysqli_fetch_assoc($query_run_tos);

                    $query_dl = "SELECT * FROM `diagnosis_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_dl = mysqli_query($con, $query_dl);
                    if (mysqli_num_rows($query_run_dl) > 0)
                    {
                        $amount_diagnosis = 0;
                        while($row_dl = mysqli_fetch_assoc($query_run_dl))
                        {
                            $amount_diagnosis = $amount_diagnosis + $row_dl['amount_prvt'];
                            $amount_sum = $amount_sum + $row_dl['amount_prvt'];
                            $total_diagnosis = $total_diagnosis + $row_dl['amount_prvt'];
                            $amount_grand = $amount_grand + $row_dl['amount_prvt'];
                        };

                            $amount_diagnosis = number_format($amount_diagnosis, 2, '.', ',');
                    };

                    $query_svl = "SELECT * FROM `service_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_svl = mysqli_query($con, $query_svl);
                    if (mysqli_num_rows($query_run_svl) > 0)
                    {
                        $amount_service = 0;
                        while($row_svl = mysqli_fetch_assoc($query_run_svl))
                        {
                            $amount_service = $amount_service + $row_svl['amount_prvt'];
                            $amount_sum = $amount_sum + $row_svl['amount_prvt'];
                            $total_service = $total_service + $row_svl['amount_prvt'];
                            $amount_grand = $amount_grand + $row_svl['amount_prvt'];
                        };
                            $amount_service = number_format($amount_service, 2, '.', ',');
                    };

                    $query_ll = "SELECT * FROM `lab_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_ll = mysqli_query($con, $query_ll);
                    if (mysqli_num_rows($query_run_ll) > 0)
                    {
                        $amount_lab = 0;
                        while($row_ll = mysqli_fetch_assoc($query_run_ll))
                        {
                            $amount_lab = $amount_lab + $row_ll['amount_prvt'];
                            $amount_sum = $amount_sum + $row_ll['amount_prvt'];
                            $total_labs = $total_labs + $row_ll['amount_prvt'];
                            $amount_grand = $amount_grand + $row_ll['amount_prvt'];
                        };
                            $amount_lab = number_format($amount_lab, 2, '.', ',');
                    };

                    $query_rl = "SELECT * FROM `radio_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_rl = mysqli_query($con, $query_rl);
                    if (mysqli_num_rows($query_run_rl) > 0)
                    {
                        $amount_radio = 0;
                        while($row_rl = mysqli_fetch_assoc($query_run_rl))
                        {
                            $amount_radio = $amount_radio + $row_rl['amount_prvt'];
                            $amount_sum = $amount_sum + $row_rl['amount_prvt'];
                            $total_radio = $total_radio + $row_rl['amount_prvt'];
                            $amount_grand = $amount_grand + $row_rl['amount_prvt'];
                        };
                            $amount_radio = number_format($amount_radio, 2, '.', ',');
                    };

                    $query_sl = "SELECT * FROM `surgery_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_sl = mysqli_query($con, $query_sl);
                    if (mysqli_num_rows($query_run_sl) > 0)
                    {
                        $amount_surgery = 0;
                        while($row_sl = mysqli_fetch_assoc($query_run_sl))
                        {
                            $amount_surgery = $amount_surgery + $row_sl['amount_prvt'];
                            $amount_sum = $amount_sum + $row_sl['amount_prvt'];
                            $total_surgery = $total_surgery + $row_sl['amount_prvt'];
                            $amount_grand = $amount_grand + $row_sl['amount_prvt'];
                        };
                            $amount_surgery = number_format($amount_surgery, 2, '.', ',');
                    };

                    $query_drl = "SELECT * FROM `drug_dispense_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_drl = mysqli_query($con, $query_drl);
                    if (mysqli_num_rows($query_run_drl) > 0)
                    {
                        $amount_drug = 0;
                        while($row_drl = mysqli_fetch_assoc($query_run_drl))
                        {
                            $amount_drug = $amount_drug + $row_drl['amt_prvt'];
                            $amount_sum = $amount_sum + $row_drl['amt_prvt'];
                            $total_drugs = $total_drugs + $row_drl['amt_prvt'];
                            $amount_grand = $amount_grand + $row_drl['amt_prvt'];
                        };
                            $amount_drug = number_format($amount_drug, 2, '.', ',');
                    };
                    $amount_sum = number_format($amount_sum, 2, '.', ',');
                    echo '<tr>
                        <td>
                            <a href="#" 
                                id="" 
                                data-id="'.$row_patient['patient_id'].'" 
                                data-id1="'.$ledger_id.'"  
                                data-id2="'.$start_date.'" 
                                data-id3="'.$end_date.'"
                                data-id4="'.$attend_id.'">'.$row_patient['firstName'].' '.$row_patient['lastName'].'
                            </a>
                        </td>
                        <td class="action-td">'.$row_attend['age'].'year(s)</td>
                        <td class="action-td">'.$row_gender['gender'].'</td>
                        <td class="action-td">'.$row_tos['description'].'</td>
                        <td class="action-td">'.$row_attend['date_admit'].'</td>
                        <td class="action-td">'.$row_attend['date_disch'].'</td>
                        <td class="amt-td">';if(isset($amount_service)){echo $amount_service;}else{echo '0.00';}; echo'</td>
                        <td class="amt-td">';if(isset($amount_diagnosis)){echo $amount_diagnosis;}else{echo '0.00';}; echo'</td>
                        <td class="amt-td">';if(isset($amount_lab)){echo $amount_lab;}else{echo '0.00';}; echo'</td>
                        <td class="amt-td">';if(isset($amount_radio)){echo $amount_radio;}else{echo '0.00';}; echo'</td>
                        <td class="amt-td">';if(isset($amount_surgery)){echo $amount_surgery;}else{echo '0.00';}; echo'</td>
                        <td class="amt-td">';if(isset($amount_drug)){echo $amount_drug;}else{echo '0.00';}; echo'</td>
                        <td class="amt-td">';if(isset($amount_sum)){echo $amount_sum;}else{echo '0.00';}; echo'</td>
                    </tr>';
                };
                $amount_grand = number_format($amount_grand, 2, '.', ',');
                $total_diagnosis = number_format($total_diagnosis, 2, '.', ',');
                $total_service = number_format($total_service, 2, '.', ',');
                $total_labs = number_format($total_labs, 2, '.', ',');
                $total_radio = number_format($total_radio, 2, '.', ',');
                $total_surgery = number_format($total_surgery, 2, '.', ',');
                $total_drugs = number_format($total_drugs, 2, '.', ',');
                echo '<tr>
                        <th class="action-td" colspan="6"><H6><strong>GRAND TOTAL</strong></H6></th>
                        <th class="amt-td"><H6><strong>'.$total_service.'</strong></H6></th>
                        <th class="amt-td"><H6><strong>'.$total_diagnosis.'</strong></H6></th>
                        <th class="amt-td"><H6><strong>'.$total_labs.'</strong></H6></th>
                        <th class="amt-td"><H6><strong>'.$total_radio.'</strong></H6></th>
                        <th class="amt-td"><H6><strong>'.$total_surgery.'</strong></H6></th>
                        <th class="amt-td"><H6><strong>'.$total_drugs.'</strong></H6></th>
                        <th class="amt-td"><H6><strong>'.$amount_grand.'</strong></H6></th>
                    </tr>';
            };
    ?>
        </tbody>
    </table>
<?php    
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>