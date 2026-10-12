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
        if(isset($_SESSION['nhis_specialty_detail_report_start_date']))
        {           
            $company_id = $_SESSION['nhis_specialty_detail_report_company_id'];
            $user_id = $_SESSION['nhis_specialty_detail_report_user_id'];
            $user_super_id = $_SESSION['nhis_specialty_detail_report_user_super_id'];
            $start_date = $_SESSION['nhis_specialty_detail_report_start_date'];
            $end_date = $_SESSION['nhis_specialty_detail_report_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
            <table class="table table-hover table-bordered table-sm" id="nhis_specialty_detail_report_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="17"><H2><?php echo $row_company['trading_name'];?></H2></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="17"><H6>LEDGER SUMMARY REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                    </tr>
                    <tr>
                        <th class = "amt-td" colspan="17">
                            <a id="btn_convert_to_xml" href="#"
                                data-id="<?php echo $start_date;?>"
                                data-id1="<?php echo $end_date;?>"
                            >Convert to XML</a>
                        </th>
                    </tr>
                    <tr>
                        <th class="action-td">S/NO</th>
                        <th class="action-td">SURENAME</th>
                        <th class="action-td">OTHER NAMES</th>
                        <th class="action-td">DATE ADMIT</th>
                        <th class="action-td">DATE DISCH.</th>
                        <th class="action-td">AGE</th>
                        <th class="action-td">GENDER</th>
                        <th class="action-td">FOLDER NO</th>
                        <th class="action-td">MEMBER NO</th>
                        <th class="action-td">CCC</th>
                        <th class="action-td">PROCEDURE</th>
                        <th class="action-td">DIAGNOSIS</th>
                        <th class="action-td">GDRG</th>
                        <th class="action-td">ICD-10</th>
                        <th class="action-td">SERVICE</th>
                        <th class="action-td">DRUGS</th>
                        <th class="action-td">TOTAL</th>

                    </tr>
                </thead>
                <tbody class="pv-table-body" id="nhis_specialty_detail_report_list_table_body">
            <?php
            $query = "SELECT P.*, A.attend_id, A.patient_id, A.date_admit, A.date_disch, A.tos_id, A.age, A.created_by, A.created_datetime, A.vetted  FROM `payment_type` AS P
            JOIN `attendance` AS A ON A.attend_id = P.attend_id WHERE P.ledger_id = 2 AND A.date_admit BETWEEN '$start_date' AND 
            '$end_date'";

            $service = 0;
            $drug = 0;
            $total = 0;

            $service_sum = 0;
            $drug_sum = 0;
            $total_sum = 0;

            $result = mysqli_query($con,$query);
            if (mysqli_num_rows($result) > 0)
            {
                $i = 0;
                while($row = mysqli_fetch_array($result))
                {
                    $i = ++$i;
                    $attend_id = $row['attend_id'];
                    $patient_id = $row['patient_id'];
                    $sql_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
                    $result_patient = mysqli_query($con,$sql_patient);
                    $row_patient = mysqli_fetch_array($result_patient);

                    $gender_id = $row_patient['gender'];
                    $query_gender = "SELECT * FROM `gender` WHERE `gender_id` = '$gender_id'";
                    $query_run_gender = mysqli_query($con, $query_gender);
                    $row_gender = mysqli_fetch_assoc($query_run_gender);

                    $tos_id = $row['tos_id'];
                    $query_tos = "SELECT * FROM `type_of_service` WHERE `tos_id` = '$tos_id'";
                    $query_run_tos = mysqli_query($con, $query_tos);
                    $row_tos = mysqli_fetch_assoc($query_run_tos);
                    

                    $created_by_id = $row['created_by'];
                    $query_cb = "SELECT * FROM users WHERE id='$created_by_id'";
                    $query_run_cb = mysqli_query($con, $query_cb);
                    if(!empty($query_run_cb) && mysqli_num_rows($query_run_cb) > 0)
                    {
                        $row_cb = mysqli_fetch_assoc($query_run_cb);
                        $creator = $row_cb['first_name'].''.$row_cb['last_name'];
                    }
                    else
                    {
                        $creator = 'Not Specified';
                    };
                    $service = 0;
                    $drug = 0;
                    $total = $service + $drug;

                    $query_dl = "SELECT * FROM `diagnosis_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_dl = mysqli_query($con, $query_dl);
                    $diagnosis_list = '';
                    if (mysqli_num_rows($query_run_dl) > 0)
                    {
                        while($row_dl = mysqli_fetch_assoc($query_run_dl))
                        {
                            $service = $service + $row_dl['amount_nhis'];
                            $service_sum = $service_sum + $row_dl['amount_nhis'];
                            $diagnosis_id = $row_dl['diagnosis_id'];
                            $query_diag = "SELECT * FROM `diagnosis` WHERE `diagnosis_id` = '$diagnosis_id'";
                            $query_run_diag = mysqli_query($con, $query_diag);
                            $row_diag = mysqli_fetch_assoc($query_run_diag);
                            if($diagnosis_list == '')
                            {
                                $diagnosis_list = $row_diag['diagnosis'];
                                $icd_10_list = $row_diag['icd_10'];
                            }
                            else
                            {
                                $diagnosis_list = $diagnosis_list.', '.$row_diag['diagnosis'];
                                $icd_10_list =  $icd_10_list.', '.$row_diag['icd_10'];
                            };
                        };
                    };
                    
                    $query_sl = "SELECT * FROM `surgery_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_sl = mysqli_query($con, $query_sl);
                    $surgery_list = '';
                    if (mysqli_num_rows($query_run_sl) > 0)
                    {
                        while($row_sl = mysqli_fetch_assoc($query_run_sl))
                        {
                            $service = $service + $row_sl['amount_nhis'];
                            $service_sum = $service_sum + $row_sl['amount_nhis'];
                            $surgery_id = $row_sl['surgery_id'];
                            $query_surg = "SELECT * FROM `surgery` WHERE `surgery_id` = '$surgery_id'";
                            $query_run_surg = mysqli_query($con, $query_surg);
                            $row_surg = mysqli_fetch_assoc($query_run_surg);
                            if($surgery_list == '')
                            {
                                $surgery_list = $row_surg['surgery'];
                                $icd_10_list = $row_surg['icd_10'];
                            }
                            else
                            {
                                $surgery_list = $surgery_list.', '.$row_surg['surgery'];
                                $icd_10_list = $icd_10_list.', '.$row_surg['icd_10'];
                            };
                        };
                    };
                    if($row['vetted']=='Yes')
                    {
                        echo '<tr style="background-color:#cbf7d3; color:black">';
                    }
                    else
                    {
                        echo '<tr>';
                    };
                    ?>
                        <td class="action-td"><?php echo $i;?></td>
                        <td >
                            <a id="btn_open_claim_form" href="#"
                                data-id="<?php echo $row['attend_id'];?>"
                                data-id1="<?php echo $row['patient_id'];?>"
                                data-id2="<?php echo $row['pay_type_id'];?>"
                                data-id3="<?php echo $row['date_admit'];?>"
                                data-id4="<?php echo $row['date_disch'];?>"
                                data-id5="<?php echo $row_patient['firstName'].' '.$row_patient['lastName'];?>"
                            >
                                <?php echo $row_patient['lastName'];?>
                            </a>
                        </td>
                        <td >
                            <a id="btn_open_claim_form" href="#"
                                data-id="<?php echo $row['attend_id'];?>"
                                data-id1="<?php echo $row['patient_id'];?>"
                                data-id2="<?php echo $row['pay_type_id'];?>"
                                data-id3="<?php echo $row['date_admit'];?>"
                                data-id4="<?php echo $row['date_disch'];?>"
                                data-id5="<?php echo $row_patient['firstName'].' '.$row_patient['lastName'];?>"
                            >
                                <?php echo $row_patient['firstName'];?>
                            </a>
                        </td>
                        <td ><?php echo $row['date_admit'];?></td>
                        <td ><?php echo $row['date_disch'];?></td>
                        <td class="action-td"><?php echo $row['age'];?></td>
                        <td class="action-td"><?php echo $row_gender['gender'];?></td>
                        <td ><?php echo $row_patient['folderNo'];?></td>
                        <td ><?php echo $row['member_no'];?></td>
                        <td ><?php echo $row['code'];?></td>
                        <td ><?php if(isset($surgery_list)){echo $surgery_list;};?></td>
                        <td ><?php if(isset($diagnosis_list)){echo $diagnosis_list;};?></td>
                        <td ><?php echo $row['member_no'];?></td>
                        <td ><?php if(isset($icd_10_list)){echo $icd_10_list;};?></td>
                        <?php

                            $query_svl = "SELECT * FROM `service_list` WHERE `attend_id` = '$attend_id'";
                            $query_run_svl = mysqli_query($con, $query_svl);
                            if (mysqli_num_rows($query_run_svl) > 0)
                            {
                                while($row_svl = mysqli_fetch_assoc($query_run_svl))
                                {
                                    $service = $service + $row_svl['amount_nhis'];
                                    $service_sum = $service_sum + $row_svl['amount_nhis'];
                                };
                            };

                            $query_ll = "SELECT * FROM `lab_list` WHERE `attend_id` = '$attend_id'";
                            $query_run_ll = mysqli_query($con, $query_ll);
                            if (mysqli_num_rows($query_run_ll) > 0)
                            {
                                while($row_ll = mysqli_fetch_assoc($query_run_ll))
                                {
                                    $service = $service + $row_ll['amount_nhis'];
                                    $service_sum = $service_sum + $row_ll['amount_nhis'];
                                };
                            };

                            $query_rl = "SELECT * FROM `radio_list` WHERE `attend_id` = '$attend_id'";
                            $query_run_rl = mysqli_query($con, $query_rl);
                            if (mysqli_num_rows($query_run_rl) > 0)
                            {
                                while($row_rl = mysqli_fetch_assoc($query_run_rl))
                                {
                                    $service = $service + $row_rl['amount_nhis'];
                                    $service_sum = $service_sum + $row_rl['amount_nhis'];
                                };
                            };

                            $query_drl = "SELECT * FROM `drug_dispense_list` WHERE `attend_id` = '$attend_id'";
                            $query_run_drl = mysqli_query($con, $query_drl);
                            if (mysqli_num_rows($query_run_drl) > 0)
                            {
                                while($row_drl = mysqli_fetch_assoc($query_run_drl))
                                {
                                    $drug = $drug + $row_drl['amt_nhis'];
                                    $drug_sum = $drug_sum + $row_drl['amt_nhis'];
                                };
                            };
                            $service_f = number_format($service, 2, '.', ',');
                            $drug_f = number_format($drug, 2, '.', ',');
                            $total_f = number_format($total, 2, '.', ',');
                        ?>
                        <td class="amt-td"><?php echo $service_f;?></td>
                        <td class="amt-td"><?php echo $drug_f;?></td>
                        <td class="amt-td"><?php echo $total_f;?></td>
                    </tr>
                    <?php
                    if($row['vetted']=='Yes')
                    {
                        echo '<tr style="background-color:#cbf7d3; color:black">';
                    }
                    else
                    {
                        echo '<tr>';
                    };
                        echo '<td colspan="17" class="action-td"><small>Created by: '.$creator.' - '.$row['created_datetime'].'</small></td>
                    </tr>';
                };
            };
                            $service_sum_f = number_format($service_sum, 2, '.', ',');
                            $drug_sum_f = number_format($drug_sum, 2, '.', ',');
                            $total_f = number_format($total, 2, '.', ',');
        ?>
                    <tr>
                        <th class="action-td" colspan="13">GRAND TOTAL</th>
                        <th class="amt-td"><?php echo $service_sum_f;?></th>
                        <th class="amt-td"><?php echo $drug_sum_f;?></th>
                        <th class="amt-td"><?php echo $total_f;?></th>
                    </tr>
                </tbody>
        </table>
<?php    
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>