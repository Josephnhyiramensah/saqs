<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//STOCK ADJUSTMENT
function stock_adjustment_item_list()
{
    global $con;
    $count = $_POST['i'];
    $value = "";
    $value = '<td>
                <input type="hidden" name="stk_adj_item_list_id[]" class="form-control bg-light" id="stk_adj_item_list_id'.$count.'">
                <input type="hidden" name="item_cat_id[]" class="form-control bg-light" id="item_cat_id'.$count.'">
                <select class="form-control stk_adj_item_id bg-light" name="stk_adj_item_id[]" id="stk_adj_item_id'.$count.'" data-id="'.$count.'" style="border-width:0px"> 
                    <option value="0">Please Select</option>';
                    
                        $sql="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
                        UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable ORDER BY item_desc";
                        $result=mysqli_query($con,$sql);
                        while($row=mysqli_fetch_array($result))
                        {
                            $value .= '<option value ="'.$row['id'].'" data-value ="'.$row['category_id'].'">'.$row['item_desc'].'</option>';
                        }
                    
        $value .= '</select>
            </td>
            <td class = "action-td">
                <select class="form-control bg-light" name="stock_adj_wh[]" id="stock_adj_wh'.$count.'"> 
                    <option value="0">Please Select</option>';
                     
                        $sql="SELECT * FROM warehouse WHERE company_id = '".$_SESSION['company_id']."' ORDER BY warehouse_desc ASC";
                        $result=mysqli_query($con,$sql);
                        while($row=mysqli_fetch_array($result))
                        {
                            $value .= '<option value = "'.$row['warehouse_id'].'" >'.$row['warehouse_desc'].'</option>';
                        }               
                   
        $value .= '</select>
            </td>
            <td class = "action-td">
                <input type="text" name="stk_adj_qty_in[]" class="form-control bg-light stk_adj_qty_in" id="stk_adj_qty_in'.$count.'" data-id="'.$count.'" style="border-width:0px">
            </td>
            <td class = "action-td">
                <input type="text" name="stk_adj_qty_out[]" class="form-control bg-light stk_adj_qty_out" id="stk_adj_qty_out'.$count.'" data-id="'.$count.'" style="border-width:0px">
            </td>
            <td class = "action-td">
                <input type="text" name="stock_adj_batch_no[]" class="form-control bg-light stock_adj_batch_no" id="stock_adj_batch_no'.$count.'" data-id="'.$count.'" style="border-width:0px">
            </td>
            <td class = "action-td">
                <a href="#" id="delete_stk_adj_item" data-id="'.$count.'"><i class="fa fa-trash fa-sm"></i></a>
            </td>';

    echo $value;
}

function save_stock_adjustment_voucher()
{
    global $con;
    $stock_adj_id = $_POST['stock_adj_id'];
    $stk_adj_adjusted_by = $_POST['stk_adj_adjusted_by'];
    $stk_adj_ref_no = $_POST['stk_adj_ref_no'];
    $stk_adj_date = $_POST['stk_adj_date'];
    $stk_adj_narration = $_POST['stk_adj_narration'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "INSERT INTO `stock_adjustment`(`company_id`, `reference_no`, `date`, `narration`, `adjusted_by`, 
    `branch_id`, `created_by`, `created_datetime`) 
    VALUES ('$company_id','$stk_adj_ref_no','$stk_adj_date','$stk_adj_narration','$stk_adj_adjusted_by',
    '$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run) 
    {
        $query = "SELECT * FROM stock_adjustment ORDER BY stock_adj_id  DESC";
        $result = mysqli_query($con,$query);
        $row = mysqli_fetch_assoc($result);
        $stock_adj_id  = $row['stock_adj_id'];

        $number_as = count($_POST["stk_adj_item_id"]);  
            if($number_as > 0)  
            {  
                for($i=0; $i<$number_as; $i++)  
                {  
                    if(trim($_POST["stk_adj_item_id"][$i] !== '') && trim($_POST["stk_adj_item_id"][$i] !== 0))  
                    {  
                        $stk_adj_item_id = $_POST['stk_adj_item_id'][$i];
                        $stk_adj_item_list_id = $_POST['stk_adj_item_list_id'][$i];
                        $item_cat_id = 2;
                        //$item_cat_id = $_POST['item_cat_id'][$i];
                        $stock_adj_wh = $_POST['stock_adj_wh'][$i];
                        $stk_adj_qty_in = $_POST['stk_adj_qty_in'][$i];
                        $stk_adj_qty_out = $_POST['stk_adj_qty_out'][$i];
                        $stock_adj_batch_no = $_POST['stock_adj_batch_no'][$i];
                        $query_stk_adj_items = "INSERT INTO `stock_adjustment_items`
                        (`company_id`,`stock_adj_id`, `date`, `item_id`, `category_id`, `warehouse_id`, `batch_no`, `qty_in`, `qty_out`,
                        `branch_id`, `created_by`, `created_datetime`) VALUES 
                        ('$company_id','$stock_adj_id','$stk_adj_date','$stk_adj_item_id','$item_cat_id','$stock_adj_wh','$stock_adj_batch_no',
                        '$stk_adj_qty_in','$stk_adj_qty_out','$branch_id','$user_id',NOW())";
                        $query_run_stk_adj_items = mysqli_query($con, $query_stk_adj_items);
                    };
                };
                echo "Stock Adjustment Items Inserted";  
            }  
            else  
            {  
                echo "Stock Adjustment Items NOT Inserted";  
            };
    };
}

function edit_stock_adjustment_voucher()
{
    global $con;
    $stock_adj_id = $_POST['stock_adj_id'];
    $stock_adj_details=array();
    $query = "SELECT * FROM stock_adjustment WHERE stock_adj_id='$stock_adj_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($stock_adj_details, 
            $row['stock_adj_id'],$row['reference_no'],$row['date'],$row['narration'],$row['adjusted_by']
        );
    }
     echo json_encode($stock_adj_details);
}

function edit_stock_adjustment_item_list()
{
    global $con;
    $stock_adj_id = $_POST['stock_adj_id'];
    $value = "";
    $value = '<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="stock_adjustment_items_table">
                <tr>
                    <th width="40%">Item Description</th>
                    <th width="20%">Location</th>
                    <th width="10%">Qty In</th>
                    <th width="10%">Qty Out</th>
                    <th width="15%">Batch No</th>
                    <th width="5%">Action</th>
                </tr>';
    $query = "SELECT * FROM stock_adjustment_items WHERE stock_adj_id='$stock_adj_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        $i=0;
        while($row=mysqli_fetch_assoc($query_run))
        {
            $i=++$i;
            $value .= '<tr id="'.$i.'">
                        <td>
                            <input type="hidden" name="stk_adj_item_list_id[]" class="form-control bg-light" id="stk_adj_item_list_id'.$i.'" value="'.$row['stk_adj_item_id'].'">
                            <input type="hidden" name="item_cat_id[]" class="form-control bg-light" id="item_cat_id'.$i.'" value="'.$row['category_id'].'">
                            <select class="form-control stk_adj_item_id bg-light" name="stk_adj_item_id[]" id="stk_adj_item_id'.$i.'" data-id="'.$i.'" style="border-width:0px">
                                <option value="0">Please Select</option>';
                                
                                    $sql="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
                                    UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable ORDER BY item_desc";
                                    $result=mysqli_query($con,$sql);
                                    while($row_item = mysqli_fetch_array($result))
                                    {
                                        if ($row['item_id'] == $row_item['id'] && $row['category_id'] == $row_item['category_id']) 
                                        {
                                            $value .= '<option value ="'.$row['item_id'].'" data-value ="'.$row_item['category_id'].'" selected="selected">'.$row_item['item_desc'].'</option>';
                                        }
                                        else
                                        {
                                            $value .= '<option value ="'.$row['item_id'].'" data-value ="'.$row_item['category_id'].'">'.$row_item['item_desc'].'</option>';
                                        }
                                    }
                    
                    $value .= '</select>
                        </td>
                        <td class = "action-td">
                            <select class="form-control bg-light" name="stock_adj_wh[]" id="stock_adj_wh'.$i.'"> 
                                <option value="0">Please Select</option>';
                                 
                                    $sql="SELECT * FROM warehouse WHERE company_id = '".$_SESSION['company_id']."' ORDER BY warehouse_desc ASC";
                                    $result=mysqli_query($con,$sql);
                                    while($row_wh = mysqli_fetch_array($result))
                                    {
                                        if ($row_wh['warehouse_id'] == $row['warehouse_id']) 
                                        {
                                            $value .= '<option value = "'.$row_wh['warehouse_id'].'" selected="selected">'.$row_wh['warehouse_desc'].'</option>';
                                        }
                                        else
                                        {
                                            $value .= '<option value = "'.$row_wh['warehouse_id'].'" >'.$row_wh['warehouse_desc'].'</option>';
                                        }
                                    }               
                               
                    $value .= '</select>
                        </td>
                        <td class = "action-td">';
                        if ($row['qty_in'] > 0) {
                            $value .= '<input type="text" name="stk_adj_qty_in[]" class="form-control bg-light stk_adj_qty_in" id="stk_adj_qty_in'.$i.'" data-id="'.$i.'" style="border-width:0px" value="'.$row['qty_in'].'">';
                        } else {
                            $value .= '<input type="text" name="stk_adj_qty_in[]" class="form-control bg-light stk_adj_qty_in" id="stk_adj_qty_in'.$i.'" data-id="'.$i.'" style="border-width:0px" hidden = "true">';
                        };
              $value .= '</td>
                        <td class = "action-td">';
                        if ($row['qty_out'] > 0) {
                            $value .= '<input type="text" name="stk_adj_qty_out[]" class="form-control bg-light stk_adj_qty_out" id="stk_adj_qty_out'.$i.'" data-id="'.$i.'" style="border-width:0px" value="'.$row['qty_out'].'">';
                        } else {
                            $value .= '<input type="text" name="stk_adj_qty_out[]" class="form-control bg-light stk_adj_qty_out" id="stk_adj_qty_out'.$i.'" data-id="'.$i.'" style="border-width:0px"  hidden = "true">';
                        };
              $value .= '</td>
                        <td class = "action-td">
                            <input type="text" name="stock_adj_batch_no[]" class="form-control bg-light stock_adj_batch_no" id="stock_adj_batch_no'.$i.'" data-id="'.$i.'" style="border-width:0px" value="'.$row['batch_no'].'">
                        </td>
                        <td class = "action-td">
                            <a href="#" id="delete_stk_adj_item" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                        </td>
                    </tr>';
        };
        $i=++$i;
            $value.='<tr id="'.$i.'">
                        <td>
                            <input type="hidden" name="stk_adj_item_list_id[]" class="form-control bg-light" id="stk_adj_item_list_id'.$i.'">
                            <input type="hidden" name="item_cat_id[]" class="form-control bg-light" id="item_cat_id'.$i.'">
                            <select class="form-control stk_adj_item_id bg-light" name="stk_adj_item_id[]" id="stk_adj_item_id'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                
                                    $sql="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
                                    UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable ORDER BY item_desc";
                                    $result=mysqli_query($con,$sql);
                                    while($row=mysqli_fetch_array($result))
                                    {
                                        $value .= '<option value ="'.$row['id'].'" data-value ="'.$row['category_id'].'">'.$row['item_desc'].'</option>';
                                    }
                                
                    $value .= '</select>
                        </td>
                        <td class = "action-td">
                            <select class="form-control bg-light" name="stock_adj_wh[]" id="stock_adj_wh'.$i.'"> 
                                <option value="0">Please Select</option>';
                                 
                                    $sql="SELECT * FROM warehouse WHERE company_id = '".$_SESSION['company_id']."' ORDER BY warehouse_desc ASC";
                                    $result=mysqli_query($con,$sql);
                                    while($row=mysqli_fetch_array($result))
                                    {
                                        $value .= '<option value = "'.$row['warehouse_id'].'" >'.$row['warehouse_desc'].'</option>';
                                    }               
                               
                    $value .= '</select>
                        </td>
                        <td class = "action-td">
                            <input type="text" name="stk_adj_qty_in[]" class="form-control bg-light stk_adj_qty_in" id="stk_adj_qty_in'.$i.'" data-id="'.$i.'" style="border-width:0px">
                        </td>
                        <td class = "action-td">
                            <input type="text" name="stk_adj_qty_out[]" class="form-control bg-light stk_adj_qty_out" id="stk_adj_qty_out'.$i.'" data-id="'.$i.'" style="border-width:0px">
                        </td>
                        <td class = "action-td">
                            <input type="text" name="stock_adj_batch_no[]" class="form-control bg-light stock_adj_batch_no" id="stock_adj_batch_no'.$i.'" data-id="'.$i.'" style="border-width:0px">
                        </td>
                        <td class = "action-td">
                            <a href="#" id="delete_stk_adj_item" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>';
    }
    echo $value;
}

function update_stock_adjustment_voucher()
{
    global $con;
    $stock_adj_id = $_POST['stock_adj_id'];
    $stk_adj_adjusted_by = $_POST['stk_adj_adjusted_by'];
    $stk_adj_ref_no = $_POST['stk_adj_ref_no'];
    $stk_adj_date = $_POST['stk_adj_date'];
    $stk_adj_narration = $_POST['stk_adj_narration'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `stock_adjustment`SET `reference_no`='$stk_adj_ref_no', `date`='$stk_adj_date', 
    `narration`='$stk_adj_narration', `adjusted_by`='$stk_adj_adjusted_by', 
    `altered_by`='$user_id', `altered_datetime`=NOW()
    WHERE `stock_adj_id`='$stock_adj_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) 
    {
        $query = "UPDATE `stock_adjustment_items` SET `status`='' WHERE `stock_adj_id`='$stock_adj_id'";
        $result = mysqli_query($con,$query);

        $number_as = count($_POST["stk_adj_item_id"]);  
        if($number_as > 0)  
        {  
            for($i=0; $i<$number_as; $i++)  
            {  
                if(trim($_POST["stk_adj_item_id"][$i] !== '') && trim($_POST["stk_adj_item_id"][$i] !== 0))  
                {  
                    $stk_adj_item_id = $_POST['stk_adj_item_id'][$i];
                    $stk_adj_item_list_id = $_POST['stk_adj_item_list_id'][$i];
                    $item_cat_id = $_POST['item_cat_id'][$i];
                    $stock_adj_wh = $_POST['stock_adj_wh'][$i];
                    $stk_adj_qty_in = $_POST['stk_adj_qty_in'][$i];
                    $stk_adj_qty_out = $_POST['stk_adj_qty_out'][$i];
                    $stock_adj_batch_no = $_POST['stock_adj_batch_no'][$i];

                    if($stk_adj_item_list_id !== '' && $stk_adj_item_list_id !== 0)
                    {
                        $query_stk_adj_items = "UPDATE `stock_adjustment_items` SET `stock_adj_id`='$stock_adj_id', 
                        `date`='$stk_adj_date', `item_id`='$stk_adj_item_id', `category_id`='$item_cat_id', 
                        `warehouse_id`='$stock_adj_wh', `batch_no`='$stock_adj_batch_no', 
                        `qty_in`='$stk_adj_qty_in', `qty_out`='$stk_adj_qty_out', `status`='updated', 
                        `altered_by`='$user_id', `altered_datetime`=NOW()
                        WHERE `stk_adj_item_id`='$stk_adj_item_list_id'";
                    }
                    else
                    {
                        $query_stk_adj_items = "INSERT INTO `stock_adjustment_items`
                        (`stock_adj_id`, `date`, `item_id`, `category_id`, `warehouse_id`, `batch_no`, `qty_in`, `qty_out`, 
                        `status`) VALUES ('$stock_adj_id','$stk_adj_date','$stk_adj_item_id','$item_cat_id',
                        '$stock_adj_wh','$stock_adj_batch_no','$stk_adj_qty_in','$stk_adj_qty_out','updated', 
                        `altered_by`='$user_id', `altered_datetime`=NOW())";
                    };
                    $query_run_stk_adj_items = mysqli_query($con, $query_stk_adj_items);
                };
            };

            $query = "DELETE FROM `stock_adjustment_items` WHERE `status`='' AND `stock_adj_id`='$stock_adj_id'";
            $result = mysqli_query($con,$query);

            echo "Stock Adjustment Items Updated";  
        }  
        else  
        {  
            echo "Stock Adjustment Items NOT Updated";  
        };
    };
}

function delete_stock_adjustment_voucher()
{
    global $con;
    $stock_adj_id = $_POST['stock_adj_id'];
    $query = "DELETE FROM `stock_adjustment` WHERE `stock_adj_id`='$stock_adj_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $query = "DELETE FROM `stock_adjustment_items` WHERE `stock_adj_id`='$stock_adj_id'";
        $result = mysqli_query($con,$query);
    }
}

?>
