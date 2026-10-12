<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//SURGERIES AND PROCEDURES
function save_surgery()
{
    global $con;
    $surgery = $_POST['surgery'];
    $nhisitem = $_POST['nhisitem'];
    $icd_10 = $_POST['icd_10'];
    $price_cash = $_POST['price_cash'];
    $price_private = $_POST['price_private'];
    $price_private_topup = $_POST['price_private_topup'];
    $price_nhis_topup = $_POST['price_nhis_topup'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $branch_id = $_SESSION['branch_id'];
    
    $query = "INSERT INTO `surgery`(`nhis_id`, `surgery`, `icd_10`, `price_cash`, `price_private`,
    `price_private_topup`, `price_nhis_topup`, `company_id`, `user_id`, `created_by`, `created_datetime`,
    `branch_id`
    ) 
    VALUES ('$nhisitem','$surgery','$icd_10','$price_cash','$price_private','$price_private_topup',
    '$price_nhis_topup','$company_id','$user_id','$user_id',NOW(),'$branch_id'
    )";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "Surgery Saved";
    }
    else
    {
        echo "Surgery NOT Added";
    };
}

/*function list_surgery()
{
    global $con;
    $value='';
    $query = "SELECT * FROM surgery ORDER BY surgery ASC";
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="diagnosisTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="action-td">Surgery</th>
                        <th class="action-td">ICD-10</th>
                        <th class="action-td">G-DRG</th>
                        <th class="action-td">G-DRG Adult</th>
                        <th class="action-td">G-DRG Child</th>
                        <th class="action-td">Price - Cash</th>
                        <th class="action-td">Price - Adult</th>
                        <th class="action-td">Price - Child</th>
                        <th class="action-td">Delete</th>
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
                                        <a href="#" id="btn_edit_surgery" data-id="'.$row['surgery_id'].'">'.$row['surgery'].'</a>
                                    </td>
                                    <td class="action-td">'.$row['icd_10'].'</td>';
                                    if ($row_nhis==null){$value.='<td class="action-td">'.$NA.'</td>';}else{$value.='<td class="action-td">'.$row_nhis['gdrg'].'</td>';};
                                    if ($row_nhis==null){$value.='<td class="action-td">'.$NA.'</td>';}else{$value.='<td class="action-td">'.$row_nhis['gdrg_adult'].'</td>';};
                                    if ($row_nhis==null){$value.='<td class="action-td">'.$NA.'</td>';}else{$value.='<td class="action-td">'.$row_nhis['gdrg_child'].'</td>';};
                                    $value.='<td class="amt-td">'.$row['price_cash'].'</td>';
                                    if ($row_nhis==null){$value.='<td class="amt-td">'.$NA.'</td>';}else{$value.='<td class="amt-td">'.$row_nhis['price_adult'].'</td>';};
                                    if ($row_nhis==null){$value.='<td class="amt-td">'.$NA.'</td>';}else{$value.='<td class="amt-td">'.$row_nhis['price_child'].'</td>';};
                                    $value.='<td class="action-td">
                                        <a href="#" id="btn_delete_surgery" data-id="'.$row['surgery_id'].'"
                                        data-id1="'.$row['surgery'].'"><i class="fa fa-trash fa-sm"></i></a>
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

function edit_surgery()
{
    global $con;
    $surgery_id = $_POST['surgery_id'];
    $query = "SELECT * from surgery where surgery_id='$surgery_id'";
    $result = mysqli_query($con,$query);
    $surgery_item=array();
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($surgery_item, 
            $row['surgery_id'],
            $row['nhis_id'],
            $row['surgery'],
            $row['price_cash'],
            $row['icd_10'],
            $row['price_private'],
            $row['price_private_topup'],
            $row['price_nhis_topup']
        );
    }
     echo json_encode($surgery_item);
}

function update_surgery()
{
    global $con;
    $surgery_id = $_POST['surgery_id'];
    $surgery = $_POST['surgery'];
    $nhisitem = $_POST['nhisitem'];
    $icd_10 = $_POST['icd_10'];
    $price_cash = $_POST['price_cash'];
    $price_private = $_POST['price_private'];
    $price_private_topup = $_POST['price_private_topup'];
    $price_nhis_topup = $_POST['price_nhis_topup'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "UPDATE `surgery` SET `surgery`='$surgery',`nhis_id`='$nhisitem',`icd_10`='$icd_10',
    `price_cash`='$price_cash',`price_private`='$price_private',`price_private_topup`='$price_private_topup',
    `price_nhis_topup`='$price_nhis_topup',`altered_by`= '$user_id',`altered_datetime`= NOW() 
    WHERE `surgery_id`='$surgery_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "Surgery Saved";
    }
    else
    {
        echo "Surgery NOT Updated";
    };
}

function search_surgery()
{
    global $con;
    $value = '';
    if(isset($_POST["search"]))
    {
     $search = mysqli_real_escape_string($con, $_POST["search"]);
     $query = "SELECT * FROM surgery 
      WHERE surgery LIKE '%".$search."%' 
      OR icd_10 LIKE '%".$search."%' ORDER BY surgery ASC";
    }
    else
    {
        $query = "SELECT * FROM surgery ORDER BY surgery ASC";
    }
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="diagnosisTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="action-td">Surgery</th>
                        <th class="action-td">ICD-10</th>
                        <th class="action-td">G-DRG</th>
                        <th class="action-td">G-DRG Adult</th>
                        <th class="action-td">G-DRG Child</th>
                        <th class="action-td">Price - Cash</th>
                        <th class="action-td">Price - Adult</th>
                        <th class="action-td">Price - Child</th>
                        <th class="action-td">Delete</th>
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
                                        <a href="#" id="btn_edit_surgery" data-id="'.$row['surgery_id'].'">'.$row['surgery'].'</a>
                                    </td>
                                    <td class="action-td">'.$row['icd_10'].'</td>';
                                    if ($row_nhis==null){$value.='<td class="action-td">'.$NA.'</td>';}else{$value.='<td class="action-td">'.$row_nhis['gdrg'].'</td>';};
                                    if ($row_nhis==null){$value.='<td class="action-td">'.$NA.'</td>';}else{$value.='<td class="action-td">'.$row_nhis['gdrg_adult'].'</td>';};
                                    if ($row_nhis==null){$value.='<td class="action-td">'.$NA.'</td>';}else{$value.='<td class="action-td">'.$row_nhis['gdrg_child'].'</td>';};
                                    $value.='<td class="amt-td">'.$row['price_cash'].'</td>';
                                    if ($row_nhis==null){$value.='<td class="amt-td">'.$NA.'</td>';}else{$value.='<td class="amt-td">'.$row_nhis['price_adult'].'</td>';};
                                    if ($row_nhis==null){$value.='<td class="amt-td">'.$NA.'</td>';}else{$value.='<td class="amt-td">'.$row_nhis['price_child'].'</td>';};
                                    $value.='<td class="action-td">
                                        <a href="#" id="btn_delete_surgery" data-id="'.$row['surgery_id'].'"
                                        data-id1="'.$row['surgery'].'"><i class="fa fa-trash fa-sm"></i></a>
                                    </td>
                                </tr>';
                            };
                        }
                        else
                        {
                            echo 'Data Not Found';
                        };
                    
                $value.='</tbody>
            </table>';
            echo $value;
    
}

function delete_surgery()
{
    global $con;
    $surgery_id = $_POST['surgery_id'];
    
    $query = "SELECT * FROM `surgery_list` WHERE `surgery_id`='$surgery_id'";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) < 1)
    {
        $query = "DELETE FROM `surgery` WHERE `surgery_id`='$surgery_id'";
        mysqli_query($con, $query);
        echo 'deleted';
    }
    else
    {
        echo 'used';
    };
}

?>
