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
	                Drug List
	            </h4>
		        <div class="input-group">
                    <a href="#" data-toggle="" id="new_drug_icon">New Drug</a>
		        </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" name="search_drug" id="search_drug">
		              <div class="input-group-append">
		                <button class="btn btn-primary" type="button">
		                  <i class="fas fa-search fa-sm"></i>
		                </button>
		              </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                
                $query = "SELECT * FROM drugs ORDER BY brand_name ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="drug_list_table">
                <table class="table table-hover table-bordered table-sm" id="drugTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Brand Name</th>
                            <th>Generic Name</th>
                            <th>Price - Cash</th>
                            <th>Price - NHIS</th>
                            <th>Price - Private</th>
                            <th>Code</th>
                            <th>Unit</th>
                            <th>Gender</th>
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
                                    $gender_id = $row['gender'];
                                    $query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
                                    $query_nhis_run = mysqli_query($con, $query_nhis);
                                    $row_nhis=mysqli_fetch_assoc($query_nhis_run);

                                    $query_gender = "SELECT * FROM gender WHERE gender_id='$gender_id'";
                                    $query_gender_run = mysqli_query($con, $query_gender);
                                    $row_gender=mysqli_fetch_assoc($query_gender_run);

                                    $unit_id = $row['unit'];
                                    $query_unit="SELECT * FROM unit WHERE unit_id = '$unit_id' ORDER BY formal_name ASC";
                                    $query_unit_run = mysqli_query($con, $query_unit);
                                    $row_unit=mysqli_fetch_assoc($query_unit_run);
                        ?>
                                    <tr>
                                        <td>
                                            <a href="#" id="btn_edit_drug" data-id="<?php echo $row['drug_id'];?>"><?php echo $row['brand_name'];?></a>
                                        </td>
                                        <td><?php echo $row['generic_name'];?></td>
                                        <td><?php echo $row['price_cash'];?></td>
                                        <td><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['price'];}?></td>
                                        <td><?php echo $row['price_prvt'];?></td>
        	                            <td><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['gdrg'];}?></td>
                                        <td><?php echo $row_unit['formal_name'];?></td>
                                        <td><?php if ($row_gender==null){echo 'N/A';}else{echo $row_gender['gender'];}?></td>
        	                            <td>
        									<a href="#" id="btn_delete_drug" 
                                            data-id="<?php echo $row['drug_id'];?>"
                                            data-id1="<?php echo $row['brand_name'];?>"><i class="fa fa-trash fa-sm"></i></a>
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
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/drug_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>