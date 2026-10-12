<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//CREATE AND OPEN
function attend_new()
{
    global $con;
    $patient_id = $_POST["patient_id"];
    //FIND PREVIOUS ATTENDANCE
    $query = "SELECT * FROM `attendance` WHERE patient_id='$patient_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0) 
    {
        $_SESSION['state_attd'] = 'Old';
        $_SESSION['type_attd'] = 'Regular';
    }
    else
    {
        $_SESSION['state_attd'] = 'New';
        $_SESSION['type_attd'] = "0";
    };
    $sql="SELECT * FROM patients WHERE patient_id='$patient_id'";
    $result=mysqli_query($con,$sql);
    $row=mysqli_fetch_array($result);

    $today = date("Y-m-d");
    $expirenhis = $row['nhisexpirydate'];
    $expireprvt = $row['prtexpirydate'];
    $today_dt = new DateTime($today);
    $expirenhis_dt = new DateTime($expirenhis);
    $expireprvt_dt = new DateTime($expireprvt);

    $_SESSION['patient_id'] = $row['patient_id'];
    $_SESSION['attend_id'] = '';
    $_SESSION['folderno'] = $row['folderNo'];
    $_SESSION['name'] = $row['firstName'].' '.$row['lastName'];
    $_SESSION['dob'] = $row['DOB'];
    $_SESSION['gender'] = $row['gender'];
    $_SESSION['telephone'] = $row['telephone'];
    $_SESSION['city'] = $row['city'];
    $_SESSION['attend_state'] = 'new';

    if ($row['Schname'] > 0) {
        if ($expirenhis_dt >= $today_dt) {
            if ($row['nhismemberno'] !== "") {
                if (strlen($row['nhismemberno']) == 8) {
                    $_SESSION['Schname'] = $row['Schname'];
                    $_SESSION['nhismemberno'] = $row['nhismemberno'];
                    $_SESSION['serial_no'] = $row['serial_no'];
                    $_SESSION['ghanacard'] = $row['ghanacard'];
                    $_SESSION['nhisexpirydate'] = $row['nhisexpirydate'];
                } else {
                    echo 'NN8';
                    //echo 'Please the NHIS number should be 8-digits';
                };
            }
            else
            {
                echo 'NN1';
                //echo 'Please provide the membership number!';
            };
        }
        else
        {
            echo 'NE1';
            //echo 'Please the NHIS card has expired!';
        };
    }
    else
    {
        $_SESSION['Schname'] = "";
        $_SESSION['nhismemberno'] = "";
        $_SESSION['serial_no'] = "";
        $_SESSION['nhisexpirydate'] = "";
        $_SESSION['ghanacard'] = "";
    };

    if ($row['prtinsname'] > 0 ) {
        if ($expireprvt_dt >= $today_dt) {
            if ($row['prtmemberno'] !== "") {
                $_SESSION['prtinsname'] = $row['prtinsname'];
                $_SESSION['prtmemberno'] = $row['prtmemberno'];
                $_SESSION['prtexpirydate'] = $row['prtexpirydate'];
            }
            else
            {
                echo 'PN1';
                //echo 'Please provide the insurance number!';
            };
        }
        else
        {
            echo 'PE1';
            //echo 'Please the card has expired';
        };
    }
    else
    {
        $_SESSION['prtinsname'] = "";
        $_SESSION['prtmemberno'] = "";
        $_SESSION['prtexpirydate'] = "";
    };
    
    if ($_SESSION['Schname'] > 0 && $_SESSION['prtinsname'] > 0 ) {
        $_SESSION['sponsor'] = $_SESSION['Schname'];
    }
    else if ($_SESSION['Schname'] > 0 && $_SESSION['prtinsname'] <= 0 ){
        $_SESSION['sponsor'] = $_SESSION['Schname'];
    }
    else if ($_SESSION['Schname'] <= 0 && $_SESSION['prtinsname'] > 0 ){
        $_SESSION['sponsor'] = $_SESSION['prtinsname'];
    }
    else if ($_SESSION['Schname'] <= 0 && $_SESSION['prtinsname'] <= 0 ){
        $_SESSION['sponsor'] = 1;
    };
}

function attend_specialty_1()
{
    global $con;
    $specialty_1 = $_POST['specialty_1'];
    $specialty_data=array();
    $query = "SELECT * FROM `nhis` WHERE nhis_id='$specialty_1'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0) 
    {
         while($row=mysqli_fetch_assoc($query_run))
        {
            array_push($specialty_data, 
                $row['gdrg'],
                $row['gdrg_adult'],
                $row['gdrg_child']
            );
        };
    } 
    else 
    {
        array_push($specialty_data, 
                'none'
            );
    };
   
     echo json_encode($specialty_data);
}

function attend_specialty_2()
{
    global $con;
    $specialty_2 = $_POST['specialty_2'];
    $specialty_data=array();
    $query = "SELECT * FROM `nhis` WHERE nhis_id='$specialty_2'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0) 
    {
        while($row=mysqli_fetch_assoc($query_run))
        {
            array_push($specialty_data, 
                $row['gdrg'],
                $row['gdrg_adult'],
                $row['gdrg_child']
            );
        };
    } 
    else 
    {
        array_push($specialty_data, 
                'none'
            );
    };
     echo json_encode($specialty_data);
}

function attend_specialty_3()
{
    global $con;
    $specialty_3 = $_POST['specialty_3'];
    $specialty_data=array();
    $query = "SELECT * FROM `nhis` WHERE nhis_id='$specialty_3'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0) 
    {
        while($row=mysqli_fetch_assoc($query_run))
        {
            array_push($specialty_data, 
                $row['gdrg'],
                $row['gdrg_adult'],
                $row['gdrg_child']
            );
        };
    } 
    else 
    {
        array_push($specialty_data, 
                'none'
            );
    };
     echo json_encode($specialty_data);
}

function attend_sponsor_list()
{
    global $con;
    $i = $_POST['i'];
    $value = "";
    $value = '<tr id="'.$i.'">
                <td>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="attend_sponsor_id"><small><u>Sponsor Name</u></small></label>
                            <select class="form-control bg-light attend_sponsor_id" name="attend_sponsor_id[]" id="attend_sponsor_id'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                $sql_sponor = "SELECT * FROM ledgers WHERE tb_5 = 1 ORDER BY ledger_desc"; 
                                $result_sponor = mysqli_query($con,$sql_sponor);
                                while($row_sponor = mysqli_fetch_array($result_sponor))
                                {
                                    $value.='<option value ="'.$row_sponor['ledger_id'].'">'.$row_sponor['ledger_desc'].'</option>';
                                };
                    $value.='</select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="nhismemberno_attd"><small><u>Membership No</u></small></label>
                            <input type="text" name="attend_sponsor_member_no[]" class="form-control bg-light attend_sponsor_member_no" id="attend_sponsor_member_no'.$i.'" data-id="1" style="border-width:0px" >
                        </div>
                        <div class="col-md-2 mb-2">
                            <div id="ghanacard_div'.$i.'"  style="display:none;">
                                <label for="ghanacard_attd"><small><u>Ghana Card</u></small></label>
                                <input type="text" class="form-control bg-light" name="ghanacard_attd[]" id="ghanacard_attd'.$i.'">
                            </div>
                            <div id="ins_category_div'.$i.'">
                                <label for="attend_sponsor_category"><small><u>Category</u></small></label>
                                <input type="text" name="attend_sponsor_category[]" class="form-control bg-light attend_sponsor_category" id="attend_sponsor_category'.$i.'" data-id="'.$i.'" style="border-width:0px" >
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="nhisexpirydate_attd"><small><u>Expiry Date</u></small></label>
                            <input type="date" name="attend_sponsor_expiry_date[]" class="form-control bg-light" id="attend_sponsor_expiry_date'.$i.'" style="border-width:0px">
                        </div>
                        <div class="col-md-1 mb-1">
                            <label for="nhisexpirydate_attd"><small><u>Principal</u></small></label>
                            <select class="form-control bg-light attend_sponsor_principal" name="attend_sponsor_principal[]" id="attend_sponsor_principal'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>
                                <option value ="Yes">Yes</option>
                                <option value ="No">No</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div id="serial_no_div'.$i.'" style="display:none;">
                                <label for="serial_no"><small><u>Serial no</u></small></label>
                                <input type="text" class="form-control bg-light" name="serial_no[]" id="serial_no'.$i.'">
                            </div>
                            <div id="relation_div'.$i.'">
                                <label for="attend_sponsor_relation"><small><u>Relation Type</u></small></label>
                                <input type="text" class="form-control bg-light" name="attend_sponsor_relation[]" id="attend_sponsor_relation'.$i.'">
                            </div>
                        </div>
                    </div>
                    <div class="form-row" id="ins_detail_one'.$i.'"  style="display:none;">
                    
                    <div class="form-row">
                        <div class="col-md-1 mb-1">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="ASUR" id="ASUR'.$i.'" name="specialty_attd[]">
                            <label class="form-check-label" for="ASUR">
                                ASUR
                            </label>
                            </div>
                        </div>
                        <div class="col-md-1 mb-1">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="DENT" id="DENT'.$i.'" name="specialty_attd[]">
                            <label class="form-check-label" for="DENT">
                                DENT
                            </label>
                            </div>
                        </div>
                        <div class="col-md-1 mb-1">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="ENTH" id="ENTH'.$i.'" name="specialty_attd[]">
                            <label class="form-check-label" for="ENTH">
                                ENTH
                            </label>
                            </div>
                        </div>
                        <div class="col-md-1 mb-1">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="MEDI" id="MEDI'.$i.'" name="specialty_attd[]">
                            <label class="form-check-label" for="MEDI">
                                MEDI
                            </label>
                            </div>
                        </div>
                        <div class="col-md-1 mb-1">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="OBGY" id="OBGY'.$i.'" name="specialty_attd[]">
                            <label class="form-check-label" for="OBGY">
                                OBGY
                            </label>
                            </div>
                        </div>
                        <div class="col-md-1 mb-1">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="OPDC" id="OPDC'.$i.'" name="specialty_attd[]">
                            <label class="form-check-label" for="OPDC">
                                OPDC
                            </label>
                            </div>
                        </div>
                        <div class="col-md-1 mb-1">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="OPHT" id="OPHT'.$i.'" name="specialty_attd[]">
                            <label class="form-check-label" for="OPHT">
                                OPHT
                            </label>
                            </div>
                        </div>
                        <div class="col-md-1 mb-1">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="ORTH" id="ORTH'.$i.'" name="specialty_attd[]">
                            <label class="form-check-label" for="ORTH">
                                ORTH
                            </label>
                            </div>
                        </div>
                        <div class="col-md-1 mb-1">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="PAED" id="PAED'.$i.'" name="specialty_attd[]">
                            <label class="form-check-label" for="PAED">
                                PAED
                            </label>
                            </div>
                        </div>
                        <div class="col-md-1 mb-1">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="PSUR" id="PSUR'.$i.'" name="specialty_attd[]">
                            <label class="form-check-label" for="PSUR">
                                PSUR
                            </label>
                            </div>
                        </div>
                        <div class="col-md-1 mb-1">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="RSUR" id="RSUR'.$i.'" name="specialty_attd[]">
                            <label class="form-check-label" for="RSUR">
                                RSUR
                            </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row" id="ins_detail_two'.$i.'" style="display:none;">
                        <div class="col-md-3 mb-3">
                            <label for="type_of_attendnace"><small><u>Type Of Attendance</u></small></label>
                            <select class="form-control bg-light" name="type_of_attendnace[]" id="type_of_attendnace'.$i.'"> 
                                <option value="0">-Please Select-</option>
                                <option value="chronic_follow_up">Chronic Follow-up</option>
                                <option value="emergency_acute_episode">Emergency/Acute Episode</option>
                                <option value="antenatal">Antenatal Care</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="date_of_claim"><small><u>Date of Claim</u></small></label>
                            <input type="date" class="form-control bg-light" name="date_of_claim[]" id="date_of_claim'.$i.'">
                        </div>
                        <div class="col-md-1 mb-1">
                            <label for="claim_no"><small><u>Claim No</u></small></label>
                            <input type="text" class="form-control" name="claim_no[]" id="claim_no'.$i.'">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="pharmacy"><small><u>Pharmacy</u></small></label>
                            <select class="form-control bg-light" name="pharmacy[]" id="pharmacy'.$i.'"> 
                                <option value="0">Please Select</option>
                                <option value="pharmacy">Pharmacy</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="type_of_service_2"><small><u>Type Of Service (b)</u></small></label>
                            <select class="form-control bg-light" name="type_of_service_2[]" id="type_of_service_2'.$i.'"> 
                                <option value="0">Please Select</option>
                                <option value="all_inclusive">All Inclusive</option>
                                <option value="unbundled">Unbundled</option>
                            </select>
                        </div>
                        <div class="col-md-1 mb-1">
                            <label for="nhisccc"><small><u>CCC</u></small></label>
                            <input type="text" class="form-control bg-light" name="nhisccc[]" id="nhisccc'.$i.'">
                        </div>
                        <div class="col-md-1 mb-1">
                            <label for="spell"><small><u>Spell</u></small></label>
                            <input type="text" class="form-control bg-light" name="spell[]" id="spell'.$i.'">
                        </div>
                    </div>
                    <div class="clearfix">';
                            if ($i > 1) 
                            {
                                $value.='<a href="#" id="delete_attend_sponsor" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>';
                            };
            $value.='</div>
                </td>
            </tr>';
    echo $value;
}

function attend_save()
{
    global $con;
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $company_id = mysqli_real_escape_string($con,$_POST['session_company_id']);
    $patient_id = mysqli_real_escape_string($con,$_POST['patient_id_attend']);
    $patient_age = mysqli_real_escape_string($con,$_POST['patient_age']);
    $clinic_attd = mysqli_real_escape_string($con,$_POST['clinic_attd']);
    $doctor_attd = mysqli_real_escape_string($con,$_POST['doctor_attd']);
    $type = mysqli_real_escape_string($con,$_POST['type_attd']);
    $status = mysqli_real_escape_string($con,$_POST['state_attd']);
    $typeofservice_attd = 1;
    $dateofadmission_attd = mysqli_real_escape_string($con,$_POST['dateofadmission_attd']);
    $outcome = 'discharged';

    $user_id = $_SESSION['user_id'];
    date_default_timezone_set("Africa/Accra");
    $datetime = date('Y/m/d H:i:s');

    //FIND DUPLICATE ATTENDANCE
    $query = "SELECT * FROM `attendance` WHERE patient_id = '$patient_id' AND date_admit = '$dateofadmission_attd' AND company_id = '$company_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        echo 1;
    } 
    else 
    {
        $query = "INSERT INTO attendance (company_id, patient_id, clinic_id, date_admit, date_disch, 
        tos_id, age, doctor_id, outcome, type, status, created_by, created_datetime, branch_id) 
        VALUES ('$company_id','$patient_id','$clinic_attd','$dateofadmission_attd',
        '$dateofadmission_attd','$typeofservice_attd','$patient_age','$doctor_attd', '$outcome',
        '$type', '$status','$user_id', '$datetime', '$branch_id')";
        $query_run = mysqli_query($con, $query);
        if ($query_run) 
        {
            $query_attend = "SELECT * FROM `attendance` ORDER BY attend_id DESC";
            $query_run_attend = mysqli_query($con, $query_attend);
            $row_attend = mysqli_fetch_assoc($query_run_attend);
            $attend_id = $row_attend['attend_id'];

            $_SESSION['attend_id'] = $row_attend['attend_id'];
            $_SESSION['age'] = $row_attend['age'];
            $_SESSION['dateofadmission_attd'] = $row_attend['date_admit'];
            $_SESSION['dateofdischarge_attd'] = $row_attend['date_disch'];
            $_SESSION['typeofservice_attd'] = $row_attend['tos_id'];
            $_SESSION['doctor_id'] = $row_attend['doctor_id'];
            $_SESSION['clinic'] = $row_attend['clinic_id'];
            $_SESSION['patient_id'] = $patient_id;
            
            $query_patient = "SELECT * FROM patients WHERE patient_id ='$patient_id'";
            $query_run_patient = mysqli_query($con, $query_patient);
            $row_patient = mysqli_fetch_assoc($query_run_patient);
            $_SESSION['folderno'] = $row_patient['folderNo'];
            $_SESSION['name'] = $row_patient['firstName'].' '.$row_patient['lastName'];
            $_SESSION['gender'] = $row_patient['gender'];
            $_SESSION['dob'] = $row_patient['DOB'];
            $_SESSION['address'] = $row_patient['address'];
            $_SESSION['BloodGroup'] = $row_patient['BloodGroup'];
            $_SESSION['telephone'] = $row_patient['telephone'];
            $_SESSION['relname'] = $row_patient['relname'];
            $_SESSION['reltelephone'] = $row_patient['reltelephone'];

            //ENTER SPONSORS
            $number_as = count($_POST["attend_sponsor_id"]);  
            if($number_as > 0)  
            {
                  for($i=0; $i<$number_as; $i++)
                  {
                   if(trim($_POST["attend_sponsor_id"][$i] !== '') && trim($_POST["attend_sponsor_id"][$i] !== 0))  
                   {
                        $attend_sponsor_id = $_POST['attend_sponsor_id'][$i];
                        $attend_sponsor_member_no = $_POST['attend_sponsor_member_no'][$i];
                        $attend_sponsor_category = $_POST['attend_sponsor_category'][$i];
                        $attend_sponsor_principal = $_POST['attend_sponsor_principal'][$i];
                        $attend_sponsor_code = $_POST['nhisccc'][$i];
                        $attend_sponsor_expiry_date = $_POST['attend_sponsor_expiry_date'][$i];
                        $ghanacard_attd = $_POST['ghanacard_attd'][$i];
                        $serial_no = $_POST['serial_no'][$i];
                        $type_of_attendnace = $_POST['type_of_attendnace'][$i];
                        $date_of_claim = $_POST['date_of_claim'][$i];
                        $pharmacy = $_POST['pharmacy'][$i];
                        $type_of_service_2 = $_POST['type_of_service_2'][$i];
                        $spell = $_POST['spell'][$i];

                        $dependant = $_POST['claim_no'][$i];
                        $dependant_name = $_POST['pharmacy'][$i];
                        $dependant_no = $_POST['type_of_service_2'][$i];
                        $relation = $_POST['spell'][$i];
                        $claim_no = $_POST['claim_no'][$i];

                        //SPECIALTY CODE
                        if($attend_sponsor_id == 2)
                        {
                            $specialty_attd = '';
                            $spec_code_count = count($_POST["specialty_attd"]);  
                            if($spec_code_count > 0)
                            {
                                for($a=0; $a < $spec_code_count; $a++)  
                                {  
                                    //if(trim($_POST["specialty_attd"][$a] !== '') && trim($_POST["specialty_attd"][$a] !== 0))  
                                    //{  
                                        if($a <= 1)
                                        {
                                            $specialty_attd = $_POST['specialty_attd'][$a];
                                        }
                                        else
                                        {
                                            $specialty_attd = $specialty_attd.','.$_POST['specialty_attd'][$a];
                                        };
                                    //};
                                };
                            };
                        }
                        else
                        {
                            $specialty_attd = 'N/A';
                        };
        
                        if($attend_sponsor_id == 2)
                        {
                            if($clinic_attd == 1/*GENERAL*/)
                            {$specialty = 820;}
                            else if($clinic_attd == 7/*EYE*/)
                            {$specialty = 819;}
                            else if($clinic_attd == 8/*DENTISTRY*/)
                            {$specialty = 817;}
                            else if($clinic_attd == 15/*ORTHODONTICS*/)
                            {$specialty = 820;}
                            else if($clinic_attd == 17/*ANTENATAL/POSTNATAL*/)
                            {$specialty = 816;}
                            else if($clinic_attd == 19/*ENT*/)
                            {$specialty = 818;}
                            else if($clinic_attd == 5/*Physiotheraphy*/)
                            {$specialty = 822;}
                            else if($clinic_attd != 1 && $clinic_attd != 7
                            && $clinic_attd != 8 && $clinic_attd != 15
                            && $clinic_attd != 17 && $clinic_attd != 19
                            && $clinic_attd != 5)
                            {$specialty = 820;};

                            $query_nhis = "SELECT * FROM nhis WHERE nhis_id = '$specialty'";
                            $query_run_nhis = mysqli_query($con, $query_nhis);
                            $row_nhis = mysqli_fetch_assoc($query_run_nhis);

                            if($patient_age < 12)
                            {
                                $Out_Patient_Code = $row_nhis['gdrg_child'];
                                $Out_Patient_Price = $row_nhis['price_child'];
                            }
                            else
                            {
                                $Out_Patient_Code = $row_nhis['gdrg_adult'];
                                $Out_Patient_Price = $row_nhis['price_adult'];
                            };
                        }
                        else
                        {
                            $specialty = 0;
                            $Out_Patient_Code = '';
                            $Out_Patient_Price = '';
                        };

                        $query_pt = "INSERT INTO `payment_type`(
                        `company_id`,`attend_id`, `patient_id`, `ledger_id`, `principal`, `member_no`, `ins_class`, `code`, 
                        `expiry_date`,`ghanacard`, `serial_no`,`specialty_1`, `type_of_attend`, `date_of_claim`, `pharmacy`, 
                        `type_of_serv_b`, `spell`, `dependant`, `dependant_name`, `dependant_no`, `relation`, `claim_no`, 
                        `date_admit`, `date_disch`, `specialty`, `gdrg_out_patient`, `amt_out_patient`, `branch_id`) 
                        VALUES (
                        '$company_id','$attend_id','$patient_id','$attend_sponsor_id','$attend_sponsor_principal',
                        '$attend_sponsor_member_no','$attend_sponsor_category','$attend_sponsor_code','$attend_sponsor_expiry_date',
                        '$ghanacard_attd','$serial_no','$specialty_attd','$type_of_attendnace','$date_of_claim','$pharmacy',
                        '$type_of_service_2','$spell','$dependant','$dependant_name','$dependant_no','$relation','$claim_no',
                        '$dateofadmission_attd','$dateofadmission_attd','$specialty','$Out_Patient_Code','$Out_Patient_Price',
                        '$branch_id')";
                        $query_run_pt = mysqli_query($con, $query_pt);
                   };
                  };
            };

            if($type == 'Regular')
            {
                $query_sponsor = "SELECT * FROM payment_type WHERE attend_id='$attend_id' AND principal ='Yes'";
                $query_run_sponsor = mysqli_query($con, $query_sponsor);
                $row_sponsor = mysqli_fetch_assoc($query_run_sponsor);
                $service_sponsor = $row_sponsor['ledger_id'];

                //ENTER SERVICE BILL
                $query_clinic = "SELECT * FROM `clinics` WHERE `clinic_id`='$clinic_attd'";
                $query_run_clinic = mysqli_query($con, $query_clinic);
                if (mysqli_num_rows($query_run_clinic) > 0) 
                {
                    $row_clinic = mysqli_fetch_assoc($query_run_clinic);
                    $service_id = $row_clinic['item_id'];
                    if ($service_id > 0) 
                    {
                        $query = "SELECT * FROM `services` WHERE `service_id` ='$service_id'";
                        $query_run = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($query_run);

                        if ($service_sponsor == 1) 
                        {
                            $service_amt_cash = $row['price_cash'];
                            $service_amt_prvt = 0;
                            $service_amt_nhis = 0;
                            $service_gdrg = 0;
                        } 
                        else if($service_sponsor == 2) 
                        {
                            //$query_nhis_item = "SELECT * FROM `services` WHERE `service_id` ='$service_id'";
                            //$query_run_nhis_item = mysqli_query($con, $query_nhis_item);
                            //$row_nhis_item = mysqli_fetch_assoc($query_run_nhis_item);
                            $nhis_id = $row['nhis_id'];

                            $query_nhis = "SELECT * FROM `nhis` WHERE `nhis_id` ='$nhis_id'";
                            $query_run_nhis = mysqli_query($con, $query_nhis);
                            if (mysqli_num_rows($query_run_nhis) > 0)
                            {
                                $row_nhis = mysqli_fetch_assoc($query_run_nhis);

                                if ($patient_age < 12) 
                                {
                                    $service_amt_nhis = $row_nhis['price_child'];
                                    $service_amt_prvt = 0;
                                    $service_amt_cash = $row_nhis['price_topup'];
                                    $service_gdrg = $row_nhis['gdrg_child'];
                                } 
                                else 
                                {
                                    $service_amt_nhis = $row_nhis['price_adult'];
                                    $service_amt_prvt = 0;
                                    $service_amt_cash = $row_nhis['price_topup'];
                                    $service_gdrg = $row_nhis['gdrg_adult'];
                                };
                            };
                        }
                        else if($service_sponsor != 1 && $service_sponsor != 2) 
                        {
                            $prvt_led_id = $service_sponsor;
                            $query_prvt = "SELECT * FROM `price_list` WHERE `item_id` ='$service_id' AND `category_id` = 1 AND `ledger_id` ='$prvt_led_id'";
                            $query_run_prvt = mysqli_query($con, $query_prvt);
                            if (mysqli_num_rows($query_run_prvt) > 0)
                            {
                                $row_prvt = mysqli_fetch_assoc($query_run_prvt);
                                $service_amt_prvt = $row_prvt['price'];
                                $service_amt_nhis = 0;
                                $service_amt_cash = $row_prvt['price_topup'];
                                $service_gdrg = 0;
                            }
                            else
                            {
                                $service_amt_prvt = $row['price_cash'];
                                $service_amt_nhis = 0;
                                $service_amt_cash = 0;
                                $service_gdrg = 0;
                            };
                        };

                        $query = "INSERT INTO `service_list`(
                        `company_id`,`service_id`, `attend_id`, `patient_id`, `date`, `qty`, `g_drg`, `price_cash`, `price_nhis`, `price_prvt`, 
                        `amount_cash`, `amount_nhis`, `amount_prvt`, `comment`, `ledger_id`, `doctor_id`, `branch_id`) 
                        VALUES (
                        '$company_id','$service_id','$attend_id','$patient_id','$dateofadmission_attd',1,
                        '$service_gdrg','$service_amt_cash','$service_amt_nhis',
                        '$service_amt_prvt','$service_amt_cash','$service_amt_nhis','$service_amt_prvt',
                        'no comment','$service_sponsor','$doctor_attd','$branch_id')";
                        $query_run = mysqli_query($con, $query);

                        if ($query_run)
                        {
                            $query_sl = "SELECT * FROM service_list WHERE attend_id='$attend_id' ORDER BY service_list_id DESC";
                            $query_run_sl = mysqli_query($con, $query_sl);
                            $row_sl=mysqli_fetch_assoc($query_run_sl);
                            $service_list_id = $row_sl['service_list_id'];
                            $service_date = $row_sl['date'];

                            $query_tr = "SELECT * FROM transactions WHERE attend_id='$attend_id' AND item_list_id='$service_list_id' AND category_id=1";
                            $query_run_tr = mysqli_query($con, $query_tr);
                            if (mysqli_num_rows($query_run_tr) > 0)
                            {
                                $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=1 AND `item_list_id`='$service_list_id'";
                                mysqli_query($con, $query_trans_del);

                                if ($service_amt_cash > 0) 
                                {
                                    $query_cash_dr = "INSERT INTO `transactions`(`company_id`,`ledger_id`,`ledger_id_contra`, 
                                    `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                    `amt_credit`, `narration`, `branch_id`) VALUES ('$company_id',1,9,'$attend_id','$service_list_id',
                                    '$patient_id',1,'$service_date','$service_amt_cash','$service_amt_cash',0,'Cash Service',
                                    '$branch_id')";
                                    mysqli_query($con, $query_cash_dr);
                                    
                                    $query_cash_cr = "INSERT INTO `transactions`(`company_id`,`ledger_id`,`ledger_id_contra`, 
                                    `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                    `amt_credit`, `narration`, `branch_id`) VALUES ('$company_id',9,1,'$attend_id','$service_list_id',
                                    '$patient_id',1,'$service_date','$service_amt_cash',0,'$service_amt_cash','Cash Service',
                                    '$branch_id')";
                                    mysqli_query($con, $query_cash_cr);

                                    /*AUTO ITEMISED RECEIPT
                                            $query_receipt_deposit = "SELECT * FROM receipt WHERE attend_id='$attend_id' AND patient_id='$patient_id' ORDER BY receipt_id ASC";
                                            $result_receipt_deposit = mysqli_query($con,$query_receipt_deposit);
                                            if (mysqli_num_rows($result_receipt_deposit) > 0)
                                            {
                                                while($row_receipt_deposit = mysqli_fetch_assoc($result_receipt_deposit))
                                                {
                                                    $receipt_id = $row_receipt_deposit['receipt_id'];
                                                    $amount_deposited = $row_receipt_deposit['amount'];

                                                    $query_receipt_item = "SELECT SUM(amount_rec) AS total_itemised FROM receipt_items WHERE receipt_id='$receipt_id'";
                                                    $result_receipt_item = mysqli_query($con,$query_receipt_item);
                                                    if (mysqli_num_rows($result_receipt_item) > 0)
                                                    {
                                                        $row_receipt_item = mysqli_fetch_assoc($result_receipt_item);
                                                        $amount_itemised = $row_receipt_item['total_itemised'];
                                                    }
                                                    else
                                                    {
                                                        $amount_itemised = 0;
                                                    };
                                                        $deposit_balance = $amount_deposited - $amount_itemised;
                                                        $item_list_id = $service_list_id;
                                                        $item_id = $service_id;
                                                        $category_id = 1;
                                                        $price = $service_price_cash;
                                                        $qty = $service_qty;
                                                        $amount_cash = $service_amt_cash;
                                                        $date = $service_date;
                                                    if($deposit_balance > $amount_cash)
                                                    {
                                                        $amount_rec = $amount_cash;
                                                    }
                                                    else
                                                    {
                                                        $amount_rec = $deposit_balance;
                                                    };
                                                    if($amount_rec > 0)
                                                    {
                                                        $query_rec_item = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,`attend_id`, `date`, `qty`, `price`, 
                                                        `amount_bill`, `amount_rec`, `type`) VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$qty',
                                                        '$price','$amount_cash','$amount_rec','itemise')";
                                                        $query_run_rec_item = mysqli_query($con, $query_rec_item);
                                                    };
                                                };
                                            };*/
                                };
                                if ($service_amt_prvt > 0)
                                {
                                    $query_prvt_dr = "INSERT INTO `transactions`(`company_id`,`ledger_id`,`ledger_id_contra`, 
                                    `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                    `amt_credit`, `narration`, `branch_id`) VALUES ('$company_id','$prvt_led_id',9,'$attend_id',
                                    '$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt','$service_amt_prvt',
                                    0,'Insured Service','$branch_id')";
                                    mysqli_query($con, $query_prvt_dr);

                                    $query_prvt_cr = "INSERT INTO `transactions`(`company_id`,`ledger_id`,`ledger_id_contra`, 
                                    `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                    `amt_credit`, `narration`, `branch_id`) VALUES ('$company_id',9,'$prvt_led_id','$attend_id',
                                    '$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt',0,'$service_amt_prvt',
                                    'Cash Service','$branch_id')";
                                    mysqli_query($con, $query_prvt_cr);
                                };
                                if ($service_amt_nhis > 0)
                                {
                                    $query_nhis_dr = "INSERT INTO `transactions`(`company_id`,`ledger_id`,`ledger_id_contra`, 
                                    `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                    `amt_credit`, `narration`, `branch_id`) VALUES ('$company_id',2,9,'$attend_id',
                                    '$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis','$service_amt_nhis',
                                    0,'NHIS Service','$branch_id')";
                                    mysqli_query($con, $query_nhis_dr);

                                    $query_nhis_cr = "INSERT INTO `transactions`(`company_id`,`ledger_id`,`ledger_id_contra`, 
                                    `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                    `amt_credit`, `narration`, `branch_id`) VALUES ('$company_id',9,2,'$attend_id',
                                    '$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis',0,'$service_amt_nhis',
                                    'NHIS Service','$branch_id')";
                                    mysqli_query($con, $query_nhis_cr);
                                };
                            }
                            else
                            {
                                if ($service_amt_cash > 0) 
                                {
                                    $query_cash_dr = "INSERT INTO `transactions`(`company_id`,`ledger_id`,`ledger_id_contra`, 
                                    `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                    `amt_credit`, `narration`, `branch_id`) VALUES ('$company_id',1,9,'$attend_id',
                                    '$service_list_id','$patient_id',1,'$service_date','$service_amt_cash','$service_amt_cash',
                                    0,'Cash Service','$branch_id')";
                                    mysqli_query($con, $query_cash_dr);
                                    
                                    $query_cash_cr = "INSERT INTO `transactions`(`company_id`,`ledger_id`,`ledger_id_contra`, 
                                    `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                    `amt_credit`, `narration`, `branch_id`) VALUES ('$company_id',9,1,'$attend_id','$service_list_id',
                                    '$patient_id',1,'$service_date','$service_amt_cash',0,'$service_amt_cash','Cash Service','$branch_id')";
                                    mysqli_query($con, $query_cash_cr);

                                    /*AUTO ITEMISED RECEIPT
                                            $query_receipt_deposit = "SELECT * FROM receipt WHERE attend_id='$attend_id' AND patient_id='$patient_id' ORDER BY receipt_id ASC";
                                            $result_receipt_deposit = mysqli_query($con,$query_receipt_deposit);
                                            if (mysqli_num_rows($result_receipt_deposit) > 0)
                                            {
                                                while($row_receipt_deposit = mysqli_fetch_assoc($result_receipt_deposit))
                                                {
                                                    $receipt_id = $row_receipt_deposit['receipt_id'];
                                                    $amount_deposited = $row_receipt_deposit['amount'];

                                                    $query_receipt_item = "SELECT SUM(amount_rec) AS total_itemised FROM receipt_items WHERE receipt_id='$receipt_id'";
                                                    $result_receipt_item = mysqli_query($con,$query_receipt_item);
                                                    if (mysqli_num_rows($result_receipt_item) > 0)
                                                    {
                                                        $row_receipt_item = mysqli_fetch_assoc($result_receipt_item);
                                                        $amount_itemised = $row_receipt_item['total_itemised'];
                                                    }
                                                    else
                                                    {
                                                        $amount_itemised = 0;
                                                    };
                                                        $deposit_balance = $amount_deposited - $amount_itemised;
                                                        $item_list_id = $service_list_id;
                                                        $item_id = $service_id;
                                                        $category_id = 1;
                                                        $price = $service_price_cash;
                                                        $qty = $service_qty;
                                                        $amount_cash = $service_amt_cash;
                                                        $date = $service_date;
                                                    if($deposit_balance > $amount_cash)
                                                    {
                                                        $amount_rec = $amount_cash;
                                                    }
                                                    else
                                                    {
                                                        $amount_rec = $deposit_balance;
                                                    };
                                                    if($amount_rec > 0)
                                                    {
                                                        $query_rec_item = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,`attend_id`, `date`, `qty`, `price`, 
                                                        `amount_bill`, `amount_rec`, `type`) VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$qty',
                                                        '$price','$amount_cash','$amount_rec','itemise')";
                                                        $query_run_rec_item = mysqli_query($con, $query_rec_item);
                                                    };
                                                };
                                            };*/
                                };
                                if ($service_amt_prvt > 0)
                                {
                                    $query_prvt_dr = "INSERT INTO `transactions`(`company_id`,`ledger_id`,`ledger_id_contra`, 
                                    `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                    `amt_credit`, `narration`, `branch_id`) VALUES ('$company_id','$prvt_led_id',9,'$attend_id',
                                    '$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt','$service_amt_prvt',
                                    0,'Insred Service','$branch_id')";
                                    mysqli_query($con, $query_prvt_dr);

                                    $query_prvt_cr = "INSERT INTO `transactions`(`company_id`,`ledger_id`,`ledger_id_contra`, 
                                    `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                    `amt_credit`, `narration`, `branch_id`) VALUES ('$company_id',9,'$prvt_led_id',
                                    '$attend_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt',0,
                                    '$service_amt_prvt','Insured Service','$branch_id')";
                                    mysqli_query($con, $query_prvt_cr);
                                };
                                if ($service_amt_nhis > 0)
                                {
                                    $query_nhis_dr = "INSERT INTO `transactions`(`company_id`,`ledger_id`,`ledger_id_contra`, 
                                    `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                    `amt_credit`, `narration`, `branch_id`) VALUES ('$company_id',2,9,'$attend_id',
                                    '$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis','$service_amt_nhis',
                                    0,'NHIS Service','$branch_id')";
                                    mysqli_query($con, $query_nhis_dr);

                                    $query_nhis_cr = "INSERT INTO `transactions`(`company_id`,`ledger_id`,`ledger_id_contra`, 
                                    `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, 
                                    `amt_credit`, `narration`, `branch_id`) VALUES ('$company_id',9,2,'$attend_id',
                                    '$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis',0,
                                    '$service_amt_nhis','NHIS Service','$branch_id')";
                                    mysqli_query($con, $query_nhis_cr);
                                };
                            };
                        };
                    };
                };
            };
            echo 0;

            $_SESSION['search_clinic'] = '';
            $_SESSION['search_from'] = $dateofadmission_attd;
            $_SESSION['search_to'] = $dateofadmission_attd;
            $_SESSION['page'] = '';
            $_SESSION['remember_state'] = '';
        } 
        else 
        {
            echo 2;
        };
    };
}

function attend_update()
{
    global $con;
    $attend_id = mysqli_real_escape_string($con,$_POST['attend_id_attd']);
    $patient_id = mysqli_real_escape_string($con,$_POST['patient_id_attend']);
    $patient_age = mysqli_real_escape_string($con,$_POST['patient_age']);
    $clinic_attd = mysqli_real_escape_string($con,$_POST['clinic_attd']);
    $doctor_attd = mysqli_real_escape_string($con,$_POST['doctor_attd']);
    $typeofservice_attd = mysqli_real_escape_string($con,$_POST['typeofservice_attd']);
    $dateofadmission_attd = mysqli_real_escape_string($con,$_POST['dateofadmission_attd']);
    $dateofdischarge_attd = mysqli_real_escape_string($con,$_POST['dateofdischarge_attd']);
    $outcome = mysqli_real_escape_string($con,$_POST['outcome']);
    $type = mysqli_real_escape_string($con,$_POST['type_attd']);
    $status = mysqli_real_escape_string($con,$_POST['state_attd']);

    $user_id = $_SESSION['user_id'];
    date_default_timezone_set("Africa/Accra");
    $datetime = date('Y/m/d H:i:s');
    
    $query = "UPDATE attendance SET patient_id='$patient_id', clinic_id='$clinic_attd', date_admit='$dateofadmission_attd', date_disch='$dateofdischarge_attd', tos_id='$typeofservice_attd', age='$patient_age', doctor_id='$doctor_attd', outcome='$outcome', type='$type', status='$status', altered_by='$user_id', altered_datetime='$datetime' WHERE attend_id = '$attend_id'";
        $query_run = mysqli_query($con, $query);
        if ($query_run) 
        {
            //UPDATE SPONSORS
                $query_sponsor_del = "DELETE FROM `payment_type` WHERE `attend_id`='$attend_id'";
                mysqli_query($con, $query_sponsor_del);

                $number_as = count($_POST["attend_sponsor_id"]);  
                if($number_as > 0)  
                {  
                      for($i=0; $i<$number_as; $i++)  
                      {  
                       if(trim($_POST["attend_sponsor_id"][$i] !== '') && trim($_POST["attend_sponsor_id"][$i] !== 0))  
                       {  
                            $attend_sponsor_id = $_POST['attend_sponsor_id'][$i];
                            $attend_sponsor_member_no = $_POST['attend_sponsor_member_no'][$i];
                            $attend_sponsor_category = $_POST['attend_sponsor_category'][$i];
                            $attend_sponsor_principal = $_POST['attend_sponsor_principal'][$i];
                            $attend_sponsor_code = $_POST['nhisccc'][$i];
                            $attend_sponsor_expiry_date = $_POST['attend_sponsor_expiry_date'][$i];
                            $ghanacard_attd = $_POST['ghanacard_attd'][$i];
                            $serial_no = $_POST['serial_no'][$i];
                            
                            //SPECIALTY CODE
                            if($attend_sponsor_id == 2)
                            {
                                $specialty_attd = '';
                                if(isset($_POST["specialty_attd"]))
                                {
                                    $specialty_attd = implode(',',$_POST["specialty_attd"]);
                                };
                            }
                            else
                            {
                                $specialty_attd = 'N/A';
                            };
                            $type_of_attendnace = $_POST['type_of_attendnace'][$i];
                            $date_of_claim = $_POST['date_of_claim'][$i];
                            $pharmacy = $_POST['pharmacy'][$i];
                            $type_of_service_2 = $_POST['type_of_service_2'][$i];
                            $spell = $_POST['spell'][$i];

                            $dependant = '';
                            $dependant_name = '';
                            $dependant_no = '';
                            $relation = '';
                            $claim_no = '';

                            $query_pt = "INSERT INTO `payment_type`(
                            `attend_id`, `patient_id`, `ledger_id`, `principal`, `member_no`, `ins_class`, `code`, `expiry_date`,`ghanacard`, `serial_no`,
                            `specialty_1`, `type_of_attend`, `date_of_claim`, `pharmacy`, `type_of_serv_b`, `spell`, 
                            `dependant`, `dependant_name`, `dependant_no`, `relation`, `claim_no`, `date_admit`, `date_disch`) 
                            VALUES (
                            '$attend_id','$patient_id','$attend_sponsor_id','$attend_sponsor_principal','$attend_sponsor_member_no','$attend_sponsor_category',
                            '$attend_sponsor_code','$attend_sponsor_expiry_date','$ghanacard_attd','$serial_no','$specialty_attd','$type_of_attendnace','$date_of_claim','$pharmacy',
                            '$type_of_service_2','$spell','$dependant','$dependant_name','$dependant_no','$relation','$claim_no','$dateofadmission_attd','$dateofadmission_attd')";

                            $query_run_pt = mysqli_query($con, $query_pt);
                       };
                      };
                };
            
            if($type == 'Regular')
            {
                $query_sponsor = "SELECT * FROM payment_type WHERE attend_id='$attend_id' AND principal ='Yes'";
                $query_run_sponsor = mysqli_query($con, $query_sponsor);
                $row_sponsor = mysqli_fetch_assoc($query_run_sponsor);
                $service_sponsor = $row_sponsor['ledger_id'];

                //ENTER SERVICE BILL
                $query_clinic = "SELECT * FROM `clinics` WHERE `clinic_id`='$clinic_attd'";
                $query_run_clinic = mysqli_query($con, $query_clinic);
                if (mysqli_num_rows($query_run_clinic) > 0) 
                {
                    $row_clinic = mysqli_fetch_assoc($query_run_clinic);
                    $service_id = $row_clinic['item_id'];

                    $query_service_list = "SELECT * FROM service_list WHERE attend_id='$attend_id' AND service_id='$service_id' AND ledger_id='$service_sponsor'";
                    $query_run_service_list = mysqli_query($con, $query_service_list);
                    if (mysqli_num_rows($query_run_service_list) < 0) 
                    {
                        if ($service_id > 0) 
                        {
                            if ($service_sponsor == 1) 
                            {
                                $query = "SELECT * FROM `services` WHERE `service_id` ='$service_id'";
                                $query_run = mysqli_query($con, $query);
                                $row = mysqli_fetch_assoc($query_run);
                                $service_amt_cash = $row['price_cash'];
                                $service_amt_prvt = 0;
                                $service_amt_nhis = 0;
                                $service_gdrg = 0;
                            } 
                            else if($service_sponsor == 2) 
                            {
                                $query_nhis_item = "SELECT * FROM `services` WHERE `service_id` ='$service_id'";
                                $query_run_nhis_item = mysqli_query($con, $query_nhis_item);
                                $row_nhis_item = mysqli_fetch_assoc($query_run_nhis_item);
                                $nhis_id = $row_nhis_item['nhis_id'];

                                $query = "SELECT * FROM `nhis` WHERE `nhis_id` ='$nhis_id'";
                                $query_run = mysqli_query($con, $query);
                                $row = mysqli_fetch_assoc($query_run);
                                if ($patient_age < 12) 
                                {
                                    $service_amt_nhis = $row['price_child'];
                                    $service_amt_prvt = 0;
                                    $service_amt_cash = $row['price_topup'];
                                    $service_gdrg = $row['gdrg_child'];
                                } 
                                else 
                                {
                                    $service_amt_nhis = $row['price_adult'];
                                    $service_amt_prvt = 0;
                                    $service_amt_cash = $row['price_topup'];
                                    $service_gdrg = $row['gdrg_adult'];
                                };
                            }
                            else if($service_sponsor !== 1 && $service_sponsor !== 2) 
                            {
                                $prvt_led_id = $service_sponsor;
                                $query = "SELECT * FROM `price_list` WHERE `item_id` ='$service_id' AND `category_id` = 1 AND `ledger_id` ='$prvt_led_id'";
                                $query_run = mysqli_query($con, $query);
                                $row = mysqli_fetch_assoc($query_run);
                                $service_amt_prvt = $row['price'];
                                $service_amt_nhis = 0;
                                $service_amt_cash = $row['price_topup'];
                                $service_gdrg = 0;
                            };

                            $query = "INSERT INTO `service_list`(
                            `service_id`, `attend_id`, `patient_id`, `date`, `qty`, `g_drg`, `price_cash`, `price_nhis`, `price_prvt`, 
                            `amount_cash`, `amount_nhis`, `amount_prvt`, `comment`, `ledger_id`, `doctor_id`) 
                            VALUES (
                            '$service_id','$attend_id','$patient_id','$dateofadmission_attd',1,'$service_gdrg','$service_amt_cash','$service_amt_nhis',
                            '$service_amt_prvt','$service_amt_cash','$service_amt_nhis','$service_amt_prvt','no comment','$service_sponsor','$doctor_attd')";
                            $query_run = mysqli_query($con, $query);

                            if ($query_run)
                            {
                                $query_sl = "SELECT * FROM service_list WHERE attend_id='$attend_id' ORDER BY service_list_id DESC";
                                $query_run_sl = mysqli_query($con, $query_sl);
                                $row_sl=mysqli_fetch_assoc($query_run_sl);
                                $service_list_id = $row_sl['service_list_id'];
                                $service_date = $row_sl['date'];

                                $query_tr = "SELECT * FROM transactions WHERE attend_id='$attend_id' AND item_list_id='$service_list_id' AND category_id=1";
                                $query_run_tr = mysqli_query($con, $query_tr);
                                if (mysqli_num_rows($query_run_tr) > 0)
                                {
                                    $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=1 AND `item_list_id`='$service_list_id'";
                                    mysqli_query($con, $query_trans_del);

                                    if ($service_amt_cash > 0) 
                                    {
                                        $query_cash_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (1,9,'$attend_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_cash','$service_amt_cash',0,'Cash Service')";
                                        mysqli_query($con, $query_cash_dr);
                                        
                                        $query_cash_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (9,1,'$attend_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_cash',0,'$service_amt_cash','Cash Service')";
                                        mysqli_query($con, $query_cash_cr);

                                        /*AUTO ITEMISED RECEIPT
                                                $query_receipt_deposit = "SELECT * FROM receipt WHERE attend_id='$attend_id' AND patient_id='$patient_id' ORDER BY receipt_id ASC";
                                                $result_receipt_deposit = mysqli_query($con,$query_receipt_deposit);
                                                if (mysqli_num_rows($result_receipt_deposit) > 0)
                                                {
                                                    while($row_receipt_deposit = mysqli_fetch_assoc($result_receipt_deposit))
                                                    {
                                                        $receipt_id = $row_receipt_deposit['receipt_id'];
                                                        $amount_deposited = $row_receipt_deposit['amount'];

                                                        $query_receipt_item = "SELECT SUM(amount_rec) AS total_itemised FROM receipt_items WHERE receipt_id='$receipt_id'";
                                                        $result_receipt_item = mysqli_query($con,$query_receipt_item);
                                                        if (mysqli_num_rows($result_receipt_item) > 0)
                                                        {
                                                            $row_receipt_item = mysqli_fetch_assoc($result_receipt_item);
                                                            $amount_itemised = $row_receipt_item['total_itemised'];
                                                        }
                                                        else
                                                        {
                                                            $amount_itemised = 0;
                                                        };
                                                            $deposit_balance = $amount_deposited - $amount_itemised;
                                                            $item_list_id = $service_list_id;
                                                            $item_id = $service_id;
                                                            $category_id = 1;
                                                            $price = $service_price_cash;
                                                            $qty = $service_qty;
                                                            $amount_cash = $service_amt_cash;
                                                            $date = $service_date;
                                                        if($deposit_balance > $amount_cash)
                                                        {
                                                            $amount_rec = $amount_cash;
                                                        }
                                                        else
                                                        {
                                                            $amount_rec = $deposit_balance;
                                                        };
                                                        if($amount_rec > 0)
                                                        {
                                                            $query_rec_item = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,`attend_id`, `date`, `qty`, `price`, 
                                                            `amount_bill`, `amount_rec`, `type`) VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$qty',
                                                            '$price','$amount_cash','$amount_rec','itemise')";
                                                            $query_run_rec_item = mysqli_query($con, $query_rec_item);
                                                        };
                                                    };
                                                };*/
                                    } 
                                    if ($service_amt_prvt > 0)
                                    {
                                        $query_prvt_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES ('$prvt_led_id',9,'$attend_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt','$service_amt_prvt',0,'Insured Service')";
                                        mysqli_query($con, $query_prvt_dr);

                                        $query_prvt_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (9,'$prvt_led_id','$attend_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt',0,'$service_amt_prvt','Cash Service')";
                                        mysqli_query($con, $query_prvt_cr);
                                    }
                                    if ($service_amt_nhis > 0)
                                    {
                                        $query_nhis_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (2,9,'$attend_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis','$service_amt_nhis',0,'NHIS Service')";
                                        mysqli_query($con, $query_nhis_dr);

                                        $query_nhis_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (9,2,'$attend_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis',0,'$service_amt_nhis','NHIS Service')";
                                        mysqli_query($con, $query_nhis_cr);
                                    }
                                }
                                else
                                {
                                    if ($service_amt_cash > 0) 
                                    {
                                        $query_cash_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (1,9,'$attend_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_cash','$service_amt_cash',0,'Cash Service')";
                                        mysqli_query($con, $query_cash_dr);
                                        
                                        $query_cash_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (9,1,'$attend_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_cash',0,'$service_amt_cash','Cash Service')";
                                        mysqli_query($con, $query_cash_cr);

                                        /*AUTO ITEMISED RECEIPT
                                                $query_receipt_deposit = "SELECT * FROM receipt WHERE attend_id='$attend_id' AND patient_id='$patient_id' ORDER BY receipt_id ASC";
                                                $result_receipt_deposit = mysqli_query($con,$query_receipt_deposit);
                                                if (mysqli_num_rows($result_receipt_deposit) > 0)
                                                {
                                                    while($row_receipt_deposit = mysqli_fetch_assoc($result_receipt_deposit))
                                                    {
                                                        $receipt_id = $row_receipt_deposit['receipt_id'];
                                                        $amount_deposited = $row_receipt_deposit['amount'];

                                                        $query_receipt_item = "SELECT SUM(amount_rec) AS total_itemised FROM receipt_items WHERE receipt_id='$receipt_id'";
                                                        $result_receipt_item = mysqli_query($con,$query_receipt_item);
                                                        if (mysqli_num_rows($result_receipt_item) > 0)
                                                        {
                                                            $row_receipt_item = mysqli_fetch_assoc($result_receipt_item);
                                                            $amount_itemised = $row_receipt_item['total_itemised'];
                                                        }
                                                        else
                                                        {
                                                            $amount_itemised = 0;
                                                        };
                                                            $deposit_balance = $amount_deposited - $amount_itemised;
                                                            $item_list_id = $service_list_id;
                                                            $item_id = $service_id;
                                                            $category_id = 1;
                                                            $price = $service_price_cash;
                                                            $qty = $service_qty;
                                                            $amount_cash = $service_amt_cash;
                                                            $date = $service_date;
                                                        if($deposit_balance > $amount_cash)
                                                        {
                                                            $amount_rec = $amount_cash;
                                                        }
                                                        else
                                                        {
                                                            $amount_rec = $deposit_balance;
                                                        };
                                                        if($amount_rec > 0)
                                                        {
                                                            $query_rec_item = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,`attend_id`, `date`, `qty`, `price`, 
                                                            `amount_bill`, `amount_rec`, `type`) VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$qty',
                                                            '$price','$amount_cash','$amount_rec','itemise')";
                                                            $query_run_rec_item = mysqli_query($con, $query_rec_item);
                                                        };
                                                    };
                                                };*/
                                    } 
                                    if ($service_amt_prvt > 0)
                                    {
                                        $query_prvt_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES ('$prvt_led_id',9,'$attend_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt','$service_amt_prvt',0,'Insred Service')";
                                        mysqli_query($con, $query_prvt_dr);

                                        $query_prvt_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (9,'$prvt_led_id','$attend_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_prvt',0,'$service_amt_prvt','Insured Service')";
                                        mysqli_query($con, $query_prvt_cr);
                                    }
                                    if ($service_amt_nhis > 0)
                                    {
                                        $query_nhis_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (2,9,'$attend_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis','$service_amt_nhis',0,'NHIS Service')";
                                        mysqli_query($con, $query_nhis_dr);

                                        $query_nhis_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, `item_list_id`, `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES (9,2,'$attend_id','$service_list_id','$patient_id',1,'$service_date','$service_amt_nhis',0,'$service_amt_nhis','NHIS Service')";
                                        mysqli_query($con, $query_nhis_cr);
                                    }
                                };
                            };
                        };
                    };
                };
            };
            echo 0;
        } 
        else 
        {
            echo 2;
        };
}

function attend_open()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $attend_id = $_POST['attend_id'];
    $_SESSION['patient_id'] = $patient_id;
    $_SESSION['attend_id'] = $attend_id;
    $_SESSION['search_clinic'] = $_POST['search_clinic'];
    $_SESSION['search_from'] = $_POST['search_from'];
    $_SESSION['search_to'] = $_POST['search_to'];
    $_SESSION['page'] = $_POST['page'];
    $_SESSION['remember_state'] = $_POST['remember_state'];

    $query_patient = "SELECT * FROM patients WHERE patient_id ='$patient_id'";
    $query_run_patient = mysqli_query($con, $query_patient);
    $row_p = mysqli_fetch_assoc($query_run_patient);
    $_SESSION['folderno'] = $row_p['folderNo'];
    $_SESSION['name'] = $row_p['firstName'].' '.$row_p['lastName'];
    $_SESSION['gender'] = $row_p['gender'];
    $_SESSION['dob'] = $row_p['DOB'];
    $_SESSION['address'] = $row_p['address'];
    $_SESSION['BloodGroup'] = $row_p['BloodGroup'];
    $_SESSION['telephone'] = $row_p['telephone'];
    $_SESSION['relname'] = $row_p['relname'];
    $_SESSION['reltelephone'] = $row_p['reltelephone'];

    $query = "SELECT * FROM attendance WHERE attend_id='$attend_id'";
    $query_run = mysqli_query($con, $query);
    $row_a=mysqli_fetch_assoc($query_run);
    $_SESSION['age'] = $row_a['age'];
    $_SESSION['dateofadmission_attd'] = $row_a['date_admit'];
    $_SESSION['dateofdischarge_attd'] = $row_a['date_disch'];
    $_SESSION['typeofservice_attd'] = $row_a['tos_id'];
    $_SESSION['doctor_id'] = $row_a['doctor_id'];
    $_SESSION['clinic'] = $row_a['clinic_id'];
    $_SESSION['Schname'] = $row_a['nhis_led_id'];
    $_SESSION['nhismemberno'] = $row_a['nhis_no'];
    $_SESSION['serial_no'] = $row_a['serial_no'];
    $_SESSION['ghanacard'] = $row_a['ghanacard'];
    $_SESSION['nhisexpirydate'] = $row_a['nhis_date'];
    $_SESSION['nhisccc'] = $row_a['nhis_ccc'];
    $_SESSION['prtinsname'] = $row_a['prvt_led_id'];
    $_SESSION['prtmemberno'] = $row_a['prvt_no'];
    $_SESSION['prtexpirydate'] = $row_a['prvt_date'];
    $_SESSION['spec_1_id'] = $row_a['spec_1_id'];
    $_SESSION['spec_2_id'] = $row_a['spec_2_id'];
    $_SESSION['spec_3_id'] = $row_a['spec_3_id'];
    $_SESSION['spec_1_code'] = $row_a['spec_1_code'];
    $_SESSION['spec_2_code'] = $row_a['spec_2_code'];
    $_SESSION['spec_3_code'] = $row_a['spec_3_code'];
    $_SESSION['type_of_attend'] = $row_a['toa'];
    $_SESSION['outcome'] = $row_a['outcome'];
    $_SESSION['tos_2'] = $row_a['tos_2'];
    $_SESSION['pharmacy'] = $row_a['pharmacy'];
    $_SESSION['spell'] = $row_a['duration_of_spell'];
    $_SESSION['claim_no'] = $row_a['claim_no'];
    $_SESSION['date_of_claim'] = $row_a['date_of_claim'];
    $_SESSION['dependant'] = $row_a['dependant'];

    if ($row_a['nhis_led_id'] > 0 && $row_a['prvt_led_id'] > 0 ) {
        $_SESSION['sponsor'] = $row_a['nhis_led_id'];
    }
    else if ($row_a['nhis_led_id'] > 0 && $row_a['prvt_led_id'] <= 0 ){
        $_SESSION['sponsor'] = $row_a['nhis_led_id'];
    }
    else if ($row_a['nhis_led_id'] <= 0 && $row_a['prvt_led_id'] > 0 ){
        $_SESSION['sponsor'] = $row_a['prvt_led_id'];
    }
    else if ($row_a['nhis_led_id'] <= 0 && $row_a['prvt_led_id'] <= 0 ){
        $_SESSION['sponsor'] = 1;
    };
}

function attend_sponsor_list_edit()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $value = "";
    $value = '<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="attend_sponsor_table">
                <tr>
                    <th width="30%">Sponsor</th>
                    <th width="15%">Membership No</th>
                    <th width="20%">Category</th>
                    <th width="10%">Is Prinicipal</th>
                    <th width="10%">Code</th>
                    <th width="10%">Expiry Date</th>
                    <th width="5%" class="action-td">Action</th>
                </tr>';
    $query = "SELECT * FROM payment_type WHERE attend_id ='$attend_id'";
    $query_run = mysqli_query($con, $query);
    $i=0;
    if (mysqli_num_rows($query_run) > 0)
    {
        
        while($row = mysqli_fetch_assoc($query_run))
        {
            $i=++$i;
            $value.='<tr id="'.$i.'">
                        <td>
                            <select class="form-control bg-light attend_sponsor_id" name="attend_sponsor_id[]" id="attend_sponsor_id'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                
                                    $sql_sponor = "SELECT * FROM ledgers WHERE tb_5 = 1 ORDER BY ledger_desc"; 
                                    $result_sponor = mysqli_query($con,$sql_sponor);
                                    while($row_sponor = mysqli_fetch_array($result_sponor))
                                    {
                                        if($row['ledger_id'] == $row_sponor['ledger_id'])
                                        {
                                            $value .= '<option value ="'.$row_sponor['ledger_id'].'" selected="selected">'.$row_sponor['ledger_desc'].'</option>';
                                        }
                                        else
                                        {
                                            $value .= '<option value ="'.$row_sponor['ledger_id'].'">'.$row_sponor['ledger_desc'].'</option>';
                                        };
                                    }
                                
                 $value .= '</select>
                        </td>
                        <td>
                            <input type="text" name="attend_sponsor_member_no[]" class="form-control bg-light attend_sponsor_member_no" id="attend_sponsor_member_no'.$i.'" data-id="'.$i.'" style="border-width:0px" value="'.$row['member_no'].'">
                        </td>
                        <td>
                            <input type="text" name="attend_sponsor_category[]" class="form-control bg-light attend_sponsor_category" id="attend_sponsor_category'.$i.'" data-id="'.$i.'" style="border-width:0px" value="'.$row['ins_class'].'">
                        </td>
                        <td>
                            <select class="form-control bg-light attend_sponsor_principal" name="attend_sponsor_principal[]" id="attend_sponsor_principal'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                if($row['principal'] == 'Yes')
                                {
                                    $value .= '<option value ="Yes" selected="selected">Yes</option>';
                                }
                                else
                                {
                                    $value .= '<option value ="No" selected="selected">No</option>';
                                };
                  $value .= '</select>
                        </td>
                        <td>
                            <input type="text" name="attend_sponsor_code[]" class="form-control bg-light" id="attend_sponsor_code'.$i.'" style="border-width:0px" value="'.$row['code'].'">
                        </td>
                        <td>
                            <input type="date" name="attend_sponsor_expiry_date[]" class="form-control bg-light" id="attend_sponsor_expiry_date1" style="border-width:0px" value="'.$row['expiry_date'].'">
                        </td>
                        <td class="action-td">
                            <a href="#" id="delete_attend_sponsor" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                        </td>
                    </tr>';
        }

    };
        $i=++$i;
        $value.='<tr id="'.$i.'">
                        <td>
                            <select class="form-control bg-light attend_sponsor_id" name="attend_sponsor_id[]" id="attend_sponsor_id'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                
                                    $sql_sponor = "SELECT * FROM ledgers WHERE tb_5 = 1 ORDER BY ledger_desc"; 
                                    $result_sponor = mysqli_query($con,$sql_sponor);
                                    while($row_sponor = mysqli_fetch_array($result_sponor))
                                    {
                                        $value .= '<option value ="'.$row_sponor['ledger_id'].'">'.$row_sponor['ledger_desc'].'</option>';
                                    }
                                
                 $value .= '</select>
                        </td>
                        <td>
                            <input type="text" name="attend_sponsor_member_no[]" class="form-control bg-light attend_sponsor_member_no" id="attend_sponsor_member_no'.$i.'" data-id="'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="attend_sponsor_category[]" class="form-control bg-light attend_sponsor_category" id="attend_sponsor_category'.$i.'" data-id="'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <select class="form-control bg-light attend_sponsor_principal" name="attend_sponsor_principal[]" id="attend_sponsor_principal'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                <option value="0">Please Select</option>
                                <option value ="Yes">Yes</option>
                                <option value ="No">No</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="attend_sponsor_code[]" class="form-control bg-light" id="attend_sponsor_code'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="date" name="attend_sponsor_expiry_date[]" class="form-control bg-light" id="attend_sponsor_expiry_date'.$i.'" style="border-width:0px">
                        </td>
                        <td class="action-td">
                            <a href="#" id="delete_attend_sponsor" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>';
    echo $value;
}

function attend_alter()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $schname_attd = $_POST['schname_attd'];
    $nhismemberno_attd = mysqli_real_escape_string($con,$_POST['nhismemberno_attd']);
    $serial_no = mysqli_real_escape_string($con,$_POST['serial_no']);
    $ghanacard_attd = mysqli_real_escape_string($con,$_POST['ghanacard_attd']);
    $nhisexpirydate_attd = $_POST['nhisexpirydate_attd'];
    $nhisccc = mysqli_real_escape_string($con,$_POST['nhisccc']);
    $prtinsname_attd = $_POST['prtinsname_attd'];
    $prtmemberno_attd = mysqli_real_escape_string($con,$_POST['prtmemberno_attd']);
    $prtexpirydate_attd = $_POST['prtexpirydate_attd'];
    $dependant = $_POST['dependant'];
    $patient_id = $_POST['patient_id_attend'];
    $clinic_attd = $_POST['clinic_attd'];
    $dateofadmission_attd = $_POST['dateofadmission_attd'];
    $dateofdischarge_attd = $_POST['dateofdischarge_attd'];
    $typeofservice_attd = $_POST['typeofservice_attd'];
    $patient_age = $_POST['patient_age'];
    $spell = $_POST['spell'];
    $outcome = $_POST['outcome'];
    $specialty_attd_1 = $_POST['specialty_attd_1'];
    $spec_code_1 = $_POST['spec_code_1'];
    $specialty_attd_2 = $_POST['specialty_attd_2'];
    $spec_code_2 = $_POST['spec_code_2'];
    $specialty_attd_3 = $_POST['specialty_attd_3'];
    $spec_code_3 = $_POST['spec_code_3'];
    $type_of_attendnace = $_POST['type_of_attendnace'];
    $date_of_claim = $_POST['date_of_claim'];
    $pharmacy = $_POST['pharmacy'];
    $type_of_service_2 = $_POST['type_of_service_2'];
    $query = "UPDATE `attendance` SET `patient_id`='$patient_id',`clinic_id`='$clinic_attd',`date_admit`='$dateofadmission_attd',`date_disch`='$dateofdischarge_attd',`nhis_led_id`='$schname_attd',`nhis_no`='$nhismemberno_attd',`nhis_date`='$nhisexpirydate_attd',`nhis_ccc`='$nhisccc',`prvt_led_id`='$prtinsname_attd',`prvt_no`='$prtmemberno_attd',`prvt_date`='$prtexpirydate_attd',`tos_id`='$typeofservice_attd',`age`='$patient_age',`serial_no`='$serial_no',`ghanacard`='$ghanacard_attd',`outcome`='$outcome',`tos_2`='$type_of_service_2',`pharmacy`='$pharmacy',`toa`='$type_of_attendnace',`date_of_claim`='$date_of_claim',`spec_1_id`='$specialty_attd_1',`spec_2_id`='$specialty_attd_2',`spec_3_id`='$specialty_attd_3',`spec_1_code`='$spec_code_1',`spec_2_code`='$spec_code_2',`spec_3_code`='$spec_code_3',`duration_of_spell`='$spell',`dependant`='$dependant' WHERE `attend_id`='$attend_id'";
    $query_run = mysqli_query($con, $query);
    echo 0;
}

function search_attend_opd_by_name()
{
    global $con;
    date_default_timezone_set("Africa/Accra");
    $date_today = date('Y-m-d');
    $output = '';
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $start = mysqli_real_escape_string($con, $_POST["start"]);
    $end = mysqli_real_escape_string($con, $_POST["end"]);
    if($name !='' && $start =='')
    {
        $query = "SELECT A.*, P.firstName, P.lastName, P.telephone, P.folderNo, P.full_name FROM `patients` 
        AS P JOIN `attendance` AS A ON A.patient_id = P.patient_id WHERE 
        (P.firstName LIKE '%".$name."%' AND tos_id=1 AND date_admit='$date_today')
        OR (P.lastName LIKE '%".$name."%' AND tos_id=1 AND date_admit='$date_today')
        OR (P.telephone LIKE '%".$name."%' AND tos_id=1 AND date_admit='$date_today')
        OR (P.folderNo LIKE '%".$name."%' AND tos_id=1 AND date_admit='$date_today')
        OR (P.full_name LIKE '%".$name."%' AND tos_id=1 AND date_admit='$date_today')
        ";
    }
    else if($name !='' && $start !='')
    {
        $query = "SELECT A.*, P.firstName, P.lastName, P.telephone, P.folderNo, P.full_name FROM `patients` 
        AS P JOIN `attendance` AS A ON A.patient_id = P.patient_id WHERE 
        (P.firstName LIKE '%".$name."%' AND tos_id=1 AND date_admit BETWEEN '$start' AND '$end')
        OR (P.lastName LIKE '%".$name."%' AND tos_id=1 AND date_admit BETWEEN '$start' AND '$end')
        OR (P.telephone LIKE '%".$name."%' AND tos_id=1 AND date_admit BETWEEN '$start' AND '$end')
        OR (P.folderNo LIKE '%".$name."%' AND tos_id=1 AND date_admit BETWEEN '$start' AND '$end')
        OR (P.full_name LIKE '%".$name."%' AND tos_id=1 AND date_admit BETWEEN '$start' AND '$end')
        ";
    }
    else if($name =='' && $start =='')
    {
        $query = "SELECT A.*, P.firstName, P.lastName, P.telephone, P.folderNo, P.full_name FROM `patients` 
        AS P JOIN `attendance` AS A ON A.patient_id = P.patient_id WHERE 
        (P.firstName LIKE '%".$name."%' AND tos_id=1 AND date_admit='$date_today')
        OR (P.lastName LIKE '%".$name."%' AND tos_id=1 AND date_admit='$date_today')
        OR (P.telephone LIKE '%".$name."%' AND tos_id=1 AND date_admit='$date_today')
        OR (P.folderNo LIKE '%".$name."%' AND tos_id=1 AND date_admit='$date_today')
        OR (P.full_name LIKE '%".$name."%' AND tos_id=1 AND date_admit='$date_today')
        ";
    }
    else if($name =='' && $start !='')
    {
        $query = "SELECT A.*, P.firstName, P.lastName, P.telephone, P.folderNo, P.full_name FROM `patients` 
        AS P JOIN `attendance` AS A ON A.patient_id = P.patient_id WHERE 
        (P.firstName LIKE '%".$name."%' AND tos_id=1 AND date_admit BETWEEN '$start' AND '$end')
        OR (P.lastName LIKE '%".$name."%' AND tos_id=1 AND date_admit BETWEEN '$start' AND '$end')
        OR (P.telephone LIKE '%".$name."%' AND tos_id=1 AND date_admit BETWEEN '$start' AND '$end')
        OR (P.folderNo LIKE '%".$name."%' AND tos_id=1 AND date_admit BETWEEN '$start' AND '$end')
        OR (P.full_name LIKE '%".$name."%' AND tos_id=1 AND date_admit BETWEEN '$start' AND '$end')
        ";
    };
    $query_run = mysqli_query($con, $query);
    $output .= '
      <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Folder No</th>
                <th>Patient Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Attendance Date</th>
                <th>Clinic</th>
                <th>Payment Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">';
    
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $attend_id = $row['attend_id'];
            
    $output .= '<tr>
                    <td class="action-td">
                        <a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['folderNo'].'</a>
                    </td>';
                    
                        $patient_id=$row['patient_id'];
                        $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                        $query_run_p = mysqli_query($con, $query_p);
                        $row_p=mysqli_fetch_assoc($query_run_p);

                        $gender_id=$row_p['gender'];
                        $query_g = "SELECT * FROM gender WHERE gender_id='$gender_id'";
                        $query_run_g = mysqli_query($con, $query_g);
                        $row_g=mysqli_fetch_assoc($query_run_g);
                    
        $output .= '<td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_p['firstName']." ". $row_p['lastName'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['age'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_g['gender'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['date_admit'].'</a></td>';
                    
                        $query_sponsor = "SELECT * FROM payment_type WHERE attend_id='$attend_id' AND principal ='Yes'";
                        
                        $query_run_sponsor = mysqli_query($con, $query_sponsor);
                        $row_sponsor = mysqli_fetch_assoc($query_run_sponsor);
                        if(isset($row_sponsor))
                        {
                            $sponsor_id = $row_sponsor['ledger_id'];
                            $query = "SELECT * FROM ledgers WHERE ledger_id = '$sponsor_id'";
                            $query_run_led = mysqli_query($con, $query);
                            $row_led = mysqli_fetch_assoc($query_run_led);
                            $sponsor_desc = $row_led['ledger_desc'];
                        }
                        else
                        {
                            $sponsor_id = 0;
                            $sponsor_desc = 'N/A';
                        };
                        
                        $clinic_id=$row['clinic_id'];
                        $query_cl = "SELECT * FROM clinics WHERE clinic_id='$clinic_id'";
                        $query_run_cl = mysqli_query($con, $query_cl);
                        $row_cl=mysqli_fetch_assoc($query_run_cl);
                        if(isset($row_cl)){$clinic_name = $row_cl['clinic_desc'];}else{$clinic_name = 'WALK-IN';};
                    
        $output .= '<td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$clinic_name.'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$sponsor_desc.'</a></td>
                    <td>';
                    
                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Attendance_Cash_Statement'] == 'Yes')) 
                        {
                            $output .= '<a href="#" id="btn_cash_statement_attend" 
                            data-id="'.$row['attend_id'].'" 
                            data-id1="'.$row['patient_id'].'"
                            data-id2="'.$row['date_admit'].'">
                            Cash Stat.
                            </a>';
                            if($sponsor_id != 1 && $sponsor_id != 2)
                            {
                                $output .=' | <a href="#" id="btn_insurance_statement_attend" 
                                data-id="'.$row['attend_id'].'" 
                                data-id1="'.$row['patient_id'].'"
                                data-id2="'.$row['date_admit'].'"
                                data-id3="'.$sponsor_id.'">
                                Sponsor Stat.
                                </a>';
                            };
                        };
                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Cashier_Attendance_list'] == 'Yes')) 
                        {
                            $output .=' | <a href="#" 
                            id="btn_new_receipt" 
                            data-id="'.$row['attend_id'].'" 
                            data-id1="'.$row_p['firstName']." ". $row_p['lastName'].'"
                            data-id2="'.$row['patient_id'].'">New Receipt</a>';
                        };
                         if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Attendance'] == 'Yes')) 
                        {
                            $output .= ' | <a href="#" id="btn_delete_attend" data-id="'.$row['attend_id'].'">Delete Attend. Sht.</a>';
                        };
                    
         $output .= '</td>
                </tr>';
            
                    }
                };
            
     $output .= '</tbody>
    </table>';
     echo $output;
}

function search_attend_opd()
{
    global $con;
    $output = '';
    $clinic = mysqli_real_escape_string($con, $_POST["clinic"]);
    $date_from = mysqli_real_escape_string($con, $_POST["date_from"]);
    $date_to = mysqli_real_escape_string($con, $_POST["date_to"]);
    $company_id = mysqli_real_escape_string($con, $_POST["company_id"]);

    if($date_from !==0 && $date_to !==0 && $clinic > 0)
    {
        $query = "SELECT * FROM attendance WHERE tos_id=1 AND date_admit BETWEEN '$date_from' AND '$date_to' AND clinic_id='$clinic' AND company_id = '$company_id'";
    }
    else if($date_from !==0 && $date_to !==0 && $clinic ==0)
    {
        $query = "SELECT * FROM attendance WHERE tos_id=1 AND date_admit BETWEEN '$date_from' AND '$date_to' AND company_id = '$company_id'";
    }
    else if($date_from ==0 && $date_to ==0 && $clinic ==0)
    {
        $query = "SELECT * FROM attendance WHERE tos_id=1 AND date_admit = CURDATE() AND company_id = '$company_id' ORDER BY attend_id";
    }
    else if($date_from ==0 && $date_to ==0 && $clinic > 0)
    {
        $query = "SELECT * FROM attendance WHERE tos_id=1 AND date_admit = CURDATE() AND clinic_id='$clinic' AND company_id = '$company_id' ORDER BY attend_id";
    }
    $query_run = mysqli_query($con, $query);
    $output .= '
      <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Attendance ID</th>
                <th>Patient Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Attendance Date</th>
                <th>Clinic</th>
                <th>Payment Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">';
    
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $attend_id = $row['attend_id'];

                        $patient_id=$row['patient_id'];
                        $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                        $query_run_p = mysqli_query($con, $query_p);
                        $row_p=mysqli_fetch_assoc($query_run_p);
            
    $output .= '<tr>
                    <td class="action-td">
                        <a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_p['folderNo'].'</a>
                    </td>';
                    

                        $gender_id=$row_p['gender'];
                        $query_g = "SELECT * FROM gender WHERE gender_id='$gender_id'";
                        $query_run_g = mysqli_query($con, $query_g);
                        $row_g=mysqli_fetch_assoc($query_run_g);
                    
        $output .= '<td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_p['firstName']." ". $row_p['lastName'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['age'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_g['gender'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['date_admit'].'</a></td>';
                    
                        $query_sponsor = "SELECT * FROM payment_type WHERE attend_id='$attend_id' AND principal ='Yes'";
                        
                        $query_run_sponsor = mysqli_query($con, $query_sponsor);
                        $row_sponsor = mysqli_fetch_assoc($query_run_sponsor);
                        if(isset($row_sponsor))
                        {
                            $sponsor_id = $row_sponsor['ledger_id'];
                            $query = "SELECT * FROM ledgers WHERE ledger_id = '$sponsor_id'";
                            $query_run_led = mysqli_query($con, $query);
                            $row_led = mysqli_fetch_assoc($query_run_led);
                            $sponsor_desc = $row_led['ledger_desc'];
                        }
                        else
                        {
                            $sponsor_id = 0;
                            $sponsor_desc = 'N/A';
                        };
                        
                        $clinic_id=$row['clinic_id'];
                        $query_cl = "SELECT * FROM clinics WHERE clinic_id='$clinic_id'";
                        $query_run_cl = mysqli_query($con, $query_cl);
                        $row_cl=mysqli_fetch_assoc($query_run_cl);
                        if(isset($row_cl)){$clinic_name = $row_cl['clinic_desc'];}else{$clinic_name = 'WALK-IN';};
                    
        $output .= '<td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$clinic_name.'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$sponsor_desc.'</a></td>
                    <td>';
                    
                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Attendance_Cash_Statement'] == 'Yes')) 
                        {
                            $output .= '<a href="#" id="btn_cash_statement_attend" 
                            data-id="'.$row['attend_id'].'" 
                            data-id1="'.$row['patient_id'].'"
                            data-id2="'.$row['date_admit'].'">
                            Cash Stat.
                            </a>';
                            if($sponsor_id != 1 && $sponsor_id != 2)
                            {
                                $output .=' | <a href="#" id="btn_insurance_statement_attend" 
                                data-id="'.$row['attend_id'].'" 
                                data-id1="'.$row['patient_id'].'"
                                data-id2="'.$row['date_admit'].'"
                                data-id3="'.$sponsor_id.'">
                                Sponsor Stat.
                                </a>';
                            };
                        };
                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Cashier_Attendance_list'] == 'Yes')) 
                        {
                            $output .=' | <a href="#" 
                            id="btn_new_receipt" 
                            data-id="'.$row['attend_id'].'" 
                            data-id1="'.$row_p['firstName']." ". $row_p['lastName'].'"
                            data-id2="'.$row['patient_id'].'">New Receipt</a>';
                        };
                         if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Attendance'] == 'Yes')) 
                        {
                            $output .= ' | <a href="#" id="btn_delete_attend" data-id="'.$row['attend_id'].'">Delete Attend. Sht.</a>';
                        };
                    
         $output .= '</td>
                </tr>';
            
                    }
                };
            
     $output .= '</tbody>
    </table>';
     echo $output;
}

function search_attend_ipd_by_name()
{
    global $con;
    $output = '';
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $query = "SELECT A.*, P.firstName, P.lastName, P.telephone, P.folderNo, P.full_name FROM `patients` 
    AS P JOIN `attendance` AS A ON A.patient_id = P.patient_id WHERE 
    (P.firstName LIKE '%".$name."%' AND tos_id=2 AND outcome='on_admission')
      OR (P.lastName LIKE '%".$name."%' AND tos_id=2 AND outcome='on_admission')
      OR (P.telephone LIKE '%".$name."%' AND tos_id=2 AND outcome='on_admission')
      OR (P.folderNo LIKE '%".$name."%' AND tos_id=2 AND outcome='on_admission')
      OR (P.full_name LIKE '%".$name."%' AND tos_id=2 AND outcome='on_admission')
     ";
    $query_run = mysqli_query($con, $query);
    $output .= '
      <table class="table table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="action-td" width="10%">Attendance ID</th>
                <th class="action-td" width="20%">Patient Name</th>
                <th class="action-td" width="5%">Age</th>
                <th class="action-td" width="5%">Gender</th>
                <th class="action-td" width="10%">Attendance Date</th>
                <th class="action-td" width="10%">Type of Service</th>
                <th class="action-td" width="10%">Ward</th>
                <th class="action-td" width="5%">Bed</th>
                <th class="action-td" width="15%">Payment Type</th>
                <th class="action-td" width="10%">Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">
     ';
    
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $attend_id=$row['attend_id'];
                        $patient_id=$row['patient_id'];
                        $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                        $query_run_p = mysqli_query($con, $query_p);
                        $row_p=mysqli_fetch_assoc($query_run_p);
            
             $output .= '<tr style="background-color:#E4E1E0">
                            <td class="action-td">
                                <a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_p['folderNo'].'</a>
                            </td>';
                                
                                    $gender_id=$row_p['gender'];
                                    $query_g = "SELECT * FROM gender WHERE gender_id='$gender_id'";
                                    $query_run_g = mysqli_query($con, $query_g);
                                    $row_g=mysqli_fetch_assoc($query_run_g);
                                
                $output .= '<td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_p['firstName']." ". $row_p['lastName'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row['age'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_g['gender'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row['date_admit'].'</strong></a></td>';
                                
                                    $query_tos = "SELECT * FROM type_of_service WHERE tos_id=2";
                                    $query_run_tos = mysqli_query($con, $query_tos);
                                    $row_tos=mysqli_fetch_assoc($query_run_tos);
                                    
                                    $query_wl = "SELECT * FROM wardlist WHERE attend_id='$attend_id' ORDER BY wardlist_id DESC";
                                    $query_run_wl = mysqli_query($con, $query_wl);
                                    $row_wl=mysqli_fetch_assoc($query_run_wl);

                                    $ward_id=$row_wl['ward_id'];
                                    $query_wd = "SELECT * FROM ward WHERE ward_id='$ward_id'";
                                    $query_run_wd = mysqli_query($con, $query_wd);
                                    $row_wd=mysqli_fetch_assoc($query_run_wd);

                                    $bed_id=$row_wl['bed_id'];
                                    $query_bd = "SELECT * FROM bed WHERE ward_id='$ward_id' AND bed_id='$bed_id'";
                                    $query_run_bd = mysqli_query($con, $query_bd);
                                    $row_bd=mysqli_fetch_assoc($query_run_bd);

                                    $query_mg = "SELECT * FROM management_plan WHERE attend_id='$attend_id' ORDER BY mp_id DESC";
                                    $query_run_mg = mysqli_query($con, $query_mg);
                                    $row_mg=mysqli_fetch_assoc($query_run_mg);

                                    $query_pt = "SELECT * FROM payment_type WHERE attend_id='$attend_id' AND principal='Yes'";
                                    $query_run_pt = mysqli_query($con, $query_pt);
                                    if(isset($query_run_pt) && mysqli_num_rows($query_run_pt) > 0)
                                    {
                                        $row_pt = mysqli_fetch_array($query_run_pt);
                                        $sponsor_id = $row_pt['ledger_id'];
                                        $query_ptl = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
                                        $query_run_ptl = mysqli_query($con, $query_ptl);
                                        $row_ptl = mysqli_fetch_assoc($query_run_ptl);
                                        $sponsor_led = $row_ptl['ledger_desc'];
                                    }
                                    else
                                    {
                                        $sponsor_id = 0;
                                        $sponsor_led = 'Unspecified';
                                    };
                                
                $output .= '<td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_tos['description'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_wd['ward'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_bd['bed'].'</strong></a></td>
                            <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$sponsor_led.'</strong></a></td>
                            <td class="action-td">';
                                
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Attendance_Cash_Statement'] == 'Yes')) 
                                    {
                                        $output .= '<a href="#" id="btn_cash_statement_attend" 
                                                data-id="'.$row['attend_id'].'" 
                                                data-id1="'.$row['patient_id'].'"
                                                data-id2="'.$row['date_admit'].'">
                                                Cash Stat.
                                            </a>';
                                            if($sponsor_id != 1 && $sponsor_id != 2)
                                            {
                                                $output .=' | <a href="#" id="btn_insurance_statement_attend" 
                                                data-id="'.$row['attend_id'].'" 
                                                data-id1="'.$row['patient_id'].'"
                                                data-id2="'.$row['date_admit'].'"
                                                data-id3="'.$sponsor_id.'">
                                                Sponsor Stat.
                                                </a>';
                                            };
                                    };
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Cashier_Attendance_list'] == 'Yes')) 
                                    {
                                        $output .=' | <a href="#" 
                                        id="btn_new_receipt" 
                                        data-id="'.$row['attend_id'].'" 
                                        data-id1="'.$row_p['firstName']." ". $row_p['lastName'].'"
                                        data-id2="'.$row['patient_id'].'">New Receipt</a>';
                                    };
                                     if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Attendance'] == 'Yes')) 
                                    {
                                        $output .= ' | <a href="#" id="btn_delete_attend" data-id="'.$row['attend_id'].'">Delete</a>';
                                    };
                                
                 $output .= '</td>
                        </tr>
                        <tr>
                            <td style="border-bottom:none"><strong><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><i>'; 
                            if(isset($row_mg['date'])){$output .= $row_mg['date'];}else{$output .= 'No plan yet';};
                            $output .= '</i></a></strong></td>
                            <td style="border-bottom:none"><strong><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><i>'; 
                            if(isset($row_mg['initials'])){$output .= $row_mg['initials'];}else{$output .= 'No plan yet';};
                            $output .= '</i></a></strong></td>
                            <td colspan=8 style="border-bottom:none"><strong><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><i>'; 
                            if(isset($row_mg['mgt_notes'])){$output .=  $row_mg['mgt_notes'];}else{$output .= 'No plan yet';};
                            $output .= '</i></a><strong></td>
                        </tr>
                        <tr>';
                            $output .= '<td colspan=10 style="border-right:none;border-left:none;border-top:none;border-width: medium;"></td>
                        </tr>';
            
                    }
                }
                else
                {
                        $output .= 'No Record Found';
                };
            
     $output .= '</tbody>
    </table>';
     echo $output;
}

function search_attend_ipd_by_ward()
{
    global $con;
    $output = '';
    $ward = mysqli_real_escape_string($con, $_POST["ward"]);

    $query = "SELECT A.*, w.ward_id FROM wardlist AS w JOIN attendance AS A ON  A.attend_id = w.attend_id
    WHERE tos_id=2 AND outcome = 'on_admission' AND 
    w.ward_id='$ward' ORDER BY A.attend_id";
    $query_run = mysqli_query($con, $query);
    $output .= '
      <table class="table table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="action-td" width="10%">Folder No</th>
                <th class="action-td" width="20%">Patient Name</th>
                <th class="action-td" width="5%">Age</th>
                <th class="action-td" width="5%">Gender</th>
                <th class="action-td" width="10%">Attendance Date</th>
                <th class="action-td" width="10%">Type of Service</th>
                <th class="action-td" width="10%">Ward</th>
                <th class="action-td" width="5%">Bed</th>
                <th class="action-td" width="15%">Payment Type</th>
                <th class="action-td" width="10%">Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">
     ';
    
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $attend_id=$row['attend_id'];
                        $patient_id=$row['patient_id'];
                        $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                        $query_run_p = mysqli_query($con, $query_p);
                        $row_p=mysqli_fetch_assoc($query_run_p);
            
             $output .= '<tr style="background-color:#E4E1E0">
                            <td class="action-td">
                                <a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_p['folderNo'].'</a>
                            </td>';
                                
                                    $gender_id=$row_p['gender'];
                                    $query_g = "SELECT * FROM gender WHERE gender_id='$gender_id'";
                                    $query_run_g = mysqli_query($con, $query_g);
                                    $row_g=mysqli_fetch_assoc($query_run_g);
                                
                $output .= '<td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_p['firstName']." ". $row_p['lastName'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row['age'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_g['gender'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row['date_admit'].'</strong></a></td>';
                                
                                    $query_tos = "SELECT * FROM type_of_service WHERE tos_id=2";
                                    $query_run_tos = mysqli_query($con, $query_tos);
                                    $row_tos=mysqli_fetch_assoc($query_run_tos);
                                    
                                    $query_wl = "SELECT * FROM wardlist WHERE attend_id='$attend_id' ORDER BY wardlist_id DESC";
                                    $query_run_wl = mysqli_query($con, $query_wl);
                                    $row_wl=mysqli_fetch_assoc($query_run_wl);

                                    $ward_id=$row_wl['ward_id'];
                                    $query_wd = "SELECT * FROM ward WHERE ward_id='$ward_id'";
                                    $query_run_wd = mysqli_query($con, $query_wd);
                                    $row_wd=mysqli_fetch_assoc($query_run_wd);

                                    $bed_id=$row_wl['bed_id'];
                                    $query_bd = "SELECT * FROM bed WHERE ward_id='$ward_id' AND bed_id='$bed_id'";
                                    $query_run_bd = mysqli_query($con, $query_bd);
                                    $row_bd=mysqli_fetch_assoc($query_run_bd);

                                    $query_mg = "SELECT * FROM management_plan WHERE attend_id='$attend_id' ORDER BY mp_id DESC";
                                    $query_run_mg = mysqli_query($con, $query_mg);
                                    $row_mg=mysqli_fetch_assoc($query_run_mg);

                                    $query_pt = "SELECT * FROM payment_type WHERE attend_id='$attend_id' AND principal='Yes'";
                                    $query_run_pt = mysqli_query($con, $query_pt);
                                    if(isset($query_run_pt) && mysqli_num_rows($query_run_pt) > 0)
                                    {
                                        $row_pt = mysqli_fetch_array($query_run_pt);
                                        $sponsor_id = $row_pt['ledger_id'];
                                        $query_ptl = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
                                        $query_run_ptl = mysqli_query($con, $query_ptl);
                                        $row_ptl = mysqli_fetch_assoc($query_run_ptl);
                                        $sponsor_led = $row_ptl['ledger_desc'];
                                    }
                                    else
                                    {
                                        $sponsor_id = 0;
                                        $sponsor_led = 'Unspecified';
                                    };
                                
                $output .= '<td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_tos['description'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_wd['ward'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_bd['bed'].'</strong></a></td>
                            <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$sponsor_led.'</strong></a></td>
                            <td class="action-td">';
                                
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Attendance_Cash_Statement'] == 'Yes')) 
                                    {
                                        $output .= '<a href="#" id="btn_cash_statement_attend" 
                                                data-id="'.$row['attend_id'].'" 
                                                data-id1="'.$row['patient_id'].'"
                                                data-id2="'.$row['date_admit'].'">
                                                Cash Stat.
                                            </a>';
                                            if($sponsor_id != 1 && $sponsor_id != 2)
                                            {
                                                $output .=' | <a href="#" id="btn_insurance_statement_attend" 
                                                data-id="'.$row['attend_id'].'" 
                                                data-id1="'.$row['patient_id'].'"
                                                data-id2="'.$row['date_admit'].'"
                                                data-id3="'.$sponsor_id.'">
                                                Sponsor Stat.
                                                </a>';
                                            };
                                    };
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Cashier_Attendance_list'] == 'Yes')) 
                                    {
                                        $output .=' | <a href="#" 
                                        id="btn_new_receipt" 
                                        data-id="'.$row['attend_id'].'" 
                                        data-id1="'.$row_p['firstName']." ". $row_p['lastName'].'"
                                        data-id2="'.$row['patient_id'].'">New Receipt</a>';
                                    };
                                     if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Attendance'] == 'Yes')) 
                                    {
                                        $output .= ' | <a href="#" id="btn_delete_attend" data-id="'.$row['attend_id'].'">Delete</a>';
                                    };
                                
                 $output .= '</td>
                        </tr>
                        <tr>
                            <td style="border-bottom:none"><strong><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><i>'; 
                            if(isset($row_mg['date'])){$output .= $row_mg['date'];}else{$output .= 'No plan yet';};
                            $output .= '</i></a></strong></td>
                            <td style="border-bottom:none"><strong><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><i>'; 
                            if(isset($row_mg['initials'])){$output .= $row_mg['initials'];}else{$output .= 'No plan yet';};
                            $output .= '</i></a></strong></td>
                            <td colspan=8 style="border-bottom:none"><strong><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><i>'; 
                            if(isset($row_mg['mgt_notes'])){$output .=  $row_mg['mgt_notes'];}else{$output .= 'No plan yet';};
                            $output .= '</i></a><strong></td>
                        </tr>
                        <tr>';
                            $output .= '<td colspan=10 style="border-right:none;border-left:none;border-top:none;border-width: medium;"></td>
                        </tr>';
            
                    }
                }
                else
                {
                        $output .= 'No Record Found';
                };
            
     $output .= '</tbody>
    </table>';
     echo $output;
}

function search_attend_ipd()
{
    global $con;
    $output = '';
    $ward = mysqli_real_escape_string($con, $_POST["ward"]);
    $date_from = mysqli_real_escape_string($con, $_POST["date_from"]);
    $date_to = mysqli_real_escape_string($con, $_POST["date_to"]);
    $company_id = mysqli_real_escape_string($con, $_POST["company_id"]);

    if($date_from !==0 && $date_to !==0 && $ward > 0)
    {
        $query = "SELECT a.attend_id AS attend_id, a.patient_id AS patient_id, a.age AS age, a.tos_id AS tos_id, a.date_admit AS date_admit, w.ward_id AS ward_id FROM attendance a INNER JOIN wardlist w ON a.attend_id=w.attend_id WHERE tos_id=2 AND date_admit BETWEEN '$date_from' AND '$date_to' AND ward_id='$ward' AND company_id = '$company_id'";
    }
    else if($date_from !==0 && $date_to !==0 && ($ward =='' || $ward ==0))
    {
        $query = "SELECT * FROM attendance WHERE tos_id=2 AND date_admit BETWEEN '$date_from' AND '$date_to' AND company_id = '$company_id'";
    }
    else if($date_from ==0 && $date_to ==0 && ($ward =='' || $ward ==0))
    {
        $query = "SELECT * FROM attendance WHERE tos_id=2 AND date_admit = CURDATE() AND company_id = '$company_id' ORDER BY attend_id";
    }
    else if($date_from ==0 && $date_to ==0 && $ward > 0)
    {
        $query = "SELECT * FROM attendance WHERE tos_id=2 AND date_admit = CURDATE() AND ward_id='$ward' AND company_id = '$company_id' ORDER BY attend_id";
    }
    $query_run = mysqli_query($con, $query);
    $output .= '
      <table class="table table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="action-td" width="10%">Attendance ID</th>
                <th class="action-td" width="20%">Patient Name</th>
                <th class="action-td" width="5%">Age</th>
                <th class="action-td" width="5%">Gender</th>
                <th class="action-td" width="10%">Attendance Date</th>
                <th class="action-td" width="10%">Type of Service</th>
                <th class="action-td" width="10%">Ward</th>
                <th class="action-td" width="5%">Bed</th>
                <th class="action-td" width="15%">Payment Type</th>
                <th class="action-td" width="10%">Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">
     ';
    
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $attend_id=$row['attend_id'];
                        $patient_id=$row['patient_id'];
                        $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                        $query_run_p = mysqli_query($con, $query_p);
                        $row_p=mysqli_fetch_assoc($query_run_p);
            
             $output .= '<tr style="background-color:#E4E1E0">
                            <td class="action-td">
                                <a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_p['folderNo'].'</a>
                            </td>';
                                
                                    $gender_id=$row_p['gender'];
                                    $query_g = "SELECT * FROM gender WHERE gender_id='$gender_id'";
                                    $query_run_g = mysqli_query($con, $query_g);
                                    $row_g=mysqli_fetch_assoc($query_run_g);
                                
                $output .= '<td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_p['firstName']." ". $row_p['lastName'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row['age'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_g['gender'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row['date_admit'].'</strong></a></td>';
                                
                                    $query_tos = "SELECT * FROM type_of_service WHERE tos_id=2";
                                    $query_run_tos = mysqli_query($con, $query_tos);
                                    $row_tos=mysqli_fetch_assoc($query_run_tos);
                                    
                                    $query_wl = "SELECT * FROM wardlist WHERE attend_id='$attend_id' ORDER BY wardlist_id DESC";
                                    $query_run_wl = mysqli_query($con, $query_wl);
                                    $row_wl=mysqli_fetch_assoc($query_run_wl);

                                    $ward_id=$row_wl['ward_id'];
                                    $query_wd = "SELECT * FROM ward WHERE ward_id='$ward_id'";
                                    $query_run_wd = mysqli_query($con, $query_wd);
                                    $row_wd=mysqli_fetch_assoc($query_run_wd);

                                    $bed_id=$row_wl['bed_id'];
                                    $query_bd = "SELECT * FROM bed WHERE ward_id='$ward_id' AND bed_id='$bed_id'";
                                    $query_run_bd = mysqli_query($con, $query_bd);
                                    $row_bd=mysqli_fetch_assoc($query_run_bd);

                                    $query_mg = "SELECT * FROM management_plan WHERE attend_id='$attend_id' ORDER BY mp_id DESC";
                                    $query_run_mg = mysqli_query($con, $query_mg);
                                    $row_mg=mysqli_fetch_assoc($query_run_mg);

                                    $query_pt = "SELECT * FROM payment_type WHERE attend_id='$attend_id' AND principal='Yes'";
                                    $query_run_pt = mysqli_query($con, $query_pt);
                                    if(isset($query_run_pt) && mysqli_num_rows($query_run_pt) > 0)
                                    {
                                        $row_pt = mysqli_fetch_array($query_run_pt);
                                        $sponsor_id = $row_pt['ledger_id'];
                                        $query_ptl = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
                                        $query_run_ptl = mysqli_query($con, $query_ptl);
                                        $row_ptl = mysqli_fetch_assoc($query_run_ptl);
                                        $sponsor_led = $row_ptl['ledger_desc'];
                                    }
                                    else
                                    {
                                        $sponsor_id = 0;
                                        $sponsor_led = 'Unspecified';
                                    };
                                
                $output .= '<td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_tos['description'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_wd['ward'].'</strong></a></td>
                            <td class="action-td"><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$row_bd['bed'].'</strong></a></td>
                            <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><strong style="color:black;">'.$sponsor_led.'</strong></a></td>
                            <td class="action-td">';
                                
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Attendance_Cash_Statement'] == 'Yes')) 
                                    {
                                        $output .= '<a href="#" id="btn_cash_statement_attend" 
                                                data-id="'.$row['attend_id'].'" 
                                                data-id1="'.$row['patient_id'].'"
                                                data-id2="'.$row['date_admit'].'">
                                                Cash Stat.
                                            </a>';
                                            if($sponsor_id != 1 && $sponsor_id != 2)
                                            {
                                                $output .=' | <a href="#" id="btn_insurance_statement_attend" 
                                                data-id="'.$row['attend_id'].'" 
                                                data-id1="'.$row['patient_id'].'"
                                                data-id2="'.$row['date_admit'].'"
                                                data-id3="'.$sponsor_id.'">
                                                Sponsor Stat.
                                                </a>';
                                            };
                                    };
                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Cashier_Attendance_list'] == 'Yes')) 
                                    {
                                        $output .=' | <a href="#" 
                                        id="btn_new_receipt" 
                                        data-id="'.$row['attend_id'].'" 
                                        data-id1="'.$row_p['firstName']." ". $row_p['lastName'].'"
                                        data-id2="'.$row['patient_id'].'">New Receipt</a>';
                                    };
                                     if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Attendance'] == 'Yes')) 
                                    {
                                        $output .= ' | <a href="#" id="btn_delete_attend" data-id="'.$row['attend_id'].'">Delete</a>';
                                    };
                                
                 $output .= '</td>
                        </tr>
                        <tr>
                            <td style="border-bottom:none"><strong><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><i>'; 
                            if(isset($row_mg['date'])){$output .= $row_mg['date'];}else{$output .= 'No plan yet';};
                            $output .= '</i></a></strong></td>
                            <td style="border-bottom:none"><strong><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><i>'; 
                            if(isset($row_mg['initials'])){$output .= $row_mg['initials'];}else{$output .= 'No plan yet';};
                            $output .= '</i></a></strong></td>
                            <td colspan=8 style="border-bottom:none"><strong><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'"><i>'; 
                            if(isset($row_mg['mgt_notes'])){$output .=  $row_mg['mgt_notes'];}else{$output .= 'No plan yet';};
                            $output .= '</i></a><strong></td>
                        </tr>
                        <tr>';
                            $output .= '<td colspan=10 style="border-right:none;border-left:none;border-top:none;border-width: medium;"></td>
                        </tr>';
            
                    }
                }
                else
                {
                        $output .= 'No Record Found';
                };
            
     $output .= '</tbody>
    </table>';
     echo $output;
}

function search_attend_cashier()
{
    global $con;
    $output = '';
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $date_from = mysqli_real_escape_string($con, $_POST["date_from"]);
    $date_to = mysqli_real_escape_string($con, $_POST["date_to"]);

    if($date_from !==0 && $date_to !==0 && $name > 0)
    {
        $query = "SELECT * FROM attendance WHERE tos_id=1 AND date_admit BETWEEN '$date_from' AND '$date_to' AND clinic_id='$name'";
    }
    else if($date_from !==0 && $date_to !==0 && $name ==0)
    {
        $query = "SELECT * FROM attendance WHERE tos_id=1 AND date_admit BETWEEN '$date_from' AND '$date_to'";
    }
    else if($date_from ==0 && $date_to ==0 && $name ==0)
    {
        $query = "SELECT * FROM attendance WHERE tos_id=1 AND date_admit = CURDATE() ORDER BY attend_id";
    }
    else if($date_from ==0 && $date_to ==0 && $name > 0)
    {
        $query = "SELECT * FROM attendance WHERE tos_id=1 AND date_admit = CURDATE() AND clinic_id='$name' ORDER BY attend_id";
    }
    $query_run = mysqli_query($con, $query);
    $output .= '
      <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Attendance ID</th>
                <th>Patient ID</th>
                <th>Patient Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Attendance Date</th>
                <th>Sponsor</th>
                <th>Type Of Service</th>
                <th>Service</th>
                <th>Labs</th>
                <th>Radiology</th>
                <th>Drugs</th>
                <th>Surgeries</th>
                <th>Consum.</th>
                <th>Total Bill</th>
                <th>Total Rec</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">
     ';
    if(mysqli_num_rows($query_run) > 0)
    {
     
        while($row=mysqli_fetch_assoc($query_run))
        {
            if($row['nhis_led_id'] > 0 && $row['prvt_led_id'] > 0 )
                {
                    $sponsor_id = $row['prvt_led_id'];
                }
            else if($row['nhis_led_id'] <= 0 && $row['prvt_led_id'] <= 0 )
                {
                    $sponsor_id = 1;
                }
            $query = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
            $query_run_led = mysqli_query($con, $query);
            $row_led=mysqli_fetch_assoc($query_run_led);
      $output .= '
           <tr>
                    <td>
                        <a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.str_pad($row['attend_id'],7,"0",STR_PAD_LEFT).'</a>
                    </td>
                    <td>'.$row['patient_id'].'</td>';

                        $patient_id=$row['patient_id'];
                        $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                        $query_run_p = mysqli_query($con, $query_p);
                        $row_p=mysqli_fetch_assoc($query_run_p);

                        $gender_id=$row_p['gender'];
                        $query_g = "SELECT * FROM gender WHERE gender_id='$gender_id'";
                        $query_run_g = mysqli_query($con, $query_g);
                        $row_g=mysqli_fetch_assoc($query_run_g);

        $output .= '<td>'.$row_p['firstName']." ". $row_p['lastName'].'</td>
                    <td>'.$row['age'].'</td>
                    <td>'.$row_g['gender'].'</td>
                    <td>'.$row['date_admit'].'</td>';
                    
                        $query_tos = "SELECT * FROM type_of_service WHERE tos_id=1";
                        $query_run_tos = mysqli_query($con, $query_tos);
                        $row_tos=mysqli_fetch_assoc($query_run_tos);
                    
        $output .= '<td>'.$row_led['ledger_desc'].'</td>
                    <td>'.$row_tos['description'].'</td>
                    <td>'.$row['amt_service'].'</td>
                    <td>'.$row['amt_labs'].'</td>
                    <td>'.$row['amt_radio'].'</td>
                    <td>'.$row['amt_drugs'].'</td>
                    <td>'.$row['amt_sugeries'].'</td>
                    <td>'.$row['amt_comsum'].'</td>
                    <td>'.$row['total_bill'].'</td>
                    <td>'.$row['amt_rec'].'</td>
                    <td>'.$row['amt_bal'].'</td>
                </tr>';
         }
     $output .= '</tbody>
    </table>';
     echo $output;
    };
}

function doctor_attend_register()
{
    global $con;
    $attend_id = $_SESSION['attend_id'];
    $patient_id = $_SESSION['patient_id'];
    $user_id = $_SESSION['user_id'];

    $query_attend_reg = "SELECT * FROM `doctors_attend` WHERE `attend_id`='$attend_id'";
    $query_run_attend_reg = mysqli_query($con, $query_attend_reg);
    if (mysqli_num_rows($query_run_attend_reg) > 0) 
    {
        $query_doctor_reg = "SELECT * FROM `doctors_attend` WHERE `attend_id`='$attend_id' AND `user_id`='$user_id'";
        $query_run_doctor_reg = mysqli_query($con, $query_doctor_reg);
        if (mysqli_num_rows($query_run_doctor_reg) < 1) 
        {
            $query = "INSERT INTO `doctors_attend`(`user_id`, `attend_id`, `patient_id`, `type`, `date`) VALUES ('$user_id','$attend_id', '$patient_id', 'REVIEW',now())";
            $query_run = mysqli_query($con, $query);
        };
    } 
    else 
    {
        $query = "INSERT INTO `doctors_attend`(`user_id`, `attend_id`, `patient_id`, `type`, `date`) VALUES ('$user_id','$attend_id', '$patient_id', 'FIRST_VIEW',now())";
        $query_run = mysqli_query($con, $query);
    };
}

function search_attend_by_date()
{
    global $con;
    $output = '';
    $date_from = mysqli_real_escape_string($con, $_POST["date_from"]);
    $date_to = mysqli_real_escape_string($con, $_POST["date_to"]);
    $company_id = mysqli_real_escape_string($con, $_POST["company_id"]);
    
    $query = "SELECT * FROM attendance WHERE date_admit BETWEEN '$date_from' AND '$date_to'";
    
    $query_run = mysqli_query($con, $query);
    $output .= '
    <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Attendance Date</th>
            <th>Patient Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Clinic</th>
            <th>Type of Service</th>
            <th>Payment Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="pv-table-body">';
    
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $patient_id = $row['patient_id'];
                        $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                        $query_run_p = mysqli_query($con, $query_p);
                        $row_p=mysqli_fetch_assoc($query_run_p);
                        
                        $gender_id = $row_p['gender'];
                        $query_gender = "SELECT * FROM gender WHERE 	gender_id ='$gender_id'";
                        $query_run_gender = mysqli_query($con, $query_gender);
                        $row_gender=mysqli_fetch_assoc($query_run_gender);
                        
                        $clinic_id = $row['clinic_id'];
                        $query_cl = "SELECT * FROM clinics WHERE clinic_id='$clinic_id'";
                        $query_run_cl = mysqli_query($con, $query_cl);
                        $row_cl=mysqli_fetch_assoc($query_run_cl);
                        
                        $query_tos = "SELECT * FROM type_of_service WHERE tos_id=1";
                        $query_run_tos = mysqli_query($con, $query_tos);
                        $row_tos=mysqli_fetch_assoc($query_run_tos);
                        
                        $attend_id = $row['attend_id'];
                        $query_sponsor = "SELECT * FROM payment_type WHERE attend_id='$attend_id' AND principal ='Yes'";
                        
                        $query_run_sponsor = mysqli_query($con, $query_sponsor);
                        $row_sponsor = mysqli_fetch_assoc($query_run_sponsor);
                        if(isset($row_sponsor))
                        {
                           $sponsor_id = $row_sponsor['ledger_id'];
                            if(isset($sponsor_id))
                            {
                                $query = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
                                $query_run_led = mysqli_query($con, $query);
                                $row_led = mysqli_fetch_assoc($query_run_led);
                                $sponsor_desc = $row_led['ledger_desc'];
                            }
                            else
                            {
                                $sponsor_id = 0;
                                $sponsor_desc = 'N/A';
                            };
                        }
                        else
                        {
                            $sponsor_id = 0;
                            $sponsor_desc = 'N/A';
                        };
            
    $output .= '<tr>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['date_admit'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_p['firstName']." ". $row_p['lastName'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['age'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_gender['gender'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_cl['clinic_desc'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_tos['description'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$sponsor_desc.'</a></td>
                    <td>';
                        
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Attendance_Cash_Statement'] == 'Yes')) 
                            {
                                $output .='<a href="#" id="btn_cash_statement_attend" 
                                data-id="'.$row['attend_id'].'" 
                                data-id1="'.$row['patient_id'].'"
                                data-id2="'.$row['date_admit'].'">
                                Cash Stat.
                                </a>';
                                if($sponsor_id != 1 && $sponsor_id != 2)
                                {
                                    $output .=' | <a href="#" id="btn_insurance_statement_attend" 
                                    data-id="'.$row['attend_id'].'" 
                                    data-id1="'.$row['patient_id'].'"
                                    data-id2="'.$row['date_admit'].'"
                                    data-id3="'.$sponsor_id.'">
                                    Sponsor Stat.
                                    </a>';
                                };
                            };
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Cashier_Attendance_list'] == 'Yes')) 
                            {
                                $output .=' | <a href="#" 
                                id="btn_new_receipt" 
                                data-id="'.$row['attend_id'].'" 
                                data-id1="'.$row_p['firstName']." ". $row_p['lastName'].'"
                                data-id2="'.$row['patient_id'].'">New Receipt</a>';
                            };
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Attendance'] == 'Yes')) 
                            {
                                $output .=' | <a href="#" id="btn_delete_attend" data-id="'.$row['attend_id'].'"> Delete Attend. Sht.</a>';
                            };
                        
                    $output .='</td>
                </tr>';
            
                    };
                }
                else
                {
                    $output .='No Record Found';
                };
            
     $output .= '</tbody>
    </table>';
     echo $output;
}

function search_attend_by_name()
{
    global $con;
    $output = '';
    $search = mysqli_real_escape_string($con, $_POST["search"]);
    $query = "SELECT A.*, P.firstName, P.lastName, P.telephone, P.folderNo FROM `patients` 
    AS P JOIN `attendance` AS A ON A.patient_id = P.patient_id WHERE P.firstName LIKE '%".$search."%'
      OR P.lastName LIKE '%".$search."%' 
      OR P.telephone LIKE '%".$search."%' 
      OR P.folderNo LIKE '%".$search."%'
     ";
    $query_run = mysqli_query($con, $query);
    $output .= '
    <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Attendance Date</th>
            <th>Patient Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Clinic</th>
            <th>Type of Service</th>
            <th>Payment Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="pv-table-body">';
    
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $patient_id = $row['patient_id'];
                        $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                        $query_run_p = mysqli_query($con, $query_p);
                        $row_p=mysqli_fetch_assoc($query_run_p);
                        
                        $gender_id = $row_p['gender'];
                        $query_gender = "SELECT * FROM gender WHERE 	gender_id ='$gender_id'";
                        $query_run_gender = mysqli_query($con, $query_gender);
                        $row_gender=mysqli_fetch_assoc($query_run_gender);
                        
                        $clinic_id = $row['clinic_id'];
                        $query_cl = "SELECT * FROM clinics WHERE clinic_id='$clinic_id'";
                        $query_run_cl = mysqli_query($con, $query_cl);
                        $row_cl=mysqli_fetch_assoc($query_run_cl);
                        
                        $query_tos = "SELECT * FROM type_of_service WHERE tos_id=1";
                        $query_run_tos = mysqli_query($con, $query_tos);
                        $row_tos=mysqli_fetch_assoc($query_run_tos);
                        
                        $attend_id = $row['attend_id'];
                        $query_sponsor = "SELECT * FROM payment_type WHERE attend_id='$attend_id' AND principal ='Yes'";
                        
                        $query_run_sponsor = mysqli_query($con, $query_sponsor);
                        $row_sponsor = mysqli_fetch_assoc($query_run_sponsor);
                        if(isset($row_sponsor))
                        {
                            $sponsor_id = $row_sponsor['ledger_id'];
                            if(isset($sponsor_id))
                            {
                                $query = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
                                $query_run_led = mysqli_query($con, $query);
                                $row_led = mysqli_fetch_assoc($query_run_led);
                                $sponsor_desc = $row_led['ledger_desc'];
                            }
                            else
                            {
                                $sponsor_id = 0;
                                $sponsor_desc = 'N/A';
                            };
                        }
                        else
                        {
                            $sponsor_id = 0;
                            $sponsor_desc = 'N/A';
                        };
            
    $output .= '<tr>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['date_admit'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_p['firstName']." ". $row_p['lastName'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['age'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_gender['gender'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_cl['clinic_desc'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_tos['description'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$sponsor_desc.'</a></td>
                    <td>';
                        
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Attendance_Cash_Statement'] == 'Yes')) 
                            {
                                $output .='<a href="#" id="btn_cash_statement_attend" 
                                data-id="'.$row['attend_id'].'" 
                                data-id1="'.$row['patient_id'].'"
                                data-id2="'.$row['date_admit'].'">
                                Cash Stat.
                                </a>';
                                if($sponsor_id != 1 && $sponsor_id != 2)
                                {
                                    $output .=' | <a href="#" id="btn_insurance_statement_attend" 
                                    data-id="'.$row['attend_id'].'" 
                                    data-id1="'.$row['patient_id'].'"
                                    data-id2="'.$row['date_admit'].'"
                                    data-id3="'.$sponsor_id.'">
                                    Sponsor Stat.
                                    </a>';
                                };
                            };
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Cashier_Attendance_list'] == 'Yes')) 
                            {
                                $output .=' | <a href="#" 
                                id="btn_new_receipt" 
                                data-id="'.$row['attend_id'].'" 
                                data-id1="'.$row_p['firstName']." ". $row_p['lastName'].'"
                                data-id2="'.$row['patient_id'].'">New Receipt</a>';
                            };
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Attendance'] == 'Yes')) 
                            {
                                $output .=' | <a href="#" id="btn_delete_attend" data-id="'.$row['attend_id'].'"> Delete Attend. Sht.</a>';
                            };
                        
                    $output .='</td>
                </tr>';
            
                    };
                }
                else
                {
                    $output .='No Record Found';
                };
            
     $output .= '</tbody>
    </table>';
     echo $output;
}

function search_attend_discharge_by_date()
{
    global $con;
    $output = '';
    $date_from = mysqli_real_escape_string($con, $_POST["date_from"]);
    $date_to = mysqli_real_escape_string($con, $_POST["date_to"]);
    $company_id = mysqli_real_escape_string($con, $_POST["company_id"]);
    
    $query = "SELECT * FROM attendance WHERE tos_id =2 AND outcome='discharged' AND date_disch BETWEEN '$date_from' AND '$date_to'";
    
    $query_run = mysqli_query($con, $query);
    $output .= '
    <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Admission Date</th>
            <th>Discharge Date</th>
            <th>Patient Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Clinic</th>
            <th>Type of Service</th>
            <th>Payment Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="pv-table-body">';
    
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $patient_id = $row['patient_id'];
                        $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                        $query_run_p = mysqli_query($con, $query_p);
                        $row_p=mysqli_fetch_assoc($query_run_p);
                        
                        $gender_id = $row_p['gender'];
                        $query_gender = "SELECT * FROM gender WHERE 	gender_id ='$gender_id'";
                        $query_run_gender = mysqli_query($con, $query_gender);
                        $row_gender=mysqli_fetch_assoc($query_run_gender);
                        
                        $clinic_id = $row['clinic_id'];
                        $query_cl = "SELECT * FROM clinics WHERE clinic_id='$clinic_id'";
                        $query_run_cl = mysqli_query($con, $query_cl);
                        $row_cl=mysqli_fetch_assoc($query_run_cl);
                        
                        $query_tos = "SELECT * FROM type_of_service WHERE tos_id=1";
                        $query_run_tos = mysqli_query($con, $query_tos);
                        $row_tos=mysqli_fetch_assoc($query_run_tos);
                        
                        $attend_id = $row['attend_id'];
                        $query_sponsor = "SELECT * FROM payment_type WHERE attend_id='$attend_id' AND principal ='Yes'";
                        
                        $query_run_sponsor = mysqli_query($con, $query_sponsor);
                        $row_sponsor = mysqli_fetch_assoc($query_run_sponsor);
                        if(isset($row_sponsor))
                        {
                           $sponsor_id = $row_sponsor['ledger_id'];
                            if(isset($sponsor_id))
                            {
                                $query = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
                                $query_run_led = mysqli_query($con, $query);
                                $row_led = mysqli_fetch_assoc($query_run_led);
                                $sponsor_desc = $row_led['ledger_desc'];
                            }
                            else
                            {
                                $sponsor_id = 0;
                                $sponsor_desc = 'N/A';
                            };
                        }
                        else
                        {
                            $sponsor_id = 0;
                            $sponsor_desc = 'N/A';
                        };
            
    $output .= '<tr>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['date_admit'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['date_disch'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_p['firstName']." ". $row_p['lastName'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['age'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_gender['gender'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_cl['clinic_desc'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_tos['description'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$sponsor_desc.'</a></td>
                    <td>';
                        
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Attendance_Cash_Statement'] == 'Yes')) 
                            {
                                $output .='<a href="#" id="btn_cash_statement_attend" 
                                data-id="'.$row['attend_id'].'" 
                                data-id1="'.$row['patient_id'].'"
                                data-id2="'.$row['date_admit'].'">
                                Cash Stat.
                                </a>';
                                if($sponsor_id != 1 && $sponsor_id != 2)
                                {
                                    echo' | <a href="#" id="btn_insurance_statement_attend" 
                                    data-id="'.$row['attend_id'].'" 
                                    data-id1="'.$row['patient_id'].'"
                                    data-id2="'.$row['date_admit'].'"
                                    data-id3="'.$sponsor_id.'">
                                    Sponsor Stat.
                                    </a>';
                                };
                            };
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Cashier_Attendance_list'] == 'Yes')) 
                            {
                                $output .=' | <a href="#" 
                                id="btn_new_receipt" 
                                data-id="'.$row['attend_id'].'" 
                                data-id1="'.$row_p['firstName']." ". $row_p['lastName'].'"
                                data-id2="'.$row['patient_id'].'">New Receipt</a>';
                            };
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Attendance'] == 'Yes')) 
                            {
                                $output .=' | <a href="#" id="btn_delete_attend" data-id="'.$row['attend_id'].'"> Delete Attend. Sht.</a>';
                            };
                        
                    $output .='</td>
                </tr>';
            
                    };
                }
                else
                {
                    $output .='No Record Found';
                };
            
     $output .= '</tbody>
    </table>';
     echo $output;
}

function search_attend_discharge_by_name()
{
    global $con;
    $output = '';
    $search = mysqli_real_escape_string($con, $_POST["search"]);
    if($search !='')
    {
        $query = "SELECT A.*, P.firstName, P.lastName, P.telephone, P.folderNo FROM `patients` 
        AS P JOIN `attendance` AS A ON A.patient_id = P.patient_id WHERE A.tos_id =2 AND A.outcome='discharged' AND P.firstName LIKE '%".$search."%'
        OR P.lastName LIKE '%".$search."%' 
        OR P.telephone LIKE '%".$search."%' 
        OR P.folderNo LIKE '%".$search."%'";
    }
    else
    {
        $query = "SELECT A.*, P.firstName, P.lastName, P.telephone, P.folderNo FROM `patients` 
    AS P JOIN `attendance` AS A ON A.patient_id = P.patient_id WHERE A.tos_id =2 AND A.outcome='discharged'";
    };
    $query_run = mysqli_query($con, $query);
    $output .= '
    <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Admission Date</th>
            <th>Discharge Date</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Clinic</th>
            <th>Type of Service</th>
            <th>Payment Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="pv-table-body">';
    
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $patient_id = $row['patient_id'];
                        $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                        $query_run_p = mysqli_query($con, $query_p);
                        $row_p=mysqli_fetch_assoc($query_run_p);
                        
                        $gender_id = $row_p['gender'];
                        $query_gender = "SELECT * FROM gender WHERE 	gender_id ='$gender_id'";
                        $query_run_gender = mysqli_query($con, $query_gender);
                        $row_gender=mysqli_fetch_assoc($query_run_gender);
                        
                        $clinic_id = $row['clinic_id'];
                        $query_cl = "SELECT * FROM clinics WHERE clinic_id='$clinic_id'";
                        $query_run_cl = mysqli_query($con, $query_cl);
                        $row_cl=mysqli_fetch_assoc($query_run_cl);
                        
                        $query_tos = "SELECT * FROM type_of_service WHERE tos_id=1";
                        $query_run_tos = mysqli_query($con, $query_tos);
                        $row_tos=mysqli_fetch_assoc($query_run_tos);
                        
                        $attend_id = $row['attend_id'];
                        $query_sponsor = "SELECT * FROM payment_type WHERE attend_id='$attend_id' AND principal ='Yes'";
                        
                        $query_run_sponsor = mysqli_query($con, $query_sponsor);
                        $row_sponsor = mysqli_fetch_assoc($query_run_sponsor);
                        if(isset($row_sponsor))
                        {
                            $sponsor_id = $row_sponsor['ledger_id'];
                            if(isset($sponsor_id))
                            {
                                $query = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
                                $query_run_led = mysqli_query($con, $query);
                                $row_led = mysqli_fetch_assoc($query_run_led);
                                $sponsor_desc = $row_led['ledger_desc'];
                            }
                            else
                            {
                                $sponsor_id = 0;
                                $sponsor_desc = 'N/A';
                            };
                        }
                        else
                        {
                            $sponsor_id = 0;
                            $sponsor_desc = 'N/A';
                        };
            
    $output .= '<tr>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['date_admit'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['date_disch'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_p['firstName']." ". $row_p['lastName'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row['age'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_gender['gender'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_cl['clinic_desc'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$row_tos['description'].'</a></td>
                    <td><a href="#" id="btn_open_attend" data-id="'.$row['attend_id'].'" data-id2="'.$row['patient_id'].'">'.$sponsor_desc.'</a></td>
                    <td>';
                        
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Attendance_Cash_Statement'] == 'Yes')) 
                            {
                                $output .='<a href="#" id="btn_cash_statement_attend" 
                                data-id="'.$row['attend_id'].'" 
                                data-id1="'.$row['patient_id'].'"
                                data-id2="'.$row['date_admit'].'">
                                Cash Stat.
                                </a>';
                                if($sponsor_id != 1 && $sponsor_id != 2)
                                {
                                    $output .=' | <a href="#" id="btn_insurance_statement_attend" 
                                    data-id="'.$row['attend_id'].'" 
                                    data-id1="'.$row['patient_id'].'"
                                    data-id2="'.$row['date_admit'].'"
                                    data-id3="'.$sponsor_id.'">
                                    Sponsor Stat.
                                    </a>';
                                };
                            };
                            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Attendance'] == 'Yes')) 
                            {
                                $output .=' | <a href="#" id="btn_delete_attend" data-id="'.$row['attend_id'].'"> Delete Attend. Sht.</a>';
                            };
                        
                    $output .='</td>
                </tr>';
            
                    };
                }
                else
                {
                    $output .='No Record Found';
                };
            
     $output .= '</tbody>
    </table>';
     echo $output;
}

function search_attend_revenue_by_name()
{
    global $con;
    $output = '';
    $search = mysqli_real_escape_string($con, $_POST["search"]);
    if($search !='')
    {
        $query = "SELECT A.*, P.firstName, P.lastName, P.telephone, P.folderNo FROM `patients` 
        AS P JOIN `attendance` AS A ON A.patient_id = P.patient_id WHERE A.tos_id =2 AND A.outcome='discharged' AND P.firstName LIKE '%".$search."%'
        OR P.lastName LIKE '%".$search."%' 
        OR P.telephone LIKE '%".$search."%' 
        OR P.folderNo LIKE '%".$search."%'";
    }
    else
    {
        $query = "SELECT A.*, P.firstName, P.lastName, P.telephone, P.folderNo FROM `patients` 
    AS P JOIN `attendance` AS A ON A.patient_id = P.patient_id WHERE A.tos_id =2 AND A.outcome='discharged'";
    };
    $query_run = mysqli_query($con, $query);
    $output .= '
    <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="action-td">Date</th>
                <th>Patient Name</th>
                <th class="action-td">Service</th>
                <th class="action-td">Labs</th>
                <th class="action-td">Radiology</th>
                <th class="action-td">Drugs</th>
                <th class="action-td">Surgeries</th>
                <th class="action-td">Consumables</th>
                <th class="action-td">Total Bill</th>
                <th class="action-td">Discount</th>
                <th class="action-td">Receipt</th>
                <th class="action-td">Refund</th>
                <th class="action-td">Balance</th>
                <th class="action-td">Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">';
    
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        if($row['nhis_led_id'] > 0 && $row['prvt_led_id'] > 0 )
                        {
                            $sponsor_id = $row['nhis_led_id'];
                        }
                        else if($row['nhis_led_id'] > 0 && $row['prvt_led_id'] <= 0 )
                        {
                            $sponsor_id = $row['nhis_led_id'];
                        }
                        else if($row['nhis_led_id'] <= 0 && $row['prvt_led_id'] > 0 )
                        {
                            $sponsor_id = $row['prvt_led_id'];
                        }
                        else if($row['nhis_led_id'] <= 0 && $row['prvt_led_id'] <= 0 )
                        {
                            $sponsor_id = 1;
                        }
                        $query = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
                        $query_run_led = mysqli_query($con, $query);
                        $row_led=mysqli_fetch_assoc($query_run_led);
                        
                        $patient_id = $row['patient_id'];
                        $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                        $query_run_p = mysqli_query($con, $query_p);
                        $row_p = mysqli_fetch_assoc($query_run_p);

                        $attend_id = $row['attend_id']; 
                        $query_service = "SELECT SUM(amount_cash) AS service_bill FROM service_list WHERE attend_id='$attend_id'";
                        $query_run_service = mysqli_query($con, $query_service);
                        $row_service=mysqli_fetch_assoc($query_run_service);
                        $bill_service = $row_service['service_bill'];
                        $bill_service = number_format($bill_service, 2, '.', ',');
                        
                        $query_lab = "SELECT SUM(amount_cash) AS lab_bill FROM lab_list WHERE attend_id='$attend_id'";
                        $query_run_lab = mysqli_query($con, $query_lab);
                        $row_lab=mysqli_fetch_assoc($query_run_lab);
                        $bill_labs = $row_lab['lab_bill'];
                        $bill_labs = number_format($bill_labs, 2, '.', ',');
                        
                        $query_radio = "SELECT SUM(amount_cash) AS radio_bill FROM radio_list WHERE attend_id='$attend_id'";
                        $query_run_radio = mysqli_query($con, $query_radio);
                        $row_radio=mysqli_fetch_assoc($query_run_radio);
                        $bill_radio = $row_radio['radio_bill'];
                        $bill_radio = number_format($bill_radio, 2, '.', ',');
                        
                        $query_drug = "SELECT SUM(amt_cash) AS drug_bill FROM drug_dispense_list WHERE attend_id='$attend_id'";
                        $query_run_drug = mysqli_query($con, $query_drug);
                        $row_drug=mysqli_fetch_assoc($query_run_drug);
                        $bill_drugs = $row_drug['drug_bill'];
                        $bill_drugs = number_format($bill_drugs, 2, '.', ',');
                        
                        $query_surgery = "SELECT SUM(amount_cash) AS surgery_bill FROM surgery_list WHERE attend_id='$attend_id'";
                        $query_run_surgery = mysqli_query($con, $query_surgery);
                        $row_surgery=mysqli_fetch_assoc($query_run_surgery);
                        $bill_surgery = $row_surgery['surgery_bill'];
                        $bill_surgery = number_format($bill_surgery, 2, '.', ',');
                        
                        $query_consum = "SELECT SUM(amount_cash) AS consum_bill FROM consumable_list WHERE attend_id='$attend_id'";
                        $query_run_consum = mysqli_query($con, $query_consum);
                        $row_consum=mysqli_fetch_assoc($query_run_consum);
                        $bill_consum = $row_consum['consum_bill'];
                        $bill_consum = number_format($bill_consum, 2, '.', ',');
                        
                        $total_bill = $row_service['service_bill'] +
                        $row_lab['lab_bill'] +
                        $row_radio['radio_bill'] +
                        $row_drug['drug_bill'] +
                        $row_surgery['surgery_bill'] +
                        $row_consum['consum_bill'];

                        $bill_total = $row_service['service_bill'] +
                        $row_lab['lab_bill'] +
                        $row_radio['radio_bill'] +
                        $row_drug['drug_bill'] +
                        $row_surgery['surgery_bill'] +
                        $row_consum['consum_bill'];

                        $bill_total = number_format($bill_total, 2, '.', ',');
                        
                        $query_discount = "SELECT SUM(amount) AS amount_discount FROM discount WHERE attend_id='$attend_id'";
                        $query_run_discount = mysqli_query($con, $query_discount);
                        $row_discount=mysqli_fetch_assoc($query_run_discount);
                        $discount_total = $row_discount['amount_discount'];
                        $discount_total = number_format($discount_total, 2, '.', ',');
                        
                        $query_receipt = "SELECT SUM(amount) AS amount_rec FROM receipt WHERE attend_id='$attend_id'";
                        $query_run_receipt = mysqli_query($con, $query_receipt);
                        $row_receipt=mysqli_fetch_assoc($query_run_receipt);
                        $receipt_total = $row_receipt['amount_rec'];
                        $receipt_total = number_format($receipt_total, 2, '.', ',');
                        
                        $query_refund = "SELECT SUM(amount) AS amount_refund FROM refund WHERE attend_id='$attend_id'";
                        $query_run_refund = mysqli_query($con, $query_refund);
                        $row_refund=mysqli_fetch_assoc($query_run_refund);
                        $refund_total = $row_refund['amount_refund'];
                        $refund_total = number_format($refund_total, 2, '.', ',');
                        
                        $grand_total = $total_bill - $row_discount['amount_discount'] - $row_receipt['amount_rec'] + $row_refund['amount_refund'];
                        $grand_total = number_format($grand_total, 2, '.', ',');
            
    $output .= '<tr>
                    <td class="action-td">'.$row['date_admit'].'</td>
                    <td>'.$row_p['firstName']." ". $row_p['lastName'].'</td>
                    <td class="amt-td">'.$bill_service.'</td>
                    <td class="amt-td">'.$bill_labs.'</td>
                    <td class="amt-td">'.$bill_radio.'</td>
                    <td class="amt-td">'.$bill_drugs.'</td>
                    <td class="amt-td">'.$bill_surgery.'</td>
                    <td class="amt-td">'.$bill_consum.'</td>
                    <td class="amt-td">'.$bill_total.'</td>
                    <td class="amt-td">'.$discount_total.'</td>
                    <td class="amt-td">'.$receipt_total.'</td>
                    <td class="amt-td">'.$refund_total.'</td>
                    <td class="amt-td">'.$grand_total.'</td>
                    <td>
                        <a href="#" 
                        id="btn_new_receipt" 
                        data-id="'.$row['attend_id'].'" 
                        data-id1="'.$row_p['firstName']." ". $row_p['lastName'].'"
                        data-id2="'.$row['patient_id'].'">New Receipt</a>
                    </td>
                </tr>';
                    };
                }
            
     $output .= '</tbody>
    </table>';
     echo $output;
}

function search_attend_revenue_by_date()
{
    global $con;
    $output = '';
    $date_from = mysqli_real_escape_string($con, $_POST["date_from"]);
    $date_to = mysqli_real_escape_string($con, $_POST["date_to"]);
    $company_id = mysqli_real_escape_string($con, $_POST["company_id"]);

    $query = "SELECT * FROM attendance WHERE date_admit BETWEEN '$date_from' AND '$date_to'";

    $query_run = mysqli_query($con, $query);
    $output .= '
    <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="action-td">Date</th>
                <th>Patient Name</th>
                <th class="action-td">Service</th>
                <th class="action-td">Labs</th>
                <th class="action-td">Radiology</th>
                <th class="action-td">Drugs</th>
                <th class="action-td">Surgeries</th>
                <th class="action-td">Consumables</th>
                <th class="action-td">Total Bill</th>
                <th class="action-td">Discount</th>
                <th class="action-td">Receipt</th>
                <th class="action-td">Refund</th>
                <th class="action-td">Balance</th>
                <th class="action-td">Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">';
    
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        if($row['nhis_led_id'] > 0 && $row['prvt_led_id'] > 0 )
                        {
                            $sponsor_id = $row['nhis_led_id'];
                        }
                        else if($row['nhis_led_id'] > 0 && $row['prvt_led_id'] <= 0 )
                        {
                            $sponsor_id = $row['nhis_led_id'];
                        }
                        else if($row['nhis_led_id'] <= 0 && $row['prvt_led_id'] > 0 )
                        {
                            $sponsor_id = $row['prvt_led_id'];
                        }
                        else if($row['nhis_led_id'] <= 0 && $row['prvt_led_id'] <= 0 )
                        {
                            $sponsor_id = 1;
                        }
                        $query = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
                        $query_run_led = mysqli_query($con, $query);
                        $row_led=mysqli_fetch_assoc($query_run_led);
                        
                        $patient_id = $row['patient_id'];
                        $query_p = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                        $query_run_p = mysqli_query($con, $query_p);
                        $row_p = mysqli_fetch_assoc($query_run_p);

                        $attend_id = $row['attend_id']; 
                        $query_service = "SELECT SUM(amount_cash) AS service_bill FROM service_list WHERE attend_id='$attend_id'";
                        $query_run_service = mysqli_query($con, $query_service);
                        $row_service=mysqli_fetch_assoc($query_run_service);
                        $bill_service = $row_service['service_bill'];
                        $bill_service = number_format($bill_service, 2, '.', ',');
                        
                        $query_lab = "SELECT SUM(amount_cash) AS lab_bill FROM lab_list WHERE attend_id='$attend_id'";
                        $query_run_lab = mysqli_query($con, $query_lab);
                        $row_lab=mysqli_fetch_assoc($query_run_lab);
                        $bill_labs = $row_lab['lab_bill'];
                        $bill_labs = number_format($bill_labs, 2, '.', ',');
                        
                        $query_radio = "SELECT SUM(amount_cash) AS radio_bill FROM radio_list WHERE attend_id='$attend_id'";
                        $query_run_radio = mysqli_query($con, $query_radio);
                        $row_radio=mysqli_fetch_assoc($query_run_radio);
                        $bill_radio = $row_radio['radio_bill'];
                        $bill_radio = number_format($bill_radio, 2, '.', ',');
                        
                        $query_drug = "SELECT SUM(amt_cash) AS drug_bill FROM drug_dispense_list WHERE attend_id='$attend_id'";
                        $query_run_drug = mysqli_query($con, $query_drug);
                        $row_drug=mysqli_fetch_assoc($query_run_drug);
                        $bill_drugs = $row_drug['drug_bill'];
                        $bill_drugs = number_format($bill_drugs, 2, '.', ',');
                        
                        $query_surgery = "SELECT SUM(amount_cash) AS surgery_bill FROM surgery_list WHERE attend_id='$attend_id'";
                        $query_run_surgery = mysqli_query($con, $query_surgery);
                        $row_surgery=mysqli_fetch_assoc($query_run_surgery);
                        $bill_surgery = $row_surgery['surgery_bill'];
                        $bill_surgery = number_format($bill_surgery, 2, '.', ',');
                        
                        $query_consum = "SELECT SUM(amount_cash) AS consum_bill FROM consumable_list WHERE attend_id='$attend_id'";
                        $query_run_consum = mysqli_query($con, $query_consum);
                        $row_consum=mysqli_fetch_assoc($query_run_consum);
                        $bill_consum = $row_consum['consum_bill'];
                        $bill_consum = number_format($bill_consum, 2, '.', ',');
                        
                        $total_bill = $row_service['service_bill'] +
                        $row_lab['lab_bill'] +
                        $row_radio['radio_bill'] +
                        $row_drug['drug_bill'] +
                        $row_surgery['surgery_bill'] +
                        $row_consum['consum_bill'];

                        $bill_total = $row_service['service_bill'] +
                        $row_lab['lab_bill'] +
                        $row_radio['radio_bill'] +
                        $row_drug['drug_bill'] +
                        $row_surgery['surgery_bill'] +
                        $row_consum['consum_bill'];

                        $bill_total = number_format($bill_total, 2, '.', ',');
                        
                        $query_discount = "SELECT SUM(amount) AS amount_discount FROM discount WHERE attend_id='$attend_id'";
                        $query_run_discount = mysqli_query($con, $query_discount);
                        $row_discount=mysqli_fetch_assoc($query_run_discount);
                        $discount_total = $row_discount['amount_discount'];
                        $discount_total = number_format($discount_total, 2, '.', ',');
                        
                        $query_receipt = "SELECT SUM(amount) AS amount_rec FROM receipt WHERE attend_id='$attend_id'";
                        $query_run_receipt = mysqli_query($con, $query_receipt);
                        $row_receipt=mysqli_fetch_assoc($query_run_receipt);
                        $receipt_total = $row_receipt['amount_rec'];
                        $receipt_total = number_format($receipt_total, 2, '.', ',');
                        
                        $query_refund = "SELECT SUM(amount) AS amount_refund FROM refund WHERE attend_id='$attend_id'";
                        $query_run_refund = mysqli_query($con, $query_refund);
                        $row_refund=mysqli_fetch_assoc($query_run_refund);
                        $refund_total = $row_refund['amount_refund'];
                        $refund_total = number_format($refund_total, 2, '.', ',');
                        
                        $grand_total = $total_bill - $row_discount['amount_discount'] - $row_receipt['amount_rec'] + $row_refund['amount_refund'];
                        $grand_total = number_format($grand_total, 2, '.', ',');
            
    $output .= '<tr>
                    <td class="action-td">'.$row['date_admit'].'</td>
                    <td>'.$row_p['firstName']." ". $row_p['lastName'].'</td>
                    <td class="amt-td">'.$bill_service.'</td>
                    <td class="amt-td">'.$bill_labs.'</td>
                    <td class="amt-td">'.$bill_radio.'</td>
                    <td class="amt-td">'.$bill_drugs.'</td>
                    <td class="amt-td">'.$bill_surgery.'</td>
                    <td class="amt-td">'.$bill_consum.'</td>
                    <td class="amt-td">'.$bill_total.'</td>
                    <td class="amt-td">'.$discount_total.'</td>
                    <td class="amt-td">'.$receipt_total.'</td>
                    <td class="amt-td">'.$refund_total.'</td>
                    <td class="amt-td">'.$grand_total.'</td>
                    <td>
                        <a href="#" 
                        id="btn_new_receipt" 
                        data-id="'.$row['attend_id'].'" 
                        data-id1="'.$row_p['firstName']." ". $row_p['lastName'].'"
                        data-id2="'.$row['patient_id'].'">New Receipt</a>
                    </td>
                </tr>';
                    };
                }
            
     $output .= '</tbody>
    </table>';
     echo $output;
}

function delete_attendance()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $query = "DELETE FROM `attendance` WHERE attend_id='$attend_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        $query_trans_del = "DELETE FROM `service_list` WHERE `attend_id`='$attend_id'";
        mysqli_query($con, $query_trans_del);
        $query_trans_del = "DELETE FROM `consumable_list` WHERE `attend_id`='$attend_id'";
        mysqli_query($con, $query_trans_del);
        $query_trans_del = "DELETE FROM `diagnosis_list` WHERE `attend_id`='$attend_id'";
        mysqli_query($con, $query_trans_del);
        $query_trans_del = "DELETE FROM `drug_list` WHERE `attend_id`='$attend_id'";
        mysqli_query($con, $query_trans_del);
        $query_trans_del = "DELETE FROM `lab_list` WHERE `attend_id`='$attend_id'";
        mysqli_query($con, $query_trans_del);
        $query_trans_del = "DELETE FROM `radio_list` WHERE `attend_id`='$attend_id'";
        mysqli_query($con, $query_trans_del);
        $query_trans_del = "DELETE FROM `surgery_list` WHERE `attend_id`='$attend_id'";
        mysqli_query($con, $query_trans_del);
        $query_trans_del = "DELETE FROM `receipt` WHERE `attend_id`='$attend_id'";
        mysqli_query($con, $query_trans_del);
        $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id'";
        mysqli_query($con, $query_trans_del);
    }
    else
    {
        echo "Attendance NOT Deleted";
    };
}

?>
