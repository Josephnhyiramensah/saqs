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
        if(isset($_SESSION['ledger_summary_report_start_date']))
        {           
            $company_id = $_SESSION['ledger_summary_report_company_id'];
            $user_id = $_SESSION['ledger_summary_report_user_id'];
            $user_super_id = $_SESSION['ledger_summary_report_user_super_id'];
            $start_date = $_SESSION['ledger_summary_report_start_date'];
            $end_date = $_SESSION['ledger_summary_report_end_date'];
            $branch = $_SESSION['ledger_summary_report_branch'];
            $current_year = date('Y');
            $beginning_of_the_year = date($current_year.'-01-01');

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    
            echo '<table class="table table-hover table-bordered table-sm" id="ledger_summary_report_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="11"><H2>'.$row_company['trading_name'].'</H2></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="11"><H6>LEDGER SUMMARY REPORT FROM '.$start_date.' TO '.$end_date.'</H6></th>
                    </tr>
                    <tr>
                        <th class="action-td">S/NO</th>
                        <th class="action-td">T1</th>
                        <th class="action-td">T2</th>
                        <th class="action-td">T3</th>
                        <th class="action-td">T4</th>
                        <th class="action-td">T5</th>
                        <th class="action-td">LEDGER</th>
                        <th class="action-td">OPENING</th>
                        <th class="action-td">DEBIT</th>
                        <th class="action-td">CREDIT</th>
                        <th class="action-td">CLOSING</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body" id="ledger_summary_report_list_table_body">';
            
                    $tb_total_debit = 0;
                    $tb_total_credit = 0;
                    $sql_tb_1 = "SELECT id, tb_1_desc FROM trial_bal_group_1 ORDER BY tb_1_desc ASC";
                    $result_tb_1 = mysqli_query($con,$sql_tb_1);
                    if (mysqli_num_rows($result_tb_1) > 0)
                    {
                        while($row_tb_1 = mysqli_fetch_array($result_tb_1))
                        {
                            echo '<tr>
                                <td colspan="11">'.$row_tb_1['tb_1_desc'].'</td>
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
                                    echo '<tr>
                                        <td></td>
                                        <td colspan="10">'.$tb_2_desc.'</td>
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
                                                <td colspan="9">'.$tb_3_desc.'</td>
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
                                                        <td colspan="8">'.$tb_4_desc.'</td>
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
                                                                <td colspan="7">'.$tb_5_desc.'</td>
                                                            </tr>';
                                                            $tb_5_id = $row_tb_5['id'];

                                                            if($branch == 'ALL')
                                                            {
                                                                $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc, l.tb_2 FROM transactions t JOIN ledgers l ON
                                                                t.ledger_id=l.ledger_id WHERE t.date BETWEEN '$start_date' AND '$end_date' AND l.tb_5 = '$tb_5_id'
                                                                GROUP BY t.ledger_id";
                                                            }
                                                            else
                                                            {
                                                                $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc, l.tb_2 FROM transactions t JOIN ledgers l ON
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

                                                                    $sql_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
                                                                    $result_ledger = mysqli_query($con,$sql_ledger);
                                                                    if(!empty($result_ledger) && mysqli_num_rows($result_ledger) > 0)
                                                                    {
                                                                        $row_ledger = mysqli_fetch_array($result_ledger);
                                                                        if($branch == 'ALL')
                                                                        {
                                                                            if($row_ledger['tb_2'] < 3)
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
                                                                            if($row_ledger['tb_2'] < 3)
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
                                                                        if ($row_ledger['tb_2'] == 1 OR $row_ledger['tb_2'] == 4)
                                                                        {
                                                                            $Opening_balance = $row_ledger_ob['total_debit'] - $row_ledger_ob['total_credit'];
                                                                        }
                                                                        else if ($row_ledger['tb_2'] == 2 OR $row_ledger['tb_2'] == 3)
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
                                                                                $tb_2_total_debit = $tb_2_total_debit + $row_ledger_trans['total_trans_debit'];
                                                                                $tb_2_total_credit = $tb_2_total_credit + $row_ledger_trans['total_trans_credit'];
                                                                                $tb_3_total_debit = $tb_3_total_debit + $row_ledger_trans['total_trans_debit'];
                                                                                $tb_3_total_credit = $tb_3_total_credit + $row_ledger_trans['total_trans_credit'];
                                                                                $tb_4_total_debit = $tb_4_total_debit + $row_ledger_trans['total_trans_debit'];
                                                                                $tb_4_total_credit = $tb_4_total_credit + $row_ledger_trans['total_trans_credit'];
                                                                                $tb_5_total_debit = $tb_5_total_debit + $row_ledger_trans['total_trans_debit'];
                                                                                $tb_5_total_credit = $tb_5_total_credit + $row_ledger_trans['total_trans_credit'];
                                                                                echo '<tr>
                                                                                    <td colspan="6"></td>
                                                                                    <td>'.$row_ledger['ledger_desc'].'</td>';
                                                                                    
                                                                                        $Opening_balance_running = $Opening_balance;
                                                                                        $Opening_balance_running_f = number_format($Opening_balance_running, 2, '.', ',');
                                                                                
                                                                                    echo '<td class="amt-td">'.$Opening_balance_running_f.'</td>';
                                                                                    
                                                                                        $amount_debit = $row_ledger_trans['total_trans_debit'];
                                                                                        $amount_debit_f = number_format($amount_debit, 2, '.', ',');
                                                                                    
                                                                                    echo '<td class="amt-td">'.$amount_debit_f,'</td>';
                                                                                    
                                                                                        $amount_credit = $row_ledger_trans['total_trans_credit'];
                                                                                        $amount_credit_f = number_format($amount_credit, 2, '.', ',');
                                                                                
                                                                                    echo '<td class="amt-td">'.$amount_credit_f.'</td>';
                                                                                    
                                                                                        if ($row_ledger['tb_2'] == 1 OR $row_ledger['tb_2'] == 4)
                                                                                        {
                                                                                            $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_debit'] - $row_ledger_trans['total_trans_credit'];
                                                                                        }
                                                                                        else if ($row_ledger['tb_2'] == 2 OR $row_ledger['tb_2'] == 3)
                                                                                        {
                                                                                            $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_credit'] - $row_ledger_trans['total_trans_debit'];
                                                                                        };

                                                                                        $closing_balance_f = number_format($closing_balance, 2, '.', ',');
                                                                                    
                                                                                    echo '<td class="amt-td">'.$closing_balance_f.'</td>
                                                                                </tr>';
                                                                                    
                                                                            }
                                                                        };
                                                                    }
                                                                };
                                                            };
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if($branch == 'ALL')
                                                        {
                                                            $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc FROM transactions t JOIN ledgers l ON
                                                            t.ledger_id=l.ledger_id WHERE t.date BETWEEN '$start_date' AND '$end_date' AND l.tb_4 = '$tb_4_id' AND l.tb_5 < 1
                                                            GROUP BY t.ledger_id";
                                                        }
                                                        else
                                                        {
                                                            $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc FROM transactions t JOIN ledgers l ON
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

                                                                $sql_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
                                                                $result_ledger = mysqli_query($con,$sql_ledger);
                                                                if(!empty($result_ledger) && mysqli_num_rows($result_ledger) > 0)
                                                                {
                                                                    $row_ledger = mysqli_fetch_array($result_ledger);
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
                                                                    if ($row_ledger['tb_2'] == 1 OR $row_ledger['tb_2'] == 4)
                                                                    {
                                                                        $Opening_balance = $row_ledger_ob['total_debit'] - $row_ledger_ob['total_credit'];
                                                                    }
                                                                    else if ($row_ledger['tb_2'] == 2 OR $row_ledger['tb_2'] == 3)
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
                                                                            $tb_2_total_debit = $tb_2_total_debit + $row_ledger_trans['total_trans_debit'];
                                                                            $tb_2_total_credit = $tb_2_total_credit + $row_ledger_trans['total_trans_credit'];
                                                                            $tb_3_total_debit = $tb_3_total_debit + $row_ledger_trans['total_trans_debit'];
                                                                            $tb_3_total_credit = $tb_3_total_credit + $row_ledger_trans['total_trans_credit'];
                                                                            $tb_4_total_debit = $tb_4_total_debit + $row_ledger_trans['total_trans_debit'];
                                                                            $tb_4_total_credit = $tb_4_total_credit + $row_ledger_trans['total_trans_credit'];
                                                                            $tb_5_total_debit = $tb_5_total_debit + $row_ledger_trans['total_trans_debit'];
                                                                            $tb_5_total_credit = $tb_5_total_credit + $row_ledger_trans['total_trans_credit'];
                                                                            echo '<tr>
                                                                                <td colspan="6"></td>
                                                                                <td>'.$row_ledger['ledger_desc'].'</td>';
                                                                                
                                                                                    $Opening_balance_running = $Opening_balance;
                                                                                    $Opening_balance_running_f = number_format($Opening_balance_running, 2, '.', ',');
                                                                            
                                                                                echo '<td class="amt-td">'.$Opening_balance_running_f.'</td>';
                                                                                
                                                                                    $amount_debit = $row_ledger_trans['total_trans_debit'];
                                                                                    $amount_debit_f = number_format($amount_debit, 2, '.', ',');
                                                                                
                                                                                echo '<td class="amt-td">'.$amount_debit_f,'</td>';
                                                                                
                                                                                    $amount_credit = $row_ledger_trans['total_trans_credit'];
                                                                                    $amount_credit_f = number_format($amount_credit, 2, '.', ',');
                                                                            
                                                                                echo '<td class="amt-td">'.$amount_credit_f.'</td>';
                                                                                
                                                                                    if ($row_ledger['tb_2'] == 1 OR $row_ledger['tb_2'] == 4)
                                                                                    {
                                                                                        $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_debit'] - $row_ledger_trans['total_trans_credit'];
                                                                                    }
                                                                                    else if ($row_ledger['tb_2'] == 2 OR $row_ledger['tb_2'] == 3)
                                                                                    {
                                                                                        $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_credit'] - $row_ledger_trans['total_trans_debit'];
                                                                                    };

                                                                                    $closing_balance_f = number_format($closing_balance, 2, '.', ',');
                                                                                
                                                                                echo '<td class="amt-td">'.$closing_balance_f.'</td>
                                                                            </tr>';
                                                                                
                                                                        }
                                                                    };
                                                                }
                                                            };
                                                        };
                                                    };

                                                    $tb_5_total_debit_f = number_format($tb_5_total_debit, 2, '.', ',');
                                                    $tb_5_total_credit_f = number_format($tb_5_total_credit, 2, '.', ',');
                                                    echo '<tr>
                                                        <td colspan="4"></td>
                                                        <td colspan="3">TOTAL '.$tb_5_desc.'</td>';
                                                        echo '<td class="amt-td"></td>';
                                                        echo '<td class="amt-td">'.$tb_5_total_debit_f.'</td>';
                                                        echo '<td class="amt-td">'.$tb_5_total_credit_f.'</td>';
                                                        echo '<td class="amt-td"></td>
                                                    </tr>';
                                                }
                                            }
                                            else
                                            {
                                                if($branch == 'ALL')
                                                {
                                                    $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc FROM transactions t JOIN ledgers l ON
                                                    t.ledger_id=l.ledger_id WHERE t.date BETWEEN '$start_date' AND '$end_date' AND l.tb_3 = '$tb_3_id' AND l.tb_4 < 1
                                                    GROUP BY t.ledger_id";
                                                }
                                                else
                                                {
                                                    $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc FROM transactions t JOIN ledgers l ON
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

                                                        $sql_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
                                                        $result_ledger = mysqli_query($con,$sql_ledger);
                                                        if(!empty($result_ledger) && mysqli_num_rows($result_ledger) > 0)
                                                        {
                                                            $row_ledger = mysqli_fetch_array($result_ledger);
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
                                                            if ($row_ledger['tb_2'] == 1 OR $row_ledger['tb_2'] == 4)
                                                            {
                                                                $Opening_balance = $row_ledger_ob['total_debit'] - $row_ledger_ob['total_credit'];
                                                            }
                                                            else if ($row_ledger['tb_2'] == 2 OR $row_ledger['tb_2'] == 3)
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
                                                                    $tb_2_total_debit = $tb_2_total_debit + $row_ledger_trans['total_trans_debit'];
                                                                    $tb_2_total_credit = $tb_2_total_credit + $row_ledger_trans['total_trans_credit'];
                                                                    $tb_3_total_debit = $tb_3_total_debit + $row_ledger_trans['total_trans_debit'];
                                                                    $tb_3_total_credit = $tb_3_total_credit + $row_ledger_trans['total_trans_credit'];
                                                                    $tb_4_total_debit = $tb_4_total_debit + $row_ledger_trans['total_trans_debit'];
                                                                    $tb_4_total_credit = $tb_4_total_credit + $row_ledger_trans['total_trans_credit'];
                                                                    $tb_5_total_debit = $tb_5_total_debit + $row_ledger_trans['total_trans_debit'];
                                                                    $tb_5_total_credit = $tb_5_total_credit + $row_ledger_trans['total_trans_credit'];
                                                                    echo '<tr>
                                                                        <td colspan="6"></td>
                                                                        <td>'.$row_ledger['ledger_desc'].'</td>';
                                                                        
                                                                            $Opening_balance_running = $Opening_balance;
                                                                            $Opening_balance_running_f = number_format($Opening_balance_running, 2, '.', ',');
                                                                    
                                                                        echo '<td class="amt-td">'.$Opening_balance_running_f.'</td>';
                                                                        
                                                                            $amount_debit = $row_ledger_trans['total_trans_debit'];
                                                                            $amount_debit_f = number_format($amount_debit, 2, '.', ',');
                                                                        
                                                                        echo '<td class="amt-td">'.$amount_debit_f,'</td>';
                                                                        
                                                                            $amount_credit = $row_ledger_trans['total_trans_credit'];
                                                                            $amount_credit_f = number_format($amount_credit, 2, '.', ',');
                                                                    
                                                                        echo '<td class="amt-td">'.$amount_credit_f.'</td>';
                                                                        
                                                                            if ($row_ledger['tb_2'] == 1 OR $row_ledger['tb_2'] == 4)
                                                                            {
                                                                                $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_debit'] - $row_ledger_trans['total_trans_credit'];
                                                                            }
                                                                            else if ($row_ledger['tb_2'] == 2 OR $row_ledger['tb_2'] == 3)
                                                                            {
                                                                                $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_credit'] - $row_ledger_trans['total_trans_debit'];
                                                                            };

                                                                            $closing_balance_f = number_format($closing_balance, 2, '.', ',');
                                                                        
                                                                        echo '<td class="amt-td">'.$closing_balance_f.'</td>
                                                                    </tr>';
                                                                        
                                                                }
                                                            };
                                                        }
                                                    };
                                                };
                                            };

                                            $tb_4_total_debit_f = number_format($tb_4_total_debit, 2, '.', ',');
                                            $tb_4_total_credit_f = number_format($tb_4_total_credit, 2, '.', ',');
                                            echo '<tr>
                                                <td colspan="3"></td>
                                                <td colspan="4">TOTAL '.$tb_4_desc.'</td>';
                                                echo '<td class="amt-td"></td>';
                                                echo '<td class="amt-td">'.$tb_4_total_debit_f.'</td>';
                                                echo '<td class="amt-td">'.$tb_4_total_credit_f.'</td>';
                                                echo '<td class="amt-td"></td>
                                            </tr>';
                                        }
                                    };

                                    $tb_3_total_debit_f = number_format($tb_3_total_debit, 2, '.', ',');
                                    $tb_3_total_credit_f = number_format($tb_3_total_credit, 2, '.', ',');
                                    echo '<tr>
                                        <td colspan="2"></td>
                                        <td colspan="5">TOTAL '.$tb_3_desc.'</td>';
                                        echo '<td class="amt-td"></td>';
                                        echo '<td class="amt-td">'.$tb_3_total_debit_f.'</td>';
                                        echo '<td class="amt-td">'.$tb_3_total_credit_f.'</td>';
                                        echo '<td class="amt-td"></td>
                                    </tr>';
                                }
                            }
                            else
                            {
                                if($branch == 'ALL')
                                {
                                    $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc FROM transactions t JOIN ledgers l ON
                                    t.ledger_id=l.ledger_id WHERE t.date BETWEEN '$start_date' AND '$end_date' AND l.tb_1 = '$tb_1_id' AND l.tb_2 < 1
                                    GROUP BY t.ledger_id";
                                }
                                else
                                {
                                    $sql_trans_ledger = "SELECT t.ledger_id, l.ledger_desc FROM transactions t JOIN ledgers l ON
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

                                        $sql_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
                                        $result_ledger = mysqli_query($con,$sql_ledger);
                                        if(!empty($result_ledger) && mysqli_num_rows($result_ledger) > 0)
                                        {
                                            $row_ledger = mysqli_fetch_array($result_ledger);
                                    
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
                                            if ($row_ledger['tb_2'] == 1 OR $row_ledger['tb_2'] == 4)
                                            {
                                                $Opening_balance = $row_ledger_ob['total_debit'] - $row_ledger_ob['total_credit'];
                                            }
                                            else if ($row_ledger['tb_2'] == 2 OR $row_ledger['tb_2'] == 3)
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
                                                    $tb_total_debit = $tb_total_debit + $row_ledger_trans['total_trans_debit'];
                                                    $tb_total_credit = $tb_total_credit + $row_ledger_trans['total_trans_credit'];
                                                    $tb_2_total_debit = $tb_2_total_debit + $row_ledger_trans['total_trans_debit'];
                                                    $tb_2_total_credit = $tb_2_total_credit + $row_ledger_trans['total_trans_credit'];
                                                    $tb_3_total_debit = $tb_3_total_debit + $row_ledger_trans['total_trans_debit'];
                                                    $tb_3_total_credit = $tb_3_total_credit + $row_ledger_trans['total_trans_credit'];
                                                    $tb_4_total_debit = $tb_4_total_debit + $row_ledger_trans['total_trans_debit'];
                                                    $tb_4_total_credit = $tb_4_total_credit + $row_ledger_trans['total_trans_credit'];
                                                    $tb_5_total_debit = $tb_5_total_debit + $row_ledger_trans['total_trans_debit'];
                                                    $tb_5_total_credit = $tb_5_total_credit + $row_ledger_trans['total_trans_credit'];
                                                    echo '<tr>
                                                        <td colspan="5"></td>
                                                        <td>'.$row_ledger['ledger_desc'].'</td>';
                                                        
                                                            $Opening_balance_running = $Opening_balance;
                                                            $Opening_balance_running_f = number_format($Opening_balance_running, 2, '.', ',');
                                                    
                                                        echo '<td class="amt-td">'.$Opening_balance_running_f.'</td>';
                                                        
                                                            $amount_debit = $row_ledger_trans['total_trans_debit'];
                                                            $amount_debit_f = number_format($amount_debit, 2, '.', ',');
                                                        
                                                        echo '<td class="amt-td">'.$amount_debit_f,'</td>';
                                                        
                                                            $amount_credit = $row_ledger_trans['total_trans_credit'];
                                                            $amount_credit_f = number_format($amount_credit, 2, '.', ',');
                                                    
                                                        echo '<td class="amt-td">'.$amount_credit_f.'</td>';
                                                        
                                                            if ($row_ledger['tb_2'] == 1 OR $row_ledger['tb_2'] == 4)
                                                            {
                                                                $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_debit'] - $row_ledger_trans['total_trans_credit'];
                                                            }
                                                            else if ($row_ledger['tb_2'] == 2 OR $row_ledger['tb_2'] == 3)
                                                            {
                                                                $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_credit'] - $row_ledger_trans['total_trans_debit'];
                                                            };

                                                            $closing_balance_f = number_format($closing_balance, 2, '.', ',');
                                                        
                                                        echo '<td class="amt-td">'.$closing_balance_f.'</td>
                                                    </tr>';
                                                        
                                                }
                                            };
                                        }
                                    };
                                };
                            };
                        }

                        $tb_total_debit_f = number_format($tb_total_debit, 2, '.', ',');
                        $tb_total_credit_f = number_format($tb_total_credit, 2, '.', ',');
                        echo '<tr>
                            <td colspan="7">GRAND TOTAL</td>';
                            echo '<td class="amt-td"></td>';
                            echo '<td class="amt-td">'.$tb_total_debit_f.'</td>';
                            echo '<td class="amt-td">'.$tb_total_credit_f.'</td>';
                            echo '<td class="amt-td"></td>
                        </tr>';
                    };

                    /*if($branch == 'ALL')
                    {
                        $sql_trans_ledger = "SELECT ledger_id FROM transactions WHERE date BETWEEN '$start_date' AND 
                        '$end_date' GROUP BY ledger_id";
                    }
                    else
                    {
                        $sql_trans_ledger = "SELECT ledger_id FROM transactions WHERE branch_id='$branch' AND date BETWEEN '$start_date' AND 
                        '$end_date' GROUP BY ledger_id";
                    };

                    $result_trans_ledger = mysqli_query($con,$sql_trans_ledger);
                    if (mysqli_num_rows($result_trans_ledger) > 0)
                    {
                        $i = 0;
                        while($row_trans_ledger = mysqli_fetch_array($result_trans_ledger))
                        {
                            $i++;
                            $ledger_id = $row_trans_ledger['ledger_id'];

                            $sql_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
                            $result_ledger = mysqli_query($con,$sql_ledger);
                            if(!empty($result_ledger) && mysqli_num_rows($result_ledger) > 0)
                            {

                                $row_ledger = mysqli_fetch_array($result_ledger);
                        
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
                                if ($row_ledger['tb_2'] == 1 OR $row_ledger['tb_2'] == 4)
                                {
                                    $Opening_balance = $row_ledger_ob['total_debit'] - $row_ledger_ob['total_credit'];
                                }
                                else if ($row_ledger['tb_2'] == 2 OR $row_ledger['tb_2'] == 3)
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
                                        ?>
                                        <tr>
                                            <td class="action-td"><?php echo $i;?></td>
                                            <td colspan="5"></td>
                                            <td><?php echo $row_ledger['ledger_desc'];?></td>
                                            <?php
                                                $Opening_balance_running = $Opening_balance;
                                                $Opening_balance_running_f = number_format($Opening_balance_running, 2, '.', ',');
                                            ?>
                                            <td class="amt-td"><?php echo $Opening_balance_running_f;?></td>
                                            <?php
                                                $amount_debit = $row_ledger_trans['total_trans_debit'];
                                                $amount_debit_f = number_format($amount_debit, 2, '.', ',');
                                            ?>
                                            <td class="amt-td"><?php echo $amount_debit_f;?></td>
                                            <?php
                                                $amount_credit = $row_ledger_trans['total_trans_credit'];
                                                $amount_credit_f = number_format($amount_credit, 2, '.', ',');
                                            ?>
                                            <td class="amt-td"><?php echo $amount_credit_f;?></td>
                                            <?php
                                                if ($row_ledger['tb_2'] == 1 OR $row_ledger['tb_2'] == 4)
                                                {
                                                    $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_debit'] - $row_ledger_trans['total_trans_credit'];
                                                }
                                                else if ($row_ledger['tb_2'] == 2 OR $row_ledger['tb_2'] == 3)
                                                {
                                                    $closing_balance = $Opening_balance + $row_ledger_trans['total_trans_credit'] - $row_ledger_trans['total_trans_debit'];
                                                };

                                                $closing_balance_f = number_format($closing_balance, 2, '.', ',');
                                            ?>
                                            <td class="amt-td"><?php echo $closing_balance_f;?></td>
                                        </tr>
                                        <?php
                                            
                                    }
                                };
                            }
                        };
                    };*/

                echo '</tbody>
            </table>';
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>