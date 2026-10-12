<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
?>
  <style type="text/css">
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
<?php 
    if(isset($_SESSION['employee_stock_item_employee_id']))
    {
        $employee_id = $_SESSION['employee_stock_item_employee_id'];
        $company_id = $_SESSION['company_id'];

        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        if (mysqli_num_rows($result_company) > 0)
        {
            $row_company = mysqli_fetch_array($result_company);
            $company_name = $row_company['trading_name'];
        }
        else
        {
            $company_name = 'No Company';
        };

        $sql_employee = "SELECT * FROM payroll_employee WHERE employee_id = '$employee_id'";
        $result_employee = mysqli_query($con,$sql_employee);
        if (mysqli_num_rows($result_employee) > 0)
        {
            $row_employee = mysqli_fetch_array($result_employee);
            $employee_name = $row_employee['first_name'].' '.$row_employee['last_name'];
        }
        else
        {
            $employee_name = 'No Employee';
        };

    echo '<table class="table table-hover table-bordered table-sm" id="stock_report_list_table" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class = "action-td" colspan="7"><H3>'.$company_name.'</H3></th>
            </tr>
            <tr>
                <th class = "action-td" colspan="7"><H6>'.strtoupper($employee_name).' ITEM CONSUMPTION REPORT</H6></th>
            </tr>
            <tr style="background-color:#E4DCCF; color:black">
                <th class="action-td">S/NO</th>
                <th class="action-td">DATE</th>
                <th class="action-td">ITEM</th>
                <th class="action-td">QTY</th>
                <th class="action-td">REMARKS</th>
            </tr>
        </thead>
            <tbody class="pv-table-body" id="stock_report_list_table_body">';
                                 
        
        $query = "SELECT i.*, s.stock_item, c.narration, c.requested_by FROM stock_adjustment_items i 
        JOIN stock_items s ON i.stock_item_id=s.stock_item_id JOIN stock_consumption c ON i.stock_consumption_id=c.stock_consumption_id 
        WHERE i.employee_id ='$employee_id' ORDER BY i.date ASC";
        
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            $i=0;
            while($row = mysqli_fetch_assoc($query_run))
            {
                $i++;
                echo '<tr>
                    <td class="action-td">'.$i.'</td>
                    <td>'.$row['date'].'</td>
                    <td>'.$row['stock_item'].'</td>
                    <td class="action-td">'.$row['qty_out'].'</td>
                    <td>Requested By:'.$row['requested_by'].':- '.$row['narration'].'</td>
                </tr>';
            };
        };
    echo '</tbody>
</table>';
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>