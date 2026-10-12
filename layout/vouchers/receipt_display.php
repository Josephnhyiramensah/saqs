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
        if(isset($_SESSION['receipt_display_receipt_id']))
        {
            $company_id = $_SESSION['receipt_display_company_id'];
            $receipt_id = $_SESSION['receipt_display_receipt_id'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
                    <table class="table table-hover table-bordered table-sm" id="receipt_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class = "action-td" colspan="3"><H3><?php echo $row_company['trading_name'];?></H3></th>
                            </tr>
                            <tr>
                                <td class = "action-td" colspan="3"><p>Loc:<?php echo $row_company['location'];?></p></td>
                            </tr>
                            <tr>
                                <td class = "action-td" colspan="3"><p>Tel:<?php echo $row_company['telephone'];?></p></td>
                            </tr>
                            <tr>
                                <th class = "action-td" colspan="3"><H6>OFFICIAL RECEIPT</H6></th>
                            </tr>
                        </thead>
                        <tbody class="pv-table-body" id="receipt_table_body">
                                
                                 
            <?php 
                $query = "SELECT * FROM receipt WHERE receipt_id = '$receipt_id'";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $row = mysqli_fetch_assoc($query_run);
                    $vn = $row['sno'];
                    $receipt_no = str_pad($vn,7,"0",STR_PAD_LEFT);
            ?>

                    <tr>
                        <td class="action-td">No:<?php echo $receipt_no;?></td>
                        <td class="action-td"></td>
                        <td class="action-td">Date:<?php echo $row['date'];?></td>
                    </tr>
                    <tr>
                        <td colspan="3">Received From:<?php echo $row['received_from'];?></td>
                    </tr>
                    <tr>
                        <td colspan="3">Narration:<?php echo $row['narration'];?></td>
                    </tr>
                    <tr>
                        <td colspan="3">Location:<?php echo $row['reference_no'];?></td>
                    </tr>
                    
                    <tr>
                        <?php
                            $amount_receipt = $row['amount'];
                            $amount_receipt = number_format($amount_receipt, 2, '.', ',');
                        ?>
                        <td class="amt-td" colspan="3"><h1><?php echo $row_company['currency'].''.$amount_receipt;?></h1></td>
                    </tr>
                    <tr>
                        <td colspan="3">Amount-in-words:</td>
                    </tr>
                    <tr>
                        <td class="action-td">CREDIT LEDGER</td>
                        <td class="action-td">AMOUNT</td>
                        <td class="action-td">NARRATION</td>
                    </tr>
            <?php 
                    $query_receipt_item = "SELECT * FROM transactions WHERE receipt_id = '$receipt_id' AND amount_debit = ''";
                    $query_run_receipt_item = mysqli_query($con, $query_receipt_item);
                    if (mysqli_num_rows($query_run_receipt_item) > 0)
                    {
                        while ($row_receipt_item = mysqli_fetch_assoc($query_run_receipt_item))
                        {
                            $credit_led_id = $row_receipt_item['ledger_id'];
                            $credit_amount = $row_receipt_item['amount'];
                            $amount_credit = number_format($credit_amount, 2, '.', ',');

                            $query_credit_led = "SELECT * FROM ledgers WHERE ledger_id = '$credit_led_id'";
                            $query_run_credit_led = mysqli_query($con, $query_credit_led);
                            $row_credit_led = mysqli_fetch_assoc($query_run_credit_led);
                ?>
                            <tr>
                                <td><?php echo $row_credit_led['ledger_desc'];?></td>
                                <td class="amt-td"><?php echo $amount_credit;?></td>
                                <td><?php echo $row_receipt_item['narration'];?></td>
                            </tr>
                <?php
                        };
                    };
                };
            ?>
                    <tr>
                        <td class="amt-td" colspan="3"><h1> </h1></td>
                    </tr>
                        </tbody>
                    </table>
        <?php
        };
        ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>