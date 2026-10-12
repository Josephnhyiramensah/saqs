<div 
class="modal fade bd-example-modal-lg" 
id="diagnosis_merge_duplicate_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="diagnosis_merge_duplicate_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="diagnosis_merge_duplicate_create_modal_header">Merge Duplicate Diagnosis</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="diagnosis_merge_duplicate_create_form" method="POST">
              <div class="modal-body">
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <div id="diagnosis_merge_duplicate_create_form_msg"></div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <label for="diagnosis_merge_duplicate_from">Replace This (From)</label>
                    <select class="form-control bg-light" name="diagnosis_merge_duplicate_from" id="diagnosis_merge_duplicate_from"> 
                        <option value="0">Please Select</option>
                          <?php
                              $company_id = $_SESSION['company_id'];
                              $sql="SELECT * FROM diagnosis ORDER BY diagnosis ASC";
                              $result = mysqli_query($con,$sql);
                              while($row = mysqli_fetch_array($result))
                              {
                                echo '<option value = "'.$row['diagnosis_id'].'">'.$row['diagnosis'].'</option>';
                              };
                          ?>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <label for="diagnosis_merge_duplicate_to">With This (To)</label>
                    <select class="form-control bg-light" name="diagnosis_merge_duplicate_to" id="diagnosis_merge_duplicate_to"> 
                        <option value="0">Please Select</option>
                        <?php
                          $company_id = $_SESSION['company_id'];
                          $sql="SELECT * FROM diagnosis ORDER BY diagnosis ASC";
                          $result = mysqli_query($con,$sql);
                          while($row = mysqli_fetch_array($result))
                          {
                            echo '<option value = "'.$row['diagnosis_id'].'">'.$row['diagnosis'].'</option>';
                          };
                        ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" name="diagnosis_merge_duplicate_save_btn" id="diagnosis_merge_duplicate_save_btn" class="btn btn-primary">Merge</button>
                  <button type="submit" name="diagnosis_merge_duplicate_cancel_btn" id="diagnosis_merge_duplicate_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>