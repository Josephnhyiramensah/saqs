<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/sessions.php');
?>
<input type='hidden' id='session_user_super_id' value="<?php echo $user_super_id;?>">
<input type='hidden' id='session_company_id' value="<?php echo $company_id;?>">
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
	                User List
	            </h4>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <label>Search</label>
                        <input type="text" class="form-control border-0 small" name="user_search" id="user_search">
                    </div>
		        	<div class="input-group">
                    <?php
                      /*if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_User'] == 'Yes')) 
                      {
                        echo '<a href="#" data-toggle="" id="new_user_icon"><i class="fas fa-user-plus"></i></a>';
                      };*/
                    ?>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                
                if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User') 
                {
                    $query = "SELECT * FROM users";
                }
                else
                {
                    $query = "SELECT * FROM users WHERE company_id = '$company_id'";
                };
                    
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="user-table">
                <table class="table table-hover table-bordered table-sm" id="userTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Formal Name</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th>User Type</th>
                            <th>Branch</th>
                            <th>Status</th>
                            <?php
                                if ($_SESSION['user_type'] == 'Ultra_Super_User') 
                                {
                                    echo '<th>Company</th>';
                                };
                            ?>
                            <th class="action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                                ?>
                            <tr>
	                            <td><?php echo $row['first_name'].' '.$row['last_name']?></td>
                                <td><?php echo $row['email'];?></td>
                                <td><?php echo $row['telephone'];?></td>
                                <?php
                                    $user_type_id = $row['user_type_id'];
                                    $query_ut = "SELECT * FROM user_type WHERE user_type_id = '$user_type_id'";
                                    $query_run_ut = mysqli_query($con, $query_ut);
                                    if (!empty($query_run_ut) && mysqli_num_rows($query_run_ut) > 0) 
                                    {
                                       $row_ut = mysqli_fetch_assoc($query_run_ut);
                                       $user_type_desc = $row_ut['user_type_desc'];
                                    }
                                    else
                                    {
                                        $user_type_desc = "";
                                    };
                                ?>
                                <td><?php echo $user_type_desc;?></td>
                                <td>
                                    <?php
                                        echo '<select class="form-control user_change_branch" name="user_change_branch" id="user_change_branch'.$row['id'].'" data-id="'.$row['id'].'">
                                            <option value="0">Please Select</option>';
                                            if($user_type == 'Normal_User')
                                            {
                                                $query_branch = "SELECT * FROM branch WHERE company_id = '".$_SESSION['company_id']."' ORDER BY branch_name ASC";
                                            }
                                            else
                                            {
                                                $query_branch = "SELECT * FROM branch ORDER BY branch_name ASC";
                                            };
                                            $query_run_branch = mysqli_query($con, $query_branch);
                                            if (mysqli_num_rows($query_run_branch) > 0) 
                                            {
                                                while($row_branch = mysqli_fetch_assoc($query_run_branch))
                                                {
                                                    if($row_branch['branch_id'] == $row['branch_id'])
                                                    {
                                                        echo'<option value="'.$row_branch['branch_id'].'"selected="selected">'.$row_branch['branch_name'].'</option>';
                                                    }
                                                    else
                                                    {
                                                        echo'<option value="'.$row_branch['branch_id'].'">'.$row_branch['branch_name'].'</option>';
                                                    };
                                                };
                                            };
                                        echo '</select>';
                                    ?>
                                </td>
                                <td><?php echo $row['user_status'];?></td>
                                <?php
                                    /*if ($user_type == 'Ultra_Super_User') 
                                    {
                                        $user_company_id = $row['company_id'];
                                        $query_uc = "SELECT * FROM company WHERE company_id = '$user_company_id'";
                                        $query_run_uc = mysqli_query($con, $query_uc);
                                        $row_uc = mysqli_fetch_assoc($query_run_uc);
                                        echo '<td>'.$row_uc['trading_name'].'</td>';
                                    };*/
                                ?>
                                    <?php
                                    if ($user_type == 'Ultra_Super_User') 
                                    {
                                        echo '<td>
                                            <select class="form-control user_change_company" name="user_change_company" id="user_change_company'.$row['id'].'" data-id="'.$row['id'].'">
                                                <option value="0">Please Select</option>';
                                                if($user_type == 'Normal_User')
                                                {
                                                    $query_branch = "SELECT * FROM company WHERE company_id = '".$_SESSION['company_id']."' ORDER BY trading_name ASC";
                                                }
                                                else
                                                {
                                                    $query_branch = "SELECT * FROM company ORDER BY trading_name ASC";
                                                };
                                                $query_run_branch = mysqli_query($con, $query_branch);
                                                if (mysqli_num_rows($query_run_branch) > 0) 
                                                {
                                                    while($row_branch = mysqli_fetch_assoc($query_run_branch))
                                                    {
                                                        if($row_branch['company_id'] == $row['company_id'])
                                                        {
                                                            echo'<option value="'.$row_branch['company_id'].'"selected="selected">'.$row_branch['trading_name'].'</option>';
                                                        }
                                                        else
                                                        {
                                                            echo'<option value="'.$row_branch['company_id'].'">'.$row_branch['trading_name'].'</option>';
                                                        };
                                                    };
                                                };
                                            echo '</select>
                                        </td>';
                                    };
                                    ?>
	                            <td class="action-td">
                                    <?php
                                      if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR 
                                      ($user_type == 'Normal_User' AND $Edit_User == 'Yes')) 
                                      {
                                        echo '<a href="#" id="btn_edit_user" 
                                            data-id="'.$row['id'].'">
                                            <i class="fa fa-edit fa-sm"></i></a> ';
                                      };

                                      if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR $user_type_id == 3) 
                                      {
                                        echo ' | <a href="#" id="btn_reset_user"
                                                data-id="'.$row['id'].'">
                                                <i class="fa fa-unlock fa-sm"></i>
                                            </a>';
                                      };
                                      if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR 
                                      ($user_type == 'Normal_User' AND $Delete_User == 'Yes')) 
                                      {
                                        echo ' | <a href="#" id="btn_delete_user" data-id="'.$row['id'].'"><i class="fa fa-trash fa-sm"></i></a>';
                                      };
                                    ?>
	                            </td>
                            </tr>
                        <?php
                                };
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
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/user_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/user_personal_reset_password_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>