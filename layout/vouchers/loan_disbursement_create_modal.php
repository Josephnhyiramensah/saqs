<div 
class="modal fade hide bd-example-modal-xl" 
id="loan_disbursement_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="loan_disbursement_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 60%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="loan_disbursement_create_modal_header">Loan Disbursement Voucher Creation</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="loan_disbursement_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-8 mb-8 form-group">
	                            <input type="hidden" name="loan_disbursement_id" class="form-control bg-light" id="loan_disbursement_id">
	                            <label for="employee_id">Employee</label>
	                            <select class="form-control bg-light" name="employee_id" id="employee_id"> 
	                                <option value="0">Please Select</option>
		                                <?php
		                                	$company_id = $_SESSION['company_id'];
		                                    $sql="SELECT * FROM payroll_employee WHERE company_id = '$company_id' ORDER BY first_name ASC";
		                                    $result = mysqli_query($con,$sql);
		                                    while($row = mysqli_fetch_array($result))
		                                    {
												?>
												<option value = "<?php echo($row['employee_id'])?>">
													<?php echo $row['first_name'].' '.$row['last_name'];?>
												</option>
												<?php
		                                    };
		                                ?>
	                            </select>
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="date"> Date</label>
	                            <input type="date" class="form-control bg-light" name="date" id="date" value="<?php echo $date_today;?>">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="effective_date">Effective Date</label>
	                            <input type="date" class="form-control bg-light" name="effective_date" id="effective_date" value="<?php echo $date_today;?>">
	                        </div>
	                    </div>
	                    <div class="form-row">
                          <div class="col-md-3 mb-3">
                            <label for="principal">Principal</label>
                            <input type="text" class="form-control bg-light" name="principal" id="principal">
                          </div>
                          <div class="col-md-3 mb-3">
                            <label for="duration">Duration (months)</label>
                            <input type="text" class="form-control bg-light" name="duration" id="duration">
                          </div>
                          <div class="col-md-3 mb-3">
                            <label for="interest">Interest <small>(e.g. 0.10 for 10%)</small></label>
                            <input type="text" class="form-control bg-light" name="interest" id="interest">
                          </div>
                          <div class="col-md-3 mb-3">
                            <label for="interest_calc_type">Interest Calculation Type</label>
                            <select class="form-control bg-light" name="interest_calc_type" id="interest_calc_type"> 
                                <option value="0">Please Select</option>
                                <option value="Straight Line">Straight Line</option>
                                <option value="Reducing Balance">Reducing Balance</option>
                              </select>
                          </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-6 mb-6 form-group">
	                            <label for="debit_ledger">Debit Ledger</label>
	                            <select class="form-control bg-light" name="debit_ledger" id="debit_ledger" hidden="true"> 
	                                <option value="0">Please Select</option>
		                                <?php
		                                	$company_id = $_SESSION['company_id'];
		                                    $sql="SELECT * FROM ledgers";
		                                    $result = mysqli_query($con,$sql);
		                                    while($row = mysqli_fetch_array($result))
		                                    {
												if($row['ledger_id'] == 43)
												{
													echo '<option value = "'.$row['ledger_id'].'" selected="selected">'.$row['ledger_desc'].'</option>';
												}
												else
												{
													echo '<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
												};
		                                    };
		                                ?>
	                            </select>
	                            <select class="form-control bg-light" name="debit_ledgerD" id="debit_ledgerD" disabled="true"> 
	                                <option value="0">Please Select</option>
		                                <?php
		                                	$company_id = $_SESSION['company_id'];
		                                    $sql="SELECT * FROM ledgers";
		                                    $result = mysqli_query($con,$sql);
		                                    while($row = mysqli_fetch_array($result))
		                                    {
												if($row['ledger_id'] == 43)
												{
													echo '<option value = "'.$row['ledger_id'].'" selected="selected">'.$row['ledger_desc'].'</option>';
												}
												else
												{
													echo '<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
												};
		                                    };
		                                ?>
	                            </select>
	                        </div>
	                        <div class="col-md-6 mb-6 form-group">
								<label for="credit_ledger">Credit Ledger</label>
	                            <select class="form-control bg-light" name="credit_ledger" id="credit_ledger"> 
	                                <option value="0">Please Select</option>
		                                <?php
		                                	$company_id = $_SESSION['company_id'];
		                                    $sql="SELECT * FROM ledgers WHERE (tb_4=6 AND company_id = '$company_id') OR (default_status = 'yes' AND tb_4 = 6) ORDER BY ledger_desc ASC";
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
	                            <label for="narration">Narration</label>
	                            <input type="text" class="form-control bg-light" name="narration" id="narration">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="loan_disbursement_save_btn" id="loan_disbursement_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="loan_disbursement_update_btn" id="loan_disbursement_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="loan_disbursement_cancel_btn" id="loan_disbursement_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
			</div>
		</div>
	</div>
</div>