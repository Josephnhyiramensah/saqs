<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//STOCK TRANSFER
function check_stock_requisition_transfer()
{
    global $con;
    $stock_req_id = $_POST['stock_req_id'];
    $query = "SELECT * FROM stock_transfer WHERE stock_req_id='$stock_req_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        $state = "transferred";
    }
    else
    {
        $state = "none";
    };

    echo $state;
}

function stock_transfer_items_requested()
{
    global $con;
    $stock_req_id = $_POST['stock_req_id'];
    $value = "";
    $value = '<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="stock_transfer_items_table">
                    <tr>
                        <th width="50%">Description</th>
                        <th width="15%">Qty Requested</th>
                        <th width="15%">Qty Transferred</th>
                        <th width="20%">Batch No</th>
                    </tr>';
                        //<th width="10%">Action</th>
                    
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
                            <input type="hidden" name="stk_trans_item_list_id[]" class="form-control bg-light" id="stk_trans_item_list_id'.$i.'" value="'.$row['stk_req_item_id'].'">
                            <input type="hidden" name="item_cat_id[]" class="form-control bg-light" id="item_cat_id'.$i.'" value="'.$row['category_id'].'">
                            <input type="hidden" name="wh_from_id[]" class="form-control bg-light" id="wh_from_id'.$i.'" value="'.$row['warehouse_to'].'">
                            <input type="hidden" name="wh_to_id[]" class="form-control bg-light" id="wh_to_id'.$i.'" value="'.$row['warehouse_from'].'">
                            <select class="form-control stk_trans_item_id bg-light" name="stk_trans_item_id[]" id="stk_trans_item_id'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                
                                    $sql="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
                                    UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable";
                                    $result=mysqli_query($con,$sql);
                                    while($row_item=mysqli_fetch_array($result))
                                    {
                                        if($row_item['id'] == $row['item_id'] && $row_item['category_id'] == $row['category_id'])
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
                            <input type="text" name="stk_trans_qty_req[]" class="form-control bg-light stk_trans_qty_req" id="stk_trans_qty_req'.$i.'" data-id="'.$i.'" value="'.$row['qty'].'" style="border-width:0px" hidden="true">
                            <input type="text" name="stk_trans_qty_reqt[]" class="form-control bg-light stk_trans_qty_reqt" id="stk_trans_qty_reqt'.$i.'" data-id="'.$i.'" value="'.$row['qty'].'" style="border-width:0px" disabled="true">
                        </td>
                        <td class = "action-td">
                            <input type="text" name="stk_trans_qty[]" class="form-control bg-light stk_trans_qty" id="stk_trans_qty'.$i.'" data-id="'.$i.'"  style="border-width:0px">
                        </td>
                        <td class = "action-td">
                            <input type="text" name="stock_trans_batch_no[]" class="form-control bg-light stock_trans_batch_no" id="stock_trans_batch_no'.$i.'" data-id="'.$i.'" style="border-width:0px">
                        </td>
                    </tr>';
                    
        };
                $value.='</tbody>
            </table>';
    }
    echo $value;
}

function save_stock_transfer_voucher()
{
    global $con;
    $stock_req_id = $_POST['stock_req_id_trans'];
    $stock_req_date = $_POST['stock_req_date'];
    $stock_trans_from = $_POST['stock_trans_from'];
    $stock_trans_to = $_POST['stock_trans_to'];
    $stk_trans_date = $_POST['stk_trans_date'];
    $stk_trans_transferred_by = $_POST['stk_trans_transferred_by'];
    $stk_trans_requested_by = $_POST['stk_trans_requested_by'];
    $stk_trans_collected_by = $_POST['stk_trans_collected_by'];
    $stk_trans_approved_by = $_POST['stk_trans_approved_by'];
    $stk_trans_narration = $_POST['stk_trans_narration'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `stock_requisition` SET 
        `status`='transferred' WHERE `stock_req_id`='$stock_req_id'";
    $query_run = mysqli_query($con, $query);

    $query = "INSERT INTO `stock_transfer`(
    `company_id`, `warehouse_from`, `warehouse_to`, `date`, `date_req`, `requested_by`, `collected_by`, 
    `transferred_by`, `stock_req_id`, `narration`, `approved_by`, `branch_id`, `created_by`, `created_datetime`) 
    VALUES ('$company_id','$stock_trans_from','$stock_trans_to','$stk_trans_date','$stock_req_date',
    '$stk_trans_requested_by','$stk_trans_collected_by','$stk_trans_transferred_by','$stock_req_id',
    '$stk_trans_narration','$stk_trans_approved_by','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run) 
    {
        $query = "SELECT * FROM stock_transfer ORDER BY stock_trans_id  DESC";
        $result = mysqli_query($con,$query);
        $row = mysqli_fetch_assoc($result);
        $stock_trans_id  = $row['stock_trans_id'];

        $number_as = count($_POST["stk_trans_item_id"]); 
        if($number_as > 0)  
        {  
            for($i=0; $i<$number_as; $i++)  
            {  
                if(trim($_POST["stk_trans_item_id"][$i] !== '') && trim($_POST["stk_trans_item_id"][$i] !== 0))  
                {  
                    $stk_trans_item_id = $_POST['stk_trans_item_id'][$i];
                    $stk_trans_item_list_id = $_POST['stk_trans_item_list_id'][$i];
                    $item_cat_id = 2;
                    $stk_trans_qty_req = $_POST['stk_trans_qty_req'][$i];
                    $stk_trans_qty = $_POST['stk_trans_qty'][$i];
                    $stock_trans_batch_no = $_POST['stock_trans_batch_no'][$i];
                    $query = "INSERT INTO `stock_transfer_items`
                    (`company_id`,`stock_trans_id`,`stock_req_id`, `date_trans`, `item_id`, `category_id`, 
                    `warehouse_id`, `qty_transferred`, `date_req`, `batch_no`, `qty_requested`, `branch_id`, `created_by`, `created_datetime`) 
                    VALUES ('$company_id','$stock_trans_id','$stock_req_id','$stk_trans_date',
                    '$stk_trans_item_id','$item_cat_id','$stock_trans_from','$stk_trans_qty','$stock_req_date',
                    '$stock_trans_batch_no','$stk_trans_qty_req','$branch_id','$user_id',NOW())";
                    $query_run = mysqli_query($con, $query);

                    $query = "INSERT INTO `stock_transfer_items`
                    (`company_id`,`stock_trans_id`,`stock_req_id`, `date_trans`, `item_id`, `category_id`, `warehouse_id`, 
                    `qty_received`, `date_req`, `batch_no`, `qty_requested`, `branch_id`, `created_by`, `created_datetime`) 
                    VALUES ('$company_id','$stock_trans_id','$stock_req_id','$stk_trans_date','$stk_trans_item_id',
                    '$item_cat_id','$stock_trans_to','$stk_trans_qty','$stock_req_date','$stock_trans_batch_no',
                    '$stk_trans_qty_req','$branch_id','$user_id',NOW())";
                    $query_run = mysqli_query($con, $query);
                };
            };
            echo "Stock Transfer Items Inserted";  
        }  
        else  
        {  
            echo "Stock Transfer Items NOT Inserted";  
        };
    };
}

function edit_stock_transfer_voucher()
{
    global $con;
    $stock_trans_id = $_POST['stock_trans_id'];
    $stock_trans_details = array();
    $query = "SELECT * FROM stock_transfer WHERE stock_trans_id='$stock_trans_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($stock_trans_details, 
            $row['stock_trans_id'],$row['stock_req_id'],$row['warehouse_from'],$row['warehouse_to'],$row['date'],$row['date_req'],$row['requested_by'],
            $row['approved_by'],$row['transferred_by'],$row['collected_by'],$row['narration']
        );
    }
     echo json_encode($stock_trans_details);
}

function edit_stock_transfer_item_list()
{
    global $con;
    $stock_trans_id = $_POST['stock_trans_id'];
    $query_st = "SELECT * FROM stock_transfer WHERE stock_trans_id='$stock_trans_id'";
    $query_run_st = mysqli_query($con, $query_st);
    $row_st=mysqli_fetch_assoc($query_run_st);

    $value = "";
    $value = '<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="stock_transfer_items_table">
                    <tr>
                        <th width="30%">Description</th>
                        <th width="10%">Qty Requested</th>
                        <th width="10%">Qty Transferred</th>
                        <th width="20%">Batch No</th>
                        <th width="10%">Action</th>
                    </tr>';
    $query = "SELECT * FROM stock_transfer_items WHERE stock_trans_id='$stock_trans_id' AND qty_received = 0";
    $query_run = mysqli_query($con, $query);
    $i=0;
    if (mysqli_num_rows($query_run) > 0)
    {
        while($row=mysqli_fetch_assoc($query_run))
        {
            $i=++$i;
            $value.='<tr id="'.$i.'">
                        <td>
                            <input type="hidden" name="stk_trans_item_list_id[]" class="form-control bg-light" id="stk_trans_item_list_id'.$i.'" value="'.$row['stock_req_id'].'">
                            <input type="hidden" name="item_cat_id[]" class="form-control bg-light" id="item_cat_id'.$i.'" value="'.$row['category_id'].'">
                            <input type="hidden" name="wh_from_id[]" class="form-control bg-light" id="wh_from_id'.$i.'" value="'.$row_st['warehouse_to'].'">
                            <input type="hidden" name="wh_to_id[]" class="form-control bg-light" id="wh_to_id'.$i.'" value="'.$row_st['warehouse_from'].'">
                            <select class="form-control stk_trans_item_id bg-light" name="stk_trans_item_id[]" id="stk_trans_item_id'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                
                                    $sql="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
                                    UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable";
                                    $result=mysqli_query($con,$sql);
                                    while($row_item=mysqli_fetch_array($result))
                                    {
                                        if($row_item['id'] == $row['item_id'] && $row_item['category_id'] == $row['category_id'])
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
                            <input type="text" name="stk_trans_qty_req[]" class="form-control bg-light stk_trans_qty_req" id="stk_trans_qty_req'.$i.'" data-id="'.$i.'" value="'.$row['qty_requested'].'" style="border-width:0px" disabled="true">
                        </td>
                        <td class = "action-td">
                            <input type="text" name="stk_trans_qty[]" class="form-control bg-light stk_trans_qty" id="stk_trans_qty'.$i.'" data-id="'.$i.'" value="'.$row['qty_transferred'].'" style="border-width:0px">
                        </td>
                        <td class = "action-td">
                            <input type="text" name="stock_trans_batch_no[]" class="form-control bg-light stock_trans_batch_no" id="stock_trans_batch_no'.$i.'" data-id="'.$i.'" value="'.$row['batch_no'].'" style="border-width:0px">
                        </td>
                        <td class = "action-td">
                            <a href="#" id="delete_stk_trans_item" data-id="1"><i class="fa fa-trash fa-sm"></i></a>
                        </td>
                    </tr>';
                    
        };
    }
    $i=++$i;
            $value.='<tr id="'.$i.'">
                        <td>
                            <input type="hidden" name="stk_trans_item_list_id[]" class="form-control bg-light" id="stk_trans_item_list_id'.$i.'" >
                            <input type="hidden" name="item_cat_id[]" class="form-control bg-light" id="item_cat_id'.$i.'">
                            <input type="hidden" name="wh_from_id[]" class="form-control bg-light" id="wh_from_id'.$i.'">
                            <input type="hidden" name="wh_to_id[]" class="form-control bg-light" id="wh_to_id'.$i.'">
                            <select class="form-control stk_trans_item_id bg-light" name="stk_trans_item_id[]" id="stk_trans_item_id'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
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
                            <input type="text" name="stk_trans_qty_req[]" class="form-control bg-light stk_trans_qty_req" id="stk_trans_qty_req'.$i.'" data-id="'.$i.'" style="border-width:0px" disabled="true">
                        </td>
                        <td class = "action-td">
                            <input type="text" name="stk_trans_qty[]" class="form-control bg-light stk_trans_qty" id="stk_trans_qty'.$i.'" data-id="'.$i.'"  style="border-width:0px">
                        </td>
                        <td class = "action-td">
                            <input type="text" name="stock_trans_batch_no[]" class="form-control bg-light stock_trans_batch_no" id="stock_trans_batch_no'.$i.'" data-id="'.$i.'" style="border-width:0px">
                        </td>
                        <td class = "action-td">
                            <a href="#" id="delete_stk_trans_item" data-id="1"><i class="fa fa-trash fa-sm"></i></a>
                        </td>
                    </tr>';
                $value.='</tbody>
            </table>';
    echo $value;
}

function update_stock_transfer_voucher()
{
    global $con;
    $stock_trans_id = $_POST['stock_trans_id'];
    $stock_req_id = $_POST['stock_req_id_trans'];
    $stock_req_date = $_POST['stock_req_date'];
    $stock_trans_from = $_POST['stock_trans_from'];
    $stock_trans_to = $_POST['stock_trans_to'];
    $stk_trans_date = $_POST['stk_trans_date'];
    $stk_trans_transferred_by = $_POST['stk_trans_transferred_by'];
    $stk_trans_requested_by = $_POST['stk_trans_requested_by'];
    $stk_trans_collected_by = $_POST['stk_trans_collected_by'];
    $stk_trans_approved_by = $_POST['stk_trans_approved_by'];
    $stk_trans_narration = $_POST['stk_trans_narration'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `stock_transfer` SET `warehouse_from`='$stock_trans_from', 
    `warehouse_to`='$stock_trans_to', `date`='$stk_trans_date', `date_req`='$stock_req_date', 
    `requested_by`='$stk_trans_requested_by', `collected_by`='$stk_trans_collected_by', 
    `transferred_by`='$stk_trans_transferred_by', `stock_req_id`='$stock_req_id', `narration`='$stk_trans_narration', 
    `approved_by`='$stk_trans_approved_by',`altered_by`='$user_id',`altered_datetime`=NOW() WHERE `stock_trans_id`='$stock_trans_id'";
    $query_run = mysqli_query($con, $query);

        if ($query_run) {
            $query_del = "DELETE FROM `stock_transfer_items` WHERE `stock_trans_id`='$stock_trans_id'";
            $result_del = mysqli_query($con,$query_del);

            $number_as = count($_POST["stk_trans_item_id"]); 
            if($number_as > 0)  
            {  
              for($i=0; $i<$number_as; $i++)  
              {  
                   if(trim($_POST["stk_trans_item_id"][$i] !== '') && trim($_POST["stk_trans_item_id"][$i] !== 0))  
                   {  
                        $stk_trans_item_id = $_POST['stk_trans_item_id'][$i];
                        $stk_trans_item_list_id = $_POST['stk_trans_item_list_id'][$i];
                        $item_cat_id = $_POST['item_cat_id'][$i];
                        $stk_trans_qty = $_POST['stk_trans_qty'][$i];
                        $stock_trans_batch_no = $_POST['stock_trans_batch_no'][$i];
                        $query = "INSERT INTO `stock_transfer_items`
                        (`stock_trans_id`,`stock_req_id`, `date_trans`, `item_id`, `category_id`, `warehouse_id`, 
                        `qty_transferred`, `date_req`, `batch_no`, `branch_id`, `created_by`, `created_datetime`) 
                        VALUES ('$stock_trans_id','$stock_req_id','$stk_trans_date','$stk_trans_item_id','$item_cat_id',
                        '$stock_trans_from','$stk_trans_qty','$stock_req_date',
                        '$stock_trans_batch_no','$branch_id','$user_id',NOW())";
                        $query_run = mysqli_query($con, $query);

                        $query = "INSERT INTO `stock_transfer_items`
                        (`stock_trans_id`,`stock_req_id`, `date_trans`, `item_id`, `category_id`, `warehouse_id`, 
                        `qty_received`, `date_req`, `batch_no`, `branch_id`, `created_by`, `created_datetime`) 
                        VALUES ('$stock_trans_id','$stock_req_id','$stk_trans_date','$stk_trans_item_id','$item_cat_id',
                        '$stock_trans_to','$stk_trans_qty','$stock_req_date',
                        '$stock_trans_batch_no','$branch_id','$user_id',NOW())";
                        $query_run = mysqli_query($con, $query);
                   };
              };
              echo "Stock Transfer Items Inserted";  
            }  
            else  
            {  
              echo "Stock Transfer Items NOT Inserted";  
            };
        }
}

function stock_transfer_item_initial()
{
    global $con;
    $i = $_POST['i'];
    $value = "";
    $value = '<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="stock_transfer_items_table">
                    <tr>
                        <th width="40%">Description</th>
                        <th width="10%">Qty Requested</th>
                        <th width="10%">Qty Transferred</th>
                        <th width="10%">Batch No</th>
                        <th width="10%">Action</th>
                    </tr>
                    <tr id="1">
                        <td>
                            <input type="hidden" name="stk_trans_item_list_id[]" class="form-control bg-light" id="stk_trans_item_list_id1">
                            <input type="hidden" name="item_cat_id[]" class="form-control bg-light" id="item_cat_id1">
                            <input type="hidden" name="wh_from_id[]" class="form-control bg-light" id="wh_from_id1">
                            <input type="hidden" name="wh_to_id[]" class="form-control bg-light" id="wh_to_id1">
                            <select class="form-control stk_trans_item_id bg-light" name="stk_trans_item_id[]" id="stk_trans_item_id1" data-id="1" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                
                                    $sql="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
                                    UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable";
                                    $result=mysqli_query($con,$sql);
                                    while($row=mysqli_fetch_array($result))
                                    {
                                        $value.='<option value ="'.$row['id'].'" data-value ="'.$row['category_id'].'">'.$row['item_desc'].'</option>';
                                    }
                               
                   $value.='</select>
                        </td>
                        <td class = "action-td">
                            <input type="text" name="stk_trans_qty_req[]" class="form-control bg-light stk_trans_qty_req" id="stk_trans_qty_req1" data-id="1" style="border-width:0px" hidden="true">
                            <input type="text" name="stk_trans_qty_reqt[]" class="form-control bg-light stk_trans_qty_reqt" id="stk_trans_qty_reqt" data-id="1" style="border-width:0px" disabled="true">
                        </td>
                        <td class = "action-td">
                            <input type="text" name="stk_trans_qty[]" class="form-control bg-light stk_trans_qty" id="stk_trans_qty1" data-id="1" style="border-width:0px">
                        </td>
                        <td class = "action-td">
                            <input type="text" name="stock_trans_batch_no[]" class="form-control bg-light stock_trans_batch_no" id="stock_trans_batch_no1" data-id="1" style="border-width:0px">
                        </td>
                        <td class = "action-td">
                            <a href="#" id="delete_stk_trans_item" data-id="1"><i class="fa fa-trash fa-sm"></i></a>
                        </td>
                    </tr>
                </table>';

    echo $value;
}

function stock_transfer_item_list()
{
    global $con;
    $i = $_POST['i'];
    $value = "";
    $value = '<tr id="'.$i.'">
                <td>
                    <input type="hidden" name="stk_trans_item_list_id[]" class="form-control bg-light" id="stk_trans_item_list_id'.$i.'">
                    <input type="hidden" name="item_cat_id[]" class="form-control bg-light" id="item_cat_id'.$i.'">
                    <input type="hidden" name="wh_from_id[]" class="form-control bg-light" id="wh_from_id'.$i.'">
                    <input type="hidden" name="wh_to_id[]" class="form-control bg-light" id="wh_to_id'.$i.'">
                    <select class="form-control stk_trans_item_id" name="stk_trans_item_id[]" id="stk_trans_item_id'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                        <option value="0">Please Select</option>';
                        
                            $sql="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
                            UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable";
                            $result = mysqli_query($con,$sql);
                            while($row = mysqli_fetch_array($result))
                            {
                                $value .= '<option value ="'.$row['id'].'" data-value ="'.$row['category_id'].'">'.$row['item_desc'].'</option>';
                            }
                        
         $value .= '</select>
                </td>
                <td class = "action-td">
                    <input type="text" name="stk_trans_qty_req[]" class="form-control bg-light stk_trans_qty_req" id="stk_trans_qty_req'.$i.'" data-id="'.$i.'" style="border-width:0px" hidden="true">
                    <input type="text" name="stk_trans_qty_reqt[]" class="form-control bg-light stk_trans_qty_reqt" id="stk_trans_qty_reqt'.$i.'" data-id="'.$i.'" style="border-width:0px" disabled="true">
                </td>
                <td class = "action-td">
                    <input type="text" name="stk_trans_qty[]" class="form-control bg-light stk_trans_qty" id="stk_trans_qty'.$i.'" data-id="'.$i.'" style="border-width:0px">
                </td>
                <td class = "action-td">
                    <select class="form-control bg-light" name="stock_trans_batch_no" id="stock_trans_batch_no'.$i.'"> 
                    </select>
                </td>
                <td class = "action-td">
                    <a href="#" id="delete_stk_trans_item" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                </td>
            </tr>';

    echo $value;
}


?>
