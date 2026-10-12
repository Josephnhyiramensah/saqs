<div 
class="modal fade hide bd-example-modal-lg" 
id="lab_occurance_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="lab_occurance_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="lab_occurance_modal_header">Registers</h5>
			</div>
			<div class="modal-body">
				<form id="lab_occurance_modal_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
							<div class="col-md-12 mb-12 form-group">
								<label for="lab_occurance_branch">Branch</label>
								<select class="form-control bg-light" name="lab_occurance_branch" id="lab_occurance_branch"> 
									<option value="ALL">ALL</option>
									<?php
										$branch_id = $_SESSION['branch_id'];
										if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
										{
											$sql="SELECT * FROM branch ORDER BY branch_name ASC";
										}
										else
										{
											$sql="SELECT * FROM branch WHERE branch_id='$branch_id' ORDER BY branch_name ASC";
										};
										$result = mysqli_query($con, $sql);
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
								<label for="lab_occurance_type">Type</label>
								<select class="form-control bg-light" name="lab_occurance_type" id="lab_occurance_type"> 
									<option value="LAB_OCCURANCE">LAB_OCCURANCE</option>
									<option value="LAB_REGISTER">LAB_REGISTER</option>
									<option value="DELIVERY_REGISTER">DELIVERY_REGISTER</option>
									<option value="ANC_REGISTER">ANC_REGISTER</option>
									<option value="DETENTION_REGISTER">DETENTION_REGISTER</option>
									<option value="PROCEDURE_REGISTER">PROCEDURE_REGISTER</option>
									<option value="PROCEDURE_OCCURANCE">PROCEDURE_OCCURANCE</option>
									<option value="CIRCUMCISION_REGISTER">CIRCUMCISION_REGISTER</option>
									<option value="OPD_REGISTER">OPD_REGISTER</option>
									<option value="IPD_REGISTER">IPD_REGISTER</option>
									<option value="WARD_STATE">WARD_STATE</option>
								</select>
							</div>
		                </div>
		                <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <input type="hidden" name="lab_occurance_company_id" class="form-control bg-light" id="lab_occurance_company_id">
	                            <input type="hidden" name="lab_occurance_user_id" class="form-control bg-light" id="lab_occurance_user_id">
	                            <input type="hidden" name="lab_occurance_user_super_id" class="form-control bg-light" id="lab_occurance_user_super_id">
	                            <label for="lab_occurance_start_date">Start Date</label>
	                            <input type="date" name="lab_occurance_start_date" class="form-control bg-light" id="lab_occurance_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="lab_occurance_end_date">End Date</label>
	                            <input type="date" name="lab_occurance_end_date" class="form-control bg-light" id="lab_occurance_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="lab_occurance_ok_btn" id="lab_occurance_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="lab_occurance_cancel_btn" id="lab_occurance_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>