<div 
class="modal fade hide bd-example-modal-lg" 
id="patient_import_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="patient_import_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="patient_import_modal_header">Import Patient</h5>
			</div>
			<div class="modal-body">
				<form id="patient_import_modal_form" action="patient_import.php" method="POST" enctype="multipart/form-data">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="patient_import_file">Upload item CSV file</label>
	                            <input type="file" class="form-control" name="patient_import_file" id="patient_import_file">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="submit" name="patient_import_post_btn" id="patient_import_post_btn" class="btn btn-primary">Import</button>
	                    <button type="button" name="patient_import_cancel_btn" id="patient_import_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>