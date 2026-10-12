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
        if(isset($_SESSION['statement_of_in_patient_start_date']))
        {
            $company_id = $_SESSION['company_id'];
            $start_date = $_SESSION['statement_of_in_patient_start_date'];
            $end_date = $_SESSION['statement_of_in_patient_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
            <table class="table table-hover table-bordered table-sm" id="statement_of_in_patient_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="15"><H2><?php echo $row_company['trading_name'];?></H2></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="15"><H6>STATEMENT OF IN-PATIENT FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                    </tr>
                    
                    <tr>
                        <th class="action-td">AGE GROUP</th>
                        <th class="action-td" colspan="6">INSURED PATIENTS</th>
                        <th class="action-td" colspan="6">NON-INSURED PATIENTS</th>
                        <th class="action-td" colspan="2">TOTAL</th>
                    </tr>
                    <tr>
                        <th class="action-td"></th>
                        <th class="action-td" colspan="3">ADMISSION</th>
                        <th class="action-td" colspan="3">DEATH</th>
                        <th class="action-td" colspan="3">ADMISSION</th>
                        <th class="action-td" colspan="3">DEATH</th>
                        <th class="action-td" colspan="2"></th>
                    </tr>
                    <tr>
                        <th class="action-td"></th>
                        <th class="action-td">MALE</th>
                        <th class="action-td">FEMALE</th>
                        <th class="action-td">TOTAL</th>
                        <th class="action-td">MALE</th>
                        <th class="action-td">FEMALE</th>
                        <th class="action-td">TOTAL</th>
                        <th class="action-td">MALE</th>
                        <th class="action-td">FEMALE</th>
                        <th class="action-td">TOTAL</th>
                        <th class="action-td">MALE</th>
                        <th class="action-td">FEMALE</th>
                        <th class="action-td">TOTAL</th>
                        <th class="action-td" colspan="2"></th>
                    </tr>
                </thead>
                <tbody class="pv-table-body" id="ledger_report_list_table_body">
                    <?php
                                    //ins_admission_m_0_28days
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 0 AND 28 
                                        AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_m_0_28days = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_m_0_28days = 0;
                                        };

                                    //ins_death_m_0_28days
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 0 AND 28 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_m_0_28days = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_m_0_28days = 0;
                                        };

                                    //ins_admission_f_0_28days
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 0 AND 28 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_f_0_28days = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_f_0_28days = 0;
                                        };

                                    //ins_death_f_0_28days
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 0 AND 28 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_f_0_28days = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_f_0_28days = 0;
                                        };
                                    
                                    //non_ins_admission_m_0_28days
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 0 AND 28 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_m_0_28days = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_m_0_28days = 0;
                                        };

                                    //non_ins_death_m_0_28days
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 0 AND 28 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_m_0_28days = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_m_0_28days = 0;
                                        };

                                    //non_ins_admission_f_0_28days
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 0 AND 28 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_f_0_28days = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_f_0_28days = 0;
                                        };

                                    //non_ins_death_f_0_28days
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 0 AND 28 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_f_0_28days = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_f_0_28days = 0;
                                        };
                                    //total_0_28days
                                        $total_0_28days = $ins_admission_m_0_28days + $ins_death_m_0_28days + 
                                        $ins_admission_f_0_28days + $ins_death_f_0_28days + $non_ins_admission_m_0_28days + 
                                        $non_ins_death_m_0_28days + $non_ins_admission_f_0_28days + $non_ins_death_f_0_28days;
                                        echo'<tr>
                                            <td class="action-td">0 - 28 Days</td>
                                            <td class="action-td">'.$ins_admission_m_0_28days.'</td>
                                            <td class="action-td">'.$ins_death_m_0_28days.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$ins_admission_f_0_28days.'</td>
                                            <td class="action-td">'.$ins_death_f_0_28days.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_m_0_28days.'</td>
                                            <td class="action-td">'.$non_ins_death_m_0_28days.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_f_0_28days.'</td>
                                            <td class="action-td">'.$non_ins_death_f_0_28days.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_0_28days.'</strong></td>
                                        </tr>';
                                    //ins_admission_m_1_11Months
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 29 AND 330 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_m_1_11Months = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_m_1_11Months = 0;
                                        };

                                    //ins_death_m_1_11Months
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 29 AND 330 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_m_1_11Months = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_m_1_11Months = 0;
                                        };

                                    //ins_admission_f_1_11Months
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 29 AND 330 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_f_1_11Months = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_f_1_11Months = 0;
                                        };

                                    //ins_death_f_1_11Months
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 29 AND 330 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_f_1_11Months = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_f_1_11Months = 0;
                                        };
                                    
                                    //non_ins_admission_m_1_11Months
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 29 AND 330 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_m_1_11Months = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_m_1_11Months = 0;
                                        };

                                    //non_ins_death_m_1_11Months
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 29 AND 330 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_m_1_11Months = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_m_1_11Months = 0;
                                        };

                                    //non_ins_admission_f_1_11Months
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 29 AND 330 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_f_1_11Months = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_f_1_11Months = 0;
                                        };

                                    //non_ins_death_f_1_11Months
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 29 AND 330 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_f_1_11Months = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_f_1_11Months = 0;
                                        };

                                    //total_1_11Months
                                        $total_1_11Months = $ins_admission_m_1_11Months + $ins_death_m_1_11Months + 
                                        $ins_admission_f_1_11Months + $ins_death_f_1_11Months + $non_ins_admission_m_1_11Months + 
                                        $non_ins_death_m_1_11Months + $non_ins_admission_f_1_11Months + $non_ins_death_f_1_11Months;
                                    
                                        echo'<tr>
                                            <td class="action-td">1 - 11 Months</td>
                                            <td class="action-td">'.$ins_admission_m_1_11Months.'</td>
                                            <td class="action-td">'.$ins_death_m_1_11Months.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$ins_admission_f_1_11Months.'</td>
                                            <td class="action-td">'.$ins_death_f_1_11Months.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_m_1_11Months.'</td>
                                            <td class="action-td">'.$non_ins_death_m_1_11Months.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_f_1_11Months.'</td>
                                            <td class="action-td">'.$non_ins_death_f_1_11Months.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_1_11Months.'</strong></td>
                                        </tr>';
                                    //ins_admission_m_1_4yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 1 AND 4 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_m_1_4yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_m_1_4yrs = 0;
                                        };

                                    //ins_death_m_1_4yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 1 AND 4 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_m_1_4yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_m_1_4yrs = 0;
                                        };

                                    //ins_admission_f_1_4yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 1 AND 4 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_f_1_4yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_f_1_4yrs = 0;
                                        };

                                    //ins_death_f_1_4yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 1 AND 4 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_f_1_4yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_f_1_4yrs = 0;
                                        };
                                    
                                    //non_ins_admission_m_1_4yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 1 AND 4 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_m_1_4yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_m_1_4yrs = 0;
                                        };

                                    //non_ins_death_m_1_4yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 1 AND 4 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_m_1_4yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_m_1_4yrs = 0;
                                        };

                                    //non_ins_admission_f_1_4yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 1 AND 4 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_f_1_4yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_f_1_4yrs = 0;
                                        };

                                    //non_ins_death_f_1_4yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 1 AND 4 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_f_1_4yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_f_1_4yrs = 0;
                                        };

                                    //total_1_4yrs
                                        $total_1_4yrs = $ins_admission_m_1_4yrs + $ins_death_m_1_4yrs + $ins_admission_f_1_4yrs +
                                        $ins_death_f_1_4yrs + $non_ins_admission_m_1_4yrs + $non_ins_death_m_1_4yrs +
                                        $non_ins_admission_f_1_4yrs + $non_ins_death_f_1_4yrs;
                                    
                                        echo'<tr>
                                            <td class="action-td">1 - 4 Years</td>
                                            <td class="action-td">'.$ins_admission_m_1_4yrs.'</td>
                                            <td class="action-td">'.$ins_death_m_1_4yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$ins_admission_f_1_4yrs.'</td>
                                            <td class="action-td">'.$ins_death_f_1_4yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_m_1_4yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_m_1_4yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_f_1_4yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_f_1_4yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_1_4yrs.'</strong></td>
                                        </tr>';

                                    //ins_admission_m_5_9yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 4 AND 9 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_m_5_9yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_m_5_9yrs = 0;
                                        };

                                    //ins_death_m_5_9yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 5 AND 9 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_m_5_9yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_m_5_9yrs = 0;
                                        };

                                    //ins_admission_f_5_9yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 5 AND 9 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_f_5_9yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_f_5_9yrs = 0;
                                        };

                                    //ins_death_f_5_9yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 5 AND 9 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_f_5_9yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_f_5_9yrs = 0;
                                        };
                                    
                                    //non_ins_admission_m_5_9yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 5 AND 9 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_m_5_9yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_m_5_9yrs = 0;
                                        };

                                    //non_ins_death_m_5_9yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 5 AND 9 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_m_5_9yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_m_5_9yrs = 0;
                                        };

                                    //non_ins_admission_f_5_9yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 5 AND 9 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_f_5_9yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_f_5_9yrs = 0;
                                        };

                                    //non_ins_death_f_5_9yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 5 AND 9 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_f_5_9yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_f_5_9yrs = 0;
                                        };

                                    //total_5_9yrs
                                        $total_5_9yrs = $ins_admission_m_5_9yrs + $ins_death_m_5_9yrs + $ins_admission_f_5_9yrs +
                                        $ins_death_f_5_9yrs + $non_ins_admission_m_5_9yrs + $non_ins_death_m_5_9yrs +
                                        $non_ins_admission_f_5_9yrs + $non_ins_death_f_5_9yrs;
                                        
                                        echo'<tr>
                                            <td class="action-td">5 - 9 Years</td>
                                            <td class="action-td">'.$ins_admission_m_5_9yrs.'</td>
                                            <td class="action-td">'.$ins_death_m_5_9yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$ins_admission_f_5_9yrs.'</td>
                                            <td class="action-td">'.$ins_death_f_5_9yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_m_5_9yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_m_5_9yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_f_5_9yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_f_5_9yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_5_9yrs.'</strong></td>
                                        </tr>';
                                
                                    //ins_admission_m_10_14yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 10 AND 14 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_m_10_14yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_m_10_14yrs = 0;
                                        };

                                    //ins_death_m_10_14yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 10 AND 14 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_m_10_14yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_m_10_14yrs = 0;
                                        };

                                    //ins_admission_f_10_14yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 10 AND 14 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_f_10_14yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_f_10_14yrs = 0;
                                        };

                                    //ins_death_f_10_14yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 10 AND 14 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_f_10_14yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_f_10_14yrs = 0;
                                        };
                                    
                                    //non_ins_admission_m_10_14yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 10 AND 14 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_m_10_14yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_m_10_14yrs = 0;
                                        };

                                    //non_ins_death_m_10_14yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 10 AND 14 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_m_10_14yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_m_10_14yrs = 0;
                                        };

                                    //non_ins_admission_f_10_14yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 10 AND 14 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_f_10_14yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_f_10_14yrs = 0;
                                        };

                                    //non_ins_death_f_10_14yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 10 AND 14 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_f_10_14yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_f_10_14yrs = 0;
                                        };

                                    //total_10_14yrs
                                        $total_10_14yrs = $ins_admission_m_10_14yrs + $ins_death_m_10_14yrs + $ins_admission_f_10_14yrs +
                                        $ins_death_f_10_14yrs + $non_ins_admission_m_10_14yrs + $non_ins_death_m_10_14yrs +
                                        $non_ins_admission_f_10_14yrs + $non_ins_death_f_10_14yrs;
                                    
                                        echo'<tr>
                                            <td class="action-td">10 - 14 Years</td>
                                            <td class="action-td">'.$ins_admission_m_10_14yrs.'</td>
                                            <td class="action-td">'.$ins_death_m_10_14yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$ins_admission_f_10_14yrs.'</td>
                                            <td class="action-td">'.$ins_death_f_10_14yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_m_10_14yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_m_10_14yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_f_10_14yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_f_10_14yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_10_14yrs.'</strong></td>
                                        </tr>';

                                    //ins_admission_m_15_17yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 15 AND 17 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_m_15_17yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_m_15_17yrs = 0;
                                        };

                                    //ins_death_m_15_17yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 15 AND 17 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_m_15_17yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_m_15_17yrs = 0;
                                        };

                                    //ins_admission_f_15_17yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 15 AND 17 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_f_15_17yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_f_15_17yrs = 0;
                                        };

                                    //ins_death_f_15_17yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 15 AND 17 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_f_15_17yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_f_15_17yrs = 0;
                                        };
                                    
                                    //non_ins_admission_m_15_17yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 15 AND 17 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_m_15_17yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_m_15_17yrs = 0;
                                        };

                                    //non_ins_death_m_15_17yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 15 AND 17 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_m_15_17yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_m_15_17yrs = 0;
                                        };

                                    //non_ins_admission_f_15_17yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 15 AND 17 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_f_15_17yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_f_15_17yrs = 0;
                                        };

                                    //non_ins_death_f_15_17yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 15 AND 17 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_f_15_17yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_f_15_17yrs = 0;
                                        };

                                    //total_15_17yrs
                                        $total_15_17yrs = $ins_admission_m_15_17yrs + $ins_death_m_15_17yrs + $ins_admission_f_15_17yrs +
                                        $ins_death_f_15_17yrs + $non_ins_admission_m_15_17yrs + $non_ins_death_m_15_17yrs +
                                        $non_ins_admission_f_15_17yrs + $non_ins_death_f_15_17yrs;
                                    
                                        echo'<tr>
                                            <td class="action-td">15 - 17 Years</td>
                                            <td class="action-td">'.$ins_admission_m_15_17yrs.'</td>
                                            <td class="action-td">'.$ins_death_m_15_17yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$ins_admission_f_15_17yrs.'</td>
                                            <td class="action-td">'.$ins_death_f_15_17yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_m_15_17yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_m_15_17yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_f_15_17yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_f_15_17yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_15_17yrs.'</strong></td>
                                        </tr>';

                                    //ins_admission_m_18_19yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 18 AND 19 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_m_18_19yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_m_18_19yrs = 0;
                                        };

                                    //ins_death_m_18_19yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 18 AND 19 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_m_18_19yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_m_18_19yrs = 0;
                                        };

                                    //ins_admission_f_18_19yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 18 AND 19 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_f_18_19yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_f_18_19yrs = 0;
                                        };

                                    //ins_death_f_18_19yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 18 AND 19 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_f_18_19yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_f_18_19yrs = 0;
                                        };
                                    
                                    //non_ins_admission_m_18_19yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 18 AND 19 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_m_18_19yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_m_18_19yrs = 0;
                                        };

                                    //non_ins_death_m_18_19yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 18 AND 19 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_m_18_19yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_m_18_19yrs = 0;
                                        };

                                    //non_ins_admission_f_18_19yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 18 AND 19 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_f_18_19yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_f_18_19yrs = 0;
                                        };

                                    //non_ins_death_f_18_19yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 18 AND 19 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_f_18_19yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_f_18_19yrs = 0;
                                        };

                                    //total_18_19yrs
                                        $total_18_19yrs = $ins_admission_m_18_19yrs + $ins_death_m_18_19yrs + $ins_admission_f_18_19yrs +
                                        $ins_death_f_18_19yrs + $non_ins_admission_m_18_19yrs + $non_ins_death_m_18_19yrs +
                                        $non_ins_admission_f_18_19yrs + $non_ins_death_f_18_19yrs;
                                    
                                        echo'<tr>
                                            <td class="action-td">18 - 19 Years</td>
                                            <td class="action-td">'.$ins_admission_m_18_19yrs.'</td>
                                            <td class="action-td">'.$ins_death_m_18_19yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$ins_admission_f_18_19yrs.'</td>
                                            <td class="action-td">'.$ins_death_f_18_19yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_m_18_19yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_m_18_19yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_f_18_19yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_f_18_19yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_18_19yrs.'</strong></td>
                                        </tr>';

                                    //ins_admission_m_20_34yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 20 AND 34 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_m_20_34yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_m_20_34yrs = 0;
                                        };

                                    //ins_death_m_20_34yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 20 AND 34 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_m_20_34yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_m_20_34yrs = 0;
                                        };

                                    //ins_admission_f_20_34yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 20 AND 34 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_f_20_34yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_f_20_34yrs = 0;
                                        };

                                    //ins_death_f_20_34yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 20 AND 34 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_f_20_34yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_f_20_34yrs = 0;
                                        };
                                    
                                    //non_ins_admission_m_20_34yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 20 AND 34 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_m_20_34yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_m_20_34yrs = 0;
                                        };

                                    //non_ins_death_m_20_34yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 20 AND 34 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_m_20_34yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_m_20_34yrs = 0;
                                        };

                                    //non_ins_admission_f_20_34yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 20 AND 34 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_f_20_34yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_f_20_34yrs = 0;
                                        };

                                    //non_ins_death_f_20_34yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 20 AND 34 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_f_20_34yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_f_20_34yrs = 0;
                                        };

                                    //total_20_34yrs
                                        $total_20_34yrs = $ins_admission_m_20_34yrs + $ins_death_m_20_34yrs + $ins_admission_f_20_34yrs +
                                        $ins_death_f_20_34yrs + $non_ins_admission_m_20_34yrs + $non_ins_death_m_20_34yrs +
                                        $non_ins_admission_f_20_34yrs + $non_ins_death_f_20_34yrs;
                                    
                                        echo'<tr>
                                            <td class="action-td">20 - 34 Years</td>
                                            <td class="action-td">'.$ins_admission_m_20_34yrs.'</td>
                                            <td class="action-td">'.$ins_death_m_20_34yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$ins_admission_f_20_34yrs.'</td>
                                            <td class="action-td">'.$ins_death_f_20_34yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_m_20_34yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_m_20_34yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_f_20_34yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_f_20_34yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_20_34yrs.'</strong></td>
                                        </tr>';

                                    //ins_admission_m_35_49yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 35 AND 49 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_m_35_49yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_m_35_49yrs = 0;
                                        };

                                    //ins_death_m_35_49yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 35 AND 49 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_m_35_49yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_m_35_49yrs = 0;
                                        };

                                    //ins_admission_f_35_49yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 35 AND 49 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_f_35_49yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_f_35_49yrs = 0;
                                        };

                                    //ins_death_f_35_49yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 35 AND 49 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_f_35_49yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_f_35_49yrs = 0;
                                        };
                                    
                                    //non_ins_admission_m_35_49yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 35 AND 49 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_m_35_49yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_m_35_49yrs = 0;
                                        };

                                    //non_ins_death_m_35_49yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 35 AND 49 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_m_35_49yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_m_35_49yrs = 0;
                                        };

                                    //non_ins_admission_f_35_49yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 35 AND 49 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_f_35_49yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_f_35_49yrs = 0;
                                        };

                                    //non_ins_death_f_35_49yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 35 AND 49 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_f_35_49yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_f_35_49yrs = 0;
                                        };

                                    //total_35_49yrs
                                        $total_35_49yrs = $ins_admission_m_35_49yrs + $ins_death_m_35_49yrs + $ins_admission_f_35_49yrs +
                                        $ins_death_f_35_49yrs + $non_ins_admission_m_35_49yrs + $non_ins_death_m_35_49yrs +
                                        $non_ins_admission_f_35_49yrs + $non_ins_death_f_35_49yrs;
                                    
                                        echo'<tr>
                                            <td class="action-td">35 - 49 Years</td>
                                            <td class="action-td">'.$ins_admission_m_35_49yrs.'</td>
                                            <td class="action-td">'.$ins_death_m_35_49yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$ins_admission_f_35_49yrs.'</td>
                                            <td class="action-td">'.$ins_death_f_35_49yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_m_35_49yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_m_35_49yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_f_35_49yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_f_35_49yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_35_49yrs.'</strong></td>
                                        </tr>';

                                    //ins_admission_m_50_59yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 50 AND 59 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_m_50_59yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_m_50_59yrs = 0;
                                        };

                                    //ins_death_m_50_59yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 50 AND 59 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_m_50_59yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_m_50_59yrs = 0;
                                        };

                                    //ins_admission_f_50_59yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 50 AND 59 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_f_50_59yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_f_50_59yrs = 0;
                                        };

                                    //ins_death_f_50_59yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 50 AND 59 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_f_50_59yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_f_50_59yrs = 0;
                                        };
                                    
                                    //non_ins_admission_m_50_59yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 50 AND 59 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_m_50_59yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_m_50_59yrs = 0;
                                        };

                                    //non_ins_death_m_50_59yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 50 AND 59 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_m_50_59yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_m_50_59yrs = 0;
                                        };

                                    //non_ins_admission_f_50_59yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 50 AND 59 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_f_50_59yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_f_50_59yrs = 0;
                                        };

                                    //non_ins_death_f_50_59yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 50 AND 59 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_f_50_59yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_f_50_59yrs = 0;
                                        };

                                    //total_50_59yrs
                                        $total_50_59yrs = $ins_admission_m_50_59yrs + $ins_death_m_50_59yrs + $ins_admission_f_50_59yrs +
                                        $ins_death_f_50_59yrs + $non_ins_admission_m_50_59yrs + $non_ins_death_m_50_59yrs +
                                        $non_ins_admission_f_50_59yrs + $non_ins_death_f_50_59yrs;
                                    
                                        echo'<tr>
                                            <td class="action-td">50 - 59 Years</td>
                                            <td class="action-td">'.$ins_admission_m_50_59yrs.'</td>
                                            <td class="action-td">'.$ins_death_m_50_59yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$ins_admission_f_50_59yrs.'</td>
                                            <td class="action-td">'.$ins_death_f_50_59yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_m_50_59yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_m_50_59yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_f_50_59yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_f_50_59yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_50_59yrs.'</strong></td>
                                        </tr>';

                                    //ins_admission_m_60_69yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 60 AND 69 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_m_60_69yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_m_60_69yrs = 0;
                                        };

                                    //ins_death_m_60_69yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 60 AND 69 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_m_60_69yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_m_60_69yrs = 0;
                                        };

                                    //ins_admission_f_60_69yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 60 AND 69 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_f_60_69yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_f_60_69yrs = 0;
                                        };

                                    //ins_death_f_60_69yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 60 AND 69 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_f_60_69yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_f_60_69yrs = 0;
                                        };
                                    
                                    //non_ins_admission_m_60_69yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 60 AND 69 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_m_60_69yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_m_60_69yrs = 0;
                                        };

                                    //non_ins_death_m_60_69yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 60 AND 69 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_m_60_69yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_m_60_69yrs = 0;
                                        };

                                    //non_ins_admission_f_60_69yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age BETWEEN 60 AND 69 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_f_60_69yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_f_60_69yrs = 0;
                                        };

                                    //non_ins_death_f_60_69yrs
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age BETWEEN 60 AND 69 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_f_60_69yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_f_60_69yrs = 0;
                                        };

                                    //total_60_69yrs
                                        $total_60_69yrs = $ins_admission_m_60_69yrs + $ins_death_m_60_69yrs + $ins_admission_f_60_69yrs +
                                        $ins_death_f_60_69yrs + $non_ins_admission_m_60_69yrs + $non_ins_death_m_60_69yrs +
                                        $non_ins_admission_f_60_69yrs + $non_ins_death_f_60_69yrs;
                                    
                                        echo'<tr>
                                            <td class="action-td">60 - 69 Years</td>
                                            <td class="action-td">'.$ins_admission_m_60_69yrs.'</td>
                                            <td class="action-td">'.$ins_death_m_60_69yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$ins_admission_f_60_69yrs.'</td>
                                            <td class="action-td">'.$ins_death_f_60_69yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_m_60_69yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_m_60_69yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_f_60_69yrs.'</td>
                                            <td class="action-td">'.$non_ins_death_f_60_69yrs.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_60_69yrs.'</strong></td>
                                        </tr>';

                                    //ins_admission_m_70yrs_and_more
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age > 69 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_m_70yrs_and_more = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_m_70yrs_and_more = 0;
                                        };

                                    //ins_death_m_70yrs_and_more
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age > 69 AND p.gender=1 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_m_70yrs_and_more = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_m_70yrs_and_more = 0;
                                        };

                                    //ins_admission_f_70yrs_and_more
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age > 69 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_admission_f_70yrs_and_more = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_admission_f_70yrs_and_more = 0;
                                        };

                                    //ins_death_f_70yrs_and_more
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age > 69 AND p.gender=2 AND pt.ledger_id !=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $ins_death_f_70yrs_and_more = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $ins_death_f_70yrs_and_more = 0;
                                        };
                                    
                                    //non_ins_admission_m_70yrs_and_more
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age > 69 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_m_70yrs_and_more = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_m_70yrs_and_more = 0;
                                        };

                                    //non_ins_death_m_70yrs_and_more
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age > 69 AND p.gender=1 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_m_70yrs_and_more = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_m_70yrs_and_more = 0;
                                        };

                                    //non_ins_admission_f_70yrs_and_more
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'New' AND a.age > 69 AND p.gender=2 AND pt.ledger_id=1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome !='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_admission_f_70yrs_and_more = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_admission_f_70yrs_and_more = 0;
                                        };

                                    //non_ins_death_f_70yrs_and_more
                                        $sql_dl = "SELECT a.date_admit, a.status, a.attend_id, a.age, p.DOB, p.patient_id, p.gender, 
                                        pt.attend_id, pt.principal, pt.ledger_id, a.tos_id, a.outcome
                                        FROM attendance a
                                        JOIN patients p ON p.patient_id=a.patient_id
                                        JOIN payment_type pt ON a.attend_id=pt.attend_id
                                        WHERE a.date_admit BETWEEN '$start_date' AND '$end_date' 
                                        AND a.status = 'Old' AND a.age > 69 AND p.gender=2 AND pt.ledger_id =1 AND 
                                        pt.principal='Yes' AND a.tos_id=2 AND a.outcome ='died'";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $non_ins_death_f_70yrs_and_more = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $non_ins_death_f_70yrs_and_more = 0;
                                        };

                                    //total_70yrs_and_more
                                        $total_70yrs_and_more = $ins_admission_m_70yrs_and_more + $ins_death_m_70yrs_and_more + 
                                        $ins_admission_f_70yrs_and_more + $ins_death_f_70yrs_and_more + $non_ins_admission_m_70yrs_and_more + 
                                        $non_ins_death_m_70yrs_and_more + $non_ins_admission_f_70yrs_and_more + $non_ins_death_f_70yrs_and_more;
                                    
                                        echo'<tr>
                                            <td class="action-td">70 Years and above</td>
                                            <td class="action-td">'.$ins_admission_m_70yrs_and_more.'</td>
                                            <td class="action-td">'.$ins_death_m_70yrs_and_more.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$ins_admission_f_70yrs_and_more.'</td>
                                            <td class="action-td">'.$ins_death_f_70yrs_and_more.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_m_70yrs_and_more.'</td>
                                            <td class="action-td">'.$non_ins_death_m_70yrs_and_more.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td">'.$non_ins_admission_f_70yrs_and_more.'</td>
                                            <td class="action-td">'.$non_ins_death_f_70yrs_and_more.'</td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_70yrs_and_more.'</strong></td>
                                        </tr>';
                                        
                                        $total_ins_admission_m = $ins_admission_m_0_28days + $ins_admission_m_1_11Months + 
                                        $ins_admission_m_1_4yrs + $ins_admission_m_5_9yrs + $ins_admission_m_10_14yrs +
                                        $ins_admission_m_15_17yrs + $ins_admission_m_18_19yrs + $ins_admission_m_20_34yrs + 
                                        $ins_admission_m_35_49yrs + $ins_admission_m_50_59yrs + $ins_admission_m_60_69yrs + 
                                        $ins_admission_m_70yrs_and_more;

                                        $total_ins_death_m = $ins_death_m_0_28days + $ins_death_m_1_11Months + $ins_death_m_1_4yrs + 
                                        $ins_death_m_5_9yrs + $ins_death_m_10_14yrs +
                                        $ins_death_m_15_17yrs + $ins_death_m_18_19yrs + $ins_death_m_20_34yrs + 
                                        $ins_death_m_35_49yrs + $ins_death_m_50_59yrs + $ins_death_m_60_69yrs + 
                                        $ins_death_m_70yrs_and_more;

                                        $total_ins_admission_f = $ins_admission_f_0_28days + $ins_admission_f_1_11Months + 
                                        $ins_admission_f_1_4yrs + 
                                        $ins_admission_f_5_9yrs + $ins_admission_f_10_14yrs + 
                                        $ins_admission_f_15_17yrs + $ins_admission_f_18_19yrs + $ins_admission_f_20_34yrs +
                                        $ins_admission_f_35_49yrs + $ins_admission_f_50_59yrs + $ins_admission_f_60_69yrs +
                                        $ins_admission_f_70yrs_and_more ;

                                        $total_ins_death_f = $ins_death_f_0_28days + $ins_death_f_1_11Months + $ins_death_f_1_4yrs + 
                                        $ins_death_f_5_9yrs +$ins_death_f_10_14yrs + 
                                        $ins_death_f_15_17yrs + $ins_death_f_18_19yrs + $ins_death_f_20_34yrs + 
                                        $ins_death_f_35_49yrs + $ins_death_f_50_59yrs + $ins_death_f_60_69yrs + 
                                        $ins_death_f_70yrs_and_more;

                                        $total_non_ins_admission_m = $non_ins_admission_m_0_28days + $non_ins_admission_m_1_11Months + 
                                        $non_ins_admission_m_1_4yrs + $non_ins_admission_m_5_9yrs +
                                        $non_ins_admission_m_10_14yrs + $non_ins_admission_m_15_17yrs + $non_ins_admission_m_18_19yrs + 
                                        $non_ins_admission_m_20_34yrs + $non_ins_admission_m_35_49yrs + $non_ins_admission_m_50_59yrs +
                                        $non_ins_admission_m_60_69yrs + $non_ins_admission_m_70yrs_and_more;

                                        $total_non_ins_death_m = $non_ins_death_m_0_28days + $non_ins_death_m_1_11Months + 
                                        $non_ins_death_m_1_4yrs + $non_ins_death_m_5_9yrs + 
                                        $non_ins_death_m_10_14yrs + $non_ins_death_m_15_17yrs + $non_ins_death_m_18_19yrs +
                                        $non_ins_death_m_20_34yrs + $non_ins_death_m_35_49yrs + $non_ins_death_m_50_59yrs +
                                        $non_ins_death_m_60_69yrs + $non_ins_death_m_70yrs_and_more;

                                        $total_non_ins_admission_f = $non_ins_admission_f_0_28days + $non_ins_admission_f_1_11Months + 
                                        $non_ins_admission_f_1_4yrs + $non_ins_admission_f_5_9yrs + 
                                        $non_ins_admission_f_10_14yrs + $non_ins_admission_f_15_17yrs + $non_ins_admission_f_18_19yrs + 
                                        $non_ins_admission_f_20_34yrs + $non_ins_admission_f_35_49yrs + $non_ins_admission_f_50_59yrs +
                                        $non_ins_admission_f_60_69yrs + $non_ins_admission_f_70yrs_and_more;

                                        $total_non_ins_death_f = $non_ins_death_f_0_28days + $non_ins_death_f_1_11Months + 
                                        $non_ins_death_f_1_4yrs + $non_ins_death_f_5_9yrs + 
                                        $non_ins_death_f_10_14yrs + $non_ins_death_f_15_17yrs + $non_ins_death_f_18_19yrs +
                                        $non_ins_death_f_20_34yrs + $non_ins_death_f_35_49yrs + $non_ins_death_f_50_59yrs +
                                        $non_ins_death_f_60_69yrs + $non_ins_death_f_70yrs_and_more;

                                        $grand_total = $total_0_28days + $total_1_11Months + $total_1_4yrs + $total_5_9yrs + 
                                        $total_10_14yrs + $total_15_17yrs + $total_18_19yrs + $total_20_34yrs + $total_35_49yrs + 
                                        $total_50_59yrs + $total_60_69yrs + $total_70yrs_and_more;

                                        echo'<tr>
                                            <td class="action-td"><strong>TOTAL</strong></td>
                                            <td class="action-td"><strong>'.$total_ins_admission_m.'</strong></td>
                                            <td class="action-td"><strong>'.$total_ins_death_m.'</strong></td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_ins_admission_f.'</strong></td>
                                            <td class="action-td"><strong>'.$total_ins_death_f.'</strong></td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_non_ins_admission_m.'</strong></td>
                                            <td class="action-td"><strong>'.$total_non_ins_death_m.'</strong></td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$total_non_ins_admission_f.'</strong></td>
                                            <td class="action-td"><strong>'.$total_non_ins_death_f.'</strong></td>
                                            <td class="action-td"></td>
                                            <td class="action-td"><strong>'.$grand_total.'</strong></td>
                                        </tr>';
                    ?>
                </tbody>
            </table>
    <?php
    };
    ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>