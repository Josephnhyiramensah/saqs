<div 
class="modal fade bd-example-modal-xl" 
id="stock_sales_invoice_lab_list_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_sales_invoice_lab_list_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_sales_invoice_lab_list_modal_title">Lab</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<form id="stock_sales_invoice_lab_form" method="POST">
					<div class="form-row">
						<div class="col-md-8 mb-8">
							<label for="lab_id">Lab Test (<a href="#" id="btn_lab_live_search">Click to add Lab</a>)</label>
								<select class="form-control" name="lab_id" id="lab_id"> 
									<option value="0">Please Select</option>
								<?php
									$sql="SELECT * FROM lab ORDER BY lab ASC";
									$result=mysqli_query($con,$sql);
									while($row=mysqli_fetch_array($result))
									{
										echo'<option value = "'.$row['lab_id'].'">'.$row['lab'].'</option>';
									};
								?>
								</select>
								<input type="hidden" name="lab_list_id" class="form-control" id="lab_list_id">
								<input type="hidden" name="lab_qty" class="form-control" id="lab_qty" value="1">
						</div>
						<div class="col-md-4 mb-4">
							<label for="lab_date">Date</label>
								<input type="date" name="lab_date" class="form-control" id="lab_date" value="'.$date.'">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-10 mb-10">
							<label for="lab_comment">Comment</label>
							<textarea type="textarea" rows="2"  class="form-control" name="lab_comment" id="lab_comment" value=""></textarea>
						</div>
						<div class="col-md-2 mb-2">
							<label for="lab_print_status">Print?</label>
							<select class="form-control" name="lab_print_status" id="lab_print_status"> 
								<option value="0">Please Select</option>
								<option value="Yes" selected="selected">Yes</option>
								<option value="No">No</option>
							</select>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="stock_sales_invoice_lab_list_save_btn" class="btn btn-primary">Save</button>
				<button type="button" id="stock_sales_invoice_lab_list_update_btn" class="btn btn-primary">Update</button>
			    <button type="button" id="stock_sales_invoice_lab_list_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
			<div class="table-responsive" id="sales_invoice_lab_table">
				<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th class="action-td">Date</th>
							<th class="action-td">Lab Test</th>
							<th class="action-td">Print?</th>
							<th class="action-td">Action</th>
						</tr>
					</thead>
					<tbody class="pv-table-body">
						<?php
							$stock_sales_id = $_SESSION['stock_sales_id'];
							$query = "SELECT * FROM lab_list WHERE stock_sales_id ='$stock_sales_id' ORDER BY date DESC";
							$query_run = mysqli_query($con, $query);
							if (mysqli_num_rows($query_run) > 0)
							{
								while($row = mysqli_fetch_assoc($query_run))
								{
									$lab_list_id = $row['lab_list_id'];
									$lab_id = $row['lab_id'];
									$query_lab = "SELECT lab FROM lab WHERE lab_id='$lab_id'";
									$query_run_lab = mysqli_query($con, $query_lab);
									$row_lab=mysqli_fetch_assoc($query_run_lab);
									?>

									<tr id="<?php echo $lab_list_id;?>">
										<td class="action-td">
											<a href="#" id="btn_lab_doc_view" 
													data-id="<?php echo $row['lab_list_id'];?>"
													data-id1="<?php echo $row['lab_id'];?>" 
												><?php echo $row['date'];?></a>
										</td>
										<td><a href="#" id="btn_lab_doc_view" 
													data-id="<?php echo $row['lab_list_id'];?>"
													data-id1="<?php echo $row['lab_id'];?>" 
												><?php echo $row_lab['lab'];?></a>
										</td>

										<?php

										$print_status = $row['print_status'];
										echo '<td class="action-td">
													<select class="form-control lab_print" name="lab_print" id="lab_print'.$lab_list_id.'">';
													if($print_status == '')
													{
														echo'<option value="0">Please Select</option>
																<option value="Yes">Yes</option>
																<option value="No" selected="selected">No</option>';
													}
													elseif($print_status == 'Yes')
													{
														echo'<option value="0">Please Select</option>
																<option value="Yes" selected="selected">Yes</option>
																<option value="No">No</option>';
													}
													elseif($print_status == 'No')
													{
														echo'<option value="0">Please Select</option>
																<option value="Yes">Yes</option>
																<option value="No" selected="selected">No</option>';
													}
											echo '</select>
											</td>
											<td class="action-td">';

												$query_img = "SELECT lab_img_id FROM lab_img WHERE lab_list_id='$lab_list_id'";
												$query_run_img = mysqli_query($con, $query_img);
												$row_imgs=mysqli_num_rows($query_run_img);

												$query_param = "SELECT lab_param_list_id FROM lab_param_list WHERE lab_id='$lab_id' AND stock_sales_id ='$stock_sales_id' AND lab_list_id='$lab_list_id'";
												$query_run_param = mysqli_query($con, $query_param);
												if (mysqli_num_rows($query_run_param) > 0)
												{
													$row_param = mysqli_fetch_assoc($query_run_param);

													/*if (
														$_SESSION['user_type'] == 'Ultra_Super_User' OR 
														$_SESSION['user_type'] == 'Super_User' OR 
														($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Lab_Result'] == 'Yes')) 
														{*/
															echo ' | <a href="#" id="btn_lab_perform_edit" 
																data-id="'.$row['lab_list_id'].'"
																data-id1="'.$row['lab_id'].'" 
																class="data-toggle="tooltip" data-placement="left" title="Edit Lab Result""
															>
																Edit Result
															</a>';
														//};

													/*if (
														$_SESSION['user_type'] == 'Ultra_Super_User' OR 
														$_SESSION['user_type'] == 'Super_User' OR 
														($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Lab_Result'] == 'Yes')) 
														{*/
															echo ' | <a href="#" id="btn_lab_result_view" 
																	data-id="'.$row['lab_list_id'].'"
																	data-id1="'.$row['lab_id'].'" 
																	class="data-toggle="tooltip" data-placement="left" title="View Lab Result""
																>
																	View Result
																</a>';
														//};

													/*if (
														$_SESSION['user_type'] == 'Ultra_Super_User' OR 
														$_SESSION['user_type'] == 'Super_User' OR 
														($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Upload_Lab_Result_Image'] == 'Yes')) 
														{*/
															echo ' | 
																<a href="#" id="btn_lab_img_upload" data-id6="'.$row['lab_list_id'].'"
																	data-id7="'.$row['lab_id'].'"
																	class="data-toggle="tooltip" data-placement="left" title="Upload Lab Result Image"">
																	Upload Image
																	</a>';
														//};
										
													if ($row_imgs > 0)
														{
											
															/*if (
																$_SESSION['user_type'] == 'Ultra_Super_User' OR 
																$_SESSION['user_type'] == 'Super_User' OR 
																($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Uploaded_Lab_Result_Image'] == 'Yes')) 
															{*/
																echo ' | 
																<a href="#" id="btn_lab_img_view" 
																data-id2="'.$row['lab_list_id'].'"
																data-id3="'.$row['lab_id'].'"
																class="data-toggle="tooltip" data-placement="left" title="View Uploaded Lab Result Image"">
																View Image
																</a>';
															//};
														};
												}
												else
												{
													
													if ($_SESSION['user_id'] == $row['user_id']) 
													{
														if($row['date'] == $date_today)
														{
															
															/*if (
																$_SESSION['user_type'] == 'Ultra_Super_User' OR 
																$_SESSION['user_type'] == 'Super_User' OR 
																($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Lab_List'] == 'Yes')) 
															{*/
																echo '<a href="#" id="btn_lab_edit" 
																		data-id12="'.$row['lab_list_id'].'"
																		data-id13="'.$row['lab_id'].'" 
																	>Edit Lab Item</a>';
															//};
														};
													};

													/*if (
														$_SESSION['user_type'] == 'Ultra_Super_User' OR 
														$_SESSION['user_type'] == 'Super_User' OR 
														($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Enter_Lab_Result_Internal'] == 'Yes')) 
														{*/
															echo ' | <a href="#" id="btn_lab_perform_enter" 
															data-id="'.$row['ledger_id'].'"
															data-id4="'.$row['lab_list_id'].'"
															data-id5="'.$row['lab_id'].'" 
															class="data-toggle="tooltip" data-placement="left" title="Enter Lab Result"">
															Enter Result
															</a>';
														//};

													/*if (
														$_SESSION['user_type'] == 'Ultra_Super_User' OR 
														$_SESSION['user_type'] == 'Super_User' OR 
														($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Enter_Lab_Result_External'] == 'Yes')) 
														{*/
															echo' | 
															<a href="#" id="btn_lab_result_enter" 
																data-id4="'.$row['lab_list_id'].'"
																data-id5="'.$row['lab_id'].'" 
																class="data-toggle="tooltip" data-placement="left" title="Enter External Lab Result"">
																Enter Ext. Result
															</a>';
														//};

													/*if (
														$_SESSION['user_type'] == 'Ultra_Super_User' OR 
														$_SESSION['user_type'] == 'Super_User' OR 
														($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Upload_Lab_Result_Image'] == 'Yes')) 
														{*/
															echo' | 
															<a href="#" id="btn_lab_img_upload" data-id6="'.$row['lab_list_id'].'"
																data-id7="'.$row['lab_id'].'"
																class="data-toggle="tooltip" data-placement="left" title="Upload Lab Result Image"">
																Upload Image
																</a>';
														//};

													if ($row_imgs > 0)
														{
															/*if (
																$_SESSION['user_type'] == 'Ultra_Super_User' OR 
																$_SESSION['user_type'] == 'Super_User' OR 
																($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Uploaded_Lab_Result_Image'] == 'Yes')) 
															{*/
																echo' | 
																	<a href="#" id="btn_lab_img_view" data-id2="'.$row['lab_list_id'].'"
																	data-id3="'.$row['lab_id'].'"
																	class="data-toggle="tooltip" data-placement="left" title="View Uploaded Lab Result Image"">
																	View Image
																	</a>';
															//};
														};
												};
												/*if (
													$_SESSION['user_type'] == 'Ultra_Super_User' OR 
													$_SESSION['user_type'] == 'Super_User' OR 
													($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Discount'] == 'Yes')) 
													{*/
														echo' |
															<a href="#" id="btn_discount_lab_attend" 
																data-id="'.$row['lab_list_id'].'"
																data-id1="'.$stock_sales_id.'" 
																class="data-toggle="tooltip" data-placement="left" title="Discount Lab Test""
															>
																Disc.
															</a>';
													//};
												
													if ($_SESSION['user_id'] == $row['user_id']) 
													{
														if($row['date'] == $date_today)
														{
															/*if (
																$_SESSION['user_type'] == 'Ultra_Super_User' OR 
																$_SESSION['user_type'] == 'Super_User' OR 
																($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Lab_List'] == 'Yes')) 
															{*/
																echo' |
																<a href="#" id="btn_delete_lab_attend" 
																	data-id8="'.$row['lab_list_id'].'"
																	data-id9="'.$row['lab_id'].'" 
																	class="data-toggle="tooltip" data-placement="left" title="Delete Lab Test""
																>
																	Delete
																</a>';
															//};
														};
													};
						
										echo'</td>
									</tr>';
								};
							};
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>