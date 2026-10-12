<?php 
	if(!isset($attend_id)){$attend_id=0;};
	if(!isset($patient_id)){$patient_id=0;};
	if(!isset($payment_type_id)){$payment_type_id=0;};
	if(!isset($con)){
    	require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
	};
?>
<div 
class="modal fade bd-example-modal-xl" 
id="nhis_procedure_detail_modal" 
tabindex="-1" role="dialog" 
aria-labelledby="nhis_procedure_detail_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="nhis_procedure_detail_modal_title">Procedure Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="nhis_procedure_detail_form" method="POST">
					<input type="text" class="form-control" name="nhis_surgerylist_id" id="nhis_surgerylist_id" hidden="true">
					<input type="text" class="form-control" name="nhis_procedure_amount_cash" id="nhis_procedure_amount_cash" hidden="true">
					<input type="text" class="form-control" name="nhis_procedure_amount_prvt" id="nhis_procedure_amount_prvt" hidden="true">
					<input type="text" class="form-control" name="nhis_procedure_attend_id" id="nhis_procedure_attend_id" value="<?php echo $attend_id;?>" hidden="true">
					<input type="text" class="form-control" name="nhis_procedure_patient_id" id="nhis_procedure_patient_id" value="<?php echo $patient_id;?>" hidden="true">
					<input type="text" class="form-control" name="nhis_procedure_payment_type_id" id="nhis_procedure_payment_type_id" value="<?php echo $payment_type_id;?>" hidden="true">
					<div class="form-row">
						<div class="col-md-2 mb-2">
							<label for="nhis_procedure_gdrg">G-DRG</label>
							<select class="form-control" name="nhis_procedure_gdrg" id="nhis_procedure_gdrg"> 
					    		<option value="0">Please Select</option>
						        <?php
									$query_gdrg = "SELECT nhis_item_desc, gdrg_adult AS gdrg, price_adult AS price, nhis_id FROM nhis WHERE gdrg_adult !=''
									UNION ALL SELECT nhis_item_desc, gdrg_child AS gdrg, price_child AS price, nhis_id FROM nhis WHERE gdrg_child !=''";
									$result_gdrg = mysqli_query($con,$query_gdrg);
									while($row_gdrg = mysqli_fetch_array($result_gdrg))
									{
										echo '<option value = "'.$row_gdrg['nhis_id'].'">'.$row_gdrg['gdrg'].' - '.$row_gdrg['nhis_item_desc'].'</option>';
									};
						        ?>
					    	</select>
						</div>
						<div class="col-md-6 mb-6">
							<label for="nhis_procedure_description">Description</label>
							<input type="text" class="form-control" name="nhis_procedure_description" id="nhis_procedure_description" disabled="true">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_procedure_amount">Amount</label>
							<input type="text" class="form-control" name="nhis_procedure_amount" id="nhis_procedure_amount" hidden="true">
							<input type="text" class="form-control" name="nhis_procedure_amountD" id="nhis_procedure_amountD" disabled="true">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_procedure_payment_type_id">Payment Type</label>
							<select class="form-control" name="nhis_procedure_payment_type_id" id="nhis_procedure_payment_type_id"> 
					    		<?php
									$query_sponsor = "SELECT P.*, L.ledger_id, L.ledger_desc
									FROM `ledgers` AS L JOIN `payment_type` AS P ON L.ledger_id = P.ledger_id 
									WHERE P.attend_id = '$attend_id'";
									$query_run_sponsor = mysqli_query($con, $query_sponsor);
									while($row_sponsor = mysqli_fetch_array($query_run_sponsor))
									{
										echo'<option value = "'.$row_sponsor['ledger_id'].'">'.$row_sponsor['ledger_desc'].'</option>';
									};
						        ?>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="nhis_procedure_diagnosis">Procedure</label>
							<select class="form-control" name="nhis_procedure_diagnosis" id="nhis_procedure_diagnosis"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM surgery ORDER BY surgery ASC";
									$result = mysqli_query($con,$sql);
						            while($row = mysqli_fetch_array($result))
						            {
										echo'<option value = "'.$row['surgery_id'].'">
											'.$row['surgery'].'
										</option>';
						            };
						        ?>
					    	</select>
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_procedure_icd_10">ICD-10</label>
							<input type="text" class="form-control" name="nhis_procedure_icd_10" id="nhis_procedure_icd_10" disabled ="true">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_procedure_date">Date</label>
							<input type="date" class="form-control" name="nhis_procedure_date" id="nhis_procedure_date">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_procedure_is_principal">Is Principal</label>
							<select class="form-control" name="nhis_procedure_is_principal" id="nhis_procedure_is_principal"> 
					    		<option value="0">Please Select</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="nhis_procedure_comment">Comment</label>
							<textarea type="textarea" rows="2"  class="form-control" name="nhis_procedure_comment" id="nhis_procedure_comment" value=""></textarea>
						</div>
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" id="btn_nhis_procedure_save" class="btn btn-primary">Save</button>
					<button type="button" id="btn_nhis_procedure_update" class="btn btn-primary">Update</button>
				    <button type="button" id="btn_nhis_procedure_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>