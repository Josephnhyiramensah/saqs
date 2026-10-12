    <?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');

    $appoint_type = $_SESSION['appoint_type'];
    $appoint_doctor = $_SESSION['appoint_doctor'];
    $appoint_theatre = $_SESSION['appoint_theatre'];
    $appoint_start = $_SESSION['appoint_start'];
    $appoint_end = $_SESSION['appoint_end'];
    $appoint_branch = $_SESSION['appoint_branch'];
    if($appoint_branch=='ALL')
    {
        if($appoint_type == 'all_appointments' && $appoint_doctor == 'all_doctors' && $appoint_theatre == 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE date BETWEEN '$appoint_start' AND '$appoint_end'";
        }
        else if($appoint_type !== 'all_appointments' && $appoint_doctor == 'all_doctors' && $appoint_theatre == 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE appoint_type_id = '$appoint_type' AND date BETWEEN '$appoint_start' AND '$appoint_end'";
        }
        else if($appoint_type == 'all_appointments' && $appoint_doctor !== 'all_doctors' && $appoint_theatre == 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE doctor = '$appoint_doctor' AND date BETWEEN '$appoint_start' AND '$appoint_end'";
        }
        else if($appoint_type == 'all_appointments' && $appoint_doctor == 'all_doctors' && $appoint_theatre !== 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE theatre_id = '$appoint_theatre' AND date BETWEEN '$appoint_start' AND '$appoint_end'";
        }
        else if($appoint_type !== 'all_appointments' && $appoint_doctor !== 'all_doctors' && $appoint_theatre == 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE appoint_type_id = '$appoint_type' AND doctor = '$appoint_doctor' AND date BETWEEN '$appoint_start' AND '$appoint_end'";
        }
        else if($appoint_type !== 'all_appointments' && $appoint_doctor == 'all_doctors' && $appoint_theatre !== 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE appoint_type_id = '$appoint_type' AND theatre_id = '$appoint_theatre' AND date BETWEEN '$appoint_start' AND '$appoint_end'";
        }
        else if($appoint_type !== 'all_appointments' && $appoint_doctor !== 'all_doctors' && $appoint_theatre !== 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE appoint_type_id = '$appoint_type' AND doctor = '$appoint_doctor' AND theatre_id = '$appoint_theatre' AND date BETWEEN '$appoint_start' AND '$appoint_end'";
        }
        else if($appoint_type == 'all_appointments' && $appoint_doctor !== 'all_doctors' && $appoint_theatre !== 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE doctor = '$appoint_doctor' AND theatre_id = '$appoint_theatre' AND date BETWEEN '$appoint_start' AND '$appoint_end'";
        };
    }
    else
    {
        if($appoint_type == 'all_appointments' && $appoint_doctor == 'all_doctors' && $appoint_theatre == 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE date BETWEEN '$appoint_start' AND '$appoint_end' AND branch_id='$appoint_branch'";
        }
        else if($appoint_type !== 'all_appointments' && $appoint_doctor == 'all_doctors' && $appoint_theatre == 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE appoint_type_id = '$appoint_type' AND date BETWEEN '$appoint_start' AND '$appoint_end' AND branch_id='$appoint_branch'";
        }
        else if($appoint_type == 'all_appointments' && $appoint_doctor !== 'all_doctors' && $appoint_theatre == 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE doctor = '$appoint_doctor' AND date BETWEEN '$appoint_start' AND '$appoint_end' AND branch_id='$appoint_branch'";
        }
        else if($appoint_type == 'all_appointments' && $appoint_doctor == 'all_doctors' && $appoint_theatre !== 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE theatre_id = '$appoint_theatre' AND date BETWEEN '$appoint_start' AND '$appoint_end' AND branch_id='$appoint_branch'";
        }
        else if($appoint_type !== 'all_appointments' && $appoint_doctor !== 'all_doctors' && $appoint_theatre == 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE appoint_type_id = '$appoint_type' AND doctor = '$appoint_doctor' AND date BETWEEN '$appoint_start' AND '$appoint_end' AND branch_id='$appoint_branch'";
        }
        else if($appoint_type !== 'all_appointments' && $appoint_doctor == 'all_doctors' && $appoint_theatre !== 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE appoint_type_id = '$appoint_type' AND theatre_id = '$appoint_theatre' AND date BETWEEN '$appoint_start' AND '$appoint_end' AND branch_id='$appoint_branch'";
        }
        else if($appoint_type !== 'all_appointments' && $appoint_doctor !== 'all_doctors' && $appoint_theatre !== 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE appoint_type_id = '$appoint_type' AND doctor = '$appoint_doctor' AND theatre_id = '$appoint_theatre' AND date BETWEEN '$appoint_start' AND '$appoint_end' AND branch_id='$appoint_branch'";
        }
        else if($appoint_type == 'all_appointments' && $appoint_doctor !== 'all_doctors' && $appoint_theatre !== 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE doctor = '$appoint_doctor' AND theatre_id = '$appoint_theatre' AND date BETWEEN '$appoint_start' AND '$appoint_end' AND branch_id='$appoint_branch'";
        };
    };

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
    $company_id = $_SESSION['company_id'];
    $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
    $result_company = mysqli_query($con,$sql_company);
    $row_company = mysqli_fetch_array($result_company);
?>
    <table class="table table-hover table-bordered table-sm" id="patient_cash_statement_list_table" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class = "action-td" colspan="11"><H2><?php echo $row_company['trading_name'];?></H2></th>
            </tr>
            <tr>
                <th class = "action-td" colspan="11"><H4><?php echo $row_company['telephone'];?></H4></th>
            </tr>
            <tr>
                <th class = "action-td" colspan="11"><H4>DOCTORS' APPOINTMENT LIST</H4></th>
            </tr>
        </thead>
        <tbody class="pv-table-body" id="patient_cash_statement_list_table_body">
            </tr>
                <th class = "action-td">S/NO</th>
                <th class = "action-td">NAME</th>
                <th class = "action-td">AGE</th>
                <th class = "action-td">TELEPHONE</th>
                <th class = "action-td">SEX</th>
                <th class = "action-td">DATE</th>
                <th class = "action-td">TIME</th>
                <th class = "action-td">TYPE</th>
                <th class = "action-td">SURGERY</th>
                <th class = "action-td">THEATRE</th>
                <th class = "action-td">DOCTOR</th>
            </tr>
        <?php
        $query_run = mysqli_query($con, $sql);
        if (mysqli_num_rows($query_run) > 0)
        {
            $i=0;
            while($row = mysqli_fetch_assoc($query_run))
            {
                ++$i;
                $gender_id = $row['gender_id'];
                $query_gender = "SELECT * FROM `gender` WHERE `gender_id` = '$gender_id'";
                $query_run_gender = mysqli_query($con, $query_gender);
                $row_gender = mysqli_fetch_assoc($query_run_gender);

                $appoint_type_id = $row['appoint_type_id'];
                $query_appoint_type = "SELECT * FROM `appoint_type` WHERE `appoint_type_id` = '$appoint_type_id'";
                $query_run_appoint_type = mysqli_query($con, $query_appoint_type);
                $row_appoint_type = mysqli_fetch_assoc($query_run_appoint_type);

                $theatre_id = $row['theatre_id'];
                $query_theatre = "SELECT * FROM `theatre` WHERE `theatre_id` = '$theatre_id'";
                $query_run_theatre = mysqli_query($con, $query_theatre);
                $row_theatre = mysqli_fetch_assoc($query_run_theatre);

                echo '<tr>
                    <td>'.$i.'</td>
                    <td>'.$row['name'].'</td>
                    <td class="action-td">'.$row['age'].'</td>
                    <td class="action-td">'.$row['phone'].'</td>
                    <td class="action-td">'.$row_gender['gender'].'</td>
                    <td class="action-td">'.$row['date'].'</td>
                    <td class="action-td">'.$row['time'].'</td>
                    <td>'.$row_appoint_type['appoint_type'].'</td>
                    <td>'.$row['surgery_id'].'</td>
                    <td>'; 
                        if(isset($row_theatre)){echo $row_theatre['theatre'];}else{echo 'N/A';};
                echo'</td>
                    <td>'.$row['doctor'].'</td>
                </tr>';
            };
        };
        ?>
        </tbody>
    </table>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
