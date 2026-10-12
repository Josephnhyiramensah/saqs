<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//PATIENT
function set_nhis_regional_code()
{
    global $con;
    $scheme_code = $_POST['scheme_code'];
    $query = "SELECT * from scheme where scheme_code='$scheme_code'";
    $result = mysqli_query($con,$query);
    $regional_code=array();
    if (mysqli_num_rows($result) > 0) {
        while($row=mysqli_fetch_assoc($result))
        {
            array_push($regional_code, 
                $row['regional_code'],
                $row['scheme_name'],
                $row['scheme_id']
            );
        }
    } else {
        array_push($regional_code, 
                'N/A',
                'N/A',
                'N/A'
            );

    };
     echo json_encode($regional_code);
}

function Display_Patient()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $query = "SELECT * from patients WHERE patient_id='$patient_id'";
    $result = mysqli_query($con,$query);

    $row=mysqli_fetch_assoc($result);
        $_SESSION['patient_id'] = $row['patient_id'];
        $_SESSION['folderno'] = $row['folderNo'];
        $_SESSION['name'] = $row['firstName'].' '.$row['lastName'];
        $_SESSION['age'] = $row['age'];
        $_SESSION['gender'] = $row['gender'];
        $_SESSION['telephone'] = $row['telephone'];
        $_SESSION['city'] = $row['city'];
}

function save_patient()
{
    global $con;
    $patient_details = array();
    $number = $_POST['number'];
    $folderNo = $_POST['folderNo'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $full_name = $_POST['firstName'].' '.$_POST['lastName'];
    $DOB = $_POST['DOB'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $marital = $_POST['marital_status'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $Allergies = $_POST['Allergies'];
    $MedicalHistory = $_POST['MedicalHistory'];
    $FamilyHistory = $_POST['FamilyHistory'];
    $BloodGroup = $_POST['BloodGroup'];
    $G6PD = $_POST['G6PD'];
    $geno_type = $_POST['geno_type'];
    $sickling = $_POST['sickling'];
    $relname = $_POST['relname'];
    $rellocation = $_POST['rellocation'];
    $reltelephone = $_POST['reltelephone'];
    $ghanacard = $_POST['ghanacard'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    date_default_timezone_set("Africa/Accra");
    $datetime = date('Y/m/d H:i:s');
    $branch_id = $_SESSION['branch_id'];
    
    $query = "INSERT INTO patients (company_id,folderNo, firstName, lastName, DOB, gender, marital, 
    address, city, telephone, email, Allergies,MedicalHistory, FamilyHistory, BloodGroup, G6PD, full_name,
    geno_type, sickling, relname, rellocation, reltelephone, ghanacard, created_by, created_datetime, 
    number, branch_id) 
    VALUES ('$company_id','$folderNo','$firstName','$lastName','$DOB','$gender','$marital','$address',
    '$city','$telephone','$email','$Allergies','$MedicalHistory','$FamilyHistory','$BloodGroup',
    '$G6PD','$full_name','$geno_type','$sickling','$relname','$rellocation','$reltelephone','$ghanacard',
    '$user_id','$datetime','$number','$branch_id')";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        $query_patient = "SELECT * FROM patients ORDER BY patient_id DESC";
        $query_run_patient = mysqli_query($con, $query_patient);
        $row_patient = mysqli_fetch_assoc($query_run_patient);
        array_push($patient_details, $row_patient['patient_id'],$row_patient['firstName'],
        $row_patient['lastName'],'Patient Added Successfully');
    }
    else
    {
        array_push($patient_details,'NA','NA','NA','Patient NOT Added');
    };
    echo json_encode($patient_details);
}

function edit_patient()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $query = "SELECT * from patients where patient_id='$patient_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        $Patient_Data=array();
        $scheme_id = $row['scheme_id'];
        $query_scheme = "SELECT * from scheme where scheme_id='$scheme_id'";
        $result_scheme = mysqli_query($con,$query_scheme);
        if (mysqli_num_rows($result_scheme) > 0) {
            $row_scheme=mysqli_fetch_assoc($result_scheme);
            $scheme_name = $row_scheme['scheme_name'];
        } else {
            $scheme_name = 'N/A';
        };
        array_push($Patient_Data, 
            $row['patient_id'],$row['folderNo'],$row['firstName'],$row['lastName'],$row['DOB'],$row['gender'],$row['marital'],$row['address'],
            $row['city'],$row['telephone'],$row['email'],$row['Allergies'],$row['MedicalHistory'],$row['FamilyHistory'],$row['BloodGroup'],
            $row['G6PD'],$row['geno_type'],$row['sickling'],$row['relname'],$row['rellocation'],$row['reltelephone'],
            $row['Schname'],$row['nhismemberno'],$row['nhisexpirydate'],$row['prtinsname'],$row['prtmemberno'],$row['prtexpirydate'],
            $row['ghanacard'],$row['sn_scheme_code'],$row['sn_member'],$row['sn_regional_code'],$row['serial_no'],$row['scheme_id'],
            $scheme_name
        );
    }
     echo json_encode($Patient_Data);
}

function Get_Patient_Record()
{
    global $con;
    $PatientID = $_POST['PatientID'];
    $query = "SELECT * from patients where patient_id='$PatientID'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        $Patient_Data=array();
        array_push($Patient_Data, $row['patient_id'],$row['firstName'],$row['lastName']);
    }
     echo json_encode($Patient_Data);
}

function update_patient()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $folderNo = $_POST['folderNo'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $full_name = $_POST['firstName'].' '.$_POST['lastName'];
    $DOB = $_POST['DOB'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $marital = $_POST['marital_status'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $Allergies = $_POST['Allergies'];
    $MedicalHistory = $_POST['MedicalHistory'];
    $FamilyHistory = $_POST['FamilyHistory'];
    $BloodGroup = $_POST['BloodGroup'];
    $G6PD = $_POST['G6PD'];
    $geno_type = $_POST['geno_type'];
    $sickling = $_POST['sickling'];
    $relname = $_POST['relname'];
    $rellocation = $_POST['rellocation'];
    $reltelephone = $_POST['reltelephone'];
    $ghanacard = $_POST['ghanacard'];

    $user_id = $_SESSION['user_id'];
    date_default_timezone_set("Africa/Accra");
    $datetime = date('Y/m/d H:i:s');
    
    $query = "UPDATE `patients` SET `folderNo`='$folderNo',`firstName`='$firstName',`lastName`='$lastName',`DOB`='$DOB',`gender`='$gender',
    `marital`='$marital',`address`='$address',`city`='$city',`telephone`='$telephone',`email`='$email',`Allergies`='$Allergies',
    `MedicalHistory`='$MedicalHistory',`FamilyHistory`='$FamilyHistory',`BloodGroup`='$BloodGroup',`G6PD`='$G6PD',`full_name`='$full_name',
    `geno_type`='$geno_type',`sickling`='$sickling',`relname`='$relname',`rellocation`='$rellocation',
    `reltelephone`='$reltelephone',`ghanacard`='$ghanacard',`altered_by`='$user_id',`altered_datetime`='$datetime'
    WHERE `patient_id`='$patient_id'";

    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "Patient Updated Successfully";
    }
    else
    {
        echo "Patient NOT Updated";
    };
}

/*function Delete_Patient()
{
    global $con;
    $PatientID = $_POST['patient_id'];
    $query = "DELETE FROM patients WHERE patient_id='$PatientID'";
    $result = mysqli_query($con,$query);
    if($result)
    {
        echo 'Record Deleted Successfully';
    }
    else 
    {
        echo 'Please check your connection';
    }
}*/

function search_patient()
{
    global $con;
    $output = '';
    if(isset($_POST["query"]))
    {
     $search = mysqli_real_escape_string($con, $_POST["query"]);
     $query = "
      SELECT * FROM patients 
      WHERE firstName LIKE '%".$search."%'
      OR lastName LIKE '%".$search."%' 
      OR full_name LIKE '%".$search."%' 
      OR address LIKE '%".$search."%' 
      OR telephone LIKE '%".$search."%' 
      OR folderNo LIKE '%".$search."%'
     ";
    }
    else
    {
     $query = "SELECT * FROM patients ORDER BY patient_id";
    }
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result) > 0)
    {
     $output .= '
      <table class="table table-hover table-bordered table-sm table-condensed" id="patientTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Folder No</th>
                <th>Patient Name</th>
                <th>Date of Birth</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Telephone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">
     ';
     while($row = mysqli_fetch_assoc($result))
     {
      $output .= '
           <tr>
                <td>'.$row["folderNo"].'</td>
                <td>';
                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Patient'] == 'Yes')) 
                    {
                         $output .= '<a href="#" id="btn_edit_patient" data-id1='.$row["patient_id"].'>'.$row["firstName"].' '. $row["lastName"].'</a>';
                    }
                    else
                    {
                        $output .= $row['firstName'].' '.$row['lastName'];
                    };
    $output .=  '</td>
                <td>'.$row["DOB"].'</td>';
                $gender = $row['gender'];
                $query_gender = "SELECT gender FROM gender WHERE gender_id='$gender'";
                $query_run_gender = mysqli_query($con, $query_gender);
                $row_gender=mysqli_fetch_assoc($query_run_gender);
                if (isset($row_gender["gender"])) {
                    $gender = $row_gender["gender"];
                } else {
                    $gender = 'Not Specified';
                };
    $output .= '<td>'.$row["age"].'</td>
                <td>'.$gender.'</td>
                <td>'.$row['telephone'].'</td>
                <td>';
                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Attendance'] == 'Yes')) 
                {
                     $output .= '<a href="#" id="btn_new_attend" data-id="'.$row['patient_id'].'"> New Attend. Sht</a>';
                };
                if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Patient_Folder'] == 'Yes')) 
                {
                  $output .= ' | <a href="#" id="nav_myfolder_pl" data-id="'.$row['patient_id'].'"> Patient Folder</a>';
                };
                 if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Patient_Cash_Statement'] == 'Yes')) 
                {
                     $output .= ' | <a href="#" id="btn_cash_statement_patient" data-id="'.$row['patient_id'].'"> Cash Stat.</a>';
                };
                 if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Attendance'] == 'Yes')) 
                {
                     $output .= ' | <a href="#" id="btn_delete_patient" data-id="'.$row['patient_id'].'"
                     data-id1="'.$row['firstName'].' '.$row['lastName'].'"> Delete Patient</a>';
                };
                '</td>
            </tr>';
     }
     $output .= '</tbody>
    </table>';
     echo $output;
    }
    else
    {
     echo 'Data Not Found';
    };
}

function edit_patient_allergies()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $Patient_Data=array();
    $query = "SELECT Allergies from patients where patient_id='$patient_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        
        array_push($Patient_Data, 
            $row['Allergies']
        );
    }
     echo json_encode($Patient_Data);
}

function update_patient_allergies()
{
    global $con;
    $patient_id = $_SESSION['patient_id'];
    $allergies = $_POST['allergies'];
    $allergies = addslashes($allergies);
    
    $query = "UPDATE `patients` SET `Allergies`='$allergies' WHERE `patient_id`='$patient_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "Allergies Updated Successfully";
    }
    else
    {
        echo "Allergies NOT Updated";
    };
}

function delete_patient()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    
    $query = "SELECT * FROM `attendance` WHERE `patient_id`='$patient_id'";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) < 1)
    {
        $query = "DELETE FROM `patients` WHERE `patient_id`='$patient_id'";
        mysqli_query($con, $query);

        echo 'deleted';
    }
    else
    {
        echo 'used';
    };
}


?>
