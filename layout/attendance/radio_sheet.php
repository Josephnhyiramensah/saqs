<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
    $query = "SELECT * FROM radio_list WHERE attend_id='$attend_id' ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
?>

<div class="form-row">
	<div class="col-md-6 mb-6">
	</div>
	<div class="col-md-2 mb-2">
	<a href="#" id="radio_attend_request">Request Radiology</a>
	</div>
	<div class="col-md-2 mb-2">
		<a href="#" id="radio_attend_history_icon"><i class="fa fa-history fa-lg"></i> Past Radiology</a>
	</div>
	<div class="col-md-2 mb-2">
		<a href="#" id="radio_attend_report_icon"><i class="fa fa-file fa-lg"></i> Radiology Report</a>
	</div>
</div>

<?php
	if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Radiology_List'] == 'Yes')) 
	{
		echo '<form id="radio_attend_form" method="POST">	
		<div class="form-row">';
		if (
			$_SESSION['user_type'] == 'Ultra_Super_User' OR 
			$_SESSION['user_type'] == 'Super_User' OR 
			($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
			{
		        echo'<div class="col-md-6 mb-6">';
		    }
		    else
		    {
		    	echo'<div class="col-md-8 mb-8">';
		    };
				echo'<label for="radio_id"><a href="#" id="btn_radio_live_search"><strong><h5>Click to add Radiology</a></strong></h5></label>
					<select class="form-control" name="radio_id" id="radio_id" hidden="true"> 
				    	<option value="0">Please Select</option>';
				        
				        	$sql="SELECT * FROM radiology ORDER BY radiology ASC";
							$result=mysqli_query($con,$sql);
				            while($row=mysqli_fetch_array($result))
				            {
					            echo'<option value = "'.$row['radio_id'].'">
					                '.$row['radiology'].'
					            </option>';
				            };
				    echo'</select>
					<input type="hidden" name="radio_list_id" class="form-control" id="radio_list_id" value="">
					<input type="hidden" name="radio_qty" class="form-control" id="radio_qty" value="1">
				</div>';
		if (
			$_SESSION['user_type'] == 'Ultra_Super_User' OR 
			$_SESSION['user_type'] == 'Super_User' OR 
			($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
			{
                echo'<div class="col-md-2 mb-2" hidden="true">';
	        }
	        else
	        {
	        	echo'<div class="col-md-4 mb-4" hidden="true">';
	        };
					echo'<label for="radio_date">Date</label>
					<input type="date" name="radio_date" class="form-control" id="radio_date" value="'.$date.'">
				</div>';

		if (
			$_SESSION['user_type'] == 'Ultra_Super_User' OR 
			$_SESSION['user_type'] == 'Super_User' OR 
			($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
			{
                echo'<div class="col-md-2 mb-2" hidden="true">
						<label for="radio_sponsor">Sponsor</label>
						<select class="form-control" name="radio_sponsor" id="radio_sponsor"> 
							<option value="0">Please Select</option>';
							
							$sponsor_option = set_sponsor_list();
							echo $sponsor_option;
							
						echo'</select>
					</div>
					<div class="col-md-2 mb-2" hidden="true">
						<label for="radio_amt_est">Estimated Lab Bill</label>
						<input type="hidden" name="radio_price_est" class="form-control" id="radio_price_est">
						<input type="text" name="radio_amt_est" class="form-control" id="radio_amt_est">
					</div>';
			};
				echo '</div>
					<div class="form-row" hidden="true">
						<div class="col-md-12 mb-12">
							<label for="radio_comment">Comment</label>
							<textarea type="textarea" rows="2"  class="form-control" name="radio_comment" id="radio_comment" value=""></textarea>
						</div>
					</div>
					<hr class="d-none d-md-block" hidden="true">
					<div id="radio_save_update" hidden="true">
						<button type="submit" name="radio_list_save_btn" id="radio_list_save_btn" class="btn btn-primary">Save</button>
					</div>
			</form>

			<hr class="d-none d-md-block">';
	};
?>
<div class="table-responsive" id="attend_radio_table">
    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="action-td">Date</th>
                <th class="action-td">Radiology Item</th>
            <?php
                if (
						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
						$_SESSION['user_type'] == 'Super_User' OR 
						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
					{
		                echo'
		                <th class="action-td">Amt-Estimate</th>
		                <th class="action-td">Amt-Cash</th>
		                <th class="action-td">Amt-Disc</th>
		                <th class="action-td">Amt-Prvt</th>
		                <th class="action-td">Amt-NHIS</th>';
		            };
            ?>
                <th class="action-td">Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">
            <?php
                	$total_est=0;
            		$total_cash=0;
                	$total_disc=0;
                	$total_prvt=0;
                if (mysqli_num_rows($query_run) > 0)
                {
                	$amt_est=0;
                	$amt_cash=0;
                	$amt_disc=0;
                	$amt_prvt=0;
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                    	$radio_id = $row['radio_id'];
                    	$query_radio = "SELECT radiology FROM radiology WHERE radio_id='$radio_id'";
						$query_run_radio = mysqli_query($con, $query_radio);
						$row_radio=mysqli_fetch_assoc($query_run_radio);

						$radio_list_id = $row['radio_list_id'];
						$query_disc = "SELECT SUM(amount) AS amount FROM discount WHERE radio_list_id='$radio_list_id'";
    					$query_run_disc = mysqli_query($con, $query_disc);
    					$row_disc = mysqli_fetch_assoc($query_run_disc);
    					if (isset($row_disc))
						{
    						$amt_disc = $row_disc['amount'];
    					} else {
    						$amt_disc = 0;
    					};
						?>
							<tr>
								<td class="action-td"><?php echo $row['date'];?></td>
								<td><?php echo $row_radio['radiology'];?></td>
						<?php
							if (
									$_SESSION['user_type'] == 'Ultra_Super_User' OR 
									$_SESSION['user_type'] == 'Super_User' OR 
									($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
							{
								echo'
								<td class="amt-td">'.$row['amount_est'].'</td>
								<td class="amt-td">'.$row['amount_cash'].'</td>
								<td class="amt-td">'.$amt_disc.'</td>
								<td class="amt-td">'.$row['amount_prvt'].'</td>';
							};
						?>
							<td class="action-td">
								<?php
											
								if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Validate_Bill'] == 'Yes')) 
								{
									echo '<a href="#" 
										id="btn_validate_bill" 
										data-item_id="'.$row['radio_id'].'"
										data-item_list_id="'.$row['radio_list_id'].'"
										data-sponsor_id="'.$row['ledger_id'].'"
										data-cash_price="'.$row['price_cash'].'"
										data-private_price="'.$row['price_prvt'].'"
										data-item_type="radio"
										data-item_name="'.$row_radio['radiology'].'"
										>Validate
									</a>';
								};
									$total_est+=$row['amount_est'];
									$total_cash+=$row['amount_cash'];
									$total_disc+=$amt_disc;
									$total_prvt+=$row['amount_prvt'];

									$query_img = "SELECT radio_img_id FROM radio_img WHERE radio_list_id='$radio_list_id'";
									$query_run_img = mysqli_query($con, $query_img);
									$row_imgs=mysqli_num_rows($query_run_img);

									$query_receipt_item = "SELECT * FROM `receipt_items` WHERE `attend_id` = '$attend_id' AND `category_id` = 4 
									AND `item_list_id`='$radio_list_id'";
									$query_run_receipt_item = mysqli_query($con, $query_receipt_item);
									$rows_receipt_item_count = mysqli_num_rows($query_run_receipt_item);

									$query_param = "SELECT radio_param_list_id FROM radio_param_list WHERE radio_id='$radio_id' AND attend_id='$attend_id' AND radio_list_id='$radio_list_id'";
									$query_run_param = mysqli_query($con, $query_param);
									if (mysqli_num_rows($query_run_param) > 0)
									{
										$row_param=mysqli_fetch_assoc($query_run_param);
						
										if (
											$_SESSION['user_type'] == 'Ultra_Super_User' OR 
											$_SESSION['user_type'] == 'Super_User' OR 
											($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Radiology_Result'] == 'Yes')) 
										{
											echo '<a href="#" id="btn_radio_result_perform_edit" 
												data-id="'.$row['radio_list_id'].'"
												data-id1="'.$row['radio_id'].'">
												Edit Result
											</a>';
										};

										if (
											$_SESSION['user_type'] == 'Ultra_Super_User' OR 
											$_SESSION['user_type'] == 'Super_User' OR 
											($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Radiology_Result'] == 'Yes')) 
										{
											echo ' | 
											<a href="#" id="btn_radio_result_view" 
												data-id="'.$row['radio_list_id'].'"
												data-id1="'.$row['radio_id'].'">
												View Result
											</a>';
										};

										if (
											$_SESSION['user_type'] == 'Ultra_Super_User' OR 
											$_SESSION['user_type'] == 'Super_User' OR 
											($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Upload_Radiology_Result_Image'] == 'Yes')) 
										{
											if((($rows_receipt_item_count > 0 || ($row['amount_cash'] - $amt_disc)==0) && $_SESSION['typeofservice_attd'] !=2) || $_SESSION['typeofservice_attd'] ==2)
											{
												echo ' | 
												<a href="#" id="btn_radio_img_upload" data-id6="'.$row['radio_list_id'].'"
													data-id7="'.$row['radio_id'].'">
													Upload Image
												</a>';
											};
										};
											
										if ($row_imgs > 0)
										{
											if (
												$_SESSION['user_type'] == 'Ultra_Super_User' OR 
												$_SESSION['user_type'] == 'Super_User' OR 
												($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Uploaded_Radiology_Result_Image'] == 'Yes')) 
											{
												echo ' | 
													<a href="#" id="btn_radio_img_view" 
													data-id2="'.$row['radio_list_id'].'"
													data-id3="'.$row['radio_id'].'">
													View Image
												</a>';
											};
										};
									}
									else
									{
										if (
											$_SESSION['user_type'] == 'Ultra_Super_User' OR 
											$_SESSION['user_type'] == 'Super_User' OR 
											($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Enter_Radiology_Result_Internal'] == 'Yes')) 
										{
											if((($rows_receipt_item_count > 0 || ($row['amount_cash'] - $amt_disc)==0) && $_SESSION['typeofservice_attd'] !=2) || $_SESSION['typeofservice_attd'] ==2)
											{
												echo ' <a href="#" id="btn_radio_result_perform_enter" 
													data-id="'.$row['radio_list_id'].'"
													data-id1="'.$row['radio_id'].'" 
													data-id2="'.$row['ledger_id'].'">
													Enter Result
												</a>';
											};
										};

										if (
											$_SESSION['user_type'] == 'Ultra_Super_User' OR 
											$_SESSION['user_type'] == 'Super_User' OR 
											($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Enter_Radiology_Result_External'] == 'Yes')) 
										{
											echo' | <a href="#" id="btn_radio_result_enter" 
												data-id4="'.$row['radio_list_id'].'"
												data-id5="'.$row['radio_id'].'">
												Enter Ext. Result
											</a>';
										};

										if (
											$_SESSION['user_type'] == 'Ultra_Super_User' OR 
											$_SESSION['user_type'] == 'Super_User' OR 
											($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Upload_Radiology_Result_Image'] == 'Yes')) 
										{
											if((($rows_receipt_item_count > 0 || ($row['amount_cash'] - $amt_disc)==0) && $_SESSION['typeofservice_attd'] !=2) || $_SESSION['typeofservice_attd'] ==2)
											{
												echo' | <a href="#" id="btn_radio_img_upload" data-id6="'.$row['radio_list_id'].'"
													data-id7="'.$row['radio_id'].'">
													Upload Image
												</a>';
											};
										};

										if ($row_imgs > 0)
										{
											if (
												$_SESSION['user_type'] == 'Ultra_Super_User' OR 
												$_SESSION['user_type'] == 'Super_User' OR 
												($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Uploaded_Radiology_Result_Image'] == 'Yes')) 
											{
												echo' | <a href="#" id="btn_radio_img_view" data-id2="'.$row['radio_list_id'].'"
													data-id3="'.$row['radio_id'].'">
													View Image
												</a>';
											};
										};
									};
								if (
									$_SESSION['user_type'] == 'Ultra_Super_User' OR 
									$_SESSION['user_type'] == 'Super_User' OR 
									($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Discount'] == 'Yes')) 
								{
									echo' | <a href="#" id="btn_discount_radio_list"
									class="data-toggle="tooltip" data-placement="left" title="Discount Radiology"" 
									data-id="'.$row['attend_id'].'"
									data-id1="'.$_SESSION['patient_id'].'"
									data-id2="'.$row['radio_list_id'].'"
									data-id3="'.$_SESSION['name'].'"
									data-id4="'.$row['amount_cash'].'"
									data-id5="'.$amt_disc.'">
										Disc.
									</a>';
								};
								
								if ($_SESSION['user_id'] == $row['user_id']) 
								{
									if($row['date'] == $date_today)
									{
										if (
											$_SESSION['user_type'] == 'Ultra_Super_User' OR 
											$_SESSION['user_type'] == 'Super_User' OR 
											($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Radiology_List'] == 'Yes')) 
										{
											echo' |
											<a href="#" id="btn_edit_radio_attend" 
												data-id12="'.$row['radio_list_id'].'"
												data-id13="'.$row['radio_id'].'">
												Edit
											</a>';
										};
										if (
											$_SESSION['user_type'] == 'Ultra_Super_User' OR 
											$_SESSION['user_type'] == 'Super_User' OR 
											($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Radiology_List'] == 'Yes')) 
										{
											echo' |
											<a href="#" id="btn_delete_radio_attend" 
												data-id8="'.$row['radio_list_id'].'"
												data-id9="'.$row['radio_id'].'">
												Delete
											</a>';
										};
									};
								};
								?>
							</td>
						</tr>
				<?php
                    };
					if (
							$_SESSION['user_type'] == 'Ultra_Super_User' OR 
							$_SESSION['user_type'] == 'Super_User' OR 
							($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
					{
						echo'<tr>
							<td class="action-td" colspan="2">TOTAL</td>
							<td class="amt-td">'.$total_est.'</td>
							<td class="amt-td">'.$total_cash.'</td>
							<td class="amt-td">'.$total_disc.'</td>
							<td class="amt-td">'.$total_prvt.'</td>
							<td class="amt-td">'.$total_nhis.'</td>
							<td></td>
						</tr>';
					};
            	};
            ?>
        </tbody>
    </table>
</div>

<div class="modal fade bd-example-modal-xl" id="radio_attend_result_enter_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="radio_attend_result_enter_modal_title">Enter Radiology Result</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="radio_attend_result_enter_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="table-responsive" id="radio_attend_result_enter_table">
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" name="radio_attend_result_enter_save_btn" id="radio_attend_result_enter_save_btn" class="btn btn-primary">Save</button>
				    <button type="button" name="radio_attend_result_enter_cancel_btn" id="radio_attend_result_enter_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="radio_attend_result_perform_enter_modal" tabindex="-1" role="dialog" aria-labelledby="radio_attend_result_perform_enter_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="radio_attend_result_perform_enter_modal_title">Enter Radiology Result</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="radio_attend_result_perform_enter_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="table-responsive" id="radio_attend_result_perform_enter_table">
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" name="radio_attend_result_perform_enter_save_btn" id="radio_attend_result_perform_enter_save_btn" class="btn btn-primary">Save</button>
				    <button type="button" name="radio_attend_result_perform_enter_cancel_btn" id="radio_attend_result_perform_enter_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="radio_attend_result_view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="radio_attend_result_view_modal_title">Radiology Result</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="radio_attend_result_view_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="table-responsive" id="radio_attend_result_view_table">
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="button" name="radio_attend_result_view_cancel_btn" id="radio_attend_result_view_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="radio_attend_result_edit_modal" tabindex="-1" role="dialog" aria-labelledby="radio_attend_result_edit_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="radio_attend_result_edit_modal_title">Edit Radiology Result</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="radio_attend_result_edit_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="table-responsive" id="radio_attend_result_edit_table">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" name="radio_attend_result_update_btn" id="radio_attend_result_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" name="radio_attend_result_edit_cancel_btn" id="radio_attend_result_edit_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="radio_attend_report_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
					<h3 class="modal-title m-0 font-weight-bold text-primary" id="radio_attend_report_modal_title">Medical Report</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive no-padding">
		        	<table width="100%" cellpadding="3" cellspacing="3">
			            <tr>
			            	<td width="15%" valign="top" align="center">
				                <?php
								/*if(!$patientInfo->picture){
									$picture = "avatar.png";	
								}else{
									$picture = $patientInfo->picture;
								}*/
								?>
								<img src="/img/patients/patient_image.jpg" class="img-rounded" width="100" height="100">
			                </td>
			                <td>
			                	<table id="attend_patient_table" width="100%">
				                    <tr>
				                    	<td colspan="5"><h4><strong><?php echo $name;?></strong></h4></td>
				                    </tr>
				                    <tr>
				                    	<tr>
				                    	<td><small><u>Patient No:</u><?php echo $patient_id;?></small></td>
				                    	<td><small><u>Folder No:</u><?php echo $folderno;?></small></td>
				                    	<td><small><u>Date of Birth:</u></small></td>
				                    	<td><small><u>Age:</u><?php echo $age;?></small></td>
				                    	<td><small><u>Gender:</u><?php echo $gender?></small></td>
				                    </tr>
				                    <tr>
				                    	<td><small><u>Attendance ID:</u><?php echo $attend_id;?></small></td>
				            			<td><small><u>Date of Admission:</u><?php echo $dateofadmission_attd;?></small></td>
				            			<td><small><u>Date of Discharge:</u><?php echo $dateofdischarge_attd;?></small></td>
				            			<td><small><u>Type of Service:</u><?php echo $typeofservice_attd;?></small></td>
				            			<td><small><u>Clinic:</u><?php echo $clinic;?></small></td>
				            		</tr>
			                    </table>
			                </td>
			            </tr>
		            </table>
	        	</div>
				<div class="table-responsive" id="radio_attend_report_table">
				</div>
      		</div>
      		<div class="modal-footer">
      			<button type="submit" name="radio_report_print_btn" id="radio_report_print_btn" class="btn btn-primary">Print</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="radio_history_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title m-0 font-weight-bold text-primary" id="radio_history_modal_title">Radiology History</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="radio_history_list">
					
				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" name="radio_history_cancel_btn" id="radio_history_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-md" id="radio_edit_decline_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title m-0 font-weight-bold text-primary" id="radio_edit_decline_modal_title">Radiolody Edit Declined!</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="radio_edit_decline_info">
					
				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" name="radio_edit_decline_cancel_btn" id="radio_edit_decline_cancel_btn" class="btn btn-secondary" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-lg" id="radio_img_upload_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="radio_img_upload_modal_title">Upload Radiology Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="radio_img_upload_form" method="POST" action="radio_attend_img_upload.php" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="radio_list_file">Radiology Item</label>
									<input type="hidden" name="file_size" class="form-control" id="file_size" value="1000000">
									<input type="file" name="radio_list_file" class="form-control" id="radio_list_file">
									<input type="hidden" name="radio_list_id_img" class="form-control" id="radio_list_id_img">
									<input type="hidden" name="radio_id_img" class="form-control" id="radio_id_img">
									<input type="hidden" name="attend_id_img" class="form-control" id="attend_id_img">
									<input type="hidden" name="patient_id_img" class="form-control" id="patient_id_img">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="radio_img_comment">Comment</label>
								<textarea type="textarea" rows="2"  class="form-control" name="radio_img_comment" id="radio_img_comment" value=""></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="lab_list_file_save_update">
						<button type="submit" name="radio_list_img_save_btn" id="radio_list_img_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    <button type="submit" name="radio_list_img_update_btn" id="radio_list_img_update_btn" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div 
class="modal fade bd-example-modal-lg" 
id="radio_img_display_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="radio_img_display_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width:65%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="radio_img_display_modal_title">Display Radiology Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="radio_list_img_display" class="scroll-card-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div 
	class="modal fade bd-example-modal-xl" 
	id="radio_attend_delete_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="radio_attend_delete_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="radio_attend_delete_modal_title">Radiology Item Deletion</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="radio_attend_delete_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="radio_attend_delete_yes" name="radio_attend_delete_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="radio_attend_delete_no" name="radio_attend_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>

<div 
	class="modal fade bd-example-modal-xl" 
	id="radio_list_duplicate_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="radio_list_duplicate_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="radio_list_duplicate_modal_title">Radiology Item Duplication</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="radio_list_duplicate_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="radio_list_duplicate_yes" name="radio_list_duplicate_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="radio_list_duplicate_no" name="radio_list_duplicate_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/radio_request_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/validation_sheet_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/radio_search_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/discount_create_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>
<!--<script>
	$(document).ready(function()
	{
		$('#radio_list_search_modal_form').trigger('reset');
		$('#radio_list_search_modal').modal('show');
		$('#radio_list_search').focus();
	});
</script>-->