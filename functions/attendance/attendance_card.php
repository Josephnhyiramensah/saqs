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
				<div class="form-row">
					<div class="col-md-12 mb-12">
			    		<div class="form-row">
							<div class="col-md-4 mb-4">
								<label for="attend_sponsor">Sponsor</label>
								<select class="form-control" name="attend_sponsor" id="attend_sponsor"> 
							    	<option value="0">Please Select</option>
							        <?php
							        	$sponsor_option = set_sponsor_list();
							        	echo $sponsor_option;
							        ?>
							    </select>
								<input type="hidden" class="form-control" name="attd_service_id" id="attd_service_id">
								<input type="hidden" class="form-control" name="attd_service_amt_cash" id="attd_service_amt_cash">
								<input type="hidden" class="form-control" name="attd_service_amt_prvt" id="attd_service_amt_prvt">
								<input type="hidden" class="form-control" name="attd_service_amt_nhis" id="attd_service_amt_nhis">
								<input type="hidden" class="form-control" name="attd_service_gdrg" id="attd_service_gdrg">

								<input type="hidden" class="form-control" name="attend_id" id="attend_id" value="<?php echo $vn;?>">
								<input type="hidden" class="form-control" name="patient_id_attend" id="patient_id_attend" value="<?php echo $patient_id;?>">
								<input type="hidden" class="form-control" name="patient_folderno" id="patient_folderno" value="<?php echo $folderno;?>">
								<input type="hidden" class="form-control" name="patient_name" id="patient_name" value="<?php echo $name;?>">
								<input type="hidden" class="form-control" name="patient_gender" id="patient_gender" value="<?php echo $gender;?>">
								<input type="hidden" class="form-control" name="patient_age" id="patient_age" value="<?php echo $age;?>">
							</div>
							<div class="col-md-4 mb-4">
								<label for="clinic"><small><u>Clinic</u></small></label>
								<select class="form-control" name="clinic_attd" id="clinic_attd" required> 
							    <option value="0">Please Select</option>
							        <?php
							        	$sql = "SELECT * FROM clinics ORDER BY clinic_desc DESC";
										$result = mysqli_query($con,$sql);
							            while($row = mysqli_fetch_array($result))
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
							<div class="col-md-4 mb-4">
								<label for="typeofservice_attd"><small><u>Type Of Service</u></small></label>
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
						</div>
						<div class="form-row">
							<div class="col-md-4 mb-4">
								<label for="dateofadmission"><small><u>Date Of Admission</u></small></label>
								<input type="date" class="form-control" name="dateofadmission_attd" id="dateofadmission_attd" value="" required>
							</div>
							<div class="col-md-4 mb-4">
								<label for="dateofdischarge"><small><u>Date Of Discharge</u></small></label>
								<input type="date" class="form-control" name="dateofdischarge_attd" id="dateofdischarge_attd">
							</div>
							<div class="col-md-4 mb-4">
								<label for="outcome"><small><u>Outcome</u></small></label>
								<select class="form-control" name="outcome" id="outcome" required> 
							    	<option value="0">-Please Select-</option>
							    	<option value="discharged">Discharged</option>
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
								        <th width="30%">Sponsor</th>
								        <th width="15%">Membership No</th>
								        <th width="20%">Category</th>
								        <th width="10%">Is Prinicipal</th>
								        <th width="10%">Code</th>
								        <th width="10%">Expiry Date</th>
								        <th width="5%" class="action-td">Action</th>
								    </tr>
								    <tr id="1">
								        <td>
								            <select class="form-control bg-light attend_sponsor_id" name="attend_sponsor_id[]" id="attend_sponsor_id1" data-id="1" style="border-width:0px"> 
								                <option value="0">Please Select</option>
								                <?php
								                    $sql_sponor = "SELECT * FROM ledgers WHERE tb_5 = 1 ORDER BY ledger_desc"; 
								                    $result_sponor = mysqli_query($con,$sql_sponor);
								                    while($row_sponor = mysqli_fetch_array($result_sponor))
								                    {
								                        echo '<option value ="'.$row_sponor['ledger_id'].'">'.$row_sponor['ledger_desc'].'</option>';
								                    }
								                ?>
								            </select>
								        </td>
								        <td>
								            <input type="text" name="attend_sponsor_member_no[]" class="form-control bg-light attend_sponsor_member_no" id="attend_sponsor_member_no1" data-id="1" style="border-width:0px">
								        </td>
								        <td>
								            <input type="text" name="attend_sponsor_category[]" class="form-control bg-light attend_sponsor_category" id="attend_sponsor_category1" data-id="1" style="border-width:0px">
								        </td>
								        <td>
								            <select class="form-control bg-light attend_sponsor_principal" name="attend_sponsor_principal[]" id="attend_sponsor_principal1" data-id="1" style="border-width:0px"> 
								                <option value="0">Please Select</option>
								                <option value ="Yes">Yes</option>
								                <option value ="No">No</option>
								            </select>
								        </td>
								        <td>
								            <input type="text" name="attend_sponsor_code[]" class="form-control bg-light" id="attend_sponsor_code1" style="border-width:0px">
								        </td>
								        <td>
								            <input type="date" name="attend_sponsor_expiry_date[]" class="form-control bg-light" id="attend_sponsor_expiry_date1" style="border-width:0px">
								        </td>
								        <td class="action-td">
								            <!--<a href="#" id="delete_attend_sponsor" data-id="1"><i class="fa fa-trash fa-sm"></i></a>-->
								        </td>
								    </tr>
								</table>
							</div>
						</div>
						<div id="nhis_attd_details">
							<hr class="d-none d-md-block">
							<div class="form-row">
								<div class="col-md-3 mb-3">
									<label for="schname_attd"><small><u>Scheme Name<</u></small></label>
									<select class="form-control" name="schname_attd" id="schname_attd"> 
								    <option value="0">-Please Select-</option>
								        <?php
								        	$sql="SELECT * FROM ledgers WHERE type=1 ORDER BY ledger_desc ASC";
											$result=mysqli_query($con,$sql);
								            while($row=mysqli_fetch_array($result))
								            {
								            ?>
								            	<option value = "<?php echo $row['ledger_id'];?>" >
								                <?php echo($row['ledger_desc']) ?>
								            	</option>
								            <?php
								            }               
								        ?>
								    </select>
								</div>
								<div class="col-md-2 mb-2">
									<label for="nhismemberno_attd"><small><u>Membership No</u></small></label>
									<input type="text" class="form-control" name="nhismemberno_attd" id="nhismemberno_attd" value="">
								</div>
								<div class="col-md-2 mb-2">
									<label for="ghanacard_attd"><small><u>Ghana Card</u></small></label>
									<input type="text" class="form-control" name="ghanacard_attd" id="ghanacard_attd" value="">
								</div>
								<div class="col-md-2 mb-2">
									<label for="serial_no"><small><u>Serial no</u></small></label>
									<input type="text" class="form-control" name="serial_no" id="serial_no" value="">
								</div>
								<div class="col-md-2 mb-2">
									<label for="nhisexpirydate_attd"><small><u>Expiry Date</u></small></label>
									<input type="date" class="form-control" name="nhisexpirydate_attd" id="nhisexpirydate_attd" value="">
								</div>
								<div class="col-md-1 mb-1">
									<label for="dependant"><small><u>Dependant</u></small></label>
									<select class="form-control" name="dependant" id="dependant"> 
								    <option value="0">-Please Select-</option>
								    <option value="1">Yes</option>
								    <option value="2">No</option>
								    </select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-3 mb-3">
									<label for="specialty_attd_1"><small><u>Specialty (Primary)</u></small></label>
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
									<label for="spec_code_1"><small><u>Specialty Code</u></small></label>
									<input type="text" class="form-control" name="spec_code_1" id="spec_code_1">
								</div>
								<div class="col-md-3 mb-3">
									<label for="specialty_attd_2"><small><u>Specialty (Secondary)</u></small></label>
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
									<label for="spec_cod_2"><small><u>Specialty Code</u></small></label>
									<input type="text" class="form-control" name="spec_code_2" id="spec_code_2">
								</div>
								<div class="col-md-3 mb-3">
									<label for="specialty_attd_3"><small><u>Specialty (Tertiary)</u></small></label>
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
									<label for="spec_code_3"><small><u>Specialty Code</u></small></label>
									<input type="text" class="form-control" name="spec_code_3" id="spec_code_3">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-3 mb-3">
									<label for="type_of_attendnace"><small><u>Type Of Attendance</u></small></label>
									<select class="form-control" name="type_of_attendnace" id="type_of_attendnace"> 
								    	<option value="0">-Please Select-</option>
								    	<option value="chronic_follow_up">Chronic Follow-up</option>
								    	<option value="emergency_acute_episode">Emergency/Acute Episode</option>
								    	<option value="antenatal">Antenatal Care</option>
								    </select>
								</div>
								<div class="col-md-2 mb-2">
									<label for="date_of_claim"><small><u>Date of Claim</u></small></label>
									<input type="date" class="form-control" name="date_of_claim" id="date_of_claim">
								</div>
								<div class="col-md-1 mb-1">
									<label for="claim_no"><small><u>Claim No</u></small></label>
									<input type="text" class="form-control" name="claim_no" id="claim_no">
								</div>
								<div class="col-md-2 mb-2">
									<label for="pharmacy"><small><u>Pharmacy</u></small></label>
									<select class="form-control" name="pharmacy" id="pharmacy"> 
								    	<option value="0">Please Select</option>
								    	<option value="1">Pharmacy</option>
								    </select>
								</div>
								<div class="col-md-2 mb-2">
									<label for="type_of_service_2"><small><u>Type Of Service (b)</u></small></label>
									<select class="form-control" name="type_of_service_2" id="type_of_service_2"> 
								    	<option value="0">Please Select</option>
								    	<option value="all_inclusive">All Inclusive</option>
								    	<option value="unbundled">Unbundled</option>
								    </select>
								</div>
								<div class="col-md-1 mb-1">
									<label for="nhisccc"><small><u>CCC</u></small></label>
									<input type="text" class="form-control" name="nhisccc" id="nhisccc">
								</div>
								<div class="col-md-1 mb-1">
									<label for="spell"><small><u>Spell</u></small></label>
									<input type="text" class="form-control" name="spell" id="spell">
								</div>
							</div>
						</div>
						<div id="prvt_attd_details">
							<hr class="d-none d-md-block">
							<div class="form-row">
								<div class="col-md-4 mb-4">
									<label for="prtinsname_attd"><small><u>Private Insurance Name</u></small></label>
									<select class="form-control" name="prtinsname_attd" id="prtinsname_attd"> 
								    <option value="0">-Please Select-</option>
								        <?php
								        	$sql="SELECT * FROM ledgers WHERE type=2 ORDER BY ledger_desc ASC";
											$result=mysqli_query($con,$sql);
								            while($row=mysqli_fetch_array($result))
								            {
								            ?>
										            <option value = "<?php echo($row['ledger_id'])?>" >
										                <?php echo($row['ledger_desc']) ?>
										            </option>
								            <?php
								            }               
								        ?>
								    </select>
								</div>
								<div class="col-md-4 mb-4">
									<label for="prtmemberno_attd"><small><u>Membership No</u></small></label>
									<input type="text" class="form-control" name="prtmemberno_attd" id="prtmemberno_attd" value="">
								</div>
								<div class="col-md-4 mb-4">
									<label for="prtexpirydate_attd"><small><u>Expiry Date</u></small></label>
									<input type="date" class="form-control" name="prtexpirydate_attd" id="prtexpirydate_attd" value="">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>