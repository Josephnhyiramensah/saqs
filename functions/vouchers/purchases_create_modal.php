<div 
class="modal fade hide bd-example-modal-xl" 
id="purchase_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="purchase_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="purchases_create_modal_header">Purchases Invoice</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="purchases_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-4 mb-4 form-group">
	                            <input type="hidden" name="purchase_id" class="form-control bg-light" id="purchase_id">
	                            <label for="purch_debit">Debit</label>
	                            <select class="form-control" name="purch_debit" id="purch_debit"> 
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
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="purch_credit">Credit</label>
	                            <select class="form-control" name="purch_credit" id="purch_credit"> 
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
	                            <label for="purch_amount">Amount</label>
	                            <input type="text" class="form-control" name="purch_amount" id="purch_amount" hidden="true">
	                            <input type="text" class="form-control" name="purch_amount_2" id="purch_amount_2" disabled="true">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="purch_supplied_by">Supplied By</label>
	                            <input type="text" class="form-control" name="purch_supplied_by" id="purch_supplied_by">
	                        </div>
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="purch_ref_no">Reference No</label>
	                            <input type="text" class="form-control" name="purch_ref_no" id="purch_ref_no">
	                        </div>
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="purch_date">Date</label>
	                            <input type="date" class="form-control" name="purch_date" id="purch_date">
	                        </div>
	                    </div>

	                    <div class="form-row">
	                        <div class="col-md-4 mb-4 form-group">
	                            <label for="purch_received_by">Received By</label>
	                            <input type="text" class="form-control" name="purch_received_by" id="purch_received_by">
	                        </div>
	                        <div class="col-md-8 mb-8 form-group">
	                            <label for="purch_narration">Narration</label>
	                            <input type="text" class="form-control" name="purch_narration" id="purch_narration">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12" id="purchase_items_list">
	                            <table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="purchase_items_table">
	                                <tr>
	                                    <th width="35%">Description</th>
	                                    <th width="10%">Warehouse</th>
	                                    <th width="10%">Qty</th>
	                                    <th width="10%">Price</th>
	                                    <th width="10%">Amount</th>
                            			<th width="10%">Selling Price</th>
	                                    <th width="10%">Batch/Lot No</th>
	                                    <th width="10%">Expiry Date</th>
	                                    <th width="5%">Action</th>
	                                </tr>
	                                <tr id="1">
	                                    <td>
	                                    	<input type="hidden" name="purch_item_list_id[]" class="form-control bg-light" id="purch_item_list_id1">
	                                        <input type="hidden" name="purch_cat_id[]" class="form-control bg-light" id="purch_cat_id1">
	                                        <select class="form-control purch_item_id" name="purch_desc[]" id="purch_desc1" data-id="1" style="border-width:0px"> 
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
	                                        <select class="form-control purch_loc_id" name="purch_loc[]" id="purch_loc1" data-id="1" style="border-width:0px"> 
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
	                                        <input type="text" name="purch_qty[]" class="form-control bg-light purch_qty" id="purch_qty1" data-id="1" style="border-width:0px">
	                                    </td>
	                                    <td>
	                                        <input type="text" name="purch_price[]" class="form-control bg-light purch_price" id="purch_price1" data-id="1" style="border-width:0px">
	                                    </td>
	                                    <td>
	                                        <input type="text" name="purch_amt[]" class="form-control bg-light" id="purch_amt1" style="border-width:0px">
	                                    </td>
	                                    <td>
	                                        <input type="text" name="purch_selling_price[]" class="form-control bg-light" id="purch_selling_price1" style="border-width:0px">
	                                    </td>
	                                    <td>
	                                        <input type="text" name="purch_batch[]" class="form-control bg-light" id="purch_batch1" style="border-width:0px">
	                                    </td>
	                                    <td>
	                                        <input type="date" name="purch_expiry_date[]" class="form-control bg-light" id="purch_expiry_date1" style="border-width:0px">
	                                    </td>
	                                    <td>
	                                        <!--<a href="#" id="delete_purchase_item" data-id="1"><i class="fa fa-trash fa-sm"></i></a>-->
	                                    </td>
	                                </tr>
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