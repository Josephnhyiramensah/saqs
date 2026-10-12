<div 
class="modal fade bd-example-modal-lg" 
id="sms_purchase_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="sms_purchase_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="sms_purchase_create_modal_header">SMS Purchase Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="sms_purchase_create_form" method="POST">
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<input type="hidden" class="form-control" name="sms_utility_id" id="sms_utility_id">
							<label for="sms_company">Company</label>
							<select class="form-control" name="sms_company" id="sms_company" hidden="true"> 
							<option value="0">Please Select</option>
							<?php
                				$company_id = $_SESSION['company_id'];
								$sql="SELECT * FROM company ORDER BY trading_name ASC";
								$result=mysqli_query($con,$sql);
								while($row=mysqli_fetch_array($result))
								{
									if($company_id == $row['company_id'])
									{
										echo '<option value = "'.$row['company_id'].'" selected="selected">'.$row['trading_name'].'</option>';
									}
									else
									{
										echo '<option value = "'.$row['company_id'].'">'.$row['trading_name'].'</option>';
									};
								}
							?>
							</select>
							
							<select class="form-control" name="sms_company_2" id="sms_company_2" disabled="true"> 
                                <option value="0">Please Select</option>
                                <?php
                					$company_id = $_SESSION['company_id'];
                                  	$sql="SELECT * FROM company ORDER BY trading_name ASC";
                                	$result=mysqli_query($con,$sql);
									while($row=mysqli_fetch_array($result))
									{
										if($company_id == $row['company_id'])
										{
											echo '<option value = "'.$row['company_id'].'" selected="selected">'.$row['trading_name'].'</option>';
										}
										else
										{
											echo '<option value = "'.$row['company_id'].'">'.$row['trading_name'].'</option>';
										};
									};
                                ?>
                              </select>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="_sms_date">Date</label>
							<input type="date" class="form-control" name="sms_date" id="sms_date">
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<label for="sms_qty">Qty</label>
							<input type="text" class="form-control" name="sms_qty" id="sms_qty">
						</div>
					</div>
				    <div class="modal-footer">
				        <button type="button" name="sms_save_btn" id="sms_save_btn" class="btn btn-primary" >Save</button>
				        <button type="button" name="sms_update_btn" id="sms_update_btn" class="btn btn-primary" >Update</button>
				        <button type="submit" name="sms_cancel_btn" id="sms_cancel_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				    </div>
				</form>
			</div>
		</div>
	</div>
</div>