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
	                Radiology List
	            </h4>
                <a href="#" data-toggle="" id="new_radio_icon">New Radiology</a>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">
                    <input type="text" class="form-control border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" name="search_radiology" id="search_radiology">
                    <a href="#" data-toggle="" id="new_radio_icon"><i class="fas fa-plus-square"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                
                $query = "SELECT * FROM radiology ORDER BY radio_type_id ASC, radiology ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="radio_list_table">
                <table class="table table-hover table-bordered table-sm" id="radioTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">Radiology Item</th>
                            <th class="action-td">Type</th>
                            <th class="action-td">Cash</th>
                            <th class="action-td">Private</th>
                            <th class="action-td">Private Top Up</th>
                            <th class="action-td">NHIS Price</th>
                            <th class="action-td">NHIS Top Up</th>
                            <th class="action-td">NHIS Item</th>
                            <th class="action-td">NHIS Code</th>
                            <th class="action-td">Action</th>
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

                                    $radio_type_id = $row['radio_type_id'];
                                    $query_radio_type = "SELECT * FROM radio_type WHERE radio_type_id='$radio_type_id'";
                                    $query_radio_type_run = mysqli_query($con, $query_radio_type);
                                    $row_radio_type=mysqli_fetch_assoc($query_radio_type_run);
                        ?>
                                    <tr>
                                        <td>
                                            <a href="#" id="btn_edit_radio" data-id="<?php echo $row['radio_id'];?>"><?php echo $row['radiology'];?></a>
                                        </td>
                                        <td><?php echo $row_radio_type['radio_type'];?></td>
                                        <td class="amt-td"><?php echo $row['price_cash'];?></td>
                                        <td class="amt-td"><?php echo $row['price_private'];?></td>
                                        <td class="amt-td"><?php echo $row['price_private_topup'];?></td>
                                        <td class="amt-td"><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['price'];}?></td>
                                        <td class="amt-td"><?php echo $row['price_nhis_topup'];?></td>
                                        <td class="action-td"><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['nhis_item_desc'];}?></td>
                                        <td class="action-td"><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['gdrg'];}?></td>
        	                            <td class="action-td">
        									<a href="#" id="btn_delete_radio" 
                                            data-id="<?php echo $row['radio_id'];?>"
                                            data-id1="<?php echo $row['radiology'];?>"><i class="fa fa-trash fa-sm"></i></a>
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
<?php include('radio_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>