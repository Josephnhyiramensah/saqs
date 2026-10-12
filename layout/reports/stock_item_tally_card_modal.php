<div 
class="modal fade hide bd-example-modal-lg" 
id="stock_item_tally_card_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_item_tally_card_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_item_tally_card_modal_header">Tally Card Report</h5>
			</div>
			<div class="modal-body">
				<form id="stock_item_tally_card_modal_form" method="POST">
	                <div class="panel-body">
	                	<div id="stock_item_tally_card_modal_warning"></div>
                        <input type="hidden" name="stock_item_tally_card_company_id" class="form-control bg-light" id="stock_item_tally_card_company_id">
                        <input type="hidden" name="stock_item_tally_card_user_id" class="form-control bg-light" id="stock_item_tally_card_user_id">
                        <input type="hidden" name="stock_item_tally_card_user_super_id" class="form-control bg-light" id="stock_item_tally_card_user_super_id">
                        <input type="hidden" name="stock_item_tally_card_category_id" class="form-control bg-light" id="stock_item_tally_card_category_id">
                        <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="stock_item_tally_card_item">Item</label>
	                            <select class="form-control bg-light" name="stock_item_tally_card_item" id="stock_item_tally_card_item">
					                <option value="">-Please select-</option>';
			                    <?php
                                    $sql="SELECT * FROM stock_items ORDER BY stock_item ASC";
                                    $result = mysqli_query($con,$sql);
                                    while($row = mysqli_fetch_array($result))
                                    {
                                        echo '<option value ="'.$row['stock_item_id'].'">'.$row['stock_item'].'</option>';
                                    }
                                ?>
					        	</select>
	                        </div>
	                    </div>
                        <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="stock_item_tally_card_warehouse">Warehouse</label>
	                            <select class="form-control bg-light" name="stock_item_tally_card_warehouse" id="stock_item_tally_card_warehouse">
					                <option value="all">ALL</option>';
			                    <?php
			                        $sql_warehouse = "SELECT * FROM warehouse";
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
	                            <label for="stock_item_tally_card_start_date">Start Date</label>
	                            <input type="date" name="stock_item_tally_card_start_date" class="form-control bg-light" id="stock_item_tally_card_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="stock_item_tally_card_end_date">End Date</label>
	                            <input type="date" name="stock_item_tally_card_end_date" class="form-control bg-light" id="stock_item_tally_card_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="stock_item_tally_card_ok_btn" id="stock_item_tally_card_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="stock_item_tally_card_cancel_btn" id="stock_item_tally_card_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>