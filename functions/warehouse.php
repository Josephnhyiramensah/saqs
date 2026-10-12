<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//WAREHOUSE
function save_new_warehouse()
{
    global $con;
    $warehouse_name = $_POST['warehouse_name'];
    $warehouse_location = $_POST['warehouse_location'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query_last_sno = "SELECT `sno` FROM `warehouse` WHERE `company_id` = '$company_id' ORDER BY `sno` DESC";
    $result_last_sno = mysqli_query($con,$query_last_sno);
    $row_last_sno = mysqli_fetch_assoc($result_last_sno);
    if(isset($row_last_sno)){$last_sno = $row_last_sno['sno'];}else{$last_sno = 0;};
    $next_sno = $last_sno + 1;
    
    $query = "INSERT INTO `warehouse`(`sno`,`company_id`,`warehouse_desc`, `location`,
    `branch_id`,`created_by`,`created_datetime`) VALUES ('$next_sno','$company_id','$warehouse_name',
    '$warehouse_location','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        list_warehouses();
    }
    else
    {
        echo "Warehouse NOT Added";
    };
}

/*function list_warehouses()
{
    global $con;
    $company_id = $_SESSION['company_id'];
    $value='';
    $query = "SELECT * FROM warehouse WHERE company_id = '$company_id' ORDER BY warehouse_desc ASC";
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="warehouseTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';

                        if (mysqli_num_rows($query_run) > 0)
                        {
                            while($row=mysqli_fetch_assoc($query_run))
                            {
                                $value.='<tr>
                                    <td>
                                        <a href="#" id="btn_edit_warehouse" data-id="'.$row['warehouse_id'].'">'.$row['warehouse_desc'].'</a>
                                    </td>
                                    <td>'.$row['location'].'</td>';
                                    $value.='<td>
                                        <a href="#" id="btn_delete_warehouse" data-id2="'.$row['warehouse_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                    </td>
                                </tr>';
                            }
                        };
                    
                $value.='</tbody>
            </table>';
            echo $value;
}*/

function edit_warehouse()
{
    global $con;
    $warehouse_id = $_POST['warehouse_id'];
    $query = "SELECT * from warehouse where warehouse_id='$warehouse_id'";
    $result = mysqli_query($con,$query);
    $data=array();
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($data, 
            $row['warehouse_id'],
            $row['warehouse_desc'],
            $row['location']
        );
    }
     echo json_encode($data);
}

function update_warehouse()
{
    global $con;
    $warehouse_id = $_POST['warehouse_id'];
    $warehouse_name = $_POST['warehouse_name'];
    $warehouse_location = $_POST['warehouse_location'];
    
    $query = "UPDATE `warehouse` SET 
    `warehouse_desc`='$warehouse_name', `location`='$warehouse_location' WHERE `warehouse_id`='$warehouse_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        list_warehouses();
    }
    else
    {
        echo "Warehouse NOT Updated";
    };
}

function delete_warehouse()
{
    global $con;
    $warehouse_id = $_POST['warehouse_id'];
    
    $query = "SELECT * FROM `drug_dispense_list` WHERE `warehouse_id`='$warehouse_id'";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) < 1)
    {
        $query = "SELECT * FROM `stock_transfer_items` WHERE `warehouse_id`='$warehouse_id'";
        $query_run = mysqli_query($con, $query);
        if(mysqli_num_rows($query_run) < 1)
        {
            $query = "SELECT * FROM `stock_adjustment_items` WHERE `warehouse_id`='$warehouse_id'";
            $query_run = mysqli_query($con, $query);
            if(mysqli_num_rows($query_run) < 1)
            {
                $query = "SELECT * FROM `purchase_items` WHERE `warehouse_id`='$warehouse_id'";
                $query_run = mysqli_query($con, $query);
                if(mysqli_num_rows($query_run) < 1)
                {
                    $query = "SELECT * FROM `stock_sales_items` WHERE `warehouse_id`='$warehouse_id'";
                    $query_run = mysqli_query($con, $query);
                    if(mysqli_num_rows($query_run) < 1)
                    {
                        $query = "DELETE FROM `warehouse` WHERE `warehouse_id`='$warehouse_id'";
                        mysqli_query($con, $query);
        
                        echo 'deleted';
                    }
                    else
                    {
                        echo 'used';
                    };
                }
                else
                {
                    echo 'used';
                };
            }
            else
            {
                echo 'used';
            };
        }
        else
        {
            echo 'used';
        };
    }
    else
    {
        echo 'used';
    };
}


?>
