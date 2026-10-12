<div 
class="modal fade hide bd-example-modal-lg" 
id="pay_sheet_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="pay_sheet_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="pay_sheet_create_modal_header">Create Pay Sheet</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="pay_sheet_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row text-center">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="pay_sheet_start_date">Start Date</label>
	                            <input type="date" class="form-control  text-center bg-light" name="pay_sheet_start_date" id="pay_sheet_start_date">
	                        </div>
	                    </div>
	                    <div class="form-row text-center">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="pay_sheet_end_date">End Date</label>
	                            <input type="date" class="form-control  text-center bg-light" name="pay_sheet_end_date" id="pay_sheet_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="text-center">
	                    <button type="button" name="pay_sheet_save_btn" id="pay_sheet_save_btn" class="btn btn-primary">Execute</button>
	                    <button type="submit" name="pay_sheet_cancel_btn" id="pay_sheet_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
			</div>
		</div>
	</div>
</div>