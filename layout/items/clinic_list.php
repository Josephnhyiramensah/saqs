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
	                Clinic List
	            </h4>
                <a href="#" data-toggle="" id="new_clinic_icon">New Clinic</a>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">
                    <a href="#" data-toggle="" id="new_clinic_icon"><i class="fas fa-plus-square"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                
                $query = "SELECT * FROM clinics ORDER BY clinic_desc ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="clinic_list_table">
                <table class="table table-hover table-bordered table-sm" id="clinicTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Clinic</th>
                            <th>Delete</th>
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
                                            <a href="#" id="btn_edit_clinic" data-id="<?php echo $row['clinic_id'];?>"><?php echo $row['clinic_desc'];?></a>
                                        </td>
        	                            <td>
        									<a href="#" id="btn_delete_clinic" data-id="<?php echo $row['clinic_id'];?>"
                                            data-id1="<?php echo $row['clinic_desc'];?>"><i class="fa fa-trash fa-sm"></i></a>
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
<?php include('clinic_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>