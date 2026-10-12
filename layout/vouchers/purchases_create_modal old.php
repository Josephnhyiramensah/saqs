<div 
class="modal fade hide bd-example-modal-xl" 
id="purchase_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="purchase_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 99%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="purchases_create_modal_header">Purchases Invoice</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="purchases_create_form" method="POST">
	                <div class="panel-body">
	                    <input type="hidden" name="purchase_id" class="form-control bg-light" id="purchase_id">
	                    <input type="hidden" name="purchase_button_id" class="form-control bg-light" id="purchase_button_id">
	                    <div class="form-row">
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="purch_debit"><strong>Debit</strong></label>
	                            <select class="form-control bg-light" name="purch_debit" id="purch_debit"> 
	                                <option value="0">Please Select</option>
	                                <?php
	                                    $sql="SELECT * FROM ledgers WHERE tb_4=9 ORDER BY ledger_desc ASC";
	                                    $result=mysqli_query($con,$sql);
	                                    	while($row=mysqli_fetch_array($result))
	                                    	{
	                                    ?>
	                                    		<option value = "<?php echo($row['ledger_id'])?>" >
	                                        	<?php echo($row['ledger_desc']) ?>
	                                    		</option>
	                                    <?php
	                                    	}               
	                                ?>
	                            </select>
	                            <select class="form-control bg-light" name="purch_debitD" id="purch_debitD" disabled="true" hidden="true"> 
	                                <option value="0">Please Select</option>
	                                <?php
	                                    $sql="SELECT * FROM ledgers WHERE tb_4=9 ORDER BY ledger_desc ASC";
	                                    $result=mysqli_query($con,$sql);
	                                    	while($row=mysqli_fetch_array($result))
	                                    	{
	                                    ?>
	                                    		<option value = "<?php echo($row['ledger_id'])?>" >
	                                        	<?php echo($row['ledger_desc']) ?>
	                                    		</option>
	                                    <?php
	                                    	}               
	                                ?>
	                            </select>
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="purch_credit"><strong>Credit</strong></label>
	                            <select class="form-control bg-light" name="purch_credit" id="purch_credit"> 
	                                <option value="0">Please Select</option>
	                                 <?php
	                                    $sql="SELECT * FROM ledgers WHERE tb_5=1 OR tb_5=4 OR tb_5=7 OR tb_5=8 OR tb_5=11 ORDER BY ledger_desc ASC";
	                                    $result=mysqli_query($con,$sql);
	                                    while($row=mysqli_fetch_array($result))
	                                    {
	                                    ?>
	                                    <option value = "<?php echo($row['ledger_id'])?>" >
	                                        <?php echo($row['ledger_desc']) ?>
	                                    </option>
	                                    <?php
	                                    }               
	                                ?>
	                            </select>
	                            <select class="form-control bg-light" name="purch_creditD" id="purch_creditD" disabled="true" hidden="true"> 
	                                <option value="0">Please Select</option>
	                                 <?php
	                                    $sql="SELECT * FROM ledgers WHERE tb_5=1 OR tb_5=4 OR tb_5=7 OR tb_5=8 OR tb_5=11 ORDER BY ledger_desc ASC";
	                                    $result=mysqli_query($con,$sql);
	                                    while($row=mysqli_fetch_array($result))
	                                    {
	                                    ?>
	                                    <option value = "<?php echo($row['ledger_id'])?>" >
	                                        <?php echo($row['ledger_desc']) ?>
	                                    </option>
	                                    <?php
	                                    }               
	                                ?>
	                            </select>
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="purch_date"><strong>Date</strong></label>
	                            <input type="date" class="form-control bg-light" name="purch_date" id="purch_date" value="<?php echo date('Y-m-d');?>">
	                            <input type="date" class="form-control bg-light" name="purch_dateD" id="purch_dateD" value="<?php echo date('Y-m-d');?>" disabled="true" hidden="true">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="purch_ref_no"><strong>Reference No</strong></label>
	                            <input type="text" class="form-control bg-light" name="purch_ref_no" id="purch_ref_no">
	                            <input type="text" class="form-control bg-light" name="purch_ref_noD" id="purch_ref_noD" disabled="true" hidden="true">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="purch_amount"><strong>Amount</strong></label>
	                            <input type="text" class="form-control bg-light" name="purch_amount" id="purch_amount" hidden="true">
	                            <input type="text" class="form-control bg-light" name="purch_amount_2" id="purch_amount_2" disabled="true">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="purch_supplied_by"><strong>Supplied By</strong></label>
	                            <input type="text" class="form-control bg-light" name="purch_supplied_by" id="purch_supplied_by">
	                            <input type="text" class="form-control bg-light" name="purch_supplied_byD" id="purch_supplied_byD" disabled="true" hidden="true">
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="purch_received_by"><strong>Received By</strong></label>
	                            <input type="text" class="form-control bg-light" name="purch_received_by" id="purch_received_by">
	                            <input type="text" class="form-control bg-light" name="purch_received_byD" id="purch_received_byD" disabled="true" hidden="true">
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="purch_discount_perc"><strong>Discount %</strong></label>
	                            <input type="text" class="form-control bg-light" name="purch_discount_perc" id="purch_discount_perc">
	                            <input type="text" class="form-control bg-light" name="purch_discount_percD" id="purch_discount_percD" disabled="true" hidden="true">
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="purch_discount_amount"><strong>Discount Amount</strong></label>
	                            <input type="text" class="form-control bg-light" name="purch_discount_amount" id="purch_discount_amount">
	                            <input type="text" class="form-control bg-light" name="purch_discount_amountD" id="purch_discount_amountD" disabled="true" hidden="true">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="purch_narration"><strong>Narration</strong></label>
	                            <input type="text" class="form-control bg-light" name="purch_narration" id="purch_narration">
	                            <input type="text" class="form-control bg-light" name="purch_narrationD" id="purch_narrationD" disabled="true" hidden="true">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-8 mb-8 form-group">
	                            <label for="purchases_invoice_search_item"><strong>Search Item</strong></label>
	                            <input type="text" class="form-control bg-light" name="purchases_invoice_search_item" id="purchases_invoice_search_item" placeholder="type to search item...">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="purchases_invoice_search_item_criteria"><strong>Criteria</strong></label>
	                            <select class="form-control bg-light" name="purchases_invoice_search_item_criteria" id="purchases_invoice_search_item_criteria"> 
	                                <option value="Name">Name</option> 
									<option value="Code">Code</option> 
									<option value="Barcode">Barcode</option> 
	                            </select>
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="purch_warehouse"><strong>Warehouse</strong></label>
	                            <select class="form-control bg-light" name="purch_warehouse" id="purch_warehouse" hidden="true"> 
	                                <option value="0">Please Select</option>
	                                <?php
	                                    $sql="SELECT * FROM warehouse ORDER BY warehouse_desc ASC";
	                                    $result=mysqli_query($con,$sql);
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
	                            <select class="form-control bg-light" name="purch_warehouseD" id="purch_warehouseD" disabled="true"> 
	                                <option value="0">Please Select</option>
	                                <?php
	                                    $sql="SELECT * FROM warehouse ORDER BY warehouse_desc ASC";
	                                    $result=mysqli_query($con,$sql);
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
	                        <div class="col-md-12 mb-12 form-group scroll_search_div"  id="purchase_search_items_list">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 scroll_table_div" id="purchase_items_list">
	                            <table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="purchase_items_table">
	                                <thead>
	                                    <th width="45%">Description</th>
	                                    <th width="10%">Qty</th>
	                                    <th width="10%">Price</th>
	                                    <th width="10%">Amount</th>
                            			<th width="10%">Selling Price</th>
	                                    <th width="10%">Batch/Lot No</th>
	                                    <th width="10%">Expiry Date</th>
	                                    <th width="5%">Action</th>
	                                </thead>
									<tbody>
									</tbody>
	                            </table>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="purch_save_btn" id="purch_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="purch_update_btn" id="purch_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="purch_cancel_btn" id="purch_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>