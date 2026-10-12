<?php
if (isset($_POST["insert"])) {
	 $file = addslashes(file_get_content($_FILES["image"]["tmp_name"]));
	 $query = "INSERT INTO patients(img) VALUES ('$file')";
	 if (mysqli_query($con, $query)) {
	 	echo '<script>alert("Image Inserted into Database")</script>';	 
	 }
}
?>