<div 
class="modal fade" 
id="price_list_auto_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="price_list_auto_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 30%;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="price_list_auto_modal_title">Price List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="price_list_auto_form" method="POST">
        <div class="modal-body">
            <div class="form-row">
              <div class="col-md-12 mb-12">
                <div id="price_list_auto_form_msg"></div>
                <label for="price_list_auto_group"><strong>Group</strong></label>
                    <input type="hidden" class="form-control" name="price_list_auto_price_level_id" id="price_list_auto_price_level_id">
                    <select class="form-control bg-light" name="price_list_auto_group" id="price_list_auto_group"> 
                        <option value="ALL">ALL</option>
                        <?php
                          $sql_unit="SELECT * FROM stock_item_type ORDER BY stock_item_type ASC";
                          $result_unit = mysqli_query($con,$sql_unit);
                          while($row_unit = mysqli_fetch_array($result_unit))
                          {
                            echo '<option value = "'.$row_unit['stock_item_type_id'].'">'.
                            $row_unit['stock_item_type'].'</option>';
                          }    
                        ?>
                    </select>
              </div>
              <div class="col-md-12 mb-12">
                <label for="price_list_auto_type"><strong>Calculation Type</strong></label>
                    <select class="form-control bg-light" name="price_list_auto_type" id="price_list_auto_type"> 
                        <option value="Increase_By_Percentage">Increase_By_Percentage</option>
                        <option value="Decrease_By_Percentage">Decrease_By_Percentage</option>
                        <option value="Increase_By_Amount">Increase_By_Amount</option>
                        <option value="Decrease_By_Amount">Decrease_By_Amount</option>
                    </select>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12 mb-12">
                <label for="price_list_auto_amount" id="for_price_list_auto_amount"><strong>Percentage</strong></label>
                <input type="text" class="form-control" name="price_list_auto_amount" id="price_list_auto_amount">
              </div>
            </div>
          <div class="modal-footer">
              <button type="button" name="price_list_auto_save_btn" id="price_list_auto_save_btn" class="btn btn-primary" >Save</button>
              <button type="button" name="price_list_auto_update_btn" id="price_list_auto_update_btn" class="btn btn-primary" >Update</button>
              <button type="submit" name="price_list_auto_cancel_btn" id="price_list_auto_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>