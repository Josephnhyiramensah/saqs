<div 
class="modal fade bd-example-modal-lg" 
id="radio_param_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="radio_param_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="radio_param_modal_header">Radiology Parameter Setup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		    <div class="clearfix"></div>
        <form id="radio_param_form" method="POST">
          <div class="panel-body">
  					<div class="form-row">
  						<div class="col-md-12 mb-12">
  							<label for="radio_param">Parameter</label>
  							<input type="text" class="form-control" name="radio_param" id="radio_param">
  							<input type="hidden" class="form-control" name="radio_param_id" id="radio_param_id">
                <input type="hidden" class="form-control" name="param_radio_id" id="param_radio_id">
  						</div>
            </div>
            <div class="form-row">
              <div class="col-md-12 mb-12">
                <label for="param_comment">Comment</label>
                <textarea type="textarea" rows="4"  class="form-control" name="param_comment" id="param_comment" value=""></textarea>
              </div>
  					</div>
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" name="param_save_btn" id="param_save_btn" class="btn btn-primary" >Save</button>
          <button type="button" name="param_update_btn" id="param_update_btn" class="btn btn-primary" >Update</button>
          <button type="submit" name="param_cancel_btn" id="param_cancel_btn" class="btn btn-danger">Cancel</button>
        </div>
        <div id="radio_param_dd_table_div">
            <div class="float-left">
              <button class="btn-primary" id="add_radio_param_dd_icon"><i class="fas fa-plus"></i></button>
            </div>
            <div class="table-responsive" id="radio_param_dd_table"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('radio_param_dd_modal.php');?>