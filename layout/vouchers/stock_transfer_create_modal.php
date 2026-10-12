<?php
    if(!isset($con))
    {
		require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
	};
?>
<div 
class="modal fade hide bd-example-modal-xl" 
id="stock_transfer_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_transfer_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_transfer_create_modal_header">Stock Transfer Voucher</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="stock_transfer_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-4 mb-4 form-group">
	                            <input type="hidden" name="stock_trans_id" class="form-control bg-light" id="stock_trans_id">
	                            <input type="hidden" name="stock_req_id_trans" class="form-control bg-light" id="stock_req_id_trans">
	                            <input type="hidden" name="stock_req_date" class="form-control bg-light" id="stock_req_date">
	                            <label for="stock_trans_from">Warehouse From (Source)</label>
	                            <select class="form-control" name="stock_trans_from" id="stock_trans_from"> 
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
	                        </div>
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="stock_trans_to">Warehouse To (Destination)</label>
	                            <select class="form-control" name="stock_trans_to" id="stock_trans_to"> 
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
	                        </div>
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="stk_trans_date">Date</label>
	                            <input type="date" class="form-control" name="stk_trans_date" id="stk_trans_date">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="stk_trans_transferred_by">Transferred by</label>
	                            <input type="text" class="form-control" name="stk_trans_transferred_by" id="stk_trans_transferred_by">
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="stk_trans_collected_by">Collected by</label>
	                            <input type="text" class="form-control" name="stk_trans_collected_by" id="stk_trans_collected_by">
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="stk_trans_requested_by">Requested by</label>
	                            <input type="text" class="form-control" name="stk_trans_requested_by" id="stk_trans_requested_by">
	                        </div>
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="stk_trans_approved_by">Approved by</label>
	                            <input type="text" class="form-control" name="stk_trans_approved_by" id="stk_trans_approved_by">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="stk_trans_narration">Narration</label>
	                            <input type="text" class="form-control" name="stk_trans_narration" id="stk_trans_narration">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12" id="stock_transfer_items_list">
	                            <table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="stock_transfer_items_table">
	                                <tr>
	                                    <th width="30%">Description</th>
	                                    <th width="10%">Qty Requested</th>
	                                    <th width="10%">Qty Transferred</th>
	                                    <th width="20%">Batch No</th>
	                                    <th width="10%">Action</th>
	                                </tr>
	                                <tr id="1">
	                                    <td>
	                                    	<input type="hidden" name="stk_trans_item_list_id[]" class="form-control bg-light" id="stk_trans_item_list_id1">
	                                        <input type="hidden" name="item_cat_id[]" class="form-control bg-light" id="item_cat_id1">
	                                        <input type="hidden" name="wh_from_id[]" class="form-control bg-light" id="wh_from_id1">
	                                        <input type="hidden" name="wh_to_id[]" class="form-control bg-light" id="wh_to_id1">
	                                        <select class="form-control stk_trans_item_id" name="stk_trans_item_id[]" id="stk_trans_item_id1" data-id="1" style="border-width:0px"> 
	                                            <option value="0">Please Select</option>
	                                            <?php
	                                                $sql="SELECT stock_item_id, stock_item FROM stock_items ORDER BY stock_item";
	                                                $result = mysqli_query($con,$sql);
	                                                while($row = mysqli_fetch_array($result))
	                                                {
	                                                    echo '<option value ="'.$row['stock_item_id'].'">'.$row['stock_item'].'</option>';
	                                                }
	                                            ?>
	                                        </select>
	                                    </td>
	                                    <td class = "action-td">
	                                        <input type="text" name="stk_trans_qty_req[]" class="form-control bg-light stk_trans_qty_req" id="stk_trans_qty_req1" data-id="1" style="border-width:0px" hidden="true">
	                                        <input type="text" name="stk_trans_qty_reqt[]" class="form-control bg-light stk_trans_qty_reqt" id="stk_trans_qty_reqt1" data-id="1" style="border-width:0px" disabled="true">
	                                    </td>
	                                    <td class = "action-td">
	                                        <input type="text" name="stk_trans_qty[]" class="form-control bg-light stk_trans_qty" id="stk_trans_qty1" data-id="1" style="border-width:0px">
	                                    </td>
	                                    <td class = "action-td">
	                                        <select class="form-control bg-light" name="stock_trans_batch_no" id="stock_trans_batch_no1"> 
				                            </select>
	                                    </td>
	                                    <td class = "action-td">
	                                        <a href="#" id="delete_stk_trans_item" data-id="1"><i class="fa fa-trash fa-sm"></i></a>
	                                    </td>
	                                </tr>
	                            </table>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="stock_trans_save_btn" id="stock_trans_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="stock_trans_update_btn" id="stock_trans_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="stock_trans_cancel_btn" id="stock_trans_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>