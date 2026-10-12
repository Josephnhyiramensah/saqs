<div 
class="modal fade bd-example-modal-lg" 
id="sales_returns_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="sales_returns_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="sales_returns_create_modal_header">sales_returns Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="sales_returns_create_form" method="POST">
              <div class="modal-body">
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <div id="sales_returns_create_form_msg"></div>
                    <input type="hidden" class="form-control" name="sales_returns_company_id" id="sales_returns_company_id" value="<?php echo($_SESSION['company_id'])?>">
                    <input type="hidden" class="form-control" name="sales_returns_id" id="sales_returns_id" >
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <label for="sales_returns_name">sales_returns Name</label>
                    <input type="text" class="form-control" name="sales_returns_name" id="sales_returns_name">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6 mb-6">
                    <label for="sales_returns_address">Address</label>
                    <input type="text" class="form-control" name="sales_returns_address" id="sales_returns_address">
                  </div>
                  <div class="col-md-6 mb-6">
                    <label for="sales_returns_location">Location</label>
                    <input type="text" class="form-control" name="sales_returns_location" id="sales_returns_location">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6 mb-6">
                    <label for="sales_returns_telephone">Telephone</label>
                    <input type="text" class="form-control" name="sales_returns_telephone" id="sales_returns_telephone">
                  </div>
                  <div class="col-md-6 mb-6">
                    <label for="sales_returns_email">Email</label>
                    <input type="text" class="form-control" name="sales_returns_email" id="sales_returns_email">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6 mb-6">
                    <label for="sales_returns_warehouse">Default Warehouse</label>
                    <select class="form-control bg-light" name="sales_returns_warehouse" id="sales_returns_warehouse"> 
                        <option value="0">Please Select</option>
                            <?php
                                $company_id = $_SESSION['company_id'];
                                $sql="SELECT * FROM warehouse WHERE company_id='$company_id'";
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
                    <label for="sales_returns_cash_ledger">Default Cash Ledger</label>
                    <select class="form-control bg-light" name="sales_returns_cash_ledger" id="sales_returns_cash_ledger"> 
                      <option value="0">Please Select</option>
                      <?php
                        $company_id = $_SESSION['company_id'];
                          $sql="SELECT * FROM ledgers WHERE (company_id = '$company_id' AND tb_4 = 6) OR 
                          (default_status = 'yes' AND tb_4 = 6) ORDER BY ledger_desc ASC";
                          $result = mysqli_query($con,$sql);
                          while($row = mysqli_fetch_array($result))
                          {
                            echo '<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
                          };
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" name="sales_returns_save_btn" id="sales_returns_save_btn" class="btn btn-primary">Save</button>
                  <button type="button" name="sales_returns_update_btn" id="sales_returns_update_btn" class="btn btn-primary">Update</button>
                  <button type="submit" name="sales_returns_cancel_btn" id="sales_returns_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>