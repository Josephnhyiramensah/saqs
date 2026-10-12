<div 
class="modal fade hide bd-example-modal-lg" 
id="cash_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="cash_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="cash_report_modal_header">Cash Report</h5>
			</div>
			<div class="modal-body">
				<form id="cash_report_modal_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                    		<div id="cash_report_modal_warning"></div>
		                        <div class="col-md-12 mb-12 form-group">
		                            <label for="cash_report_ledger_id">Ledger</label>
		                            <select class="form-control bg-light" name="cash_report_ledger_id" id="cash_report_ledger_id"> 
		                                <option value="ALL">ALL</option>
			                                <?php
		                                		$company_id = $_SESSION['company_id'];

												if($_SESSION['user_type']=='Normal_User')
												{
													$user_id = $_SESSION['user_id'];
													$sql="SELECT * FROM ledgers WHERE ((company_id = '$company_id' AND tb_4=6) OR 
													(default_status = 'Yes' AND tb_4=6)) AND 
													ledger_id NOT IN (SELECT ledger_id FROM user_cash_ledger WHERE user_id='$user_id')
													ORDER BY ledger_desc ASC";
												}
												else
												{
													$sql="SELECT * FROM ledgers WHERE (company_id = '$company_id' AND tb_4=6) OR 
													(default_status = 'Yes' AND tb_4=6)
													ORDER BY ledger_desc ASC";
												};
			                                    $result = mysqli_query($con,$sql);
			                                    while($row = mysqli_fetch_array($result))
			                                    {
													echo'<option value = "'.$row['ledger_id'].'">'.$row['ledger_desc'].'</option>';
			                                    };
			                                ?>
		                            </select>
		                        </div>
		                </div>
		                <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <input type="hidden" name="cash_report_company_id" class="form-control bg-light" id="cash_report_company_id">
	                            <input type="hidden" name="cash_report_user_id" class="form-control bg-light" id="cash_report_user_id">
	                            <input type="hidden" name="cash_report_user_super_id" class="form-control bg-light" id="cash_report_user_super_id">
	                            <label for="cash_report_start_date">Start Date</label>
	                            <input type="date" name="cash_report_start_date" class="form-control bg-light" id="cash_report_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="cash_report_end_date">End Date</label>
	                            <input type="date" name="cash_report_end_date" class="form-control bg-light" id="cash_report_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="cash_report_ok_btn" id="cash_report_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="cash_report_cancel_btn" id="cash_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>