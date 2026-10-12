<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//ADMISSIONS/REFERRALS/DISCHARGES
function check_wardlist_attend_duplicate()
{
    global $con;
    $ward = $_POST['ward'];
    $bed = $_POST['bed'];
    $attend_id = $_POST['attend_id'];
    $wardlist_dup=array();
    $query = "SELECT * FROM wardlist WHERE ward_id='$ward' AND bed_id='$bed' AND attend_id='$attend_id'";
    $result = mysqli_query($con,$query);
        if (mysqli_num_rows($result) > 0)
        {
            $query_ward = "SELECT * FROM ward WHERE ward_id='$ward'";
            $result_ward = mysqli_query($con,$query_ward);
            $row_ward=mysqli_fetch_assoc($result_ward);

            array_push($wardlist_dup, 'duplicate',$row_ward['ward']);
        }
        else
        {
             array_push($wardlist_dup, 'none');

        }
    echo json_encode($wardlist_dup);
}

function available_bed_list()
{
    global $con;
    $ward_id = $_POST['ward_id'];
    $options = '';
    
    $query = "SELECT * FROM bed WHERE ward_id = '$ward_id'";
    $result = mysqli_query($con,$query);
    $options .= '<option value="0">Please select</option>';
    while($row = mysqli_fetch_assoc($result))
    {
        $bed_id = $row['bed_id'];
        $query_obl = "SELECT * FROM wardlist WHERE bed_id='$bed_id' AND 
        LENGTH(type_of_discharge) < 1";
        $result_obl = mysqli_query($con,$query_obl);

        if (!empty($result_obl) && mysqli_num_rows($result_obl) < 1) 
        {
            $options .= '<option value="'.$row['bed_id'].'">'.$row['bed'].'</option>';
        };
    };
    echo $options;
}

function save_wardlist_attend()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $ward = $_POST['ward'];
    $bed = $_POST['bed'];
    $date = $_POST['date'];
    $officer = $_POST['officer'];
    $comment = $_POST['comment'];
    $sponsor = $_POST['sponsor'];
    $type = $_POST['type'];
    $age = $_POST['age'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "INSERT INTO `wardlist`(`company_id`, `attend_id`, `patient_id`, `ward_id`, 
    `date_in`, `bed_id`, `admitting_doctor`, `comment`, `ledger_id`, `type_of_adimission`,
    `branch_id`, `created_by`, `created_datetime`) 
    VALUES ('$company_id','$attend_id','$patient_id','$ward','$date','$bed','$officer',
    '$comment','$sponsor','$type','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        $query = "UPDATE `attendance` SET `tos_id`=2,`outcome`='on_admission',`date_disch`='' 
        WHERE `attend_id`='$attend_id'";
        mysqli_query($con, $query);

        $query_pay_type = "SELECT * FROM `payment_type` WHERE `attend_id`='$attend_id' 
        AND `principal`='Yes' AND `ledger_id`=2";
        $query_run_pay_type = mysqli_query($con, $query_pay_type);
        if (mysqli_num_rows($query_run_pay_type) > 0)
        {
            $row_pay_type = mysqli_fetch_assoc($query_run_pay_type);
            $pay_type_id = $row_pay_type['pay_type_id'];
            $query_procedure_check = "SELECT * FROM surgery_list WHERE `attend_id`='$attend_id'
            ORDER BY surgery_list_id ASC";
            $query_run_procedure_check = mysqli_query($con, $query_procedure_check);
            if (mysqli_num_rows($query_run_procedure_check) > 0)
            {
                $row_procedure_check = mysqli_fetch_assoc($query_run_procedure_check);
                $surgery_list_id = $row_procedure_check['surgery_list_id'];
                $surgery_id = $row_procedure_check['surgery_id'];
                
                $query_procedure = "SELECT * FROM `surgery` WHERE `surgery_id`='$surgery_id'";
                $query_run_procedure = mysqli_query($con, $query_procedure);
                if($query_run_procedure)
                {
                    $row_procedure = mysqli_fetch_assoc($query_run_procedure);
                    $nhis_id = $row_procedure['nhis_id'];
                    if(isset($nhis_id) && $nhis_id > 0)
                    {
                        $query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
                        $query_run_nhis = mysqli_query($con, $query_nhis);
                        $row_nhis = mysqli_fetch_assoc($query_run_nhis);
                        if($age < 12)
                        {
                            $gdrg_nhis = $row_nhis['gdrg_child'];
                            $price_nhis = $row_nhis['price_child'];
                        }
                        else
                        {
                            $gdrg_nhis = $row_nhis['gdrg_adult'];
                            $price_nhis = $row_nhis['price_adult'];
                        };

                        $query_procedure_list = "UPDATE `surgery_list` SET `is_principal`='Yes'
                        WHERE `surgery_list_id`='$surgery_list_id'";
                        $query_run_procedure_list = mysqli_query($con, $query_procedure_list);
                        if($query_run_procedure_list)
                        {
                            $query_pt = "UPDATE `payment_type` SET `amt_out_patient`='', 
                            `gdrg_out_patient`='',`amt_in_patient`='$price_nhis', 
                            `gdrg_in_patient`='$gdrg_nhis', `principal_gdrg`='$gdrg_nhis'
                            WHERE `pay_type_id`='$pay_type_id'";
                        };
                    };
                };
            }
            else
            {
                $query_diagnosis_check = "SELECT * FROM diagnosis_list WHERE `attend_id`='$attend_id'
                ORDER BY diagnosis_list_id ASC";
                $query_run_diagnosis_check = mysqli_query($con, $query_diagnosis_check);
                if (mysqli_num_rows($query_run_diagnosis_check) > 0)
                {
                    $row_diagnosis_check = mysqli_fetch_assoc($query_run_diagnosis_check);
                    $diagnosis_list_id = $row_diagnosis_check['diagnosis_list_id'];
                    $diagnosis_id = $row_diagnosis_check['diagnosis_id'];
                    
                    $query_diagnosis = "SELECT * FROM `diagnosis` WHERE `diagnosis_id`='$diagnosis_id'";
                    $query_run_diagnosis = mysqli_query($con, $query_diagnosis);
                    if($query_run_diagnosis)
                    {
                        $row_diagnosis = mysqli_fetch_assoc($query_run_diagnosis);
                        $nhis_id = $row_diagnosis['nhis_id'];
                        if(isset($nhis_id) && $nhis_id > 0)
                        {
                            $query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
                            $query_run_nhis = mysqli_query($con, $query_nhis);
                            $row_nhis = mysqli_fetch_assoc($query_run_nhis);
                            if($age < 12)
                            {
                                $gdrg_nhis = $row_nhis['gdrg_child'];
                                $price_nhis = $row_nhis['price_child'];
                            }
                            else
                            {
                                $gdrg_nhis = $row_nhis['gdrg_adult'];
                                $price_nhis = $row_nhis['price_adult'];
                            };

                            $query_diagnosis_list = "UPDATE `diagnosis_list` SET `is_principal`='Yes'
                            WHERE `diagnosis_list_id`='$diagnosis_list_id'";
                            $query_run_diagnosis_list = mysqli_query($con, $query_diagnosis_list);
                            if($query_run_diagnosis_list)
                            {
                                $query_pt = "UPDATE `payment_type` SET `amt_out_patient`='', 
                                `gdrg_out_patient`='',`amt_in_patient`='$price_nhis', 
                                `gdrg_in_patient`='$gdrg_nhis', `principal_gdrg`='$gdrg_nhis'
                                WHERE `pay_type_id`='$pay_type_id'";
                            };
                        };
                    };
                };
            };
        };
    }
    else
    {
        echo "Wardlist NOT Added";
    };
}

function edit_wardlist_attend()
{
    global $con;
    $wardlist_id = $_POST['wardlist_id'];
    $Wardlist_Data=array();
    $query = "SELECT * FROM wardlist WHERE wardlist_id=$wardlist_id";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Wardlist_Data, 
            $row['date_in'],
            $row['ward_id'],
            $row['attend_id'],
            $row['patient_id'],
            $row['wardlist_id'],
            $row['comment'],
            $row['type_of_adimission'],
            $row['admitting_doctor'],
            $row['ledger_id'],
            $row['bed_id']
        );
    }
     echo json_encode($Wardlist_Data);
}

function update_wardlist_attend()
{
    global $con;
    $wardlist_id = $_POST['wardlist_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $ward = $_POST['ward'];
    $bed = $_POST['bed'];
    $date = $_POST['date'];
    $officer = $_POST['officer'];
    $comment = $_POST['comment'];
    $sponsor = $_POST['sponsor'];
    $type = $_POST['type'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "UPDATE `wardlist` SET `attend_id`='$attend_id',`patient_id`='$patient_id',
    `ward_id`='$ward',`comment`='$comment',`ledger_id`='$sponsor',`date_in`='$date',
    `bed_id`='$bed',`admitting_doctor`='$officer',`type_of_adimission`='$type',
    `altered_by`='$user_id',`altered_datetime`=NOW()
    WHERE `wardlist_id`='$wardlist_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "Wardlist Updated Successfully";
    }
    else
    {
        echo "Wardlist NOT Updated";
    };
}

function view_current_wardlist()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Ward</th>
                        <th>Bed</th>
                        <th>Date In</th>
                        <th>Type of Admission</th>
                        <th>Admitting Officer</th>
                        <th>Date Out</th>
                        <th>Type of Discharge</th>
                        <th>Discharging Officer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query_attend = "SELECT * FROM attendance WHERE attend_id='$attend_id' AND outcome != 'on_admission'";
    $query_run_attend = mysqli_query($con, $query_attend);
    $active_attend_rows = mysqli_num_rows($query_run_attend);

    $query_wardlist = "SELECT * FROM wardlist WHERE attend_id='$attend_id' ORDER BY date_in DESC";
    $query_run_wardlist = mysqli_query($con, $query_wardlist);
    if (mysqli_num_rows($query_run_wardlist) > 0)
        {
            while($row=mysqli_fetch_assoc($query_run_wardlist))
            {
                $ward_id = $row['ward_id'];
                $bed_id = $row['bed_id'];
                $query = "SELECT * FROM ward WHERE ward_id='$ward_id'";
                $query_run_ward = mysqli_query($con, $query);
                $row_ward=mysqli_fetch_assoc($query_run_ward);

                $query = "SELECT * FROM bed WHERE ward_id='$ward_id' AND bed_id='$bed_id'";
                $query_run_bed = mysqli_query($con, $query);
                $row_bed=mysqli_fetch_assoc($query_run_bed);
                $value.='
                    <tr>
                        <td>';
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Patient_Admission'] == 'Yes')) 
                            {
                                $value.='<a href="#" id="btn_edit_wardlist" data-id1="'.$row['wardlist_id'].'">'.$row_ward['ward'].'</a>';
                            }
                            else
                            {
                                $value.= $row_ward['ward'];
                            };
                            
               $value.='</td>
                        <td>'.$row_bed['bed'].'</td>
                        <td>'.$row['date_in'].'</td>
                        <td>'.$row['type_of_adimission'].'</td>
                        <td>'.$row['admitting_doctor'].'</td>
                        <td>'.$row['date_out'].'</td>
                        <td>'.$row['type_of_discharge'].'</td>
                        <td>'.$row['discharging_doctor'].'</td>
                        <td>';
                        if($active_attend_rows <= 0)
                        {
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Patient_Transfer'] == 'Yes')) 
                            {
                                $value.='<a href="#" id="btn_transfer_wardlist" data-id2="'.$row['wardlist_id'].'">Transfer</a> | ';
                            };

                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Patient_Discharge'] == 'Yes')) 
                            {
                                $value.='<a href="#" id="btn_discharge_wardlist" data-id2="'.$row['wardlist_id'].'">Discharge</a> | ';
                            };
                        };
                            
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Patient_Admission'] == 'Yes')) 
                            {
                                $value.='<a href="#" id="btn_delete_wardlist" data-id2="'.$row['wardlist_id'].'">Delete</a>';
                            };
               $value.='</td>
                    </tr>';
            };
        };
    $value.='</tbody>
            </table>';
    echo $value;
}

function view_wardlist_history()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Ward</th>
                        <th>Bed</th>
                        <th>Date In</th>
                        <th>Date Out</th>
                        <th>Type of Admission</th>
                        <th>Admitting Officer</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query_wardlist = "SELECT * FROM wardlist WHERE attend_id='$attend_id' ORDER BY date_in DESC";
    $query_run_wardlist = mysqli_query($con, $query_wardlist);
    if (mysqli_num_rows($query_run_wardlist) > 0)
        {
            while($row=mysqli_fetch_assoc($query_run_wardlist))
            {
                $ward_id = $row['ward_id'];
                $bed_id = $row['bed_id'];
                $query = "SELECT * FROM ward WHERE ward_id='$ward_id'";
                $query_run_ward = mysqli_query($con, $query);
                $row_ward=mysqli_fetch_assoc($query_run_ward);

                $query = "SELECT * FROM bed WHERE ward_id='$ward_id' AND bed_id='$bed_id'";
                $query_run_bed = mysqli_query($con, $query);
                $row_bed=mysqli_fetch_assoc($query_run_bed);
                $value.='
                        <tr>
                        <td><a href="#" id="btn_edit_wardlist" data-id1="'.$row['wardlist_id'].'">'.$row_ward['ward'].'</a></td>
                        <td>'.$row_bed['bed'].'</td>
                        <td>'.$row['date_in'].'</td>
                        <td>'.$row['date_out'].'</td>
                        <td>'.$row['type_of_adimission'].'</td>
                        <td>'.$row['admitting_doctor'].'</td>
                    </tr>';
            
            };
        };
    $value.='</tbody>
            </table>';
    echo $value;
}

function transfer_wardlist_attend()
{
    global $con;
    $wardlist_id = $_POST['wardlist_id'];
    $Wardlist_Data=array();
    $query = "SELECT * FROM wardlist WHERE wardlist_id=$wardlist_id";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Wardlist_Data, 
            $row['ward_id'],
            $row['bed_id'],
            $row['wardlist_id'],
            $row['date_in'],
            $row['admitting_doctor'],
            $row['type_of_adimission'],
            $row['wardlist_id']
        );
    }
     echo json_encode($Wardlist_Data);
}

function transfer_available_bed_list()
{
    global $con;
    $ward_id = $_POST['ward_id'];
    $options = '';
    
    $query = "SELECT * FROM bed WHERE ward_id = '$ward_id'";
    $result = mysqli_query($con,$query);
    $options .= '<option value="0">Please select</option>';
    while($row = mysqli_fetch_assoc($result))
    {
        $bed_id = $row['bed_id'];
        $query_obl = "SELECT * FROM wardlist WHERE bed_id='$bed_id' AND 
        LENGTH(type_of_discharge) < 1";
        $result_obl = mysqli_query($con,$query_obl);

        if (!empty($result_obl) && mysqli_num_rows($result_obl) < 1) 
        {
            $options .= '<option value="'.$row['bed_id'].'">'.$row['bed'].'</option>';
        };
    };
    
    echo $options;
}

function save_transfer_wardlist_attend()
{
    global $con;
    $wardlist_id = $_POST['wardlist_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $ward = $_POST['ward'];
    $bed = $_POST['bed'];
    $date = $_POST['date'];
    $officer = $_POST['officer'];
    $comment = $_POST['comment'];
    $sponsor = $_POST['sponsor'];
    $type = $_POST['type'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "INSERT INTO `wardlist`(`company_id`, `attend_id`, `patient_id`, `ward_id`, `date_in`, 
    `bed_id`, `admitting_doctor`, `comment`, `ledger_id`, `type_of_adimission`,
    `branch_id`, `created_by`, `created_datetime`
    ) VALUES (
    '$company_id','$attend_id','$patient_id','$ward','$date','$bed','$officer','$comment',
    '$sponsor','$type','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        $query = "UPDATE `wardlist` SET `date_out`='$date',`discharging_doctor`='$officer',
        `type_of_discharge`='transferred_out',`altered_by`='$user_id',`altered_datetime`=NOW() 
        WHERE `wardlist_id`='$wardlist_id'";
        $query_run = mysqli_query($con, $query);
    }
    else
    {
        echo "Wardlist NOT Added";
    };
}

function discharge_wardlist_attend()
{
    global $con;
    $wardlist_id = $_POST['wardlist_id'];
    $Wardlist_Data = array();
    $query = "SELECT * FROM wardlist WHERE wardlist_id=$wardlist_id";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_assoc($result))
    {
        array_push($Wardlist_Data, 
            $row['ward_id'],
            $row['bed_id'],
            $row['wardlist_id']
        );
    }
     echo json_encode($Wardlist_Data);
}

function save_discharge_wardlist_attend()
{
    global $con;
    $wardlist_id = $_POST['wardlist_id'];
    $date = $_POST['date'];
    $officer = $_POST['officer'];
    $comment = $_POST['comment'];
    $type = $_POST['type'];
    $attend_id = $_POST['attend_id'];
    
    $query = "UPDATE `wardlist` SET `comment`='$comment',`date_out`='$date',
    `discharging_doctor`='$officer',`type_of_discharge`='$type' 
    WHERE `wardlist_id`='$wardlist_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        $query = "UPDATE `attendance` SET `outcome`='$type',`date_disch`='$date' WHERE 
        `attend_id`='$attend_id'";
        $query_run = mysqli_query($con, $query);

        $query = "UPDATE `payment_type` SET `date_disch`='$date' WHERE `attend_id`='$attend_id'";
        $query_run = mysqli_query($con, $query);
    }
    else
    {
        echo "Wardlist NOT Updated";
    };
}

function delete_wardlist_attend()
{
    global $con;
    $wardlist_id = $_POST['wardlist_id'];
    $attend_id = $_POST['attend_id'];
    $date_admit = $_POST['date_admit'];
    $query = "DELETE FROM `wardlist` WHERE wardlist_id='$wardlist_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        $query = "SELECT * FROM `wardlist` WHERE attend_id='$attend_id'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            echo "Wardlist Deleted";
        }
        else
        {
            $query = "UPDATE `attendance` SET `tos_id`=1,`outcome`='discharged',`date_disch`='$date_admit' WHERE `attend_id`='$attend_id'";
            $query_run = mysqli_query($con, $query);
        };
        
    }
    else
    {
        echo "Wardlist NOT Deleted";
    };
}

function save_referral_attend()
{
    global $con;
    $facility = $_POST['facility'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $doctor = $_POST['doctor'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $alertness = $_POST['alertness'];
    $walking = $_POST['walking'];
    $illness_state = $_POST['illness_state'];
    $urgency = $_POST['urgency'];
    $accompanied = $_POST['accompanied'];
    $staff_name = $_POST['staff_name'];
    $reason = $_POST['reason'];
    $action_taken = $_POST['action_taken'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "INSERT INTO `referral`(`company_id`, `attend_id`, `patient_id`, `facility`, 
    `doctor`, `date`, `time`, `alertness`, `walking`, `illness_state`, `urgency`, 
    `accompanied`, `staff_name`, `reason`, `action`, `branch_id`, `created_by`, `created_datetime`) 
    VALUES ('$company_id','$attend_id','$patient_id','$facility','$doctor','$date','$time',
    '$alertness','$walking','$illness_state','$urgency','$accompanied','$staff_name','$reason',
    '$action_taken','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        $query = "UPDATE `wardlist` SET `date_out`='$date',`discharging_doctor`='$doctor',
        `type_of_discharge`='referred_out',`altered_by`='$user_id',`altered_datetime`=NOW() WHERE `attend_id`='$attend_id' AND 
        `type_of_discharge`=''";
        $query_run = mysqli_query($con, $query);

        $query = "UPDATE `attendance` SET `outcome`='referred_out',`date_disch`='$date' WHERE `attend_id`='$attend_id'";
        $query_run = mysqli_query($con, $query);

        $query = "UPDATE `payment_type` SET `date_disch`='$date' WHERE `attend_id`='$attend_id'";
        $query_run = mysqli_query($con, $query);
        echo 1;
    }
    else
    {
        echo 0;
    };
}

function edit_referral_attend()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $Data=array();
    $query = "SELECT * FROM referral WHERE attend_id = $attend_id";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Data, 
            $row['referral_id'],
            $row['facility'],
            $row['urgency'],
            $row['accompanied'],
            $row['doctor'],
            $row['date'],
            $row['time'],
            $row['alertness'],
            $row['walking'],
            $row['illness_state'],
            $row['staff_name'],
            $row['reason'],
            $row['action']
        );
    }
     echo json_encode($Data);
}

function update_referral_attend()
{
    global $con;
    $referral_id = $_POST['referral_id'];
    $facility = $_POST['facility'];
    $doctor = $_POST['doctor'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $alertness = $_POST['alertness'];
    $walking = $_POST['walking'];
    $illness_state = $_POST['illness_state'];
    $urgency = $_POST['urgency'];
    $accompanied = $_POST['accompanied'];
    $staff_name = $_POST['staff_name'];
    $reason = $_POST['reason'];
    $action_taken = $_POST['action_taken'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "UPDATE `referral` SET `facility`='$facility', `doctor`='$doctor', `date`='$date', 
    `time`='$time', `alertness`='$alertness', `walking`='$walking', `illness_state`='$illness_state', 
    `urgency`='$urgency', `accompanied`='$accompanied', `staff_name`='$staff_name', 
    `reason`='$reason', `action`='$action_taken', `altered_by`='$user_id', `altered_datetime`=NOW()
    WHERE `referral_id`='$referral_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo 1;
    }
    else
    {
        echo 0;
    };
}

function referral_note_display()
{
    global $con;
    $_SESSION['company_id'] = $_POST['company_id'];
    $_SESSION['attend_id'] = $_POST['attend_id'];
}

?>
