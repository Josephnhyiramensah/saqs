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
        if(isset($_SESSION['cash_report_start_date']))
        {           
            $company_id = $_SESSION['cash_report_company_id'];
            $user_id = $_SESSION['cash_report_user_id'];
            $user_super_id = $_SESSION['cash_report_user_super_id'];
            $ledger_id = $_SESSION['cash_report_ledger_id'];
            $start_date = $_SESSION['cash_report_start_date'];
            $end_date = $_SESSION['cash_report_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
                    <table class="table table-hover table-bordered table-sm" id="cash_report_list_table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class = "action-td" colspan="8"><H2><?php echo $row_company['trading_name'];?></H2></th>
                                </tr>
                                <tr>
                                    <th class = "action-td" colspan="8"><H6>CASH REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    echo '<tr>
                                            <th class="action-td">S/NO</th>
                                            <th class="action-td">PARTICULARS</th>
                                            <th class="action-td">'.$row_company['currency'].'</th>
                                            <th class="action-td">'.$row_company['currency'].'</th>
                                            <th class="action-td">'.$row_company['currency'].'</th>
                                        </tr>';
                                    if($ledger_id == 'ALL')
                                    {
                                        $sql_ledger = "SELECT * FROM ledgers WHERE (company_id = '$company_id' AND tb_4=6) OR 
                                        (default_status = 'Yes' AND tb_4 = 6)";
                                    }
                                    else
                                    {
                                        $sql_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
                                    };
                                    
                                    $result_ledger = mysqli_query($con,$sql_ledger);
                                    while($row_ledger = mysqli_fetch_assoc($result_ledger))
                                    {
                                        $ledger_id = $row_ledger['ledger_id'];
                                        
                                        echo '<tr style="background-color:#E4DCCF; color:black">
                                                <th colspan="5"><h5><strong>'.$row_ledger['ledger_desc'].'</strong></h5></th>
                                            </tr>';
                                        //OPENING BALANCE
                                            $sql_ledger_ob = "SELECT SUM(amount_debit) AS total_debit, SUM(amount_credit) AS 
                                            total_credit FROM transactions WHERE ledger_id = '$ledger_id' AND date < '$start_date' AND 
                                            company_id = '$company_id'";
                                            $result_ledger_ob = mysqli_query($con,$sql_ledger_ob);
                                            if (mysqli_num_rows($result_ledger_ob) > 0)
                                            {
                                                $row_ledger_ob = mysqli_fetch_array($result_ledger_ob);
                                                $Opening_balance = $row_ledger_ob['total_debit'] - $row_ledger_ob['total_credit'];
                                            }
                                            else
                                            {
                                                $Opening_balance = 0;
                                            };

                                            $Opening_balance_f = number_format($Opening_balance, 2, '.', ',');
                                            echo '<tr>
                                                    <td colspan="2"><strong>OPENING BALANCE</strong></td>
                                                    <td class="amt-td"></td>
                                                    <td class="amt-td">'.$Opening_balance_f.'</td>
                                                    <td class="amt-td"></td>
                                                </tr>';
                                            
                                        //TOTAL CASH RECEIVED
                                            $sql_led_trans_contra = "SELECT SUM(amount_debit) AS total_debit, ledger_id_contra FROM 
                                            transactions  WHERE ledger_id = '$ledger_id' AND
                                            date BETWEEN '$start_date' AND '$end_date' AND company_id = '$company_id' GROUP BY ledger_id_contra";
                                            $result_led_trans_contra = mysqli_query($con,$sql_led_trans_contra);

                                            $amount_cash_received = 0;
                                            $total_amount_cash_received = 0;
                                            if (mysqli_num_rows($result_led_trans_contra) > 0)
                                            {
                                                echo '<tr>
                                                        <td colspan="2">TOTAL CASH RECEIVED</td>
                                                        <td class="action-td"></td>
                                                        <td class="action-td"></td>
                                                        <td class="amt-td"></td>
                                                    </tr>';
                                                while($row_led_trans_contra = mysqli_fetch_assoc($result_led_trans_contra))
                                                {
                                                    $ledger_id_contra = $row_led_trans_contra['ledger_id_contra'];
                                                    $sql_ledger_lic = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id_contra'";
                                                    $result_ledger_lic = mysqli_query($con,$sql_ledger_lic);
                                                    if(mysqli_num_rows($result_ledger_lic) > 0)
                                                    {
                                                        $row_ledger_lic = mysqli_fetch_assoc($result_ledger_lic);
                                                        $ledger_desc = $row_ledger_lic['ledger_desc'];
                                                    }
                                                    else
                                                    {
                                                        $ledger_desc = 'N/A';
                                                    };
                                                    
                                                    $amount_cash_received = $row_led_trans_contra['total_debit'];
                                                    $total_amount_cash_received = $total_amount_cash_received + $amount_cash_received;
                                                    $amount_cash_received_f = number_format($amount_cash_received, 2, '.', ',');
                                                    if($amount_cash_received != 0)
                                                    {
                                                        echo '<tr>
                                                            <td class="action-td"></td>
                                                            <td>'.$ledger_desc.'</td>
                                                            <td class="amt-td">'.$amount_cash_received_f.'</td>
                                                            <td class="amt-td"></td>
                                                            <td class="amt-td"></td>
                                                        </tr>';
                                                    };
                                                };
                                                $total_amount_cash_received_f = number_format($total_amount_cash_received, 2, '.', ',');
                                                if($total_amount_cash_received != 0)
                                                {
                                                    echo '<tr>
                                                        <td class="action-td"></td>
                                                        <td><strong>TOTAL CASH RECEIVED</strong></td>
                                                        <td class="amt-td"></td>
                                                        <td class="amt-td">'.$total_amount_cash_received_f.'</td>
                                                        <td class="amt-td"></td>
                                                    </tr>';
                                                };
                                            };
                                            
                                            $total_amount_received = $total_amount_cash_received + $Opening_balance;
                                            $total_amount_received_f = number_format($total_amount_received, 2, '.', ',');
                                            if($total_amount_received != 0)
                                            {
                                                echo '<tr>
                                                    <td><strong>TOTAL CASH AVAILABLE</strong></td>
                                                    <td class="action-td"></td>
                                                    <td class="amt-td"></td>
                                                    <td class="amt-td"></td>
                                                    <td class="amt-td"><strong>'.$total_amount_received_f.'</strong></td>
                                                </tr>';
                                            };

                                        //GOODS PURCHASES
                                            $sql_led_trans_contra = "SELECT t.ledger_id_contra, SUM(t.amount_debit) AS total_debit, 
                                            SUM(t.amount_credit) AS total_credit, l.tb_1, l.tb_2, l.tb_3, l.tb_4 FROM 
                                            transactions t JOIN ledgers l ON t.ledger_id_contra=l.ledger_id
                                            WHERE t.ledger_id = '$ledger_id' AND l.tb_2 = 4 AND l.tb_4 = 9 AND
                                            t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id' GROUP BY t.ledger_id_contra";
                                            $result_led_trans_contra = mysqli_query($con,$sql_led_trans_contra);
                                            
                                            $amount_purchased = 0;
                                            $total_amount_purchased = 0;
                                            if (mysqli_num_rows($result_led_trans_contra) > 0)
                                            {
                                                echo '<tr>
                                                        <td colspan="2"><strong>GOODS PURCHASES</strong></td>
                                                        <td class="action-td"></td>
                                                        <td class="action-td"></td>
                                                        <td class="amt-td"></td>
                                                    </tr>';
                                                while($row_led_trans_contra = mysqli_fetch_assoc($result_led_trans_contra))
                                                {
                                                    $ledger_id_contra = $row_led_trans_contra['ledger_id_contra'];
                                                    $sql_ledger_lic = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id_contra'";
                                                    $result_ledger_lic = mysqli_query($con,$sql_ledger_lic);
                                                    
                                                    if(mysqli_num_rows($result_ledger_lic) > 0)
                                                    {
                                                        $row_ledger_lic = mysqli_fetch_assoc($result_ledger_lic);
                                                        $ledger_desc = $row_ledger_lic['ledger_desc'];
                                                    }
                                                    else
                                                    {
                                                        $ledger_desc = 'N/A';
                                                    };
                                                    
                                                    $amount_purchased = $row_led_trans_contra['total_credit'];
                                                    $total_amount_purchased = $total_amount_purchased + $amount_purchased;
                                                    $amount_purchased_f = number_format($amount_purchased, 2, '.', ',');
                                                    if($amount_purchased != 0)
                                                    {
                                                        echo '<tr>
                                                            <td class="action-td"></td>
                                                            <td>'.$ledger_desc.'</td>
                                                            <td class="amt-td">'.$amount_purchased_f.'</td>
                                                            <td class="amt-td"></td>
                                                            <td class="amt-td"></td>
                                                        </tr>';
                                                    };
                                                };
                                                $total_amount_purchased_f = number_format($total_amount_purchased, 2, '.', ',');
                                                if($total_amount_purchased != 0)
                                                {
                                                    echo '<tr>
                                                        <td class="action-td"></td>
                                                        <td><strong>TOTAL GOODS PURCHASED</strong></td>
                                                        <td class="amt-td"></td>
                                                        <td class="amt-td"><strong>'.$total_amount_purchased_f.'</strong></td>
                                                        <td class="amt-td"></td>
                                                    </tr>';
                                                };
                                            };

                                        //EXPENSES
                                            $sql_led_trans_contra = "SELECT t.ledger_id_contra, SUM(t.amount_debit) AS total_debit, 
                                            SUM(t.amount_credit) AS total_credit, l.tb_1, l.tb_2, l.tb_3, l.tb_4 FROM 
                                            transactions t JOIN ledgers l ON t.ledger_id_contra=l.ledger_id
                                            WHERE t.ledger_id = '$ledger_id' AND ((l.tb_2 = 4 AND l.tb_4 != 9) OR(l.tb_2 = 1 AND l.tb_4 != 4 AND l.tb_4 != 6)) AND
                                            t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id' GROUP BY t.ledger_id_contra";
                                            $result_led_trans_contra = mysqli_query($con,$sql_led_trans_contra);

                                            $amount_expenses = 0;
                                            $total_amount_expenses = 0;
                                            if (mysqli_num_rows($result_led_trans_contra) > 0)
                                            {
                                                echo '<tr>
                                                        <td colspan="2"><strong>EXPENSES</strong></td>
                                                        <td class="action-td"></td>
                                                        <td class="action-td"></td>
                                                        <td class="amt-td"></td>
                                                    </tr>';
                                                while($row_led_trans_contra = mysqli_fetch_assoc($result_led_trans_contra))
                                                {
                                                    $ledger_id_contra = $row_led_trans_contra['ledger_id_contra'];
                                                    $sql_ledger_lic = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id_contra'";
                                                    $result_ledger_lic = mysqli_query($con,$sql_ledger_lic);
                                                    
                                                    if(mysqli_num_rows($result_ledger_lic) > 0)
                                                    {
                                                        $row_ledger_lic = mysqli_fetch_assoc($result_ledger_lic);
                                                        $ledger_desc = $row_ledger_lic['ledger_desc'];
                                                    }
                                                    else
                                                    {
                                                        $ledger_desc = 'N/A';
                                                    };
                                                    
                                                    $amount_expenses = $row_led_trans_contra['total_credit'];
                                                    $total_amount_expenses = $total_amount_expenses + $amount_expenses;
                                                    $amount_expenses_f = number_format($amount_expenses, 2, '.', ',');
                                                    if($amount_expenses != 0)
                                                    {
                                                        echo '<tr>
                                                            <td class="action-td"></td>
                                                            <td>'.$ledger_desc.'</td>
                                                            <td class="amt-td">'.$amount_expenses_f.'</td>
                                                            <td class="amt-td"></td>
                                                            <td class="amt-td"></td>
                                                        </tr>';
                                                    };
                                                };
                                                $total_amount_expenses_f = number_format($total_amount_expenses, 2, '.', ',');
                                                if($total_amount_expenses != 0)
                                                {
                                                    echo '<tr>
                                                        <td class="action-td"></td>
                                                        <td><strong>TOTAL EXPENSES</strong></td>
                                                        <td class="amt-td"></td>
                                                        <td class="amt-td"><strong>'.$total_amount_expenses_f.'<strong></td>
                                                        <td class="amt-td"></td>
                                                    </tr>';
                                                };
                                            };

                                        //CASH SENT TO OTHER BRANCHES/HQ
                                            $sql_led_trans_contra = "SELECT t.ledger_id_contra, SUM(t.amount_debit) AS total_debit, 
                                            SUM(t.amount_credit) AS total_credit, l.tb_1, l.tb_2, l.tb_3, l.tb_4 FROM 
                                            transactions t JOIN ledgers l ON t.ledger_id_contra=l.ledger_id
                                            WHERE t.ledger_id = '$ledger_id' AND l.tb_4 = 6 AND
                                            t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id' GROUP BY t.ledger_id_contra";
                                            $result_led_trans_contra = mysqli_query($con,$sql_led_trans_contra);
                                            
                                            $amount_cash_sent = 0;
                                            $total_amount_cash_sent = 0;
                                            if (mysqli_num_rows($result_led_trans_contra) > 0)
                                            {
                                                echo '<tr>
                                                        <td colspan="2"><strong>CASH SENT TO OTHER BRANCHES/HQ</strong></td>
                                                        <td class="action-td"></td>
                                                        <td class="action-td"></td>
                                                        <td class="amt-td"></td>
                                                    </tr>';
                                                while($row_led_trans_contra = mysqli_fetch_assoc($result_led_trans_contra))
                                                {
                                                    $ledger_id_contra = $row_led_trans_contra['ledger_id_contra'];
                                                    $sql_ledger_lic = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id_contra'";
                                                    $result_ledger_lic = mysqli_query($con,$sql_ledger_lic);
                                                    
                                                    if(mysqli_num_rows($result_ledger_lic) > 0)
                                                    {
                                                        $row_ledger_lic = mysqli_fetch_assoc($result_ledger_lic);
                                                        $ledger_desc = $row_ledger_lic['ledger_desc'];
                                                    }
                                                    else
                                                    {
                                                        $ledger_desc = 'N/A';
                                                    };
                                                    
                                                    $amount_cash_sent = $row_led_trans_contra['total_credit'];
                                                    $total_amount_cash_sent = $total_amount_cash_sent + $amount_cash_sent;
                                                    $amount_cash_sent_f = number_format($amount_cash_sent, 2, '.', ',');
                                                    if($amount_cash_sent != 0)
                                                    {
                                                        echo '<tr>
                                                            <td class="action-td"></td>
                                                            <td>'.$ledger_desc.'</td>
                                                            <td class="amt-td">'.$amount_cash_sent_f.'</td>
                                                            <td class="amt-td"></td>
                                                            <td class="amt-td"></td>
                                                        </tr>';
                                                    };
                                                };
                                                $total_amount_cash_sent_f = number_format($total_amount_cash_sent, 2, '.', ',');
                                                if($total_amount_cash_sent != 0)
                                                {
                                                    echo '<tr>
                                                        <td class="action-td"></td>
                                                        <td><strong>TOTAL CASH SENT</strong></td>
                                                        <td class="amt-td"></td>
                                                        <td class="amt-td"><strong>'.$total_amount_cash_sent_f.'</strong></td>
                                                        <td class="amt-td"></td>
                                                    </tr>';
                                                };
                                            };
                                            
                                        //CASH TO SUPPLIER
                                            $sql_led_trans_contra = "SELECT t.ledger_id_contra, SUM(t.amount_debit) AS total_debit, 
                                            SUM(t.amount_credit) AS total_credit, l.tb_1, l.tb_2, l.tb_3, l.tb_4 FROM 
                                            transactions t JOIN ledgers l ON t.ledger_id_contra=l.ledger_id
                                            WHERE t.ledger_id = '$ledger_id' AND l.tb_2 = 2 AND
                                            t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id' GROUP BY t.ledger_id_contra";
                                            $result_led_trans_contra = mysqli_query($con,$sql_led_trans_contra);
                                            $amount_supplier = 0;
                                            $total_amount_supplier = 0;
                                            if (mysqli_num_rows($result_led_trans_contra) > 0)
                                            {
                                                echo '<tr>
                                                        <td colspan="2"><strong>CASH TO SUPPLIER</strong></td>
                                                        <td class="action-td"></td>
                                                        <td class="action-td"></td>
                                                        <td class="amt-td"></td>
                                                    </tr>';
                                                while($row_led_trans_contra = mysqli_fetch_assoc($result_led_trans_contra))
                                                {
                                                    $ledger_id_contra = $row_led_trans_contra['ledger_id_contra'];
                                                    $sql_ledger_lic = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id_contra'";
                                                    $result_ledger_lic = mysqli_query($con,$sql_ledger_lic);
                                                    
                                                    if(mysqli_num_rows($result_ledger_lic) > 0)
                                                    {
                                                        $row_ledger_lic = mysqli_fetch_assoc($result_ledger_lic);
                                                        $ledger_desc = $row_ledger_lic['ledger_desc'];
                                                    }
                                                    else
                                                    {
                                                        $ledger_desc = 'N/A';
                                                    };
                                                    
                                                    $amount_supplier = $row_led_trans_contra['total_credit'];
                                                    $total_amount_supplier = $total_amount_supplier + $amount_supplier;
                                                    $amount_supplier_f = number_format($amount_supplier, 2, '.', ',');
                                                    if($amount_supplier != 0)
                                                    {
                                                        echo '<tr>
                                                            <td class="action-td"></td>
                                                            <td>'.$ledger_desc.'</td>
                                                            <td class="amt-td">'.$amount_supplier_f.'</td>
                                                            <td class="amt-td"></td>
                                                            <td class="amt-td"></td>
                                                        </tr>';
                                                    };
                                                };
                                                $total_amount_supplier_f = number_format($total_amount_supplier, 2, '.', ',');
                                                if($total_amount_supplier != 0)
                                                {
                                                    echo '<tr>
                                                        <td class="action-td"></td>
                                                        <td><strong>TOTAL CASH TO SUPPLIER</strong></td>
                                                        <td class="amt-td"></td>
                                                        <td class="amt-td">'.$total_amount_supplier_f.'</td>
                                                        <td class="amt-td"></td>
                                                    </tr>';
                                                };
                                            };
                                            
                                        //CASH TO CUSTOMERS
                                            $sql_led_trans_contra = "SELECT t.ledger_id_contra, SUM(t.amount_debit) AS total_debit, 
                                            SUM(t.amount_credit) AS total_credit, l.tb_1, l.tb_2, l.tb_3, l.tb_4 FROM 
                                            transactions t JOIN ledgers l ON t.ledger_id_contra=l.ledger_id
                                            WHERE t.ledger_id = '$ledger_id' AND l.tb_2 = 1 AND l.tb_4 = 4 AND
                                            t.date BETWEEN '$start_date' AND '$end_date' AND t.company_id = '$company_id' GROUP BY t.ledger_id_contra";
                                            $result_led_trans_contra = mysqli_query($con,$sql_led_trans_contra);
                                            
                                            $customer_bal = 0;
                                            $total_customer_bal = 0;
                                            if (mysqli_num_rows($result_led_trans_contra) > 0)
                                            {
                                                echo '<tr>
                                                        <td colspan="2"><strong>CASH CUSTOMERS</strong></td>
                                                        <td class="action-td"></td>
                                                        <td class="action-td"></td>
                                                        <td class="amt-td"></td>
                                                    </tr>';
                                                while($row_led_trans_contra = mysqli_fetch_assoc($result_led_trans_contra))
                                                {
                                                    $ledger_id_contra = $row_led_trans_contra['ledger_id_contra'];
                                                    $sql_ledger_lic = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id_contra'";
                                                    $result_ledger_lic = mysqli_query($con,$sql_ledger_lic);
                                                    
                                                    if(mysqli_num_rows($result_ledger_lic) > 0)
                                                    {
                                                        $row_ledger_lic = mysqli_fetch_assoc($result_ledger_lic);
                                                        $ledger_desc = $row_ledger_lic['ledger_desc'];
                                                    }
                                                    else
                                                    {
                                                        $ledger_desc = 'N/A';
                                                    };

                                                    /*$sql_trans_lic = "SELECT SUM(amount_debit) AS total_debit, SUM(amount_credit) AS total_credit 
                                                    FROM transactions WHERE ledger_id = '$ledger_id_contra' AND company_id = '$company_id'
                                                    GROUP BY ledger_id";
                                                    $result_trans_lic = mysqli_query($con,$sql_trans_lic);
                                                    if(mysqli_num_rows($result_trans_lic) > 0)
                                                    {
                                                        while($row_ledger_lic = mysqli_fetch_assoc($result_trans_lic))
                                                        {
                                                            $customer_bal = $row_ledger_lic['total_debit'] - $row_ledger_lic['total_credit'];
                                                        };
                                                    }
                                                    else
                                                    {
                                                        $customer_bal = 0;
                                                    };*/
                                                    $customer_bal = $row_led_trans_contra['total_credit'];
                                                    $total_customer_bal = $total_customer_bal + $customer_bal;
                                                    $customer_bal_f = number_format($customer_bal, 2, '.', ',');
                                                    if($customer_bal != 0)
                                                    {
                                                        echo '<tr>
                                                            <td class="action-td"></td>
                                                            <td>'.$ledger_desc.'</td>
                                                            <td class="amt-td">'.$customer_bal_f.'</td>
                                                            <td class="amt-td"></td>
                                                            <td class="amt-td"></td>
                                                        </tr>';
                                                    };
                                                };
                                                $total_customer_bal_f = number_format($total_customer_bal, 2, '.', ',');
                                                if($total_customer_bal != 0)
                                                {
                                                    echo '<tr>
                                                        <td class="action-td"></td>
                                                        <td><strong>TOTAL CASH TO CUSTOMERS</strong></td>
                                                        <td class="amt-td"></td>
                                                        <td class="amt-td"><strong>'.$total_customer_bal_f.'</strong></td>
                                                        <td class="amt-td"></td>
                                                    </tr>';
                                                };
                                            };
                                            
                                            $total_cash_paid = $total_amount_purchased + $total_amount_expenses + 
                                                                $total_customer_bal + $total_amount_cash_sent + 
                                                                $total_amount_supplier;
                                            $total_cash_paid_f = number_format($total_cash_paid, 2, '.', ',');
                                            if($total_cash_paid != 0)
                                            {
                                                echo '<tr>
                                                    <td><strong>TOTAL CASH PAID</strong></td>
                                                    <td class="action-td"></td>
                                                    <td class="amt-td"></td>
                                                    <td class="amt-td"></td>
                                                    <td class="amt-td"><strong>'.$total_cash_paid_f.'</strong></td>
                                                </tr>';
                                            };
                                            
                                            $account_balance = $total_amount_received - $total_cash_paid;
                                            $account_balance_f = number_format($account_balance, 2, '.', ',');
                                            if($account_balance != 0)
                                            {
                                                echo '<tr>
                                                    <td><strong>CASH BALANCE</strong></td>
                                                    <td class="action-td"></td>
                                                    <td class="amt-td"></td>
                                                    <td class="amt-td"></td>
                                                    <td class="amt-td"><strong>'.$account_balance_f.'</strong></td>
                                                </tr>';
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