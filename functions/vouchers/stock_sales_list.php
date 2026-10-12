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
	                Stock Sales List
	            </h4>
                <div class="input-group">
                    <a href="#" data-toggle="" id="new_stock_sales_icon">New Stock Sales Voucher</a>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <label>Name</label>
                        <input type="text" class="form-control border-0 small" name="stock_sales_name" id="stock_sales_name">
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
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $query = "SELECT * FROM stock_sales WHERE company_id = '".$_SESSION['company_id']."' ORDER BY date ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="stock_sales_list_table">
                <table class="table table-hover table-bordered table-sm" id="stock_salesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td">Sales ID</th>
                            <th class = "action-td">Date</th>
                            <th>Supplied By</th>
                            <th class = "action-td">Amount</th>
                            <th class = "action-td">Invoice No</th>
                            <th>Credit Ledger</th>
                            <th class = "action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    $ledger_cr = $row['ledger_credit'];
                                    $query_ledger = "SELECT * FROM ledgers WHERE ledger_id='$ledger_cr'";
                                    $query_ledger_run = mysqli_query($con, $query_ledger);
                                    $row_ledger = mysqli_fetch_assoc($query_ledger_run);
                        ?>
                                    <tr>
                                        <td class = "action-td">
                                            <a href="#" id="btn_edit_stock_sales" data-id="<?php echo $row['stock_sales_id'];?>"><?php echo $row['stock_sales_id'];?></a>
                                        </td>
                                        <td class = "action-td"><?php echo $row['date'];?></td>
                                        <td><?php echo $row['supplied_by'];?></td>
                                        <td class = "amt-td"><?php echo $row['amount'];?></td>
                                        <td class = "action-td"><?php echo $row['reference_no'];?></td>
                                        <td><?php echo $row_ledger['ledger_desc'];?></td>
        	                            <td class = "action-td">
        									<a href="#" id="btn_delete_stock_sales" data-id2="<?php echo $row['stock_sales_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
        	                            </td>
                                    </tr>
                        <?php
                                }
                            }
                            else
                            {
                                    echo 'No Stock Sales Not Found';
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include('stock_sales_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>