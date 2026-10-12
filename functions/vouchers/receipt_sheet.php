<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
?>
	<div id="receipt_setup">
		<form id="receipt_setup_form" method="POST">
			<input type='hidden' id='receipt_type' name="receipt_type" value="<?php echo $_SESSION['receipt_type'];?>">
			<div class="receipt_form_div">
			      	<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="debit_ledger">Receiving Ledger - Cash Account (Dr)</label>
							<select class="form-control bg-light" name="debit_ledger" id="debit_ledger"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	if ($_SESSION['user_type'] == 'Ultra_Super_User') {
						        		$sql="SELECT * FROM ledgers WHERE tb_5=8 ORDER BY ledger_desc ASC";
										$result=mysqli_query($con,$sql);
							            while($row=mysqli_fetch_array($result))
							            {
								            echo '<option value = "'.$row['ledger_id'].'" >'.$row['ledger_desc'].'</option>';
							            };
						        	} 
						        	else 
						        	{
						        		$user_id = $_SESSION['user_id'];
						        		$sql="SELECT * FROM user_cash_ledger WHERE user_id='$user_id'";
										$result=mysqli_query($con,$sql);
							            while($row=mysqli_fetch_array($result))
							            {
							            	$ledger_id = $row['ledger_id'];

							            	$sql_led = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id' ORDER BY ledger_desc ASC";
											$result_led = mysqli_query($con,$sql_led);
											$row_led = mysqli_fetch_array($result_led);
											if ($ledger_id == $row_led['ledger_id']) 
											{
												echo '<option value = "'.$row_led['ledger_id'].'" selected="selected">'.$row_led['ledger_desc'].'</option>';
											} else {
												echo '<option value = "'.$row_led['ledger_id'].'">'.$row_led['ledger_desc'].'</option>';
											};
							            };
						        	};
						        ?>
					    	</select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="credit_ledger">Paying Ledger - Customer Account (Cr)</label>
							<select class="form-control bg-light" name="credit_ledger" id="credit_ledger"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM ledgers WHERE tb_5=1 ORDER BY ledger_desc ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            	if ($row['ledger_id'] == 1) {
						            		echo '<option value = "'.$row['ledger_id'].'" selected="selected">'.$row['ledger_desc'].'</option>';
						            	} 
						            	else 
						            	{
						            		echo '<option value = "'.$row['ledger_id'].'" >'.$row['ledger_desc'].'</option>';
						            	};
						            };
						        ?>
					    	</select>
						</div>
						<div class="col-md-2 mb-2">
						</div>
						<div class="col-md-2 mb-2">
							<label for="date">Date</label>
							<input type="date" name="date" class="form-control bg-light" id="date" required>
						</div>
						<div class="col-md-2 mb-2">
							<label for="receipt_no">Receipt No</label>
							<?php
									$sql="SELECT receipt_id FROM receipt ORDER BY receipt_id DESC";
									$result=mysqli_query($con,$sql);
									$rs_fa=mysqli_fetch_array($result);
									if(isset($rs_fa)){$vn=$rs_fa['receipt_id']+1;}else{$vn=1;};
								echo'<input type="text" name="receipt_no" id="receipt_no" class="form-control" hidden value="'.'REC'.str_pad($vn,7,"0",STR_PAD_LEFT).'">';
								echo'<input type="text" name="receipt_no_2" id="receipt_no_2" class="form-control" disabled value="'.'REC'.str_pad($vn,7,"0",STR_PAD_LEFT).'">';
							?>
						</div>
					</div>
			      	<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="received_from">Received From</label>
							<input type="text" name="received_from" class="form-control bg-light" id="received_from" value="<?php echo $_SESSION['name'];?>">
						</div>
						<div class="col-md-2 mb-2">
							<label for="amount">Amount</label>
							<input type="text" class="form-control bg-light" name="amount" id="amount" hidden="true">
							<input type="text" class="form-control bg-light" name="amount_2" id="amount_2" disabled="true">
						</div>
						<div class="col-md-2 mb-2">
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
						<div class="col-md-5 mb-5">
							<label for="narration">Narration</label>
							<input type="text" name="narration" class="form-control bg-light" id="narration">
						</div>
					</div>
					<div class="modal-footer">
						<div id="receipt_save_update">
							<button type="submit" name="receipt_save_btn" id="receipt_save_btn" class="btn btn-primary">Save</button>
							<!--<button type="submit" name="receipt_update_btn" id="receipt_update_btn" class="btn btn-primary" hidden="true">Update</button>
							<button type="button" name="receipt_reprint_btn" id="receipt_reprint_btn" class="btn btn-primary" hidden="true">Reprint</button>-->
						</div>
							<button type="button" name="receipt_sheet_cancel_btn" id="receipt_sheet_cancel_btn" class="btn btn-secondary">Cancel</button>
					</div>
			</div>
			
		</form>
	</div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>