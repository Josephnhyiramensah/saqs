<?php
	include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
    $query = "SELECT * FROM surgery_list WHERE attend_id=$attend_id ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
?>
	
<ul class="nav nav-tabs">
	<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#surgery_current">Surgery/Procedure</a></li>
	<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#surgery_history" id="surgery_history_icon">Past Surgeries/Procedures</a></li>
</ul>
<div class="tab-content">
	<div id="surgery_current" class="tab-pane fade show active">
		<form id="surgery_attend_form" method="POST">
			<div class="form-row">
				<div class="col-md-4 mb-4">
					<label for="surgery">Procedure/Surgery Description</label>
					<select class="form-control" name="surgery" id="surgery"> 
			    		<option value="0">Please Select</option>
				        <?php
				        	$sql="SELECT * FROM surgery ORDER BY surgery ASC";
							$result=mysqli_query($con,$sql);
				            while($row=mysqli_fetch_array($result))
				            {
				            ?>
				            <option value = "<?php echo($row['surgery_id'])?>" >
				                <?php echo($row['surgery']) ?>
				            </option>
				            <?php
				            }               
				        ?>
			    	</select>
				</div>
				<div class="col-md-3 mb-3">
					<label for="surgeon">Head Surgeon</label>
					<input type="text" class="form-control" name="surgeon" id="surgeon">
				</div>
				<div class="col-md-2 mb-2">
					<label for="anesthetist">Anesthetist</label>
					<input type="text" class="form-control" name="anesthetist" id="anesthetist">
				</div>
				<div class="col-md-1 mb-1">
					<label for="procqty">Qty</label>
					<input type="text" class="form-control" name="procqty" id="procqty">
				</div>
				<div class="col-md-1 mb-1">
					<label for="procprice">Price</label>
					<input type="text" class="form-control" name="procprice" id="procprice">
				</div>
				<div class="col-md-1 mb-1">
					<label for="procamt">Amount</label>
					<input type="text" class="form-control" name="procamt" id="procamt">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-12 mb-12">
					<label for="surgery_comment">Comment</label>
					<textarea type="textarea" rows="2"  class="form-control" name="surgery_comment" id="surgery_comment" value=""></textarea>
						<input type="hidden" name="surgery_list_id" class="form-control" id="surgery_list_id" value="">
				</div>
			</div>
			<hr class="d-none d-md-block">
			<div id="surgery_save_update">
				<button type="submit" id="surgery_attend_save_btn" class="btn btn-primary">Save</button>
			</div>
		</form>
		<hr class="d-none d-md-block">
		<div class="table-responsive" id="attend_surgery_table">
		    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
		        <thead>
		            <tr>
		                <th>Date</th>
		                <th>Procedure/Surgery</th>
		                <th>Comment</th>
		                <th>Action</th>
		                <th>Delete</th>
		            </tr>
		        </thead>
		        <tbody class="pv-table-body">
		            <?php
		                if (mysqli_num_rows($query_run) > 0)
		                {
		                    while($row=mysqli_fetch_assoc($query_run))
		                    {
		                    	$surgery_id = $row['surgery_id'];
		                    	$query = "SELECT * FROM surgery WHERE surgery_id=$surgery_id";
								$query_run = mysqli_query($con, $query);
								$row_surgery=mysqli_fetch_assoc($query_run);
		            ?>
		                <tr>
		                    
		                    <td><a href="#" id="btn_edit_surgery_attend" data-id1="<?php echo $row['surgery_id'];?>"><?php echo $row['date'];?></a></td>
		                    <td><?php echo $row_surgery['surgery'];?></td>
		                    <td><?php echo $row['comment'];?></td>
		                    <td>
								<a href="#" id="btn_anesthesia" data-id1="<?php echo $row['surgery_list_id'];?>" data-id2="<?php echo $row['surgery_list_id'];?>" class='data-toggle="tooltip" data-placement="left" title="Anesthesia"'><i class="fas fa-file-medical-alt"></i></a>
								| 
								<a href="#" id="btn_opt_notes" data-id1="<?php echo $row['surgery_list_id'];?>" data-id2="<?php echo $row['surgery_id'];?>" class='data-toggle="tooltip" data-placement="right" title="Operation Notes"'><i class="fas fa-file-medical"></i></a>
		                    </td>
		                    <td>
								<a href="#" id="btn_delete_surgery" data-id2="<?php echo $row['surgery_list_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
		                    </td>
		                </tr>
		            <?php
		                    }
		                }
		                else
		                {
		                    echo 'No Record Found';
		                };
		            ?>
		        </tbody>
		    </table>
		</div>
	</div>
	<div id="surgery_history" class="tab-pane fade">
		<div class="table-responsive" id="attend_surgery_history_table">
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="surgery_opt_notes_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="surgery_opt_notes_modal_title">Operation Notes</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="surgery_opt_note_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<div class="form-row">
									<div class="col-md-6 mb-6">
										<div class="form-row">
											<div class="col-md-4 mb-4">
												<label for="surgery_date">Date</label>
												<input type="date" name="surgery_date" class="form-control" id="surgery_date">
											</div>
											<div class="col-md-4 mb-4">
												<label for="surgery_time_start">Start Time</label>
												<input type="time" name="surgery_time_start" class="form-control" id="surgery_time_start">
											</div>
											<div class="col-md-4 mb-4">
												<label for="surgery_time_end">End Time</label>
												<input type="time" name="surgery_time_end" class="form-control" id="surgery_time_end">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-12 mb-12">
												<label for="surgery_head">Head Surgeon</label>
												<input type="text" name="surgery_head" class="form-control" id="surgery_head">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-6 mb-6">
												<label for="surgery_assist">Assistant Surgeon</label>
												<input type="text" name="surgery_assist" class="form-control" id="surgery_assist">
											</div>
											<div class="col-md-6 mb-6">
												<label for="surgery_nurse">Scrub Nurse</label>
												<input type="text" name="surgery_nurse" class="form-control" id="surgery_nurse">
											</div>
										</div>
									</div>
									<div class="col-md-6 mb-6">
										<label for="surgery_findings">Findings</label>
										<textarea type="textarea" rows="7"  class="form-control" name="surgery_findings" id="surgery_findings" value=""></textarea>
									</div>
								</div>
									<input type="hidden" name="surgery_id_op" class="form-control" id="surgery_id_op">
									<input type="hidden" name="surgery_list_id_op" class="form-control" id="surgery_list_id_op">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="surgery_procedure">Procedures</label>
								<textarea type="textarea" rows="4"  class="form-control" name="surgery_procedure" id="surgery_procedure" value=""></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="surgery_opt_note_save_update">
						<button type="submit" name="surgery_opt_note_save_btn" id="surgery_opt_note_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    <button type="submit" name="surgery_opt_note_update_btn" id="surgery_opt_note_update_btn" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="surgery_anesthesia_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="surgery_anesthesia_modal_title">Anesthesia Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="surgery_anesthesia_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="surgery_rscp"><small>Rapid Seq. Cricoid Pres.</small></label>
								<select class="form-control bg-light" name="surgery_rscp" id="surgery_rscp"> 
						    		<option value="0">Please Select</option>
							        <option value="Pre O2">Pre O2</option>
							        <option value="IV">IV</option>
							        <option value="IM">IM</option>
							        <option value="IH">IH</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_airway"><small>Air Way</small></label>
								<select class="form-control bg-light" name="surgery_airway" id="surgery_airway"> 
						    		<option value="0">Please Select</option>
							        <option value="Oral">Oral</option>
							        <option value="Nasal">Nasal</option>
							        <option value="Cuffed">Cuffed</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_etmethod"><small>ET Method</small></label>
								<select class="form-control bg-light" name="surgery_etmethod" id="surgery_etmethod"> 
						    		<option value="0">Please Select</option>
							        <option value="Mask">Mask</option>
							        <option value="Oral ETT">Oral ETT</option>
							        <option value="LMA">LMA</option>
							        <option value="Nasal ETT">Nasal ETT</option>
							        <option value="Laser">Laser</option>
							        <option value="Nasal Cannula">Nasal Cannula</option>
							        <option value="O2 Mask">O2 Mask</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_intubation"><small>Intubation</small></label>
								<select class="form-control bg-light" name="surgery_intubation" id="surgery_intubation"> 
						    		<option value="0">Please Select</option>
							        <option value="Breathing Sounds Bilater">Breathing Sounds Bilater</option>
							        <option value="Cricoid Pressure">Cricoid Pressure</option>
							        <option value="Difficult Intubation">Difficult Intubation</option>
							        <option value="Atraumatic Intubation">Atraumatic Intubation</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_tube_type"><small>Tube Type</small></label>
								<select class="form-control bg-light" name="surgery_tube_type" id="surgery_tube_type"> 
						    		<option value="0">Please Select</option>
							        <option value="Direct">Direct</option>
							        <option value="Blind">Blind</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_tube_size"><small>Tube Size (mm)</small></label>
								<select class="form-control bg-light" name="surgery_tube_size" id="surgery_tube_size"> 
						    		<option value="0">Please Select</option>
									<option value="2.5">2.5</option>
									<option value="3">3</option>
									<option value="3.5">3.5</option>
									<option value="4">4</option>
									<option value="4.5">4.5</option>
									<option value="5">5</option>
									<option value="5.5">5.5</option>
									<option value="6">6</option>
									<option value="6.5">6.5</option>
									<option value="7">7</option>
									<option value="7.5">7.5</option>
									<option value="8">8</option>
									<option value="8.5">8.5</option>
									<option value="9">9</option>
									<option value="9.5">9.5</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="surgery_date"><small>Taped (cm)</small></label>
								<input type="text" name="surgery_date" class="form-control bg-light" id="surgery_date">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_blade_size"><small>Blade Size</small></label>
								<select class="form-control bg-light" name="surgery_blade_size" id="surgery_blade_size"> 
						    		<option value="0">Please Select</option>
							        <option value="1">1</option>
							        <option value="2">2</option>
							        <option value="3">3</option>
							        <option value="4">4</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_blade_type"><small>Blade Type</small></label>
								<select class="form-control bg-light" name="surgery_blade_type" id="surgery_blade_type"> 
						    		<option value="0">Please Select</option>
							        <option value="Curve">Curve</option>
							        <option value="Straight">Straight</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_eye"><small>Eye</small></label>
								<select class="form-control bg-light" name="surgery_eye" id="surgery_eye"> 
						    		<option value="0">Please Select</option>
							        <option value="Taped">Taped</option>
							        <option value="Lubed">Lubed</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_circuit"><small>Circuit</small></label>
								<select class="form-control bg-light" name="surgery_circuit" id="surgery_circuit"> 
						    		<option value="0">Please Select</option>
							        <option value="Circle">Circle</option>
							        <option value="Draw Over">Draw Over</option>
							        <option value="Semi Open">Semi Open</option>
							        <option value="T-Piece">T-Piece</option>
							        <option value="Non Rebreathing">Non Rebreathing</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_crystaloids"><small>Crystaloids</small></label>
								<input type="text" name="surgery_crystaloids" class="form-control bg-light" id="surgery_crystaloids">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="surgery_colloid"><small>Colloid</small></label>
								<input type="text" name="surgery_colloid" class="form-control bg-light" id="surgery_colloid">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_prbc"><small>Packed Red Blood Cells</small></label>
								<input type="text" name="surgery_prbc" class="form-control bg-light" id="surgery_prbc">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_platelets"><small>Platelets</small></label>
								<input type="text" name="surgery_platelets" class="form-control bg-light" id="surgery_platelets">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_others"><small>Others</small></label>
								<input type="text" name="surgery_others" class="form-control bg-light" id="surgery_others">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_ebl"><small>Estimated Blood Loss</small></label>
								<input type="text" name="surgery_ebl" class="form-control bg-light" id="surgery_ebl">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_urine_output"><small>Urine Output</small></label>
								<input type="text" name="surgery_urine_output" class="form-control bg-light" id="surgery_urine_output">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="surgery_exubated"><small>Exubated?</small></label>
								<select class="form-control bg-light" name="surgery_exubated" id="surgery_exubated"> 
						    		<option value="0">Please Select</option>
							        <option value="Yes">Yes</option>
							        <option value="No">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_exubated_date"><small>Exubated Date</small></label>
								<input type="date" name="surgery_exubated_date" class="form-control bg-light" id="surgery_exubated_date">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_exubated_time"><small>Exubated Time</small></label>
								<input type="time" name="surgery_exubated_time" class="form-control bg-light" id="surgery_exubated_time">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_mask"><small>Mask/Throat Pack?</small></label>
								<select class="form-control bg-light" name="surgery_mask" id="surgery_mask"> 
						    		<option value="0">Please Select</option>
							        <option value="Yes">Yes</option>
							        <option value="No">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_mask_date"><small>Mask Out @ Date</small></label>
								<input type="date" name="surgery_mask_date" class="form-control bg-light" id="surgery_mask_date">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_mask_time"><small>Mask Out @ Time</small></label>
								<input type="time" name="surgery_mask_time" class="form-control bg-light" id="surgery_mask_time">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="surgery_blood_req"><small>Blood Requested?</small></label>
								<select class="form-control bg-light" name="surgery_blood_req" id="surgery_blood_req"> 
						    		<option value="0">Please Select</option>
							        <option value="Yes">Yes</option>
							        <option value="No">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_path_req"><small>Pathology Requested?</small></label>
								<select class="form-control bg-light" name="surgery_path_req" id="surgery_path_req"> 
						    		<option value="0">Please Select</option>
							        <option value="Yes">Yes</option>
							        <option value="No">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_usa"><small>USA Status</small></label>
								<select class="form-control bg-light" name="surgery_usa" id="surgery_usa"> 
						    		<option value="0">Please Select</option>
							        <option value="Yes">Yes</option>
							        <option value="No">No</option>
						    	</select>
							</div>
							<div class="col-md-6 mb-6">
								<label for="surgery_anesthetist"><small>Head Anesthetist</small></label>
								<input type="text" name="surgery_anesthetist" class="form-control bg-light" id="surgery_anesthetist">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label for="surgery_tech_desc"><small>Technique Description</small></label>
								<input type="text" name="surgery_tech_desc" class="form-control bg-light" id="surgery_tech_desc">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_tech_date"><small>Tech. Date</small></label>
								<input type="date" name="surgery_tech_date" class="form-control bg-light" id="surgery_tech_date">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_tech_time"><small>Tech. Time</small></label>
								<input type="time" name="surgery_tech_time" class="form-control bg-light" id="surgery_tech_time">
							</div>
							<div class="col-md-1 mb-1 d-flex align-items-center">
								<a href=""><i class="fas fa-plus-square"></i></a>
							</div>
							<div class="col-md-3 mb-3">
								<label for="surgery_assist_anest"><small>Assist. Anesthetist</small></label>
								<input type="text" name="surgery_assist_anest" class="form-control bg-light" id="surgery_assist_anest">
							</div>
							<div class="col-md-1 mb-1 d-flex align-items-center">
								<a href=""><i class="fas fa-user-plus"></i></a>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-6 mb-6">
								<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
							        <thead>
							            <tr>
							                <th>Technique</th>
							                <th>Date</th>
							                <th>Time</th>
							            </tr>
							        </thead>
							        <tbody class="pv-table-body">
									        <tr>
							                    <td></td>
							                    <td></td>
							                    <td></td>
							                </tr>
									</tbody>
							    </table>
							</div>
							<div class="col-md-6 mb-6">
								<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
							        <thead>
							            <tr>
							                <th>Assistant Anesthetist</th>
							            </tr>
							        </thead>
							        <tbody class="pv-table-body">
									        <tr>
							                    <td></td>
							                </tr>
									</tbody>
							    </table>
							</div>
					</div>
						<input type="hidden" name="surgery_id_anes" class="form-control" id="surgery_id_anes">
						<input type="hidden" name="surgery_list_id_anes" class="form-control" id="surgery_list_id_anes">
					</div>
				</div>
				<div class="modal-footer">
					<div id="surgery_opt_note_save_update">
						<button type="submit" name="surgery_anesthesia_save_btn" id="surgery_anesthesia_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    <button type="submit" name="surgery_anesthesia_update_btn" id="surgery_anesthesia_update_btn" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>