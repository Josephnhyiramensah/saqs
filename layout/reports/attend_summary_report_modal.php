<div 
class="modal fade hide bd-example-modal-lg" 
id="attend_summary_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="attend_summary_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="attend_summary_report_modal_header">Attendance Summary Report</h5>
			</div>
			<div class="modal-body">
				<form id="attend_summary_report_modal_form" method="POST">
	                <div class="panel-body">
	                    <div id="attend_summary_report_modal_warning"></div>
						<div class="form-row">
							<div class="col-md-12 mb-12 form-group">
								<label for="attend_summary_report_branch">Branch</label>
								<select class="form-control bg-light" name="attend_summary_report_branch" id="attend_summary_report_branch"> 
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
	                            <input type="hidden" name="attend_summary_report_company_id" class="form-control bg-light" id="attend_summary_report_company_id">
	                            <input type="hidden" name="attend_summary_report_user_id" class="form-control bg-light" id="attend_summary_report_user_id">
	                            <input type="hidden" name="attend_summary_report_user_super_id" class="form-control bg-light" id="attend_summary_report_user_super_id">
	                            <label for="attend_summary_report_start_date">Start Date</label>
	                            <input type="date" name="attend_summary_report_start_date" class="form-control bg-light" id="attend_summary_report_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="attend_summary_report_end_date">End Date</label>
	                            <input type="date" name="attend_summary_report_end_date" class="form-control bg-light" id="attend_summary_report_end_date">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="attend_summary_report_doctor">Doctor</label>
	                            <select class="form-control bg-light" name="attend_summary_report_doctor" id="attend_summary_report_doctor"> 
	                                <option value="all">ALL</option>
		                                <?php
                                            $sql_doctor = "SELECT * FROM users WHERE user_type_id = 6 ORDER BY full_name ASC";
                                            $result_doctor = mysqli_query($con,$sql_doctor);
                                            while($row_doctor = mysqli_fetch_array($result_doctor))
                                            {
                                                echo '<option value = "'.$row_doctor['full_name'].'">'.$row_doctor['full_name'].'</option>';
                                            };
                                        ?>
	                            </select>
	                        </div>
		                </div>
	                    <div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="attend_summary_report_tos">Type Of Service</label>
								<select class="form-control bg-light" name="attend_summary_report_tos" id="attend_summary_report_tos" required> 
							    	<option value="all">ALL</option>
							        <?php
							        	$sql_tos="SELECT * FROM type_of_service ORDER BY description DESC";
										$result_tos = mysqli_query($con,$sql_tos);
							            while($row_tos = mysqli_fetch_array($result_tos))
							            {
							            	echo '<option value = "'.$row_tos['tos_id'].'">'.$row_tos['description'].'</option>';
							            };
							        ?>
							    </select>
							</div>
						</div>
	                    <div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="attend_summary_report_clinic">Clinic</label>
								<select class="form-control bg-light" name="attend_summary_report_clinic" id="attend_summary_report_clinic" required> 
							    	<option value="all">ALL</option>
							        <?php
							        	$sql_clinic = "SELECT * FROM clinics ORDER BY clinic_desc ASC";
										$result_clinic = mysqli_query($con,$sql_clinic);
							            while($row_clinic = mysqli_fetch_array($result_clinic))
							            {
							            	echo '<option value = "'.$row_clinic['clinic_id'].'">'.$row_clinic['clinic_desc'].'</option>';
							            };
							        ?>
							    </select>
							</div>
						</div>
	                    <div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="attend_summary_report_bal_type">Balance Type</label>
								<select class="form-control bg-light" name="attend_summary_report_bal_type" id="attend_summary_report_bal_type" required> 
							    	<option value="all">ALL</option>
							    	<option value="negative">NEGATIVE</option>
							    	<option value="positive">POSITIVE</option>
							    </select>
							</div>
						</div>
	                    <div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="attend_summary_report_sponsor">Sponsor</label>
								<select class="form-control bg-light" name="attend_summary_report_sponsor" id="attend_summary_report_sponsor" required> 
							    	<option value="all">ALL</option>
							        <?php
							        	$sponsor_query ="SELECT * FROM ledgers WHERE tb_5=1 ORDER BY ledger_desc ASC";
										$sponsor_query_result=mysqli_query($con,$sponsor_query);
										while($row_sponsor = mysqli_fetch_array($sponsor_query_result))
            							{
											echo '<option value = "'.$row_sponsor['ledger_id'].'">'.$row_sponsor['ledger_desc'].'</option>';
										};
							        ?>
							    </select>
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="attend_summary_report_ok_btn" id="attend_summary_report_ok_btn" class="btn btn-primary" >OK</button>
	                    <button type="submit" name="attend_summary_report_cancel_btn" id="attend_summary_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>