<div 
class="modal fade hide bd-example-modal-xl" 
id="visitors_register_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="visitors_register_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 60%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="visitors_register_create_modal_header">New Visitors Entry</h5>
			</div>
			<div class="modal-body">
				<form id="visitors_register_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-6 mb-6 form-group">
	                            <input type="hidden" name="visitors_register_id" class="form-control bg-light" id="visitors_register_id">
	                            <label for="visitors_register_name">Visitors Name</label>
	                            <input type="text" name="visitors_register_name" class="form-control bg-light" id="visitors_register_name">
	                        </div>
	                        <div class="col-md-6 mb-6 form-group">
	                            <label for="visitors_register_staff">Person to be visited</label>
	                            <input type="text" name="visitors_register_staff" class="form-control bg-light" id="visitors_register_staff">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="visitors_register_date">Date</label>
	                            <input type="date" class="form-control bg-light" name="visitors_register_date" id="visitors_register_date" value="<?php echo $date_today;?>">
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="visitors_register_time_in">Time-In</label>
	                            <input type="time" class="form-control bg-light" name="visitors_register_time_in" id="visitors_register_time_in" value="<?php echo $current_time;?>">
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="visitors_register_time_out">Time-Out</label>
	                            <input type="time" class="form-control bg-light" name="visitors_register_time_out" id="visitors_register_time_out">
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="visitors_register_telephone">Telephone</label>
	                            <input type="text" class="form-control bg-light" name="visitors_register_telephone" id="visitors_register_telephone">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="visitors_register_purpose">Purpose</label>
	                            <input type="text" class="form-control bg-light" name="visitors_register_purpose" id="visitors_register_purpose">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="visitors_register_save_btn" id="visitors_register_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="visitors_register_update_btn" id="visitors_register_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="visitors_register_cancel_btn" id="visitors_register_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
			</div>
		</div>
	</div>
</div>