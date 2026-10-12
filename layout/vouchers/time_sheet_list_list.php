<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    $time_sheet_id = $_SESSION['time_sheet_id'];
	$ts_branch_id = $_SESSION['ts_branch_id'];
	$ts_branch_name = $_SESSION['ts_branch_name'];
	$ts_date = $_SESSION['ts_date'];
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
                <p><?php echo $ts_branch_name.' - '.$ts_date;?></p>
                <div class="input-group">
                    <a href="#" data-toggle="" id="new_time_sheet_list_icon" 
                        data-id="<?php echo $time_sheet_id;?>" 
                        data-id1="<?php echo $ts_branch_id;?>"
                        data-id3="<?php echo $ts_date;?>"
                    >New Employee Time Sheet</a>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $query = "SELECT * FROM payroll_time_sheet_list WHERE time_sheet_id = '$time_sheet_id'";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="time_sheet_list_list_table">
                <table class="table table-hover table-bordered table-sm" id="time_sheetTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="action-td">Overtime</th>
                            <th class="action-td">Day 6 and 7</th>
                            <th class="action-td">Holidays</th>
                            <th class="action-td">Total</th>
                            <th class="action-td">Absent</th>
                            <th class="action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    $employee_id = $row['employee_id'];
                                    $query_employee = "SELECT * FROM payroll_employee WHERE employee_id = '$employee_id'";
                                    $query_run_employee = mysqli_query($con, $query_employee);
                                    if(!empty($query_run_employee) && mysqli_num_rows($query_run_employee) > 0)
                                    {
                                        $row_employee = mysqli_fetch_assoc($query_run_employee);
                                        $employee_name = $row_employee['first_name'].' '.$row_employee['last_name'];
                                    }
                                    else
                                    {
                                        $employee_name = 'Not Specified';
                                    };
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="#" id="btn_edit_time_sheet_list" data-id="<?php echo $row['time_sheet_list_id'];?>"><?php echo $employee_name;?></a>
                                        </td>
                                        <td class="action-td"><?php echo $row['normal_overtime'];?></td>
                                        <td class="action-td"><?php echo $row['day_67'];?></td>
                                        <td class="action-td"><?php echo $row['holidays'];?></td>
                                        <td class="action-td"><?php echo $row['normal_overtime'] + $row['day_67'] + $row['holidays'];?></td>
                                        <td class="action-td"><?php echo $row['absent'];?></td>
        	                            <td class="action-td">
        									<a href="#" id="btn_edit_time_sheet_list" data-id="<?php echo $row['time_sheet_list_id'];?>">Edit</a>
                                            |
        									<a href="#" id="btn_delete_time_sheet_list" data-id="<?php echo $row['time_sheet_list_id'];?>">Delete</a>
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
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/time_sheet_list_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>