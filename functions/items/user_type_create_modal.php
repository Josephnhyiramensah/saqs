<div 
class="modal fade bd-example-modal-lg" 
id="user_type_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="user_type_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="user_type_create_modal_header">User Type Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
        <div class="modal-body">
          <form id="user_type_create_form" method="POST">
                <div id="user_type_form_msg"></div>
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <label for="user_type_desc">Description</label>
                    <input type="text" class="form-control" name="user_type_desc" id="user_type_desc">
                  </div>
                </div>
                <div id="user_type_privileges_div">
                </div>
                <input type="text" class="form-control" name="user_type_id" id="user_type_id" hidden="true">
                <div class="modal-footer">
                    <button type="button" name="user_type_save_btn" id="user_type_save_btn" class="btn btn-primary" >Save</button>
                    <button type="button" name="user_type_update_btn" id="user_type_update_btn" class="btn btn-primary" >Update</button>
                    <button type="submit" name="user_type_cancel_btn" id="user_type_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
          </form>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
	     </div>
      </div>
  </div>
</div>