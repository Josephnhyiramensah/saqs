<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    if (isset($_SESSION['user_super_id'])) {
        $user_super_id = $_SESSION['user_super_id'];
        $name = $_SESSION['full_name'];
    };
    
	$date_today = date('Y-m-d');
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
	                Price Level List
	            </h4>
                <div class="input-group">
                    <a href="#" data-toggle="" id="new_price_level_icon">New Price Level</a> -|- 
                    <a href="#" data-toggle="" id="import_price_level">Import Price Level</a> -|- 
                    <a href="#" data-toggle="" id="export_price_level">Export Price Level</a>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">

                    <a href="#" data-toggle="" id="new_price_level_icon"><i class="fas fa-building"></i></a>

		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body scroll-card-body">
            <?php
                /*if($_SESSION['user_type'] == 'Ultra_Super_User')
                {
                    $query = "SELECT * FROM stock_type";
                }
                else
                {*/
                    $query = "SELECT * FROM price_level WHERE company_id = '".$_SESSION['company_id']."'";
                //};
                
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="price_level_list_div">
                <table class="table table-hover table-bordered table-sm" id="price_level_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Branch</th>
                            <th>Price Level</th>
                            <th class = "action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    $branch_id = $row['branch_id'];
                                    $query_branch = "SELECT * FROM branch WHERE branch_id = '$branch_id'";
                                    $query_run_branch = mysqli_query($con, $query_branch);
                                    if(!empty($query_run_branch) && mysqli_num_rows($query_run_branch) > 0)
                                    {
                                        $row_branch = mysqli_fetch_assoc($query_run_branch);
                                        $branch = $row_branch['branch_name'];
                                    }
                                    else
                                    {
                                        $branch = 'Not Specified';
                                    };
                                    ?>
                                    <tr>
                                        <td><?php echo $row['date']?></td>
                                        <td><?php echo $branch;?></td>
                                        <td><?php echo $row['price_level']?></td>
                                        <td class = "action-td">
                                            
                                            <?php
                                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Drugs'] == 'Yes')) 
                                            {
                                                echo '<a 
                                                    href="#" id="btn_edit_price_level" 
                                                    data-id="'.$row['price_level_id'].'">
                                                    Edit
                                                </a>';
                                            };
                                                echo ' | <a 
                                                    href="#" id="btn_display_price_level" 
                                                    data-id="'.$row['price_level_id'].'" 
                                                    data-level="'.$row['price_level'].'" 
                                                    data-branch="'.$branch.'"
                                                    data-date="'.$row['date'].'" >
                                                    Display
                                                </a>';
                                                echo ' | <a 
                                                    href="#" id="btn_export_price_level" 
                                                    data-id="'.$row['price_level_id'].'" 
                                                    data-level="'.$row['price_level'].'" 
                                                    data-branch="'.$branch.'"
                                                    data-date="'.$row['date'].'" >
                                                    Export
                                                </a>';
                                                echo ' | <a 
                                                    href="#" id="btn_auto_price_level" 
                                                    data-id="'.$row['price_level_id'].'" 
                                                    data-level="'.$row['price_level'].'" 
                                                    data-branch="'.$branch.'"
                                                    data-date="'.$row['date'].'">
                                                    Auto
                                                </a>';

                                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Drugs'] == 'Yes')) 
                                            {
                                                echo ' | <a href="#" id="btn_delete_price_level" data-id="'.$row['price_level_id'].'">Delete</a>';
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
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/price_list_auto_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/price_level_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/price_level_import_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>