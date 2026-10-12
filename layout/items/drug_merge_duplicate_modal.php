<div 
class="modal fade bd-example-modal-lg" 
id="drug_merge_duplicate_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="drug_merge_duplicate_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="drug_merge_duplicate_create_modal_header">Merge Duplicate Drug</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="drug_merge_duplicate_create_form" method="POST">
              <div class="modal-body">
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <label for="drug_merge_duplicate_from">Replace This (From)</label>
                    <select class="form-control bg-light" name="drug_merge_duplicate_from" id="drug_merge_duplicate_from"> 
                        <option value="0">Please Select</option>
                          <?php
                              $company_id = $_SESSION['company_id'];
                              $sql="SELECT * FROM stock_items ORDER BY stock_item ASC";
                              $result = mysqli_query($con,$sql);
                              while($row = mysqli_fetch_array($result))
                              {
                                echo '<option value = "'.$row['stock_item_id'].'">'.$row['stock_item'].'</option>';
                              };
                          ?>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <label for="drug_merge_duplicate_to">With This (To)</label>
                    <select class="form-control bg-light" name="drug_merge_duplicate_to" id="drug_merge_duplicate_to"> 
                        <option value="0">Please Select</option>
                        <?php
                          $company_id = $_SESSION['company_id'];
                          $sql="SELECT * FROM stock_items ORDER BY stock_item ASC";
                          $result = mysqli_query($con,$sql);
                          while($row = mysqli_fetch_array($result))
                          {
                            echo '<option value = "'.$row['stock_item_id'].'">'.$row['stock_item'].'</option>';
                          };
                        ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" name="drug_merge_duplicate_save_btn" id="drug_merge_duplicate_save_btn" class="btn btn-primary">Merge</button>
                  <button type="submit" name="drug_merge_duplicate_cancel_btn" id="drug_merge_duplicate_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>