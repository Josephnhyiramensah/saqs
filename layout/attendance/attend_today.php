
<?php 
    require('includes/db.php');
    include('includes/auth.php');
    include('includes/header_main.php');
    include('includes/navbar_main.php');
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
                
                $query = "SELECT * FROM patients";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Attendance ID</th>
                            <th>Patient ID</th>
                            <th>Folder No</th>
                            <th>Patient Name</th>
                            <th>Date of Birth</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Action</th>
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
                                    <td> <?php echo $row['Patient_Id']?></td>
                                    <td> <?php echo $row['folder_no']?></td>
                                    <td> <?php echo $row['firstname']." ". $row['lastname'] ?></td>
                                    <td> <?php echo $row['date_of_birth']?></td>
                                    <td> <?php echo $row['age']?></td>
                                    <td> <?php echo $row['gender']?></td>
                                    <td> 
                                        <form action="registeredit.php" method="POST">
                                            <input type="hidden" name="edit_id" value="<?php echo $row['patient_id']?>;">
                                            <button type="submit" name="edit_btn" class="btn btn-link btn-sm">EDIT</button>
                                        </form> | 
                                        <form action="code.php" method="POST">
                                            <input type="hidden" name="delete_id" value="<?php echo $row['patient_id']?>;">
                                            <button type="submit" name="delete_btn" class="btn btn-link btn-sm">DELETE</button>
                                        </form>
                                    </td>
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