<?php
    if(!isset($con))
    {
		require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
	};
?>
<div 
class="modal fade hide bd-example-modal-lg" 
id="stock_requisition_auto_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_requisition_auto_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_requisition_auto_modal_header">Auto Stock Requisition</h5>
			</div>
			<div class="modal-body">
				<form id="stock_requisition_auto_modal_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
							<div id="stock_requisition_auto_modal_warning"></div>
							<div class="col-md-12 mb-12 form-group">
								<label for="stock_requisition_auto_warehouse_id">Vendor</label>
								<select class="form-control bg-light" name="stock_requisition_auto_warehouse_id" id="stock_requisition_auto_warehouse_id"> 
									<option value="0">Please Select</option>
									<?php
										$company_id = $_SESSION['company_id'];
										$sql="SELECT * FROM warehouse WHERE company_id != '$company_id' ORDER BY warehouse_desc ASC";
										$result = mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											echo'<option value = "'.$row['warehouse_id'].'">'.$row['warehouse_desc'].'</option>';
										};
									?>
								</select>
							</div>
		                </div>
		                <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="stock_requisition_auto_start_date">Start Date</label>
	                            <input type="date" name="stock_requisition_auto_start_date" class="form-control bg-light" id="stock_requisition_auto_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="stock_requisition_auto_end_date">End Date</label>
	                            <input type="date" name="stock_requisition_auto_end_date" class="form-control bg-light" id="stock_requisition_auto_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="stock_requisition_auto_post_btn" id="stock_requisition_auto_post_btn" class="btn btn-primary" >Post</button>
	                    <button type="submit" name="stock_requisition_auto_cancel_btn" id="stock_requisition_auto_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>