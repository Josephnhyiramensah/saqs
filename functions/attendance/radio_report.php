<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
?>
<input type='hidden' id='session_company_id' value="<?php echo $_SESSION['company_id'];?>">
<input type='hidden' id='session_user_super_id' value="<?php echo $_SESSION['user_super_id'];?>">
<input type='hidden' id='session_user_id' value="<?php echo $_SESSION['user_id'];?>">
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
    <?php 
        if(isset($_SESSION['attend_id']))
        {
            $company_id = $_SESSION['company_id'];
            $attend_id = $_SESSION['attend_id'];
            $patient_id = $_SESSION['patient_id'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);

            $sql_attend = "SELECT * FROM attendance WHERE attend_id = '$attend_id'";
            $result_attend = mysqli_query($con,$sql_attend);
            $row_attend = mysqli_fetch_array($result_attend);

            $query_patient = "SELECT * FROM patients WHERE patient_id ='$patient_id'";
            $query_run_patient = mysqli_query($con, $query_patient);
            $row_patient = mysqli_fetch_assoc($query_run_patient);

            $gender_id = $row_patient['gender'];
            $query_gender = "SELECT * FROM `gender` WHERE `gender_id` = '$gender_id'";
            $query_run_gender = mysqli_query($con, $query_gender);
            $row_gender = mysqli_fetch_assoc($query_run_gender);

            $tos_id = $row_attend['tos_id'];
            $query_tos = "SELECT * FROM `type_of_service` WHERE `tos_id` = '$tos_id'";
            $query_run_tos = mysqli_query($con, $query_tos);
            $row_tos = mysqli_fetch_assoc($query_run_tos);

            $clinic_id = $row_attend['clinic_id'];
            $sql_clinic="SELECT * FROM clinics WHERE  clinic_id='$clinic_id'";
			$result_clinic=mysqli_query($con,$sql_clinic);
	        $row_clinic=mysqli_fetch_array($result_clinic);
    ?>
    
			
        	<table width="100%" cellpadding="3" cellspacing="3">
        		<tr>
                    <td class="action-td" colspan="5"><h4><?php echo $row_company['trading_name'];?></h4></td>
                </tr>
                <tr>
                    <td class="action-td" colspan="5"><?php echo $row_company['address'];?></td>
                </tr>
                <tr>
                    <td class="action-td" colspan="5"><?php echo $row_company['telephone'];?></td>
                </tr>
                <tr>
                    <td class="action-td" colspan="5"><h3 class="modal-title m-0 font-weight-bold text-primary">Medical Radiology Report</h3></td>
                </tr>
	            <tr>
	            	<td width="15%" valign="top" align="center">
		                <?php
						/*if(!$patientInfo->picture){
							$picture = "avatar.png";	
						}else{
							$picture = $patientInfo->picture;
						}*/
						?>
						<img src="/img/patients/patient_image.jpg" class="img-rounded" width="100" height="100">
	                </td>
	                <td>
	                	<table width="100%">
		                    <tr>
		                    	<td colspan="5"><h6><strong><?php echo $row_patient['firstName'].' '. $row_patient['lastName'];?></strong></h6></td>
		                    </tr>
		                    <tr>
		                    	<tr>
		                    	<td><small><strong>Folder No:</strong><?php echo $row_patient['folderNo'];?></small></td>
		                    	<td><small><strong>Date of Birth:</strong><?php echo $row_patient['DOB'];?></small></td>
		                    	<td><small><strong>Age:</strong><?php echo $row_attend['age'];?></small></td>
		                    	<td><small><strong>Gender:</strong><?php echo $row_gender['gender'];?></small></td>
		                    </tr>
		                    <tr>
		            			<td><small><strong>Date of Admission:</strong><?php echo $row_attend['date_admit'];?></small></td>
		            			<td><small><strong>Date of Discharge:</strong><?php echo $row_attend['date_disch'];?></small></td>
		            			<td><small><strong>Type of Service:</strong><?php echo $row_tos['description'];?></small></td>
		            			<td><small><strong>Clinic:</strong><?php echo $row_clinic['clinic_desc'];?></small></td>
		            		</tr>
	                    </table>
	                </td>
	            </tr>
            </table>

 <?php 
 echo '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
	        <thead>
	        <tr>
                <th class="action-td" width="30%">Parameter</th>
                <th class="action-td" width="55%">Result</th>
                <th width="15%">Comment</th>
            </tr>	
	        </thead>
	        <tbody class="pv-table-body">';
	        	$query = "SELECT * FROM radio_list WHERE attend_id='$attend_id'";
				$query_run = mysqli_query($con, $query);
				if (mysqli_num_rows($query_run) > 0)
				{
					while($row_radio_list = mysqli_fetch_assoc($query_run))
					{
						$radio_id = $row_radio_list['radio_id'];
						$radio_list_id = $row_radio_list['radio_list_id'];
						$query = "SELECT * FROM radio_param_list WHERE radio_list_id='$radio_list_id'";
						    $query_run_radio_param_list = mysqli_query($con, $query);
						    if (mysqli_num_rows($query_run_radio_param_list) > 0)
								{
									$query = "SELECT * FROM radiology WHERE radio_id='$radio_id'";
		    						$query_run_radio = mysqli_query($con, $query);
		    						$row_radio=mysqli_fetch_assoc($query_run_radio);
		    						echo'
											<tr style="background-color:#E4E1E0">
								        		<td colspan="7">
													<strong>'.$row_radio['radiology'].'</strong>
												</td>
											</tr>';
								        
									while($row_radio_param_list = mysqli_fetch_assoc($query_run_radio_param_list))
									{
										$radio_param_id = $row_radio_param_list['radio_param_id'];
										$query = "SELECT * FROM radio_param WHERE radio_param_id='$radio_param_id'";
						    			$query_run_radio_param = mysqli_query($con, $query);
						    			$row_radio_param=mysqli_fetch_assoc($query_run_radio_param);
										echo'
												<tr>
									        		<td>
														'.$row_radio_param['radio_param'].'
													</td>
													<td>
														'.$row_radio_param_list['result'].'
													</td>
													<td>
														'.$row_radio_param_list['comment'].'
													</td>
									        	</tr>
									        	<tr>
												</tr>';
									};
								};
					};
		echo'</tbody>
		    </table>';
				};
	};
?>

<div>
    <br>
    <br>
    <br>
    <div class="float-right">
        <p>.......................................................................................</p><br>
        <p>SONOGRAPHER</p>
    </div>
</div>