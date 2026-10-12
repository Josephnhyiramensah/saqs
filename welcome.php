<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/sessions.php');

    $company_id = $_SESSION['company_id'];
	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
	$time = date('H-i-sa');

    echo '<style type="text/css">
        input {border-top-style: hidden;border-right-style: hidden;border-left-style: hidden;
            border-bottom-style: hidden;background-color: #ffffff;}
        .amt-td {text-align:right;}
        .action-td {text-align:center;}
        .scroll_search_div {max-height: 300px;overflow-y: auto;}
    </style>
    <div class="container-fluid">
        <div class="card shadow md-4 mx-auto" style="width: 95%;">
            <div class="card-header">
                <h3 class="m-0 font-weight-bold text-primary">
                    <a href="#">Welcome</a>
                </h3>
            </div>
            <div class="card-body p-5">';
            
                if (isset($_SESSION['company_type_id']))
                {
                    $company_type_id = $_SESSION['company_type_id'];
                }else{
                    $company_type_id = 0;
                };
                
                if($company_type_id == 2 || $company_type_id == 3)
                {
                    echo '<div class="form-row px-5">
                        <div class="col-md-3 mb-3 align-items-center">
                            <a href="/layout/vouchers/stock_sales_list.php" class="btn btn-primary btn-lg btn-block text-white">Sales</a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="/layout/vouchers/purchases_list.php" class="btn btn-primary btn-lg btn-block text-white">Purchases</a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a id="mini_stock_report_link" href="#" class="btn btn-primary btn-lg btn-block text-white">Mini Stock</a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a id="sales_report_link" href="#" class="btn btn-primary btn-lg btn-block text-white">Sales Report</a>
                        </div>
                    </div>';
                }
                else
                {
                    echo '<div class="form-row px-5">
                        <div class="col-md-3 mb-3 align-items-center">
                            <a id="opdbtn" href="/layout/attendance/attend_list_opd.php" class="btn btn-primary btn-lg btn-block text-white">Out-Patient</a>
                            <!--<a href=""><small class="text-center">Other Attendance</small></a>-->
                        </div>
                        <div class="col-md-3 mb-3">
                            <a id="ipdbtn" href="/layout/attendance/attend_list_ipd.php" class="btn btn-primary btn-lg btn-block text-white">In-Patient</a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a id="ipdbtn" href="/layout/attendance/attend_list_detention.php" class="btn btn-primary btn-lg btn-block text-white">Detention</a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a id="apptbtn" href="/layout/attendance/appointment.php" class="btn btn-primary btn-lg btn-block text-white">Appointment</a>
                        </div>
                    </div>
                    <div class="footer px-5">
                        <div class="form-row px-5">
                            <div class="col-md-3 mb-3">
                                <button type="submit" id="walkinbtn" class="btn btn-primary btn-sm btn-block" hidden="true">Walk-In</button>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="/layout/patients/patient_list.php" id="findpatentbtn" class="btn btn-primary btn-sm btn-block">Find Patient</a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="/layout/attendance/visitors_register.php" id="visitors_register_btn" class="btn btn-primary btn-sm btn-block">Visitors Register</a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="submit" id="refillbtn" class="btn btn-primary btn-sm btn-block" hidden="true">Refill</button>
                            </div>
                        </div>
                    </div>';
                };

                $query_so = "SELECT * FROM sales_order WHERE `company_id` ='$company_id' AND sales_order_id NOT IN (SELECT sales_order_id FROM stock_sales)";
                //$query_so = "SELECT * FROM `sales_order` WHERE `company_id` ='$company_id' AND  `status` ='pending'";
                $result_so = mysqli_query($con,$query_so);
                $rows_result_so = mysqli_num_rows($result_so);
                    
                $query = "SELECT * FROM stock_requisition WHERE (`company_id` ='$company_id' OR company_id_to = '$company_id') AND stock_req_id NOT IN (SELECT stock_req_id FROM stock_sales)";
                //$query = "SELECT * FROM stock_requisition WHERE company_id = '$company_id' OR company_id_to = '$company_id' ORDER BY date ASC";
                $query_run = mysqli_query($con, $query);
                $rows_query_run = mysqli_num_rows($query_run);

                if($rows_result_so > 0 OR $rows_query_run > 0)
                {
                    echo '<div class="scroll_search_div">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#branch_stock_requisition"><strong>BRANCH REQUISITION</strong></a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#customer_stock_requisition" id="customer_requisition_list" data-id="'.$company_id.'"><strong>CUSTOMER REQUISITION</strong></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="branch_stock_requisition" class="tab-pane fade show active">
                                <div class="table-responsive" id="stock_requisition_list_table">
                                    <table class="table table-hover table-bordered table-sm" id="stockrequisitionTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class = "action-td">ID</th>
                                                <th class = "action-td">Date</th>
                                                <th>Requested By</th>
                                                <th class = "action-td">Requested To</th>
                                                <th class = "action-td">Requested From</th>
                                                <th class = "action-td">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="pv-table-body">';
                                            if (mysqli_num_rows($query_run) > 0)
                                            {
                                                while($row = mysqli_fetch_assoc($query_run))
                                                {
                                                    $stock_req_id = $row['stock_req_id'];
                                                    $query_ss = "SELECT * FROM stock_sales WHERE stock_req_id = '$stock_req_id'";
                                                    $result_ss = mysqli_query($con,$query_ss);

                                                    if (mysqli_num_rows($result_ss) < 1)
                                                    {
                                                        $warehouse_from = $row['warehouse_from'];
                                                        $warehouse_to = $row['warehouse_to'];

                                                        $query_warehouse_from = "SELECT * FROM warehouse WHERE warehouse_id ='$warehouse_from'";
                                                        $query_warehouse_from_run = mysqli_query($con, $query_warehouse_from);
                                                        $row_warehouse_from = mysqli_fetch_assoc($query_warehouse_from_run);

                                                        $query_warehouse_to = "SELECT * FROM warehouse WHERE warehouse_id ='$warehouse_to'";
                                                        $query_warehouse_to_run = mysqli_query($con, $query_warehouse_to);
                                                        $row_warehouse_to = mysqli_fetch_assoc($query_warehouse_to_run);
                                            
                                                        echo '<tr>
                                                            <td class = "action-td">'.$row['stock_req_id'].'</td>
                                                            <td class = "action-td">'.$row['date'].'</td>
                                                            <td>'.$row['requested_by'].'</td>
                                                            <td class = "action-td">'.$row_warehouse_to['warehouse_desc'].'</td>
                                                            <td class = "action-td">'.$row_warehouse_from['warehouse_desc'].'</td>
                                                            <td class = "action-td">';
                                                            
                                                                $requisition_id = $row['stock_req_id'];
                                                                $query_req_trans = "SELECT * FROM stock_transfer WHERE stock_req_id ='$requisition_id'";
                                                                $query_run_req_trans = mysqli_query($con, $query_req_trans);
                                                                if (mysqli_num_rows($query_run_req_trans) < 1)
                                                                {
                                                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Stock_Transfer'] == 'Yes')) 
                                                                    {
                                                                        if($row_warehouse_to['company_id']==$_SESSION['company_id'])
                                                                        {
                                                                            echo '<a href="#" id="btn_transfer_stock_req" data-id="'.$row['stock_req_id'].'">Transfer</a>';
                                                                        };
                                                                    };
                                                                };
                                                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Stock_Requisition'] == 'Yes')) 
                                                                {
                                                                    if($row_warehouse_from['company_id']==$_SESSION['company_id'])
                                                                    {
                                                                        echo ' | <a href="#" id="btn_edit_stock_req" data-id="'.$row['stock_req_id'].'">Edit</a>';
                                                                    }
                                                                };
                                                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Purchases'] == 'Yes')) 
                                                                {
                                                                    if($row_warehouse_to['company_id']==$_SESSION['company_id'])
                                                                    {
                                                                        echo ' | <a href="#" id="btn_new_shipment_from_stock_req" 
                                                                            data-stock_req_id="'.$row['stock_req_id'].'"
                                                                            data-warehouse_from="'.$row['warehouse_from'].'"
                                                                            data-warehouse_to="'.$row['warehouse_to'].'"
                                                                            data-company_from="'.$row_warehouse_from['company_id'].'"
                                                                            data-company_to="'.$row_warehouse_to['company_id'].'"
                                                                        >Ship</a>';
                                                                    };
                                                                };
                                                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Stock_Requisition'] == 'Yes')) 
                                                                {
                                                                    if($row_warehouse_from['company_id']==$_SESSION['company_id'])
                                                                    {
                                                                        echo ' | <a href="#" id="btn_delete_stock_req" data-id="'.$row['stock_req_id'].'">Delete</a>';
                                                                    }
                                                                };
                                                            echo '</td>
                                                        </tr>';
                                                    };
                                                }
                                            }
                                            else
                                            {
                                                echo 'No Stock Requisition Not Found';
                                            };
                                        echo '</tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="customer_stock_requisition" class="tab-pane fade">';

                                $query_so = "SELECT * FROM `sales_order` WHERE `company_id` ='$company_id' AND  `status` ='pending'";
                                $result_so = mysqli_query($con,$query_so);

                                if(mysqli_num_rows($result_so) > 0)
                                {
                                    echo '<div class="form-row">
                                        <div class="col-md-12 mb-12">
                                            <div class="table-responsive scroll-card-items" id="pending_sales_order_list_table">
                                                <table class="table table-hover table-bordered table-sm" id="pending_sales_order_table" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr id="1">
                                                            <th class = "action-td" colspan="5">PENDING SALES ORDER</th>
                                                        </tr>
                                                        <tr id="2">
                                                            <th class = "action-td">S/No</th>
                                                            <th class = "action-td">Date</th>
                                                            <th>Customer Name</th>
                                                            <th class = "action-td">Telephone</th>
                                                            <th class = "action-td">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="pv-table-body">';
                                                        $i=2;
                                                        $x=0;
                                                        while($row_so = mysqli_fetch_assoc($result_so))
                                                        {
                                                            $i++;
                                                            $x++;

                                                            $sales_order_id = $row_so['sales_order_id'];
                                                            $query_ss = "SELECT * FROM stock_sales WHERE sales_order_id = '$sales_order_id'";
                                                            $result_ss = mysqli_query($con,$query_ss);

                                                            if (mysqli_num_rows($result_ss) < 1)
                                                            {
                                                                echo '<tr id="'.$i.'">
                                                                    <td class = "action-td">'.$x.'</td>
                                                                    <td class = "action-td">'.$row_so['date'].'</td>
                                                                    <td>'.$row_so['customer_name'].'</td>
                                                                    <td class = "action-td">'.$row_so['telephone'].'</td>
                                                                    <td class = "action-td">';
                                                                        echo '<a href="#" id="sales_order_conversion_btn" data-sales_order_id="'.$row_so['sales_order_id'].'">Convert</a>';
                                                                    
                                                                        echo ' | <a href="#" id="sales_order_print_btn" data-id="'.$row_so['sales_order_id'].'">Reprint</a>';

                                                                    echo '</td>
                                                                </tr>';
                                                            };
                                                        }
                                                    echo '</tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>';
                                };
                            echo '</div>
                        </div>
                    </div>';
                }
            echo '</div>
        </div>
    </div>';
?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_sales_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>