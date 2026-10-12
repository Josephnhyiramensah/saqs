<?php 
ini_set('max_execution_time', '600');
include($_SERVER['DOCUMENT_ROOT'] .'/includes/functions.php');

if (isset($_POST['price_level_import_post_btn'])) 
{
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 
    'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 
    'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    if (!empty($_FILES['price_level_import_file']['name']) && in_array($_FILES['price_level_import_file']['type'], $csvMimes)) 
    {
        if (is_uploaded_file($_FILES['price_level_import_file']['tmp_name'])) 
        {
            $csvFile = fopen($_FILES['price_level_import_file']['tmp_name'], 'r');
            fgetcsv($csvFile);
    
            $user_id = $_SESSION['user_id'];
            $company_id = $_POST['price_level_import_company_id'];
            $date = $_POST['price_level_import_date'];
			
            //BRANCH
                $query = "SELECT * FROM branch WHERE company_id='$company_id'";
                $result = mysqli_query($con,$query);
                if(!empty($result) && mysqli_num_rows($result) > 0)
                {
                    $row = mysqli_fetch_assoc($result);
                    $branch_id = $row['branch_id'];
                    $branch_name = $row['branch_name'];
                }
                else
                {
                    $branch_id = 0;
                    $branch_name = 'Not Specified';
                };

            //PRICE_LEVEL
                $query = "SELECT * FROM price_list WHERE company_id='$company_id'";
                $result = mysqli_query($con,$query);
                if(!empty($result) && mysqli_num_rows($result) > 0)
                {
                    $row = mysqli_fetch_assoc($result);
                    $price_level_id = $row['price_level_id'];
                }
                else
                {
                    $price_level = $branch_name.' - '.$date;
					$query = "INSERT INTO `price_level`(`price_level`,`company_id`,`branch_id`,`date`,`created_by`,
					`created_datetime`) VALUES ('$price_level','$company_id','$branch_id','$date','$user_id',NOW())";
					$query_run = mysqli_query($con, $query);

                    $query = "SELECT * FROM price_level WHERE `company_id`='$company_id' ORDER BY price_level_id DESC";
                    $result = mysqli_query($con,$query);
                    $row = mysqli_fetch_assoc($result);
                    $price_level_id = $row['price_level_id'];
                };
            
            while (($line = fgetcsv($csvFile)) !== false) 
            {
                $code = $line[0];
                $item_name = addslashes($line[1]);
                $price = $line[2];
                $price_branch = $line[3];
                $price_insurance = $line[4];

                //STOCK_ITEM_ID
                    $query = "SELECT * FROM stock_items WHERE stock_item='$item_name'";
                    $result = mysqli_query($con,$query);
                    if(!empty($result) && mysqli_num_rows($result) > 0)
                    {
                        $row = mysqli_fetch_assoc($result);
                        $stock_item_id = $row['stock_item_id'];
                    }
                    else
                    {
                        $stock_item_id = 0;
                    };

                //UPDATE_PRICE_LIST
                    $query = "SELECT * FROM price_list WHERE `stock_item_id`='$stock_item_id' AND `price_level_id`='$price_level_id'";
                    $result = mysqli_query($con,$query);
                    if(!empty($result) && mysqli_num_rows($result) > 0)
                    {
                        $query_pl = "UPDATE `price_list` SET `price`='$price',`price_branch`='$price_branch', 
                        `price_insurance`='$price_insurance',`altered_by`='$user_id',`altered_datetime`=NOW() 
                        WHERE `stock_item_id`='$stock_item_id' AND `price_level_id`='$price_level_id'";
                        mysqli_query($con, $query_pl);
                    }
                    else
                    {
                        if($stock_item_id > 0)
                        {
                            $query_pl = "INSERT INTO `price_list`(`price_level_id`,`company_id`, `branch_id`,`stock_item_id`, 
                            `date`,`price`,`price_branch`,`price_insurance`, `created_by`,`created_datetime`) VALUES 
                            ('$price_level_id','$company_id','$branch_id','$stock_item_id','$date','$price','$price_branch', 
                            '$price_insurance', '$user_id',NOW())";
                            mysqli_query($con, $query_pl);
                        };
                    };
            };
            fclose($csvFile);
            $qstring = '?status=succ';
        } 
        else 
        {
            $qstring = '?status=err';
        };
    } 
    else 
    {
        $qstring = '?status=invalid_file';
    };
};

header("Location: ".$_SERVER['DOCUMENT_ROOT'] ."/layout/items/price_level_list.php".$qstring);