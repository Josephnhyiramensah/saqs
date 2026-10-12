<div 
class="modal fade bd-example-modal-xl" 
id="validation_sheet_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="validation_sheet_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 60%;" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="validation_sheet_modal_header">Validation Sheet</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="validation_sheet_modal_form" method="POST">
            <div class="modal-body">
		          <div id="validation_sheet_msg"></div>
              <input type="hidden" class="form-control" name="validation_sheet_item_list_id" id="validation_sheet_item_list_id">
              <input type="hidden" class="form-control" name="validation_sheet_item_type" id="validation_sheet_item_type">
              <div class="form-row">
                <div class="col-md-12 mb-12" id="validation_sheet_item_div">
                  <label for="validation_sheet_item_id">Item Description</label>
                  <select class="form-control" name="validation_sheet_item_id" id="validation_sheet_item_id"> 
                    <option value="0">Please Select</option>
                    <?php
                      $sql="SELECT * FROM stock_items ORDER BY stock_item ASC";
                      $result = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($result))
                        {
                          echo '<option value = "'.$row['stock_item_id'].'">'.$row['stock_item'].'</option>';
                        };

                      /*$sql="SELECT * FROM company ORDER BY trading_name ASC";
                      $result=mysqli_query($con,$sql);
                        while($row=mysqli_fetch_array($result))
                        {
                          echo '<option value = "'.$row['company_id'].'">'.$row['trading_name'].'</option>';
                        };*/
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-6 mb-6">
                  <label for="validation_sheet_sponsor_id">Sponsor</label>
                  <select class="form-control" name="validation_sheet_sponsor_id" id="validation_sheet_sponsor_id"> 
                    <option value="0">Please Select</option>
                    <?php
                      $sql="SELECT * FROM ledgers ORDER BY ledger_desc ASC";
                      $result=mysqli_query($con,$sql);
                        while($row=mysqli_fetch_array($result))
                        {
                          echo '<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
                        };
                    ?>
                  </select>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="validation_sheet_cash_price">Cash Price</label>
                  <input type="text" class="form-control" name="validation_sheet_cash_price" id="validation_sheet_cash_price">
                </div>
                <div class="col-md-3 mb-3">
                  <label for="validation_sheet_insured_price">Insured Price</label>
                  <input type="text" class="form-control" name="validation_sheet_insured_price" id="validation_sheet_insured_price">
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="validation_sheet_update_btn" id="validation_sheet_update_btn" class="btn btn-primary">Update</button>
                <button type="button" name="validation_sheet_cancel_btn" id="validation_sheet_cancel_btn" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>