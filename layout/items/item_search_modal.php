<div 
class="modal fade bd-example-modal-xl" 
id="item_search_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="item_search_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="item_search_modal_header">Item Search</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
				<div class="modal-body">
          <div id="item_customer_form_div">
            
          </div>
				</div>
        <div class="modal-footer">
          <button type="button" name="customer_save_btn" id="customer_save_btn" class="btn btn-primary">Save</button>
          <button type="button" name="customer_update_btn" id="customer_update_btn" class="btn btn-primary">Update</button>
          <button type="submit" name="customer_cancel_btn" id="customer_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
        <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
	   </div>
  </div>
</div>