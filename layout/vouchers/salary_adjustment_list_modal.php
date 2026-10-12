<div 
class="modal fade hide bd-example-modal-lg" 
id="salary_adjustment_list_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="salary_adjustment_list_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="salary_adjustment_list_modal_header">Employee Salary Adjustment</h5>
			</div>
			<div class="modal-body">
				<form id="salary_adjustment_list_modal_form" method="POST">
	                <div class="panel-body">
	                	<div id="salary_adjustment_list_modal_warning"></div>
                        <input type="hidden" name="salary_adjustment_list_id" class="form-control bg-light" id="salary_adjustment_list_id">
                        <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="salary_adjustment_list_employee_id">Employee</label>
                        		<input type="hidden" name="salary_adjustment_list_employee_id" class="form-control bg-light" id="salary_adjustment_list_employee_id">
	                            <select class="form-control bg-light" name="salary_adjustment_list_employee_idD" id="salary_adjustment_list_employee_idD" disabled>
					                <?php
										$sql="SELECT * FROM payroll_employee";
										$result = mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value = "'.$row['employee_id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
										};
									?>
					        	</select>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="salary_adjustment_list_basic_salary">Basic Salary</label>
	                            <input type="text" name="salary_adjustment_list_basic_salary" class="form-control bg-light" id="salary_adjustment_list_basic_salary">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="salary_adjustment_list_percentage">Percentage/Flat Amount</label>
	                            <input type="hidden" name="salary_adjustment_list_percentage" class="form-control bg-light" id="salary_adjustment_list_percentage">
	                            <input type="text" name="salary_adjustment_list_percentageD" class="form-control bg-light" id="salary_adjustment_list_percentageD" disabled>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="salary_adjustment_list_amount">Salary Adjustment Amount</label>
	                            <input type="text" name="salary_adjustment_list_amount" class="form-control bg-light" id="salary_adjustment_list_amount">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="salary_adjustment_list_update_btn" id="salary_adjustment_list_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="salary_adjustment_list_cancel_btn" id="salary_adjustment_list_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>