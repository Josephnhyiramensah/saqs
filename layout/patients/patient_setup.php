
<?php 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
    
	date_default_timezone_set("Africa/Accra");
	$year = date('Y');
    
    $new_number = '';
    $folder_no = '';

    $query = "SELECT * FROM patients ORDER BY number DESC";
    $result = mysqli_query($con,$query);
    if(!empty($result) && mysqli_num_rows($result)>0)
    {
        $row = mysqli_fetch_assoc($result);
        $new_number = $row['number'] + 1;
    }
    else
    {
        $new_number = 1;
    };
    $folder_no = $new_number.'/'.substr($year,2);
?>
<div class="container-fluid">
    <?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/patients/patient_setup_form.php');?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/patients/patient_attend_dialogue_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>