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
			$bonus_voucher_id = $_SESSION['bonus_voucher_id'];
			$bonus_voucher_date = $_SESSION['bonus_voucher_date'];
			$bonus_voucher_narration = $_SESSION['bonus_voucher_narration'];
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
	                Bonus Sheet
	            </h4>
                
                <?php
                      echo $bonus_voucher_date.' | '.$bonus_voucher_narration.' | <a href="#" id="btn_print_bonus_voucher" data-id="'.$bonus_voucher_id.'">Print</a>';
                    ?>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <label for="bonus_voucher_list_search_name">Search</label>
                        <input type="text" class="form-control border-0 small" name="bonus_voucher_list_search_name" id="bonus_voucher_list_search_name">
                    </div>
                    <!--<div class="input-group">
                        <label for="bonus_voucher_search_from">From</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="bonus_voucher_search_from" id="bonus_voucher_search_from">
                    </div>
                    <div class="input-group">
                        <label for="bonus_voucher_search_to">To</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="bonus_voucher_search_to" id="bonus_voucher_search_to">
                    </div>
                    <div class="input-group">
                        <a href="#" data-toggle="" id="bonus_voucher_search_icon"><i class="fas fa-search"></i></a>
                    </div>-->
                </form>
	        </div>
        </div>
        <div class="card-body" id="bonus_voucher_list_card_body">
            <?php
                $query = "SELECT s.*, e.first_name, e.last_name FROM bonus_list s JOIN
                payroll_employee e ON e.employee_id=s.employee_id WHERE s.bonus_id = '$bonus_voucher_id' ORDER BY date DESC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="bonus_voucher_list_table">
                <table class="table table-hover table-bordered table-sm" id="bonus_voucherTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">S/NO</th>
                            <th>EMPLOYEE</th>
                            <th class="action-td">DATE</th>
                            <th class="action-td">CALCULATION TYPE</th>
                            <th class="action-td">BASIC SALARY</th>
                            <th class="action-td">PERCENTAGE</th>
                            <th class="action-td">BONUS AMOUNT</th>
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
                                    $i++;
                                    $basic_salary = $row['basic_salary'];
                                    $percentage = $row['amount'];
                                    $bonus_amount = $row['bonus_amount'];
                                    $basic_salary_f = number_format($basic_salary, 2, '.', ',');
                                    $percentage_f = number_format($percentage, 2, '.', ',');
                                    $bonus_amount_f = number_format($bonus_amount, 2, '.', ',');
                                    
                                    echo '<tr>
                                        <td class="action-td">'.$i.'</td>
                                        <td>'.$row['first_name'].' '.$row['last_name'].'</td>
                                        <td class="action-td">'.$row['date'].'</td>
                                        <td class="action-td">'.$row['calculation_type'].'</td>
                                        <td class="amt-td">'.$basic_salary_f.'</td>
                                        <td class="amt-td">'.$percentage_f.'</td>
                                        <td class="amt-td">'.$bonus_amount_f.'</td>
        	                            <td class="action-td">';
                                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Salary_Adjustment'] == 'Yes')) 
                                            {
                                                echo '<a href="#" id="btn_edit_bonus_list" data-id="'.$row['bonus_list_id'].'">Edit</a>';
                                            };
                                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Salary_Adjustment'] == 'Yes'))
                                            {
                                                echo ' | <a href="#" id="btn_delete_bonus_list" data-id="'.$row['bonus_list_id'].'">Delete</a>';
                                            };
                                        
        	                            echo '</td>
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
    id="bonus_list_delete_modal" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="bonus_list_delete_modal" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bonus_list_delete_modal_title">Employee Bonus Deletion</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <p id="bonus_list_delete_question"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="bonus_list_delete_yes" name="bonus_list_delete_yes" class="btn btn-danger">Yes</button>
                    <button type="button" id="bonus_list_delete_no" name="bonus_list_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('bonus_list_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>