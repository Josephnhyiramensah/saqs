<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    $date = date('Y-m-d');
    $company_id = $_SESSION['company_id'];
    $this_month_start = date('Y-m-01');
    $this_month_end = date('Y-m-t');
    if(isset($_SESSION['branch_id'])){$user_branch_id = $_SESSION['branch_id'];}else{$user_branch_id = '';};
?>
<input type='hidden' id='session_company_id' value="<?php echo $_SESSION['company_id'];?>">
<input type='hidden' id='session_user_super_id' value="<?php echo $_SESSION['user_super_id'];?>">
<input type='hidden' id='session_user_id' value="<?php echo $_SESSION['user_id'];?>">
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
	                Payment List
	            </h4>
                <?php
                  if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Payment'] == 'Yes')) 
                  {
                    echo '<a href="#" data-toggle="" id="new_payment_icon">New Payment</a>';
                  };
                ?>
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
                        <label>Search</label>
                        <input type="text" class="form-control border-0 small" name="payment_search_name" id="payment_search_name">
                    </div>
                    <div class="input-group">
                        <label>From</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="payment_search_from" id="payment_search_from">
                    </div>
                    <div class="input-group">
                        <label>To</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="payment_search_to" id="payment_search_to">
                    </div>
                    <div class="input-group">
                        <a href="#" data-toggle="" id="payment_search_icon"><i class="fas fa-search"></i></a>
                    </div>
                </form>
	        </div>
        </div>
        <div class="card-body" id="payment_list_card_body">
            <?php
                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
                {
                    $query = "SELECT * FROM payment WHERE company_id = '$company_id' AND date BETWEEN '$this_month_start' AND 
                    '$this_month_end' ORDER BY date DESC";
                }
                else
                {
                    $query = "SELECT * FROM payment WHERE branch_id = '$user_branch_id' AND date BETWEEN '$this_month_start' AND 
                    '$this_month_end' ORDER BY date DESC";
                };
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="payment_list_table">
                <table class="table table-hover table-bordered table-sm" id="paymentTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%" class="action-td">Payment No</th>
                            <th width="10%" class="action-td">Date</th>
                            <th width="30%">Payee</th>
                            <th width="20%">Paying Ledger</th>
                            <th width="15%">Amount</th>
                            <th width="10%">Mode</th>
                            <th width="5%" class="action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                        ?>
                                    <tr>
                                        <td class="action-td">
                                            <?php echo $row['sno'];?>
                                        </td>
                                        <td class="action-td"><?php echo $row['date'];?></td>
                                        <td><?php echo $row['payee'];?></td>
                                        <?php
                                            $ledger_id = $row['ledger_credit'];
                                            $query_ledger="SELECT * FROM ledgers WHERE ledger_id ='$ledger_id'";
                                            $query_run_ledger = mysqli_query($con,$query_ledger);
                                            $row_ledger = mysqli_fetch_array($query_run_ledger);

                                            $payment_amount = $row['amount'];
                                            $payment_amount = number_format($payment_amount, 2, '.', ',');
                                        ?>
                                        <td><?php echo $row_ledger['ledger_desc'];?></td>
                                        <td class="amt-td"><?php echo $payment_amount;?></td>
                                        <td><?php echo $row['mode'];?></td>
        	                            <td class="action-td">
                                            <?php
                                              if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Payment'] == 'Yes')) 
                                              {
                                                echo '<a href="#" id="btn_edit_payment" data-id="'.$row['payment_id'].'"><i class="fa fa-edit fa-sm"></i></a> |';
                                              };
                                            ?>

                                              <a href="#" id="btn_payment_reprint" data-id="<?php echo $row['payment_id'];?>"><i class="fa fa-print fa-sm"></i></a>

                                            <?php
                                              if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Payment'] == 'Yes'))
                                              {
                                                echo '| <a href="#" id="btn_delete_payment" data-id="'.$row['payment_id'].'"><i class="fa fa-trash fa-sm"></i></a>';
                                              };
                                            ?>
        	                            </td>
                                    </tr>
                        <?php
                                }
                            }
                            else
                            {
                                    echo 'No Payment Not Found';
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
    id="payment_delete_modal" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="payment_delete_modal" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payment_delete_modal_title">Payment Deletion</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <p id="payment_delete_question"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="payment_delete_yes" name="payment_delete_yes" class="btn btn-danger">Yes</button>
                    <button type="button" id="payment_delete_no" name="payment_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include('payment_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>