<html>
  <link rel='stylesheet' href='/css/sweetalert.css'>

<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/bdd.php');

 if (isset($_POST['name']) && isset($_POST['start']) && isset($_POST['end']))
 {
	$title = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$color = $_POST['color'];
	$patient_id = $_POST['patient_id'];
	$attend_id = $_POST['attend_id'];
	$name = $_POST['name'];
	$sex = $_POST['sex'];
	$age = $_POST['age'];
	$appoint_type = $_POST['appoint_type'];
	$doctor = $_POST['doctor'];
	$surgery = $_POST['surgery'];
	$anesthetist = $_POST['anesthetist'];
	$theatre = $_POST['theatre'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$date = $_POST['date'];
	$time = $_POST['time'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $branch_id = $_SESSION['branch_id'];
    date_default_timezone_set("Africa/Accra");
	$datetime = date('Y/m/d H:i:s');
	
    $_SESSION['appoint_type']=$_POST['appoint_type'];
    $_SESSION['appoint_doctor']=$_POST['doctor'];
    $_SESSION['appoint_theatre']=$_POST['theatre'];
    $_SESSION['appoint_start']=$_POST['date'];
    $_SESSION['appoint_end']=$_POST['date'];
    $_SESSION['appoint_branch']=$_SESSION['branch_id'];

	$sql = "INSERT INTO appointment (title, start, end, color,status, patient_id, attend_id, gender_id, 
	age, name, doctor, anesthetist, appoint_type_id, surgery_id, theatre_id, email, phone, date, 
	time, company_id, user_id, created_by, created_datetime, branch_id) values ('$title', '$start', 
	'$end', '$color', NULL, '$patient_id', '$attend_id', '$sex', '$age', '$name', '$doctor', '$anesthetist', 
	'$appoint_type', '$surgery', '$theatre', '$email', '$phone', '$date', '$time', '$company_id', '$user_id', 
	'$user_id', '$datetime', '$branch_id')";

	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$sth = $query->execute();

	if ($sth == false) 
	{
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}
}

/*if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']))
{

	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$role = $_POST['role'];

			
	$sql = "INSERT INTO member_rss(member_first, username, password,email,role) values ('$name', '$username', '$password', '$email','$role')";
	//$req = $bdd->prepare($sql);
	//$req->execute();
	echo $sql;

	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$sth = $query->execute();


	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}
}

$_SESSION['appoint_type'] = $_POST['appoint_type'];
header('Location: calendar.php');*/
?>
  <script src='/js/sweetalert.min.js'></script>
  <script>window.open('/layout/attendance/calendar.php', '_blank');</script>
</html>
