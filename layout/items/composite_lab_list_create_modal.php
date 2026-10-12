<div 
class="modal fade bd-example-modal-lg" 
id="composite_lab_list_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="composite_lab_list_create_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        	<h5 class="modal-title m-0 font-weight-bold text-primary" id="compositelab_list_create_modal_header">Composite Laboratory List Setup</h5>
        </div>
        <div class="modal-body">
			<form id="composite_lab_list_create_form" method="POST">
				<div class="panel-body">
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="composite_lab_list_lab_id">Description</label>
							<input type="hidden" class="form-control" name="cll_composite_lab_id" id="cll_composite_lab_id">
							<input type="hidden" class="form-control" name="composite_lab_list_id" id="composite_lab_list_id">
							<select class="form-control" name="composite_lab_list_lab_id" id="composite_lab_list_lab_id"> 
								<option value="0">Please Select</option>';
								<?php
									$sql="SELECT * FROM lab ORDER BY lab ASC";
									$result = mysqli_query($con,$sql);
									while($row = mysqli_fetch_array($result))
									{
										echo'<option value = "'.$row['lab_id'].'">'.$row['lab'].'</option>';
									};
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" name="composite_lab_list_save_btn" id="composite_lab_list_save_btn" class="btn btn-primary" >Save</button>
					<button type="button" name="composite_lab_list_update_btn" id="composite_lab_list_update_btn" class="btn btn-primary" >Update</button>
					<button type="submit" name="composite_lab_list_cancel_btn" id="composite_lab_list_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</form>
        </div>
	   </div>
  </div>
</div>