<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
?>
<input type='hidden' id='session_company_id' value="<?php echo $_SESSION['company_id'];?>">
<input type='hidden' id='session_user_super_id' value="<?php echo $_SESSION['user_super_id'];?>">
<input type='hidden' id='session_user_id' value="<?php echo $_SESSION['user_id'];?>">
  <style type="text/css">
    .scroll-card-body {max-height: 700px;overflow-y: auto;}
    .amt-td {text-align:right;}
    .action-td {text-align:center;}
</style>
<div class="container-fluid">
    <?php 
        if(isset($_SESSION['mini_stock_report_start_date']))
        {           
            $company_id = $_SESSION['company_id'];
            $warehouse = $_SESSION['mini_stock_report_warehouse'];
            $start_date = $_SESSION['mini_stock_report_start_date'];
            $end_date = $_SESSION['mini_stock_report_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            if(!empty($result_company) && mysqli_num_rows($result_company) > 0)
            {
                $row_company = mysqli_fetch_array($result_company);
                $company_name = $row_company['trading_name'];
            }
            else
            {
                $company_name = 'Not Specified';
            };

            $sql_warehouse = "SELECT * FROM warehouse WHERE warehouse_id = '$warehouse'";
            $result_warehouse = mysqli_query($con,$sql_warehouse);
            if(!empty($result_warehouse) && mysqli_num_rows($result_warehouse) > 0)
            {
                $row_warehouse = mysqli_fetch_array($result_warehouse);
                $warehouse_desc = $row_warehouse['warehouse_desc'];
            }
            else
            {
                $warehouse_desc = 'Not Specified';
            };

            echo '<table class="table table-hover table-bordered table-sm" id="stock_report_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="11"><H3>'.$company_name.'</H3></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="11"><H6>'.$warehouse_desc.' STOCK REPORT FROM '.$start_date.' TO '.$end_date.'</H6></th>
                    </tr>
                    <tr style="background-color:#E4DCCF; color:black">
                        <th class="action-td">S/NO</th>
                        <th class="action-td">DATE</th>
                        <th class="action-td">VOUCHER NO</th>
                        <th class="action-td">ITEM NUMBER</th>
                        <th class="action-td">BARCODE</th>
                        <th class="action-td">DESCRIPTION</th>
                        <th class="action-td">QTY RECEIVED</th>
                        <th class="action-td">PC QTY</th>
                        <th class="action-td">PHYSICAL</th>
                        <th class="action-td">DIFFERENCE</th>
                        <th class="action-td">REMARKS</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body" id="stock_report_list_table_body">';

            $sql_transfer = "SELECT sti.qty_received AS qty, sti.date_trans, sti.stock_trans_id, sti.stock_item_id, 
            si.stock_item FROM stock_transfer_items sti JOIN stock_items si ON sti.stock_item_id=si.stock_item_id 
            WHERE sti.warehouse_id = '$warehouse' AND sti.qty_received > 0 AND sti.date_trans BETWEEN 
            '$start_date' AND '$end_date' ORDER BY sti.stock_trans_id ASC";
            $i=0;
            $result_transfer = mysqli_query($con, $sql_transfer);
            if(!empty($result_transfer) && mysqli_num_rows($result_transfer) > 0)
            {
                while($row_transfer = mysqli_fetch_array($result_transfer))
                {
                    $i++;
                    $qty_received = $row_transfer['qty'];
                    $stock_item_id = $row_transfer['stock_item_id'];
                    $voucher_id = $row_transfer['stock_trans_id'];
                    $date = $row_transfer['date_trans'];
                    //PC QTY
                        $query="SELECT item_id, SUM(ob) AS ob, SUM(qty_in) AS qty_in, SUM(qty_out) AS qty_out FROM
                        (SELECT stock_item_id  AS item_id, warehouse_id, qty - 0 AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_purchase_items 
                        WHERE date < '$start_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_item_id = '$stock_item_id'
                        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 - qty AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_sales_items 
                        WHERE date < '$start_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_item_id = '$stock_item_id'
                        UNION ALL SELECT stock_id AS item_id, warehouse_id, 0 - qty AS ob, 0 AS qty_out, 0 AS qty_in FROM mtce_stock_list 
                        WHERE date < '$start_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_id = '$stock_item_id'
                        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 - qty_out AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
                        WHERE date < '$start_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_item_id = '$stock_item_id'
                        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 - qty_transferred AS ob, 0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
                        WHERE date_trans < '$start_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_item_id = '$stock_item_id'
                        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, qty_in - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
                        WHERE date < '$start_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_item_id = '$stock_item_id'
                        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, qty_received - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_transfer_items 
                        WHERE date_trans < '$start_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_item_id = '$stock_item_id'
                        UNION ALL SELECT item_id AS item_id, warehouse_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM purchase_items 
                        WHERE date < '$start_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND item_id = '$stock_item_id'
                        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, qty - 0 AS ob,  0 AS qty_out, 0 AS qty_in FROM stock_sales_return_items 
                        WHERE date < '$start_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_item_id = '$stock_item_id'
                        UNION ALL SELECT item_id AS item_id, warehouse_id, 0 - qty AS ob,  0 AS qty_out, 0 AS qty_in FROM purchase_return_items 
                        WHERE date < '$start_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND item_id = '$stock_item_id'

                        UNION ALL SELECT stock_item_id  AS item_id, warehouse_id, 0 AS ob, 0 AS qty_out, qty AS qty_in FROM stock_purchase_items 
                        WHERE date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_item_id = '$stock_item_id'
                        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM stock_sales_items 
                        WHERE date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_item_id = '$stock_item_id'
                        UNION ALL SELECT stock_id AS item_id, warehouse_id, 0 AS ob,  qty AS qty_out, 0 AS qty_in FROM mtce_stock_list 
                        WHERE date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_id = '$stock_item_id'
                        UNION ALL SELECT stock_item_id AS item_id,warehouse_id, 0 AS ob,  qty_out AS qty_out, 0 AS qty_in FROM stock_adjustment_items 
                        WHERE date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_item_id = '$stock_item_id'
                        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  qty_transferred AS qty_out, 0 AS qty_in FROM stock_transfer_items 
                        WHERE date_trans BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_item_id = '$stock_item_id'
                        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty_in AS qty_in FROM stock_adjustment_items 
                        WHERE date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_item_id = '$stock_item_id'
                        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty_received AS qty_in FROM stock_transfer_items 
                        WHERE date_trans BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_item_id = '$stock_item_id'
                        UNION ALL SELECT item_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM purchase_items 
                        WHERE date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND item_id = '$stock_item_id'
                        UNION ALL SELECT stock_item_id AS item_id, warehouse_id, 0 AS ob,  0 AS qty_out, qty AS qty_in FROM stock_sales_return_items 
                        WHERE date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND stock_item_id = '$stock_item_id'
                        UNION ALL SELECT item_id AS item_id, warehouse_id, 0 AS ob,  qty AS qty_out, 0AS qty_in FROM purchase_return_items 
                        WHERE date BETWEEN '$start_date' AND '$end_date' AND warehouse_id ='$warehouse' AND company_id = '$company_id' AND item_id = '$stock_item_id') AS c GROUP BY item_id";
                        
                        $query_run = mysqli_query($con, $query);
                        if (mysqli_num_rows($query_run) > 0)
                        {
                            $row = mysqli_fetch_assoc($query_run);
                            $cls_bal = $row['ob'] + $row['qty_in'] - $row['qty_out'];
                        }
                        else
                        {
                            $cls_bal = 0;
                        };

                    //ITEM DETAILS
                        $sql_stock_item = "SELECT * FROM stock_items WHERE stock_item_id = '$stock_item_id'";
                        $result_stock_item = mysqli_query($con,$sql_stock_item);
                        if(!empty($result_stock_item) && mysqli_num_rows($result_stock_item) > 0)
                        {
                            $row_stock_item = mysqli_fetch_array($result_stock_item);
                            $item_description = $row_stock_item['stock_item'];
                            $item_number = $row_stock_item['code'];
                            $barcode = $row_stock_item['barcode'];
                        }
                        else
                        {
                            $item_description = 'Not Specified';
                            $item_number = 'Not Specified';
                            $barcode = 'Not Specified';
                        };
                    
                    echo '<tr>
                        <td class="action-td">'.$i.'</td>
                        <td class="action-td">'.$date.'</td>
                        <td class="action-td">'.$voucher_id.'</td>
                        <td class="action-td">'.$item_number.'</td>
                        <td class="action-td">'.$barcode.'</td>
                        <td>'.$item_description.'</td>
                        <td class="action-td">'.$qty_received.'</td>
                        <td class="action-td">'.$cls_bal.'</td>
                        <td class="action-td"></td>
                        <td class="action-td"></td>
                        <td class="action-td"></td>
                    </tr>';
                };
            }
            else
            {
                echo '<tr>
                    <td colspan = "9" class="action-td">No Items Received</td>
                </tr>';
            };
                
                    echo '<tr>
                        <td colspan = "3" class="action-td"><strong>STAKE TAKE BY:</strong></td>
                        <td colspan = "3" class="action-td"><strong>VERIFIED BY:</strong></td>
                        <td colspan = "3" class="action-td"><strong>APPROVED BY:</strong></td>
                    </tr>
                    <tr>
                        <td colspan = "3" class="action-td">.</td>
                        <td colspan = "3" class="action-td">.</td>
                        <td colspan = "3" class="action-td">.</td>
                    </tr>
                </tbody>
            </table>';
        };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>