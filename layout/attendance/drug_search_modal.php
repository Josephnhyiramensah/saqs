<div 
class="modal fade bd-example-modal-xl" 
id="drug_list_search_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="drug_list_search_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 90%;" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="drug_list_search_modal_header">Drug Search</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="drug_list_search_modal_form" method="POST">
            <div class="modal-body">
              <div class="form-row">
                <div class="col-md-10 mb-10">
		              <div id="drug_save_msg"></div>
                  <label for="drug_list_search">Search</label>
                  <input type="text" class="form-control" name="drug_list_search" id="drug_list_search" placeholder="type drug to search">
                  <input type="hidden" class="form-control" name="drug_list_sponsor_id" id="drug_list_sponsor_id" value="<?php echo $principal_sponsor;?>">
                  <input type="hidden" class="form-control" name="drug_list_age" id="drug_list_age" value="<?php echo $age;?>">
                </div>
                <div class="col-md-2 mb-2 text-center">
                  <label for="drug_list_search_btn">Click To Search</label>
                  <button id="drug_list_search_btn" type="button" class="btn btn-primary btn-block">Search</button>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12 mb-12">
                  <div class="table-responsive" id="drug_list_search_table"></div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="drug_list_search_cancel_btn" id="drug_list_search_cancel_btn" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>