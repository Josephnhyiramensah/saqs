<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    if (isset($_SESSION['user_super_id'])) {
        $user_super_id = $_SESSION['user_super_id'];
        $name = $_SESSION['full_name'];
    };
?>
<input type='hidden' id='session_user_super_id' value="<?php echo $user_super_id;?>">
<style type="text/css">
    input {border-top-style: hidden;border-right-style: hidden;border-left-style: hidden;border-bottom-style: hidden;background-color: #ffffff;}
    .scroll-card-body {max-height: 700px;overflow-y: auto;}
    .amt-td {text-align:right;}
    .action-td {text-align:center;}
  </style>
<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Department List
	            </h4>
                <div class="input-group">
                    <?php
                        //if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Department'] == 'Yes')) 
                        //{
                            echo '<a href="#" data-toggle="" id="new_dept_icon">New Department</a>';
                        //};
                    ?>
                </div>
            </div>
            <div class="float-right">
		        <!--<form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">

                    <a href="#" data-toggle="" id="new_dept_icon"><i class="fas fa-building"></i></a>

		            </div>
		        </form>-->
	        </div>
        </div>
        <div class="card-body">
            <?php
                /*if($_SESSION['user_type'] == 'Ultra_Super_User')
                {
                    $query = "SELECT * FROM dept";
                }
                else
                {*/
                    $query = "SELECT * FROM department WHERE company_id = '".$_SESSION['company_id']."'";
                //};
                
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="dept_list_table">
                <table class="table table-hover table-bordered table-sm" id="deptTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th class = "action-td">Code</th>
                            <th class = "action-td">Action</th>
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
	                            <td><?php echo $row['department']?></td>
	                            <td class = "action-td"><?php echo $row['code']?></td>
                                <td class = "action-td">
                                     
                                    <?php
                                      if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Department'] == 'Yes')) 
                                      {
                                        echo '<a 
                                        href="#" id="btn_edit_dept" 
                                        data-id="'.$row['dept_id'].'">
                                        Edit
                                    </a>';
                                      };

                                      if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Department'] == 'Yes')) 
                                      {
                                        echo ' | <a href="#" id="btn_delete_dept" data-id="'.$row['dept_id'].'">Delete</a>';
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
<?php include('dept_setup_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>