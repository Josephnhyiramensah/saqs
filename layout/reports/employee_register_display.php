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
        //if(isset($_SESSION['employee_register_start_date']))
        //{
            $company_id = $_SESSION['company_id'];
            $location_id = $_SESSION['employee_register_branch_id'];
            $dept_id = $_SESSION['employee_register_department'];
            $status = $_SESSION['employee_register_status'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);

            if($location_id == 'ALL')
            {
                if($dept_id == 'ALL')
                {
                    $query = "SELECT * FROM payroll_employee WHERE status = '$status' ORDER BY location ASC, dept_id ASC";
                }
                else
                {
                    $query = "SELECT * FROM payroll_employee WHERE status = '$status' AND dept_id='$dept_id' ORDER BY location ASC, dept_id ASC";
                };
            }
            else
            {
                if($dept_id == 'ALL')
                {
                    $query = "SELECT * FROM payroll_employee WHERE status = '$status' AND location='$location_id' ORDER BY location ASC, dept_id ASC";
                }
                else
                {
                    $query = "SELECT * FROM payroll_employee WHERE status = '$status' AND location='$location_id' AND dept_id='$dept_id' ORDER BY location ASC, dept_id ASC";
                };
            };
				$query_run = mysqli_query($con, $query);
            ?>
            <table class="table table-hover table-bordered table-sm" id="employeeTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" colspan="7"><H2><?php echo $row_company['trading_name'];?></H2></th>
                        </tr>
                        <tr>
                            <th class = "action-td" colspan="7"><H4>EMPLOYEE REGISTER</H4></th>
                        </tr>
                        <tr>
                            <th class="action-td">S/No</th>
                            <th class="action-td">Name</th>
                            <th class="action-td">Staff No</th>
                            <th class="action-td">Ghanacard</th>
                            <th class="action-td">Branch</th>
                            <th class="action-td">Department</th>
                            <th class="action-td">Status</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                    <?php
							$i=0;
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
									$i++;
                                    $dept_id = $row['dept_id'];
                                    $query_dept = "SELECT * FROM department WHERE dept_id = '$dept_id' ORDER BY department ASC";
                                    $query_run_dept = mysqli_query($con, $query_dept);
                                    if(!empty($query_run_dept) && mysqli_num_rows($query_run_dept) > 0)
                                    {
                                        $row_dept = mysqli_fetch_assoc($query_run_dept);
                                        $dept = $row_dept['department'];
                                    }
                                    else
                                    {
                                        $dept = 'Not Specified';
                                    };

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
                    
                                    echo '<tr>
										<td class="action-td">'.$i.'</td>
                                        <td>'. $row['first_name'].' '.$row['last_name'].'</td>
                                        <td>'.$row['staff_id'].'</td>
                                        <td>'.$row['ghanacard'].'</td>
                                        <td>'.$branch_name.'</td>
                                        <td>'.$dept.'</td>
                                        <td>'.$row['status'].'</td>
        	                        </tr>';
                                }
                    
								echo '<tr>
									<td colspan="5">
										TOTAL NO OF EMPLOYEES</a>
									</td>
									<td>'.$i.'</td>
									<td>
									</td>
								</tr>';
                            };
                    ?>
                </tbody>
            </table>
    <?php
        //};
    ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>