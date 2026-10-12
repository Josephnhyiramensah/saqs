<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    if(isset($_SESSION['search_from'])){$search_from = $_SESSION['search_from'];}else{$search_from = '';};
    if(isset($_SESSION['search_to'])){$search_to = $_SESSION['search_to'];}else{$search_to = '';};
    if(isset($_SESSION['page'])){$page = $_SESSION['page'];}else{$page = '';};
    if(isset($_SESSION['remember_state'])){$remember_state = $_SESSION['remember_state'];}else{$remember_state = 'false';};
?>
  <style type="text/css">
    .scroll-card-body {
            max-height: 700px;
            overflow-y: auto;
          }
    .amt-td {
            text-align:right;
          }
    .action-td {
            text-align:center;
          }
</style>
<div class="container-fluid scroll-card-body">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Stock Take List
	            </h4>
                <div class="input-group">
                    <!--<a href="#" data-toggle="" id="new_stock_sales_icon">New Stock Take Voucher</a> | -->
                    <a href="/layout/vouchers/stock_take_invoice.php" data-toggle="" id="new_stock_take_invoice">New Stock Take Voucher</a>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <label>Name</label>
                        <input type="text" class="form-control border-0 small" name="stock_sales_name" id="stock_sales_name">
                    </div>
                    <div class="input-group">
                        <label>From</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_sales_search_from" id="stock_sales_search_from">
                    </div>
                    <div class="input-group">
                        <label>To</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_sales_search_to" id="stock_sales_search_to">
                    </div>
                    <div class="input-group">
                        <a href="#" data-toggle="" id="stock_sales_search_icon"><i class="fas fa-search"></i></a>
                    </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $query = "SELECT * FROM stock_sales WHERE company_id = '".$_SESSION['company_id']."' ORDER BY date DESC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="stock_sales_list_table">
                <table class="table table-hover table-bordered table-sm" id="stock_salesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td">Branch</th>
                            <th class = "action-td">Date</th>
                            <th class = "action-td">Voucher No</th>
                            <th class = "action-td">No of Items</th>
                            <th>Created by</th>
                            <th class = "action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    $ledger_cr = $row['ledger_credit'];
                                    $query_ledger = "SELECT * FROM ledgers WHERE ledger_id='$ledger_cr'";
                                    $query_ledger_run = mysqli_query($con, $query_ledger);
                                    $row_ledger = mysqli_fetch_assoc($query_ledger_run);

                                    $branch_id = $row['branch_id'];
                                    $query_branch = "SELECT * FROM branch WHERE branch_id='$branch_id'";
                                    $query_run_branch = mysqli_query($con, $query_branch);
                                    if(!empty($query_run_branch) && mysqli_num_rows($query_run_branch) > 0)
                                    {
                                        $row_branch = mysqli_fetch_assoc($query_run_branch);
                                        $branch_name = $row_branch['branch_name'];
                                    }
                                    else
                                    {
                                        $branch_name = 'Not Specified';
                                    };

                                    $cashier_id = $row['created_by'];
                                    $query_cashier = "SELECT * FROM users WHERE id='$user_id'";
                                    $query_run_cashier = mysqli_query($con, $query_cashier);
                                    if(!empty($query_run_cashier ) && mysqli_num_rows($query_run_cashier ) > 0)
                                    {
                                        $row_cashier = mysqli_fetch_assoc($query_run_cashier);
                                        $cashier = $row_cashier['first_name'].' '.$row_cashier['last_name'].':-'.$row['created_datetime'];
                                    }
                                    else
                                    {
                                        $cashier = 'Not Specified';
                                    };
                        ?>
                                    <tr>
                                        <td class = "action-td"><?php echo $branch_name;?></td>
                                        <td class = "action-td">
                                            <a href="#" id="btn_edit_stock_sales" data-id="<?php echo $row['stock_sales_id'];?>"><?php echo $row['stock_sales_id'];?></a>
                                        </td>
                                        <td class = "action-td"><?php echo $row['date'];?></td>
                                        <td class = "amt-td"><?php echo $row['amount'];?></td>
                                        <td><?php echo $cashier;?></td>
        	                            <td class = "action-td">
                                            <?php
                                              //if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Stock_Sales'] == 'Yes')) 
                                              //{
                                                echo '<a href="#" id="btn_edit_stock_sales" data-id="'.$row['stock_sales_id'].'">Edit</a> | ';
                                              //};
                                            ?>
                                              <a href="#" id="stock_sales_invoice_print_btn" data-id="<?php echo $row['stock_sales_id'];?>">Reprint</a>
                                            <?php
                                              //if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Stock_Sales'] == 'Yes'))
                                              //{
                                                echo ' | <a href="#" id="btn_return_stock_sales" data-id="'.$row['stock_sales_id'].'">Return</a>';
                                              //};
                                              //if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Stock_Sales'] == 'Yes'))
                                              //{
                                                echo ' | <a href="#" id="btn_delete_stock_sales" data-id="'.$row['stock_sales_id'].'">Delete</a>';
                                              //};
                                            ?>
        									<!--<a href="#" id="btn_delete_stock_sales" data-id2="<?php //echo $row['stock_sales_id'];?>"><i class="fa fa-trash fa-sm"></i></a>-->
        	                            </td>
                                    </tr>
                        <?php
                                }
                            }
                            else
                            {
                                    echo 'No Stock Sales Not Found';
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div 
    class="modal fade bd-example-modal-xl" 
    id="stock_sales_invoice_delete_modal" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="stock_sales_invoice_delete_modal" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stock_sales_invoice_delete_modal_title">Stock Sales Invoice Deletion</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <p id="stock_sales_invoice_delete_question"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="stock_sales_delete_yes" name="stock_sales_delete_yes" class="btn btn-danger">Yes</button>
                    <button type="button" id="stock_sales_delete_no" name="stock_sales_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include('stock_sales_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/sales_returns_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>