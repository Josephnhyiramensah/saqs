<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    if(isset($_SESSION['branch_id'])){$user_branch_id = $_SESSION['branch_id'];}else{$user_branch_id = '';};
    if(isset($_SESSION['search_from'])){$search_from = $_SESSION['search_from'];}else{$search_from = '';};
    if(isset($_SESSION['search_to'])){$search_to = $_SESSION['search_to'];}else{$search_to = '';};
    if(isset($_SESSION['page'])){$page = $_SESSION['page'];}else{$page = '';};
    if(isset($_SESSION['remember_state'])){$remember_state = $_SESSION['remember_state'];}else{$remember_state = 'false';};
    
    $date = date('Y-m-d');
    $company_id = $_SESSION['company_id'];
    $this_month_start = date('Y-m-01');
    $this_month_end = date('Y-m-t');
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
	                Purchases List
	            </h4>
                <div class="input-group">
                <a href="#" data-toggle="" id="new_purchase_icon">New Purchase Voucher</a> <!--- | -
                <a href="#" data-toggle="" id="new_inter_branch_purchase_icon">New Inter-Branch Purchase Voucher</a>-->
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
                        <input type="text" class="form-control border-0 small" name="purchase_search" id="purchase_search">
                    </div>
                    <div class="input-group">
                        <label>From</label>
                        <?php
                            if($remember_state == true)
                            {
                        ?>
                                <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="purchase_search_from" id="purchase_search_from" value="<?php echo $search_from;?>">
                        <?php
                            }
                            else
                            {
                        ?>
                                <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="purchase_search_from" id="purchase_search_from">
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
                                    <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="purchase_search_to" id="purchase_search_to" value="<?php echo $search_to;?>">
                            <?php
                                }
                                else
                                {
                            ?>
                                    <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="purchase_search_to" id="purchase_search_to">

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
		        	<div class="input-group">
                    <a href="#" data-toggle="" id="new_purchase_icon"><i class="fas fa-plus-square"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR 
                ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
                {
                    $query = "SELECT * FROM purchases WHERE company_id = '$company_id' AND date BETWEEN '$this_month_start' AND 
                    '$this_month_end' ORDER BY date ASC";
                }
                else
                {
                    $query = "SELECT * FROM purchases WHERE branch_id = '$user_branch_id' AND date BETWEEN '$this_month_start' AND 
                    '$this_month_end' ORDER BY date ASC";
                };
                $query_run = mysqli_query($con, $query);
            
            echo '<div class="table-responsive" id="purchases_list_table">
                <table class="table table-hover table-bordered table-sm" id="purchasesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
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
                                    if(!empty($query_ledger_run) && mysqli_num_rows($query_ledger_run) > 0)
                                    {
                                        $row_ledger = mysqli_fetch_assoc($query_ledger_run);
                                        $ledger_desc = $row_ledger['ledger_desc'];
                                    }
                                    else
                                    {
                                        $ledger_desc = 'Not Specified';
                                    };
                                
                                    echo '<tr>
                                        <td class = "action-td">'.$row['date'].'</td>
                                        <td>'.$row['supplied_by'].'</td>
                                        <td class = "amt-td">'.$row['amount'].'</td>
                                        <td class = "action-td">'.$row['reference_no'].'</td>
                                        <td>'.$ledger_desc.'</td>
        	                            <td class = "action-td">';
                                            if($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR 
                                            ($_SESSION['user_type'] == 'Normal_User' AND $row['company_id']==$_SESSION['company_id'] AND $_SESSION['Edit_Purchases'] == 'Yes'))
                                            {
                                                if($row['stock_req_id'] < 1)
                                                {
                                                    echo '<a href="#" id="btn_edit_purchase" data-id="'.$row['purchase_id'].'">Edit</a>';
                                                };

                                                echo ' | <a href="#" id="btn_purchase_return" data-id="'.$row['purchase_id'].'">Return</a>';
                                            };

                                            if($row['stock_sales_id'] > 0 && ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR 
                                            ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Accept_Purchases'] == 'Yes' && $row['company_id']==$_SESSION['company_id'])))
                                            {
                                                echo ' |
                                                <a href="#" id="btn_accept_purchase" data-id="'.$row['purchase_id'].'">Accept</a>';
                                            };
                                                echo ' |
                                                <a href="#" id="btn_display_purchase" data-id="'.$row['purchase_id'].'">Display</a>';

                                            if($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR 
                                            ($_SESSION['user_type'] == 'Normal_User' AND ($row['sending_company_id']==$_SESSION['company_id'] 
                                            OR $row['company_id']==$_SESSION['company_id']) AND $_SESSION['Delete_Purchases'] == 'Yes'))
                                            {
                                                echo ' |
                                                <a href="#" id="btn_delete_purchase" data-id="'.$row['purchase_id'].'">Delete</a>';
                                            };
        	                            echo '</td>
                                    </tr>';
                                }
                            }
                            else
                            {
                                echo 'No Purchases Not Found';
                            };
                    echo '</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div 
	class="modal fade bd-example-modal-xl" 
	id="purchase_delete_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="purchase_delete_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="purchase_delete_modal_title">Purchase Invoice Deletion</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="purchase_delete_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="purchase_delete_yes" name="purchase_delete_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="purchase_delete_no" name="purchase_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>';
?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/purchases_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/purchase_returns_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>