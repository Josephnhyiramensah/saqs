<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    if (isset($_SESSION['user_super_id'])) {
        $user_super_id = $_SESSION['user_super_id'];
        $name = $_SESSION['full_name'];
    };
    
    $price_level_id = $_SESSION['price_level_id'];
    $price_level_name = $_SESSION['price_level_name']; 
    $price_level_branch = $_SESSION['price_level_branch']; 
    $price_level_date = $_SESSION['price_level_date'];
    
	$date_today = date('Y-m-d');
?>
<input type='hidden' id='session_user_super_id' value="<?php echo $user_super_id;?>">
<style type="text/css">
    input {border-top-style: hidden;border-right-style: hidden;border-left-style: hidden;border-bottom-style: hidden;background-color: #ffffff;}
    .scroll-card-body {max-height: 700px;overflow-y: auto;}
    .amt-td {text-align:right;}
    .action-td {text-align:center;}
  </style>
<?php
echo '<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Price List Display
	            </h4>
                <div class="input-group">
                    '.$price_level_name.' | '.$price_level_branch.' | '.$price_level_date.'
                    - | - 
                    <a href="#" data-toggle="" data-id="'.$price_level_id.'" data-date="'.$price_level_date.'" id="add_item_to_price_list_icon">Add Item</a>
                    - | - 
                    <a href="#" data-toggle="" data-id="'.$price_level_id.'" id="export_price_list_to_excel_icon">Export to Excel</a>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">
                        <label for="price_list_search_criteria">Criteria</label>
                        <select class="form-control bg-light" name="price_list_search_criteria" id="price_list_search_criteria"> 
                            <option value="Name">Name</option>
                            <option value="Code">Code</option>
                            <option value="Barcode">Barcode</option>
                        </select>
		            </div>
		        	<div class="input-group">
                        <label for="price_list_search">Search</label>
                        <input type="text" class="form-control bg-light" name="price_list_search" id="price_list_search" data-id="'.$price_level_id.'">
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body scroll-card-body">';

            $query = "SELECT l.*, d.stock_item FROM price_list l JOIN stock_items d ON l.stock_item_id=d.stock_item_id 
            WHERE l.price_level_id = '$price_level_id' ORDER BY d.stock_item ASC";
            $query_run = mysqli_query($con, $query);
            $i=0;
        
            echo '<div class="table-responsive" id="price_level_list_div">
                <table class="table table-hover table-bordered table-sm" id="price_level_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td">S/No</th>
                            <th>Item</th>
                            <th class = "action-td">Price</th>
                            <th class = "action-td">Price (Inter-Branch)</th>
                            <th class = "action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">';
                        
                        if (mysqli_num_rows($query_run) > 0)
                        {
                            while($row = mysqli_fetch_assoc($query_run))
                            {
                                $i++;
                                $stock_item = $row['stock_item'];
                                $price = $row['price'];
                                $price_branch = $row['price_branch'];
                                $f_price = number_format($price, 2, '.', ',');
                                $f_price_branch = number_format($price_branch, 2, '.', ',');
                    
                            echo '<tr>
                                <td class = "action-td">'.$i.'</td>
                                <td>'.$stock_item.'</td>
                                <td class="amt-td">'.$f_price.'</td>
                                <td class="amt-td">'.$f_price_branch.'</td>
                                <td class = "action-td">';
                                    
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Drugs'] == 'Yes')) 
                                    {
                                        echo '<a 
                                            href="#" id="btn_edit_price_list" 
                                            data-price_list_id="'.$row['price_list_id'].'">
                                            Edit
                                        </a>';
                                    };

                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Drugs'] == 'Yes')) 
                                    {
                                        echo ' | <a href="#" id="btn_delete_price_list" data-price_list_id="'.$row['price_list_id'].'">Delete</a>';
                                    };
                                    
                                echo '</td>
                            </tr>';
                    
                            }
                        }
                        else
                        {
                            echo 'Data Not Found';
                        };
                        
                    echo '</tbody>
                </table>
            </div>
        </div>
    </div>
</div>';
?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/price_list_item_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/price_level_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>