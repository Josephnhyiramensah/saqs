<div 
class="modal fade bd-example-modal-xl" 
id="ledgereditmodal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="ledgereditmodal" 
aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="ledger_edit_modal_header">Ledger Edit</h5>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
      <form id="ledger_edit_form" method="POST">
        <div class="modal-body">
  		<div class="clearfix"></div>
      		<div class="panel-body">
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="ledgerdesc_up">Description</label>
							<input type="text" class="form-control" name="ledgerdesc_up" id="ledgerdesc_up">
						</div>
						<div class="col-md-2 mb-2" id="ledger_code_div_up">
							<label for="ledgerCode_up">Code</label>
							<input type="text" class="form-control" name="ledgerCode_up" id="ledgerCode_up">
						</div>
						<div class="col-md-4 mb-4">
							<label for="ledgerstatus_up">Status</label>
							<select class="form-control" name="ledgerstatus_up" id="ledgerstatus_up"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM status ORDER BY status ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            ?>
						            <option value = "<?php echo($row['id'])?>" >
						                <?php echo($row['status']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4 mb-3">
							<label for="tb_1_up">TB Group 1</label>
							<select class="form-control" name="tb_1_up" id="tb_1_up"> 
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
						<div class="col-md-4 mb-3">
							<label for="tb_2_up">TB Group 2</label>
							<select class="form-control" name="tb_2_up" id="tb_2_up">
								<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM trial_bal_group_2 ORDER BY tb_2_desc ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            ?>
						            <option value = "<?php echo($row['id'])?>" >
						                <?php echo($row['tb_2_desc']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
						<div class="col-md-4 mb-3">
							<label for="tb_3_up">TB Group 3</label>
							<select class="form-control" name="tb_3_up" id="tb_3_up">
								<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM trial_bal_group_3 ORDER BY tb_3_desc ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            ?>
						            <option value = "<?php echo($row['id'])?>" >
						                <?php echo($row['tb_3_desc']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4 mb-3">
							<label for="tb_4_up">TB Group 4</label>
							<select class="form-control" name="tb_4_up" id="tb_4_up">
								<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM trial_bal_group_4 ORDER BY tb_4_desc ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            ?>
						            <option value = "<?php echo($row['id'])?>" >
						                <?php echo($row['tb_4_desc']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
						<div class="col-md-4 mb-3">
							<label for="tb_5_up">TB Group 5</label>
							<select class="form-control" name="tb_5_up" id="tb_5_up">
								<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM trial_bal_group_5 ORDER BY tb_5_desc ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            ?>
						            <option value = "<?php echo($row['id'])?>" >
						                <?php echo($row['tb_5_desc']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
						<div class="col-md-4 mb-3" id="ledger_type_div_up">
							<label for="ledgertype_up">Sponsor Type</label>
							<select class="form-control" name="ledgertype_up" id="ledgertype_up">
								<option value="0">-Select Type-</option>
						        <?php
						        	$sql="SELECT * FROM ledger_type ORDER BY ledger_type ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            ?>
						            <option value = "<?php echo($row['ledger_type_id'])?>" >
						                <?php echo($row['ledger_type']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4 mb-3">
							<label for="ledgeraddress_up">Address</label>
							<input type="text" class="form-control" name="ledgeraddress_up" id="ledgeraddress_up">
						</div>
						<div class="col-md-4 mb-3">
							<label for="ledgeremail_up">Email</label>
							<input type="text" class="form-control" name="ledgeremail_up" id="ledgeremail_up">
						</div>
						<div class="col-md-4 mb-3">
							<label for="ledgerphone_up">Telephone</label>
							<input type="text" class="form-control" name="ledgerphone_up" id="ledgerphone_up">
						</div>
					</div>
			</div>
	        <div class="modal-footer">
	        	<input type="hidden" class="form-control" name="ledgerid_up" id="ledgerid_up">
	            <button type="button" name="ledgerupdatebtn" id="ledger_update_btn" class="btn btn-primary" >Update</button>
	            <button type="submit" name="ledgercancelbtn_up" id="ledgercancelbtn_up" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	        </div>
        </div>
      </form>
    </div>
  </div>
</div>