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
            max-height: 850px;
            overflow-y: auto;
        }
    .amt-td {
            text-align:right;
        }
    .action-td {
            text-align:center;
        }
  </style>
<div class="container-fluid scroll-card-body">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                NHIS List
	            </h4>
                <div class="input-group">
                    <a href="#" data-toggle="" id="new_nhis_icon">New NHIS Item</a>
		        </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" name="search_nhis_item" id="search_nhis_item">
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
            if(isset($_SESSION['success']) && $_SESSION['success'] !='')
            {
                echo '<h2>'.$_SESSION['success'].'</h2>';
                unset($_SESSION['success']);
            };
            if(isset($_SESSION['status']) && $_SESSION['status'] !='')
            {
                echo '<h2>'.$_SESSION['status'].'</h2>';
                unset($_SESSION['status']);
            };
            ?>
            <?php
                
                $query = "SELECT * FROM nhis ORDER BY category_id DESC, nhis_item_desc ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="nhis_list_table">
                <table class="table table-hover table-bordered table-sm" id="nhisTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>G-DRG</th>
                            <th>G-DRG Adult</th>
                            <th>G-DRG Child</th>
                            <th>Price</th>
                            <th>Price Adult</th>
                            <th>Price Child</th>
                            <th>Category</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                                    $category_id = $row['category_id'];
                                    $querycategory = "SELECT * FROM item_category WHERE category_id='$category_id'";
                                    $querycategory_run = mysqli_query($con, $querycategory);
                                    $row_category=mysqli_fetch_assoc($querycategory_run);
                        ?>
                                    <tr>
                                        <td><a href="#" id="btn_edit_nhis" data-id="<?php echo $row['nhis_id'];?>"><?php echo $row['nhis_item_desc'];?></a></td>
        	                            <td><a href="#" id="btn_edit_nhis" data-id="<?php echo $row['nhis_id'];?>"><?php echo $row['gdrg'];?></a></td>
        	                            <td><a href="#" id="btn_edit_nhis" data-id="<?php echo $row['nhis_id'];?>"><?php echo $row['gdrg_adult']?></a></td>
                                        <td><a href="#" id="btn_edit_nhis" data-id="<?php echo $row['nhis_id'];?>"><?php echo $row['gdrg_child']?></a></td>
                                        <td><a href="#" id="btn_edit_nhis" data-id="<?php echo $row['nhis_id'];?>"><?php echo $row['price']?></a></td>
                                        <td><a href="#" id="btn_edit_nhis" data-id="<?php echo $row['nhis_id'];?>"><?php echo $row['price_adult']?></a></td>
                                        <td><a href="#" id="btn_edit_nhis" data-id="<?php echo $row['nhis_id'];?>"><?php echo $row['price_child']?></a></td>
                                        <td><a href="#" id="btn_edit_nhis" data-id="<?php echo $row['nhis_id'];?>"><?php echo $row_category['category_desc'];?></a></td>
        	                            <td>
        									<a href="#" id="btn_delete_nhis" data-id2="<?php echo $row['nhis_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
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
<?php include('nhis_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>