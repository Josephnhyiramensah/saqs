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
<input type='hidden' id='session_user_type_id' value="<?php echo $_SESSION['user_type_id'];?>">
<style type="text/css">
    input {
            border-top-style: hidden;
            border-right-style: hidden;
            border-left-style: hidden;
            border-bottom-style: hidden;
            background-color: #ffffff;
          }
      #ledger_list_card_body {
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
    <div class="card shadow">
        <div class="card-header">
            <div class="form-row">
                <div class="col-md-12 mb-12 float-left">
        	            <h4 class="m-0 font-weight-bold text-primary">
        	                Ledger List
        	            </h4>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-12 float-right">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="col-md-2 mb-2 input-group">
                                <label>Search</label>
                                <input type="text" class="form-control border-0 small" name="ledger_search" id="ledger_search">
                            </div>
                            <?php
                              if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Ledger'] == 'Yes')) 
                              {
                                echo '<div class="col-md-2 mb-2 input-group">
                                    <a href="#" data-toggle="" id="new_ledger_icon">New Ledger</a>
                                </div>';
                              };
                            ?>
                        </form>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-2 mb-2 text-center">
                    <a href="#" data-toggle="" id="new_customer_ledger" data-id="customer">New Customer/Debtor</a>
                </div>
                <div class="col-md-2 mb-2 text-center">
                    <a href="#" data-toggle="" id="new_supplier_ledger" data-id="supplier">New Supplier/Creditor</a>
                </div>
                <div class="col-md-2 mb-2 text-center">
                    <a href="#" data-toggle="" id="new_cash_ledger" data-id="cash">New Cash Account</a>
                </div>
                <div class="col-md-2 mb-2 text-center">
                    <a href="#" data-toggle="" id="new_bank_ledger" data-id="bank">New Bank Account</a>
                </div>
                <div class="col-md-2 mb-2 text-center">
                    <a href="#" data-toggle="" id="new_expense_ledger" data-id="expense">New Expense</a>
                </div>
                <div class="col-md-2 mb-2 text-center">
                    <a href="#" data-toggle="" id="new_ledger_help">Help</a>
                </div>
            </div>
        </div>
        <div class="card-body" id="ledger_list_card_body">
            <?php
                /*$company_id = $_SESSION['company_id'];
                if($_SESSION['user_type'] == 'Ultra_Super_User')
                {*/
                    $query = "SELECT * FROM ledgers ORDER BY ledger_desc ASC";
                /*}
                else
                {
                    $query = "SELECT * FROM ledgers WHERE company_id = '$company_id'";
                };*/
                
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="ledger_list_table_div">
                <table class="table table-hover table-bordered table-sm" id="ledgerTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>TB Group 1</th>
                            <th>TB Group 2</th>
                            <th>TB Group 3</th>
                            <th>TB Group 4</th>
                            <th>TB Group 5</th>
                            <th>Last Date</th>
                            <th>No of Days</th>
                            <?php
                                if($_SESSION['user_type'] == 'Ultra_Super_User')
                                {
                                    echo '<th>Company</th>';
                                };
                            ?>
                            <th class = "action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                                    $tb_1_id = $row['tb_1'];
                                    $querytb_1 = "SELECT tb_1_desc FROM trial_bal_group_1 WHERE id='$tb_1_id'";
                                    $querytb_1_run = mysqli_query($con, $querytb_1);
                                    $row_tb_1=mysqli_fetch_assoc($querytb_1_run);

                                    $tb_2_id = $row['tb_2'];
                                    $querytb_2 = "SELECT tb_2_desc FROM trial_bal_group_2 WHERE id='$tb_2_id'";
                                    $querytb_2_run = mysqli_query($con, $querytb_2);
                                    $row_tb_2=mysqli_fetch_assoc($querytb_2_run);

                                    $tb_3_id = $row['tb_3'];
                                    $querytb_3 = "SELECT tb_3_desc FROM trial_bal_group_3 WHERE id='$tb_3_id'";
                                    $querytb_3_run = mysqli_query($con, $querytb_3);
                                    $row_tb_3=mysqli_fetch_assoc($querytb_3_run);

                                    $tb_4_id = $row['tb_4'];
                                    $querytb_4 = "SELECT tb_4_desc FROM trial_bal_group_4 WHERE id='$tb_4_id'";
                                    $querytb_4_run = mysqli_query($con, $querytb_4);
                                    $row_tb_4=mysqli_fetch_assoc($querytb_4_run);

                                    $tb_5_id = $row['tb_5'];
                                    $querytb_5 = "SELECT tb_5_desc FROM trial_bal_group_5 WHERE id='$tb_5_id'";
                                    $querytb_5_run = mysqli_query($con, $querytb_5);
                                    $row_tb_5=mysqli_fetch_assoc($querytb_5_run);

                                    $ledger_id = $row['ledger_id'];
                                    $query_trans = "SELECT * FROM transactions WHERE ledger_id='$ledger_id' AND company_id='$company_id' ORDER BY date DESC";
                                    $query_run_trans = mysqli_query($con, $query_trans);
                                    $row_trans = mysqli_fetch_assoc($query_run_trans);
                                    if(isset($row_trans['date']) && $row_trans['date'] > 0)
                                    {
                                        $last_visit = $row_trans['date'];
                                    }
                                    else
                                    {
                                        $last_visit = Date('Y-m-d');
                                    };

                                    $last_visit_date = new DateTime($last_visit);
                                    $today = new DateTime();
                                    $days = $today->diff($last_visit_date)->format('%a');
                        ?>
                            <tr>
	                            <td><?php echo $row['ledger_desc'];?></td>
	                            <td><?php 
                                    if (isset($row_tb_1['tb_1_desc'])){echo $row_tb_1['tb_1_desc'];}?>
                                </td>
                                <td><?php 
                                    if (isset($row_tb_2['tb_2_desc'])){echo $row_tb_2['tb_2_desc'];}?>
                                </td>
	                            <td><?php 
                                    if (isset($row_tb_3['tb_3_desc'])){echo $row_tb_3['tb_3_desc'];}?>
                                </td>
                                <td><?php 
                                    if (isset($row_tb_4['tb_4_desc'])){echo $row_tb_4['tb_4_desc'];}?>
                                </td>
                                <td><?php 
                                    if (isset($row_tb_5['tb_5_desc'])){echo $row_tb_5['tb_5_desc'];}?>
                                </td>
                                <td><?php echo $last_visit;?></td>
                                <td><?php echo $days.' day(s)';?></td>
                                <?php
                                    if($_SESSION['user_type'] == 'Ultra_Super_User')
                                    {
                                        $ledger_company_id = $row['company_id'];
                                        if($ledger_company_id > 0)
                                        {
                                            $query_lc = "SELECT * FROM company WHERE company_id = '$ledger_company_id'";
                                            $query_run_lc = mysqli_query($con, $query_lc);
                                            if (mysqli_num_rows($query_run_lc) > 0) 
                                            {
                                                $row_lc = mysqli_fetch_assoc($query_run_lc);
                                                echo '<td>'.$row_lc['trading_name'].'</td>';
                                            }
                                            else
                                            {
                                                echo '<td></td>';
                                            }
                                        }
                                        else
                                        {
                                            echo '<td></td>';
                                        };
                                    };
                                ?>
	                            <td class = "action-td">
                                    <?php
                                      if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Ledger'] == 'Yes' AND  $row['default_status'] !='Yes')) 
                                      {
                                        echo '<a href="#" id="btn_edit_ledger" data-id="'.$row['ledger_id'].'"><i class="fa fa-edit fa-sm"></i></a>';
                                      };

                                      if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Ledger'] == 'Yes' AND  $row['default_status'] !='Yes')) 
                                      {
                                        echo ' | <a href="#" id="btn_delete_ledger" data-id="'.$row['ledger_id'].'"><i class="fa fa-trash fa-sm"></i></a>';
                                      };
                                    ?>
	                            </td>
                            </tr>
                        <?php
                                }
                            }
                            else
                            {
                                    echo 'Data Not Found';
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/ledger_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>