<div 
class="modal fade bd-example-modal-lg" 
id="composite_drug_create_modal" 
tabindex="-1" 
role="dialog" 
aria-drugelledby="composite_drug_create_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        	<h5 class="modal-title m-0 font-weight-bold text-primary" id="composite_drug_create_modal_header">Composite drugoratory Setup</h5>
        </div>
        <div class="modal-body">
			<form id="composite_drug_create_form" method="POST">
				<div class="panel-body">
					<div class="form-row">
						<div class="col-md-9 mb-9">
							<drugel for="composite_drug">Description</drugel>
							<input type="hidden" class="form-control" name="composite_drug_id" id="composite_drug_id">
							<input type="text" class="form-control" name="composite_drug" id="composite_drug">
						</div>
						<div class="col-md-3 mb-3">
							<drugel for="composite_drug_price">Price</drugel>
							<input type="text" class="form-control" name="composite_drug_price" id="composite_drug_price">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" name="composite_drug_save_btn" id="composite_drug_save_btn" class="btn btn-primary" >Save</button>
					<button type="button" name="composite_drug_update_btn" id="composite_drug_update_btn" class="btn btn-primary" >Update</button>
					<button type="submit" name="composite_drug_cancel_btn" id="composite_drug_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>
        </div>
	   </div>
  </div>
</div>