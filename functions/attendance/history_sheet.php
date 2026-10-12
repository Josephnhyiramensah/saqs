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
		echo '<form id="add_history_form" method="POST">
				<div class="form-row">
					<div class="col-md-10 mb-10">
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label>History</label>
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
			</form>';
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
												if (/*$_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND*/ $_SESSION['user_id'] == $row['user_id']) 
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
<!--<script>
	$(window).on("beforeunload", function() 
	{
    	return confirm("Do you really want to close?"); 
	});
	var history_id = $('#history_id').val();
	var history = $('#history').val();
	var date = $('#h_date').val();
	var time = $('#h_time').val();
</script>-->
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');
	include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');
?>