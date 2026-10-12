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
        if(isset($_SESSION['nhis_specialty_report_start_date']))
        {           
            $company_id = $_SESSION['nhis_specialty_report_company_id'];
            $start_date = $_SESSION['nhis_specialty_report_start_date'];
            $end_date = $_SESSION['nhis_specialty_report_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
            
            
            echo '<table class="table table-hover table-bordered table-sm" id="nhis_specialty_summary_report_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="7"><H2>'.$row_company['trading_name'].'</H2></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="7"><H6>SPECIALTY SUMMARY REPORT FROM '.$start_date.' TO '.$end_date.'</H6></th>
                    </tr>
                    <tr>
                        <th class="action-td">SPECIALTY</th>
                        <th class="action-td">CODE</th>
                        <th class="action-td">ATTN.</th>
                        <th class="action-td">SERVICE</th>
                        <th class="action-td">DRUGS</th>
                        <th class="action-td">TOTAL</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body" id="nhis_specialty_summary_report_list_table_body">';
            
                $query = "SELECT P.*, A.attend_id, A.patient_id, A.date_admit, A.date_disch, A.tos_id, A.age, 
                A.created_by, A.created_datetime, A.vetted, A.clinic_id FROM `payment_type` AS P JOIN `attendance` 
                AS A ON A.attend_id = P.attend_id WHERE P.ledger_id = 2 AND P.principal = 'Yes' AND A.date_admit 
                BETWEEN '$start_date' AND '$end_date'";

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
                    
                    array_push($anc_array, 'OPDC02A','OPDC02C');

                    array_push($zoom_array, 'ZOOM01A','ZOOM03A','ZOOM04A','ZOOM05A','ZOOM06A','ZOOM07A',
                    'ZOOM08A','ZOOM09A','ZOOM10A','ZOOM11A','ZOOM12A','ZOOM13A','ZOOM14A','ZOOM15A',
                    'ZOOM16A','ZOOM17A','ZOOM18A','ZOOM19A','ZOOM20A','ZOOM01C','ZOOM03C','ZOOM04C',
                    'ZOOM05C','ZOOM06C','ZOOM07C','ZOOM08C','ZOOM09C','ZOOM10C','ZOOM11C','ZOOM12C',
                    'ZOOM13C','ZOOM14C','ZOOM15C','ZOOM16C','ZOOM17C','ZOOM18C','ZOOM19C','ZOOM20C'
                    );

                //IN-PATIENT
                    $IPD_ASUR = 0;      $IPD_ASUR_S = 0;          $IPD_ASUR_D = 0;      $IPD_ASUR_T = 0;
                    $IPD_DENT = 0;      $IPD_DENT_S = 0;          $IPD_DENT_D = 0;      $IPD_DENT_T = 0;
                    $IPD_ENTH = 0;      $IPD_ENTH_S = 0;          $IPD_ENTH_D = 0;      $IPD_ENTH_T = 0;
                    $IPD_MEDI = 0;      $IPD_MEDI_S = 0;          $IPD_MEDI_D = 0;      $IPD_MEDI_T = 0;
                    $IPD_OBGY = 0;      $IPD_OBGY_S = 0;          $IPD_OBGY_D = 0;      $IPD_OBGY_T = 0;
                    $IPD_OPDC = 0;      $IPD_OPDC_S = 0;          $IPD_OPDC_D = 0;      $IPD_OPDC_T = 0;
                    $IPD_OPDC_ANC = 0;  $IPD_OPDC_ANC_S = 0;      $IPD_OPDC_ANC_D = 0;  $IPD_OPDC_ANC_T = 0;
                    $IPD_OPDC_ZOOM = 0; $IPD_OPDC_ZOOM_S = 0;     $IPD_OPDC_ZOOM_D = 0; $IPD_OPDC_ZOOM_T = 0;
                    $IPD_OPHT = 0;      $IPD_OPHT_S = 0;          $IPD_OPHT_D = 0;      $IPD_OPHT_T = 0;
                    $IPD_ORTH = 0;      $IPD_ORTH_S = 0;          $IPD_ORTH_D = 0;      $IPD_ORTH_T = 0;
                    $IPD_PAED = 0;      $IPD_PAED_S = 0;          $IPD_PAED_D = 0;      $IPD_PAED_T = 0;
                    $IPD_PSUR = 0;      $IPD_PSUR_S = 0;          $IPD_PSUR_D = 0;      $IPD_PSUR_T = 0;
                    $IPD_RSUR = 0;      $IPD_RSUR_S = 0;          $IPD_RSUR_D = 0;      $IPD_RSUR_T = 0;
                    $TOTAL_IPD = 0; $TOTAL_IPD_SERVICE = 0;     $TOTAL_IPD_DRUG = 0;    $TOTAL_IPD_TOTAL = 0;

                //OUT-PATIENT
                    $OPD_ASUR = 0;      $OPD_ASUR_S = 0;          $OPD_ASUR_D = 0;      $OPD_ASUR_T = 0;
                    $OPD_DENT = 0;      $OPD_DENT_S = 0;          $OPD_DENT_D = 0;      $OPD_DENT_T = 0;
                    $OPD_ENTH = 0;      $OPD_ENTH_S = 0;          $OPD_ENTH_D = 0;      $OPD_ENTH_T = 0;
                    $OPD_MEDI = 0;      $OPD_MEDI_S = 0;          $OPD_MEDI_D = 0;      $OPD_MEDI_T = 0;
                    $OPD_OBGY = 0;      $OPD_OBGY_S = 0;          $OPD_OBGY_D = 0;      $OPD_OBGY_T = 0;
                    $OPD_OPDC = 0;      $OPD_OPDC_S = 0;          $OPD_OPDC_D = 0;      $OPD_OPDC_T = 0;
                    $OPD_OPDC_ANC = 0;  $OPD_OPDC_ANC_S = 0;      $OPD_OPDC_ANC_D = 0;  $OPD_OPDC_ANC_T = 0;
                    $OPD_OPDC_ZOOM = 0; $OPD_OPDC_ZOOM_S = 0;     $OPD_OPDC_ZOOM_D = 0; $OPD_OPDC_ZOOM_T = 0;
                    $OPD_OPHT = 0;      $OPD_OPHT_S = 0;          $OPD_OPHT_D = 0;      $OPD_OPHT_T = 0;
                    $OPD_ORTH = 0;      $OPD_ORTH_S = 0;          $OPD_ORTH_D = 0;      $OPD_ORTH_T = 0;
                    $OPD_PAED = 0;      $OPD_PAED_S = 0;          $OPD_PAED_D = 0;      $OPD_PAED_T = 0;
                    $OPD_PSUR = 0;      $OPD_PSUR_S = 0;          $OPD_PSUR_D = 0;      $OPD_PSUR_T = 0;
                    $OPD_RSUR = 0;      $OPD_RSUR_S = 0;          $OPD_RSUR_D = 0;      $OPD_RSUR_T = 0;
                    $TOTAL_OPD = 0; $TOTAL_OPD_SERVICE = 0;     $TOTAL_OPD_DRUG = 0;    $TOTAL_OPD_TOTAL = 0;

                    $service_sum = 0;
                    $drug_sum = 0;
                    $total_sum = 0;
                $result = mysqli_query($con,$query);
                if (mysqli_num_rows($result) > 0)
                {
                    $i = 0;
                    while($row = mysqli_fetch_array($result))
                    {
                        $i++;
                        $attend_id = $row['attend_id'];
                        $patient_id = $row['patient_id'];
                        $code = $row['specialty_code'];
                        $service = 0;
                        $drug = 0;
                        $total = 0;
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
                        $total_sum = $service_sum + $drug_sum;

                        //IN-PATIENT
                            if($row['tos_id']==2 && $row['specialty_1']=='ASUR')
                            {
                                $IPD_ASUR++;    $IPD_ASUR_S = $IPD_ASUR_S + $service;   $IPD_ASUR_D = $IPD_ASUR_D + $drug;      $IPD_ASUR_T = $IPD_ASUR_T + $total;
                            };
                            if($row['tos_id']==2 && $row['specialty_1']=='DENT')
                            {
                                $IPD_DENT++;    $IPD_DENT_S = $IPD_DENT_S + $service;   $IPD_DENT_D = $IPD_DENT_D + $drug;      $IPD_DENT_T = $IPD_DENT_T + $total;
                            };
                            if($row['tos_id']==2 && $row['specialty_1']=='ENTH')
                            {
                                $IPD_ENTH++;    $IPD_ENTH_S = $IPD_ENTH_S + $service;   $IPD_ENTH_D = $IPD_ENTH_D + $drug;      $IPD_ENTH_T = $IPD_ENTH_T + $total;
                            };
                            if($row['tos_id']==2 && $row['specialty_1']=='MEDI')
                            {
                                $IPD_MEDI++;    $IPD_MEDI_S = $IPD_MEDI_S + $service;   $IPD_MEDI_D = $IPD_MEDI_D + $drug;      $IPD_MEDI_T = $IPD_MEDI_T + $total;
                            };
                            if($row['tos_id']==2 && $row['specialty_1']=='OBGY')
                            {
                                $IPD_OBGY++;    $IPD_OBGY_S = $IPD_OBGY_S + $service;   $IPD_OBGY_D = $IPD_OBGY_D + $drug;      $IPD_OBGY_T = $IPD_OBGY_T + $total;
                            };
                            if($row['tos_id']==2 && $row['specialty_1']=='OPDC' && in_array($code, $opd_array))
                            {
                                $IPD_OPDC++;    $IPD_OPDC_S = $IPD_OPDC_S + $service;   $IPD_OPDC_D = $IPD_OPDC_D + $drug;      $IPD_OPDC_T = $IPD_OPDC_T + $total;
                            };
                            if($row['tos_id']==2 && $row['specialty_1']=='OPDC' &&  in_array($code, $anc_array))
                            {
                                $IPD_OPDC_ANC++;    $IPD_OPDC_ANC_S = $IPD_OPDC_ANC_S + $service;   $IPD_OPDC_ANC_D = $IPD_OPDC_ANC_D + $drug;      $IPD_OPDC_ANC_T = $IPD_OPDC_ANC_T + $total;
                            };
                            if($row['tos_id']==2 && $row['specialty_1']=='OPDC' &&  in_array($code, $zoom_array))
                            {
                                $IPD_OPDC_ZOOM++;    $IPD_OPDC_ZOOM_S = $IPD_OPDC_ZOOM_S + $service;   $IPD_OPDC_ZOOM_D = $IPD_OPDC_ZOOM_D + $drug;      $IPD_OPDC_ZOOM_T = $IPD_OPDC_ZOOM_T + $total;
                            };
                            if($row['tos_id']==2 && $row['specialty_1']=='OPHT')
                            {
                                $IPD_OPHT++;    $IPD_OPHT_S = $IPD_OPHT_S + $service;   $IPD_OPHT_D = $IPD_OPHT_D + $drug;      $IPD_OPHT_T = $IPD_OPHT_T + $total;
                            };
                            if($row['tos_id']==2 && $row['specialty_1']=='ORTH')
                            {
                                $IPD_ORTH++;    $IPD_ORTH_S = $IPD_ORTH_S + $service;   $IPD_ORTH_D = $IPD_ORTH_D + $drug;      $IPD_ORTH_T = $IPD_ORTH_T + $total;
                            };
                            if($row['tos_id']==2 && $row['specialty_1']=='PAED')
                            {
                                $IPD_PAED++;    $IPD_PAED_S = $IPD_PAED_S + $service;   $IPD_PAED_D = $IPD_PAED_D + $drug;      $IPD_PAED_T = $IPD_PAED_T + $total;
                            };
                            if($row['tos_id']==2 && $row['specialty_1']=='PSUR')
                            {
                                $IPD_PSUR++;    $IPD_PSUR_S = $IPD_PSUR_S + $service;   $IPD_PSUR_D = $IPD_PSUR_D + $drug;      $IPD_PSUR_T = $IPD_PSUR_T + $total;
                            };
                            if($row['tos_id']==2 && $row['specialty_1']=='RSUR')
                            {
                                $IPD_RSUR++;    $IPD_RSUR_S = $IPD_RSUR_S + $service;   $IPD_RSUR_D = $IPD_RSUR_D + $drug;      $IPD_RSUR_T = $IPD_RSUR_T + $total;
                            };
                            
                            if($row['tos_id']==2)
                            {
                                $TOTAL_IPD = $TOTAL_IPD + 1; $TOTAL_IPD_SERVICE = $TOTAL_IPD_SERVICE + $service;     $TOTAL_IPD_DRUG = $TOTAL_IPD_DRUG + $drug;    $TOTAL_IPD_TOTAL = $TOTAL_IPD_TOTAL + $total;
                            };

                        //OUT-PATIENT
                            if($row['tos_id']==1 && $row['specialty_1']=='ASUR')
                            {
                                $OPD_ASUR++;    $OPD_ASUR_S = $OPD_ASUR_S + $service;   $OPD_ASUR_D = $OPD_ASUR_D + $drug;      $OPD_ASUR_T = $OPD_ASUR_T + $total;
                            };
                            if($row['tos_id']==1 && $row['specialty_1']=='DENT')
                            {
                                $OPD_DENT++;    $OPD_DENT_S = $OPD_DENT_S + $service;   $OPD_DENT_D = $OPD_DENT_D + $drug;      $OPD_DENT_T = $OPD_DENT_T + $total;
                            };
                            if($row['tos_id']==1 && $row['specialty_1']=='ENTH')
                            {
                                $OPD_ENTH++;    $OPD_ENTH_S = $OPD_ENTH_S + $service;   $OPD_ENTH_D = $OPD_ENTH_D + $drug;      $OPD_ENTH_T = $OPD_ENTH_T + $total;
                            };
                            if($row['tos_id']==1 && $row['specialty_1']=='MEDI')
                            {
                                $OPD_MEDI++;    $OPD_MEDI_S = $OPD_MEDI_S + $service;   $OPD_MEDI_D = $OPD_MEDI_D + $drug;      $OPD_MEDI_T = $OPD_MEDI_T + $total;
                            };
                            if($row['tos_id']==1 && $row['specialty_1']=='OBGY')
                            {
                                $OPD_OBGY++;    $OPD_OBGY_S = $OPD_OBGY_S + $service;   $OPD_OBGY_D = $OPD_OBGY_D + $drug;      $OPD_OBGY_T = $OPD_OBGY_T + $total;
                            };
                            if($row['tos_id']==1 && $row['specialty_1']=='OPDC' && in_array($code, $opd_array))
                            {
                                $OPD_OPDC++;    $OPD_OPDC_S = $OPD_OPDC_S + $service;   $OPD_OPDC_D = $OPD_OPDC_D + $drug;      $OPD_OPDC_T = $OPD_OPDC_T + $total;
                            };
                            if($row['tos_id']==1 && $row['specialty_1']=='OPDC' && in_array($code, $anc_array))
                            {
                                $OPD_OPDC_ANC++;    $OPD_OPDC_ANC_S = $OPD_OPDC_ANC_S + $service;   $OPD_OPDC_ANC_D = $OPD_OPDC_ANC_D + $drug;      $OPD_OPDC_ANC_T = $OPD_OPDC_ANC_T + $total;
                            };
                            if($row['tos_id']==1 && $row['specialty_1']=='OPDC' && in_array($code, $zoom_array))
                            {
                                $OPD_OPDC_ZOOM++;    $OPD_OPDC_ZOOM_S = $OPD_OPDC_ZOOM_S + $service;   $OPD_OPDC_ZOOM_D = $OPD_OPDC_ZOOM_D + $drug;      $OPD_OPDC_ZOOM_T = $OPD_OPDC_ZOOM_T + $total;
                            };
                            if($row['tos_id']==1 && $row['specialty_1']=='OPHT')
                            {
                                $OPD_OPHT++;    $OPD_OPHT_S = $OPD_OPHT_S + $service;   $OPD_OPHT_D = $OPD_OPHT_D + $drug;      $OPD_OPHT_T = $OPD_OPHT_T + $total;
                            };
                            if($row['tos_id']==1 && $row['specialty_1']=='ORTH')
                            {
                                $OPD_ORTH++;    $OPD_ORTH_S = $OPD_ORTH_S + $service;   $OPD_ORTH_D = $OPD_ORTH_D + $drug;      $OPD_ORTH_T = $OPD_ORTH_T + $total;
                            };
                            if($row['tos_id']==1 && $row['specialty_1']=='PAED')
                            {
                                $OPD_PAED++;    $OPD_PAED_S = $OPD_PAED_S + $service;   $OPD_PAED_D = $OPD_PAED_D + $drug;      $OPD_PAED_T = $OPD_PAED_T + $total;
                            };
                            if($row['tos_id']==1 && $row['specialty_1']=='PSUR')
                            {
                                $OPD_PSUR++;    $OPD_PSUR_S = $OPD_PSUR_S + $service;   $OPD_PSUR_D = $OPD_PSUR_D + $drug;      $OPD_PSUR_T = $OPD_PSUR_T + $total;
                            };
                            if($row['tos_id']==1 && $row['specialty_1']=='RSUR')
                            {
                                $OPD_RSUR++;    $OPD_RSUR_S = $OPD_RSUR_S + $service;   $OPD_RSUR_D = $OPD_RSUR_D + $drug;      $OPD_RSUR_T = $OPD_RSUR_T + $total;
                            };
                            
                            if($row['tos_id']==1)
                            {
                                $TOTAL_OPD = $TOTAL_OPD + 1; $TOTAL_OPD_SERVICE = $TOTAL_OPD_SERVICE + $service;     $TOTAL_OPD_DRUG = $TOTAL_OPD_DRUG + $drug;    $TOTAL_OPD_TOTAL = $TOTAL_OPD_TOTAL + $total;
                            };
                    };
                };

                $IPD_ASUR_S_f = number_format($IPD_ASUR_S, 2, '.', ',');
                $IPD_DENT_S_f = number_format($IPD_DENT_S, 2, '.', ',');
                $IPD_ENTH_S_f = number_format($IPD_ENTH_S, 2, '.', ',');
                $IPD_MEDI_S_f = number_format($IPD_MEDI_S, 2, '.', ',');
                $IPD_OBGY_S_f = number_format($IPD_OBGY_S, 2, '.', ',');
                $IPD_OPDC_S_f = number_format($IPD_OPDC_S, 2, '.', ',');
                $IPD_OPDC_ANC_S_f = number_format($IPD_OPDC_ANC_S, 2, '.', ',');
                $IPD_OPDC_ZOOM_S_f = number_format($IPD_OPDC_ZOOM_S, 2, '.', ',');
                $IPD_OPHT_S_f = number_format($IPD_OPHT_S, 2, '.', ',');
                $IPD_ORTH_S_f = number_format($IPD_ORTH_S, 2, '.', ',');
                $IPD_PAED_S_f = number_format($IPD_PAED_S, 2, '.', ',');
                $IPD_PSUR_S_f = number_format($IPD_PSUR_S, 2, '.', ',');
                $IPD_PSUR_S_f = number_format($IPD_PSUR_S, 2, '.', ',');
                $IPD_RSUR_S_f = number_format($IPD_RSUR_S, 2, '.', ',');
                $TOTAL_IPD_SERVICE_f = number_format($TOTAL_IPD_SERVICE, 2, '.', ',');
                
                $IPD_ASUR_D_f = number_format($IPD_ASUR_D, 2, '.', ',');
                $IPD_DENT_D_f = number_format($IPD_DENT_D, 2, '.', ',');
                $IPD_ENTH_D_f = number_format($IPD_ENTH_D, 2, '.', ',');
                $IPD_MEDI_D_f = number_format($IPD_MEDI_D, 2, '.', ',');
                $IPD_OBGY_D_f = number_format($IPD_OBGY_D, 2, '.', ',');
                $IPD_OPDC_D_f = number_format($IPD_OPDC_D, 2, '.', ',');
                $IPD_OPDC_ANC_D_f = number_format($IPD_OPDC_ANC_D, 2, '.', ',');
                $IPD_OPDC_ZOOM_D_f = number_format($IPD_OPDC_ZOOM_D, 2, '.', ',');
                $IPD_OPHT_D_f = number_format($IPD_OPHT_D, 2, '.', ',');
                $IPD_ORTH_D_f = number_format($IPD_ORTH_D, 2, '.', ',');
                $IPD_PAED_D_f = number_format($IPD_PAED_D, 2, '.', ',');
                $IPD_PSUR_D_f = number_format($IPD_PSUR_D, 2, '.', ',');
                $IPD_PSUR_D_f = number_format($IPD_PSUR_D, 2, '.', ',');
                $IPD_RSUR_D_f = number_format($IPD_RSUR_D, 2, '.', ',');
                $TOTAL_IPD_DRUG_f = number_format($TOTAL_IPD_DRUG, 2, '.', ',');
                
                $IPD_ASUR_T_f = number_format($IPD_ASUR_T, 2, '.', ',');
                $IPD_DENT_T_f = number_format($IPD_DENT_T, 2, '.', ',');
                $IPD_ENTH_T_f = number_format($IPD_ENTH_T, 2, '.', ',');
                $IPD_MEDI_T_f = number_format($IPD_MEDI_T, 2, '.', ',');
                $IPD_OBGY_T_f = number_format($IPD_OBGY_T, 2, '.', ',');
                $IPD_OPDC_T_f = number_format($IPD_OPDC_T, 2, '.', ',');
                $IPD_OPDC_ANC_T_f = number_format($IPD_OPDC_ANC_T, 2, '.', ',');
                $IPD_OPDC_ZOOM_T_f = number_format($IPD_OPDC_ZOOM_T, 2, '.', ',');
                $IPD_OPHT_T_f = number_format($IPD_OPHT_T, 2, '.', ',');
                $IPD_ORTH_T_f = number_format($IPD_ORTH_T, 2, '.', ',');
                $IPD_PAED_T_f = number_format($IPD_PAED_T, 2, '.', ',');
                $IPD_PSUR_T_f = number_format($IPD_PSUR_T, 2, '.', ',');
                $IPD_PSUR_T_f = number_format($IPD_PSUR_T, 2, '.', ',');
                $IPD_RSUR_T_f = number_format($IPD_RSUR_T, 2, '.', ',');
                $TOTAL_IPD_TOTAL_f = number_format($TOTAL_IPD_TOTAL, 2, '.', ',');
                
                $OPD_ASUR_S_f = number_format($OPD_ASUR_S, 2, '.', ',');
                $OPD_DENT_S_f = number_format($OPD_DENT_S, 2, '.', ',');
                $OPD_ENTH_S_f = number_format($OPD_ENTH_S, 2, '.', ',');
                $OPD_MEDI_S_f = number_format($OPD_MEDI_S, 2, '.', ',');
                $OPD_OBGY_S_f = number_format($OPD_OBGY_S, 2, '.', ',');
                $OPD_OPDC_S_f = number_format($OPD_OPDC_S, 2, '.', ',');
                $OPD_OPDC_ANC_S_f = number_format($OPD_OPDC_ANC_S, 2, '.', ',');
                $OPD_OPDC_ZOOM_S_f = number_format($OPD_OPDC_ZOOM_S, 2, '.', ',');
                $OPD_OPHT_S_f = number_format($OPD_OPHT_S, 2, '.', ',');
                $OPD_ORTH_S_f = number_format($OPD_ORTH_S, 2, '.', ',');
                $OPD_PAED_S_f = number_format($OPD_PAED_S, 2, '.', ',');
                $OPD_PSUR_S_f = number_format($OPD_PSUR_S, 2, '.', ',');
                $OPD_PSUR_S_f = number_format($OPD_PSUR_S, 2, '.', ',');
                $OPD_RSUR_S_f = number_format($OPD_RSUR_S, 2, '.', ',');
                $TOTAL_OPD_SERVICE_f = number_format($TOTAL_OPD_SERVICE, 2, '.', ',');

                $OPD_ASUR_D_f = number_format($OPD_ASUR_D, 2, '.', ',');
                $OPD_DENT_D_f = number_format($OPD_DENT_D, 2, '.', ',');
                $OPD_ENTH_D_f = number_format($OPD_ENTH_D, 2, '.', ',');
                $OPD_MEDI_D_f = number_format($OPD_MEDI_D, 2, '.', ',');
                $OPD_OBGY_D_f = number_format($OPD_OBGY_D, 2, '.', ',');
                $OPD_OPDC_D_f = number_format($OPD_OPDC_D, 2, '.', ',');
                $OPD_OPDC_ANC_D_f = number_format($OPD_OPDC_ANC_D, 2, '.', ',');
                $OPD_OPDC_ZOOM_D_f = number_format($OPD_OPDC_ZOOM_D, 2, '.', ',');
                $OPD_OPHT_D_f = number_format($OPD_OPHT_D, 2, '.', ',');
                $OPD_ORTH_D_f = number_format($OPD_ORTH_D, 2, '.', ',');
                $OPD_PAED_D_f = number_format($OPD_PAED_D, 2, '.', ',');
                $OPD_PSUR_D_f = number_format($OPD_PSUR_D, 2, '.', ',');
                $OPD_PSUR_D_f = number_format($OPD_PSUR_D, 2, '.', ',');
                $OPD_RSUR_D_f = number_format($OPD_RSUR_D, 2, '.', ',');
                $TOTAL_OPD_DRUG_f = number_format($TOTAL_OPD_DRUG, 2, '.', ',');

                $OPD_ASUR_T_f = number_format($OPD_ASUR_T, 2, '.', ',');
                $OPD_DENT_T_f = number_format($OPD_DENT_T, 2, '.', ',');
                $OPD_ENTH_T_f = number_format($OPD_ENTH_T, 2, '.', ',');
                $OPD_MEDI_T_f = number_format($OPD_MEDI_T, 2, '.', ',');
                $OPD_OBGY_T_f = number_format($OPD_OBGY_T, 2, '.', ',');
                $OPD_OPDC_T_f = number_format($OPD_OPDC_T, 2, '.', ',');
                $OPD_OPDC_ANC_T_f = number_format($OPD_OPDC_ANC_T, 2, '.', ',');
                $OPD_OPDC_ZOOM_T_f = number_format($OPD_OPDC_ZOOM_T, 2, '.', ',');
                $OPD_OPHT_T_f = number_format($OPD_OPHT_T, 2, '.', ',');
                $OPD_ORTH_T_f = number_format($OPD_ORTH_T, 2, '.', ',');
                $OPD_PAED_T_f = number_format($OPD_PAED_T, 2, '.', ',');
                $OPD_PSUR_T_f = number_format($OPD_PSUR_T, 2, '.', ',');
                $OPD_PSUR_T_f = number_format($OPD_PSUR_T, 2, '.', ',');
                $OPD_RSUR_T_f = number_format($OPD_RSUR_T, 2, '.', ',');
                $TOTAL_OPD_TOTAL_f = number_format($TOTAL_OPD_TOTAL, 2, '.', ',');

                $GRAND_TOTAL = $TOTAL_IPD + $TOTAL_OPD;
                $GRAND_TOTAL_DRUGS = $TOTAL_IPD_DRUG + $TOTAL_OPD_DRUG;
                $GRAND_TOTAL_SERVICES = $TOTAL_IPD_SERVICE + $TOTAL_OPD_SERVICE;
                $GRAND_TOTAL_TOTAL = $TOTAL_IPD_TOTAL + $TOTAL_OPD_TOTAL;
                $GRAND_TOTAL_DRUGS_f = number_format($GRAND_TOTAL_DRUGS, 2, '.', ',');
                $GRAND_TOTAL_SERVICES_f = number_format($GRAND_TOTAL_SERVICES, 2, '.', ',');
                $GRAND_TOTAL_TOTAL_f = number_format($GRAND_TOTAL_TOTAL, 2, '.', ',');

                echo '<tr>
                    <th colspan="7">IN-PATIENT</th>
                </tr>';
                if($IPD_ASUR > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="ASUR" data-id3="2">
                                ADULT SURGERY
                            </a>
                        </td>
                        <td class="action-td">ASUR</td>
                        <td class="action-td">'.$IPD_ASUR.'</td>
                        <td class="amt-td">'.$IPD_ASUR_S_f.'</td>
                        <td class="amt-td">'.$IPD_ASUR_D_f.'</td>
                        <td class="amt-td">'.$IPD_ASUR_T_f.'</td>
                    </tr>';
                };
                
                if($IPD_DENT > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="DENT" data-id3="2">
                                DENTAL
                            </a>
                        </td>
                        <td class="action-td">DENT</td>
                        <td class="action-td">'.$IPD_DENT.'</td>
                        <td class="amt-td">'.$IPD_DENT_S_f.'</td>
                        <td class="amt-td">'.$IPD_DENT_D_f.'</td>
                        <td class="amt-td">'.$IPD_DENT_T_f.'</td>
                    </tr>';
                };
                
                if($IPD_ENTH > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="ENTH" data-id3="2">
                                EAR, NOSE AND THROAT
                            </a>
                        </td>
                        <td class="action-td">ENTH</td>
                        <td class="action-td">'.$IPD_ENTH.'</td>
                        <td class="amt-td">'.$IPD_ENTH_S_f.'</td>
                        <td class="amt-td">'.$IPD_ENTH_D_f.'</td>
                        <td class="amt-td">'.$IPD_ENTH_T_f.'</td>
                    </tr>';
                };
                
                if($IPD_MEDI > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="MEDI" data-id3="2">
                                MEDICAL
                            </a>
                        </td>
                        <td class="action-td">MEDI</td>
                        <td class="action-td">'.$IPD_MEDI.'</td>
                        <td class="amt-td">'.$IPD_MEDI_S_f.'</td>
                        <td class="amt-td">'.$IPD_MEDI_D_f.'</td>
                        <td class="amt-td">'.$IPD_MEDI_T_f.'</td>
                    </tr>';
                };
                
                if($IPD_OBGY > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="OBGY" data-id3="2">
                                OBSTETRICS AND GYNECOLOGY
                            </a>
                        </td>
                        <td class="action-td">OBGY</td>
                        <td class="action-td">'.$IPD_OBGY.'</td>
                        <td class="amt-td">'.$IPD_OBGY_S_f.'</td>
                        <td class="amt-td">'.$IPD_OBGY_D_f.'</td>
                        <td class="amt-td">'.$IPD_OBGY_T_f.'</td>
                    </tr>';
                };

                if($IPD_OPDC > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="OPD" data-id3="2">
                                GENERAL OPD
                            </a>
                        </td>
                        <td class="action-td">OPDC</td>
                        <td class="action-td">'.$IPD_OPDC.'</td>
                        <td class="amt-td">'.$IPD_OPDC_S_f.'</td>
                        <td class="amt-td">'.$IPD_OPDC_D_f.'</td>
                        <td class="amt-td">'.$IPD_OPDC_T_f.'</td>
                    </tr>';
                };

                if($IPD_OPDC_ANC > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="ANC" data-id3="2">
                                ANTENATAL
                            </a>
                        </td>
                        <td class="action-td">ANC</td>
                        <td class="action-td">'.$IPD_OPDC_ANC.'</td>
                        <td class="amt-td">'.$IPD_OPDC_ANC_S_f.'</td>
                        <td class="amt-td">'.$IPD_OPDC_ANC_D_f.'</td>
                        <td class="amt-td">'.$IPD_OPDC_ANC_T_f.'</td>
                    </tr>';
                };

                if($IPD_OPDC_ZOOM > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="ZOOM" data-id3="2">
                                CROSS MDC
                            </a>
                        </td>
                        <td class="action-td">ZOOM</td>
                        <td class="action-td">'.$IPD_OPDC_ZOOM.'</td>
                        <td class="amt-td">'.$IPD_OPDC_ZOOM_S_f.'</td>
                        <td class="amt-td">'.$IPD_OPDC_ZOOM_D_f.'</td>
                        <td class="amt-td">'.$IPD_OPDC_ZOOM_T_f.'</td>
                    </tr>';
                };

                if($IPD_OPHT > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="OPHT" data-id3="2">
                                OPHTALMOLOGY
                            </a>
                        </td>
                        <td class="action-td">OPHT</td>
                        <td class="action-td">'.$IPD_OPHT.'</td>
                        <td class="amt-td">'.$IPD_OPHT_S_f.'</td>
                        <td class="amt-td">'.$IPD_OPHT_D_f.'</td>
                        <td class="amt-td">'.$IPD_OPHT_T_f.'</td>
                    </tr>';
                };

                if($IPD_ORTH > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="ORTH" data-id3="2">
                                ORTHOPEDIC
                            </a>
                        </td>
                        <td class="action-td">ORTH</td>
                        <td class="action-td">'.$IPD_ORTH.'</td>
                        <td class="amt-td">'.$IPD_ORTH_S_f.'</td>
                        <td class="amt-td">'.$IPD_ORTH_D_f.'</td>
                        <td class="amt-td">'.$IPD_ORTH_T_f.'</td>
                    </tr>';
                };

                if($IPD_PAED > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="PAED" data-id3="2">
                                PEDIATRICS
                            </a>
                        </td>
                        <td class="action-td">PAED</td>
                        <td class="action-td">'.$IPD_PAED.'</td>
                        <td class="amt-td">'.$IPD_PAED_S_f.'</td>
                        <td class="amt-td">'.$IPD_PAED_D_f.'</td>
                        <td class="amt-td">'.$IPD_PAED_T_f.'</td>
                    </tr>';
                };

                if($IPD_PSUR > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="PSUR" data-id3="2">
                                PEDIATRIC SURGERY
                            </a>
                        </td>
                        <td class="action-td">PSUR</td>
                        <td class="action-td">'.$IPD_PSUR.'</td>
                        <td class="amt-td">'.$IPD_PSUR_S_f.'</td>
                        <td class="amt-td">'.$IPD_PSUR_D_f.'</td>
                        <td class="amt-td">'.$IPD_PSUR_T_f.'</td>
                    </tr>';
                };

                if($IPD_RSUR > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="RSUR" data-id3="2">
                                RECONSTRUCTIVE SURGERY
                            </a>
                        </td>
                        <td class="action-td">RSUR</td>
                        <td class="action-td">'.$IPD_RSUR.'</td>
                        <td class="amt-td">'.$IPD_RSUR_S_f.'</td>
                        <td class="amt-td">'.$IPD_RSUR_D_f.'</td>
                        <td class="amt-td">'.$IPD_RSUR_T_f.'</td>
                    </tr>';
                };
                echo '<tr>
                    <th class="action-td" colspan="2">TOTAL</th>
                    <th class="action-td">'.$TOTAL_IPD.'</th>
                    <th class="amt-td">'.$TOTAL_IPD_SERVICE_f.'</th>
                    <th class="amt-td">'.$TOTAL_IPD_DRUG_f.'</th>
                    <th class="amt-td">'.$TOTAL_IPD_TOTAL_f.'</th>
                </tr>';
                
                echo '<tr>
                    <th colspan="7">OUT-PATIENT</th>
                </tr>';

                if($OPD_ASUR > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="ASUR" data-id3="1">
                                ADULT SURGERY
                            </a>
                        </td>
                        <td class="action-td">ASUR</td>
                        <td class="action-td">'.$OPD_ASUR.'</td>
                        <td class="amt-td">'.$OPD_ASUR_S_f.'</td>
                        <td class="amt-td">'.$OPD_ASUR_D_f.'</td>
                        <td class="amt-td">'.$OPD_ASUR_T_f.'</td>
                    </tr>';
                };

                if($OPD_DENT > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="DENT" data-id3="1">
                                DENTAL
                            </a>
                        </td>
                        <td class="action-td">DENT</td>
                        <td class="action-td">'.$OPD_DENT.'</td>
                        <td class="amt-td">'.$OPD_DENT_S_f.'</td>
                        <td class="amt-td">'.$OPD_DENT_D_f.'</td>
                        <td class="amt-td">'.$OPD_DENT_T_f.'</td>
                    </tr>';
                };

                if($OPD_ENTH > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="ENTH" data-id3="1">
                                EAR, NOSE AND THROAT
                            </a>
                        </td>
                        <td class="action-td">ENTH</td>
                        <td class="action-td">'.$OPD_ENTH.'</td>
                        <td class="amt-td">'.$OPD_ENTH_S_f.'</td>
                        <td class="amt-td">'.$OPD_ENTH_D_f.'</td>
                        <td class="amt-td">'.$OPD_ENTH_T_f.'</td>
                    </tr>';
                };

                if($OPD_MEDI > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="MEDI" data-id3="1">
                                MEDICAL
                            </a>
                        </td>
                        <td class="action-td">MEDI</td>
                        <td class="action-td">'.$OPD_MEDI.'</td>
                        <td class="amt-td">'.$OPD_MEDI_S_f.'</td>
                        <td class="amt-td">'.$OPD_MEDI_D_f.'</td>
                        <td class="amt-td">'.$OPD_MEDI_T_f.'</td>
                    </tr>';
                };

                if($OPD_OBGY > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="OBGY" data-id3="1">
                                OBSTETRICS AND GYNECOLOGY
                            </a>
                        </td>
                        <td class="action-td">OBGY</td>
                        <td class="action-td">'.$OPD_OBGY.'</td>
                        <td class="amt-td">'.$OPD_OBGY_S_f.'</td>
                        <td class="amt-td">'.$OPD_OBGY_D_f.'</td>
                        <td class="amt-td">'.$OPD_OBGY_T_f.'</td>
                    </tr>';
                };

                if($OPD_OPDC > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="OPD" data-id3="1">
                                GENERAL OPD
                            </a>
                        </td>
                        <td class="action-td">OPDC</td>
                        <td class="action-td">'.$OPD_OPDC.'</td>
                        <td class="amt-td">'.$OPD_OPDC_S_f.'</td>
                        <td class="amt-td">'.$OPD_OPDC_D_f.'</td>
                        <td class="amt-td">'.$OPD_OPDC_T_f.'</td>
                    </tr>';
                };

                if($OPD_OPDC_ANC > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="ANC" data-id3="1">
                                ANTENATAL
                            </a>
                        </td>
                        <td class="action-td">ANC</td>
                        <td class="action-td">'.$OPD_OPDC_ANC.'</td>
                        <td class="amt-td">'.$OPD_OPDC_ANC_S_f.'</td>
                        <td class="amt-td">'.$OPD_OPDC_ANC_D_f.'</td>
                        <td class="amt-td">'.$OPD_OPDC_ANC_T_f.'</td>
                    </tr>';
                };

                if($OPD_OPDC_ZOOM > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="ZOOM" data-id3="1">
                                CROSS MDC
                            </a>
                        </td>
                        <td class="action-td">ZOOM</td>
                        <td class="action-td">'.$OPD_OPDC_ZOOM.'</td>
                        <td class="amt-td">'.$OPD_OPDC_ZOOM_S_f.'</td>
                        <td class="amt-td">'.$OPD_OPDC_ZOOM_D_f.'</td>
                        <td class="amt-td">'.$OPD_OPDC_ZOOM_T_f.'</td>
                    </tr>';
                };

                if($OPD_OPHT > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="OPHT" data-id3="1">
                                OPHTALMOLOGY
                            </a>
                        </td>
                        <td class="action-td">OPHT</td>
                        <td class="action-td">'.$OPD_OPHT.'</td>
                        <td class="amt-td">'.$OPD_OPHT_S_f.'</td>
                        <td class="amt-td">'.$OPD_OPHT_D_f.'</td>
                        <td class="amt-td">'.$OPD_OPHT_T_f.'</td>
                    </tr>';
                };

                if($OPD_ORTH > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="ORTH" data-id3="1">
                                ORTHOPEDIC
                            </a>
                        </td>
                        <td class="action-td">ORTH</td>
                        <td class="action-td">'.$OPD_ORTH.'</td>
                        <td class="amt-td">'.$OPD_ORTH_S_f.'</td>
                        <td class="amt-td">'.$OPD_ORTH_D_f.'</td>
                        <td class="amt-td">'.$OPD_ORTH_T_f.'</td>
                    </tr>';
                };

                if($OPD_PAED > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="PAED" data-id3="1">
                                PEDIATRICS
                            </a>
                        </td>
                        <td class="action-td">PAED</td>
                        <td class="action-td">'.$OPD_PAED.'</td>
                        <td class="amt-td">'.$OPD_PAED_S_f.'</td>
                        <td class="amt-td">'.$OPD_PAED_D_f.'</td>
                        <td class="amt-td">'.$OPD_PAED_T_f.'</td>
                    </tr>';
                };

                if($OPD_PSUR > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="PSUR" data-id3="1">
                                PEDIATRIC SURGERY
                            </a>
                        </td>
                        <td class="action-td">PSUR</td>
                        <td class="action-td">'.$OPD_PSUR.'</td>
                        <td class="amt-td">'.$OPD_PSUR_S_f.'</td>
                        <td class="amt-td">'.$OPD_PSUR_D_f.'</td>
                        <td class="amt-td">'.$OPD_PSUR_T_f.'</td>
                    </tr>';
                };

                if($OPD_RSUR > 0)
                {
                    echo '<tr>
                        <td>
                            <a id="btn_open_specialty_detail" href="#" data-id="'.$start_date.'" data-id1="'.$end_date.'" data-id2="RSUR" data-id3="1">
                                RECONSTRUCTIVE SURGERY
                            </a>
                        </td>
                        <td class="action-td">RSUR</td>
                        <td class="action-td">'.$OPD_RSUR.'</td>
                        <td class="amt-td">'.$OPD_RSUR_S_f.'</td>
                        <td class="amt-td">'.$OPD_RSUR_D_f.'</td>
                        <td class="amt-td">'.$OPD_RSUR_T_f.'</td>
                    </tr>';
                };
                echo '<tr>
                    <th class="action-td" colspan="2">TOTAL</th>
                    <th class="action-td">'.$TOTAL_OPD.'</th>
                    <th class="amt-td">'.$TOTAL_OPD_SERVICE_f.'</th>
                    <th class="amt-td">'.$TOTAL_OPD_DRUG_f.'</th>
                    <th class="amt-td">'.$TOTAL_OPD_TOTAL_f.'</th>
                </tr>
                <tr>
                    <th class="action-td" colspan="2">GRAND TOTAL</th>
                    <th class="action-td">'.$GRAND_TOTAL.'</th>
                    <th class="amt-td">'.$GRAND_TOTAL_SERVICES_f.'</th>
                    <th class="amt-td">'.$GRAND_TOTAL_DRUGS_f.'</th>
                    <th class="amt-td">'.$GRAND_TOTAL_TOTAL_f.'</th>
                </tr>';
            echo '</tbody>
        </table>';
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>