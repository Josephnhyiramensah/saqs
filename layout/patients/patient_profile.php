<form action="">
	<div class="form-row">
		<!--<div class="col-md-2 mb-2 text-center">
			<div class="card shadow md-4">
				<div class="card-body">
					<img src="/img/patients/patient_image.jpg" class="img-responsive img-thumbnail" />
					<input type="hidden" name="size" value="1000000">
				</div>
			</div>
		</div>
		<div class="col-md-2 mb-2">
			<?php echo'<p><small>Patient ID:</small>'.$patient_id.'</p>';?>
			<?php echo'<p><small>Folder No:</small>'.$folderno.'</p>';?>
			<?php echo'<p><small>Age:</small>'.$age.'</p>';?>
			<?php echo'<p><small>Sex:</small>'.$gender.'</p>';?>
		</div>-->
		<div class="col-md-12 mb-12">
    		<div class="form-row">
				<div class="col-md-3 mb-3">
					<label for="attend_id"><u>Attendance ID</u></label>
					<?php
						/*$sql="SELECT attend_id FROM attendance WHERE attend_id = $attend_id";
						$result=mysqli_query($con,$sql);
						$rs=mysqli_fetch_array($result);
						if ($rs) {
							$vn=$rs['attend_id'];
						}*/
						echo'<input type="text" name="attend_no" id="attend_no" class="form-control" disabled value="'.str_pad($attend_id,7,"0",STR_PAD_LEFT).'">
						<input type="hidden" name="attend_id" id="attend_id" class="form-control" disabled value="'.$attend_id.'">';
					?>
				</div>
				<div class="col-md-3 mb-3">
					<label for="typeofservice"><u>Type Of Service</u></label>
					<select class="form-control" name="typeofservice" id="typeofservice"> 
				    <option value="0">Please Select</option>
				        <?php
				        	$sql="SELECT * FROM type_of_service ORDER BY description DESC";
							$result=mysqli_query($con,$sql);
				            while($row=mysqli_fetch_array($result))
				            {
				            ?>
				            <option value = "<?php echo($row['tos_id'])?>" >
				                <?php echo($row['description']) ?>
				            </option>
				            <?php
				            }               
				        ?>
				    </select>
				</div>
				<div class="col-md-3 mb-3">
					<label for="dateofadmission"><u>Date Of Admission</u></label>
					<input type="date" class="form-control" name="dateofadmission" id="dateofadmission" value="<?echo date('m/d/Y');?>">
				</div>
				<div class="col-md-3 mb-3">
					<label for="dateofdischarge"><u>Date Of Discharge</u></label>
					<input type="date" class="form-control" name="dateofdischarge" id="dateofdischarge">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-4 mb-4">
					<label for="paymenttype"><u>Payment Type</u></label>
					<input type="text" class="form-control" name="paymenttype" id="paymenttype">
					<input type="hidden" class="form-control" name="paymenttypeid" id="paymenttypeid">
				</div>
				<div class="col-md-2 mb-2">
					<label for="daysbill"><u>Cash Bill</u></label>
					<input type="text" class="form-control" name="cashbill" id="cashbill">
				</div>
				<div class="col-md-2 mb-2">
					<label for="acbal"><u>Account Balance</u></label>
					<input type="text" class="form-control" name="acbal" id="acbal">
				</div>
				<div class="col-md-2 mb-2">
					<label for="prvtinsbill"><u>Private Ins. Bill</u></label>
					<input type="text" class="form-control" name="prvtinsbill" id="prvtinsbill">
				</div>
				<div class="col-md-2 mb-2">
					<label for="nhisbill"><u>NHIS Bill</u></label>
					<input type="text" class="form-control" name="nhisbill" id="nhisbill">
				</div>
			</div>
			<div class="form-row">
				
				<div class="col-md-4 mb-4">
					<label for="ward"><u>Clinic</u></label>
					<input type="text" class="form-control" name="clinic" id="clinic">
					<input type="hidden" class="form-control" name="clinicid" id="clinicid">
				</div>
				<div class="col-md-4 mb-4">
					<label for="ward"><u>Ward</u></label>
					<input type="text" class="form-control" name="ward" id="ward">
					<input type="hidden" class="form-control" name="wardid" id="wardid">
				</div>
				<div class="col-md-2 mb-2">
					<label for="bed"><u>Bed</u></label>
					<input type="text" class="form-control" name="bed" id="bed">
					<input type="hidden" class="form-control" name="bedid" id="bedid">
				</div>
				<div class="col-md-2 mb-2">
					<label for="ccc"><u>CCC</u></label>
					<input type="text" class="form-control" name="ccc" id="ccc">
				</div>
			</div>
		</div>
	</div>
</form>