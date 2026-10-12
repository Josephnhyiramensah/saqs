
<?php 
    require('includes/db.php');
    include('includes/auth.php');
    include('includes/header_main.php');
    include('includes/navbar_main.php');
?>
<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Examination</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">
        <div class="modal-body">
            <div class="form-group">
                <label>System</label>
                <input type="text" name="system" class="form-control">
            </div>
            <div class="form-group">
                <label>Examination</label>
                <textarea name="examination" class="form-control" rows="6"></textarea>
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
                                <a class="list-group-item list-group-item-action" id="list-vitals-list" href="attd_vitals.php" role="tab" aria-controls="drugs">Vitals</a>
                                <a class="list-group-item list-group-item-action" id="list-history-list" href="attd_history.php" role="tab" aria-controls="history">History</a>
                                <a class="list-group-item list-group-item-action active" id="list-examination-list" href="attd_examination.php" role="tab" aria-controls="examination">Examination</a>
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
                                Examination
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                                Add Examination
                                </button>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>System</th>
                                            <th>Examination</th>
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