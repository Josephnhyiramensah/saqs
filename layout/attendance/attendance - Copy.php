<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    	$patient_id = $_SESSION['patient_id'];
		$folderno = $_SESSION['folderno'];
		$name = $_SESSION['name'];
		$DOB = $_SESSION['dob'];
		$age = date_diff(date_create($DOB), date_create(date("d-m-Y")));
		$gender = $_SESSION['gender'];
		$Schname = $_SESSION['Schname'];
		$nhismemberno = $_SESSION['nhismemberno'];
		$serial_no = $_SESSION['serial_no'];
		$ghanacard = $_SESSION['ghanacard'];
		$nhisexpirydate = $_SESSION['nhisexpirydate'];
		$prtinsname = $_SESSION['prtinsname'];
		$prtmemberno = $_SESSION['prtmemberno'];
		$prtexpirydate = $_SESSION['prtexpirydate'];
		$date = date("d-m-Y");
?>

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
			                    	<td><u>Patient No.</u></td>
			                    	<td><u>Folder No.</u></td>
			                    	<td><u>Age</u></td>
			                    	<td><u>Gender</u></td>
			                    </tr>
			                    <tr>
			            			<td><?php echo $patient_id;?></td>
			            			<td><?php echo $folderno;?></td>
			            			<td><?php echo $age->format("%y");?></td>
			            			<td><?php echo $gender?></td>
			            		</tr>
		                    </table>
		                </td>
		            </tr>
	            </table>
	        </div>
        </div>
        <div class="card-body">
        	<form id="new_attend_form" action="" method="POST">
				<div class="form-row">
					<div class="col-md-12 mb-12">
			    		<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="attend_id"><u>Attendance ID</u></label>
								<?php
									$sql="SELECT attend_id FROM attendance ORDER BY attend_id DESC";
									$result=mysqli_query($con,$sql);
									$rs=mysqli_fetch_array($result);
									if ($rs) {
										$vn=$rs['attend_id']+1;
									} else {
										$vn=1;
									}
									echo'<input type="text" name="attend_no" id="attend_no" class="form-control" disabled value="'.str_pad($vn,7,"0",STR_PAD_LEFT).'">';
								?>
								<input type="hidden" class="form-control" name="attend_id" id="attend_id" value="<?php echo $vn;?>">
								<input type="hidden" class="form-control" name="patient_id_attend" id="patient_id_attend" value="<?php echo $patient_id;?>">
								<input type="hidden" class="form-control" name="patient_folderno" id="patient_folderno" value="<?php echo $folderno;?>">
								<input type="hidden" class="form-control" name="patient_name" id="patient_name" value="<?php echo $name;?>">
								<input type="hidden" class="form-control" name="patient_gender" id="patient_gender" value="<?php echo $gender;?>">
								<input type="hidden" class="form-control" name="patient_age" id="patient_age" value="<?php echo $age->format("%y");?>">
							</div>
							<div class="col-md-2 mb-2">
								<label for="typeofservice_attd"><u>Type Of Service</u></label>
								<select class="form-control" name="typeofservice_attd" id="typeofservice_attd" required> 
							    <option value="0">Please Select</option>
							        <?php
							        	$sql="SELECT * FROM type_of_service ORDER BY description DESC";
										$result=mysqli_query($con,$sql);
							            while($row=mysqli_fetch_array($result))
							            {
							            ?>
							            <option value = "<?php echo($row['tos_id'])?>" >
							                <?php echo($row['description']) ?>
							            </option>
							            <?php
							            }               
							        ?>
							    </select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="dateofadmission"><u>Date Of Admission</u></label>
								<input type="date" class="form-control" name="dateofadmission_attd" id="dateofadmission_attd" value="<?php echo date('Y-m-d');?>" required>
							</div>
							<div class="col-md-2 mb-2">
								<label for="dateofdischarge"><u>Date Of Discharge</u></label>
								<input type="date" class="form-control" name="dateofdischarge_attd" id="dateofdischarge_attd">
							</div>
							<div class="col-md-2 mb-2">
								<label for="clinic"><u>Clinic</u></label>
								<select class="form-control" name="clinic_attd" id="clinic_attd" required> 
							    <option value="0">Please Select</option>
							        <?php
							        	$sql="SELECT * FROM clinics ORDER BY clinic_desc DESC";
										$result=mysqli_query($con,$sql);
							            while($row=mysqli_fetch_array($result))
							            {
							            ?>
							            <option value = "<?php echo($row['clinic_id'])?>" >
							                <?php echo($row['clinic_desc']) ?>
							            </option>
							            <?php
							            }               
							        ?>
							    </select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="outcome"><u>Outcome</u></label>
								<select class="form-control" name="outcome" id="outcome" required> 
							    	<option value="0">-Please Select-</option>
							    	<option value="discharged">Discharged</option>
							    	<option value="died">Died</option>
							    	<option value="absconded">Absconded</option>
							    	<option value="discharged_against_medical_advice">Discharged Against Medical Advice</option>
							    	<option value="referred_out">Referred Out</option>
							    	<option value="transferred_out">Transferred Out</option>
							    </select>
							</div>
						</div>
					<div id="nhis_attd_details">
						<hr class="d-none d-md-block">
						<div class="form-row">
							<div class="col-md-4 mb-4">
								<label for="schname_attd">NHIS Name</label>
								<select class="form-control" name="schname_attd" id="schname_attd"> 
							    <option value="0">-Please Select-</option>
							        <?php
							        	$sql="SELECT * FROM ledgers WHERE type=1 ORDER BY ledger_desc ASC";
										$result=mysqli_query($con,$sql);
							            while($row=mysqli_fetch_array($result))
							            {
							            	if ($Schname==$row['ledger_id']) {
							            ?>
							            <option selected="selected" value = "<?php echo $row['ledger_id'];?>" >
							                <?php echo($row['ledger_desc']) ?>
							            </option>
							            <?php
							            	}
							            	else
							            	{
							            ?>
							            	<option value = "<?php echo $row['ledger_id'];?>" >
							                <?php echo($row['ledger_desc']) ?>
							            	</option>
							            <?php
							            	}
							            }               
							        ?>
							    </select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="nhismemberno_attd">Membership No</label>
								<input type="text" class="form-control" name="nhismemberno_attd" id="nhismemberno_attd" value="<?php echo $nhismemberno;?>">
							</div>
							<div class="col-md-2 mb-2">
								<label for="ghanacard_attd">Ghana Card</label>
								<input type="text" class="form-control" name="ghanacard_attd" id="ghanacard_attd" value="<?php echo $ghanacard;?>">
							</div>
							<div class="col-md-2 mb-2">
								<label for="serial_no">Serial no</label>
								<input type="text" class="form-control" name="serial_no" id="serial_no" value="<?php echo $serial_no;?>">
							</div>
							<div class="col-md-2 mb-2">
								<label for="nhisexpirydate_attd">Expiry Date</label>
								<input type="date" class="form-control" name="nhisexpirydate_attd" id="nhisexpirydate_attd" value="<?php echo $nhisexpirydate;?>">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label for="specialty_attd_1"><u>Specialty (Primary)</u></label>
								<select class="form-control" name="specialty_attd_1" id="specialty_attd_1"> 
							    	<option value="0">Please Select</option>
							        <?php
							        	$sql="SELECT * FROM nhis WHERE category_id=1 ORDER BY nhis_item_desc DESC";
										$result=mysqli_query($con,$sql);
							            while($row=mysqli_fetch_array($result))
							            {
							            ?>
							            <option value = "<?php echo($row['nhis_id'])?>" >
							                <?php echo($row['nhis_item_desc']) ?>
							            </option>
							            <?php
							            }               
							        ?>
							    </select>
							</div>
							<div class="col-md-1 mb-1">
								<label for="spec_code_1">Specialty Code</label>
								<input type="text" class="form-control" name="spec_code_1" id="spec_code_1">
							</div>
							<div class="col-md-3 mb-3">
								<label for="specialty_attd_2"><u>Specialty (Secondary)</u></label>
								<select class="form-control" name="specialty_attd_2" id="specialty_attd_2"> 
							    	<option value="0">Please Select</option>
							        <?php
							        	$sql="SELECT * FROM nhis WHERE category_id=1 ORDER BY nhis_item_desc DESC";
										$result=mysqli_query($con,$sql);
							            while($row=mysqli_fetch_array($result))
							            {
							            ?>
							            <option value = "<?php echo($row['nhis_id'])?>" >
							                <?php echo($row['nhis_item_desc']) ?>
							            </option>
							            <?php
							            }               
							        ?>
							    </select>
							</div>
							<div class="col-md-1 mb-1">
								<label for="spec_cod_2">Specialty Code</label>
								<input type="text" class="form-control" name="spec_code_2" id="spec_code_2">
							</div>
							<div class="col-md-3 mb-3">
								<label for="specialty_attd_3"><u>Specialty (Tertiary)</u></label>
								<select class="form-control" name="specialty_attd_3" id="specialty_attd_3"> 
							    	<option value="0">Please Select</option>
							        <?php
							        	$sql="SELECT * FROM nhis WHERE category_id=1 ORDER BY nhis_item_desc DESC";
										$result=mysqli_query($con,$sql);
							            while($row=mysqli_fetch_array($result))
							            {
							            ?>
							            <option value = "<?php echo($row['nhis_id'])?>" >
							                <?php echo($row['nhis_item_desc']) ?>
							            </option>
							            <?php
							            }               
							        ?>
							    </select>
							</div>
							<div class="col-md-1 mb-1">
								<label for="spec_code_3">Specialty Code</label>
								<input type="text" class="form-control" name="spec_code_3" id="spec_code_3">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label for="type_of_attendnace"><u>Type Of Attendance</u></label>
								<select class="form-control" name="type_of_attendnace" id="type_of_attendnace"> 
							    	<option value="0">-Please Select-</option>
							    	<option value="chronic_follow_up">Chronic Follow-up</option>
							    	<option value="emergency_acute_episode">Emergency/Acute Episode</option>
							    	<option value="antenatal">Antenatal Care</option>
							    </select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="date_of_claim"><u>Date of Claim</u></label>
								<input type="date" class="form-control" name="date_of_claim" id="date_of_claim">
							</div>
							<div class="col-md-1 mb-1">
								<label for="claim_no"><u>Claim No</u></label>
								<input type="text" class="form-control" name="claim_no" id="claim_no">
							</div>
							<div class="col-md-2 mb-2">
								<label for="pharmacy"><u>Pharmacy</u></label>
								<select class="form-control" name="pharmacy" id="pharmacy"> 
							    	<option value="0">Please Select</option>
							    	<option value="pharmacy">Pharmacy</option>
							    </select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="type_of_service_2"><u>Type Of Service (b)</u></label>
								<select class="form-control" name="type_of_service_2" id="type_of_service_2"> 
							    	<option value="0">Please Select</option>
							    	<option value="all_inclusive">All Inclusive</option>
							    	<option value="unbundled">Unbundled</option>
							    </select>
							</div>
							<div class="col-md-1 mb-1">
								<label for="nhisccc">CCC</label>
								<input type="text" class="form-control" name="nhisccc" id="nhisccc">
							</div>
							<div class="col-md-1 mb-1">
								<label for="spell">Spell</label>
								<input type="text" class="form-control" name="spell" id="spell">
							</div>
						</div>
					</div>
					<div id="prvt_attd_details">
						<hr class="d-none d-md-block">
						<div class="form-row">
							<div class="col-md-4 mb-4">
								<label for="prtinsname_attd">Private Insurance Name</label>
								<select class="form-control" name="prtinsname_attd" id="prtinsname_attd"> 
							    <option value="0">-Please Select-</option>
							        <?php
							        	$sql="SELECT * FROM ledgers WHERE type=2 ORDER BY ledger_desc ASC";
										$result=mysqli_query($con,$sql);
							            while($row=mysqli_fetch_array($result))
							            {
							            	if ($prtinsname==$row['ledger_id']) {
							            ?>
									            <option selected="selected" value = "<?php echo($row['ledger_id'])?>" >
									                <?php echo($row['ledger_desc']) ?>
									            </option>
							            <?php
							            	}
							            	else
							            	{
							            ?>
									            <option value = "<?php echo($row['ledger_id'])?>" >
									                <?php echo($row['ledger_desc']) ?>
									            </option>
							            <?php
							            	}
							            }               
							        ?>
							    </select>
							</div>
							<div class="col-md-4 mb-4">
								<label for="prtmemberno_attd">Membership No</label>
								<input type="text" class="form-control" name="prtmemberno_attd" id="prtmemberno_attd" value="<?php echo$prtmemberno;?>">
							</div>
							<div class="col-md-4 mb-4">
								<label for="prtexpirydate_attd">Expiry Date</label>
								<input type="date" class="form-control" name="prtexpirydate_attd" id="prtexpirydate_attd" value="<?php echo$prtexpirydate;?>">
							</div>
						</div>
					</div>
					<hr class="d-none d-md-block">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="nhisbill"><u>NHIS Bill</u></label>
								<input type="text" class="form-control" name="nhisbill" id="nhisbill_attd" disabled="true">
							</div>
							<div class="col-md-2 mb-2">
								<label for="prvtinsbill"><u>Private Ins. Bill</u></label>
								<input type="text" class="form-control" name="prvtinsbill" id="prvtinsbill_attd" disabled="true">
							</div>
							<div class="col-md-3 mb-3">
								<label for="daysbill"><u>Cash Bill</u></label>
								<input type="text" class="form-control" name="cashbill" id="cashbill_attd" disabled="true">
							</div>
							<div class="col-md-2 mb-2">
								<label for="daysrec"><u>Cash Receipt</u></label>
								<input type="text" class="form-control" name="cashrec" id="cashrec_attd" disabled="true">
							</div>
							<div class="col-md-3 mb-3">
								<label for="acbal"><u>Account Balance</u></label>
								<input type="text" class="form-control" name="acbal" id="acbal_attd" disabled="true">
							</div>
						</div>
					</div>
				</div>
        </div>
        <div class="card-footer">
        	<div class="modal-footer">
	        	<button type="submit" name="attend_save_btn_attd" id="attend_save_btn_attd" class="btn btn-primary">Save</button>
				<a name="attend_cancel_btn_attd" id="attend_cancel_btn_attd" class="btn btn-primary text-white">Cancel</a>
			</div>
		</div>
			</form>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>