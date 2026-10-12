<div 
class="modal fade bd-example-modal-m" 
id="patient_age_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="patient_age_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-m" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="patient_age_modal_header">Age Update</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="patient_age_form" method="POST">
        <div class="modal-body">
  		<div class="clearfix"></div>
      		<div class="panel-body">
				<div class="form-row">
					<div class="col-md-12 mb-12">
						<label for="date_of_birth_patient">Date of Birth</label>
						<input type="date" class="form-control" name="date_of_birth_patient" id="date_of_birth_patient">
						<input type="hidden" class="form-control" name="age_patient_id" id="age_patient_id">
						<input type="hidden" class="form-control" name="age_attend_id" id="age_attend_id">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-12 mb-12">
						<label for="age_patient">Age</label>
						<input type="text" class="form-control" name="age_patient" id="age_patient">
					</div>
				</div>
			</div>
	        <div class="modal-footer">
	            <button type="button" name="age_save_btn" id="age_save_btn" class="btn btn-primary" >Save</button>
	            <button type="button" name="age_update_btn" id="age_update_btn" class="btn btn-primary" >Update</button>
	            <button type="submit" name="age_cancel_btn" id="age_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	        </div>
        </div>
      </form>
    </div>
  </div>
</div>
