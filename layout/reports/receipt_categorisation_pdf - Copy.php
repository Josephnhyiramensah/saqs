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
            $this->Cell(189,5,'Printed by: '.$user_name.' on '.date('Y-m-d h:m:sa'),0,1,'C');
        }
    }
	date_default_timezone_set("Africa/Accra");

    $pdf = new PDF('P','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    $pdf->Image($image,10,10,40,15);
    
    if(isset($_SESSION['receipt_categorisation_type']))
    {
        $company_id = $_SESSION['company_id'];
        $type = $_SESSION['receipt_categorisation_type'];
        $start_date = $_SESSION['receipt_categorisation_start_date'];
        $end_date = $_SESSION['receipt_categorisation_end_date'];
    
        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);

        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(189,5,$row_company['trading_name'],0,1,'C');
        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(189,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
        $pdf->Cell(189,5,$row_company['telephone'],0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(189,5,'',0,1,'C');
        $pdf->Cell(189,5,'RECEIPT CATEGORISATION',0,1,'C');
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(189,5,'From:'.$start_date.' To:'.$end_date,0,1,'C');
        $pdf->Cell(189,5,'',0,1,'C');

        if($type == 'Detail')
        {
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(74,5,'PATIENT NAME',1,0,'C');
            $pdf->Cell(20,5,'AGE',1,0,'C');
            $pdf->Cell(20,5,'SEX',1,0,'C');
            $pdf->Cell(25,5,'PHONE NO',1,0,'C');
            $pdf->Cell(50,5,'AMOUNT',1,1,'C');
        }
        else
        {
            $pdf->Cell(139,5,'PARTICULARS',1,0);
            $pdf->Cell(50,5,'AMOUNT',1,1,'C');
        };

        $total_amount = 0;
        $category_amount = 0;

        $sql_receipt_category = "SELECT * FROM receipt_category ORDER BY category ASC";
        $result_receipt_category = mysqli_query($con,$sql_receipt_category);
        if(!empty($result_receipt_category) && mysqli_num_rows($result_receipt_category))
        {
            while($row_receipt_category = mysqli_fetch_array($result_receipt_category))
            {
                $category_id = $row_receipt_category['receipt_category_id'];
                $sql_ds = "SELECT * FROM receipt WHERE category='$category_id' AND date BETWEEN '$start_date' AND '$end_date' ORDER BY date ASC";
                $result_ds = mysqli_query($con,$sql_ds);
                if(!empty($result_ds) && mysqli_num_rows($result_ds))
                {
                    $category_amount = 0;

                    if($type == 'Detail')
                    {
                        $pdf->SetFont('Arial','B',8);
                        $pdf->Cell(189,5,$row_receipt_category['category'],1,1);
                    };

                    while($row_ds = mysqli_fetch_array($result_ds))
                    {
                        $attend_id = $row_ds['attend_id'];
                        $patient_id = $row_ds['patient_id'];
                        $amount = $row_ds['amount'];
                        $total_amount = $total_amount + $amount;
                        $category_amount = $category_amount + $amount;
                        $amount_f = number_format($amount, 2, '.', ',');
                        
                        $query_patient = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                        $query_run_patient = mysqli_query($con, $query_patient);
                        $row_patient = mysqli_fetch_assoc($query_run_patient);
                        $gender_id = $row_patient['gender'];

                        $query_attend = "SELECT * FROM attendance WHERE attend_id='$attend_id'";
                        $query_run_attend = mysqli_query($con, $query_attend);
                        $row_attend = mysqli_fetch_assoc($query_run_attend);

                        $query_gender = "SELECT * FROM gender WHERE gender_id='$gender_id'";
                        $query_gender_run = mysqli_query($con, $query_gender);
                        $row_gender = mysqli_fetch_assoc($query_gender_run);

                        if($type == 'Detail')
                        {
                            $pdf->SetFont('Arial','I',8);
                            $pdf->Cell(74,5,$row_patient['firstName'].' '.$row_patient['lastName'],1,0);
                            $pdf->Cell(20,5,$row_attend['age'].'yrs',1,0,'C');
                            $pdf->Cell(20,5,$row_gender['gender'],1,0,'C');
                            $pdf->Cell(25,5,$row_patient['telephone'],1,0,'C');
                            $pdf->Cell(50,5,$amount_f,1,1,'R');
                        };
                    };
                    $category_amount_f = number_format($category_amount, 2, '.', ',');
                    $pdf->SetFont('Arial','B',8);
                    if($type == 'Detail')
                    {
                        $pdf->SetFont('Arial','B',8);
                        $pdf->Cell(139,5,'TOTAL '.$row_receipt_category['category'],1,0,'R');
                        $pdf->Cell(50,5,$category_amount_f,1,1,'R');
                    }
                    else
                    {
                        $pdf->SetFont('Arial','I',8);
                        $pdf->Cell(139,5,$row_receipt_category['category'],1,0);
                        $pdf->Cell(50,5,$category_amount_f,1,1,'R');
                    }
                };
            };

            $total_amount_f = number_format($total_amount, 2, '.', ',');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(139,5,'GRAND TOTAL',1,0,'R');
            $pdf->Cell(50,5,$total_amount_f,1,1,'R');
        };
        $pdf->Output();
    };
?>