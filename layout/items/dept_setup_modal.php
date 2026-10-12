<div 
class="modal fade bd-example-modal-lg" 
id="dept_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="dept_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="dept_create_modal_header">Department Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="dept_create_form" method="POST">
              <div class="modal-body">
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <div id="dept_create_form_msg"></div>
                    <input type="hidden" class="form-control" name="dept_id" id="dept_id" >
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-10 mb-10">
                    <label for="dept_name">Department</label>
                    <input type="text" class="form-control" name="department" id="department">
                  </div>
                  <div class="col-md-2 mb-2">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" name="code" id="code">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" name="dept_save_btn" id="dept_save_btn" class="btn btn-primary">Save</button>
                  <button type="button" name="dept_update_btn" id="dept_update_btn" class="btn btn-primary">Update</button>
                  <button type="submit" name="dept_cancel_btn" id="dept_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>