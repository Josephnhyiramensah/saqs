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
    .amt-td {
            text-align:right;
          }
    .action-td {
            text-align:center;
          }
</style>
<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Composite Laboratory List
	            </h4>
                <div class="input-group">
                    <a href="#" data-toggle="" id="new_composite_lab_icon">New Composite Lab</a>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">
                        <a href="#" data-toggle="" id="new_composite_lab_icon"><i class="fas fa-flask"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                
                $query = "SELECT * FROM composite_labs ORDER BY composite_lab";
                $query_run = mysqli_query($con, $query);
            ?>
			</table>
            <div class="table-responsive" id="composite_lab_table">
                <table class="table table-hover table-bordered table-sm" id="compositelabTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">Description</th>
                            <th class="action-td">Price</th>
                            <th class="action-td">Action</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row = mysqli_fetch_assoc($query_run))
                                {
                                    echo'<tr style="background-color:#E4DCCF; color:black">
        	                            <td>'.$row['composite_lab'].'</td>
                                        <td class="amt-td">'.$row['price'].'</td>
        	                            <td class="action-td">
                                            <a href="#" id="btn_add_composite_lab_list" data-id="'.$row['composite_lab_id'].'">Add lab Test</a>
                                            | 
                                            <a href="#" id="btn_edit_composite_lab" data-id="'.$row['composite_lab_id'].'">Edit</a>
                                            | 
        									<a href="#" id="btn_delete_composite_lab" data-id="'.$row['composite_lab_id'].'">Delete</a>
        	                            </td>
                                    </tr>';

                                    $composite_lab_id = $row['composite_lab_id'];
                                    $query_com_lab_list = "SELECT * FROM composite_lab_list WHERE composite_lab_id ='$composite_lab_id'";
                                    $query_run_com_lab_list = mysqli_query($con, $query_com_lab_list);
                                    while($row_com_lab_list = mysqli_fetch_assoc($query_run_com_lab_list))
                                    {
                                        $lab_id = $row_com_lab_list['lab_id'];
                                        $query_lab = "SELECT * FROM lab WHERE lab_id ='$lab_id'";
                                        $query_run_lab = mysqli_query($con, $query_lab);

                                        if (mysqli_num_rows($query_run_lab) > 0)
                                        {
                                            $row_lab = mysqli_fetch_assoc($query_run_lab);
                                            $lab_desc = $row_lab['lab'];
                                        }
                                        else
                                        {
                                            
                                            $lab_desc = 'THIS LAB DOES NOT EXIST!';
                                        };

                                        echo'<tr>
                                            <td></td>
                                            <td>'.$lab_desc.'</td>
                                            <td class="action-td">
                                                <a href="#" id="btn_edit_composite_lab_list" data-id="'.$row_com_lab_list['composite_lab_list_id'].'">Edit</a>
                                                | 
                                                <a href="#" id="btn_delete_composite_lab_list" data-id="'.$row_com_lab_list['composite_lab_list_id'].'">Delete</a>
                                            </td>
                                        </tr>';
                                    };
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
<?php include('composite_lab_create_modal.php');?>
<?php include('composite_lab_list_create_modal.php');?>
<?php include('item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>