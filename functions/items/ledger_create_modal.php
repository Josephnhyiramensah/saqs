
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
						<div class="col-md-6 mb-6">
							<label for="ledgerdesc">Description</label>
							<input type="text" class="form-control" name="ledgerdesc" id="ledgerdesc">
						</div>
						<div class="col-md-2 mb-2" id="ledger_code_div">
							<label for="ledgerCode">Code</label>
							<input type="text" class="form-control" name="ledgerCode" id="ledgerCode">
						</div>
						<div class="col-md-4 mb-4">
							<label for="ledgerstatus">Status</label>
							<select class="form-control" name="ledgerstatus" id="ledgerstatus"> 
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
						<div class="col-md-4 mb-3">
							<label for="tb_2">TB Group 2</label>
							<select class="form-control" name="tb_2" id="tb_2"> 
						    </select>
						</div>
						<div class="col-md-4 mb-3">
							<label for="tb_3">TB Group 3</label>
							<select class="form-control" name="tb_3" id="tb_3">
						    </select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4 mb-3">
							<label for="tb_4">TB Group 4</label>
							<select class="form-control" name="tb_4" id="tb_4"> 
						    </select>
						</div>
						<div class="col-md-4 mb-3">
							<label for="tb_5">TB Group 5</label>
							<select class="form-control" name="tb_5" id="tb_5"> 
						    </select>
						</div>
						<div class="col-md-4 mb-3" id="ledger_type_div"
						>
							<label for="ledgertype">Sponsor Type</label>
							<select class="form-control" name="ledgertype" id="ledgertype">
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
							<label for="ledgeraddress">Address</label>
							<input type="text" class="form-control" name="ledgeraddress" id="ledgeraddress">
						</div>
						<div class="col-md-4 mb-3">
							<label for="ledgeremail">Email</label>
							<input type="text" class="form-control" name="ledgeremail" id="ledgeremail">
						</div>
						<div class="col-md-4 mb-3">
							<label for="ledgerphone">Telephone</label>
							<input type="text" class="form-control" name="ledgerphone" id="ledgerphone">
						</div>
					</div>
			</div>
	        <div class="modal-footer">
	            <button type="button" name="ledgersavebtn" id="ledger_save_btn" class="btn btn-primary" >Save</button>
	            <button type="submit" name="ledgercancelbtn" id="ledgercancelbtn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	        </div>
        </div>
      </form>
    </div>
  </div>
</div>