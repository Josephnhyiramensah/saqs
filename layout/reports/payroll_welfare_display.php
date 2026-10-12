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
            $this->SetFont('Arial','I',8);
            $this->Cell(189,5,'Welfare Report printed by: '.$user_name.' on '.date('Y-m-d h:m:sa'),0,1,'C');
        }
    }
	date_default_timezone_set("Africa/Accra");

    $pdf = new PDF('P','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    $pdf->Image($image,10,10,25,25);
    
    if(isset($_SESSION['payroll_welfare_pay_sheet_id']))
    {
        $company_id = $_SESSION['company_id'];
        $pay_sheet_id = $_SESSION['payroll_welfare_pay_sheet_id'];
        $location = $_SESSION['payroll_welfare_location'];
    
        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);
    
        $sql_ps = "SELECT * FROM payroll_pay_sheet WHERE pay_sheet_id = '$pay_sheet_id'";
        $result_ps = mysqli_query($con,$sql_ps);
        if(!empty($result_ps) && mysqli_num_rows($result_ps))
        {
            $row_ps = mysqli_fetch_array($result_ps);
            $pay_sheet_date = $row_ps['date'];
        }
        else
        {
            $pay_sheet_date = 'Not Specified';
        };

        if($location != 'ALL')
        {
            $query_loc = "SELECT * FROM branch WHERE branch_id = '$location'";
            $query_run_loc = mysqli_query($con, $query_loc);
            if(!empty($query_run_loc) && mysqli_num_rows($query_run_loc) > 0 )
            {
                $row_loc = mysqli_fetch_array($query_run_loc);
                $pay_sheet_location = $row_loc['branch_name'];
            }
            else
            {
                $pay_sheet_location = 'Not Specified';
            };
        }
        else
        {
            $pay_sheet_location = 'ALL LOCATION';
        };

        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(189,10,$row_company['trading_name'],0,1,'C');
        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(189,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
        $pdf->Cell(189,5,$row_company['telephone'],0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(189,5,'',0,1,'C');
        $pdf->Cell(189,5,'WELFARE REPORT',0,1,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(189,5,'FOR '.$pay_sheet_location.' AS AT '.$pay_sheet_date,0,1,'C');
        $pdf->Cell(189,5,'',0,1,'C');

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(20,5,'S/No',1,0,'C');
        $pdf->Cell(80,5,'Employee',1,0,'C');
        $pdf->Cell(50,5,'Position',1,0,'C');
        $pdf->Cell(39,5,'Welfare',1,1,'C');
        
        $welfare = 0;
        $sum_welfare = 0;
        if($location == 'ALL')
        {
            $query_location = "SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name ASC";
        }
        else
        {
            $query_location = "SELECT * FROM branch WHERE branch_id = '$location'";
        };
        $query_run_location = mysqli_query($con, $query_location);
        if(!empty($query_run_location) && mysqli_num_rows($query_run_location) > 0 )
        {
            $i=0;
            while($row_location = mysqli_fetch_array($query_run_location))
            {
                $location = $row_location['branch_id'];

                $query_pay_slip = "SELECT * FROM payroll_pay_slip WHERE pay_sheet_id = '$pay_sheet_id' AND location = '$location' AND welfare > 0";
                $query_run_pay_slip = mysqli_query($con, $query_pay_slip);
                if(!empty($query_run_pay_slip) && mysqli_num_rows($query_run_pay_slip) > 0 )
                {
                    $subt_welfare = 0;

                    $pdf->SetFont('Arial','B',12);
                    $pdf->Cell(189,5,$row_location['branch_name'],1,1);
                    while($row_pay_slip = mysqli_fetch_array($query_run_pay_slip))
                    {
                        $i++;
                        $employee_id = $row_pay_slip['employee_id'];
                        $welfare = $row_pay_slip['welfare'];
                        $subt_welfare = $subt_welfare + $row_pay_slip['welfare'];
                        $sum_welfare = $sum_welfare + $row_pay_slip['welfare'];
                        
                        $f_welfare = number_format($welfare, 2, '.', ',');
                        $sql_employee="SELECT * FROM payroll_employee WHERE employee_id = '$employee_id'";
                        $result_employee = mysqli_query($con, $sql_employee);
                        if(!empty($result_employee) && mysqli_num_rows($result_employee) > 0 )
                        {
                            $row_employee = mysqli_fetch_array($result_employee);
                            $employee_name = $row_employee['first_name'].' '.$row_employee['last_name'];
                            $position = $row_employee['position'];
                        }
                        else
                        {
                            $employee_name = 'Not Specified';
                            $position = 'Not Specified';
                        };
                        $pdf->SetFont('Arial','I',10);
                        $pdf->Cell(20,5,$i,1,0,'C');
                        $pdf->Cell(80,5,$employee_name,1,0);
                        $pdf->Cell(50,5,$position,1,0);
                        $pdf->Cell(39,5,$f_welfare,1,1,'R');
                    };
                    $f_subt_welfare = number_format($subt_welfare, 2, '.', ',');
                    $pdf->SetFont('Arial','BI',10);
                    $pdf->Cell(150,5,'TOTAL',1,0);
                    $pdf->Cell(39,5,$f_subt_welfare,1,1,'R');
                };
            };
            $f_sum_welfare = number_format($sum_welfare, 2, '.', ',');
            
            $pdf->SetFont('Arial','BI',10);
            $pdf->Cell(150,5,'GRAND TOTAL',1,0);
            $pdf->Cell(39,5,$f_sum_welfare,1,1,'R');
        }
        else
        {
            $pdf->Cell(189,10,'No Pay Slip for the selected location',0,1,'C');
        };
        $pdf->Output();
    };
?>