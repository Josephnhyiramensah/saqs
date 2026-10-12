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
	                Composite Drug List
	            </h4>
                <div class="input-group">
                    <a href="#" data-toggle="" id="new_composite_drug_icon">New Composite Drug</a>
                </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
		        	<div class="input-group">
                        <a href="#" data-toggle="" id="new_composite_drug_icon"><i class="fas fa-pills"></i></a>
		            </div>
		        </form>
	        </div>
        </div>
        <div class="card-body">
            <?php
                
                $query = "SELECT * FROM composite_drugs ORDER BY composite_drug";
                $query_run = mysqli_query($con, $query);
            ?>
			</table>
            <div class="table-responsive" id="composite_drug_table">
                <table class="table table-hover table-bordered table-sm" id="compositedrugTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th colspan="3" class="action-td">Description</th>
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
        	                            <td colspan="3">'.$row['composite_drug'].'</td>
                                        <td class="amt-td">'.$row['price'].'</td>
        	                            <td class="action-td">
                                            <a href="#" id="btn_add_composite_drug_list" data-id="'.$row['composite_drug_id'].'">Add Drug</a>
                                            | 
                                            <a href="#" id="btn_edit_composite_drug" data-id="'.$row['composite_drug_id'].'">Edit</a>
                                            | 
        									<a href="#" id="btn_delete_composite_drug" data-id="'.$row['composite_drug_id'].'">Delete</a>
        	                            </td>
                                    </tr>';

                                    $composite_drug_id = $row['composite_drug_id'];
                                    $query_com_drug_list = "SELECT * FROM composite_drug_list WHERE composite_drug_id ='$composite_drug_id'";
                                    $query_run_com_drug_list = mysqli_query($con, $query_com_drug_list);
                                    while($row_com_drug_list = mysqli_fetch_assoc($query_run_com_drug_list))
                                    {
                                        $drug_id = $row_com_drug_list['drug_id'];
                                        $query_drug = "SELECT * FROM drugs WHERE drug_id ='$drug_id'";
                                        $query_run_drug = mysqli_query($con, $query_drug);
                                        
                                        if (mysqli_num_rows($query_run_drug) > 0)
                                        {
                                            $row_drug = mysqli_fetch_assoc($query_run_drug);
                                            $drug_desc = $row_drug['brand_name'];
                                        }
                                        else
                                        {
                                            
                                            $drug_desc = 'THIS DRUG DOES NOT EXIST!';
                                        };

                                        echo'<tr>
                                            <td></td>
                                            <td>'.$drug_desc.'</td>
                                            <td class="action-td">'.$row_com_drug_list['dosage'].'</td>
                                            <td class="action-td">'.$row_com_drug_list['qty'].'</td>
                                            <td class="action-td">
                                                <a href="#" id="btn_edit_composite_drug_list" data-id="'.$row_com_drug_list['composite_drug_list_id'].'">Edit</a>
                                                | 
                                                <a href="#" id="btn_delete_composite_drug_list" data-id="'.$row_com_drug_list['composite_drug_list_id'].'">Delete</a>
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
<?php include('composite_drug_create_modal.php');?>
<?php include('composite_drug_list_create_modal.php');?>
<?php include('item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>