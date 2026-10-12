<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    if(isset($_SESSION['user_super_id'])){$user_super_id = $_SESSION['user_super_id'];};
    $name = $_SESSION['full_name'];
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
	                Privileges List
	            </h4>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">
                    <a href="#" data-toggle="" id="new_user_privilege_icon"><i class="fas fa-user-plus"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $query = "SELECT * FROM user_privilege ORDER BY user_page_id";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="user_privilege-table">
                <table class="table table-hover table-bordered table-sm" id="user_privilegeTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Privilege</th>
                            <th>Page</th>
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
	                            <td><a href="#" id="btn_user_privilege_edit" data-id="<?php echo $row['user_priv_id'];?>"><?php echo $row['user_privilege']?></a></td>
                                <?php
                                    $user_page_id = $row['user_page_id'];
                                    $query_page = "SELECT * FROM user_pages WHERE user_page_id = '$user_page_id'";
                                    $query_run_page = mysqli_query($con, $query_page);
                                    $row_page = mysqli_fetch_assoc($query_run_page);
                                ?>
                                <td><?php echo $row_page['page'];?></td>
	                            <td class = "action-td">
									<a href="#" id="btn_user_privilege_delete" data-id="<?php echo $row['user_priv_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
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
<?php include('user_privilege_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>