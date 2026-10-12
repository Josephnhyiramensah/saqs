
<style type="text/css">
	.scroll-card-body {max-height: 300px;overflow-y: auto;}
	.scroll-card-img {max-height: 700px;overflow-y: auto;}
	.amt-td {text-align:right;}
	.action-td {text-align:center;}
</style>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
    $query = "SELECT * FROM history WHERE patient_id = '$patient_id' ORDER BY date DESC, time DESC";
    $query_run = mysqli_query($con, $query);
	
    date_default_timezone_set("Africa/Accra");
    $date_today = date('Y-m-d');
	if (
		$_SESSION['user_type'] == 'Ultra_Super_User' OR 
		$_SESSION['user_type'] == 'Super_User' OR 
		($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_History'] == 'Yes')) 
    {
		echo '<div id="history_div">
			<ul class="nav nav-tabs">
				<li class="nav-item active"><a class="nav-link" aria-current="page" data-toggle="tab" href="#history_input">History</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#past_history">Past History (Old System)</a></li>
			</ul>
			<div class="tab-content">
				<div id="history_input" class="tab-pane fade show active">
					<form id="add_history_form" method="POST">
						<div class="form-row">
							<div class="col-md-10 mb-10">
								<div class="form-row">
									<div class="col-md-12 mb-12">
										<label>History</label> : - 
											<a href="#" id="upload_medical_history" data-id="'.$attend_id.'" data-id1="'.$patient_id.'">Upload Medical History</a> | 
											<a href="#" id="view_medical_history" data-id="'.$attend_id.'" data-id1="'.$patient_id.'">View Medical History</a>
										<textarea type="textarea" rows="7"  class="form-control" name="history" id="history" value=""></textarea>
										<input type="hidden" id="history_id">
									</div>
								</div>
							</div>
							<div class="col-md-2 mb-2">
								<div class="form-row">
									<div class="col-md-12 mb-12">
									<label>Date</label>
										<input type="date" class="form-control" name="h_date" id="h_date" value="'.$date.'">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-12 mb-12">
									<label>Time</label>
										<input type="time" class="form-control" name="h_time" id="h_time" value="'.$time.'">
									</div>
								</div>
							</div>
						</div>
						<hr class="d-none d-md-block">
						<div id="history_save_update">
							<button type="submit" id="history_save_btn" class="btn btn-primary">Save</button>
						</div>
					</form>
				</div>
				<div id="past_history" class="tab-pane fade">
					<div id="past_history_tab">
						<ul class="nav nav-tabs">
							<li class="nav-item active"><a class="nav-link" aria-current="page" data-toggle="tab" href="#old_complaints">Complaints</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#old_diagnosis">Diagnosis</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#old_drugs">Drugs</a></li>
						</ul>
						<div class="tab-content">
							<div id="old_complaints" class="tab-pane fade show active">
							</div>
							<div id="old_diagnosis" class="tab-pane fade">
							</div>
							<div id="old_drugs" class="tab-pane fade">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>';
	};
?>
			<hr class="d-none d-md-block">
				<div class="table-responsive" id="attend_history_table_div">
				    <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
				        <thead>
				            <tr>
				                <th width="10%">Date</th>
				                <th width="10%">Time</th>
				                <th width="50%">History</th>
				                <th width="15%">Doctor</th>
				                <th width="15%">Action</th>
				            </tr>
				        </thead>
				        <tbody class="pv-table-body">
				            <?php
				                if (mysqli_num_rows($query_run) > 0)
				                {
				                    while($row = mysqli_fetch_assoc($query_run))
				                    {
										$doctor = $row['user_id'];
										$query_doctor = "SELECT * FROM users WHERE id = '$doctor'";
										$query_run_doctor = mysqli_query($con, $query_doctor);
										if(isset($query_run_doctor))
										{
											$row_doctor = mysqli_fetch_assoc($query_run_doctor);
											if($row_doctor != '')
											{
												$doctor = $row_doctor['first_name'];
											}
											else
											{
												$doctor = 'No Doctor Specified';
											};
										}
										else
										{
											$doctor = 'No Doctor Specified';
										};
				            			?>
						                <tr>
						                    <td><?php echo $row['date'];?></td>
						                    <td><?php echo $row['time'];?></td>
						                    <td><?php echo $row['history'];?></td>
						                    <td><?php echo $doctor;?></td>
						                    <td>
						                    <?php
												if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_id'] == $row['user_id'])) 
												{
													if($row['date'] == $date_today)
													{
														if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_History'] == 'Yes')) 
														{
															echo '<a href="#" id="btn_edit_history" data-id="'.$row['history_id'].'">Edit</a>';
														};
														if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_History'] == 'Yes')) 
														{
															echo ' | <a href="#" id="btn_delete_history" data-id1="'.$row['history_id'].'"> Delete</a>';
														};
													};
												};
											?>
						                    </td>
						                </tr>
				            		<?php
				                    };
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
</div>

<div 
	class="modal fade bd-example-modal-xl" 
	id="history_delete_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="history_delete_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="history_delete_modal_title">History Deletion</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="history_delete_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="history_delete_yes" name="history_delete_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="history_delete_no" name="history_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>


<div class="modal fade bd-example-modal-lg" id="hx_med_img_upload_modal" tabindex="-1" role="dialog" aria-hx_medelledby="exampleModalhx_medel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="hx_med_img_upload_modal_title">Upload Medical History Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-hx_medel="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="history_medical_img_upload_form" method="POST" action="history_medical_img_upload.php" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="hx_med_id">Medical History</label>
								<input type="hidden" name="file_size" class="form-control" id="file_size" value="1000000">
									<input type="file" name="hx_med_list_file" class="form-control" id="hx_med_list_file">
									<input type="hidden" name="hx_med_list_id_img" class="form-control" id="hx_med_list_id_img">
									<input type="hidden" name="hx_med_id_img" class="form-control" id="hx_med_id_img">
									<input type="hidden" name="attend_id_img" class="form-control" id="attend_id_img">
									<input type="hidden" name="patient_id_img" class="form-control" id="patient_id_img">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="hx_med_img_comment">Comment</label>
								<textarea type="textarea" rows="2"  class="form-control" name="hx_med_img_comment" id="hx_med_img_comment" value=""></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="hx_med_list_file_save_update">
						<button type="submit" name="hx_med_list_img_save_btn" id="hx_med_list_img_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    <button type="submit" name="hx_med_list_img_update_btn" id="hx_med_list_img_update_btn" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-lg" id="hx_med_img_display_modal" tabindex="-1" role="dialog" aria-hx_medelledby="hx_med_img_display_modal" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="max-width: 70%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="hx_med_img_display_modal_title">Display Medical History</h5>
				<button type="button" class="close" data-dismiss="modal" aria-hx_medel="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="hx_med_list_img_display" class="scroll-card-img text-center">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');
	include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');
?>