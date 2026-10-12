<div 
class="modal fade bd-example-modal-xl" 
id="surgery_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="surgery_create_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="surgery_create_modal_header">Procedure/Surgery Setup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="surgery_create_form" method="POST">
        <div class="modal-body">
  		<div class="clearfix"></div>
      		<div class="panel-body">
					<div class="form-row">
						<div class="col-md-8 mb-8">
							<label for="surgery">Surgery</label>
							<input type="text" class="form-control" name="surgery" id="surgery">
							<input type="hidden" class="form-control" name="surgery_id" id="surgery_id">
						</div>
						<div class="col-md-4 mb-4">
							<label for="nhisitem">Applicable NHIS Item</label>
							<select class="form-control" name="nhisitem" id="nhisitem"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM nhis WHERE category_id=5 ORDER BY nhis_item_desc ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            ?>
						            <option value = "<?php echo($row['nhis_id'])?>" >
						                <?php echo($row['nhis_item_desc']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4 mb-4">
							<label for="icd_10">ICD 10</label>
							<input type="text" class="form-control" name="icd_10" id="icd_10">
						</div>
						<div class="col-md-2 mb-2">
							<label for="price_cash">Price - Cash</label>
							<input type="text" class="form-control" name="price_cash" id="price_cash">
						</div>
						<div class="col-md-2 mb-2">
							<label for="price_private">Price - Private</label>
							<input type="text" class="form-control" name="price_private" id="price_private">
						</div>
						<div class="col-md-2 mb-2">
							<label for="price_private_topup">Price - Private Top Up</label>
							<input type="text" class="form-control" name="price_private_topup" id="price_private_topup">
						</div>
						<div class="col-md-2 mb-2">
							<label for="price_nhis_topup">Price - NHIS Top Up</label>
							<input type="text" class="form-control" name="price_nhis_topup" id="price_nhis_topup">
						</div>
					</div>
			</div>
	        <div class="modal-footer">
	            <button type="button" name="surgery_save_btn" id="surgery_save_btn" class="btn btn-primary" >Save</button>
	            <button type="button" name="surgery_update_btn" id="surgery_update_btn" class="btn btn-primary" >Update</button>
	            <button type="submit" name="surgery_cancel_btn" id="surgery_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	        </div>
        </div>
      </form>
    </div>
  </div>
</div>