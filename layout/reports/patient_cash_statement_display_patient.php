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
        if(isset($_SESSION['patient_id']))
        {           
            $company_id = $_SESSION['company_id'];
            $user_super_id = $_SESSION['user_super_id'];
            $patient_id = $_SESSION['patient_id'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);

            $sql_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
            $result_patient = mysqli_query($con,$sql_patient);
            $row_patient = mysqli_fetch_array($result_patient);

            $gender_id = $row_patient['gender'];
            $sql_gender = "SELECT * FROM gender WHERE gender_id = '$gender_id'";
            $result_gender = mysqli_query($con,$sql_gender);
            $row_gender = mysqli_fetch_array($result_gender);
    ?>
            <table class="table table-hover table-bordered table-sm" id="patient_cash_statement_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="8"><H2><?php echo $row_company['trading_name'];?></H2></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="8"><H4><?php echo $row_company['telephone'];?></H4></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="8"><H4>PATIENT STATEMENT</H4></th>
                    </tr>
                </thead>
                <tbody class="pv-table-body" id="patient_cash_statement_list_table_body">
                    <tr>
                        <td colspan="8"><strong>NAME:</strong><?php echo $row_patient['firstName'].' '.$row_patient['lastName'];?></td>
                    </tr>
                    <tr>
                        <td colspan="4"><strong>FOLDER NO:</strong><?php echo $row_patient['folderNo'];?></td>
                        <td colspan="4"><strong>GENDER:</strong><?php echo $row_gender['gender'];?></td>
                    </tr>
                </tbody>
            </table>
    <?php

            $sql_attend = "SELECT * FROM attendance WHERE patient_id = '$patient_id'";
            $result_attend = mysqli_query($con,$sql_attend);
            
            if (mysqli_num_rows($result_attend) > 0)
            {
                while($row_attend = mysqli_fetch_array($result_attend))
                {
                    $tos_id = $row_attend['tos_id'];
                    $attend_id = $row_attend['attend_id'];
                    $sql_tos = "SELECT * FROM type_of_service WHERE tos_id = '$tos_id'";
                    $result_tos = mysqli_query($con,$sql_tos);
                    $row_tos = mysqli_fetch_array($result_tos);
                    echo '<table class="table table-hover table-bordered table-sm" id="patient_cash_statement_patient_list_table" width="100%" cellspacing="0">
                            <tr style="background-color:#E4DCCF; color:black">
                                <td colspan="2"><strong>AGE:</strong>'.$row_attend['age'].'year(s)</td>
                                <td colspan="2"><strong>TYPE OF SERVICE:</strong>'.$row_tos['description'].'</td>
                                <td colspan="2"><strong>DATE ADMITTED:</strong>'.$row_attend['date_admit'].'</td>
                                <td colspan="2"><strong>DATE DISCHARGED:</strong>'.$row_attend['date_disch'].'</td>
                            </tr>
                            
                            <tr>
                                <th class = "action-td">DATE</th>
                                <th>PARTICULARS</th>
                                <th class = "action-td">QTY</th>
                                <th class = "action-td">PRICE</th>
                                <th class = "action-td">BILL</th>
                                <th class = "action-td">DISC.</th>
                                <th class = "action-td">RECEIPT</th>
                                <th class = "action-td">REFUND</th>
                            </tr>
                        <tbody class="pv-table-body" id="patient_cash_statement_patient_list_table_body">';

                    $total_bill = 0;
                    $total_receipt = 0;
                    $total_discount = 0;
                    $total_refund = 0;

                    $query_svl = "SELECT * FROM `service_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_svl = mysqli_query($con, $query_svl);
                    if (mysqli_num_rows($query_run_svl) > 0)
                    {
                        $amount_sum = 0;
                        echo'<tr>
                                <th colspan="8">SERVICE</th>
                            </tr>';
                        while($row_svl = mysqli_fetch_assoc($query_run_svl))
                        {
                            $service_list_id = $row_svl['service_list_id'];
                            $query_svl_disc = "SELECT SUM(amount) AS amt_disc FROM `discount` WHERE `service_list_id` = '$service_list_id'";
                            $query_run_svl_disc = mysqli_query($con, $query_svl_disc);
                            $row_svl_disc = mysqli_fetch_assoc($query_run_svl_disc);
                            if (isset($row_svl_disc)) {
                                $amount_disc = $row_svl_disc['amt_disc'];
                            }
                            else 
                            {
                                $amount_disc = 0;
                            };
                            $total_discount = $total_discount + $amount_disc;
                            $amount_disc = number_format($amount_disc, 2, '.', ',');

                            $service_id = $row_svl['service_id'];
                            $query_service = "SELECT * FROM `services` WHERE `service_id` = '$service_id'";
                            $query_run_service = mysqli_query($con, $query_service);
                            if (mysqli_num_rows($query_run_service) > 0)
                            {
                                $row_service = mysqli_fetch_assoc($query_run_service);
                            };
                                $amount = $row_svl['amount_cash'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td class="action-td">'.$row_svl['date'].'</td>
                                    <td>'.$row_service['service'].'</td>
                                    <td class="action-td">'.$row_svl['qty'].'</td>
                                    <td class="amt-td">'.$row_svl['price_cash'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                    <td class="amt-td">'.$amount_disc.'</td>
                                    <td class="amt-td"></td>
                                    <td class="amt-td"></td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_svl['amount_cash'];
                                $total_bill = $total_bill + $row_svl['amount_cash'];
                        };
                    };

                    $query_ll = "SELECT * FROM `lab_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_ll = mysqli_query($con, $query_ll);
                    if (mysqli_num_rows($query_run_ll) > 0)
                    {
                        $amount_sum = 0;
                        echo'<tr>
                                <th colspan="8">LABORATORY TEST</th>
                            </tr>';
                        while($row_ll = mysqli_fetch_assoc($query_run_ll))
                        {
                            $lab_list_id = $row_ll['lab_list_id'];
                            $query_ll_disc = "SELECT SUM(amount) AS amt_disc FROM `discount` WHERE `lab_list_id` = '$lab_list_id'";
                            $query_run_ll_disc = mysqli_query($con, $query_ll_disc);
                            $row_ll_disc = mysqli_fetch_assoc($query_run_ll_disc);
                            if (isset($row_ll_disc)) {
                                $amount_disc = $row_ll_disc['amt_disc'];
                            }
                            else 
                            {
                                $amount_disc = 0;
                            };
                            $total_discount = $total_discount + $amount_disc;
                            $amount_disc = number_format($amount_disc, 2, '.', ',');

                            $lab_id = $row_ll['lab_id'];
                            $query_lab = "SELECT * FROM `lab` WHERE `lab_id` = '$lab_id'";
                            $query_run_lab = mysqli_query($con, $query_lab);
                            if (mysqli_num_rows($query_run_lab) > 0)
                            {
                                $row_lab = mysqli_fetch_assoc($query_run_lab);
                            };
                                $amount = $row_ll['amount_cash'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td class="action-td">'.$row_ll['date'].'</td>
                                    <td>'.$row_lab['lab'].'</td>
                                    <td class="action-td">'.$row_ll['qty'].'</td>
                                    <td class="amt-td">'.$row_ll['price_cash'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                    <td class="amt-td">'.$amount_disc.'</td>
                                    <td class="amt-td"></td>
                                    <td class="amt-td"></td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_ll['amount_cash'];
                                $total_bill = $total_bill + $row_ll['amount_cash'];
                        };
                    };

                    $query_rl = "SELECT * FROM `radio_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_rl = mysqli_query($con, $query_rl);
                    if (mysqli_num_rows($query_run_rl) > 0)
                    {
                        $amount_sum = 0;
                        echo'<tr>
                                <th colspan="8">RADIOLOGY</th>
                            </tr>';
                        while($row_rl = mysqli_fetch_assoc($query_run_rl))
                        {
                            $radio_list_id = $row_rl['radio_list_id'];
                            $query_rl_disc = "SELECT SUM(amount) AS amt_disc FROM `discount` WHERE `radio_list_id` = '$radio_list_id'";
                            $query_run_rl_disc = mysqli_query($con, $query_rl_disc);
                            $row_rl_disc = mysqli_fetch_assoc($query_run_rl_disc);
                            if (isset($row_rl_disc)) {
                                $amount_disc = $row_rl_disc['amt_disc'];
                            }
                            else 
                            {
                                $amount_disc = 0;
                            };
                            $total_discount = $total_discount + $amount_disc;
                            $amount_disc = number_format($amount_disc, 2, '.', ',');

                            $radio_id = $row_rl['radio_id'];
                            $query_radio = "SELECT * FROM `radiology` WHERE `radio_id` = '$radio_id'";
                            $query_run_radio = mysqli_query($con, $query_radio);
                            if (mysqli_num_rows($query_run_radio) > 0)
                            {
                                $row_radio = mysqli_fetch_assoc($query_run_radio);
                            };
                                $amount = $row_rl['amount_cash'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td class="action-td">'.$row_rl['date'].'</td>
                                    <td>'.$row_radio['radiology'].'</td>
                                    <td class="action-td">'.$row_rl['qty'].'</td>
                                    <td class="amt-td">'.$row_rl['price_cash'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                    <td class="amt-td">'.$amount_disc.'</td>
                                    <td class="amt-td"></td>
                                    <td class="amt-td"></td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_rl['amount_cash'];
                                $total_bill = $total_bill + $row_rl['amount_cash'];
                        };
                    };

                    $query_sl = "SELECT * FROM `surgery_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_sl = mysqli_query($con, $query_sl);
                    if (mysqli_num_rows($query_run_sl) > 0)
                    {
                        $amount_sum = 0;
                        echo'<tr>
                                <th colspan="8">SURGERY/PROCEDURE</th>
                            </tr>';
                        while($row_sl = mysqli_fetch_assoc($query_run_sl))
                        {
                            $surgery_list_id = $row_sl['surgery_list_id'];
                            $query_sl_disc = "SELECT SUM(amount) AS amt_disc FROM `discount` WHERE `surgery_list_id` = '$surgery_list_id'";
                            $query_run_sl_disc = mysqli_query($con, $query_sl_disc);
                            $row_sl_disc = mysqli_fetch_assoc($query_run_sl_disc);
                            if (isset($row_sl_disc)) {
                                $amount_disc = $row_sl_disc['amt_disc'];
                            }
                            else 
                            {
                                $amount_disc = 0;
                            };
                            $total_discount = $total_discount + $amount_disc;
                            $amount_disc = number_format($amount_disc, 2, '.', ',');

                            $surgery_id = $row_sl['surgery_id'];
                            $query_surgery = "SELECT * FROM `surgery` WHERE `surgery_id` = '$surgery_id'";
                            $query_run_surgery = mysqli_query($con, $query_surgery);
                            if (mysqli_num_rows($query_run_surgery) > 0)
                            {
                                $row_surgery = mysqli_fetch_assoc($query_run_surgery);
                            };
                                $amount = $row_sl['amount_cash'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td class="action-td">'.$row_sl['date'].'</td>
                                    <td>'.$row_surgery['surgery'].'</td>
                                    <td class="action-td">'.$row_sl['qty'].'</td>
                                    <td class="amt-td">'.$row_sl['price_cash'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                    <td class="amt-td">'.$amount_disc.'</td>
                                    <td class="amt-td"></td>
                                    <td class="amt-td"></td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_sl['amount_cash'];
                                $total_bill = $total_bill + $row_sl['amount_cash'];
                        };
                    };

                    //DRUGS
                    $query_drl = "SELECT * FROM `drug_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_drl = mysqli_query($con, $query_drl);
                    if (mysqli_num_rows($query_run_drl) > 0)
                    {
                        $amount_sum = 0;
                        echo'<tr>
                                <th colspan="8">DRUGS</th>
                            </tr>';
                        while($row_drl = mysqli_fetch_assoc($query_run_drl))
                        {
                            $drug_list_id = $row_drl['drug_list_id'];
                            $query_drl_disc = "SELECT SUM(amount) AS amt_disc FROM `discount` WHERE `drug_list_id` = '$drug_list_id'";
                            $query_run_drl_disc = mysqli_query($con, $query_drl_disc);
                            $row_drl_disc = mysqli_fetch_assoc($query_run_drl_disc);
                            if (isset($row_drl_disc)) {
                                $amount_disc = $row_drl_disc['amt_disc'];
                            }
                            else 
                            {
                                $amount_disc = 0;
                            };
                            $total_discount = $total_discount + $amount_disc;
                            $amount_disc = number_format($amount_disc, 2, '.', ',');

                            $drug_id = $row_drl['drug_id'];
                            $query_drug = "SELECT * FROM `stock_items` WHERE `stock_item_id` = '$drug_id'";
                            $query_run_drug = mysqli_query($con, $query_drug);
                            if (mysqli_num_rows($query_run_drug) > 0)
                            {
                                $row_drug = mysqli_fetch_assoc($query_run_drug);
                            };
                                $amount = $row_drl['amount_cash'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td class="action-td">'.$row_drl['date'].'</td>
                                    <td>'.$row_drug['stock_item'].'</td>
                                    <td class="action-td">'.$row_drl['qty_presc'].'</td>
                                    <td class="amt-td">'.$row_drl['price_cash'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                    <td class="amt-td">'.$amount_disc.'</td>
                                    <td class="amt-td"></td>
                                    <td class="amt-td"></td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_drl['amount_cash'];
                                $total_bill = $total_bill + $row_drl['amount_cash'];
                        };
                    };

                    //PATIENT DRUG RETURNS
                    $query_drl = "SELECT * FROM `drug_patient_returns` WHERE `attend_id` = '$attend_id'";
                    $query_run_drl = mysqli_query($con, $query_drl);
                    if (mysqli_num_rows($query_run_drl) > 0)
                    {
                        $amount_sum = 0;
                        echo'<tr>
                                <th colspan="8">DRUG RETURNS</th>
                            </tr>';
                        while($row_drl = mysqli_fetch_assoc($query_run_drl))
                        {
                            $drug_id = $row_drl['drug_id'];
                            $query_drug = "SELECT * FROM `drugs` WHERE `drug_id` = '$drug_id'";
                            $query_run_drug = mysqli_query($con, $query_drug);
                            if (mysqli_num_rows($query_run_drug) > 0)
                            {
                                $row_drug = mysqli_fetch_assoc($query_run_drug);
                            };
                                $amount = $row_drl['amount'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td class="action-td">'.$row_drl['date'].'</td>
                                    <td>'.$row_drug['brand_name'].'</td>
                                    <td class="action-td">'.$row_drl['qty'].'</td>
                                    <td class="amt-td">'.$row_drl['price'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                    <td class="amt-td"></td>
                                    <td class="amt-td"></td>
                                    <td class="amt-td"></td>
                                </tr>';
                                $amount_sum = $amount_sum - $row_drl['amount'];
                                $total_bill = $total_bill - $row_drl['amount'];
                        };
                    };

                    $query_cl = "SELECT * FROM `consumable_list` WHERE `attend_id` = '$attend_id'";
                    $query_run_cl = mysqli_query($con, $query_cl);
                    if (mysqli_num_rows($query_run_cl) > 0)
                    {
                        $amount_sum = 0;
                        echo'<tr>
                                <th colspan="8">CONSUMABLES</th>
                            </tr>';
                        while($row_cl = mysqli_fetch_assoc($query_run_cl))
                        {
                            $con_list_id = $row_cl['con_list_id'];
                            $query_cl_disc = "SELECT SUM(amount) AS amt_disc FROM `discount` WHERE `con_list_id` = '$con_list_id'";
                            $query_run_cl_disc = mysqli_query($con, $query_cl_disc);
                            $row_cl_disc = mysqli_fetch_assoc($query_run_cl_disc);
                            if (isset($row_cl_disc)) {
                                $amount_disc = $row_cl_disc['amt_disc'];
                            }
                            else 
                            {
                                $amount_disc = 0;
                            };
                            $total_discount = $total_discount + $amount_disc;
                            $amount_disc = number_format($amount_disc, 2, '.', ',');

                            $con_id = $row_cl['con_id'];
                            $query_con = "SELECT * FROM `consumable` WHERE `con_id` = '$con_id'";
                            $query_run_con = mysqli_query($con, $query_con);
                            if (mysqli_num_rows($query_run_con) > 0)
                            {
                                $row_con = mysqli_fetch_assoc($query_run_con);
                            };
                                $amount = $row_cl['amount_cash'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td class="action-td">'.$row_cl['date'].'</td>
                                    <td>'.$row_con['consumable'].'</td>
                                    <td class="action-td">'.$row_cl['qty_issued'].'</td>
                                    <td class="amt-td">'.$row_cl['price_cash'].'</td>
                                    <td class="amt-td">'.$amount.'</td>
                                    <td class="amt-td">'.$amount_disc.'</td>
                                    <td class="amt-td"></td>
                                    <td class="amt-td"></td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_cl['amount_cash'];
                                $total_bill = $total_bill + $row_cl['amount_cash'];
                        };
                    };

                    $query_rec = "SELECT * FROM `receipt` WHERE `attend_id` = '$attend_id'";
                    $query_run_rec = mysqli_query($con, $query_rec);
                    if (mysqli_num_rows($query_run_rec) > 0)
                    {
                        $amount_sum = 0;
                        echo'<tr>
                                <th colspan="8">RECIPTS</th>
                            </tr>';
                        while($row_rec = mysqli_fetch_assoc($query_run_rec))
                        {
                            $receipt_id = $row_rec['receipt_id'];
                            $query_rec_refund = "SELECT SUM(amount) AS amt_refund FROM `refund` WHERE `receipt_id` = '$receipt_id'";
                            $query_run_rec_refund = mysqli_query($con, $query_rec_refund);
                            $row_rec_refund = mysqli_fetch_assoc($query_run_rec_refund);
                            if (isset($row_rec_refund)) {
                                $amount_refund = $row_rec_refund['amt_refund'];
                            }
                            else 
                            {
                                $amount_refund = 0;
                            };
                            $total_refund = $total_refund + $amount_refund;
                            $amount_refund = number_format($amount_refund, 2, '.', ',');
                            
                                $amount = $row_rec['amount'];
                                $amount = number_format($amount, 2, '.', ',');
                            echo '<tr>
                                    <td class="action-td">'.$row_rec['date'].'</td>
                                    <td>'.$row_rec['mode'].'</td>
                                    <td class="action-td"></td>
                                    <td class="amt-td"></td>
                                    <td class="amt-td"></td>
                                    <td class="amt-td"></td>
                                    <td class="amt-td">'.$amount.'</td>
                                    <td class="amt-td">'.$amount_refund.'</td>
                                </tr>';
                                $amount_sum = $amount_sum + $row_rec['amount'];
                                $total_receipt = $total_receipt + $row_rec['amount'];
                        };
                    };

                    $balance = $total_bill - $total_discount + $total_refund - $total_receipt;
                    $total_bill = number_format($total_bill, 2, '.', ',');
                    $total_discount = number_format($total_discount, 2, '.', ',');
                    $total_receipt = number_format($total_receipt, 2, '.', ',');
                    $total_refund = number_format($total_refund, 2, '.', ',');
                    $balance = number_format($balance, 2, '.', ',');
                    echo '<tr>
                            <th class="amt-td" colspan="4">TOTAL</th>
                            <th class="amt-td">'.$total_bill.'</th>
                            <th class="amt-td">'.$total_discount.'</th>
                            <th class="amt-td">'.$total_receipt.'</th>
                            <th class="amt-td">'.$total_refund.'</th>
                        </tr>
                        <tr>
                            <th class="amt-td" colspan="6">BALANCE</th>
                            <th class="amt-td" colspan="2">'.$balance.'</th>
                        </tr>
                        </tbody>
                    </table>';
                };
            };
    };
?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>