<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
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
	                Journal List
	            </h4>
                <?php
                  if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Journal'] == 'Yes')) 
                  {
                    echo '<a href="#" data-toggle="" id="new_journal_icon">New Journal</a>';
                  };
                ?>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <label>Search</label>
                        <input type="text" class="form-control border-0 small" name="journal_search_name" id="journal_search_name">
                    </div>
                    <div class="input-group">
                        <label>From</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="journal_search_from" id="journal_search_from">
                    </div>
                    <div class="input-group">
                        <label>To</label>
                        <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="journal_search_to" id="journal_search_to">
                    </div>
                    <div class="input-group">
                        <a href="#" data-toggle="" id="journal_search_icon"><i class="fas fa-search"></i></a>
                    </div>
                </form>
	        </div>
        </div>
        <div class="card-body" id="journal_list_card_body">
            <?php
                $query = "SELECT * FROM journal WHERE company_id = '".$_SESSION['company_id']."' ORDER BY date ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="journal_list_table">
                <table class="table table-hover table-bordered table-sm" id="paymentTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">Journal No</th>
                            <th class="action-td">Date</th>
                            <th>Debit Ledger</th>
                            <th>Credit Ledger</th>
                            <th>Amount</th>
                            <th>Narration</th>
                            <th class="action-td">Action</th>
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
                                            $query_ledger_dr="SELECT * FROM ledgers WHERE ledger_id ='$ledger_id_dr'";
                                            $query_run_ledger_dr = mysqli_query($con,$query_ledger_dr);
                                            $row_ledger_dr = mysqli_fetch_array($query_run_ledger_dr);
                                        ?>

                                        <td><?php echo $row_ledger_dr['ledger_desc'];?></td>
                                        <?php
                                            $ledger_id_cr = $row['ledger_credit'];
                                            $query_ledger_cr = "SELECT * FROM ledgers WHERE ledger_id ='$ledger_id_cr'";
                                            $query_run_ledger_cr = mysqli_query($con,$query_ledger_cr);
                                            $row_ledger_cr = mysqli_fetch_array($query_run_ledger_cr);

                                            $journal_amount = $row['amount'];
                                            $journal_amount = number_format($journal_amount, 2, '.', ',');
                                        ?>
                                        <td><?php echo $row_ledger_cr['ledger_desc'];?></td>
                                        <td class="amt-td"><?php echo $journal_amount;?></td>
                                        <td><?php echo $row['narration'];?></td>
        	                            <td class="action-td">
                                            <?php
                                              if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Journal'] == 'Yes')) 
                                              {
                                                echo '<a href="#" id="btn_edit_journal" data-id="'.$row['journal_id'].'"><i class="fa fa-edit fa-sm"></i></a> | ';
                                              };
                                            ?>

                                              <a href="#" id="btn_journal_reprint" data-id="<?php echo $row['journal_id'];?>"><i class="fa fa-print fa-sm"></i></a>

                                            <?php
                                              if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Journal'] == 'Yes'))
                                              {
                                                echo '| <a href="#" id="btn_delete_journal" data-id2="'.$row['journal_id'].'"><i class="fa fa-trash fa-sm"></i></a>';
                                              };
                                            ?>
        	                            </td>
                                    </tr>
                        <?php
                                }
                            }
                            else
                            {
                                    echo 'No Journal Not Found';
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include('journal_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>