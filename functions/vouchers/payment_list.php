<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
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
                $query = "SELECT * FROM payment WHERE company_id = '".$_SESSION['company_id']."' ORDER BY date ASC";
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
                                                echo '| <a href="#" id="btn_delete_payment" data-id2="'.$row['payment_id'].'"><i class="fa fa-trash fa-sm"></i></a>';
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
<?php include('payment_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>