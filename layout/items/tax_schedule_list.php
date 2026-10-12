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
	                Tax Schedule List
	            </h4>
                <div class="input-group">
                    <a href="#" data-toggle="" id="new_tax_schedule_icon">New Tax Schedule</a>
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
                $query = "SELECT * FROM payroll_tax_schedule WHERE company_id = '$company_id' ORDER BY sno DESC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="tax_schedule_list_table">
                <table class="table table-hover table-bordered table-sm" id="tax_scheduleTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">Applicable Date</th>
                            <th class="action-td">First</th>
                            <th class="action-td">Next</th>
                            <th class="action-td">Next</th>
                            <th class="action-td">Next</th>
                            <th class="action-td">Next</th>
                            <th class="action-td">Next</th>
                            <th class="action-td">Exceeding</th>
                            <th class="action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    
                                    $CI_1 = number_format($row['CI_1'], 2, '.', ',');
                                    $CI_2 = number_format($row['CI_2'], 2, '.', ',');
                                    $CI_3 = number_format($row['CI_3'], 2, '.', ',');
                                    $CI_4 = number_format($row['CI_4'], 2, '.', ',');
                                    $CI_5 = number_format($row['CI_5'], 2, '.', ',');
                                    $CI_6 = number_format($row['CI_6'], 2, '.', ',');
                                    $CI_7 = number_format($row['CI_7'], 2, '.', ',');
                        ?>
                                    <tr>
                                        <td class="action-td"><?php echo $row['date'];?></td>
                                        <td class="amt-td"><?php echo $CI_1;?></td>
                                        <td class="amt-td"><?php echo $CI_2;?></td>
                                        <td class="amt-td"><?php echo $CI_3;?></td>
                                        <td class="amt-td"><?php echo $CI_4;?></td>
                                        <td class="amt-td"><?php echo $CI_5;?></td>
                                        <td class="amt-td"><?php echo $CI_6;?></td>
                                        <td class="amt-td"><?php echo $CI_7;?></td>
        	                            <td class="action-td">
                                            <a href="#" id="btn_edit_tax_schedule" data-id="<?php echo $row['tax_schedule_id'];?>">Edit</a>
                                            <!--|
        									<a href="#" id="btn_delete_tax_schedule" data-id="<?php //echo $row['tax_schedule_id'];?>">Delete</a>-->
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
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/tax_schedule_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>