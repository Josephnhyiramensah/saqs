<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    if (isset($_SESSION['user_super_id'])) {
        $user_super_id = $_SESSION['user_super_id'];
        $name = $_SESSION['full_name'];
    };
    if (isset($_SESSION['company_id'])){$company_id = $_SESSION['company_id'];}else{$company_id = 0;};
?>
<input type='hidden' id='session_user_super_id' value="<?php echo $user_super_id;?>">
<style type="text/css">
    input {border-top-style: hidden;border-right-style: hidden;border-left-style: hidden;border-bottom-style: hidden;background-color: #ffffff;}
    .scroll-card-body {max-height: 700px;overflow-y: auto;}
    .scroll_search_div {max-height: 200px;overflow-y: auto;}
    .scroll_table_div {max-height: 500px;overflow-y: auto;}
    .amt-td {text-align:right;}
    .action-td {text-align:center;}
  </style>
<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Purchase Returns List
	            </h4>
                <div class="input-group">
                    <a href="#" data-toggle="" id="new_purchase_returns_icon">New Purchase Returns</a>
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
                        <input type="text" class="form-control border-0 small" name="purchase_returns_search" id="purchase_returns_search">
                    </div>
                    <div class="input-group">
                        <label>From</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="purchase_returns_search_from" id="purchase_returns_search_from">
                    </div>
                    <div class="input-group">
                        <label>To</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="purchase_search_to" id="purchase_returns_search_to">
                    </div>
		        	<div class="input-group">
                        <a href="#" data-toggle="" id="new_purchase_returns_icon"><i class="fas fa-plus-square"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                /*if($_SESSION['user_type'] == 'Ultra_Super_User')
                {
                    $query = "SELECT * FROM purchase_returns";
                }
                else
                {*/
                    $query = "SELECT r.*, l.ledger_desc, w.warehouse_desc FROM purchase_return r 
                    JOIN ledgers l ON r.ledger_debit=l.ledger_id 
                    JOIN warehouse w ON r.warehouse_id=w.warehouse_id 
                    WHERE r.company_id = '$company_id'";
                //};
                
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="purchase_returns-table">
                <table class="table table-hover table-bordered table-sm" id="purchase_returnsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Receiving Ledger</th>
                            <th>Date</th>
                            <th>Warehouse</th>
                            <th>Reason</th>
                            <th class = "action-td">Reference</th>
                            <th class = "action-td">Amount</th>
                            <th class = "action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                ?>
                            <tr>
	                            <td><?php echo $row['ledger_desc']?></td>
                                <td><?php echo $row['date'];?></td>
                                <td><?php echo $row['warehouse_desc'];?></td>
                                <td><?php echo $row['narration'];?></td>
                                <td class = "action-td"><?php echo $row['reference_no'];?></td>
                                <td class = "amt-td"><?php echo $row['amount'];?></td>
                                <td class = "action-td">
                                     
                                    <?php
                                      if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Purchases'] == 'Yes')) 
                                      {
                                        echo '<a 
                                            href="#" id="btn_edit_purchase_returns" 
                                            data-id="'.$row['purchase_return_id'].'">
                                            Edit
                                        </a>';
                                      };

                                      if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Purchases'] == 'Yes')) 
                                      {
                                        echo ' | <a href="#" id="btn_delete_purchase_returns" data-id="'.$row['purchase_return_id'].'">Delete</a>';
                                      };
                                    ?>
	                            </td>
                            </tr>
                        <?php
                                }
                            }
                            else
                            {
                                echo '<tr><td colspan="7">Data Not Found</td></tr>';
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/purchase_returns_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>