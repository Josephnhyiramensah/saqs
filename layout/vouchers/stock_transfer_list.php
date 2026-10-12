<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    if(isset($_SESSION['branch_id'])){$user_branch_id = $_SESSION['branch_id'];}else{$user_branch_id = '';};
    if(isset($_SESSION['search_from'])){$search_from = $_SESSION['search_from'];}else{$search_from = '';};
    if(isset($_SESSION['search_to'])){$search_to = $_SESSION['search_to'];}else{$search_to = '';};
    if(isset($_SESSION['page'])){$page = $_SESSION['page'];}else{$page = '';};
    if(isset($_SESSION['remember_state'])){$remember_state = $_SESSION['remember_state'];}else{$remember_state = 'false';};
    $company_id = $_SESSION['company_id'];
    $user_branch_id = $_SESSION['branch_id'];
?>
  <style type="text/css">
    .scroll-card-body {max-height: 700px;overflow-y: auto;}
    .amt-td {text-align:right;}
    .action-td {text-align:center;}
</style>
<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Stock Transfer List
	            </h4>
                <div class="input-group">
                <a href="#" data-toggle="" id="new_stock_transfer_icon">New Stock Transfer Voucher</a>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <?php
                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
                        {
                            echo '<div class="input-group" id="branch_filter">
                                <label>Branch</label>
                                <select class="form-control" class="form-control bg-light border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_branch" id="search_branch"> 
                                    <option value="0">ALL</option>';
                                    
                                        $sql_branch="SELECT * FROM branch ORDER BY branch_name ASC";
                                        $result_branch_list = mysqli_query($con,$sql_branch);
                                        while($row_branch_list=mysqli_fetch_array($result_branch_list))
                                        {
                                            echo '<option value = "'.$row_branch_list['branch_id'].'">
                                                '.$row_branch_list['branch_name'].'
                                            </option>';
                                        };
                                
                                echo '</select>
                            </div>';
                        };
                    ?>
                    <div class="input-group">
                        <label>Name</label>
                        <input type="text" class="form-control border-0 small" name="stock_transfer_search" id="stock_transfer_search">
                    </div>
                    <div class="input-group">
                        <label>From</label>
                        <?php
                            if($remember_state == true)
                            {
                        ?>
                                <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_transfer_search_from" id="stock_transfer_search_from" value="<?php echo $search_from;?>">
                        <?php
                            }
                            else
                            {
                        ?>
                                <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_transfer_search_from" id="stock_transfer_search_from">
                        <?php
                            };
                        ?>
                    </div>
                    <div class="input-group">
                        <label>To</label>
                            <?php
                                if($remember_state == true)
                                {
                            ?>
                                    <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_transfer_search_to" id="stock_transfer_search_to" value="<?php echo $search_to;?>">
                            <?php
                                }
                                else
                                {
                            ?>
                                    <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_transfer_search_to" id="stock_transfer_search_to">

                            <?php
                                };
                            ?>
                    </div>
                    <div class="input-group">
                        <div class="form-check">
                            <?php
                                if($remember_state == true)
                                {
                            ?>
                                    <input class="form-check-input" type="checkbox" value="" id="remember_state" checked>
                            <?php
                                }
                                else
                                {
                            ?>
                                    <input class="form-check-input" type="checkbox" value="" id="remember_state">
                            <?php
                                };
                            ?>
                        </div>
                    </div>
		        	<div class="input-group">
                    <a href="#" data-toggle="" id="new_stock_transfer_icon"><i class="fas fa-plus-square"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
                {
                    $query = "SELECT s.*, f.warehouse_desc AS warehouse_from, t.warehouse_desc AS warehouse_to FROM stock_transfer s JOIN 
				    warehouse f ON s.warehouse_from=f.warehouse_id JOIN warehouse t ON s.warehouse_to=t.warehouse_id 
                    WHERE s.company_id = '$company_id' ORDER BY s.date ASC";
                }
                else
                {
                    $query = "SELECT s.*, f.warehouse_desc AS warehouse_from, t.warehouse_desc AS warehouse_to FROM stock_transfer s JOIN 
				    warehouse f ON s.warehouse_from=f.warehouse_id JOIN warehouse t ON s.warehouse_to=t.warehouse_id 
                    WHERE s.company_id = '$company_id' AND s.branch_id = '$user_branch_id' ORDER BY s.date ASC";
                };
                $query_run = mysqli_query($con, $query);
            
            echo '<div class="table-responsive" id="stock_transfer_list_table">
                <table class="table table-hover table-bordered table-sm" id="stocktransferTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td">ID</th>
                            <th class = "action-td">Date</th>
                            <th class = "action-td">Transferred From</th>
                            <th class = "action-td">Transferred To</th>
                            <th>Transferred By</th>
                            <th>Requested By</th>
                            <th>Rquisition ID</th>
                            <th class = "action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">';
                        
                        if (mysqli_num_rows($query_run) > 0)
                        {
                            while($row = mysqli_fetch_assoc($query_run))
                            {
                                /*$warehouse_from = $row['warehouse_from'];
                                $warehouse_to = $row['warehouse_to'];
                                $query_warehouse_from = "SELECT * FROM warehouse WHERE warehouse_id ='$warehouse_from'";
                                $query_warehouse_from_run = mysqli_query($con, $query_warehouse_from);
                                $row_warehouse_from = mysqli_fetch_assoc($query_warehouse_from_run);

                                $query_warehouse_to = "SELECT * FROM warehouse WHERE warehouse_id ='$warehouse_to'";
                                $query_warehouse_to_run = mysqli_query($con, $query_warehouse_to);
                                $row_warehouse_to = mysqli_fetch_assoc($query_warehouse_to_run);*/
                    
                                echo '<tr>
                                    <td class = "action-td">
                                        <a href="#" id="btn_edit_stk_trans" data-id="'.$row['stock_trans_id'].'">'.$row['stock_trans_id'].'</a>
                                    </td>
                                    <td class = "action-td">'.$row['date'].'</td>
                                    <td>'.$row['warehouse_from'].'</td>
                                    <td>'.$row['warehouse_to'].'</td>
                                    <td class = "action-td">'.$row['transferred_by'].'</td>
                                    <td class = "action-td">'.$row['requested_by'].'</td>
                                    <td>'.$row['stock_req_id'].'</td>
                                    <td class = "action-td">
                                        <a href="#" id="btn_delete_stk_trans" data-id="'.$row['stock_trans_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                    </td>
                                </tr>';
                            }
                        }
                        else
                        {
                            echo 'No Stock Transfer Found';
                        };
                    echo '</tbody>
                </table>
            </div>';
            ?>
        </div>
    </div>
</div>
<?php include('stock_transfer_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>