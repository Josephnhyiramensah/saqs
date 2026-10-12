<div 
class="modal fade hide bd-example-modal-lg" 
id="trial_balance_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="trial_balance_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="trial_balance_report_modal_header">Trial Balance</h5>
			</div>
			<div class="modal-body">
				<form id="trial_balance_report_modal_form" method="POST">
	                <div class="panel-body">
	                    <div id="trial_balance_report_modal_warning"></div>
	                    <div class="form-row">
							<div class="col-md-12 mb-12 form-group">
								<label for="trial_balance_report_branch">Branch</label>
								<select class="form-control bg-light" name="trial_balance_report_branch" id="trial_balance_report_branch"> 
									<option value="ALL">ALL</option>
									<?php
										$branch_id = $_SESSION['branch_id'];
										if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
										{
											$sql="SELECT * FROM branch ORDER BY branch_name ASC";
										}
										else
										{
											$sql="SELECT * FROM branch WHERE branch_id='$branch_id' ORDER BY branch_name ASC";
										};
										$result = mysqli_query($con, $sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value = "'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
										};
									?>
								</select>
							</div>
		                </div>
		                <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="trial_balance_report_start_date">Start Date</label>
	                            <input type="date" name="trial_balance_report_start_date" class="form-control bg-light" id="trial_balance_report_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="trial_balance_report_end_date">End Date</label>
	                            <input type="date" name="trial_balance_report_end_date" class="form-control bg-light" id="trial_balance_report_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="trial_balance_report_ok_btn" id="trial_balance_report_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="trial_balance_report_cancel_btn" id="trial_balance_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>