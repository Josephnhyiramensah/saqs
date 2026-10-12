<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
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
	                Stock Requisition List
	            </h4>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <label>Name</label>
                        <input type="text" class="form-control border-0 small" name="patient_name" id="patient_name">
                    </div>
                    <div class="input-group">
                        <label>From</label>
                        <?php
                            if($remember_state == true)
                            {
                        ?>
                                <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_from" id="search_from" value="<?php echo $search_from;?>">
                        <?php
                            }
                            else
                            {
                        ?>
                                <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_from" id="search_from">
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
                                    <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_to" id="search_to" value="<?php echo $search_to;?>">
                            <?php
                                }
                                else
                                {
                            ?>
                                    <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_to" id="search_to">

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
                    <a href="#" data-toggle="" id="new_stock_requisition_icon"><i class="fas fa-plus-square"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $query = "SELECT * FROM stock_requisition WHERE company_id = '".$_SESSION['company_id']."' ORDER BY date ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="stock_requisition_list_table">
                <table class="table table-hover table-bordered table-sm" id="stockrequisitionTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td">ID</th>
                            <th class = "action-td">Date</th>
                            <th>Requested By</th>
                            <th class = "action-td">Requested To</th>
                            <th class = "action-td">Requested From</th>
                            <th class = "action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    $warehouse_from = $row['warehouse_from'];
                                    $warehouse_to = $row['warehouse_to'];
                                    $query_warehouse_from = "SELECT * FROM warehouse WHERE warehouse_id ='$warehouse_to'";
                                    $query_warehouse_from_run = mysqli_query($con, $query_warehouse_from);
                                    $row_warehouse_from = mysqli_fetch_assoc($query_warehouse_from_run);

                                    $query_warehouse_to = "SELECT * FROM warehouse WHERE warehouse_id ='$warehouse_from'";
                                    $query_warehouse_to_run = mysqli_query($con, $query_warehouse_to);
                                    $row_warehouse_to = mysqli_fetch_assoc($query_warehouse_to_run);
                        ?>
                                    <tr>
                                        <td class = "action-td">
                                            <a href="#" id="btn_edit_stock_req" data-id="<?php echo $row['stock_req_id'];?>"><?php echo $row['stock_req_id'];?></a>
                                        </td>
                                        <td class = "action-td"><?php echo $row['date'];?></td>
                                        <td><?php echo $row['requested_by'];?></td>
                                        <td class = "action-td"><?php echo $row_warehouse_to['warehouse_desc'];?></td>
                                        <td class = "action-td"><?php echo $row_warehouse_from['warehouse_desc'];?></td>
        	                            <td class = "action-td">
                                        <?php
                                            $requisition_id = $row['stock_req_id'];
                                            $query_req_trans = "SELECT * FROM stock_transfer WHERE stock_req_id ='$requisition_id'";
                                            $query_run_req_trans = mysqli_query($con, $query_req_trans);
                                            if (mysqli_num_rows($query_run_req_trans) < 1)
                                            {
                                                echo '<a href="#" id="btn_transfer_stock_req" data-id="'.$row['stock_req_id'].'">Transfer</a>
                                                        | ';
                                            };
                                        ?>
                                            <a href="#" id="btn_delete_stock_req" data-id2="<?php echo $row['stock_req_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
        	                            </td>
                                    </tr>
                        <?php
                                }
                            }
                            else
                            {
                                    echo 'No Stock Requisition Not Found';
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include('stock_requisition_create_modal.php');?>
<?php include('stock_transfer_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>