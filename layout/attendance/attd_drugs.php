
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
        <h5 class="modal-title" id="exampleModalLabel">New Drug</h5>
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
                        <label>Drug ID</label>
                        <input type="text" name="drugid" class="form-control">
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
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Group</label>
                        <input type="text" name="group" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Drug</label>
                        <input type="text" name="drug" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Dosage</label>
                        <input type="text" name="dosage" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Qty</label>
                        <input type="text" name="qty" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="price" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" name="amount" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Comments</label>
                        <textarea name="comments" class="form-control" rows="3"></textarea>
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
                                <a class="list-group-item list-group-item-action" id="list-vitals-list" href="attd_vitals.php" role="tab" aria-controls="drugs">Vitals</a>
                                <a class="list-group-item list-group-item-action" id="list-history-list" href="attd_history.php" role="tab" aria-controls="history">History</a>
                                <a class="list-group-item list-group-item-action" id="list-examination-list" href="attd_examination.php" role="tab" aria-controls="examination">Examination</a>
                                <a class="list-group-item list-group-item-action" id="list-diagnosis-list" href="attd_diagnosis.php" role="tab" aria-controls="diagnosis">Diagnosis</a>
                                <a class="list-group-item list-group-item-action" id="list-radiology-list" href="attd_radiology.php" role="tab" aria-controls="radiology">Radiology</a>
                                <a class="list-group-item list-group-item-action" id="list-laboratory-list" href="attd_laboratory.php" role="tab" aria-controls="laboratory">Laboratoty</a>
                                <a class="list-group-item list-group-item-action active" id="list-drugs-list" href="attd_drugs.php" role="tab" aria-controls="drugs">Drugs</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 mb-8">
                    <div class="card shadow md-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Drugs
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                                Add Drugs
                                </button>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Drug</th>
                                            <th>Dosage</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>6/7/2020</td>
                                            <td>Paracetamol 500mg (UK)</td>
                                            <td>1gmxTDSx5</td>
                                            <td>20</td>
                                            <td>2.00</td>
                                            <td>40.00</td>
                                        </tr>
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