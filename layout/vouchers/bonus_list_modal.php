<div 
class="modal fade hide bd-example-modal-lg" 
id="bonus_list_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="bonus_list_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="bonus_list_modal_header">Employee Bonus</h5>
			</div>
			<div class="modal-body">
				<form id="bonus_list_modal_form" method="POST">
	                <div class="panel-body">
	                	<div id="bonus_list_modal_warning"></div>
                        <input type="hidden" name="bonus_list_id" class="form-control bg-light" id="bonus_list_id">
                        <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="bonus_list_employee_id">Employee</label>
                        		<input type="hidden" name="bonus_list_employee_id" class="form-control bg-light" id="bonus_list_employee_id">
	                            <select class="form-control bg-light" name="bonus_list_employee_idD" id="bonus_list_employee_idD" disabled>
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
	                            <label for="bonus_list_basic_salary">Basic Salary</label>
	                            <input type="text" name="bonus_list_basic_salary" class="form-control bg-light" id="bonus_list_basic_salary">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="bonus_list_calculation_type">Calculation Type</label>
	                            <input type="hidden" name="bonus_list_calculation_type" class="form-control bg-light" id="bonus_list_calculation_type">
	                            <select class="form-control bg-light" name="bonus_list_calculation_typeD" id="bonus_list_calculation_typeD" disabled>
					                <option value="Percentage_Of_Salary">Percentage_Of_Salary</option>
					                <option value="Flat_Amount">Flat_Amount</option>
					        	</select>
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="bonus_list_percentage">Percentage/Flat Amount</label>
	                            <input type="hidden" name="bonus_list_percentage" class="form-control bg-light" id="bonus_list_percentage">
	                            <input type="text" name="bonus_list_percentageD" class="form-control bg-light" id="bonus_list_percentageD" disabled>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="bonus_list_amount">Bonus Amount</label>
	                            <input type="text" name="bonus_list_amount" class="form-control bg-light" id="bonus_list_amount">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="bonus_list_update_btn" id="bonus_list_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="bonus_list_cancel_btn" id="bonus_list_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>