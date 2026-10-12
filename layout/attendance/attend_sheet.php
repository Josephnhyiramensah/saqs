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

?>
<input type='hidden' id='session_attend_id' value="<?php echo $attend_id;?>">
<input type='hidden' id='session_patient_id' value="<?php echo $patient_id;?>">

<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">
                <?php echo $name;?>
            </h3>
        	<div class="table-responsive no-padding">
	        	<table width="100%" cellpadding="3" cellspacing="3">
		            <tr>
		                <td>
		                	<table id="attend_patient_table" width="100%">
			                    <tr>
			                    	<td><u>Folder No:</u><?php echo $folderno;?></td>
			                    	<td><u>Date of Birth:</u></td>
			                    	<td><u>Age:</u><?php echo $age;?></td>
			                    	<td><u>Gender:</u><?php echo $gender?></td>
			                    </tr>
			                    <tr>
			            			<td><u>Date of Admission:</u><?php echo $dateofadmission_attd;?></td>
			            			<td><u>Date of Discharge:</u><?php echo $dateofdischarge_attd;?></td>
			            			<td><u>Type of Service:</u><?php echo $typeofservice_attd;?></td>
			            			<td><u>Clinic:</u><?php echo $clinic;?></td>
			            		</tr>
		                    </table>
		                </td>
		            </tr>
	            </table>
	        </div>
        </div>
        <div class="card-body">

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