<?php
	include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
    $query = "SELECT * FROM management_plan WHERE attend_id=$attend_id ORDER BY date DESC, time DESC";
    $query_run = mysqli_query($con, $query);

    $query_nn = "SELECT * FROM nurses_notes WHERE attend_id=$attend_id ORDER BY date DESC";
    $query_run_nn = mysqli_query($con, $query_nn);

    $query_rehab = "SELECT * FROM rehabilitation WHERE attend_id=$attend_id ORDER BY date DESC";
    $query_run_rehab = mysqli_query($con, $query_rehab);

    date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
?>
<div class="form-row">
	<div class="col-md-6 mb-6">
	</div>
	<div class="col-md-2 mb-2">
		<a href="#" id="mgtplan_history_icon"><i class="fa fa-history fa-lg"></i> Past Mgt Plan</a>
	</div>
	<div class="col-md-2 mb-2">
		<a href="#" id="nnotes_history_icon"><i class="fa fa-history fa-lg"></i> Past Nurses Notes</a>
	</div>
	<div class="col-md-2 mb-2">
		<a href="#" id="rehab_history_icon"><i class="fa fa-history fa-lg"></i> Past Rehab</a>
	</div>
</div>
<ul class="nav nav-tabs">
	<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#mgtplan_current">Management Plan</a></li>
	<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#nurese_notes_current">Nurses Notes</a></li>
	<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#rehab_current">Rehabilitation</a></li>
</ul>
<div class="tab-content">
	<div id="mgtplan_current" class="tab-pane fade show active">
		<?php
		if (
			$_SESSION['user_type'] == 'Ultra_Super_User' OR 
			$_SESSION['user_type'] == 'Super_User' OR 
			(
				$_SESSION['user_type'] == 'Normal_User' AND 
				$_SESSION['Create_Mgt_Plan'] == 'Yes'
			)
		) 
		{
			echo '<form id="management_plan_form" method="POST">
			<div class="form-row">
				<div class="col-md-2 mb-2">
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="management_plan_date">Date</label>
							<input type="date" class="form-control" name="management_plan_date" id="management_plan_date" value="'.$date.'">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="management_plan_time">Time</label>
							<input type="text" class="form-control" name="management_plan_time" id="management_plan_time" value="'.$time.'">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="management_plan_initials">Initials</label>
							<input type="text" class="form-control" name="management_plan_initials" id="management_plan_initials" value="'.$_SESSION['full_name'].'">
						</div>
					</div>
				</div>
				<div class="col-md-10 mb-10">
					<label for="management_plan">Management Plan</label>
					<textarea type="textarea" rows="7"  class="form-control" name="management_plan" id="management_plan" value=""></textarea>
					<input type="hidden" name="management_plan_id" class="form-control" id="management_plan_id">
				</div>
			</div>
				<hr class="d-none d-md-block">
				<button type="submit" id="management_plan_save_btn" name="management_plan_save_btn" class="btn btn-primary">Save</button>
				<button type="submit" id="management_plan_update_btn" name="management_plan_update_btn" class="btn btn-primary" hidden="true">Update</button>
			</form>
			<hr class="d-none d-md-block">';
		};
		?>
		
		<div class="table-responsive" id="attend_management_plan_table">
		    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
		        <thead>
		            <tr>
		                <th>Date</th>
		                <th>Time</th>
		                <th>Initials</th>
		                <th>Management Plan</th>
		                <th>Action</th>
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
		                    <td><?php echo $row['date'];?></td>
		                    <td><?php echo $row['time'];?></td>
		                    <td><?php echo $row['initials'];?></td>
		                    <td><?php echo nl2br($row['mgt_notes']);?></td>
	                        <td>
								<?php
								if ($_SESSION['user_id'] == $row['user_id']) 
								{
									if($row['date'] == $date_today)
									{
										if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Mgt_Plan'] == 'Yes')) 
										{
											echo '<a href="#" id="btn_edit_management_plan" data-id="'.$row['mp_id'].'">Edit</a>';
										};
										if (
											$_SESSION['user_type'] == 'Ultra_Super_User' OR 
											$_SESSION['user_type'] == 'Super_User' OR 
											($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Mgt_Plan'] == 'Yes')) 
										{
											echo ' | <a href="#" id="btn_delete_management_plan" data-id="'.$row['mp_id'].'">Delete</a>';
										};
									};
								};
								?>
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
	<div id="nurese_notes_current" class="tab-pane fade">
		<?php
		if (
			$_SESSION['user_type'] == 'Ultra_Super_User' OR 
			$_SESSION['user_type'] == 'Super_User' OR 
			(
				$_SESSION['user_type'] == 'Normal_User' AND 
				$_SESSION['Create_Nurses_Notes'] == 'Yes'
			)
		) 
		{
			echo '<form id="nnotes_form" method="POST">
				<div class="form-row">
					<div class="col-md-2 mb-2">
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="nnotes_date">Date</label>
								<input type="date" class="form-control" name="nnotes_date" id="nnotes_date" value="'.$date.'">
							</div>
							<div class="col-md-12 mb-12">
								<label for="nnotes_time">Time</label>
								<input type="text" class="form-control" name="nnotes_time" id="nnotes_time" value="'.$time.'">
							</div>
							<div class="col-md-12 mb-12">
								<label for="nnotes_initials">Initials</label>
								<input type="text" class="form-control" name="nnotes_initials" id="nnotes_initials" value="'.$_SESSION['full_name'].'">
							</div>
						</div>
					</div>
					<div class="col-md-10 mb-10">
						<label for="nurses_notes">Nurses Note</label>
						<textarea type="textarea" rows="7"  class="form-control" name="nurses_notes" id="nurses_notes" value=""></textarea>
						<input type="hidden" name="nn_id" class="form-control" id="nn_id" value="">
					</div>
				</div>
				<hr class="d-none d-md-block">
				<div id="nnotes_save_update">
					<button type="submit" id="nnotes_save_btn" class="btn btn-primary">Save</button>
					<button type="submit" id="nnotes_update_btn" class="btn btn-primary" hidden="true">Update</button>
				</div>
			</form>
			<hr class="d-none d-md-block">';
		};
		?>
		<div class="table-responsive" id="attend_nnotes_table">
		    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
		        <thead>
		            <tr>
		                <th>Date</th>
		                <th>Time</th>
		                <th>Initials</th>
		                <th>Nurses Notes</th>
		                <th>Action</th>
		            </tr>
		        </thead>
		        <tbody class="pv-table-body">
		            <?php
		                if (mysqli_num_rows($query_run_nn) > 0)
		                {
		                    while($row_nn=mysqli_fetch_assoc($query_run_nn))
		                    {
		            ?>
		                <tr>
		                    <td><?php echo $row['date'];?></td>
		                    <td><?php echo $row['time'];?></td>
		                    <td><?php echo $row_nn['initials'];?></td>
		                    <td><?php echo nl2br($row_nn['nurses_notes']);?></td>
	                        <td>
	                        	<?php
								if($row['date'] == $date_today)
									{
										if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Nurses_Notes'] == 'Yes' AND $_SESSION['user_id'] == $row['user_id'])) 
										{
											echo '<a href="#" id="btn_edit_nnotes" data-id1="'.$row_nn['nn_id'].'">Edit</a>';
										};
										if (
											$_SESSION['user_type'] == 'Ultra_Super_User' OR 
											$_SESSION['user_type'] == 'Super_User' OR 
											($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Nurses_Notes'] == 'Yes' AND $_SESSION['user_id'] == $row['user_id'])) 
										{
											echo ' | <a href="#" id="btn_delete_nnotes" data-id="'.$row_nn['nn_id'].'">Delete</a>';
										};
									};
								?>
								
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
	<div id="rehab_current" class="tab-pane fade">
		<?php
		if (
			$_SESSION['user_type'] == 'Ultra_Super_User' OR 
			$_SESSION['user_type'] == 'Super_User' OR 
			(
				$_SESSION['user_type'] == 'Normal_User' AND 
				$_SESSION['Create_Rehab'] == 'Yes'
			)
		) 
		{
			echo '<form id="rehab_form" method="POST">
				<div class="form-row">
					<div class="col-md-2 mb-2">
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="rehab_date">Date</label>
								<input type="date" class="form-control" name="rehab_date" id="rehab_date" value="'.$date.'">
							</div>
							<div class="col-md-12 mb-12">
								<label for="rehab_time">Time</label>
								<input type="text" class="form-control" name="rehab_time" id="rehab_time" value="'.$time.'">
							</div>
							<div class="col-md-12 mb-12">
								<label for="rehab_initials">Initials</label>
								<input type="text" class="form-control" name="rehab_initials" id="rehab_initials" value="'.$_SESSION['full_name'].'">
							</div>
						</div>
					</div>
					<div class="col-md-10 mb-10">
						<label for="rehab_notes">Rehab Note</label>
						<textarea type="textarea" rows="7"  class="form-control" name="rehab_notes" id="rehab_notes" value=""></textarea>
						<input type="hidden" name="rehab_id" class="form-control" id="rehab_id" value="">
					</div>
				</div>
				<hr class="d-none d-md-block">
				<div id="rehab_save_update">
					<button type="submit" id="rehab_save_btn" class="btn btn-primary">Save</button>
					<button type="submit" id="rehab_update_btn" class="btn btn-primary" hidden="true">Update</button>
				</div>
			</form>
			<hr class="d-none d-md-block">';
		};
		?>
		<div class="table-responsive" id="attend_rehab_table">
		    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
		        <thead>
		            <tr>
		                <th>Date</th>
		                <th>Time</th>
		                <th>Initials</th>
		                <th>Rehab Notes</th>
		                <th>Action</th>
		            </tr>
		        </thead>
		        <tbody class="pv-table-body">
		            <?php
		                if (mysqli_num_rows($query_run_rehab) > 0)
		                {
		                    while($row_rehab = mysqli_fetch_assoc($query_run_rehab))
		                    {
		            ?>
		                <tr>
		                    <td><?php echo $row_rehab['date'];?></td>
		                    <td><?php echo $row_rehab['time'];?></td>
		                    <td><?php echo $row_rehab['initials'];?></td>
		                    <td><?php echo $row_rehab['rehab_notes'];?></td>
	                        <td>
	                        	<?php
								if($row['date'] == $date_today)
									{
										if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Rehab'] == 'Yes' AND $_SESSION['user_id'] == $row['user_id'])) 
										{
											echo '<a href="#" id="btn_edit_rehab" data-id1="'.$row_rehab['rehab_id'].'">Edit</a>';
										};
										if (
											$_SESSION['user_type'] == 'Ultra_Super_User' OR 
											$_SESSION['user_type'] == 'Super_User' OR 
											($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Rehab'] == 'Yes' AND $_SESSION['user_id'] == $row['user_id'])) 
										{
											echo ' | <a href="#" id="btn_delete_rehab" data-id="'.$row_rehab['rehab_id'].'">Delete</a>';
										};
									};
								?>
								
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
	
<div class="modal fade bd-example-modal-xl" id="mgtplan_history_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary">Management Plan History</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="table-responsive" id="attend_mgtplanhistory_table">
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="nnotes_history_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary">Nurses Notes History</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="table-responsive" id="attend_nnoteshistory_table">
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="rehab_history_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary">Rehab History</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="table-responsive" id="attend_rehabhistory_table">
			</div>
		</div>
	</div>
</div>

<div 
	class="modal fade bd-example-modal-xl" 
	id="plan_note_delete_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="plan_note_delete_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="plan_note_delete_modal_title">Management Plan Deletion</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="plan_note_delete_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="plan_note_delete_yes" name="plan_note_delete_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="plan_note_delete_no" name="plan_note_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>