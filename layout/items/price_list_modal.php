
<div 
class="modal fade bd-example-modal-xl" 
id="price_list_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="price_list_modal" 
aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title m-0 font-weight-bold text-primary" id="price_list_modal_title">Price Lise</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="price_list_form" method="POST">
        <div class="modal-body">
          <div class="clearfix"></div>
          <div class="panel-body">
            <div class="table-responsive" id="price_list_table">
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" name="price_list_save_btn" id="price_list_save_btn" class="btn btn-primary" >Save</button>
              <button type="button" name="price_list_update_btn" id="price_list_update_btn" class="btn btn-primary" >Update</button>
              <button type="submit" name="price_list_cancel_btn" id="price_list_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>