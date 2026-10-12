<form id="lab_param_edit_form" method="POST">
	<div class="panel-body">
		<div class="form-row">
			<div class="col-md-6 mb-6">
				<label for="Parameter">Parameter</label>
				<input type="text" class="form-control" name="lab_param_up" id="lab_param_up" value="">
			</div>
			<div class="col-md-2 mb-2">
				<label for="lab_param_low_range">Lower Range</label>
				<input type="text" class="form-control" name="lab_param_low_range_up" id="lab_param_low_range_up" value="">
			</div>
			<div class="col-md-2 mb-2">
				<label for="lab_param_high_range">Higher Range</label>
				<input type="text" class="form-control" name="lab_param_high_range_up" id="lab_param_high_range_up" value="">
			</div>
			<div class="col-md-2 mb-2">
				<label for="lab_param_unit">Unit</label>
				<input type="text" class="form-control" name="lab_param_unit_up" id="lab_param_unit_up" value="">
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<label for="lab_param_comment">Comment</label>
				<textarea type="textarea" rows="4"  class="form-control" name="lab_param_comment_up" id="lab_param_comment_up" value=""></textarea>
			</div>
		</div>
	</div>
	<div id="lab_param_add_form_footer" class="modal-footer">
		<input type="hidden" class="form-control" name="lab_param_lab_id_up" id="lab_param_lab_id_up" value="">
		<input type="hidden" class="form-control" name="lab_param_id_up" id="lab_param_id_up" value="">
	    <button type="button" name="lab_param_update_btn_up" id="lab_param_update_btn_up" class="btn btn-primary" >Update</button>
	    <button type="submit" name="lab_param_cancel_btn_up" id="lab_param_cancel_btn_up" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	</div>
</form>