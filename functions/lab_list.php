<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//LABS
function check_lab_attend_duplicate()
{
    global $con;
    $lab_id = $_POST['lab_id'];
    $attend_id = $_POST['lab_attend_id'];
    $lab_dup=array();
    $query = "SELECT * FROM lab_list WHERE lab_id='$lab_id' AND attend_id='$attend_id'";
    $result = mysqli_query($con,$query);
        if (mysqli_num_rows($result) > 0)
        {
            $query_lab = "SELECT * FROM lab WHERE lab_id='$lab_id'";
            $result_lab = mysqli_query($con,$query_lab);
            $row_lab=mysqli_fetch_assoc($result_lab);

            array_push($lab_dup, 'duplicate',$row_lab['lab']);
        }
        else
        {
             array_push($lab_dup, 'none');

        }
    echo json_encode($lab_dup);
}

function save_lab_attend()
{
    global $con;
    $lab_id = $_POST['lab_id'];
    $attend_id = $_POST['lab_attend_id'];
    $patient_id = $_POST['lab_patient_id'];
    $lab_sponsor = $_POST['lab_sponsor'];
    $lab_comment = $_POST['lab_comment'];
    $lab_price_est = $_POST['lab_price_est'];
    $lab_amt_est = $_POST['lab_amt_est'];
    $date = $_POST['lab_date'];
    $lab_qty = $_POST['lab_qty'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    if($_POST['lab_print_status'] !== '' && $_POST['lab_print_status'] !== 0)
        {
            $lab_print_status = $_POST['lab_print_status'];
        }
        else
        {
            $lab_print_status = 'Yes';
        };
    $company_id = $_SESSION['company_id'];

    $query = "INSERT INTO `lab_list`(
    `company_id`,`lab_id`, `attend_id`, `patient_id`, `comment`, `date`, `price_est`, 
    `amount_est`, `qty`, `ledger_id`,`print_status`,`user_id`,`created_by`,`created_datetime`,
    `branch_id`) VALUES (
    '$company_id','$lab_id','$attend_id', '$patient_id', '$lab_comment','$date','$lab_price_est',
    '$lab_amt_est', '$lab_qty', '$lab_sponsor', '$lab_print_status', '$user_id', '$user_id', 
    NOW(),'$branch_id')";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        if ($_SESSION['user_type_id'] == 6) 
        {
            doctor_attend_register();
        };

        $query_lab_list = "SELECT * FROM `lab_list` ORDER BY `lab_list_id` DESC";
        $query_run_lab_list = mysqli_query($con, $query_lab_list);
        $row_lab_list = mysqli_fetch_assoc($query_run_lab_list);
        $lab_list_id  = $row_lab_list['lab_list_id'];

        $_SESSION['diagnosis_id'] = 0;
        $_SESSION['diag_list_id'] = 0;
        $_SESSION['lab_id'] = $lab_id;
        $_SESSION['lab_list_id'] = $lab_list_id;
        $_SESSION['item_category_id'] = 3;
        $_SESSION['date_SIOD'] = $date;

        incidence_of_disease_entry();
        echo "lab Added Successfully";
    }
    else
    {
        echo "lab NOT Added";
    };
}

function save_lab_attend_composite()
{
    global $con;
    $composite_lab_id = $_POST['composite_lab_select'];
    $attend_id = $_POST['lab_attend_id'];
    $patient_id = $_POST['lab_patient_id'];
    $lab_sponsor = $_POST['lab_sponsor'];
    $lab_comment = $_POST['lab_comment'];
    $date = $_POST['lab_date'];
    $lab_qty = $_POST['lab_qty'];
    $user_id = $_SESSION['user_id'];
    $company_id = $_SESSION['company_id'];
    if($_POST['lab_print_status'] != '' && $_POST['lab_print_status'] != 0)
    {
        $lab_print_status = $_POST['lab_print_status'];
    }
    else
    {
        $lab_print_status = 'Yes';
    };
    $company_id = $_SESSION['company_id'];

    $query_com_lab = "SELECT * FROM `composite_labs` WHERE `composite_lab_id` = '$composite_lab_id'";
    $query_run_com_lab = mysqli_query($con, $query_com_lab);
    $row_com_lab = mysqli_fetch_assoc($query_run_com_lab);
    $composite_lab_price = $row_com_lab['price'];

    $query_com_lab_list = "SELECT * FROM `composite_lab_list` WHERE `composite_lab_id` = '$composite_lab_id'";
    $query_run_com_lab_list = mysqli_query($con, $query_com_lab_list);
    if(mysqli_num_rows($query_run_com_lab_list) > 0)
    {
        $composite_lab_rows = mysqli_num_rows($query_run_com_lab_list);
        while($row_com_lab_list = mysqli_fetch_assoc($query_run_com_lab_list))
        {
            $lab_id  = $row_com_lab_list['lab_id'];
            $query_lab = "SELECT * FROM `lab` WHERE `lab_id` = '$lab_id'";
            $query_run_lab = mysqli_query($con, $query_lab);
            $row_lab = mysqli_fetch_assoc($query_run_lab);
            $lab_price = $row_com_lab['price'];
            if($composite_lab_price > 0)
            {
                $lab_price_est = $composite_lab_price / $composite_lab_rows;
                $lab_amt_est = $composite_lab_price / $composite_lab_rows;
            }
            else
            {
                $lab_price_est = $lab_price;
                $lab_amt_est = $lab_price;
            };

            $query = "INSERT INTO `lab_list`(
                `company_id`,`lab_id`, `attend_id`, `patient_id`, `comment`, `date`, `price_est`, 
                `amount_est`, `qty`, `ledger_id`,`print_status`,`user_id`,`created_by`,`created_datetime`) VALUES (
                '$company_id','$lab_id','$attend_id', '$patient_id', '$lab_comment','$date','$lab_price_est',
                '$lab_amt_est', '$lab_qty', '$lab_sponsor', '$lab_print_status', '$user_id', '$user_id', NOW())";
            $query_run = mysqli_query($con, $query);

            if ($query_run)
            {
                if ($_SESSION['user_type_id'] == 6) 
                {
                    doctor_attend_register();
                };

                $query_lab_list = "SELECT * FROM `lab_list` ORDER BY `lab_list_id` DESC";
                $query_run_lab_list = mysqli_query($con, $query_lab_list);
                $row_lab_list = mysqli_fetch_assoc($query_run_lab_list);
                $lab_list_id  = $row_lab_list['lab_list_id'];

                $_SESSION['diagnosis_id'] = 0;
                $_SESSION['diag_list_id'] = 0;
                $_SESSION['lab_id'] = $lab_id;
                $_SESSION['lab_list_id'] = $lab_list_id;
                $_SESSION['item_category_id'] = 3;
                $_SESSION['date_SIOD'] = $date;

                incidence_of_disease_entry();
                echo "lab Added Successfully";
            }
            else
            {
                echo "lab NOT Added";
            };
        };
    };
}

function lab_list_param_count()
{
    global $con;
    $lab_list_id = $_POST['lab_list_id'];
    $Data=array();

    $query_param = "SELECT lab_param_list_id FROM lab_param_list WHERE lab_list_id='$lab_list_id'";
    $query_run_param = mysqli_query($con, $query_param);
    $rows=mysqli_num_rows($query_run_param);

    $query = "SELECT * FROM lab_img WHERE lab_list_id=$lab_list_id";
    $result = mysqli_query($con,$query);
    $row_img=mysqli_num_rows($result);
    
        array_push($Data, 
            $rows,
            $row_img
        );
    
     echo json_encode($Data);
}

function edit_lab_attend()
{
    global $con;
    $lab_list_id = $_POST['lab_list_id'];
    $Lab_Data=array();
    $query = "SELECT * FROM lab_list WHERE lab_list_id='$lab_list_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($Lab_Data, 
            $row['date'],
            $row['lab_id'],
            $row['attend_id'],
            $row['patient_id'],
            $row['lab_list_id'],
            $row['comment'],
            $row['price_est'],
            $row['amount_est'],
            $row['qty'],
            $row['ledger_id'],
            $row['print_status']
        );
    };
     echo json_encode($Lab_Data);
}

function update_lab_attend()
{
    global $con;
    $lab_list_id = $_POST['lab_list_id'];
    $lab_id = $_POST['lab_id'];
    $lab_attend_id = $_POST['lab_attend_id'];
    $lab_patient_id = $_POST['lab_patient_id'];
    $lab_sponsor = $_POST['lab_sponsor'];
    $lab_comment = $_POST['lab_comment'];
    $lab_price_est = $_POST['lab_price_est'];
    $lab_amt_est = $_POST['lab_amt_est'];
    $lab_date = $_POST['lab_date'];
    $lab_qty = $_POST['lab_qty'];
    $lab_print_status = $_POST['lab_print_status'];
    $user_id = $_SESSION['user_id'];
    
    $query = "UPDATE `lab_list` SET `attend_id`='$lab_attend_id',`patient_id`='$lab_patient_id',`lab_id`='$lab_id',
    `comment`='$lab_comment',`price_est`='$lab_price_est',`amount_est`='$lab_amt_est',`date`='$lab_date',
    `qty`='$lab_qty',`ledger_id`='$lab_sponsor',`print_status`='$lab_print_status',
    `altered_by`='$user_id' ,`altered_datetime`=NOW() WHERE `lab_list_id`='$lab_list_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        
        $_SESSION['diagnosis_id'] = 0;
        $_SESSION['diag_list_id'] = 0;
        $_SESSION['lab_id'] = $lab_id;
        $_SESSION['lab_list_id'] = $lab_list_id;
        $_SESSION['item_category_id'] = 3;
        $_SESSION['date_SIOD'] = $date;
        incidence_of_disease_update_lab();
        echo "lab Updated Successfully";
    }
    else
    {
        echo "lab NOT Updated";
    };
}

function get_lab_attend_list()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];

    date_default_timezone_set("Africa/Accra");
    $date_today = date('Y-m-d');
    
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="action-td">Date</th>
                <th class="action-td">Lab Test</th>';
            if (
                $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                $_SESSION['user_type'] == 'Super_User' OR 
                ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
            {    
                $value.='
                <th class="action-td">Amt-Estimate</th>
                <th class="action-td">Amt-Cash</th>
                <th class="action-td">Amt-Disc.</th>
                <th class="action-td" hidden="true">Amt-Prvt</th>
                <th class="action-td" hidden="true">Amt-NHIS</th>
                <th class="action-td">Bill?</th>';
            };

                $value.='<th class="action-td">Print?</th>
                <th class="action-td">Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">';
    $query = "SELECT * FROM lab_list WHERE attend_id='$attend_id' ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
        {
            $total_est=0;
            $total_cash=0;
            $total_disc=0;
            $total_prvt=0;
            $total_nhis=0;
            //$counter = 0;
            while($row=mysqli_fetch_assoc($query_run))
            {
                //$counter=++$counter;
                $lab_id = $row['lab_id'];
                $query_lab = "SELECT lab FROM lab WHERE lab_id='$lab_id'";
                $query_run_lab = mysqli_query($con, $query_lab);
                $row_lab=mysqli_fetch_assoc($query_run_lab);

                $lab_list_id = $row['lab_list_id'];
                $query_disc = "SELECT SUM(amount) AS amount FROM discount WHERE lab_list_id='$lab_list_id'";
                $query_run_disc = mysqli_query($con, $query_disc);
                $row_disc=mysqli_fetch_assoc($query_run_disc);

                $amt_est = $row['amount_est'];
                $amt_cash = $row['amount_cash'];
                if (isset($row_disc)) {$amt_disc = $row_disc['amount'];} else {$amt_disc = 0;};
                $amt_prvt = $row['amount_prvt'];
                $amt_nhis = $row['amount_nhis'];
                $amt_est = number_format($amt_est, 2, '.', ',');
                $amt_cash = number_format($amt_cash, 2, '.', ',');
                $amt_disc = number_format($amt_disc, 2, '.', ',');
                $amt_prvt = number_format($amt_prvt, 2, '.', ',');
                $amt_nhis = number_format($amt_nhis, 2, '.', ',');
                $value.='<tr id="'.$lab_list_id.'">
                    <td class="action-td">
                        <a href="#" id="btn_lab_doc_view" 
                        data-id="'.$row['lab_list_id'].'"
                        data-id1="'.$row['lab_id'].'" 
                        >'.$row['date'].'</a>
                    </td>
                    <td>
                        <a href="#" id="btn_lab_doc_view" 
                        data-id="'.$row['lab_list_id'].'"
                        data-id1="'.$row['lab_id'].'" 
                        >'.$row_lab['lab'].'</a>
                    </td>';

                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
                            $_SESSION['user_type'] == 'Super_User' OR 
                            ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
                            {
                                $value.='<td class="amt-td">'.$amt_est.'</td>
                                <td class="amt-td">'.$amt_cash.'</td>
                                <td class="amt-td">'.$amt_disc.'</td>
                                <td class="amt-td" hidden="true">'.$amt_prvt.'</td>
                                <td class="amt-td" hidden="true">'.$amt_nhis.'</td>';
                                $perform_status = $row['bill'];
                                $value.='<td class="action-td">
                                    <select class="form-control lab_bill text-center" name="lab_bill" id="lab_bill'.$lab_list_id.'">';
                                    if($perform_status == '')
                                    {
                                        $value.='<option value="0">Please Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No" selected="selected">No</option>';
                                    }
                                    elseif($perform_status == 'Yes')
                                    {
                                        $value.='<option value="0">Please Select</option>
                                        <option value="Yes" selected="selected">Yes</option>
                                        <option value="No">No</option>';
                                    }
                                    elseif($perform_status == 'No')
                                    {
                                        $value.='<option value="0">Please Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No" selected="selected">No</option>';
                                    };
                                    $value.='</select>
                                </td>';
                            };
                            $print_status = $row['print_status'];
                            $value.='<td class="action-td">
                                <select class="form-control lab_print text-center" name="lab_print" id="lab_print'.$lab_list_id.'">';
                                if($print_status == '')
                                {
                                    $value.='<option value="0">Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No" selected="selected">No</option>';
                                }
                                elseif($print_status == 'Yes')
                                {
                                    $value.='<option value="0">Please Select</option>
                                    <option value="Yes" selected="selected">Yes</option>
                                    <option value="No">No</option>';
                                }
                                elseif($print_status == 'No')
                                {
                                    $value.='<option value="0">Please Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No" selected="selected">No</option>';
                                };
                                $value.='</select>
                            </td>
                            <td class="action-td">';
                            $total_est += $row['amount_est'];
                            $total_cash += $row['amount_cash'];
                            if (isset($row_disc)) {$total_disc += $row_disc['amount'];} else {$total_disc+=0;};
                            $total_prvt += $row['amount_prvt'];
                            $total_nhis += $row['amount_nhis'];
                            $lab_list_id = $row['lab_list_id'];

                            $query_receipt_item = "SELECT * FROM `receipt_items` WHERE `attend_id` = '$attend_id' AND 
                            `category_id` = 3 AND `item_list_id`='$lab_list_id'";
                            $query_run_receipt_item = mysqli_query($con, $query_receipt_item);
                            $rows_receipt_item_count = mysqli_num_rows($query_run_receipt_item);

                            $query_img = "SELECT lab_img_id FROM lab_img WHERE lab_list_id='$lab_list_id'";
                            $query_run_img = mysqli_query($con, $query_img);
                            $row_imgs=mysqli_num_rows($query_run_img);

                            $query_param = "SELECT lab_param_list_id FROM lab_param_list WHERE lab_id='$lab_id' AND attend_id='$attend_id' AND lab_list_id='$lab_list_id'";
                            $query_run_param = mysqli_query($con, $query_param);
                            if (mysqli_num_rows($query_run_param) > 0)
                            {
                                $row_param = mysqli_fetch_assoc($query_run_param);

                                /*if (
                                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Lab_List'] == 'Yes')) 
                                    {
                                        $value.='<a href="#" id="btn_lab_edit" 
                                            data-id12="'.$row['lab_list_id'].'"
                                            data-id13="'.$row['lab_id'].'">
                                            Edit Lab Item</a>';
                                    };*/

                                if (
                                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Lab_Result'] == 'Yes')) 
                                    {
                                        $value.=' | <a href="#" id="btn_lab_perform_edit" data-id="'.$row['lab_list_id'].'" data-id1="'.$row['lab_id'].'"
                                                    class="data-toggle="tooltip" data-placement="left" title="Edit Lab Result"">
                                                    Edit Result
                                                </a>';
                                    };
                                
                                if (
                                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Lab_Result'] == 'Yes')) 
                                    {
                                        $value.=' | 
                                                <a href="#" id="btn_lab_result_view" data-id="'.$row['lab_list_id'].'" data-id1="'.$row['lab_id'].'"
                                                    class="data-toggle="tooltip" data-placement="left" title="View Lab Result"">
                                                    View Result
                                                </a>';
                                    };

                                if (
                                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Upload_Lab_Result_Image'] == 'Yes')) 
                                    {
                                        if($rows_receipt_item_count > 0)
                                        {
                                            $value.=' | 
                                                <a href="#" id="btn_lab_img_upload" data-id6="'.$row['lab_list_id'].'" data-id7="'.$row['lab_id'].'"
                                                    class="data-toggle="tooltip" data-placement="left" title="Upload Lab Result Image"">
                                                    Upload Image
                                                </a>';
                                        };
                                    };

                                if ($row_imgs > 0)
                                {
                                    if (
                                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                        $_SESSION['user_type'] == 'Super_User' OR 
                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Uploaded_Lab_Result_Image'] == 'Yes')) 
                                        {
                                            $value.=' | 
                                                <a href="#" id="btn_lab_img_view" data-id2="'.$row['lab_list_id'].'" data-id3="'.$row['lab_id'].'"
                                                    class="data-toggle="tooltip" data-placement="left" title="View Uploaded Lab Result Image"">
                                                    View Image
                                                </a>';
                                        };
                                };
                            }
                            else
                            {
                                if ($_SESSION['user_id'] == $row['user_id']) 
                                {
                                    if($row['date'] == $date_today)
                                    {
                                        
                                        if (
                                            $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                            $_SESSION['user_type'] == 'Super_User' OR 
                                            ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Lab_List'] == 'Yes')) 
                                        {
                                            $value.='<a href="#" id="btn_lab_edit" 
                                                    data-id12="'.$row['lab_list_id'].'"
                                                    data-id13="'.$row['lab_id'].'" 
                                                >Edit Lab Item</a>';
                                        };
                                    };
                                };

                                if (
                                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Enter_Lab_Result_Internal'] == 'Yes')) 
                                    {
                                        if($rows_receipt_item_count > 0)
                                        {
                                            $value.=' | <a href="#" id="btn_lab_perform_enter" data-id="'.$row['ledger_id'].'" data-id4="'.$row['lab_list_id'].'" data-id5="'.$row['lab_id'].'"
                                                class="data-toggle="tooltip" data-placement="left" title="Enter Lab Result"">
                                                Enter Result
                                            </a>';
                                        };
                                    };

                                if (
                                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Enter_Lab_Result_External'] == 'Yes')) 
                                    {
                                        if($rows_receipt_item_count > 0)
                                        {
                                            $value.=' | 
                                                <a href="#" id="btn_lab_result_enter" data-id4="'.$row['lab_list_id'].'" data-id5="'.$row['lab_id'].'"
                                                    class="data-toggle="tooltip" data-placement="left" title="Enter External Lab Result"">
                                                    Enter Ext. Result
                                                </a>';
                                        };
                                    };

                                if (
                                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Upload_Lab_Result_Image'] == 'Yes')) 
                                    {
                                        if($rows_receipt_item_count > 0)
                                        {
                                            $value.=' | 
                                            <a href="#" id="btn_lab_img_upload" data-id6="'.$row['lab_list_id'].'" data-id7="'.$row['lab_id'].'"
                                                class="data-toggle="tooltip" data-placement="left" title="Upload Lab Result Image"">
                                                Upload Image
                                            </a> ';
                                        };
                                    };

                                if ($row_imgs > 0)
                                {
                                    if (
                                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                        $_SESSION['user_type'] == 'Super_User' OR 
                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Uploaded_Lab_Result_Image'] == 'Yes')) 
                                        {
                                            $value.=' | 
                                                <a href="#" id="btn_lab_img_view" data-id2="'.$row['lab_list_id'].'" data-id3="'.$row['lab_id'].'"
                                                    class="data-toggle="tooltip" data-placement="left" title="View Uploaded Lab Result Image"">
                                                    View Image
                                                </a>';
                                        };
                                };
                            };
                    if (
                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                        $_SESSION['user_type'] == 'Super_User' OR 
                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Discount'] == 'Yes')) 
                        {
                            $value.=' | <a href="#" id="btn_discount_lab_attend" 
                                data-id="'.$row['lab_list_id'].'" 
                                data-id1="'.$attend_id.'"
                                data-id2="'.$patient_id.'" 
                                data-id3="'.$row['amount_cash'].'" 
                                data-id4="'.$_SESSION['name'].'" 
                                class="data-toggle="tooltip" data-placement="left" title="Discount Lab Test"">
                                    Disc.
                            </a>';
                        };
                    
                        if ($_SESSION['user_id'] == $row['user_id'] OR $_SESSION['user_type'] == 'Ultra_Super_User') 
                        {
                            if($row['date'] == $date_today)
                            {
                                if (
                                    $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                    $_SESSION['user_type'] == 'Super_User' OR 
                                    ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Lab_List'] == 'Yes')) 
                                {
                                    $value.=' | 
                                    <a href="#" id="btn_delete_lab_attend" data-id8="'.$row['lab_list_id'].'" data-id9="'.$row['lab_id'].'"
                                        class="data-toggle="tooltip" data-placement="left" title="Delete Lab Test"">
                                        Delete
                                    </a>';
                                };
                            };
                        };
                $value.='</td>
                </tr>';
            }
            $total_est = number_format($total_est, 2, '.', ',');
            $total_cash = number_format($total_cash, 2, '.', ',');
            $total_disc = number_format($total_disc, 2, '.', ',');
            $total_prvt = number_format($total_prvt, 2, '.', ',');
            $total_nhis = number_format($total_nhis, 2, '.', ',');
            if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
            $_SESSION['user_type'] == 'Super_User' OR 
            ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
            {
                $value.='<tr>
                    <td colspan="2">TOTAL</td>
                    <td class="amt-td">'.$total_est.'</td>
                    <td class="amt-td">'.$total_cash.'</td>
                    <td class="amt-td">'.$total_disc.'</td>
                    <td class="amt-td" hidden="true">'.$total_prvt.'</td>
                    <td class="amt-td" hidden="true">'.$total_nhis.'</td>
                    <td colspan="2"></td>
                </tr>';
            };
           $value.='</tbody>
            </table>';
        };
    
    echo $value;
}

function lab_result_enter()
{
    global $con;
    $lab_list_id = $_POST['lab_list_id'];
    $lab_id = $_POST['lab_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                <thead>
                    <tr>
                        <th width="30%">Parameter</th>
                        <th width="15%">Result</th>
                        <th width="5%">Lower Range</th>
                        <th width="5%">Higher Range</th>
                        <th width="5%">Unit</th>
                        <th width="5%">Flag</th>
                        <th width="35%">Comment</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM lab_param WHERE lab_id='$lab_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
        {
            $i=0;
            while($row=mysqli_fetch_assoc($query_run))
            {
                $lab_param_id = $row['lab_param_id'];
                $i=$i++;
                $value.='
                        <tr id="'.$i.'">
                            <td>
                                <input type="hidden" name="lab_list_id_re[]" class="form-control" id="lab_list_id_re" value="'.$lab_list_id.'">
                                <input type="hidden" name="lab_id_re[]" class="form-control" id="lab_id_re" value="'.$lab_id.'">
                                <input type="hidden" name="lab_param_id_re[]" class="form-control" id="lab_param_id_re" value="'.$row['lab_param_id'].'">
                                <input type="hidden" name="lab_attend_id_re[]" class="form-control" id="lab_attend_id_re" value="'.$attend_id.'">
                                <input type="hidden" name="lab_patient_id_re[]" class= id="lab_patient_id_re" value="'.$patient_id.'">
                                '.$row['lab_param'].'
                            </td>
                            <td>';
                                $sql="SELECT * FROM lab_param_dropdown WHERE lab_param_id='$lab_param_id'";
                                $result=mysqli_query($con,$sql);
                                if (mysqli_num_rows($result) > 0)
                                {
                                    $value.='<select name="lab_attend_result_re[]" id="lab_attend_result_re" style="border-width:0px"> 
                                    <option value="0">Please Select</option>';
                                        while($row_param_dd=mysqli_fetch_array($result))
                                        {
                                        $value.='<option value = "'.$row_param_dd['lab_param_dropdown'].'" >'
                                            .$row_param_dd['lab_param_dropdown'].'</option>';
                                        } 
                                        $value.='</select>';
                                }
                                else{
                                    $value.='<input type="text" name="lab_attend_result_re[]" id="lab_attend_result_re" style="border-width:0px">';
                                }
                            $value.='</td>
                            <td>
                                <input type="hidden" name="lower_range_re[]" class="form-control" id="lower_range_re" value="'.$row['low_range'].'">
                                '.$row['low_range'].'
                            </td>
                            <td>
                                <input type="hidden" name="higher_range_re[]" class="form-control" id="higher_range_re" value="'.$row['high_range'].'">
                                '.$row['high_range'].'
                            </td>
                            <td>
                                <input type="hidden" name="unit_re[]" class="form-control" id="unit_re" value="'.$row['unit'].'">
                                '.$row['unit'].'
                            </td>
                            <td>
                                <input type="text" name="flag_re[]" id="flag_re" style="border-width:0px" size="10">
                            </td>
                            <td>
                                <input type="text" name="comment_re[]" id="comment_re" style="border-width:0px" size="50">
                            </td>
                        </tr>';
            };
            $value.='</tbody>
            </table>';
        }
    echo $value;
}

function lab_result_save()
{
    global $con;
    $number = count($_POST["lab_param_id_re"]);  
     if($number > 0)  
     {  
          for($i=0; $i<$number; $i++)  
          {  
               if(trim($_POST["lab_param_id_re"][$i] != ''))  
               {  
                    $lab_list_id = $_POST['lab_list_id_re'][$i];
                    $lab_param_id = $_POST['lab_param_id_re'][$i];
                    $lab_id = $_POST['lab_id_re'][$i];
                    $attend_id = $_POST['lab_attend_id_re'][$i];
                    $patient_id = $_POST['lab_patient_id_re'][$i];
                    $result = $_POST['lab_attend_result_re'][$i];
                    $flag = $_POST['flag_re'][$i];
                    $comment = $_POST['comment_re'][$i];
                    $lower = $_POST['lower_range_re'][$i];
                    $higher = $_POST['higher_range_re'][$i];
                    $user_id = $_SESSION['user_id'];
                    $query = "INSERT INTO `lab_param_list`(`lab_param_id`, `lab_id`, `attend_id`, `patient_id`, 
                    `lab_list_id`, `result`, `comment`, `flag`, `low_range`, `high_range`, `user_id`, `created_by`, 
                    `created_datetime`) VALUES ('$lab_param_id','$lab_id','$attend_id','$patient_id','$lab_list_id','$result',
                    '$comment','$flag','$lower','$higher','$user_id','$user_id',NOW())";
                    mysqli_query($con, $query);
               };
          };
          echo "Data Inserted";  
     }  
     else  
     {  
          echo "Data NOT Inserted";  
     }  
}

function lab_result_perform_enter()
{
    global $con;
    $lab_list_id = $_POST['lab_list_id'];
    $lab_id = $_POST['lab_id'];
    $lab_sponsor = $_POST['lab_sponsor'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    //$prvt_led_id = $_POST['prvt_led_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                <thead>
                    <tr>
                        <th width="30%">Parameter</th>
                        <th width="15%">Result</th>
                        <th width="5%">Lower Range</th>
                        <th width="5%">Higher Range</th>
                        <th width="5%">Unit</th>
                        <th width="5%">Flag</th>
                        <th width="35%">Comment</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM lab_param WHERE lab_id='$lab_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        $i = 0;
        while($row=mysqli_fetch_assoc($query_run))
        {
            $lab_param_id = $row['lab_param_id'];
            $i=$i++;
            $value.='<tr id="'.$i.'">
                <td>
                    <input type="hidden" name="lab_list_id_re[]" class="form-control" id="lab_list_id_re" value="'.$lab_list_id.'">
                    <input type="hidden" name="lab_id_re[]" class="form-control" id="lab_id_re" value="'.$lab_id.'">
                    <input type="hidden" name="lab_sponsor_re[]" class="form-control" id="lab_sponsor_re" value="'.$lab_sponsor.'">
                    <input type="hidden" name="lab_param_id_re[]" class="form-control" id="lab_param_id_re" value="'.$row['lab_param_id'].'">
                    <input type="hidden" name="lab_attend_id_re[]" class="form-control" id="lab_attend_id_re" value="'.$attend_id.'">
                    <input type="hidden" name="lab_patient_id_re[]" class= id="lab_patient_id_re" value="'.$patient_id.'">
                    <input type="hidden" name="lab_prvt_led_id_re[]" class= id="lab_prvt_led_id_re" value="'.$lab_sponsor.'">
                    '.$row['lab_param'].'
                </td>
                <td>';
                    $sql="SELECT * FROM lab_param_dropdown WHERE lab_param_id='$lab_param_id'";
                    $result=mysqli_query($con,$sql);
                    if (mysqli_num_rows($result) > 0)
                    {
                        $value.='<select name="lab_attend_result_re[]" id="lab_attend_result_re" style="border-width:0px"> 
                        <option value="0">Please Select</option>';
                            while($row_param_dd=mysqli_fetch_array($result))
                            {
                            $value.='<option value = "'.$row_param_dd['lab_param_dropdown'].'" >'
                                .$row_param_dd['lab_param_dropdown'].'</option>';
                            } 
                            $value.='</select>';
                    }
                    else{
                        $value.='<input type="text" name="lab_attend_result_re[]" id="lab_attend_result_re" style="border-width:0px">';
                    }
                $value.='</td>
                <td>
                    <input type="hidden" name="lower_range_re[]" class="form-control" id="lower_range_re" value="'.$row['low_range'].'">
                    '.$row['low_range'].'
                </td>
                <td>
                    <input type="hidden" name="higher_range_re[]" class="form-control" id="higher_range_re" value="'.$row['high_range'].'">
                    '.$row['high_range'].'
                </td>
                <td>
                    <input type="hidden" name="unit_re[]" class="form-control" id="unit_re" value="'.$row['unit'].'">
                    '.$row['unit'].'
                </td>
                <td>
                    <input type="text" name="flag_re[]" id="flag_re" style="border-width:0px" size="10">
                </td>
                <td>
                    <input type="text" name="comment_re[]" id="comment_re" style="border-width:0px" size="50">
                </td>
            </tr>';
        };
        $value.='</tbody>
        </table>';
    }
    echo $value;
}

function lab_result_perform_save()
{
    global $con;
    $number = count($_POST["lab_param_id_re"]);  
    if($number > 0)  
    {  
        for($i=0; $i<$number; $i++)  
        {  
           if(trim($_POST["lab_param_id_re"][$i] != ''))  
           {  
                $lab_list_id = $_POST['lab_list_id_re'][$i];
                $lab_param_id = $_POST['lab_param_id_re'][$i];
                $lab_id = $_POST['lab_id_re'][$i];
                $sponsor_id = $_POST['lab_sponsor_re'][$i];
                $prvt_led_id = $_POST['lab_prvt_led_id_re'][$i];
                $attend_id = $_POST['lab_attend_id_re'][$i];
                $patient_id = $_POST['lab_patient_id_re'][$i];
                $result = $_POST['lab_attend_result_re'][$i];
                $flag = $_POST['flag_re'][$i];
                $comment = $_POST['comment_re'][$i];
                $lower = $_POST['lower_range_re'][$i];
                $higher = $_POST['higher_range_re'][$i];
                $company_id = $_SESSION['company_id'];
                $branch_id = $_SESSION['branch_id'];
                $user_id = $_SESSION['user_id'];
                $query = "INSERT INTO `lab_param_list`(`lab_param_id`, `lab_id`, `attend_id`, `patient_id`,
                 `lab_list_id`, `result`, `comment`, `flag`, `low_range`, `high_range`, `user_id`, 
                 `created_by`, `created_datetime`, `company_id`, `branch_id`) 
                 VALUES ('$lab_param_id','$lab_id','$attend_id','$patient_id','$lab_list_id','$result',
                 '$comment','$flag','$lower','$higher','$user_id','$user_id',NOW(),'$company_id','$branch_id')";
                mysqli_query($con, $query);
           };  
        };

    //SET PRICE
        $query_ll = "SELECT * FROM `lab_list` WHERE `lab_list_id`='$lab_list_id'";
        $query_run_ll = mysqli_query($con, $query_ll);
        $row_ll = mysqli_fetch_assoc($query_run_ll);
        $cash_price = $row_ll['amount_est'];

          $query = "SELECT * FROM lab WHERE lab_id = '$lab_id'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            $row_cash = mysqli_fetch_assoc($query_run);
            //$cash_price = $row_cash['price_cash'];
            $price_private = $row_cash['price_private'];
            $price_private_topup = $row_cash['price_private_topup'];
            $price_nhis_topup = $row_cash['price_nhis_topup'];
            $nhis_id = $row_cash['nhis_id'];
        };
        if ($sponsor_id == 1)
        {
            $query = "UPDATE `lab_list` SET `performed`=1,`price_cash`='$cash_price',`price_prvt`=0,
            `price_nhis`= 0,`amount_cash`='$cash_price',`amount_prvt`=0,`amount_nhis`=0 WHERE 
            `lab_list_id`='$lab_list_id'";
            $query_run = mysqli_query($con, $query);
        }
        else if ($sponsor_id == 2)
        {
            $query = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
            $query_run = mysqli_query($con, $query);
            if (mysqli_num_rows($query_run) > 0)
            {
                while($row_nhis = mysqli_fetch_assoc($query_run))
                {
                    $price_adult = $row_nhis['price_adult'];
                    $price_child = $row_nhis['price_child'];
                    $price_topup = $row_nhis['price_topup'];
                    $price = $row_nhis['price'];
                }
                $query = "UPDATE `lab_list` SET `performed`= 1,`price_cash`='$price_topup',`price_prvt`=0,
                `price_nhis`='$price',`amount_cash`='$price_topup',`amount_prvt`=0,`amount_nhis`='$price' 
                WHERE `lab_list_id`='$lab_list_id'";
                $query_run = mysqli_query($con, $query);
            }
            else
            {
                $query = "UPDATE `lab_list` SET `performed`=1,`price_cash`='$cash_price',`price_prvt`=0,
                `price_nhis`=0,`amount_cash`='$cash_price',`amount_prvt`=0,`amount_nhis`=0, `ledger_id`=1  WHERE `lab_list_id`='$lab_list_id'";
                $query_run = mysqli_query($con, $query);
            }
        }
        else if ($sponsor_id != 1 && $sponsor_id != 2)
        {
            $query = "SELECT * FROM price_list WHERE ledger_id='$sponsor_id' AND item_id='$lab_id' AND 
            category_id=3";
            $query_run = mysqli_query($con, $query);
            if (mysqli_num_rows($query_run) > 0)
            {
                while($row_pl=mysqli_fetch_assoc($query_run))
                {
                    $price_prvt = $row_pl['price'];
                    $price_prvt_topup = $row_pl['price_topup'];
                }
                       $query = "UPDATE `lab_list` SET `performed`=1,`price_cash`='$price_prvt_topup',
                    `price_prvt`='$price_prvt',`price_nhis`=0,`amount_cash`='$price_prvt_topup',
                    `amount_prvt`='$price_prvt',`amount_nhis`=0 WHERE `lab_list_id`='$lab_list_id'";
                    $query_run = mysqli_query($con, $query);
            }
            else
            {
                if($price_private > 0)
                {
                    $query = "UPDATE `lab_list` SET `performed`=1,`price_cash`=0,`price_prvt`='$price_private',
                    `price_nhis`=0,`amount_cash`=0,`amount_prvt`='$price_private',`amount_nhis`=0 WHERE 
                    `lab_list_id`='$lab_list_id'";
                }
                else
                {
                    $query = "UPDATE `lab_list` SET `performed`=1,`price_cash`=0,`price_prvt`='$cash_price',
                    `price_nhis`=0,`amount_cash`=0,`amount_prvt`='$cash_price',`amount_nhis`=0 WHERE 
                    `lab_list_id`='$lab_list_id'";
                };
                $query_run = mysqli_query($con, $query);
            };
        };

    //POST TRANSACTION
        $query_lab_list = "SELECT * FROM `lab_list` WHERE `lab_list_id`='$lab_list_id'";
        $query_run_lab_list = mysqli_query($con, $query_lab_list);
        $row_lab_list=mysqli_fetch_assoc($query_run_lab_list);

        $amount_est = $row_lab_list['amount_est'];
        $amount_cash = $row_lab_list['amount_cash'];
        $amount_prvt = $row_lab_list['amount_prvt'];
        $amount_nhis = $row_lab_list['amount_nhis'];
        $date = $row_lab_list['date'];

        $query_trans = "SELECT * FROM `transactions` WHERE `attend_id`='$attend_id' AND 
        `category_id`=3 AND `item_list_id`='$lab_list_id'";
        $query_run_trans = mysqli_query($con, $query_trans);
        if (mysqli_num_rows($query_run_trans) > 0)
        {
            $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND 
            `category_id`=3 AND `item_list_id`='$lab_list_id'";
            mysqli_query($con, $query_trans_del);

            if ($amount_cash > 0)
            {
                $query_dr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `lab_list_id`, `narration`, `branch_id`) 
                VALUES (1,6,'$attend_id','$patient_id',3,'$date','$amount_cash','$amount_cash',0,
                '$lab_list_id','$lab_list_id','lab test performed for cash','$branch_id')";
                mysqli_query($con, $query_dr);

                $query_cr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `lab_list_id`, `narration`, `branch_id`) 
                VALUES (6,1,'$attend_id','$patient_id',3,'$date','$amount_cash',0,'$amount_cash',
                '$lab_list_id','$lab_list_id','lab test performed for cash','$branch_id')";
                mysqli_query($con, $query_cr);

                //AUTO ITEMISED RECEIPT
                        /*$query_receipt_deposit = "SELECT * FROM receipt WHERE attend_id='$attend_id' AND patient_id='$patient_id' AND type='Deposit' ORDER BY receipt_id ASC";
                        $result_receipt_deposit = mysqli_query($con,$query_receipt_deposit);
                        if (mysqli_num_rows($result_receipt_deposit) > 0)
                        {
                            while($row_receipt_deposit = mysqli_fetch_assoc($result_receipt_deposit))
                            {
                                $receipt_id = $row_receipt_deposit['receipt_id'];
                                $amount_deposited = $row_receipt_deposit['amount'];

                                $query_receipt_item = "SELECT SUM(amount_rec) AS total_itemised FROM receipt_items WHERE receipt_id='$receipt_id'";
                                $result_receipt_item = mysqli_query($con,$query_receipt_item);
                                if (mysqli_num_rows($result_receipt_item) > 0)
                                {
                                    $row_receipt_item = mysqli_fetch_assoc($result_receipt_item);
                                    $amount_itemised = $row_receipt_item['total_itemised'];
                                }
                                else
                                {
                                    $amount_itemised = 0;
                                };
                                    $deposit_balance = $amount_deposited - $amount_itemised;
                                    $item_list_id = $lab_list_id;
                                    $item_id = $lab_id;
                                    $category_id = 3;
                                    $qty = 1;
                                    $price = $amount_cash;
                                if($deposit_balance > $amount_cash)
                                {
                                    $amount_rec = $amount_cash;
                                }
                                else
                                {
                                    $amount_rec = $deposit_balance;
                                };
                                if($amount_rec > 0)
                                {
                                    $query_rec_item = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,`attend_id`, `date`, `qty`, `price`, 
                                    `amount_bill`, `amount_rec`, `type`) VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$qty',
                                    '$price','$amount_cash','$amount_rec','itemise')";
                                    $query_run_rec_item = mysqli_query($con, $query_rec_item);
                                };
                            };
                        };*/
            }
            if ($amount_prvt > 0)
            {
                $query_dr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `lab_list_id`, `narration`, `branch_id`) 
                VALUES ('$prvt_led_id',6,'$attend_id','$patient_id',3,'$date','$amount_prvt','$amount_prvt',
                0,'$lab_list_id','$lab_list_id','lab test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_dr);

                $query_cr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `lab_list_id`, `narration`, `branch_id`) 
                VALUES (6,'$prvt_led_id','$attend_id','$patient_id',3,'$date','$amount_prvt',0,
                '$amount_prvt','$lab_list_id','$lab_list_id','lab test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_cr);
            }
            if ($amount_nhis > 0)
            {
                $query_dr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `lab_list_id`, `narration`, `branch_id`) 
                VALUES (2,6,'$attend_id','$patient_id',3,'$date','$amount_nhis','$amount_nhis',0,
                '$lab_list_id','$lab_list_id','lab test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_dr);

                $query_cr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `lab_list_id`, `narration`, `branch_id`) 
                VALUES (6,2,'$attend_id','$patient_id',3,'$date','$amount_nhis',0,'$amount_nhis',
                '$lab_list_id','$lab_list_id','lab test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_cr);
            }
        }
        else
        {
            if ($amount_cash > 0)
            {
                $query_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
                `lab_list_id`, `narration`, `branch_id`) VALUES (1,6,'$attend_id','$patient_id',3,'$date',
                '$amount_cash','$amount_cash',0,'$lab_list_id','$lab_list_id',
                'lab test performed for cash','$branch_id')";
                mysqli_query($con, $query_dr);

                $query_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
                `lab_list_id`, `narration`, `branch_id`) VALUES (6,1,'$attend_id','$patient_id',3,'$date',
                '$amount_cash',0,'$amount_cash','$lab_list_id','$lab_list_id',
                'lab test performed for cash','$branch_id')";
                mysqli_query($con, $query_cr);

                 //AUTO ITEMISED RECEIPT
                    /*$query_receipt_deposit = "SELECT * FROM receipt WHERE attend_id='$attend_id' AND patient_id='$patient_id' AND type='Deposit' ORDER BY receipt_id ASC";
                    $result_receipt_deposit = mysqli_query($con,$query_receipt_deposit);
                    if (mysqli_num_rows($result_receipt_deposit) > 0)
                    {
                        while($row_receipt_deposit = mysqli_fetch_assoc($result_receipt_deposit))
                        {
                            $receipt_id = $row_receipt_deposit['receipt_id'];
                            $amount_deposited = $row_receipt_deposit['amount'];

                            $query_receipt_item = "SELECT SUM(amount_rec) AS total_itemised FROM receipt_items WHERE receipt_id='$receipt_id'";
                            $result_receipt_item = mysqli_query($con,$query_receipt_item);
                            if (mysqli_num_rows($result_receipt_item) > 0)
                            {
                                $row_receipt_item = mysqli_fetch_assoc($result_receipt_item);
                                $amount_itemised = $row_receipt_item['total_itemised'];
                            }
                            else
                            {
                                $amount_itemised = 0;
                            };
                                $deposit_balance = $amount_deposited - $amount_itemised;
                                $item_list_id = $lab_list_id;
                                $item_id = $lab_id;
                                $category_id = 3;
                                $qty = 1;
                                $price = $amount_cash;
                            if($deposit_balance > $amount_cash)
                            {
                                $amount_rec = $amount_cash;
                            }
                            else
                            {
                                $amount_rec = $deposit_balance;
                            };
                            if($amount_rec > 0)
                            {
                                $query_rec_item = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,`attend_id`, `date`, `qty`, `price`, 
                                `amount_bill`, `amount_rec`, `type`) VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$qty',
                                '$price','$amount_cash','$amount_rec','itemise')";
                                $query_run_rec_item = mysqli_query($con, $query_rec_item);
                            };
                        };
                    };*/
            }
            if ($amount_prvt > 0)
            {
                $query_dr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `lab_list_id`, `narration`, `branch_id`) 
                VALUES ('$prvt_led_id',6,'$attend_id','$patient_id',3,'$date','$amount_prvt','$amount_prvt',
                0,'$lab_list_id','$lab_list_id','lab test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_dr);

                $query_cr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `lab_list_id`, `narration`, `branch_id`) 
                VALUES (6,'$prvt_led_id','$attend_id','$patient_id',3,'$date','$amount_prvt',0,
                '$amount_prvt','$lab_list_id','$lab_list_id','lab test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_cr);
            }
            if ($amount_nhis > 0)
            {
                $query_dr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `lab_list_id`, `narration`, `branch_id`) 
                VALUES (2,6,'$attend_id','$patient_id',3,'$date','$amount_nhis','$amount_nhis',0,
                '$lab_list_id','$lab_list_id','lab test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_dr);

                $query_cr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `lab_list_id`, `narration`, `branch_id`) 
                VALUES (6,2,'$attend_id','$patient_id',3,'$date','$amount_nhis',0,'$amount_nhis',
                '$lab_list_id','$lab_list_id','lab test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_cr);
            }
        }
    };
}

function delete_lab_attend_check_perform()
{
    global $con;
    $Lab_Data = array();
    $lab_list_id = $_POST['lab_list_id'];
    $attend_id = $_POST['attend_id'];
    $query_lab_performed = "SELECT * FROM lab_param_list WHERE lab_list_id='$lab_list_id'";
    $query_run_lab_performed = mysqli_query($con, $query_lab_performed);
    if (mysqli_num_rows($query_run_lab_performed) > 0)
    {
        array_push($Lab_Data, 
            'performed',
            $_SESSION['user_type']
        );
    }
    else
    {
        array_push($Lab_Data, 
            'empty',
            $_SESSION['user_type']
        );
    };
}

function delete_lab_attend()
{
    global $con;
    $lab_list_id = $_POST['lab_list_id'];
    $attend_id = $_POST['attend_id'];
    $query = "DELETE FROM `lab_list` WHERE lab_list_id = '$lab_list_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=3 AND `item_list_id`='$lab_list_id'";
        mysqli_query($con, $query_trans_del);
        
        $query = "DELETE FROM `stat_incidence_of_diseases` WHERE lab_list_id='$lab_list_id'";
        $query_run = mysqli_query($con, $query);
        if ($query_run)
        {
            echo 'Deleted Successfully';
        };
    }
    else
    {
        echo 'Not Deleted';
    };
}

function lab_history()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $value = "";
    $query = "SELECT * FROM attendance WHERE patient_id='$patient_id' ORDER BY date_admit DESC";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        while($attend_list=mysqli_fetch_assoc($query_run))
        {
            $value.='<h6 class="m-0 font-weight-bold text-primary">'.$attend_list['date_admit'].'</h6>';
            $attend_id=$attend_list['attend_id'];
            $query = "SELECT * FROM lab_list WHERE attend_id='$attend_id'";
                    $query_run_ll = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run_ll) > 0)
                    {
                        while($lab_list=mysqli_fetch_assoc($query_run_ll))
                        {
                            $lab_id=$lab_list['lab_id'];
                            $lab_list_id=$lab_list['lab_list_id'];
                            $query = "SELECT * FROM lab WHERE lab_id='$lab_id'";
                            $query_run_lab = mysqli_query($con, $query);
                            $lab=mysqli_fetch_assoc($query_run_lab);
                $value.='<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel-body">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="lab_history_heading'.$lab_list_id.'">
                                        <h6 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_lab_history'.$lab_list_id.'" aria-expanded="true" aria-controls="collapse_lab_history'.$lab_list_id.'">
                                                <p>'.$lab['lab'].'</p>
                                            </a>
                                        </h6>
                                    </div>
                                    <div id="collapse_lab_history'.$lab_list_id.'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="lab_history_heading'.$lab_list_id.'">
                                        <div class="panel-body">
                                        <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                                                <thead>
                                                    <tr>
                                                        <th width="30%">Parameter</th>
                                                        <th width="15%">Result</th>
                                                        <th width="5%">Lower Range</th>
                                                        <th width="5%">Higher Range</th>
                                                        <th width="5%">Unit</th>
                                                        <th width="5%">Flag</th>
                                                        <th width="35%">Comment</th>
                                                    </tr>	
                                                </thead>
                                                <tbody class="pv-table-body">';
                                                $query = "SELECT * FROM lab_param_list WHERE lab_list_id='$lab_list_id'";
                                                    $query_run_lab_param_list = mysqli_query($con, $query);
                                                    if (mysqli_num_rows($query_run_lab_param_list) > 0)
                                                        {
                                                            while($row_lab_param_list=mysqli_fetch_assoc($query_run_lab_param_list))
                                                            {
                                                                $lab_param_id = $row_lab_param_list['lab_param_id'];
                                                                $query = "SELECT * FROM lab_param WHERE lab_param_id='$lab_param_id'";
                                                                $query_run_lab_param = mysqli_query($con, $query);
                                                                $row_lab_param=mysqli_fetch_assoc($query_run_lab_param);
                                                                $value.='
                                                                        <tr>
                                                                            <td>
                                                                                '.$row_lab_param['lab_param'].'
                                                                            </td>
                                                                            <td>
                                                                                '.$row_lab_param_list['result'].'
                                                                            </td>
                                                                            <td>
                                                                                '.$row_lab_param_list['low_range'].'
                                                                            </td>
                                                                            <td>
                                                                                '.$row_lab_param_list['high_range'].'
                                                                            </td>
                                                                            <td>
                                                                                '.$row_lab_param['unit'].'
                                                                            </td>
                                                                            <td>
                                                                                '.$row_lab_param_list['flag'].'
                                                                            </td>
                                                                            <td>
                                                                                '.$row_lab_param_list['comment'].'
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                        </tr>';
                                                            }
                                                        }
                            $value.='			</tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </div>
                        <div id="lab_list_img_history_display" class="scroll-card-img">';
                            $query_img = "SELECT * FROM `lab_img` WHERE `lab_list_id`= '$lab_list_id'";
                            $query_run_img = mysqli_query($con, $query_img);
                            if (mysqli_num_rows($query_run_img) > 0)
                            {
                                while($row_img = mysqli_fetch_assoc($query_run_img))
                                {
                                    $fileName = $row_img['img_url'];
                                    $fileExt = explode('.', $fileName);
                                    $fileActualExt = strtolower(end($fileExt));
                                    if($fileActualExt == 'pdf')
                                    {
                                        $value.='<iframe src="'.$row_img['img_url'].'" width="1000" height="1100"></iframe>';
                                    }
                                    else
                                    {
                                        $value.='<img src="'.$row_img['img_url'].'" width="1000" height="1100">';
                                    }
                                };
                            };
                            $value.='</div>
                        <hr class="d-none d-md-block">';
                        }
                    }
        }
        
    echo $value;
    }
    else
    {
        echo 'No Labs Found';
    }
}

function labs_attend_img_upload()
{
    global $con;
    if (isset($_POST['lab_list_img_save_btn'])) {
        $lab_list_id = $_POST['lab_list_id_img'];
        $lab_id = $_POST['lab_id_img'];
        $attend_id = $_POST['attend_id_img'];
        $patient_id = $_POST['patient_id_img'];
        $file = $_FILES['lab_list_file'];
        $fileName = $_FILES['lab_list_file']['name'];
        $fileType = $_FILES['lab_list_file']['type'];
        $fileError = $_FILES['lab_list_file']['error'];
        $fileSize = $_FILES['lab_list_file']['size'];
        $fileTmpName = $_FILES['lab_list_file']['tmp_name'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) 
                {
                    $fileNameNew = $attend_id.$lab_id.$lab_list_id."_".uniqid('',true).".".$fileActualExt;
                    //$fileNameNew = uniqid('',true).".".$fileActualExt;
                    $fileDestination = $_SERVER['DOCUMENT_ROOT'].'/img/labs/'.$fileNameNew;
                    $fileUrl = '/img/labs/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $query = "INSERT INTO `lab_img`(`lab_id`, `attend_id`, `patient_id`, `lab_list_id`, `img`, `img_url`) VALUES ('$lab_id','$attend_id', '$patient_id', '$lab_list_id','$fileDestination','$fileUrl')";
                    mysqli_query($con, $query);
                    header("Location: /layout/attendance/lab_sheet.php?uploadsuccess");
                } 
                else 
                {
                    echo "Your file is too big";
                }
                
            } 
            else 
            {
                echo "There was an error uploading your file";
            }
            
        }
        else
        {
            echo "You cannot upload files of this type";
        }
    } 
}

function labs_attend_img_display()
{
    global $con;
    
        $lab_list_id = $_POST['lab_list_id'];
        $lab_id = $_POST['lab_id'];
        $attend_id = $_POST['attend_id'];
        $patient_id = $_POST['patient_id'];
        $fileName = $attend_id.$lab_id.$lab_list_id;
        $img_list=array();
        $query = "SELECT * FROM `lab_img` WHERE `img`LIKE '%$fileName%'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            while($row=mysqli_fetch_assoc($query_run))
            {
                $fileName = $row['img_url'];
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));
                array_push($img_list, 
                    $row['img_url'],
                    $row['lab_img_id'],
                    $fileActualExt 
                );
            }
             echo json_encode($img_list);
        }
}

function lab_attend_img_display_clear()
{
    global $con;
        $lab_img_id = $_POST['lab_img_id'];
        $attend_id = $_POST['attend_id'];
        $query = "DELETE FROM `lab_img` WHERE `lab_img_id`='$lab_img_id'";
        $query_run = mysqli_query($con, $query);

        $query = "SELECT * FROM `lab_img` WHERE `attend_id`='$attend_id'";
        $query_run = mysqli_query($con, $query);
        $rows = mysqli_num_rows($query_run);
        echo $rows;
}

function lab_result_view()
{
    global $con;
    $lab_list_id = $_POST['lab_list_id'];
    $lab_id = $_POST['lab_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                <thead>
                    <tr>
                        <th width="30%">Parameter</th>
                        <th width="15%">Result</th>
                        <th width="5%">Lower Range</th>
                        <th width="5%">Higher Range</th>
                        <th width="5%">Unit</th>
                        <th width="5%">Flag</th>
                        <th width="35%">Comment</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM lab_param_list WHERE lab_list_id='$lab_list_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        while($row_lab_list=mysqli_fetch_assoc($query_run))
        {
            $lab_param_id = $row_lab_list['lab_param_id'];
            $query = "SELECT * FROM lab_param WHERE lab_param_id='$lab_param_id'";
            $result = mysqli_query($con, $query);
            $row_lab_param=mysqli_fetch_assoc($result);
            $value.='
                    <tr>
                        <td>
                            '.$row_lab_param['lab_param'].'
                        </td>
                        <td>
                            '.$row_lab_list['result'].'
                        </td>
                        <td>
                            '.$row_lab_list['low_range'].'
                        </td>
                        <td>
                            '.$row_lab_list['high_range'].'
                        </td>
                        <td>
                            '.$row_lab_param['unit'].'
                        </td>
                        <td>
                            '.$row_lab_list['flag'].'
                        </td>
                        <td>
                            '.$row_lab_list['comment'].'
                        </td>
                    </tr>';
        };
        $value.='</tbody>
        </table>';
    }
    echo $value;
}

function lab_result_edit()
{
    global $con;
    $lab_list_id = $_POST['lab_list_id'];
    $lab_id = $_POST['lab_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                <thead>
                    <tr>
                        <th width="30%">Parameter</th>
                        <th width="15%">Result</th>
                        <th width="5%">Lower Range</th>
                        <th width="5%">Higher Range</th>
                        <th width="5%">Unit</th>
                        <th width="5%">Flag</th>
                        <th width="35%">Comment</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM lab_param_list WHERE lab_list_id='$lab_list_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
        {
            $i=0;
            while($row_lab_list=mysqli_fetch_assoc($query_run))
            {
                $lab_param_id = $row_lab_list['lab_param_id'];
                $lab_param_list_id = $row_lab_list['lab_param_list_id'];
                $query = "SELECT * FROM lab_param WHERE lab_param_id='$lab_param_id'";
                $result = mysqli_query($con, $query);
                $row_lab_param=mysqli_fetch_assoc($result);
                $i=$i++;
                $value.='
                        <tr id="'.$i.'">
                            <td>
                                <input type="hidden" name="lab_list_id_re[]" class="form-control" id="lab_list_id_re" value="'.$lab_list_id.'">
                                <input type="hidden" name="lab_id_re[]" class="form-control" id="lab_id_re" value="'.$lab_id.'">
                                <input type="hidden" name="lab_param_id_re[]" class="form-control" id="lab_param_id_re" value="'.$lab_param_id.'">
                                <input type="hidden" name="lab_param_list_id_re[]" class="form-control" id="lab_param_list_id_re" value="'.$lab_param_list_id.'">
                                <input type="hidden" name="lab_attend_id_re[]" class="form-control" id="lab_attend_id_re" value="'.$attend_id.'">
                                <input type="hidden" name="lab_patient_id_re[]" class= id="lab_patient_id_re" value="'.$patient_id.'">
                                '.$row_lab_param['lab_param'].'
                            </td>
                            <td>';
                                $sql="SELECT * FROM lab_param_dropdown WHERE lab_param_id='$lab_param_id'";
                                $result=mysqli_query($con,$sql);
                                if (mysqli_num_rows($result) > 0)
                                {
                                    $value.='<select name="lab_attend_result_re[]" id="lab_attend_result_re" style="border-width:0px"> 
                                    <option value="0">Please Select</option>';
                                        while($row_param_dd=mysqli_fetch_array($result))
                                        {
                                            $value.='<option value = "'.$row_param_dd['lab_param_dropdown'].'"';
                                                if($row_lab_list['result']==$row_param_dd['lab_param_dropdown'])
                                                {
                                                    $value.='selected="selected">'.$row_param_dd['lab_param_dropdown'].'</option>';
                                                }
                                                else
                                                {
                                                    $value.='>'.$row_param_dd['lab_param_dropdown'].'</option>';
                                                }
                                        } 
                                        $value.='</select>';
                                }
                                else{
                                    $value.='<input type="text" name="lab_attend_result_re[]" id="lab_attend_result_re" style="border-width:0px" value="'.$row_lab_list['result'].'">';
                                }
                            $value.='</td>
                            <td>
                                <input type="hidden" name="lower_range_re[]" class="form-control" id="lower_range_re" value="'.$row_lab_param['low_range'].'">
                                '.$row_lab_param['low_range'].'
                            </td>
                            <td>
                                <input type="hidden" name="higher_range_re[]" class="form-control" id="higher_range_re" value="'.$row_lab_param['high_range'].'">
                                '.$row_lab_param['high_range'].'
                            </td>
                            <td>
                                <input type="hidden" name="unit_re[]" class="form-control" id="unit_re" value="'.$row_lab_param['unit'].'">
                                '.$row_lab_param['unit'].'
                            </td>
                            <td>
                                <input type="text" name="flag_re[]" id="flag_re" style="border-width:0px" size="10" value="'.$row_lab_list['flag'].'">
                            </td>
                            <td>
                                <input type="text" name="comment_re[]" id="comment_re" style="border-width:0px" size="50" value="'.$row_lab_list['comment'].'">
                            </td>
                        </tr>';
            };
            $value.='</tbody>
            </table>';
        }
    echo $value;
}

function lab_result_update()
{
    global $con;
    $number = count($_POST["lab_param_id_re"]);  
     if($number > 0)  
     {  
          for($i=0; $i<$number; $i++)  
          {  
               if(trim($_POST["lab_param_id_re"][$i] != ''))  
               {  
                    $lab_list_id = $_POST['lab_list_id_re'][$i];
                    $lab_param_id = $_POST['lab_param_id_re'][$i];
                    $lab_param_list_id = $_POST['lab_param_list_id_re'][$i];
                    $lab_id = $_POST['lab_id_re'][$i];
                    $attend_id = $_POST['lab_attend_id_re'][$i];
                    $patient_id = $_POST['lab_patient_id_re'][$i];
                    $result = $_POST['lab_attend_result_re'][$i];
                    $flag = $_POST['flag_re'][$i];
                    $comment = $_POST['comment_re'][$i];
                    $lower = $_POST['lower_range_re'][$i];
                    $higher = $_POST['higher_range_re'][$i];

                    $query = "UPDATE `lab_param_list` SET `lab_param_id`='$lab_param_id',`lab_id`='$lab_id',`lab_list_id`='$lab_list_id',`attend_id`='$attend_id',`patient_id`='$patient_id',`low_range`='$lower',`high_range`='$higher',`result`='$result',`comment`='$comment',`flag`='$flag' WHERE `lab_param_list_id`='$lab_param_list_id'";
                    $query_run = mysqli_query($con, $query);
               }  
          }
          echo "Data Updated";  
     }  
     else  
     {  
          echo "Data NOT Updated";  
     }  
}

function lab_report()
{
    global $con;
    $_SESSION['attend_id'] = $_POST['attend_id'];
    $_SESSION['patient_id'] = $_POST['patient_id'];
}

function set_lab_price()
{
    global $con;
    $price_list=array();
    $sponsor_id = $_POST['sponsor_id'];
    $lab_id = $_POST['lab_id'];
    $query = "SELECT * FROM lab WHERE lab_id='$lab_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        while($row_cash=mysqli_fetch_assoc($query_run))
        {
            $cash_price = $row_cash['price_cash'];
            $nhis_id = $row_cash['nhis_id'];
        }
    };

    if ($sponsor_id == 1)
    {
        $price = "";
        $price_adult = "";
        $price_child = "";
        $price_topup = "";
        $price_prvt = "";
        $price_prvt_topup = "";
        $remark = 'cash';
        array_push($price_list, $cash_price,$price,$price_adult,$price_child,$price_topup,$price_prvt,$price_prvt_topup,$remark);
        echo json_encode($price_list);
    }
    else if ($sponsor_id == 2)
    {
        $query = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            while($row_nhis=mysqli_fetch_assoc($query_run))
            {
                $cash_price = "";
                $price = $row_nhis['price'];
                $price_adult = $row_nhis['price_adult'];
                $price_child = $row_nhis['price_child'];
                $price_topup = $row_nhis['price_topup'];
                $price_prvt = "";
                $price_prvt_topup = "";
                $remark = 'nhia';
            }
            array_push($price_list, $cash_price,$price,$price_adult,$price_child,$price_topup,$price_prvt,$price_prvt_topup,$remark);
            echo json_encode($price_list);
        }
        else
        {
            $price = "";
            $price_adult = "";
            $price_child = "";
            $price_topup = "";
            $price_prvt = "";
            $price_prvt_topup = "";
            $remark = 'nhia_na';
            array_push($price_list, $cash_price,$price,$price_adult,$price_child,$price_topup,$price_prvt,$price_prvt_topup,$remark);
            echo json_encode($price_list);
        }
    }
    else if ($sponsor_id !== 1 && $sponsor_id !== 2)
    {
        $query = "SELECT * FROM price_list WHERE ledger_id='$sponsor_id' AND item_id='$lab_id' AND category_id=3";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            while($row_pl=mysqli_fetch_assoc($query_run))
            {
                $cash_price = "";
                $price = "";
                $price_adult = "";
                $price_child = "";
                $price_topup = "";
                $price_prvt = $row_pl['price'];
                $price_prvt_topup = $row_pl['price_topup'];
                $remark = 'private_list';
            }
           array_push($price_list, $cash_price,$price,$price_adult,$price_child,$price_topup,$price_prvt,$price_prvt_topup,$remark);
            echo json_encode($price_list);
        }
        else
        {
            $price = "";
            $price_adult = "";
            $price_child = "";
            $price_topup = "";
            $price_prvt = "";
            $price_prvt_topup = "";
            $remark = 'private_no_list';
            array_push($price_list, $cash_price,$price,$price_adult,$price_child,$price_topup,$price_prvt,$price_prvt_topup,$remark);
            echo json_encode($price_list);
        };
    };
}

function lab_print_status()
{
    global $con;
    $lab_list_id = $_POST['lab_list_id'];
    $lab_print_status = $_POST['print_status'];
    
    $query = "UPDATE `lab_list` SET `print_status`='$lab_print_status' WHERE `lab_list_id`='$lab_list_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "lab Updated Successfully";
    }
    else
    {
        echo "lab NOT Updated";
    };
}

function lab_bill_status()
{
    global $con;
    $lab_list_id = $_POST['lab_list_id'];
    $bill_status = $_POST['bill_status'];
    
    $query = "UPDATE `lab_list` SET `bill`='$bill_status' WHERE `lab_list_id`='$lab_list_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "lab Updated Successfully";
    }
    else
    {
        echo "lab NOT Updated";
    };
}

function lab_request_process()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $Data = array();
    $query = "SELECT * FROM lab_request WHERE attend_id = '$attend_id'";
    $result = mysqli_query($con,$query);
    
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $patient_id = $row['patient_id'];
            $query_patient = "SELECT * FROM patients WHERE patient_id='$patient_id'";
            $result_patient = mysqli_query($con,$query_patient);
            $row_patient = mysqli_fetch_array($result_patient);
            
            array_push($Data, 
                $row['lab_request_id'],
                $row['patient_id'],
                $row['doctor'],
                $row['diagnosis'],
                $row['age'],
                $row['lab_test'],
                $row['date'],
                $row['specimen'],
                $row['specimen_date'],
                $row['clinical_summary'],
                $row_patient['gender'],
                'exist'
            );
        }
        echo json_encode($Data);
    }
    else
    {
        $query_attend = "SELECT * FROM attendance WHERE attend_id = '$attend_id'";
        $result_attend = mysqli_query($con, $query_attend);
        if(mysqli_num_rows($result_attend) > 0)
        {
            while($row_attend = mysqli_fetch_assoc($result_attend))
            {
                $patient_id = $row_attend['patient_id'];
                $query_patient = "SELECT * FROM patients WHERE patient_id='$patient_id'";
                $result_patient = mysqli_query($con,$query_patient);
                $row_patient = mysqli_fetch_array($result_patient);
                $gender = $row_patient['gender'];

                if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0)
                {
                    $user_id = $_SESSION['user_id'];
                    $query_user = "SELECT * FROM users WHERE id = '$user_id'";
                    $result_user = mysqli_query($con,$query_user);
                    if(mysqli_num_rows($result_user) > 0)
                    {
                        while($row_user = mysqli_fetch_assoc($result_user))
                        {
                            $user_name = $row_user['first_name'].' '.$row_user['last_name'];
                        };
                    }
                    else
                    {
                        $user_id = $row_attend['doctor_id'];
                        $query_user = "SELECT * FROM users WHERE id = '$user_id'";
                        $result_user = mysqli_query($con,$query_user);
                        if(mysqli_num_rows($result_user) > 0)
                        {
                            while($row_user = mysqli_fetch_assoc($result_user))
                            {
                                $user_name = $row_user['first_name'].' '.$row_user['last_name'];
                            };
                        }
                        else
                        {
                            $user_name = 'Please Enter Doctors Name';
                        };
                    };
                }
                else
                {
                    $user_id = $row_attend['doctor_id'];
                };

                $query_diag_list = "SELECT * FROM diagnosis_list WHERE attend_id = '$attend_id'";
                $result_diag_list = mysqli_query($con, $query_diag_list);
                
                if(mysqli_num_rows($result_diag_list) > 0)
                {
                    $diagnosis_list = '';
                    $i = 0;
                    while($row_diag_list = mysqli_fetch_assoc($result_diag_list))
                    {
                        $diagnosis_id = $row_diag_list['diagnosis_id'];
                        $query_diag = "SELECT * FROM diagnosis WHERE diagnosis_id = '$diagnosis_id'";
                        $result_diag = mysqli_query($con, $query_diag);
                        
                        if(mysqli_num_rows($result_diag) > 0)
                        {
                            while($row_diag = mysqli_fetch_assoc($result_diag))
                            {
                                $diagnosis = $row_diag['diagnosis'];
                            };
                        }
                        else
                        {
                            $diagnosis = 'N/A';
                        };

                        ++$i;
                        if($i < 2)
                        {
                            $diagnosis_list = $diagnosis;
                        }
                        else
                        {
                            $diagnosis_list = $diagnosis_list.', '.$diagnosis;
                        };
                    };
                }
                else
                {
                    $diagnosis_list = 'N/A';
                };

                $query_lab_list = "SELECT * FROM lab_list WHERE attend_id = '$attend_id'";
                $result_lab_list = mysqli_query($con, $query_lab_list);
                
                if(mysqli_num_rows($result_lab_list) > 0)
                {
                    $lab_list = '';
                    $i = 0;
                    while($row_lab_list = mysqli_fetch_assoc($result_lab_list))
                    {
                        $lab_id = $row_lab_list['lab_id'];
                        $query_lab = "SELECT * FROM lab WHERE lab_id = '$lab_id'";
                        $result_lab = mysqli_query($con, $query_lab);
                        
                        if(mysqli_num_rows($result_lab) > 0)
                        {
                            while($row_lab = mysqli_fetch_assoc($result_lab))
                            {
                                $lab = $row_lab['lab'];
                            };
                        }
                        else
                        {
                            $lab = 'N/A';
                        };

                        ++$i;
                        if($i < 2)
                        {
                            $lab_list = $lab;
                        }
                        else
                        {
                            $lab_list = $lab_list.', '.$lab;
                        };
                    };
                }
                else
                {
                    $lab_list = 'N/A';
                };
                array_push($Data, 
                    0,
                    $row_attend['patient_id'],
                    $user_name,
                    $diagnosis_list,
                    $row_attend['age'],
                    $lab_list,
                    $row_attend['date_admit'],
                    'N/A',
                    $row_attend['date_admit'],
                    'N/A',
                    $gender,
                    'new'
                );
            }
            echo json_encode($Data);
        }
    };
}

function lab_request_save()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $doctor = $_POST['lab_request_doctor'];
    $diagnosis = $_POST['lab_request_diagnosis'];
    $date = $_POST['lab_request_date'];
    $lab_test = $_POST['lab_request_test'];
    $age = $_POST['lab_request_age'];
    $specimen = $_POST['lab_request_specimen'];
    $specimen_date = $_POST['lab_request_specimen_date'];
    $clinical_summary = $_POST['lab_request_clinical_summary'];
    $gender = $_POST['lab_request_gender'];
    $lab_request_id = $_POST['lab_request_id'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO `lab_request`(
    `company_id`, `attend_id`, `patient_id`, `doctor`, `age`, `date`, 
    `lab_test`, `specimen`, `specimen_date`, `diagnosis`, `clinical_summary`, 
    `user_id`, `created_by`, `created_datetime`, `gender_id`) VALUES (
    '$company_id','$attend_id','$patient_id','$doctor','$age','$date',
    '$lab_test','$specimen','$specimen_date','$diagnosis','$clinical_summary',
    '$user_id','$user_id',NOW(),'$gender')";
    $query_run = mysqli_query($con, $query);
    
    if ($query_run)
    {
        $query_lrq = "SELECT * FROM lab_request ORDER BY lab_request_id DESC";
        $result_lrq = mysqli_query($con,$query_lrq);
        $row_lrq = mysqli_fetch_assoc($result_lrq);
        $_SESSION['lab_request_id'] = $row_lrq['lab_request_id'];
    };
}

function lab_request_update()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $doctor = $_POST['lab_request_doctor'];
    $diagnosis = $_POST['lab_request_diagnosis'];
    $date = $_POST['lab_request_date'];
    $lab_test = $_POST['lab_request_test'];
    $age = $_POST['lab_request_age'];
    $specimen = $_POST['lab_request_specimen'];
    $specimen_date = $_POST['lab_request_specimen_date'];
    $clinical_summary = $_POST['lab_request_clinical_summary'];
    $gender = $_POST['lab_request_gender'];
    $lab_request_id = $_POST['lab_request_id'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `lab_request` SET 
    `company_id`='$company_id', `attend_id`='$attend_id', `patient_id`='$patient_id', `doctor`='$doctor', `age`='$age', `date`='$date', 
    `lab_test`='$lab_test', `specimen`='$specimen', `specimen_date`='$specimen_date', `diagnosis`='$diagnosis', `clinical_summary`='$clinical_summary', 
    `user_id`='$user_id', `gender_id`='$gender', `altered_by`='$user_id', `altered_datetime`=NOW() WHERE `lab_request_id`='$lab_request_id'";
    $query_run = mysqli_query($con, $query);
    
    if ($query_run)
    {
        $_SESSION['lab_request_id'] = $lab_request_id;
    };
}

function search_lab_attend()
{
    global $con;
    $search = $_POST['search'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Lab</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';

                if(isset($_POST["search"]))
                {
                    $query = "SELECT *  FROM `lab` WHERE `lab` LIKE '%".$search."%'";
                    $query_run = mysqli_query($con,$query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                <td>
                                    <a href="#" id="btn_save_lab_search_item" 
                                        data-id="'.$row['lab_id'].'"
                                        data-id1="'.$row['price_cash'].'"
                                        data-id2="'.$row['price_private'].'"
                                    >'.$row['lab'].'</a>
                                </td>
                            </tr>';
                        };
                    };
                };

    $value.='</tbody>
            </table>';
    echo $value;
}


?>
