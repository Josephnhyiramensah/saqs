<div 
class="modal fade bd-example-modal-xl" 
id="warehouse_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="warehouse_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="warehouse_create_modal_header">Warehouse Setup</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="warehouse_create_form" method="POST">
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="warehouse_name">Warehouse Description</label>
							<input type="text" class="form-control" name="warehouse_name" id="warehouse_name">
							<input type="hidden" class="form-control" name="warehouse_id" id="warehouse_id">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="warehouse_location">Warehouse Location</label>
							<input type="text" class="form-control" name="warehouse_location" id="warehouse_location">
						</div>
					</div>
				    <div class="modal-footer">
				        <button type="button" name="warehouse_save_btn" id="warehouse_save_btn" class="btn btn-primary" >Save</button>
				        <button type="button" name="warehouse_update_btn" id="warehouse_update_btn" class="btn btn-primary" >Update</button>
				        <button type="submit" name="warehouse_cancel_btn" id="warehouse_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>