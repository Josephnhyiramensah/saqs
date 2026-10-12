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
        if(isset($_SESSION['attend_id']))
        {           
            $company_id = $_SESSION['company_id'];
            $user_super_id = $_SESSION['user_super_id'];
            $patient_id = $_SESSION['patient_id'];
            $attend_id = $_SESSION['attend_id'];
            $ledger_id = $_SESSION['sponsor_id'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);

            $sql_attend = "SELECT * FROM attendance WHERE attend_id = '$attend_id'";
            $result_attend = mysqli_query($con,$sql_attend);
            $row_attend = mysqli_fetch_array($result_attend);

            $sql_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
            $result_patient = mysqli_query($con,$sql_patient);
            $row_patient = mysqli_fetch_array($result_patient);

            $tos_id = $row_attend['tos_id'];
            $sql_tos = "SELECT * FROM type_of_service WHERE tos_id = '$tos_id'";
            $result_tos = mysqli_query($con,$sql_tos);
            $row_tos = mysqli_fetch_array($result_tos);

            $gender_id = $row_patient['gender'];
            $sql_gender = "SELECT * FROM gender WHERE gender_id = '$gender_id'";
            $result_gender = mysqli_query($con,$sql_gender);
            $row_gender = mysqli_fetch_array($result_gender);
    ?>
            <table class="table table-hover table-bordered table-sm" id="patient_cash_statement_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="8"><H2><?php echo $row_company['trading_name'];?></H2></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="8"><H4><?php echo $row_company['telephone'];?></H4></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="8"><H4>PATIENT SPONSOR STATEMENT</H4></th>
                    </tr>
                </thead>
                <tbody class="pv-table-body" id="patient_cash_statement_list_table_body">
                    <tr>
                        <td colspan="6"><strong>NAME:</strong><?php echo $row_patient['firstName'].' '.$row_patient['lastName'];?></td>
                    </tr>
                        <td colspan="2"><strong>FOLDER NO:</strong><?php echo $row_patient['folderNo'];?></td>
                        <td colspan="2"><strong>GENDER:</strong><?php echo $row_gender['gender'];?></td>
                        <td colspan="2"><strong>AGE:</strong><?php echo $row_attend['age'];?></td>
                    </tr>
                    </tr>
                        <td colspan="2"><strong>TYPE OF SERVICE:</strong><?php echo $row_tos['description'];?></td>
                        <td colspan="2"><strong>DATE ADMITTED:</strong><?php echo $row_attend['date_admit'];?></td>
                        <td colspan="2"><strong>DATE DISCHARGED:</strong><?php echo $row_attend['date_disch'];?></td>
                    </tr>
                    </tr>
                        <th class = "action-td">DATE</th>
                        <th colspan="2">PARTICULARS</th>
                        <th class = "action-td">QTY</th>
                        <th class = "action-td">PRICE</th>
                        <th class = "action-td">BILL</th>
                    </tr>
    <?php
                    $query_svl = "SELECT * FROM `service_list` WHERE `attend_id` = '$attend_id' AND ledger_id ='$ledger_id'";
                    $query_run_svl = mysqli_query($con, $query_svl);
                    if (mysqli_num_rows($query_run_svl) > 0)
                    {   
                        $amount_sum = 0;
                        $total_bill = 0;
                        echo'<tr>
                                <th colspan="6">SERVICE</th>
                            </tr>';
                        while($row_svl = mysqli_fetch_assoc($query_run_svl))
                        {
                            $service_list_id = $row_svl['service_list_id'];
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
                                    <td class="action-td">'.$row_svl['date'].'</td>
                                    <td colspan="2">'.$row_service['service'].'</td>
                                    <td class="action-td">'.$row_svl['qty'].'</td>
                                    <td class="amt-td">'.$row_svl['price_prvt'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_svl['amount_prvt'];
                                $total_bill = $total_bill + $row_svl['amount_prvt'];
                        };
                    };

                    $query_ll = "SELECT * FROM `lab_list` WHERE `attend_id` = '$attend_id' AND ledger_id ='$ledger_id'";
                    $query_run_ll = mysqli_query($con, $query_ll);
                    if (mysqli_num_rows($query_run_ll) > 0)
                    {
                        $amount_sum = 0;
                        echo'<tr>
                                <th colspan="6">LABORATORY TEST</th>
                            </tr>';
                        while($row_ll = mysqli_fetch_assoc($query_run_ll))
                        {
                            $lab_list_id = $row_ll['lab_list_id'];
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
                                    <td class="action-td">'.$row_ll['date'].'</td>
                                    <td colspan="2">'.$row_lab['lab'].'</td>
                                    <td class="action-td">'.$row_ll['qty'].'</td>
                                    <td class="amt-td">'.$row_ll['price_prvt'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_ll['amount_prvt'];
                                $total_bill = $total_bill + $row_ll['amount_prvt'];
                        };
                    };

                    $query_rl = "SELECT * FROM `radio_list` WHERE `attend_id` = '$attend_id' AND ledger_id ='$ledger_id'";
                    $query_run_rl = mysqli_query($con, $query_rl);
                    if (mysqli_num_rows($query_run_rl) > 0)
                    {
                        $amount_sum = 0;
                        echo'<tr>
                                <th colspan="6">RADIOLOGY</th>
                            </tr>';
                        while($row_rl = mysqli_fetch_assoc($query_run_rl))
                        {
                            $radio_list_id = $row_rl['radio_list_id'];
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
                                    <td class="action-td">'.$row_rl['date'].'</td>
                                    <td colspan="2">'.$row_radio['radiology'].'</td>
                                    <td class="action-td">'.$row_rl['qty'].'</td>
                                    <td class="amt-td">'.$row_rl['price_prvt'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_rl['amount_prvt'];
                                $total_bill = $total_bill + $row_rl['amount_prvt'];
                        };
                    };

                    $query_sl = "SELECT * FROM `surgery_list` WHERE `attend_id` = '$attend_id' AND ledger_id ='$ledger_id'";
                    $query_run_sl = mysqli_query($con, $query_sl);
                    if (mysqli_num_rows($query_run_sl) > 0)
                    {
                        $amount_sum = 0;
                        echo'<tr>
                                <th colspan="6">SURGERY/PROCEDURE</th>
                            </tr>';
                        while($row_sl = mysqli_fetch_assoc($query_run_sl))
                        {
                            $surgery_list_id = $row_sl['surgery_list_id'];
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
                                    <td class="action-td">'.$row_sl['date'].'</td>
                                    <td colspan="2">'.$row_surgery['surgery'].'</td>
                                    <td class="action-td">'.$row_sl['qty'].'</td>
                                    <td class="amt-td">'.$row_sl['price_prvt'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_sl['amount_prvt'];
                                $total_bill = $total_bill + $row_sl['amount_prvt'];
                        };
                    };

                    $query_drl = "SELECT * FROM `drug_dispense_list` WHERE `attend_id` = '$attend_id' AND ledger_id ='$ledger_id'";
                    $query_run_drl = mysqli_query($con, $query_drl);
                    if (mysqli_num_rows($query_run_drl) > 0)
                    {
                        $amount_sum = 0;
                        echo'<tr>
                                <th colspan="6">DRUGS</th>
                            </tr>';
                        while($row_drl = mysqli_fetch_assoc($query_run_drl))
                        {
                            $drug_list_id = $row_drl['drug_list_id'];
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
                                    <td class="action-td">'.$row_drl['date'].'</td>
                                    <td colspan="2">'.$row_drug['brand_name'].'</td>
                                    <td class="action-td">'.$row_drl['qty'].'</td>
                                    <td class="amt-td">'.$row_drl['price_prvt'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_drl['amt_prvt'];
                                $total_bill = $total_bill + $row_drl['amt_prvt'];
                        };
                    };

                    $query_cl = "SELECT * FROM `consumable_list` WHERE `attend_id` = '$attend_id' AND ledger_id ='$ledger_id'";
                    $query_run_cl = mysqli_query($con, $query_cl);
                    if (mysqli_num_rows($query_run_cl) > 0)
                    {
                        $amount_sum = 0;
                        echo'<tr>
                                <th colspan="6">CONSUMABLES</th>
                            </tr>';
                        while($row_cl = mysqli_fetch_assoc($query_run_cl))
                        {
                            $con_list_id = $row_cl['con_list_id'];
                            $con_id = $row_cl['con_id'];
                            $query_con = "SELECT * FROM `consumable` WHERE `con_id` = '$con_id'";
                            $query_run_con = mysqli_query($con, $query_con);
                            if (mysqli_num_rows($query_run_con) > 0)
                            {
                                $row_con = mysqli_fetch_assoc($query_run_con);
                            };
                                $amount = $row_cl['amount_prvt'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td class="action-td">'.$row_cl['date'].'</td>
                                    <td colspan="2">'.$row_con['consumable'].'</td>
                                    <td class="action-td">'.$row_cl['qty_issued'].'</td>
                                    <td class="amt-td">'.$row_cl['price_prvt'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_cl['amount_prvt'];
                                $total_bill = $total_bill + $row_cl['amount_prvt'];
                        };
                    };
                
                $balance = $total_bill;
                $total_bill = number_format($total_bill, 2, '.', ',');
                echo '<tr>
                        <th class="amt-td" colspan="5">TOTAL</th>
                        <th class="amt-td">'.$total_bill.'</th>
                    </tr>
                    </tbody>
                </table>';
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>