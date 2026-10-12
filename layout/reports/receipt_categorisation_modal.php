<div 
class="modal fade hide bd-example-modal-lg" 
id="receipt_categorisation_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="receipt_categorisation_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="receipt_categorisation_modal_header">Receipt Categorisation Report</h5>
			</div>
			<div class="modal-body">
				<form id="receipt_categorisation_modal_form" method="POST">
	                <div class="panel-body">
	                    <div class="form-row">
							<div id="receipt_categorisation_modal_warning"></div>
							<div class="col-md-12 mb-12 form-group">
								<label for="receipt_categorisation_cashier">Cashier</label>
								<select class="form-control bg-light" name="receipt_categorisation_cashier" id="receipt_categorisation_cashier"> 
									<option value="ALL">ALL</option>
									<?php
										$company_id = $_SESSION['company_id'];
										$sql="SELECT * FROM users WHERE company_id = '$company_id' ORDER BY first_name ASC";
										$result = mysqli_query($con, $sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value = "'.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].'
											</option>';
										};
									?>
								</select>
							</div>
		                </div>
	                    <div class="form-row">
							<div class="col-md-12 mb-12 form-group">
								<label for="receipt_categorisation_branch">Branch</label>
								<select class="form-control bg-light" name="receipt_categorisation_branch" id="receipt_categorisation_branch"> 
									<option value="ALL">ALL</option>
									<?php
										$branch_id = $_SESSION['branch_id'];
										if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
										{
											$sql="SELECT * FROM branch ORDER BY branch_name ASC";
										}
										else
										{
											$sql="SELECT * FROM branch WHERE branch_id='$branch_id' ORDER BY branch_name ASC";
										};
										$result = mysqli_query($con, $sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value = "'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
										};
									?>
								</select>
							</div>
		                </div>
	                    <div class="form-row">
							<div class="col-md-12 mb-12 form-group">
								<label for="receipt_categorisation_tos">Type of Service</label>
								<select class="form-control bg-light" name="receipt_categorisation_tos" id="receipt_categorisation_tos"> 
									<option value="ALL">ALL</option>
									<?php
										$company_id = $_SESSION['company_id'];
										$sql="SELECT * FROM type_of_service ORDER BY description ASC";
										$result = mysqli_query($con, $sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value = "'.$row['tos_id'].'">'.$row['description'].'</option>';
										};
									?>
								</select>
							</div>
		                </div>
	                    <div class="form-row">
							<div class="col-md-12 mb-12 form-group">
								<label for="receipt_categorisation_type">Type of Report</label>
								<select class="form-control bg-light" name="receipt_categorisation_type" id="receipt_categorisation_type"> 
									<option value="Detail">Detail</option>
									<option value="Summary">Summary</option>
									<option value="Super_Summary">Super_Summary</option>
								</select>
							</div>
		                </div>
		                <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="receipt_categorisation_start_date">Start Date</label>
	                            <input type="date" name="receipt_categorisation_start_date" class="form-control bg-light" id="receipt_categorisation_start_date">
	                        </div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="receipt_categorisation_end_date">End Date</label>
	                            <input type="date" name="receipt_categorisation_end_date" class="form-control bg-light" id="receipt_categorisation_end_date">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="receipt_categorisation_ok_btn" id="receipt_categorisation_ok_btn" class="btn btn-primary" >Save</button>
	                    <button type="submit" name="receipt_categorisation_cancel_btn" id="receipt_categorisation_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>