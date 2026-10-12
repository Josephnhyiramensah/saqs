<div 
class="modal fade bd-example-modal-lg" 
id="time_sheet_list_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="time_sheet_list_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="time_sheet_list_create_modal_header">Time Sheet Setup</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="time_sheet_list_create_form" method="POST">
					<div class="form-row">
						<div class="col-md-9 mb-9">
							<label for="time_sheet_list_employee_id">Employee</label>
							<input type="hidden" class="form-control bg-light" name="time_sheet_date" id="time_sheet_date">
							<input type="hidden" class="form-control bg-light" name="time_sheet_list_id" id="time_sheet_list_id">
							<input type="hidden" class="form-control bg-light" name="time_sheet_id" id="time_sheet_id">
							<div id="time_sheet_list_employee_id_div">

							</div>
						</div>
						<div class="col-md-3 mb-3 text-center">
							<label for="time_sheet_list_absent">Absent</label>
							<input type="text" class="form-control bg-light text-center" name="time_sheet_list_absent" id="time_sheet_list_absent">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-3 mb-3 text-center">
							<label for="time_sheet_list_overtime">Overtime</label>
							<input type="text" class="form-control bg-light text-center" name="time_sheet_list_overtime" id="time_sheet_list_overtime">
						</div>
						<div class="col-md-3 mb-3 text-center">
							<label for="time_sheet_list_day67">Day 6/7</label>
							<input type="text" class="form-control bg-light text-center" name="time_sheet_list_day67" id="time_sheet_list_day67">
						</div>
						<div class="col-md-3 mb-3 text-center">
							<label for="time_sheet_list_holiday">Holiday</label>
							<input type="text" class="form-control bg-light text-center" name="time_sheet_list_holiday" id="time_sheet_list_holiday">
						</div>
						<div class="col-md-3 mb-3 text-center">
							<label for="time_sheet_list_total">Total</label>
							<input type="text" class="form-control bg-light text-center" name="time_sheet_list_total" id="time_sheet_list_total" disabled="true">
						</div>
					</div>
				    <div class="modal-footer">
				        <button type="button" name="time_sheet_list_save_btn" id="time_sheet_list_save_btn" class="btn btn-primary" >Save</button>
				        <button type="button" name="time_sheet_list_update_btn" id="time_sheet_list_update_btn" class="btn btn-primary" >Update</button>
				        <button type="submit" name="time_sheet_list_cancel_btn" id="time_sheet_list_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>