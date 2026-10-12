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
	                Bonus Voucher List
	            </h4>
                
                <?php
                      //if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_bonus_voucher'] == 'Yes')) 
                      //{
                        echo '<a href="#" data-toggle="" id="new_bonus_voucher_icon">New Bonus Voucher</a>';
                      //};
                    ?>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <label for="bonus_voucher_search_name">Search</label>
                        <input type="text" class="form-control border-0 small" name="bonus_voucher_search_name" id="bonus_voucher_search_name">
                    </div>
                    <div class="input-group">
                        <label for="bonus_voucher_search_from">From</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="bonus_voucher_search_from" id="bonus_voucher_search_from">
                    </div>
                    <div class="input-group">
                        <label for="bonus_voucher_search_to">To</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="bonus_voucher_search_to" id="bonus_voucher_search_to">
                    </div>
                    <div class="input-group">
                        <a href="#" data-toggle="" id="bonus_voucher_search_icon"><i class="fas fa-search"></i></a>
                    </div>
                </form>
	        </div>
        </div>
        <div class="card-body" id="bonus_voucher_list_card_body">
            <?php
                $query = "SELECT * FROM bonus WHERE company_id = '$company_id' ORDER BY date DESC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="bonus_voucher_list_table">
                <table class="table table-hover table-bordered table-sm" id="bonus_voucherTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">S/NO</th>
                            <th class="action-td">DATE</th>
                            <th class="action-td">LOCATION</th>
                            <th class="action-td">CALCULATION TYPE</th>
                            <th class="action-td">PERCENTAGE/AMOUNT</th>
                            <th class="action-td">NARRATION</th>
                            <th class="action-td">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            $i=0;
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    
                                    $location_id = $row['location'];
                                    //$employee_id = $row['employee_id'];
                                    //LOCATION
                                        if($location_id == 'ALL')
                                        {
                                            $location_name = 'ALL';
                                        }
                                        else
                                        {
                                            $query_yee = "SELECT * FROM branch WHERE branch_id='$location_id' LIMIT 1";
                                            $result_yee = mysqli_query($con,$query_yee);
                                            if(!empty($result_yee) && mysqli_num_rows($result_yee) > 0)
                                            {
                                                $row_yee = mysqli_fetch_assoc($result_yee);
                                                $location_name = $row_yee['branch_name'];
                                            }
                                            else
                                            {
                                                $location_name = 'ALL';
                                            };
                                        };

                                    $i++;
                                    echo '<tr>
                                        <td class="action-td">'.$i.'</td>
                                        <td class="action-td">'.$row['date'].'</td>
                                        <td>'.$location_name.'</td> 
                                        <td>'.$row['calculation_type'].'</td> 
                                        <td>'.$row['amount'].'</td>
                                        <td>'.$row['narration'].'</td>
        	                            <td class="action-td">';
                                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Display_Salary_Adjustment'] == 'Yes')) 
                                            {
                                                echo '<a href="#" 
                                                    id="btn_display_bonus_voucher" 
                                                    data-bonus_id="'.$row['bonus_id'].'"
                                                    data-date="'.$row['date'].'"
                                                    data-narration="'.$row['narration'].'"
                                                >Display</a>';
                                            };
                                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Salary_Adjustment'] == 'Yes')) 
                                            {
                                                echo ' | <a href="#" id="btn_print_bonus_voucher" data-id="'.$row['bonus_id'].'">Print</a>';
                                            };
                                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Salary_Adjustment'] == 'Yes')) 
                                            {
                                                echo ' | <a href="#" id="btn_edit_bonus_voucher" data-id="'.$row['bonus_id'].'">Edit</a>';
                                            };
                                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Salary_Adjustment'] == 'Yes'))
                                            {
                                                echo ' | <a href="#" id="btn_delete_bonus_voucher" data-id="'.$row['bonus_id'].'">Delete</a>';
                                            };
                                        
        	                            echo '</td>
                                    </tr>';
                                    			
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
                                echo 'No bonus_voucher Voucher Not Found';
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
    id="bonus_voucher_delete_modal" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="bonus_voucher_delete_modal" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bonus_voucher_delete_modal_title">Bonus Voucher Deletion</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <p id="bonus_voucher_delete_question"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="bonus_voucher_delete_yes" name="bonus_voucher_delete_yes" class="btn btn-danger">Yes</button>
                    <button type="button" id="bonus_voucher_delete_no" name="bonus_voucher_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/bonus_voucher_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>