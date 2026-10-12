<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//DRUGS
function save_new_drug()
{
    global $con;
    $brand_name = $_POST['brand_name'];
    $nhisitem = $_POST['nhisitem'];
    $generic_name = $_POST['generic_name'];

    $code = $_POST['code'];
    $price_cash = $_POST['price_cash'];
    $price_nhis = $_POST['price_nhis'];

    $price_prvt = $_POST['price_prvt'];
    $age_from = $_POST['age_from'];
    $age_to = $_POST['age_to'];

    $route = $_POST['route'];
    $unit_of_measure = $_POST['unit_of_measure'];
    $classification = $_POST['classification'];

    $category = $_POST['category'];
    $type = $_POST['type'];
    $manufacturer = $_POST['manufacturer'];
    
    $gender = $_POST['gender'];
    $block_neg = $_POST['block_neg'];
    $batch = $_POST['batch'];
    $expiry_date = $_POST['expiry_date'];
    $days_prompt = $_POST['days_prompt'];
    
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO `drugs`(`nhis_id`, `brand_name`, `generic_name`,`code`, 
    `type`, `class`,`category`, `unit`, `manufacturer`,`price_cash`, `price_nhis`, 
    `price_prvt`,`age_from`, `age_to`, `gender`,`block_neg`, `expiry_date`, `batch`,
    `days_prompt`, `route`, `company_id`, `branch_id`, `created_by`, `created_datetime`) 
    VALUES ('$nhisitem','$brand_name','$generic_name',
    '$code','$type','$classification','$category','$unit_of_measure','$manufacturer',
    '$price_cash','$price_nhis','$price_prvt','$age_from','$age_to','$gender',
    '$block_neg','$expiry_date','$batch','$days_prompt','$route',
    '$company_id','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "Drug Saved";
    }
    else
    {
        echo "Drug NOT Added";
    };
}

/*function list_drugs()
{
    global $con;
    $value='';
    $query = "SELECT * FROM drugs ORDER BY brand_name ASC";
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="drugTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Brand Name</th>
                        <th>Generic Name</th>
                        <th>Price - Cash</th>
                        <th>Price - NHIS</th>
                        <th>Price - Private</th>
                        <th>Code</th>
                        <th>Unit</th>
                        <th>Gender</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';

                        if (mysqli_num_rows($query_run) > 0)
                        {
                            while($row=mysqli_fetch_assoc($query_run))
                            {
                                $nhis_id = $row['nhis_id'];
                                $gender_id = $row['gender'];
                                $query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
                                $query_nhis_run = mysqli_query($con, $query_nhis);
                                $row_nhis=mysqli_fetch_assoc($query_nhis_run);

                                $query_gender = "SELECT * FROM gender WHERE gender_id='$gender_id'";
                                $query_gender_run = mysqli_query($con, $query_gender);
                                $row_gender=mysqli_fetch_assoc($query_gender_run);
                                
                                $unit_id = $row['unit'];
                                $query_unit="SELECT * FROM unit WHERE unit_id = '$unit_id' ORDER BY formal_name ASC";
                                $query_unit_run = mysqli_query($con, $query_unit);
                                if($query_unit_run)
                                {
                                    $row_unit=mysqli_fetch_assoc($query_unit_run);
                                    $unit = $row_unit['formal_name'];
                                }
                                else
                                {
                                    $unit = 'No Unit';
                                };

                                $NA='N/A';
                                $value.='<tr>
                                    <td>
                                        <a href="#" id="btn_edit_drug" data-id="'.$row['drug_id'].'">'.$row['brand_name'].'</a>
                                    </td>
                                    <td>'.$row['generic_name'].'</td>
                                    <td>'.$row['price_cash'].'</td>';
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['price'].'</td>';};
                                    $value.='<td>'.$row['price_prvt'].'</td>';
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['gdrg'].'</td>';};
                                    $value.='<td>'.$unit.'</td>';
                                    if ($row_gender==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_gender['gender'].'</td>';};
                                    $value.='<td>
                                        <a href="#" id="btn_delete_drug" data-id2="'.$row['drug_id'].'"><i class="fa fa-trash fa-sm"></i></a>
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

function edit_drug()
{
    global $con;
    $drug_id = $_POST['drug_id'];
    $query = "SELECT * from drugs where drug_id='$drug_id'";
    $result = mysqli_query($con,$query);
    $drug_item=array();
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($drug_item, 
            $row['drug_id'],
            $row['nhis_id'],
            $row['brand_name'],
            $row['generic_name'],
            $row['code'],
            $row['type'],
            $row['class'],
            $row['category'],
            $row['unit'],
            $row['manufacturer'],
            $row['price_cash'],
            $row['price_nhis'],
            $row['price_prvt'],
            $row['age_from'],
            $row['age_to'],
            $row['gender'],
            $row['block_neg'],
            $row['expiry_date'],
            $row['batch'],
            $row['days_prompt'],
            $row['route']

        );
    }
     echo json_encode($drug_item);
}

function update_drug()
{
    global $con;
    $drug_id = $_POST['drug_id'];
    $brand_name = $_POST['brand_name'];
    $nhisitem = $_POST['nhisitem'];
    $generic_name = $_POST['generic_name'];

    $code = $_POST['code'];
    $price_cash = $_POST['price_cash'];
    $price_nhis = $_POST['price_nhis'];

    $price_prvt = $_POST['price_prvt'];
    $age_from = $_POST['age_from'];
    $age_to = $_POST['age_to'];

    $route = $_POST['route'];
    $unit_of_measure = $_POST['unit_of_measure'];
    $classification = $_POST['classification'];

    $category = $_POST['category'];
    $type = $_POST['type'];
    $manufacturer = $_POST['manufacturer'];
    
    $gender = $_POST['gender'];
    $block_neg = $_POST['block_neg'];
    $batch = $_POST['batch'];
    $expiry_date = $_POST['expiry_date'];
    $days_prompt = $_POST['days_prompt'];
    
    $query = "UPDATE `drugs` SET 
    `nhis_id`='$nhisitem',
    `brand_name`='$brand_name',
    `generic_name`='$generic_name',
    `code`='$code',
    `type`='$type',
    `class`='$classification',
    `category`='$category',
    `unit`='$unit_of_measure',
    `manufacturer`='$manufacturer',
    `price_cash`='$price_cash',
    `price_nhis`='$price_nhis',
    `price_prvt`='$price_prvt',
    `age_from`='$age_from',
    `age_to`='$age_to',
    `gender`='$gender',
    `block_neg`='$block_neg',
    `expiry_date`='$expiry_date',
    `batch`='$batch',
    `days_prompt`='$days_prompt',
    `route`='$route' WHERE `drug_id`='$drug_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "Drug Saved";
    }
    else
    {
        echo "Drug NOT Updated";
    };
}

function search_drug()
{
    global $con;
    $value = '';
    if(isset($_POST["search"]))
    {
     $search = mysqli_real_escape_string($con, $_POST["search"]);
     $query = "SELECT * FROM drugs 
      WHERE brand_name LIKE '%".$search."%' 
      OR generic_name LIKE '%".$search."%'";
    }
    else
    {
        $query = "SELECT * FROM drugs ORDER BY brand_name";
    }
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="drugTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Brand Name</th>
                        <th>Generic Name</th>
                        <th>Price - Cash</th>
                        <th>Price - NHIS</th>
                        <th>Price - Private</th>
                        <th>Code</th>
                        <th>Unit</th>
                        <th>Gender</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';

                        if (mysqli_num_rows($query_run) > 0)
                        {
                            while($row=mysqli_fetch_assoc($query_run))
                            {
                                $nhis_id = $row['nhis_id'];
                                $gender_id = $row['gender'];
                                $query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
                                $query_nhis_run = mysqli_query($con, $query_nhis);
                                $row_nhis=mysqli_fetch_assoc($query_nhis_run);

                                $query_gender = "SELECT * FROM gender WHERE gender_id='$gender_id'";
                                $query_gender_run = mysqli_query($con, $query_gender);
                                $row_gender=mysqli_fetch_assoc($query_gender_run);
                                
                                $unit_id = $row['unit'];
                                $query_unit="SELECT * FROM unit WHERE unit_id = '$unit_id' ORDER BY formal_name ASC";
                                $query_unit_run = mysqli_query($con, $query_unit);
                                $row_unit=mysqli_fetch_assoc($query_unit_run);

                                $NA='N/A';
                                $value.='<tr>
                                    <td>
                                        <a href="#" id="btn_edit_drug" data-id="'.$row['drug_id'].'">'.$row['brand_name'].'</a>
                                    </td>
                                    <td>'.$row['generic_name'].'</td>
                                    <td>'.$row['price_cash'].'</td>';
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['price'].'</td>';};
                                    $value.='<td>'.$row['price_prvt'].'</td>';
                                    if ($row_nhis==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_nhis['gdrg'].'</td>';};
                                    $value.='<td>'.$row_unit['formal_name'].'</td>';
                                    if ($row_gender==null){$value.='<td>'.$NA.'</td>';}else{$value.='<td>'.$row_gender['gender'].'</td>';};
                                    $value.='<td>
                                        <a href="#" id="btn_delete_drug" data-id="'.$row['drug_id'].'"
                                        data-id1="'.$row['brand_name'].'"><i class="fa fa-trash fa-sm"></i></a>
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

function save_composite_drug()
{
    global $con;
    $composite_drug_id = $_POST['composite_drug_id'];
    $composite_drug = $_POST['composite_drug'];
    $composite_drug_price = $_POST['composite_drug_price'];
    $company_id = $_POST['company_id'];
    $branch_id = $_POST['branch_id'];
    $user_id = $_POST['user_id'];
    
    $query = "INSERT INTO `composite_drugs`(`company_id`, `branch_id`, `user_id`, `composite_drug`, 
    `price`, `created_by`, `created_datetime`) VALUES ('$company_id','$branch_id',
    '$user_id','$composite_drug','$composite_drug_price','$user_id',NOW())";
    mysqli_query($con, $query);
}

function edit_composite_drug()
{
    global $con;
    $Data = array();
    $composite_drug_id = $_POST['composite_drug_id'];
    $query = "SELECT * FROM composite_drugs WHERE composite_drug_id = $composite_drug_id";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);
    if ($row) 
    {
        array_push(
            $Data, 
            $row['composite_drug_id'],
            $row['composite_drug'],
            $row['price']
        );
    };
    echo json_encode($Data);
}

function update_composite_drug()
{
    global $con;
    $composite_drug_id = $_POST['composite_drug_id'];
    $composite_drug = $_POST['composite_drug'];
    $composite_drug_price = $_POST['composite_drug_price'];
    $company_id = $_POST['company_id'];
    $branch_id = $_POST['branch_id'];
    $user_id = $_POST['user_id'];
    
    $query = "UPDATE `composite_drugs` SET `composite_drug`='$composite_drug', 
    `price`='$composite_drug_price', `altered_by`='$user_id', `altered_datetime`= NOW()
    WHERE `composite_drug_id`='$composite_drug_id'";
    mysqli_query($con, $query);
}

function delete_composite_drug()
{
    global $con;
    $composite_lab_id = $_POST['composite_lab_id'];
    $query = "DELETE FROM `composite_drugs` WHERE `composite_drug_id`= '$composite_drug_id'";
    mysqli_query($con, $query);

    $query = "DELETE FROM `composite_drug_list` WHERE `composite_drug_id`= '$composite_drug_id'";
    mysqli_query($con, $query);
}

function save_composite_drug_list()
{
    global $con;
    $composite_drug_id = $_POST['composite_drug_id'];
    $composite_drug_list_id = $_POST['composite_drug_list_id'];
    $composite_drug_list_drug_id = $_POST['composite_drug_list_drug_id'];
    $composite_drug_dosage = $_POST['composite_drug_dosage'];
    $composite_drug_qty = $_POST['composite_drug_qty'];
    $company_id = $_POST['company_id'];
    $branch_id = $_POST['branch_id'];
    $user_id = $_POST['user_id'];
    
    $query = "INSERT INTO `composite_drug_list`(`company_id`, `branch_id`, `user_id`, `composite_drug_id`, 
    `drug_id`, `created_by`, `created_datetime`, `dosage`, `qty`) 
    VALUES ('$company_id','$branch_id','$user_id','$composite_drug_id','$composite_drug_list_drug_id',
    '$user_id',NOW(),'$composite_drug_dosage','$composite_drug_qty')";
    mysqli_query($con, $query);
}

function edit_composite_drug_list()
{
    global $con;
    $Data = array();
    $composite_drug_list_id = $_POST['composite_drug_list_id'];
    $query = "SELECT * FROM composite_drug_list WHERE composite_drug_list_id = $composite_drug_list_id";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);
    if ($row) 
    {
        array_push(
            $Data, 
            $row['composite_drug_list_id'],
            $row['composite_drug_id'],
            $row['drug_id'],
            $row['dosage'],
            $row['qty']
        );
    };
    echo json_encode($Data);
}

function update_composite_drug_list()
{
    global $con;
    $composite_drug_id = $_POST['composite_drug_id'];
    $composite_drug_list_id = $_POST['composite_drug_list_id'];
    $composite_drug_list_drug_id = $_POST['composite_drug_list_drug_id'];
    $composite_drug_dosage = $_POST['composite_drug_dosage'];
    $composite_drug_qty = $_POST['composite_drug_qty'];
    $company_id = $_POST['company_id'];
    $branch_id = $_POST['branch_id'];
    $user_id = $_POST['user_id'];
    
    $query = "UPDATE `composite_drug_list` SET `composite_drug_id`='$composite_drug_id', 
    `drug_id`='$composite_drug_list_drug_id', `altered_by`='$user_id', `altered_datetime`=NOW(), 
    `dosage`='$composite_drug_dosage',`qty`='$composite_drug_qty'WHERE `composite_drug_list_id`='$composite_drug_list_id'";
    mysqli_query($con, $query);
}

function delete_composite_drug_list()
{
    global $con;
    $composite_drug_list_id = $_POST['composite_drug_list_id'];
    $query = "DELETE FROM `composite_drug_list` WHERE `composite_drug_list_id`= '$composite_drug_list_id'";
    mysqli_query($con, $query);
}

function delete_drug()
{
    global $con;
    $drug_id = $_POST['drug_id'];
    
    $query = "SELECT * FROM `drug_dispense_list` WHERE `drug_id`='$drug_id'";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) < 1)
    {
        $query = "SELECT * FROM `drug_list` WHERE `drug_id`='$drug_id'";
        $query_run = mysqli_query($con, $query);
        if(mysqli_num_rows($query_run) < 1)
        {
            $query = "DELETE FROM `drugs` WHERE `drug_id`='$drug_id'";
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

?>
