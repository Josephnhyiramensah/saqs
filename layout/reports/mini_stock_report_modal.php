<div 
class="modal fade hide bd-example-modal-lg" 
id="mini_stock_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="mini_stock_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="mini_stock_report_modal_header">Mini Stock Report</h5>
			</div>
			<div class="modal-body">
				<form id="mini_stock_report_modal_form" method="POST">
	                <div class="panel-body">
	                	<div id="mini_stock_report_modal_warning"></div>
                        <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="mini_stock_report_warehouse">Store</label>
	                            <select class="form-control bg-light" name="mini_stock_report_warehouse" id="mini_stock_report_warehouse">
					                <option value="all">ALL</option>';
			                    <?php
                        			if(isset($_SESSION['company_id'])){$company_id = $_SESSION['company_id'];}else{$company_id = 0;};
                        			if(isset($_SESSION['warehouse_id'])){$warehouse_id = $_SESSION['warehouse_id'];}else{$warehouse_id = 0;};
	                                
									$sql_warehouse = "SELECT * FROM warehouse WHERE company_id = '$company_id' ORDER BY warehouse_desc ASC";
			                        $result_warehouse = mysqli_query($con, $sql_warehouse);
			                        while($row_warehouse = mysqli_fetch_array($result_warehouse))
			                        {
										if($row_warehouse['warehouse_id']==$warehouse_id)
			                        	{
											echo '<option value ="'.$row_warehouse['warehouse_id'].'" selected="selected">'.$row_warehouse['warehouse_desc'].'</option>';
										}
										else
										{
											echo '<option value ="'.$row_warehouse['warehouse_id'].'">'.$row_warehouse['warehouse_desc'].'</option>';
										};
			                        };
			                    ?>
					        	</select>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="mini_stock_report_start_date">Start Date</label>
	                            <input type="date" name="mini_stock_report_start_date" class="form-control bg-light" id="mini_stock_report_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="mini_stock_report_end_date">End Date</label>
	                            <input type="date" name="mini_stock_report_end_date" class="form-control bg-light" id="mini_stock_report_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="mini_stock_report_ok_btn" id="mini_stock_report_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="mini_stock_report_cancel_btn" id="mini_stock_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>