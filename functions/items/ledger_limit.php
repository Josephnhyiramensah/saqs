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
	                Insurance Limit List
	            </h4>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">
                    <a href="#" data-toggle="" id="new_ledger_icon"><i class="fas fa-book"></i></a>
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
                
                $query = "SELECT * FROM insurance_limit";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="ledger-table">
                <table class="table table-hover table-bordered table-sm" id="ledgerTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Insurance Company</th>
                            <th>Category</th>
                            <th>Limit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                                    $ledger_id = $row['ledger_id'];
                                    $query_ledger = "SELECT * FROM ledgers WHERE ledger_id='$ledger_id'";
                                    $query_run_ledger = mysqli_query($con, $query_ledger);
                                    $row_ledger = mysqli_fetch_assoc($query_run_ledger);

                        ?>
                            <tr>
	                            <td><?php echo $row_ledger['ledger_desc'];?></td>
	                            <td><?php echo $row['description'];?></td>
	                            <td><?php echo $row['limit_amount'];?></td>
	                            <td>
                                    <a href="#" 
                                        id="btn_edit_ledger_limit" 
                                        data-id="<?php echo $row['insurance_limit_id'];?>" 
                                        data-id1 ="<?php echo $row['ledger_id'];?>"
                                    >Edit</a>
                                    |
                                    <a href="#" 
                                        id="btn_delete_ledger_limit" 
                                        data-id="<?php echo $row['insurance_limit_id'];?>" 
                                        data-id1 ="<?php echo $row['ledger_id'];?>"
                                    >Delete</a>
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
<?php include('ledger_create_modal.php');?>
<?php include('ledger_edit_modal.php');?>
<?php include('price_list_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>