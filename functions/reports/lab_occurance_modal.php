<div 
class="modal fade hide bd-example-modal-lg" 
id="lab_occurance_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="lab_occurance_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="lab_occurance_modal_header">Lab Test Occurance</h5>
			</div>
			<div class="modal-body">
				<form id="lab_occurance_modal_form" method="POST">
	                <div class="panel-body">
		                <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <input type="hidden" name="lab_occurance_company_id" class="form-control bg-light" id="lab_occurance_company_id">
	                            <input type="hidden" name="lab_occurance_user_id" class="form-control bg-light" id="lab_occurance_user_id">
	                            <input type="hidden" name="lab_occurance_user_super_id" class="form-control bg-light" id="lab_occurance_user_super_id">
	                            <label for="lab_occurance_start_date">Start Date</label>
	                            <input type="date" name="lab_occurance_start_date" class="form-control bg-light" id="lab_occurance_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="lab_occurance_end_date">End Date</label>
	                            <input type="date" name="lab_occurance_end_date" class="form-control bg-light" id="lab_occurance_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="lab_occurance_ok_btn" id="lab_occurance_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="lab_occurance_cancel_btn" id="lab_occurance_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>