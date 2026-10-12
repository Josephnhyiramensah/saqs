<div 
class="modal fade hide bd-example-modal-xl" 
id="stock_requisition_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_requisition_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog modal-xl"role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_requisition_create_modal_header">Stock Requisition</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="stock_requisition_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-4 mb-4 form-group">
	                            <input type="hidden" name="stock_req_id" class="form-control bg-light" id="stock_req_id">
	                            <label for="stock_req_from">Requested From</label>
	                            <select class="form-control" name="stock_req_from" id="stock_req_from"> 
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
	                            <label for="stock_req_to">Requested To</label>
	                            <select class="form-control" name="stock_req_to" id="stock_req_to"> 
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
	                            <label for="stk_req_date">Date</label>
	                            <input type="date" class="form-control" name="stk_req_date" id="stk_req_date">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="stk_req_requested_by">Requested by</label>
	                            <input type="text" class="form-control" name="stk_req_requested_by" id="stk_req_requested_by">
	                        </div>
	                        <div class="col-md-8 mb-8 form-group">
	                            <label for="stk_req_narration">Narration</label>
	                            <input type="text" class="form-control" name="stk_req_narration" id="stk_req_narration">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12" id="stock_requisition_items_list">
	                            <table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="stock_requisition_items_table">
	                                <tr>
	                                    <th width="70%">Description</th>
	                                    <th width="20%">Qty</th>
	                                    <th width="10%">Action</th>
	                                </tr>
	                                <tr id="1">
	                                    <td>
	                                    	<input type="hidden" name="stk_req_item_list_id[]" class="form-control bg-light" id="stk_req_item_list_id1">
	                                        <input type="hidden" name="item_cat_id[]" class="form-control bg-light" id="item_cat_id1">
	                                        <select class="form-control stk_req_item_id" name="stk_req_item_id[]" id="stk_req_item_id1" data-id="1" style="border-width:0px"> 
	                                            <option value="0">Please Select</option>
	                                            <?php
	                                                $sql="SELECT drug_id AS id,category_id,brand_name AS item_desc FROM drugs 
	                                                UNION ALL SELECT con_id AS id,category_id,consumable AS item_desc FROM consumable";
	                                                $result = mysqli_query($con,$sql);
	                                                while($row = mysqli_fetch_array($result))
	                                                {
	                                                    echo '<option value ="'.$row['id'].'" data-value ="'.$row['category_id'].'">'.$row['item_desc'].'</option>';
	                                                }
	                                            ?>
	                                        </select>
	                                    </td>
	                                    <td class = "action-td">
	                                        <input type="text" name="stk_req_qty[]" class="form-control bg-light stk_req_qty" id="stk_req_qty1" data-id="1" style="border-width:0px">
	                                    </td>
	                                    <td class = "action-td">
	                                        <!--<a href="#" id="delete_stk_req_item" data-id="1"><i class="fa fa-trash fa-sm"></i></a>-->
	                                    </td>
	                                </tr>
	                            </table>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="stock_req_save_btn" id="stock_req_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="stock_req_update_btn" id="stock_req_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="stock_req_cancel_btn" id="stock_req_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>