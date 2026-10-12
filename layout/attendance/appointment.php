<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_main.php');
?>
<style type="text/css">
    input {
            border-top-style: hidden;
            border-right-style: hidden;
            border-left-style: hidden;
            border-bottom-style: hidden;
            background-color: #ffffff;
          }
  </style>
    <div class="container-fluid py-5">
        <div class="card shadow md-4 mx-auto" style="width: 60%;">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">
                    <a href="">Appointment</a>
                </h3>
            </div>
            <div class="card-body p-5">
                <div class="form-row px-5">
            <?php
                $query_appoint_type = "SELECT * FROM appoint_type ORDER BY appoint_type";
                $result_appoint_type = mysqli_query($con,$query_appoint_type);
                if (mysqli_num_rows($result_appoint_type) > 0)
                {
                    while($row_appoint_type = mysqli_fetch_assoc($result_appoint_type))
                    {
                        echo '<div class="col-md-4 mb-4 align-items-center">
                            <a id="'.$row_appoint_type['appoint_type_id'].'" href="#" class="btn btn-primary btn-lg btn-block text-white btn_appoint_type">'.$row_appoint_type['appoint_type'].'</a>
                        </div>';
                    }
                };
            ?>
                    <div class="col-md-4 mb-4 align-items-center">
                        <a id="all_appointments" href="#" class="btn btn-primary btn-lg btn-block text-white btn_appoint_type">ALL</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>