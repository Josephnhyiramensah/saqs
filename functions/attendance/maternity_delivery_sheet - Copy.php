<?php
	include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
?>
<hr class="d-none d-md-block">
<ul class="nav nav-tabs">
	<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#mother" id="deliver_mother"><h5 class="m-0 font-weight-bold text-primary">Mother</h5></a></li>
	<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#children" id="deliver_children"><h5 class="m-0 font-weight-bold text-primary">Children</h5></a></li>
	<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#partograph" id="deliver_partograph"><h5 class="m-0 font-weight-bold text-primary">Partograph</h5></a></li>
</ul>
<div class="tab-content">
	<div id="mother" class="tab-pane fade show active">
		<form action="" id="delivery_attend_form" method="POST">
			<div class="form-row">
				<div class="col-md-2 mb-2">
					<label for="delivery_start_date"><small>Start Date</small></label>
					<input type="date" class="form-control" name="delivery_start_date" id="delivery_start_date">
				</div>
				<div class="col-md-2 mb-2">
					<label for="delivery_start_time"><small>Start Time</small></label>
					<input type="time" class="form-control" name="delivery_start_time" id="delivery_start_time">
				</div>
				<div class="col-md-4 mb-4">
				</div>
				<div class="col-md-2 mb-2">
					<label for="delivery_end_date"><small>End Date</small></label>
					<input type="date" class="form-control" name="delivery_end_date" id="delivery_end_date">
				</div>
				<div class="col-md-2 mb-2">
					<label for="delivery_end_time"><small>End Time</small></label>
					<input type="time" class="form-control" name="delivery_end_time" id="delivery_end_time">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-1 mb-1">
					<label for="gravida"><small>Gravida</small></label>
					<input type="text" class="form-control bg-light" name="gravida" id="gravida">
				</div>
				<div class="col-md-1 mb-1">
					<label for="para"><small>Para</small></label>
					<input type="text" class="form-control bg-light" name="para" id="para">
				</div>
				<div class="col-md-1 mb-1">
					<label for="abortions"><small>Abortions</small></label>
					<input type="text" class="form-control bg-light" name="abortions" id="abortions">
				</div>
				<div class="col-md-1 mb-1">
					<label for="induced"><small>Induced</small></label>
					<input type="text" class="form-control bg-light" name="induced" id="induced">
				</div>
				<div class="col-md-1 mb-1">
					<label for="spontaneous"><small>Spontaeous</small></label>
					<input type="text" class="form-control bg-light" name="spontaneous" id="spontaneous">
				</div>
				<div class="col-md-2 mb-2">
					<label for="lmp"><small>LMP</small></label>
					<input type="date" class="form-control bg-light" name="lmp" id="lmp">
				</div>
				<div class="col-md-2 mb-2">
					<label for="edd"><small>EDD</small></label>
					<input type="date" class="form-control bg-light" name="edd" id="edd">
				</div>
				<div class="col-md-1 mb-1">
					<label for="blood_group"><small>Blood Group</small></label>
					<input type="text" class="form-control bg-light" name="blood_group" id="blood_group">
				</div>
				<div class="col-md-1 mb-1">
					<label for="sickling"><small>Sickling</small></label>
					<input type="text" class="form-control bg-light" name="sickling" id="sickling">
				</div>
				<div class="col-md-1 mb-1">
					<label for="geno_type"><small>Geno Type</small></label>
					<input type="text" class="form-control bg-light" name="geno_type" id="geno_type">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-1 mb-1">
					<label for="gestation_age"><small>Genstation Age</small></label>
					<input type="text" class="form-control bg-light" name="gestation_age" id="gestation_age">
				</div>
				<div class="col-md-1 mb-1">
					<label for="no_of_anc_visits"><small>No of ANC visits</small></label>
					<input type="text" class="form-control bg-light" name="no_of_anc_visits" id="no_of_anc_visits">
				</div>
				<div class="col-md-1 mb-1">
					<label for="syphillis"><small>Syphillis</small></label>
					<select class="form-control bg-light" name="syphillis" id="syphillis"> 
			    		<option value="0">Select</option>
			    		<option value="positive">Positive</option>
			    		<option value="negative">Negative</option>
			    		<option value="not_done">Not Done</option>
			    	</select>
				</div>
				<div class="col-md-1 mb-1">
					<label for="heb_b"><small>Heb B</small></label>
					<select class="form-control bg-light" name="heb_b" id="heb_b"> 
			    		<option value="0">Select</option>
			    		<option value="positive">Positive</option>
			    		<option value="negative">Negative</option>
			    		<option value="not_done">Not Done</option>
			    	</select>
				</div>
				<div class="col-md-1 mb-1">
					<label for="pmtct"><small>PMTCT</small></label>
					<select class="form-control bg-light" name="pmtct" id="pmtct"> 
			    		<option value="0">Select</option>
			    		<option value="positive">Positive</option>
			    		<option value="negative">Negative</option>
			    		<option value="not_done">Not Done</option>
			    	</select>
				</div>
				<div class="col-md-1 mb-1">
					<label for="an_cort"><small>AN Cort</small></label>
					<select class="form-control bg-light" name="an_cort" id="an_cort"> 
			    		<option value="0">Select</option>
			    		<option value="yes">Yes</option>
			    		<option value="no">No</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="stillbirth"><small>SB</small></label>
					<select class="form-control bg-light" name="stillbirth" id="stillbirth"> 
			    		<option value="0">Please Select</option>
			    		<option value="macerated_sb">Macerated SB</option>
			    		<option value="fresh_sb">Fresh SB</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="labour_complication"><small>Labour Complication</small></label>
					<select class="form-control bg-light" name="labour_complication" id="labour_complication"> 
			    		<option value="0">Please Select</option>
			    		<option value="PPH">PPH</option>
			    		<option value="ECLAMPSIA">ECLAMPSIA</option>
			    		<option value="Obstructed_Labour">Obstructed Labour</option>
			    		<option value="Ruptured_Uterus">Ruptured Uterus</option>
			    		<option value="PIH">PIH</option>
			    		<option value="Chorioamnionitis">Chorioamnionitis</option>
			    		<option value="PROM">PROM</option>
			    		<option value="NIL">NIL</option>
			    		<option value="OTHERS">OTHERS</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="other_interventions"><small>Other Interventions</small></label>
					<input type="text" class="form-control bg-light" name="other_interventions" id="other_interventions">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-1 mb-1">
					<label for="bp_systolic"><small>BP-Systolic</small></label>
					<input type="text" class="form-control bg-light" name="bp_systolic" id="bp_systolic">
				</div>
				<div class="col-md-1 mb-1">
					<label for="bp_diastolic"><small>BP-Diastolic</small></label>
					<input type="text" class="form-control bg-light" name="bp_diastolic" id="bp_diastolic">
				</div>
				<div class="col-md-1 mb-1">
					<label for="pulse"><small>Pulse</small></label>
					<input type="text" class="form-control bg-light" name="pulse" id="pulse">
				</div>
				<div class="col-md-1 mb-1">
					<label for="temp"><small>Temp</small></label>
					<input type="text" class="form-control bg-light" name="temp" id="temp">
				</div>
				<div class="col-md-1 mb-1">
					<label for="fhr"><small>FHR</small></label>
					<input type="text" class="form-control bg-light" name="fhr" id="fhr">
				</div>
				<div class="col-md-2 mb-2">
					<label for="lie_present"><small>Lie & Presentation</small></label>
					<select class="form-control bg-light" name="lie_present" id="lie_present"> 
			    		<option value="0">Select</option>
			    		<option value="Longi">Longi.</option>
			    		<option value="Obliq">Obliq.</option>
			    		<option value="Trans">Trans.</option>
			    		<option value="Ceph">Ceph.</option>
			    		<option value="Breech">Breech</option>
			    		<option value="Others">Others</option>
			    	</select>
				</div>
				<div class="col-md-1 mb-1">
					<label for="cervical_dilitation"><small>Cervical Dilitation</small></label>
					<input type="text" class="form-control bg-light" name="cervical_dilitation" id="cervical_dilitation">
				</div>
				<div class="col-md-1 mb-1">
					<label for="partograph_used"><small>Partograph Used</small></label>
					<select class="form-control bg-light" name="partograph_used" id="partograph_used"> 
			    		<option value="0">Select</option>
			    		<option value="yes">Yes</option>
			    		<option value="no">No</option>
			    	</select>
				</div>
				<div class="col-md-1 mb-1">
					<label for="perineum"><small>Perineum</small></label>
					<select class="form-control bg-light" name="perineum" id="perineum"> 
			    		<option value="0">Select</option>
			    		<option value="intact">Intact</option>
			    		<option value="episiotomy">Episiotomy</option>
			    		<option value="tear">Tear</option>
			    	</select>
				</div>
				<div class="col-md-1 mb-1">
					<label for="auxilliary_temp"><small>Auxilliary Temp</small></label>
					<input type="text" class="form-control bg-light" name="auxilliary_temp" id="auxilliary_temp">
				</div>
				<div class="col-md-1 mb-1">
					<label for="apgar_score"><small>Apgar Score</small></label>
					<select class="form-control bg-light" name="apgar_score" id="apgar_score"> 
			    		<option value="0">Select</option>
			    		<option value="1min">1min</option>
			    		<option value="5min">5min</option>
			    	</select>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-2 mb-2">
					<label for="Mode_of_delivery"><small>Mode Of Delivery (MOD)</small></label>
					<select class="form-control bg-light" name="Mode_of_delivery" id="Mode_of_delivery"> 
			    		<option value="0">Please Select</option>
						<option value="CAESARIAN SECTION">CAESARIAN SECTION</option>
						<option value="FORCEPS">FORCEPS</option>
						<option value="NORMAL/SPONTANEOUS">NORMAL/SPONTANEOUS</option>
						<option value="VACCUM">VACCUM</option>
						<option value="ABORTION">ABORTION</option>
						<option value="OTHER">OTHER</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="cs_on_account"><small>CS on account of</small></label>
					<input type="text" class="form-control bg-light" name="cs_on_account" id="cs_on_account">
				</div>
				<div class="col-md-1 mb-1">
					<label for="oxytocin_10min"><small>Oxytocin in 10min</small></label>
					<select class="form-control bg-light" name="oxytocin_10min" id="oxytocin_10min">  
			    		<option value="0">Select</option>
			    		<option value="no">No</option>
			    		<option value="yes">Yes</option>
		    		</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="oxytocin_time"><small>Time Oxytocin Given</small></label>
					<input type="time" class="form-control bg-light" name="oxytocin_time" id="oxytocin_time">
				</div>
				<div class="col-md-1 mb-1">
					<label for="est_blood_loss"><small>Est. Blood Loss</small></label>
					<input type="text" class="form-control bg-light" name="est_blood_loss" id="est_blood_loss">
				</div>
				<div class="col-md-2 mb-2">
					<label for="placenta_time"><small>Time Placenta Delivered</small></label>
					<input type="time" class="form-control bg-light" name="placenta_time" id="placenta_time">
				</div>
				<div class="col-md-2 mb-2">
					<label for="placenta_state"><small>State of Placenta</small></label>
					<select class="form-control bg-light" name="placenta_state" id="placenta_state">  
			    		<option value="0">Select</option>
			    		<option value="Complete">Complete</option>
			    		<option value="Incomplete">Incomplete</option>
		    		</select>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-3 mb-3">
					<label for="labour_type"><small>Labour Type</small></label>
					<select class="form-control bg-light" name="labour_type" id="labour_type"> 
			    		<option value="0">Please Select</option>
						<option value="Spontaneous">Spontaneous</option>
						<option value="Induced">Induced</option>
						<option value="Augumentation">Augumentation</option>
						<option value="Caesarian Section">Caesarian Section</option>
						<option value="Other">Other</option>
			    	</select>
				</div>
				<div class="col-md-3 mb-3">
					<label for="outcome"><small>Outcome</small></label>
					<select class="form-control bg-light" name="outcome" id="outcome"> 
			    		<option value="0">Please Select</option>
						<option value="LIVE">LIVE</option>
						<option value="PREMATURE">PREMATURE</option>
						<option value="STILL">STILL</option>
			    	</select>
				</div>
				<div class="col-md-3 mb-3">
					<label for="condition"><small>Condition</small></label>
					<select class="form-control bg-light" name="condition" id="condition"> 
			    		<option value="0">Please Select</option>
						<option value="ALIVE">ALIVE</option>
						<option value="COMMA">COMMA</option>
						<option value="DEAD">DEAD</option>
			    	</select>
				</div>
				<div class="col-md-3 mb-3">
					<label for="post_partum"><small>Post Partum</small></label>
					<select class="form-control bg-light" name="post_partum" id="post_partum"> 
			    		<option value="0">Please Select</option>
						<option value="COMPLICATED">COMPLICATED</option>
						<option value="UNCOMPLICATED">UNCOMPLICATED</option>
			    	</select>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-2 mb-2">
					<label for="bp_systolic_post"><small>BP-Systolic</small></label>
					<input type="text" class="form-control bg-light" name="bp_systolic_post" id="bp_systolic_post">
				</div>
				<div class="col-md-2 mb-2">
					<label for="bp_diastolic_post"><small>BP-Diastolic</small></label>
					<input type="text" class="form-control bg-light" name="bp_diastolic_post" id="bp_diastolic_post">
				</div>
				<div class="col-md-2 mb-2">
					<label for="pulse_post"><small>Pulse</small></label>
					<input type="text" class="form-control bg-light" name="pulse_post" id="pulse_post">
				</div>
				<div class="col-md-2 mb-2">
					<label for="temp_post"><small>Temp</small></label>
					<input type="text" class="form-control bg-light" name="temp_post" id="temp_post">
				</div>
				<div class="col-md-2 mb-2">
					<label for="resp_rate_post"><small>Respiratory Rate</small></label>
					<input type="text" class="form-control bg-light" name="resp_rate_post" id="resp_rate_post">
				</div>
				<div class="col-md-2 mb-2">
					<label for="vit_a_post"><small>Vitamin A</small></label>
					<select class="form-control bg-light" name="vit_a_post" id="vit_a_post"> 
			    		<option value="0">Select</option>
			    		<option value="yes">Yes</option>
			    		<option value="no">No</option>
			    	</select>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-2 mb-2">
					<label for="mother_state"><small>State</small></label>
					<select class="form-control bg-light" name="mother_state" id="mother_state"> 
			    		<option value="0">Select</option>
			    		<option value="Discharged">Discharged</option>
			    		<option value="Transferred">Transferred</option>
			    		<option value="Referred">Referred</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="transferred_to"><small>Transferred To</small></label>
					<input type="text" class="form-control bg-light" name="transferred_to" id="transferred_to">
				</div>
				<div class="col-md-2 mb-2">
					<label for="transferred_date"><small>Transferred Date</small></label>
					<input type="date" class="form-control bg-light" name="transferred_date" id="transferred_date">
				</div>
				<div class="col-md-2 mb-2">
					<label for="transferred_time"><small>Transferred Time</small></label>
					<input type="time" class="form-control bg-light" name="transferred_time" id="transferred_time">
				</div>
				<div class="col-md-4 mb-4">
					<label for="post_mother_comment"><small>Comment</small></label>
					<input type="text" class="form-control bg-light" name="post_mother_comment" id="post_mother_comment">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-2 mb-2">
					<label for="delivered_by"><small>Delivered By</small></label>
					<input type="text" class="form-control bg-light" name="delivered_by" id="delivered_by">
				</div>
				<div class="col-md-2 mb-2">
					<label for="designation"><small>Designation</small></label>
					<input type="text" class="form-control bg-light" name="designation" id="designation">
				</div>
				<div class="col-md-2 mb-2">
					<label for="delivered_date"><small>Date of Delivery</small></label>
					<input type="date" class="form-control bg-light" name="delivered_date" id="delivered_date">
				</div>
				<div class="col-md-2 mb-2">
					<label for="delivered_time"><small>Time of Delivery</small></label>
					<input type="time" class="form-control bg-light" name="delivered_time" id="delivered_time">
				</div>
				<div class="col-md-4 mb-4">
					<label for="final_comment"><small>Comment</small></label>
					<input type="text" class="form-control bg-light" name="final_comment" id="final_comment">
					<input type="text" class="form-control" name="delivery_id" id="delivery_id" hidden="true">
				</div>
			</div>
		</form>
		<div id="delivery_mother_table">
			
		</div>
			<div class="modal-footer">
				<div id="delivery_save_update">
					<button type="submit" id="delivery_save_btn" name="delivery_save_btn" class="btn btn-primary">Save</button>
				</div>
					<button type="button" class="btn btn-primary" id="delivery_update_btn" name="delivery_update_btn">Update</button>
					<button type="button" class="btn btn-primary" id="delivery_edit_btn" name="delivery_edit_btn">Edit</button>
					<button type="button" class="btn btn-secondary" id="delivery_cancel_btn">Cancel</button>
			</div>
	</div>
	<div id="children" class="tab-pane fade">
		<div class="form-row">
			<div class="col-md-2 mb-2">
			</div>
			<div class="col-md-8 mb-8">
			</div>
			<div class="col-md-2 mb-2">
				<button type="button" name="add_children_btn" id="add_children_btn" class="btn btn-block btn-secondary">Add Child</button>
			</div>
		</div>
		<div id="children_list_div">
			
		</div>
	</div>
	<div id="partograph" class="tab-pane fade">
		<ul class="nav nav-tabs">
			<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#fetal_heart_rate">Fetal Heart Rate</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#amniotic_fluid">Amniotic Fluid/Moulding</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cervix_descent">Cervix/Descent</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#contractions">Contractions</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#oxytocin">Oxytocin/Drugs</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pulse_bp">Pulse/BP</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#temperature">Temperature</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#urine">Urine</a></li>
		</ul>
		<div class="tab-content">
			<div id="fetal_heart_rate" class="tab-pane fade show active">
				<div class="form-row">
					<button type="button" name="add_fhr_btn" id="add_fhr_btn" class="btn btn-sm btn-primary">Add FHR</button>
				</div>
				<div class="form-row">
					<div id="parto_fhr_table" class="col-md-6 mb-6">

					</div>
					<div class="col-md-6 mb-6">

					</div>
				</div>
			</div>
			<div id="amniotic_fluid" class="tab-pane fade">
				<div class="form-row">
					<div class="col-md-6 mb-6">
						<button type="button" name="add_amniotic_btn" id="add_amniotic_btn" class="btn btn-sm btn-primary">Add Amniotic Fluid</button>
					</div>
					<div class="col-md-6 mb-6">
						<button type="button" name="add_moulding_btn" id="add_moulding_btn" class="btn btn-sm btn-primary">Add Moulding</button>
					</div>
				</div>
				<div class="form-row">
					<div id="parto_amniotic_table" class="col-md-6 mb-6">

					</div>
					<div id="parto_moulding_table" class="col-md-6 mb-6">

					</div>
				</div>
			</div>
			<div id="cervix_descent" class="tab-pane fade">
				<div class="form-row">
					<button type="button" name="add_cervix_descent_btn" id="add_cervix_descent_btn" class="btn btn-sm btn-primary">Add Cervix/Descent</button>
				</div>
				<div class="form-row">
					<div id="parto_cervix_descent_table" class="col-md-6 mb-6">

					</div>
					<div class="col-md-6 mb-6">

					</div>
				</div>
			</div>
			<div id="contractions" class="tab-pane fade">
				<div class="form-row">
					<button type="button" name="add_contractions_btn" id="add_contractions_btn" class="btn btn-sm btn-primary">Add Contractions</button>
				</div>
				<div class="form-row">
					<div id="parto_contractions_table" class="col-md-6 mb-6">

					</div>
					<div class="col-md-6 mb-6">

					</div>
				</div>
			</div>
			<div id="oxytocin" class="tab-pane fade">
				<div class="form-row">
					<div class="col-md-6 mb-6">
						<button type="button" name="add_oxytocin_btn" id="add_oxytocin_btn" class="btn btn-sm btn-primary">Add Oxytocin</button>
					</div>
					<div class="col-md-6 mb-6">
						<button type="button" name="add_parto_drug_btn" id="add_parto_drug_btn" class="btn btn-sm btn-primary">Add Drug</button>
					</div>
				</div>
				<div class="form-row">
					<div id="parto_oxytocin_table" class="col-md-6 mb-6">

					</div>
					<div id="parto_drugs_table" class="col-md-6 mb-6">

					</div>
				</div>
			</div>
			<div id="pulse_bp" class="tab-pane fade">
				<div class="form-row">
					<button type="button" name="add_pulse_bp_btn" id="add_pulse_bp_btn" class="btn btn-sm btn-primary">Add Pulse/BP</button>
				</div>
				<div class="form-row">
					<div id="parto_pulse_bp_table" class="col-md-6 mb-6">

					</div>
					<div class="col-md-6 mb-6">

					</div>
				</div>
			</div>
			<div id="temperature" class="tab-pane fade">
				<div class="form-row">
					<button type="button" name="add_temp_btn" id="add_temp_btn" class="btn btn-sm btn-primary">Add Temp</button>
				</div>
				<div class="form-row">
					<div id="parto_temp_table" class="col-md-6 mb-6">

					</div>
					<div class="col-md-6 mb-6">

					</div>
				</div>
			</div>
			<div id="urine" class="tab-pane fade">
				<div class="form-row">
					<button type="button" name="add_urine_btn" id="add_urine_btn" class="btn btn-sm btn-primary">Add Urine</button>
				</div>
				<div class="form-row">
					<div id="parto_urine_table" class="col-md-6 mb-6">

					</div>
					<div class="col-md-6 mb-6">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="delivery_child_modal" tabindex="-1" role="dialog" aria-labelledby="delivery_child_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="delivery_child_modal_title">New Child Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
				<div class="modal-body">
					<form id="delivery_child_form" method="POST">
						<input type="hidden" class="form-control bg-light" name="delivery_id_c1" id="delivery_id_c1">
						<input type="hidden" class="form-control bg-light" name="child_id_c1" id="child_id_c1">
						<input type="hidden" class="form-control bg-light" name="preg_id_c1" id="preg_id_c1">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="date_c1"><small>Date</small></label>
								<input type="date" class="form-control bg-light" name="date_c1" id="date_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="time_c1"><small>Time</small></label>
								<input type="time" class="form-control bg-light" name="time_c1" id="time_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="sex_c1"><small>Sex</small></label>
								<select class="form-control bg-light" name="sex_c1" id="sex_c1"> 
						    		<option value="0">Please Select</option>
							        <?php
							        	$sql="SELECT * FROM gender";
										$result=mysqli_query($con,$sql);
							            while($row=mysqli_fetch_array($result))
							            {
							        ?>
							            <option value = "<?php echo($row['gender_id'])?>" >
							                <?php echo($row['gender']) ?>
							            </option>
							        <?php
							            }
							        ?>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="Mode_of_delivery_c1"><small>Mode Of Delivery (MOD)</small></label>
								<select class="form-control bg-light" name="Mode_of_delivery_c1" id="Mode_of_delivery_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="CAESARIAN_SECTION">CAESARIAN SECTION</option>
						    		<option value="FORCEPS">FORCEPS</option>
						    		<option value="NORMAL_SPONTANEOUS">NORMAL/SPONTANEOUS</option>
						    		<option value="VACCUM">VACCUM</option>
						    		<option value="OTHER">OTHER</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="presentation_c1"><small>Present. (if MOD is SPONT.)</small></label>
								<input type="text" class="form-control bg-light" name="presentation_c1" id="presentation_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="indication_c1"><small>Indication (if MOD is CS)</small></label>
								<input type="text" class="form-control bg-light" name="indication_c1" id="indication_c1">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="weight_c1"><small>Weight</small></label>
								<input type="text" class="form-control bg-light" name="weight_c1" id="weight_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="chest_circ_c1"><small>Chest Circum.(cm)</small></label>
								<input type="text" class="form-control bg-light" name="chest_circ_c1" id="chest_circ_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="head_circ_c1"><small>Head Circum.(cm)</small></label>
								<input type="text" class="form-control bg-light" name="head_circ_c1" id="head_circ_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="length_c1"><small>Length</small></label>
								<input type="text" class="form-control bg-light" name="length_c1" id="length_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="resp_rate_30min_c1"><small>Resp. Rate within 30min</small></label>
								<input type="text" class="form-control bg-light" name="resp_rate_30min_c1" id="resp_rate_30min_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="inj_vit_k_c1"><small>Inject Vitamin K</small></label>
								<select class="form-control bg-light" name="inj_vit_k_c1" id="inj_vit_k_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="yes">Yes</option>
						    		<option value="no">No</option>
						    	</select>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="breastfeeding_c1"><small>Breast Feeding within 30min</small></label>
								<select class="form-control bg-light" name="breastfeeding_c1" id="breastfeeding_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="yes">Yes</option>
						    		<option value="no">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="initiated_skin_to_skin_c1"><small>Initiated skin to skin</small></label>
								<select class="form-control bg-light" name="initiated_skin_to_skin_c1" id="initiated_skin_to_skin_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="yes">Yes</option>
						    		<option value="no">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="breath_cry_c1"><small>Breathing/Cry at birth</small></label>
								<select class="form-control bg-light" name="breath_cry_c1" id="breath_cry_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="yes">Yes</option>
						    		<option value="no">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="resuscitation_c1"><small>Resuscitation</small></label>
								<select class="form-control bg-light" name="resuscitation_c1" id="resuscitation_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="none">None</option>
						    		<option value="Stimulation_and_Suction">Stimulation and Suction</option>
						    		<option value="Bag_and_Mask_Ventilation">Bag and Mask Ventilation</option>
						    		<option value="Chest_Compression">Chest Compression</option>
						    		<option value="Endotracheal_Tube_Ventilation">Endotracheal Tube Ventilation</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="meconium_pass_c1"><small>Meconium Passed</small></label>
								<select class="form-control bg-light" name="meconium_pass_c1" id="meconium_pass_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="yes">Yes</option>
						    		<option value="no">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="urine_pass_c1"><small>Urine Passed</small></label>
								<select class="form-control bg-light" name="urine_pass_c1" id="urine_pass_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="yes">Yes</option>
						    		<option value="no">No</option>
						    	</select>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="eye_care_c1"><small>Eye Care</small></label>
								<select class="form-control bg-light" name="eye_care_c1" id="eye_care_c1">  
							    	<option value="0">Please Select</option>
						    		<option value="None">None</option>
						    		<option value="Chloramphenicol">Chloramphenicol</option>
						    		<option value="Tetracycline">Tetracycline</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="cord_care_c1"><small>Cord Care</small></label>
								<select class="form-control bg-light" name="cord_care_c1" id="cord_care_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="M_Spirit">M. Spirit</option>
						    		<option value="None">None</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="birth_outcome_c1"><small>Birth Outcome</small></label>
								<select class="form-control bg-light" name="birth_outcome_c1" id="birth_outcome_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="Alive">Alive</option>
						    		<option value="Dead">Dead</option>
						    		<option value="Birth_Asphyxia">Birth Asphyxia</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="maturity_c1"><small>Maturity</small></label>
								<select class="form-control bg-light" name="maturity_c1" id="maturity_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="yes">Yes</option>
						    		<option value="no">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="vacuum_assisted_c1"><small>Vacuum Assisted</small></label>
								<select class="form-control bg-light" name="vacuum_assisted_c1" id="vacuum_assisted_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="yes">Yes</option>
						    		<option value="no">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="infant_arv_c1"><small>Infant ARV</small></label>
								<select class="form-control bg-light" name="infant_arv_c1" id="infant_arv_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="yes">Yes</option>
						    		<option value="no">No</option>
						    	</select>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label for="birth_complications_c1"><small>Birth Complication</small></label>
								<select class="form-control bg-light" name="birth_complications_c1" id="birth_complications_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="Asphyxia">Asphyxia</option>
						    		<option value="Jaundice">Jaundice</option>
						    		<option value="Sepsis_of_Cord">Sepsis of Cord</option>
						    		<option value="Ophthalmia_Neonatorium">Ophthalmia Neonatorium</option>
						    		<option value="Others">Others</option>
						    	</select>
							</div>
							<div class="col-md-3 mb-3">
								<label for="other_complications_c1"><small>Other Complication</small></label>
								<input type="textarea" rows="2"  class="form-control bg-light" name="other_complications_c1" id="other_complications_c1" value="">
							</div>
							<div class="col-md-3 mb-3">
								<label for="birth_abnormalities_c1"><small>Birth Abnormalities</small></label>
								<select class="form-control bg-light" name="birth_abnormalities_c1" id="birth_abnormalities_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="Hare_lip_Cleft_palate">Hare lip/Cleft palate</option>
						    		<option value="Anencephaly">Anencephaly</option>
						    		<option value="Talipes">Talipes</option>
						    		<option value="Hydrocephalus">Hydrocephalus</option>
						    		<option value="Undescended Testes">Undescended Testes</option>
						    		<option value="Spina Bifida">Spina Bifida</option>
						    		<option value="Exomphalus">Exomphalus</option>
						    		<option value="Downs_syndrome">Downs syndrome</option>
						    		<option value="Imperforate_Anus">Imperforate Anus</option>
						    		<option value="Others">Others</option>
						    	</select>
							</div>
							<div class="col-md-3 mb-3">
								<label for="other_abnormalities_c1"><small>Other Abnormalities</small></label>
								<input type="textarea" rows="2"  class="form-control bg-light" name="other_abnormalities_c1" id="other_abnormalities_c1" value="">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="attendant_c1"><small>Attendant</small></label>
								<select class="form-control bg-light" name="attendant_c1" id="attendant_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="yes">Yes</option>
						    		<option value="no">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="duration_stage_1_c1"><small>Duration Stage 1</small></label>
								<input type="text" class="form-control bg-light" name="duration_stage_1_c1" id="duration_stage_1_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="duration_stage_2_c1"><small>Duration Stage 2</small></label>
								<input type="text" class="form-control bg-light" name="duration_stage_2_c1" id="duration_stage_2_c1">
							</div>
							<div class="col-md-6 mb-6">
								<label for="remarks_c1"><small>Remarks</small></label>
								<input type="text" class="form-control bg-light" name="remarks_c1" id="remarks_c1">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-6 mb-6">
								<h5>APGAR SCORE @ 1 MIN</h5>
								<div class="form-row">
									<div class="col-md-8 mb-8">
										<label for="apgar_colour_1_c1"><small>Colour</small></label>
										<select class="form-control bg-light" name="apgar_colour_1_c1" id="apgar_colour_1_c1"> 
								    		<option value="0">Please Select</option>
								    		<option value="PINK_ALL_OVER">PINK ALL OVER</option>
								    		<option value="PINK_LIPS_BLUE_HANDS_AND_FEET">PINK LIPS, BLUE HANDS AND FEET</option>
								    		<option value="BLUE_ALL_OVER">BLUE ALL OVER</option>
								    	</select>
									</div>
									<div class="col-md-3 mb-3">
										<label for="apgar_colour_score_1_c1"><small>Colour Score</small></label>
										<input type="text" class="form-control" name="apgar_colour_score_1_c1" id="apgar_colour_score_1_c1" hidden="true">
										<input type="text" class="form-control" name="apgar_colour_score_1_c1_h" id="apgar_colour_score_1_c1_h" disabled="true">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-8 mb-8">
										<label for="apgar_heart_rate_1_c1"><small>Heart Rate</small></label>
										<select class="form-control bg-light" name="apgar_heart_rate_1_c1" id="apgar_heart_rate_1_c1"> 
								    		<option value="0">Please Select</option>
								    		<option value="MORE_THAN_100">MORE THAN 100</option>
								    		<option value="LESS_THAN_100">LESS THAN 100</option>
								    		<option value="NONE">NONE</option>
								    	</select>
									</div>
									<div class="col-md-3 mb-3">
										<label for="apgar_heart_rate_score_1_c1"><small>Heart Rate Score</small></label>
										<input type="text" class="form-control" name="apgar_heart_rate_score_1_c1" id="apgar_heart_rate_score_1_c1" hidden="true">
										<input type="text" class="form-control" name="apgar_heart_rate_score_1_c1_h" id="apgar_heart_rate_score_1_c1_h" disabled="true">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-8 mb-8">
										<label for="apgar_breathing_1_c1"><small>Breathing</small></label>
										<select class="form-control bg-light" name="apgar_breathing_1_c1" id="apgar_breathing_1_c1"> 
								    		<option value="0">Please Select</option>
								    		<option value="REGULAR">REGULAR</option>
								    		<option value="IRREGULAR_GASPING">IRREGULAR/GASPING</option>
								    		<option value="NONE">NONE</option>
								    	</select>
									</div>
									<div class="col-md-3 mb-3">
										<label for="apgar_breathing_score_1_c1"><small>Breathing Score</small></label>
										<input type="text" class="form-control" name="apgar_breathing_score_1_c1" id="apgar_breathing_score_1_c1" hidden="true">
										<input type="text" class="form-control" name="apgar_breathing_score_1_c1_h" id="apgar_breathing_score_1_c1_h" disabled="true">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-8 mb-8">
										<label for="apgar_movement_1_c1"><small>Movement</small></label>
										<select class="form-control bg-light" name="apgar_movement_1_c1" id="apgar_movement_1_c1"> 
								    		<option value="0">Please Select</option>
								    		<option value="ACTIVE">ACTIVE</option>
								    		<option value="LITTLE">LITTLE</option>
								    		<option value="FLOPP_NONE">FLOPP/NONE</option>
								    	</select>
									</div>
									<div class="col-md-3 mb-3">
										<label for="apgar_movement_score_1_c1"><small>Movement Score</small></label>
										<input type="text" class="form-control" name="apgar_movement_score_1_c1" id="apgar_movement_score_1_c1" hidden="true">
										<input type="text" class="form-control" name="apgar_movement_score_1_c1_h" id="apgar_movement_score_1_c1_h" disabled="true">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-8 mb-8">
										<label for="apgar_response_1_c1"><small>Response</small></label>
										<select class="form-control bg-light" name="apgar_response_1_c1" id="apgar_response_1_c1"> 
								    		<option value="0">Please Select</option>
								    		<option value="CRIES">CRIES</option>
								    		<option value="COUGH_WHEN_SUCKED">COUGH WHEN SUCKED</option>
								    		<option value="NO_RESPONSE_TO_SUCTION_TO_NASAL">NO RESPONSE TO SUCTION TO NASAL</option>
								    	</select>
									</div>
									<div class="col-md-3 mb-3">
										<label for="apgar_response_score_1_c1"><small>Response Score</small></label>
										<input type="text" class="form-control" name="apgar_response_score_1_c1" id="apgar_response_score_1_c1" hidden="true">
										<input type="text" class="form-control" name="apgar_response_score_1_c1_h" id="apgar_response_score_1_c1_h" disabled="true">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-8 mb-8">
										<h6>TOTAL</h6>
									</div>
									<div class="col-md-3 mb-3">
										<input type="text" class="form-control" name="apgar_total_1_c1" id="apgar_total_1_c1" hidden="true">
										<input type="text" class="form-control" name="apgar_total_1_c1_h" id="apgar_total_1_c1_h" disabled="true">
									</div>
								</div>
							</div>
							<div class="col-md-6 mb-6">
								<h5>APGAR SCORE @ 5 MIN</h5>
								<div class="form-row">
									<div class="col-md-8 mb-8">
										<label for="apgar_colour_5_c1"><small>Colour</small></label>
										<select class="form-control bg-light" name="apgar_colour_5_c1" id="apgar_colour_5_c1"> 
								    		<option value="0">Please Select</option>
								    		<option value="PINK_ALL_OVER">PINK ALL OVER</option>
								    		<option value="PINK_LIPS_BLUE_HANDS_AND_FEET">PINK LIPS, BLUE HANDS AND FEET</option>
								    		<option value="BLUE_ALL_OVER">BLUE ALL OVER</option>
								    	</select>
									</div>
									<div class="col-md-3 mb-3">
										<label for="apgar_colour_score_5_c1"><small>Colour Score</small></label>
										<input type="text" class="form-control" name="apgar_colour_score_5_c1" id="apgar_colour_score_5_c1" hidden="true">
										<input type="text" class="form-control" name="apgar_colour_score_5_c1_h" id="apgar_colour_score_5_c1_h" disabled="true">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-8 mb-8">
										<label for="apgar_heart_rate_5_c1"><small>Heart Rate</small></label>
										<select class="form-control bg-light" name="apgar_heart_rate_5_c1" id="apgar_heart_rate_5_c1"> 
								    		<option value="0">Please Select</option>
								    		<option value="MORE_THAN_100">MORE THAN 100</option>
								    		<option value="LESS_THAN_100">LESS THAN 100</option>
								    		<option value="NONE">NONE</option>
								    	</select>
									</div>
									<div class="col-md-3 mb-3">
										<label for="apgar_heart_rate_score_5_c1"><small>Heart Rate Score</small></label>
										<input type="text" class="form-control" name="apgar_heart_rate_score_5_c1" id="apgar_heart_rate_score_5_c1" hidden="ture">
										<input type="text" class="form-control" name="apgar_heart_rate_score_5_c1_h" id="apgar_heart_rate_score_5_c1_h" disabled="true">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-8 mb-8">
										<label for="apgar_breathing_5_c1"><small>Breathing</small></label>
										<select class="form-control bg-light" name="apgar_breathing_5_c1" id="apgar_breathing_5_c1"> 
								    		<option value="0">Please Select</option>
								    		<option value="REGULAR">REGULAR</option>
								    		<option value="IRREGULAR_GASPING">IRREGULAR/GASPING</option>
								    		<option value="NONE">NONE</option>
								    	</select>
									</div>
									<div class="col-md-3 mb-3">
										<label for="apgar_breathing_score_5_c1"><small>Breathing Score</small></label>
										<input type="text" class="form-control" name="apgar_breathing_score_5_c1" id="apgar_breathing_score_5_c1" hidden="true">
										<input type="text" class="form-control" name="apgar_breathing_score_5_c1_h" id="apgar_breathing_score_5_c1_h" disabled="true">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-8 mb-8">
										<label for="apgar_movement_5_c1"><small>Movement</small></label>
										<select class="form-control bg-light" name="apgar_movement_5_c1" id="apgar_movement_5_c1"> 
								    		<option value="0">Please Select</option>
								    		<option value="ACTIVE">ACTIVE</option>
								    		<option value="LITTLE">LITTLE</option>
								    		<option value="FLOPP_NONE">FLOPP/NONE</option>
								    	</select>
									</div>
									<div class="col-md-3 mb-3">
										<label for="apgar_movement_score_5_c1"><small>Movement Score</small></label>
										<input type="text" class="form-control" name="apgar_movement_score_5_c1" id="apgar_movement_score_5_c1" hidden="true">
										<input type="text" class="form-control" name="apgar_movement_score_5_c1_h" id="apgar_movement_score_5_c1_h" disabled="true">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-8 mb-8">
										<label for="apgar_response_5_c1"><small>Response</small></label>
										<select class="form-control bg-light" name="apgar_response_5_c1" id="apgar_response_5_c1"> 
								    		<option value="0">Please Select</option>
								    		<option value="CRIES">CRIES</option>
								    		<option value="COUGH_WHEN_SUCKED">COUGH WHEN SUCKED</option>
								    		<option value="NO_RESPONSE_TO_SUCTION_TO_NASAL">NO RESPONSE TO SUCTION TO NASAL</option>
								    	</select>
									</div>
									<div class="col-md-3 mb-3">
										<label for="apgar_response_score_5_c1"><small>Response Score</small></label>
										<input type="text" class="form-control" name="apgar_response_score_5_c1" id="apgar_response_score_5_c1" hidden="true">
										<input type="text" class="form-control" name="apgar_response_score_5_c1_h" id="apgar_response_score_5_c1_h" disabled="true">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-8 mb-8">
										<h6>TOTAL</h6>
									</div>
									<div class="col-md-3 mb-3">
										<input type="text" class="form-control" name="apgar_total_5_c1" id="apgar_total_5_c1" hidden="true">
										<input type="text" class="form-control" name="apgar_total_5_c1_h" id="apgar_total_5_c1_h" disabled="true">
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<h5 class="modal-title m-0 font-weight-bold text-primary">Post Delivery</h5>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="breast_feeding_c1"><small>Breast Feeding</small></label>
								<select class="form-control bg-light" name="breast_feeding_c1" id="breast_feeding_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="yes">Yes</option>
						    		<option value="no">No</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="colour_c1"><small>Colour</small></label>
								<input type="text" class="form-control bg-light" name="colour_c1" id="colour_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="heart_rate_c1"><small>Heart Rate</small></label>
								<input type="text" class="form-control bg-light" name="heart_rate_c1" id="heart_rate_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="temp_c1"><small>Temp</small></label>
								<input type="text" class="form-control bg-light" name="temp_c1" id="temp_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="resp_rate_c1"><small>Respiratory Rate</small></label>
								<input type="text" class="form-control bg-light" name="resp_rate_c1" id="resp_rate_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="state_c1"><small>State</small></label>
								<select class="form-control bg-light" name="state_c1" id="state_c1"> 
						    		<option value="0">Please Select</option>
						    		<option value="Discharged">Discharged</option>
						    		<option value="Transferred">Transferred</option>
						    		<option value="Referred">Referred</option>
						    	</select>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="transferred_to_c1"><small>Transferred To</small></label>
								<input type="text" class="form-control bg-light" name="transferred_to_c1" id="transferred_to_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="transferred_date_c1"><small>Transferred Date</small></label>
								<input type="date" class="form-control bg-light" name="transferred_date_c1" id="transferred_date_c1">
							</div>
							<div class="col-md-2 mb-2">
								<label for="transferred_time_c1"><small>Transferred Time</small></label>
								<input type="time" class="form-control bg-light" name="transferred_time_c1" id="transferred_time_c1">
							</div>
							<div class="col-md-6 mb-6">
								<label for="comment_c1"><small>Comment</small></label>
								<input type="text" class="form-control bg-light" name="comment_c1" id="comment_c1">
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<div id="delivery_child_save_update">
						<button type="submit" name="delivery_child_save_btn" id="delivery_child_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="submit" name="delivery_child_update_btn" id="delivery_child_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="parto_fhr_modal" tabindex="-1" role="dialog" aria-labelledby="parto_fhr_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="parto_fhr_modal_title">Partograph - Fetal Heart Rate</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="parto_fhr_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="parto_fhr_date">Date</label>
								<input type="date" name="parto_fhr_date" class="form-control" id="parto_fhr_date">
								<input type="hidden" name="parto_fhr_id" class="form-control" id="parto_fhr_id">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_fhr_time">Time</label>
								<input type="time" name="parto_fhr_time" class="form-control" id="parto_fhr_time">
							</div>
							<div class="col-md-3 mb-3">
								<label for="parto_fhr_value">Fetal Heart Rate</label>
								<input type="text" name="parto_fhr_value" class="form-control" id="parto_fhr_value">
							</div>
							<div class="col-md-5 mb-5">
								<label for="parto_fhr_read_by">Read by</label>
								<input type="text" name="parto_fhr_read_by" class="form-control" id="parto_fhr_read_by">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="parto_fhr_remarks">Remarks</label>
								<textarea row="3" name="parto_fhr_remarks" class="form-control" id="parto_fhr_remarks"></textarea> 
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="parto_fhr_save_update">
						<button type="submit" name="parto_fhr_save_btn" id="parto_fhr_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="submit" name="parto_fhr_update_btn" id="parto_fhr_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="parto_amniotic_modal" tabindex="-1" role="dialog" aria-labelledby="parto_amniotic_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="parto_amniotic_modal_title">Partograph - Amniotic Fluid</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="parto_amniotic_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="parto_amniotic_date">Date</label>
								<input type="date" name="parto_amniotic_date" class="form-control" id="parto_amniotic_date">
								<input type="hidden" name="parto_amniotic_id" class="form-control" id="parto_amniotic_id">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_amniotic_time">Time</label>
								<input type="time" name="parto_amniotic_time" class="form-control" id="parto_amniotic_time">
							</div>
							<div class="col-md-3 mb-3">
								<label for="parto_amniotic_value">Amniotic Fluid</label>
								<select class="form-control bg-light" name="parto_amniotic_value" id="parto_amniotic_value"> 
						    		<option value="0">Please Select</option>
						    		<option value="I">I</option>
						    		<option value="C">C</option>
						    		<option value="M">M</option>
						    		<option value="B">B</option>
						    		<option value="A">A</option>
						    	</select>
							</div>
							<div class="col-md-5 mb-5">
								<label for="parto_amniotic_read_by">Read by</label>
								<input type="text" name="parto_amniotic_read_by" class="form-control" id="parto_amniotic_read_by">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="parto_amniotic_remarks">Remarks</label>
								<textarea row="3" name="parto_amniotic_remarks" class="form-control" id="parto_amniotic_remarks"></textarea> 
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="parto_amniotic_save_update">
						<button type="submit" name="parto_amniotic_save_btn" id="parto_amniotic_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="submit" name="parto_amniotic_update_btn" id="parto_amniotic_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="parto_moulding_modal" tabindex="-1" role="dialog" aria-labelledby="parto_moulding_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="parto_moulding_modal_title">Partograph - Moulding</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="parto_moulding_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="parto_moulding_date">Date</label>
								<input type="date" name="parto_moulding_date" class="form-control" id="parto_moulding_date">
								<input type="hidden" name="parto_moulding_id" class="form-control" id="parto_moulding_id">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_moulding_time">Time</label>
								<input type="time" name="parto_moulding_time" class="form-control" id="parto_moulding_time">
							</div>
							<div class="col-md-3 mb-3">
								<label for="parto_moulding_value">Moulding</label>
								<select class="form-control bg-light" name="parto_moulding_value" id="parto_moulding_value"> 
						    		<option value="">Please Select</option>
						    		<option value="0">0</option>
						    		<option value="1+">1+</option>
						    		<option value="2+">2+</option>
						    		<option value="3+">3+</option>
						    	</select>
							</div>
							<div class="col-md-5 mb-5">
								<label for="parto_moulding_read_by">Read by</label>
								<input type="text" name="parto_moulding_read_by" class="form-control" id="parto_moulding_read_by">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="parto_moulding_remarks">Remarks</label>
								<textarea row="3" name="parto_moulding_remarks" class="form-control" id="parto_moulding_remarks"></textarea> 
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="parto_moulding_save_update">
						<button type="submit" name="parto_moulding_save_btn" id="parto_moulding_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="submit" name="parto_moulding_update_btn" id="parto_moulding_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="parto_cervix_descent_modal" tabindex="-1" role="dialog" aria-labelledby="parto_cervix_descent_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="parto_cervix_descent_modal_title">Partograph - Cervix/Descent</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="parto_cervix_descent_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="parto_cd_date">Date</label>
								<input type="date" name="parto_cd_date" class="form-control" id="parto_cd_date">
								<input type="hidden" name="parto_cd_id" class="form-control" id="parto_cd_id">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_cd_time">Time</label>
								<input type="time" name="parto_cd_time" class="form-control" id="parto_cd_time">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_cd_cervix_">Cervix</label>
								<input type="text" name="parto_cd_cervix_" class="form-control" id="parto_cd_cervix_">
							</div>
							<div class="col-md-3 mb-3">
								<label for="parto_cd_descent">Descent</label>
								<select class="form-control bg-light" name="parto_cd_descent" id="parto_cd_descent"> 
						    		<option value="">Please Select</option>
						    		<option value="0">0</option>
						    		<option value="1">1</option>
						    		<option value="2">2</option>
						    		<option value="3">3</option>
						    		<option value="4">4</option>
						    		<option value="5">5</option>
						    	</select>
							</div>
							<div class="col-md-3 mb-3">
								<label for="parto_cd_read_by">Read by</label>
								<input type="text" name="parto_cd_read_by" class="form-control" id="parto_cd_read_by">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="parto_cd_remarks">Remarks</label>
								<textarea row="3" name="parto_cd_remarks" class="form-control" id="parto_cd_remarks"></textarea> 
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="parto_cd_save_update">
						<button type="submit" name="parto_cd_save_btn" id="parto_cd_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="submit" name="parto_cd_update_btn" id="parto_cd_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="parto_contractions_modal" tabindex="-1" role="dialog" aria-labelledby="parto_contractions_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="parto_contractions_modal_title">Partograph - Contractions</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="parto_contractions_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="parto_contra_date">Date</label>
								<input type="date" name="parto_contra_date" class="form-control" id="parto_contra_date">
								<input type="hidden" name="parto_contra_id" class="form-control" id="parto_contra_id">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_contra_time">Time</label>
								<input type="time" name="parto_contra_time" class="form-control" id="parto_contra_time">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_contra_less20">Less than 20</label>
								<input type="text" name="parto_contra_less20" class="form-control" id="parto_contra_less20">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_contra_2040">20 to 40</label>
								<input type="text" name="parto_contra_2040" class="form-control" id="parto_contra_2040">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_contra_more40">More than 40</label>
								<input type="text" name="parto_contra_more40" class="form-control" id="parto_contra_more40">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_contra_read_by">Read by</label>
								<input type="text" name="parto_contra_read_by" class="form-control" id="parto_contra_read_by">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="parto_contra_remarks">Remarks</label>
								<textarea row="3" name="parto_contra_remarks" class="form-control" id="parto_contra_remarks"></textarea> 
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="parto_contra_save_update">
						<button type="submit" name="parto_contra_save_btn" id="parto_contra_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="submit" name="parto_contra_update_btn" id="parto_contra_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="parto_oxytocin_modal" tabindex="-1" role="dialog" aria-labelledby="parto_oxytocin_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="parto_oxytocin_modal_title">Partograph - Oxytocin</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="parto_oxytocin_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="parto_oxy_date">Date</label>
								<input type="date" name="parto_oxy_date" class="form-control" id="parto_oxy_date">
								<input type="hidden" name="parto_oxy_id" class="form-control" id="parto_oxy_id">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_oxy_time">Time</label>
								<input type="time" name="parto_oxy_time" class="form-control" id="parto_oxy_time">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_oxy_vol">Volume</label>
								<input type="text" name="parto_oxy_vol" class="form-control" id="parto_oxy_vol">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_oxy_drops">Drop/min</label>
								<input type="text" name="parto_oxy_drops" class="form-control" id="parto_oxy_drops">
							</div>
							<div class="col-md-4 mb-4">
								<label for="parto_oxy_read_by">Read by</label>
								<input type="text" name="parto_oxy_read_by" class="form-control" id="parto_oxy_read_by">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="parto_oxy_remarks">Remarks</label>
								<textarea row="3" name="parto_oxy_remarks" class="form-control" id="parto_oxy_remarks"></textarea> 
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="parto_oxy_save_update">
						<button type="submit" name="parto_oxy_save_btn" id="parto_oxy_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="submit" name="parto_oxy_update_btn" id="parto_oxy_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="parto_drugs_modal" tabindex="-1" role="dialog" aria-labelledby="parto_drugs_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="parto_drugs_modal_title">Partograph - Drugs</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="parto_drugs_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="parto_drug_date">Date</label>
								<input type="date" name="parto_drug_date" class="form-control" id="parto_drug_date">
								<input type="hidden" name="parto_drug_id" class="form-control" id="parto_drug_id">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_drug_time">Time</label>
								<input type="time" name="parto_drug_time" class="form-control" id="parto_drug_time">
							</div>
							<div class="col-md-3 mb-3">
								<label for="parto_drug_name">Drug</label>
								<input type="text" name="parto_drug_name" class="form-control" id="parto_drug_name">
							</div>
							<div class="col-md-1 mb-1">
								<label for="parto_drug_qty">Qty</label>
								<input type="text" name="parto_drug_qty" class="form-control" id="parto_drug_qty">
							</div>
							<div class="col-md-4 mb-4">
								<label for="parto_drug_read_by">Read by</label>
								<input type="text" name="parto_drug_read_by" class="form-control" id="parto_drug_read_by">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="parto_drug_remarks">Remarks</label>
								<textarea row="3" name="parto_drug_remarks" class="form-control" id="parto_drug_remarks"></textarea> 
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="parto_drug_save_update">
						<button type="submit" name="parto_drug_save_btn" id="parto_drug_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="submit" name="parto_drug_update_btn" id="parto_drug_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="parto_pulse_bp_modal" tabindex="-1" role="dialog" aria-labelledby="parto_pulse_bp_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="parto_pulse_bp_modal_title">Partograph - Pulse/BP</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="parto_pulse_bp_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="parto_pbp_date">Date</label>
								<input type="date" name="parto_pbp_date" class="form-control" id="parto_pbp_date">
								<input type="hidden" name="parto_pbp_id" class="form-control" id="parto_pbp_id">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_pbp_time">Time</label>
								<input type="time" name="parto_pbp_time" class="form-control" id="parto_pbp_time">
							</div>
							<div class="col-md-1 mb-1">
								<label for="parto_pbp_pulse">Pulse</label>
								<input type="text" name="parto_pbp_pulse" class="form-control" id="parto_pbp_pulse">
							</div>
							<div class="col-md-1 mb-1">
								<label for="parto_pbp_systolic">BP - Syst.</label>
								<input type="text" name="parto_pbp_systolic" class="form-control" id="parto_pbp_systolic">
							</div>
							<div class="col-md-1 mb-1">
								<label for="parto_pbp_diastolic">BP - Diast.</label>
								<input type="text" name="parto_pbp_diastolic" class="form-control" id="parto_pbp_diastolic">
							</div>
							<div class="col-md-5 mb-5">
								<label for="parto_pbp_read_by">Read by</label>
								<input type="text" name="parto_pbp_read_by" class="form-control" id="parto_pbp_read_by">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="parto_pbp_remarks">Remarks</label>
								<textarea row="3" name="parto_pbp_remarks" class="form-control" id="parto_pbp_remarks"></textarea> 
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="parto_pbp_save_update">
						<button type="submit" name="parto_pbp_save_btn" id="parto_pbp_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="submit" name="parto_pbp_update_btn" id="parto_pbp_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="parto_temp_modal" tabindex="-1" role="dialog" aria-labelledby="parto_temp_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="parto_temp_modal_title">Partograph - Temperature</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="parto_temp_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="parto_temp_date">Date</label>
								<input type="date" name="parto_temp_date" class="form-control" id="parto_temp_date">
								<input type="hidden" name="parto_temp_id" class="form-control" id="parto_temp_id">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_temp_time">Time</label>
								<input type="time" name="parto_temp_time" class="form-control" id="parto_temp_time">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_temp">Temp</label>
								<input type="text" name="parto_temp" class="form-control" id="parto_temp">
							</div>
							<div class="col-md-6 mb-6">
								<label for="parto_temp_read_by">Read by</label>
								<input type="text" name="parto_temp_read_by" class="form-control" id="parto_temp_read_by">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="parto_temp_remarks">Remarks</label>
								<textarea row="3" name="parto_temp_remarks" class="form-control" id="parto_temp_remarks"></textarea> 
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="parto_temp_save_update">
						<button type="submit" name="parto_temp_save_btn" id="parto_temp_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="submit" name="parto_temp_update_btn" id="parto_temp_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="parto_urine_modal" tabindex="-1" role="dialog" aria-labelledby="parto_urine_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="parto_urine_modal_title">Partograph - Urine</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="parto_urine_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="parto_urine_date">Date</label>
								<input type="date" name="parto_urine_date" class="form-control" id="parto_urine_date">
								<input type="hidden" name="parto_urine_id" class="form-control" id="parto_urine_id">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_urine_time">Time</label>
								<input type="time" name="parto_urine_time" class="form-control" id="parto_urine_time">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_urine_protein">Protein</label>
								<input type="text" name="parto_urine_protein" class="form-control" id="parto_urine_protein">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_urine_acetone">Acetone</label>
								<input type="text" name="parto_urine_acetone" class="form-control" id="parto_urine_acetone">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_urine_sugar">Sugar</label>
								<input type="text" name="parto_urine_sugar" class="form-control" id="parto_urine_sugar">
							</div>
							<div class="col-md-2 mb-2">
								<label for="parto_urine_volume">Volume</label>
								<input type="text" name="parto_urine_volume" class="form-control" id="parto_urine_volume">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-4 mb-4">
								<label for="parto_urine_read_by">Read by</label>
								<input type="text" name="parto_urine_read_by" class="form-control" id="parto_urine_read_by">
							</div>
							<div class="col-md-8 mb-8">
								<label for="parto_urine_remarks">Remarks</label>
								<textarea row="3" name="parto_urine_remarks" class="form-control" id="parto_urine_remarks"></textarea> 
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="parto_urine_save_update">
						<button type="submit" name="parto_urine_save_btn" id="parto_urine_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="submit" name="parto_urine_update_btn" id="parto_urine_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>