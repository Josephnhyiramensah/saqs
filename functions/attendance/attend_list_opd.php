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
    $company_id = $_SESSION['company_id'];
    
	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
?>
<input type="hidden" name="session_company_id" class="form-control bg-light" id="session_company_id" value="<?php echo $_SESSION['company_id'];?>">
<style type="text/css">
    input {
            border-top-style: hidden;
            border-right-style: hidden;
            border-left-style: hidden;
            border-bottom-style: hidden;
            background-color: #ffffff;
          }
    .scroll-card-body {
            max-height: 750px;
            overflow-y: auto;
          }
  </style>
<div class="container-fluid scroll-card-body">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Attendance List - OPD
	            </h4>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search" id="opd_attend_search_form">
		        	<div class="input-group">
                        <label>Name</label>
                        <input type="text" class="form-control border-0 small" aria-label="search_by_name" aria-describedby="basic-addon2" name="search_by_name" id="search_by_name">
		            	<label>Clinic</label>
		            	<select class="form-control" class="form-control bg-light border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_clinic" id="search_clinic"> 
					    	<option value="0">ALL</option>
					    	<?php
					        	$sql="SELECT * FROM clinics ORDER BY clinic_desc ASC";
								$result_clinics_list=mysqli_query($con,$sql);
					            while($row_clinics_list=mysqli_fetch_array($result_clinics_list))
					            {
                                    if($remember_state == true && $row_clinics_list['clinic_id'] == $search_clinic)
                                    {
					            ?>
        					            <option value = "<?php echo($row_clinics_list['clinic_id'])?>" selected="selected">
        					                <?php echo($row_clinics_list['clinic_desc']);?>
        					            </option>
					            <?php
                                    }
                                    else
                                    {
                                ?>
                                         <option value = "<?php echo($row_clinics_list['clinic_id'])?>">
                                            <?php echo($row_clinics_list['clinic_desc']);?>
                                        </option>
                                <?php
                                    };
					            };
					        ?>
				    	</select>
		            </div>
		            <div class="input-group">
		            	<label>From</label>
                        <?php
                                if($remember_state == true)
                                {
                            ?>
                                    <input type="date" class="form-control bg-light border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_from" id="search_from" value="<?php echo $search_from;?>">
                            <?php
                                }
                                else
                                {
                            ?>
                                    <input type="date" class="form-control bg-light border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_from" id="search_from">
                            <?php
                                };
                            ?>
		              	
		            </div>
		            <div class="input-group">
		            	<label>To</label>
                            <?php
                                if($remember_state == true)
                                {
                            ?>
                                    <input type="date" class="form-control bg-light border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_to" id="search_to" value="<?php echo $search_to;?>">
                            <?php
                                }
                                else
                                {
                            ?>
                                    <input type="date" class="form-control bg-light border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_to" id="search_to">
                            <?php
                                };
                            ?>
		            </div>
                    <div class="input-group">
                        <div class="form-check">
                            <?php
                                if($remember_state == true)
                                {
                            ?>
                                    <input class="form-check-input" type="checkbox" value="" id="remember_state" checked>
                            <?php
                                }
                                else
                                {
                            ?>
                                    <input class="form-check-input" type="checkbox" value="" id="remember_state">
                            <?php
                                };
                            ?>
                        </div>
                    </div>
		            <!--<div class="input-group">
		                <button class="btn btn-primary" type="button" id="search_attend_btn">
		                  <i class="fas fa-search fa-sm"></i>
		                </button>
		            </div>-->
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                /*if ($remember_state == true) {
                    $query = "SELECT * FROM attendance WHERE tos_id=1 AND date_admit BETWEEN '$search_from' AND '$search_to' AND clinic_id='$search_clinic'";
                    $query_run = mysqli_query($con, $query);
                }
                else*/
                //{
                    $query = "SELECT * FROM attendance WHERE tos_id=1 AND date_admit = CURDATE() AND company_id = '$company_id' ORDER BY attend_id";
                    $query_run = mysqli_query($con, $query);
                //};
            ?>
            <div class="table-responsive" id="attend-table">
                <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Folder No</th>
                            <th>Patient Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Attendance Date</th>
                            <th>Clinic</th>
                            <th>Payment Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    $attend_id = $row['attend_id'];
                                    $patient_id = $row['patient_id'];
                                    $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                                    $query_run_p = mysqli_query($con, $query_p);
                                    $row_p=mysqli_fetch_assoc($query_run_p);
                        ?>
                            <tr>
	                            <td class="action-td">
                                    <a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo $row_p['folderNo'];?></a>
                                </td>
                                <?php 

                                    $gender_id = $row_p['gender'];
                                    $query_g = "SELECT * FROM gender WHERE gender_id='$gender_id'";
                                    $query_run_g = mysqli_query($con, $query_g);
                                    $row_g=mysqli_fetch_assoc($query_run_g);
                                ?>
                                <td><a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo $row_p['firstName']." ". $row_p['lastName'] ?></a></td>
                                <td><a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo $row['age'];?></a></td>
                                <td><a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo $row_g['gender'];?></a></td>
                                <td><a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo $row['date_admit'];?></a></td>
                                <?php
                                    $query_sponsor = "SELECT * FROM payment_type WHERE attend_id = '$attend_id' AND principal = 'Yes'";
                                    $query_run_sponsor = mysqli_query($con, $query_sponsor);
                                    if(mysqli_num_rows($query_run_sponsor) > 0)
                                    {
                                        $row_sponsor = mysqli_fetch_assoc($query_run_sponsor);
                                        $sponsor_id = $row_sponsor['ledger_id'];
                                        $query = "SELECT * FROM ledgers WHERE ledger_id = '$sponsor_id'";
                                        $query_run_led = mysqli_query($con, $query);
                                        $row_led = mysqli_fetch_assoc($query_run_led);
                                        $sponsor_desc = $row_led['ledger_desc'];
                                    }
                                    else
                                    {
                                        $sponsor_id = 0;
                                        $sponsor_desc = 'N/A';
                                    };
                                    
                                    $clinic_id = $row['clinic_id'];
                                    $query_cl = "SELECT * FROM clinics WHERE clinic_id = '$clinic_id'";
                                    $query_run_cl = mysqli_query($con, $query_cl);
                                    $row_cl=mysqli_fetch_assoc($query_run_cl);
                                    if(isset($row_cl))
                                    {
                                        $clinic_name = $row_cl['clinic_desc'];
                                    }
                                    else
                                    {
                                        $clinic_name = 'WALK-IN';
                                    };
                                ?>
                                <td><a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo $clinic_name;?></a></td>
	                            <td><a href="#" id="btn_open_attend" data-id="<?php echo $row['attend_id'];?>" data-id2="<?php echo $row['patient_id'];?>"><?php echo $sponsor_desc;?></a></td>
                                <td>
                                <?php 
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Attendance_Cash_Statement'] == 'Yes')) 
                                    {
                                        echo '<a href="#" id="btn_cash_statement_attend" 
                                        data-id="'.$row['attend_id'].'" 
                                        data-id1="'.$row['patient_id'].'"
                                        data-id2="'.$row['date_admit'].'">
                                        Cash Stat.
                                        </a>';
                                        if($sponsor_id != 1 && $sponsor_id != 2)
                                        {
                                            echo' | <a href="#" id="btn_insurance_statement_attend" 
                                            data-id="'.$row['attend_id'].'" 
                                            data-id1="'.$row['patient_id'].'"
                                            data-id2="'.$row['date_admit'].'"
                                            data-id3="'.$sponsor_id.'">
                                            Sponsor Stat.
                                            </a>';
                                        };
                                    };
                                    
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Cashier_Attendance_list'] == 'Yes')) 
                                    {
                                        echo ' | <a href="#" 
                                        id="btn_new_receipt" 
                                        data-id="'.$row['attend_id'].'" 
                                        data-id1="'.$row_p['firstName']." ". $row_p['lastName'].'"
                                        data-id2="'.$row['patient_id'].'">New Receipt</a>';
                                    };
                                     if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' 
                                     OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Attendance'] == 'Yes')) 
                                    {
                                        echo ' | <a href="#" id="btn_delete_attend" data-id="'.$row['attend_id'].'"> Delete Attend. Sht.</a>';
                                    };
                                ?>
                                </td>
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
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/receipt_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>