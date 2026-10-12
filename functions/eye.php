<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//EYE
function save_eye_visual_acuity()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $date = $_SESSION['dateofadmission_attd'];
    $eye_visual_acuity_unaided_right = $_POST['eye_visual_acuity_unaided_right'];
    $eye_visual_acuity_unaided_left = $_POST['eye_visual_acuity_unaided_left'];
    $eye_visual_acuity_pinhole_right = $_POST['eye_visual_acuity_pinhole_right'];
    $eye_visual_acuity_pinhole_left = $_POST['eye_visual_acuity_pinhole_left'];
    $eye_visual_acuity_aided_right = $_POST['eye_visual_acuity_aided_right'];
    $eye_visual_acuity_aided_left = $_POST['eye_visual_acuity_aided_left'];
    $eye_visual_acuity_iop_right = $_POST['eye_visual_acuity_iop_right'];
    $eye_visual_acuity_iop_left = $_POST['eye_visual_acuity_iop_left'];
    $eye_visual_acuity_iop_left = $_POST['eye_visual_acuity_iop_left'];
    $eye_visual_acuity_remarks = $_POST['eye_visual_acuity_remarks'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO `eye_visual_acuity`(
    `company_id`, `attend_id`, `patient_id`, `unaided_L`, `unaided_R`, `pinhole_L`, 
    `pinhole_R`, `aided_L`, `aided_R`, `IOP_L`, `IOP_R`, `Remarks`, `date`,
    `branch_id`,`created_by`,`created_datetime`) VALUES (
    '$company_id','$attend_id','$patient_id','$eye_visual_acuity_unaided_left','$eye_visual_acuity_unaided_right','$eye_visual_acuity_pinhole_left',
    '$eye_visual_acuity_pinhole_right','$eye_visual_acuity_aided_left','$eye_visual_acuity_aided_right','$eye_visual_acuity_iop_left',
    '$eye_visual_acuity_iop_right','$eye_visual_acuity_remarks','$date','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        if ($_SESSION['user_type_id'] == 6) {
            doctor_attend_register();
        };
    };
}

function edit_eye_visual_acuity()
{
    global $con;
    $eye_va_id = $_POST['eye_va_id'];
    $Data=array();
    $query = "SELECT * FROM eye_visual_acuity WHERE eye_va_id='$eye_va_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Data, 
            $row['eye_va_id'],$row['unaided_R'],$row['unaided_L'],
            $row['pinhole_R'],$row['pinhole_L'],$row['aided_R'],$row['aided_L'],$row['IOP_R'],$row['IOP_L'],$row['Remarks']
        );
    }
     echo json_encode($Data);
}

function update_eye_visual_acuity()
{
    global $con;
    $eye_va_id = $_POST['eye_visual_acuity_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $date = $_SESSION['dateofadmission_attd'];
    $eye_visual_acuity_unaided_right = $_POST['eye_visual_acuity_unaided_right'];
    $eye_visual_acuity_unaided_left = $_POST['eye_visual_acuity_unaided_left'];
    $eye_visual_acuity_pinhole_right = $_POST['eye_visual_acuity_pinhole_right'];
    $eye_visual_acuity_pinhole_left = $_POST['eye_visual_acuity_pinhole_left'];
    $eye_visual_acuity_aided_right = $_POST['eye_visual_acuity_aided_right'];
    $eye_visual_acuity_aided_left = $_POST['eye_visual_acuity_aided_left'];
    $eye_visual_acuity_iop_right = $_POST['eye_visual_acuity_iop_right'];
    $eye_visual_acuity_iop_left = $_POST['eye_visual_acuity_iop_left'];
    $eye_visual_acuity_iop_left = $_POST['eye_visual_acuity_iop_left'];
    $eye_visual_acuity_remarks = $_POST['eye_visual_acuity_remarks'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `eye_visual_acuity` SET 
    `company_id`='$company_id', `attend_id`='$attend_id', `patient_id`='$patient_id', 
    `unaided_L`='$eye_visual_acuity_unaided_left', `unaided_R`='$eye_visual_acuity_unaided_right', 
    `pinhole_L`='$eye_visual_acuity_pinhole_left',  `date`='$date', 
    `pinhole_R`='$eye_visual_acuity_pinhole_right', `aided_L`='$eye_visual_acuity_aided_left', 
    `aided_R`='$eye_visual_acuity_aided_right', `IOP_L`='$eye_visual_acuity_iop_left', 
    `IOP_R`='$eye_visual_acuity_iop_right', `Remarks`='$eye_visual_acuity_remarks', 
    `altered_by`='$user_id', `altered_datetime`=NOW() 
    WHERE `eye_va_id`='$eye_va_id'";
    $query_run = mysqli_query($con, $query);
    
    if ($query_run)
    {
        if ($_SESSION['user_type_id'] == 6) {
            doctor_attend_register();
        };
    };
}

function save_eye_ocular_exam()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $eoe_lid_right = $_POST['eoe_lid_right'];
    $eoe_lid_left = $_POST['eoe_lid_left'];
    $eoe_lid_remarks = $_POST['eoe_lid_remarks'];
    $eoe_conjunctiva_right = $_POST['eoe_conjunctiva_right'];
    $eoe_conjunctiva_left = $_POST['eoe_conjunctiva_left'];
    $eoe_conjunctiva_remarks = $_POST['eoe_conjunctiva_remarks'];
    $eoe_cornea_right = $_POST['eoe_cornea_right'];
    $eoe_cornea_left = $_POST['eoe_cornea_left'];
    $eoe_cornea_remarks = $_POST['eoe_cornea_remarks'];
    $eoe_ac_right = $_POST['eoe_ac_right'];
    $eoe_ac_left = $_POST['eoe_ac_left'];
    $eoe_ac_remarks = $_POST['eoe_ac_remarks'];
    $eoe_pupil_right = $_POST['eoe_pupil_right'];
    $eoe_pupil_left = $_POST['eoe_pupil_left'];
    $eoe_pupil_remarks = $_POST['eoe_pupil_remarks'];
    $eoe_lens_right = $_POST['eoe_lens_right'];
    $eoe_lens_left = $_POST['eoe_lens_left'];
    $eoe_lens_remarks = $_POST['eoe_lens_remarks'];
    $eoe_vitreous_right = $_POST['eoe_vitreous_right'];
    $eoe_vitreous_left = $_POST['eoe_vitreous_left'];
    $eoe_vitreous_remarks = $_POST['eoe_vitreous_remarks'];
    $eoe_fundus_right = $_POST['eoe_fundus_right'];
    $eoe_fundus_left = $_POST['eoe_fundus_left'];
    $eoe_fundus_remarks = $_POST['eoe_fundus_remarks'];
    $eoe_vc_d_right = $_POST['eoe_vc_d_right'];
    $eoe_vc_d_left = $_POST['eoe_vc_d_left'];
    $eoe_vc_d_remarks = $_POST['eoe_vc_d_remarks'];
    $eoe_iop_right = $_POST['eoe_iop_right'];
    $eoe_iop_left = $_POST['eoe_iop_left'];
    $eoe_iop_remarks = $_POST['eoe_iop_remarks'];
    $eoe_visual_field_result = $_POST['eoe_visual_field_result'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    $date = $_SESSION['dateofadmission_attd'];

    $query = "INSERT INTO `eye_ocular_exam`(
    `company_id`, `attend_id`, `patient_id`, `LID_L`, `LID_R`, `LID_Remarks`, `CONJUNCTIVA_L`, 
    `CONJUNCTIVA_R`, `CONJUNCTIVA_Remarks`, `CORNEA_L`, `CORNEA_R`, `CORNEA_Remarks`, 
    `AC_L`, `AC_R`, `AC_Remarks`, `PUPIL_L`, `PUPIL_R`, `PUPIL_Remarks`, `LENS_L`,`LENS_R`, 
    `LENS_Remarks`, `VITREOUS_L`, `VITREOUS_R`, `VITREOUS_Remarks`, `FUNDUS_L`, `FUNDUS_R`, 
    `FUNDUS_Remarks`, `VC_D_L`, `VC_D_R`, `VC_D_Remarks`,`IOP_L`, `IOP_R`, `IOP_Remarks`, 
    `remarks`, `date`, `branch_id`, `created_by`, `created_datetime`) 
        VALUES (
    '$company_id','$attend_id','$patient_id','$eoe_lid_left','$eoe_lid_right','$eoe_lid_remarks',
    '$eoe_conjunctiva_left','$eoe_conjunctiva_right','$eoe_conjunctiva_remarks','$eoe_cornea_left',
    '$eoe_cornea_right','$eoe_cornea_remarks','$eoe_ac_left','$eoe_ac_right','$eoe_ac_remarks',
    '$eoe_pupil_left','$eoe_pupil_right','$eoe_pupil_remarks','$eoe_lens_left','$eoe_lens_right',
    '$eoe_lens_remarks','$eoe_vitreous_left','$eoe_vitreous_right','$eoe_vitreous_remarks',
    '$eoe_fundus_left','$eoe_fundus_right','$eoe_fundus_remarks','$eoe_vc_d_left','$eoe_vc_d_right',
    '$eoe_vc_d_remarks','$eoe_iop_left','$eoe_iop_right','$eoe_iop_remarks','$eoe_visual_field_result',
    '$date','$branch_id','$user_id',NOW())";
        $query_run = mysqli_query($con, $query);
    if ($query_run) {
        if ($_SESSION['user_type_id'] == 6) 
        {
            doctor_attend_register();
        };
    };
}

function edit_eye_ocular_exam()
{
    global $con;
    $eye_oe_id = $_POST['eye_oe_id'];
    $Data=array();
    $query = "SELECT * FROM eye_ocular_exam WHERE eye_oe_id='$eye_oe_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Data, 
            $row['eye_oe_id'],$row['LID_L'],$row['LID_R'],$row['LID_Remarks'],$row['CONJUNCTIVA_L'],$row['CONJUNCTIVA_R'],$row['CONJUNCTIVA_Remarks'],
            $row['CORNEA_L'],$row['CORNEA_R'],$row['CORNEA_Remarks'],$row['AC_L'],$row['AC_R'],$row['AC_Remarks'],$row['PUPIL_L'],$row['PUPIL_R'],
            $row['PUPIL_Remarks'],$row['LENS_L'],$row['LENS_R'],$row['LENS_Remarks'],$row['VITREOUS_L'],$row['VITREOUS_R'],$row['VITREOUS_Remarks'],
            $row['FUNDUS_L'],$row['FUNDUS_R'],$row['FUNDUS_Remarks'],$row['VC_D_L'],$row['VC_D_R'],$row['VC_D_Remarks'],$row['IOP_L'],$row['IOP_R'],
            $row['IOP_Remarks'],$row['remarks']
        );
    }
     echo json_encode($Data);
}

function update_eye_ocular_exam()
{
    global $con;
    $eye_ocular_examamination_id = $_POST['eye_ocular_examamination_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $eoe_lid_right = $_POST['eoe_lid_right'];
    $eoe_lid_left = $_POST['eoe_lid_left'];
    $eoe_lid_remarks = $_POST['eoe_lid_remarks'];
    $eoe_conjunctiva_right = $_POST['eoe_conjunctiva_right'];
    $eoe_conjunctiva_left = $_POST['eoe_conjunctiva_left'];
    $eoe_conjunctiva_remarks = $_POST['eoe_conjunctiva_remarks'];
    $eoe_cornea_right = $_POST['eoe_cornea_right'];
    $eoe_cornea_left = $_POST['eoe_cornea_left'];
    $eoe_cornea_remarks = $_POST['eoe_cornea_remarks'];
    $eoe_ac_right = $_POST['eoe_ac_right'];
    $eoe_ac_left = $_POST['eoe_ac_left'];
    $eoe_ac_remarks = $_POST['eoe_ac_remarks'];
    $eoe_pupil_right = $_POST['eoe_pupil_right'];
    $eoe_pupil_left = $_POST['eoe_pupil_left'];
    $eoe_pupil_remarks = $_POST['eoe_pupil_remarks'];
    $eoe_lens_right = $_POST['eoe_lens_right'];
    $eoe_lens_left = $_POST['eoe_lens_left'];
    $eoe_lens_remarks = $_POST['eoe_lens_remarks'];
    $eoe_vitreous_right = $_POST['eoe_vitreous_right'];
    $eoe_vitreous_left = $_POST['eoe_vitreous_left'];
    $eoe_vitreous_remarks = $_POST['eoe_vitreous_remarks'];
    $eoe_fundus_right = $_POST['eoe_fundus_right'];
    $eoe_fundus_left = $_POST['eoe_fundus_left'];
    $eoe_fundus_remarks = $_POST['eoe_fundus_remarks'];
    $eoe_vc_d_right = $_POST['eoe_vc_d_right'];
    $eoe_vc_d_left = $_POST['eoe_vc_d_left'];
    $eoe_vc_d_remarks = $_POST['eoe_vc_d_remarks'];
    $eoe_iop_right = $_POST['eoe_iop_right'];
    $eoe_iop_left = $_POST['eoe_iop_left'];
    $eoe_iop_remarks = $_POST['eoe_iop_remarks'];
    $eoe_visual_field_result = $_POST['eoe_visual_field_result'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    $date = $_SESSION['dateofadmission_attd'];

    $query = "UPDATE `eye_ocular_exam` SET 
    `company_id`='$company_id', `attend_id`='$attend_id', `patient_id`='$patient_id', `LID_L`='$eoe_lid_left', `LID_R`='$eoe_lid_right', 
    `LID_Remarks`='$eoe_lid_remarks', `CONJUNCTIVA_L`='$eoe_conjunctiva_left', `CONJUNCTIVA_R`='$eoe_conjunctiva_right', 
    `CONJUNCTIVA_Remarks`='$eoe_conjunctiva_remarks', `CORNEA_L`='$eoe_cornea_left', `CORNEA_R`='$eoe_cornea_right', `CORNEA_Remarks`='$eoe_cornea_remarks', 
    `AC_L`='$eoe_ac_left', `AC_R`='$eoe_ac_right', `AC_Remarks`='$eoe_ac_remarks', `PUPIL_L`='$eoe_pupil_left', `PUPIL_R`='$eoe_pupil_right', 
    `PUPIL_Remarks`='$eoe_pupil_remarks', `LENS_L`='$eoe_lens_left',`LENS_R`='$eoe_lens_right', `LENS_Remarks`='$eoe_lens_remarks', 
    `VITREOUS_L`='$eoe_vitreous_left', `VITREOUS_R`='$eoe_vitreous_right', `VITREOUS_Remarks`='$eoe_vitreous_remarks', `FUNDUS_L`='$eoe_fundus_left', 
    `FUNDUS_R`='$eoe_fundus_right', `FUNDUS_Remarks`='$eoe_fundus_remarks', `VC_D_L`='$eoe_vc_d_left', `VC_D_R`='$eoe_vc_d_right', 
    `VC_D_Remarks`='$eoe_vc_d_remarks',`IOP_L`='$eoe_iop_left', `IOP_R`='$eoe_iop_right', `IOP_Remarks`='$eoe_iop_remarks', 
    `remarks`='$eoe_visual_field_result', `date`= '$date', `altered_by`= '$user_id', `altered_datetime`= NOW()
    WHERE `eye_oe_id`= '$eye_ocular_examamination_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run) 
    {
        if ($_SESSION['user_type_id'] == 6) 
        {
            doctor_attend_register();
        };
    };
}

function save_eye_refraction()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $eye_refraction_id = $_POST['eye_refraction_id'];
    $eye_refraction_sph_right = $_POST['eye_refraction_sph_right'];
    $eye_refraction_sph_left = $_POST['eye_refraction_sph_left'];
    $eye_refraction_cyl_right = $_POST['eye_refraction_cyl_right'];
    $eye_refraction_cyl_left = $_POST['eye_refraction_cyl_left'];
    $eye_refraction_axis_right = $_POST['eye_refraction_axis_right'];
    $eye_refraction_axis_left = $_POST['eye_refraction_axis_left'];
    $eye_refraction_add_right = $_POST['eye_refraction_add_right'];
    $eye_refraction_add_left = $_POST['eye_refraction_add_left'];
    $eye_refraction_hgt_right = $_POST['eye_refraction_hgt_right'];
    $eye_refraction_hgt_left = $_POST['eye_refraction_hgt_left'];
    $eye_refraction_pd_right = $_POST['eye_refraction_pd_right'];
    $eye_refraction_pd_left = $_POST['eye_refraction_pd_left'];
    $eye_refraction_remarks = $_POST['eye_refraction_remarks'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    $date = $_SESSION['dateofadmission_attd'];

    $query = "INSERT INTO `eye_refraction`(
    `company_id`, `attend_id`, `patient_id`, `date`, `SPH_L`, `SPH_R`, `CYL_L`, `CYL_R`, `AXIS_L`, 
    `AXIS_R`, `ADD_L`, `ADD_R`, `HGT_L`, `HGT_R`, `PD_L`, 
    `PD_R`, `Remarks`, `branch_id`, `created_by`, `created_datetime`) VALUES (
    '$company_id','$attend_id','$patient_id','$date','$eye_refraction_sph_left','$eye_refraction_sph_right','$eye_refraction_cyl_left',
    '$eye_refraction_cyl_right','$eye_refraction_axis_left','$eye_refraction_axis_right','$eye_refraction_add_left','$eye_refraction_add_right',
    '$eye_refraction_hgt_left','$eye_refraction_hgt_right','$eye_refraction_pd_left',
    '$eye_refraction_pd_right','$eye_refraction_remarks','$branch_id','$user_id',
    NOW())";
    
    $query_run = mysqli_query($con, $query);
    if ($query_run) 
    {
        if ($_SESSION['user_type_id'] == 6) {
        doctor_attend_register();
        };
    };
}

function edit_eye_refraction()
{
    global $con;
    $eye_ref_id = $_POST['eye_ref_id'];
    $Data=array();
    $query = "SELECT * FROM eye_refraction WHERE eye_ref_id='$eye_ref_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Data, 
            $row['eye_ref_id'],$row['SPH_L'],$row['SPH_R'],$row['CYL_L'],$row['CYL_R'],$row['AXIS_L'],$row['AXIS_R'],$row['ADD_L'],$row['ADD_R'],
            $row['HGT_L'],$row['HGT_R'],$row['PD_L'],$row['PD_R'],$row['Remarks']
        );
    }
     echo json_encode($Data);
}

function update_eye_refraction()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $eye_refraction_id = $_POST['eye_refraction_id'];
    $eye_refraction_sph_right = $_POST['eye_refraction_sph_right'];
    $eye_refraction_sph_left = $_POST['eye_refraction_sph_left'];
    $eye_refraction_cyl_right = $_POST['eye_refraction_cyl_right'];
    $eye_refraction_cyl_left = $_POST['eye_refraction_cyl_left'];
    $eye_refraction_axis_right = $_POST['eye_refraction_axis_right'];
    $eye_refraction_axis_left = $_POST['eye_refraction_axis_left'];
    $eye_refraction_add_right = $_POST['eye_refraction_add_right'];
    $eye_refraction_add_left = $_POST['eye_refraction_add_left'];
    $eye_refraction_hgt_right = $_POST['eye_refraction_hgt_right'];
    $eye_refraction_hgt_left = $_POST['eye_refraction_hgt_left'];
    $eye_refraction_pd_right = $_POST['eye_refraction_pd_right'];
    $eye_refraction_pd_left = $_POST['eye_refraction_pd_left'];
    $eye_refraction_remarks = $_POST['eye_refraction_remarks'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    $date = $_SESSION['dateofadmission_attd'];

    $query = "UPDATE `eye_refraction`SET
    `company_id`='$company_id', `attend_id`='$attend_id', `patient_id`='$patient_id', `date`='$date', 
    `SPH_L`='$eye_refraction_sph_left', `SPH_R`='$eye_refraction_sph_right', `CYL_L`='$eye_refraction_cyl_left', 
    `CYL_R`='$eye_refraction_cyl_right', `AXIS_L`='$eye_refraction_axis_left', `AXIS_R`='$eye_refraction_axis_right', 
    `ADD_L`='$eye_refraction_add_left', `ADD_R`='$eye_refraction_add_right', `HGT_L`='$eye_refraction_hgt_left', 
    `HGT_R`='$eye_refraction_hgt_right', `PD_L`='$eye_refraction_pd_left', `PD_R`='$eye_refraction_pd_right', 
    `Remarks`='$eye_refraction_remarks', `altered_by`='$user_id', `altered_datetime`=NOW()
    WHERE `eye_ref_id`='$eye_refraction_id'";
    
    $query_run = mysqli_query($con, $query);
    if ($query_run) 
    {
        if ($_SESSION['user_type_id'] == 6) 
        {
            doctor_attend_register();
        };
    };
}

function save_eye_lens()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $eye_lens_details_id = $_POST['eye_lens_details_id'];
    $eld_lens_type = $_POST['eld_lens_type'];
    $eld_lens_material = $_POST['eld_lens_material'];
    $eld_lens_index = $_POST['eld_lens_index'];
    $eld_lens_frame_type = $_POST['eld_lens_frame_type'];
    $eld_remarks = $_POST['eld_remarks'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    $date = $_SESSION['dateofadmission_attd'];

    $lens_others = '';
    $number_as = count($_POST["lens_others"]);  
    if($number_as > 0)  
    {
        for($i=0; $i<$number_as; $i++)  
        {  
            if(trim($_POST["lens_others"][$i] !== '') && trim($_POST["lens_others"][$i] !== 0))  
            {  if($i <= 0)
                {
                    $lens_others = $_POST['lens_others'][$i];
                }
                else
                {
                    $lens_others = $lens_others.','.$_POST['lens_others'][$i];
                };
            };
        };
    };

    $query = "INSERT INTO `eye_lens`(`company_id`, `attend_id`, `patient_id`, `date`, `lens_type`, 
    `lens_material`, `lens_index`, 
    `lens_frame`, `lens_others`, `remarks`, `branch_id`, `created_by`, `created_datetime`) 
    VALUES ('$company_id','$attend_id','$patient_id','$date','$eld_lens_type','$eld_lens_material','$eld_lens_index',
    '$eld_lens_frame_type','$lens_others','$eld_remarks','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);
    if ($query_run) 
    {
        if ($_SESSION['user_type_id'] == 6) 
        {
            doctor_attend_register();
        };
    };
}

function edit_eye_lens()
{
    global $con;
    $eye_lens_id = $_POST['eye_lens_id'];
    $Data=array();
    $query = "SELECT * FROM eye_lens WHERE eye_lens_id='$eye_lens_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Data, 
            $row['eye_lens_id'],$row['lens_type'],$row['lens_material'],
            $row['lens_index'],$row['lens_frame'],$row['lens_others'],$row['remarks']
        );
    }
     echo json_encode($Data);
}

function update_eye_lens()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $eye_lens_details_id = $_POST['eye_lens_details_id'];
    $eld_lens_type = $_POST['eld_lens_type'];
    $eld_lens_material = $_POST['eld_lens_material'];
    $eld_lens_index = $_POST['eld_lens_index'];
    $eld_lens_frame_type = $_POST['eld_lens_frame_type'];
    $eld_remarks = $_POST['eld_remarks'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    $date = $_SESSION['dateofadmission_attd'];

    $lens_others = '';
    $number_as = count($_POST["lens_others"]);  
    if($number_as > 0)  
    {
        for($i=0; $i<$number_as; $i++)  
        {  
            if(trim($_POST["lens_others"][$i] !== '') && trim($_POST["lens_others"][$i] !== 0))  
            {  if($i <= 0)
                {
                    $lens_others = $_POST['lens_others'][$i];
                }
                else
                {
                    $lens_others = $lens_others.','.$_POST['lens_others'][$i];
                };
            };
        };
    };

    $query = "UPDATE `eye_lens` SET `company_id`='$company_id', `attend_id`='$attend_id', `patient_id`='$patient_id', `date`='$date', 
    `lens_type`='$eld_lens_type', `lens_material`='$eld_lens_material', `lens_index`='$eld_lens_index', `lens_frame`='$eld_lens_frame_type', 
    `lens_others`='$lens_others', `remarks`= '$eld_remarks', `altered_by`= '$user_id', `altered_datetime`= NOW()
    WHERE `eye_lens_id`= '$eye_lens_details_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run) 
    {
        if ($_SESSION['user_type_id'] == 6) 
        {
            doctor_attend_register();
        };
    };
}

?>
