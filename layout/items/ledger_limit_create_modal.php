
<div 
class="modal fade bd-example-modal-lg" 
id="ledger_limit_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="ledger_limit_create_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="ledger_limit_create_modal">Ledger Limit Setup</h5>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
      <form id="ledger_limit_create_form" method="POST">
        <div class="modal-body">
  		<div class="clearfix"></div>
      		<div class="panel-body">
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="ledger_limit_ledger_id">Company</label>
							<input type="text" class="form-control" name="ledger_limit_ledger_id" id="ledger_limit_ledger_id">
						</div>
						<div class="col-md-2 mb-2" id="ledger_limit_description">
							<label for="ledger_limit_description">Description</label>
							<input type="text" class="form-control" name="ledger_limit_description" id="ledger_limit_description">
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
										echo '<option value = "'.$row['id'].'">'.$row['status'].'</option>';
						            };
						        ?>
						    </select>
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