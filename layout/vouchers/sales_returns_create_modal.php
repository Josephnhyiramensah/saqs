<div 
class="modal fade hide bd-example-modal-xl" 
id="stock_sales_returns_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_sales_returns_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 95%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_sales_returns_create_modal_header">Sales Returns Voucher Creation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="stock_sales_returns_create_form" method="POST">
	                <input type="hidden" name="stock_sales_returns_stock_sales_id" class="form-control bg-light" id="stock_sales_returns_stock_sales_id">
	                <input type="hidden" name="stock_sales_return_id" class="form-control bg-light" id="stock_sales_return_id">
	                <div class="panel-body">
						<div id="stock_sales_returns_create_form_msg"></div>
	                    <div class="form-row">
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="stock_sales_returns_debit_ledger"><strong>Debit Ledger</strong></label>
	                            <select class="form-control bg-light" name="stock_sales_returns_debit_ledger" id="stock_sales_returns_debit_ledger" hidden="true"> 
	                                <option value="0">Please Select</option>
		                                <?php
		                                    $sql="SELECT * FROM ledgers ORDER BY ledger_desc ASC";
		                                    $result = mysqli_query($con,$sql);
		                                    while($row = mysqli_fetch_array($result))
		                                    {
												if($row['ledger_id'] == 18)
		                                    	{
													echo '<option value = "'.$row['ledger_id'].'" selected="selected">
		                                        	'.$row['ledger_desc'].'</option>';
												}
												else
												{
													echo '<option value = "'.$row['ledger_id'].'">
		                                        	'.$row['ledger_desc'].'</option>';
												}
		                                    };
		                                ?>
	                            </select>
	                            <select class="form-control bg-light" name="stock_sales_returns_debit_ledgerD" id="stock_sales_returns_debit_ledgerD" disabled="true"> 
	                                <option value="0">Please Select</option>
		                                <?php
		                                    $sql="SELECT * FROM ledgers ORDER BY ledger_desc ASC";
		                                    $result=mysqli_query($con,$sql);
		                                    while($row = mysqli_fetch_array($result))
		                                    {
												if($row['ledger_id'] == 18)
		                                    	{
													echo '<option value = "'.$row['ledger_id'].'" selected="selected">
		                                        	'.$row['ledger_desc'].'</option>';
												}
												else
												{
													echo '<option value = "'.$row['ledger_id'].'">
		                                        	'.$row['ledger_desc'].'</option>';
												}
		                                    };
		                                ?>
	                            </select>
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="stock_sales_returns_credit_ledger"><strong>Credit Ledger</strong></label>
	                            <select class="form-control bg-light" name="stock_sales_returns_credit_ledger" id="stock_sales_returns_credit_ledger"> 
	                                <option value="0">Please Select</option>
		                                <?php
		                                    $sql="SELECT * FROM ledgers ORDER BY ledger_desc ASC";
		                                    $result=mysqli_query($con,$sql);
		                                    while($row = mysqli_fetch_array($result))
		                                    {
		                                    	echo '<option value = "'.$row['ledger_id'].'">
		                                        '.$row['ledger_desc'].'</option>';
		                                    };
		                                ?>
	                            </select>
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_returns_reference"><strong>Reference</strong></label>
	                            <input type="text" name="stock_sales_returns_reference" class="form-control bg-light text-right" id="stock_sales_returns_reference">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_returns_date"><strong>Date</strong></label>
	                            <input type="date" class="form-control bg-light text-center" name="stock_sales_returns_date" id="stock_sales_returns_date" value="<?php echo date('Y-m-d');?>">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_returns_amount"><strong>Amount</strong></label>
	                            <input type="text" name="stock_sales_returns_amount" class="form-control bg-light text-right" id="stock_sales_returns_amount" hidden="true">
	                            <input type="text" name="stock_sales_returns_amountD" class="form-control bg-light text-right" id="stock_sales_returns_amountD" disabled="true">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-8 mb-8 form-group">
	                            <label for="stock_sales_returns_reason"><strong>Reason</strong></label>
	                            <input type="text" name="stock_sales_returns_reason" class="form-control bg-light" id="stock_sales_returns_reason">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_returns_sent_by"><strong>Brought By</strong></label>
	                            <input type="text" name="stock_sales_returns_sent_by" class="form-control bg-light" id="stock_sales_returns_sent_by">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_returns_received_by"><strong>Received By</strong></label>
	                            <input type="text" class="form-control bg-light" name="stock_sales_returns_received_by" id="stock_sales_returns_received_by">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-8 mb-8 form-group">
	                            <label for="stock_sales_returns_search_item"><strong>Search Item</strong></label>
	                            <input type="text" class="form-control bg-light" name="stock_sales_returns_search_item" id="stock_sales_returns_search_item" placeholder="type to search item...">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_returns_search_item_criteria"><strong>Criteria</strong></label>
	                            <select class="form-control bg-light" name="stock_sales_returns_search_item_criteria" id="stock_sales_returns_search_item_criteria"> 
	                                <option value="Name">Name</option> 
									<option value="Code">Code</option> 
									<option value="Barcode">Barcode</option> 
	                            </select>
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_returns_warehouse"><strong>Warehouse</strong></label>
	                            <select class="form-control bg-light" name="stock_sales_returns_warehouse" id="stock_sales_returns_warehouse" hidden="true"> 
	                                <option value="0">Please Select</option>
	                                <?php
	                                    $sql="SELECT * FROM warehouse ORDER BY warehouse_desc ASC";
	                                    $result = mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											if($row['company_id']==$_SESSION['company_id'])
											{
												echo '<option value = "'.$row['warehouse_id'].'" selected="selected">
												'.$row['warehouse_desc'].'</option>';
											}
											else
											{
												echo '<option value = "'.$row['warehouse_id'].'">
												'.$row['warehouse_desc'].'</option>';
											};
										}
	                                ?>
	                            </select>
	                            <select class="form-control bg-light" name="stock_sales_returns_warehouseD" id="stock_sales_returns_warehouseD" disabled="true"> 
	                                <option value="0">Please Select</option>
	                                <?php
	                                    $sql="SELECT * FROM warehouse ORDER BY warehouse_desc ASC";
	                                    $result = mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											if($row['company_id']==$_SESSION['company_id'])
											{
												echo '<option value = "'.$row['warehouse_id'].'" selected="selected">
												'.$row['warehouse_desc'].'</option>';
											}
											else
											{
												echo '<option value = "'.$row['warehouse_id'].'">
												'.$row['warehouse_desc'].'</option>';
											};
										}
	                                ?>
	                            </select>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group scroll_search_div"  id="stock_sales_returns_search_items_list">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12" id="stock_sales_returns_items_table_div">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="stock_sales_returns_save_btn" id="stock_sales_returns_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="stock_sales_returns_update_btn" id="stock_sales_returns_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="stock_sales_returns_cancel_btn" id="stock_sales_returns_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
          		<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
			</div>
		</div>
	</div>
</div>