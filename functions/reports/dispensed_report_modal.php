<div 
class="modal fade hide bd-example-modal-lg" 
id="dispensed_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="dispensed_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="dispensed_report_modal_header">Stock Dispensed Report</h5>
			</div>
			<div class="modal-body">
				<form id="dispensed_report_modal_form" method="POST">
	                <div class="panel-body">
	                	<div id="dispensed_report_modal_warning"></div>
                        <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="dispensed_report_warehouse">Warehouse</label>
	                            <select class="form-control bg-light" name="dispensed_report_warehouse" id="dispensed_report_warehouse">
					                <option value="all">ALL</option>';
			                    <?php
			                        $sql_warehouse = "SELECT * FROM warehouse";
			                        $result_warehouse = mysqli_query($con,$sql_warehouse);
			                        while($row_warehouse = mysqli_fetch_array($result_warehouse))
			                        {
			                        	echo '<option value ="'.$row_warehouse['warehouse_id'].'">'.$row_warehouse['warehouse_desc'].'</option>';
			                        };
			                    ?>
					        	</select>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="dispensed_report_start_date">Start Date</label>
	                            <input type="date" name="dispensed_report_start_date" class="form-control bg-light" id="dispensed_report_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="dispensed_report_end_date">End Date</label>
	                            <input type="date" name="dispensed_report_end_date" class="form-control bg-light" id="dispensed_report_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="dispensed_report_ok_btn" id="dispensed_report_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="dispensed_report_cancel_btn" id="dispensed_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>