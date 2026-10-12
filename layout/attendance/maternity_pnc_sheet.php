<?php
	include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
?>
<div class="form-row">
	<div class="col-md-2 mb-2">
		<button type="button" name="pnc_maternity_leave_btn" id="pnc_maternity_leave_btn" class="btn btn-block btn-secondary">Maternity Leave</button>
	</div>
	<div class="col-md-10 mb-10">
	</div>
</div>
<hr class="d-none d-md-block">
<div class="table-responsive" id="patient_pnc_table">
</div>

<form id="pnc_current_form" method="POST" >
	<div class="modal-body">
		<div class="panel-body">
			<div class="form-row">
				<div class="col-md-2 mb-2">
					<label for="pnc_urine_protein"><small>Urine Protein</small></label>
					<select class="form-control bg-light" name="pnc_urine_protein" id="pnc_urine_protein"> 
			    		<option value="0">Please Select</option>
				        <option value="+">+</option>
				        <option value="+++">++</option>
				        <option value="++++">++++</option>
				        <option value="NIL">NIL</option>
				        <option value="TRACE">TRACE</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="pnc_urine_sugar"><small>Urine Sugar</small></label>
					<select class="form-control bg-light" name="pnc_urine_sugar" id="pnc_urine_sugar"> 
			    		<option value="0">Please Select</option>
				        <option value="+">+</option>
				        <option value="+++">++</option>
				        <option value="++++">++++</option>
				        <option value="NIL">NIL</option>
				        <option value="TRACE">TRACE</option>
			    	</select>
				</div>
				<div class="col-md-3 mb-3">
					<label for="pnc_loch_colour"><small>Loch. Colour</small></label>
					<input type="text" name="pnc_loch_colour" class="form-control bg-light" id="pnc_loch_colour">
				</div>
				<div class="col-md-3 mb-3">
					<label for="pnc_loch_odour"><small>Loch. Odour</small></label>
					<input type="text" name="pnc_loch_odour" class="form-control bg-light" id="pnc_loch_odour">
				</div>
				<div class="col-md-2 mb-2">
					<label for="pnc_incision_per"><small>Incision Per.</small></label>
					<select class="form-control bg-light" name="pnc_incision_per" id="pnc_incision_per"> 
			    		<option value="0">Please Select</option>
				        <option value="Clean">Clean</option>
				        <option value="Infected">Infected</option>
			    	</select>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-4 mb-4">
					<label for="pnc_breast_nipple"><small>Breast/Nipple</small></label>
					<input type="text" name="pnc_breast_nipple" class="form-control bg-light" id="pnc_breast_nipple">
				</div>
				<div class="col-md-4 mb-4">
					<label for="pnc_mood_change"><small>Mood Change</small></label>
					<select class="form-control bg-light" name="pnc_mood_change" id="pnc_mood_change"> 
			    		<option value="0">Please Select</option>
				        <option value="Yes">Yes</option>
				        <option value="No">No</option>
			    	</select>
				</div>
				<div class="col-md-4 mb-4">
					<label for="pnc_hb"><small>HB</small></label>
					<input type="text" name="pnc_hb" class="form-control bg-light" id="pnc_hb">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-2 mb-2">
					<label for="pnc_fp_counsel"><small>FP Counsel?</small></label>
					<select class="form-control bg-light" name="pnc_fp_counsel" id="pnc_fp_counsel"> 
			    		<option value="0">Please Select</option>
				        <option value="Yes">Yes</option>
				        <option value="No">No</option>
			    	</select>
				</div>
				<div class="col-md-2 mb-2">
					<label for="pnc_fp_method"><small>FP Method</small></label>
					<input type="text" name="pnc_fp_method" class="form-control bg-light" id="pnc_fp_method">
				</div>
				<div class="col-md-4 mb-4">
					<label for="pnc_fp_remarks"><small>FP Remarks</small></label>
					<input type="text" name="pnc_fp_remarks" class="form-control bg-light" id="pnc_fp_remarks">
				</div>
				<div class="col-md-4 mb-4">
					<label for="pnc_complaint"><small>Complaint</small></label>
					<input type="text" name="pnc_complaint" class="form-control bg-light" id="pnc_complaint">
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<div id="pnc_save_update">
			<button type="submit" name="pnc_save_btn" id="pnc_save_btn" class="btn btn-primary">Save</button>
		</div>
	    <button type="button" name="pnc_update_btn" id="pnc_update_btn" class="btn btn-primary" hidden="true">Update</button>
	    <button type="button" name="pnc_cancel_btn" id="pnc_cancel_btn" class="btn btn-secondary">Cancel</button>
	    <input type="hidden" name="pnc_id" class="form-control bg-light" id="pnc_id">
	    <input type="hidden" name="preg_id" class="form-control bg-light" id="preg_id" value="">
	</div>
</form>

<div class="modal fade bd-example-modal-xl" id="pnc_child_modal" tabindex="-1" role="dialog" aria-labelledby="pnc_child_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="pnc_child_modal_title">Postnatal - Child Care</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="pnc_child_form" method="POST" >
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="pc_date"><small>Date</small></label>
								<input type="date" name="pc_date" class="form-control bg-light" id="pc_date">
								<input type="hidden" name="pnc_child_id" class="form-control" id="pnc_child_id">
								<input type="hidden" name="pnc_id_child" class="form-control" id="pnc_id_child">
								<input type="hidden" name="pnc_preg_id" class="form-control" id="pnc_preg_id">
							</div>
							<div class="col-md-2 mb-2">
								<label for="pc_time"><small>Time</small></label>
								<input type="time" name="pc_time" class="form-control bg-light" id="pc_time">
							</div>
							<div class="col-md-2 mb-2">
								<label for="pc_weight"><small>Weight</small></label>
								<input type="text" name="pc_weight" class="form-control bg-light" id="pc_weight">
							</div>
							<div class="col-md-2 mb-2">
								<label for="pc_length"><small>Length</small></label>
								<input type="text" name="pc_length" class="form-control bg-light" id="pc_length">
							</div>
							<div class="col-md-2 mb-2">
								<label for="pc_head_circ"><small>Head Circ.</small></label>
								<input type="text" name="pc_head_circ" class="form-control bg-light" id="pc_head_circ">
							</div>
							<div class="col-md-2 mb-2">
								<label for="pc_resp_rate"><small>Resp. Rate</small></label>
								<input type="text" name="pc_resp_rate" class="form-control bg-light" id="pc_resp_rate">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="pc_temp"><small>Temp</small></label>
								<input type="text" name="pc_temp" class="form-control bg-light" id="pc_temp">
							</div>
							<div class="col-md-2 mb-2">
								<label for="pc_feeding"><small>Feeding</small></label>
								<select class="form-control bg-light" name="pc_feeding" id="pc_feeding"> 
						    		<option value="0">Please Select</option>
							        <option value="Breastfeeding">Breastfeeding</option>
							        <option value="Others">Others</option>
						    	</select>
						    </div>
							<div class="col-md-2 mb-2">
								<label for="pc_activities"><small>Activities</small></label>
								<select class="form-control bg-light" name="pc_activities" id="pc_activities"> 
						    		<option value="0">Please Select</option>
							        <option value="normal">normal</option>
							        <option value="abnormal">abnormal</option>
						    	</select>
						    </div>
							<div class="col-md-2 mb-2">
								<label for="pc_pallor"><small>Pallor</small></label>
								<select class="form-control bg-light" name="pc_pallor" id="pc_pallor"> 
						    		<option value="0">Please Select</option>
							        <option value="Yes">Yes</option>
							        <option value="No">No</option>
						    	</select>
						    </div>
							<div class="col-md-2 mb-2">
								<label for="pc_jaundice"><small>Jaundice</small></label>
								<select class="form-control bg-light" name="pc_jaundice" id="pc_jaundice"> 
						    		<option value="0">Please Select</option>
							        <option value="Yes">Yes</option>
							        <option value="No">No</option>
						    	</select>
						    </div>
							<div class="col-md-2 mb-2">
								<label for="pc_head"><small>Head</small></label>
								<select class="form-control bg-light" name="pc_head" id="pc_head"> 
						    		<option value="0">Please Select</option>
							        <option value="normal">normal</option>
							        <option value="abnormal">abnormal</option>
						    	</select>
						    </div>
						</div>
						<div class="form-row">
							<div class="col-md-2 mb-2">
								<label for="pc_eye"><small>Eye</small></label>
								<select class="form-control bg-light" name="pc_eye" id="pc_eye"> 
						    		<option value="0">Please Select</option>
							        <option value="normal">normal</option>
							        <option value="abnormal">abnormal</option>
						    	</select>
							</div>
							<div class="col-md-2 mb-2">
								<label for="pc_abdomen"><small>Abdomen</small></label>
								<select class="form-control bg-light" name="pc_abdomen" id="pc_abdomen"> 
						    		<option value="0">Please Select</option>
							        <option value="normal">normal</option>
							        <option value="abnormal">abnormal</option>
						    	</select>
						    </div>
							<div class="col-md-2 mb-2">
								<label for="pc_limbs"><small>Limbs</small></label>
								<select class="form-control bg-light" name="pc_limbs" id="pc_limbs"> 
						    		<option value="0">Please Select</option>
							        <option value="normal">normal</option>
							        <option value="abnormal">abnormal</option>
						    	</select>
						    </div>
							<div class="col-md-2 mb-2">
								<label for="pc_back"><small>Back</small></label>
								<select class="form-control bg-light" name="pc_back" id="pc_back"> 
						    		<option value="0">Please Select</option>
							        <option value="normal">normal</option>
							        <option value="abnormal">abnormal</option>
						    	</select>
						    </div>
							<div class="col-md-2 mb-2">
								<label for="pc_skin"><small>Skin</small></label>
								<select class="form-control bg-light" name="pc_skin" id="pc_skin"> 
						    		<option value="0">Please Select</option>
							        <option value="normal">normal</option>
							        <option value="abnormal">abnormal</option>
						    	</select>
						    </div>
							<div class="col-md-2 mb-2">
								<label for="pc_heart_rate"><small>Heart Rate</small></label>
								<input type="text" name="pc_heart_rate" class="form-control bg-light" id="pc_heart_rate">
						    </div>
						</div>
						<div class="form-row">
							<div class="col-md-1 mb-1">
								<label for="pc_pass_urine"><small>Passing Urine</small></label>
								<select class="form-control bg-light" name="pc_pass_urine" id="pc_pass_urine"> 
						    		<option value="0">Please Select</option>
							        <option value="Yes">Yes</option>
							        <option value="No">No</option>
						    	</select>
						    </div>
							<div class="col-md-1 mb-1">
								<label for="pc_pass_stool"><small>Passing Stool</small></label>
								<select class="form-control bg-light" name="pc_pass_stool" id="pc_pass_stool"> 
						    		<option value="0">Please Select</option>
							        <option value="Yes">Yes</option>
							        <option value="No">No</option>
						    	</select>
							</div>
							<div class="col-md-4 mb-4">
								<label for="pc_attend_type"><small>Attendance Type</small></label>
								<select class="form-control bg-light" name="pc_attend_type" id="pc_attend_type"> 
						    		<option value="0">Please Select</option>
							        <option value="FIRST_VISIT_24_48_HOURS">FIRST VISIT 24 - 48 HOURS</option>
							        <option value="FOLLOW_UP_VISIT_6_7_DAYS">FOLLOW UP VISIT 6 -7 DAYS</option>
							        <option value="FOLLOW_UP_VISIT_6_WEEKS">FOLLOW UP VISIT 6 WEEKS</option>
						    	</select>
						    </div>
							<div class="col-md-2 mb-2">
								<label for="pc_hiv_date"><small>HIV Date</small></label>
								<input type="date" name="pc_hiv_date" class="form-control bg-light" id="pc_hiv_date">
						    </div>
							<div class="col-md-2 mb-2">
								<label for="pc_hiv_result"><small>HIV Result</small></label>
								<select class="form-control bg-light" name="pc_hiv_result" id="pc_hiv_result"> 
						    		<option value="0">Please Select</option>
							        <option value="279">279</option>
							        <option value="280">280</option>
						    	</select>
						    </div>
							<div class="col-md-2 mb-2">
								<label for="pc_hiv_remarks"><small>HIV Remarks</small></label>
								<input type="text" name="pc_hiv_remarks" class="form-control bg-light" id="pc_hiv_remarks">
						    </div>
						</div>
						<div class="form-row">
							<div class="col-md-3 mb-3">
								<label for="pc_umbelical_cord"><small>Condition of Umbelical Cord</small></label>
								<input type="text" name="pc_umbelical_cord" class="form-control bg-light" id="pc_umbelical_cord">
						    </div>
						    <div class="col-md-2 mb-2">
								<label for="pc_initials"><small>Initials</small></label>
								<input type="text" name="pc_initials" class="form-control bg-light" id="pc_initials">
						    </div>
							<div class="col-md-7 mb-7">
								<label for="pc_remarks"><small>Remarks</small></label>
								<textarea row="3" name="pc_remarks" class="form-control bg-light" id="pc_remarks"></textarea> 
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="pc_save_update">
						<button type="submit" name="pc_save_btn" id="pc_save_btn" class="btn btn-primary">Save</button>
					</div>
				    <button type="button" name="pc_update_btn" id="pc_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
	include($_SERVER['DOCUMENT_ROOT'] .'/layout/attendance/maternity_leave_sheet.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>