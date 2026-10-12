<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//MISCELLANEOUS
		//MY FOLDER
			/*function my_folder_view()
			{
				global $con;
			    $patient_id = $_POST['patient_id'];
			    $value = "";
		        	$query = "SELECT * FROM attendance WHERE patient_id ='$patient_id' ORDER BY date_admit DESC";
		        	$query_run = mysqli_query($con, $query);
    				if (mysqli_num_rows($query_run) > 0)
					{
						while($row_attend = mysqli_fetch_assoc($query_run))
						{
							$date_admit = $row_attend['date_admit'];
							$date_disch = $row_attend['date_disch'];
							$attend_id = $row_attend['attend_id'];
							$tos_id = $row_attend['tos_id'];
							$nhis_led_id = $row_attend['nhis_led_id'];
							$prvt_led_id = $row_attend['prvt_led_id'];
							if($nhis_led_id > 0 && $prvt_led_id > 0 )
                                {
                                    $sponsor_id = $nhis_led_id;
                                }
                            else if($nhis_led_id > 0 && $prvt_led_id <= 0 )
                                {
                                    $sponsor_id = $nhis_led_id;
                                }
                            else if($nhis_led_id <= 0 && $prvt_led_id > 0 )
                                {
                                    $sponsor_id = $prvt_led_id;
                                }
                            else if($nhis_led_id <= 0 && $prvt_led_id <= 0 )
                                {
                                    $sponsor_id = 1;
                                }
                            $query_led = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
                            $query_run_led = mysqli_query($con, $query_led);
                            $row_led=mysqli_fetch_assoc($query_run_led);

                            $query_tos = "SELECT * FROM type_of_service WHERE tos_id='$tos_id'";
                            $query_run_tos = mysqli_query($con, $query_tos);
                            $row_tos=mysqli_fetch_assoc($query_run_tos);

							$value .='<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
								        <thead>
									        <tr style="background-color:black; color:white">
								                <th width="20%">Admission Date:'.$date_admit.'</th>
								                <th width="20%">Discharge Date:'.$date_disch.'</th>
								                <th width="20%">Age:'.$row_attend['age'].'</th>
								                <th width="20%">Type Of Service:'.$row_tos['description'].'</th>
								                <th width="20%">Sponsor:'.$row_led['ledger_desc'].'</th>
								            </tr>	
								        </thead>
								        <tbody class="pv-table-body">
								        </tbody>
									</table>';
							//VITALS
								$query_vitals = "SELECT * FROM vitals WHERE attend_id='$attend_id' AND patient_id ='$patient_id' ORDER BY date DESC";
							    $query_run_vitals = mysqli_query($con, $query_vitals);
							    if (mysqli_num_rows($query_run_vitals) > 0) 
								{
									$value.='<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
		        								<thead>
													<tr style="background-color:#E4DCCF; color:black">
										        		<td colspan="12">
															<strong>VITALS</strong>
														</td>
													</tr>
													<tr>
										                <th>Date</th>
										                <th>Temp</th>
										                <th>BP</th>
										                <th>Pulse</th>
										                <th>R.Rate</th>
										                <th>Weight</th>
										                <th>Height</th>
										                <th>Oxygen</th>
										                <th>H.Circ.</th>
										                <th>A.Circ.</th>
										                <th>comment</th>
										            </tr>
										        </thead>
										        <tbody class="pv-table-body">';
												    
												    while($row_vitals = mysqli_fetch_assoc($query_run_vitals))
													{
														$value.='<tr>
												                    <td>'.$row_vitals['date'].'</td>
												                    <td>'.$row_vitals['temp'].'</td>
												                    <td>'.$row_vitals['bp_systolic'].'/'.$row_vitals['bp_diastolic'].'</td>
												                    <td>'.$row_vitals['pulse'].'</td>
												                    <td>'.$row_vitals['resp_rate'].'</td>
												                    <td>'.$row_vitals['weight'].'</td>
												                    <td>'.$row_vitals['height'].'</td>
												                    <td>'.$row_vitals['oxygen_sat'].'</td>
												                    <td>'.$row_vitals['circ_hip'].'</td>
												                    <td>'.$row_vitals['circ_abdo'].'</td>
												                    <td>'.$row_vitals['comment'].'</td>
												                </tr>';
													}
										$value.='</tbody>
	    									</table>';
    							}
							//HISTORY
								$query_history = "SELECT * FROM history WHERE attend_id='$attend_id' AND patient_id ='$patient_id' ORDER BY date DESC";
							    $query_run_history = mysqli_query($con, $query_history);
							    if (mysqli_num_rows($query_run_history) > 0)
								{
									$value.='<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
		        								<thead>
													<tr style="background-color:#E4DCCF; color:black">
										        		<td colspan="12">
															<strong>HISTORY</strong>
														</td>
													</tr>
													<tr>
										                <th width="10%">Date</th>
										                <th width="90%">History</th>
										            </tr>
										        </thead>
										        <tbody class="pv-table-body">';
												    
														while($row_history = mysqli_fetch_assoc($query_run_history))
														{
															$value.='<tr>
													                    <td>'.$row_history['date'].'</td>
								                    					<td>'.$row_history['history'].'</td>
													                </tr>';
														}
										$value.='</tbody>	
	    									</table>';
    							}
							//DIAGNOSIS
    							$query_diagnosis_list = "SELECT * FROM diagnosis_list WHERE attend_id='$attend_id' AND patient_id ='$patient_id' ORDER BY date DESC";
								$query_run_diagnosis_list = mysqli_query($con, $query_diagnosis_list);
								if (mysqli_num_rows($query_run_diagnosis_list) > 0)
								{
									$value.='<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
		        								<thead>
													<tr style="background-color:#E4DCCF; color:black">
										        		<td colspan="12">
															<strong>DIAGNOSIS</strong>
														</td>
													</tr>
													<tr>
										                <th width="10%">Date</th>
										                <th width="30%">Diagnosis</th>
										                <th width="10%">ICD 10</th>
										                <th width="10%">G-DRG</th>
										                <th width="40%">Comment</th>
										            </tr>
										        </thead>
										        <tbody class="pv-table-body">';
												while($row_diagnosis_list = mysqli_fetch_assoc($query_run_diagnosis_list))
												{
													$diagnosis_id = $row_diagnosis_list['diagnosis_id'];
								                	$query_diag = "SELECT * FROM diagnosis WHERE diagnosis_id='$diagnosis_id'";
													$query_run_diag = mysqli_query($con, $query_diag);
													$row_diag=mysqli_fetch_assoc($query_run_diag);
													$value.='
															<tr>
											                    <td>'.$row_diagnosis_list['date'].'</a></td>
											                    <td>'.$row_diag['diagnosis'].'</td>
											                    <td>'.$row_diag['icd_10'].'</td>
											                    <td>'.$row_diag['g_drg'].'</td>
											                    <td>'.$row_diagnosis_list['comment'].'</td>
											                </tr>';
												}
										$value.='</tbody>
	    									</table>';
    							}
							//LABORATORY TEST
								$query_lab_list = "SELECT * FROM lab_list WHERE attend_id='$attend_id'";
			    				$query_run_lab_list = mysqli_query($con, $query_lab_list);
			    				if (mysqli_num_rows($query_run_lab_list) > 0)
								{
									$value.='<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
		        								<thead>
													<tr style="background-color:#E4DCCF; color:black">
										        		<td colspan="12">
															<strong>LABORATORY TEST</strong>
														</td>
													</tr>
													<tr>
										                <th width="30%">Parameter</th>
										                <th width="15%">Result</th>
										                <th width="5%">Lower Range</th>
										                <th width="5%">Higher Range</th>
										                <th width="5%">Unit</th>
										                <th width="5%">Flag</th>
										                <th width="35%">Comment</th>
										            </tr>
										        </thead>
										        <tbody class="pv-table-body">';
														while($row_lab_list=mysqli_fetch_assoc($query_run_lab_list))
														{
															$lab_id = $row_lab_list['lab_id'];
															$lab_list_id = $row_lab_list['lab_list_id'];
															$query_lab_param_list = "SELECT * FROM lab_param_list WHERE lab_list_id='$lab_list_id'";
														    $query_run_lab_param_list = mysqli_query($con, $query_lab_param_list);
														    if (mysqli_num_rows($query_run_lab_param_list) > 0)
															{
																$query_lab = "SELECT * FROM lab WHERE lab_id='$lab_id'";
									    						$query_run_lab = mysqli_query($con, $query_lab);
									    						$row_lab=mysqli_fetch_assoc($query_run_lab);
									    						$value.='
																		<tr style="background-color:#EEEEEE">
															        		<td colspan="7">
																				<strong>'.$row_lab['lab'].'</strong>
																			</td>
																		</tr>';
															        
																while($row_lab_param_list=mysqli_fetch_assoc($query_run_lab_param_list))
																{
																	$lab_param_id = $row_lab_param_list['lab_param_id'];
																	$querylab_param = "SELECT * FROM lab_param WHERE lab_param_id='$lab_param_id'";
													    			$query_run_lab_param = mysqli_query($con, $querylab_param);
													    			$row_lab_param=mysqli_fetch_assoc($query_run_lab_param);
																	$value.='
																			<tr>
																        		<td>
																					'.$row_lab_param['lab_param'].'
																				</td>
																				<td>
																					'.$row_lab_param_list['result'].'
																				</td>
																				<td>
																					'.$row_lab_param_list['low_range'].'
																				</td>
																				<td>
																					'.$row_lab_param_list['high_range'].'
																				</td>
																				<td>
																					'.$row_lab_param['unit'].'
																				</td>
																				<td>
																					'.$row_lab_param_list['flag'].'
																				</td>
																				<td>
																					'.$row_lab_param_list['comment'].'
																				</td>
																        	</tr>
																        	<tr>
																			</tr>';
																};
															};
														};
													
										$value.='</tbody>
	    									</table>';
    							};
    						//RADIOLOGY
								$query_radiolist = "SELECT * FROM radio_list WHERE attend_id = '$attend_id'";
			    				$query_run_radiolist = mysqli_query($con, $query_radiolist);
			    				if (mysqli_num_rows($query_run_radiolist) > 0)
								{
									$value.='<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
		        								<thead>
													<tr style="background-color:#E4DCCF; color:black">
										        		<td colspan="12">
															<strong>RADIOLOGY</strong>
														</td>
													</tr>
													<tr>
										                <th width="30%">Parameter</th>
										                <th width="15%">Result</th>
										                <th width="55%">Comment</th>
										            </tr>
										        </thead>
										        <tbody class="pv-table-body">';
														while($row_radio_list = mysqli_fetch_assoc($query_run_radiolist))
														{
															$radio_id = $row_radio_list['radio_id'];
															$radio_list_id = $row_radio_list['radio_list_id'];
															$queryradio_param_list = "SELECT * FROM radio_param_list WHERE radio_list_id = '$radio_list_id'";
														    $query_run_radio_param_list = mysqli_query($con, $queryradio_param_list);
														    if (mysqli_num_rows($query_run_radio_param_list) > 0)
															{
																$query_radio = "SELECT * FROM radiology WHERE radio_id = '$radio_id'";
									    						$query_run_radio = mysqli_query($con, $query_radio);
									    						$row_radio = mysqli_fetch_assoc($query_run_radio);
									    						$value.='<tr style="background-color:#EEEEEE">
															        		<td colspan="7">
																				<strong>'.$row_radio['radiology'].'</strong>
																			</td>
																		</tr>';
															        
																while($row_radio_param_list = mysqli_fetch_assoc($query_run_radio_param_list))
																{
																	$radio_param_id = $row_radio_param_list['radio_param_id'];
																	$query_radio_param = "SELECT * FROM radio_param WHERE radio_param_id = '$radio_param_id'";
													    			$query_run_radio_param = mysqli_query($con, $query_radio_param);
													    			$row_radio_param = mysqli_fetch_assoc($query_run_radio_param);
																	$value.='<tr>
																        		<td>'.$row_radio_param['radio_param'].'</td>
																				<td>'.$row_radio_param_list['result'].'</td>
																				<td>'.$row_radio_param_list['comment'].'</td>
																        	</tr>
																        	<tr>
																			</tr>';
																};
															};
														};
													
										$value.='</tbody>
	    									</table>';
    							};
    						//PRESCRIPTION
    							$query_presc = "SELECT * FROM drug_list WHERE attend_id='$attend_id' ORDER BY date DESC";
								$result_presc = mysqli_query($con,$query_presc);
					            if (mysqli_num_rows($result_presc) > 0)
				                {
	    							$value.='<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
		        								<thead>
													<tr style="background-color:#E4DCCF; color:black">
										        		<td colspan="12">
															<strong>PRESCRIPTION</strong>
														</td>
													</tr>
													<tr>
										                <th>Date</th>
										                <th>Drug</th>
										                <th>Qty Presc.</th>
										                <th>Qty Disp.</th>
										                <th>Dosage</th>
										            </tr>
										        </thead>
										        <tbody class="pv-table-body">';
														while($row_presc=mysqli_fetch_assoc($result_presc))
														{
															$drug_id = $row_presc['drug_id'];
										                	$query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
															$query_run_drug = mysqli_query($con, $query_drug);
															$row_drug=mysqli_fetch_assoc($query_run_drug);

															$drug_list_id = $row_presc['drug_list_id'];
															$query_ddisp = "SELECT SUM(amt_cash) AS amt_cash, SUM(amt_prvt) AS amt_prvt, SUM(amt_nhis) AS amt_nhis, SUM(qty) AS qty FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
															$query_run_ddisp = mysqli_query($con, $query_ddisp);
															$row_ddisp=mysqli_fetch_assoc($query_run_ddisp);

															$value.='<tr>
													                    <td>'.$row_presc['date'].'</td>
													                    <td>'.$row_drug['brand_name'].'</td>
													                    <td>'.$row_presc['qty_presc'].'</td>
													                    <td>'.$row_ddisp['qty'].'</td>
													                    <td>'.$row_presc['dosage'].'</td>
													                </tr>';
														}
										$value.='</tbody>
	    									</table>';
    							};
    						//DRUG ADMINISTRATION
    							$query_drug_admin = "SELECT * FROM drug_admin WHERE attend_id='$attend_id'";
								$query_run_drug_admin = mysqli_query($con, $query_drug_admin);
			    				if (mysqli_num_rows($query_run_drug_admin) > 0)
								{
	    							$value.='<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
		        								<thead>
													<tr style="background-color:#E4DCCF; color:black">
										        		<td colspan="12">
															<strong>DRUG ADMINISTRATION</strong>
														</td>
													</tr>
													<tr>
										                <th width="10%">Date</th>
										                <th width="10%">Time</th>
										                <th width="10%">Route</th>
										                <th width="10%">Dosage</th>
										                <th width="10%">Qty Admin</th>
										                <th width="40%">Drug</th>
										                <th width="10%">Admin By</th>
										            </tr>
										        </thead>
										        <tbody class="pv-table-body">
											        <tr style="background-color:#E4E1E0">
										        		<td colspan="7">
															<strong>STAT</strong>
														</td>
													</tr>';
													$query_drug_admin_stat = "
									        			SELECT * FROM drug_admin AS da 
									        			JOIN drug_list AS dl 
									        			ON da.drug_list_id=dl.drug_list_id
									        			WHERE da.attend_id='$attend_id' 
									        			AND dl.dosage LIKE '%st%' ORDER BY da.date DESC, da.time DESC";

									        	$query_run_drug_admin_stat = mysqli_query($con, $query_drug_admin_stat);
							    				if (mysqli_num_rows($query_run_drug_admin_stat) > 0)
												{
													while($row_drug_admin_stat=mysqli_fetch_assoc($query_run_drug_admin_stat))
													{
														$drug_id = $row_drug_admin_stat['drug_id'];
														$drug_list_id = $row_drug_admin_stat['drug_list_id'];
														$route_id = $row_drug_admin_stat['route_id'];

														$query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
													    $query_run_drug = mysqli_query($con, $query_drug);
													    $row_drug=mysqli_fetch_assoc($query_run_drug);
													    $drug = $row_drug['brand_name'];

														$query_drug_list = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
														$query_run_drug_list = mysqli_query($con, $query_drug_list);
													    $row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
													    $dosage = $row_drug_list['dosage'];

													    $query_route = "SELECT * FROM drug_route WHERE route_id='$route_id'";
														$query_run_route = mysqli_query($con, $query_route);
													    $row_route=mysqli_fetch_assoc($query_run_route);
													    $route = $row_route['route'];

													    $value.='
																<tr>
													        		<td>
																		'.$row_drug_admin_stat['date'].'
																	</td>
													        		<td>
																		'.$row_drug_admin_stat['time'].'
																	</td>
																	<td>
																		'.$route.'
																	</td>
																	<td>
																		'.$dosage.'
																	</td>
																	<td>
																		'.$row_drug_admin_stat['qty_admin'].'
																	</td>
																	<td>
																		'.$drug.'
																	</td>
																	<td>
																		'.$row_drug_admin_stat['initials'].'
																	</td>
													        	</tr>';
													}
												}
												else
												{
													$value.='
															<tr>
																<td>
																</td>
															</tr>';
												};
												$value.='<tr style="background-color:#E4E1E0">
											        		<td colspan="7">
																<strong>INFUSIONS</strong>
															</td>
														</tr>';
												$query_drug_admin_infusion = "
									        			SELECT * FROM drug_admin AS da 
									        			JOIN drugs AS ds 
									        			ON da.drug_id=ds.drug_id
									        			WHERE da.attend_id='$attend_id' 
									        			AND ds.category=3 ORDER BY ds.brand_name ASC, da.date DESC, da.time DESC";

									        	$query_run_drug_admin_infusion = mysqli_query($con, $query_drug_admin_infusion);
							    				if (mysqli_num_rows($query_run_drug_admin_infusion) > 0)
												{
													while($row_drug_admin_infusion=mysqli_fetch_assoc($query_run_drug_admin_infusion))
													{
														$drug_id = $row_drug_admin_infusion['drug_id'];
														$drug_list_id = $row_drug_admin_infusion['drug_list_id'];
														$route_id = $row_drug_admin_infusion['route_id'];

														$query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
													    $query_run_drug = mysqli_query($con, $query_drug);
													    $row_drug=mysqli_fetch_assoc($query_run_drug);
													    $drug = $row_drug['brand_name'];

														$query_drug_list = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
														$query_run_drug_list = mysqli_query($con, $query_drug_list);
													    $row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
													    $dosage = $row_drug_list['dosage'];

													    $query_route = "SELECT * FROM drug_route WHERE route_id='$route_id'";
														$query_run_route = mysqli_query($con, $query_route);
													    $row_route=mysqli_fetch_assoc($query_run_route);
													    $route = $row_route['route'];

													    $value.='
																<tr>
													        		<td>
																		'.$row_drug_admin_infusion['date'].'
																	</td>
													        		<td>
																		'.$row_drug_admin_infusion['time'].'
																	</td>
																	<td>
																		'.$route.'
																	</td>
																	<td>
																		'.$dosage.'
																	</td>
																	<td>
																		'.$row_drug_admin_infusion['qty_admin'].'
																	</td>
																	<td>
																		'.$drug.'
																	</td>
																	<td>
																		'.$row_drug_admin_infusion['initials'].'
																	</td>
													        	</tr>';
													}
												}else
												{
													$value.='
															<tr>
																<td>
																</td>
															</tr>';
												};
												$value.='<tr style="background-color:#E4E1E0">
											        		<td colspan="7">
																<strong>OTHERS</strong>
															</td>
														</tr>';
												$query_drug_admin_other = "
									        			SELECT * FROM drug_admin AS da 
									        			JOIN drugs AS ds 
									        			ON da.drug_id=ds.drug_id
									        			WHERE da.attend_id='$attend_id' 
									        			AND ds.category<>3 ORDER BY ds.brand_name ASC, da.date DESC, da.time DESC";

									        	$query_run_drug_admin_other = mysqli_query($con, $query_drug_admin_other);
							    				if (mysqli_num_rows($query_run_drug_admin_other) > 0)
												{
													while($row_drug_admin_other=mysqli_fetch_assoc($query_run_drug_admin_other))
													{
														$drug_id = $row_drug_admin_other['drug_id'];
														$drug_list_id = $row_drug_admin_other['drug_list_id'];
														$route_id = $row_drug_admin_other['route_id'];

														$query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
													    $query_run_drug = mysqli_query($con, $query_drug);
													    $row_drug=mysqli_fetch_assoc($query_run_drug);
													    $drug = $row_drug['brand_name'];

														$query_drug_list = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
														$query_run_drug_list = mysqli_query($con, $query_drug_list);
													    $row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
													    $dosage = $row_drug_list['dosage'];

													    $query_route = "SELECT * FROM drug_route WHERE route_id='$route_id'";
														$query_run_route = mysqli_query($con, $query_route);
													    $row_route=mysqli_fetch_assoc($query_run_route);
													    $route = $row_route['route'];

													    $value.='
																<tr>
													        		<td>
																		'.$row_drug_admin_other['date'].'
																	</td>
													        		<td>
																		'.$row_drug_admin_other['time'].'
																	</td>
																	<td>
																		'.$route.'
																	</td>
																	<td>
																		'.$dosage.'
																	</td>
																	<td>
																		'.$row_drug_admin_other['qty_admin'].'
																	</td>
																	<td>
																		'.$drug.'
																	</td>
																	<td>
																		'.$row_drug_admin_other['initials'].'
																	</td>
													        	</tr>';
													}
												}
												else
												{
													$value.='
															<tr>
																<td>
																</td>
															</tr>';
												};
										$value.='</tbody>
	    									</table>';
    							};
    						//SURGERIES
    						//MANAGEMENT PLAN
    						//NURSES NOTES
    						//ANTENATAL
    						//DELIVERY
    						//POSTNATAL
						};
					};
				echo $value;
			}*/

			function patient_folder_display()
			{
				global $con;
			    $_SESSION['patient_id'] = $_POST['patient_id'];
			}
		//UPDATE PRIVATE PRICES
			function update_private_prices()
			{
				global $con;
				//SERVICES
					$query_find = "SELECT * FROM services WHERE price_private < 1";
					$query_run_find = mysqli_query($con,$query_find);
					while($row_find = mysqli_fetch_assoc($query_run_find))
					{
						$service_id = $row_find['service_id'];
						$cash_price = $row_find['price_cash'];
						$private_price = $cash_price * 1.30;
						$query_update = "UPDATE `services` SET `price_private`='$private_price' WHERE `service_id`='$service_id'";
						mysqli_query($con, $query_update);
					};

				//LABS
					$query_find = "SELECT * FROM lab WHERE price_private < 1";
					$query_run_find = mysqli_query($con,$query_find);
					while($row_find = mysqli_fetch_array($query_run_find))
					{
						$lab_id = $row_find['lab_id'];
						$cash_price = $row_find['price_cash'];
						$private_price = $cash_price * 1.30;
						$query_update = "UPDATE `lab` SET `price_private`='$private_price' WHERE `lab_id`='$lab_id'";
						mysqli_query($con, $query_update);
					};

				//RADIOLOGY
					$query_find = "SELECT * FROM radiology WHERE price_private < 1";
					$query_run_find = mysqli_query($con,$query_find);
					while($row_find = mysqli_fetch_array($query_run_find))
					{
						$radio_id = $row_find['radio_id'];
						$cash_price = $row_find['price_cash'];
						$private_price = $cash_price * 1.30;
						$query_update = "UPDATE `radiology` SET `price_private`='$private_price' WHERE `radio_id`='$radio_id'";
						mysqli_query($con, $query_update);
					};

				//DRUGS
					$query_find = "SELECT * FROM drugs WHERE price_prvt < 1";
					$query_run_find = mysqli_query($con,$query_find);
					while($row_find = mysqli_fetch_array($query_run_find))
					{
						$drug_id = $row_find['drug_id'];
						$cash_price = $row_find['price_cash'];
						$private_price = $cash_price * 1.30;
						$query_update = "UPDATE `drugs` SET `price_prvt`='$private_price' WHERE `drug_id`='$drug_id'";
						mysqli_query($con, $query_update);
					};

				//CONSUMABLES
					$query_find = "SELECT * FROM consumable WHERE price_prvt < 1";
					$query_run_find = mysqli_query($con,$query_find);
					while($row_find = mysqli_fetch_array($query_run_find))
					{
						$con_id = $row_find['con_id'];
						$cash_price = $row_find['price_cash'];
						$private_price = $cash_price * 1.30;
						$query_update = "UPDATE `consumable` SET `price_prvt`='$private_price' WHERE `con_id`='$con_id'";
						mysqli_query($con, $query_update);
					};

				//SURGERIES
					$query_find = "SELECT * FROM surgery WHERE price_private < 1";
					$query_run_find = mysqli_query($con,$query_find);
					while($row_find = mysqli_fetch_array($query_run_find))
					{
						$surgery_id = $row_find['surgery_id'];
						$cash_price = $row_find['price_cash'];
						$private_price = $cash_price * 1.30;
						$query_update = "UPDATE `surgery` SET `price_private`='$private_price' WHERE `surgery_id`='$surgery_id'";
						mysqli_query($con, $query_update);
					};

				//SERVICE_LIST
					$query_find = "SELECT * FROM service_list WHERE ledger_id != 1";
					$query_run_find = mysqli_query($con,$query_find);
					while($row_find = mysqli_fetch_array($query_run_find))
					{
						if($row_find['amount_prvt'] < 1)
						{
							$service_list_id = $row_find['service_list_id'];
							$prvt_led_id = $row_find['ledger_id'];
							$attend_id = $row_find['attend_id'];
							$patient_id = $row_find['patient_id'];
							$service_date = $row_find['date'];
							$service_amt_cash = $row_find['amount_cash'];
							$service_amt_nhis = $row_find['amount_nhis'];
							
							if($row_find['qty'] > 0){$qty = $row_find['qty'];}else{$qty = 1;}
							$service_id = $row_find['service_id'];
							$query_item = "SELECT * FROM services WHERE service_id = '$service_id'";
							$query_run_item = mysqli_query($con,$query_item);
							$row_item = mysqli_fetch_array($query_run_item);
							
							//UPDATE SERVICE_LIST PRIVATE PRICE
							$private_price = $row_item['price_private'];
							$service_amt_prvt = $row_item['price_private'] * $qty;
							$query_update = "UPDATE `service_list` SET `price_prvt`='$private_price',
							`amount_prvt`='$service_amt_prvt' WHERE `service_list_id`='$service_list_id'";
							mysqli_query($con, $query_update);

							//DELETE TRANSACTION
							$query_trans_del = "DELETE FROM `transactions` WHERE `service_list_id`='$service_list_id'";
							mysqli_query($con, $query_trans_del);
							
							//POST TO TRANSACTION
							if ($row_find['amount_cash'] > 0)
							{
								$query_cash_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, 
								`attend_id`, `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (1,9,'$attend_id',
								'$service_list_id','$service_list_id','$patient_id',1,'$service_date',
								'$service_amt_cash','$service_amt_cash',0,'Cash Service')";
								mysqli_query($con, $query_cash_dr);
								
								$query_cash_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, 
								`attend_id`, `item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (9,1,'$attend_id',
								'$service_list_id','$service_list_id','$patient_id',1,'$service_date',
								'$service_amt_cash',0,'$service_amt_cash','Cash Service')";
								mysqli_query($con, $query_cash_cr);
							} 
							else if ($service_amt_prvt > 0)
							{
								$query_prvt_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`,
								`item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
								`amt_credit`, `narration`) VALUES ('$prvt_led_id',9,'$attend_id','$service_list_id',
								'$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt','$service_amt_prvt',
								0,'Insured Service')";
								mysqli_query($con, $query_prvt_dr);

								$query_prvt_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
								`item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
								`amt_credit`, `narration`) VALUES (9,'$prvt_led_id','$attend_id','$service_list_id',
								'$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt',0,
								'$service_amt_prvt','Insured Service')";
								mysqli_query($con, $query_prvt_cr);
							}
							else if ($row_find['amount_nhis'] > 0)
							{
								$query_nhis_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
								`item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
								`amt_credit`, `narration`) VALUES (2,9,'$attend_id','$service_list_id','$service_list_id',
								'$patient_id',1,'$service_date','$service_amt_nhis','$service_amt_nhis',0,'NHIS Service')";
								mysqli_query($con, $query_nhis_dr);

								$query_nhis_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
								`item_list_id`, `service_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
								`amt_credit`, `narration`) VALUES (9,2,'$attend_id','$service_list_id','$service_list_id',
								'$patient_id',1,'$service_date','$service_amt_nhis',0,'$service_amt_nhis','NHIS Service')";
								mysqli_query($con, $query_nhis_cr);
							};
						};
					};
				//LAB_LIST
					$query_find = "SELECT * FROM lab_list WHERE ledger_id != 1";
					$query_run_find = mysqli_query($con,$query_find);
					while($row_find = mysqli_fetch_array($query_run_find))
					{
						if($row_find['amount_prvt'] < 1)
						{
							$lab_list_id = $row_find['lab_list_id'];
							$query_perform = "SELECT * FROM lab_param_list WHERE lab_list_id = '$lab_list_id'";
							$query_run_perform = mysqli_query($con,$query_perform);
							if(mysqli_num_rows($query_run_perform) > 0)
							{
								$prvt_led_id = $row_find['ledger_id'];
								$attend_id = $row_find['attend_id'];
								$patient_id = $row_find['patient_id'];
								$date = $row_find['date'];
								$amount_cash = $row_find['amount_cash'];
								$amount_nhis = $row_find['amount_nhis'];
								if($row_find['qty'] > 0){$qty = $row_find['qty'];}else{$qty = 1;};
								$lab_id = $row_find['lab_id'];

								$query_item = "SELECT * FROM lab WHERE lab_id = '$lab_id'";
								$query_run_item = mysqli_query($con,$query_item);
								$row_item = mysqli_fetch_array($query_run_item);
								
								//UPDATE SERVICE_LIST PRIVATE PRICE
								$private_price = $row_item['price_private'];
								$amount_prvt = $row_item['price_private'] * $qty;
								$query_update = "UPDATE `lab_list` SET `price_prvt`='$private_price',
								`amount_prvt`='$amount_prvt' WHERE `lab_list_id`='$lab_list_id'";
								mysqli_query($con, $query_update);

								//DELETE TRANSACTION
								$query_trans_del = "DELETE FROM `transactions` WHERE `lab_list_id`='$lab_list_id'";
								mysqli_query($con, $query_trans_del);
								
								//POST TO TRANSACTION
								if ($amount_cash > 0)
								{
									$query_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
									`patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
									`lab_list_id`, `narration`) VALUES (1,6,'$attend_id','$patient_id',3,'$date',
									'$amount_cash','$amount_cash',0,'$lab_list_id','$lab_list_id',
									'lab test performed for cash')";
									mysqli_query($con, $query_dr);

									$query_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
									`patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
									`lab_list_id`, `narration`) VALUES (6,1,'$attend_id','$patient_id',3,'$date',
									'$amount_cash',0,'$amount_cash','$lab_list_id','$lab_list_id',
									'lab test performed for cash')";
									mysqli_query($con, $query_cr);
								}
								if ($amount_prvt > 0)
								{
									$query_dr = "INSERT INTO `transactions`(
									`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
									`amt_debit`, `amt_credit`, `item_list_id`, `lab_list_id`, `narration`) VALUES (
									'$prvt_led_id',6,'$attend_id','$patient_id',3,'$date','$amount_prvt','$amount_prvt',
									0,'$lab_list_id','$lab_list_id','lab test performed for NHIS')";
									mysqli_query($con, $query_dr);

									$query_cr = "INSERT INTO `transactions`(
									`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
									`amt_debit`, `amt_credit`, `item_list_id`, `lab_list_id`, `narration`) VALUES (6,
									'$prvt_led_id','$attend_id','$patient_id',3,'$date','$amount_prvt',0,'$amount_prvt',
									'$lab_list_id','$lab_list_id','lab test performed for NHIS')";
									mysqli_query($con, $query_cr);
								}
								if ($amount_nhis > 0)
								{
									$query_dr = "INSERT INTO `transactions`(
									`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
									`amt_debit`, `amt_credit`, `item_list_id`, `lab_list_id`, `narration`) VALUES (2,6,
									'$attend_id','$patient_id',3,'$date','$amount_nhis','$amount_nhis',0,'$lab_list_id',
									'$lab_list_id','lab test performed for NHIS')";
									mysqli_query($con, $query_dr);

									$query_cr = "INSERT INTO `transactions`(
									`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
									`amt_debit`, `amt_credit`, `item_list_id`, `lab_list_id`, `narration`) VALUES (6,2,
									'$attend_id','$patient_id',3,'$date','$amount_nhis',0,'$amount_nhis','$lab_list_id',
									'$lab_list_id','lab test performed for NHIS')";
									mysqli_query($con, $query_cr);
								}
							};
						};
					};
				//RADIOLOGY_LIST
					$query_find = "SELECT * FROM radio_list WHERE ledger_id != 1";
					$query_run_find = mysqli_query($con,$query_find);
					while($row_find = mysqli_fetch_array($query_run_find))
					{
						if($row_find['amount_prvt'] < 1)
						{
							$radio_list_id = $row_find['radio_list_id'];
							$query_perform = "SELECT * FROM radio_param_list WHERE radio_list_id = '$lab_list_id'";
							$query_run_perform = mysqli_query($con,$query_perform);
							if(mysqli_num_rows($query_run_perform) > 0)
							{
								$prvt_led_id = $row_find['ledger_id'];
								$attend_id = $row_find['attend_id'];
								$patient_id = $row_find['patient_id'];
								$date = $row_find['date'];
								$amount_cash = $row_find['amount_cash'];
								$amount_nhis = $row_find['amount_nhis'];
								if($row_find['qty'] > 0){$qty = $row_find['qty'];}else{$qty = 1;};
								$radio_id = $row_find['radio_id'];

								$query_item = "SELECT * FROM radiology WHERE radio_id = '$radio_id'";
								$query_run_item = mysqli_query($con,$query_item);
								$row_item = mysqli_fetch_array($query_run_item);
								
								//UPDATE SERVICE_LIST PRIVATE PRICE
								$private_price = $row_item['price_private'];
								$amount_prvt = $row_item['price_private'] * $qty;
								$query_update = "UPDATE `radio_list` SET `price_prvt`='$private_price',
								`amount_prvt`='$amount_prvt' WHERE `radio_list_id`='$radio_list_id'";
								mysqli_query($con, $query_update);

								//DELETE TRANSACTION
								$query_trans_del = "DELETE FROM `transactions` WHERE `rado_list_id`='$radio_list_id'";
								mysqli_query($con, $query_trans_del);
								
								//POST TO TRANSACTION
								if ($amount_cash > 0)
								{
									$query_dr = "INSERT INTO `transactions`(
									`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
									`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `radio_list_id`, `narration`) 
									VALUES (1,7,'$attend_id','$patient_id',4,'$date','$amount_cash','$amount_cash',0,
									'$radio_list_id','$radio_list_id','radiology test performed for cash')";
									mysqli_query($con, $query_dr);

									$query_cr = "INSERT INTO `transactions`(
									`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
									`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `radio_list_id`, `narration`) 
									VALUES (7,1,'$attend_id','$patient_id',4,'$date','$amount_cash',0,'$amount_cash',
									'$radio_list_id','$radio_list_id','radiology test performed for cash')";
									mysqli_query($con, $query_cr);

								}
								if ($amount_prvt > 0)
								{
									$query_dr = "INSERT INTO `transactions`(
									`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
									`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `radio_list_id`, `narration`) 
									VALUES ('$prvt_led_id',7,'$attend_id','$patient_id',4,'$date','$amount_prvt',
									'$amount_prvt',0,'$radio_list_id','$radio_list_id','radiology test performed for NHIS')";
									mysqli_query($con, $query_dr);

									$query_cr = "INSERT INTO `transactions`(
									`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
									`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `radio_list_id`, `narration`) 
									VALUES (7,'$prvt_led_id','$attend_id','$patient_id',4,'$date','$amount_prvt',0,
									'$amount_prvt','$radio_list_id','$radio_list_id','radiology test performed for NHIS')";
									mysqli_query($con, $query_cr);
								}
								if ($amount_nhis > 0)
								{
									$query_dr = "INSERT INTO `transactions`(
									`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
									`amt`, `amt_debit`, `amt_credit`, `radio_list_id`, `item_list_id`, `narration`) 
									VALUES (2,7,'$attend_id','$patient_id',4,'$date','$amount_nhis','$amount_nhis',0,
									'$radio_list_id','$radio_list_id','radiology test performed for NHIS')";
									mysqli_query($con, $query_dr);

									$query_cr = "INSERT INTO `transactions`(
									`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
									`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `radio_list_id`, `narration`) 
									VALUES (7,2,'$attend_id','$patient_id',4,'$date','$amount_nhis',0,'$amount_nhis',
									'$radio_list_id','$radio_list_id','radiology test performed for NHIS')";
									mysqli_query($con, $query_cr);
								};
							};
						};
					};
				//DRUG_LIST
					$query_find = "SELECT * FROM drug_dispense_list WHERE ledger_id != 1";
					$query_run_find = mysqli_query($con,$query_find);
					while($row_find = mysqli_fetch_array($query_run_find))
					{
						$drug_disp_list_id = $row_find['drug_disp_list_id'];
						$drug_list_id = $row_find['drug_list_id'];
						if($row_find['amt_prvt'] < 1)
						{
							$prvt_led_id = $row_find['ledger_id'];
							$attend_id = $row_find['attend_id'];
							$patient_id = $row_find['patient_id'];
							$date = $row_find['date'];
							$amount_cash = $row_find['amt_cash'];
							$amount_nhis = $row_find['amt_nhis'];
							if($row_find['qty'] > 0){$qty = $row_find['qty'];}else{$qty = 1;};
							$drug_id = $row_find['drug_id'];

							$query_item = "SELECT * FROM drugs WHERE drug_id = '$drug_id'";
							$query_run_item = mysqli_query($con,$query_item);
							$row_item = mysqli_fetch_array($query_run_item);
							
							//UPDATE SERVICE_LIST PRIVATE PRICE
							$private_price = $row_item['price_prvt'];
							$amount_prvt = $row_item['price_prvt'] * $qty;
							$query_update = "UPDATE `drug_dispense_list` SET `price_prvt`='$private_price',
							`amt_prvt`='$amount_prvt' WHERE `drug_disp_list_id`='$drug_disp_list_id'";
							mysqli_query($con, $query_update);

							//DELETE TRANSACTION
							$query_trans_del = "DELETE FROM `transactions` WHERE `drug_disp_list_id`='$drug_disp_list_id'";
							mysqli_query($con, $query_trans_del);
							
							//POST TO TRANSACTION
							if ($amount_cash > 0)
			                {
			                	$query_dr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
								`amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES 
								(1,5,'$attend_id','$patient_id',2,'$date','$amount_cash','$amount_cash',0,
								'$drug_list_id','drug dispensed for cash','$drug_disp_list_id')";
				                mysqli_query($con, $query_dr);

				                $query_cr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
								`amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES 
								(5,2,'$attend_id','$patient_id',2,'$date','$amount_cash',0,'$amount_cash','$drug_list_id',
								'drug dispensed for cash','$drug_disp_list_id')";
				                mysqli_query($con, $query_cr);
			                }
			                if ($amount_prvt > 0)
			                {
			                	$query_dr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
								`amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES 
								('$prvt_led_id',2'$attend_id','$patient_id',2,'$date','$amount_prvt','$amount_prvt',0,
								'$drug_list_id','drug dispensed for Insurance','$drug_disp_list_id')";
				                mysqli_query($con, $query_dr);

				                $query_cr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
								`amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) VALUES (2,
								'$prvt_led_id','$attend_id','$patient_id',2,'$date','$amount_prvt',0,'$amount_prvt',
								'$drug_list_id','drug dispensed for Insurance','$drug_disp_list_id')";
				                mysqli_query($con, $query_cr);
			                }
			                if ($amount_nhis > 0)
			                {
			                	$query_dr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) 
								VALUES (2,5,'$attend_id','$patient_id',2,'$date','$amount_nhis','$amount_nhis',0,
								'$drug_list_id','drug dispensed for NHIS','$drug_disp_list_id')";
				                mysqli_query($con, $query_dr);

				                $query_cr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `narration`, `drug_disp_list_id`) 
								VALUES (5,2,'$attend_id','$patient_id',2,'$date','$amount_nhis',0,'$amount_nhis',
								'$drug_list_id','drug dispensed for NHIS','$drug_disp_list_id')";
				                mysqli_query($con, $query_cr);
			                };
						};
					};
				//CONSUMABLE_LIST
					$query_find = "SELECT * FROM consumable_list WHERE ledger_id != 1";
					$query_run_find = mysqli_query($con,$query_find);
					while($row_find = mysqli_fetch_array($query_run_find))
					{
						if($row_find['amount_prvt'] < 1)
						{
							$con_list_id = $row_find['con_list_id'];
							$prvt_led_id = $row_find['ledger_id'];
							$attend_id = $row_find['attend_id'];
							$patient_id = $row_find['patient_id'];
							$date = $row_find['date'];
							$amount_cash = $row_find['amount_cash'];
							$amount_nhis = $row_find['amount_nhis'];
							
							if($row_find['qty_issued'] > 0){$qty = $row_find['qty_issued'];}else{$qty = 1;}
							$con_id = $row_find['con_id'];
							$query_item = "SELECT * FROM consumable WHERE con_id = '$con_id'";
							$query_run_item = mysqli_query($con,$query_item);
							$row_item = mysqli_fetch_array($query_run_item);
							
							//UPDATE SERVICE_LIST PRIVATE PRICE
							$private_price = $row_item['price_prvt'];
							$amount_prvt = $row_item['price_prvt'] * $qty;
							$query_update = "UPDATE `consumable_list` SET `price_prvt`='$private_price',
							`amount_prvt`='$amount_prvt' WHERE `con_list_id`='$con_list_id'";
							mysqli_query($con, $query_update);

							//DELETE TRANSACTION
							$query_trans_del = "DELETE FROM `transactions` WHERE `con_list_id`='$con_list_id'";
							mysqli_query($con, $query_trans_del);
							
							//POST TO TRANSACTION
							if ($amount_cash > 0)
			                {
			                	$query_dr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) 
								VALUES (1,10'$attend_id','$patient_id',7,'$date','$amount_cash','$amount_cash',0,
								'$con_list_id','$con_list_id','consumable for cash')";
				                mysqli_query($con, $query_dr);

				                $query_cr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) 
								VALUES (10,1'$attend_id','$patient_id',7,'$date','$amount_cash',0,'$amount_cash',
								'$con_list_id','$con_list_id','consumable for cash')";
				                mysqli_query($con, $query_cr);
				            }
			                if ($amount_prvt > 0)
			                {
			                	$query_dr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) 
								VALUES ('$prvt_led_id',10,'$attend_id','$patient_id',7,'$date','$amount_prvt',
								'$amount_prvt',0,'$con_list_id','$con_list_id','consumable for NHIS')";
				                mysqli_query($con, $query_dr);

				                $query_cr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) 
								VALUES (10,'$prvt_led_id','$attend_id','$patient_id',7,'$date','$amount_prvt',0,
								'$amount_prvt','$con_list_id','$con_list_id','consumable for NHIS')";
				                mysqli_query($con, $query_cr);
			                }
			                if ($amount_nhis > 0)
			                {
			                	$query_dr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) 
								VALUES (2,10,'$attend_id','$patient_id',7,'$date','$amount_nhis','$amount_nhis',0,
								'$con_list_id','$con_list_id','consumable for NHIS')";
				                mysqli_query($con, $query_dr);

				                $query_cr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `con_list_id`, `narration`) 
								VALUES (10,2,'$attend_id','$patient_id',7,'$date','$amount_nhis',0,'$amount_nhis',
								'$con_list_id','$con_list_id','consumable for NHIS')";
				                mysqli_query($con, $query_cr);
			                };
						};
					};
				//SURGERY_LIST
					$query_find = "SELECT * FROM surgery_list WHERE ledger_id != 1";
					$query_run_find = mysqli_query($con,$query_find);
					while($row_find = mysqli_fetch_array($query_run_find))
					{
						if($row_find['amount_prvt'] < 1)
						{
							$surgery_list_id = $row_find['surgery_list_id'];
							$prvt_led_id = $row_find['ledger_id'];
							$attend_id = $row_find['attend_id'];
							$patient_id = $row_find['patient_id'];
							$date = $row_find['date'];
							$amount_cash = $row_find['amount_cash'];
							$amount_nhis = $row_find['amount_nhis'];
							
							if($row_find['qty'] > 0){$qty = $row_find['qty'];}else{$qty = 1;}
							$surgery_id = $row_find['surgery_id'];
							$query_item = "SELECT * FROM surgery WHERE surgery_id = '$surgery_id'";
							$query_run_item = mysqli_query($con,$query_item);
							$row_item = mysqli_fetch_array($query_run_item);
							
							//UPDATE SERVICE_LIST PRIVATE PRICE
							$private_price = $row_item['price_private'];
							$amount_prvt = $row_item['price_private'] * $qty;
							$query_update = "UPDATE `surgery_list` SET `price_prvt`='$private_price',
							`amount_prvt`='$amount_prvt' WHERE `surgery_list_id`='$surgery_list_id'";
							mysqli_query($con, $query_update);

							//DELETE TRANSACTION
							$query_trans_del = "DELETE FROM `transactions` WHERE `surgery_list_id`='$surgery_list_id'";
							mysqli_query($con, $query_trans_del);
							
							//POST TO TRANSACTION
							if ($amount_cash > 0)
			                {
			                	$query_dr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) 
								VALUES (1,8,'$attend_id','$patient_id',5,'$date','$amount_cash','$amount_cash',0,
								'$surgery_list_id','$surgery_list_id','surgery for cash')";
				                mysqli_query($con, $query_dr);

				                $query_cr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) 
								VALUES (8,1,'$attend_id','$patient_id',5,'$date','$amount_cash',0,'$amount_cash',
								'$surgery_list_id','$surgery_list_id','surgery for cash')";
				                mysqli_query($con, $query_cr);
				            }
			                if ($amount_prvt > 0)
			                {
			                	$query_dr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) 
								VALUES ('$prvt_led_id',8,'$attend_id','$patient_id',5,'$date','$amount_prvt',
								'$amount_prvt',0,'$surgery_list_id','$surgery_list_id','surgery for NHIS')";
				                mysqli_query($con, $query_dr);

				                $query_cr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) 
								VALUES (8,'$prvt_led_id','$attend_id','$patient_id',5,'$date','$amount_prvt',0,
								'$amount_prvt','$surgery_list_id','$surgery_list_id','surgery for NHIS')";
				                mysqli_query($con, $query_cr);
			                }
			                if ($amount_nhis > 0)
			                {
			                	$query_dr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) 
								VALUES (2,8,'$attend_id','$patient_id',5,'$date','$amount_nhis','$amount_nhis',0,
								'$surgery_list_id','$surgery_list_id','surgery for NHIS')";
				                mysqli_query($con, $query_dr);

				                $query_cr = "INSERT INTO `transactions`(
				                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
								`amt`, `amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) 
								VALUES (8,2,'$attend_id','$patient_id',5,'$date','$amount_nhis',0,'$amount_nhis',
								'$surgery_list_id','$surgery_list_id','surgery for NHIS')";
				                mysqli_query($con, $query_cr);
			                };
						};
					};
			}
		//EXCUSE DUTY
			function excuse_duty_process()
			{
				global $con;
			    $attend_id = $_POST['attend_id'];
				$Data = array();
				$query = "SELECT * FROM excuse_duty WHERE attend_id = '$attend_id'";
				$result = mysqli_query($con,$query);
				
				if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_assoc($result))
					{
						/*$query_diag_list = "SELECT * FROM diagnosis_list WHERE attend_id = '$attend_id'";
						$result_diag_list = mysqli_query($con, $query_diag_list);
						
						if(mysqli_num_rows($result_diag_list) > 0)
						{
							$diagnosis_list = '';
							$i = 0;
							while($row_diag_list = mysqli_fetch_assoc($result_diag_list))
							{
								$diagnosis_id = $row_diag_list['diagnosis_id'];
								$query_diag = "SELECT * FROM diagnosis WHERE diagnosis_id = '$diagnosis_id'";
								$result_diag = mysqli_query($con, $query_diag);
								
								if(mysqli_num_rows($result_diag) > 0)
								{
									while($row_diag = mysqli_fetch_assoc($result_diag))
									{
										$diagnosis = $row_diag['diagnosis'];
									};
								}
								else
								{
									$diagnosis = 'N/A';
								};

								++$i;
								if($i < 2)
								{
									$diagnosis_list = $diagnosis;
								}
								else
								{
									$diagnosis_list = $diagnosis_list.', '.$diagnosis;
								};
							};
						}
						else
						{
							$diagnosis_list = 'N/A';
						};

						if($diagnosis_list == $row['diagnosis'])
						{
							$dlist = $diagnosis_list;
						}
						else
						{
							$dlist = $row['diagnosis'];
						};*/
						array_push($Data, 
							$row['excuse_duty_id'],
							$row['patient_id'],
							$row['doctor'],
							$row['diagnosis'],
							$row['date_admit'],
							$row['date_discharged'],
							$row['date'],
							$row['narration'],
							'exist'
						);
					}
					echo json_encode($Data);
				}
				else
				{
					$query_attend = "SELECT * FROM attendance WHERE attend_id = '$attend_id'";
					$result_attend = mysqli_query($con, $query_attend);
					if(mysqli_num_rows($result_attend) > 0)
					{
						while($row_attend = mysqli_fetch_assoc($result_attend))
						{
							$query_diag_list = "SELECT * FROM diagnosis_list WHERE attend_id = '$attend_id'";
							$result_diag_list = mysqli_query($con, $query_diag_list);
							
							if(mysqli_num_rows($result_diag_list) > 0)
							{
								$diagnosis_list = '';
								$i = 0;
								while($row_diag_list = mysqli_fetch_assoc($result_diag_list))
								{
									$diagnosis_id = $row_diag_list['diagnosis_id'];
									$query_diag = "SELECT * FROM diagnosis WHERE diagnosis_id = '$diagnosis_id'";
									$result_diag = mysqli_query($con, $query_diag);
									
									if(mysqli_num_rows($result_diag) > 0)
									{
										while($row_diag = mysqli_fetch_assoc($result_diag))
										{
											$diagnosis = $row_diag['diagnosis'];
										};
									}
									else
									{
										$diagnosis = 'N/A';
									};

									++$i;
									if($i < 2)
									{
										$diagnosis_list = $diagnosis;
									}
									else
									{
										$diagnosis_list = $diagnosis_list.', '.$diagnosis;
									};
								};
							}
							else
							{
								$diagnosis_list = 'N/A';
							};
							if(isset($_SESSION['user_id']))
							{
								$user_id = $_SESSION['user_id'];
							}
							else
							{
								$user_id = $row_attend['doctor_id'];
							};

							array_push($Data, 
								0,
								$row_attend['patient_id'],
								$user_id,
								$diagnosis_list,
								$row_attend['date_admit'],
								$row_attend['date_disch'],
								$row_attend['date_admit'],
								'Excuse Duty',
								'new'
							);
						}
						echo json_encode($Data);
					}
				};
			}

			function excuse_duty_save()
			{
				global $con;
			    $attend_id = $_POST['attend_id'];
			    $patient_id = $_POST['patient_id'];
			    $doctor = $_POST['excuse_duty_doctor'];
			    $diagnosis = $_POST['excuse_duty_diagnosis'];
			    $date = $_POST['excuse_duty_date'];
			    $date_admit = $_POST['excuse_duty_date_admit'];
			    $date_discharge = $_POST['excuse_duty_date_discharge'];
			    $remarks = $_POST['excuse_duty_remarks'];
			    $excuse_duty_id = $_POST['excuse_duty_id'];
				$company_id = $_SESSION['company_id'];
				$branch_id = $_SESSION['branch_id'];
				$user_id = $_SESSION['user_id'];

				$query = "INSERT INTO `excuse_duty`(
				`company_id`, `attend_id`, `patient_id`, `doctor`, `date_admit`, `date_discharged`, 
				`diagnosis`, `date`, `narration`, `user_id`, `created_by`, `created_datetime`, `branch_id`) VALUES (
				'$company_id','$attend_id','$patient_id','$doctor','$date_admit','$date_discharge',
				'$diagnosis','$date','$remarks','$user_id','$user_id',NOW(),'$branch_id')";
				$query_run = mysqli_query($con, $query);
				if ($query_run)
				{
					$query_ed = "SELECT * FROM excuse_duty ORDER BY excuse_duty_id DESC";
					$result_ed = mysqli_query($con,$query_ed);
					$row_ed = mysqli_fetch_assoc($result_ed);
					$_SESSION['excuse_duty_id'] = $row_ed['excuse_duty_id'];

					/*if ($_SESSION['user_type_id'] == 6) {
						doctor_attend_register();
					};*/
				};
			}
			
			function excuse_duty_update()
			{
				global $con;
			    $attend_id = $_POST['attend_id'];
			    $patient_id = $_POST['patient_id'];
			    $doctor = $_POST['excuse_duty_doctor'];
			    $diagnosis = $_POST['excuse_duty_diagnosis'];
			    $date = $_POST['excuse_duty_date'];
			    $date_admit = $_POST['excuse_duty_date_admit'];
			    $date_discharge = $_POST['excuse_duty_date_discharge'];
			    $remarks = $_POST['excuse_duty_remarks'];
			    $excuse_duty_id = $_POST['excuse_duty_id'];
				$company_id = $_SESSION['company_id'];
				$branch_id = $_SESSION['branch_id'];
				$user_id = $_SESSION['user_id'];

				$query = "UPDATE `excuse_duty`SET
				`doctor`='$doctor', `date_admit`='$date_admit', `date_discharged`='$date_discharge', 
				`diagnosis`='$diagnosis', `date`='$date', `narration`='$remarks', `altered_by`='$user_id',
				`altered_datetime`=now() WHERE `excuse_duty_id`='$excuse_duty_id'";
				$query_run = mysqli_query($con, $query);
				//$error = mysqli_error($con);
				//echo $error;
				if ($query_run)
				{
					$_SESSION['excuse_duty_id'] = $excuse_duty_id;
				};
			}
		//OTHERS
			function current_date()
			{
				date_default_timezone_set('Africa/Accra');
				$date = date('m/d/Y h:i:s a', time());
				echo $date;
			}

			function age($dob)
			{
				$dateOfBirth = $dob;
				$today = date("Y-m-d");
				$diff = date_diff(date_create($dateOfBirth), date_create($today));
				echo $diff->format('%y');
			}
	//APPOINTMENT
		function calendar_by_type_go()
		{
			global $con;
			$_SESSION['appoint_type'] = $_POST['appoint_type'];
			$_SESSION['appoint_doctor'] = $_POST['appoint_doctor'];
			$_SESSION['appoint_theatre'] = $_POST['appoint_theatre'];
			$_SESSION['appoint_start'] = $_POST['appoint_start'];
			$_SESSION['appoint_end'] = $_POST['appoint_end'];
		}

		function appointment_report_display()
		{
			global $con;
			$_SESSION['appoint_company_id'] = $_POST['appoint_company_id'];
			$_SESSION['appoint_user_super_id'] = $_POST['appoint_user_super_id'];
			$_SESSION['appoint_type'] = $_POST['appoint_type'];
			$_SESSION['appoint_doctor'] = $_POST['appoint_doctor'];
			$_SESSION['appoint_theatre'] = $_POST['appoint_theatre'];
			$_SESSION['appoint_start'] = $_POST['appoint_start'];
			$_SESSION['appoint_end'] = $_POST['appoint_end'];
		}

		function appointment_report_by_date_display()
		{
			global $con;
			$_SESSION['appoint_company_id'] = $_POST['appoint_company_id'];
			$_SESSION['appoint_user_super_id'] = $_POST['appoint_user_super_id'];
			$_SESSION['appoint_type'] = $_POST['appoint_type'];
			$_SESSION['appoint_doctor'] = $_POST['appoint_doctor'];
			$_SESSION['appoint_theatre'] = $_POST['appoint_theatre'];
			$_SESSION['appoint_start'] = $_POST['appoint_start'];
			$_SESSION['appoint_end'] = $_POST['appoint_end'];
		}

?>
