<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    if(isset($_SESSION['patient_id'])){$patient_id = $_SESSION['patient_id'];}else{$patient_id =0;};
    if(isset($_SESSION['company_id'])){$company_id = $_SESSION['company_id'];}else{$company_id =0;};
    if(isset($_SESSION['attend_id'])){$attend_id = $_SESSION['attend_id'];}else{$attend_id =0;};
    if(isset($_SESSION['folderno'])){$folderno = $_SESSION['folderno'];}else{$folderno =0;};
    if(isset($_SESSION['dob'])){$DOB = $_SESSION['dob'];}else{$DOB =0;};
    if(isset($_SESSION['gender'])){$gender = $_SESSION['gender'];}else{$gender =0;};
    if(isset($_SESSION['scheme_id'])){$scheme_id = $_SESSION['scheme_id'];}else{$scheme_id =0;};
    if(isset($_SESSION['nhismemberno'])){$nhismemberno = $_SESSION['nhismemberno'];}else{$nhismemberno =0;};
    if(isset($_SESSION['name'])){$name = $_SESSION['name'];}else{$name ='N/A';};
    if(isset($_SESSION['attend_state'])){$attend_state = $_SESSION['attend_state'];}else{$attend_state ='';};
    if(isset($_SESSION['Schname'])){$Schname = $_SESSION['Schname'];}else{$Schname ='';};
    if(isset($_SESSION['nhisexpirydate'])){$nhisexpirydate = $_SESSION['nhisexpirydate'];}else{$nhisexpirydate ='';};
    if(isset($_SESSION['serial_no'])){$serial_no = $_SESSION['serial_no'];}else{$serial_no ='';};
    if(isset($_SESSION['ghanacard'])){$ghanacard = $_SESSION['ghanacard'];}else{$ghanacard ='';};
    if(isset($_SESSION['prtinsname'])){$prtinsname = $_SESSION['prtinsname'];}else{$prtinsname ='';};
    if(isset($_SESSION['prtmemberno'])){$prtmemberno = $_SESSION['prtmemberno'];}else{$prtmemberno ='';};
    if(isset($_SESSION['prtexpirydate'])){$prtexpirydate = $_SESSION['prtexpirydate'];}else{$prtexpirydate ='';};
	
	//DATE
		date_default_timezone_set("Africa/Accra");
		$date = date('Y-m-d');

	//AGE
		$ts1 = strtotime($DOB);
		$ts2 = strtotime($date);
		
		$year1 = date('Y', $ts1);
		$year2 = date('Y', $ts2);
		$years = $year2 - $year1;
		
		$month1 = date('m', $ts1);
		$month2 = date('m', $ts2);
		$months = $month2 - $month1;

		if($years > 0)
		{
			$age = ($year2 - $year1).' years';
		}
		else
		{
			$age = ($month2 - $month1).' months';
		};
	//GENDER
		$sql_gender="SELECT * FROM gender WHERE gender_id ='$gender'";
		$result_gender = mysqli_query($con,$sql_gender);
		if(!empty($result_gender) && mysqli_num_rows($result_gender) >0)
		{
			$row_gender = mysqli_fetch_array($result_gender);
			$gender = $row_gender['gender'];
		}
		else
		{
			$gender = 'Not Specified';
		};
	//SPONSOR
			function set_sponsor_list()
			{
				global $con;
				$nhis_led_id = $_SESSION['Schname'];
				$prvt_led_id = $_SESSION['prtinsname'];
				$sponsor_attd = $_SESSION['sponsor'];
				$sponsor_option = "";
				if ($nhis_led_id > 0) {
					$sql="SELECT * FROM ledgers WHERE ledger_id='$nhis_led_id'";
					$result_nhis=mysqli_query($con,$sql);
					while($row_nhis=mysqli_fetch_array($result_nhis))
					{
						$sponsor_option.='<option value = "'.$row_nhis['ledger_id'].'"';
						if ($row_nhis['ledger_id']==$sponsor_attd){$sponsor_option.='selected="selected"';}
						$sponsor_option.='>'.$row_nhis['ledger_desc'].'</option>';
					}
				};

				if ($prvt_led_id > 0) 
				{
					$sql="SELECT * FROM ledgers WHERE ledger_id='$prvt_led_id'";
					$result_prvt=mysqli_query($con,$sql);
					while($row_prvt=mysqli_fetch_array($result_prvt))
					{
						$sponsor_option.='<option value = "'.$row_prvt['ledger_id'].'"';
						if ($row_prvt['ledger_id']==$sponsor_attd){$sponsor_option.='selected="selected"';}
						$sponsor_option.='>'.$row_prvt['ledger_desc'].'</option>';
					}
				};

				$sql="SELECT * FROM ledgers WHERE ledger_id=1";
				$result_cash=mysqli_query($con,$sql);
				while($row_cash=mysqli_fetch_array($result_cash))
				{
					$sponsor_option.='<option value = "'.$row_cash['ledger_id'].'"';
					if ($row_cash['ledger_id']==$sponsor_attd){$sponsor_option.='selected="selected"';}
					$sponsor_option.='>'.$row_cash['ledger_desc'].'</option>';
				}
				return $sponsor_option;
			};

?>
<style type="text/css">
    .scroll-card-body {max-height: 700px;overflow-y: auto;}
    .amt-td {text-align:right;}
    .action-td {text-align:center;}
</style>
<input type='hidden' id='session_date' value="<?php echo $date;?>">
<input type='hidden' id='session_Schname' value="<?php echo $Schname;?>">
<input type='hidden' id='session_nhismemberno' value="<?php echo $nhismemberno;?>">
<input type='hidden' id='session_nhisexpirydate' value="<?php echo $nhisexpirydate;?>">
<input type='hidden' id='session_serial_no' value="<?php echo $serial_no;?>">
<input type='hidden' id='session_ghanacard' value="<?php echo $ghanacard;?>">
<input type='hidden' id='session_prtinsname' value="<?php echo $prtinsname;?>">
<input type='hidden' id='session_prtmemberno' value="<?php echo $prtmemberno;?>">
<input type='hidden' id='session_prtexpirydate' value="<?php echo $prtexpirydate;?>">
<input type='hidden' id='session_attend_state' value="<?php echo $attend_state;?>">
<div class="container-fluid">
    <div class="card shadow md-4">
	        <div class="card-header py-3">
	    		<small>Patient Attendance Details</small>
	    		<h3 class="m-0 font-weight-bold text-primary" id="name"><?php echo $name ?></h3>
	        	<div class="table-responsive no-padding">
		        	<table width="100%" cellpadding="3" cellspacing="3">
			            <tr>
			            	<td width="15%" valign="top" align="center">
				                <?php
								/*if(!$patientInfo->picture){
									$picture = "avatar.png";	
								}else{
									$picture = $patientInfo->picture;
								}*/
								?>
								<img src="/img/patients/patient_image.jpg" class="img-rounded" width="86" height="81">
			                </td>
			                <td>
			                	<table id="attend_patient_table" width="100%">
				                    <tr>
				                    	<td width="20%" class="action-td"><u>Patient No.</u></td>
				                    	<td width="20%" class="action-td"><u>Folder No.</u></td>
				                    	<td width="20%" class="action-td"><u>Age</u></td>
				                    	<td width="20%" class="action-td"><u>Gender</u></td>
				                    </tr>
				                    <tr>
				            			<td class="action-td"><?php echo $patient_id;?></td>
				            			<td class="action-td"><?php echo $folderno;?></td>
				            			<td class="action-td"><?php echo $age;?></td>
				            			<td class="action-td"><?php echo $gender?></td>
				            		</tr>
			                    </table>
			                </td>
			            </tr>
		            </table>
		        </div>
	        </div>
	    <form id="new_attend_form" action="" method="POST">
	        <div class="card-body">
	        	<div id="attend_create_msg"></div>

				<div class="form-row">
					<div class="col-md-12 mb-12">
			    		<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="type_attd"><small><u>Type</u></small></label>
								<select class="form-control bg-light" name="type_attd" id="type_attd" required> 
							    	<?php
							        	$type_attd = $_SESSION['type_attd'];
							            if($type_attd == 'Regular')
							            {
							            	echo '<option value="0">Please Select</option>
											<option value="Regular" selected="selected">Regular</option>
											<option value="Walk-In">Walk-In</option>';
							            }
							            else
							            {
							            	echo '<option value="0" selected="selected">Please Select</option>
											<option value="Regular">Regular</option>
											<option value="Walk-In">Walk-In</option>';
							            };
							        ?>
							    </select>
							</div>
							<div class="col-md-3 mb-3">
								<label for="clinic_attd"><small><u>Clinic</u></small></label>
								<select class="form-control bg-light" name="clinic_attd" id="clinic_attd" required> 
							    	<option value="0">Please Select</option>
							        <?php
							        	$sql_clinic = "SELECT * FROM clinics ORDER BY clinic_desc ASC";
										$result_clinic = mysqli_query($con,$sql_clinic);
							            while($row_clinic = mysqli_fetch_array($result_clinic))
							            {
							            	echo '<option value = "'.$row_clinic['clinic_id'].'">'.$row_clinic['clinic_desc'].'</option>';
							            };
							        ?>
							    </select>
							</div>
							<div class="col-md-3 mb-3">
								<label for="doctor_attd">Doctor</label>
								<select class="form-control bg-light" name="doctor_attd" id="doctor_attd" required> 
							    	<option value="0">Please Select</option>
							        <?php
							        	$sql_doctor = "SELECT * FROM users WHERE user_type_id=6 ORDER BY first_name ASC";
										$result_doctor = mysqli_query($con,$sql_doctor);
							            while($row_doctor = mysqli_fetch_array($result_doctor))
							            {
							            	echo '<option value = "'.$row_doctor['id'].'">'.$row_doctor['first_name'].'</option>';
							            };
							        ?>
							    </select>

								<input type="hidden" class="form-control" name="session_company_id" id="session_company_id" value="<?php echo $company_id;?>">
								<input type="hidden" class="form-control" name="attd_service_id" id="attd_service_id">
								<input type="hidden" class="form-control" name="attd_service_amt_cash" id="attd_service_amt_cash">
								<input type="hidden" class="form-control" name="attd_service_amt_prvt" id="attd_service_amt_prvt">
								<input type="hidden" class="form-control" name="attd_service_amt_nhis" id="attd_service_amt_nhis">
								<input type="hidden" class="form-control" name="attd_service_gdrg" id="attd_service_gdrg" value="">
								<input type="hidden" class="form-control" name="attend_id" id="attend_id" value="<?php //echo $vn;?>">
								<input type="hidden" class="form-control" name="patient_id_attend" id="patient_id_attend" value="<?php echo $patient_id;?>">
								<input type="hidden" class="form-control" name="patient_folderno" id="patient_folderno" value="<?php echo $folderno;?>">
								<input type="hidden" class="form-control" name="patient_name" id="patient_name" value="<?php echo $name;?>">
								<input type="hidden" class="form-control" name="patient_gender" id="patient_gender" value="<?php echo $gender;?>">
								<input type="hidden" class="form-control" name="patient_age" id="patient_age" value="<?php echo $age;?>">
							</div>
							<div class="col-md-2 mb-2">
								<label for="state_attd"><small><u>Status</u></small></label>
								<select class="form-control bg-light" name="state_attd" id="state_attd" required> 
							    	<?php
							        	$state_attd = $_SESSION['state_attd'];
							            if($state_attd == 'New')
							            {
							            	echo '<option value="0">Please Select</option>
											<option value = "New" selected="selected">New</option>
											<option value="Old">Old</option>';
							            }
							            else
							            {
							            	echo '<option value="0">Please Select</option>
											<option value = "New">New</option>
											<option value="Old" selected="selected">Old</option>';
							            };
							        ?>
							    </select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="typeofservice_attd"><small><u>Type Of Service</u></small></label>
								<select class="form-control bg-light" name="typeofservice_attd" id="typeofservice_attd" required> 
								    <option value="0">Please Select</option>
							        <?php
							        	$sql_tos="SELECT * FROM type_of_service ORDER BY description DESC";
										$result_tos = mysqli_query($con,$sql_tos);
							            while($row_tos = mysqli_fetch_array($result_tos))
							            {
							            	if ($row_tos['tos_id'] == 1) 
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
						</div>
						<div class="form-row">
							<div class="col-md-4 mb-4">
								<label for="dateofadmission_attd"><small><u>Date Of Admission</u></small></label>
								<input type="date" class="form-control bg-light" name="dateofadmission_attd" id="dateofadmission_attd" value="<?php echo $date;?>">
							</div>
							<div class="col-md-4 mb-4">
								<label for="dateofdischarge_attd"><small><u>Date Of Discharge</u></small></label>
								<input type="date" class="form-control bg-light" name="dateofdischarge_attd" id="dateofdischarge_attd" value="<?php echo $date;?>">
							</div>
							<div class="col-md-4 mb-4">
								<label for="outcome"><small><u>Outcome</u></small></label>
								<select class="form-control bg-light" name="outcome" id="outcome" required> 
							    	<option value="0">-Please Select-</option>
							    	<option value = "discharged" selected = "selected">Discharged</option>
							    	<option value="died">Died</option>
							    	<option value="absconded">Absconded</option>
							    	<option value="discharged_against_medical_advice">Discharged Against Medical Advice</option>
							    	<option value="referred_out">Referred Out</option>
							    	<option value="transferred_out">Transferred Out</option>
							    	<option value="on_admission">On-Admission</option>
							    </select>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12" id="attend_sponsor_table_div">
					    		<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="attend_sponsor_table">
								    <tr>
								        <th width="30%">Sponsors</th>
								    </tr>
									<?php
										if($scheme_id > 0)
										{
											echo '<tr id="1">
												<td>
													<div class="form-row">
														<div class="col-md-3 mb-3">
															<label for="attend_sponsor_id"><small><u>Sponsor Name</u></small></label>
															<select class="form-control bg-light attend_sponsor_id" name="attend_sponsor_id[]" id="attend_sponsor_id1" data-id="1" style="border-width:0px" hidden="true"> 
																<option value="0">Please Select</option>';
																
																	$sql_sponor = "SELECT * FROM ledgers WHERE tb_5 = 1 ORDER BY ledger_desc"; 
																	$result_sponor = mysqli_query($con,$sql_sponor);
																	while($row_sponor = mysqli_fetch_array($result_sponor))
																	{
																		if ($row_sponor['ledger_id'] == 1) 
																		{
																			echo '<option value ="'.$row_sponor['ledger_id'].'" selected="selected">'.$row_sponor['ledger_desc'].'</option>';
																		} 
																		else 
																		{
																			echo '<option value ="'.$row_sponor['ledger_id'].'">'.$row_sponor['ledger_desc'].'</option>';
																		};
																	};
																
															echo '</select>
															<select class="form-control bg-light attend_sponsor_id" name="attend_sponsor_id[]" id="attend_sponsor_id1D" data-id="1" style="border-width:0px" disabled ="true"> 
																<option value="0">Please Select</option>';
																
																	$sql_sponor = "SELECT * FROM ledgers WHERE tb_5 = 1 ORDER BY ledger_desc"; 
																	$result_sponor = mysqli_query($con,$sql_sponor);
																	while($row_sponor = mysqli_fetch_array($result_sponor))
																	{
																		if ($row_sponor['ledger_id'] == 1) {
																			echo '<option value ="'.$row_sponor['ledger_id'].'" selected="selected">'.$row_sponor['ledger_desc'].'</option>';
																		} 
																		else 
																		{
																			echo '<option value ="'.$row_sponor['ledger_id'].'">'.$row_sponor['ledger_desc'].'</option>';
																		};
																	};
																
															echo '</select>
														</div>
														<div class="col-md-2 mb-2">
															<label for="attend_sponsor_member_no"><small><u>Membership No</u></small></label>
															<input type="text" name="attend_sponsor_member_no[]" class="form-control bg-light attend_sponsor_member_no" id="attend_sponsor_member_no1" data-id="1" style="border-width:0px" >
														</div>
														<div class="col-md-2 mb-2">
															<div id="ghanacard_div1"  style="display:none;">
																<label for="ghanacard_attd"><small><u>Ghana Card</u></small></label>
																<input type="text" class="form-control bg-light" name="ghanacard_attd[]" id="ghanacard_attd1">
															</div>
															<div id="ins_category_div1">
																<label for="attend_sponsor_category"><small><u>Category</u></small></label>
																<input type="text" name="attend_sponsor_category[]" class="form-control bg-light attend_sponsor_category" id="attend_sponsor_category1" data-id="1" style="border-width:0px" >
															</div>
														</div>
														<div class="col-md-2 mb-2">
															<label for="nhisexpirydate_attd"><small><u>Expiry Date</u></small></label>
															<input type="date" name="attend_sponsor_expiry_date[]" class="form-control bg-light" id="attend_sponsor_expiry_date1" style="border-width:0px">
														</div>
														<div class="col-md-1 mb-1">
															<label for="nhisexpirydate_attd"><small><u>Principal</u></small></label>
															<div id="principal_select_div1">
																<select class="form-control bg-light attend_sponsor_principal" name="attend_sponsor_principal[]" id="attend_sponsor_principal1" data-id="1" style="border-width:0px"> 
																	<option value="0">Please Select</option>
																	<option value ="Yes">Yes</option>
																	<option value ="No" selected="selected">No</option>
																</select>
															</div>
														</div>
														<div class="col-md-2 mb-2">
															<div id="serial_no_div1" style="display:none;">
																<label for="serial_no"><small><u>Serial no</u></small></label>
																<input type="text" class="form-control bg-light" name="serial_no[]" id="serial_no1">
															</div>
															<div id="relation_div1">
																<label for="attend_sponsor_relation"><small><u>Relation Type</u></small></label>
																<input type="text" class="form-control bg-light" name="attend_sponsor_relation[]" id="attend_sponsor_relation1">
															</div>
														</div>
													</div>
													<div class="form-row" id="ins_detail_one1"  style="display:none;">
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="ASUR" id="ASUR1" name="specialty_attd[]">
															<label class="form-check-label" for="ASUR">
																ASUR
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="DENT" id="DENT1" name="specialty_attd[]">
															<label class="form-check-label" for="DENT">
																DENT
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="ENTH" id="ENTH1" name="specialty_attd[]">
															<label class="form-check-label" for="ENTH">
																ENTH
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="MEDI" id="MEDI1" name="specialty_attd[]">
															<label class="form-check-label" for="MEDI">
																MEDI
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="OBGY" id="OBGY1" name="specialty_attd[]">
															<label class="form-check-label" for="OBGY">
																OBGY
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="OPDC" id="OPDC1" name="specialty_attd[]">
															<label class="form-check-label" for="OPDC">
																OPDC
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="OPHT" id="OPHT1" name="specialty_attd[]">
															<label class="form-check-label" for="OPHT">
																OPHT
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="ORTH" id="ORTH1" name="specialty_attd[]">
															<label class="form-check-label" for="ORTH">
																ORTH
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="PAED" id="PAED1" name="specialty_attd[]">
															<label class="form-check-label" for="PAED">
																PAED
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="PSUR" id="PSUR1" name="specialty_attd[]">
															<label class="form-check-label" for="PSUR">
																PSUR
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="RSUR" id="RSUR1" name="specialty_attd[]">
															<label class="form-check-label" for="RSUR">
																RSUR
															</label>
															</div>
														</div>
													</div>
													<div class="form-row" id="ins_detail_two1" style="display:none;">
														<div class="col-md-3 mb-3">
															<label for="type_of_attendnace"><small><u>Type Of Attendance</u></small></label>
															<select class="form-control bg-light" name="type_of_attendnace[]" id="type_of_attendnace1"> 
																<option value="0">-Please Select-</option>
																<option value="chronic_follow_up">Chronic Follow-up</option>
																<option value="emergency_acute_episode">Emergency/Acute Episode</option>
																<option value="antenatal">Antenatal Care</option>
															</select>
														</div>
														<div class="col-md-2 mb-2">
															<label for="date_of_claim"><small><u>Date of Claim</u></small></label>
															<input type="date" class="form-control bg-light" name="date_of_claim[]" id="date_of_claim1">
														</div>
														<div class="col-md-1 mb-1">
															<label for="claim_no"><small><u>Claim No</u></small></label>
															<input type="text" class="form-control" name="claim_no[]" id="claim_no1">
														</div>
														<div class="col-md-2 mb-2">
															<label for="pharmacy"><small><u>Pharmacy</u></small></label>
															<select class="form-control bg-light" name="pharmacy[]" id="pharmacy1"> 
																<option value="0">Please Select</option>
																<option value="pharmacy">Pharmacy</option>
															</select>
														</div>
														<div class="col-md-2 mb-2">
															<label for="type_of_service_2"><small><u>Type Of Service (b)</u></small></label>
															<select class="form-control bg-light" name="type_of_service_2[]" id="type_of_service_21"> 
																<option value="0">Please Select</option>
																<option value="all_inclusive">All Inclusive</option>
																<option value="unbundled">Unbundled</option>
															</select>
														</div>
														<div class="col-md-1 mb-1">
															<label for="nhisccc"><small><u>CCC</u></small></label>
															<input type="text" class="form-control bg-light" name="nhisccc[]" id="nhisccc1">
														</div>
														<div class="col-md-1 mb-1">
															<label for="spell"><small><u>Spell</u></small></label>
															<input type="text" class="form-control bg-light" name="spell[]" id="spell1">
														</div>
													</div>
													<div class="clearfix">
													</div>
													<hr class="d-none d-md-block">
												</td>
											</tr>
											<tr id="2">
												<td>
													<div class="form-row">
														<div class="col-md-3 mb-3">
															<label for="attend_sponsor_id"><small><u>Sponsor Name</u></small></label>
															<select class="form-control bg-light attend_sponsor_id" name="attend_sponsor_id[]" id="attend_sponsor_id2" data-id="2" style="border-width:0px"> 
																<option value="0">Please Select</option>';
																
																	$sql_sponor = "SELECT * FROM ledgers WHERE (tb_5 = 1 OR tb_5 = 12 OR tb_5 = 13) ORDER BY ledger_desc"; 
																	$result_sponor = mysqli_query($con,$sql_sponor);
																	while($row_sponor = mysqli_fetch_array($result_sponor))
																	{
																		if($row_sponor['ledger_id'] == $_SESSION['scheme_id'])
																		{
																			echo '<option value ="'.$row_sponor['ledger_id'].'" selected="selected">'.$row_sponor['ledger_desc'].'</option>';
																		}
																		else
																		{
																			echo '<option value ="'.$row_sponor['ledger_id'].'">'.$row_sponor['ledger_desc'].'</option>';
																		}
																	};
																
															echo '</select>
														</div>
														<div class="col-md-2 mb-2">
															<label for="attend_sponsor_member_no"><small><u>Membership No</u></small></label>
															<input type="text" name="attend_sponsor_member_no[]" class="form-control bg-light attend_sponsor_member_no" id="attend_sponsor_member_no2" data-id="2" style="border-width:0px" value="'.$nhismemberno.'">
														</div>
														<div class="col-md-2 mb-2">
															<div id="ghanacard_div2"  style="display:none;">
																<label for="ghanacard_attd"><small><u>Ghana Card</u></small></label>
																<input type="text" class="form-control bg-light" name="ghanacard_attd[]" id="ghanacard_attd2">
															</div>
															<div id="ins_category_div2">
																<label for="attend_sponsor_category"><small><u>Category</u></small></label>
																<input type="text" name="attend_sponsor_category[]" class="form-control bg-light attend_sponsor_category" id="attend_sponsor_category2" data-id="2" style="border-width:0px" >
															</div>
														</div>
														<div class="col-md-2 mb-2">
															<label for="nhisexpirydate_attd"><small><u>Expiry Date</u></small></label>
															<input type="date" name="attend_sponsor_expiry_date[]" class="form-control bg-light" id="attend_sponsor_expiry_date2" style="border-width:0px">
														</div>
														<div class="col-md-1 mb-1">
															<label for="nhisexpirydate_attd"><small><u>Principal</u></small></label>
															<div id="principal_select_div2">
																<select class="form-control bg-light attend_sponsor_principal" name="attend_sponsor_principal[]" id="attend_sponsor_principal2" data-id="2" style="border-width:0px"> 
																	<option value="0">Please Select</option>
																	<option value ="Yes" selected="selected">Yes</option>
																	<option value ="No">No</option>
																</select>
															</div>
														</div>
														<div class="col-md-2 mb-2">
															<div id="serial_no_div2" style="display:none;">
																<label for="serial_no"><small><u>Serial no</u></small></label>
																<input type="text" class="form-control bg-light" name="serial_no[]" id="serial_no2">
															</div>
															<div id="relation_div2">
																<label for="attend_sponsor_relation"><small><u>Relation Type</u></small></label>
																<input type="text" class="form-control bg-light" name="attend_sponsor_relation[]" id="attend_sponsor_relation2">
															</div>
														</div>
													</div>
													<div class="form-row" id="ins_detail_one2"  style="display:none;">
														<label for="specialty_attd"><small><u>Specialty Code</u></small></label>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="ASUR" id="ASUR2" name="specialty_attd[]">
															<label class="form-check-label" for="ASUR">
																ASUR
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="DENT" id="DENT2" name="specialty_attd[]">
															<label class="form-check-label" for="DENT">
																DENT
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="ENTH" id="ENTH2" name="specialty_attd[]">
															<label class="form-check-label" for="ENTH">
																ENTH
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="MEDI" id="MEDI2" name="specialty_attd[]">
															<label class="form-check-label" for="MEDI">
																MEDI
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="OBGY" id="OBGY2" name="specialty_attd[]">
															<label class="form-check-label" for="OBGY">
																OBGY
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="OPDC" id="OPDC2" name="specialty_attd[]">
															<label class="form-check-label" for="OPDC">
																OPDC
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="OPHT" id="OPHT2" name="specialty_attd[]">
															<label class="form-check-label" for="OPHT">
																OPHT
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="ORTH" id="ORTH2" name="specialty_attd[]">
															<label class="form-check-label" for="ORTH">
																ORTH
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="PAED" id="PAED2" name="specialty_attd[]">
															<label class="form-check-label" for="PAED">
																PAED
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="PSUR" id="PSUR2" name="specialty_attd[]">
															<label class="form-check-label" for="PSUR">
																PSUR
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="RSUR" id="RSUR2" name="specialty_attd[]">
															<label class="form-check-label" for="RSUR">
																RSUR
															</label>
															</div>
														</div>
													</div>
													<hr class="d-none d-md-block">
													<div class="form-row" id="ins_detail_two2" style="display:none;">
														<div class="col-md-3 mb-3">
															<label for="type_of_attendnace"><small><u>Type Of Attendance</u></small></label>
															<select class="form-control bg-light" name="type_of_attendnace[]" id="type_of_attendnace2"> 
																<option value="0">-Please Select-</option>
																<option value="chronic_follow_up">Chronic Follow-up</option>
																<option value="emergency_acute_episode">Emergency/Acute Episode</option>
																<option value="antenatal">Antenatal Care</option>
																<option value="postnatal">Postnatal Care</option>
															</select>
														</div>
														<div class="col-md-2 mb-2">
															<label for="date_of_claim"><small><u>Date of Claim</u></small></label>
															<input type="date" class="form-control bg-light" name="date_of_claim[]" id="date_of_claim2">
														</div>
														<div class="col-md-1 mb-1">
															<label for="claim_no"><small><u>Claim No</u></small></label>
															<input type="text" class="form-control" name="claim_no[]" id="claim_no2">
														</div>
														<div class="col-md-2 mb-2">
															<label for="pharmacy"><small><u>Pharmacy</u></small></label>
															<select class="form-control bg-light" name="pharmacy[]" id="pharmacy2"> 
																<option value="0">Please Select</option>
																<option value="pharmacy">Pharmacy</option>
															</select>
														</div>
														<div class="col-md-2 mb-2">
															<label for="type_of_service_2"><small><u>Type Of Service (b)</u></small></label>
															<select class="form-control bg-light" name="type_of_service_2[]" id="type_of_service_22"> 
																<option value="0">Please Select</option>
																<option value="all_inclusive">All Inclusive</option>
																<option value="unbundled">Unbundled</option>
															</select>
														</div>
														<div class="col-md-1 mb-1">
															<label for="nhisccc"><small><u>CCC</u></small></label>
															<input type="text" class="form-control bg-light" name="nhisccc[]" id="nhisccc2">
														</div>
														<div class="col-md-1 mb-1">
															<label for="spell"><small><u>Spell</u></small></label>
															<input type="text" class="form-control bg-light" name="spell[]" id="spell2">
														</div>
													</div>
													<div class="clearfix">
													</div>
													<a href="#" id="delete_attend_sponsor" data-id="2"><i class="fa fa-trash fa-sm"></i></a>
													<hr class="d-none d-md-block">
												</td>
											</tr>';
										}
										else
										{
											echo '<tr id="1">
												<td>
													<div class="form-row">
														<div class="col-md-3 mb-3">
															<label for="attend_sponsor_id"><small><u>Sponsor Name</u></small></label>
															<select class="form-control bg-light attend_sponsor_id" name="attend_sponsor_id[]" id="attend_sponsor_id1" data-id="1" style="border-width:0px" hidden="true"> 
																<option value="0">Please Select</option>';
																
																	$sql_sponor = "SELECT * FROM ledgers WHERE tb_5 = 1 ORDER BY ledger_desc"; 
																	$result_sponor = mysqli_query($con,$sql_sponor);
																	while($row_sponor = mysqli_fetch_array($result_sponor))
																	{
																		if ($row_sponor['ledger_id'] == 1) 
																		{
																			echo '<option value ="'.$row_sponor['ledger_id'].'" selected="selected">'.$row_sponor['ledger_desc'].'</option>';
																		} 
																		else 
																		{
																			echo '<option value ="'.$row_sponor['ledger_id'].'">'.$row_sponor['ledger_desc'].'</option>';
																		};
																	};
																
															echo '</select>
															<select class="form-control bg-light attend_sponsor_id" name="attend_sponsor_id[]" id="attend_sponsor_id1D" data-id="1" style="border-width:0px" disabled ="true"> 
																<option value="0">Please Select</option>';
																
																	$sql_sponor = "SELECT * FROM ledgers WHERE tb_5 = 1 ORDER BY ledger_desc"; 
																	$result_sponor = mysqli_query($con,$sql_sponor);
																	while($row_sponor = mysqli_fetch_array($result_sponor))
																	{
																		if ($row_sponor['ledger_id'] == 1) {
																			echo '<option value ="'.$row_sponor['ledger_id'].'" selected="selected">'.$row_sponor['ledger_desc'].'</option>';
																		} 
																		else 
																		{
																			echo '<option value ="'.$row_sponor['ledger_id'].'">'.$row_sponor['ledger_desc'].'</option>';
																		};
																	};
																
															echo '</select>
														</div>
														<div class="col-md-2 mb-2">
															<label for="attend_sponsor_member_no"><small><u>Membership No</u></small></label>
															<input type="text" name="attend_sponsor_member_no[]" class="form-control bg-light attend_sponsor_member_no" id="attend_sponsor_member_no1" data-id="1" style="border-width:0px" >
														</div>
														<div class="col-md-2 mb-2">
															<div id="ghanacard_div1"  style="display:none;">
																<label for="ghanacard_attd"><small><u>Ghana Card</u></small></label>
																<input type="text" class="form-control bg-light" name="ghanacard_attd[]" id="ghanacard_attd1">
															</div>
															<div id="ins_category_div1">
																<label for="attend_sponsor_category"><small><u>Category</u></small></label>
																<input type="text" name="attend_sponsor_category[]" class="form-control bg-light attend_sponsor_category" id="attend_sponsor_category1" data-id="1" style="border-width:0px" >
															</div>
														</div>
														<div class="col-md-2 mb-2">
															<label for="nhisexpirydate_attd"><small><u>Expiry Date</u></small></label>
															<input type="date" name="attend_sponsor_expiry_date[]" class="form-control bg-light" id="attend_sponsor_expiry_date1" style="border-width:0px">
														</div>
														<div class="col-md-1 mb-1">
															<label for="nhisexpirydate_attd"><small><u>Principal</u></small></label>
															<div id="principal_select_div1">
																<select class="form-control bg-light attend_sponsor_principal" name="attend_sponsor_principal[]" id="attend_sponsor_principal1" data-id="1" style="border-width:0px"> 
																	<option value="0">Please Select</option>
																	<option value ="Yes" selected="selected">Yes</option>
																	<option value ="No">No</option>
																</select>
															</div>
														</div>
														<div class="col-md-2 mb-2">
															<div id="serial_no_div1" style="display:none;">
																<label for="serial_no"><small><u>Serial no</u></small></label>
																<input type="text" class="form-control bg-light" name="serial_no[]" id="serial_no1">
															</div>
															<div id="relation_div1">
																<label for="attend_sponsor_relation"><small><u>Relation Type</u></small></label>
																<input type="text" class="form-control bg-light" name="attend_sponsor_relation[]" id="attend_sponsor_relation1">
															</div>
														</div>
													</div>
													<div class="form-row" id="ins_detail_one1"  style="display:none;">
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="ASUR" id="ASUR1" name="specialty_attd[]">
															<label class="form-check-label" for="ASUR">
																ASUR
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="DENT" id="DENT1" name="specialty_attd[]">
															<label class="form-check-label" for="DENT">
																DENT
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="ENTH" id="ENTH1" name="specialty_attd[]">
															<label class="form-check-label" for="ENTH">
																ENTH
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="MEDI" id="MEDI1" name="specialty_attd[]">
															<label class="form-check-label" for="MEDI">
																MEDI
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="OBGY" id="OBGY1" name="specialty_attd[]">
															<label class="form-check-label" for="OBGY">
																OBGY
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="OPDC" id="OPDC1" name="specialty_attd[]">
															<label class="form-check-label" for="OPDC">
																OPDC
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="OPHT" id="OPHT1" name="specialty_attd[]">
															<label class="form-check-label" for="OPHT">
																OPHT
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="ORTH" id="ORTH1" name="specialty_attd[]">
															<label class="form-check-label" for="ORTH">
																ORTH
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="PAED" id="PAED1" name="specialty_attd[]">
															<label class="form-check-label" for="PAED">
																PAED
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="PSUR" id="PSUR1" name="specialty_attd[]">
															<label class="form-check-label" for="PSUR">
																PSUR
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="RSUR" id="RSUR1" name="specialty_attd[]">
															<label class="form-check-label" for="RSUR">
																RSUR
															</label>
															</div>
														</div>
													</div>
													<div class="form-row" id="ins_detail_two1" style="display:none;">
														<div class="col-md-3 mb-3">
															<label for="type_of_attendnace"><small><u>Type Of Attendance</u></small></label>
															<select class="form-control bg-light" name="type_of_attendnace[]" id="type_of_attendnace1"> 
																<option value="0">-Please Select-</option>
																<option value="chronic_follow_up">Chronic Follow-up</option>
																<option value="emergency_acute_episode">Emergency/Acute Episode</option>
																<option value="antenatal">Antenatal Care</option>
															</select>
														</div>
														<div class="col-md-2 mb-2">
															<label for="date_of_claim"><small><u>Date of Claim</u></small></label>
															<input type="date" class="form-control bg-light" name="date_of_claim[]" id="date_of_claim1">
														</div>
														<div class="col-md-1 mb-1">
															<label for="claim_no"><small><u>Claim No</u></small></label>
															<input type="text" class="form-control" name="claim_no[]" id="claim_no1">
														</div>
														<div class="col-md-2 mb-2">
															<label for="pharmacy"><small><u>Pharmacy</u></small></label>
															<select class="form-control bg-light" name="pharmacy[]" id="pharmacy1"> 
																<option value="0">Please Select</option>
																<option value="pharmacy">Pharmacy</option>
															</select>
														</div>
														<div class="col-md-2 mb-2">
															<label for="type_of_service_2"><small><u>Type Of Service (b)</u></small></label>
															<select class="form-control bg-light" name="type_of_service_2[]" id="type_of_service_21"> 
																<option value="0">Please Select</option>
																<option value="all_inclusive">All Inclusive</option>
																<option value="unbundled">Unbundled</option>
															</select>
														</div>
														<div class="col-md-1 mb-1">
															<label for="nhisccc"><small><u>CCC</u></small></label>
															<input type="text" class="form-control bg-light" name="nhisccc[]" id="nhisccc1">
														</div>
														<div class="col-md-1 mb-1">
															<label for="spell"><small><u>Spell</u></small></label>
															<input type="text" class="form-control bg-light" name="spell[]" id="spell1">
														</div>
													</div>
													<div class="clearfix">
													</div>
													<hr class="d-none d-md-block">
												</td>
											</tr>
											<tr id="2">
												<td>
													<div class="form-row">
														<div class="col-md-3 mb-3">
															<label for="attend_sponsor_id"><small><u>Sponsor Name</u></small></label>
															<select class="form-control bg-light attend_sponsor_id" name="attend_sponsor_id[]" id="attend_sponsor_id2" data-id="2" style="border-width:0px"> 
																<option value="0">Please Select</option>';
																
																	$sql_sponor = "SELECT * FROM ledgers WHERE (tb_5 = 1 OR tb_5 = 12 OR tb_5 = 13) ORDER BY ledger_desc"; 
																	$result_sponor = mysqli_query($con,$sql_sponor);
																	while($row_sponor = mysqli_fetch_array($result_sponor))
																	{
																		echo '<option value ="'.$row_sponor['ledger_id'].'">'.$row_sponor['ledger_desc'].'</option>';
																	};
																
															echo '</select>
														</div>
														<div class="col-md-2 mb-2">
															<label for="attend_sponsor_member_no"><small><u>Membership No</u></small></label>
															<input type="text" name="attend_sponsor_member_no[]" class="form-control bg-light attend_sponsor_member_no" id="attend_sponsor_member_no2" data-id="2" style="border-width:0px" >
														</div>
														<div class="col-md-2 mb-2">
															<div id="ghanacard_div2"  style="display:none;">
																<label for="ghanacard_attd"><small><u>Ghana Card</u></small></label>
																<input type="text" class="form-control bg-light" name="ghanacard_attd[]" id="ghanacard_attd2">
															</div>
															<div id="ins_category_div2">
																<label for="attend_sponsor_category"><small><u>Category</u></small></label>
																<input type="text" name="attend_sponsor_category[]" class="form-control bg-light attend_sponsor_category" id="attend_sponsor_category2" data-id="2" style="border-width:0px" >
															</div>
														</div>
														<div class="col-md-2 mb-2">
															<label for="nhisexpirydate_attd"><small><u>Expiry Date</u></small></label>
															<input type="date" name="attend_sponsor_expiry_date[]" class="form-control bg-light" id="attend_sponsor_expiry_date2" style="border-width:0px">
														</div>
														<div class="col-md-1 mb-1">
															<label for="nhisexpirydate_attd"><small><u>Principal</u></small></label>
															<div id="principal_select_div2">
																<select class="form-control bg-light attend_sponsor_principal" name="attend_sponsor_principal[]" id="attend_sponsor_principal2" data-id="2" style="border-width:0px"> 
																	<option value="0">Please Select</option>
																	<option value ="Yes">Yes</option>
																	<option value ="No">No</option>
																</select>
															</div>
														</div>
														<div class="col-md-2 mb-2">
															<div id="serial_no_div2" style="display:none;">
																<label for="serial_no"><small><u>Serial no</u></small></label>
																<input type="text" class="form-control bg-light" name="serial_no[]" id="serial_no2">
															</div>
															<div id="relation_div2">
																<label for="attend_sponsor_relation"><small><u>Relation Type</u></small></label>
																<input type="text" class="form-control bg-light" name="attend_sponsor_relation[]" id="attend_sponsor_relation2">
															</div>
														</div>
													</div>
													<div class="form-row" id="ins_detail_one2"  style="display:none;">
														<label for="specialty_attd"><small><u>Specialty Code</u></small></label>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="ASUR" id="ASUR2" name="specialty_attd[]">
															<label class="form-check-label" for="ASUR">
																ASUR
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="DENT" id="DENT2" name="specialty_attd[]">
															<label class="form-check-label" for="DENT">
																DENT
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="ENTH" id="ENTH2" name="specialty_attd[]">
															<label class="form-check-label" for="ENTH">
																ENTH
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="MEDI" id="MEDI2" name="specialty_attd[]">
															<label class="form-check-label" for="MEDI">
																MEDI
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="OBGY" id="OBGY2" name="specialty_attd[]">
															<label class="form-check-label" for="OBGY">
																OBGY
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="OPDC" id="OPDC2" name="specialty_attd[]">
															<label class="form-check-label" for="OPDC">
																OPDC
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="OPHT" id="OPHT2" name="specialty_attd[]">
															<label class="form-check-label" for="OPHT">
																OPHT
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="ORTH" id="ORTH2" name="specialty_attd[]">
															<label class="form-check-label" for="ORTH">
																ORTH
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="PAED" id="PAED2" name="specialty_attd[]">
															<label class="form-check-label" for="PAED">
																PAED
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="PSUR" id="PSUR2" name="specialty_attd[]">
															<label class="form-check-label" for="PSUR">
																PSUR
															</label>
															</div>
														</div>
														<div class="col-md-1 mb-1">
															<div class="form-check">
															<input class="form-check-input" type="checkbox" value="RSUR" id="RSUR2" name="specialty_attd[]">
															<label class="form-check-label" for="RSUR">
																RSUR
															</label>
															</div>
														</div>
													</div>
													<hr class="d-none d-md-block">
													<div class="form-row" id="ins_detail_two2" style="display:none;">
														<div class="col-md-3 mb-3">
															<label for="type_of_attendnace"><small><u>Type Of Attendance</u></small></label>
															<select class="form-control bg-light" name="type_of_attendnace[]" id="type_of_attendnace2"> 
																<option value="0">-Please Select-</option>
																<option value="chronic_follow_up">Chronic Follow-up</option>
																<option value="emergency_acute_episode">Emergency/Acute Episode</option>
																<option value="antenatal">Antenatal Care</option>
																<option value="postnatal">Postnatal Care</option>
															</select>
														</div>
														<div class="col-md-2 mb-2">
															<label for="date_of_claim"><small><u>Date of Claim</u></small></label>
															<input type="date" class="form-control bg-light" name="date_of_claim[]" id="date_of_claim2">
														</div>
														<div class="col-md-1 mb-1">
															<label for="claim_no"><small><u>Claim No</u></small></label>
															<input type="text" class="form-control" name="claim_no[]" id="claim_no2">
														</div>
														<div class="col-md-2 mb-2">
															<label for="pharmacy"><small><u>Pharmacy</u></small></label>
															<select class="form-control bg-light" name="pharmacy[]" id="pharmacy2"> 
																<option value="0">Please Select</option>
																<option value="pharmacy">Pharmacy</option>
															</select>
														</div>
														<div class="col-md-2 mb-2">
															<label for="type_of_service_2"><small><u>Type Of Service (b)</u></small></label>
															<select class="form-control bg-light" name="type_of_service_2[]" id="type_of_service_22"> 
																<option value="0">Please Select</option>
																<option value="all_inclusive">All Inclusive</option>
																<option value="unbundled">Unbundled</option>
															</select>
														</div>
														<div class="col-md-1 mb-1">
															<label for="nhisccc"><small><u>CCC</u></small></label>
															<input type="text" class="form-control bg-light" name="nhisccc[]" id="nhisccc2">
														</div>
														<div class="col-md-1 mb-1">
															<label for="spell"><small><u>Spell</u></small></label>
															<input type="text" class="form-control bg-light" name="spell[]" id="spell2">
														</div>
													</div>
													<div class="clearfix">
													</div>
													<a href="#" id="delete_attend_sponsor" data-id="2"><i class="fa fa-trash fa-sm"></i></a>
													<hr class="d-none d-md-block">
												</td>
											</tr>';
										};
									?>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

		    <div class="card-footer">
		    	<div class="modal-footer">
		        	<button type="submit" name="attend_save_btn_attd" id="attend_save_btn_attd" class="btn btn-primary">Save</button>
					<a name="attend_cancel_btn_attd" id="attend_cancel_btn_attd" class="btn btn-danger text-white">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/attend_sponsor_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>