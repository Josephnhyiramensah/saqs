<div 
class="modal fade hide bd-example-modal-lg" 
id="pay_slip_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="pay_slip_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="pay_slip_report_modal_header">Pay Slip Report</h5>
			</div>
			<div class="modal-body">
				<form id="pay_slip_report_modal_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
							<div id="pay_slip_report_modal_warning"></div>
							<div class="col-md-12 mb-12 form-group">
								<label for="pay_slip_report_type">Type</label>
								<select class="form-control bg-light" name="pay_slip_report_type" id="pay_slip_report_type"> 
									<option value="ALL">ALL</option>
									<option value="EMPLOYEE">EMPLOYEE</option>
									<option value="BRANCH">BRANCH</option>
								</select>
							</div>
		                </div>
						<div id="pay_slip_report_dynamic_div">
						</div>
	                    <div class="form-row">
							<div class="col-md-12 mb-12 form-group">
								<label for="pay_slip_execution_type">Execution Type</label>
								<select class="form-control bg-light" name="pay_slip_execution_type" id="pay_slip_execution_type"> 
									<option value="DOWNLOAD">DOWNLOAD</option>
									<option value="SEND_BY_MAIL">SEND_BY_MAIL</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12 form-group">
								<label for="pay_slip_report_start_date">Start Date</label>
								<input type="date" name="pay_slip_report_start_date" class="form-control bg-light" id="pay_slip_report_start_date">
							</div>
						</div> 
						<div class="form-row">
							<div class="col-md-12 mb-12 form-group">
								<label for="pay_slip_report_end_date">End Date</label>
								<input type="date" name="pay_slip_report_end_date" class="form-control bg-light" id="pay_slip_report_end_date">
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="pay_slip_report_ok_btn" id="pay_slip_report_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="pay_slip_report_cancel_btn" id="pay_slip_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>