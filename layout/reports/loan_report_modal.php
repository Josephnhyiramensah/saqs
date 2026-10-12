<div 
class="modal fade hide bd-example-modal-lg" 
id="loan_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="loan_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="loan_report_modal_header">Loan Report</h5>
			</div>
			<div class="modal-body">
				<form id="loan_report_modal_form" method="POST">
	                <div class="panel-body">
	                	<div id="loan_report_modal_warning"></div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="loan_report_start_date">Start Date</label>
	                            <input type="date" name="loan_report_start_date" class="form-control bg-light" id="loan_report_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="loan_report_end_date">End Date</label>
	                            <input type="date" name="loan_report_end_date" class="form-control bg-light" id="loan_report_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="loan_report_ok_btn" id="loan_report_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="loan_report_cancel_btn" id="loan_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>