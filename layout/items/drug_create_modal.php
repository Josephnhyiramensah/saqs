<div 
class="modal fade bd-example-modal-xl" 
id="drug_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="drug_create_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="drug_create_modal_header">Drug Setup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="drug_create_form" method="POST">
        <div class="modal-body">
  		<div class="clearfix"></div>
      		<div class="panel-body">
				<div class="form-row">
					<div class="col-md-6 mb-6">
						<label for="brand_name"><strong>Brand Name</strong></label>
						<input type="text" class="form-control bg-light" name="brand_name" id="brand_name">
						<input type="hidden" class="form-control" name="drug_id" id="drug_id">
					</div>
					<div class="col-md-6 mb-6">
						<label for="generic_name"><strong>Generic Name</strong></label>
						<input type="text" class="form-control bg-light" name="generic_name" id="generic_name">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-9 mb-9">
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
				</div>
				<div class="form-row">
					<div class="col-md-3 mb-3">
						<label for="unit_of_measure"><strong>Primary Unit</strong></label>
						<select class="form-control bg-light" name="unit_of_measure" id="unit_of_measure"> 
							<option value="0">Please Select</option>
							<?php
								$sql="SELECT * FROM unit ORDER BY formal_name ASC";
								$result=mysqli_query($con,$sql);
								while($row=mysqli_fetch_array($result))
								{
									echo '<option value = "'.$row['unit_id'].'" >
										'.$row['formal_name'].'
									</option>';
								}               
							?>
						</select>
					</div>
					<div class="col-md-3 mb-3">
						<label for="secondary_unit"><strong>Secondary Unit</strong></label>
						<select class="form-control bg-light" name="secondary_unit" id="secondary_unit"> 
							<option value="0">Please Select</option>
							<?php
								$sql="SELECT * FROM unit ORDER BY formal_name ASC";
								$result=mysqli_query($con,$sql);
								while($row=mysqli_fetch_array($result))
								{
									echo '<option value = "'.$row['unit_id'].'" >
										'.$row['formal_name'].'
									</option>';
								}               
							?>
						</select>
					</div>
					<div class="col-md-3 mb-3">
						<label for="secondary_unit_qty"><strong>Secondary Unit Qty</strong></label>
						<input type="text" class="form-control bg-light" name="secondary_unit_qty" id="secondary_unit_qty">
					</div>
					<div class="col-md-3 mb-3">
						<label for="primary_unit_qty"><strong>Primary Unit Qty</strong></label>
						<input type="text" class="form-control bg-light" name="primary_unit_qty" id="primary_unit_qty">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-3 mb-3">
						<label for="item_group"><strong>Item Group</strong></label>
						<select class="form-control bg-light" name="item_group" id="item_group"> 
							<option value="0">Please Select</option>
							<?php
								$sql="SELECT * FROM stock_group ORDER BY stock_group ASC";
								$result=mysqli_query($con,$sql);
								while($row=mysqli_fetch_array($result))
								{
									echo '<option value = "'.$row['stock_group_id'].'">
										'.$row['stock_group'].'
									</option>';
								}               
							?>
						</select>
					</div>
					<div class="col-md-3 mb-3">
						<label for="item_origin"><strong>Item Origin</strong></label>
						<select class="form-control bg-light" name="item_origin" id="item_origin"> 
							<option value="0">Please Select</option>
							<?php
								$sql="SELECT * FROM stock_origin ORDER BY stock_origin ASC";
								$result=mysqli_query($con,$sql);
								while($row=mysqli_fetch_array($result))
								{
									echo '<option value = "'.$row['stock_origin_id'].'" >
										'.$row['stock_origin'].'
									</option>';
								}               
							?>
						</select>
					</div>
					<div class="col-md-3 mb-3">
						<label for="classification"><strong>Classification</strong></label>
						<select class="form-control bg-light" name="classification" id="classification"> 
							<option value="0">Please Select</option>
							<?php
								$sql="SELECT * FROM drug_class ORDER BY drug_class ASC";
								$result=mysqli_query($con,$sql);
								while($row=mysqli_fetch_array($result))
								{
								?>
								<option value = "<?php echo($row['drug_class_id'])?>" >
									<?php echo($row['drug_class']) ?>
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
				</div>
				<div class="form-row">
					<div class="col-md-2 mb-2">
						<label for="price_cash"><strong>Price (Local)</strong></label>
						<input type="text" class="form-control bg-light" name="price_cash" id="price_cash">
					</div>
					<div class="col-md-2 mb-2">
						<label for="price_cash_foreign"><strong>Price (Foreign)</strong></label>
						<input type="text" class="form-control bg-light" name="price_cash_foreign" id="price_cash_foreign">
					</div>
					<div class="col-md-2 mb-2">
						<label for="price_cash_wholesale"><strong>Price (Wholesale)</strong></label>
						<input type="text" class="form-control bg-light" name="price_cash_wholesale" id="price_cash_wholesale">
					</div>
					<div class="col-md-2 mb-2">
						<label for="price_cash_retail"><strong>Price (Retail)</strong></label>
						<input type="text" class="form-control bg-light" name="price_cash_retail" id="price_cash_retail">
					</div>
					<div class="col-md-2 mb-2" hidden="true">
						<label for="price_nhis">Price - NHIS</label>
						<input type="text" class="form-control bg-light" name="price_nhis" id="price_nhis">
					</div>
					<div class="col-md-2 mb-2" hidden="true">
						<label for="price_nhis_topup">Price - NHIS</label>
						<input type="text" class="form-control bg-light" name="price_nhis_topup" id="price_nhis_topup">
					</div>
					<div class="col-md-2 mb-2" hidden="true">
						<label for="price_prvt">Price - Private</label>
						<input type="text" class="form-control bg-light" name="price_prvt" id="price_prvt">
					</div>
					<div class="col-md-2 mb-2">
						<label for="code"><strong>Code</strong></label>
						<input type="text" class="form-control bg-light" name="code" id="code">
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
				</div>
				<div class="form-row" hidden>
					<div class="col-md-2 mb-2">
						<label for="type"><strong>Type</strong></label>
						<input type="text" class="form-control bg-light" name="type" id="type">
					</div>
					<div class="col-md-4 mb-4">
						<label for="manufacturer"><strong>Manufacturer</trong></label>
						<input type="text" class="form-control bg-light" name="manufacturer" id="manufacturer">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-2 mb-2">
						<label for="age_from"><strong>Age From</strong></label>
						<input type="number" class="form-control bg-light" name="age_from" id="age_from">
					</div>
					<div class="col-md-2 mb-2">
						<label for="age_to"><strong>Age To</strong></label>
						<input type="number" class="form-control bg-light" name="age_to" id="age_to">
					</div>
					
					<div class="col-md-2 mb-2">
						<label for="block_neg"><strong>Block Negative?</strong></label>
						<select class="form-control bg-light" name="block_neg" id="block_neg"> 
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
					<div class="col-md-2 mb-2">
						<label for="batch"><strong>Maintain Batches?</strong></label>
						<select class="form-control bg-light" name="batch" id="batch"> 
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
					<div class="col-md-2 mb-2">
						<label for="expiry_date"><strong>Maintain Expiry Date?</strong></label>
						<select class="form-control bg-light" name="expiry_date" id="expiry_date"> 
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
					<div class="col-md-2 mb-2">
						<label for="days_prompt"><strong>Days to Prompt</strong></label>
						<input type="text" class="form-control bg-light" name="days_prompt" id="days_prompt">
					</div>
				</div>
			</div>
	        <div class="modal-footer">
	            <button type="button" name="drug_save_btn" id="drug_save_btn" class="btn btn-primary" >Save</button>
	            <button type="button" name="drug_update_btn" id="drug_update_btn" class="btn btn-primary" >Update</button>
	            <button type="submit" name="drug_cancel_btn" id="drug_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	        </div>
        </div>
      </form>
    </div>
  </div>
</div>