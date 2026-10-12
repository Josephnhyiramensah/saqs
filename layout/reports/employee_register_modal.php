<div 
class="modal fade hide bd-example-modal-lg" 
id="employee_register_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="employee_register_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="employee_register_modal_header">Employee Time Sheet</h5>
			</div>
			<div class="modal-body">
				<form id="employee_register_modal_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
							<div id="employee_register_modal_warning"></div>
							<div class="col-md-12 mb-12 form-group">
								<label for="employee_register_branch_id">Branch</label>
								<select class="form-control bg-light" name="employee_register_branch_id" id="employee_register_branch_id"> 
									<option value="ALL">ALL</option>
										<?php
											$company_id = $_SESSION['company_id'];
											$sql="SELECT * FROM branch WHERE company_id = '$company_id'
											ORDER BY branch_name ASC";
											$result = mysqli_query($con,$sql);
											while($row = mysqli_fetch_array($result))
											{
												echo'<option value = "'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
											};
										?>
								</select>
							</div>
							<div class="col-md-12 mb-12 form-group">
								<label for="employee_register_department">Department</label>
								<select class="form-control bg-light" name="employee_register_department" id="employee_register_department"> 
									<?php
									echo '<option value="ALL">ALL</option>';
									$company_id = $_SESSION['company_id'];
									$sql="SELECT * FROM department WHERE company_id = '$company_id' ORDER BY department ASC";
									$result=mysqli_query($con,$sql);
									while($row = mysqli_fetch_array($result))
									{
										echo '<option value = "'.$row['dept_id'].'">'.$row['department'].'</option>';
									};
									?>
								</select>
							</div>
							<div class="col-md-12 mb-12 form-group">
								<label for="employee_register_status">Status</label>
								<select class="form-control bg-light" name="employee_register_status" id="employee_register_status"> 
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
	                <div class="modal-footer">
	                    <button type="button" name="employee_register_ok_btn" id="employee_register_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="employee_register_cancel_btn" id="employee_register_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>