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
    if(isset($_SESSION['doctors_attend_register_start_date']))
    {           
        $company_id = $_SESSION['company_id'];
        $start_date = $_SESSION['doctors_attend_register_start_date'];
        $end_date = $_SESSION['doctors_attend_register_end_date'];
        $doctor = $_SESSION['doctors_attend_register_doctor'];
        $branch = $_SESSION['doctors_attend_register_branch'];

        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);


        if($branch == 'ALL')
        {
            if($doctor == 'ALL')
            {
                $query_dar = "SELECT * FROM `doctors_attend` WHERE `date` BETWEEN '$start_date' AND '$end_date' ORDER BY `user_id` ASC";
            }
            else
            {
                $query_dar = "SELECT * FROM `doctors_attend` WHERE `date` BETWEEN '$start_date' AND '$end_date' AND `user_id` = '$doctor' ORDER BY `user_id` ASC";
            };
        }
        else
        {
            if($doctor == 'ALL')
            {
                $query_dar = "SELECT * FROM `doctors_attend` WHERE `date` BETWEEN '$start_date' AND '$end_date' AND `branch_id` = '$branch' ORDER BY `user_id` ASC";
            }
            else
            {
                $query_dar = "SELECT * FROM `doctors_attend` WHERE `date` BETWEEN '$start_date' AND '$end_date' AND `user_id` = '$doctor' AND `branch_id` = '$branch' ORDER BY `user_id` ASC";
            };
        };
        $query_run_dar = mysqli_query($con, $query_dar);
                
        echo '<table class="table table-hover table-bordered table-sm" id="stock_report_list_table" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class = "action-td" colspan="14"><H3>'.$row_company['trading_name'].'</H3></th>
                </tr>
                <tr>
                    <th class = "action-td" colspan="14"><H6>DOCTORS ATTENDANCE REGISTER FROM '.$start_date.' TO '.$end_date.'</H6></th>
                </tr>
                <tr style="background-color:#E4DCCF; color:black">
                    <th class="action-td">S/NO</th>
                    <th class="action-td">DOCTOR</th>
                    <th class="action-td">ATTD. TYPE</th>
                    <th class="action-td">DATE ADMIT.</th>
                    <th class="action-td">DATE DISCH.</th>
                    <th class="action-td">DURATION</th>
                    <th class="action-td">PATIENT NAME</th>
                    <th class="action-td">AGE</th>
                    <th class="action-td">GENDER</th>
                    <th class="action-td">TYPE OF SERVICE</th>
                    <th class="action-td">DIAGNOSIS</th>
                    <th class="action-td">PROCEDURE</th>
                    <th class="action-td">CLINIC</th>
                    <th class="action-td">PAYMENT TYPE</th>
                </tr>
            </thead>
            <tbody class="pv-table-body" id="stock_report_list_table_body">';
            
            if (mysqli_num_rows($query_run_dar) > 0) 
            {
                $i=0;
                while($row_dar = mysqli_fetch_array($query_run_dar))
                {
                    $i++;
                    $attend_id = $row_dar['attend_id'];
                    $query = "SELECT * FROM `attendance` WHERE `attend_id`= '$attend_id'";
                    $query_run = mysqli_query($con, $query);
                        ?>
                        <?php 
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                            $doctor_id = $row_dar['user_id'];
                            $patient_id = $row['patient_id'];

                            $date_admitted1 = $row['date_admit'];
                            $date_discharged1 = $row['date_disch'];

                            $datetime1 = strtotime($date_admitted1);
                            $datetime2 = strtotime($date_discharged1);
                            if($datetime2 > $datetime1)
                            {
                                $secs = $datetime2 - $datetime1;
                                $days = $secs / 86400;
                            }
                            else if($datetime2 < $datetime1)
                            {
                                $secs = $datetime2 - $datetime1;
                                $days = 'discharge date cannot be earlier than admission date';
                            }
                            else if($datetime2 == $datetime1)
                            {
                                $secs = 1;
                                $days = 1;
                            };

                            $query_doctor = "SELECT * FROM `users` WHERE `id` = '$doctor_id'";
                            $query_run_doctor = mysqli_query($con, $query_doctor);
                            $row_doctor = mysqli_fetch_assoc($query_run_doctor);

                            $query_patient = "SELECT * FROM `patients` WHERE `patient_id` = '$patient_id'";
                            $query_run_patient = mysqli_query($con, $query_patient);
                            $row_patient = mysqli_fetch_assoc($query_run_patient);

                            $gender_id = $row_patient['gender'];
                            $query_gender = "SELECT * FROM `gender` WHERE `gender_id` = '$gender_id'";
                            $query_run_gender = mysqli_query($con, $query_gender);
                            $row_gender = mysqli_fetch_assoc($query_run_gender);

                            $query_attend = "SELECT * FROM `attendance` WHERE `attend_id` = '$attend_id'";
                            $query_run_attend = mysqli_query($con, $query_attend);
                            $row_attend = mysqli_fetch_assoc($query_run_attend);

                            $tos_id = $row_attend['tos_id'];
                            $query_tos = "SELECT * FROM `type_of_service` WHERE `tos_id` = '$tos_id'";
                            $query_run_tos = mysqli_query($con, $query_tos);
                            $row_tos = mysqli_fetch_assoc($query_run_tos);

                            $clinic_id = $row_attend['clinic_id'];
                            $query_clinic = "SELECT * FROM `clinics` WHERE `clinic_id` = '$clinic_id'";
                            $query_run_clinic = mysqli_query($con, $query_clinic);
                            $row_clinic = mysqli_fetch_assoc($query_run_clinic);
                            
                            $query_dl = "SELECT * FROM `diagnosis_list` WHERE `attend_id` = '$attend_id'";
                            $query_run_dl = mysqli_query($con, $query_dl);
                            $diagnosis_list = '';
                            if (mysqli_num_rows($query_run_dl) > 0)
                            {
                                while($row_dl = mysqli_fetch_assoc($query_run_dl))
                                {
                                    $diagnosis_id = $row_dl['diagnosis_id'];
                                    $query_diagnosis = "SELECT * FROM `diagnosis` WHERE `diagnosis_id` = '$diagnosis_id'";
                                    $query_run_diagnosis = mysqli_query($con, $query_diagnosis);
                                    if (mysqli_num_rows($query_run_diagnosis) > 0)
                                    {
                                        $row_diagnosis = mysqli_fetch_assoc($query_run_diagnosis);
                                        $diagnosis_list = $diagnosis_list.' '.$row_diagnosis['diagnosis'];
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
                                    $surgery_id = $row_sl['surgery_id'];
                                    $query_surgery = "SELECT * FROM `surgery` WHERE `surgery_id` = '$surgery_id'";
                                    $query_run_surgery = mysqli_query($con, $query_surgery);
                                    if (mysqli_num_rows($query_run_surgery) > 0)
                                    {
                                        $row_surgery = mysqli_fetch_assoc($query_run_surgery);
                                        $surgery_list = $surgery_list.' '.$row_surgery['surgery'];
                                    };
                                };
                            };
                                    
                            $query_paytype = "SELECT * FROM `payment_type` WHERE `attend_id` = '$attend_id' AND `principal` = 'yes'";
                            $query_run_paytype = mysqli_query($con, $query_paytype);
                            if (mysqli_num_rows($query_run_paytype) > 0)
                            {
                                $row_paytype = mysqli_fetch_assoc($query_run_paytype);
                                $paytype_ledger_id = $row_paytype['ledger_id'];

                                $query_paytype_ledger = "SELECT * FROM `ledgers` WHERE `ledger_id` = '$paytype_ledger_id'";
                                $query_run_paytype_ledger = mysqli_query($con, $query_paytype_ledger);
                                if (mysqli_num_rows($query_run_paytype_ledger) > 0)
                                {
                                    $row_paytype_ledger = mysqli_fetch_assoc($query_run_paytype_ledger);
                                    $paytype_ledger = $row_paytype_ledger['ledger_desc'];
                                }
                                else
                                {
                                    $paytype_ledger = 'Not Specified';
                                };
                            }else
                            {
                                $paytype_ledger = 'Not Specified';
                            };
                            
                            echo '<tr>
                                <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$i.'</a></td>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_doctor['first_name'].'</a></td>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_dar['type'].'</a></td>
                                <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['date_admit'].'</a></td>
                                <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['date_disch'].'</a></td>
                                <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$days.'</a></td>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_patient['firstName'].' '.$row_patient['lastName'].'</a></td>
                                <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_attend['age'].'</a></td>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_gender['gender'].'</a></td>
                                <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_tos['description'].'</a></td>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">';if(isset($diagnosis_list)){echo $diagnosis_list;}else{echo 'N/A';}; echo'</a></td>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'; if (isset($surgery_list)){echo $surgery_list;}else{echo 'N/A';}; echo'</a></td>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_clinic['clinic_desc'].'</a></td>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$paytype_ledger.'</a></td>
                            </tr>';
                        };
                    };
                };
            };
            echo '</tbody>
        </table>';
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>