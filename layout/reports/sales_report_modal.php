<div 
class="modal fade hide bd-example-modal-lg" 
id="sales_report_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="sales_report_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="sales_report_modal_header">Sales Report</h5>
			</div>
			<div class="modal-body">
				<form id="sales_report_modal_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                    	<div id="sales_report_modal_warning"></div>
	                        <div class="col-md-12 mb-12 form-group">
	                            <input type="hidden" name="company_id_sales" class="form-control bg-light" id="company_id_sales">
	                            <input type="hidden" name="user_id_sales" class="form-control bg-light" id="user_id_sales">
	                            <input type="hidden" name="user_super_id_sales" class="form-control bg-light" id="user_super_id_sales">
	                            <label for="sales_report_company">Company</label>
	                            <select class="form-control" name="sales_report_company" id="sales_report_company"> 
	                                <option value="ALL">ALL</option>
	                                <?php
	                                    $sql="SELECT * FROM company ORDER BY trading_name ASC";
	                                    $result=mysqli_query($con,$sql);
										while($row=mysqli_fetch_array($result))
										{
											if($row['company_id']==$_SESSION['company_id'])
											{
												echo '<option value = "'.$row['company_id'].'" selected="selected">'.$row['trading_name'].'</option>';
											}
											else
											{
												echo '<option value = "'.$row['company_id'].'" >'.$row['trading_name'].'</option>';
											}
										}
	                                ?>
	                            </select>
	                        </div>
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="start_date_sales">Start Date</label>
	                            <input type="date" name="start_date_sales" class="form-control bg-light" id="start_date_sales">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="end_date_sales">End Date</label>
	                            <input type="date" name="end_date_sales" class="form-control bg-light" id="end_date_sales">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="sales_report_ok_btn" id="sales_report_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="sales_report_cancel_btn" id="sales_report_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>