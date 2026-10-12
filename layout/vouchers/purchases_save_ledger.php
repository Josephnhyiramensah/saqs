<?php 
include($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    
    $company_id = $_SESSION['company_id'];
    if(isset($_SESSION['user_id'])){$user_id = $_SESSION['user_id'];}else{$user_id = 0;};
    if(isset($_SESSION['user_super_id'])){$user_super_id = $_SESSION['user_super_id'];}else{$user_super_id = 0;};
    if(isset($_SESSION['branch_id'])){$branch_id = $_SESSION['branch_id'];}else{$branch_id = 0;};
    $code = '';
    $ledger_desc = $_POST['ledger_desc'];
    $ledger_type = 'Dr';
    $tb_1 = 1;
    $tb_2 = 2;
    $tb_3 = 3;
    $tb_4 = 7;
    $tb_5 = 4;
    $address = '';
    $telephone = '';
    $email = '';
    $status = 'Active';
    $opening_amount = '';
    $opening_date = '';
    $opening_state = 'Dr';
    $data = '';

    $query_last_com_led_id = "SELECT * FROM ledgers WHERE company_id = '$company_id' ORDER BY comp_led_id DESC";
    $result_last_com_led_id = mysqli_query($con,$query_last_com_led_id);
    if(!empty($result_last_com_led_id) && mysqli_num_rows($result_last_com_led_id) > 0)
    {
        $row_last_com_led_id = mysqli_fetch_assoc($result_last_com_led_id);
        $last_com_led_id = $row_last_com_led_id['comp_led_id'];
    }
    else
    {
        $last_com_led_id = 0;
    };
    $next_com_led_id = $last_com_led_id + 1;
    
    $query = "INSERT INTO ledgers (
    ledger_company_id, code, ledger_desc, tb_1, tb_2, tb_3, tb_4, tb_5, address, telephone, email, 
    status, company_id, user_id, comp_led_id, opening_amount, opening_date) 
    VALUES (
    '$company_id', '$code','$ledger_desc','$tb_1','$tb_2','$tb_3','$tb_4','$tb_5','$address',
    '$telephone','$email','$status','$company_id','$user_id',
    '$next_com_led_id', '$opening_amount', '$opening_date')";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        $query_ledger = "SELECT * FROM `ledgers` WHERE `company_id` = '$company_id' 
        ORDER BY `ledger_id` DESC";
        $result_ledger = mysqli_query($con,$query_ledger);
        if(!empty($result_ledger) && mysqli_num_rows($result_ledger) > 0)
        {
            $row_ledger = mysqli_fetch_assoc($result_ledger);
            $supplier_ledger_id = $row_ledger['ledger_id'];
        }
        else
        {
            $supplier_ledger_id = 0;
        };

        $data = '<label for="purch_credit"><strong>Credit</strong> (<a href="#" id="btn_new_purchase_ledger">Create Ledger</a>)</label>
        <select class="form-control bg-light" name="purch_credit" id="purch_credit"> 
            <option value="0">Please Select</option>';
            $sql="SELECT * FROM ledgers WHERE tb_5=1 OR tb_5=4 OR tb_5=7 OR tb_5=8 OR tb_5=11 ORDER BY ledger_desc ASC";
            $result=mysqli_query($con,$sql);
            while($row=mysqli_fetch_array($result))
            {
                if($row['ledger_id'] == $supplier_ledger_id)
                {
                    $data .= '<option value = "'.$row['ledger_id'].'" selected="selected">'.$row['ledger_desc'].'</option>';
                }
                else
                {
                    $data .= '<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
                };
            }
        $data .= '</select>
        <select class="form-control bg-light" name="purch_creditD" id="purch_creditD" disabled="true" hidden="true"> 
            <option value="0">Please Select</option>';
            $sql="SELECT * FROM ledgers WHERE tb_5=1 OR tb_5=4 OR tb_5=7 OR tb_5=8 OR tb_5=11 ORDER BY ledger_desc ASC";
            $result=mysqli_query($con,$sql);
            while($row=mysqli_fetch_array($result))
            {
                if($row['ledger_id'] == $supplier_ledger_id)
                {
                    $data .= '<option value = "'.$row['ledger_id'].'" selected="selected">'.$row['ledger_desc'].'</option>';
                }
                else
                {
                    $data .= '<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
                };
            }
        $data .= '</select>';
    }
    else
    {
        $data = '<label for="purch_credit"><strong>Credit</strong> (<a href="#" id="btn_new_purchase_ledger">Create Ledger</a>)</label>
        <select class="form-control bg-light" name="purch_credit" id="purch_credit"> 
            <option value="0">Please Select</option>';
            $sql="SELECT * FROM ledgers WHERE tb_5=1 OR tb_5=4 OR tb_5=7 OR tb_5=8 OR tb_5=11 ORDER BY ledger_desc ASC";
            $result=mysqli_query($con,$sql);
            while($row=mysqli_fetch_array($result))
            {
                $data .= '<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
            }
        $data .= '</select>
        <select class="form-control bg-light" name="purch_creditD" id="purch_creditD" disabled="true" hidden="true"> 
            <option value="0">Please Select</option>';
            $sql="SELECT * FROM ledgers WHERE tb_5=1 OR tb_5=4 OR tb_5=7 OR tb_5=8 OR tb_5=11 ORDER BY ledger_desc ASC";
            $result=mysqli_query($con,$sql);
            while($row=mysqli_fetch_array($result))
            {
                $data .= '<option value = "'.$row['ledger_id'].'" >'.$row['ledger_desc'].'</option>';
            }
        $data .= '</select>';
    }
    echo $data;