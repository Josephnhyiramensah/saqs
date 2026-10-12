<div 
class="modal fade hide bd-example-modal-xl" 
id="journal_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="journal_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 60%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="journal_create_modal_header">Journal Voucher Creation</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="journal_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-6 mb-6 form-group">
	                            <input type="hidden" name="journal_id" class="form-control bg-light" id="journal_id">
	                            <input type="hidden" name="company_id" class="form-control bg-light" id="company_id">
	                            <input type="hidden" name="user_id" class="form-control bg-light" id="user_id">
	                            <input type="hidden" name="user_super_id" class="form-control bg-light" id="user_super_id">
	                            <label for="journal_debit_ledger">Debit Ledger</label>
	                            <select class="form-control bg-light" name="journal_debit_ledger" id="journal_debit_ledger"> 
	                                <option value="0">Please Select</option>
		                                <?php
		                                	$company_id = $_SESSION['company_id'];
		                                    $sql="SELECT * FROM ledgers WHERE tb_4 !=6 ORDER BY ledger_desc ASC";
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
	                        <div class="col-md-6 mb-6 form-group">
	                            <label for="journal_credit_ledger">Credit Ledger</label>
	                            <select class="form-control bg-light" name="journal_credit_ledger" id="journal_credit_ledger"> 
	                                <option value="0">Please Select</option>
		                                <?php
		                                	$company_id = $_SESSION['company_id'];
		                                    $sql="SELECT * FROM ledgers WHERE tb_4 !=6 ORDER BY ledger_desc ASC";
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
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="journal_date">Date</label>
	                            <input type="date" class="form-control bg-light" name="journal_date" id="journal_date">
	                        </div>
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="journal_amount">Amount</label>
	                            <input type="text" class="form-control bg-light" name="journal_amount" id="journal_amount">
	                        </div>
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="journal_ref">Reference</label>
	                            <input type="text" name="journal_ref" class="form-control bg-light" id="journal_ref">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-13 form-group">
	                            <label for="journal_narration">Narration</label>
	                            <input type="text" class="form-control bg-light" name="journal_narration" id="journal_narration">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="journal_save_btn" id="journal_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="journal_update_btn" id="journal_update_btn" class="btn btn-primary">Update</button>
	                    <button type="button" name="journal_cancel_btn" id="journal_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
          		<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
			</div>
		</div>
	</div>
</div>