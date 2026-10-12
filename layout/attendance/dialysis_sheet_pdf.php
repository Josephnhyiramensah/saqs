<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    
    $image = $_SERVER['DOCUMENT_ROOT'] .'/img/logo.png';

    class PDF extends FPDF
    {
        function Header()
        {
            //Put the watermark
            //$image = $_SERVER['DOCUMENT_ROOT'] .'/img/aflia watermark.png';
            //$this->Image($image,55,110,100,95);
        }
        function Footer()
        {
            // Go to 1.5 cm from bottom
            $this->SetY(-15);
            // Select Arial italic 8
            
            /*$sign = $_SERVER['DOCUMENT_ROOT'] .'/img/ac_sign.png';
            $this->Image($sign,80,250,50,30);*/
            global $con;
            if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0)
            {
                $user_id = $_SESSION['user_id'];
                $sql_users = "SELECT * FROM users WHERE id = '$user_id'";
                $result_users = mysqli_query($con,$sql_users);
                if(!empty($result_users) && mysqli_num_rows($result_users) > 0)
                {
                    $row_users = mysqli_fetch_array($result_users);
                    $user_name = $row_users['first_name'].' '.$row_users['last_name'];
                }
                else 
                {
                    $user_name = 'No User';
                };
            }
            else 
            {
                $user_name = 'No User';
            };
            $this->SetFont('Arial','I',8);
            $this->Cell(273,5,'Printed by: '.$user_name.' on '.date('Y-m-d h:m:sa'),0,1,'C');
        }
    }
	date_default_timezone_set("Africa/Accra");

    $pdf = new PDF('L','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    $pdf->Image($image,10,10,40,15);
    
    if(isset($_SESSION['dialysis_sheet_id']))
    {
        $company_id = $_SESSION['company_id'];
        $dialysis_sheet_id = $_SESSION['dialysis_sheet_id'];
    
        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);

        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(274,5,$row_company['trading_name'],0,1,'C');
        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(274,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
        $pdf->Cell(274,5,$row_company['telephone'],0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(274,5,'',0,1,'C');
        $pdf->Cell(274,5,'DIALYSIS SHEET',0,1,'C');
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(274,5,'',0,1,'C');

        $sql_ds = "SELECT * FROM dialysis_sheet WHERE dialysis_sheet_id = '$dialysis_sheet_id'";
        $result_ds = mysqli_query($con,$sql_ds);
        if(!empty($result_ds) && mysqli_num_rows($result_ds))
        {
            $row_ds = mysqli_fetch_array($result_ds);
            $attend_id = $row_ds['attend_id'];
            $patient_id = $row_ds['patient_id'];
            
            $query_patient = "SELECT * FROM patients WHERE patient_id='$patient_id'";
            $query_run_patient = mysqli_query($con, $query_patient);
            $row_patient = mysqli_fetch_assoc($query_run_patient);
            $gender_id = $row_patient['gender'];

            $query_attend = "SELECT * FROM attendance WHERE attend_id='$attend_id'";
            $query_run_attend = mysqli_query($con, $query_attend);
            $row_attend = mysqli_fetch_assoc($query_run_attend);

            $query_gender = "SELECT * FROM gender WHERE gender_id='$gender_id'";
            $query_gender_run = mysqli_query($con, $query_gender);
            $row_gender=mysqli_fetch_assoc($query_gender_run);

            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(70,5,'Patient Name: '.$row_patient['firstName'].''.$row_patient['lastName'],0,0);
            $pdf->Cell(40,5,'Age: '.$row_attend['age'].'yrs',0,0);
            $pdf->Cell(40,5,'Sex: '.$row_gender['gender'],0,0);
            $pdf->Cell(40,5,'Date of Birth: '.$row_patient['DOB'],0,0);
            $pdf->Cell(40,5,'Date of HD: '.$row_ds['date'],0,0);
            $pdf->Cell(44,5,'Renal Unit Unit I/P#:',0,1);

            $pdf->Cell(70,5,'TREATMENT PARAMETERS',1,0,'C');
            $pdf->Cell(68,5,'WEIGHT AND GOAL',1,0,'C');
            $pdf->Cell(78,5,'OBSERVATION',1,0,'C');
            $pdf->Cell(58,5,'ACCESS',1,1,'C');

            $pdf->SetFont('Arial','I',7);
            $pdf->Cell(40,5,'Treatment Time in hours: ',1,0);
            $pdf->Cell(30,5,$row_ds['treatment_time'],1,0,'C');
            $pdf->Cell(40,5,'Dry Weight: ',1,0);
            $pdf->Cell(28,5,$row_ds['dry_weight'],1,0,'C');
            $pdf->Cell(30,5,'BVP',1,0);
            $pdf->Cell(48,5,$row_ds['bvp'],1,0,'C');
            if($row_ds['access'] == 'Fistula')
            {
                $pdf->Cell(30,5,'Vascular Access: '.$row_ds['access'],1,0);
                $pdf->Cell(28,5,'Needle Size: '.$row_ds['needle_size'],1,1);
            }
            else
            {
                $pdf->Cell(58,5,'Vascular Access: '.$row_ds['access'],1,1);
            };

            $pdf->Cell(40,5,'Type Dialysis: ',1,0);
            $pdf->Cell(30,5,$row_ds['type_of_dialysis'],1,0,'C');
            $pdf->Cell(40,5,'Previous Weight: ',1,0);
            $pdf->Cell(28,5,$row_ds['previous_weight'],1,0,'C');
            $pdf->Cell(30,5,'Creat',1,0);
            $pdf->Cell(48,5,$row_ds['creat'],1,0,'C');
            $pdf->Cell(58,5,'',1,1);
            
            $pdf->Cell(40,5,'Machine No: ',1,0);
            $pdf->Cell(30,5,$row_ds['machine_no'],1,0,'C');
            $pdf->Cell(40,5,'Weight Gain: ',1,0);
            $pdf->Cell(28,5,$row_ds['weight_gain'],1,0,'C');
            $pdf->Cell(30,5,'Urea',1,0);
            $pdf->Cell(48,5,$row_ds['urea'],1,0,'C');
            $pdf->Cell(30,5,'Exact Time Commence: ',1,0);
            $pdf->Cell(28,5,$row_ds['exact_time_commenced'],1,1);
            
            $pdf->Cell(40,5,'Heparin Bolus Dose: ',1,0);
            $pdf->Cell(30,5,$row_ds['heparin_bolus_dose'],1,0,'C');
            $pdf->Cell(40,5,'Heparin Maint Dose: ',1,0);
            $pdf->Cell(28,5,$row_ds['heparin_mtce_dose'],1,0,'C');
            $pdf->Cell(30,5,'Hb',1,0);
            $pdf->Cell(48,5,$row_ds['hb'],1,0,'C');
            $pdf->Cell(30,5,'Exact Time Completed: ',1,0);
            $pdf->Cell(28,5,$row_ds['exact_time_completed'],1,1);
            
            $pdf->MultiCell(274,5,'Nursing/Medical Orders/Action: '.$row_ds['medical_order'],1,1);
            $pdf->MultiCell(274,5,'Assessment (Pre): '.$row_ds['assessment_pre'],1,1);
            $pdf->MultiCell(274,5,'Assessment (Post): '.$row_ds['assessment_post'],1,1);


            $pdf->SetFont('Arial','B',6);
            $pdf->Cell(20,5,'Time',1,0,'C');
            $pdf->Cell(25,5,'BP',1,0,'C');
            $pdf->Cell(20,5,'Pulse',1,0,'C');
            $pdf->Cell(20,5,'Blood Flow',1,0,'C');
            $pdf->Cell(25,5,'Arterial Pressure',1,0,'C');
            $pdf->Cell(25,5,'Venous Pressure',1,0,'C');
            $pdf->Cell(20,5,'TMP',1,0,'C');
            $pdf->Cell(25,5,'UFR',1,0,'C');
            $pdf->Cell(20,5,'Volume',1,0,'C');
            $pdf->Cell(25,5,'Heparin Rate',1,0,'C');
            $pdf->Cell(49,5,'Comment',1,1,'C');
        
            $query_list = "SELECT * FROM dialysis_sheet_list WHERE dialysis_sheet_id = '$dialysis_sheet_id'";
            $query_run_list = mysqli_query($con, $query_list);
            if(!empty($query_run_list) && mysqli_num_rows($query_run_list) > 0 )
            {
                $pdf->SetFont('Arial','B',7);
                while($row_list = mysqli_fetch_array($query_run_list))
                {
                    $pdf->SetFont('Arial','I',7);
                    $pdf->Cell(20,5,$row_list['time'],1,0,'C');
                    $pdf->Cell(25,5,$row_list['bp'],1,0,'C');
                    $pdf->Cell(20,5,$row_list['pulse'],1,0,'C');
                    $pdf->Cell(20,5,$row_list['blood_flow'],1,0,'C');
                    $pdf->Cell(25,5,$row_list['arterial_pressure'],1,0,'C');
                    $pdf->Cell(25,5,$row_list['venous_pressure'],1,0,'C');
                    $pdf->Cell(20,5,$row_list['tmp'],1,0,'C');
                    $pdf->Cell(25,5,$row_list['ufr'],1,0,'C');
                    $pdf->Cell(20,5,$row_list['volume'],1,0,'C');
                    $pdf->Cell(25,5,$row_list['heparin_rate'],1,0,'C');
                    $pdf->Cell(49,5,$row_list['comment'],1,1,'C');
                };
                
                $pdf->SetFont('Arial','B',8);
                $pdf->Cell(137,10,'Connecting Nurse:'.$row_ds['connecting_nurse'],1,0);
                $pdf->Cell(137,10,'Disconnecting Nurse:'.$row_ds['disconnecting_nurse'],1,1);
            };
        };
        $pdf->Output();
    };
?>