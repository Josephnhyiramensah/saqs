<div 
class="modal fade bd-example-modal-xl" 
id="stock_sales_invoice_label_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_sales_invoice_label_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 60%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_sales_invoice_label_modal_title">Drug Labelling</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<form id="stock_sales_invoice_label_form" method="POST">
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<div class="col-md-12 mb-12">
								<label for="label_dispensed_by">Dispensed By</label>
								<input type="text"class="form-control" name="label_dispensed_by" id="label_dispensed_by">
							</div>
							<div class="col-md-12 mb-12">
								<label for="label_view">Drug Label</label>
								<textarea type="textarea" rows="4"  class="form-control" name="label_view" id="label_view" value=""></textarea>
							</div>
							<div class="col-md-12 mb-12">
								<label for="label_warning">Warning</label>
								<textarea type="textarea" rows="2"  class="form-control" name="label_warning" id="label_warning" value=""></textarea>
							</div>
						</div>
						<!--<div class="col-md-6 mb-6">
							<label for="label_search">Search</label>
							<input type="text"class="form-control" name="label_search" id="label_search">
							<div class="form-row">
								<div class="col-md-12 mb-12">
									<div id="label_search_result"></div>
								</div>
							</div>
						</div>-->
					</div>
					<input type="hidden" id="label_sales_item_id" name="label_sales_item_id">
					<input type="hidden" id="label_date" name="label_date">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn_stock_sales_invoice_label_save" name="btn_stock_sales_invoice_label_save" class="btn btn-primary">Save</button>
			    <button type="button" id="btn_stock_sales_invoice_label_cancel" name="btn_stock_sales_invoice_label_cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>