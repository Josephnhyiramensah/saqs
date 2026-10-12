<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//NHIS ITEMS
function nhis_list()
{
    global $con;
    $value='';
    $query = "SELECT * FROM nhis ORDER BY category_id DESC, nhis_item_desc ASC";
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="nhisTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Description</th>
                <th>G-DRG</th>
                <th>G-DRG Adult</th>
                <th>G-DRG Child</th>
                <th>Price</th>
                <th>Price Adult</th>
                <th>Price Child</th>
                <th>Category</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">';
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $category_id = $row['category_id'];
                        $querycategory = "SELECT * FROM item_category WHERE category_id='$category_id'";
                        $querycategory_run = mysqli_query($con, $querycategory);
                        $row_category=mysqli_fetch_assoc($querycategory_run);
                        $value.='<tr>
                            <td><a href="#" id="btn_edit_nhis" data-id="'.$row['nhis_id'].'">'.$row['nhis_item_desc'].'</a></td>
                            <td>'.$row['gdrg'].'</td>
                            <td>'.$row['gdrg_adult'].'</td>
                            <td>'.$row['gdrg_child'].'</td>
                            <td>'.$row['price'].'</td>
                            <td>'.$row['price_adult'].'</td>
                            <td>'.$row['price_child'].'</td>
                            <td>'.$row_category['category_desc'].'</td>
                            <td>
                                <a href="#" id="btn_delete_nhis" data-id2="'.$row['nhis_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                            </td>
                        </tr>';
                    }
                    $value.='</tbody>
    </table>';
    echo $value;
                }
                else
                {
                        echo 'Data Not Found';
                };
}

function save_nhis()
{
    global $con;
    $nhisdesc = $_POST['nhisdesc'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $price_adult = $_POST['price_adult'];
    $price_child = $_POST['price_child'];
    $price_topup = $_POST['price_topup'];
    $code = $_POST['code'];
    $gdrg_adult = $_POST['gdrg_adult'];
    $gdrg_child = $_POST['gdrg_child'];
    
    $query = "INSERT INTO `nhis`(`category_id`, `nhis_item_desc`, `price`, `price_adult`, `price_child`, `price_topup`, `gdrg`, `gdrg_adult`, `gdrg_child`) VALUES ('$category','$nhisdesc','$price','$price_adult','$price_child','$price_topup','$code','$gdrg_adult','$gdrg_child')";
    $query_run = mysqli_query($con, $query);

    If ($query_run)
    {
        nhis_list();
    }
    else
    {
        echo "NHIS Item NOT Added";
    };
}

function edit_nhis()
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
            $row['category_id'],
            $row['nhis_item_desc'],
            $row['price'],
            $row['price_adult'],
            $row['price_child'],
            $row['gdrg'],
            $row['gdrg_adult'],
            $row['gdrg_child'],
            $row['price_topup']
        );
    }
     echo json_encode($nhis_item);
}

function update_nhis()
{
    global $con;
    $nhis_id = $_POST['nhis_id'];
    $nhisdesc = $_POST['nhisdesc'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $price_adult = $_POST['price_adult'];
    $price_child = $_POST['price_child'];
    $price_topup = $_POST['price_topup'];
    $code = $_POST['code'];
    $gdrg_adult = $_POST['gdrg_adult'];
    $gdrg_child = $_POST['gdrg_child'];
    
    $query = "UPDATE `nhis` SET `category_id`='$category',`nhis_item_desc`='$nhisdesc',`price`='$price',`price_adult`='$price_adult',`price_child`='$price_child',`gdrg`='$code',`gdrg_adult`='$gdrg_adult',`gdrg_child`='$gdrg_child',`price_topup`='$price_topup' WHERE `nhis_id`='$nhis_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        nhis_list();
    }
    else
    {
        echo "NHIS Item NOT Added";
    };
}

function nhis_scheme_list()
{
    global $con;
    $value='';
    $query = "SELECT * FROM scheme ORDER BY scheme_name ASC";
    $query_run = mysqli_query($con, $query);
    $value.='<table class="table table-hover table-bordered table-sm" id="nhisTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Scheme Name</th>
                <th>Scheme Code</th>
                <th>Regional Code</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">';
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $value.='<tr>
                            <td><a href="#" id="btn_edit_nhis_scheme" data-id="'.$row['scheme_id'].'">'.$row['scheme_name'].'</a></td>
                            <td>'.$row['scheme_code'].'</td>
                            <td>'.$row['regional_code'].'</td>
                            <td>
                                <a href="#" id="btn_delete_nhis_scheme" data-id2="'.$row['scheme_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                            </td>
                        </tr>';
                    }
                    $value.='</tbody>
    </table>';
    echo $value;
                };
}

function save_nhis_scheme()
{
    global $con;
    $scheme_name = $_POST['scheme_name'];
    $regional_code = $_POST['regional_code'];
    $scheme_code = $_POST['scheme_code'];
    
    $query = "INSERT INTO `scheme`(`scheme_name`, `regional_code`, `scheme_code`) VALUES ('$scheme_name','$regional_code','$scheme_code')";
    $query_run = mysqli_query($con, $query);

    If ($query_run)
    {
        nhis_scheme_list();
    }
    else
    {
        echo "NHIS Scheme NOT Added";
    };
}

function edit_nhis_scheme()
{
    global $con;
    $scheme_id = $_POST['scheme_id'];
    $query = "SELECT * from scheme where scheme_id='$scheme_id'";
    $result = mysqli_query($con,$query);
    $nhis_scheme=array();
    while($row=mysqli_fetch_assoc($result))
    {
        array_push($nhis_scheme, 
            $row['scheme_id'],
            $row['scheme_name'],
            $row['regional_code'],
            $row['scheme_code']
        );
    }
     echo json_encode($nhis_scheme);
}

function update_nhis_scheme()
{
    global $con;
    $scheme_id = $_POST['scheme_id'];
    $scheme_name = $_POST['scheme_name'];
    $regional_code = $_POST['regional_code'];
    $scheme_code = $_POST['scheme_code'];
    
    $query = "UPDATE `scheme` SET `scheme_name`='$scheme_name',`regional_code`='$regional_code',`scheme_code`='$scheme_code' WHERE `scheme_id`='$scheme_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run)
    {
        nhis_scheme_list();
    }
    else
    {
        echo "NHIS Scheme NOT Added";
    };
}

function search_nhis_item()
{
    global $con;
    $value = '';
    if(isset($_POST["search"]))
    {
     $search = mysqli_real_escape_string($con, $_POST["search"]);
     $query = "SELECT * FROM nhis 
      WHERE nhis_item_desc LIKE '%".$search."%' 
      OR gdrg LIKE '%".$search."%' 
      OR gdrg_adult LIKE '%".$search."%' 
      OR gdrg_child LIKE '%".$search."%'";
    }
    else
    {
        $query = "SELECT * FROM nhis ORDER BY category_id AND nhis_item_desc";
    }
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) > 0)
    {
        $value.='<table class="table table-hover table-bordered table-sm" id="nhisTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>G-DRG</th>
                    <th>G-DRG Adult</th>
                    <th>G-DRG Child</th>
                    <th>Price</th>
                    <th>Price Adult</th>
                    <th>Price Child</th>
                    <th>Category</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody class="pv-table-body">';
        while($row=mysqli_fetch_assoc($query_run))
        {
            $category_id = $row['category_id'];
            $querycategory = "SELECT * FROM item_category WHERE category_id='$category_id'";
            $querycategory_run = mysqli_query($con, $querycategory);
            $row_category=mysqli_fetch_assoc($querycategory_run);
            $value.='<tr>
                <td><a href="#" id="btn_edit_nhis" data-id="'.$row['nhis_id'].'">'.$row['nhis_item_desc'].'</a></td>
                <td>'.$row['gdrg'].'</td>
                <td>'.$row['gdrg_adult'].'</td>
                <td>'.$row['gdrg_child'].'</td>
                <td>'.$row['price'].'</td>
                <td>'.$row['price_adult'].'</td>
                <td>'.$row['price_child'].'</td>
                <td>'.$row_category['category_desc'].'</td>
                <td>
                    <a href="#" id="btn_delete_nhis" data-id2="'.$row['nhis_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                </td>
            </tr>';
        }
        $value.='</tbody>
        </table>';
        echo $value;
    }
    else
    {
            echo 'Data Not Found';
    };
}

?>
