 <?php 
  $name = $_SESSION['name'];
  $patient_id = $_SESSION['patient_id'];
  $typeofservice_attd = $_SESSION['typeofservice_attd'];
  ?>
 <!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
<!-- Divider -->
<hr class="sidebar-divider my-0">
<li class="nav-item">
  <a class="nav-link" href="#" id="nav_home">
    <i class="fas fa-home"></i>
      <span>End Consultation</span>
  </a>
</li>
<!-- Divider -->
<hr class="sidebar-divider">
<?php
  if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Attendance'] == 'Yes')) 
  {
      echo '<li class="nav-item">
      <a class="nav-link" href="#" id="nav_attendance_edit">
        <i class="far fa-address-card"></i>
        <span>Attendance Details</span>
      </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">';
  };
?>
<!-- Nav Item - Setup Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGeneral" aria-expanded="true" aria-controls="collapseGeneral">
    <i class="fas fa-fw fa-folder-plus"></i>
    <span>General</span>
  </a>
  <div id="collapseGeneral" class="collapse show" aria-labelledby="headingGeneral" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
      <?php
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Vitals'] == 'Yes')) 
        {
            echo '<a class="collapse-item" href="#" id="nav_vitals"><i class="fa fa-heartbeat"></i> Vitals</a>';
        };
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_History'] == 'Yes')) 
        {
            echo '<a class="collapse-item" href="#" id="nav_history"><i class="fas fa-file-medical-alt"></i> History</a>';
        };
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Diagnosis_List'] == 'Yes')) 
        {
            echo '<a class="collapse-item" href="#" id="nav_diagnosis"><i class="fas fa-diagnoses"></i> Diagnosis</a>';
        };
        /*if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Dental'] == 'Yes')) 
        {
            echo '<a class="collapse-item" href="#" id="nav_dental" ><i class="fas fa-tooth"></i> Dental</a>';
        };*/
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Lab_List'] == 'Yes')) 
        {
            echo '<a class="collapse-item" href="#" id="nav_labs"><i class="fas fa-flask"></i> Labs</a>';
        };
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Radiology_List'] == 'Yes')) 
        {
            echo '<a class="collapse-item" href="#" id="nav_radio"><i class="fas fa-x-ray"></i> Radiology</a>';
        };
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Prescription'] == 'Yes')) 
        {
            echo '<a class="collapse-item" href="#" id="nav_drugs"><i class="fas fa-prescription-bottle-alt"></i> Prescription</a>';
        };
        /*if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Consumable_List'] == 'Yes')) 
        {
            echo '<a class="collapse-item" href="#" id="nav_consumables"><i class="fas fa-toilet-paper"></i> Consumables</a>';
        };*/
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND ($_SESSION['View_Mgt_Plan'] == 'Yes' OR $_SESSION['View_Nurses_Notes'] == 'Yes' ))) 
        {
            echo '<a class="collapse-item" href="#" id="nav_mgtplan"><i class="fas fa-notes-medical"></i> Management Plan</a>';
        };
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Maternity'] == 'Yes')) 
        {
          $query_patient = "SELECT * FROM patients WHERE patient_id='$patient_id'";
          $query_run_patient = mysqli_query($con, $query_patient);
            if(isset($query_run_patient))
            {
              $row_patient = mysqli_fetch_assoc($query_run_patient);
              if ($row_patient['gender'] == 2)
              {
                echo '<a class="collapse-item" href="#" id="nav_maternity"><i class="fas fa-baby"></i> Maternity</a>';
              };
            }
            else
            {
              echo '<a class="collapse-item" href="#" id="nav_maternity"><i class="fas fa-baby"></i> Maternity</a>';
            };
        };
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Service_List'] == 'Yes')) 
        {
          echo'<a class="collapse-item" href="#" id="nav_service"><i class="fas fa-concierge-bell"></i> Service</a>';
        };
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Surgery_List'] == 'Yes')) 
        {
          echo'<a class="collapse-item" href="#" id="nav_surgery"><i class="fas fa-procedures"></i> Surgery/Procedure</a>';
        };
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Patient_Admission'] == 'Yes')) 
        {
          echo'<a class="collapse-item" href="#" id="nav_admit"><i class="fas fa-clinic-medical"></i> Admissions</a>';
        };
		?>
        <a class="collapse-item" href="#" id="nav_new_dialysis"><i class="fa fa-file"></i> Dialysis</a>';
    <?php
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Patient_Folder'] == 'Yes')) 
        {
          echo'<hr>
        <a class="collapse-item" href="#" id="nav_myfolder"><i class="fa fa-folder"></i> Patient Folder</a>
        <a class="collapse-item" href="#" id="nav_Print_Attd_sheet"><i class="fa fa-folder"></i> Print Attd. Sheet</a>';
        };
      ?>
      <a class="collapse-item" href="#" id="nav_new_appointment"><i class="fa fa-calendar"></i> Appointment</a>';
      <a class="collapse-item" href="#" id="nav_new_excuse_duty"><i class="fa fa-file"></i> Excuse Duty</a>';
      <?php 
        //if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND ($_SESSION['View_Feedback'] == 'Yes'))) 
        //{
            echo '<a class="collapse-item" href="/layout/attendance/feedback_patient.php" id="nav_feedback_patient"><i class="fas fa-comment"></i> Feedback</a>';
        //};
        ?>
    </div>
  </div>
</li>

<hr class="sidebar-divider">

<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMisc" aria-expanded="true" aria-controls="collapseMisc">
    <i class="fas fa-fw fa-folder-plus"></i>
    <span>Miscellaneous</span>
  </a>
  <div id="collapseMisc" class="collapse show" aria-labelledby="headingMisc" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
      <?php
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Service_List'] == 'Yes')) 
        {
          echo'<a class="collapse-item" href="#" id="nav_service"><i class="fas fa-concierge-bell"></i> Service</a>';
        };
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Surgery_List'] == 'Yes')) 
        {
          echo'<a class="collapse-item" href="#" id="nav_surgery"><i class="fas fa-procedures"></i> Surgery/Procedure</a>';
        };
      ?>
      </div>
  </div>
</li>
<?php
if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Patient_Admission'] == 'Yes')) 
{
  echo'<hr class="sidebar-divider">
  <li class="nav-item">
    <a class="nav-link" href="#" id="nav_admit">
      <i class="fas fa-clinic-medical"></i>
      <span>Admissions</span>
    </a>
  </li>';
};
?>
<hr class="sidebar-divider">

<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSpecialised" aria-expanded="true" aria-controls="collapseSpecialised">
    <i class="fas fa-fw fa-folder-plus"></i>
    <span>Specialised</span>
  </a>
  <div id="collapseSpecialised" class="collapse" aria-labelledby="headingSpecialised" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
      <?php
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Eye'] == 'Yes')) 
        {
          echo'<a class="collapse-item" href="#" id="nav_eye"><i class="fas fa-eye"></i> Eye</a>';
        };
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Dental'] == 'Yes')) 
        {
          echo'<a class="collapse-item" href="#" id="nav_dental" ><i class="fas fa-tooth"></i> Dental</a>';
        };
        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Physio'] == 'Yes')) 
        {
          echo'<a class="collapse-item" href="#" id="nav_physio"><i class="fas fa-dumbbell"></i> Physiotheray</a>';
        };
      ?>
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
    <div class="float-left">
      <h3 class="m-0 font-weight-bold text-primary">
                <?php echo $name;?>
            </h3>
    </div>
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
          <a class="btn btn-primary" href="/logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>


<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/nhis_attendance_edit_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/nhis_diagnosis_edit_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/nhis_drug_edit_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/reports/nhis_procedure_edit_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/patients/patient_age_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/calendar_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/excuse_duty_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/patients/patient_allergies_modal.php');
?>