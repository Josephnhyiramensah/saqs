<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//LABS
function save_lab()
{
    global $con;
    $labdesc = $_POST['labdesc'];
    $nhisitem = $_POST['nhisitem'];
    $price_cash = $_POST['price_cash'];
    $price_nhis = $_POST['price_nhis'];
    $price_nhis_topup = $_POST['price_nhis_topup'];
    $price_private = $_POST['price_private'];
    $price_private_topup = $_POST['price_private_topup'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "INSERT INTO `lab`(`lab`, `nhis_id`, `price_cash`, `price_private`, 
    `price_nhis`, `price_private_topup`, `price_nhis_topup`,`company_id`,`branch_id`,
    `created_by`,`created_datetime`) 
    VALUES ('$labdesc','$nhisitem','$price_cash','$price_private','$price_nhis',
    '$price_private_topup','$price_nhis_topup','$company_id','$branch_id',
    '$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    If ($query_run)
    {
        echo "lab Added Successfully";
    }
    else
    {
        echo "lab NOT Added";
    };
}

function edit_lab()
{
    global $con;
    $lab_id = $_POST['lab_id'];
    $query = "SELECT * FROM lab WHERE lab_id=$lab_id";
    $result=mysqli_query($con,$query);
    $row=mysqli_fetch_array($result);
    if ($row) {

        $Lab_Data=array();
        array_push(
                    $Lab_Data, 
                    $row['lab_id'],
                    $row['nhis_id'],
                    $row['lab'],
                    $row['price_cash'],
                    $row['price_private'],
                    $row['price_nhis'],
                    $row['price_private_topup'],
                    $row['price_nhis_topup'],
                    $row['gdrg']
                );
        echo json_encode($Lab_Data);
    }
    else
    {
        echo 'Not Set';
    };	
}

function update_lab()
{
    global $con;
    $lab_id = $_POST['lab_id'];
    $labdesc = $_POST['labdesc'];
    $nhisitem = $_POST['nhisitem'];
    $price_cash = $_POST['price_cash'];
    $price_nhis = $_POST['price_nhis'];
    $price_nhis_topup = $_POST['price_nhis_topup'];
    $price_private = $_POST['price_private'];
    $price_private_topup = $_POST['price_private_topup'];
    $gdrg = $_POST['gdrg'];
    
    $query = "UPDATE `lab` SET `lab`='$labdesc',`price_cash`='$price_cash',`price_private`='$price_private',`price_nhis`='$price_nhis',`price_private_topup`='$price_private_topup',`price_nhis_topup`='$price_nhis_topup',`gdrg`='$gdrg',`nhis_id`='$nhisitem' WHERE lab_id='$lab_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "lab Updated Successfully";
    }
    else
    {
        echo "lab NOT Updated";
    };
}

function delete_lab()
{
    global $con;
    $lab_id = $_POST['lab_id'];
    $query = "SELECT * FROM `lab_list` WHERE lab_id = '$lab_id'";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) < 1)
    {
        $query_del = "DELETE FROM `lab` WHERE lab_id = '$lab_id'";
        mysqli_query($con, $query_del);
        echo "deleted";
    }
    else
    {
        echo "used";
    };
}

function save_lab_param()
{
    global $con;
    $lab_id = $_POST['lab_id'];
    $lab_param = $_POST['lab_param'];
    $lab_param_low_range = $_POST['lab_param_low_range'];
    $lab_param_high_range = $_POST['lab_param_high_range'];
    $lab_param_unit = $_POST['lab_param_unit'];
    $lab_param_comment = $_POST['lab_param_comment'];
    
    $query = "INSERT INTO `lab_param`(`lab_id`, `lab_param`, `low_range`, `high_range`, `unit`, `comment`) VALUES ('$lab_id','$lab_param','$lab_param_low_range','$lab_param_high_range','$lab_param_unit','$lab_param_comment')";
    $query_run = mysqli_query($con, $query);
    get_lab_param_record();
}

function update_lab_param()
{
    global $con;
    $lab_param_id = $_POST['lab_param_id'];
    $lab_param = $_POST['lab_param'];
    $lab_param_low_range = $_POST['lab_param_low_range'];
    $lab_param_high_range = $_POST['lab_param_high_range'];
    $lab_param_unit = $_POST['lab_param_unit'];
    $lab_param_comment = $_POST['lab_param_comment'];

    $query = "UPDATE `lab_param` SET `lab_param`='$lab_param',`low_range`='$lab_param_low_range',`high_range`='$lab_param_high_range',`unit`='$lab_param_unit',`comment`='$lab_param_comment' WHERE lab_param_id='$lab_param_id'";

    $query_run = mysqli_query($con, $query);

    If ($query_run)
    {
        echo "lab Parameter Added Successfully";
    }
    else
    {
        echo "lab Parameter NOT Added";
    };
}

function lab_param_edit()
{
    global $con;
    $lab_param_id = $_POST['lab_param_id'];
    $query = "SELECT * FROM lab_param WHERE lab_param_id =$lab_param_id";
        $result=mysqli_query($con,$query);
        $row=mysqli_fetch_array($result);
        if ($row) {

            $lab_param_data=array();
            array_push(
                        $lab_param_data, 
                        $row['lab_param_id'],
                        $row['lab_id'],
                        $row['lab_param'],
                        $row['low_range'],
                        $row['high_range'],
                        $row['comment'],
                        $row['unit']
                    );
            echo json_encode($lab_param_data);
        }
        else
        {
            echo 'Not Set';
        };	
}

function get_lab_param_record()
{
    global $con;
    $lab_id = $_POST['lab_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Lower Range</th>
                        <th>Higher Range</th>
                        <th>Unit</th>
                        <th>Comment</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM lab_param where lab_id=$lab_id";
    $result = mysqli_query($con,$query);

    while($row=mysqli_fetch_assoc($result))
    {
        $value.='
                <tr>
                    <td><a href="#" id="btn_lab_param_edit" data-id="'.$row['lab_param_id'].'">'.$row['lab_param'].'</a></td>
                    <td>'.$row['low_range'].'</td>
                    <td>'.$row['high_range'].'</td>
                    <td>'.$row['unit'].'</td>
                    <td>'.$row['comment'].'</td>
                    <td>
                        <a href="#" id="btn_lab_param_delete" data-id1="'.$row['lab_param_id'].'" data-id2="'.$row['lab_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                    </td>
                </tr>';
    }
    $value.='</tbody>
            </table>';
    echo $value;
}

function delete_lab_param()
{
    global $con;
    $lab_id = $_POST['lab_id'];
    $lab_param_id = $_POST['lab_param_id'];

    $query = "DELETE FROM `lab_param` WHERE lab_param_id='$lab_param_id'";
    $query_run = mysqli_query($con,$query);
    get_lab_param_record();
}

function search_lab()
{
    global $con;
    $value = '';
    if(isset($_POST["search"]))
    {
     $search = mysqli_real_escape_string($con, $_POST["search"]);
     $query = "SELECT * FROM lab 
      WHERE lab LIKE '%".$search."%' ORDER BY lab ASC";
    }
    $query_run = mysqli_query($con, $query);
    $value .= '<table class="table table-hover table-bordered table-sm" id="labTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Test</th>
            <th>Code</th>
            <th>Cash</th>
            <th>NHIS</th>
            <th>NHIS (Top Up)</th>
            <th>Private</th>
            <th>Private (Top Up)</th>
            <th>Param</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody class="pv-table-body">';
        
            if (mysqli_num_rows($query_run) > 0)
            {
                while($row=mysqli_fetch_assoc($query_run))
                {
                    $nhis_id = $row['nhis_id'];
                    $query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
                    $query_nhis_run = mysqli_query($con, $query_nhis);
                    $row_nhis=mysqli_fetch_assoc($query_nhis_run);
        
                    $value .= '<tr>
                        <td>
                            <a href="#" id="btn_edit_lab" data-id1="'.$row['lab_id'].'">'.$row['lab'].'</a>
                        </td>
                        <td>';
                            if ($row_nhis==null){$value .= 'N/A';}else{$value .= $row_nhis['gdrg'];}
                        $value .= '</td>
                        <td>'.$row['price_cash'].'</td>
                        <td>';
                            if ($row_nhis==null){$value .= 'N/A';}else{$value .= $row_nhis['price'];}
                        $value .= '</td>
                        <td>'.$row['price_nhis_topup'].'</td>
                        <td>'.$row['price_private'].'</td>
                        <td>'.$row['price_private_topup'].'</td>
                        <td>
                            <a href="#" id="btn_lab_param" data-id="'.$row['lab_id'].'">
                            <i class="fas fa-clipboard-list"></i></a>
                        </td>
                        <td>
                            <a href="#" id="btn_delete_lab" data-id2="'.$row['lab_id'].'"
                            data-id1="'.$row['lab'].'">
                            <i class="fa fa-trash fa-sm"></i></a>
                        </td>
                    </tr>';
        
                }
            }
            else
            {
                $value .= 'Data Not Found';
            };
        
        $value .= '</tbody>
    </table>';

    echo $value;
}

function save_lab_param_dropdown()
{
    global $con;
    $lab_param_id = $_POST['lab_param_id'];
    $lab_param_dd = $_POST['lab_param_dd'];
    
    $query = "INSERT INTO `lab_param_dropdown`(`lab_param_id`, `lab_param_dropdown`) VALUES ('$lab_param_id','$lab_param_dd')";
    $query_run = mysqli_query($con, $query);

    If ($query_run)
    {
        echo "lab Parameter Dropdown Added Successfully";
    }
    else
    {
        echo "lab Parameter Dropdown NOT Added";
    };
}

function lab_param_dropdown_edit()
{
    global $con;
    $lab_param_dd_id = $_POST['lab_param_dd_id'];
    $query = "SELECT * FROM lab_param_dropdown WHERE id =$lab_param_dd_id";
        $result=mysqli_query($con,$query);
        $row=mysqli_fetch_array($result);
        if ($row) {

            $lab_param_dd_data=array();
            array_push(
                        $lab_param_dd_data, 
                        $row['id'],
                        $row['lab_param_dropdown']
                    );
            echo json_encode($lab_param_dd_data);
        }
        else
        {
            echo 'Not Set';
        };	
}

function update_lab_param_dropdown()
{
    global $con;
    $lab_param_dd_id = $_POST['lab_param_dd_id'];
    $lab_param_dd = $_POST['lab_param_dd'];

    $query = "UPDATE `lab_param_dropdown` SET `lab_param_dropdown`='$lab_param_dd' WHERE id='$lab_param_dd_id'";

    $query_run = mysqli_query($con, $query);

    If ($query_run)
    {
        echo "lab Parameter Dropdown Updated Successfully";
    }
    else
    {
        echo "lab Parameter Dropdown NOT Updated";
    };
}

function get_lab_param_dropdown_record()
{
    global $con;
    $lab_param_id = $_POST['lab_param_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Dropdown Item</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM lab_param_dropdown where lab_param_id=$lab_param_id";
    $result = mysqli_query($con,$query);

    while($row=mysqli_fetch_assoc($result))
    {
        $value.='
                <tr>
                    <td><a href="#" id="btn_lab_param_dropdown_edit" data-id="'.$row['id'].'">'.$row['lab_param_dropdown'].'</a></td>
                    <td>
                        <a href="#" id="btn_lab_param_delete" data-id1="'.$row['id'].'"><i class="fa fa-trash fa-sm"></i></a>
                    </td>
                </tr>';
    }
    $value.='</tbody>
            </table>';
    echo $value;
}

function save_composite_lab()
{
    global $con;
    $composite_lab_id = $_POST['composite_lab_id'];
    $composite_lab = $_POST['composite_lab'];
    $composite_lab_price = $_POST['composite_lab_price'];
    $company_id = $_POST['company_id'];
    $branch_id = $_POST['branch_id'];
    $user_id = $_POST['user_id'];
    
    $query = "INSERT INTO `composite_labs`(`company_id`, `branch_id`, `user_id`, `composite_lab`, 
    `price`, `created_by`, `created_datetime`) VALUES ('$company_id','$branch_id',
    '$user_id','$composite_lab','$composite_lab_price','$user_id',NOW())";
    mysqli_query($con, $query);
}

function edit_composite_lab()
{
    global $con;
    $Lab_Data = array();
    $composite_lab_id = $_POST['composite_lab_id'];
    $query = "SELECT * FROM composite_labs WHERE composite_lab_id = $composite_lab_id";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);
    if ($row) 
    {
        array_push(
            $Lab_Data, 
            $row['composite_lab_id'],
            $row['composite_lab'],
            $row['price']
        );
    };
    echo json_encode($Lab_Data);
}

function update_composite_lab()
{
    global $con;
    $composite_lab_id = $_POST['composite_lab_id'];
    $composite_lab = $_POST['composite_lab'];
    $composite_lab_price = $_POST['composite_lab_price'];
    $company_id = $_POST['company_id'];
    $branch_id = $_POST['branch_id'];
    $user_id = $_POST['user_id'];
    
    $query = "UPDATE `composite_labs` SET `composite_lab`='$composite_lab', 
    `price`='$composite_lab_price', `altered_by`='$user_id', `altered_datetime`= NOW()
    WHERE `composite_lab_id`='$composite_lab_id'";
    mysqli_query($con, $query);
}

function delete_composite_lab()
{
    global $con;
    $composite_lab_id = $_POST['composite_lab_id'];
    $query = "DELETE FROM `composite_labs` WHERE `composite_lab_id`= '$composite_lab_id'";
    mysqli_query($con, $query);

    $query = "DELETE FROM `composite_lab_list` WHERE `composite_lab_id`= '$composite_lab_id'";
    mysqli_query($con, $query);
}

function save_composite_lab_list()
{
    global $con;
    $composite_lab_id = $_POST['composite_lab_id'];
    $composite_lab_list_id = $_POST['composite_lab_list_id'];
    $composite_lab_list_lab_id = $_POST['composite_lab_list_lab_id'];
    $company_id = $_POST['company_id'];
    $branch_id = $_POST['branch_id'];
    $user_id = $_POST['user_id'];
    
    $query = "INSERT INTO `composite_lab_list`(`company_id`, `branch_id`, `user_id`, `composite_lab_id`, 
    `lab_id`, `created_by`, `created_datetime`) VALUES ('$company_id','$branch_id',
    '$user_id','$composite_lab_id','$composite_lab_list_lab_id','$user_id',NOW())";
    mysqli_query($con, $query);
}

function edit_composite_lab_list()
{
    global $con;
    $Lab_Data = array();
    $composite_lab_list_id = $_POST['composite_lab_list_id'];
    $query = "SELECT * FROM composite_lab_list WHERE composite_lab_list_id = $composite_lab_list_id";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);
    if ($row) 
    {
        array_push(
            $Lab_Data, 
            $row['composite_lab_list_id'],
            $row['composite_lab_id'],
            $row['lab_id']
        );
    };
    echo json_encode($Lab_Data);
}

function update_composite_lab_list()
{
    global $con;
    $composite_lab_id = $_POST['composite_lab_id'];
    $composite_lab_list_id = $_POST['composite_lab_list_id'];
    $composite_lab_list_lab_id = $_POST['composite_lab_list_lab_id'];
    $company_id = $_POST['company_id'];
    $branch_id = $_POST['branch_id'];
    $user_id = $_POST['user_id'];
    
    $query = "UPDATE `composite_lab_list` SET `composite_lab_id`='$composite_lab_id', 
    `lab_id`='$composite_lab_list_lab_id', `altered_by`='$user_id', `altered_datetime`=NOW() 
    WHERE `composite_lab_list_id`='$composite_lab_list_id'";
    mysqli_query($con, $query);
}

function delete_composite_lab_list()
{
    global $con;
    $composite_lab_list_id = $_POST['composite_lab_list_id'];
    $query = "DELETE FROM `composite_lab_list` WHERE `composite_lab_list_id`= '$composite_lab_list_id'";
    mysqli_query($con, $query);
}

?>
