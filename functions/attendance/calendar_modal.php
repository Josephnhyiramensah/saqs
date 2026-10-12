<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="ModalAdd" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title m-0 font-weight-bold text-primary" id="myModalLabel">Add Appointment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
                <form method="POST" action="calendar_addEvent.php">
                    <div class="modal-body">
                        <div class="panel-body">
                            <div class="form-row">
                                <div class="col-sm-8 col-md-8">
                                    <div class="form-group">
                                        <label for="name" class="control-label">Name</label>
                                        <input type="hidden" name="patient_id" class="form-control" id="patient_id">
                                        <input type="hidden" name="attend_id" class="form-control" id="attend_id">
                                        <input type="text" name="name" class="form-control" id="name" >
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2">
                                    <div class="form-group">
                                        <label for="sex" class="control-label">Sex</label>
                                        <select name="sex" class="form-control" id="sex">
                                            <option value="">Choose Sex</option>
                                            <?php
                                                $sql_sex="SELECT * FROM gender WHERE gender != 'Both' ORDER BY gender ASC";
                                                $result_sex = mysqli_query($con,$sql_sex);
                                                while($row_sex = mysqli_fetch_array($result_sex))
                                                {
                                                    echo '<option value = "'.$row_sex['gender_id'].'" >
                                                        '.$row_sex['gender'].'
                                                    </option>';
                                                };
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2">
                                    <div class="form-group">
                                        <label for="age" class="control-label">Age</label>
                                        <input type="text" name="age" class="form-control" id="age" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" id="phone" >
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="email" class="control-label">Email</label>
                                        <input type="text" name="email" class="form-control" id="email" >
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="date" class="control-label">Date</label>
                                        <input type="text" name="date" class="form-control" id="date">
                                        <input type="text" name="start" class="form-control" id="start" >
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="time" class="ontrol-label">Time</label>
                                        <input type="text" name="time" class="form-control" id="time">
                                            <input type="text" name="end" class="form-control" id="end">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="appoint_type" class="control-label">Type</label>
                                        <select name="appoint_type" class="form-control" id="appoint_type">
                                            <option value="">Choose</option>
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
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="doctor" class="control-label">Doctor</label>
                                        <!--<input type="text" name="doctor" class="form-control" id="doctor">-->
                                        <select class="form-control bg-light" name="doctor" id="doctor" required> 
                                            <option value="0">Choose Doctor</option>
                                            <?php
                                                $sql_doctor = "SELECT * FROM users WHERE user_type_id = 6 ORDER BY first_name ASC";
                                                $result_doctor = mysqli_query($con,$sql_doctor);
                                                while($row_doctor = mysqli_fetch_array($result_doctor))
                                                {
                                                    echo '<option value = "'.$row_doctor['first_name'].'">'.$row_doctor['first_name'].'</option>';
                                                };
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" id="appoint_surgery_div" hidden="true">
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="surgery" class="control-label">Surgery</label>
                                        <select name="surgery" class="form-control" id="surgery">
                                            <option value="">Choose Surgery</option>
                                            <?php
                                                $sql_surgery = "SELECT * FROM surgery ORDER BY surgery ASC";
                                                $result_surgery = mysqli_query($con,$sql_surgery);
                                                while($row_surgery = mysqli_fetch_array($result_surgery))
                                                {
                                                    echo '<option value = "'.$row_surgery['surgery'].'" >
                                                        '.$row_surgery['surgery'].'
                                                    </option>';
                                                };
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label for="anesthetist" class="control-label">Anesthetist</label>
                                        <input type="text" name="anesthetist" class="form-control" id="anesthetist" >
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2">
                                    <div class="form-group">
                                        <label for="theatre" class="control-label">Theatre</label>
                                        <select name="theatre" class="form-control" id="theatre">
                                            <option value="">Choose Theatre</option>
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
                            <div class="form-group">
                                <label for="color" class="control-label">Type of Activiy:</label>
                                    <select name="color" class="form-control" id="color" required="">
                                        <option value="">Choose</option>
                                        <option style="color:#FF0000;" value="#FF0000">&#9724; SURGERY</option>
                                        <option style="color:#008000;" value="#008000">&#9724; CONSULTATION</option>
                                        <option style="color:#FF8C00;" value="#FF8C00">&#9724; ENDOSCOPY</option>
                                        <option style="color:#0071c5;" value="#0071c5">&#9724; DIALYSIS</option>
                                    </select>
                            </div>
                            <div class="form-group">
                                <label for="title" class="control-label">Activity:</label>
                                <textarea rows="4" cols="10" id="title" class="form-control" name="title" maxlength="300" value="" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-xl" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="ModalEdit" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title m-0 font-weight-bold text-primary" id="myModalLabel">Edit Appointment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
                <form method="POST" action="calendar_editEventTitle.php">
                    <div class="modal-body">
                        <div class="panel-body">
                            <div class="form-row">
                                <div class="col-sm-8 col-md-8">
                                    <div class="form-group">
                                        <label for="name" class="control-label">Name</label>
                                        <input type="hidden" name="patient_id" class="form-control" id="patient_id">
                                        <input type="hidden" name="attend_id" class="form-control" id="attend_id">
                                        <input type="hidden" name="id" class="form-control" id="id">
                                        <input type="text" name="name" class="form-control" id="name" >
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2">
                                    <div class="form-group">
                                        <label for="sex" class="control-label">Sex</label>
                                        <select name="sex" class="form-control" id="sex">
                                            <option value="">Choose Sex</option>
                                            <?php
                                                $sql_sex="SELECT * FROM gender WHERE gender != 'Both' ORDER BY gender ASC";
                                                $result_sex = mysqli_query($con,$sql_sex);
                                                while($row_sex = mysqli_fetch_array($result_sex))
                                                {
                                                    echo '<option value = "'.$row_sex['gender_id'].'" >
                                                        '.$row_sex['gender'].'
                                                    </option>';
                                                };
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2">
                                    <div class="form-group">
                                        <label for="age" class="control-label">Age</label>
                                        <input type="text" name="age" class="form-control" id="age" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" id="phone" >
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="email" class="control-label">Email</label>
                                        <input type="text" name="email" class="form-control" id="email" >
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="date" class="control-label">Date</label>
                                        <input type="text" name="date" class="form-control" id="date">
                                        <input type="text" name="start" class="form-control" id="start">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="time" class="ontrol-label">Time</label>
                                        <input type="text" name="time" class="form-control" id="time">
                                        <input type="text" name="end" class="form-control" id="end">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="appoint_type" class="control-label">Type</label>
                                        <select name="appoint_type" class="form-control" id="appoint_type">
                                            <option value="">Choose</option>
                                            <?php
                                                $sql_appoint_type="SELECT * FROM appoint_type ORDER BY appoint_type ASC";
                                                $result_appoint_type = mysqli_query($con,$sql_appoint_type);
                                                while($row_appoint_type = mysqli_fetch_array($result_appoint_type))
                                                {
                                                    echo '<option value = "'.$row_appoint_type['appoint_type_id'].'" >
                                                        '.$row_appoint_type['appoint_type'].'
                                                    </option>';
                                                };
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="doctor" class="control-label">Doctor</label>
                                        <!--<input type="text" name="doctor" class="form-control" id="doctor" >-->
                                        <select class="form-control bg-light" name="doctor" id="doctor" required> 
                                            <option value="0">Choose Doctor</option>
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
                            </div>
                            <div class="form-row">
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="surgery" class="control-label">Surgery</label>
                                        <select name="surgery" class="form-control" id="surgery">
                                            <option value="">Choose Surgery</option>
                                            <?php
                                                $sql_surgery = "SELECT * FROM surgery ORDER BY surgery ASC";
                                                $result_surgery = mysqli_query($con,$sql_surgery);
                                                while($row_surgery = mysqli_fetch_array($result_surgery))
                                                {
                                                    echo '<option value = "'.$row_surgery['surgery'].'" >
                                                        '.$row_surgery['surgery'].'
                                                    </option>';
                                                };
                                            ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label for="anesthetist" class="control-label">Anesthetist</label>
                                        <input type="text" name="anesthetist" class="form-control" id="anesthetist" >
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2">
                                    <div class="form-group">
                                        <label for="theatre" class="control-label">Theatre</label>
                                        <select name="theatre" class="form-control" id="theatre">
                                            <option value="">Choose Theatre</option>
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
                            <div class="form-group">
                                <label for="color" class="control-label">Type of Activiy:</label>
                                    <select name="color" class="form-control" id="color" required="">
                                        <option value="">Choose</option>
                                        <option style="color:#FF0000;" value="#FF0000">&#9724; SURGERY</option>
                                        <option style="color:#008000;" value="#008000">&#9724; CONSULTATION</option>
                                        <option style="color:#FF8C00;" value="#FF8C00">&#9724; ENDOSCOPY</option>
                                        <option style="color:#0071c5;" value="#0071c5">&#9724; DIALYSIS</option>
                                    </select>
                            </div>
                            <div class="form-group">
                                <label for="title" class="control-label">Activity:</label>
                                <textarea rows="4" cols="10" id="title" class="form-control" name="title" maxlength="300" value="" required></textarea>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label class="text-danger"><input type="checkbox"  name="delete"> Delete event</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
        </div>
    </div>
</div>

<!-- END Modal -->
	
	
     