<div 
class="modal fade hide bd-example-modal-lg" 
id="appointment_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="appointment_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="appointment_report_modal_header">Appointments</h5>
			</div>
			<div class="modal-body">
				<form id="appointment_report_modal_form" method="POST">
	                <div class="panel-body">
                    	<div id="appointment_report_modal_warning"></div>
                    	<input type="hidden" name="appoint_company_id" class="form-control" id="appoint_company_id">
                    	<input type="hidden" name="appoint_user_super_id" class="form-control" id="appoint_user_super_id">
	                    <div class="form-row">
							<div class="col-md-12 mb-12 form-group">
								<label for="appoint_branch">Branch</label>
								<select class="form-control bg-light" name="appoint_branch" id="appoint_branch"> 
									
									<?php
										$branch_id = $_SESSION['branch_id'];
										if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
										{
											$sql="SELECT * FROM branch ORDER BY branch_name ASC";
											echo '<option value="ALL">ALL</option>';
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
	                            <label for="appoint_type" class="control-label">Type</label>
                                <select name="appoint_type" class="form-control" id="appoint_type">
                                    <option value="all_appointments">ALL</option>
                                    <?php
                                        $sql_appoint_type="SELECT * FROM appoint_type ORDER BY appoint_type ASC";
                                        $result_appoint_type = mysqli_query($con,$sql_appoint_type);
                                        while($row_appoint_type = mysqli_fetch_array($result_appoint_type))
                                        {
                                            echo '<option value = "'.$row_appoint_type['appoint_type_id'].'">
                                                '.$row_appoint_type['appoint_type'].'
                                            </option>';
                                        };
                                    ?>
                                </select>
	                        </div>
		                </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="appoint_doctor">Doctor</label>
	                            <select class="form-control bg-light" name="appoint_doctor" id="appoint_doctor"> 
	                                <option value="all_doctors">ALL</option>
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
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="appoint_theatre" class="control-label">Theatre</label>
                                <select name="appoint_theatre" class="form-control" id="appoint_theatre">
                                    <option value="all_theatres">ALL</option>
                                    <?php
                                        $sql_theatre = "SELECT * FROM theatre ORDER BY theatre ASC";
                                        $result_theatre = mysqli_query($con,$sql_theatre);
                                        while($row_theatre = mysqli_fetch_array($result_theatre))
                                        {
                                            echo '<option value = "'.$row_theatre['theatre_id'].'" >
                                                '.$row_theatre['theatre'].'
                                            </option>';
                                        };
                                    ?>
                                </select>
	                        </div>
		                </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="appointment_report_ok_btn" id="appointment_report_ok_btn" class="btn btn-primary">OK</button>
	                    <button type="submit" name="appointment_report_cancel_btn" id="appointment_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>