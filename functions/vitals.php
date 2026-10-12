<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//VITALS
function save_vitals()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $temp = $_POST['temp'];
    $bsystolic = $_POST['bsystolic'];
    $bdiastolic = $_POST['bdiastolic'];
    $pulse = $_POST['pulse'];
    $rrate = $_POST['rrate'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $oxygen = $_POST['oxygen'];
    $hipcirc = $_POST['hipcirc'];
    $abdcirc = $_POST['abdcirc'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $fbs = $_POST['fbs'];
    $rbs = $_POST['rbs'];
    $vitals_comment = $_POST['vitals_comment'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "INSERT INTO `vitals`(`company_id`,`attend_id`, `patient_id`, `temp`, `bp_systolic`, 
    `bp_diastolic`, `weight`, `height`, `pulse`, `resp_rate`, `comment`, `circ_hip`, `circ_abdo`, 
    `oxygen_sat`, `date`, `time`, `user_id`, `user_create`, `user_create_timestamp`, `fbs`, `rbs`,
    `branch_id`) VALUES ('$company_id','$attend_id','$patient_id','$temp',
    '$bsystolic','$bdiastolic','$weight','$height','$pulse','$rrate','$vitals_comment','$hipcirc',
    '$abdcirc','$oxygen','$date','$time','$user_id','$user_id',NOW(),'$fbs','$rbs','$branch_id')";
    $query_run = mysqli_query($con, $query);
    
    if ($query_run)
    {
        if ($_SESSION['user_type_id'] == 6) {
            doctor_attend_register();
        };
        echo "Vital Added Successfully";
    }
    else
    {
        echo "Vital NOT Added";
    };
}

function edit_vitals()
{
    global $con;
    $vital_id = $_POST['vital_id'];
    $Vital_Data=array();
    $query = "SELECT * FROM vitals WHERE vital_id='$vital_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Vital_Data, 
            $row['vital_id'],
            $row['temp'],
            $row['bp_systolic'],
            $row['bp_diastolic'],
            $row['weight'],
            $row['height'],
            $row['pulse'],
            $row['resp_rate'],
            $row['circ_hip'],
            $row['circ_abdo'],
            $row['oxygen_sat'],
            $row['comment'],
            $row['date'],
            $row['time'],
            $row['fbs'],
            $row['rbs']
        );
    }
     echo json_encode($Vital_Data);
}

function update_vitals()
{
    global $con;
    $vital_id = $_POST['vital_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $temp = $_POST['temp'];
    $bsystolic = $_POST['bsystolic'];
    $bdiastolic = $_POST['bdiastolic'];
    $pulse = $_POST['pulse'];
    $rrate = $_POST['rrate'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $oxygen = $_POST['oxygen'];
    $hipcirc = $_POST['hipcirc'];
    $abdcirc = $_POST['abdcirc'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $fbs = $_POST['fbs'];
    $rbs = $_POST['rbs'];
    $vitals_comment = $_POST['vitals_comment'];
    $user_id = $_SESSION['user_id'];
    
    $query = "UPDATE `vitals` SET `attend_id`='$attend_id',`patient_id`='$patient_id',`temp`='$temp',
    `date`='$date',`time`='$time',`bp_systolic`='$bsystolic',`bp_diastolic`='$bdiastolic',
    `weight`='$weight',`height`='$height',`pulse`='$pulse',`resp_rate`='$rrate',
    `comment`='$vitals_comment',`circ_hip`='$hipcirc',`circ_abdo`='$abdcirc',`oxygen_sat`='$oxygen',
    `user_alter`='$user_id',`user_alter_timestamp`=NOW(),`fbs`='$fbs',`rbs`='$rbs'
    WHERE `vital_id`='$vital_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "Vital Added Successfully";
    }
    else
    {
        echo "Vital NOT Added";
    };
}

function delete_vital()
{
    global $con;
    $vital_id = $_POST['vital_id'];
    $query = "DELETE FROM `vitals` WHERE vital_id='$vital_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        echo "Vital Deleted Successfully";
    }
    else
    {
        echo "Vital NOT Deleted";
    };
}

function view_current_vitals()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];

    date_default_timezone_set("Africa/Accra");
    $date_today = date('Y-m-d');
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Temp</th>
                        <th>BP</th>
                        <th>Pulse</th>
                        <th>R.Rate</th>
                        <th>Weight</th>
                        <th>Height</th>
                        <th>SpO<sub>2</sub></th>
                        <th>FBS</th>
                        <th>RBS</th>
                        <th>H.Circ.</th>
                        <th>A.Circ.</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM vitals WHERE attend_id='$attend_id' ORDER BY date DESC, time DESC";
    $result = mysqli_query($con,$query);

    while($row=mysqli_fetch_assoc($result))
    {
        $value.='
                <tr>
                    <td>'.$row['date'].'</td>
                    <td>'.$row['time'].'</td>
                       <td>'.$row['temp'].'</td>
                    <td>'.$row['bp_systolic'].'/'.$row['bp_diastolic'].'</td>
                    <td>'.$row['pulse'].'</td>
                    <td>'.$row['resp_rate'].'</td>
                    <td>'.$row['weight'].'</td>
                    <td>'.$row['height'].'</td>
                    <td>'.$row['oxygen_sat'].'</td>
                    <td>'.$row['fbs'].'</td>
                    <td>'.$row['rbs'].'</td>
                    <td>'.$row['circ_hip'].'</td>
                    <td>'.$row['circ_abdo'].'</td>
                    <td>'.$row['comment'].'</td>
                    <td>';
                if (/*$_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND*/ $_SESSION['user_id'] == $row['user_id']) 
                {
                    if($row['date'] == $date_today)
                    {
                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Vitals'] == 'Yes')) 
                        {
                            $value.='<a href="#" id="btn_edit_vital" data-id1="'.$row['vital_id'].'">Edit</a>';
                        };
                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Vitals'] == 'Yes')) 
                        {
                            $value.=' | <a href="#" id="btn_delete_vital" data-id2="'.$row['vital_id'].'"> Delete</a>';
                        };
                    };
                };
           $value.='</td>
                </tr>';
    }
    $value.='</tbody>
            </table>';
    echo $value;
}

function save_fluid()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $fb_oral_input = $_POST['fb_oral_input'];
    $fb_oral_input_mls = $_POST['fb_oral_input_mls'];
    $fb_ivi_input = $_POST['fb_ivi_input'];
    $fb_ivi_input_mls = $_POST['fb_ivi_input_mls'];
    $fb_cum_input = $_POST['fb_cum_input'];
    $fb_vomit = $_POST['fb_vomit'];
    $fb_urine = $_POST['fb_urine'];
    $fb_bowels = $_POST['fb_bowels'];
    $fb_cum_output = $_POST['fb_cum_output'];
    $date = $_POST['fd_date'];
    $time = $_POST['fb_time'];
    $fb_comment = $_POST['fb_comment'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "INSERT INTO `fluid_data`(`company_id`,`attend_id`, `patient_id`, `oral_input`, 
    `oral_input_qty`, `ivi_input`, `ivi_input_qty`, `cum_input`, `vomit_qty`, `urine_qty`, 
    `bowels_qty`, `cum_output`, `comment`,  `date`, `time`, `user_id`, `created_by`, 
    `created_datetime`) VALUES ('$company_id','$attend_id','$patient_id','$fb_oral_input',
    '$fb_oral_input_mls','$fb_ivi_input','$fb_ivi_input_mls','$fb_cum_input','$fb_vomit',
    '$fb_urine','$fb_bowels','$fb_cum_output',
    '$fb_comment','$date','$time','$user_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        if ($_SESSION['user_type_id'] == 6) {
            doctor_attend_register();
        };
        echo "Fluid Added Successfully";
    }
    else
    {
        echo "Fluid NOT Added";
    };
}

function edit_fluid()
{
    global $con;
    $fluid_data_id = $_POST['fluid_data_id'];
    $Fluid_Data=array();
    $query = "SELECT * FROM fluid_data WHERE fluid_data_id='$fluid_data_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Fluid_Data, 
            $row['fluid_data_id'],
            $row['oral_input'],
            $row['oral_input_qty'],
            $row['ivi_input'],
            $row['ivi_input_qty'],
            $row['cum_input'],
            $row['vomit_qty'],
            $row['urine_qty'],
            $row['bowels_qty'],
            $row['cum_output'],
            $row['date'],
            $row['time'],
            $row['comment']
        );
    }
     echo json_encode($Fluid_Data);
}

function update_fluid()
{
    global $con;
    $fluid_data_id = $_POST['fluid_data_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $fb_oral_input = $_POST['fb_oral_input'];
    $fb_oral_input_mls = $_POST['fb_oral_input_mls'];
    $fb_ivi_input = $_POST['fb_ivi_input'];
    $fb_ivi_input_mls = $_POST['fb_ivi_input_mls'];
    $fb_cum_input = $_POST['fb_cum_input'];
    $fb_vomit = $_POST['fb_vomit'];
    $fb_urine = $_POST['fb_urine'];
    $fb_bowels = $_POST['fb_bowels'];
    $fb_cum_output = $_POST['fb_cum_output'];
    $date = $_POST['fd_date'];
    $time = $_POST['fb_time'];
    $fb_comment = $_POST['fb_comment'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "UPDATE `fluid_data` SET `company_id`='$company_id',`attend_id`='$attend_id', 
    `patient_id`='$patient_id', `oral_input`='$fb_oral_input', `oral_input_qty`='$fb_oral_input_mls', 
    `ivi_input`='$fb_ivi_input', `ivi_input_qty`='$fb_ivi_input_mls', `cum_input`='$fb_cum_input', 
    `vomit_qty`='$fb_vomit', `urine_qty`='$fb_urine', `bowels_qty`='$fb_bowels', `cum_output`='$fb_cum_output', 
    `comment`='$fb_comment', `date`='$date', `time`='$time', `altered_by`='$user_id', 
    `altered_datetime`=NOW() WHERE `fluid_data_id`='$fluid_data_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        if ($_SESSION['user_type_id'] == 6) {
            doctor_attend_register();
        };
        echo "Fluid Updated Successfully";
    }
    else
    {
        echo "Fluid NOT Updated";
    };
}

function delete_fluid()
{
    global $con;
    $fluid_data_id = $_POST['fluid_data_id'];
    $query = "DELETE FROM `fluid_data` WHERE fluid_data_id='$fluid_data_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        echo "Vital Deleted Successfully";
    }
    else
    {
        echo "Vital NOT Deleted";
    };
}

function view_current_fluid()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    date_default_timezone_set("Africa/Accra");
    $date_today = date('Y-m-d');
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" id="attendfluidTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Oral Input</th>
                        <th>Oral (mls)</th>
                        <th>IVI Input</th>
                        <th>IVI (mls)</th>
                        <th>Cum. Input (mls)</th>
                        <th>Vomit (mls)</th>
                        <th>Urine (mls)</th>
                        <th>Bowels (mls)</th>
                        <th>Cum. Output (mls)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    
                $query_fluid = "SELECT * FROM fluid_data WHERE attend_id='$attend_id' ORDER BY date DESC";
                $query_run_fluid = mysqli_query($con, $query_fluid);
                if (mysqli_num_rows($query_run_fluid) > 0)
                {
                    while($row_fluid=mysqli_fetch_assoc($query_run_fluid))
                    {
        $value.='<tr>
                    <td>'.$row_fluid['date'].'</td>
                    <td>'.$row_fluid['time'].'</td>
                    <td>'.$row_fluid['oral_input'].'</td>
                    <td>'.$row_fluid['oral_input_qty'].'</td>
                    <td>'.$row_fluid['ivi_input'].'</td>
                    <td>'.$row_fluid['ivi_input_qty'].'</td>
                    <td>'.$row_fluid['cum_input'].'</td>
                    <td>'.$row_fluid['vomit_qty'].'</td>
                    <td>'.$row_fluid['urine_qty'].'</td>
                    <td>'.$row_fluid['bowels_qty'].'</td>
                    <td>'.$row_fluid['cum_output'].'</td>
                    <td>';
                    if ($_SESSION['user_id'] == $row_fluid['user_id']) 
                    {
                        if($row_fluid['date'] == $date_today)
                        {
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Vitals'] == 'Yes')) 
                            {
                                $value.='<a href="#" id="btn_edit_fluid" data-id1="'.$row_fluid['fluid_data_id'].'">Edit</a>';
                            };
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Vitals'] == 'Yes')) 
                            {
                                $value.=' | <a href="#" id="btn_delete_fluid" data-id2="'.$row_fluid['fluid_data_id'].'"> Delete</a>';
                            };
                        };
                    };
            $value.='</td>
                </tr>';
                };
            };
    $value.='</tbody>
            </table>';
    echo $value;
}

function view_vitals_history()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Temp</th>
                        <th>BP</th>
                        <th>Pulse</th>
                        <th>R.Rate</th>
                        <th>Weight</th>
                        <th>Height</th>
                        <th>SpO<sub>2</sub></th>
                        <th>H.Circ.</th>
                        <th>A.Circ.</th>
                        <th>comment</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM vitals WHERE patient_id=$patient_id ORDER BY date DESC";
    $result = mysqli_query($con,$query);

    while($row=mysqli_fetch_assoc($result))
    {
        $value.='
                <tr>
                    <td>'.$row['date'].'</td>
                    <td>'.$row['temp'].'</td>
                    <td>'.$row['bp_systolic'].'/'.$row['bp_diastolic'].'</td>
                    <td>'.$row['pulse'].'</td>
                    <td>'.$row['resp_rate'].'</td>
                    <td>'.$row['weight'].'</td>
                    <td>'.$row['height'].'</td>
                    <td>'.$row['oxygen_sat'].'</td>
                    <td>'.$row['circ_hip'].'</td>
                    <td>'.$row['circ_abdo'].'</td>
                    <td>'.$row['comment'].'</td>
                </tr>';
    }
    $value.='</tbody>
            </table>';
    echo $value;
}

?>
