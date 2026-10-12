<div 
class="modal fade bd-example-modal-lg" 
id="branch_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="branch_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="branch_create_modal_header">Branch Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="branch_create_form" method="POST">
              <div class="modal-body">
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <div id="branch_create_form_msg"></div>
                    <input type="hidden" class="form-control" name="branch_id" id="branch_id" >
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <label for="branch_company_id">Company Name</label>
                    <select class="form-control bg-light" name="branch_company_id" id="branch_company_id" hidden = "true"> 
                        <option value="0">Please Select</option>
                            <?php
                                $company_id = $_SESSION['company_id'];
                                $sql="SELECT * FROM company WHERE company_id='$company_id'";
                                $result = mysqli_query($con,$sql);
                                while($row = mysqli_fetch_array($result))
                                {
                                  if($row['company_id'] == $company_id)
                                  {
                                    echo '<option value = "'.$row['company_id'].'" selected="selected">
                                        '.$row['trading_name'].'
                                    </option>';
                                  }
                                  else
                                  {
                                    echo '<option value = "'.$row['company_id'].'">
                                        '.$row['trading_name'].'
                                    </option>';
                                  };
                                
                                };
                            ?>
                    </select>
                    <select class="form-control bg-light" name="branch_company_idD" id="branch_company_idD" disabled = "true"> 
                        <option value="0">Please Select</option>
                            <?php
                                $company_id = $_SESSION['company_id'];
                                $sql="SELECT * FROM company WHERE company_id='$company_id'";
                                $result = mysqli_query($con,$sql);
                                while($row = mysqli_fetch_array($result))
                                {
                                  if($row['company_id'] == $company_id)
                                  {
                                    echo '<option value = "'.$row['company_id'].'" selected="selected">
                                        '.$row['trading_name'].'
                                    </option>';
                                  }
                                  else
                                  {
                                    echo '<option value = "'.$row['company_id'].'">
                                        '.$row['trading_name'].'
                                    </option>';
                                  };
                                
                                };
                            ?>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <label for="branch_name">Branch Name</label>
                    <input type="text" class="form-control" name="branch_name" id="branch_name">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6 mb-6">
                    <label for="branch_address">Address</label>
                    <input type="text" class="form-control" name="branch_address" id="branch_address">
                  </div>
                  <div class="col-md-6 mb-6">
                    <label for="branch_location">Location</label>
                    <input type="text" class="form-control" name="branch_location" id="branch_location">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6 mb-6">
                    <label for="branch_telephone">Telephone</label>
                    <input type="text" class="form-control" name="branch_telephone" id="branch_telephone">
                  </div>
                  <div class="col-md-6 mb-6">
                    <label for="branch_email">Email</label>
                    <input type="text" class="form-control" name="branch_email" id="branch_email">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6 mb-6">
                    <label for="branch_warehouse">Default Warehouse</label>
                    <select class="form-control bg-light" name="branch_warehouse" id="branch_warehouse"> 
                        <option value="0">Please Select</option>
                            <?php
                                $company_id = $_SESSION['company_id'];
                                $sql="SELECT * FROM warehouse ORDER BY warehouse_desc ASC";
                                $result=mysqli_query($con,$sql);
                                while($row = mysqli_fetch_array($result))
                                {
                                ?>
                                <option value = "<?php echo($row['warehouse_id'])?>">
                                    <?php echo($row['warehouse_desc'])?>
                                </option>
                                <?php
                                };
                            ?>
                    </select>
                  </div>
                  <div class="col-md-6 mb-6">
                    <label for="branch_cash_ledger">Default Cash Ledger</label>
                    <select class="form-control bg-light" name="branch_cash_ledger" id="branch_cash_ledger"> 
                      <option value="0">Please Select</option>
                      <?php
                        $company_id = $_SESSION['company_id'];
                          $sql="SELECT * FROM ledgers WHERE tb_4 = 6 ORDER BY ledger_desc ASC";
                          $result=mysqli_query($con,$sql);
                          while($row = mysqli_fetch_array($result))
                          {
                          ?>
                          <option value = "<?php echo($row['ledger_id'])?>">
                              <?php echo($row['ledger_desc'])?>
                          </option>
                          <?php
                          };
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" name="branch_save_btn" id="branch_save_btn" class="btn btn-primary">Save</button>
                  <button type="button" name="branch_update_btn" id="branch_update_btn" class="btn btn-primary">Update</button>
                  <button type="submit" name="branch_cancel_btn" id="branch_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>