<div 
class="modal fade hide bd-example-modal-lg" 
id="employee_time_sheet_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="employee_time_sheet_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="employee_time_sheet_modal_header">Employee Time Sheet</h5>
			</div>
			<div class="modal-body">
				<form id="employee_time_sheet_modal_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
							<div id="employee_time_sheet_modal_warning"></div>
							<div class="col-md-12 mb-12 form-group">
								<label for="employee_time_sheet_branch_id">Branch</label>
								<select class="form-control bg-light" name="employee_time_sheet_branch_id" id="employee_time_sheet_branch_id"> 
									<option value="0">Please Select</option>
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
		                </div>
		                <div class="form-row">
		                        <div class="col-md-12 mb-12 form-group" id="employee_time_sheet_employee_id_div">
		                            <label for="employee_time_sheet_employee_id">Employee</label>
	                            	<input type="text" name="employee_time_sheet_employee_id" class="form-control bg-light" id="employee_time_sheet_employee_id">
		                        </div>
		                </div>
		                <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="employee_time_sheet_start_date">Start Date</label>
	                            <input type="date" name="employee_time_sheet_start_date" class="form-control bg-light" id="employee_time_sheet_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="employee_time_sheet_end_date">End Date</label>
	                            <input type="date" name="employee_time_sheet_end_date" class="form-control bg-light" id="employee_time_sheet_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="employee_time_sheet_ok_btn" id="employee_time_sheet_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="employee_time_sheet_cancel_btn" id="employee_time_sheet_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>