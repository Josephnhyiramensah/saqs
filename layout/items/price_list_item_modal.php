<div 
class="modal fade bd-example-modal-lg" 
id="price_list_item_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="price_list_item_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-lg" style="max-width: 80%;" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="price_list_item_modal_header">Price List Item Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="price_list_item_form" method="POST">
              <div class="modal-body">
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <div id="price_list_item_form_msg"></div>
                    <input type="hidden" class="form-control" name="price_list_id" id="price_list_id">
                    <input type="hidden" class="form-control" name="price_list_price_level_id" id="price_list_price_level_id">
                    <input type="hidden" class="form-control" name="price_list_date" id="price_list_date">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-10 mb-10">
                    <label for="price_list_item_id">Item Description</label>
                    <select class="form-control bg-light" name="price_list_item_id" id="price_list_item_id"> 
                        <option value="0">Please Select</option>
                            <?php
                                $sql="SELECT * FROM stock_items ORDER BY stock_item ASC";
                                $result = mysqli_query($con,$sql);
                                while($row = mysqli_fetch_array($result))
                                {
                                  echo '<option value = "'.$row['stock_item_id'].'">
                                  '.$row['stock_item'].'</option>';
                                };
                            ?>
                    </select>
                    <select class="form-control bg-light" name="price_list_item_idD" id="price_list_item_idD" disabled = "true" hidden="true"> 
                        <option value="0">Please Select</option>
                            <?php
                                $sql="SELECT * FROM stock_items ORDER BY stock_item ASC";
                                $result = mysqli_query($con,$sql);
                                while($row = mysqli_fetch_array($result))
                                {
                                  echo '<option value = "'.$row['stock_item_id'].'">
                                  '.$row['stock_item'].'</option>';
                                };
                            ?>
                    </select>
                  </div>
                  <div class="col-md-2 mb-2">
                    <label for="price_list_item_price">Price</label>
                    <input type="text" class="form-control" name="price_list_item_price" id="price_list_item_price">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" name="price_list_item_save_btn" id="price_list_item_save_btn" class="btn btn-primary">Save</button>
                  <button type="button" name="price_list_item_update_btn" id="price_list_item_update_btn" class="btn btn-primary">Update</button>
                  <button type="submit" name="price_list_item_cancel_btn" id="price_list_item_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>