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
	                Laboratory Test List
	            </h4>
                    <a href="#" data-toggle="" id="new_lab_icon">New Lab</a>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                <input type="text" class="form-control border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" name="search_lab" id="search_lab">
		            <div class="input-group">
                        <a href="#" data-toggle="" id="new_lab_icon"><i class="fas fa-flask"></i></a>
                    </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $query = "SELECT * FROM lab ORDER BY lab ASC";
                $query_run = mysqli_query($con, $query);
            ?>
			</table>
            <div class="table-responsive" id="lab_item_table">
                <table class="table table-hover table-bordered table-sm" id="labTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Test</th>
                            <th>Code</th>
                            <th>Cash</th>
                            <th>NHIS</th>
                            <th>NHIS (Top Up)</th>
                            <th>Private</th>
                            <th>Private (Top Up)</th>
                            <th>Param</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                                    $nhis_id = $row['nhis_id'];
                                    $query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
                                    $query_nhis_run = mysqli_query($con, $query_nhis);
                                    $row_nhis=mysqli_fetch_assoc($query_nhis_run);
                        ?>
                                    <tr>
        	                            <td>
        	                            	<a href="#" id="btn_edit_lab" data-id1="<?php echo $row['lab_id'];?>"><?php echo $row['lab'];?></a>
        	                            </td>
                                        <td><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['gdrg'];}?></td>
        	                            <td><?php echo $row['price_cash']?></td>
                                        <td><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['price'];}?></td>
                                        <td><?php echo $row['price_nhis_topup']?></td>
                                        <td><?php echo $row['price_private']?></td>
                                        <td><?php echo $row['price_private_topup']?></td>
                                        <td>
                                            <a href="#" id="btn_lab_param" data-id="<?php echo $row['lab_id'];?>"><i class="fas fa-clipboard-list"></i></a>
                                        </td>
        	                            <td>
        									<a href="#" id="btn_delete_lab" data-id2="<?php echo $row['lab_id'];?>"data-id1="<?php echo $row['lab'];?>"><i class="fa fa-trash fa-sm"></i></a>
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
<?php include('lab_create_modal.php');?>
<?php include('lab_edit_modal.php');?>
<?php include('lab_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>