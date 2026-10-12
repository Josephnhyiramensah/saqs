<div 
class="modal fade bd-example-modal-xl" 
id="stock_sales_invoice_batch_qty_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_sales_invoice_batch_qty_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 50%;" role="document">
		<div class="modal-content">
			<form id="stock_sales_invoice_batch_qty_form" method="POST">
				<div class="modal-header">
					<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_sales_invoice_batch_qty_modal_title">Medicine Utilisation Review</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="batch_qty_maintain_batch" class="form-control bg-light text-center" id="batch_qty_maintain_batch">
	                <input type="hidden" name="batch_qty_block_negative" class="form-control bg-light text-center" id="batch_qty_block_negative">
	                <input type="hidden" name="batch_qty_batch_balance" class="form-control bg-light text-center" id="batch_qty_batch_balance">
	                <input type="hidden" name="batch_qty_item_balance" class="form-control bg-light text-center" id="batch_qty_item_balance">
	                <input type="hidden" name="batch_qty_price" class="form-control bg-light text-center" id="batch_qty_price">
	                <input type="hidden" name="batch_qty_stock_item_id" class="form-control bg-light text-center" id="batch_qty_stock_item_id">
	                <input type="hidden" name="batch_qty_stock_item" class="form-control bg-light text-center" id="batch_qty_stock_item">
					<div class="form-row">
						<div class="col-md-6 mb-6" id="batch_qty_batch_no_div">
	                        <label for="batch_qty_batch_no">Batch/Lot Number</label>
	                        <input type="text" name="batch_qty_batch_no" class="form-control bg-light text-center" id="batch_qty_batch_no">
						</div>
						<div class="col-md-3 mb-3">
	                        <label for="batch_qty_issue">Issued Qty</label>
	                        <input type="text" name="batch_qty_issue" class="form-control bg-light text-center" id="batch_qty_issue">
						</div>
						<div class="col-md-3 mb-3">
	                        <label for="batch_qty_billed">Billed Qty</label>
	                        <input type="text" name="batch_qty_billed" class="form-control bg-light text-center" id="batch_qty_billed">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-3 mb-3">
	                        <label for="batch_price">Price</label>
	                        <input type="text" name="batch_price" class="form-control bg-light text-center" id="batch_price">
						</div>
						<div class="col-md-3 mb-3">
	                        <label for="batch_amount">Amount</label>
	                        <input type="hidden" name="batch_amount" class="form-control bg-light text-center" id="batch_amount">
	                        <input type="text" name="batch_amountD" class="form-control bg-light text-center" id="batch_amountD" disabled="true">
						</div>
						<div class="col-md-3 mb-3">
	                        <label for="batch_disc_perc">Discount</label>
	                        <input type="text" name="batch_disc_perc" class="form-control bg-light text-center" id="batch_disc_perc">
						</div>
						<div class="col-md-3 mb-3">
	                        <label for="batch_disc_amount">Disc. Amount</label>
	                        <input type="text" name="batch_disc_amount" class="form-control bg-light text-center" id="batch_disc_amount">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12" id="stock_sales_invoice_batch_qty_batch_expiry_list">
							<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="stock_sales_invoice_batch_qty_batch_expiry_table">
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
					<button type="button" id="btn_stock_sales_invoice_batch_qty_save" class="btn btn-primary">Save</button>
					<button type="button" id="btn_stock_sales_invoice_batch_qty_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>