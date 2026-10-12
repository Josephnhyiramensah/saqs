
<?php 
    require('includes/db.php');
    include('includes/auth.php');
    include('includes/header_main.php');
    include('includes/navbar_main.php');
?>
<div class="modal fade bd-example-modal-lg" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Vital Signs</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="text" name="date" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                        <label>Time</label>
                        <input type="text" name="time" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                        <label>Attendance ID</label>
                        <input type="text" name="attdid" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>BP-Systolic</label>
                        <input type="text" name="bpsystolic" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>BP-Diastolic</label>
                        <input type="text" name="bpdiastolic" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Temp</label>
                        <input type="text" name="temp" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Pulse</label>
                        <input type="text" name="pulse" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Respiratory Rate</label>
                        <input type="text" name="resprate" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Weight</label>
                        <input type="text" name="weight" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Height</label>
                        <input type="text" name="height" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Oxygen Saturation</label>
                        <input type="text" name="oxysat" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Hip Circum.</label>
                        <input type="text" name="hipcirc" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Abdominal Circum.</label>
                        <input type="text" name="abdocir" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="registerbtn" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Attendance
            </h6>
        </div>
        <div class="card-body">
            <div class="form-row">
				<div class="col-md-3 mb-2">
                    <div class="card shadow md-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Patient Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
				                <div class="col-md-4 mb-2">
                                    <img src="img/logo_2.jpg" class="card-img" alt="mylogo_2">
                                </div>
                                <div class="col-md-8 mb-4">
                                    <h6>1111/20</h6>
                                    <h6>Ekow Dadzie Andam</h6>
                                    <h6>40yrs</h6>
                                </div>
                            </div>
                            <div class="list-group" id="list-tab" role="tablist">
                                <a class="list-group-item list-group-item-action active" id="list-vitals-list" href="attd_vitals.php" role="tab" aria-controls="drugs">Vitals</a>
                                <a class="list-group-item list-group-item-action" id="list-history-list" href="attd_history.php" role="tab" aria-controls="history">History</a>
                                <a class="list-group-item list-group-item-action" id="list-examination-list" href="attd_examination.php" role="tab" aria-controls="examination">Examination</a>
                                <a class="list-group-item list-group-item-action" id="list-diagnosis-list" href="attd_diagnosis.php" role="tab" aria-controls="diagnosis">Diagnosis</a>
                                <a class="list-group-item list-group-item-action" id="list-radiology-list" href="attd_radiology.php" role="tab" aria-controls="radiology">Radiology</a>
                                <a class="list-group-item list-group-item-action" id="list-laboratory-list" href="attd_laboratory.php" role="tab" aria-controls="laboratory">Laboratoty</a>
                                <a class="list-group-item list-group-item-action" id="list-drugs-list" href="attd_drugs.php" role="tab" aria-controls="drugs">Drugs</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 mb-8">
                    <div class="card shadow md-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Vital Signs
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                                Add Vitals
                                </button>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Temp</th>
                                            <th>BP</th>
                                            <th>Pulse</th>
                                            <th>Weight</th>
                                            <th>Height</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/scripts_main.php');?>
<?php include('includes/footer_main.php');?>