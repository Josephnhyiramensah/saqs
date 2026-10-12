<div 
class="modal fade bd-example-modal-m" 
id="drug_admin_status_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="drug_admin_status_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-m" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="drug_admin_status_modal_header">Drug Admin State</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="drug_admin_status_form" method="POST">
        <div class="modal-body">
  		<div class="clearfix"></div>
      		<div class="panel-body">
				<div class="form-row">
					<div class="col-md-12 mb-12">
						<label for="drug_admin_status_remarks">Remarks</label>
						<textarea type="textarea" rows="7"  class="form-control" name="drug_admin_status_remarks" id="drug_admin_status_remarks"></textarea>
						<input type="hidden" class="form-control" name="drug_admin_status_id" id="drug_admin_status_id">
						<input type="hidden" class="form-control" name="drug_admin_status_drug_list_id" id="drug_admin_status_drug_list_id">
						<input type="hidden" class="form-control" name="drug_admin_status_drug_id" id="drug_admin_status_drug_id">
					</div>
				</div>
			</div>
	        <div class="modal-footer">
	            <button type="button" name="drug_admin_status_complete_btn" id="drug_admin_status_complete_btn" class="btn btn-primary">Complete</button>
	            <button type="button" name="drug_admin_status_suspend_btn" id="drug_admin_status_suspend_btn" class="btn btn-primary">Suspend</button>
	            <button type="button" name="drug_admin_status_uncomplete_btn" id="drug_admin_status_uncomplete_btn" class="btn btn-primary">Uncomplete</button>
	            <button type="button" name="drug_admin_status_unsuspend_btn" id="drug_admin_status_unsuspend_btn" class="btn btn-primary">Unsuspend</button>
	            <button type="submit" name="drug_admin_status_cancel_btn" id="drug_admin_status_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	        </div>
        </div>
      </form>
    </div>
  </div>
</div>
