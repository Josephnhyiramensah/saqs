<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    //include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_consulting.php');
   
		$attend_id = $_SESSION['nhis_claim_attend_id'];
		$patient_id = $_SESSION['nhis_claim_patient_id'];
		$payment_type_id = $_SESSION['nhis_claim_payment_type_id'];

        $sql_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
        $result_patient = mysqli_query($con,$sql_patient);
        $row_patient = mysqli_fetch_array($result_patient);

        $gender_id = $row_patient['gender'];
		$sql_gender="SELECT * FROM gender WHERE gender_id ='$gender_id'";
		$result_gender=mysqli_query($con,$sql_gender);
        $row_gender = mysqli_fetch_array($result_gender);
        $gender = $row_gender['gender'];
        
        $sql_attend = "SELECT * FROM attendance WHERE attend_id ='$attend_id'";
		$result_attend = mysqli_query($con,$sql_attend);
        $row_attend = mysqli_fetch_array($result_attend);

        $sql_pay_type = "SELECT * FROM payment_type WHERE pay_type_id ='$payment_type_id'";
		$result_pay_type = mysqli_query($con,$sql_pay_type);
        $row_pay_type = mysqli_fetch_array($result_pay_type);

?>

<style type="text/css">
    .scroll-card-body {
            max-height: 850px;
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
    		<h4>Claim form</h4>
        </div>
        <div class="card-body">
        	<div class="form-row">
        		<div class="col-md-12 mb-12">
        			<div class="card shadow md-4">
						<div class="card-header" style="background-color:#C3C1C1; color:white">
							<h5><strong>MEMBER DETAILS</strong></h5>
						</div>
						<div class="card-body">
							<div class="form-row">
				        		<div class="col-md-4 mb-4">
				        			<label for="surname">Surname</label>
									<input type="text" class="form-control bg-light" name="surname" id="surname" value="<?php echo $row_patient['lastName'];?>">
								</div>
				        		<div class="col-md-4 mb-4">
				        			<label for="other_name">Other Name</label>
									<input type="text" class="form-control bg-light" name="other_name" id="other_name" value="<?php echo $row_patient['firstName'];?>">
								</div>
				        		<div class="col-md-2 mb-2">
				        			<label for="gender">Gender</label>
									<input type="text" class="form-control bg-light" name="gender" id="gender" value="<?php echo $row_gender['gender'];?>">
								</div>
				        		<div class="col-md-2 mb-2">
				        			<label for="folder_no">Folder No</label>
									<input type="text" class="form-control bg-light" name="folder_no" id="folder_no" value="<?php echo $row_patient['folderNo'];?>">
								</div>
							</div>
							<div class="form-row">
				        		<div class="col-md-4 mb-4">
				        			<label for="member_no">Member No</label>
									<input type="text" class="form-control bg-light" name="member_no" id="member_no" value="<?php echo $row_pay_type['member_no'];?>">
								</div>
				        		<div class="col-md-2 mb-2">
				        			<label for="ccc">CCC</label>
									<input type="text" class="form-control bg-light" name="ccc" id="ccc" value="<?php echo $row_pay_type['code'];?>">
								</div>
				        		<div class="col-md-2 mb-2">
				        			<label for="folder_no">Folder No</label>
									<input type="text" class="form-control bg-light" name="folder_no" id="folder_no" value="<?php echo $row_patient['folderNo'];?>">
								</div>
				        		<div class="col-md-2 mb-2">
				        			<label for="date_of_birth">Date Of Birth</label>
									<input type="date" class="form-control bg-light" name="date_of_birth" id="date_of_birth" value="<?php echo $row_patient['DOB'];?>">
								</div>
				        		<div class="col-md-2 mb-2">
				        			<label for="age">Age</label>
									<input type="text" class="form-control bg-light" name="age" id="age" value="<?php echo $row_attend['age'];?>">
								</div>
							</div>
							<div class="form-row float-right">
								<a href="#" id="btn_nhis_attend_edit">Edit</a>
							</div>
						</div>
					</div>
        		</div>
			</div>
			<br>
			<div class="form-row">
        		<div class="col-md-4 mb-4">
        			<div class="card shadow md-4 h-100">
						<div class="card-header" style="background-color:#C3C1C1; color:white">
							<h5><strong>TYPE OF SERVICE</strong></h5>
						</div>
						<div class="card-body">
							<div class="form-row">
				        		<div class="col-md-12 mb-12">
				        			<div class="form-row">
							        <?php
							        	$tos_attend = $row_attend['tos_id'];
							        	$sql_tos="SELECT * FROM type_of_service ORDER BY description DESC";
										$result_tos = mysqli_query($con,$sql_tos);
							            while($row_tos = mysqli_fetch_array($result_tos))
							            {
							            	if ($tos_attend == $row_tos['tos_id']) 
							            	{
							            		echo '<div class="col-md-4 mb-4">
										        			<div class="form-check form-check-inline">
																<input class="form-check-input" type="radio" name="nhis_type_of_service[]" id="nhis_type_of_service" value = "'.$row_tos['tos_id'].'" checked>
																<label class="form-check-label" for="nhis_type_of_service">'.$row_tos['description'].'</label>
															</div>
														</div>';
							            	} else 
							            	{
							            		echo '<div class="col-md-4 mb-4">
										        			<div class="form-check form-check-inline">
																<input class="form-check-input" type="radio" name="nhis_type_of_service[]" id="nhis_type_of_service" value = "'.$row_tos['tos_id'].'">
																<label class="form-check-label" for="nhis_type_of_service">'.$row_tos['description'].'</label>
															</div>
														</div>';
							            	};
							            };
							        ?>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-row">
				        		<div class="col-md-12 mb-12">
							        <?php
					                	$type_of_serv_b = $row_pay_type['type_of_serv_b'];
				                    	if ($type_of_serv_b == 'all_inclusive') 
				                    	{
				                    		echo '
												<div class="form-row">
									        		<div class="col-md-6 mb-6">
									        			<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_service_b[]" id="nhis_type_of_service_b" value = "all_inclusive" checked>
														  <label class="form-check-label" for="nhis_type_of_service_b">
														    All Inclusive
														  </label>
														</div>
													</div>
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_service_b[]" id="nhis_type_of_service_b" value = "unbundled">
														  <label class="form-check-label" for="nhis_type_of_service_b">
														    Unbundled
														  </label>
														</div>
													</div>
												</div>';

				                    	} 
				                    	else if($type_of_serv_b == 'unbundled')
				                    	{
				                    		echo '
												<div class="form-row">
									        		<div class="col-md-6 mb-6">
									        			<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_service_b[]" id="nhis_type_of_service_b" value = "all_inclusive">
														  <label class="form-check-label" for="nhis_type_of_service_b">
														    All Inclusive
														  </label>
														</div>
													</div>
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_service_b[]" id="nhis_type_of_service_b" value = "unbundled" checked>
														  <label class="form-check-label" for="nhis_type_of_service_b">
														    Unbundled
														  </label>
														</div>
													</div>
												</div>';
				                    	}
				                    	else if($type_of_serv_b == '')
				                    	{
				                    		echo '
												<div class="form-row">
									        		<div class="col-md-6 mb-6">
									        			<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_service_b[]" id="nhis_type_of_service_b" value = "all_inclusive">
														  <label class="form-check-label" for="nhis_type_of_service_b">
														    All Inclusive
														  </label>
														</div>
													</div>
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_service_b[]" id="nhis_type_of_service_b" value = "unbundled">
														  <label class="form-check-label" for="nhis_type_of_service_b">
														    Unbundled
														  </label>
														</div>
													</div>
												</div>';
				                    	};
					                ?>
								</div>
							</div>
							<hr>
							<div class="form-row">
				        		<div class="col-md-12 mb-12">
				        			<?php
										if ($row_pay_type['pharmacy'] == 'pharmacy') 
							            {
								           echo '<div class="form-check">
												  <input class="form-check-input" type="checkbox" value="pharmacy" id="pharmacy" name="pharmacy[]" checked>
												  <label class="form-check-label" for="pharmacy">
												    Pharmacy
												  </label>
												</div>';
										}
										else
										{
											echo '<div class="form-check">
												  <input class="form-check-input" type="checkbox" value="pharmacy" id="pharmacy" name="pharmacy[]">
												  <label class="form-check-label" for="pharmacy">
												    Pharmacy
												  </label>
												</div>';
										};
									?>
								</div>
							</div>
							<div class="form-row float-right">
								<a href="#" id="btn_nhis_attend_edit">Edit</a>
							</div>
						</div>
					</div>
        		</div>
        		<div class="col-md-4 mb-4">
        			<div class="card shadow md-4 h-100">
						<div class="card-header" style="background-color:#C3C1C1; color:white">
							<h5><strong>SERVICE OUTCOME</strong></h5>
						</div>
						<div class="card-body">
							<div class="form-row">
				        		<div class="col-md-12 mb-12">
							        <?php
							        	if($row_attend['outcome'] == 'discharged')
							        	{
				                    		echo '<div class="form-row">
									        		<div class="col-md-4 mb-4">
									        			<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "transferred_out">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Transferred Out
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "died">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Died
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "absconded">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Absconded
														  </label>
														</div>
													</div>
												</div>
												<div class="form-row">
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "referred_out">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Referred Out
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "on_admission">
														  <label class="form-check-label" for="nhis_service_outcome">
														    On-Admission
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "discharged" checked>
														  <label class="form-check-label" for="nhis_service_outcome">
														    Discharged
														  </label>
														</div>
													</div>
												</div>
												<div class="form-row">
									        		<div class="col-md-12 mb-12">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "discharged_against_medical_advice">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Discharged Against Medical Advice
														  </label>
														</div>
													</div>
												</div>';
										}
										else if($row_attend['outcome'] == 'transferred_out')
										{
											echo '<div class="form-row">
									        		<div class="col-md-4 mb-4">
									        			<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "transferred_out"checked>
														  <label class="form-check-label" for="nhis_service_outcome">
														    Transferred Out
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "died">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Died
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "absconded">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Absconded
														  </label>
														</div>
													</div>
												</div>
												<div class="form-row">
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "referred_out">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Referred Out
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "on_admission">
														  <label class="form-check-label" for="nhis_service_outcome">
														    On-Admission
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "discharged">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Discharged
														  </label>
														</div>
													</div>
												</div>
												<div class="form-row">
									        		<div class="col-md-12 mb-12">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "discharged_against_medical_advice">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Discharged Against Medical Advice
														  </label>
														</div>
													</div>
												</div>';
										}
										else if($row_attend['outcome'] == 'died')
										{
											echo '<div class="form-row">
									        		<div class="col-md-4 mb-4">
									        			<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "transferred_out">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Transferred Out
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "died" checked>
														  <label class="form-check-label" for="nhis_service_outcome">
														    Died
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "absconded">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Absconded
														  </label>
														</div>
													</div>
												</div>
												<div class="form-row">
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "referred_out">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Referred Out
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "on_admission">
														  <label class="form-check-label" for="nhis_service_outcome">
														    On-Admission
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "discharged">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Discharged
														  </label>
														</div>
													</div>
												</div>
												<div class="form-row">
									        		<div class="col-md-12 mb-12">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "discharged_against_medical_advice">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Discharged Against Medical Advice
														  </label>
														</div>
													</div>
												</div>';
										}
										else if($row_attend['outcome'] == 'absconded')
										{
											echo '<div class="form-row">
									        		<div class="col-md-4 mb-4">
									        			<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "transferred_out">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Transferred Out
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "died">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Died
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "absconded" checked>
														  <label class="form-check-label" for="nhis_service_outcome">
														    Absconded
														  </label>
														</div>
													</div>
												</div>
												<div class="form-row">
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "referred_out">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Referred Out
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "on_admission">
														  <label class="form-check-label" for="nhis_service_outcome">
														    On-Admission
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "discharged">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Discharged
														  </label>
														</div>
													</div>
												</div>
												<div class="form-row">
									        		<div class="col-md-12 mb-12">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "discharged_against_medical_advice">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Discharged Against Medical Advice
														  </label>
														</div>
													</div>
												</div>';
										}
										else if($row_attend['outcome'] == 'referred_out')
										{
											echo '<div class="form-row">
									        		<div class="col-md-4 mb-4">
									        			<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "transferred_out">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Transferred Out
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "died">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Died
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "absconded">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Absconded
														  </label>
														</div>
													</div>
												</div>
												<div class="form-row">
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "referred_out" checked>
														  <label class="form-check-label" for="nhis_service_outcome">
														    Referred Out
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "on_admission">
														  <label class="form-check-label" for="nhis_service_outcome">
														    On-Admission
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "discharged">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Discharged
														  </label>
														</div>
													</div>
												</div>
												<div class="form-row">
									        		<div class="col-md-12 mb-12">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "discharged_against_medical_advice">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Discharged Against Medical Advice
														  </label>
														</div>
													</div>
												</div>';
										}
										else if($row_attend['outcome'] == 'on_admission')
										{
											echo '<div class="form-row">
									        		<div class="col-md-4 mb-4">
									        			<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "transferred_out">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Transferred Out
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "died">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Died
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "absconded">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Absconded
														  </label>
														</div>
													</div>
												</div>
												<div class="form-row">
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "referred_out">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Referred Out
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "on_admission" checked>
														  <label class="form-check-label" for="nhis_service_outcome">
														    On-Admission
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "discharged">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Discharged
														  </label>
														</div>
													</div>
												</div>
												<div class="form-row">
									        		<div class="col-md-12 mb-12">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "discharged_against_medical_advice">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Discharged Against Medical Advice
														  </label>
														</div>
													</div>
												</div>';
										}
										else if($row_attend['outcome'] == 'discharged_against_medical_advice')
										{
											echo '<div class="form-row">
									        		<div class="col-md-4 mb-4">
									        			<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "transferred_out">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Transferred Out
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "died">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Died
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "absconded">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Absconded
														  </label>
														</div>
													</div>
												</div>
												<div class="form-row">
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "referred_out">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Referred Out
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "on_admission">
														  <label class="form-check-label" for="nhis_service_outcome">
														    On-Admission
														  </label>
														</div>
													</div>
									        		<div class="col-md-4 mb-4">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "discharged">
														  <label class="form-check-label" for="nhis_service_outcome">
														    Discharged
														  </label>
														</div>
													</div>
												</div>
												<div class="form-row">
									        		<div class="col-md-12 mb-12">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_service_outcome[]" id="nhis_service_outcome" value = "discharged_against_medical_advice" checked>
														  <label class="form-check-label" for="nhis_service_outcome">
														    Discharged Against Medical Advice
														  </label>
														</div>
													</div>
												</div>';
										}
					                ?>
								</div>
							</div>
							<div class="form-row float-right">
				        		<div class="col-md-12 mb-12">
									<a href="#" id="btn_nhis_attend_edit">Edit</a>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 mb-12">
									<label for="nhis_attend_vetted"><strong>Vetted?</strong></label>
									<select class="form-control" name="nhis_attend_vetted" id="nhis_attend_vetted" data-id="<?php echo $attend_id;?>">
									<?php
										if($row_attend['vetted']=='Yes')
										{
											echo '<option value="No">No</option>
											<option value="Yes" selected="selected">Yes</option>';
										}
										else{
											echo '<option value="No" selected="selected">No</option>
											<option value="Yes">Yes</option>';
										};
									?>
									</select>
								</div>
							</div>
							<a href="#" id="btn_open_attend" data-id="<?php echo $row_attend['attend_id'];?>" data-id2="<?php echo $row_attend['patient_id'];?>">Open Attendance Sheet</a>
						</div>
					</div>
        		</div>
        		<div class="col-md-4 mb-4">
        			<div class="card shadow md-4 h-100">
						<div class="card-header" style="background-color:#C3C1C1; color:white">
							<h5><strong>DATE OF SERVICE</strong></h5>
						</div>
						<div class="card-body">
							<div class="form-row">
								<div class="col-md-12 mb-12">
									<label for="nhis_date_admit">Date Of Admission</label>
									<input type="date" class="form-control bg-light" name="nhis_date_admit" id="nhis_date_admit" value="<?php echo $row_attend['date_admit'];?>">
								</div>
							</div>
							<br>
							<div class="form-row">
								<div class="col-md-12 mb-12">
									<label for="nhis_date_disch">Date Of Discharge</label>
									<input type="date" class="form-control bg-light" name="nhis_date_disch" id="nhis_date_disch" value="<?php echo $row_attend['date_disch'];?>">
								</div>
							</div>
							<div class="form-row float-right">
							<a href="#" id="btn_nhis_attend_edit">Edit</a>
							</div>
						</div>
					</div>
        		</div>
			</div>
			<div class="form-row">
        		<div class="col-md-4 mb-4">
        			<div class="card shadow md-4 h-100">
						<div class="card-header" style="background-color:#C3C1C1; color:white">
							<h5><strong>TYPE OF ATTENDANCE</strong></h5>
						</div>
						<div class="card-body">
							<div class="form-row">
				        		<div class="col-md-12 mb-12">
							        <?php
							        	if ($row_pay_type['type_of_attend'] == 'chronic_follow_up') 
							            {
				                    		echo '<div class="form-row">
									        		<div class="col-md-6 mb-6">
									        			<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "chronic_follow_up" checked>
														  <label class="form-check-label" for="nhis_type_of_attendance">
														    Chronic Follow-up
														  </label>
														</div>
													</div>
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "emergency_acute_episode">
														  <label class="form-check-label" for="nhis_type_of_attendance">
														    Emergency/Acute Episode
														  </label>
														</div>
													</div>
												</div>
												<br>
												<div class="form-row">
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "antenatal">
														  <label class="form-check-label" for="nhis_type_of_attendance">
														    Antenatal Care
														  </label>
														</div>
													</div>
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "postnatal">
															  <label class="form-check-label" for="nhis_type_of_attendance">
															    Postnatal Care
															  </label>
														</div>
													</div>
												</div>';
										}
										else if($row_pay_type['type_of_attend'] == 'emergency_acute_episode')
										{
											echo '<div class="form-row">
									        		<div class="col-md-6 mb-6">
									        			<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "chronic_follow_up">
														  <label class="form-check-label" for="nhis_type_of_attendance">
														    Chronic Follow-up
														  </label>
														</div>
													</div>
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "emergency_acute_episode" checked>
														  <label class="form-check-label" for="nhis_type_of_attendance">
														    Emergency/Acute Episode
														  </label>
														</div>
													</div>
												</div>
												<br>
												<div class="form-row">
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "antenatal">
														  <label class="form-check-label" for="nhis_type_of_attendance">
														    Antenatal Care
														  </label>
														</div>
													</div>
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "postnatal">
															  <label class="form-check-label" for="nhis_type_of_attendance">
															    Postnatal Care
															  </label>
														</div>
													</div>
												</div>';
										}
										else if($row_pay_type['type_of_attend'] == 'antenatal')
										{
											echo '<div class="form-row">
									        		<div class="col-md-6 mb-6">
									        			<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "chronic_follow_up">
														  <label class="form-check-label" for="nhis_type_of_attendance">
														    Chronic Follow-up
														  </label>
														</div>
													</div>
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "emergency_acute_episode">
														  <label class="form-check-label" for="nhis_type_of_attendance">
														    Emergency/Acute Episode
														  </label>
														</div>
													</div>
												</div>
												<br>
												<div class="form-row">
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "antenatal" checked>
														  <label class="form-check-label" for="nhis_type_of_attendance">
														    Antenatal Care
														  </label>
														</div>
													</div>
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "postnatal">
															  <label class="form-check-label" for="nhis_type_of_attendance">
															    Postnatal Care
															  </label>
														</div>
													</div>
												</div>';
										}
										else if($row_pay_type['type_of_attend'] == 'postnatal')
										{
											echo '<div class="form-row">
									        		<div class="col-md-6 mb-6">
									        			<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "chronic_follow_up">
														  <label class="form-check-label" for="nhis_type_of_attendance">
														    Chronic Follow-up
														  </label>
														</div>
													</div>
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "emergency_acute_episode">
														  <label class="form-check-label" for="nhis_type_of_attendance">
														    Emergency/Acute Episode
														  </label>
														</div>
													</div>
												</div>
												<br>
												<div class="form-row">
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "antenatal">
														  <label class="form-check-label" for="nhis_type_of_attendance">
														    Antenatal Care
														  </label>
														</div>
													</div>
									        		<div class="col-md-6 mb-6">
														<div class="form-check form-check-inline">
															<input class="form-check-input" type="radio" name="nhis_type_of_attendance[]" id="nhis_type_of_attendance" value = "postnatal" chekced>
															  <label class="form-check-label" for="nhis_type_of_attendance">
															    Postnatal Care
															  </label>
														</div>
													</div>
												</div>';
										}
					                ?>
								</div>
							</div>
							<div class="form-row float-right">
								<a href="#" id="btn_nhis_attend_edit">Edit</a>
							</div>
						</div>
					</div>
        		</div>
        		<div class="col-md-4 mb-4">
        			<div class="card shadow md-4 h-100">
						<div class="card-header" style="background-color:#C3C1C1; color:white">
							<h5><strong>SPECIALTY ATTENDED</strong></h5>
						</div>
						<?php
							$specialty_attd_list = $row_pay_type['specialty_1'];
							$specialty_array = explode(',', $specialty_attd_list);
						?>
						<div class="card-body">
							<div class="form-row">
        						<div class="col-md-9 mb-9">
									<label for="nhis_specialty_description">Specialty Description</label>
									<select class="form-control" name="nhis_specialty_description" 
									id="nhis_specialty_description" data-id="<?php echo $row_pay_type['pay_type_id'];?>"
									data-id2="<?php echo $row_attend['tos_id'];?>"> 
										<option value="0">Please Select</option>
										<?php
											if($row_attend['age'] < 12)
											{
												$query = "SELECT nhis_item_desc, gdrg_child AS gdrg, price_child AS price, nhis_id 
												FROM nhis WHERE gdrg_child !='' AND category_id = 1 ORDER BY gdrg";
											}
											else
											{
												$query = "SELECT nhis_item_desc, gdrg_adult AS gdrg, price_adult AS price, nhis_id 
												FROM nhis WHERE gdrg_adult !='' AND category_id = 1 ORDER BY gdrg";
											};
											$result = mysqli_query($con,$query);
											while($row = mysqli_fetch_array($result))
											{
												if($row['nhis_id'] == $row_pay_type['specialty'])
												{
													echo '<option value = "'.$row['nhis_id'].'" selected="selected">'.$row['gdrg'].' - '.$row['nhis_item_desc'].'</option>';
												}
												else
												{
													echo '<option value = "'.$row['nhis_id'].'">'.$row['gdrg'].' - '.$row['nhis_item_desc'].'</option>';
												};
											};
										?>
									</select>
        						</div>
        						<div class="col-md-3 mb-3">
									<label for="nhis_specialty_code">Code</label>
									<input type="text" class="form-control" name="nhis_specialty_code" 
									id="nhis_specialty_code" disabled="true" value="<?php echo $row_pay_type['specialty_code'];?>">
        						</div>
        					</div>
							<div class="form-row">
        						<div class="col-md-3 mb-3">
									<div class="form-check">
							 			<?php
											if (in_array('ASUR', $specialty_array)) 
											{
												echo '<input class="form-check-input" type="checkbox" checked="checked" value="ASUR" id="ASUR" name="nhis_specialty_attended[]">';
											}
											else
											{
												echo '<input class="form-check-input" type="checkbox" value="ASUR" id="ASUR" name="nhis_specialty_attended[]">';
											};
										?>
									  <label class="form-check-label" for="ASUR">
									    ASUR
									  </label>
									</div>
        						</div>
        						<div class="col-md-3 mb-3">
									<div class="form-check">
										<?php
											if (in_array('DENT', $specialty_array)) 
											{
												echo '<input class="form-check-input" type="checkbox" checked="checked" value="DENT" id="DENT" name="nhis_specialty_attended[]">';
											}
											else
											{
												echo '<input class="form-check-input" type="checkbox" value="DENT" id="DENT" name="nhis_specialty_attended[]">';
											};
										?>
									  <label class="form-check-label" for="DENT">
									    DENT
									  </label>
									</div>
        						</div>
        						<div class="col-md-3 mb-3">
									<div class="form-check">
										<?php
											if (in_array('ENTH', $specialty_array)) 
											{
												echo '<input class="form-check-input" type="checkbox" checked="checked" value="ENTH" id="ENTH" name="nhis_specialty_attended[]">';
											}
											else
											{
												echo '<input class="form-check-input" type="checkbox" value="ENTH" id="ENTH" name="nhis_specialty_attended[]">';
											};
										?>
									  <label class="form-check-label" for="ENTH">
									    ENTH
									  </label>
									</div>
        						</div>
        						<div class="col-md-3 mb-3">
									<div class="form-check">
										<?php
											if (in_array('MEDI', $specialty_array)) 
											{
												echo '<input class="form-check-input" type="checkbox" checked="checked" value="MEDI" id="MEDI" name="nhis_specialty_attended[]">';
											}
											else
											{
												echo '<input class="form-check-input" type="checkbox" value="MEDI" id="MEDI" name="nhis_specialty_attended[]">';
											};
										?>
									  
									  <label class="form-check-label" for="MEDI">
									    MEDI
									  </label>
									</div>
        						</div>
        					</div>
							<div class="form-row">
        						<div class="col-md-3 mb-3">
									<div class="form-check">
										<?php
											if (in_array('OBGY', $specialty_array)) 
											{
												echo '<input class="form-check-input" type="checkbox" checked="checked" value="OBGY" id="OBGY" name="nhis_specialty_attended[]">';
											}
											else
											{
												echo '<input class="form-check-input" type="checkbox" value="OBGY" id="OBGY" name="nhis_specialty_attended[]">';
											};
										?>
									  <label class="form-check-label" for="OBGY">
									    OBGY
									  </label>
									</div>
        						</div>
        						<div class="col-md-3 mb-3">
									<div class="form-check">
										<?php
											if (in_array('OPDC', $specialty_array)) 
											{
												echo '<input class="form-check-input" type="checkbox" checked="checked" value="OPDC" id="OPDC" name="nhis_specialty_attended[]">';
											}
											else
											{
												echo '<input class="form-check-input" type="checkbox" value="OPDC" id="OPDC" name="nhis_specialty_attended[]">';
											};
										?>
									  <label class="form-check-label" for="OPDC">
									    OPDC
									  </label>
									</div>
        						</div>
        						<div class="col-md-3 mb-3">
									<div class="form-check">
										<?php
											if (in_array('OPHT', $specialty_array)) 
											{
												echo '<input class="form-check-input" type="checkbox" checked="checked" value="OPHT" id="OPHT" name="nhis_specialty_attended[]">';
											}
											else
											{
												echo '<input class="form-check-input" type="checkbox" value="OPHT" id="OPHT" name="nhis_specialty_attended[]">';
											};
										?>
									  <label class="form-check-label" for="OPHT">
									    OPHT
									  </label>
									</div>
        						</div>
        						<div class="col-md-3 mb-3">
									<div class="form-check">
										<?php
											if (in_array('ORTH', $specialty_array)) 
											{
												echo '<input class="form-check-input" type="checkbox" checked="checked" value="ORTH" id="ORTH" name="nhis_specialty_attended[]">';
											}
											else
											{
												echo '<input class="form-check-input" type="checkbox" value="ORTH" id="ORTH" name="nhis_specialty_attended[]">';
											};
										?>
									  
									  <label class="form-check-label" for="ORTH">
									    ORTH
									  </label>
									</div>
        						</div>
        					</div>
							<div class="form-row">
        						<div class="col-md-3 mb-3">
									<div class="form-check">
										<?php
											if (in_array('PAED', $specialty_array)) 
											{
												echo '<input class="form-check-input" type="checkbox" checked="checked" value="PAED" id="PAED" name="nhis_specialty_attended[]">';
											}
											else
											{
												echo '<input class="form-check-input" type="checkbox" value="PAED" id="PAED" name="nhis_specialty_attended[]">';
											};
										?>
									  <label class="form-check-label" for="PAED">
									    PAED
									  </label>
									</div>
        						</div>
        						<div class="col-md-3 mb-3">
									<div class="form-check">
										<?php
											if (in_array('PSUR', $specialty_array)) 
											{
												echo '<input class="form-check-input" type="checkbox" checked="checked" value="PSUR" id="PSUR" name="nhis_specialty_attended[]">';
											}
											else
											{
												echo '<input class="form-check-input" type="checkbox" value="PSUR" id="PSUR" name="nhis_specialty_attended[]">';
											};
										?>
									  <label class="form-check-label" for="PSUR">
									    PSUR
									  </label>
									</div>
        						</div>
        						<div class="col-md-3 mb-3">
									<div class="form-check">
										<?php
											if (in_array('RSUR', $specialty_array)) 
											{
												echo '<input class="form-check-input" type="checkbox" checked="checked" value="RSUR" id="RSUR" name="nhis_specialty_attended[]">';
											}
											else
											{
												echo '<input class="form-check-input" type="checkbox" value="RSUR" id="RSUR" name="nhis_specialty_attended[]">';
											};
										?>
									  <label class="form-check-label" for="RSUR">
									    RSUR
									  </label>
									</div>
        						</div>
        					</div>
							<div class="form-row float-right">
								<a href="#" id="btn_nhis_attend_edit">Edit</a>
							</div>
						</div>
					</div>
        		</div>
        		<div class="col-md-4 mb-4">
        			<div class="card shadow md-4 h-100">
						<div class="card-header" style="background-color:#C3C1C1; color:white">
							<h5><strong>REFERRAL INFO</strong></h5>
						</div>
						<div class="card-body">
							<div class="form-row">
								<div class="col-md-12 mb-12">
									<label for="nhis_referring_facility">Referring Facility Name</label>
									<input type="text" class="form-control bg-light" name="nhis_referring_facility" id="nhis_referring_facility" value="">
								</div>
							</div>
							<br>
							<div class="form-row">
								<div class="col-md-12 mb-12">
									<label for="nhis_referral_ccc">Referral Code/ CCC</label>
									<input type="text" class="form-control bg-light" name="nhis_referral_ccc" id="nhis_referral_ccc" value="">
								</div>
							</div>
							<div class="form-row float-right">
								<a href="#" id="btn_nhis_attend_edit">Edit</a>
							</div>
						</div>
					</div>
        		</div>
			</div>
        	<div class="form-row">
        		<div class="col-md-12 mb-12">
        			<div class="card shadow md-4">
						<div class="card-header" style="background-color:#C3C1C1; color:white">
							<h5><strong>PROCEDURES</strong></h5>
						</div>
						<div class="card-body">
							<div class="table-responsive" id="nhis_procedures_table">
							    <table class="table table-hover table-bordered table-sm" id="nhis_proceduresTable" width="100%" cellspacing="0">
							        <thead>
							            <tr>
							                <th class="action-td" width="10%"><h6><strong>G-DRG</strong></h6></th>
							                <th width="30%"><h6><strong>Group</strong></h6></th>
							                <th width="30%"><h6><strong>Procedure - <small><a href="#" data-id="<?php echo $attend_id;?>" data-id="<?php echo $patient_id;?>" id="btn_nhis_procedure_add">Add Procedure</a></small>
											</strong></h6></th>
							                <th class="action-td" width="10%"><h6><strong>ICD-10</strong></h6></th>
							                <th class="action-td" width="5%"><h6><strong>IsPrincipal</strong></h6></th>
							                <th class="action-td" width="10%"><h6><strong>Date</strong></h6></th>
							                <th class="action-td" width="5%"><h6><strong>Action</strong></h6></th>
							            </tr>
							        </thead>
							        <tbody class="pv-table-body">
							            <?php
											$pi = 0;
							            	$query_surgery_list = "SELECT * FROM surgery_list WHERE attend_id = '$attend_id' ORDER BY date ASC";
    										$query_run_surgery_list = mysqli_query($con, $query_surgery_list);
							                if (mysqli_num_rows($query_run_surgery_list) > 0)
							                {
							                	while($row_surgery_list = mysqli_fetch_assoc($query_run_surgery_list))
		                    					{
	    											$surgery_id = $row_surgery_list['surgery_id'];
							                    	$query_surgery = "SELECT * FROM surgery WHERE surgery_id='$surgery_id'";
													$query_run_surgery = mysqli_query($con, $query_surgery);
													$row_surgery = mysqli_fetch_assoc($query_run_surgery);
								        			if($row_attend['tos_id'] == 2)
	    											{
														$nhis_id = $row_surgery_list['nhis_id'];
													}
													else
													{
														$nhis_id = $row_pay_type['specialty'];
													};
							                    	$query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
													$query_run_nhis = mysqli_query($con, $query_nhis);
													$row_nhis = mysqli_fetch_assoc($query_run_nhis);
													if($row_attend['age'] < 12)
													{
														$gdrg = $row_nhis['gdrg_child'];
													}
													else
													{
														$gdrg = $row_nhis['gdrg_adult'];
													};
													echo '<tr>
														<td class="action-td">'.$gdrg.'</td>
														<td>'.$row_nhis['nhis_item_desc'].'</td>
														<td>'.$row_surgery['surgery'].'</td>
														<td class="action-td">'.$row_surgery['icd_10'].'</td>
														<td class="action-td">'.$row_surgery_list['is_principal'].'</td>
														<td class="action-td">'.$row_surgery_list['date'].'</td>
														<td class="action-td">
															<a 
																href="#" 
																data-id="'.$row_surgery_list['surgery_list_id'].'" 
																id="btn_nhis_procedure_edit"
															>Edit</a>';
															if($row_surgery_list['user_id'] == $_SESSION['user_id'])
															{
																echo ' | <a 
																data-id="'.$row_surgery_list['surgery_list_id'].'" 
																href="#" 
																id="btn_nhis_procedure_delete"
															>Delete</a>';
															};
														echo '</td>
													</tr>';
							            		};
							                };
							            ?>
							        </tbody>
							    </table>
							</div>
						</div>
					</div>
        		</div>
			</div>
			<br>
        	<div class="form-row">
        		<div class="col-md-12 mb-12">
        			<div class="card shadow md-4">
						<div class="card-header" style="background-color:#C3C1C1; color:white">
							<h5><strong>DIAGNOSES</strong></h5>
						</div>
						<div class="card-body">
							<div class="table-responsive" id="nhis_diagnoses_table">
							    <table class="table table-hover table-bordered table-sm" id="nhis_diagnosesTable" width="100%" cellspacing="0">
							        <thead>
							            <tr>
							                <th width="60%"><h6><strong>Diagnosis - <small><a href="#" data-id="<?php echo $attend_id;?>" data-id="<?php echo $patient_id;?>" id="btn_nhis_diagnosis_add">Add Diagnosis</a></small></strong></h6></th>
							                <th class="action-td" width="10%"><h6><strong>ICD-10</strong></h6></th>
							                <th class="action-td" width="10%"><h6><strong>G-DRG</strong></h6></th>
							                <th class="action-td" width="10%"><h6><strong>IsPrincipal</strong></h6></th>
							                <th class="action-td" width="10%"><h6><strong>Action</strong></h6></th>
							            </tr>
							        </thead>
							        <tbody class="pv-table-body">
							            <?php
							            	$query_diagnosis_list = "SELECT * FROM diagnosis_list WHERE attend_id = '$attend_id' ORDER BY date ASC";
    										$query_run_diagnosis_list = mysqli_query($con, $query_diagnosis_list);
							                if (mysqli_num_rows($query_run_diagnosis_list) > 0)
							                {
							                	while($row_diagnosis_list = mysqli_fetch_assoc($query_run_diagnosis_list))
		                    					{
	    											$diagnosis_id = $row_diagnosis_list['diagnosis_id'];
							                    	$query_diagnosis = "SELECT * FROM diagnosis WHERE diagnosis_id='$diagnosis_id'";
													$query_run_diagnosis = mysqli_query($con, $query_diagnosis);
													$row_diagnosis = mysqli_fetch_assoc($query_run_diagnosis);
								        			if($row_attend['tos_id'] == 2 || $row_attend['tos_id'] == "2")
	    											{
														$nhis_id = $row_diagnosis['nhis_id'];
													}
													else
													{
														$nhis_id = $row_pay_type['specialty'];
													};
							                    	$query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
													$query_run_nhis = mysqli_query($con, $query_nhis);
													$row_nhis = mysqli_fetch_assoc($query_run_nhis);

								                echo'<tr>
									            	<td>'.$row_diagnosis['diagnosis'].'</td>
								                    <td class="action-td">'.$row_diagnosis['icd_10'].'</td>
								                    <td class="action-td">';
								                    if(isset($nhis_id) && $nhis_id > 0)
								                    {
								                    	if($row_attend['age'] > 11){echo $row_nhis['gdrg_adult'];}else{echo $row_nhis['gdrg_child'];};
								                    }
								                    else
								                    {
								                    	echo 'N/A';
								                    };
								                    
								                echo'</td>
								                	<td class="action-td">'.$row_diagnosis_list['is_principal'].'</td>
								                    <td class="action-td">
														<a 
															data-id="'.$row_diagnosis_list['diagnosis_list_id'].'" 
															id="btn_nhis_diagnosis_edit" href="#">Edit
														</a>';
														if($row_diagnosis_list['user_id'] == $_SESSION['user_id'])
														{
															echo ' | <a 
															data-id="'.$row_diagnosis_list['diagnosis_list_id'].'" 
															href="#" 
															id="btn_nhis_diagnosis_delete"
														>Delete</a>';
														};
													echo '</td>
								                </tr>';
							            
							            		};
							                };
							            ?>
							        </tbody>
							    </table>
							</div>
						</div>
					</div>
        		</div>
			</div>
			<br>
        	<div class="form-row">
        		<div class="col-md-12 mb-12">
        			<div class="card shadow md-4">
						<div class="card-header" style="background-color:#C3C1C1; color:white">
							<h5><strong>INVESTIGATIONS</strong></h5>
						</div>
						<div class="card-body">
							<div class="table-responsive" id="nhis_investigations_table">
							    <table class="table table-hover table-bordered table-sm" id="nhis_investigationsTable" width="100%" cellspacing="0">
							        <thead>
							            <tr>
							                <th width="60%"><h6><strong>Investigation - <small><a href="#" data-id="<?php echo $attend_id;?>" data-id="<?php echo $patient_id;?>" id="btn_nhis_lab_add">Add Lab</a></small></strong></h6></th>
							                <th class="action-td" width="20%"><h6><strong>G-DRG</strong></h6></th>
							                <th class="action-td" width="10%"><h6><strong>Date</strong></h6></th>
							                <th class="action-td" width="10%"><h6><strong>Action</strong></h6></th>
							            </tr>
							        </thead>
							        <tbody class="pv-table-body">
							            <?php
							            	$query_lab_list = "SELECT * FROM lab_list WHERE attend_id = '$attend_id' ORDER BY date ASC";
    										$query_run_lab_list = mysqli_query($con, $query_lab_list);
							                if (mysqli_num_rows($query_run_lab_list) > 0)
							                {
							                	while($row_lab_list = mysqli_fetch_assoc($query_run_lab_list))
		                    					{
	    											$lab_id = $row_lab_list['lab_id'];
							                    	$query_lab = "SELECT * FROM lab WHERE lab_id='$lab_id'";
													$query_run_lab = mysqli_query($con, $query_lab);
													$row_lab = mysqli_fetch_assoc($query_run_lab);
								        			
	    											$nhis_id = $row_lab['nhis_id'];
							                    	$query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
													$query_run_nhis = mysqli_query($con, $query_nhis);
													$row_nhis = mysqli_fetch_assoc($query_run_nhis);

								                echo'<tr>
									            	<td>'.$row_lab['lab'].'</td>
								                    <td class="action-td">';
								                    if(isset($nhis_id) && $nhis_id > 0)
								                    {
								                    	echo $row_nhis['gdrg'];
								                    }
								                    else
								                    {
								                    	echo 'N/A';
								                    };
								                    
								                echo'</td>
								                	<td class="action-td">'.$row_lab_list['date'].'</td>
								                    <td class="action-td"><a href="#">Edit</a></td>
								                </tr>';
							            
							            		};
							                };
							            ?>
							        </tbody>
							    </table>
							</div>
						</div>
					</div>
        		</div>
			</div>
			<br>
        	<div class="form-row">
        		<div class="col-md-12 mb-12">
        			<div class="card shadow md-4">
						<div class="card-header" style="background-color:#C3C1C1; color:white">
							<h5><strong>MEDICINES</strong></h5>
						</div>
						<div class="card-body">
							<div class="table-responsive" id="nhis_medicines_table">
							    <table class="table table-hover table-bordered table-sm" id="nhis_medicinesTable" width="100%" cellspacing="0">
							        <thead>
							            <tr>
							                <th width="40%"><h6><strong>Drug - <small><a href="#" data-id="<?php echo $attend_id;?>" data-id="<?php echo $patient_id;?>" id="btn_nhis_drug_add">Add Drug</a></small></strong></h6></th>
							                <th class="action-td" width="5%"><h6><strong>Qty</strong></h6></th>
							                <th class="amt-td" width="5%"><h6><strong>Price</strong></h6></th>
							                <th class="amt-td" width="10%"><h6><strong>Amount</strong></h6></th>
							                <th class="action-td" width="10%"><h6><strong>Date</strong></h6></th>
							                <th class="action-td" width="15%"><h6><strong>Dosage</strong></h6></th>
							                <th class="action-td" width="5%"><h6><strong>Code</strong></h6></th>
							                <th class="action-td" width="5%"><h6><strong>Action</strong></h6></th>
							            </tr>
							        </thead>
							        <tbody class="pv-table-body">
							            <?php
											$total_drugs = 0;
							            	$query_drug_dispense_list = "SELECT * FROM drug_dispense_list WHERE attend_id = '$attend_id' AND 
											ledger_id = 2 ORDER BY date ASC";
    										$query_run_drug_dispense_list = mysqli_query($con, $query_drug_dispense_list);
							                if (mysqli_num_rows($query_run_drug_dispense_list) > 0)
							                {
							                	while($row_drug_dispense_list = mysqli_fetch_assoc($query_run_drug_dispense_list))
		                    					{
	    											$drug_id = $row_drug_dispense_list['drug_id'];
							                    	$query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
													$query_run_drug = mysqli_query($con, $query_drug);
													$row_drug = mysqli_fetch_assoc($query_run_drug);
								        			
	    											$nhis_id = $row_drug['nhis_id'];
							                    	$query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
													$query_run_nhis = mysqli_query($con, $query_nhis);
													$row_nhis = mysqli_fetch_assoc($query_run_nhis);

													$total_drugs = $total_drugs + $row_drug_dispense_list['amt_nhis'];
													echo'<tr>
														<td>'.$row_drug['brand_name'].'</td>
														<td class="action-td">'.$row_drug_dispense_list['qty_nhis'].'</td>
														<td class="amt-td">'.$row_drug_dispense_list['price_nhis'].'</td>
														<td class="amt-td">'.$row_drug_dispense_list['amt_nhis'].'</td>
														<td class="action-td">'.$row_drug_dispense_list['date'].'</td>
														<td class="action-td">'.$row_drug_dispense_list['dosage'].'</td>
														<td class="action-td">';
															if(isset($nhis_id) && $nhis_id > 0)
															{
																echo $row_nhis['gdrg'];
															}
															else
															{
																echo 'N/A';
															};
														echo'</td>
														<td class="action-td">
															<a data-id="'.$row_drug_dispense_list['drug_disp_list_id'].'" href="#" id="btn_nhis_drug_edit">Edit</a>';
															if($row_drug_dispense_list['user_id'] == $_SESSION['user_id'])
															{
																echo ' | <a 
																data-id="'.$row_drug_dispense_list['drug_disp_list_id'].'" 
																data-id2="'.$row_drug_dispense_list['drug_list_id'].'" 
																href="#" 
																id="btn_nhis_drug_delete"
															>Delete</a>';
															};
														echo '</td>
													</tr>';
							            		};
							                };
							            ?>
							        </tbody>
							    </table>
							</div>
						</div>
					</div>
        		</div>
			</div>
			<br>
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
											<label for="nhis_summary_label"><strong>Type Of Service</strong></label>
										</div>
										<div class="col-md-4 mb-4">
											<label for="nhis_summary_code_labe"><strong>G-DRG/Code</strong></label>
										</div>
										<div class="col-md-4 mb-4">
											<label for="nhis_summary_tariff_label"><strong>Tariff Amount</strong></label>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-4 mb-4">
											<label for="nhis_ipd_label">A. In-Patient</label>
										</div>
										<div class="col-md-4 mb-4">
											<input type="text" class="form-control bg-light text-center" name="nhis_ipd_code" id="nhis_ipd_code" value="<?php echo $row_pay_type['gdrg_in_patient'];?>">
										</div>
										<div class="col-md-4 mb-4">
											<input type="text" class="form-control bg-light text-right" name="nhis_ipd_total" id="nhis_ipd_total" value="<?php echo $row_pay_type['amt_in_patient'];?>">
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-4 mb-4">
											<label for="nhis_opd_label">B. Out-Patient</label>
										</div>
										<div class="col-md-4 mb-4">
											<input type="text" class="form-control bg-light text-center" name="nhis_opd_code" id="nhis_opd_code" value="<?php echo $row_pay_type['gdrg_out_patient'];?>">
										</div>
										<div class="col-md-4 mb-4">
											<input type="text" class="form-control bg-light text-right" name="nhis_opd_total" id="nhis_opd_total" value="<?php echo $row_pay_type['amt_out_patient'];?>">
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-4 mb-4">
											<label for="nhis_invest_label">C. Investigations</label>
										</div>
										<div class="col-md-4 mb-4">
											<input type="text" class="form-control bg-light text-center" name="nhis_invest_code" id="nhis_invest_code" value="">
										</div>
										<div class="col-md-4 mb-4">
											<input type="text" class="form-control bg-light text-right" name="nhis_invest_total" id="nhis_invest_total" value="<?php echo $row_pay_type['amt_invest'];?>">
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-4 mb-4">
											<label for="nhis_pharmacy_label">D. Pharmacy</label>
										</div>
										<div class="col-md-4 mb-4">
											<input type="text" class="form-control bg-light text-center" name="nhis_pharmacy_code" id="nhis_pharmacy_code" value="">
										</div>
										<div class="col-md-4 mb-4">
											<input type="text" class="form-control bg-light text-right" name="nhis_pharmacy_total" id="nhis_pharmacy_total" value="<?php echo $total_drugs;?>">
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-4 mb-4">
											<label for="nhis_total_amount">E. Claim Total</label>
										</div>
										<div class="col-md-4 mb-4">
										</div>
										<div class="col-md-4 mb-4">
											<input type="text" class="form-control bg-light text-right" name="nhis_total_amount" id="nhis_total_amount" value="<?php echo $row_pay_type['amt_out_patient'] + $row_pay_type['amt_in_patient'] + $row_pay_type['amt_invest'] + $total_drugs;?>">
										</div>
									</div>
								</div>
								<div class="col-md-6 mb-6">
									<div class="form-row">
										<div class="col-md-4 mb-4">
											<label for="nhis_principal_gdrg"><strong>Principal G-DRG</strong></label>
										</div>
									</div>
									<?php 
										/*$sql_pay_type = "SELECT * FROM payment_type WHERE pay_type_id ='$payment_type_id'";
										$result_pay_type = mysqli_query($con,$sql_pay_type);
										$row_pay_type = mysqli_fetch_array($result_pay_type);*/
									?>
									<div class="form-row">
										<div class="col-md-8 mb-8">
											<select class="form-control" name="nhis_principal_desc" id="nhis_principal_desc"> 
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
											<input type="text" class="form-control bg-light text-center" name="nhis_principal_gdrg" 
											id="nhis_principal_gdrg" value="<?php echo $row_pay_type['principal_amt'];?>">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
        		</div>
			</div>
		</div>
	    <!--<div class="card-footer">
		</div>-->
	</div>
</div>
<!--<div class="modal fade bd-example-modal-xl" id="nhis_attend_detail_modal" tabindex="-1" role="dialog" aria-labelledby="nhis_attend_detail_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="nhis_attend_detail_modal_title">Drug Administration</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<form id="nhis_attend_detail_form" method="POST">
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="drug_id_da">Drug Description</label>
							<select class="form-control" name="drug_id_dp" id="drug_id_da" hidden> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM drugs ORDER BY brand_name ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						        ?>
						            <option value = "<?php echo($row['drug_id'])?>" >
						                <?php echo($row['brand_name']) ?>
						            </option>
						        <?php
						            }
						        ?>
					    	</select>
					    	<select class="form-control" name="drug_id_da2" id="drug_id_da2" disabled="true"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM drugs ORDER BY brand_name ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						        ?>
						            <option value = "<?php echo($row['drug_id'])?>" >
						                <?php echo($row['brand_name']) ?>
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
			</div>
		</div>
	</div>
</div>-->

<div 
class="modal fade bd-example-modal-xl" 
id="nhis_procedure_detail_modal" 
tabindex="-1" role="dialog" 
aria-labelledby="nhis_procedure_detail_modal" 
aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="nhis_procedure_detail_modal_title">Procedure Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="nhis_procedure_detail_form" method="POST">
					<input type="text" class="form-control" name="nhis_surgerylist_id" id="nhis_surgerylist_id" hidden="true">
					<input type="text" class="form-control" name="nhis_procedure_amount_cash" id="nhis_procedure_amount_cash" hidden="true">
					<input type="text" class="form-control" name="nhis_procedure_amount_prvt" id="nhis_procedure_amount_prvt" hidden="true">
					<input type="text" class="form-control" name="nhis_procedure_attend_id" id="nhis_procedure_attend_id" value="<?php echo $attend_id;?>" hidden="true">
					<input type="text" class="form-control" name="nhis_procedure_patient_id" id="nhis_procedure_patient_id" value="<?php echo $patient_id;?>" hidden="true">
					<input type="text" class="form-control" name="nhis_procedure_payment_type_id" id="nhis_procedure_payment_type_id" value="<?php echo $payment_type_id;?>" hidden="true">
					<div class="form-row">
						<div class="col-md-2 mb-2">
							<label for="nhis_procedure_gdrg">G-DRG</label>
							<select class="form-control" name="nhis_procedure_gdrg" id="nhis_procedure_gdrg"> 
					    		<option value="0">Please Select</option>
						        <?php
									$query_gdrg = "SELECT nhis_item_desc, gdrg_adult AS gdrg, price_adult AS price, nhis_id FROM nhis WHERE gdrg_adult !=''
									UNION ALL SELECT nhis_item_desc, gdrg_child AS gdrg, price_child AS price, nhis_id FROM nhis WHERE gdrg_child !=''";
									$result_gdrg = mysqli_query($con,$query_gdrg);
									while($row_gdrg = mysqli_fetch_array($result_gdrg))
									{
										echo '<option value = "'.$row_gdrg['nhis_id'].'">'.$row_gdrg['gdrg'].' - '.$row_gdrg['nhis_item_desc'].'</option>';
									};
						        ?>
					    	</select>
						</div>
						<div class="col-md-8 mb-8">
							<label for="nhis_procedure_description">Description</label>
							<input type="text" class="form-control" name="nhis_procedure_description" id="nhis_procedure_description" disabled="true">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_procedure_amount">Amount</label>
							<input type="text" class="form-control" name="nhis_procedure_amount" id="nhis_procedure_amount" hidden="true">
							<input type="text" class="form-control" name="nhis_procedure_amountD" id="nhis_procedure_amountD" disabled="true">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="nhis_procedure_diagnosis">Procedure</label>
							<select class="form-control" name="nhis_procedure_diagnosis" id="nhis_procedure_diagnosis"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM surgery ORDER BY surgery ASC";
									$result = mysqli_query($con,$sql);
						            while($row = mysqli_fetch_array($result))
						            {
										echo'<option value = "'.$row['surgery_id'].'">
											'.$row['surgery'].'
										</option>';
						            };
						        ?>
					    	</select>
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_procedure_icd_10">ICD-10</label>
							<input type="text" class="form-control" name="nhis_procedure_icd_10" id="nhis_procedure_icd_10" disabled ="true">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_procedure_date">Date</label>
							<input type="date" class="form-control" name="nhis_procedure_date" id="nhis_procedure_date">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_procedure_is_principal">Is Principal</label>
							<select class="form-control" name="nhis_procedure_is_principal" id="nhis_procedure_is_principal"> 
					    		<option value="0">Please Select</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="nhis_procedure_comment">Comment</label>
							<textarea type="textarea" rows="2"  class="form-control" name="nhis_procedure_comment" id="nhis_procedure_comment" value=""></textarea>
						</div>
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" id="btn_nhis_procedure_save" class="btn btn-primary">Save</button>
					<button type="button" id="btn_nhis_procedure_update" class="btn btn-primary">Update</button>
				    <button type="button" id="btn_nhis_procedure_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div 
class="modal fade bd-example-modal-xl" 
id="nhis_diagnosis_detail_modal" 
tabindex="-1" role="dialog" 
aria-labelledby="nhis_diagnosis_detail_modal" 
aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="nhis_diagnosis_detail_modal_title">Diagnosis Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="nhis_diagnosis_detail_form" method="POST">
					<input type="text" class="form-control" name="nhis_diagnosislist_id" id="nhis_diagnosislist_id" hidden="true">
					<input type="text" class="form-control" name="nhis_diagnosis_amount_cash" id="nhis_diagnosis_amount_cash" hidden="true">
					<input type="text" class="form-control" name="nhis_diagnosis_amount_prvt" id="nhis_diagnosis_amount_prvt" hidden="true">
					<input type="text" class="form-control" name="nhis_diagnosis_attend_id" id="nhis_diagnosis_attend_id" value="<?php echo $attend_id;?>" hidden="true">
					<input type="text" class="form-control" name="nhis_diagnosis_patient_id" id="nhis_diagnosis_patient_id" value="<?php echo $patient_id;?>" hidden="true">
					<input type="text" class="form-control" name="nhis_diagnosis_payment_type_id" id="nhis_diagnosis_payment_type_id" value="<?php echo $payment_type_id;?>" hidden="true">
					<div class="form-row">
						<div class="col-md-2 mb-2">
							<label for="nhis_diagnosis_gdrg">G-DRG</label>
							<select class="form-control" name="nhis_diagnosis_gdrg" id="nhis_diagnosis_gdrg"> 
					    		<option value="0">Please Select</option>
						        <?php
									$query_gdrg = "SELECT nhis_item_desc, gdrg_adult AS gdrg, price_adult AS price, nhis_id FROM nhis WHERE gdrg_adult !=''
									UNION ALL SELECT nhis_item_desc, gdrg_child AS gdrg, price_child AS price, nhis_id FROM nhis WHERE gdrg_child !=''";
									$result_gdrg = mysqli_query($con,$query_gdrg);
									while($row_gdrg = mysqli_fetch_array($result_gdrg))
									{
										echo '<option value = "'.$row_gdrg['nhis_id'].'">'.$row_gdrg['gdrg'].' - '.$row_gdrg['nhis_item_desc'].'</option>';
									};
						        ?>
					    	</select>
						</div>
						<div class="col-md-8 mb-8">
							<label for="nhis_diagnosis_description">Description</label>
							<input type="text" class="form-control" name="nhis_diagnosis_description" id="nhis_diagnosis_description" disabled="true">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_diagnosis_amount">Amount</label>
							<input type="text" class="form-control" name="nhis_diagnosis_amount" id="nhis_diagnosis_amount" hidden="true">
							<input type="text" class="form-control" name="nhis_diagnosis_amountD" id="nhis_diagnosis_amountD" disabled="true">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="nhis_diagnosis_id">Diagnosis</label>
							<select class="form-control" name="nhis_diagnosis_id" id="nhis_diagnosis_id"> 
					    		<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM diagnosis ORDER BY diagnosis ASC";
									$result = mysqli_query($con,$sql);
						            while($row = mysqli_fetch_array($result))
						            {
										echo'<option value = "'.$row['diagnosis_id'].'">
											'.$row['diagnosis'].'
										</option>';
						            };
						        ?>
					    	</select>
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_diagnosis_icd_10">ICD-10</label>
							<input type="text" class="form-control" name="nhis_diagnosis_icd_10" id="nhis_diagnosis_icd_10" disabled ="true">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_diagnosis_date">Date</label>
							<input type="date" class="form-control" name="nhis_diagnosis_date" id="nhis_diagnosis_date">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_diagnosis_is_principal">Is Princiapl</label>
							<select class="form-control" name="nhis_diagnosis_is_principal" id="nhis_diagnosis_is_principal"> 
					    		<option value="0">Please Select</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="nhis_diagnosis_comment">Comment</label>
							<textarea type="textarea" rows="2"  class="form-control" name="nhis_diagnosis_comment" id="nhis_diagnosis_comment" value=""></textarea>
						</div>
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" id="btn_nhis_diagnosis_save" class="btn btn-primary">Save</button>
					<button type="button" id="btn_nhis_diagnosis_update" class="btn btn-primary">Update</button>
				    <button type="button" id="btn_nhis_diagnosis_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div 
class="modal fade bd-example-modal-xl" 
id="nhis_drug_detail_modal" 
tabindex="-1" role="dialog" 
aria-labelledby="nhis_drug_detail_modal" 
aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="nhis_drug_detail_modal_title">Drug Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="nhis_drug_detail_form" method="POST">
					<input type="text" class="form-control" name="drug_disp_list_id" id="drug_disp_list_id" hidden="true">
					<input type="text" class="form-control" name="nhis_drug_price_cash" id="nhis_drug_price_cash" hidden="true">
					<input type="text" class="form-control" name="nhis_drug_amount_cash" id="nhis_drug_amount_cash" hidden="true">
					<input type="text" class="form-control" name="nhis_drug_price_prvt" id="nhis_drug_price_prvt" hidden="true">
					<input type="text" class="form-control" name="nhis_drug_amount_prvt" id="nhis_drug_amount_prvt" hidden="true">
					<input type="text" class="form-control" name="nhis_drug_attend_id" id="nhis_drug_attend_id" hidden="true"value="<?php echo $attend_id;?>">
					<input type="text" class="form-control" name="nhis_drug_patient_id" id="nhis_drug_patient_id" hidden="true"value="<?php echo $patient_id;?>">
					<input type="text" class="form-control" name="nhis_drug_payment_type_id" id="nhis_drug_payment_type_id" value="<?php echo $payment_type_id;?>" hidden="true">
					<div class="form-row">
						<div class="col-md-9 mb-9">
							<label for="nhis_drug_id">Drug</label>
							<select class="form-control" name="nhis_drug_id" id="nhis_drug_id"> 
					    		<option value="0">Please Select</option>
						        <?php
									$query_drug = "SELECT * FROM drugs ORDER BY brand_name ASC";
									$result_drug = mysqli_query($con,$query_drug);
									while($row_drug = mysqli_fetch_array($result_drug))
									{
										echo '<option value = "'.$row_drug['drug_id'].'">'.$row_drug['brand_name'].'</option>';
									};
						        ?>
					    	</select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="nhis_drug_code">Code</label>
							<input type="text" class="form-control" name="nhis_drug_code" id="nhis_drug_code" disabled="true">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4 mb-4">
							<label for="nhis_drug_dosage">Dosage</label>
							<input type="text" class="form-control" name="nhis_drug_dosage" id="nhis_drug_dosage">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_drug_date">Date</label>
							<input type="date" class="form-control" name="nhis_drug_date" id="nhis_drug_date">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_drug_qty">Qty</label>
							<input type="text" class="form-control" name="nhis_drug_qty" id="nhis_drug_qty">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_drug_price">Price</label>
							<input type="text" class="form-control" name="nhis_drug_price" id="nhis_drug_price">
						</div>
						<div class="col-md-2 mb-2">
							<label for="nhis_drug_amount">Amount</label>
							<input type="text" class="form-control" name="nhis_drug_amount" id="nhis_drug_amount" hidden="true">
							<input type="text" class="form-control" name="nhis_drug_amountD" id="nhis_drug_amountD" disabled="true">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="nhis_drug_comment">Comment</label>
							<textarea type="textarea" rows="2"  class="form-control" name="nhis_drug_comment" id="nhis_drug_comment"></textarea>
						</div>
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" id="btn_nhis_drug_save" class="btn btn-primary">Save</button>
					<button type="button" id="btn_nhis_drug_update" class="btn btn-primary">Update</button>
				    <button type="button" id="btn_nhis_drug_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

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
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/nhis_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>