<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/goldchest/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/goldchest/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/goldchest/includes/header_main.php');
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
        if(isset($_SESSION['sales_report_start_date']))
        {           
            $company_id = $_SESSION['sales_report_company_id'];
            $user_id = $_SESSION['sales_report_user_id'];
            $user_super_id = $_SESSION['sales_report_user_super_id'];
            $start_date = $_SESSION['sales_report_start_date'];
            $end_date = $_SESSION['sales_report_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
                    <table class="table table-hover table-bordered table-sm" id="sales_report_list_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class = "action-td" colspan="10"><H3><?php echo $row_company['trading_name'];?></H3></th>
                                </tr>
                                <tr>
                                    <th class = "action-td" colspan="10"><H6>SALES REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                                </tr>
                                <tr>
                                    <th class="action-td">S/NO</th>
                                    <th class="action-td">DATE</th>
                                    <th class="action-td">PARTICULARS</th>
                                    <th class="action-td">WEIGHT</th>
                                    <th class="action-td">WATER</th>
                                    <th class="action-td">DENSITY</th>
                                    <th class="action-td">PRICE</th>
                                    <th class="action-td">POUND</th>
                                    <th class="action-td">KARAT</th>
                                    <th class="action-td">AMOUNT</th>
                                </tr>
                            </thead>
                                <tbody class="pv-table-body" id="purchase_report_list_table_body">
                                 
            <?php 
                $query = "SELECT * FROM sales WHERE company_id = '$company_id' AND date BETWEEN '$start_date' AND '$end_date' ORDER BY date ASC";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                        $i = 0;
                        $total_amount_sales = 0;
                        $total_weight_sales = 0;
                        $total_price_sales = 0;
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                            $i = ++$i;
                            $total_amount_sales = $total_amount_sales + $row['amount'];
                            $total_weight_sales = $total_weight_sales + $row['weight'];
                            $total_price_sales = $total_price_sales + $row['price'];
        ?>
                                <tr>
                                    <td class="action-td"><?php echo $i;?></td>
                                    <td class="action-td"><?php echo $row['date'];?></td>
                                    <td><?php echo $row['supplier'];?></td>
                                    <td class="amt-td"><?php echo $row['weight'];?></td>
                                    <td class="amt-td"><?php echo $row['water'];?></td>
                                    <td class="amt-td"><?php echo $row['density'];?></td>
                                    <?php
                                        $price_sales = $row['price'];
                                        $price_sales = number_format($price_sales, 2, '.', ',');
                                    ?>
                                    <td class="amt-td"><?php echo $price_sales;?></td>
                                    <td class="amt-td"><?php echo $row['pounds'];?></td>
                                    <td class="amt-td"><?php echo $row['karat'];?></td>
                                    <?php
                                        $amount_sales = $row['amount'];
                                        $amount_sales = number_format($amount_sales, 2, '.', ',');
                                    ?>
                                    <td class="amt-td"><?php echo $amount_sales; ?></td>
                                </tr>
            <?php 
                        }
                };
            ?>
                                    <tr>
                                        <td class="action-td" colspan="3"><strong>TOTAL</strong></td>
                                        <td class="amt-td"><strong><?php echo $total_weight_sales;?></strong></td>
                                        <td class="amt-td" colspan="5"><strong></strong></td>
                                        <?php
                                            $total_amount_sales = number_format($total_amount_sales, 2, '.', ',');
                                        ?>
                                        <td class="amt-td"><strong><?php echo $total_amount_sales;?></strong></td>
                                    </tr>
                                </tbody>
                    </table>
        <?php
        };
        ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/goldchest/includes/scripts_main.php');?>