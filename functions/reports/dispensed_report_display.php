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
        if(isset($_SESSION['dispensed_report_start_date']))
        {           
            $company_id = $_SESSION['company_id'];
            $warehouse = $_SESSION['dispensed_report_warehouse'];
            $start_date = $_SESSION['dispensed_report_start_date'];
            $end_date = $_SESSION['dispensed_report_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);

            $sql_warehouse = "SELECT * FROM warehouse WHERE warehouse_id = '$warehouse'";
            $result_warehouse = mysqli_query($con,$sql_warehouse);
            $row_warehouse = mysqli_fetch_array($result_warehouse);
    ?>
                    <table class="table table-hover table-bordered table-sm" id="stock_report_list_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class = "action-td" colspan="4"><H3><?php echo $row_company['trading_name'];?></H3></th>
                                </tr>
                                <tr>
                                    <th class = "action-td" colspan="4"><H6><?php if ($warehouse !== 'all'){echo $row_warehouse['warehouse_desc'].' ';}else{echo 'ALL WAREHOUSES ';};?> STOCK DISPENSED FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                                </tr>
                                <tr style="background-color:#E4DCCF; color:black">
                                    <th class="action-td">S/NO</th>
                                    <th class="action-td">ITEM</th>
                                    <th class="action-td">QUANTITY</th>
                                    <th class="action-td">AMOUNT</th>
                                </tr>
                            </thead>
                                <tbody class="pv-table-body" id="stock_report_list_table_body">
                                 
<?php 
    if ($warehouse == 'all') 
    {
        $query="SELECT drug_id, SUM(qty) AS qty, SUM(amt_cash) AS amount FROM drug_dispense_list 
        WHERE date BETWEEN '$start_date' AND '$end_date' GROUP BY drug_id";
    }
    else
    {
        $query="SELECT drug_id, SUM(qty) AS qty, SUM(amt_cash) AS amount FROM drug_dispense_list 
        WHERE warehouse_id = '$warehouse' AND date BETWEEN '$start_date' AND '$end_date' GROUP BY drug_id";
    };

        
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $i=0;
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                            ++$i;
                            $drug_id = $row['drug_id'];
                            $query_item = "SELECT * FROM drugs WHERE drug_id ='$drug_id'";
                            $query_run_item = mysqli_query($con, $query_item);
                            $row_item = mysqli_fetch_assoc($query_run_item);
                            $item_desc = $row_item['brand_name'];
?>
                                <tr>
                                    <td class="action-td"><?php echo $i;?></td>
                                    <td><a id="dispensed_report_item" 
                                        href="#"
                                        data-id="<?php echo $row['drug_id'];?>"
                                        data-id2="<?php echo $warehouse;?>"
                                        data-id3="<?php echo $start_date;?>"
                                        data-id4="<?php echo $end_date;?>">
                                        <?php echo $item_desc;?>
                                        </a>
                                    </td>
                                    <td class="action-td"><?php echo $row['qty'];?></td>
                                    <td class="amt-td"><?php echo $row['amount'];?></td>
                                </tr>
<?php 
                        };
                };
?>
                                </tbody>
                    </table>
<?php
        };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>