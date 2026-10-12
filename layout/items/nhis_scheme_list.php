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
	                NHIS Scheme List
	            </h4>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">
                    <a href="#" data-toggle="" id="new_nhis_scheme_icon"><i class="fas fa-plus-square"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                
                $query = "SELECT * FROM scheme ORDER BY scheme_name ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="nhis_scheme_list_table">
                <table class="table table-hover table-bordered table-sm" id="nhis_scheme_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Scheme Name</th>
                            <th>Scheme Code</th>
                            <th>Regional Code</th>
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
                                        <td><a href="#" id="btn_edit_nhis_scheme" data-id="<?php echo $row['scheme_id'];?>"><?php echo $row['scheme_name'];?></a></td>
        	                            <td><?php echo $row['scheme_code'];?></td>
        	                            <td><?php echo $row['regional_code']?></td>
        	                            <td>
        									<a href="#" id="btn_delete_nhis_scheme" data-id2="<?php echo $row['nhis_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
        	                            </td>
                                    </tr>
                        <?php
                                };
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include('nhis_scheme_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>