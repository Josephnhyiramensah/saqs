<div 
class="modal fade bd-example-modal-xl" 
id="attend_sponsor_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="attend_sponsor_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="attend_sponsor_create_modal_header">User Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="attend_sponsor_create_form" method="POST">
              <div class="modal-body">
                <div id="attend_sponsor_form_msg"></div>
                    <div class="form-row">
                      <div class="col-md-8 mb-8">
                          <div class="form-row">
                            <div class="col-md-8 mb-8">
                              <label for="attend_sponsor_ledger_id">Ledger</label>
                              <input type="text" class="form-control" name="attend_sponsor_patient_id" id="attend_sponsor_patient_id" value="<?php echo $_SESSION['patient_id'];?>">
                              <input type="text" class="form-control" name="attend_sponsor_attend_id" id="attend_sponsor_attend_id" value="<?php echo $_SESSION['attend_id'];?>">
                              <select class="form-control" name="attend_sponsor_ledger_id" id="attend_sponsor_ledger_id"> 
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
                            <div class="col-md-4 mb-4">
                              <label for="user_type">User Type</label>
                              <select class="form-control" name="user_type" id="user_type"> 
                                <option value="0">Please Select</option>
                                <?php
                                  $sql="SELECT * FROM user_type ORDER BY user_type_desc ASC";
                                  $result=mysqli_query($con,$sql);
                                    while($row=mysqli_fetch_array($result))
                                    {
                                    ?>
                                    <option value = "<?php echo($row['user_type_id'])?>" >
                                        <?php echo($row['user_type_desc']) ?>
                                    </option>
                                    <?php
                                    }               
                                ?>
                              </select>
                            </div>
                          </div>
                          
                          <div class="form-row">
                            <div class="col-md-6 mb-6">
                              <label for="email">Email</label>
                              <input type="text" class="form-control" name="email" id="email">
                            </div>
                            <div class="col-md-6 mb-6">
                              <label for="user_approval_status">Status</label>
                              <select class="form-control" name="user_approval_status" id="user_approval_status"> 
                                <option value="0">Please Select</option>
                                <option value="Pending">Pending</option>
                                <option value="Accepted">Accepted</option>
                                <option value="Rejected">Rejected</option>
                                <option value="Revoked">Revoked</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="col-md-6 mb-6">
                              <label for="first_name">First Name</label>
                              <input type="text" class="form-control" name="first_name" id="first_name">
                            </div>
                            <div class="col-md-6 mb-6">
                              <label for="last_name">Last Name</label>
                              <input type="text" class="form-control" name="last_name" id="last_name">
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
                      </div>
                    </div>
              </div>
              <div class="modal-footer">
                  <button type="button" name="attend_sponsor_save_btn" id="attend_sponsor_save_btn" class="btn btn-primary" >Save</button>
                  <button type="button" name="attend_sponsor_update_btn" id="attend_sponsor_update_btn" class="btn btn-primary" >Update</button>
                  <button type="submit" name="attend_sponsor_cancel_btn" id="attend_sponsor_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
            <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>