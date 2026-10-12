<div 
class="modal fade bd-example-modal-xl" 
id="company_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="company_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-xl" style="max-width: 80%" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="company_create_modal_header">Company Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
        <div class="modal-body">
          <form id="company_create_form" method="POST">
            <div class="modal-body">
              <div class="panel-body">
              <div id="company_warning_div"></div>
                <div class="form-row">
                  <div class="col-md-8 mb-8">
                      <div class="form-row">
                        <div class="col-md-6 mb-6">
                          <label for="trading_name">Trading Name</label>
                          <input type="text" class="form-control" name="trading_name" id="trading_name">
                          <input type="hidden" class="form-control" name="company_id" id="company_id">
                          <input type="hidden" class="form-control" name="user_super_id" id="user_super_id">
                        </div>
                        <div class="col-md-6 mb-6">
                          <label for="legal_name">Legal Name</label>
                          <input type="text" class="form-control" name="legal_name" id="legal_name">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-4 mb-4">
                          <label for="address">Address</label>
                          <input type="text" class="form-control" name="address" id="address">
                        </div>
                        <div class="col-md-4 mb-4">
                          <label for="location">Location</label>
                          <input type="text" class="form-control" name="location" id="location">
                        </div>
                        <div class="col-md-2 mb-2">
                          <label for="gps">GPS</label>
                          <input type="text" class="form-control" name="gps" id="gps">
                        </div>
                        <div class="col-md-2 mb-2">
                          <label for="currency">Currency</label>
                          <select class="form-control" name="currency" id="currency"> 
                            <option value="GHc">GHc</option>
                            <option value="US$">US$</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-5 mb-5">
                          <label for="email">Email</label>
                          <input type="text" class="form-control" name="email" id="email">
                        </div>
                        <div class="col-md-5 mb-5">
                          <label for="website">website</label>
                          <input type="text" class="form-control" name="website" id="website">
                        </div>
                        <div class="col-md-2 mb-2" hidden="true">
                          <label for="sms">Send SMS?</label>
                          <select class="form-control" name="sms" id="sms">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-4 mb-4">
                          <label for="telephone">Telephone</label>
                          <input type="text" class="form-control" name="telephone" id="telephone">
                        </div>
                        <div class="col-md-4 mb-4">
                          <label for="momo_phone">MoMo Number</label>
                          <input type="text" class="form-control" name="momo_phone" id="momo_phone">
                        </div>
                        <div class="col-md-4 mb-4">
                          <label for="whatsapp_phone">WhatsApp Number</label>
                          <input type="text" class="form-control" name="whatsapp_phone" id="whatsapp_phone">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-4 mb-4">
                          <label for="admin_username">Admin - Username</label>
                          <input type="text" class="form-control" name="admin_username" id="admin_username">
                        </div>
                        <div class="col-md-4 mb-4">
                          <label for="admin_email">Admin - Email</label>
                          <input type="text" class="form-control" name="admin_email" id="admin_email">
                        </div>
                        <div class="col-md-4 mb-4">
                          <label for="admin_password">Admin - Password</label>
                          <input type="text" class="form-control" name="admin_password" id="admin_password">
                        </div>
                      </div>
                  </div>
                  <div class="col-md-4 mb-4">
                    <div class="form-row">
                      <div class="col-md-12 mb-12">
                        <label for="company_type_id">Company Type</label>
                        <select class="form-control" name="company_type_id" id="company_type_id"> 
                          <option value="0">Please Select</option>
                              <?php
                                $sql="SELECT * FROM company_type ORDER BY company_type ASC";
                                $result=mysqli_query($con,$sql);
                                  while($row=mysqli_fetch_array($result))
                                  {
                                  ?>
                                  <option value = "<?php echo($row['company_type_id'])?>" >
                                      <?php echo($row['company_type']) ?>
                                  </option>
                                  <?php
                                  };
                              ?>
                          </select>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-12 mb-12">
                        <label for="company_logo">Company Logo</label>
                          <input type="hidden" name="file_size" class="form-control" id="file_size" value="1000000">
                          <input type="file" name="company_logo_file" class="form-control" id="company_logo_file">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-12 mb-12">
                        <label for="logo_display"></label>
                        <textarea type="textarea" rows="8"  class="form-control" name="logo_display" id="logo_display" value=""></textarea>
                      </div>
                    </div>
                    <?php
                      if ($_SESSION['user_type'] == 'Ultra_Super_User') 
                      {
                        echo '<div class="form-row">
                                <div class="col-md-12 mb-12">
                                  <label for="company_status">Status</label>
                                  <select class="form-control" name="company_status" id="company_status">
                                    <option value="0">-Please Select-</option> 
                                    <option value="Active">Active</option>
                                    <option value="Suspended">Suspended</option>
                                    <option value="Closed">Closed</option>
                                    <option value="Demo">Demo</option>
                                  </select>
                                </div>
                              </div>';
                      };
                    ?>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" name="company_save_btn" id="company_save_btn" class="btn btn-primary" >Save</button>
                  <button type="button" name="company_update_btn" id="company_update_btn" class="btn btn-primary" >Update</button>
                  <button type="submit" name="company_cancel_btn" id="company_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </form>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
        </div>
	   </div>
  </div>
</div>