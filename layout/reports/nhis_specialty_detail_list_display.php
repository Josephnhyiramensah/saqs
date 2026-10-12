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
    if(isset($_SESSION['nhis_specialty_detail_list_start_date']))
    {           
        $company_id = $_SESSION['company_id'];
        $start_date = $_SESSION['nhis_specialty_detail_list_start_date'];
        $end_date = $_SESSION['nhis_specialty_detail_list_end_date'];
        $code = $_SESSION['nhis_specialty_detail_list_code'];
        $tos_id = $_SESSION['nhis_specialty_detail_list_tos_id'];

        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);

        //SET ARRAYS
            $opd_array = array();
            $zoom_array = array();
            $anc_array = array();

            array_push($opd_array, 'OPDC01A','OPDC03A','OPDC04A','OPDC05A','OPDC06A','OPDC07A',
            'OPDC08A','OPDC09A','OPDC10A','OPDC11A','OPDC12A','OPDC13A','OPDC14A','OPDC15A',
            'OPDC16A','OPDC17A','OPDC18A','OPDC19A','OPDC20A','OPDC01C','OPDC03C','OPDC04C',
            'OPDC05C','OPDC06C','OPDC07C','OPDC08C','OPDC09C','OPDC10C','OPDC11C','OPDC12C',
            'OPDC13C','OPDC14C','OPDC15C','OPDC16C','OPDC17C','OPDC18C','OPDC19C','OPDC20C'
            );

            array_push($anc_array, 'OPDC02A','OPDC02C'
            );

            array_push($zoom_array, 'ZOOM01A','ZOOM03A','ZOOM04A','ZOOM05A','ZOOM06A','ZOOM07A',
            'ZOOM08A','ZOOM09A','ZOOM10A','ZOOM11A','ZOOM12A','ZOOM13A','ZOOM14A','ZOOM15A',
            'ZOOM16A','ZOOM17A','ZOOM18A','ZOOM19A','ZOOM20A','ZOOM01C','ZOOM03C','ZOOM04C',
            'ZOOM05C','ZOOM06C','ZOOM07C','ZOOM08C','ZOOM09C','ZOOM10C','ZOOM11C','ZOOM12C',
            'ZOOM13C','ZOOM14C','ZOOM15C','ZOOM16C','ZOOM17C','ZOOM18C','ZOOM19C','ZOOM20C'
            );
            if($code == 'OPD')
            {
                $list = implode(",", $opd_array);
            }
            else if($code == 'ANC')
            {
                $list = implode(",", $anc_array);
            }
            else if($code == 'ZOOM')
            {
                $list = implode(",", $zoom_array);
            };

        echo '<table class="table table-hover table-bordered table-sm" id="nhis_specialty_detail_report_list_table" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class = "action-td" colspan="18"><H2>'.$row_company['trading_name'].'</H2></th>
                </tr>
                <tr>
                    <th class = "action-td" colspan="18"><H6>LEDGER SUMMARY REPORT FROM '.$start_date.' TO '.$end_date.'/H6></th>
                </tr>
                <tr>
                    <th class = "amt-td" colspan="18">
                        <a id="btn_convert_to_xml" href="#"
                            data-id="'.$start_date.'"
                            data-id1="'.$end_date.'"
                        >Convert to XML</a>
                    </th>
                </tr>
                <tr>
                    <th class="action-td">S/NO</th>
                    <th class="action-td">SURENAME</th>
                    <th class="action-td">OTHER NAMES</th>
                    <th class="action-td">DATE ADMIT</th>
                    <th class="action-td">DATE DISCH.</th>
                    <th class="action-td">TYPE</th>
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
            <tbody class="pv-table-body" id="nhis_specialty_detail_report_list_table_body">';
                if($code == 'OPD' || $code == 'ANC' || $code == 'ZOOM')
                {
                    $query = "SELECT P.*, A.attend_id, A.patient_id, A.date_admit, A.date_disch, A.tos_id, A.age, 
                    A.created_by, A.created_datetime, A.vetted FROM `payment_type` AS P JOIN `attendance` AS A ON 
                    A.attend_id = P.attend_id WHERE A.tos_id = '$tos_id' AND A.date_admit 
                    BETWEEN '$start_date' AND '$end_date' AND FIND_IN_SET(P.specialty_code, '$list')";
                }
                else
                {
                    $query = "SELECT P.*, A.attend_id, A.patient_id, A.date_admit, A.date_disch, A.tos_id, A.age, 
                    A.created_by, A.created_datetime, A.vetted FROM `payment_type` AS P JOIN `attendance` AS A ON 
                    A.attend_id = P.attend_id WHERE A.tos_id = '$tos_id' AND P.specialty_1 = '$code' AND A.date_admit 
                    BETWEEN '$start_date' AND '$end_date'";
                };
                $service = 0;   $drug = 0;  $total = 0;     $service_sum = 0;   $drug_sum = 0;  $total_sum = 0;
                $result = mysqli_query($con,$query);
                if (mysqli_num_rows($result) > 0)
                {
                    $i = 0;
                    while($row = mysqli_fetch_array($result))
                    {
                        $i++;
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

                        //DIAGNOSIS
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
                                    if(!empty($query_run_diag) && mysqli_num_rows($query_run_diag) > 0)
                                    {
                                        $row_diag = mysqli_fetch_assoc($query_run_diag);
                                        $diagnosis_item = $row_diag['diagnosis'];
                                        $icd_10_item = $row_diag['icd_10'];

                                    }
                                    else
                                    {
                                        $diagnosis_item = 'Not Specified';
                                        $icd_10_item = 'Not Specified';
                                    };

                                    if($diagnosis_list == '')
                                    {
                                        $diagnosis_list = $diagnosis_item;
                                        $icd_10_list = $icd_10_item;
                                    }
                                    else
                                    {
                                        $diagnosis_list = $diagnosis_list.', '.$diagnosis_item;
                                        $icd_10_list =  $icd_10_list.', '.$icd_10_item;
                                    };
                                };
                            };
                        //SURGERIES
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
                        
                            echo '<td class="action-td">'.$i.'</td>
                            <td >
                                <a id="btn_open_claim_form" href="#"
                                    data-id="'.$row['attend_id'].'"
                                    data-id1="'.$row['patient_id'].'"
                                    data-id2="'.$row['pay_type_id'].'"
                                    data-id3="'.$row['date_admit'].'"
                                    data-id4="'.$row['date_disch'].'"
                                    data-id5="'.$row_patient['firstName'].' '.$row_patient['lastName'].'"
                                >
                                    '.$row_patient['lastName'].'
                                </a>
                            </td>
                            <td >
                                <a id="btn_open_claim_form" href="#"
                                    data-id="'.$row['attend_id'].'"
                                    data-id1="'.$row['patient_id'].'"
                                    data-id2="'.$row['pay_type_id'].'"
                                    data-id3="'.$row['date_admit'].'"
                                    data-id4="'.$row['date_disch'].'"
                                    data-id5="'.$row_patient['firstName'].' '.$row_patient['lastName'].'"
                                >
                                    '.$row_patient['firstName'].'
                                </a>
                            </td>
                            <td >'.$row['date_admit'].'</td>
                            <td >'.$row['date_disch'].'</td>
                            <td >'.$row_tos['description'].'</td>
                            <td class="action-td">'.$row['age'].'</td>
                            <td class="action-td">'.$row_gender['gender'].'</td>
                            <td >'.$row_patient['folderNo'].'</td>
                            <td >'.$row['member_no'].'</td>
                            <td >'.$row['code'].'</td>
                            <td >';
                                if(isset($surgery_list)){echo $surgery_list;};
                            echo '</td>
                            <td >';
                                if(isset($diagnosis_list)){echo $diagnosis_list;};
                            echo '</td>
                            <td >'.$row['member_no'].'</td>
                            <td >';
                                if(isset($icd_10_list)){echo $icd_10_list;};
                            echo '</td>';
                            

                            //SERVICES
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
                            //LABS
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
                            //RADIOLOGY
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
                            //DRUGS
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
                                $total = $service + $drug;
                                $service_f = number_format($service, 2, '.', ',');
                                $drug_f = number_format($drug, 2, '.', ',');
                                $total_f = number_format($total, 2, '.', ',');
                            
                            echo '<td class="amt-td">'.$service_f.'</td>
                            <td class="amt-td">'.$drug_f.'</td>
                            <td class="amt-td">'.$total_f.'</td>
                        </tr>';
                        
                        if($row['vetted']=='Yes')
                        {
                            echo '<tr style="background-color:#cbf7d3; color:black">';
                        }
                        else
                        {
                            echo '<tr>';
                        };
                            echo '<td colspan="18" class="action-td"><small>Created by: '.$creator.' - '.$row['created_datetime'].'</small></td>
                        </tr>';
                    };
                };
                $service_sum_f = number_format($service_sum, 2, '.', ',');
                $drug_sum_f = number_format($drug_sum, 2, '.', ',');
                $total_f = number_format($total, 2, '.', ',');
                
                echo '<tr>
                    <th class="action-td" colspan="13">GRAND TOTAL</th>
                    <th class="amt-td">'.$service_sum_f.'</th>
                    <th class="amt-td">'.$drug_sum_f.'</th>
                    <th class="amt-td">'.$total_f.'</th>
                </tr>
            </tbody>
        </table>';
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>