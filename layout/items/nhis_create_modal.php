<div 
class="modal fade bd-example-modal-xl" 
id="nhiscreatemodal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="nhiscreatemodal" 
aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="nhis_create_modal_header">NHIS Item Setup</h5>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
      <form id="nhis_create_form" method="POST">
        <div class="modal-body">
  		<div class="clearfix"></div>
      		<div class="panel-body">
					<div class="form-row">
						<div class="col-md-8 mb-8">
							<label for="nhisdesc">Description</label>
							<input type="text" class="form-control" name="nhisdesc" id="nhisdesc">
							<input type="hidden" class="form-control" name="nhis_id" id="nhis_id">
						</div>
						<div class="col-md-4 mb-4">
							<label for="category">Category</label>
							<select class="form-control" name="category" id="category"> 
						    <option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM item_category ORDER BY category_desc DESC";
									$result=mysqli_query($con,$sql);
						            while($row=mysqli_fetch_array($result))
						            {
						            ?>
						            <option value = "<?php echo($row['category_id'])?>" >
						                <?php echo($row['category_desc']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="price_adult">Price - Adult</label>
							<input type="text" class="form-control" name="price_adult" id="price_adult">
						</div>
						<div class="col-md-3 mb-3">
							<label for="price_child">Price - Child</label>
							<input type="text" class="form-control" name="price_child" id="price_child">
						</div>
						<div class="col-md-3 mb-3">
							<label for="price">Price</label>
							<input type="text" class="form-control" name="price" id="price">
						</div>
						<div class="col-md-3 mb-3">
							<label for="price_topup">Price - Topup</label>
							<input type="text" class="form-control" name="price_topup" id="price_topup">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-4 mb-4">
							<label for="code">Code</label>
							<input type="text" class="form-control" name="code" id="code">
						</div>
						<div class="col-md-4 mb-4">
							<label for="gdrg_adult">G-DRG - Adult</label>
							<input type="text" class="form-control" name="gdrg_adult" id="gdrg_adult">
						</div>
						<div class="col-md-4 mb-4">
							<label for="gdrg_child">G-DRG - Child</label>
							<input type="text" class="form-control" name="gdrg_child" id="gdrg_child">
						</div>
					</div>
			</div>
	        <div class="modal-footer">
	            <button type="button" name="nhissavebtn" id="nhissavebtn" class="btn btn-primary" >Save</button>
	            <button type="button" name="nhisupdatebtn" id="nhisupdatebtn" class="btn btn-primary" >Update</button>
	            <button type="submit" name="nhiscancelbtn" id="nhiscancelbtn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	        </div>
        </div>
      </form>
    </div>
  </div>
</div>