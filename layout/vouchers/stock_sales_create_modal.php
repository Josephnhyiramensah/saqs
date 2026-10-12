<div 
class="modal fade hide bd-example-modal-xl" 
id="stock_sales_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="stock_sales_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 95%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="stock_sales_create_modal_header">Stock Sales Invoice</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="stock_sales_create_form" method="POST">
	                <div class="panel-body">
	                    <input type="hidden" name="stock_sales_id" class="form-control bg-light" id="stock_sales_id">
	                    <input type="hidden" name="stock_sales_order_id" class="form-control bg-light" id="stock_sales_order_id">
	                    <input type="hidden" name="stock_sales_req_id" class="form-control bg-light" id="stock_sales_req_id">
                		<input type="hidden" name="stock_sales_invoice_type" class="form-control" id="stock_sales_invoice_type">
                		<input type="hidden" name="stock_sales_credit" class="form-control" id="stock_sales_credit">
	                    <input type="hidden" name="stock_sales_customer_id" class="form-control bg-light" id="stock_sales_customer_id">
                		<input type="hidden" name="stock_sales_branch_company_id" class="form-control bg-light text-right" id="stock_sales_branch_company_id">
                		<input type="hidden" name="stock_sales_branch_warehouse_id" class="form-control bg-light text-right" id="stock_sales_branch_warehouse_id">
	                    <div class="form-row">
							<div class="col-md-5 mb-5 form-group branch_ifo">
								<label for="stock_sales_buying_branch">Branch</label>
								<select class="form-control bg-light" name="stock_sales_buying_branch" id="stock_sales_buying_branch"> 
									<option value="0">Please Select</option>
									<?php
										$sql="SELECT * FROM company WHERE company_id != '$company_id' ORDER BY trading_name ASC";
										$result = mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value = "'.$row['company_id'].'">'.$row['trading_name'].'</option>';
										};
									?>
								</select>
							</div>
	                        <div class="col-md-2 mb-2 form-group customer">
	                            <label for="stock_sales_customer_telephone"><strong>Customer Telephone</strong></label>
	                            <input type="text" class="form-control bg-light" name="stock_sales_customer_telephone" id="stock_sales_customer_telephone">
	                        </div>
	                        <div class="col-md-3 mb-3 form-group customer">
	                            <label for="stock_sales_customer_name"><strong>Customer Name</strong></label>
	                            <input type="text" class="form-control bg-light" name="stock_sales_customer_name" id="stock_sales_customer_name">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_date"><strong>Date</strong></label>
	                            <input type="date" class="form-control bg-light text-center" name="stock_sales_date" id="stock_sales_date" value="<?php echo $date_today;?>">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_amount"><strong>Gross Amount</strong></label>
	                            <input type="text" class="form-control bg-light text-right" name="stock_sales_amount" id="stock_sales_amount" hidden="true">
	                            <input type="text" class="form-control bg-light text-right" name="stock_sales_amount_2" id="stock_sales_amount_2" disabled="true">
	                        </div>
	                        <div class="col-md-1 mb-1 form-group">
	                            <label for="stock_sales_discount_amount"><strong>Discount</strong></label>
	                            <input type="hidden" class="form-control text-right" name="stock_sales_discount_amount" id="stock_sales_discount_amount">
	                            <input type="text" class="form-control text-right" name="stock_sales_discount_amountD" id="stock_sales_discount_amountD" disabled="true">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_net_amount"><strong>Net Amount</strong></label>
	                            <input type="hidden" class="form-control text-right" name="stock_sales_net_amount" id="stock_sales_net_amount">
	                            <input type="text" class="form-control text-right" name="stock_sales_net_amountD" id="stock_sales_net_amountD" disabled="true">
	                        </div>
	                    </div>
	                    <div class="form-row" id="customer_info" hidden>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_membership_no"><strong>Membership No</strong></label>
	                            <input type="text" class="form-control bg-light" name="stock_sales_membership_no" id="stock_sales_membership_no">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_date_of_birth"><strong>Date of Birth <?php echo '<span id="stock_sales_age"></span>';?></strong></label>
	                            <input type="date" class="form-control bg-light text-center" name="stock_sales_date_of_birth" id="stock_sales_date_of_birth">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_gender"><strong>Gender</strong></label>
	                            <select class="form-control bg-light" name="stock_sales_gender" id="stock_sales_gender"> 
	                                <option value="0">Please Select</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
	                            </select>
							</div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_location"><strong>Location</strong></label>
	                            <input type="text" class="form-control bg-light" name="stock_sales_location" id="stock_sales_location">
	                        </div>
							<div class="col-md-4 mb-4 form-group">
								<label for="stock_sales_insurance_company">Company</label>
								<select class="form-control bg-light" name="stock_sales_insurance_company" id="stock_sales_insurance_company"> 
									<option value="0">Please Select</option>
										<?php
											$sql="SELECT * FROM ledgers WHERE tb_5=1 OR tb_5=12 ORDER BY ledger_desc ASC";
											$result = mysqli_query($con,$sql);
											while($row = mysqli_fetch_array($result))
											{
												echo '<option value = "'.$row['ledger_id'].'">
												'.$row['ledger_desc'].'</option>';
											};
										?>
								</select>
							</div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-10 mb-10 form-group">
	                            <label for="stock_sales_narration"><strong>Narration</strong></label>
	                            <input type="text" class="form-control bg-light" name="stock_sales_narration" id="stock_sales_narration">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="stock_sales_warehouse_id"><strong>Warehouse</strong></label>
	                            <select class="form-control bg-light" name="stock_sales_warehouse_id" id="stock_sales_warehouse_id"> 
	                                <option value="0">Please Select</option>
	                                <?php
	                                    $sql="SELECT * FROM warehouse ORDER BY warehouse_desc ASC";
	                                    $result=mysqli_query($con,$sql);
										while($row=mysqli_fetch_array($result))
										{
											if($warehouse_id == $row['warehouse_id'])
											{
												echo '<option value = "'.$row['warehouse_id'].'" selected="selected">'.$row['warehouse_desc'].'
												</option>';
											}
											else
											{
												echo '<option value = "'.$row['warehouse_id'].'">'.$row['warehouse_desc'].'
												</option>';
											};
										}               
	                                ?>
	                            </select>
	                            <select class="form-control bg-light" name="stock_sales_warehouse_idD" id="stock_sales_warehouse_idD" disabled="true" hidden="true"> 
	                                <option value="0">Please Select</option>
	                                <?php
	                                    $sql="SELECT * FROM warehouse ORDER BY warehouse_desc ASC";
	                                    $result=mysqli_query($con,$sql);
										while($row=mysqli_fetch_array($result))
										{
											if($warehouse_id == $row['warehouse_id'])
											{
												echo '<option value = "'.$row['warehouse_id'].'" selected="selected">'.$row['warehouse_desc'].'
												</option>';
											}
											else
											{
												echo '<option value = "'.$row['warehouse_id'].'">'.$row['warehouse_desc'].'
												</option>';
											};
										}               
	                                ?>
	                            </select>
	                        </div>
	                    </div>
						<ul class="nav nav-tabs nav-justified">
							<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#stock_sales_details"><strong>ITEMS DETAIL</strong></a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#stock_sales_payment_options"><strong>PAYMENT DETAIL</strong></a></li>
						</ul>
						<div class="tab-content">
							<div id="stock_sales_details" class="tab-pane fade show active">
								<div class="form-row">
									<div class="col-md-9 mb-9 form-group">
										<label for="stock_sales_search_item"><strong>Search New Item</strong></label>
										<input type="text" class="form-control bg-light" name="stock_sales_search_item" id="stock_sales_search_item">
									</div>
									<div class="col-md-3 mb-3 form-group">
										<label for="stock_sales_search_item_criteria"><strong>Criteria</strong></label>
										<select class="form-control bg-light" name="stock_sales_search_item_criteria" id="stock_sales_search_item_criteria"> 
											<option value="Name">Name</option>
											<option value="Code">Code</option>
											<option value="Barcode">Barcode</option>
										</select>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-12 mb-12 form-group scroll_search_div"  id="stock_sales_search_items_list">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-12 mb-12" id="stock_sales_items_list">
										<table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="stock_sales_items_table">
											<tr id="1">
												<th>Description</th>
												<th class = "action-td">Requested Qty</th>
												<th class = "action-td">Issue Qty</th>
												<th class = "action-td">Billed Qty</th>
												<th class = "action-td">Price</th>
												<th class = "action-td">Amount</th>
												<th class = "action-td">Disc.%</th>
												<th class = "action-td">Disc. Amt</th>
												<th class = "action-td">Action</th>
											</tr>
										</table>
									</div>
								</div>
							</div>
							<div id="stock_sales_payment_options" class="tab-pane fade">
								<table class="table table-hover table-bordered table-sm" id="stock_sales_invoice_payment_optionTable" width="100%" cellspacing="0">
									<thead>
										<tr id="1">
											<th width="60%" class = "action-td"><a href="#" data-toggle="" id="stock_sales_invoice_add_ledger">Ledger <small>(click to add ledger)</small></a></th>
											<th width="40%" class = "action-td" colspan="2">Amount</th>
										</tr>
									</thead>
									<tbody class="pv-table-body">
										<tr id="2">
											<td width="50%">
												<select class="form-control bg-light" name="payment_option_ledger_id[]" id="payment_option_ledger_id2"> 
													<option value="0">Please Select</option>';
													<?php
														$company_id = $_SESSION['company_id'];
														$cash_ledger_id = $_SESSION['cash_ledger_id'];
														$sql="SELECT * FROM ledgers WHERE  tb_4 = 6 OR  tb_4 = 4 ORDER BY ledger_desc ASC";
														$result=mysqli_query($con,$sql);
														while($row = mysqli_fetch_array($result))
														{
															if($row['ledger_id'] == $cash_ledger_id)
															{
																echo '<option value = "'.$row['ledger_id'].'" ledger_company_id = "'.$row['ledger_company_id'].'" selected="selected">
																'.$row['ledger_desc'].'</option>';
															}
															else
															{
																echo '<option value = "'.$row['ledger_id'].'" ledger_company_id = "'.$row['ledger_company_id'].'">
																'.$row['ledger_desc'].'</option>';
															};
														};
													
													?>
												</select>
											</td>
											<td width="30%">
												<input type="text" name="payment_option_ledger_amount[]" class="form-control payment_option_amount bg-light text-right" id="payment_option_ledger_amount2">
											</td>
											<td width="20%" class="action-td">
												<!--<a href="#" data-toggle="" id="delete_payment_option_ledger">Delete</a>-->
											</td>
										</tr>
									</tbody>
								</table>
								<table class="table table-hover table-bordered table-sm" id="stock_sales_invoice_payment_optionTotalTable" width="100%" cellspacing="0">
									<thead>
										<th width="60%" class = "amt-td">Total</th>
										<th width="30%" class = "action-td">
											<input type="text" class="form-control text-right" name="payment_option_total" id="payment_option_total">
										</th>
										<th width="10%" class = "action-td"></th>
									</thead>
									<thead>
										<th width="60%" class = "amt-td">Cash Tendered</th>
										<th width="30%" class = "action-td">
											<input type="text" class="form-control text-right" name="payment_option_cash_tendered" id="payment_option_cash_tendered">
										</th>
										<th width="10%" class = "action-td"></th>
									</thead>
									<thead>
										<th width="60%" class = "amt-td">Change</th>
										<th width="30%" class = "action-td">
											<input type="text" class="form-control text-right" name="payment_option_change" id="payment_option_change">
										</th>
										<th width="10%" class = "action-td"></th>
									</thead>
								</table>
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="stock_sales_save_btn" id="stock_sales_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="button" name="stock_sales_update_btn" id="stock_sales_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="stock_sales_cancel_btn" id="stock_sales_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>