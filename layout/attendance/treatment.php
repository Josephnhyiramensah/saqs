<?php
    $query = "SELECT * FROM management_plan WHERE attend_id=$attend_id ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
?>
<hr class="d-none d-md-block">
<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingSeven">
		<h6 class="panel-title">
			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
				<h5 class="m-0 font-weight-bold text-primary">Management Plan</h5>
			</a>
		</h6>
	</div>
	<div id="collapseSeven" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingSeven">
		<div class="panel-body">
			<div class="form-row">
				<div class="col-md-8 mb-8">
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" data-toggle="" id="mgtplan_add_icon"><i class="fas fa-file-medical fa-lg"></i> Add Mgt Plan</a>
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" id="mgtplan_history_icon"><i class="fa fa-history fa-lg"></i> Past Mgt Plan</a>
				</div>
			</div>
			<div class="table-responsive" id="attend-mgtplan-table">
			    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
			        <thead>
			            <tr>
			                <th>Date</th>
			                <th>Initials</th>
			                <th>Management Plan</th>
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
									<a href="#" id="btn_edit_mgtplan" data-id1="<?php echo $row['drug_list_id'];?>"><i class="fa fa-edit fa-sm"></i></a>
		                        </td>
		                        <td>
									<a href="#" id="btn_delete_mgtplan" data-id2="<?php echo $row['drug_list_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
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

<div class="modal fade bd-example-modal-xl" id="mgtplanmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="mgtplanmodaltitle">Enter Management Plan</h5>
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
								<label for="mgtplan_comment">Comment</label>
								<textarea type="textarea" rows="4"  class="form-control" name="mgtplan_comment" id="mgtplan_comment" value=""></textarea>
									<input type="hidden" name="mgtplan_patient_id" class="form-control" id="mgtplan_patient_id" value="<?php echo $patient_id;?>">
									<input type="hidden" name="mgtplan_attend_id" class="form-control" id="mgtplan_attend_id" value="<?php echo $attend_id;?>">
									<input type="hidden" name="mgtplan_list_id" class="form-control" id="mgtplan_list_id" value="">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" id="mgtplan_save_btn" class="btn btn-primary">Save</button>
				    <button type="submit" id="mgtplan_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
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
			<div class="table-responsive" id="attend-mgtplanhistory-table">
			</div>
		</div>
	</div>
</div>