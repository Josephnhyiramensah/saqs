<?php 
    require('includes/db.php');
    include('includes/auth.php');
    include('includes/header_main.php');
    include('includes/navbar_main.php');
    if(isset($_POST['create_btn']))
        {
            $id = $_POST['patient_id'];
            $dob = $_POST['dob'];
            $name = $_POST['name'];
            $today = date("Y-m-d H:i:s");
            //$age = date_diff(date_create($dob), date_create($today));
            $query = "INSERT INTO attendance (patient_id, age, name, date_admit) 
                VALUES ('$id', '40', '$name', '$today')";
            $query_run = mysqli_query($con,$query);
        };
    /*else if($_POST['edit_btn'])
        {
         
        }
    else if($_POST['delete_btn'])
        {
        
        };*/
?>

<div class="container-fluid">

<!-- DataTables Example -->
    <div class="card shadow md-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Attendance List
            </h6>
        </div>
        <div class="card-body">

            <?php
            if(isset($_SESSION['success']) && $_SESSION['success'] !='')
            {
                echo '<h2>'.$_SESSION['success'].'</h2>';
                unset($_SESSION['success']);
            };
            if(isset($_SESSION['status']) && $_SESSION['status'] !='')
            {
                echo '<h2>'.$_SESSION['status'].'</h2>';
                unset($_SESSION['status']);
            };
            ?>

            <?php
                
                $query = "SELECT * FROM attendance";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Receipt ID</th>
                            <th>Date</th>
                            <th>Ledger To</th>
                            <th>Ledger From</th>
                            <th>Amount</th>
                            <th>Narration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                        ?>
                                <tr>
                                    <td> <?php echo $row['PatientID']?></td>
                                    <td> </td>
                                    <td> <?php echo $row['name'] ?></td>
                                    <td> <?php echo $row['age']?></td>
                                    <td> </td>
                                    <td> <?php echo $row['tos']?></td>
                                </tr>
                        <?php
                                }
                            }
                            else
                            {
                                    echo 'No Record Found';
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include('includes/scripts_main.php');?>
<?php include('includes/footer_main.php');?>