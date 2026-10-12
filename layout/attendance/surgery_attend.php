<?php
    $query = "SELECT * FROM surgery_list WHERE attend_id=$attend_id ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
?>
<hr class="d-none d-md-block">
<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingSix">
		<h6 class="panel-title">
			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
				<h5 class="m-0 font-weight-bold text-primary">Procedure/Surgery</h5>
			</a>
		</h6>
	</div>
	<div id="collapseSix" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingSix">
		<div class="panel-body">
			<div class="form-row">
				<div class="col-md-8 mb-8">
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" data-toggle="" id="surgery_add_icon"><i class="fas fa-procedures fa-lg"></i> Add Procedure/Surgery</a>
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" id="surgery_history_icon"><i class="fa fa-history fa-lg"></i> Past Procedure/Surgery</a>
				</div>
			</div>
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
									<a href="#" id="btn_anesthesia" data-id1="<?php echo $row['surgery_list_id'];?>"><i class="fas fa-file-medical-alt"></i></a>
									| 
									<a href="#" id="btn_opt_notes" data-id1="<?php echo $row['surgery_list_id'];?>"><i class="fas fa-file-medical"></i></a>
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
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="surgery_attend_modal" tabindex="-1" role="dialog" aria-labelledby="surgery_attend_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="surgery_attend_modal_title">Enter Procedure/Surgery</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="surgery_attend_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
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
								<textarea type="textarea" rows="4"  class="form-control" name="surgery_comment" id="surgery_comment" value=""></textarea>
									<input type="hidden" name="surgery_list_id" class="form-control" id="surgery_list_id" value="">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" id="surgery_attend_save_btn" class="btn btn-primary">Save</button>
				    <button type="submit" id="surgery_attend_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-xl" id="surgery_history_modal" tabindex="-1" role="dialog" aria-labelledby="surgery_history_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="surgery_history_modal_title">Procedure/Surgery History</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive" id="attend_surgery_history_table">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>