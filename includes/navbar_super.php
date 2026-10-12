 <?php

    include($_SERVER['DOCUMENT_ROOT'] .'/includes/sessions.php');
    
?>
<!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <?php
      /*$sql_comp = "SELECT * FROM company WHERE company_id = '".$_SESSION['company_id']."'";
      $result_comp = mysqli_query($con,$sql_comp);
      if(mysqli_num_rows($result_comp) > 0)
      {*/
        echo'<a class="sidebar-brand d-flex align-items-center justify-content-center"';
        if($company_id =='' && $company_id > 0)
        {
          echo 'href="/welcome.php">';
        }
        else
        {
          echo 'href="#">';
        };

      /*}
      else
      {
         echo'<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">';
      };*/
    ?>
      <div class="sidebar-brand-icon rotate-n-15">
        <img src="/img/logo_2.png" alt="HealthNotes" class="img-thumbnail">
      </div>
      <div class="sidebar-brand-text mx-3">
        <?php
            if (isset($user_super_id) && $user_super_id >0) {
              $sql = "SELECT * FROM user_super WHERE user_super_id = '$user_super_id' ORDER BY name ASC";
              $result = mysqli_query($con,$sql);
              $row = mysqli_fetch_array($result);
              echo $row['name'];
            } 
            else if(isset($user_ultra_super_id))
            {
              $sql = "SELECT * FROM user_ultra_super WHERE user_ultra_super_id = '$user_ultra_super_id' ORDER BY name ASC";
              $result = mysqli_query($con,$sql);
              $row = mysqli_fetch_array($result);
              echo $row['name'];
            };
          ?>
      </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="#">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>HealthNotes</span>
      </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Interface
    </div>

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
      <a class="collapse-item" id="change_password_link">Change Password</a>
        </div>
      </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline"><button class="rounded-circle border-0" id="sidebarToggle"></button></div>

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
              <img class="rounded-circle" src="/img/logo_2.jpg" alt="">
              <div class="status-indicator bg-success"></div>
            </div>
            <div class="font-weight-bold">
              <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
              <div class="small text-gray-500">Emily Fowler · 58m</div>
            </div>
          </a>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <div class="dropdown-list-image mr-3">
              <img class="rounded-circle" src="/img/logo_2.jpg" alt="">
              <div class="status-indicator"></div>
            </div>
            <div>
              <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
              <div class="small text-gray-500">Jae Chun · 1d</div>
            </div>
          </a>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <div class="dropdown-list-image mr-3">
              <img class="rounded-circle" src="/img/logo_2.jpg" alt="">
              <div class="status-indicator bg-warning"></div>
            </div>
            <div>
              <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
              <div class="small text-gray-500">Morgan Alvarez · 2d</div>
            </div>
          </a>
          <a class="dropdown-item d-flex align-items-center" href="#">
            <div class="dropdown-list-image mr-3">
              <img class="rounded-circle" src="/img/logo_2.jpg" alt="">
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
          <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php 
                if (isset($_SESSION['full_name'])) {
                  echo $_SESSION['full_name'];
                }
              ?>
          </span>
          <img class="img-profile rounded-circle" src="/img/logo_2.jpg">
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
  <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

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

<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/user_personal_change_password_modal.php');?>