<div 
class="modal fade bd-example-modal-xl" 
id="diagnosis_list_search_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="diagnosis_list_search_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="diagnosis_list_search_modal_header">Diagnosis Search</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="diagnosis_list_search_modal_form" method="POST">
            <div class="modal-body">
              <div class="form-row">
                <?php 
                if (
                  $_SESSION['user_type'] == 'Ultra_Super_User' OR 
                  $_SESSION['user_type'] == 'Super_User' OR 
                  ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Diagnosis'] == 'Yes')) 
                  {
                    echo '<div class="col-md-10 mb-10">
                      <label for="diagnosis_list_search">Search</label>
                      <input type="text" class="form-control" name="diagnosis_list_search" id="diagnosis_list_search" placeholder="type diagnosis to search">
                    </div>
                    <div class="col-md-2 mb-2 text-center">
                      <label for="diagnosis_list_search_insert_new_diagnosis">Insert</label>
                      <button id="diagnosis_list_search_insert_new_diagnosis" type="button" class="btn btn-success btn-block">New Diagnosis</button>
                    </div>';
                  }
                  else
                  {
                    echo '<div class="col-md-12 mb-12">
                      <label for="diagnosis_list_search">Search</label>
                      <input type="text" class="form-control" name="diagnosis_list_search" id="diagnosis_list_search" placeholder="type diagnosis to search">
                    </div>';
                  };
              ?>
              </div>
              <div class="form-row">
                <div class="col-md-12 mb-12">
                  <div class="table-responsive" id="diagnosis_list_search_table"></div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="diagnosis_list_search_cancel_btn" id="diagnosis_list_search_cancel_btn" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>