<div 
class="modal fade hide bd-example-modal-xl" 
id="employee_validation_sheet_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="employee_validation_sheet_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 60%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="employee_validation_sheet_create_modal_header">Employee Validation Sheet Setup</h5>
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>-->
			</div>
			<div class="modal-body">
				<form id="employee_validation_sheet_create_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-10 mb-10 form-group">
	                            <label for="employee_validation_sheet_location">Location</label>
								<select class="form-control bg-light" name="employee_validation_sheet_location" id="employee_validation_sheet_location"> 
									<option value="0">Please Select</option>
									<?php
										if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 2)) 
										{
											$sql="SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name ASC";
										}
										else
										{
											$sql="SELECT * FROM branch WHERE company_id = '$company_id' AND branch_id='$branch_id' ORDER BY branch_name ASC";
										};
										$result = mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											if($row['branch_id']==$branch_id)
											{
												echo '<option value = "'.$row['branch_id'].'" selected="selected">'.$row['branch_name'].'</option>';
											}
											else
											{
												echo '<option value = "'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
											};
										};
									?>
								</select>
	                        </div>
	                        <div class="col-md-2 mb-2 form-group">
	                            <label for="employee_validation_sheet_date">Date</label>
	                            <input type="hidden" name="employee_validation_sheet_id" class="form-control bg-light" id="employee_validation_sheet_id">
	                            <input type="date" class="form-control bg-light" name="employee_validation_sheet_date" id="employee_validation_sheet_date" value="<?php echo $date_today;?>">
	                        </div>
	                	</div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="employee_validation_sheet_remarks">Remarks</label>
	                            <input type="text" class="form-control bg-light" name="employee_validation_sheet_remarks" id="employee_validation_sheet_remarks">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12" id="employee_validation_sheet_list_div">
	                            <table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="employee_validation_sheet_list_table">
	                                <tr>
	                                    <th width="35%">Debit Ledger(s)</th><?php
				                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['company_type_id'] == 3 OR $_SESSION['company_type_id'] == 5) 
			          					{
					                        echo '<th width="15%">Site</th>';
		                                };
	                                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['company_type_id'] == 4 OR $_SESSION['company_type_id'] == 5) 
			          					{
					                        echo '<th width="15%">Asset</th>';
				                        };
			                            ?>
	                                    <th width="10%">Amount</th>
	                                    <th width="20%">Narration</th>
	                                    <th width="5%">Action</th>
	                                </tr>
	                                <tr id="1">
	                                    <td>
	                                        <select class="form-control payment_led_dr bg-light" name="payment_led_dr[]" id="payment_led_dr1" data-id="1" style="border-width:0px"> 
	                                            <option value="0">Please Select</option>
	                                            <?php
				                                    $sql="SELECT * FROM ledgers 
													WHERE (company_id = '$company_id' AND tb_2 !=3 AND tb_4 !=6)
													OR (default_status = 'Yes' AND tb_2 !=3 AND tb_4 !=6) 
	
													OR (company_id = '$company_id' AND tb_4 !=10 AND tb_4 !=6)
													OR (default_status = 'Yes' AND tb_4 !=10 AND tb_4 !=6)
													ORDER BY ledger_desc ASC";
				                                    $result=mysqli_query($con,$sql);
				                                    	while($row=mysqli_fetch_array($result))
				                                    	{
				                                    ?>
				                                    		<option value = "<?php echo($row['ledger_id'])?>" ><?php echo($row['ledger_desc']) ?></option>
				                                    <?php
				                                    	};
				                                ?>
	                                        </select>
	                                    </td>

				                        <?php
				                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['company_type_id'] == 3 OR $_SESSION['company_type_id'] == 5) 
			          					{
					                        echo '<td>
			                                        <select class="form-control payment_site_dr bg-light" name="payment_site_dr[]" id="payment_site_dr1" data-id="1" style="border-width:0px"> 
			                                            <option value="0">Please Select</option>';
			                                            
						                                    $sql_site = "SELECT * FROM site WHERE company_id = '$company_id' ORDER BY site ASC";
						                                    $result_site = mysqli_query($con,$sql_site);
						                                    	while($row_site=mysqli_fetch_array($result_site))
						                                    	{
																	if($_SESSION['branch_id']==$row_site['site_id'])
						                                    		{
																		echo '<option value = "'.$row_site['site_id'].'" selected="selected">'.$row_site['site'].'</option>';
																	}
																	else
																	{
																		echo '<option value = "'.$row_site['site_id'].'" >'.$row_site['site'].'</option>';
																	};
						                                    	};
			                                        echo '</select>
			                                    </td>';
				                        };
				                        if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['company_type_id'] == 4 OR $_SESSION['company_type_id'] == 5) 
			          					{
					                        echo '<td>
			                                        <select class="form-control payment_asset_dr bg-light" name="payment_asset_dr[]" id="payment_asset_dr1" data-id="1" style="border-width:0px"> 
			                                            <option value="0">Please Select</option>';
			                                            
						                                    $sql_asset = "SELECT * FROM assets WHERE company_id = '$company_id' ORDER BY brand ASC";
						                                    $result_asset = mysqli_query($con,$sql_asset);
						                                    	while($row_asset=mysqli_fetch_array($result_asset))
						                                    	{
						                                   
						                                    		echo '<option value = "'.$row_asset['asset_id'].'" >'.$row_asset['brand'].' - '.$row_asset['model'].'</option>';
						                                    
						                                    	};
						                                
			                                        echo '</select>
			                                    </td>';
				                        };
			                            ?>
	                                    
	                                    <td class = "action-td">
	                                        <input type="text" name="payment_dr_amt[]" class="form-control bg-light payment_dr_amt amt-td" id="payment_dr_amt1" data-id="1" style="border-width:0px">
	                                    </td>
	                                    <td class = "action-td">
	                                        <input type="text" name="payment_dr_narration[]" class="form-control bg-light payment_dr_narration" id="payment_dr_narration1" data-id="1" style="border-width:0px">
	                                    </td>
	                                    <td class = "action-td">
	                                        <!--<a href="#" id="delete_payment_dr" data-id="1"><i class="fa fa-trash fa-sm"></i></a>-->
	                                    </td>
	                                </tr>
	                            </table>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="employee_validation_sheet_save_btn" id="employee_validation_sheet_save_btn" class="btn btn-primary">Save</button>
	                    <button type="button" name="employee_validation_sheet_update_btn" id="employee_validation_sheet_update_btn" class="btn btn-primary">Update</button>
	                    <button type="submit" name="employee_validation_sheet_cancel_btn" id="employee_validation_sheet_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
          		<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
			</div>
		</div>
	</div>
</div>