<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    global $con;
    $patient_id = $_SESSION['patient_id'];
    $query_patient = "SELECT * FROM patients WHERE patient_id='$patient_id'";
    $query_run_patient = mysqli_query($con, $query_patient);
    $row_patient=mysqli_fetch_assoc($query_run_patient);

    $gender = $row_patient['gender'];
    $query_gender = "SELECT * FROM gender WHERE gender_id='$gender'";
    $query_gender_run = mysqli_query($con, $query_gender);
    $row_gender=mysqli_fetch_assoc($query_gender_run);

    class PDF extends FPDF
    {
        function Footer()
        {
            // Go to 1.5 cm from bottom
            $this->SetY(-15);
            // Select Arial italic 8
            $this->SetFont('Arial','I',8);
            // Print centered page number
            $this->Cell(0,10,'Page '.$this->PageNo().' - {pages}',0,0,'C');
        }
    }
    //A4 width: 219mm
    //default margin: 10mm each side
    //Writable horizontal: 219mm - (10mm*2) = 189mm
    $pdf = new PDF('L','mm','A4');
    $pdf->AliasNbPages('{pages}');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    //Cell(width, height, text, border, end line, align)
    $pdf->Cell(275,8,'PATIENT FOLDER',1,1,'C');

    $pdf->SetFont('Arial','',8);
    $pdf->Cell(137.5,5,'Patient Name: '.$row_patient['firstName']." ".$row_patient['lastName'],1,0);
    $pdf->Cell(137.5,5,'Date Of Birth: '.$row_patient['DOB'],1,1);

    $pdf->Cell(137.5,5,'Folder No:'.$row_patient['folderNo'],1,0);
    $pdf->Cell(137.5,5,'Address: '.$row_patient['address'],1,1);

    $pdf->Cell(137.5,5,'Gender: '.$row_gender['gender'],1,0);
    $pdf->Cell(137.5,5,'Telephone: '.$row_patient['telephone'],1,1);

    $pdf->Cell(137.5,5,'Blood Group: '.$row_patient['BloodGroup'],1,0);
    $pdf->Cell(137.5,5,'Emergency Contact: '.$row_patient['relname']." - ".$row_patient['reltelephone'],1,1);

    $query = "SELECT * FROM attendance WHERE patient_id ='$patient_id' ORDER BY date_admit DESC";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        while($row_attend = mysqli_fetch_assoc($query_run))
        {
            $date_admit = $row_attend['date_admit'];
            $date_disch = $row_attend['date_disch'];
            $attend_id = $row_attend['attend_id'];
            $tos_id = $row_attend['tos_id'];
            $nhis_led_id = $row_attend['nhis_led_id'];
            $prvt_led_id = $row_attend['prvt_led_id'];
            if($nhis_led_id > 0 && $prvt_led_id > 0 )
                {
                    $sponsor_id = $nhis_led_id;
                }
            else if($nhis_led_id > 0 && $prvt_led_id <= 0 )
                {
                    $sponsor_id = $nhis_led_id;
                }
            else if($nhis_led_id <= 0 && $prvt_led_id > 0 )
                {
                    $sponsor_id = $prvt_led_id;
                }
            else if($nhis_led_id <= 0 && $prvt_led_id <= 0 )
                {
                    $sponsor_id = 1;
                }
            $query_led = "SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
            $query_run_led = mysqli_query($con, $query_led);
            $row_led=mysqli_fetch_assoc($query_run_led);

            $query_tos = "SELECT * FROM type_of_service WHERE tos_id='$tos_id'";
            $query_run_tos = mysqli_query($con, $query_tos);
            $row_tos=mysqli_fetch_assoc($query_run_tos);

            $pdf->SetFillColor(100,100,100);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(55,5,'Admission Date:'.$date_admit,1,0,'C',true);
            $pdf->Cell(55,5,'Discharge Date:'.$date_disch,1,0,'C',true);
            $pdf->Cell(55,5,'Age:'.$row_attend['age'],1,0,'C',true);
            $pdf->Cell(55,5,'Type Of Service:'.$row_tos['description'],1,0,'C',true);
            $pdf->Cell(55,5,'Sponsor:'.$row_led['ledger_desc'],1,1,'C',true);
            //VITALS
                $query_vitals = "SELECT * FROM vitals WHERE attend_id='$attend_id' AND patient_id ='$patient_id' ORDER BY date DESC";
                $query_run_vitals = mysqli_query($con, $query_vitals);
                if (mysqli_num_rows($query_run_vitals) > 0) 
                {
                    $pdf->SetFillColor(255,253,226);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(275,5,'VITALS',1,1,'C',true);

                    $pdf->SetFillColor(255,255,255);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(20,5,'Date:',1,0,'C');
                    $pdf->Cell(15,5,'Temp:',1,0,'C');
                    $pdf->Cell(25,5,'BP:',1,0,'C');
                    $pdf->Cell(20,5,'Pulse:',1,0,'C');
                    $pdf->Cell(20,5,'R.Rate:',1,0,'C');
                    $pdf->Cell(20,5,'Weight:',1,0,'C');
                    $pdf->Cell(20,5,'Height:',1,0,'C');
                    $pdf->Cell(20,5,'Oxygen:',1,0,'C');
                    $pdf->Cell(20,5,'H.Circ.:',1,0,'C');
                    $pdf->Cell(20,5,'A.Circ.:',1,0,'C');
                    $pdf->Cell(75,5,'comment:',1,1,'C');
                    while($row_vitals = mysqli_fetch_assoc($query_run_vitals))
                    {
                        $pdf->Cell(20,5,$row_vitals['date'],1,0,'C');
                        $pdf->Cell(15,5,$row_vitals['temp'],1,0,'C');
                        $pdf->Cell(25,5,$row_vitals['bp_systolic'].'/'.$row_vitals['bp_diastolic'],1,0,'C');
                        $pdf->Cell(20,5,$row_vitals['pulse'],1,0,'C');
                        $pdf->Cell(20,5,$row_vitals['resp_rate'],1,0,'C');
                        $pdf->Cell(20,5,$row_vitals['weight'],1,0,'C');
                        $pdf->Cell(20,5,$row_vitals['height'],1,0,'C');
                        $pdf->Cell(20,5,$row_vitals['oxygen_sat'],1,0,'C');
                        $pdf->Cell(20,5,$row_vitals['circ_hip'],1,0,'C');
                        $pdf->Cell(20,5,$row_vitals['circ_abdo'],1,0,'C');
                        $pdf->Cell(75,5,$row_vitals['comment'],1,1,'C');
                    }
                }
            //HISTORY
                $query_history = "SELECT * FROM history WHERE attend_id='$attend_id' AND patient_id ='$patient_id' ORDER BY date DESC";
                $query_run_history = mysqli_query($con, $query_history);
                if (mysqli_num_rows($query_run_history) > 0)
                {
                    $pdf->SetFillColor(255,253,226);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(275,5,'HISTORY',1,1,'C',true);

                    $pdf->SetFillColor(255,255,255);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(20,5,'Date:',1,0,'C');
                    $pdf->Cell(255,5,'History:',1,1);
                                    
                    while($row_history = mysqli_fetch_assoc($query_run_history))
                    {
                        $history = $row_history['history'];
                        $cellwidth = 255;
                        $cellheight = 5;
                        if ($pdf->GetStringWidth($history) < $cellwidth) 
                        {
                            $line = 1;
                        }
                        else
                        {
                            $textlength = strlen($history);
                            $errmargin = 10;
                            $startchar = 0;
                            $maxchar = 0;
                            $textarray = array();
                            $tmpstring = "";
                            while ($startchar < $textlength) 
                            {
                                while ($pdf->GetStringWidth($tmpstring) < ($cellwidth - $errmargin) && ($startchar + $maxchar) < $textlength) 
                                {
                                    $maxchar++;
                                    $tmpstring = substr($history, $startchar, $maxchar);
                                }
                                $startchar = $startchar + $maxchar;
                                array_push($textarray, $tmpstring);
                                $maxchar = 0;
                                $tmpstring = "";
                            }
                            $line = count($textarray);
                        }
                        $pdf->Cell(20,($line * $cellheight),$row_history['date'],1,0);
                        $xPos = $pdf->GetX();
                        $yPos = $pdf->GetY();
                        $pdf->MultiCell($cellwidth,$cellheight,$history,1);
                        //$pdf->SetXY($xPos + $cellwidth, $yPos);
                    }
                }
            //DIAGNOSIS
                $query_diagnosis_list = "SELECT * FROM diagnosis_list WHERE attend_id='$attend_id' AND patient_id ='$patient_id' ORDER BY date DESC";
                $query_run_diagnosis_list = mysqli_query($con, $query_diagnosis_list);
                if (mysqli_num_rows($query_run_diagnosis_list) > 0)
                {
                    $pdf->SetFillColor(255,253,226);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(275,5,'DIAGNOSIS',1,1,'C',true);

                    $pdf->SetFillColor(255,255,255);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(20,5,'Date',1,0,'C');
                    $pdf->Cell(50,5,'Diagnosis',1,0,'C');
                    $pdf->Cell(20,5,'ICD 10',1,0,'C');
                    $pdf->Cell(30,5,'G-DRG',1,0,'C');
                    $pdf->Cell(155,5,'Comment',1,1);
                                while($row_diagnosis_list = mysqli_fetch_assoc($query_run_diagnosis_list))
                                {
                                    $diagnosis_id = $row_diagnosis_list['diagnosis_id'];
                                    $query_diag = "SELECT * FROM diagnosis WHERE diagnosis_id='$diagnosis_id'";
                                    $query_run_diag = mysqli_query($con, $query_diag);
                                    $row_diag=mysqli_fetch_assoc($query_run_diag);

                                    $pdf->Cell(20,5,$row_diagnosis_list['date'],1,0,'C');
                                    $pdf->Cell(50,5,$row_diag['diagnosis'],1,0);
                                    $pdf->Cell(20,5,$row_diag['icd_10'],1,0,'C');
                                    $pdf->Cell(30,5,$row_diag['g_drg'],1,0,'C');
                                    $pdf->Cell(155,5,$row_diagnosis_list['comment'],1,1);
                                }
                }
            //LABORATORY TEST
                $query_lab_list = "SELECT * FROM lab_list WHERE attend_id='$attend_id'";
                $query_run_lab_list = mysqli_query($con, $query_lab_list);
                if (mysqli_num_rows($query_run_lab_list) > 0)
                {
                    $pdf->SetFillColor(255,253,226);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(275,5,'LABORATORY TEST',1,1,'C',true);

                    $pdf->SetFillColor(255,255,255);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(40,5,'Parameter',1,0,'C');
                    $pdf->Cell(40,5,'Result',1,0,'C');
                    $pdf->Cell(20,5,'Lower Range',1,0,'C');
                    $pdf->Cell(20,5,'Higher Range',1,0,'C');
                    $pdf->Cell(20,5,'Unit',1,0,'C');
                    $pdf->Cell(50,5,'Flag',1,0,'C');
                    $pdf->Cell(85,5,'Comment',1,1);
                    while($row_lab_list=mysqli_fetch_assoc($query_run_lab_list))
                    {
                        $lab_id = $row_lab_list['lab_id'];
                        $lab_list_id = $row_lab_list['lab_list_id'];
                        $query_lab_param_list = "SELECT * FROM lab_param_list WHERE lab_list_id='$lab_list_id'";
                        $query_run_lab_param_list = mysqli_query($con, $query_lab_param_list);
                        if (mysqli_num_rows($query_run_lab_param_list) > 0)
                        {
                            $query_lab = "SELECT * FROM lab WHERE lab_id='$lab_id'";
                            $query_run_lab = mysqli_query($con, $query_lab);
                            $row_lab=mysqli_fetch_assoc($query_run_lab);
                            $pdf->SetFillColor(238,235,235);
                            $pdf->SetTextColor(10,10,10);
                            $pdf->Cell(275,5,$row_lab['lab'],1,1,'L',true);
                                
                            while($row_lab_param_list=mysqli_fetch_assoc($query_run_lab_param_list))
                            {
                                $lab_param_id = $row_lab_param_list['lab_param_id'];
                                $querylab_param = "SELECT * FROM lab_param WHERE lab_param_id='$lab_param_id'";
                                $query_run_lab_param = mysqli_query($con, $querylab_param);
                                $row_lab_param=mysqli_fetch_assoc($query_run_lab_param);
                                $pdf->SetFillColor(255,255,255);
                                $pdf->SetTextColor(10,10,10);
                                $pdf->Cell(40,5,$row_lab_param['lab_param'],1,0);
                                $pdf->Cell(40,5,$row_lab_param_list['result'],1,0,'C');
                                $pdf->Cell(20,5,$row_lab_param_list['low_range'],1,0,'C');
                                $pdf->Cell(20,5,$row_lab_param_list['high_range'],1,0,'C');
                                $pdf->Cell(20,5,$row_lab_param['unit'],1,0,'C');
                                $pdf->Cell(50,5,$row_lab_param_list['flag'],1,0,'C');
                                $pdf->Cell(85,5,$row_lab_param_list['comment'],1,1);
                            };
                        };
                    };
                };
            //RADIOLOGY
                $query_radiolist = "SELECT * FROM radio_list WHERE attend_id = '$attend_id'";
                $query_run_radiolist = mysqli_query($con, $query_radiolist);
                if (mysqli_num_rows($query_run_radiolist) > 0)
                {
                    $pdf->SetFillColor(255,253,226);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(275,5,'RADIOLOGY',1,1,'C',true);

                    $pdf->SetFillColor(255,255,255);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(40,5,'Parameter',1,0,'C');
                    $pdf->Cell(140,5,'Result',1,0,'C');
                    $pdf->Cell(95,5,'Comment',1,1);
                    while($row_radio_list = mysqli_fetch_assoc($query_run_radiolist))
                    {
                        $radio_id = $row_radio_list['radio_id'];
                        $radio_list_id = $row_radio_list['radio_list_id'];
                        $queryradio_param_list = "SELECT * FROM radio_param_list WHERE radio_list_id = '$radio_list_id'";
                        $query_run_radio_param_list = mysqli_query($con, $queryradio_param_list);
                        if (mysqli_num_rows($query_run_radio_param_list) > 0)
                        {
                            $query_radio = "SELECT * FROM radiology WHERE radio_id = '$radio_id'";
                            $query_run_radio = mysqli_query($con, $query_radio);
                            $row_radio = mysqli_fetch_assoc($query_run_radio);
                            $pdf->SetFillColor(238,235,235);
                            $pdf->SetTextColor(10,10,10);
                            $pdf->Cell(275,5,$row_radio['radiology'],1,1,'L',true);
                                
                            while($row_radio_param_list = mysqli_fetch_assoc($query_run_radio_param_list))
                            {
                                $radio_param_id = $row_radio_param_list['radio_param_id'];
                                $query_radio_param = "SELECT * FROM radio_param WHERE radio_param_id = '$radio_param_id'";
                                $query_run_radio_param = mysqli_query($con, $query_radio_param);
                                $row_radio_param = mysqli_fetch_assoc($query_run_radio_param);
                                $pdf->SetFillColor(255,255,255);
                                $pdf->SetTextColor(10,10,10);
                                $pdf->Cell(40,5,$row_radio_param['radio_param'],1,0,'C');
                                $pdf->Cell(140,5,$row_radio_param_list['result'],1,0,'C');
                                $pdf->Cell(95,5,$row_radio_param_list['comment'],1,1);
                            };
                        };
                    };
                };
            //PRESCRIPTION
                $query_presc = "SELECT * FROM drug_list WHERE attend_id='$attend_id' ORDER BY date DESC";
                $result_presc = mysqli_query($con,$query_presc);
                if (mysqli_num_rows($result_presc) > 0)
                {
                    $pdf->SetFillColor(255,253,226);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(275,5,'PRESCRIPTION',1,1,'C',true);

                    $pdf->SetFillColor(255,255,255);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(20,5,'Date',1,0,'C');
                    $pdf->Cell(140,5,'Drug',1,0,'C');
                    $pdf->Cell(30,5,'Qty Presc.',1,0,'C');
                    $pdf->Cell(30,5,'Qty Disp.',1,0,'C');
                    $pdf->Cell(55,5,'Dosage',1,1);

                    while($row_presc=mysqli_fetch_assoc($result_presc))
                    {
                        $drug_id = $row_presc['drug_id'];
                        $query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
                        $query_run_drug = mysqli_query($con, $query_drug);
                        $row_drug=mysqli_fetch_assoc($query_run_drug);

                        $drug_list_id = $row_presc['drug_list_id'];
                        $query_ddisp = "SELECT SUM(amt_cash) AS amt_cash, SUM(amt_prvt) AS amt_prvt, SUM(amt_nhis) AS amt_nhis, SUM(qty) AS qty FROM  drug_dispense_list WHERE drug_presc_id='$drug_id' AND drug_list_id='$drug_list_id'";
                        $query_run_ddisp = mysqli_query($con, $query_ddisp);
                        $row_ddisp=mysqli_fetch_assoc($query_run_ddisp);
                        $pdf->SetFillColor(255,255,255);
                        $pdf->SetTextColor(10,10,10);
                        $pdf->Cell(20,5,$row_presc['date'],1,0,'C');
                        $pdf->Cell(140,5,$row_drug['brand_name'],1,0);
                        $pdf->Cell(30,5,$row_presc['qty_presc'],1,0,'C');
                        $pdf->Cell(30,5,$row_ddisp['qty'],1,0,'C');
                        $pdf->Cell(55,5,$row_presc['dosage'],1,1);
                    }
                };
            //DRUG ADMINISTRATION
                $query_drug_admin = "SELECT * FROM drug_admin WHERE attend_id='$attend_id'";
                $query_run_drug_admin = mysqli_query($con, $query_drug_admin);
                if (mysqli_num_rows($query_run_drug_admin) > 0)
                {
                    $pdf->SetFillColor(255,253,226);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(275,5,'DRUG ADMINISTRATION',1,1,'C',true);

                    $pdf->SetFillColor(255,255,255);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(20,5,'Date',1,0,'C');
                    $pdf->Cell(20,5,'Time',1,0,'C');
                    $pdf->Cell(30,5,'Route',1,0,'C');
                    $pdf->Cell(50,5,'Dosage',1,0,'C');
                    $pdf->Cell(20,5,'Qty Admin',1,0,'C');
                    $pdf->Cell(95,5,'Drug',1,0,'C');
                    $pdf->Cell(40,5,'Admin By',1,1);

                    $pdf->SetFillColor(238,235,235);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(275,5,'STAT',1,1,'L',true);
                    $query_drug_admin_stat = "
                        SELECT * FROM drug_admin AS da 
                        JOIN drug_list AS dl 
                        ON da.drug_list_id=dl.drug_list_id
                        WHERE da.attend_id='$attend_id' 
                        AND dl.dosage LIKE '%st%' ORDER BY da.date DESC, da.time DESC";

                    $query_run_drug_admin_stat = mysqli_query($con, $query_drug_admin_stat);
                    if (mysqli_num_rows($query_run_drug_admin_stat) > 0)
                    {
                        while($row_drug_admin_stat=mysqli_fetch_assoc($query_run_drug_admin_stat))
                        {
                            $drug_id = $row_drug_admin_stat['drug_id'];
                            $drug_list_id = $row_drug_admin_stat['drug_list_id'];
                            $route_id = $row_drug_admin_stat['route_id'];

                            $query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
                            $query_run_drug = mysqli_query($con, $query_drug);
                            $row_drug=mysqli_fetch_assoc($query_run_drug);
                            $drug = $row_drug['brand_name'];

                            $query_drug_list = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
                            $query_run_drug_list = mysqli_query($con, $query_drug_list);
                            $row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
                            $dosage = $row_drug_list['dosage'];

                            $query_route = "SELECT * FROM drug_route WHERE route_id='$route_id'";
                            $query_run_route = mysqli_query($con, $query_route);
                            $row_route=mysqli_fetch_assoc($query_run_route);
                            $route = $row_route['route'];

                            $pdf->SetFillColor(255,255,255);
                            $pdf->SetTextColor(10,10,10);
                            $pdf->Cell(20,5,$row_drug_admin_stat['date'],1,0,'C');
                            $pdf->Cell(20,5,$row_drug_admin_stat['time'],1,0,'C');
                            $pdf->Cell(30,5,$route,1,0,'C');
                            $pdf->Cell(50,5,$dosage,1,0,'C');
                            $pdf->Cell(20,5,$row_drug_admin_stat['qty_admin'],1,0,'C');
                            $pdf->Cell(95,5,$drug,1,0,'C');
                            $pdf->Cell(40,5,$row_drug_admin_stat['initials'],1,1);
                        }
                    }
                    $pdf->SetFillColor(238,235,235);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(275,5,'INFUSIONS',1,1,'L',true);
                    $query_drug_admin_infusion = "
                            SELECT * FROM drug_admin AS da 
                            JOIN drugs AS ds 
                            ON da.drug_id=ds.drug_id
                            WHERE da.attend_id='$attend_id' 
                            AND ds.category=3 ORDER BY ds.brand_name ASC, da.date DESC, da.time DESC";

                    $query_run_drug_admin_infusion = mysqli_query($con, $query_drug_admin_infusion);
                    if (mysqli_num_rows($query_run_drug_admin_infusion) > 0)
                    {
                        while($row_drug_admin_infusion=mysqli_fetch_assoc($query_run_drug_admin_infusion))
                        {
                            $drug_id = $row_drug_admin_infusion['drug_id'];
                            $drug_list_id = $row_drug_admin_infusion['drug_list_id'];
                            $route_id = $row_drug_admin_infusion['route_id'];

                            $query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
                            $query_run_drug = mysqli_query($con, $query_drug);
                            $row_drug=mysqli_fetch_assoc($query_run_drug);
                            $drug = $row_drug['brand_name'];

                            $query_drug_list = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
                            $query_run_drug_list = mysqli_query($con, $query_drug_list);
                            $row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
                            $dosage = $row_drug_list['dosage'];

                            $query_route = "SELECT * FROM drug_route WHERE route_id='$route_id'";
                            $query_run_route = mysqli_query($con, $query_route);
                            $row_route=mysqli_fetch_assoc($query_run_route);
                            $route = $row_route['route'];

                            $pdf->SetFillColor(255,255,255);
                            $pdf->SetTextColor(10,10,10);
                            $pdf->Cell(20,5,$row_drug_admin_infusion['date'],1,0,'C');
                            $pdf->Cell(20,5,$row_drug_admin_infusion['time'],1,0,'C');
                            $pdf->Cell(30,5,$route,1,0,'C');
                            $pdf->Cell(50,5,$dosage,1,0,'C');
                            $pdf->Cell(20,5,$row_drug_admin_infusion['qty_admin'],1,0,'C');
                            $pdf->Cell(95,5,$drug,1,0,'C');
                            $pdf->Cell(40,5,$row_drug_admin_infusion['initials'],1,1);
                        }
                    }
                    $pdf->SetFillColor(238,235,235);
                    $pdf->SetTextColor(10,10,10);
                    $pdf->Cell(275,5,'OTHERS',1,1,'L',true);
                    $query_drug_admin_other = "
                            SELECT * FROM drug_admin AS da 
                            JOIN drugs AS ds 
                            ON da.drug_id=ds.drug_id
                            WHERE da.attend_id='$attend_id' 
                            AND ds.category<>3 ORDER BY ds.brand_name ASC, da.date DESC, da.time DESC";

                    $query_run_drug_admin_other = mysqli_query($con, $query_drug_admin_other);
                    if (mysqli_num_rows($query_run_drug_admin_other) > 0)
                    {
                        while($row_drug_admin_other=mysqli_fetch_assoc($query_run_drug_admin_other))
                        {
                            $drug_id = $row_drug_admin_other['drug_id'];
                            $drug_list_id = $row_drug_admin_other['drug_list_id'];
                            $route_id = $row_drug_admin_other['route_id'];

                            $query_drug = "SELECT * FROM drugs WHERE drug_id='$drug_id'";
                            $query_run_drug = mysqli_query($con, $query_drug);
                            $row_drug=mysqli_fetch_assoc($query_run_drug);
                            $drug = $row_drug['brand_name'];

                            $query_drug_list = "SELECT * FROM drug_list WHERE drug_list_id='$drug_list_id'";
                            $query_run_drug_list = mysqli_query($con, $query_drug_list);
                            $row_drug_list=mysqli_fetch_assoc($query_run_drug_list);
                            $dosage = $row_drug_list['dosage'];

                            $query_route = "SELECT * FROM drug_route WHERE route_id='$route_id'";
                            $query_run_route = mysqli_query($con, $query_route);
                            $row_route=mysqli_fetch_assoc($query_run_route);
                            $route = $row_route['route'];

                            $pdf->SetFillColor(255,255,255);
                            $pdf->SetTextColor(10,10,10);
                            $pdf->Cell(20,5,$row_drug_admin_other['date'],1,0,'C');
                            $pdf->Cell(20,5,$row_drug_admin_other['time'],1,0,'C');
                            $pdf->Cell(30,5,$route,1,0,'C');
                            $pdf->Cell(50,5,$dosage,1,0,'C');
                            $pdf->Cell(20,5,$row_drug_admin_other['qty_admin'],1,0,'C');
                            $pdf->Cell(95,5,$drug,1,0,'C');
                            $pdf->Cell(40,5,$row_drug_admin_other['initials'],1,1);
                        }
                    }
                };
            /*//SURGERIES
            //MANAGEMENT PLAN
            //NURSES NOTES
            //ANTENATAL
            //DELIVERY
            //POSTNATAL*/
        };
    };


    $pdf->Output();
?>