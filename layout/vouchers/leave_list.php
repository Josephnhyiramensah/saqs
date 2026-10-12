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
    $branch_id = $_SESSION['branch_id'];
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
	                Leave List
	            </h4>
                
                <?php
                      if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Leave'] == 'Yes')) 
                      {
                        echo '<a href="#" data-toggle="" id="new_leave_icon">New leave</a>';
                      };
                    ?>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <label for="leave_search_name">Search</label>
                        <input type="text" class="form-control border-0 small" name="leave_search_name" id="leave_search_name">
                    </div>
                    <div class="input-group">
                        <label for="leave_search_from">From</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="leave_search_from" id="leave_search_from">
                    </div>
                    <div class="input-group">
                        <label for="leave_search_to">To</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="leave_search_to" id="leave_search_to">
                    </div>
                    <div class="input-group">
                        <a href="#" data-toggle="" id="leave_search_icon"><i class="fas fa-search"></i></a>
                    </div>
                </form>
	        </div>
        </div>
        <div class="card-body" id="leave_list_card_body">
            <?php
                $query = "SELECT * FROM payroll_leave WHERE company_id = '$company_id' ORDER BY date DESC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="leave_list_table">
                <table class="table table-hover table-bordered table-sm" id="leaveTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td" rowspan="2">Employee</th>
                            <th class="action-td" rowspan="2">Date</th>
                            <th class="action-td" rowspan="2">Start Date</th>
                            <th class="action-td" rowspan="2">End Date</th>
                            <th class="action-td" colspan="2">Annual</th>
                            <th class="action-td" colspan="2">Sick</th>
                            <th class="action-td" colspan="2">Maternity</th>
                            <th class="action-td" rowspan="2">Narration</th>
                            <th class="action-td" rowspan="2">Action</th>
                        </tr>
                        <tr>
                            <th class="action-td">Requested</th>
                            <th class="action-td">Approved</th>
                            <th class="action-td">Requested</th>
                            <th class="action-td">Approved</th>
                            <th class="action-td">Requested</th>
                            <th class="action-td">Approved</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    
                                        $employee_id = $row['employee_id'];
                                        $query_employee = "SELECT * FROM payroll_employee WHERE employee_id ='$employee_id'";
                                        $query_run_employee = mysqli_query($con,$query_employee);
                                        $row_employee = mysqli_fetch_array($query_run_employee);
                                    
                        ?>
                                    <tr>
                                        <td>
                                            <?php echo $row_employee['first_name'].' '.$row_employee['last_name'];?>
                                        </td>
                                        <td class="action-td"><?php echo $row['date'];?></td>
                                        <td class="action-td"><?php echo $row['date_start'];?></td> 
                                        <td class="action-td"><?php echo $row['date_end'];?></td> 
                                        <td class="action-td"><?php echo $row['requested_annual'];?></td>
                                        <td class="action-td"><?php echo $row['leave_annual'];?></td>
                                        <td class="action-td"><?php echo $row['requested_sick'];?></td>
                                        <td class="action-td"><?php echo $row['leave_sick'];?></td>
                                        <td class="action-td"><?php echo $row['requested_maternity'];?></td>
                                        <td class="action-td"><?php echo $row['leave_maternity'];?></td>
                                        <td><?php echo $row['narration'];?></td>
        	                            <td class="action-td">
                                            <?php
                                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_id'] == $row['authorised_by'])) 
                                                {
                                                    echo '<a href="#" id="btn_authorise_leave" data-id="'.$row['leave_id'].'">Authorised</a> | ';
                                                };
                                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_id'] == $row['approved_by'])) 
                                                {
                                                    echo '<a href="#" id="btn_approve_leave" data-id="'.$row['leave_id'].'">Approved</a> | ';
                                                };
                                                echo '<a href="#" id="btn_display_leave" data-id="'.$row['leave_id'].'">Display</a> | ';
                                              if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Leave'] == 'Yes')) 
                                              {
                                                echo '<a href="#" id="btn_edit_leave" data-id="'.$row['leave_id'].'">Edit</a>';
                                              };
                                              if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Leave'] == 'Yes'))
                                              {
                                                echo ' | <a href="#" id="btn_delete_leave" data-id="'.$row['leave_id'].'">Delete</a>';
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
							  <td class = "action-td" colspan="12"><small>Branch:'.$voucher_branch.': '.$creator.' '.$alter.'</small>
							  </td>
						  </tr>';
                        
                                }
                            }
                            else
                            {
                                echo 'No leave Voucher Not Found';
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
    id="leave_delete_modal" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="leave_delete_modal" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leave_delete_modal_title">Leave Deletion</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <p id="leave_delete_question"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="leave_delete_yes" name="leave_delete_yes" class="btn btn-danger">Yes</button>
                    <button type="button" id="leave_delete_no" name="leave_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div 
    class="modal fade bd-example-modal-xl" 
    id="leave_comment_modal" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="leave_comment_modal" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leave_comment_modal_title">leave Comment</h5>
            </div>
			<form id="leave_comment_form" method="POST">
                <div class="modal-body">
                    <div class="form-row" id="approved_days" hidden="true">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="leave_comment_annual_days">Annual Days</label>
	                        <input type="text" name="leave_comment_annual_days" class="form-control bg-light" id="leave_comment_annual_days">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="leave_comment_sick_days">Sick Days</label>
	                        <input type="text" name="leave_comment_sick_days" class="form-control bg-light" id="leave_comment_sick_days">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="leave_comment_maternity_days">Maternity Days</label>
	                        <input type="text" name="leave_comment_maternity_days" class="form-control bg-light" id="leave_comment_maternity_days">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-12 form-group">
                            <label for="leave_comment">Comment</label>
	                        <input type="hidden" name="comment_leave_id" class="form-control bg-light" id="comment_leave_id">
                            <textarea class="form-control bg-light" id="leave_comment" name="leave_comment" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="leave_comment_approve" name="leave_comment_approve" class="btn btn-secondary">Approve</button>
                    <button type="button" id="leave_comment_authorise" name="leave_comment_authorise" class="btn btn-secondary">Authorise/Verify</button>
                    <button type="button" id="leave_comment_cancel" name="leave_comment_cancel" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/leave_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>