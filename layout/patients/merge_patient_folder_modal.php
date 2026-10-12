<div 
class="modal fade hide bd-example-modal-lg" 
id="merge_patient_folder_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="merge_patient_folder_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="merge_patient_folder_modal_header">Merger Patient Folder</h5>
			</div>
			<div class="modal-body">
				<form id="merge_patient_folder_modal_form" method="POST">
	                <div class="panel-body">
	                	<div id="merge_patient_folder_modal_warning"></div>
                        <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="merge_patient_folder_from">Patient(From)</label>
	                           	<select class="form-control" name="merge_patient_folder_from" id="merge_patient_folder_from">
								<?php
									$sql="SELECT * FROM patients ORDER BY firstName ASC";
									$result = mysqli_query($con,$sql);
									while($row = mysqli_fetch_array($result))
									{
										echo '<option value = "'.$row['patient_id'].'">'.$row['patient_id'].' '.$row['folderNo'].' :-'.$row['firstName'].' '.$row['lastName'].'</option>';
									};
								?>
								</select>
							</div>
	                    </div> 
	                    <div class="form-row">
	                        <div class="col-md-12 mb-12 form-group">
	                            <label for="merge_patient_folder_to">Patient (To)</label>
	                           	<select class="form-control" name="merge_patient_folder_to" id="merge_patient_folder_to"> 
								<?php
									$sql="SELECT * FROM patients ORDER BY firstName ASC";
									$result = mysqli_query($con,$sql);
									while($row = mysqli_fetch_array($result))
									{
										echo '<option value = "'.$row['patient_id'].'">'.$row['patient_id'].' '.$row['folderNo'].' :-'.$row['firstName'].' '.$row['lastName'].'</option>';
									};
								?>
								</select>
							</div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" name="merge_patient_folder_merge_btn" id="merge_patient_folder_merge_btn" class="btn btn-primary">Merge</button>
	                    <button type="submit" name="merge_patient_folder_cancel_btn" id="merge_patient_folder_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>