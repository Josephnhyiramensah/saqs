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
    if(isset($_SESSION['dispensed_report_item_end_date']))
    {
        $item_id = $_SESSION['dispensed_report_item_item_id'];
        $category_id = $_SESSION['dispensed_report_item_category_id'];
        $warehouse = $_SESSION['dispensed_report_item_warehouse_id'];
        $start_date = $_SESSION['dispensed_report_item_start_date'];
        $end_date = $_SESSION['dispensed_report_item_end_date'];
        $company_id = $_SESSION['company_id'];

        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);

        $sql_warehouse = "SELECT * FROM warehouse WHERE warehouse_id = '$warehouse'";
        $result_warehouse = mysqli_query($con,$sql_warehouse);
        $row_warehouse = mysqli_fetch_array($result_warehouse);

        $query_item = "SELECT * FROM drugs WHERE drug_id ='$item_id'";
        $query_run_item = mysqli_query($con, $query_item);
        $row_item = mysqli_fetch_assoc($query_run_item);
        $item_desc = $row_item['brand_name'];
            
?>
                <table class="table table-hover table-bordered table-sm" id="stock_report_list_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class = "action-td" colspan="6"><H3><?php echo $row_company['trading_name'];?></H3></th>
                            </tr>
                            <tr>
                                <th class = "action-td" colspan="6"><H6><?php echo $item_desc;?> TALLY CARD FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                            </tr>
                            <tr style="background-color:#E4DCCF; color:black">
                                <th class="action-td">S/NO</th>
                                <th class="action-td">DATE</th>
                                <th class="action-td">PATIENT</th>
                                <th class="action-td">QUANTITY</th>
                                <th class="action-td">PRICE</th>
                                <th class="action-td">AMOUNT</th>
                                <th class="action-td">DISPENSED BY</th>
                            </tr>
                        </thead>
                            <tbody class="pv-table-body" id="stock_report_list_table_body">
                                 
<?php 

if ($warehouse == 'all') 
{
    $query="SELECT * FROM drug_dispense_list WHERE drug_id = '$item_id' AND date BETWEEN '$start_date' AND '$end_date'";
}
else
{
    $query="SELECT * FROM drug_dispense_list WHERE drug_id = '$item_id' AND  warehouse_id = '$warehouse' AND date BETWEEN '$start_date' AND '$end_date'";
};
        $query_run = mysqli_query($con, $query);
        $i = 0;
        $total_qty = 0;
        $total_amount = 0;
        if (mysqli_num_rows($query_run) > 0)
        {
            while($row = mysqli_fetch_assoc($query_run))
            {
                $patient_id = $row['patient_id'];
                $query_voucher_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
                $result_voucher_patient = mysqli_query($con,$query_voucher_patient);
                $row_voucher_patient = mysqli_fetch_assoc($result_voucher_patient);
                $narration = $row_voucher_patient['full_name'].': '.$row_voucher_patient['folderNo'];

                $user_id = $row['created_by'];
                $query_created = "SELECT * FROM users WHERE id = '$user_id'";
                $result_created = mysqli_query($con,$query_created);
                $row_created = mysqli_fetch_assoc($result_created);
                $created_by = $row_created['first_name'].': '.$row['created_timestamp'];
                        
                ++$i;
?>
                    <tr>
                        <td class="action-td"><?php echo $i;?></td>
                        <td><?php echo $row['date'];?></td>
                        <td><?php echo $row_voucher_patient['full_name'].': '.$row_voucher_patient['folderNo'];?>
                        <td class="amt-td"><?php echo $row['qty'];?></td>
                        <td class="amt-td"><?php echo $row['price_cash'];?></td>
                        <td class="amt-td"><?php echo $row['amt_cash'];?></td>
                        <td><?php echo $created_by;?></td>
                    </tr>
<?php 
                $total_qty = $total_qty + $row['qty'];
                $total_amount = $total_amount + $row['amt_cash'];
            };
        };

?>
        <tr>
            <td class="action-td" colspan = "3">TOTAL</td>
            <td class="amt-td"><?php echo $total_qty;?></td>
            <td class="amt-td"></td>
            <td class="amt-td"><?php echo $total_amount;?></td>
        </tr>
    </tbody>
</table>
<?php
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>