<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    //require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/functions.php');

	//If (isset($_SESSION['patient_id']))
	//{
		$attend_id = $_SESSION['attend_id'];
		$patient_id = $_SESSION['patient_id'];
		$folderno = $_SESSION['folderno'];
		$name = $_SESSION['name'];
		$age = $_SESSION['age'];
		$gender = $_SESSION['gender'];
		$Schname = $_SESSION['Schname'];
        $nhismemberno = $_SESSION['nhismemberno'];
        $nhisexpirydate = $_SESSION['nhisexpirydate'];
        $nhisccc = $_SESSION['nhisccc'];
        $prtinsname = $_SESSION['prtinsname'];
        $prtmemberno = $_SESSION['prtmemberno'];
        $prtexpirydate = $_SESSION['prtexpirydate'];
        $clinic = $_SESSION['clinic'];
        $typeofservice_attd = $_SESSION['typeofservice_attd'];
        $dateofadmission_attd = $_SESSION['dateofadmission_attd'];
        $dateofdischarge_attd = $_SESSION['dateofdischarge_attd'];
	//}
?>
<input type='hidden' id='session_attend_id' value="<?php echo $attend_id;?>">
<input type='hidden' id='session_patient_id' value="<?php echo $patient_id;?>">

<style type="text/css">
    .scroll-card-body {
            max-height: 700px;
            overflow-y: auto;
          }
  </style>
<div class="container-fluid scroll-card-body">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        		<small>Patient Attendance Details</small>
	            <h3 class="m-0 font-weight-bold text-primary">
	                <?php echo $name;?>
	            </h3>
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
							<img src="/img/patients/patient_image.jpg" class="img-rounded" width="100" height="100">
		                </td>
		                <td>
		                	<table id="attend_patient_table" width="100%">
			                    <tr>
			                    	<th>PATIENT</th>
			                    	<th>ATTENDANCE</th>
			                    	<th>CASH BILL</th>
			                    	<th>PRIVATE INSURANCE</th>
			                    	<th>NHIS</th>
			                    </tr>
			                    <tr>
			                    	<td><small><u>Patient No:</u><?php echo $patient_id;?></small></td>
			                    	<td><small><u>Attendance ID:</u><?php echo $attend_id;?></small></td>
			                    	<td><small><u>Cash Ledger:</u></small></td>
			                    	<td><small><u>Private Ins. Ledger:</u><?php echo $prtinsname;?></small></td>
			                    	<td><small><u>NHIS Ledger:</u><?php echo $Schname;?></small></td>
			                    </tr>
			                    <tr>
			            			<td><small><u>Folder No:</u><?php echo $folderno;?></small></td>
			            			<td><small><u>Date of Admission:</u><?php echo $dateofadmission_attd;?></small></td>
			            			<td><small><u>Cash Bill:</u></small></td>
			            			<td><small><u>Private Ins. Bill:</u></small></td>
			            			<td><small><u>NHIS Bill:</u></small></td>
			            		</tr>
			            		<tr>
			            			<td><small><u>Date of Birth:</u></small></td>
			            			<td><small><u>Date of Discharge:</u><?php echo $dateofdischarge_attd;?></small></td>
			            			<td><small><u>Cash Receipt:</u></small></td>
			            			<td><small><u>Private Ins. No:</u><?php echo $prtmemberno;?></small></td>
			            			<td><small><u>NHIS Membership No:</u><?php echo $nhismemberno;?></small></td>
			            		</tr>
			            		<tr>
			            			<td><small><u>Age:</u><?php echo $age;?></small></td>
			            			<td><small><u>Type of Service:</u><?php echo $typeofservice_attd;?></small></td>
			            			<td><small><u>Cash Discount:</u></small></td>
			            			<td><small><u>Private Ins. Exp. Date:</u><?php echo $prtexpirydate;?></small></td>
			            			<td><small><u>NHIS Exp. Date:</u><?php echo $nhisexpirydate;?></small></td>
			            		</tr>
			            		<tr>
			            			<td><small><u>Gender:</u><?php echo $gender?></small></td>
			            			<td><small><u>Clinic:</u><?php echo $clinic;?></small></td>
			            			<td><small><u>Cash Bill Bal:</u></small></td>
			            			<td></td>
			            			<td><small><u>NHIS CCC:</u><?php echo $nhisccc;?></small></td>
			            		</tr>
		                    </table>
		                </td>
		            </tr>
	            </table>
	        </div>
        </div>
        <div class="card-body">
        	<?php 
        		//include($_SERVER['DOCUMENT_ROOT'] .'/layout/patients/patient_profile.php');
			?>
			<form class="needs-validation" novalidate action="#" method="POST">
				<div class="accordion-option">
					<a href="javascript:void(0)" class="toggle-accordion active" accordion-id="#accordion"></a>
				</div>
				<div class="clearfix"></div>
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<?php 
						include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/vitals.php');
						include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/history.php');
						include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/diagnosis_attend.php');
						include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/labs_attend.php');
						include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/radio_attend.php');
						include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/drugs_attend.php');
						include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/surgery_attend.php');
						include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/treatment.php');
						include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/nurses_notes.php');
						include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/service.php');
						include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/dental.php');
						include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/eye.php');
					?>
				</div>
			</div>
        </div>
        <div class="footer">
			<a type="submit" href="/welcome.php" name="patientsavebtn" class="btn btn-primary btn-block">Home</a>
		</div>
			</form>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>