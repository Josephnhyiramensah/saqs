<div 
class="modal fade bd-example-modal-xl" 
id="stock_take_invoice_batch_qty_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_take_invoice_batch_qty_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 50%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_take_invoice_batch_qty_modal_title">Qty Batch Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<form id="stock_take_invoice_batch_qty_form" method="POST">
					<input type="hidden" name="stock_take_batch_qty_maintain_batch" class="form-control bg-light text-center" id="stock_take_batch_qty_maintain_batch">
	                <input type="hidden" name="stock_take_batch_qty_block_negative" class="form-control bg-light text-center" id="stock_take_batch_qty_block_negative">
	                <input type="hidden" name="stock_take_batch_qty_batch_balance" class="form-control bg-light text-center" id="stock_take_batch_qty_batch_balance">
	                <input type="hidden" name="stock_take_batch_qty_item_balance" class="form-control bg-light text-center" id="stock_take_batch_qty_item_balance">
	                <input type="hidden" name="stock_take_batch_qty_price" class="form-control bg-light text-center" id="stock_take_batch_qty_price">
	                <input type="hidden" name="stock_take_batch_qty_stock_item_id" class="form-control bg-light text-center" id="stock_take_batch_qty_stock_item_id">
	                <input type="hidden" name="stock_take_batch_qty_stock_item" class="form-control bg-light text-center" id="stock_take_batch_qty_stock_item">
					<div class="form-row">
						<div class="col-md-4 mb-4" id="stock_take_batch_qty_batch_no_div">
	                        <label for="stock_take_batch_qty_batch_no">Batch/Lot Number</label>
	                        <input type="text" name="stock_take_batch_qty_batch_no" class="form-control bg-light text-center" id="stock_take_batch_qty_batch_no">
						</div>
						<div class="col-md-4 mb-4">
	                        <label for="stock_take_batch_qty_expiry_date">Expiry Date</label>
	                        <input type="date" name="stock_take_batch_qty_expiry_date" class="form-control bg-light text-center" id="stock_take_batch_qty_expiry_date">
						</div>
						<div class="col-md-4 mb-4">
	                        <label for="stock_take_batch_qty_issue">Qty</label>
	                        <input type="text" name="stock_take_batch_qty_issue" class="form-control bg-light text-center" id="stock_take_batch_qty_issue">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12" id="stock_take_invoice_batch_qty_batch_expiry_list">
							<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="stock_take_invoice_batch_qty_batch_expiry_table">
								<tr>
									<th colspan="5" class="action-td">BATCH LIST</th>
								</tr>
								<tr>
									<th width="70%">Batch/Lot Number</th>
									<th width="15%">Expiry Date</th>
									<th width="15%">Days to Expire</th>
								</tr>
								<tr>
									<td class="action-td"></td>
									<td class="action-td"></td>
									<td class="action-td"></td>
								</tr>
							</table>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn_stock_take_invoice_batch_qty_save" class="btn btn-primary">Save</button>
			    <button type="button" id="btn_stock_take_invoice_batch_qty_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>