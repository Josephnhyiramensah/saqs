<div 
class="modal fade hide bd-example-modal-lg" 
id="doctors_attend_register_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="doctors_attend_register_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="doctors_attend_register_modal_header">Doctors Attendance Register</h5>
			</div>
			<div class="modal-body">
				<form id="doctors_attend_register_modal_form" method="POST">
	                <div class="panel-body">
	                	<div id="doctors_attend_register_modal_warning"></div>
                        <input type="hidden" name="doctors_attend_register_company_id" class="form-control bg-light" id="doctors_attend_register_company_id">
                        <input type="hidden" name="doctors_attend_register_user_id" class="form-control bg-light" id="doctors_attend_register_user_id">
                        <input type="hidden" name="doctors_attend_register_user_super_id" class="form-control bg-light" id="doctors_attend_register_user_super_id">
                        
	                    <div class="form-row">
							<div class="col-md-12 mb-12 form-group">
								<label for="doctors_attend_register_branch">Branch</label>
								<select class="form-control bg-light" name="doctors_attend_register_branch" id="doctors_attend_register_branch"> 
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
	                            <label for="doctors_attend_register_doctor">Doctor</label>
	                           	<select class="form-control" name="doctors_attend_register_doctor" id="doctors_attend_register_doctor"> 
									<option value="ALL">ALL</option>
										<?php
											$sql="SELECT * FROM users WHERE user_type_id = 6 ORDER BY full_name ASC";
											$result = mysqli_query($con,$sql);
											while($row = mysqli_fetch_array($result))
											{
												echo '<option value = "'.$row['id'].'">'.$row['full_name'].'</option>';
											};
										?>
								</select>
							</div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="doctors_attend_register_start_date">Start Date</label>
	                            <input type="date" name="doctors_attend_register_start_date" class="form-control bg-light" id="doctors_attend_register_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="doctors_attend_register_end_date">End Date</label>
	                            <input type="date" name="doctors_attend_register_end_date" class="form-control bg-light" id="doctors_attend_register_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="doctors_attend_register_ok_btn" id="doctors_attend_register_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="doctors_attend_register_cancel_btn" id="doctors_attend_register_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>