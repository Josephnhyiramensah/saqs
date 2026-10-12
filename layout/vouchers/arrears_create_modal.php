<div 
class="modal fade hide bd-example-modal-xl" 
id="arrears_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="arrears_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 60%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="arrears_create_modal_header">Arrears Setup</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="arrears_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-10 mb-10 form-group">
	                            <label for="arrears_employee">Employee</label>
								<select class="form-control bg-light" name="arrears_employee" id="arrears_employee"> 
									<option value="0">Please Select</option>
									<?php
										$sql="SELECT * FROM payroll_employee WHERE company_id = '$company_id' AND status='Active' ORDER BY first_name ASC";
										$result = mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value = "'.$row['employee_id'].'">
												'.$row['first_name'].' '.$row['last_name'].' ('.$row['phone_no'].')
											</option>';
										};
									?>
								</select>
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="arrears_date">Date</label>
	                            <input type="hidden" name="arrears_id" class="form-control bg-light" id="arrears_id">
	                            <input type="date" class="form-control bg-light" name="arrears_date" id="arrears_date" value="<?php echo $date_today;?>">
	                        </div>
	                	</div>
	                    <div class="form-row">
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="arrears_salary_arrears">Salary Arrears</label>
	                            <input type="text" class="form-control bg-light" name="arrears_salary_arrears" id="arrears_salary_arrears">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="arrears_tier_1_arrears">Tier 1 Arrears</label>
	                            <input type="text" name="arrears_tier_1_arrears" class="form-control bg-light" id="arrears_tier_1_arrears">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="arrears_tier_2_arrears">Tier 2 Arrears</label>
	                            <input type="text" name="arrears_tier_2_arrears" class="form-control bg-light" id="arrears_tier_2_arrears">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="arrears_ssf_employee_arrears">SSF Employee Arrears</label>
	                            <input type="text" name="arrears_ssf_employee_arrears" class="form-control bg-light" id="arrears_ssf_employee_arrears">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="arrears_ssf_employer_arrears">SSF Employer Arrears</label>
	                            <input type="text" name="arrears_ssf_employer_arrears" class="form-control bg-light" id="arrears_ssf_employer_arrears">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="arrears_ssnit_arrears_type">SSNIT Arrears Type</label>
								<select class="form-control bg-light" name="arrears_ssnit_arrears_type" id="arrears_ssnit_arrears_type">
									<option value="PREVIOUS_DEDUCTION">PREVIOUS_DEDUCTION</option>
									<option value="CURRENT_DEDUCTION">CURRENT_DEDUCTION</option>
								</select>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="arrears_narration">Narration</label>
	                            <textarea type="text" class="form-control bg-light" name="arrears_narration" id="arrears_narration" rows="4"></textarea>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="arrears_save_btn" id="arrears_save_btn" class="btn btn-primary">Save</button>
	                    <button type="button" name="arrears_update_btn" id="arrears_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="arrears_cancel_btn" id="arrears_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
          		<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
			</div>
		</div>
	</div>
</div>