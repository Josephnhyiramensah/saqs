<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
?>
<div id="eyes">
	<ul class="nav nav-tabs nav-justified">
		<li class="nav-item active"><a class="nav-link" aria-current="page" data-toggle="tab" href="#current_episode"><strong>CURRENT EPISODE</strong></a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#all_episodes"><strong>ALL EPISODES</strong></a></li>
	</ul>
	<div class="tab-content">
		<div id="current_episode" class="tab-pane fade show active">
			<ul class="nav nav-tabs nav-justified">
				<li class="nav-item active"><a class="nav-link" aria-current="page" data-toggle="tab" href="#visual_acuity">VISUAL ACUITY</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eye_ocular_examination">OCULAR EXAMINATION</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eye_refraction">REFRACTION</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eye_lens">LENS</a></li>
			</ul>
			<div class="tab-content">
				<div id="visual_acuity" class="tab-pane fade show active">
					<?php
						$query = "SELECT * FROM eye_visual_acuity WHERE attend_id='$attend_id'";
						$query_run = mysqli_query($con, $query);
		                if (mysqli_num_rows($query_run) > 0)
		                {
		                	$row = mysqli_fetch_assoc($query_run);
		            
		            		if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Eye'] == 'Yes')) 
					        {
					            echo '<button type="button" name="edit_eye_visual_acuity_btn" id="edit_eye_visual_acuity_btn" class="btn btn-secondary" data-id="'.$row['eye_va_id'].'">Edit Visual Acuity</button>';
					        };
		            
		                }
		                else 
		                {
		           
		            		if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Eye'] == 'Yes')) 
					        {
					            echo '<button type="button" name="add_eye_visual_acuity_btn" id="add_eye_visual_acuity_btn" class="btn btn-primary">Add Visual Acuity</button>';
					        };
		            
		                };
		            ?>
					
					<div class="table-responsive" id="eye_visual_acuity_table">
					    <table class="table table-hover table-bordered table-sm" id="eye_visual_acuityTable" width="100%" cellspacing="0">
					        <thead>
					            <tr style="background-color:#C3C1C1; color:white">
					                <th width="20%"><h6><strong>PARTICULARS</strong></h6></th>
					                <th width="40%"><h6><strong>RIGHT</strong></h6></th>
					                <th width="40%"><h6><strong>LEFT</strong></h6></th>
					            </tr>
					        </thead>
					        <tbody class="pv-table-body">
					            <?php
					                if (mysqli_num_rows($query_run) > 0)
					                {
					            ?>
					                <tr>
						            	<td>UNAIDED:</td>
					                    <td><?php echo $row['unaided_R'];?></td>
					                    <td><?php echo $row['unaided_L'];?></td>
					                </tr>
					                <tr>
					                    <td>PINHOLE:</td>
					                    <td><?php echo $row['pinhole_R'];?></td>
					                    <td><?php echo $row['pinhole_L'];?></td>
					                </tr>
					                <tr>
					                    <td>AIDED:</td>
					                    <td><?php echo $row['aided_R'];?></td>
					                    <td><?php echo $row['aided_L'];?></td>
					                </tr>
					                <tr>
					                    <td>IOP</td>
					                    <td><?php echo $row['IOP_R'];?></td>
					                    <td><?php echo $row['IOP_L'];?></td>
					                </tr>
					                <tr>
					                    <td>Remarks</td>
					                    <td colspan="2"><?php echo $row['Remarks'];?></td>
					                </tr>
					            <?php
					                };
					            ?>
					        </tbody>
					    </table>
					</div>
				</div>
				<div id="eye_ocular_examination" class="tab-pane fade">
					<?php
						$query = "SELECT * FROM eye_ocular_exam WHERE attend_id='$attend_id'";
						$query_run = mysqli_query($con, $query);
		                if (mysqli_num_rows($query_run) > 0)
		                {
		                	$row = mysqli_fetch_assoc($query_run);
		            
		            		if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Eye'] == 'Yes')) 
					        {
					            echo '<button type="button" name="edit_eye_ocular_exam_btn" id="edit_eye_ocular_exam_btn" class="btn btn-secondary" data-id="'.$row['eye_oe_id'].'">Edit Ocular Exam</button>';
					        };
		            
		                }
		                else 
		                {
		           
		            		if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Eye'] == 'Yes')) 
					        {
					            echo '<button type="button" name="add_eye_ocular_exam_btn" id="add_eye_ocular_exam_btn" class="btn btn-primary">Add Ocular Exams</button>';
					        };
		            
		                };
		            ?>
					
					<div class="table-responsive" id="eye_ocular_exam_table">
					    <table class="table table-hover table-bordered table-sm" id="eye_ocular_examTable" width="100%" cellspacing="0">
					        <thead>
					            <tr style="background-color:#C3C1C1; color:white">
					                <th width="20%"><h6><strong>PARTICULARS</strong></h6></th>
					                <th width="25%"><h6><strong>RIGHT VISION</strong></h6></th>
					                <th width="25%"><h6><strong>LEFT VISION</strong></h6></th>
					                <th width="30%"><h6><strong>REMARKS</strong></h6></th>
					            </tr>
					        </thead>
					        <tbody class="pv-table-body">
					            <?php
					                if (mysqli_num_rows($query_run) > 0)
					                {
					            ?>
					                <tr>
						            	<td>LID:</td>
					                    <td><?php echo $row['LID_R'];?></td>
					                    <td><?php echo $row['LID_L'];?></td>
					                    <td><?php echo $row['LID_Remarks'];?></td>
					                </tr>
					                <tr>
					                    <td>CONJUNCTIVA:</td>
					                    <td><?php echo $row['CONJUNCTIVA_R'];?></td>
					                    <td><?php echo $row['CONJUNCTIVA_L'];?></td>
					                    <td><?php echo $row['CONJUNCTIVA_Remarks'];?></td>
					                </tr>
					                <tr>
					                    <td>CORNEA:</td>
					                    <td><?php echo $row['CORNEA_R'];?></td>
					                    <td><?php echo $row['CORNEA_L'];?></td>
					                    <td><?php echo $row['CORNEA_Remarks'];?></td>
					                </tr>
					                <tr>
					                    <td>AC</td>
					                    <td><?php echo $row['AC_R'];?></td>
					                    <td><?php echo $row['AC_L'];?></td>
					                    <td><?php echo $row['AC_Remarks'];?></td>
					                </tr>
					                <tr>
					                    <td>PUPIL</td>
					                    <td><?php echo $row['PUPIL_R'];?></td>
					                    <td><?php echo $row['PUPIL_L'];?></td>
					                    <td><?php echo $row['PUPIL_Remarks'];?></td>
					                </tr>
					                <tr>
					                    <td>LENS</td>
					                    <td><?php echo $row['LENS_R'];?></td>
					                    <td><?php echo $row['LENS_L'];?></td>
					                    <td><?php echo $row['LENS_Remarks'];?></td>
					                </tr>
					                <tr>
					                    <td>VITREOUS</td>
					                    <td><?php echo $row['VITREOUS_R'];?></td>
					                    <td><?php echo $row['VITREOUS_L'];?></td>
					                    <td><?php echo $row['VITREOUS_Remarks'];?></td>
					                </tr>
					                <tr>
					                    <td>FUNDUS</td>
					                    <td><?php echo $row['FUNDUS_R'];?></td>
					                    <td><?php echo $row['FUNDUS_L'];?></td>
					                    <td><?php echo $row['FUNDUS_Remarks'];?></td>
					                </tr>
					                <tr>
					                    <td>VC/D</td>
					                    <td><?php echo $row['VC_D_R'];?></td>
					                    <td><?php echo $row['VC_D_L'];?></td>
					                    <td><?php echo $row['VC_D_Remarks'];?></td>
					                </tr>
					                <tr>
					                    <td>IOP</td>
					                    <td><?php echo $row['IOP_R'];?></td>
					                    <td><?php echo $row['IOP_L'];?></td>
					                    <td><?php echo $row['IOP_Remarks'];?></td>
					                </tr>
					                <tr>
					                    <td>Remarks</td>
					                    <td colspan="3"><?php echo $row['remarks'];?></td>
					                </tr>
					            <?php
					                };
					            ?>
					        </tbody>
					    </table>
					</div>
				</div>
				<div id="eye_refraction" class="tab-pane fade">
					<?php
						$query = "SELECT * FROM eye_refraction WHERE attend_id='$attend_id'";
						$query_run = mysqli_query($con, $query);
		                if (mysqli_num_rows($query_run) > 0)
		                {
		                	$row = mysqli_fetch_assoc($query_run);
		           
		            		if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Eye'] == 'Yes')) 
					        {
					            echo '<button type="button" name="edit_eye_refraction_btn" id="edit_eye_refraction_btn" class="btn btn-secondary" data-id="'.$row['eye_ref_id'].'">Edit Eye Refraction</button>';
					        };
		            
		                }
		                else 
		                {
		            
		            		if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Eye'] == 'Yes')) 
					        {
					            echo '<button type="button" name="add_eye_refraction_btn" id="add_eyerefraction_btn" class="btn btn-primary">Add Eye Refraction</button>';
					        };
		            
		                };
		            ?>
					
					<div class="table-responsive" id="eye_refraction_table">
					    <table class="table table-hover table-bordered table-sm" id="eye_refractionTable" width="100%" cellspacing="0">
					        <thead>
					            <tr style="background-color:#C3C1C1; color:white">
					                <th width="20%"><h6><strong>PARTICULARS</strong></h6></th>
					                <th width="40%"><h6><strong>RIGHT VISION</strong></h6></th>
					                <th width="40%"><h6><strong>LEFT VISION</strong></h6></th>
					            </tr>
					        </thead>
					        <tbody class="pv-table-body">
					            <?php
					                if (mysqli_num_rows($query_run) > 0)
					                {
					            ?>
					                <tr>
						            	<td>SPH:</td>
					                    <td><?php echo $row['SPH_R'];?></td>
					                    <td><?php echo $row['SPH_L'];?></td>
					                </tr>
					                <tr>
					                    <td>CYL:</td>
					                    <td><?php echo $row['CYL_R'];?></td>
					                    <td><?php echo $row['CYL_L'];?></td>
					                </tr>
					                <tr>
					                    <td>AXIS:</td>
					                    <td><?php echo $row['AXIS_R'];?></td>
					                    <td><?php echo $row['AXIS_L'];?></td>
					                </tr>
					                <tr>
					                    <td>ADD:</td>
					                    <td><?php echo $row['ADD_R'];?></td>
					                    <td><?php echo $row['ADD_L'];?></td>
					                </tr>
					                <tr>
					                    <td>HGT:</td>
					                    <td><?php echo $row['HGT_R'];?></td>
					                    <td><?php echo $row['HGT_L'];?></td>
					                </tr>
					                <tr>
					                    <td>PD:</td>
					                    <td><?php echo $row['PD_R'];?></td>
					                    <td><?php echo $row['PD_L'];?></td>
					                </tr>
					                <tr>
					                    <td>Remarks</td>
					                    <td colspan="2"><?php echo $row['Remarks'];?></td>
					                </tr>
					            <?php
					                };
					            ?>
					        </tbody>
					    </table>
					</div>
				</div>
				<div id="eye_lens" class="tab-pane fade">
					<?php
						$query = "SELECT * FROM eye_lens WHERE attend_id='$attend_id'";
						$query_run = mysqli_query($con, $query);
		                if (mysqli_num_rows($query_run) > 0)
		                {
		                	$row = mysqli_fetch_assoc($query_run);
		            
		            		if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Eye'] == 'Yes')) 
					        {
					            echo '<button type="button" name="edit_eye_lens_btn" id="edit_eye_lens_btn" class="btn btn-secondary" data-id="'.$row['eye_lens_id'].'">Edit Lens</button>';
					        };
		            
		                }
		                else 
		                {
		           
		            		if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Eye'] == 'Yes')) 
					        {
					            echo '<button type="button" name="add_eye_lens_btn" id="add_eye_lens_btn" class="btn btn-primary">Add Lens</button>';
					        };
		            
		                };
		            ?>
					
					<div class="table-responsive" id="eye_lens_table">
					    <table class="table table-hover table-bordered table-sm" id="eye_lensTable" width="100%" cellspacing="0">
					        <thead>
					            <tr style="background-color:#C3C1C1; color:white">
					                <th width="30%"><h6><strong>PARTICULARS</strong></h6></th>
					                <th width="70%"><h6><strong>DETAILS</strong></h6></th>
					            </tr>
					        </thead>
					        <tbody class="pv-table-body">
				            <?php
				                if (mysqli_num_rows($query_run) > 0)
				                {
				            ?>
					                <tr>
						            	<td>LENS TYPE:</td>
					                    <td><?php echo $row['lens_type'];?></td>
					                </tr>
					                <tr>
					                    <td>LENS MATERIAL:</td>
					                    <td><?php echo $row['lens_material'];?></td>
					                </tr>
					                <tr>
					                    <td>LENS INDEX:</td>
					                    <td><?php echo $row['lens_index'];?></td>
					                </tr>
					                <tr>
					                    <td>LENS FRAME:</td>
					                    <td><?php echo $row['lens_frame'];?></td>
					                </tr>
					                <tr>
					                    <td>LENS OTHERS:</td>
					                    <td><?php echo $row['lens_others'];?></td>
					                </tr>
					                <tr>
					                    <td>REMARKS:</td>
					                    <td colspan="2"><?php echo $row['remarks'];?></td>
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
		<div id="all_episodes" class="tab-pane fade">
		    <ul class="nav nav-tabs nav-justified">
				<li class="nav-item active"><a class="nav-link" aria-current="page" data-toggle="tab" href="#visual_acuity_all">ALL VISUAL ACUITY</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eye_ocular_examination_all">ALL OCULAR EXAMINATION</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eye_refraction_all">ALL REFRACTION</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eye_lens_all">ALL LENS</a></li>
			</ul>
			<div class="tab-content">
				<div id="visual_acuity_all" class="tab-pane fade show active">
					<table class="table table-hover table-bordered table-sm" id="visual_acuity_allTable" width="100%" cellspacing="0">
				        <thead>
				            <tr style="background-color:#C3C1C1; color:white">
				                <th width="20%"><h6><strong>PARTICULARS</strong></h6></th>
				                <th width="40%"><h6><strong>RIGHT</strong></h6></th>
				                <th width="40%"><h6><strong>LEFT</strong></h6></th>
				            </tr>
				        </thead>
				        <tbody class="pv-table-body">
							<?php
								$query = "SELECT * FROM eye_visual_acuity WHERE patient_id='$patient_id' ORDER BY date DESC";
								$query_run = mysqli_query($con, $query);
				                if (mysqli_num_rows($query_run) > 0)
				                {
				                	while($row = mysqli_fetch_assoc($query_run))
				                	{
										echo'<tr style="background-color:#DCCDCD; color:black">
								            	<td colspan = "3"><strong>'.$row['date'].'</strong></td>
							                </tr>
							                <tr>
								            	<td>UNAIDED:</td>
							                    <td>'.$row['unaided_R'].'</td>
							                    <td>'.$row['unaided_L'].'</td>
							                </tr>
							                <tr>
							                    <td>PINHOLE:</td>
							                    <td>'.$row['pinhole_R'].'</td>
							                    <td>'.$row['pinhole_L'].'</td>
							                </tr>
							                <tr>
							                    <td>AIDED:</td>
							                    <td>'.$row['aided_R'].'</td>
							                    <td>'.$row['aided_L'].'</td>
							                </tr>
							                <tr>
							                    <td>IOP</td>
							                    <td>'.$row['IOP_R'].'</td>
							                    <td>'.$row['IOP_L'].'</td>
							                </tr>
							                <tr>
							                    <td>Remarks</td>
							                    <td colspan="2">'.$row['Remarks'].'</td>
							                </tr>';
				                	};
				            		
				                };
				            ?>
				        </tbody>
					</table>
				</div>
				<div id="eye_ocular_examination_all" class="tab-pane fade">
					<table class="table table-hover table-bordered table-sm" id="eye_ocular_exam_allTable" width="100%" cellspacing="0">
				        <thead>
				            <tr style="background-color:#C3C1C1; color:white">
				                <th width="20%"><h6><strong>PARTICULARS</strong></h6></th>
				                <th width="25%"><h6><strong>RIGHT VISION</strong></h6></th>
				                <th width="25%"><h6><strong>LEFT VISION</strong></h6></th>
				                <th width="30%"><h6><strong>REMARKS</strong></h6></th>
				            </tr>
				        </thead>
				        <tbody class="pv-table-body">
							<?php
								$query = "SELECT * FROM eye_ocular_exam WHERE patient_id='$patient_id' ORDER BY date DESC";
								$query_run = mysqli_query($con, $query);
				                if (mysqli_num_rows($query_run) > 0)
				                {
				                	while($row = mysqli_fetch_assoc($query_run))
				                	{
										echo'<tr style="background-color:#DCCDCD; color:black">
								            	<td colspan = "4"><strong>'.$row['date'].'</strong></td>
							                </tr>
							                <tr>
								            	<td>LID:</td>
							                    <td>'.$row['LID_R'].'</td>
							                    <td>'.$row['LID_L'].'</td>
							                    <td>'.$row['LID_Remarks'].'</td>
							                </tr>
							                <tr>
							                    <td>CONJUNCTIVA:</td>
							                    <td>'.$row['CONJUNCTIVA_R'].'</td>
							                    <td>'.$row['CONJUNCTIVA_L'].'</td>
							                    <td>'.$row['CONJUNCTIVA_Remarks'].'</td>
							                </tr>
							                <tr>
							                    <td>CORNEA:</td>
							                    <td>'.$row['CORNEA_R'].'</td>
							                    <td>'.$row['CORNEA_L'].'</td>
							                    <td>'.$row['CORNEA_Remarks'].'</td>
							                </tr>
							                <tr>
							                    <td>AC</td>
							                    <td>'.$row['AC_R'].'</td>
							                    <td>'.$row['AC_L'].'</td>
							                    <td>'.$row['AC_Remarks'].'</td>
							                </tr>
							                <tr>
							                    <td>PUPIL</td>
							                    <td>'.$row['PUPIL_R'].'</td>
							                    <td>'.$row['PUPIL_L'].'</td>
							                    <td>'.$row['PUPIL_Remarks'].'</td>
							                </tr>
							                <tr>
							                    <td>LENS</td>
							                    <td>'.$row['LENS_R'].'</td>
							                    <td>'.$row['LENS_L'].'</td>
							                    <td>'.$row['LENS_Remarks'].'</td>
							                </tr>
							                <tr>
							                    <td>VITREOUS</td>
							                    <td>'.$row['VITREOUS_R'].'</td>
							                    <td>'.$row['VITREOUS_L'].'</td>
							                    <td>'.$row['VITREOUS_Remarks'].'</td>
							                </tr>
							                <tr>
							                    <td>FUNDUS</td>
							                    <td>'.$row['FUNDUS_R'].'</td>
							                    <td>'.$row['FUNDUS_L'].'</td>
							                    <td>'.$row['FUNDUS_Remarks'].'</td>
							                </tr>
							                <tr>
							                    <td>VC/D</td>
							                    <td>'.$row['VC_D_R'].'</td>
							                    <td>'.$row['VC_D_L'].'</td>
							                    <td>'.$row['VC_D_Remarks'].'</td>
							                </tr>
							                <tr>
							                    <td>IOP</td>
							                    <td>'.$row['IOP_R'].'</td>
							                    <td>'.$row['IOP_L'].'</td>
							                    <td>'.$row['IOP_Remarks'].'</td>
							                </tr>
							                <tr>
							                    <td>REMARKS</td>
							                    <td colspan="3">'.$row['remarks'].'</td>
							                </tr>';
				                	};
				            		
				                };
				            ?>
				        </tbody>
					</table>
				</div>
				<div id="eye_refraction_all" class="tab-pane fade">
					<table class="table table-hover table-bordered table-sm" id="eye_refraction_allTable" width="100%" cellspacing="0">
				        <thead>
				            <tr style="background-color:#C3C1C1; color:white">
				                <th width="20%"><h6><strong>PARTICULARS</strong></h6></th>
				                <th width="40%"><h6><strong>RIGHT VISION</strong></h6></th>
				                <th width="40%"><h6><strong>LEFT VISION</strong></h6></th>
				            </tr>
				        </thead>
				        <tbody class="pv-table-body">
							<?php
								$query = "SELECT * FROM eye_refraction WHERE patient_id='$patient_id' ORDER BY date DESC";
								$query_run = mysqli_query($con, $query);
				                if (mysqli_num_rows($query_run) > 0)
				                {
				                	while($row = mysqli_fetch_assoc($query_run))
				                	{
										echo'<tr style="background-color:#DCCDCD; color:black">
								            	<td colspan = "3"><strong>'.$row['date'].'</strong></td>
							                </tr>
							                <tr>
								            	<td>SPH:</td>
							                    <td>'.$row['SPH_R'].'</td>
							                    <td>'.$row['SPH_L'].'</td>
							                </tr>
							                <tr>
							                    <td>CYL:</td>
							                    <td>'.$row['CYL_R'].'</td>
							                    <td>'.$row['CYL_L'].'</td>
							                </tr>
							                <tr>
							                    <td>AXIS:</td>
							                    <td>'.$row['AXIS_R'].'</td>
							                    <td>'.$row['AXIS_L'].'</td>
							                </tr>
							                <tr>
							                    <td>ADD:</td>
							                    <td>'.$row['ADD_R'].'</td>
							                    <td>'.$row['ADD_L'].'</td>
							                </tr>
							                <tr>
							                    <td>HGT:</td>
							                    <td>'.$row['HGT_R'].'</td>
							                    <td>'.$row['HGT_L'].'</td>
							                </tr>
							                <tr>
							                    <td>PD:</td>
							                    <td>'.$row['PD_R'].'</td>
							                    <td>'.$row['PD_L'].'</td>
							                </tr>
							                <tr>
							                    <td>Remarks</td>
							                    <td colspan="2">'.$row['Remarks'].'</td>
							                </tr>';
				                	};
				            		
				                };
				            ?>
				        </tbody>
					</table>
				</div>
				<div id="eye_lens_all" class="tab-pane fade">
					<table class="table table-hover table-bordered table-sm" id="eye_lens_allTable" width="100%" cellspacing="0">
				        <thead>
				            <tr style="background-color:#C3C1C1; color:white">
				                <th width="30%"><h6><strong>PARTICULARS</strong></h6></th>
				                <th width="70%"><h6><strong>DETAILS</strong></h6></th>
				            </tr>
				        </thead>
				        <tbody class="pv-table-body">
							<?php
								$query = "SELECT * FROM eye_lens WHERE patient_id='$patient_id' ORDER BY date DESC";
								$query_run = mysqli_query($con, $query);
				                if (mysqli_num_rows($query_run) > 0)
				                {
				                	while($row = mysqli_fetch_assoc($query_run))
				                	{
										echo'<tr style="background-color:#DCCDCD; color:black">
								            	<td colspan = "3"><strong>'.$row['date'].'</strong></td>
							                </tr>
							                <tr>
								            	<td>LENS TYPE:</td>
							                    <td>'.$row['lens_type'].'</td>
							                </tr>
							                <tr>
							                    <td>LENS MATERIAL:</td>
							                    <td>'.$row['lens_material'].'</td>
							                </tr>
							                <tr>
							                    <td>LENS INDEX:</td>
							                    <td>'.$row['lens_index'].'</td>
							                </tr>
							                <tr>
							                    <td>LENS FRAME:</td>
							                    <td>'.$row['lens_frame'].'</td>
							                </tr>
							                <tr>
							                    <td>LENS OTHERS:</td>
							                    <td>'.$row['lens_others'].'</td>
							                </tr>
							                <tr>
							                    <td>REMARKS:</td>
							                    <td colspan="2">'.$row['remarks'].'</td>
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
<div 
	class="modal fade hide bd-example-modal-xl" 
	id="add_eye_visual_acuity_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="add_eye_visual_acuity_modal" 
	aria-hidden="true"
	data-backdrop="static"
	data-keyboard="false">
		<div class="modal-dialog modal-xl" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title m-0 font-weight-bold text-primary" id="add_eye_visual_acuity_modal_title">VISUAL ACUITY</h5>
	    	</div>
			<form id="add_eye_visual_acuity_form" action="#" method="POST">
			    <div class="modal-body">
                            <input type="hidden" class="form-control" name="eye_visual_acuity_id" id="eye_visual_acuity_id">
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <label for="eye_visual_acuity_right"><h6><strong>RIGHT</strong></h6></label>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <label for="eye_visual_acuity_left"><h6><strong>LEFT</strong></h6></label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_visual_acuity_unaided"><h6><strong>UNAIDED</strong></h6></label>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_visual_acuity_unaided_right" id="eye_visual_acuity_unaided_right"> 
                                <option value="0">Please Select</option>
                                <option value = "6/4">6/4</option>
                                <option value = "6/5">6/5</option>
                                <option value = "6/6">6/6</option>
                                <option value = "6/9">6/9</option>
                                <option value = "6/12">6/12</option>
                                <option value = "6/18">6/18</option>
                                <option value = "6/24">6/24</option>
                                <option value = "6/36">6/36</option>
                                <option value = "6/60">6/60</option>
                                <option value = "3/60">3/60</option>
                                <option value = "1/60">1/60</option>
                                <option value = "CF3M">CF3M</option>
                                <option value = "CF2M">CF2M</option>
                                <option value = "CF1M">CF1M</option>
                                <option value = "MM">MM</option>
                                <option value = "PL">PL</option>
                                <option value = "NPL">NPL</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_visual_acuity_unaided_left" id="eye_visual_acuity_unaided_left"> 
                                <option value="0">Please Select</option>
                                <option value = "6/4">6/4</option>
                                <option value = "6/5">6/5</option>
                                <option value = "6/6">6/6</option>
                                <option value = "6/9">6/9</option>
                                <option value = "6/12">6/12</option>
                                <option value = "6/18">6/18</option>
                                <option value = "6/24">6/24</option>
                                <option value = "6/36">6/36</option>
                                <option value = "6/60">6/60</option>
                                <option value = "3/60">3/60</option>
                                <option value = "1/60">1/60</option>
                                <option value = "CF3M">CF3M</option>
                                <option value = "CF2M">CF2M</option>
                                <option value = "CF1M">CF1M</option>
                                <option value = "MM">MM</option>
                                <option value = "PL">PL</option>
                                <option value = "NPL">NPL</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_visual_acuity_pinhole"><h6><strong>PINHOLE</strong></h6></label>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_visual_acuity_pinhole_right" id="eye_visual_acuity_pinhole_right"> 
                                <option value="0">Please Select</option>
                                <option value = "6/4">6/4</option>
                                <option value = "6/5">6/5</option>
                                <option value = "6/6">6/6</option>
                                <option value = "6/9">6/9</option>
                                <option value = "6/12">6/12</option>
                                <option value = "6/18">6/18</option>
                                <option value = "6/24">6/24</option>
                                <option value = "6/36">6/36</option>
                                <option value = "6/60">6/60</option>
                                <option value = "3/60">3/60</option>
                                <option value = "1/60">1/60</option>
                                <option value = "CF3M">CF3M</option>
                                <option value = "CF2M">CF2M</option>
                                <option value = "CF1M">CF1M</option>
                                <option value = "MM">MM</option>
                                <option value = "PL">PL</option>
                                <option value = "NPL">NPL</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_visual_acuity_pinhole_left" id="eye_visual_acuity_pinhole_left"> 
                                <option value="0">Please Select</option>
                                <option value = "6/4">6/4</option>
                                <option value = "6/5">6/5</option>
                                <option value = "6/6">6/6</option>
                                <option value = "6/9">6/9</option>
                                <option value = "6/12">6/12</option>
                                <option value = "6/18">6/18</option>
                                <option value = "6/24">6/24</option>
                                <option value = "6/36">6/36</option>
                                <option value = "6/60">6/60</option>
                                <option value = "3/60">3/60</option>
                                <option value = "1/60">1/60</option>
                                <option value = "CF3M">CF3M</option>
                                <option value = "CF2M">CF2M</option>
                                <option value = "CF1M">CF1M</option>
                                <option value = "MM">MM</option>
                                <option value = "PL">PL</option>
                                <option value = "NPL">NPL</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_visual_acuity_aided"><h6><strong>AIDED</strong></h6></label>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_visual_acuity_aided_right" id="eye_visual_acuity_aided_right"> 
                                <option value="0">Please Select</option>
                                <option value = "6/4">6/4</option>
                                <option value = "6/5">6/5</option>
                                <option value = "6/6">6/6</option>
                                <option value = "6/9">6/9</option>
                                <option value = "6/12">6/12</option>
                                <option value = "6/18">6/18</option>
                                <option value = "6/24">6/24</option>
                                <option value = "6/36">6/36</option>
                                <option value = "6/60">6/60</option>
                                <option value = "3/60">3/60</option>
                                <option value = "1/60">1/60</option>
                                <option value = "CF3M">CF3M</option>
                                <option value = "CF2M">CF2M</option>
                                <option value = "CF1M">CF1M</option>
                                <option value = "MM">MM</option>
                                <option value = "PL">PL</option>
                                <option value = "NPL">NPL</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_visual_acuity_aided_left" id="eye_visual_acuity_aided_left"> 
                                <option value="0">Please Select</option>
                                <option value = "6/4">6/4</option>
                                <option value = "6/5">6/5</option>
                                <option value = "6/6">6/6</option>
                                <option value = "6/9">6/9</option>
                                <option value = "6/12">6/12</option>
                                <option value = "6/18">6/18</option>
                                <option value = "6/24">6/24</option>
                                <option value = "6/36">6/36</option>
                                <option value = "6/60">6/60</option>
                                <option value = "3/60">3/60</option>
                                <option value = "1/60">1/60</option>
                                <option value = "CF3M">CF3M</option>
                                <option value = "CF2M">CF2M</option>
                                <option value = "CF1M">CF1M</option>
                                <option value = "MM">MM</option>
                                <option value = "PL">PL</option>
                                <option value = "NPL">NPL</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_visual_acuity_iop"><h6><strong>IOP</strong></h6></label>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_visual_acuity_iop_right" id="eye_visual_acuity_iop_right"> 
                                <option value="0">Please Select</option>
                                <option value = "6/4">6/4</option>
                                <option value = "6/5">6/5</option>
                                <option value = "6/6">6/6</option>
                                <option value = "6/9">6/9</option>
                                <option value = "6/12">6/12</option>
                                <option value = "6/18">6/18</option>
                                <option value = "6/24">6/24</option>
                                <option value = "6/36">6/36</option>
                                <option value = "6/60">6/60</option>
                                <option value = "3/60">3/60</option>
                                <option value = "1/60">1/60</option>
                                <option value = "CF3M">CF3M</option>
                                <option value = "CF2M">CF2M</option>
                                <option value = "CF1M">CF1M</option>
                                <option value = "MM">MM</option>
                                <option value = "PL">PL</option>
                                <option value = "NPL">NPL</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_visual_acuity_iop_left" id="eye_visual_acuity_iop_left"> 
                                <option value="0">Please Select</option>
                                <option value = "6/4">6/4</option>
                                <option value = "6/5">6/5</option>
                                <option value = "6/6">6/6</option>
                                <option value = "6/9">6/9</option>
                                <option value = "6/12">6/12</option>
                                <option value = "6/18">6/18</option>
                                <option value = "6/24">6/24</option>
                                <option value = "6/36">6/36</option>
                                <option value = "6/60">6/60</option>
                                <option value = "3/60">3/60</option>
                                <option value = "1/60">1/60</option>
                                <option value = "CF3M">CF3M</option>
                                <option value = "CF2M">CF2M</option>
                                <option value = "CF1M">CF1M</option>
                                <option value = "MM">MM</option>
                                <option value = "PL">PL</option>
                                <option value = "NPL">NPL</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-12 form-group">
                            <label for="eye_visual_acuity_remarks"><h6><strong>Remarks</strong></h6></label>
                            <textarea type="textarea" rows="4"  class="form-control" name="eye_visual_acuity_remarks" id="eye_visual_acuity_remarks" value=""></textarea>
                        </div>
                    </div>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="eye_visual_acuity_save" name="eye_visual_acuity_save" class="btn btn-primary">Save</button>
			        <button type="button" id="eye_visual_acuity_update" name="eye_visual_acuity_update" class="btn btn-primary">Update</button>
			        <button type="button" id="eye_visual_acuity_cancel" name="eye_visual_acuity_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<div 
	class="modal fade hide bd-example-modal-xl" 
	id="add_eye_ocular_examamination_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="add_eye_ocular_examamination_modal" 
	aria-hidden="true"
	data-backdrop="static"
	data-keyboard="false">
		<div class="modal-dialog modal-xl" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title m-0 font-weight-bold text-primary" id="add_eye_ocular_examamination_modal_title">Add Eye Ocular Examination</h5>
	    	</div>
			<form id="add_eye_ocular_examamination_form" action="#" method="POST">
			    <div class="modal-body">
                            <input type="hidden" class="form-control" name="eye_ocular_examamination_id" id="eye_ocular_examamination_id">
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <label for="eye_ocular_examamination_right"><h6><strong>RIGHT VISION</strong></h6></label>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <label for="eye_ocular_examamination_left"><h6><strong>LEFT VISION</strong></h6></label>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                            <label for="eye_ocular_examamination_remarks"><h6><strong>REMARKS</strong></h6></label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_ocular_examamination_lid"><h6><strong>LID</strong></h6></label>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_lid_right" id="eoe_lid_right"> 
                                <option value="0">Please Select</option>
                                <option value = "Normal">Normal</option>
                                <option value = "Swollen">Swollen</option>
                                <option value = "Soiled With Discharge">Soiled With Discharge</option>
                                <option value = "Offending Lashes">Offending Lashes</option>
                                <option value = "Growth">Growth</option>
                                <option value = "Crust">Crust</option>
                                <option value = "Ptotic">Ptotic</option>
                                <option value = "Stuck">Stuck</option>
                                <option value = "Retracted">Retracted</option>
                                <option value = "Erythmatous">Erythmatous</option>
                                <option value = "Proptosed">Proptosed</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_lid_left" id="eoe_lid_left"> 
                                <option value="0">Please Select</option>
                                <option value = "Normal">Normal</option>
                                <option value = "Swollen">Swollen</option>
                                <option value = "Soiled With Discharge">Soiled With Discharge</option>
                                <option value = "Offending Lashes">Offending Lashes</option>
                                <option value = "Growth">Growth</option>
                                <option value = "Crust">Crust</option>
                                <option value = "Ptotic">Ptotic</option>
                                <option value = "Stuck">Stuck</option>
                                <option value = "Retracted">Retracted</option>
                                <option value = "Erythmatous">Erythmatous</option>
                                <option value = "Proptosed">Proptosed</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                        	<input type="text" class="form-control" name="eoe_lid_remarks" id="eoe_lid_remarks">
						</div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_ocular_examamination_conjunctiva"><h6><strong>CONJUNCTIVA</strong></h6></label>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_conjunctiva_right" id="eoe_conjunctiva_right"> 
                                <option value="0">Please Select</option>
                                <option value = "Haemorrhage">Haemorrhage</option>
                                <option value = "Lateral Haemorrhage">Lateral Haemorrhage</option>
                                <option value = "superior Haemorrhage">superior Haemorrhage</option>
                                <option value = "medial Haemorrhage">medial Haemorrhage</option>
                                <option value = "inferior Haemorrhage">inferior Haemorrhage</option>
                                <option value = "total Haemorrhage">total Haemorrhage</option>
                                <option value = "Slightly Injected">Slightly Injected</option>
                                <option value = "Injected">Injected</option>
                                <option value = "Medial Growth">Medial Growth</option>
                                <option value = "Lateral Growth">Lateral Growth</option>
                                <option value = "Injected Media Growth">Injected Media Growth</option>
                                <option value = "Injected Lateral Growth">Injected Lateral Growth</option>
                                <option value = "Early Media Growth">Early Media Growth</option>
                                <option value = "Early Lateral Growth">Early Lateral Growth</option>
                                <option value = "medial Haemorrhage">medial Haemorrhage</option>
                                <option value = "Chemosed">Chemosed</option>
                                <option value = "Pink">Pink</option>
                                <option value = "Slightly Injected">Slightly Injected</option>
                                <option value = "Brownish">Brownish</option>
                                <option value = "Tarsal Injection">Tarsal Injection</option>
                                <option value = "Tarsal Foreign Body">Tarsal Foreign Body</option>
                                <option value = "Bulbar Foreign Body">Bulbar Foreign Body</option>
                                <option value = "Normal">Normal</option>
                                <option value = "White">White</option>
                                <option value = "Hyperemic">Hyperemic</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_conjunctiva_left" id="eoe_conjunctiva_left"> 
                                <option value="0">Please Select</option>
                                <option value = "Haemorrhage">Haemorrhage</option>
                                <option value = "Lateral Haemorrhage">Lateral Haemorrhage</option>
                                <option value = "superior Haemorrhage">superior Haemorrhage</option>
                                <option value = "medial Haemorrhage">medial Haemorrhage</option>
                                <option value = "inferior Haemorrhage">inferior Haemorrhage</option>
                                <option value = "total Haemorrhage">total Haemorrhage</option>
                                <option value = "Slightly Injected">Slightly Injected</option>
                                <option value = "Injected">Injected</option>
                                <option value = "Medial Growth">Medial Growth</option>
                                <option value = "Lateral Growth">Lateral Growth</option>
                                <option value = "Injected Media Growth">Injected Media Growth</option>
                                <option value = "Injected Lateral Growth">Injected Lateral Growth</option>
                                <option value = "Early Media Growth">Early Media Growth</option>
                                <option value = "Early Lateral Growth">Early Lateral Growth</option>
                                <option value = "medial Haemorrhage">medial Haemorrhage</option>
                                <option value = "Chemosed">Chemosed</option>
                                <option value = "Pink">Pink</option>
                                <option value = "Slightly Injected">Slightly Injected</option>
                                <option value = "Brownish">Brownish</option>
                                <option value = "Tarsal Injection">Tarsal Injection</option>
                                <option value = "Tarsal Foreign Body">Tarsal Foreign Body</option>
                                <option value = "Bulbar Foreign Body">Bulbar Foreign Body</option>
                                <option value = "Normal">Normal</option>
                                <option value = "White">White</option>
                                <option value = "Hyperemic">Hyperemic</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                        	<input type="text" class="form-control" name="eoe_conjunctiva_remarks" id="eoe_conjunctiva_remarks">
						</div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_ocular_examamination_cornea"><h6><strong>CORNEA</strong></h6></label>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_cornea_right" id="eoe_cornea_right"> 
                                <option value="0">Please Select</option>
                                <option value = "Clear">Clear</option>
                                <option value = "Abrasion">Abrasion</option>
                                <option value = "Central Abrasion">Central Abrasion</option>
                                <option value = "Superior Abrasion">Superior Abrasion</option>
                                <option value = "Inferior Abrasion">Inferior Abrasion</option>
                                <option value = "lateral Abrasion">lateral Abrasion</option>
                                <option value = "Medial Abrasion">Medial Abrasion</option>
                                <option value = "Ulcer">Ulcer</option>
                                <option value = "Superior Ulcer">Superior Ulcer</option>
                                <option value = "Inferior Ulcer">Inferior Ulcer</option>
                                <option value = "Lateral Ulcer">Lateral Ulcer</option>
                                <option value = "Medial Ulcer">Medial Ulcer</option>
                                <option value = "Stain">Stain</option>
                                <option value = "Superior Stain">Superior Stain</option>
                                <option value = "Inferior Stain">Inferior Stain</option>
                                <option value = "Lateral Stain">Lateral Stain</option>
                                <option value = "Medial Stain">Medial Stain</option>
                                <option value = "Foreign Body">Foreign Body</option>
                                <option value = "Superior Foreign Body">Superior Foreign Body</option>
                                <option value = "Inferior Foreign Body">Inferior Foreign Body</option>
                                <option value = "Lateral Foreign Body">Lateral Foreign Body</option>
                                <option value = "Medial Foreign Body">Medial Foreign Body</option>
                                <option value = "Scar">Scar</option>
                                <option value = "Inferior Scar">Inferior Scar</option>
                                <option value = "Central Scar">Central Scar</option>
                                <option value = "Lateral Scar">Lateral Scar</option>
                                <option value = "Medial Scar">Medial Scar</option>
                                <option value = "Total Scar">Total Scar</option>
                                <option value = "KPs">KPs</option>
                                <option value = "Scar">Scar</option>
                                <option value = "Arcus">Arcus</option>
                                <option value = "Limbal Hyper Pigmentation">Limbal Hyper Pigmentation</option>
                                <option value = "Neo Vascularisation">Neo Vascularisation</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_cornea_left" id="eoe_cornea_left"> 
                                <option value="0">Please Select</option>
                                <option value = "Clear">Clear</option>
                                <option value = "Abrasion">Abrasion</option>
                                <option value = "Central Abrasion">Central Abrasion</option>
                                <option value = "Superior Abrasion">Superior Abrasion</option>
                                <option value = "Inferior Abrasion">Inferior Abrasion</option>
                                <option value = "lateral Abrasion">lateral Abrasion</option>
                                <option value = "Medial Abrasion">Medial Abrasion</option>
                                <option value = "Ulcer">Ulcer</option>
                                <option value = "Superior Ulcer">Superior Ulcer</option>
                                <option value = "Inferior Ulcer">Inferior Ulcer</option>
                                <option value = "Lateral Ulcer">Lateral Ulcer</option>
                                <option value = "Medial Ulcer">Medial Ulcer</option>
                                <option value = "Stain">Stain</option>
                                <option value = "Superior Stain">Superior Stain</option>
                                <option value = "Inferior Stain">Inferior Stain</option>
                                <option value = "Lateral Stain">Lateral Stain</option>
                                <option value = "Medial Stain">Medial Stain</option>
                                <option value = "Foreign Body">Foreign Body</option>
                                <option value = "Superior Foreign Body">Superior Foreign Body</option>
                                <option value = "Inferior Foreign Body">Inferior Foreign Body</option>
                                <option value = "Lateral Foreign Body">Lateral Foreign Body</option>
                                <option value = "Medial Foreign Body">Medial Foreign Body</option>
                                <option value = "Scar">Scar</option>
                                <option value = "Inferior Scar">Inferior Scar</option>
                                <option value = "Central Scar">Central Scar</option>
                                <option value = "Lateral Scar">Lateral Scar</option>
                                <option value = "Medial Scar">Medial Scar</option>
                                <option value = "Total Scar">Total Scar</option>
                                <option value = "KPs">KPs</option>
                                <option value = "Scar">Scar</option>
                                <option value = "Arcus">Arcus</option>
                                <option value = "Limbal Hyper Pigmentation">Limbal Hyper Pigmentation</option>
                                <option value = "Neo Vascularisation">Neo Vascularisation</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                        	<input type="text" class="form-control" name="eoe_cornea_remarks" id="eoe_cornea_remarks">
						</div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_ocular_examamination_ac"><h6><strong>AC</strong></h6></label>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_ac_right" id="eoe_ac_right"> 
                                <option value="0">Please Select</option>
                                <option value = "Hyphaema">Hyphaema</option>
                                <option value = "Superior Hyphaema">Superior Hyphaema</option>
                                <option value = "Inferior Hyphaema">Inferior Hyphaema</option>
                                <option value = "Lateral Hyphaema">Lateral Hyphaema</option>
                                <option value = "Medial Hyphaema">Medial Hyphaema</option>
                                <option value = "Total Hyphaema">Total Hyphaema</option>
                                <option value = "Deep">Deep</option>
                                <option value = "Quiet">Quiet</option>
                                <option value = "Shallow">Shallow</option>
                                <option value = "KPS">KPS</option>
                                <option value = "Cells and Flair">Cells and Flair</option>
                                <option value = "CELLS AND FLARE">CELLS AND FLARE</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_ac_left" id="eoe_ac_left"> 
                                <option value="0">Please Select</option>
                                <option value = "Hyphaema">Hyphaema</option>
                                <option value = "Superior Hyphaema">Superior Hyphaema</option>
                                <option value = "Inferior Hyphaema">Inferior Hyphaema</option>
                                <option value = "Lateral Hyphaema">Lateral Hyphaema</option>
                                <option value = "Medial Hyphaema">Medial Hyphaema</option>
                                <option value = "Total Hyphaema">Total Hyphaema</option>
                                <option value = "Deep">Deep</option>
                                <option value = "Quiet">Quiet</option>
                                <option value = "Shallow">Shallow</option>
                                <option value = "KPS">KPS</option>
                                <option value = "Cells and Flair">Cells and Flair</option>
                                <option value = "CELLS AND FLARE">CELLS AND FLARE</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                        	<input type="text" class="form-control" name="eoe_ac_remarks" id="eoe_ac_remarks">
						</div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_ocular_examamination_pupil"><h6><strong>PUPIL</strong></h6></label>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_pupil_right" id="eoe_pupil_right"> 
                                <option value="0">Please Select</option>
                                <option value = "React">React</option>
                                <option value = "Sluggish Reaction">Sluggish Reaction</option>
                                <option value = "Brisk Reaction">Brisk Reaction</option>
                                <option value = "Fixed and Dialated">Fixed and Dialated</option>
                                <option value = "Miotic">Miotic</option>
                                <option value = "RAPD">RAPD</option>
                                <option value = "No RAPD">No RAPD</option>
                                <option value = "Not Round">Not Round</option>
                                <option value = "Round">Round</option>
                                <option value = "Multiples">Multiples</option>
                                <option value = "Synechiae">Synechiae</option>
                                <option value = "Anterior Synechiae">Anterior Synechiae</option>
                                <option value = "Posterior Synechiae">Posterior Synechiae</option>
                                <option value = "Shifted Upwards">Shifted Upwards</option>
                                <option value = "Shifted Downwards">Shifted Downwards</option>
                                <option value = "Shifted to the Right">Shifted to the Right</option>
                                <option value = "Shifted to the Left">Shifted to the Left</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_pupil_left" id="eoe_pupil_left"> 
                                <option value="0">Please Select</option>
                                <option value = "React">React</option>
                                <option value = "Sluggish Reaction">Sluggish Reaction</option>
                                <option value = "Brisk Reaction">Brisk Reaction</option>
                                <option value = "Fixed and Dialated">Fixed and Dialated</option>
                                <option value = "Miotic">Miotic</option>
                                <option value = "RAPD">RAPD</option>
                                <option value = "No RAPD">No RAPD</option>
                                <option value = "Not Round">Not Round</option>
                                <option value = "Round">Round</option>
                                <option value = "Multiples">Multiples</option>
                                <option value = "Synechiae">Synechiae</option>
                                <option value = "Anterior Synechiae">Anterior Synechiae</option>
                                <option value = "Posterior Synechiae">Posterior Synechiae</option>
                                <option value = "Shifted Upwards">Shifted Upwards</option>
                                <option value = "Shifted Downwards">Shifted Downwards</option>
                                <option value = "Shifted to the Right">Shifted to the Right</option>
                                <option value = "Shifted to the Left">Shifted to the Left</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                        	<input type="text" class="form-control" name="eoe_pupil_remarks" id="eoe_pupil_remarks">
						</div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_ocular_examamination_lens"><h6><strong>LENS</strong></h6></label>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_lens_right" id="eoe_lens_right"> 
                                <option value="0">Please Select</option>
                                <option value = "Opacities">Opacities</option>
                                <option value = "Early Changes">Early Changes</option>
                                <option value = "Central Opacity">Central Opacity</option>
                                <option value = "Cortical Opacity">Cortical Opacity</option>
                                <option value = "After Cataract">After Cataract</option>
                                <option value = "Dislocated">Dislocated</option>
                                <option value = "Subluxated">Subluxated</option>
                                <option value = "Pseudophakic">Pseudophakic</option>
                                <option value = "Clear">Clear</option>
                                <option value = "Deposits">Deposits</option>
                                <option value = "Aphakic">Aphakic</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_lens_left" id="eoe_lens_left"> 
                                <option value="0">Please Select</option>
                                <option value = "Opacities">Opacities</option>
                                <option value = "Early Changes">Early Changes</option>
                                <option value = "Central Opacity">Central Opacity</option>
                                <option value = "Cortical Opacity">Cortical Opacity</option>
                                <option value = "After Cataract">After Cataract</option>
                                <option value = "Dislocated">Dislocated</option>
                                <option value = "Subluxated">Subluxated</option>
                                <option value = "Pseudophakic">Pseudophakic</option>
                                <option value = "Clear">Clear</option>
                                <option value = "Deposits">Deposits</option>
                                <option value = "Aphakic">Aphakic</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                        	<input type="text" class="form-control" name="eoe_lens_remarks" id="eoe_lens_remarks">
						</div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_ocular_examamination_vitreous"><h6><strong>VITREOUS</strong></h6></label>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_vitreous_right" id="eoe_vitreous_right"> 
                                <option value="0">Please Select</option>
                                <option value = "Heazy">Heazy</option>
                                <option value = "Clear">Clear</option>
                                <option value = "Floater">Floater</option>
                                <option value = "Floaters">Floaters</option>
                                <option value = "Cells">Cells</option>
                                <option value = "Haemorrhage">Haemorrhage</option>
                                <option value = "No view">No view</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_vitreous_left" id="eoe_vitreous_left"> 
                                <option value="0">Please Select</option>
                                <option value = "Heazy">Heazy</option>
                                <option value = "Clear">Clear</option>
                                <option value = "Floater">Floater</option>
                                <option value = "Floaters">Floaters</option>
                                <option value = "Cells">Cells</option>
                                <option value = "Haemorrhage">Haemorrhage</option>
                                <option value = "No view">No view</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                        	<input type="text" class="form-control" name="eoe_vitreous_remarks" id="eoe_vitreous_remarks">
						</div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_ocular_examamination_fundus"><h6><strong>FUNDUS</strong></h6></label>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_fundus_right" id="eoe_fundus_right"> 
                                <option value="0">Please Select</option>
                                <option value = "Toxo Scar">Toxo Scar</option>
                                <option value = "Inferior Scar">Inferior Scar</option>
                                <option value = "Superior Scar">Superior Scar</option>
                                <option value = "Lateral Scar">Lateral Scar</option>
                                <option value = "Medial Scar">Medial Scar</option>
                                <option value = "Central Scar">Central Scar</option>
                                <option value = "Macula Scar">Macula Scar</option>
                                <option value = "Haemorrhage">Haemorrhage</option>
                                <option value = "Inferior Haemorrhage">Inferior Haemorrhage</option>
                                <option value = "Superior Haemorrhage">Superior Haemorrhage</option>
                                <option value = "Lateral Haemorrhage">Lateral Haemorrhage</option>
                                <option value = "Medial Haemorrhage">Medial Haemorrhage</option>
                                <option value = "Central Haemorrhage">Central Haemorrhage</option>
                                <option value = "Macula Haemorrhage">Macula Haemorrhage</option>
                                <option value = "Disc Haemorrhage">Disc Haemorrhage</option>
                                <option value = "Pigmentation">Pigmentation</option>
                                <option value = "Inferior Pigmentation">Inferior Pigmentation</option>
                                <option value = "Superior Pigmentation">Superior Pigmentation</option>
                                <option value = "Lateral Pigmentation">Lateral Pigmentation</option>
                                <option value = "Medial Pigmentation">Medial Pigmentation</option>
                                <option value = "Central Pigmentation">Central Pigmentation</option>
                                <option value = "Macula Pigmentation">Macula Pigmentation</option>
                                <option value = "General Pigmentation">General Pigmentation</option>
                                <option value = "Retina Detachment">Retina Detachment</option>
                                <option value = "Inferior Detachment">Inferior Detachment</option>
                                <option value = "Superior Detachment">Superior Detachment</option>
                                <option value = "Lateral Detachment">Lateral Detachment</option>
                                <option value = "Medial Detachment">Medial Detachment</option>
                                <option value = "Central Detachment">Central Detachment</option>
                                <option value = "Retinal Tear">Retinal Tear</option>
                                <option value = "Inferior Tear">Inferior Tear</option>
                                <option value = "Superior Tear">Superior Tear</option>
                                <option value = "Lateral Tear">Lateral Tear</option>
                                <option value = "Medial Tear">Medial Tear</option>
                                <option value = "Central Tear">Central Tear</option>
                                <option value = "Macula Hole">Macula Hole</option>
                                <option value = "Chorioretinitis">Chorioretinitis</option>
                                <option value = "Inferior Chorioretinitis">Inferior Chorioretinitis</option>
                                <option value = "Superior Chorioretinitis">Superior Chorioretinitis</option>
                                <option value = "Lateral Chorioretinitis">Lateral Chorioretinitis</option>
                                <option value = "Medial Chorioretinitis">Medial Chorioretinitis</option>
                                <option value = "General Chorioretinitis">General Chorioretinitis</option>
                                <option value = "Vein Occlusion">Vein Occlusion</option>
                                <option value = "Superior Vein Occlusion">Superior Vein Occlusion</option>
                                <option value = "Inferior Vein Occlusion">Inferior Vein Occlusion</option>
                                <option value = "Medial Vein Occlusion">Medial Vein Occlusion</option>
                                <option value = "Lateral Vein Occlusion">Lateral Vein Occlusion</option>
                                <option value = "Central Vein Occlusion">Central Vein Occlusion</option>
                                <option value = "Artery Occlusion">Artery Occlusion</option>
                                <option value = "Superior Artery Occlusion">Superior Artery Occlusion</option>
                                <option value = "Inferior Artery Occlusion">Inferior Artery Occlusion</option>
                                <option value = "Medial Artery Occlusion">Medial Artery Occlusion</option>
                                <option value = "Lateral Artery Occlusion">Lateral Artery Occlusion</option>
                                <option value = "Central Artery Occlusion">Central Artery Occlusion</option>
                                <option value = "Nasal Shifting of Vessels">Nasal Shifting of Vessels</option>
                                <option value = "Beta Zone">Beta Zone</option>
                                <option value = "Disc Suspect">Disc Suspect</option>
                                <option value = "Normal">Normal</option>
                                <option value = "No View">No View</option>
                                <option value = "Poor View">Poor View</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_fundus_left" id="eoe_fundus_left"> 
                                <option value="0">Please Select</option>
                                <option value = "Toxo Scar">Toxo Scar</option>
                                <option value = "Inferior Scar">Inferior Scar</option>
                                <option value = "Superior Scar">Superior Scar</option>
                                <option value = "Lateral Scar">Lateral Scar</option>
                                <option value = "Medial Scar">Medial Scar</option>
                                <option value = "Central Scar">Central Scar</option>
                                <option value = "Macula Scar">Macula Scar</option>
                                <option value = "Haemorrhage">Haemorrhage</option>
                                <option value = "Inferior Haemorrhage">Inferior Haemorrhage</option>
                                <option value = "Superior Haemorrhage">Superior Haemorrhage</option>
                                <option value = "Lateral Haemorrhage">Lateral Haemorrhage</option>
                                <option value = "Medial Haemorrhage">Medial Haemorrhage</option>
                                <option value = "Central Haemorrhage">Central Haemorrhage</option>
                                <option value = "Macula Haemorrhage">Macula Haemorrhage</option>
                                <option value = "Disc Haemorrhage">Disc Haemorrhage</option>
                                <option value = "Pigmentation">Pigmentation</option>
                                <option value = "Inferior Pigmentation">Inferior Pigmentation</option>
                                <option value = "Superior Pigmentation">Superior Pigmentation</option>
                                <option value = "Lateral Pigmentation">Lateral Pigmentation</option>
                                <option value = "Medial Pigmentation">Medial Pigmentation</option>
                                <option value = "Central Pigmentation">Central Pigmentation</option>
                                <option value = "Macula Pigmentation">Macula Pigmentation</option>
                                <option value = "General Pigmentation">General Pigmentation</option>
                                <option value = "Retina Detachment">Retina Detachment</option>
                                <option value = "Inferior Detachment">Inferior Detachment</option>
                                <option value = "Superior Detachment">Superior Detachment</option>
                                <option value = "Lateral Detachment">Lateral Detachment</option>
                                <option value = "Medial Detachment">Medial Detachment</option>
                                <option value = "Central Detachment">Central Detachment</option>
                                <option value = "Retinal Tear">Retinal Tear</option>
                                <option value = "Inferior Tear">Inferior Tear</option>
                                <option value = "Superior Tear">Superior Tear</option>
                                <option value = "Lateral Tear">Lateral Tear</option>
                                <option value = "Medial Tear">Medial Tear</option>
                                <option value = "Central Tear">Central Tear</option>
                                <option value = "Macula Hole">Macula Hole</option>
                                <option value = "Chorioretinitis">Chorioretinitis</option>
                                <option value = "Inferior Chorioretinitis">Inferior Chorioretinitis</option>
                                <option value = "Superior Chorioretinitis">Superior Chorioretinitis</option>
                                <option value = "Lateral Chorioretinitis">Lateral Chorioretinitis</option>
                                <option value = "Medial Chorioretinitis">Medial Chorioretinitis</option>
                                <option value = "General Chorioretinitis">General Chorioretinitis</option>
                                <option value = "Vein Occlusion">Vein Occlusion</option>
                                <option value = "Superior Vein Occlusion">Superior Vein Occlusion</option>
                                <option value = "Inferior Vein Occlusion">Inferior Vein Occlusion</option>
                                <option value = "Medial Vein Occlusion">Medial Vein Occlusion</option>
                                <option value = "Lateral Vein Occlusion">Lateral Vein Occlusion</option>
                                <option value = "Central Vein Occlusion">Central Vein Occlusion</option>
                                <option value = "Artery Occlusion">Artery Occlusion</option>
                                <option value = "Superior Artery Occlusion">Superior Artery Occlusion</option>
                                <option value = "Inferior Artery Occlusion">Inferior Artery Occlusion</option>
                                <option value = "Medial Artery Occlusion">Medial Artery Occlusion</option>
                                <option value = "Lateral Artery Occlusion">Lateral Artery Occlusion</option>
                                <option value = "Central Artery Occlusion">Central Artery Occlusion</option>
                                <option value = "Nasal Shifting of Vessels">Nasal Shifting of Vessels</option>
                                <option value = "Beta Zone">Beta Zone</option>
                                <option value = "Disc Suspect">Disc Suspect</option>
                                <option value = "Normal">Normal</option>
                                <option value = "No View">No View</option>
                                <option value = "Poor View">Poor View</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                        	<input type="text" class="form-control" name="eoe_fundus_remarks" id="eoe_fundus_remarks">
						</div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_ocular_examamination_vc_d"><h6><strong>VC/D</strong></h6></label>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_vc_d_right" id="eoe_vc_d_right"> 
                                <option value="">Please Select</option>
                                <option value = "0">0</option>
                                <option value = "0.1">0.1</option>
                                <option value = "0.2">0.2</option>
                                <option value = "0.3">0.3</option>
                                <option value = "0.4">0.4</option>
                                <option value = "0.5">0.5</option>
                                <option value = "0.6">0.6</option>
                                <option value = "0.7">0.7</option>
                                <option value = "0.8">0.8</option>
                                <option value = "0.9">0.9</option>
                                <option value = "1">1</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_vc_d_left" id="eoe_vc_d_left"> 
                                <option value="">Please Select</option>
                                <option value = "0">0</option>
                                <option value = "0.1">0.1</option>
                                <option value = "0.2">0.2</option>
                                <option value = "0.3">0.3</option>
                                <option value = "0.4">0.4</option>
                                <option value = "0.5">0.5</option>
                                <option value = "0.6">0.6</option>
                                <option value = "0.7">0.7</option>
                                <option value = "0.8">0.8</option>
                                <option value = "0.9">0.9</option>
                                <option value = "1">1</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                        	<input type="text" class="form-control" name="eoe_vc_d_remarks" id="eoe_vc_d_remarks">
						</div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_ocular_examamination_iop"><h6><strong>IOP</strong></h6></label>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_iop_right" id="eoe_iop_right"> 
                                <option value="0">Please Select</option>
                                <option value = "1">1</option>
                                <option value = "2">2</option>
                                <option value = "3">3</option>
                                <option value = "4">4</option>
                                <option value = "5">5</option>
                                <option value = "6">6</option>
                                <option value = "7">7</option>
                                <option value = "8">8</option>
                                <option value = "9">9</option>
                                <option value = "10">10</option>
                                <option value = "11">11</option>
                                <option value = "12">12</option>
                                <option value = "13">13</option>
                                <option value = "14">14</option>
                                <option value = "15">15</option>
                                <option value = "16">16</option>
                                <option value = "17">17</option>
                                <option value = "18">18</option>
                                <option value = "19">19</option>
                                <option value = "20">20</option>
                                <option value = "21">21</option>
                                <option value = "22">22</option>
                                <option value = "23">23</option>
                                <option value = "24">24</option>
                                <option value = "25">25</option>
                                <option value = "26">26</option>
                                <option value = "27">27</option>
                                <option value = "28">28</option>
                                <option value = "29">29</option>
                                <option value = "30">30</option>
                                <option value = "31">31</option>
                                <option value = "32">32</option>
                                <option value = "33">33</option>
                                <option value = "34">34</option>
                                <option value = "35">35</option>
                                <option value = "36">36</option>
                                <option value = "37">37</option>
                                <option value = "38">38</option>
                                <option value = "39">39</option>
                                <option value = "40">40</option>
                                <option value = "41">41</option>
                                <option value = "42">42</option>
                                <option value = "43">43</option>
                                <option value = "44">44</option>
                                <option value = "45">45</option>
                                <option value = "46">46</option>
                                <option value = "47">47</option>
                                <option value = "48">48</option>
                                <option value = "49">49</option>
                                <option value = "50">50</option>
                                <option value = "51">51</option>
                                <option value = "52">52</option>
                                <option value = "53">53</option>
                                <option value = "54">54</option>
                                <option value = "55">55</option>
                                <option value = "56">56</option>
                                <option value = "57">57</option>
                                <option value = "58">58</option>
                                <option value = "59">59</option>
                                <option value = "60">60</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 form-group">
                            <select class="form-control" name="eoe_iop_left" id="eoe_iop_left"> 
                                <option value="0">Please Select</option>
                                <option value = "1">1</option>
                                <option value = "2">2</option>
                                <option value = "3">3</option>
                                <option value = "4">4</option>
                                <option value = "5">5</option>
                                <option value = "6">6</option>
                                <option value = "7">7</option>
                                <option value = "8">8</option>
                                <option value = "9">9</option>
                                <option value = "10">10</option>
                                <option value = "11">11</option>
                                <option value = "12">12</option>
                                <option value = "13">13</option>
                                <option value = "14">14</option>
                                <option value = "15">15</option>
                                <option value = "16">16</option>
                                <option value = "17">17</option>
                                <option value = "18">18</option>
                                <option value = "19">19</option>
                                <option value = "20">20</option>
                                <option value = "21">21</option>
                                <option value = "22">22</option>
                                <option value = "23">23</option>
                                <option value = "24">24</option>
                                <option value = "25">25</option>
                                <option value = "26">26</option>
                                <option value = "27">27</option>
                                <option value = "28">28</option>
                                <option value = "29">29</option>
                                <option value = "30">30</option>
                                <option value = "31">31</option>
                                <option value = "32">32</option>
                                <option value = "33">33</option>
                                <option value = "34">34</option>
                                <option value = "35">35</option>
                                <option value = "36">36</option>
                                <option value = "37">37</option>
                                <option value = "38">38</option>
                                <option value = "39">39</option>
                                <option value = "40">40</option>
                                <option value = "41">41</option>
                                <option value = "42">42</option>
                                <option value = "43">43</option>
                                <option value = "44">44</option>
                                <option value = "45">45</option>
                                <option value = "46">46</option>
                                <option value = "47">47</option>
                                <option value = "48">48</option>
                                <option value = "49">49</option>
                                <option value = "50">50</option>
                                <option value = "51">51</option>
                                <option value = "52">52</option>
                                <option value = "53">53</option>
                                <option value = "54">54</option>
                                <option value = "55">55</option>
                                <option value = "56">56</option>
                                <option value = "57">57</option>
                                <option value = "58">58</option>
                                <option value = "59">59</option>
                                <option value = "60">60</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-4 form-group">
                        	<input type="text" class="form-control" name="eoe_iop_remarks" id="eoe_iop_remarks">
						</div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-12 mb-12 form-group">
                            <label for="eoe_visual_field_result"><h6><strong>Visual Field Result</strong></h6></label>
                            <textarea type="textarea" rows="4"  class="form-control" name="eoe_visual_field_result" id="eoe_visual_field_result" value=""></textarea>
                        </div>
                    </div>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="eoe_save" name="eoe_save" class="btn btn-primary">Save</button>
			        <button type="button" id="eoe_update" name="eoe_update" class="btn btn-primary">Update</button>
			        <button type="button" id="eoe_cancel" name="eoe_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<div 
	class="modal fade hide bd-example-modal-xl" 
	id="add_eye_refraction_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="add_eye_refraction_modal" 
	aria-hidden="true"
	data-backdrop="static"
	data-keyboard="false">
		<div class="modal-dialog modal-xl" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title m-0 font-weight-bold text-primary" id="add_eye_refraction_modal_title">EYE REFRACTION</h5>
	    	</div>
			<form id="add_eye_refraction_form" action="#" method="POST">
			    <div class="modal-body">
                            <input type="hidden" class="form-control" name="eye_refraction_id" id="eye_refraction_id">
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <label for="eye_refraction_right"><h6><strong>RIGHT VISION</strong></h6></label>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <label for="eye_refraction_left"><h6><strong>LEFT VISION</strong></h6></label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_refraction_sph"><h6><strong>SPH</strong></h6></label>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_refraction_sph_right" id="eye_refraction_sph_right"> 
                                <option value="">Please Select</option>
                                <option value = "-30">-30</option>
                                <option value = "-29">-29</option>
                                <option value = "-28">-28</option>
                                <option value = "-27">-27</option>
                                <option value = "-26">-26</option>
                                <option value = "-25">-25</option>
                                <option value = "-24">-24</option>
                                <option value = "-23">-23</option>
                                <option value = "-22">-22</option>
                                <option value = "-21">-21</option>
                                <option value = "-20">-20</option>
                                <option value = "-19">-19</option>
                                <option value = "-18">-18</option>
                                <option value = "-17">-17</option>
                                <option value = "-16">-16</option>
                                <option value = "-15">-15</option>
                                <option value = "-14">-14</option>
                                <option value = "-13">-13</option>
                                <option value = "-12">-12</option>
                                <option value = "-11">-11</option>
                                <option value = "-10">-10</option>
                                <option value = "-9">-9</option>
                                <option value = "-8">-8</option>
                                <option value = "-7">-7</option>
                                <option value = "-6">-6</option>
                                <option value = "-5">-5</option>
                                <option value = "-4">-4</option>
                                <option value = "-3">-3</option>
                                <option value = "-2">-2</option>
                                <option value = "-1">-1</option>
                                <option value = "0">0</option>
                                <option value = "1">1</option>
                                <option value = "2">2</option>
                                <option value = "3">3</option>
                                <option value = "4">4</option>
                                <option value = "5">5</option>
                                <option value = "6">6</option>
                                <option value = "7">7</option>
                                <option value = "8">8</option>
                                <option value = "9">9</option>
                                <option value = "10">10</option>
                                <option value = "11">11</option>
                                <option value = "12">12</option>
                                <option value = "13">13</option>
                                <option value = "14">14</option>
                                <option value = "15">15</option>
                                <option value = "16">16</option>
                                <option value = "17">17</option>
                                <option value = "18">18</option>
                                <option value = "19">19</option>
                                <option value = "20">20</option>
                                <option value = "21">21</option>
                                <option value = "22">22</option>
                                <option value = "23">23</option>
                                <option value = "24">24</option>
                                <option value = "25">25</option>
                                <option value = "26">26</option>
                                <option value = "27">27</option>
                                <option value = "28">28</option>
                                <option value = "29">29</option>
                                <option value = "30">30</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_refraction_sph_left" id="eye_refraction_sph_left"> 
                                <option value="0">Please Select</option>
                                <option value = "-30">-30</option>
                                <option value = "-29">-29</option>
                                <option value = "-28">-28</option>
                                <option value = "-27">-27</option>
                                <option value = "-26">-26</option>
                                <option value = "-25">-25</option>
                                <option value = "-24">-24</option>
                                <option value = "-23">-23</option>
                                <option value = "-22">-22</option>
                                <option value = "-21">-21</option>
                                <option value = "-20">-20</option>
                                <option value = "-19">-19</option>
                                <option value = "-18">-18</option>
                                <option value = "-17">-17</option>
                                <option value = "-16">-16</option>
                                <option value = "-15">-15</option>
                                <option value = "-14">-14</option>
                                <option value = "-13">-13</option>
                                <option value = "-12">-12</option>
                                <option value = "-11">-11</option>
                                <option value = "-10">-10</option>
                                <option value = "-9">-9</option>
                                <option value = "-8">-8</option>
                                <option value = "-7">-7</option>
                                <option value = "-6">-6</option>
                                <option value = "-5">-5</option>
                                <option value = "-4">-4</option>
                                <option value = "-3">-3</option>
                                <option value = "-2">-2</option>
                                <option value = "-1">-1</option>
                                <option value = "0">0</option>
                                <option value = "1">1</option>
                                <option value = "2">2</option>
                                <option value = "3">3</option>
                                <option value = "4">4</option>
                                <option value = "5">5</option>
                                <option value = "6">6</option>
                                <option value = "7">7</option>
                                <option value = "8">8</option>
                                <option value = "9">9</option>
                                <option value = "10">10</option>
                                <option value = "11">11</option>
                                <option value = "12">12</option>
                                <option value = "13">13</option>
                                <option value = "14">14</option>
                                <option value = "15">15</option>
                                <option value = "16">16</option>
                                <option value = "17">17</option>
                                <option value = "18">18</option>
                                <option value = "19">19</option>
                                <option value = "20">20</option>
                                <option value = "21">21</option>
                                <option value = "22">22</option>
                                <option value = "23">23</option>
                                <option value = "24">24</option>
                                <option value = "25">25</option>
                                <option value = "26">26</option>
                                <option value = "27">27</option>
                                <option value = "28">28</option>
                                <option value = "29">29</option>
                                <option value = "30">30</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_refraction_cyl"><h6><strong>CYL</strong></h6></label>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_refraction_cyl_right" id="eye_refraction_cyl_right"> 
                                <option value="0">Please Select</option>
                                <option value = "-30">-30</option>
                                <option value = "-29">-29</option>
                                <option value = "-28">-28</option>
                                <option value = "-27">-27</option>
                                <option value = "-26">-26</option>
                                <option value = "-25">-25</option>
                                <option value = "-24">-24</option>
                                <option value = "-23">-23</option>
                                <option value = "-22">-22</option>
                                <option value = "-21">-21</option>
                                <option value = "-20">-20</option>
                                <option value = "-19">-19</option>
                                <option value = "-18">-18</option>
                                <option value = "-17">-17</option>
                                <option value = "-16">-16</option>
                                <option value = "-15">-15</option>
                                <option value = "-14">-14</option>
                                <option value = "-13">-13</option>
                                <option value = "-12">-12</option>
                                <option value = "-11">-11</option>
                                <option value = "-10">-10</option>
                                <option value = "-9">-9</option>
                                <option value = "-8">-8</option>
                                <option value = "-7">-7</option>
                                <option value = "-6">-6</option>
                                <option value = "-5">-5</option>
                                <option value = "-4">-4</option>
                                <option value = "-3">-3</option>
                                <option value = "-2">-2</option>
                                <option value = "-1">-1</option>
                                <option value = "0">0</option>
                                <option value = "1">1</option>
                                <option value = "2">2</option>
                                <option value = "3">3</option>
                                <option value = "4">4</option>
                                <option value = "5">5</option>
                                <option value = "6">6</option>
                                <option value = "7">7</option>
                                <option value = "8">8</option>
                                <option value = "9">9</option>
                                <option value = "10">10</option>
                                <option value = "11">11</option>
                                <option value = "12">12</option>
                                <option value = "13">13</option>
                                <option value = "14">14</option>
                                <option value = "15">15</option>
                                <option value = "16">16</option>
                                <option value = "17">17</option>
                                <option value = "18">18</option>
                                <option value = "19">19</option>
                                <option value = "20">20</option>
                                <option value = "21">21</option>
                                <option value = "22">22</option>
                                <option value = "23">23</option>
                                <option value = "24">24</option>
                                <option value = "25">25</option>
                                <option value = "26">26</option>
                                <option value = "27">27</option>
                                <option value = "28">28</option>
                                <option value = "29">29</option>
                                <option value = "30">30</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_refraction_cyl_left" id="eye_refraction_cyl_left"> 
                                <option value="0">Please Select</option>
                                <option value = "-30">-30</option>
                                <option value = "-29">-29</option>
                                <option value = "-28">-28</option>
                                <option value = "-27">-27</option>
                                <option value = "-26">-26</option>
                                <option value = "-25">-25</option>
                                <option value = "-24">-24</option>
                                <option value = "-23">-23</option>
                                <option value = "-22">-22</option>
                                <option value = "-21">-21</option>
                                <option value = "-20">-20</option>
                                <option value = "-19">-19</option>
                                <option value = "-18">-18</option>
                                <option value = "-17">-17</option>
                                <option value = "-16">-16</option>
                                <option value = "-15">-15</option>
                                <option value = "-14">-14</option>
                                <option value = "-13">-13</option>
                                <option value = "-12">-12</option>
                                <option value = "-11">-11</option>
                                <option value = "-10">-10</option>
                                <option value = "-9">-9</option>
                                <option value = "-8">-8</option>
                                <option value = "-7">-7</option>
                                <option value = "-6">-6</option>
                                <option value = "-5">-5</option>
                                <option value = "-4">-4</option>
                                <option value = "-3">-3</option>
                                <option value = "-2">-2</option>
                                <option value = "-1">-1</option>
                                <option value = "0">0</option>
                                <option value = "1">1</option>
                                <option value = "2">2</option>
                                <option value = "3">3</option>
                                <option value = "4">4</option>
                                <option value = "5">5</option>
                                <option value = "6">6</option>
                                <option value = "7">7</option>
                                <option value = "8">8</option>
                                <option value = "9">9</option>
                                <option value = "10">10</option>
                                <option value = "11">11</option>
                                <option value = "12">12</option>
                                <option value = "13">13</option>
                                <option value = "14">14</option>
                                <option value = "15">15</option>
                                <option value = "16">16</option>
                                <option value = "17">17</option>
                                <option value = "18">18</option>
                                <option value = "19">19</option>
                                <option value = "20">20</option>
                                <option value = "21">21</option>
                                <option value = "22">22</option>
                                <option value = "23">23</option>
                                <option value = "24">24</option>
                                <option value = "25">25</option>
                                <option value = "26">26</option>
                                <option value = "27">27</option>
                                <option value = "28">28</option>
                                <option value = "29">29</option>
                                <option value = "30">30</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_refraction_axis"><h6><strong>AXIS</strong></h6></label>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_refraction_axis_right" id="eye_refraction_axis_right"> 
                                <option value="0">Please Select</option>
                                <option value = "-30">-30</option>
                                <option value = "-29">-29</option>
                                <option value = "-28">-28</option>
                                <option value = "-27">-27</option>
                                <option value = "-26">-26</option>
                                <option value = "-25">-25</option>
                                <option value = "-24">-24</option>
                                <option value = "-23">-23</option>
                                <option value = "-22">-22</option>
                                <option value = "-21">-21</option>
                                <option value = "-20">-20</option>
                                <option value = "-19">-19</option>
                                <option value = "-18">-18</option>
                                <option value = "-17">-17</option>
                                <option value = "-16">-16</option>
                                <option value = "-15">-15</option>
                                <option value = "-14">-14</option>
                                <option value = "-13">-13</option>
                                <option value = "-12">-12</option>
                                <option value = "-11">-11</option>
                                <option value = "-10">-10</option>
                                <option value = "-9">-9</option>
                                <option value = "-8">-8</option>
                                <option value = "-7">-7</option>
                                <option value = "-6">-6</option>
                                <option value = "-5">-5</option>
                                <option value = "-4">-4</option>
                                <option value = "-3">-3</option>
                                <option value = "-2">-2</option>
                                <option value = "-1">-1</option>
                                <option value = "0">0</option>
                                <option value = "1">1</option>
                                <option value = "2">2</option>
                                <option value = "3">3</option>
                                <option value = "4">4</option>
                                <option value = "5">5</option>
                                <option value = "6">6</option>
                                <option value = "7">7</option>
                                <option value = "8">8</option>
                                <option value = "9">9</option>
                                <option value = "10">10</option>
                                <option value = "11">11</option>
                                <option value = "12">12</option>
                                <option value = "13">13</option>
                                <option value = "14">14</option>
                                <option value = "15">15</option>
                                <option value = "16">16</option>
                                <option value = "17">17</option>
                                <option value = "18">18</option>
                                <option value = "19">19</option>
                                <option value = "20">20</option>
                                <option value = "21">21</option>
                                <option value = "22">22</option>
                                <option value = "23">23</option>
                                <option value = "24">24</option>
                                <option value = "25">25</option>
                                <option value = "26">26</option>
                                <option value = "27">27</option>
                                <option value = "28">28</option>
                                <option value = "29">29</option>
                                <option value = "30">30</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_refraction_axis_left" id="eye_refraction_axis_left"> 
                                <option value="0">Please Select</option>
                                <option value = "-30">-30</option>
                                <option value = "-29">-29</option>
                                <option value = "-28">-28</option>
                                <option value = "-27">-27</option>
                                <option value = "-26">-26</option>
                                <option value = "-25">-25</option>
                                <option value = "-24">-24</option>
                                <option value = "-23">-23</option>
                                <option value = "-22">-22</option>
                                <option value = "-21">-21</option>
                                <option value = "-20">-20</option>
                                <option value = "-19">-19</option>
                                <option value = "-18">-18</option>
                                <option value = "-17">-17</option>
                                <option value = "-16">-16</option>
                                <option value = "-15">-15</option>
                                <option value = "-14">-14</option>
                                <option value = "-13">-13</option>
                                <option value = "-12">-12</option>
                                <option value = "-11">-11</option>
                                <option value = "-10">-10</option>
                                <option value = "-9">-9</option>
                                <option value = "-8">-8</option>
                                <option value = "-7">-7</option>
                                <option value = "-6">-6</option>
                                <option value = "-5">-5</option>
                                <option value = "-4">-4</option>
                                <option value = "-3">-3</option>
                                <option value = "-2">-2</option>
                                <option value = "-1">-1</option>
                                <option value = "0">0</option>
                                <option value = "1">1</option>
                                <option value = "2">2</option>
                                <option value = "3">3</option>
                                <option value = "4">4</option>
                                <option value = "5">5</option>
                                <option value = "6">6</option>
                                <option value = "7">7</option>
                                <option value = "8">8</option>
                                <option value = "9">9</option>
                                <option value = "10">10</option>
                                <option value = "11">11</option>
                                <option value = "12">12</option>
                                <option value = "13">13</option>
                                <option value = "14">14</option>
                                <option value = "15">15</option>
                                <option value = "16">16</option>
                                <option value = "17">17</option>
                                <option value = "18">18</option>
                                <option value = "19">19</option>
                                <option value = "20">20</option>
                                <option value = "21">21</option>
                                <option value = "22">22</option>
                                <option value = "23">23</option>
                                <option value = "24">24</option>
                                <option value = "25">25</option>
                                <option value = "26">26</option>
                                <option value = "27">27</option>
                                <option value = "28">28</option>
                                <option value = "29">29</option>
                                <option value = "30">30</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_refraction_add"><h6><strong>ADD</strong></h6></label>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_refraction_add_right" id="eye_refraction_add_right"> 
                                <option value="0">Please Select</option>
                                <option value = "-30">-30</option>
                                <option value = "-29">-29</option>
                                <option value = "-28">-28</option>
                                <option value = "-27">-27</option>
                                <option value = "-26">-26</option>
                                <option value = "-25">-25</option>
                                <option value = "-24">-24</option>
                                <option value = "-23">-23</option>
                                <option value = "-22">-22</option>
                                <option value = "-21">-21</option>
                                <option value = "-20">-20</option>
                                <option value = "-19">-19</option>
                                <option value = "-18">-18</option>
                                <option value = "-17">-17</option>
                                <option value = "-16">-16</option>
                                <option value = "-15">-15</option>
                                <option value = "-14">-14</option>
                                <option value = "-13">-13</option>
                                <option value = "-12">-12</option>
                                <option value = "-11">-11</option>
                                <option value = "-10">-10</option>
                                <option value = "-9">-9</option>
                                <option value = "-8">-8</option>
                                <option value = "-7">-7</option>
                                <option value = "-6">-6</option>
                                <option value = "-5">-5</option>
                                <option value = "-4">-4</option>
                                <option value = "-3">-3</option>
                                <option value = "-2">-2</option>
                                <option value = "-1">-1</option>
                                <option value = "0">0</option>
                                <option value = "1">1</option>
                                <option value = "2">2</option>
                                <option value = "3">3</option>
                                <option value = "4">4</option>
                                <option value = "5">5</option>
                                <option value = "6">6</option>
                                <option value = "7">7</option>
                                <option value = "8">8</option>
                                <option value = "9">9</option>
                                <option value = "10">10</option>
                                <option value = "11">11</option>
                                <option value = "12">12</option>
                                <option value = "13">13</option>
                                <option value = "14">14</option>
                                <option value = "15">15</option>
                                <option value = "16">16</option>
                                <option value = "17">17</option>
                                <option value = "18">18</option>
                                <option value = "19">19</option>
                                <option value = "20">20</option>
                                <option value = "21">21</option>
                                <option value = "22">22</option>
                                <option value = "23">23</option>
                                <option value = "24">24</option>
                                <option value = "25">25</option>
                                <option value = "26">26</option>
                                <option value = "27">27</option>
                                <option value = "28">28</option>
                                <option value = "29">29</option>
                                <option value = "30">30</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_refraction_add_left" id="eye_refraction_add_left"> 
                                <option value="0">Please Select</option>
                                <option value = "-30">-30</option>
                                <option value = "-29">-29</option>
                                <option value = "-28">-28</option>
                                <option value = "-27">-27</option>
                                <option value = "-26">-26</option>
                                <option value = "-25">-25</option>
                                <option value = "-24">-24</option>
                                <option value = "-23">-23</option>
                                <option value = "-22">-22</option>
                                <option value = "-21">-21</option>
                                <option value = "-20">-20</option>
                                <option value = "-19">-19</option>
                                <option value = "-18">-18</option>
                                <option value = "-17">-17</option>
                                <option value = "-16">-16</option>
                                <option value = "-15">-15</option>
                                <option value = "-14">-14</option>
                                <option value = "-13">-13</option>
                                <option value = "-12">-12</option>
                                <option value = "-11">-11</option>
                                <option value = "-10">-10</option>
                                <option value = "-9">-9</option>
                                <option value = "-8">-8</option>
                                <option value = "-7">-7</option>
                                <option value = "-6">-6</option>
                                <option value = "-5">-5</option>
                                <option value = "-4">-4</option>
                                <option value = "-3">-3</option>
                                <option value = "-2">-2</option>
                                <option value = "-1">-1</option>
                                <option value = "0">0</option>
                                <option value = "1">1</option>
                                <option value = "2">2</option>
                                <option value = "3">3</option>
                                <option value = "4">4</option>
                                <option value = "5">5</option>
                                <option value = "6">6</option>
                                <option value = "7">7</option>
                                <option value = "8">8</option>
                                <option value = "9">9</option>
                                <option value = "10">10</option>
                                <option value = "11">11</option>
                                <option value = "12">12</option>
                                <option value = "13">13</option>
                                <option value = "14">14</option>
                                <option value = "15">15</option>
                                <option value = "16">16</option>
                                <option value = "17">17</option>
                                <option value = "18">18</option>
                                <option value = "19">19</option>
                                <option value = "20">20</option>
                                <option value = "21">21</option>
                                <option value = "22">22</option>
                                <option value = "23">23</option>
                                <option value = "24">24</option>
                                <option value = "25">25</option>
                                <option value = "26">26</option>
                                <option value = "27">27</option>
                                <option value = "28">28</option>
                                <option value = "29">29</option>
                                <option value = "30">30</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_refraction_hgt"><h6><strong>HGT</strong></h6></label>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_refraction_hgt_right" id="eye_refraction_hgt_right"> 
                                <option value="0">Please Select</option>
                                <option value = "-30">-30</option>
                                <option value = "-29">-29</option>
                                <option value = "-28">-28</option>
                                <option value = "-27">-27</option>
                                <option value = "-26">-26</option>
                                <option value = "-25">-25</option>
                                <option value = "-24">-24</option>
                                <option value = "-23">-23</option>
                                <option value = "-22">-22</option>
                                <option value = "-21">-21</option>
                                <option value = "-20">-20</option>
                                <option value = "-19">-19</option>
                                <option value = "-18">-18</option>
                                <option value = "-17">-17</option>
                                <option value = "-16">-16</option>
                                <option value = "-15">-15</option>
                                <option value = "-14">-14</option>
                                <option value = "-13">-13</option>
                                <option value = "-12">-12</option>
                                <option value = "-11">-11</option>
                                <option value = "-10">-10</option>
                                <option value = "-9">-9</option>
                                <option value = "-8">-8</option>
                                <option value = "-7">-7</option>
                                <option value = "-6">-6</option>
                                <option value = "-5">-5</option>
                                <option value = "-4">-4</option>
                                <option value = "-3">-3</option>
                                <option value = "-2">-2</option>
                                <option value = "-1">-1</option>
                                <option value = "0">0</option>
                                <option value = "1">1</option>
                                <option value = "2">2</option>
                                <option value = "3">3</option>
                                <option value = "4">4</option>
                                <option value = "5">5</option>
                                <option value = "6">6</option>
                                <option value = "7">7</option>
                                <option value = "8">8</option>
                                <option value = "9">9</option>
                                <option value = "10">10</option>
                                <option value = "11">11</option>
                                <option value = "12">12</option>
                                <option value = "13">13</option>
                                <option value = "14">14</option>
                                <option value = "15">15</option>
                                <option value = "16">16</option>
                                <option value = "17">17</option>
                                <option value = "18">18</option>
                                <option value = "19">19</option>
                                <option value = "20">20</option>
                                <option value = "21">21</option>
                                <option value = "22">22</option>
                                <option value = "23">23</option>
                                <option value = "24">24</option>
                                <option value = "25">25</option>
                                <option value = "26">26</option>
                                <option value = "27">27</option>
                                <option value = "28">28</option>
                                <option value = "29">29</option>
                                <option value = "30">30</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_refraction_hgt_left" id="eye_refraction_hgt_left"> 
                                <option value="0">Please Select</option>
                                <option value = "-30">-30</option>
                                <option value = "-29">-29</option>
                                <option value = "-28">-28</option>
                                <option value = "-27">-27</option>
                                <option value = "-26">-26</option>
                                <option value = "-25">-25</option>
                                <option value = "-24">-24</option>
                                <option value = "-23">-23</option>
                                <option value = "-22">-22</option>
                                <option value = "-21">-21</option>
                                <option value = "-20">-20</option>
                                <option value = "-19">-19</option>
                                <option value = "-18">-18</option>
                                <option value = "-17">-17</option>
                                <option value = "-16">-16</option>
                                <option value = "-15">-15</option>
                                <option value = "-14">-14</option>
                                <option value = "-13">-13</option>
                                <option value = "-12">-12</option>
                                <option value = "-11">-11</option>
                                <option value = "-10">-10</option>
                                <option value = "-9">-9</option>
                                <option value = "-8">-8</option>
                                <option value = "-7">-7</option>
                                <option value = "-6">-6</option>
                                <option value = "-5">-5</option>
                                <option value = "-4">-4</option>
                                <option value = "-3">-3</option>
                                <option value = "-2">-2</option>
                                <option value = "-1">-1</option>
                                <option value = "0">0</option>
                                <option value = "1">1</option>
                                <option value = "2">2</option>
                                <option value = "3">3</option>
                                <option value = "4">4</option>
                                <option value = "5">5</option>
                                <option value = "6">6</option>
                                <option value = "7">7</option>
                                <option value = "8">8</option>
                                <option value = "9">9</option>
                                <option value = "10">10</option>
                                <option value = "11">11</option>
                                <option value = "12">12</option>
                                <option value = "13">13</option>
                                <option value = "14">14</option>
                                <option value = "15">15</option>
                                <option value = "16">16</option>
                                <option value = "17">17</option>
                                <option value = "18">18</option>
                                <option value = "19">19</option>
                                <option value = "20">20</option>
                                <option value = "21">21</option>
                                <option value = "22">22</option>
                                <option value = "23">23</option>
                                <option value = "24">24</option>
                                <option value = "25">25</option>
                                <option value = "26">26</option>
                                <option value = "27">27</option>
                                <option value = "28">28</option>
                                <option value = "29">29</option>
                                <option value = "30">30</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-2 mb-2 form-group">
                            <label for="eye_refraction_pd"><h6><strong>PD</strong></h6></label>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_refraction_pd_right" id="eye_refraction_pd_right"> 
                                <option value="0">Please Select</option>
                                <option value = "-30">-30</option>
                                <option value = "-29">-29</option>
                                <option value = "-28">-28</option>
                                <option value = "-27">-27</option>
                                <option value = "-26">-26</option>
                                <option value = "-25">-25</option>
                                <option value = "-24">-24</option>
                                <option value = "-23">-23</option>
                                <option value = "-22">-22</option>
                                <option value = "-21">-21</option>
                                <option value = "-20">-20</option>
                                <option value = "-19">-19</option>
                                <option value = "-18">-18</option>
                                <option value = "-17">-17</option>
                                <option value = "-16">-16</option>
                                <option value = "-15">-15</option>
                                <option value = "-14">-14</option>
                                <option value = "-13">-13</option>
                                <option value = "-12">-12</option>
                                <option value = "-11">-11</option>
                                <option value = "-10">-10</option>
                                <option value = "-9">-9</option>
                                <option value = "-8">-8</option>
                                <option value = "-7">-7</option>
                                <option value = "-6">-6</option>
                                <option value = "-5">-5</option>
                                <option value = "-4">-4</option>
                                <option value = "-3">-3</option>
                                <option value = "-2">-2</option>
                                <option value = "-1">-1</option>
                                <option value = "0">0</option>
                                <option value = "1">1</option>
                                <option value = "2">2</option>
                                <option value = "3">3</option>
                                <option value = "4">4</option>
                                <option value = "5">5</option>
                                <option value = "6">6</option>
                                <option value = "7">7</option>
                                <option value = "8">8</option>
                                <option value = "9">9</option>
                                <option value = "10">10</option>
                                <option value = "11">11</option>
                                <option value = "12">12</option>
                                <option value = "13">13</option>
                                <option value = "14">14</option>
                                <option value = "15">15</option>
                                <option value = "16">16</option>
                                <option value = "17">17</option>
                                <option value = "18">18</option>
                                <option value = "19">19</option>
                                <option value = "20">20</option>
                                <option value = "21">21</option>
                                <option value = "22">22</option>
                                <option value = "23">23</option>
                                <option value = "24">24</option>
                                <option value = "25">25</option>
                                <option value = "26">26</option>
                                <option value = "27">27</option>
                                <option value = "28">28</option>
                                <option value = "29">29</option>
                                <option value = "30">30</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-5 form-group">
                            <select class="form-control" name="eye_refraction_pd_left" id="eye_refraction_pd_left"> 
                                <option value="0">Please Select</option>
                                <option value = "-30">-30</option>
                                <option value = "-29">-29</option>
                                <option value = "-28">-28</option>
                                <option value = "-27">-27</option>
                                <option value = "-26">-26</option>
                                <option value = "-25">-25</option>
                                <option value = "-24">-24</option>
                                <option value = "-23">-23</option>
                                <option value = "-22">-22</option>
                                <option value = "-21">-21</option>
                                <option value = "-20">-20</option>
                                <option value = "-19">-19</option>
                                <option value = "-18">-18</option>
                                <option value = "-17">-17</option>
                                <option value = "-16">-16</option>
                                <option value = "-15">-15</option>
                                <option value = "-14">-14</option>
                                <option value = "-13">-13</option>
                                <option value = "-12">-12</option>
                                <option value = "-11">-11</option>
                                <option value = "-10">-10</option>
                                <option value = "-9">-9</option>
                                <option value = "-8">-8</option>
                                <option value = "-7">-7</option>
                                <option value = "-6">-6</option>
                                <option value = "-5">-5</option>
                                <option value = "-4">-4</option>
                                <option value = "-3">-3</option>
                                <option value = "-2">-2</option>
                                <option value = "-1">-1</option>
                                <option value = "0">0</option>
                                <option value = "1">1</option>
                                <option value = "2">2</option>
                                <option value = "3">3</option>
                                <option value = "4">4</option>
                                <option value = "5">5</option>
                                <option value = "6">6</option>
                                <option value = "7">7</option>
                                <option value = "8">8</option>
                                <option value = "9">9</option>
                                <option value = "10">10</option>
                                <option value = "11">11</option>
                                <option value = "12">12</option>
                                <option value = "13">13</option>
                                <option value = "14">14</option>
                                <option value = "15">15</option>
                                <option value = "16">16</option>
                                <option value = "17">17</option>
                                <option value = "18">18</option>
                                <option value = "19">19</option>
                                <option value = "20">20</option>
                                <option value = "21">21</option>
                                <option value = "22">22</option>
                                <option value = "23">23</option>
                                <option value = "24">24</option>
                                <option value = "25">25</option>
                                <option value = "26">26</option>
                                <option value = "27">27</option>
                                <option value = "28">28</option>
                                <option value = "29">29</option>
                                <option value = "30">30</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-12 form-group">
                            <label for="eye_refraction_remarks"><h6><strong>Remarks</strong></h6></label>
                            <textarea type="textarea" rows="4"  class="form-control" name="eye_refraction_remarks" id="eye_refraction_remarks" value=""></textarea>
                        </div>
                    </div>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="eye_refraction_save" name="eye_refraction_save" class="btn btn-primary">Save</button>
			        <button type="button" id="eye_refraction_update" name="eye_refraction_update" class="btn btn-primary">Update</button>
			        <button type="button" id="eye_refraction_cancel" name="eye_refraction_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<div 
	class="modal fade hide bd-example-modal-xl" 
	id="add_eye_lens_details_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="add_eye_lens_details_modal" 
	aria-hidden="true"
	data-backdrop="static"
	data-keyboard="false">
		<div class="modal-dialog modal-xl" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title m-0 font-weight-bold text-primary" id="add_eye_lens_details_modal_title">LENS DETAILS</h5>
	    	</div>
			<form id="add_eye_lens_details_modal_form" action="#" method="POST">
			    <div class="modal-body">
                            <input type="hidden" class="form-control" name="eye_lens_details_id" id="eye_lens_details_id">
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="eld_lens_type"><h6><strong>LENS TYPE</strong></h6></label>
                        </div>
                        <div class="col-md-8 mb-8 form-group">
                            <select class="form-control" name="eld_lens_type" id="eld_lens_type"> 
                                <option value="0">Please Select</option>
                                <option value = "SINGLE VISION">SINGLE VISION</option>
                                <option value = "BIFOCAL">BIFOCAL</option>
                                <option value = "PROGRESSIVE">PROGRESSIVE</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="eld_lens_material"><h6><strong>LENS MATERIAL</strong></h6></label>
                        </div>
                        <div class="col-md-8 mb-8 form-group">
                            <select class="form-control" name="eld_lens_material" id="eld_lens_material"> 
                                <option value="0">Please Select</option>
                                <option value = "PLASTIC">PLASTIC</option>
                                <option value = "GLASS">GLASS</option>
                                <option value = "POLYCARBONATE">POLYCARBONATE</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="eld_lens_index"><h6><strong>LENS INDEX</strong></h6></label>
                        </div>
                        <div class="col-md-8 mb-8 form-group">
                            <select class="form-control" name="eld_lens_index" id="eld_lens_index"> 
                                <option value="0">Please Select</option>
                                <option value = "1.49">1.49</option>
                                <option value = "1.56">1.56</option>
                                <option value = "1.67">1.67</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="eld_lens_frame_type"><h6><strong>LENS FRAME TYPE</strong></h6></label>
                        </div>
                        <div class="col-md-8 mb-8 form-group">
                            <select class="form-control" name="eld_lens_frame_type" id="eld_lens_frame_type"> 
                                <option value="0">Please Select</option>
                                <option value = "INTERNAL">INTERNAL</option>
                                <option value = "EXTERNAL">EXTERNAL</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-4 form-group">
                            <label for="eld_lens_others"><h6><strong>LENS OTHERS</strong></h6></label>
                        </div>
                        <div class="col-md-8 mb-8 form-group">
                            <div class="form-check">
							  <input class="form-check-input" type="checkbox" value="PHOTOCHROMIC" id="PHOTOCHROMIC" name="lens_others[]">
							  <label class="form-check-label" for="PHOTOCHROMIC">
							    PHOTOCHROMIC
							  </label>
							</div>
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" value="ANTIREFLECTIVE" id="ANTIREFLECTIVE" name="lens_others[]">
							  <label class="form-check-label" for="ANTIREFLECTIVE">
							    ANTIREFLECTIVE
							  </label>
							</div>
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" value="GRADIENT TINT" id="GRADIENT TINT" name="lens_others[]">
							  <label class="form-check-label" for="GRADIENT TINT">
							    GRADIENT TINT
							  </label>
							</div>
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" value="SOLID TINT" id="SOLID TINT" name="lens_others[]">
							  <label class="form-check-label" for="SOLID TINT">
							    SOLID TINT
							  </label>
							</div>
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" value="TRANSITIONS" id="TRANSITIONS" name="lens_others[]">
							  <label class="form-check-label" for="TRANSITIONS">
							    TRANSITIONS
							  </label>
							</div>
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" value="UTMT" id="UTMT" name="lens_others[]">
							  <label class="form-check-label" for="UTMT">
							    UTMT
							  </label>
							</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-12 form-group">
                            <label for="eld_remarks"><h6><strong>Remarks</strong></h6></label>
                            <textarea type="textarea" rows="4"  class="form-control" name="eld_remarks" id="eld_remarks" value=""></textarea>
                        </div>
                    </div>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="eld_save" name="eld_save" class="btn btn-primary">Save</button>
			        <button type="button" id="eld_update" name="eld_update" class="btn btn-primary">Update</button>
			        <button type="button" id="ele_cancel" name="ele_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>