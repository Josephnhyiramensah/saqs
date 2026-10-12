<?php
require('includes/db.php');
include('includes/auth.php');

if(isset($_POST['registerbtn']))
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];
    if($password === $cpassword){
        $query = "INSERT INTO users (username, email, password) VALUES ('$username','$email','$password')";
        $query_run = mysqli_query($con, $query);
    
        If ($query_run)
        {
            $_SESSION['success'] = "Admin Profile Added";
            header('Location: welcome.php');
        }
        else
        {
            $_SESSION['status'] = "Admin Profile NOT Added";
            header('Location: welcome.php');
        };
    }
    else
    {
        $_SESSION['success'] = "Password and Confirm Password Does NOT Match";
        header('Location: welcome.php');
    };
    
};




    if(isset($_POST['updatebtn']))
    {
        $id = $_POST['edit_id'];
        $username = $_POST['edit_username'];
        $email = $_POST['edit_email'];
        $password = $_POST['edit_password'];
        $query = "UPDATE users SET username='$username', email='$email', password='$password' WHERE id='$id'";
        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            $_SESSION['success'] = "Your Data is Updated";
            header('Location: welcome.php');
        }
        else
        {
            $_SESSION['status'] = "Your Data is NOT Updated";
            header('Location: welcome.php');
        }
    };









    if(isset($_POST['delete_btn']))
    {
        $id = $_POST['delete_id'];
        $query = "DELETE FROM users WHERE user_id='$id'";
        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            $_SESSION['success'] = "Your Data has been DELETED";
            header('Location: welcome.php');
        }
        else
        {
            $_SESSION['status'] = "Your Data could NOT DELETED";
            header('Location: welcome.php');
        }
    };

?>
