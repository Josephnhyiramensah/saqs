<?php 
require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');

if(isset($_POST['ledgerdesc']))
{
    $code = $_POST['ledgerCode'];
    $ledger_desc = $_POST['ledgerdesc'];
    $ledgertype = $_POST['ledgertype'];
    $tb_1 = $_POST['tb_1'];
    $tb_2 = $_POST['tb_2'];
    $tb_3 = $_POST['tb_3'];
    $tb_4 = $_POST['tb_4'];
    $tb_5 = $_POST['tb_5'];
    $address = $_POST['ledgeraddress'];
    $telephone = $_POST['ledgerphone'];
    $email = $_POST['ledgeremail'];
    $status = $_POST['ledgerstatus'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $branch_id = $_SESSION['branch_id'];
    
    $query = "INSERT INTO ledgers (company_id, code, ledger_desc, type, tb_1, tb_2, tb_3, tb_4, 
    tb_5, address, telephone, email, status, branch_id, created_by, created_datetime) 
    VALUES ('$company_id','$code','$ledger_desc','$ledgertype','$tb_1','$tb_2','$tb_3','$tb_4','$tb_5','$address','$telephone','$email',
    '$status','$branch_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);
   if ($query_run)
    {
        echo "Ledger Added Successfully";
    }
    else
    {
        echo "Ledger NOT Added";
    };
};
    
?>
