<?php
    $query = "SELECT * FROM diagnosis_list WHERE attend_id=$attend_id ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
?>
<hr class="d-none d-md-block">
<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingThree">
		<h6 class="panel-title">
			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
				<h5 class="m-0 font-weight-bold text-primary">Diagnosis</h5>
			</a>
		</h6>
	</div>
	<div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
		<div class="panel-body">
			<div class="form-row">
				<div class="col-md-8 mb-8">
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" data-toggle="" id="diagnosis_add_icon"><i class="fas fa-diagnoses fa-lg"></i> Add Diagnosis</a>
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" id="diagnosis_history_icon"><i class="fa fa-history fa-lg"></i> Past Diagnosis</a>
				</div>
			</div>
			<div class="table-responsive" id="attend-diagnosis-table">
			    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
			        <thead>
			            <tr>
			                <th>Date</th>
			                <th>Diagnosis</th>
			                <th>ICD 10</th>
			                <th>G-DRG</th>
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
			                    	$diagnosis_id = $row['diagnosis_id'];
			                    	$query = "SELECT * FROM diagnosis WHERE diagnosis_id=$diagnosis_id";
    								$query_run_diag = mysqli_query($con, $query);
    								$row_diag=mysqli_fetch_assoc($query_run_diag);
			            ?>	
			                <tr>
			                    
			                    <td>a href="#" id="btn_edit_diag" data-id1="<?php echo $row['diagnosis_list_id'];?>"><?php echo $row['date'];?></a></td>
			                    <td><?php echo $row_diag['diagnosis'];?></td>
			                    <td><?php echo $row_diag['icd_10'];?></td>
			                    <td><?php echo $row_diag['g_drg'];?></td>
			                    <td><?php echo $row['comment'];?></td>
		                        <td>
									<a href="#" id="btn_delete_diag" data-id2="<?php echo $row['diagnosis_list_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
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

<div class="modal fade bd-example-modal-xl" id="diagnosismodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="diagnosismodaltitle">Enter Diagnosis</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="diagnosis_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
								<div class="col-md-8 mb-8">
								<label for="diagnosis">Diagnosis</label>
								<select class="form-control" name="diagnosis" id="diagnosis"> 
						    	<option value="0">Please Select</option>
							        <?php
							        	$sql="SELECT * FROM diagnosis ORDER BY diagnosis ASC";
										$result=mysqli_query($con,$sql);
							            while($row=mysqli_fetch_array($result))
							            {
							            ?>
							            <option value = "<?php echo($row['diagnosis_id'])?>" >
							                <?php echo($row['diagnosis']) ?>
							            </option>
							            <?php
							            }               
							        ?>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="diag_icd10">ICD 10</label>
								<input type="text" class="form-control" name="diag_icd10" id="diag_icd10">
							</div>
							<div class="col-md-2 mb-2">
								<label for="diag_gdrg">G-DRG</label>
								<input type="text" class="form-control" name="diag_gdrg" id="diag_gdrg">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="diag_comment">Comment</label>
								<textarea type="textarea" rows="4"  class="form-control" name="diag_comment" id="diag_comment" value=""></textarea>
									<input type="hidden" name="diag_patient_id" class="form-control" id="diag_patient_id" value="<?php echo $patient_id;?>">
									<input type="hidden" name="diag_attend_id" class="form-control" id="diag_attend_id" value="<?php echo $attend_id;?>">
									<input type="hidden" name="diagnosis_list_id" class="form-control" id="diagnosis_list_id" value="">
									<input type="hidden" name="diag_qty" class="form-control" id="diag_qty" value="">
									<input type="hidden" name="diag_price" class="form-control" id="diag_price" value="<?php echo $patient_id;?>">
									<input type="hidden" name="diag_amount" class="form-control" id="diag_amount" value="<?php echo $attend_id;?>">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" id="diag_save_btn" class="btn btn-primary">Save</button>
				    <button type="submit" id="diag_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-xl" id="diagnosis_history_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary">Diagnosis History</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="table-responsive" id="attend-diagnosishistory-table">
			</div>
		</div>
	</div>
</div>