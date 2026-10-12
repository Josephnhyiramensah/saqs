<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
?>
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
        if(isset($_SESSION['loan_report_start_date']))
        {           
            $start_date = $_SESSION['loan_report_start_date'];
            $end_date = $_SESSION['loan_report_end_date'];

        $company_id = $_SESSION['company_id'];

        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        if (mysqli_num_rows($result_company) > 0)
        {
            $row_company = mysqli_fetch_array($result_company);
            $company_name = $row_company['trading_name'];
        }
        else
        {
            $company_name = 'No Company';
        };
    
    echo '.<table class="table table-hover table-bordered table-sm" id="loan_report_list_table" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class = "action-td" colspan="10"><H3>'.$company_name.'</H3></th>
                </tr>
                <tr>
                    <th class = "action-td" colspan="10"><H6>ALL STAFF LOAN REPORT FROM '.$start_date.' TO '.$end_date.'</H6></th>
                </tr>
                <tr style="background-color:#E4DCCF; color:black">
                    <th class="action-td">S/NO</th>
                    <th class="action-td">NAME</th>
                    <th class="action-td">OPENING BALANCE</th>
                    <th class="action-td">DISBURSEMENT</th>
                    <th class="action-td">REPAYMENT</th>
                    <th class="action-td">CLOSING BALANCE</th>
                </tr>
            </thead>
                <tbody class="pv-table-body" id="loan_report_list_table_body">';
                                 

        $i=0;
        $total_opening_balance = 0;
        $total_disbursement = 0;
        $total_repayment = 0;
        $total_closing_balance = 0;

        $sql_employee = "SELECT * FROM payroll_employee";
        $result_employee = mysqli_query($con,$sql_employee);
        if(mysqli_num_rows($result_employee) > 0)
        {
            while($row_employee = mysqli_fetch_array($result_employee))
            {
                $employee_name = $row_employee['first_name'].' '.$row_employee['last_name'];
                $employee_id = $row_employee['employee_id'];

                $query = "SELECT employee_id, SUM(disbursement) AS disbursement, SUM(repayment) AS repayment, SUM(opd) AS opd, SUM(opp) AS opp FROM
                (SELECT employee_id, 0 AS disbursement, 0 AS repayment, principal AS opd, 0 AS opp FROM payroll_loan_disburse 
                WHERE employee_id = '$employee_id' AND date < '$start_date'
                UNION ALL SELECT employee_id, 0 AS disbursement, 0 AS repayment, 0 AS opd, loan_repayment AS opp FROM payroll_pay_slip 
                WHERE employee_id = '$employee_id' AND date < '$start_date'
                UNION ALL SELECT employee_id, principal AS disbursement, 0 AS repayment, 0 AS opd, 0 AS opp FROM payroll_loan_disburse 
                WHERE employee_id = '$employee_id' AND date BETWEEN '$start_date' AND '$end_date'
                UNION ALL SELECT employee_id, 0 AS disbursement, loan_repayment AS repayment, 0 AS opd, 0 AS opp FROM payroll_pay_slip 
                WHERE employee_id = '$employee_id' AND date BETWEEN '$start_date' AND '$end_date') AS c GROUP BY employee_id";

                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $row = mysqli_fetch_assoc($query_run);
                    $opening_balance = $row['opd'] - $row['opp'];
                    $disbursement = $row['disbursement'];
                    $repayment = $row['repayment'];
                    $closing_balance = $opening_balance + $disbursement - $repayment;
                    $total_disbursement = $total_disbursement + $disbursement;
                    $total_repayment = $total_repayment + $repayment;
                    $total_opening_balance = $total_opening_balance + $opening_balance;
                    $total_closing_balance = $total_closing_balance + $closing_balance;
                    
                    $opening_balance_f = number_format($opening_balance, 2, '.', ',');
                    $disbursement_f = number_format($disbursement, 2, '.', ',');
                    $repayment_f = number_format($repayment, 2, '.', ',');
                    $closing_balance_f = number_format($closing_balance, 2, '.', ',');
                    if($opening_balance > 0 || $disbursement > 0 || $repayment > 0 || $closing_balance > 0)
                    {
                        $i++;
                        echo '<tr>
                            <td class="action-td">'.$i.'</td>
                            <td><a id="loan_report_view_employee_detail" 
                                href="#"
                                data-employee_id="'.$row['employee_id'].'"
                                data-start_date="'.$start_date.'"
                                data-end_date="'.$end_date.'">
                                '.$employee_name.'
                                </a>
                            </td>
                            <td class="amt-td">'.$opening_balance_f.'</td>
                            <td class="amt-td">'.$disbursement_f.'</td>
                            <td class="amt-td">'.$repayment_f.'</td>
                            <td class="amt-td">'.$closing_balance_f.'</td>
                        </tr>';
                    };
                };
            };
            $total_opening_balance_f = number_format($total_opening_balance, 2, '.', ',');
            $total_disbursement_f = number_format($total_disbursement, 2, '.', ',');
            $total_repayment_f = number_format($total_repayment, 2, '.', ',');
            $total_closing_balance_f = number_format($total_closing_balance, 2, '.', ',');
            echo '<tr>
                <td class="action-td" colspan = "2"><strong>GRAND TOTAL</strong></td>
                <td class="amt-td"><strong>'.$total_opening_balance_f.'</strong></td>
                <td class="amt-td"><strong>'.$total_disbursement_f.'</strong></td>
                <td class="amt-td"><strong>'.$total_repayment_f.'</strong></td>
                <td class="amt-td"><strong>'.$total_closing_balance_f.'</strong></td>
            </tr>';
        };
        echo '</tbody>
    </table>';
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>