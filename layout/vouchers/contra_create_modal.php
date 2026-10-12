<div 
class="modal fade hide bd-example-modal-xl" 
id="contra_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="contra_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 60%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="contra_create_modal_header">Contra Voucher Creation</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="contra_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-6 mb-6 form-group">
	                            <input type="hidden" name="contra_id" class="form-control bg-light" id="contra_id">
	                            <input type="hidden" name="contra_company_id" class="form-control bg-light" id="contra_company_id">
	                            <input type="hidden" name="contra_user_id" class="form-control bg-light" id="contra_user_id">
	                            <input type="hidden" name="contra_user_super_id" class="form-control bg-light" id="contra_user_super_id">
	                            <label for="contra_debit_ledger">Debit Ledger</label>
	                            <select class="form-control bg-light" name="contra_debit_ledger" id="contra_debit_ledger"> 
	                                <option value="0">Please Select</option>
		                                <?php
		                                    $sql="SELECT * FROM ledgers WHERE tb_4=6 ORDER BY ledger_desc ASC";
		                                    $result = mysqli_query($con,$sql);
		                                    while($row = mysqli_fetch_array($result))
		                                    {
		                                    ?>
		                                    <option value = "<?php echo($row['ledger_id'])?>">
		                                        <?php echo($row['ledger_desc'])?>
		                                    </option>
		                                    <?php
		                                    };
		                                ?>
	                            </select>
	                        </div>
	                        <div class="col-md-6 mb-6 form-group">
	                            <label for="contra_credit_ledger">Credit Ledger</label>
	                            <select class="form-control bg-light" name="contra_credit_ledger" id="contra_credit_ledger"> 
	                                <option value="0">Please Select</option>
		                                <?php
		                                    $sql="SELECT * FROM ledgers WHERE tb_4=6 ORDER BY ledger_desc ASC";
		                                    $result = mysqli_query($con,$sql);
		                                    while($row = mysqli_fetch_array($result))
		                                    {
		                                    ?>
		                                    <option value = "<?php echo($row['ledger_id'])?>">
		                                        <?php echo($row['ledger_desc'])?>
		                                    </option>
		                                    <?php
		                                    };
		                                ?>
	                            </select>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="contra_date">Date</label>
	                            <input type="date" class="form-control bg-light" name="contra_date" id="contra_date">
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="contra_amount">Amount</label>
	                            <input type="text" class="form-control" name="contra_amount" id="contra_amount">
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="contra_mode">Mode</label>
	                            <select class="form-control bg-light" name="contra_mode" id="contra_mode"> 
	                                <option value="0">Please Select</option>
		                            <option value="cash">Cash</option>
		                            <option value="cheque">Cheque</option>
		                            <option value="momo">MoMo</option>
		                            <option value="bank_transfer">Bank Transfer</option>
		                            <option value="payment_order">Payment Order</option>
		                            <option value="swift">Swift</option>
		                            <option value="visa">Visa</option>
		                            <option value="paypal">PayPal</option>
		                            <option value="credit_card">Credit Card</option>
		                            <option value="debit_card">Debit Card</option>
	                            </select>
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="contra_ref">Reference</label>
	                            <input type="text" name="contra_ref" class="form-control bg-light" id="contra_ref">
	                        </div>
	                    </div>
	                    <div id="bank_details_div" class="form-row" hidden="true">
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="contra_inst_no">Instrument No</label>
	                            <input type="text" class="form-control bg-light" name="contra_inst_no" id="contra_inst_no">
	                        </div>
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="contra_bank">Bank</label>
	                            <input type="text" class="form-control bg-light" name="contra_bank" id="contra_bank">
	                        </div>
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="contra_branch">Branch</label>
	                            <input type="text" class="form-control bg-light" name="contra_branch" id="contra_branch">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="contra_name">Name</label>
	                            <input type="text" class="form-control bg-light" name="contra_name" id="contra_name">
	                        </div>
	                        <div class="col-md-8 mb-8 form-group">
	                            <label for="contra_narration">Narration</label>
	                            <input type="text" class="form-control bg-light" name="contra_narration" id="contra_narration">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="contra_save_btn" id="contra_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="contra_update_btn" id="contra_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="contra_cancel_btn" id="contra_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
			</div>
		</div>
	</div>
</div>