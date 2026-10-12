<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_super.php');
    if (isset($_SESSION['user_super_id'])) 
    {
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
	                Branch List
	            </h4>
                <div class="input-group">
                    <a href="#" data-toggle="" id="new_branch_icon">New Branch</a>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">

                    <a href="#" data-toggle="" id="new_branch_icon"><i class="fas fa-building"></i></a>

		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                /*if($_SESSION['user_type'] == 'Ultra_Super_User')
                {
                    $query = "SELECT * FROM branch";
                }
                else
                {*/
                    $query = "SELECT * FROM branch WHERE company_id = '".$_SESSION['company_id']."'";
                //};
                
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="branch-table">
                <table class="table table-hover table-bordered table-sm" id="branchTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Branch Name</th>
                            <th>Address</th>
                            <th>Location</th>
                            <th>Email</th>
                            <th class = "action-td">Telephone</th>
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
	                            <td><?php echo $row['branch_name']?></td>
                                <td><?php echo $row['branch_address'];?></td>
                                <td><?php echo $row['branch_location'];?></td>
                                <td><?php echo $row['branch_email'];?></td>
                                <td class = "action-td"><?php echo $row['branch_telephone'];?></td>
                                <td class = "action-td">
                                     
                                    <?php
                                      if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Company'] == 'Yes')) 
                                      {
                                        echo '<a 
                                        href="#" id="btn_edit_branch" 
                                        data-id="'.$row['branch_id'].'">
                                        Edit
                                    </a>';
                                      };

                                      if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Company'] == 'Yes')) 
                                      {
                                        echo ' | <a href="#" id="btn_delete_branch" data-id="'.$row['branch_id'].'">Delete</a>';
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
<?php include('branch_setup_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>