<div class="modal fade bd-example-modal-lg" id="maternity_leave_modal" tabindex="-1" role="dialog" aria-labelledby="maternity_leave_modal" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="maternity_leave_modal_title">Maternity Leave Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="maternity_leave_body_div">
					
				</div>
				<form id="maternity_leave_form" method="POST">
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="name_of_patient"><small>Patient Name</small></label>
							<input type="text" class="form-control bg-light" name="name_of_patient" id="name_of_patient">
						</div>
						<div class="col-md-6 mb-6">
							<label for="date_of_delivery"><small>Date of Delivery</small></label>
							<input type="date" class="form-control bg-light" name="date_of_delivery" id="date_of_delivery">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="remarks"><small>Remarks</small></label>
							<textarea type="textarea" rows="7"  class="form-control bg-light" name="remarks" id="remarks" value=""></textarea>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="date_of_issue"><small>Date of Issue</small></label>
							<input type="date" class="form-control bg-light" name="date_of_issue" id="date_of_issue">
						</div>
						<div class="col-md-6 mb-6">
							<label for="medical_officer"><small>Medical Officer</small></label>
							<input type="text" class="form-control bg-light" name="medical_officer" id="medical_officer">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
					<input type="hidden" class="form-control bg-light" name="mat_leave_id" id="mat_leave_id">
					<button type="submit" id="maternity_leave_save_btn" name="maternity_leave_save_btn" class="btn btn-primary">Save</button>
					<button type="submit" id="maternity_leave_edit_btn" name="maternity_leave_edit_btn" class="btn btn-primary">Edit</button>
					<button type="submit" id="maternity_leave_update_btn" name="maternity_leave_update_btn" class="btn btn-primary">Update</button>
					<button type="button" id="maternity_leave_cancel_btn" name="maternity_leave_cancel_btn" class="btn btn-secondary">Cancel</button>
			</div>
		</div>
	</div>
</div>