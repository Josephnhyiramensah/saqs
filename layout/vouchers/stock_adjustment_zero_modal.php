<div 
class="modal fade hide bd-example-modal-lg" 
id="stock_adjustment_zero_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_adjustment_zero_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_adjustment_zero_modal_header">Zero Stock</h5>
			</div>
			<div class="modal-body">
				<form id="stock_adjustment_zero_modal_form" method="POST">
	                <div class="panel-body">
	                	<div id="stock_adjustment_zero_modal_warning"></div>
                        <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="stock_adjustment_zero_warehouse">Warehouse</label>
	                            <select class="form-control bg-light" name="stock_adjustment_zero_warehouse" id="stock_adjustment_zero_warehouse">
					                <option value="all">ALL</option>';
			                    <?php
			                        $sql_warehouse = "SELECT * FROM warehouse ORDER BY warehouse_desc ASC";
			                        $result_warehouse = mysqli_query($con,$sql_warehouse);
			                        while($row_warehouse = mysqli_fetch_array($result_warehouse))
			                        {
			                        	echo '<option value ="'.$row_warehouse['warehouse_id'].'">'.$row_warehouse['warehouse_desc'].'</option>';
			                        };
			                    ?>
					        	</select>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="stock_adjustment_zero_date">Applicable Date</label>
	                            <input type="date" name="stock_adjustment_zero_date" class="form-control bg-light" id="stock_adjustment_zero_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="stock_adjustment_zero_ok_btn" id="stock_adjustment_zero_ok_btn" class="btn btn-primary">Save</button>
	                    <button type="submit" name="stock_adjustment_zero_cancel_btn" id="stock_adjustment_zero_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>