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
        if(isset($_SESSION['purch_display_purchase_id']))
        {
            $company_id = $_SESSION['purch_display_company_id'];
            $user_id = $_SESSION['purch_display_user_id'];
            $user_super_id = $_SESSION['purch_display_user_super_id'];
            $purchase_id = $_SESSION['purch_display_purchase_id'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
                    <table class="table table-hover table-bordered table-sm" id="sales_report_list_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class = "action-td" colspan="2"><H3><?php echo $row_company['trading_name'];?></H3></th>
                            </tr>
                            <tr>
                                <td class = "action-td" colspan="2"><p>Loc:<?php echo $row_company['location'];?></p></td>
                            </tr>
                            <tr>
                                <td class = "action-td" colspan="2"><p>Tel:<?php echo $row_company['telephone'];?></p></td>
                            </tr>
                            <tr>
                                <th class = "action-td" colspan="2"><H6>PURCHASE INVOICE</H6></th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body" id="purchase_report_list_table_body">
                                
                                 
            <?php 
                $query = "SELECT * FROM purchases WHERE purchase_id = '$purchase_id'";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $row = mysqli_fetch_assoc($query_run);
    ?>                      <tr>
                                <td class="action-td">No:<?php echo $row['purchase_id'];?></td>
                                <td class="action-td">Date:<?php echo $row['date'];?></td>
                            </tr>
                            <tr>
                                <td colspan="2">Supplier:<?php echo $row['supplier'];?></td>
                            </tr>
                            <tr>
                                <td colspan="2">Telephone:<?php echo $row['phone'];?></td>
                            </tr>
                            <tr>
                                <td colspan="2">Location:<?php echo $row['location'];?></td>
                            </tr>
                            <tr>
                                <td>Grams:</td>
                                <td class="action-td"><?php echo $row['weight'];?></td></tr>
                            <tr>
                                <td>Water:</td>
                                <td class="action-td"><?php echo $row['water'];?></td>
                            </tr>
                            <tr>
                                <td>Pounds:<?php echo $row['pounds'];?></td>
                                <td>Karat:<?php echo $row['karat'];?></td>
                            </tr>
                            <tr>
                                <td>Density:<?php echo $row['density'];?></td>
                                <td>Purity:<?php echo $row['purity'];?></td>
                            </tr>
                            <tr>
                                <?php
                                    $price_purchase = $row['price'];
                                    $price_purchase = number_format($price_purchase, 2, '.', ',');
                                ?>
                                <td colspan="2">Price:<?php echo $row_company['currency'].''.$price_purchase;?></td>
                            </tr>
                            <tr>
                                <?php
                                    $ppp_purchase = $row['price_per_pound'];
                                    $ppp_purchase = number_format($ppp_purchase, 2, '.', ',');
                                ?>
                                <td colspan="2">Price Per Pound:<?php echo $row_company['currency'].''.$ppp_purchase;?></td>
                            </tr>
                            <tr>
                                <td colspan="2">Pieces:<?php echo $row['pieces'];?></td>
                            </tr>
                            <tr>
                                <?php
                                    $amount_purchase = $row['amount'];
                                    $amount_purchase = number_format($amount_purchase, 2, '.', ',');
                                ?>
                                <td class="amt-td" colspan="2"><h1><?php echo $row_company['currency'].''.$amount_purchase;?></h1></td>
                            </tr>
            <?php 
                };
            ?>
                        </tbody>
                    </table>
        <?php
        };
        ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>