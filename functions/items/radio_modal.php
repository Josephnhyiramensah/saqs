<div 
class="modal fade bd-example-modal-xl" 
id="radio_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="radio_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="radio_modal_header">Radiology Item Setup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		    <div class="clearfix"></div>
        <form id="radio_form" method="POST">
          <div class="panel-body">
  					<div class="form-row">
  						<div class="col-md-6 mb-6">
  							<label for="radio">Radiology Item</label>
  							<input type="text" class="form-control" name="radio" id="radio">
  							<input type="hidden" class="form-control" name="radio_id" id="radio_id">
  						</div>
              <div class="col-md-2 mb-2">
                <label for="radio_type">Radiology Type</label>
                <select class="form-control" name="radio_type" id="radio_type"> 
                      <option value="0">Please Select</option>
                        <?php
                          $sql="SELECT * FROM radio_type ORDER BY radio_type ASC";
                          $result=mysqli_query($con,$sql);
                            while($row_radio_type=mysqli_fetch_array($result))
                            {
                            ?>
                            <option value = "<?php echo($row_radio_type['radio_type_id'])?>" >
                                <?php echo($row_radio_type['radio_type']);?>
                            </option>
                            <?php
                            }               
                        ?>
                </select>
              </div>
  						<div class="col-md-2 mb-2">
  							<label for="price_private">Price - Private</label>
  							<input type="text" class="form-control" name="price_private" id="price_private">
  						</div>
              <div class="col-md-2 mb-2">
                <label for="price_private_topup">Price - Private Top Up</label>
                <input type="text" class="form-control" name="price_private_topup" id="price_private_topup">
              </div>
  					</div>
            <div class="form-row">
              <div class="col-md-6 mb-6">
                  <label for="radio_nhis_id">Applicable NHIS Item</label>
                  <select class="form-control" name="radio_nhis_id" id="radio_nhis_id"> 
                      <option value="0">Please Select</option>
                        <?php
                          $sql="SELECT * FROM nhis WHERE category_id=4 ORDER BY nhis_item_desc ASC";
                          $result=mysqli_query($con,$sql);
                            while($row=mysqli_fetch_array($result))
                            {
                            ?>
                              <option value = "<?php echo($row['nhis_id'])?>" >
                                  <?php echo($row['nhis_item_desc']);?>
                              </option>
                            <?php
                            }               
                        ?>
                  </select>
              </div>
              <div class="col-md-2 mb-2">
                <label for="radio_nhis_price">NHIS Price</label>
                <input type="text" class="form-control" name="radio_nhis_price" id="radio_nhis_price" disabled="">
              </div>
              <div class="col-md-2 mb-2">
                <label for="price_nhis_topup">Price - NHIS Top Up</label>
                <input type="text" class="form-control" name="price_nhis_topup" id="price_nhis_topup">
              </div>
  						<div class="col-md-2 mb-2">
  							<label for="price">Cash Price</label>
  							<input type="text" class="form-control" name="price" id="price">
  						</div>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" name="radio_save_btn" id="radio_save_btn" class="btn btn-primary" >Save</button>
          <button type="button" name="radio_update_btn" id="radio_update_btn" class="btn btn-primary" >Update</button>
          <button type="submit" name="radio_cancel_btn" id="radio_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
        <div id="radio_param_table_div">
            <div class="float-left">
              <button class="btn-primary" id="add_radio_param_icon"><i class="fas fa-plus"></i></button>
            </div>
            <div class="table-responsive" id="radio_param_table"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('radio_param_modal.php');?>

