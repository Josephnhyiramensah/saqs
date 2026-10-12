<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//STOCK REQUISITION
function stock_requisition_item_list()
{
    global $con;
    $count = $_POST['i'];
    $value = "";
    $value = '<td>
                <input type="hidden" name="stk_req_item_list_id[]" class="form-control bg-light" id="stk_req_item_list_id'.$count.'">
                <input type="hidden" name="item_cat_id[]" class="form-control bg-light" id="item_cat_id'.$count.'">
                <select class="form-control stk_req_item_id" name="stk_req_item_id[]" id="stk_req_item_id'.$count.'"  data-id="'.$count.'"style="border-width:0px"> 
                    <option value="0">Please Select</option>';
                        $sql="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
                        UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable";
                        $result=mysqli_query($con,$sql);
                        while($row=mysqli_fetch_array($result))
                        {
                            $value .= '<option value ="'.$row['id'].'" data-value ="'.$row['category_id'].'">'.$row['item_desc'].'</option>';
                        }
     $value .= '</select>
            </td>
            <td class = "action-td">
                <input type="text" name="stk_req_qty[]" class="form-control bg-light stk_req_qty" id="stk_req_qty'.$count.'" data-id="'.$count.'" style="border-width:0px">
            </td>
            <td class = "action-td">
                <a href="#" id="delete_stk_req_item" data-id="'.$count.'"><i class="fa fa-trash fa-sm"></i></a>
            </td>';
    
    echo $value;
}

function save_stock_requisition_voucher()
{
    global $con;
    $stock_req_id = $_POST['stock_req_id'];
    $stock_req_from = $_POST['stock_req_from'];
    $stock_req_to = $_POST['stock_req_to'];
    $stk_req_date = $_POST['stk_req_date'];
    $stk_req_requested_by = $_POST['stk_req_requested_by'];
    $stk_req_narration = $_POST['stk_req_narration'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO `stock_requisition`(
    `company_id`,`warehouse_from`, `warehouse_to`, `date`, `requested_by`, `approved_by`, `narration`,
    `branch_id`, `created_by`, `created_datetime`) 
    VALUES ('$company_id','$stock_req_from','$stock_req_to','$stk_req_date','$stk_req_requested_by','',
    '$stk_req_narration','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run) 
    {
        $query = "SELECT * FROM stock_requisition ORDER BY stock_req_id  DESC";
        $result = mysqli_query($con,$query);
        $row = mysqli_fetch_assoc($result);
        $stock_req_id  = $row['stock_req_id'];

        $number_as = count($_POST["stk_req_item_id"]);  
            if($number_as > 0)  
            {  
                for($i=0; $i<$number_as; $i++)  
                {  
                    if(trim($_POST["stk_req_item_id"][$i] !== '') && trim($_POST["stk_req_item_id"][$i] !== 0))  
                    {  
                        $stk_req_item_id = $_POST['stk_req_item_id'][$i];
                        $stk_req_item_list_id = $_POST['stk_req_item_list_id'][$i];
                        $item_cat_id = $_POST['item_cat_id'][$i];
                        $stk_req_qty = $_POST['stk_req_qty'][$i];
                        $query = "INSERT INTO `stock_requisition_items`
                        (`company_id`, `stock_req_id`, `date`, `item_id`, `category_id`, `warehouse_from`, `warehouse_to`, 
                        `qty`,`branch_id`) VALUES 
                        ('$company_id','$stock_req_id','$stk_req_date','$stk_req_item_id','$item_cat_id','$stock_req_from',
                        '$stock_req_to','$stk_req_qty','$branch_id')";
                        $query_run = mysqli_query($con, $query);
                    };
                };
                echo "Stock Requisition Items Inserted";  
            }  
            else  
            {  
                echo "Stock Requisition Items NOT Inserted";  
            };
    };
}

function edit_stock_requisition_voucher()
{
    global $con;
    $stock_req_id = $_POST['stock_req_id'];
    $stock_req_details=array();
    $query = "SELECT * FROM stock_requisition WHERE stock_req_id='$stock_req_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($stock_req_details, 
            $row['stock_req_id'],$row['warehouse_from'],$row['warehouse_to'],$row['date'],$row['requested_by'],$row['approved_by'],
            $row['narration']
        );
    }
     echo json_encode($stock_req_details);
}

function edit_stock_requisition_item_list()
{
    global $con;
    $stock_req_id = $_POST['stock_req_id'];
    $value = "";
    $value = '<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="stock_requisition_items_table">
                    <tr>
                        <th width="70%">Description</th>
                        <th width="20%">Qty</th>
                        <th width="10%">Action</th>
                    </tr>';
    $query = "SELECT * FROM stock_requisition_items WHERE stock_req_id='$stock_req_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        $i=0;
        while($row=mysqli_fetch_assoc($query_run))
        {
            $i=++$i;
            $value.='<tr id="'.$i.'">
                        <td>
                            <input type="hidden" name="stk_req_item_list_id[]" class="form-control bg-light" id="stk_req_item_list_id'.$i.'" value="'.$row['stk_req_item_id'].'">
                            <input type="hidden" name="item_cat_id[]" class="form-control bg-light" id="item_cat_id'.$i.'" value="'.$row['category_id'].'">
                            <select class="form-control stk_req_item_id" name="stk_req_item_id[]" id="stk_req_item_id'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                
                                    $sql="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
                                    UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable";
                                    $result=mysqli_query($con,$sql);
                                    while($row_item=mysqli_fetch_array($result))
                                    {
                                        if($row['item_id'] == $row_item['id'] && $row['category_id'] == $row_item['category_id'])
                                        {
                                            $value.='<option value ="'.$row_item['id'].'" data-value ="'.$row_item['category_id'].'" selected="selected">'.$row_item['item_desc'].'</option>';
                                        }
                                        else
                                        {
                                            $value.='<option value ="'.$row_item['id'].'" data-value ="'.$row_item['category_id'].'">'.$row_item['item_desc'].'</option>';
                                        };
                                    }
                                
                   $value.='</select>
                        </td>
                        <td class = "action-td">
                            <input type="text" name="stk_req_qty[]" class="form-control bg-light stk_req_qty" id="stk_req_qty'.$i.'" data-id="'.$i.'" style="border-width:0px" value="'.$row['qty'].'">
                        </td>
                        <td class = "action-td">
                            <a href="#" id="delete_stk_req_item" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                        </td>
                    </tr>';
        };
        $i=++$i;
            $value.='<tr id="'.$i.'">
                        <td>
                            <input type="hidden" name="stk_req_item_list_id[]" class="form-control bg-light" id="stk_req_item_list_id'.$i.'">
                            <input type="hidden" name="item_cat_id[]" class="form-control bg-light" id="item_cat_id'.$i.'">
                            <select class="form-control stk_req_item_id" name="stk_req_item_id[]" id="stk_req_item_id'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                
                                    $sql="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
                                    UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable";
                                    $result=mysqli_query($con,$sql);
                                    while($row_item=mysqli_fetch_array($result))
                                    {
                                        $value.='<option value ="'.$row_item['id'].'" data-value ="'.$row_item['category_id'].'">'.$row_item['item_desc'].'</option>';
                                    }
                   $value.='</select>
                        </td>
                        <td class = "action-td">
                            <input type="text" name="stk_req_qty[]" class="form-control bg-light stk_req_qty" id="stk_req_qty'.$i.'" data-id="'.$i.'" style="border-width:0px">
                        </td>
                        <td class = "action-td">
                            <a href="#" id="delete_stk_req_item" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>';
    }
    echo $value;
}

function update_stock_requisition_voucher()
{
    global $con;
    $stock_req_id = $_POST['stock_req_id'];
    $stock_req_from = $_POST['stock_req_from'];
    $stock_req_to = $_POST['stock_req_to'];
    $stk_req_date = $_POST['stk_req_date'];
    $stk_req_requested_by = $_POST['stk_req_requested_by'];
    $stk_req_narration = $_POST['stk_req_narration'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `stock_requisition` SET 
        `warehouse_from`='$stock_req_from', `warehouse_to`='$stock_req_to', `date`='$stk_req_date', `requested_by`='$stk_req_requested_by', 
        `approved_by`='', `narration`='$stk_req_narration',`altered_by`='$user_id', `altered_datetime`=NOW() 
        WHERE `stock_req_id`='$stock_req_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) 
    {
        $query = "UPDATE `stock_requisition_items` SET `status`='' WHERE `stock_req_id`='$stock_req_id'";
        $result = mysqli_query($con,$query);

        $number_as = count($_POST["stk_req_item_id"]);  
        if($number_as > 0)  
        {  
            for($i=0; $i<$number_as; $i++)  
            {  
                   if(trim($_POST["stk_req_item_id"][$i] !== '') && trim($_POST["stk_req_item_id"][$i] !== 0))  
                   {  
                    $stk_req_item_id = $_POST['stk_req_item_id'][$i];
                    $stk_req_item_list_id = $_POST['stk_req_item_list_id'][$i];
                    $item_cat_id = $_POST['item_cat_id'][$i];
                    $stk_req_qty = $_POST['stk_req_qty'][$i];

                    if($stk_req_item_list_id !=='' && $stk_req_item_list_id !== 0)
                    {
                        $query = "UPDATE `stock_requisition_items` SET 
                        `stock_req_id`='$stock_req_id', `date`='$stk_req_date', `item_id`='$stk_req_item_id', `category_id`='$item_cat_id', `warehouse_from`='$stock_req_from', `warehouse_to`='$stock_req_to', `qty`='$stk_req_qty',`status`='updated' WHERE 
                        `stk_req_item_id`='$stk_req_item_list_id'"; 
                    }
                    else
                    {
                        $query = "INSERT INTO `stock_requisition_items`
                        (`stock_req_id`, `date`, `item_id`, `category_id`, `warehouse_from`, `warehouse_to`, `qty`,`status`,
                        `branch_id`) VALUES 
                        ('$stock_req_id','$stk_req_date','$stk_req_item_id','$item_cat_id','$stock_req_from',
                        '$stock_req_to','$stk_req_qty','updated','$branch_id')";
                    };
                    
                    $query_run = mysqli_query($con, $query);
                   };
            };
        }
        
        $query = "DELETE FROM `stock_requisition_items` WHERE `status`='' AND `stock_req_id`='$stock_req_id'";
        $result = mysqli_query($con,$query);

        echo "Stock Requisition Items Updated";  
    }  
    else  
    {  
        echo "Stock Requisition Items NOT Updated";  
    };
}

?>
