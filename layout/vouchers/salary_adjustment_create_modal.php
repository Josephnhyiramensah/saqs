<div 
class="modal fade hide bd-example-modal-xl" 
id="salary_adjustment_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="salary_adjustment_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 30%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="salary_adjustment_create_modal_header">Salary Adjustment Creation</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="salary_adjustment_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="salary_adjustment_branch_id">Site</label>
								<select class="form-control bg-light" name="salary_adjustment_branch_id" id="salary_adjustment_branch_id"> 
									<option value="ALL">ALL</option>
									<?php
										$sql="SELECT * FROM branch ORDER BY branch_name ASC";
										$result = mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value = "'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
										};
									?>
								</select>
	                        </div>
	                	</div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="salary_adjustment_dept_id">Department</label>
								<select class="form-control bg-light" name="salary_adjustment_dept_id" id="salary_adjustment_dept_id"> 
									<option value="ALL">ALL</option>
									<?php
										$sql="SELECT * FROM department WHERE company_id = '$company_id' ORDER BY department ASC";
										$result = mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value = "'.$row['dept_id'].'">'.$row['department'].'</option>';
										};
									?>
								</select>
	                        </div>
	                	</div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group" id="salary_adjustment_employee_div">
	                            <label for="salary_adjustment_employee">Employee</label>
								<select class="form-control bg-light" name="salary_adjustment_employee" id="salary_adjustment_employee"> 
									<option value="ALL">ALL</option>
									<?php
										/*$sql="SELECT * FROM payroll_employee WHERE company_id = '$company_id'
										AND status = 'Active' ORDER BY first_name ASC";
										$result = mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value = "'.$row['employee_id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
										};*/
									?>
								</select>
	                        </div>
	                	</div>
	                    <div class="form-row">
	                        <div class="col-md-6 mb-6 form-group">
	                            <label for="salary_adjustment_percentage">Percentage (e.g. 0.10 for 10%)</label>
	                            <input type="text" class="form-control bg-light" name="salary_adjustment_percentage" id="salary_adjustment_percentage">
	                        </div>
	                        <div class="col-md-6 mb-6 form-group">
	                            <label for="salary_adjustment_date">Date</label>
	                            <input type="hidden" name="salary_adjustment_id" class="form-control bg-light" id="salary_adjustment_id">
	                            <input type="date" class="form-control bg-light" name="salary_adjustment_date" id="salary_adjustment_date" value="<?php echo $date_today;?>">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="salary_adjustment_narration">Narration</label>
	                            <textarea type="text" class="form-control bg-light" name="salary_adjustment_narration" id="salary_adjustment_narration" rows="4"></textarea>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="salary_adjustment_save_btn" id="salary_adjustment_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="salary_adjustment_update_btn" id="salary_adjustment_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="salary_adjustment_cancel_btn" id="salary_adjustment_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
          		<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
			</div>
		</div>
	</div>
</div>