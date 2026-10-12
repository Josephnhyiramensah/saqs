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
            <h6 class="m-0 font-weight-bold text-primary">EDIT Patient Profile</h6>
        </div>
        <div class="card-body">
            <?php
                if(isset($_POST['edit_btn']))
                {
                    $id = $_POST['edit_id'];
                    $query = "SELECT * FROM patients WHERE patient_id='$id'";
                    $query_run = mysqli_query($con,$query);
                    $row = mysqli_fetch_assoc($query_run);
                };
            ?>
            <form action="code.php" method="POST">
                <input type="hidden" name="edit_id" value="<?php echo $row['id'];?>">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="edit_username" class="form-control" value="<?php echo $row['username'];?>" placeholder="Enter Username">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="edit_email" class="form-control" value="<?php echo $row['email'];?>" placeholder="Enter Email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="edit_password" class="form-control" value="<?php echo $row['password'];?>" placeholder="Enter Password">
                </div>
                <div class="form-group">
                    <label>User Type</label>
                    <input type="text" name="edit_usertype" class="form-control" placeholder="User Type">
                </div>
                <button type="submit" name="updatebtn" class="btn btn-success">Update</button>
                <a href="welcome.php" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</div>
<?php include('includes/scripts_main.php');?>
<?php include('includes/footer_main.php');?>