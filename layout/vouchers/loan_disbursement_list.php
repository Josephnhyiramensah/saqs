<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
	$time = date('H-i-sa');
    $company_id = $_SESSION['company_id'];
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
<div class="container-fluid scroll-card-body">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Loan Disbursement List
	            </h4>
                
                <?php
                      if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Loan_Disbursement'] == 'Yes')) 
                      {
                        echo '<a href="#" data-toggle="" id="new_loan_disbursement_icon">New Loan Disbursement</a>';
                      };
                    ?>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <label for="loan_disbursement_search_name">Search</label>
                        <input type="text" class="form-control border-0 small" name="loan_disbursement_search_name" id="loan_disbursement_search_name">
                    </div>
                    <div class="input-group">
                        <label for="loan_disbursement_search_from">From</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="loan_disbursement_search_from" id="loan_disbursement_search_from">
                    </div>
                    <div class="input-group">
                        <label for="loan_disbursement_search_to">To</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="loan_disbursement_search_to" id="loan_disbursement_search_to">
                    </div>
                    <div class="input-group">
                        <a href="#" data-toggle="" id="loan_disbursement_search_icon"><i class="fas fa-search"></i></a>
                    </div>
                </form>
	        </div>
        </div>
        <div class="card-body" id="loan_disbursement_list_card_body">
            <?php
                $query = "SELECT * FROM payroll_loan_disburse WHERE company_id = '$company_id' ORDER BY date DESC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="loan_disbursement_list_table">
                <table class="table table-hover table-bordered table-sm" id="loan_disbursementTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">Date</th>
                            <th>Name</th>
                            <th class="action-td">Principal</th>
                            <th class="action-td">Duration</th>
                            <th class="action-td">Interest</th>
                            <th class="action-td">Interest Type</th>
                            <th class="action-td">Effective Date</th>
                            <th class="action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    $employee_id = $row['employee_id'];
                                    $sql_employee="SELECT * FROM payroll_employee WHERE employee_id = '$employee_id' ORDER BY first_name ASC";
                                    $result_employee = mysqli_query($con,$sql_employee);
                                    if(!empty($result_employee) && mysqli_num_rows($result_employee) > 0)
                                    {
                                        $row_employee = mysqli_fetch_array($result_employee);
                                        $employee_name = $row_employee['first_name'].' '.$row_employee['last_name'];
                                    }
                                    else
                                    {
                                        $employee_name = 'Not Specified';
                                    };
                                    $principal = $row['principal'];
                                    $f_principal = number_format($principal, 2, '.', ',');
                        ?>
                                    <tr>
                                        <td class="action-td"><?php echo $row['date'];?></td> 
                                        <td><?php echo $employee_name;?></td>
                                        <td class="amt-td"><?php echo $f_principal;?></td>
                                        <td class="action-td"><?php echo $row['duration'];?></td>
                                        <td class="action-td"><?php echo $row['interest_rate'];?></td>
                                        <td class="action-td"><?php echo $row['interest_type'];?></td>
                                        <td class="action-td"><?php echo $row['effective_date'];?></td>
        	                            <td class="action-td">
                                            <?php
                                              if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Loan_Disbursement'] == 'Yes')) 
                                              {
                                                echo '<a href="#" id="btn_edit_loan_disbursement" data-id="'.$row['loan_disburse_id'].'">Edit</a> |';
                                              };
                                            ?>

                                              <a href="#" id="btn_loan_disbursement_reprint" data-id="<?php echo $row['loan_disburse_id'];?>">Print</a>

                                            <?php
                                              if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Loan_Disbursement'] == 'Yes'))
                                              {
                                                echo '| <a href="#" id="btn_delete_loan_disbursement" data-id="'.$row['loan_disburse_id'].'">Delete</a>';
                                              };
                                            ?>
        	                            </td>
                                    </tr>
                        <?php				
									//CREATOR
										$created_id = $row['created_by'];
										$query_creator = "SELECT * FROM users WHERE id='$created_id'";
										$result_creator = mysqli_query($con,$query_creator);
										if(!empty($result_creator) && mysqli_num_rows($result_creator) > 0)
										{
											$row_creator = mysqli_fetch_assoc($result_creator);
											$creator = 'Entered By:'.$row_creator['first_name'].' '.$row_creator['last_name'].': '.$row['created_datetime'];
										}
										else
										{
											$creator = 'Not Specified';
										};

									//ALTER
										$altered_id = $row['altered_by'];
										$query_alter = "SELECT * FROM users WHERE id='$altered_id'";
										$result_alter = mysqli_query($con,$query_alter);
										if(!empty($result_alter) && mysqli_num_rows($result_alter) > 0)
										{
											$row_alter = mysqli_fetch_assoc($result_alter);
											$alter = 'Altered By:'.$row_alter['first_name'].' '.$row_alter['last_name'].': '.$row['altered_datetime'];
										}
										else
										{
											$alter = 'Not Specified';
										};

									//BRANCH
										$voucher_branch_id = $row['branch_id'];
										$query_branch = "SELECT * FROM branch WHERE branch_id='$voucher_branch_id'";
										$result_branch = mysqli_query($con,$query_branch);
										if(!empty($result_branch) && mysqli_num_rows($result_branch) > 0)
										{
											$row_branch = mysqli_fetch_assoc($result_branch);
											$voucher_branch = $row_branch['branch_name'];
										}
										else
										{
											$voucher_branch = 'Not Specified';
										};
							  
						echo '<tr>
							  <td class = "action-td" colspan="8"><small>Branch:'.$voucher_branch.': '.$creator.' '.$alter.'</small>
							  </td>
						  </tr>';
                        
                                }
                            }
                            else
                            {
                                    echo 'No Loan Disbursement Voucher Not Found';
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers//loan_disbursement_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>