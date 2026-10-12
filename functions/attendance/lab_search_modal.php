<div 
class="modal fade bd-example-modal-xl" 
id="lab_list_search_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="lab_list_search_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="lab_list_search_modal_header">Lab Search</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="lab_list_search_modal_form" method="POST">
            <div class="modal-body">
              <div class="form-row">
                <div class="col-md-12 mb-12">
                  <label for="diagnosis_list_search">Search</label>
                  <input type="text" class="form-control" name="lab_list_search" id="lab_list_search" placeholder="type lab to search">
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12 mb-12">
                  <div class="table-responsive" id="lab_list_search_table"></div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="lab_list_search_cancel_btn" id="lab_list_search_cancel_btn" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>