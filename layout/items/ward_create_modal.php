<div 
class="modal fade bd-example-modal-xl" 
id="ward_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="ward_create_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="ward_create_modal_header">Ward Setup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="ward_create_form" method="POST">
          <div class="clearfix"></div>
          <div class="panel-body">
            <div class="form-row">
              <div class="col-md-10 mb-10">
                <label for="ward">Ward</label>
                <input type="text" class="form-control" name="ward" id="ward">
                <input type="hidden" class="form-control" name="ward_id" id="ward_id">
              </div>
              <div class="col-md-2 mb-2">
                <label for="price">Price</label>
                <input type="text" class="form-control" name="price" id="price">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" name="ward_save_btn" id="ward_save_btn" class="btn btn-primary" >Save</button>
            <button type="button" name="ward_update_btn" id="ward_update_btn" class="btn btn-primary" >Update</button>
            <button type="submit" name="ward_cancel_btn" id="ward_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </form>
        <div id="beds">
          <div class="float-left"><button class="btn-primary" id="add_bed_icon"><i class="fas fa-plus"></i></button></div>
          <div class="table-responsive" id="bed_list_table"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div 
class="modal fade bd-example-modal-xl" 
id="bed_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="bed_create_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="bed_create_modal_header">Bed Setup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="bed_create_form" method="POST">
        <div class="modal-body">
  		<div class="clearfix"></div>
      		<div class="panel-body">
					<div class="form-row">
						<div class="col-md-10 mb-10">
							<label for="ward">Bed</label>
							<input type="text" class="form-control" name="bed" id="bed">
							<input type="hidden" class="form-control" name="bed_id" id="bed_id">
						</div>
						<div class="col-md-2 mb-2">
							<label for="type">Type of Bed</label>
							<input type="text" class="form-control" name="type" id="type">
						</div>
					</div>
			</div>
	        <div class="modal-footer">
	            <button type="button" name="bed_save_btn" id="bed_save_btn" class="btn btn-primary" >Save</button>
	            <button type="button" name="bed_update_btn" id="bed_update_btn" class="btn btn-primary" >Update</button>
	            <button type="submit" name="bed_cancel_btn" id="bed_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	        </div>
        </div>
      </form>
    </div>
  </div>
</div>