<div 
class="modal fade hide bd-example-modal-lg" 
id="price_level_import_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="price_level_import_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="price_level_import_modal_header">Import Price List</h5>
			</div>
			<div class="modal-body">
				<form id="price_level_import_modal_form" action="price_level_import.php" method="POST" enctype="multipart/form-data">
	                <div class="panel-body">
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
								<select class="form-control" name="price_level_import_company_id" id="price_level_import_company_id"> 
									<option value="0">Please Select</option>
									<?php
										if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 3)) 
										{
											$sql="SELECT * FROM company ORDER BY trading_name ASC";
										}
										else
										{
											$sql="SELECT * FROM company WHERE company_id='".$_SESSION['company_id']."' ORDER BY trading_name ASC";
										};
										$result=mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($result))
										{
											echo '<option value ="'.$row['company_id'].'">'.$row['trading_name'].'</option>';
										};
									?>
								</select>
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="price_level_import_date">Applicable Date</label>
	                            <input type="date" class="form-control" name="price_level_import_date" id="price_level_import_date">
	                        </div>
	                    </div>
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="price_level_import_file">Upload item CSV file</label>
	                            <input type="file" class="form-control" name="price_level_import_file" id="price_level_import_file">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="submit" name="price_level_import_post_btn" id="price_level_import_post_btn" class="btn btn-primary">Import</button>
	                    <button type="button" name="price_level_import_cancel_btn" id="price_level_import_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>