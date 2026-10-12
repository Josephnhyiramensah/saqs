<div 
class="modal fade bd-example-modal-lg" 
id="user_personal_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="user_personal_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="user_personal_create_modal_header">User Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="user_personal_create_form" method="POST">
              <div class="modal-body">
                    <div class="form-row">
                      <div class="col-md-12 mb-12">
                        <div id="user_personal_form_msg"></div>
                          <div class="form-row">
                            <div class="col-md-12 mb-12">
                              <input type="hidden" class="form-control" name="user_personal_user_super_id" id="user_personal_user_super_id">
                              <label for="user_personal_company_id">Company</label>
                              <select class="form-control" name="user_personal_company_id" id="user_personal_company_id" hidden="true"> 
                                <option value="0">Please Select</option>
                                <?php
                                  $sql="SELECT * FROM company ORDER BY trading_name ASC";
                                  $result=mysqli_query($con,$sql);
                                    while($row=mysqli_fetch_array($result))
                                    {
                                    ?>
                                    <option value = "<?php echo($row['company_id'])?>" >
                                        <?php echo($row['trading_name']) ?>
                                    </option>
                                    <?php
                                    };
                                ?>
                              </select>
                              <select class="form-control" name="user_personal_company_id_2" id="user_personal_company_id_2" disabled="true"> 
                                <option value="0">Please Select</option>
                                <?php
                                  $sql="SELECT * FROM company ORDER BY trading_name ASC";
                                  $result=mysqli_query($con,$sql);
                                    while($row=mysqli_fetch_array($result))
                                    {
                                    ?>
                                    <option value = "<?php echo($row['company_id'])?>" >
                                        <?php echo($row['trading_name']) ?>
                                    </option>
                                    <?php
                                    }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="col-md-6 mb-6">
                              <label for="user_personal_full_name">Full Name</label>
                              <input type="text" class="form-control" name="user_personal_full_name" id="user_personal_full_name">
                            </div>
                            <div class="col-md-6 mb-6">
                              <label for="user_personal_email">Email</label>
                              <input type="text" class="form-control" name="user_personal_email" id="user_personal_email">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="col-md-6 mb-6">
                              <label for="user_personal_password">Password</label>
                              <input type="password" class="form-control" name="user_personal_password" id="user_personal_password">
                            </div>
                            <div class="col-md-6 mb-6">
                              <label for="user_personal_password_confirm">Confirm Password</label>
                              <input type="password" class="form-control" name="user_personal_password_confirm" id="user_personal_password_confirm">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="col-md-4 mb-4">
                              <label for="user_personal_telephone">Telephone</label>
                              <input type="text" class="form-control" name="user_personal_telephone" id="user_personal_telephone">
                            </div>
                            <div class="col-md-4 mb-4">
                              <label for="user_personal_address">Address</label>
                              <input type="text" class="form-control" name="user_personal_address" id="user_personal_address">
                            </div>
                            <div class="col-md-4 mb-4">
                              <label for="user_personal_location">Location</label>
                              <input type="text" class="form-control" name="user_personal_location" id="user_personal_location">
                            </div>
                          </div>
                      </div>
                      <!--<div class="col-md-4 mb-4">
                        <div class="form-row">
                          <div class="col-md-12 mb-12">
                            <label for="user_personal_photo">Photo</label>
                              <input type="hidden" name="file_size" class="form-control" id="file_size" value="1000000">
                              <input type="file" name="user_personal_photo" class="form-control" id="user_personal_photo">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="col-md-12 mb-12">
                            <label for="user_personal_photo_display"></label>
                            <textarea type="textarea" rows="8"  class="form-control" name="user_personal_photo_display" id="user_personal_photo_display" value=""></textarea>
                          </div>
                        </div>
                      </div>-->
                    </div>
              </div>
              <input type="text" class="form-control" name="user_id" id="user_id" hidden="true">
              <div class="modal-footer">
                  <button type="button" name="user_personal_save_btn" id="user_personal_save_btn" class="btn btn-primary">Save</button>
                  <button type="button" name="user_personal_update_btn" id="user_personal_update_btn" class="btn btn-primary">Update</button>
                  <button type="submit" name="user_personal_cancel_btn" id="user_personal_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>