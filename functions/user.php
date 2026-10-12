<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');

		//USERS ULTRA-SUPER
        function user_ultra_super_sign_up()
        {
            global $con;
            $company_id = $_POST['company_id'];
            $user_type_id = $_POST['user_type'];
            $user_status = $_POST['user_approval_status'];
            $first_name = stripslashes($_POST['first_name']);
            $first_name = mysqli_real_escape_string($con,$first_name);
            $email = stripslashes($_POST['email']);
            $email = mysqli_real_escape_string($con,$email);
            $telephone = stripslashes($_POST['telephone']);
            $telephone = mysqli_real_escape_string($con,$telephone);
            $address = stripslashes($_POST['address']);
            $address = mysqli_real_escape_string($con,$address);
            $location = stripslashes($_POST['location']);
            $location = mysqli_real_escape_string($con,$location);
            $last_name = stripslashes($_POST['last_name']);
            $last_name = mysqli_real_escape_string($con,$last_name);
            $password = stripslashes($_POST['password']);
            $password = mysqli_real_escape_string($con,$password);
            $user_super_id = stripslashes($_POST['user_super_id']);
            $user_super_id = mysqli_real_escape_string($con,$user_super_id);
            $trn_date = date("Y-m-d H:i:s");
            $query = "SELECT * FROM `users` WHERE `email`='$email'";
            $result = mysqli_query($con,$query);
            if (mysqli_num_rows($result) > 0) 
            {
                echo 'exist';
            }
            else
            {
                $query = "SELECT * FROM `user_super` WHERE `email`='$email'";
                $result = mysqli_query($con,$query);
                if (mysqli_num_rows($result) > 0) 
                {
                    echo 'exist';
                }
                else
                {
                    $query = "INSERT INTO `users`(
                    `user_super_id`,`company_id`,`last_name`,`user_password`,`email`,`telephone`,`address`,`location`,`photo`,`first_name`,`user_type_id`,`user_status`) VALUES (
                    '$user_super_id','$company_id','$last_name','".md5($password)."','$email','$telephone','$address','$location','$first_name','$user_type_id,'$user_status')";
                    $result = mysqli_query($con,$query);
                    
                    //ENTER PRIVILEGES
                    if ($result) 
                    {
                        $query_user = "SELECT * FROM `users` ORDER BY id DESC";
                        $result_user = mysqli_query($con,$query_user);
                        $row_user = mysqli_fetch_assoc($result_user);
                        $user_id = $row_user['id'];

                        $number_as = count($_POST["user_priv_id"]);  
                        if($number_as > 0)  
                        {  
                              for($i=0; $i < $number_as; $i++)  
                              {  
                                   if(trim($_POST["user_priv_id"][$i] != ''))
                                   {  
                                    $user_priv_id = $_POST['user_priv_id'][$i];
                                    $privilege_value = $_POST['privilege_value'][$i];

                                    $query_priv = "INSERT INTO `user_privilege_set`(`user_id`,`user_type_id`,`user_priv_id`, `user_privilege_set`,`company_id`,`user_super_id`) 
                                    VALUES ('$user_id','$user_type_id','$user_priv_id','$privilege_value','$company_id','$user_super_id')";
                                    mysqli_query($con, $query_priv);
                                };
                              }; 
                        };
                        echo 'inserted';
                    };
                };
            };
        }

        function user_ultra_super_save()
        {
            global $con;
            $name = stripslashes($_POST['user_ultra_super_name']);
            $name = mysqli_real_escape_string($con,$name);
            $email = stripslashes($_POST['user_ultra_super_email']);
            $email = mysqli_real_escape_string($con,$email);
            $password = stripslashes($_POST['user_ultra_super_password']);
            $password = mysqli_real_escape_string($con,$password);

            $query_user_ultra = "SELECT * FROM `user_ultra_super` WHERE `email`='$email'";
            $result_user_ultra = mysqli_query($con,$query_user_ultra);
            if (mysqli_num_rows($result_user_ultra) > 0) 
            {
                echo 'exist';
            }
            else
            {
                $query_user = "SELECT * FROM `users` WHERE `email`='$email'";
                $result_user = mysqli_query($con,$query_user);
                if (mysqli_num_rows($result_user) > 0) 
                {
                    echo 'exist';
                }
                else
                {
                    $query_super = "SELECT * FROM `user_super` WHERE `email`='$email'";
                    $result_super = mysqli_query($con,$query_super);
                    if (mysqli_num_rows($result_super) > 0) 
                    {
                        echo 'exist';
                    }
                    else
                    {
                        $query = "INSERT INTO `user_ultra_super`(`name`,`email`,`password`,`user_status`) VALUES (
                        '$name','$email','".md5($password)."','Active')";
                        $result = mysqli_query($con,$query);
                    };
                };
            };
        }

        function user_ultra_super_edit()
        {
            global $con;
            $user_id = $_POST['user_id'];
            $query = "SELECT * from users where id='$user_id'";
            $result = mysqli_query($con,$query);
            $user_detail = array();
            while($row = mysqli_fetch_assoc($result))
            {
                array_push($user_detail, 
                    $row['company_id'],
                    $row['id'],
                    $row['last_name'],
                    $row['user_status'],
                    $row['email'],
                    $row['telephone'],
                    $row['address'],
                    $row['location'],
                    $row['photo'],
                    $row['first_name'],
                    $row['user_super_id'],
                    $row['user_type_id']

                );
            }
             echo json_encode($user_detail);
        }

        function user_ultra_super_update()
        {
            global $con;
            $user_id = $_POST['ucm_user_id'];
            $company_id = $_POST['ucm_company_id'];
            $user_type_id = $_POST['user_type'];
            $user_status = $_POST['user_approval_status'];
            $first_name = stripslashes($_POST['first_name']);
            $first_name = mysqli_real_escape_string($con,$first_name);
            $email = stripslashes($_POST['email']);
            $email = mysqli_real_escape_string($con,$email);
            $telephone = stripslashes($_POST['telephone']);
            $telephone = mysqli_real_escape_string($con,$telephone);
            $address = stripslashes($_POST['address']);
            $address = mysqli_real_escape_string($con,$address);
            $location = stripslashes($_POST['location']);
            $location = mysqli_real_escape_string($con,$location);
            $last_name = stripslashes($_POST['last_name']);
            $last_name = mysqli_real_escape_string($con,$last_name);
            $user_super_id = stripslashes($_POST['ucm_user_super_id']);
            $user_super_id = mysqli_real_escape_string($con,$user_super_id);
            //$trn_date = date("Y-m-d H:i:s");

            $query = "SELECT * FROM `users` WHERE `email`='$email' AND `id`!='$user_id'";
            $result = mysqli_query($con,$query);
            if (mysqli_num_rows($result) > 0) 
            {
                echo 'exist';
            }
            else
            {
                $query = "SELECT * FROM `user_super` WHERE `email`='$email' AND `user_super_id`!='$user_id'";
                $result = mysqli_query($con,$query);
                if (mysqli_num_rows($result) > 0) 
                {
                    echo 'exist';
                }
                else
                {
                    $query = "UPDATE `users` SET `company_id`='$company_id',`user_super_id`='$user_super_id',`user_status`='$user_status',`user_type_id`='$user_type_id',
                    `last_name`='$last_name',`email`='$email',`telephone`='$telephone',`address`='$address',`location`='$location',`first_name`='$first_name' 
                    WHERE `id`='$user_id'";
                    $result = mysqli_query($con,$query);
                    
                    //ENTER PRIVILEGES
                    if ($result) 
                    {
                        $query_del = "DELETE FROM `user_privilege_set` WHERE `user_id`='$user_id'";
                        $result_del = mysqli_query($con,$query_del);

                        $number_as = count($_POST["user_priv_id"]);  
                        if($number_as > 0)  
                        {  
                              for($i=0; $i < $number_as; $i++)  
                              {  
                                   if(trim($_POST["user_priv_id"][$i] != ''))
                                   {  
                                    $user_priv_id = $_POST['user_priv_id'][$i];
                                    $privilege_value = $_POST['privilege_value'][$i];

                                    $query_priv = "INSERT INTO `user_privilege_set`(`user_id`,`user_type_id`,`user_priv_id`, `user_privilege_set`,`company_id`,`user_super_id`) 
                                    VALUES ('$user_id','$user_type_id','$user_priv_id','$privilege_value','$company_id','$user_super_id')";
                                    mysqli_query($con, $query_priv);
                                };
                              }; 
                        };
                        echo 'inserted';
                    };
                };
            };
        }
    //USERS-PERSONAL
        /*function user_personal_save()
        {
            global $con;
            $user_super_id = stripslashes($_POST['user_personal_user_super_id']);
            $user_super_id = mysqli_real_escape_string($con,$user_super_id);
            $company_id = stripslashes($_POST['user_personal_company_id']);
            $company_id = mysqli_real_escape_string($con,$company_id);
            $name = stripslashes($_POST['user_personal_full_name']);
            $name = mysqli_real_escape_string($con,$name);
            $email = stripslashes($_POST['user_personal_email']);
            $email = mysqli_real_escape_string($con,$email);
            $telephone = stripslashes($_POST['user_personal_telephone']);
            $telephone = mysqli_real_escape_string($con,$telephone);
            $password = stripslashes($_POST['user_personal_password']);
            $password = mysqli_real_escape_string($con,$password);
            $trn_date = date("Y-m-d H:i:s");
            $query = "SELECT * FROM `user_super` WHERE `email`='$email'";
            $result = mysqli_query($con,$query);

            if (mysqli_num_rows($result) > 0)
            {
                echo 'exist';
            }
            else
            {
                $query = "SELECT * FROM `users` WHERE `email`='$email'";
                $result = mysqli_query($con,$query);

                if (mysqli_num_rows($result) > 0)
                {
                    echo 'exist';
                }
                else
                {
                    $query = "INSERT INTO `users`(`company_id`,`user_super_id`,`first_name`,`user_password`,`email`,`telephone`,`user_status`) VALUES ('$company_id','$user_super_id','$name','".md5($password)."','$email','$telephone','Pending')";
                    $result = mysqli_query($con,$query);
                    echo 'inserted';
                };
            };
        }

        function user_personal_change_password_update()
        {
            global $con;
            $user_id = stripslashes($_POST['user_personal_change_password_user_id']);
            $user_id = mysqli_real_escape_string($con,$user_id);
            $user_type = stripslashes($_POST['user_personal_change_password_user_type']);
            $user_type = mysqli_real_escape_string($con,$user_type);
            $password_old = stripslashes($_POST['user_personal_change_password_old']);
            $password_old = mysqli_real_escape_string($con,$password_old);
            $hashed_password_old = md5($password_old);
            $password_new = stripslashes($_POST['user_personal_change_password_new']);
            $password_new = mysqli_real_escape_string($con,$password_new);
            $hashed_password_new = md5($password_new);
            if($user_type == "Super_User") 
            {
                $query = "SELECT * FROM `user_super` WHERE `user_super_id`='$user_id'";
                $result = mysqli_query($con,$query);
                if (mysqli_num_rows($result) > 0)
                {
                    $user_row = mysqli_fetch_assoc($result);
                    $db_password_old = $user_row['password'];
                    if ($db_password_old == $hashed_password_old) 
                    {
                        $query = "UPDATE `user_super` SET `password` = '$hashed_password_new' WHERE `user_super_id`='$user_id'";
                        $result = mysqli_query($con,$query);
                        if (isset($result)) 
                        {
                            echo 'password_updated';
                        } else {
                            echo 'password_not_updated';
                        };
                    }
                    else
                    {
                        echo 'old_password_not_match';
                    };
                }
                else
                {
                    echo 'no_user_match';
                };
            } 
            else if($user_type == "Normal_User") 
            {
                $query = "SELECT * FROM `users` WHERE `id`='$user_id'";
                $result = mysqli_query($con,$query);

                if (mysqli_num_rows($result) > 0)
                {
                    $user_row = mysqli_fetch_assoc($result);
                    $db_password_old = $user_row['user_password'];
                    if ($db_password_old == $hashed_password_old) {
                        $query = "UPDATE `users` SET `user_password` = '$hashed_password_new' WHERE `id`='$user_id'";
                        $result = mysqli_query($con,$query);
                        $error = mysqli_error($con);
                        echo $error;
                        if (isset($result)) {
                            echo 'password_updated';
                        } else {
                            echo 'password_not_updated';
                        };
                    }
                    else
                    {
                        echo 'old_password_not_match';
                    };
                }
                else
                {
                    echo 'no_user_match';
                };
            } 
            else if($user_type == "Ultra_Super_User") 
            {
                $query = "SELECT * FROM `user_ultra_super` WHERE `user_ultra_super_id`='$user_id'";
                $result = mysqli_query($con,$query);

                if (mysqli_num_rows($result) > 0)
                {
                    $user_row = mysqli_fetch_assoc($result);
                    $db_password_old = $user_row['password'];
                    if ($db_password_old == $hashed_password_old) {
                        $query = "UPDATE `user_ultra_super` SET `password` = '$hashed_password_new' WHERE `user_ultra_super_id`='$user_id'";
                        $result = mysqli_query($con,$query);
                        $error = mysqli_error($con);
                        echo $error;
                        if (isset($result)) 
                        {
                            echo 'password_updated';
                        } 
                        else 
                        {
                            echo 'password_not_updated';
                        };
                    }
                    else
                    {
                        echo 'old_password_not_match';
                    };
                }
                else
                {
                    echo 'no_user_match';
                };
            };
        }*/
        function user_personal_save()
        {
            global $con;
            $user_super_id = stripslashes($_POST['user_personal_user_super_id']);
            $user_super_id = mysqli_real_escape_string($con,$user_super_id);
            $company_id = stripslashes($_POST['user_personal_company_id']);
            $company_id = mysqli_real_escape_string($con,$company_id);
            $name = stripslashes($_POST['user_personal_full_name']);
            $name = mysqli_real_escape_string($con,$name);
            $email = stripslashes($_POST['user_personal_email']);
            $email = mysqli_real_escape_string($con,$email);
            $telephone = stripslashes($_POST['user_personal_telephone']);
            $telephone = mysqli_real_escape_string($con,$telephone);
            $password = stripslashes($_POST['user_personal_password']);
            $password = mysqli_real_escape_string($con,$password);
            $trn_date = date("Y-m-d H:i:s");
            $query = "SELECT * FROM `user_super` WHERE `email`='$email'";
            $result = mysqli_query($con,$query);

            if (mysqli_num_rows($result) > 0)
            {
                echo 'exist';
            }
            else
            {
                $query = "SELECT * FROM `users` WHERE `email`='$email'";
                $result = mysqli_query($con,$query);

                if (mysqli_num_rows($result) > 0)
                {
                    echo 'exist';
                }
                else
                {
                    $query = "INSERT INTO `users`(`company_id`,`user_super_id`,`first_name`,`user_password`,`email`,`telephone`,`user_status`) VALUES ('$company_id','$user_super_id','$name','".md5($password)."','$email','$telephone','Pending')";
                    $result = mysqli_query($con,$query);
                    echo 'inserted';
                };
            };
        }

        function user_personal_change_password_update()
        {
            global $con;
            $user_id = stripslashes($_POST['user_personal_change_password_user_id']);
            $user_id = mysqli_real_escape_string($con,$user_id);
            $user_type = stripslashes($_POST['user_personal_change_password_user_type']);
            $user_type = mysqli_real_escape_string($con,$user_type);
            $password_old = stripslashes($_POST['user_personal_change_password_old']);
            $password_old = mysqli_real_escape_string($con,$password_old);
            $hashed_password_old = md5($password_old);
            $password_new = stripslashes($_POST['user_personal_change_password_new']);
            $password_new = mysqli_real_escape_string($con,$password_new);
            $hashed_password_new = md5($password_new);
            if ($user_type == "Super_User") 
            {
                $query = "SELECT * FROM `user_super` WHERE `user_super_id`='$user_id'";
                $result = mysqli_query($con,$query);
                if (mysqli_num_rows($result) > 0)
                {
                    $user_row = mysqli_fetch_assoc($result);
                    $db_password_old = $user_row['password'];
                    if ($db_password_old == $hashed_password_old) {
                        $query = "UPDATE `user_super` SET `password` = '$hashed_password_new' WHERE `user_super_id`='$user_id'";
                        $result = mysqli_query($con,$query);
                        if (isset($result)) {
                            echo 'password_updated';
                        } else {
                            echo 'password_not_updated';
                        };
                    }
                    else
                    {
                        echo 'old_password_not_match';
                    };
                }
                else
                {
                    echo 'no_user_match';
                };
            } 
            else if($user_type == "Normal_User") 
            {
                $query = "SELECT * FROM `users` WHERE `id`='$user_id'";
                $result = mysqli_query($con,$query);

                if (mysqli_num_rows($result) > 0)
                {
                    $user_row = mysqli_fetch_assoc($result);
                    $db_password_old = $user_row['user_password'];
                    if ($db_password_old == $hashed_password_old) {
                        $query = "UPDATE `users` SET `user_password` = '$hashed_password_new' WHERE `id`='$user_id'";
                        $result = mysqli_query($con,$query);
                        $error = mysqli_error($con);
                        echo $error;
                        if (isset($result)) {
                            echo 'password_updated';
                        } else {
                            echo 'password_not_updated';
                        };
                    }
                    else
                    {
                        echo 'old_password_not_match';
                    };
                }
                else
                {
                    echo 'no_user_match';
                };
            };
        }

        function user_personal_reset_password_update()
        {
            global $con;
            $user_id = stripslashes($_POST['user_personal_reset_password_user_id']);
            $user_id = mysqli_real_escape_string($con,$user_id);
            $password_new = stripslashes($_POST['user_personal_reset_password_new']);
            $password_new = mysqli_real_escape_string($con,$password_new);
            $hashed_password_new = md5($password_new);
            $password_confirm = stripslashes($_POST['user_personal_reset_password_confirm']);
            $password_confirm = mysqli_real_escape_string($con,$password_confirm);
            $hashed_password_confirm = md5($password_confirm);
            
            if ($hashed_password_confirm == $hashed_password_new) 
            {
                $query = "UPDATE `users` SET `user_password` = '$hashed_password_new' 
                WHERE `id`='$user_id'";
                $result = mysqli_query($con,$query);
                if (isset($result)) 
                {
                    echo 'password_updated';
                } 
                else 
                {
                    echo 'password_not_updated';
                };
            }
            else
            {
                echo 'password_do_not_match';
            };
        }
    //USERS-ADMIN
        function user_admin_save()
        {
            global $con;
            $name = stripslashes($_POST['user_admin_name']);
            $name = mysqli_real_escape_string($con,$name);
            $email = stripslashes($_POST['user_admin_email']);
            $email = mysqli_real_escape_string($con,$email);
            $telephone = stripslashes($_POST['user_admin_telephone']);
            $telephone = mysqli_real_escape_string($con,$telephone);
            $password = stripslashes($_POST['user_admin_password']);
            $password = mysqli_real_escape_string($con,$password);
            $trn_date = date("Y-m-d H:i:s");
            $query = "SELECT * FROM `user_super`WHERE `email`='$email'";
            $result = mysqli_query($con,$query);

            if (mysqli_num_rows($result) > 0)
            {
                echo 'exist';
            }
            else
            {
                $query = "SELECT * FROM `users`WHERE `email`='$email'";
                $result = mysqli_query($con,$query);

                if (mysqli_num_rows($result) > 0)
                {
                    echo 'exist';
                }
                else
                {
                    $query = "INSERT INTO `user_super`(`name`,`password`,`email`,`telephone`) VALUES ('$name','".md5($password)."','$email','$telephone')";
                    $result = mysqli_query($con,$query);
                    echo 'inserted';
                    $query = "SELECT * FROM `user_super` WHERE email ='$email'";
                    $result = mysqli_query($con,$query) or die(mysql_error());
                    if(mysqli_num_rows($result) == 1)
                    {
                        $user_super_row = mysqli_fetch_assoc($result);
                        $_SESSION['user_super_id'] = $user_super_row['user_super_id'];
                        $_SESSION['user_super_name'] = $user_super_row['name'];
                        $_SESSION['username'] = $user_super_row['name'];
                        
                        $_SESSION['user_id'] = $user_super_row['user_super_id'];
                        $_SESSION['user_type_id'] = '';
                        $_SESSION['user_type'] = 'Super_User';
                        $_SESSION['full_name'] = $user_super_row['name'];
                        $_SESSION['company_id'] = '';
                        $_SESSION['email'] = $email;
                    };
                };
            };
        }

        function user_admin_edit()
        {
            global $con;
            $user_id = $_POST['user_id'];
            $query = "SELECT * from users where id='$user_id'";
            $result = mysqli_query($con,$query);
            $user_detail = array();
            while($row = mysqli_fetch_assoc($result))
            {
                array_push($user_detail, 
                    $row['company_id'],
                    $row['id'],
                    $row['username'],
                    $row['password'],
                    $row['email'],
                    $row['telephone'],
                    $row['address'],
                    $row['location'],
                    $row['photo'],
                    $row['full_name']

                );
            }
             echo json_encode($user_detail);
        }

        function user_admin_update()
        {
            global $con;
            $user_id = $_POST['user_id'];
            $company_id = $_POST['company_id'];
            $full_name = stripslashes($_POST['full_name']);
            $full_name = mysqli_real_escape_string($con,$full_name);
            $email = stripslashes($_POST['email']);
            $email = mysqli_real_escape_string($con,$email);
            $telephone = stripslashes($_POST['telephone']);
            $telephone = mysqli_real_escape_string($con,$telephone);
            $address = stripslashes($_POST['address']);
            $address = mysqli_real_escape_string($con,$address);
            $location = stripslashes($_POST['location']);
            $location = mysqli_real_escape_string($con,$location);
            $username = stripslashes($_POST['username']);
            $username = mysqli_real_escape_string($con,$username);
            $password = stripslashes($_POST['password']);
            $password = mysqli_real_escape_string($con,$password);
            $photo = $_POST['photo'];
            $trn_date = date("Y-m-d H:i:s");

            $query = "UPDATE `users` SET `company_id`='$company_id',`username`='$username',`email`='$email',`telephone`='$telephone',`address`='$address',
            `location`='$location',`photo`='$photo',`full_name`='$full_name',`password`='".md5($password)."' WHERE `id`='$user_id'";
            $result = mysqli_query($con,$query);
        }
    //USER TYPE
        function user_type_save()
        {
            global $con;
            $user_type_desc = $_POST['user_type_desc'];
            $user_type_desc = stripslashes($_POST['user_type_desc']);
            $user_type_desc = mysqli_real_escape_string($con,$user_type_desc);
            
            $query_user_type = "INSERT INTO `user_type`(`user_type_desc`) VALUES ('$user_type_desc')";
            $result_user_type = mysqli_query($con,$query_user_type);

            //ENTER PRIVILEGES
            if ($result_user_type) 
            {
                $query = "SELECT * FROM user_type ORDER BY user_type_id DESC";
                $result = mysqli_query($con,$query);
                $row = mysqli_fetch_assoc($result);
                $user_type_id = $row['user_type_id'];

                $number_as = count($_POST["privilege_id"]);  
                if($number_as > 0)  
                {  
                      for($i=0; $i < $number_as; $i++)  
                      {  
                           if(trim($_POST["privilege_id"][$i] != ''))
                           {  
                            $privilege_id = $_POST['privilege_id'][$i];
                            $privilege_value = $_POST['privilege_value'][$i];

                            $query_priv = "INSERT INTO `user_type_privilege_set`(`user_type_id`,`user_priv_id`, `user_privilege_set`) 
                            VALUES ('$user_type_id','$privilege_id','$privilege_value')";
                            mysqli_query($con, $query_priv);
                        };
                      }; 
                };
            }
        }

        function user_type_edit()
        {
            global $con;
            $user_type_id = $_POST['user_type_id'];
            $query = "SELECT * from user_type where user_type_id='$user_type_id'";
            $result = mysqli_query($con,$query);
            $user_type_detail = array();
            while($row = mysqli_fetch_assoc($result))
            {
                array_push($user_type_detail, 
                    $row['user_type_id'],
                    $row['user_type_desc']
                );
            }
             echo json_encode($user_type_detail);
        }

        function user_type_update()
        {
            global $con;
            $user_type_desc = $_POST['user_type_desc'];
            $user_type_id = $_POST['user_type_id'];
            $user_type_desc = stripslashes($_POST['user_type_desc']);
            $user_type_desc = mysqli_real_escape_string($con,$user_type_desc);

            $query = "UPDATE `user_type` SET `user_type_desc`='$user_type_desc' WHERE `user_type_id`='$user_type_id'";
            $result = mysqli_query($con,$query);

            if ($result) 
            {
                $query_del = "DELETE FROM `user_type_privilege_set` WHERE `user_type_id`='$user_type_id'";
                mysqli_query($con,$query_del);

                $number_as = count($_POST["privilege_id"]);  
                if($number_as > 0)  
                {  
                      for($i=0; $i < $number_as; $i++)  
                      {  
                           if(trim($_POST["privilege_id"][$i] != ''))
                           {  
                            $privilege_id = $_POST['privilege_id'][$i];
                            $privilege_value = $_POST['privilege_value'][$i];

                            $query_priv = "INSERT INTO `user_type_privilege_set`(`user_type_id`,`user_priv_id`, `user_privilege_set`) 
                            VALUES ('$user_type_id','$privilege_id','$privilege_value')";
                            mysqli_query($con, $query_priv);
                        };
                      }; 
                };
            };
        }

        function user_type_privilege_list()
        {
            global $con;
            $user_type_id = $_POST['user_type_id'];
            $value = "";
            if ($user_type_id !=="" && $user_type_id > 0) 
            {
                $value ='<div class="accordion-option">
                            <a href="javascript:void(0)" class="toggle-accordion active" accordion-id="#accordion"></a>
                        </div>
                        <div class="clearfix"></div>
                              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';

                //SELECT PAGES
                $query_pages = "SELECT * FROM `user_pages` ORDER BY `user_page_id` ASC";
                $query_run_pages = mysqli_query($con,$query_pages);
                if(mysqli_num_rows($query_run_pages) > 0)
                {
                    while($row_pages = mysqli_fetch_assoc($query_run_pages))
                    {
                        $value.='<div class="panel panel-default">
                                  <div class="panel-heading" role="tab" id="heading'.$row_pages['user_page_id'].'">
                                    <h6 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$row_pages['user_page_id'].'" aria-expanded="true" aria-controls="collapse'.$row_pages['user_page_id'].'">
                                        <h6 class="m-0 font-weight-bold text-primary">'.$row_pages['page'].'</h6>
                                        </a>
                                      </h6>
                                  </div>
                                  <div id="response"></div>  
                                <div id="collapse'.$row_pages['user_page_id'].'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading'.$row_pages['user_page_id'].'">
                                    <div class="panel-body">';
                        $user_page_id = $row_pages['user_page_id'];
                        $query = "SELECT * FROM `user_privilege` WHERE `user_page_id`='$user_page_id'";
                        $query_run = mysqli_query($con,$query);
                        //if(mysqli_num_rows($query_run) > 0)
                        //{
                            while($row = mysqli_fetch_assoc($query_run))
                            {
                                $user_priv_id = $row['user_priv_id'];
                                $query_utp = "SELECT * FROM `user_type_privilege_set` WHERE `user_type_id`= '$user_type_id' AND `user_priv_id`='$user_priv_id'";
                                $query_run_utp = mysqli_query($con,$query_utp);
                                if(mysqli_num_rows($query_run_utp) > 0)
                                {
                                    $row_utp = mysqli_fetch_assoc($query_run_utp);
                                    $value.='<div class="form-row">
                                                <div class="col-md-8 mb-8">
                                                    <select class="form-control privilege_select bg-light" name="privilege_id[]" id="privilege_id'.$row_utp['user_priv_id'].'" data-id="'.$row_utp['user_priv_id'].'" style="border-width:0px" hidden="true">
                                                        <option value = "'.$row_utp['user_priv_id'].'" selected="selected">'.$row['user_privilege'].'</option>
                                                    </select>
                                                    <select class="form-control privilege_selectD bg-light" name="privilege_idD[]" id="privilege_idD'.$row_utp['user_priv_id'].'" data-id="D'.$row_utp['user_priv_id'].'" style="border-width:0px" disabled="true">
                                                        <option value = "'.$row_utp['user_priv_id'].'" selected="selected">'.$row['user_privilege'].'</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <select class="form-control bg-light" name="privilege_value[]" id="privilege_value'.$row_utp['user_priv_id'].'"> 
                                                        <option value="0">Please Select</option>';
                                                    if ($row_utp['user_privilege_set'] =="Yes") 
                                                    {
                                                        $value.='<option value="Yes" selected="selected">Yes</option>
                                                        <option value="No">No</option>';
                                                    } 
                                                    else 
                                                    {
                                                        $value.='<option value="Yes">Yes</option>
                                                        <option value="No" selected="selected">No</option>';
                                                    };
                                            $value.='</select>
                                                </div>
                                            </div>';
                                }
                                else
                                {
                                    $value.='<div class="form-row">
                                            <div class="col-md-8 mb-8">
                                                <select class="form-control privilege_select bg-light" name="privilege_id[]" id="privilege_id'.$row['user_priv_id'].'" data-id="'.$row['user_priv_id'].'" style="border-width:0px" hidden="true">
                                                    <option value = "'.$row['user_priv_id'].'" selected="selected">'.$row['user_privilege'].'</option>
                                                </select>
                                                <select class="form-control privilege_selectD bg-light" name="privilege_idD[]" id="privilege_idD'.$row['user_priv_id'].'" data-id="D'.$row['user_priv_id'].'" style="border-width:0px" disabled="true">
                                                    <option value = "'.$row['user_priv_id'].'" selected="selected">'.$row['user_privilege'].'</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <select class="form-control bg-light" name="privilege_value[]" id="privilege_value'.$row['user_priv_id'].'"> 
                                                    <option value="0">Please Select</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>';

                                    $value.='</div>
                                        </div>';
                                };
                            };
                        //}
                        //else
                        //{
                            //$value = "No Privileges found";
                        //};
                        $value.='</div>
                                    </div>
                                </div>
                                <hr class="d-none d-md-block">';
                    };
                }
                else
                {
                    $value = "No Pages found";
                };
            } 
            else 
            {
                $value ='<div class="accordion-option">
                            <a href="javascript:void(0)" class="toggle-accordion active" accordion-id="#accordion"></a>
                        </div>
                        <div class="clearfix"></div>
                              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';

                //SELECT PAGES
                $query_pages = "SELECT * FROM `user_pages` ORDER BY `user_page_id` ASC";
                $query_run_pages = mysqli_query($con,$query_pages);
                if(mysqli_num_rows($query_run_pages) > 0)
                {
                    while($row_pages = mysqli_fetch_assoc($query_run_pages))
                    {
                        $value.='<div class="panel panel-default">
                                  <div class="panel-heading" role="tab" id="heading'.$row_pages['user_page_id'].'">
                                    <h6 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$row_pages['user_page_id'].'" aria-expanded="true" aria-controls="collapse'.$row_pages['user_page_id'].'">
                                        <h6 class="m-0 font-weight-bold text-primary">'.$row_pages['page'].'</h6>
                                        </a>
                                      </h6>
                                  </div>
                                  <div id="response"></div>  
                                <div id="collapse'.$row_pages['user_page_id'].'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading'.$row_pages['user_page_id'].'">
                                    <div class="panel-body">';
                        $user_page_id = $row_pages['user_page_id'];
                        $query = "SELECT * FROM `user_privilege` WHERE `user_page_id` = '$user_page_id'";
                        $query_run = mysqli_query($con,$query);
                        //if(mysqli_num_rows($query_run) > 0)
                        //{
                            while($row = mysqli_fetch_assoc($query_run))
                            {
                                $value.='<div class="form-row">
                                            <div class="col-md-8 mb-8">
                                                <select class="form-control privilege_select bg-light" name="privilege_id[]" id="privilege_id'.$row['user_priv_id'].'" data-id="'.$row['user_priv_id'].'" style="border-width:0px" hidden="true">
                                                    <option value = "'.$row['user_priv_id'].'" selected="selected">'.$row['user_privilege'].'</option>
                                                </select>
                                                <select class="form-control privilege_selectD bg-light" name="privilege_idD[]" id="privilege_idD'.$row['user_priv_id'].'" data-id="D'.$row['user_priv_id'].'" style="border-width:0px" disabled="true">
                                                    <option value = "'.$row['user_priv_id'].'" selected="selected">'.$row['user_privilege'].'</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-4">
                                                <select class="form-control bg-light" name="privilege_value[]" id="privilege_value'.$row['user_priv_id'].'"> 
                                                    <option value="0">Please Select</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>';

                                    $value.='</div>
                                        </div>';
                            };
                        //}
                        //else
                        //{
                            //$value = "No Privileges found";
                        //};

                        $value.='</div>
                                    </div>
                                </div>
                                <hr class="d-none d-md-block">';
                    };
                }
                else
                {
                    $value = "No Pages found";
                };
            };
            echo $value;
        }
    //USER PRIVILEGES
        function user_privilege_save()
        {
            global $con;
            $user_priv_page_id = $_POST['user_priv_page_id'];
            $user_privilege_desc = $_POST['user_privilege_desc'];
            $user_privilege_desc = stripslashes($_POST['user_privilege_desc']);
            $user_privilege_desc = mysqli_real_escape_string($con,$user_privilege_desc);
            
            $query = "INSERT INTO `user_privilege`(`user_privilege`,`user_page_id`) VALUES ('$user_privilege_desc','$user_priv_page_id')";
            $result = mysqli_query($con,$query);
        }

        function user_privilege_edit()
        {
            global $con;
            $user_priv_id = $_POST['user_priv_id'];
            $query = "SELECT * FROM user_privilege WHERE user_priv_id='$user_priv_id'";
            $result = mysqli_query($con,$query);
            $user_privilege_detail = array();
            while($row = mysqli_fetch_assoc($result))
            {
                array_push($user_privilege_detail, 
                    $row['user_priv_id'],
                    $row['user_privilege'],
                    $row['user_page_id']
                );
            }
             echo json_encode($user_privilege_detail);
        }

        function user_privilege_update()
        {
            global $con;
            $user_priv_page_id = $_POST['user_priv_page_id'];
            $user_privilege_desc = $_POST['user_privilege_desc'];
            $user_priv_id = $_POST['user_privilege_id'];
            $user_privilege_desc = stripslashes($_POST['user_privilege_desc']);
            $user_privilege_desc = mysqli_real_escape_string($con,$user_privilege_desc);

            $query = "UPDATE `user_privilege` SET `user_privilege`='$user_privilege_desc',`user_page_id`='$user_priv_page_id'  WHERE `user_priv_id`='$user_priv_id'";
            $result = mysqli_query($con,$query);
        }
    //USERS
        function user_sign_in()
        {
            global $con;
            $user_sign_in_detail = array();
            $type = '';
            $email = stripslashes($_REQUEST['user_email']);
            $email = mysqli_real_escape_string($con,$email);
            $password = stripslashes($_REQUEST['user_password']);
            $password = mysqli_real_escape_string($con,$password);
            $query = "SELECT * FROM `users` WHERE `email` ='$email' AND user_password ='".md5($password)."'";
            $result = mysqli_query($con,$query) or die(mysqli_error($con));
            if(mysqli_num_rows($result) == 1)
            {
                $user_row = mysqli_fetch_assoc($result);
                $user_status = $user_row['user_status'];
                $company_id = $user_row['company_id'];
                $query_sub_bill = "SELECT * FROM `subscription_bill` WHERE `company_id` ='$company_id'
                ORDER BY date_end DESC";
                $result_sub_bill = mysqli_query($con,$query_sub_bill);
                $row_sub_bill = mysqli_fetch_assoc($result_sub_bill);
                
                $date_grace = $row_sub_bill['date_grace'];
                $date_end = $row_sub_bill['date_end'];
                if ($user_status == "Accepted")
                {
                    $date = date("Y-m-d");
                    
                    if($row_sub_bill['date_grace'] < $date)
                    {
                        $type = "Expired_Closed";
                    }
                    else if($row_sub_bill['date_grace'] >= $date)
                    {
                        if($row_sub_bill['date_end'] >= $date)
                        {
                            $query_company = "SELECT * FROM `company` WHERE `company_id` ='$company_id'";
                            $result_company = mysqli_query($con,$query_company);
                            $row_company = mysqli_fetch_assoc($result_company);
                            $status = $row_company['status'];
                            if($status == 'Active')
                            {
                                $_SESSION['user_super_id'] = '';
                                $_SESSION['user_id'] = $user_row['id'];
                                $_SESSION['user_telephone'] = $user_row['telephone'];
                                $_SESSION['user_type'] = 'Normal_User';
                                $_SESSION['user_type_id'] = $user_row['user_type_id'];
                                $_SESSION['full_name'] = $user_row['first_name'].' '.$user_row['last_name'];
                                $_SESSION['company_id'] = $user_row['company_id'];
                                $_SESSION['email'] = $email;
                                if(isset($user_row['branch_id']))
                                {
                                    $branch_id = $user_row['branch_id'];
                                    $query_branch = "SELECT * FROM branch WHERE branch_id='$branch_id'";
                                    $result_branch = mysqli_query($con,$query_branch);
                                    $row_branch = mysqli_fetch_assoc($result_branch);
                                    if(isset($row_branch['warehouse_id']))
                                    {
                                        $_SESSION['warehouse_id'] = $row_branch['warehouse_id'];
                                    }
                                    else
                                    {
                                        $_SESSION['warehouse_id'] = '';
                                    };

                                    if(isset($row_branch['cash_ledger_id']))
                                    {
                                        $_SESSION['cash_ledger_id'] = $row_branch['cash_ledger_id'];
                                    }
                                    else
                                    {
                                        $_SESSION['cash_ledger_id'] = '';
                                    };
                                    $_SESSION['branch_id'] = $user_row['branch_id'];
                                }
                                else
                                {
                                    $query_branch = "SELECT * FROM branch WHERE company_id='".$_POST['company_id']."'
                                    ORDER BY branch_id ASC";
                                    $result_branch = mysqli_query($con,$query_branch);
                                    $row_branch = mysqli_fetch_assoc($result_branch);
                                    $_SESSION['branch_id'] = $row_branch['branch_id'];
                                    $_SESSION['warehouse_id'] = $row_branch['warehouse_id'];
                                    $_SESSION['cash_ledger_id'] = $row_branch['cash_ledger_id'];
                                };

                                if(isset($row_company['company_type_id']))
                                {
                                    $_SESSION['company_type_id'] = $row_company['company_type_id'];
                                }
                                else
                                {
                                    $_SESSION['company_type_id'] = '';
                                };

                                if(isset($row_company['sms']))
                                {
                                    $_SESSION['company_sms'] = $row_company['sms'];
                                }
                                else
                                {
                                    $_SESSION['company_sms'] = '';
                                };

                                $user_id = $user_row['id'];
                                $query = "SELECT * FROM `user_privilege_set` WHERE `user_id` ='$user_id'";
                                $result = mysqli_query($con,$query);
                                if(mysqli_num_rows($result) > 0)
                                {
                                    while($user_priv_set_row = mysqli_fetch_assoc($result))
                                    {
                                        $user_priv_id = $user_priv_set_row['user_priv_id'];
                                        $query_priv = "SELECT * FROM `user_privilege` WHERE `user_priv_id` ='$user_priv_id'";
                                        $result_priv = mysqli_query($con,$query_priv);
                                        $user_priv_row = mysqli_fetch_assoc($result_priv);
                                        $privilege = $user_priv_row['user_privilege'];
                                        $_SESSION[$privilege] = $user_priv_set_row['user_privilege_set'];
                                    };
                                };
                                $type = "Normal_User";
                            }
                            else
                            {
                                $type = "Closed";
                            };
                        }
                        else
                        {
                            $type = "Expired_Grace";
                        };
                    };
                } 
                else if($user_status == "Pending")
                {
                    $type = "Pending";
                }
                else if($user_status == "Rejected")
                {
                    $type = "Rejected";
                }
                else if($user_status == "Revoked")
                {
                    $type = "Revoked";
                };
            }
            else
            {
                $date_grace = 'N/A';
                $date_end = 'N/A';

                $query = "SELECT * FROM `user_super` WHERE `email` ='$email' and password ='".md5($password)."'";
                $result = mysqli_query($con,$query) or die(mysqli_error($con));
                
                if(mysqli_num_rows($result) == 1)
                {
                    $user_row = mysqli_fetch_assoc($result);
                    $_SESSION['user_super_id'] = $user_row['user_super_id'];
                    $_SESSION['user_id'] = $user_row['user_super_id'];
                    $_SESSION['user_type'] = 'Super_User';
                    $_SESSION['user_type_id'] = '';
                    $_SESSION['full_name'] = $user_row['name'];
                    $_SESSION['company_id'] = '';
                    $_SESSION['email'] = $email;
                    $type = "Super_User";
                }
                else
                {
                    $query = "SELECT * FROM `user_ultra_super` WHERE `email` ='$email' and password ='".md5($password)."'";
                    $result = mysqli_query($con,$query) or die(mysqli_error($con));
                    
                    if(mysqli_num_rows($result) == 1)
                    {
                        $user_row = mysqli_fetch_assoc($result);
                        $_SESSION['user_ultra_super_id'] = $user_row['user_ultra_super_id'];
                        $_SESSION['user_type'] = 'Ultra_Super_User';
                        $_SESSION['user_type_id'] = '';
                        $_SESSION['full_name'] = $user_row['name'];
                        $_SESSION['email'] = $email;
                        $type = "Ultra_Super_User";
                    }
                    else
                    {
                        $type = "User_Not_Registered";
                     };
                 };
             };
                array_push($user_sign_in_detail, 
                    $date_grace,
                    $date_end,
                    $type
                );
                echo json_encode($user_sign_in_detail);
        }

        function user_company_user_sign_up()
        {
            global $con;
            $company_id = $_POST['company_id'];
            $user_type_id = $_POST['user_type'];
            $user_status = $_POST['user_approval_status'];
            $first_name = stripslashes($_POST['first_name']);
            $first_name = mysqli_real_escape_string($con,$first_name);
            $email = stripslashes($_POST['email']);
            $email = mysqli_real_escape_string($con,$email);
            $telephone = stripslashes($_POST['telephone']);
            $telephone = mysqli_real_escape_string($con,$telephone);
            $address = stripslashes($_POST['address']);
            $address = mysqli_real_escape_string($con,$address);
            $location = stripslashes($_POST['location']);
            $location = mysqli_real_escape_string($con,$location);
            $last_name = stripslashes($_POST['last_name']);
            $last_name = mysqli_real_escape_string($con,$last_name);
            $password = stripslashes($_POST['password']);
            $password = mysqli_real_escape_string($con,$password);
            $user_super_id = stripslashes($_POST['user_super_id']);
            $user_super_id = mysqli_real_escape_string($con,$user_super_id);
            $trn_date = date("Y-m-d H:i:s");
            $query = "SELECT * FROM `users` WHERE `email`='$email'";
            $result = mysqli_query($con,$query);
            if (mysqli_num_rows($result) > 0) 
            {
                echo 'exist';
            }
            else
            {
                $query = "SELECT * FROM `user_super` WHERE `email`='$email'";
                $result = mysqli_query($con,$query);
                if (mysqli_num_rows($result) > 0) 
                {
                    echo 'exist';
                }
                else
                {
                    $query = "INSERT INTO `users`(
                    `user_super_id`,`company_id`,`last_name`,`user_password`,`email`,`telephone`,`address`,`location`,`photo`,`first_name`,`user_type_id`,`user_status`) VALUES (
                    '$user_super_id','$company_id','$last_name','".md5($password)."','$email','$telephone','$address','$location','$first_name','$user_type_id,'$user_status')";
                    $result = mysqli_query($con,$query);
                    
                    //ENTER PRIVILEGES
                    if ($result) 
                    {
                        $query_user = "SELECT * FROM `users` ORDER BY id DESC";
                        $result_user = mysqli_query($con,$query_user);
                        $row_user = mysqli_fetch_assoc($result_user);
                        $user_id = $row_user['id'];

                        $number_as = count($_POST["user_priv_id"]);  
                        if($number_as > 0)  
                        {  
                              for($i=0; $i < $number_as; $i++)  
                              {  
                                   if(trim($_POST["user_priv_id"][$i] != ''))
                                   {  
                                    $user_priv_id = $_POST['user_priv_id'][$i];
                                    $privilege_value = $_POST['privilege_value'][$i];

                                    $query_priv = "INSERT INTO `user_privilege_set`(`user_id`,`user_type_id`,`user_priv_id`, `user_privilege_set`,`company_id`,`user_super_id`) 
                                    VALUES ('$user_id','$user_type_id','$user_priv_id','$privilege_value','$company_id','$user_super_id')";
                                    mysqli_query($con, $query_priv);
                                };
                              }; 
                        };
                        echo 'inserted';
                    };
                };
            };
        }

        function user_save()
        {
            global $con;
            $company_id = $_POST['ucm_company_id'];
            $user_type_id = $_POST['user_type'];
            $user_status = $_POST['user_approval_status'];
            $first_name = stripslashes($_POST['first_name']);
            $first_name = mysqli_real_escape_string($con,$first_name);
            $email = stripslashes($_POST['email']);
            $email = mysqli_real_escape_string($con,$email);
            $telephone = stripslashes($_POST['telephone']);
            $telephone = mysqli_real_escape_string($con,$telephone);
            $address = stripslashes($_POST['address']);
            $address = mysqli_real_escape_string($con,$address);
            $location = stripslashes($_POST['location']);
            $location = mysqli_real_escape_string($con,$location);
            $warehouse_id = stripslashes($_POST['warehouse_id']);
            $warehouse_id = mysqli_real_escape_string($con,$warehouse_id);
            $last_name = stripslashes($_POST['last_name']);
            $last_name = mysqli_real_escape_string($con,$last_name);
            $user_super_id = stripslashes($_POST['ucm_user_super_id']);
            $user_super_id = mysqli_real_escape_string($con,$user_super_id);
            //$trn_date = date("Y-m-d H:i:s");

            $query_user = "SELECT * FROM `users` WHERE `email`='$email'";
            $result_user = mysqli_query($con,$query_user);
            if (mysqli_num_rows($result_user) > 0) 
            {
                echo 'exist';
            }
            else
            {
                $query_super = "SELECT * FROM `user_super` WHERE `email`='$email'";
                $result_super = mysqli_query($con,$query_super);
                if (mysqli_num_rows($result_super) > 0) 
                {
                    echo 'exist';
                }
                else
                {
                    $query = "INSERT INTO `users`(
                    `user_super_id`,`company_id`,`last_name`,`email`,`telephone`,`address`,`location`,
                    `first_name`,`user_type_id`,`user_status`,`warehouse_id`) VALUES ('$user_super_id','$company_id',
                    '$last_name','$email','$telephone','$address','$location','$first_name','$user_type_id',
                    '$user_status','$warehouse_id')";
                    $result = mysqli_query($con,$query);
                    
                    
                    //ENTER PRIVILEGES
                    if (isset($result)) 
                    {
                        $query_user = "SELECT * FROM `users` ORDER BY id DESC";
                        $result_user = mysqli_query($con,$query_user);
                        $row_user = mysqli_fetch_assoc($result_user);
                        $user_id = $row_user['id'];

                        $number_as = count($_POST["user_priv_id"]);  
                        if($number_as > 0)  
                        {  
                              for($i=0; $i < $number_as; $i++)
                              {  
                                   if(trim($_POST["user_priv_id"][$i] != ''))
                                   {  
                                    $user_priv_id = $_POST['user_priv_id'][$i];
                                    $privilege_value = $_POST['privilege_value'][$i];

                                    $query_priv = "INSERT INTO `user_privilege_set`(`user_id`,`user_type_id`,`user_priv_id`, `user_privilege_set`,`company_id`,`user_super_id`) 
                                    VALUES ('$user_id','$user_type_id','$user_priv_id','$privilege_value','$company_id','$user_super_id')";
                                    mysqli_query($con, $query_priv);
                                };
                              }; 
                        };

                        //USER CASH LEDGER
                        $number_as = count($_POST["user_cash_ledger_id"]);  
                        if($number_as > 0)  
                        {  
                              for($i=0; $i<$number_as; $i++)  
                              {  
                                   if(trim($_POST["user_cash_ledger_id"][$i] != '' && $_POST["user_cash_ledger_id"][$i] > 0))
                                   {  
                                    $user_cash_ledger_id = $_POST['user_cash_ledger_id'][$i];

                                    $query_user_cash_ledger = "INSERT INTO `user_cash_ledger`(
                                    `user_id`,`ledger_id`, `principal`, `company_id`, `user_super_id`) VALUES (
                                    '$user_id','$user_cash_ledger_id','No','$company_id','$user_super_id')";
                                    mysqli_query($con, $query_user_cash_ledger);
                                };
                              }; 
                        };
                        echo 'inserted';
                    };
                };
            };
        }

        function user_edit()
        {
            global $con;
            $user_id = $_POST['user_id'];
            $query = "SELECT * from users where id='$user_id'";
            $result = mysqli_query($con,$query);
            $user_detail = array();
            while($row = mysqli_fetch_assoc($result))
            {
                array_push($user_detail, 
                    $row['company_id'],
                    $row['id'],
                    $row['last_name'],
                    $row['user_status'],
                    $row['email'],
                    $row['telephone'],
                    $row['address'],
                    $row['location'],
                    $row['photo'],
                    $row['first_name'],
                    $row['user_super_id'],
                    $row['user_type_id'],
                    $row['warehouse_id'],
                    $row['branch_id']

                );
            }
             echo json_encode($user_detail);
        }

        function user_update()
        {
            global $con;
            $user_id = $_POST['ucm_user_id'];
            $company_id = $_POST['ucm_company_id'];
            $user_type_id = $_POST['user_type'];
            $user_status = $_POST['user_approval_status'];
            $first_name = stripslashes($_POST['first_name']);
            $first_name = mysqli_real_escape_string($con,$first_name);
            $email = stripslashes($_POST['email']);
            $email = mysqli_real_escape_string($con,$email);
            $telephone = stripslashes($_POST['telephone']);
            $telephone = mysqli_real_escape_string($con,$telephone);
            $address = stripslashes($_POST['address']);
            $address = mysqli_real_escape_string($con,$address);
            $location = stripslashes($_POST['location']);
            $location = mysqli_real_escape_string($con,$location);
            $warehouse_id = stripslashes($_POST['warehouse_id']);
            $warehouse_id = mysqli_real_escape_string($con,$warehouse_id);
            $last_name = stripslashes($_POST['last_name']);
            $last_name = mysqli_real_escape_string($con,$last_name);
            $user_super_id = stripslashes($_POST['ucm_user_super_id']);
            $user_super_id = mysqli_real_escape_string($con,$user_super_id);
            //$trn_date = date("Y-m-d H:i:s");

            $query = "SELECT * FROM `users` WHERE `email`='$email' AND `id`!='$user_id'";
            $result = mysqli_query($con,$query);
            if (mysqli_num_rows($result) > 0) 
            {
                echo 'exist';
            }
            else
            {
                $query = "SELECT * FROM `user_super` WHERE `email`='$email' AND `user_super_id`!='$user_id'";
                $result = mysqli_query($con,$query);
                if (mysqli_num_rows($result) > 0) 
                {
                    echo 'exist';
                }
                else
                {
                    $query = "UPDATE `users` SET `company_id`='$company_id',`user_super_id`='$user_super_id',
                    `user_status`='$user_status',`user_type_id`='$user_type_id',`last_name`='$last_name',
                    `email`='$email',`telephone`='$telephone',`address`='$address',`location`='$location',
                    `first_name`='$first_name',`warehouse_id`='$warehouse_id' 
                    WHERE `id`='$user_id'";
                    $result = mysqli_query($con,$query);
                    
                    //ENTER PRIVILEGES
                    if ($result) 
                    {
                        $query_del = "DELETE FROM `user_privilege_set` WHERE `user_id`='$user_id'";
                        $result_del = mysqli_query($con,$query_del);

                        $number_as = count($_POST["user_priv_id"]);  
                        if($number_as > 0)  
                        {  
                              for($i=0; $i < $number_as; $i++)  
                              {  
                                   if(trim($_POST["user_priv_id"][$i] != ''))
                                   {  
                                    $user_priv_id = $_POST['user_priv_id'][$i];
                                    $privilege_value = $_POST['privilege_value'][$i];

                                    $query_priv = "INSERT INTO `user_privilege_set`(`user_id`,`user_type_id`,`user_priv_id`, `user_privilege_set`,`company_id`,`user_super_id`) 
                                    VALUES ('$user_id','$user_type_id','$user_priv_id','$privilege_value','$company_id','$user_super_id')";
                                    mysqli_query($con, $query_priv);
                                };
                              }; 
                        };

                        //USER CASH LEDGER
                        if(isset($_POST["user_cash_ledger_id"]) && $_POST["user_cash_ledger_id"] !=='')
                        {
                            $query = "DELETE FROM user_cash_ledger WHERE `user_id`='$user_id'";
                            $result = mysqli_query($con,$query);

                            $number_as = count($_POST["user_cash_ledger_id"]);  
                            if($number_as > 0)  
                            {  
                                for($i=0; $i<$number_as; $i++)  
                                {  
                                    if(trim($_POST["user_cash_ledger_id"][$i] != '' && $_POST["user_cash_ledger_id"][$i] > 0))
                                    {  
                                        $user_cash_ledger_id = $_POST['user_cash_ledger_id'][$i];
                                        $query_user_cash_ledger = "INSERT INTO `user_cash_ledger`(
                                        `user_id`,`ledger_id`, `principal`, `company_id`, `user_super_id`) VALUES (
                                        '$user_id','$user_cash_ledger_id','No','$company_id','$user_super_id')";
                                        mysqli_query($con, $query_user_cash_ledger);
                                    };
                                }; 
                            };
                        };
                        echo 'updated';
                    };
                };
            };
        }

        function user_privilege_list()
        {
            global $con;
            $value = "";
            $user_id = $_POST['user_id'];
            $value ='<div class="accordion-option">
                            <a href="javascript:void(0)" class="toggle-accordion active" accordion-id="#accordion"></a>
                        </div>
                        <div class="clearfix"></div>
                              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';

            //SELECT PAGES
            $query_pages = "SELECT * FROM `user_pages` ORDER BY `user_page_id` ASC";
            $query_run_pages = mysqli_query($con,$query_pages);
            if(mysqli_num_rows($query_run_pages) > 0)
            {
                while($row_pages = mysqli_fetch_assoc($query_run_pages))
                {
                    $value.='<div class="panel panel-default">
                                  <div class="panel-heading" role="tab" id="heading'.$row_pages['user_page_id'].'">
                                    <h6 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$row_pages['user_page_id'].'" aria-expanded="true" aria-controls="collapse'.$row_pages['user_page_id'].'">
                                        <h6 class="m-0 font-weight-bold text-primary">'.$row_pages['page'].'</h6>
                                        </a>
                                      </h6>
                                  </div>
                                  <div id="response"></div>  
                                <div id="collapse'.$row_pages['user_page_id'].'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading'.$row_pages['user_page_id'].'">
                                    <div class="panel-body">';

                        //SELECT PRIVILEGES FOR THE PAGE
                        $user_page_id = $row_pages['user_page_id'];
                        $query = "SELECT * FROM `user_privilege` WHERE `user_page_id` = '$user_page_id'";
                        $query_run = mysqli_query($con,$query);
                        if(mysqli_num_rows($query_run) > 0)
                        {
                            while($row = mysqli_fetch_assoc($query_run))
                            {
                                //CHECK IF PRIVILEGE IS SET IN THE USER_PRIVILEGE_SET
                                $user_priv_id = $row['user_priv_id'];
                                $query_ups = "SELECT * FROM `user_privilege_set` WHERE `user_id` = '$user_id' AND `user_priv_id` = '$user_priv_id'";
                                $query_run_ups = mysqli_query($con,$query_ups);
                                if(mysqli_num_rows($query_run_ups) > 0)
                                {
                                    $row_ups = mysqli_fetch_assoc($query_run_ups);
                                    $value.='<div class="form-row">
                                                <div class="col-md-6 mb-6">
                                                    <input type="hidden" name="user_priv_id[]" id="user_priv_id'.$row['user_priv_id'].'" value="'.$row['user_priv_id'].'">
                                                    <input type="text"  class="form-control" name="user_priv_idD" id="user_priv_idD'.$row['user_priv_id'].'" value="'.$row['user_privilege'].'" disabled="disabled">
                                                </div>
                                                <div class="col-md-6 mb-6">
                                                    <select class="form-control bg-light" name="privilege_value[]" id="privilege_value'.$row['user_priv_id'].'"> 
                                                            <option value="0">Please Select</option>';
                                                        if ($row_ups['user_privilege_set'] =="Yes") 
                                                        {
                                                            $value.='<option value="Yes" selected="selected">Yes</option>
                                                            <option value="No">No</option>';
                                                        } 
                                                        else 
                                                        {
                                                            $value.='<option value="Yes">Yes</option>
                                                            <option value="No" selected="selected">No</option>';
                                                        };
                                                $value.='</select>
                                                </div>
                                            </div>';
                                }
                                else
                                {
                                    //CHECK IF PRIVILEGE IS SET IN THE USER_TYPE_PRIVILEGE_SET
                                    $query_user = "SELECT * FROM `users` WHERE `id` = '$user_id'";
                                    $query_run_user = mysqli_query($con,$query_user);
                                    $row_user = mysqli_fetch_assoc($query_run_user);
                                    if($row_user){$user_type_id = $row_user['user_type_id'];};
                                    if(isset($user_type_id) && $user_type_id > 0)
                                    {
                                        $query_utps = "SELECT * FROM `user_type_privilege_set` WHERE `user_type_id` = '$user_type_id' AND `user_priv_id` = '$user_priv_id'";
                                        $query_run_utps = mysqli_query($con,$query_utps);
                                        if(mysqli_num_rows($query_run_utps) > 0)
                                        {
                                            $row_utps = mysqli_fetch_assoc($query_run_utps);
                                            $value.='<div class="form-row">
                                                        <div class="col-md-6 mb-6">
                                                            <input type="hidden" name="user_priv_id[]" id="user_priv_id'.$row['user_priv_id'].'" value="'.$row['user_priv_id'].'">
                                                            <input type="text"  class="form-control" name="user_priv_idD" id="user_priv_idD'.$row['user_priv_id'].'" value="'.$row['user_privilege'].'" disabled="disabled">
                                                        </div>
                                                        <div class="col-md-6 mb-6">
                                                            <select class="form-control bg-light" name="privilege_value[]" id="privilege_value'.$row['user_priv_id'].'"> 
                                                                    <option value="0">Please Select</option>';
                                                                if ($row_utps['user_privilege_set'] =="Yes") 
                                                                {
                                                                    $value.='<option value="Yes" selected="selected">Yes</option>
                                                                    <option value="No">No</option>';
                                                                } 
                                                                else 
                                                                {
                                                                    $value.='<option value="Yes">Yes</option>
                                                                    <option value="No" selected="selected">No</option>';
                                                                };
                                                        $value.='</select>
                                                        </div>
                                                    </div>';
                                        }
                                        else
                                        {
                                            $value.='<div class="form-row">
                                                        <div class="col-md-6 mb-6">
                                                            <input type="hidden" name="user_priv_id[]" id="user_priv_id'.$row['user_priv_id'].'" value="'.$row['user_priv_id'].'">
                                                            <input type="text"  class="form-control" name="user_priv_idD" id="user_priv_idD'.$row['user_priv_id'].'" value="'.$row['user_privilege'].'" disabled="disabled">
                                                        </div>
                                                        <div class="col-md-6 mb-6">
                                                            <select class="form-control bg-light" name="privilege_value[]" id="privilege_value'.$row['user_priv_id'].'"> 
                                                                <option value="0">Please Select</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>
                                                    </div>';
                                        };
                                    }
                                    else
                                    {
                                        $value.='<div class="form-row">
                                                    <div class="col-md-6 mb-6">
                                                        <input type="hidden" name="user_priv_id[]" id="user_priv_id'.$row['user_priv_id'].'" value="'.$row['user_priv_id'].'">
                                                        <input type="text"  class="form-control" name="user_priv_idD" id="user_priv_idD'.$row['user_priv_id'].'" value="'.$row['user_privilege'].'" disabled="disabled">
                                                    </div>
                                                    <div class="col-md-6 mb-6">
                                                        <select class="form-control bg-light" name="privilege_value[]" id="privilege_value'.$row['user_priv_id'].'"> 
                                                            <option value="0">Please Select</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    </div>
                                                </div>';
                                    };
                                };
                            };
                        };
                            $value.='</div>
                                </div>
                            </div>
                            <hr class="d-none d-md-block">';
                };
            }
            else
            {
                $value = "No Pages found";
            };
                
            echo $value;
        }

        function user_change_user_type()
        {
            global $con;
            $value = "";
            $user_type_id = $_POST['user_type_id'];
            if ($user_type_id !=="" && $user_type_id > 0) 
            {
                $value.='<table class="table table-hover table-bordered table-sm" id="user_privilege_set_list_table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody class="pv-table-body" id="user_privilege_set_list_table_body">';
                $query_utps = "SELECT * FROM `user_type_privilege_set` WHERE `user_type_id` = '$user_type_id'";
                $query_run_utps = mysqli_query($con,$query_utps);
                if(mysqli_num_rows($query_run_utps) > 0)
                {
                    while ($row_utps = mysqli_fetch_assoc($query_run_utps))
                    {
                        $user_priv_id = $row_utps['user_priv_id'];
                        $query = "SELECT * FROM `user_privilege` WHERE `user_priv_id`= '$user_priv_id'";
                        $query_run = mysqli_query($con,$query);
                        if(mysqli_num_rows($query_run) > 0)
                        {
                            $row = mysqli_fetch_assoc($query_run);

                            $value.='<tr>
                                        <td>'.$row['user_privilege'].'<input type="hidden" name="user_priv_id[]" id="user_priv_id'.$row_utps['user_priv_id'].'" value="'.$row_utps['user_priv_id'].'"></td>
                                        <td><select class="form-control bg-light" name="privilege_value[]" id="privilege_value'.$row_utps['user_priv_id'].'"> 
                                                    <option value="0">Please Select</option>';
                                                if ($row_utps['user_privilege_set'] =="Yes") 
                                                {
                                                    $value.='<option value="Yes" selected="selected">Yes</option>
                                                    <option value="No">No</option>';
                                                } 
                                                else 
                                                {
                                                    $value.='<option value="Yes">Yes</option>
                                                    <option value="No" selected="selected">No</option>';
                                                };
                                        $value.='</select></td>
                                    </tr>';
                        };
                    };
                    $value.='</tbody>
                            </table>';
                }
                else
                {
                    $query = "SELECT * FROM `user_privilege`";
                    $query_run = mysqli_query($con,$query);
                    while ($row = mysqli_fetch_assoc($query_run))
                    {
                        $value.='<tr>
                                <td>'.$row['user_privilege'].'<input type="hidden" name="user_priv_id[]" id="user_priv_id'.$row['user_priv_id'].'" value="'.$row['user_priv_id'].'"></td>
                                <td>
                                    <select class="form-control bg-light" name="privilege_value[]" id="privilege_value'.$row['user_priv_id'].'"> 
                                        <option value="0">Please Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </td>
                            </tr>';
                    };
                    $value.='</tbody>
                            </table>';
                };
            } 
            else 
            {
                $query = "SELECT * FROM `user_privilege`";
                $query_run = mysqli_query($con,$query);
                if(mysqli_num_rows($query_run) > 0)
                {
                    $value.='<table class="table table-hover table-bordered table-sm" id="user_privilege_set_list_table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody class="pv-table-body" id="user_privilege_set_list_table_body">';
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                            $value.='<tr>
                                        <td>'.$row['user_privilege'].'<input type="hidden" name="user_priv_id[]" id="user_priv_id'.$row['user_priv_id'].'" value="'.$row['user_priv_id'].'"></td>
                                        <td>
                                            <select class="form-control bg-light" name="privilege_value[]" id="privilege_value'.$row['user_priv_id'].'"> 
                                                <option value="0">Please Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </td>
                                    </tr>';
                    }
                          $value.='</tbody>
                            </table>';
                }
                else
                {
                    $value = "No Privileges found";
                };
            };
            echo $value;
        }

        function user_cash_ledger_list()
        {
            global $con;
            $count = $_POST['i'];
            $value = "";
            $value = '<td>
                        <input type="hidden" name="payment_item_id[]" class="form-control bg-light" id="payment_item_id'.$count.'">
                          <select class="form-control user_cash_ledger_id bg-light" name="user_cash_ledger_id[]" id="user_cash_ledger_id'.$count.'" data-id="'.$count.'" style="border-width:0px"> 
                            <option value="0">Please Select</option>';

                              $sql="SELECT * FROM ledgers WHERE tb_5=8 ORDER BY ledger_desc ASC";
                              $result=mysqli_query($con,$sql);
                                while($row=mysqli_fetch_array($result))
                                {
                                    $value .= '<option value = "'.$row['ledger_id'].'" >'.$row['ledger_desc'].'</option>';
                                }   

               $value .= '</select>
                      </td>
                      <td class = "action-td">
                          <a href="#" id="delete_user_cash_ledger" data-id="'.$count.'"><i class="fa fa-trash fa-sm"></i></a>
                      </td>';

            echo $value;
        }

        function edit_user_cash_ledger()
        {
            global $con;
            $user_id = $_POST['user_id'];
            $value = "";
            $value = '<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="user_cash_ledger_list_table">
                              <tr>
                                  <th width="90%">Cash Ledger(s)</th>
                                  <th width="10%">Action</th>
                              </tr>';
            $query = "SELECT * FROM user_cash_ledger WHERE user_id='$user_id'";
            $query_run = mysqli_query($con, $query);
            $i=0;
            if (mysqli_num_rows($query_run) > 0)
            {
                while($row_user_cash_ledger = mysqli_fetch_assoc($query_run))
                {
                    $i=++$i;
                    $value.='
                            <tr id="'.$i.'">
                              <td>
                                  <select class="form-control user_cash_ledger_id bg-light" name="user_cash_ledger_id[]" id="user_cash_ledger_id'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                    <option value="0">Please Select</option>';
                                    $ledger = $row_user_cash_ledger['ledger_id'];
                                      $sql="SELECT * FROM ledgers WHERE tb_5=8 ORDER BY ledger_desc ASC";
                                      $result=mysqli_query($con,$sql);
                                        while($row=mysqli_fetch_array($result))
                                        {
                                            if ($ledger == $row['ledger_id']) {
                                                $value.='<option value = "'.$row['ledger_id'].'" selected="selected">'.$row['ledger_desc'].'</option>';
                                            } else {
                                                $value.='<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
                                            };
                                        };
                               $value.='</select>
                              </td>
                              <td class = "action-td">';
                                  if ($i > 1) 
                                  {
                                      $value.='<a href="#" id="delete_user_cash_ledger" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>';
                                  };
                              $value.='</td>
                            </tr>';

                }
            };

            $i=++$i;
                $value.='
                        <tr id="'.$i.'">
                              <td>
                                  <select class="form-control user_cash_ledger_id bg-light" name="user_cash_ledger_id[]" id="user_cash_ledger_id'.$i.'" data-id="'.$i.'" style="border-width:0px"> 
                                    <option value="0">Please Select</option>';
                                      $sql="SELECT * FROM ledgers WHERE tb_5=8 ORDER BY ledger_desc ASC";
                                      $result = mysqli_query($con,$sql);
                                        while($row = mysqli_fetch_array($result))
                                        {
                                                $value.='<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
                                        };
                               $value.='</select>
                              </td>
                              <td class = "action-td">';
                                  if ($i > 1) 
                                  {
                                      $value.='<a href="#" id="delete_user_cash_ledger" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>';
                                  };
                              $value.='</td>
                            </tr>';

            $value.='</tbody>
            </table>';
                
            echo $value;
        }

        function user_change_branch()
        {
            global $con;
            $user_id = $_POST['user_id'];
            $branch_id = $_POST['branch_id'];
            
            $query = "UPDATE `users` SET `branch_id`='$branch_id' WHERE `id`='$user_id'";
            mysqli_query($con, $query);
        }

?>
