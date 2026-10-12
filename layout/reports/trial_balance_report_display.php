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
        if(isset($_SESSION['trial_balance_report_start_date']))
        {           
            $company_id = $_SESSION['company_id'];
            $start_date = $_SESSION['trial_balance_report_start_date'];
            $end_date = $_SESSION['trial_balance_report_end_date'];
            $branch = $_SESSION['trial_balance_report_branch'];
            $current_year = date('Y');
            $beginning_of_the_year = date($current_year.'-01-01');
            $amount_debit = 0;
            $amount_credit = 0;
            $grand_total_debit = 0;
            $grand_total_credit = 0;

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    
            echo '<table class="table table-hover table-bordered table-sm" id="trial_balance_report_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr style="background-color:grey; color:white">
                        <th class = "action-td" colspan="8"><H2><strong>'.$row_company['trading_name'].'</strong></H2></th>
                    </tr>
                    <tr style="background-color:grey; color:white">
                        <th class = "action-td" colspan="8"><H6><strong>TRIAL BALANCE AT '.$end_date.'</strong></H6></th>
                    </tr>
                    <tr style="background-color:grey; color:white">
                        <th>GROUP</th>
                        <th>SUB 1</th>
                        <th>SUB 2</th>
                        <th>SUB 3</th>
                        <th>SUB 4</th>
                        <th>LEDGER</th>
                        <th class="action-td">DEBIT</th>
                        <th class="action-td">CREDIT</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body" id="trial_balance_report_list_table_body">';
            
                    $tb_total_debit = 0;
                    $tb_total_credit = 0;
                    $sql_tb_1 = "SELECT id, tb_1_desc FROM trial_bal_group_1 ORDER BY tb_1_desc ASC";
                    $result_tb_1 = mysqli_query($con,$sql_tb_1);
                    if (mysqli_num_rows($result_tb_1) > 0)
                    {
                        while($row_tb_1 = mysqli_fetch_array($result_tb_1))
                        {
                            echo '<tr style="background-color:#E4DCCF; color:black">
                                <td colspan="8"><strong>'.$row_tb_1['tb_1_desc'].'</strong></td>
                            </tr>';
                            $tb_1_id = $row_tb_1['id'];
                            $sql_tb_2 = "SELECT id, tb_2_desc FROM trial_bal_group_2 WHERE tb_1_id='$tb_1_id' ORDER BY tb_2_desc ASC";
                            $result_tb_2 = mysqli_query($con,$sql_tb_2);
                            if (mysqli_num_rows($result_tb_2) > 0)
                            {
                                while($row_tb_2 = mysqli_fetch_array($result_tb_2))
                                {
                                    if(isset($row_tb_2['tb_2_desc'])){$tb_2_desc = $row_tb_2['tb_2_desc'];}else{$tb_2_desc = 'Not Specified';};
                                    $tb_2_total_debit = 0;
                                    $tb_2_total_credit = 0;
                                    echo '<tr style="background-color:#F1EEEE; color:black">
                                        <td></td>
                                        <td colspan="7"><strong>'.$tb_2_desc.'</strong></td>
                                    </tr>';
                                    $tb_2_id = $row_tb_2['id'];
                                    $sql_tb_3 = "SELECT id, tb_3_desc FROM trial_bal_group_3 WHERE tb_2_id='$tb_2_id' ORDER BY tb_3_desc ASC";
                                    $result_tb_3 = mysqli_query($con,$sql_tb_3);
                                    if (mysqli_num_rows($result_tb_3) > 0)
                                    {
                                        while($row_tb_3 = mysqli_fetch_array($result_tb_3))
                                        {
                                            if(isset($row_tb_3['tb_3_desc'])){$tb_3_desc = $row_tb_3['tb_3_desc'];}else{$tb_3_desc = 'Not Specified';};
                                            $tb_3_total_debit = 0;
                                            $tb_3_total_credit = 0;
                                            echo '<tr>
                                                <td colspan="2"></td>
                                                <td colspan="6">'.$tb_3_desc.'</td>
                                            </tr>';
                                            $tb_3_id = $row_tb_3['id'];
                                            $sql_tb_4 = "SELECT id, tb_4_desc FROM trial_bal_group_4 WHERE tb_3_id='$tb_3_id' ORDER BY tb_4_desc ASC";
                                            $result_tb_4 = mysqli_query($con,$sql_tb_4);
                                            if (mysqli_num_rows($result_tb_4) > 0)
                                            {
                                                while($row_tb_4 = mysqli_fetch_array($result_tb_4))
                                                {
                                                    if(isset($row_tb_4['tb_4_desc'])){$tb_4_desc = $row_tb_4['tb_4_desc'];}else{$tb_4_desc = 'Not Specified';};
                                                    $tb_4_total_debit = 0;
                                                    $tb_4_total_credit = 0;
                                                    echo '<tr>
                                                        <td colspan="3"></td>
                                                        <td colspan="5">'.$tb_4_desc.'</td>
                                                    </tr>';
                                                    $tb_4_id = $row_tb_4['id'];
                                                    $sql_tb_5 = "SELECT id, tb_5_desc FROM trial_bal_group_5 WHERE tb_4_id='$tb_4_id' ORDER BY tb_5_desc ASC";
                                                    $result_tb_5 = mysqli_query($con,$sql_tb_5);
                                                    if (mysqli_num_rows($result_tb_5) > 0)
                                                    {
                                                        while($row_tb_5 = mysqli_fetch_array($result_tb_5))
                                                        {
                                                            if(isset($row_tb_5['tb_5_desc'])){$tb_5_desc = $row_tb_5['tb_5_desc'];}else{$tb_5_desc = 'Not Specified';};
                                                            $tb_5_total_debit = 0;
                                                            $tb_5_total_credit = 0;
                                                            echo '<tr>
                                                                <td colspan="4"></td>
                                                                <td colspan="4">'.$tb_5_desc.'</td>
                                                            </tr>';
                                                            $tb_5_id = $row_tb_5['id'];

                                                            if($branch == 'ALL')
                                                            {
                                                                $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc, l.tb_2, l.ledger_desc FROM transactions t JOIN ledgers l ON
                                                                t.ledger_id=l.ledger_id WHERE t.date BETWEEN '$start_date' AND '$end_date' AND l.tb_5 = '$tb_5_id'
                                                                GROUP BY t.ledger_id";
                                                            }
                                                            else
                                                            {
                                                                $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc, l.tb_2, l.ledger_desc FROM transactions t JOIN ledgers l ON
                                                                t.ledger_id=l.ledger_id WHERE t.branch_id='$branch' AND t.date BETWEEN '$start_date' AND 
                                                                '$end_date' AND l.tb_5 = '$tb_5_id' GROUP BY t.ledger_id";
                                                            };

                                                            $result_trans_ledger = mysqli_query($con,$sql_trans_ledger);
                                                            if (mysqli_num_rows($result_trans_ledger) > 0)
                                                            {
                                                                $i = 0;
                                                                while($row_trans_ledger = mysqli_fetch_array($result_trans_ledger))
                                                                {
                                                                    $i++;
                                                                    $ledger_id = $row_trans_ledger['ledger_id'];
                                                                        if($branch == 'ALL')
                                                                        {
                                                                            if($row_trans_ledger['tb_2'] < 3)
                                                                            {
                                                                                $sql_ledger_ob = "SELECT SUM(amt_debit) AS total_debit, SUM(amt_credit) AS total_credit FROM 
                                                                                transactions WHERE ledger_id = '$ledger_id' AND date < '$start_date' AND 
                                                                                company_id = '$company_id'";
                                                                            }
                                                                            else 
                                                                            {
                                                                                $sql_ledger_ob = "SELECT SUM(amt_debit) AS total_debit, SUM(amt_credit) AS total_credit FROM 
                                                                                transactions WHERE ledger_id = '$ledger_id' AND date BETWEEN '$beginning_of_the_year' AND 
                                                                                '$start_date' AND company_id = '$company_id'";
                                                                            };
                                                                        }
                                                                        else
                                                                        {
                                                                            if($row_trans_ledger['tb_2'] < 3)
                                                                            {
                                                                                $sql_ledger_ob = "SELECT SUM(amt_debit) AS total_debit, SUM(amt_credit) AS total_credit FROM 
                                                                                transactions WHERE branch_id='$branch' AND ledger_id = '$ledger_id' AND date < '$start_date' AND 
                                                                                company_id = '$company_id'";
                                                                            }
                                                                            else 
                                                                            {
                                                                                $sql_ledger_ob = "SELECT SUM(amt_debit) AS total_debit, SUM(amt_credit) AS total_credit FROM 
                                                                                transactions WHERE branch_id='$branch' AND ledger_id = '$ledger_id' AND date BETWEEN 
                                                                                '$beginning_of_the_year' AND '$start_date' AND company_id = '$company_id'";
                                                                            };
                                                                        };
                                                                        $result_ledger_ob = mysqli_query($con,$sql_ledger_ob);
                                                                        $row_ledger_ob = mysqli_fetch_array($result_ledger_ob);
                                                                        if ($row_trans_ledger['tb_2'] == 1 OR $row_trans_ledger['tb_2'] == 4)
                                                                        {
                                                                            $Opening_balance = $row_ledger_ob['total_debit'] - $row_ledger_ob['total_credit'];
                                                                        }
                                                                        else if ($row_trans_ledger['tb_2'] == 2 OR $row_trans_ledger['tb_2'] == 3)
                                                                        {
                                                                            $Opening_balance = $row_ledger_ob['total_credit'] - $row_ledger_ob['total_debit'];
                                                                        };

                                                                        $Opening_balance_f = number_format($Opening_balance, 2, '.', ',');
                                                                
                                                                
                                                                        if($branch == 'ALL')
                                                                        {
                                                                            $sql_ledger_trans = "SELECT SUM(amt_debit) AS total_trans_debit, SUM(amt_credit) AS 
                                                                            total_trans_credit FROM transactions WHERE ledger_id = '$ledger_id' AND date BETWEEN 
                                                                            '$start_date' AND '$end_date'";
                                                                        }
                                                                        else
                                                                        {
                                                                            $sql_ledger_trans = "SELECT SUM(amt_debit) AS total_trans_debit, SUM(amt_credit) AS 
                                                                            total_trans_credit FROM transactions WHERE branch_id='$branch' AND ledger_id = '$ledger_id' AND date BETWEEN 
                                                                            '$start_date' AND '$end_date'";
                                                                        };
                                                                        $result_ledger_trans = mysqli_query($con,$sql_ledger_trans);
                                                                        if (mysqli_num_rows($result_ledger_trans) > 0)
                                                                        {
                                                                            while($row_ledger_trans = mysqli_fetch_array($result_ledger_trans))
                                                                            {
                                                                                if ($row_trans_ledger['tb_2'] == 1 OR $row_trans_ledger['tb_2'] == 4)
                                                                                {
                                                                                    $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_debit'] - $row_ledger_trans['total_trans_credit'];
                                                                                    if($closing_balance > 0){
                                                                                        $amount_debit = $closing_balance;
                                                                                        $amount_credit = 0;
                                                                                    }else{
                                                                                        $amount_debit = 0;
                                                                                        $amount_credit = -$closing_balance;
                                                                                    };
                                                                                }
                                                                                else if ($row_trans_ledger['tb_2'] == 2 OR $row_trans_ledger['tb_2'] == 3)
                                                                                {
                                                                                    $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_credit'] - $row_ledger_trans['total_trans_debit'];
                                                                                    if($closing_balance > 0){
                                                                                        $amount_debit = 0;
                                                                                        $amount_credit = $closing_balance;
                                                                                    }else{
                                                                                        $amount_debit = -$closing_balance;
                                                                                        $amount_credit = 0;
                                                                                    };
                                                                                };

                                                                                $grand_total_debit = $grand_total_debit + $amount_debit;
                                                                                $grand_total_credit = $grand_total_credit + $amount_credit;

                                                                                echo '<tr>
                                                                                    <td colspan="5"></td>
                                                                                    <td>'.$row_trans_ledger['ledger_desc'].'</td>';
                                                                                        $amount_debit_f = number_format($amount_debit, 2, '.', ',');
                                                                                    
                                                                                    echo '<td class="amt-td">'.$amount_debit_f,'</td>';
                                                                                    
                                                                                        $amount_credit_f = number_format($amount_credit, 2, '.', ',');
                                                                                
                                                                                    echo '<td class="amt-td">'.$amount_credit_f.'</td>
                                                                                </tr>';
                                                                                    
                                                                            }
                                                                        };
                                                                };
                                                            };
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if($branch == 'ALL')
                                                        {
                                                            $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc, l.tb_2 FROM transactions t JOIN ledgers l ON
                                                            t.ledger_id=l.ledger_id WHERE t.date BETWEEN '$start_date' AND '$end_date' AND l.tb_4 = '$tb_4_id' AND l.tb_5 < 1
                                                            GROUP BY t.ledger_id";
                                                        }
                                                        else
                                                        {
                                                            $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc, l.tb_2  FROM transactions t JOIN ledgers l ON
                                                            t.ledger_id=l.ledger_id WHERE t.branch_id='$branch' AND t.date BETWEEN '$start_date' AND 
                                                            '$end_date' AND l.tb_4 = '$tb_4_id' AND l.tb_5 < 1 GROUP BY t.ledger_id";
                                                        };

                                                        $result_trans_ledger = mysqli_query($con,$sql_trans_ledger);
                                                        if (mysqli_num_rows($result_trans_ledger) > 0)
                                                        {
                                                            $i = 0;
                                                            while($row_trans_ledger = mysqli_fetch_array($result_trans_ledger))
                                                            {
                                                                $i++;
                                                                $ledger_id = $row_trans_ledger['ledger_id'];
                                                                    if($branch == 'ALL')
                                                                    {
                                                                        $sql_ledger_ob = "SELECT SUM(amt_debit) AS total_debit, SUM(amt_credit) AS total_credit FROM 
                                                                        transactions WHERE ledger_id = '$ledger_id' AND date < '$start_date' AND 
                                                                        company_id = '$company_id'";
                                                                    }
                                                                    else
                                                                    {
                                                                        $sql_ledger_ob = "SELECT SUM(amt_debit) AS total_debit, SUM(amt_credit) AS total_credit FROM 
                                                                        transactions WHERE branch_id='$branch' AND ledger_id = '$ledger_id' AND date < '$start_date' AND 
                                                                        company_id = '$company_id'";
                                                                    };
                                                                    $result_ledger_ob = mysqli_query($con,$sql_ledger_ob);
                                                                    $row_ledger_ob = mysqli_fetch_array($result_ledger_ob);
                                                                    if ($row_trans_ledger['tb_2'] == 1 OR $row_trans_ledger['tb_2'] == 4)
                                                                    {
                                                                        $Opening_balance = $row_ledger_ob['total_debit'] - $row_ledger_ob['total_credit'];
                                                                    }
                                                                    else if ($row_trans_ledger['tb_2'] == 2 OR $row_trans_ledger['tb_2'] == 3)
                                                                    {
                                                                        $Opening_balance = $row_ledger_ob['total_credit'] - $row_ledger_ob['total_debit'];
                                                                    };

                                                                    $Opening_balance_f = number_format($Opening_balance, 2, '.', ',');
                                                            
                                                            
                                                                    if($branch == 'ALL')
                                                                    {
                                                                        $sql_ledger_trans = "SELECT SUM(amt_debit) AS total_trans_debit, SUM(amt_credit) AS 
                                                                        total_trans_credit FROM transactions WHERE ledger_id = '$ledger_id' AND date BETWEEN 
                                                                        '$start_date' AND '$end_date'";
                                                                    }
                                                                    else
                                                                    {
                                                                        $sql_ledger_trans = "SELECT SUM(amt_debit) AS total_trans_debit, SUM(amt_credit) AS 
                                                                        total_trans_credit FROM transactions WHERE branch_id='$branch' AND ledger_id = '$ledger_id' AND date BETWEEN 
                                                                        '$start_date' AND '$end_date'";
                                                                    };
                                                                    $result_ledger_trans = mysqli_query($con,$sql_ledger_trans);
                                                                    if (mysqli_num_rows($result_ledger_trans) > 0)
                                                                    {
                                                                        
                                                                        while($row_ledger_trans = mysqli_fetch_array($result_ledger_trans))
                                                                        {
                                                                                if ($row_trans_ledger['tb_2'] == 1 OR $row_trans_ledger['tb_2'] == 4)
                                                                                {
                                                                                    $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_debit'] - $row_ledger_trans['total_trans_credit'];
                                                                                    if($closing_balance > 0){
                                                                                        $amount_debit = $closing_balance;
                                                                                        $amount_credit = 0;
                                                                                    }else{
                                                                                        $amount_debit = 0;
                                                                                        $amount_credit = -$closing_balance;
                                                                                    };
                                                                                }
                                                                                else if ($row_trans_ledger['tb_2'] == 2 OR $row_trans_ledger['tb_2'] == 3)
                                                                                {
                                                                                    $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_credit'] - $row_ledger_trans['total_trans_debit'];
                                                                                    if($closing_balance > 0){
                                                                                        $amount_debit = 0;
                                                                                        $amount_credit = $closing_balance;
                                                                                    }else{
                                                                                        $amount_debit = -$closing_balance;
                                                                                        $amount_credit = 0;
                                                                                    };
                                                                                };

                                                                                $grand_total_debit = $grand_total_debit + $amount_debit;
                                                                                $grand_total_credit = $grand_total_credit + $amount_credit;

                                                                            echo '<tr>
                                                                                <td colspan="5"></td>
                                                                                <td>'.$row_trans_ledger['ledger_desc'].'</td>';
                                                                                
                                                                                    $amount_debit_f = number_format($amount_debit, 2, '.', ',');
                                                                                
                                                                                echo '<td class="amt-td">'.$amount_debit_f,'</td>';
                                                                                
                                                                                    $amount_credit_f = number_format($amount_credit, 2, '.', ',');
                                                                            
                                                                                echo '<td class="amt-td">'.$amount_credit_f.'</td>
                                                                            </tr>';
                                                                                
                                                                        }
                                                                    };
                                                            };
                                                        };
                                                    };
                                                }
                                            }
                                            else
                                            {
                                                if($branch == 'ALL')
                                                {
                                                    $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc, l.tb_2 FROM transactions t JOIN ledgers l ON
                                                    t.ledger_id=l.ledger_id WHERE t.date BETWEEN '$start_date' AND '$end_date' AND l.tb_3 = '$tb_3_id' AND l.tb_4 < 1
                                                    GROUP BY t.ledger_id";
                                                }
                                                else
                                                {
                                                    $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc, l.tb_2 FROM transactions t JOIN ledgers l ON
                                                    t.ledger_id=l.ledger_id WHERE t.branch_id='$branch' AND t.date BETWEEN '$start_date' AND 
                                                    '$end_date' AND l.tb_3 = '$tb_3_id' AND l.tb_4 < 1 GROUP BY t.ledger_id";
                                                };

                                                $result_trans_ledger = mysqli_query($con,$sql_trans_ledger);
                                                if (mysqli_num_rows($result_trans_ledger) > 0)
                                                {
                                                    $i = 0;
                                                    while($row_trans_ledger = mysqli_fetch_array($result_trans_ledger))
                                                    {
                                                        $i++;
                                                        $ledger_id = $row_trans_ledger['ledger_id'];

                                                            if($branch == 'ALL')
                                                            {
                                                                $sql_ledger_ob = "SELECT SUM(amt_debit) AS total_debit, SUM(amt_credit) AS total_credit FROM 
                                                                transactions WHERE ledger_id = '$ledger_id' AND date < '$start_date' AND 
                                                                company_id = '$company_id'";
                                                            }
                                                            else
                                                            {
                                                                $sql_ledger_ob = "SELECT SUM(amt_debit) AS total_debit, SUM(amt_credit) AS total_credit FROM 
                                                                transactions WHERE branch_id='$branch' AND ledger_id = '$ledger_id' AND date < '$start_date' AND 
                                                                company_id = '$company_id'";
                                                            };
                                                            $result_ledger_ob = mysqli_query($con,$sql_ledger_ob);
                                                            $row_ledger_ob = mysqli_fetch_array($result_ledger_ob);
                                                            if ($row_trans_ledger['tb_2'] == 1 OR $row_trans_ledger['tb_2'] == 4)
                                                            {
                                                                $Opening_balance = $row_ledger_ob['total_debit'] - $row_ledger_ob['total_credit'];
                                                            }
                                                            else if ($row_trans_ledger['tb_2'] == 2 OR $row_trans_ledger['tb_2'] == 3)
                                                            {
                                                                $Opening_balance = $row_ledger_ob['total_credit'] - $row_ledger_ob['total_debit'];
                                                            };

                                                            $Opening_balance_f = number_format($Opening_balance, 2, '.', ',');
                                                    
                                                    
                                                            if($branch == 'ALL')
                                                            {
                                                                $sql_ledger_trans = "SELECT SUM(amt_debit) AS total_trans_debit, SUM(amt_credit) AS 
                                                                total_trans_credit FROM transactions WHERE ledger_id = '$ledger_id' AND date BETWEEN 
                                                                '$start_date' AND '$end_date'";
                                                            }
                                                            else
                                                            {
                                                                $sql_ledger_trans = "SELECT SUM(amt_debit) AS total_trans_debit, SUM(amt_credit) AS 
                                                                total_trans_credit FROM transactions WHERE branch_id='$branch' AND ledger_id = '$ledger_id' AND date BETWEEN 
                                                                '$start_date' AND '$end_date'";
                                                            };
                                                            $result_ledger_trans = mysqli_query($con,$sql_ledger_trans);
                                                            if (mysqli_num_rows($result_ledger_trans) > 0)
                                                            {
                                                                
                                                                while($row_ledger_trans = mysqli_fetch_array($result_ledger_trans))
                                                                {
                                                                    if ($row_trans_ledger['tb_2'] == 1 OR $row_trans_ledger['tb_2'] == 4)
                                                                    {
                                                                        $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_debit'] - $row_ledger_trans['total_trans_credit'];
                                                                        if($closing_balance > 0){
                                                                            $amount_debit = $closing_balance;
                                                                            $amount_credit = 0;
                                                                        }else{
                                                                            $amount_debit = 0;
                                                                            $amount_credit = -$closing_balance;
                                                                        };
                                                                    }
                                                                    else if ($row_trans_ledger['tb_2'] == 2 OR $row_trans_ledger['tb_2'] == 3)
                                                                    {
                                                                        $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_credit'] - $row_ledger_trans['total_trans_debit'];
                                                                        if($closing_balance > 0){
                                                                            $amount_debit = 0;
                                                                            $amount_credit = $closing_balance;
                                                                        }else{
                                                                            $amount_debit = -$closing_balance;
                                                                            $amount_credit = 0;
                                                                        };
                                                                    };

                                                                    $grand_total_debit = $grand_total_debit + $amount_debit;
                                                                    $grand_total_credit = $grand_total_credit + $amount_credit;
                                                                    echo '<tr>
                                                                        <td colspan="5"></td>
                                                                        <td>'.$row_trans_ledger['ledger_desc'].'</td>';
                                                                            $amount_debit_f = number_format($amount_debit, 2, '.', ',');
                                                                        
                                                                        echo '<td class="amt-td">'.$amount_debit_f,'</td>';
                                                                            $amount_credit_f = number_format($amount_credit, 2, '.', ',');
                                                                    
                                                                        echo '<td class="amt-td">'.$amount_credit_f.'</td>
                                                                    </tr>';
                                                                        
                                                                }
                                                            };
                                                    };
                                                };
                                            };
                                        }
                                    };
                                };
                            }
                            else
                            {
                                if($branch == 'ALL')
                                {
                                    $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc, l.tb_2 FROM transactions t JOIN ledgers l ON
                                    t.ledger_id=l.ledger_id WHERE t.date BETWEEN '$start_date' AND '$end_date' AND l.tb_1 = '$tb_1_id' AND l.tb_2 < 1
                                    GROUP BY t.ledger_id";
                                }
                                else
                                {
                                    $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc, l.tb_2 FROM transactions t JOIN ledgers l ON
                                    t.ledger_id=l.ledger_id WHERE t.branch_id='$branch' AND t.date BETWEEN '$start_date' AND 
                                    '$end_date' AND l.tb_2 = '$tb_2_id' AND l.tb_3 < 1 GROUP BY t.ledger_id";
                                };

                                $result_trans_ledger = mysqli_query($con,$sql_trans_ledger);
                                if (mysqli_num_rows($result_trans_ledger) > 0)
                                {
                                    $i = 0;
                                    while($row_trans_ledger = mysqli_fetch_array($result_trans_ledger))
                                    {
                                        $i++;
                                        $ledger_id = $row_trans_ledger['ledger_id'];
                                            if($branch == 'ALL')
                                            {
                                                $sql_ledger_ob = "SELECT SUM(amt_debit) AS total_debit, SUM(amt_credit) AS total_credit FROM 
                                                transactions WHERE ledger_id = '$ledger_id' AND date < '$start_date' AND 
                                                company_id = '$company_id'";
                                            }
                                            else
                                            {
                                                $sql_ledger_ob = "SELECT SUM(amt_debit) AS total_debit, SUM(amt_credit) AS total_credit FROM 
                                                transactions WHERE branch_id='$branch' AND ledger_id = '$ledger_id' AND date < '$start_date' AND 
                                                company_id = '$company_id'";
                                            };
                                            $result_ledger_ob = mysqli_query($con,$sql_ledger_ob);
                                            $row_ledger_ob = mysqli_fetch_array($result_ledger_ob);
                                            if ($row_trans_ledger['tb_2'] == 1 OR $row_trans_ledger['tb_2'] == 4)
                                            {
                                                $Opening_balance = $row_ledger_ob['total_debit'] - $row_ledger_ob['total_credit'];
                                            }
                                            else if ($row_trans_ledger['tb_2'] == 2 OR $row_trans_ledger['tb_2'] == 3)
                                            {
                                                $Opening_balance = $row_ledger_ob['total_credit'] - $row_ledger_ob['total_debit'];
                                            };

                                            $Opening_balance_f = number_format($Opening_balance, 2, '.', ',');
                                    
                                    
                                            if($branch == 'ALL')
                                            {
                                                $sql_ledger_trans = "SELECT SUM(amt_debit) AS total_trans_debit, SUM(amt_credit) AS 
                                                total_trans_credit FROM transactions WHERE ledger_id = '$ledger_id' AND date BETWEEN 
                                                '$start_date' AND '$end_date'";
                                            }
                                            else
                                            {
                                                $sql_ledger_trans = "SELECT SUM(amt_debit) AS total_trans_debit, SUM(amt_credit) AS 
                                                total_trans_credit FROM transactions WHERE branch_id='$branch' AND ledger_id = '$ledger_id' AND date BETWEEN 
                                                '$start_date' AND '$end_date'";
                                            };
                                            $result_ledger_trans = mysqli_query($con,$sql_ledger_trans);
                                            if (mysqli_num_rows($result_ledger_trans) > 0)
                                            {
                                                while($row_ledger_trans = mysqli_fetch_array($result_ledger_trans))
                                                {
                                                    if ($row_trans_ledger['tb_2'] == 1 OR $row_trans_ledger['tb_2'] == 4)
                                                    {
                                                        $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_debit'] - $row_ledger_trans['total_trans_credit'];
                                                        if($closing_balance > 0){
                                                            $amount_debit = $closing_balance;
                                                            $amount_credit = 0;
                                                        }else{
                                                            $amount_debit = 0;
                                                            $amount_credit = -$closing_balance;
                                                        };
                                                    }
                                                    else if ($row_trans_ledger['tb_2'] == 2 OR $row_trans_ledger['tb_2'] == 3)
                                                    {
                                                        $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_credit'] - $row_ledger_trans['total_trans_debit'];
                                                        if($closing_balance > 0){
                                                            $amount_debit = 0;
                                                            $amount_credit = $closing_balance;
                                                        }else{
                                                            $amount_debit = -$closing_balance;
                                                            $amount_credit = 0;
                                                        };
                                                    };

                                                    $grand_total_debit = $grand_total_debit + $amount_debit;
                                                    $grand_total_credit = $grand_total_credit + $amount_credit;
                                                    echo '<tr>
                                                        <td colspan="5"></td>
                                                        <td>'.$row_trans_ledger['ledger_desc'].'</td>';
                                                        
                                                            $amount_debit_f = number_format($amount_debit, 2, '.', ',');
                                                        
                                                        echo '<td class="amt-td">'.$amount_debit_f,'</td>';
                                                        
                                                            $amount_credit_f = number_format($amount_credit, 2, '.', ',');
                                                    
                                                        echo '<td class="amt-td">'.$amount_credit_f.'</td>
                                                    </tr>';
                                                        
                                                }
                                            };
                                    };
                                };
                            };
                        }

                        $grand_total_debit_f = number_format($grand_total_debit, 2, '.', ',');
                        $grand_total_credit_f = number_format($grand_total_credit, 2, '.', ',');
                        echo '<tr style="color:black">
                            <td colspan="6"><strong>GRAND TOTAL</strong></td>
                            <td class="amt-td"><strong>'.$grand_total_debit_f.'</strong></td>
                            <td class="amt-td"><strong>'.$grand_total_credit_f.'</strong></td>
                        </tr>';
                    };
                echo '</tbody>
            </table>';
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>