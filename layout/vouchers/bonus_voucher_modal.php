<div 
class="modal fade hide bd-example-modal-lg" 
id="bonus_voucher_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="bonus_voucher_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="bonus_voucher_modal_header">Bonus Voucher</h5>
			</div>
			<div class="modal-body">
				<form id="bonus_voucher_modal_form" method="POST">
	                <div class="panel-body">
	                	<div id="bonus_voucher_modal_warning"></div>
                        <input type="hidden" name="bonus_voucher_company_id" class="form-control bg-light" id="bonus_voucher_company_id">
                        <input type="hidden" name="bonus_voucher_user_id" class="form-control bg-light" id="bonus_voucher_user_id">
                        <input type="hidden" name="bonus_voucher_user_super_id" class="form-control bg-light" id="bonus_voucher_user_super_id">
                        <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="bonus_voucher_branch">Location</label>
	                            <select class="form-control bg-light" name="bonus_voucher_branch" id="bonus_voucher_branch">
					                <option value="ALL">ALL</option>';
			                      	<?php
										$company_id = $_SESSION['company_id'];
										$sql="SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name ASC";
										$result=mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value = "'.$row['branch_id'].'">
												'.$row['branch_name'].'
											</option>';
										};
									?>
					        	</select>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="bonus_voucher_date">Applicable Date</label>
	                            <input type="date" name="bonus_voucher_date" class="form-control bg-light" id="bonus_voucher_date">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="bonus_voucher_calculation_type">Calculation Type</label>
	                            <select class="form-control bg-light" name="bonus_voucher_calculation_type" id="bonus_voucher_calculation_type">
					                <option value="Percentage_Of_Salary">Percentage_Of_Salary</option>
					                <option value="Flat_Amount">Flat_Amount</option>
					        	</select>
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="bonus_voucher_amount">Percentage/Amount</label>
	                            <input type="text" name="bonus_voucher_amount" class="form-control bg-light" id="bonus_voucher_amount">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="bonus_voucher_narration">Narration</label>
	                            <textarea type="text" class="form-control bg-light" name="bonus_voucher_narration" id="bonus_voucher_narration" rows="4"></textarea>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="bonus_voucher_ok_btn" id="bonus_voucher_ok_btn" class="btn btn-primary">Execute</button>
	                    <button type="submit" name="bonus_voucher_cancel_btn" id="bonus_voucher_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>