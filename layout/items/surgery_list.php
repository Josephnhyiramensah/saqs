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
	                Procedure/Surgery List
	            </h4>
                <div class="input-group">
                    <a href="#" data-toggle="" id="new_surgery_icon">New Procedure/Surgery</a>
		        </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" name="search_procedure" id="search_procedure">
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
                
                $query = "SELECT * FROM surgery ORDER BY surgery ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="surgery_list_table">
                <table class="table table-hover table-bordered table-sm" id="surgeryTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">Surgery</th>
                            <th class="action-td">ICD-10</th>
                            <th class="action-td">G-DRG</th>
                            <th class="action-td">G-DRG Adult</th>
                            <th class="action-td">G-DRG Child</th>
                            <th class="action-td">Price - Cash</th>
                            <th class="action-td">Price - Cash(Foreign)</th>
                            <th class="action-td">Price - Adult</th>
                            <th class="action-td">Price - Child</th>
                            <th class="action-td">Delete</th>
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
                                            <a href="#" id="btn_edit_surgery" data-id="<?php echo $row['surgery_id'];?>"><?php echo $row['surgery'];?></a>
                                        </td>
                                        <td class="action-td"><?php echo $row['icd_10'];?></td>
        	                            <td class="action-td"><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['gdrg'];}?></td>
        	                            <td class="action-td"><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['gdrg_adult'];}?></td>
                                        <td class="action-td"><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['gdrg_child'];}?></td>
                                        <td class="amt-td"><?php echo $row['price_cash']?></td>
                                        <td class="amt-td"><?php echo $row['price_cash_foreign']?></td>
                                        <td class="amt-td"><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['price_adult'];}?></td>
                                        <td class="amt-td"><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['price_child'];}?></td>
        	                            <td class="action-td">
        									<a href="#" id="btn_delete_surgery" 
                                            data-id="<?php echo $row['surgery_id'];?>"
                                            data-id1="<?php echo $row['surgery'];?>"><i class="fa fa-trash fa-sm"></i></a>
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
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/surgery_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>