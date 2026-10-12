<?php
	include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
    $query = "SELECT * FROM drug_list WHERE attend_id='$attend_id' ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);

	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
?>

<ul class="nav nav-tabs">
	<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#current_drugs">Current Drugs</a></li>
	<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#drug_history">Drug History</a></li>
</ul>
<div class="tab-content">
	<div id="current_drugs" class="tab-pane fade show active">
		<div class="form-row">
			<div class="col-md-6 mb-6">
				<div class="form-row">
					<div class="col-md-3 mb-3">
						<?php
							if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Cashier_Attendance_list'] == 'Yes')) 
							{
								echo '<a href="#" 
								id="btn_new_receipt" 
								data-id="'.$_SESSION['attend_id'].'" 
								data-id1="'.$_SESSION['name'].'"
								data-id2="'.$_SESSION['patient_id'].'">New Receipt</a>';
							};
						?>
					</div>
					<div class="col-md-3 mb-3">
					</div>
					<div class="col-md-3 mb-3">
					</div>
					<div class="col-md-3 mb-3">
					</div>
				</div>
			</div>
			<div class="col-md-6 mb-6">
				<div class="form-row">
					<div class="col-md-3 mb-3">
						<a href="#" id="drug_history_icon"><i class="fa fa-history fa-lg"></i> Past Medicines</a>
					</div>
					<div class="col-md-3 mb-3">
						<a href="#" id="drug_prescription_icon"><i class="fas fa-file-prescription fa-lg"></i> Prescription</a>
					</div>
					<div class="col-md-3 mb-3">
						<a href="#" id="drug_chart_icon"><i class="fas fa-chart-line fa-lg"></i> Drug Chart</a>
					</div>
					<div class="col-md-3 mb-3">
						<a href="#" id="drug_patient_returns_icon"><i class="fa fa-capsules fa-lg"></i> Patient Drug Returns (PDR)</a>
					</div>
				</div>
			</div>
		</div>
		<?php
			if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Prescription'] == 'Yes')) 
			{
				echo '<div class="form-row">
					<div class="col-md-12 mb-12">
						<form id="drug_attend_form" method="POST">
							<div class="form-row">
								<div class="col-md-2 mb-2">
									<label for="drug"><a href="#" id="btn_drug_live_search" data-id="'.$_SESSION['attend_id'].'"><h5><strong>Click to add Drug</strong></h5></a></label>
								</div>
								<div class="col-md-4 mb-4">
									<select class="form-control bg-light" name="composite_drug_select" id="composite_drug_select"> 
										<option value="0">Please Select Composite Drug</option>';
										
										$sql_comp="SELECT * FROM composite_drugs";
										$result_comp = mysqli_query($con,$sql_comp);
										while($row_comp = mysqli_fetch_array($result_comp))
										{
											echo'<option value = "'.$row_comp['composite_drug_id'].'">'.$row_comp['composite_drug'].'</option>';
										};
									echo '</select>
								</div>
								<div class="col-md-1 mb-1">
									<select class="form-control bg-light text-center" name="composite_days" id="composite_days"> 
										<option value="0">Days</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
									</select>
								</div>
								<div class="col-md-1 mb-1">
									<button type="submit" name="composite_drug_enter_btn" id="composite_drug_enter_btn" class="btn btn-primary btn-block">Execute</button>
								</div>
								<div class="col-md-4 mb-4" id="dispensing_company_div">
									<select class="form-control bg-light" name="dispensing_company" id="dispensing_company"> 
										<option value="0">Select Dispenser</option>';
										
										$dispensing_company = $_SESSION['dispensing_company'];
										$sql_comp="SELECT * FROM company";
										$result_comp = mysqli_query($con, $sql_comp);
										while($row_comp = mysqli_fetch_array($result_comp))
										{
											if($row_comp['company_id'] == $dispensing_company)
											{
												echo'<option value = "'.$row_comp['company_id'].'" selected="selected">'.$row_comp['trading_name'].'</option>';
											}
											else
											{
												echo'<option value = "'.$row_comp['company_id'].'">'.$row_comp['trading_name'].'</option>';
											};
										};
									echo '</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-7 mb-7">
									<select class="form-control" name="drug" id="drug" hidden="true"> 
										<option value="0">Please Select</option>';
											$sql_drug_detail="SELECT * FROM stock_items ORDER BY stock_item ASC";
											$result_drug_detail = mysqli_query($con,$sql_drug_detail);
											while($row_drug_detail = mysqli_fetch_array($result_drug_detail))
											{
												echo'<option value = "'.$row_drug_detail['stock_item_id'].'">'.$row_drug_detail['stock_item'].'</option>';
											};
									echo'</select>
								</div>
								<div class="col-md-3 mb-3" hidden="true">
									<label for="dosage">Dosage</label>
									<input type="text" class="form-control" name="dosage" id="dosage">
								</div>
								<div class="col-md-2 mb-2" hidden="true">
									<label for="qty_presc">Qty</label>
									<input type="text" class="form-control" name="qty_presc" id="qty_presc">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-3 mb-3" hidden="true">
									<label for="drug_date">Date</label>
									<input type="date" class="form-control" name="drug_date" id="drug_date" value="'.$date.'">
								</div>';
								if (
									$_SESSION['user_type'] == 'Ultra_Super_User' OR 
									$_SESSION['user_type'] == 'Super_User' OR 
									($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
								{
									echo'
									<div class="col-md-5 mb-5" hidden="true">
										<label for="drug_sponsor">Sponsor</label>
											<select class="form-control" name="drug_sponsor" id="drug_sponsor"> 
												<option value="0">Please Select</option>';
												
													$sponsor_option = set_sponsor_list();
													echo $sponsor_option;
												
											echo'</select>
									</div>
									<div class="col-md-2 mb-2" hidden="true">
										<label for="drug_price_est">Price</label>
										<input type="text" class="form-control" name="drug_price_est" id="drug_price_est">
									</div>
									<div class="col-md-2 mb-2" hidden="true">
										<label for="drug_amt_est">Amount</label>
										<input type="text" class="form-control" name="drug_amt_est" id="drug_amt_est">
									</div>';
								};
							echo'</div>
							<div class="form-row" hidden="true">
								<div class="col-md-12 mb-12">
									<label for="drug_comment">Comment</label>
									<textarea type="textarea" rows="2"  class="form-control" name="drug_comment" id="drug_comment" value=""></textarea>
									<input type="hidden" name="drug_list_id" class="form-control" id="drug_list_id" value="">
									<input type="hidden" name="drug_gender" class="form-control" id="drug_gender" value="">
									<input type="hidden" name="drug_age_from" class="form-control" id="drug_age_from" value="">
									<input type="hidden" name="drug_age_to" class="form-control" id="drug_age_to" value="">
								</div>
							</div>
							<hr class="d-none d-md-block" hidden="true">
							<div id="drug_save_update" hidden="true">
								<button type="submit" id="drug_sheet_save_btn" name="drug_sheet_save_btn" class="btn btn-primary">Save</button>
							</div>
						</form>
					</div>
				</div>';
			};
		?>
		<div class="table-responsive" id="attend_drug_table">
			<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th class="action-td">Date</th>
						<th class="action-td">Time</th>
						<th class="action-td">Drug</th>
						<th class="action-td">Dosage</th>
						<th class="action-td">Qty Presc.</th>
						<?php
							if (
								$_SESSION['user_type'] == 'Ultra_Super_User' OR 
								$_SESSION['user_type'] == 'Super_User' OR 
								($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
							{
								echo'
								<th class="action-td">Qty Est.</th>
								<th class="action-td">Price Est.</th>
								<th class="action-td">Qty Disp.</th>
								<th class="action-td">Amt-Estimate</th>
								<th class="action-td">Amt-Cash</th>
								<th class="action-td">Amt-Disc</th>
								<th class="action-td" hidden="true">Amt-Prvt</th>
								<th class="action-td" hidden="true">Amt-NHIS</th>';
							};
						?>
						<th class="action-td">Action</th>
					</tr>
				</thead>
				<tbody class="pv-table-body">
					<?php
						if (mysqli_num_rows($query_run) > 0)
						{
							$total_est=0;
							$total_cash=0;
							$total_disc=0;
							$total_prvt=0;
							$total_nhis=0;
							while($row = mysqli_fetch_assoc($query_run))
							{
								$amt_est=0;
								$amt_cash=0;
								$amt_disc=0;
								$amt_prvt=0;
								$amt_nhis=0;

								$drug_id = $row['drug_id'];
								$query_drug = "SELECT * FROM stock_items WHERE stock_item_id='$drug_id'";
								$query_run_drug = mysqli_query($con, $query_drug);
								$row_drug = mysqli_fetch_assoc($query_run_drug);

								$drug_list_id = $row['drug_list_id'];
								$query_ddisp = "SELECT SUM(amt_cash) AS amt_cash, MAX(price_cash) AS price_cash, SUM(amt_prvt) AS amt_prvt, SUM(amt_nhis) AS amt_nhis, SUM(qty) AS qty FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
								$query_run_ddisp = mysqli_query($con, $query_ddisp);
								$row_ddisp=mysqli_fetch_assoc($query_run_ddisp);

								$query_receipt_item = "SELECT * FROM `receipt_items` WHERE `attend_id` = '$attend_id' AND `category_id` = 2 
								AND `item_list_id`='$drug_list_id'";
								$query_run_receipt_item = mysqli_query($con, $query_receipt_item);
								$rows_receipt_item_count = mysqli_num_rows($query_run_receipt_item);

								$query_ddl = "SELECT drug_id FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
								$query_run_ddl = mysqli_query($con, $query_ddl);
								if(mysqli_num_rows($query_run_ddl) > 0)
								{
									$sup_drugs = '';
									while($row_ddl=mysqli_fetch_assoc($query_run_ddl))
									{
										$drug_id_ddl = $row_ddl['drug_id'];
										$query_drug_ddl = "SELECT * FROM stock_items WHERE stock_item_id='$drug_id_ddl'";
										$query_run_drug_ddl = mysqli_query($con, $query_drug_ddl);
										$row_drug_ddl = mysqli_fetch_assoc($query_run_drug_ddl);
										$sup_drugs .= $row_drug_ddl['stock_item'].'<br>';
									};
								}
								else
								{
									$sup_drugs = 'Not dispensed yet';
								};
								
								$query_prescriber = "SELECT created_by FROM  drug_list WHERE drug_list_id='$drug_list_id'";
								$query_run_prescriber = mysqli_query($con, $query_prescriber);
								if(mysqli_num_rows($query_run_prescriber) > 0)
								{
									$p_user = '';
									while($row_prescriber=mysqli_fetch_assoc($query_run_prescriber))
									{
										$prescriber_id = $row_prescriber['created_by'];
										$query_p_user = "SELECT * FROM users WHERE id='$prescriber_id'";
										$query_run_p_user = mysqli_query($con, $query_p_user);
										$row_p_user = mysqli_fetch_assoc($query_run_p_user);
										
										if(isset($row_p_user['first_name']) && !empty($row_p_user['first_name']))
										{
											$p_user = $row_p_user['first_name'];
										}
										else
										{
											$p_user = 'No Prescriber';
										};
									};
								}
								else
								{
									$p_user = 'No Prescriber';
								};
								
								$query_dispenser = "SELECT created_by FROM  drug_dispense_list WHERE drug_list_id='$drug_list_id'";
								$query_run_dispenser = mysqli_query($con, $query_dispenser);
								if(mysqli_num_rows($query_run_dispenser) > 0)
								{
									$d_user = '';
									while($row_dispenser = mysqli_fetch_assoc($query_run_dispenser))
									{
										$dispenser_id = $row_dispenser['created_by'];
										$query_d_user = "SELECT * FROM users WHERE id='$dispenser_id'";
										$query_run_d_user = mysqli_query($con, $query_d_user);
										$row_d_user = mysqli_fetch_assoc($query_run_d_user);
										$d_user = $row_d_user['first_name'];
									};
								}
								else
								{
									$d_user = 'No Dispenser';
								};

								$query_dadmin = "SELECT SUM(qty_admin) AS qty_admin FROM  drug_admin WHERE drug_id='$drug_id' AND drug_list_id='$drug_list_id'";
								$query_run_dadmin = mysqli_query($con, $query_dadmin);
								if(isset($query_run_dadmin))
								{
									$row_dadmin = mysqli_fetch_assoc($query_run_dadmin);
									$qty_admin = $row_dadmin['qty_admin'];
								}
								else
								{
									$qty_admin = 0;
								};

								$query_returned = "SELECT SUM(qty) AS qty_returned FROM  drug_patient_returns WHERE drug_id='$drug_id' AND drug_list_id='$drug_list_id'";
								$query_run_returned = mysqli_query($con, $query_returned);
								if(isset($query_run_returned))
								{
									$row_returned = mysqli_fetch_assoc($query_run_returned);
									$qty_returned = $row_returned['qty_returned'];
								}
								else
								{
									$qty_returned = 0;
								};

								$query_disc = "SELECT SUM(amount) AS amount FROM discount WHERE drug_list_id='$drug_list_id'";
								$query_run_disc = mysqli_query($con, $query_disc);
								$row_disc = mysqli_fetch_assoc($query_run_disc);
								if (isset($row_disc)) {
									$amt_disc = $row_disc['amount'];
								} else 
								{
									$amt_disc = 0;
								};
								?>
								<tr  id="<?php echo $drug_list_id;?>">
									<td class="action-td"><?php echo $row['date'];?></td>
									<td class="action-td"><?php echo $row['created_datetime'].'<br><small>Prescribed by:'.$p_user.', Dispensed by:'.$d_user.'</small>';?></td>
									<td style="display: none;"><strong><?php echo $row_drug['stock_item'];?></strong></td>
									<td><strong><?php echo $row_drug['stock_item'];?></strong><br><small><?php echo $sup_drugs;?></small></td>
									<td class="action-td">
										<?php 
											if($row['qty_presc'] < 1)
											{
												echo '<a href="#" 
													id="btn_drug_edit_qty" 
													data-id="'.$row['drug_list_id'].'"
													data-id1="'.$row_drug['stock_item'].'">
													'.$row['dosage'].'
												</a>';
											}
											else
											{
												echo $row['dosage'];
											};
										?>
									</td>
									<td class="action-td"><?php echo $row['qty_presc'];?></td>
								<?php
									if (
										$_SESSION['user_type'] == 'Ultra_Super_User' OR 
										$_SESSION['user_type'] == 'Super_User' OR 
										($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
									{
										echo'<td class="action-td">
												<input type="text" class="form-control drug_list_qty_est" name="drug_list_qty_est" id="drug_list_qty_est'.$drug_list_id.'" 
													value="'.$row['qty_est'].'"
													data-id="'.$row['drug_list_id'].'"
													data-id1="'.$row['attend_id'].'"
												>
											</td>
											<td class="action-td">
												<input type="text" class="form-control drug_list_price_est" name="drug_list_price_est" id="drug_list_price_est'.$drug_list_id.'" 
													value="'.$row['price_est'].'"
													data-id="'.$row['drug_list_id'].'"
													data-id1="'.$row['attend_id'].'"
												>
											</td>
											<td class="action-td">'.$row_ddisp['qty'].'</td>
											<td class="amt-td">'.$row['amount_est'].'</td>
											<td class="amt-td">'.$row['amount_cash'].'</td>
											<td class="amt-td">'.$amt_disc.'</td>
											<td class="amt-td">'.$row['amount_prvt'].'</td>';
									};
										$total_est+=$row['amount_est'];
										$total_cash+=$row['amount_cash'];
										$total_disc+=$amt_disc;
										$total_prvt+=$row['amount_prvt'];
								?>
									<td class="action-td">
										<?php 
											if($row_ddisp['qty'] <= 0)
											{
												if ($_SESSION['user_id'] == $row['user_id']) 
												{
													if($row['date'] == $date_today)
													{
														if (
															$_SESSION['user_type'] == 'Ultra_Super_User' OR 
															$_SESSION['user_type'] == 'Super_User' OR 
															($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Prescription'] == 'Yes')) 
														{
															echo'<a href="#" id="btn_edit_drug_list" data-id1="'.$row['drug_list_id'].'">Edit Presc.</a> | ';
														};
													};
												};
											};
											
											if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Validate_Bill'] == 'Yes')) 
											{
												echo '<a href="#" 
													id="btn_validate_bill" 
													data-item_id="'.$row['drug_id'].'"
													data-item_list_id="'.$row['drug_list_id'].'"
													data-sponsor_id="'.$row['ledger_id'].'"
													data-cash_price="'.$row['price_cash'].'"
													data-private_price="'.$row['price_prvt'].'"
													data-item_type="drug"
													data-item_name="'.$row_drug['stock_item'].'"
													>Validate
												</a>';
											};

											if (
												$_SESSION['user_type'] == 'Ultra_Super_User' OR 
												$_SESSION['user_type'] == 'Super_User' OR 
												($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Dispense_Prescription'] == 'Yes')) 
												{
													if((($rows_receipt_item_count > 0 || ($amt_cash - $amt_disc)==0) && $_SESSION['typeofservice_attd'] !=2) || $_SESSION['typeofservice_attd'] ==2)
													{
														echo' | <a href="#" id="btn_disp_drug_list" 
														data-id1="'.$row['drug_list_id'].'" 
														data-id2="'.$row_drug['stock_item_id'].'"
														data-id3="'.$row['dose_dosage'].'"
														data-id4="'.$row['dose_frequency'].'"
														data-id5="'.$row['dose_duration'].'"
														data-id6="'.$row_drug['block_neg'].'">
														Dispense</a>';
													};
												};

											if($row['status']=='')
											{
												if (
												$_SESSION['user_type'] == 'Ultra_Super_User' OR 
												$_SESSION['user_type'] == 'Super_User' OR 
												($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Administer_Prescription'] == 'Yes')) 
												{
													echo'<a href="#" id="btn_admin_drug_list" data-id1="'.$row['drug_list_id'].'" data-id2="'.$row_drug['stock_item_id'].'">
													Administer</a>';
												};
												echo' | <a href="#" id="btn_suspend_drug_list" data-id1="'.$row['drug_list_id'].'" data-id2="'.$row_drug['stock_item_id'].'">
												Suspend</a> | <a href="#" id="btn_complete_drug_list" data-id1="'.$row['drug_list_id'].'" data-id2="'.$row_drug['stock_item_id'].'">
												Complete</a>';
											}
											else if($row['status']=='Suspended')
											{
												echo' | <a href="#" id="btn_unsuspend_drug_list" data-id1="'.$row['drug_list_id'].'" data-id2="'.$row_drug['stock_item_id'].'">
												Unsuspend</a>';
											}
											else if($row['status']=='Completed')
											{
												echo' | <a href="#" id="btn_uncomplete_drug_list" data-id1="'.$row['drug_list_id'].'" data-id2="'.$row_drug['stock_item_id'].'">
												Uncomplete</a>';
											};

											if (
												$_SESSION['user_type'] == 'Ultra_Super_User' OR 
												$_SESSION['user_type'] == 'Super_User' OR 
												($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Administer_Prescription'] == 'Yes')) 
												{
													echo ' | <a href="#" id="btn_admin_drug_list" data-id1="'.$row['drug_list_id'].'" data-id2="'.$row_drug['stock_item_id'].'">
													Administer</a>';
												};
										
											if ($row_ddisp['qty'] > 0) 
											{
												if (
													$_SESSION['user_type'] == 'Ultra_Super_User' OR 
													$_SESSION['user_type'] == 'Super_User' OR 
													($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Label_Prescription'] == 'Yes')) 
												{
													echo ' | <a href="#" id="btn_label_drug_list" data-id1="'.$row['drug_list_id'].'" data-id2="'. $row_drug['stock_item_id'].'">Label</a>';
												};

												if (
													$_SESSION['user_type'] == 'Ultra_Super_User' OR 
													$_SESSION['user_type'] == 'Super_User' OR 
													($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Discount'] == 'Yes')) 
												{
													echo ' | <a href="#" id="btn_discount_drug_list" 
														data-id="'.$row['attend_id'].'"
														data-id1="'.$_SESSION['patient_id'].'"
														data-id2="'.$row['drug_list_id'].'"
														data-id3="'.$_SESSION['name'].'"
														data-id4="'.$row_ddisp['amt_cash'].'"
														data-id5="'.$amt_disc.'">
													Disc.</a>';
												};

												if (
													$_SESSION['user_type'] == 'Ultra_Super_User' OR 
													$_SESSION['user_type'] == 'Super_User' OR 
													($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Patient_Drug_Returns'] == 'Yes')) 
												{
													echo ' | <a href="#" id="btn_patient_drug_returns" 
														data-id="'.$row['attend_id'].'"
														data-id1="'.$_SESSION['patient_id'].'"
														data-id2="'.$row['drug_list_id'].'"
														data-id3="'.$_SESSION['name'].'"
														data-id4="'.$row_ddisp['price_cash'].'"
														data-id5="'.$row['drug_id'].'"
														data-id6="'.$row_drug['stock_item'].'"
														data-id7="2"
														data-id8="'.$row_ddisp['qty'].'"
														data-id9="'.$qty_admin.'"
														data-id10="'.$qty_returned.'">
													Drug Return</a>';
												};
											};
										
											if ($row_ddisp['qty'] <= 0) 
											{
												/*if ($_SESSION['user_id'] == $row['user_id'] OR $_SESSION['user_type'] == 'Ultra_Super_User') 
												{
													if($row['date'] == $date_today)
													{*/
														if (
															$_SESSION['user_type'] == 'Ultra_Super_User' OR 
															$_SESSION['user_type'] == 'Super_User' OR 
															$_SESSION['user_type_id'] == 3 OR 
															($_SESSION['user_type_id'] != 3 AND $_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Prescription'] == 'Yes' AND $row['date'] == $date_today)) 
														{
															echo' | <a href="#" id="btn_delete_drug_list" data-id1="'.$row['drug_list_id'].'">Delete</a>';
														};
													//};
												//};
											};
										?>
									</td>
								</tr>
							<?php
							}
								if (
										$_SESSION['user_type'] == 'Ultra_Super_User' OR 
										$_SESSION['user_type'] == 'Super_User' OR 
										($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
									{
										echo'<tr>
												<td class="action-td" colspan="8">TOTAL</td>
												<td class="amt-td"><?php echo $total_est;?></td>
												<td class="amt-td"><?php echo $total_cash;?></td>
												<td class="amt-td"><?php echo $total_disc;?></td>
												<td class="amt-td"><?php echo $total_prvt;?></td>
												<td class="amt-td"><?php echo $total_nhis;?></td>
												<td class="action-td"></td>
											</tr>';
									};
						};
							?>
				</tbody>
			</table>
		</div>
	</div>
	<div id="drug_history" class="tab-pane fade">
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<?php
					echo'<div class="scroll-card-body" style="height: 50vh">
						<label>Prescription History</label>
						<div class="table-responsive" id="previous_attends_drugs_table">
							<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th class ="action-td">Date</th>
										<th>Drug</th>
										<th class ="action-td">Qty Presc.</th>
										<th class ="action-td">Dosage</th>';
										if (
											$_SESSION['user_type'] == 'Ultra_Super_User' OR 
											$_SESSION['user_type'] == 'Super_User' OR 
											($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Perform_MUR'] == 'Yes')) 
										{
											echo'<th>MUR</th>';
										};
									echo'</tr>
								</thead>
								<tbody class="pv-table-body">';
										$query_ht = "SELECT * FROM drug_list WHERE patient_id='$patient_id' AND attend_id!='$attend_id' ORDER BY date DESC";
										$query_run_ht = mysqli_query($con, $query_ht);
										if (mysqli_num_rows($query_run_ht) > 0)
										{
											while($row_ht=mysqli_fetch_assoc($query_run_ht))
											{
												$drug_id = $row_ht['drug_id'];
												$query_drug_ht = "SELECT * FROM stock_items WHERE stock_item_id='$drug_id'";
												$query_run_drug_ht = mysqli_query($con, $query_drug_ht);
												$row_drug_ht=mysqli_fetch_assoc($query_run_drug_ht);
									
												echo'<tr>
													<td class ="action-td">
														<a href="#" 
															id="btn_drug_ht_list" 
															data-id="'.$row_ht['drug_id'].'"
															data-id1="'.$row_ht['qty_presc'].'"
															data-id2="'.$row_ht['dosage'].'"
														>
															'.$row_ht['date'].'
														</a>
													</td>
													<td>
														<a href="#" 
															id="btn_drug_ht_list" 
															data-id="'.$row_ht['drug_id'].'"
															data-id1="'.$row_ht['qty_presc'].'"
															data-id2="'.$row_ht['dosage'].'"
														>
															'.$row_drug_ht['stock_item'].'
														</a>
													</td>
													<td class ="action-td">
														<a href="#" 
															id="btn_drug_ht_list" 
															data-id="'.$row_ht['drug_id'].'"
															data-id1="'.$row_ht['qty_presc'].'"
															data-id2="'.$row_ht['dosage'].'"
														>
															'.$row_ht['qty_presc'].'
														</a>
													</td>
													<td class ="action-td">
														<a href="#" 
															id="btn_drug_ht_list" 
															data-id="'.$row_ht['drug_id'].'"
															data-id1="'.$row_ht['qty_presc'].'"
															data-id2="'.$row_ht['dosage'].'"
														>
															'.$row_ht['dosage'].'
														</a>
													</td>';
													if (
														$_SESSION['user_type'] == 'Ultra_Super_User' OR 
														$_SESSION['user_type'] == 'Super_User' OR 
														($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Perform_MUR'] == 'Yes')) 
													{
														echo'<td class ="action-td">
															<a href="#" 
																id="btn_drug_mur" 
																data-id="'.$row_ht['drug_id'].'"
																data-id1="'.$row_ht['drug_list_id'].'"
																data-id2="'.$row_ht['attend_id'].'"
															>
																<i class="fa fa-question-circle" aria-hidden="true"></i>
															</a>
														</td>';
													};

												echo'</tr>';
											};
										};
								
								echo'</tbody>
							</table>
						</div>
					</div>';
				?>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-xl" id="drug_patient_returns_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary">Patient Drug Returns</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<form id="drug_patient_returns_form" method="POST">
						<div id="drug_patient_returns_inputs">
							<div class="form-row">
								<div class="col-md-6 mb-6">
									<label for="dpr_drug_id">Drug</label>
									<input type="text" class="form-control" name="dpr_category" id="dpr_category" hidden="true">
									<input type="text" class="form-control" name="dpr_drug_list_id" id="dpr_drug_list_id" hidden="true">
									<input type="text" class="form-control" name="drug_pat_return_id" id="drug_pat_return_id" hidden="true">
									<select class="form-control" name="dpr_drug_id" id="dpr_drug_id"> 
							    		<option value="0">Please Select</option>
								        <?php
								        	$sql="SELECT * FROM stock_items ORDER BY stock_item ASC";
											$result = mysqli_query($con, $sql);
								            while($row = mysqli_fetch_array($result))
								            {
								        ?>
								            <option value = "<?php echo($row['stock_item_id'])?>" >
								                <?php echo($row['stock_item']) ?>
								            </option>
								        <?php
								            }
								        ?>
							    	</select>
								</div>
								<div class="col-md-3 mb-3">
									<label for="dpr_warehouse_id">Warehouse</label>
									<select type="text" class="form-control" name="dpr_warehouse_id" id="dpr_warehouse_id">
							    		<option value="0">Please Select</option>
								        <?php
								        	$sql="SELECT * FROM warehouse ORDER BY warehouse_desc ASC";
											$result=mysqli_query($con,$sql);
								            while($row=mysqli_fetch_array($result))
								            {
								        ?>
								            <option value = "<?php echo($row['warehouse_id'])?>" >
								                <?php echo($row['warehouse_desc']) ?>
								            </option>
								        <?php
								            }
								        ?>
							    	</select>
								</div>
								<div class="col-md-3 mb-3">
									<label for="dpr_date">Date</label>
									<input type="date" class="form-control" name="dpr_date" id="dpr_date">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-2 mb-2">
									<label for="dpr_batch_no">Batch No</label>
									<input type="text" class="form-control" name="dpr_batch_no" id="dpr_batch_no">
								</div>
								<div class="col-md-2 mb-2">
									<label for="dpr_expiry_date">Expiry Date</label>
									<input type="date" class="form-control" name="dpr_expiry_date" id="dpr_expiry_date">
								</div>
								<div class="col-md-2 mb-2">
									<label for="dpr_max_qty">Max Qty</label>
									<input type="text" class="form-control" name="dpr_max_qty" id="dpr_max_qty" hidden="true">
									<input type="text" class="form-control" name="dpr_max_qty_d" id="dpr_max_qty_d" disabled="true">
								</div>
								<div class="col-md-2 mb-2">
									<label for="dpr_qty">Qty</label>
									<input type="text" class="form-control" name="dpr_qty" id="dpr_qty">
								</div>
								<div class="col-md-2 mb-2">
									<label for="dpr_price">Price</label>
									<input type="text" class="form-control" name="dpr_price" id="dpr_price">
								</div>
								<div class="col-md-2 mb-2">
									<label for="dpr_amount">Amount</label>
									<input type="text" class="form-control" name="dpr_amount" id="dpr_amount">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 mb-12">
									<label for="dpr_narration">Reason</label>
									<input type="text" class="form-control" name="dpr_narration" id="dpr_narration">
								</div>
							</div>
						</div>
						<div class="table-responsive" id="drug_patient_returns_table">
						</div>
					</div>
					<div class="modal-footer">
					    <button type="button" id="save_drug_patient_returns"  class="btn btn-primary">Save</button>
					    <button type="button" id="update_drug_patient_returns" class="btn btn-primary">Update</button>
					    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					</div>
				</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="drug_history_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary">Medicine History</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive" id="attend_drug_history_table">
				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-md" id="drug_duplicate_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary">Drug Duplicate</h5>
			</div>
			<div class="modal-body">
				<p id="drug_duplicate_modal_question"></p>
			</div>
			<div class="modal-footer">
			    <button type="button" id="drug_dup_yes" name="drug_dup_yes"class="btn btn-danger">Yes</button>
			    <button type="button" id="drug_dup_no" name="drug_dup_no"class="btn btn-primary">No</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="drug_dispense_modal" tabindex="-1" role="dialog" aria-labelledby="drug_dispense_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" style="max-width: 95%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="drug_dispense_modal_title">Drug Dispensing</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<form id="drug_dispense_form" method="POST">
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="drug_id_dp">Drug Prescribed</label>
							<input  type="text" class="form-control" name="drug_block_neg_dp" id="drug_block_neg_dp" hidden="true"> 
							<select class="form-control" name="drug_id_dp" id="drug_id_dp" hidden="true"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM stock_items ORDER BY stock_item ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
										echo '<option value = "'.$row['stock_item_id'].'">'.$row['stock_item'].'</option>';
						            }
						        ?>
					    	</select>
					    	<select class="form-control" name="drug_id_dp2" id="drug_id_dp2" disabled="true"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM stock_items ORDER BY stock_item ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
										echo '<option value = "'.$row['stock_item_id'].'">'.$row['stock_item'].'</option>';
						            }
						        ?>
					    	</select>
						</div>
						<div class="col-md-2 mb-2">
							<label for="dosage_dp">Dosage</label>
							<input type="text" class="form-control" name="dosage_dp" id="dosage_dp" hidden="true">
							<input type="text" class="form-control" name="dosage_dp2" id="dosage_dp2" disabled="true">
						</div>
						<div class="col-md-2 mb-2">
							<label for="qty_presc_dp">Qty Presc</label>
							<input type="text" class="form-control" name="qty_presc_dp" id="qty_presc_dp" hidden="true">
							<input type="text" class="form-control" name="qty_presc_dp2" id="qty_presc_dp2" disabled="true">
						</div>
						<div class="col-md-2 mb-2">
							<label for="date_presc_dp">Date Presc</label>
							<input type="date" class="form-control" name="date_presc_dp" id="date_presc_dp" hidden="true">
							<input type="date" class="form-control" name="date_presc_dp2" id="date_presc_dp2" disabled="true">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4 mb-4">
							<label for="drug_id_disp">Drug Dispensed</label>
							<select class="form-control" name="drug_id_disp" id="drug_id_disp"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM stock_items ORDER BY stock_item ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            	echo '<option value = "'.$row['stock_item_id'].'">'.$row['stock_item'].'</option>';
						    		}
						        ?>
					    	</select>
						</div>
						<div class="col-md-1 mb-1">
							<label for="dosage_dp_dose">Dose</label>
							<input type="text" name="dosage_dp_dose" class="form-control dosaging" id="dosage_dp_dose">
						</div>
						<div class="col-md-1 mb-1">
							<label for="dosage_dp_frequency">Frequency</label>
							<select class="form-control dosaging" name="dosage_dp_frequency" id="dosage_dp_frequency"> 
								<option value="0">Please Select</option>
								<option value="DAILY">DAILY</option>
								<option value="BD">BD</option>
								<option value="TDS">TDS</option>
								<option value="TID">TID</option>
								<option value="QID">QID</option>
								<option value="NOCTE">NOCTE</option>
								<option value="STAT">STAT</option>
								<option value="APPLY">APPLY</option>
							</select>
						</div>
						<div class="col-md-1 mb-1">
							<label for="dosage_dp_duration">Duration</label>
							<input type="text" name="dosage_dp_duration" class="form-control" id="dosage_dp_duration">
						</div>
						<div class="col-md-2 mb-2">
							<label for="dosage_disp">Dosage</label>
							<input type="text" class="form-control" name="dosage_disp" id="dosage_disp">
						</div>
						<div class="col-md-1 mb-1">
							<label for="qty_issue_dp">Qty Dispense</label>
							<input type="text" class="form-control" name="qty_issue_dp" id="qty_issue_dp">
						</div>
						<div class="col-md-2 mb-2">
							<label for="date_disp">Date Dispesed</label>
							<input type="date" class="form-control" name="date_disp" id="date_disp">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="drug_sponsor">Sponsor</label>
							<select class="form-control" name="drug_sponsor" id="drug_sponsor"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sponsor_option = set_sponsor_list();
						        	echo $sponsor_option;
						        ?>
						    </select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="loc_id_dp">Location</label>
							<select class="form-control" name="loc_id_dp" id="loc_id_dp"> 
					    		<option value="0">Please Select</option>
						        <?php
									$company_id = $_SESSION['company_id'];
									$warehouse_id = $_SESSION['warehouse_id'];
						        	$sql="SELECT * FROM warehouse WHERE company_id = '$company_id' ORDER BY warehouse_desc ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
										if($row['warehouse_id'] == $warehouse_id)
										{
											echo '<option value = "'.$row['warehouse_id'].'" selected = "selected">
											'.$row['warehouse_desc'].'</option>';
										}
										else
										{
											echo '<option value = "'.$row['warehouse_id'].'" >
											'.$row['warehouse_desc'].'</option>';
										};
						            };
						        ?>
					    	</select>
						</div>
						<div class="col-md-2 mb-2">
							<label for="batch_no_dp">Batch No</label>
							<input type="text" class="form-control" name="batch_no_dp" id="batch_no_dp">
							<input type="hidden" name="drug_expiry_date_dp" class="form-control" id="drug_expiry_date_dp" value="">
						</div>
						<div class="col-md-2 mb-2">
							<label for="drugprice_dp">Price</label>
							<input type="text" class="form-control" name="drug_price_cash_dp" id="drug_price_cash_dp">
							<!--<input type="text" class="form-control" name="drug_price_cash_dp2" id="drug_price_cash_dp2" disabled="true">-->
							<input type="hidden" class="form-control" name="drug_price_nhis_dp" id="drug_price_nhis_dp">
							<input type="hidden" class="form-control" name="drug_price_prvt_dp" id="drug_price_prvt_dp">
						</div>
						<div class="col-md-2 mb-2">
							<label for="drugamt_dp">Amount</label>
							<input type="hidden" class="form-control" name="drug_amt_cash_dp" id="drug_amt_cash_dp">
							<input type="text" class="form-control" name="drug_amt_cash_dp2" id="drug_amt_cash_dp2" disabled="true">
							<input type="hidden" class="form-control" name="drug_amt_nhis_dp" id="drug_amt_nhis_dp">
							<input type="hidden" class="form-control" name="drug_amt_prvt_dp" id="drug_amt_prvt_dp">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="drug_comment_dp">Comment</label>
							<textarea type="textarea" rows="2"  class="form-control" name="drug_comment_dp" id="drug_comment_dp" value=""></textarea>
							<input type="hidden" name="drug_list_id_dp" class="form-control" id="drug_list_id_dp" value="">
							<input type="hidden" name="drug_gender_dp" class="form-control" id="drug_gender_dp" value="">
							<input type="hidden" name="drug_age_from_dp" class="form-control" id="drug_age_from_dp" value="">
							<input type="hidden" name="drug_age_to_dp" class="form-control" id="drug_age_to_dp" value="">
							<input type="hidden" name="drug_negative_dp" class="form-control" id="drug_negative_dp" value="">
							<input type="hidden" name="drug_batch_dp" class="form-control" id="drug_batch_dp" value="">
							<input type="hidden" name="drug_expiry_dp" class="form-control" id="drug_expiry_dp" value="">
							<input type="hidden" name="drug_days_dp" class="form-control" id="drug_days_dp" value="">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4 mb-4">
							<label for="total_av_qty_dp">Total Available Qty</label>
							<input type="text" class="form-control" name="total_av_qty_dp" id="total_av_qty_dp" disabled="true">
						</div>
						<div class="col-md-4 mb-4">
							<label for="loc_qty_dp">Location Qty</label>
							<input type="text" class="form-control" name="loc_qty_dp" id="loc_qty_dp" disabled="true">
						</div>
						<div class="col-md-4 mb-4">
							<label for="batch_qty_dp">Batch Qty</label>
							<input type="text" class="form-control" name="batch_qty_dp" id="batch_qty_dp" disabled="true">
						</div>
					</div>
				</form>
				<div class="table-responsive" id="drug_dispensed_table">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn_drug_dispense" class="btn btn-primary">Dispense</button>
			    <button type="button" id="btn_cancel_dispense" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-md" id="drug_dispensed_deletion_modal" tabindex="-1" role="dialog" aria-labelledby="drug_dispensed_deletion_modal" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary">Drug Deletion</h5>
			</div>
			<div class="modal-body">
				<p id="drug_dispensed_deletion_modal_question"></p>
			</div>
			<div class="modal-footer">
			    <button type="button" id="drug_disp_del_yes" name="drug_disp_del_yes"class="btn btn-danger">Yes</button>
			    <button type="button" id="drug_disp_del_no" name="drug_disp_del_no"class="btn btn-primary">No</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-md" id="drug_edit_qty_presc_modal" tabindex="-1" role="dialog" aria-labelledby="drug_edit_qty_presc_modal" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary">Edit Prescription Quantity</h5>
			</div>
			<div class="modal-body">
				<h5 id="drug_edit_qty_presc_drug"></h5>
				<div class="form-row">
					<div class="col-md-12 mb-12">
						<label for="drug_edit_qty_presc_qty">Enter Quantity</label>
						<input type="text" class="form-control" name="drug_edit_qty_presc_qty" id="drug_edit_qty_presc_qty">
					</div>
				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" id="drug_edit_qty_presc_save" name="drug_edit_qty_presc_save"class="btn btn-primary">Save</button>
			    <button type="button" id="drug_edit_qty_presc_cancel" name="drug_edit_qty_presc_cancel"class="btn btn-secondary">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="drug_admin_modal" tabindex="-1" role="dialog" aria-labelledby="drug_admin_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="drug_admin_modal_title">Drug Administration</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<form id="drug_admin_form" method="POST">
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="drug_id_da">Drug Description</label>
							<select class="form-control" name="drug_id_dp" id="drug_id_da" hidden> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM stock_items ORDER BY stock_item ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						        ?>
						            <option value = "<?php echo($row['stock_item_id'])?>" >
						                <?php echo($row['stock_item']) ?>
						            </option>
						        <?php
						            }
						        ?>
					    	</select>
					    	<select class="form-control" name="drug_id_da2" id="drug_id_da2" disabled="true"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM stock_items ORDER BY stock_item ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						        ?>
						            <option value = "<?php echo($row['stock_item_id'])?>" >
						                <?php echo($row['stock_item']) ?>
						            </option>
						        <?php
						            }
						        ?>
					    	</select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="dosage_da">Dosage</label>
							<input type="text" class="form-control" name="dosage_da" id="dosage_da" hidden="true">
							<input type="text" class="form-control" name="dosage_da2" id="dosage_da2" disabled="true">
						</div>
						<div class="col-md-3 mb-3">
							<label for="qty_presc_da">Qty Presc</label>
							<input type="text" class="form-control" name="qty_presc_da" id="qty_presc_da" hidden="true">
							<input type="text" class="form-control" name="qty_presc_da2" id="qty_presc_da2" disabled="true">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4 mb-4">
							<label for="route_da">Route</label>
							<select class="form-control" name="route_da" id="route_da"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM drug_route ORDER BY route ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						        ?>
						            <option value = "<?php echo($row['route_id'])?>" >
						                <?php echo($row['route']) ?>
						            </option>
						        <?php
						            }
						        ?>
					    	</select>
						</div>
						<div class="col-md-2 mb-2">
							<label for="qty_admin_da">Qty Admin</label>
							<input type="text" class="form-control" name="qty_admin_da" id="qty_admin_da">
						</div>
						<div class="col-md-2 mb-2">
							<label for="initials_da">Initials</label>
							<input type="text" class="form-control" name="initials_da" id="initials_da">
						</div>
						<div class="col-md-2 mb-2">
							<label for="date_admin_da">Date</label>
							<input type="date" class="form-control" name="date_admin_da" id="date_admin_da">
						</div>
						<div class="col-md-2 mb-2">
							<label for="time_admin_da">Time</label>
							<input type="time" class="form-control" name="time_admin_da" id="time_admin_da">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="drug_comment_da">Comment</label>
							<textarea type="textarea" rows="2"  class="form-control" name="drug_comment_da" id="drug_comment_da" value=""></textarea>
							<input type="hidden" name="drug_list_id_da" class="form-control" id="drug_list_id_da" value="">
						</div>
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" id="btn_drug_admin" class="btn btn-primary">Administer</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
				<div class="table-responsive" id="drug_admin_table">

				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="drug_admin_chart_modal" tabindex="-1" role="dialog" aria-labelledby="drug_admin_chart_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary">Drug Administration Chart</h5>
			</div>
			<div class="modal-body">
				<div class="table-responsive no-padding">
		        	<table width="100%" cellpadding="3" cellspacing="3">
			            <tr>
			                <td>
			                	<table id="attend_patient_table_drug_admin_chart" width="100%">
				                    <tr>
				                    	<td><u>Patient Name:</u><?php echo $name;?></td>
				                    </tr>
				                    <tr>
				                    	<td><u>Age:</u><?php echo $age;?></td>
									</tr>
				                    <tr>
				                    	<td><u>Gender:</u><?php echo $row_gender['gender']?></td>
									</tr>
				                    <tr>
				            			<td><u>Date:</u><?php echo $dateofadmission_attd;?></td>
				            		</tr>
			                    </table>
			                </td>
			            </tr>
		            </table>
		        </div>
		        <br>
				<div class="table-responsive" id="drug_admin_chart_table">
				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" id="drug_chart_print" name="drug_chart_print"class="btn btn-primary">Print</button>
			    <button type="button" id="drug_chart_cancel" name="drug_chart_cancel"class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-md" id="drug_admin_deletion_modal" tabindex="-1" role="dialog" aria-labelledby="drug_admin_deletion_modal" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="drug_admin_deletion_title">Drug Administration Deletion</h5>
			</div>
			<div class="modal-body">
				<p id="drug_admin_deletion_modal_question"></p>
			</div>
			<div class="modal-footer">
			    <button type="button" id="drug_admin_del_yes" name="drug_admin_del_yes"class="btn btn-danger">Yes</button>
			    <button type="button" id="drug_admin_del_no" name="drug_admin_del_no"class="btn btn-primary">No</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-md" id="drug_attend_deletion_modal" tabindex="-1" role="dialog" aria-labelledby="drug_attend_deletion_modal" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary">Drug Deletion</h5>
			</div>
			<div class="modal-body">
				<p id="drug_attend_deletion_modal_question"></p>
			</div>
			<div class="modal-footer">
			    <button type="button" id="drug_del_yes" name="drug_del_yes"class="btn btn-danger">Yes</button>
			    <button type="button" id="drug_del_no" name="drug_del_no"class="btn btn-primary">No</button>
			</div>
		</div>
	</div>
</div>

<div 
class="modal fade bd-example-modal-xl" 
id="drug_mur_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="drug_mur_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="drug_mur_modal_title">Medicine Utilisation Review</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<form id="drug_mur_form" method="POST">

					<strong><p>MATTERS IDENTIFIED DURING MUR</p></strong>

					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="mur_q_1">1. Any matters identified during MUR</label>
							<select class="form-control bg-light" name="mur_q_1" id="mur_q_1"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_2_div" hidden="true">
							<label for="mur_q_2">2. OTC/Complementary Therapy</label>
							<select class="form-control bg-light" name="mur_q_2" id="mur_q_2"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_3_div" hidden="true">
							<label for="mur_q_3">3. Patient not using medication as prescribed (Non-Adherence)</label>
							<select class="form-control bg-light" name="mur_q_3" id="mur_q_3"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_4_div" hidden="true">
							<label for="mur_q_4">4. Problem with pharmacuetical form of a medicine or use of device</label>
							<select class="form-control bg-light" name="mur_q_4" id="mur_q_4"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_5_div" hidden="true">
							<label for="mur_q_5">5. Patient reports need for more information about a medicine or condition</label>
							<select class="form-control bg-light" name="mur_q_5" id="mur_q_5"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_6_div" hidden="true">
							<label for="mur_q_6">6. Patient reports side effects or other concern about a medicine</label>
							<select class="form-control bg-light" name="mur_q_6" id="mur_q_6"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_7_div" hidden="true">
							<label for="mur_q_7">7. Patient Drug Interaction</label>
							<select class="form-control bg-light" name="mur_q_7" id="mur_q_7"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_8_div" hidden="true">
							<label for="mur_q_8">8. Patient report not using the medicine anymore</label>
							<select class="form-control bg-light" name="mur_q_8" id="mur_q_8"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_9_div" hidden="true">
							<label for="mur_q_9">9. Patient report difficulty in using the medicine issue with the formulation</label>
							<select class="form-control bg-light" name="mur_q_9" id="mur_q_9"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_10_div" hidden="true">
							<label for="mur_q_10">10. Patient report lack of efficacy</label>
							<select class="form-control bg-light" name="mur_q_10" id="mur_q_10"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_11_div" hidden="true">
							<label for="mur_q_11">11. Patient reports problem with dosage regime</label>
							<select class="form-control bg-light" name="mur_q_11" id="mur_q_11"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_12_div" hidden="true">
							<label for="mur_q_12">12. Patient reports unresolved concern about the medicine</label>
							<select class="form-control bg-light" name="mur_q_12" id="mur_q_12"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12" id="mur_q_13_div" hidden="true">
							<label for="mur_q_13">13. Others</label>
							<textarea type="textarea" rows="2"  class="form-control bg-light" name="mur_q_13" id="mur_q_13" value=""></textarea>
						</div>
					</div>

					<div id="mur_action_taken_div" hidden="true">
						<strong><p>ACTION TAKEN / OUTCOME</p></strong>
					</div>

					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_14_div" hidden="true">
							<label for="mur_q_14">14. Information/Advice provided</label>
							<select class="form-control bg-light" name="mur_q_14" id="mur_q_14"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_15_div" hidden="true">
							<label for="mur_q_15">15. Yellow Card submitted to MHRA</label>
							<select class="form-control bg-light" name="mur_q_15" id="mur_q_15"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_16_div" hidden="true">
							<label for="mur_q_16">16. Referral - issues to be raised with GP practice or another primary nhiscare provider</label>
							<select class="form-control bg-light" name="mur_q_16" id="mur_q_16"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_17_div" hidden="true">
							<label for="mur_q_17">17. Others</label>
							<textarea type="textarea" rows="2"  class="form-control bg-light" name="mur_q_17" id="mur_q_17" value=""></textarea>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_18_div" hidden="true">
							<label for="mur_q_18">18. Better understanding/reinforcement of why they are using the medicine/what is it for</label>
							<select class="form-control bg-light" name="mur_q_18" id="mur_q_18"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_19_div" hidden="true">
							<label for="mur_q_19">19. Better understanding/reinforcement of when/how to take the medicines</label>
							<select class="form-control bg-light" name="mur_q_19" id="mur_q_19"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_20_div" hidden="true">
							<label for="mur_q_20">20. Better understanding/reinforcement of side effect and how to manage the medicines</label>
							<select class="form-control bg-light" name="mur_q_20" id="mur_q_20"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_21_div" hidden="true">
							<label for="mur_q_21">21. Better understanding/reinforcement of the condition being treated</label>
							<select class="form-control bg-light" name="mur_q_21" id="mur_q_21"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<input type="text" name="mur_drug_list_id" id="mur_drug_list_id" hidden="true">
					<input type="text" name="mur_drug_id" id="mur_drug_id" hidden="true">
					<input type="text" name="mur_patient_id" id="mur_patient_id" hidden="true">
					<input type="text" name="mur_attend_id" id="mur_attend_id" hidden="true">
					<input type="date" name="mur_date" id="mur_date" hidden="true">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn_drug_mur_save" class="btn btn-primary">Save</button>
			    <button type="button" id="btn_cancel_mur" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div 
class="modal fade bd-example-modal-xl" 
id="drug_label_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="drug_label_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 60%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="drug_label_modal_title">Drug Labelling</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<form id="drug_label_form" method="POST">
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<div class="col-md-12 mb-12">
								<label for="label_dispensed_by">Dispensed By</label>
								<input type="text"class="form-control" name="label_dispensed_by" id="label_dispensed_by">
							</div>
							<div class="col-md-12 mb-12">
								<label for="label_view">Drug Label</label>
								<textarea type="textarea" rows="4"  class="form-control" name="label_view" id="label_view" value=""></textarea>
							</div>
						</div>
						<div class="col-md-6 mb-6">
							<label for="label_search">Search</label>
							<input type="text"class="form-control" name="label_search" id="label_search">
							<div class="form-row">
								<div class="col-md-12 mb-12">
									<div id="label_search_result"></div>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" id="label_drug_list_id" name="label_drug_list_id">
					<input type="hidden" id="label_drug_id" name="label_drug_id">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn_drug_label_save" name="btn_drug_label_save" class="btn btn-primary">Save</button>
			    <button type="button" id="btn_drug_label_cancel" name="btn_drug_label_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<?php
	include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/receipt_create_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/drug_search_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/drug_admin_status_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/validation_sheet_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/discount_create_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>