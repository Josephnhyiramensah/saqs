<div 
class="modal fade hide bd-example-modal-lg" 
id="stock_item_import_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_item_import_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_item_import_modal_header">Import Stock item</h5>
			</div>
			<div class="modal-body">
				<form id="stock_item_import_modal_form" action="stock_item_import.php" method="POST" enctype="multipart/form-data">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="stock_item_import_file">Upload item CSV file</label>
	                            <input type="file" class="form-control" name="stock_item_import_file" id="stock_item_import_file">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="submit" name="stock_item_import_post_btn" id="stock_item_import_post_btn" class="btn btn-primary">Import</button>
	                    <button type="button" name="stock_item_import_cancel_btn" id="stock_item_import_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>