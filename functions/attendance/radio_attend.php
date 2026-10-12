<?php
    $query = "SELECT * FROM radio_list WHERE attend_id='$attend_id' ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
?>

<hr class="d-none d-md-block">
<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="radio_attend_heading">
		<h6 class="panel-title">
			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_radio_attend" aria-expanded="true" aria-controls="collapse_radio_attend">
				<h5 class="m-0 font-weight-bold text-primary">Radiology</h5>
			</a>
		</h6>
	</div>
	<div id="collapse_radio_attend" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="radio_attend_heading">
		<div class="panel-body">
			<div class="form-row">
				<div class="col-md-6 mb-6">
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" data-toggle="" id="radio_attend_add_icon"><i class="fas fa-x-ray fa-lg"></i> Add Lab Test</a>
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" id="radio_attend_history_icon"><i class="fa fa-history fa-lg"></i> Past Labs</a>
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" id="radio_attend_report_icon"><i class="fa fa-file fa-lg"></i> Lab Report</a>
				</div>
			</div>
			<div class="table-responsive" id="attend_radio_table">
			    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
			        <thead>
			            <tr>
			                <th>Date</th>
			                <th>ID</th>
			                <th>Radiology</th>
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
			                    	$radio_id = $row['radio_id'];
			                    	$query_radio = "SELECT radiology FROM radiology WHERE radio_id='$radio_id'";
    								$query_run_radio = mysqli_query($con, $query_radio);
    								$row_radio=mysqli_fetch_assoc($query_run_radio);
			            ?>
			                <tr>
			                    <td><a href="#" id="btn_edit_radio_attend" 
										data-id12="<?php echo $row['radio_list_id'];?>"
			                			data-id13="<?php echo $row['radio_id'];?>" 
									><?php echo $row['date'];?></a></td>
			                    <td><?php echo $row['radio_id'];?></td>
			                    <td><?php echo $row_radio['radiology'];?></td>
			                    <td>
			                    	<?php
			                    		$query_param = "SELECT radio_param_list_id FROM radio_param_list WHERE radio_id='$radio_id' AND attend_id='$attend_id'";
    									$query_run_param = mysqli_query($con, $query_param);
    									if (mysqli_num_rows($query_run_param) > 0)
			                				{
			                					$row_param=mysqli_fetch_assoc($query_run_param);
			                		?>
			                			<a href="#" id="btn_radio_result_view" 
			                				data-id="<?php echo $row['radio_list_id'];?>"
			                				data-id1="<?php echo $row['radio_id'];?>" 
			                			>
			                				<i class="fa fa-clipboard-list fa-sm"></i>
			                			</a>
			                		<?php
			                				}
						                else
							                {
							         ?>
							         	<a href="#" id="btn_radio_result_enter" 
							         		data-id4="<?php echo $row['radio_list_id'];?>"
			                				data-id5="<?php echo $row['radio_id'];?>" 
							         	>
							         		<i class="fa fa-plus-square fa-sm"></i>
							         	</a>
							         <?php
							                };
			                    	?>
		                        </td>
		                        <td>
									<a href="#" id="btn_delete_radio_attend" 
										data-id8="<?php echo $row['radio_list_id'];?>"
			                			data-id9="<?php echo $row['radio_id'];?>" 
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

<div class="modal fade bd-example-modal-lg" id="radio_attend_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="radioattendmodaltitle">Enter Radiology Item</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="radio_attend_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="radio_id">Radiology Item</label>
								<select class="form-control" name="radio_id" id="radio_id"> 
							    	<option value="0">Please Select</option>
							        <?php
							        	$sql="SELECT * FROM radiology ORDER BY radiology ASC";
										$result=mysqli_query($con,$sql);
							            while($row=mysqli_fetch_array($result))
							            {
							            ?>
							            <option value = "<?php echo($row['radio_id'])?>" >
							                <?php echo($row['radiology']) ?>
							            </option>
							            <?php
							            }               
							        ?>
							    </select>
								<input type="hidden" name="radio_attend_id" class="form-control" id="radio_attend_id" value="<?php echo $attend_id;?>">
								<input type="hidden" name="radio_patient_id" class="form-control" id="radio_patient_id" value="<?php echo $patient_id;?>">
								<input type="hidden" name="radio_list_id" class="form-control" id="radio_list_id" value="">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="radio_comment">Comment</label>
								<textarea type="textarea" rows="4"  class="form-control" name="radio_comment" id="radio_comment" value=""></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" name="radio_list_save_btn" id="radio_list_save_btn" class="btn btn-primary">Save</button>
				    <button type="submit" name="radio_list_update_btn" id="radio_list_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="radio_attend_result_enter_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="radio_attend_result_enter_modal_title">Enter Radiology Result</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="radio_attend_result_enter_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="table-responsive" id="radio_attend_result_enter_table">
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" name="radio_attend_result_enter_save_btn" id="radio_attend_result_enter_save_btn" class="btn btn-primary">Save</button>
				    <button type="button" name="radio_attend_result_enter_cancel_btn" id="radio_attend_result_enter_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="radio_attend_result_view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="radio_attend_result_view_modal_title">Radiology Result</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="radio_attend_result_view_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="table-responsive" id="radio_attend_result_view_table">
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="button" name="radio_attend_result_view_cancel_btn" id="radio_attend_result_view_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="radio_attend_report_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
					<h3 class="modal-title m-0 font-weight-bold text-primary" id="radio_attend_report_modal_title">Medical Report</h3>
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
				<div class="table-responsive" id="radio_attend_report_table">
				</div>
      		</div>
      		<div class="modal-footer">
      			<button type="submit" name="radio_report_print_btn" id="radio_report_print_btn" class="btn btn-primary">Print</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="radio_history_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title m-0 font-weight-bold text-primary" id="radio_history_modal_title">Radiology History</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="radio_history_list">
					
				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" name="radio_history_cancel_btn" id="radio_history_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-md" id="radio_edit_decline_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title m-0 font-weight-bold text-primary" id="radio_edit_decline_modal_title">Radiolody Edit Declined!</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="radio_edit_decline_info">
					
				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" name="radio_edit_decline_cancel_btn" id="radio_edit_decline_cancel_btn" class="btn btn-secondary" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>

