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
						$result = mysqli_query($con,$sql);
			            while($row = mysqli_fetch_array($result))
			            {
			            	echo '<option value = "'.$row['nhis_id'].'">'.$row['nhis_item_desc'].'</option>';
			            };
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
		<div class="form-row">
			<div class="col-md-12 mb-12" id="lab_stock_list">
				<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="lab_stock_list_table">
					<tr>
						<th width="55%">Stock Item</th>
						<th width="20%" class="action-td">Qty</th>
						<th width="20%" class="action-td">Warehouse</th>
						<th width="5%" class="action-td">Action</th>
					</tr>
					<tr id="lab_stk1">
						<td>
							<select class="form-control lab_stock_item_id bg-light" name="lab_stock_item_id[]" id="lab_stock_item_id1" data-id="1" style="border-width:0px"> 
								<option value="0">Please Select</option>
								<?php
									$company_id = $_SESSION['company_id'];
									$sql="SELECT * FROM drugs WHERE company_id = '$company_id' ORDER BY brand_name ASC";
									$result=mysqli_query($con,$sql);
									while($row=mysqli_fetch_array($result))
									{
										echo '<option value = "'.$row['drug_id'].'">'.$row['brand_name'].'</option>';
									};
								?>
							</select>
						</td>
						<td class = "action-td">
							<input type="text" name="lab_stock_item_qty[]" class="form-control bg-light lab_stock_item_qty text-center" id="lab_stock_item_qty1" data-id="1" style="border-width:0px">
						</td>
						<td>
							<select class="form-control lab_stock_item_warehouse_id bg-light" name="lab_stock_item_warehouse_id[]" id="lab_stock_item_warehouse_id1" data-id="1" style="border-width:0px"> 
								<option value="0">Please Select</option>
								<?php
									$company_id = $_SESSION['company_id'];
									$sql="SELECT * FROM warehouse WHERE company_id = '$company_id' ORDER BY warehouse_desc ASC";
									$result=mysqli_query($con,$sql);
									while($row=mysqli_fetch_array($result))
									{
										echo '<option value = "'.$row['warehouse_id'].'">'.$row['warehouse_desc'].'</option>';
									};
								?>
							</select>
						</td>
						<td class = "action-td">
							<!--<a href="#" id="delete_lab_stock_item" class="delete_lab_stock_item" data-id="1"><i class="fa fa-trash fa-sm"></i></a>-->
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="modal-footer">
	    <button type="button" name="lab_save_btn" id="lab_save_btn" class="btn btn-primary" >Save</button>
	    <button type="button" name="lab_update_btn" id="lab_update_btn" class="btn btn-primary" >Update</button>
	    <button type="submit" name="lab_cancel_btn" id="lab_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	</div>
</form>