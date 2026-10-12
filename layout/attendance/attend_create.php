<?php 
    require('includes/db.php');
    include('includes/auth.php');
?>
<?php
    $output = '';
	if(isset($_POST["query"]))
	{
	 $search = mysqli_real_escape_string($con, $_POST["query"]);
	 $query = "
	  SELECT * FROM patients 
	  WHERE firstName LIKE '%".$search."%'
	  OR lastName LIKE '%".$search."%' 
	  OR address LIKE '%".$search."%' 
	  OR telephone LIKE '%".$search."%' 
	  OR folderNo LIKE '%".$search."%'
	 ";
	}
	else
	{
	 $query = "
	  SELECT * FROM patients ORDER BY PatientID
	 ";
	}
	$result = mysqli_query($con, $query);
	if(mysqli_num_rows($result) > 0)
	{
	 $output .= '
	  <div class="table-responsive" id="patient-table">
    	<table class="table table-hover table-bordered table-sm" id="patientTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Patient ID</th>
                <th>Folder No</th>
                <th>Patient Name</th>
                <th>Date of Birth</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Add</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">
	 ';
	 while($row = mysqli_fetch_array($result))
	 {
	  $output .= '
		   <tr>
		        <td>'.$row["PatientID"].'</td>
		        <td>'.$row["folderNo"].'</td>
		        <td>'.$row["firstName"].' '. $row["lastName"].'</td>
		        <td>'.$row["DOB"].'</td>
		        <td>'.$row["age"].'</td>
		        <td>'.$row["gender"].'</td>
		        <td>
					<a href="#" data-id='.$row["PatientID"].'><i class="fa fa-address-card fa-sm"></i></a>
		        </td>
		        <td>
					<a href="#" data-id='.$row["PatientID"].'><i class="fa fa-edit fa-sm"></i></a>
		        </td>
		        <td>
					<a href="#" data-id='.$row["PatientID"].'><i class="fa fa-trash fa-sm"></i></a>
		        </td>
		    </tr>';
	 }
	 echo $output;
	}
	else
	{
	 echo 'Data Not Found';
	};
	'</tbody>
	</table>
</div>'
?>

        