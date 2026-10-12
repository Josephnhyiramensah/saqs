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
        if(isset($_SESSION['purch_report_start_date']))
        {           
            $company_id = $_SESSION['purch_report_company_id'];
            $user_id = $_SESSION['purch_report_user_id'];
            $user_super_id = $_SESSION['purch_report_user_super_id'];
            $start_date = $_SESSION['purch_report_start_date'];
            $end_date = $_SESSION['purch_report_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
                    <table class="table table-hover table-bordered table-sm" id="purchase_report_list_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class = "action-td" colspan="10"><H3><?php echo $row_company['trading_name'];?></H3></th>
                                </tr>
                                <tr>
                                    <th class = "action-td" colspan="10"><H6>PURCHASE REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
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
                                    <tr>
                                        <th colspan="10"><H6><strong>PENDING</strong></H6></th>
                                    </tr>
            <?php 
                $query = "SELECT * FROM purchases WHERE company_id = '$company_id' AND date BETWEEN '$start_date' AND '$end_date' ORDER BY date ASC";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                        $i=0;
                        $total_amount_pending = 0;
                        $total_weight_pending = 0;
                        $total_price_pending = 0;
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $purchase_id = $row['purchase_id'];
                            $query_pending = "SELECT * FROM sold_items WHERE purchase_id = '$purchase_id'";
                            $query_run_pending = mysqli_query($con, $query_pending);
                            if (mysqli_num_rows($query_run_pending) <= 0)
                            {
                                $i = ++$i;
                                $total_amount_pending = $total_amount_pending + $row['amount'];
                                $total_weight_pending = $total_weight_pending + $row['weight'];
                                $total_price_pending = $total_price_pending + $row['price'];
            ?>
                                    <tr>
                                        <td class="action-td"><?php echo $i;?></td>
                                        <td class="action-td"><?php echo $row['date'];?></td>
                                        <td><?php echo $row['supplier'];?></td>
                                        <td class="amt-td"><?php echo $row['weight'];?></td>
                                        <td class="amt-td"><?php echo $row['water'];?></td>
                                        <td class="amt-td"><?php echo $row['density'];?></td>
                                        <?php
                                            $price_pending = $row['price'];
                                            $price_pending = number_format($price_pending, 2, '.', ',');
                                        ?>
                                        <td class="amt-td"><?php echo $price_pending;?></td>
                                        <td class="amt-td"><?php echo $row['pounds'];?></td>
                                        <td class="amt-td"><?php echo $row['karat'];?></td>
                                        <?php
                                            $amount_pending = $row['amount'];
                                            $amount_pending = number_format($amount_pending, 2, '.', ',');
                                        ?>
                                        <td class="amt-td"><?php echo $amount_pending; ?></td>
                                    </tr>
            <?php 
                            }
                        }
                };
            ?>
                                    <tr>
                                        <td class="action-td" colspan="3"><strong>TOTAL</strong></td>
                                        <td class="amt-td"><strong><?php echo $total_weight_pending;?></strong></td>
                                        <td class="amt-td" colspan="5"><strong></strong></td>
                                        <?php
                                            $total_amount_pending_f = number_format($total_amount_pending, 2, '.', ',');
                                        ?>
                                        <td class="amt-td"><strong><?php echo $total_amount_pending_f;?></strong></td>
                                    </tr>
                                    <tr>
                                        <th colspan="10"><H6><strong>SOLD</strong></H6></th>
                                    </tr>
        <?php 
                $query = "SELECT * FROM purchases WHERE company_id = '$company_id' AND date BETWEEN '$start_date' AND '$end_date' ORDER BY date ASC";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                        $total_amount_sold = 0;
                        $total_weight_sold = 0;
                        $total_price_sold = 0;
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $purchase_id = $row['purchase_id'];
                            $query_sold = "SELECT * FROM sold_items WHERE purchase_id = '$purchase_id'";
                            $query_run_sold = mysqli_query($con, $query_sold);
                            if (mysqli_num_rows($query_run_sold) > 0)
                            {
                                $i = ++$i;
                                $total_amount_sold = $total_amount_sold + $row['amount'];
                                $total_weight_sold = $total_weight_sold + $row['weight'];
                                $total_price_sold = $total_price_sold + $row['price'];
            ?>
                                    <tr>
                                        <td class="action-td"><?php echo $i;?></td>
                                        <td class="action-td"><?php echo $row['date'];?></td>
                                        <td><?php echo $row['supplier'];?></td>
                                        <td class="amt-td"><?php echo $row['weight'];?></td>
                                        <td class="amt-td"><?php echo $row['water'];?></td>
                                        <td class="amt-td"><?php echo $row['density'];?></td>
                                        <?php
                                            $price_sold = $row['price'];
                                            $price_sold = number_format($price_sold, 2, '.', ',');
                                        ?>
                                        <td class="amt-td"><?php echo $price_sold;?></td>
                                        <td class="amt-td"><?php echo $row['pounds'];?></td>
                                        <td class="amt-td"><?php echo $row['karat'];?></td>
                                        <?php
                                            $amount_sold = $row['amount'];
                                            $amount_sold = number_format($amount_sold, 2, '.', ',');
                                        ?>
                                        <td class="amt-td"><?php echo $amount_sold; ?></td>
                                    </tr>
            <?php 
                            }
                        }
                };
            ?>
                                    <tr>
                                        <td class="action-td" colspan="3"><strong>TOTAL</strong></td>
                                        <td class="amt-td"><strong><?php echo $total_weight_sold;?></strong></td>
                                        <td class="amt-td" colspan="5"><strong></strong></td>
                                        <?php
                                            $total_amount_sold_f = number_format($total_amount_sold, 2, '.', ',');
                                        ?>
                                        <td class="amt-td"><strong><?php echo $total_amount_sold_f;?></strong></td>
                                    </tr>
                                    <?php 
                                        $total_weight = $total_weight_pending + $total_weight_sold;
                                        $total_price = $total_price_pending + $total_price_sold;
                                        $average_price = $total_price / $i;
                                        $average_price = number_format($average_price, 2, '.', ',');
                                        $total_amount = $total_amount_pending + $total_amount_sold;
                                        $total_amount = number_format($total_amount, 2, '.', ',');
                                    ?>
                                    <tr>
                                        <td class="action-td" colspan="3"><strong>GRAND TOTAL</strong></td>
                                        <td class="amt-td"><strong><?php echo $total_weight;?></strong></td>
                                        <td class="amt-td" colspan="2"><strong>AVERAGE PRICE</strong></td>
                                        <td class="amt-td"><strong><?php echo $average_price;?></strong></td>
                                        <td class="amt-td" colspan="2"><strong></strong></td>
                                        <td class="amt-td"><strong><?php echo $total_amount;?></strong></td>
                                    </tr>
                                </tbody>
                    </table>
        <?php
        };
        ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/goldchest/includes/scripts_main.php');?>