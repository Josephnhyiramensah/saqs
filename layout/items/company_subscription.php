<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_super.php');
    if (isset($_SESSION['user_super_id'])) {
        $user_super_id = $_SESSION['user_super_id'];
        $name = $_SESSION['full_name'];
    };
    $company_id = $_SESSION['company_id'];
    $query_company = "SELECT * FROM company WHERE company_id = '$company_id'";
    $query_run_company = mysqli_query($con, $query_company);
    if (mysqli_num_rows($query_run_company) > 0)
    {
        $row_company = mysqli_fetch_assoc($query_run_company);
        $company_name = $row_company['trading_name'];
    }
    else
    {
        $company_name = 'N/A';
    };
?>
<input type='hidden' id='session_user_super_id' value="<?php echo $user_super_id;?>">
<style type="text/css">
    input {border-top-style: hidden;border-right-style: hidden;border-left-style: hidden;border-bottom-style: hidden;background-color: #ffffff;}
    .scroll-card-body {max-height: 700px;overflow-y: auto;}
    .amt-td {text-align:right;}
    .action-td {text-align:center;}
</style>
<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                <?php echo $company_name.' Subscription';?>
	            </h4>
                <div class="input-group">
                    <a href="#" data-toggle="" data-id="<?php echo $_SESSION['company_id'];?>" id="btn_subscription_company">New Subscription</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="company-subscription-table">
                <table class="table table-hover table-bordered table-sm" id="company_subscriptionTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class = "action-td" colspan="6"><h5><strong>Subscription Details</strong><h5></th>
                        </tr>
                        <tr>
                            <th class = "action-td">Start Date</th>
                            <th class = "action-td">No of Months</th>
                            <th class = "action-td">Expiry Date</th>
                            <th class = "action-td">Price</th>
                            <th class = "action-td">Amount</th>
                            <th class = "action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            $query_sub = "SELECT * FROM subscription_bill WHERE company_id = '$company_id' 
                            ORDER BY date_end DESC";
                            $query_run_sub = mysqli_query($con, $query_sub);
                            if (mysqli_num_rows($query_run_sub) > 0)
                            {
                                while($row_sub = mysqli_fetch_assoc($query_run_sub))
                                {
                                    ?>
                                        <tr>
                                            <td class = "action-td"><?php echo $row_sub['date_start']?></td>
                                            <td class = "action-td"><?php echo $row_sub['no_of_months'];?></td>
                                            <td class = "action-td"><?php echo $row_sub['date_end'];?></td>
                                            <td class = "action-td"><?php echo $row_sub['price'];?></td>
                                            <td class = "action-td"><?php echo $row_sub['amount_dollar'];?></td>
                                            <td class = "action-td">
                                                <a href="#" 
                                                    id="btn_edit_subscription" 
                                                    data-id="<?php echo $row_sub['sub_bill_id'];?>"
                                                >Edit</a>
                                                | 
                                                <a href="#" 
                                                    id="btn_delete_subscription" 
                                                    data-id="<?php echo $row_sub['sub_bill_id'];?>"
                                                >Delete</a>
                                        </td>
                                        </tr>
                                    <?php
                                };
                            }
                            else
                            {
                                echo 'Data Not Found';
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include('company_subscription_modal.php');?>
<div 
    class="modal fade bd-example-modal-xl" 
    id="subscription_delete_modal" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="subscription_delete_modal" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subscription_delete_modal_title">Subscription Deletion</h5>
            </div>
            <form action="#" method="POST">
                <div class="modal-body">
                    <p id="subscription_delete_question"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="subscription_delete_yes" name="subscription_delete_yes" class="btn btn-danger">Yes</button>
                    <button type="button" id="subscription_delete_no" name="subscription_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>