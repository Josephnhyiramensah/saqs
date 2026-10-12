<div 
class="modal fade hide bd-example-modal-xl" 
id="refund_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="refund_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog"  style="max-width: 60%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="refund_create_modal_header">Refund Voucher</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="refund_setup_form" method="POST">
					<input type="hidden" name="refund_id" class="form-control bg-light" id="refund_id">
					<input type="hidden" name="refund_receipt_id" class="form-control bg-light" id="refund_receipt_id">
					<input type="hidden" name="refund_attend_id" class="form-control bg-light" id="refund_attend_id">
					<input type="hidden" name="refund_patient_id" class="form-control bg-light" id="refund_patient_id">
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="refund_debit_ledger">Receiving Ledger - Customer (Dr)</label>
							<select class="form-control bg-light" name="refund_debit_ledger" id="refund_debit_ledger"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM ledgers WHERE tb_4!=6 ORDER BY ledger_desc ASC";
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
							<label for="refund_credit_ledger">Paying Ledger - Cash Account (Cr)</label>
							<select class="form-control bg-light" name="refund_credit_ledger" id="refund_credit_ledger"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM ledgers WHERE tb_4=6 ORDER BY ledger_desc ASC";
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
							<label for="refund_date">Date</label>
							<input type="date" name="refund_date" class="form-control bg-light" id="refund_date" required>
						</div>
						<div class="col-md-6 mb-6">
							<label for="refund_received_from">Received From</label>
							<input type="text" name="refund_received_from" class="form-control bg-light" id="refund_received_from" disabled="true">
						</div>
					</div>
			      	<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="refund_amount">Amount</label>
							<input type="text" class="form-control bg-light" name="refund_amount" id="refund_amount">
						</div>
						<div class="col-md-6 mb-6">
							<label for="refund_max_amount">Maximum Possible Refund</label>
							<input type="text" class="form-control bg-light" name="refund_max_amount" id="refund_max_amount" disabled="true">
						</div>
					</div>
			      	<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="refund_reason">Reason</label>
							<textarea type="textarea" rows="4"  class="form-control" name="refund_reason" id="refund_reason"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" name="refund_save_btn" id="refund_save_btn" class="btn btn-primary">Save</button>
						<button type="submit" name="refund_update_btn" id="refund_update_btn" class="btn btn-primary">Update</button>
						<button type="button" name="refund_cancel_btn" id="refund_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							</div>
				</form>
			</div>
		</div>
	</div>
</div>