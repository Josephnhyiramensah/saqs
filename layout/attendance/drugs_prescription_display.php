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
                    <td class="action-td" colspan="3"><h4><?php echo $row_company['trading_name'];?></h4></td>
                </tr>
                <tr>
                    <td class="action-td" colspan="3"><?php echo $row_company['address'];?></td>
                </tr>
                <tr>
                    <td class="action-td" colspan="3"><?php echo $row_company['telephone'];?></td>
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
                    <td class="action-td" colspan="3"><h5 class="modal-title m-0 font-weight-bold text-primary">DRUG PRESCRIPTION</h5></td>
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
                <tr style="background-color:#E4E1E0">
                    <th>DRUG DESCRIPTION</th>
                    <th>DOSAGE</th>
                    <th>QTY</th>
                </tr>   
            </thead>
            <tbody class="pv-table-body">
 <?php 
                 $query = "SELECT * FROM drug_list WHERE attend_id='$attend_id' /*AND qty_presc > qty_dispensed*/";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row_drug_list = mysqli_fetch_assoc($query_run))
                    {
                        $drug_id = $row_drug_list['drug_id'];
                        $qty_presc = $row_drug_list['qty_presc'];
                        //$qty_dispensed = $row_drug_list['qty_dispensed'];
                        //$qty = $qty_presc - $qty_dispensed;
                        $drug_list_id = $row_drug_list['drug_list_id'];

                        $query_dispensed = "SELECT SUM(qty) AS qty_disp FROM drug_dispense_list 
                                WHERE attend_id='$attend_id'  
                                AND drug_list_id='$drug_list_id'";
                        $query_run_dispensed = mysqli_query($con, $query_dispensed);
                        if (mysqli_num_rows($query_run_dispensed) > 0)
                        {
                            $row_dispensed = mysqli_fetch_assoc($query_run_dispensed);
                            $qty_dispensed = $row_dispensed['qty_disp'];
                        }
                        else
                        {
                            $qty_dispensed = 0;
                        };
                        
                        $qty = $qty_presc - $qty_dispensed;
                        
                        if($qty > 0)
                        {
                            $query = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
                        $query_run_drug = mysqli_query($con, $query);
                        $row_drug=mysqli_fetch_assoc($query_run_drug);
                        echo'<tr>
                                    <td>
                                        '.$row_drug['brand_name'].'
                                    </td>
                                    <td>
                                        '.$row_drug_list['dosage'].'
                                    </td>
                                    <td>
                                        '.$qty.'
                                    </td>
                                </tr>';
                        };
                    }
?>
            </tbody>
    </table>
 <?php 
                            }
                            else
                            {
                                echo 'No Drug on prescription';
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