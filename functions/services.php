<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//SERVICES
function save_service()
{
    global $con;
    $service = $_POST['service'];
    $nhisitem = $_POST['nhisitem'];
    $price_cash = $_POST['price_cash'];
    $price_private = $_POST['price_private'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $branch_id = $_SESSION['branch_id'];
    
    $query = "INSERT INTO `services`(`nhis_id`, `service`, `price_cash`, `price_private`,
    `company_id`, `branch_id`, `created_by`, `created_datetime`) 
    VALUES ('$nhisitem','$service','$price_cash','$price_private',
    '$company_id','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "Service Saved";
    }
    else
    {
        echo "Service NOT Added";
    };
}

/*function list_service()
{
    global $con;
    $value='';
    $query = "SELECT * FROM services ORDER BY service ASC";
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="diagnosisTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>G-DRG</th>
                        <th>G-DRG Adult</th>
                        <th>G-DRG Child</th>
                        <th>Price - Cash</th>
                        <th>Price - Private</th>
                        <th>Price - Adult</th>
                        <th>Price - Child</th>
                        <th>Action</th>
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
                                $NA='N/A';
                                $value.='<tr>
                                    <td>
                                        <a href="#" id="btn_edit_service" data-id="'.$row['service_id'].'">'.$row['service'].'</a>
                                    </td>';
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['gdrg'].'</td>';};
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['gdrg_adult'].'</td>';};
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['gdrg_child'].'</td>';};
                                    $value.='<td>'.$row['price_cash'].'</td>';
                                    $value.='<td>'.$row['price_private'].'</td>';
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['price_adult'].'</td>';};
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['price_child'].'</td>';};
                                    $value.='<td>
                                        <a href="#" id="btn_delete_service" data-id2="'.$row['service_id'].'"><i class="fa fa-trash fa-sm"></i></a>
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

function edit_service()
{
    global $con;
    $service_id = $_POST['service_id'];
    $query = "SELECT * from services where service_id='$service_id'";
    $result = mysqli_query($con,$query);
    $service_item=array();
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($service_item, 
            $row['service_id'],
            $row['nhis_id'],
            $row['service'],
            $row['price_cash'],
            $row['price_private']
        );
    }
     echo json_encode($service_item);
}

function update_service()
{
    global $con;
    $service_id = $_POST['service_id'];
    $service = $_POST['service'];
    $nhisitem = $_POST['nhisitem'];
    $price_cash = $_POST['price_cash'];
    $price_private = $_POST['price_private'];
    
    $query = "UPDATE `services` SET `service`='$service',`nhis_id`='$nhisitem',
    `price_cash`='$price_cash',`price_private`='$price_private' WHERE `service_id`='$service_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "Service Saved";
    }
    else
    {
        echo "service NOT Updated";
    };
}

function search_service()
{
    global $con;
    $value = '';
    if(isset($_POST["search"]))
    {
     $search = mysqli_real_escape_string($con, $_POST["search"]);
     $query = "SELECT * FROM services 
      WHERE service LIKE '%".$search."%' ORDER BY service ASC";
    }
    else
    {
        $query = "SELECT * FROM services ORDER BY service ASC";
    }
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="serviceTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="action-td">Service</th>
                <th class="action-td">G-DRG</th>
                <th class="action-td">G-DRG Adult</th>
                <th class="action-td">G-DRG Child</th>
                <th class="action-td">Price (Cash)</th>
                <th class="action-td">Price (Private)</th>
                <th class="action-td">Price (NHIS Adult)</th>
                <th class="action-td">Price (NHIS Child)</th>
                <th class="action-td">Action</th>
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
                        
                        $NA='N/A';

                        $value.='<tr>
                            <td>
                                <a href="#" id="btn_edit_service" data-id="'.$row['service_id'].'">'.$row['service'].'</a>
                            </td>';
                            if ($row_nhis==null){$value.='<td class="action-td">'.$NA.'</td>';}else{$value.='<td class="action-td">'.$row_nhis['gdrg'].'</td>';};
                            if ($row_nhis==null){$value.='<td class="action-td">'.$NA.'</td>';}else{$value.='<td class="action-td">'.$row_nhis['gdrg_adult'].'</td>';};
                            if ($row_nhis==null){$value.='<td class="action-td">'.$NA.'</td>';}else{$value.='<td class="action-td">'.$row_nhis['gdrg_child'].'</td>';};
                            $value.='<td class="amt-td">'.$row['price_cash'].'</td>
                            <td class="amt-td">'.$row['price_private'].'</td>';
                            if ($row_nhis==null){$value.='<td class="amt-td">'.$NA.'</td>';}else{$value.='<td class="amt-td">'.$row_nhis['price_adult'].'</td>';};
                            if ($row_nhis==null){$value.='<td class="amt-td">'.$NA.'</td>';}else{$value.='<td class="amt-td">'.$row_nhis['price_child'].'</td>';};
                            $value.='<td class="action-td">
                                <a href="#" id="btn_delete_service" data-id="'.$row['service_id'].'"
                                data-id1="'.$row['service'].'"><i class="fa fa-trash fa-sm"></i></a>
                            </td>
                        </tr>';
                        
                    }
                }
                else
                {
                    $value.='Data Not Found';
                };
            
                $value.='</tbody>
    </table>';
    echo $value;
    
}

function delete_service()
{
    global $con;
    $service_id = $_POST['service_id'];
    
    $query = "SELECT * FROM `service_list` WHERE `service_id`='$service_id'";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) < 1)
    {
        $query = "DELETE FROM `services` WHERE `service_id`='$service_id'";
        mysqli_query($con, $query);
        echo 'deleted';
    }
    else
    {
        echo 'used';
    };
}

?>
