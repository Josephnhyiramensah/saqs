<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//RADIOLOGY
function save_radio()
{
    global $con;
    $radio = $_POST['radio'];
    $radio_type_id = $_POST['radio_type'];
    $nhis_id = $_POST['radio_nhis_id'];
    $price = $_POST['price'];
    $price_private = $_POST['price_private'];
    $price_private_topup = $_POST['price_private_topup'];
    $price_nhis_topup = $_POST['price_nhis_topup'];
    $company_id = $_SESSION['company_id'];
    $branch_id = $_SESSION['branch_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "INSERT INTO `radiology`(`radiology`,`nhis_id`,`radio_type_id`,`price_cash`,
    `price_private`,`price_private_topup`,`price_nhis_topup`,`company_id`,
    `user_id`,`created_by`,`created_datetime`,`branch_id`
    ) VALUES ('$radio','$nhis_id','$radio_type_id','$price','$price_private','$price_private_topup',
    '$price_nhis_topup','$company_id','$user_id','$user_id',NOW(),'$branch_id')";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        list_radio();
    }
    else
    {
        echo "Radiology NOT Added";
    };
}

function list_radio()
{
    global $con;
    $value='';
    $query = "SELECT * FROM radiology ORDER BY radio_type_id ASC, radiology ASC";
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="radioTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="action-td">Radiology Item</th>
                        <th class="action-td">Type</th>
                        <th class="action-td">Cash</th>
                        <th class="action-td">Private</th>
                        <th class="action-td">Private Top Up</th>
                        <th class="action-td">NHIS Price</th>
                        <th class="action-td">NHIS Top Up</th>
                        <th class="action-td">NHIS Item</th>
                        <th class="action-td">NHIS Code</th>
                        <th class="action-td">Action</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';

                        if (mysqli_num_rows($query_run) > 0)
                        {
                            while($row=mysqli_fetch_assoc($query_run))
                            {
                                $nhis_id = $row['nhis_id'];
                                $query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
                                $query_nhis_run = mysqli_query($con, $query_nhis);
                                $row_nhis=mysqli_fetch_assoc($query_nhis_run);
                                $NA='N/A';
                                $radio_type_id = $row['radio_type_id'];
                                $query_radio_type = "SELECT * FROM radio_type WHERE radio_type_id='$radio_type_id'";
                                $query_radio_type_run = mysqli_query($con, $query_radio_type);
                                $row_radio_type=mysqli_fetch_assoc($query_radio_type_run);

                                $value.='<tr>
                                    <td>
                                        <a href="#" id="btn_edit_radio" data-id="'.$row['radio_id'].'">'.$row['radiology'].'</a>
                                    </td>
                                    <td>'.$row_radio_type['radio_type'].'</td>
                                    <td class="amt-td">'.$row['price_cash'].'</td>
                                    <td class="amt-td">'.$row['price_private'].'</td>
                                    <td class="amt-td">'.$row['price_private_topup'].'</td>';
                                    if ($row_nhis==null){$value.='<td class="amt-td">'.$NA.'</td>';}else{$value.='<td class="amt-td">'.$row_nhis['price'].'</td>';};
                                    $value.='<td class="amt-td">'.$row['price_nhis_topup'].'</td>';
                                    if ($row_nhis==null){$value.='<td class="action-td">'.$NA.'</td>';}else{$value.='<td class="action-td">'.$row_nhis['nhis_item_desc'].'</td>';};
                                    if ($row_nhis==null){$value.='<td class="action-td">'.$NA.'</td>';}else{$value.='<td class="action-td">'.$row_nhis['gdrg'].'</td>';};
                                    $value.='<td class="action-td">
                                        <a href="#" id="btn_delete_radio" data-id2="'.$row['radio_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                    </td>
                                </tr>';
                            }
                        }
                        else
                        {
                                echo 'Data Not Found';
                        };
                    
                $value.='</tbody>
            </table>';
            echo $value;
}

function edit_radio()
{
    global $con;
    $radio_id = $_POST['radio_id'];
    $query = "SELECT * from radiology where radio_id='$radio_id'";
    $result = mysqli_query($con,$query);
    $radio_item=array();
    while($row=mysqli_fetch_assoc($result))
    {
        $nhis_id=$row['nhis_id'];
        $query = "SELECT * from nhis where nhis_id='$nhis_id'";
        $result = mysqli_query($con,$query);
        $row_nhis=mysqli_fetch_assoc($result);
        array_push($radio_item, 
            $row['radio_id'],
            $row['radiology'],
            $row['radio_type_id'],
            $row['nhis_id'],
            $row['price_cash'],
            $row['price_private'],
            $row['price_private_topup'],
            $row['price_nhis_topup']
        );
    }
     echo json_encode($radio_item);
}

function radio_get_param_list()
{
    global $con;
    $radio_id = $_POST['radio_id'];
    $value='';
    $query = "SELECT * FROM radio_param WHERE radio_id=$radio_id ORDER BY radio_param ASC";
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="radioparamTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Comment</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';

                        if (mysqli_num_rows($query_run) > 0)
                        {
                            while($row=mysqli_fetch_assoc($query_run))
                            {

                                $value.='<tr>
                                    <td>
                                        <a href="#" id="btn_edit_radio_param" data-id="'.$row['radio_param_id'].'">'.$row['radio_param'].'</a>
                                    </td>
                                    <td>'.$row['comment'].'</td>
                                    <td>
                                        <a href="#" id="btn_delete_radio_param" data-id2="'.$row['radio_param_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                    </td>
                                </tr>';
                            }
                        }
                        else
                        {
                                echo 'Data Not Found';
                        };
                    
                $value.='</tbody>
            </table>';
            echo $value;
}

function radio_nhis_code_price()
{
    global $con;
    $nhis_id = $_POST['nhis_id'];
    $query = "SELECT * from nhis where nhis_id='$nhis_id'";
    $result = mysqli_query($con,$query);
    $nhis_item=array();
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($nhis_item, 
            $row['nhis_id'],
            $row['gdrg'],
            $row['price']
        );
    }
     echo json_encode($nhis_item);
}

function update_radio()
{
    global $con;
    $radio_id = $_POST['radio_id'];
    $radio = $_POST['radio'];
    $type = $_POST['radio_type'];
    $nhis_id = $_POST['radio_nhis_id'];
    $price = $_POST['price'];
    $price_private = $_POST['price_private'];
    $price_private_topup = $_POST['price_private_topup'];
    $price_nhis_topup = $_POST['price_nhis_topup'];
    $company_id = $_SESSION['company_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "UPDATE `radiology` SET `radiology`='$radio',`radio_type_id`='$type',
    `nhis_id`='$nhis_id',`price_cash`='$price',`price_private`='$price_private',
    `price_private_topup`='$price_private_topup',`price_nhis_topup`='$price_nhis_topup',
    `altered_by`='$user_id',`altered_datetime`= NOW() WHERE `radio_id`='$radio_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        list_radio();
    }
    else
    {
        echo "Radiology NOT Updated";
    };
}

function save_radio_param()
{
    global $con;
    $radio_id = $_POST['param_radio_id'];
    $radio_param = $_POST['radio_param'];
    $param_comment = $_POST['param_comment'];
    
    $query = "INSERT INTO `radio_param`(`radio_id`,`radio_param`,`comment`) VALUES ('$radio_id','$radio_param','$param_comment')";
    $query_run = mysqli_query($con, $query);

    If ($query_run)
    {
        $value='';
        $query = "SELECT * FROM radio_param WHERE radio_id=$radio_id ORDER BY radio_param ASC";
        $query_run = mysqli_query($con, $query);
        $value.='<table class="table table-hover table-bordered table-sm" id="radioparamTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Comment</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">';

                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {

                                    $value.='<tr>
                                        <td>
                                            <a href="#" id="btn_edit_radio_param" data-id="'.$row['radio_param_id'].'">'.$row['radio_param'].'</a>
                                        </td>
                                        <td>'.$row['comment'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_radio_param" data-id2="'.$row['radio_param_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                                }
                            }
                            else
                            {
                                    echo 'Data Not Found';
                            };
                        
                    $value.='</tbody>
                </table>';
                echo $value;
    }
    else
    {
        echo "Radiology Parameter NOT Added";
    };
}

function edit_radio_param()
{
    global $con;
    $radio_param_id = $_POST['radio_param_id'];
    $query = "SELECT * from radio_param where radio_param_id='$radio_param_id'";
    $result = mysqli_query($con,$query);
    $radio_param_item=array();
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($radio_param_item, 
            $row['radio_param_id'],
            $row['radio_id'],
            $row['radio_param'],
            $row['comment']
        );
    }
     echo json_encode($radio_param_item);
}

function radio_get_param_dd_list()
{
    global $con;
    $radio_param_id = $_POST['radio_param_id'];
    $value='';
    $query = "SELECT * FROM radio_param_dropdown WHERE radio_param_id=$radio_param_id ORDER BY radio_param_dd ASC";
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="radioparamddTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Dropdown Item</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body">';

                        if (mysqli_num_rows($query_run) > 0)
                        {
                            while($row=mysqli_fetch_assoc($query_run))
                            {

                                $value.='<tr>
                                    <td>
                                        <a href="#" id="btn_edit_radio_param_dd" data-id="'.$row['radio_param_dd_id'].'">'.$row['radio_param_dd'].'</a>
                                    </td>
                                    <td>
                                        <a href="#" id="btn_delete_radio_param_dd" data-id2="'.$row['radio_param_dd_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                    </td>
                                </tr>';
                            }
                        }
                        else
                        {
                                echo 'Data Not Found';
                        };
                    
                $value.='</tbody>
            </table>';
            echo $value;
}

function update_radio_param()
{
    global $con;
    $radio_param = $_POST['radio_param'];
    $radio_param_id = $_POST['radio_param_id'];
    $radio_id = $_POST['param_radio_id'];
    $param_comment = $_POST['param_comment'];
    
    $query = "UPDATE `radio_param` SET `radio_param`='$radio_param',`radio_id`='$radio_id',`comment`='$param_comment' WHERE `radio_param_id`='$radio_param_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        $value='';
        $query = "SELECT * FROM radio_param WHERE radio_id=$radio_id ORDER BY radio_param ASC";
        $query_run = mysqli_query($con, $query);
        $value.='<table class="table table-hover table-bordered table-sm" id="radioparamTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Comment</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">';

                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {

                                    $value.='<tr>
                                        <td>
                                            <a href="#" id="btn_edit_radio_param" data-id="'.$row['radio_param_id'].'">'.$row['radio_param'].'</a>
                                        </td>
                                        <td>'.$row['comment'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_radio_param" data-id2="'.$row['radio_param_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                                }
                            }
                            else
                            {
                                    echo 'Data Not Found';
                            };
                        
                    $value.='</tbody>
                </table>';
                echo $value;
    }
    else
    {
        echo "clinic NOT Updated";
    };
}

function save_radio_param_dd()
{
    global $con;
    $radio_id = $_POST['param_dd_radio_id'];
    $radio_param_id = $_POST['param_dd_param_id'];
    $param_dropdown = $_POST['param_dropdown'];
    
    $query = "INSERT INTO `radio_param_dropdown`(`radio_id`,`radio_param_id`,`radio_param_dd`) VALUES ('$radio_id','$radio_param_id','$param_dropdown')";
    $query_run = mysqli_query($con, $query);

    If ($query_run)
    {
        $value='';
        $query = "SELECT * FROM radio_param_dropdown WHERE radio_param_id=$radio_param_id ORDER BY radio_param_dd ASC";
        $query_run = mysqli_query($con, $query);
        $value.='<table class="table table-hover table-bordered table-sm" id="radioparamddTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Dropdown Item</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">';

                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {

                                    $value.='<tr>
                                        <td>
                                            <a href="#" id="btn_edit_radio_param_dd" data-id="'.$row['radio_param_dd_id'].'">'.$row['radio_param_dd'].'</a>
                                        </td>
                                        <td>
                                            <a href="#" id="btn_delete_radio_param_dd" data-id2="'.$row['radio_param_dd_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                                }
                            }
                            else
                            {
                                    echo 'Data Not Found';
                            };
                        
                    $value.='</tbody>
                </table>';
                echo $value;
    }
    else
    {
        echo "Parameter Dropdown NOT Added";
    };
}

function edit_radio_param_dd()
{
    global $con;
    $radio_param_dd_id = $_POST['radio_param_dd_id'];
    $query = "SELECT * from radio_param_dropdown where radio_param_dd_id='$radio_param_dd_id'";
    $result = mysqli_query($con,$query);
    $param_dd_item=array();
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($param_dd_item, 
            $row['radio_param_dd_id'],
            $row['radio_param_id'],
            $row['radio_id'],
            $row['radio_param_dd']
        );
    }
     echo json_encode($param_dd_item);
}

function update_radio_param_dd()
{
    global $con;
    $param_dropdown = $_POST['param_dropdown'];
    $radio_param_id = $_POST['param_dd_param_id'];
    $radio_id = $_POST['param_dd_radio_id'];
    $param_dd_id = $_POST['param_dd_id'];
    
    $query = "UPDATE `radio_param_dropdown` SET `radio_param_id`='$radio_param_id',`radio_id`='$radio_id',`radio_param_dd`='$param_dropdown' WHERE `radio_param_dd_id`='$param_dd_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        $value='';
        $query = "SELECT * FROM radio_param_dropdown WHERE radio_param_id=$radio_param_id ORDER BY radio_param_dd ASC";
        $query_run = mysqli_query($con, $query);
        $value.='<table class="table table-hover table-bordered table-sm" id="radioparamddTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Dropdown Item</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">';

                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {

                                    $value.='<tr>
                                        <td>
                                            <a href="#" id="btn_edit_radio_param_dd" data-id="'.$row['radio_param_dd_id'].'">'.$row['radio_param_dd'].'</a>
                                        </td>
                                        <td>
                                            <a href="#" id="btn_delete_radio_param_dd" data-id2="'.$row['radio_param_dd_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                                }
                            }
                            else
                            {
                                    echo 'Data Not Found';
                            };
                        
                    $value.='</tbody>
                </table>';
                echo $value;
    }
    else
    {
        echo "Parameter Dropdown NOT Updated";
    };
}

function search_radio()
{
    global $con;
    $value = '';
    if(isset($_POST["search"]))
    {
     $search = mysqli_real_escape_string($con, $_POST["search"]);
     $query = "SELECT * FROM radiology 
      WHERE radiology LIKE '%".$search."%' ORDER BY radiology ASC";
    }
    else
    {
        $query = "SELECT * FROM radiology ORDER BY radiology ASC";
    }
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="radioTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="action-td">Radiology Item</th>
                <th class="action-td">Type</th>
                <th class="action-td">Cash</th>
                <th class="action-td">Private</th>
                <th class="action-td">Private Top Up</th>
                <th class="action-td">NHIS Price</th>
                <th class="action-td">NHIS Top Up</th>
                <th class="action-td">NHIS Item</th>
                <th class="action-td">NHIS Code</th>
                <th class="action-td">Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">';
            
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $nhis_id = $row['nhis_id'];
                        $query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
                        $query_nhis_run = mysqli_query($con, $query_nhis);
                        $row_nhis=mysqli_fetch_assoc($query_nhis_run);

                        $radio_type_id = $row['radio_type_id'];
                        $query_radio_type = "SELECT * FROM radio_type WHERE radio_type_id='$radio_type_id'";
                        $query_radio_type_run = mysqli_query($con, $query_radio_type);
                        $row_radio_type=mysqli_fetch_assoc($query_radio_type_run);
            
                        $value.='<tr>
                            <td>
                                <a href="#" id="btn_edit_radio" data-id="'.$row['radio_id'].'">'.$row['radiology'].'</a>
                            </td>
                            <td>'.$row_radio_type['radio_type'].'</td>
                            <td class="amt-td">'.$row['price_cash'].'</td>
                            <td class="amt-td">'.$row['price_private'].'</td>
                            <td class="amt-td">'.$row['price_private_topup'].'</td>
                            <td>';if ($row_nhis==null){$value .= 'N/A';}else{$value .= $row_nhis['price'];}$value .= '</td>
                            <td class="amt-td">'.$row['price_nhis_topup'].'</td>
                            <td>';if ($row_nhis==null){$value .= 'N/A';}else{$value .= $row_nhis['nhis_item_desc'];}$value .= '</td>
                            <td>';if ($row_nhis==null){$value .= 'N/A';}else{$value .= $row_nhis['gdrg'];}$value .= '</td>
                            <td class="action-td">
                                <a href="#" id="btn_delete_radio" 
                                data-id="'.$row['radio_id'].'"
                                data-id1="'.$row['radiology'].'"><i class="fa fa-trash fa-sm"></i></a>
                            </td>
                        </tr>';
                    }
                }
                else
                {
                    $value.='Data Not Found';
                };
            
        $value.='</tbody>
    </table>';
            echo $value;

}

function delete_radio()
{
    global $con;
    $radio_id = $_POST['radio_id'];
    
    $query = "SELECT * FROM `radio_list` WHERE `radio_id`='$radio_id'";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) < 1)
    {
        $query = "DELETE FROM `radiology` WHERE `radio_id`='$radio_id'";
            mysqli_query($con, $query);
            echo 'deleted';
    }
    else
    {
        echo 'used';
    };
}

?>
