<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    if(isset($_SESSION['branch_id'])){$user_branch_id = $_SESSION['branch_id'];}else{$user_branch_id = '';};
?>
<input type='hidden' id='session_company_id' value="<?php echo $_SESSION['company_id'];?>">
<input type='hidden' id='session_user_super_id' value="<?php echo $_SESSION['user_super_id'];?>">
<input type='hidden' id='session_user_id' value="<?php echo $_SESSION['user_id'];?>">
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
	                Contra List
	            </h4>
                <?php
                      if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Contra'] == 'Yes')) 
                      {
                        echo '<a href="#" data-toggle="" id="new_contra_icon">New Contra</a>';
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
                        <label>Search</label>
                        <input type="text" class="form-control border-0 small" name="contra_search_name" id="contra_search_name">
                    </div>
                    <div class="input-group">
                        <label>From</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="contra_search_from" id="contra_search_from">
                    </div>
                    <div class="input-group">
                        <label>To</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="contra_search_to" id="contra_search_to">
                    </div>
                    <div class="input-group">
                        <a href="#" data-toggle="" id="contra_search_icon"><i class="fas fa-search"></i></a>
                    </div>
                </form>
	        </div>
        </div>
        <div class="card-body" id="contra_list_card_body">
            <?php
                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
                {
                    $query = "SELECT * FROM contra WHERE company_id = '".$_SESSION['company_id']."' ORDER BY date ASC";
                }
                else
                {
                    $query = "SELECT * FROM contra WHERE branch_id = '$user_branch_id' ORDER BY date ASC";
                };
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="contra_list_table">
                <table class="table table-hover table-bordered table-sm" id="contraTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%" class="action-td">Contra No</th>
                            <th width="10%" class="action-td">Date</th>
                            <th width="20%">Debit Ledger</th>
                            <th width="20%">Credit Ledger</th>
                            <th width="10%">Amount</th>
                            <th width="25%">Narration</th>
                            <th width="5%" class="action-td">Action</th>
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
                                        <td class="action-td">
                                            <?php echo $row['sno'];?>
                                        </td>
                                        <td class="action-td"><?php echo $row['date'];?></td> 
                                        <?php
                                            $ledger_id_dr = $row['ledger_debit'];
                                            $query_ledger_dr = "SELECT * FROM ledgers WHERE ledger_id ='$ledger_id_dr'";
                                            $query_run_ledger_dr = mysqli_query($con,$query_ledger_dr);
                                            $row_ledger_dr = mysqli_fetch_array($query_run_ledger_dr);
                                        ?>
                                        <td><?php echo $row_ledger_dr['ledger_desc'];?></td>
                                        <?php
                                            $ledger_id = $row['ledger_credit'];
                                            $query_ledger="SELECT * FROM ledgers WHERE ledger_id ='$ledger_id'";
                                            $query_run_ledger = mysqli_query($con,$query_ledger);
                                            $row_ledger = mysqli_fetch_array($query_run_ledger);

                                            $contra_amount = $row['amount'];
                                            $contra_amount = number_format($contra_amount, 2, '.', ',');
                                        ?>
                                        <td><?php echo $row_ledger['ledger_desc'];?></td>
                                        <td class="amt-td"><?php echo $contra_amount;?></td>
                                        <td><?php echo $row['narration'];?></td>
        	                            <td class="action-td">
                                            <?php
                                              if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Contra'] == 'Yes')) 
                                              {
                                                echo '<a href="#" id="btn_edit_contra" data-id="'.$row['contra_id'].'"><i class="fa fa-edit fa-sm"></i></a> |';
                                              };
                                            ?>

                                              <a href="#" id="btn_contra_reprint" data-id="<?php echo $row['contra_id'];?>"><i class="fa fa-print fa-sm"></i></a>

                                            <?php
                                              if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Contra'] == 'Yes'))
                                              {
                                                echo '| <a href="#" id="btn_delete_contra" data-id2="'.$row['contra_id'].'"><i class="fa fa-trash fa-sm"></i></a>';
                                              };
                                            ?>
        	                            </td>
                                    </tr>
                        <?php
                                }
                            }
                            else
                            {
                                    echo 'No Contra Voucher Not Found';
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/contra_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>