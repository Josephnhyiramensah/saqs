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
<div class="container-fluid scroll-card-body">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Ledger List
	            </h4>
                <div class="input-group">
                    <a href="#" data-toggle="" id="new_ledger_icon">New Ledger</a>
                </div>
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
                
                $query = "SELECT * FROM ledgers ORDER BY ledger_desc ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="ledger-table">
                <table class="table table-hover table-bordered table-sm" id="ledgerTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>TB Group 1</th>
                            <th>TB Group 2</th>
                            <th>TB Group 3</th>
                            <th>TB Group 4</th>
                            <th>TB Group 5</th>
                            <th>Pricelist</th>
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
                                    $tb_1_id = $row['tb_1'];
                                    $querytb_1 = "SELECT tb_1_desc FROM trial_bal_group_1 WHERE id='$tb_1_id'";
                                    $querytb_1_run = mysqli_query($con, $querytb_1);
                                    $row_tb_1=mysqli_fetch_assoc($querytb_1_run);

                                    $tb_2_id = $row['tb_2'];
                                    $querytb_2 = "SELECT tb_2_desc FROM trial_bal_group_2 WHERE id='$tb_2_id'";
                                    $querytb_2_run = mysqli_query($con, $querytb_2);
                                    $row_tb_2=mysqli_fetch_assoc($querytb_2_run);

                                    $tb_3_id = $row['tb_3'];
                                    $querytb_3 = "SELECT tb_3_desc FROM trial_bal_group_3 WHERE id='$tb_3_id'";
                                    $querytb_3_run = mysqli_query($con, $querytb_3);
                                    $row_tb_3=mysqli_fetch_assoc($querytb_3_run);

                                    $tb_4_id = $row['tb_4'];
                                    $querytb_4 = "SELECT tb_4_desc FROM trial_bal_group_4 WHERE id='$tb_4_id'";
                                    $querytb_4_run = mysqli_query($con, $querytb_4);
                                    $row_tb_4=mysqli_fetch_assoc($querytb_4_run);

                                    $tb_5_id = $row['tb_5'];
                                    $querytb_5 = "SELECT tb_5_desc FROM trial_bal_group_5 WHERE id='$tb_5_id'";
                                    $querytb_5_run = mysqli_query($con, $querytb_5);
                                    $row_tb_5=mysqli_fetch_assoc($querytb_5_run);
                        ?>
                            <tr>
	                            <td><a href="#" id="btn_edit_ledger" data-id="<?php echo $row['ledger_id'];?>"><?php echo $row['ledger_desc']?></a></td>
	                            <td><?php 
                                    if (isset($row_tb_1['tb_1_desc'])){
                                            echo $row_tb_1['tb_1_desc'];
                                    }
                                    ?>
                                </td>
                                <td><?php 
                                    if (isset($row_tb_2['tb_2_desc'])){
                                            echo $row_tb_2['tb_2_desc'];
                                    }
                                    ?>
                                </td>
	                            <td><?php 
                                    if (isset($row_tb_3['tb_3_desc'])){
                                            echo $row_tb_3['tb_3_desc'];
                                    }
                                    ?>
                                </td>
                                <td><?php 
                                    if (isset($row_tb_4['tb_4_desc'])){
                                            echo $row_tb_4['tb_4_desc'];
                                    }
                                    ?>
                                </td>
                                <td><?php 
                                    if (isset($row_tb_5['tb_5_desc'])){
                                            echo $row_tb_5['tb_5_desc'];
                                    }
                                    ?>
                                </td>
                                <td class="action-td">
                                    <?php 
                                    if ($row['type'] == 2)
                                    {
                                        $ledger_id = $row['ledger_id'];
                                        $query_it = "SELECT * FROM price_list WHERE ledger_id='$ledger_id'";
                                        $query_it_run = mysqli_query($con, $query_it);
                                        $row_pl=mysqli_num_rows($query_it_run);
                                        if ($row_pl > 0) 
                                        {
                                    ?>
                                        <a href="#" id="btn_edit_pricelist" data-id2="<?php echo $row['ledger_id'];?>"><i class="far fa-edit"></i></a>
                                    <?php 
                                        }
                                        else 
                                        {
                                    ?>
                                        <a href="#" id="btn_new_pricelist" data-id2="<?php echo $row['ledger_id'];?>"><i class="fas fa-clipboard-list"></i></a>
                                    <?php 
                                        }
                                    }
                                    ?>
                                </td>
	                            <td class="action-td">
                                    <?php 
                                        if ($row['type'] == 2)
                                        {
                                            echo '<a href="#" id="btn_limit_ledger" data-id="'.$row['ledger_id'].'">Limit</a>';
                                        };
                                    ?>
								</td>
	                            <td class="action-td">
									<a href="#" id="btn_delete_ledger" data-id1="<?php echo $row['ledger_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
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
<?php include('ledger_limit_create_modal.php');?>
<?php include('ledger_create_modal.php');?>
<?php include('ledger_edit_modal.php');?>
<?php include('price_list_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>