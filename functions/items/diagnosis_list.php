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

    .scroll-card-body {
            max-height: 850px;
            overflow-y: auto;
        }
    .amt-td {
            text-align:right;
        }
    .action-td {
            text-align:center;
        }
  </style>
<div class="container-fluid scroll-card-body">
    <div class="card shadow md-4">
        <div class="card-header py-3">
        	<div class="float-left">
	            <h4 class="m-0 font-weight-bold text-primary">
	                Diagnosis List
	            </h4>
		        <div class="input-group">
                    <a href="#" data-toggle="" id="new_diagnosis_icon">New Diagnosis</a>
		        </div>
            </div>
            <div class="float-right">
		        <form class="form-inline mr-auto w-100 navbar-search">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" name="search_diagnosis" id="search_diagnosis">
		              <div class="input-group-append">
		                <button class="btn btn-primary" type="button">
		                  <i class="fas fa-search fa-sm"></i>
		                </button>
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
                
                $query = "SELECT * FROM diagnosis ORDER BY diagnosis ASC";
                $query_run = mysqli_query($con, $query);
            ?>
            <div class="table-responsive" id="diagnosis_list_table">
                <table class="table table-hover table-bordered table-sm" id="diagnosisTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="action-td">Diagnosis</th>
                            <th class="action-td">ICD-10</th>
                            <th class="action-td">G-DRG</th>
                            <th class="action-td">G-DRG Adult</th>
                            <th class="action-td">G-DRG Child</th>
                            <th class="action-td">Price</th>
                            <th class="action-td">Price Adult</th>
                            <th class="action-td">Price Child</th>
                            <th class="action-td">Delete</th>
                        </tr>
                    </thead>
                    <tbody class="pv-table-body">
                        <?php
                            if (mysqli_num_rows($query_run) > 0)
                            {
                                while($row=mysqli_fetch_assoc($query_run))
                                {
                                    $nhis_id = $row['nhis_id'];
                                    $query_nhis = "SELECT * FROM nhis WHERE nhis_id='$nhis_id'";
                                    $query_nhis_run = mysqli_query($con, $query_nhis);
                                    $row_nhis=mysqli_fetch_assoc($query_nhis_run);
                        ?>
                                    <tr>
                                        <td>
                                            <a href="#" id="btn_edit_diagnosis" data-id="<?php echo $row['diagnosis_id'];?>"><?php echo $row['diagnosis'];?></a>
                                        </td>
                                        <td class="action-td"><?php echo $row['icd_10'];?></td>
                                        <td class="action-td"><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['gdrg'];}?></td>
                                        <td class="action-td"><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['gdrg_adult'];}?></td>
                                        <td class="action-td"><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['gdrg_child'];}?></td>
                                        <td class="amt-td"><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['price'];}?></td>
                                        <td class="amt-td"><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['price_adult'];}?></td>
                                        <td class="amt-td"><?php if ($row_nhis==null){echo 'N/A';}else{echo $row_nhis['price_child'];}?></td>
        	                            <td class="action-td">
        									<a href="#" id="btn_delete_diagnosis" data-id="<?php echo $row['diagnosis_id'];?>"
                                                data-id1="<?php echo $row['diagnosis'];?>"><i class="fa fa-trash fa-sm"></i></a>
        	                            </td>
                                    </tr>
                        <?php
                                }
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
<?php include('diagnosis_create_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/footer_main.php');?>