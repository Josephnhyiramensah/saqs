<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
    
	$query = "SELECT * FROM dialysis_sheet WHERE patient_id = '$patient_id' ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);

	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
?>  
<style type="text/css">
	.scroll-card-body {max-height: 300px;overflow-y: auto;}
	.scroll-card-img {max-height: 700px;overflow-y: auto;}
	.amt-td {text-align:right;}
	.action-td {text-align:center;}
</style>
<div class="form-row">
	<div class="col-md-8 mb-8">
		<label for="new_dialysis_sheet"><a href="#" id="new_dialysis_sheet"><h5><strong>Click To Add Dialysis Sheet</strong></h5></a></label>
	</div>
</div>
<hr class="d-none d-md-block">
<div class="table-responsive" id="attend_dialysis_table">
    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="action-td">Date</th>
				<th class="action-td">Type of Dialysis</th>
                <th class="action-td">Treatment Time</th>
            	<th class="action-td">Previous Weight</th>
				<th class="action-td">Current Weight</th>
				<th class="action-td">Pre - BP</th>
				<th class="action-td">Post - BP</th>
				<th class="action-td">Pre - Temp</th>
				<th class="action-td">Post - Temp</th>
				<th class="action-td">Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">
            <?php
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
            			echo'<tr>
		                    <td class="action-td">'.$row['date'].'</td>
		                	<td>'.$row['type_of_dialysis'].'</td>
							<td>'.$row['treatment_time'].'</td>
			                <td>'.$row['previous_weight'].'</td>
			                <td>'.$row['dry_weight'].'</td>
			                <td>'.$row['bp_pre'].'</td>
			                <td>'.$row['bp_post'].'</td>
			                <td>'.$row['temp_pre'].'</td>
			                <td>'.$row['temp_post'].'</td>
			                <td class="action-td">
								<a href="#" id="edit_dialysis_sheet" data-id="'.$row['dialysis_sheet_id'].'">Edit</a>
								|
								<a href="#" id="display_dialysis_sheet" data-id="'.$row['dialysis_sheet_id'].'">Display</a>
								|
								<a href="#" id="delete_dialysis_sheet" data-id="'.$row['dialysis_sheet_id'].'">Delete</a>
							</td>
		                </tr>';
                    }
                };
            ?>
        </tbody>
    </table>
</div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/dialysis_sheet_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/items/item_delete_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/lab_search_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/lab_request_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/discount_create_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>