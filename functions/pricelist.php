<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//PRICELIST
function new_price_list()
{
    global $con;
    $ledger_id = $_POST['ledger_id'];
    $value = "";
    $i=0;
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                <thead>
                    <tr>
                        <th width="70%">Description</th>
                        <th width="15%">Price</th>
                        <th width="15%">Top-Up</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';

                $query = "SELECT * FROM services";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $value.='
                        <tr style="background-color:#E4E1E0">
                            <td colspan="3">
                                <strong>SERVICES</strong>
                            </td>
                        </tr>';
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $service_id = $row['service_id'];
                        $i=$i++;
                        $value.='
                                <tr id="'.$i.'">
                                    <td>
                                        <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                                        <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$service_id.'">
                                        <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="1">
                                        '.$row['service'].'
                                    </td>
                                    <td>
                                        <input type="text" name="price[]" id="price" style="border-width:0px">
                                    </td>
                                    <td>
                                        <input type="text" name="top_up[]" id="top_up" style="border-width:0px">
                                    </td>
                                </tr>';
                    };
                };

                $query = "SELECT * FROM drugs";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $value.='
                        <tr style="background-color:#E4E1E0">
                            <td colspan="3">
                                <strong>DRUGS</strong>
                            </td>
                        </tr>';
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $drug_id = $row['drug_id'];
                        $i=$i++;
                        $value.='
                                <tr id="'.$i.'">
                                    <td>
                                        <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                                        <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$drug_id.'">
                                        <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="2">
                                        '.$row['brand_name'].'
                                    </td>
                                    <td>
                                        <input type="text" name="price[]" id="price" style="border-width:0px">
                                    </td>
                                    <td>
                                        <input type="text" name="top_up[]" id="top_up" style="border-width:0px">
                                    </td>
                                </tr>';
                    };
                };

                $query = "SELECT * FROM lab";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $value.='
                        <tr style="background-color:#E4E1E0">
                            <td colspan="3">
                                <strong>LABS</strong>
                            </td>
                        </tr>';
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $lab_id = $row['lab_id'];
                        $i=$i++;
                        $value.='
                                <tr id="'.$i.'">
                                    <td>
                                        <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                                        <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$lab_id.'">
                                        <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="3">
                                        '.$row['lab'].'
                                    </td>
                                    <td>
                                        <input type="text" name="price[]" id="price" style="border-width:0px">
                                    </td>
                                    <td>
                                        <input type="text" name="top_up[]" id="top_up" style="border-width:0px">
                                    </td>
                                </tr>';
                    };
                };

                $query = "SELECT * FROM radiology";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $value.='
                        <tr style="background-color:#E4E1E0">
                            <td colspan="3">
                                <strong>RADIOLOGY</strong>
                            </td>
                        </tr>';
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $radio_id = $row['radio_id'];
                        $i=$i++;
                        $value.='
                                <tr id="'.$i.'">
                                    <td>
                                        <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                                        <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$radio_id.'">
                                        <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="4">
                                        '.$row['radiology'].'
                                    </td>
                                    <td>
                                        <input type="text" name="price[]" id="price" style="border-width:0px">
                                    </td>
                                    <td>
                                        <input type="text" name="top_up[]" id="top_up" style="border-width:0px">
                                    </td>
                                </tr>';
                    };
                };

                $query = "SELECT * FROM surgery";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $value.='
                        <tr style="background-color:#E4E1E0">
                            <td colspan="3">
                                <strong>SURGERY/PROCEDURE</strong>
                            </td>
                        </tr>';
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $surgery_id = $row['surgery_id'];
                        $i=$i++;
                        $value.='
                                <tr id="'.$i.'">
                                    <td>
                                        <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                                        <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$surgery_id.'">
                                        <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="5">
                                        '.$row['surgery'].'
                                    </td>
                                    <td>
                                        <input type="text" name="price[]" id="price" style="border-width:0px">
                                    </td>
                                    <td>
                                        <input type="text" name="top_up[]" id="top_up" style="border-width:0px">
                                    </td>
                                </tr>';
                    };
                };

                $value.='</tbody>
            </table>';
            echo $value;
}

function save_price_list()
{
    global $con;
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $branch_id = $_SESSION['branch_id'];
    $number = count($_POST["ledger_id"]);
    
    if($number > 0)
    {  
        for($i=0; $i<$number; $i++)
        {  
            if(trim($_POST["ledger_id"][$i]) != '')
            {  
                $ledger_id = $_POST['ledger_id'][$i];
                $item_id = $_POST['item_id'][$i];
                $category_id = $_POST['category_id'][$i];
                $price = $_POST['price'][$i];
                $top_up = $_POST['top_up'][$i];
                $query = "INSERT INTO `price_list`(`ledger_id`, `item_id`, `category_id`, `price`, 
                `price_topup`,`created_by`,`created_datetime`,`company_id`,`user_id`,`branch_id`) VALUES ('$ledger_id',
                '$item_id','$category_id','$price','$top_up','$user_id',NOW(),'$company_id','$user_id','$branch_id')";
                $query_run = mysqli_query($con, $query);
            };
        };
        echo "Data Inserted";  
    }  
    else  
    {  
        echo "Data NOT Inserted";  
    };
}

function edit_price_list()
{
    global $con;
    $ledger_id = $_POST['ledger_id'];
    $value = "";
    $i=0;
    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                <thead>
                    <tr>
                        <th width="70%">Description</th>
                        <th width="15%">Price</th>
                        <th width="15%">Top-Up</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';

    $query = "SELECT * FROM services";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        $value.='
            <tr style="background-color:#E4E1E0">
                <td colspan="3">
                    <strong>SERVICES</strong>
                </td>
            </tr>';
        while($row=mysqli_fetch_assoc($query_run))
        {
            $service_id = $row['service_id'];
            $query_service = "SELECT * FROM price_list WHERE ledger_id='$ledger_id' AND 
            item_id='$service_id' AND category_id=1";
            $query_run_service = mysqli_query($con, $query_service);
            if (mysqli_num_rows($query_run_service) > 0)
            {
                $row_service=mysqli_fetch_assoc($query_run_service);
                $price = $row_service['price'];
                $top_up = $row_service['price_topup'];
                $price_list_id = $row_service['id'];
                
                $i=$i++;
                $value.='
                <tr id="'.$i.'">
                    <td>
                        '.$row['service'].'
                        <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                        <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$service_id.'">
                        <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="1">
                        <input type="hidden" name="price_list_id[]" value="'.$price_list_id.'" class="form-control" id="price_list_id">
                        </td>
                        <td>
                            <input type="text" name="price[]" id="price" value="'.$price.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="top_up[]" id="top_up" value="'.$top_up.'" style="border-width:0px">
                        </td>';
            }
            else
            {
                $i=$i++;
                $value.='
                <tr id="'.$i.'">
                    <td>
                        '.$row['service'].'
                        <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                        <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$service_id.'">
                        <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="1">
                        <input type="hidden" name="price_list_id[]" class="form-control" id="price_list_id">
                        </td>
                        <td>
                            <input type="text" name="price[]" id="price" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="top_up[]" id="top_up" style="border-width:0px">
                        </td>';
            };
        };
    };

    $query = "SELECT * FROM drugs";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
    {
        $value.='
            <tr style="background-color:#E4E1E0">
                <td colspan="3">
                    <strong>DRUGS</strong>
                </td>
            </tr>';
        while($row=mysqli_fetch_assoc($query_run))
        {
            $drug_id = $row['drug_id'];
            $query_drug = "SELECT * FROM price_list WHERE ledger_id='$ledger_id' AND item_id='$drug_id' AND category_id=2";
            $query_run_drug = mysqli_query($con, $query_drug);
            if (mysqli_num_rows($query_run_drug) > 0)
            {
                $row_drug=mysqli_fetch_assoc($query_run_drug);
                $price = $row_drug['price'];
                $top_up = $row_drug['price_topup'];
                $price_list_id = $row_drug['id'];
                
                $i=$i++;
                $value.='
                <tr id="'.$i.'">
                    <td>
                        '.$row['brand_name'].'
                        <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                        <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$drug_id.'">
                        <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="2">
                        <input type="hidden" name="price_list_id[]" value="'.$price_list_id.'" class="form-control" id="price_list_id">
                        </td>
                        <td>
                            <input type="text" name="price[]" id="price" value="'.$price.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="top_up[]" id="top_up" value="'.$top_up.'" style="border-width:0px">
                        </td>';
            }
            else
            {
                $i=$i++;
                $value.='
                <tr id="'.$i.'">
                    <td>
                        '.$row['brand_name'].'
                        <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                        <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$drug_id.'">
                        <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="2">
                        <input type="hidden" name="price_list_id[]" class="form-control" id="price_list_id">
                        </td>
                        <td>
                            <input type="text" name="price[]" id="price" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="top_up[]" id="top_up" style="border-width:0px">
                        </td>';
            };
        };
    };

    $query = "SELECT * FROM lab";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
        {
            $value.='
                <tr style="background-color:#E4E1E0">
                    <td colspan="3">
                        <strong>LABS</strong>
                    </td>
                </tr>';
            while($row=mysqli_fetch_assoc($query_run))
            {
                $lab_id = $row['lab_id'];
                $query_lab = "SELECT * FROM price_list WHERE ledger_id='$ledger_id' AND item_id='$lab_id' AND category_id=3";
                $query_run_lab = mysqli_query($con, $query_lab);
                if (mysqli_num_rows($query_run_lab) > 0)
                {
                    $row_lab=mysqli_fetch_assoc($query_run_lab);
                    $price = $row_lab['price'];
                    $top_up = $row_lab['price_topup'];
                    $price_list_id = $row_lab['id'];

                    $i=$i++;
                    $value.='
                    <tr id="'.$i.'">
                        <td>
                            '.$row['lab'].'
                            <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                            <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$lab_id.'">
                            <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="3">
                            <input type="hidden" name="price_list_id[]" value="'.$price_list_id.'" class="form-control" id="price_list_id">
                            </td>
                            <td>
                                <input type="text" name="price[]" id="price" value="'.$price.'" style="border-width:0px">
                            </td>
                            <td>
                                <input type="text" name="top_up[]" id="top_up" value="'.$top_up.'" style="border-width:0px">
                            </td>';
                }
                else
                {
                    $i=$i++;
                    $value.='
                    <tr id="'.$i.'">
                        <td>
                            '.$row['lab'].'
                            <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                            <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$lab_id.'">
                            <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="3">
                            <input type="hidden" name="price_list_id[]" class="form-control" id="price_list_id">
                            </td>
                            <td>
                                <input type="text" name="price[]" id="price" style="border-width:0px">
                            </td>
                            <td>
                                <input type="text" name="top_up[]" id="top_up" style="border-width:0px">
                            </td>';
                };
            };
        };

    $query = "SELECT * FROM radiology";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
        {
            $value.='
                <tr style="background-color:#E4E1E0">
                    <td colspan="3">
                        <strong>RADIOLOGY</strong>
                    </td>
                </tr>';
            while($row=mysqli_fetch_assoc($query_run))
            {
                $radio_id = $row['radio_id'];
                $query_radio = "SELECT * FROM price_list WHERE ledger_id='$ledger_id' AND item_id='$radio_id' AND category_id=4";
                $query_run_radio = mysqli_query($con, $query_radio);
                if (mysqli_num_rows($query_run_radio) > 0)
                    {
                        $row_radio=mysqli_fetch_assoc($query_run_radio);
                        $price = $row_radio['price'];
                        $top_up = $row_radio['price_topup'];
                        $price_list_id = $row_radio['id'];

                        $i=$i++;
                        $value.='
                        <tr id="'.$i.'">
                            <td>
                                '.$row['radiology'].'
                                <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                                <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$radio_id.'">
                                <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="4">
                                <input type="hidden" name="price_list_id[]" value="'.$price_list_id.'" class="form-control" id="price_list_id">
                                </td>
                                <td>
                                    <input type="text" name="price[]" id="price" value="'.$price.'" style="border-width:0px">
                                </td>
                                <td>
                                    <input type="text" name="top_up[]" id="top_up" value="'.$top_up.'" style="border-width:0px">
                                </td>';
                    }
                else
                    {
                        $i=$i++;
                        $value.='
                        <tr id="'.$i.'">
                            <td>
                                '.$row['radiology'].'
                                <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                                <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$radio_id.'">
                                <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="4">
                                <input type="hidden" name="price_list_id[]" class="form-control" id="price_list_id">
                                </td>
                                <td>
                                    <input type="text" name="price[]" id="price" style="border-width:0px">
                                </td>
                                <td>
                                    <input type="text" name="top_up[]" id="top_up" style="border-width:0px">
                                </td>';
                    };
            };
        };

    $query = "SELECT * FROM surgery";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0)
        {
            $value.='
                <tr style="background-color:#E4E1E0">
                    <td colspan="3">
                        <strong>SURGERY/PROCEDURE</strong>
                    </td>
                </tr>';
            while($row=mysqli_fetch_assoc($query_run))
            {
                $surgery_id = $row['surgery_id'];
                $query_surgery = "SELECT * FROM price_list WHERE ledger_id='$ledger_id' AND item_id='$surgery_id' AND category_id=5";
                $query_run_surgery = mysqli_query($con, $query_surgery);
                if (mysqli_num_rows($query_run_surgery) > 0)
                    {
                        $row_surgery=mysqli_fetch_assoc($query_run_surgery);
                        $price = $row_surgery['price'];
                        $top_up = $row_surgery['price_topup'];
                        $price_list_id = $row_surgery['id'];

                        $i=$i++;
                        $value.='
                        <tr id="'.$i.'">
                            <td>
                                '.$row['surgery'].'
                                <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                                <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$surgery_id.'">
                                <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="5">
                                <input type="hidden" name="price_list_id[]" value="'.$price_list_id.'" class="form-control" id="price_list_id">
                                </td>
                                <td>
                                    <input type="text" name="price[]" id="price" value="'.$price.'" style="border-width:0px">
                                </td>
                                <td>
                                    <input type="text" name="top_up[]" id="top_up" value="'.$top_up.'" style="border-width:0px">
                                </td>';
                    }
                else
                    {
                        $i=$i++;
                        $value.='
                        <tr id="'.$i.'">
                            <td>
                                '.$row['surgery'].'
                                <input type="hidden" name="ledger_id[]" class="form-control" id="ledger_id" value="'.$ledger_id.'">
                                <input type="hidden" name="item_id[]" class="form-control" id="item_id" value="'.$surgery_id.'">
                                <input type="hidden" name="category_id[]" class="form-control" id="category_id" value="5">
                                <input type="hidden" name="price_list_id[]" class="form-control" id="price_list_id">
                                </td>
                                <td>
                                    <input type="text" name="price[]" id="price" style="border-width:0px">
                                </td>
                                <td>
                                    <input type="text" name="top_up[]" id="top_up" style="border-width:0px">
                                </td>';
                    };
            };
        };

    $value.='</tbody>
    </table>';
    echo $value;
}

function update_price_list()
{
    global $con;
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    $number = count($_POST["ledger_id"]);
    if($number > 0)
    {  
        for($i=0; $i<$number; $i++)
        {  
            if(trim($_POST["ledger_id"][$i]) != '')
            {
                $ledger_id = $_POST['ledger_id'][$i];
                $item_id = $_POST['item_id'][$i];
                $category_id = $_POST['category_id'][$i];
                $price_list_id = $_POST['price_list_id'][$i];
                $price = $_POST['price'][$i];
                $top_up = $_POST['top_up'][$i];
                if($price_list_id > 0)
                {
                    $query = "UPDATE `price_list` SET `ledger_id`='$ledger_id',`item_id`='$item_id',
                    `category_id`='$category_id',`price`='$price',`price_topup`='$top_up',
                    `altered_by`='$user_id',`altered_datetime`=NOW(),`company_id`='$company_id'
                    WHERE `id`='$price_list_id'";
                }
                else
                {
                    $query = "INSERT INTO `price_list`(`ledger_id`, `item_id`, `category_id`, `price`, 
                    `price_topup`,`created_by`,`created_datetime`,`company_id`,`user_id`) VALUES ('$ledger_id',
                    '$item_id','$category_id','$price','$top_up','$user_id',NOW(),'$company_id','$user_id')";
                };
                $query_run = mysqli_query($con, $query);
            };
        };
        echo "Data Inserted";  
    }  
    else
    {  
        echo "Data NOT Inserted";  
    };
}

?>
