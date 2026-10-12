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

   $query = "SELECT P.*, A.attend_id, A.patient_id, A.date_admit, A.date_disch, A.tos_id, A.age FROM `attendance` AS A 
   JOIN `payment_type` AS P ON A.attend_id = P.attend_id WHERE P.ledger_id = 2 AND A.date_admit BETWEEN '$start_date' AND 
   '$end_date'";
   $result = mysqli_query($con,$query);

   $xml = new DOMDocument('1.0', 'utf-8');
   $xml->formatOutput = true;
   $claims = $xml->createElement("claims");
   $xml->appendChild($claims);

   if (mysqli_num_rows($result) > 0)
   {
      while($row = mysqli_fetch_array($result))
      {
         $attend_id = $row['attend_id'];
         $patient_id = $row['patient_id'];
         $sql_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
         $result_patient = mysqli_query($con,$sql_patient);
         $row_patient = mysqli_fetch_array($result_patient);

         $gender_id = $row_patient['gender'];
         $query_gender = "SELECT * FROM `gender` WHERE `gender_id` = '$gender_id'";
         $query_run_gender = mysqli_query($con, $query_gender);
         $row_gender = mysqli_fetch_assoc($query_run_gender);
         if($row_gender['gender_id'] == 1)
         {
            $gender = 'M';
         }
         else if($row_gender['gender_id'] == 2)
         {
            $gender = 'F';
         };

         $tos_id = $row['tos_id'];
         if($tos_id == 1)
         {
            $tos = 'OPD';
         }
         else if($tos_id == 2)
         {
            $tos = 'IPD';
         }
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
               $isDependant = $xml->createElement("isDependant",$row['dependant']);
               $claim->appendChild($isDependant);
               $typeOfService = $xml->createElement("typeOfService",$tos);
               $claim->appendChild($typeOfService);
               $isUnbundled = $xml->createElement("isUnbundled",'$tos');
               $claim->appendChild($isUnbundled);
               $includesPharmacy = $xml->createElement("includesPharmacy",'$tos');
               $claim->appendChild($includesPharmacy);
               $typeOfAttendance = $xml->createElement("typeOfAttendance",'$tos');
               $claim->appendChild($typeOfAttendance);
               $serviceOutcome = $xml->createElement("serviceOutcome",'$tos');
               $claim->appendChild($serviceOutcome);
               $dateOfService = $xml->createElement("dateOfService",'$tos');
               $claim->appendChild($dateOfService);
               $dateOfService = $xml->createElement("dateOfService",'$tos');
               $claim->appendChild($dateOfService);
               $specialtyAttended = $xml->createElement("specialtyAttended",'$tos');
               $claim->appendChild($specialtyAttended);
               
               $query_sl = "SELECT * FROM `surgery_list` WHERE `attend_id` = '$attend_id'";
               $query_run_sl = mysqli_query($con, $query_sl);
               if (mysqli_num_rows($query_run_sl) > 0)
               {
                  while($row_sl = mysqli_fetch_assoc($query_run_sl))
                  {
                     $surgery_id = $row_sl['surgery_id'];
                     $query_surg = "SELECT * FROM `surgery` WHERE `surgery_id` = '$surgery_id'";
                     $query_run_surg = mysqli_query($con, $query_surg);
                     $row_surg = mysqli_fetch_assoc($query_run_surg);

                     $nhis_id = $row_surg['nhis_id'];
                     $query_nhis = "SELECT * FROM `nhis` WHERE `nhis_id` = '$nhis_id'";
                     $query_run_nhis = mysqli_query($con, $query_nhis);
                     $row_nhis = mysqli_fetch_assoc($query_run_nhis);
                     if($row['age'] < 12)
                     {
                        $gdrg = $row_nhis['gdrg_child'];
                     }
                     else
                     {
                        $gdrg = $row_nhis['gdrg_adult'];
                     };
                     
                     $procedure = $xml->createElement("procedure");
                     $claim->appendChild($procedure);
                        $serviceDate = $xml->createElement("serviceDate", $row_sl['date']);
                        $procedure->appendChild($serviceDate);
                        $gdrgCode = $xml->createElement("gdrgCode", $gdrg);
                        $procedure->appendChild($gdrgCode);
                        $icd10 = $xml->createElement("icd10", $row_surg['icd_10']);
                        $procedure->appendChild($icd10);
                        $diagnosis = $xml->createElement("diagnosis",$row_surg['surgery']);
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
                     $row_diag = mysqli_fetch_assoc($query_run_diag);

                     $nhis_id = $row_surg['nhis_id'];
                     $query_nhis = "SELECT * FROM `nhis` WHERE `nhis_id` = '$nhis_id'";
                     $query_run_nhis = mysqli_query($con, $query_nhis);
                     $row_nhis = mysqli_fetch_assoc($query_run_nhis);
                     if($row['age'] < 12)
                     {
                        $gdrg = $row_nhis['gdrg_child'];
                     }
                     else
                     {
                        $gdrg = $row_nhis['gdrg_adult'];
                     };
                     
                     $diagnosis = $xml->createElement("diagnosis");
                     $claim->appendChild($diagnosis);
                        $gdrgCode = $xml->createElement("gdrgCode", $gdrg);
                        $diagnosis->appendChild($gdrgCode);
                        $icd10 = $xml->createElement("icd10", $row_diag['icd_10']);
                        $diagnosis->appendChild($icd10);
                        $diagnosis1 = $xml->createElement("diagnosis",$row_diag['diagnosis']);
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
                     $query_drug = "SELECT * FROM `drugs` WHERE `drug_id` = '$drug_id'";
                     $query_run_drug = mysqli_query($con, $query_drug);
                     $row_drug = mysqli_fetch_assoc($query_run_drug);

                     $medicine = $xml->createElement("medicine");
                     $claim->appendChild($medicine);
                        $medicineCode = $xml->createElement("medicineCode", $row_drug['code']);
                        $medicine->appendChild($medicineCode);
                        $dispensedQty = $xml->createElement("dispensedQty");
                        $medicine->appendChild($dispensedQty);
                        $serviceDate = $xml->createElement("serviceDate");
                        $medicine->appendChild($serviceDate);
                        $prescription = $xml->createElement("prescription");
                        $serviceDate->appendChild($prescription);
                        $dose = $xml->createElement("dose");
                        $prescription->appendChild($dose);
                        $frequency = $xml->createElement("frequency");
                        $prescription->appendChild($frequency);
                        $duration = $xml->createElement("duration");
                        $prescription->appendChild($duration);
                        $unparsed = $xml->createElement("unparsed");
                        $prescription->appendChild($unparsed);
                  };
               };
               $principalGDRG = $xml->createElement("principalGDRG");
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