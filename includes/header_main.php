<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel = "icon" href ="/img/logo_2.png" type ="image/x-icon">

  <title>HealthNotes - 
    <?php
      if(isset($_SESSION['company_id']))
      {
        $company_id = $_SESSION['company_id'];
        $sql="SELECT * FROM company WHERE company_id = '$company_id'";
        $result = mysqli_query($con,$sql);
        if(!empty($result) && mysqli_num_rows($result) > 0 )
        {
          $row = mysqli_fetch_array($result);
          echo $row['trading_name'].', '.$row['telephone'];
        }
        else
        {
          echo 'No Company';
        };
      }
      else
      {
        echo 'No Company';
      };
    ?>
  </title>
  <!-- Custom fonts for this template-->
  <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="/css/googleapis.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/bootstrapcdn_bootstrap.min.css">
  <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">-->
  <link rel="stylesheet" href="/css/bootstrap-select.min.css">
  <!-- Custom styles for this template-->
  <link href="/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">