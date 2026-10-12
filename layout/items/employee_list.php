<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
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
            max-height: 800px;
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
	                Employee List
	            </h4>
                <div class="input-group">
                    <?php
                        if($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR 
                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Employee'] == 'Yes'))
                        {
                            echo '<a href="#" data-toggle="" id="new_employee_icon">New Employee</a>';
                        };
                    ?>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		            <div class="input-group">
		            	<label for="employee_search_branch">Location</label>
                        <select class="form-control bg-light" name="employee_search_branch" id="employee_search_branch">
                            <?php
                            
                            if($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR 
                            ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 2))
                            {
                                echo '<option value="ALL">ALL</option>';
                                $company_id = $_SESSION['company_id'];
                                $sql="SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name ASC";
                                $result=mysqli_query($con,$sql);
                                while($row = mysqli_fetch_array($result))
                                {
                                    echo '<option value = "'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
                                };
                            }
                            else
                            {
                                    $branch_id = $_SESSION['branch_id'];
                                    $sql="SELECT * FROM branch WHERE branch_id = '$branch_id' ORDER BY branch_name ASC";
                                    $result=mysqli_query($con,$sql);
                                    while($row = mysqli_fetch_array($result))
                                    {
                                        if($branch_id == $row['branch_id'])
                                        {
                                            echo '<option value = "'.$row['branch_id'].'" selected="selected">'.$row['branch_name'].'</option>';
                                        }
                                        else
                                        {
                                            echo '<option value = "'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
                                        };
                                    };
                            }
                            ?>
                        </select>
		            </div>
		            <div class="input-group">
		            	<label for="employee_search_department">Department</label>
                        <select class="form-control bg-light" name="employee_search_department" id="employee_search_department">
                            <?php
                                echo '<option value="ALL">ALL</option>';
                                $company_id = $_SESSION['company_id'];
                                $sql="SELECT * FROM department WHERE company_id = '$company_id' ORDER BY department ASC";
                                $result=mysqli_query($con,$sql);
                                while($row = mysqli_fetch_array($result))
                                {
                                    echo '<option value = "'.$row['dept_id'].'">'.$row['department'].'</option>';
                                };
                            ?>
                        </select>
		            </div>
		        	<div class="input-group">
		            	<label for="employee_search_name">Name</label>
        				<input type="text" class="form-control border-0 small" name="employee_search_name" id="employee_search_name">
		            </div>
		            <div class="input-group">
		            	<label for="employee_search_status">Status</label>
							<select class="form-control bg-light" name="employee_search_status" id="employee_search_status"> 
	                        	<option value="Active">Active</option>
	                        	<option value="New_Employee">New_Employee</option>
	                        	<option value="Resigned">Resigned</option>
	                        	<option value="Dismissed">Dismissed</option>
	                        	<option value="Dead">Dead</option>
	                        	<option value="Dormant">Dormant</option>
	                        </select>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body scroll-card-body">
            <?php
                //if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 2)) 
                //{
                    $query = "SELECT * FROM payroll_employee WHERE status='Active' 
                    ORDER BY location ASC, first_name ASC";
                /*}
                else
                {
                    $query = "SELECT * FROM payroll_employee WHERE company_id = '$company_id' AND branch_id = '$branch_id' AND status='Active' 
                    ORDER BY location ASC, first_name ASC";
                };*/
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="employee_list_table">
                <table class="table table-hover table-bordered table-sm" id="employeeTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">S/No</th>
                            <th class="action-td">Name</th>
                            <th class="action-td">Staff No</th>
                            <th class="action-td">Position</th>
                            <th class="action-td">Branch</th>
                            <th class="action-td">Department</th>
                            <th class="action-td">Status</th>
                            <th class="action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            $i = 0;
                            if (!empty($query_run) && mysqli_num_rows($query_run) > 0)
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
                                        ?>
                                    <tr>
                                        <td class="action-td"><?php echo $i;?></td>
                                        <td>
                                            <?php
                                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' 
                                                OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id']!= 2 AND $_SESSION['Edit_Employee'] == 'Yes' AND $_SESSION['branch_id'] == $row['location'])
                                                OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id']== 2 AND $_SESSION['Edit_Employee'] == 'Yes'))
                                                {
                                                    echo '<a href="#" id="btn_edit_employee" data-id="'.$row['employee_id'].'">'.$row['first_name'].' '.$row['last_name'].'</a>';
                                                }
                                                else
                                                {
                                                    echo $row['first_name'].' '.$row['last_name'];
                                                };
                                            ?>
                                        </td>
                                        <td class="action-td"><?php echo $row['staff_id'];?></td>
                                        <td><?php echo $row['position'];?></td>
                                        <td><?php echo $branch_name;?></td>
                                        <td><?php echo $dept;?></td>
                                        <td class="action-td"><?php echo $row['status'];?></td>
        	                            <td class="action-td">
                                            <?php
                                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' 
                                                OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id']!= 2 AND $_SESSION['Edit_Employee'] == 'Yes' AND $_SESSION['branch_id'] == $row['location'])
                                                OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id']== 2 AND $_SESSION['Edit_Employee'] == 'Yes'))
                                                {
                                                    echo '<a href="#" id="btn_edit_employee" data-id="'.$row['employee_id'].'">Edit</a>';
                                                };
                                                    /*echo ' |
                                                    <a href="#" id="btn_view_employee_ppe" data-id="'.$row['employee_id'].'">View PPE</a>';*/
                                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' 
                                                OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id']!= 2 AND $_SESSION['Delete_Employee'] == 'Yes' AND $_SESSION['branch_id'] == $row['location'])
                                                OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id']== 2 AND $_SESSION['Delete_Employee'] == 'Yes'))
                                                {
                                                    echo ' |
                                                    <a href="#" id="btn_delete_employee" data-id="'.$row['employee_id'].'">Delete</a>';
                                                };
        	                            echo '</td>
                                    </tr>';
                                };
                                
                            ?>
                                <tr>
                                    <td colspan="7">
                                        TOTAL NO OF EMPLOYEES</a>
                                    </td>
                                    <td class="action-td"><?php echo $i;?></td>
                                </tr>
                                <?php
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/employee_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>