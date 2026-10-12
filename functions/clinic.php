<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//CLINICS
function save_clinic()
{
    global $con;
    $clinic = $_POST['clinic'];
    $service_charge = $_POST['service_charge'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $branch_id = $_SESSION['branch_id'];
    
    $query = "INSERT INTO `clinics`(`clinic_desc`,`item_id`,`company_id`,`branch_id`,`created_by`,
    `created_datetime`) VALUES ('$clinic','$service_charge','$company_id','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        list_clinic();
    }
    else
    {
        echo "clinic NOT Added";
    };
}

/*function list_clinic()
{
    global $con;
    $value='';
    $query = "SELECT * FROM clinics ORDER BY clinic_desc ASC";
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="clinicTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Clinic</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';

                        if (mysqli_num_rows($query_run) > 0)
                        {
                            while($row=mysqli_fetch_assoc($query_run))
                            {
                                $value.='<tr>
                                    <td>
                                        <a href="#" id="btn_edit_clinic" data-id="'.$row['clinic_id'].'">'.$row['clinic_desc'].'</a>
                                    </td>
                                    <td>
                                        <a href="#" id="btn_delete_clinic" data-id2="'.$row['clinic_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                    </td>
                                </tr>';
                            }
                        }
                        else
                        {
                                echo 'Data Not Found';
                        };
                    
                $value.='</tbody>
            </table>';
            echo $value;
}*/

function edit_clinic()
{
    global $con;
    $clinic_id = $_POST['clinic_id'];
    $query = "SELECT * from clinics where clinic_id='$clinic_id'";
    $result = mysqli_query($con,$query);
    $clinic_item=array();
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($clinic_item, 
            $row['clinic_id'],
            $row['clinic_desc'],
            $row['item_id']
        );
    }
     echo json_encode($clinic_item);
}

function update_clinic()
{
    global $con;
    $clinic_id = $_POST['clinic_id'];
    $clinic = $_POST['clinic'];
    $service_charge = $_POST['service_charge'];
    
    $query = "UPDATE `clinics` SET `clinic_desc`='$clinic',`item_id`='$service_charge' WHERE `clinic_id`='$clinic_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        list_clinic();
    }
    else
    {
        echo "clinic NOT Updated";
    };
}

function delete_clinic()
{
    global $con;
    $clinic_id = $_POST['clinic_id'];
    
    $query = "SELECT * FROM `attendance` WHERE `clinic_id`='$clinic_id'";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) < 1)
    {
        $query = "DELETE FROM `clinics` WHERE `clinic_id`='$clinic_id'";
            mysqli_query($con, $query);
            echo 'deleted';
    }
    else
    {
        echo 'used';
    };
}

?>
