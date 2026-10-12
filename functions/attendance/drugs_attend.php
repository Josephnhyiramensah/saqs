<?php
    $query = "SELECT * FROM drug_list WHERE attend_id=$attend_id ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);
?>
<hr class="d-none d-md-block">
<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="headingFive">
		<h6 class="panel-title">
			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
				<h5 class="m-0 font-weight-bold text-primary">Prescription</h5>
			</a>
		</h6>
	</div>
	<div id="collapseFive" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFive">
		<div class="panel-body">
			<div class="form-row">
				<div class="col-md-6 mb-6">
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" data-toggle="" id="drug_add_icon"><i class="fas fa-prescription-bottle-alt fa-lg"></i> Add Medicine</a>
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" id="drug_history_icon"><i class="fa fa-history fa-lg"></i> Past Medicines</a>
				</div>
				<div class="col-md-2 mb-2">
					<a href="#" id="drug_prescription_icon"><i class="fas fa-file-prescription fa-lg"></i> Prescription</a>
				</div>
			</div>
			<div class="table-responsive" id="attend_drug_table">
			    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
			        <thead>
			            <tr>
			                <th>Date</th>
			                <th>Drug</th>
			                <th>Qty Presc.</th>
			                <th>Dosage</th>
			                <th>Action</th>
			                <th>Delete</th>
			            </tr>
			        </thead>
			        <tbody class="pv-table-body">
			            <?php
			                if (mysqli_num_rows($query_run) > 0)
			                {
			                    while($row=mysqli_fetch_assoc($query_run))
			                    {
			                    	$drug_id = $row['drug_id'];
			                    	$query_drug = "SELECT * FROM drugs WHERE drug_id=$drug_id";
    								$query_run_drug = mysqli_query($con, $query_drug);
    								$row_drug=mysqli_fetch_assoc($query_run_drug);
			            ?>
			                <tr>
			                    <td><a href="#" id="btn_edit_drug" data-id1="<?php echo $row['drug_list_id'];?>"><?php echo $row['date'];?></a></td>
			                    <td><?php echo $row_drug['brand_name'];?></td>
			                    <td><?php echo $row['qty_presc'];?></td>
			                    <td><?php echo $row['dosage'];?></td>
			                    <td>
									<a href="#" id="btn_disp_drug" data-id1="<?php echo $row['drug_list_id'];?>"><i class="fa fa-pills fa-sm"></i></a>
									 | 
									<a href="#" id="btn_admin_drug" data-id1="<?php echo $row['drug_list_id'];?>"><i class="fas fa-prescription-bottle"></i></a>
		                        </td>
		                        <td>
									<a href="#" id="btn_delete_drug" data-id2="<?php echo $row['drug_list_id'];?>"><i class="fa fa-trash fa-sm"></i></a>
		                        </td>
			                </tr>
			            <?php
			                    }
			                }
			                else
			                {
			                    echo 'No Record Found';
			                };
			            ?>
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-xl" id="drug_attend_modal" tabindex="-1" role="dialog" aria-labelledby="drug_attend_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="drug_attend_modal_title">Enter Medicine</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="drug_attend_form" method="POST">
				<div class="modal-body">
					<div class="panel-body">
						<div class="form-row">
							<div class="col-md-6 mb-6">
								<label for="drug">Drug Description</label>
								<select class="form-control" name="drug" id="drug"> 
						    		<option value="0">Please Select</option>
							        <?php
							        	$sql="SELECT * FROM drugs ORDER BY brand_name ASC";
										$result=mysqli_query($con,$sql);
							            while($row=mysqli_fetch_array($result))
							            {
							        ?>
							            <option value = "<?php echo($row['drug_id'])?>" >
							                <?php echo($row['brand_name']) ?>
							            </option>
							        <?php
							            }
							        ?>
						    	</select>
							</div>
							<div class="col-md-3 mb-3">
								<label for="dosage">Dosage</label>
								<input type="text" class="form-control" name="dosage" id="dosage">
							</div>
							<div class="col-md-1 mb-1">
								<label for="qty_presc">Qty</label>
								<input type="text" class="form-control" name="qty_presc" id="qty_presc">
							</div>
							<div class="col-md-1 mb-1">
								<label for="drugprice">Price</label>
								<input type="text" class="form-control" name="drugprice" id="drugprice">
							</div>
							<div class="col-md-1 mb-1">
								<label for="drugamt">Amount</label>
								<input type="text" class="form-control" name="drugamt" id="drugamt">
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12">
								<label for="drug_comment">Comment</label>
								<textarea type="textarea" rows="4"  class="form-control" name="drug_comment" id="drug_comment" value=""></textarea>
									<input type="hidden" name="drug_list_id" class="form-control" id="drug_list_id" value="">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				    <button type="submit" id="drug_save_btn" name="drug_save_btn" class="btn btn-primary">Save</button>
				    <button type="submit" id="drug_update_btn" name="drug_update_btn" class="btn btn-primary">Update</button>
				    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade bd-example-modal-xl" id="drug_history_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary">Medicine History</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive" id="attend_drug_history_table">
				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>