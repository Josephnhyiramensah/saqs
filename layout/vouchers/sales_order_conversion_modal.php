<div 
class="modal fade hide bd-example-modal-xl" 
id="sales_order_conversion_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="sales_order_conversion_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 95%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="sales_order_conversion_modal_header">Sales Order Conversion</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="sales_order_conversion_form" method="POST">
					<div id="sales_order_conversion_item_search_msg"></div>
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-3 mb-3 form-group">
	                            <input type="hidden" name="sales_order_id" class="form-control bg-light" id="sales_order_id">
	                            <label for="sales_order_from">Warehouse</label>
	                            <select class="form-control" name="sales_order_from" id="sales_order_from"> 
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
	                            <select class="form-control" name="sales_order_fromD" id="sales_order_fromD" disabled="true" hidden="true"> 
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
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="sales_order_ledger">Customer/Cash Ledger</label>
	                            <select class="form-control" name="sales_order_ledger" id="sales_order_ledger"> 
	                                <option value="0">Please Select</option>
	                                 <?php
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
	                            <select class="form-control" name="sales_order_ledgerD" id="sales_order_ledgerD" disabled="true" hidden="true"> 
	                                <option value="0">Please Select</option>
	                                 <?php
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
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="sales_order_date">Date</label>
	                            <input type="date" class="form-control" name="sales_order_date" id="sales_order_date" value="<?php echo date('Y-m-d');?>">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="sales_order_amount">Amount</label>
	                            <input type="hidden" class="form-control text-right" name="sales_order_amount" id="sales_order_amount">
	                            <input type="text" class="form-control text-right" name="sales_order_amountD" id="sales_order_amountD" disabled="true">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="sales_order_discount_amount">Discount Amount</label>
	                            <input type="hidden" class="form-control text-right" name="sales_order_discount_amount" id="sales_order_discount_amount">
	                            <input type="text" class="form-control text-right" name="sales_order_discount_amountD" id="sales_order_discount_amountD" disabled="true">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-3 mb-3 form-group">
	                            <label for="sales_order_requested_by">Requested by</label>
	                            <input type="text" class="form-control" name="sales_order_requested_by" id="sales_order_requested_by">
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="sales_order_requested_telephone">Telephone</label>
	                            <input type="text" class="form-control" name="sales_order_requested_telephone" id="sales_order_requested_telephone">
	                        </div>
	                        <div class="col-md-7 mb-7 form-group">
	                            <label for="sales_order_narration">Narration</label>
	                            <input type="text" class="form-control" name="sales_order_narration" id="sales_order_narration">
	                        </div>
	                    </div>
						<ul class="nav nav-tabs nav-justified">
							<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#sales_order_details"><strong>ITEMS DETAIL</strong></a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sales_order_payment_options"><strong>PAYMENT DETAIL</strong></a></li>
						</ul>
						<div class="tab-content">
							<div id="sales_order_details" class="tab-pane fade show active">
								<div class="form-row">
									<div class="col-md-9 mb-9 form-group">
										<label for="sales_order_search_item">Search New Item</label>
										<input type="text" class="form-control" name="sales_order_search_item" id="sales_order_search_item">
									</div>
									<div class="col-md-3 mb-3 form-group">
										<label for="sales_order_search_item_criteria">Criteria</label>
										<select class="form-control" name="sales_order_search_item_criteria" id="sales_order_search_item_criteria"> 
											<option value="Name">Name</option> 
											<option value="Code">Code</option> 
											<option value="Barcode">Barcode</option> 
										</select>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-12 mb-12 form-group scroll_search_div"  id="sales_order_search_items_list">
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-12 mb-12 scroll_search_div" id="sales_order_items_list">
									</div>
								</div>
							</div>
							<div id="sales_order_payment_options" class="tab-pane fade">
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
	                    <button type="button" name="sales_order_conversion_save_btn" id="sales_order_conversion_save_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="sales_order_conversion_cancel_btn" id="sales_order_conversion_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>