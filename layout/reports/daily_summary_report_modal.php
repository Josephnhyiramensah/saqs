<div 
class="modal fade hide bd-example-modal-lg" 
id="daily_summary_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="daily_summary_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="daily_summary_report_modal_header">Daily Summary Report</h5>
			</div>
			<div class="modal-body">
				<form id="daily_summary_report_modal_form" method="POST">
	                <div class="panel-body">
	                    <div id="daily_summary_report_modal_warning"></div>
		                <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="daily_summary_report_start_date">Start Date</label>
	                            <input type="date" name="daily_summary_report_start_date" class="form-control bg-light" id="daily_summary_report_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="daily_summary_report_end_date">End Date</label>
	                            <input type="date" name="daily_summary_report_end_date" class="form-control bg-light" id="daily_summary_report_end_date">
	                        </div>
	                    </div>
	                    <!--<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="daily_summary_report_sponsor">Sponsor</label>
								<select class="form-control bg-light" name="daily_summary_report_sponsor" id="daily_summary_report_sponsor" required> 
							    	<option value="all">ALL</option>
							        <?php
							        	/*$sponsor_query ="SELECT * FROM ledgers WHERE tb_5=1";
										$sponsor_query_result=mysqli_query($con,$sponsor_query);
										while($row_sponsor = mysqli_fetch_array($sponsor_query_result))
            							{
											echo '<option value = "'.$row_sponsor['ledger_id'].'">'.$row_sponsor['ledger_desc'].'</option>';
										};*/
							        ?>
							    </select>
							</div>
						</div>
	                    <div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="daily_summary_report_bal_type">Balance Type</label>
								<select class="form-control bg-light" name="daily_summary_report_bal_type" id="daily_summary_report_bal_type" required> 
							    	<option value="all">ALL</option>
							    	<option value="negative">NEGATIVE</option>
							    	<option value="positive">POSITIVE</option>
							    </select>
							</div>
						</div>-->
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="daily_summary_report_ok_btn" id="daily_summary_report_ok_btn" class="btn btn-primary" >OK</button>
	                    <button type="submit" name="daily_summary_report_cancel_btn" id="daily_summary_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>