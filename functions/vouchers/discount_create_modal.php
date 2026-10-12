<div 
class="modal fade hide bd-example-modal-xl" 
id="discount_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="discount_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog"  style="max-width: 60%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="discount_create_modal_header">Discount Voucher</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="discount_setup_form" method="POST">
					<input type="hidden" name="discount_id" class="form-control bg-light" id="discount_id">
					<input type="hidden" name="discount_item_list_id" class="form-control bg-light" id="discount_item_list_id">
					<input type="hidden" name="discount_attend_id" class="form-control bg-light" id="discount_attend_id">
					<input type="hidden" name="discount_patient_id" class="form-control bg-light" id="discount_patient_id">
					<input type="hidden" name="discount_type" class="form-control bg-light" id="discount_type">
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="discount_debit_ledger">Receiving Ledger - Revenue (Dr)</label>
							<select class="form-control bg-light" name="discount_debit_ledger" id="discount_debit_ledger"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM ledgers WHERE tb_4=10 ORDER BY ledger_desc ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
							    ?>
							            <option value = "<?php echo($row['ledger_id'])?>" ><?php echo($row['ledger_desc']); ?></option>
							    <?php
						            }               
						        ?>
					    	</select>
						</div>
						<div class="col-md-6 mb-6">
							<label for="discount_credit_ledger">Paying Ledger - Customer Account (Cr)</label>
							<select class="form-control bg-light" name="discount_credit_ledger" id="discount_credit_ledger"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM ledgers WHERE tb_5=1 ORDER BY ledger_desc ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
							    ?>
							            <option value = "<?php echo($row['ledger_id'])?>" ><?php echo($row['ledger_desc']); ?></option>
							    <?php
						            }               
						        ?>
					    	</select>
						</div>
					</div>
			      	<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="discount_date">Date</label>
							<input type="date" name="discount_date" class="form-control bg-light" id="discount_date" required>
						</div>
						<div class="col-md-6 mb-6">
							<label for="discount_received_from">Received From</label>
							<input type="text" name="discount_received_from" class="form-control bg-light" id="discount_received_from" disabled="true">
						</div>
					</div>
			      	<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="discount_amount">Amount</label>
							<input type="text" class="form-control bg-light" name="discount_amount" id="discount_amount">
						</div>
						<div class="col-md-6 mb-6">
							<label for="discount_max_amount">Maximum Possible Discount</label>
							<input type="text" class="form-control bg-light" name="discount_max_amount" id="discount_max_amount" disabled="true">
						</div>
					</div>
			      	<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="discount_reason">Reason</label>
							<textarea type="textarea" rows="4"  class="form-control" name="discount_reason" id="discount_reason"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" name="discount_save_btn" id="discount_save_btn" class="btn btn-primary">Save</button>
						<button type="submit" name="discount_update_btn" id="discount_update_btn" class="btn btn-primary">Update</button>
						<button type="button" name="discount_cancel_btn" id="discount_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							</div>
				</form>
			</div>
		</div>
	</div>
</div>