<div 
class="modal fade bd-example-modal-xl" 
id="nhis_scheme_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="nhis_scheme_create_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="nhis_scheme_create_modal_header">NHIS Scheme Setup</h5>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
      <form id="nhis_scheme_create_form" method="POST">
        <div class="modal-body">
  		<div class="clearfix"></div>
      		<div class="panel-body">
					<div class="form-row">
						<div class="col-md-8 mb-8">
							<label for="scheme_name">Scheme Name</label>
							<input type="text" class="form-control" name="scheme_name" id="scheme_name">
							<input type="hidden" class="form-control" name="scheme_id" id="scheme_id">
						</div>
						<div class="col-md-2 mb-2">
							<label for="scheme_code">Scheme Code</label>
							<input type="text" class="form-control" name="scheme_code" id="scheme_code">
						</div>
						<div class="col-md-2 mb-2">
							<label for="regional_code">Regional Code</label>
							<input type="text" class="form-control" name="regional_code" id="regional_code">
						</div>
					</div>
			</div>
	        <div class="modal-footer">
	            <button type="button" name="nhis_scheme_save_btn" id="nhis_scheme_save_btn" class="btn btn-primary" >Save</button>
	            <button type="button" name="nhis_scheme_update_btn" id="nhis_scheme_update_btn" class="btn btn-primary" >Update</button>
	            <button type="submit" name="nhis_scheme_cancel_btn" id="nhis_scheme_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	        </div>
        </div>
      </form>
    </div>
  </div>
</div>