<div 
class="modal fade bd-example-modal-xl" 
id="sales_order_item_search_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="sales_order_item_search_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 70%;" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="sales_order_item_search_modal_header">Item Search</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="sales_order_item_search_modal_form" method="POST">
            <div class="modal-body">
              <div class="form-row">
                <div class="col-md-12 mb-12">
		              <div id="sales_order_item_search_msg"></div>
                  <label for="sales_order_item_search">Search</label>
                  <input type="text" class="form-control" name="sales_order_item_search" id="sales_order_item_search" placeholder="type to search item">
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12 mb-12">
                  <div class="table-responsive" id="sales_order_item_search_table">
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="sales_order_item_search_cancel_btn" id="sales_order_item_search_cancel_btn" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>