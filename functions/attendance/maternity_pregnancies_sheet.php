<?php
	include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
    $query = "SELECT * FROM pregnancies WHERE patient_id='$patient_id' ORDER BY delivery_date DESC";
    $query_run = mysqli_query($con, $query);
?>
<div class="form-row">
	<div class="col-md-2 mb-2">
		<div id="new_pregnancy_div">
			<button type="button" id="pregnancy_new_btn" class="btn btn-block btn-primary">Enter New Pregnancy</button>
		</div>
	</div>
	<div class="col-md-8 mb-8">
	</div>
	<div class="col-md-2 mb-2">
		<div id="old_pregnancy_div">
			<button type="button" id="pregnancy_previous_btn" class="btn btn-block btn-primary float-right">Enter Previous Pregnancy</button>
		</div>
	</div>
</div>
<hr class="d-none d-md-block">
<?php
	$query_gravida = "SELECT COUNT(preg_id) AS gravida FROM pregnancies WHERE patient_id='$patient_id'";
    $query_run_gravida = mysqli_query($con, $query_gravida);
    $row_gravida=mysqli_fetch_assoc($query_run_gravida);

    $query_para = "SELECT COUNT(preg_id) AS para FROM pregnancies WHERE patient_id='$patient_id' AND gestation_age > 23";
    $query_run_para = mysqli_query($con, $query_para);
    $row_para=mysqli_fetch_assoc($query_run_para);

    $query_abort = "SELECT COUNT(preg_id) AS abortions FROM pregnancies WHERE patient_id='$patient_id' AND method='ABORTION'";
    $query_run_abort = mysqli_query($con, $query_abort);
    $row_abort=mysqli_fetch_assoc($query_run_abort);

    $query_spont = "SELECT COUNT(preg_id) AS spontaneous FROM pregnancies WHERE patient_id='$patient_id' AND method='ABORTION' AND labour_type='Spontaneous'";
    $query_run_spont = mysqli_query($con, $query_spont);
    $row_spont=mysqli_fetch_assoc($query_run_spont);

    $query_induced = "SELECT COUNT(preg_id) AS induced FROM pregnancies WHERE patient_id='$patient_id' AND method='ABORTION' AND labour_type='induced'";
    $query_run_induced = mysqli_query($con, $query_induced);
    $row_induced=mysqli_fetch_assoc($query_run_induced);
?>
<div class="table-responsive" id="patient_pregnancy_table">
	<div class="form-row">
		<div class="col-md-3 mb-3">
			<label for="ps_gravida"><small>Gravida</small></label>
			<input type="text" class="form-control bg-light text-center" name="ps_gravida" id="ps_gravida" disabled="true" value="<?php echo $row_gravida['gravida'];?>">
		</div>
		<div class="col-md-3 mb-3">
			<label for="ps_para"><small>Para</small></label>
			<input type="text" class="form-control bg-light text-center" name="ps_para" id="ps_para" disabled="true" value="<?php echo $row_para['para'];?>">
		</div>
		<div class="col-md-2 mb-2">
			<label for="ps_abortions"><small>Abortions</small></label>
			<input type="text" class="form-control bg-light text-center" name="ps_abortions" id="ps_abortions" disabled="true" value="<?php echo $row_abort['abortions'];?>">
		</div>
		<div class="col-md-2 mb-2">
			<label for="ps_spontaneous"><small>Spontaneous</small></label>
			<input type="text" class="form-control bg-light text-center" name="ps_spontaneous" id="ps_spontaneous" disabled="true" value="<?php echo $row_spont['spontaneous'];?>">
		</div>
		<div class="col-md-2 mb-2">
			<label for="ps_induced"><small>Induced</small></label>
			<input type="text" class="form-control bg-light text-center" name="ps_induced" id="ps_induced" disabled="true" value="<?php echo $row_induced['induced'];?>">
		</div>
	</div>
	<hr class="d-none d-md-block">
    <table class="table table-hover table-bordered table-sm text-center" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>EDD</th>
                <th>LMP</th>
                <th>Delivery Date</th>
                <th>Delivery Method</th>
                <th>Labour Type</th>
                <th>Gestation Age</th>
                <th>Risk Factors</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">
            <?php
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
            ?>
		                <tr>
		                    <td><a href="#" id="btn_edit_preg" data-id="<?php echo $row['preg_id'];?>"><?php echo $row['EDD'];?></a></td>
		                    <td><?php echo $row['LMP'];?></td>
		                    <td><?php echo $row['delivery_date'];?></td>
		                    <td><?php echo $row['method'];?></td>
		                    <td><?php echo $row['labour_type'];?></td>
		                    <td><?php echo $row['gestation_age'];?></td>
		                    <td><?php echo $row['risk_factor'];?></td>
		                    <td>
		                    	<?php
		                    		if ($row['delivery_date'] == 0 || $row['delivery_date'] == "") 
		                    		{
										echo'<a href="#" id="preg_anc_sheet" data-id="'.$row['preg_id'].'">ANC</a> | 
											<a href="#" id="preg_delivery_sheet" data-id1="'.$row['preg_id'].'">DELIVERY</a> | 
											<a href="#" id="preg_pnc_sheet" data-id2="'.$row['preg_id'].'">PNC</a> | ';
		                    		};

									echo'<a href="#" id="preg_delete" data-id3="'.$row['preg_id'].'"><i class="fa fa-trash fa-sm"></i></a>';
								?>
		                    </td>
		                </tr>
            <?php
                    };
                }
                else
                {
                        echo 'No Pregnancies Found';
                };
            ?>
        </tbody>
    </table>
</div>

<div class="modal fade bd-example-modal-xl" id="pregnancy_modal" tabindex="-1" role="dialog" aria-labelledby="pregnancy_modal" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title m-0 font-weight-bold text-primary" id="pregnancy_modal_title">Pregnacy Setup</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
				<div class="modal-body">
					<form id="pregnancy_form" method="POST">
						<div id="new_pregnancy_details">
							<div class="form-row">
								<div class="col-md-2 mb-2">
									<label for="lmp"><small>LMP</small></label>
									<input type="date" class="form-control bg-light" name="lmp" id="lmp">
								</div>
								<div class="col-md-2 mb-2">
									<label for="edd"><small>EDD</small></label>
									<input type="date" class="form-control bg-light" name="edd" id="edd">
								</div>
								<div class="col-md-2 mb-2">
									<label for="risk_factors"><small>Risk Factors</small></label>
									<input type="text" class="form-control bg-light" name="risk_factors" id="risk_factors">
								</div>
								<div class="col-md-6 mb-6" id="preg_thru_div">
									<label for="preg_thru"><small>Pregnancy Through</small></label>
									<select class="form-control bg-light" name="preg_thru" id="preg_thru"> 
							    		<option value="0">Please Select</option>
										<option value="normal">Normal</option>
										<option value="ovulation_induction">Ovulation Induction</option>
										<option value="IUI">IUI</option>
										<option value="IVF">IVF</option>
										<option value="Others">Others</option>
							    	</select>
								</div>
								<div class="col-md-4 mb-4" id="preg_thru_specify_div" hidden="true">
									<label for="preg_thru_specify"><small>Specify (if Others)</small></label>
									<input type="text" class="form-control bg-light" name="preg_thru_specify" id="preg_thru_specify">
								</div>
							</div>
						</div>
						<div id="previous_pregnancy_details">
							<div class="form-row">
								<div class="col-md-2 mb-2">
									<label for="gestation_age"><small>Gestation Age (weeks)</small></label>
									<select class="form-control bg-light" name="gestation_age" id="gestation_age"> 
							    		<option value="0">Please Select</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
										<option value="32">32</option>
										<option value="33">33</option>
										<option value="34">34</option>
										<option value="35">35</option>
										<option value="36">36</option>
							    	</select>
								</div>
								<div class="col-md-2 mb-2">
									<label for="date_delivery"><small>Date of Delivery</small></label>
									<input type="date" class="form-control bg-light" name="date_delivery" id="date_delivery">
								</div>
								<div class="col-md-2 mb-2">
									<label for="method_delivery"><small>Method of Delivery</small></label>
									<select class="form-control bg-light" name="method_delivery" id="method_delivery"> 
							    		<option value="0">Please Select</option>
										<option value="CAESARIAN SECTION">CAESARIAN SECTION</option>
										<option value="FORCEPS">FORCEPS</option>
										<option value="NORMAL/SPONTANEOUS">NORMAL/SPONTANEOUS</option>
										<option value="VACCUM">VACCUM</option>
										<option value="ABORTION">ABORTION</option>
										<option value="OTHER">OTHER</option>
							    	</select>
								</div>
								<div class="col-md-2 mb-2">
									<label for="labour_type"><small>Labour Type</small></label>
									<select class="form-control bg-light" name="labour_type" id="labour_type"> 
							    		<option value="0">Please Select</option>
										<option value="Spontaneous">Spontaneous</option>
										<option value="Induced">Induced</option>
										<option value="Augumentation">Augumentation</option>
										<option value="Caesarian Section">Caesarian Section</option>
										<option value="Other">Other</option>
							    	</select>
								</div>
								<div class="col-md-2 mb-2">
									<label for="preg_outcome"><small>Outcome</small></label>
									<select class="form-control bg-light" name="preg_outcome" id="preg_outcome"> 
							    		<option value="0">Please Select</option>
										<option value="LIVE">LIVE</option>
										<option value="PREMATURE">PREMATURE</option>
										<option value="STILL">STILL</option>
							    	</select>
								</div>
								<div class="col-md-2 mb-2">
									<label for="preg_condition"><small>Condition</small></label>
									<select class="form-control bg-light" name="preg_condition" id="preg_condition"> 
							    		<option value="0">Please Select</option>
										<option value="ALIVE">ALIVE</option>
										<option value="COMMA">COMMA</option>
										<option value="DEAD">DEAD</option>
							    	</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-2 mb-2">
									<label for="gender_1"><small>Gender 1</small></label>
									<select class="form-control bg-light" name="gender_1" id="gender_1"> 
							    		<option value="0">Please Select</option>
								        <?php
								        	$sql="SELECT * FROM gender";
											$result=mysqli_query($con,$sql);
								            while($row=mysqli_fetch_array($result))
								            {
								        ?>
								            <option value = "<?php echo($row['gender_id'])?>" >
								                <?php echo($row['gender']) ?>
								            </option>
								        <?php
								            }
								        ?>
							    	</select>
								</div>
								<div class="col-md-2 mb-2">
									<label for="weight_1"><small>Weight 1</small></label>
									<input type="text" class="form-control bg-light" name="weight_1" id="weight_1">
								</div>
								<div class="col-md-2 mb-2">
									<label for="height_1"><small>Height 1</small></label>
									<input type="text" class="form-control bg-light" name="height_1" id="height_1">
								</div>
								<div class="col-md-1 mb-1">
									<label for="gender_2"><small>Gender 2</small></label>
									<select class="form-control bg-light" name="gender_2" id="gender_2"> 
							    		<option value="0">Please Select</option>
								        <?php
								        	$sql="SELECT * FROM gender";
											$result=mysqli_query($con,$sql);
								            while($row=mysqli_fetch_array($result))
								            {
								        ?>
								            <option value = "<?php echo($row['gender_id'])?>" >
								                <?php echo($row['gender']) ?>
								            </option>
								        <?php
								            }
								        ?>
							    	</select>
								</div>
								<div class="col-md-1 mb-1">
									<label for="weight_2"><small>Weight 2</small></label>
									<input type="text" class="form-control bg-light" name="weight_2" id="weight_2">
								</div>
								<div class="col-md-1 mb-1">
									<label for="height_2"><small>Height 2</small></label>
									<input type="text" class="form-control bg-light" name="height_2" id="height_2">
								</div>
								<div class="col-md-1 mb-1">
									<label for="gender_3"><small>Gender 3</small></label>
									<select class="form-control bg-light" name="gender_3" id="gender_3"> 
							    		<option value="0">Please Select</option>
								        <?php
								        	$sql="SELECT * FROM gender";
											$result=mysqli_query($con,$sql);
								            while($row=mysqli_fetch_array($result))
								            {
								        ?>
								            <option value = "<?php echo($row['gender_id'])?>" >
								                <?php echo($row['gender']) ?>
								            </option>
								        <?php
								            }
								        ?>
							    	</select>
								</div>
								<div class="col-md-1 mb-1">
									<label for="weight_3"><small>Weight 3</small></label>
									<input type="text" class="form-control bg-light" name="weight_3" id="weight_3">
								</div>
								<div class="col-md-1 mb-1">
									<label for="height_3"><small>Height 3</small></label>
									<input type="text" class="form-control bg-light" name="height_3" id="height_3">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-2 mb-2">
									<label for="indication"><small>Indication</small></label>
									<input type="text" class="form-control bg-light" name="indication" id="indication">
								</div>
								<div class="col-md-2 mb-2">
									<label for="preg_problem"><small>Pregnancy Problem</small></label>
									<select class="form-control bg-light" name="preg_problem" id="preg_problem"> 
							    		<option value="0">Please Select</option>
										<option value="PPH">PPH</option>
										<option value="ECLAMPSIA">ECLAMPSIA</option>
										<option value="Obstructed Labour">Obstructed Labour</option>
										<option value="Ruptured Uterus">Ruptured Uterus</option>
										<option value="PIH">PIH</option>
										<option value="Chorioamnionitis">Chorioamnionitis</option>
										<option value="PROM">PROM</option>
										<option value="NIL">NIL</option>
										<option value="OTHERS">OTHERS</option>
							    	</select>
								</div>
								<div class="col-md-2 mb-2">
									<label for="post_partum"><small>Post Partum</small></label>
									<select class="form-control bg-light" name="post_partum" id="post_partum"> 
							    		<option value="0">Please Select</option>
										<option value="COMPLICATED">COMPLICATED</option>
										<option value="UNCOMPLICATED">UNCOMPLICATED</option>
							    	</select>
								</div>
								<div class="col-md-6 mb-6">
									<label for="preg_comment"><small>Comment</small></label>
									<textarea type="textarea" rows="4"  class="form-control bg-light" name="preg_comment" id="preg_comment" value=""></textarea>
									<input type="hidden" name="pregnancy_id" class="form-control" id="pregnancy_id" value="">
								</div>
							</div>
						</div>

						<input type="hidden" class="form-control bg-light" name="pregnancy_type" id="pregnancy_type">
					</form>
				</div>
				<div class="modal-footer">
					<div id="pregnancy_save_update">
						<button type="submit" id="pregnancy_save_btn" name="pregnancy_save_btn" class="btn btn-primary">Save</button>
					</div>
						<button type="button" id="pregnancy_cancel_btn" name="pregnancy_cancel_btn" class="btn btn-secondary">Cancel</button>
				</div>
		</div>
	</div>
</div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>