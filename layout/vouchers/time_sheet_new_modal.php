<div 
class="modal fade hide bd-example-modal-lg" 
id="time_sheet_new_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="time_sheet_new_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="time_sheet_new_modal_header">Ledger Report</h5>
			</div>
			<div class="modal-body">
				<form id="time_sheet_new_modal_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
							<div id="time_sheet_new_modal_warning"></div>
							<div class="col-md-12 mb-12 form-group">
								<label for="time_sheet_new_branch_id">Branch</label>
								<select class="form-control bg-light" name="time_sheet_new_branch_id" id="time_sheet_new_branch_id"> 
									<option value="0">Please Select</option>
									<?php
										$company_id = $_SESSION['company_id'];
										$sql="SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name ASC";
										$result = mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											if($_SESSION['branch_id']==$row['branch_id'])
											{
												echo '<option value = "'.$row['branch_id'].'" selected ="selected">'.$row['branch_name'].'</option>';
											}
											else
											{
												echo '<option value = "'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
											};
										};
									?>
								</select>
							</div>
		                </div>
		                <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="time_sheet_new_effective_date">Effective Date</label>
	                            <input type="date" name="time_sheet_new_effective_date" class="form-control bg-light" id="time_sheet_new_effective_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="time_sheet_new_ok_btn" id="time_sheet_new_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="time_sheet_new_cancel_btn" id="time_sheet_new_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>