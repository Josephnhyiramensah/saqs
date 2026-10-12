<div 
class="modal fade bd-example-modal-xl" 
id="tax_schedule_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="tax_schedule_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="tax_schedule_create_modal_header">Tax Schedule Setup</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="tax_schedule_create_form" method="POST">
					<div class="form-row">
						<div class="col-md-2 mb-2 text-center">
							<input type="hidden" class="form-control bg-light" name="tax_schedule_id" id="tax_schedule_id">
							<label for="tax_schedule_applicable_date">Applicable Date</label>
							<input type="date" class="form-control bg-light" name="tax_schedule_applicable_date" id="tax_schedule_applicable_date">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2 mb-2 text-center">
							<label for="tax_schedule_ssf_employee">SSF Employee</label>
							<input type="text" class="form-control bg-light text-center" name="tax_schedule_ssf_employee" id="tax_schedule_ssf_employee">
						</div>
						<div class="col-md-2 mb-2 text-center">
							<label for="tax_schedule_ssf_employer">SSF Employer</label>
							<input type="text" class="form-control bg-light text-center" name="tax_schedule_ssf_employer" id="tax_schedule_ssf_employer">
						</div>
						<div class="col-md-2 mb-2 text-center">
							<label for="tax_schedule_ssf_tier_1">SSF Tier 1</label>
							<input type="text" class="form-control bg-light text-center" name="tax_schedule_ssf_tier_1" id="tax_schedule_ssf_tier_1">
						</div>
						<div class="col-md-2 mb-2 text-center">
							<label for="tax_schedule_ssf_tier_2">SSF Tier 2</label>
							<input type="text" class="form-control bg-light text-center" name="tax_schedule_ssf_tier_2" id="tax_schedule_ssf_tier_2">
						</div>
						<div class="col-md-2 mb-2 text-center">
							<label for="tax_schedule_bonus_threshold">Threshold</label>
							<input type="text" class="form-control bg-light text-center" name="tax_schedule_bonus_threshold" id="tax_schedule_bonus_threshold">
						</div>
						<div class="col-md-2 mb-2 text-center">
							<label for="tax_schedule_bonus_threshold_tax">Threshold Tax</label>
							<input type="text" class="form-control bg-light text-center" name="tax_schedule_bonus_threshold_tax" id="tax_schedule_bonus_threshold_tax">
						</div>
						<!--<div class="col-md-6 mb-6 text-center">
						</div>
						<div class="col-md-2 mb-2 text-center">
							<label for="tax_schedule_start_date">Start Date</label>
							<input type="date" class="form-control bg-light" name="tax_schedule_start_date" id="tax_schedule_start_date">
						</div>
						<div class="col-md-2 mb-2 text-center">
							<label for="tax_schedule_end_date">End Date</label>
							<input type="date" class="form-control bg-light" name="tax_schedule_end_date" id="tax_schedule_end_date">
						</div>-->
					</div>
					<div class="form-row">
						<div class="col-md-2 mb-2">
						</div>
						<div class="col-md-2 mb-2 text-center">
							<label for="CI_1">Chargeable Income</label>
						</div>
						<div class="col-md-2 mb-2 text-center">
							<label for="Rate_1">Rate</label>
						</div>
						<div class="col-md-2 mb-2 text-center">
							<label for="Tax_1">Tax</label>
						</div>
						<div class="col-md-2 mb-2 text-center">
							<label for="CCI_1">Cum. Chg. Income</label>
						</div>
						<div class="col-md-2 mb-2 text-center">
							<label for="CT_1">Cum. Tax</label>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2 mb-2 text-center">
							<label for="CI_1">First</label>
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center CI" name="CI_1" id="CI_1">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center Rate" name="Rate_1" id="Rate_1">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="Tax_1" id="Tax_1">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="CCI_1" id="CCI_1">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="CT_1" id="CT_1">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2 mb-2 text-center">
							<label for="CI_2">Next</label>
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center CI" name="CI_2" id="CI_2">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center Rate" name="Rate_2" id="Rate_2">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="Tax_2" id="Tax_2">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="CCI_2" id="CCI_2">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="CT_2" id="CT_2">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2 mb-2 text-center">
							<label for="CI_3">Next</label>
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center CI" name="CI_3" id="CI_3">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center Rate" name="Rate_3" id="Rate_3">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="Tax_3" id="Tax_3">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="CCI_3" id="CCI_3">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="CT_3" id="CT_3">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2 mb-2 text-center">
							<label for="CI_4">Next</label>
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center CI" name="CI_4" id="CI_4">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center Rate" name="Rate_4" id="Rate_4">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="Tax_4" id="Tax_4">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="CCI_4" id="CCI_4">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="CT_4" id="CT_4">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2 mb-2 text-center">
							<label for="CI_5">Next</label>
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center CI" name="CI_5" id="CI_5">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center Rate" name="Rate_5" id="Rate_5">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="Tax_5" id="Tax_5">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="CCI_5" id="CCI_5">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="CT_5" id="CT_5">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2 mb-2 text-center">
							<label for="CI_6">Next</label>
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center CI" name="CI_6" id="CI_6">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center Rate" name="Rate_6" id="Rate_6">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="Tax_6" id="Tax_6">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="CCI_6" id="CCI_6">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="CT_6" id="CT_6">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2 mb-2 text-center">
							<label for="CI_7">Exceeding</label>
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center CI" name="CI_7" id="CI_7">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center Rate" name="Rate_7" id="Rate_7">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="Tax_7" id="Tax_7">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="CCI_7" id="CCI_7">
						</div>
						<div class="col-md-2 mb-2">
							<input type="text" class="form-control bg-light text-center" name="CT_7" id="CT_7">
						</div>
					</div>
				    <div class="modal-footer">
				        <button type="button" name="tax_schedule_save_btn" id="tax_schedule_save_btn" class="btn btn-primary" >Save</button>
				        <button type="button" name="tax_schedule_update_btn" id="tax_schedule_update_btn" class="btn btn-primary" >Update</button>
				        <button type="submit" name="tax_schedule_cancel_btn" id="tax_schedule_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>