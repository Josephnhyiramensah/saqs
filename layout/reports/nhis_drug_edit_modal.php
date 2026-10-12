
<div 
class="modal fade bd-example-modal-xl" 
id="nhis_drug_detail_modal" 
tabindex="-1" role="dialog" 
aria-labelledby="nhis_drug_detail_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="nhis_drug_detail_modal_title">Drug Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="nhis_drug_detail_form" method="POST">
					<input type="text" class="form-control" name="drug_disp_list_id" id="drug_disp_list_id" hidden="true">
					<input type="text" class="form-control" name="nhis_drug_price_cash" id="nhis_drug_price_cash" hidden="true">
					<input type="text" class="form-control" name="nhis_drug_amount_cash" id="nhis_drug_amount_cash" hidden="true">
					<input type="text" class="form-control" name="nhis_drug_price_prvt" id="nhis_drug_price_prvt" hidden="true">
					<input type="text" class="form-control" name="nhis_drug_amount_prvt" id="nhis_drug_amount_prvt" hidden="true">
					<input type="text" class="form-control" name="nhis_drug_attend_id" id="nhis_drug_attend_id" hidden="true"value="<?php echo $attend_id;?>">
					<input type="text" class="form-control" name="nhis_drug_patient_id" id="nhis_drug_patient_id" hidden="true"value="<?php echo $patient_id;?>">
					<input type="text" class="form-control" name="nhis_drug_payment_type_id" id="nhis_drug_payment_type_id" value="<?php echo $payment_type_id;?>" hidden="true">
					<div class="form-row">
						<div class="col-md-8 mb-8">
							<label for="nhis_drug_id">Drug</label>
							<select class="form-control" name="nhis_drug_id" id="nhis_drug_id"> 
					    		<option value="0">Please Select</option>
						        <?php
									$query_drug = "SELECT * FROM drugs ORDER BY brand_name ASC";
									$result_drug = mysqli_query($con,$query_drug);
									while($row_drug = mysqli_fetch_array($result_drug))
									{
										echo '<option value = "'.$row_drug['drug_id'].'">'.$row_drug['brand_name'].'</option>';
									};
						        ?>
					    	</select>
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_drug_code">Code</label>
							<input type="text" class="form-control" name="nhis_drug_code" id="nhis_drug_code" disabled="true">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_drug_payment_type_id">Payment Type</label>
							<select class="form-control" name="nhis_drug_payment_type_id" id="nhis_drug_payment_type_id"> 
					    		<?php
									$query_sponsor = "SELECT P.*, L.ledger_id, L.ledger_desc
									FROM `ledgers` AS L JOIN `payment_type` AS P ON L.ledger_id = P.ledger_id 
									WHERE P.attend_id = '$attend_id'";
									$query_run_sponsor = mysqli_query($con, $query_sponsor);
									while($row_sponsor = mysqli_fetch_array($query_run_sponsor))
									{
										echo '<option value = "'.$row_sponsor['ledger_id'].'">'.$row_sponsor['ledger_desc'].'</option>';
									};
						        ?>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4 mb-4">
							<label for="nhis_drug_dosage">Dosage</label>
							<input type="text" class="form-control" name="nhis_drug_dosage" id="nhis_drug_dosage">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_drug_date">Date</label>
							<input type="date" class="form-control" name="nhis_drug_date" id="nhis_drug_date">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_drug_qty">Qty</label>
							<input type="text" class="form-control" name="nhis_drug_qty" id="nhis_drug_qty">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_drug_price">Price</label>
							<input type="text" class="form-control" name="nhis_drug_price" id="nhis_drug_price">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_drug_amount">Amount</label>
							<input type="text" class="form-control" name="nhis_drug_amount" id="nhis_drug_amount" hidden="true">
							<input type="text" class="form-control" name="nhis_drug_amountD" id="nhis_drug_amountD" disabled="true">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="nhis_drug_comment">Comment</label>
							<textarea type="textarea" rows="2"  class="form-control" name="nhis_drug_comment" id="nhis_drug_comment"></textarea>
						</div>
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" id="btn_nhis_drug_save" class="btn btn-primary">Save</button>
					<button type="button" id="btn_nhis_drug_update" class="btn btn-primary">Update</button>
				    <button type="button" id="btn_nhis_drug_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>
