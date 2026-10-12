<div 
class="modal fade hide bd-example-modal-lg" 
id="profit_and_loss_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="profit_and_loss_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="profit_and_loss_report_modal_header">Profit and Loss</h5>
			</div>
			<div class="modal-body">
				<form id="profit_and_loss_report_modal_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                    	<div id="profit_and_loss_report_modal_warning"></div>
	                        <div class="col-md-12 mb-12 form-group">
	                            <input type="hidden" name="plr_company_id" class="form-control bg-light" id="plr_company_id">
	                            <input type="hidden" name="plr_user_id" class="form-control bg-light" id="plr_user_id">
	                            <input type="hidden" name="plr_user_super_id" class="form-control bg-light" id="plr_user_super_id">
	                            <label for="plr_start_date">Start Date</label>
	                            <input type="date" name="plr_start_date" class="form-control bg-light" id="plr_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="plr_end_date">End Date</label>
	                            <input type="date" name="plr_end_date" class="form-control bg-light" id="plr_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="plr_ok_btn" id="plr_ok_btn" class="btn btn-primary">Save</button>
	                    <button type="submit" name="plr_cancel_btn" id="plr_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>