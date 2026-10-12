<div 
class="modal fade hide bd-example-modal-xl" 
id="excuse_duty_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="excuse_duty_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 50%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="excuse_duty_modal_header">EXCUSE DUTY</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="excuse_duty_modal_form" method="POST">
				<div class="modal-body">
					<div class="form-row">
						<div class="col-md-6 mb-6 form-group">
							<label for="excuse_duty_patient">Patient Name</label>
							<select class="form-control" name="excuse_duty_patient" id="excuse_duty_patient" hidden="true">
								<?php
									$query_patient = "SELECT * FROM patients";
									$result_patient = mysqli_query($con,$query_patient);
									while($row_patient = mysqli_fetch_array($result_patient))
									{
										echo '<option value = "'.$row_patient['patient_id'].'">'.$row_patient['firstName'].' '.$row_patient['lastName'].'</option>';
									};
								?>
							</select>
							<select class="form-control" name="excuse_duty_patientD" id="excuse_duty_patientD" disabled="true">
								<?php
									$query_patient = "SELECT * FROM patients";
									$result_patient = mysqli_query($con,$query_patient);
									while($row_patient = mysqli_fetch_array($result_patient))
									{
										echo '<option value = "'.$row_patient['patient_id'].'">'.$row_patient['firstName'].' '.$row_patient['lastName'].'</option>';
									};
								?>
							</select>
						</div>
						<div class="col-md-6 mb-6 form-group">
							<label for="excuse_duty_doctor">Doctor</label>
							<select class="form-control" name="excuse_duty_doctor" id="excuse_duty_doctor">
								<?php
									$query_user = "SELECT * FROM users WHERE user_type_id = 6";
									$result_user = mysqli_query($con,$query_user);
									while($row_user = mysqli_fetch_array($result_user))
									{
										echo '<option value = "'.$row_user['id'].'">'.$row_user['first_name'].'</option>';
									};
								?>
							</select>
						</div>
					</div> 
					<div class="form-row">
						<div class="col-md-6 mb-6 form-group">
							<label for="excuse_duty_diagnosis">Diagnosis</label>
							<textarea type="textarea" rows="6"  class="form-control" name="excuse_duty_diagnosis" id="excuse_duty_diagnosis" value=""></textarea>
						</div>
						<div class="col-md-6 mb-6 form-group">
							<label for="excuse_duty_date">Date</label>
							<input type="date" name="excuse_duty_date" class="form-control bg-light" id="excuse_duty_date">
							<label for="excuse_duty_date_admit">Admission Date</label>
							<input type="date" name="excuse_duty_date_admit" class="form-control bg-light" id="excuse_duty_date_admit">
							<label for="excuse_duty_date_discharge">Discharged Date</label>
							<input type="date" name="excuse_duty_date_discharge" class="form-control bg-light" id="excuse_duty_date_discharge">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12 form-group">
							<label for="excuse_duty_remarks">Remarks</label>
							<textarea type="textarea" rows="3"  class="form-control" name="excuse_duty_remarks" id="excuse_duty_remarks" value=""></textarea>
							<input type="hidden" name="excuse_duty_id" id="excuse_duty_id">
						</div>
					</div> 
				</div>
				<div class="modal-footer">
					<button type="button" id="excuse_duty_save" name="excuse_duty_save"class="btn btn-primary">Save</button>
					<button type="button" id="excuse_duty_update" name="excuse_duty_update"class="btn btn-primary">Update</button>
					<button type="button" id="excuse_duty_cancel" name="excuse_duty_cancel"class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
	        </form>
		</div>
	</div>
</div>