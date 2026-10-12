<div 
class="modal fade hide bd-example-modal-lg" 
id="statement_of_in_patient_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="statement_of_in_patient_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="statement_of_in_patient_modal_header">Statement Of In-Patient</h5>
			</div>
			<div class="modal-body">
				<div id="statement_of_in_patient_modal_warning"></div>
				<form id="statement_of_in_patient_modal_form" method="POST">
	                <div class="panel-body">
		                <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <input type="hidden" name="statement_of_in_patient_company_id" class="form-control bg-light" id="statement_of_in_patient_company_id">
	                            <input type="hidden" name="statement_of_in_patient_user_id" class="form-control bg-light" id="statement_of_in_patient_user_id">
	                            <input type="hidden" name="statement_of_in_patient_user_super_id" class="form-control bg-light" id="statement_of_in_patient_user_super_id">
	                            <label for="statement_of_in_patient_start_date">Start Date</label>
	                            <input type="date" name="statement_of_in_patient_start_date" class="form-control bg-light" id="statement_of_in_patient_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="statement_of_in_patient_end_date">End Date</label>
	                            <input type="date" name="statement_of_in_patient_end_date" class="form-control bg-light" id="statement_of_in_patient_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="statement_of_in_patient_ok_btn" id="statement_of_in_patient_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="statement_of_in_patient_cancel_btn" id="statement_of_in_patient_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>