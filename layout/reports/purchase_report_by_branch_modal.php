<div 
class="modal fade hide bd-example-modal-lg" 
id="purchase_report_by_branch_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="purchase_report_by_branch_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="purchase_report_by_branch_modal_header">Purchase Report</h5>
			</div>
			<div class="modal-body">
				<form id="purchase_report_by_branch_modal_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                    	<div id="purchase_report_by_branch_modal_warning"></div>
	                        <div class="col-md-12 mb-12 form-group">
	                            <input type="hidden" name="prbb_company_id" class="form-control bg-light" id="prbb_company_id">
	                            <input type="hidden" name="prbb_user_id" class="form-control bg-light" id="prbb_user_id">
	                            <input type="hidden" name="prbb_user_super_id" class="form-control bg-light" id="prbb_user_super_id">
	                            <label for="prbb_start_date">Start Date</label>
	                            <input type="date" name="prbb_start_date" class="form-control bg-light" id="prbb_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="prbb_end_date">End Date</label>
	                            <input type="date" name="prbb_end_date" class="form-control bg-light" id="prbb_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="prbb_ok_btn" id="prbb_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="prbb_cancel_btn" id="prbb_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>