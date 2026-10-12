<div 
class="modal fade bd-example-modal-xl" 
id="user_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="user_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="user_create_modal_header">User Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="user_create_form" method="POST">
              <div class="modal-body">
                <div id="user_form_msg"></div>
                    <div class="form-row">
                      <div class="col-md-8 mb-8">
                          <div class="form-row">
                            <div class="col-md-8 mb-8">
                              <label for="company_id">Company</label>
                              <input type="hidden" class="form-control" name="ucm_user_super_id" id="ucm_user_super_id">
                              <select class="form-control" name="ucm_company_id" id="ucm_company_id" hidden="true"> 
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
                              <select class="form-control" name="company_id_2" id="company_id_2" disabled="true"> 
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
                              <label for="user_branch">Branch</label>
                              <select class="form-control" name="user_branch" id="user_branch"> 
                                <option value="0">Please Select</option>
                                <?php
                                  $company_id = $_SESSION['company_id'];
                                  $sql="SELECT * FROM branch WHERE company_id='$company_id' ORDER BY branch_name ASC";
                                  $result=mysqli_query($con,$sql);
                                    while($row=mysqli_fetch_array($result))
                                    {
                                    ?>
                                    <option value = "<?php echo($row['branch_id'])?>" >
                                        <?php echo($row['branch_name']) ?>
                                    </option>
                                    <?php
                                    };
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="col-md-6 mb-6">
                              <label for="email">Email</label>
                              <input type="text" class="form-control" name="email" id="email">
                            </div>
                            <div class="col-md-3 mb-3">
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
                                      };
                                  ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
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
                            <div class="col-md-4 mb-4">
                              <label for="first_name">First Name</label>
                              <input type="text" class="form-control" name="first_name" id="first_name">
                            </div>
                            <div class="col-md-4 mb-4">
                              <label for="last_name">Last Name</label>
                              <input type="text" class="form-control" name="last_name" id="last_name">
                            </div>
                            <div class="col-md-4 mb-4">
                              <label for="warehouse_id">Warehouse</label>
                                <select class="form-control warehouse_id" name="warehouse_id" id="warehouse_id"> 
                                  <option value="0">Please Select</option>
                                  <?php
                                    $company_id = $_SESSION['company_id'];
                                    $sql="SELECT * FROM warehouse WHERE company_id = '$company_id' ORDER BY warehouse_desc ASC";
                                    $result = mysqli_query($con,$sql);
                                      while($row=mysqli_fetch_array($result))
                                      {
                                        ?>
                                          <option value = "<?php echo($row['warehouse_id'])?>" >
                                              <?php echo($row['warehouse_desc']) ?>
                                          </option>
                                        <?php
                                      };
                                  ?>
                                </select>
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
                    <div class="form-row">
                      <div class="col-md-8 mb-8">
                        <div id="user_privileges_div">
                        </div>
                      </div>
                      <div class="col-md-4 mb-4">
                        <div class="form-row">
                          <div class="col-md-12 mb-12" id="user_cash_ledger_list">
                            <table table class="table table-hover table-bordered table-sm" width="100%" 
                              cellspacing="0" style="font-size: 14px" id="user_cash_ledger_list_table">
                                  <tr>
                                      <th width="90%">Hidden Ledger List</th>
                                      <th width="10%">Action</th>
                                  </tr>
                                  <tr id="1">
                                      <td>
                                          <select class="form-control user_cash_ledger_id bg-light" name="user_cash_ledger_id[]" id="user_cash_ledger_id1" data-id="1" style="border-width:0px"> 
                                            <option value="0">Please Select</option>
                                            <?php
                                              $company_id = $_SESSION['company_id'];
                                              $sql="SELECT * FROM ledgers WHERE company_id = '$company_id'  OR default_status = 'Yes' ORDER BY ledger_desc ASC";
                                              $result = mysqli_query($con,$sql);
                                                while($row=mysqli_fetch_array($result))
                                                {
                                                  ?>
                                                    <option value = "<?php echo($row['ledger_id'])?>" >
                                                        <?php echo($row['ledger_desc']) ?>
                                                    </option>
                                                  <?php
                                                };
                                            ?>
                                          </select>
                                      </td>
                                      <!--<td class = "action-td">
                                          <a href="#" id="delete_user_cash_ledger" data-id="1"><i class="fa fa-trash fa-sm"></i></a>
                                      </td>-->
                                  </tr>
                              </table>
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
              <input type="hidden" class="form-control" name="ucm_user_id" id="ucm_user_id">
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