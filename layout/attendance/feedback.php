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
    $current_time = date('H:i:s');
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
    .amt-td {
            text-align:right;
          }
    .action-td {
            text-align:center;
          }
  </style>
<div class="container-fluid scroll-card-body">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Feedback
	            </h4>
                <?php
                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Patient'] == 'Yes')) 
                    {
                        echo '<a href="#" data-toggle="" id="new_feedback">New Feedback</a>';
                    };
                ?>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search" id="opd_attend_search_form">
		        	<!--<div class="input-group">
                        <label>Search</label>
                        <input type="text" class="form-control border-0 small" aria-label="search_by_name" aria-describedby="basic-addon2" name="search_by_name" id="search_by_name">
		            </div>-->
		            <div class="input-group">
		            	<label>From</label>
                        <input type="date" class="form-control bg-light border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_feedback_from" id="search_feedback_from">
                    </div>
		            <div class="input-group">
		            	<label>To</label>
                        <input type="date" class="form-control bg-light border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_feedback_to" id="search_feedback_to">
                    </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $query = "SELECT * FROM feedback WHERE date = CURDATE() AND company_id = '$company_id' ORDER BY date";
                $query_run = mysqli_query($con, $query);
            
                echo '<div class="table-responsive" id="feedback_table_div">
                    <table class="table table-hover table-bordered table-sm" id="feedback_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="action-td">Date</th>
                                <th class="action-td">Feedback</th>
                                <th class="action-td">Status</th>
                                <th class="action-td">Remark</th>
                                <th class="action-td">Patient</th>
                                <th class="action-td">User</th>
                                <th class="action-td">Action</th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body">';
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    if(isset($row['patient_id']) && $row['patient_id'] !=0)
                                    {
                                        $patient_id = $row['patient_id'];
                                        $query_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
                                        $query_run_patient = mysqli_query($con, $query_patient);
                                        $row_patient = mysqli_fetch_assoc($query_run_patient);
                                        $patient_name = $row_patient['firstName'].''.$row_patient['lastName'];
                                    }
                                    else
                                    {
                                        $patient_name = 'Not Specified';
                                    };
                                    if(isset($row['created_by']))
                                    {
                                        $user_id = $row['created_by'];
                                        $query_user = "SELECT * FROM users WHERE id = '$user_id'";
                                        $query_run_user = mysqli_query($con, $query_user);
                                        $row_user = mysqli_fetch_assoc($query_run_user);
                                        $username = $row_user['first_name'].''.$row_user['last_name'];
                                    }
                                    else
                                    {
                                        $username = 'Not Specified';
                                    };
                                    echo '<tr>
                                        <td class="action-td">'.$row['date'].'</td>
                                        <td>'.$row['feedback'].'</td>
                                        <td class="action-td">'.$row['status'].'</td>
                                        <td>'.$row['remarks'].'</td>
                                        <td>'.$patient_name.'</td>
                                        <td>'.$username.'</td>
                                        <td>';
                                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Patient'] == 'Yes')) 
                                            {
                                                    echo '<a href="#" id="btn_edit_feedback" data-id="'.$row['feedback_id'].'">Edit</a>';
                                            };
                                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Patient'] == 'Yes')) 
                                            {
                                                echo ' | <a href="#" id="btn_delete_feedback" 
                                                data-id="'.$row['feedback_id'].'"> Delete</a>';
                                            };
                                        echo '</td>
                                    </tr>';
                                }
                            };
                        echo '</tbody>
                    </table>';
                ?>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/receipt_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/feedback_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>