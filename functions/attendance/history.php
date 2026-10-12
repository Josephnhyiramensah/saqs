<?php
    
    $query = "SELECT * FROM history WHERE attend_id=$attend_id ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
?>
<hr class="d-none d-md-block">
<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingOne">
		<h6 class="panel-title">
			<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				<h5 class="m-0 font-weight-bold text-primary">History/Examination</h5>
			</a>
		</h6>
	</div>
	<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
		<div class="panel-body">
			<div class="form-row">
				<div class="col-md-8 mb-8">
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" id="add_history_icon" data-toggle="modal"><i class="fas fa-file-medical-alt fa-lg"></i> Add History</a>
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" id="past_history_icon"><i class="fa fa-history fa-lg"></i> Past History</a>
				</div>
			</div>
			<div class="table-responsive" id="attend-history-table">
			    <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
			        <thead>
			            <tr>
			                <th>Date</th>
			                <th>History</th>
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
			                    <td><a href="#" id="btn_edit_history" data-id="<?php echo $row['history_id'];?>"><?php echo $row['date'];?></a></td>
			                    <td><?php echo $row['history'];?></td>
			                    <td>
									<a href="#" id="btn_delete_history" data-id1="<?php echo $row['history_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
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

<div class="modal fade bd-example-modal-xl" id="historymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="historymodaltitle">Enter History</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="add_history_form" method="POST">
				<div class="modal-body">
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="history">History</label>
							<textarea type="textarea" rows="4"  class="form-control" name="history" id="history" value=""></textarea>
							<input type='hidden' id='history_id'>
							<input type='hidden' id='history_attend_id'>
							<input type='hidden' id='history_patient_id'>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" id="history_save_btn" class="btn btn-primary">Save</button>
				    <button type="button" id="history_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-xl" id="pasthistorymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary">Past History</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="table-responsive" id="attend-pasthistory-table">
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