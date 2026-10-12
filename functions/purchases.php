<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//PURCHASES
function purchase_item_list()
{
    global $con;
    $count = $_POST['i'];
    $value = "";
    $value = '<td>
                <input type="hidden" name="purch_item_list_id[]" class="form-control bg-light" id="purch_item_list_id'.$count.'">
                <input type="hidden" name="purch_cat_id[]" class="form-control bg-light" id="purch_cat_id'.$count.'">
                <select class="form-control purch_item_id" name="purch_desc[]" id="purch_desc'.$count.'"  data-id="'.$count.'"style="border-width:0px"> 
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
            <td>
                <select class="form-control purch_loc_id" name="purch_loc[]" id="purch_loc'.$count.'" data-id="'.$count.'" style="border-width:0px"> 
                    <option value="0">Please Select</option>';
                    
                        $sql_wh="SELECT * FROM warehouse WHERE company_id = '".$_SESSION['company_id']."' ORDER BY warehouse_desc"; 
                        $result_wh=mysqli_query($con,$sql_wh);
                        while($row_wh=mysqli_fetch_array($result_wh))
                        {
                            $value .= '<option value ="'.$row_wh['warehouse_id'].'">'.$row_wh['warehouse_desc'].'</option>';
                        }
     $value .= '</select>
            </td>';
    
    echo $value;
}

function purchase_item_price()
{
    global $con;
    $purch_item_id = $_POST['purch_item_id'];
    $category_id = $_POST['category_id'];
    
    $data=array();
    if($category_id == 2)
    {
        $query = "SELECT * FROM `drugs` WHERE drug_id='$purch_item_id'";
    }
    elseif($category_id == 7)
    {
        $query = "SELECT * FROM `consumable` WHERE con_id='$purch_item_id'";
    };
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_assoc($result))
    {
        array_push($data, 
            $row['price_cash']
        );
    }
     echo json_encode($data);
}

function save_purchase_invoice()
{
    global $con;
    $purch_debit = $_POST['purch_debit'];
    $purch_credit = $_POST['purch_credit'];
    $purch_amount = $_POST['purch_amount'];
    $purch_supplied_by = $_POST['purch_supplied_by'];
    $purch_ref_no = $_POST['purch_ref_no'];
    $purch_date = $_POST['purch_date'];
    $purch_received_by = $_POST['purch_received_by'];
    $purch_narration = $_POST['purch_narration'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $branch_id = $_SESSION['branch_id'];

    $query = "INSERT INTO `purchases`(
    `company_id`, `date`, `ledger_debit`, `ledger_credit`, `amount`, `reference_no`, 
    `supplied_by`, `received_by`, `narration`, `branch_id`, `created_by`, `created_datetime`) 
    VALUES ('$company_id','$purch_date','$purch_debit','$purch_credit','$purch_amount',
    '$purch_ref_no','$purch_supplied_by',
    '$purch_received_by','$purch_narration','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        //POST TRANSACTION
            $query = "SELECT * FROM purchases ORDER BY purchase_id DESC";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_assoc($result);
            $purchase_id = $row['purchase_id'];

            $query_dr = "INSERT INTO `transactions`(
            `company_id`,`purchase_id`,`ledger_id`, `ledger_id_contra`, `date`, `amt`, `amt_debit`, `narration`,
            `branch_id`, `created_by`, `created_datetime`) VALUES (
            '$company_id','$purchase_id','$purch_debit','$purch_credit','$purch_date','$purch_amount',
            '$purch_amount','$purch_narration','$branch_id','$user_id',NOW())";
            mysqli_query($con, $query_dr);

            $query_cr = "INSERT INTO `transactions`(
            `company_id`,`purchase_id`,`ledger_id`, `ledger_id_contra`, `date`, `amt`, `amt_credit`, `narration`, 
            `branch_id`, `created_by`, `created_datetime`) VALUES (
            '$company_id','$purchase_id','$purch_credit','$purch_debit','$purch_date','$purch_amount',
            '$purch_amount','$purch_narration','$branch_id','$user_id',NOW())";
            mysqli_query($con, $query_cr);

        $number_as = count($_POST["purch_desc"]);
            if($number_as > 0)  
            {  
                for($i=0; $i<$number_as; $i++)  
                {  
                    if(trim($_POST["purch_desc"][$i] !== '') && trim($_POST["purch_desc"][$i] !== 0))  
                    {  
                        $purch_desc = $_POST['purch_desc'][$i];
                        $purch_loc = $_POST['purch_loc'][$i];
                        $purch_qty = $_POST['purch_qty'][$i];
                        $purch_price = $_POST['purch_price'][$i];
                        $purch_amt = $_POST['purch_amt'][$i];
                        $purch_selling_price = $_POST['purch_selling_price'][$i];
                        $purch_batch = $_POST['purch_batch'][$i];
                        $purch_expiry_date = $_POST['purch_expiry_date'][$i];
                        $purch_cat_id = 2;
                        //$purch_cat_id = $_POST['purch_cat_id'][$i];
                        $query = "INSERT INTO `purchase_items`
                        (`company_id`, `purchase_id`, `item_id`, `category_id`, `warehouse_id`, `date`, `price`, `amount`, 
                        `batch`, `expiry_date`, `qty`, `branch_id`) VALUES 
                        ('$company_id','$purchase_id','$purch_desc','$purch_cat_id','$purch_loc','$purch_date',
                        '$purch_price','$purch_amt','$purch_batch','$purch_expiry_date','$purch_qty','$branch_id')";
                        $query_run = mysqli_query($con, $query);
                        
                        if($query_run)
                        {
                            if($purch_selling_price > 0)
                            {
                                if($purch_cat_id == 2)
                                {
                                    $query_drug = "UPDATE `drugs` SET `price_cash`='$purch_selling_price' WHERE `drug_id`='$purch_desc'";
                                    mysqli_query($con, $query_drug);
                                }
                                elseif($purch_cat_id == 7)
                                {
                                    $query_consum = "UPDATE `consumable` SET `price_cash`='$purch_selling_price' WHERE `con_id`='$purch_desc'";
                                    mysqli_query($con, $query_consum);
                                };
                            };
                        };
                    }
                }
                echo "Purchases Items Inserted";  
            }  
            else  
            {  
                echo "Purchases Items NOT Inserted";  
            }
    };
}

function edit_purchase_invoice()
{
    global $con;
    $purchase_id = $_POST['purchase_id'];
    $purchases_details=array();
    $query = "SELECT * FROM purchases WHERE purchase_id='$purchase_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($purchases_details, 
            $row['purchase_id'],$row['date'],$row['ledger_debit'],$row['ledger_credit'],$row['amount'],$row['reference_no'],
            $row['supplied_by'],$row['received_by'],$row['narration']
        );
    }
     echo json_encode($purchases_details);
}

function edit_purchase_item_list()
{
    global $con;
    $purchase_id = $_POST['purchase_id'];
    $value = "";
    $value = '<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="purchase_items_table">
                <tr>
                    <th width="35%">Description</th>
                    <th width="10%">Warehouse</th>
                    <th width="10%">Qty</th>
                    <th width="10%">Price</th>
                    <th width="10%">Amount</th>
                    <th width="10%">Selling Price</th>
                    <th width="10%">Batch/Lot No</th>
                    <th width="10%">Expiry Date</th>
                    <th width="5%">Action</th>
                </tr>';
    $query = "SELECT * FROM purchase_items WHERE purchase_id='$purchase_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        $i=0;
        while($row = mysqli_fetch_assoc($query_run))
        {
            $item_category_id = $row['category_id'];
            $item_id = $row['item_id'];
            if($item_category_id == 2)
            {
                $query_drug = "SELECT * FROM `drugs` WHERE drug_id='$item_id'";
                $query_run_drug = mysqli_query($con, $query_drug);
                $row_selling_price = mysqli_fetch_assoc($query_run_drug);
            }
            elseif($item_category_id == 7)
            {
                $query_consum = "SELECT * FROM `consumable` WHERE con_id='$item_id'";
                $query_run_consum = mysqli_query($con, $query_consum);
                $row_selling_price = mysqli_fetch_assoc($query_run_consum);
            };

            $i=++$i;
            $value.='<tr id="'.$i.'">
                        <td>
                            <input type="hidden" name="purch_item_list_id[]" class="form-control bg-light" id="purch_item_list_id'.$i.'" value="'.$row['purch_item_id'].'">
                            <input type="hidden" name="purch_cat_id[]" class="form-control bg-light" id="purch_cat_id'.$i.'" value="'.$row['category_id'].'">
                            <select class="form-control purch_item_id" name="purch_desc[]" id="purch_desc'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                    $query_pi="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
                                    UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable";
                                    $query_run_pi = mysqli_query($con,$query_pi);
                                    while($row_pi = mysqli_fetch_array($query_run_pi))
                                    {
                                        if($row['item_id'] == $row_pi['id'] && $row['category_id'] == $row_pi['category_id'])
                                        {
                                            $value.='<option value ="'.$row_pi['id'].'" data-value ="'.$row_pi['category_id'].'" selected="selected">'.$row_pi['item_desc'].'</option>';
                                        }
                                        else
                                        {
                                            $value.='<option value ="'.$row_pi['id'].'" data-value ="'.$row_pi['category_id'].'">'.$row_pi['item_desc'].'</option>';
                                        };
                                    }
                   $value.='</select>
                        </td>
                        <td>
                            <select class="form-control purch_loc_id" name="purch_loc[]" id="purch_loc'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                
                                    $sql_wh="SELECT * FROM warehouse WHERE company_id = '".$_SESSION['company_id']."' ORDER BY warehouse_desc"; 
                                    $result_wh = mysqli_query($con,$sql_wh);
                                    while($row_wh = mysqli_fetch_array($result_wh))
                                    {
                                        if($row['warehouse_id'] == $row_wh['warehouse_id'])
                                        {
                                            $value.='<option value ="'.$row_wh['warehouse_id'].'" selected="selected">'.$row_wh['warehouse_desc'].'</option>';
                                        }
                                        else
                                        {
                                            $value.='<option value ="'.$row_wh['warehouse_id'].'">'.$row_wh['warehouse_desc'].'</option>';
                                        };
                                    }
                   $value.='</select>
                        </td>
                        <td>
                            <input type="text" name="purch_qty[]" class="form-control bg-light purch_qty" id="purch_qty'.$i.'" data-id="'.$i.'" value="'.$row['qty'].'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="purch_price[]" class="form-control bg-light purch_price" id="purch_price'.$i.'" data-id="'.$i.'"  value="'.$row['price'].'"style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="purch_amt[]" class="form-control bg-light" id="purch_amt'.$i.'" value="'.$row['amount'].'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="purch_selling_price[]" class="form-control bg-light" id="purch_selling_price'.$i.'" value="'.$row_selling_price['price_cash'].'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="purch_batch[]" class="form-control bg-light" id="purch_batch'.$i.'" value="'.$row['batch'].'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="date" name="purch_expiry_date[]" class="form-control bg-light" id="purch_expiry_date'.$i.'" value="'.$row['expiry_date'].'" style="border-width:0px">
                        </td>
                        <td>
                            <a href="#" id="delete_purchase_item" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                        </td>
                    </tr>';
        };
        $i=++$i;
        $value.='<tr id="'.$i.'">
                        <td>
                            <input type="hidden" name="purch_item_list_id[]" class="form-control bg-light" id="purch_item_list_id'.$i.'">
                            <input type="hidden" name="purch_cat_id[]" class="form-control bg-light" id="purch_cat_id'.$i.'">
                            <select class="form-control purch_item_id" name="purch_desc[]" id="purch_desc'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                
                                    $query_pi="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
                                    UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable";
                                    $query_run_pi = mysqli_query($con,$query_pi);
                                    while($row_pi = mysqli_fetch_array($query_run_pi))
                                    {
                                        $value.='<option value ="'.$row_pi['id'].'" data-value ="'.$row_pi['category_id'].'">'.$row_pi['item_desc'].'</option>';
                                    }
                               
                   $value.='</select>
                        </td>
                        <td>
                            <select class="form-control purch_loc_id" name="purch_loc[]" id="purch_loc'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                
                                    $sql_wh="SELECT * FROM warehouse WHERE company_id = '".$_SESSION['company_id']."' ORDER BY warehouse_desc"; 
                                    $result_wh = mysqli_query($con,$sql_wh);
                                    while($row_wh = mysqli_fetch_array($result_wh))
                                    {
                                        $value.='<option value ="'.$row_wh['warehouse_id'].'">'.$row_wh['warehouse_desc'].'</option>';
                                    }
                                
                   $value.='</select>
                        </td>
                        <td>
                            <input type="text" name="purch_qty[]" class="form-control bg-light purch_qty" id="purch_qty'.$i.'" data-id="'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="purch_price[]" class="form-control bg-light purch_price" id="purch_price'.$i.'" data-id="'.$i.'"  style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="purch_amt[]" class="form-control bg-light" id="purch_amt'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="purch_selling_price[]" class="form-control bg-light" id="purch_selling_price'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="purch_batch[]" class="form-control bg-light" id="purch_batch'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="date" name="purch_expiry_date[]" class="form-control bg-light" id="purch_expiry_date'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <a href="#" id="delete_purchase_item" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>';
    }
    echo $value;
}

function update_purchase_invoice()
{
    global $con;
    $purchase_id = $_POST['purchase_id'];
    $purch_debit = $_POST['purch_debit'];
    $purch_credit = $_POST['purch_credit'];
    $purch_amount = $_POST['purch_amount'];
    $purch_supplied_by = $_POST['purch_supplied_by'];
    $purch_ref_no = $_POST['purch_ref_no'];
    $purch_date = $_POST['purch_date'];
    $purch_received_by = $_POST['purch_received_by'];
    $purch_narration = $_POST['purch_narration'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $branch_id = $_SESSION['branch_id'];

    $query = "UPDATE `purchases` SET `date`='$purch_date',`ledger_debit`='$purch_debit',
    `amount`='$purch_amount',`reference_no`='$purch_ref_no',`supplied_by`='$purch_supplied_by',
    `received_by`='$purch_received_by',`narration`='$purch_narration',
    `altered_by`='$user_id',`altered_datetime`=NOW() WHERE `purchase_id`='$purchase_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) 
    {
        //POST TRANSACTION
        $query_trans_del = "DELETE FROM `transactions` WHERE `purchase_id`='$purchase_id'";
        mysqli_query($con, $query_trans_del);

        $query_dr = "INSERT INTO `transactions`(
        `purchase_id`,`ledger_id`, `ledger_id_contra`, `date`, `amt`, `amt_debit`, `narration`,
        `branch_id`, `created_by`, `created_datetime`) VALUES (
        '$purchase_id','$purch_debit','$purch_credit','$purch_date','$purch_amount','$purch_amount',
        '$purch_narration','$branch_id','$user_id',NOW())";
        mysqli_query($con, $query_dr);

        $query_cr = "INSERT INTO `transactions`(
        `purchase_id`,`ledger_id`, `ledger_id_contra`, `date`, `amt`, `amt_credit`, `narration`,
        `branch_id`, `created_by`, `created_datetime`) VALUES (
        '$purchase_id','$purch_credit','$purch_debit','$purch_date','$purch_amount','$purch_amount',
        '$purch_narration','$branch_id','$user_id',NOW())";
        mysqli_query($con, $query_cr);

        $query_up = "UPDATE `purchase_items` SET `status`='' WHERE `purchase_id`='$purchase_id'";
        mysqli_query($con,$query_up);

        $number_pi = count($_POST["purch_desc"]);
        if($number_pi > 0)  
        {  
            for($i=0; $i<$number_pi; $i++)  
            {  
                  if(trim($_POST["purch_desc"][$i] !== '') && trim($_POST["purch_desc"][$i] !== 0))  
                   {  
                    $purch_item_list_id = $_POST['purch_item_list_id'][$i];
                    $purch_desc = $_POST['purch_desc'][$i];
                    $purch_loc = $_POST['purch_loc'][$i];
                    $purch_qty = $_POST['purch_qty'][$i];
                    $purch_price = $_POST['purch_price'][$i];
                    $purch_amt = $_POST['purch_amt'][$i];
                    $purch_selling_price = $_POST['purch_selling_price'][$i];
                    $purch_batch = $_POST['purch_batch'][$i];
                    $purch_expiry_date = $_POST['purch_expiry_date'][$i];
                    $purch_cat_id = $_POST['purch_cat_id'][$i];

                    if($purch_item_list_id !== "" && $purch_item_list_id !== 0)
                    {
                        $query_item_list = "UPDATE `purchase_items` SET `purchase_id`='$purchase_id', `item_id`='$purch_desc', `category_id`='$purch_cat_id', 
                        `warehouse_id`='$purch_loc', `date`='$purch_date', `price`='$purch_price', `amount`='$purch_amt', `batch`='$purch_batch', 
                        `expiry_date`='$purch_expiry_date', `qty`='$purch_qty',`status`='updated' WHERE `purch_item_id`='$purch_item_list_id'";
                    }
                    else
                    {
                        $query_item_list = "INSERT INTO `purchase_items`(`purchase_id`, `item_id`, `category_id`, `warehouse_id`, `date`, `price`, `amount`, `batch`,
                         `expiry_date`, `qty`,`status`,`branch_id`) VALUES ('$purchase_id','$purch_desc','$purch_cat_id','$purch_loc','$purch_date','$purch_price',
                         '$purch_amt','$purch_batch','$purch_expiry_date','$purch_qty','updated','$branch_id')";
                    };
                    $query_run_item_list = mysqli_query($con, $query_item_list);
                    if($query_run_item_list)
                    {
                        if($purch_selling_price > 0)
                        {
                            if($purch_cat_id == 2)
                            {
                                $query_drug = "UPDATE `drugs` SET `price_cash`='$purch_selling_price' WHERE `drug_id`='$purch_desc'";
                                $query_run_drug = mysqli_query($con, $query_drug);
                            }
                            elseif($purch_cat_id == 7)
                            {
                                $query_consum = "UPDATE `consumable` SET `price_cash`='$purch_selling_price' WHERE `con_id`='$purch_desc'";
                                $query_run_consum = mysqli_query($con, $query_consum);
                            };
                        };
                    };
                   };
            };

            $query_del = "DELETE FROM `purchase_items` WHERE `status`='' AND `purchase_id`='$purchase_id'";
            mysqli_query($con,$query_del);

            echo "Purchase Updated";
        }  
        else  
        {  
            echo "Purchase NOT Updated";  
        };
    };
}

function delete_purchase_invoice()
{
    global $con;
    $purchase_id = $_POST['purchase_id'];
    $query = "DELETE FROM `purchases` WHERE purchase_id='$purchase_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        $query_trans_del = "DELETE FROM `transactions` WHERE `purchase_id`='$purchase_id'";
        mysqli_query($con, $query_trans_del);
    }
    else
    {
        echo "Purchases NOT Deleted";
    };
}


?>
