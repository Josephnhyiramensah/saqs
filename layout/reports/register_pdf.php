<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf184/fpdf.php');
    
    $image = $_SERVER['DOCUMENT_ROOT'] .'/img/company_logo.png';

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
    $pdf->Image($image,10,10,25,25);
    
    if(isset($_SESSION['receipt_categorisation_type']))
    {
        $company_id = $_SESSION['company_id'];
        $cashier = $_SESSION['receipt_categorisation_cashier'];
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

        if($type == 'Super_Summary')
        {
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(110,5,'CATEGORY',1,0);
            $pdf->Cell(29,5,'NO OF PATIENTS',1,0,'C');
            $pdf->Cell(50,5,'AMOUNT',1,1,'C');
            $total_amount = 0;
            $category_amount = 0;

            $sql_receipt_category = "SELECT * FROM receipt_category ORDER BY category ASC";
            $result_receipt_category = mysqli_query($con,$sql_receipt_category);
            if(!empty($result_receipt_category) && mysqli_num_rows($result_receipt_category))
            {
                while($row_receipt_category = mysqli_fetch_array($result_receipt_category))
                {
                    $x=0;
                    $category_amount = 0;
                    $category_id = $row_receipt_category['receipt_category_id'];
                    $category = $row_receipt_category['category'];
                    $sql_ds = "SELECT * FROM receipt_category_list WHERE receipt_cat_id='$category_id' AND date 
                    BETWEEN '$start_date' AND '$end_date' ORDER BY date ASC";
                    $result_ds = mysqli_query($con,$sql_ds);
                    if(!empty($result_ds) && mysqli_num_rows($result_ds) > 0)
                    {
                        while($row_ds = mysqli_fetch_array($result_ds))
                        {
                            $x++;
                            $amount = $row_ds['amount'];
                            $total_amount = $total_amount + $amount;
                            $category_amount = $category_amount + $amount;
                        };
                    }
                    else
                    {
                        $amount = 0;
                    };
                    if($category_amount > 0)
                    {
                        $category_amount_f = number_format($category_amount, 2, '.', ',');
                        $pdf->SetFont('Arial','I',8);
                        $pdf->Cell(110,5,$category,1,0);
                        $pdf->Cell(29,5,$x,1,0,'C');
                        $pdf->Cell(50,5,$category_amount_f,1,1,'R');
                    };
                };
            };
            $total_amount_f = number_format($total_amount, 2, '.', ',');
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(110,5,'TOTAL',1,0,'C');
            $pdf->Cell(29,5,'',1,0,'C');
            $pdf->Cell(50,5,$total_amount_f,1,1,'R');
        }
        else
        {
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
            if($cashier == 'ALL')
            {
                $sql_cashier = "SELECT * FROM receipt GROUP BY created_by ORDER BY created_by ASC";
            }
            else
            {
                $sql_cashier = "SELECT * FROM receipt WHERE created_by = '$cashier' GROUP BY created_by ORDER BY created_by ASC";
            };
            $result_cashier = mysqli_query($con,$sql_cashier);
            if(!empty($result_cashier) && mysqli_num_rows($result_cashier) > 0)
            {
                while($row_cashier = mysqli_fetch_array($result_cashier))
                {
                    $cashier_total = 0;
                    $cashier_id = $row_cashier['created_by'];
                    $sql_user = "SELECT * FROM users WHERE id='$cashier_id' ORDER BY first_name ASC";
                    $result_user = mysqli_query($con,$sql_user);
                    
                    if(!empty($result_user) && mysqli_num_rows($result_user) > 0)
                    {
                        $row_user = mysqli_fetch_array($result_user);
                        $cashier_name = $row_user['first_name'].' '.$row_user['last_name'];
                    }
                    else
                    {
                        $cashier_name = 'Not Specified';
                    };
                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(189,5,$cashier_name,1,1);
                    $sql_receipt_category = "SELECT * FROM receipt_category ORDER BY category ASC";
                    $result_receipt_category = mysqli_query($con,$sql_receipt_category);
                    if(!empty($result_receipt_category) && mysqli_num_rows($result_receipt_category))
                    {
                        while($row_receipt_category = mysqli_fetch_array($result_receipt_category))
                        {
                            $category_id = $row_receipt_category['receipt_category_id'];
                            $sql_ds = "SELECT * FROM receipt_category_list WHERE receipt_cat_id='$category_id' AND date 
                            BETWEEN '$start_date' AND '$end_date' AND created_by='$cashier_id' ORDER BY date ASC";
                            $result_ds = mysqli_query($con,$sql_ds);
                            if(!empty($result_ds) && mysqli_num_rows($result_ds) > 0)
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
                                    $cashier_total = $cashier_total + $amount;
                                    $total_amount = $total_amount + $amount;
                                    $category_amount = $category_amount + $amount;
                                    $amount_f = number_format($amount, 2, '.', ',');
                                    
                                    $query_patient = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                                    $query_run_patient = mysqli_query($con, $query_patient);
                                    if(!empty($query_run_patient) && mysqli_num_rows($query_run_patient)>0)
                                    {
                                        $row_patient = mysqli_fetch_assoc($query_run_patient);
                                        $gender_id = $row_patient['gender'];
                                        $patient_name = $row_patient['firstName'].' '.$row_patient['lastName'];
                                        $patient_telephone = $row_patient['telephone'];
                                    }
                                    else
                                    {
                                        $gender_id = 'Not Specified';
                                        $patient_name = 'Not Specified';
                                        $patient_telephone = 'Not Specified';
                                    };

                                    $query_attend = "SELECT * FROM attendance WHERE attend_id='$attend_id'";
                                    $query_run_attend = mysqli_query($con, $query_attend);
                                    if(!empty($query_run_attend) && mysqli_num_rows($query_run_attend) > 0 )
                                    {
                                        $row_attend = mysqli_fetch_assoc($query_run_attend);
                                        $age = $row_attend['age'].'yrs';
                                    }
                                    else
                                    {
                                        $age = 'N/A';
                                    };

                                    $query_gender = "SELECT * FROM gender WHERE gender_id='$gender_id'";
                                    $query_gender_run = mysqli_query($con, $query_gender);
                                    if(!empty($query_gender_run) && mysqli_num_rows($query_gender_run) > 0)
                                    {
                                        $row_gender = mysqli_fetch_assoc($query_gender_run);
                                        $gender = $row_gender['gender'];
                                    }
                                    else
                                    {
                                        $gender = 'Not Specified';
                                    };

                                    if($type == 'Detail')
                                    {
                                        $pdf->SetFont('Arial','I',8);
                                        $pdf->Cell(74,5,$patient_name,1,0);
                                        $pdf->Cell(20,5,$age,1,0,'C');
                                        $pdf->Cell(20,5,$gender,1,0,'C');
                                        $pdf->Cell(25,5,$patient_telephone,1,0,'C');
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
                    };
                    $cashier_total_f = number_format($cashier_total, 2, '.', ',');
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Cell(139,5,$cashier_name.' TOTAL',1,0,'R');
                    $pdf->Cell(50,5,$cashier_total_f,1,1,'R');
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