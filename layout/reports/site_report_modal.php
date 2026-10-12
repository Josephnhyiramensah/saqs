<div 
class="modal fade hide bd-example-modal-lg" 
id="site_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="site_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="site_report_modal_header">Site Report</h5>
			</div>
			<div class="modal-body">
				<form id="site_report_modal_form" method="POST">
	                <div class="panel-body">
	                	<div id="site_report_modal_warning"></div>
                        <input type="hidden" name="site_report_company_id" class="form-control bg-light" id="site_report_company_id">
                        <input type="hidden" name="site_report_user_id" class="form-control bg-light" id="site_report_user_id">
                        <input type="hidden" name="site_report_user_super_id" class="form-control bg-light" id="site_report_user_super_id">
                        <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="site_report_site">Site</label>
	                            <select class="form-control bg-light" name="site_report_site" id="site_report_site">
					                <option value="all">ALL</option>';
			                    <?php
			                    	$company_id = $_SESSION['company_id'];
			                        $sql_site = "SELECT * FROM site WHERE company_id = '$company_id' ORDER BY site ASC";
			                        $result_site = mysqli_query($con,$sql_site);
			                        while($row_site = mysqli_fetch_array($result_site))
			                        {
			                        	echo '<option value ="'.$row_site['site_id'].'">'.$row_site['site'].'</option>';
			                        };
			                    ?>
					        	</select>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="site_report_start_date">Start Date</label>
	                            <input type="date" name="site_report_start_date" class="form-control bg-light" id="site_report_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="site_report_end_date">End Date</label>
	                            <input type="date" name="site_report_end_date" class="form-control bg-light" id="site_report_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="site_report_ok_btn" id="site_report_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="site_report_cancel_btn" id="site_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>