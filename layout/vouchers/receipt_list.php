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
    input {
            border-top-style: hidden;
            border-right-style: hidden;
            border-left-style: hidden;
            border-bottom-style: hidden;
            background-color: #ffffff;
          }
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
<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Receipt List
	            </h4>
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
        				<input type="text" class="form-control border-0 small" name="receipt_patient_name" id="receipt_patient_name">
		            </div>
		            <div class="input-group">
		            	<label>From</label>
                        <?php
                            if($remember_state == true)
                            {
                        ?>
                                <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="receipt_search_from" id="receipt_search_from" value="<?php echo $search_from;?>">
                        <?php
                            }
                            else
                            {
                        ?>
                                <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="receipt_search_from" id="receipt_search_from">
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
                                    <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="receipt_search_to" id="receipt_search_to" value="<?php echo $search_to;?>">
                            <?php
                                }
                                else
                                {
                            ?>
                                    <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="receipt_search_to" id="receipt_search_to">

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
                    <a href="#" data-toggle="" id="new_recipt_icon"><i class="fas fa-plus-square"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
                {
                    $query = "SELECT * FROM receipt WHERE company_id = '$company_id' AND date BETWEEN '$this_month_start' AND 
                    '$this_month_end' ORDER BY date DESC";
                }
                else
                {
                    $query = "SELECT * FROM receipt WHERE branch_id = '$user_branch_id' AND date BETWEEN '$this_month_start' AND 
                    '$this_month_end' ORDER BY date DESC";
                };
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="receipt_list_table">
                <table class="table table-hover table-bordered table-sm" id="receiptTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">Receipt No</th>
                            <th class="action-td">Date</th>
                            <!--<th class="action-td">Cash/Bank A/C</th>-->
                            <th class="action-td">Received From</th>
                            <th class="action-td">Amount</th>
                            <th class="action-td">Mode</th>
                            <th class="action-td">Refund</th>
                            <th class="action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                                    $ledger_id = $row['ledger_debit'];
                                    $query_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
                                    $query_run_ledger = mysqli_query($con, $query_ledger);
                                    $row_ledger = mysqli_fetch_assoc($query_run_ledger);
                        ?>
                                    <tr>
                                        <td class="action-td"><?php echo $row['receipt_id'];?></td>
                                        <td class="action-td">
                                            <a href="#" id="btn_edit_receipt" data-id="<?php echo $row['receipt_id'];?>"><?php echo $row['date'];?></a>
                                        </td>
                                        <!--<td><?php //echo $row_ledger['ledger_desc'];?></td>-->
                                        <td><?php echo $row['name'];?></td>
                                        <td class="amt-td"><?php echo $row['amount'];?></td>
                                        <?php
                                            $receipt_id = $row['receipt_id'];
                                            $query_refund = "SELECT SUM(amount) AS amount FROM refund WHERE receipt_id = '$receipt_id'";
                                            $query_run_refund = mysqli_query($con, $query_refund);
                                            $row_refund = mysqli_fetch_assoc($query_run_refund);
                                        ?>
                                        <td><?php echo $row['mode'];?></td>
                                        <td class="amt-td">
                                            <?php if(isset($row_refund)){echo $row_refund['amount'];}else{echo 'N/A';};?>
                                        </td>
        	                            <td class="action-td">
		                                    <a href="#" id="btn_receipt_reprint" data-id="<?php echo $row['receipt_id'];?>">Reprint</a>
                                            |
                                            <a href="#" id="btn_edit_receipt" data-id="<?php echo $row['receipt_id'];?>">Edit</a>
		                                    |
                                            <a href="#" 
                                                id="btn_refund_receipt" 
                                                data-id="<?php echo $row['receipt_id'];?>" 
                                                data-id1="<?php echo $row['amount'];?>"
                                                data-id2="<?php echo $row['patient_id'];?>"
                                                data-id3="<?php echo $row['attend_id'];?>"
                                                data-id4="<?php echo $row['name'];?>"
                                                data-id5="<?php echo $row['ledger_credit'];?>"
                                                data-id6="<?php echo $row['ledger_debit'];?>"
                                                data-id7="<?php if(isset($row_refund)){echo $row_refund['amount'];}else{echo 0;};?>">
                                                Refund
                                            </a>
                                            |
        									<a href="#" id="btn_delete_receipt" data-id="<?php echo $row['receipt_id'];?>">Delete</a>
        	                            </td>
                                    </tr>
                        <?php
                                }
                            }
                            else
                            {
                                    echo 'No Receipt Not Found';
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
	id="receipt_delete_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="receipt_delete_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="receipt_delete_modal_title">Receipt Deletion</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="receipt_delete_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="receipt_delete_yes" name="receipt_delete_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="receipt_delete_no" name="receipt_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/receipt_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/refund_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>