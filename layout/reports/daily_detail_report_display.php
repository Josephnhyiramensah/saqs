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
        if(isset($_SESSION['daily_detail_report_start_date']))
        {           
            $company_id = $_SESSION['company_id'];
            $patient_id = $_SESSION['daily_detail_report_patient_id'];
            $patient_name = $_SESSION['daily_detail_report_patient_name'];
            $balance_type = $_SESSION['daily_detail_report_bal_type'];
            $sponsor = $_SESSION['daily_detail_report_sponsor'];
            $start_date = $_SESSION['daily_detail_report_start_date'];
            $end_date = $_SESSION['daily_detail_report_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
            <table class="table table-hover table-bordered table-sm" id="attend_summary_report_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="15"><H2><?php echo $row_company['trading_name'];?></H2></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="15"><H6>DAILY DETAIL REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                    </tr>
                    <tr>
                        <th class="action-td">S/NO</th>
                        <th class="action-td">DESCRIPTION</th>
                        <th class="action-td">SERVICE</th>
                        <th class="action-td">LABS</th>
                        <th class="action-td">RADIOLOGY</th>
                        <th class="action-td">DRUGS</th>
                        <th class="action-td">SURGERY</th>
                        <th class="action-td">TOTAL BILL</th>
                        <th class="action-td">RECEIPTS</th>
                        <th class="action-td">DISCOUNT</th>
                        <th class="action-td">REFUNDS</th>
                        <th class="action-td">TOTAL PAYMENTS</th>
                        <th class="action-td">BALANCE</th>

                    </tr>
                </thead>
                <tbody class="pv-table-body" id="attend_summary_report_list_table_body">
            <?php
            
            $sql_attend = "SELECT amt_diag, amt_service, amt_labs, amt_radio, amt_surgery, amt_drugs, amt_con,
            amt_receipt, amt_refund, amt_discount, patient_id, item FROM
            (SELECT dl.amount_cash AS amt_diag, 0 AS amt_service, 0 AS amt_labs, 0 AS amt_radio, 0 AS amt_surgery, 0 AS amt_drugs, 
            0 AS amt_con, 0 AS amt_receipt, 0 AS amt_refund, 0 AS amt_discount, d.diagnosis AS item, patient_id FROM diagnosis_list dl JOIN diagnosis d ON dl.diagnosis_id=d.diagnosis_id
            WHERE dl.date BETWEEN '$start_date' AND '$end_date' AND dl.patient_id = '$patient_id'
            UNION ALL SELECT 0 AS amt_diag, sl.amount_cash AS amt_service, 0 AS amt_labs, 0 AS amt_radio, 0 AS amt_surgery, 0 AS amt_drugs, 
            0 AS amt_con, 0 AS amt_receipt, 0 AS amt_refund, 0 AS amt_discount, s.service AS item, patient_id FROM service_list sl JOIN services s ON sl.service_id=s.service_id
            WHERE sl.date BETWEEN '$start_date' AND '$end_date' AND sl.patient_id = '$patient_id'
            UNION ALL SELECT 0 AS amt_diag, 0 AS amt_service, ll.amount_cash AS amt_labs, 0 AS amt_radio, 0 AS amt_surgery, 0 AS amt_drugs, 
            0 AS amt_con, 0 AS amt_receipt, 0 AS amt_refund, 0 AS amt_discount, l.lab AS item, patient_id FROM lab_list  ll JOIN lab l ON ll.lab_id=l.lab_id
            WHERE ll.date BETWEEN '$start_date' AND '$end_date' AND ll.patient_id = '$patient_id'
            UNION ALL SELECT 0 AS amt_diag, 0 AS amt_service, 0 AS amt_labs, rl.amount_cash AS amt_radio, 0 AS amt_surgery, 0 AS amt_drugs, 
            0 AS amt_con, 0 AS amt_receipt, 0 AS amt_refund, 0 AS amt_discount, r.radiology AS item, patient_id FROM radio_list  rl JOIN radiology r ON rl.radio_id=r.radio_id
            WHERE rl.date BETWEEN '$start_date' AND '$end_date' AND rl.patient_id = '$patient_id'
            UNION ALL SELECT 0 AS amt_diag, 0 AS amt_service, 0 AS amt_labs, 0 AS amt_radio, pl.amount_cash AS amt_surgery, 0 AS amt_drugs, 
            0 AS amt_con, 0 AS amt_receipt, 0 AS amt_refund, 0 AS amt_discount, p.surgery AS item, patient_id FROM surgery_list pl JOIN surgery p ON pl.surgery_id=p.surgery_id
            WHERE pl.date BETWEEN '$start_date' AND '$end_date' AND pl.patient_id = '$patient_id'
            UNION ALL SELECT 0 AS amt_diag, 0 AS amt_service, 0 AS amt_labs, 0 AS amt_radio, 0 AS amt_surgery, ml.amt_cash AS amt_drugs, 
            0 AS amt_con, 0 AS amt_receipt, 0 AS amt_refund, 0 AS amt_discount, m.brand_name AS item, patient_id FROM drug_dispense_list ml JOIN drugs m ON ml.drug_id=m.drug_id
            WHERE ml.date BETWEEN '$start_date' AND '$end_date' AND ml.patient_id = '$patient_id'
            UNION ALL SELECT 0 AS amt_diag, 0 AS amt_service, 0 AS amt_labs, 0 AS amt_radio, 0 AS amt_surgery, 0 AS amt_drugs, 
            amount_cash AS amt_con, 0 AS amt_receipt, 0 AS amt_refund, 0 AS amt_discount, 'consumable' AS item, patient_id FROM consumable_list 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND patient_id = '$patient_id'
            UNION ALL SELECT 0 AS amt_diag, 0 AS amt_service, 0 AS amt_labs, 0 AS amt_radio, 0 AS amt_surgery, 0 AS amt_drugs, 
            0 AS amt_con, amount AS amt_receipt, 0 AS amt_refund, 0 AS amt_discount, 'receipt' AS item, patient_id FROM receipt 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND patient_id = '$patient_id'
            UNION ALL SELECT 0 AS amt_diag, 0 AS amt_service, 0 AS amt_labs, 0 AS amt_radio, 0 AS amt_surgery, 0 AS amt_drugs, 
            0 AS amt_con, 0 AS amt_receipt, amount AS amt_refund, 0 AS amt_discount, 'refund' AS item, patient_id FROM refund 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND patient_id = '$patient_id'
            UNION ALL SELECT 0 AS amt_diag, 0 AS amt_service, 0 AS amt_labs, 0 AS amt_radio, 0 AS amt_surgery, 0 AS amt_drugs, 
            0 AS amt_con, 0 AS amt_receipt, 0 AS amt_refund, amount AS amt_discount, 'discount' AS item, patient_id FROM discount 
            WHERE date BETWEEN '$start_date' AND '$end_date' AND patient_id = '$patient_id') AS c";

                
            $amt_diag_sum = 0;
            $amt_service_sum = 0;
            $amt_labs_sum = 0;
            $amt_radio_sum = 0;
            $amt_surgery_sum = 0;
            $amt_drugs_sum = 0;
            $amt_con_sum = 0;
            $amt_receipt_sum = 0;
            $amt_refund_sum = 0;
            $amt_discount_sum = 0;

            $result_attend = mysqli_query($con,$sql_attend);
            if (mysqli_num_rows($result_attend) > 0)
            {
                $i = 0;
                
                $amt_diag_sum = 0;
                $amt_service_sum = 0;
                $amt_labs_sum = 0;
                $amt_radio_sum = 0;
                $amt_surgery_sum = 0;
                $amt_drugs_sum = 0;
                $amt_con_sum = 0;
                $amt_receipt_sum = 0;
                $amt_refund_sum = 0;
                $amt_discount_sum = 0;
                $total_bill_sum = 0;
                $total_payment_sum = 0;
                $balance_sum = 0;

                while($row_attend = mysqli_fetch_array($result_attend))
                {
                    $i++;
                    $amt_diag = $row_attend['amt_diag'];
                    $amt_service = $row_attend['amt_service'];
                    $amt_labs = $row_attend['amt_labs'];
                    $amt_radio = $row_attend['amt_radio'];
                    $amt_surgery = $row_attend['amt_surgery'];
                    $amt_drugs = $row_attend['amt_drugs'];
                    $amt_con = $row_attend['amt_con'];
                    $amt_receipt = $row_attend['amt_receipt'];
                    $amt_refund = $row_attend['amt_refund'];
                    $amt_discount = $row_attend['amt_discount'];

                    $amt_diag_sum = $amt_diag_sum + $row_attend['amt_diag'];
                    $amt_service_sum = $amt_service + $row_attend['amt_service'];
                    $amt_labs_sum = $amt_labs_sum + $row_attend['amt_labs'];
                    $amt_radio_sum = $amt_radio_sum + $row_attend['amt_radio'];
                    $amt_surgery_sum = $amt_surgery_sum + $row_attend['amt_surgery'];
                    $amt_drugs_sum = $amt_drugs_sum + $row_attend['amt_drugs'];
                    $amt_con_sum = $amt_con_sum + $row_attend['amt_con'];
                    $amt_receipt_sum = $amt_receipt_sum + $row_attend['amt_receipt'];
                    $amt_refund_sum = $amt_refund_sum + $row_attend['amt_refund'];
                    $amt_discount_sum = $amt_discount_sum + $row_attend['amt_discount'];

                    $patient_id = $row_attend['patient_id'];
                    $sql_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
                    $result_patient = mysqli_query($con,$sql_patient);
                    if(!empty($result_patient) && mysqli_num_rows($result_patient) > 0)
                    {
                        $row_patient = mysqli_fetch_array($result_patient);
                        $gender_id = $row_patient['gender'];
                        $patient_name = $row_patient['firstName'].' '.$row_patient['lastName'];
                    }
                    else
                    {
                        $gender_id = 0;
                        $patient_name = 'Not Specified';
                    };

                    $query_gender = "SELECT * FROM `gender` WHERE `gender_id` = '$gender_id'";
                    $query_run_gender = mysqli_query($con, $query_gender);
                    $row_gender = mysqli_fetch_assoc($query_run_gender);
                            
                    
                    $total_bill = $amt_diag + $amt_service + $amt_labs + $amt_radio + $amt_surgery + $amt_drugs + $amt_con;
                    $total_payment = $amt_receipt + $amt_refund + $amt_discount;
                    $balance = $total_payment - $total_bill;

                    $amt_diag_f = number_format($amt_diag, 2, '.', ',');
                    $amt_service_f = number_format($amt_service, 2, '.', ',');
                    $amt_labs_f = number_format($amt_labs, 2, '.', ',');
                    $amt_radio_f = number_format($amt_radio, 2, '.', ',');
                    $amt_surgery_f = number_format($amt_surgery, 2, '.', ',');
                    $amt_drugs_f = number_format($amt_drugs, 2, '.', ',');
                    $amt_con_f = number_format($amt_con, 2, '.', ',');
                    $total_bill_f = number_format($total_bill, 2, '.', ',');
                    $amt_receipt_f = number_format($amt_receipt, 2, '.', ',');
                    $amt_refund_f = number_format($amt_refund, 2, '.', ',');
                    $amt_discount_f = number_format($amt_discount, 2, '.', ',');
                    $total_payment_f = number_format($total_payment, 2, '.', ',');
                    $balance_f = number_format($balance, 2, '.', ',');
                    ?>
                    <tr>
                        <td class="action-td"><?php echo $i;?></td>
                        <td ><?php echo $row_attend['item'];?></td>
                        <td class="amt-td"><?php echo $amt_service_f;?></td>
                        <td class="amt-td"><?php echo $amt_labs_f;?></td>
                        <td class="amt-td"><?php echo $amt_radio_f;?></td>
                        <td class="amt-td"><?php echo $amt_drugs_f;?></td>
                        <td class="amt-td"><?php echo $amt_surgery_f;?></td>
                        <td class="amt-td"><strong><?php echo $total_bill_f;?></strong></td>
                        <td class="amt-td"><?php echo $amt_receipt_f;?></td>
                        <td class="amt-td"><?php echo $amt_discount_f;?></td>
                        <td class="amt-td"><?php echo $amt_refund_f;?></td>
                        <td class="amt-td"><strong><?php echo $total_payment_f;?></strong></td>
                        <td class="amt-td"><strong><?php echo $balance_f;?></strong></td>
                    </tr>
                    <?php
                };
            };
                            

                    $total_bill_sum = $amt_diag_sum + $amt_service_sum + $amt_labs_sum + $amt_radio_sum + $amt_surgery_sum + $amt_drugs_sum + $amt_con_sum;
                    $total_payment_sum = $amt_receipt_sum + $amt_refund_sum + $amt_discount_sum;
                    $balance_sum = $total_payment_sum - $total_bill_sum;

                    $amt_diag_sum_f = number_format($amt_diag_sum, 2, '.', ',');
                    $amt_service_sum_f = number_format($amt_service_sum, 2, '.', ',');
                    $amt_labs_sum_f = number_format($amt_labs_sum, 2, '.', ',');
                    $amt_radio_sum_f = number_format($amt_radio_sum, 2, '.', ',');
                    $amt_surgery_sum_f = number_format($amt_surgery_sum, 2, '.', ',');
                    $amt_drugs_sum_f = number_format($amt_drugs_sum, 2, '.', ',');
                    $amt_con_sum_f = number_format($amt_con_sum, 2, '.', ',');
                    $total_bill_sum_f = number_format($total_bill_sum, 2, '.', ',');
                    $amt_receipt_sum_f = number_format($amt_receipt_sum, 2, '.', ',');
                    $amt_refund_sum_f = number_format($amt_refund_sum, 2, '.', ',');
                    $amt_discount_sum_f = number_format($amt_discount_sum, 2, '.', ',');
                    $total_payment_sum_f = number_format($total_payment_sum, 2, '.', ',');
                    $balance_sum_f = number_format($balance_sum, 2, '.', ',');
                    ?>
                    <tr>
                        <td class="action-td" colspan="2"><strong>GRAND TOTAL</strong></td>
                        <td class="amt-td"><strong><?php echo $amt_service_sum_f;?></strong></td>
                        <td class="amt-td"><strong><?php echo $amt_labs_sum_f;?></strong></td>
                        <td class="amt-td"><strong><?php echo $amt_radio_sum_f;?></strong></td>
                        <td class="amt-td"><strong><?php echo $amt_drugs_sum_f;?></strong></td>
                        <td class="amt-td"><strong><?php echo $amt_surgery_sum_f;?></strong></td>
                        <td class="amt-td"><strong><?php echo $total_bill_sum_f;?></strong></td>
                        <td class="amt-td"><strong><?php echo $amt_receipt_sum_f;?></strong></td>
                        <td class="amt-td"><strong><?php echo $amt_discount_sum_f;?></strong></td>
                        <td class="amt-td"><strong><?php echo $amt_refund_sum_f;?></strong></td>
                        <td class="amt-td"><strong><?php echo $total_payment_sum_f;?></strong></td>
                        <td class="amt-td"><strong><?php echo $balance_sum_f;?></strong></td>
                    </tr>
                </tbody>
        </table>
<?php    
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>