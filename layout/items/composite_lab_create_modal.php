<div 
class="modal fade bd-example-modal-lg" 
id="composite_lab_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="composite_lab_create_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        	<h5 class="modal-title m-0 font-weight-bold text-primary" id="composite_lab_create_modal_header">Composite Laboratory Setup</h5>
        </div>
        <div class="modal-body">
			<form id="composite_lab_create_form" method="POST">
				<div class="panel-body">
					<div class="form-row">
						<div class="col-md-9 mb-9">
							<label for="composite_lab">Description</label>
							<input type="hidden" class="form-control" name="composite_lab_id" id="composite_lab_id">
							<input type="text" class="form-control" name="composite_lab" id="composite_lab">
						</div>
						<div class="col-md-3 mb-3">
							<label for="composite_lab_price">Price</label>
							<input type="text" class="form-control" name="composite_lab_price" id="composite_lab_price">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" name="composite_lab_save_btn" id="composite_lab_save_btn" class="btn btn-primary" >Save</button>
					<button type="button" name="composite_lab_update_btn" id="composite_lab_update_btn" class="btn btn-primary" >Update</button>
					<button type="submit" name="composite_lab_cancel_btn" id="composite_lab_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>
        </div>
	   </div>
  </div>
</div>