<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
    
    $query_wardlist = "SELECT * FROM wardlist WHERE attend_id='$attend_id' ORDER BY date_in DESC";
    $query_run_wardlist = mysqli_query($con, $query_wardlist);
?>
<div class="form-row">
	<div class="col-md-4 mb-4">
		<div id="admit_button">
			<?php
				if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Patient_Admission'] == 'Yes')) 
				{
					if (mysqli_num_rows($query_run_wardlist) > 0)
		            {
		            	echo '<button type="button" id="wardlist_admit_btn" class="btn btn-primary" 
						hidden>Admit</button>';
		            }
		            else
		            {
		            	echo '<button type="button" id="wardlist_admit_btn" class="btn btn-primary"
						>Admit</button>';
		            };
		        };
	        ?>
			
		</div>
	</div>
	<div class="col-md-4 mb-4">
	</div>
	<div class="col-md-4 mb-4">
		<div id="refer_button">
			<?php
				if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Patient_Referal'] == 'Yes')) 
				{
					$query_outcome = "SELECT * FROM attendance WHERE attend_id='$attend_id'";
	    			$query_run_outcome = mysqli_query($con, $query_outcome);
	    			$row_outcome=mysqli_fetch_assoc($query_run_outcome);
	    			$outcome=$row_outcome['outcome'];
		            if ($outcome =='referred_out')
		            {
		            	echo '<div class="form-row">
								<div class="col-md-6 mb-6">
									<button type="button" id="wardlist_refer_edit_btn" class="btn btn-primary d-flex float-right">Edit Refer</button>
								</div>
								<div class="col-md-6 mb-6">
									<button type="button" id="wardlist_refer_print_btn" class="btn btn-primary d-flex float-right">Print Refer</button>
								</div>
							</div>';
		            }
		            else
		            {
		            	echo '<div class="form-row">
		            			<div class="col-md-6 mb-6">
								</div>
								<div class="col-md-6 mb-6 d-flex">
									<button type="button" id="wardlist_refer_btn" class="btn btn-primary d-flex float-right">Refer</button>
								</div>
							</div>';
		            };
		        };
	        ?>
		</div>
	</div>
</div>

<div class="table-responsive" id="attend_wardlist_table">
    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Ward</th>
                <th>Bed</th>
                <th>Date In</th>
                <th>Type of Admission</th>
                <th>Admitting Officer</th>
                <th>Date Out</th>
                <th>Type of Discharge</th>
                <th>Discharging Officer</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">
        <?php
        	$query_attend = "SELECT * FROM attendance WHERE attend_id='$attend_id' AND outcome != 'on_admission'";
    		$query_run_attend = mysqli_query($con, $query_attend);
    		$active_attend_rows = mysqli_num_rows($query_run_attend);

            if (mysqli_num_rows($query_run_wardlist) > 0)
            {
                while($row=mysqli_fetch_assoc($query_run_wardlist))
                {
                	$ward_id = $row['ward_id'];
                	$bed_id = $row['bed_id'];
                	$query = "SELECT * FROM ward WHERE ward_id='$ward_id'";
					$query_run_ward = mysqli_query($con, $query);
					$row_ward=mysqli_fetch_assoc($query_run_ward);

					$query = "SELECT * FROM bed WHERE ward_id='$ward_id' AND bed_id='$bed_id'";
					$query_run_bed = mysqli_query($con, $query);
					$row_bed=mysqli_fetch_assoc($query_run_bed);
        ?>	
            <tr>
                
                <td>
                	<?php
						if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Patient_Admission'] == 'Yes')) 
						{
							echo'<a href="#" id="btn_edit_wardlist" data-id1="'.$row['wardlist_id'].'">'.$row_ward['ward'].'</a>';
						}
						else
						{
							echo $row_ward['ward'];
						};
					?>
                </td>
                <td><?php echo $row_bed['bed'];?></td>
                <td><?php echo $row['date_in'];?></td>
                <td><?php echo $row['type_of_adimission'];?></td>
                <td><?php echo $row['admitting_doctor'];?></td>
                <td><?php echo $row['date_out'];?></td>
                <td><?php echo $row['type_of_discharge'];?></td>
                <td><?php echo $row['discharging_doctor'];?></td>
                <td>
        <?php
        	if($active_attend_rows <= 0)
			{
                	if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Patient_Transfer'] == 'Yes')) 
					{
						echo'<a href="#" id="btn_transfer_wardlist" data-id2="'.$row['wardlist_id'].'">Transfer</a> | ';
					};

	                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Patient_Discharge'] == 'Yes')) 
					{
						echo'<a href="#" id="btn_discharge_wardlist" data-id2="'.$row['wardlist_id'].'">Discharge</a> | ';
					};
			};
	                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Patient_Admission'] == 'Yes')) 
					{
						echo'<a href="#" id="btn_delete_wardlist" data-id2="'.$row['wardlist_id'].'">Delete</a>';
					};
        ?>
                </td>
            </tr>
        <?php
                };
            };
        ?>
        </tbody>
    </table>
</div>

<div class="modal fade bd-example-modal-xl" 
	id="wardlist_admit_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="wardlist_admit_modal" 
	aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title m-0 font-weight-bold text-primary" id="wardlist_admit_modal_title">Admit Patient</h5>
	    	</div>
			    <div class="modal-body">
					<form id="wardlist_admit_form" method="POST">
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label for="ward_id">Ward</label>
								<select class="form-control" name="ward_id" id="ward_id"> 
						    	<option value="0">Please Select</option>
							        <?php
							        	$sql="SELECT * FROM ward ORDER BY ward ASC";
										$result_ward_list=mysqli_query($con,$sql);
							            while($row_ward_list=mysqli_fetch_array($result_ward_list))
							            {
							            ?>
							            <option value = "<?php echo($row_ward_list['ward_id'])?>" >
							                <?php echo($row_ward_list['ward']);?>
							            </option>
							            <?php
							            };
							        ?>
						    	</select>
							</div>
							<div class="col-md-1 mb-1">
								<label for="bed_id">Bed</label>
								<select class="form-control" name="bed_id" id="bed_id">
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="wardlist_sponsor_select">Sponsor</label>
								<select class="form-control" name="wardlist_sponsor" id="wardlist_sponsor"> 
							    	<option value="0">Please Select</option>
							        <?php
							        	$sponsor_option = set_sponsor_list();
							        	echo $sponsor_option;
							        ?>
							    </select>
							</div>
							<div class="col-md-2 mb-2">
								<div id="admission_date_in">
									<label for="ward_date_in">Date In</label>
									<input type="date" class="form-control" name="ward_date_in" id="ward_date_in">
								</div>
							</div>
							<div class="col-md-2 mb-2">
								<div id="admission_admitting_officer">
									<label for="wardlist_admitting_officer">Admitting Officer</label>
									<input type="text" class="form-control" name="wardlist_admitting_officer" id="wardlist_admitting_officer">
								</div>
							</div>
							<div class="col-md-2 mb-2">
								<div id="admission_type">
									<label for="wardlist_type_of_admission">Type of Admission</label>
									<select class="form-control" name="wardlist_type_of_admission" id="wardlist_type_of_admission"> 
								    	<option value="0">Please Select</option>
								    	<option value="normal_admission">Normal Admission</option>
								    	<option value="referred_in">Referred In</option>
								    	<option value="transferred_in">Transferred In</option>
							    	</select>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="wardlist_comment">Comment</label>
								<textarea type="textarea" rows="2"  class="form-control" name="wardlist_comment" id="wardlist_comment" value=""></textarea>
								<input type="hidden" name="wardlist_id" class="form-control" id="wardlist_id" value="">
								<input type="hidden" name="wardlist_attend_id" class="form-control" id="wardlist_attend_id" value="">
								<input type="hidden" name="wardlist_patient_id" class="form-control" id="wardlist_patient_id" value="">
							</div>
						</div>
					</form>
				</div>
			    <div class="modal-footer">
			        <div id="wardlist_save_update">
						<button type="button" id="wardlist_admit_save_btn" class="btn btn-primary">Save</button>
						<button type="button" id="wardlist_admit_update_btn" class="btn btn-primary">Update</button>
						<button type="button" id="wardlist_admit_cancel_btn" class="btn btn-primary" data-dismiss="modal">Cancel</button>
					</div>
			    </div>
			</form>
	    </div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" 
	id="wardlist_transfer_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="wardlist_transfer_modal" 
	aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	    		<h5 class="modal-title m-0 font-weight-bold text-primary" id="wardlist_transfer_modal_title">Transfer Patient</h5>
	    	</div>
			    <div class="modal-body">
			    	<form id="wardlist_transfer_from_form" method="POST">
						<div class="form-row">
							<div class="col-md-4 mb-4">
								<label for="ward_id_tf">Ward</label>
								<select class="form-control" name="ward_id_tf" id="ward_id_if" disabled="true"> 
						    	<option value="0">Please Select</option>
							        <?php
							        	$sql="SELECT * FROM ward ORDER BY ward ASC";
										$result_ward_list=mysqli_query($con,$sql);
							            while($row_ward_list=mysqli_fetch_array($result_ward_list))
							            {
							            ?>
							            <option value = "<?php echo($row_ward_list['ward_id'])?>" >
							                <?php echo($row_ward_list['ward']);?>
							            </option>
							            <?php
							            };
							        ?>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="bed_id_tf">Bed</label>
								<select class="form-control" name="bed_id_tf" id="bed_id_tf" disabled="true">
									<option value="0">Please Select</option>
							        <?php
							        	$sql="SELECT * FROM bed ORDER BY bed ASC";
										$result_bed_list=mysqli_query($con,$sql);
							            while($row_bed_list=mysqli_fetch_array($result_bed_list))
							            {
							            ?>
							            <option value = "<?php echo($row_bed_list['bed_id'])?>" >
							                <?php echo($row_bed_list['bed']);?>
							            </option>
							            <?php
							            };
							        ?>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
									<label for="date_in_tf">Date In</label>
									<input type="date" class="form-control" name="date_in_tf" id="date_in_tf" disabled="true">
							</div>
							<div class="col-md-2 mb-2">
									<label for="officer_tf">Admitting Officer</label>
									<input type="text" class="form-control" name="officer_tf" id="officer_tf" disabled="true">
							</div>
							<div class="col-md-2 mb-2">
									<label for="type_of_admission_tf">Type of Admission</label>
									<select class="form-control" name="type_of_admission_tf" id="type_of_admission_tf" disabled="true"> 
								    	<option value="0">Please Select</option>
								    	<option value="normal_admission">Normal Admission</option>
								    	<option value="referred_in">Referred In</option>
								    	<option value="transferred_in">Transferred In</option>
							    	</select>
							</div>
						</div>
					</form>
					<form id="wardlist_transfer_to_form" method="POST">
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label for="ward_id_tt">Ward</label>
								<select class="form-control" name="ward_id_tt" id="ward_id_tt"> 
						    	<option value="0">Please Select</option>
							        <?php
							        	$sql="SELECT * FROM ward ORDER BY ward ASC";
										$result_ward_list=mysqli_query($con,$sql);
							            while($row_ward_list=mysqli_fetch_array($result_ward_list))
							            {
							            ?>
							            <option value = "<?php echo($row_ward_list['ward_id'])?>" >
							                <?php echo($row_ward_list['ward']);?>
							            </option>
							            <?php
							            };
							        ?>
						    	</select>
							</div>
							<div class="col-md-1 mb-1">
								<label for="bed_id_tt">Bed</label>
								<select class="form-control" name="bed_id_tt" id="bed_id_tt">
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="sponsor_tt">Sponsor</label>
								<select class="form-control" name="sponsor_tt" id="sponsor_tt"> 
							    	<option value="0">Please Select</option>
							        <?php
							        	$sponsor_option = set_sponsor_list();
							        	echo $sponsor_option;
							        ?>
							    </select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="date_in_tt">Date In</label>
								<input type="date" class="form-control" name="date_in_tt" id="date_in_tt">
							</div>
							<div class="col-md-2 mb-2">
								<label for="admitting_officer_tt">Admitting Officer</label>
								<input type="text" class="form-control" name="admitting_officer_tt" id="admitting_officer_tt">
							</div>
							<div class="col-md-2 mb-2">
								<label for="admission_type_tt">Type of Admission</label>
								<select class="form-control" name="admission_type_tt" id="admission_type_tt"> 
							    	<option value="0">Please Select</option>
							    	<option value="transferred_in">Transferred In</option>
						    	</select>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="comment_tt">Comment</label>
								<textarea type="textarea" rows="2"  class="form-control" name="comment_tt" id="comment_tt" value=""></textarea>
								<input type="hidden" name="wardlist_id_tf" class="form-control" id="wardlist_id_tf" value="">
							</div>
						</div>
					</form>
				</div>
			    <div class="modal-footer">
					<button type="button" id="wardlist_tt_save_btn" class="btn btn-primary">Save</button>
					<button type="button" id="wardlist_tt_cancel_btn" class="btn btn-primary" data-dismiss="modal">Cancel</button>
			    </div>
			</form>
	    </div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" 
	id="wardlist_discharge_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="wardlist_discharge_modal" 
	aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	    		<h5 class="modal-title m-0 font-weight-bold text-primary" id="wardlist_discharge_modal_title">Discharge Patient</h5>
	    	</div>
		    <div class="modal-body">
		    	<form id="wardlist_discharge_form" method="POST">
					<div class="form-row">
						<div class="col-md-4 mb-4">
							<label for="ward_id_discharge">Ward</label>
							<select class="form-control" name="ward_id_discharge" id="ward_id_discharge" disabled="true"> 
					    	<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM ward ORDER BY ward ASC";
									$result_ward_list=mysqli_query($con,$sql);
						            while($row_ward_list=mysqli_fetch_array($result_ward_list))
						            {
						            ?>
						            <option value = "<?php echo($row_ward_list['ward_id'])?>" >
						                <?php echo($row_ward_list['ward']);?>
						            </option>
						            <?php
						            };
						        ?>
					    	</select>
						</div>
						<div class="col-md-2 mb-2">
							<label for="bed_id_discharge">Bed</label>
							<select class="form-control" name="bed_id_discharge" id="bed_id_discharge" disabled="true">
								<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM bed ORDER BY bed ASC";
									$result_bed_list=mysqli_query($con,$sql);
						            while($row_bed_list = mysqli_fetch_array($result_bed_list))
						            {
						            ?>
						            <option value = "<?php echo($row_bed_list['bed_id'])?>" >
						                <?php echo($row_bed_list['bed']);?>
						            </option>
						            <?php
						            };
						        ?>
					    	</select>
						</div>
						<div class="col-md-2 mb-2">
								<label for="ward_date_out">Date Out</label>
								<input type="date" class="form-control" name="ward_date_out" id="ward_date_out">
						</div>
						<div class="col-md-2 mb-2">
								<label for="wardlist_discharging_officer">Discharging Officer</label>
								<input type="text" class="form-control" name="wardlist_discharging_officer" id="wardlist_discharging_officer">
						</div>
						<div class="col-md-2 mb-2">
								<label for="wardlist_type_of_discharge">Type of Discharge</label>
								<select class="form-control" name="wardlist_type_of_discharge" id="wardlist_type_of_discharge"> 
							    	<option value="0">-Please Select-</option>
							    	<option value="discharged">Discharged</option>
							    	<option value="died">Died</option>
							    	<option value="absconded">Absconded</option>
							    	<option value="discharged_against_medical_advice">Discharged Against Medical Advice</option>
							    	<!--<option value="referred_out">Referred Out</option>
							    	<option value="transferred_out">Transferred Out</option>-->
						    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="wardlist_comment_discharge">Comment</label>
							<textarea type="textarea" rows="2"  class="form-control" name="wardlist_comment_discharge" id="wardlist_comment_discharge" value=""></textarea>
							<input type="hidden" name="wardlist_id_discharge" class="form-control" id="wardlist_id_discharge" value="">
						</div>
					</div>
				</form>
			</div>
		    <div class="modal-footer">
		    	<button type="button" id="wardlist_discharge_save_btn" class="btn btn-primary">Save</button>
				<button type="button" id="wardlist_discharge_update_btn" class="btn btn-primary">Update</button>
				<button type="button" id="wardlist_discharge_cancel_btn" class="btn btn-primary" data-dismiss="modal">Cancel</button>
		    </div>
	    </div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" 
	id="wardlist_referral_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="wardlist_referral_modal" 
	aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	    		<h5 class="modal-title m-0 font-weight-bold text-primary" id="wardlist_referral_modal_title">Refer Patient</h5>
	    	</div>
		    <div class="modal-body">
		    	<form id="wardlist_referral_form" method="POST">
					<div class="form-row">
						<div class="col-md-5 mb-5">
							<label for="facility">Facility</label>
							<input type="text" class="form-control" name="facility" id="facility">
						</div>
						<div class="col-md-3 mb-3">
							<label for="ref_doctor">Doctor</label>
							<input type="text" class="form-control" name="ref_doctor" id="ref_doctor">
						</div>
						<div class="col-md-2 mb-2">
								<label for="ref_date">Date</label>
								<input type="date" class="form-control" name="ref_date" id="ref_date">
						</div>
						<div class="col-md-2 mb-2">
								<label for="ref_time">Time</label>
								<input type="time" class="form-control" name="ref_time" id="ref_time">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="alertness">Alertness</label>
								<select class="form-control" name="alertness" id="alertness"> 
					    		<option value="0">Please Select</option>
					    		<option value="alert">Alert</option>
					    		<option value="semi_concious">Semi-Concious</option>
					    		<option value="comatose">Comatose</option>
					    	</select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="walking">Walking</label>
							<select class="form-control" name="walking" id="walking"> 
					    		<option value="0">Please Select</option>
					    		<option value="walking">Walking</option>
					    		<option value="stretcher">Stretcher</option>
					    		<option value="wheel_chair">Wheel Chair</option>
					    		<option value="with_ambulance">With Ambulance</option>
					    	</select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="illness_state">Illness State</label>
							<select class="form-control" name="illness_state" id="illness_state"> 
					    		<option value="0">Please Select</option>
					    		<option value="satisfactory">Satisfactory</option>
					    		<option value="ill">Ill</option>
					    		<option value="critically_ill">Critically Ill</option>
					    	</select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="urgency">Urgency</label>
							<select class="form-control" name="urgency" id="urgency"> 
					    		<option value="0">Please Select</option>
					    		<option value="immediate_transfer_required">Immediate Transfer Required</option>
					    		<option value="by_appointment">By Appointment</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-3 mb-3">
								<label for="accompanied">Accompanied by Staff</label>
								<select class="form-control" name="accompanied" id="accompanied"> 
									<option value="0">Please Select</option>
					    			<option value="yes">Yes</option>
					    			<option value="no">No</option>
					    		</select>
						</div>
						<div class="col-md-3 mb-3">
							<div id="rsn">
								<label for="referral_staff_name">Staff Name</label>
								<input type="text" class="form-control" name="referral_staff_name" id="referral_staff_name">
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="reason">Reason for referral</label>
							<textarea type="textarea" rows="4"  class="form-control" name="reason" id="reason" value=""></textarea>
						</div>
						<div class="col-md-6 mb-6">
							<label for="action_taken">Action Taken</label>
							<textarea type="textarea" rows="4"  class="form-control" name="action_taken" id="action_taken" value=""></textarea>
						</div>
					</div>
				</form>
			</div>
		    <div class="modal-footer">
		    	<button type="button" id="referal_save_btn" class="btn btn-primary">Save</button>
				<button type="button" id="referal_update_btn" class="btn btn-primary">Update</button>
				<button type="button" id="referal_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<input type="hidden" name="referral_id" class="form-control" id="referral_id" value="">
		    </div>
	    </div>
	</div>
</div>

<div 
	class="modal fade bd-example-modal-xl" 
	id="wardlist_delete_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="wardlist_delete_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	    		<h5 class="modal-title m-0 font-weight-bold text-primary" id="wardlist_delete_modal_title">Ward List Deletion</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="wardlist_delete_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="wardlist_delete_yes" name="wardlist_delete_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="wardlist_delete_no" name="wardlist_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>

<div 
	class="modal fade bd-example-modal-xl" 
	id="wardlist_duplicate_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="wardlist_duplicate_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	    		<h5 class="modal-title m-0 font-weight-bold text-primary" id="wardlist_duplicate_modal_title">Ward List Deletion</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="wardlist_duplicate_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="wardlist_duplicate_yes" name="wardlist_duplicate_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="wardlist_duplicate_no" name="wardlist_duplicate_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>