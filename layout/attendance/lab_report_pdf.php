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
    $pdf = new PDF('P','mm','A4');
    $pdf->SetMargins(5,5,5);
    //$pdf->AliasNbPages('{pages}');
    $pdf->AddPage();
    $pdf->SetFont('Arial','BU',14);
    //Cell(width, height, text, border, end line, align)

	$pdf->Image($logo,10,5,25,20);
    $pdf->Cell(209,5,'',0,1,'C');


    $pdf->Cell(209,5,$row_company['trading_name'],0,1,'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(209,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
    $pdf->Cell(209,5,$row_company['telephone'],0,1,'C');
    //$pdf->Cell(75,10,'LOGO',0,1,'C');
    $pdf->Cell(209,10,'',0,1);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(200,5,'LABORATORY REPORT',0,1,'C');
    $pdf->Cell(209,5,'',0,1);

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(200,5,'Patient Name: '.$row_patient['firstName'].' '.$row_patient['lastName'],0,1);
    
    $pdf->SetFont('Arial','',8);
	$pdf->Cell(50,5,'Folder No: '.$row_patient['folderNo'],0,0);
    $pdf->Cell(50,5,'Date of Birth: '.$row_patient['DOB'],0,0);
	$interval = date_diff(date_create(), date_create($row_patient['DOB']));
    $pdf->Cell(50,5,'Age:'.$interval->format("%Y Year, %M Months, %d Days"),0,0);
	$pdf->Cell(50,5,'Gender: '.$row_gender['gender'],0,1);

    $pdf->Cell(50,5,'Date: '.$row_attend['date_admit'],0,0);
    $pdf->Cell(50,5,'Telephone: '.$row_patient['telephone'],0,0);
    $pdf->Cell(50,5,'Type of Service: '.$row_tos['description'],0,0);
    //$pdf->Cell(50,5,'Clinic: '.$row_clinic['clinic_desc'],0,1);
    $pdf->Cell(200,10,'',0,1);

    $pdf->SetFont('Arial','BU',10);
    $pdf->Cell(40,5,'Parameter',0,0);
    $pdf->Cell(50,5,'Result',0,0,'C');
    $pdf->Cell(35,5,'',0,0,'C');
    //$pdf->Cell(15,5,'L Range',0,0,'C');
    //$pdf->Cell(15,5,'H Range',0,0,'C');
    $pdf->Cell(15,5,'Reference Range',0,0,'C');
    $pdf->Cell(55,5,'',0,1,'C');

	$query = "SELECT * FROM lab_list WHERE attend_id='$attend_id' AND `print_status`='Yes'";
	$query_run = mysqli_query($con, $query);
	if (mysqli_num_rows($query_run) > 0)
	{
		while($row_lab_list = mysqli_fetch_assoc($query_run))
		{
			$lab_id = $row_lab_list['lab_id'];
			$lab_list_id = $row_lab_list['lab_list_id'];
			$query = "SELECT * FROM lab_param_list WHERE lab_list_id='$lab_list_id'";
			$query_run_lab_param_list = mysqli_query($con, $query);
			if (mysqli_num_rows($query_run_lab_param_list) > 0)
			{
				$query = "SELECT * FROM lab WHERE lab_id='$lab_id'";
				$query_run_lab = mysqli_query($con, $query);
				$row_lab=mysqli_fetch_assoc($query_run_lab);
				$pdf->SetFont('Arial','B',9);
				$pdf->SetLineWidth(0.1);
				$pdf->Cell(200,5,$row_lab['lab'],'B',1);
					
				while($row_lab_param_list = mysqli_fetch_assoc($query_run_lab_param_list))
				{
					$lab_param_id = $row_lab_param_list['lab_param_id'];
					$query = "SELECT * FROM lab_param WHERE lab_param_id='$lab_param_id'";
					$query_run_lab_param = mysqli_query($con, $query);
					$row_lab_param=mysqli_fetch_assoc($query_run_lab_param);
					
					$pdf->SetFont('Arial','I',10);
					$pdf->Cell(40,8,$row_lab_param['lab_param'],0,0);
					$pdf->Cell(50,8,$row_lab_param_list['result'],0,0,'C');
					$pdf->Cell(35,8,$row_lab_param_list['flag'],0,0,'C');
					//$pdf->Cell(15,8,$row_lab_param_list['low_range'],0,0,'C');
					//$pdf->Cell(15,8,$row_lab_param_list['high_range'],0,0,'C');
					$pdf->Cell(15,8,$row_lab_param_list['low_range'].' - '.$row_lab_param_list['high_range'].' '.$row_lab_param['unit'],0,0);
					
					if($row_lab_param_list['comment']=='' && $row_lab_param['comment']=='')
					{
						$pdf->Cell(55,8,$row_lab_param['comment'],0,1);
					}
					else if($row_lab_param_list['comment'] !='' && $row_lab_param['comment']=='')
					{
						$pdf->Cell(55,8,$row_lab_param_list['comment'],0,1,'C');
					}
					else if($row_lab_param_list['comment']=='' && $row_lab_param['comment'] !='')
					{
						$pdf->Cell(55,8,$row_lab_param['comment'],0,1);
					}
					else if($row_lab_param_list['comment'] !='' && $row_lab_param['comment'] !='')
					{
						$pdf->Cell(55,8,$row_lab_param_list['comment'],0,1,'C');
					};
				};
				$pdf->Cell(200,5,'',0,1);
			};
		};
	};
$pdf->Cell(200,15,'',0,1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(200,5,'.......................................................................',0,1,'C');
$pdf->Cell(200,10,'',0,1);
$pdf->Cell(200,5,'MEDICAL LAB. TECHNOLOGIST I/C',0,1,'C');
/*$pdf->Cell(209,5,'',0,1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(209,5,'========================================================================================================',0,1,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(209,5,'LIMITATIONS OF THE PROCEDURE',0,1,'C');
$pdf->SetFont('Arial','I',10);
$pdf->Cell(209,5,'As with all diagnostic tests, a definite clinical diagnosis should not be based on the results of a ',0,1,'C');
$pdf->Cell(209,5,'single test, but should only be made by the physician after all clinical and laboratory findings',0,1,'C');
$pdf->Cell(209,5,'have been evaluated.',0,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(209,5,'========================================================================================================',0,1,'C');*/

$pdf->Output();