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
	                Stock Purchases List
	            </h4>
                <div class="input-group">
                    <a href="#" data-toggle="" id="new_stock_purchase_icon">New Stock Purchase Voucher</a> | 
                    <a href="#" data-toggle="" id="new_stock_purchase_download_csv">Download CSV file</a> | 
                    <a href="#" data-toggle="" id="new_stock_purchase_upload_csv">Upload Purchases</a>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <label>Name</label>
                        <input type="text" class="form-control border-0 small" name="stock_purchase_name" id="stock_purchase_name">
                    </div>
                    <div class="input-group">
                        <label>From</label>
                            <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_purchase_search_from" id="stock_purchase_search_from">
                    </div>
                    <div class="input-group">
                        <label>To</label>
                            <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_purchase_search_to" id="stock_purchase_search_to">
                    </div>
                    <div class="input-group">
                        <a href="#" data-toggle="" id="stock_purchase_search_icon"><i class="fas fa-search"></i></a>
                    </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $company_id = $_SESSION['company_id'];
                $query = "SELECT * FROM stock_purchases WHERE company_id = '$company_id' ORDER BY date DESC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="stock_purchases_list_table">
                <table class="table table-hover table-bordered table-sm" id="stock_purchasesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td">Purchase ID</th>
                            <th class = "action-td">Date</th>
                            <th>Supplied By</th>
                            <th class = "action-td">Amount</th>
                            <th class = "action-td">Invoice No</th>
                            <th>Credit Ledger</th>
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
                        ?>
                                    <tr>
                                        <td class = "action-td">
                                        <?php
                                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Stock_Purchase'] == 'Yes')) 
                                            {
                                                echo '<a href="#" id="btn_edit_stock_purchase" data-id="'.$row['stock_purchase_id'].'">'.$row['sno'].'</a>';
                                            }
                                        ?>
                                        </td>
                                        <td class = "action-td"><?php echo $row['date'];?></td>
                                        <td><?php echo $row['supplied_by'];?></td>
                                        <td class = "amt-td"><?php echo $row['amount'];?></td>
                                        <td class = "action-td"><?php echo $row['reference_no'];?></td>
                                        <td><?php echo $row_ledger['ledger_desc'];?></td>
        	                            <td class = "action-td">
                                        <?php
                                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Stock_Purchase'] == 'Yes')) 
						                    {
							                    echo '<a href="#" id="btn_delete_stock_purchase" data-id="'.$row['stock_purchase_id'].'">
                                                    <i class="fa fa-trash fa-sm"></i>
                                                </a>';
                                            };
                                        ?>
        	                            </td>
                                    </tr>
                        <?php
                                }
                            }
                            else
                            {
                                echo 'No Stock Purchases Not Found';
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
    id="stock_purchase_invoice_delete_modal" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="stock_purchase_invoice_delete_modal" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stock_purchase_invoice_delete_modal_title">Stock Purchase Invoice Deletion</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <p id="stock_purchase_invoice_delete_question"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="stock_purchase_delete_yes" name="stock_purchase_delete_yes" class="btn btn-danger">Yes</button>
                    <button type="button" id="stock_purchase_delete_no" name="stock_purchase_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('stock_purchases_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_purchase_import_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>