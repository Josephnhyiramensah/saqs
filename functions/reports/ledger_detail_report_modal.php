<div 
class="modal fade hide bd-example-modal-lg" 
id="ledger_detail_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="ledger_detail_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="ledger_detail_report_modal_header">Ledger Detail Report</h5>
			</div>
			<div class="modal-body">
				<form id="ledger_detail_report_modal_form" method="POST">
	                <div class="panel-body">
	                    <div id="ledger_detail_report_modal_warning"></div>
		                <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <input type="hidden" name="ledger_detail_report_company_id" class="form-control bg-light" id="ledger_detail_report_company_id">
	                            <input type="hidden" name="ledger_detail_report_user_id" class="form-control bg-light" id="ledger_detail_report_user_id">
	                            <input type="hidden" name="ledger_detail_report_user_super_id" class="form-control bg-light" id="ledger_detail_report_user_super_id">
	                            <label for="ledger_detail_report_start_date">Start Date</label>
	                            <input type="date" name="ledger_detail_report_start_date" class="form-control bg-light" id="ledger_detail_report_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="ledger_detail_report_end_date">End Date</label>
	                            <input type="date" name="ledger_detail_report_end_date" class="form-control bg-light" id="ledger_detail_report_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="ledger_detail_report_ok_btn" id="ledger_detail_report_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="ledger_detail_report_cancel_btn" id="ledger_detail_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>