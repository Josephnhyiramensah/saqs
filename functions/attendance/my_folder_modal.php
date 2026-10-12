<div 
class="modal fade hide bd-example-modal-xl" 
id="my_folder_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="my_folder_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
	<div class="modal-dialog" style="max-width: 80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="my_folder_modal_header"><?php echo $name;?>'s Folder</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive no-padding">
		        	<table width="100%" cellpadding="3" cellspacing="3">
			            <tr>
			                <td>
			                	<table id="my_folder_top_table" width="100%">
				                    <tr>
				                    	<td width="50%"><strong>Patient Name: </strong><?php echo $name;?></td>
				                    	<td width="50%"><strong>Date of Birth: </strong><?php echo $_SESSION['dob'];?></td>
				                    </tr>
				                    <tr>
				                    	<td width="50%"><strong>Folder No: </strong><?php echo $folderno;?></td>
				                    	<td width="50%"><strong>Address: </strong><?php echo $_SESSION['address'];?></td>
									</tr>
				                    <tr>
				                    	<td width="50%"><strong>Gender: </strong><?php echo $row_gender['gender']?></td>
				                    	<td width="50%"><strong>Telephone: </strong><?php echo $_SESSION['telephone']?></td>
									</tr>
				                    <tr>
				            			<td width="50%"><strong>Blood Group: </strong><?php echo $_SESSION['BloodGroup'];?></td>
				            			<td width="50%"><strong>Emergency Contact: </strong><?php echo $_SESSION['relname']." - ".$_SESSION['reltelephone'];?></td>
				            		</tr>
			                    </table>
			                </td>
			            </tr>
		            </table>
		        </div>
		        <br>
				<div class="table-responsive" id="my_folder_table_main">
				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" id="my_folder_print" name="my_folder_print"class="btn btn-primary">Print</button>
			    <button type="button" id="my_folder_cancel" name="my_folder_cancel"class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>