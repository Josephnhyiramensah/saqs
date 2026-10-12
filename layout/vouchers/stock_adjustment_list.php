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
?>
  <style type="text/css">
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
	                Stock Adjustment List
	            </h4>
                    <?php
                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Stock_Adjustment'] == 'Yes')) 
                        {
                            echo '<a href="#" id="new_stock_adjustment_icon">New Stock Adjustment</a> | 
                            <a href="#" data-toggle="" id="new_stock_adjustment_download_csv">Download CSV file</a> | 
                            <a href="#" id="import_stock_adjustment_icon">Import Stock Take</a>';
                        };
                    ?>
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
                        <input type="text" class="form-control border-0 small" name="stock_adjustment_search" id="stock_adjustment_search">
                    </div>
                    <div class="input-group">
                        <label>From</label>
                        <?php
                            if($remember_state == true)
                            {
                        ?>
                                <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_adjustment_search_from" id="stock_adjustment_search_from" value="<?php echo $search_from;?>">
                        <?php
                            }
                            else
                            {
                        ?>
                                <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_adjustment_search_from" id="stock_adjustment_search_from">
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
                                    <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_adjustment_search_to" id="stock_adjustment_search_to" value="<?php echo $search_to;?>">
                            <?php
                                }
                                else
                                {
                            ?>
                                    <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_adjustment_search_to" id="stock_adjustment_search_to">

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
                        <a href="#" id="new_stock_adjustment_icon"><i class="fas fa-plus-square"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
                {
                    $query = "SELECT * FROM stock_adjustment WHERE company_id = '".$_SESSION['company_id']."' ORDER BY date ASC";
                }
                else
                {
                    $query = "SELECT * FROM stock_adjustment WHERE branch_id = '$user_branch_id' ORDER BY date ASC";
                };
                $query_run = mysqli_query($con, $query);

            echo '<div class="table-responsive" id="stock_adjustment_list_table">
                <table class="table table-hover table-bordered table-sm" id="stocktransferTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" width="5%">ID</th>
                            <th class = "action-td" width="15%">Date</th>
                            <th width="25%">Adjusted By</th>
                            <th width="40%">Narration</th>
                            <th class = "action-td" width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">';
                        
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    echo '<tr>
                                        <td class = "action-td">
                                            <a href="#" id="btn_edit_stk_adj" data-id="'.$row['stock_adj_id'].'">'.$row['stock_adj_id'].'</a>
                                        </td>
                                        <td class = "action-td">'.$row['date'].'</td>
                                        <td>'.$row['adjusted_by'].'</td>
                                        <td>'.$row['narration'].'</td>
        	                            <td class = "action-td">
        									<a href="#" id="btn_delete_stk_adj" data-id="'.$row['stock_adj_id'].'"><i class="fa fa-trash fa-sm"></i></a>
        	                            </td>
                                    </tr>';
                                }
                            }
                            else
                            {
                                echo 'No Stock Adjustment Found';
                            };
                    echo '</tbody>
                </table>';
                ?>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_adjustment_import_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_adjustment_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_adjustment_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>