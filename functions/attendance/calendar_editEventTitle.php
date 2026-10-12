<?php

//require_once('bdd.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/bdd.php');
if (isset($_POST['delete']) && isset($_POST['id']))
{
	$id = $_POST['id'];

	$sql = "DELETE FROM appointment WHERE id = $id";
	$query = $bdd->prepare( $sql );
	if ($query == false) 
	{
		 echo($bdd->errorInfo());
		 die ('Error prepare');
		 echo "<script>alert('Data added Successfully');</script>" ;
	}
		$res = $query->execute();
	if ($res == false) 
	{
		 print_r($query->errorInfo());
		 die ('Error execute');
	}

}
elseif (isset($_POST['title']) && isset($_POST['color']) && isset($_POST['id']))
{

	$id = $_POST['id'];
	$title = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$color = $_POST['color'];

	$patient_id = $_POST['patient_id'];
    $attend_id = $_POST['attend_id'];
    $gender_id = $_POST['sex'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $appoint_type_id = $_POST['appoint_type'];
    $doctor = $_POST['doctor'];
    $surgery = $_POST['surgery'];
    $anesthetist = $_POST['anesthetist'];
    $theatre_id = $_POST['theatre'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time = $_POST['time'];

	//$sql = "UPDATE appointment SET  title = '$title',start = '$start',end = '$end', color = '$color' WHERE id = $id ";
	$sql = "UPDATE appointment SET title='$title', start='$start', end='$end', color='$color', patient_id='$patient_id', attend_id='$attend_id', gender_id='$gender_id', age='$age', name='$name', doctor='$doctor', anesthetist='$anesthetist', appoint_type_id='$appoint_type_id', surgery_id='$surgery', theatre_id='$theatre_id', email='$email', phone='$phone', date='$date', time='$time' WHERE id = '$id'";


	$query = $bdd->prepare( $sql );
	if ($query == false) 
	{
	 print_r($bdd->errorInfo());
	 die ('Error prepare');
	};
	$sth = $query->execute();
	if ($sth == false) 
	{
	 print_r($query->errorInfo());
	 die ('Error execute');
	};

}

$_SESSION['appoint_type'] = $_POST['appoint_type'];
header('Location: calendar.php');
?>
