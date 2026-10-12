<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
    $query = "SELECT * FROM dental_history WHERE attend_id='$attend_id'";
	$query_run = mysqli_query($con, $query);
?>
<div id="dental_hx">
	<ul class="nav nav-tabs nav-justified">
		<li class="nav-item active"><a class="nav-link" aria-current="page" data-toggle="tab" href="#patient_hx">Patient History</a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#assessment">Assessment</a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#chart" id="dental_chart">Chart</a></li>
	</ul>
	<div class="tab-content">
		<div id="patient_hx" class="tab-pane fade show active">
			<?php
                if (mysqli_num_rows($query_run) > 0)
                {
                	$row=mysqli_fetch_assoc($query_run);
                	if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['  
						Edit_Dental'] == 'Yes')) 
					{
            			echo'<button type="button" name="edit_patient_hx_btn" id="edit_patient_hx_btn" class="btn btn-secondary" data-id="'.$row['dent_hx_id'].'">Edit Patient Hx</button>';
            		};
                }
                else 
                {
            		if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Dental'] == 'Yes')) 
					{
            			echo'<button type="button" name="add_patient_hx_btn" id="add_patient_hx_btn" class="btn btn-primary">Add Patient Hx</button>';
            		};
                };
            ?>
			
			<div class="table-responsive" id="patient_hx_table">
			    <table class="table table-hover table-bordered table-sm" id="patienthxTable" width="100%" cellspacing="0">
			        <thead>
			            <tr style="background-color:#C3C1C1; color:white">
			                <th width="20%">Question</th>
			                <th width="10%">Response</th>
			                <th width="20%">Question</th>
			                <th width="10%">Response</th>
			                <th width="20%">Question</th>
			                <th width="10%">Response</th>
			            </tr>
			        </thead>
			        <tbody class="pv-table-body">
			            <?php
			                if (mysqli_num_rows($query_run) > 0)
			                {
			            ?>
			                <tr>
				            	<td><small>1. DO YOUR GUMS BLEED WHILE BRUSHING OR FLOSSING:</small></td>
			                    <td><?php echo $row['1'];?></td>
			                    <td><small>2. ARE YOUR TEETH SENSITIVE TO HOT OR COLD LIQUIDS/FOODS:</small></td>
			                    <td><?php echo $row['2'];?></td>
			                    <td><small>3. ARE YOUR TEETH SENSITIVE TO SWEET OR SOUR FOODS:</small></td>
			                    <td><?php echo $row['3'];?></td>
			                </tr>
			                <tr>
			                    <td><small>4. DO YOU FEEL PAIN IN ANY OF YOUR TEETH:</small></td>
			                    <td><?php echo $row['4'];?></td>
			                    <td><small>5. DO YOU HAVE ANY SORES OR LUMPS IN OR NEAR YOUR MOUTH:</small></td>
			                    <td><?php echo $row['5'];?></td>
			                    <td><small>6. HAVE YOU EVER EXPERIENCED ANY OF THE FOLLOWING PROBLEMS IN YOUR JAW?:</small></td>
			                    <td><?php echo $row['6'];?></td>
			                </tr>
			                <tr>
			                    <td><small>7. CLICKING:</small></td>
			                    <td><?php echo $row['7'];?></td>
			                    <td><small>8. PAIN (JOINT, EAR, SIDE OF FACE):</small></td>
			                    <td><?php echo $row['8'];?></td>
			                    <td><small>9. DO YOU HAVE FREQUENT HEADACHES:</small></td>
			                    <td><?php echo $row['9'];?></td>
			                </tr>
			                <tr>
			                    <td><small>10. DO YOU CLENCH OR GRIND YOUR TEETH:</small></td>
			                    <td><?php echo $row['10'];?></td>
			                    <td><small>11. HAVE YOU NOTICED ANY LOOSENING OF YOUR TEETH:</small></td>
			                    <td><?php echo $row['11'];?></td>
			                    <td><small>12. DOES FOOD TEND TO BECOME CAUGHT BETWEEN YOUR TEETH:</small></td>
			                    <td><?php echo $row['12'];?></td>
			                </tr>
			                <tr>
			                    <td><small>13. HAVE YOU EVER HAD PERIODONTAL TREATMENT:</small></td>
			                    <td><?php echo $row['13'];?></td>
			                    <td><small>14. HAVE YOU EVER WORN ANY APPLIANCE:</small></td>
			                    <td><?php echo $row['14'];?></td>
			                    <td><small>15. ARE YOU USING OR EVER USED DENTURE:</small></td>
			                    <td><?php echo $row['15'];?></td>
			                </tr>
			                <tr>
			                    <td><small>16. HAVE YOU EVER HAD ANY DIFFICULT EXTRACTIONS IN THE PAST:</small></td>
			                    <td><?php echo $row['16'];?></td>
			                    <td><small>17. HAVE YOU EVER HAD ANY PROLONGED BLEEDING FOLLOWING EXTRACTIONS OR CUTS:</small></td>
			                    <td><?php echo $row['17'];?></td>
			                    <td><small>18. HAVE YOU EVER RECEIVED ORAL HYGIENE INSTRUCTIONS REGARDING THE CARE OF YOUR TEETH AND GUMS:</small></td>
			                    <td><?php echo $row['18'];?></td>
			                </tr>
			                <tr>
			                	<td colspan = "6"><strong>ARE YOU ALLERGIC TO OR HAVE YOU HAD REACTIONS TO</strong></td>
			                </tr>
			                <tr>
			                    <td><small>1. LOCAL ANAESTHETIC LIKE LIDOCAINE:</small></td>
			                    <td><?php echo $row['19'];?></td>
			                    <td><small>2. PENICILLINS OR OTHER ANTIBIOTICS:</small></td>
			                    <td><?php echo $row['20'];?></td>
			                </tr>
			                <tr>
			                    <td><small>3. OTHER (PLEASE LIST):</small></td>
			                    <td colspan = "5"><?php echo $row['21'];?></td>
			                </tr>
			                <tr>
			                	<td colspan = "6"><strong>DO YOU HAVE OR EVER HAD THE FOLLOWING</strong></td>
			                </tr>
			                <tr>
			                    <td><small>1. HEART ATTACK/HEART PROBLEM/CHESTPAIN:</small></td>
			                    <td><?php echo $row['22'];?></td>
			                    <td><small>2. SICKLE CELL DISEASE:</small></td>
			                    <td><?php echo $row['23'];?></td>
			                    <td><small>3. HIGH/LOW BLOOD PRESSURE:</small></td>
			                    <td><?php echo $row['24'];?></td>
			                </tr>
			                <tr>
			                    <td><small>4. HEPATITIS:</small></td>
			                    <td><?php echo $row['25'];?></td>
			                    <td><small>5. LUNG OR BREATHING PROBLEM:</small></td>
			                    <td><?php echo $row['26'];?></td>
			                    <td><small>6. FAINTING OF DIZZY SPELLS:</small></td>
			                    <td><?php echo $row['27'];?></td>
			                </tr>
			                <tr>
			                    <td><small>7. DIABETES:</small></td>
			                    <td><?php echo $row['28'];?></td>
			                    <td><small>8. STOMACH ULCER:</small></td>
			                    <td><?php echo $row['29'];?></td>
			                    <td><small>9. PERSISTENT COUGH:</small></td>
			                    <td><?php echo $row['30'];?></td>
			                </tr>
			                <tr>
			                    <td><small>10. EPILEPSY OR SEIZURES:</small></td>
			                    <td><?php echo $row['31'];?></td>
			                </tr>
			                <tr>
			                    <td><small>11. OTHERS:</small></td>
			                    <td colspan = "5"><?php echo $row['32'];?></td>
			                </tr>
			                <tr>
			                	<td colspan = "6"><strong>FOR WOMEN ONLY</strong></td>
			                </tr>
			                <tr>
			                    <td><small>1. ARE YOU PREGNANT OR THINK YOU MAY BE PREGNANT:</small></td>
			                    <td><?php echo $row['33'];?></td>
			                    <td><small>2. ARE YOU NURSING:</small></td>
			                    <td><?php echo $row['34'];?></td>
			                    <td><small>3. ARE YOU TAKING BIRTH CONTROL PILLS:</small></td>
			                    <td><?php echo $row['35'];?></td>
			                </tr>
			            <?php
			                };
			            ?>
			        </tbody>
			    </table>
			</div>
		</div>
		<div id="assessment" class="tab-pane fade">
		    <div id="dental_assessment">
				<ul class="nav nav-tabs nav-justified">
					<li class="nav-item active"><a class="nav-link" aria-current="page" data-toggle="tab" href="#assessment_current">Current Assessment</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#assessment_history">Assessment History</a></li>
				</ul>
				<div class="tab-content">
					<div id="assessment_current" class="tab-pane fade show active">
						<div id="dental_assessment_current">
							<ul class="nav nav-tabs nav-justified">
								<li class="nav-item active"><a class="nav-link" aria-current="page" data-toggle="tab" href="#extra_oral_current">Extra Oral</a></li>
								<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#intra_oral_current">Intra Oral</a></li>
							</ul>
							<div class="tab-content">
								<div id="extra_oral_current" class="tab-pane fade show active">
						            <?php
						            	$query_ac = "SELECT * FROM dental_assess_extra_oral WHERE attend_id='$attend_id' AND patient_id='$patient_id'";
										$query_run_ac = mysqli_query($con, $query_ac);
						                if (mysqli_num_rows($query_run_ac) > 0)
						                {
						                	$row_ac = mysqli_fetch_assoc($query_run_ac);
						                	if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['  
												Edit_Dental'] == 'Yes')) 
											{
						            			echo'<button type="button" name="edit_current_eo_assessment_btn" id="edit_current_eo_assessment_btn" class="btn btn-secondary" data-id="'.$row_ac['dental_aeo_id'].'">Edit Extra Oral Assessment</button>';
						            		};
						                }
						                else 
						                {
						                	if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND 
											$_SESSION['Create_Dental'] == 'Yes')) 
											{
						            			echo'<button type="button" name="add_current_eo_assessment_btn" id="add_current_eo_assessment_btn" class="btn btn-primary">Add Extra Oral Assessment</button>';
							           		};
						                };
						               if (mysqli_num_rows($query_run_ac) > 0)
						                {
						            ?>
										<table class="table table-hover table-bordered table-sm" id="currentassessmentTable" width="100%" cellspacing="0">
									        <thead>
									            <tr style="background-color:#C3C1C1; color:white">
									                <th width="20%">Description</th>
									                <th width="10%">Remarks</th>
									                <th width="20%">Description</th>
									                <th width="10%">Remarks</th>
									                <th width="20%">Description</th>
									                <th width="10%">Remarks</th>
									            </tr>
									        </thead>
									        <tbody class="pv-table-body">
									                <tr>
										            	<td><small>Facial Type:</small></td>
									                    <td><?php echo $row_ac['Facial_Type'];?></td>
									                    <td><small>Profile Type:</small></td>
									                    <td><?php echo $row_ac['Profile_Type'];?></td>
									                    <td><small>Lower Facial Height</small></td>
									                    <td><?php echo $row_ac['Lower_Facial_Height'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Transverse</small></td>
									                    <td><?php echo $row_ac['Transverse'];?></td>
									                    <td><small>TMJ</small></td>
									                    <td><?php echo $row_ac['TMJ'];?></td>
									                    <td><small>Lip Competence</small></td>
									                    <td><?php echo $row_ac['Lip_Competence'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Incisor Show at Rest </small></td>
									                    <td><?php echo $row_ac['Incisor_Show_at_Rest'];?></td>
									                    <td><small>Incisor Show when smiling </small></td>
									                    <td><?php echo $row_ac['Incisor_Show_when_smiling'];?></td>
									                    <td><small>Naso Labial Angle</small></td>
									                    <td><?php echo $row_ac['Naso_Labial_Angle'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Labio Mental Fold</small></td>
									                    <td><?php echo $row_ac['Labio_Mental_Fold'];?></td>
									                    <td><small>Lip To E-Line</small></td>
									                    <td><?php echo $row_ac['Lip_To_E_Line'];?></td>
									                    <td><small>Symmetry:</small></td>
									                    <td><?php echo $row_ac['Symmetry'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Scars:</small></td>
									                    <td><?php echo $row_ac['Scars'];?></td>
									                    <td><small>Lesions:</small></td>
									                    <td><?php echo $row_ac['Lesions'];?></td>
									                    <td><small>Oral Habit:</small></td>
									                    <td><?php echo $row_ac['Oral_Habit'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Other</small></td>
									                    <td colspan="5"><?php echo $row_ac['Other'];?></td>
									                </tr>
						            <?php
						                };
						            ?>
									        </tbody>
									    </table>
								</div>
								<div id="intra_oral_current" class="tab-pane fade">
									<?php
						            	$query_ain = "SELECT * FROM dental_assess_intra_oral WHERE attend_id='$attend_id' AND patient_id='$patient_id'";
										$query_run_ain = mysqli_query($con, $query_ain);
						                if (mysqli_num_rows($query_run_ain) > 0)
						                {
						                	$row_ain = mysqli_fetch_assoc($query_run_ain);
						                	if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['  
												Edit_Dental'] == 'Yes')) 
											{
						            			echo'<button type="button" name="edit_current_io_assessment_btn" id="edit_current_io_assessment_btn" class="btn btn-secondary" data-id="'.$row_ain['dental_aio_id'].'">Edit Intra Oral Assessment</button>';
						            		};
						                }
						                else 
						                {
						            		if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['  
												Create_Dental'] == 'Yes')) 
											{
						            			echo'<button type="button" name="add_current_io_assessment_btn" id="add_current_io_assessment_btn" class="btn btn-primary">Add Intra Oral Assessment</button>';
						            		};
						                };
						               if (mysqli_num_rows($query_run_ain) > 0)
						                {
						            ?>
										<table class="table table-hover table-bordered table-sm" id="currentassessmentintraTable" width="100%" cellspacing="0">
									        <thead>
									            <tr style="background-color:#C3C1C1; color:white">
									                <th width="20%">Description</th>
									                <th width="10%">Remarks</th>
									                <th width="20%">Description</th>
									                <th width="10%">Remarks</th>
									                <th width="20%">Description</th>
									                <th width="10%">Remarks</th>
									            </tr>
									        </thead>
									        <tbody class="pv-table-body">
									                <tr>
										            	<td><small>Tongue:</small></td>
									                    <td><?php echo $row_ain['Tongue'];?></td>
									                    <td><small>Gingiva:</small></td>
									                    <td><?php echo $row_ain['Gingiva'];?></td>
									                    <td><small>Overjet</small></td>
									                    <td><?php echo $row_ain['Overjet'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Overbite (mm)</small></td>
									                    <td><?php echo $row_ain['Overbite_mm'];?></td>
									                    <td><small>Overbite %</small></td>
									                    <td><?php echo $row_ain['Overbite_perc'];?></td>
									                    <td><small>Openbite</small></td>
									                    <td><?php echo $row_ain['Openbite'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Molar Relation R</small></td>
									                    <td><?php echo $row_ain['Molar_Relation_R'];?></td>
									                    <td><small>Molar Relation L</small></td>
									                    <td><?php echo $row_ain['Molar_Relation_L'];?></td>
									                    <td><small>Canine Relation R</small></td>
									                    <td><?php echo $row_ain['Canine_Relation_R'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Canine_Relation_L</small></td>
									                    <td><?php echo $row_ain['Canine_Relation_L'];?></td>
									                    <td><small>Incisor_Relation</small></td>
									                    <td><?php echo $row_ain['Incisor_Relation'];?></td>
									                    <td><small>Arches U:</small></td>
									                    <td><?php echo $row_ain['Arches_U'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Arches L:</small></td>
									                    <td><?php echo $row_ain['Arches_L'];?></td>
									                    <td><small>Crossbites Anterior:</small></td>
									                    <td><?php echo $row_ain['Crossbites_Anterior'];?></td>
									                    <td><small>Crossbites Posterior:</small></td>
									                    <td><?php echo $row_ain['Crossbites_Posterior'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Curve of Spee R:</small></td>
									                    <td><?php echo $row_ain['Curve_of_Spee_R'];?></td>
									                    <td><small>Curve of Spee L:</small></td>
									                    <td><?php echo $row_ain['Curve_of_Spee_L'];?></td>
									                    <td><small>Stage_of_Dentition:</small></td>
									                    <td><?php echo $row_ain['Stage_of_Dentition'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Tooth Size:</small></td>
									                    <td><?php echo $row_ain['Tooth_Size'];?></td>
									                    <td><small>Centerlines:</small></td>
									                    <td><?php echo $row_ain['Centerlines'];?></td>
									                    <td><small>Deviated_Remarks:</small></td>
									                    <td><?php echo $row_ain['Deviated_Remarks'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Tonsils:</small></td>
									                    <td><?php echo $row_ain['Tonsils'];?></td>
									                    <td><small>Lesions:</small></td>
									                    <td><?php echo $row_ain['Lesions'];?></td>
									                    <td><small>Akerly Type:</small></td>
									                    <td><?php echo $row_ain['Akerly_Type'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Symmetry:</small></td>
									                    <td><?php echo $row_ain['Symmetry'];?></td>
									                    <td><small>Missing Teeth:</small></td>
									                    <td><?php echo $row_ain['Missing_Teeth'];?></td>
									                    <td><small>Malformed_Teeth:</small></td>
									                    <td><?php echo $row_ain['Malformed_Teeth'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Calculus:</small></td>
									                    <td><?php echo $row_ain['Calculus'];?></td>
									                    <td><small>Other:</small></td>
									                    <td><?php echo $row_ain['Other'];?></td>
									                    <td><small>Rotations:</small></td>
									                    <td><?php echo $row_ain['Rotations'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Crowding:</small></td>
									                    <td><?php echo $row_ain['Crowding'];?></td>
									                    <td><small>Spacing:</small></td>
									                    <td><?php echo $row_ain['Spacing'];?></td>
									                    <td><small>Impacted Teeth:</small></td>
									                    <td><?php echo $row_ain['Impacted_Teeth'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Aesthetic:</small></td>
									                    <td><?php echo $row_ain['Aesthetic'];?></td>
									                    <td><small>Dental nhis:</small></td>
									                    <td><?php echo $row_ain['Dental_nhis'];?></td>
									                </tr>
						            <?php
						                };
						            ?>
									        </tbody>
									    </table>
								</div>
							</div>
						</div>
					</div>
					<div id="assessment_history" class="tab-pane fade">
						<div id="dental_assessment_history">
							<ul class="nav nav-tabs nav-justified">
								<li class="nav-item active"><a class="nav-link" aria-current="page" data-toggle="tab" href="#extra_oral_history">Extra Oral History</a></li>
								<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#intra_oral_history">Intra Oral History</a></li>
							</ul>
							<div class="tab-content">
								<div id="extra_oral_history" class="tab-pane fade show active">
										<table class="table table-hover table-bordered table-sm" id="extraoralhistoryTable" width="100%" cellspacing="0">
									        <thead>
									            <tr style="background-color:#C3C1C1; color:white">
									                <th width="20%">Description</th>
									                <th width="10%">Remarks</th>
									                <th width="20%">Description</th>
									                <th width="10%">Remarks</th>
									                <th width="20%">Description</th>
									                <th width="10%">Remarks</th>
									            </tr>
									        </thead>
									        <tbody class="pv-table-body">
									<?php
									$query_attend = "SELECT * FROM attendance WHERE patient_id='$patient_id' ORDER BY date_admit DESC";
									$query_run_attend = mysqli_query($con, $query_attend);
									if (mysqli_num_rows($query_run_attend) > 0)
					                {
					                	while($row_attend = mysqli_fetch_assoc($query_run_attend))
					                	{
					                		$attend_id_eoh = $row_attend['attend_id'];
							            	$query_eoh = "SELECT * FROM dental_assess_extra_oral WHERE attend_id='$attend_id_eoh' AND patient_id='$patient_id'";
											$query_run_eoh = mysqli_query($con, $query_eoh);
							                if (mysqli_num_rows($query_run_eoh) > 0)
							                {
							                	$row_eoh = mysqli_fetch_assoc($query_run_eoh);
						            ?>
						            				<tr style="background-color:#DCCDCD; color:black">
										            	<td colspan = "6"><strong><?php echo $row_attend['date_admit'];?></strong></td>
									                </tr>
									                <tr>
										            	<td><small>Facial Type:</small></td>
									                    <td><?php echo $row_eoh['Facial_Type'];?></td>
									                    <td><small>Profile Type:</small></td>
									                    <td><?php echo $row_eoh['Profile_Type'];?></td>
									                    <td><small>Lower Facial Height</small></td>
									                    <td><?php echo $row_eoh['Lower_Facial_Height'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Transverse</small></td>
									                    <td><?php echo $row_eoh['Transverse'];?></td>
									                    <td><small>TMJ</small></td>
									                    <td><?php echo $row_eoh['TMJ'];?></td>
									                    <td><small>Lip Competence</small></td>
									                    <td><?php echo $row_eoh['Lip_Competence'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Incisor Show at Rest </small></td>
									                    <td><?php echo $row_eoh['Incisor_Show_at_Rest'];?></td>
									                    <td><small>Incisor Show when smiling </small></td>
									                    <td><?php echo $row_eoh['Incisor_Show_when_smiling'];?></td>
									                    <td><small>Naso Labial Angle</small></td>
									                    <td><?php echo $row_eoh['Naso_Labial_Angle'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Labio Mental Fold</small></td>
									                    <td><?php echo $row_eoh['Labio_Mental_Fold'];?></td>
									                    <td><small>Lip To E-Line</small></td>
									                    <td><?php echo $row_eoh['Lip_To_E_Line'];?></td>
									                    <td><small>Symmetry:</small></td>
									                    <td><?php echo $row_eoh['Symmetry'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Scars:</small></td>
									                    <td><?php echo $row_eoh['Scars'];?></td>
									                    <td><small>Lesions:</small></td>
									                    <td><?php echo $row_eoh['Lesions'];?></td>
									                    <td><small>Oral Habit:</small></td>
									                    <td><?php echo $row_eoh['Oral_Habit'];?></td>
									                </tr>
									                <tr>
									                    <td><small>Other</small></td>
									                    <td colspan="5"><?php echo $row_eoh['Other'];?></td>
									                </tr>
						        <?php
						        			};
						                };

					                };
					            ?>
									        </tbody>
									    </table>
								</div>
								<div id="intra_oral_history" class="tab-pane fade">
											<table class="table table-hover table-bordered table-sm" id="intraoralhistoryTable" width="100%" cellspacing="0">
										        <thead>
										            <tr style="background-color:#C3C1C1; color:white">
										                <th width="20%">Description</th>
										                <th width="10%">Remarks</th>
										                <th width="20%">Description</th>
										                <th width="10%">Remarks</th>
										                <th width="20%">Description</th>
										                <th width="10%">Remarks</th>
										            </tr>
										        </thead>
										        <tbody class="pv-table-body">
									<?php
									$query_attend = "SELECT * FROM attendance WHERE patient_id='$patient_id' ORDER BY date_admit DESC";
									$query_run_attend = mysqli_query($con, $query_attend);
									if (mysqli_num_rows($query_run_attend) > 0)
					                {
					                	while($row_attend = mysqli_fetch_assoc($query_run_attend))
					                	{
					                		$attend_id_ioh = $row_attend['attend_id'];
							            	$query_ioh = "SELECT * FROM dental_assess_intra_oral WHERE attend_id='$attend_id_ioh' AND patient_id='$patient_id'";
											$query_run_ioh = mysqli_query($con, $query_ioh);
							                if (mysqli_num_rows($query_run_ioh) > 0)
							                {
							                	$row_ioh = mysqli_fetch_assoc($query_run_ioh);
						            ?>
										        		<tr style="background-color:#DCCDCD; color:black">
											            	<td colspan = "6"><strong><?php echo $row_attend['date_admit'];?></strong></td>
										                </tr>
										                <tr>
											            	<td><small>Tongue:</small></td>
										                    <td><?php echo $row_ioh['Tongue'];?></td>
										                    <td><small>Gingiva:</small></td>
										                    <td><?php echo $row_ioh['Gingiva'];?></td>
										                    <td><small>Overjet</small></td>
										                    <td><?php echo $row_ioh['Overjet'];?></td>
										                </tr>
										                <tr>
										                    <td><small>Overbite (mm)</small></td>
										                    <td><?php echo $row_ioh['Overbite_mm'];?></td>
										                    <td><small>Overbite %</small></td>
										                    <td><?php echo $row_ioh['Overbite_perc'];?></td>
										                    <td><small>Openbite</small></td>
										                    <td><?php echo $row_ioh['Openbite'];?></td>
										                </tr>
										                <tr>
										                    <td><small>Molar Relation R</small></td>
										                    <td><?php echo $row_ioh['Molar_Relation_R'];?></td>
										                    <td><small>Molar Relation L</small></td>
										                    <td><?php echo $row_ioh['Molar_Relation_L'];?></td>
										                    <td><small>Canine Relation R</small></td>
										                    <td><?php echo $row_ioh['Canine_Relation_R'];?></td>
										                </tr>
										                <tr>
										                    <td><small>Canine_Relation_L</small></td>
										                    <td><?php echo $row_ioh['Canine_Relation_L'];?></td>
										                    <td><small>Incisor_Relation</small></td>
										                    <td><?php echo $row_ioh['Incisor_Relation'];?></td>
										                    <td><small>Arches U:</small></td>
										                    <td><?php echo $row_ioh['Arches_U'];?></td>
										                </tr>
										                <tr>
										                    <td><small>Arches L:</small></td>
										                    <td><?php echo $row_ioh['Arches_L'];?></td>
										                    <td><small>Crossbites Anterior:</small></td>
										                    <td><?php echo $row_ioh['Crossbites_Anterior'];?></td>
										                    <td><small>Crossbites Posterior:</small></td>
										                    <td><?php echo $row_ioh['Crossbites_Posterior'];?></td>
										                </tr>
										                <tr>
										                    <td><small>Curve of Spee R:</small></td>
										                    <td><?php echo $row_ioh['Curve_of_Spee_R'];?></td>
										                    <td><small>Curve of Spee L:</small></td>
										                    <td><?php echo $row_ioh['Curve_of_Spee_L'];?></td>
										                    <td><small>Stage_of_Dentition:</small></td>
										                    <td><?php echo $row_ioh['Stage_of_Dentition'];?></td>
										                </tr>
										                <tr>
										                    <td><small>Tooth Size:</small></td>
										                    <td><?php echo $row_ioh['Tooth_Size'];?></td>
										                    <td><small>Centerlines:</small></td>
										                    <td><?php echo $row_ioh['Centerlines'];?></td>
										                    <td><small>Deviated_Remarks:</small></td>
										                    <td><?php echo $row_ioh['Deviated_Remarks'];?></td>
										                </tr>
										                <tr>
										                    <td><small>Tonsils:</small></td>
										                    <td><?php echo $row_ioh['Tonsils'];?></td>
										                    <td><small>Lesions:</small></td>
										                    <td><?php echo $row_ioh['Lesions'];?></td>
										                    <td><small>Akerly Type:</small></td>
										                    <td><?php echo $row_ioh['Akerly_Type'];?></td>
										                </tr>
										                <tr>
										                    <td><small>Symmetry:</small></td>
										                    <td><?php echo $row_ioh['Symmetry'];?></td>
										                    <td><small>Missing Teeth:</small></td>
										                    <td><?php echo $row_ioh['Missing_Teeth'];?></td>
										                    <td><small>Malformed_Teeth:</small></td>
										                    <td><?php echo $row_ioh['Malformed_Teeth'];?></td>
										                </tr>
										                <tr>
										                    <td><small>Calculus:</small></td>
										                    <td><?php echo $row_ioh['Calculus'];?></td>
										                    <td><small>Other:</small></td>
										                    <td><?php echo $row_ioh['Other'];?></td>
										                    <td><small>Rotations:</small></td>
										                    <td><?php echo $row_ioh['Rotations'];?></td>
										                </tr>
										                <tr>
										                    <td><small>Crowding:</small></td>
										                    <td><?php echo $row_ioh['Crowding'];?></td>
										                    <td><small>Spacing:</small></td>
										                    <td><?php echo $row_ioh['Spacing'];?></td>
										                    <td><small>Impacted Teeth:</small></td>
										                    <td><?php echo $row_ioh['Impacted_Teeth'];?></td>
										                </tr>
										                <tr>
										                    <td><small>Aesthetic:</small></td>
										                    <td><?php echo $row_ioh['Aesthetic'];?></td>
										                    <td><small>Dental nhis:</small></td>
										                    <td><?php echo $row_ioh['Dental_nhis'];?></td>
										                </tr>
						        <?php
						        			};
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
			</div>
		</div>
		<div id="chart" class="tab-pane fade">
		 	<div class="table-responsive" id="attend_dental_chart_table">
		 		<div class="form-row">
                    <div class="col-md-1 mb-1 form-group">
					</div>
                    <div class="col-md-10 mb-10 form-group">
				 		<table class="table table-bordered table-sm" id="adultdentalchartTable" width="100%" cellspacing="0">
					        <thead>
					            <tr>
					                <th class="action-td" colspan = "16">ADULT DENTAL CHART</th>
					            </tr>
					        </thead>
					        <tbody class="pv-table-body">
					        	<tr>
					        		<td class="action-td tooth" data-id ="T18"><img class="tooth" src="/img/dental/18.jpg" alt="18" data-id ="T18" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T17"><img class="tooth" src="/img/dental/17.jpg" alt="17" data-id ="T17" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T16"><img class="tooth" src="/img/dental/16.jpg" alt="16" data-id ="T16" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T15"><img class="tooth" src="/img/dental/15.jpg" alt="15" data-id ="T15" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T14"><img class="tooth" src="/img/dental/14.jpg" alt="14" data-id ="T14" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T13"><img class="tooth" src="/img/dental/13.jpg" alt="13" data-id ="T13" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T12"><img class="tooth" src="/img/dental/12.jpg" alt="12" data-id ="T12" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T11"><img class="tooth" src="/img/dental/11.jpg" alt="11" data-id ="T11" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T21"><img class="tooth" src="/img/dental/21.jpg" alt="21" data-id ="T21" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T22"><img class="tooth" src="/img/dental/22.jpg" alt="22" data-id ="T22" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T23"><img class="tooth" src="/img/dental/23.jpg" alt="23" data-id ="T23" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T24"><img class="tooth" src="/img/dental/24.jpg" alt="24" data-id ="T24" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T25"><img class="tooth" src="/img/dental/25.jpg" alt="25" data-id ="T25" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T26"><img class="tooth" src="/img/dental/26.jpg" alt="26" data-id ="T26" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T27"><img class="tooth" src="/img/dental/27.jpg" alt="27" data-id ="T27" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T28"><img class="tooth" src="/img/dental/28.jpg" alt="28" data-id ="T28" width="50" height="90"></td>
					        	</tr>
					        	<tr>
					        		<?php
					        			$query_t18 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T18' AND patient_id='$patient_id'";
											$query_run_t18 = mysqli_query($con, $query_t18);
							                if (mysqli_num_rows($query_run_t18) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T18">T18</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T18">T18</td>
							        <?php
							                };
					        			$query_t17 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T17' AND patient_id='$patient_id'";
											$query_run_t17 = mysqli_query($con, $query_t17);
							                if (mysqli_num_rows($query_run_t17) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T17">T17</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T17">T17</td>
							        <?php
							                };
					        			$query_t16 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T16' AND patient_id='$patient_id'";
											$query_run_t16 = mysqli_query($con, $query_t16);
							                if (mysqli_num_rows($query_run_t16) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T16">T16</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T16">T16</td>
							        <?php
							                };
					        			$query_t15 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T15' AND patient_id='$patient_id'";
											$query_run_t15 = mysqli_query($con, $query_t15);
							                if (mysqli_num_rows($query_run_t15) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T15">T15</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T15">T15</td>
							        <?php
							                };

					        			$query_t14 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T14' AND patient_id='$patient_id'";
											$query_run_t14 = mysqli_query($con, $query_t14);
							                if (mysqli_num_rows($query_run_t14) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T14">T14</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T14">T14</td>
							        <?php
							                };
					        			$query_t13 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T13' AND patient_id='$patient_id'";
											$query_run_t13 = mysqli_query($con, $query_t13);
							                if (mysqli_num_rows($query_run_t13) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T13">T13</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T13">T13</td>
							        <?php
							                };
					        			$query_t12 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T12' AND patient_id='$patient_id'";
											$query_run_t12 = mysqli_query($con, $query_t12);
							                if (mysqli_num_rows($query_run_t12) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T12">T12</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T12">T12</td>
							        <?php
							                };
					        			$query_t11 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T11' AND patient_id='$patient_id'";
											$query_run_t11 = mysqli_query($con, $query_t11);
							                if (mysqli_num_rows($query_run_t11) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T11">T11</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T11">T11</td>
							        <?php
							                };
						        	
					        			$query_t21 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T21' AND patient_id='$patient_id'";
											$query_run_t21 = mysqli_query($con, $query_t21);
							                if (mysqli_num_rows($query_run_t21) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T21">T21</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T21">T21</td>
							        <?php
							                };
					        			$query_t22 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T22' AND patient_id='$patient_id'";
											$query_run_t22 = mysqli_query($con, $query_t22);
							                if (mysqli_num_rows($query_run_t22) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T22">T22</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T22">T22</td>
							        <?php
							                };
					        			$query_t23 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T23' AND patient_id='$patient_id'";
											$query_run_t23 = mysqli_query($con, $query_t23);
							                if (mysqli_num_rows($query_run_t23) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T23">T23</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T23">T23</td>
							        <?php
							                };
					        			$query_t24 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T24' AND patient_id='$patient_id'";
											$query_run_t24 = mysqli_query($con, $query_t24);
							                if (mysqli_num_rows($query_run_t24) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T24">T24</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T24">T24</td>
							        <?php
							                };

					        			$query_t25 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T25' AND patient_id='$patient_id'";
											$query_run_t25 = mysqli_query($con, $query_t25);
							                if (mysqli_num_rows($query_run_t25) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T25">T25</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T25">T25</td>
							        <?php
							                };
					        			$query_t26 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T26' AND patient_id='$patient_id'";
											$query_run_t26 = mysqli_query($con, $query_t26);
							                if (mysqli_num_rows($query_run_t26) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T26">T26</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T26">T26</td>
							        <?php
							                };
					        			$query_t27 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T27' AND patient_id='$patient_id'";
											$query_run_t27 = mysqli_query($con, $query_t27);
							                if (mysqli_num_rows($query_run_t27) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T27">T27</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T27">T27</td>
							        <?php
							                };
					        			$query_t28 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T28' AND patient_id='$patient_id'";
											$query_run_t28 = mysqli_query($con, $query_t28);
							                if (mysqli_num_rows($query_run_t28) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T28">T28</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T28">T28</td>
							        <?php
							                };
						        	?>
					        	</tr>
					        	<tr>
					        		<td colspan = "16"></td>
					        	</tr>
					        	<tr>
					        		<td class="action-td tooth" data-id ="T48"><img class="tooth" src="/img/dental/48.jpg" alt="48" data-id ="T48" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T47"><img class="tooth" src="/img/dental/47.jpg" alt="47" data-id ="T47" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T46"><img class="tooth" src="/img/dental/46.jpg" alt="46" data-id ="T46" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T45"><img class="tooth" src="/img/dental/45.jpg" alt="45" data-id ="T45" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T44"><img class="tooth" src="/img/dental/44.jpg" alt="44" data-id ="T44" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T43"><img class="tooth" src="/img/dental/43.jpg" alt="43" data-id ="T43" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T42"><img class="tooth" src="/img/dental/42.jpg" alt="42" data-id ="T42" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T41"><img class="tooth" src="/img/dental/41.jpg" alt="41" data-id ="T41" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T31"><img class="tooth" src="/img/dental/31.jpg" alt="31" data-id ="T31" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T32"><img class="tooth" src="/img/dental/32.jpg" alt="32" data-id ="T32" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T33"><img class="tooth" src="/img/dental/33.jpg" alt="33" data-id ="T33" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T34"><img class="tooth" src="/img/dental/34.jpg" alt="34" data-id ="T34" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T35"><img class="tooth" src="/img/dental/35.jpg" alt="35" data-id ="T35" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T36"><img class="tooth" src="/img/dental/36.jpg" alt="36" data-id ="T36" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T37"><img class="tooth" src="/img/dental/37.jpg" alt="37" data-id ="T37" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T38"><img class="tooth" src="/img/dental/38.jpg" alt="38" data-id ="T38" width="50" height="90"></td>
					        	</tr>
					        	<tr>
					        		<?php
					        			$query_t48 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T48' AND patient_id='$patient_id'";
											$query_run_t48 = mysqli_query($con, $query_t48);
							                if (mysqli_num_rows($query_run_t48) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T48">T48</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T48">T48</td>
							        <?php
							                };
					        			$query_t47 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T47' AND patient_id='$patient_id'";
											$query_run_t47 = mysqli_query($con, $query_t47);
							                if (mysqli_num_rows($query_run_t47) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T47">T47</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T47">T47</td>
							        <?php
							                };
					        			$query_t46 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T46' AND patient_id='$patient_id'";
											$query_run_t46 = mysqli_query($con, $query_t46);
							                if (mysqli_num_rows($query_run_t46) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T46">T46</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T46">T46</td>
							        <?php
							                };
					        			$query_t45 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T45' AND patient_id='$patient_id'";
											$query_run_t45 = mysqli_query($con, $query_t45);
							                if (mysqli_num_rows($query_run_t45) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T45">T45</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T45">T45</td>
							        <?php
							                };

					        			$query_t44 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T44' AND patient_id='$patient_id'";
											$query_run_t44 = mysqli_query($con, $query_t44);
							                if (mysqli_num_rows($query_run_t44) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T44">T44</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T44">T44</td>
							        <?php
							                };
					        			$query_t43 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T43' AND patient_id='$patient_id'";
											$query_run_t43 = mysqli_query($con, $query_t43);
							                if (mysqli_num_rows($query_run_t43) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T43">T43</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T43">T43</td>
							        <?php
							                };
					        			$query_t42 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T42' AND patient_id='$patient_id'";
											$query_run_t42 = mysqli_query($con, $query_t42);
							                if (mysqli_num_rows($query_run_t42) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T42">T42</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T42">T42</td>
							        <?php
							                };
					        			$query_t41 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T41' AND patient_id='$patient_id'";
											$query_run_t41 = mysqli_query($con, $query_t41);
							                if (mysqli_num_rows($query_run_t41) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T41">T41</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T41">T41</td>
							        <?php
							                };
						        	
					        			$query_t31 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T31' AND patient_id='$patient_id'";
											$query_run_t31 = mysqli_query($con, $query_t31);
							                if (mysqli_num_rows($query_run_t31) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T31">T31</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T31">T31</td>
							        <?php
							                };
					        			$query_t32 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T32' AND patient_id='$patient_id'";
											$query_run_t32 = mysqli_query($con, $query_t32);
							                if (mysqli_num_rows($query_run_t32) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T32">T32</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T32">T32</td>
							        <?php
							                };
					        			$query_t33 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T33' AND patient_id='$patient_id'";
											$query_run_t33 = mysqli_query($con, $query_t33);
							                if (mysqli_num_rows($query_run_t33) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T33">T33</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T33">T33</td>
							        <?php
							                };
					        			$query_t34 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T34' AND patient_id='$patient_id'";
											$query_run_t34 = mysqli_query($con, $query_t34);
							                if (mysqli_num_rows($query_run_t34) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T34">T34</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T34">T34</td>
							        <?php
							                };

					        			$query_t35 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T35' AND patient_id='$patient_id'";
											$query_run_t35 = mysqli_query($con, $query_t35);
							                if (mysqli_num_rows($query_run_t35) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T35">T35</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T35">T35</td>
							        <?php
							                };
					        			$query_t36 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T36' AND patient_id='$patient_id'";
											$query_run_t36 = mysqli_query($con, $query_t36);
							                if (mysqli_num_rows($query_run_t36) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T36">T36</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T36">T36</td>
							        <?php
							                };
					        			$query_t37 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T37' AND patient_id='$patient_id'";
											$query_run_t37 = mysqli_query($con, $query_t37);
							                if (mysqli_num_rows($query_run_t37) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T37">T37</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T37">T37</td>
							        <?php
							                };
					        			$query_t38 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T38' AND patient_id='$patient_id'";
											$query_run_t38 = mysqli_query($con, $query_t38);
							                if (mysqli_num_rows($query_run_t38) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T38">T38</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T38">T38</td>
							        <?php
							                };
						        	?>
					        	</tr>
							</tbody>
					    </table>
					</div>
                    <div class="col-md-1 mb-1 form-group">
					</div>
				</div>
				<div class="form-row">
                    <div class="col-md-2 mb-2 form-group">
					</div>
                    <div class="col-md-8 mb-8 form-group">
					    <table class="table table-bordered table-sm" id="childdentalchartTable" width="100%" cellspacing="0">
					        <thead>
					            <tr>
					                <th class="action-td" colspan = "16">CHILD DENTAL CHART</th>
					            </tr>
					        </thead>
					        <tbody class="pv-table-body">
					        	<tr>
					        		<td class="action-td tooth" data-id ="T55"><img class="tooth" src="/img/dental/17.jpg" alt="55" data-id ="T55" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T54"><img class="tooth" src="/img/dental/16.jpg" alt="54" data-id ="T54" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T53"><img class="tooth" src="/img/dental/13.jpg" alt="53" data-id ="T53" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T52"><img class="tooth" src="/img/dental/12.jpg" alt="52" data-id ="T52" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T51"><img class="tooth" src="/img/dental/11.jpg" alt="51" data-id ="T51" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T61"><img class="tooth" src="/img/dental/21.jpg" alt="61" data-id ="T61" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T62"><img class="tooth" src="/img/dental/22.jpg" alt="62" data-id ="T62" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T63"><img class="tooth" src="/img/dental/23.jpg" alt="63" data-id ="T63" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T64"><img class="tooth" src="/img/dental/26.jpg" alt="64" data-id ="T64" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T65"><img class="tooth" src="/img/dental/27.jpg" alt="65" data-id ="T65" width="50" height="90"></td>
					        	</tr>
					        	<tr>
					        		 <?php
					        			$query_t55 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T55' AND patient_id='$patient_id'";
											$query_run_t55 = mysqli_query($con, $query_t55);
							                if (mysqli_num_rows($query_run_t55) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T55">T55</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T55">T55</td>
							        <?php
							                };

					        			$query_t54 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T54' AND patient_id='$patient_id'";
											$query_run_t54 = mysqli_query($con, $query_t54);
							                if (mysqli_num_rows($query_run_t54) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T54">T54</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T54">T54</td>
							        <?php
							                };
					        			$query_t53 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T53' AND patient_id='$patient_id'";
											$query_run_t53 = mysqli_query($con, $query_t53);
							                if (mysqli_num_rows($query_run_t53) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T53">T53</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T53">T53</td>
							        <?php
							                };
					        			$query_t52 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T52' AND patient_id='$patient_id'";
											$query_run_t52 = mysqli_query($con, $query_t52);
							                if (mysqli_num_rows($query_run_t52) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T52">T52</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T52">T52</td>
							        <?php
							                };
					        			$query_t51 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T51' AND patient_id='$patient_id'";
											$query_run_t51 = mysqli_query($con, $query_t51);
							                if (mysqli_num_rows($query_run_t51) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T51">T51</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T51">T51</td>
							        <?php
							                };
						        	
					        			$query_t61 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T61' AND patient_id='$patient_id'";
											$query_run_t61 = mysqli_query($con, $query_t61);
							                if (mysqli_num_rows($query_run_t61) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T61">T61</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T61">T61</td>
							        <?php
							                };
					        			$query_t62 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T62' AND patient_id='$patient_id'";
											$query_run_t62 = mysqli_query($con, $query_t62);
							                if (mysqli_num_rows($query_run_t62) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T62">T62</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T62">T62</td>
							        <?php
							                };
					        			$query_t63 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T63' AND patient_id='$patient_id'";
											$query_run_t63 = mysqli_query($con, $query_t63);
							                if (mysqli_num_rows($query_run_t63) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T63">T63</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T63">T63</td>
							        <?php
							                };
					        			$query_t64 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T64' AND patient_id='$patient_id'";
											$query_run_t64 = mysqli_query($con, $query_t64);
							                if (mysqli_num_rows($query_run_t64) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T64">T64</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T64">T64</td>
							        <?php
							                };

					        			$query_t65 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T65' AND patient_id='$patient_id'";
											$query_run_t65 = mysqli_query($con, $query_t65);
							                if (mysqli_num_rows($query_run_t65) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T65">T65</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T65">T65</td>
							        <?php
							                };
							        ?>
					        	</tr>
					        	<tr>
					        		<td colspan = "16"></td>
					        	</tr>
					        	<tr>
					        		<td class="action-td tooth" data-id ="T85"><img class="tooth" src="/img/dental/47.jpg" alt="85" data-id ="T85" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T84"><img class="tooth" src="/img/dental/46.jpg" alt="84" data-id ="T84" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T83"><img class="tooth" src="/img/dental/43.jpg" alt="83" data-id ="T83" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T82"><img class="tooth" src="/img/dental/42.jpg" alt="82" data-id ="T82" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T81"><img class="tooth" src="/img/dental/41.jpg" alt="81" data-id ="T81" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T71"><img class="tooth" src="/img/dental/31.jpg" alt="71" data-id ="T71" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T72"><img class="tooth" src="/img/dental/32.jpg" alt="72" data-id ="T72" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T73"><img class="tooth" src="/img/dental/33.jpg" alt="73" data-id ="T73" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T74"><img class="tooth" src="/img/dental/36.jpg" alt="74" data-id ="T74" width="50" height="90"></td>
					        		<td class="action-td tooth" data-id ="T75"><img class="tooth" src="/img/dental/37.jpg" alt="75" data-id ="T75" width="50" height="90"></td>
					        	</tr>
					        	<tr>
					        		<?php
					        			$query_t85 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T85' AND patient_id='$patient_id'";
											$query_run_t85 = mysqli_query($con, $query_t85);
							                if (mysqli_num_rows($query_run_t85) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T85">T85</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T85">T85</td>
							        <?php
							                };

					        			$query_t84 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T84' AND patient_id='$patient_id'";
											$query_run_t84 = mysqli_query($con, $query_t84);
							                if (mysqli_num_rows($query_run_t84) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T84">T84</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T84">T84</td>
							        <?php
							                };
					        			$query_t83 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T83' AND patient_id='$patient_id'";
											$query_run_t83 = mysqli_query($con, $query_t83);
							                if (mysqli_num_rows($query_run_t83) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T83">T83</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T83">T83</td>
							        <?php
							                };
					        			$query_t82 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T82' AND patient_id='$patient_id'";
											$query_run_t82 = mysqli_query($con, $query_t82);
							                if (mysqli_num_rows($query_run_t82) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T82">T82</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T82">T82</td>
							        <?php
							                };
					        			$query_t81 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T81' AND patient_id='$patient_id'";
											$query_run_t81 = mysqli_query($con, $query_t81);
							                if (mysqli_num_rows($query_run_t81) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T81">T81</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T81">T81</td>
							        <?php
							                };
						        	
					        			$query_t71 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T71' AND patient_id='$patient_id'";
											$query_run_t71 = mysqli_query($con, $query_t71);
							                if (mysqli_num_rows($query_run_t71) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T71">T71</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T71">T71</td>
							        <?php
							                };
					        			$query_t72 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T72' AND patient_id='$patient_id'";
											$query_run_t72 = mysqli_query($con, $query_t72);
							                if (mysqli_num_rows($query_run_t72) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T72">T72</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T72">T72</td>
							        <?php
							                };
					        			$query_t73 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T73' AND patient_id='$patient_id'";
											$query_run_t73 = mysqli_query($con, $query_t73);
							                if (mysqli_num_rows($query_run_t73) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T73">T73</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T73">T73</td>
							        <?php
							                };
					        			$query_t74 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T74' AND patient_id='$patient_id'";
											$query_run_t74 = mysqli_query($con, $query_t74);
							                if (mysqli_num_rows($query_run_t74) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T74">T74</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T74">T74</td>
							        <?php
							                };

					        			$query_t75 = "SELECT * FROM dental_chart WHERE dental_teeth_id='T75' AND patient_id='$patient_id'";
											$query_run_t75 = mysqli_query($con, $query_t75);
							                if (mysqli_num_rows($query_run_t75) > 0)
							                {
							        ?>
							        			<td class="action-td tooth bg-danger text-white" data-id ="T75">T75</td>
							        <?php
							                }
							                else
							                {
							        ?>
							        			<td class="action-td tooth" data-id ="T75">T75</td>
							        <?php
							                };
							        ?>
					        	</tr>
							</tbody>
					    </table>
					</div>
                    <div class="col-md-2 mb-2 form-group">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div 
	class="modal fade hide bd-example-modal-xl" 
	id="add_patient_hx_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="add_patient_hx_modal" 
	aria-hidden="true"
	data-backdrop="static"
	data-keyboard="false">
		<div class="modal-dialog modal-xl" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title m-0 font-weight-bold text-primary" id="add_patient_hx_modal_title">Add Patient History</h5>
	    	</div>
			<form id="add_patient_hx_form" action="#" method="POST">
			    <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                        	<input type="hidden" class="form-control" name="phx_id" id="phx_id">
                            <label for="phx1"><small>1. Do your gums bleed while brushing or flossing:</small></label>
                            <select class="form-control" name="phx1" id="phx1"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx2"><small>2. Are your teeth sensitive to hot or cold liquids/foods:</small></label>
                            <select class="form-control" name="phx2" id="phx2"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx3"><small>3. Are your teeth sensitive to sweet or sour foods:</small></label>
                            <select class="form-control" name="phx3" id="phx3"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx4"><small>4. Do you feel pain in any of your teeth:</small></label>
                            <select class="form-control" name="phx4" id="phx4"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx5"><small>5. Do you have any sores or lumps in or near your mouth:</small></label>
                            <select class="form-control" name="phx5" id="phx5"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx6"><small>6. Have you ever experianced any problems in your jaw?:</small></label>
                            <select class="form-control" name="phx6" id="phx6"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx7"><small>7. Clicking:</small></label>
                            <select class="form-control" name="phx7" id="phx7"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx8"><small>8. Pain (Joint, Ear, side of face):</small></label>
                            <select class="form-control" name="phx8" id="phx8"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx9"><small>9. Do you have frequent headaches:</small></label>
                            <select class="form-control" name="phx9" id="phx9"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx10"><small>10. Do you clench or grind your teeth:</small></label>
                            <select class="form-control" name="phx10" id="phx10"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx11"><small>11. Have you noticed any loosening of your teeth:</small></label>
                            <select class="form-control" name="phx11" id="phx11"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx12"><small>12. Does food tend to become caught between your teeth:</small></label>
                            <select class="form-control" name="phx12" id="phx12"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx13"><small>13. Have you ever had periodontal treatment:</small></label>
                            <select class="form-control" name="phx13" id="phx13"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx14"><small>14. Have you ever worn any appliance:</small></label>
                            <select class="form-control" name="phx14" id="phx14"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx15"><small>15. Are you using or ever used denture:</small></label>
                            <select class="form-control" name="phx15" id="phx15"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx16"><small>16. Have you ever had any difficult extractions in the past:</small></label>
                            <select class="form-control" name="phx16" id="phx16"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx17"><small>17. Have you ever had any prolonged bleeding following extractions or cuts:</small></label>
                            <select class="form-control" name="phx17" id="phx17"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx18"><small>18. Have you ever received oral hygiene instuctions regarding the care of your teeth and gums:</small></label>
                            <select class="form-control" name="phx18" id="phx18"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                    	<div class="col-md-12 mb-12 form-group">
                            <p><strong>ARE YOU ALLERGIC TO OR HAVE YOU HAD REACTIONS TO</strong></p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx19"><small>1. Local anaesthetic like lidocaine:</small></label>
                            <select class="form-control" name="phx19" id="phx19"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx20"><small>2. Penicillins or other antibiotics:</small></label>
                            <select class="form-control" name="phx20" id="phx20"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx21"><small>3. Other (Please list):</small></label>
                            <textarea class="form-control" id="phx21" name="phx21"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                    	<div class="col-md-12 mb-12 form-group">
                            <p><strong>DO YOU HAVE OR EVER HAD THE FOLLOWING</strong></p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx22"><small>1. Heart Attack/Heart problem/Chest pain:</small></label>
                            <select class="form-control" name="phx22" id="phx22"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx23"><small>2. Sickle Cell Disease:</small></label>
                            <select class="form-control" name="phx23" id="phx23"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx24"><small>3. High/Low Blood Pressure:</small></label>
                            <select class="form-control" name="phx24" id="phx24"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx25"><small>4. Hepatitis:</small></label>
                            <select class="form-control" name="phx25" id="phx25"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx26"><small>5. Lung or breathing problem:</small></label>
                            <select class="form-control" name="phx26" id="phx26"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx27"><small>6. Fainting of dizzy spells:</small></label>
                            <select class="form-control" name="phx27" id="phx27"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx28"><small>7. Diabetes:</small></label>
                            <select class="form-control" name="phx28" id="phx28"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx29"><small>8. Stomach Ulcer:</small></label>
                            <select class="form-control" name="phx29" id="phx29"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx30"><small>9. Persistent Cough:</small></label>
                            <select class="form-control" name="phx30" id="phx30"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx31"><small>10. Epilepsy or Seizures:</small></label>
                            <select class="form-control" name="phx31" id="phx31"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx32"><small>11. Others:</small></label>
                            <textarea class="form-control" id="phx32" name="phx32"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                    	<div class="col-md-12 mb-12 form-group">
                            <p><strong>FOR WOMEN ONLY</strong></p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx33"><small>1. Are you pregnant or think you may be pregnant:</small></label>
                            <select class="form-control" name="phx33" id="phx33"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx34"><small>2. Are you nursing:</small></label>
                            <select class="form-control" name="phx34" id="phx34"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="phx35"><small>3. Are you taking birth control pills:</small></label>
                            <select class="form-control" name="phx35" id="phx35"> 
                                <option value="0">Please Select</option>
                                <option value = "yes">Yes</option>
                                <option value = "no">No</option>
                            </select>
                        </div>
                    </div>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="patient_hx_save" name="patient_hx_save" class="btn btn-primary">Save</button>
			        <button type="button" id="patient_hx_update" name="patient_hx_update" class="btn btn-primary">Update</button>
			        <button type="button" id="patient_hx_cancel" name="patient_hx_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<div 
	class="modal fade hide bd-example-modal-xl" 
	id="add_assessment_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="add_assessment_modal" 
	aria-hidden="true"
	data-backdrop="static"
	data-keyboard="false">
		<div class="modal-dialog modal-xl" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title m-0 font-weight-bold text-primary" id="add_assessment_modal_title">Add Dental Assessment</h5>
	    	</div>
			<form id="add_assessment_form" action="#" method="POST">
			    <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                        	<input type="hidden" class="form-control" name="dental_aeo_id" id="dental_aeo_id">
                            <label for="Facial_Type"><small>Facial Type:</small></label>
                            <select class="form-control" name="Facial_Type" id="Facial_Type"> 
                                <option value="">Please Select</option>
                                <option value = "Orthognathic">Orthognathic</option>
                                <option value = "Retrognathic">Retrognathic</option>
                                <option value = "Prognathic">Prognathic</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Profile_Type"><small>Profile Type:</small></label>
                            <select class="form-control" name="Profile_Type" id="Profile_Type"> 
                                <option value="">Please Select</option>
                                <option value = "Straight">Straight</option>
                                <option value = "Convex">Convex</option>
                                <option value = "Concave">Concave</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Lower_Facial_Height"><small>Lower Facial Height</small></label>
                            <select class="form-control" name="Lower_Facial_Height" id="Lower_Facial_Height"> 
                                <option value="">Please Select</option>
                                <option value = "Normal">Normal</option>
                                <option value = "Reduced">Reduced</option>
                                <option value = "Increased">Increased</option>
							</select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Transverse"><small>Transverse</small></label>
                            <select class="form-control" name="Transverse" id="Transverse"> 
                                <option value="">Please Select</option>
                                <option value = "Symmetrical">Symmetrical</option>
                                <option value = "Mand to the R">Mand to the R</option>
                                <option value = "Mand to the L">Mand to the L</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="TMJ"><small>TMJ</small></label>
                            <select class="form-control" name="TMJ" id="TMJ"> 
                                <option value="">Please Select</option>
                                <option value = "Both Normal">Both Normal</option>
                                <option value = "R + L Pathology">R + L Pathology</option>
                                <option value = "R Pathology">R Pathology</option>
                                <option value = "L Pathology">L Pathology</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Lip_Competence"><small>Lip Competence</small></label>
                            <select class="form-control" name="Lip_Competence" id="Lip_Competence"> 
                                <option value="">Please Select</option>
                                <option value = "Together">Together</option>
                                <option value = "Apart">Apart</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Incisor_Show_at_Rest "><small>Incisor Show at Rest (mm)</small></label>
	                        <input type="text" class="form-control" name="Incisor_Show_at_Rest" id="Incisor_Show_at_Rest">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Incisor_Show_when_smiling "><small>Incisor Show when smiling (mm)</small></label>
                            <input type="text" class="form-control" name="Incisor_Show_when_smiling" id="Incisor_Show_when_smiling">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Naso_Labial_Angle"><small>Naso Labial Angle</small></label>
                            <select class="form-control" name="Naso_Labial_Angle" id="Naso_Labial_Angle"> 
                                <option value="">Please Select</option>
                                <option value = "Normal">Normal</option>
                                <option value = "Acute">Acute</option>
                                <option value = "Obtuse">Obtuse</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Labio_Mental_Fold"><small>Labio Mental Fold</small></label>
                            <select class="form-control" name="Labio_Mental_Fold" id="Labio_Mental_Fold"> 
                                <option value="">Please Select</option>
                                <option value = "Normal">Normal</option>
                                <option value = "Deep">Deep</option>
                                <option value = "Flat">Flat</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Lip_To_E_Line"><small>Lip To E-Line</small></label>
                            <select class="form-control" name="Lip_To_E_Line" id="Lip_To_E_Line"> 
                                <option value="">Please Select</option>
                                <option value = "On">On</option>
                                <option value = "Behind">Behind</option>
                                <option value = "Forward">Forward</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Symmetry"><small>Symmetry:</small></label>
                            <input type="text" class="form-control" name="Symmetry" id="Symmetry">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Scars"><small>Scars</small></label>
                            <input type="text" class="form-control" name="Scars" id="Scars">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Lesions"><small>Lesions</small></label>
                            <input type="text" class="form-control" name="Lesions" id="Lesions">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Oral_Habit"><small>Oral Habit:</small></label>
                            <input type="text" class="form-control" name="Oral_Habit" id="Oral_Habit">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-12 form-group">
                            <label for="Others"><small>Others:</small></label>
                            <textarea class="form-control" id="Others" name="Others"></textarea>
                        </div>
                    </div>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="add_assess_save" name="add_assess_save" class="btn btn-primary">Save</button>
			        <button type="button" id="add_assess_update" name="add_assess_update" class="btn btn-primary">Update</button>
			        <button type="button" id="add_assess_cancel" name="add_assess_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<div 
	class="modal fade hide bd-example-modal-xl" 
	id="add_intra_assessment_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="add_intra_assessment_modal" 
	aria-hidden="true"
	data-backdrop="static"
	data-keyboard="false">
		<div class="modal-dialog modal-xl" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title m-0 font-weight-bold text-primary" id="add_intra_assessment_modal_title">Add Intra Assessment</h5>
	    	</div>
			<form id="add_intra_assessment_form" action="#" method="POST">
			    <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                        	<input type="hidden" class="form-control" name="dental_aio_id" id="dental_aio_id">
                            <label for="Tongue"><small>Tongue</small></label>
	                        <input type="text" class="form-control" name="Tongue" id="Tongue">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Gingiva"><small>Gingiva</small></label>
	                        <input type="text" class="form-control" name="Gingiva" id="Gingiva">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Overjet"><small>Overjet</small></label>
	                        <input type="text" class="form-control" name="Overjet" id="Overjet">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Overbite_mm"><small>Overbite (mm)</small></label>
	                        <input type="text" class="form-control" name="Overbite_mm" id="Overbite_mm">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Overbite_perc"><small>Overbite (%)</small></label>
	                        <input type="text" class="form-control" name="Overbite_perc" id="Overbite_perc">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Openbite"><small>Openbite</small></label>
	                        <input type="text" class="form-control" name="Openbite" id="Openbite">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Molar_Relation_R"><small>Molar Relation R:</small></label>
	                        <input type="text" class="form-control" name="Molar_Relation_R" id="Molar_Relation_R">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Molar_Relation_L"><small>Molar Relation L:</small></label>
	                        <input type="text" class="form-control" name="Molar_Relation_L" id="Molar_Relation_L">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Canine_Relation_R"><small>Canine Relation R:</small></label>
	                        <input type="text" class="form-control" name="Canine_Relation_R" id="Canine_Relation_R">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Canine_Relation_L"><small>Canine Relation L:</small></label>
	                        <input type="text" class="form-control" name="Canine_Relation_L" id="Canine_Relation_L">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Incisor_Relation"><small>Incisor Relation</small></label>
                            <select class="form-control" name="Incisor_Relation" id="Incisor_Relation"> 
                                <option value="">Please Select</option>
                                <option value = "Class_I">Class I</option>
                                <option value = "Class_II_DIV1">Class II DIV1</option>
                                <option value = "Class_II_DIV2">Class II DIV</option>
                                <option value = "Class_III">Class III</option>
							</select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Arches_U"><small>Arches U</small></label>
	                        <input type="text" class="form-control" name="Arches_U" id="Arches_U">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Arches_L"><small>Arches L</small></label>
	                        <input type="text" class="form-control" name="Arches_L" id="Arches_L">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Crossbites_Anterior"><small>Crossbites (Anterior)</small></label>
	                        <input type="text" class="form-control" name="Crossbites_Anterior" id="Crossbites_Anterior">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Crossbites_Posterior"><small>Crossbites (Posterior)</small></label>
	                        <input type="text" class="form-control" name="Crossbites_Posterior" id="Crossbites_Posterior">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Curve_of_Spee_R"><small>Curve of Spee R (mm)</small></label>
	                        <input type="text" class="form-control" name="Curve_of_Spee_R" id="Curve_of_Spee_R">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Curve_of_Spee_L"><small>Curve of Spee L (mm)</small></label>
	                        <input type="text" class="form-control" name="Curve_of_Spee_L" id="Curve_of_Spee_L">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Stage_of_Dentition"><small>Stage of Dentition</small></label>
                            <select class="form-control" name="Stage_of_Dentition" id="Stage_of_Dentition"> 
                                <option value="">Please Select</option>
                                <option value = "Primary">Primary</option>
                                <option value = "Mixed">Mixed</option>
                                <option value = "Permanent">Permanent</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Tooth_Size"><small>Tooth Size</small></label>
                            <select class="form-control" name="Tooth_Size" id="Tooth_Size"> 
                                <option value="">Please Select</option>
                                <option value = "Normal">Normal</option>
                                <option value = "Microdont">Microdont</option>
                                <option value = "Macrodont">Macrodont</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Centerlines"><small>Centerlines</small></label>
                            <select class="form-control" name="Centerlines" id="Centerlines"> 
                                <option value="">Please Select</option>
                                <option value = "Coincident">Coincident</option>
                                <option value = "Deviated">Deviated</option>
							</select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Deviated_Remarks"><small>Deviated Remarks</small></label>
	                        <input type="text" class="form-control" name="Deviated_Remarks" id="Deviated_Remarks">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Tonsils"><small>Tonsils</small></label>
	                        <input type="text" class="form-control" name="Tonsils" id="Tonsils">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Lesions"><small>Lesions</small></label>
	                        <input type="text" class="form-control" name="Lesions" id="Lesions">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Akerly_Type"><small>Akerly Type</small></label>
                            <select class="form-control" name="Akerly_Type" id="Akerly_Type"> 
                                <option value="">Please Select</option>
                                <option value = "I">I</option>
                                <option value = "II">II</option>
                                <option value = "III">III</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Symmetry"><small>Symmetry</small></label>
	                        <input type="text" class="form-control" name="Symmetry" id="Symmetry">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Missing_Teeth"><small>Missing Teeth</small></label>
	                        <input type="text" class="form-control" name="Missing_Teeth" id="Missing_Teeth">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Malformed_Teeth"><small>Malformed_Teeth</small></label>
	                        <input type="text" class="form-control" name="Malformed_Teeth" id="Malformed_Teeth">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Calculus"><small>Calculus:</small></label>
	                        <input type="text" class="form-control" name="Calculus" id="Calculus">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Other"><small>Other</small></label>
	                        <input type="text" class="form-control" name="Other" id="Other">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Rotations"><small>Rotations</small></label>
	                        <input type="text" class="form-control" name="Rotations" id="Rotations">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Crowding"><small>Crowding</small></label>
	                        <input type="text" class="form-control" name="Crowding" id="Crowding">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Spacing"><small>Spacing:</small></label>
	                        <input type="text" class="form-control" name="Spacing" id="Spacing">
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="Impacted_Teeth"><small>Impacted Teeth</small></label>
	                        <input type="text" class="form-control" name="Impacted_Teeth" id="Impacted_Teeth">
                        </div>
                    </div>
                    <div class="form-row">
                    	<div class="col-md-12 mb-12 form-group">
                            <p><strong>IOTN (Index of Ortho Treatment Need):</strong></p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-6 form-group">
                            <label for="Aesthetic"><small>Aesthetic</small></label>
	                        <input type="text" class="form-control" name="Aesthetic" id="Aesthetic">
                        </div>
                        <div class="col-md-6 mb-6 form-group">
                            <label for="Dental_nhis"><small>Dental nhis</small></label>
	                        <input type="text" class="form-control" name="Dental_nhis" id="Dental_nhis">
                        </div>
                    </div>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="assess_intra_save" name="assess_intra_save" class="btn btn-primary">Save</button>
			        <button type="button" id="assess_intra_update" name="assess_intra_update" class="btn btn-primary">Update</button>
			        <button type="button" id="assess_intra_cancel" name="assess_intra_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<div 
	class="modal fade hide bd-example-modal-lg" 
	id="add_dental_chart_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="add_dental_chart_modal" 
	aria-hidden="true"
	data-backdrop="static"
	data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title m-0 font-weight-bold text-primary" id="add_dental_chart_modal_title">Chart Entry</h5>
	    	</div>
	    		<form id="add_dental_chart_form" action="#" method="POST">
				    <div class="modal-body">
		    			<div id="dental_chart_modal_div">
		                    <div class="form-row">
		                        <div class="col-md-12 mb-12 form-group">
		                        	<input type="hidden" class="form-control" name="dental_chart_id" id="dental_chart_id">
		                        	<input type="hidden" class="form-control" name="tooth_id" id="tooth_id">
		                            <label for="chart_date"><small>Date</small></label>
			                        <input type="date" class="form-control" name="chart_date" id="chart_date">
		                        </div>
		                    </div>
		                    <div class="form-row">
		                        <div class="col-md-12 mb-12 form-group">
		                            <label for="chart_remark"><small>Remarks</small></label>
		                            <textarea class="form-control" id="chart_remark" name="chart_remark" rows="6"></textarea>
		                        </div>
		                    </div>
						</div>
	    			</div>
				    <div class="modal-footer">
				        <button type="button" id="dental_chart_save" name="dental_chart_save" class="btn btn-primary">Save</button>
				        <button type="button" id="dental_chart_update_btn" name="dental_chart_update_btn" class="btn btn-primary">Update</button>
				        <button type="button" id="dental_chart_cancel" name="dental_chart_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    </div>
				</form>
			
	    </div>
	</div>
</div>
<div 
	class="modal fade hide bd-example" 
	id="dialog_dental_chart_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="dialog_dental_chart_modal" 
	aria-hidden="true"
	data-backdrop="static"
	data-keyboard="false">
		<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title m-0 font-weight-bold text-primary" id="dialog_dental_chart_modal_title">Dental Chart Dialog</h5>
	    	</div>
			<form id="dialog_dental_chart_form" action="#" method="POST">
			    <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12 mb-12 form-group">
                            <h5 id="dialog_question"></h5>
                        </div>
                    </div>
                </div>
			    <div class="modal-footer">
			        <button type="button" id="dialog_dental_chart_new_entry" name="dialog_dental_chart_new_entry" class="btn btn-primary">New</button>
			        <button type="button" id="dialog_dental_chart_edit_entry" name="dialog_dental_chart_edit_entry" class="btn btn-primary">Edit</button>
			        <button type="button" id="dialog_dental_chart_view_entry" name="dialog_dental_chart_view_entry" class="btn btn-primary">View</button>
			        <button type="button" id="dialog_dental_chart_cancel" name="dialog_dental_chart_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>