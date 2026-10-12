<?php 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    if(isset($_SESSION['search_clinic'])){$search_clinic = $_SESSION['search_clinic'];}else{$search_clinic = 0;};
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
            max-height: 750px;
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
	                Attendance Cash Bills
	            </h4>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">
		            	<label>Name</label>
        				<input type="text" class="form-control border-0 small" name="search_attend_revenue_name" id="search_attend_revenue_name">
		            </div>
		            <div class="input-group">
		            	<label>From</label>
                        <?php
                            if($remember_state == true)
                            {
                        ?>
                                <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_attend_revenue_from" id="search_attend_revenue_from" value="<?php echo $search_from;?>">
                        <?php
                            }
                            else
                            {
                        ?>
                                <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_attend_revenue_from" id="search_attend_revenue_from">
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
                                    <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_attend_revenue_to" id="search_attend_revenue_to" value="<?php echo $search_to;?>">
                            <?php
                                }
                                else
                                {
                            ?>
                                    <input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="search_attend_revenue_to" id="search_attend_revenue_to">

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
                    $query = "SELECT * FROM attendance ORDER BY date_admit DESC";
                    $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="attend-table">
                <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">Date</th>
                            <th>Patient Name</th>
                            <th class="action-td">Service</th>
                            <th class="action-td">Labs</th>
                            <th class="action-td">Radiology</th>
                            <th class="action-td">Drugs</th>
                            <th class="action-td">Surgeries</th>
                            <th class="action-td">Consumables</th>
                            <th class="action-td">Total Bill</th>
                            <th class="action-td">Discount</th>
                            <th class="action-td">Receipt</th>
                            <th class="action-td">Refund</th>
                            <th class="action-td">Balance</th>
                            <th class="action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                                    if($row['nhis_led_id'] > 0 && $row['prvt_led_id'] > 0 )
                                        {
                                            $sponsor_id = $row['nhis_led_id'];
                                        }
                                    else if($row['nhis_led_id'] > 0 && $row['prvt_led_id'] <= 0 )
                                        {
                                            $sponsor_id = $row['nhis_led_id'];
                                        }
                                    else if($row['nhis_led_id'] <= 0 && $row['prvt_led_id'] > 0 )
                                        {
                                            $sponsor_id = $row['prvt_led_id'];
                                        }
                                    else if($row['nhis_led_id'] <= 0 && $row['prvt_led_id'] <= 0 )
                                        {
                                            $sponsor_id = 1;
                                        }
                                    $query = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
                                    $query_run_led = mysqli_query($con, $query);
                                    $row_led=mysqli_fetch_assoc($query_run_led);
                        ?>
                            <tr>
	                            <td class="action-td">
                                    <?php echo $row['date_admit'];?>
                                </td>
                                <?php 
                                    $patient_id = $row['patient_id'];
                                    $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                                    $query_run_p = mysqli_query($con, $query_p);
                                    $row_p = mysqli_fetch_assoc($query_run_p);
                                ?>
                                <td><?php echo $row_p['firstName']." ". $row_p['lastName'];?></td>
                                <td class="amt-td">
                                    <?php
                                        $attend_id = $row['attend_id']; 
                                        $query_service = "SELECT SUM(amount_cash) AS service_bill FROM service_list WHERE attend_id='$attend_id'";
                                        $query_run_service = mysqli_query($con, $query_service);
                                        $row_service=mysqli_fetch_assoc($query_run_service);
                                        $bill_service = $row_service['service_bill'];
                                        $bill_service = number_format($bill_service, 2, '.', ',');
                                        echo $bill_service;
                                    ?>
                                </td>
                                <td class="amt-td">
                                    <?php 
                                        $query_lab = "SELECT SUM(amount_cash) AS lab_bill FROM lab_list WHERE attend_id='$attend_id'";
                                        $query_run_lab = mysqli_query($con, $query_lab);
                                        $row_lab=mysqli_fetch_assoc($query_run_lab);
                                        $bill_labs = $row_lab['lab_bill'];
                                        $bill_labs = number_format($bill_labs, 2, '.', ',');
                                        echo $bill_labs;
                                    ?>
                                </td>
                                <td class="amt-td">
                                    <?php
                                        $query_radio = "SELECT SUM(amount_cash) AS radio_bill FROM radio_list WHERE attend_id='$attend_id'";
                                        $query_run_radio = mysqli_query($con, $query_radio);
                                        $row_radio=mysqli_fetch_assoc($query_run_radio);
                                        $bill_radio = $row_radio['radio_bill'];
                                        $bill_radio = number_format($bill_radio, 2, '.', ',');
                                        echo $bill_radio;
                                    ?>
                                </td>
                                <td class="amt-td">
                                    <?php
                                        $query_drug = "SELECT SUM(amt_cash) AS drug_bill FROM drug_dispense_list WHERE attend_id='$attend_id'";
                                        $query_run_drug = mysqli_query($con, $query_drug);
                                        $row_drug=mysqli_fetch_assoc($query_run_drug);
                                        $bill_drugs = $row_drug['drug_bill'];
                                        $bill_drugs = number_format($bill_drugs, 2, '.', ',');
                                        echo $bill_drugs;
                                    ?>
                                </td>
                                <td class="amt-td">
                                    <?php
                                        $query_surgery = "SELECT SUM(amount_cash) AS surgery_bill FROM surgery_list WHERE attend_id='$attend_id'";
                                        $query_run_surgery = mysqli_query($con, $query_surgery);
                                        $row_surgery=mysqli_fetch_assoc($query_run_surgery);
                                        $bill_surgery = $row_surgery['surgery_bill'];
                                        $bill_surgery = number_format($bill_surgery, 2, '.', ',');
                                        echo $bill_surgery;
                                    ?>
                                </td>
                                <td class="amt-td">
                                    <?php
                                        $query_consum = "SELECT SUM(amount_cash) AS consum_bill FROM consumable_list WHERE attend_id='$attend_id'";
                                        $query_run_consum = mysqli_query($con, $query_consum);
                                        $row_consum=mysqli_fetch_assoc($query_run_consum);
                                        $bill_consum = $row_consum['consum_bill'];
                                        $bill_consum = number_format($bill_consum, 2, '.', ',');
                                        echo $bill_consum;
                                    ?>
                                </td>
                                <td class="amt-td">
                                    <?php
                                        
                                        $total_bill = $row_service['service_bill'] +
                                            $row_lab['lab_bill'] +
                                            $row_radio['radio_bill'] +
                                            $row_drug['drug_bill'] +
                                            $row_surgery['surgery_bill'] +
                                            $row_consum['consum_bill'];

                                        $bill_total = $row_service['service_bill'] +
                                            $row_lab['lab_bill'] +
                                            $row_radio['radio_bill'] +
                                            $row_drug['drug_bill'] +
                                            $row_surgery['surgery_bill'] +
                                            $row_consum['consum_bill'];

                                        $bill_total = number_format($bill_total, 2, '.', ',');
                                        echo $bill_total;
                                    ?>
                                </td>
                                <td class="amt-td">
                                    <?php
                                        $query_discount = "SELECT SUM(amount) AS amount_discount FROM discount WHERE attend_id='$attend_id'";
                                        $query_run_discount = mysqli_query($con, $query_discount);
                                        $row_discount=mysqli_fetch_assoc($query_run_discount);
                                        $discount_total = $row_discount['amount_discount'];
                                        $discount_total = number_format($discount_total, 2, '.', ',');
                                        echo $discount_total;
                                    ?>   
                                </td>
	                            <td class="amt-td">
                                    <?php
                                        $query_receipt = "SELECT SUM(amount) AS amount_rec FROM receipt WHERE attend_id='$attend_id'";
                                        $query_run_receipt = mysqli_query($con, $query_receipt);
                                        $row_receipt=mysqli_fetch_assoc($query_run_receipt);
                                        $receipt_total = $row_receipt['amount_rec'];
                                        $receipt_total = number_format($receipt_total, 2, '.', ',');
                                        echo $receipt_total;
                                    ?>   
                                </td>
                                <td class="amt-td">
                                    <?php
                                        $query_refund = "SELECT SUM(amount) AS amount_refund FROM refund WHERE attend_id='$attend_id'";
                                        $query_run_refund = mysqli_query($con, $query_refund);
                                        $row_refund=mysqli_fetch_assoc($query_run_refund);
                                        $refund_total = $row_refund['amount_refund'];
                                        $refund_total = number_format($refund_total, 2, '.', ',');
                                        echo $refund_total;
                                    ?>   
                                </td>
                                <td class="amt-td">
                                    <?php
                                        $grand_total = $total_bill - $row_discount['amount_discount'] - $row_receipt['amount_rec'] + $row_refund['amount_refund'];
                                        $grand_total = number_format($grand_total, 2, '.', ',');
                                        echo $grand_total;
                                    ?>
                                </td>
                                <td class="action-td">
                                    <a href="#" 
                                        id="btn_new_receipt" 
                                        data-id="<?php echo $row['attend_id'];?>" 
                                        data-id1="<?php echo $row_p['firstName']." ". $row_p['lastName'];?>"
                                        data-id2="<?php echo $row['patient_id'];?>">New Receipt</a>
                                    <!--<a href="#" id="btn_enter_receipt_deposit" data-id="<?php //echo $row['attend_id'];?>" data-id2="<?php //echo $row['patient_id'];?>">Deposit</a>
                                    |
                                    <a href="#" id="btn_enter_receipt_itemise" data-id="<?php //echo $row['attend_id'];?>" data-id2="<?php //echo $row['patient_id'];?>">Itemise</a>-->
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
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/receipt_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>