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
        if(isset($_SESSION['payment_type_report_start_date']))
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
                        <th class = "action-td" colspan="7"><H2><?php echo $row_company['trading_name'];?></H2></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="7"><H6><?php echo $row_ledger['ledger_desc'];?> REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
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
                $amount_grand = 0;
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

                    echo '<tr style="background-color:#E4DCCF; color:black">
                            <th colspan="2">'.$row_patient['firstName'].' '.$row_patient['lastName'].'</th>
                            <th class="action-td">'.$row_attend['age'].'year(s)</th>
                            <th class="action-td">'.$row_gender['gender'].'</th>
                            <th class="action-td">'.$row_tos['description'].'</th>
                            <th class="action-td">'.$row_attend['date_admit'].'</th>
                            <th class="action-td">'.$row_attend['date_disch'].'</th>
                        </tr>';

                    $query_dl = "SELECT * FROM `diagnosis_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_dl = mysqli_query($con, $query_dl);
                    if (mysqli_num_rows($query_run_dl) > 0)
                    {
                        echo'<tr>
                                <th colspan="7">DIAGNOSIS</th>
                            </tr>';
                        while($row_dl = mysqli_fetch_assoc($query_run_dl))
                        {
                            $diagnosis_id = $row_dl['diagnosis_id'];
                            $query_diagnosis = "SELECT * FROM `diagnosis` WHERE `diagnosis_id` = '$diagnosis_id'";
                            $query_run_diagnosis = mysqli_query($con, $query_diagnosis);
                            if (mysqli_num_rows($query_run_diagnosis) > 0)
                            {
                                $row_diagnosis = mysqli_fetch_assoc($query_run_diagnosis);
                            };
                                $amount = $row_dl['amount_prvt'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td colspan="3">'.$row_diagnosis['diagnosis'].'</td>
                                    <td class="action-td">'.$row_dl['date'].'</td>
                                    <td class="action-td">'.$row_dl['qty'].'</td>
                                    <td class="amt-td">'.$row_dl['price_prvt'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_dl['amount_prvt'];
                                $amount_grand = $amount_grand + $row_dl['amount_prvt'];
                        };
                    };

                    $query_svl = "SELECT * FROM `service_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_svl = mysqli_query($con, $query_svl);
                    if (mysqli_num_rows($query_run_svl) > 0)
                    {
                        echo'<tr>
                                <th colspan="7">SERVICE</th>
                            </tr>';
                        while($row_svl = mysqli_fetch_assoc($query_run_svl))
                        {
                            $service_id = $row_svl['service_id'];
                            $query_service = "SELECT * FROM `services` WHERE `service_id` = '$service_id'";
                            $query_run_service = mysqli_query($con, $query_service);
                            if (mysqli_num_rows($query_run_service) > 0)
                            {
                                $row_service = mysqli_fetch_assoc($query_run_service);
                            };
                                $amount = $row_svl['amount_prvt'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td colspan="3">'.$row_service['service'].'</td>
                                    <td class="action-td">'.$row_svl['date'].'</td>
                                    <td class="action-td">'.$row_svl['qty'].'</td>
                                    <td class="amt-td">'.$row_svl['price_prvt'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_svl['amount_prvt'];
                                $amount_grand = $amount_grand + $row_svl['amount_prvt'];
                        };
                    };

                    $query_ll = "SELECT * FROM `lab_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_ll = mysqli_query($con, $query_ll);
                    if (mysqli_num_rows($query_run_ll) > 0)
                    {
                        echo'<tr>
                                <th colspan="7">LABORATORY TEST</th>
                            </tr>';
                        while($row_ll = mysqli_fetch_assoc($query_run_ll))
                        {
                            $lab_id = $row_ll['lab_id'];
                            $query_lab = "SELECT * FROM `lab` WHERE `lab_id` = '$lab_id'";
                            $query_run_lab = mysqli_query($con, $query_lab);
                            if (mysqli_num_rows($query_run_lab) > 0)
                            {
                                $row_lab = mysqli_fetch_assoc($query_run_lab);
                            };
                                $amount = $row_ll['amount_prvt'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td colspan="3">'.$row_lab['lab'].'</td>
                                    <td class="action-td">'.$row_ll['date'].'</td>
                                    <td class="action-td">'.$row_ll['qty'].'</td>
                                    <td class="amt-td">'.$row_ll['price_prvt'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_ll['amount_prvt'];
                                $amount_grand = $amount_grand + $row_ll['amount_prvt'];
                        };
                    };


                    $query_rl = "SELECT * FROM `radio_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_rl = mysqli_query($con, $query_rl);
                    if (mysqli_num_rows($query_run_rl) > 0)
                    {
                        echo'<tr>
                                <th colspan="7">RADIOLOGY</th>
                            </tr>';
                        while($row_rl = mysqli_fetch_assoc($query_run_rl))
                        {
                            $radio_id = $row_rl['radio_id'];
                            $query_radio = "SELECT * FROM `radiology` WHERE `radio_id` = '$radio_id'";
                            $query_run_radio = mysqli_query($con, $query_radio);
                            if (mysqli_num_rows($query_run_radio) > 0)
                            {
                                $row_radio = mysqli_fetch_assoc($query_run_radio);
                            };
                                $amount = $row_rl['amount_prvt'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td colspan="3">'.$row_radio['radiology'].'</td>
                                    <td class="action-td">'.$row_rl['date'].'</td>
                                    <td class="action-td">'.$row_rl['qty'].'</td>
                                    <td class="amt-td">'.$row_rl['price_prvt'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_rl['amount_prvt'];
                                $amount_grand = $amount_grand + $row_rl['amount_prvt'];
                        };
                    };


                    $query_sl = "SELECT * FROM `surgery_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_sl = mysqli_query($con, $query_sl);
                    if (mysqli_num_rows($query_run_sl) > 0)
                    {
                        echo'<tr>
                                <th colspan="7">SURGERY/PROCEDURE</th>
                            </tr>';
                        while($row_sl = mysqli_fetch_assoc($query_run_sl))
                        {
                            $surgery_id = $row_sl['surgery_id'];
                            $query_surgery = "SELECT * FROM `surgery` WHERE `surgery_id` = '$surgery_id'";
                            $query_run_surgery = mysqli_query($con, $query_surgery);
                            if (mysqli_num_rows($query_run_surgery) > 0)
                            {
                                $row_surgery = mysqli_fetch_assoc($query_run_surgery);
                            };
                                $amount = $row_sl['amount_prvt'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td colspan="3">'.$row_surgery['surgery'].'</td>
                                    <td class="action-td">'.$row_sl['date'].'</td>
                                    <td class="action-td">'.$row_sl['qty'].'</td>
                                    <td class="amt-td">'.$row_sl['price_prvt'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_sl['amount_prvt'];
                                $amount_grand = $amount_grand + $row_sl['amount_prvt'];
                        };
                    };

                    $query_drl = "SELECT * FROM `drug_dispense_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_drl = mysqli_query($con, $query_drl);
                    if (mysqli_num_rows($query_run_drl) > 0)
                    {
                        echo'<tr>
                                <th colspan="7">DRUGS</th>
                            </tr>';
                        while($row_drl = mysqli_fetch_assoc($query_run_drl))
                        {
                            $drug_id = $row_drl['drug_id'];
                            $query_drug = "SELECT * FROM `drugs` WHERE `drug_id` = '$drug_id'";
                            $query_run_drug = mysqli_query($con, $query_drug);
                            if (mysqli_num_rows($query_run_drug) > 0)
                            {
                                $row_drug = mysqli_fetch_assoc($query_run_drug);
                            };
                                $amount = $row_drl['amt_prvt'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td colspan="3">'.$row_drug['brand_name'].'</td>
                                    <td class="action-td">'.$row_drl['date'].'</td>
                                    <td class="action-td">'.$row_drl['qty'].'</td>
                                    <td class="amt-td">'.$row_drl['price_prvt'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_drl['amt_prvt'];
                                $amount_grand = $amount_grand + $row_drl['amt_prvt'];
                        };
                    };
                    $amount_sum = number_format($amount_sum, 2, '.', ',');
                    echo '<tr>
                            <th class="action-td" colspan="6">TOTAL</th>
                            <th class="amt-td">'.$amount_sum.'</th>
                        </tr>';
                };
                $amount_grand = number_format($amount_grand, 2, '.', ',');
                    echo '<tr>
                            <th class="action-td" colspan="6"><H4><strong>GRAND TOTAL</strong></H4></th>
                            <th class="amt-td"><H4><strong>'.$amount_grand.'</strong></H4></th>
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