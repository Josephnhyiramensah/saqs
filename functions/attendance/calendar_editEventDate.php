<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/bdd.php');

if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])){

	$id = $_POST['Event'][0];
	$start = $_POST['Event'][1];
	$end = $_POST['Event'][2];
	$patient_id = $_POST['Event'][3];
    $attend_id = $_POST['Event'][4];
    $gender_id = $_POST['Event'][5];
    $age = $_POST['Event'][6];
    $phone = $_POST['Event'][7];
    $email = $_POST['Event'][8];
    $appoint_type_id = $_POST['Event'][9];
    $doctor = $_POST['Event'][10];
    $surgery = $_POST['Event'][11];
    $anesthetist = $_POST['Event'][12];
    $theatre_id = $_POST['Event'][13];
    $name = $_POST['Event'][14];
    $title = $_POST['Event'][15];
    $color = $_POST['Event'][16];
    $date = $_POST['Event'][17];
    $time = $_POST['Event'][18];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    date_default_timezone_set("Africa/Accra");
	$datetime = date('Y/m/d H:i:s');

	$sql = "UPDATE appointment SET title='$title', start='$start', end='$end', color='$color', patient_id='$patient_id', attend_id='$attend_id', gender_id='$gender_id', age='$age', name='$name', doctor='$doctor', anesthetist='$anesthetist', appoint_type_id='$appoint_type_id', surgery_id='$surgery', theatre_id='$theatre_id', email='$email', phone='$phone', date='$date', time='$time', company_id='$company_id', user_id='$user_id', created_by='$user_id', created_datetime='$datetime' WHERE id = '$id'";


	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}else{
		die ('OK');
	}

}
$_SESSION['appoint_type'] = $appoint_type_id;
header('Location: '.$_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/calendar.php');



?>
