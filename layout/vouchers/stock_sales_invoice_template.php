<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    
    $stock_sales_id = $_SESSION['stock_sales_id'];
    $query_stock_sales = "SELECT * FROM stock_sales WHERE stock_sales_id='$stock_sales_id'";
    $result_stock_sales = mysqli_query($con,$query_stock_sales);
    $row_stock_sales = mysqli_fetch_assoc($result_stock_sales);

    
	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
	$time = date('H-i-sa');
 ?>
  <style type="text/css">
    .scroll-card {height: 800px;overflow-y: auto;}
    .scroll-card-items {height: 385px;overflow-y: auto;}
    .scroll-card-div {height: 600px;overflow-y: auto;}
    .scroll-card-body {max-height: 700px;overflow-y: auto;}
    .amt-td {text-align:right;}
    .action-td {text-align:center;}
</style>
<div class="container-fluid scroll-card">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Sales Invoice
	            </h4>
                <div class="input-group">
                </div>
            </div>
            <div class="float-right">
                <a href="#" data-toggle="" id="stock_sales_invoice_search_item">Search Item</a>
                | 
                <a href="#" data-toggle="" data-id="invoice" id="new_customer_icon">New Customer</a>
                | 
                <a href="#" data-toggle="" data-id="invoice" id="search_customer_icon">Search Customer</a>
                | 
                <a href="#" data-toggle="" id="new_stock_sales_icon">History</a>
                | 
                <a href="#" 
                    data-id="<?php echo $stock_sales_id;?>" 
                    data-id1="<?php echo $row_stock_sales['date'];?>"
                    id="stock_sales_invoice_vitals_btn">Vital</a>
                | 
                <a href="#" 
                    data-id="<?php echo $stock_sales_id;?>" 
                    data-id1="<?php echo $row_stock_sales['date'];?>"
                    id="stock_sales_invoice_labs">Labs</a>
                | 
                <a href="#" data-toggle="" id="new_stock_sales_icon">Customer Activities</a>
	        </div>
        </div>
        <div class="card-body">
            <form action="" method="POST" id="stock_sales_invoice_form">
                <div class="form-row">
                    <div class="col-md-5 mb-5 scroll-card-div">
                        <div class="table-responsive" id="stock_sales_invoice_customer_details">
                            <?php 
                                /*$customer_id = $row_stock_sales['customer_id'];
                                $query_customer = "SELECT * FROM customer WHERE customer_id='$customer_id'";
                                $result_customer = mysqli_query($con,$query_customer);
                                $row_customer = mysqli_fetch_assoc($result_customer);

                                $insurance_id = $row_stock_sales['insurance_id'];
                                $query_ins = "SELECT * FROM ledgers WHERE ledger_id='$insurance_id'";
                                $result_ins = mysqli_query($con,$query_ins);
                                $row_ins = mysqli_fetch_assoc($result_ins);*/
                                
                                $insurance_id = $row_stock_sales['insurance_id'];
                                $query_ins = "SELECT * FROM ledgers WHERE ledger_id = '$insurance_id'";
                                $query_run_ins = mysqli_query($con, $query_ins);
                                if (mysqli_num_rows($query_run_ins) > 0)
                                {
                                    $row_ins = mysqli_fetch_assoc($query_run_ins);
                                    $insurance_company = $row_ins['ledger_desc'];
                                }
                                else
                                {
                                    $insurance_company = '';
                                };
                    
                                $customer_id = $row_stock_sales['customer_id'];
                                $query_cust = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
                                $query_run_cust = mysqli_query($con, $query_cust);
                                if (mysqli_num_rows($query_run_cust) > 0)
                                {
                                    $row_cust = mysqli_fetch_assoc($query_run_cust);
                                    $customer = $row_cust['first_name'].' '.$row_cust['last_name'];
                                    $customer_id = $row_cust['id_number'];
                                    $customer_tel = $row_cust['phone_number'];
                                    $customer_gender = $row_cust['gender'];
                                }
                                else
                                {
                                    $customer = '';
                                    $customer_id = '';
                                    $customer_tel = '';
                                    $customer_gender = '';
                                };
                            ?>
                            <table class="table table-hover table-bordered table-sm" id="stock_sales_invoice_customer_detailsTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <td><strong>Name</strong></td>
                                        <td colspan="2"><?php echo $customer;?></td>
                                        <td class="action-td">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Age</strong></td>
                                        <td><?php echo $row_stock_sales['age'];?></td>
                                        <td><strong>Phone No:</strong></td>
                                        <td><?php echo $customer_tel;?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Sex</strong></td>
                                        <td><?php echo $customer_gender;?></td>
                                        <td><strong>ID No:</strong></td>
                                        <td><?php echo $row_stock_sales['id_number'];?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Company:</strong></td>
                                        <td colspan="3"><?php echo $insurance_company;?></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="table-responsive" id="stock_sales_invoice_payment_option">
                            <table class="table table-hover table-bordered table-sm" id="stock_sales_invoice_payment_optionTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr id="1">
                                        <th width="60%" class = "action-td"><a href="#" data-toggle="" id="stock_sales_invoice_add_ledger">Ledger</a></th>
                                        <th width="40%" class = "action-td" colspan="2">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="pv-table-body">
                                    <?php 
                                        $query_trans = "SELECT * FROM transactions WHERE stock_sales_id='$stock_sales_id' AND amt_debit > 0";
                                        $result_trans = mysqli_query($con,$query_trans);
                                        if (mysqli_num_rows($result_trans) > 0)
                                        {
                                            $payment_option_total = 0;
                                            while($row_trans = mysqli_fetch_assoc($result_trans))
                                            {
                                                $ledger_id = $row_trans['ledger_id'];
                                                $query_ledger = "SELECT * FROM ledgers WHERE ledger_id ='$ledger_id'";
                                                $result_ledger = mysqli_query($con,$query_ledger);
                                                $row_ledger = mysqli_fetch_assoc($result_ledger);

                                                $amount_debit_f = number_format($row_trans['amt_debit'], 2, '.', ',');
                                                echo '<tr>
                                                    <td width="50%">
                                                    '.$row_ledger['ledger_desc'].'
                                                    </td>
                                                    <td width="30%" class="amt-td">
                                                    '.$amount_debit_f.'
                                                     </td>
                                                    <td width="20%" class="action-td">
                                                     </td>
                                                </tr>';
                                                $payment_option_total = $payment_option_total + $row_trans['amt_debit'];
                                            };
                                            $payment_option_total_f = number_format($payment_option_total, 2, '.', ',');
                                            $cash_tendered_f = number_format($row_stock_sales['cash_tendered'], 2, '.', ',');
                                            $balance_f = number_format($row_stock_sales['balance'], 2, '.', ',');
                                            echo '<table class="table table-hover table-bordered table-sm" id="stock_sales_invoice_payment_optionTotalTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <th width="60%" class = "amt-td">Total</th>
                                                    <th width="30%" class = "amt-td">
                                                    '.$payment_option_total_f.'
                                                    </th>
                                                    <th width="10%" class = "action-td"></th>
                                                </thead>
                                                <thead>
                                                    <th width="60%" class = "amt-td">Cash Tendered</th>
                                                    <th width="30%" class = "amt-td">
                                                    '.$cash_tendered_f.'
                                                    </th>
                                                    <th width="10%" class = "action-td"></th>
                                                </thead>
                                                <thead>
                                                    <th width="60%" class = "amt-td">Change</th>
                                                    <th width="30%" class = "amt-td">
                                                    '.$balance_f.'
                                                    </th>
                                                    <th width="10%" class = "action-td"></th>
                                                </thead>
                                            </table>';
                                        };
                                    ?>
                                </tbody>
                            </table>
                            
                        </div>
                        <div class="table-responsive" id="stock_sales_invoice_warehouse_cash_ledger">
                            <table class="table table-hover table-bordered table-sm" id="stock_sales_invoice_warehouse_cash_ledgerTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="50%" class = "action-td">Default Warehouse</th>
                                        <th width="50%" class = "action-td">Default Date</th>
                                    </tr>
                                </thead>
                                <tbody class="pv-table-body">
                                    <?php
                                        $warehouse_id = $row_stock_sales['warehouse_id'];
                                        $query_warehouse = "SELECT * FROM warehouse WHERE warehouse_id='$warehouse_id'";
                                        $result_warehouse = mysqli_query($con,$query_warehouse);
                                        $row_warehouse = mysqli_fetch_assoc($result_warehouse);
                                        
                                        echo'<tr>
                                            <td width="50%">
                                            '.$row_warehouse['warehouse_desc'].'
                                            </td>
                                            <td width="50%">
                                            '.$row_stock_sales['date'].'
                                            </td>
                                        </tr>';
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-7 mb-7 scroll-card-div">
                        <div class="table-responsive scroll-card-items" id="stock_sales_invoice_list_table">
                            <table class="table table-hover table-bordered table-sm" id="stock_sales_invoiceTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr id="1">
                                        <th width="40%" class = "action-td">Item Description</th>
                                        <th width="10%" class = "action-td">Qty</th>
                                        <th width="10%" class = "action-td">Price</th>
                                        <th width="15%" class = "action-td">Amount</th>
                                        <th width="15%" class = "action-td">Disc</th>
                                        <th width="10%" class = "action-td">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="pv-table-body">
                                    <?php 
                                        $query_sales_item_list = "SELECT * FROM stock_sales_items WHERE stock_sales_id='$stock_sales_id'";
                                        $result_sales_item_list = mysqli_query($con,$query_sales_item_list);
                                        if (mysqli_num_rows($result_sales_item_list) > 0)
                                        {
                                            while($row_sales_item_list = mysqli_fetch_assoc($result_sales_item_list))
                                            {
                                                $stock_item_id = $row_sales_item_list['stock_item_id'];
                                                $query_stock_item = "SELECT * FROM stock_items WHERE stock_item_id='$stock_item_id'";
                                                $result_stock_item = mysqli_query($con,$query_stock_item);
                                                $row_stock_item = mysqli_fetch_assoc($result_stock_item);

                                                $price_f = number_format($row_sales_item_list['price'], 2, '.', ',');
                                                $amount_f = number_format($row_sales_item_list['amount'], 2, '.', ',');
                                                $amount_disc_f = number_format($row_sales_item_list['amount_disc'], 2, '.', ',');
                                                echo '<tr>
                                                    <td>'.$row_stock_item['stock_item'].'</td>
                                                    <td class = "action-td">'.$row_sales_item_list['qty'].'</td>
                                                    <td class = "amt-td">'.$price_f.'</td>
                                                    <td class = "amt-td">'.$amount_f.'</td>
                                                    <td class = "amt-td">'.$amount_disc_f.'</td>
                                                    <td class = "action-td">
                                                        <a href="#" 
                                                            data-id="'.$row_sales_item_list['sales_item_id'].'" 
                                                            data-id1="'.$row_sales_item_list['stock_item_id'].'"
                                                            data-id2="'.$row_stock_sales['date'].'"
                                                            id="label_stock_sales_invoice">Label</a>
                                                        | 
                                                        <a href="#" 
                                                            data-id="'.$row_sales_item_list['sales_item_id'].'" 
                                                            data-id1="'.$row_stock_sales['date'].'"
                                                            id="mur_stock_sales_invoice">MUR</a>
                                                    </td>
                                                </tr>';
                                            };
                                        };
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php 
                            
                                $user_id = $row_stock_sales['created_by'];
                                $sql_user = "SELECT * FROM users WHERE id = '$user_id'";
                                $result_user = mysqli_query($con,$sql_user);
                                $row_user = mysqli_fetch_array($result_user);
                            
                                $branch_id = $row_stock_sales['branch_id'];
                                $sql_branch = "SELECT * FROM branch WHERE branch_id = '$branch_id'";
                                $result_branch = mysqli_query($con,$sql_branch);
                                $row_branch = mysqli_fetch_array($result_branch);

                                $total_invoice_value = $row_stock_sales['total_invoice_value'];
                                $total_invoice_value_f = number_format($total_invoice_value, 2, '.', ',');

                                $discount = $row_stock_sales['discount'];
                                $discount_f = number_format($discount, 2, '.', ',');

                                $tax = $row_stock_sales['tax'];
                                $tax_f = number_format($tax, 2, '.', ',');
                                
                                $net_amount = $row_stock_sales['net_amount'];
                                $net_amount_f = number_format($net_amount, 2, '.', ',');
                        ?>
                        <div class="table-responsive" id="stock_sales_invoice_total_table">
                            <table class="table table-hover table-bordered table-sm" id="stock_sales_totalTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="40%">Branch: <?php echo $row_branch['branch_name'];?></th>
                                        <th width="30%" class = "amt-td">Sub Total</th>
                                        <th width="30%" class = "amt-td"><?php echo $total_invoice_value_f;?></th>
                                    </tr>
                                    <tr>
                                        <th width="40%">User: <?php echo $row_user['first_name'].' '.$row_user['last_name'];?></th>
                                        <th width="30%" class = "amt-td">Discount</th>
                                        <th width="30%" class = "amt-td"><?php echo $discount_f;?></th>
                                    </tr>
                                    <tr>
                                        <th width="40%">Date: <?php echo $row_stock_sales['date'];?></th>
                                        <th width="30%" class = "amt-td">Tax</th>
                                        <th width="30%" class = "amt-td"><?php echo $tax_f;?></th>
                                    </tr>
                                    <tr>
                                        <th width="40%">Time: <?php echo $row_stock_sales['created_datetime'];?></th>
                                        <th width="30%" class = "amt-td">Net Total</th>
                                        <th width="30%" class = "amt-td"><?php echo $net_amount_f;?></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <a href="/layout/vouchers/stock_sales_invoice.php" class="btn btn-primary btn-block" id="stock_sales_invoice_new_tn">New Invoice</a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <!--<button type="submit" name="stock_sales_invoice_void_btn" id="stock_sales_invoice_void_btn" class="btn btn-primary btn-block">Void</button>-->
                    </div>
                    <div class="col-md-3 mb-3">
                        <button type="submit" 
                            name="stock_sales_invoice_save_btn" 
                            id="stock_sales_invoice_print_btn" 
                            data-id="<?php echo $stock_sales_id;?>"
                            data-type="<?php echo $row_stock_sales['type'];?>"
                            class="btn btn-primary btn-block">Print Invoice</button>
                    </div>
                    <div class="col-md-3 mb-3">
                        <!--<button type="submit" name="stock_sales_invoice_cancel_btn" id="stock_sales_invoice_cancel_btn" class="btn btn-danger btn-block">Cancel</button>-->
                        <a href="/layout/vouchers/stock_sales_list.php" class="btn btn-danger btn-block" id="stock_sales_invoice_cancel_btn">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
          <?php //include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
    </div>
</div>

<?php include('stock_sales_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_sales_invoice_lab_list_result_view_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_sales_invoice_lab_list_enter_result_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_sales_invoice_lab_list_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_sales_invoice_vitals_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_sales_invoice_mur_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_sales_invoice_label_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/customer_setup_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_search_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php //include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>