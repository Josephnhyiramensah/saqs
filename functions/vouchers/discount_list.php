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
	                Discount List
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
                    <a href="#" data-toggle="" id="new_discount_icon"><i class="fas fa-plus-square"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                $query = "SELECT * FROM discount WHERE company_id = '".$_SESSION['company_id']."' ORDER BY date ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="discount_list_table">
                <table class="table table-hover table-bordered table-sm" id="discountTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            
                            <th class="action-td">Date</th>
                            <th class="action-td">Discount No</th>
                            <th class="action-td">Discount Amount</th>
                            <th class="action-td">Received By</th>
                            <th class="action-td">Bill No</th>
                            <th class="action-td">Bill Amount</th>
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
                                            <a href="#" id="btn_edit_discount" data-id="<?php echo $row['discount_id'];?>"><?php echo $row['date'];?></a>
                                        </td>
                                        <td class="action-td"><?php echo $row['discount_id'];?></td>
                                        <td class="amt-td"><?php echo $row['amount'];?></td>
                                        <?php
                                            $type = $row['type'];
                                            if ($type == 'labs') 
                                            {
                                                $lab_list_id = $row['lab_list_id'];
                                                $query_bill = "SELECT * FROM lab_list WHERE lab_list_id = '$lab_list_id'";
                                                $query_run_bill = mysqli_query($con, $query_bill);
                                                $row_bill = mysqli_fetch_assoc($query_run_bill);
                                                $bill_id = $row_bill['lab_list_id'];
                                                $bill_amount = $row_bill['amount_cash'];
                                            } 
                                            else if($type == 'surgery') 
                                            {
                                                $surgery_list_id = $row['surgery_list_id'];
                                                $query_bill = "SELECT * FROM surgery_list WHERE surgery_list_id = '$surgery_list_id'";
                                                $query_run_bill = mysqli_query($con, $query_bill);
                                                $row_bill = mysqli_fetch_assoc($query_run_bill);
                                                $bill_id = $row_bill['surgery_list_id'];
                                                $bill_amount = $row_bill['amount_cash'];
                                            } 
                                            else if($type == 'service') 
                                            {
                                                $service_list_id = $row['service_list_id'];
                                                $query_bill = "SELECT * FROM service_list WHERE service_list_id = '$service_list_id'";
                                                $query_run_bill = mysqli_query($con, $query_bill);
                                                $row_bill = mysqli_fetch_assoc($query_run_bill);
                                                $bill_id = $row_bill['service_list_id'];
                                                $bill_amount = $row_bill['amount_cash'];
                                            } 
                                            else if($type == 'consumable') 
                                            {
                                                $con_list_id = $row['con_list_id'];
                                                $query_bill = "SELECT * FROM consumable_list WHERE con_list_id = '$con_list_id'";
                                                $query_run_bill = mysqli_query($con, $query_bill);
                                                $row_bill = mysqli_fetch_assoc($query_run_bill);
                                                $bill_id = $row_bill['con_list_id'];
                                                $bill_amount = $row_bill['amount_cash'];
                                            } 
                                            else if($type == 'drug') 
                                            {
                                                $drug_list_id = $row['drug_list_id'];
                                                $query_bill = "SELECT SUM(amt_cash) AS amount_cash FROM  drug_dispense_list WHERE drug_list_id='$drug_list_id'";
                                                $query_run_bill = mysqli_query($con, $query_bill);
                                                $row_bill = mysqli_fetch_assoc($query_run_bill);
                                                $bill_id = $row['drug_list_id'];
                                                $bill_amount = $row_bill['amount_cash'];
                                            } 
                                            else if($type == 'radiology') 
                                            {
                                                $radio_list_id = $row['radio_list_id'];
                                                $query_bill = "SELECT * FROM radio_list WHERE radio_list_id = '$radio_list_id'";
                                                $query_run_bill = mysqli_query($con, $query_bill);
                                                $row_bill = mysqli_fetch_assoc($query_run_bill);
                                                $bill_id = $row_bill['radio_list_id'];
                                                $bill_amount = $row_bill['amount_cash'];
                                            };
                                            
                                            $patient_id = $row['patient_id'];
                                            $query_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
                                            $query_run_patient = mysqli_query($con, $query_patient);
                                            $row_patient = mysqli_fetch_assoc($query_run_patient);
                                        ?>
                                        <td><?php echo $row_patient['firstName'].' '.$row_patient['lastName'];?></td>
                                        <td class="action-td"><?php echo $bill_id;?></td>
                                        <td class="amt-td">
                                            <?php if(isset($row_receipt)){echo $bill_amount;}else{echo 'N/A';};?>
                                        </td>
        	                            <td class="action-td">
		                                    <a href="#" id="btn_discount_reprint" data-id="<?php echo $row['discount_id'];?>">Reprint</a>
                                            |
                                            <a href="#" id="btn_edit_discount" data-id="<?php echo $row['discount_id'];?>"><i class="fa fa-edit fa-sm"></i></a>
		                                    |
        									<a href="#" id="btn_delete_discount" data-id2="<?php echo $row['discount_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
        	                            </td>
                                    </tr>
                        <?php
                                }
                            }
                            else
                            {
                                    echo 'No Discount Not Found';
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/discount_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>