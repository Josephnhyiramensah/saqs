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
        if(isset($_SESSION['sales_report_start_date']))
        {           
            /*$company_id = $_SESSION['company_id'];
            $user_id = $_SESSION['user_id'];
            $branch_id = $_SESSION['branch_id'];*/
            $sales_report_company = $_SESSION['sales_report_company'];
            $start_date = $_SESSION['sales_report_start_date'];
            $end_date = $_SESSION['sales_report_end_date'];

            if($sales_report_company == 'ALL')
            {
                $sql_company = "SELECT * FROM company ORDER BY trading_name ASC";
            }
            else
            {
                $sql_company = "SELECT * FROM company WHERE company_id = '$sales_report_company' ORDER BY trading_name ASC";
            };
            
            $result_company = mysqli_query($con,$sql_company);
            while ($row_company = mysqli_fetch_array($result_company))
            {
                $company_id = $row_company['company_id'];
                $tender = '<table class="table table-hover table-bordered table-sm" id="tender_report_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr style="background-color:#E4DCCF; color:black">
                            <th class = "action-td" colspan="12"><H3><strong>'.$row_company['trading_name'].'</strong></H3></th>
                        </tr>
                        <tr>
                            <th class = "action-td" colspan="12"><H6><strong>TENDER REPORT '.$start_date.' TO '.$end_date.'</strong></H6></th>
                        </tr>
                        <tr>
                            <th class="action-td">S/NO</th>
                            <th class="action-td">BRANCH</th>
                            <th class="action-td">CASH</th>
                            <th class="action-td">MOMO</th>
                            <th class="action-td">CREDIT CARD</th>
                            <th class="action-td">INSURANCE</th>
                            <th class="action-td">CHEQUE</th>
                            <th class="action-td">INTER-BRANCH</th>
                            <th class="action-td">OTHERS</th>
                            <th class="action-td">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body" id="tender_report_list_table_body">';
                                    
                        //$query_branch = "SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name ASC";
                        //$query_run_branch = mysqli_query($con, $query_branch);
                            
                        $i = 0;
                        $cash = 0;
                        $momo = 0;
                        $credit_card = 0;
                        $insurance = 0;
                        $cheque = 0;
                        $inter_branch = 0;
                        $others = 0;
                        $total = 0;

                        $sum_cash = 0;
                        $sum_momo = 0;
                        $sum_credit_card = 0;
                        $sum_insurance = 0;
                        $sum_cheque = 0;
                        $sum_inter_branch = 0;
                        $sum_others = 0;
                        $sum_total = 0;
                        /*if (mysqli_num_rows($query_run_branch) > 0)
                        {
                            while($row_branch = mysqli_fetch_assoc($query_run_branch))
                            {*/
                                $i++;
                                //$branch_id = $row_branch['branch_id'];

                                //CASH
                                    $sql_trans_ledger = "SELECT ledger_id, ledger_desc, SUM(Total_Debit) AS Total_Debit, SUM(Total_Credit) AS Total_Credit FROM
                                    (SELECT SUM(t.amt_debit) AS Total_Debit, SUM(t.amt_credit) AS Total_Credit, 
                                    l.ledger_desc AS ledger_desc, t.ledger_id AS ledger_id FROM transactions t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE l.tb_5=8 AND 
                                    t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id' AND 
                                    t.stock_sales_id > 0
                                    UNION ALL SELECT SUM(t.amt_cash) AS Total_Debit, 0 AS Total_Credit, 
                                    l.ledger_desc AS ledger_desc, t.ledger_id AS ledger_id FROM drug_dispense_list t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE l.tb_5=8 AND 
                                    t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id') AS d GROUP BY ledger_id ORDER BY Total_Debit DESC";

                                    $result_trans_ledger = mysqli_query($con,$sql_trans_ledger);
                                    if(!empty($result_trans_ledger) && mysqli_num_rows($result_trans_ledger) > 0)
                                    {
                                        $row_trans_ledger = mysqli_fetch_assoc($result_trans_ledger);
                                        $cash = $row_trans_ledger['Total_Debit'] /*- $row_trans_ledger['Total_Credit']*/;
                                    }
                                    else
                                    {
                                        $cash = 0;
                                    };
                                    $sum_cash = $sum_cash + $cash;
                                    $cash_f = number_format($cash, 2, '.', ',');

                                //MOMO
                                    $sql_trans_ledger = "SELECT ledger_id, ledger_desc, SUM(Total_Debit) AS Total_Debit, SUM(Total_Credit) AS Total_Credit FROM
                                    (SELECT SUM(t.amt_debit) AS Total_Debit, SUM(t.amt_credit) AS Total_Credit, 
                                    l.ledger_desc AS ledger_desc, t.ledger_id AS ledger_id FROM transactions t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE l.tb_5=9 AND 
                                    t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id' AND 
                                    t.stock_sales_id > 0
                                    UNION ALL SELECT SUM(t.amt_cash) AS Total_Debit, 0 AS Total_Credit, 
                                    l.ledger_desc AS ledger_desc, t.ledger_id AS ledger_id FROM drug_dispense_list t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE l.tb_5=9 AND 
                                    t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id') AS d GROUP BY ledger_id ORDER BY Total_Debit DESC";

                                    $result_trans_ledger = mysqli_query($con,$sql_trans_ledger);
                                    if (!empty($result_trans_ledger) && mysqli_num_rows($result_trans_ledger) > 0)
                                    {
                                        $row_trans_ledger = mysqli_fetch_array($result_trans_ledger);
                                        $momo = $row_trans_ledger['Total_Debit'] /*- $row_trans_ledger['Total_Credit']*/;
                                    }
                                    else
                                    {
                                        $momo = 0;
                                    };
                                    $sum_momo = $sum_momo + $momo;
                                    $momo_f = number_format($momo, 2, '.', ',');

                                //CREDIT CARD
                                    $sql_trans_ledger = "SELECT ledger_id, ledger_desc, SUM(Total_Debit) AS Total_Debit, SUM(Total_Credit) AS Total_Credit FROM
                                    (SELECT SUM(t.amt_debit) AS Total_Debit, SUM(t.amt_credit) AS Total_Credit, 
                                    l.ledger_desc AS ledger_desc, t.ledger_id AS ledger_id FROM transactions t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE l.tb_5=10 AND 
                                    t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id' AND 
                                    t.stock_sales_id > 0
                                    UNION ALL SELECT SUM(t.amt_cash) AS Total_Debit, 0 AS Total_Credit, 
                                    l.ledger_desc AS ledger_desc, t.ledger_id AS ledger_id FROM drug_dispense_list t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE l.tb_5=10 AND 
                                    t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id') AS d GROUP BY ledger_id ORDER BY Total_Debit DESC";

                                    $result_trans_ledger = mysqli_query($con,$sql_trans_ledger);
                                    if (!empty($result_trans_ledger) && mysqli_num_rows($result_trans_ledger) > 0)
                                    {
                                        $row_trans_ledger = mysqli_fetch_array($result_trans_ledger);
                                        $credit_card = $row_trans_ledger['Total_Debit'] /*- $row_trans_ledger['Total_Credit']*/;
                                    }
                                    else
                                    {
                                        $credit_card = 0;
                                    };
                                    $sum_credit_card = $sum_credit_card + $credit_card;
                                    $credit_card_f = number_format($credit_card, 2, '.', ',');
                                    
                                //INSURANCE
                                    $sql_trans_ledger = "SELECT ledger_id, ledger_desc, SUM(Total_Debit) AS Total_Debit, SUM(Total_Credit) AS Total_Credit FROM
                                    (SELECT SUM(t.amt_debit) AS Total_Debit, SUM(t.amt_credit) AS Total_Credit, 
                                    l.ledger_desc AS ledger_desc, t.ledger_id AS ledger_id FROM transactions t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE (l.tb_5=12 OR l.tb_5=13) AND 
                                    t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id' AND 
                                    t.stock_sales_id > 0
                                    UNION ALL SELECT SUM(t.amt_cash) AS Total_Debit, 0 AS Total_Credit, 
                                    l.ledger_desc AS ledger_desc, t.ledger_id AS ledger_id FROM drug_dispense_list t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE (l.tb_5=12 OR l.tb_5=13) AND 
                                    t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id') AS d GROUP BY ledger_id ORDER BY Total_Debit DESC";

                                    $result_trans_ledger = mysqli_query($con,$sql_trans_ledger);
                                    if (!empty($result_trans_ledger) && mysqli_num_rows($result_trans_ledger) > 0)
                                    {
                                        $row_trans_ledger = mysqli_fetch_array($result_trans_ledger);
                                        $insurance = $row_trans_ledger['Total_Debit'] /*- $row_trans_ledger['Total_Credit']*/;
                                    }
                                    else
                                    {
                                        $insurance = 0;
                                    };
                                    $sum_insurance = $sum_insurance + $insurance;
                                    $insurance_f = number_format($insurance, 2, '.', ',');
                                    
                                //CHEQUE
                                    $sql_trans_ledger = "SELECT ledger_id, ledger_desc, SUM(Total_Debit) AS Total_Debit, SUM(Total_Credit) AS Total_Credit FROM
                                    (SELECT SUM(t.amt_debit) AS Total_Debit, SUM(t.amt_credit) AS Total_Credit, 
                                    l.ledger_desc AS ledger_desc, t.ledger_id AS ledger_id FROM transactions t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE l.tb_5=7 AND 
                                    t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id' AND 
                                    t.stock_sales_id > 0
                                    UNION ALL SELECT SUM(t.amt_cash) AS Total_Debit, 0 AS Total_Credit, 
                                    l.ledger_desc AS ledger_desc, t.ledger_id AS ledger_id FROM drug_dispense_list t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE l.tb_5=7 AND 
                                    t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id') AS d GROUP BY ledger_id ORDER BY Total_Debit DESC";

                                    $result_trans_ledger = mysqli_query($con,$sql_trans_ledger);
                                    if (!empty($result_trans_ledger) && mysqli_num_rows($result_trans_ledger) > 0)
                                    {
                                        $row_trans_ledger = mysqli_fetch_array($result_trans_ledger);
                                        $cheque = $row_trans_ledger['Total_Debit'] /*- $row_trans_ledger['Total_Credit']*/;
                                    }
                                    else
                                    {
                                        $cheque = 0;
                                    };
                                    $sum_cheque = $sum_cheque + $cheque;
                                    $cheque_f = number_format($cheque, 2, '.', ',');
                                    
                                //INTER-BRANCH
                                    $sql_trans_ledger = "SELECT ledger_id, ledger_desc, SUM(Total_Debit) AS Total_Debit, SUM(Total_Credit) AS Total_Credit FROM
                                    (SELECT SUM(t.amt_debit) AS Total_Debit, SUM(t.amt_credit) AS Total_Credit, 
                                    l.ledger_desc AS ledger_desc, t.ledger_id AS ledger_id FROM transactions t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE l.tb_5=11 AND 
                                    t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id' AND 
                                    t.stock_sales_id > 0
                                    UNION ALL SELECT SUM(t.amt_cash) AS Total_Debit, 0 AS Total_Credit, 
                                    l.ledger_desc AS ledger_desc, t.ledger_id AS ledger_id FROM drug_dispense_list t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE l.tb_5=11 AND 
                                    t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id') AS d GROUP BY ledger_id ORDER BY Total_Debit DESC";

                                    $result_trans_ledger = mysqli_query($con,$sql_trans_ledger);
                                    if (!empty($result_trans_ledger) && mysqli_num_rows($result_trans_ledger) > 0)
                                    {
                                        $row_trans_ledger = mysqli_fetch_array($result_trans_ledger);
                                        $inter_branch = $row_trans_ledger['Total_Debit'] /*- $row_trans_ledger['Total_Credit']*/;
                                    }
                                    else
                                    {
                                        $inter_branch = 0;
                                    };
                                    $sum_inter_branch = $sum_inter_branch + $inter_branch;
                                    $inter_branch_f = number_format($inter_branch, 2, '.', ',');

                                    
                                //OTHERS
                                    $sql_trans_ledger = "SELECT ledger_id, ledger_desc, SUM(Total_Debit) AS Total_Debit, SUM(Total_Credit) AS Total_Credit FROM
                                    (SELECT SUM(t.amt_debit) AS Total_Debit, SUM(t.amt_credit) AS Total_Credit, l.ledger_desc AS ledger_desc, t.ledger_id AS 
                                    ledger_id FROM transactions t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE (l.tb_5 !=7 AND l.tb_5 !=10 AND l.tb_5 !=8 AND 
                                    l.tb_5 !=9 AND l.tb_5 !=12 AND l.tb_5 !=11 AND l.tb_5 !=13) AND t.date BETWEEN '$start_date' AND '$end_date' AND 
                                    t.company_id = '$company_id' AND t.stock_sales_id > 0
                                    UNION ALL SELECT SUM(t.amt_cash) AS Total_Debit, 0 AS Total_Credit, l.ledger_desc AS ledger_desc, t.ledger_id AS ledger_id 
                                    FROM drug_dispense_list t JOIN ledgers l ON t.ledger_id=l.ledger_id WHERE (l.tb_5 !=7 AND l.tb_5 !=10 AND l.tb_5 !=8 AND 
                                    l.tb_5 !=9 AND l.tb_5 !=12 AND l.tb_5 !=11 AND l.tb_5 !=13) AND t.date BETWEEN '$start_date' AND '$end_date' AND 
                                    t.company_id = '$company_id') AS d GROUP BY ledger_id ORDER BY Total_Debit DESC";

                                    $result_trans_ledger = mysqli_query($con,$sql_trans_ledger);
                                    if (!empty($result_trans_ledger) && mysqli_num_rows($result_trans_ledger) > 0)
                                    {
                                        $row_trans_ledger = mysqli_fetch_array($result_trans_ledger);
                                        $others = $row_trans_ledger['Total_Debit'] /*- $row_trans_ledger['Total_Credit']*/;
                                    }
                                    else
                                    {
                                        $others = 0;
                                    };
                                    $sum_others = $sum_others + $others;
                                    $others_f = number_format($others, 2, '.', ',');
                                //TOTAL
                                    $total = $cash + $momo + $credit_card + $insurance + $cheque + $others + $inter_branch;
                                    $sum_total = $sum_total + $total;
                                    $total_f = number_format($total, 2, '.', ',');
                                    
                                //if($total > 0)
                                //{
                                    $tender .= '<tr>
                                        <td class="action-td">'.$i.'</td>
                                        <td>'.$row_company['trading_name'].'</td>
                                        <td class="amt-td">'.$cash_f.'</td>
                                        <td class="amt-td">'.$momo_f.'</td>
                                        <td class="amt-td">'.$credit_card_f.'</td>
                                        <td class="amt-td">'.$insurance_f.'</td>
                                        <td class="amt-td">'.$cheque_f.'</td>
                                        <td class="amt-td">'.$inter_branch_f.'</td>
                                        <td class="amt-td">'.$others_f.'</td>
                                        <td class="amt-td">'.$total_f.'</td>
                                    </tr>';
                                //};
                            //};
                        //};
                                
                        $sum_cash_f = number_format($sum_cash, 2, '.', ',');
                        $sum_momo_f = number_format($sum_momo, 2, '.', ',');
                        $sum_credit_card_f = number_format($sum_credit_card, 2, '.', ',');
                        $sum_insurance_f = number_format($sum_insurance, 2, '.', ',');
                        $sum_cheque_f = number_format($sum_cheque, 2, '.', ',');
                        $sum_others_f = number_format($sum_others, 2, '.', ',');
                        $sum_inter_branch_f = number_format($sum_inter_branch, 2, '.', ',');
                        $sum_total_f = number_format($sum_total, 2, '.', ',');
                        $tender .= '<tr>
                            <th class="action-td" colspan="2">TOTAL</th>
                            <th class="amt-td">'.$sum_cash_f.'</th>
                            <th class="amt-td">'.$sum_momo_f.'</th>
                            <th class="amt-td">'.$sum_credit_card_f.'</th>
                            <th class="amt-td">'.$sum_insurance_f.'</th>
                            <th class="amt-td">'.$sum_cheque_f.'</th>
                            <th class="amt-td">'.$sum_inter_branch_f.'</th>
                            <th class="amt-td">'.$sum_others_f.'</th>
                            <th class="amt-td">'.$sum_total_f.'</th>
                        </tr>';
                           
                    $tender .= '</tbody>
                </table>';
                if($sum_total > 0){ echo $tender;};

                $sales_items = '<table class="table table-hover table-bordered table-sm" id="sales_report_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" colspan="12"><H6><strong>SALES REPORT '.$start_date.' TO '.$end_date.'</strong></H6></th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body" id="tender_report_list_table_body">';
                    
                        /*$query_branch = "SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name ASC";
                        $query_run_branch = mysqli_query($con, $query_branch);
                        if (mysqli_num_rows($query_run_branch) > 0)
                        {
                            while($row_branch = mysqli_fetch_assoc($query_run_branch))
                            {*/
                                $i=0;
                                $grand_total_amount = 0;
                                $grand_total_amount_disc = 0;
                                $i++;
                                $x = 0;
                                $total_amount = 0;
                                $total_amount_disc = 0;
                                //$branch_id = $row_branch['branch_id'];

                                $query_sales = "SELECT ledger_id, sales_id, stock_item_id, stock_item, code, created_by, price, 
                                amount, price_disc, amount_disc, date, qty FROM
                                (SELECT 0 AS ledger_id, s.stock_sales_id AS sales_id, d.stock_item AS stock_item, d.code AS code, s.stock_item_id, 
                                s.created_by, s.price, s.amount, s.price_disc, s.amount_disc, s.date, s.qty FROM stock_sales_items s 
                                JOIN stock_items d ON s.stock_item_id=d.stock_item_id WHERE s.company_id = '$company_id' AND s.date BETWEEN '$start_date' 
                                AND '$end_date'
                                UNION ALL SELECT s.ledger_id, s.drug_list_id AS sales_id, d.stock_item AS stock_item, d.code AS code, s.drug_id AS 
                                stock_item_id, s.created_by, s.price_cash AS price, s.amt_cash AS amount, 0 AS price_disc, 0 AS 
                                amount_disc, s.date, s.qty FROM drug_dispense_list s JOIN stock_items d ON s.drug_id=d.stock_item_id WHERE 
                                s.company_id = '$company_id' AND s.date BETWEEN '$start_date' AND '$end_date') 
                                AS d";

                                $query_run_sales = mysqli_query($con, $query_sales);
                                if (!empty($query_run_sales) && mysqli_num_rows($query_run_sales) > 0)
                                {
                                    $sales_items .= '<tr style="background-color:#E4DCCF; color:black">
                                        <td class="action-td">'.$i.'</td>
                                        <td colspan="12">'.$row_company['trading_name'].'</td>
                                    </tr>
                                    <tr>
                                        <th class="action-td">S/NO</th>
                                        <th class="action-td">DATE</th>
                                        <th class="action-td">STORE</th>
                                        <th class="action-td">CASHIER</th>
                                        <th class="action-td">INVOICE NO</th>
                                        <th class="action-td">ITEM NUMBER</th>
                                        <th class="action-td">ITEM</th>
                                        <th class="action-td">QTY</th>
                                        <th class="action-td">PRICE</th>
                                        <th class="action-td">AMOUNT</th>
                                        <th class="action-td">DISC. PRICE</th>
                                        <th class="action-td">DISC. AMOUNT</th>
                                    </tr>';
                                    while($row_sales = mysqli_fetch_assoc($query_run_sales))
                                    {
                                        $x++;
                                        $stock_item_id = $row_sales['stock_item_id'];
                                        $stock_item = $row_sales['stock_item'];
                                        $item_number = $row_sales['code'];

                                        //CREATED BY
                                            $created_by = $row_sales['created_by'];
                                            $query_created_by = "SELECT * FROM users WHERE id = '$created_by'";
                                            $query_run_created_by = mysqli_query($con, $query_created_by);
                                            if (!empty($query_run_created_by) && mysqli_num_rows($query_run_created_by) > 0)
                                            {
                                                $row_created_by = mysqli_fetch_assoc($query_run_created_by);
                                                $creator = $row_created_by['first_name'].' '.$row_created_by['last_name'];
                                            }
                                            else
                                            {
                                                $creator = 'Not Specified';
                                            };
                                        $price = $row_sales['price'];
                                        $amount = $row_sales['amount'];
                                        $price_disc = $row_sales['price_disc'];
                                        $amount_disc = $row_sales['amount_disc'];
                                        $price_f = number_format($price, 2, '.', ',');
                                        $amount_f = number_format($amount, 2, '.', ',');
                                        $price_disc_f = number_format($price_disc, 2, '.', ',');
                                        $amount_disc_f = number_format($amount_disc, 2, '.', ',');
                                        $sales_items .= '<tr>
                                            <td class="action-td"><small>'.$x.'</small></td>
                                            <td class="action-td"><small>'.$row_sales['date'].'</small></td>
                                            <td><small>'.$row_company['trading_name'].'</small></td>
                                            <td><small>'.$creator.'</small></td>
                                            <td class="action-td"><small>'.$row_sales['sales_id'].'</small></td>
                                            <td><small>'.$item_number.'</small></td>
                                            <td><small>'.$stock_item.'</small></td>
                                            <td class="action-td"><small>'.$row_sales['qty'].'</small></td>
                                            <td class="amt-td"><small>'.$price_f.'</small></td>
                                            <td class="amt-td"><small>'.$amount_f.'</small></td>
                                            <td class="amt-td"><small>'.$price_disc_f.'</small></td>
                                            <td class="amt-td"><small>'.$amount_disc_f.'</small></td>
                                        </tr>';
                                        $total_amount = $total_amount + $row_sales['amount'];
                                        $total_amount_disc = $total_amount_disc + $row_sales['amount_disc'];
                                        $grand_total_amount = $grand_total_amount + $row_sales['amount'];
                                        $grand_total_amount_disc = $grand_total_amount_disc + $row_sales['amount_disc'];
                                    };
                                    $total_amount_f = number_format($total_amount, 2, '.', ',');
                                    $total_amount_disc_f = number_format($total_amount_disc, 2, '.', ',');
                                    $sales_items .= '<tr style="color:black">
                                        <th class="action-td" colspan="8">TOTAL</th>
                                        <th class="amt-td"></th>
                                        <th class="amt-td">'.$total_amount_f.'</th>
                                        <th class="amt-td"></th>
                                        <th class="amt-td">'.$total_amount_disc_f.'</th>
                                    </tr>';
                                };
                            /*};
                            $grand_total_amount_f = number_format($grand_total_amount, 2, '.', ',');
                            $grand_total_amount_disc_f = number_format($grand_total_amount_disc, 2, '.', ',');
                            $sales_items .= '<tr style="color:black">
                                <th class="action-td" colspan="8">GRAND TOTAL</th>
                                <th class="amt-td"></th>
                                <th class="amt-td">'.$grand_total_amount_f.'</th>
                                <th class="amt-td"></th>
                                <th class="amt-td">'.$grand_total_amount_disc_f.'</th>
                            </tr>';
                        };*/
                    $sales_items .= '</tbody>
                </table>';
                
                if($grand_total_amount > 0){echo $sales_items;};
                //echo $sales_items;
            }
        };
        ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/sales_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>