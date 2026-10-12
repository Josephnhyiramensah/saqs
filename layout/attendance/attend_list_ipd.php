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
                    Attendance List - IPD <!--| <a href="#" id="btn_auto_bill_ipd" >Auto_Bill IPD</a>-->
                </h4>
            </div>
            <div class="float-right">
                <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group" id="ipd_list_branch_filter">
                        <label>Branch</label>
		            	<select class="form-control" class="form-control bg-light border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="ipd_search_by_branch" id="ipd_search_by_branch"> 
                            <option value="ALL">ALL</option>
                            <?php
					        	$sql="SELECT * FROM branch ORDER BY branch_name ASC";
								$result_clinics_list=mysqli_query($con,$sql);
					            while($row_clinics_list=mysqli_fetch_array($result_clinics_list))
					            {
                                    echo '<option value = "'.$row_clinics_list['branch_id'].'">
                                        '.$row_clinics_list['branch_name'].'
                                    </option>';
					            };
					        ?>
				    	</select>
		            </div>
                    <div class="input-group">
                        <label>Name</label>
                        <input type="text" class="form-control border-0 small" aria-label="search_by_name" aria-describedby="basic-addon2" name="search_by_name" id="search_by_name">
		            	
                        <label>Ward</label>
                        <select class="form-control" class="form-control bg-light border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_ward" id="search_ward"> 
                            <option value="0">Please Select</option>
                            <?php
                                $sql="SELECT * FROM ward ORDER BY ward ASC";
                                $result_ward_list=mysqli_query($con,$sql);
                                while($row_ward_list=mysqli_fetch_array($result_ward_list))
                                {
                                    if($remember_state == true && $row_ward_list['ward_id'] == $search_ward)
                                    {
                                ?>
                                        <option value = "<?php echo($row_ward_list['ward_id'])?>" selected="selected">
                                            <?php echo($row_ward_list['ward']);?>
                                        </option>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                         <option value = "<?php echo($row_ward_list['ward_id'])?>">
                                            <?php echo($row_ward_list['ward']);?>
                                        </option>
                                <?php
                                    };
                                };
                            ?>
                        </select>
                    </div>
		        	<div class="input-group" hidden="true">
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
                    <div class="input-group" hidden="true">
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
                    <div class="input-group" hidden="true">
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
                    <div class="input-group" hidden="true">
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
                    <div class="input-group" hidden="true">
                        <button class="btn btn-primary" type="button" id="search_attend_btn">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">

            <?php
                
                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR 
                ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
                {
                    $query = "SELECT * FROM attendance WHERE (tos_id=2 AND outcome = 'on_admission') AND company_id = '$company_id'";
                }
                else
                {
                    $query = "SELECT * FROM attendance WHERE (tos_id=2 AND outcome = 'on_admission') AND 
                    company_id = '$company_id' AND (branch_id='$branch_id' OR share_status = 'SHARED')";
                };
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="ipd_attend_table">
                <table class="table table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td" width="10%">Folder No</th>
                            <th class="action-td" width="20%">Patient Name</th>
                            <th class="action-td" width="5%">Age</th>
                            <th class="action-td" width="5%">Gender</th>
                            <th class="action-td" width="10%">Attendance Date</th>
                            <th class="action-td" width="10%">Type of Service</th>
                            <th class="action-td" width="10%">Ward</th>
                            <th class="action-td" width="5%">Bed</th>
                            <th class="action-td" width="15%">Payment Type</th>
                            <th class="action-td" width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                                	$attend_id=$row['attend_id'];
                                    $patient_id=$row['patient_id'];
                                    $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                                    $query_run_p = mysqli_query($con, $query_p);
                                    $row_p=mysqli_fetch_assoc($query_run_p);
                        ?>
                            <tr style="background-color:#E4E1E0">
                                <td class="action-td">
                                    <a href="#" 
                                        id="btn_open_attend" 
                                        data-id="<?php echo $row['attend_id'];?>" 
                                        data-id2="<?php echo $row['patient_id'];?>"
                                    >
                                        <strong style="color:black;"><?php echo $row_p['folderNo'];?></strong>
                                    </a>
                                </td>
	                                <?php 

	                                    $gender_id=$row_p['gender'];
	                                    $query_g = "SELECT * FROM gender WHERE gender_id='$gender_id'";
	                                    $query_run_g = mysqli_query($con, $query_g);
	                                    $row_g=mysqli_fetch_assoc($query_run_g);
	                                ?>
                                <td>
                                    <a href="#" 
                                        id="btn_open_attend" 
                                        data-id="<?php echo $row['attend_id'];?>" 
                                        data-id2="<?php echo $row['patient_id'];?>">
                                        <strong style="color:black;"><?php echo $row_p['firstName']." ". $row_p['lastName']?></strong>
                                    </a>
                                </td>
                                <td class="action-td">
                                    <a href="#" 
                                        id="btn_open_attend" 
                                        data-id="<?php echo $row['attend_id'];?>" 
                                        data-id2="<?php echo $row['patient_id'];?>"
                                    >
                                        <strong style="color:black;"><?php echo $row['age'];?></strong>
                                    </a>
                                </td>
                                <td class="action-td">
                                    <a href="#" 
                                        id="btn_open_attend" 
                                        data-id="<?php echo $row['attend_id'];?>" 
                                        data-id2="<?php echo $row['patient_id'];?>">
                                        <strong style="color:black;"><?php echo $row_g['gender'];?></strong>
                                    </a>
                                </td>
                                <td class="action-td">
                                    <a href="#" 
                                        id="btn_open_attend" 
                                        data-id="<?php echo $row['attend_id'];?>" 
                                        data-id2="<?php echo $row['patient_id'];?>">
                                        <strong style="color:black;"><?php echo $row['date_admit'];?></strong>
                                    </a>
                                </td>
	                                <?php 
	                                    $query_tos = "SELECT * FROM type_of_service WHERE tos_id=2";
	                                    $query_run_tos = mysqli_query($con, $query_tos);
	                                    $row_tos=mysqli_fetch_assoc($query_run_tos);
	                                    
	                                    $query_wl = "SELECT * FROM wardlist WHERE attend_id='$attend_id' ORDER BY wardlist_id DESC";
	                                    $query_run_wl = mysqli_query($con, $query_wl);
	                                    $row_wl=mysqli_fetch_assoc($query_run_wl);

	                                    $ward_id=$row_wl['ward_id'];
	                                    $query_wd = "SELECT * FROM ward WHERE ward_id='$ward_id'";
	                                    $query_run_wd = mysqli_query($con, $query_wd);
	                                    $row_wd=mysqli_fetch_assoc($query_run_wd);

                                        $bed_id=$row_wl['bed_id'];
                                        $query_bd = "SELECT * FROM bed WHERE ward_id='$ward_id' AND bed_id='$bed_id'";
                                        $query_run_bd = mysqli_query($con, $query_bd);
                                        $row_bd=mysqli_fetch_assoc($query_run_bd);

	                                    $query_mg = "SELECT * FROM management_plan WHERE attend_id='$attend_id' ORDER BY mp_id DESC";
	                                    $query_run_mg = mysqli_query($con, $query_mg);
	                                    $row_mg=mysqli_fetch_assoc($query_run_mg);

                                        $query_pt = "SELECT * FROM payment_type WHERE attend_id='$attend_id' AND principal='Yes'";
                                        $query_run_pt = mysqli_query($con, $query_pt);
                                        if(isset($query_run_pt) && mysqli_num_rows($query_run_pt) > 0)
                                        {
                                            $row_pt = mysqli_fetch_array($query_run_pt);
                                            $sponsor_id = $row_pt['ledger_id'];
                                            $query_ptl = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
                                            $query_run_ptl = mysqli_query($con, $query_ptl);
                                            $row_ptl = mysqli_fetch_assoc($query_run_ptl);
                                            $sponsor_led = $row_ptl['ledger_desc'];
                                        }
                                        else
                                        {
                                            $sponsor_id = 0;
                                            $sponsor_led = 'Unspecified';
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

                                        $altered_by_id = $row['altered_by'];
                                        $query_cb = "SELECT * FROM users WHERE id='$altered_by_id'";
                                        $query_run_cb = mysqli_query($con, $query_cb);
                                        if(!empty($query_run_cb) && mysqli_num_rows($query_run_cb) > 0)
                                        {
                                            $row_cb = mysqli_fetch_assoc($query_run_cb);
                                            $alter = $row_cb['first_name'].' '.$row_cb['last_name'];
                                        }
                                        else
                                        {
                                            $alter = 'Not Specified';
                                        };

                                        $created_branch_id = $row['branch_id'];
                                        $query_cb = "SELECT * FROM branch WHERE branch_id='$created_branch_id'";
                                        $query_run_cb = mysqli_query($con, $query_cb);
                                        if(!empty($query_run_cb) && mysqli_num_rows($query_run_cb) > 0)
                                        {
                                            $row_cb = mysqli_fetch_assoc($query_run_cb);
                                            $created_branch = $row_cb['branch_name'];
                                        }
                                        else
                                        {
                                            $created_branch = 'Not Specified';
                                        };
	                                ?>
                                <td class="action-td">
                                    <a href="#" 
                                        id="btn_open_attend" 
                                        data-id="<?php echo $row['attend_id'];?>" 
                                        data-id2="<?php echo $row['patient_id'];?>">
                                        <strong style="color:black;"><?php echo $row_tos['description'];?></strong>
                                    </a>
                                </td>
                                <td class="action-td">
                                    <a href="#" 
                                        id="btn_open_attend" 
                                        data-id="<?php echo $row['attend_id'];?>" 
                                        data-id2="<?php echo $row['patient_id'];?>"
                                    >
                                        <strong style="color:black;"><?php echo $row_wd['ward'];?></strong>
                                    </a>
                                </td>
                                <td class="action-td">
                                    <a href="#" 
                                        id="btn_open_attend" 
                                        data-id="<?php echo $row['attend_id'];?>" 
                                        data-id2="<?php echo $row['patient_id'];?>">
                                        <strong style="color:black;"><?php echo $row_bd['bed'];?></strong>
                                    </a>
                                </td>
                                <td><a href="#" 
                                    id="btn_open_attend" 
                                    data-id="<?php echo $row['attend_id'];?>" 
                                    data-id2="<?php echo $row['patient_id'];?>">
                                    <strong style="color:black;"><?php echo $sponsor_led;?></strong>
                                    </a>
                                </td>
                                <td class="action-td">
                                    <?php 
                                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Attendance_Cash_Statement'] == 'Yes')) 
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

                                            echo ' | <a href="#" 
                                            id="attend_print_attend_sheet" 
                                            data-id="'.$row['attend_id'].'" 
                                            data-id1="'.$row_p['firstName']." ". $row_p['lastName'].'"
                                            data-id2="'.$row['patient_id'].'">Print Attend.</a>';
                                        };
                                    
                                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
                                        {
                                            echo ' | <a href="#" 
                                            id="btn_share_attendance" 
                                            data-attend_id="'.$row['attend_id'].'" 
                                            data-share_status="'.$row['share_status'].'">';
                                            if($row['share_status'] == 'SHARED')
                                            {
                                                echo 'UNSHARE';
                                            }
                                            else
                                            {
                                                echo 'SHARE';
                                            };
                                            echo '</a>';
                                        };
                                         if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Attendance'] == 'Yes')) 
                                        {
                                            echo ' | <a href="#" id="btn_delete_attend" data-id="'.$row['attend_id'].'">Delete Attend. Sht.</a>';
                                        };
                                    ?>
                                </td>
                            </tr>
								<?php
                                        if (
											$_SESSION['user_type'] == 'Ultra_Super_User' OR 
											$_SESSION['user_type'] == 'Super_User' OR 
											($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Mgt_Plan'] == 'Yes')) 
										{
											echo '<tr>
                                                <td style="border-bottom:none"><i><strong>
                                                    <a href="#" id="btn_open_attend" 
                                                    data-id="'.$row['attend_id'].'" 
                                                    data-id2="'.$row['patient_id'].'">';
                                                    if(isset($row_mg['date'])){echo $row_mg['date'];}else{echo 'No plan yet';};
                                                    echo'</i></a></strong></td>
                                                <td style="border-bottom:none"><i><strong>
                                                    <a href="#" id="btn_open_attend" 
                                                    data-id="'.$row['attend_id'].'" 
                                                    data-id2="'.$row['patient_id'].'">';
                                                    if(isset($row_mg['initials'])){echo 'Doctor:'.$row_mg['initials'];}else{echo 'No plan yet';};
                                                    echo'</i></a></strong></td>
                                                <td colspan=8 style="border-bottom:none"><strong>
                                                    <a href="#" id="btn_open_attend" 
                                                    data-id="'.$row['attend_id'].'" 
                                                    data-id2="'.$row['patient_id'].'"><i>';
                                                    if(isset($row_mg['mgt_notes'])){echo $row_mg['mgt_notes'];}else{echo 'No plan yet';};
                                                    echo'</i></a></strong></td>
                                            </tr>';
										};
                            
                            echo '<tr>
                                <td colspan="10" class="action-td">
                                    <a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">
                                    <small></strong>Created Branch:'.$created_branch.': - Created by:'.$creator.' - '.$row['created_datetime'].': - Altered by:'.$alter.' - '.$row['altered_datetime'].'</strong></small></a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=10 style="border-right:none;border-left:none;border-top:none;border-width: medium;"></td>
                            </tr>';
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
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/receipt_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>