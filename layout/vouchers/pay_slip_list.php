<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
	$time = date('H-i-sa');
    $pay_sheet_id = $_SESSION['pay_sheet_id'];
    $pay_sheet_date = $_SESSION['pay_sheet_date'];
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
	                Pay Sheet List
	            </h4>
                
                <?php
                    echo '<p>Pay Sheet As At '.$pay_sheet_date.'</p>';
                      /*if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Pay_Sheet'] == 'Yes')) 
                      {
                        echo '<a href="#" data-toggle="" id="new_pay_sheet_icon" data-id="'.$pay_sheet_id.'">New Pay Slip</a>';
                      };*/
                    ?>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <label>Search</label>
                        <input type="text" class="form-control border-0 small" name="pay_slip_search_name" id="pay_slip_search_name"  data-id="<?php echo $pay_sheet_id;?>">
                    </div>
                    <!--<div class="input-group">
                        <label>From</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="pay_sheet_search_from" id="pay_sheet_search_from">
                    </div>
                    <div class="input-group">
                        <label>To</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="pay_sheet_search_to" id="pay_sheet_search_to">
                    </div>
                    <div class="input-group">
                        <a href="#" data-toggle="" id="pay_sheet_search_icon"><i class="fas fa-search"></i></a>
                    </div>-->
                </form>
	        </div>
        </div>
        <div class="card-body" id="pay_sheet_list_card_body">
            <?php
                $query_pay_slip = "SELECT * FROM payroll_pay_slip WHERE pay_sheet_id = '$pay_sheet_id'";
                $query_run_pay_slip = mysqli_query($con, $query_pay_slip);
            ?>
            <div class="table-responsive" id="pay_slip_list_table">
                <table class="table table-hover table-bordered table-sm" id="pay_sheetTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td" rowspan="3">Period</th>
                            <th class="action-td" colspan="12">Earnings</th>
                            <th class="action-td" colspan="9">Deduction</th>
                            <th class="action-td" rowspan="3">Net Salary</th>
                            <th class="action-td" rowspan="3">Action</th>
                        </tr>
                        <tr>
                            <th class="action-td" rowspan="2">Basic Salary</th>
                            <th class="action-td" rowspan="2">Fuel All</th>
                            <th class="action-td" rowspan="2">Clothing All</th>
                            <th class="action-td" rowspan="2">Other All.</th>
                            <th class="action-td" colspan="4">Overtime</th>
                            <th class="action-td" rowspan="2">Bonus</th>
                            <th class="action-td" rowspan="2">Salary Arrears</th>
                            <th class="action-td" rowspan="2">Paid Leave</th>
                            <th class="action-td" rowspan="2">Total Allow.</th>
                            <th class="action-td" rowspan="2">Total Emol.</th>
                            <th class="action-td" rowspan="2">Welfare</th>
                            <th class="action-td" rowspan="2">SSF Employee</th>
                            <th class="action-td" rowspan="2">SSF Employee Arrears</th>
                            <th class="action-td" rowspan="2">PAYE</th>
                            <th class="action-td" rowspan="2">Salary Adv.</th>
                            <th class="action-td" rowspan="2">Loan</th>
                            <th class="action-td" rowspan="2">Other Deductions</th>
                            <th class="action-td" rowspan="2">Absent</th>
                            <th class="action-td" rowspan="2">Total Ded.</th>
                        </tr>
                        <tr>
                            <th class="action-td">Normal</th>
                            <th class="action-td">Day 6/7</th>
                            <th class="action-td">Holiday</th>
                            <th class="action-td">Total</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run_pay_slip) > 0)
                            {
                                while($row_pay_slip = mysqli_fetch_assoc($query_run_pay_slip))
                                {
                                    $employee_id = $row_pay_slip['employee_id'];
                                    $query_employee = "SELECT * FROM payroll_employee WHERE employee_id = '$employee_id'";
                                    $query_run_employee = mysqli_query($con, $query_employee);
                                    if(!empty($query_run_employee) && mysqli_num_rows($query_run_employee) > 0)
                                    {
                                        $row_employee = mysqli_fetch_assoc($query_run_employee);
                                        $employee_name = $row_employee['first_name'].' '.$row_employee['last_name'];
                                    }
                                    else
                                    {
                                        $employee_name = 'Not Specified';
                                    };

                                        if($row_pay_slip['basic_salary'] != NULL){$basic_salary = $row_pay_slip['basic_salary'];}else{$basic_salary = 0;};
                                        if($row_pay_slip['fuel_allowance'] != NULL){$fuel_allowance = $row_pay_slip['fuel_allowance'];}else{$fuel_allowance = 0;};
                                        if($row_pay_slip['clothing_allowance'] != NULL){$clothing_allowance = $row_pay_slip['clothing_allowance'];}else{$clothing_allowance = 0;};
                                        if($row_pay_slip['other_allowance'] != NULL){$other_allowance = $row_pay_slip['other_allowance'];}else{$other_allowance = 0;};
                                        if($row_pay_slip['normal_overtime'] != NULL){$normal_overtime = $row_pay_slip['normal_overtime'];}else{$normal_overtime = 0;};
                                        if($row_pay_slip['holiday'] != NULL){$holiday = $row_pay_slip['holiday'];}else{$holiday = 0;};
                                        if($row_pay_slip['day_67'] != NULL){$day_67 = $row_pay_slip['day_67'];}else{$day_67 = 0;};
                                        if($row_pay_slip['welfare'] != NULL){$welfare = $row_pay_slip['welfare'];}else{$welfare = 0;};
                                        if($row_pay_slip['bonus'] != NULL){$bonus = $row_pay_slip['bonus'];}else{$bonus = 0;};
                                        if($row_pay_slip['paid_leave'] != NULL){$paid_leave = $row_pay_slip['paid_leave'];}else{$paid_leave = 0;};
                                        if($row_pay_slip['other_deductions'] != NULL){$other_deductions = $row_pay_slip['other_deductions'];}else{$other_deductions = 0;};
                                        if($row_pay_slip['ssf_amount'] != NULL){$ssf_amount = $row_pay_slip['ssf_amount'];}else{$ssf_amount = 0;};
                                        if($row_pay_slip['tax'] != NULL){$tax = $row_pay_slip['tax'];}else{$tax = 0;};
                                        if($row_pay_slip['salary_advance'] != NULL){$salary_advance = $row_pay_slip['salary_advance'];}else{$salary_advance = 0;};
                                        if($row_pay_slip['loan_repayment'] != NULL){$loan_repayment = $row_pay_slip['loan_repayment'];}else{$loan_repayment = 0;};
                                        if($row_pay_slip['absent'] != NULL){$absent = $row_pay_slip['absent'];}else{$absent = 0;};if($row_pay_slip['salary_arrears'] != NULL){$salary_arrears = $row_pay_slip['salary_arrears'];}else{$salary_arrears = 0;};
                                        if($row_pay_slip['tier_1_arrears'] != NULL){$tier_1_arrears = $row_pay_slip['tier_1_arrears'];}else{$tier_1_arrears = 0;};
                                        if($row_pay_slip['tier_2_arrears'] != NULL){$tier_2_arrears = $row_pay_slip['tier_2_arrears'];}else{$tier_2_arrears = 0;};
                                        if($row_pay_slip['ssf_employee_arrears'] != NULL){$ssf_employee_arrears = $row_pay_slip['ssf_employee_arrears'];}else{$ssf_employee_arrears = 0;};
                                        if($row_pay_slip['ssf_employer_arrears'] != NULL){$ssf_employer_arrears = $row_pay_slip['ssf_employer_arrears'];}else{$ssf_employer_arrears = 0;};
                                        if($row_pay_slip['ssnit_arrears_type'] != NULL){$ssnit_arrears_type = $row_pay_slip['ssnit_arrears_type'];}else{$ssnit_arrears_type = 0;};
                                    
                                        $total_allowance = $fuel_allowance + $clothing_allowance + $other_allowance +
                                        $normal_overtime + $holiday + $day_67 + $bonus + $paid_leave + $salary_arrears;

                                        $total_overtime = $normal_overtime + $holiday + $day_67;
                                        $total_emolument = $basic_salary + $total_allowance;
                                        
            
                                        if($ssnit_arrears_type == 'CURRENT_DEDUCTION')
                                        {
                                            if($row_pay_slip['ssf_amount'] != NULL){$ssf_amount = $row_pay_slip['ssf_amount'] + $ssf_employee_arrears;}else{$ssf_amount = 0 + $ssf_employee_arrears;};
                                            $ssf_employer = $row_pay_slip['ssf_employer'] + $ssf_employer_arrears;

                                            $total_deductions = $welfare + $ssf_amount + $tax + $loan_repayment + $salary_advance + 
                                            $absent + $other_deductions + $ssf_employee_arrears;
                                        }
                                        else
                                        {
                                            if($row_pay_slip['ssf_amount'] != NULL){$ssf_amount = $row_pay_slip['ssf_amount'];}else{$ssf_amount = 0;};
                                            $ssf_employer = $row_pay_slip['ssf_employer'];

                                            $total_deductions = $welfare + $ssf_amount + $tax + $loan_repayment + $salary_advance + 
                                            $absent + $other_deductions;
                                        };
                                        
                                        $net_salary = $total_emolument - $total_deductions;

                                        $f_basic_salary = number_format($basic_salary, 2, '.', ',');
                                        $f_fuel_allowance = number_format($fuel_allowance, 2, '.', ',');
                                        $f_clothing_allowance = number_format($clothing_allowance, 2, '.', ',');
                                        $f_other_allowance = number_format($other_allowance, 2, '.', ',');
                                        $f_normal_overtime = number_format($normal_overtime, 2, '.', ',');
                                        $f_holiday = number_format($holiday, 2, '.', ',');
                                        $f_day_67 = number_format($day_67, 2, '.', ',');
                                        $f_welfare = number_format($welfare, 2, '.', ',');
                                        $f_bonus = number_format($bonus, 2, '.', ',');
                                        $f_paid_leave = number_format($paid_leave, 2, '.', ',');
                                        $f_salary_arrears = number_format($salary_arrears, 2, '.', ',');
                                        $f_ssf_employee_arrears = number_format($ssf_employee_arrears, 2, '.', ',');
                                        $f_other_deductions = number_format($other_deductions, 2, '.', ',');
                                        $f_ssf_amount = number_format($ssf_amount, 2, '.', ',');
                                        $f_absent = number_format($absent, 2, '.', ',');
                                        $f_tax = number_format($tax, 2, '.', ',');
                                        $f_salary_advance = number_format($salary_advance, 2, '.', ',');
                                        $f_loan_repayment = number_format($loan_repayment, 2, '.', ',');
                                        $f_total_allowance = number_format($total_allowance, 2, '.', ',');
                                        $f_total_overtime = number_format($total_overtime, 2, '.', ',');
                                        $f_total_emolument = number_format($total_emolument, 2, '.', ',');
                                        $f_total_deductions = number_format($total_deductions, 2, '.', ',');
                                        $f_net_salary = number_format($net_salary, 2, '.', ',');
                            ?>
                                    <tr>
                                        <td><a href="#" id="btn_pay_slip_reprint" data-id="<?php echo $row_pay_slip['pay_slip_id'];?>"
                                              ><?php echo $employee_name;?></a></td> 
                                        <td class="amt-td"><?php echo $f_basic_salary;?></td>
                                        <td class="amt-td"><?php echo $f_fuel_allowance;?></td>
                                        <td class="amt-td"><?php echo $f_clothing_allowance;?></td>
                                        <td class="amt-td"><?php echo $f_other_allowance;?></td>
                                        <td class="amt-td"><?php echo $f_normal_overtime;?></td>
                                        <td class="amt-td"><?php echo $f_day_67;?></td>
                                        <td class="amt-td"><?php echo $f_holiday;?></td>
                                        <td class="amt-td"><?php echo $f_total_overtime;?></td>
                                        <td class="amt-td"><?php echo $f_bonus;?></td>
                                        <td class="amt-td"><?php echo $f_salary_arrears;?></td>
                                        <td class="amt-td"><?php echo $f_paid_leave;?></td>
                                        <td class="amt-td"><?php echo $f_total_allowance;?></td>
                                        <td class="amt-td"><?php echo $f_total_emolument;?></td>
                                        <td class="amt-td"><?php echo $f_welfare;?></td>
                                        <td class="amt-td"><?php echo $f_ssf_amount;?></td>
                                        <td class="amt-td"><?php echo $f_ssf_employee_arrears;?></td>
                                        <td class="amt-td"><?php echo $f_tax;?></td>
                                        <td class="amt-td"><?php echo $f_salary_advance;?></td>
                                        <td class="amt-td"><?php echo $f_loan_repayment;?></td>
                                        <td class="amt-td"><?php echo $f_other_deductions;?></td>
                                        <td class="amt-td"><?php echo $f_absent;?></td>
                                        <td class="amt-td"><?php echo $f_total_deductions;?></td>
                                        <td class="amt-td"><?php echo $f_net_salary;?></td>
        	                            <td class="action-td">
                                            <?php
                                              /*if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Display_Pay_Sheet'] == 'Yes')) 
                                              {
                                                echo '<a href="#" id="btn_display_pay_sheet" data-id="'.$row_pay_slip['pay_slip_id'].'">Display</a> |';
                                              };*/
                                            ?>
                                              <a href="#" id="btn_pay_slip_reprint" data-id="<?php echo $row_pay_slip['pay_slip_id'];?>"
                                              >Print</a>

                                            <?php
                                              /*if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Pay_Sheet'] == 'Yes'))
                                              {
                                                echo '| <a href="#" id="btn_delete_pay_sheet" data-id="'.$row_pay_slip['pay_slip_id'].'">Delete</a>';
                                              };*/
                                            ?>
        	                            </td>
                                    </tr>
                        <?php				
									//CREATOR
										if(isset($row['created_by']) && $row['created_by'] > 0)
                                        {
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
                                        }
                                        else
                                        {
                                            $creator = 'Not Specified';
                                        };

									//ALTER
										if(isset($row['altered_by']) && $row['altered_by'] > 0)
                                        {
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
                                        }
                                        else
                                        {
                                            $alter = 'Not Specified';
                                        };

									//BRANCH
										if(isset($row['branch_id']) && $row['branch_id'] > 0)
                                        {
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
                                        }
                                        else
                                        {
                                            $voucher_branch = 'Not Specified';
                                        };
							  
						echo '<tr>
							  <td class = "action-td" colspan="30"><small>Branch:'.$voucher_branch.': '.$creator.' '.$alter.'</small>
							  </td>
						  </tr>';
                        
                                }
                            }
                            else
                            {
                                    echo 'No Pay Sheet Voucher Not Found';
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/pay_sheet_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>