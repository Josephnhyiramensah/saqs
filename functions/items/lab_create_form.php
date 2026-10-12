<form id="lab_create_form" method="POST">
	<div class="panel-body">
		<div class="form-row">
			<div class="col-md-6 mb-6">
				<label for="labdesc">Description</label>
				<input type="text" class="form-control" name="labdesc" id="labdesc">
			</div>
			<div class="col-md-4 mb-4">
				<label for="nhisitem">Applicable NHIS Item</label>
				<select class="form-control" name="nhisitem" id="nhisitem"> 
			    	<option value="0">Please Select</option>
			        <?php
			        	$sql="SELECT * FROM nhis WHERE category_id=3 ORDER BY nhis_item_desc ASC";
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
				<label for="lab_gdrg">G-DRG</label>
				<input type="text" class="form-control" name="lab_gdrg" id="lab_gdrg">
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-2 mb-2">
				<label for="price_cash">Price (Cash)</label>
				<input type="text" class="form-control" name="price_cash" id="price_cash">
			</div>
			<div class="col-md-2 mb-2">
				<label for="price_nhis">Price (NHIS)</label>
				<input class="form-control" name="price_nhis" id="price_nhis"> 
			</div>
			<div class="col-md-2 mb-2">
				<label for="price_nhis_topup">Price (NHIS-Top-Up)</label>
				<input type="text" class="form-control" name="price_nhis_topup" id="price_nhis_topup"> 
			</div>
			<div class="col-md-2 mb-2">
				<label for="price_private">Price (Prvt Ins.)</label>
				<input type="text" class="form-control" name="price_private" id="price_private">
			</div>
			<div class="col-md-2 mb-2">
				<label for="price_private_topup">Price (Prvt Ins. - Top Up)</label>
				<input type="text" class="form-control" name="price_private_topup" id="price_private_topup">
			</div>
		</div>
	</div>
	<div class="modal-footer">
	    <button type="button" name="lab_save_btn" id="lab_save_btn" class="btn btn-primary" >Save</button>
	    <button type="button" name="lab_update_btn" id="lab_update_btn" class="btn btn-primary" >Update</button>
	    <button type="submit" name="lab_cancel_btn" id="lab_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	</div>
</form>