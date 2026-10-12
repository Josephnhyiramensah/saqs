<div 
class="modal fade bd-example-modal-xl" 
id="stock_sales_invoice_mur_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_sales_invoice_mur_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_sales_invoice_mur_modal_title">Medicine Utilisation Review</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<form id="stock_sales_invoice_mur_form" method="POST">

					<strong><p>MATTERS IDENTIFIED DURING MUR</p></strong>

					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="mur_q_1">1. Any matters identified during MUR</label>
							<select class="form-control bg-light" name="mur_q_1" id="mur_q_1"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_2_div" hidden="true">
							<label for="mur_q_2">2. OTC/Complementary Therapy</label>
							<select class="form-control bg-light" name="mur_q_2" id="mur_q_2"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_3_div" hidden="true">
							<label for="mur_q_3">3. Patient not using medication as prescribed (Non-Adherence)</label>
							<select class="form-control bg-light" name="mur_q_3" id="mur_q_3"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_4_div" hidden="true">
							<label for="mur_q_4">4. Problem with pharmacuetical form of a medicine or use of device</label>
							<select class="form-control bg-light" name="mur_q_4" id="mur_q_4"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_5_div" hidden="true">
							<label for="mur_q_5">5. Patient reports need for more information about a medicine or condition</label>
							<select class="form-control bg-light" name="mur_q_5" id="mur_q_5"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_6_div" hidden="true">
							<label for="mur_q_6">6. Patient reports side effects or other concern about a medicine</label>
							<select class="form-control bg-light" name="mur_q_6" id="mur_q_6"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_7_div" hidden="true">
							<label for="mur_q_7">7. Patient Drug Interaction</label>
							<select class="form-control bg-light" name="mur_q_7" id="mur_q_7"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_8_div" hidden="true">
							<label for="mur_q_8">8. Patient report not using the medicine anymore</label>
							<select class="form-control bg-light" name="mur_q_8" id="mur_q_8"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_9_div" hidden="true">
							<label for="mur_q_9">9. Patient report difficulty in using the medicine issue with the formulation</label>
							<select class="form-control bg-light" name="mur_q_9" id="mur_q_9"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_10_div" hidden="true">
							<label for="mur_q_10">10. Patient report lack of efficacy</label>
							<select class="form-control bg-light" name="mur_q_10" id="mur_q_10"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_11_div" hidden="true">
							<label for="mur_q_11">11. Patient reports problem with dosage regime</label>
							<select class="form-control bg-light" name="mur_q_11" id="mur_q_11"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_12_div" hidden="true">
							<label for="mur_q_12">12. Patient reports unresolved concern about the medicine</label>
							<select class="form-control bg-light" name="mur_q_12" id="mur_q_12"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12" id="mur_q_13_div" hidden="true">
							<label for="mur_q_13">13. Others</label>
							<textarea type="textarea" rows="2"  class="form-control bg-light" name="mur_q_13" id="mur_q_13" value=""></textarea>
						</div>
					</div>

					<div id="mur_action_taken_div" hidden="true">
						<strong><p>ACTION TAKEN / OUTCOME</p></strong>
					</div>

					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_14_div" hidden="true">
							<label for="mur_q_14">14. Information/Advice provided</label>
							<select class="form-control bg-light" name="mur_q_14" id="mur_q_14"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_15_div" hidden="true">
							<label for="mur_q_15">15. Yellow Card submitted to MHRA</label>
							<select class="form-control bg-light" name="mur_q_15" id="mur_q_15"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_16_div" hidden="true">
							<label for="mur_q_16">16. Referral - issues to be raised with GP practice or another primary healthcare provider</label>
							<select class="form-control bg-light" name="mur_q_16" id="mur_q_16"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_17_div" hidden="true">
							<label for="mur_q_17">17. Others</label>
							<textarea type="textarea" rows="2"  class="form-control bg-light" name="mur_q_17" id="mur_q_17" value=""></textarea>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_18_div" hidden="true">
							<label for="mur_q_18">18. Better understanding/reinforcement of why they are using the medicine/what is it for</label>
							<select class="form-control bg-light" name="mur_q_18" id="mur_q_18"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_19_div" hidden="true">
							<label for="mur_q_19">19. Better understanding/reinforcement of when/how to take the medicines</label>
							<select class="form-control bg-light" name="mur_q_19" id="mur_q_19"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6" id="mur_q_20_div" hidden="true">
							<label for="mur_q_20">20. Better understanding/reinforcement of side effect and how to manage the medicines</label>
							<select class="form-control bg-light" name="mur_q_20" id="mur_q_20"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
						<div class="col-md-6 mb-6" id="mur_q_21_div" hidden="true">
							<label for="mur_q_21">21. Better understanding/reinforcement of the condition being treated</label>
							<select class="form-control bg-light" name="mur_q_21" id="mur_q_21"> 
					    		<option value="0">Please Select</option>
					            <option value = "Yes" >Yes</option>
					            <option value = "No" >No</option>
					    	</select>
						</div>
					</div>
					<input type="text" name="mur_sales_item_id" id="mur_sales_item_id" hidden="true">
					<input type="text" name="mur_sales_item" id="mur_sales_item" hidden="true">
					<input type="text" name="mur_date" id="mur_date" hidden="true">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn_stock_sales_invoice_mur_save" class="btn btn-primary">Save</button>
			    <button type="button" id="btn_stock_sales_invoice_mur_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>