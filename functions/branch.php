<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');

		//BRANCH
        function branch_save()
        {
            global $con;
            $branch_company_id = $_POST['branch_company_id'];
            $branch_id = $_POST['branch_id'];
            $branch_name = $_POST['branch_name'];
            $branch_address = $_POST['branch_address'];
            $branch_location = $_POST['branch_location'];
            $branch_telephone = $_POST['branch_telephone'];
            $branch_email = $_POST['branch_email'];
            $branch_warehouse = $_POST['branch_warehouse'];
            $branch_cash_ledger = $_POST['branch_cash_ledger'];
            $user_id = $_SESSION['user_id'];

            $query = "INSERT INTO `branch`(`branch_name`,`branch_address`,`branch_location`,`branch_telephone`,
            `branch_email`,`company_id`,`user_id`,`created_by`,`created_datetime`,`warehouse_id`,`cash_ledger_id`) VALUES ('$branch_name',
            '$branch_address','$branch_location','$branch_telephone','$branch_email',
            '$branch_company_id','$user_id','$user_id',NOW(),'$branch_warehouse','$branch_cash_ledger')";
            mysqli_query($con,$query);
        }

        function branch_edit()
        {
            global $con;
            $branch_id = $_POST['branch_id'];
            $query = "SELECT * FROM branch WHERE branch_id='$branch_id'";
            $result = mysqli_query($con,$query);
            $branch_detail = array();
            while($row = mysqli_fetch_assoc($result))
            {
                array_push($branch_detail, 
                    $row['branch_id'],
                    $row['company_id'],
                    $row['branch_name'],
                    $row['branch_address'],
                    $row['branch_location'],
                    $row['branch_telephone'],
                    $row['branch_email'],
                    $row['warehouse_id'],
                    $row['cash_ledger_id']
                );
            }
                echo json_encode($branch_detail);
        }

        function branch_update()
        {
            global $con;
            $branch_company_id = $_POST['branch_company_id'];
            $branch_id = $_POST['branch_id'];
            $branch_name = $_POST['branch_name'];
            $branch_address = $_POST['branch_address'];
            $branch_location = $_POST['branch_location'];
            $branch_telephone = $_POST['branch_telephone'];
            $branch_email = $_POST['branch_email'];
            $branch_warehouse = $_POST['branch_warehouse'];
            $branch_cash_ledger = $_POST['branch_cash_ledger'];
            $user_id = $_SESSION['user_id'];

            $query = "UPDATE `branch` SET `branch_name`='$branch_name',`branch_address`='$branch_address',
            `branch_location`='$branch_location',`branch_telephone`='$branch_telephone',
            `branch_email`='$branch_email',`company_id`='$branch_company_id',`altered_by`='$user_id',
            `warehouse_id`='$branch_warehouse',`cash_ledger_id`='$branch_cash_ledger',`altered_datetime`=NOW() WHERE `branch_id`='$branch_id'";
            mysqli_query($con,$query);
        }
?>
