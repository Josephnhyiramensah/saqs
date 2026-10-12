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
    .scroll_card {height: 700px;overflow-y: auto;}
  </style>
<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Stock Item List
	            </h4>
                <div class="input-group">
                    <?php 
                        if (
                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                        $_SESSION['user_type'] == 'Super_User' OR 
                        $_SESSION['user_type_id'] == 3 OR 
                        ($_SESSION['user_type_id'] != 3 && $_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Drugs'] == 'Yes')) 
                        {
                            echo '<a href="#" data-toggle="" id="new_stock_item_icon">New Stock Item</a> -|- 
                            <a href="#" data-toggle="" id="import_stock_item">Import Stock Item</a> -|- 
                            <a href="#" data-toggle="" id="merge_duplicate_icon">Merge Duplicate</a> -|- ';
                        };
                    ?>
                    <a href="stock_item_export.php" data-toggle="" id="export_stock_item">Export Stock Item</a>
                </div>
            </div>
            <div class="float-right">
                <form class="form-inline mr-auto w-150 navbar-search">
                    <div class="input-group">
                        <label for="stock_item_search_criteria">Criteria</label>
                        <select class="form-control bg-light" name="stock_item_search_criteria" id="stock_item_search_criteria"> 
                            <option value="Name">Name</option>
                            <option value="Code">Code</option>
                            <option value="Barcode">Barcode</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="stock_item_search">Search</label>
                        <input type="text" class="form-control bg-light" name="stock_item_search" id="stock_item_search">
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body scroll_card">
            <?php
                $company_id = $_SESSION['company_id'];
                $query = "SELECT * FROM stock_items ORDER BY stock_item ASC LIMIT 100";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="stock_item_list_table">
                <table class="table table-hover table-bordered table-sm" id="stock_itemTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Unit</th>
                            <th>Price - Cash</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                                    $unit_id = $row['unit_id'];
                                    $query_unit = "SELECT * FROM unit WHERE unit_id='$unit_id'";
                                    $query_unit_run = mysqli_query($con, $query_unit);
                                    $row_unit=mysqli_fetch_assoc($query_unit_run);
                        ?>
                                    <tr>
                                        <td>
                                            <a href="#" id="btn_edit_stock_item" data-id="<?php echo $row['stock_item_id'];?>"><?php echo $row['stock_item'];?></a>
                                        </td>
                                        <td><?php echo $row['code'];?></td>
                                        <td><?php echo $row['stock_type'];?></td>
                                        <td><?php echo $row_unit['formal_name'];?></td>
                                        <td><?php echo $row['price_cash'];?></td>
        	                            <td>
        									<a href="#" id="btn_delete_stock_item" data-id2="<?php echo $row['stock_item_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
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
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/drug_merge_duplicate_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/stock_item_import_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/stock_item_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>