<?php
    $query = "SELECT * FROM nurses_notes WHERE attend_id=$attend_id ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
?>
<hr class="d-none d-md-block">
<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingEight">
		<h6 class="panel-title">
			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="true" aria-controls="collapseEight">
				<h5 class="m-0 font-weight-bold text-primary">Nurses Notes</h5>
			</a>
		</h6>
	</div>
	<div id="collapseEight" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingEight">
		<div class="panel-body">
			<div class="form-row">
				<div class="col-md-8 mb-8">
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" data-toggle="" id="nnotes_add_icon"><i class="fas fa-notes-medical fa-lg"></i> Add Nurses Note</a>
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" id="nnotes_history_icon"><i class="fa fa-history fa-lg"></i> Past Nurses Notes</a>
				</div>
			</div>
			<div class="table-responsive" id="attend-nnotes-table">
			    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
			        <thead>
			            <tr>
			                <th>Date</th>
			                <th>Initials</th>
			                <th>Nurses Notes</th>
			                <th>Edit</th>
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
			                    
			                    <td><a href="#"><?php echo $row['date'];?></a></td>
			                    <td><?php echo $row['lab'];?></td>
			                    <td><?php echo $row['comment'];?></td>
			                    <td><?php echo $row['comment'];?></td>
			                    <td>
									<a href="#" id="btn_edit_nnotes" data-id1="<?php echo $row['drug_list_id'];?>"><i class="fa fa-edit fa-sm"></i></a>
		                        </td>
		                        <td>
									<a href="#" id="btn_delete_nnotes" data-id2="<?php echo $row['drug_list_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
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
</div>

<div class="modal fade bd-example-modal-xl" id="nnotesmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="nnotesmodaltitle">Enter Nurses Notes</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="nnotes_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
							<div class="form-row">
								<div class="col-md-1 mb-1">
									<label for="noteinitials">Initials</label>
									<input type="text" class="form-control" name="noteinitials" id="noteinitials">
								</div>
								<div class="col-md-10 mb-10">
									<label for="nursenotedesc">Management Plan</label>
									<textarea type="textarea" rows="4"  class="form-control" name="nursenotedesc" id="nursenotedesc" value=""></textarea>
								</div>
							</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="nnotes_comment">Comment</label>
								<textarea type="textarea" rows="4"  class="form-control" name="nnotes_comment" id="nnotes_comment" value=""></textarea>
									<input type="hidden" name="nnotes_patient_id" class="form-control" id="nnotes_patient_id" value="<?php echo $patient_id;?>">
									<input type="hidden" name="nnotes_attend_id" class="form-control" id="nnotes_attend_id" value="<?php echo $attend_id;?>">
									<input type="hidden" name="nnotes_list_id" class="form-control" id="nnotes_list_id" value="">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" id="nnotes_save_btn" class="btn btn-primary">Save</button>
				    <button type="submit" id="nnotes_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
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
			<div class="table-responsive" id="attend-nnoteshistory-table">
			</div>
		</div>
	</div>
</div>