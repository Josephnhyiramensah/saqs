<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//STOCK_SALES
function stock_sales_item_list()
{
    global $con;
    $count = $_POST['i'];
    $value = "";
    $value = '<td>
                <input type="hidden" name="stock_sales_item_list_id[]" class="form-control bg-light" id="stock_sales_item_list_id'.$count.'">
                <input type="hidden" name="stock_sales_cat_id[]" class="form-control bg-light" id="stock_sales_cat_id'.$count.'">
                <select class="form-control stock_sales_desc" name="stock_sales_desc[]" id="stock_sales_desc'.$count.'"  data-id="'.$count.'"style="border-width:0px"> 
                    <option value="0">Please Select</option>';
                        $sql="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
                        UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable";
                        $result=mysqli_query($con,$sql);
                        while($row=mysqli_fetch_array($result))
                        {
                            $value .= '<option value ="'.$row['id'].'" data-value ="'.$row['category_id'].'">'.$row['item_desc'].'</option>';
                        };
     $value .= '</select>
            </td>
            <td>
                <select class="form-control stock_sales_loc_id" name="stock_sales_loc[]" id="stock_sales_loc'.$count.'" data-id="'.$count.'" style="border-width:0px"> 
                    <option value="0">Please Select</option>';
                        $sql_wh = "SELECT * FROM warehouse WHERE company_id = '".$_SESSION['company_id']."' ORDER BY warehouse_desc"; 
                        $result_wh = mysqli_query($con,$sql_wh);
                        while($row_wh = mysqli_fetch_array($result_wh))
                        {
                            $value .= '<option value ="'.$row_wh['warehouse_id'].'">'.$row_wh['warehouse_desc'].'</option>';
                        };
     $value .= '</select>
            </td>';
    
    echo $value;
}

function stock_sales_item_price()
{
    global $con;
    $stock_item_id = $_POST['stock_item_id'];
    $category_id = $_POST['category_id'];
    $data = array();
    $query="SELECT * FROM (SELECT drug_id AS id,category_id, price_cash FROM drugs 
            UNION ALL SELECT con_id AS id,category_id, price_cash FROM consumable) items
            WHERE id = '$stock_item_id' AND category_id = '$category_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($data, 
            $row['price_cash']
        );
    }
     echo json_encode($data);
}

function save_stock_sales_invoice()
{
    global $con;
    $sales_debit = $_POST['stock_sales_debit'];
    $sales_credit = $_POST['stock_sales_credit'];
    $sales_amount = $_POST['stock_sales_amount'];
    $sales_supplied_by = $_POST['stock_sales_supplied_by'];
    $sales_ref_no = $_POST['stock_sales_ref_no'];
    $sales_date = $_POST['stock_sales_date'];
    $sales_received_by = $_POST['stock_sales_received_by'];
    $sales_narration = $_POST['stock_sales_narration'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "SELECT sno FROM stock_sales WHERE company_id = 'company_id' ORDER BY sno DESC";
    $result = mysqli_query($con,$query);

    if(!empty($result) && mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);
        $sno = $row['sno'] + 1;
    }
    else
    {
        $sno = 1;
    };

    $query = "INSERT INTO `stock_sales`(
    `company_id`, `date`, `ledger_debit`, `ledger_credit`, `amount`, `reference_no`, 
    `supplied_by`, `received_by`, `narration`, `sno`, `branch_id`, `created_by`, `created_datetime`) 
    VALUES ('$company_id','$sales_date','$sales_debit','$sales_credit','$sales_amount',
    '$sales_ref_no','$sales_supplied_by','$sales_received_by','$sales_narration',
    '$sno','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);

    if ($query_run) 
    {
        //POST TRANSACTION
            $query = "SELECT * FROM stock_sales ORDER BY stock_sales_id DESC";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_assoc($result);
            $stock_sales_id = $row['stock_sales_id'];

            $query_dr = "INSERT INTO `transactions`(
            `company_id`,`stock_sales_id`,`ledger_id`, `ledger_id_contra`, `date`, `amt`, `amt_debit`, `narration`,
            `branch_id`, `created_by`, `created_datetime`) VALUES (
            '$company_id','$stock_sales_id','$sales_debit','$sales_credit','$sales_date','$sales_amount',
            '$sales_amount','$sales_narration','$branch_id','$user_id',NOW())";
            mysqli_query($con, $query_dr);

            $query_cr = "INSERT INTO `transactions`(
            `company_id`,`stock_sales_id`,`ledger_id`, `ledger_id_contra`, `date`, `amt`, `amt_credit`, `narration`,
            `branch_id`, `created_by`, `created_datetime`) VALUES (
            '$company_id','$stock_sales_id','$sales_credit','$sales_debit','$sales_date','$sales_amount',
            '$sales_amount','$sales_narration','$branch_id','$user_id',NOW())";
            mysqli_query($con, $query_cr);

            $number_as = count($_POST["stock_sales_desc"]);  
            if($number_as > 0)  
            {  
                for($i=0; $i<$number_as; $i++)  
                {  
                    if(trim($_POST["stock_sales_desc"][$i] !== '') && trim($_POST["stock_sales_desc"][$i] !== 0))  
                    {  
                        $stock_sales_desc = $_POST['stock_sales_desc'][$i];
                        $stock_sales_cat_id = $_POST['stock_sales_cat_id'][$i];
                        $stock_sales_loc = $_POST['stock_sales_loc'][$i];
                        $stock_sales_qty = $_POST['stock_sales_qty'][$i];
                        $stock_sales_price = $_POST['stock_sales_price'][$i];
                        $stock_sales_amt = $_POST['stock_sales_amt'][$i];
                        $stock_sales_batch = $_POST['stock_sales_batch'][$i];
                        $stock_sales_expiry_date = $_POST['stock_sales_expiry_date'][$i];
                        $query = "INSERT INTO `stock_sales_items`
                        (`company_id`, `stock_sales_id`, `stock_item_id`, `warehouse_id`, `date`, `price`, `amount`, `batch`, `expiry_date`, `qty`, `category_id`, `branch_id`) VALUES 
                        ('$company_id','$stock_sales_id','$stock_sales_desc','$stock_sales_loc','$sales_date','$stock_sales_price','$stock_sales_amt','$stock_sales_batch',
                        '$stock_sales_expiry_date','$stock_sales_qty','$stock_sales_cat_id','$branch_id')";
                        $query_run = mysqli_query($con, $query);
                    }  
                }
                echo "Stock Sales Items Inserted";  
            }  
            else  
            {  
                echo "Stock Sales Items NOT Inserted";  
            }
    }
}

function edit_stock_sales_invoice()
{
    global $con;
    $stock_sales_id = $_POST['stock_sales_id'];
    $data=array();
    $query = "SELECT * FROM stock_sales WHERE stock_sales_id='$stock_sales_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($data, 
            $row['stock_sales_id'],$row['date'],$row['ledger_debit'],$row['ledger_credit'],$row['amount'],$row['reference_no'],
            $row['supplied_by'],$row['received_by'],$row['narration']
        );
    }
     echo json_encode($data);
}

function edit_stock_sales_item_list()
{
    global $con;
    $stock_sales_id = $_POST['stock_sales_id'];
    $value = "";
    $value = '<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="stock_sales_items_table">
                <tr>
                    <th width="45%">Description</th>
                    <th width="10%">Warehouse</th>
                    <th width="10%">Qty</th>
                    <th width="10%">Price</th>
                    <th width="10%">Amount</th>
                    <th width="10%">Batch/Lot No</th>
                    <th width="10%">Expiry Date</th>
                    <th width="5%">Action</th>
                </tr>';
    $query = "SELECT * FROM stock_sales_items WHERE stock_sales_id='$stock_sales_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        $i=0;
        while($row=mysqli_fetch_assoc($query_run))
        {
            $i=++$i;
            $value.='<tr id="'.$i.'">
                        <td>
                            <input type="hidden" name="stock_sales_item_list_id[]" class="form-control bg-light" id="stock_sales_item_list_id'.$i.'" value="'.$row['sales_item_id'].'">
                            <input type="hidden" name="stock_sales_cat_id[]" class="form-control bg-light" id="stock_sales_cat_id'.$i.'"value="'.$row['category_id'].'">
                            <select class="form-control stock_sales_desc" name="stock_sales_desc[]" id="stock_sales_desc'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';

                                    $query_pi="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
                                    UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable";
                                    $query_run_pi = mysqli_query($con,$query_pi);
                                    while($row_pi = mysqli_fetch_array($query_run_pi))
                                    {
                                        if($row['stock_item_id'] == $row_pi['id'] && $row['category_id'] == $row_pi['category_id'])
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
                            <select class="form-control stock_sales_loc_id" name="stock_sales_loc[]" id="stock_sales_loc'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
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
                            <input type="text" name="stock_sales_qty[]" class="form-control bg-light stock_sales_qty" id="stock_sales_qty'.$i.'" data-id="'.$i.'" value="'.$row['qty'].'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="stock_sales_price[]" class="form-control bg-light stock_sales_price" id="stock_sales_price'.$i.'" data-id="'.$i.'"  value="'.$row['price'].'"style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="stock_sales_amt[]" class="form-control bg-light" id="stock_sales_amt'.$i.'" value="'.$row['amount'].'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="stock_sales_batch[]" class="form-control bg-light" id="stock_sales_batch'.$i.'" value="'.$row['batch'].'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="date" name="stock_sales_expiry_date[]" class="form-control bg-light" id="stock_sales_expiry_date'.$i.'" value="'.$row['expiry_date'].'" style="border-width:0px">
                        </td>
                        <td>
                            <a href="#" id="delete_stock_sales_item" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                        </td>
                    </tr>';
        };
        $i=++$i;
        $value.='<tr id="'.$i.'">
                        <td>
                            <input type="hidden" name="stock_sales_item_list_id[]" class="form-control bg-light" id="stock_sales_item_list_id'.$i.'">
                            <input type="hidden" name="stock_sales_cat_id[]" class="form-control bg-light" id="stock_sales_cat_id'.$i.'">
                            <select class="form-control stock_sales_desc" name="stock_sales_desc[]" id="stock_sales_desc'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
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
                            <select class="form-control stock_sales_loc_id" name="stock_sales_loc[]" id="stock_sales_loc'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                
                                    $sql_wh="SELECT * FROM warehouse WHERE company_id = '".$_SESSION['company_id']."' ORDER BY warehouse_desc"; 
                                    $result_wh = mysqli_query($con,$sql_wh);
                                    while($row_wh = mysqli_fetch_array($result_wh))
                                    {
                                        $value.='<option value ="'.$row_wh['warehouse_id'].'">'.$row_wh['warehouse_desc'].'</option>';
                                    };
                                
                   $value.='</select>
                        </td>
                        <td>
                            <input type="text" name="stock_sales_qty[]" class="form-control bg-light stock_sales_qty" id="stock_sales_qty'.$i.'" data-id="'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="stock_sales_price[]" class="form-control bg-light stock_sales_price" id="stock_sales_price'.$i.'" data-id="'.$i.'"  style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="stock_sales_amt[]" class="form-control bg-light" id="stock_sales_amt'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="stock_sales_batch[]" class="form-control bg-light" id="stock_sales_batch'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="date" name="stock_sales_expiry_date[]" class="form-control bg-light" id="stock_sales_expiry_date'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <a href="#" id="delete_stock_sales_item" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>';
    }
    echo $value;
}

function update_stock_sales_invoice()
{
    global $con;
    $stock_sales_id = $_POST['stock_sales_id'];
    $sales_debit = $_POST['stock_sales_debit'];
    $sales_credit = $_POST['stock_sales_credit'];
    $sales_amount = $_POST['stock_sales_amount'];
    $sales_supplied_by = $_POST['stock_sales_supplied_by'];
    $sales_ref_no = $_POST['stock_sales_ref_no'];
    $sales_date = $_POST['stock_sales_date'];
    $sales_received_by = $_POST['stock_sales_received_by'];
    $sales_narration = $_POST['stock_sales_narration'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `stock_sales` SET `date`='$sales_date',`ledger_debit`='$sales_debit',
    `amount`='$sales_amount',`reference_no`='$sales_ref_no',`supplied_by`='$sales_supplied_by',
    `received_by`='$sales_received_by',`narration`='$sales_narration',`altered_by`='$user_id',
    `altered_datetime`=NOW()
    WHERE `stock_sales_id`='$stock_sales_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) 
    {
        //POST TRANSACTION
        $query_trans_del = "DELETE FROM `transactions` WHERE `stock_sales_id`='$stock_sales_id'";
        mysqli_query($con, $query_trans_del);

        $query_dr = "INSERT INTO `transactions`(
        `company_id`,`stock_sales_id`,`ledger_id`, `ledger_id_contra`, `date`, `amt`, `amt_debit`, 
        `narration`,`branch_id`, `created_by`, `created_datetime`) VALUES (
        '$company_id','$stock_sales_id','$sales_debit','$sales_credit','$sales_date','$sales_amount',
        '$sales_amount','$sales_narration','$branch_id','$user_id',NOW())";
        mysqli_query($con, $query_dr);

        $query_cr = "INSERT INTO `transactions`(
        `company_id`,`stock_sales_id`,`ledger_id`, `ledger_id_contra`, `date`, `amt`, `amt_credit`, 
        `narration`,`branch_id`, `created_by`, `created_datetime`) VALUES (
        '$company_id','$stock_sales_id','$sales_credit','$sales_debit','$sales_date','$sales_amount',
        '$sales_amount','$sales_narration','$branch_id','$user_id',NOW())";
        mysqli_query($con, $query_cr);


        $query = "DELETE FROM `stock_sales_items` WHERE `stock_sales_id`='$stock_sales_id'";
        $result = mysqli_query($con,$query);

        $number_as = count($_POST["stock_sales_desc"]);  
        if($number_as > 0)  
        {  
          for($i=0; $i<$number_as; $i++)  
          {  
               if(trim($_POST["stock_sales_desc"][$i] !== '') && trim($_POST["stock_sales_desc"][$i] !== 0))  
               {  
                    $stock_sales_desc = $_POST['stock_sales_desc'][$i];
                    $stock_sales_cat_id = $_POST['stock_sales_cat_id'][$i];
                    $stock_sales_loc = $_POST['stock_sales_loc'][$i];
                    $stock_sales_qty = $_POST['stock_sales_qty'][$i];
                    $stock_sales_price = $_POST['stock_sales_price'][$i];
                    $stock_sales_amt = $_POST['stock_sales_amt'][$i];
                    $stock_sales_batch = $_POST['stock_sales_batch'][$i];
                    $stock_sales_expiry_date = $_POST['stock_sales_expiry_date'][$i];
                    $query = "INSERT INTO `stock_sales_items`
                    (`company_id`, `stock_sales_id`, `stock_item_id`, `warehouse_id`, `date`, `price`, `amount`, `batch`, 
                    `expiry_date`, `qty`, `category_id`, `branch_id`) VALUES 
                    ('$company_id','$stock_sales_id','$stock_sales_desc','$stock_sales_loc','$sales_date',
                    '$stock_sales_price','$stock_sales_amt','$stock_sales_batch','$stock_sales_expiry_date',
                    '$stock_sales_qty','$stock_sales_cat_id','$branch_id')";
                    mysqli_query($con, $query);
               };
          };
          echo "Stock Sales Items Updated";  
        }  
        else  
        {  
          echo "Stock Sales Items NOT Updated";  
        };
    };
}

?>
