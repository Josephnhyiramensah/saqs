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
  </style>
<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Warehouse List
	            </h4>
                <div class="input-group">
                <a href="#" data-toggle="" id="new_warehouse_icon">New Warehouse</i></a>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $company_id = $_SESSION['company_id'];
                $query = "SELECT * FROM warehouse WHERE company_id = '$company_id' ORDER BY warehouse_desc ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="warehouse_list_table">
                <table class="table table-hover table-bordered table-sm" id="warehouseTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Location</th>
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
                                        <td>
                                            <a href="#" id="btn_edit_warehouse" data-id="<?php echo $row['warehouse_id'];?>"><?php echo $row['warehouse_desc'];?></a>
                                        </td>
                                        <td><?php echo $row['location'];?></td>
        	                            <td>
        									<a href="#" id="btn_delete_warehouse" data-id="<?php echo $row['warehouse_id'];?>"
                                            data-id1="<?php echo $row['warehouse_desc'];?>"><i class="fa fa-trash fa-sm"></i></a>
        	                            </td>
                                    </tr>
                        <?php
                                }
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/warehouse_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>