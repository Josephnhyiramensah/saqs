<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
    $date_start = date("Y-m-01");
    $month_start = date("Y-m-01", strtotime($date_start));
    $month_end = date("Y-m-t", strtotime($date_start));
	$user_id = $_SESSION['user_id'];
	$time = date('H-i-sa');
    $company_id = $_SESSION['company_id'];
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
            max-height: 700px;
            overflow-y: auto;
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
	                Time Sheet List
	            </h4>
                <div class="input-group">
                    <?php
                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Time_Sheet'] == 'Yes')) 
                        {
                            echo '<a href="#" data-toggle="" id="new_time_sheet_icon">New Time Sheet</a>';
                        };
                    ?>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <label for="time_sheet_search_from">From</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="time_sheet_search_from" id="time_sheet_search_from">
                    </div>
                    <div class="input-group">
                        <label for="time_sheet_search_to">To</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="time_sheet_search_to" id="time_sheet_search_to">
                    </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                //$query = "SELECT * FROM payroll_time_sheet WHERE company_id = '$company_id' ORDER BY date DESC";
                /*$query_branch_count = "SELECT * FROM branch WHERE company_id = '".$_SESSION['company_id']."'";
                $query_run_branch_count = mysqli_query($con, $query_branch_count);
                if (mysqli_num_rows($query_run_branch_count) > 1)
                {*/
                    if($_SESSION['user_type'] == 'Ultra_Super_User' OR 
                    $_SESSION['user_type'] == 'Super_User' OR 
                    ($_SESSION['user_type'] == 'Normal_User' AND 
                    $_SESSION['user_type_id'] == 2))
                    {
                        $query = "SELECT * FROM payroll_time_sheet WHERE company_id = '$company_id' 
                        AND date BETWEEN '$month_start' AND '$month_end'  ORDER BY date DESC, time_sheet_id ASC";
                    }
                    else if(($_SESSION['user_type'] == 'Normal_User' AND 
                    $_SESSION['user_type_id'] != 2 ))
                    {
                        $query = "SELECT * FROM payroll_time_sheet WHERE company_id = '$company_id'  
                        AND location = '".$_SESSION['branch_id']."' AND date BETWEEN '$month_start' AND '$month_end'  ORDER BY date DESC, time_sheet_id ASC";
                    };
                /*}
                else
                {
                };*/
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="time_sheet_list_table">
                <table class="table table-hover table-bordered table-sm" id="time_sheetTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">Date</th>
                            <th class="action-td">Branch</th>
                            <!--<th class="action-td">Department</th>-->
                            <th class="action-td">No of Employees</th>
                            <th class="action-td">Overtime</th>
                            <th class="action-td">Day 6 and 7</th>
                            <th class="action-td">Holidays</th>
                            <th class="action-td">Approval Status</th>
                            <th class="action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    $branch_id = $row['location'];
                                    $query_branch = "SELECT * FROM branch WHERE branch_id = '$branch_id'";
                                    $query_run_branch = mysqli_query($con, $query_branch);
                                    if(!empty($query_run_branch) && mysqli_num_rows($query_run_branch) > 0)
                                    {
                                        $row_branch = mysqli_fetch_assoc($query_run_branch);
                                        $branch_name = $row_branch['branch_name'];
                                    }
                                    else
                                    {
                                        $branch_name = 'Not Specified';
                                    };

                                    $dept_id = $row['dept_id'];
                                    $query_dept = "SELECT * FROM department WHERE dept_id = '$dept_id'";
                                    $query_run_dept = mysqli_query($con, $query_dept);
                                    if(!empty($query_run_dept) && mysqli_num_rows($query_run_dept) > 0)
                                    {
                                        $row_dept = mysqli_fetch_assoc($query_run_dept);
                                        $dept_name = $row_dept['department'];
                                    }
                                    else
                                    {
                                        $dept_name = 'Not Specified';
                                    };

                                    $time_sheet_id = $row['time_sheet_id'];
                                    $query_ts = "SELECT SUM(normal_overtime) AS overtime, SUM(day_67) AS day_67, 
                                    SUM(holidays) AS holidays FROM payroll_time_sheet_list WHERE time_sheet_id = '$time_sheet_id'";
                                    $query_run_ts = mysqli_query($con, $query_ts);
                                    if(!empty($query_run_ts) && mysqli_num_rows($query_run_ts) > 0)
                                    {
                                        $row_ts = mysqli_fetch_assoc($query_run_ts);
                                        $overtime = $row_ts['overtime'];
                                        $day_67_overtime = $row_ts['day_67'];
                                        $holidays = $row_ts['holidays'];
                                    }
                                    else
                                    {
                                        $overtime = 0;
                                        $day_67_overtime = 0;
                                        $holidays = 0;
                                    };
                                    $query_ts = "SELECT * FROM payroll_time_sheet_list WHERE time_sheet_id = '$time_sheet_id'";
                                    $query_run_ts = mysqli_query($con, $query_ts);
                                    if(!empty($query_run_ts) && mysqli_num_rows($query_run_ts) > 0)
                                    {
                                        $no_of_empoyees = mysqli_num_rows($query_run_ts);
                                    }
                                    else
                                    {
                                        $no_of_empoyees = 0;
                                    };

                                    if(($row['authorized_status']=='Authorized' || $row['authorized_status_hr']=='Authorized') && $row['approved_status']=='Pending'){echo '<tr style="background-color:yellow; color:black">';}
                                    else if(($row['authorized_status']=='Authorized' || $row['authorized_status_hr']=='Authorized') && $row['approved_status']=='Approved'){echo '<tr style="background-color:red; color:black">';}
                                    else if(($row['authorized_status']=='Pending' || $row['authorized_status_hr']=='Pending') && $row['approved_status']=='Pending'){echo '<tr>';}
                                    else if(($row['authorized_status']=='Pending' || $row['authorized_status_hr']=='Pending') && $row['approved_status']=='Approved'){echo '<tr style="background-color:orange; color:black">';}
                                    ?>
                                        <td class="action-td">
                                            <?php 
                                                /*if (
                                                    $_SESSION['user_type'] == 'Ultra_Super_User' OR
                                                    $_SESSION['user_type'] == 'Super_User' OR
                                                    ($_SESSION['user_type'] == 'Normal_User' AND
                                                    $_SESSION['user_type_id'] == 2) OR 
                                                    ($_SESSION['user_type'] == 'Normal_User' AND 
                                                    $_SESSION['Edit_Time_Sheet'] == 'Yes' AND 
                                                    $row['created_by']==$user_id AND $row['date']==$date_today))
                                                {
                                                    if($row['pay_sheet_id'] =='' || $row['pay_sheet_id'] ==0)
                                                    {
                                                        echo '<a href="#" id="btn_edit_time_sheet"
                                                            data-id="'.$row['time_sheet_id'].'" 
                                                            data-id1="'.$_SESSION['user_id'].'" 
                                                            data-id2="'.$row['created_by'].'"
                                                            data-id3="'.$row['authorized_by'].'"
                                                            data-id4="'.$row['authorized_status'].'"
                                                            data-id5="'.$row['approved_by'].'"
                                                            data-id6="'.$row['approved_status'].'"
                                                            data-id7="'.$row['pay_sheet_id'].'"
                                                        >'.$row['date'].'</a>';
                                                    }
                                                    else
                                                    {
                                                        echo $row['date'];
                                                    };
                                                }
                                                else
                                                {
                                                    echo $row['date'];
                                                };*/
                                                echo $row['date'];
                                            ?>
                                        </td>
                                        <td><?php echo $branch_name;?></td>
                                        <!--<td><?php //echo $dept_name;?></td>-->
                                        <td class="action-td"><?php echo $no_of_empoyees;?></td>
                                        <td class="action-td"><?php echo $overtime;?></td>
                                        <td class="action-td"><?php echo $day_67_overtime;?></td>
                                        <td class="action-td"><?php echo $holidays;?></td>
                                        <td class="action-td"><?php echo $row['approved_status'];?></td>
        	                            <td class="action-td">
        									<!--<a href="#" id="btn_display_time_sheet" 
                                                data-id="<?php //echo $row['time_sheet_id'];?>"
                                                data-id1="<?php //echo $row['location'];?>"
                                                data-id2="<?php //echo $row['dept_id'];?>"
                                                data-id3="<?php //echo $branch_name;?>"
                                                data-id4="<?php //echo $dept_name;?>"
                                                data-id5="<?php //echo $row['date'];?>"
                                            >Display</a>-->
                                            <?php
                                                if (
                                                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                                    $_SESSION['user_type'] == 'Super_User' OR 
                                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 2) OR 
                                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 9 AND $_SESSION['branch_id']==$row['location']) OR 
                                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Time_Sheet'] == 'Yes' AND 
                                                    $row['created_by']==$user_id /*AND $row['date']==$date_today*/)) 
                                                {
                                                    if(!isset($row['pay_sheet_id']) || $row['pay_sheet_id'] =='' || $row['pay_sheet_id'] ==0)
                                                    {
                                                        $pay_sheet_id = 0;
                                                        echo '<a href="#" id="btn_edit_time_sheet"
                                                            data-id="'.$row['time_sheet_id'].'" 
                                                            data-id1="'.$_SESSION['user_id'].'" 
                                                            data-id2="'.$row['created_by'].'"
                                                            data-id3="'.$row['authorized_by'].'"
                                                            data-id4="'.$row['authorized_status'].'"
                                                            data-id5="'.$row['approved_by'].'"
                                                            data-id6="'.$row['approved_status'].'"
                                                            data-id7="'.$pay_sheet_id.'"
                                                        >Edit</a>';
                                                    };
                                                };
                                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                                $_SESSION['user_type'] == 'Super_User' OR 
                                                ($_SESSION['user_type'] == 'Normal_User' AND 
                                                $_SESSION['Edit_Time_Sheet'] == 'Yes' AND 
                                                $row['created_by']==$user_id AND $row['date']==$date_today)) 
                                                {
                                                    if(!isset($row['pay_sheet_id']) || $row['pay_sheet_id'] == '' || $row['pay_sheet_id'] ==0)
                                                    {
                                                        echo ' | <a href="#" id="btn_delete_time_sheet" 
                                                        data-id="'.$row['time_sheet_id'].'">Delete</a>';
                                                    };
                                                };
                                                //CREATOR
                                                    $created_id = $row['created_by'];
                                                    $query_creator = "SELECT * FROM users WHERE id='$created_id'";
                                                    $result_creator = mysqli_query($con,$query_creator);
                                                    if(!empty($result_creator) && mysqli_num_rows($result_creator) > 0)
                                                    {
                                                        $row_creator = mysqli_fetch_assoc($result_creator);
                                                        $creator = 'Entered By:'.$row_creator['first_name'].' '.$row_creator['last_name'].': '.$row['created_datetime'];
                                                    }
                                                    else
                                                    {
                                                        $creator = 'Not Specified';
                                                    };
            
                                                //ALTER
                                                    $altered_id = $row['altered_by'];
                                                    $query_alter = "SELECT * FROM users WHERE id='$altered_id'";
                                                    $result_alter = mysqli_query($con,$query_alter);
                                                    if(!empty($result_alter) && mysqli_num_rows($result_alter) > 0)
                                                    {
                                                        $row_alter = mysqli_fetch_assoc($result_alter);
                                                        $alter = 'Altered By:'.$row_alter['first_name'].' '.$row_alter['last_name'].': '.$row['altered_datetime'];
                                                    }
                                                    else
                                                    {
                                                        $alter = 'Not Specified';
                                                    };
            
                                                //BRANCH
                                                    $voucher_branch_id = $row['branch_id'];
                                                    $query_branch = "SELECT * FROM branch WHERE branch_id='$voucher_branch_id'";
                                                    $result_branch = mysqli_query($con,$query_branch);
                                                    if(!empty($result_branch) && mysqli_num_rows($result_branch) > 0)
                                                    {
                                                        $row_branch = mysqli_fetch_assoc($result_branch);
                                                        $voucher_branch = $row_branch['branch_name'];
                                                    }
                                                    else
                                                    {
                                                        $voucher_branch = 'Not Specified';
                                                    };
                                          
                                          echo '</td>
                                      </tr>
                                      <tr>
                                          <td class = "action-td" colspan="8"><small>Branch:'.$voucher_branch.': '.$creator.' '.$alter.'</small>
                                          </td>
                                      </tr>';
                                }
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/time_sheet_new_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/time_sheet_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>