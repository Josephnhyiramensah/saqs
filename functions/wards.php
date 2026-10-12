<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//WARDS AND BEDS
function save_ward()
{
    global $con;
    $ward = $_POST['ward'];
    $price = $_POST['price'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $branch_id = $_SESSION['branch_id'];
    
    $query = "INSERT INTO `ward`(`ward`, `price`, `company_id`, `branch_id`, `created_by`, 
    `created_datetime`) VALUES ('$ward','$price','$company_id','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        list_ward();
    }
    else
    {
        echo "Ward NOT Added";
    };
}

/*function list_ward()
{
    global $con;
    $value='';
    $query = "SELECT * FROM ward ORDER BY ward ASC";
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="surgeryTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Ward</th>
                        <th>Price</th>
                        <th>No of Beds</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';

                        if (mysqli_num_rows($query_run) > 0)
                        {
                            while($row=mysqli_fetch_assoc($query_run))
                            {
                                $ward_id = $row['ward_id'];
                                $query_ward = "SELECT * FROM bed WHERE ward_id='$ward_id'";
                                $query_ward_run = mysqli_query($con, $query_ward);
                                $rows = mysqli_num_rows($query_ward_run);
                                $value.='<tr>
                                    <td>
                                        <a href="#" id="btn_edit_ward" data-id="'.$row['ward_id'].'">'.$row['ward'].'</a>
                                    </td>
                                    <td>'.$row['price'].'</td>
                                    <td>'.$rows.'</td>
                                    <td>
                                        <a href="#" id="btn_delete_ward" data-id2="'.$row['ward_id'].'"><i class="fa fa-trash fa-sm"></i></a>
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

function edit_ward()
{
    global $con;
    $ward_id = $_POST['ward_id'];
    $query = "SELECT * from ward where ward_id='$ward_id'";
    $result = mysqli_query($con,$query);
    $ward_item=array();
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($ward_item, 
            $row['ward_id'],
            $row['ward'],
            $row['price']
        );
    }
     echo json_encode($ward_item);
}

function update_ward()
{
    global $con;
    $ward_id = $_POST['ward_id'];
    $ward = $_POST['ward'];
    $price = $_POST['price'];
    
    $query = "UPDATE `ward` SET `ward`='$ward',`price`='$price' WHERE `ward_id`='$ward_id'";
    $query_run = mysqli_query($con, $query);

    If ($query_run)
    {
        list_ward();
    }
    else
    {
        echo "Ward NOT Updated";
    };
}

function get_bed_list()
{
    global $con;
    $ward_id = $_POST['ward_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Bed</th>
                        <th>Type</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM bed where ward_id=$ward_id";
    $result = mysqli_query($con,$query);

    while($row=mysqli_fetch_assoc($result))
    {
        $value.='
                <tr>
                    <td><a href="#" id="btn_bed_edit" data-id="'.$row['bed_id'].'">'.$row['bed'].'</a></td>
                    <td>'.$row['type_of_bed'].'</td>
                    <td>
                        <a href="#" id="btn_bed_delete" data-id1="'.$row['bed_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                    </td>
                </tr>';
    }
    $value.='</tbody>
            </table>';
    echo $value;
}

function edit_bed()
{
    global $con;
    $bed_id = $_POST['bed_id'];
    $query = "SELECT * from bed where bed_id='$bed_id'";
    $result = mysqli_query($con,$query);
    $bed_item=array();
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($bed_item, 
            $row['bed_id'],
            $row['ward_id'],
            $row['bed'],
            $row['type_of_bed']
        );
    }
     echo json_encode($bed_item);
}

function save_bed()
{
    global $con;
    $ward_id = $_POST['ward_id'];
    $bed = $_POST['bed'];
    $type = $_POST['type'];
    $query = "INSERT INTO `bed`(`bed`, `type_of_bed`,`ward_id`) VALUES ('$bed','$type','$ward_id')";
    $query_run = mysqli_query($con, $query);

    If ($query_run)
    {
        get_bed_list();
    }
    else
    {
        echo "bed NOT Added";
    };
}

function update_bed()
{
    global $con;
    $bed_id = $_POST['bed_id'];
    $bed = $_POST['bed'];
    $type = $_POST['type'];
    $query = "UPDATE `bed` SET `bed`='$bed',`type_of_bed`='$type' WHERE `bed_id`='$bed_id'";
    $query_run = mysqli_query($con, $query);

    If ($query_run)
    {
        get_bed_list();
    }
    else
    {
        echo "bed NOT Updated";
    };
}

function delete_ward()
{
    global $con;
    $ward_id = $_POST['ward_id'];
    
    $query = "SELECT * FROM `wardlist` WHERE `ward_id`='$ward_id'";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) < 1)
    {
        $query = "DELETE FROM `ward` WHERE `ward_id`='$ward_id'";
        mysqli_query($con, $query);

        $query = "DELETE FROM `bed` WHERE `ward_id`='$ward_id'";
        mysqli_query($con, $query);

        echo 'deleted';
    }
    else
    {
        echo 'used';
    };
}

?>
