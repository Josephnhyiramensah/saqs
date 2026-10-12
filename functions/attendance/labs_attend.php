<?php
    $query = "SELECT * FROM lab_list WHERE attend_id='$attend_id' ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
?>

<hr class="d-none d-md-block">
<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="lab_attend_heading">
		<h6 class="panel-title">
			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_lab_attend" aria-expanded="true" aria-controls="collapse_lab_attend">
				<h5 class="m-0 font-weight-bold text-primary">Labs</h5>
			</a>
		</h6>
	</div>
	<div id="collapse_lab_attend" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="lab_attend_heading">
		<div class="panel-body">
			<div class="form-row">
				<div class="col-md-6 mb-6">
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" data-toggle="" id="lab_attend_add_icon"><i class="fas fa-flask fa-lg"></i> Add Lab Test</a>
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" id="lab_attend_history_icon"><i class="fa fa-history fa-lg"></i> Past Labs</a>
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" id="lab_attend_report_icon"><i class="fa fa-file fa-lg"></i> Lab Report</a>
				</div>
			</div>
			<div class="table-responsive" id="attend-lab-table">
			    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
			        <thead>
			            <tr>
			                <th>Date</th>
			                <th>Lab ID</th>
			                <th>Lab Test</th>
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
			                    	$lab_id = $row['lab_id'];
			                    	$query_lab = "SELECT lab FROM lab WHERE lab_id='$lab_id'";
    								$query_run_lab = mysqli_query($con, $query_lab);
    								$row_lab=mysqli_fetch_assoc($query_run_lab);
			            ?>

			                <tr>
			                    <td><a href="#" id="btn_lab_edit" 
			                				data-id12="<?php echo $row['lab_list_id'];?>"
			                				data-id13="<?php echo $row['lab_id'];?>" 
			                			><?php echo $row['date'];?></a></td>
			                    <td><?php echo $row['lab_id'];?></td>
			                    <td><?php echo $row_lab['lab'];?></td>
			                    <td>
			                    	<?php
			                    		$lab_list_id = $row['lab_list_id'];
			                    		$query_img = "SELECT lab_img_id FROM lab_img WHERE lab_list_id='$lab_list_id'";
    									$query_run_img = mysqli_query($con, $query_img);
    									$row_imgs=mysqli_num_rows($query_run_img);

			                    		$query_param = "SELECT lab_param_list_id FROM lab_param_list WHERE lab_id='$lab_id' AND attend_id='$attend_id'";
    									$query_run_param = mysqli_query($con, $query_param);
    									if (mysqli_num_rows($query_run_param) > 0)
			                				{
			                					$row_param=mysqli_fetch_assoc($query_run_param);
			                		?>
			                			<a href="#" id="btn_lab_result_view" 
			                				data-id="<?php echo $row['lab_list_id'];?>"
			                				data-id1="<?php echo $row['lab_id'];?>" 
			                			>
			                				<i class="fa fa-clipboard-list fa-sm"></i>
			                			</a> | 
			                			
			                		<?php
			                			if ($row_imgs > 0)
			                				{
			                		?>
			                					<a href="#" id="btn_lab_img_view" 
			                					data-id2="<?php echo $row['lab_list_id'];?>"
			                					data-id3="<?php echo $row['lab_id'];?>">
					                			<i class="fas fa-file-image"></i>
					                			</a>
					                <?php
			                				}
			                				else
			                				{
			                		?>
			                					<a href="#" id="btn_lab_img_upload" data-id6="<?php echo $row['lab_list_id'];?>"
			                					data-id7="<?php echo $row['lab_id'];?>">
					                			<i class="fas fa-file-upload"></i>
					                			</a>
			                		<?php
			                				}
			                				}
						                else
							                {
							         ?>
							         	<a href="#" id="btn_lab_result_enter" 
							         		data-id4="<?php echo $row['lab_list_id'];?>"
			                				data-id5="<?php echo $row['lab_id'];?>" 
							         	>
							         		<i class="fa fa-plus-square fa-sm"></i>
							         	</a> | 
			                		<?php
			                			if ($row_imgs > 0)
			                				{
			                		?>
			                					<a href="#" id="btn_lab_img_view" data-id2="<?php echo $row['lab_list_id'];?>"
			                					data-id3="<?php echo $row['lab_id'];?>">
					                			<i class="fas fa-file-image"></i>
					                			</a>
					                <?php
			                				}
			                				else
			                				{
			                		?>
			                					<a href="#" id="btn_lab_img_upload" data-id6="<?php echo $row['lab_list_id'];?>"
			                					data-id7="<?php echo $row['lab_id'];?>">
					                			<i class="fas fa-file-upload"></i>
					                			</a>
			                		<?php
			                				}
							                };
			                    	?>
		                        </td>
		                        <td>
									<a href="#" id="btn_delete_lab_attend" 
										data-id8="<?php echo $row['lab_list_id'];?>"
			                			data-id9="<?php echo $row['lab_id'];?>" 
									>
										<i class="fa fa-trash fa-sm"></i>
									</a>
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

<div class="modal fade bd-example-modal-lg" id="labs_attend_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="labsattendmodaltitle">Enter Lab Test</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="labs_attend_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="lab_id">Lab Test</label>
									<select class="form-control" name="lab_id" id="lab_id"> 
								    	<option value="0">Please Select</option>
								        <?php
								        	$sql="SELECT * FROM lab ORDER BY lab ASC";
											$result=mysqli_query($con,$sql);
								            while($row=mysqli_fetch_array($result))
								            {
								            ?>
								            <option value = "<?php echo($row['lab_id'])?>" >
								                <?php echo($row['lab']) ?>
								            </option>
								            <?php
								            }               
								        ?>
								    </select>
									<input type="hidden" name="lab_attend_id" class="form-control" id="lab_attend_id" value="<?php echo $attend_id;?>">
									<input type="hidden" name="lab_patient_id" class="form-control" id="lab_patient_id" value="<?php echo $patient_id;?>">
									<input type="hidden" name="lab_list_id" class="form-control" id="lab_list_id">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="lab_comment">Comment</label>
								<textarea type="textarea" rows="4"  class="form-control" name="lab_comment" id="lab_comment" value=""></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" name="lab_list_save_btn" id="lab_list_save_btn" class="btn btn-primary">Save</button>
				    <button type="submit" name="lab_list_update_btn" id="lab_list_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="labs_attend_result_enter_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="labs_attend_result_enter_modal_title">Enter Lab Test Result</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="labs_attend_result_enter_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="table-responsive" id="labs_attend_result_enter_table">
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" name="labs_attend_result_enter_save_btn" id="labs_attend_result_enter_save_btn" class="btn btn-primary">Save</button>
				    <button type="button" name="labs_attend_result_enter_cancel_btn" id="labs_attend_result_enter_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="labs_attend_result_view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="labs_attend_result_view_modal_title">Lab Test Result</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="labs_attend_result_view_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="table-responsive" id="labs_attend_result_view_table">
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="button" name="labs_attend_result_view_cancel_btn" id="labs_attend_result_view_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="labs_attend_report_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
					<h3 class="modal-title m-0 font-weight-bold text-primary" id="labs_attend_report_modal_title">Medical Laboratory Report</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive no-padding">
		        	<table width="100%" cellpadding="3" cellspacing="3">
			            <tr>
			            	<td width="15%" valign="top" align="center">
				                <?php
								/*if(!$patientInfo->picture){
									$picture = "avatar.png";	
								}else{
									$picture = $patientInfo->picture;
								}*/
								?>
								<img src="/img/patients/patient_image.jpg" class="img-rounded" width="100" height="100">
			                </td>
			                <td>
			                	<table id="attend_patient_table" width="100%">
				                    <tr>
				                    	<td colspan="5"><h4><strong><?php echo $name;?></strong></h4></td>
				                    </tr>
				                    <tr>
				                    	<tr>
				                    	<td><small><u>Patient No:</u><?php echo $patient_id;?></small></td>
				                    	<td><small><u>Folder No:</u><?php echo $folderno;?></small></td>
				                    	<td><small><u>Date of Birth:</u></small></td>
				                    	<td><small><u>Age:</u><?php echo $age;?></small></td>
				                    	<td><small><u>Gender:</u><?php echo $gender?></small></td>
				                    </tr>
				                    <tr>
				                    	<td><small><u>Attendance ID:</u><?php echo $attend_id;?></small></td>
				            			<td><small><u>Date of Admission:</u><?php echo $dateofadmission_attd;?></small></td>
				            			<td><small><u>Date of Discharge:</u><?php echo $dateofdischarge_attd;?></small></td>
				            			<td><small><u>Type of Service:</u><?php echo $typeofservice_attd;?></small></td>
				            			<td><small><u>Clinic:</u><?php echo $clinic;?></small></td>
				            		</tr>
			                    </table>
			                </td>
			            </tr>
		            </table>
	        	</div>
				<div class="table-responsive" id="labs_attend_report_table">
				</div>
      		</div>
      		<div class="modal-footer">
      			<button type="submit" name="lab_report_print_btn" id="lab_report_print_btn" class="btn btn-primary">Print</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="lab_history_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title m-0 font-weight-bold text-primary" id="lab_history_modal_title">Lab History</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="lab_history_list">
					
				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" name="lab_history_cancel_btn" id="lab_history_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-md" id="lab_edit_decline_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title m-0 font-weight-bold text-primary" id="lab_edit_decline_modal_title">Lab Edit Declined!</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="lab_edit_decline_info">
					
				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" name="lab_edit_decline_cancel_btn" id="lab_edit_decline_cancel_btn" class="btn btn-secondary" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-lg" id="labs_img_upload_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="labs_img_upload_modal_title">Upload Lab Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="labs_img_upload_form" method="POST" action="" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="lab_id">Lab Test</label>
									<input type="hidden" name="file_size" class="form-control" id="file_size" value="1000000">
									<input type="file" name="lab_file_upload_id" class="form-control" id="lab_file_upload_id">
									<input type="hidden" name="lab_list_id_img" class="form-control" id="lab_list_id_img">
									<input type="hidden" name="lab_id_img" class="form-control" id="lab_id_img">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="lab_img_comment">Comment</label>
								<textarea type="textarea" rows="4"  class="form-control" name="lab_img_comment" id="lab_img_comment" value=""></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" name="lab_list_img_save_btn" id="lab_list_img_save_btn" class="btn btn-primary">Save</button>
				    <button type="submit" name="lab_list_img_update_btn" id="lab_list_img_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>