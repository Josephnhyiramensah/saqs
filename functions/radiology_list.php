<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//RADIOLOGY
function check_radio_attend_duplicate()
{
    global $con;
    $radio_id = $_POST['radio_id'];
    $attend_id = $_POST['radio_attend_id'];
    $radio_dup=array();
    $query = "SELECT * FROM radio_list WHERE radio_id='$radio_id' AND attend_id='$attend_id'";
    $result = mysqli_query($con,$query);
        if (mysqli_num_rows($result) > 0)
        {
            $query_radio = "SELECT * FROM radiology WHERE radio_id='$radio_id'";
            $result_radio = mysqli_query($con,$query_radio);
            $row_radio=mysqli_fetch_assoc($result_radio);

            array_push($radio_dup, 'duplicate',$row_radio['radiology']);
        }
        else
        {
             array_push($radio_dup, 'none');

        }
    echo json_encode($radio_dup);
}

function save_radio_attend()
{
    global $con;
    $radio_id = $_POST['radio_id'];
    $radio_attend_id = $_POST['radio_attend_id'];
    $radio_patient_id = $_POST['radio_patient_id'];
    $radio_date = $_POST['radio_date'];
    $radio_qty = $_POST['radio_qty'];
    $radio_sponsor = $_POST['radio_sponsor'];
    $radio_price_est = $_POST['radio_price_est'];
    $radio_amt_est = $_POST['radio_amt_est'];
    $radio_comment = $_POST['radio_comment'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO `radio_list`(`company_id`, `radio_id`, `attend_id`, `patient_id`, 
    `date`,`qty`, `price_est`, `amount_est`, `ledger_id`, `comment`, `user_id`, `created_by`, 
    `created_datetime`, `branch_id`) 
    VALUES ('$company_id','$radio_id','$radio_attend_id', '$radio_patient_id',
    '$radio_date','$radio_qty','$radio_price_est', '$radio_amt_est','$radio_sponsor',
    '$radio_comment','$user_id','$user_id',NOW(),'$branch_id')";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        if ($_SESSION['user_type_id'] == 6) 
        {
            doctor_attend_register();
        };
        echo "radio Added Successfully";
    }
    else
    {
        echo "radio NOT Added";
    };
}

function radio_list_param_count()
{
    global $con;
    $radio_list_id = $_POST['radio_list_id'];
    $query_param = "SELECT radio_param_list_id FROM radio_param_list WHERE radio_list_id='$radio_list_id'";
    $query_run_param = mysqli_query($con, $query_param);
    $rows=mysqli_num_rows($query_run_param);
    echo $rows;
}

function edit_radio_attend()
{
    global $con;
    $radio_list_id = $_POST['radio_list_id'];
    $radio_data=array();
    $query = "SELECT * FROM `radio_list` WHERE `radio_list_id`='$radio_list_id'";
    $result = mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($radio_data, 
            $row['date'],
            $row['radio_id'],
            $row['attend_id'],
            $row['patient_id'],
            $row['radio_list_id'],
            $row['comment'],
            $row['qty'],
            $row['price_est'],
            $row['amount_est'],
            $row['ledger_id']
        );
    }
     echo json_encode($radio_data);
}

function update_radio_attend()
{
    global $con;
    $radio_id = $_POST['radio_id'];
    $radio_attend_id = $_POST['radio_attend_id'];
    $radio_patient_id = $_POST['radio_patient_id'];
    $radio_date = $_POST['radio_date'];
    $radio_qty = $_POST['radio_qty'];
    $radio_sponsor = $_POST['radio_sponsor'];
    $radio_price_est = $_POST['radio_price_est'];
    $radio_amt_est = $_POST['radio_amt_est'];
    $radio_comment = $_POST['radio_comment'];
    $radio_list_id = $_POST['radio_list_id'];
    
    $query = "UPDATE `radio_list` SET 
            `attend_id`='$radio_attend_id',`patient_id`='$radio_patient_id',`radio_id`='$radio_id',`comment`='$radio_comment',
            `qty`='$radio_qty',`price_est`='$radio_price_est',`amount_est`='$radio_amt_est',`ledger_id`='$radio_sponsor',`date`='$radio_date'
            WHERE `radio_list_id`='$radio_list_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        echo "Radiology Updated Successfully";
    }
    else
    {
        echo "Radiology NOT Updated";
    };
}

function view_current_radio_attend()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $query = "SELECT * FROM radio_list WHERE attend_id='$attend_id' ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
    date_default_timezone_set("Africa/Accra");
    $date_today = date('Y-m-d');
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="action-td">Date</th>
                        <th class="action-td">Radiology Item</th>';
                    
                        if (
                                $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                $_SESSION['user_type'] == 'Super_User' OR 
                                ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
                            {
                                $value .='
                                <th class="action-td">Amt-Estimate</th>
                                <th class="action-td">Amt-Cash</th>
                                <th class="action-td">Amt-Disc</th>
                                <th class="action-td">Amt-Prvt</th>
                                <th class="action-td">Amt-NHIS</th>';
                            };
                    
                        $value .='<th class="action-td">Action</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
        
                $total_est=0;
                $total_cash=0;
                $total_disc=0;
                $total_prvt=0;
                $total_nhis=0;
            if (mysqli_num_rows($query_run) > 0)
            {
                $amt_est=0;
                $amt_cash=0;
                $amt_disc=0;
                $amt_prvt=0;
                $amt_nhis=0;
                while($row=mysqli_fetch_assoc($query_run))
                {
                    $radio_id = $row['radio_id'];
                    $query_radio = "SELECT radiology FROM radiology WHERE radio_id='$radio_id'";
                    $query_run_radio = mysqli_query($con, $query_radio);
                    $row_radio=mysqli_fetch_assoc($query_run_radio);

                    $radio_list_id = $row['radio_list_id'];
                    $query_disc = "SELECT SUM(amount) AS amount FROM discount WHERE radio_list_id='$radio_list_id'";
                    $query_run_disc = mysqli_query($con, $query_disc);
                    $row_disc = mysqli_fetch_assoc($query_run_disc);
                    if (isset($row_disc))
                    {
                        $amt_disc = $row_disc['amount'];
                    } else {
                        $amt_disc = 0;
                    };
                    
                        $value .='<tr>
                            <td class="action-td">'.$row['date'].'</td>
                            <td>'.$row_radio['radiology'].'</td>';
                    
                        if (
                                $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                $_SESSION['user_type'] == 'Super_User' OR 
                                ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
                        {
                            $value .='
                            <td class="amt-td">'.$row['amount_est'].'</td>
                            <td class="amt-td">'.$row['amount_cash'].'</td>
                            <td class="amt-td">'.$amt_disc.'</td>
                            <td class="amt-td">'.$row['amount_prvt'].'</td>
                            <td class="amt-td">'.$row['amount_nhis'].'</td>';
                        };
                
                        $value .='<td class="action-td">';
                            
                                $total_est+=$row['amount_est'];
                                $total_cash+=$row['amount_cash'];
                                $total_disc+=$amt_disc;
                                $total_prvt+=$row['amount_prvt'];
                                $total_nhis+=$row['amount_nhis'];

                                $query_img = "SELECT radio_img_id FROM radio_img WHERE radio_list_id='$radio_list_id'";
                                $query_run_img = mysqli_query($con, $query_img);
                                $row_imgs=mysqli_num_rows($query_run_img);

                                $query_param = "SELECT radio_param_list_id FROM radio_param_list WHERE radio_id='$radio_id' AND attend_id='$attend_id' AND radio_list_id='$radio_list_id'";
                                $query_run_param = mysqli_query($con, $query_param);
                                if (mysqli_num_rows($query_run_param) > 0)
                                {
                                    $row_param=mysqli_fetch_assoc($query_run_param);
                    
                                    if (
                                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                        $_SESSION['user_type'] == 'Super_User' OR 
                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Radiology_Result'] == 'Yes')) 
                                    {
                                        $value .='<a href="#" id="btn_radio_result_perform_edit" 
                                            data-id="'.$row['radio_list_id'].'"
                                            data-id1="'.$row['radio_id'].'">
                                            Edit Result
                                        </a>';
                                    };

                                    if (
                                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                        $_SESSION['user_type'] == 'Super_User' OR 
                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Radiology_Result'] == 'Yes')) 
                                    {
                                        $value .=' | 
                                        <a href="#" id="btn_radio_result_view" 
                                            data-id="'.$row['radio_list_id'].'"
                                            data-id1="'.$row['radio_id'].'">
                                            View Result
                                        </a>';
                                    };

                                    if (
                                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                        $_SESSION['user_type'] == 'Super_User' OR 
                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Upload_Radiology_Result_Image'] == 'Yes')) 
                                    {
                                        $value .=' | 
                                        <a href="#" id="btn_radio_img_upload" data-id6="'.$row['radio_list_id'].'"
                                            data-id7="'.$row['radio_id'].'">
                                            Upload Image
                                        </a>';
                                    };
                                        
                                            if ($row_imgs > 0)
                                            {
                                        
                                                    if (
                                                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                                        $_SESSION['user_type'] == 'Super_User' OR 
                                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Uploaded_Radiology_Result_Image'] == 'Yes')) 
                                                    {
                                                        $value .=' | 
                                                        <a href="#" id="btn_radio_img_view" 
                                                        data-id2="'.$row['radio_list_id'].'"
                                                        data-id3="'.$row['radio_id'].'">
                                                        View Image
                                                        </a>';
                                                    };
                                        
                                            };
                                }
                                else
                                {
                                    if (
                                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                        $_SESSION['user_type'] == 'Super_User' OR 
                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Enter_Radiology_Result_Internal'] == 'Yes')) 
                                    {
                                        $value .=' <a href="#" id="btn_radio_result_perform_enter" 
                                        data-id="'.$row['radio_list_id'].'"
                                        data-id1="'.$row['radio_id'].'" 
                                        data-id2="'.$row['ledger_id'].'">
                                        Enter Result
                                        </a>';
                                    };

                                    if (
                                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                        $_SESSION['user_type'] == 'Super_User' OR 
                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Enter_Radiology_Result_External'] == 'Yes')) 
                                    {
                                        $value .=' | 
                                        <a href="#" id="btn_radio_result_enter" 
                                            data-id4="'.$row['radio_list_id'].'"
                                            data-id5="'.$row['radio_id'].'">
                                            Enter Ext. Result
                                        </a>';
                                    };

                                    if (
                                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                        $_SESSION['user_type'] == 'Super_User' OR 
                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Upload_Radiology_Result_Image'] == 'Yes')) 
                                    {
                                        $value .=' | 
                                        <a href="#" id="btn_radio_img_upload" data-id6="'.$row['radio_list_id'].'"
                                            data-id7="'.$row['radio_id'].'">
                                            Upload Image
                                            </a>';
                                    };

                                    if ($row_imgs > 0)
                                    {
                                        if (
                                            $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                            $_SESSION['user_type'] == 'Super_User' OR 
                                            ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Uploaded_Radiology_Result_Image'] == 'Yes')) 
                                        {
                                            $value .=' | 
                                            <a href="#" id="btn_radio_img_view" data-id2="'.$row['radio_list_id'].'"
                                            data-id3="'.$row['radio_id'].'">
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
                                $value .=' <a href="#" id="btn_discount_radio_list"
                                class="data-toggle="tooltip" data-placement="left" title="Discount Radiology"" 
                                data-id="'.$row['attend_id'].'"
                                data-id1="'.$_SESSION['patient_id'].'"
                                data-id2="'.$row['radio_list_id'].'"
                                data-id3="'.$_SESSION['name'].'"
                                data-id4="'.$row['amount_cash'].'"
                                data-id5="'.$amt_disc.'">
                                    Disc.
                                </a>';
                            };
                            
                            if ($_SESSION['user_id'] == $row['user_id']) 
                            {
                                if($row['date'] == $date_today)
                                {
                                    if (
                                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                        $_SESSION['user_type'] == 'Super_User' OR 
                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Radiology_List'] == 'Yes')) 
                                    {
                                        $value .=' |
                                        <a href="#" id="btn_edit_radio_attend" 
                                            data-id12="'.$row['radio_list_id'].'"
                                            data-id13="'.$row['radio_id'].'">
                                            Edit
                                        </a>';
                                    };
                                    if (
                                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                                        $_SESSION['user_type'] == 'Super_User' OR 
                                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Radiology_List'] == 'Yes')) 
                                    {
                                        $value .=' |
                                        <a href="#" id="btn_delete_radio_attend" 
                                            data-id8="'.$row['radio_list_id'].'"
                                            data-id9="'.$row['radio_id'].'">
                                            Delete
                                        </a>';
                                    };
                                };
                            };
                            
                            $value .='</td>
                    </tr>';
            
                };
                if (
                        $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                        $_SESSION['user_type'] == 'Super_User' OR 
                        ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
                {
                    $value .='<tr>
                        <td class="action-td" colspan="2">TOTAL</td>
                        <td class="amt-td">'.$total_est.'</td>
                        <td class="amt-td">'.$total_cash.'</td>
                        <td class="amt-td">'.$total_disc.'</td>
                        <td class="amt-td">'.$total_prvt.'</td>
                        <td class="amt-td">'.$total_nhis.'</td>
                        <td></td>
                    </tr>';
                };
            };
        
        $value .='</tbody>
    </table>';
        echo $value;
}

function radio_result_enter()
{
    global $con;
    $radio_list_id = $_POST['radio_list_id'];
    $radio_id = $_POST['radio_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                <thead>
                    <tr>
                        <th width="30%">Parameter</th>
                        <th width="15%">Result</th>
                        <th width="35%">Comment</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM radio_param WHERE radio_id='$radio_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        $i=0;
        while($row=mysqli_fetch_assoc($query_run))
        {
            $radio_param_id = $row['radio_param_id'];
            $i=$i++;
            $value.='
                    <tr id="'.$i.'">
                        <td>
                            <input type="hidden" name="radio_list_id_re[]" class="form-control" id="radio_list_id_re" value="'.$radio_list_id.'">
                            <input type="hidden" name="radio_id_re[]" class="form-control" id="radio_id_re" value="'.$radio_id.'">
                            <input type="hidden" name="radio_param_id_re[]" class="form-control" id="radio_param_id_re" value="'.$row['radio_param_id'].'">
                            <input type="hidden" name="radio_attend_id_re[]" class="form-control" id="radio_attend_id_re" value="'.$attend_id.'">
                            <input type="hidden" name="radio_patient_id_re[]" class= id="radio_patient_id_re" value="'.$patient_id.'">
                            '.$row['radio_param'].'
                        </td>
                        <td>';
                            $sql="SELECT * FROM radio_param_dropdown WHERE radio_param_id='$radio_param_id'";
                            $result=mysqli_query($con,$sql);
                            if (mysqli_num_rows($result) > 0)
                            {
                                $value.='<select name="radio_attend_result_re[]" id="radio_attend_result_re" style="border-width:0px"> 
                                <option value="0">Please Select</option>';
                                    while($row_param_dd=mysqli_fetch_array($result))
                                    {
                                    $value.='<option value = "'.$row_param_dd['radio_param_dd'].'" >'
                                        .$row_param_dd['radio_param_dd'].'</option>';
                                    } 
                                    $value.='</select>';
                            }
                            else
                            {
                                $value.='<input type="text" name="radio_attend_result_re[]" id="radio_attend_result_re" style="border-width:0px">';
                            }
                        $value.='</td>
                        <td>
                            <input type="text" name="comment_re[]" id="comment_re" style="border-width:0px" size="50">
                        </td>
                    </tr>';
        };
        $value.='</tbody>
        </table>';
    };
    echo $value;
}

function radio_result_save()
{
    global $con;
    $number = count($_POST["radio_param_id_re"]);  
     if($number > 0)  
     {  
          for($i=0; $i<$number; $i++)  
          {  
               if(trim($_POST["radio_param_id_re"][$i] != ''))  
               {  
                    $radio_list_id = $_POST['radio_list_id_re'][$i];
                    $radio_param_id = $_POST['radio_param_id_re'][$i];
                    $radio_id = $_POST['radio_id_re'][$i];
                    $attend_id = $_POST['radio_attend_id_re'][$i];
                    $patient_id = $_POST['radio_patient_id_re'][$i];
                    $result = $_POST['radio_attend_result_re'][$i];
                    $comment = $_POST['comment_re'][$i];
                    $company_id = $_SESSION['company_id'];
                    $branch_id = $_SESSION['branch_id'];
                    $user_id = $_SESSION['user_id'];
                    $query = "INSERT INTO `radio_param_list`(`radio_param_id`, `radio_id`, `attend_id`, 
                    `patient_id`, `radio_list_id`, `result`, `comment`, `user_id`, `created_by`, 
                    `created_datetime`, `company_id`, `branch_id`) VALUES ('$radio_param_id','$radio_id',
                    '$attend_id','$patient_id','$radio_list_id','$result','$comment','$user_id',
                    '$user_id',NOW(),'$company_id','$branch_id')";
                    mysqli_query($con, $query);
               }  
          }
          echo "Data Inserted";  
     }  
     else  
     {  
          echo "Data NOT Inserted";  
     }  
}

function radio_result_perform_enter()
{
    global $con;
    $radio_list_id = $_POST['radio_list_id'];
    $radio_id = $_POST['radio_id'];
    $radio_sponsor = $_POST['radio_sponsor'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    //$prvt_led_id = $_POST['prvt_led_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                <thead>
                    <tr>
                        <th width="30%">Parameter</th>
                        <th width="15%">Result</th>
                        <th width="35%">Comment</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM radio_param WHERE radio_id='$radio_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
        {
            $i=0;
            while($row=mysqli_fetch_assoc($query_run))
            {
                $radio_param_id = $row['radio_param_id'];
                $i=$i++;
                $value.='
                        <tr id="'.$i.'">
                            <td>
                                <input type="hidden" name="radio_list_id_re[]" class="form-control" id="radio_list_id_re" value="'.$radio_list_id.'">
                                <input type="hidden" name="radio_id_re[]" class="form-control" id="radio_id_re" value="'.$radio_id.'">
                                <input type="hidden" name="radio_sponsor_re[]" class="form-control" id="radio_sponsor_re" value="'.$radio_sponsor.'">
                                <input type="hidden" name="radio_param_id_re[]" class="form-control" id="radio_param_id_re" value="'.$row['radio_param_id'].'">
                                <input type="hidden" name="radio_attend_id_re[]" class="form-control" id="radio_attend_id_re" value="'.$attend_id.'">
                                <input type="hidden" name="radio_patient_id_re[]" class= id="radio_patient_id_re" value="'.$patient_id.'">
                                <input type="hidden" name="radio_prvt_led_id_re[]" class= id="radio_prvt_led_id_re" value="'.$radio_sponsor.'">
                                '.$row['radio_param'].'
                            </td>
                            <td>';
                                $sql="SELECT * FROM radio_param_dropdown WHERE radio_param_id='$radio_param_id'";
                                $result=mysqli_query($con,$sql);
                                if (mysqli_num_rows($result) > 0)
                                {
                                    $value.='<select name="radio_attend_result_re[]" id="radio_attend_result_re" style="border-width:0px"> 
                                    <option value="0">Please Select</option>';
                                        while($row_param_dd=mysqli_fetch_array($result))
                                        {
                                        $value.='<option value = "'.$row_param_dd['radio_param_dd'].'" >'
                                            .$row_param_dd['radio_param_dd'].'</option>';
                                        } 
                                        $value.='</select>';
                                }
                                else{
                                    $value.='<input type="text" name="radio_attend_result_re[]" id="radio_attend_result_re" style="border-width:0px">';
                                }
                            $value.='</td>
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

function radio_result_perform_save()
{
    global $con;
    $number = count($_POST["radio_param_id_re"]);  
    if($number > 0)  
    {  
        for($i=0; $i<$number; $i++)  
        {  
           if(trim($_POST["radio_param_id_re"][$i] != ''))  
           {  
                $radio_list_id = $_POST['radio_list_id_re'][$i];
                $radio_param_id = $_POST['radio_param_id_re'][$i];
                $radio_id = $_POST['radio_id_re'][$i];
                $sponsor_id = $_POST['radio_sponsor_re'][$i];
                $prvt_led_id = $_POST['radio_prvt_led_id_re'][$i];
                $attend_id = $_POST['radio_attend_id_re'][$i];
                $patient_id = $_POST['radio_patient_id_re'][$i];
                $result = $_POST['radio_attend_result_re'][$i];
                $comment = $_POST['comment_re'][$i];
                $company_id = $_SESSION['company_id'];
                $branch_id = $_SESSION['branch_id'];
                $user_id = $_SESSION['user_id'];
                $query = "INSERT INTO `radio_param_list`(`radio_param_id`, `radio_id`, `attend_id`, `patient_id`,
                `radio_list_id`, `result`, `comment`, `user_id`, `created_by`, `created_datetime`.
                `company_id`, `branch_id`) 
                VALUES ('$radio_param_id','$radio_id','$attend_id','$patient_id','$radio_list_id','$result',
                '$comment','$user_id','$user_id',NOW(),'$company_id','$branch_id')";
                $query_run = mysqli_query($con, $query);
           }  
        }

    //SET PRICE
          $query = "SELECT * FROM radiology WHERE radio_id='$radio_id'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            while($row_cash=mysqli_fetch_assoc($query_run))
            {
                $cash_price = $row_cash['price_cash'];
                $price_private = $row_cash['price_private'];
                $price_private_topup = $row_cash['price_private_topup'];
                $price_nhis_topup = $row_cash['price_nhis_topup'];
                $nhis_id = $row_cash['nhis_id'];
            }
        };
        if ($sponsor_id == 1)
        {
            $query = "UPDATE `radio_list` SET `performed`=1,`price_cash`='$cash_price',`price_prvt`=0,`price_nhis`=0,`amount_cash`='$cash_price',`amount_prvt`=0,`amount_nhis`=0 WHERE `radio_list_id`='$radio_list_id'";
            $query_run = mysqli_query($con, $query);
        }
        else if ($sponsor_id == 2)
        {
            $query = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
            $query_run = mysqli_query($con, $query);
            if (mysqli_num_rows($query_run) > 0)
            {
                while($row_nhis=mysqli_fetch_assoc($query_run))
                {
                    $price_adult = $row_nhis['price_adult'];
                    $price_child = $row_nhis['price_child'];
                    $price_topup = $row_nhis['price_topup'];
                    $price = $row_nhis['price'];
                }
                $query = "UPDATE `radio_list` SET `performed`=1,`price_cash`='$price_topup',`price_prvt`=0,`price_nhis`='$price',`amount_cash`='$price_topup',`amount_prvt`=0,`amount_nhis`='$price' WHERE `radio_list_id`='$radio_list_id'";
                $query_run = mysqli_query($con, $query);
            }
            else
            {
                $query = "UPDATE `radio_list` SET `performed`=1,`price_cash`='$cash_price',`price_prvt`=0,`price_nhis`=0,`amount_cash`='$cash_price',`amount_prvt`=0,`amount_nhis`=0, `ledger_id`=1  WHERE `radio_list_id`='$radio_list_id'";
                $query_run = mysqli_query($con, $query);
            };
        }
        else if ($sponsor_id !== 1 && $sponsor_id !== 2)
        {
            $query = "SELECT * FROM price_list WHERE ledger_id='$sponsor_id' AND item_id='$radio_id' AND category_id=4";
            $query_run = mysqli_query($con, $query);
            if (mysqli_num_rows($query_run) > 0)
            {
                while($row_pl=mysqli_fetch_assoc($query_run))
                {
                    $price_prvt = $row_pl['price'];
                    $price_prvt_topup = $row_pl['price_topup'];
                }
                       $query = "UPDATE `radio_list` SET `performed`=1,`price_cash`='$price_prvt_topup',`price_prvt`='$price_prvt',`price_nhis`=0,`amount_cash`='$price_prvt_topup',`amount_prvt`='$price_prvt',`amount_nhis`=0 WHERE `radio_list_id`='$radio_list_id'";
                    $query_run = mysqli_query($con, $query);
            }
            else
            {
                if($price_private > 0)
                {
                    $query = "UPDATE `radio_list` SET `performed`=1,`price_cash`=0,`price_prvt`='$price_private',
                    `price_nhis`=0,`amount_cash`=0,`amount_prvt`='$price_private',`amount_nhis`=0 
                    WHERE `radio_list_id`='$radio_list_id'";
                }
                else
                {
                    $query = "UPDATE `radio_list` SET `performed`=1,`price_cash`=0,`price_prvt`='$cash_price',
                    `price_nhis`=0,`amount_cash`=0,`amount_prvt`='$cash_price',`amount_nhis`=0 
                    WHERE `radio_list_id`='$radio_list_id'";
                };
                $query_run = mysqli_query($con, $query);
            };
        };

    //POST TRANSACTION
        $query_radio_list = "SELECT * FROM `radio_list` WHERE `radio_list_id`='$radio_list_id'";
        $query_run_radio_list = mysqli_query($con, $query_radio_list);
        $row_radio_list=mysqli_fetch_assoc($query_run_radio_list);
        $amount_cash = $row_radio_list['amount_cash'];
        $amount_prvt = $row_radio_list['amount_prvt'];
        $amount_nhis = $row_radio_list['amount_nhis'];
        $date = $row_radio_list['date'];

        $query_trans = "SELECT * FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=4 AND `item_list_id`='$radio_list_id'";
        $query_run_trans = mysqli_query($con, $query_trans);
        if (mysqli_num_rows($query_run_trans) > 0)
        {
            $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=4 AND `item_list_id`='$radio_list_id'";
            mysqli_query($con, $query_trans_del);
            if ($amount_cash > 0)
            {
                $query_dr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, 
                `amt`, `amt_debit`, `amt_credit`, `item_list_id`, `radio_list_id`, `narration`, `branch_id`) 
                VALUES (1,7,'$attend_id','$patient_id',4,'$date','$amount_cash','$amount_cash',0,
                '$radio_list_id','$radio_list_id','radiology test performed for cash','$branch_id')";
                mysqli_query($con, $query_dr);

                $query_cr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `radio_list_id`, `narration`, `branch_id`) 
                VALUES (7,1,'$attend_id','$patient_id',4,'$date','$amount_cash',0,'$amount_cash',
                '$radio_list_id','$radio_list_id','radiology test performed for cash','$branch_id')";
                mysqli_query($con, $query_cr);

                //AUTO ITEMISED RECEIPT
                    $query_receipt_deposit = "SELECT * FROM receipt WHERE attend_id='$attend_id' AND patient_id='$patient_id' AND type='Deposit' ORDER BY receipt_id ASC";
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
                                $item_list_id = $radio_list_id;
                                $item_id = $radio_id;
                                $category_id = 4;
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
                    };
            }
            if ($amount_prvt > 0)
            {
                $query_dr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `radio_list_id`, `narration`, `branch_id`) 
                VALUES ('$prvt_led_id',7,'$attend_id','$patient_id',4,'$date','$amount_prvt','$amount_prvt',
                0,'$radio_list_id','$radio_list_id','radiology test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_dr);

                $query_cr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `radio_list_id`, `narration`, `branch_id`) 
                VALUES (7,'$prvt_led_id','$attend_id','$patient_id',4,'$date','$amount_prvt',0,'$amount_prvt',
                '$radio_list_id','$radio_list_id','radiology test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_cr);
            }
            if ($amount_nhis > 0)
            {
                $query_dr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `radio_list_id`, `item_list_id`, `narration`, `branch_id`) 
                VALUES (2,7,'$attend_id','$patient_id',4,'$date','$amount_nhis','$amount_nhis',0,
                '$radio_list_id','$radio_list_id','radiology test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_dr);

                $query_cr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `radio_list_id`, `narration`, `branch_id`) 
                VALUES (7,2,'$attend_id','$patient_id',4,'$date','$amount_nhis',0,'$amount_nhis',
                '$radio_list_id','$radio_list_id','radiology test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_cr);
            };
        }
        else
        {
            if ($amount_cash > 0)
            {
                $query_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
                `radio_list_id`, `narration`, `branch_id`) VALUES (1,7,'$attend_id','$patient_id',4,'$date',
                '$amount_cash','$amount_cash',0,'$radio_list_id','$radio_list_id',
                'radiology test performed for cash','$branch_id')";
                mysqli_query($con, $query_dr);
                
                $query_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
                `patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
                `radio_list_id`, `narration`, `branch_id`) VALUES (7,1,'$attend_id','$patient_id',4,
                '$date','$amount_cash',0,'$amount_cash','$radio_list_id','$radio_list_id',
                'radiology test performed for cash','$branch_id')";
                mysqli_query($con, $query_cr);

                //AUTO ITEMISED RECEIPT
                    $query_receipt_deposit = "SELECT * FROM receipt WHERE attend_id='$attend_id' AND patient_id='$patient_id' AND type='Deposit' ORDER BY receipt_id ASC";
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
                                $item_list_id = $radio_list_id;
                                $item_id = $radio_id;
                                $category_id = 4;
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
                    };
            }
            if ($amount_prvt > 0)
            {
                $query_dr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `radio_list_id`, `narration`, `branch_id`) 
                VALUES ('$prvt_led_id',7,'$attend_id','$patient_id',4,'$date','$amount_prvt','$amount_prvt',
                0,'$radio_list_id','$radio_list_id','radiology test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_dr);

                $query_cr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `radio_list_id`, `narration`, `branch_id`) 
                VALUES (7,'$prvt_led_id','$attend_id','$patient_id',4,'$date','$amount_prvt',0,'$amount_prvt',
                '$radio_list_id','$radio_list_id','radiology test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_cr);
            }
            if ($amount_nhis > 0)
            {
                $query_dr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `radio_list_id`, `narration`, `branch_id`) 
                VALUES (2,7,'$attend_id','$patient_id',4,'$date','$amount_nhis','$amount_nhis',0,
                '$radio_list_id','$radio_list_id','radiology test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_dr);

                $query_cr = "INSERT INTO `transactions`(
                `ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
                `amt_debit`, `amt_credit`, `item_list_id`, `radio_list_id`, `narration`, `branch_id`) 
                VALUES (7,2,'$attend_id','$patient_id',4,'$date','$amount_nhis',0,'$amount_nhis',
                '$radio_list_id','$radio_list_id','radiology test performed for NHIS','$branch_id')";
                mysqli_query($con, $query_cr);
            };
        };
    };
}

function radio_result_view()
{
    global $con;
    $radio_list_id = $_POST['radio_list_id'];
    $radio_id = $_POST['radio_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                <thead>
                    <tr>
                        <th width="30%">Parameter</th>
                        <th width="15%">Result</th>
                        <th width="35%">Comment</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM radio_param_list WHERE radio_list_id='$radio_list_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
        {
            while($row_radio_list = mysqli_fetch_assoc($query_run))
            {
                $radio_param_id = $row_radio_list['radio_param_id'];
                $query = "SELECT * FROM radio_param WHERE radio_param_id='$radio_param_id'";
                $result = mysqli_query($con, $query);
                $row_radio_param = mysqli_fetch_assoc($result);
                $value.='
                        <tr>
                            <td>
                                '.$row_radio_param['radio_param'].'
                            </td>
                            <td>
                                '.$row_radio_list['result'].'
                            </td>
                            <td>
                                '.$row_radio_list['comment'].'
                            </td>
                        </tr>';
            };
            $value.='</tbody>
            </table>';
        }
    echo $value;
}

   function radio_result_edit()
{
    global $con;
    $radio_list_id = $_POST['radio_list_id'];
    $radio_id = $_POST['radio_id'];
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                <thead>
                    <tr>
                        <th width="30%">Parameter</th>
                        <th width="15%">Result</th>
                        <th width="35%">Comment</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    $query = "SELECT * FROM radio_param_list WHERE radio_list_id='$radio_list_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        $i=0;
        while($row_radio_list=mysqli_fetch_assoc($query_run))
        {
            $radio_param_id = $row_radio_list['radio_param_id'];
            $radio_param_list_id = $row_radio_list['radio_param_list_id'];
            $query = "SELECT * FROM radio_param WHERE radio_param_id='$radio_param_id'";
            $result = mysqli_query($con, $query);
            $row_radio_param=mysqli_fetch_assoc($result);
            $i = $i++;
            $value.='<tr id="'.$i.'">
                <td>
                    <input type="hidden" name="radio_list_id_re[]" class="form-control" id="radio_list_id_re" value="'.$radio_list_id.'">
                    <input type="hidden" name="radio_id_re[]" class="form-control" id="radio_id_re" value="'.$radio_id.'">
                    <input type="hidden" name="radio_param_id_re[]" class="form-control" id="radio_param_id_re" value="'.$radio_param_id.'">
                    <input type="hidden" name="radio_param_list_id_re[]" class="form-control" id="radio_param_list_id_re" value="'.$radio_param_list_id.'">
                    <input type="hidden" name="radio_attend_id_re[]" class="form-control" id="radio_attend_id_re" value="'.$attend_id.'">
                    <input type="hidden" name="radio_patient_id_re[]" class= id="radio_patient_id_re" value="'.$patient_id.'">
                    '.$row_radio_param['radio_param'].'
                </td>
                <td>';
                    $sql = "SELECT * FROM radio_param_dropdown WHERE radio_param_id = '$radio_param_id'";
                    $result = mysqli_query($con,$sql);
                    if (mysqli_num_rows($result) > 0)
                    {
                        $value.='<select name="radio_attend_result_re[]" id="radio_attend_result_re" style="border-width:0px"> 
                        <option value="0">Please Select</option>';
                        while($row_param_dd = mysqli_fetch_array($result))
                        {
                            if($row_param_dd !='' && $row_param_dd['radio_param_dd'] !='')
                            {
                                $value.='<option value = "'.$row_param_dd['radio_param_dd'].'"';
                                if($row_radio_list['result'] == $row_param_dd['radio_param_dd'])
                                {
                                    $value.='selected="selected">'.$row_param_dd['radio_param_dd'].'</option>';
                                }
                                else
                                {
                                    $value.='>'.$row_param_dd['radio_param_dd'].'</option>';
                                };
                            };
                        };
                        $value.='</select>';
                    }
                    else
                    {
                        $value.='<input type="text" name="radio_attend_result_re[]" id="radio_attend_result_re" style="border-width:0px" value="'.$row_radio_list['result'].'">';
                    }
                $value.='</td>
                <td>
                    <input type="text" name="comment_re[]" id="comment_re" style="border-width:0px" size="50" value="'.$row_radio_list['comment'].'">
                </td>
            </tr>';
        };
        $value.='</tbody>
        </table>';
    }
    echo $value;
}

function radio_result_update()
{
    global $con;
    $number = count($_POST["radio_param_id_re"]);  
     if($number > 0)  
     {  
          for($i=0; $i<$number; $i++)  
          {  
               if(trim($_POST["radio_param_id_re"][$i] != ''))  
               {  
                    $radio_list_id = $_POST['radio_list_id_re'][$i];
                    $radio_param_id = $_POST['radio_param_id_re'][$i];
                    $radio_param_list_id = $_POST['radio_param_list_id_re'][$i];
                    $radio_id = $_POST['radio_id_re'][$i];
                    $attend_id = $_POST['radio_attend_id_re'][$i];
                    $patient_id = $_POST['radio_patient_id_re'][$i];
                    $result = $_POST['radio_attend_result_re'][$i];
                    $comment = $_POST['comment_re'][$i];
                    $user_id = $_SESSION['user_id'];

                    $query = "UPDATE `radio_param_list` SET `radio_param_id`='$radio_param_id',
                    `radio_id`='$radio_id',`radio_list_id`='$radio_list_id',`attend_id`='$attend_id',
                    `patient_id`='$patient_id',`result`='$result',`comment`='$comment',
                    `altered_by`='$user_id',`altered_datetime`=NOW() WHERE `radio_param_list_id`='$radio_param_list_id'";
                    mysqli_query($con, $query);
               }  
          }
          echo "Data Updated";
     }  
     else  
     {  
          echo "Data NOT Updated";  
     }  
}

function radio_history()
{
    global $con;
    $patient_id = $_POST['patient_id'];
    $value = "";
    $query = "SELECT * FROM attendance WHERE patient_id='$patient_id' ORDER BY date_admit DESC";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        while($attend_list = mysqli_fetch_assoc($query_run))
        {
            $value.='<h6 class="m-0 font-weight-bold text-primary">'.$attend_list['date_admit'].'</h6>';
            $attend_id = $attend_list['attend_id'];
            $query = "SELECT * FROM radio_list WHERE attend_id='$attend_id'";
            $query_run_rl = mysqli_query($con, $query);
            if (mysqli_num_rows($query_run_rl) > 0)
            {
                while($radio_list = mysqli_fetch_assoc($query_run_rl))
                {
                    $radio_id = $radio_list['radio_id'];
                    $radio_list_id = $radio_list['radio_list_id'];
                    $query = "SELECT * FROM radiology WHERE radio_id='$radio_id'";
                    $query_run_radio = mysqli_query($con, $query);
                    $radio = mysqli_fetch_assoc($query_run_radio);
                    $value.='<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="radio_history_heading'.$radio_list_id.'">
                                    <h6 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_radio_history'.$radio_list_id.'" aria-expanded="true" aria-controls="collapse_radio_history'.$radio_list_id.'">
                                            <p>'.$radio['radiology'].'</p>
                                        </a>
                                    </h6>
                                </div>
                                <div id="collapse_radio_history'.$radio_list_id.'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="radio_history_heading'.$radio_list_id.'">
                                    <div class="panel-body">
                                    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                                            <thead>
                                                <tr>
                                                    <th width="30%">Parameter</th>
                                                    <th width="50%">Result</th>
                                                    <th width="20%">Comment</th>
                                                </tr>	
                                            </thead>
                                            <tbody class="pv-table-body">';
                                            $query = "SELECT * FROM radio_param_list WHERE radio_list_id='$radio_list_id'";
                                            $query_run_radio_param_list = mysqli_query($con, $query);
                                            if (mysqli_num_rows($query_run_radio_param_list) > 0)
                                            {
                                                while($row_radio_param_list = mysqli_fetch_assoc($query_run_radio_param_list))
                                                {
                                                    $radio_param_id = $row_radio_param_list['radio_param_id'];
                                                    $query = "SELECT * FROM radio_param WHERE radio_param_id='$radio_param_id'";
                                                    $query_run_radio_param = mysqli_query($con, $query);
                                                    $row_radio_param=mysqli_fetch_assoc($query_run_radio_param);
                                                    $value.='<tr>
                                                        <td>
                                                            '.$row_radio_param['radio_param'].'
                                                        </td>
                                                        <td>
                                                            '.$row_radio_param_list['result'].'
                                                        </td>
                                                        <td>
                                                            '.$row_radio_param_list['comment'].'
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    </tr>';
                                                };
                                            };
                                    $value.='</tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </div>
                    <div id="radio_list_img_history_display" class="scroll-card-body">';
                        $query_img = "SELECT * FROM `radio_img` WHERE `radio_list_id`= '$radio_list_id'";
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
                };
            };
        };
        
    echo $value;
    }
    else
    {
        echo 'No Radiology Found';
    }
}

function radio_attend_img_upload()
{
    global $con;
    if (isset($_POST['radio_list_img_save_btn'])) {
        $radio_list_id = $_POST['radio_list_id_img'];
        $radio_id = $_POST['radio_id_img'];
        $attend_id = $_POST['attend_id_img'];
        $patient_id = $_POST['patient_id_img'];
        $file = $_FILES['radio_list_file'];
        $fileName = $_FILES['radio_list_file']['name'];
        $fileType = $_FILES['radio_list_file']['type'];
        $fileError = $_FILES['radio_list_file']['error'];
        $fileSize = $_FILES['radio_list_file']['size'];
        $fileTmpName = $_FILES['radio_list_file']['tmp_name'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $fileNameNew = $attend_id.$radio_id.$radio_list_id."_".uniqid('',true).".".$fileActualExt;
                    //$fileNameNew = uniqid('',true).".".$fileActualExt;
                    $fileDestination = $_SERVER['DOCUMENT_ROOT'].'/img/radio/'.$fileNameNew;
                    $fileUrl = '/img/radio/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $query = "INSERT INTO `radio_img`(`radio_id`, `attend_id`, `patient_id`, `radio_list_id`, `img`, `img_url`) VALUES ('$radio_id','$attend_id', '$patient_id', '$radio_list_id','$fileDestination','$fileUrl')";
                    mysqli_query($con, $query);
                    header("Location: /layout/attendance/radio_sheet.php?uploadsuccess");
                } else {
                    echo "Your file is too big";
                }
                
            } else {
                echo "There was an error uploading your file";
            }
            
        }
        else
        {
            echo "You cannot upload files of this type";
        }
    } 
}

function radio_attend_img_display()
{
    global $con;
        $radio_list_id = $_POST['radio_list_id'];
        $radio_id = $_POST['radio_id'];
        $attend_id = $_POST['attend_id'];
        $patient_id = $_POST['patient_id'];
        $fileName = $attend_id.$radio_id.$radio_list_id;
        $img_list = array();
        $query = "SELECT * FROM `radio_img` WHERE `img`LIKE '%$fileName%'";
        $query_run = mysqli_query($con, $query);
        if (mysqli_num_rows($query_run) > 0)
        {
            while($row = mysqli_fetch_assoc($query_run))
            {
                $fileName = $row['img_url'];
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));
                array_push($img_list, 
                    $row['img_url'],
                    $row['radio_img_id'],
                    $fileActualExt 
                );
            }
             echo json_encode($img_list);
        }
}

function radio_attend_img_display_clear()
{
    global $con;
        $radio_img_id = $_POST['radio_img_id'];
        $attend_id = $_POST['attend_id'];
        $query = "DELETE FROM `radio_img` WHERE `radio_img_id`='$radio_img_id'";
        $query_run = mysqli_query($con, $query);

        $query = "SELECT * FROM `radio_img` WHERE `attend_id`='$attend_id'";
        $query_run = mysqli_query($con, $query);
        $rows = mysqli_num_rows($query_run);
        echo $rows;
}

function set_radio_price()
{
    global $con;
    $price_list=array();
    $sponsor_id = $_POST['sponsor_id'];
    $radio_id = $_POST['radio_id'];
    $query = "SELECT * FROM radiology WHERE radio_id='$radio_id'";
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
        $query = "SELECT * FROM price_list WHERE ledger_id='$sponsor_id' AND item_id='$radio_id' AND category_id=4";
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

function delete_radio_attend()
{
    global $con;
    $radio_list_id = $_POST['radio_list_id'];
    $attend_id = $_POST['attend_id'];
    $query = "DELETE FROM `radio_list` WHERE radio_list_id='$radio_list_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        $query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=4 AND `item_list_id`='$radio_list_id'";
        mysqli_query($con, $query_trans_del);
    }
    else
    {
        echo "Radiology NOT Deleted";
    };
}

function radio_request_process()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $Data = array();
    $query = "SELECT * FROM radio_request WHERE attend_id = '$attend_id'";
    $result = mysqli_query($con,$query);
    
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            array_push($Data, 
                $row['radio_request_id'],
                $row['patient_id'],
                $row['doctor'],
                $row['diagnosis'],
                $row['age'],
                $row['radiology'],
                $row['date'],
                $row['problem'],
                $row['comment'],
                $row['clinical_summary'],
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

                $query_radio_list = "SELECT * FROM radio_list WHERE attend_id = '$attend_id'";
                $result_radio_list = mysqli_query($con, $query_radio_list);
                
                if(mysqli_num_rows($result_radio_list) > 0)
                {
                    $lab_list = '';
                    $i = 0;
                    while($row_radio_list = mysqli_fetch_assoc($result_radio_list))
                    {
                        $radio_id = $row_radio_list['radio_id'];
                        $query_radio = "SELECT * FROM radiology WHERE radio_id = '$radio_id'";
                        $result_radio = mysqli_query($con, $query_radio);
                        
                        if(mysqli_num_rows($result_radio) > 0)
                        {
                            while($row_radio = mysqli_fetch_assoc($result_radio))
                            {
                                $radio = $row_radio['radiology'];
                            };
                        }
                        else
                        {
                            $radio = 'N/A';
                        };

                        ++$i;
                        if($i < 2)
                        {
                            $radio_list = $radio;
                        }
                        else
                        {
                            $radio_list = $radio_list.', '.$radio;
                        };
                    };
                }
                else
                {
                    $radio_list = 'N/A';
                };

                array_push($Data, 
                    0,
                    $row_attend['patient_id'],
                    $user_name,
                    $diagnosis_list,
                    $row_attend['age'],
                    $radio_list,
                    $row_attend['date_admit'],
                    'N/A',
                    'N/A',
                    'N/A',
                    'new'
                );
            }
            echo json_encode($Data);
        }
    };
}

function radio_request_save()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $doctor = $_POST['radio_request_doctor'];
    $diagnosis = $_POST['radio_request_diagnosis'];
    $diagnosis = addslashes($diagnosis);
    $date = $_POST['radio_request_date'];
    $radio_test = $_POST['radio_request_test'];
    $age = $_POST['radio_request_age'];
    $problem = $_POST['radio_request_problem'];
    $problem = addslashes($problem);
    $comment = $_POST['radio_request_comment'];
    $comment = addslashes($comment);
    $clinical_summary = $_POST['radio_request_clinical_summary'];
    $clinical_summary = addslashes($clinical_summary);
    $radio_request_id = $_POST['radio_request_id'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO `radio_request`(
    `company_id`, `attend_id`, `patient_id`, `doctor`, `age`, `date`, 
    `radiology`, `problem`, `comment`, `diagnosis`, `clinical_summary`, 
    `user_id`, `created_by`, `created_datetime`) VALUES (
    '$company_id','$attend_id','$patient_id','$doctor','$age','$date',
    '$radio_test','$problem','$comment','$diagnosis','$clinical_summary',
    '$user_id','$user_id',NOW())";
    $query_run = mysqli_query($con, $query);
    if ($query_run)
    {
        $query_lrq = "SELECT * FROM radio_request ORDER BY radio_request_id DESC";
        $result_lrq = mysqli_query($con,$query_lrq);
        $row_lrq = mysqli_fetch_assoc($result_lrq);
        $_SESSION['radio_request_id'] = $row_lrq['radio_request_id'];
    };
}

function radio_request_update()
{
    global $con;
    $attend_id = $_POST['attend_id'];
    $patient_id = $_POST['patient_id'];
    $doctor = $_POST['radio_request_doctor'];
    $diagnosis = $_POST['radio_request_diagnosis'];
    $diagnosis = addslashes($diagnosis);
    $date = $_POST['radio_request_date'];
    $radio_test = $_POST['radio_request_test'];
    $age = $_POST['radio_request_age'];
    $problem = $_POST['radio_request_problem'];
    $problem = addslashes($problem);
    $comment = $_POST['radio_request_comment'];
    $comment = addslashes($comment);
    $clinical_summary = $_POST['radio_request_clinical_summary'];
    $clinical_summary = addslashes($clinical_summary);
    $radio_request_id = $_POST['radio_request_id'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE `radio_request` SET 
    `company_id`='$company_id', `attend_id`='$attend_id', `patient_id`='$patient_id', 
    `doctor`='$doctor', `age`='$age', `date`='$date', `radiology`='$radio_test', 
    `problem`='$problem', `comment`='$comment', `diagnosis`='$diagnosis', 
    `clinical_summary`='$clinical_summary', `user_id`='$user_id', `altered_by`='$user_id', 
    `altered_datetime`=NOW() WHERE `radio_request_id`='$radio_request_id'";
    $query_run = mysqli_query($con, $query);
    
    if ($query_run)
    {
        $_SESSION['radio_request_id'] = $radio_request_id;
    };
}

function radio_report()
{
    global $con;
    $_SESSION['attend_id'] = $_POST['attend_id'];
    $_SESSION['patient_id'] = $_POST['patient_id'];
}

function search_radio_attend()
{
    global $con;
    $search = $_POST['search'];
    $value = "";
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Radiology</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';
    if(isset($_POST["search"]))
    {
        $query = "SELECT *  FROM `radiology` WHERE `radiology` LIKE '%".$search."%'";
        $query_run = mysqli_query($con,$query);
        if (mysqli_num_rows($query_run) > 0)
        {
            while($row = mysqli_fetch_assoc($query_run))
            {
                $value.='
                        <tr>
                            <td>
                                <a href="#" id="btn_save_radio_search_item" 
                                    data-id="'.$row['radio_id'].'"
                                    data-id1="'.$row['price_cash'].'"
                                >'.$row['radiology'].'</a></td>
                        </tr>';
            };
        };
    
    };
    $value.='</tbody>
            </table>';
    echo $value;
}

?>
