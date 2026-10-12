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
        if(isset($_SESSION['nhis_specialty_report_start_date']))
        {           
            $company_id = $_SESSION['nhis_specialty_report_company_id'];
            $user_id = $_SESSION['nhis_specialty_report_user_id'];
            $user_super_id = $_SESSION['nhis_specialty_report_user_super_id'];
            $start_date = $_SESSION['nhis_specialty_report_start_date'];
            $end_date = $_SESSION['nhis_specialty_report_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
            <table class="table table-hover table-bordered table-sm" id="nhis_specialty_report_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="14"><H2><?php echo $row_company['trading_name'];?></H2></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="14"><H6>NHIS SPECIALTY REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                    </tr>
                    <tr>
                        <th class="action-td">S/NO</th>
                        <th class="action-td">NAME</th>
                        <th class="action-td">DATE ADMIT</th>
                        <th class="action-td">DATE DISCH.</th>
                        <th class="action-td">AGE</th>
                        <th class="action-td">SEX</th>
                        <th class="action-td">MEMBER. NO</th>
                        <th class="action-td">SERVICE TYPE</th>
                        <th class="action-td">SPECIALTY</th>
                        <th class="action-td">CODE</th>
                        <th class="action-td">ATTN.</th>
                        <th class="action-td">SERVICE</th>
                        <th class="action-td">DRUG</th>
                        <th class="action-td">TOTAL</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body" id="nhis_specialty_report_list_table_body">
            <?php
             $sql_attend_by_tos = "SELECT  A.tos_id FROM `attendance` AS A JOIN `payment_type` AS P ON A.attend_id = P.attend_id WHERE P.ledger_id = 2 
             AND A.date_admit BETWEEN '$start_date' AND '$end_date' GROUP BY  A.tos_id";
             $result_attend_by_tos = mysqli_query($con,$sql_attend_by_tos);
            if (mysqli_num_rows($result_attend_by_tos) > 0)
            {
                while($row_attend_by_tos = mysqli_fetch_array($result_attend_by_tos))
                {
                    $tos_id = $row_attend_by_tos['tos_id'];
                    $sql_tos = "SELECT * FROM type_of_service WHERE tos_id = '$tos_id'";
                    $result_tos = mysqli_query($con,$sql_tos);
                    $row_tos = mysqli_fetch_array($result_tos);
                    
                    echo '<tr>
                        <th colspan="14"><H6>NHIS SPECIALTY REPORT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                    </tr>';
                    $sql_payment_type = "SELECT P.*, A.attend_id, A.patient_id, A.date_admit, A.date_disch, A.tos_id, A.age,
                    ( 
                    CASE 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 1 THEN 'GENERAL OPD' 
                        WHEN A.tos_id = 2 AND P.Specialty_1 = 1 AND A.age > 11 THEN 'MEDICAL' 
                        WHEN A.tos_id = 2 AND P.Specialty_1 = 1 AND A.age < 12 THEN 'PAEDIATRIC' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 2 THEN 'ANTENATAL/POSTNATAL' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 3 THEN 'CROSS MDC' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 29 THEN 'DENTAL' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 30 THEN 'ENT' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 31 THEN 'OPHTHAMOLOGY' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 36 THEN 'UNBUNDLED CONSULTATION ONLY' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 37 THEN 'ADULT SURGERY' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 41 THEN 'OBSTETRICS & GYNAECOLOGY' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 42 THEN 'OPHTHAMOLOGY' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 43 THEN 'ORTHOPAEDICS' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 44 THEN 'RECONSTRUCTIVE SURGERY' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 45 THEN 'CROSS MDC' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 46 THEN 'CROSS MDC' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 47 THEN 'PHYSIOTHERAPY' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 48 THEN 'CROSS MDC' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 49 THEN 'CROSS MDC' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 50 THEN 'CROSS MDC' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 51 THEN 'CROSS MDC' 
                        ELSE 'OTHERS' 
                    END 
                    )AS Specialty, 
                    (CASE 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 1 THEN 'OPDC' 
                        WHEN A.tos_id = 2 AND P.Specialty_1 = 1 AND A.age > 11 THEN 'MEDI' 
                        WHEN A.tos_id = 2 AND P.Specialty_1 = 1 AND A.age < 12 THEN 'PAED' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 2 THEN 'ANC' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 3 THEN 'ZOOM' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 29 THEN 'DENT' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 30 THEN 'ENT' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 31 THEN 'OPHT' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 36 THEN 'OPDC' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 37 THEN 'ASUR' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 41 THEN 'OBGY' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 42 THEN 'OPHT' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 43 THEN 'ORTH' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 44 THEN 'RSUR' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 45 THEN 'ZOOM' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 46 THEN 'ZOOM' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 47 THEN 'OPDC' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 48 THEN 'ZOOM' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 49 THEN 'ZOOM' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 50 THEN 'ZOOM' 
                        WHEN A.tos_id = 1 AND P.Specialty_1 = 51 THEN 'ZOOM' 
                        ELSE 'OPDC' 
                    END 
                    )AS Spec_Code, 1 AS attend_count FROM `attendance` AS A JOIN `payment_type` AS P ON A.attend_id = P.attend_id WHERE P.ledger_id = 2 AND A.date_admit BETWEEN '$start_date' AND '$end_date'";
                    $result_payment_type = mysqli_query($con,$sql_payment_type);
                    if (mysqli_num_rows($result_payment_type) > 0)
                    {
                        $i = 0;
                        while($row_payment_type = mysqli_fetch_array($result_payment_type))
                        {
                            $i = ++$i;
                            $patient_id = $row_payment_type['patient_id'];
                            $sql_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
                            $result_patient = mysqli_query($con,$sql_patient);
                            $row_patient = mysqli_fetch_array($result_patient);

                            $gender_id = $row_patient['gender'];
                            $sql_gender = "SELECT * FROM gender WHERE gender_id = '$gender_id'";
                            $result_gender = mysqli_query($con,$sql_gender);
                            $row_gender = mysqli_fetch_array($result_gender);

                            $tos_id = $row_payment_type['tos_id'];
                            $sql_tos = "SELECT * FROM type_of_service WHERE tos_id = '$tos_id'";
                            $result_tos = mysqli_query($con,$sql_tos);
                            $row_tos = mysqli_fetch_array($result_tos);

                            $attend_id = $row_payment_type['attend_id'];
                            $sql_drug_dispensed = "SELECT * FROM drug_dispense_list WHERE attend_id = '$attend_id' AND ledger_id = 2";
                            $result_drug_dispensed = mysqli_query($con,$sql_drug_dispensed);
                            if (mysqli_num_rows($result_drug_dispensed) > 0)
                            {
                                $drug_nhis_amt = 0;
                                while($row_drug_dispensed = mysqli_fetch_array($result_drug_dispensed))
                                {
                                    $drug_nhis_amt = $drug_nhis_amt + $row_drug_dispensed['amt_nhis'];
                                };
                                $drug_nhis_amt_f = number_format($drug_nhis_amt, 2, '.', ',');
                            }
                            else
                            {
                                $drug_nhis_amt = 0;
                                $drug_nhis_amt_f = number_format($drug_nhis_amt, 2, '.', ',');
                            };

                            $sql_service_charge = "SELECT * FROM service_list WHERE attend_id = '$attend_id' AND ledger_id = 2";
                            $result_service_charge = mysqli_query($con,$sql_service_charge);
                            if (mysqli_num_rows($result_service_charge) > 0)
                            {
                                $service_nhis_amt = 0;
                                while($row_service_charge = mysqli_fetch_array($result_service_charge))
                                {
                                    $service_nhis_amt = $service_nhis_amt + $row_service_charge['amount_nhis'];
                                };
                                $service_nhis_amt_f = number_format($service_nhis_amt, 2, '.', ',');
                            }
                            else
                            {
                                $service_nhis_amt = 0;
                                $service_nhis_amt_f = number_format($service_nhis_amt, 2, '.', ',');
                            };
                                $total = $drug_nhis_amt + $service_nhis_amt;
                                $total_f = number_format($total, 2, '.', ',');
                            ?>
                                <tr>
                                    <td class="action-td"><?php echo $i;?></td>
                                    <td >
                                        <?php
                                            echo '<a 
                                                href="#" 
                                                id="open_nhis_claim" 
                                                data-id="'.$row_payment_type['attend_id'].'"
                                                data-id1="'.$row_payment_type['patient_id'].'"
                                            >
                                                '.$row_patient['firstName'].' '.$row_patient['lastName'].'
                                            </a>';
                                        ?>
                                    </td>
                                    <td class="action-td"><?php echo $row_payment_type['date_admit'];?></td>
                                    <td class="action-td"><?php echo $row_payment_type['date_disch'];?></td>
                                    <td class="action-td"><?php echo $row_payment_type['age'];?></td>
                                    <td class="action-td"><?php echo $row_gender['gender'];?></td>
                                    <td class="action-td"><?php echo $row_payment_type['member_no'];?></td>
                                    <td class="action-td"><?php echo $row_tos['description'];?></td>
                                    <td><?php echo $row_payment_type['Specialty'];?></td>
                                    <td class="action-td"><?php echo $row_payment_type['Spec_Code'];?></td>
                                    <td class="action-td"><?php echo $row_payment_type['attend_count'];?></td>
                                    <td class="amt-td"><?php echo $service_nhis_amt_f;?></td>
                                    <td class="amt-td"><?php echo $drug_nhis_amt_f;?></td>
                                    <td class="amt-td"><?php echo $total_f;?></td>
                                </tr>
                            <?php
                        };
                    };
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