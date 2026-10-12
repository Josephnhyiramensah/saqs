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
            $branch_id = $_SESSION['employee_time_sheet_branch_id'];
            $start_date = $_SESSION['employee_time_sheet_start_date'];
            $end_date = $_SESSION['employee_time_sheet_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);

            $sql_branch = "SELECT * FROM branch WHERE branch_id = '$branch_id'";
            $result_branch = mysqli_query($con,$sql_branch);
            $row_branch = mysqli_fetch_array($result_branch);
            ?>
            <table class="table table-hover table-bordered table-sm" id="employee_time_sheet_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="7"><H2><?php echo $row_company['trading_name'];?></H2></th>
                    </tr>
                    <tr>
                        <th colspan="7"><H6><?php echo '<strong>Branch:</strong> '.$row_branch['branch_name'];?></H6></th>
                    </tr>
                    <tr>
                        <th colspan="7"><H6><?php echo '<strong>Subject:</strong> TIME SHEET';?></H6></th>
                    </tr>
                    <tr>
                        <th colspan="7"><H6><?php echo '<strong>FROM:</strong> '.$start_date;?> <strong>TO:</strong> <?php echo $end_date;?></H6></th>
                    </tr>
                    <tr>
                        <th class="action-td">S/No</th>
                        <th class="action-td">Employee Name</th>
                        <th class="action-td">Overtime</th>
                        <th class="action-td">Day 6 and 7</th>
                        <th class="action-td">Holidays</th>
                        <th class="action-td">Total</th>
                        <th class="action-td">Absent</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">
                    <?php
                        $i = 1;
                        $normal_overtime = 0;
                        $day_67 = 0;
                        $holidays = 0;
                        $absent = 0;
                        $sum_total = 0;
                        $sql_loc_list = "SELECT * FROM payroll_employee WHERE location = '$branch_id'";
                        $result_loc_list = mysqli_query($con,$sql_loc_list);

                        while($row_loc_list = mysqli_fetch_array($result_loc_list))
                        {
                            $employee_id = $row_loc_list['employee_id'];
                            $sql_employee = "SELECT * FROM payroll_employee WHERE employee_id = '$employee_id'";
                            $result_employee = mysqli_query($con,$sql_employee);
                            $row_employee = mysqli_fetch_array($result_employee);
                            
                            $query = "SELECT SUM(normal_overtime) AS normal_overtime, 
                            SUM(day_67) AS day_67, SUM(holidays) AS holidays, SUM(absent) AS days_absent 
                            FROM payroll_time_sheet_list WHERE employee_id = '$employee_id' AND date BETWEEN '$start_date' AND '$end_date'";
                            $query_run = mysqli_query($con, $query);

                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_array($query_run))
                                {
                                    $normal_overtime = $normal_overtime + $row['normal_overtime'];
                                    $day_67 = $day_67 + $row['day_67'];
                                    $holidays = $holidays + $row['holidays'];
                                    $absent = $absent + $row['days_absent'];
                                    $total = $row['normal_overtime'] + $row['day_67'] + $row['holidays'];
                                    $sum_total = $sum_total + $total;
                                    if($total > 0)
                                    {
                                        echo '<tr>
                                            <td class="action-td">'.$i.'</td>
                                            <td>
                                                <a href="#" id="employee_time_sheet_from_branch_summary" 
                                                data-id="'.$employee_id.'"
                                                data-id1="'.$start_date.'"
                                                data-id2="'.$end_date.'">'.$row_employee['first_name'].' '.$row_employee['last_name'].'</a>
                                            </td>
                                            <td class="action-td">'.$row['normal_overtime'].'</td>
                                            <td class="action-td">'.$row['day_67'].'</td>
                                            <td class="action-td">'.$row['holidays'].'</td>
                                            <td class="action-td">'.$total.'</td>
                                            <td class="action-td">'.$row['days_absent'].'</td>
                                        </tr>';
                                        $i++;
                                    };
                                };
                            };
                        }
                        echo '<tr>
                            <th class="action-td" colspan="2">TOTAL</th>
                            <th class="action-td">'.$normal_overtime.'</th>
                            <th class="action-td">'.$day_67.'</th>
                            <th class="action-td">'.$holidays.'</th>
                            <th class="action-td">'.$sum_total.'</th>
                            <th class="action-td">'.$absent.'</th>
                        </tr>';
                    ?>
                </tbody>
            </table>
    <?php
        //};
    ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>