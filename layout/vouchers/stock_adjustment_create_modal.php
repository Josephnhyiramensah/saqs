<div 
class="modal fade hide bd-example-modal-xl" 
id="stock_adjustment_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_adjustment_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_adjustment_create_modal_header">Stock Adjustment Voucher</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="stock_adjustment_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-4 mb-4 form-group">
	                            <input type="hidden" name="stock_adj_id" class="form-control bg-light" id="stock_adj_id">
	                            <label for="stk_adj_adjusted_by">Adjusted By</label>
	                            <input type="text" class="form-control" name="stk_adj_adjusted_by" id="stk_adj_adjusted_by">
	                        </div>
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="stk_adj_ref_no">Reference No</label>
	                            <input type="text" class="form-control" name="stk_adj_ref_no" id="stk_adj_ref_no">
	                        </div>
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="stk_adj_date">Date</label>
	                            <input type="date" class="form-control" name="stk_adj_date" id="stk_adj_date">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="stk_adj_narration">Narration</label>
	                            <input type="text" class="form-control" name="stk_adj_narration" id="stk_adj_narration">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12" id="stock_adjustment_items_list">
	                            <table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="stock_adjustment_items_table">
	                                <tr>
	                                    <th width="40%">Item Description</th>
	                                    <th width="20%">Location</th>
	                                    <th width="10%">Qty In</th>
	                                    <th width="10%">Qty Out</th>
	                                    <th width="15%">Batch No</th>
	                                    <th width="5%">Action</th>
	                                </tr>
	                                <tr id="1">
	                                    <td>
	                                    	<input type="hidden" name="stk_adj_item_list_id[]" class="form-control bg-light" id="stk_adj_item_list_id1">
	                                        <input type="hidden" name="item_cat_id[]" class="form-control bg-light" id="item_cat_id1">
	                                        <select class="form-control stk_adj_item_id bg-light" name="stk_adj_item_id[]" id="stk_adj_item_id1" data-id="1" style="border-width:0px"> 
	                                            <option value="0">Please Select</option>
	                                            <?php
	                                                $sql="SELECT * FROM drugs ORDER BY brand_name ASC";
	                                                $result=mysqli_query($con,$sql);
	                                                while($row=mysqli_fetch_array($result))
	                                                {
	                                                    echo '<option value ="'.$row['drug_id'].'">'.$row['brand_name'].'</option>';
	                                                };
	                                            ?>
	                                        </select>
	                                    </td>
	                                    <td class = "action-td">
	                                        <select class="form-control bg-light" name="stock_adj_wh[]" id="stock_adj_wh1"> 
				                                <option value="0">Please Select</option>
				                                 <?php
				                                    $sql="SELECT * FROM warehouse WHERE company_id = '".$_SESSION['company_id']."' ORDER BY warehouse_desc ASC";
				                                    $result=mysqli_query($con,$sql);
				                                    while($row=mysqli_fetch_array($result))
				                                    {
				                                    ?>
				                                    <option value = "<?php echo($row['warehouse_id'])?>" >
				                                        <?php echo($row['warehouse_desc']) ?>
				                                    </option>
				                                    <?php
				                                    }               
				                                ?>
				                            </select>
	                                    </td>
	                                    <td class = "action-td">
	                                        <input type="text" name="stk_adj_qty_in[]" class="form-control bg-light stk_adj_qty_in" id="stk_adj_qty_in1" data-id="1" style="border-width:0px">
	                                    </td>
	                                    <td class = "action-td">
	                                        <input type="text" name="stk_adj_qty_out[]" class="form-control bg-light stk_adj_qty_out" id="stk_adj_qty_out1" data-id="1" style="border-width:0px">
	                                    </td>
	                                    <td class = "action-td">
	                                        <input type="text" name="stock_adj_batch_no[]" class="form-control bg-light stock_adj_batch_no" id="stock_adj_batch_no1" data-id="1" style="border-width:0px">
	                                    </td>
	                                    <td class = "action-td">
	                                        <a href="#" id="delete_stk_adj_item" data-id="1"><i class="fa fa-trash fa-sm"></i></a>
	                                    </td>
	                                </tr>
	                            </table>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="stock_adj_save_btn" id="stock_adj_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="stock_adj_update_btn" id="stock_adj_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="stock_adj_cancel_btn" id="stock_adj_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>