<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
?>
  <style type="text/css">
    .scroll-card-body {max-height: 700px;overflow-y: auto;}
    .amt-td {text-align:right;}
    .action-td {text-align:center;}
</style>
<div class="container-fluid">
    <?php 
        //if(isset($_SESSION['employee_time_sheet_start_date']))
        //{
            $company_id = $_SESSION['company_id'];
            $employee_id = $_SESSION['employee_time_sheet_employee_id'];
            $start_date = $_SESSION['employee_time_sheet_start_date'];
            $end_date = $_SESSION['employee_time_sheet_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);

            $sql_employee = "SELECT * FROM payroll_employee WHERE employee_id = '$employee_id'";
            $result_employee = mysqli_query($con,$sql_employee);
            $row_employee = mysqli_fetch_array($result_employee);
            ?>
            <table class="table table-hover table-bordered table-sm" id="employee_time_sheet_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="7"><H2><?php echo $row_company['trading_name'];?></H2></th>
                    </tr>
                    <tr>
                        <th colspan="7"><H6><?php echo '<strong>Name:</strong> '.$row_employee['first_name'].' '.$row_employee['last_name'];?></H6></th>
                    </tr>
                    <tr>
                        <th colspan="7"><H6><?php echo '<strong>Subject:</strong> TIME SHEET';?></H6></th>
                    </tr>
                    <tr>
                        <th colspan="7"><H6><?php echo '<strong>FROM:</strong> '.$start_date;?> <strong>TO:</strong> <?php echo $end_date;?></H6></th>
                    </tr>
                    <?php
                        $query = "SELECT * FROM payroll_time_sheet_list WHERE employee_id = '$employee_id' AND 
                        date BETWEEN '$start_date' AND '$end_date' ORDER BY date ASC";
                        $query_run = mysqli_query($con, $query);
                    ?>
                    <tr>
                        <th class="action-td">S/No</th>
                        <th class="action-td">Date</th>
                        <th class="action-td">Overtime</th>
                        <th class="action-td">Day 6 and 7</th>
                        <th class="action-td">Holidays</th>
                        <th class="action-td">Total</th>
                        <th class="action-td">Absent</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">
                    <?php
                        if (mysqli_num_rows($query_run) > 0)
                        {
                            $i = 0;
                            $normal_overtime = 0;
                            $day_67 = 0;
                            $holidays = 0;
                            $absent = 0;
                            $sum_total = 0;
                            while($row = mysqli_fetch_array($query_run))
                            {
                                $i++;
                                $time_sheet_id  = $row['time_sheet_id'];
                                $query_pts = "SELECT * FROM payroll_time_sheet WHERE time_sheet_id = '$time_sheet_id'";
                                $query_run_pts = mysqli_query($con, $query_pts);
                                $row_pts = mysqli_fetch_array($query_run_pts);

                                $normal_overtime = $normal_overtime + $row['normal_overtime'];
                                $day_67 = $day_67 + $row['day_67'];
                                $holidays = $holidays + $row['holidays'];
                                $absent = $absent + $row['absent'];
                                $total = $row['normal_overtime'] + $row['day_67'] + $row['holidays'];
                                $sum_total = $sum_total + $total;
                                echo '<tr>
                                    <td class="action-td">'.$i.'</td>
                                    <td class="action-td">';
                                    if($_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND 
                                    $_SESSION['user_type_id'] == 2) OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND 
                                    $_SESSION['user_type_id'] != 2 AND 
                                    $_SESSION['Edit_Time_Sheet'] == 'Yes'))
                                    {
                                        echo '<a href="#" id="btn_open_employee_time_sheet_list" data-id="'.$row['time_sheet_list_id'].'">'.$row_pts['date'].'</a>';
                                    }
                                    else
                                    {
                                        echo $row_pts['date'];
                                    };
                                    echo '</td>
                                    <td class="action-td">'.$row['normal_overtime'].'</td>
                                    <td class="action-td">'.$row['day_67'].'</td>
                                    <td class="action-td">'.$row['holidays'].'</td>
                                    <td class="action-td">'.$total.'</td>
                                    <td class="action-td">'.$row['absent'].'</td>
                                </tr>';
                            };
                            echo '<tr>
                                <th class="action-td" colspan="2">TOTAL</th>
                                <th class="action-td">'.$normal_overtime.'</th>
                                <th class="action-td">'.$day_67.'</th>
                                <th class="action-td">'.$holidays.'</th>
                                <th class="action-td">'.$sum_total.'</th>
                                <th class="action-td">'.$absent.'</th>
                            </tr>';
                        };
                    ?>
                </tbody>
            </table>
    <?php
        //};
    ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/time_sheet_list_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>