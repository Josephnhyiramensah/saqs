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
		<?php 
			echo '<a id="btn_open_claim_form_all_items" href="#"
				data-id="'.$attend_id.'"
				data-id1="'.$patient_id.'"
				data-id2="'.$payment_type_id.'">
				<h4>Claim form</h4><small> - all items</small>
			</a>';
		?>
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
							            	$query_surgery_list = "SELECT * FROM surgery_list WHERE attend_id = '$attend_id' AND ledger_id=2 ORDER BY date ASC";
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
							            	$query_diagnosis_list = "SELECT * FROM diagnosis_list WHERE attend_id = '$attend_id' AND ledger_id=2 ORDER BY date ASC";
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
															data-id1="'.$_SESSION['age'].'"
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
							            	$query_lab_list = "SELECT * FROM lab_list WHERE attend_id = '$attend_id' AND ledger_id=2 ORDER BY date ASC";
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


<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/nhis_attendance_edit_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/nhis_diagnosis_edit_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/nhis_drug_edit_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/nhis_procedure_edit_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/nhis_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>