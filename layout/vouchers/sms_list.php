<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
?>
<input type="hidden" class="form-control" name="session_company" id="session_company" value="<?php echo $_SESSION['company_id'];?>">
<style type="text/css">
    input {
            border-top-style: hidden;
            border-right-style: hidden;
            border-left-style: hidden;
            border-bottom-style: hidden;
            background-color: #ffffff;
          }
    .amt-td {text-align:right;}
    .action-td {text-align:center;}
  </style>
<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                SMS List
	            </h4>
                <div class="input-group">
                <a href="#" data-toggle="" id="new_sms_purchase_icon">New SMS Purhcase</i></a>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $query = "SELECT * FROM sms WHERE qty_in !='' ORDER BY date ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="sms_list_table">
                <table class="table table-hover table-bordered table-sm" id="smsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th class="action-td">Date</th>
                            <th class="action-td">Qty</th>
                            <th class="action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    $company_id = $row['company_id'];
                                    $sql_company = "SELECT * FROM company WHERE company_id = '$company_id' ORDER BY trading_name ASC";
                                    $result_company = mysqli_query($con,$sql_company);
                                    $row_company = mysqli_fetch_array($result_company);
                        ?>
                                    <tr>
                                        <td><?php echo $row_company['trading_name'];?></td>
                                        <td class="action-td"><?php echo $row['date'];?></td>
                                        <td class="action-td"><?php echo $row['qty_in'];?></td>
        	                            <td class="action-td">
        									<a href="#" id="btn_edit_sms_purchase" data-id="<?php echo $row['sms_utility_id'];?>">Edit</a>
                                            | 
        									<a href="#" id="btn_delete_sms_purchase" data-id="<?php echo $row['sms_utility_id'];?>">Delete</a>
        	                            </td>
                                    </tr>
                        <?php
                                }
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/sms_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>