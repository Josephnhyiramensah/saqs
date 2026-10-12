<div class="card shadow md-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary" id="patient_create_form_title">
                Patient Setup
            </h3>
        </div>
        <div class="card-body">
			<form class="needs-validation" method="POST" enctype="multipart/form-data" novalidate id="patient_create_form">
				<div class="accordion-option">
					<a href="javascript:void(0)" class="toggle-accordion active" accordion-id="#accordion"></a>
				</div>
				<div class="clearfix"></div>
				  	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				    		<div class="panel panel-default">
					      		<div class="panel-heading" role="tab" id="headingOne">
					        		<h6 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										<h5 class="m-0 font-weight-bold text-primary">Personal Details</h5>
										</a>
					      			</h6>
					      		</div>
				      			<div id="response"></div>
								<?php 
									if(isset($folder_no)){$folder_no=$folder_no;}else{$folder_no='';};
									if(isset($new_number)){$new_number=$new_number;}else{$new_number='';};
								?>
								<div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
									<div class="panel-body">
										<div class="form-row">
											<div class="col-md-10 mb-10">
												<div class="form-row">
													<div class="col-md-2 mb-2">
														<label for="folderNo">Folder No</label>
														<input type="text" name="folderNo" class="form-control" id="folderNo" value="<?php echo $folder_no;?>" required>
														<input type="hidden" name="number" class="form-control" id="number" value="<?php echo $new_number;?>">
														<input type="hidden" name="patient_id" class="form-control" id="patient_id">
													</div>
													<div class="col-md-5 mb-4">
														<label for="firstName">First Name</label>
														<input type="text" name="firstName" class="form-control" id="firstName" value="" required>
													</div>
													<div class="col-md-5 mb-4">
														<label for="lastName">Last Name</label>
														<input type="text" name="lastName" class="form-control" id="lastName" value="" required>
													</div>
												</div>
												<div class="form-row">
													<div class="col-md-2 mb-2">
														<label for="DOB">Date Of Birth</label>
														<input type="date" name="DOB" class="form-control" id="DOB" value="">
													</div>
													<div class="col-md-2 mb-2">
														<label for="age">Age</label>
														<input type="text" name="age" class="form-control" id="age" value="">
													</div>
													<div class="col-md-2 mb-2">
														<label for="gender">Gender</label>
														<select class="form-control" name="gender" id="gender" required="">
															<option value="0">-Select Gender-</option>
															<?php
																$sql="SELECT * FROM gender WHERE gender_id < 3 ORDER BY gender ASC";
																$result=mysqli_query($con,$sql);
																while($row=mysqli_fetch_array($result))
																{
																	echo '<option value = "'.$row['gender_id'].'">'.$row['gender'].'</option>';
																};
															?>
														</select>
													</div>
													<div class="col-md-3 mb-3">
														<label for="marital">Marital Status</label>
															<select class="form-control" name="marital_status" id="marital_status">
																<option value="0">-Select Status-</option>
																<option value="Single">Single</option>
																<option value="Married">Married</option>
																<option value="Seperated">Seperated</option>
																<option value="Divorced">Divorced</option>
																<option value="Widowed">Widowed</option>
															</select>
													</div>
													<div class="col-md-3 mb-3">
														<label for="ghanacard">Ghanacard</label>
														<input type="text" name="ghanacard" class="form-control" id="ghanacard">
													</div>
												</div>
												<div class="form-row">
													<div class="col-md-3 mb-2">
														<label for="address">Address</label>
														<input type="text" class="form-control" name="address" id="address">
													</div>
													<div class="col-md-3 mb-2">
														<label for="city">City</label>
														<input type="text" class="form-control" name="city" id="city">
													</div>
													<div class="col-md-3 mb-2">
														<label for="telephone">Telephone</label>
														<input type="text" class="form-control" name="telephone" id="telephone">
													</div>
													<div class="col-md-3 mb-2">
														<label for="telephone">Email</label>
														<input type="text" class="form-control" name="email" id="email">
													</div>
												</div>
												<div class="form-row">
													<div class="col-md-6 mb-6">
														<label for="patient_country">Birth Country</label>
														<select class="form-control bg-light" name="patient_country" id="patient_country"> 
															<option value="0">Please Select</option>
															<?php
																$sql="SELECT * FROM country ORDER BY country ASC";
																$result=mysqli_query($con,$sql);
																while($row=mysqli_fetch_array($result))
																{
																	if($row['country_id']==87)
																	{
																		echo '<option value = "'.$row['country_id'].'" selected="selected">'.$row['country'].'</option>';
																	}
																	else
																	{
																		echo '<option value = "'.$row['country_id'].'">'.$row['country'].'</option>';
																	};
																};
															?>
														</select>
													</div>
													<div class="col-md-6 mb-6">
														<label for="patient_nationality">Nationality</label>
														<input type="text" class="form-control" name="patient_nationality" id="patient_nationality" value="Ghanaian" hidden="true">
														<input type="text" class="form-control" name="patient_nationalityD" id="patient_nationalityD" value="Ghanaian" disabled="true">
													</div>
												</div>
											</div>
											<div class="col-md-2 mb-2">
												<div class="card shadow md-4">
													<div class="card-body">
														<img id="patient_image" src="/img/patients/patient_image.jpg" class="img-responsive img-thumbnail" />
														<input type="hidden" name="size" value="1000000">
														<div class="custom-file">
															<input type="file" class="custom-file-input" id="patient_photo_file">
															<label class="custom-file-label" for="patient_photo"><small>Choose file</small></label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-3 mb-3">
												<label for="nhismemberno">Membership No</label>
												<input type="text" name="nhismemberno" class="form-control" id="nhismemberno">
											</div>
											<div class="col-md-9 mb-9">
												<label for="scheme_id">Sponsor</label>
												<select class="form-control bg-light" name="scheme_id" id="scheme_id"> 
													<option value="0">Please Select</option>
													<?php
														$sql="SELECT * FROM ledgers WHERE tb_5=1 OR tb_5=12 OR tb_5=13 ORDER BY ledger_desc ASC";
														$result = mysqli_query($con,$sql);
														while($row = mysqli_fetch_array($result))
														{
															echo '<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
														};
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>

							<hr class="d-none d-md-block">

				    		<div class="panel panel-default">
					      		<div class="panel-heading" role="tab" id="headingThree">
					        		<h6 class="panel-title">
					        			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
											<h5 class="m-0 font-weight-bold text-primary">Relative Details</h5>
					        			</a>
					      			</h6>
					      		</div>
				      			<div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
				        			<div class="panel-body">
                						<div class="form-row">
							    				<div class="col-md-4 mb-3">
													<label for="relname">Relative Name</label>
													<input type="text" class="form-control" name="relname" id="relname">
							    				</div>
                          						<div class="col-md-4 mb-3">
													<label for="rellocation">Location</label>
													<input type="text" class="form-control" name="rellocation" id="rellocation">
							    				</div>
							    				<div class="col-md-4 mb-3">
													<label for="reltelephone">Telephone</label>
													<input type="text" class="form-control" name="reltelephone" id="reltelephone">
							    				</div>
										</div>
				        			</div>
				      			</div>
				    		</div>
							
							<hr class="d-none d-md-block">

							<!--<div class="panel panel-default">
					      		<div class="panel-heading" role="tab" id="headingTwo">
					        		<h6 class="panel-title">
					        				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
												<h5 class="m-0 font-weight-bold text-primary">Past Medical Records</h5>
					        				</a>
					      			</h6>
					      		</div>
								<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
									<div class="panel-body">
										<div class="form-row">
											<div class="col-md-3 mb-2">
												<label for="Allergies">Allergies</label>
												<textarea type="textarea" rows="4" class="form-control" name="Allergies" id="Allergies" value=""></textarea>
											</div>
											<div class="col-md-3 mb-2">
												<label for="MedicalHistory">Medical History</label>
												<textarea type="textarea" rows="4"  class="form-control" name="MedicalHistory" id="MedicalHistory" value=""></textarea>
											</div>
											<div class="col-md-3 mb-2">
												<label for="FamilyHistory">Family History</label>
												<textarea type="textarea" rows="4" class="form-control" name="FamilyHistory" id="FamilyHistory" value=""></textarea>
											</div>
											<div class="col-md-3 mb-2">
												<div class="form-row">
													<div class="col-md-6 mb-3">
														<label for="BloodGroup">Blood Group</label>
														<select class="form-control" name="BloodGroup" id="BloodGroup">
																<option value="0">-Select Status-</option>
																<option value="A+">A+</option>
																<option value="A-">A-</option>
																<option value="B+">B+</option>
																<option value="B-">B-</option>
																<option value="O+">O+</option>
																<option value="O-">O-</option>
																<option value="AB+">AB+</option>
																<option value="AB-">AB-</option>
															</select>
													</div>
													<div class="col-md-6 mb-3">
														<label for="G6PD">G6PD</label>
														<input type="text" class="form-control" name="G6PD" id="G6PD" value="">
													</div>
												</div>
												<div class="form-row">
													<div class="col-md-6 mb-3">
														<label for="geno_type">Geno Type</label>
														<input type="text" class="form-control" name="geno_type" id="geno_type" value="">
													</div>
													<div class="col-md-6 mb-3">
														<label for="sickling">Sickling</label>
														<input type="text" class="form-control" name="sickling" id="sickling" value="">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<hr class="d-none d-md-block">-->

				    		<!--<div class="panel panel-default">
					    		<div class="panel-heading" role="tab" id="headingFour">
						        	<h6 class="panel-title">
							        	<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
											<h5 class="m-0 font-weight-bold text-primary">Payment Details</h5>
							        	</a>
						      		</h6>
					    		</div>
					      		<div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour">
									<div class="panel-body">
										<div class="form-row">
											<div class="col-md-4 mb-4">
												<label for="Schname">NHIS Name</label>
												<select class="form-control" name="Schname" id="Schname"> 
											    <option value="0">-Please Select-</option>
											        <?php
											        	$sql="SELECT * FROM ledgers WHERE type=1 ORDER BY ledger_desc ASC";
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
											<div class="col-md-3 mb-3">
												<label for="nhismemberno">Membership NO</label>
												<input type="text" class="form-control" name="nhismemberno" id="nhismemberno">
											</div>
											<div class="col-md-3 mb-3">
												<label for="ghanacard">Ghana Card No</label>
												<input type="text" class="form-control" name="ghanacard" id="ghanacard">
											</div>
											<div class="col-md-2 mb-2">
												<label for="nhisexpirydate">Expiry Date</label>
												<input type="date" class="form-control" name="nhisexpirydate" id="nhisexpirydate">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-5 mb-5">
												<label for="serial_no_set">Serial No(Set)</label>
												<div class="input-group">
												  <input type="hidden" class="form-control w-25" name="sn_regional_code" id="sn_regional_code">
												  <input type="text" class="form-control w-25" name="sn_regional_code_2" id="sn_regional_code_2" disabled="true">
												  <select class="form-control w-25" name="sn_scheme_code" id="sn_scheme_code"> 
											    <option value="">Select</option>
											        <?php
											        	$sql="SELECT scheme_code FROM scheme ORDER BY scheme_name ASC";
														$result=mysqli_query($con,$sql);
											            while($row=mysqli_fetch_array($result))
											            {
											            ?>
											            <option value = "<?php echo($row['scheme_code'])?>" >
											                <?php echo($row['scheme_code']) ?>
											            </option>
											            <?php
											            }               
											        ?>
											    </select>
												  <input type="text" class="form-control w-50" name="sn_member" id="sn_member">
												</div>
											</div>
											<div class="col-md-3 mb-3">
												<label for="serial_no">Serial No</label>
												<input type="hidden" class="form-control" name="serial_no" id="serial_no">
												<input type="text" class="form-control" name="serial_no_2" id="serial_no_2" disabled="true">
											</div>
											<div class="col-md-4 mb-4">
												<label for="scheme_name">Scheme Name</label>
												<input type="text" class="form-control" name="scheme_name" id="scheme_name" disabled="true">
												<input type="hidden" class="form-control" name="scheme_id" id="scheme_id">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-6 mb-6">
												<label for="prtinsname">Private Insurance Name</label>
												<select class="form-control" name="prtinsname" id="prtinsname"> 
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
											<div class="col-md-3 mb-3">
												<label for="prtmemberno">Membership No</label>
												<input type="text" class="form-control" name="prtmemberno" id="prtmemberno">
											</div>
											<div class="col-md-3 mb-3">
												<label for="prtexpirydate">Expiry Date</label>
												<input type="date" class="form-control" name="prtexpirydate" id="prtexpirydate">
											</div>
										</div>
									</div>
					      		</div>
				    		</div>-->
					</div>
			</form>
        </div>
        <div class="modal-footer">
        	<div id="patient_save_update">
        		<button type="submit" name="patient_save_btn" id="patient_save_btn" class="btn btn-primary">Save</button>
        	</div>
			<button type="button" name="patient_cancel_btn" id="patient_cancel_btn" class="btn btn-danger">Cancel</button>
		</div>
</div>