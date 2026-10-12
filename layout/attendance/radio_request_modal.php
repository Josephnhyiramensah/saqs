<div 
class="modal fade hide bd-example-modal-xl" 
id="radio_request_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="radio_request_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 70%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="radio_request_modal_header">RADIOLOGY REQUEST</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="radio_request_modal_form" method="POST">
				<input type="hidden" name="radio_request_id" class="form-control bg-light" id="radio_request_id">
				<div class="modal-body">
					<div class="form-row">
						<div class="col-md-6 mb-6 form-group">
							<label for="radio_request_patient">Patient Name</label>
							<select class="form-control" name="radio_request_patient" id="radio_request_patient" hidden="true">
								<?php
									$query_patient = "SELECT * FROM patients";
									$result_patient = mysqli_query($con,$query_patient);
									while($row_patient = mysqli_fetch_array($result_patient))
									{
										echo '<option value = "'.$row_patient['patient_id'].'">'.$row_patient['firstName'].' '.$row_patient['lastName'].'</option>';
									};
								?>
							</select>
							<select class="form-control" name="radio_request_patientD" id="radio_request_patientD" disabled="true">
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
							<label for="radio_request_doctor">Doctor</label>
							<input type="text" name="radio_request_doctor" class="form-control bg-light" id="radio_request_doctor">
						</div>
					</div> 
					<div class="form-row">
						<div class="col-md-6 mb-6 form-group">
							<label for="radio_request_age">Age</label>
							<input type="text" name="radio_request_age" class="form-control bg-light" id="radio_request_age">
						</div>
						<div class="col-md-6 mb-6 form-group">
							<label for="radio_request_date">Date</label>
							<input type="date" name="radio_request_date" class="form-control bg-light" id="radio_request_date">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6 form-group">
							<label for="radio_request_test">Radiology</label>
							<textarea type="textarea" rows="6"  class="form-control" name="radio_request_test" id="radio_request_test" value=""></textarea>
						</div>
						<div class="col-md-6 mb-6 form-group">
							<label for="radio_request_diagnosis">Diagnosis</label>
							<textarea type="textarea" rows="6"  class="form-control" name="radio_request_diagnosis" id="radio_request_diagnosis" value=""></textarea>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6 form-group">
							<label for="radio_request_clinical_summary">Clinical Summary</label>
							<textarea type="textarea" rows="6"  class="form-control" name="radio_request_clinical_summary" id="radio_request_clinical_summary" value=""></textarea>
							<input type="hidden" name="lab_request_id" id="lab_request_id">
						</div>
						<div class="col-md-6 mb-6 form-group">
							<label for="radio_request_problem">Problem To Be Resolved</label>
							<textarea type="textarea" rows="6"  class="form-control" name="radio_request_problem" id="radio_request_problem" value=""></textarea>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12 form-group">
							<label for="radio_request_comment">Comment</label>
							<textarea type="textarea" rows="6"  class="form-control" name="radio_request_comment" id="radio_request_comment" value=""></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="radio_request_save" name="radio_request_save"class="btn btn-primary">Save</button>
					<button type="button" id="radio_request_update" name="radio_request_update"class="btn btn-primary">Update</button>
					<button type="button" id="radio_request_cancel" name="radio_request_cancel"class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
	        </form>
		</div>
	</div>
</div>