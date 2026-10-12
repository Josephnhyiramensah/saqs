<?php
   require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
   include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
   include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');

   $company_id = $_SESSION['nhis_specialty_report_xml_company_id'];
   $start_date = $_SESSION['nhis_specialty_report_xml_start_date'];
   $end_date = $_SESSION['nhis_specialty_report_xml_end_date'];

   $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
   $result_company = mysqli_query($con,$sql_company);
   $row_company = mysqli_fetch_array($result_company);

   $query = "SELECT P.*, A.attend_id, A.patient_id, A.date_admit, A.date_disch, A.tos_id, A.age, A.outcome 
   FROM `attendance` AS A JOIN `payment_type` AS P ON A.attend_id = P.attend_id 
   WHERE P.ledger_id = 2 AND P.principal = 'Yes' AND A.date_admit BETWEEN '$start_date' AND '$end_date'";
   $result = mysqli_query($con,$query);

   $xml = new DOMDocument('1.0', 'utf-8');
   $xml->formatOutput = true;
   $claims = $xml->createElement("claims");
   $xml->appendChild($claims);

   if (!empty($result) && mysqli_num_rows($result) > 0)
   {
      while($row = mysqli_fetch_array($result))
      {
         $attend_id = $row['attend_id'];
         $patient_id = $row['patient_id'];
         $sql_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
         $result_patient = mysqli_query($con,$sql_patient);
         if(!empty($result_patient) && mysqli_num_rows($result_patient) > 0)
         {
            $row_patient = mysqli_fetch_array($result_patient);
            $gender_id = $row_patient['gender'];
         
            $query_gender = "SELECT * FROM `gender` WHERE `gender_id` = '$gender_id'";
            $query_run_gender = mysqli_query($con, $query_gender);
            if(!empty($query_run_gender) && mysqli_num_rows($query_run_gender) > 0)
            {
               $row_gender = mysqli_fetch_assoc($query_run_gender);
               if($row_gender['gender_id'] == 1){$gender = 'M';}
               else if($row_gender['gender_id'] == 2){$gender = 'F';};
            }
            else
            {
               $gender = 'Not Specified';
            };
         }
         else
         {
            $gender = 'Not Specified';
         };


         $tos_id = $row['tos_id'];
         if($tos_id == 1){$tos = 'OPD';}else if($tos_id == 2){$tos = 'IPD';}
         else if($tos_id == 3){$tos = 'DIA';}else if($tos_id == 4){$tos = 'PHC';};

         $depend = $row['dependant'];
         if($depend == 'Yes'){$dependant = 1;}else{$dependant = 0;};

         $tos_b = $row['type_of_serv_b'];
         if($tos_b == 'all_inclusive'){$type_of_serv_b = 0;}
         else if($tos_b == 'unbundled'){$type_of_serv_b = 1;};

         $pharm = $row['pharmacy'];
         if($pharm == 'pharmacy'){$pharmacy = 1;}else {$pharmacy = 0;};

         $toa = $row['type_of_attend'];
         if($toa == 'chronic_follow_up'){$type_of_attend = 'CFU';}
         else if($toa == 'emergency_acute_episode'){$type_of_attend = 'EAE';}
         else if($toa == 'antenatal'){$type_of_attend = 'ANC';}
         else if($toa == 'postnatal'){$type_of_attend = 'PNC';};

         $so = $row['outcome'];
         if($so == '0'){$outcome = 'DISC';}else if($so == 'discharged'){$outcome = 'DISC';}
         else if($so == 'died'){$outcome = 'DIED';}else if($so == 'discharged_against_medical_advice'){$outcome = 'DISC';}
         else if($so == 'referred_out'){$outcome = 'TFOT';}else if($so == 'transferred_out'){$outcome = 'TFOT';}
         else if($so == 'on_admission'){$outcome = 'DISC';}else if($so == 'absconded'){$outcome = 'ABSC';};

         if($tos_id == 2){$principal = $row['principal_gdrg'];}else{$principal = ' ';};

         $claim = $xml->createElement("claim");
            $claims->appendChild($claim);
               $claimID = $xml->createElement("claimID",$row['attend_id']);
               $claim->appendChild($claimID);
               $claimCheckCode = $xml->createElement("claimCheckCode",$row['code']);
               $claim->appendChild($claimCheckCode);
               $preAuthorizationCodes = $xml->createElement("preAuthorizationCodes",$row['member_no']);
               $claim->appendChild($preAuthorizationCodes);
               $physicianID = $xml->createElement("physicianID");
               $claim->appendChild($physicianID);
               $memberNo = $xml->createElement("memberNo",$row['member_no']);
               $claim->appendChild($memberNo);
               $cardSerialNo = $xml->createElement("cardSerialNo");
               $claim->appendChild($cardSerialNo);
               $surname = $xml->createElement("surname",$row_patient['lastName']);
               $claim->appendChild($surname);
               $otherNames = $xml->createElement("otherNames",$row_patient['firstName']);
               $claim->appendChild($otherNames);
               $dateOfBirth = $xml->createElement("dateOfBirth",$row_patient['DOB']);
               $claim->appendChild($dateOfBirth);
               $gender = $xml->createElement("gender",$gender);
               $claim->appendChild($gender);
               $hospitalRecNo = $xml->createElement("hospitalRecNo",$row_patient['folderNo']);
               $claim->appendChild($hospitalRecNo);
               $isDependant = $xml->createElement("isDependant",$dependant);
               $claim->appendChild($isDependant);
               $typeOfService = $xml->createElement("typeOfService",$tos);
               $claim->appendChild($typeOfService);
               $isUnbundled = $xml->createElement("isUnbundled",$type_of_serv_b);
               $claim->appendChild($isUnbundled);
               $includesPharmacy = $xml->createElement("includesPharmacy",$pharmacy);
               $claim->appendChild($includesPharmacy);
               $typeOfAttendance = $xml->createElement("typeOfAttendance",$type_of_attend);
               $claim->appendChild($typeOfAttendance);
               $serviceOutcome = $xml->createElement("serviceOutcome",$outcome);
               $claim->appendChild($serviceOutcome);
               $dateOfService = $xml->createElement("dateOfService",$row['date_admit']);
               $claim->appendChild($dateOfService);
               $dateOfService = $xml->createElement("dateOfService",$row['date_disch']);
               $claim->appendChild($dateOfService);
               $specialtyAttended = $xml->createElement("specialtyAttended",$row['specialty_1']);
               $claim->appendChild($specialtyAttended);
               
               $query_sl = "SELECT * FROM `surgery_list` WHERE `attend_id` = '$attend_id'";
               $query_run_sl = mysqli_query($con, $query_sl);
               if (mysqli_num_rows($query_run_sl) > 0)
               {
                  while($row_sl = mysqli_fetch_assoc($query_run_sl))
                  {
                     $surgery_id = $row_sl['surgery_id'];
                     $surgery_date = $row_sl['date'];
                     $query_surg = "SELECT * FROM `surgery` WHERE `surgery_id` = '$surgery_id'";
                     $query_run_surg = mysqli_query($con, $query_surg);
                     if(!empty($query_run_surg) && mysqli_num_rows($query_run_surg) > 0)
                     {
                        $row_surg = mysqli_fetch_assoc($query_run_surg);
                        $surg_icd_10 = $row_surg['icd_10'];
                        $surgery = $row_surg['surgery'];
                     }
                     else
                     {
                        $surg_icd_10 = 'Not Specified';
                        $surgery = 'Not Specified';
                     };

                     if($tos_id == 2)
                     {
                        $nhis_id = $row_surg['nhis_id'];
                     }
                     else
                     {
                        $nhis_id = $row['specialty'];
                     };
                     $query_nhis = "SELECT * FROM `nhis` WHERE `nhis_id` = '$nhis_id'";
                     $query_run_nhis = mysqli_query($con, $query_nhis);
                     if(!empty($query_run_nhis) && mysqli_num_rows($query_run_nhis) > 0)
                     {
                        $row_nhis = mysqli_fetch_assoc($query_run_nhis);

                        if($row['age'] < 12)
                        {
                           $gdrg = $row_nhis['gdrg_child'];
                        }
                        else
                        {
                           $gdrg = $row_nhis['gdrg_adult'];
                        };
                     }
                     else
                     {
                        $gdrg = 'Not Specified';
                     };
                     
                     $procedure = $xml->createElement("procedure");
                     $claim->appendChild($procedure);
                        $serviceDate = $xml->createElement("serviceDate", $surgery_date);
                        $procedure->appendChild($serviceDate);
                        $gdrgCode = $xml->createElement("gdrgCode", $gdrg);
                        $procedure->appendChild($gdrgCode);
                        $icd10 = $xml->createElement("icd10", $surg_icd_10);
                        $procedure->appendChild($icd10);
                        $diagnosis = $xml->createElement("diagnosis",$surgery);
                        $procedure->appendChild($diagnosis);
                  };
               };
               
               $query_dl = "SELECT * FROM `diagnosis_list` WHERE `attend_id` = '$attend_id'";
               $query_run_dl = mysqli_query($con, $query_dl);
               if (mysqli_num_rows($query_run_dl) > 0)
               {
                  while($row_dl = mysqli_fetch_assoc($query_run_dl))
                  {
                     $diagnosis_id = $row_dl['diagnosis_id'];
                     $query_diag = "SELECT * FROM `diagnosis` WHERE `diagnosis_id` = '$diagnosis_id'";
                     $query_run_diag = mysqli_query($con, $query_diag);
                     if(!empty($query_run_diag) && mysqli_num_rows($query_run_diag) > 0)
                     {
                        $row_diag = mysqli_fetch_assoc($query_run_diag);
                        $diag_icd_10 = $row_diag['icd_10'];
                        $diagnosis_item = $row_diag['diagnosis'];
                     }
                     else
                     {
                        $diag_icd_10 = 'Not Specified';
                        $diagnosis_item = 'Not Specified';
                     };

                     if($tos_id == 2)
                     {
                        $nhis_id = $row_diag['nhis_id'];
                     }
                     else
                     {
                        $nhis_id = $row['specialty'];
                     };
                     $query_nhis = "SELECT * FROM `nhis` WHERE `nhis_id` = '$nhis_id'";
                     $query_run_nhis = mysqli_query($con, $query_nhis);
                     if(!empty($query_run_nhis) && mysqli_num_rows($query_run_nhis) > 0)
                     {
                        $row_nhis = mysqli_fetch_assoc($query_run_nhis);
                        if($row['age'] < 12)
                        {
                           $gdrg = $row_nhis['gdrg_child'];
                        }
                        else
                        {
                           $gdrg = $row_nhis['gdrg_adult'];
                        };
                     }
                     else
                     {
                        $gdrg = 'Not Specified';
                     };
                     
                     $diagnosis = $xml->createElement("diagnosis");
                     $claim->appendChild($diagnosis);
                        $gdrgCode = $xml->createElement("gdrgCode", $gdrg);
                        $diagnosis->appendChild($gdrgCode);
                        $icd10 = $xml->createElement("icd10", $diag_icd_10);
                        $diagnosis->appendChild($icd10);
                        $diagnosis1 = $xml->createElement("diagnosis",$diagnosis_item);
                        $diagnosis->appendChild($diagnosis1);
                  };
               };
               
               $query_drl = "SELECT * FROM `drug_dispense_list` WHERE `attend_id` = '$attend_id'";
               $query_run_drl = mysqli_query($con, $query_drl);
               if (mysqli_num_rows($query_run_drl) > 0)
               {
                  while($row_drl = mysqli_fetch_assoc($query_run_drl))
                  {
                     $drug_id = $row_drl['drug_id'];
                     if(isset($row_drl['qty_nhis']))
                     {
                        $dispensed_qty = $row_drl['qty_nhis'];
                     }else{
                        $dispensed_qty = 'Not Specified';
                     };
                     if(isset($row_drl['date']))
                     {
                        $dispensed_date = $row_drl['date'];
                     }else{
                        $dispensed_date = 'Not Specified';
                     };
                     if(isset($row_drl['dosage']))
                     {
                        $dispensed_dosage = $row_drl['dosage'];
                     }else{
                        $dispensed_dosage = 'Not Specified';
                     };
                     $query_drug = "SELECT * FROM `drugs` WHERE `drug_id` = '$drug_id'";
                     $query_run_drug = mysqli_query($con, $query_drug);
                     if(!empty($query_run_drug) && mysqli_num_rows($query_run_drug) > 0)
                     {
                        $row_drug = mysqli_fetch_assoc($query_run_drug);
                        $nhis_id = $row_drug['nhis_id'];
                     }
                     else
                     {
                        $nhis_id = 0;
                     };

                     $query_drug_nhis = "SELECT * FROM `nhis` WHERE `nhis_id` = '$nhis_id'";
                     $query_run_drug_nhis = mysqli_query($con, $query_drug_nhis);
                     if(!empty($query_run_drug_nhis) && mysqli_num_rows($query_run_drug_nhis) > 0)
                     {
                        $row_drug_nhis = mysqli_fetch_assoc($query_run_drug_nhis);
                        if(isset($row_drug_nhis['gdrg']))
                        {
                           $drug_nhis_gdrg = $row_drug_nhis['gdrg'];
                        }else{
                           $drug_nhis_gdrg = 'Not Specified';
                        };
                        $medicine = $xml->createElement("medicine");
                        $claim->appendChild($medicine);
                           $medicineCode = $xml->createElement("medicineCode", $drug_nhis_gdrg);
                           $medicine->appendChild($medicineCode);
                           $dispensedQty = $xml->createElement("dispensedQty", $dispensed_qty);
                           $medicine->appendChild($dispensedQty);
                           $serviceDate = $xml->createElement("serviceDate", $dispensed_date);
                           $medicine->appendChild($serviceDate);
                           $prescription = $xml->createElement("prescription");
                           $medicine->appendChild($prescription);
                           $dose = $xml->createElement("dose",' ');
                           $prescription->appendChild($dose);
                           $frequency = $xml->createElement("frequency",' ');
                           $prescription->appendChild($frequency);
                           $duration = $xml->createElement("duration",' ');
                           $prescription->appendChild($duration);
                           $unparsed = $xml->createElement("unparsed", $dispensed_dosage);
                           $prescription->appendChild($unparsed);
                     };
                  };
               };
               $principalGDRG = $xml->createElement("principalGDRG",$principal);
               $claim->appendChild($principalGDRG);
               $referralInfo = $xml->createElement("referralInfo");
               $claim->appendChild($referralInfo);
               $claimCheckCode = $xml->createElement("claimCheckCode");
               $referralInfo->appendChild($claimCheckCode);
               $facilityID = $xml->createElement("facilityID");
               $referralInfo->appendChild($facilityID);
               $facilityName = $xml->createElement("facilityName");
               $referralInfo->appendChild($facilityName);
      };
   };

   echo "<xmp>".$xml->saveXML()."</xmp>";
   $xml->save("nhisclaims.xml");