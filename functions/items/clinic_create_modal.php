<div 
class="modal fade bd-example-modal-m" 
id="clinic_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="clinic_create_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-m" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="clinic_create_modal_header">Clinic Setup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="clinic_create_form" method="POST">
        <div class="modal-body">
  		<div class="clearfix"></div>
      		<div class="panel-body">
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="clinic">Clinic</label>
							<input type="text" class="form-control" name="clinic" id="clinic">
							<input type="hidden" class="form-control" name="clinic_id" id="clinic_id">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="service_charge">Service Charge</label>
							<select class="form-control" name="service_charge" id="service_charge"> 
						    	<option value="0">Please Select</option>
						        <?php
						        	$sql="SELECT * FROM services ORDER BY service ASC";
									$result_service=mysqli_query($con,$sql);
						            while($row_service=mysqli_fetch_array($result_service))
						            {
						            ?>
						            <option value = "<?php echo($row_service['service_id'])?>" >
						                <?php echo($row_service['service']) ?>
						            </option>
						            <?php
						            }               
						        ?>
						    </select>
						</div>
					</div>
			</div>
	        <div class="modal-footer">
	            <button type="button" name="clinic_save_btn" id="clinic_save_btn" class="btn btn-primary" >Save</button>
	            <button type="button" name="clinic_update_btn" id="clinic_update_btn" class="btn btn-primary" >Update</button>
	            <button type="submit" name="clinic_cancel_btn" id="clinic_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	        </div>
        </div>
      </form>
    </div>
  </div>
</div>
