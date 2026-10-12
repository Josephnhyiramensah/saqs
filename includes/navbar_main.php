<?php

    include($_SERVER['DOCUMENT_ROOT'] .'/includes/sessions.php');
    
?>
<!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/welcome.php">
      <!--<div class="sidebar-brand-icon rotate-n-15">
        <img src="/img/TOL.jpg" alt="HealthNotes" class="img-thumbnail">
      </div>-->
      <div class="sidebar-brand-text mx-3">
        <?php
          $today = date('Y-m-d');
          if($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR 
          ($user_type == 'Normal_User' AND $user_type_id == 3)) 
          {
            if(isset($trading_name)){echo $trading_name;}else{echo 'No Company';};
          }
          else
          {
            if(isset($branch_name)){echo $branch_name;}else{echo 'No Branch';};
          };
        ?>
        <input type="hidden" name="session_company_id" class="form-control bg-light" id="session_company_id" value="<?php echo $company_id;?>">
        <input type='hidden' id='session_user_type_id' value="<?php echo $user_type_id;?>">
      </div>
    </a>

<!-- Divider -->
    <hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>HealthNotes</span></a>
  </li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  Interface
</div>

<!-- Nav Item - Patients Collapse Menu -->
<?php
  if($company_type_id == 1)
  {
    if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Patient == 'Yes')) 
    {
        echo '<li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePatients" aria-expanded="true" aria-controls="collapsePatients">
            <i class="fas fa-fw fa-users"></i>
            <span>Patients</span>
          </a>
          <div id="collapsePatients" class="collapse" aria-labelledby="headingPatients" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Patient Profile:</h6>
              <a class="collapse-item" href="/layout/patients/patient_list.php">Find Patient</a>
            </div>
          </div>
        </li>';
    };
  }

if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Attendance == 'Yes')) 
  {
      echo '<!-- Divider -->
<hr class="sidebar-divider">
<!-- Nav Item - Attendance Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAttendance" aria-expanded="true" aria-controls="collapseAttendance">
    <i class="fas fa-fw fa-folder"></i>
    <span>Attendance</span>
  </a>

  <div id="collapseAttendance" class="collapse" aria-labelledby="headingAttendance" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Attendance Sheet:</h6>';
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_OPD_List == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/attendance/attend_list_opd.php">OPD</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_IPD_List == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/attendance/attend_list_ipd.php">IPD</a>
              <a class="collapse-item" href="/layout/attendance/attend_list_discharge.php">Discharged</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Cashier_Attendance_list == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/attendance/attend_list_revenue.php" id="nav_receipt">OPD/IPD - Revenue</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Attend_List == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/attendance/attend_list.php" id="nav_attend_list">All Attendance List</a>';
        };
        /*if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User') 
        {
            echo '<a class="collapse-item" href="/layout/attendance/update_private_prices.php" id="nav_attend_list">Update Private Prices</a>';
        };*/
      echo'<h6 class="collapse-header">Appointment:</h6>
        <a class="collapse-item" id="appoint_report_link" href="#">Appointments</a>
        <a class="collapse-item" id="appoint_report_by_date_link" href="#">Appoint. by Date</a>';
        //if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND ($_SESSION['View_Feedback'] == 'Yes'))) 
        //{
            echo '<a class="collapse-item" href="/layout/attendance/feedback.php" id="nav_feedback">Feedback</a>';
        //};
      echo'</div>
  </div>
</li>';
  };


if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Setup == 'Yes')) 
  {
      echo '<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Setup Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetup" aria-expanded="true" aria-controls="collapseSetup">
    <i class="fas fa-fw fa-folder-plus"></i>
    <span>Setup</span>
  </a>
  <div id="collapseSetup" class="collapse" aria-labelledby="headingSetup" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Setup:</h6>';
          if ($user_type == 'Ultra_Super_User') 
          {
            echo '<a class="collapse-item" href="#" id="btn_clear_data" data-company_id="'.$_SESSION['company_id'].'">Clear Data</a>';
          };
          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Ledger == 'Yes')) 
          {
            echo '<a class="collapse-item" href="/layout/items/customer_list.php">Customers</a>';
          };
          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Drugs == 'Yes')) 
          {
            echo '<a class="collapse-item" href="/layout/items/stock_item_list.php">Stock Items</a>
            <a class="collapse-item" href="/layout/items/stock_item_type_list.php">Stock Type</a>';
            echo '<a class="collapse-item" href="/layout/items/price_level_list.php">Price Level</a>';
          };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Drugs == 'Yes')) 
        {
            //echo '<a class="collapse-item" href="/layout/items/drug_list.php">Drugs</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Drugs == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/items/composite_drug_list.php">Composite Drugs</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Diagnosis == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/items/diagnosis_list.php">Diagnosis</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Surgery == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/items/surgery_list.php">Procedures/Surgeries</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Services == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/items/service_list.php">Services</a>';
        };
        /*if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Consumables'] == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/items/consum_list.php">Consumables</a>';
        };*/
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Labs == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/items/lab_list.php">Labs</a>
            <a class="collapse-item" href="/layout/items/composite_lab_list.php">Composite Labs</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Radiology == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/items/radio_list.php">Radiology</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Clinic == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/items/clinic_list.php">Clinic</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Ward == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/items/ward_list.php">Ward</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Ledger == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/items/ledger_list.php">Ledgers</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_NHIS == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/items/nhis_list.php">NHIS List</a>
            <a class="collapse-item" href="/layout/items/nhis_scheme_list.php">NHIS Schemes</a>';
        };
          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Warehouse == 'Yes')) 
          {
            echo '<a class="collapse-item" href="/layout/items/warehouse_list.php">Warehouses</a>';
          };
      echo'</div>
  </div>
</li>';
  };

 if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Vouchers == 'Yes')) 
          {
            echo '
<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Accounting Vouchers Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAccountVouchers" aria-expanded="true" aria-controls="collapseAccountVouchers">
    <i class="fas fa-fw fa-book"></i>
    <span>Vouchers</span>
  </a>
  <div id="collapseAccountVouchers" class="collapse" aria-labelledby="headingAccountVouchers" data-parent="#accordionSidebar">';
 if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Accounting_Vouchers == 'Yes')) 
  {
            echo '
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Accounting Vouchers:</h6>';

        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $Send_SMS == 'Yes')) 
        {
            echo '<a class="collapse-item" href="#" id="send_sms_nav">Send SMS</a>';
        };
        
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Receipt == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/vouchers/receipt_list.php">Receipt</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Payment == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/vouchers/payment_list.php">Payment</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Contra == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/vouchers/contra_list.php">Contra</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Journal == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/vouchers/journal_list.php">Journal</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Purchases == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/vouchers/purchases_list.php">Purchases</a>';
            echo '<a class="collapse-item" href="/layout/vouchers/purchase_returns_list.php">Purchase Returns</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Sales == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/vouchers/stock_sales_list.php">Sales</a>';
            echo '<a class="collapse-item" href="/layout/vouchers/stock_sales_returns_list.php">Sales Returns</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Refund == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/vouchers/refund_list.php">Refund</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Discount == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/vouchers/discount_list.php">Discount</a>';
        };
      echo'</div>';
  };

  if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Inventory_Vouchers == 'Yes')) 
  {
            echo '
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Inventory Vouchers:</h6>';

        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Stock_Requisition == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/vouchers/stock_requisition_list.php">Stock Requisition</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Stock_Transfer == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/vouchers/stock_transfer_list.php">Stock Transfer</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Stock_Adjustment == 'Yes')) 
        {
            echo '<a class="collapse-item" href="/layout/vouchers/stock_adjustment_list.php">Stock Adjustment</a>
            <a class="collapse-item" href="#" id="zero_stock_btn">Zero Stock</a>
            <a class="collapse-item"  href="/layout/vouchers/stock_take_invoice_list.php" id="stock_take_btn">Stock Taking</a>';
        };

      echo'</div>';
    };
  echo'</div>
</li>';
};

 if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Payroll == 'Yes')) 
          {
            echo '<!-- Divider -->
<hr class="sidebar-divider">
<!-- Nav Item - Payroll Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePayroll" aria-expanded="true" aria-controls="collapsePayroll">
    <i class="fas fa-fw fa-money-bill-wave"></i>
    <span>Payroll</span>
  </a>
  <div id="collapsePayroll" class="collapse" aria-labelledby="headingPayroll" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Payroll:</h6>';
          
            if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Employee == 'Yes')) 
            {
              echo '<a class="collapse-item" href="/layout/items/employee_list.php">Employee</a>';
            };
            
            //if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Department == 'Yes')) 
            //{
              echo '<a class="collapse-item" href="/layout/items/dept_list.php">Department</a>';
            //};

            //if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Tax_Schedule == 'Yes')) 
            //{
              echo '<a class="collapse-item" href="/layout/items/tax_schedule_list.php">Tax Schedule</a>';
            //};
              if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Time_Sheet == 'Yes')) 
              {
                echo '<a class="collapse-item" href="/layout/vouchers/time_sheet_list.php">Time Sheet</a>';
                if($_SESSION['user_type_id'] < 3 || $_SESSION['user_type_id'] > 7)
                {
                  echo '<a class="collapse-item" href="/layout/vouchers/employee_validation_sheet_list.php">Employee Validation Sheet</a>';
                };
              };
              if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Loan_Disbursement == 'Yes')) 
              {
                echo '<a class="collapse-item" href="/layout/vouchers/loan_disbursement_list.php">Loan Disbursement</a>';
              };
              if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Salary_Advance == 'Yes')) 
              {
                echo '<a class="collapse-item" href="/layout/vouchers/salary_advance_list.php">Salary Advance</a>';
              };
              if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Payroll_Journal == 'Yes')) 
              {
                echo '<a class="collapse-item" href="/layout/vouchers/pay_sheet_list.php">Pay Sheet</a>';
                echo '<a class="collapse-item" href="/layout/vouchers/bonus_voucher_list.php">Bonus Voucher</a>';
                echo '<a class="collapse-item" href="/layout/vouchers/salary_adjustment_list.php">Salary Adjustment</a>';
                echo '<a class="collapse-item" href="/layout/vouchers/arrears_list.php">Arrears</a>';
              };
              if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Leave == 'Yes')) 
              {
                echo '<a class="collapse-item" href="/layout/vouchers/leave_list.php">Leave</a>';
              };

          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Time_Sheet == 'Yes')) 
          {
            echo '<a class="collapse-item" id="employee_register_link" href="#">Employee Register</a>';
          };

          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Time_Sheet == 'Yes')) 
          {
            echo '<a class="collapse-item" id="employee_time_sheet_link" href="#">Employee Time Sheet</a>';
          };

          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Payroll_Statement == 'Yes')) 
          {
            echo '<a class="collapse-item" href="#" id="payroll_statement_link">Payroll Statement</a>
            <a class="collapse-item" href="#" id="pay_slip_link">Pay Slip</a>
            <a class="collapse-item" href="#" id="loan_report_link">Loan Report</a>
            <a class="collapse-item" href="#" id="payroll_welfare_link">Welfare</a>';
          };

          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_SSNIT_Report == 'Yes')) 
          {
            echo '<a class="collapse-item" href="#" id="payroll_1st_tier_link">1st Tier</a>
            <a class="collapse-item" href="#" id="payroll_2nd_tier_link">2nd Tier</a>';
          };

          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_PAYE == 'Yes')) 
          {
            echo '<a class="collapse-item" href="#" id="payroll_paye_link">P. A. Y. E.</a>';
          };

          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Bank_Advice == 'Yes')) 
          {
            echo '<a class="collapse-item" href="#" id="payroll_bank_advice_link">Bank Advice</a>';
          };
      echo'</div>
  </div>
</li>';
};

 if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Stock_Report == 'Yes')) 
          {
            echo '
<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Stock Reports Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStkReports" aria-expanded="true" aria-controls="collapseStkReports">
    <i class="fas fa-fw fa-list"></i>
    <span>Stock Reports</span>
  </a>
  <div id="collapseStkReports" class="collapse" aria-labelledby="headingStkReports" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Stock Reports:</h6>';
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Stock_Summary == 'Yes')) 
          {
            echo '<a class="collapse-item" href="#" id="stock_report_link">Stock Summary</a>
            <a class="collapse-item" href="#" id="mini_stock_report_link">Mini Stock</a>
            <a class="collapse-item" href="#" id="dispensed_report_link">Dispensed</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Tally_Card == 'Yes')) 
          {
            echo '<a class="collapse-item" href="#" id="stock_item_tally_card_link">Tally Card</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Drug_Batch_Report == 'Yes')) 
          {
            echo '<a class="collapse-item" href="#">Batch Enquiry</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Expiries == 'Yes')) 
          {
            echo '<a class="collapse-item" href="#">Expiries</a>';
        };
      echo'</div>
  </div>
</li>';
};

 if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Accounting_Report == 'Yes')) 
          {
echo '
<hr class="sidebar-divider">
<!-- Nav Item - Accounting Reports Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseActReports" aria-expanded="true" aria-controls="collapseActReports">
    <i class="fas fa-fw fa-book-reader"></i>
    <span>Accounting Reports</span>
  </a>
  <div id="collapseActReports" class="collapse" aria-labelledby="headingActReports" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Accounting Reports:</h6>
        <a class="collapse-item" href="#">Range Of Vouchers</a>';
        
          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Ledger_Report'] == 'Yes')) 
          {
            echo '<a class="collapse-item" id="ledger_report_link" href="#">Ledger Report</a>
            <a class="collapse-item" id="receipt_categorisation_link" href="#">Receipt Categorisation</a>';
          };

          //if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Sales_Report'] == 'Yes')) 
          //{
            echo '<a class="collapse-item" id="sales_report_link" href="#">Sales Report</a>
            <a class="collapse-item" href="#" id="sales_summary_report_link">Sales Summary</a>';
          //};

          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Ledger_Summary_Report'] == 'Yes')) 
          {
            echo '<a class="collapse-item" id="ledger_summary_report_link" href="#">Ledger Summary</a>';
          };

          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Ledger_Detail_Report'] == 'Yes')) 
          {
            echo '<a class="collapse-item" id="ledger_detail_report_link" href="#">Ledger Details</a>';
          };
          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Payment_Type_Report'] == 'Yes')) 
          {
            echo '<a class="collapse-item" id="payment_type_report_link" href="#">Payment Type Report</a>';
          };
          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Trial_Balance'] == 'Yes')) 
          {
            echo '<a class="collapse-item" href="#" id="trial_balance_report_link">Trial Balance</a>';
          };
          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Profit_And_Loss'] == 'Yes')) 
          {
            //echo '<a class="collapse-item" href="#">Profit and Loss</a>';
          };
          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Balance_Sheet'] == 'Yes')) 
          {
            //echo '<a class="collapse-item" href="#">Balance Sheet</a>';
          };
          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Cash_Flow'] == 'Yes')) 
          {
            //echo '<a class="collapse-item" href="#">Cash Flow</a>';
          };
      echo '<h6 class="collapse-header">NHIA Reports:</h6>
        <a class="collapse-item" id="attend_summary_report_link" href="#">Attendance Summary</a>
        <a class="collapse-item" id="daily_summary_report_link" href="#">Daily Summary</a>
        <a class="collapse-item" id="nhis_specialty_detail_link" href="#">NHIS Detail</a>
        <a class="collapse-item" id="nhis_specialty_summary_link" href="#">NHIS Summary</a>
      </div>
  </div>
</li>';
};

if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Statistics == 'Yes')) 
{
  echo '<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Stock Reports Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStats" aria-expanded="true" aria-controls="collapseStats">
    <i class="fas fa-fw fa-list"></i>
    <span>Statistics</span>
  </a>
  <div id="collapseStats" class="collapse" aria-labelledby="headingStats" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Statistics:</h6>';
       if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Doctors_Attendance_Register == 'Yes')) 
          {
            echo '<a class="collapse-item" href="#" id="doctors_attend_link">Dr. Attend. Register</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Incidence_Of_Diseases'] == 'Yes')) 
          {
            echo '<a class="collapse-item" href="#" id="diseases_incidence_link">Incidence Of Diseases</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Statement_Of_Out_Patient'] == 'Yes')) 
          {
            echo '<a class="collapse-item" href="#" id="OPD_Statement_link">Statement Of Out-Patient</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Statement_Of_In_Patient'] == 'Yes')) 
          {
            echo '<a class="collapse-item" href="#" id="IPD_Statement_link">Statement Of In-Patient</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Ward_State'] == 'Yes')) 
          {
            echo '<a class="collapse-item" href="#" id="ward_state_link">Ward State</a>';
        };
        if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $_SESSION['View_Lab_Occurance'] == 'Yes')) 
        {
            echo '<a class="collapse-item" href="#" id="lab_occurance_link">Registers</a>';
        };
      echo'</div>
  </div>
</li>';
};
?>
<!-- Divider -->
<hr class="sidebar-divider">
<!-- Nav Item - Settings Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings">
    <i class="fas fa-fw fa-tools"></i>
    <span>Settings</span>
  </a>
  <div id="collapseSettings" class="collapse" aria-labelledby="headingSettings" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Custom Settings:</h6>
      <?php
          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_Company == 'Yes')) 
          {
            echo '<a class="collapse-item" id="company_list_link" href="/layout/items/company_list.php">Company</a>';
          };
          if ($user_type == 'Ultra_Super_User') 
          {
            echo '<a class="collapse-item" id="branch_list_link" href="/layout/items/branch_list.php">Branch</a>
            <a class="collapse-item" id="sms_list_link" href="/layout/items/sms_list.php">SMS</a>';
          };

          if ($user_type == 'Ultra_Super_User' OR $user_type == 'Super_User' OR ($user_type == 'Normal_User' AND $View_User == 'Yes')) 
          {
            echo '<a class="collapse-item" id="users_list_link" href="/layout/items/user_list.php">Users and Passwords</a>';
          };

          if ($user_type == 'Ultra_Super_User') 
         {
            echo '<a class="collapse-item" id="users_ultra_super_link" href="/layout/items/user_ultra_super_list.php">User Ultra-Super</a>
              <a class="collapse-item" id="users_admin_link" href="/layout/items/user_admin_list.php">User Admin</a>
              <a class="collapse-item" id="users_type_link" href="/layout/items/user_type_list.php">User Type</a>
              <a class="collapse-item" id="users_privileges_link" href="/layout/items/user_privileges_list.php">Privileges</a>';
          };
      ?>
      <a class="collapse-item" id="new_user_link">New User</a>
      <a class="collapse-item" id="change_password_link">Change Password</a>
    </div>
  </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
      <div class="input-group">
        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search fa-sm"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

      <!-- Nav Item - Search Dropdown (Visible Only XS) -->
      <li class="nav-item dropdown no-arrow d-sm-none">
        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-search fa-fw"></i>
        </a>
        <!-- Dropdown - Messages -->
        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
          <form class="form-inline mr-auto w-100 navbar-search">
            <div class="input-group">
              <input type="text" id="Search for" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Nav Item - Alerts -->
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <!-- Counter - Alerts -->
          <span class="badge badge-danger badge-counter">3+</span>
        </a>
        <!-- Dropdown - Alerts -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
          <h6 class="dropdown-header">
            Alerts Center
          </h6>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <div class="mr-3">
              <div class="icon-circle bg-primary">
                <i class="fas fa-file-alt text-white"></i>
              </div>
            </div>
            <div>
              <div class="small text-gray-500">December 12, 2019</div>
              <span class="font-weight-bold">A new monthly report is ready to download!</span>
            </div>
          </a>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <div class="mr-3">
              <div class="icon-circle bg-success">
                <i class="fas fa-donate text-white"></i>
              </div>
            </div>
            <div>
              <div class="small text-gray-500">December 7, 2019</div>
              $290.29 has been deposited into your account!
            </div>
          </a>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <div class="mr-3">
              <div class="icon-circle bg-warning">
                <i class="fas fa-exclamation-triangle text-white"></i>
              </div>
            </div>
            <div>
              <div class="small text-gray-500">December 2, 2019</div>
              Spending Alert: We've noticed unusually high spending for your account.
            </div>
          </a>
          <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
        </div>
      </li>

      <!-- Nav Item - Messages -->
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <!-- Counter - Messages -->
          <span class="badge badge-danger badge-counter">7</span>
        </a>
        <!-- Dropdown - Messages -->
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
          <h6 class="dropdown-header">
            Message Center
          </h6>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <div class="dropdown-list-image mr-3">
              <img class="rounded-circle" src="/img/logo_2.png" alt="">
              <div class="status-indicator bg-success"></div>
            </div>
            <div class="font-weight-bold">
              <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
              <div class="small text-gray-500">Emily Fowler · 58m</div>
            </div>
          </a>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <div class="dropdown-list-image mr-3">
              <img class="rounded-circle" src="/img/logo_2.png" alt="">
              <div class="status-indicator"></div>
            </div>
            <div>
              <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
              <div class="small text-gray-500">Jae Chun · 1d</div>
            </div>
          </a>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <div class="dropdown-list-image mr-3">
              <img class="rounded-circle" src="/img/logo_2.png" alt="">
              <div class="status-indicator bg-warning"></div>
            </div>
            <div>
              <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
              <div class="small text-gray-500">Morgan Alvarez · 2d</div>
            </div>
          </a>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <div class="dropdown-list-image mr-3">
              <img class="rounded-circle" src="/img/logo_2.png" alt="">
              <div class="status-indicator bg-success"></div>
            </div>
            <div>
              <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
              <div class="small text-gray-500">Chicken the Dog · 2w</div>
            </div>
          </a>
          <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
        </div>
      </li>

      <div class="topbar-divider d-none d-sm-block"></div>

      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">
            <?php 
              if (isset($_SESSION['full_name'])) {
                echo $_SESSION['full_name'];
              }
            ?>
            </span>
          <img class="img-profile rounded-circle" src="/img/logo_2.png">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
          </a>
          <a class="dropdown-item" href="#">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            Settings
          </a>
          <a class="dropdown-item" href="#">
            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
            Activity Log
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
          </a>
        </div>
      </li>

    </ul>

  </nav>
  <!-- End of Topbar -->


  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

 <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" id="btn_logout" href="/logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/receipt_categorisation_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/lab_occurance_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/nhis_specialty_detail_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/appointment_report_by_date_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/appointment_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/incidence_of_disease_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/statement_of_out_patient_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/statement_of_in_patient_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/stock_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/stock_adjustment_zero_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/mini_stock_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/sales_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/sales_summary_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/dispensed_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/stock_item_tally_card_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/ledger_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/ledger_detail_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/nhis_specialty_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/ledger_summary_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/trial_balance_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/attend_summary_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/daily_summary_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/user_personal_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/user_personal_change_password_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/user_ultra_super_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/doctors_attend_register_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/payment_type_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/sms_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/employee_time_sheet_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/employee_register_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/pay_slip_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/payroll_bank_advice_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/payroll_paye_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/payroll_1st_tier_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/payroll_2nd_tier_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/payroll_statement_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/payroll_welfare_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/loan_report_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/bonus_voucher_modal.php');?>