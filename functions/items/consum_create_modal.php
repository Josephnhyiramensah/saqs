<div 
class="modal fade bd-example-modal-xl" 
id="consumable_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="consumable_create_modal" 
aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="consumable_create_modal_header">Consumable Setup</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="consumable_create_form" method="POST">
					<div class="form-row">
						<div class="col-md-7 mb-7">
							<label for="consum_name">Consumable Name</label>
							<input type="text" class="form-control" name="consum_name" id="consum_name">
							<input type="hidden" class="form-control" name="con_id" id="con_id">
						</div>
						<div class="col-md-2 mb-2">
							<label for="unit_of_measure">Unit of Measure</label>
							<select class="form-control" name="unit_of_measure" id="unit_of_measure"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sql_unit="SELECT * FROM unit ORDER BY formal_name ASC";
									$result_unit=mysqli_query($con,$sql_unit);
						            while($row_unit=mysqli_fetch_array($result_unit))
						            {
						            ?>
						            <option value = "<?php echo($row_unit['unit_id'])?>" >
						                <?php echo($row_unit['formal_name']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="type">Type</label>
							<select class="form-control" name="type" id="type"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM consumable_type ORDER BY consum_type ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            ?>
						            <option value = "<?php echo($row['con_type_id'])?>" >
						                <?php echo($row['consum_type']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2 mb-2">
							<label for="price_cash">Price - Cash</label>
							<input type="text" class="form-control" name="price_cash" id="price_cash">
						</div>
						<div class="col-md-2 mb-2">
							<label for="price_nhis">Price - NHIS</label>
							<input type="text" class="form-control" name="price_nhis" id="price_nhis">
						</div>
						<div class="col-md-2 mb-2">
							<label for="price_prvt">Price - Private</label>
							<input type="text" class="form-control" name="price_prvt" id="price_prvt">
						</div>
						<div class="col-md-6 mb-6">
							<label for="manufacturer">Manufacturer</label>
							<input type="text" class="form-control" name="manufacturer" id="manufacturer">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="block_neg">Block Negative?</label>
							<select class="form-control" name="block_neg" id="block_neg"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM boolen";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            ?>
						            <option value = "<?php echo($row['boolen_id'])?>" >
						                <?php echo($row['boolen']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="batch">Maintain Batches?</label>
							<select class="form-control" name="batch" id="batch"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM boolen";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            ?>
						            <option value = "<?php echo($row['boolen_id'])?>" >
						                <?php echo($row['boolen']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="expiry_date">Maintain Expiry Date?</label>
							<select class="form-control" name="expiry_date" id="expiry_date"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM boolen";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            ?>
						            <option value = "<?php echo($row['boolen_id'])?>" >
						                <?php echo($row['boolen']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="days_prompt">Days to Prompt</label>
							<input type="text" class="form-control" name="days_prompt" id="days_prompt">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="min_level">Minimum Level</label>
							<input type="text" class="form-control" name="min_level" id="min_level">
						</div>
						<div class="col-md-3 mb-3">
							<label for="max_level">Maximum Level</label>
							<input type="text" class="form-control" name="max_level" id="max_level">
						</div>
						<div class="col-md-3 mb-3">
							<label for="re_order_level">Re-Order Level</label>
							<input type="text" class="form-control" name="re_order_level" id="re_order_level">
						</div>
						<div class="col-md-3 mb-3">
							<label for="eoq">EOQ</label>
							<input type="text" class="form-control" name="eoq" id="eoq">
						</div>
					</div>
				    <div class="modal-footer">
				        <button type="button" name="consum_save_btn" id="consum_save_btn" class="btn btn-primary" >Save</button>
				        <button type="button" name="consum_update_btn" id="consum_update_btn" class="btn btn-primary" >Update</button>
				        <button type="submit" name="consum_cancel_btn" id="consum_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>