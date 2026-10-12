<div 
class="modal fade hide bd-example-modal-lg" 
id="stock_purchase_import_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_purchase_import_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_purchase_import_modal_header">Import Stock Purchase</h5>
			</div>
			<div class="modal-body">
				<form id="stock_purchase_import_modal_form" action="stock_purchase_import.php" method="POST" enctype="multipart/form-data">
	                <div class="panel-body">
	                    <div class="form-row">
							<div id="stock_purchase_import_modal_warning"></div>
							<div class="col-md-12 mb-12 form-group">
								<label for="stock_purchase_import_ledger_id">Ledger</label>
								<select class="form-control bg-light" name="stock_purchase_import_ledger_id" id="stock_purchase_import_ledger_id"> 
									<option value="0">Please Select</option>
										<?php
											$company_id = $_SESSION['company_id'];
											
											$sql="SELECT * FROM ledgers WHERE 
											(company_id = '$company_id' AND (tb_4=4 OR tb_4=6 OR tb_4=7)) OR
											(default_status = 'yes' AND (tb_4=4 OR tb_4=6 OR tb_4=7))
											ORDER BY ledger_desc ASC";
											$result=mysqli_query($con,$sql);
											while($row=mysqli_fetch_array($result))
											{
												echo '<option value = "'.$row['ledger_id'].'" data-id="'.$row['ledger_desc'].'">
												'.$row['ledger_desc'].'</option>';
											};
										?>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12 form-group">
								<label for="stock_purchase_import_warehouse_id">Store</label>
								<select class="form-control bg-light" name="stock_purchase_import_warehouse_id" id="stock_purchase_import_warehouse_id"> 
									<option value="0">Please Select</option>
										<?php
											$company_id = $_SESSION['company_id'];
											/*if($_SESSION['user_type']=='Normal_User')
											{
												$user_id = $_SESSION['user_id'];
												$sql="SELECT * FROM ledgers WHERE (company_id = '$company_id' OR default_status = 'Yes') AND 
												ledger_id NOT IN (SELECT ledger_id FROM user_cash_ledger WHERE user_id='$user_id')
												ORDER BY ledger_desc ASC";
											}
											else
											{*/
												$sql="SELECT * FROM warehouse WHERE company_id = '$company_id' ORDER BY warehouse_desc ASC";
											//};
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
	                        <div class="col-md-6 mb-6 form-group">
	                            <label for="stock_purchase_import_applicable_date">Applicable Date</label>
	                            <input type="date" name="stock_purchase_import_applicable_date" class="form-control bg-light" id="stock_purchase_import_applicable_date">
	                        </div>
	                        <div class="col-md-6 mb-6 form-group">
	                            <label for="stock_purchase_import_reference_no">Reference</label>
	                            <input type="text" name="stock_purchase_import_reference_no" class="form-control bg-light" id="stock_purchase_import_reference_no">
	                        </div>
	                    </div>
		                <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="stock_purchase_import_narration">Narration</label>
	                            <input type="text" name="stock_purchase_import_narration" class="form-control bg-light" id="stock_purchase_import_narration">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="stock_purchase_import_file">Upload Purchase CSV file</label>
	                            <input type="file" class="form-control" name="stock_purchase_import_file" id="stock_purchase_import_file">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="submit" name="stock_purchase_import_post_btn" id="stock_purchase_import_post_btn" class="btn btn-primary" >Post</button>
	                    <button type="button" name="stock_purchase_import_cancel_btn" id="stock_purchase_import_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>