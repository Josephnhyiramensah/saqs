<div 
class="modal fade hide bd-example-modal-lg" 
id="payroll_paye_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="payroll_paye_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="payroll_paye_modal_header">Payroll PAYE</h5>
			</div>
			<div class="modal-body">
				<form id="payroll_paye_modal_form" method="POST">
	                <div class="panel-body">
	                    <div id="payroll_paye_modal_warning"></div>
		                <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="paye_pay_sheet_id">Pay Sheet</label>
								<select class="form-control bg-light" name="pay_sheet_id" id="paye_pay_sheet_id"> 
									<option value="0">Please Select</option>
										<?php
											$company_id = $_SESSION['company_id'];

											$sql="SELECT * FROM payroll_pay_sheet WHERE company_id = '$company_id' ORDER BY date DESC";
											$result = mysqli_query($con,$sql);
											while($row = mysqli_fetch_array($result))
											{
												echo'<option value = "'.$row['pay_sheet_id'].'">'.$row['date'].'</option>';
											};
										?>
								</select>
							</div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="paye_location">Location</label>
	                            <select class="form-control bg-light" name="location" id="paye_location"> 
									<option value="ALL">ALL</option>
										<?php
											$company_id = $_SESSION['company_id'];

											$sql="SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name DESC";
											$result = mysqli_query($con,$sql);
											while($row = mysqli_fetch_array($result))
											{
												echo'<option value = "'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
											};
										?>
								</select>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="payroll_paye_ok_btn" id="payroll_paye_ok_btn" class="btn btn-primary">OK</button>
	                    <button type="submit" name="payroll_paye_cancel_btn" id="payroll_paye_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>