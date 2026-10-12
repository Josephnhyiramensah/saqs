<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    $name = $_SESSION['full_name'];
    if (isset($_SESSION['user_super_id'])) {
        $user_super_id = $_SESSION['user_super_id'];
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
	                User Type List
	            </h4>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">
                    <a href="#" data-toggle="" id="new_user_type_icon"><i class="fas fa-building"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $query = "SELECT * FROM user_type";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="user_type-table">
                <table class="table table-hover table-bordered table-sm" id="user_typeTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>User Type Description</th>
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
	                            <td>
                                    <a 
                                        href="#" id="btn_edit_user_type" 
                                        data-id2="<?php echo $row['company_id'];?>" 
                                        data-id1="<?php echo $row['user_super_id'];?>"
                                        data-id="<?php echo $row['user_type_id'];?>">
                                        <?php echo $row['user_type_desc']?>
                                    </a>
	                            </td>
                                <td class = "action-td">
                                    <a href="#" id="btn_delete_user_type" data-id="<?php echo $row['user_type_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
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
<?php include('user_type_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>