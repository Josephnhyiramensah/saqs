<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_consulting.php');
   
		$attend_id = $_SESSION['attend_id'];
		$patient_id = $_SESSION['patient_id'];
		$folderno = $_SESSION['folderno'];
		$name = $_SESSION['name'];
		$age = $_SESSION['age'];
		$gender = $_SESSION['gender'];
		$typeofservice_attd = $_SESSION['typeofservice_attd'];

		$sql_gender="SELECT * FROM gender WHERE gender_id ='$gender'";
		$result_gender=mysqli_query($con,$sql_gender);
        $row_gender = mysqli_fetch_array($result_gender);
        $gender = $row_gender['gender'];
        
        $sql_attend = "SELECT * FROM attendance WHERE attend_id ='$attend_id'";
		$result_attend = mysqli_query($con,$sql_attend);
        $row_attend = mysqli_fetch_array($result_attend);

        function set_sponsor_list(){
        	global $con;
        	$nhis_led_id = $_SESSION['nhis_led_id'];
        	$prvt_led_id = $_SESSION['prvt_led_id'];
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
        	if ($prvt_led_id > 0) {
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
<input type='hidden' id='session_search_from' value="<?php echo $_SESSION['search_from'];?>">
<input type='hidden' id='session_search_to' value="<?php echo $_SESSION['search_to'];?>">
<input type='hidden' id='session_page' value="<?php echo $_SESSION['page'];?>">
<input type='hidden' id='session_remember_state' value="<?php echo $_SESSION['remember_state'];?>">
<input type='hidden' id='session_preg_id' value="<?php echo $_SESSION['preg_id'];?>">
<input type='hidden' id='session_attend_id' value="<?php echo $_SESSION['attend_id'];?>">
<input type='hidden' id='session_patient_id' value="<?php echo $_SESSION['patient_id'];?>">
<input type='hidden' id='session_clinic' value="<?php echo $_SESSION['clinic'];?>">
<input type='hidden' id='session_doctor_id' value="<?php echo $_SESSION['doctor_id'];?>">
<input type='hidden' id='session_age' value="<?php echo $_SESSION['age'];?>">
<input type='hidden' id='session_date_admit' value="<?php echo $_SESSION['dateofadmission_attd'];?>">
<input type='hidden' id='session_date_disch' value="<?php echo $_SESSION['dateofdischarge_attd'];?>">
<input type='hidden' id='session_folderno' value="<?php echo $_SESSION['folderno'];?>">
<input type='hidden' id='session_name' value="<?php echo $_SESSION['name'];?>">
<input type='hidden' id='session_gender' value="<?php echo $_SESSION['gender'];?>">
<input type='hidden' id='session_spec_1_id' value="<?php echo $_SESSION['spec_1_id'];?>">
<input type='hidden' id='session_spec_2_id' value="<?php echo $_SESSION['spec_2_id'];?>">
<input type='hidden' id='session_spec_3_id' value="<?php echo $_SESSION['spec_3_id'];?>">
<input type='hidden' id='session_spec_1_code' value="<?php echo $_SESSION['spec_1_code'];?>">
<input type='hidden' id='session_spec_2_code' value="<?php echo $_SESSION['spec_2_code'];?>">
<input type='hidden' id='session_spec_3_code' value="<?php echo $_SESSION['spec_3_code'];?>">
<input type='hidden' id='session_toa' value="<?php echo $_SESSION['type_of_attend'];?>">
<input type='hidden' id='session_tos_id' value="<?php echo $typeofservice_attd;?>">
<input type='hidden' id='session_tos_2' value="<?php echo $_SESSION['tos_2'];?>">
<input type='hidden' id='session_outcome' value="<?php echo $_SESSION['outcome'];?>">
<input type='hidden' id='session_claim_no' value="<?php echo $_SESSION['claim_no'];?>">
<input type='hidden' id='session_date_of_claim' value="<?php echo $_SESSION['date_of_claim'];?>">
<input type='hidden' id='session_pharmacy' value="<?php echo $_SESSION['pharmacy'];?>">
<input type='hidden' id='session_duration_of_spell' value="<?php echo $_SESSION['spell'];?>">
<input type='hidden' id='session_serial_no' value="<?php echo $_SESSION['serial_no'];?>">
<input type='hidden' id='session_nhis_led_id' value="<?php echo $_SESSION['Schname'];?>">
<input type='hidden' id='session_nhis_no' value="<?php echo $_SESSION['nhismemberno'];?>">
<input type='hidden' id='session_ghanacard' value="<?php echo $_SESSION['ghanacard'];?>">
<input type='hidden' id='session_nhis_date' value="<?php echo $_SESSION['nhisexpirydate'];?>">
<input type='hidden' id='session_nhisccc' value="<?php echo $_SESSION['nhisccc'];?>">
<input type='hidden' id='session_dependant' value="<?php echo $_SESSION['dependant'];?>">
<input type='hidden' id='session_prvt_led_id' value="<?php echo $_SESSION['prtinsname'];?>">
<input type='hidden' id='session_prvt_no' value="<?php echo $_SESSION['prtmemberno'];?>">
<input type='hidden' id='session_prvt_date' value="<?php echo $_SESSION['prtexpirydate'];?>">
<input type='hidden' id='session_sponsor' value="<?php echo $_SESSION['sponsor'];?>">
<input type='hidden' id='session_attend_state' value="<?php echo $_SESSION['attend_state'];?>">

<style type="text/css">
    .scroll-card-body {
            max-height: 700px;
            overflow-y: auto;
          }
    .amt-td {
            text-align:right;
          }
    .action-td {
            text-align:center;
          }
</style>

<div class="container-fluid">
		<div class="card shadow md-4">
	        <div class="card-header py-3">
	    		<small>Patient Attendance Details</small>
	        	<div class="table-responsive no-padding">
		        	<table width="100%" cellpadding="3" cellspacing="3">
			            <tr>
			            	<td width="15%" valign="top" style="text-align:center;">
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
							        	$type_attd = $row_attend['type_attd'];
							            if($type_attd == 'Walk-In')
							            {
							            	echo '<option value="0">Please Select</option>
											    	<option value="Regular">Regular</option>
											    	<option value="Walk-In" selected="selected">Walk-In</option>';
							            }
							            else
							            {
							            	echo '<option value="0">Please Select</option>
											    	<option value="Regular" selected="selected">Regular</option>
											    	<option value="Walk-In">Walk-In</option>';
							            };
							        ?>
							    </select>
							</div>

							<div class="col-md-3 mb-3">
								<input type="hidden" class="form-control bg-light" name="attend_id_attd" id="attend_id_attd" value="<?php echo $row_attend['attend_id'];?>">
								<label for="clinic_attd"><small><u>Clinic</u></small></label>
								<select class="form-control bg-light" name="clinic_attd" id="clinic_attd" required> 
							    	<option value="0">Please Select</option>
							        <?php
							        	$clinic_id = $row_attend['clinic_id'];
							        	$sql_clinic = "SELECT * FROM clinics ORDER BY clinic_desc ASC";
										$result_clinic = mysqli_query($con,$sql_clinic);
							            while($row_clinic = mysqli_fetch_array($result_clinic))
							            {
							            	if ($clinic_id == $row_clinic['clinic_id']) 
							            	{
							            		echo '<option value = "'.$row_clinic['clinic_id'].'" selected = "selected">'.$row_clinic['clinic_desc'].'</option>';
							            	} 
							            	else 
							            	{
							            		echo '<option value = "'.$row_clinic['clinic_id'].'">'.$row_clinic['clinic_desc'].'</option>';
							            	};
							            };
							        ?>
							    </select>
							</div>
							<div class="col-md-3 mb-3">
								<label for="doctor_attd">Doctor</label>
								<select class="form-control bg-light" name="doctor_attd" id="doctor_attd" required> 
							    	<option value="0">Please Select</option>
							        <?php
							        	$doctor_id = $row_attend['doctor_id'];
							        	$sql_doctor = "SELECT * FROM users WHERE user_type_id=6 ORDER BY first_name ASC";
										$result_doctor = mysqli_query($con,$sql_doctor);
							            while($row_doctor = mysqli_fetch_array($result_doctor))
							            {
							            	if ($doctor_id == $row_doctor['id']) 
							            	{
							            		echo '<option value = "'.$row_doctor['id'].'" selected = "selected">'.$row_doctor['first_name'].'</option>';
							            	} 
							            	else 
							            	{
							            		echo '<option value = "'.$row_doctor['id'].'">'.$row_doctor['first_name'].'</option>';
							            	};
							            };
							        ?>
							    </select>

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
							        	$state_attd = $row_attend['state_attd'];
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
						</div>
						<div class="form-row">
							<div class="col-md-4 mb-4">
								<label for="dateofadmission_attd"><small><u>Date Of Admission</u></small></label>
								<input type="date" class="form-control bg-light" name="dateofadmission_attd" id="dateofadmission_attd" value="<?php echo $row_attend['date_admit'];?>">
							</div>
							<div class="col-md-4 mb-4">
								<label for="dateofdischarge_attd"><small><u>Date Of Discharge</u></small></label>
								<input type="date" class="form-control bg-light" name="dateofdischarge_attd" id="dateofdischarge_attd" value="<?php echo $row_attend['date_disch'];?>">
							</div>
							<div class="col-md-4 mb-4">
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

						
						<div class="form-row">
							<div class="col-md-12 mb-12" id="attend_sponsor_table_div">
					    		<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="attend_sponsor_table">
								    <tr>
								        <th>Sponsors</th>
								    </tr>
					    <?php
					    	$query_payment_type = "SELECT * FROM payment_type WHERE attend_id ='$attend_id'";
					        $query_run_payment_type = mysqli_query($con, $query_payment_type);
					        $i=0;
					        if (mysqli_num_rows($query_run_payment_type) > 0)
							{
								
								while($row_payment_type = mysqli_fetch_assoc($query_run_payment_type))
								{
									$i=++$i;
						?>
								    <tr id="<?php echo $i;?>">
								        <td>
								            <div class="form-row">
												<div class="col-md-3 mb-3">
													<label for="attend_sponsor_id"><small><u>Sponsor Name</u></small></label>
													<select class="form-control bg-light attend_sponsor_id" name="attend_sponsor_id[]" id="attend_sponsor_id<?php echo $i;?>" data-id="<?php echo $i;?>" style="border-width:0px"> 
										                <option value="0">Please Select</option>
										                <?php
										                	$sponsor_id = $row_payment_type['ledger_id'];
										                    $sql_sponor = "SELECT * FROM ledgers WHERE (tb_5 = 1 OR tb_5 = 12 OR tb_5 = 13) ORDER BY ledger_desc"; 
										                    $result_sponor = mysqli_query($con,$sql_sponor);
										                    while($row_sponor = mysqli_fetch_array($result_sponor))
										                    {
										                    	if ($sponsor_id == $row_sponor['ledger_id']) {
										                    		echo '<option value ="'.$row_sponor['ledger_id'].'" selected ="selected">'.$row_sponor['ledger_desc'].'</option>';
										                    	} else {
										                    		echo '<option value ="'.$row_sponor['ledger_id'].'">'.$row_sponor['ledger_desc'].'</option>';
										                    	};
										                    };
										                ?>
										            </select>
												</div>
												<div class="col-md-2 mb-2">
													<label for="attend_sponsor_member_no"><small><u>Membership No</u></small></label>
													<input type="text" name="attend_sponsor_member_no[]" class="form-control bg-light attend_sponsor_member_no" id="attend_sponsor_member_no<?php echo $i;?>" data-id="1" style="border-width:0px" value="<?php echo $row_payment_type['member_no'];?>">
												</div>
												<div class="col-md-2 mb-2">
													<div id="ghanacard_div<?php echo $i;?>" <?php if($row_payment_type['ledger_id'] == 2){echo 'style=display:inline;';}else{echo 'style=display:none;';};?>>
														<label for="ghanacard_attd"><small><u>Ghana Card</u></small></label>
														<input type="text" class="form-control bg-light" name="ghanacard_attd[]" id="ghanacard_attd<?php echo $i;?>" value="<?php echo $row_payment_type['ghanacard'];?>">
													</div>
													<div id="ins_category_div<?php echo $i;?>" <?php if($row_payment_type['ledger_id'] == 2){echo 'style=display:none;';}else{echo 'style=display:inline;';};?>>
														<label for="attend_sponsor_category"><small><u>Category</u></small></label>
														<input type="text" name="attend_sponsor_category[]" class="form-control bg-light attend_sponsor_category" id="attend_sponsor_category<?php echo $i;?>" data-id="<?php echo $i;?>" style="border-width:0px" value="<?php echo $row_payment_type['ins_class'];?>">
													</div>
												</div>
												<div class="col-md-2 mb-2">
													<label for="attend_sponsor_expiry_date"><small><u>Expiry Date</u></small></label>
													<input type="date" name="attend_sponsor_expiry_date[]" class="form-control bg-light" id="attend_sponsor_expiry_date<?php echo $i;?>" style="border-width:0px" value="<?php echo $row_payment_type['expiry_date'];?>">
												</div>
												<div class="col-md-1 mb-1">
													<label for="attend_sponsor_principal"><small><u>Principal</u></small></label>
													<div id="principal_select_div<?php echo $i;?>">
														<select class="form-control bg-light attend_sponsor_principal" name="attend_sponsor_principal[]" id="attend_sponsor_principal<?php echo $i;?>" data-id="<?php echo $i;?>" style="border-width:0px"> 
											                <option value="0">Please Select</option>
											                <?php
											                	$principal = $row_payment_type['principal'];
										                    	if ($principal == 'Yes') {
										                    		echo '<option value ="Yes" selected ="selected">Yes</option>
										                    			<option value ="No">No</option>';
										                    	} else {
										                    		echo '<option value ="Yes">Yes</option>
										                    			<option value ="No" selected ="selected">No</option>';
										                    	};
											                ?>
											            </select>
												    </div>
												</div>
												<div class="col-md-2 mb-2">
													<div id="serial_no_div<?php echo $i;?>"<?php if($row_payment_type['ledger_id'] == 2){echo 'style=display:inline;';}else{echo 'style=display:none;';};?>>
														<label for="serial_no"><small><u>Serial no</u></small></label>
														<input type="text" class="form-control bg-light" name="serial_no[]" id="serial_no<?php echo $i;?>" value="<?php echo $row_payment_type['serial_no'];?>">
													</div>
													<div id="relation_div<?php echo $i;?>" <?php if($row_payment_type['ledger_id'] == 2){echo 'style=display:none;';}else{echo 'style=display:inline;';};?>>
														<label for="attend_sponsor_relation"><small><u>Relation Type</u></small></label>
														<input type="text" class="form-control bg-light" name="attend_sponsor_relation[]" id="attend_sponsor_relation<?php echo $i;?>" value="<?php echo $row_payment_type['relation'];?>">
													</div>
												</div>
											</div>
											<?php
												$specialty_1 = $row_payment_type['specialty_1'];
												$specialty_array = explode(",",$specialty_1);
											?>
											<div class="form-row" id="ins_detail_one<?php echo $i;?>" <?php if($row_payment_type['ledger_id'] == 2){echo 'style=display:flex;';}else{echo 'style=display:none;';};?>>
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
											<hr class="d-none d-md-block">
											</div>
											<div class="form-row" id="ins_detail_two<?php echo $i;?>" <?php if($row_payment_type['ledger_id'] == 2){echo 'style=display:flex;';}else{echo 'style=display:none;';};?>>
												<div class="col-md-3 mb-3">
													<label for="type_of_attendnace"><small><u>Type Of Attendance</u></small></label>
													<select class="form-control bg-light" name="type_of_attendnace[]" id="type_of_attendnace<?php echo $i;?>"> 
												    	<option value="0">-Please Select-</option>
												    	<?php
										                	$type_of_attend = $row_payment_type['type_of_attend'];
									                    	if ($type_of_attend == 'chronic_follow_up') 
									                    	{
									                    		echo '<option value ="chronic_follow_up" selected ="selected">Chronic Follow-up</option>
															    	<option value="emergency_acute_episode">Emergency/Acute Episode</option>
															    	<option value="antenatal">Antenatal Care</option>
																	<option value="postnatal">Postnatal Care</option>';
									                    	} 
									                    	else if($type_of_attend == 'emergency_acute_episode')
									                    	{
									                    		echo '<option value ="chronic_follow_up">Chronic Follow-up</option>
															    	<option value="emergency_acute_episode" selected ="selected">Emergency/Acute Episode</option>
															    	<option value="antenatal">Antenatal Care</option>
																	<option value="postnatal">Postnatal Care</option>';
									                    	}
									                    	else if($type_of_attend == 'antenatal')
									                    	{
									                    		echo '<option value ="chronic_follow_up">Chronic Follow-up</option>
															    	<option value="emergency_acute_episode">Emergency/Acute Episode</option>
															    	<option value="antenatal" selected ="selected">Antenatal Care</option>
																	<option value="postnatal">Postnatal Care</option>';
									                    	}
									                    	else if($type_of_attend == 'postnatal')
									                    	{
									                    		echo '<option value ="chronic_follow_up">Chronic Follow-up</option>
															    	<option value="emergency_acute_episode">Emergency/Acute Episode</option>
															    	<option value="antenatal">Antenatal Care</option>
																	<option value="postnatal" selected ="selected">Postnatal Care</option>';
									                    	};
										                ?>
												    </select>
												</div>
												<div class="col-md-2 mb-2">
													<label for="date_of_claim"><small><u>Date of Claim</u></small></label>
													<input type="date" class="form-control bg-light" name="date_of_claim[]" id="date_of_claim<?php echo $i;?>" value="<?php echo $row_payment_type['date_of_claim'];?>">
												</div>
												<div class="col-md-1 mb-1">
													<label for="claim_no"><small><u>Claim No</u></small></label>
													<input type="text" class="form-control" name="claim_no[]" id="claim_no<?php echo $i;?>" value="<?php echo $row_payment_type['claim_no'];?>">
												</div>
												<div class="col-md-2 mb-2">
													<label for="pharmacy"><small><u>Pharmacy</u></small></label>
													<select class="form-control bg-light" name="pharmacy[]" id="pharmacy<?php echo $i;?>"> 
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
													<select class="form-control bg-light" name="type_of_service_2[]" id="type_of_service_2<?php echo $i;?>"> 
												    	
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
													<input type="text" class="form-control bg-light" name="nhisccc[]" id="nhisccc<?php echo $i;?>" value="<?php echo $row_payment_type['code'];?>">
												</div>
												<div class="col-md-1 mb-1">
													<label for="spell"><small><u>Spell</u></small></label>
													<input type="text" class="form-control bg-light" name="spell[]" id="spell<?php echo $i;?>" value="<?php echo $row_payment_type['spell'];?>">
												</div>
											</div>
											<div class="clearfix">
												<?php
							                    	if ($i > 1) {
							                    		echo '<a href="#" id="delete_attend_sponsor" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>';
							                    	};
									            ?>
											</div>
											<hr class="d-none d-md-block">
								        </td>
								    </tr>
						<?php
		                    	};
		                    };
		                    		$i=++$i;
		                ?>
		                			<tr id="<?php echo $i;?>">
								        <td>
								            <div class="form-row">
												<div class="col-md-3 mb-3">
													<label for="schname_attd"><small><u>Sponsor Name</u></small></label>
													<select class="form-control bg-light attend_sponsor_id" name="attend_sponsor_id[]" id="attend_sponsor_id<?php echo $i;?>" data-id="<?php echo $i;?>" style="border-width:0px"> 
										                <option value="0">Please Select</option>
										                <?php
										                    $sql_sponor = "SELECT * FROM ledgers WHERE (tb_5 = 1 OR tb_5 = 12 OR tb_5 = 13) ORDER BY ledger_desc"; 
										                    $result_sponor = mysqli_query($con,$sql_sponor);
										                    while($row_sponor = mysqli_fetch_array($result_sponor))
										                    {
										                    		echo '<option value ="'.$row_sponor['ledger_id'].'">'.$row_sponor['ledger_desc'].'</option>';
										                    };
										                ?>
										            </select>
												</div>
												<div class="col-md-2 mb-2">
													<label for="attend_sponsor_member_no"><small><u>Membership No</u></small></label>
													<input type="text" name="attend_sponsor_member_no[]" class="form-control bg-light attend_sponsor_member_no" id="attend_sponsor_member_no<?php echo $i;?>" data-id="1" style="border-width:0px" >
												</div>
												<div class="col-md-2 mb-2">
													<div id="ghanacard_div<?php echo $i;?>"  style='display:none;'>
														<label for="ghanacard_attd"><small><u>Ghana Card</u></small></label>
														<input type="text" class="form-control bg-light" name="ghanacard_attd[]" id="ghanacard_attd<?php echo $i;?>">
													</div>
													<div id="ins_category_div<?php echo $i;?>">
														<label for="attend_sponsor_category"><small><u>Category</u></small></label>
														<input type="text" name="attend_sponsor_category[]" class="form-control bg-light attend_sponsor_category" id="attend_sponsor_category<?php echo $i;?>" data-id="<?php echo $i;?>" style="border-width:0px" >
													</div>
												</div>
												<div class="col-md-2 mb-2">
													<label for="attend_sponsor_expiry_date"><small><u>Expiry Date</u></small></label>
													<input type="date" name="attend_sponsor_expiry_date[]" class="form-control bg-light" id="attend_sponsor_expiry_date<?php echo $i;?>" style="border-width:0px">
												</div>
												<div class="col-md-1 mb-1">
													<label for="attend_sponsor_principal"><small><u>Principal</u></small></label>
													<div id="principal_select_div<?php echo $i;?>">
														<select class="form-control bg-light attend_sponsor_principal" name="attend_sponsor_principal[]" id="attend_sponsor_principal<?php echo $i;?>" data-id="<?php echo $i;?>" style="border-width:0px"> 
											                <option value="0">Please Select</option>
											                <option value ="Yes">Yes</option>
											                <option value ="No">No</option>
											            </select>
													</div>
												</div>
												<div class="col-md-2 mb-2">
													<div id="serial_no_div<?php echo $i;?>" style='display:none;'>
														<label for="serial_no"><small><u>Serial no</u></small></label>
														<input type="text" class="form-control bg-light" name="serial_no[]" id="serial_no<?php echo $i;?>">
													</div>
													<div id="relation_div<?php echo $i;?>">
														<label for="attend_sponsor_relation"><small><u>Relation Type</u></small></label>
														<input type="text" class="form-control bg-light" name="attend_sponsor_relation[]" id="attend_sponsor_relation<?php echo $i;?>">
													</div>
												</div>
											</div>
											<div class="form-row" id="ins_detail_one<?php echo $i;?>"  style='display:none;'>
											<label for="specialty_attd"><small><u>Specialty Code</u></small></label>
												<div class="col-md-1 mb-1">
													<div class="form-check">
													<input class="form-check-input" type="checkbox" value="ASUR" id="ASUR<?php echo $i;?>" name="specialty_attd[]">
													<label class="form-check-label" for="ASUR">
														ASUR
													</label>
													</div>
												</div>
												<div class="col-md-1 mb-1">
													<div class="form-check">
													<input class="form-check-input" type="checkbox" value="DENT" id="DENT<?php echo $i;?>" name="specialty_attd[]">
													<label class="form-check-label" for="DENT">
														DENT
													</label>
													</div>
												</div>
												<div class="col-md-1 mb-1">
													<div class="form-check">
													<input class="form-check-input" type="checkbox" value="ENTH" id="ENTH<?php echo $i;?>" name="specialty_attd[]">
													<label class="form-check-label" for="ENTH">
														ENTH
													</label>
													</div>
												</div>
												<div class="col-md-1 mb-1">
													<div class="form-check">
													<input class="form-check-input" type="checkbox" value="MEDI" id="MEDI<?php echo $i;?>" name="specialty_attd[]">
													<label class="form-check-label" for="MEDI">
														MEDI
													</label>
													</div>
												</div>
												<div class="col-md-1 mb-1">
													<div class="form-check">
													<input class="form-check-input" type="checkbox" value="OBGY" id="OBGY<?php echo $i;?>" name="specialty_attd[]">
													<label class="form-check-label" for="OBGY">
														OBGY
													</label>
													</div>
												</div>
												<div class="col-md-1 mb-1">
													<div class="form-check">
													<input class="form-check-input" type="checkbox" value="OPDC" id="OPDC<?php echo $i;?>" name="specialty_attd[]">
													<label class="form-check-label" for="OPDC">
														OPDC
													</label>
													</div>
												</div>
												<div class="col-md-1 mb-1">
													<div class="form-check">
													<input class="form-check-input" type="checkbox" value="OPHT" id="OPHT<?php echo $i;?>" name="specialty_attd[]">
													<label class="form-check-label" for="OPHT">
														OPHT
													</label>
													</div>
												</div>
												<div class="col-md-1 mb-1">
													<div class="form-check">
													<input class="form-check-input" type="checkbox" value="ORTH" id="ORTH<?php echo $i;?>" name="specialty_attd[]">
													<label class="form-check-label" for="ORTH">
														ORTH
													</label>
													</div>
												</div>
												<div class="col-md-1 mb-1">
													<div class="form-check">
													<input class="form-check-input" type="checkbox" value="PAED" id="PAED<?php echo $i;?>" name="specialty_attd[]">
													<label class="form-check-label" for="PAED">
														PAED
													</label>
													</div>
												</div>
												<div class="col-md-1 mb-1">
													<div class="form-check">
													<input class="form-check-input" type="checkbox" value="PSUR" id="PSUR<?php echo $i;?>" name="specialty_attd[]">
													<label class="form-check-label" for="PSUR">
														PSUR
													</label>
													</div>
												</div>
												<div class="col-md-1 mb-1">
													<div class="form-check">
													<input class="form-check-input" type="checkbox" value="RSUR" id="RSUR<?php echo $i;?>" name="specialty_attd[]">
													<label class="form-check-label" for="RSUR">
														RSUR
													</label>
													</div>
												</div>
											<hr class="d-none d-md-block">
											</div>
											<div class="form-row" id="ins_detail_two<?php echo $i;?>" style='display:none;'>
												<div class="col-md-3 mb-3">
													<label for="type_of_attendnace"><small><u>Type Of Attendance</u></small></label>
													<select class="form-control bg-light" name="type_of_attendnace[]" id="type_of_attendnace<?php echo $i;?>"> 
												    	<option value="0">-Please Select-</option>
												    	<option value="chronic_follow_up">Chronic Follow-up</option>
												    	<option value="emergency_acute_episode">Emergency/Acute Episode</option>
												    	<option value="antenatal">Antenatal Care</option>
												    </select>
												</div>
												<div class="col-md-2 mb-2">
													<label for="date_of_claim"><small><u>Date of Claim</u></small></label>
													<input type="date" class="form-control bg-light" name="date_of_claim[]" id="date_of_claim<?php echo $i;?>">
												</div>
												<div class="col-md-1 mb-1">
													<label for="claim_no"><small><u>Claim No</u></small></label>
													<input type="text" class="form-control" name="claim_no[]" id="claim_no<?php echo $i;?>">
												</div>
												<div class="col-md-2 mb-2">
													<label for="pharmacy"><small><u>Pharmacy</u></small></label>
													<select class="form-control bg-light" name="pharmacy[]" id="pharmacy<?php echo $i;?>"> 
												    	<option value="0">Please Select</option>
												    	<option value="pharmacy">Pharmacy</option>
												    </select>
												</div>
												<div class="col-md-2 mb-2">
													<label for="type_of_service_2"><small><u>Type Of Service (b)</u></small></label>
													<select class="form-control bg-light" name="type_of_service_2[]" id="type_of_service_2<?php echo $i;?>"> 
												    	<option value="0">Please Select</option>
												    	<option value="all_inclusive">All Inclusive</option>
												    	<option value="unbundled">Unbundled</option>
												    </select>
												</div>
												<div class="col-md-1 mb-1">
													<label for="nhisccc"><small><u>CCC</u></small></label>
													<input type="text" class="form-control bg-light" name="nhisccc[]" id="nhisccc<?php echo $i;?>">
												</div>
												<div class="col-md-1 mb-1">
													<label for="spell"><small><u>Spell</u></small></label>
													<input type="text" class="form-control bg-light" name="spell[]" id="spell<?php echo $i;?>">
												</div>
											</div>
											<div class="clearfix">
												<?php
							                    	if ($i > 1) {
							                    		echo '<a href="#" id="delete_attend_sponsor" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>';
							                    	};
									            ?>
											</div>
											<hr class="d-none d-md-block">
								        </td>
								    </tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

	    <div class="card-footer">
	    	<div class="modal-footer">
	        	<button type="submit" name="attend_edit_update_btn" id="attend_edit_update_btn" class="btn btn-primary">Update</button>
				<a name="attend_edit_cancel_btn" id="attend_edit_cancel_btn" class="btn btn-primary text-white">Cancel</a>
			</div>
		</div>
			</form>
	</div>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>