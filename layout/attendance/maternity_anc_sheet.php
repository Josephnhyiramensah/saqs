<?php
	include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
	$preg_id = $_SESSION['preg_id'];
	$query_preg = "SELECT * FROM pregnancies WHERE preg_id='$preg_id'";
	$query_run_preg = mysqli_query($con, $query_preg);

	if (mysqli_num_rows($query_run_preg) > 0)
	{
		while($row_preg = mysqli_fetch_assoc($query_run_preg))
		{
			$preg_problem = $row_preg['risk_factor'];
		};
	}
	else
	{
		$preg_problem = 'None';
	};
?>
<div class="form-row">
	<div class="col-md-2 mb-2">
		<button type="button" name="anc_maternity_leave_btn" id="anc_maternity_leave_btn" class="btn btn-block btn-secondary">Maternity Leave</button>
	</div>
	<div class="col-md-3 mb-3">
	</div>
	<div class="col-md-2 mb-2">
		<button type="button" id="pregnancies_btn" class="btn btn-block btn-secondary">Pregnancies</button>
	</div>
	<div class="col-md-3 mb-3">
	</div>
	<div class="col-md-2 mb-2">
		<button type="button" name="anc_delivery_btn" id="anc_delivery_btn" class="btn btn-block btn-secondary">Delivery</button>
	</div>
</div>
<hr class="d-none d-md-block">
<div class="table-responsive" id="patient_anc_table">
    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Date</th>
                <th>Weight</th>
                <th>BP</th>
                <th>Urine Protein</th>
                <th>Urine Sugar</th>
                <th>Gest. Age</th>
                <th>F. Height</th>
                <th>F. Weight</th>
                <th>Present.</th>
                <th>Descent</th>
                <th>FHR</th>
                <th>Remarks</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">
			<tr>
				<td colspan="13"><?php echo '<strong>Pregnancy Problem:</strong> '.$preg_problem;?></td>
			</tr>
            <?php
            	//$preg_id = $_SESSION['preg_id'];
			    $query = "SELECT * FROM anc WHERE preg_id='$preg_id' ORDER BY date DESC";
			    $query_run = mysqli_query($con, $query);

                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
						$attend_id = $row['attend_id'];
						$query_attd_vitals = "SELECT * FROM vitals WHERE attend_id='$attend_id' ORDER BY date DESC";
						$query_run_attd_vitals = mysqli_query($con, $query_attd_vitals);
						if (mysqli_num_rows($query_run_attd_vitals) > 0)
						{
							while($row_attd_vitals = mysqli_fetch_assoc($query_run_attd_vitals))
							{
								if($row_attd_vitals['bp_diastolic'] !='')
								{$bp_diastolic = $row_attd_vitals['bp_diastolic'];}
								else
								{$bp_diastolic = 0;};

								if($row_attd_vitals['bp_systolic'] !='')
								{$bp_systolic = $row_attd_vitals['bp_systolic'];}
								else
								{$bp_systolic = 0;};

								if($row_attd_vitals['weight'] !='')
								{$weight = $row_attd_vitals['weight'];}
								else
								{$weight = 0;};
							};
						}
						else
						{
							$bp_diastolic = 0;
							$bp_systolic = 0;
							$weight = 0;
						};
						
						$urine_protein = 0;
						$urine_sugar = 0;
						$query_attd_labs = "SELECT * FROM lab_param_list WHERE attend_id='$attend_id' AND (lab_id = 400 OR lab_id = 435)";
						$query_run_attd_labs = mysqli_query($con, $query_attd_labs);
						if (mysqli_num_rows($query_run_attd_labs) > 0)
						{
							while($row_attd_labs = mysqli_fetch_assoc($query_run_attd_labs))
							{
								if($row_attd_labs['lab_id'] == 400)
								{
									$urine_protein = $row_attd_labs['result'];
								};
								if($row_attd_labs['lab_id'] == 435)
								{
									$urine_sugar = $row_attd_labs['result'];
								};
							};
						}
						else
						{
							$urine_protein = 0;
							$urine_sugar = 0;
						};
            ?>
                <tr>
                    <td><a href="#" id="btn_edit_anc_sheet" data-id1="<?php echo $row['anc_id'];?>"><?php echo $row['date'];?></a></td>
                    <td><?php echo $weight;?></td>
                    <td><?php echo $bp_systolic;?>/<?php echo $bp_diastolic;?></td>
                    <td><?php echo $urine_protein;?></td>
                    <td><?php echo $urine_sugar;?></td>
                    <td><?php echo $row['gest_age'];?></td>
                    <td><?php echo $row['fundal_height'];?></td>
                    <td><?php echo $row['fundal_weight'];?></td>
                    <td><?php echo $row['presentation'];?></td>
                    <td><?php echo $row['descent'];?></td>
                    <td><?php echo $row['foetal_hr'];?></td>
                    <td><?php echo $row['remarks'];?></td>
                    <td>
						<a href="#" id="btn_delete_anc" data-id2="<?php echo $row['anc_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
                    </td>
                </tr>
            <?php
                    }
                };
            ?>
        </tbody>
    </table>
</div>

<form id="anc_current_form" method="POST" >
	<div class="modal-body">
		<div class="panel-body">
			<div class="form-row">
				<div class="col-md-2 mb-2">
					<label for="anc_gest_age"><small>Gestation Age</small></label>
					<input type="text" name="anc_gest_age" class="form-control bg-light" id="anc_gest_age">
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_fundal_height"><small>Fundal Height</small></label>
					<input type="text" name="anc_fundal_height" class="form-control bg-light" id="anc_fundal_height">
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_fundal_weight"><small>Foetal Weight</small></label>
					<input type="text" name="anc_fundal_weight" class="form-control bg-light" id="anc_fundal_weight">
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_fhr"><small>Foetal Heart Rate</small></label>
					<input type="text" name="anc_fhr" class="form-control bg-light" id="anc_fhr">
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_present"><small>Presentation</small></label>
					<select class="form-control bg-light" name="anc_present" id="anc_present"> 
			    		<option value="0">Please Select</option>
				        <option value="BREECH">BREECH</option>
				        <option value="CEPHALIC">CEPHALIC</option>
				        <option value="OBLIQUE">OBLIQUE</option>
				        <option value="TRANSVERSE">TRANSVERSE</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_descent"><small>Descent</small></label>
					<select class="form-control bg-light" name="anc_descent" id="anc_descent"> 
			    		<option value="-">Please Select</option>
				        <option value="0">0</option>
				        <option value="1">1</option>
				        <option value="2">2</option>
				        <option value="3">3</option>
				        <option value="4">4</option>
				        <option value="5">5</option>
			    	</select>
				</div>
			</div>
			<!--<div class="form-row">
				<div class="col-md-2 mb-2">
					<label for="anc_weight"><small>Weight</small></label>
					<input type="text" name="anc_weight" class="form-control bg-light" id="anc_weight">
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_urine_sugar"><small>Urine Sugar</small></label>
					<select class="form-control bg-light" name="anc_urine_sugar" id="anc_urine_sugar"> 
			    		<option value="0">Please Select</option>
				        <option value="+">+</option>
				        <option value="+++">++</option>
				        <option value="++++">++++</option>
				        <option value="NIL">NIL</option>
				        <option value="TRACE">TRACE</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_urine_protein"><small>Urine Protein</small></label>
					<select class="form-control bg-light" name="anc_urine_protein" id="anc_urine_protein"> 
			    		<option value="0">Please Select</option>
				        <option value="+">+</option>
				        <option value="+++">++</option>
				        <option value="++++">++++</option>
				        <option value="NIL">NIL</option>
				        <option value="TRACE">TRACE</option>
			    	</select>
				</div>
				<div class="col-md-1 mb-1">
					<label for="anc_bp_systolic"><small>BP Systolic</small></label>
					<input type="text" name="anc_bp_systolic" class="form-control bg-light" id="anc_bp_systolic">
				</div>
				<div class="col-md-1 mb-1">
					<label for="anc_bp_diastolic"><small>BP Diastolic</small></label>
					<input type="text" name="anc_bp_diastolic" class="form-control bg-light" id="anc_bp_diastolic">
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_tt_episode"><small>TT Episode</small></label>
					<select class="form-control bg-light" name="anc_tt_episode" id="anc_tt_episode"> 
			    		<option value="0">Please Select</option>
				        <option value="FIRST">FIRST</option>
				        <option value="SECOND">SECOND</option>
				        <option value="THIRD">THIRD</option>
				        <option value="FOURTH">FOURTH</option>
				        <option value="FIFTH">FIFTH</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_tt_qty"><small>TT Qty</small></label>
					<input type="text" name="anc_tt_qty" class="form-control bg-light" id="anc_tt_qty">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-2 mb-2">
					<label for="anc_ifa_given"><small>IFA Tab Given</small></label>
					<select class="form-control bg-light" name="anc_ifa_given" id="anc_ifa_given"> 
			    		<option value="0">Please Select</option>
				        <option value="">15</option>
				        <option value="30">30</option>
				        <option value="60">60</option>
				        <option value="90">90</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_sp_episode"><small>SP Episode</small></label>
					<select class="form-control bg-light" name="anc_sp_episode" id="anc_sp_episode"> 
			    		<option value="0">Please Select</option>
				        <option value="FIRST">FIRST</option>
				        <option value="SECOND">SECOND</option>
				        <option value="THIRD">THIRD</option>
				        <option value="FOURTH">FOURTH</option>
				        <option value="FIFTH">FIFTH</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_sp_qty"><small>SP Qty</small></label>
					<input type="text" name="anc_sp_qty" class="form-control bg-light" id="anc_sp_qty">
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_g6pd"><small>G6PD</small></label>
					<select class="form-control bg-light" name="anc_g6pd" id="anc_g6pd"> 
			    		<option value="0">Please Select</option>
				        <option value="NO DEFECT">NO DEFECT</option>
				        <option value="PARTIAL DEFECT">PARTIAL DEFECT</option>
				        <option value="FULL DEFECT">FULL DEFECT</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_hiv_status"><small>HIV Status</small></label>
					<select class="form-control bg-light" name="anc_hiv_status" id="anc_hiv_status"> 
			    		<option value="0">Please Select</option>
				        <option value="Positive">Positive</option>
				        <option value="Negative">Negative</option>
				        <option value="Not Done">Not Done</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_arv_treat"><small>ARV Treat.</small></label>
					<select class="form-control bg-light" name="anc_arv_treat" id="anc_arv_treat"> 
			    		<option value="0">Please Select</option>
				        <option value="Yes">Yes</option>
				        <option value="No">No</option>
			    	</select>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-2 mb-2">
					<label for="anc_syphillis_status"><small>Syphillis Status</small></label>
					<select class="form-control bg-light" name="anc_syphillis_status" id="anc_syphillis_status"> 
			    		<option value="0">Please Select</option>
				        <option value="Positive">Positive</option>
				        <option value="Negative">Negative</option>
				        <option value="Not Done">Not Done</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_syphillis_treat"><small>Syphillis Treat.</small></label>
					<select class="form-control bg-light" name="anc_syphillis_treat" id="anc_syphillis_treat"> 
			    		<option value="0">Please Select</option>
				        <option value="Yes">Yes</option>
				        <option value="No">No</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_tb_diagnosed"><small>TB Diagnosed</small></label>
					<select class="form-control bg-light" name="anc_tb_diagnosed" id="anc_tb_diagnosed"> 
			    		<option value="0">Please Select</option>
				        <option value="Positive">Positive</option>
				        <option value="Negative">Negative</option>
				        <option value="Not Done">Not Done</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_tb_treat"><small>TB Treat.</small></label>
					<select class="form-control bg-light" name="anc_tb_treat" id="anc_tb_treat"> 
			    		<option value="0">Please Select</option>
				        <option value="Yes">Yes</option>
				        <option value="No">No</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_hp"><small>HB</small></label>
					<input type="text" name="anc_hp" class="form-control bg-light" id="anc_hp">
				</div>
				<div class="col-md-2 mb-2">
					<label for="anc_itn"><small>ITN Given</small></label>
					<select class="form-control bg-light" name="anc_itn" id="anc_itn"> 
			    		<option value="0">Please Select</option>
				        <option value="Yes">Yes</option>
				        <option value="No">No</option>
			    	</select>
				</div>
			</div>-->
			<div class="form-row">
				<div class="col-md-2 mb-2">
					<label for="anc_date"><small>Date</small></label>
					<input type="date" name="anc_date" class="form-control bg-light" id="anc_date" value="<?php echo $date?>">
				</div>
				<div class="col-md-10 mb-10">
					<label for="anc_comment"><small>Comment</small></label>
					<textarea type="textarea" rows="2"  class="form-control bg-light" name="anc_comment" id="anc_comment" value=""></textarea>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<div id="anc_save_update">
			<button type="submit" name="anc_save_btn" id="anc_save_btn" class="btn btn-primary">Save</button>
		</div>
	    <button type="button" name="anc_cancel_btn" id="anc_cancel_btn" class="btn btn-secondary">Cancel</button>
	    <input type="hidden" name="anc_id" class="form-control bg-light" id="anc_id">
	    <input type="hidden" name="preg_id" class="form-control bg-light" id="preg_id" value="">
	</div>
</form>

<?php
	include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/maternity_leave_sheet.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>