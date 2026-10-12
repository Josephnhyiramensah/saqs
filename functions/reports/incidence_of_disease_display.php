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
        if(isset($_SESSION['incidence_of_disease_start_date']))
        {           
            $company_id = $_SESSION['company_id'];
            $start_date = $_SESSION['incidence_of_disease_start_date'];
            $end_date = $_SESSION['incidence_of_disease_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
            <table class="table table-hover table-bordered table-sm" id="incidence_of_disease_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="29"><H2><?php echo $row_company['trading_name'];?></H2></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="29"><H6>INCIDENCE OF DISEASES FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                    </tr>
                    
                    <tr>
                        <th class="action-td" colspan="2">PARTICULARS</th>
                        <th class="action-td" colspan="13">MALE</th>
                        <th class="action-td" colspan="13">FEMALE</th>
                        <th class="action-td">TOTAL</th>
                    </tr>
                    <tr>
                        <th class="action-td">S/NO</th>
                        <th class="action-td">DISEASE</th>
                        <th class="action-td">0-28Days</th>
                        <th class="action-td">1-11Months</th>
                        <th class="action-td">1-4Yrs</th>
                        <th class="action-td">5-9Yrs</th>
                        <th class="action-td">10-14Yrs</th>
                        <th class="action-td">15-17Yrs</th>
                        <th class="action-td">18-19Yrs</th>
                        <th class="action-td">20-34Yrs</th>
                        <th class="action-td">35-49Yrs</th>
                        <th class="action-td">50-59Yrs</th>
                        <th class="action-td">60-69Yrs</th>
                        <th class="action-td">Above 70Yrs</th>
                        <th class="action-td">Total Male</th>
                        <th class="action-td">0-28Days</th>
                        <th class="action-td">1-11Months</th>
                        <th class="action-td">1-4Yrs</th>
                        <th class="action-td">5-9Yrs</th>
                        <th class="action-td">10-14Yrs</th>
                        <th class="action-td">15-17Yrs</th>
                        <th class="action-td">18-19Yrs</th>
                        <th class="action-td">20-34Yrs</th>
                        <th class="action-td">35-49Yrs</th>
                        <th class="action-td">50-59Yrs</th>
                        <th class="action-td">60-69Yrs</th>
                        <th class="action-td">Above 70Yrs</th>
                        <th class="action-td">Total Female</th>
                        <th class="action-td">Grand Total</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body" id="ledger_report_list_table_body">
                    <?php
                        $m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;
                        $m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;$m_50_59yrs = 0;
                        $m_60_69yrs = 0;$m_70_more = 0;$m_total = 0;$f_0_28days = 0;$f_1_11months = 0;
                        $f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;
                        $f_20_34yrs = 0;$f_35_49yrs = 0;$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;
                        $f_total = 0;$m_f_total = 0;

                        $m_0_28days_sum = 0;$m_1_11months_sum = 0;$m_1_4yrs_sum = 0;$m_5_9yrs_sum = 0;$m_10_14yrs_sum = 0;
                        $m_15_17yrs_sum = 0;$m_18_19yrs_sum = 0;$m_20_34yrs_sum = 0;$m_35_49yrs_sum = 0;$m_50_59yrs_sum = 0;
                        $m_60_69yrs_sum = 0;$m_70_more_sum = 0;$m_total_sum = 0;$f_0_28days_sum = 0;$f_1_11months_sum = 0;
                        $f_1_4yrs_sum = 0;$f_5_9yrs_sum = 0;$f_10_14yrs_sum = 0;$f_15_17yrs_sum = 0;$f_18_19yrs_sum = 0;
                        $f_20_34yrs_sum = 0;$f_35_49yrs_sum = 0;$f_50_59yrs_sum = 0;$f_60_69yrs_sum = 0;$f_70_more_sum = 0;
                        $f_total_sum = 0;$m_f_total_sum = 0;

                        
                        $sql_diagnosis = "SELECT * FROM diagnosis ORDER BY diagnosis ASC";
                        $result_diagnosis = mysqli_query($con,$sql_diagnosis);
                        if(mysqli_num_rows($result_diagnosis) > 0)
                        {
                            $i = 0;
                            while($row_diagnosis = mysqli_fetch_array($result_diagnosis))
                            {
                                $diagnosis_id = $row_diagnosis['diagnosis_id'];
                                
                                $sql_dlcount = "SELECT * FROM diagnosis_list WHERE diagnosis_id='$diagnosis_id'";
                                $result_dlcount = mysqli_query($con,$sql_dlcount);
                                if(mysqli_num_rows($result_dlcount) > 0)
                                {
                                    $i = ++$i;
                                    $m_total = 0;
                                    $f_total = 0;
                                    $m_f_total = 0;
                                    //m_0_28days
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 0 AND 28 AND p.gender=2";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $m_0_28days = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $m_0_28days = 0;
                                        };
                                        $m_0_28days_sum = $m_0_28days_sum + $m_0_28days;

                                    //m_1_11months
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND DATEDIFF(CURRENT_DATE(), p.DOB) BETWEEN 29 AND 330 AND p.gender=1";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $m_1_11months = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $m_1_11months = 0;
                                        };
                                        $m_1_11months_sum = $m_1_11months_sum + $m_1_11months;

                                    //m_1_4yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 1 AND 4 AND p.gender=1";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $m_1_4yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $m_1_4yrs = 0;
                                        };
                                        $m_1_4yrs_sum = $m_1_4yrs_sum + $m_1_4yrs;

                                    //m_5_9yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 5 AND 9 AND p.gender=1";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $m_5_9yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $m_5_9yrs = 0;
                                        };
                                        $m_5_9yrs_sum = $m_5_9yrs_sum + $m_5_9yrs;

                                    //m_10_14yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 10 AND 14 AND p.gender=1";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $m_10_14yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $m_10_14yrs = 0;
                                        };
                                        $m_10_14yrs_sum = $m_10_14yrs_sum + $m_10_14yrs;

                                    //m_15_17yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 15 AND 17 AND p.gender=1";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $m_15_17yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $m_15_17yrs = 0;
                                        };
                                        $m_15_17yrs_sum = $m_15_17yrs_sum + $m_15_17yrs;

                                    //m_18_19yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 18 AND 19 AND p.gender=1";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $m_18_19yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $m_18_19yrs = 0;
                                        };
                                        $m_18_19yrs_sum = $m_18_19yrs_sum + $m_18_19yrs;

                                    //m_20_34yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 20 AND 34 AND p.gender=1";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $m_20_34yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $m_20_34yrs = 0;
                                        };
                                        $m_20_34yrs_sum = $m_20_34yrs_sum + $m_20_34yrs;

                                    //m_35_49yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 35 AND 49 AND p.gender=1";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $m_35_49yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $m_35_49yrs = 0;
                                        };
                                        $m_35_49yrs_sum = $m_35_49yrs_sum + $m_35_49yrs;

                                    //m_50_59yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 50 AND 59 AND p.gender=1";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $m_50_59yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $m_50_59yrs = 0;
                                        };
                                        $m_50_59yrs_sum = $m_50_59yrs_sum + $m_50_59yrs;

                                    //m_60_69yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 60 AND 69 AND p.gender=1";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $m_60_69yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $m_60_69yrs = 0;
                                        };
                                        $m_60_69yrs_sum = $m_60_69yrs_sum + $m_60_69yrs;

                                    //m_70_more
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age > 69 AND p.gender=1";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $m_70_more = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $m_70_more = 0;
                                        };
                                        $m_70_more_sum = $m_70_more_sum + $m_70_more;
                                        
                                    //m_total
                                        $m_total = $m_0_28days + $m_1_11months + $m_1_4yrs + $m_5_9yrs +
                                        $m_10_14yrs + $m_15_17yrs + $m_18_19yrs + $m_20_34yrs + $m_35_49yrs +
                                        $m_50_59yrs + $m_60_69yrs + $m_70_more;
                                        $m_total_sum = $m_total_sum + $m_total;
                                    //f_0_28days
                                        /*$sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 1 AND 4 AND p.gender=2";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $f_0_28days = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $f_0_28days = 0;
                                        };
                                        $f_0_28days_sum = $f_0_28days_sum + $f_0_28days;*/

                                    //f_1_11months
                                        /*$sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 1 AND 4 AND p.gender=2";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $f_1_11months = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $f_1_11months = 0;
                                        };
                                        $f_1_11months_sum = $f_1_11months_sum + $f_1_11months;*/

                                    //f_1_4yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 1 AND 4 AND p.gender=2";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $f_1_4yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $f_1_4yrs = 0;
                                        };
                                        $f_1_4yrs_sum = $f_1_4yrs_sum + $f_1_4yrs;

                                    //f_5_9yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 5 AND 9 AND p.gender=2";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $f_5_9yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $f_5_9yrs = 0;
                                        };
                                        $f_5_9yrs_sum = $f_5_9yrs_sum + $f_5_9yrs;

                                    //f_10_14yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 10 AND 14 AND p.gender=2";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $f_10_14yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $f_10_14yrs = 0;
                                        };
                                        $f_10_14yrs_sum = $f_10_14yrs_sum + $f_10_14yrs;

                                    //f_15_17yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 15 AND 17 AND p.gender=2";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $f_15_17yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $f_15_17yrs = 0;
                                        };
                                        $f_15_17yrs_sum = $f_15_17yrs_sum + $f_15_17yrs;

                                    //f_18_19yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 18 AND 19 AND p.gender=2";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $f_18_19yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $f_18_19yrs = 0;
                                        };
                                        $f_18_19yrs_sum = $f_18_19yrs_sum + $f_18_19yrs;
                                    
                                    //f_20_34yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 20 AND 34 AND p.gender=2";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $f_20_34yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $f_20_34yrs = 0;
                                        };
                                        $f_20_34yrs_sum = $f_20_34yrs_sum + $f_20_34yrs;

                                    //f_35_49yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 35 AND 49 AND p.gender=2";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $f_35_49yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $f_35_49yrs = 0;
                                        };
                                        $f_35_49yrs_sum = $f_35_49yrs_sum + $f_35_49yrs;

                                    //f_50_59yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 50 AND 59 AND p.gender=2";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $f_50_59yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $f_50_59yrs = 0;
                                        };
                                        $f_50_59yrs_sum = $f_50_59yrs_sum + $f_50_59yrs;

                                    //f_60_69yrs
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age BETWEEN 60 AND 69 AND p.gender=2";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $f_60_69yrs = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $f_60_69yrs = 0;
                                        };
                                        $f_60_69yrs_sum = $f_60_69yrs_sum + $f_60_69yrs;

                                    //f_70_more
                                        $sql_dl = "SELECT dl.date, dl.diagnosis_id, p.DOB, p.patient_id, p.gender, a.attend_id, a.age
                                        FROM diagnosis_list dl
                                        JOIN patients p ON p.patient_id=dl.patient_id
                                        JOIN attendance a ON a.attend_id=dl.attend_id
                                        WHERE dl.date BETWEEN '$start_date' AND '$end_date' 
                                        AND dl.diagnosis_id = '$diagnosis_id' AND a.age > 69 AND p.gender=2";
                                        $result_dl = mysqli_query($con,$sql_dl);
                                        if(mysqli_num_rows($result_dl) > 0)
                                        {
                                            $f_70_more = mysqli_num_rows($result_dl);
                                        }
                                        else
                                        {
                                            $f_70_more = 0;
                                        };
                                        $f_70_more_sum = $f_70_more_sum + $f_70_more;
                                    //f_total
                                        $f_total = $f_0_28days + $f_1_11months + $f_1_4yrs + $f_5_9yrs +
                                        $f_10_14yrs + $f_15_17yrs + $f_18_19yrs + $f_20_34yrs + $f_35_49yrs +
                                        $f_50_59yrs + $f_60_69yrs + $f_70_more;
                                        $f_total_sum = $f_total_sum + $f_total;
                                    //m_f_total
                                        $m_f_total = $m_total + $f_total;
                                        $m_f_total_sum = $m_f_total_sum + $m_f_total;

                                    echo'<tr>
                                        <td class="action-td">'.$i.'</td>
                                        <td>'.$row_diagnosis['diagnosis'].'</td>
                                        <td class="action-td">'.$m_0_28days.'</td>
                                        <td class="action-td">'.$m_1_11months.'</td>
                                        <td class="action-td">'.$m_1_4yrs.'</td>
                                        <td class="action-td">'.$m_5_9yrs.'</td>
                                        <td class="action-td">'.$m_10_14yrs.'</td>
                                        <td class="action-td">'.$m_15_17yrs.'</td>
                                        <td class="action-td">'.$m_18_19yrs.'</td>
                                        <td class="action-td">'.$m_20_34yrs.'</td>
                                        <td class="action-td">'.$m_35_49yrs.'</td>
                                        <td class="action-td">'.$m_50_59yrs.'</td>
                                        <td class="action-td">'.$m_60_69yrs.'</td>
                                        <td class="action-td">'.$m_70_more.'</td>
                                        <td class="action-td"><strong>'.$m_total.'</strong></td>
                                        <td class="action-td">'.$f_0_28days.'</td>
                                        <td class="action-td">'.$f_1_11months.'</td>
                                        <td class="action-td">'.$f_1_4yrs.'</td>
                                        <td class="action-td">'.$f_5_9yrs.'</td>
                                        <td class="action-td">'.$f_10_14yrs.'</td>
                                        <td class="action-td">'.$f_15_17yrs.'</td>
                                        <td class="action-td">'.$f_18_19yrs.'</td>
                                        <td class="action-td">'.$f_20_34yrs.'</td>
                                        <td class="action-td">'.$f_35_49yrs.'</td>
                                        <td class="action-td">'.$f_50_59yrs.'</td>
                                        <td class="action-td">'.$f_60_69yrs.'</td>
                                        <td class="action-td">'.$f_70_more.'</td>
                                        <td class="action-td"><strong>'.$f_total.'</strong></td>
                                        <td class="action-td"><strong>'.$m_f_total.'</strong></td>
                                    </tr>';
                                };
                            };
                            echo'<tr>
                                <td class="action-td" colspan="2"><strong>TOTAL</strong></td>
                                <td class="action-td"><strong>'.$m_0_28days_sum.'</strong></td>
                                <td class="action-td"><strong>'.$m_1_11months_sum.'</strong></td>
                                <td class="action-td"><strong>'.$m_1_4yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$m_5_9yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$m_10_14yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$m_15_17yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$m_18_19yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$m_20_34yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$m_35_49yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$m_50_59yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$m_60_69yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$m_70_more_sum.'</strong></td>
                                <td class="action-td"><strong>'.$m_total_sum.'</strong></td>
                                <td class="action-td"><strong>'.$f_0_28days_sum.'</strong></td>
                                <td class="action-td"><strong>'.$f_1_11months_sum.'</strong></td>
                                <td class="action-td"><strong>'.$f_1_4yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$f_5_9yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$f_10_14yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$f_15_17yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$f_18_19yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$f_20_34yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$f_35_49yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$f_50_59yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$f_60_69yrs_sum.'</strong></td>
                                <td class="action-td"><strong>'.$f_70_more_sum.'</strong></td>
                                <td class="action-td"><strong>'.$f_total_sum.'</strong></td>
                                <td class="action-td"><strong>'.$m_f_total_sum.'</strong></td>
                            </tr>';
                        };
                        
                    ?>
                </tbody>
            </table>
    <?php
    };
    ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>