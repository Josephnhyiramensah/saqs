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
        $patient_id = $_SESSION['patient_id'];

        $query_patient = "SELECT * FROM patients WHERE patient_id ='$patient_id'";
        $query_run_patient = mysqli_query($con, $query_patient);
        $row_patient = mysqli_fetch_assoc($query_run_patient);

        $gender_id = $row_patient['gender'];
        $query_gender = "SELECT * FROM `gender` WHERE `gender_id` = '$gender_id'";
        $query_run_gender = mysqli_query($con, $query_gender);
        $row_gender = mysqli_fetch_assoc($query_run_gender);
    ?>

    <h3 class="modal-title m-0 font-weight-bold text-primary" ><?php echo $row_patient['firstName'].' '.$row_patient['lastName'] ;?>'s Folder</h3>
    <hr>
    <div class="table-responsive no-padding">
        <table width="100%" cellpadding="3" cellspacing="3">
            <tr>
                <td>
                    <table id="my_folder_top_table" width="100%">
                        <tr>
                            <td width="50%"><strong>Patient Name: </strong><?php echo $row_patient['firstName'].' '.$row_patient['lastName'] ;?></td>
                            <td width="50%"><strong>Date of Birth: </strong><?php echo $row_patient['DOB'];?></td>
                        </tr>
                        <tr>
                            <td width="50%"><strong>Folder No: </strong><?php echo $row_patient['folderNo'];?></td>
                            <td width="50%"><strong>Address: </strong><?php echo $row_patient['address'];?></td>
                        </tr>
                        <tr>
                            <td width="50%"><strong>Gender: </strong><?php echo $row_gender['gender']?></td>
                            <td width="50%"><strong>Telephone: </strong><?php echo $row_patient['telephone']?></td>
                        </tr>
                        <tr>
                            <td width="50%"><strong>Blood Group: </strong><?php echo $row_patient['BloodGroup'];?></td>
                            <td width="50%"><strong>Emergency Contact: </strong><?php echo $row_patient['relname']." - ".$row_patient['reltelephone'];?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <?php 

    $query = "SELECT * FROM attendance WHERE patient_id ='$patient_id' ORDER BY date_admit DESC";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        while($row_attend = mysqli_fetch_assoc($query_run))
        {
            $date_admit = $row_attend['date_admit'];
            $date_disch = $row_attend['date_disch'];
            $attend_id = $row_attend['attend_id'];
            $tos_id = $row_attend['tos_id'];
            $nhis_led_id = $row_attend['nhis_led_id'];
            $prvt_led_id = $row_attend['prvt_led_id'];
            if($nhis_led_id > 0 && $prvt_led_id > 0 )
                {
                    $sponsor_id = $nhis_led_id;
                }
            else if($nhis_led_id > 0 && $prvt_led_id <= 0 )
                {
                    $sponsor_id = $nhis_led_id;
                }
            else if($nhis_led_id <= 0 && $prvt_led_id > 0 )
                {
                    $sponsor_id = $prvt_led_id;
                }
            else if($nhis_led_id <= 0 && $prvt_led_id <= 0 )
                {
                    $sponsor_id = 1;
                };
            $query_led = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
            $query_run_led = mysqli_query($con, $query_led);
            $row_led=mysqli_fetch_assoc($query_run_led);

            $query_tos = "SELECT * FROM type_of_service WHERE tos_id='$tos_id'";
            $query_run_tos = mysqli_query($con, $query_tos);
            $row_tos=mysqli_fetch_assoc($query_run_tos);
            ?>

            <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                <thead>
                    <tr style="background-color:black; color:white">
                        <th width="20%">
                            <a href="#" 
                                id="btn_open_attend" 
                                data-id="<?php echo $row_attend['attend_id'];?>" 
                                data-id2="<?php echo $row_attend['patient_id'];?>">
                                <strong><?php echo 'Admission Date:'.$date_admit;?></strong>
                            </a>
                        </th>
                        <th width="20%"><?php echo 'Discharge Date:'.$date_disch;?></th>
                        <th width="20%"><?php echo 'Age:'.$row_attend['age'];?></th>
                        <th width="20%"><?php echo 'Type Of Service:'.$row_tos['description'];?></th>
                        <th width="20%"><?php echo 'Sponsor:'.$row_led['ledger_desc'];?></th>
                    </tr>   
                </thead>
                <tbody class="pv-table-body">
                </tbody>
            </table>

                <?php
            //VITALS
                $query_vitals = "SELECT * FROM vitals WHERE attend_id='$attend_id' AND patient_id ='$patient_id' ORDER BY date DESC";
                $query_run_vitals = mysqli_query($con, $query_vitals);
                if (mysqli_num_rows($query_run_vitals) > 0) 
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>VITALS</strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Temp</th>
                                <th>BP</th>
                                <th>Pulse</th>
                                <th>R.Rate</th>
                                <th>Weight</th>
                                <th>Height</th>
                                <th>Oxygen</th>
                                <th>H.Circ.</th>
                                <th>A.Circ.</th>
                                <th>comment</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                <?php
                                while($row_vitals = mysqli_fetch_assoc($query_run_vitals))
                                {
                                    echo '<tr>
                                                <td>'.$row_vitals['date'].'</td>
                                                <td>'.$row_vitals['temp'].'</td>
                                                <td>'.$row_vitals['bp_systolic'].'/'.$row_vitals['bp_diastolic'].'</td>
                                                <td>'.$row_vitals['pulse'].'</td>
                                                <td>'.$row_vitals['resp_rate'].'</td>
                                                <td>'.$row_vitals['weight'].'</td>
                                                <td>'.$row_vitals['height'].'</td>
                                                <td>'.$row_vitals['oxygen_sat'].'</td>
                                                <td>'.$row_vitals['circ_hip'].'</td>
                                                <td>'.$row_vitals['circ_abdo'].'</td>
                                                <td>'.$row_vitals['comment'].'</td>
                                            </tr>';
                                }
                ?>
                            </tbody>
                        </table>
                <?php
                };

            //HISTORY
                $query_history = "SELECT * FROM history WHERE attend_id='$attend_id' AND patient_id ='$patient_id' ORDER BY date DESC";
                $query_run_history = mysqli_query($con, $query_history);
                if (mysqli_num_rows($query_run_history) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>HISTORY</strong>
                                </td>
                            </tr>
                            <tr>
                                <th width="10%">Date</th>
                                <th width="90%">History</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">';
                <?php
                                while($row_history = mysqli_fetch_assoc($query_run_history))
                                {
                                    echo '<tr>
                                                <td>'.$row_history['date'].'</td>
                                                <td>'.$row_history['history'].'</td>
                                            </tr>';
                                };
                ?>
                        </tbody>   
                    </table>
                <?php
                };

            //DIAGNOSIS
                $query_diagnosis_list = "SELECT * FROM diagnosis_list WHERE attend_id='$attend_id' AND patient_id ='$patient_id' ORDER BY date DESC";
                $query_run_diagnosis_list = mysqli_query($con, $query_diagnosis_list);
                if (mysqli_num_rows($query_run_diagnosis_list) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>DIAGNOSIS</strong>
                                </td>
                            </tr>
                            <tr>
                                <th width="10%">Date</th>
                                <th width="30%">Diagnosis</th>
                                <th width="10%">ICD 10</th>
                                <th width="10%">G-DRG</th>
                                <th width="40%">Comment</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                <?php
                        while($row_diagnosis_list = mysqli_fetch_assoc($query_run_diagnosis_list))
                        {
                            $diagnosis_id = $row_diagnosis_list['diagnosis_id'];
                            $query_diag = "SELECT * FROM diagnosis WHERE diagnosis_id='$diagnosis_id'";
                            $query_run_diag = mysqli_query($con, $query_diag);
                            $row_diag=mysqli_fetch_assoc($query_run_diag);
                            echo '<tr>
                                        <td>'.$row_diagnosis_list['date'].'</a></td>
                                        <td>'.$row_diag['diagnosis'].'</td>
                                        <td>'.$row_diag['icd_10'].'</td>
                                        <td>'.$row_diag['g_drg'].'</td>
                                        <td>'.$row_diagnosis_list['comment'].'</td>
                                    </tr>';
                        };
                ?>
                        </tbody>
                    </table>
                <?php
                };

            //LABORATORY TEST
                $query_lab_list = "SELECT * FROM lab_list WHERE attend_id='$attend_id'";
                $query_run_lab_list = mysqli_query($con, $query_lab_list);
                if (mysqli_num_rows($query_run_lab_list) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>LABORATORY TEST</strong>
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">Parameter</th>
                                <th width="15%">Result</th>
                                <th width="5%">Lower Range</th>
                                <th width="5%">Higher Range</th>
                                <th width="5%">Unit</th>
                                <th width="5%">Flag</th>
                                <th width="35%">Comment</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                <?php
                        while($row_lab_list=mysqli_fetch_assoc($query_run_lab_list))
                        {
                            $lab_id = $row_lab_list['lab_id'];
                            $lab_list_id = $row_lab_list['lab_list_id'];
                            $query_lab_param_list = "SELECT * FROM lab_param_list WHERE lab_list_id='$lab_list_id'";
                            $query_run_lab_param_list = mysqli_query($con, $query_lab_param_list);
                            if (mysqli_num_rows($query_run_lab_param_list) > 0)
                            {
                                $query_lab = "SELECT * FROM lab WHERE lab_id='$lab_id'";
                                $query_run_lab = mysqli_query($con, $query_lab);
                                $row_lab=mysqli_fetch_assoc($query_run_lab);
                                echo'
                                        <tr style="background-color:#EEEEEE">
                                            <td colspan="7">
                                                <strong>'.$row_lab['lab'].'</strong>
                                            </td>
                                        </tr>';
                                    
                                while($row_lab_param_list=mysqli_fetch_assoc($query_run_lab_param_list))
                                {
                                    $lab_param_id = $row_lab_param_list['lab_param_id'];
                                    $querylab_param = "SELECT * FROM lab_param WHERE lab_param_id='$lab_param_id'";
                                    $query_run_lab_param = mysqli_query($con, $querylab_param);
                                    $row_lab_param=mysqli_fetch_assoc($query_run_lab_param);
                                    echo'
                                        <tr>
                                            <td>
                                                '.$row_lab_param['lab_param'].'
                                            </td>
                                            <td>
                                                '.$row_lab_param_list['result'].'
                                            </td>
                                            <td>
                                                '.$row_lab_param_list['low_range'].'
                                            </td>
                                            <td>
                                                '.$row_lab_param_list['high_range'].'
                                            </td>
                                            <td>
                                                '.$row_lab_param['unit'].'
                                            </td>
                                            <td>
                                                '.$row_lab_param_list['flag'].'
                                            </td>
                                            <td>
                                                '.$row_lab_param_list['comment'].'
                                            </td>
                                        </tr>
                                        <tr>
                                        </tr>';
                                };
                            };
                        };
                    ?>
                            </tbody>
                        </table>
                    <?php 
                };

            //RADIOLOGY
                $query_radiolist = "SELECT * FROM radio_list WHERE attend_id = '$attend_id'";
                $query_run_radiolist = mysqli_query($con, $query_radiolist);
                if (mysqli_num_rows($query_run_radiolist) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>RADIOLOGY</strong>
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">Parameter</th>
                                <th width="15%">Result</th>
                                <th width="55%">Comment</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                <?php
                        while($row_radio_list = mysqli_fetch_assoc($query_run_radiolist))
                        {
                            $radio_id = $row_radio_list['radio_id'];
                            $radio_list_id = $row_radio_list['radio_list_id'];
                            $queryradio_param_list = "SELECT * FROM radio_param_list WHERE radio_list_id = '$radio_list_id'";
                            $query_run_radio_param_list = mysqli_query($con, $queryradio_param_list);
                            if (mysqli_num_rows($query_run_radio_param_list) > 0)
                            {
                                $query_radio = "SELECT * FROM radiology WHERE radio_id = '$radio_id'";
                                $query_run_radio = mysqli_query($con, $query_radio);
                                $row_radio = mysqli_fetch_assoc($query_run_radio);
                                echo'<tr style="background-color:#EEEEEE">
                                            <td colspan="7">
                                                <strong>'.$row_radio['radiology'].'</strong>
                                            </td>
                                        </tr>';
                                    
                                while($row_radio_param_list = mysqli_fetch_assoc($query_run_radio_param_list))
                                {
                                    $radio_param_id = $row_radio_param_list['radio_param_id'];
                                    $query_radio_param = "SELECT * FROM radio_param WHERE radio_param_id = '$radio_param_id'";
                                    $query_run_radio_param = mysqli_query($con, $query_radio_param);
                                    $row_radio_param = mysqli_fetch_assoc($query_run_radio_param);
                                    echo'<tr>
                                            <td>'.$row_radio_param['radio_param'].'</td>
                                            <td>'.$row_radio_param_list['result'].'</td>
                                            <td>'.$row_radio_param_list['comment'].'</td>
                                        </tr>
                                        <tr>
                                        </tr>';
                                };
                            };
                        };
                ?>
                            </tbody>
                        </table>
                <?php  
                };

            //PRESCRIPTION
                $query_presc = "SELECT * FROM drug_list WHERE attend_id='$attend_id' ORDER BY date DESC";
                $result_presc = mysqli_query($con,$query_presc);
                if (mysqli_num_rows($result_presc) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>PRESCRIPTION</strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Drug</th>
                                <th>Qty Presc.</th>
                                <th>Qty Disp.</th>
                                <th>Dosage</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                <?php  
                            while($row_presc=mysqli_fetch_assoc($result_presc))
                            {
                                $drug_id = $row_presc['drug_id'];
                                $query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
                                $query_run_drug = mysqli_query($con, $query_drug);
                                $row_drug=mysqli_fetch_assoc($query_run_drug);

                                $drug_list_id = $row_presc['drug_list_id'];
                                $query_ddisp = "SELECT SUM(amt_cash) AS amt_cash, SUM(amt_prvt) AS amt_prvt, SUM(amt_nhis) AS amt_nhis, SUM(qty) AS qty FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
                                $query_run_ddisp = mysqli_query($con, $query_ddisp);
                                $row_ddisp=mysqli_fetch_assoc($query_run_ddisp);

                                echo'<tr>
                                        <td>'.$row_presc['date'].'</td>
                                        <td>'.$row_drug['brand_name'].'</td>
                                        <td>'.$row_presc['qty_presc'].'</td>
                                        <td>'.$row_ddisp['qty'].'</td>
                                        <td>'.$row_presc['dosage'].'</td>
                                    </tr>';
                            };
                ?>
                                </tbody>
                            </table>
                <?php  
                };

            //DRUG ADMINISTRATION
                $query_drug_admin = "SELECT * FROM drug_admin WHERE attend_id='$attend_id'";
                $query_run_drug_admin = mysqli_query($con, $query_drug_admin);
                if (mysqli_num_rows($query_run_drug_admin) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>DRUG ADMINISTRATION</strong>
                                </td>
                            </tr>
                            <tr>
                                <th width="10%">Date</th>
                                <th width="10%">Time</th>
                                <th width="10%">Route</th>
                                <th width="10%">Dosage</th>
                                <th width="10%">Qty Admin</th>
                                <th width="40%">Drug</th>
                                <th width="10%">Admin By</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                            <tr style="background-color:#E4E1E0">
                                <td colspan="7">
                                    <strong>STAT</strong>
                                </td>
                            </tr>
                        <?php  
                            $query_drug_admin_stat = "
                                SELECT * FROM drug_admin AS da 
                                JOIN drug_list AS dl 
                                ON da.drug_list_id=dl.drug_list_id
                                WHERE da.attend_id='$attend_id' 
                                AND dl.dosage LIKE '%st%' ORDER BY da.date DESC, da.time DESC";

                        $query_run_drug_admin_stat = mysqli_query($con, $query_drug_admin_stat);
                        if (mysqli_num_rows($query_run_drug_admin_stat) > 0)
                        {
                            while($row_drug_admin_stat=mysqli_fetch_assoc($query_run_drug_admin_stat))
                            {
                                $drug_id = $row_drug_admin_stat['drug_id'];
                                $drug_list_id = $row_drug_admin_stat['drug_list_id'];
                                $route_id = $row_drug_admin_stat['route_id'];

                                $query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
                                $query_run_drug = mysqli_query($con, $query_drug);
                                $row_drug=mysqli_fetch_assoc($query_run_drug);
                                $drug = $row_drug['brand_name'];

                                $query_drug_list = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
                                $query_run_drug_list = mysqli_query($con, $query_drug_list);
                                $row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
                                $dosage = $row_drug_list['dosage'];

                                $query_route = "SELECT * FROM drug_route WHERE route_id='$route_id'";
                                $query_run_route = mysqli_query($con, $query_route);
                                $row_route=mysqli_fetch_assoc($query_run_route);
                                $route = $row_route['route'];
                        ?>

                                                            
                                        <tr>
                                            <td>
                                                <?php echo $row_drug_admin_stat['date']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row_drug_admin_stat['time']; ?>
                                            </td>
                                            <td>
                                                <?php echo $route; ?>
                                            </td>
                                            <td>
                                                <?php echo $dosage; ?>
                                            </td>
                                            <td>
                                                <?php echo $row_drug_admin_stat['qty_admin']; ?>
                                            </td>
                                            <td>
                                                <?php echo $drug; ?>
                                            </td>
                                            <td>
                                                <?php echo $row_drug_admin_stat['initials']; ?>
                                            </td>
                                        </tr>
                        <?php  
                            };
                        }
                        else
                        {
                            echo '
                                    <tr>
                                        <td>
                                        </td>
                                    </tr>';
                        };
                                echo '<tr style="background-color:#E4E1E0">
                                            <td colspan="7">
                                                <strong>INFUSIONS</strong>
                                            </td>
                                        </tr>';
                                $query_drug_admin_infusion = "
                                        SELECT * FROM drug_admin AS da 
                                        JOIN drugs AS ds 
                                        ON da.drug_id=ds.drug_id
                                        WHERE da.attend_id='$attend_id' 
                                        AND ds.category=3 ORDER BY ds.brand_name ASC, da.date DESC, da.time DESC";

                                $query_run_drug_admin_infusion = mysqli_query($con, $query_drug_admin_infusion);
                                if (mysqli_num_rows($query_run_drug_admin_infusion) > 0)
                                {
                                    while($row_drug_admin_infusion=mysqli_fetch_assoc($query_run_drug_admin_infusion))
                                    {
                                        $drug_id = $row_drug_admin_infusion['drug_id'];
                                        $drug_list_id = $row_drug_admin_infusion['drug_list_id'];
                                        $route_id = $row_drug_admin_infusion['route_id'];

                                        $query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
                                        $query_run_drug = mysqli_query($con, $query_drug);
                                        $row_drug=mysqli_fetch_assoc($query_run_drug);
                                        $drug = $row_drug['brand_name'];

                                        $query_drug_list = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
                                        $query_run_drug_list = mysqli_query($con, $query_drug_list);
                                        $row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
                                        $dosage = $row_drug_list['dosage'];

                                        $query_route = "SELECT * FROM drug_route WHERE route_id='$route_id'";
                                        $query_run_route = mysqli_query($con, $query_route);
                                        $row_route=mysqli_fetch_assoc($query_run_route);
                                        $route = $row_route['route'];

                                        echo '
                                                <tr>
                                                    <td>
                                                        '.$row_drug_admin_infusion['date'].'
                                                    </td>
                                                    <td>
                                                        '.$row_drug_admin_infusion['time'].'
                                                    </td>
                                                    <td>
                                                        '.$route.'
                                                    </td>
                                                    <td>
                                                        '.$dosage.'
                                                    </td>
                                                    <td>
                                                        '.$row_drug_admin_infusion['qty_admin'].'
                                                    </td>
                                                    <td>
                                                        '.$drug.'
                                                    </td>
                                                    <td>
                                                        '.$row_drug_admin_infusion['initials'].'
                                                    </td>
                                                </tr>';
                                    };
                                }else
                                {
                                    echo '
                                            <tr>
                                                <td>
                                                </td>
                                            </tr>';
                                };
                                echo '<tr style="background-color:#E4E1E0">
                                            <td colspan="7">
                                                <strong>OTHERS</strong>
                                            </td>
                                        </tr>';
                                $query_drug_admin_other = "
                                        SELECT * FROM drug_admin AS da 
                                        JOIN drugs AS ds 
                                        ON da.drug_id=ds.drug_id
                                        WHERE da.attend_id='$attend_id' 
                                        AND ds.category<>3 ORDER BY ds.brand_name ASC, da.date DESC, da.time DESC";

                                $query_run_drug_admin_other = mysqli_query($con, $query_drug_admin_other);
                                if (mysqli_num_rows($query_run_drug_admin_other) > 0)
                                {
                                    while($row_drug_admin_other=mysqli_fetch_assoc($query_run_drug_admin_other))
                                    {
                                        $drug_id = $row_drug_admin_other['drug_id'];
                                        $drug_list_id = $row_drug_admin_other['drug_list_id'];
                                        $route_id = $row_drug_admin_other['route_id'];

                                        $query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
                                        $query_run_drug = mysqli_query($con, $query_drug);
                                        $row_drug=mysqli_fetch_assoc($query_run_drug);
                                        $drug = $row_drug['brand_name'];

                                        $query_drug_list = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
                                        $query_run_drug_list = mysqli_query($con, $query_drug_list);
                                        $row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
                                        $dosage = $row_drug_list['dosage'];

                                        $query_route = "SELECT * FROM drug_route WHERE route_id='$route_id'";
                                        $query_run_route = mysqli_query($con, $query_route);
                                        $row_route=mysqli_fetch_assoc($query_run_route);
                                        $route = $row_route['route'];

                                        echo'
                                                <tr>
                                                    <td>
                                                        '.$row_drug_admin_other['date'].'
                                                    </td>
                                                    <td>
                                                        '.$row_drug_admin_other['time'].'
                                                    </td>
                                                    <td>
                                                        '.$route.'
                                                    </td>
                                                    <td>
                                                        '.$dosage.'
                                                    </td>
                                                    <td>
                                                        '.$row_drug_admin_other['qty_admin'].'
                                                    </td>
                                                    <td>
                                                        '.$drug.'
                                                    </td>
                                                    <td>
                                                        '.$row_drug_admin_other['initials'].'
                                                    </td>
                                                </tr>';
                                    };
                                }
                                else
                                {
                                    echo '
                                            <tr>
                                                <td>
                                                </td>
                                            </tr>';
                                };
                        echo '</tbody>
                            </table>';
                };

            //SURGERIES
                $query_surgery_list = "SELECT * FROM surgery_list WHERE attend_id=$attend_id ORDER BY date DESC";
                $query_run_surgery_list = mysqli_query($con, $query_surgery_list);
                if (mysqli_num_rows($query_run_surgery_list) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>SURGERIES/PROCEDURES</strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Procedure/Surgery</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                    <?php
                        while($row_surgery_list = mysqli_fetch_assoc($query_run_surgery_list))
                        {
                            $surgery_id = $row_surgery_list['surgery_id'];
                            $query_surgery = "SELECT * FROM surgery WHERE surgery_id=$surgery_id";
                            $query_run_surgery = mysqli_query($con, $query_surgery);
                            $row_surgery=mysqli_fetch_assoc($query_run_surgery);
                    
                            echo'<tr>
                                    <td>'.$row_surgery_list['date'].'</td>
                                    <td>'.$row_surgery['surgery'].'</td>
                                    <td>'.$row_surgery_list['comment'].'</td>
                                </tr>';
                        };
                    ?>
                        </tbody>
                    </table>
                <?php  
                };
            //MANAGEMENT PLAN
                $query_mgt_plan = "SELECT * FROM management_plan WHERE attend_id=$attend_id ORDER BY date DESC";
                $query_run_mgt_plan = mysqli_query($con, $query_mgt_plan);
                if (mysqli_num_rows($query_run_mgt_plan) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>MANAGEMENT PLAN</strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Initials</th>
                                <th>Management Plan</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                    <?php
                        while($row_mgt_plan = mysqli_fetch_assoc($query_run_mgt_plan))
                        {
                            echo'<tr>
                                    <td>'.$row_mgt_plan['date'].'</td>
                                    <td>'.$row_mgt_plan['initials'].'</td>
                                    <td>'.$row_mgt_plan['mgt_notes'].'</td>
                                </tr>';
                        };
                    ?>
                        </tbody>
                    </table>
                <?php  
                };
            //NURSES NOTES
                $query_nn = "SELECT * FROM nurses_notes WHERE attend_id=$attend_id ORDER BY date DESC";
                $query_run_nn = mysqli_query($con, $query_nn);
                if (mysqli_num_rows($query_run_nn) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>NURSES NOTES</strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Initials</th>
                                <th>Nurses Notes</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                    <?php
                        while($row_nn = mysqli_fetch_assoc($query_run_nn))
                        {
                            echo'<tr>
                                    <td>'.$row_nn['date'].'</td>
                                    <td>'.$row_nn['initials'].'</td>
                                    <td>'.$row_nn['nurses_notes'].'</td>
                                </tr>';
                        };
                    ?>
                        </tbody>
                    </table>
                <?php  
                };
            //ANTENATAL
                $query_nn = "SELECT * FROM nurses_notes WHERE attend_id=$attend_id ORDER BY date DESC";
                $query_run_nn = mysqli_query($con, $query_nn);
                if (mysqli_num_rows($query_run_nn) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>ANTENATAL</strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Initials</th>
                                <th>Nurses Notes</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                    <?php
                        while($row_nn = mysqli_fetch_assoc($query_run_nn))
                        {
                            echo'';
                        };
                    ?>
                        </tbody>
                    </table>
                <?php  
                };
            //DELIVERY
                $query_nn = "SELECT * FROM nurses_notes WHERE attend_id=$attend_id ORDER BY date DESC";
                $query_run_nn = mysqli_query($con, $query_nn);
                if (mysqli_num_rows($query_run_nn) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>DELIVERY</strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Initials</th>
                                <th>Nurses Notes</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                    <?php
                        while($row_nn = mysqli_fetch_assoc($query_run_nn))
                        {
                            echo'';
                        };
                    ?>
                        </tbody>
                    </table>
                <?php  
                };
            //POSTNATAL
                $query_nn = "SELECT * FROM nurses_notes WHERE attend_id=$attend_id ORDER BY date DESC";
                $query_run_nn = mysqli_query($con, $query_nn);
                if (mysqli_num_rows($query_run_nn) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>POSTNATAL</strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Initials</th>
                                <th>Nurses Notes</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                    <?php
                        while($row_nn = mysqli_fetch_assoc($query_run_nn))
                        {
                            echo'';
                        };
                    ?>
                        </tbody>
                    </table>
                <?php 

                //PARTOGRAPH
                $query_nn = "SELECT * FROM nurses_notes WHERE attend_id=$attend_id ORDER BY date DESC";
                $query_run_nn = mysqli_query($con, $query_nn);
                if (mysqli_num_rows($query_run_nn) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>PARTOGRAPH</strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Initials</th>
                                <th>Nurses Notes</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                    <?php
                        while($row_nn = mysqli_fetch_assoc($query_run_nn))
                        {
                            echo'';
                        };
                    ?>
                        </tbody>
                    </table>
                <?php  
                };
                };
            //EYE
                $query_va = "SELECT * FROM eye_visual_acuity WHERE attend_id='$attend_id'";
                $query_run_va = mysqli_query($con, $query_va);
                if (mysqli_num_rows($query_run_va) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>EYE - VISUAL ACUITY</strong>
                                </td>
                            </tr>
                            <tr>
                                <th width="20%"><h6><strong>PARTICULARS</strong></h6></th>
                                <th width="40%"><h6><strong>RIGHT</strong></h6></th>
                                <th width="40%"><h6><strong>LEFT</strong></h6></th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                    <?php
                        while($row_va = mysqli_fetch_assoc($query_run_va))
                        {
                            echo'<tr>
                                    <td>UNAIDED:</td>
                                    <td>'.$row_va['unaided_R'].'</td>
                                    <td>'.$row_va['unaided_L'].'</td>
                                </tr>
                                <tr>
                                    <td>PINHOLE:</td>
                                    <td>'.$row_va['pinhole_R'].'</td>
                                    <td>'.$row_va['pinhole_L'].'</td>
                                </tr>
                                <tr>
                                    <td>AIDED:</td>
                                    <td>'.$row_va['aided_R'].'</td>
                                    <td>'.$row_va['aided_L'].'</td>
                                </tr>
                                <tr>
                                    <td>IOP</td>
                                    <td>'.$row_va['IOP_R'].'</td>
                                    <td>'.$row_va['IOP_L'].'</td>
                                </tr>
                                <tr>
                                    <td>Remarks</td>
                                    <td colspan="2">'.$row_va['Remarks'].'</td>
                                </tr>';
                        };
                    ?>
                        </tbody>
                    </table>
                <?php  
                };

                $query_oe = "SELECT * FROM eye_ocular_exam WHERE attend_id='$attend_id'";
                $query_run_oe = mysqli_query($con, $query_oe);
                if (mysqli_num_rows($query_run_oe) > 0)
                {
                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>EYE - OCULAR EXAMINATION</strong>
                                </td>
                            </tr>
                            <tr>
                                <th width="20%"><h6><strong>PARTICULARS</strong></h6></th>
                                <th width="25%"><h6><strong>RIGHT VISION</strong></h6></th>
                                <th width="25%"><h6><strong>LEFT VISION</strong></h6></th>
                                <th width="30%"><h6><strong>REMARKS</strong></h6></th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                    <?php
                        while($row_oe = mysqli_fetch_assoc($query_run_oe))
                        {
                    ?>
                                <tr>
                                    <td>LID:</td>
                                    <td><?php echo $row_oe['LID_R'];?></td>
                                    <td><?php echo $row_oe['LID_L'];?></td>
                                    <td><?php echo $row_oe['LID_Remarks'];?></td>
                                </tr>
                                <tr>
                                    <td>CONJUNCTIVA:</td>
                                    <td><?php echo $row_oe['CONJUNCTIVA_R'];?></td>
                                    <td><?php echo $row_oe['CONJUNCTIVA_L'];?></td>
                                    <td><?php echo $row_oe['CONJUNCTIVA_Remarks'];?></td>
                                </tr>
                                <tr>
                                    <td>CORNEA:</td>
                                    <td><?php echo $row_oe['CORNEA_R'];?></td>
                                    <td><?php echo $row_oe['CORNEA_L'];?></td>
                                    <td><?php echo $row_oe['CORNEA_Remarks'];?></td>
                                </tr>
                                <tr>
                                    <td>AC</td>
                                    <td><?php echo $row_oe['AC_R'];?></td>
                                    <td><?php echo $row_oe['AC_L'];?></td>
                                    <td><?php echo $row_oe['AC_Remarks'];?></td>
                                </tr>
                                <tr>
                                    <td>PUPIL</td>
                                    <td><?php echo $row_oe['PUPIL_R'];?></td>
                                    <td><?php echo $row_oe['PUPIL_L'];?></td>
                                    <td><?php echo $row_oe['PUPIL_Remarks'];?></td>
                                </tr>
                                <tr>
                                    <td>LENS</td>
                                    <td><?php echo $row_oe['LENS_R'];?></td>
                                    <td><?php echo $row_oe['LENS_L'];?></td>
                                    <td><?php echo $row_oe['LENS_Remarks'];?></td>
                                </tr>
                                <tr>
                                    <td>VITREOUS</td>
                                    <td><?php echo $row_oe['VITREOUS_R'];?></td>
                                    <td><?php echo $row_oe['VITREOUS_L'];?></td>
                                    <td><?php echo $row_oe['VITREOUS_Remarks'];?></td>
                                </tr>
                                <tr>
                                    <td>FUNDUS</td>
                                    <td><?php echo $row_oe['FUNDUS_R'];?></td>
                                    <td><?php echo $row_oe['FUNDUS_L'];?></td>
                                    <td><?php echo $row_oe['FUNDUS_Remarks'];?></td>
                                </tr>
                                <tr>
                                    <td>VC/D</td>
                                    <td><?php echo $row_oe['VC_D_R'];?></td>
                                    <td><?php echo $row_oe['VC_D_L'];?></td>
                                    <td><?php echo $row_oe['VC_D_Remarks'];?></td>
                                </tr>
                                <tr>
                                    <td>IOP</td>
                                    <td><?php echo $row_oe['IOP_R'];?></td>
                                    <td><?php echo $row_oe['IOP_L'];?></td>
                                    <td><?php echo $row_oe['IOP_Remarks'];?></td>
                                </tr>
                                <tr>
                                    <td>Remarks</td>
                                    <td colspan="3"><?php echo $row_oe['remarks'];?></td>
                                </tr>
                    <?php
                        };
                    ?>
                        </tbody>
                    </table>
                <?php  
                };

                $query_ref = "SELECT * FROM eye_refraction WHERE attend_id='$attend_id'";
                $query_run_ref = mysqli_query($con, $query_ref);
                if (mysqli_num_rows($query_run_ref) > 0)
                {

                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>EYE - REFRACTION</strong>
                                </td>
                            </tr>
                            <tr>
                                <th width="20%"><h6><strong>PARTICULARS</strong></h6></th>
                                <th width="40%"><h6><strong>RIGHT VISION</strong></h6></th>
                                <th width="40%"><h6><strong>LEFT VISION</strong></h6></th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                    <?php
                        while($row_ref = mysqli_fetch_assoc($query_run_ref))
                        {
                    ?>
                            <tr>
                                    <td>SPH:</td>
                                    <td><?php echo $row_ref['SPH_R'];?></td>
                                    <td><?php echo $row_ref['SPH_L'];?></td>
                                </tr>
                                <tr>
                                    <td>CYL:</td>
                                    <td><?php echo $row_ref['CYL_R'];?></td>
                                    <td><?php echo $row_ref['CYL_L'];?></td>
                                </tr>
                                <tr>
                                    <td>AXIS:</td>
                                    <td><?php echo $row_ref['AXIS_R'];?></td>
                                    <td><?php echo $row_ref['AXIS_L'];?></td>
                                </tr>
                                <tr>
                                    <td>ADD:</td>
                                    <td><?php echo $row_ref['ADD_R'];?></td>
                                    <td><?php echo $row_ref['ADD_L'];?></td>
                                </tr>
                                <tr>
                                    <td>HGT:</td>
                                    <td><?php echo $row_ref['HGT_R'];?></td>
                                    <td><?php echo $row_ref['HGT_L'];?></td>
                                </tr>
                                <tr>
                                    <td>PD:</td>
                                    <td><?php echo $row_ref['PD_R'];?></td>
                                    <td><?php echo $row_ref['PD_L'];?></td>
                                </tr>
                                <tr>
                                    <td>Remarks</td>
                                    <td colspan="2"><?php echo $row_ref['Remarks'];?></td>
                                </tr>
                    <?php
                        };
                    ?>
                        </tbody>
                    </table>
                <?php  
                };


                $query_len = "SELECT * FROM eye_lens WHERE attend_id='$attend_id'";
                $query_run_len = mysqli_query($con, $query_len);
                if (mysqli_num_rows($query_run_len) > 0)
                {

                ?>
                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="12">
                                    <strong>EYE - LENS</strong>
                                </td>
                            </tr>
                            <tr>
                                <th width="30%"><h6><strong>PARTICULARS</strong></h6></th>
                                <th width="70%"><h6><strong>DETAILS</strong></h6></th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">
                    <?php
                        while($row_len = mysqli_fetch_assoc($query_run_len))
                        {
                    ?>
                            <tr>
                                <td>LENS TYPE:</td>
                                <td><?php echo $row_len['lens_type'];?></td>
                            </tr>
                            <tr>
                                <td>LENS MATERIAL:</td>
                                <td><?php echo $row_len['lens_material'];?></td>
                            </tr>
                            <tr>
                                <td>LENS INDEX:</td>
                                <td><?php echo $row_len['lens_index'];?></td>
                            </tr>
                            <tr>
                                <td>LENS FRAME:</td>
                                <td><?php echo $row_len['lens_frame'];?></td>
                            </tr>
                            <tr>
                                <td>LENS OTHERS:</td>
                                <td><?php echo $row_len['lens_others'];?></td>
                            </tr>
                            <tr>
                                <td>REMARKS:</td>
                                <td colspan="2"><?php echo $row_len['remarks'];?></td>
                            </tr>
                    <?php
                        };
                    ?>
                        </tbody>
                    </table>
                <?php  
                };
            //DENTAL
                //DENTAL HISTORY
                    $query_dental_history = "SELECT * FROM dental_history WHERE attend_id='$attend_id'";
                    $query_run_dental_history = mysqli_query($con, $query_dental_history);
                    if (mysqli_num_rows($query_run_dental_history) > 0)
                    {
                    ?>
                        <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr style="background-color:#E4DCCF; color:black">
                                    <td colspan="12">
                                        <strong>DENTAL HISTORY</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="20%">Question</th>
                                    <th width="10%">Response</th>
                                    <th width="20%">Question</th>
                                    <th width="10%">Response</th>
                                    <th width="20%">Question</th>
                                    <th width="10%">Response</th>
                                </tr>
                            </thead>
                            <tbody class="pv-table-body">
                        <?php
                            while($row_dental_history = mysqli_fetch_assoc($query_run_dental_history))
                            {
                                echo'<tr>
                                        <td><small>1. DO YOUR GUMS BLEED WHILE BRUSHING OR FLOSSING:</small></td>
                                        <td>'.$row_dental_history['1'].'</td>
                                        <td><small>2. ARE YOUR TEETH SENSITIVE TO HOT OR COLD LIQUIDS/FOODS:</small></td>
                                        <td>'.$row_dental_history['2'].'</td>
                                        <td><small>3. ARE YOUR TEETH SENSITIVE TO SWEET OR SOUR FOODS:</small></td>
                                        <td>'.$row_dental_history['3'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>4. DO YOU FEEL PAIN IN ANY OF YOUR TEETH:</small></td>
                                        <td>'.$row_dental_history['4'].'</td>
                                        <td><small>5. DO YOU HAVE ANY SORES OR LUMPS IN OR NEAR YOUR MOUTH:</small></td>
                                        <td>'.$row_dental_history['5'].'</td>
                                        <td><small>6. HAVE YOU EVER EXPERIENCED ANY OF THE FOLLOWING PROBLEMS IN YOUR JAW?:</small></td>
                                        <td>'.$row_dental_history['6'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>7. CLICKING:</small></td>
                                        <td>'.$row_dental_history['7'].'</td>
                                        <td><small>8. PAIN (JOINT, EAR, SIDE OF FACE):</small></td>
                                        <td>'.$row_dental_history['8'].'</td>
                                        <td><small>9. DO YOU HAVE FREQUENT HEADACHES:</small></td>
                                        <td>'.$row_dental_history['9'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>10. DO YOU CLENCH OR GRIND YOUR TEETH:</small></td>
                                        <td>'.$row_dental_history['10'].'</td>
                                        <td><small>11. HAVE YOU NOTICED ANY LOOSENING OF YOUR TEETH:</small></td>
                                        <td>'.$row_dental_history['11'].'</td>
                                        <td><small>12. DOES FOOD TEND TO BECOME CAUGHT BETWEEN YOUR TEETH:</small></td>
                                        <td>'.$row_dental_history['12'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>13. HAVE YOU EVER HAD PERIODONTAL TREATMENT:</small></td>
                                        <td>'.$row_dental_history['13'].'</td>
                                        <td><small>14. HAVE YOU EVER WORN ANY APPLIANCE:</small></td>
                                        <td>'.$row_dental_history['14'].'</td>
                                        <td><small>15. ARE YOU USING OR EVER USED DENTURE:</small></td>
                                        <td>'.$row_dental_history['15'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>16. HAVE YOU EVER HAD ANY DIFFICULT EXTRACTIONS IN THE PAST:</small></td>
                                        <td>'.$row_dental_history['16'].'</td>
                                        <td><small>17. HAVE YOU EVER HAD ANY PROLONGED BLEEDING FOLLOWING EXTRACTIONS OR CUTS:</small></td>
                                        <td>'.$row_dental_history['17'].'</td>
                                        <td><small>18. HAVE YOU EVER RECEIVED ORAL HYGIENE INSTRUCTIONS REGARDING THE CARE OF YOUR TEETH AND GUMS:</small></td>
                                        <td>'.$row_dental_history['18'].'</td>
                                    </tr>
                                    <tr>
                                        <td colspan = "6"><strong>ARE YOU ALLERGIC TO OR HAVE YOU HAD REACTIONS TO</strong></td>
                                    </tr>
                                    <tr>
                                        <td><small>1. LOCAL ANAESTHETIC LIKE LIDOCAINE:</small></td>
                                        <td>'.$row_dental_history['19'].'</td>
                                        <td><small>2. PENICILLINS OR OTHER ANTIBIOTICS:</small></td>
                                        <td>'.$row_dental_history['20'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>3. OTHER (PLEASE LIST):</small></td>
                                        <td colspan = "5">'.$row_dental_history['21'].'</td>
                                    </tr>
                                    <tr>
                                        <td colspan = "6"><strong>DO YOU HAVE OR EVER HAD THE FOLLOWING</strong></td>
                                    </tr>
                                    <tr>
                                        <td><small>1. HEART ATTACK/HEART PROBLEM/CHESTPAIN:</small></td>
                                        <td>'.$row_dental_history['22'].'</td>
                                        <td><small>2. SICKLE CELL DISEASE:</small></td>
                                        <td>'.$row_dental_history['23'].'</td>
                                        <td><small>3. HIGH/LOW BLOOD PRESSURE:</small></td>
                                        <td>'.$row_dental_history['24'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>4. HEPATITIS:</small></td>
                                        <td>'.$row_dental_history['25'].'</td>
                                        <td><small>5. LUNG OR BREATHING PROBLEM:</small></td>
                                        <td>'.$row_dental_history['26'].'</td>
                                        <td><small>6. FAINTING OF DIZZY SPELLS:</small></td>
                                        <td>'.$row_dental_history['27'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>7. DIABETES:</small></td>
                                        <td>'.$row_dental_history['28'].'</td>
                                        <td><small>8. STOMACH ULCER:</small></td>
                                        <td>'.$row_dental_history['29'].'</td>
                                        <td><small>9. PERSISTENT COUGH:</small></td>
                                        <td>'.$row_dental_history['30'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>10. EPILEPSY OR SEIZURES:</small></td>
                                        <td>'.$row_dental_history['31'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>11. OTHERS:</small></td>
                                        <td colspan = "5">'.$row_dental_history['32'].'</td>
                                    </tr>
                                    <tr>
                                        <td colspan = "6"><strong>FOR WOMEN ONLY</strong></td>
                                    </tr>
                                    <tr>
                                        <td><small>1. ARE YOU PREGNANT OR THINK YOU MAY BE PREGNANT:</small></td>
                                        <td>'.$row_dental_history['33'].'</td>
                                        <td><small>2. ARE YOU NURSING:</small></td>
                                        <td>'.$row_dental_history['34'].'</td>
                                        <td><small>3. ARE YOU TAKING BIRTH CONTROL PILLS:</small></td>
                                        <td>'.$row_dental_history['35'].'</td>
                                    </tr>';
                            };
                        ?>
                            </tbody>
                        </table>
                    <?php  
                    };
                //ASSESSMENT - EXTRA
                    $query_extra_oral = "SELECT * FROM dental_assess_extra_oral WHERE attend_id='$attend_id' AND patient_id='$patient_id'";
                    $query_run_extra_oral = mysqli_query($con, $query_extra_oral);
                    if (mysqli_num_rows($query_run_extra_oral) > 0)
                    {
                    ?>
                        <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr style="background-color:#E4DCCF; color:black">
                                    <td colspan="12">
                                        <strong>DENTAL ASSESSMENT - EXTRA ORAL</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="20%">Description</th>
                                    <th width="10%">Remarks</th>
                                    <th width="20%">Description</th>
                                    <th width="10%">Remarks</th>
                                    <th width="20%">Description</th>
                                    <th width="10%">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="pv-table-body">
                        <?php
                            while($row_extra_oral = mysqli_fetch_assoc($query_run_extra_oral))
                            {
                                echo'<tr>
                                        <td><small>Facial Type:</small></td>
                                        <td>'.$row_extra_oral['Facial_Type'].'</td>
                                        <td><small>Profile Type:</small></td>
                                        <td>'.$row_extra_oral['Profile_Type'].'</td>
                                        <td><small>Lower Facial Height</small></td>
                                        <td>'.$row_extra_oral['Lower_Facial_Height'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Transverse</small></td>
                                        <td>'.$row_extra_oral['Transverse'].'</td>
                                        <td><small>TMJ</small></td>
                                        <td>'.$row_extra_oral['TMJ'].'</td>
                                        <td><small>Lip Competence</small></td>
                                        <td>'.$row_extra_oral['Lip_Competence'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Incisor Show at Rest </small></td>
                                        <td>'.$row_extra_oral['Incisor_Show_at_Rest'].'</td>
                                        <td><small>Incisor Show when smiling </small></td>
                                        <td>'.$row_extra_oral['Incisor_Show_when_smiling'].'</td>
                                        <td><small>Naso Labial Angle</small></td>
                                        <td>'.$row_extra_oral['Naso_Labial_Angle'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Labio Mental Fold</small></td>
                                        <td>'.$row_extra_oral['Labio_Mental_Fold'].'</td>
                                        <td><small>Lip To E-Line</small></td>
                                        <td>'.$row_extra_oral['Lip_To_E_Line'].'</td>
                                        <td><small>Symmetry:</small></td>
                                        <td>'.$row_extra_oral['Symmetry'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Scars:</small></td>
                                        <td>'.$row_extra_oral['Scars'].'</td>
                                        <td><small>Lesions:</small></td>
                                        <td>'.$row_extra_oral['Lesions'].'</td>
                                        <td><small>Oral Habit:</small></td>
                                        <td>'.$row_extra_oral['Oral_Habit'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Other</small></td>
                                        <td colspan="5">'.$row_extra_oral['Other'].'</td>
                                    </tr>';
                            };
                        ?>
                            </tbody>
                        </table>
                    <?php  
                    };
                //ASSESSMENT - INTRA
                    $query_intra_oral = "SELECT * FROM dental_assess_intra_oral WHERE attend_id='$attend_id' AND patient_id='$patient_id'";
                    $query_run_intra_oral = mysqli_query($con, $query_intra_oral);
                    if (mysqli_num_rows($query_run_intra_oral) > 0)
                    {
                    ?>
                        <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr style="background-color:#E4DCCF; color:black">
                                    <td colspan="12">
                                        <strong>DENTAL ASSESSMENT - INTRA ORAL</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="20%">Description</th>
                                    <th width="10%">Remarks</th>
                                    <th width="20%">Description</th>
                                    <th width="10%">Remarks</th>
                                    <th width="20%">Description</th>
                                    <th width="10%">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="pv-table-body">
                        <?php
                            while($row_intra_oral = mysqli_fetch_assoc($query_run_intra_oral))
                            {
                                echo'<tr>
                                        <td><small>Tongue:</small></td>
                                        <td>'.$row_intra_oral['Tongue'].'</td>
                                        <td><small>Gingiva:</small></td>
                                        <td>'.$row_intra_oral['Gingiva'].'</td>
                                        <td><small>Overjet</small></td>
                                        <td>'.$row_intra_oral['Overjet'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Overbite (mm)</small></td>
                                        <td>'.$row_intra_oral['Overbite_mm'].'</td>
                                        <td><small>Overbite %</small></td>
                                        <td>'.$row_intra_oral['Overbite_perc'].'</td>
                                        <td><small>Openbite</small></td>
                                        <td>'.$row_intra_oral['Openbite'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Molar Relation R</small></td>
                                        <td>'.$row_intra_oral['Molar_Relation_R'].'</td>
                                        <td><small>Molar Relation L</small></td>
                                        <td>'.$row_intra_oral['Molar_Relation_L'].'</td>
                                        <td><small>Canine Relation R</small></td>
                                        <td>'.$row_intra_oral['Canine_Relation_R'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Canine_Relation_L</small></td>
                                        <td>'.$row_intra_oral['Canine_Relation_L'].'</td>
                                        <td><small>Incisor_Relation</small></td>
                                        <td>'.$row_intra_oral['Incisor_Relation'].'</td>
                                        <td><small>Arches U:</small></td>
                                        <td>'.$row_intra_oral['Arches_U'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Arches L:</small></td>
                                        <td>'.$row_intra_oral['Arches_L'].'</td>
                                        <td><small>Crossbites Anterior:</small></td>
                                        <td>'.$row_intra_oral['Crossbites_Anterior'].'</td>
                                        <td><small>Crossbites Posterior:</small></td>
                                        <td>'.$row_intra_oral['Crossbites_Posterior'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Curve of Spee R:</small></td>
                                        <td>'.$row_intra_oral['Curve_of_Spee_R'].'</td>
                                        <td><small>Curve of Spee L:</small></td>
                                        <td>'.$row_intra_oral['Curve_of_Spee_L'].'</td>
                                        <td><small>Stage_of_Dentition:</small></td>
                                        <td>'.$row_intra_oral['Stage_of_Dentition'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Tooth Size:</small></td>
                                        <td>'.$row_intra_oral['Tooth_Size'].'</td>
                                        <td><small>Centerlines:</small></td>
                                        <td>'.$row_intra_oral['Centerlines'].'</td>
                                        <td><small>Deviated_Remarks:</small></td>
                                        <td>'.$row_intra_oral['Deviated_Remarks'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Tonsils:</small></td>
                                        <td>'.$row_intra_oral['Tonsils'].'</td>
                                        <td><small>Lesions:</small></td>
                                        <td>'.$row_intra_oral['Lesions'].'</td>
                                        <td><small>Akerly Type:</small></td>
                                        <td>'.$row_intra_oral['Akerly_Type'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Symmetry:</small></td>
                                        <td>'.$row_intra_oral['Symmetry'].'</td>
                                        <td><small>Missing Teeth:</small></td>
                                        <td>'.$row_intra_oral['Missing_Teeth'].'</td>
                                        <td><small>Malformed_Teeth:</small></td>
                                        <td>'.$row_intra_oral['Malformed_Teeth'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Calculus:</small></td>
                                        <td>'.$row_intra_oral['Calculus'].'</td>
                                        <td><small>Other:</small></td>
                                        <td>'.$row_intra_oral['Other'].'</td>
                                        <td><small>Rotations:</small></td>
                                        <td>'.$row_intra_oral['Rotations'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Crowding:</small></td>
                                        <td>'.$row_intra_oral['Crowding'].'</td>
                                        <td><small>Spacing:</small></td>
                                        <td>'.$row_intra_oral['Spacing'].'</td>
                                        <td><small>Impacted Teeth:</small></td>
                                        <td>'.$row_intra_oral['Impacted_Teeth'].'</td>
                                    </tr>
                                    <tr>
                                        <td><small>Aesthetic:</small></td>
                                        <td>'.$row_intra_oral['Aesthetic'].'</td>
                                        <td><small>Dental nhis:</small></td>
                                        <td>'.$row_intra_oral['Dental_nhis'].'</td>
                                    </tr>';
                            };
                        ?>
                            </tbody>
                        </table>
                    <?php  
                    };
                //DENTAL CHART
                    $query_dental_chart = "SELECT * FROM dental_chart WHERE attend_id='$attend_id'";
                    $query_run_dental_chart = mysqli_query($con, $query_dental_chart);
                    if (mysqli_num_rows($query_run_dental_chart) > 0)
                    {
                    ?>
                        <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr style="background-color:#E4DCCF; color:black">
                                    <td colspan="12">
                                        <strong>DENTAL CHART</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="action-td" width="10%">DATE</th>
                                    <th class="action-td" width="10%">TOOTH</th>
                                    <th width="80%">REMARKS</th>
                                </tr>
                            </thead>
                            <tbody class="pv-table-body">
                        <?php
                            while($row_dental_chart = mysqli_fetch_assoc($query_run_dental_chart))
                            {
                                echo'<tr>
                                        <td class="action-td">'.$row_dental_chart['date'].'</td>
                                        <td class="action-td">'.$row_dental_chart['dental_teeth_id'].'</td>
                                        <td>'.$row_dental_chart['remarks'].'</td>
                                    </tr>';
                            };
                        ?>
                            </tbody>
                        </table>
                    <?php  
                    };
        };
    };
    ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>