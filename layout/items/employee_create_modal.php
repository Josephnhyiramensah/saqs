<div 
class="modal fade bd-example-modal-xl" 
id="employee_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="employee_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 90%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="employee_create_modal_header">Employee Setup</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="employee_create_form" method="POST">
					<ul class="nav nav-tabs nav-justified">
						<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#employee_details"><strong>Employee Details</strong></a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#emolument_history"><strong>Emolument History</strong></a></li>
					</ul>
					<div class="tab-content">
						<div id="employee_details" class="tab-pane fade show active">
							<div class="form-row">
								<div class="col-md-3 mb-3">
									<label for="employee_first_name">First Name</label>
									<input type="text" class="form-control bg-light" name="employee_first_name" id="employee_first_name">
									<input type="text" class="form-control bg-light" name="employee_first_nameD" id="employee_first_nameD" disabled="true" hidden="true">
									<input type="hidden" class="form-control bg-light" name="employee_id" id="employee_id">
								</div>
								<div class="col-md-3 mb-3">
									<label for="employee_last_name">Last Name</label>
									<input type="text" class="form-control bg-light" name="employee_last_name" id="employee_last_name">
									<input type="text" class="form-control bg-light" name="employee_last_nameD" id="employee_last_nameD" disabled="true" hidden="true">
								</div>
								<div class="col-md-1 mb-1">
									<label for="employee_sex">Sex</label>
									<select class="form-control" name="employee_sex" id="employee_sex"> 
										<option value="0">Please Select</option>
										<option value="Male">Male</option>
										<option value="Female">Female</option>
									</select>
									<select class="form-control" name="employee_sexD" id="employee_sexD" disabled="true" hidden="true"> 
										<option value="0">Please Select</option>
										<option value="Male">Male</option>
										<option value="Female">Female</option>
									</select>
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_dob">Date of Birth</label>
									<input type="date" class="form-control bg-light" name="employee_dob" id="employee_dob">
									<input type="date" class="form-control bg-light" name="employee_dobD" id="employee_dobD" disabled="true" hidden="true">
								</div>
								<div class="col-md-3 mb-3">
									<label for="employee_email">Email</label>
									<input type="text" class="form-control bg-light" name="employee_email" id="employee_email">
									<input type="text" class="form-control bg-light" name="employee_emailD" id="employee_emailD" disabled="true" hidden="true">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-2 mb-2">
									<label for="employee_branch_id">Location</label>
									<select class="form-control bg-light" name="employee_branch_id" id="employee_branch_id">
										<option value="0">Please Select</option>
										<?php
											$company_id = $_SESSION['company_id'];
											$sql="SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name ASC";
											$result=mysqli_query($con,$sql);
											while($row = mysqli_fetch_array($result))
											{
												echo '<option value = "'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
											};
										?>
									</select>
									<select class="form-control bg-light" name="employee_branch_idD" id="employee_branch_idD" disabled="true" hidden="true">
										<option value="0">Please Select</option>
										<?php
											$company_id = $_SESSION['company_id'];
											$sql="SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name ASC";
											$result=mysqli_query($con,$sql);
											while($row = mysqli_fetch_array($result))
											{
												echo '<option value = "'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
											};
										?>
									</select>
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_position">Position</label>
									<input type="text" class="form-control bg-light" name="employee_position" id="employee_position">
									<input type="text" class="form-control bg-light" name="employee_positionD" id="employee_positionD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_ssf_no">SSF Number</label>
									<input type="text" class="form-control bg-light" name="employee_ssf_no" id="employee_ssf_no">
									<input type="text" class="form-control bg-light" name="employee_ssf_noD" id="employee_ssf_noD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_phone_no">Phone No</label>
									<input type="text" class="form-control bg-light" name="employee_phone_no" id="employee_phone_no">
									<input type="text" class="form-control bg-light" name="employee_phone_noD" id="employee_phone_noD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_date_join">Date Join</label>
									<input type="date" class="form-control bg-light" name="employee_date_join" id="employee_date_join">
									<input type="date" class="form-control bg-light" name="employee_date_joinD" id="employee_date_joinD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_date_exit">Date Exit</label>
									<input type="date" class="form-control bg-light" name="employee_date_exit" id="employee_date_exit">
									<input type="date" class="form-control bg-light" name="employee_date_exitD" id="employee_date_exitD" disabled="true" hidden="true">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-4 mb-4">
									<label for="employee_bank">Bank</label>
									
									<select class="form-control bg-light" name="employee_bank" id="employee_bank"> 
										<option value="0">Please Select</option>
										<?php
											$sql="SELECT * FROM ledgers WHERE company_id = '$company_id' ORDER BY ledger_desc ASC";
											$result=mysqli_query($con,$sql);
											while($row = mysqli_fetch_array($result))
											{
											?>
												<option value = "<?php echo($row['ledger_id'])?>">
													<?php echo($row['ledger_desc'])?>
												</option>
											<?php
											};
										?>
									</select>
									<!--<input type="text" class="form-control bg-light" name="employee_bank" id="employee_bank">
									<input type="text" class="form-control bg-light" name="employee_bankD" id="employee_bankD" disabled="true" hidden="true">-->
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_bank_code">Bank Code</label>
									<input type="text" class="form-control bg-light" name="employee_bank_code" id="employee_bank_code">
									<input type="text" class="form-control bg-light" name="employee_bank_codeD" id="employee_bank_codeD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_bank_branch">Branch</label>
									<input type="text" class="form-control bg-light" name="employee_bank_branch" id="employee_bank_branch">
									<input type="text" class="form-control bg-light" name="employee_bank_branchD" id="employee_bank_branchD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_bank_branch_code">Branch Code</label>
									<input type="text" class="form-control bg-light" name="employee_bank_branch_code" id="employee_bank_branch_code">
									<input type="text" class="form-control bg-light" name="employee_bank_branch_codeD" id="employee_bank_branch_codeD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_bank_account_number">Account Number</label>
									<input type="text" class="form-control bg-light" name="employee_bank_account_number" id="employee_bank_account_number">
									<input type="text" class="form-control bg-light" name="employee_bank_account_numberD" id="employee_bank_account_numberD" disabled="true" hidden="true">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-2 mb-2">
									<label for="employee_basic_salary">Basic Salary</label>
									<input type="text" class="form-control bg-light" name="employee_basic_salary" id="employee_basic_salary">
									<input type="text" class="form-control bg-light" name="employee_basic_salaryD" id="employee_basic_salaryD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_daily_wage">Daily Wage</label>
									<input type="text" class="form-control bg-light" name="employee_daily_wage" id="employee_daily_wage">
									<input type="text" class="form-control bg-light" name="employee_daily_wageD" id="employee_daily_wageD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_hourly_wage">Hourly Wage</label>
									<input type="text" class="form-control bg-light" name="employee_hourly_wage" id="employee_hourly_wage">
									<input type="text" class="form-control bg-light" name="employee_hourly_wageD" id="employee_hourly_wageD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_overtime_rate">Overtime Rate</label>
									<input type="text" class="form-control bg-light" name="employee_overtime_rate" id="employee_overtime_rate">
									<input type="text" class="form-control bg-light" name="employee_overtime_rateD" id="employee_overtime_rateD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_day_67_rate">Day 6/7 Rate</label>
									<input type="text" class="form-control bg-light" name="employee_day_67_rate" id="employee_day_67_rate">
									<input type="text" class="form-control bg-light" name="employee_day_67_rateD" id="employee_day_67_rateD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_holiday_rate">Holiday Rate</label>
									<input type="text" class="form-control bg-light" name="employee_holiday_rate" id="employee_holiday_rate">
									<input type="text" class="form-control bg-light" name="employee_holiday_rateD" id="employee_holiday_rateD" disabled="true" hidden="true">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-2 mb-2">
									<label for="employee_ssf_remark">SSF Apply?</label>
									<select class="form-control bg-light" name="employee_ssf_remark" id="employee_ssf_remark"> 
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									<select class="form-control bg-light" name="employee_ssf_remarkD" id="employee_ssf_remarkD" disabled="true" hidden="true"> 
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_ssf_employer">SSF Employer (13%)</label>
									<input type="text" class="form-control bg-light" name="employee_ssf_employer" id="employee_ssf_employer">
									<input type="text" class="form-control bg-light" name="employee_ssf_employerD" id="employee_ssf_employerD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_ssf_1st_tier">1st Tier (13.5%)</label>
									<input type="text" class="form-control bg-light" name="employee_ssf_1st_tier" id="employee_ssf_1st_tier">
									<input type="text" class="form-control bg-light" name="employee_ssf_1st_tierD" id="employee_ssf_1st_tierD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_ssf_2nd_tier">2nd Tier (5%)</label>
									<input type="text" class="form-control bg-light" name="employee_ssf_2nd_tier" id="employee_ssf_2nd_tier">
									<input type="text" class="form-control bg-light" name="employee_ssf_2nd_tierD" id="employee_ssf_2nd_tierD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_paye_status">Tax Deductible?</label>
									<select class="form-control bg-light" name="employee_paye_status" id="employee_paye_status"> 
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
									<select class="form-control bg-light" name="employee_paye_statusD" id="employee_paye_statusD" disabled="true" hidden="true"> 
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_ghanacard">Ghanacard</label>
									<input type="text" class="form-control bg-light" name="employee_ghanacard" id="employee_ghanacard">
									<input type="text" class="form-control bg-light" name="employee_ghanacardD" id="employee_ghanacardD" disabled="true" hidden="true">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-2 mb-2">
									<label for="employee_fuel_allowance">Fuel Allowance</label>
									<input type="text" class="form-control bg-light" name="employee_fuel_allowance" id="employee_fuel_allowance">
									<input type="text" class="form-control bg-light" name="employee_fuel_allowanceD" id="employee_fuel_allowanceD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_clothing_allowance">Clothing Allowance</label>
									<input type="text" class="form-control bg-light" name="employee_clothing_allowance" id="employee_clothing_allowance">
									<input type="text" class="form-control bg-light" name="employee_clothing_allowanceD" id="employee_clothing_allowanceD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_other_allowance">Other Allowance</label>
									<input type="text" class="form-control bg-light" name="employee_other_allowance" id="employee_other_allowance">
									<input type="text" class="form-control bg-light" name="employee_other_allowanceD" id="employee_other_allowanceD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_total_allowance">Total Allowance</label>
									<input type="text" class="form-control bg-light" name="employee_total_allowance" id="employee_total_allowance">
									<input type="text" class="form-control bg-light" name="employee_total_allowanceD" id="employee_total_allowanceD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_gross_salary">Gross Salary</label>
									<input type="text" class="form-control bg-light" name="employee_gross_salary" id="employee_gross_salary">
									<input type="text" class="form-control bg-light" name="employee_gross_salaryD" id="employee_gross_salaryD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_taxable_income">Taxable Income</label>
									<input type="text" class="form-control bg-light" name="employee_taxable_income" id="employee_taxable_income">
									<input type="text" class="form-control bg-light" name="employee_taxable_incomeD" id="employee_taxable_incomeD" disabled="true" hidden="true">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-2 mb-2">
									<label for="employee_welfare">Welfare</label>
									<input type="text" class="form-control bg-light" name="employee_welfare" id="employee_welfare">
									<input type="text" class="form-control bg-light" name="employee_welfareD" id="employee_welfareD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_other_deductions">Other Deductions</label>
									<input type="text" class="form-control bg-light" name="employee_other_deductions" id="employee_other_deductions">
									<input type="text" class="form-control bg-light" name="employee_other_deductionsD" id="employee_other_deductionsD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_tax">Tax</label>
									<input type="text" class="form-control bg-light" name="employee_tax" id="employee_tax">
									<input type="text" class="form-control bg-light" name="employee_taxD" id="employee_taxD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_ssf_contribution">SSF Employee (5.5%)</label>
									<input type="text" class="form-control bg-light" name="employee_ssf_contribution" id="employee_ssf_contribution">
									<input type="text" class="form-control bg-light" name="employee_ssf_contributionD" id="employee_ssf_contributionD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_total_deduction">Total Deduction</label>
									<input type="text" class="form-control bg-light" name="employee_total_deduction" id="employee_total_deduction">
									<input type="text" class="form-control bg-light" name="employee_total_deductionD" id="employee_total_deductionD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_net_salary">Net Salary</label>
									<input type="text" class="form-control bg-light" name="employee_net_salary" id="employee_net_salary">
									<input type="text" class="form-control bg-light" name="employee_net_salaryD" id="employee_net_salaryD" disabled="true" hidden="true">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-2 mb-2">
									<label for="employee_employment_type">Employment Type</label>
									<select class="form-control bg-light" name="employee_employment_type" id="employee_employment_type"> 
										<option value="REGULAR">REGULAR</option>
										<option value="REGULAR_PENSIONER">REGULAR_PENSIONER</option>
										<option value="SUB-CONTRACTORS">SUB-CONTRACTORS</option>
										<option value="NATIONAL SERVICE">NATIONAL SERVICE</option>
									</select>
									<select class="form-control bg-light" name="employee_employment_typeD" id="employee_employment_typeD" disabled="true" hidden="true"> 
										<option value="REGULAR">REGULAR</option>
										<option value="REGULAR_PENSIONER">REGULAR_PENSIONER</option>
										<option value="SUB-CONTRACTORS">SUB-CONTRACTORS</option>
										<option value="NATIONAL SERVICE">NATIONAL SERVICE</option>
									</select>
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_leave_annual">Annual Leave</label>
									<input type="text" class="form-control bg-light" name="employee_leave_annual" id="employee_leave_annual">
									<input type="text" class="form-control bg-light" name="employee_leave_annualD" id="employee_leave_annualD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_leave_sick">Sick Leave</label>
									<input type="text" class="form-control bg-light" name="employee_leave_sick" id="employee_leave_sick">
									<input type="text" class="form-control bg-light" name="employee_leave_sickD" id="employee_leave_sickD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_leave_maternity">Maternity Leave</label>
									<input type="text" class="form-control bg-light" name="employee_leave_maternity" id="employee_leave_maternity">
									<input type="text" class="form-control bg-light" name="employee_leave_maternityD" id="employee_leave_maternityD" disabled="true" hidden="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="employee_category">Category</label>
									<select class="form-control bg-light" name="employee_category" id="employee_category"> 
										<option value="0">Please Select</option>
										<?php
											$sql="SELECT * FROM payroll_employee_category WHERE company_id = '$company_id' ORDER BY category ASC";
											$result=mysqli_query($con,$sql);
											while($row = mysqli_fetch_array($result))
											{
												echo '<option value = "'.$row['payroll_employee_category_id'].'">'.$row['category'].'</option>';
											};
										?>
									</select>
									<select class="form-control bg-light" name="employee_categoryD" id="employee_categoryD" disabled="true" hidden="true"> 
										<option value="0">Please Select</option>
										<?php
											$sql="SELECT * FROM payroll_employee_category WHERE company_id = '$company_id' ORDER BY category ASC";
											$result=mysqli_query($con,$sql);
											while($row = mysqli_fetch_array($result))
											{
												echo '<option value = "'.$row['payroll_employee_category_id'].'">'.$row['category'].'</option>';
											};
										?>
									</select>
								</div>
								<div class="col-md-2 mb-2" <?php if($_SESSION['user_type_id'] != 2){echo 'hidden="true"';};?>>
									<label for="employee_status">Status</label>
									<select class="form-control bg-light" name="employee_status" id="employee_status"> 
										<option value="Active">Active</option>
										<option value="New_Employee">New_Employee</option>
										<option value="Resigned">Resigned</option>
										<option value="Dismissed">Dismissed</option>
										<option value="Dead">Dead</option>
										<option value="Dormant">Dormant</option>
									</select>
									<select class="form-control bg-light" name="employee_statusD" id="employee_statusD" disabled="true" hidden="true"> 
										<option value="Active">Active</option>
										<option value="New_Employee">New_Employee</option>
										<option value="Resigned">Resigned</option>
										<option value="Dismissed">Dismissed</option>
										<option value="Dead">Dead</option>
										<option value="Dormant">Dormant</option>
									</select>
								</div>
							</div>
						</div>
						<div id="emolument_history" class="tab-pane fade">
							<div class="form-row">
								<div class="col-md-12 mb-12" id="emolument_history_table_div">
								</div>
							</div>
						</div>
					</div>
				    <div class="modal-footer">
				        <button type="button" name="employee_save_btn" id="employee_save_btn" class="btn btn-primary" >Save</button>
				        <button type="button" name="employee_update_btn" id="employee_update_btn" class="btn btn-primary" >Update</button>
				        <button type="submit" name="employee_cancel_btn" id="employee_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>