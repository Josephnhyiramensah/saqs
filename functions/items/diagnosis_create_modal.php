<div 
class="modal fade bd-example-modal-xl" 
id="diagnosis_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="diagnosis_create_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="diagnosis_create_modal_header">Diagnosis Setup</h5>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
      <form id="diagnosis_create_form" method="POST">
        <div class="modal-body">
  		<div class="clearfix"></div>
      		<div class="panel-body">
					<div class="form-row">
						<div class="col-md-8 mb-8">
							<label for="diagnosis">Diagnosis</label>
							<input type="text" class="form-control" name="diagnosis" id="diagnosis">
							<input type="hidden" class="form-control" name="diagnosis_id" id="diagnosis_id">
						</div>
						<div class="col-md-4 mb-4">
							<label for="nhisitem">Applicable NHIS Item</label>
							<select class="form-control" name="nhisitem" id="nhisitem"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM nhis WHERE category_id=6 ORDER BY nhis_item_desc ASC";
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
							<label for="price_adult">Price - Adult</label>
							<input type="text" class="form-control" name="price_adult" id="price_adult">
						</div>
						<div class="col-md-2 mb-2">
							<label for="price_child">Price - Child</label>
							<input type="text" class="form-control" name="price_child" id="price_child">
						</div>
						<div class="col-md-2 mb-2">
							<label for="gdrg_adult">G-DRG - Adult</label>
							<input type="text" class="form-control" name="gdrg_adult" id="gdrg_adult">
						</div>
						<div class="col-md-2 mb-2">
							<label for="gdrg_child">G-DRG - Child</label>
							<input type="text" class="form-control" name="gdrg_child" id="gdrg_child">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-6">
							<label for="disease_categroy">Disease Category</label>
							<select class="form-control" name="disease_categroy" id="disease_categroy"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM diagnosis_category ORDER BY category ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            ?>
						            <option value = "<?php echo($row['diag_cat_id'])?>" >
						                <?php echo($row['category']) ?>
						            </option>
						            <?php
						            }
						        ?>
						    </select>
						</div>
						<div class="col-md-6 mb-6">
							<label for="disease_group">Disease Group</label>
							<select class="form-control" name="disease_group" id="disease_group"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM diagnosis_group ORDER BY disease_group ASC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            ?>
						            <option value = "<?php echo($row['diag_group_id'])?>" >
						                <?php echo($row['disease_group']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
					</div>
			</div>
	        <div class="modal-footer">
	            <button type="button" name="diagnosis_save_btn" id="diagnosis_save_btn" class="btn btn-primary" >Save</button>
	            <button type="button" name="diagnosis_update_btn" id="diagnosis_update_btn" class="btn btn-primary" >Update</button>
	            <button type="submit" name="diagnosis_cancel_btn" id="diagnosis_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	        </div>
        </div>
      </form>
    </div>
  </div>
</div>