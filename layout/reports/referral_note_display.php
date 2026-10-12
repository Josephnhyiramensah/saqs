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
        if(isset($_SESSION['attend_id']))
        {
            $company_id = $_SESSION['company_id'];
            $attend_id = $_SESSION['attend_id'];
            $patient_id = $_SESSION['patient_id'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);

            $sql_attend = "SELECT * FROM attendance WHERE attend_id = '$attend_id'";
            $result_attend = mysqli_query($con,$sql_attend);
            $row_attend = mysqli_fetch_array($result_attend);

            $query_patient = "SELECT * FROM patients WHERE patient_id ='$patient_id'";
            $query_run_patient = mysqli_query($con, $query_patient);
            $row_patient = mysqli_fetch_assoc($query_run_patient);

            $gender_id = $row_patient['gender'];
            $query_gender = "SELECT * FROM `gender` WHERE `gender_id` = '$gender_id'";
            $query_run_gender = mysqli_query($con, $query_gender);
            $row_gender = mysqli_fetch_assoc($query_run_gender);
    ?>

        <table class="table table-hover table-borderless table-sm" width="100%" cellspacing="0" style="font-size: 14px">
            <thead>
                <tr>
                    <td class="action-td" colspan="4"><h4><?php echo $row_company['trading_name'];?></h4></td>
                </tr>
                <tr>
                    <td class="action-td" colspan="4"><?php echo $row_company['address'];?></td>
                </tr>
                <tr>
                    <td class="action-td" colspan="4"><?php echo $row_company['telephone'];?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="action-td" colspan="4"><h5 class="modal-title m-0 font-weight-bold text-primary">REFERRAL NOTE</h5></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><strong>Patient Name: </strong><?php echo $row_patient['firstName'].' '.$row_patient['lastName'] ;?></td>
                    <td><strong>Age: </strong><?php echo $row_attend['age'];?></td>
                    <td><strong>Date: </strong><?php echo $row_attend['date_admit'];?></td>
                </tr>
                <tr>
                    <td><strong>Gender: </strong><?php echo $row_gender['gender']?></td>
                    <td><strong>Telephone: </strong><?php echo $row_patient['telephone']?></td>
                    <td><strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody class="pv-table-body">
 <?php 
                $query_refer = "SELECT * FROM `referral` WHERE `attend_id` = '$attend_id'";
                $query_run_refer = mysqli_query($con, $query_refer);
                if (mysqli_num_rows($query_run_refer) > 0)
                {
                    while($row_refer = mysqli_fetch_assoc($query_run_refer))
                    {
                        echo '
                        <tr style="background-color:#E4E1E0">
                            <th colspan="3">FACILITY</th>
                            <th>DOCTOR</th>
                        </tr>
                        <tr>
                            <td colspan="3">'.$row_refer['facility'].'</td>
                            <td>'.$row_refer['doctor'].'</td>
                        </tr>
                        <tr style="background-color:#E4E1E0">
                            <th>DATE</th>
                            <th>TIME</th>
                            <th>ALERTNESS</th>
                            <th>WALKING</th>
                        </tr>
                        <tr>
                            <td>'.$row_refer['date'].'</td>
                            <td>'.$row_refer['time'].'</td>
                            <td>'.$row_refer['alertness'].'</td>
                            <td>'.$row_refer['walking'].'</td>
                        </tr>
                        <tr style="background-color:#E4E1E0">
                            <th>ILLNESS STATE</th>
                            <th>URGENCY</th>
                            <th>ACCOMPANIED BY STAFF</th>
                            <th>STAFF NAME</th>
                        </tr>
                        <tr>
                            <td>'.$row_refer['illness_state'].'</td>
                            <td>'.$row_refer['urgency'].'</td>
                            <td>'.$row_refer['accompanied'].'</td>
                            <td>'.$row_refer['staff_name'].'</td>
                        </tr>
                        <tr style="background-color:#E4E1E0">
                            <th colspan="2">REASON FOR REFERRAL</th>
                            <th colspan="2">ACTION TAKEN</th>
                        </tr>
                        <tr>
                            <td colspan="2">'.$row_refer['reason'].'</td>
                            <td colspan="2">'.$row_refer['action'].'</td>
                        </tr>';
                    }
?>
            </tbody>
    </table>
 <?php 
                            }
                            else
                            {
                                echo 'No Referral Note found';
                            };
    };
?>

<div>
    <br>
    <br>
    <br>
    <div class="float-right">
        <p>.......................................................................................</p><br>
        <p>CLINICIAN/MEDICAL OFFICER</p>
    </div>
</div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>