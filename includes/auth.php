<?php
    //session_start();
    if(!isset($_SESSION['user_id']) && !isset($_SESSION['user_super_id']) && !isset($_SESSION['user_ultra_super_id']))
    {
        header("Location: login.php");
        exit(); 
    }
?>