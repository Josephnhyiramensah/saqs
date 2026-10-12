<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');

	$query = "SELECT * FROM lab_list WHERE attend_id = '$attend_id' ORDER BY date DESC";
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
	<div class="col-md-4 mb-4">
	</div>
	<div class="col-md-2 mb-2">
		<a href="#" id="nav_new_lab_request">Lab Request</a>
	</div>
	<div class="col-md-2 mb-2">
		<a href="#" id="lab_attend_history_icon"><i class="fa fa-history fa-lg"></i> Past Labs</a>
	</div>
	<div class="col-md-2 mb-2">
		<a href="#" id="lab_attend_trend_icon">Labs Trend Analysis</a>
	</div>
	<div class="col-md-2 mb-2">
		<a href="#" id="lab_attend_report_icon" data-id="<?php echo $grand_total;?>"><i class="fa fa-file fa-lg"></i> Lab Report</a>
	</div>
</div>

<?php

  if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
  		$_SESSION['user_type'] == 'Super_User' OR 
		($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Lab_List'] == 'Yes')) 
  {
      echo '<div class="form-row">
		  <div class="col-md-8 mb-8">
			<form id="labs_attend_form" method="POST">	
			<div class="form-row">
				<div class="col-md-8 mb-8">
					<select class="form-control bg-light" name="composite_lab_select" id="composite_lab_select"> 
						<option value="0">Please Select Composite Lab</option>';
						$sql = "SELECT * FROM composite_labs";
						$result = mysqli_query($con, $sql);
						while($row = mysqli_fetch_array($result))
						{
							echo'<option value = "'.$row['composite_lab_id'].'">'.$row['composite_lab'].'</option>';
						};
					echo '</select>
				</div>
				<div class="col-md-4 mb-4">
					<button type="submit" name="composite_lab_enter_btn" id="composite_lab_enter_btn" class="btn btn-primary btn-block">Enter Composite Labs</button>
				</div>
			</div>
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
						
				echo'<label for="lab_id"><a href="#" id="btn_lab_live_search" data-id="'.$_SESSION['attend_id'].'"><h5><strong>Click to add Lab</strong></h5></a></label>
						<select class="form-control" name="lab_id" id="lab_id" hidden="true"> 
							<option value="0">Please Select</option>';
							
							$sql="SELECT * FROM lab ORDER BY lab ASC";
							$result=mysqli_query($con,$sql);
							while($row=mysqli_fetch_array($result))
							{
								echo'<option value = "'.$row['lab_id'].'">'.$row['lab'].'</option>';
							};
							
					echo'</select>
					<input type="hidden" name="lab_list_id" class="form-control" id="lab_list_id">
					<input type="hidden" name="lab_qty" class="form-control" id="lab_qty" value="1">
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
				echo'<label for="lab_date">Date</label>
					<input type="date" name="lab_date" class="form-control" id="lab_date" value="'.$date.'">
			</div>';

					if (
						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
						$_SESSION['user_type'] == 'Super_User' OR 
						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
					{
						echo'
							<div class="col-md-2 mb-2" hidden="true">
								<label for="lab_sponsor">Sponsor</label>
									<select class="form-control" name="lab_sponsor" id="lab_sponsor"> 
										<option value="0">Please Select</option>';
											$sponsor_option = set_sponsor_list();
											echo $sponsor_option;
									echo'</select>
							</div>
							<div class="col-md-2 mb-2" hidden="true">
								<label for="lab_amt_est">Estimated Lab Bill</label>
								<input type="hidden" name="lab_price_est" class="form-control" id="lab_price_est">
								<input type="text" name="lab_amt_est" class="form-control" id="lab_amt_est">
							</div>';
					};
					echo'</div>
					<div class="form-row" hidden="true">
						<div class="col-md-10 mb-10">
							<label for="lab_comment">Comment</label>
							<textarea type="textarea" rows="2"  class="form-control" name="lab_comment" id="lab_comment" value=""></textarea>
						</div>
						<div class="col-md-2 mb-2">
							<label for="lab_print_status">Print?</label>
							<select class="form-control" name="lab_print_status" id="lab_print_status"> 
								<option value="0">Please Select</option>
								<option value="Yes" selected="selected">Yes</option>
								<option value="No">No</option>
							</select>
						</div>
					</div>
					
					<hr class="d-none d-md-block" hidden="true">
					<div id="lab_save_update" hidden="true">
						<button type="submit" name="lab_list_save_btn" id="lab_list_save_btn" class="btn btn-primary">Save</button>
					</div>
				</form>
		</div>
		<div class="col-md-4 mb-4">
			<div class="table-responsive scroll-card-body" id="past_labs_table">
				<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th class="action-td">Date</th>
							<th class="action-td">Past Lab Test</th>
							<th class="action-td">Action</th>
						</tr>
					</thead>';
					
					$query_past = "SELECT * FROM attendance WHERE patient_id='$patient_id' AND 
					attend_id != '$attend_id' ORDER BY date_admit DESC";
					$query_run_past = mysqli_query($con, $query_past);
					if (mysqli_num_rows($query_run_past) > 0)
					{
						while($attend_list_past = mysqli_fetch_assoc($query_run_past))
						{
							$attend_id_past=$attend_list_past['attend_id'];
							$query_past = "SELECT * FROM lab_list WHERE attend_id='$attend_id_past'";
							$query_run_ll_past = mysqli_query($con, $query_past);
							if (mysqli_num_rows($query_run_ll_past) > 0)
							{
								while($lab_list_past = mysqli_fetch_assoc($query_run_ll_past))
								{
									$lab_id_past = $lab_list_past['lab_id'];
									$lab_list_id_past = $lab_list_past['lab_list_id'];
									$query_past = "SELECT * FROM lab WHERE lab_id='$lab_id_past'";
									$query_run_lab_past = mysqli_query($con, $query_past);
									$lab_past = mysqli_fetch_assoc($query_run_lab_past);
									echo'<tr>
										<td class="action-td"><small>'.$lab_list_past['date'].'</small></td>
										<td><small>'.$lab_past['lab'].'</small></td>
										<td>
											<a href="#" id="btn_past_lab_view" 
												data-id="'.$lab_list_past['lab_list_id'].'"
												data-id1="'.$lab_list_past['lab_id'].'"
												><small>View</small>
											</a> | 
											<a href="#" id="btn_past_lab_request" 
												data-id="'.$lab_list_past['lab_id'].'"
												><small>Request</small>
											</a>
										</td>
									</tr>';
								};
							};
						};
					};
				echo'</table>
			</div>
		</div>
	</div>
<hr class="d-none d-md-block">';
};
?>
<div class="table-responsive" id="attend_lab_table">
    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="action-td">Date</th>
                <th class="action-td">Lab Test</th>
            <?php
                if (
						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
						$_SESSION['user_type'] == 'Super_User' OR 
						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
					{
                    echo'
		                <th class="action-td">Amt-Estimate</th>
		                <th class="action-td">Amt-Cash</th>
		                <th class="action-td">Amt-Disc.</th>
		                <th class="action-td">Amt-Prvt</th>
						<th class="action-td">Bill?</th>';
		            };
		    ?>
						<th class="action-td">Print?</th>
		                <th class="action-td">Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">
            <?php
                if (mysqli_num_rows($query_run) > 0)
                {
                	$total_est=0;
                	$total_cash=0;
                	$total_disc=0;
                	$total_prvt=0;
                	$total_nhis=0;
                	//$counter=0;
                    while($row = mysqli_fetch_assoc($query_run))
                    {
						//$counter=++$counter;
                    	$lab_id = $row['lab_id'];
                    	$query_lab = "SELECT lab FROM lab WHERE lab_id='$lab_id'";
						$query_run_lab = mysqli_query($con, $query_lab);
						$row_lab=mysqli_fetch_assoc($query_run_lab);

						$lab_list_id = $row['lab_list_id'];
                    	$query_disc = "SELECT SUM(amount) AS amount FROM discount WHERE lab_list_id='$lab_list_id'";
						$query_run_disc = mysqli_query($con, $query_disc);
						$row_disc=mysqli_fetch_assoc($query_run_disc);

						$amt_est = $row['amount_est'];
						$amt_cash = $row['amount_cash'];
						if (isset($row_disc)) {$amt_disc = $row_disc['amount'];} else {$amt_disc =0;};
						$amt_prvt = $row['amount_prvt'];
						$amt_nhis = $row['amount_nhis'];
	                    $amt_est = number_format($amt_est, 2, '.', ',');
	                    $amt_cash = number_format($amt_cash, 2, '.', ',');
	                    $amt_disc = number_format($amt_disc, 2, '.', ',');
	                    $amt_prvt = number_format($amt_prvt, 2, '.', ',');
	                    $amt_nhis = number_format($amt_nhis, 2, '.', ',');
            			?>

		                <tr id="<?php echo $lab_list_id;?>">
		                    <td class="action-td">
								<a href="#" id="btn_lab_doc_view" 
									data-id="<?php echo $row['lab_list_id'];?>"
									data-id1="<?php echo $row['lab_id'];?>" 
								><?php echo $row['date'];?></a>
							</td>
		                	<td><a href="#" id="btn_lab_doc_view" 
									data-id="<?php echo $row['lab_list_id'];?>"
									data-id1="<?php echo $row['lab_id'];?>" 
								><?php echo $row_lab['lab'];?></a>
							</td>

		    			<?php

		                if (
								$_SESSION['user_type'] == 'Ultra_Super_User' OR 
								$_SESSION['user_type'] == 'Super_User' OR 
								($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
							{
			                    echo'<td class="amt-td">'.$amt_est.'</td>
			                    <td class="amt-td">'.$amt_cash.'</td>
			                    <td class="amt-td">'.$amt_disc.'</td>
			                    <td class="amt-td">'.$amt_prvt.'</td>';
							};

							if (
									$_SESSION['user_type'] == 'Ultra_Super_User' OR 
									$_SESSION['user_type'] == 'Super_User' OR 
									($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Discount'] == 'Yes')) 
							{
								$perform_status = $row['bill'];
								echo '<td class="action-td">
										<select class="form-control lab_bill text-center" name="lab_bill" id="lab_bill'.$lab_list_id.'"
											data-id="'.$row['lab_list_id'].'"
											data-id1="'.$attend_id.'" 
											data-id2="'.$patient_id.'" 
											data-id3="'.$row['amount_cash'].'" 
											data-id4="'.$_SESSION['name'].'" 
											data-id5="lab_bill" 
										>';
										if($perform_status == '')
										{
											echo'<option value="0">Please Select</option>
											<option value="Yes">Yes</option>
											<option value="No" selected="selected">No</option>';
										}
										elseif($perform_status == 'Yes')
										{
											echo'<option value="0">Please Select</option>
											<option value="Yes" selected="selected">Yes</option>
											<option value="No">No</option>';
										}
										elseif($perform_status == 'No')
										{
											echo'<option value="0">Please Select</option>
											<option value="Yes">Yes</option>
											<option value="No" selected="selected">No</option>';
										};
									echo '</select>
									</td>';
		                    };
								$print_status = $row['print_status'];
		                    	echo '<td class="action-td">
										<select class="form-control lab_print text-center" name="lab_print" id="lab_print'.$lab_list_id.'">';
										if($print_status == '')
										{
											echo'<option value="0">Please Select</option>
											<option value="Yes">Yes</option>
											<option value="No" selected="selected">No</option>';
										}
										elseif($print_status == 'Yes')
										{
											echo'<option value="0">Please Select</option>
											<option value="Yes" selected="selected">Yes</option>
											<option value="No">No</option>';
										}
										elseif($print_status == 'No')
										{
											echo'<option value="0">Please Select</option>
											<option value="Yes">Yes</option>
											<option value="No" selected="selected">No</option>';
										};
								echo '</select>
								</td>
								<td class="action-td">';
											
								if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Validate_Bill'] == 'Yes')) 
								{
									echo '<a href="#" 
										id="btn_validate_bill" 
										data-item_id="'.$row['lab_id'].'"
										data-item_list_id="'.$row['lab_list_id'].'"
										data-sponsor_id="'.$row['ledger_id'].'"
										data-cash_price="'.$row['price_cash'].'"
										data-private_price="'.$row['price_prvt'].'"
										data-item_type="lab"
										data-item_name="'.$row_lab['lab'].'"
										>Validate
									</a>';
								};
											
		                    		$total_est+=$row['amount_est'];
		                    		$total_cash+=$row['amount_cash'];
		                    		if(isset($row_disc)) {$total_disc+=$row_disc['amount'];}else{$total_disc+=0;};
				                	$total_prvt+=$row['amount_prvt'];
				                	$total_nhis+=$row['amount_nhis'];
		                    		$lab_list_id = $row['lab_list_id'];

									$query_receipt_item = "SELECT * FROM `receipt_items` WHERE `attend_id` = '$attend_id' AND `category_id` = 3 
									AND `item_list_id`='$lab_list_id'";
									$query_run_receipt_item = mysqli_query($con, $query_receipt_item);
									$rows_receipt_item_count = mysqli_num_rows($query_run_receipt_item);

		                    		$query_img = "SELECT lab_img_id FROM lab_img WHERE lab_list_id='$lab_list_id'";
									$query_run_img = mysqli_query($con, $query_img);
									$row_imgs=mysqli_num_rows($query_run_img);

		                    		$query_param = "SELECT lab_param_list_id FROM lab_param_list WHERE lab_id='$lab_id' AND attend_id='$attend_id' AND lab_list_id='$lab_list_id'";
									$query_run_param = mysqli_query($con, $query_param);
									if (mysqli_num_rows($query_run_param) > 0)
	                				{
	                					$row_param = mysqli_fetch_assoc($query_run_param);
	                					if (
	                						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
	                						$_SESSION['user_type'] == 'Super_User' OR 
	                						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Lab_Result'] == 'Yes')) 
		        							{
					                			echo ' | <a href="#" id="btn_lab_perform_edit" 
					                				data-id="'.$row['lab_list_id'].'"
					                				data-id1="'.$row['lab_id'].'" 
					                				class="data-toggle="tooltip" data-placement="left" title="Edit Lab Result""
					                			>
					                				Edit Result
					                			</a>';
					                		};

			                			if (
	                						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
	                						$_SESSION['user_type'] == 'Super_User' OR 
	                						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Lab_Result'] == 'Yes')) 
		        							{
												//if((($rows_receipt_item_count > 0 || ($amt_cash - $amt_disc)==0) && $_SESSION['typeofservice_attd'] !=2) || $_SESSION['typeofservice_attd'] ==2)
												//{
													echo ' | <a href="#" id="btn_lab_result_view" 
															data-id="'.$row['lab_list_id'].'"
															data-id1="'.$row['lab_id'].'" 
															class="data-toggle="tooltip" data-placement="left" title="View Lab Result""
														>
															View Result
														</a>';
												//};
						                	};

			                			if (
	                						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
	                						$_SESSION['user_type'] == 'Super_User' OR 
	                						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Upload_Lab_Result_Image'] == 'Yes')) 
		        							{
												if((($rows_receipt_item_count > 0 || ($amt_cash - $amt_disc)==0) && $_SESSION['typeofservice_attd'] !=2) || $_SESSION['typeofservice_attd'] ==2)
												{
													echo ' | <a href="#" id="btn_lab_img_upload" data-id6="'.$row['lab_list_id'].'"
														data-id7="'.$row['lab_id'].'"
														class="data-toggle="tooltip" data-placement="left" title="Upload Lab Result Image"">
														Upload Image
													</a>';
												};
							                };
	                		
			                			if ($row_imgs > 0)
										{
											if (
												$_SESSION['user_type'] == 'Ultra_Super_User' OR 
												$_SESSION['user_type'] == 'Super_User' OR 
												($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Uploaded_Lab_Result_Image'] == 'Yes')) 
											{
													echo ' | 
													<a href="#" id="btn_lab_img_view" 
													data-id2="'.$row['lab_list_id'].'"
													data-id3="'.$row['lab_id'].'"
													class="data-toggle="tooltip" data-placement="left" title="View Uploaded Lab Result Image"">
													View Image
													</a>';
											};
										};
	                				}
					                else
					                {
										
										if ($_SESSION['user_id'] == $row['user_id']) 
										{
											if($row['date'] == $date_today)
											{
												
												if (
													$_SESSION['user_type'] == 'Ultra_Super_User' OR 
													$_SESSION['user_type'] == 'Super_User' OR 
													($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Lab_List'] == 'Yes')) 
												{
													echo ' | <a href="#" id="btn_lab_edit" 
															data-id12="'.$row['lab_list_id'].'"
															data-id13="'.$row['lab_id'].'" 
														>Edit Lab Item</a>';
												};
											};
										};

					         			if (
	                						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
	                						$_SESSION['user_type'] == 'Super_User' OR 
	                						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Enter_Lab_Result_Internal'] == 'Yes')) 
		        							{
												if((($rows_receipt_item_count > 0 || ($amt_cash - $amt_disc)==0) && $_SESSION['typeofservice_attd'] !=2) || $_SESSION['typeofservice_attd'] ==2)
												{
													echo ' | <a href="#" id="btn_lab_perform_enter" 
														data-id="'.$row['ledger_id'].'"
														data-id4="'.$row['lab_list_id'].'"
														data-id5="'.$row['lab_id'].'" 
														class="data-toggle="tooltip" data-placement="left" title="Enter Lab Result"">
														Enter Result
													</a>';
												};
					                		};

			                			if (
	                						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
	                						$_SESSION['user_type'] == 'Super_User' OR 
	                						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Enter_Lab_Result_External'] == 'Yes')) 
		        							{
												echo' | <a href="#" id="btn_lab_result_enter" 
														data-id4="'.$row['lab_list_id'].'"
														data-id5="'.$row['lab_id'].'" 
														class="data-toggle="tooltip" data-placement="left" title="Enter External Lab Result"">
														Enter Ext. Result
													</a>';
									         };

							         	if (
	                						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
	                						$_SESSION['user_type'] == 'Super_User' OR 
	                						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Upload_Lab_Result_Image'] == 'Yes')) 
		        							{
												if((($rows_receipt_item_count > 0 || ($amt_cash - $amt_disc)==0) && $_SESSION['typeofservice_attd'] !=2) || $_SESSION['typeofservice_attd'] ==2)
												{
													echo' | <a href="#" id="btn_lab_img_upload" data-id6="'.$row['lab_list_id'].'"
															data-id7="'.$row['lab_id'].'"
															class="data-toggle="tooltip" data-placement="left" title="Upload Lab Result Image"">
															Upload Image
														</a>';
												};
					                		};

			                			if ($row_imgs > 0)
			                				{
	                				 			if (
			                						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
			                						$_SESSION['user_type'] == 'Super_User' OR 
			                						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Uploaded_Lab_Result_Image'] == 'Yes')) 
			        							{
														echo' | 
															<a href="#" id="btn_lab_img_view" data-id2="'.$row['lab_list_id'].'"
															data-id3="'.$row['lab_id'].'"
															class="data-toggle="tooltip" data-placement="left" title="View Uploaded Lab Result Image"">
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
											echo' |
												<a href="#" id="btn_discount_lab_attend"
													data-id="'.$row['lab_list_id'].'"
						                			data-id1="'.$attend_id.'" 
						                			data-id2="'.$patient_id.'" 
						                			data-id3="'.$row['amount_cash'].'" 
						                			data-id4="'.$_SESSION['name'].'" 
													data-id5="btn_discount_lab_attend" 
						                			class="data-toggle="tooltip" data-placement="left" title="Discount Lab Test""
												>
													Disc.
												</a>';
										};
									
										/*if ($_SESSION['user_id'] == $row['user_id'] OR $_SESSION['user_type'] == 'Ultra_Super_User') 
										{
											if($row['date'] == $date_today)
											{*/
												if (
													$_SESSION['user_type'] == 'Ultra_Super_User' OR 
													$_SESSION['user_type'] == 'Super_User' OR 
													$_SESSION['user_type_id'] == 3 OR 
													($_SESSION['user_type_id'] != 3 AND $_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Lab_List'] == 'Yes' AND $row['date'] == $date_today)) 
												{
													echo' |
													<a href="#" id="btn_delete_lab_attend" 
														data-id8="'.$row['lab_list_id'].'"
														data-id9="'.$row['lab_id'].'" 
														class="data-toggle="tooltip" data-placement="left" title="Delete Lab Test""
													>
														Delete
													</a>';
												};
											//};
										//};
			
		                    echo'</td>
		                </tr>';
                    }
                    $total_est = number_format($total_est, 2, '.', ',');
                    $total_cash = number_format($total_cash, 2, '.', ',');
                    $total_disc = number_format($total_disc, 2, '.', ',');
                    $total_prvt = number_format($total_prvt, 2, '.', ',');
                    $total_nhis = number_format($total_nhis, 2, '.', ',');
            
	                if (
						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
						$_SESSION['user_type'] == 'Super_User' OR 
						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
						{
			                echo'<tr>
			                	<td colspan="2">TOTAL</td>
			                	<td class="amt-td">'.$total_est.'</td>
			                	<td class="amt-td">'.$total_cash.'</td>
			                	<td class="amt-td">'.$total_disc.'</td>
			                	<td class="amt-td">'.$total_prvt.'</td>
			                	<td class="amt-td">'.$total_nhis.'</td>
			                	<td colspan="2"></td>
			                </tr>';
			            };
                };
            ?>
        </tbody>
    </table>
    <input type="hidden" name="lab_cash_ledger" class="form-control" id="lab_cash_ledger">
	<input type="hidden" name="lab_cash_total" class="form-control" id="lab_cash_total" value="<?php if (isset($amt_cash)){echo $amt_cash;}?>">
	<input type="hidden" name="lab_prvt_ledger" class="form-control" id="lab_prvt_ledger">
	<input type="hidden" name="lab_prvt_total" class="form-control" id="lab_prvt_total" value="<?php if (isset($amt_prvt)){ echo $amt_prvt;}?>">
	<input type="hidden" name="lab_nhis_ledger" class="form-control" id="lab_nhis_ledger">
	<input type="hidden" name="lab_nhis_total" class="form-control" id="lab_nhis_total" value="<?php if (isset($amt_nhis)){ echo $amt_nhis;}?>">
</div>

<div class="modal fade bd-example-modal-xl" id="labs_attend_result_enter_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="labs_attend_result_enter_modal_title">Enter Lab Test Result</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="labs_attend_result_enter_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="table-responsive" id="labs_attend_result_enter_table">
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" name="labs_attend_result_enter_save_btn" id="labs_attend_result_enter_save_btn" class="btn btn-primary">Save</button>
				    <button type="button" name="labs_attend_result_enter_cancel_btn" id="labs_attend_result_enter_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="labs_attend_result_perform_enter_modal" tabindex="-1" role="dialog" aria-labelledby="labs_attend_result_perform_enter_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="labs_attend_result_perform_enter_modal_title">Enter Lab Test Result</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="labs_attend_result_perform_enter_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="table-responsive" id="labs_attend_result_perform_enter_table">
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" name="labs_attend_result_perform_enter_save_btn" id="labs_attend_result_perform_enter_save_btn" class="btn btn-primary">Save</button>
				    <button type="button" name="labs_attend_result_perform_enter_cancel_btn" id="labs_attend_result_perform_enter_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="labs_attend_result_view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="labs_attend_result_view_modal_title">Lab Test Result</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="labs_attend_result_view_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="table-responsive" id="labs_attend_result_view_table">
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="button" name="labs_attend_result_view_cancel_btn" id="labs_attend_result_view_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="labs_attend_doctors_view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="labs_attend_doctors_view_modal_title">Lab Test Result - Doctor's View</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="labs_attend_doctors_view_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="table-responsive" id="labs_attend_doctors_view_table">
						</div>
						<div id="lab_list_img_display_doctors" class="scroll-card-body">
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="button" name="labs_attend_doctors_view_cancel_btn" id="labs_attend_doctors_view_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="labs_attend_result_edit_modal" tabindex="-1" role="dialog" aria-labelledby="labs_attend_result_edit_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="labs_attend_result_edit_modal_title">Edit Lab Test Result</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="labs_attend_result_edit_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="table-responsive" id="labs_attend_result_edit_table">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" name="labs_attend_result_update_btn" id="labs_attend_result_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" name="labs_attend_result_edit_cancel_btn" id="labs_attend_result_edit_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="labs_attend_report_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
					<h3 class="modal-title m-0 font-weight-bold text-primary" id="labs_attend_report_modal_title">Medical Laboratory Report</h3>
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
				<div class="table-responsive" id="labs_attend_report_table">
				</div>
      		</div>
      		<div class="modal-footer">
      			<button type="submit" name="lab_report_print_btn" id="lab_report_print_btn" class="btn btn-primary">Print</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="lab_history_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title m-0 font-weight-bold text-primary" id="lab_history_modal_title">Lab History</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="lab_history_list">
					
				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" name="lab_history_cancel_btn" id="lab_history_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-md" id="lab_edit_decline_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title m-0 font-weight-bold text-primary" id="lab_edit_decline_modal_title">Lab Edit Declined!</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="lab_edit_decline_info">
					
				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" name="lab_edit_decline_cancel_btn" id="lab_edit_decline_cancel_btn" class="btn btn-secondary" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-lg" id="labs_img_upload_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="labs_img_upload_modal_title">Upload Lab Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="labs_img_upload_form" method="POST" action="labs_attend_img_upload.php" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="lab_id">Lab Test</label>
									<input type="hidden" name="file_size" class="form-control" id="file_size" value="1000000">
									<input type="file" name="lab_list_file" class="form-control" id="lab_list_file">
									<input type="hidden" name="lab_list_id_img" class="form-control" id="lab_list_id_img">
									<input type="hidden" name="lab_id_img" class="form-control" id="lab_id_img">
									<input type="hidden" name="attend_id_img" class="form-control" id="attend_id_img">
									<input type="hidden" name="patient_id_img" class="form-control" id="patient_id_img">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="lab_img_comment">Comment</label>
								<textarea type="textarea" rows="2"  class="form-control" name="lab_img_comment" id="lab_img_comment" value=""></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="lab_list_file_save_update">
						<button type="submit" name="lab_list_img_save_btn" id="lab_list_img_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    <button type="submit" name="lab_list_img_update_btn" id="lab_list_img_update_btn" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-lg" id="labs_img_display_modal" tabindex="-1" role="dialog" aria-labelledby="labs_img_display_modal" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="max-width: 70%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="labs_img_display_modal_title">Display Lab Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="lab_list_img_display" class="scroll-card-img text-center">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<div 
	class="modal fade bd-example-modal-xl" 
	id="lab_attend_delete_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="lab_attend_delete_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="lab_attend_delete_modal_title">Laboratory Test Deletion</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="lab_attend_delete_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="lab_attend_delete_yes" name="lab_attend_delete_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="lab_attend_delete_no" name="lab_attend_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<div 
	class="modal fade bd-example-modal-xl" 
	id="lab_list_duplicate_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="lab_list_duplicate_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="lab_list_duplicate_modal_title">Lab Test Duplication</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="lab_list_duplicate_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="lab_list_duplicate_yes" name="lab_list_duplicate_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="lab_list_duplicate_no" name="lab_list_duplicate_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/lab_search_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/lab_request_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/validation_sheet_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/discount_create_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>
<!--<script>
	$(document).ready(function()
	{
		$('#lab_list_search_modal_form').trigger('reset');
		$('#lab_list_search_modal').modal('show');
		$('#lab_list_search').focus();
	});
</script>-->