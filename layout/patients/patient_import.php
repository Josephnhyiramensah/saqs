<?php 
include($_SERVER['DOCUMENT_ROOT'] .'/includes/functions.php');
//patient_import();

if (isset($_POST['patient_import_post_btn'])) 
{
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 
    'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 
    'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 
    'text/plain');

    if (!empty($_FILES['patient_import_file']['name']) && in_array($_FILES['patient_import_file']['type'], $csvMimes)) 
    {
        if (is_uploaded_file($_FILES['patient_import_file']['tmp_name'])) 
        {
            $csvFile = fopen($_FILES['patient_import_file']['tmp_name'], 'r');
            fgetcsv($csvFile);
    
            $company_id = $_SESSION['company_id'];
            $branch_id = $_SESSION['branch_id'];

            $csvFile = fopen($_FILES['patient_import_file']['tmp_name'], 'r');
            fgetcsv($csvFile);
            while (($line = fgetcsv($csvFile)) !== false) 
            {
                $firstName = $line[0];
                $lastName = $line[1];
                $folderNo = $line[2];
                $gender = $line[3];
                $DOB = $line[4];
                if($line[5] > 0){$age = $line[5];}else{$age = age($DOB);};
                $email = $line[6];
                $marital = $line[7];
                $address = $line[8];
                $city = $line[9];
                $house_no = $line[10];
                $location = $line[11];
                $telephone = $line[12];
                $relname = $line[13];
                $rellocation = $line[14];
                $reltelephone = $line[15];
                $membership_no = $line[16];
                $scheme_name = $line[17];
                $scheme_id = $line[18];

                $query = "INSERT INTO `patients`(`company_id`,`branch_id`, `firstName`, `lastName`, `folderNo`, 
                `gender`, `DOB`, `age`, `email`, `marital`, `address`, `city`, `house_no`, `location`, 
                `telephone`, `relname`, `rellocation`, `reltelephone`, `nhismemberno`, `scheme_name`, `scheme_id`,
                `country`, `nationality`) 
                VALUES ('$company_id','$branch_id','$firstName','$lastName','$folderNo','$gender','$DOB',
                '$age','$email','$marital','$address','$city','$house_no','$location','$telephone','$relname',
                '$rellocation','$reltelephone','$membership_no','$scheme_name','$scheme_id', 87,'Ghanaian')";
                mysqli_query($con, $query);
            };
            fclose($csvFile);
            $qstring = '?status=succ';
        } 
        else 
        {
            $qstring = '?status=err';
        };
    } 
    else 
    {
        $qstring = '?status=invalid_file';
    };
};

header("Location: /layout/patients/patient_list.php".$qstring);