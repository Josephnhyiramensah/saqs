<?php 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    if(isset($_SESSION['search_clinic'])){$search_clinic = $_SESSION['search_clinic'];}else{$search_clinic = 0;};
    if(isset($_SESSION['search_from'])){$search_from = $_SESSION['search_from'];}else{$search_from = '';};
    if(isset($_SESSION['search_to'])){$search_to = $_SESSION['search_to'];}else{$search_to = '';};
    if(isset($_SESSION['page'])){$page = $_SESSION['page'];}else{$page = '';};
    if(isset($_SESSION['remember_state'])){$remember_state = $_SESSION['remember_state'];}else{$remember_state = 'false';};
?>
<style type="text/css">
    input {
            border-top-style: hidden;
            border-right-style: hidden;
            border-left-style: hidden;
            border-bottom-style: hidden;
            background-color: #ffffff;
          }
  </style>
<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Attendance List - Cashier
	            </h4>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">
		            	<label>Name</label>
		            	<input type="text" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="name_search" id="name_search">
		            </div>
		            <div class="input-group">
		            	<label>From</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="start_date" id="start_date">
		              	
		            </div>
		            <div class="input-group">
		            	<label>To</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="end_date" id="end_date">
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                if ($remember_state == true) {
                    $query = "SELECT * FROM attendance WHERE tos_id=1 AND date_admit BETWEEN '$search_from' AND '$search_to' AND clinic_id='$search_clinic'";
                    $query_run = mysqli_query($con, $query);
                }
                else
                {
                    $query = "SELECT * FROM attendance WHERE tos_id=1 AND date_admit = CURDATE() ORDER BY attend_id";
                    $query_run = mysqli_query($con, $query);
                };
            ?>
            <div class="table-responsive" id="attend-table">
                <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Attendance ID</th>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Attendance Date</th>
                            <th>Payment Type</th>
                            <th>Type Of Service</th>
                            <th>Service</th>
                            <th>Labs</th>
                            <th>Radiology</th>
                            <th>Drugs</th>
                            <th>Surgeries</th>
                            <th>Consum.</th>
                            <th>Total Bill</th>
                            <th>Total Rec</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                                    if($row['nhis_led_id'] > 0 && $row['prvt_led_id'] > 0 )
                                        {
                                            $sponsor_id = $row['nhis_led_id'];
                                        }
                                    else if($row['nhis_led_id'] > 0 && $row['prvt_led_id'] <= 0 )
                                        {
                                            $sponsor_id = $row['nhis_led_id'];
                                        }
                                    else if($row['nhis_led_id'] <= 0 && $row['prvt_led_id'] > 0 )
                                        {
                                            $sponsor_id = $row['prvt_led_id'];
                                        }
                                    else if($row['nhis_led_id'] <= 0 && $row['prvt_led_id'] <= 0 )
                                        {
                                            $sponsor_id = 1;
                                        }
                                    $query = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
                                    $query_run_led = mysqli_query($con, $query);
                                    $row_led=mysqli_fetch_assoc($query_run_led);
                        ?>
                            <tr>
	                            <td>
                                    <a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo str_pad($row['attend_id'],7,"0",STR_PAD_LEFT);?></a>
                                </td>
                                <td><?php echo $row['patient_id'];?></td>
                                <?php 
                                    $patient_id=$row['patient_id'];
                                    $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                                    $query_run_p = mysqli_query($con, $query_p);
                                    $row_p=mysqli_fetch_assoc($query_run_p);

                                    $gender_id=$row_p['gender'];
	                                    $query_g = "SELECT * FROM gender WHERE gender_id='$gender_id'";
	                                    $query_run_g = mysqli_query($con, $query_g);
	                                    $row_g=mysqli_fetch_assoc($query_run_g);
                                ?>
                                <td><?php echo $row_p['firstName']." ". $row_p['lastName'] ?></td>
                                <td><?php echo $row['age'];?></td>
                                <td><?php echo $row_g['gender'];?></td>
                                <td><?php echo $row['date_admit'];?></td>
                                <?php 
                                    $query_tos = "SELECT * FROM type_of_service WHERE tos_id=1";
                                    $query_run_tos = mysqli_query($con, $query_tos);
                                    $row_tos=mysqli_fetch_assoc($query_run_tos);
                                ?>
	                            <td><?php echo $row_led['ledger_desc'];?></td>
                                <td><?php echo $row_tos['description'];?></td>
                                <td><?php echo $row['amt_service'];?></td>
                                <td><?php echo $row['amt_labs'];?></td>
                                <td><?php echo $row['amt_radio'];?></td>
                                <td><?php echo $row['amt_drugs'];?></td>
                                <td><?php echo $row['amt_sugeries'];?></td>
                                <td><?php echo $row['amt_comsum'];?></td>
                                <td><?php echo $row['total_bill'];?></td>
                                <td><?php echo $row['amt_rec'];?></td>
                                <td><?php echo $row['amt_bal'];?></td>
                            </tr>
                        <?php
                                }
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>