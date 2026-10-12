<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/pdf/fpdf.php');
    
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
            $this->Cell(189,5,'Printed by: '.$user_name.' on '.date('Y-m-d h:m:sa'),0,1,'C');
        }
    }

	date_default_timezone_set("Africa/Accra");

    $pdf = new PDF('P','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',8);
    $pdf->Image($image,10,10,15,15);
    
    if(isset($_SESSION['bonus_voucher_id']))
    {
        $company_id = $_SESSION['company_id'];
        $bonus_voucher_id = $_SESSION['bonus_voucher_id'];
    
        $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
        $result_company = mysqli_query($con,$sql_company);
        $row_company = mysqli_fetch_array($result_company);

        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(189,10,$row_company['trading_name'],0,1,'C');
        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(189,5,$row_company['address'].', '.$row_company['location'],0,1,'C');
        $pdf->Cell(189,5,$row_company['telephone'],0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(189,5,'',0,1,'C');
        $pdf->Cell(189,5,'BONUS VOUCHER',0,1,'C');
        $pdf->Cell(189,5,'',0,1,'C');
        $i=0;
        $total_bonus = 0;

        $query_bonus = "SELECT * FROM bonus WHERE bonus_id = '$bonus_voucher_id'";
        $query_run_bonus = mysqli_query($con, $query_bonus);
        if(!empty($query_run_bonus) && mysqli_num_rows($query_run_bonus) > 0)
        {
            while($row_bonus = mysqli_fetch_array($query_run_bonus))
            {
                $branch_id = $row_bonus['location'];
                $sql_branch = "SELECT * FROM branch WHERE branch_id = '$branch_id'";
                $result_branch = mysqli_query($con, $sql_branch);
                if(!empty($result_branch) && mysqli_num_rows($result_branch) > 0)
                {
                    while($row_branch = mysqli_fetch_array($result_branch))
                    {
                        $location_name = $row_branch['branch_name'];
                    };
                }
                else
                {
                    $location_name = 'Not Specified';
                };

                $pdf->SetFont('Arial','',8);
                $pdf->Cell(189,5,'Site: '.$location_name,0,1);
                $pdf->Cell(95,5,'Date: '.$row_bonus['date'],0,0);
                $pdf->Cell(94,5,'Calculation Type: '.$row_bonus['calculation_type'],0,1);
                $pdf->Cell(95,5,'Percentage/Amount: '.$row_bonus['amount'],0,0);
                $pdf->Cell(94,5,'Narration: '.$row_bonus['narration'],0,1);
                $pdf->Cell(189,5,'',0,1);
                
                $pdf->SetFont('Arial','B',6);
                $pdf->Cell(10,5,'S/No',1,0,'C');
                $pdf->Cell(50,5,'Employee',1,0);
                $pdf->Cell(34,5,'Location',1,0,'C');
                $pdf->Cell(25,5,'Calculation Type',1,0,'C');
                $pdf->Cell(25,5,'Percentage/Amount',1,0,'C');
                $pdf->Cell(25,5,'Basic Salary',1,0,'C');
                $pdf->Cell(25,5,'Bonus Amount',1,1,'C');


                $sql_bonus_list = "SELECT b.*, e.first_name, e.last_name, e.location AS site_id, e.employment_type FROM bonus_list b JOIN
                payroll_employee e ON b.employee_id=e.employee_id WHERE b.bonus_id = '$bonus_voucher_id' ORDER BY e.location ASC, e.first_name ASC";
                $result_bonus_list = mysqli_query($con, $sql_bonus_list);
                if(!empty($result_bonus_list) && mysqli_num_rows($result_bonus_list) > 0)
                {
                    while($row_bonus_list = mysqli_fetch_array($result_bonus_list))
                    {
                        $i++;
                        $employee_id = $row_bonus_list['employee_id'];
                        $total_bonus = $total_bonus + $row_bonus_list['bonus_amount'];
                        //EMPLOYEE
                            /*$sql_employee="SELECT * FROM payroll_employee WHERE employee_id = '$employee_id'";
                            $result_employee = mysqli_query($con, $sql_employee);
                            if(!empty($result_employee) && mysqli_num_rows($result_employee) > 0)
                            {
                                while($row_employee = mysqli_fetch_array($result_employee))
                                {
                                    $employee_name = $row_employee['first_name'].' '.$row_employee['last_name'];
                                    $location_id = $row_employee['location'];*/

                                    $employee_name = $row_bonus_list['first_name'].' '.$row_bonus_list['last_name'];
                                    $location_id = $row_bonus_list['site_id'];
                                    //SITE
                                        $sql_branch = "SELECT * FROM branch WHERE branch_id = '$location_id'";
                                        $result_branch = mysqli_query($con, $sql_branch);
                                        if(!empty($result_branch) && mysqli_num_rows($result_branch) > 0)
                                        {
                                            while($row_branch = mysqli_fetch_array($result_branch))
                                            {
                                                $branch_name = $row_branch['branch_name'];
                                            };
                                        }
                                        else
                                        {
                                            $branch_name = 'Not Specified';
                                        };
                                /*};
                            }
                            else
                            {
                                $employee_name = 'Not Specified';
                            };*/
                
                        $amount_f = number_format($row_bonus_list['amount'], 2, '.', ',');
                        $basic_salary_f = number_format($row_bonus_list['basic_salary'], 2, '.', ',');
                        $bonus_amount_f = number_format($row_bonus_list['bonus_amount'], 2, '.', ',');
                        $pdf->SetFont('Arial','I',6);
                        $pdf->Cell(10,5,$i,1,0,'C');
                        $pdf->Cell(50,5,$employee_name,1,0);
                        $pdf->Cell(34,5,$branch_name,1,0);
                        $pdf->Cell(25,5,$row_bonus_list['calculation_type'],1,0);
                        $pdf->Cell(25,5,$amount_f,1,0,'R');
                        $pdf->Cell(25,5,$basic_salary_f,1,0,'R');
                        $pdf->Cell(25,5,$bonus_amount_f,1,1,'R');
                    };
                        $total_bonus_f = number_format($total_bonus, 2, '.', ',');
                        $pdf->SetFont('Arial','B',8);
                        $pdf->Cell(169,5,'TOTAL',1,0,'C');
                        $pdf->Cell(25,5,$total_bonus_f,1,1,'R');
                };
            }
        };

        $pdf->Output();
    };
?>