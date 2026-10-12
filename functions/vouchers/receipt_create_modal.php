<div 
class="modal fade hide bd-example-modal-xl" 
id="receipt_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="receipt_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 90%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="receipt_create_modal_header">Receipt Voucher</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<div id="receipt_setup">
					<form id="receipt_setup_form" method="POST">
						<div class="form-row">
							<div class="col-md-6 mb-6">
								<input type='hidden' id='receipt_type' name="receipt_type">
								<input type="hidden" name="receipt_id" class="form-control bg-light" id="receipt_id">
								<input type="hidden" name="rec_attend_id" class="form-control bg-light" id="rec_attend_id">
								<input type="hidden" name="rec_patient_id" class="form-control bg-light" id="rec_patient_id">
								<div class="receipt_form_div">
										<div class="form-row">
											<div class="col-md-6 mb-6">
												<label for="debit_ledger">Receiving Ledger - Cash Account (Dr)</label>
												<select class="form-control bg-light" name="debit_ledger" id="debit_ledger"> 
													<option value="0">Please Select</option>
													<?php
														$sql="SELECT * FROM ledgers WHERE tb_4=6 ORDER BY ledger_desc ASC";
														$result = mysqli_query($con,$sql);
														$cash_ledger_id = $_SESSION['cash_ledger_id'];
														while($row = mysqli_fetch_array($result))
														{
															if($row['ledger_id'] == $cash_ledger_id)
															{
																echo '<option value = "'.$row['ledger_id'].'" selected="selected">'.$row['ledger_desc'].'</option>';
															}
															else
															{
																echo '<option value = "'.$row['ledger_id'].'" >'.$row['ledger_desc'].'</option>';
															};
														}               
													?>
												</select>
											</div>
											<div class="col-md-6 mb-6">
												<label for="credit_ledger">Paying Ledger - Customer Account (Cr)</label>
												<select class="form-control bg-light" name="credit_ledger" id="credit_ledger"> 
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
										</div>
										<div class="form-row">
											<div class="col-md-6 mb-6">
												<label for="date">Date</label>
												<input type="date" name="date" class="form-control bg-light" id="date" value="<?php echo $date_today;?>">
											</div>
											<div class="col-md-6 mb-6">
												<label for="received_from">Received From</label>
												<input type="text" name="received_from" class="form-control bg-light" id="received_from">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-6 mb-6">
												<label for="mode">Mode</label>
												<select class="form-control bg-light" name="mode" id="mode"> 
													<option value="0">Please Select</option>
													<option value="Cash">Cash</option>
													<option value="Cheque">Cheque</option>
													<option value="MoMo">MoMo</option>
													<option value="Bank_Draft">Bank Draft</option>
													<option value="Visa">Visa</option>
													<option value="PayPal">PayPal</option>
												</select>
											</div>
											<div class="col-md-6 mb-6">
												<label for="amount">Amount</label>
												<input type="text" class="form-control bg-light" name="amount" id="amount">
											</div>
										</div>
										<div id="bank_details_div" class="form-row" hidden="true">
											<div class="col-md-4 mb-4 form-group">
												<label for="rec_inst_no">Instrument No</label>
												<input type="text" class="form-control bg-light" name="rec_inst_no" id="rec_inst_no">
											</div>
											<div class="col-md-4 mb-4 form-group">
												<label for="rec_bank">Bank</label>
												<input type="text" class="form-control bg-light" name="rec_bank" id="rec_bank">
											</div>
											<div class="col-md-4 mb-4 form-group">
												<label for="rec_branch">Branch</label>
												<input type="text" class="form-control bg-light" name="rec_branch" id="rec_branch">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-12 mb-12">
												<label for="narration">Narration</label>
												<textarea type="textarea" rows="4"  class="form-control" name="narration" id="narration"></textarea>
											</div>
										</div>
										<div class="modal-footer">
											<div id="receipt_save_update">
												<button type="submit" name="receipt_save_btn" id="receipt_save_btn" class="btn btn-primary">Save</button>
												<button type="submit" name="receipt_update_btn" id="receipt_update_btn" class="btn btn-primary">Update</button>
											</div>
												<button type="button" name="receipt_cancel_btn" id="receipt_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
										</div>
								</div>
							</div>
							<div class="col-md-6 mb-6" id="unpaid_item_list">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>