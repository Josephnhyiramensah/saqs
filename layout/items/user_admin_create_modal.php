<div 
class="modal fade bd-example-modal-xl" 
id="user_admin_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="user_admin_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="user_admin_create_modal_header">User Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="user_admin_create_form" method="POST">
              <div class="modal-body">
                    <div class="form-row">
                      <div class="col-md-8 mb-8">
                          <div class="form-row">
                            <div class="col-md-12 mb-12">
                              <label for="company_id">Company</label>
                              <select class="form-control" name="company_id" id="company_id"> 
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
                              <label for="full_name">Full Name</label>
                              <input type="text" class="form-control" name="full_name" id="full_name">
                            </div>
                            <div class="col-md-6 mb-6">
                              <label for="email">Email</label>
                              <input type="text" class="form-control" name="email" id="email">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="col-md-4 mb-4">
                              <label for="telephone">Telephone</label>
                              <input type="text" class="form-control" name="telephone" id="telephone">
                            </div>
                            <div class="col-md-4 mb-4">
                              <label for="address">Address</label>
                              <input type="text" class="form-control" name="address" id="address">
                            </div>
                            <div class="col-md-4 mb-4">
                              <label for="location">Location</label>
                              <input type="text" class="form-control" name="location" id="location">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="col-md-6 mb-6">
                              <label for="username">Username</label>
                              <input type="text" class="form-control" name="username" id="username">
                            </div>
                            <div class="col-md-6 mb-6">
                              <label for="password">Password</label>
                              <input type="text" class="form-control" name="password" id="password">
                            </div>
                          </div>
                      </div>
                      <div class="col-md-4 mb-4">
                        <div class="form-row">
                          <div class="col-md-12 mb-12">
                            <label for="photo">Photo</label>
                              <input type="hidden" name="file_size" class="form-control" id="file_size" value="1000000">
                              <input type="file" name="photo" class="form-control" id="photo">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="col-md-12 mb-12">
                            <label for="photo_display"></label>
                            <textarea type="textarea" rows="8"  class="form-control" name="photo_display" id="photo_display" value=""></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
              <input type="text" class="form-control" name="user_id" id="user_id" hidden="true">
              <div class="modal-footer">
                  <button type="button" name="user_save_btn" id="user_save_btn" class="btn btn-primary" >Save</button>
                  <button type="button" name="user_update_btn" id="user_update_btn" class="btn btn-primary" >Update</button>
                  <button type="submit" name="user_cancel_btn" id="user_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>