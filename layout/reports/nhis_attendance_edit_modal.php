<?php 
	if(!isset($attend_id)){$attend_id=0;};
	if(!isset($patient_id)){$patient_id=0;};
	if(!isset($payment_type_id)){$payment_type_id=0;};
	if(!isset($con)){
    	require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
	};
	if(!isset($row_attend)){
        $sql_attend = "SELECT * FROM attendance WHERE attend_id ='$attend_id'";
		$result_attend = mysqli_query($con,$sql_attend);
        $row_attend = mysqli_fetch_array($result_attend);
	};
	if(!isset($row_pay_type)){
        $sql_pay_type = "SELECT * FROM payment_type WHERE pay_type_id ='$payment_type_id'";
		$result_pay_type = mysqli_query($con,$sql_pay_type);
        $row_pay_type = mysqli_fetch_array($result_pay_type);
	};
?>
<div 
class="modal fade bd-example-modal-xl" 
id="nhis_attend_detail_modal" 
tabindex="-1" role="dialog" 
aria-labelledby="nhis_attend_detail_modal" 
aria-hidden="true">
	<div class="modal-dialog modal-xl" style="max-width: 80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="nhis_attend_detail_modal_title">Attendance Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="nhis_attend_detail_form" method="POST">
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label for="typeofservice_attd"><small><u>Type Of Service</u></small></label>
								<select class="form-control bg-light" name="typeofservice_attd" id="typeofservice_attd" required> 
								    <option value="0">Please Select</option>
							        <?php
							        	$tos_attend = $row_attend['tos_id'];
							        	$sql_tos="SELECT * FROM type_of_service ORDER BY description DESC";
										$result_tos = mysqli_query($con,$sql_tos);
							            while($row_tos = mysqli_fetch_array($result_tos))
							            {
							            	if ($tos_attend == $row_tos['tos_id'])
							            	{
							            		echo '<option value = "'.$row_tos['tos_id'].'" selected = "selected">'.$row_tos['description'].'</option>';
							            	} else 
							            	{
							            		echo '<option value = "'.$row_tos['tos_id'].'">'.$row_tos['description'].'</option>';
							            	};
							            };
							        ?>
							    </select>
							</div>
							<div class="col-md-3 mb-3">
								<label for="dateofadmission_attd"><small><u>Date Of Admission</u></small></label>
								<input type="date" class="form-control bg-light" name="dateofadmission_attd" id="dateofadmission_attd" value="<?php echo $row_attend['date_admit'];?>">
							</div>
							<div class="col-md-3 mb-3">
								<label for="dateofdischarge_attd"><small><u>Date Of Discharge</u></small></label>
								<input type="date" class="form-control bg-light" name="dateofdischarge_attd" id="dateofdischarge_attd" value="<?php echo $row_attend['date_disch'];?>">
							</div>
							<div class="col-md-3 mb-3">
								<label for="outcome"><small><u>Outcome</u></small></label>
								<select class="form-control bg-light" name="outcome" id="outcome" required> 
							    	<option value="0">-Please Select-</option>
							    	<?php
						            	if ($row_attend['outcome'] == 'discharged') 
						            	{
						            		echo '<option value = "discharged" selected = "selected">Discharged</option>
										    	<option value="died">Died</option>
										    	<option value="absconded">Absconded</option>
										    	<option value="discharged_against_medical_advice">Discharged Against Medical Advice</option>
										    	<option value="referred_out">Referred Out</option>
										    	<option value="transferred_out">Transferred Out</option>
										    	<option value="on_admission">On-Admission</option>';
						            	} 
						            	else if($row_attend['outcome'] == 'died')
						            	{
						            		echo '<option value = "died" selected = "selected">Died</option>
							            		<option value="discharged">Discharged</option>
										    	<option value="absconded">Absconded</option>
										    	<option value="discharged_against_medical_advice">Discharged Against Medical Advice</option>
										    	<option value="referred_out">Referred Out</option>
										    	<option value="transferred_out">Transferred Out</option>
										    	<option value="on_admission">On-Admission</option>';
						            	} 
						            	else if($row_attend['outcome'] == 'absconded')
						            	{
						            		echo '<option value = "absconded" selected = "selected">Absconded</option>
							            		<option value="discharged">Discharged</option>
										    	<option value="died">Died</option>
										    	<option value="discharged_against_medical_advice">Discharged Against Medical Advice</option>
										    	<option value="referred_out">Referred Out</option>
										    	<option value="transferred_out">Transferred Out</option>
										    	<option value="on_admission">On-Admission</option>';
						            	} 
						            	else if($row_attend['outcome'] == 'discharged_against_medical_advice')
						            	{
						            		echo '<option value = "discharged_against_medical_advice" selected = "selected">Discharged Against Medical Advice</option>
							            		<option value="discharged">Discharged</option>
										    	<option value="died">Died</option>
										    	<option value="absconded">Absconded</option>
										    	<option value="referred_out">Referred Out</option>
										    	<option value="transferred_out">Transferred Out</option>
										    	<option value="on_admission">On-Admission</option>';
						            	} 
						            	else if($row_attend['outcome'] == 'referred_out')
						            	{
						            		echo '<option value = "referred_out" selected = "selected">Referred Out</option>
							            		<option value="discharged">Discharged</option>
										    	<option value="died">Died</option>
										    	<option value="absconded">Absconded</option>
										    	<option value="discharged_against_medical_advice">Discharged Against Medical Advice</option>
										    	<option value="transferred_out">Transferred Out</option>
										    	<option value="on_admission">On-Admission</option>';
						            	} 
						            	else if($row_attend['outcome'] == 'transferred_out')
						            	{
						            		echo '<option value = "transferred_out" selected = "selected">Transferred Out</option>
							            		<option value="discharged">Discharged</option>
										    	<option value="died">Died</option>
										    	<option value="absconded">Absconded</option>
										    	<option value="discharged_against_medical_advice">Discharged Against Medical Advice</option>
										    	<option value="referred_out">Referred Out</option>
										    	<option value="on_admission">On-Admission</option>';
						            	} 
						            	else if($row_attend['outcome'] == 'on_admission')
						            	{
						            		echo '<option value = "on_admission" selected = "selected">On-Admission</option>
							            		<option value="discharged">Discharged</option>
										    	<option value="died">Died</option>
										    	<option value="absconded">Absconded</option>
										    	<option value="discharged_against_medical_advice">Discharged Against Medical Advice</option>
										    	<option value="referred_out">Referred Out</option>
										    	<option value="transferred_out">Transferred Out</option>';
						            	};
							        ?>
							    </select>
							</div>
						</div>
					<?php
						$query_payment_type = "SELECT * FROM payment_type WHERE ledger_id =2 AND attend_id='$attend_id'";
						$query_run_payment_type = mysqli_query($con, $query_payment_type);
						
						if (mysqli_num_rows($query_run_payment_type) > 0)
						{
							while($row_payment_type = mysqli_fetch_assoc($query_run_payment_type))
							{
								?>
								<div class="form-row">
									<div class="col-md-3 mb-3">
										<label for="attend_sponsor_member_no"><small><u>Membership No</u></small></label>
										<input type="text" name="attend_sponsor_member_no" class="form-control bg-light attend_sponsor_member_no" id="attend_sponsor_member_no<?php echo $i;?>" data-id="1" style="border-width:0px" value="<?php echo $row_payment_type['member_no'];?>">
									</div>
									<div class="col-md-3 mb-3">
										<div id="ghanacard_div<?php echo $i;?>" <?php if($row_payment_type['ledger_id'] == 2){echo 'style=display:inline;';}else{echo 'style=display:none;';};?>>
											<label for="ghanacard_attd"><small><u>Ghana Card</u></small></label>
											<input type="text" class="form-control bg-light" name="ghanacard_attd" id="ghanacard_attd<?php echo $i;?>" value="<?php echo $row_payment_type['ghanacard'];?>">
										</div>
										<div id="ins_category_div<?php echo $i;?>" <?php if($row_payment_type['ledger_id'] == 2){echo 'style=display:none;';}else{echo 'style=display:inline;';};?>>
											<label for="attend_sponsor_category"><small><u>Category</u></small></label>
											<input type="text" name="attend_sponsor_category[]" class="form-control bg-light attend_sponsor_category" id="attend_sponsor_category<?php echo $i;?>" data-id="<?php echo $i;?>" style="border-width:0px" value="<?php echo $row_payment_type['ins_class'];?>">
										</div>
									</div>
									<div class="col-md-3 mb-3">
										<label for="attend_sponsor_expiry_date"><small><u>Expiry Date</u></small></label>
										<input type="date" name="attend_sponsor_expiry_date" class="form-control bg-light" id="attend_sponsor_expiry_date<?php echo $i;?>" style="border-width:0px" value="<?php echo $row_payment_type['expiry_date'];?>">
									</div>
									<div class="col-md-3 mb-3">
										<div id="serial_no_div<?php echo $i;?>"<?php if($row_payment_type['ledger_id'] == 2){echo 'style=display:inline;';}else{echo 'style=display:none;';};?>>
											<label for="serial_no"><small><u>Serial no</u></small></label>
											<input type="text" class="form-control bg-light" name="serial_no" id="serial_no<?php echo $i;?>" value="<?php echo $row_payment_type['serial_no'];?>">
										</div>
										<div id="relation_div<?php echo $i;?>" <?php if($row_payment_type['ledger_id'] == 2){echo 'style=display:none;';}else{echo 'style=display:inline;';};?>>
											<label for="attend_sponsor_relation"><small><u>Relation Type</u></small></label>
											<input type="text" class="form-control bg-light" name="attend_sponsor_relation" id="attend_sponsor_relation<?php echo $i;?>" value="<?php echo $row_payment_type['relation'];?>">
										</div>
									</div>
								</div>
								<?php
									$specialty_1 = $row_payment_type['specialty_1'];
									$specialty_array = explode(",",$specialty_1);
								?>
								<div class="form-row">
									<label for="specialty_attd"><small><u>Specialty Code</u></small></label>
									<div class="col-md-1 mb-1">
										<div class="form-check">
										<input class="form-check-input" type="checkbox" value="ASUR" id="ASUR<?php echo $i;?>" name="specialty_attd[]" <?php if(in_array("ASUR", $specialty_array)){echo "checked='checked'";};?>>
										<label class="form-check-label" for="ASUR">
											ASUR
										</label>
										</div>
									</div>
									<div class="col-md-1 mb-1">
										<div class="form-check">
										<input class="form-check-input" type="checkbox" value="DENT" id="DENT<?php echo $i;?>" name="specialty_attd[]" <?php if(in_array("DENT", $specialty_array)){echo "checked='checked'";};?>>
										<label class="form-check-label" for="DENT">
											DENT
										</label>
										</div>
									</div>
									<div class="col-md-1 mb-1">
										<div class="form-check">
										<input class="form-check-input" type="checkbox" value="ENTH" id="ENTH<?php echo $i;?>" name="specialty_attd[]" <?php if(in_array("ENTH", $specialty_array)){echo "checked='checked'";};?>>
										<label class="form-check-label" for="ENTH">
											ENTH
										</label>
										</div>
									</div>
									<div class="col-md-1 mb-1">
										<div class="form-check">
										<input class="form-check-input" type="checkbox" value="MEDI" id="MEDI<?php echo $i;?>" name="specialty_attd[]" <?php if(in_array("MEDI", $specialty_array)){echo "checked='checked'";};?>>
										<label class="form-check-label" for="MEDI">
											MEDI
										</label>
										</div>
									</div>
									<div class="col-md-1 mb-1">
										<div class="form-check">
										<input class="form-check-input" type="checkbox" value="OBGY" id="OBGY<?php echo $i;?>" name="specialty_attd[]" <?php if(in_array("OBGY", $specialty_array)){echo "checked='checked'";};?>>
										<label class="form-check-label" for="OBGY">
											OBGY
										</label>
										</div>
									</div>
									<div class="col-md-1 mb-1">
										<div class="form-check">
										<input class="form-check-input" type="checkbox" value="OPDC" id="OPDC<?php echo $i;?>" name="specialty_attd[]" <?php if(in_array("OPDC", $specialty_array)){echo "checked='checked'";};?>>
										<label class="form-check-label" for="OPDC">
											OPDC
										</label>
										</div>
									</div>
									<div class="col-md-1 mb-1">
										<div class="form-check">
										<input class="form-check-input" type="checkbox" value="OPHT" id="OPHT<?php echo $i;?>" name="specialty_attd[]" <?php if(in_array("OPHT", $specialty_array)){echo "checked='checked'";};?>>
										<label class="form-check-label" for="OPHT">
											OPHT
										</label>
										</div>
									</div>
									<div class="col-md-1 mb-1">
										<div class="form-check">
										<input class="form-check-input" type="checkbox" value="ORTH" id="ORTH<?php echo $i;?>" name="specialty_attd[]" <?php if(in_array("ORTH", $specialty_array)){echo "checked='checked'";};?>>
										<label class="form-check-label" for="ORTH">
											ORTH
										</label>
										</div>
									</div>
									<div class="col-md-1 mb-1">
										<div class="form-check">
										<input class="form-check-input" type="checkbox" value="PAED" id="PAED<?php echo $i;?>" name="specialty_attd[]" <?php if(in_array("PAED", $specialty_array)){echo "checked='checked'";};?>>
										<label class="form-check-label" for="PAED">
											PAED
										</label>
										</div>
									</div>
									<div class="col-md-1 mb-1">
										<div class="form-check">
										<input class="form-check-input" type="checkbox" value="PSUR" id="PSUR<?php echo $i;?>" name="specialty_attd[]" <?php if(in_array("PSUR", $specialty_array)){echo "checked='checked'";};?>>
										<label class="form-check-label" for="PSUR">
											PSUR
										</label>
										</div>
									</div>
									<div class="col-md-1 mb-1">
										<div class="form-check">
										<input class="form-check-input" type="checkbox" value="RSUR" id="RSUR<?php echo $i;?>" name="specialty_attd[]" <?php if(in_array("RSUR", $specialty_array)){echo "checked='checked'";};?>>
										<label class="form-check-label" for="RSUR">
											RSUR
										</label>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-3 mb-3">
										<label for="type_of_attendnace"><small><u>Type Of Attendance</u></small></label>
										<select class="form-control bg-light" name="type_of_attendnace" id="type_of_attendnace<?php echo $i;?>"> 
											<option value="0">-Please Select-</option>
											<?php
												$type_of_attend = $row_payment_type['type_of_attend'];
												if ($type_of_attend == 'chronic_follow_up') 
												{
													echo '<option value ="chronic_follow_up" selected ="selected">Chronic Follow-up</option>
														<option value="emergency_acute_episode">Emergency/Acute Episode</option>
														<option value="antenatal">Antenatal Care</option>';
												} 
												else if($type_of_attend == 'emergency_acute_episode')
												{
													echo '<option value ="chronic_follow_up">Chronic Follow-up</option>
														<option value="emergency_acute_episode" selected ="selected">Emergency/Acute Episode</option>
														<option value="antenatal">Antenatal Care</option>';
												}
												else if($type_of_attend == 'antenatal')
												{
													echo '<option value ="chronic_follow_up">Chronic Follow-up</option>
														<option value="emergency_acute_episode">Emergency/Acute Episode</option>
														<option value="antenatal" selected ="selected">Antenatal Care</option>';
												};
											?>
										</select>
									</div>
									<div class="col-md-2 mb-2">
										<label for="date_of_claim"><small><u>Date of Claim</u></small></label>
										<input type="date" class="form-control bg-light" name="date_of_claim" id="date_of_claim<?php echo $i;?>" value="<?php echo $row_payment_type['date_of_claim'];?>">
									</div>
									<div class="col-md-1 mb-1">
										<label for="claim_no"><small><u>Claim No</u></small></label>
										<input type="text" class="form-control" name="claim_no" id="claim_no<?php echo $i;?>" value="<?php echo $row_payment_type['claim_no'];?>">
									</div>
									<div class="col-md-2 mb-2">
										<label for="pharmacy"><small><u>Pharmacy</u></small></label>
										<select class="form-control bg-light" name="pharmacy" id="pharmacy<?php echo $i;?>"> 
											<?php
												$pharmacy = $row_payment_type['pharmacy'];
												if ($pharmacy == 'pharmacy') 
												{
													echo '<option value="0">Please Select</option>
														<option value="pharmacy" selected ="selected">Pharmacy</option>';
												} 
												else if($pharmacy !== 'pharmacy')
												{
													echo '<option value="0" selected ="selected">Please Select</option>
														<option value="pharmacy">Pharmacy</option>';
												};
											?>
										</select>
									</div>
									<div class="col-md-2 mb-2">
										<label for="type_of_service_2"><small><u>Type Of Service (b)</u></small></label>
										<select class="form-control bg-light" name="type_of_service_2" id="type_of_service_2<?php echo $i;?>"> 
											
											<?php
												$type_of_serv_b = $row_payment_type['type_of_serv_b'];
												if ($type_of_serv_b == 'all_inclusive') 
												{
													echo '<option value="0">Please Select</option>
														<option value="all_inclusive" selected ="selected">All Inclusive</option>
														<option value="unbundled">Unbundled</option>';
												} 
												else if($type_of_serv_b == 'unbundled')
												{
													echo '<option value="0">Please Select</option>
														<option value="all_inclusive">All Inclusive</option>
														<option value="unbundled" selected ="selected">Unbundled</option>';
												}else if($type_of_serv_b == '')
												{
													echo '<option value="0">Please Select</option>
														<option value="all_inclusive">All Inclusive</option>
														<option value="unbundled">Unbundled</option>';
												}else if($type_of_serv_b == '0'|| $type_of_serv_b == 0)
												{
													echo '<option value="0">Please Select</option>
														<option value="all_inclusive">All Inclusive</option>
														<option value="unbundled">Unbundled</option>';
												};
											?>
										</select>
									</div>
									<div class="col-md-1 mb-1">
										<label for="nhisccc"><small><u>CCC</u></small></label>
										<input type="text" class="form-control bg-light" name="nhisccc" id="nhisccc<?php echo $i;?>" value="<?php echo $row_payment_type['code'];?>">
									</div>
									<div class="col-md-1 mb-1">
										<label for="spell"><small><u>Spell</u></small></label>
										<input type="text" class="form-control bg-light" name="spell" id="spell<?php echo $i;?>" value="<?php echo $row_payment_type['spell'];?>">
										<input type="hidden" class="form-control bg-light" name="nhis_attend_pay_type_id" id="nhis_attend_pay_type_id<?php echo $i;?>" value="<?php echo $row_payment_type['pay_type_id'];?>">
										<input type="hidden" class="form-control bg-light" name="nhis_attend_id" id="nhis_attend_id<?php echo $i;?>" value="<?php echo $row_payment_type['attend_id'];?>">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-4 mb-4">
										<label for="nhis_attend_specialty_description">Specialty Description</label>
										<select class="form-control" name="nhis_attend_specialty_description" id="nhis_attend_specialty_description"
										data-id="<?php echo $row_pay_type['pay_type_id'];?>" data-id2="<?php echo $row_attend['tos_id'];?>"> 
											<option value="0">Please Select</option>
											<?php
												$nasp_specialty_id = $row_payment_type['specialty'];
												if($row_attend['age'] < 12)
												{
													$nasp_query = "SELECT nhis_item_desc, gdrg_child AS gdrg, price_child AS price, nhis_id 
													FROM nhis WHERE gdrg_child !='' AND category_id = 1 ORDER BY gdrg";
												}
												else
												{
													$nasp_query = "SELECT nhis_item_desc, gdrg_adult AS gdrg, price_adult AS price, nhis_id 
													FROM nhis WHERE gdrg_adult !='' AND category_id = 1 ORDER BY gdrg";
												};
												
												$nasp_result = mysqli_query($con,$nasp_query);
												while($nasp_row = mysqli_fetch_array($nasp_result))
												{
													if($nasp_specialty_id == $nasp_row['nhis_id'])
													{
														echo '<option value = "'.$nasp_row['nhis_id'].'" selected="selected">
														'.$nasp_row['gdrg'].' - '.$nasp_row['nhis_item_desc'].'</option>';
													}
													else
													{
														echo '<option value = "'.$nasp_row['nhis_id'].'">'.$nasp_row['gdrg'].' - 
														'.$nasp_row['nhis_item_desc'].'</option>';
													};
												};
											?>
										</select>
									</div>
									<div class="col-md-2 mb-2">
										<label for="nhis_attend_specialty_code">Code</label>
										<input type="text" class="form-control" name="nhis_attend_specialty_code" 
											id="nhis_attend_specialty_code"  value="<?php echo $row_pay_type['specialty_code'];?>">
									</div>
									<div class="col-md-3 mb-3">
										<label for="nhis_attend_referral_facility">Referral Facility</label>
										<input type="text" class="form-control" name="nhis_attend_referral_facility" 
											id="nhis_attend_referral_facility" value="<?php echo $row_payment_type['referral_facility'];?>">
									</div>
									<div class="col-md-3 mb-3">
										<label for="nhis_attend_referral_facility_code">Referral Facility Code</label>
										<input type="text" class="form-control" name="nhis_attend_referral_facility_code" 
											id="nhis_attend_referral_facility_code" value="<?php echo $row_payment_type['referral_gdrg'];?>">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-12 mb-12">
										<div class="card shadow md-4">
											<div class="card-header" style="background-color:#C3C1C1; color:white">
												<h5><strong>CLAIM SUMMARY</strong></h5>
											</div>
											<div class="card-body">
												<div class="form-row">
													<div class="col-md-6 mb-6">
														<div class="form-row">
															<div class="col-md-4 mb-4">
																<label for="nhis_attend_summary_label"><strong>Type Of Service</strong></label>
															</div>
															<div class="col-md-4 mb-4">
																<label for="nhis_attend_summary_code_label"><strong>G-DRG/Code</strong></label>
															</div>
															<div class="col-md-4 mb-4">
																<label for="nhis_attend_summary_tariff_label"><strong>Tariff Amount</strong></label>
															</div>
														</div>
														<div class="form-row">
															<div class="col-md-4 mb-4">
																<label for="nhis_attend_ipd_label">A. In-Patient</label>
															</div>
															<div class="col-md-4 mb-4">
																<input type="text" class="form-control bg-light text-center" name="nhis_attend_ipd_code" id="nhis_attend_ipd_code" value="<?php echo $row_payment_type['gdrg_in_patient'];?>">
															</div>
															<div class="col-md-4 mb-4">
																<input type="text" class="form-control bg-light text-right" name="nhis_attend_ipd_total" id="nhis_attend_ipd_total" value="<?php echo $row_payment_type['amt_in_patient'];?>">
															</div>
														</div>
														<div class="form-row">
															<div class="col-md-4 mb-4">
																<label for="nhis_attend_opd_label">B. Out-Patient</label>
															</div>
															<div class="col-md-4 mb-4">
																<input type="text" class="form-control bg-light text-center" name="nhis_attend_opd_code" id="nhis_attend_opd_code" value="<?php echo $row_payment_type['gdrg_out_patient'];?>">
															</div>
															<div class="col-md-4 mb-4">
																<input type="text" class="form-control bg-light text-right" name="nhis_attend_opd_total" id="nhis_attend_opd_total" value="<?php echo $row_payment_type['amt_out_patient'];?>">
															</div>
														</div>
														<div class="form-row">
															<div class="col-md-4 mb-4">
																<label for="nhis_attend_invest_label">C. Investigations</label>
															</div>
															<div class="col-md-4 mb-4">
																<input type="text" class="form-control bg-light text-center" name="nhis_attend_invest_code" id="nhis_attend_invest_code" value="">
															</div>
															<div class="col-md-4 mb-4">
																<input type="text" class="form-control bg-light text-right" name="nhis_attend_invest_total" id="nhis_attend_invest_total" value="<?php echo $row_payment_type['amt_invest'];?>">
															</div>
														</div>
														<div class="form-row">
															<div class="col-md-4 mb-4">
																<label for="nhis_attend_pharmacy_label">D. Pharmacy</label>
															</div>
															<div class="col-md-4 mb-4">
																<input type="text" class="form-control bg-light text-center" name="nhis_attend_pharmacy_code" id="nhis_attend_pharmacy_code" value="">
															</div>
															<div class="col-md-4 mb-4">
																<input type="text" class="form-control bg-light text-right" name="nhis_attend_pharmacy_total" id="nhis_attend_pharmacy_total" value="<?php echo $row_payment_type['amt_pharmacy'];?>">
															</div>
														</div>
														<div class="form-row">
															<div class="col-md-4 mb-4">
																<label for="nhis_attend_total_amount">E. Claim Total</label>
															</div>
															<div class="col-md-4 mb-4">
															</div>
															<div class="col-md-4 mb-4">
																<input type="text" class="form-control bg-light text-right" name="nhis_attend_total_amount" id="nhis_attend_total_amount" value="<?php echo $row_payment_type['amt_total'];?>">
															</div>
														</div>
													</div>
													<div class="col-md-6 mb-6">
														<div class="form-row">
															<div class="col-md-4 mb-4">
																<label for="nhis_attend_principal_gdrg"><strong>Principal G-DRG</strong></label>
															</div>
														</div>
														<div class="form-row">
															<div class="col-md-8 mb-8">
																<select class="form-control" name="nhis_attend_principal_desc" id="nhis_attend_principal_desc"> 
																<option value="0">Please Select</option>
																<?php
																	$nasp_specialty_id = $row_pay_type['principal_id'];
																	if($row_attend['age'] < 12)
																	{
																		$nasp_query = "SELECT nhis_item_desc, gdrg_child AS gdrg, price_child AS price, nhis_id 
																		FROM nhis WHERE gdrg_child !='' AND (category_id = 1 OR category_id = 5 OR category_id = 6) ORDER BY gdrg ASC";
																	}
																	else
																	{
																		$nasp_query = "SELECT nhis_item_desc, gdrg_adult AS gdrg, price_adult AS price, nhis_id 
																		FROM nhis WHERE gdrg_adult !='' AND (category_id = 1 OR category_id = 5 OR category_id = 6) ORDER BY gdrg ASC";
																	};
																	
																	$nasp_result = mysqli_query($con,$nasp_query);
																	while($nasp_row = mysqli_fetch_array($nasp_result))
																	{
																		if($nasp_specialty_id == $nasp_row['nhis_id'])
																		{
																			echo '<option value = "'.$nasp_row['nhis_id'].'" selected="selected">
																			'.$nasp_row['gdrg'].' - '.$nasp_row['nhis_item_desc'].'</option>';
																		}
																		else
																		{
																			echo '<option value = "'.$nasp_row['nhis_id'].'">'.$nasp_row['gdrg'].' - 
																			'.$nasp_row['nhis_item_desc'].'</option>';
																		};
																	};
																?>
															</select>
															</div>
															<div class="col-md-4 mb-4">
																<input type="text" class="form-control bg-light text-center" name="nhis_attend_principal_gdrg" 
																id="nhis_attend_principal_gdrg" value="<?php echo $row_payment_type['principal_gdrg'];?>">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php
							};
						};
					?>
				</form>
				<div class="modal-footer">
					<button type="button" id="btn_nhis_attend_update" class="btn btn-primary">Update</button>
				    <button type="button" id="btn_nhis_attend_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>