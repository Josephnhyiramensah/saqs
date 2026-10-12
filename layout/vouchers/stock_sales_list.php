<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    if(isset($_SESSION['branch_id'])){$user_branch_id = $_SESSION['branch_id'];}else{$user_branch_id = '';};
    if(isset($_SESSION['company_id'])){$company_id = $_SESSION['company_id'];}else{$company_id = '';};
    if(isset($_SESSION['search_from'])){$search_from = $_SESSION['search_from'];}else{$search_from = '';};
    if(isset($_SESSION['search_to'])){$search_to = $_SESSION['search_to'];}else{$search_to = '';};
    if(isset($_SESSION['page'])){$page = $_SESSION['page'];}else{$page = '';};
    if(isset($_SESSION['remember_state'])){$remember_state = $_SESSION['remember_state'];}else{$remember_state = 'false';};
    
	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
	$time = date('H-i-sa');
?>
  <style type="text/css">
    .scroll-card-body {max-height: 700px;overflow-y: auto;}
    .scroll_search_div {max-height: 200px;overflow-y: auto;}
    .scroll_table_div {max-height: 500px;overflow-y: auto;}
    .amt-td {text-align:right;}
    .action-td {text-align:center;}
</style>
<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Stock Sales List
	            </h4>
                <div class="input-group">
                    <!--<a href="#" data-toggle="" id="new_stock_sales_icon">New Stock Sales Voucher</a> - | --->
                    <a href="#" data-toggle="" id="new_cash_sales_invoice">New Sales Invoice</a> - | - 
                    <a href="#" data-toggle="" id="new_corporate_sales_invoice">New Corporate Invoice</a> - | - 
                    <a href="#" data-toggle="" id="new_branch_sales_invoice">New Inter-Branch Invoice</a> - | - 
                    <a href="#" data-toggle="" id="btn_pending_prescription" data-id="<?php echo $_SESSION['company_id']?>">Prescriptions</a>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <?php
                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
                        {
                            echo '<div class="input-group" id="branch_filter">
                                <label>Branch</label>
                                <select class="form-control" class="form-control bg-light border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_branch" id="search_branch"> 
                                    <option value="0">ALL</option>';
                                    
                                        $sql_branch="SELECT * FROM branch ORDER BY branch_name ASC";
                                        $result_branch_list = mysqli_query($con,$sql_branch);
                                        while($row_branch_list=mysqli_fetch_array($result_branch_list))
                                        {
                                            echo '<option value = "'.$row_branch_list['branch_id'].'">
                                                '.$row_branch_list['branch_name'].'
                                            </option>';
                                        };
                                
                                echo '</select>
                            </div>';
                        };
                    ?>
                    <div class="input-group">
                        <label>Name</label>
                        <input type="text" class="form-control border-0 small" name="stock_sales_name" id="stock_sales_name">
                    </div>
                    <div class="input-group">
                        <label>From</label>
                        <?php
                            if($remember_state == true)
                            {
                        ?>
                                <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_sales_search_from" id="stock_sales_search_from" value="<?php echo $search_from;?>">
                        <?php
                            }
                            else
                            {
                        ?>
                                <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_sales_search_from" id="stock_sales_search_from">
                        <?php
                            };
                        ?>
                    </div>
                    <div class="input-group">
                        <label>To</label>
                            <?php
                                if($remember_state == true)
                                {
                            ?>
                                    <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_sales_search_to" id="stock_sales_search_to" value="<?php echo $search_to;?>">
                            <?php
                                }
                                else
                                {
                            ?>
                                    <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_sales_search_to" id="stock_sales_search_to">

                            <?php
                                };
                            ?>
                    </div>
                    <div class="input-group">
                        <div class="form-check">
                            <?php
                                if($remember_state == true)
                                {
                            ?>
                                    <input class="form-check-input" type="checkbox" value="" id="remember_state" checked>
                            <?php
                                }
                                else
                                {
                            ?>
                                    <input class="form-check-input" type="checkbox" value="" id="remember_state">
                            <?php
                                };
                            ?>
                        </div>
                    </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
                {
                    $query = "SELECT * FROM stock_sales WHERE company_id = '".$_SESSION['company_id']."' ORDER BY date ASC";
                }
                else
                {
                    $query = "SELECT * FROM stock_sales WHERE branch_id = '$user_branch_id' ORDER BY date ASC";
                };
                $query_run = mysqli_query($con, $query);
            
            echo '<div class="table-responsive" id="stock_sales_list_table">
                <table class="table table-hover table-bordered table-sm" id="stock_salesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td">Sales ID</th>
                            <th class = "action-td">Date</th>
                            <th>Supplied By</th>
                            <th class = "action-td">Amount</th>
                            <th class = "action-td">Invoice No</th>
                            <th>Credit Ledger</th>
                            <th class = "action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">';
                        
                        if (mysqli_num_rows($query_run) > 0)
                        {
                            while($row = mysqli_fetch_assoc($query_run))
                            {
                                $ledger_cr = $row['ledger_credit'];
                                $query_ledger = "SELECT * FROM ledgers WHERE ledger_id='$ledger_cr'";
                                $query_ledger_run = mysqli_query($con, $query_ledger);
                                $row_ledger = mysqli_fetch_assoc($query_ledger_run);
                
                                echo '<tr>
                                    <td class = "action-td">
                                        <a href="#" id="btn_edit_stock_sales" data-id="'.$row['stock_sales_id'].'">'.$row['stock_sales_id'].'</a>
                                    </td>
                                    <td class = "action-td">'.$row['date'].'</td>
                                    <td>'.$row['supplied_by'].'</td>
                                    <td class = "amt-td">'.$row['amount'].'</td>
                                    <td class = "action-td">'.$row['reference_no'].'</td>
                                    <td>'.$row_ledger['ledger_desc'].'</td>
                                    <td class = "action-td">';

                                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Sales'] == 'Yes')) 
                                        {
                                            echo '<a href="#" id="btn_edit_stock_sales" data-id="'.$row['stock_sales_id'].'">Edit</a>';
                                            echo ' | <a href="#" id="btn_stock_sales_returns" data-id="'.$row['stock_sales_id'].'">Return</a>';
                                        };
                                            echo ' |
                                            <a href="#" id="stock_sales_invoice_print_btn" data-id="'.$row['stock_sales_id'].'">Reprint</a>';
                                        
                                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Sales'] == 'Yes')) 
                                        {
                                            echo ' |
                                            <a href="#" id="btn_delete_stock_sales" data-id="'.$row['stock_sales_id'].'">Delete</a>';
                                        };

                                    echo '</td>
                                </tr>';
                            }
                        }
                        else
                        {
                            echo 'No Stock Sales Not Found';
                        };
                        
                    echo '</tbody>
                </table>
            </div>';
            ?>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_sales_pending_prescription_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/sales_returns_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_sales_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>