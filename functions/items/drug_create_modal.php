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
							<label for="brand_name">Brand Name</label>
							<input type="text" class="form-control" name="brand_name" id="brand_name">
							<input type="hidden" class="form-control" name="drug_id" id="drug_id">
						</div>
						<div class="col-md-6 mb-6">
							<label for="generic_name">Generic Name</label>
							<input type="text" class="form-control" name="generic_name" id="generic_name">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-10 mb-10">
							<label for="nhisitem">Applicable NHIS Item</label>
							<select class="form-control" name="nhisitem" id="nhisitem"> 
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
						<div class="col-md-2 mb-2">
							<label for="code">Code</label>
							<input type="text" class="form-control" name="code" id="code">
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
						<div class="col-md-2 mb-2">
							<label for="unit_of_measure">Unit of Measure</label>
							<select class="form-control" name="unit_of_measure" id="unit_of_measure"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM unit ORDER BY formal_name ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
										?>
											<option value = "<?php echo($row['unit_id'])?>" >
												<?php echo($row['formal_name']) ?>
											</option>
										<?php
						            }               
						        ?>
						    </select>
						</div>
						<div class="col-md-4 mb-4">
							<label for="route">Route</label>
							<select class="form-control" name="route" id="route"> 
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
						<div class="col-md-2 mb-2">
							<label for="gender">Gender</label>
							<select class="form-control" name="gender" id="gender"> 
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
							<label for="classification">Classification</label>
							<select class="form-control" name="classification" id="classification"> 
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
						<div class="col-md-2 mb-2">
							<label for="category">Category</label>
							<select class="form-control" name="category" id="category"> 
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
							<label for="type">Type</label>
							<input type="text" class="form-control" name="type" id="type">
						</div>
						<div class="col-md-4 mb-4">
							<label for="manufacturer">Manufacturer</label>
							<input type="text" class="form-control" name="manufacturer" id="manufacturer">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2 mb-2">
							<label for="age_from">Age From</label>
							<input type="number" class="form-control" name="age_from" id="age_from">
						</div>
						<div class="col-md-2 mb-2">
							<label for="age_to">Age To</label>
							<input type="number" class="form-control" name="age_to" id="age_to">
						</div>
						
						<div class="col-md-2 mb-2">
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
						<div class="col-md-2 mb-2">
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
						<div class="col-md-2 mb-2">
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
						<div class="col-md-2 mb-2">
							<label for="days_prompt">Days to Prompt</label>
							<input type="text" class="form-control" name="days_prompt" id="days_prompt">
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