<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//MGT PLAN AND NURSES NOTES
function save_mgt_plan()
{
    global $con;
    $management_plan = $_POST['management_plan'];
    $management_plan = addslashes($management_plan);
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $management_plan_initials = $_POST['management_plan_initials'];
    $management_plan_date = $_POST['management_plan_date'];
    $management_plan_time = $_POST['management_plan_time'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "INSERT INTO `management_plan`(`company_id`,`mgt_notes`, `attend_id`, 
    `patient_id`, `initials`, `date`, `time`, `user_id`, `created_by`, `created_datetime`, `branch_id`) 
    VALUES ('$company_id','$management_plan','$attend_id','$patient_id','$management_plan_initials',
    '$management_plan_date','$management_plan_time','$user_id','$user_id',NOW(),'$branch_id')";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        if ($_SESSION['user_type_id'] == 6) {
            doctor_attend_register();
        };
        view_current_mgt_plan();
    }
    else
    {
        echo "Management Plan NOT Added";
    };
}

function edit_mgt_plan()
{
    global $con;
    $management_plan_id = $_POST['management_plan_id'];
    $Data=array();
    $query = "SELECT * FROM management_plan WHERE mp_id=$management_plan_id";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Data, 
            $row['mp_id'],
            $row['mgt_notes'],
            $row['initials'],
            $row['date'],
            $row['time']
        );
    }
     echo json_encode($Data);
}

function update_mgt_plan()
{
    global $con;
    $management_plan_id = $_POST['management_plan_id'];
    $management_plan = $_POST['management_plan'];
    $management_plan = addslashes($management_plan);
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $management_plan_initials = $_POST['management_plan_initials'];
    $management_plan_date = $_POST['management_plan_date'];
    $management_plan_time = $_POST['management_plan_time'];
    $user_id = $_SESSION['user_id'];
    
    $query = "UPDATE `management_plan` SET `attend_id`='$attend_id',
    `patient_id`='$patient_id',`mgt_notes`='$management_plan',
    `initials`='$management_plan_initials',
    `date`='$management_plan_date',`time`='$management_plan_time',
    `altered_by`='$user_id',`altered_datetime`=NOW() WHERE 
    `mp_id`='$management_plan_id'";

    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        view_current_mgt_plan();
    }
    else
    {
        echo "Management Plan NOT Updated";
    };
}

function view_current_mgt_plan()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    date_default_timezone_set("Africa/Accra");
    $date_today = date('Y-m-d');
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Initials</th>
                        <th>Management Plan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM management_plan WHERE attend_id='$attend_id' ORDER BY date DESC, time DESC";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
            {
                while($row=mysqli_fetch_assoc($query_run))
                    {
                        $value.='<tr>
                        <td>'.$row['date'].'</td>
                        <td>'.$row['time'].'</td>
                        <td>'.$row['initials'].'</td>
                        <td>'.$row['mgt_notes'].'</td>
                        <td>';
                            
                            if ($_SESSION['user_id'] == $row['user_id']) 
                            {
                                if($row['date'] == $date_today)
                                {
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Mgt_Plan'] == 'Yes')) 
                                    {
                                        $value.='<a href="#" id="btn_edit_management_plan" data-id="'.$row['mp_id'].'">Edit</a>';
                                    };
                                    if (
                                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                        $_SESSION['user_type'] == 'Super_User' OR 
                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Mgt_Plan'] == 'Yes')) 
                                    {
                                        $value.=' | <a href="#" id="btn_delete_management_plan" data-id="'.$row['mp_id'].'">Delete</a>';
                                    };
                                };
                            };
                            
                            $value.='</td>
                    </tr>';
                    }
            }
            else
            {
                echo 'No Record Found';
            };
    $value.='</tbody>
            </table>';
    echo $value;
}

function view_mgt_plan_history()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Initials</th>
                        <th>Management Plan</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM management_plan WHERE patient_id=$patient_id ORDER BY date DESC";
    $result = mysqli_query($con,$query);

    while($row=mysqli_fetch_assoc($result))
    {
        $value.='<tr>
                    <td><a href="#" id="btn_edit_mgt_plan" data-id1="'.$row['mp_id'].'">'.$row['date'].'</a></td>
                    <td>'.$row['time'].'</td>
                    <td>'.$row['initials'].'</td>
                    <td>'.$row['mgt_notes'].'</td>
                </tr>';
    }
    $value.='</tbody>
            </table>';
    echo $value;
}

function delete_mgt_plan()
{
    global $con;
    $mp_id = $_POST['mp_id'];
    $attend_id = $_POST['attend_id'];
    $query = "DELETE FROM `management_plan` WHERE mp_id='$mp_id'";
    $query_run = mysqli_query($con, $query);
    If ($query_run)
    {
        echo "Management Plan Deleted";
    }
    else
    {
        echo "Management Plan NOT Deleted";
    };
}

function save_nurses_notes()
{
    global $con;
    $nurses_notes = $_POST['nurses_notes'];
    $nurses_notes = addslashes($nurses_notes);
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $nnotes_initials = $_POST['nnotes_initials'];
    $nnotes_date = $_POST['nnotes_date'];
    $nnotes_time = $_POST['nnotes_time'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "INSERT INTO `nurses_notes`(`company_id`,`nurses_notes`, `attend_id`, 
    `patient_id`, `initials`, `date`,`time`, `user_id`, `created_by`, `created_datetime`, `branch_id`) 
    VALUES ('$company_id','$nurses_notes','$attend_id','$patient_id','$nnotes_initials',
    '$nnotes_date','$nnotes_time','$user_id','$user_id',NOW(),'$branch_id')";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        view_current_nurses_notes();
    }
    else
    {
        echo "Nurses Notes NOT Added";
    };
}

function edit_nurses_notes()
{
    global $con;
    $nn_id = $_POST['nn_id'];
    $Data=array();
    $query = "SELECT * FROM nurses_notes WHERE nn_id=$nn_id";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Data, 
            $row['nn_id'],
            $row['nurses_notes'],
            $row['initials'],
            $row['date'],
            $row['time']
        );
    }
     echo json_encode($Data);
}

function update_nurses_notes()
{
    global $con;
    $nn_id = $_POST['nn_id'];
    $nurses_notes = $_POST['nurses_notes'];
    $nurses_notes = addslashes($nurses_notes);
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $nnotes_initials = $_POST['nnotes_initials'];
    $nnotes_date = $_POST['nnotes_date'];
    $nnotes_time = $_POST['nnotes_time'];
    $user_id = $_SESSION['user_id'];
    
    $query = "UPDATE `nurses_notes` SET `attend_id`='$attend_id',
    `patient_id`='$patient_id',`nurses_notes`='$nurses_notes',
    `initials`='$nnotes_initials',`date`='$nnotes_date',`time`='$nnotes_time',
    `altered_by`='$user_id',`altered_datetime`=NOW()
    WHERE `nn_id`='$nn_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        view_current_nurses_notes();			    }
    else
    {
        echo "Nurses Notes NOT Updated";
    };
}

function view_current_nurses_notes()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    date_default_timezone_set("Africa/Accra");
    $date_today = date('Y-m-d');
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Initials</th>
                        <th>Nurses Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM nurses_notes WHERE attend_id='$attend_id' ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        while($row=mysqli_fetch_assoc($query_run))
        {
            $value.='<tr>
            <td>'.$row['date'].'</td>
            <td>'.$row['time'].'</td>
            <td>'.$row['initials'].'</td>
            <td>'.$row['nurses_notes'].'</td>
            <td>';
                
                if($row['date'] == $date_today)
                {
                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Nurses_Notes'] == 'Yes' AND $_SESSION['user_id'] == $row['user_id'])) 
                    {
                        $value.='<a href="#" id="btn_edit_nnotes" data-id1="'.$row['nn_id'].'">Edit</a>';
                    };
                    if (
                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                        $_SESSION['user_type'] == 'Super_User' OR 
                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Nurses_Notes'] == 'Yes' AND $_SESSION['user_id'] == $row['user_id'])) 
                    {
                        $value.=' | <a href="#" id="btn_delete_nnotes" data-id="'.$row['nn_id'].'">Delete</a>';
                    };
                };
            $value.='</td>
        </tr>';
        }
    }
    else
    {
        $value.='No Record Found';
    };
    $value.='</tbody>
            </table>';
    echo $value;
}

function view_nurses_notes_history()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Initials</th>
                        <th>Nurses Notes</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM nurses_notes WHERE patient_id=$patient_id ORDER BY date DESC";
    $result = mysqli_query($con,$query);

    while($row=mysqli_fetch_assoc($result))
        {
            $value.='<tr>
                        <td>'.$row['date'].'</td>
                        <td>'.$row['time'].'</td>
                        <td>'.$row['initials'].'</td>
                        <td>'.$row['nurses_notes'].'</td>
                    </tr>';
        }
    $value.='</tbody>
            </table>';
    echo $value;
}

function delete_nurses_notes()
{
    global $con;
    $nn_id = $_POST['nn_id'];
    $attend_id = $_POST['attend_id'];
    $query = "DELETE FROM `nurses_notes` WHERE nn_id='$nn_id'";
    $query_run = mysqli_query($con, $query);
    If ($query_run)
    {
        echo "Nurses Note Deleted";
    }
    else
    {
        echo "Nurses Note NOT Deleted";
    };
}

?>
