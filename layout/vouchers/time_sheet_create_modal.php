<div 
class="modal fade bd-example-modal-lg" 
id="time_sheet_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="time_sheet_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 99%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="time_sheet_create_modal_header">Time Sheet Setup</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="time_sheet_create_form" method="POST">
					<div class="form-row">
						<div class="col-md-8 mb-8">
							<label for="time_sheet_branch_id">Branch</label>
							<select class="form-control bg-light" name="time_sheet_branch_id" id="time_sheet_branch_id"> 
	                            <option value="0">Please Select</option>
								<?php
									$company_id = $_SESSION['company_id'];
									$sql="SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name ASC";
									$result = mysqli_query($con,$sql);
									while($row = mysqli_fetch_array($result))
									{
										if($_SESSION['branch_id']==$row['branch_id'])
										{
											echo '<option value = "'.$row['branch_id'].'" selected ="selected">'.$row['branch_name'].'</option>';
										}
										else
										{
											echo '<option value = "'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
										};
									};
								?>
	                        </select>
						</div>
						<div class="col-md-4 mb-4">
							<label for="time_sheet_date">Date</label>
							<input type="date" class="form-control bg-light" name="time_sheet_date" id="time_sheet_date" value="<?php echo $date_today;?>">
							<input type="hidden" class="form-control bg-light" name="time_sheet_id" id="time_sheet_id">
						</div>
					</div>
					<div class="form-row" hidden>
						<div class="col-md-3 mb-3">
							<label for="time_sheet_authorized_by_hr">Authorized By (Site HR)</label>
							<select class="form-control bg-light" name="time_sheet_authorized_by_hr" id="time_sheet_authorized_by_hr"> 
	                            <option value="0">Please Select</option>
								<?php
									$branch_id = $_SESSION['branch_id'];
									$sql = "SELECT * FROM users WHERE branch_id='$branch_id' ORDER BY first_name ASC";
									$result = mysqli_query($con,$sql);
									while($row = mysqli_fetch_array($result))
									{
										echo '<option value = "'.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
									};
								?>
	                        </select>
							<select class="form-control bg-light" name="time_sheet_authorized_by_hrD" id="time_sheet_authorized_by_hrD" disabled="true" hidden="true"> 
	                            <option value="0">Please Select</option>
								<?php
									$branch_id = $_SESSION['branch_id'];
									$sql = "SELECT * FROM users WHERE branch_id='$branch_id' ORDER BY first_name ASC";
									$result = mysqli_query($con,$sql);
									while($row = mysqli_fetch_array($result))
									{
										echo '<option value = "'.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
									};
								?>
	                        </select>
						</div>
						<div class="col-md-1 mb-1">
							<label for="time_sheet_authorized_status_hr">Status (Site HR)</label>
							<select class="form-control bg-light" name="time_sheet_authorized_status_hr" id="time_sheet_authorized_status_hr"> 
	                        	<option value="Pending">Pending</option>
								<option value="Authorized" selected="selected">Authorized</option>
	                        </select>
							<select class="form-control bg-light" name="time_sheet_authorized_status_hrD" id="time_sheet_authorized_status_hrD" disabled="true" hidden="true"> 
	                        	<option value="Pending">Pending</option>
								<option value="Authorized"selected="selected">Authorized</option>
	                        </select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="time_sheet_authorized_by">Authorized By (SM)</label>
							<select class="form-control bg-light" name="time_sheet_authorized_by" id="time_sheet_authorized_by"> 
	                            <option value="0">Please Select</option>
								<?php
									$branch_id = $_SESSION['branch_id'];
									$sql = "SELECT * FROM users WHERE branch_id='$branch_id' ORDER BY first_name ASC";
									$result = mysqli_query($con,$sql);
									while($row = mysqli_fetch_array($result))
									{
										echo '<option value = "'.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
									};
								?>
	                        </select>
							<select class="form-control bg-light" name="time_sheet_authorized_by" id="time_sheet_authorized_by" disabled="true" hidden="true"> 
	                            <option value="0">Please Select</option>
								<?php
									$branch_id = $_SESSION['branch_id'];
									$sql = "SELECT * FROM users WHERE branch_id='$branch_id' ORDER BY first_name ASC";
									$result = mysqli_query($con,$sql);
									while($row = mysqli_fetch_array($result))
									{
										echo '<option value = "'.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
									};
								?>
	                        </select>
						</div>
						<div class="col-md-1 mb-1">
							<label for="time_sheet_authorized_status">Status (SM)</label>
							<select class="form-control bg-light" name="time_sheet_authorized_status" id="time_sheet_authorized_status"> 
	                        	<option value="Pending">Pending</option>
								<option value="Authorized"selected="selected">Authorized</option>
	                        </select>
							<select class="form-control bg-light" name="time_sheet_authorized_status" id="time_sheet_authorized_status" disabled="true" hidden="true"> 
	                        	<option value="Pending">Pending</option>
								<option value="Authorized"selected="selected">Authorized</option>
	                        </select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="time_sheet_approved_by">Approved By</label>
							<select class="form-control bg-light" name="time_sheet_approved_by" id="time_sheet_approved_by"> 
	                            <option value="0">Please Select</option>
								<?php
									$sql = "SELECT * FROM users ORDER BY first_name ASC";
									$result = mysqli_query($con,$sql);
									while($row = mysqli_fetch_array($result))
									{
										echo '<option value = "'.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
									};
								?>
	                        </select>
							<select class="form-control bg-light" name="time_sheet_approved_byD" id="time_sheet_approved_byD" disabled="true" hidden="true"> 
	                            <option value="0">Please Select</option>
								<?php
									$sql = "SELECT * FROM users ORDER BY first_name ASC";
									$result = mysqli_query($con,$sql);
									while($row = mysqli_fetch_array($result))
									{
										echo '<option value = "'.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
									};
								?>
	                        </select>
						</div>
						<div class="col-md-1 mb-1">
							<label for="time_sheet_approved_status">Approved Status</label>
							<select class="form-control bg-light" name="time_sheet_approved_status" id="time_sheet_approved_status">
								<option value="Pending">Pending</option>
	                        	<option value="Approved"selected="selected">Approved</option>
	                        </select>
							<select class="form-control bg-light" name="time_sheet_approved_statusD" id="time_sheet_approved_statusD" disabled="true" hidden="true">
								<option value="Pending">Pending</option>
	                        	<option value="Approved"selected="selected">Approved</option>
	                        </select>
						</div>
					</div>
					<!--<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="time_sheet_dept_id">Department</label>
							<select class="form-control bg-light" name="time_sheet_dept_id" id="time_sheet_dept_id"> 
	                            <option value="0">Please Select</option>-->
								<?php
									/*$company_id = $_SESSION['company_id'];
									$sql="SELECT * FROM department WHERE company_id = '$company_id' ORDER BY department ASC";
									$result = mysqli_query($con,$sql);
									while($row = mysqli_fetch_array($result))
									{
									?>
										<option value = "<?php echo $row['dept_id'];?>">
											<?php echo $row['department'];?>
										</option>
									<?php
									};*/
								?>
	                        <!--</select>
						</div>
					</div>-->
					<div class="form-row">
						<div class="col-md-12 mb-12" id="time_sheet_employee_list">
							<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="time_sheet_employee_table">
								<thead>
									<tr>
										<th width="35%" class="action-td" rowspan="2">Employee</th>
										<th width="15%" class="action-td" colspan="2">Overtime</th>
										<th width="15%" class="action-td" colspan="2">Day 6/7</th>
										<th width="15%" class="action-td" colspan="2">Holidays</th>
										<th width="10%" class="action-td" rowspan="2">Absent</th>
										<th width="10%" class="action-td" rowspan="2">Action</th>
									</tr>
									<tr>
										<th class="action-td">Actual</th>
										<th class="action-td">Approved</th>
										<th class="action-td">Actual</th>
										<th class="action-td">Approved</th>
										<th class="action-td">Actual</th>
										<th class="action-td">Approved</th>
									</tr>
								</thead>
								<tbody>
									<tr id="1">
										<td>
											<input type="hidden" name="time_sheet_list_id[]" class="form-control bg-light" id="time_sheet_list_id1">
											<select class="form-control time_sheet_employee_id" name="time_sheet_employee_id[]" id="time_sheet_employee_id1" data-id="1" style="border-width:0px">
												<option value="0">Please Select</option>
												<?php
													$branch_id = $_SESSION['time_sheet_branch_id'];
													$sql = "SELECT * FROM payroll_employee WHERE location='$branch_id' AND resp_allowance < 1 ORDER BY first_name ASC";
													$result = mysqli_query($con,$sql);
													while($row = mysqli_fetch_array($result))
													{
														echo '<option value = "'.$row['employee_id'].'">'.$row['first_name'].' '.$row['last_name'].'( - '.$row['telephone'].')</option>';
													};
												?>       
											</select>
										</td>
										<td>
											<input type="text" name="time_sheet_overtime_actual[]" class="form-control bg-light time_sheet_overtime_actual text-center" id="time_sheet_overtime_actual1" data-id="1" style="border-width:0px">
											<input type="text" name="time_sheet_overtime_actualD[]" class="form-control bg-light time_sheet_overtime_actualD text-center" id="time_sheet_overtime_actualD1" data-id="1" style="border-width:0px" disabled="true" hidden="true">
										</td>
										<td>
											<input type="text" name="time_sheet_overtime[]" class="form-control bg-light time_sheet_overtime text-center" id="time_sheet_overtime1" data-id="1" style="border-width:0px" hidden="true">
											<input type="text" name="time_sheet_overtimeD[]" class="form-control bg-light time_sheet_overtimeD text-center" id="time_sheet_overtimeD1" data-id="1" style="border-width:0px" disabled="true">
										</td>
										<td>
											<input type="text" name="time_sheet_day_6n7_actual[]" class="form-control bg-light time_sheet_day_6n7_actual text-center" id="time_sheet_day_6n7_actual1" data-id="1" style="border-width:0px">
											<input type="text" name="time_sheet_day_6n7_actualD[]" class="form-control bg-light time_sheet_day_6n7_actualD text-center" id="time_sheet_day_6n7_actualD1" data-id="1" style="border-width:0px" disabled="true" hidden="true">
										</td>
										<td>
											<input type="text" name="time_sheet_day_6n7[]" class="form-control bg-light time_sheet_day_6n7 text-center" id="time_sheet_day_6n71" data-id="1" style="border-width:0px" hidden="true">
											<input type="text" name="time_sheet_day_6n7D[]" class="form-control bg-light time_sheet_day_6n7D text-center" id="time_sheet_day_6n7D1" data-id="1" style="border-width:0px" disabled="true">
										</td>
										<td>
											<input type="text" name="time_sheet_holidays_actual[]" class="form-control bg-light time_sheet_holidays_actual text-center" id="time_sheet_holidays_actual1" style="border-width:0px">
											<input type="text" name="time_sheet_holidays_actualD[]" class="form-control bg-light time_sheet_holidays_actualD text-center" id="time_sheet_holidays_actualD1" style="border-width:0px" disabled="true" hidden="true">
										</td>
										<td>
											<input type="text" name="time_sheet_holidays[]" class="form-control bg-light time_sheet_holidays text-center" id="time_sheet_holidays1" style="border-width:0px" hidden="true">
											<input type="text" name="time_sheet_holidaysD[]" class="form-control bg-light time_sheet_holidaysD text-center" id="time_sheet_holidaysD1" style="border-width:0px" disabled="true">
										</td>
										<td>
											<input type="text" name="time_sheet_absent[]" class="form-control bg-light time_sheet_absent text-center" id="time_sheet_absent1" style="border-width:0px">
										</td>
										<td class="action-td">
											<!--<a href="#" class="delete_time_sheet_employee" id="delete_time_sheet_employee" data-id="1"><i class="fa fa-trash fa-sm"></i></a>-->
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				    <div class="modal-footer">
				        <button type="button" name="time_sheet_save_btn" id="time_sheet_save_btn" class="btn btn-primary" >Save</button>
				        <button type="button" name="time_sheet_update_btn" id="time_sheet_update_btn" class="btn btn-primary" >Update</button>
				        <button type="submit" name="time_sheet_cancel_btn" id="time_sheet_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>