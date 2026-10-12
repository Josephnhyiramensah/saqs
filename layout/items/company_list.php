<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_super.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/sessions.php');
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
	                Company List
	            </h4>
                <div class="input-group">
                    <?php 
                        if ($user_type == 'Ultra_Super_User') 
                        {
                        echo '<a href="#" data-toggle="" id="new_company_icon">New Company</a>';
                        };
                        if ($user_type == 'Ultra_Super_User') 
                        {
                            echo ' | <a href="/layout/items/user_admin_sheet.php">Sign Up</a>';
                        };
                    ?>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">
                    <?php
                        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User') 
                        {
                            echo '<a href="#" data-toggle="" id="new_company_icon"><i class="fas fa-building"></i></a>';
                        };
                    ?>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                if($user_type == 'Ultra_Super_User')
                {
                    $query = "SELECT * FROM company";
                }
                else
                {
                    $query = "SELECT * FROM company WHERE user_super_id = '$user_super_id'";
                };
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="company-table">
                <table class="table table-hover table-bordered table-sm" id="companyTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Address</th>
                            <th>Location</th>
                            <th>Email</th>
                            <th class = "action-td">Telephone</th>
                            <th class = "action-td">Expiry Date</th>
                            <th class = "action-td">SMS Balance</th>
                            <th class = "action-td">Status</th>
                            <th class = "action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    $company_id = $row['company_id'];
                                    $query_sms = "SELECT SUM(qty_purchased) AS total_sms_purchases, SUM(qty_sent) AS 
                                    total_sms_used FROM sms WHERE company_id = '$company_id'";
                                    $query_run_sms = mysqli_query($con, $query_sms);
                                    if (!empty($query_run_sms) && mysqli_num_rows($query_run_sms) > 0)
                                    {
                                        $row_sms = mysqli_fetch_assoc($query_run_sms);
                                        $company_sms_bal = $row_sms['total_sms_purchases'] - $row_sms['total_sms_used'];
                                    }
                                    else
                                    {
                                        $company_sms_bal = 'N/A';
                                    };
                                    
                                    $query_sub_bill = "SELECT * FROM subscription_bill WHERE company_id = '$company_id' 
                                    ORDER BY date_end DESC";
                                    $query_run_sub_bill = mysqli_query($con, $query_sub_bill);
                                    if (mysqli_num_rows($query_run_sub_bill) > 0)
                                    {
                                        $row_sub_bill = mysqli_fetch_assoc($query_run_sub_bill);
                                        $sub_expiry_date = $row_sub_bill['date_end'];
                                        //$sub_bill_amount = $row_sub_bill['amount_bill'];
                                    }
                                    else
                                    {
                                        $sub_expiry_date = 'N/A';
                                        //$sub_bill_amount = 0;
                                    };
                        ?>
                            <tr>
	                            <td><?php echo $row['trading_name']?></td>
                                <td><?php echo $row['address'];?></td>
                                <td><?php echo $row['location'];?></td>
                                <td><?php echo $row['email'];?></td>
                                <td class = "action-td"><?php echo $row['telephone'];?></td>
                                <td class = "action-td"><?php echo $sub_expiry_date;?></td>
                                <td class = "action-td"><?php echo $company_sms_bal;?></td>
                                <td class = "action-td"><?php echo $row['status'];?></td>
	                            <td class = "action-td">
                                    <a href="#" 
                                        id="btn_open_company" 
                                        data-id="<?php echo $row['company_id'];?>" 
                                        data-id1="<?php echo $row['user_super_id'];?>"
                                        data-id2="<?php echo $name;?>" 
                                        data-id3="<?php echo $row['company_type_id'];?>"
                                        data-id4="<?php echo $row['sms'];?>"
                                        data-margin_branch="<?php echo $row['margin_branch'];?>"
                                        data-margin_inter_branch="<?php echo $row['margin_inter_branch'];?>"
                                        data-company_ledger_id="<?php echo $row['ledger_id'];?>"
                                        data-trading_name="<?php echo $row['trading_name'];?>"
                                    >Open</a>
                                     
                                    <?php
                                      if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $Edit_Company == 'Yes')) 
                                      {
                                        echo ' | <a 
                                        href="#" id="btn_edit_company" 
                                        data-id="'.$row['company_id'].'" 
                                        data-id1="'.$row['user_super_id'].'">
                                        Edit
                                    </a>';
                                      };
                                      if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User') 
                                      {
                                        if($row['status'] == 'Active')
                                        {
                                            echo ' | <a 
                                                href="#" id="btn_lock_company" 
                                                data-id="'.$row['company_id'].'" 
                                                data-id1="Active">
                                                Lock
                                            </a>';
                                        }
                                        else
                                        {
                                            echo ' | <a 
                                                href="#" id="btn_unlock_company" 
                                                data-id="'.$row['company_id'].'" 
                                                data-id1="Closed">
                                                Unlock
                                            </a>';
                                        };
                                        
                                      };

                                      if ($user_type == 'Ultra_Super_User') 
                                      {
                                        echo ' | <a href="#" id="btn_subscription_open" data-id="'.$row['company_id'].'">Subscription</a>';
                                      };

                                      if ($user_type == 'Ultra_Super_User') 
                                      {
                                        echo ' | <a href="#" id="btn_delete_company" data-company_id="'.$row['company_id'].'">Delete</a>';
                                      };

                                      if ($user_type == 'Ultra_Super_User') 
                                      {
                                            echo ' | <a 
                                                href="#" id="btn_clear_company_data" 
                                                data-id="'.$row['company_id'].'" 
                                                data-id1="Active">
                                                Clear Data
                                            </a>';
                                        }
                                    ?>
	                            </td>
                            </tr>
                        <?php
                                }
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
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/company_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>