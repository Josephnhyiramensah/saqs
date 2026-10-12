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
        if(isset($_SESSION['lab_occurance_start_date']))
        {           
            $company_id = $_SESSION['company_id'];
            $start_date = $_SESSION['lab_occurance_start_date'];
            $end_date = $_SESSION['lab_occurance_end_date'];
            $type = $_SESSION['lab_occurance_type'];
            $branch = $_SESSION['lab_occurance_branch'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    
            if($type == 'LAB_OCCURANCE')
            {
                echo '<table class="table table-hover table-bordered table-sm" id="incidence_of_disease_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" colspan="3"><H2>'.$row_company['trading_name'].'</H2></th>
                        </tr>
                        <tr>
                            <th class = "action-td" colspan="3"><H6>LABORATORY TEST OCCURANCE FROM '.$start_date.' TO '.$end_date.'</H6></th>
                        </tr>
                        
                        <tr>
                            <th class="action-td">S/NO</th>
                            <th>TEST</th>
                            <th class="action-td">OCCURANCE</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body" id="lab_occurance_list_table_body">';
                        
                            $sql_lab = "SELECT * FROM lab ORDER BY lab ASC";
                            $result_lab = mysqli_query($con,$sql_lab);
                            if(mysqli_num_rows($result_lab) > 0)
                            {
                                $i = 0;
                                while($row_lab = mysqli_fetch_array($result_lab))
                                {
                                    $lab_id = $row_lab['lab_id'];
                                    if($branch == 'ALL')
                                    {
                                        $sql_llcount = "SELECT count(lab_id) AS count FROM lab_list WHERE lab_id='$lab_id'
                                        AND date BETWEEN '$start_date' AND '$end_date'";
                                    }
                                    else
                                    {
                                        $sql_llcount = "SELECT count(lab_id) AS count FROM lab_list WHERE lab_id='$lab_id'
                                        AND date BETWEEN '$start_date' AND '$end_date' AND branch_id='$branch'";
                                    };
                                    $result_llcount = mysqli_query($con,$sql_llcount);
                                    if(mysqli_num_rows($result_llcount) > 0)
                                    {
                                        $row_llcount = mysqli_fetch_array($result_llcount);
                                        if($row_llcount['count'] > 0)
                                        {
                                            $i++;
                                            echo'<tr>
                                                <td class="action-td">'.$i.'</td>
                                                <td>'.$row_lab['lab'].'</td>
                                                <td class="action-td"><strong>'.$row_llcount['count'].'</strong></td>
                                            </tr>';
                                        };
                                    };
                                };
                            };
                            
                    echo '</tbody>
                </table>';
            };
    
            if($type == 'LAB_REGISTER')
            {
                echo '<table class="table table-hover table-bordered table-sm" id="register_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" colspan="5"><H2>'.$row_company['trading_name'].'</H2></th>
                        </tr>
                        <tr>
                            <th class = "action-td" colspan="5"><H6>LABORATORY REGISTER FROM '.$start_date.' TO '.$end_date.'</H6></th>
                        </tr>
                        
                        <tr>
                            <th class="action-td">S/NO</th>
                            <th class="action-td">DATE</th>
                            <th class="action-td">NAME</th>
                            <th class="action-td">AGE</th>
                            <th class="action-td">TEST</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body" id="lab_occurance_list_table_body">';
                        
                        $i = 0;
                        if($branch == 'ALL')
                        {
                            $sql = "SELECT sl.*, p.firstName, p.lastName, a.age, s.lab FROM lab_list sl 
                            JOIN lab s ON sl.lab_id = s.lab_id 
                            JOIN patients p ON sl.patient_id = p.patient_id
                            JOIN attendance a ON a.attend_id = sl.attend_id WHERE
                            sl.date BETWEEN '$start_date' AND '$end_date' ORDER BY sl.date ASC";
                        }
                        else
                        {
                            $sql = "SELECT sl.*, p.firstName, p.lastName, a.age, s.lab FROM lab_list sl 
                            JOIN lab s ON sl.lab_id = s.lab_id 
                            JOIN patients p ON sl.patient_id = p.patient_id
                            JOIN attendance a ON a.attend_id = sl.attend_id WHERE
                            sl.date BETWEEN '$start_date' AND '$end_date' AND a.branch_id='$branch' ORDER BY sl.date ASC";
                        };
                        $result = mysqli_query($con,$sql);
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_array($result))
                            {
                                $i++;
                                echo'<tr>
                                    <td class="action-td">'.$i.'</td>
                                    <td class="action-td">'.$row['date'].'</td>
                                    <td>'.$row['firstName'].' '.$row['lastName'].'</td>
                                    <td class="action-td">'.$row['age'].'</td>
                                    <td>'.$row['lab'].'</td>
                                </tr>';
                            };
                        };
                            
                    echo '</tbody>
                </table>';
            };
    
            if($type == 'DELIVERY_REGISTER')
            {
                echo '<table class="table table-hover table-bordered table-sm" id="register_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" colspan="5"><H2>'.$row_company['trading_name'].'</H2></th>
                        </tr>
                        <tr>
                            <th class = "action-td" colspan="5"><H6>DELIVERY REGISTER FROM '.$start_date.' TO '.$end_date.'</H6></th>
                        </tr>
                        
                        <tr>
                            <th class="action-td">S/NO</th>
                            <th class="action-td">DATE</th>
                            <th class="action-td">NAME</th>
                            <th class="action-td">AGE</th>
                            <th class="action-td">PROCEDURE</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body" id="lab_occurance_list_table_body">';
                        
                        $i = 0;
                        if($branch == 'ALL')
                        {
                            $sql = "SELECT sl.*, p.firstName, p.lastName, a.age, s.surgery FROM surgery_list sl 
                            JOIN surgery s ON sl.surgery_id = s.surgery_id 
                            JOIN patients p ON sl.patient_id = p.patient_id
                            JOIN attendance a ON a.attend_id = sl.attend_id WHERE (sl.surgery_id=941 OR
                            sl.surgery_id=1031 OR sl.surgery_id=1030 OR sl.surgery_id=958 OR
                            sl.surgery_id=944 OR sl.surgery_id=810) AND
                            sl.date BETWEEN '$start_date' AND '$end_date' ORDER BY sl.date ASC";
                        }
                        else
                        {
                            $sql = "SELECT sl.*, p.firstName, p.lastName, a.age, s.surgery FROM surgery_list sl 
                            JOIN surgery s ON sl.surgery_id = s.surgery_id 
                            JOIN patients p ON sl.patient_id = p.patient_id
                            JOIN attendance a ON a.attend_id = sl.attend_id WHERE (sl.surgery_id=941 OR
                            sl.surgery_id=1031 OR sl.surgery_id=1030 OR sl.surgery_id=958 OR
                            sl.surgery_id=944 OR sl.surgery_id=810) AND
                            sl.date BETWEEN '$start_date' AND '$end_date' AND a.branch_id='$branch' ORDER BY sl.date ASC";
                        };
                        $result = mysqli_query($con,$sql);
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_array($result))
                            {
                                $i++;
                                echo'<tr>
                                    <td class="action-td">'.$i.'</td>
                                    <td class="action-td">'.$row['date'].'</td>
                                    <td>'.$row['firstName'].' '.$row['lastName'].'</td>
                                    <td class="action-td">'.$row['age'].'</td>
                                    <td>'.$row['surgery'].'</td>
                                </tr>';
                            };
                        };
                            
                    echo '</tbody>
                </table>';
            };
    
            if($type == 'ANC_REGISTER')
            {
                echo '<table class="table table-hover table-bordered table-sm" id="register_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" colspan="5"><H2>'.$row_company['trading_name'].'</H2></th>
                        </tr>
                        <tr>
                            <th class = "action-td" colspan="5"><H6>ANTENATAL REGISTER FROM '.$start_date.' TO '.$end_date.'</H6></th>
                        </tr>
                        
                        <tr>
                            <th class="action-td">S/NO</th>
                            <th class="action-td">DATE</th>
                            <th class="action-td">NAME</th>
                            <th class="action-td">AGE</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body" id="lab_occurance_list_table_body">';
                        
                        $i = 0;
                        if($branch == 'ALL')
                        {
                            $sql = "SELECT a.*, p.firstName, p.lastName, a.age FROM attendance a 
                            JOIN patients p ON a.patient_id = p.patient_id WHERE a.clinic_id=30 AND
                            a.date_admit BETWEEN '$start_date' AND '$end_date' ORDER BY a.date_admit ASC";
                        }
                        else
                        {
                            $sql = "SELECT a.*, p.firstName, p.lastName, a.age FROM attendance a 
                            JOIN patients p ON a.patient_id = p.patient_id WHERE a.clinic_id=30 AND
                            a.date_admit BETWEEN '$start_date' AND '$end_date' AND a.branch_id='$branch' 
                            ORDER BY a.date_admit ASC";
                        };
                        $result = mysqli_query($con,$sql);
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_array($result))
                            {
                                $i++;
                                echo'<tr>
                                    <td class="action-td">'.$i.'</td>
                                    <td class="action-td">'.$row['date_admit'].'</td>
                                    <td>'.$row['firstName'].' '.$row['lastName'].'</td>
                                    <td class="action-td">'.$row['age'].'</td>
                                </tr>';
                            };
                        };
                            
                    echo '</tbody>
                </table>';
            };
    
            if($type == 'DETENTION_REGISTER')
            {
                echo '<table class="table table-hover table-bordered table-sm" id="register_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" colspan="5"><H2>'.$row_company['trading_name'].'</H2></th>
                        </tr>
                        <tr>
                            <th class = "action-td" colspan="5"><H6>DETENTION REGISTER FROM '.$start_date.' TO '.$end_date.'</H6></th>
                        </tr>
                        
                        <tr>
                            <th class="action-td">S/NO</th>
                            <th class="action-td">DATE</th>
                            <th class="action-td">NAME</th>
                            <th class="action-td">AGE</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body" id="lab_occurance_list_table_body">';
                        
                        $i = 0;
                        if($branch == 'ALL')
                        {
                            $sql = "SELECT sl.*, p.firstName, p.lastName, a.age, a.date_admit FROM service_list sl 
                            JOIN attendance a ON a.attend_id = sl.attend_id 
                            JOIN patients p ON a.patient_id = p.patient_id WHERE sl.service_id=23 AND
                            a.date_admit BETWEEN '$start_date' AND '$end_date' ORDER BY a.date_admit ASC";
                        }
                        else
                        {
                            $sql = "SELECT sl.*, p.firstName, p.lastName, a.age, a.date_admit FROM service_list sl 
                            JOIN attendance a ON a.attend_id = sl.attend_id 
                            JOIN patients p ON a.patient_id = p.patient_id WHERE sl.service_id=23 AND
                            a.date_admit BETWEEN '$start_date' AND '$end_date' AND a.branch_id='$branch' ORDER BY a.date_admit ASC";
                        };
                        $result = mysqli_query($con,$sql);
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_array($result))
                            {
                                $i++;
                                echo'<tr>
                                    <td class="action-td">'.$i.'</td>
                                    <td class="action-td">'.$row['date_admit'].'</td>
                                    <td>'.$row['firstName'].' '.$row['lastName'].'</td>
                                    <td class="action-td">'.$row['age'].'</td>
                                </tr>';
                            };
                        };
                            
                    echo '</tbody>
                </table>';
            };
    
            if($type == 'PROCEDURE_REGISTER')
            {
                echo '<table class="table table-hover table-bordered table-sm" id="register_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" colspan="5"><H2>'.$row_company['trading_name'].'</H2></th>
                        </tr>
                        <tr>
                            <th class = "action-td" colspan="5"><H6>PROCEDURE REGISTER FROM '.$start_date.' TO '.$end_date.'</H6></th>
                        </tr>
                        
                        <tr>
                            <th class="action-td">S/NO</th>
                            <th class="action-td">DATE</th>
                            <th class="action-td">NAME</th>
                            <th class="action-td">AGE</th>
                            <th class="action-td">PROCEDURE</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body" id="lab_occurance_list_table_body">';
                        
                        $i = 0;
                        if($branch == 'ALL')
                        {
                            $sql = "SELECT sl.*, p.firstName, p.lastName, a.age, s.surgery FROM surgery_list sl 
                            JOIN surgery s ON sl.surgery_id = s.surgery_id 
                            JOIN patients p ON sl.patient_id = p.patient_id
                            JOIN attendance a ON a.attend_id = sl.attend_id WHERE
                            sl.date BETWEEN '$start_date' AND '$end_date' ORDER BY sl.date ASC";
                        }
                        else
                        {
                            $sql = "SELECT sl.*, p.firstName, p.lastName, a.age, s.surgery FROM surgery_list sl 
                            JOIN surgery s ON sl.surgery_id = s.surgery_id 
                            JOIN patients p ON sl.patient_id = p.patient_id
                            JOIN attendance a ON a.attend_id = sl.attend_id WHERE
                            sl.date BETWEEN '$start_date' AND '$end_date' AND a.branch_id='$branch' ORDER BY sl.date ASC";
                        };
                        $result = mysqli_query($con,$sql);
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_array($result))
                            {
                                $i++;
                                echo'<tr>
                                    <td class="action-td">'.$i.'</td>
                                    <td class="action-td">'.$row['date'].'</td>
                                    <td>'.$row['firstName'].' '.$row['lastName'].'</td>
                                    <td class="action-td">'.$row['age'].'</td>
                                    <td>'.$row['surgery'].'</td>
                                </tr>';
                            };
                        };
                            
                    echo '</tbody>
                </table>';
            };
    
            if($type == 'PROCEDURE_OCCURANCE')
            {
                echo '<table class="table table-hover table-bordered table-sm" id="register_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" colspan="3"><H2>'.$row_company['trading_name'].'</H2></th>
                        </tr>
                        <tr>
                            <th class = "action-td" colspan="3"><H6>PROCEDURE OCCURANCE FROM '.$start_date.' TO '.$end_date.'</H6></th>
                        </tr>
                        
                        <tr>
                            <th class="action-td">S/NO</th>
                            <th>PROCEDURE</th>
                            <th class="action-td">OCCURANCE</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body" id="lab_occurance_list_table_body">';
                        
                            $sql_surgery = "SELECT * FROM surgery ORDER BY surgery ASC";
                            $result_surgery = mysqli_query($con,$sql_surgery);
                            if(mysqli_num_rows($result_surgery) > 0)
                            {
                                $i = 0;
                                while($row_surgery = mysqli_fetch_array($result_surgery))
                                {
                                    $surgery_id = $row_surgery['surgery_id'];
                                    
                                    if($branch == 'ALL')
                                    {
                                        $sql_slcount = "SELECT count(surgery_id) AS count FROM surgery_list WHERE surgery_id='$surgery_id'
                                        AND date BETWEEN '$start_date' AND '$end_date'";
                                    }
                                    else
                                    {
                                        $sql_slcount = "SELECT count(surgery_id) AS count FROM surgery_list WHERE surgery_id='$surgery_id'
                                        AND date BETWEEN '$start_date' AND '$end_date' AND branch_id='$branch'";
                                    };
                                    $result_slcount = mysqli_query($con,$sql_slcount);
                                    if(mysqli_num_rows($result_slcount) > 0)
                                    {
                                        $row_slcount = mysqli_fetch_array($result_slcount);
                                        if($row_slcount['count'] > 0)
                                        {
                                            $i++;
                                            echo'<tr>
                                                <td class="action-td">'.$i.'</td>
                                                <td>'.$row_surgery['surgery'].'</td>
                                                <td class="action-td"><strong>'.$row_slcount['count'].'</strong></td>
                                            </tr>';
                                        };
                                    };
                                };
                            };
                            
                    echo '</tbody>
                </table>';
            };
    
            if($type == 'CIRCUMCISION_REGISTER')
            {
                echo '<table class="table table-hover table-bordered table-sm" id="register_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" colspan="5"><H2>'.$row_company['trading_name'].'</H2></th>
                        </tr>
                        <tr>
                            <th class = "action-td" colspan="5"><H6>CIRCUMCISION REGISTER FROM '.$start_date.' TO '.$end_date.'</H6></th>
                        </tr>
                        
                        <tr>
                            <th class="action-td">S/NO</th>
                            <th class="action-td">DATE</th>
                            <th class="action-td">NAME</th>
                            <th class="action-td">AGE</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body" id="lab_occurance_list_table_body">';
                        
                        $i = 0;
                        if($branch == 'ALL')
                        {
                            $sql = "SELECT sl.*, p.firstName, p.lastName, a.age, a.date_admit FROM service_list sl 
                            JOIN attendance a ON a.attend_id = sl.attend_id 
                            JOIN patients p ON a.patient_id = p.patient_id WHERE sl.service_id=42 AND
                            a.date_admit BETWEEN '$start_date' AND '$end_date' ORDER BY a.date_admit ASC";
                        }
                        else
                        {
                            $sql = "SELECT sl.*, p.firstName, p.lastName, a.age, a.date_admit FROM service_list sl 
                            JOIN attendance a ON a.attend_id = sl.attend_id 
                            JOIN patients p ON a.patient_id = p.patient_id WHERE sl.service_id=42 AND
                            a.date_admit BETWEEN '$start_date' AND '$end_date' AND a.branch_id='$branch' ORDER BY a.date_admit ASC";
                        };
                        $result = mysqli_query($con,$sql);
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_array($result))
                            {
                                $i++;
                                echo'<tr>
                                    <td class="action-td">'.$i.'</td>
                                    <td class="action-td">'.$row['date_admit'].'</td>
                                    <td>'.$row['firstName'].' '.$row['lastName'].'</td>
                                    <td class="action-td">'.$row['age'].'</td>
                                </tr>';
                            };
                        };
                            
                    echo '</tbody>
                </table>';
            };
    
            if($type == 'OPD_REGISTER')
            {
                echo '<table class="table table-hover table-bordered table-sm" id="register_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" colspan="6"><H2>'.$row_company['trading_name'].'</H2></th>
                        </tr>
                        <tr>
                            <th class = "action-td" colspan="6"><H6>OPD REGISTER FROM '.$start_date.' TO '.$end_date.'</H6></th>
                        </tr>
                        
                        <tr>
                            <th class="action-td">S/NO</th>
                            <th class="action-td">DATE</th>
                            <th class="action-td">NAME</th>
                            <th class="action-td">AGE</th>
                            <th class="action-td">SEX</th>
                            <th class="action-td">CLINIC</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body" id="lab_occurance_list_table_body">';
                        
                        $i = 0;
                        if($branch == 'ALL')
                        {
                            $sql = "SELECT a.*, p.firstName, p.lastName, a.age, a.date_admit, a.date_disch, g.gender, 
                            c.clinic_desc FROM attendance a JOIN clinics c ON a.clinic_id = c.clinic_id 
                            JOIN patients p ON a.patient_id = p.patient_id JOIN gender g ON p.gender=g.gender_id 
                            WHERE a.tos_id=1 AND a.date_admit BETWEEN '$start_date' AND '$end_date' ORDER BY a.date_admit ASC";
                        }
                        else
                        {
                            $sql = "SELECT a.*, p.firstName, p.lastName, a.age, a.date_admit, a.date_disch, g.gender, 
                            c.clinic_desc FROM attendance a JOIN clinics c ON a.clinic_id = c.clinic_id 
                            JOIN patients p ON a.patient_id = p.patient_id JOIN gender g ON p.gender=g.gender_id 
                            WHERE a.tos_id=1 AND a.date_admit BETWEEN '$start_date' AND '$end_date' AND a.branch_id='$branch'
                            ORDER BY a.date_admit ASC";
                        };
                        $result = mysqli_query($con,$sql);
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_array($result))
                            {
                                $i++;
                                echo'<tr>
                                    <td class="action-td">'.$i.'</td>
                                    <td class="action-td">'.$row['date_admit'].'</td>
                                    <td>'.$row['firstName'].' '.$row['lastName'].'</td>
                                    <td class="action-td">'.$row['age'].'</td>
                                    <td class="action-td">'.$row['gender'].'</td>
                                    <td class="action-td">'.$row['clinic_desc'].'</td>
                                </tr>';
                            };
                        };
                            
                    echo '</tbody>
                </table>';
            };
    
            if($type == 'IPD_REGISTER')
            {
                echo '<table class="table table-hover table-bordered table-sm" id="register_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" colspan="8"><H2>'.$row_company['trading_name'].'</H2></th>
                        </tr>
                        <tr>
                            <th class = "action-td" colspan="8"><H6>IPD REGISTER FROM '.$start_date.' TO '.$end_date.'</H6></th>
                        </tr>
                        
                        <tr>
                            <th class="action-td">S/NO</th>
                            <th class="action-td">ADMISSION DATE</th>
                            <th class="action-td">DISCHARGED DATE</th>
                            <th class="action-td">NAME</th>
                            <th class="action-td">AGE</th>
                            <th class="action-td">SEX</th>
                            <th>CLINIC</th>
                            <th>WARD</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body" id="lab_occurance_list_table_body">';
                        
                        $i = 0;
                        if($branch == 'ALL')
                        {
                            $sql = "SELECT a.*, p.firstName, p.lastName, a.age, a.date_admit, a.date_disch, g.gender, 
                            c.clinic_desc, w.ward FROM attendance a JOIN clinics c ON a.clinic_id = c.clinic_id 
                            JOIN patients p ON a.patient_id = p.patient_id JOIN gender g ON p.gender=g.gender_id JOIN
                            wardlist wl ON wl.attend_id=a.attend_id JOIN ward w ON w.ward_id=wl.ward_id
                            WHERE a.tos_id=2 AND a.date_admit BETWEEN '$start_date' AND '$end_date' ORDER BY a.date_admit ASC";
                        }
                        else
                        {
                            $sql = "SELECT a.*, p.firstName, p.lastName, a.age, a.date_admit, a.date_disch, g.gender, 
                            c.clinic_desc, w.ward FROM attendance a JOIN clinics c ON a.clinic_id = c.clinic_id 
                            JOIN patients p ON a.patient_id = p.patient_id JOIN gender g ON p.gender=g.gender_id JOIN
                            wardlist wl ON wl.attend_id=a.attend_id JOIN ward w ON w.ward_id=wl.ward_id
                            WHERE a.tos_id=2 AND a.date_admit BETWEEN '$start_date' AND '$end_date' AND a.branch_id='$branch'
                            ORDER BY a.date_admit ASC";
                        };
                        $result = mysqli_query($con,$sql);
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_array($result))
                            {
                                $i++;
                                echo'<tr>
                                    <td class="action-td">'.$i.'</td>
                                    <td class="action-td">'.$row['date_admit'].'</td>
                                    <td class="action-td">'.$row['date_disch'].'</td>
                                    <td>'.$row['firstName'].' '.$row['lastName'].'</td>
                                    <td class="action-td">'.$row['age'].'</td>
                                    <td class="action-td">'.$row['gender'].'</td>
                                    <td>'.$row['clinic_desc'].'</td>
                                    <td>'.$row['ward'].'</td>
                                </tr>';
                            };
                        };
                            
                    echo '</tbody>
                </table>';
            };
    
            if($type == 'WARD_STATE')
            {
                echo '<table class="table table-hover table-bordered table-sm" id="ward_state_list_table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" colspan="8"><H2>'.$row_company['trading_name'].'</H2></th>
                        </tr>
                        <tr>
                            <th class = "action-td" colspan="8"><H6>WARD STATE FROM '.$start_date.' TO '.$end_date.'</H6></th>
                        </tr>
                        
                        <tr>
                            <th class="action-td">S/NO</th>
                            <th class="action-td">WARD</th>
                            <th class="action-td">PREVIOUS</th>
                            <th class="action-td">ADMISSION</th>
                            <th class="action-td">DISCHARGE</th>
                            <th class="action-td">REMAINING</th>
                            <th>AVAILABLE BEDS</th>
                            <th>EMPTY BEDS</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body" id="ward_state_list_table_body">';
                        
                        $i = 0;
                        $sql_ward = "SELECT * FROM ward ORDER BY ward ASC";
                        $result_ward = mysqli_query($con,$sql_ward);
                        if(mysqli_num_rows($result_ward) > 0)
                        {
                            while($row_ward = mysqli_fetch_array($result_ward))
                            {
                                $ward_id = $row_ward['ward_id'];
                                //WARDLIST
                                    if($branch == 'ALL')
                                    {
                                        $sql_wardlist = "SELECT COUNT(ward_id) AS previous_count FROM wardlist WHERE ward_id='$ward_id' AND 
                                        date_in < '$start_date' AND (date_out = '' OR date_out < '$start_date') GROUP BY ward_id";
                                    }
                                    else
                                    {
                                        $sql_wardlist = "SELECT COUNT(ward_id) AS previous_count FROM wardlist WHERE ward_id='$ward_id' AND 
                                        date_in < '$start_date' AND (date_out = '' OR date_out < '$start_date') AND branch_id='$branch' GROUP BY ward_id";
                                    };
                                    $result_wardlist = mysqli_query($con,$sql_wardlist);
                                    if(mysqli_num_rows($result_wardlist) > 0)
                                    {
                                        $row_wardlist = mysqli_fetch_array($result_wardlist);
                                        $previous_count = $row_wardlist['previous_count'];
                                    }
                                    else
                                    {
                                        $previous_count = 0;
                                    };

                                //ADMISSIONS
                                    if($branch == 'ALL')
                                    {
                                        $sql_admission = "SELECT COUNT(ward_id) AS admissions FROM wardlist WHERE ward_id='$ward_id' AND 
                                        date_in BETWEEN '$start_date' AND '$end_date' GROUP BY ward_id";
                                    }
                                    else
                                    {
                                        $sql_admission = "SELECT COUNT(ward_id) AS admissions FROM wardlist WHERE ward_id='$ward_id' AND 
                                        date_in BETWEEN '$start_date' AND '$end_date' AND branch_id='$branch' GROUP BY ward_id";
                                    };
                                    $result_admission = mysqli_query($con,$sql_admission);
                                    if(mysqli_num_rows($result_admission) > 0)
                                    {
                                        $row_admission = mysqli_fetch_array($result_admission);
                                        $admissions = $row_admission['admissions'];
                                    }
                                    else
                                    {
                                        $admissions = 0;
                                    };

                                //DISCHARGE
                                    if($branch == 'ALL')
                                    {
                                        $sql_discharge = "SELECT COUNT(ward_id) AS discharges FROM wardlist WHERE ward_id='$ward_id' AND 
                                        date_out BETWEEN '$start_date' AND '$end_date' GROUP BY ward_id";
                                    }
                                    else
                                    {
                                        $sql_discharge = "SELECT COUNT(ward_id) AS discharges FROM wardlist WHERE ward_id='$ward_id' AND 
                                        date_out BETWEEN '$start_date' AND '$end_date' AND branch_id='$branch' GROUP BY ward_id";
                                    };
                                    $result_discharge = mysqli_query($con, $sql_discharge);
                                    if(mysqli_num_rows($result_discharge) > 0)
                                    {
                                        $row_discharge = mysqli_fetch_array($result_discharge);
                                        $discharges = $row_discharge['discharges'];
                                    }
                                    else
                                    {
                                        $discharges = 0;
                                    };

                                //NO_OF_BEDS
                                    $sql_bed = "SELECT COUNT(ward_id) AS no_of_bed FROM bed WHERE ward_id='$ward_id' GROUP BY ward_id";
                                    $result_bed = mysqli_query($con,$sql_bed);
                                    if(mysqli_num_rows($result_bed) > 0)
                                    {
                                        $row_bed = mysqli_fetch_array($result_bed);
                                        $no_of_bed = $row_bed['no_of_bed'];
                                    }
                                    else
                                    {
                                        $no_of_bed = 0;
                                    };
                                
                                //REMAINING
                                    $remaining = ($previous_count + $admissions - $discharges);
                                    $available_beds = $no_of_bed - $remaining;
                                $i++;
                                echo'<tr>
                                    <td class="action-td">'.$i.'</td>
                                    <td class="action-td">'.$row_ward['ward'].'</td>
                                    <td class="action-td">'.$previous_count.'</td>
                                    <td class="action-td">'.$admissions.'</td>
                                    <td class="action-td">'.$discharges.'</td>
                                    <td class="action-td">'.$remaining.'</td>
                                    <td class="action-td">'.$no_of_bed.'</td>
                                    <td class="action-td">'.$available_beds.'</td>
                                </tr>';
                            };
                        };
                    echo '</tbody>
                </table>';
            };
    };
    ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>