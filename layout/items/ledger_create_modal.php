<div 
class="modal fade bd-example-modal-xl" 
id="ledgercreatemodal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="ledgercreatemodal" 
aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="ledger_create_modal_header">Ledger Setup</h5>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
      <form id="ledger_create_form" method="POST">
        <div class="modal-body">
  		<div class="clearfix"></div>
      		<div class="panel-body">
				<div class="form-row">
					<div class="col-md-6 mb-6" id="ledgerdesc_div">
						<input type="hidden" name="ledger_user_id" class="form-control bg-light" id="ledger_user_id">
						<input type="hidden" name="ledger_user_super_id" class="form-control bg-light" id="ledger_user_super_id">
						<input type="hidden" name="ledger_type" class="form-control bg-light" id="ledger_type">
						<label for="ledgerdesc">Description</label>
						<input type="hidden" class="form-control" name="ledger_id" id="ledger_id">
						<input type="text" class="form-control" name="ledgerdesc" id="ledgerdesc">
					</div>
					<div class="col-md-2 mb-2" id="ledger_code_div">
						<label for="ledgerCode">Code</label>
						<input type="text" class="form-control" name="ledgerCode" id="ledgerCode">
					</div>
					<div class="col-md-4 mb-4" id="ledger_company_id_div">
						<label for="ledger_company_id">Company</label>
						<select class="form-control" name="ledger_company_id" id="ledger_company_id">
							<option value="0">-Please Select-</option>
							<?php
								$sql="SELECT trading_name, company_id FROM company ORDER BY trading_name ASC";
								$result=mysqli_query($con,$sql);
								while($row=mysqli_fetch_array($result))
								{
									echo '<option value = "'.$row['company_id'].'">'.$row['trading_name'].'</option>';
								};
							?>
						</select>
					</div>
					<div class="col-md-4 mb-4" hidden>
						<label for="show_balance">Show Balance <small>(Customer Purchase)</small></label>
						<select class="form-control" name="show_balance" id="show_balance"> 
							<option value="0">Please Select</option>
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 mb-3 trial_balance_group" id="tb_1_div">
						<label for="tb_1">TB Group 1</label>
						<select class="form-control" name="tb_1" id="tb_1"> 
							<option value="0">Please Select</option>
							<?php
								$sql="SELECT * FROM trial_bal_group_1 ORDER BY tb_1_desc ASC";
								$result=mysqli_query($con,$sql);
								while($row=mysqli_fetch_array($result))
								{
								?>
								<option value = "<?php echo($row['id'])?>" >
									<?php echo($row['tb_1_desc']) ?>
								</option>
								<?php
								}               
							?>
						</select>
					</div>
					<div class="col-md-4 mb-3 trial_balance_group" id="tb_2_div">
						<label for="tb_2">TB Group 2</label>
						<select class="form-control" name="tb_2" id="tb_2"> 
						</select>
					</div>
					<div class="col-md-4 mb-3 trial_balance_group" id="tb_3_div">
						<label for="tb_3">TB Group 3</label>
						<select class="form-control" name="tb_3" id="tb_3">
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 mb-4 trial_balance_group" id="tb_4_div">
						<label for="tb_4">TB Group 4</label>
						<select class="form-control" name="tb_4" id="tb_4"> 
						</select>
					</div>
					<div class="col-md-4 mb-4 trial_balance_group" id="tb_5_div">
						<label for="tb_5">TB Group 5</label>
						<select class="form-control" name="tb_5" id="tb_5"> 
						</select>
					</div>
					<div class="col-md-4 mb-4 trial_balance_group">
						<label for="ledgerstatus">Status</label>
						<select class="form-control" name="ledgerstatus" id="ledgerstatus"> 
							<option value="0">Please Select</option>
							<option value="Active">Active</option>
							<option value="Dormant">Dormant</option>
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 mb-4">
						<label for="ledgeraddress">Address</label>
						<input type="text" class="form-control" name="ledgeraddress" id="ledgeraddress">
					</div>
					<div class="col-md-4 mb-4">
						<label for="ledgeremail">Email</label>
						<input type="text" class="form-control" name="ledgeremail" id="ledgeremail">
					</div>
					<div class="col-md-4 mb-4">
						<label for="ledgerphone">Telephone</label>
						<input type="text" class="form-control" name="ledgerphone" id="ledgerphone">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 mb-4">
						<label for="ledger_opening_balance">Opening Balance</label>
						<input type="text" class="form-control" name="ledger_opening_balance" id="ledger_opening_balance">
					</div>
					<div class="col-md-4 mb-4">
						<label for="ledger_opening_state">Balance Type</label>
						<select class="form-control" name="ledger_opening_state" id="ledger_opening_state">
							<option value="0">-Please Select-</option>
							<option value="Dr">Dr</option>
							<option value="Cr">Cr</option>
						</select>
					</div>
					<div class="col-md-4 mb-4">
						<label for="ledger_opening_date">Applicable Date</label>
						<input type="date" class="form-control" name="ledger_opening_date" id="ledger_opening_date">
					</div>
				</div>
			</div>
	        <div class="modal-footer">
	            <button type="button" name="ledger_save_btn" id="ledger_save_btn" class="btn btn-primary">Save</button>
	            <button type="button" name="ledger_update_btn" id="ledger_update_btn" class="btn btn-primary">Update</button>
	            <button type="button" name="ledger_execute_btn" id="ledger_execute_btn" class="btn btn-success">Execute</button>
	            <button type="submit" name="ledgercancelbtn" id="ledgercancelbtn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	        </div>
        </div>
      </form>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
    </div>
  </div>
</div>