<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');

    if(isset($_SESSION['branch_id'])){$user_branch_id = $_SESSION['branch_id'];}else{$user_branch_id = '';};
    if(isset($_SESSION['company_id'])){$company_id = $_SESSION['company_id'];}else{$company_id = '';};
    if(isset($_SESSION['search_from'])){$search_from = $_SESSION['search_from'];}else{$search_from = '';};
    if(isset($_SESSION['search_to'])){$search_to = $_SESSION['search_to'];}else{$search_to = '';};
    if(isset($_SESSION['page'])){$page = $_SESSION['page'];}else{$page = '';};
    if(isset($_SESSION['remember_state'])){$remember_state = $_SESSION['remember_state'];}else{$remember_state = 'false';};
    if(isset($_SESSION['warehouse_id'])){$warehouse_id = $_SESSION['warehouse_id'];};
    if(isset($_SESSION['cash_ledger_id'])){$cash_ledger_id = $_SESSION['cash_ledger_id'];};

	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
	$time = date('H-i-sa');
    
    echo '<style type="text/css">
        .scroll-card-body {max-height: 700px;overflow-y: auto;}
        .scroll_search_div {max-height: 300px;overflow-y: auto;}
        .amt-td {text-align:right;}
        .action-td {text-align:center;}
    </style>
    <div class="container-fluid">
        <div class="card shadow md-4">
            <div class="card-header py-3">
                <div class="float-left">
                    <h4 class="m-0 font-weight-bold text-primary">
                        Stock Requisition List
                    </h4>';
                    
                        if (
                            $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                            $_SESSION['user_type'] == 'Super_User' OR 
                            ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Time_Sheet'] == 'Yes')) 
                        {
                            echo '<a href="#" id="new_stock_requisition_icon">New Stock Requisition Voucher</a>
                            - | - 
                            <a href="#" id="auto_stock_requisition_icon">Auto New Stock Requisition Voucher</a>';
                        }
                
                echo '</div>
                <div class="float-right">
                    <form class="form-inline mr-auto w-100 navbar-search">';
                        
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
                        
                        echo '<div class="input-group">
                            <label>Name</label>
                            <input type="text" class="form-control border-0 small" name="stock_requisition_search" id="stock_requisition_search">
                        </div>
                        <div class="input-group">
                            <label>From</label>';
                            
                                if($remember_state == true)
                                {
                        
                                    echo '<input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_requisition_search_from" id="stock_requisition_search_from" value="'.$search_from.'">';
                            
                                }
                                else
                                {
                            
                                    echo '<input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_requisition_search_from" id="stock_requisition_search_from">';
                            
                                };
                            
                        echo '</div>
                        <div class="input-group">
                            <label>To</label>';
                                
                                    if($remember_state == true)
                                    {
                                        echo '<input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_requisition_search_to" id="stock_requisition_search_to" value="'.$search_to.'">';
                                    }
                                    else
                                    {
                                        echo '<input type="date" class="form-control border-0 small" aria-label="Search" aria-describedby="basic-addon2" name="stock_requisition_search_to" id="stock_requisition_search_to">';
                                    };
                            
                        echo '</div>
                        <div class="input-group">
                            <div class="form-check">';
                                
                                    if($remember_state == true)
                                    {
                                
                                        echo '<input class="form-check-input" type="checkbox" value="" id="remember_state" checked>';
                                
                                    }
                                    else
                                    {
                                
                                        echo '<input class="form-check-input" type="checkbox" value="" id="remember_state">';
                                
                                    };
                                
                            echo '</div>
                        </div>
                        <div class="input-group">
                        <a href="#" data-toggle="" id="new_stock_requisition_icon"><i class="fas fa-plus-square"></i></a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">';
                
                    //if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
                    //{
                        $query = "SELECT * FROM stock_requisition WHERE 
                        company_id = '".$_SESSION['company_id']."' OR company_id_to = '".$_SESSION['company_id']."' ORDER BY date ASC";
                    /*}
                    else
                    {
                        $query = "SELECT * FROM stock_requisition WHERE branch_id = '$user_branch_id' ORDER BY date ASC";
                    };*/
                    $query_run = mysqli_query($con, $query);

                echo '<ul class="nav nav-tabs nav-justified">
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
                    <div id="customer_stock_requisition" class="tab-pane fade">
                    </div>
                </div>
            </div>
        </div>
    </div>';
?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_sales_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/sales_order_conversion_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_requisition_auto_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_requisition_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_transfer_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>