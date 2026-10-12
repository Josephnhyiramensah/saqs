<div 
class="modal fade bd-example-modal-lg" 
id="user_privilege_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="user_privilege_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="user_privilege_create_modal_header">Privilege Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
        <div class="modal-body">
          <form id="user_privilege_create_form" method="POST">
            <div id="user_privilege_form_msg"></div>
            <div class="form-row">
              <div class="col-md-12 mb-12">
                <label for="user_privilege_desc">Description</label>
                <input type="text" class="form-control" name="user_privilege_desc" id="user_privilege_desc">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 mb-12">
                <label for="user_priv_page_id">Page</label>
                <select class="form-control" name="user_priv_page_id" id="user_priv_page_id"> 
                  <option value="0">Please Select</option>
                  <?php
                    $sql="SELECT * FROM user_pages ORDER BY page ASC";
                    $result=mysqli_query($con,$sql);
                      while($row=mysqli_fetch_array($result))
                      {
                      ?>
                      <option value = "<?php echo($row['user_page_id'])?>" >
                          <?php echo($row['page']) ?>
                      </option>
                      <?php
                      }               
                  ?>
                </select>
              </div>
            </div>
            <input type="text" class="form-control" name="user_privilege_id" id="user_privilege_id" hidden="true">
            <div class="modal-footer">
                <button type="button" name="user_privilege_save_btn" id="user_privilege_save_btn" class="btn btn-primary" >Save</button>
                <button type="button" name="user_privilege_update_btn" id="user_privilege_update_btn" class="btn btn-primary" >Update</button>
                <button type="submit" name="user_privilege_cancel_btn" id="user_privilege_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </form>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
	     </div>
      </div>
  </div>
</div>