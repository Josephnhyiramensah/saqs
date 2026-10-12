<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
    
    $query = "SELECT * FROM vitals WHERE attend_id='$attend_id' ORDER BY date DESC, time DESC";
    $query_run = mysqli_query($con, $query);

	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
?>
	<div id="vitals">
		<ul class="nav nav-tabs">
			<li class="nav-item active"><a class="nav-link" aria-current="page" data-toggle="tab" href="#vitals_input">Input Vitals</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#fluid_data">Fluid Balance Data</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cvd">CVD</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#chart">Charts</a></li>
			<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#past" id="vitals_history_icon">Past Vitals</a></li>
		</ul>
		<div class="tab-content">
			<div id="vitals_input" class="tab-pane fade show active">
				<?php
        			if (
        				$_SESSION['user_type'] == 'Ultra_Super_User' OR 
        				$_SESSION['user_type'] == 'Super_User' OR 
        				($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Vitals'] == 'Yes')) 
			        {
			            echo '<div class="v_input">
								<form id="vitals_input_form" method="POST">
							      	<div class="form-row">
										<div class="col-md-2 mb-2>
											<label for="v_date">Date</label>
											<input type="date" class="form-control" name="v_date" id="v_date" value="'.$date.'">
										</div>
										<div class="col-md-2 mb-2>
											<label for="v_time">Time</label>
											<input type="time" class="form-control" name="v_time" id="v_time" value="'.$time.'">
										</div>
										<div class="col-md-2 mb-2>
											<label for="temp">Temp.</label>
											<input type="text" name="temp" class="form-control" id="temp" value="" required>
										</div>
										<div class="col-md-2 mb-2>
											<label for="bsystolic">Systolic</label>
											<input type="text" name="bsystolic" class="form-control" id="bsystolic" value="">
										</div>
										<div class="col-md-2 mb-2>
											<label for="bdiastolic">Diastolic</label>
											<input type="text" name="bdiastolic" class="form-control" id="bdiastolic" value="">
										</div>
										<div class="col-md-1 mb-1>
											<label for="pulse">Pulse</label>
											<input type="text" name="pulse" class="form-control" id="pulse" value="">
										</div>
										<div class="col-md-1 mb-1>
											<label for="fbs">FBS</label>
											<input type="text" name="fbs" class="form-control" id="fbs" value="">
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-2 mb-2>
											<label for="rrate">Resp. Rate</label>
											<input type="text" name="rrate" class="form-control" id="rrate" value="">
										</div>
										<div class="col-md-2 mb-2>
											<label for="weight">Weight (kg)</label>
											<input type="text" name="weight" class="form-control" id="weight" value="">
										</div>
										<div class="col-md-2 mb-2>
											<label for="height">Height (m)</label>
											<input type="text" class="form-control" name="height" id="height">
										</div>
										<div class="col-md-2 mb-2>
											<label for="oxygen">SpO<sub>2</sub></label>
											<input type="text" class="form-control" name="oxygen" id="oxygen">
										</div>
										<div class="col-md-2 mb-2>
											<label for="hipcirc">Hip Circ.</label>
											<input type="text" class="form-control" name="hipcirc" id="hipcirc">
										</div>
										<div class="col-md-1 mb-1>
											<label for="abdcirc">Abdo. Circ.</label>
											<input type="text" class="form-control" name="abdcirc" id="abdcirc">
										</div>
										<div class="col-md-1 mb-1>
											<label for="rbs">RBS</label>
											<input type="text" class="form-control" name="rbs" id="rbs">
										</div>
									</div>
									<!--<div id="cvd_risk_assessment_div">
										<div class="form-row">
											<div class="col-md-1 mb-1">
												<label for="cvd_chd">CHD</label>
												<input type="text" name="cvd_chd" class="form-control" id="cvd_chd" hidden="true">
												<input type="text" name="cvd_chd_d" class="form-control" id="cvd_chd_d" disabled ="true">
											</div>
											<div class="col-md-1 mb-1">
												<label for="cvd_mi">MI</label>
												<input type="text" name="cvd_mi" class="form-control" id="cvd_mi" hidden="true">
												<input type="text" name="cvd_mi_d" class="form-control" id="cvd_mi_d" disabled ="true">
											</div>
											<div class="col-md-2 mb-2">
												<label for="cvd_stroke">Stroke</label>
												<input type="text" name="cvd_stroke" class="form-control" id="cvd_stroke" hidden="true">
												<input type="text" name="cvd_stroke_d" class="form-control" id="cvd_stroke_d" disabled ="true">
											</div>
											<div class="col-md-1 mb-1">
												<label for="cvd_framingham">Framingham</label>
												<input type="text" name="cvd_framingham" class="form-control" id="cvd_framingham" hidden="true">
												<input type="text" name="cvd_framingham_d" class="form-control" id="cvd_framingham_d" disabled ="true">
											</div>
											<div class="col-md-1 mb-1">
												<label for="cvd_chd_death">CHD Death</label>
												<input type="text" class="form-control" name="cvd_chd_death" id="cvd_chd_death" hidden="true">
												<input type="text" class="form-control" name="cvd_chd_death_d" id="cvd_chd_death_d" disabled ="true">
											</div>
											<div class="col-md-2 mb-2">
												<label for="cvd_death">CVD Death</label>
												<input type="text" class="form-control" name="cvd_death" id="cvd_death" hidden="true">
												<input type="text" class="form-control" name="cvd_death_d" id="cvd_death_d" disabled ="true">
											</div>
											<div class="col-md-2 mb-2">
												<label for="cvd_bnf">BNF</label>
												<input type="text" class="form-control" name="cvd_bnf" id="cvd_bnf" hidden="true">
												<input type="text" class="form-control" name="cvd_bnf_d" id="cvd_bnf_d" disabled="true">
											</div>
											<div class="col-md-2 mb-2">
												<label for="cvd_assign">Assign</label>
												<input type="text" class="form-control" name="cvd_assign" id="cvd_assign" hidden="true">
												<input type="text" class="form-control" name="cvd_assign_d" id="cvd_assign_d" disabled="true">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2 mb-2">
												<label>PARAMETER</label>
											</div>
											<div class="col-md-2 mb-2">
												<label>VALUE</label>
											</div>
											<div class="col-md-8 mb-8">
												<label>NARRATION</label>
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" disabled ="true" value="Time Period">
											</div>
											<div class="col-md-2 mb-2">
												<input type="text" name="time_period" class="form-control" id="time_period" value="">
											</div>
											<div class="col-md-8 mb-8">
												<input type="text" class="form-control" disabled ="true" value="Time in years over which risk is calculated. Usually set to 10, appropriate range is 4 to 12 years. Does not affect ASSIGN calculation (which is always 10 years).">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" disabled ="true" value="Age">
											</div>
											<div class="col-md-2 mb-2">
												<input type="text" name="cvd_age" class="form-control" id="cvd_age" hidden="true" value="'.$_SESSION['age'].'">
												<input type="text" name="cvd_age_d" class="form-control" id="cvd_age_d" disabled ="true" value="'.$_SESSION['age'].'">
											</div>
											<div class="col-md-8 mb-8">
												<input type="text" class="form-control" disabled ="true" value="Patient age in years (try to limit to 35 to 75 years).">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" disabled ="true" value="Male(Gender)">
											</div>
											<div class="col-md-2 mb-2">
												<select class="form-control" name="cvd_male" id="cvd_male" hidden="true"> 
											    	<option value="">-Select-</option>
											    	<option value="1">Male</option>
											    	<option value="0">Female</option>
										    	</select>
										    	<select class="form-control" name="cvd_male_d" id="cvd_male_d" disabled ="true">';
										    		
										    			if($_SESSION['gender'] == 1)
										    			{
										    				echo '<option value="">-Select-</option>
															    	<option value="1" selected="selected">Male</option>
															    	<option value="0">Female</option>';
										    			}
										    			else
										    			{
										    				echo '<option value="">-Select-</option>
															    	<option value="1">Male</option>
															    	<option value="0" selected="selected">Female</option>';
										    			};
											    	
										    echo '</select>
											</div>
											<div class="col-md-8 mb-8">
												<input type="text" class="form-control" disabled ="true" value="Patient sex: male=1, female=0">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" disabled ="true" value="Smoking">
											</div>
											<div class="col-md-2 mb-2">
												<select class="form-control" name="smoking" id="smoking"> 
											    	<option value="">-Select-</option>
											    	<option value="1">Smoker</option>
											    	<option value="0">Non-Smoker</option>
										    	</select>
											</div>
											<div class="col-md-8 mb-8">
												<input type="text" class="form-control" disabled ="true" value="Smoking status: smoker=1, non-smoker=0. Does not affect ASSIGN score.">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" disabled ="true" value="Cigarette">
											</div>
											<div class="col-md-2 mb-2">
												<input type="text" name="cigarette" class="form-control" id="cigarette" value="">
											</div>
											<div class="col-md-8 mb-8">
												<input type="text" class="form-control" disabled ="true" value="Number of cigarettes smoked per day. Affects ASSIGN score only.">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" disabled ="true" value="Family_hx">
											</div>
											<div class="col-md-2 mb-2">
										    	<select class="form-control" name="family_hx" id="family_hx"> 
											    	<option value="">-Select-</option>
											    	<option value="1">Yes</option>
											    	<option value="0">No</option>
										    	</select>
											</div>
											<div class="col-md-8 mb-8">
												<input type="text" class="form-control" disabled ="true" value="Family history of premature cardiovascular disease: yes=1, no=0. Affects ASSIGN score only.">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" disabled ="true" value="Diabetes">
											</div>
											<div class="col-md-2 mb-2">
										    	<select class="form-control" name="diabetes" id="diabetes"> 
											    	<option value="">-Select-</option>
											    	<option value="1">Yes</option>
											    	<option value="0">No</option>
										    	</select>
											</div>
											<div class="col-md-8 mb-8">
												<input type="text" class="form-control" disabled ="true" value="Presence of diabetes: yes=1, no=0">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" disabled ="true" value="IVH">
											</div>
											<div class="col-md-2 mb-2">
										    	<select class="form-control" name="ivh" id="ivh"> 
											    	<option value="">-Select-</option>
											    	<option value="1">Yes</option>
											    	<option value="0">No</option>
										    	</select>
											</div>
											<div class="col-md-8 mb-8">
												<input type="text" class="form-control" disabled ="true" value="Presence of left ventricular hypertrophy on ECG: yes=1, no=0. Does not affect ASSIGN score.">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" disabled ="true" value="SIMD">
											</div>
											<div class="col-md-2 mb-2">
										    	<input type="text" class="form-control" name="simd" id="simd">
											</div>
											<div class="col-md-8 mb-8">
												<input type="text" class="form-control" disabled ="true" value="Scottish index of multiple deprivation. Usual range is 0.53 to 87.7. 20 is a reasonable default when unknown. Affects ASSIGN score only.">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" disabled ="true" value="Systolic_BP">
											</div>
											<div class="col-md-2 mb-2">
												<input type="text" name="bsystolic" class="form-control" id="bsystolic" value="">
											</div>
											<div class="col-md-8 mb-8">
												<input type="text" class="form-control" disabled ="true" value="Systolic blood pressure in mmHg">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" disabled ="true" value="Total Cholestrol">
											</div>
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" name="chol_tc" id="chol_tc">
											</div>
											<div class="col-md-8 mb-8">
												<input type="text" class="form-control" disabled ="true" value="Total cholesterol in mmol/L">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" disabled ="true" value="HDL Cholestrol">
											</div>
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" name="chol_hdl" id="chol_hdl">
											</div>
											<div class="col-md-8 mb-8">
												<input type="text" class="form-control" disabled ="true" value="HDL cholesterol in mmol/L">
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" disabled ="true" value="LDL Cholestrol">
											</div>
											<div class="col-md-2 mb-2">
												<input type="text" class="form-control" name="chol_ldl" id="chol_ldl">
											</div>
											<div class="col-md-8 mb-8">
												<input type="text" class="form-control" disabled ="true" value="LDL cholesterol in mmol/L">
											</div>
										</div>
									</div>-->
									<div class="form-row">
										<div class="col-md-12 mb-12">
											<label for="vitals_comment">Comment</label>
											<input type="hidden" name="vital_id" class="form-control" id="vital_id">
											<textarea type="textarea" rows="2"  class="form-control" name="vitals_comment" id="vitals_comment" value=""></textarea>
										</div>
									</div>
									<hr>
										<div class="col-md-2 mb-2" id="vital_save_update">
											<button type="submit" id="vitals_save_btn" class="btn btn-primary btn-block">Save</button>
										</div>	
								</form>
							</div>
							<hr class="d-none d-md-block">';
					};
				?>
				<div class="table-responsive" id="attend-vitals-table">
				    <table class="table table-hover table-bordered table-sm" id="attendTable" width="100%" cellspacing="0">
				        <thead>
				            <tr>
				                <th>Date</th>
				                <th>Time</th>
				                <th>Temp</th>
				                <th>BP</th>
				                <th>Pulse</th>
				                <th>R.Rate</th>
				                <th>Weight</th>
				                <th>Height</th>
				                <th>BMI</th>
				                <th>SpO<sub>2</sub></th>
				                <th>FBS</th>
				                <th>RBS</th>
				                <th>H.Circ.</th>
				                <th>A.Circ.</th>
				                <th>Comment</th>
				                <th>Action</th>
				            </tr>
				        </thead>
				        <tbody class="pv-table-body">
				            <?php
				                if (mysqli_num_rows($query_run) > 0)
				                {
				                    while($row=mysqli_fetch_assoc($query_run))
				                    {
										if($row['weight'] > 0 && $row['height'] > 0)
										{
											$bmi = round(($row['weight']/($row['height']*$row['height'])),2);
										}
										else
										{
											$bmi = 0;
										};
				            ?>
				                <tr>
				                    <td><?php echo $row['date'];?></td>
				                    <td><?php echo $row['time'];?></td>
				                    <td><?php echo $row['temp'];?></td>
				                    <td><?php echo $row['bp_systolic'];?>/<?php echo $row['bp_diastolic'];?></td>
				                    <td><?php echo $row['pulse'];?></td>
				                    <td><?php echo $row['resp_rate'];?></td>
				                    <td><?php echo $row['weight'];?></td>
				                    <td><?php echo $row['height'];?></td>
				                    <td><?php echo $bmi;?></td>
				                    <td><?php echo $row['oxygen_sat'];?></td>
				                    <td><?php echo $row['fbs'];?></td>
				                    <td><?php echo $row['rbs'];?></td>
				                    <td><?php echo $row['circ_hip'];?></td>
				                    <td><?php echo $row['circ_abdo'];?></td>
				                    <td><?php echo $row['comment'];?></td>
			                        <td>
				            <?php
				            	if ($_SESSION['user_id'] == $row['user_id']) 
								{
									if($row['date'] == $date_today)
									{
										if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Vitals'] == 'Yes')) 
										{
											echo '<a href="#" id="btn_edit_vital" data-id1="'.$row['vital_id'].'">Edit</a>';
										};
										if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Vitals'] == 'Yes')) 
										{
											echo ' | <a href="#" id="btn_delete_vital" data-id2="'.$row['vital_id'].'"> Delete</a>';
										};
									};
								};
				            ?>	
			                        </td>
				                </tr>
				            <?php
				                    }
				                };
				            ?>
				        </tbody>
				    </table>
				</div>
			</div>
			<div id="fluid_data" class="tab-pane fade">
				<?php
    $query_fluid = "SELECT * FROM fluid_data WHERE attend_id='$attend_id' ORDER BY date DESC";
    $query_run_fluid = mysqli_query($con, $query_fluid);
        			if (
        				$_SESSION['user_type'] == 'Ultra_Super_User' OR 
        				$_SESSION['user_type'] == 'Super_User' OR 
        				($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Vitals'] == 'Yes')) 
			        {
			            echo '<div class="v_input">
								<form id="fluid_data_form" method="POST">
							      	<div class="form-row">
										<div class="col-md-3 mb-3>
											<label for="fb_oral_input">Oral Input</label>
											<input type="text" name="fb_oral_input" class="form-control" id="fb_oral_input" value="">
											<input type="text" name="fluid_data_id" class="form-control" id="fluid_data_id" hidden>
										</div>
										<div class="col-md-2 mb-2>
											<label for="fb_oral_input_mls">Oral Input (mls)</label>
											<input type="text" name="fb_oral_input_mls" class="form-control" id="fb_oral_input_mls" value="">
										</div>
										<div class="col-md-3 mb-3>
											<label for="fb_ivi_input">IVI Input</label>
											<input type="text" name="fb_ivi_input" class="form-control" id="fb_ivi_input" value="">
										</div>
										<div class="col-md-2 mb-2>
											<label for="fb_ivi_input_mls">IVI Input (mls)</label>
											<input type="text" name="fb_ivi_input_mls" class="form-control" id="fb_ivi_input_mls" value="">
										</div>
										<div class="col-md-2 mb-2>
											<label for="fb_cum_input">Cum. Input</label>
											<input type="text" class="form-control" name="fb_cum_input" id="fb_cum_input" hidden>
											<input type="text" class="form-control" name="fb_cum_inputD" id="fb_cum_inputD" disabled>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-2 mb-2>
											<label for="fb_vomit">Vomit (mls)</label>
											<input type="text" name="fb_vomit" class="form-control" id="fb_vomit" value="">
										</div>
										<div class="col-md-2 mb-2>
											<label for="fb_urine">Urine (mls)</label>
											<input type="text" name="fb_urine" class="form-control" id="fb_urine" value="">
										</div>
										<div class="col-md-2 mb-2>
											<label for="fb_bowels">Bowels (mls)</label>
											<input type="text" class="form-control" name="fb_bowels" id="fb_bowels">
										</div>
										<div class="col-md-2 mb-2>
											<label for="fb_cum_output">Cum. Output</label>
											<input type="text" class="form-control" name="fb_cum_output" id="fb_cum_output" hidden>
											<input type="text" class="form-control" name="fb_cum_outputD" id="fb_cum_outputD" disabled>
										</div>
										<div class="col-md-2 mb-2>
											<label for="fd_date">Date</label>
											<input type="date" class="form-control" name="fd_date" id="fd_date" value="'.$date.'">
										</div>
										<div class="col-md-2 mb-2>
											<label for="fb_time">Time</label>
											<input type="time" class="form-control" name="fb_time" id="fb_time" value="'.$time.'">
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-12 mb-12>
											<label for="fb_comment">Comment</label>
											<input type="text" class="form-control" name="fb_comment" id="fb_comment">
										</div>
									</div>
									<hr>
										<div class="col-md-2 mb-2" id="fb_save_update">
											<button type="submit" id="fb_save_btn" class="btn btn-primary btn-block">Save</button>
										</div>	
								</form>
							</div>
							<hr class="d-none d-md-block">';
					};
				?>
				<div class="table-responsive" id="attend_fluid_data_table">
				    <table class="table table-hover table-bordered table-sm" id="attendfluidTable" width="100%" cellspacing="0">
				        <thead>
				            <tr>
				                <th>Date</th>
				                <th>Time</th>
				                <th>Oral Input</th>
				                <th>Oral (mls)</th>
				                <th>IVI Input</th>
				                <th>IVI (mls)</th>
				                <th>Cum. Input (mls)</th>
				                <th>Vomit (mls)</th>
				                <th>Urine (mls)</th>
				                <th>Bowels (mls)</th>
				                <th>Cum. Output (mls)</th>
				                <th>Action</th>
				            </tr>
				        </thead>
				        <tbody class="pv-table-body">
				            <?php
				                if (mysqli_num_rows($query_run_fluid) > 0)
				                {
				                    while($row_fluid=mysqli_fetch_assoc($query_run_fluid))
				                    {
				            ?>
				                <tr>
				                    <td><?php echo $row_fluid['date'];?></td>
				                    <td><?php echo $row_fluid['time'];?></td>
				                    <td><?php echo $row_fluid['oral_input'];?></td>
				                    <td><?php echo $row_fluid['oral_input_qty'];?></td>
				                    <td><?php echo $row_fluid['ivi_input'];?></td>
				                    <td><?php echo $row_fluid['ivi_input_qty'];?></td>
				                    <td><?php echo $row_fluid['cum_input'];?></td>
				                    <td><?php echo $row_fluid['vomit_qty'];?></td>
				                    <td><?php echo $row_fluid['urine_qty'];?></td>
				                    <td><?php echo $row_fluid['bowels_qty'];?></td>
				                    <td><?php echo $row_fluid['cum_output'];?></td>
			                        <td>
				            <?php
				            	if ($_SESSION['user_id'] == $row_fluid['user_id']) 
								{
									if($row_fluid['date'] == $date_today)
									{
										if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Vitals'] == 'Yes')) 
										{
											echo '<a href="#" id="btn_edit_fluid" data-id1="'.$row_fluid['fluid_data_id'].'">Edit</a>';
										};
										if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Vitals'] == 'Yes')) 
										{
											echo ' | <a href="#" id="btn_delete_fluid" data-id2="'.$row_fluid['fluid_data_id'].'"> Delete</a>';
										};
									};
								};
				            ?>	
			                        </td>
				                </tr>
				            <?php
				                    }
				                };
				            ?>
				        </tbody>
				    </table>
				</div>
			</div>
			<div id="cvd" class="tab-pane fade">
			    
			</div>
			<div id="chart" class="tab-pane fade">
			    <ul class="nav nav-tabs">
					<li class="nav-item active"><a class="nav-link" aria-current="page" data-toggle="tab" href="#chart_temp">Temperature</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#chart_bp">Blood Pressure</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#chart_pulse">Pulse</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#chart_resp">Respiratory Rate</a></li>
				</ul>
				<div class="tab-content">
					<div id="chart_temp" class="tab-pane fade show active">
						<div class="chart-container temperature-chart">
							<canvas id="temperature_chart"></canvas>
						</div>
					</div>
					<div id="chart_bp" class="tab-pane fade">
						<div class="row">
							<div class="col-md-4">
								<div class="card mt-4 mb-4">
									<div class="card-header">BP Chart</div>
									<div class="card-body">
										<div class="chart-container bp-chart">
											<canvas id="bp_chart"></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="chart_pulse" class="tab-pane fade">
					    <div class="row">
							<div class="col-md-4">
								<div class="card mt-4">
									<div class="card-header">Pulse Chart</div>
									<div class="card-body">
										<div class="chart-container pulse-chart">
											<canvas id="pulse_chart"></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="chart_resp" class="tab-pane fade">
					</div>
				</div>
			</div>
			<div id="past" class="tab-pane fade">
			 	<div class="table-responsive" id="attend-vitalshistory-table">
				</div>
			</div>
		</div>

	<div 
		class="modal fade bd-example-modal-xl" 
		id="vital_delete_modal" 
		tabindex="-1" 
		role="dialog" 
		aria-labelledby="vital_delete_modal" 
		aria-hidden="true">
		<div class="modal-dialog" role="document">
		    <div class="modal-content">
		    	<div class="modal-header">
		        	<h5 class="modal-title" id="vital_delete_modal_title">Vital Deletion</h5>
		    	</div>
				<form action="#" method="POST">
				    <div class="modal-body">
						<p id="vital_delete_question"></p>
					</div>
				    <div class="modal-footer">
				        <button type="button" id="vital_delete_yes" name="vital_delete_yes" class="btn btn-danger">Yes</button>
				        <button type="button" id="vital_delete_no" name="vital_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
				    </div>
				</form>
		    </div>
		</div>
	</div>
</div>

<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>