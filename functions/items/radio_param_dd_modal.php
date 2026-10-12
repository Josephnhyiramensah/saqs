<div 
class="modal fade bd-example-modal-md" 
id="radio_param_dd_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="radio_param_dd_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="radio_param_dd_modal_header">Parameter Dropdown Setup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		    <div class="clearfix"></div>
        <form id="radio_param_dd_form" method="POST">
          <div class="panel-body">
  					<div class="form-row">
  						<div class="col-md-12 mb-12">
  							<label for="param_dropdown">Parameter Dropdown</label>
  							<input type="text" class="form-control" name="param_dropdown" id="param_dropdown">
  							<input type="hidden" class="form-control" name="param_dd_param_id" id="param_dd_param_id">
                <input type="hidden" class="form-control" name="param_dd_radio_id" id="param_dd_radio_id">
                <input type="hidden" class="form-control" name="param_dd_id" id="param_dd_id">
  						</div>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" name="param_dd_save_btn" id="param_dd_save_btn" class="btn btn-primary" >Save</button>
          <button type="button" name="param_dd_update_btn" id="param_dd_update_btn" class="btn btn-primary">Update</button>
          <button type="submit" name="param_dd_cancel_btn" id="param_dd_cancel_btn" class="btn btn-danger">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>

