<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    $today = date('Y-m-d');
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
	                SMS List
	            </h4>
                <div class="input-group">
                    <a href="#" data-toggle="" id="new_sms_icon">New SMS</a>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $company_id = $_SESSION['company_id'];
                $query = "SELECT * FROM sms WHERE company_id = '$company_id' ORDER BY date ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="sms_list_table">
                <table class="table table-hover table-bordered table-sm" id="smsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">Date</th>
                            <th class="action-td">Qty IN</th>
                            <th class="action-td">Qty OUT</th>
                            <th class="action-td">Name</th>
                            <th class="action-td">Status</th>
                            <th class="action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                        ?>
                                    <tr>
                                        <td class="action-td">
                                            <a href="#" id="btn_edit_sms" data-id="<?php echo $row['sms_id'];?>"><?php echo $row['date'];?></a>
                                        </td>
                                        <td class="action-td"><?php echo $row['qty_purchased'];?></td>
                                        <td class="action-td"><?php echo $row['qty_sent'];?></td>
                                        <td><?php echo $row['name'];?></td>
                                        <td><?php echo $row['status'];?></td>
        	                            <td class="action-td">
                                            <a href="#" id="btn_edit_sms" data-id="<?php echo $row['sms_id'];?>"><i class="fa fa-edit fa-sm"></i></a>
        									| <a href="#" id="btn_delete_sms" data-id="<?php echo $row['sms_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
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
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/sms_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>