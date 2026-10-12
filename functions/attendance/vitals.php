<?php
    $query = "SELECT * FROM vitals WHERE attend_id=$attend_id ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
?>
<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingOne">
		<h6 class="panel-title">
			<a role="button" data-toggle="collapse" data-parent="#accordion" href="#vitals" aria-expanded="true" aria-controls="vitals">
				<h6 class="m-0 font-weight-bold text-primary">Vital Signs</h6>
			</a>
		</h6>
	</div>
	<div id="vitals" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
		<div class="panel-body">
			<div class="form-row">
				<div class="col-md-8 mb-8">
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" data-toggle="" id="vitals_add_icon"><i class="fa fa-heartbeat fa-lg"></i> Add Vitals</a>
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" id="vitals_history_icon"><i class="fa fa-history fa-lg"></i> Past Vitals</a>
				</div>
			</div>
			<div class="table-responsive" id="attend-vitals-table">
			    <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
			        <thead>
			            <tr>
			                <th>Date</th>
			                <th>Temp</th>
			                <th>BP</th>
			                <th>Pulse</th>
			                <th>R.Rate</th>
			                <th>Weight</th>
			                <th>Height</th>
			                <th>Oxygen</th>
			                <th>H.Circ.</th>
			                <th>A.Circ.</th>
			                <th>Comment</th>
			                <th>Delete</th>
			            </tr>
			        </thead>
			        <tbody class="pv-table-body">
			            <?php
			                if (mysqli_num_rows($query_run) > 0)
			                {
			                    while($row=mysqli_fetch_assoc($query_run))
			                    {
			            ?>
			                <tr>
			                    
			                    <td><a href="#" id="btn_edit_vital" data-id1="<?php echo $row['vital_id'];?>"><?php echo $row['date'];?></a></td>
			                    <td><?php echo $row['temp'];?></td>
			                    <td><?php echo $row['bp_systolic'];?>/<?php echo $row['bp_diastolic'];?></td>
			                    <td><?php echo $row['pulse'];?></td>
			                    <td><?php echo $row['resp_rate'];?></td>
			                    <td><?php echo $row['weight'];?></td>
			                    <td><?php echo $row['height'];?></td>
			                    <td><?php echo $row['oxygen_sat'];?></td>
			                    <td><?php echo $row['circ_hip'];?></td>
			                    <td><?php echo $row['circ_abdo'];?></td>
			                    <td><?php echo $row['comment'];?></td>
	                            <td>
									<a href="#" id="btn_delete_vital" data-id2="<?php echo $row['vital_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
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
</div>
<div class="modal fade bd-example-modal-xl" id="vitalsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="vitalsmodaltitle">Enter Vital Signs</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="vitals_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label for="temp">Temperature</label>
								<input type="text" name="temp" class="form-control" id="temp" value="">
							</div>
							<div class="col-md-3 mb-3">
								<label for="bsystolic">BP Systolic</label>
								<input type="text" name="bsystolic" class="form-control" id="bsystolic" value="" required>
							</div>
							<div class="col-md-3 mb-3">
								<label for="bdiastolic">BP Diastolic</label>
								<input type="text" name="bdiastolic" class="form-control" id="bdiastolic" value="" required>
							</div>
							<div class="col-md-3 mb-3">
								<label for="pulse">Pulse</label>
								<input type="text" name="pulse" class="form-control" id="pulse" value="">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label for="rrate">Respiratory Rate</label>
								<input type="text" name="rrate" class="form-control" id="rrate" value="">
							</div>
							<div class="col-md-3 mb-3">
								<label for="weight">Weight</label>
								<input type="text" name="weight" class="form-control" id="weight" value="">
							</div>
							<div class="col-md-3 mb-3">
								<label for="height">Height</label>
								<input type="text" class="form-control" name="height" id="height">
							</div>
							<div class="col-md-3 mb-3">
								<label for="oxygen">Oxygen</label>
								<input type="text" class="form-control" name="oxygen" id="oxygen">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label for="hipcirc">Hip Circum.</label>
								<input type="text" class="form-control" name="hipcirc" id="hipcirc">
							</div>
							<div class="col-md-3 mb-3">
								<label for="abdcirc">Abdominal Circum.</label>
								<input type="text" class="form-control" name="abdcirc" id="abdcirc">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="vitals_comment">Comment</label>
								<textarea type="textarea" rows="4"  class="form-control" name="vitals_comment" id="vitals_comment" value=""></textarea>
							</div>
								<input type="hidden" name="vital_patient_id" class="form-control" id="vital_patient_id" value="<?php echo $patient_id;?>">
								<input type="hidden" name="vital_attend_id" class="form-control" id="vital_attend_id" value="<?php echo $attend_id;?>">
								<input type="hidden" name="vital_id" class="form-control" id="vital_id" value="">
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" id="vitals_save_btn" class="btn btn-primary">Save</button>
				    <button type="submit" id="vitals_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-xl" id="vitalshistorymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary">Vital Signs History</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="table-responsive" id="attend-vitalshistory-table">
			</div>
		</div>
	</div>
</div>

<div 
	class="modal fade bd-example-modal-xl" 
	id="vital_delete_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="vital_delete_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="vital_delete_modal_title">Vital Deletion</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="vital_delete_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="vital_delete_yes" name="vital_delete_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="vital_delete_no" name="vital_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>