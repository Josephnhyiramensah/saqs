<div 
class="modal fade hide bd-example-modal-lg" 
id="sales_summary_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="sales_summary_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="sales_summary_report_modal_header">Sales Summary Report</h5>
			</div>
			<div class="modal-body">
				<form id="sales_summary_report_modal_form" method="POST">
	                <div class="panel-body">
	                	<div id="sales_summary_report_modal_warning"></div>
                        <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="sales_summary_report_branch_id">Branch</label>
	                            <select class="form-control bg-light" name="sales_summary_report_branch_id" id="sales_summary_report_branch_id">
					            	<option value="ALL">ALL</option>
								<?php
	                                $company_id = $_SESSION['company_id'];
	                                $branch_id = $_SESSION['branch_id'];
			                        $sql_ssc="SELECT * FROM branch ORDER BY branch_name ASC";
									$result_ssc = mysqli_query($con,$sql_ssc);
									while($row_ssc = mysqli_fetch_array($result_ssc))
									{
										if($row_ssc['branch_id'] == $branch_id)
										{
											echo '<option value = "'.$row_ssc['branch_id'].'" selected="selected">'.$row_ssc['branch_name'].'</option>';
										}
										else
										{
											echo '<option value = "'.$row_ssc['branch_id'].'">'.$row_ssc['branch_name'].'</option>';
										}
									};
			                    ?>
					        	</select>
	                        </div>
	                    </div>
                        <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="sales_summary_report_type">Type</label>
	                            <select class="form-control bg-light" name="sales_summary_report_type" id="sales_summary_report_type">
									<option value="ALL">ALL</option>
									<option value="SALES">SALES</option>
					        	</select>
	                        </div>
	                    </div>
                        <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="sales_summary_report_category">Category</label>
	                            <select class="form-control bg-light" name="sales_summary_report_category" id="sales_summary_report_category">
					            	<option value="DETAILS">DETAILS</option>
									<option value="SUMMARY">SUMMARY</option>
					        	</select>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="sales_summary_report_start_date">Start Date</label>
	                            <input type="date" name="sales_summary_report_start_date" class="form-control bg-light" id="sales_summary_report_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="sales_summary_report_end_date">End Date</label>
	                            <input type="date" name="sales_summary_report_end_date" class="form-control bg-light" id="sales_summary_report_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="sales_summary_report_ok_btn" id="sales_summary_report_ok_btn" class="btn btn-primary">Execute</button>
	                    <button type="submit" name="sales_summary_report_cancel_btn" id="sales_summary_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>