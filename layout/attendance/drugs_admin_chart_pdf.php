<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    //include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');

	$company_id = $_SESSION['company_id'];
	$attend_id = $_SESSION['attend_id'];
	$patient_id = $_SESSION['patient_id'];

	$sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
	$result_company = mysqli_query($con,$sql_company);
	$row_company = mysqli_fetch_array($result_company);

	$sql_attend = "SELECT * FROM attendance WHERE attend_id = '$attend_id'";
	$result_attend = mysqli_query($con,$sql_attend);
	$row_attend = mysqli_fetch_array($result_attend);

	$query_patient = "SELECT * FROM patients WHERE patient_id ='$patient_id'";
	$query_run_patient = mysqli_query($con, $query_patient);
	$row_patient = mysqli_fetch_assoc($query_run_patient);

	$gender_id = $row_patient['gender'];
	$query_gender = "SELECT * FROM `gender` WHERE `gender_id` = '$gender_id'";
	$query_run_gender = mysqli_query($con, $query_gender);
	$row_gender = mysqli_fetch_assoc($query_run_gender);

	$tos_id = $row_attend['tos_id'];
	$query_tos = "SELECT * FROM `type_of_service` WHERE `tos_id` = '$tos_id'";
	$query_run_tos = mysqli_query($con, $query_tos);
	$row_tos = mysqli_fetch_assoc($query_run_tos);

	$clinic_id = $row_attend['clinic_id'];
	$sql_clinic="SELECT * FROM clinics WHERE  clinic_id='$clinic_id'";
	$result_clinic=mysqli_query($con,$sql_clinic);
	$row_clinic=mysqli_fetch_array($result_clinic);

	$logo = $_SERVER['DOCUMENT_ROOT'] .'/img/logo.png';
    class PDF extends FPDF
    {
        function Header()
        {
			//Put the watermark
            //$image = $_SERVER['DOCUMENT_ROOT'] .'/img/logo_watermark.png';
            //$this->Image($image,55,110,100,40);
        }
        function Footer()
        {
            // Go to 1.5 cm from bottom
            $this->SetY(-15);
            // Select Arial italic 8
            $this->SetFont('Arial','I',8);
            // Print centered page number
            //$this->Cell(0,10,'Page '.$this->PageNo().' - {pages}',0,0,'C');
        }
    }
    //A4 width: 219mm
    //default margin: 10mm each side
    //Writable horizontal: 219mm - (10mm*2) = 189mm
    $pdf = new PDF('L','mm','A4');
    $pdf->SetMargins(5,5,5);
    //$pdf->AliasNbPages('{pages}');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    //Cell(width, height, text, border, end line, align)
	$pdf->Image($logo,10,10,40,15);
    $pdf->Cell(289,5,$row_company['trading_name'],0,1,'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(289,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
    $pdf->Cell(289,5,$row_company['telephone'],0,1,'C');
    //$pdf->Cell(75,10,'LOGO',0,1,'C');
    $pdf->Cell(289,10,'',0,1);

    $pdf->SetFont('Arial','BU',12);
    $pdf->Cell(289,8,'Drug Administration Chart',0,1,'C');
    $pdf->Cell(289,10,'',0,1);

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(289,5,'Patient Name: '.$row_patient['firstName'].' '.$row_patient['lastName'],0,1);
    
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(79,5,'Folder No: '.$row_patient['folderNo'],0,0);
    $pdf->Cell(70,5,'Date of Birth: '.$row_patient['DOB'],0,0);
    $pdf->Cell(70,5,'Age: '.$row_attend['age'],0,0);
	$pdf->Cell(70,5,'Gender: '.$row_gender['gender'],0,1);

    $pdf->Cell(79,5,'Date of Admission: '.$row_attend['date_admit'],0,0);
    $pdf->Cell(70,5,'Date of Discharge: '.$row_attend['date_disch'],0,0);
    $pdf->Cell(70,5,'Type of Service: '.$row_tos['description'],0,0);
    $pdf->Cell(70,5,'Clinic: '.$row_clinic['clinic_desc'],0,1);
    $pdf->Cell(289,5,'',0,1);

    $pdf->SetFont('Arial','BU',8);
    $pdf->Cell(29,5,'Date',0,0,'C');
    $pdf->Cell(20,5,'Time',0,0,'C');
    $pdf->Cell(15,5,'Route',0,0,'C');
    $pdf->Cell(35,5,'Dosage',0,0,'C');
    $pdf->Cell(15,5,'Qty Admin',0,0,'C');
    $pdf->Cell(95,5,'Drug',0,0);
    $pdf->Cell(15,5,'Admin By',0,0,'C');
    $pdf->Cell(75,5,'Comment',0,1);
	
    $pdf->SetFont('Arial','B',10);
	//$pdf->SetLineWidth(0.1);
    $pdf->Cell(289,5,'STAT',0,1);

	$query = "
	SELECT * FROM drug_admin AS da 
	JOIN drug_list AS dl 
	ON da.drug_list_id=dl.drug_list_id
	WHERE da.attend_id='$attend_id' 
	AND dl.dosage LIKE '%st%' ORDER BY da.date DESC, da.time DESC";

$query_run = mysqli_query($con, $query);
if (mysqli_num_rows($query_run) > 0)
{
while($row_drug_admin_stat=mysqli_fetch_assoc($query_run))
{
	$drug_id = $row_drug_admin_stat['drug_id'];
	$drug_list_id = $row_drug_admin_stat['drug_list_id'];
	$route_id = $row_drug_admin_stat['route_id'];

	$query = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
	$query_run_drug = mysqli_query($con, $query);
	$row_drug=mysqli_fetch_assoc($query_run_drug);
	$drug = $row_drug['brand_name'];

	$query = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
	$query_run_drug_list = mysqli_query($con, $query);
	$row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
	$dosage = $row_drug_list['dosage'];

	$query_ddl = "SELECT drug_id FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
	$query_run_ddl = mysqli_query($con, $query_ddl);
	if(mysqli_num_rows($query_run_ddl) > 0)
	{
		$sup_drugs = '';
		while($row_ddl=mysqli_fetch_assoc($query_run_ddl))
		{
			$drug_id_ddl = $row_ddl['drug_id'];
			$query_drug_ddl = "SELECT * FROM drugs WHERE drug_id='$drug_id_ddl'";
			$query_run_drug_ddl = mysqli_query($con, $query_drug_ddl);
			$row_drug_ddl = mysqli_fetch_assoc($query_run_drug_ddl);
			$sup_drugs .= $row_drug_ddl['brand_name'];
		};
	}
	else
	{
		$sup_drugs = 'Not dispensed';
	};
	$query = "SELECT * FROM drug_route WHERE route_id='$route_id'";
	$query_run_route = mysqli_query($con, $query);
	$row_route=mysqli_fetch_assoc($query_run_route);
	$route = $row_route['route'];

    $pdf->SetFont('Arial','',8);
    $pdf->Cell(29,5,$row_drug_admin_stat['date'],0,0,'C');
    $pdf->Cell(20,5,$row_drug_admin_stat['time'],0,0,'C');
    $pdf->Cell(15,5,$route,0,0,'C');
    $pdf->Cell(35,5,$dosage,0,0,'C');
    $pdf->Cell(15,5,$row_drug_admin_stat['qty_admin'],0,0,'C');
    $pdf->Cell(95,5,$drug.':'.$sup_drugs,0,0);
    $pdf->Cell(15,5,$row_drug_admin_stat['initials'],0,0);
    $pdf->Cell(75,5,$row_drug_admin_stat['comment'],0,1);
}
}
else
{
	$pdf->Cell(289,5,'',0,1);
};

//$pdf->Cell(289,5,'','B',0,1);
$pdf->SetFont('Arial','B',10);
//$pdf->SetLineWidth(0.1);
$pdf->Cell(289,5,'INFUSIONS',0,1);

$query = "
	SELECT * FROM drug_admin AS da 
	JOIN drugs AS ds 
	ON da.drug_id=ds.drug_id
	WHERE da.attend_id='$attend_id' 
	AND ds.category=3 ORDER BY ds.brand_name ASC, da.date DESC, da.time DESC";

$query_run = mysqli_query($con, $query);
if (mysqli_num_rows($query_run) > 0)
{
while($row_drug_admin_stat=mysqli_fetch_assoc($query_run))
{
	$drug_id = $row_drug_admin_stat['drug_id'];
	$drug_list_id = $row_drug_admin_stat['drug_list_id'];
	$route_id = $row_drug_admin_stat['route_id'];

	$query = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
	$query_run_drug = mysqli_query($con, $query);
	$row_drug=mysqli_fetch_assoc($query_run_drug);
	$drug = $row_drug['brand_name'];

	$query = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
	$query_run_drug_list = mysqli_query($con, $query);
	$row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
	$dosage = $row_drug_list['dosage'];

	$query_ddl = "SELECT drug_id FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
	$query_run_ddl = mysqli_query($con, $query_ddl);
	if(mysqli_num_rows($query_run_ddl) > 0)
	{
		$sup_drugs = '';
		while($row_ddl=mysqli_fetch_assoc($query_run_ddl))
		{
			$drug_id_ddl = $row_ddl['drug_id'];
			$query_drug_ddl = "SELECT * FROM drugs WHERE drug_id='$drug_id_ddl'";
			$query_run_drug_ddl = mysqli_query($con, $query_drug_ddl);
			$row_drug_ddl = mysqli_fetch_assoc($query_run_drug_ddl);
			$sup_drugs .= $row_drug_ddl['brand_name'];
		};
	}
	else
	{
		$sup_drugs = 'Not dispensed';
	};

	$query = "SELECT * FROM drug_route WHERE route_id='$route_id'";
	$query_run_route = mysqli_query($con, $query);
	$row_route=mysqli_fetch_assoc($query_run_route);
	$route = $row_route['route'];

    $pdf->SetFont('Arial','',8);
    $pdf->Cell(29,5,$row_drug_admin_stat['date'],0,0,'C');
    $pdf->Cell(20,5,$row_drug_admin_stat['time'],0,0,'C');
    $pdf->Cell(15,5,$route,0,0,'C');
    $pdf->Cell(35,5,$dosage,0,0,'C');
    $pdf->Cell(15,5,$row_drug_admin_stat['qty_admin'],0,0,'C');
    $pdf->Cell(95,5,$drug.':'.$sup_drugs,0,0);
    $pdf->Cell(15,5,$row_drug_admin_stat['initials'],0,0);
    $pdf->Cell(75,5,$row_drug_admin_stat['comment'],0,1);
}
}else
{
	$pdf->Cell(289,5,'',0,1);
};

//$pdf->Cell(289,5,'','B',0,1);
$pdf->SetFont('Arial','B',10);
//$pdf->SetLineWidth(0.1);
$pdf->Cell(289,5,'OTHERS',0,1);

$query = "
	SELECT * FROM drug_admin AS da 
	JOIN drugs AS ds 
	ON da.drug_id=ds.drug_id
	WHERE da.attend_id='$attend_id' 
	AND ds.category<>3 ORDER BY ds.brand_name ASC, da.date DESC, da.time DESC";

$query_run = mysqli_query($con, $query);
if (mysqli_num_rows($query_run) > 0)
{
while($row_drug_admin_stat=mysqli_fetch_assoc($query_run))
{
	$drug_id = $row_drug_admin_stat['drug_id'];
	$drug_list_id = $row_drug_admin_stat['drug_list_id'];
	$route_id = $row_drug_admin_stat['route_id'];

	$query = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
	$query_run_drug = mysqli_query($con, $query);
	$row_drug=mysqli_fetch_assoc($query_run_drug);
	$drug = $row_drug['brand_name'];

	$query = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
	$query_run_drug_list = mysqli_query($con, $query);
	$row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
	$dosage = $row_drug_list['dosage'];

	$query_ddl = "SELECT drug_id FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
	$query_run_ddl = mysqli_query($con, $query_ddl);
	if(mysqli_num_rows($query_run_ddl) > 0)
	{
		$sup_drugs = '';
		while($row_ddl=mysqli_fetch_assoc($query_run_ddl))
		{
			$drug_id_ddl = $row_ddl['drug_id'];
			$query_drug_ddl = "SELECT * FROM drugs WHERE drug_id='$drug_id_ddl'";
			$query_run_drug_ddl = mysqli_query($con, $query_drug_ddl);
			$row_drug_ddl = mysqli_fetch_assoc($query_run_drug_ddl);
			$sup_drugs .= $row_drug_ddl['brand_name'];
		};
	}
	else
	{
		$sup_drugs = 'Not dispensed';
	};

	$query = "SELECT * FROM drug_route WHERE route_id='$route_id'";
	$query_run_route = mysqli_query($con, $query);
	$row_route=mysqli_fetch_assoc($query_run_route);
	$route = $row_route['route'];

    $pdf->SetFont('Arial','',8);
    $pdf->Cell(29,5,$row_drug_admin_stat['date'],0,0,'C');
    $pdf->Cell(20,5,$row_drug_admin_stat['time'],0,0,'C');
    $pdf->Cell(15,5,$route,0,0,'C');
    $pdf->Cell(35,5,$dosage,0,0,'C');
    $pdf->Cell(15,5,$row_drug_admin_stat['qty_admin'],0,0,'C');
    $pdf->Cell(95,5,$drug.':'.$sup_drugs,0,0);
    $pdf->Cell(15,5,$row_drug_admin_stat['initials'],0,0);
    $pdf->Cell(75,5,$row_drug_admin_stat['comment'],0,1);
}
}
else
{
	$pdf->Cell(289,5,'',0,1);
};
$pdf->Cell(289,15,'',0,1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(289,5,'.......................................................................',0,1,'C');
$pdf->Cell(289,10,'',0,1);
$pdf->Cell(289,5,'MANAGER',0,1,'C');
$pdf->Output();
?>