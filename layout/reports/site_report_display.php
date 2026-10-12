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
        if(isset($_SESSION['site_report_start_date']))
        {           
            $company_id = $_SESSION['site_report_company_id'];
            $user_id = $_SESSION['site_report_user_id'];
            $user_super_id = $_SESSION['site_report_user_super_id'];
            $site_id = $_SESSION['site_report_site'];
            $start_date = $_SESSION['site_report_start_date'];
            $end_date = $_SESSION['site_report_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);

            $sql_site = "SELECT * FROM site WHERE site_id = '$site_id' AND company_id = '$company_id'";
            $result_site = mysqli_query($con,$sql_site);
            $row_site = mysqli_fetch_array($result_site);
    ?>
                    <table class="table table-hover table-bordered table-sm" id="site_report_list_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class = "action-td" colspan="6"><H3><?php echo $row_company['trading_name'];?></H3></th>
                                </tr>
                                <tr>
                                    <th class = "action-td" colspan="6"><H6><?php if ($site_id !== 'all'){echo $row_site['site'].' ';}else{echo 'ALL SITE ';};?> SITE REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                                </tr>
                                <tr style="background-color:#E4DCCF; color:black">
                                    <th class="action-td">S/NO</th>
                                    <th class="action-td">PARTICULARS</th>
                                    <th class="action-td">OPENING SURPLUS/(DEFICIT)</th>
                                    <th class="action-td">REVENUE</th>
                                    <th class="action-td">EXPENDITURE</th>
                                    <th class="action-td">CLOSING SURPLUS/(DEFICIT)</th>
                                </tr>
                            </thead>
                                <tbody class="pv-table-body" id="site_report_list_table_body">
                                 
<?php 
    if ($site_id == 'all') 
    {
        $query="
        SELECT site_id, SUM(ob) AS ob, SUM(revenue) AS revenue, SUM(expenditure) AS expenditure FROM
        (SELECT site_id AS site_id, amount - 0 AS ob, 0 AS expenditure, 0 AS revenue FROM purchases 
        WHERE date < '$start_date' AND company_id = '$company_id'

        UNION ALL SELECT site_id AS site_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue FROM mtce_led_list 
        WHERE date < '$start_date' AND company_id = '$company_id'

        UNION ALL SELECT site_id AS site_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue FROM mtce_stock_list 
        WHERE date < '$start_date' AND company_id = '$company_id'

        UNION ALL SELECT site_id AS site_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue FROM hiring_list 
        WHERE date < '$start_date' AND company_id = '$company_id'

        UNION ALL SELECT site_id AS site_id, 0 - amount_debit AS ob, 0 AS expenditure, 0 AS revenue FROM transactions 
        WHERE date < '$start_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0 AND site_id != ''

        UNION ALL SELECT site_id AS site_id, 0 AS ob, 0 AS expenditure, amount AS revenue FROM purchases 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'

        UNION ALL SELECT site_id AS site_id, 0 AS ob, amount AS expenditure, 0 AS revenue FROM mtce_led_list 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'

        UNION ALL SELECT site_id AS site_id, 0 AS ob, amount AS expenditure, 0 AS revenue FROM mtce_stock_list 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'

        UNION ALL SELECT site_id AS site_id, 0 AS ob, amount AS expenditure, 0 AS revenue FROM hiring_list 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id'

        UNION ALL SELECT site_id AS site_id, 0 AS ob, amount_debit AS expenditure, 0 AS revenue FROM transactions 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0 AND site_id != '') AS c GROUP BY site_id";

    } 
    else 
    {
        $query="
        SELECT site_id, SUM(ob) AS ob, SUM(revenue) AS revenue, SUM(expenditure) AS expenditure FROM
        (SELECT site_id AS site_id, amount - 0 AS ob, 0 AS expenditure, 0 AS revenue FROM purchases 
        WHERE date < '$start_date' AND company_id = '$company_id' AND site_id = '$site_id'

        UNION ALL SELECT site_id AS site_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue FROM mtce_led_list 
        WHERE date < '$start_date' AND company_id = '$company_id' AND site_id = '$site_id'

        UNION ALL SELECT site_id AS site_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue FROM mtce_stock_list 
        WHERE date < '$start_date' AND company_id = '$company_id' AND site_id = '$site_id'

        UNION ALL SELECT site_id AS site_id, 0 - amount AS ob, 0 AS expenditure, 0 AS revenue FROM hiring_list 
        WHERE date < '$start_date' AND company_id = '$company_id' AND site_id = '$site_id'

        UNION ALL SELECT site_id AS site_id, 0 - amount_debit AS ob, 0 AS expenditure, 0 AS revenue FROM transactions 
        WHERE date < '$start_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0 AND site_id = '$site_id'

        UNION ALL SELECT site_id AS site_id, 0 AS ob, 0 AS expenditure, amount AS revenue FROM purchases 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND site_id = '$site_id'

        UNION ALL SELECT site_id AS site_id, 0 AS ob, amount AS expenditure, 0 AS revenue FROM mtce_led_list 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND site_id = '$site_id'

        UNION ALL SELECT site_id AS site_id, 0 AS ob, amount AS expenditure, 0 AS revenue FROM mtce_stock_list 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND site_id = '$site_id'
        
        UNION ALL SELECT site_id AS site_id, 0 AS ob, amount AS expenditure, 0 AS revenue FROM hiring_list 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND site_id = '$site_id'

        UNION ALL SELECT site_id AS site_id, 0  AS ob, amount_debit AS expenditure, 0 AS revenue FROM transactions 
        WHERE date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' AND payment_id != '' AND amount_debit > 0 AND site_id = '$site_id') AS c GROUP BY site_id";
    }
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $i=0;
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                            ++$i;
                            $site_id = $row['site_id'];
                                $query_site = "SELECT * FROM site WHERE site_id ='$site_id'";
                          
                                $query_run_site = mysqli_query($con, $query_site);
                                if (mysqli_num_rows($query_run_site) > 0)
                                {
                                    $row_site = mysqli_fetch_assoc($query_run_site);
                                    $site = $row_site['site'];
                                }
                                else
                                {
                                    $site = '--No Name Site--';
                                };

                                $ob = number_format($row['ob'], 2, '.', ',');
                                $revenue = number_format($row['revenue'], 2, '.', ',');
                                $expenditure = number_format($row['expenditure'], 2, '.', ',');
                                $cb = $row['ob'] + $row['revenue'] - $row['expenditure'];
                                $cb = number_format($cb, 2, '.', ',');
?>
                                <tr>
                                    <td class="action-td"><?php echo $i;?></td>
                                    <td><a id="site_report_item_tally_card" 
                                        href="#"
                                        data-id="<?php echo $row['site_id'];?>"
                                        data-id3="<?php echo $start_date;?>"
                                        data-id4="<?php echo $end_date;?>"
                                        data-id5="<?php echo $company_id;?>">
                                        <?php echo $site;?>
                                        </a>
                                    </td>
                                    <td class="amt-td"><?php echo $ob;?></td>
                                    <td class="amt-td"><?php echo $revenue;?></td>
                                    <td class="amt-td"><?php echo $expenditure;?></td>
                                    <td class="amt-td"><?php echo $cb;?></td>
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