<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
?>
<input type='hidden' id='session_company_id' value="<?php echo $_SESSION['company_id'];?>">
<input type='hidden' id='session_user_super_id' value="<?php echo $_SESSION['user_super_id'];?>">
<input type='hidden' id='session_user_id' value="<?php echo $_SESSION['user_id'];?>">
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
        if(isset($_SESSION['label_drug_list_id']))
        {
            $company_id = $_SESSION['company_id'];
            $drug_id = $_SESSION['label_drug_id'];
            $drug_list_id = $_SESSION['label_drug_list_id'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);

            $sql_druglist = "SELECT * FROM drug_list WHERE drug_list_id = '$drug_list_id'";
            $result_druglist = mysqli_query($con,$sql_druglist);
            $row_druglist = mysqli_fetch_array($result_druglist);

            $sql_drug = "SELECT * FROM stock_items WHERE stock_item_id = '$drug_id'";
            $result_drug = mysqli_query($con,$sql_drug);
            $row_drug = mysqli_fetch_array($result_drug);
    ?>
                    <table class="table table-hover table-borderless table-sm" id="label_drug_table" width="100%" cellspacing="0">
                        <tbody class="pv-table-body" id="label_drug_table_body">
                            <tr>
                                <th class = "action-td"><H3><?php echo $row_drug['stock_item'];?></H3></th>
                            </tr>
                            <tr>
                                <td class = "action-td">Dosage: <?php echo $row_druglist['dosage'];?></td>
                            </tr>
                            <tr>
                                <td class = "action-td"><?php echo $row_druglist['label'];?></td>
                            </tr>
                            <tr>
                                <td class = "action-td">Dispense/Labelled by: <?php echo $row_druglist['label_by'];?></td>
                            </tr>
                        </tbody>
                    </table>
        <?php
        };
        ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>