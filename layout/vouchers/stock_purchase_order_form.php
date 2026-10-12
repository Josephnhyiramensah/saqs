<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar.php');
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
						        	$sql="SELECT * FROM ledgers WHERE tb_5=8 ORDER BY ledger_desc ASC";
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
						<div class="col-md-3 mb-3">
							<label for="credit_ledger">Paying Ledger - Customer Account (Cr)</label>
							<select class="form-control bg-light" name="credit_ledger" id="credit_ledger"> 
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
							<input type="text" name="received_from" class="form-control bg-light" id="received_from">
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
							<button type="button" name="receipt_cancel_btn" id="receipt_cancel_btn" class="btn btn-secondary">Cancel</button>
					</div>
			</div>
			<div class="form-row" id="receipt_itemise_table">
				<div class="col-md-6 mb-6">
					<div class="table-responsive" id="attend_billlist_table">
				 		<table class="table table-hover table-bordered table-sm" id="billlist_table" width="100%" cellspacing="0">
			                <thead>
			                    <tr>
			                        <th>BILL DESCRIPTION</th>
			                        <th>AMT BILL</th>
			                        <th>AMT PAID</th>
			                        <th>AMT BAL</th>
			                        <th>ACTION</th>
			                    </tr>
			                </thead>
			                <tbody class="pv-table-body">
			                	<?php
			                		$i=0;
								    $query_servicelist = "SELECT * FROM service_list WHERE attend_id='$attend_id' ORDER BY date DESC";
								    $query_run_servicelist = mysqli_query($con, $query_servicelist);
								    if (mysqli_num_rows($query_run_servicelist) > 0)
									{
								?>
										<!--<tr data-id="1" style="background-color:#E4E1E0">
							        		<td colspan="5">
												<strong>SERVICES</strong>
											</td>
										</tr>-->
								<?php
										while($row_servicelist=mysqli_fetch_assoc($query_run_servicelist))
										{
											$service_list_id = $row_servicelist['service_list_id'];
											$service_id = $row_servicelist['service_id'];
											$query_rsl = "SELECT MAX(amount_bill) AS amount_bill, SUM(amount_rec) AS total_rec FROM receipt_items WHERE item_list_id='$service_list_id' AND item_id='$service_id' AND category_id=1";
								    		$query_run_rsl = mysqli_query($con, $query_rsl);
								    		$row_rsl=mysqli_fetch_assoc($query_run_rsl);
								    		if($row_rsl['amount_bill'] == NULL)
								    			{
								    				$amount_bill = number_format($row_servicelist['amount_cash'], 2);
								    				$amount_paid = number_format($row_rsl['total_rec'], 2);
								    				$amount_left = number_format($row_servicelist['amount_cash'] - $row_rsl['total_rec'], 2);
								    			}
								    		else if($row_rsl['amount_bill'] !== NULL)
								    			{
								    				$amount_bill = number_format($row_rsl['amount_bill'], 2);
								    				$amount_paid = number_format($row_rsl['total_rec'], 2);
								    				$amount_left = number_format($row_rsl['amount_bill'] - $row_rsl['total_rec'], 2);
								    			};
								    		
								    		if ($row_rsl['amount_bill'] == NULL || $row_rsl['amount_bill'] > $row_rsl['total_rec'])
											{
												$query_service = "SELECT * FROM services WHERE service_id='$service_id'";
						        				$query_run_service = mysqli_query($con, $query_service);
						        				$row_service=mysqli_fetch_assoc($query_run_service);
						        				$i++;
						        ?>
												
												<tr id="bill_list<?php echo $i;?>">
									        		<td>
														<?php echo $row_service['service'];?>
													</td>
									        		<td class="amt-td">
									        			<?php echo $amount_bill;?>
									        		</td>
									        		<td class="amt-td">
									        			<?php echo $amount_paid;?>
									        		</td>
									        		<td class="amt-td">
									        			<?php echo $amount_left;?>
									        		</td>
									        		<td class="action-td">
									        			<a href="#" 
									        				id="btn_receipt_enter" 
									        				data-id="<?php echo $row_servicelist['service_list_id'];?>"
									        				data-id2="<?php echo $row_servicelist['service_id'];?>"
									        				data-id3="1"
									        			><i class="fa fa-receipt"></i></a>
									        		</td>
									        	</tr>
								<?php
											};
										};
									};
			                	?>

			                	<?php
								    $query_lablist = "SELECT * FROM lab_list WHERE attend_id='$attend_id' ORDER BY date DESC";
								    $query_run_lablist = mysqli_query($con, $query_lablist);
								    if (mysqli_num_rows($query_run_lablist) > 0)
									{
								?>
										<!--<tr data-id="3" style="background-color:#E4E1E0">
							        		<td colspan="5">
												<strong>LAB TEST</strong>
											</td>
										</tr>-->
								<?php
										while($row_lablist=mysqli_fetch_assoc($query_run_lablist))
										{
											$lab_list_id = $row_lablist['lab_list_id'];
											$lab_id = $row_lablist['lab_id'];
											$query_rll = "SELECT MAX(amount_bill) AS amount_bill, SUM(amount_rec) AS total_rec FROM receipt_items WHERE item_list_id='$lab_list_id' AND item_id='$lab_id' AND category_id=3";
								    		$query_run_rll = mysqli_query($con, $query_rll);
								    		$row_rll=mysqli_fetch_assoc($query_run_rll);
								    		if($row_rll['amount_bill'] == NULL)
								    			{
								    				$amount_bill = number_format($row_lablist['amount_cash'], 2);
								    				$amount_paid = number_format($row_rll['total_rec'], 2);
								    				$amount_left = number_format($row_lablist['amount_cash'] - $row_rll['total_rec'], 2);
								    			}
								    		else if($row_rll['amount_bill'] !== NULL)
								    			{
								    				$amount_bill = number_format($row_rll['amount_bill'], 2);
								    				$amount_paid = number_format($row_rll['total_rec'], 2);
								    				$amount_left = number_format($row_rll['amount_bill'] - $row_rll['total_rec'], 2);
								    			};
								    		
								    		if ($row_rll['amount_bill'] == NULL || $row_rll['amount_bill'] > $row_rll['total_rec'])
											{
												$query_lab = "SELECT * FROM lab WHERE lab_id='$lab_id'";
						        				$query_run_lab = mysqli_query($con, $query_lab);
						        				$row_lab=mysqli_fetch_assoc($query_run_lab);
						        				$i++;
						        	?>
												<tr id="bill_list<?php echo $i;?>">
									        		<td>
														<?php echo $row_lab['lab'];?>
													</td>
									        		<td class="amt-td">
									        			<?php echo $amount_bill;?>
									        		</td>
									        		<td class="amt-td">
									        			<?php echo $amount_paid;?>
									        		</td>
									        		<td class="amt-td">
									        			<?php echo $amount_left;?>
									        		</td>
									        		<td class="action-td">
									        			<a href="#" 
									        				id="btn_receipt_enter" 
									        				data-id="<?php echo $row_lablist['lab_list_id'];?>"
									        				data-id2="<?php echo $row_lablist['lab_id'];?>"
									        				data-id3="3"
									        			><i class="fa fa-receipt"></i></a>
									        		</td>
									        	</tr>
								<?php
											};
										};
									};
			                	?>

			                	<?php
								    $query_radiolist = "SELECT * FROM radio_list WHERE attend_id='$attend_id' ORDER BY date DESC";
								    $query_run_radiolist = mysqli_query($con, $query_radiolist);
								    if (mysqli_num_rows($query_run_radiolist) > 0)
									{;
								?>
											<!--<tr data-id="4" style="background-color:#E4E1E0">
								        		<td colspan="5">
													<strong>RADIOLOGY</strong>
												</td>
											</tr>-->
								<?php
										while($row_radiolist=mysqli_fetch_assoc($query_run_radiolist))
										{
											$radio_list_id = $row_radiolist['radio_list_id'];
											$radio_id = $row_radiolist['radio_id'];
											$query_rrl = "SELECT MAX(amount_bill) AS amount_bill, SUM(amount_rec) AS total_rec FROM receipt_items WHERE item_list_id='$radio_list_id' AND item_id='$radio_id' AND category_id=4";
								    		$query_run_rrl = mysqli_query($con, $query_rrl);
								    		$row_rrl=mysqli_fetch_assoc($query_run_rrl);
								    		if($row_rrl['amount_bill'] == NULL)
								    			{
								    				$amount_bill = number_format($row_radiolist['amount_cash'], 2);
								    				$amount_paid = number_format($row_rrl['total_rec'], 2);
								    				$amount_left = number_format($row_radiolist['amount_cash'] - $row_rrl['total_rec'], 2);
								    			}
								    		else if($row_rrl['amount_bill'] !== NULL)
								    			{
								    				$amount_bill = number_format($row_rrl['amount_bill'], 2);
								    				$amount_paid = number_format($row_rrl['total_rec'], 2);
								    				$amount_left = number_format($row_rrl['amount_bill'] - $row_rrl['total_rec'], 2);
								    			};
								    		
								    		if ($row_rrl['amount_bill'] == NULL || $row_rrl['amount_bill'] > $row_rrl['total_rec'])
											{
												$query_radio = "SELECT * FROM radiology WHERE radio_id='$radio_id'";
						        				$query_run_radio = mysqli_query($con, $query_radio);
						        				$row_radio=mysqli_fetch_assoc($query_run_radio);
						        				$i++;
						        ?>
												<tr id="bill_list<?php echo $i;?>">
									        		<td>
														<?php echo $row_radio['radiology'];?>
													</td>
									        		<td class="amt-td">
									        			<?php echo $amount_bill;?>
									        		</td>
									        		<td class="amt-td">
									        			<?php echo $amount_paid;?>
									        		</td>
									        		<td class="amt-td">
									        			<?php echo $amount_left;?>
									        		</td>
									        		<td class="action-td">
									        			<a href="#" 
									        				id="btn_receipt_enter" 
									        				data-id="<?php echo $row_radiolist['radio_list_id'];?>"
									        				data-id2="<?php echo $row_radiolist['radio_id'];?>"
									        				data-id3="4"
									        			><i class="fa fa-receipt"></i></a>
									        		</td>
									        	</tr>
								<?php
											};
										};
									};
			                	?>

			                	<?php
								    $query_ddruglist = "SELECT * FROM drug_dispense_list WHERE attend_id='$attend_id' ORDER BY date DESC";
								    $query_run_ddruglist = mysqli_query($con, $query_ddruglist);
								    if (mysqli_num_rows($query_run_ddruglist) > 0)
									{;
								?>
											<!--<tr data-id="2" style="background-color:#E4E1E0">
								        		<td colspan="5">
													<strong>DRUGS DISPENSED</strong>
												</td>
											</tr>-->
								<?php
										while($row_ddruglist=mysqli_fetch_assoc($query_run_ddruglist))
										{
											$drug_disp_list_id = $row_ddruglist['drug_disp_list_id'];
											$drug_id = $row_ddruglist['drug_id'];
											$query_rdl = "SELECT MAX(amount_bill) AS amount_bill, SUM(amount_rec) AS total_rec FROM receipt_items WHERE item_list_id='$drug_disp_list_id' AND item_id='$drug_id' AND category_id=2";
								    		$query_run_rdl = mysqli_query($con, $query_rdl);
								    		$row_rdl=mysqli_fetch_assoc($query_run_rdl);
								    		if($row_rdl['amount_bill'] == NULL)
								    			{
								    				$amount_bill = number_format($row_ddruglist['amt_cash'], 2);
								    				$amount_paid = number_format($row_rdl['total_rec'], 2);
								    				$amount_left = number_format($row_ddruglist['amt_cash'] - $row_rdl['total_rec'], 2);
								    			}
								    		else if($row_rdl['amount_bill'] !== NULL)
								    			{
								    				$amount_bill = number_format($row_rdl['amount_bill'], 2);
								    				$amount_paid = number_format($row_rdl['total_rec'], 2);
								    				$amount_left = number_format($row_rdl['amount_bill'] - $row_rdl['total_rec'], 2);
								    			};
								    		
								    		if ($row_rdl['amount_bill'] == NULL || $row_rdl['amount_bill'] > $row_rdl['total_rec'])
											{
												$query_drugs = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
						        				$query_run_drugs = mysqli_query($con, $query_drugs);
						        				$row_drugs=mysqli_fetch_assoc($query_run_drugs);
						        				$i++;
						        	?>
												<tr id="bill_list<?php echo $i;?>">
									        		<td>
														<?php echo $row_drugs['brand_name'];?>
													</td>
									        		<td class="amt-td">
									        			<?php echo $amount_bill;?>
									        		</td>
									        		<td class="amt-td">
									        			<?php echo $amount_paid;?>
									        		</td>
									        		<td class="amt-td">
									        			<?php echo $amount_left;?>
									        		</td>
									        		<td class="action-td">
									        			<a href="#" 
									        				id="btn_receipt_enter" 
									        				data-id="<?php echo $row_ddruglist['drug_disp_list_id'];?>"
									        				data-id2="<?php echo $row_ddruglist['drug_id'];?>"
									        				data-id3="2"
									        			><i class="fa fa-receipt"></i></a>
									        		</td>
									        	</tr>
								<?php
											};
										};
									};
			                	?>

			                	<?php
								    $query_consumlist = "SELECT * FROM consumable_list WHERE attend_id='$attend_id' ORDER BY date DESC";
								    $query_run_consumlist = mysqli_query($con, $query_consumlist);
								    if (mysqli_num_rows($query_run_consumlist) > 0)
									{;
								?>
											<!--<tr data-id="7" style="background-color:#E4E1E0">
								        		<td colspan="5">
													<strong>CONSUMABLES</strong>
												</td>
											</tr>-->
								<?php
										while($row_consumlist=mysqli_fetch_assoc($query_run_consumlist))
										{
											$con_list_id = $row_consumlist['con_list_id'];
											$con_id = $row_consumlist['con_id'];
											$query_rcl = "SELECT MAX(amount_bill) AS amount_bill, SUM(amount_rec) AS total_rec FROM receipt_items WHERE item_list_id='$con_list_id' AND item_id='$con_id' AND category_id=7";
								    		$query_run_rcl = mysqli_query($con, $query_rcl);
								    		$row_rcl=mysqli_fetch_assoc($query_run_rcl);
								    		if($row_rcl['amount_bill'] == NULL)
								    			{
								    				$amount_bill = number_format($row_consumlist['amount_cash'], 2);
								    				$amount_paid = number_format($row_rcl['total_rec'], 2);
								    				$amount_left = number_format($row_consumlist['amount_cash'] - $row_rcl['total_rec'], 2);
								    			}
								    		else if($row_rcl['amount_bill'] !== NULL)
								    			{
								    				$amount_bill = number_format($row_rcl['amount_bill'], 2);
								    				$amount_paid = number_format($row_rcl['total_rec'], 2);
								    				$amount_left = number_format($row_rcl['amount_bill'] - $row_rcl['total_rec'], 2);
								    			};
								    		
								    		if ($row_rcl['amount_bill'] == NULL || $row_rcl['amount_bill'] > $row_rcl['total_rec'])
											{
												$query_consum = "SELECT * FROM consumable WHERE con_id='$con_id'";
						        				$query_run_consum = mysqli_query($con, $query_consum);
						        				$row_consum=mysqli_fetch_assoc($query_run_consum);
						        				$i++;
						        	?>
												<tr id="bill_list<?php echo $i;?>">
									        		<td>
														<?php echo $row_consum['consumable'];?>
													</td>
									        		<td class="amt-td">
									        			<?php echo $amount_bill;?>
									        		</td>
									        		<td class="amt-td">
									        			<?php echo $amount_paid;?>
									        		</td>
									        		<td class="amt-td">
									        			<?php echo $amount_left;?>
									        		</td>
									        		<td class="action-td">
									        			<a href="#" 
									        				id="btn_receipt_enter" 
									        				data-id="<?php echo $row_consumlist['con_list_id'];?>"
									        				data-id2="<?php echo $row_consumlist['con_id'];?>"
									        				data-id3="7"
									        			><i class="fa fa-receipt"></i></a>
									        		</td>
									        	</tr>
								<?php
											};
										};
									};
			                	?>

			                	<?php
								    $query_surgerylist = "SELECT * FROM surgery_list WHERE attend_id='$attend_id' ORDER BY date DESC";
								    $query_run_surgerylist = mysqli_query($con, $query_surgerylist);
								    if (mysqli_num_rows($query_run_surgerylist) > 0)
									{;
								?>
											<!--<tr data-id="5" style="background-color:#E4E1E0">
								        		<td colspan="5">
													<strong>SURGERIES/PROCEDURES</strong>
												</td>
											</tr>-->
								<?php
										while($row_surgerylist=mysqli_fetch_assoc($query_run_surgerylist))
										{
											$surgery_list_id = $row_surgerylist['surgery_list_id'];
											$surgery_id = $row_surgerylist['surgery_id'];
											$query_rsgl = "SELECT MAX(amount_bill) AS amount_bill, SUM(amount_rec) AS total_rec FROM receipt_items WHERE item_list_id='$surgery_list_id' AND item_id='$surgery_id' AND category_id=5";
								    		$query_run_rsgl = mysqli_query($con, $query_rsgl);
								    		$row_rsgl=mysqli_fetch_assoc($query_run_rsgl);
								    		if($row_rsgl['amount_bill'] == NULL)
								    			{
								    				$amount_bill = number_format($row_surgerylist['amount_cash'], 2);
								    				$amount_paid = number_format($row_rsgl['total_rec'], 2);
								    				$amount_left = number_format($row_surgerylist['amount_cash'] - $row_rsgl['total_rec'], 2);
								    			}
								    		else if($row_rsgl['amount_bill'] !== NULL)
								    			{
								    				$amount_bill = number_format($row_rsgl['amount_bill'], 2);
								    				$amount_paid = number_format($row_rsgl['total_rec'], 2);
								    				$amount_left = number_format($row_rsgl['amount_bill'] - $row_rsgl['total_rec'], 2);
								    			};
								    		
								    		if ($row_rsgl['amount_bill'] == NULL || $row_rsgl['amount_bill'] > $row_rsgl['total_rec'])
											{
												$query_surgery = "SELECT * FROM surgery WHERE surgery_id='$surgery_id'";
						        				$query_run_surgery = mysqli_query($con, $query_surgery);
						        				$row_surgery=mysqli_fetch_assoc($query_run_surgery);
						        				$i++;
					        	?>
											
												<tr id="bill_list<?php echo $i;?>">
									        		<td>
														<?php echo $row_surgery['surgery'];?>
													</td>
									        		<td class="amt-td">
									        			<?php echo $amount_bill;?>
									        		</td>
									        		<td class="amt-td">
									        			<?php echo $amount_paid;?>
									        		</td>
									        		<td class="amt-td">
									        			<?php echo $amount_left;?>
									        		</td>
									        		<td class="action-td">
									        			<a href="#" 
									        				id="btn_receipt_enter" 
									        				data-id="<?php echo $row_surgerylist['surgery_list_id'];?>"
									        				data-id2="<?php echo $row_surgerylist['surgery_id'];?>"
									        				data-id3="7"
									        			><i class="fa fa-receipt"></i></a>
									        		</td>
									        	</tr>
								<?php
											};
										};
									};
			                	?>
			                </tbody>
					    </table>
					</div>
				</div>
				<div class="col-md-6 mb-6">
				 	<div class="table-responsive" id="attend_receiptlist_table">
				 		<table class="table table-hover table-bordered table-sm" id="receiptlist_table" width="100%" cellspacing="0">
			                <thead>
			                    <tr>
			                        <th>RECEIPT DESCRIPTION</th>
			                        <th>AMT BAL</th>
			                        <th>AMT PAID</th>
			                        <th>ACTION</th>
			                    </tr>
			                </thead>
				                <tbody class="pv-table-body" id="attend_receiptlist_table_body">
				                	
				                </tbody>
					    </table>
					</div>
				</div>
			</div>
		</form>
	</div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>