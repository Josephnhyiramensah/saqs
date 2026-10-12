<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
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
	                User List
	            </h4>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <label>Search</label>
                        <input type="text" class="form-control border-0 small" name="user_admin_search" id="user_admin_search">
		        	</div>
                    <div class="input-group">
                        <a href="#" data-toggle="" id="new_user_icon"><i class="fas fa-user-plus"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $query = "SELECT * FROM users";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="user-table">
                <table class="table table-hover table-bordered table-sm" id="userTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Formal Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th>Action</th>
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
	                            <td><a href="#" id="btn_edit_user" data-id="<?php echo $row['id'];?>"><?php echo $row['full_name']?></a></td>
                                <td><?php echo $row['username'];?></td>
                                <td><?php echo $row['email'];?></td>
                                <td><?php echo $row['telephone'];?></td>
	                            <td>
									<a href="#" id="btn_delete_user" data-id="<?php echo $row['company_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
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
<?php include('user_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>