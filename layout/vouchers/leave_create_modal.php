<div 
class="modal fade hide bd-example-modal-xl" 
id="leave_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="leave_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="leave_create_modal_header">Leave Creation</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="leave_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="leave_employee">Employee</label>
								<select class="form-control bg-light" name="leave_employee" id="leave_employee"> 
									<option value="0">Please Select</option>
									<?php
										$sql="SELECT * FROM payroll_employee WHERE company_id = '$company_id' AND location = '$branch_id' 
										AND status = 'Active' ORDER BY first_name ASC";
										$result = mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value = "'.$row['employee_id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
										};
									?>
								</select>
	                        </div>
	                	</div>
	                    <div class="form-row">
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="leave_date_proposed">Proposed Date</label>
	                            <input type="hidden" name="leave_id" class="form-control bg-light" id="leave_id">
	                            <input type="date" class="form-control bg-light" name="leave_date_proposed" id="leave_date_proposed" value="<?php echo $date_today;?>">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="start_date_proposed">Proposed Start Date</label>
	                            <input type="date" class="form-control bg-light" name="start_date_proposed" id="start_date_proposed">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="end_date_proposed">Proposed End Date</label>
	                            <input type="date" name="end_date_proposed" class="form-control bg-light" id="end_date_proposed">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="leave_date">Actual Date</label>
	                            <input type="date" class="form-control bg-light" name="leave_date" id="leave_date">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="start_date">Actual Start Date</label>
	                            <input type="date" class="form-control bg-light" name="start_date" id="start_date">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="end_date">Actual End Date</label>
	                            <input type="date" name="end_date" class="form-control bg-light" id="end_date">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
								<table class="table table-hover table-bordered table-sm" id="leaveTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th class="action-td">Description</th>
											<th class="action-td">Annual Leave</th>
											<th class="action-td">Sick Leave</th>
											<th class="action-td">Maternity Leave</th>
										</tr>
									</thead>
									<tbody class="pv-table-body">
										<tr style="color:black;">
											<th>
												Requested
											</th>
											<td class="action-td">
												<input type="text" class="form-control bg-light text-center" name="requested_annual" id="requested_annual">
											</td>
											<td class="action-td">
												<input type="text" name="requested_sick" class="form-control bg-light text-center" id="requested_sick">
											</td> 
											<td class="action-td">
												<input type="text" name="requested_maternity" class="form-control bg-light text-center" id="requested_maternity">
											</td> 
										</tr>
										<tr style="color:black;">
											<th>
												Approved
											</th>
											<td class="action-td">
												<input type="text" class="form-control bg-light text-center" name="leave_annual" id="leave_annual" hidden="true">
												<input type="text" class="form-control bg-light text-center" name="leave_annualD" id="leave_annualD" disabled="true">
											</td>
											<td class="action-td">
												<input type="text" name="leave_sick" class="form-control bg-light text-center" id="leave_sick" hidden="true">
												<input type="text" name="leave_sickD" class="form-control bg-light text-center" id="leave_sickD" disabled="true">
											</td> 
											<td class="action-td">
												<input type="text" name="leave_maternity" class="form-control bg-light text-center" id="leave_maternity" hidden="true">
												<input type="text" name="leave_maternityD" class="form-control bg-light text-center" id="leave_maternityD" disabled="true">
											</td> 
										</tr>
										<tr style="color:black;">
											<th>
												Outcome
											</th>
											<td class="action-td">
												<select class="form-control bg-light" name="leave_outcome" id="leave_outcome"> 
													<option value="0">Please Select</option>
													<option value="Spent">Spent</option>
													<option value="Paid">Paid</option>
												</select>
											</td>
											<td class="action-td"></td> 
											<td class="action-td"></td> 
										</tr>
									</tbody>
								</table>
							</div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="leave_narration">Narration</label>
	                            <textarea type="text" class="form-control bg-light" name="leave_narration" id="leave_narration" rows="2"></textarea>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-6 mb-6 form-group">
	                            <label for="leave_authorised_by">Authorised By</label>
	                            <select class="form-control bg-light" name="leave_authorised_by" id="leave_authorised_by"> 
	                                <option value="0">Please Select</option>
	                                <?php
	                                	$user_id = $_SESSION['user_id'];
	                                    $sql="SELECT * FROM users  WHERE company_id = '$company_id' AND user_status='Accepted'";
	                                    $result=mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											if($user_id == $row['id'])
											{
												echo '<option value = "'.$row['id'].'" selected="selected">'.$row['first_name'].''.$row['last_name'].'</option>';
											}
											else
											{
												echo '<option value = "'.$row['id'].'">'.$row['first_name'].''.$row['last_name'].'</option>';
											};
										}
	                                ?>
	                            </select>
	                        </div>
	                        <div class="col-md-6 mb-6 form-group">
	                            <label for="leave_approved_by">Approved By</label>
	                            <select class="form-control bg-light" name="leave_approved_by" id="leave_approved_by"> 
	                                <option value="0">Please Select</option>
	                                <?php
	                                    $sql="SELECT * FROM users  WHERE company_id = '$company_id' AND user_status='Accepted'";
	                                    $result=mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value = "'.$row['id'].'">'.$row['first_name'].''.$row['last_name'].'</option>';
										};
	                                ?>
	                            </select>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-6 mb-6 form-group">
	                            <label for="authorised_comment">Comment (Authorised)</label>
	                            <textarea type="text" class="form-control bg-light" name="authorised_comment" id="authorised_comment" rows="3" hidden="true"></textarea>
	                            <textarea type="text" class="form-control bg-light" name="authorised_commentD" id="authorised_commentD" rows="3" disabled="true"></textarea>
	                        </div>
	                        <div class="col-md-6 mb-6 form-group">
	                            <label for="approved_comment">Comment (Approved)</label>
	                            <textarea type="text" class="form-control bg-light" name="approved_comment" id="approved_comment" rows="3" hidden="true"></textarea>
	                            <textarea type="text" class="form-control bg-light" name="approved_commentD" id="approved_commentD" rows="3" disabled="true"></textarea>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="leave_save_btn" id="leave_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="leave_update_btn" id="leave_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="leave_cancel_btn" id="leave_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
			</div>
		</div>
	</div>
</div>