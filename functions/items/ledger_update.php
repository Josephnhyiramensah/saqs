<?php 
require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');

if(isset($_POST['ledgerdesc_up']))
{
    $ledger_id = $_POST['ledgerid_up'];
    $code = $_POST['ledgerCode_up'];
    $ledger_desc = $_POST['ledgerdesc_up'];
    $ledgertype = $_POST['ledgertype_up'];
    $tb_1 = $_POST['tb_1_up'];
    $tb_2 = $_POST['tb_2_up'];
    $tb_3 = $_POST['tb_3_up'];
    $tb_4 = $_POST['tb_4_up'];
    $tb_5 = $_POST['tb_5_up'];
    $address = $_POST['ledgeraddress_up'];
    $telephone = $_POST['ledgerphone_up'];
    $email = $_POST['ledgeremail_up'];
    $status = $_POST['ledgerstatus_up'];
    
    $query = "UPDATE `ledgers` SET `code`='$code', `ledger_desc`='$ledger_desc', `type`='$ledgertype', `tb_1`='$tb_1', `tb_2`='$tb_2', `tb_3`='$tb_3', `tb_4`='$tb_4', `tb_5`='$tb_5', `address`='$address', `telephone`='$telephone', `email`='$email', `status`='$status' WHERE ledger_id='$ledger_id'";
    $query_run = mysqli_query($con, $query);

    If ($query_run)
    {
        echo "Ledger Updated Successfully";
    }
    else
    {
        echo "Ledger NOT Updated";
    };
};
    
?>
