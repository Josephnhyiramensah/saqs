<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
    $query = "SELECT * FROM diagnosis_list WHERE attend_id=$attend_id ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);

	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
?>

<ul class="nav nav-tabs">
	<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#current_diagnosis">Current Diagnosis</a></li>
	<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#diagnosis_history" id="diagnosis_history_icon">Past Diagnosis</a></li>
</ul>
<div class="tab-content">
	<div id="current_diagnosis" class="tab-pane fade show active">
		<?php
        if (
        	$_SESSION['user_type'] == 'Ultra_Super_User' OR 
        	$_SESSION['user_type'] == 'Super_User' OR 
        	($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Diagnosis_List'] == 'Yes')) 
        {
	            echo '<div class="diag_input">
				<form id="diagnosis_attend_form" method="POST">
				
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="diagnosis"><a href="#" id="btn_diagnosis_live_search"><h5><strong>Click to add diagnosis</strong></h5></a></label>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<select class="form-control" name="diagnosis" id="btn_diagnosis_live_search" hidden="true"> 
					    	<option value="0">Please Select</option>';
						       $sql="SELECT * FROM diagnosis ORDER BY diagnosis ASC";
									$result_diaglist=mysqli_query($con,$sql);
						            while($row_diaglist=mysqli_fetch_array($result_diaglist))
						            {
						            echo '<option value = "'.$row_diaglist['diagnosis_id'].'">'.$row_diaglist['diagnosis'].'</option>';
						            };
					    	echo '</select>
					</div>
						<div class="col-md-2 mb-2" hidden="true">
							<label for="diag_sponsor_select">Sponsor</label>
							<select class="form-control" name="diag_sponsor" id="diag_sponsor"> 
						    	<option value="0">Please Select</option>';
						        	$sponsor_option = set_sponsor_list();
						        	echo $sponsor_option;
						    echo '</select>
						</div>
						<div class="col-md-2 mb-2" hidden="true">
							<label for="diag_date">Date</label>
							<input type="date" class="form-control" name="diag_date" id="diag_date" value="'.$date.'">
						</div>
						<div class="col-md-1 mb-1" hidden="true">
							<label for="diag_amt">Amount</label>
							<input type="text" class="form-control" name="diag_amt" id="diag_amt">
						</div>
						<div class="col-md-1 mb-1" hidden="true">
							<label for="diag_gdrg">G-DRG</label>
							<input type="text" class="form-control" name="diag_gdrg" id="diag_gdrg">
						</div>
					</div>
					<div class="form-row" hidden="true">
						<div class="col-md-12 mb-12">
							<label for="diag_comment">Comment</label>
							<textarea type="textarea" rows="2"  class="form-control" name="diag_comment" id="diag_comment" value=""></textarea>
							<input type="hidden" name="diagnosis_list_id" class="form-control" id="diagnosis_list_id" value="">
						</div>
					</div>
					<hr class="d-none d-md-block" hidden="true">
					<div id="diagnosis_save_update" hidden="true">
						<button type="button" id="diag_save_btn" class="btn btn-primary">Save</button>
					</div>
				    
				</form>
			</div>
			<hr class="d-none d-md-block">';
		};
		    $query = "SELECT * FROM diagnosis_list WHERE attend_id='$attend_id' ORDER BY date DESC";
		    $query_run = mysqli_query($con, $query);
		?>
		<div class="table-responsive" id="attend_diagnosis_table">
		    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
		        <thead>
		            <tr>
		                <th class="action-td">Date</th>
		                <th class="action-td">Diagnosis</th>
		                <th class="action-td">ICD 10</th>
		                <th class="action-td">G-DRG</th>
		                <th class="action-td">Principal?</th>
		                <th class="action-td">Comment</th>
		                <th class="action-td">Action</th>
		            </tr>
		        </thead>
		        <tbody class="pv-table-body">
		            <?php
		                if (mysqli_num_rows($query_run) > 0)
		                {
		                    while($row=mysqli_fetch_assoc($query_run))
		                    {
		                    	$diagnosis_id = $row['diagnosis_id'];
		                    	$query = "SELECT * FROM diagnosis WHERE diagnosis_id='$diagnosis_id'";
								$query_run_diag = mysqli_query($con, $query);
								$row_diag=mysqli_fetch_assoc($query_run_diag);

								$nhis_id = $row['nhis_id'];
								$query_gdrg = "SELECT * FROM nhis WHERE nhis_id ='$nhis_id'";
								$result_gdrg = mysqli_query($con,$query_gdrg);
								$row_gdrg = mysqli_fetch_array($result_gdrg);
								if($age < 12)
								{
									if(isset($row_gdrg['gdrg_child']))
									{$diag_gdrg = $row_gdrg['gdrg_child'];}else
									{$diag_gdrg = 'N/A';};
								}
								else
								{
									if(isset($row_gdrg['gdrg_adult']))
									{$diag_gdrg = $row_gdrg['gdrg_adult'];}else
									{$diag_gdrg = 'N/A';};
								};
		            ?>	
		                <tr>
		                    <td class="action-td"><?php echo $row['date'];?></td>
		                    <td><?php echo $row_diag['diagnosis'];?></td>
		                    <td class="action-td"><?php echo $row_diag['icd_10'];?></td>
		                    <td class="action-td"><?php echo $diag_gdrg;?></td>
		                    <td class="action-td"><?php echo $row['is_principal'];?></td>
		                    <td><?php echo $row['comment'];?></td>
	                        <td>
								<?php
									if ($_SESSION['user_id'] == $row['user_id']) 
									{
										if($row['date'] == $date_today)
										{
											if (
											$_SESSION['user_type'] == 'Ultra_Super_User' OR 
											$_SESSION['user_type'] == 'Super_User' OR 
											($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Diagnosis_List'] == 'Yes')) 
											{
											echo '<a href="#" id="btn_edit_diag" data-id1="'.$row['diagnosis_list_id'].'">Edit</a>';
											};
											if (
												$_SESSION['user_type'] == 'Ultra_Super_User' OR 
												$_SESSION['user_type'] == 'Super_User' OR 
												($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Diagnosis_List'] == 'Yes')) 
											{
											echo ' | <a href="#" id="btn_delete_diag" data-id2="'.$row['diagnosis_list_id'].'"> Delete</a>';
											};
										};
									};
			                	?>
	                        </td>
		                </tr>
		            <?php
		                    }
		                };
		            ?>
		        </tbody>
		    </table>
		</div>
	</div>
	<div id="diagnosis_history" class="tab-pane fade">
	 	<div class="table-responsive" id="attend_diagnosis_history_table">
		</div>
	</div>
</div>
<div 
	class="modal fade bd-example-modal-xl" 
	id="diagnosis_list_delete_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="diagnosis_list_delete_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="diagnosis_list_delete_modal_title">Diagnosis Deletion</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="diagnosis_list_delete_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="diagnosis_list_delete_yes" name="diagnosis_list_delete_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="diagnosis_list_delete_no" name="diagnosis_list_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>

<div 
	class="modal fade bd-example-modal-xl" 
	id="diagnosis_list_duplicate_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="diagnosis_list_duplicate_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="diagnosis_list_duplicate_modal_title">Diagnosis Deletion</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="diagnosis_list_duplicate_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="diagnosis_list_duplicate_yes" name="diagnosis_list_duplicate_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="diagnosis_list_duplicate_no" name="diagnosis_list_duplicate_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/diagnosis_search_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>
<!--<script>
	$(document).ready(function()
	{
		$('#diagnosis_list_search_modal_form').trigger('reset');
		$('#diagnosis_list_search').focus();
		$('#diagnosis_list_search_modal').modal('show');
	});
</script>-->