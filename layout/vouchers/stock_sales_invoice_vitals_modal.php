<div 
class="modal fade bd-example-modal-xl" 
id="stock_sales_invoice_vitals_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_sales_invoice_vitals_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_sales_invoice_vitals_modal_title">Vitals</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<div class="v_input">
					<form id="stock_sales_invoice_vitals_input_form" method="POST">
						<input type="hidden" name="v_stock_sales_id" class="form-control" id="v_stock_sales_id">
						<div class="form-row">
							<div class="col-md-2 mb-2>
								<label for="v_date">Date</label>
								<input type="date" class="form-control" name="v_date" id="v_date" value="<?php echo $date_today;?>">
							</div>
							<div class="col-md-2 mb-2>
								<label for="v_time">Time</label>
								<input type="time" class="form-control" name="v_time" id="v_time" value="<?php echo $time;?>">
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
								<label for="weight">Weight</label>
								<input type="text" name="weight" class="form-control" id="weight" value="">
							</div>
							<div class="col-md-2 mb-2>
								<label for="height">Height</label>
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
						<div id="cvd_risk_assessment_div">
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
									<input type="text" name="cvd_age" class="form-control" id="cvd_age" hidden="true" value="<?php echo $row_stock_sales['age'];?>">
									<input type="text" name="cvd_age_d" class="form-control" id="cvd_age_d" disabled ="true" value="<?php echo $row_stock_sales['age'];?>">
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
										
									</select>
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
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="vitals_comment">Comment</label>
								<input type="hidden" name="vital_id" class="form-control" id="vital_id">
								<textarea type="textarea" rows="2"  class="form-control" name="vitals_comment" id="vitals_comment" value=""></textarea>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="stock_sales_invoice_vitals_save_btn" class="btn btn-primary">Save</button>
			    <button type="button" id="stock_sales_invoice_vitals_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>