<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
?><!DOCTYPE html>
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
  <style type="text/css">
    .scroll-card {height: 800px;overflow-y: auto;}
    .scroll-card-items {height: 385px;overflow-y: auto;}
    .scroll-card-div {height: 600px;overflow-y: auto;}
    .scroll-card-body {max-height: 700px;overflow-y: auto;}
    .amt-td {text-align:right;}
    .action-td {text-align:center;}
</style>
<div class="container-fluid scroll-card">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Sales Order
	            </h4>
                <div class="input-group">
                </div>
            </div>
            <div class="float-right">
	        </div>
        </div>
        <div class="card-body">
            <form action="" method="POST" id="sales_order_form">
                <div class="form-row">
                    <div class="col-md-4 mb-4">
	                    <label for="sales_order_customer_name">Name</label>
	                    <input type="text" name="sales_order_customer_name" class="form-control bg-light" id="sales_order_customer_name">
                    </div>
                    <div class="col-md-4 mb-4">
	                    <label for="sales_order_customer_telephone">Telephone</label>
	                    <input type="text" name="sales_order_customer_telephone" class="form-control bg-light" id="sales_order_customer_telephone">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="sales_order_branch">Branch</label>
                        <select class="form-control bg-light" name="sales_order_branch" id="sales_order_branch"> 
                            <option value="0">Please Select</option>
                            <?php
                            
                                $sql = "SELECT * FROM `company` ORDER BY `trading_name` ASC";
                                $result = $con->prepare($sql); 
                                $result->execute();
                                $stmt_result_ups = $result->get_result();

                                if($stmt_result_ups->num_rows > 0)
                                {
                                    while($row = $stmt_result_ups->fetch_assoc())
                                    {
                                    /*$sql="SELECT * FROM company ORDER BY trading_name ASC";
                                    $result = mysqli_query($con,$sql);
                                    while($row = mysqli_fetch_array($result))
                                    {*/
                                        echo '<option value = "'.$row['company_id'].'">'.$row['trading_name'].'</option>';
                                        
                                    };
                                };
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-12 scroll-card-body">
                        <div class="table-responsive scroll-card-items" id="sales_order_list_table">
                            <table class="table table-hover table-bordered table-sm" id="sales_order_table" width="100%" cellspacing="0">
                                <thead>
                                    <tr id="1">
                                        <th width="70%" class = "action-td">Item Description (<a id="sales_order_add_item_btn" href="#">Click to Add Item</a>)</th>
                                        <th width="20%" class = "action-td">Qty</th>
                                        <th width="10%" class = "action-td">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="pv-table-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-6">
                    </div>
                    <div class="col-md-3 mb-3">
						<a class="btn btn-primary btn-block"
                            name="sales_order_save_btn" 
                            id="sales_order_save_btn" href="index.php">Save Order
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
						<a class="btn btn-danger btn-block" href="index.php">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/sales_order_item_search_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>