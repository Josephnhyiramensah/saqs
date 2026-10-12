<?php 
include($_SERVER['DOCUMENT_ROOT'] .'/includes/functions.php');

global $con;
$filename = "Patient_list_" . date('Y-m-d') . ".csv"; 
$delimiter = ","; 
$f = fopen('php://memory', 'w'); 
$fields = array('firstName', 'lastName', 'folderNo', 'gender', 'DOB', 'age', 'email', 'marital', 
'address', 'city', 'house_no', 'location', 'telephone', 'relname', 'rellocation', 'reltelephone', 
'membership_no', 'scheme_name', 'scheme_id');
fputcsv($f, $fields, $delimiter); 

$result = $con->query("SELECT * FROM patients ORDER BY firstName ASC"); 

if($result->num_rows > 0) 
{ 
    while ($row = $result->fetch_assoc()) 
    { 
        $lineData = array($row['firstName'], $row['lastName'], $row['folderNo'], $row['gender'], $row['DOB'], 
        $row['age'], $row['email'], $row['marital'], $row['address'], $row['city'], $row['house_no'], 
        $row['location'], $row['telephone'], $row['relname'], $row['rellocation'], $row['reltelephone'], 
        $row['nhismemberno'], $row['scheme_name'], $row['scheme_id']);
        fputcsv($f, $lineData, $delimiter);
    };
} 

fseek($f, 0); 
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
fpassthru($f); 
exit();
?>
