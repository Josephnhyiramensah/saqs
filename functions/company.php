<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');

		//COMPANY
        function company_open()
        {
            global $con;
            $company_open_detail = array();
            $type = '';
            $company_id = $_POST['company_id'];

            $query_sub_bill = "SELECT * FROM `subscription_bill` WHERE `company_id`='$company_id'
            ORDER BY date_end DESC";
            $result_sub_bill = mysqli_query($con,$query_sub_bill);
            $row_sub_bill = mysqli_fetch_assoc($result_sub_bill);
            $date = date("Y-m-d");

            $date_grace = $row_sub_bill['date_grace'];
            $date_end = $row_sub_bill['date_end'];

            if($date_grace < $date)
            {
                $type = "Expired_Closed";
            }
            else if($date_grace >= $date)
            {
                if($date_end >= $date)
                {
                    $_SESSION['company_id'] = $_POST['company_id'];
                    $_SESSION['company_type_id'] = $_POST['company_type_id'];
                    $_SESSION['company_sms'] = $_POST['company_sms'];
            
                    $query = "SELECT * FROM branch WHERE company_id='".$_POST['company_id']."'
                    ORDER BY branch_id ASC";
                    $result = mysqli_query($con,$query);
                    if(mysqli_num_rows($result) > 0)
                    {
                        $row = mysqli_fetch_assoc($result);
                        $_SESSION['branch_id'] = $row['branch_id'];
                    };
                    $type = "Open";
                }
                else
                {
                    $_SESSION['company_id'] = $_POST['company_id'];
                    $_SESSION['company_type_id'] = $_POST['company_type_id'];
                    $_SESSION['company_sms'] = $_POST['company_sms'];
            
                    $query = "SELECT * FROM branch WHERE company_id='".$_POST['company_id']."'
                    ORDER BY branch_id ASC";
                    $result = mysqli_query($con,$query);
                    if(mysqli_num_rows($result) > 0)
                    {
                        $row = mysqli_fetch_assoc($result);
                        $_SESSION['branch_id'] = $row['branch_id'];
                    };
                    $type = "Expired_Grace";
                };
            };
    
            array_push($company_open_detail, 
                $date_grace,
                $date_end,
                $type
            );
            echo json_encode($company_open_detail);
        }

        function company_save()
        {
            global $con;
            $user_super_id = $_POST['user_super_id'];
            $trading_name = $_POST['trading_name'];
            $legal_name = $_POST['legal_name'];
            $address = $_POST['address'];
            $location = $_POST['location'];
            $gps = $_POST['gps'];
            $email = $_POST['email'];
            $website = $_POST['website'];
            $telephone = $_POST['telephone'];
            $momo_phone = $_POST['momo_phone'];
            $whatsapp_phone = $_POST['whatsapp_phone'];
            $admin_username = $_POST['admin_username'];
            $admin_email = $_POST['admin_email'];
            $admin_password = $_POST['admin_password'];
            $currency = $_POST['currency'];
            $company_logo_file = $_POST['company_logo_file'];
            $company_type_id = $_POST['company_type_id'];
            $sms = $_POST['sms'];
            $status = 'Active';

            $query = "INSERT INTO `company`(`user_super_id`,`trading_name`,`legal_name`,`logo`,`address`,`location`,`gps`,
            `telephone`,`whatsapp`,`momo`,`email`,`website`,`admin_username`,`admin_email`,`admin_password`,`currency`,
            `company_type_id`,`status`,`sms`) VALUES ('$user_super_id','$trading_name','$legal_name','$company_logo_file','$address',
            '$location','$gps','$telephone','$whatsapp_phone','$momo_phone','$email','$website','$admin_username',
            '$admin_email','$admin_password','$currency','$company_type_id','$status','$sms')";

            $result = mysqli_query($con,$query);
        }

        function company_edit()
        {
            global $con;
            $company_id = $_POST['company_id'];
            $query = "SELECT * from company where company_id='$company_id'";
            $result = mysqli_query($con,$query);
            $company_detail = array();
            while($row = mysqli_fetch_assoc($result))
            {
                array_push($company_detail, 
                    $row['company_id'],
                    $row['trading_name'],
                    $row['legal_name'],
                    $row['logo'],
                    $row['address'],
                    $row['location'],
                    $row['gps'],
                    $row['telephone'],
                    $row['whatsapp'],
                    $row['momo'],
                    $row['email'],
                    $row['website'],
                    $row['admin_username'],
                    $row['admin_email'],
                    $row['admin_password'],
                    $row['currency'],
                    $row['company_type_id'],
                    $row['status'],
                    $row['sms']

                );
            }
             echo json_encode($company_detail);
        }

        function company_update()
        {
            global $con;
            $company_id = $_POST['company_id'];
            $trading_name = $_POST['trading_name'];
            $legal_name = $_POST['legal_name'];
            $attend_id = $_POST['mur_attend_id'];
            $address = $_POST['address'];
            $location = $_POST['location'];
            $gps = $_POST['gps'];
            $email = $_POST['email'];
            $website = $_POST['website'];
            $telephone = $_POST['telephone'];
            $momo_phone = $_POST['momo_phone'];
            $whatsapp_phone = $_POST['whatsapp_phone'];
            $admin_username = $_POST['admin_username'];
            $admin_email = $_POST['admin_email'];
            $admin_password = $_POST['admin_password'];
            $currency = $_POST['currency'];
            $company_logo_file = $_POST['company_logo_file'];
            $company_type_id = $_POST['company_type_id'];
            $sms = $_POST['sms'];
            $status = $_POST['company_status'];

            $query = "UPDATE `company` SET `trading_name`='$trading_name',`legal_name`='$legal_name',
            `logo`='$company_logo_file',`address`='$address',`location`='$location',`gps`='$gps',`telephone`='$telephone',
            `whatsapp`='$whatsapp_phone',`momo`='$momo_phone',`email`='$email',`website`='$website',
            `admin_username`='$admin_username',`admin_email`='$admin_email',`admin_password`='$admin_password',
            `currency`='$currency',`company_type_id`='$company_type_id',`status`='$status',`sms`='$sms' WHERE `company_id`='$company_id'";

            $result = mysqli_query($con,$query);
        }

        function company_lock_unlock()
        {
            global $con;
            $company_id = $_POST['company_id'];
            $current_state = $_POST['status'];
            if($current_state == 'Active')
            {
                $status = 'Closed';
            }
            else
            {
                $status = 'Active';
            };

            $query = "UPDATE `company` SET `status`='$status' WHERE `company_id`='$company_id'";
            mysqli_query($con,$query);
        }

        function company_subscription_modal_show()
        {
            global $con;
            $_SESSION['company_id'] = $_POST['company_id'];
        }

        function company_subscription_save()
        {
            global $con;
            $price = $_POST['price'];
            $no_of_months = $_POST['no_of_months'];
            $exchange_rate = $_POST['exchange_rate'];
            $start_date = $_POST['start_date'];
            $amount_dollar = $_POST['amount_dollar'];
            $amount_cedi = $_POST['amount_cedi'];
            $expiry_date = $_POST['expiry_date'];
            $date_grace = $_POST['date_grace'];
            $company_id = $_POST['company_subscription_company_id'];

            $query = "INSERT INTO `subscription_bill`(`company_id`,`date_start`,`date_end`,`date_grace`,
            `no_of_months`,`price`,`ex_rate`,`amount_dollar`,`amount_cedi`) 
            VALUES ('$company_id','$start_date','$expiry_date','$date_grace','$no_of_months',
            '$price','$exchange_rate','$amount_dollar','$amount_cedi')";

            mysqli_query($con,$query);
        }

        function company_subscription_edit()
        {
            global $con;
            $sub_bill_id = $_POST['sub_bill_id'];
            $query = "SELECT * FROM subscription_bill WHERE sub_bill_id ='$sub_bill_id'";
            $result = mysqli_query($con,$query);
            $subscription_detail = array();
            while($row = mysqli_fetch_assoc($result))
            {
                array_push($subscription_detail, 
                    $row['sub_bill_id'],
                    $row['company_id'],
                    $row['price'],
                    $row['no_of_months'],
                    $row['ex_rate'],
                    $row['date_start'],
                    $row['amount_dollar'],
                    $row['amount_cedi'],
                    $row['date_end'],
                    $row['date_grace']
                );
            }
             echo json_encode($subscription_detail);
        }

        function company_subscription_update()
        {
            global $con;
            $sub_bill_id = $_POST['sub_bill_id'];
            $price = $_POST['price'];
            $no_of_months = $_POST['no_of_months'];
            $exchange_rate = $_POST['exchange_rate'];
            $start_date = $_POST['start_date'];
            $amount_dollar = $_POST['amount_dollar'];
            $amount_cedi = $_POST['amount_cedi'];
            $expiry_date = $_POST['expiry_date'];
            $date_grace = $_POST['date_grace'];

            $query = "UPDATE `subscription_bill` SET `date_start`='$start_date',
            `date_end`='$expiry_date',`date_grace`='$date_grace',`no_of_months`='$no_of_months',
            `price`='$price',`ex_rate`='$exchange_rate',`amount_dollar`='$amount_dollar',
            `amount_cedi`= '$amount_cedi' WHERE `sub_bill_id`= '$sub_bill_id'";

            mysqli_query($con,$query);
        }

        function company_subscription_delete()
        {
            global $con;
            $sub_bill_id = $_POST['sub_bill_id'];
            $query = "DELETE FROM `subscription_bill` WHERE `sub_bill_id`= '$sub_bill_id'";
            mysqli_query($con,$query);
        }
?>
