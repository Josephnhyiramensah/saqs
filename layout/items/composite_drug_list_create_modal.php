<div 
class="modal fade" 
id="composite_drug_list_create_modal" 
tabindex="-1" 
role="dialog" 
aria-drugelledby="composite_drug_list_create_modal" 
aria-hidden="true">
  <div class="modal-dialog" style="max-width: 60%;" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        	<h5 class="modal-title m-0 font-weight-bold text-primary" id="compositedrug_list_create_modal_header">Composite Drug List Setup</h5>
        </div>
        <div class="modal-body">
			<form id="composite_drug_list_create_form" method="POST">
				<div class="panel-body">
					<div class="form-row">
						<div class="col-md-7 mb-7">
							<label for="composite_drug_list_drug_id">Description</label>
							<input type="hidden" class="form-control" name="cll_composite_drug_id" id="cll_composite_drug_id">
							<input type="hidden" class="form-control" name="composite_drug_list_id" id="composite_drug_list_id">
							<select class="form-control" name="composite_drug_list_drug_id" id="composite_drug_list_drug_id"> 
								<option value="0">Please Select</option>';
								<?php
									$sql="SELECT * FROM drugs ORDER BY brand_name ASC";
									$result = mysqli_query($con,$sql);
									while($row = mysqli_fetch_array($result))
									{
										echo'<option value = "'.$row['drug_id'].'">'.$row['brand_name'].'</option>';
									};
								?>
							</select>
						</div>
						<div class="col-md-3 mb-3">
							<label for="composite_drug_dosage">Dosage</label>
							<input type="text" class="form-control" name="composite_drug_dosage" id="composite_drug_dosage">
						</div>
						<div class="col-md-2 mb-2">
							<label for="composite_drug_qty">Qty</label>
							<input type="text" class="form-control" name="composite_drug_qty" id="composite_drug_qty">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" name="composite_drug_list_save_btn" id="composite_drug_list_save_btn" class="btn btn-primary" >Save</button>
					<button type="button" name="composite_drug_list_update_btn" id="composite_drug_list_update_btn" class="btn btn-primary" >Update</button>
					<button type="submit" name="composite_drug_list_cancel_btn" id="composite_drug_list_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>
        </div>
	   </div>
  </div>
</div>