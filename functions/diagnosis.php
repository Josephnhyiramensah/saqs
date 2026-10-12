<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//DIAGNOSIS
function save_diagnosis()
{
    global $con;
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    $diagnosis = $_POST['diagnosis'];
    $nhisitem = $_POST['nhisitem'];
    $icd_10 = $_POST['icd_10'];
    $disease_categroy = $_POST['disease_categroy'];
    $disease_group = $_POST['disease_group'];
    
    $query = "INSERT INTO `diagnosis`(`diag_cat_id`,`diag_group_id`,`nhis_id`, `diagnosis`, 
    `icd_10`,`company_id`,`branch_id`,`created_by`,`created_datetime`) VALUES ('$disease_categroy','$disease_group','$nhisitem',
    '$diagnosis','$icd_10','$company_id','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "Diagnosis Saved";
    }
    else
    {
        echo "Diagnosis NOT Added";
    };
}

function save_diagnosis_from_attend()
{
    global $con;
    $diagnosis = $_POST['diagnosis'];
    $nhisitem = 0;
    $icd_10 = 0;
    $disease_categroy = 0;
    $disease_group = 0;
    
    $query = "INSERT INTO `diagnosis`(`diag_cat_id`,`diag_group_id`,`nhis_id`, `diagnosis`, `icd_10`) 
    VALUES ('$disease_categroy','$disease_group','$nhisitem','$diagnosis','$icd_10')";
    mysqli_query($con, $query);
}

/*function list_diagnosis()
{
    global $con;
    $value='';
    $query = "SELECT * FROM diagnosis ORDER BY diagnosis ASC";
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="diagnosisTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Diagnosis</th>
                        <th>ICD-10</th>
                        <th>G-DRG</th>
                        <th>G-DRG Adult</th>
                        <th>G-DRG Child</th>
                        <th>Price</th>
                        <th>Price Adult</th>
                        <th>Price Child</th>
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
                                $NA='N/A';
                                $value.='<tr>
                                    <td>
                                        <a href="#" id="btn_edit_diagnosis" data-id="'.$row['diagnosis_id'].'">'.$row['diagnosis'].'</a>
                                    </td>
                                    <td>'.$row['icd_10'].'</td>';
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['gdrg'].'</td>';};
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['gdrg_adult'].'</td>';};
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['gdrg_child'].'</td>';};
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['price'].'</td>';};
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['price_adult'].'</td>';};
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['price_child'].'</td>';};
                                    $value.='<td>
                                        <a href="#" id="btn_delete_diagnosis" data-id2="'.$row['diagnosis_id'].'"><i class="fa fa-trash fa-sm"></i></a>
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

function edit_diagnosis()
{
    global $con;
    $diagnosis_id = $_POST['diagnosis_id'];
    $query = "SELECT * from diagnosis where diagnosis_id='$diagnosis_id'";
    $result = mysqli_query($con,$query);
    $diagnosis_item=array();
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($diagnosis_item, 
            $row['diagnosis_id'],
            $row['nhis_id'],
            $row['diagnosis'],
            $row['icd_10'],
            $row['diag_cat_id'],
            $row['diag_group_id']
        );
    }
     echo json_encode($diagnosis_item);
}

function update_diagnosis()
{
    global $con;
    $diagnosis_id = $_POST['diagnosis_id'];
    $diagnosis = $_POST['diagnosis'];
    $nhisitem = $_POST['nhisitem'];
    $icd_10 = $_POST['icd_10'];
    $disease_categroy = $_POST['disease_categroy'];
    $disease_group = $_POST['disease_group'];
    
    $query = "UPDATE `diagnosis` SET `diagnosis`='$diagnosis',`nhis_id`='$nhisitem',`icd_10`='$icd_10',`diag_group_id`='$disease_group',`diag_cat_id`='$disease_categroy' WHERE `diagnosis_id`='$diagnosis_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "Diagnosis Saved";
    }
    else
    {
        echo "Diagnosis NOT Updated";
    };
}

function search_diagnosis()
{
    global $con;
    $value = '';
    if(isset($_POST["search"]))
    {
     $search = mysqli_real_escape_string($con, $_POST["search"]);
     $query = "SELECT * FROM diagnosis 
      WHERE diagnosis LIKE '%".$search."%' 
      OR icd_10 LIKE '%".$search."%' ORDER BY diagnosis ASC";
    }
    else
    {
        $query = "SELECT * FROM diagnosis ORDER BY diagnosis ASC";
    }
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="diagnosisTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="action-td">Diagnosis</th>
                        <th class="action-td">ICD-10</th>
                        <th class="action-td">G-DRG</th>
                        <th class="action-td">G-DRG Adult</th>
                        <th class="action-td">G-DRG Child</th>
                        <th class="action-td">Price</th>
                        <th class="action-td">Price Adult</th>
                        <th class="action-td">Price Child</th>
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
                                        <a href="#" id="btn_edit_diagnosis" data-id="'.$row['diagnosis_id'].'">'.$row['diagnosis'].'</a>
                                    </td>
                                    <td class="action-td">'.$row['icd_10'].'</td>';
                                    if ($row_nhis==null){$value.='<td class="action-td">'.$NA.'</td>';}else{$value.='<td class="action-td">'.$row_nhis['gdrg'].'</td>';};
                                    if ($row_nhis==null){$value.='<td class="action-td">'.$NA.'</td>';}else{$value.='<td class="action-td">'.$row_nhis['gdrg_adult'].'</td>';};
                                    if ($row_nhis==null){$value.='<td class="action-td">'.$NA.'</td>';}else{$value.='<td class="action-td">'.$row_nhis['gdrg_child'].'</td>';};
                                    if ($row_nhis==null){$value.='<td class="amt-td">'.$NA.'</td>';}else{$value.='<td class="amt-td">'.$row_nhis['price'].'</td>';};
                                    if ($row_nhis==null){$value.='<td class="amt-td">'.$NA.'</td>';}else{$value.='<td class="amt-td">'.$row_nhis['price_adult'].'</td>';};
                                    if ($row_nhis==null){$value.='<td class="amt-td">'.$NA.'</td>';}else{$value.='<td class="amt-td">'.$row_nhis['price_child'].'</td>';};
                                    $value.='<td class="action-td">
                                        <a href="#" id="btn_delete_diagnosis" data-id="'.$row['diagnosis_id'].'" data-id1="'.$row['diagnosis'].'"><i class="fa fa-trash fa-sm"></i></a>
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
}

function delete_diagnosis()
{
    global $con;
    $diagnosis_id = $_POST['diagnosis_id'];
    
    $query = "SELECT * FROM `diagnosis_list` WHERE `diagnosis_id`='$diagnosis_id'";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) < 1)
    {
        $query = "DELETE FROM `diagnosis` WHERE `diagnosis_id`='$diagnosis_id'";
        mysqli_query($con, $query);
        echo 'deleted';
    }
    else
    {
        echo 'used';
    };
}

?>
