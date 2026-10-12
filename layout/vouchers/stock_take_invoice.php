<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    
    if(isset($_SESSION['warehouse_id'])){$warehouse_id = $_SESSION['warehouse_id'];};
    if(isset($_SESSION['cash_ledger_id'])){$cash_ledger_id = $_SESSION['cash_ledger_id'];};
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $sql_user = "SELECT * FROM users WHERE id = '$user_id'";
        $result_user = mysqli_query($con,$sql_user);
        $row_user = mysqli_fetch_array($result_user);
    };
    if(isset($_SESSION['branch_id'])){
        $branch_id = $_SESSION['branch_id'];
        $sql_branch = "SELECT * FROM branch WHERE branch_id = '$branch_id'";
        $result_branch = mysqli_query($con,$sql_branch);
        $row_branch = mysqli_fetch_array($result_branch);
    };
    
	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
	$time = date('H-i-sa');
 ?>
  <style type="text/css">
    .scroll-card {height: 800px;overflow-y: auto;}
    .scroll-card-items {height: 385px;overflow-y: auto;}
    .scroll-card-search-items {height: 480px;overflow-y: auto;}
    .scroll-card-div {height: 600px;overflow-y: auto;}
    .scroll-card-body {max-height: 700px;overflow-y: auto;}
    .amt-td {text-align:right;}
    .action-td {text-align:center;}
</style>
<div class="container-fluid scroll-card">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Stock Take
	            </h4>
                <div class="input-group">
                    <strong>Branch: <?php echo $row_branch['branch_name'];?></strong>
                </div>
            </div>
            <div class="float-right">
	        </div>
        </div>
        <div class="card-body">
            <form action="" method="POST" id="stock_take_invoice_form">
                <div class="form-row">
                    <div class="col-md-4 mb-4">
                        <label for="stock_take_store">Store</label>
                        <select class="form-control bg-light" name="stock_take_store" id="stock_take_store">
                            <option value="0">Select Store</option>';
                        <?php
                            $sql_warehouse = "SELECT * FROM warehouse ORDER BY warehouse_desc ASC";
                            $result_warehouse = mysqli_query($con,$sql_warehouse);
                            while($row_warehouse = mysqli_fetch_array($result_warehouse))
                            {
                                if($row_warehouse['warehouse_id']==$_SESSION['warehouse_id'])
                                {
                                    echo '<option value ="'.$row_warehouse['warehouse_id'].'" selected="selected">'.$row_warehouse['warehouse_desc'].'</option>';
                                }
                                else
                                {
                                    echo '<option value ="'.$row_warehouse['warehouse_id'].'">'.$row_warehouse['warehouse_desc'].'</option>';
                                };
                            };
                        ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="stock_take_date">Date</label>
                        <input type="date" class="form-control bg-light" name="stock_take_date" id="stock_take_date" value="<?php echo $date_today;?>">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="stock_take_creator">Creator</label>
                        <select class="form-control bg-light" name="stock_take_creator" id="stock_take_creator">
                            <option value="0">Select User</option>';
                            <?php
                                $company_id = $_SESSION['company_id'];
                                $sql_creator = "SELECT * FROM users WHERE `company_id`='$company_id' ORDER BY first_name ASC";
                                $result_creator = mysqli_query($con,$sql_creator);
                                while($row_creator = mysqli_fetch_array($result_creator))
                                {
                                    if($row_creator['id']==$_SESSION['user_id'])
                                    {
                                        echo '<option value ="'.$row_creator['id'].'" selected="selected">'.$row_creator['first_name'].' '.$row_creator['last_name'].'</option>';
                                    }
                                    else
                                    {
                                        echo '<option value ="'.$row_creator['id'].'">'.$row_creator['first_name'].' '.$row_creator['last_name'].'</option>';
                                    };
                                };
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-5 mb-5 scroll-card-div">
                        <div class="form-row">
                            <div class="col-md-8 mb-8">
                                <input type="text" class="form-control bg-light" name="stock_take_invoice_item_search" id="stock_take_invoice_item_search" placeholder="Search...">
                            </div>
                            <div class="col-md-4 mb-4">
                                <select class="form-control bg-light" name="stock_take_invoice_item_search_criteria" id="stock_take_invoice_item_search_criteria"> 
                                    <option value="ITEM_NAME">ITEM NAME</option>
                                    <option value="ITEM_NUMBER">ITEM NUMBER</option>
                                    <option value="BARCODE">BARCODE</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-12">
                                <div class="table-responsive scroll-card-search-items" id="stock_take_items_list_table_div">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 mb-7 scroll-card-div">
                        <div class="table-responsive scroll-card-items" id="stock_take_invoice_list_table">
                            <table class="table table-hover table-bordered table-sm" id="stock_take_invoiceTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr id="1">
                                        <th width="50%" class = "action-td">Item Description</th>
                                        <th width="10%" class = "action-td">Qty</th>
                                        <th width="10%" class = "action-td">Batch No</th>
                                        <th width="20%" class = "action-td">Expiry Date</th>
                                        <th width="10%" class = "action-td">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="pv-table-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-2 mb-2">
                        <a href="/layout/vouchers/stock_take_invoice.php" class="btn btn-primary btn-block" id="stock_take_invoice_new_tn">New Invoice</a>
                    </div>
                    <div class="col-md-2 mb-2">
                    <button type="submit" name="stock_take_invoice_hold_tn" id="stock_take_invoice_hold_tn" class="btn btn-primary btn-block">Hold</button>
                    </div>
                    <div class="col-md-2 mb-2">
                    <button type="submit" name="stock_take_invoice_void_tn" id="stock_take_invoice_void_tn" class="btn btn-primary btn-block">Void</button>
                    </div>
                    <div class="col-md-2 mb-2">
                    <button type="submit" name="stock_take_invoice_tender_tn" id="stock_take_invoice_tender_tn" class="btn btn-primary btn-block">Tender</button>
                    </div>
                    <div class="col-md-2 mb-2">
                    <button type="submit" name="stock_take_invoice_save_tn" id="stock_take_invoice_save_tn" class="btn btn-primary btn-block">Save Invoice</button>
                    </div>
                    <div class="col-md-2 mb-2">
                    <button type="submit" name="stock_take_invoice_cancel_tn" id="stock_take_invoice_cancel_tn" class="btn btn-danger btn-block">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
          <?php //include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
    </div>
</div>

<div 
    class="modal fade bd-example-modal-xl" 
    id="stock_take_invoice_delete_modal" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="stock_take_invoice_delete_modal" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stock_take_invoice_delete_modal_title">Stock Take Invoice Deletion</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <p id="stock_take_invoice_delete_question"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="stock_take_delete_yes" name="stock_take_delete_yes" class="btn btn-danger">Yes</button>
                    <button type="button" id="stock_take_delete_no" name="stock_take_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_take_invoice_batch_qty_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/customer_setup_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_search_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php //include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>