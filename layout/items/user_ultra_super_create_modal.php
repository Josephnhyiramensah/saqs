
<div 
class="modal fade bd-example-modal-lg" 
id="user_ultra_super_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="user_ultra_super_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="user_ultra_super_create_modal_header">User Ultra Super Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="user_ultra_super_create_form" method="POST">
              <div class="modal-body">
                <div id="user_ultra_super_form_msg"></div>
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                      <label for="user_ultra_super_name">Name</label>
                      <input type="text" class="form-control" name="user_ultra_super_name" id="user_ultra_super_name">
                  </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-12">
                      <label for="user_ultra_super_email">Email</label>
                      <input type="text" class="form-control" name="user_ultra_super_email" id="user_ultra_super_email">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-12">
                      <label for="user_ultra_super_password">Password</label>
                      <input type="password" class="form-control" name="user_ultra_super_password" id="user_ultra_super_password">
                    </div>
                </div>
              </div>
              <input type="hidden" class="form-control" name="user_ultra_super_id" id="user_ultra_super_id">
              <div class="modal-footer">
                  <button type="button" name="user_ultra_super_save_btn" id="user_ultra_super_save_btn" class="btn btn-primary" >Save</button>
                  <button type="button" name="user_ultra_super_update_btn" id="user_ultra_super_update_btn" class="btn btn-primary" >Update</button>
                  <button type="submit" name="user_ultra_super_cancel_btn" id="user_ultra_super_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
        </form>
	   </div>
  </div>
</div>