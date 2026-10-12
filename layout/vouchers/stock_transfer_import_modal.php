<div 
class="modal fade hide bd-example-modal-xl" 
id="stock_transfer_import_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_transfer_import_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 40%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_transfer_import_modal_header">Stock Take Import</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="stock_transfer_import_form" action="stock_transfer_import.php" method="POST" enctype="multipart/form-data">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
								<label for="stock_transfer_import_store_to">Store</label>
	                            <input type="hidden" class="form-control" name="stock_transfer_import_requisition_id" id="stock_transfer_import_requisition_id">
	                            <input type="hidden" class="form-control" name="stock_transfer_import_store_from" id="stock_transfer_import_store_from">
								<select class="form-control bg-light" name="stock_transfer_import_store_to" id="stock_transfer_import_store_to">
									<option value="0">Select Store</option>';
									<?php
									$sql_warehouse = "SELECT * FROM warehouse ORDER BY warehouse_desc ASC";
									$result_warehouse = mysqli_query($con,$sql_warehouse);
									while($row_warehouse = mysqli_fetch_array($result_warehouse))
									{
										if($row_warehouse['warehouse_id']==$_SESSION['warehouse_id'])
										{
											echo '<option value ="'.$row_warehouse['warehouse_id'].'" selected="selected">'.$row_warehouse['warehouse_desc'].'</option>';
										}
										else
										{
											echo '<option value ="'.$row_warehouse['warehouse_id'].'">'.$row_warehouse['warehouse_desc'].'</option>';
										};
									};
									?>
								</select>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="stock_transfer_import_date">Date</label>
	                            <input type="date" class="form-control" name="stock_transfer_import_date" id="stock_transfer_import_date">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="stock_transfer_import_file">Stock Take CSV file</label>
	                            <input type="file" class="form-control" name="stock_transfer_import_file" id="stock_transfer_import_file">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="submit" name="stock_transfer_import_import_btn" id="stock_transfer_import_import_btn" class="btn btn-primary">Import</button>
	                    <button type="button" name="stock_transfer_import_cancel_btn" id="stock_transfer_import_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>