<?php
	include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
    $query = "SELECT * FROM surgery_list WHERE attend_id = '$attend_id' ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);

	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
?>
<ul class="nav nav-tabs">
	<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#surgery_current">Surgery/Procedure</a></li>
	<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#surgery_history" id="surgery_history_icon">Past Surgeries/Procedures</a></li>
</ul>
<div class="tab-content">
	<div id="surgery_current" class="tab-pane fade show active">
<?php
    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Surgery_List'] == 'Yes')) 
    {
        echo '<form id="surgery_attend_form" method="POST">
		<div class="form-row">
			<div class="col-md-5 mb-5">
				<label for="attend_surgery_id">Procedure/Surgery Description</label>
				<select class="form-control" name="attend_surgery_id" id="attend_surgery_id"> 
		    		<option value="0">Please Select</option>';
			        
			        	$sql="SELECT * FROM surgery ORDER BY surgery ASC";
						$result=mysqli_query($con,$sql);
			            while($row=mysqli_fetch_array($result))
			            {
				            echo '<option value = "'.$row['surgery_id'].'" >
				                '.$row['surgery'].'
				            </option>';
			            }
			        
		    	echo '</select>
			</div>
			<div class="col-md-2 mb-2">
				<label for="surgery_date">Date</label>
				<input type="date" class="form-control" name="surgery_date" id="surgery_date" value="'.$date.'">
			</div>';
			if (
				$_SESSION['user_type'] == 'Ultra_Super_User' OR 
				$_SESSION['user_type'] == 'Super_User' OR 
				($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
				{
		            echo'<div class="col-md-3 mb-3">
						<label for="surgery_sponsor">Sponsor</label>
							<select class="form-control" name="surgery_sponsor" id="surgery_sponsor"> 
						    	<option value="0">Please Select</option>';
						        	$sponsor_option = set_sponsor_list();
						        	echo $sponsor_option;
						    echo '</select>
					</div>
					<div class="col-md-2 mb-2">
						<label for="procamt">Amount</label>
						<input type="text" class="form-control" name="proc_amt_cash" id="proc_amt_cash">
						<input type="hidden" class="form-control" name="proc_amt_prvt" id="proc_amt_prvt">
						<input type="hidden" class="form-control" name="proc_amt_nhis" id="proc_amt_nhis">
						<input type="hidden" class="form-control" name="proc_price_cash" id="proc_price_cash">
						<input type="hidden" class="form-control" name="proc_price_prvt" id="proc_price_prvt">
						<input type="hidden" class="form-control" name="proc_price_nhis" id="proc_price_nhis">
						<input type="hidden" class="form-control" name="procqty" id="procqty" value="1">
					</div>';
				};
		echo '</div>
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<label for="surgery_comment">Comment</label>
				<textarea type="textarea" rows="2"  class="form-control" name="surgery_comment" id="surgery_comment" value=""></textarea>
					<input type="hidden" name="surgery_list_id" class="form-control" id="surgery_list_id" value="">
			</div>
		</div>
		<hr class="d-none d-md-block">
		<div id="surgery_save_update">
			<button id="surgery_attend_save_btn" class="btn btn-primary">Save</button>
		</div>
			</form>
			<hr class="d-none d-md-block">';
	};
?>

		<div class="table-responsive" id="attend_surgery_table">
		    <?php 
				echo'<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Date</th>
						<th>Procedure/Surgery</th>';
						if (
							$_SESSION['user_type'] == 'Ultra_Super_User' OR 
							$_SESSION['user_type'] == 'Super_User' OR 
							($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
							{
								echo'
									<th>Sponsor</th>
									<th>Cash</th>
									<th>Disc.</th>
									<th>Private</th>
									<th>NHIS</th>
									<th>G-DRG</th>';
							};
							echo'<th>Action</th>
					</tr>
				</thead>
				<tbody class="pv-table-body">';
	$query = "SELECT * FROM surgery_list WHERE attend_id='$attend_id' ORDER BY date DESC";
	$result = mysqli_query($con,$query);
	if (mysqli_num_rows($result) > 0)
	{
		$total_cash=0;
		$total_disc=0;
		$total_prvt=0;
		$total_nhis=0;
		while($row=mysqli_fetch_assoc($result))
		{
			$surgery_id = $row['surgery_id'];
			$surgery_list_id = $row['surgery_list_id'];
			$ledger_id = $row['ledger_id'];

			$query = "SELECT * FROM surgery WHERE surgery_id='$surgery_id'";
			$query_run_surgery = mysqli_query($con, $query);
			$row_surgery = mysqli_fetch_assoc($query_run_surgery);

			$nhis_id = $row['nhis_id'];
			$query_gdrg = "SELECT * FROM nhis WHERE nhis_id ='$nhis_id'";
			$result_gdrg = mysqli_query($con,$query_gdrg);
			$row_gdrg = mysqli_fetch_array($result_gdrg);
			if($age < 12)
			{
				if(isset($row_gdrg['gdrg_child']))
				{$proc_gdrg = $row_gdrg['gdrg_child'];}else
				{$proc_gdrg = 'N/A';};
			}
			else
			{
				if(isset($row_gdrg['gdrg_adult']))
				{$proc_gdrg = $row_gdrg['gdrg_adult'];}else
				{$proc_gdrg = 'N/A';};
			};

			$query = "SELECT * FROM ledgers WHERE ledger_id ='$ledger_id'";
			$result_ledger = mysqli_query($con,$query);
			$ledger_rows =mysqli_fetch_assoc($result_ledger);

			$query = "SELECT * FROM operation_notes WHERE surgery_list_id='$surgery_list_id'";
			$result_surgery_list = mysqli_query($con,$query);
			$op_note_rows = mysqli_num_rows($result_surgery_list);

			$query = "SELECT * FROM anesthesia WHERE surgery_list_id='$surgery_list_id'";
			$result_anest_list = mysqli_query($con,$query);
			$op_anest_rows = mysqli_num_rows($result_anest_list);

			$query_disc = "SELECT SUM(amount) AS amount FROM discount WHERE surgery_list_id='$surgery_list_id'";
			$result_disc = mysqli_query($con,$query_disc);
			$rows_disc = mysqli_fetch_assoc($result_disc);
			if(isset($rows_disc))
			{
				$amt_disc = $rows_disc['amount'];
			}
			else
			{
				$amt_disc = 0;
			};

			echo'<tr>
						<td>'.$row['date'].'</td>
						<td>'.$row_surgery['surgery'].'</td>';
						if (
							$_SESSION['user_type'] == 'Ultra_Super_User' OR 
							$_SESSION['user_type'] == 'Super_User' OR 
							($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
							{
								echo'<td>'.$ledger_rows['ledger_desc'].'</td>
								<td>'.$row['amount_cash'].'</td>
								<td>'.$amt_disc.'</td>
								<td>'.$row['amount_prvt'].'</td>
								<td>'.$row['amount_nhis'].'</td>
								<td>'.$proc_gdrg.'</td>';
							};
							echo'<td>';
						$total_cash+=$row['amount_cash'];
						$total_disc+=$amt_disc;
						$total_prvt+=$row['amount_prvt'];
						$total_nhis+=$row['amount_nhis'];
						
						
                    	if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Validate_Bill'] == 'Yes')) 
						{
						  	echo '<a href="#" 
								id="btn_validate_bill" 
								data-item_id="'.$row['surgery_id'].'"
								data-item_list_id="'.$row['surgery_list_id'].'"
								data-sponsor_id="'.$row['ledger_id'].'"
								data-cash_price="'.$row['amount_cash'].'"
								data-private_price="'.$row['amount_prvt'].'"
								data-item_type="surgery"
								data-item_name="'.$row_surgery['surgery'].'"
								>Validate
							</a>';
                    	};
						if (/*$_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND*/ $_SESSION['user_id'] == $row['user_id']) 
						{
							if($row['date'] == $date_today)
							{
								if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
									$_SESSION['user_type'] == 'Super_User' OR 
									($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Surgery_List'] == 'Yes')) 
								{
									echo' | <a href="#" 
											id="btn_edit_surgery_attend" 
											data-id1="'.$row['surgery_list_id'].'">
											Edit Surgery
										</a>';
								};
							};
						};

						if ($op_anest_rows > 0) {
							if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
							$_SESSION['user_type'] == 'Super_User' OR 
							($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Surgery_Anestesia'] == 'Yes')) 
							{
								echo' | <a href="#" 
										id="btn_edit_anesthesia" 
										data-id1="'.$row['surgery_list_id'].'" 
										data-id2="'.$row['surgery_id'].'" 
										class="data-toggle="tooltip" 
										data-placement="left" 
										title="Edit Anesthesia"">
										Edit Anesthesia
									</a>';
							};
						} 
						else 
						{
							if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
								$_SESSION['user_type'] == 'Super_User' OR 
								($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Surgery_Anestesia'] == 'Yes')) 
							{
								echo' | <a href="#" 
											id="btn_enter_anesthesia" 
											data-id1="'.$row['surgery_list_id'].'" 
											data-id2="'.$row['surgery_id'].'" 
											class="data-toggle="tooltip" 
											data-placement="left" 
											title="Enter Anesthesia"">
											Enter Anesthesia
										</a>';
							};
						};	
						if ($op_note_rows > 0) {
							if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
								$_SESSION['user_type'] == 'Super_User' OR 
								($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Surgery_Opt_Notes'] == 'Yes')) 
							{
								echo' | <a href="#" 
										id="btn_view_opt_notes" 
										data-id1="'.$row['surgery_list_id'].'" 
										data-id2="'.$row['surgery_id'].'" 
										class="data-toggle="tooltip" 
										data-placement="right" 
										title="View Operation Notes"">
										View Operation Notes
									</a>';
							};
						} 
						else 
						{
							if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
								$_SESSION['user_type'] == 'Super_User' OR 
								($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Surgery_Opt_Notes'] == 'Yes')) 
							{
								echo' | <a href="#" 
									id="btn_enter_opt_notes" 
									data-id1="'.$row['surgery_list_id'].'" 
									data-id2="'.$row['surgery_id'].'" 
									class="data-toggle="tooltip" 
									data-placement="right" 
									title="Enter Operation Notes"">
									Enter Operation Notes
								</a>';
							};
						};

						if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
							$_SESSION['user_type'] == 'Super_User' OR 
							($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Surgery_Consent_Form'] == 'Yes')) 
						{
							echo' | <a href="#" id="consent_form_icon" 
								data-id1="'.$row['surgery_list_id'].'" 
								data-id2="'.$row['surgery_id'].'" 
								class="data-toggle="tooltip" data-placement="right" title="Consemt Form"">
								Consemt Form
							</a>
							| <a href="#" id="consent_form_pdf_icon" 
								data-id1="'.$row['surgery_list_id'].'" 
								data-id2="'.$row['surgery_id'].'" 
								data-id3="'.$_SESSION['patient_id'].'" 
								data-id3="'.$attend_id.'" 
								class="data-toggle="tooltip" 
								data-placement="right" 
								title="Print Consemt Form PDF"">
								Consemt Form PDF
							</a>';
						};

							if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Discount'] == 'Yes')) 
						{
							echo' | <a href="#" id="btn_discount_surgery_attend" 
								data-id="'.$attend_id.'" 
								data-id1="'.$_SESSION['patient_id'].'" 
								data-id2="'.$row['surgery_list_id'].'" 
								data-id3="'.$_SESSION['name'].'"
								data-id4="'.$row['amount_cash'].'"
								data-id5="'.$amt_disc.'"
								>Disc
							</a>';
						};
						
						/*if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_id'] == $row['user_id']) 
						{
							if($row['date'] == $date_today)
							{*/
								if ($_SESSION['user_type'] == 'Ultra_Super_User' OR 
									$_SESSION['user_type'] == 'Super_User' OR 
									$_SESSION['user_type_id'] == 3 OR 
									($_SESSION['user_type_id'] != 3 AND $_SESSION['user_type'] == 'Normal_User' AND 
									$_SESSION['Delete_Surgery_List'] == 'Yes' AND $row['date'] == $date_today AND $_SESSION['user_id'] == $row['user_id'])) 
								{
									echo' | <a href="#" 
										id="btn_delete_surgery_attend" 
										data-id2="'.$row['surgery_list_id'].'">Delete</a>';
								};
							//};
						//};

					echo'</td>
					</tr>';
		}
	
			if (
				$_SESSION['user_type'] == 'Ultra_Super_User' OR 
				$_SESSION['user_type'] == 'Super_User' OR 
				($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
				{
					echo'<tr>
							<td colspan="3">TOTAL</td>
							<td>'.$total_cash.'</td>
							<td>'.$total_disc.'</td>
							<td>'.$total_prvt.'</td>
							<td>'.$total_nhis.'</td>
							<td></td>
							<td></td>
						</tr>';
				};
	};
		   echo'</tbody>
			</table>';
			?>
		</div>
	</div>
	<div id="surgery_history" class="tab-pane fade">
		<div class="table-responsive" id="attend_surgery_history_table">
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="consent_form_pdf_modal" tabindex="-1" role="dialog" aria-labelledby="consent_form_pdf_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="consent_form_pdf_modal_title">Consent Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="surgery_consent_form_pdf" method="POST" action="surgery_consent_form_pdf.php" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-4 mb-4">
								<label for="consent_pdf_doctor">Doctor</label>
								<input type="text" name="consent_pdf_doctor" class="form-control" id="consent_pdf_doctor">
							</div>
							<div class="col-md-4 mb-4">
								<label for="consent_pdf_relative">Relative</label>
								<input type="text" name="consent_pdf_relative" class="form-control" id="consent_pdf_relative">
							</div>
							<div class="col-md-4 mb-4">
								<label for="consent_pdf_language">Language</label>
								<input type="text" name="consent_pdf_language" class="form-control" id="consent_pdf_language">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="consent_pdf_comment">Comment</label>
								<textarea type="textarea" rows="2"  class="form-control" name="consent_pdf_comment" id="consent_pdf_comment" value=""></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="consent_pdf_save_update">
						<button type="submit" name="consent_pdf_save_btn" id="consent_pdf_save_btn" class="btn btn-primary">Save</button>
						<button type="button" name="consent_pdf_cancel_btn" id="consent_pdf_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-xl" id="consent_form_modal" tabindex="-1" role="dialog" aria-labelledby="consent_form_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="consent_form_modal_title">Consent Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div id="consent_upload_view_div">
				<div id="consent_img_display">
					
				</div>
				<div class="modal-footer" id="consent_uplaod_edit">
						<button type="submit" name="consent_img_display_cancel_btn" id="consent_img_display_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</div>
			<div id="consent_upload_div">
				<form id="surgery_consent_form" method="POST" action="surgery_consent_form_img_upload.php" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="panel-body">
							<div class="form-row">
								<div class="col-md-4 mb-4">
									<label for="consent_doctor">Doctor</label>
									<input type="text" name="consent_doctor" class="form-control" id="consent_doctor">
								</div>
								<div class="col-md-4 mb-4">
									<label for="consent_relative">Relative</label>
									<input type="text" name="consent_relative" class="form-control" id="consent_relative">
								</div>
								<div class="col-md-4 mb-4">
									<label for="consent_language">Language</label>
									<input type="text" name="consent_language" class="form-control" id="consent_language">
								</div>
							</div>
							<!--<div class="form-row">
								<div class="col-md-6 mb-6">
									<label for="consent_diagnosis">Diagnosis</label>
									<input type="text" name="consent_diagnosis" class="form-control" id="consent_diagnosis">
								</div>
								<div class="col-md-6 mb-6">
									<label for="consent_procedure">Procedure</label>
									<input type="text" name="consent_procedure" class="form-control" id="consent_procedure">
								</div>
							</div>-->
							<div class="form-row">
								<div class="col-md-12 mb-12">
									<label for="consent_file">Consent Form Upload</label>
										<input type="file" name="consent_file" class="form-control" id="consent_file">
										<input type="hidden" name="file_size" class="form-control" id="file_size" value="1000000">
										<input type="hidden" name="consent_attend_id" class="form-control" id="consent_attend_id">
										<input type="hidden" name="consent_patient_id" class="form-control" id="consent_patient_id">
										<input type="hidden" name="consent_form_id" class="form-control" id="consent_form_id">
										<input type="hidden" name="consent_form_surgery_id" class="form-control" id="consent_form_surgery_id">
										<input type="hidden" name="consent_form_surgery_list_id" class="form-control" id="consent_form_surgery_list_id">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-12 mb-12">
									<label for="consent_comment">Comment</label>
									<textarea type="textarea" rows="2"  class="form-control" name="consent_comment" id="consent_comment" value=""></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div id="consent_uplaod_save_update">
							<button type="submit" name="consent_img_save_btn" id="consent_img_save_btn" class="btn btn-primary">Save</button>
							<button type="button" name="consent_img_upl_cancel_btn" id="consent_img_upl_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-xl" id="surgery_opt_notes_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="surgery_opt_notes_modal_title">Operation Notes</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="surgery_opt_note_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<div class="form-row">
									<div class="col-md-6 mb-6">
										<div class="form-row">
											<div class="col-md-6 mb-6">
												<label for="surgery_date_start">Start Date</label>
												<input type="date" name="surgery_date_start" class="form-control" id="surgery_date_start">
											</div>
											<div class="col-md-6 mb-6">
												<label for="surgery_time_start">Start Time</label>
												<input type="time" name="surgery_time_start" class="form-control" id="surgery_time_start">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-6 mb-6">
												<label for="surgery_date_end">End Date</label>
												<input type="date" name="surgery_date_end" class="form-control" id="surgery_date_end">
											</div>
											<div class="col-md-6 mb-6">
												<label for="surgery_time_end">End Time</label>
												<input type="time" name="surgery_time_end" class="form-control" id="surgery_time_end">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-12 mb-12">
												<label for="surgery_head">Head Surgeon</label>
												<input type="text" name="surgery_head" class="form-control" id="surgery_head">
											</div>
										</div>
									</div>
									<div class="col-md-6 mb-6">
										<label for="surgery_findings">Findings</label>
										<textarea type="textarea" rows="7"  class="form-control" name="surgery_findings" id="surgery_findings" value=""></textarea>
									</div>
								</div>
									<input type="hidden" name="surgery_id_op" class="form-control" id="surgery_id_op">
									<input type="hidden" name="surgery_list_id_op" class="form-control" id="surgery_list_id_op">
									<input type="hidden" name="surgery_optnote_id" class="form-control" id="surgery_optnote_id">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="surgery_procedure">Procedures</label>
								<textarea type="textarea" rows="4"  class="form-control" name="surgery_procedure" id="surgery_procedure" value=""></textarea>
							</div>
						</div>
					</div>
					<div class="form-row">
							<div class="col-md-6 mb-6">
								<table class="table table-bordered" id="assistant_surgeon_table">
									<tr>
										<th colspan="2"><a href="#" id="add_assist_surg_link">Assistant Surgeon</a></th>
									</tr>
									<tr id="row_as1">
										<td>
											<input type="text" name="assistant_surgeon[]" class="form-control bg-light" id="assistant_surgeon">
											<input type="hidden" name="op_assist_surg_id[]" class="form-control bg-light" id="op_assist_surg_id">
										</td>
										<td>
											<a href="#" id="delete_assist_surg_link" data-id="1"><i class="fa fa-trash fa-sm"></i></a>
										</td>
									</tr>
								</table>
							</div>
							<div class="col-md-6 mb-6">
								<table class="table table-bordered" id="scrub_nurse_table">
									<tr>
										<th colspan="2"><a href="#" id="add_scrub_nurse_link">Scrub Nurses</a></th>
									</tr>
									<tr id="row_sn1">
										<td>
											<input type="text" name="scrub_nurse[]" class="form-control bg-light" id="scrub_nurse">
											<input type="hidden" name="op_scrub_nurse_id[]" class="form-control bg-light" id="op_scrub_nurse_id">
										</td>
										<td>
											<a href="#" id="delete_scrub_nurse_link" data-id="1"><i class="fa fa-trash fa-sm"></i></a>
										</td>
									</tr>
								</table>
							</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="surgery_opt_note_save_update">
						<button type="submit" name="surgery_opt_note_save_btn" id="surgery_opt_note_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="submit" name="surgery_opt_note_update_btn" id="surgery_opt_note_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-xl" id="surgery_anesthesia_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="surgery_anesthesia_modal_title">Anesthesia Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="surgery_anesthesia_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="surgery_rscp"><small>Rapid Seq. Cricoid Pres.</small></label>
								<select class="form-control bg-light" name="surgery_rscp" id="surgery_rscp"> 
						    		<option value="0">Please Select</option>
							        <option value="Pre O2">Pre O2</option>
							        <option value="IV">IV</option>
							        <option value="IM">IM</option>
							        <option value="IH">IH</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_airway"><small>Air Way</small></label>
								<select class="form-control bg-light" name="surgery_airway" id="surgery_airway"> 
						    		<option value="0">Please Select</option>
							        <option value="Oral">Oral</option>
							        <option value="Nasal">Nasal</option>
							        <option value="Cuffed">Cuffed</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_etmethod"><small>ET Method</small></label>
								<select class="form-control bg-light" name="surgery_etmethod" id="surgery_etmethod"> 
						    		<option value="0">Please Select</option>
							        <option value="Mask">Mask</option>
							        <option value="Oral ETT">Oral ETT</option>
							        <option value="LMA">LMA</option>
							        <option value="Nasal ETT">Nasal ETT</option>
							        <option value="Laser">Laser</option>
							        <option value="Nasal Cannula">Nasal Cannula</option>
							        <option value="O2 Mask">O2 Mask</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_intubation"><small>Intubation</small></label>
								<select class="form-control bg-light" name="surgery_intubation" id="surgery_intubation"> 
						    		<option value="0">Please Select</option>
							        <option value="Breathing Sounds Bilater">Breathing Sounds Bilater</option>
							        <option value="Cricoid Pressure">Cricoid Pressure</option>
							        <option value="Difficult Intubation">Difficult Intubation</option>
							        <option value="Atraumatic Intubation">Atraumatic Intubation</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_tube_type"><small>Tube Type</small></label>
								<select class="form-control bg-light" name="surgery_tube_type" id="surgery_tube_type"> 
						    		<option value="0">Please Select</option>
							        <option value="Direct">Direct</option>
							        <option value="Blind">Blind</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_tube_size"><small>Tube Size (mm)</small></label>
								<select class="form-control bg-light" name="surgery_tube_size" id="surgery_tube_size"> 
						    		<option value="0">Please Select</option>
									<option value="2.5">2.5</option>
									<option value="3">3</option>
									<option value="3.5">3.5</option>
									<option value="4">4</option>
									<option value="4.5">4.5</option>
									<option value="5">5</option>
									<option value="5.5">5.5</option>
									<option value="6">6</option>
									<option value="6.5">6.5</option>
									<option value="7">7</option>
									<option value="7.5">7.5</option>
									<option value="8">8</option>
									<option value="8.5">8.5</option>
									<option value="9">9</option>
									<option value="9.5">9.5</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="surgery_taped"><small>Taped (cm)</small></label>
								<input type="text" name="surgery_taped" class="form-control bg-light" id="surgery_taped">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_blade_size"><small>Blade Size</small></label>
								<select class="form-control bg-light" name="surgery_blade_size" id="surgery_blade_size"> 
						    		<option value="0">Please Select</option>
							        <option value="1">1</option>
							        <option value="2">2</option>
							        <option value="3">3</option>
							        <option value="4">4</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_blade_type"><small>Blade Type</small></label>
								<select class="form-control bg-light" name="surgery_blade_type" id="surgery_blade_type"> 
						    		<option value="0">Please Select</option>
							        <option value="Curve">Curve</option>
							        <option value="Straight">Straight</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_eye"><small>Eye</small></label>
								<select class="form-control bg-light" name="surgery_eye" id="surgery_eye"> 
						    		<option value="0">Please Select</option>
							        <option value="Taped">Taped</option>
							        <option value="Lubed">Lubed</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_circuit"><small>Circuit</small></label>
								<select class="form-control bg-light" name="surgery_circuit" id="surgery_circuit"> 
						    		<option value="0">Please Select</option>
							        <option value="Circle">Circle</option>
							        <option value="Draw Over">Draw Over</option>
							        <option value="Semi Open">Semi Open</option>
							        <option value="T-Piece">T-Piece</option>
							        <option value="Non Rebreathing">Non Rebreathing</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_crystaloids"><small>Crystaloids</small></label>
								<input type="text" name="surgery_crystaloids" class="form-control bg-light" id="surgery_crystaloids">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="surgery_colloid"><small>Colloid</small></label>
								<input type="text" name="surgery_colloid" class="form-control bg-light" id="surgery_colloid">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_prbc"><small>Packed Red Blood Cells</small></label>
								<input type="text" name="surgery_prbc" class="form-control bg-light" id="surgery_prbc">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_platelets"><small>Platelets</small></label>
								<input type="text" name="surgery_platelets" class="form-control bg-light" id="surgery_platelets">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_others"><small>Others</small></label>
								<input type="text" name="surgery_others" class="form-control bg-light" id="surgery_others">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_ebl"><small>Estimated Blood Loss</small></label>
								<input type="text" name="surgery_ebl" class="form-control bg-light" id="surgery_ebl">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_urine_output"><small>Urine Output</small></label>
								<input type="text" name="surgery_urine_output" class="form-control bg-light" id="surgery_urine_output">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="surgery_exubated"><small>Exubated?</small></label>
								<select class="form-control bg-light" name="surgery_exubated" id="surgery_exubated"> 
						    		<option value="0">Please Select</option>
							        <option value="Yes">Yes</option>
							        <option value="No">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_exubated_date"><small>Exubated Date</small></label>
								<input type="date" name="surgery_exubated_date" class="form-control bg-light" id="surgery_exubated_date">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_exubated_time"><small>Exubated Time</small></label>
								<input type="time" name="surgery_exubated_time" class="form-control bg-light" id="surgery_exubated_time">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_mask"><small>Mask/Throat Pack?</small></label>
								<select class="form-control bg-light" name="surgery_mask" id="surgery_mask"> 
						    		<option value="0">Please Select</option>
							        <option value="Yes">Yes</option>
							        <option value="No">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_mask_date"><small>Mask Out @ Date</small></label>
								<input type="date" name="surgery_mask_date" class="form-control bg-light" id="surgery_mask_date">
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_mask_time"><small>Mask Out @ Time</small></label>
								<input type="time" name="surgery_mask_time" class="form-control bg-light" id="surgery_mask_time">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="surgery_blood_req"><small>Blood Requested?</small></label>
								<select class="form-control bg-light" name="surgery_blood_req" id="surgery_blood_req"> 
						    		<option value="0">Please Select</option>
							        <option value="Yes">Yes</option>
							        <option value="No">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_path_req"><small>Pathology Requested?</small></label>
								<select class="form-control bg-light" name="surgery_path_req" id="surgery_path_req"> 
						    		<option value="0">Please Select</option>
							        <option value="Yes">Yes</option>
							        <option value="No">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="surgery_usa"><small>USA Status</small></label>
								<select class="form-control bg-light" name="surgery_usa" id="surgery_usa"> 
						    		<option value="0">Please Select</option>
							        <option value="Yes">Yes</option>
							        <option value="No">No</option>
						    	</select>
							</div>
							<div class="col-md-6 mb-6">
								<label for="surgery_anesthetist"><small>Head Anesthetist</small></label>
								<input type="text" name="surgery_anesthetist" class="form-control bg-light" id="surgery_anesthetist">
							</div>
						</div>
						
						<div class="form-row">
							<div class="col-md-6 mb-6">
								<div class="form-row">
									<table class="table table-bordered" id="anest_tech_table">
											<tr>
												<th><a href="#" id="add_anest_tech_link">Technique</a></th>
												<th>Tech. Date</th>
												<th colspan="4">Tech. Time</th>
											</tr>
											<tr id="row_at1">
												<td>
													<select class="form-control bg-light" name="anest_tech_desc[]" id="anest_tech_desc"> 
											    		<option value="0">Please Select</option>
												        <option value="Combined">Combined</option>
												        <option value="General">General</option>
												        <option value="Local">Local</option>
												        <option value="Nerve_Blk">Nerve Blk</option>
												        <option value="Spinal">Spinal</option>
											    	</select>
													<input type="hidden" name="anest_tech_id []" class="form-control bg-light" id="anest_tech_id ">
												</td>
												<td>
													<input type="date" name="anest_tech_date[]" class="form-control bg-light" id="anest_tech_date">
												</td>
												<td>
													<input type="time" name="anest_tech_time[]" class="form-control bg-light" id="anest_tech_time">
												</td>
												<td>
													<a href="#" id="delete_anest_tech_link" data-id="1"><i class="fa fa-trash fa-sm"></i></a>
												</td>
											</tr>
									</table>
								</div>
							</div>
							<div class="col-md-6 mb-6">
								<table class="table table-bordered" id="assist_anest_table">
									<tr>
										<th colspan="2"><a href="#" id="add_assist_anest_link">Assistant Anesthetist</a></th>
									</tr>
									<tr id="row_aa1">
										<td>
											<input type="text" name="assistant_anesthetist[]" class="form-control bg-light" id="assistant_anesthetist">
											<input type="hidden" name="anest_assist_id []" class="form-control bg-light" id="anest_assist_id ">
										</td>
										<td>
											<a href="#" id="delete_assist_anest_link" data-id="1"><i class="fa fa-trash fa-sm"></i></a>
										</td>
									</tr>
								</table>
							</div>
					</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="surgery_anest_remarks"><small>Remarks</small></label>
								<textarea type="textarea" rows="4"  class="form-control" name="surgery_anest_remarks" id="surgery_anest_remarks"></textarea>
							</div>
						</div>
						<input type="hidden" name="surgery_anest_id" class="form-control" id="surgery_anest_id">
						<input type="hidden" name="surgery_id_anes" class="form-control" id="surgery_id_anes">
						<input type="hidden" name="surgery_list_id_anes" class="form-control" id="surgery_list_id_anes">
					</div>
				</div>
				<div class="modal-footer">
					<div id="surgery_opt_note_save_update">
						<button type="submit" name="surgery_anesthesia_save_btn" id="surgery_anesthesia_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="submit" name="surgery_anesthesia_update_btn" id="surgery_anesthesia_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-xl" id="past_surgery_opt_notes_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="past_surgery_opt_notes_modal_title">Operation Notes</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
				<div id="past_surgery_opt_notes_view">
					
				</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-xl" id="past_surgery_anesthesia_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="past_surgery_anesthesia_modal_title">Anesthesia Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
				<div id="past_surgery_anesthesia_view">
					
				</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<div 
	class="modal fade bd-example-modal-xl" 
	id="surgery_list_duplicate_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="surgery_list_duplicate_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="surgery_list_duplicate_modal_title">Surgery Duplication</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="surgery_list_duplicate_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="surgery_list_duplicate_yes" name="surgery_list_duplicate_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="surgery_list_duplicate_no" name="surgery_list_duplicate_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<div 
	class="modal fade bd-example-modal-xl" 
	id="surgery_attend_delete_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="surgery_attend_delete_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="surgery_attend_delete_modal_title">Surgery Item Deletion</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="surgery_attend_delete_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="surgery_attend_delete_yes" name="surgery_attend_delete_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="surgery_attend_delete_no" name="surgery_attend_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/discount_create_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/validation_sheet_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>