<div 
class="modal fade hide bd-example-modal-xl" 
id="stock_sales_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_sales_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_sales_create_modal_header">Stock Sales Invoice</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="stock_sales_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-4 mb-4 form-group">
	                            <input type="hidden" name="stock_sales_id" class="form-control bg-light" id="stock_sales_id">
	                            <label for="sales_debit">Debit</label>
	                            <select class="form-control" name="stock_sales_debit" id="stock_sales_debit"> 
	                                <option value="0">Please Select</option>
	                                <?php
	                                    $sql="SELECT * FROM ledgers WHERE tb_5=4 OR tb_5=7 OR tb_5=8 ORDER BY ledger_desc ASC";
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
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="stock_sales_credit">Credit</label>
	                            <select class="form-control" name="stock_sales_credit" id="stock_sales_credit"> 
	                                <option value="0">Please Select</option>
	                                 <?php
	                                    $sql="SELECT * FROM ledgers WHERE tb_4=10 ORDER BY ledger_desc ASC";
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
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="stock_sales_amount">Amount</label>
	                            <input type="text" class="form-control" name="stock_sales_amount" id="stock_sales_amount" hidden="true">
	                            <input type="text" class="form-control" name="stock_sales_amount_2" id="stock_sales_amount_2" disabled="true">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="stock_sales_supplied_by">Customer Details</label>
	                            <input type="text" class="form-control" name="stock_sales_supplied_by" id="stock_sales_supplied_by">
	                        </div>
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="stock_sales_ref_no">Reference No</label>
	                            <input type="text" class="form-control" name="stock_sales_ref_no" id="stock_sales_ref_no">
	                        </div>
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="stock_sales_date">Date</label>
	                            <input type="date" class="form-control" name="stock_sales_date" id="stock_sales_date">
	                        </div>
	                    </div>

	                    <div class="form-row">
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="stock_sales_received_by">Issued By</label>
	                            <input type="text" class="form-control" name="stock_sales_received_by" id="stock_sales_received_by">
	                        </div>
	                        <div class="col-md-8 mb-8 form-group">
	                            <label for="stock_sales_narration">Narration</label>
	                            <input type="text" class="form-control" name="stock_sales_narration" id="stock_sales_narration">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12" id="stock_sales_items_list">
	                            <table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="stock_sales_items_table">
	                                <tr>
	                                    <th width="45%">Description</th>
	                                    <th width="10%">Warehouse</th>
	                                    <th width="10%">Qty</th>
	                                    <th width="10%">Price</th>
	                                    <th width="10%">Amount</th>
	                                    <th width="10%">Batch/Lot No</th>
	                                    <th width="10%">Expiry Date</th>
	                                    <th width="5%">Action</th>
	                                </tr>
	                                <tr id="1">
	                                    <td>
	                                    	<input type="hidden" name="stock_sales_item_list_id[]" class="form-control bg-light" id="stock_sales_item_list_id1">
	                                        <input type="hidden" name="stock_sales_cat_id[]" class="form-control bg-light" id="stock_sales_cat_id1">
	                                        <select class="form-control stock_sales_desc" name="stock_sales_desc[]" id="stock_sales_desc1" data-id="1" style="border-width:0px"> 
	                                            <option value="0">Please Select</option>
	                                            <?php
	                                                $sql="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
	                                                UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable";
	                                                $result=mysqli_query($con,$sql);
	                                                while($row=mysqli_fetch_array($result))
	                                                {
	                                                    echo '<option value ="'.$row['id'].'" data-value ="'.$row['category_id'].'">'.$row['item_desc'].'</option>';
	                                                }
	                                            ?>
	                                        </select>
	                                    </td>
	                                    <td>
	                                        <select class="form-control stock_sales_loc_id" name="stock_sales_loc[]" id="stock_sales_loc1" data-id="1" style="border-width:0px"> 
	                                            <option value="0">Please Select</option>
	                                            <?php
	                                                $sql_wh="SELECT * FROM warehouse WHERE company_id = '".$_SESSION['company_id']."' ORDER BY warehouse_desc"; 
	                                                $result_wh=mysqli_query($con,$sql_wh);
	                                                while($row_wh=mysqli_fetch_array($result_wh))
	                                                {
	                                                    echo '<option value ="'.$row_wh['warehouse_id'].'">'.$row_wh['warehouse_desc'].'</option>';
	                                                }
	                                            ?>
	                                        </select>
	                                    </td>
	                                    <td>
	                                        <input type="text" name="stock_sales_qty[]" class="form-control bg-light stock_sales_qty" id="stock_sales_qty1" data-id="1" style="border-width:0px">
	                                    </td>
	                                    <td>
	                                        <input type="text" name="stock_sales_price[]" class="form-control bg-light stock_sales_price" id="stock_sales_price1" data-id="1" style="border-width:0px">
	                                    </td>
	                                    <td>
	                                        <input type="text" name="stock_sales_amt[]" class="form-control bg-light" id="stock_sales_amt1" style="border-width:0px">
	                                    </td>
	                                    <td>
	                                        <input type="text" name="stock_sales_batch[]" class="form-control bg-light" id="stock_sales_batch1" style="border-width:0px">
	                                    </td>
	                                    <td>
	                                        <input type="date" name="stock_sales_expiry_date[]" class="form-control bg-light" id="stock_sales_expiry_date1" style="border-width:0px">
	                                    </td>
	                                    <td>
	                                        <!--<a href="#" id="delete_sales_item" data-id="1"><i class="fa fa-trash fa-sm"></i></a>-->
	                                    </td>
	                                </tr>
	                            </table>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="stock_sales_save_btn" id="stock_sales_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="stock_sales_update_btn" id="stock_sales_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="stock_sales_cancel_btn" id="stock_sales_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>