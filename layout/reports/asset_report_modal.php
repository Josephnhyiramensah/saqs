<div 
class="modal fade hide bd-example-modal-lg" 
id="asset_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="asset_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="asset_report_modal_header">Asset Report</h5>
			</div>
			<div class="modal-body">
				<form id="asset_report_modal_form" method="POST">
	                <div class="panel-body">
	                	<div id="asset_report_modal_warning"></div>
                        <input type="hidden" name="asset_report_company_id" class="form-control bg-light" id="asset_report_company_id">
                        <input type="hidden" name="asset_report_user_id" class="form-control bg-light" id="asset_report_user_id">
                        <input type="hidden" name="asset_report_user_super_id" class="form-control bg-light" id="asset_report_user_super_id">
                        <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="asset_report_asset">Site</label>
	                            <select class="form-control bg-light" name="asset_report_asset" id="asset_report_asset">
					                <option value="all">ALL</option>';
			                    <?php
			                    	$company_id = $_SESSION['company_id'];
			                        $sql_asset = "SELECT * FROM assets WHERE company_id = '$company_id' ORDER BY brand ASC";
			                        $result_asset = mysqli_query($con,$sql_asset);
			                        while($row_asset = mysqli_fetch_array($result_asset))
			                        {
			                        	echo '<option value ="'.$row_asset['asset_id'].'">'.$row_asset['brand'].' - '.$row_asset['model'].'</option>';
			                        };
			                    ?>
					        	</select>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="asset_report_start_date">Start Date</label>
	                            <input type="date" name="asset_report_start_date" class="form-control bg-light" id="asset_report_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="asset_report_end_date">End Date</label>
	                            <input type="date" name="asset_report_end_date" class="form-control bg-light" id="asset_report_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="asset_report_ok_btn" id="asset_report_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="asset_report_cancel_btn" id="asset_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>