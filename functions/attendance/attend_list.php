<?php 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
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
	                Attendance List
	            </h4>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
		            	<label>Search</label>
					    <input type="text" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_attend" id="search_attend">
		            </div>
		            <div class="input-group">
		            	<label>From</label>
		              	<input type="date" class="form-control bg-light border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_from_attend_list" id="search_from_attend_list">
		            </div>
		            <div class="input-group">
		            	<label>To</label>
		            	<input type="date" class="form-control bg-light border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_to_attend_list" id="search_to_attend_list">
		            </div>
		            <div class="input-group">
		                <button class="btn btn-primary" id="btn-search-by-date" type="button">
		                  <i class="fas fa-search fa-sm"></i>
		                </button>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
            if(isset($_SESSION['success']) && $_SESSION['success'] !='')
            {
                echo '<h2>'.$_SESSION['success'].'</h2>';
                unset($_SESSION['success']);
            };
            if(isset($_SESSION['status']) && $_SESSION['status'] !='')
            {
                echo '<h2>'.$_SESSION['status'].'</h2>';
                unset($_SESSION['status']);
            };
            ?>

            <?php
                
                $query = "SELECT * FROM attendance";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="attend-table">
                <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Attendance Date</th>
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Clinic</th>
                            <th>Type of Service</th>
                            <th>Payment Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                                    $patient_id=$row['patient_id'];
                                    $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                                    $query_run_p = mysqli_query($con, $query_p);
                                    $row_p=mysqli_fetch_assoc($query_run_p);
                                    
                                    $gender_id=$row_p['gender'];
                                    $query_gender = "SELECT * FROM gender WHERE 	gender_id ='$gender_id'";
                                    $query_run_gender = mysqli_query($con, $query_gender);
                                    $row_gender=mysqli_fetch_assoc($query_run_gender);
                                    
                                    $clinic_id=$row['clinic_id'];
                                    $query_cl = "SELECT * FROM clinics WHERE clinic_id='$clinic_id'";
                                    $query_run_cl = mysqli_query($con, $query_cl);
                                    $row_cl=mysqli_fetch_assoc($query_run_cl);
                                    
                                    $query_tos = "SELECT * FROM type_of_service WHERE tos_id=1";
                                    $query_run_tos = mysqli_query($con, $query_tos);
                                    $row_tos=mysqli_fetch_assoc($query_run_tos);
                                    
                                    $attend_id = $row['attend_id'];
                                    $query_sponsor = "SELECT * FROM payment_type WHERE attend_id='$attend_id' AND principal ='Yes'";
                                    
                                    $query_run_sponsor = mysqli_query($con, $query_sponsor);
                                    $row_sponsor = mysqli_fetch_assoc($query_run_sponsor);
                                    if(isset($row_sponsor))
                                    {
                                        $sponsor_id = $row_sponsor['ledger_id'];
                                        if(isset($sponsor_id))
                                        {
                                            $query = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
                                            $query_run_led = mysqli_query($con, $query);
                                            $row_led = mysqli_fetch_assoc($query_run_led);
                                            $sponsor_desc = $row_led['ledger_desc'];
                                        }
                                        else
                                        {
                                            $sponsor_desc = 'N/A';
                                        };
                                    }
                                    else
                                    {
                                        $sponsor_desc = 'N/A';
                                    };
                        ?>
                            <tr>
                                <td><a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo $row['date_admit'];?></a></td>
                                <td><a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo $row_p['firstName']." ". $row_p['lastName'] ?></a></td>
                                <td><a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo $row['age'];?></a></td>
                                <td><a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo $row_gender['gender'];?></a></td>
                                <td><a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo $row_cl['clinic_desc'];?></a></td>
	                            <td><a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo $row_tos['description'];?></a></td>
	                            <td><a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo $sponsor_desc;?></a></td>
	                            <td>
                                    <?php 
                                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Attendance_Cash_Statement'] == 'Yes')) 
                                        {
                                            echo '<a href="#" id="btn_cash_statement_attend" 
                                            data-id="'.$row['attend_id'].'" 
                                            data-id1="'.$row['patient_id'].'"
                                            data-id2="'.$row['date_admit'].'">
                                            Cash Stat.
                                            </a>';
                                        };
                                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Attendance'] == 'Yes')) 
                                        {
                                            echo ' | <a href="#" id="btn_delete_attend" data-id="'.$row['attend_id'].'"> Delete Attend. Sht.</a>';
                                        };
                                    ?>
                                </td>
                            </tr>
                        <?php
                                }
                            }
                            else
                            {
                                    echo 'No Record Found';
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