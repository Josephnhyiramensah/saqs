<div 
class="modal fade hide bd-example-modal-lg" 
id="payment_type_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="payment_type_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="payment_type_report_modal_header">Payment Type Report</h5>
			</div>
			<div class="modal-body">
				<form id="payment_type_report_modal_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
							<div class="col-md-12 mb-12 form-group">
								<label for="payment_type_report_branch">Branch</label>
								<select class="form-control bg-light" name="payment_type_report_branch" id="payment_type_report_branch"> 
									<option value="ALL">ALL</option>
									<?php
										$company_id = $_SESSION['company_id'];
										if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
										{
											$sql="SELECT * FROM company ORDER BY trading_name ASC";
										}
										else
										{
											$sql="SELECT * FROM company WHERE company_id='$company_id' ORDER BY trading_name ASC";
										};
										$result = mysqli_query($con, $sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value = "'.$row['company_id'].'">'.$row['trading_name'].'</option>';
										};
									?>
								</select>
							</div>
		                </div>
	                    <div class="form-row">
							<div id="payment_type_report_modal_warning"></div>
							<div class="col-md-12 mb-12 form-group">
								<label for="payment_type_report_ledger_id">Payment Type</label>
								<select class="form-control bg-light" name="payment_type_report_ledger_id" id="payment_type_report_ledger_id"> 
									<option value="0">Please Select</option>
										<?php
											$sql="SELECT * FROM ledgers WHERE tb_5=1 OR tb_5=12 OR tb_5=13 ORDER BY ledger_desc ASC";
											$result = mysqli_query($con,$sql);
											while($row = mysqli_fetch_array($result))
											{
												echo '<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
											};
										?>
								</select>
							</div>
		                </div>
		                <div class="form-row">
		                        <div class="col-md-12 mb-12 form-group">
		                            <label for="payment_type_report_type">Type</label>
		                            <select class="form-control bg-light" name="payment_type_report_type" id="payment_type_report_type"> 
		                                <option value="0">Please Select</option>
			                            <option value = "Summary">Summary</option>
			                            <option value = "Detail">Detail</option>
		                            </select>
		                        </div>
		                </div>
		                <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <input type="hidden" name="payment_type_report_company_id" class="form-control bg-light" id="payment_type_report_company_id">
	                            <input type="hidden" name="payment_type_report_user_id" class="form-control bg-light" id="payment_type_report_user_id">
	                            <input type="hidden" name="payment_type_report_user_super_id" class="form-control bg-light" id="payment_type_report_user_super_id">
	                            <label for="payment_type_report_start_date">Start Date</label>
	                            <input type="date" name="payment_type_report_start_date" class="form-control bg-light" id="payment_type_report_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="payment_type_report_end_date">End Date</label>
	                            <input type="date" name="payment_type_report_end_date" class="form-control bg-light" id="payment_type_report_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="payment_type_report_ok_btn" id="payment_type_report_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="payment_type_report_cancel_btn" id="payment_type_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>