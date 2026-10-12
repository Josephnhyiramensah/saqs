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
<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Consumable List
	            </h4>
                <a href="#" id="new_consum_icon">New Consumable Item</a>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">
                    <a href="#" data-toggle="" id="new_consum_icon"><i class="fas fa-plus-square"></i></a>
		            </div>
		        </form>
	        </div>
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
                
                $query = "SELECT * FROM consumable ORDER BY consumable ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="consum_list_table">
                <table class="table table-hover table-bordered table-sm" id="consumTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Unit</th>
                            <th>Price - Cash</th>
                            <th>Price - NHIS</th>
                            <th>Price - Private</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                                    $con_type_id = $row['con_type_id'];
                                    $query_type = "SELECT * FROM consumable_type WHERE con_type_id='$con_type_id'";
                                    $query_type_run = mysqli_query($con, $query_type);
                                    if($query_type_run)
                                    {
                                        $row_type = mysqli_fetch_assoc($query_type_run);
                                        if($row_type != '')
                                        {
                                            $consum_type = $row_type['consum_type'];
                                        }
                                        else
                                        {
                                            $consum_type = 'No Type';
                                        };
                                    }
                                    else
                                    {
                                        $consum_type = 'No Type';
                                    };

                                    $unit_id = $row['unit_id'];
                                    $query_unit = "SELECT * FROM unit WHERE unit_id='$unit_id'";
                                    $query_unit_run = mysqli_query($con, $query_unit);
                                    if($query_unit_run)
                                    {
                                        $row_unit = mysqli_fetch_assoc($query_unit_run);
                                        if($row_unit != '')
                                        {
                                            $unit = $row_unit['formal_name'];
                                        }
                                        else
                                        {
                                            $unit = 'No Unit';
                                        };
                                    }
                                    else
                                    {
                                        $unit = 'No Unit';
                                    };
                        ?>
                                    <tr>
                                        <td>
                                            <a href="#" id="btn_edit_consum" data-id="<?php echo $row['con_id'];?>"><?php echo $row['consumable'];?></a>
                                        </td>
                                        <td><?php echo $consum_type;?></td>
                                        <td><?php echo $unit;?></td>
                                        <td><?php echo $row['price_cash'];?></td>
                                        <td><?php echo $row['price_nhis'];?></td>
                                        <td><?php echo $row['price_prvt'];?></td>
        	                            <td>
        									<a href="#" id="btn_delete_consum" data-id2="<?php echo $row['con_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
        	                            </td>
                                    </tr>
                        <?php
                                };
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/consum_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>