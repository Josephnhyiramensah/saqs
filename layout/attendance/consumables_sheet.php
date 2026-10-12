<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');
    $query = "SELECT * FROM consumable_list WHERE attend_id='$attend_id' ORDER BY date DESC";
    $query_run = mysqli_query($con, $query);

if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Consumable_List'] == 'Yes')) 
	{
        echo '<form id="consumables_attend_form" method="POST">	
		<div class="form-row">
			<div class="col-md-6 mb-6">
				<label for="con_id">Consumable</label>
					<select class="form-control" name="con_id" id="con_id"> 
				    	<option value="0">Please Select</option>';
				        
				        	$sql="SELECT * FROM consumable ORDER BY consumable ASC";
							$result=mysqli_query($con,$sql);
				            while($row=mysqli_fetch_array($result))
				            {
					            echo '<option value = "'.$row['con_id'].'">
					                '.$row['consumable'].'
					            </option>';
				            }               
				        
				    echo '</select>
					<input type="hidden" name="con_list_id" class="form-control" id="con_list_id">
			</div>
			<div class="col-md-2 mb-2">
				<label for="consum_date">Date</label>
				<input type="date" name="consum_date" class="form-control" id="consum_date" value="'.$date.'">
			</div>
			<div class="col-md-1 mb-1">
				<label for="consum_qty">Qty</label>
				<input type="text" name="consum_qty" class="form-control" id="consum_qty">
			</div>
			<div class="col-md-3 mb-3">
				<label for="consum_warehouse">Location</label>
				<select class="form-control" name="consum_warehouse" id="consum_warehouse"> 
		    		<option value="0">Please Select</option>';
			        
			        	$sql="SELECT * FROM warehouse WHERE company_id = '".$_SESSION['company_id']."' ORDER BY warehouse_desc ASC";
						$result=mysqli_query($con,$sql);
			            while($row=mysqli_fetch_array($result))
			            {
			            	echo '<option value = "'.$row['warehouse_id'].'" >
			                '.$row['warehouse_desc'].'
			            </option>';
			            };
		    	echo '</select>
			</div>
		</div>';
			if (
				$_SESSION['user_type'] == 'Ultra_Super_User' OR 
				$_SESSION['user_type'] == 'Super_User' OR 
				($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
				{
		            echo'<div class="form-row">
				            <div class="col-md-6 mb-6">
							<label for="consum_sponsor">Sponsor</label>
								<select class="form-control" name="consum_sponsor" id="consum_sponsor"> 
							    	<option value="0">Please Select</option>';
							        
							        	$sponsor_option = set_sponsor_list();
							        	echo $sponsor_option;
							       
							    echo '</select>
							</div>
							<div class="col-md-3 mb-3">
								<label for="consum_price">Price</label>
								<input type="text" name="consum_price" class="form-control" id="consum_price">
							</div>
							<div class="col-md-3 mb-3">
								<label for="consum_amt">Estimated Lab Bill</label>
								<input type="hidden" name="consum_amt" class="form-control" id="consum_amt">
								<input type="text" name="consum_amt_2" class="form-control" id="consum_amt_2" disabled="true">
							</div>
					</div>';
				};
		echo'
		<div class="form-row">
			<div class="col-md-12 mb-12">
				<label for="consum_comment">Comment</label>
				<textarea type="textarea" rows="2"  class="form-control" name="consum_comment" id="consum_comment" value=""></textarea>
			</div>
		</div>
		
		<hr class="d-none d-md-block">
		<div id="consum_save_update">
			<button type="submit" name="consum_list_save_btn" id="consum_list_save_btn" class="btn btn-primary">Save</button>
		</div>
	</form>
	<hr class="d-none d-md-block">';
};
?>
<div class="table-responsive" id="attend_consumables_list_table">
    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="action-td">Date</th>
                <th class="action-td">Consumable</th>
                <th class="action-td">Qty</th>
            <?php
                if (
				$_SESSION['user_type'] == 'Ultra_Super_User' OR 
				$_SESSION['user_type'] == 'Super_User' OR 
				($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
				{
			        echo'<th class="action-td">Price</th>
	                <th class="action-td">Amount - Cash</th>
	                <th class="action-td">Amount - Disc.</th>
	                <th class="action-td">Amount - Prvt</th>
	                <th class="action-td">Amount - NHIS</th>';
	            };
            ?>
                <th class="action-td">Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">
            <?php
            		$total_cash=0;
                	$total_disc=0;
                	$total_prvt=0;
                	$total_nhis=0;
                if (mysqli_num_rows($query_run) > 0)
                {
                	$amt_cash=0;
                	$amt_disc=0;
                	$amt_prvt=0;
                	$amt_nhis=0;
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                    	$con_id = $row['con_id'];
                    	$query_con = "SELECT consumable FROM consumable WHERE con_id='$con_id'";
						$query_run_con = mysqli_query($con, $query_con);
						$row_con = mysqli_fetch_assoc($query_run_con);

						$ledger_id = $row['ledger_id'];
                    	$query_led = "SELECT ledger_desc FROM ledgers WHERE ledger_id='$ledger_id'";
						$query_run_led = mysqli_query($con, $query_led);
						$row_led = mysqli_fetch_assoc($query_run_led);

						$con_list_id = $row['con_list_id'];
						$query_disc = "SELECT SUM(amount) AS amount FROM discount WHERE con_list_id='$con_list_id'";
    					$query_run_disc = mysqli_query($con, $query_disc);
    					$row_disc = mysqli_fetch_assoc($query_run_disc);
    					if (isset($row_disc)) {
    						$amt_disc = $row_disc['amount'];
    					} else {
    						$amt_disc = 0;
    					};
            ?>

                <tr>
                	<td class="action-td"><?php echo $row['date'];?></td>
                	<td><?php echo $row_con['consumable'];?></td>
                    <td class="action-td"><?php echo $row['qty_issued'];?></td>
                <?php
                     if (
						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
						$_SESSION['user_type'] == 'Super_User' OR 
						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
						{
					        echo'
		                    <td class="amt-td">'.$row['price_cash'].'</td>
		                    <td class="amt-td">'.$row['amount_cash'].'</td>
		                    <td class="amt-td">'.$amt_disc.'</td>
		                    <td class="amt-td">'.$row['amount_prvt'].'</td>
		                    <td class="amt-td">'.$row['amount_nhis'].'</td>';
		                };
                	
                		$total_cash+=$row['amount_cash'];
                		$total_disc+=$amt_disc;
                		$total_prvt+=$row['amount_prvt'];
                		$total_nhis+=$row['amount_nhis'];
            		?>
                    <td class="action-td">
                    	<?php
                    		if (
	    						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
	    						$_SESSION['user_type'] == 'Super_User' OR 
	    						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Consumable_List'] == 'Yes')) 
							{
								echo'<a href="#" id="btn_consum_list_edit" 
	                				data-id12="'.$row['con_list_id'].'"
	                				data-id13="'.$row['con_id'].'">Edit</a>';
							};

	                    	if (
	    						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
	    						$_SESSION['user_type'] == 'Super_User' OR 
	    						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Discount'] == 'Yes')) 
							{
								echo ' | <a href="#" id="btn_discount_consum_list"
			                    		class="data-toggle="tooltip" data-placement="left" title="Discount Consumable"" 
										data-id="'.$row['attend_id'].'"
										data-id1="'.$_SESSION['patient_id'].'"
										data-id2="'.$row['con_list_id'].'"
										data-id3="'.$_SESSION['name'].'"
										data-id4="'.$row['amount_cash'].'"
										data-id5="'.$amt_disc.'"
									>
										Disc.
									</a>';
							};
	                    	if (
	    						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
	    						$_SESSION['user_type'] == 'Super_User' OR 
	    						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Consumable_List'] == 'Yes')) 
							{
								echo ' | <a href="#" id="btn_delete_consum_list" 
									data-id8="'.$row['con_list_id'].'"
		                			data-id9="'.$row['con_id'].'" 
		                			class="data-toggle="tooltip" data-placement="left" title="Delete Consumable""
								>
									Delete
								</a>';
							};
						?>
                    </td>
                </tr>
            <?php
                    }
            		if (
						$_SESSION['user_type'] == 'Ultra_Super_User' OR 
						$_SESSION['user_type'] == 'Super_User' OR 
						($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['View_Bill'] == 'Yes')) 
						{
					        echo'
			                <tr>
			                	<td class="action-td" colspan="4">TOTAL</td>
			                	<td class="amt-td"><?php echo $total_cash;?></td>
			                	<td class="amt-td"><?php echo $total_disc;?></td>
			                	<td class="amt-td"><?php echo $total_prvt;?></td>
			                	<td class="amt-td"><?php echo $total_nhis;?></td>
			                	<td></td>
			                </tr>';
			            }
                }
            ?>
        </tbody>
    </table>
</div>

<div 
	class="modal fade bd-example-modal-xl" 
	id="consumable_list_delete_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="consumable_list_delete_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="consumable_list_delete_modal_title">Consumable Deletion</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="consumable_list_delete_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="consum_list_delete_yes" name="consum_list_delete_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="consum_list_delete_no" name="consum_list_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>

<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/discount_create_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>