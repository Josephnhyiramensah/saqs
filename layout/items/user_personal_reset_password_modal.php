<div 
class="modal fade bd-example-modal-lg" 
id="user_personal_reset_password_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="user_personal_reset_password_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="user_personal_reset_password_modal_header">User Change Password</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="user_personal_reset_password_form" method="POST">
              <div class="modal-body">
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <div id="user_personal_reset_password_form_msg"></div>
                    <input type="hidden" class="form-control" name="user_personal_reset_password_user_id" id="user_personal_reset_password_user_id">
                    <input type="hidden" class="form-control" name="user_personal_reset_password_user_type" id="user_personal_reset_password_user_type">
                    <label for="user_personal_reset_password_email">Email</label>
                    <select class="form-control" name="user_personal_reset_password_email" id="user_personal_reset_password_email" hidden="true"> 
                      <option value="0">Please Select</option>
                      <?php
                        $sql = "SELECT * FROM `users`";
                          $result = mysqli_query($con,$sql);
                            while($row=mysqli_fetch_array($result))
                            {
                            ?>
                            <option value = "<?php echo $row['id'];?>"  selected = "selected">
                                <?php echo $row['email'];?>
                            </option>
                            <?php
                            };
                      ?>
                    </select>
                    <select class="form-control" name="user_personal_reset_password_email_2" id="user_personal_reset_password_email_2" disabled ="true"> 
                      <option value="0">Please Select</option>
                      <?php
                        $sql = "SELECT * FROM `users`";
                          $result = mysqli_query($con,$sql);
                            while($row=mysqli_fetch_array($result))
                            {
                              ?>
                                <option value = "<?php echo $row['id'];?>"  selected = "selected">
                                    <?php echo $row['email'];?>
                                </option>
                              <?php
                            };
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <label for="user_personal_reset_password_new">New Password</label>
                    <input type="password" class="form-control" name="user_personal_reset_password_new" id="user_personal_reset_password_new">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <label for="user_personal_reset_password_confirm">New Password Confirm</label>
                    <input type="password" class="form-control" name="user_personal_reset_password_confirm" id="user_personal_reset_password_confirm">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" name="user_personal_reset_password_update_btn" id="user_personal_reset_password_update_btn" class="btn btn-primary">Update</button>
                  <button type="submit" name="user_personal_reset_password_cancel_btn" id="user_personal_reset_password_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>