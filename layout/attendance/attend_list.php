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
    .amt-td {
            text-align:right;
          }
    .action-td {
            text-align:center;
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
		            	<label>Search Criteria</label>
                        <select class="form-control bg-light" name="search_attend_criteria" id="search_attend_criteria"> 
                            <option value="Name">Name</option>
                            <option value="Telephone">Telephone</option>
                            <option value="Folder_No">Folder_No</option>
                            <option value="Membership_No">Membership_No</option>
                        </select>
		            </div>
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
                
                $query = "SELECT * FROM attendance ORDER BY date_admit DESC LIMIT 50";
                $query_run = mysqli_query($con, $query);
            
            echo '<div class="table-responsive" id="attend-table">
                <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Attend. ID</th>
                            <th>Attend. Date</th>
                            <th>Patient Name</th>
                            <th>Folder No</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Clinic</th>
                            <th>Type of Service</th>
                            <th>Payment Type</th>
                            <th>Member. No</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">';
                        
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                                    $patient_id=$row['patient_id'];
                                    $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                                    $query_run_p = mysqli_query($con, $query_p);
                                    $row_p=mysqli_fetch_assoc($query_run_p);
                                    $date = $row['date_admit'];
                                    $DOB = $row_p['DOB'];
                                    //AGE
                                        $ts1 = strtotime($DOB);
                                        $ts2 = strtotime($date);
                                        
                                        $year1 = date('Y', $ts1);
                                        $year2 = date('Y', $ts2);
                                        $years = $year2 - $year1;
                                        
                                        $month1 = date('m', $ts1);
                                        $month2 = date('m', $ts2);
                                        $months = $month2 - $month1;
                            
                                        if($years > 0)
                                        {
                                            $age = ($year2 - $year1).' years';
                                        }
                                        else
                                        {
                                            $age = ($month2 - $month1).' months';
                                        };
                                    
                                    $gender_id=$row_p['gender'];
                                    $query_gender = "SELECT * FROM gender WHERE gender_id ='$gender_id'";
                                    $query_run_gender = mysqli_query($con, $query_gender);
                                    if(!empty($query_run_gender) && mysqli_num_rows($query_run_gender) > 0)
                                    {
                                        $row_gender=mysqli_fetch_assoc($query_run_gender);
                                        $gender = $row_gender['gender'];
                                    }
                                    else{
                                        $gender = 'Not Specified';
                                    };
                                    
                                    $clinic_id=$row['clinic_id'];
                                    $query_cl = "SELECT * FROM clinics WHERE clinic_id='$clinic_id'";
                                    $query_run_cl = mysqli_query($con, $query_cl);
                                    if(!empty($query_run_cl) && mysqli_num_rows($query_run_cl) > 0)
                                    {
                                        $row_cl=mysqli_fetch_assoc($query_run_cl);
                                        $clinic = $row_cl['clinic_desc'];
                                    }
                                    else{
                                        $clinic = 'Not Specified';
                                    };
                                    
                                    $query_tos = "SELECT * FROM type_of_service WHERE tos_id=1";
                                    $query_run_tos = mysqli_query($con, $query_tos);
                                    if(!empty($query_run_tos) && mysqli_num_rows($query_run_tos) > 0)
                                    {
                                        $row_tos=mysqli_fetch_assoc($query_run_tos);
                                        $service_type = $row_tos['description'];
                                    }
                                    else{
                                        $service_type = 'Not Specified';
                                    };
                                    
                                    $attend_id = $row['attend_id'];
                                    $query_sponsor = "SELECT * FROM payment_type WHERE attend_id='$attend_id' AND principal ='Yes'";
                                    
                                    $query_run_sponsor = mysqli_query($con, $query_sponsor);
                                    $row_sponsor = mysqli_fetch_assoc($query_run_sponsor);
                                    if(isset($row_sponsor))
                                    {
                                        $sponsor_id = $row_sponsor['ledger_id'];
                                        if(isset($row_sponsor['member_no']) && $row_sponsor['member_no'] !=''){$member_no = $row_sponsor['member_no'];}else{$member_no = '';}
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
                                        $member_no = '';
                                    };

                                    $query_mg = "SELECT * FROM management_plan WHERE attend_id='$attend_id' ORDER BY date DESC, mp_id DESC";
                                    $query_run_mg = mysqli_query($con, $query_mg);
                                    if(!empty($query_run_mg) && mysqli_num_rows($query_run_mg) > 0)
                                    {
                                        $row_mg=mysqli_fetch_assoc($query_run_mg);
                                        $mgt_plan = $row_mg['mgt_notes'];
                                    }
                                    else
                                    {
                                        $mgt_plan = 'No plan yet';
                                    };

                                    $created_by_id = $row['created_by'];
                                    $query_cb = "SELECT * FROM users WHERE id='$created_by_id'";
                                    $query_run_cb = mysqli_query($con, $query_cb);
                                    if(!empty($query_run_cb) && mysqli_num_rows($query_run_cb) > 0)
                                    {
                                        $row_cb = mysqli_fetch_assoc($query_run_cb);
                                        $creator = $row_cb['first_name'].''.$row_cb['last_name'];
                                    }
                                    else
                                    {
                                        $creator = 'Not Specified';
                                    };
                        
                            echo '<tr>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['attend_id'].'</a></td>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['date_admit'].'</a></td>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_p['firstName']." ". $row_p['lastName'].'</a></td>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_p['folderNo'].'</a></td>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$age.'</a></td>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$gender.'</a></td>
                                <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$clinic.'</a></td>
	                            <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$service_type.'</a></td>
	                            <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$sponsor_desc.'</a></td>
	                            <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$member_no.'</a></td>
	                            <td>';
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
                                    
                                echo '</td>
                            </tr>
                            <tr>
                                <td colspan="11">
                                    <a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$mgt_plan.'</a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11" class="action-td">
                                    <a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">Created by: '.$creator.' - '.$row['created_datetime'].'</a>
                                </td>
                            </tr>';
                        
                                }
                            }
                            else
                            {
                                    echo 'No Record Found';
                            };
                        
                    echo '</tbody>
                </table>
            </div>';
            ?>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/receipt_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>