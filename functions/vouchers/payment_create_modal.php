<div 
class="modal fade hide bd-example-modal-xl" 
id="payment_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="payment_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="payment_create_modal_header">Payment Voucher Creation</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="payment_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-4 mb-4 form-group">
	                            <input type="hidden" name="payment_id" class="form-control bg-light" id="payment_id">
	                            <input type="hidden" name="company_id" class="form-control bg-light" id="company_id">
	                            <input type="hidden" name="user_id" class="form-control bg-light" id="user_id">
	                            <input type="hidden" name="user_super_id" class="form-control bg-light" id="user_super_id">
	                            <label for="payment_credit_ledger">Credit Ledger</label>
	                            <select class="form-control bg-light" name="payment_credit_ledger" id="payment_credit_ledger"> 
	                                <option value="0">Please Select</option>
		                                <?php
		                                	$company_id = $_SESSION['company_id'];
		                                    $sql="SELECT * FROM ledgers WHERE /*company_id = '$company_id' AND*/ tb_4=6 ORDER BY ledger_desc ASC";
		                                    $result=mysqli_query($con,$sql);
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
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="payment_ref">Reference</label>
	                            <input type="text" name="payment_ref" class="form-control bg-light" id="payment_ref">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="payment_date">Date</label>
	                            <input type="date" class="form-control bg-light" name="payment_date" id="payment_date">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="payment_amount">Amount</label>
	                            <input type="text" class="form-control" name="payment_amount" id="payment_amount" hidden="true">
	                            <input type="text" class="form-control" name="payment_amountD" id="payment_amountD" disabled="true">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="payment_mode">Mode</label>
	                            <select class="form-control bg-light" name="payment_mode" id="payment_mode"> 
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
	                    </div>
	                    <div id="bank_details_div" class="form-row" hidden="true">
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="payment_inst_no">Instrument No</label>
	                            <input type="text" class="form-control bg-light" name="payment_inst_no" id="payment_inst_no">
	                        </div>
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="payment_bank">Bank</label>
	                            <input type="text" class="form-control bg-light" name="payment_bank" id="payment_bank">
	                        </div>
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="payment_branch">Branch</label>
	                            <input type="text" class="form-control bg-light" name="payment_branch" id="payment_branch">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="payment_payee">Payee</label>
	                            <input type="text" class="form-control bg-light" name="payment_payee" id="payment_payee">
	                        </div>
	                        <div class="col-md-8 mb-8 form-group">
	                            <label for="payment_narration">Narration</label>
	                            <input type="text" class="form-control bg-light" name="payment_narration" id="payment_narration">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12" id="payment_dr_list">
	                            <table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="payment_dr_list_table">
	                                <tr>
	                                    <th width="30%">Debit Ledger(s)</th>
	                                    <th width="15%">Amount</th>
	                                    <th width="50%">Narration</th>
	                                    <th width="5%">Action</th>
	                                </tr>
	                                <tr id="1">
	                                    <td>
	                                    	<input type="hidden" name="payment_dr_id[]" class="form-control bg-light" id="payment_dr_id1">
	                                        <select class="form-control payment_led_dr bg-light" name="payment_led_dr[]" id="payment_led_dr1" data-id="1" style="border-width:0px"> 
	                                            <option value="0">Please Select</option>
	                                            <?php
				                                    $sql="SELECT * FROM ledgers WHERE (/*company_id = '$company_id' AND*/ tb_2 !=3 AND tb_4 !=6) OR (default_status = 'Yes' AND tb_4 !=10 AND tb_4 !=6) ORDER BY ledger_desc ASC";
				                                    $result=mysqli_query($con,$sql);
				                                    	while($row=mysqli_fetch_array($result))
				                                    	{
				                                    ?>
				                                    		<option value = "<?php echo($row['ledger_id'])?>" ><?php echo($row['ledger_desc']) ?></option>
				                                    <?php
				                                    	}
				                                ?>
	                                        </select>
	                                    </td>
	                                    <td class = "action-td">
	                                        <input type="text" name="payment_dr_amt[]" class="form-control bg-light payment_dr_amt amt-td" id="payment_dr_amt1" data-id="1" style="border-width:0px">
	                                    </td>
	                                    <td class = "action-td">
	                                        <input type="text" name="payment_dr_narration[]" class="form-control bg-light payment_dr_narration" id="payment_dr_narration1" data-id="1" style="border-width:0px">
	                                    </td>
	                                    <td class = "action-td">
	                                        <a href="#" id="delete_payment_dr" data-id="1"><i class="fa fa-trash fa-sm"></i></a>
	                                    </td>
	                                </tr>
	                            </table>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="payment_save_btn" id="payment_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="payment_update_btn" id="payment_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="payment_cancel_btn" id="payment_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
          		<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
			</div>
		</div>
	</div>
</div>