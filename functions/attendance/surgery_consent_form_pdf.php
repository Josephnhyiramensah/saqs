<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    $company_id = $_SESSION['company_id'];
    $attend_id = $_SESSION['attend_id'];
    $patient_id = $_SESSION['patient_id'];
    $surgery_id = $_SESSION['surgery_id'];
    $surgery = $_SESSION['surgery'];
    $surgery_list_id = $_SESSION['surgery_list_id'];
    $patient_name = $_SESSION['name'];
    
    $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
    $result_company = mysqli_query($con,$sql_company);
    $row_company = mysqli_fetch_array($result_company);

    $sql_consent = "SELECT * FROM consent_form WHERE surgery_list_id = '$surgery_list_id'";
    $result_consent = mysqli_query($con,$sql_consent);
    if(mysqli_num_rows($result_consent) > 0)
    {
        $row_consent = mysqli_fetch_array($result_consent);
        $relative = $row_consent['relative'];
        $doctor = $row_consent['doctor'];
        $language = $row_consent['language'];
    }
    else
    {
        $relative = '...........................................................................';
        $doctor = '.............................................................................';
        $language = '...........................................................................';
    };
    
    $sql_diagnosis_list = "SELECT * FROM diagnosis_list WHERE attend_id = '$attend_id'";
    $result_diagnosis_list = mysqli_query($con,$sql_diagnosis_list);
    //$image = $_SERVER['DOCUMENT_ROOT'] .'/img/aflia-head.jpg';
    class PDF extends FPDF
    {
        function Header()
        {
            //Put the watermark
            $image = $_SERVER['DOCUMENT_ROOT'] .'/img/logo.png';
            $this->Image($image,10,5,40,20);
            $this->SetFont('Arial','I',10);
        }
        function Footer()
        {
            // Go to 1.5 cm from bottom
            $this->SetY(-30);
            // Select Arial italic 8
            
            //$sign = $_SERVER['DOCUMENT_ROOT'] .'/img/ac_sign.png';
            //$this->Image($sign,80,250,50,30);
            $this->SetFont('Arial','I',10);
            $this->Cell(94,5,'Client/Relative Signature..............................................',0,0);
            $this->Cell(95,5,'Relation of Patient....................................................',0,1);
            $this->Cell(189,10,'',0,1);
            $this->Cell(189,5,'Doctor Signature......................................................',0,1);
        }
    }
    $pdf = new PDF('P','mm','A4');
    $pdf->AddPage(); 
    $pdf->SetFont('Arial','B',14);
    //Cell(width, height, text, border, end line, align)
    $pdf->Cell(209,5,$row_company['trading_name'],0,1,'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(209,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
    $pdf->Cell(209,5,$row_company['telephone'],0,1,'C');
    //$pdf->Cell(75,10,'LOGO',0,1,'C');
    $pdf->Cell(209,10,'',0,1);
    $pdf->SetFont('Arial','B',8);
    //$pdf->Image($image,5,5,199,30);
    $pdf->Cell(189,5,'',0,1,'C');
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(189,10,'PATIENT CONSENT FORM',0,1,'C');

    if (mysqli_num_rows($result_diagnosis_list) > 0)
    {
        $list_diagnosis = '';
        while($row_diagnosis_list = mysqli_fetch_array($result_diagnosis_list))
        {
            $diagnosis_id = $row_diagnosis_list['diagnosis_id'];
            $sql_diagnosis = "SELECT * FROM diagnosis WHERE diagnosis_id = '$diagnosis_id'";
            $result_diagnosis = mysqli_query($con,$sql_diagnosis);
            $row_diagnosis = mysqli_fetch_array($result_diagnosis);
            $diagnosis = $row_diagnosis['diagnosis'];
            $list_diagnosis .= $diagnosis;
        };
    }
    else
    {
        $list_diagnosis = '.......................................................................';
    };

    if (isset($surgery))
    {
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(189,10,'Patient Name:'.$patient_name,0,1);
        $pdf->Cell(189,10,'Diagnosis:'.$list_diagnosis,0,1);
        $pdf->Cell(189,10,'Surgery/Procedure:'.$surgery,0,1);
        $pdf->Cell(189,10,'',0,1,'C');
        $pdf->Cell(189,5,'Dear Client,',0,1,'L');
        $pdf->Cell(189,5,'',0,1);
        $pdf->MultiCell(189, 5, 'Our hospital is delight that you have chosen us for your medical treatment: we always attend to you with highest form of professionalism and respect. We would like to educate you on the outcomes, glad to provide any further information you require.', 0,1);
        $pdf->Cell(189,5,'',0,1);

        $pdf->Cell(189,5,'GENERAL COMPLICATIONS',0,1);
        $pdf->Cell(189,5,'',0,1);
        $pdf->Cell(189,5,'Vascular Injuries',0,1);
        $pdf->MultiCell(189,5,'Bleeding (Intra/Post-Operative): Despite intensive pre-operative Care, success rate in certain cases in minimal. In such cases there no ',0,1);
        
        $pdf->Cell(189,5,'',0,1);
        $pdf->Cell(189,5,'Risk of blood/blood products transfusion',0,1);
        $pdf->MultiCell(189,5,'guarantee that the surgical procedure used would Transfusion reaction contraction of infection yield the desired results.(HIV,HBV,HCV,etc)',0,1);
        
        $pdf->Cell(189,5,'',0,1);
        $pdf->Cell(189,5,'Nerve Injuries',0,1);
        $pdf->MultiCell(189,5,'You may; have the same complaints as prior to the Nerve Injuries operation, require several operations to treat your Sensory loss, weakness, paralysis, dystrophy complaint, have severe post-operative plan, recurrence of your complaint',0,1);
        
        $pdf->Cell(189,5,'',0,1);
        $pdf->Cell(189,5,'Infections',0,1);
        $pdf->MultiCell(189,5,'Local (wound infection, abscess, fistula) *Death can occur as well* Generalized (peritonitis, sepsis) Typical complications of the planned operation',0,1);
        
        $pdf->Cell(189,5,'',0,1);
        $pdf->Cell(189,5,'Wound healing complications',0,1);
        $pdf->Cell(189,5,'Delayed healing, hypertrophic scars, keloid Formation',0,1);

        $pdf->Cell(189,5,'',0,1);
        $pdf->Cell(189,5,'Thrombosis/embolism',0,1,'L');
        $pdf->Cell(189,5,'Damage to other organs',0,1,'L');

        $pdf->Cell(189,5,'',0,1);
        $pdf->MultiCell(189,5,'I '.$relative.' do hereby consent to the said operation. I confirm I have been adequately informed about the ricks and possible outcomes of the operation by '.$doctor.' in '.$language.' Language and confirm all my questions have been adequately answered.',0,1);
    };    
        
    $pdf->Output();
?>