<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//CONSUMABLES
function save_new_consumable()
{
    global $con;
    $consum_name = $_POST['consum_name'];
    $unit_of_measure = $_POST['unit_of_measure'];
    $type = $_POST['type'];
    $price_cash = $_POST['price_cash'];
    $price_nhis = $_POST['price_nhis'];
    $price_prvt = $_POST['price_prvt'];
    $manufacturer = $_POST['manufacturer'];
    $block_neg = $_POST['block_neg'];
    $batch = $_POST['batch'];
    $expiry_date = $_POST['expiry_date'];
    $days_prompt = $_POST['days_prompt'];
    $min_level = $_POST['min_level'];
    $max_level = $_POST['max_level'];
    $re_order_level = $_POST['re_order_level'];
    $eoq = $_POST['eoq'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "INSERT INTO `consumable`(`con_type_id`, `consumable`, `price_cash`,`price_nhis`, 
    `price_prvt`, `unit_id`,`manufacturer`, `block_negative`, `block_expiry`,`maintain_batch`, 
    `days_to_promt`, `eoq`,`min_level`, `max_level`, `re_order_level`, `company_id`, `branch_id`,
    `created_by`, `created_datetime`) 
    VALUES ('$type','$consum_name','$price_cash','$price_nhis','$price_prvt','$unit_of_measure',
    '$manufacturer','$block_neg','$expiry_date','$batch','$days_prompt','$eoq','$min_level',
    '$max_level','$re_order_level','$company_id','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        list_consumables();
    }
    else
    {
        echo "Consumable NOT Added";
    };
}

function list_consumables()
{
    global $con;
    $value='';
    $query = "SELECT * FROM consumable ORDER BY consumable ASC";
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="consumTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Description</th>
                <th>Type</th>
                <th>Unit</th>
                <th>Price - Cash</th>
                <th>Price - NHIS</th>
                <th>Price - Private</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">';

        if (mysqli_num_rows($query_run) > 0)
        {
            while($row=mysqli_fetch_assoc($query_run))
            {
                $con_type_id = $row['con_type_id'];
                $query_type = "SELECT * FROM consumable_type WHERE con_type_id='$con_type_id'";
                $query_type_run = mysqli_query($con, $query_type);

                if($query_type_run)
                {
                    $row_type = mysqli_fetch_assoc($query_type_run);
                    if($row_type != '')
                    {
                        $consum_type = $row_type['consum_type'];
                    }
                    else
                    {
                        $consum_type = 'No Type';
                    };
                }
                else
                {
                    $consum_type = 'No Type';
                };

                $unit_id = $row['unit_id'];
                $query_unit = "SELECT * FROM unit WHERE unit_id='$unit_id'";
                $query_unit_run = mysqli_query($con, $query_unit);
                
                if($query_unit_run)
                {
                    $row_unit = mysqli_fetch_assoc($query_unit_run);
                    if($row_unit != '')
                    {
                        $unit = $row_unit['formal_name'];
                    }
                    else
                    {
                        $unit = 'No Unit';
                    };
                }
                else
                {
                    $unit = 'No Unit';
                };

                $NA='N/A';
                $value.='<tr>
                    <td>
                        <a href="#" id="btn_edit_consum" data-id="'.$row['con_id'].'">'.$row['consumable'].'</a>
                    </td>
                    <td>'.$consum_type.'</td>
                    <td>'.$unit.'</td>
                    <td>'.$row['price_cash'].'</td>
                    <td>'.$row['price_nhis'].'</td>
                    <td>'.$row['price_prvt'].'</td>';
                    $value.='<td>
                        <a href="#" id="btn_delete_consum" data-id2="'.$row['con_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                    </td>
                </tr>';
            }
        };
            
        $value.='</tbody>
    </table>';
    echo $value;
}

function edit_consumable()
{
    global $con;
    $con_id = $_POST['con_id'];
    $query = "SELECT * from consumable where con_id='$con_id'";
    $result = mysqli_query($con,$query);
    $consum_item=array();
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($consum_item, 
            $row['con_id'],
            $row['con_type_id'],
            $row['consumable'],
            $row['price_cash'],
            $row['price_nhis'],
            $row['price_prvt'],
            $row['unit_id'],
            $row['manufacturer'],
            $row['block_negative'],
            $row['block_expiry'],
            $row['maintain_batch'],
            $row['days_to_promt'],
            $row['eoq'],
            $row['min_level'],
            $row['max_level'],
            $row['re_order_level']

        );
    }
     echo json_encode($consum_item);
}

function update_consumable()
{
    global $con;
    $con_id = $_POST['con_id'];
    $consum_name = $_POST['consum_name'];
    $unit_of_measure = $_POST['unit_of_measure'];
    $type = $_POST['type'];
    $price_cash = $_POST['price_cash'];
    $price_nhis = $_POST['price_nhis'];
    $price_prvt = $_POST['price_prvt'];
    $manufacturer = $_POST['manufacturer'];
    $block_neg = $_POST['block_neg'];
    $batch = $_POST['batch'];
    $expiry_date = $_POST['expiry_date'];
    $days_prompt = $_POST['days_prompt'];
    $min_level = $_POST['min_level'];
    $max_level = $_POST['max_level'];
    $re_order_level = $_POST['re_order_level'];
    $eoq = $_POST['eoq'];
    
    $query = "UPDATE `consumable` SET 
    `con_type_id`='$type', `consumable`='$consum_name', `price_cash`='$price_cash',
    `price_nhis`='$price_nhis', `price_prvt`='$price_prvt', `unit_id`='$unit_of_measure',
    `manufacturer`='$manufacturer', `block_negative`='$block_neg', 
    `block_expiry`='$expiry_date',`maintain_batch`='$batch', `days_to_promt`='$days_prompt', 
    `eoq`='$eoq',`min_level`='$min_level', `max_level`='$max_level', 
    `re_order_level`='$re_order_level' WHERE `con_id`='$con_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        list_consumables();
    }
    else
    {
        echo "Consumable NOT Updated";
    };
}

?>
