<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//DIAGNOSIS
function check_diagnosis_attend_duplicate()
{
    global $con;
    $diagnosis = $_POST['diagnosis'];
    $attend_id = $_POST['attend_id'];
    $diag_dup=array();
    $query = "SELECT * FROM diagnosis_list WHERE diagnosis_id='$diagnosis' AND attend_id='$attend_id'";
    $result = mysqli_query($con,$query);
        if (mysqli_num_rows($result) > 0)
        {
            $query_diag = "SELECT * FROM diagnosis WHERE diagnosis_id='$diagnosis'";
            $result_diag = mysqli_query($con,$query_diag);
            $row_diag=mysqli_fetch_assoc($result_diag);

            array_push($diag_dup, 'duplicate',$row_diag['diagnosis']);
        }
        else
        {
             array_push($diag_dup, 'none');

        }
    echo json_encode($diag_dup);
}

function save_diagnosis_attend()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $diagnosis_id = $_POST['diagnosis'];
    $date = $_POST['diag_date'];
    $diag_gdrg = $_POST['diag_gdrg'];
    $diag_comment = $_POST['diag_comment'];
    $amount = $_POST['diag_amt'];
    $diag_sponsor = $_POST['diag_sponsor'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    //ENTER NHIS ID
        $clinic = $_POST['clinic'];
        $age = $_POST['age'];
        $tos = $_POST['tos'];
        if($diag_sponsor == 2)
        {
            if($tos == 1)
            {
                if($clinic != 7 && $clinic != 8 && $clinic != 17){$nhis_id = 820;}
                elseif($clinic == 7){$nhis_id = 819;}
                elseif($clinic == 8){$nhis_id = 817;}
                elseif($clinic == 17){$nhis_id = 816;};
            }
            elseif($tos == 2)
            {
                $query = "SELECT * FROM diagnosis WHERE diagnosis_id='$diagnosis_id'";
                $query_run_diagnosis = mysqli_query($con, $query);
                $row_diagnosis = mysqli_fetch_assoc($query_run_diagnosis);
                $nhis_id = $row_diagnosis['nhis_id'];
            };
        };

    //ENTER IS-PRINCIPAL
        $query_surgery_list = "SELECT * FROM surgery_list WHERE attend_id ='$attend_id' AND ledger_id = 2";
        $query_run_surgery_list = mysqli_query($con, $query_surgery_list);
        if(mysqli_num_rows($query_run_surgery_list) < 1)
        {
            $query_diagnosis_list = "SELECT * FROM diagnosis_list WHERE attend_id ='$attend_id'";
            $query_run_diagnosis_list = mysqli_query($con, $query_diagnosis_list);
            if(mysqli_num_rows($query_run_diagnosis_list) < 1)
            {
                $is_principal = 'Yes';
            }
            else
            {
                $is_principal = 'No';
            };
        }
        else
        {
            $is_principal = 'No';
        };

    $query = "INSERT INTO `diagnosis_list`(`company_id`,`attend_id`, `patient_id`, `diagnosis_id`, 
    `date`, `g_drg`, `amount_nhis`, `comment`, `ledger_id`, `nhis_id`, `is_principal`, `user_id`, 
    `user_create`, `user_create_timestamp`,`branch_id`) VALUES ('$company_id','$attend_id',
    '$patient_id','$diagnosis_id','$date','$diag_gdrg','$amount','$diag_comment','$diag_sponsor',
    '$nhis_id', '$is_principal', '$user_id', '$user_id', NOW(), '$branch_id')";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        $query_diag_list = "SELECT diagnosis_list_id FROM `diagnosis_list` ORDER BY diagnosis_list_id DESC";
        $query_run_diag_list = mysqli_query($con, $query_diag_list);
        $row_diag_list = mysqli_fetch_assoc($query_run_diag_list);
        $diag_list_id  = $row_diag_list['diagnosis_list_id'];
        $_SESSION['diagnosis_id'] = $diagnosis_id;
        $_SESSION['diag_list_id'] = $diag_list_id;
        $_SESSION['lab_id'] = 0;
        $_SESSION['lab_list_id'] = 0;
        $_SESSION['item_category_id'] = 6;
        $_SESSION['date_SIOD'] = $date;

        if ($_SESSION['user_type_id'] == 6) 
        {
            doctor_attend_register();
        };
            incidence_of_disease_entry();
            echo "Diagnosis Added Successfully";
    }
    else
    {
        echo "Diagnosis NOT Added";
    };
}

function edit_diagnosis_attend()
{
    global $con;
    $diagnosis_list_id = $_POST['diagnosis_list_id'];
    $Diagnosis_Data=array();
    $query = "SELECT * FROM diagnosis_list WHERE diagnosis_list_id=$diagnosis_list_id";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Diagnosis_Data, 
            $row['date'],
            $row['diagnosis_id'],
            $row['attend_id'],
            $row['patient_id'],
            $row['diagnosis_list_id'],
            $row['comment'],
            $row['g_drg'],
            $row['amount_nhis'],
            $row['ledger_id']
        );
    }
     echo json_encode($Diagnosis_Data);
}

function update_diagnosis_attend()
{
    global $con;
    $diagnosis_list_id = $_POST['diagnosis_list_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $diagnosis_id = $_POST['diagnosis'];
    $diag_date = $_POST['diag_date'];
    $diag_gdrg = $_POST['diag_gdrg'];
    $diag_comment = $_POST['diag_comment'];
    $amount = $_POST['diag_amt'];
    $diag_sponsor = $_POST['diag_sponsor'];
    $user_id = $_SESSION['user_id'];
    
    $clinic = $_POST['clinic'];
    $age = $_POST['age'];
    $tos = $_POST['tos'];
    if($diag_sponsor == 2)
    {
        if($tos == 1)
        {
            if($clinic != 7 || $clinic != 8 || $clinic != 17){$nhis_id = 820;}
            elseif($clinic == 7){$nhis_id = 819;}
            elseif($clinic == 8){$nhis_id = 817;}
            elseif($clinic == 17){$nhis_id = 816;}
        }
        elseif($tos == 2)
        {
            $query = "SELECT * FROM diagnosis WHERE diagnosis_id ='$diagnosis_id'";
            $query_run_diagnosis = mysqli_query($con, $query);
            $row_diagnosis = mysqli_fetch_assoc($query_run_diagnosis);
            $nhis_id = $row_diagnosis['nhis_id'];
        };
    };
    
    $query = "UPDATE `diagnosis_list` SET `attend_id`='$attend_id',`patient_id`='$patient_id',
    `diagnosis_id`='$diagnosis_id',`comment`='$diag_comment',`ledger_id`='$diag_sponsor',
    `date`='$diag_date',`g_drg`='$diag_gdrg',`nhis_id`='$nhis_id',`user_alter`='$user_id',`user_alter_timestamp`=NOW() WHERE `diagnosis_list_id`='$diagnosis_list_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        $_SESSION['diagnosis_id'] = $diagnosis_id;
        $_SESSION['diag_list_id'] = $diagnosis_list_id;
        $_SESSION['lab_id'] = 0;
        $_SESSION['lab_list_id'] = 0;
        $_SESSION['item_category_id'] = 6;
        $_SESSION['date_SIOD'] = $date;
        incidence_of_disease_update_diagnosis();
        echo "Diagnosis Updated Successfully";
    }
    else
    {
        echo "Diagnosis NOT Updated";
    };
}

function view_current_diagnosis()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $age = $_POST['age'];

    date_default_timezone_set("Africa/Accra");
    $date_today = date('Y-m-d');
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="action-td">Date</th>
                        <th class="action-td">Diagnosis</th>
                        <th class="action-td">ICD 10</th>
                        <th class="action-td">G-DRG</th>
                        <th class="action-td">Principal?</th>
                        <th class="action-td">Comment</th>
                        <th class="action-td">Action</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM diagnosis_list WHERE attend_id='$attend_id' ORDER BY date DESC";
    $query_run = mysqli_query($con,$query);
    if (mysqli_num_rows($query_run) > 0)
        {
            while($row=mysqli_fetch_assoc($query_run))
            {
                $diagnosis_id = $row['diagnosis_id'];
                $query = "SELECT * FROM diagnosis WHERE diagnosis_id='$diagnosis_id'";
                $query_run_diag = mysqli_query($con, $query);
                $row_diag=mysqli_fetch_assoc($query_run_diag);

                $nhis_id = $row['nhis_id'];
                $query_gdrg = "SELECT * FROM nhis WHERE nhis_id ='$nhis_id'";
                $result_gdrg = mysqli_query($con,$query_gdrg);
                $row_gdrg = mysqli_fetch_array($result_gdrg);
                if($age < 12)
                {
                    if(isset($row_gdrg['gdrg_child']))
                    {$diag_gdrg = $row_gdrg['gdrg_child'];}else
                    {$diag_gdrg = 'N/A';};
                }
                else
                {
                    if(isset($row_gdrg['gdrg_adult']))
                    {$diag_gdrg = $row_gdrg['gdrg_adult'];}else
                    {$diag_gdrg = 'N/A';};
                };
                $value.='
                        <tr>
                            <td class="action-td">'.$row['date'].'</td>
                            <td>'.$row_diag['diagnosis'].'</td>
                            <td class="action-td">'.$row_diag['icd_10'].'</td>
                            <td class="action-td">'.$diag_gdrg.'</td>
                            <td class="action-td">'.$row['is_principal'].'</td>
                            <td>'.$row['comment'].'</td>
                            <td>';
                            if ($_SESSION['user_id'] == $row['user_id']) 
                            {
                                if($row['date'] == $date_today)
                                {
                                    if (
                                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Diagnosis_List'] == 'Yes')) 
                                        {
                                        $value.='<a href="#" id="btn_edit_diag" data-id1="'.$row['diagnosis_list_id'].'">Edit</a>';
                                        };
                                    if (
                                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                        $_SESSION['user_type'] == 'Super_User' OR 
                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Diagnosis_List'] == 'Yes')) 
                                    {
                                    $value.=' | <a href="#" id="btn_delete_diag" data-id2="'.$row['diagnosis_list_id'].'">Delete</a>';
                                    };
                                };
                            };
                    $value.='</td>
                        </tr>';
            }
        };
    $value.='</tbody>
            </table>';
    echo $value;
}

function view_diagnosis_history()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Diagnosis</th>
                        <th>ICD 10</th>
                        <th>G-DRG</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM diagnosis_list WHERE patient_id=$patient_id ORDER BY date DESC";
    $query_run = mysqli_query($con,$query);
    if (mysqli_num_rows($query_run) > 0)
        {
            while($row=mysqli_fetch_assoc($query_run))
            {
                $diagnosis_id = $row['diagnosis_id'];
                $query = "SELECT * FROM diagnosis WHERE diagnosis_id=$diagnosis_id";
                $query_run_diag = mysqli_query($con, $query);
                $row_diag=mysqli_fetch_assoc($query_run_diag);
                $value.='
                        <tr>
                            <td>'.$row['date'].'</a></td>
                            <td>'.$row_diag['diagnosis'].'</td>
                            <td>'.$row_diag['icd_10'].'</td>
                            <td>'.$row_diag['g_drg'].'</td>
                            <td>'.$row['comment'].'</td>
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

function delete_diagnosis_attend()
{
    global $con;
    $diagnosis_list_id = $_POST['diagnosis_list_id'];
    $attend_id = $_POST['attend_id'];
    $query = "DELETE FROM `diagnosis_list` WHERE diagnosis_list_id='$diagnosis_list_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        $query = "DELETE FROM `stat_incidence_of_diseases` WHERE diag_list_id='$diagnosis_list_id'";
        $query_run = mysqli_query($con, $query);
        if ($query_run)
        {
            echo "Diagnosis Deleted";
        };
    }
    else
    {
        echo "Diagnosis NOT Deleted";
    };
}

function search_diagnosis_attend()
{
    global $con;
    $search = $_POST['search'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Diagnosis</th>
                        <th class="action-td">ICD 10</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    if(isset($_POST["search"]))
    {
        $query = "SELECT *  FROM `diagnosis` WHERE `diagnosis` LIKE '%".$search."%'";
        $query_run = mysqli_query($con,$query);
        if (mysqli_num_rows($query_run) > 0)
        {
            while($row = mysqli_fetch_assoc($query_run))
            {
                $value.='
                        <tr>
                            <td><a href="#" id="btn_save_diagnosis_search_item" data-id="'.$row['diagnosis_id'].'">'.$row['diagnosis'].'</a></td>
                            <td class="action-td"><a href="#" id="btn_save_diagnosis_search_item" data-id="'.$row['diagnosis_id'].'">'.$row['icd_10'].'</a></td>
                        </tr>';
            };
        };
    
    };
    $value.='</tbody>
            </table>';
    echo $value;
}

?>
