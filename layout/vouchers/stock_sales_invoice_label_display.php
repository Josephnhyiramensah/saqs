<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    
	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
	$time = date('H-i-sa');
?>
  <style type="text/css">
    .scroll-card-body {
            max-height: 700px;
            overflow-y: auto;
          }
    .amt-td {
            text-align:right;
          }
    .action-td {
            text-align:center;
          }
</style>
<div class="container-fluid">
    <?php 
        if(isset($_SESSION['label_sales_item_id']))
        {
            $company_id = $_SESSION['company_id'];
            $sales_item_id = $_SESSION['label_sales_item_id'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);

            $sql_sales_item_list = "SELECT * FROM stock_sales_items WHERE sales_item_id = '$sales_item_id'";
            $result_sales_item_list = mysqli_query($con,$sql_sales_item_list);
            $row_sales_item_list = mysqli_fetch_array($result_sales_item_list);

            $stock_item_id = $row_sales_item_list['stock_item_id'];
            $sql_stock_item = "SELECT * FROM stock_items WHERE stock_item_id = '$stock_item_id'";
            $result_stock_item = mysqli_query($con,$sql_stock_item);
            $row_stock_item = mysqli_fetch_array($result_stock_item);
    ?>
    <div class="text-center">
        <?php 
        echo'<H3>'.$row_stock_item['stock_item'].'</H3><br>
        Dosage: '.$row_sales_item_list['dosage'].'<br>
        '.$row_sales_item_list['label'].'<br>
        <strong>WARNING:</strong> '.$row_sales_item_list['warning'].'<br>
        Dispense/Labelled by: '. $row_sales_item_list['label_by'].'<br>
        Date/Time: '.date('Y-m-d H:i:sa');
        ?>
    </div>
            <!--<table class="table table-hover table-borderless table-sm" id="label_drug_table" width="100%" cellspacing="0">
                <tbody class="pv-table-body" id="label_drug_table_body">
                    <tr>
                        <th class = "action-td"><H3><?php //echo $row_stock_item['stock_item'];?></H3></th>
                    </tr>
                    <tr>
                        <td class = "action-td">Dosage: <?php //echo $row_sales_item_list['dosage'];?></td>
                    </tr>
                    <tr>
                        <td class = "action-td"><?php //echo $row_sales_item_list['label'];?></td>
                    </tr>
                    <tr>
                        <td class = "action-td"><?php //echo 'WARNING: '.$row_sales_item_list['warning'];?></td>
                    </tr>
                    <tr>
                        <td class = "action-td">Dispense/Labelled by: <?php //echo $row_sales_item_list['label_by'];?></td>
                    </tr>
                    <tr>
                        <td class = "action-td">Date/Time: <?php //echo date('Y-m-d H:i:s');?></td>
                    </tr>
                </tbody>
            </table>-->
        <?php
        };
        ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>