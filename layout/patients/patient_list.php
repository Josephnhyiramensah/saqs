<?php
    //session_start(); 
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/functions.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    
    function ageCalculator($dob)
    {
        if(!empty($dob)){
            $birthdate = new DateTime($dob);
            $today   = new DateTime('today');
            $age = $birthdate->diff($today)->y;
            return $age;
        }else{
            return 0;
        }
    }
?>
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
	                Patient List
	            </h4>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">
		                <a href="patient_setup.php">
		                  <i class="fas fa-user-plus fa-lg"></i>
                           New Patient
		                </a>
		            </div>
		            <div class="input-group">
                    <select class="form-control" name="patient_search_type" id="patient_search_type">
                        <option value="First_Name">First_Name</option>
                        <option value="Other_Name">Other_Name</option>
                        <option value="Telephone">Telephone</option>
                        <option value="Folder_No">Folder_No</option>
                        <option value="Membership_No">Membership_No</option>
                    </select>
		              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." 
                      aria-label="Search" aria-describedby="basic-addon2" name="search_patient" id="search_patient">
		              <div class="input-group-append">
		                <button class="btn btn-primary" type="button"><i class="fas fa-search fa-sm"></i></button>
		              </div>
		            </div>
		        	<div class="input-group">
                        <?php
                            if($_SESSION['user_type'] == 'Ultra_Super_User') 
                            {
                                echo '<a href="#" id="btn_import_patient">Import Patient</a>';
                            };

                            if($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
                            {
                                echo ' - | -  <a href="patient_export.php" id="patient_export_btn">Export Patients</a> - | -  <a href="#" id="patient_merge_folder_btn">Merge Folder</a>';
                            };
                        ?>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $query = "SELECT * FROM patients LIMIT 100";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="patient_table">
                <table class="table table-hover table-bordered table-sm table-condensed" id="patientTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">Folder No</th>
                            <th class="action-td">Patient Name</th>
                            <th class="action-td">Date of Birth</th>
                            <th class="action-td">Age</th>
                            <th class="action-td">Gender</th>
                            <th class="action-td">Telephone</th>
                            <th class="action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                        ?>
                            <tr>
	                            <td class="action-td"><?php echo $row['folderNo'];?></td>
	                            <td>
                                    <?php
                                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Patient'] == 'Yes')) 
                                        {
                                             echo '<a href="#" id="btn_edit_patient" data-id1="'.$row['patient_id'].'">'.$row['firstName']." ". $row['lastName'].'</a>';
                                        }
                                        else
                                        {
                                            echo $row['firstName'].' '.$row['lastName'];
                                        };
                                    ?>
                                </td>
	                            <td class="action-td"><?php echo $row['DOB'];?></td>
	                            <td class="action-td"><?php echo ageCalculator($row['DOB']).' yr(s)';?></td>
                                <?php
                                    $gender = $row['gender'];
                                    $query_gender = "SELECT gender FROM gender WHERE gender_id='$gender'";
                                    $query_run_gender = mysqli_query($con, $query_gender);
                                    $row_gender=mysqli_fetch_assoc($query_run_gender);
                                    if (isset($row_gender["gender"])) {
                                        $gender = $row_gender["gender"];
                                    } else {
                                        $gender = 'Not Specified';
                                    };
                                ?>
	                            <td class="action-td"><?php echo $gender;?></td>
                                <td class="action-td"><?php echo $row['telephone'];?></td>
	                            <td class="action-td">

                                <?php
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Attendance'] == 'Yes')) 
                                    {
							             echo '<a href="#" id="btn_new_attend" data-id="'.$row['patient_id'].'"> New Attend. Sht</a>';
                                    };
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Patient_Folder'] == 'Yes')) 
                                    {
                                      echo' | <a href="#" id="nav_myfolder_pl" data-id="'.$row['patient_id'].'"> Patient Folder</a>';
                                    };
                                     if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Patient_Cash_Statement'] == 'Yes')) 
                                    {
                                         echo ' | <a href="#" id="btn_cash_statement_patient" data-id="'.$row['patient_id'].'"> Cash Stat.</a>';
                                    };
                                     if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Attendance'] == 'Yes')) 
                                    {
                                         echo ' | <a href="#" id="btn_delete_patient" 
                                         data-id="'.$row['patient_id'].'" 
                                         data-id1="'.$row['firstName'].' '.$row['lastName'].'"> Delete Patient</a>';
                                    };
                                ?>
	                            </td>
                            </tr>
                        <?php
                                }
                            }
                            else
                            {
                                    echo 'Data Not Found';
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/patients/patient_edit_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/patients/patient_create_attend_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/patients/patient_attend_dialogue_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/patients/merge_patient_folder_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/patients/patient_import_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>