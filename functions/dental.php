<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//DENTAL
function save_dental_hx()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $phx1 = $_POST['phx1'];
    $phx2 = $_POST['phx2'];
    $phx3 = $_POST['phx3'];
    $phx4 = $_POST['phx4'];
    $phx5 = $_POST['phx5'];
    $phx6 = $_POST['phx6'];
    $phx7 = $_POST['phx7'];
    $phx8 = $_POST['phx8'];
    $phx9 = $_POST['phx9'];
    $phx10 = $_POST['phx10'];
    $phx11 = $_POST['phx11'];
    $phx12 = $_POST['phx12'];
    $phx13 = $_POST['phx13'];
    $phx14 = $_POST['phx14'];
    $phx15 = $_POST['phx15'];
    $phx16 = $_POST['phx16'];
    $phx17 = $_POST['phx17'];
    $phx18 = $_POST['phx18'];
    $phx19 = $_POST['phx19'];
    $phx20 = $_POST['phx20'];
    $phx21 = $_POST['phx21'];
    $phx22 = $_POST['phx22'];
    $phx23 = $_POST['phx23'];
    $phx24 = $_POST['phx24'];
    $phx25 = $_POST['phx25'];
    $phx26 = $_POST['phx26'];
    $phx27 = $_POST['phx27'];
    $phx28 = $_POST['phx28'];
    $phx29 = $_POST['phx29'];
    $phx30 = $_POST['phx30'];
    $phx31 = $_POST['phx31'];
    $phx32 = $_POST['phx32'];
    $phx33 = $_POST['phx33'];
    $phx34 = $_POST['phx34'];
    $phx35 = $_POST['phx35'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO `dental_history`(`company_id`, `attend_id`, `patient_id`, `1`, `2`, 
    `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, 
    `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`, `29`, `30`, `31`, `32`, `33`, 
    `34`, `35`, `branch_id`, `created_by`, `created_datetime`) 
        VALUES ('$company_id','$attend_id','$patient_id','$phx1','$phx2','$phx3','$phx4',
        '$phx5','$phx6','$phx7','$phx8','$phx9','$phx10','$phx11','$phx12','$phx13','$phx14',
        '$phx15','$phx16','$phx17','$phx18','$phx19','$phx20','$phx21','$phx22','$phx23',
        '$phx24','$phx25','$phx26','$phx27','$phx28','$phx29','$phx30','$phx31','$phx32',
        '$phx33','$phx34','$phx35','$branch_id','$user_id_id',NOW())";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        if ($_SESSION['user_type_id'] == 6) {
            doctor_attend_register();
        };
    };
}

function edit_dental_hx()
{
    global $con;
    $dent_hx_id = $_POST['dent_hx_id'];
    $Data=array();
    $query = "SELECT * FROM dental_history WHERE dent_hx_id='$dent_hx_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Data, 
            $row['dent_hx_id'],$row['attend_id'],$row['patient_id'],
            $row['1'],$row['2'],$row['3'],$row['4'],$row['5'],$row['6'],$row['7'],$row['8'],$row['9'],$row['10'],$row['11'],$row['12'],$row['13'],$row['14'],
            $row['15'],$row['16'],$row['17'],$row['18'],$row['19'],$row['20'],$row['21'],$row['22'],$row['23'],$row['24'],$row['25'],$row['26'],$row['27'],
            $row['28'],$row['29'],$row['30'],$row['31'],$row['32'],$row['33'],$row['34'],$row['35']
        );
    }
     echo json_encode($Data);
}

function update_dental_hx()
{
    global $con;
    $phx_id = $_POST['phx_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $phx1 = $_POST['phx1'];
    $phx2 = $_POST['phx2'];
    $phx3 = $_POST['phx3'];
    $phx4 = $_POST['phx4'];
    $phx5 = $_POST['phx5'];
    $phx6 = $_POST['phx6'];
    $phx7 = $_POST['phx7'];
    $phx8 = $_POST['phx8'];
    $phx9 = $_POST['phx9'];
    $phx10 = $_POST['phx10'];
    $phx11 = $_POST['phx11'];
    $phx12 = $_POST['phx12'];
    $phx13 = $_POST['phx13'];
    $phx14 = $_POST['phx14'];
    $phx15 = $_POST['phx15'];
    $phx16 = $_POST['phx16'];
    $phx17 = $_POST['phx17'];
    $phx18 = $_POST['phx18'];
    $phx19 = $_POST['phx19'];
    $phx20 = $_POST['phx20'];
    $phx21 = $_POST['phx21'];
    $phx22 = $_POST['phx22'];
    $phx23 = $_POST['phx23'];
    $phx24 = $_POST['phx24'];
    $phx25 = $_POST['phx25'];
    $phx26 = $_POST['phx26'];
    $phx27 = $_POST['phx27'];
    $phx28 = $_POST['phx28'];
    $phx29 = $_POST['phx29'];
    $phx30 = $_POST['phx30'];
    $phx31 = $_POST['phx31'];
    $phx32 = $_POST['phx32'];
    $phx33 = $_POST['phx33'];
    $phx34 = $_POST['phx34'];
    $phx35 = $_POST['phx35'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    $query = "UPDATE `dental_history` SET `attend_id`='$attend_id', `patient_id`='$patient_id', 
    `1`='$phx1', `2`='$phx2', `3`='$phx3', `4`='$phx4', `5`='$phx5', `6`='$phx6', `7`='$phx7', 
    `8`='$phx8', `9`='$phx9', `10`='$phx10', `11`='$phx11', `12`='$phx12', `13`='$phx13', 
    `14`='$phx14', `15`='$phx15', `16`='$phx16', `17`='$phx17', `18`='$phx18', `19`='$phx19', 
    `20`='$phx20', `21`='$phx21', `22`='$phx22', `23`='$phx23', `24`='$phx24', `25`='$phx25', 
    `26`='$phx26', `27`='$phx27', `28`='$phx28', `29`='$phx29', `30`='$phx30', `31`='$phx31', 
    `32`='$phx32', `33`='$phx33', `34`='$phx34', `35`='$phx35', `altered_by`='$user_id', `altered_datetime`=NOW()
        WHERE `dent_hx_id`='$phx_id'";
        $query_run = mysqli_query($con, $query);
        $error = mysqli_error($con);
        echo $error;
}

function save_extra_assessment()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $Facial_Type = $_POST['Facial_Type'];
    $Profile_Type = $_POST['Profile_Type'];
    $Lower_Facial_Height = $_POST['Lower_Facial_Height'];
    $Transverse = $_POST['Transverse'];
    $TMJ = $_POST['TMJ'];
    $Lip_Competence = $_POST['Lip_Competence'];
    $Incisor_Show_at_Rest = $_POST['Incisor_Show_at_Rest'];
    $Incisor_Show_when_smiling = $_POST['Incisor_Show_when_smiling'];
    $Naso_Labial_Angle = $_POST['Naso_Labial_Angle'];
    $Labio_Mental_Fold = $_POST['Labio_Mental_Fold'];
    $Lip_To_E_Line = $_POST['Lip_To_E_Line'];
    $Symmetry = $_POST['Symmetry'];
    $Scars = $_POST['Scars'];
    $Lesions = $_POST['Lesions'];
    $Oral_Habit = $_POST['Oral_Habit'];
    $Others = $_POST['Others'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO `dental_assess_extra_oral`(`company_id`, `attend_id`, `patient_id`, 
    `Facial_Type`, `Profile_Type`, `Lower_Facial_Height`, `Transverse`, `TMJ`, `Lip_Competence`, 
    `Incisor_Show_at_Rest`, `Incisor_Show_when_smiling`, `Naso_Labial_Angle`, `Labio_Mental_Fold`, 
    `Lip_To_E_Line`, `Symmetry`, `Scars`, `Lesions`, `Oral_Habit`, `Other`, `branch_id`, `created_by`, 
    `created_datetime`) 
    VALUES ('$company_id','$attend_id','$patient_id','$Facial_Type','$Profile_Type',
    '$Lower_Facial_Height','$Transverse','$TMJ','$Lip_Competence','$Incisor_Show_at_Rest',
    '$Incisor_Show_when_smiling','$Naso_Labial_Angle','$Labio_Mental_Fold','$Lip_To_E_Line',
    '$Symmetry','$Scars','$Lesions','$Oral_Habit','$Others','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        if ($_SESSION['user_type_id'] == 6) 
        {
            doctor_attend_register();
        };
    };
}

function edit_extra_assessment()
{
    global $con;
    $dental_aeo_id = $_POST['dental_aeo_id'];
    $Data=array();
    $query = "SELECT * FROM dental_assess_extra_oral WHERE dental_aeo_id='$dental_aeo_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Data, 
            $row['dental_aeo_id'],$row['attend_id'],$row['patient_id'],$row['Facial_Type'],$row['Profile_Type'],$row['Lower_Facial_Height'],$row['Transverse'],
            $row['TMJ'],$row['Lip_Competence'],$row['Incisor_Show_when_smiling'],$row['Incisor_Show_at_Rest'],$row['Naso_Labial_Angle'],
            $row['Labio_Mental_Fold'],$row['Lip_To_E_Line'],$row['Symmetry'],$row['Scars'],$row['Lesions'],$row['Oral_Habit'],$row['Other']
        );
    }
     echo json_encode($Data);
}

function update_extra_assessment()
{
    global $con;
    $dental_aeo_id = $_POST['dental_aeo_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $Facial_Type = $_POST['Facial_Type'];
    $Profile_Type = $_POST['Profile_Type'];
    $Lower_Facial_Height = $_POST['Lower_Facial_Height'];
    $Transverse = $_POST['Transverse'];
    $TMJ = $_POST['TMJ'];
    $Lip_Competence = $_POST['Lip_Competence'];
    $Incisor_Show_at_Rest = $_POST['Incisor_Show_at_Rest'];
    $Incisor_Show_when_smiling = $_POST['Incisor_Show_when_smiling'];
    $Naso_Labial_Angle = $_POST['Naso_Labial_Angle'];
    $Labio_Mental_Fold = $_POST['Labio_Mental_Fold'];
    $Lip_To_E_Line = $_POST['Lip_To_E_Line'];
    $Symmetry = $_POST['Symmetry'];
    $Scars = $_POST['Scars'];
    $Lesions = $_POST['Lesions'];
    $Oral_Habit = $_POST['Oral_Habit'];
    $Others = $_POST['Others'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `dental_assess_extra_oral` SET `attend_id`='$attend_id', 
    `patient_id`='$patient_id', `Facial_Type`='$Facial_Type', `Profile_Type`='$Profile_Type', 
    `Lower_Facial_Height`='$Lower_Facial_Height', `Transverse`='$Transverse', `TMJ`='$TMJ', 
    `Lip_Competence`='$Lip_Competence', `Incisor_Show_at_Rest`='$Incisor_Show_at_Rest', 
    `Incisor_Show_when_smiling`='$Incisor_Show_when_smiling', 
    `Naso_Labial_Angle`='$Naso_Labial_Angle', `Labio_Mental_Fold`='$Labio_Mental_Fold', 
    `Lip_To_E_Line`='$Lip_To_E_Line', `Symmetry`='$Symmetry', `Scars`='$Scars', 
    `Lesions`='$Lesions', `Oral_Habit`='$Oral_Habit', `Other`='$Others', `altered_by`='$user_id', 
    `altered_datetime`=NOW()
    WHERE `dental_aeo_id`='$dental_aeo_id'";
    $query_run = mysqli_query($con, $query);
}

function save_intra_assessment()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $Tongue = $_POST['Tongue'];
    $Gingiva = $_POST['Gingiva'];
    $Overjet = $_POST['Overjet'];
    $Overbite_mm = $_POST['Overbite_mm'];
    $Overbite_perc = $_POST['Overbite_perc'];
    $Openbite = $_POST['Openbite'];
    $Molar_Relation_R = $_POST['Molar_Relation_R'];
    $Molar_Relation_L = $_POST['Molar_Relation_L'];
    $Canine_Relation_R = $_POST['Canine_Relation_R'];
    $Canine_Relation_L = $_POST['Canine_Relation_L'];
    $Incisor_Relation = $_POST['Incisor_Relation'];
    $Arches_U = $_POST['Arches_U'];
    $Arches_L = $_POST['Arches_L'];
    $Crossbites_Anterior = $_POST['Crossbites_Anterior'];
    $Crossbites_Posterior = $_POST['Crossbites_Posterior'];
    $Curve_of_Spee_R = $_POST['Curve_of_Spee_R'];
    $Curve_of_Spee_L = $_POST['Curve_of_Spee_L'];
    $Stage_of_Dentition = $_POST['Stage_of_Dentition'];
    $Tooth_Size = $_POST['Tooth_Size'];
    $Centerlines = $_POST['Centerlines'];
    $Deviated_Remarks = $_POST['Deviated_Remarks'];
    $Tonsils = $_POST['Tonsils'];
    $Lesions = $_POST['Lesions'];
    $Akerly_Type = $_POST['Akerly_Type'];
    $Symmetry = $_POST['Symmetry'];
    $Missing_Teeth = $_POST['Missing_Teeth'];
    $Malformed_Teeth = $_POST['Malformed_Teeth'];
    $Calculus = $_POST['Calculus'];
    $Other = $_POST['Other'];
    $Rotations = $_POST['Rotations'];
    $Crowding = $_POST['Crowding'];
    $Spacing = $_POST['Spacing'];
    $Impacted_Teeth = $_POST['Impacted_Teeth'];
    $Aesthetic = $_POST['Aesthetic'];
    $Dental_nhis = $_POST['Dental_nhis'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO `dental_assess_intra_oral`(`company_id`, `attend_id`, `patient_id`, `Tongue`, `Gingiva`, `Overjet`, `Overbite_mm`, `Overbite_perc`, 
    `Openbite`, `Molar_Relation_R`, `Molar_Relation_L`, `Canine_Relation_R`, `Canine_Relation_L`, `Incisor_Relation`, `Arches_U`, `Arches_L`, 
    `Crossbites_Anterior`, `Crossbites_Posterior`, `Curve_of_Spee_R`,`Curve_of_Spee_L`, `Stage_of_Dentition`, `Tooth_Size`, `Centerlines`, `Deviated_Remarks`, 
    `Tonsils`, `Lesions`, `Akerly_Type`, `Symmetry`, `Missing_Teeth`, `Malformed_Teeth`, `Calculus`, `Other`, `Rotations`, `Crowding`, `Spacing`, 
    `Impacted_Teeth`, `Aesthetic`, `Dental_nhis`, `branch_id`, `created_by`, `created_datetime`) 
    VALUES ('$company_id','$attend_id','$patient_id','$Tongue','$Gingiva','$Overjet','$Overbite_mm','$Overbite_perc','$Openbite','$Molar_Relation_R','$Molar_Relation_L',
    '$Canine_Relation_R','$Canine_Relation_L','$Incisor_Relation','$Arches_U','$Arches_L','$Crossbites_Anterior','$Crossbites_Posterior','$Curve_of_Spee_R',
    '$Curve_of_Spee_L','$Stage_of_Dentition','$Tooth_Size','$Centerlines','$Deviated_Remarks','$Tonsils','$Lesions','$Akerly_Type','$Symmetry',
    '$Missing_Teeth','$Malformed_Teeth','$Calculus','$Other','$Rotations','$Crowding','$Spacing','$Impacted_Teeth','$Aesthetic','$Dental_nhis',
    '$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        if ($_SESSION['user_type_id'] == 6) 
        {
            doctor_attend_register();
        };
    };
}

function edit_intra_assessment()
{
    global $con;
    $dental_aio_id = $_POST['dental_aio_id'];
    $Data=array();
    $query = "SELECT * FROM dental_assess_intra_oral WHERE dental_aio_id='$dental_aio_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Data, 
            $row['dental_aio_id'],$row['attend_id'],$row['patient_id'],
            $row['Tongue'],$row['Gingiva'],$row['Overjet'],$row['Overbite_mm'],$row['Overbite_perc'],$row['Openbite'],$row['Molar_Relation_R'],
            $row['Molar_Relation_L'],$row['Canine_Relation_R'],$row['Canine_Relation_L'],$row['Incisor_Relation'],$row['Arches_U'],$row['Arches_L'],
            $row['Crossbites_Anterior'],$row['Crossbites_Posterior'],$row['Curve_of_Spee_R'],$row['Curve_of_Spee_L'],$row['Stage_of_Dentition'],
            $row['Tooth_Size'],$row['Centerlines'],$row['Deviated_Remarks'],$row['Tonsils'],$row['Lesions'],$row['Akerly_Type'],$row['Symmetry'],
            $row['Missing_Teeth'],$row['Malformed_Teeth'],$row['Calculus'],$row['Other'],$row['Rotations'],$row['Crowding'],$row['Spacing'],
            $row['Impacted_Teeth'],$row['Aesthetic'],$row['Dental_nhis']
        );
    }
     echo json_encode($Data);
}

function update_intra_assessment()
{
    global $con;
    $dental_aio_id = $_POST['dental_aio_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $Tongue = $_POST['Tongue'];
    $Gingiva = $_POST['Gingiva'];
    $Overjet = $_POST['Overjet'];
    $Overbite_mm = $_POST['Overbite_mm'];
    $Overbite_perc = $_POST['Overbite_perc'];
    $Openbite = $_POST['Openbite'];
    $Molar_Relation_R = $_POST['Molar_Relation_R'];
    $Molar_Relation_L = $_POST['Molar_Relation_L'];
    $Canine_Relation_R = $_POST['Canine_Relation_R'];
    $Canine_Relation_L = $_POST['Canine_Relation_L'];
    $Incisor_Relation = $_POST['Incisor_Relation'];
    $Arches_U = $_POST['Arches_U'];
    $Arches_L = $_POST['Arches_L'];
    $Crossbites_Anterior = $_POST['Crossbites_Anterior'];
    $Crossbites_Posterior = $_POST['Crossbites_Posterior'];
    $Curve_of_Spee_R = $_POST['Curve_of_Spee_R'];
    $Curve_of_Spee_L = $_POST['Curve_of_Spee_L'];
    $Stage_of_Dentition = $_POST['Stage_of_Dentition'];
    $Tooth_Size = $_POST['Tooth_Size'];
    $Centerlines = $_POST['Centerlines'];
    $Deviated_Remarks = $_POST['Deviated_Remarks'];
    $Tonsils = $_POST['Tonsils'];
    $Lesions = $_POST['Lesions'];
    $Akerly_Type = $_POST['Akerly_Type'];
    $Symmetry = $_POST['Symmetry'];
    $Missing_Teeth = $_POST['Missing_Teeth'];
    $Malformed_Teeth = $_POST['Malformed_Teeth'];
    $Calculus = $_POST['Calculus'];
    $Other = $_POST['Other'];
    $Rotations = $_POST['Rotations'];
    $Crowding = $_POST['Crowding'];
    $Spacing = $_POST['Spacing'];
    $Impacted_Teeth = $_POST['Impacted_Teeth'];
    $Aesthetic = $_POST['Aesthetic'];
    $Dental_nhis = $_POST['Dental_nhis'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `dental_assess_intra_oral` SET `attend_id`='$attend_id', `patient_id`='$patient_id', `Tongue`='$Tongue', `Gingiva`='$Gingiva', 
    `Overjet`='$Overjet', `Overbite_mm`='$Overbite_mm', `Overbite_perc`='$Overbite_perc', `Openbite`='$Openbite', `Molar_Relation_R`='$Molar_Relation_R', 
    `Molar_Relation_L`='$Molar_Relation_L', `Canine_Relation_R`='$Canine_Relation_R', `Canine_Relation_L`='$Canine_Relation_L', 
    `Incisor_Relation`='$Incisor_Relation', `Arches_U`='$Arches_U', `Arches_L`='$Arches_L', `Crossbites_Anterior`='$Crossbites_Anterior', 
    `Crossbites_Posterior`='$Crossbites_Posterior', `Curve_of_Spee_R`='$Curve_of_Spee_R',`Curve_of_Spee_L`='$Curve_of_Spee_L', 
    `Stage_of_Dentition`='$Stage_of_Dentition', `Tooth_Size`='$Tooth_Size', `Centerlines`='$Centerlines', `Deviated_Remarks`='$Deviated_Remarks', 
    `Tonsils`='$Tonsils', `Lesions`='$Lesions', `Akerly_Type`='$Akerly_Type', `Symmetry`='$Symmetry', `Missing_Teeth`='$Missing_Teeth', 
    `Malformed_Teeth`='$Malformed_Teeth', `Calculus`='$Calculus', `Other`='$Other', `Rotations`='$Rotations', `Crowding`='$Crowding', `Spacing`='$Spacing', 
    `Impacted_Teeth`='$Impacted_Teeth', `Aesthetic`='$Aesthetic', `Dental_nhis`='$Dental_nhis', `altered_by`='$user_id', `altered_datetime`=NOW()
    WHERE `dental_aio_id`='$dental_aio_id'";
    $query_run = mysqli_query($con, $query);
}

function tooth_enquiry()
{
    global $con;
    $tooth_id = $_POST['tooth_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $data=array();
    if (
        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
        $_SESSION['user_type'] == 'Super_User' OR 
        (
            $_SESSION['user_type'] == 'Normal_User' && 
            $_SESSION['Create_Dental'] == 'Yes' && 
            $_SESSION['Edit_Dental'] == 'Yes'
        )
    )
    {
        $query = "SELECT * FROM dental_chart WHERE dental_teeth_id='$tooth_id' AND patient_id='$patient_id'";
        $result = mysqli_query($con,$query);
            if (mysqli_num_rows($result) > 0)
            {
                $patient_tooth = 'present';
            }
            else
            {
                $patient_tooth = 'none';
            };
            array_push($data, $patient_tooth);

        $query_attd = "SELECT * FROM dental_chart WHERE dental_teeth_id='$tooth_id' AND patient_id='$patient_id' AND attend_id='$attend_id'";
        $result_attd = mysqli_query($con,$query_attd);
            if (mysqli_num_rows($result_attd) > 0)
            {
                $attend_tooth = 'present';
            }
            else
            {
                $attend_tooth = 'none';
            };
            array_push($data, $attend_tooth);
    }
    else if($_SESSION['user_type'] == 'Normal_User' && $_SESSION['Create_Dental'] == 'Yes' && $_SESSION['Edit_Dental'] == 'No')
    {
        $tooth_create = 'dental_creation';
        $tooth_edit = 'no_dental_editing';
        array_push($data, $tooth_create, $tooth_edit);
    }
    else if($_SESSION['user_type'] == 'Normal_User' && $_SESSION['Create_Dental'] == 'No' && $_SESSION['Edit_Dental'] == 'Yes')
    {
        $tooth_create = 'no_dental_creation';
        $tooth_edit = 'dental_editing';
        array_push($data, $tooth_create, $tooth_edit);
    }
    else if($_SESSION['user_type'] == 'Normal_User' && $_SESSION['Create_Dental'] == 'No' && $_SESSION['Edit_Dental'] == 'No')
    {
        $tooth_create = 'no_dental_creation';
        $tooth_edit = 'no_dental_editing';
        array_push($data, $tooth_create, $tooth_edit);
    };
    
    echo json_encode($data);
}

function tooth_tooltip()
{
    global $con;
    $tooth_id = $_POST['tooth_id'];
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value.= $tooth_id;
    $query = "SELECT * FROM dental_chart WHERE dental_teeth_id='$tooth_id' AND patient_id='$patient_id'";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) > 0)
    {
        while($row=mysqli_fetch_assoc($result))
        {
            $value.="\r\n\r\n". $row['date'] ."\r\n". $row['remarks'];
        };
    }
    else
    {
            $value.="\r\n".'No Entry yet!';
    };
     echo $value;
}

function save_dental_chart()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $tooth_id = $_POST['tooth_id'];
    $date = $_POST['chart_date'];
    $remark = $_POST['chart_remark'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO `dental_chart`(`company_id`,`attend_id`, `patient_id`, `dental_teeth_id`, 
    `date`, `remarks`, `branch_id`, `created_by`, `created_datetime`) 
    VALUES ('$company_id','$attend_id','$patient_id','$tooth_id','$date','$remark',
    '$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);
        if ($query_run) {
            if ($_SESSION['user_type_id'] == 6) {
            doctor_attend_register();
        };
    };
}

function edit_dental_chart()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $tooth_id = $_POST['tooth_id'];
    $Data=array();
    $query = "SELECT * FROM dental_chart WHERE dental_teeth_id='$tooth_id' AND patient_id='$patient_id' AND attend_id='$attend_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Data, $row['dental_chart_id'],$row['attend_id'],$row['patient_id'],$row['dental_teeth_id'],$row['date'],$row['remarks']);
    }
     echo json_encode($Data);
}

function update_dental_chart()
{
    global $con;
    $dental_chart_id  = $_POST['dental_chart_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $tooth_id = $_POST['tooth_id'];
    $date = $_POST['chart_date'];
    $remark = $_POST['chart_remark'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `dental_chart` SET `attend_id`='$attend_id', `patient_id`='$patient_id', 
    `dental_teeth_id`='$tooth_id', `date`='$date', `remarks`='$remark', `altered_by`='$user_id', 
    `altered_datetime`=NOW()
    WHERE dental_chart_id='$dental_chart_id'";
    $query_run = mysqli_query($con, $query);
}

function view_dental_chart()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $tooth_id = $_POST['tooth_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="20%">Date</th>
                        <th width="80%">Remarks</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM dental_chart WHERE dental_teeth_id='$tooth_id' AND patient_id='$patient_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        while($row=mysqli_fetch_assoc($query_run))
        {
            
                $value.='<tr>
                            <td><a href="#" id="btn_edit_dental_chart" data-id1="'.$row['dental_chart_id'].'">'.$row['date'].'</a></td>
                            <td>'.$row['remarks'].'</td>
                        </tr>';
        }
    };
    $value.='</tbody>
            </table>';
    echo $value;
}

?>
