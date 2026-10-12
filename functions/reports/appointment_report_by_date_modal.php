<div 
class="modal fade hide bd-example-modal-lg" 
id="appointment_report_by_date_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="appointment_report_by_date_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="appointment_report_by_date_modal_header">Appointments</h5>
			</div>
			<div class="modal-body">
				<form id="appointment_report_by_date_modal_form" method="POST">
	                <div class="panel-body">
                    	<div id="appointment_report_by_date_modal_warning"></div>
                    	<input type="hidden" name="appoint_company_id_abd" class="form-control" id="appoint_company_id_abd">
                    	<input type="hidden" name="appoint_user_super_id_abd" class="form-control" id="appoint_user_super_id_abd">
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="appoint_type_abd" class="control-label">Type</label>
                                <select name="appoint_type_abd" class="form-control" id="appoint_type_abd">
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
	                            <label for="appoint_doctor_abd">Doctor</label>
	                            <select class="form-control bg-light" name="appoint_doctor_abd" id="appoint_doctor_abd"> 
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
	                            <label for="appoint_theatre_abd" class="control-label">Theatre</label>
                                <select name="appoint_theatre_abd" class="form-control" id="appoint_theatre_abd">
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
                        <div class="form-row">
                            <div class="col-md-12 mb-12 form-group">
                                <label for="appoint_start_date_abd" class="control-label">Start Date</label>
                                <input type="date" name="appoint_start_date_abd" class="form-control" id="appoint_start_date_abd">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-12 form-group">
                                <label for="appoint_end_date_abd" class="control-label">End Date</label>
                                <input type="date" name="appoint_end_date_abd" class="form-control" id="appoint_end_date_abd">
                            </div>
                        </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="appointment_report_by_date_ok_btn" id="appointment_report_by_date_ok_btn" class="btn btn-primary">OK</button>
	                    <button type="submit" name="appointment_report_by_date_cancel_btn" id="appointment_report_by_date_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>