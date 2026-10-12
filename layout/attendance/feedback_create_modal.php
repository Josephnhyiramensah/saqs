<div 
class="modal fade hide bd-example-modal-xl" 
id="feedback_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="feedback_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 40%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="feedback_create_modal_header">New Feedback</h5>
			</div>
			<div class="modal-body">
				<form id="feedback_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="feedback_date">Date</label>
	                            <input type="hidden" name="feedback_id" class="form-control bg-light" id="feedback_id">
	                            <input type="hidden" name="feedback_patient_id" class="form-control bg-light" id="feedback_patient_id">
	                            <input type="date" class="form-control bg-light" name="feedback_date" id="feedback_date" value="<?php echo $date_today;?>">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="feedback">Feedback</label>
								<textarea class="form-control bg-light" id="feedback" name="feedback" rows="4"></textarea>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-9 mb-9 form-group">
	                            <label for="feedback_remarks">Remarks</label>
	                            <input type="text" name="feedback_remarks" class="form-control bg-light" id="feedback_remarks">
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="feedback_status">Status</label>
	                            <select class="form-control bg-light" name="feedback_status" id="feedback_status">
									<option value = "PENDING">PENDING</option>
									<option value = "RESOLVED">RESOLVED</option>
									<option value = "STUCK">STUCK</option>
								</select>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="feedback_save_btn" id="feedback_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="feedback_update_btn" id="feedback_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="feedback_cancel_btn" id="feedback_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
			</div>
		</div>
	</div>
</div>