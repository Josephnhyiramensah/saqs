<div 
class="modal fade bd-example-modal-xl" 
id="stock_item_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_item_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 90%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_item_create_modal_header">Stock Item Setup</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="stock_item_create_form" method="POST">
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="stock_item_name"><strong>Stock Item</strong></label>
							<input type="text" class="form-control bg-light" name="stock_item_name" id="stock_item_name">
							<input type="hidden" class="form-control" name="stock_item_id" id="stock_item_id">
						</div>
						<div class="col-md-3 mb-3">
							<label for="barcode"><strong>Barcode</strong></label>
							<input type="text" class="form-control bg-light" name="barcode" id="barcode">
						</div>
						<div class="col-md-3 mb-3">
							<label for="stock_item_code"><strong>Code</strong></label>
							<input type="text" class="form-control bg-light" name="stock_item_code" id="stock_item_code">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4 mb-4">
							<label for="stock_item_type_id"><strong>Type</strong></label>
							<select class="form-control bg-light" name="stock_item_type_id" id="stock_item_type_id"> 
								<option value="0">Please Select</option>
								<?php
									$sql_unit="SELECT * FROM stock_item_type ORDER BY stock_item_type ASC";
									$result_unit = mysqli_query($con,$sql_unit);
									while($row_unit=mysqli_fetch_array($result_unit))
									{
										echo '<option value = "'.$row_unit['stock_item_type_id'].'">'.
										$row_unit['stock_item_type'].'</option>';
									}               
								?>
							</select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="route"><strong>Route</strong></label>
							<select class="form-control bg-light" name="route" id="route"> 
								<option value="0">Please Select</option>
								<?php
									$sql="SELECT * FROM drug_route ORDER BY route ASC";
									$result=mysqli_query($con,$sql);
									while($row=mysqli_fetch_array($result))
									{
									?>
									<option value = "<?php echo($row['route_id'])?>" >
										<?php echo($row['route']) ?>
									</option>
									<?php
									}               
								?>
							</select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="category"><strong>Category</strong></label>
							<select class="form-control bg-light" name="category" id="category"> 
								<option value="0">Please Select</option>
								<?php
									$sql="SELECT * FROM drug_group ORDER BY drug_group ASC";
									$result=mysqli_query($con,$sql);
									while($row=mysqli_fetch_array($result))
									{
									?>
									<option value = "<?php echo($row['group_id'])?>" >
										<?php echo($row['drug_group']) ?>
									</option>
									<?php
									}               
								?>
							</select>
						</div>
						<div class="col-md-2 mb-2">
							<label for="stock_item_origin"><strong>Origin</strong></label>
							<select class="form-control bg-light" name="stock_item_origin" id="stock_item_origin"> 
								<option value="0">Please Select</option>
								<option value="UK">UK</option>
								<option value="LOCAL">LOCAL</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2 mb-2">
							<label for="stock_item_usage"><strong>Usage</strong></label>
							<select class="form-control bg-light" name="stock_item_usage" id="stock_item_usage"> 
								<option value="Both">Both</option>
								<option value="Hospital">Hospital</option>
								<option value="Shop">Shop</option>
							</select>
						</div>
						<div class="col-md-2 mb-2">
							<label for="gender"><strong>Gender</strong></label>
							<select class="form-control bg-light" name="gender" id="gender"> 
								<option value="0">Please Select</option>
								<?php
									$sql="SELECT * FROM gender";
									$result=mysqli_query($con,$sql);
									while($row=mysqli_fetch_array($result))
									{
									?>
									<option value = "<?php echo($row['gender_id'])?>" >
										<?php echo($row['gender']) ?>
									</option>
									<?php
									}               
								?>
							</select>
						</div>
						<div class="col-md-2 mb-2">
							<label for="age_from"><strong>Age From</strong></label>
							<input type="number" class="form-control bg-light" name="age_from" id="age_from">
						</div>
						<div class="col-md-2 mb-2">
							<label for="age_to"><strong>Age To</strong></label>
							<input type="number" class="form-control bg-light" name="age_to" id="age_to">
						</div>
						<div class="col-md-2 mb-2">
							<label for="price_nhis_topup"><strong>Price - NHIS</strong></label>
							<input type="text" class="form-control bg-light" name="price_nhis_topup" id="price_nhis_topup">
						</div>
						<div class="col-md-2 mb-2">
							<label for="price_prvt"><strong>Price - Private</strong></label>
							<input type="text" class="form-control bg-light" name="price_prvt" id="price_prvt">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2 mb-2">
							<label for="price_cash"><strong>Price - Retail</strong></label>
							<input type="text" class="form-control bg-light" name="price_cash" id="price_cash">
						</div>
						<div class="col-md-2 mb-2">
							<label for="price_cash_wholesale"><strong>Price - Wholesale</strong></label>
							<input type="text" class="form-control bg-light" name="price_cash_wholesale" id="price_cash_wholesale">
						</div>
						<div class="col-md-3 mb-3">
							<label for="unit_of_measure"><strong>Unit (Wholesale)</strong></label>
							<select class="form-control bg-light" name="unit_of_measure" id="unit_of_measure"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sql_unit="SELECT * FROM unit ORDER BY formal_name ASC";
									$result_unit=mysqli_query($con,$sql_unit);
						            while($row_unit=mysqli_fetch_array($result_unit))
						            {
						            	echo '<option value = "'.$row_unit['unit_id'].'">
						                '.$row_unit['formal_name'].'</option>';
						            }               
						        ?>
						    </select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="unit_of_measure_retail"><strong>Unit (Retail)</strong></label>
							<select class="form-control bg-light" name="unit_of_measure_retail" id="unit_of_measure_retail"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sql_unit="SELECT * FROM unit ORDER BY formal_name ASC";
									$result_unit=mysqli_query($con,$sql_unit);
						            while($row_unit=mysqli_fetch_array($result_unit))
						            {
						            	echo '<option value = "'.$row_unit['unit_id'].'">
						                '.$row_unit['formal_name'].'</option>';
						            }               
						        ?>
						    </select>
						</div>
						<div class="col-md-2 mb-2">
							<label for="unit_secondary_in_primary"><strong>Retail-In-Wholesale</strong></label>
							<input type="text" class="form-control bg-light" name="unit_secondary_in_primary" id="unit_secondary_in_primary">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2 mb-2">
							<label for="cost_price_retail"><strong>Cost - Retail</strong></label>
							<input type="text" class="form-control bg-light" name="cost_price_retail" id="cost_price_retail">
						</div>
						<div class="col-md-2 mb-2">
							<label for="cost_price_wholesale"><strong>Cost - Wholesale</strong></label>
							<input type="text" class="form-control bg-light" name="cost_price_wholesale" id="cost_price_wholesale">
						</div>
						<div class="col-md-2 mb-2">
							<label for="min_level"><strong>Minimum Level</strong></label>
							<input type="text" class="form-control bg-light" name="min_level" id="min_level">
						</div>
						<div class="col-md-2 mb-2">
							<label for="max_level"><strong>Maximum Level</strong></label>
							<input type="text" class="form-control bg-light" name="max_level" id="max_level">
						</div>
						<div class="col-md-2 mb-2">
							<label for="re_order_level"><strong>Re-Order Level</strong></label>
							<input type="text" class="form-control bg-light" name="re_order_level" id="re_order_level">
						</div>
						<div class="col-md-2 mb-2">
							<label for="eoq"><strong>EOQ</strong></label>
							<input type="text" class="form-control bg-light" name="eoq" id="eoq">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="block_neg"><strong>Block Negative?</strong></label>
							<select class="form-control bg-light" name="block_neg" id="block_neg"> 
						    	<option value="0">Please Select</option>
						    	<option value="Yes">Yes</option>
						    	<option value="No">No</option>
						    </select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="batch"><strong>Maintain Batches?</strong></label>
							<select class="form-control bg-light" name="batch" id="batch"> 
						    	<option value="0">Please Select</option>
						    	<option value="Yes">Yes</option>
						    	<option value="No">No</option>
						    </select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="expiry_date"><strong>Maintain Expiry Date?</strong></label>
							<select class="form-control bg-light" name="expiry_date" id="expiry_date"> 
						    	<option value="0">Please Select</option>
						    	<option value="Yes">Yes</option>
						    	<option value="No">No</option>
						    </select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="days_prompt"><strong>Days to Prompt</strong></label>
							<input type="text" class="form-control bg-light" name="days_prompt" id="days_prompt">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="nhisitem"><strong>Applicable NHIS Item</strong></label>
							<select class="form-control bg-light" name="nhisitem" id="nhisitem"> 
								<option value="0">Please Select</option>
								<?php
									$sql="SELECT * FROM nhis WHERE category_id=2 ORDER BY nhis_item_desc ASC";
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
						<div class="col-md-6 mb-6">
							<label for="manufacturer"><strong>Manufacturer</strong></label>
							<input type="text" class="form-control bg-light" name="manufacturer" id="manufacturer">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="warning"><strong>Warning</strong></label>
							<input type="text" class="form-control bg-light" name="warning" id="warning">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="item_label"><strong>Label</strong></label>
							<textarea type="textarea" rows="4"  class="form-control bg-light" name="item_label" id="item_label"></textarea>
						</div>
					</div>
				    <div class="modal-footer">
				        <button type="button" name="stock_item_save_btn" id="stock_item_save_btn" class="btn btn-primary" >Save</button>
				        <button type="button" name="stock_item_update_btn" id="stock_item_update_btn" class="btn btn-primary" >Update</button>
				        <button type="submit" name="stock_item_cancel_btn" id="stock_item_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>