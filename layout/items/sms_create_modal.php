<div 
class="modal fade bd-example-modal-xl" 
id="sms_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="sms_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 60%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="sms_create_modal_header">sms Setup</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="sms_create_form" method="POST">
					<div id="sms_create_form_msg"></div>
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="sms_date">Date</label>
							<input type="date" class="form-control" name="sms_date" id="sms_date" value="<?php echo $today;?>">
							<input type="hidden" class="form-control" name="sms_id" id="sms_id">
							<input type="hidden" class="form-control" name="sms_type" id="sms_type">
						</div>
						<div class="col-md-2 mb-2 purchase">
							<label for="sms_qty_purchased">Qty Purchased</label>
							<input type="text" class="form-control" name="sms_qty_purchased" id="sms_qty_purchased">
						</div>
						<div class="col-md-2 mb-2 purchase">
							<label for="sms_qty_sent">Qty Sent</label>
							<input type="text" class="form-control" name="sms_qty_sent" id="sms_qty_sent">
						</div>
						<div class="col-md-5 mb-5 purchase">
							<label for="sms_name">Name</label>
							<input type="text" class="form-control" name="sms_name" id="sms_name">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-10 mb-10" id="sms_category_div">
							<label for="sms_category">Type</label>
							<select class="form-control" name="sms_category" id="sms_category">
						    	<option value="APPOINTMENT_NOTICE">APPOINTMENT_NOTICE</option>
						    	<option value="BULK_MESSAGE">BULK_MESSAGE</option>
						    </select>
						</div>
						<div class="col-md-2 mb-2" id="sms_appointment_date_div">
							<label for="sms_appointment_date">Appointment Date</label>
							<input type="date" class="form-control" name="sms_appointment_date" id="sms_appointment_date" value="<?php echo $today;?>">
						</div>
					</div>
					<div class="form-row sending" hidden="true">
						<div class="col-md-10 mb-10" id="recipient_div">
							<label for="sms_recipient">Recipient</label>
							<!--<select class="form-control selectpicker"  data-live-search="true" name="sms_recipient" id="sms_recipient">-->
							<select class="form-control" name="sms_recipient" id="sms_recipient">
						    	<option value="ALL">ALL</option>
						        <?php
						        	$sql="SELECT * FROM patients ORDER BY firstName ASC LIMIT 5000";
									$result = mysqli_query($con,$sql);
						            while($row = mysqli_fetch_array($result))
						            {
						            	echo '<option value = "'.$row['patient_id'].'">'.trim($row['firstName']).' '.trim($row['lastName']).' '.trim($row['telephone']).'</option>';
						            }
						        ?>
						    </select>
						</div>
						<div class="col-md-2 mb-2" id="sms_gender_div">
							<label for="sms_gender">Gender</label>
							<select class="form-control" name="sms_gender" id="sms_gender">
						        <?php
						        	$sql="SELECT * FROM gender ORDER BY gender ASC";
									$result = mysqli_query($con,$sql);
						            while($row = mysqli_fetch_array($result))
						            {
						            	echo '<option value = "'.$row['gender_id'].'">'.$row['gender'].'</option>';
						            }
						        ?>
						    </select>
						</div>
						<div class="col-md-2 mb-2" id="sms_telephone_div" hidden="true">
							<label for="sms_telephone">Telephone</label>
							<input type="text" class="form-control" name="sms_telephone" id="sms_telephone">
						</div>
					</div>
					<div class="form-row sending" hidden="true">
						<div class="col-md-12 mb-12">
							<label for="sms_message">Message</label>
							<textarea class="form-control" name="sms_message" id="sms_message" rows="5"></textarea>
						</div>
					</div>
					<div class="form-row" hidden="true">
						<div class="col-md-12 mb-12">
							<label for="sms_status">Status</label>
							<input type="text" class="form-control" name="sms_status" id="sms_status">
						</div>
					</div>
				    <div class="modal-footer">
						<button type="button" name="sms_send_btn" id="sms_send_btn" class="btn btn-primary">Send</button>
				        <button type="button" name="sms_save_btn" id="sms_save_btn" class="btn btn-primary">Save</button>
				        <button type="button" name="sms_update_btn" id="sms_update_btn" class="btn btn-primary">Update</button>
				        <button type="submit" name="sms_cancel_btn" id="sms_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>