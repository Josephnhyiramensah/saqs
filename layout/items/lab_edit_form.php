<form id="lab_edit_form" method="POST">
	<div class="panel-body">
		<div class="form-row">
			<div class="col-md-6 mb-6">
				<label for="labdesc_up">Description</label>
				<input type="text" class="form-control" name="labdesc_up" id="labdesc_up" value="">
			</div>
			<div class="col-md-4 mb-4">
				<label for="nhisitem_up">Applicable NHIS Item</label>
				<select class="form-control" name="nhisitem_up" id="nhisitem_up"> 
			    	<option value="0">Please Select</option>
			      	<?php
			        	$sql="SELECT * FROM nhis WHERE category_id=3 ORDER BY nhis_item_desc ASC";
						$result=mysqli_query($con,$sql);
			            while($row=mysqli_fetch_array($result))
			            {
			            	echo '<option value = "'.$row['nhis_id'].'">'.$row['nhis_item_desc'].'</option>';
			            }               
			        ?>
			    </select>
			</div>
			<div class="col-md-2 mb-2">
				<label for="lab_gdrg_up">G-DRG</label>
				<input type="text" class="form-control" name="lab_gdrg_up" id="lab_gdrg_up" value="">
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-2 mb-2">
				<label for="price_cash_up">Price (Cash)</label>
				<input type="text" class="form-control" name="price_cash_up" id="price_cash_up" value="">
			</div>
			<div class="col-md-2 mb-2">
				<label for="price_nhis_up">Price (NHIS)</label>
				<input class="form-control" name="price_nhis_up" id="price_nhis_up" value=""> 
			</div>
			<div class="col-md-2 mb-2">
				<label for="price_nhis_topup_up">Price (NHIS-Top-Up)</label>
				<input type="text" class="form-control" name="price_nhis_topup_up" id="price_nhis_topup_up" value=""> 
			</div>
			<div class="col-md-2 mb-2">
				<label for="price_private_up">Price (Prvt Ins.)</label>
				<input type="text" class="form-control" name="price_private_up" id="price_private_up" value="">
			</div>
			<div class="col-md-2 mb-2">
				<label for="price_private_topup_up">Price (Prvt Ins. - Top Up)</label>
				<input type="text" class="form-control" name="price_private_topup_up" id="price_private_topup_up" value="">
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-12 mb-12" id="lab_stock_list_up">
			</div>
		</div>
	</div>
	<div id="lab_edit_form_footer" class="modal-footer">
		<input type="hidden" class="form-control" name="lab_id_up" id="lab_id_up" value="">
	    <button type="button" name="lab_save_btn_up" id="lab_save_btn_up" class="btn btn-primary" >Save</button>
	    <button type="button" name="lab_update_btn_up" id="lab_update_btn_up" class="btn btn-primary" >Update</button>
	    <button type="submit" name="lab_cancel_btn_up" id="lab_cancel_btn_up" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	</div>
</form>