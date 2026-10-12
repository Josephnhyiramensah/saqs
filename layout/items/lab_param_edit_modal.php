<div 
class="modal fade bd-example-modal-xl" 
id="labparameditmodal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="labparameditmodal" 
aria-hidden="true">
  	<div class="modal-dialog modal-xl" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="lab_param_edit_modal_header">Add Lab Parameter Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
      		</div>
        	<div class="modal-body">
                    <div class="clearfix"></div>
                    <?php include('lab_param_edit_form.php');?>
                    <div class="float-left">
                        <button class="btn-primary" id="add_lab_param_dropdown_icon"><i class="fas fa-plus"></i></button>
                    </div>
        	</div>
          <div class="table-responsive" id="lab_param_dropdown_table">
          </div>
    	</div>
  	</div>
</div>
<?php include('lab_param_dropdown_add_modal.php');?>
<?php include('lab_param_dropdown_edit_modal.php');?>