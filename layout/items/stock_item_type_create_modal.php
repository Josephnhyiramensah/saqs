<div 
class="modal fade bd-example-modal-lg" 
id="stock_item_type_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_item_type_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_item_type_create_modal_header">Stock Type Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="stock_item_type_create_form" method="POST">
              <div class="modal-body">
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <div id="stock_item_type_create_form_msg"></div>
                    <input type="hidden" class="form-control" name="stock_item_type_id" id="stock_item_type_id" >
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <label for="stock_item_type">Stock Type</label>
                    <input type="text" class="form-control" name="stock_item_type" id="stock_item_type">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" name="stock_item_type_save_btn" id="stock_item_type_save_btn" class="btn btn-primary">Save</button>
                  <button type="button" name="stock_item_type_update_btn" id="stock_item_type_update_btn" class="btn btn-primary">Update</button>
                  <button type="submit" name="stock_item_type_cancel_btn" id="stock_item_type_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>