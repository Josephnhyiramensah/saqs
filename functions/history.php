<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//HISTORY
function save_history()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $history = $_POST['history'];
    $history = addslashes($history);
    //$history = mysql_real_escape_string($history);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "INSERT INTO `history`(`company_id`,`attend_id`, `patient_id`, `history`, `date`, 
    `user_id`, `created_by`, `created_time`, `time`, `branch_id`) 
    VALUES ('$company_id','$attend_id','$patient_id','$history','$date','$user_id','$user_id', 
    NOW(),'$time','$branch_id')";

    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        if ($_SESSION['user_type_id'] == 6) {
            doctor_attend_register();
        };
        echo "History Added Successfully";
    }
    else
    {
        echo "History NOT Added";
    };
}

function edit_history()
{
    global $con;
    $history_id = $_POST['history_id'];
    $History_Data = array();
    $query = "SELECT * FROM history WHERE history_id=$history_id";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($History_Data, 
            $row['date'],
            $row['history_id'],
            $row['attend_id'],
            $row['patient_id'],
            $row['history'],
            $row['date'],
            $row['time']
        );
    }
     echo json_encode($History_Data);
}

function update_history()
{
    global $con;
    $history_id = $_POST['history_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $history = $_POST['history'];
    $history = addslashes($history);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $user_id = $_SESSION['user_id'];
    
    $query = "UPDATE `history` SET `attend_id`='$attend_id',`patient_id`='$patient_id', `time`='$time',
    `history`='$history',`date`='$date',`altered_by`='$user_id',`altered_time`= NOW() WHERE `history_id`='$history_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "History Updated Successfully";
    }
    else
    {
        echo "History NOT Updated";
    };
}

function delete_history()
{
    global $con;
    $history_id = $_POST['history_id'];
    $query = "DELETE FROM `history` WHERE history_id='$history_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        echo "History Deleted Successfully";
    }
    else
    {
        echo "History NOT Deleted";
    };
}

function view_current_history()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    date_default_timezone_set("Africa/Accra");
    $date_today = date('Y-m-d');
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%">Date</th>
                            <th width="10%">Time</th>
                            <th width="50%">History</th>
                            <th width="15%">Doctor</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">';
    $query = "SELECT * FROM history WHERE patient_id = '$patient_id' ORDER BY date DESC, time DESC";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
        {
            while($row=mysqli_fetch_assoc($query_run))
            {
                $doctor = $row['user_id'];
                $query_doctor = "SELECT * FROM users WHERE id = '$doctor'";
                $query_run_doctor = mysqli_query($con, $query_doctor);
                if(isset($query_run_doctor))
                {
                    $row_doctor = mysqli_fetch_assoc($query_run_doctor);
                    if($row_doctor != '')
                    {
                        $doctor = $row_doctor['first_name'];
                    }
                    else
                    {
                        $doctor = 'No Doctor Specified';
                    };
                }
                else
                {
                    $doctor = 'No Doctor Specified';
                };

                $value.='
                        <tr>
                            <td>'.$row['date'].'</td>
                            <td>'.$row['time'].'</td>
                              <td>'.$row['history'].'</td>
                              <td>'.$doctor.'</td>
                              <td>';
                          if (/*$_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND*/ $_SESSION['user_id'] == $row['user_id']) 
                        {
                            if($row['date'] == $date_today)
                            {
                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_History'] == 'Yes')) 
                                {
                                    $value.= '<a href="#" id="btn_edit_history" data-id="'.$row['history_id'].'">Edit</a>';
                                };
                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_History'] == 'Yes')) 
                                {
                                    $value.= ' | <a href="#" id="btn_delete_history" data-id1="'.$row['history_id'].'"> Delete</a>';
                                };
                            };
                        };
                            
                    $value.='</td>
                        </tr>';
            };
        }
        else
        {
                echo 'No Record Found';
        };
            $value.='</tbody>
                    </table>';
    echo $value;
}

/*function view_past_history()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>History</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM history WHERE patient_id = $patient_id ORDER BY date DESC";
    $result = mysqli_query($con,$query);

    while($row=mysqli_fetch_assoc($result))
    {
        $value.='
                <tr>
                    <td><a href="#">'.$row['date'].'</a></td>
                    <td>'.$row['history'].'</td>
                    <td>
                        <a href="#" id="btn_delete_history" data-id1="'.$row['history_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                    </td>
                </tr>';
    }
    $value.='</tbody>
            </table>';
    echo $value;
}*/

?>
