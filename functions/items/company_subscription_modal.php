<div 
class="modal fade bd-example-modal-xl" 
id="company_subscription_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="company_subscription_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-xl" style="max-width: 80%" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="company_subscription_modal_header">Company Subscription</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
        <div class="modal-body">
          <form id="company_subscription_form" method="POST">
            <div class="modal-body">
              <div class="panel-body">
                    <div id="company_warning_div"></div>
                    <div class="form-row">
                      <div class="col-md-12 mb-12">
                          <label for="company_subscription_company_id">Company</label>
                          <input type="text" class="form-control" name="sub_bill_id" id="sub_bill_id" hidden="true">
                          <select class="form-control" name="company_subscription_company_id" id="company_subscription_company_id" hidden="true"> 
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
                          
                          <select class="form-control" name="company_subscription_company_idD" id="company_subscription_company_idD" disabled="true"> 
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
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-3 mb-3">
                        <label for="price">Subscription Price (US$)</label>
                        <input type="text" class="form-control" name="price" id="price">
                      </div>
                      <div class="col-md-3 mb-3">
                        <label for="no_of_months">No of Months</label>
                        <input type="text" class="form-control" name="no_of_months" id="no_of_months">
                      </div>
                      <div class="col-md-3 mb-3">
                        <label for="exchange_rate">Exchange Rate</label>
                        <input type="text" class="form-control" name="exchange_rate" id="exchange_rate">
                      </div>
                      <div class="col-md-3 mb-3">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" name="start_date" id="start_date">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-3 mb-3">
                        <label for="amount_dollar">Amount (US$)</label>
                        <input type="text" class="form-control" name="amount_dollar" id="amount_dollar" hidden>
                        <input type="text" class="form-control" name="amount_dollarD" id="amount_dollarD" disabled>
                      </div>
                      <div class="col-md-3 mb-3">
                        <label for="amount_cedi">Amount (GHc)</label>
                        <input type="text" class="form-control" name="amount_cedi" id="amount_cedi" hidden>
                        <input type="text" class="form-control" name="amount_cediD" id="amount_cediD" disabled>
                      </div>
                      <div class="col-md-3 mb-3">
                        <label for="expiry_date">Expiry Date</label>
                        <input type="date" class="form-control" name="expiry_date" id="expiry_date">
                      </div>
                      <div class="col-md-3 mb-3">
                        <label for="date_grace"> Grace Period</label>
                        <input type="date" class="form-control" name="date_grace" id="date_grace">
                      </div>
                    </div>
              </div>
              <div class="modal-footer">
                  <button type="button" name="company_sub_save_btn" id="company_sub_save_btn" class="btn btn-primary" >Save</button>
                  <button type="button" name="company_sub_update_btn" id="company_sub_update_btn" class="btn btn-primary" >Update</button>
                  <button type="submit" name="company_sub_cancel_btn" id="company_sub_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </form>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
        </div>
	   </div>
  </div>
</div>