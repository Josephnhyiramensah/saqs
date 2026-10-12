<div 
class="modal fade bd-example-modal-xl" 
id="labparamdropdownaddmodal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="labparamdropdownaddmodal" 
aria-hidden="true">
  	<div class="modal-dialog modal-xl" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="lab_param_dropdown_add_modal_header">Add Lab Parameter Dropdown Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
      		</div>
        	<div class="modal-body">
              <div class="clearfix"></div>
			  <form id="lab_param_dropdown_add_form" method="POST">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="Parameter Dropdown">Parameter Dropdown Item</label>
								<input type="text" class="form-control" name="lab_param_dropdown" id="lab_param_dropdown" value="">
							</div>
						</div>
					</div>
					<div id="lab_param_add_form_footer" class="modal-footer">
						<input type="hidden" class="form-control" name="lab_param_dd_id" id="lab_param_dd_id" value="">
						<input type="hidden" class="form-control" name="lab_param_id_dd" id="lab_param_id_dd" value="">
						<button type="button" name="lab_param_save_btn_dd" id="lab_param_save_btn_dd" class="btn btn-primary" >Save</button>
						<button type="button" name="lab_param_update_btn_dd" id="lab_param_update_btn_dd" class="btn btn-primary" >Update</button>
						<button type="submit" name="lab_param_cancel_btn_dd" id="lab_param_cancel_btn_dd" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</form>
        	</div>
    	</div>
  	</div>
</div>