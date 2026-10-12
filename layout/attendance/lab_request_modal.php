<div 
class="modal fade hide bd-example-modal-xl" 
id="lab_request_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="lab_request_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 70%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="lab_request_modal_header">LABORATORY REQUEST</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="lab_request_modal_form" method="POST">
				<div class="modal-body">
					<div class="form-row">
						<div class="col-md-6 mb-6 form-group">
							<label for="lab_request_patient">Patient Name</label>
							<select class="form-control" name="lab_request_patient" id="lab_request_patient" hidden="true">
								<?php
									$query_patient = "SELECT * FROM patients";
									$result_patient = mysqli_query($con,$query_patient);
									while($row_patient = mysqli_fetch_array($result_patient))
									{
										echo '<option value = "'.$row_patient['patient_id'].'">'.$row_patient['firstName'].' '.$row_patient['lastName'].'</option>';
									};
								?>
							</select>
							<select class="form-control" name="lab_request_patientD" id="lab_request_patientD" disabled="true">
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
							<label for="lab_request_doctor">Doctor</label>
							<input type="text" name="lab_request_doctor" class="form-control bg-light" id="lab_request_doctor">
						</div>
					</div> 
					<div class="form-row">
						<div class="col-md-4 mb-4 form-group">
							<label for="lab_request_age">Age</label>
							<input type="text" name="lab_request_age" class="form-control bg-light" id="lab_request_age">
						</div>
						<div class="col-md-4 mb-4 form-group">
							<label for="lab_request_gender">Gender</label>
							<select class="form-control" name="lab_request_gender" id="lab_request_gender" hidden="true">
								<?php
									$query_gender = "SELECT * FROM gender";
									$result_gender = mysqli_query($con,$query_gender);
									while($row_gender = mysqli_fetch_array($result_gender))
									{
										echo '<option value = "'.$row_gender['gender_id'].'">'.$row_gender['gender'].'</option>';
									};
								?>
							</select>
							<select class="form-control" name="lab_request_genderD" id="lab_request_genderD" disabled="true">
								<?php
									$query_gender = "SELECT * FROM gender";
									$result_gender = mysqli_query($con,$query_gender);
									while($row_gender = mysqli_fetch_array($result_gender))
									{
										echo '<option value = "'.$row_gender['gender_id'].'">'.$row_gender['gender'].'</option>';
									};
								?>
							</select>
						</div>
						<div class="col-md-4 mb-4 form-group">
							<label for="lab_request_date">Date</label>
							<input type="date" name="lab_request_date" class="form-control bg-light" id="lab_request_date">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6 form-group">
							<label for="lab_request_test">Laboratory Test</label>
							<textarea type="textarea" rows="6"  class="form-control" name="lab_request_test" id="lab_request_test" value=""></textarea>
						</div>
						<div class="col-md-4 mb-4 form-group">
							<label for="lab_request_specimen">Specimen</label>
							<textarea type="textarea" rows="6"  class="form-control" name="lab_request_specimen" id="lab_request_specimen" value=""></textarea>
						</div>
						<div class="col-md-2 mb-2 form-group">
							<label for="lab_request_specimen_date">Specimen Date</label>
							<textarea type="textarea" rows="6"  class="form-control" name="lab_request_specimen_date" id="lab_request_specimen_date" value=""></textarea>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12 form-group">
							<label for="lab_request_diagnosis">Diagnosis</label>
							<textarea type="textarea" rows="6"  class="form-control" name="lab_request_diagnosis" id="lab_request_diagnosis" value=""></textarea>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12 form-group">
							<label for="lab_request_clinical_summary">Clinical Summary</label>
							<textarea type="textarea" rows="6"  class="form-control" name="lab_request_clinical_summary" id="lab_request_clinical_summary" value=""></textarea>
							<input type="hidden" name="lab_request_id" id="lab_request_id">
						</div>
					</div> 
				</div>
				<div class="modal-footer">
					<button type="button" id="lab_request_save" name="lab_request_save"class="btn btn-primary">Save</button>
					<button type="button" id="lab_request_update" name="lab_request_update"class="btn btn-primary">Update</button>
					<button type="button" id="lab_request_cancel" name="lab_request_cancel"class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
	        </form>
		</div>
	</div>
</div>