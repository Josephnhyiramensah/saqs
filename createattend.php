<?php 
    require('includes/db.php');
    include('includes/auth.php');
    if (isset($con)) {
    	$patient_id = $_POST["patientid"];
    	$name = $_POST["name"];
    	$age = $_POST["age"];
    	
			$query = "INSERT INTO attendance (patient_id, name, age) VALUES ('$patient_id', '$name', '$age')";
	    	$result = mysqli_query($con, $query);
	    	If ($result)
		    {
		        echo "Attendance Added Successfully";
		    }
		    else
		    {
		        echo "Attendance NOT Added";
		    };
    }
    else{
    	echo 'No Connection';
    }
    	
?>