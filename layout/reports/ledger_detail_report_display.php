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
        if(isset($_SESSION['ledger_detail_report_start_date']))
        {           
            $company_id = $_SESSION['ledger_detail_report_company_id'];
            $user_id = $_SESSION['ledger_detail_report_user_id'];
            $user_super_id = $_SESSION['ledger_detail_report_user_super_id'];
            $start_date = $_SESSION['ledger_detail_report_start_date'];
            $end_date = $_SESSION['ledger_detail_report_end_date'];
            $branch = $_SESSION['ledger_detail_report_branch'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
            <table class="table table-hover table-bordered table-sm" id="ledger_detail_report_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="8"><H2><?php echo $row_company['trading_name'];?></H2></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="8"><H6>LEDGER DETAIL REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                    </tr>
                </thead>
                <tbody class="pv-table-body" id="ledger_detail_report_list_table_body">
            <?php
            if($branch == 'ALL')
            {
                $sql_trans_ledger = "SELECT ledger_id FROM transactions WHERE date BETWEEN '$start_date' AND 
                '$end_date' GROUP BY ledger_id";
            }
            else
            {
                $sql_trans_ledger = "SELECT ledger_id FROM transactions WHERE date BETWEEN '$start_date' AND 
                '$end_date' AND branch_id = '$branch' GROUP BY ledger_id";
            };
            $result_trans_ledger = mysqli_query($con,$sql_trans_ledger);
            if (mysqli_num_rows($result_trans_ledger) > 0)
            {
                while($row_trans_ledger = mysqli_fetch_array($result_trans_ledger))
                {
                    $ledger_id = $row_trans_ledger['ledger_id'];

                    $sql_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
                    $result_ledger = mysqli_query($con,$sql_ledger);
                    $row_ledger = mysqli_fetch_array($result_ledger);
            ?>
                    <tr style="background-color:#E4DCCF; color:black">
                        <th colspan="8"><strong><?php echo $row_ledger['ledger_desc'];?></strong></th>
                    </tr>
                    <?php
                        if($branch == 'ALL')
                        {
                            $sql_ledger_ob = "SELECT SUM(amt_debit) AS total_debit, SUM(amt_credit) AS total_credit FROM 
                            transactions WHERE ledger_id = '$ledger_id' AND date < '$start_date'";
                        }
                        else
                        {
                            $sql_ledger_ob = "SELECT SUM(amt_debit) AS total_debit, SUM(amt_credit) AS total_credit FROM 
                            transactions WHERE ledger_id = '$ledger_id' AND date < '$start_date' AND branch_id ='$branch'";
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
                    ?>
                    <tr>
                        <th class="amt-td" colspan="6">OPENING BALANCE</th>
                        <th class="action-td"><?php echo $Opening_balance_f;?></th>
                        <th class="action-td"></th>
                    </tr>
                    <tr>
                        <th class="action-td" width="5%">S/NO</th>
                        <th class="action-td" width="10%">DATE</th>
                        <th class="action-td" width="15%">PARTICULARS</th>
                        <th class="action-td" width="10%">OPENING</th>
                        <th class="action-td" width="10%">DEBIT</th>
                        <th class="action-td" width="10%">CREDIT</th>
                        <th class="action-td" width="10%">CLOSING</th>
                        <th class="action-td" width="30%">NARRATION</th>
                    </tr>
                
                    <?php
                        if($branch == 'ALL')
                        {
                            $sql_ledger_trans = "SELECT * FROM transactions WHERE ledger_id = '$ledger_id' AND date BETWEEN 
                            '$start_date' AND '$end_date'";
                        }
                        else
                        {
                            $sql_ledger_trans = "SELECT * FROM transactions WHERE ledger_id = '$ledger_id' AND date BETWEEN 
                            '$start_date' AND '$end_date' AND branch_id = '$branch'";
                        };
                            
                        $result_ledger_trans = mysqli_query($con,$sql_ledger_trans);
                        if (mysqli_num_rows($result_ledger_trans) > 0)
                        {
                            $i = 0;
                            while($row_ledger_trans = mysqli_fetch_array($result_ledger_trans))
                            {
                                $i = ++$i;
                                $patient_id = $row_ledger_trans['patient_id'];
                                $sql_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
                                $result_patient = mysqli_query($con,$sql_patient);
                                $row_patient = mysqli_fetch_array($result_patient);
                                if(isset($row_patient)){$narration = $row_patient['firstName'].' '.$row_patient['lastName'].':- '.$row_ledger_trans['narration'];}else{$narration =  $row_ledger_trans['narration'];};
                    ?>
                                <tr>
                                    <td class="action-td"><?php echo $i;?></td>
                                    <td class="action-td"><?php echo $row_ledger_trans['date'];?></td>
                                    <?php
                                        $ledger_id_contra = $row_ledger_trans['ledger_id_contra'];
                                        $sql_ledger_contra = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id_contra'";
                                        $result_ledger_contra = mysqli_query($con,$sql_ledger_contra);
                                        $row_ledger_contra = mysqli_fetch_array($result_ledger_contra);
                                    ?>
                                    <td ><?php echo $row_ledger_contra['ledger_desc'];?></td>
                                    <?php
                                        $Opening_balance_running = $Opening_balance;
                                        $Opening_balance_running_f = number_format($Opening_balance_running, 2, '.', ',');
                                    ?>
                                    <td class="amt-td"><?php echo $Opening_balance_running_f;?></td>
                                    <?php
                                        $amount_debit = $row_ledger_trans['amt_debit'];
                                        $amount_debit_f = number_format($amount_debit, 2, '.', ',');
                                    ?>
                                    <td class="amt-td"><?php echo $amount_debit_f;?></td>
                                    <?php
                                        $amount_credit = $row_ledger_trans['amt_credit'];
                                        $amount_credit_f = number_format($amount_credit, 2, '.', ',');
                                    ?>
                                    <td class="amt-td"><?php echo $amount_credit_f;?></td>
                                    <?php
                                        if ($row_ledger['tb_2'] == 1 OR $row_ledger['tb_2'] == 4)
                                        {
                                            $closing_balance = $Opening_balance + $row_ledger_trans['amt_debit'] - $row_ledger_trans['amt_credit'];
                                        }
                                        else if ($row_ledger['tb_2'] == 2 OR $row_ledger['tb_2'] == 3)
                                        {
                                            $closing_balance = $Opening_balance + $row_ledger_trans['amt_credit'] - $row_ledger_trans['amt_debit'];
                                        };

                                        $closing_balance_f = number_format($closing_balance, 2, '.', ',');
                                    ?>
                                    <td class="amt-td"><?php echo $closing_balance_f;?></td>
                                    <td><?php echo $narration;?></td>
                                </tr>
                    <?php
                                if ($row_ledger['tb_2'] == 1 OR $row_ledger['tb_2'] == 4)
                                {
                                    $Opening_balance = $Opening_balance + $row_ledger_trans['amt_debit'] - $row_ledger_trans['amt_credit'];
                                }
                                else if ($row_ledger['tb_2'] == 2 OR $row_ledger['tb_2'] == 3)
                                {
                                    $Opening_balance = $Opening_balance + $row_ledger_trans['amt_credit'] - $row_ledger_trans['amt_debit'];
                                };
                            }
                        };
                    ?>
                    <tr>
                        <th class="amt-td" colspan="6">CLOSING BALANCE</th>
                        <th class="action-td"><?php echo $closing_balance_f;?></th>
                        <th class="action-td"></th>
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