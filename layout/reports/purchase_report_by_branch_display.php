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
        
            echo'<table class="table table-hover table-bordered table-sm" id="purchase_report_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="12"><H3>'.$row_company['trading_name'].'</H3></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="12"><H6>PURCHASE REPORT FROM '.$start_date.' TO '.$end_date.'</H6></th>
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
                        <th class="action-td">SOLD TO</th>
                        <th class="action-td">DATE SOLD</th>
                    </tr>
                </thead>
                    <tbody class="pv-table-body" id="purchase_report_list_table_body">
                        <tr style="background-color:black; color:white">
                            <th colspan="12"><H5><strong>PENDING</strong></H5></th>
                        </tr>';
                            //PENDING ITEMS
                            $i=0;
                            $pri=0;
                            $sri=0;
                            $pbi=0;
                            $sbi=0;
                            $pi=0;
                            $si=0;
                            $total_amount_pending = 0;
                            $total_weight_pending = 0;
                            $total_water_pending = 0;
                            $total_price_pending = 0;
                            $total_pounds_pending = 0;

                            if ($_SESSION['user_type_id'] != 3) 
                            {
                                $query_branch = "SELECT * FROM branch WHERE company_id = '$company_id'";
                            }
                            else
                            {
                                $user_branch_id = $_SESSION['branch_id'];
                                $query_branch = "SELECT * FROM branch WHERE company_id = '$company_id'
                                AND branch_id = '$user_branch_id'";
                            };
                            $query_run_branch = mysqli_query($con, $query_branch);
                            if (mysqli_num_rows($query_run_branch) > 0)
                            {
                                while($row_branch = mysqli_fetch_assoc($query_run_branch))
                                {
                                    $branch_id = $row_branch['branch_id'];
                                    $query = "SELECT * FROM purchases WHERE company_id = '$company_id' 
                                    AND branch_id = '$branch_id' AND date BETWEEN '$start_date' AND '$end_date' ORDER BY date ASC";
                                    $query_run = mysqli_query($con, $query);
                                    if (mysqli_num_rows($query_run) > 0)
                                    {
                                        $total_amount_pending_refined = 0;
                                        $total_weight_pending_refined = 0;
                                        $total_water_pending_refined = 0;
                                        $total_price_pending_refined = 0;
                                        $total_pounds_pending_refined = 0;
        
                                        echo'<tr style="background-color:#E4DCCF; color:black">
                                            <th colspan="12"><H6>'.$row_branch['branch_name'].'</strong></H6></th>
                                        </tr>';
                                        while($row = mysqli_fetch_assoc($query_run))
                                        {
                                            $purchase_id = $row['purchase_id'];
                                            $query_pending = "SELECT * FROM sold_items WHERE purchase_id = '$purchase_id'";
                                            $query_run_pending = mysqli_query($con, $query_pending);
                                            if (mysqli_num_rows($query_run_pending) <= 0)
                                            {
                                                $i = ++$i;
                                                $pi = ++$pi;
                                                $pri = ++$pri;
                                                $total_amount_pending = $total_amount_pending + $row['amount'];
                                                $total_weight_pending = $total_weight_pending + $row['weight'];
                                                $total_water_pending = $total_water_pending + $row['water'];
                                                $total_price_pending = $total_price_pending + $row['price'];
                                                $total_pounds_pending = $total_pounds_pending + $row['pounds'];
                                                $total_amount_pending_refined = $total_amount_pending_refined + $row['amount'];
                                                $total_weight_pending_refined = $total_weight_pending_refined + $row['weight'];
                                                $total_water_pending_refined = $total_water_pending_refined + $row['water'];
                                                $total_price_pending_refined = $total_price_pending_refined + $row['price'];
                                                $total_pounds_pending_refined = $total_pounds_pending_refined + $row['pounds'];
                                                
                                                    echo'<tr>
                                                        <td class="action-td">'.$i.'</td>
                                                        <td class="action-td">'.$row['date'].'</td>
                                                        <td>';
                                                            
                                                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Purchases'] == 'Yes')) 
                                                                {
                                                                    echo '<a href="#" id="btn_edit_purchase" data-id="'.$row['purchase_id'].'">'.$row['supplier'].'</a>';
                                                                }
                                                                else
                                                                {
                                                                    echo $row['supplier'];
                                                                };
                                                        
                                                        echo'</td>
                                                        <td class="amt-td">'.$row['weight'].'</td>
                                                        <td class="amt-td">'.$row['water'].'</td>
                                                        <td class="amt-td">'.$row['density'].'</td>';
                                                        
                                                            $price_pending_refined = $row['price'];
                                                            $price_pending_refined = number_format($price_pending_refined, 2, '.', ',');
                                                        
                                                        echo'<td class="amt-td">'.$price_pending_refined.'</td>
                                                        <td class="amt-td">'.$row['pounds'].'</td>
                                                        <td class="amt-td">'.$row['karat'].'</td>';
                                                        
                                                            $amount_pending_refined = $row['amount'];
                                                            $amount_pending_refined = number_format($amount_pending_refined, 2, '.', ',');
                                                    
                                                        echo'<td class="amt-td">'.$amount_pending_refined.'</td>
                                                        <td class="amt-td"></td>
                                                        <td class="amt-td"></td>
                                                    </tr>';
                                                
                                            };
                                        };
                                            if($total_price_pending_refined > 0 && $pri > 0){$average_price_pending_refined = $total_price_pending_refined / $pri;}else{$average_price_pending_refined = 0;};
                                            $average_price_pending_refined = number_format($average_price_pending_refined, 2, '.', ',');
                                            
                                            echo'<tr>
                                                <td class="action-td" colspan="3"><strong>TOTAL</strong></td>
                                                <td class="amt-td"><strong>'.$total_weight_pending_refined.'</strong></td>
                                                <td class="amt-td"><strong>'.$total_water_pending_refined.'</strong></td>
                                                <td class="amt-td"><strong></strong></td>
                                                <td class="amt-td"><strong>'.$average_price_pending_refined.'</strong></td>
                                                <td class="amt-td"><strong>'.$total_pounds_pending_refined.'</strong></td>
                                                <td class="amt-td"><strong></strong></td>';
                                                
                                                    $total_amount_pending_refined_f = number_format($total_amount_pending_refined, 2, '.', ',');
                                            
                                                echo'<td class="amt-td"><strong>'.$total_amount_pending_refined_f.'</strong></td>
                                                <td class="amt-td"><strong></strong></td>
                                                <td class="amt-td"><strong></strong></td>
                                            </tr>';
                                    };
                                };
                                
                                    if($total_price_pending > 0 && $pi > 0){$average_price_pending = $total_price_pending / $pi;}else{$average_price_pending = 0;};
                                    $average_price_pending = number_format($average_price_pending, 2, '.', ',');
                                
                                echo'<tr>
                                    <td class="action-td" colspan="3"><strong>TOTAL</strong></td>
                                    <td class="amt-td"><strong>'.$total_weight_pending.'</strong></td>
                                    <td class="amt-td"><strong>'.$total_water_pending.'</strong></td>
                                    <td class="amt-td"><strong></strong></td>
                                    <td class="amt-td"><strong>'.$average_price_pending.'</strong></td>
                                    <td class="amt-td"><strong>'.$total_pounds_pending.'</strong></td>
                                    <td class="amt-td"><strong></strong></td>';
                                    
                                        $total_amount_pending_f = number_format($total_amount_pending, 2, '.', ',');
                                    
                                    echo'<td class="amt-td"><strong>'.$total_amount_pending_f.'</strong></td>
                                    <td class="amt-td"><strong></strong></td>
                                    <td class="amt-td"><strong></strong></td>
                                </tr>';
                            };
                
                            echo'<tr style="background-color:black; color:white">
                                <th colspan="12"><H5><strong>SOLD</strong></H5></th>
                            </tr>';
                            //SOLD ITEMS
                            
                                $total_amount_sold = 0;
                                $total_weight_sold = 0;
                                $total_water_sold = 0;
                                $total_price_sold = 0;
                                $total_pounds_sold = 0;
                                if ($_SESSION['user_type_id'] != 3) 
                                {
                                    $query_branch = "SELECT * FROM branch WHERE company_id = '$company_id'";
                                }
                                else
                                {
                                    $user_branch_id = $_SESSION['branch_id'];
                                    $query_branch = "SELECT * FROM branch WHERE company_id = '$company_id'
                                    AND branch_id = '$user_branch_id'";
                                };
                                $query_run_branch = mysqli_query($con, $query_branch);
                                if (mysqli_num_rows($query_run_branch) > 0)
                                {
                                    while($row_branch = mysqli_fetch_assoc($query_run_branch))
                                    {
                                        $branch_id = $row_branch['branch_id'];
                                        $query = "SELECT * FROM purchases WHERE company_id = '$company_id' 
                                        AND branch_id = '$branch_id' AND date BETWEEN '$start_date' AND '$end_date' ORDER BY date ASC";
                                        $query_run = mysqli_query($con, $query);
                                        if (mysqli_num_rows($query_run) > 0)
                                        {
                                            $total_amount_sold_refined = 0;
                                            $total_weight_sold_refined = 0;
                                            $total_water_sold_refined = 0;
                                            $total_price_sold_refined = 0;
                                            $total_pounds_sold_refined = 0;
        
                                            echo'
                                            <tr style="background-color:#E4DCCF; color:black">
                                                <th colspan="12"><H6>'.$row_branch['branch_name'].'</strong></H6></th>
                                            </tr>';
                                            while($row = mysqli_fetch_assoc($query_run))
                                            {
                                                $purchase_id = $row['purchase_id'];
                                                $query_sold = "SELECT * FROM sold_items WHERE purchase_id = '$purchase_id'";
                                                $query_run_sold = mysqli_query($con, $query_sold);
                                                if (mysqli_num_rows($query_run_sold) > 0)
                                                {
                                                    $row_sold_items = mysqli_fetch_assoc($query_run_sold);
                                                    $sales_id = $row_sold_items['sales_id'];
                                                    $query_sales = "SELECT * FROM sales WHERE sales_id = '$sales_id'";
                                                    $query_run_sales = mysqli_query($con, $query_sales);
                                                    if (mysqli_num_rows($query_run_sales) > 0)
                                                    {
                                                        $row_sales = mysqli_fetch_assoc($query_run_sales);
                                                        $sales_ledger_dr = $row_sales['ledger_debit'];
                                                        $query_sales_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$sales_ledger_dr'";
                                                        $query_run_sales_ledger = mysqli_query($con, $query_sales_ledger);
                                                        if (mysqli_num_rows($query_run_sales_ledger) > 0)
                                                        {
                                                            $row_customer_ledger = mysqli_fetch_assoc($query_run_sales_ledger);
                                                            $customer_ledger = $row_customer_ledger['ledger_desc'];
                                                        }
                                                        else
                                                        {
                                                            $customer_ledger = 'N/A';
                                                        };
                                                    }
                                                    else
                                                    {
                                                        $customer_ledger = 'N/A';
                                                    };
                                                    $i = ++$i;
                                                    $si = ++$si;
                                                    $sri = ++$sri;
                                                    $total_amount_sold = $total_amount_sold + $row['amount'];
                                                    $total_weight_sold = $total_weight_sold + $row['weight'];
                                                    $total_water_sold = $total_water_sold + $row['water'];
                                                    $total_price_sold = $total_price_sold + $row['price'];
                                                    $total_pounds_sold = $total_pounds_sold + $row['pounds'];
                                                    $total_amount_sold_refined = $total_amount_sold_refined + $row['amount'];
                                                    $total_weight_sold_refined = $total_weight_sold_refined + $row['weight'];
                                                    $total_water_sold_refined = $total_water_sold_refined + $row['water'];
                                                    $total_price_sold_refined = $total_price_sold_refined + $row['price'];
                                                    $total_pounds_sold_refined = $total_pounds_sold_refined + $row['pounds'];
                                                    ?>
                                                        <tr>
                                                            <td class="action-td"><?php echo $i;?></td>
                                                            <td class="action-td"><?php echo $row['date'];?></td>
                                                            <td>
                                                            <?php
                                                                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Purchases'] == 'Yes')) 
                                                                {
                                                                    echo '<a href="#" id="btn_edit_purchase" data-id="'.$row['purchase_id'].'">'.$row['supplier'].'</a>';
                                                                }
                                                                else
                                                                {
                                                                    echo $row['supplier'];
                                                                };
                                                            ?>
                                                            </td>
                                                            <td class="amt-td"><?php echo $row['weight'];?></td>
                                                            <td class="amt-td"><?php echo $row['water'];?></td>
                                                            <td class="amt-td"><?php echo $row['density'];?></td>
                                                            <?php
                                                                $price_sold_refined = $row['price'];
                                                                $price_sold_refined = number_format($price_sold_refined, 2, '.', ',');
                                                            ?>
                                                            <td class="amt-td"><?php echo $price_sold_refined;?></td>
                                                            <td class="amt-td"><?php echo $row['pounds'];?></td>
                                                            <td class="amt-td"><?php echo $row['karat'];?></td>
                                                            <?php
                                                                $amount_sold_refined = $row['amount'];
                                                                $amount_sold_refined = number_format($amount_sold_refined, 2, '.', ',');
                                                            ?>
                                                            <td class="amt-td"><?php echo $amount_sold_refined; ?></td>
                                                            <td>
                                                                <?php
                                                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Sales'] == 'Yes')) 
                                                                    {
                                                                        echo '<a href="#" id="btn_edit_sales" data-id="'.$row_sales['sales_id'].'">'.$customer_ledger.'</a>';
                                                                    }
                                                                    else
                                                                    {
                                                                        echo $customer_ledger;
                                                                    };
                                                                ?>
                                                            </td>
                                                            <td class="action-td"><?php echo $row_sales['date'];?></td>
                                                        </tr>
                                                    <?php 
                                                };
                                            };
                                            if($total_price_sold_refined > 0 && $sri > 0){$average_price_sold_refined = $total_price_sold_refined / $sri;}else{$average_price_sold_refined = 0;};
                                            $average_price_sold_refined = number_format($average_price_sold_refined, 2, '.', ',');
                                            
                                            echo'<tr>
                                                <td class="action-td" colspan="3"><strong>TOTAL</strong></td>
                                                <td class="amt-td"><strong>'.$total_weight_sold_refined.'</strong></td>
                                                <td class="amt-td"><strong>'.$total_water_sold_refined.'</strong></td>
                                                <td class="amt-td"><strong></strong></td>
                                                <td class="amt-td"><strong>'.$average_price_sold_refined.'</strong></td>
                                                <td class="amt-td"><strong>'.$total_pounds_sold_refined.'</strong></td>
                                                <td class="amt-td"><strong></strong></td>';
                                                
                                                    $total_amount_sold_refined_f = number_format($total_amount_sold_refined, 2, '.', ',');
                                                
                                                echo'<td class="amt-td"><strong>'.$total_amount_sold_refined_f.'</strong></td>
                                                <td class="amt-td"><strong></strong></td>
                                                <td class="amt-td"><strong></strong></td>
                                            </tr>';
                                        };
                                    };
                                    
                                    
                                        if($total_price_sold > 0 && $si > 0){$average_price_sold = $total_price_sold / $si;}else{$average_price_sold = 0;};
                                        $average_price_sold = number_format($average_price_sold, 2, '.', ',');
                                    
                                        echo'<tr>
                                            <td class="action-td" colspan="3"><strong>TOTAL</strong></td>
                                            <td class="amt-td"><strong>'.$total_weight_sold.'</strong></td>
                                            <td class="amt-td"><strong>'.$total_water_sold.'</strong></td>
                                            <td class="amt-td"><strong></strong></td>
                                            <td class="amt-td"><strong>'.$average_price_sold.'</strong></td>
                                            <td class="amt-td"><strong>'.$total_pounds_sold.'</strong></td>
                                            <td class="amt-td"><strong></strong></td>';
                                            
                                                $total_amount_sold_f = number_format($total_amount_sold, 2, '.', ',');
                                            
                                            echo'<td class="amt-td"><strong>'.$total_amount_sold_f.'</strong></td>
                                            <td class="amt-td"><strong></strong></td>
                                            <td class="amt-td"><strong></strong></td>
                                        </tr>';
                                };

                            
                                $total_weight = $total_weight_pending + $total_weight_sold;
                                $total_water = $total_water_pending + $total_water_sold;
                                $total_price = $total_price_pending + $total_price_sold;
                                $total_pounds = $total_pounds_pending + $total_pounds_sold;
                                if($total_price > 0 && $i > 0){$average_price = $total_price / $i;}else{$average_price = 0;};
                                //$average_price = $total_price / $i;
                                $average_price = number_format($average_price, 2, '.', ',');
                                $total_amount = $total_amount_pending + $total_amount_sold;
                                $total_amount = number_format($total_amount, 2, '.', ',');
                            
                            echo'<tr>
                                <td class="action-td" colspan="3"><strong>GRAND TOTAL</strong></td>
                                <td class="amt-td"><strong>'.$total_weight.'</strong></td>
                                <td class="amt-td"><strong>'.$total_water.'</strong></td>
                                <td class="amt-td"><strong>AVERAGE PRICE</strong></td>
                                <td class="amt-td"><strong>'.$average_price.'</strong></td>
                                <td class="amt-td"><strong>'.$total_pounds.'</strong></td>
                                <td class="amt-td"><strong></strong></td>
                                <td class="amt-td"><strong>'.$total_amount.'</strong></td>
                                <td class="amt-td"><strong></strong></td>
                                <td class="amt-td"><strong></strong></td>
                            </tr>
                </tbody>
            </table>';
        
        };
    ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/purchases_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/sales_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>