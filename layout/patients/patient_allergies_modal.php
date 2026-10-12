<div 
class="modal fade bd-example-modal-m" 
id="patient_allergies_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="patient_allergies_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-m" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="patient_allergies_modal_header">Allergies Update</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="patient_allergies_form" method="POST">
        <div class="modal-body">
  		<div class="clearfix"></div>
      		<div class="panel-body">
				<div class="form-row">
					<div class="col-md-12 mb-12">
						<label for="allergies">Allergies</label>
						<textarea type="textarea" rows="7"  class="form-control" name="allergies" id="allergies"></textarea>
						<input type="hidden" class="form-control" name="allergies_patient_id" id="allergies_patient_id">
					</div>
				</div>
			</div>
	        <div class="modal-footer">
	            <button type="button" name="allergies_save_btn" id="allergies_save_btn" class="btn btn-primary" >Save</button>
	            <button type="button" name="allergies_update_btn" id="allergies_update_btn" class="btn btn-primary" >Update</button>
	            <button type="submit" name="allergies_cancel_btn" id="allergies_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	        </div>
        </div>
      </form>
    </div>
  </div>
</div>
