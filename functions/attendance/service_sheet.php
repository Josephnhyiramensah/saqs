<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');

if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Service_List'] == 'Yes')) 
{
  	echo '<form id="service_sheet_form" method="POST">
	<div class="form-row">
		<div class="col-md-4 mb-4">
			<label for="service_id_select">Service Description</label>
			<input type="hidden" class="form-control" name="service_list_id" id="service_list_id">
			<input type="hidden" class="form-control" name="ledger_id" id="ledger_id">
			<input type="hidden" class="form-control" name="service_id_old" id="service_id_old">
			<select class="form-control" name="service_id" id="service_id"> 
		    	<option value="0">Please Select</option>';
		        
		        	$sql="SELECT * FROM services ORDER BY service ASC";
					$result_service = mysqli_query($con,$sql);
		            while($row_service = mysqli_fetch_array($result_service))
		            {
		            	echo '<option value = "'.$row_service['service_id'].'" >
			                '.$row_service['service'].'
			            </option>';
		            
		            };
		        
		    echo '</select>
		</div>
		<div class="col-md-2 mb-2">
			<label for="service_date">Date</label>
			<input type="hidden" class="form-control" name="service_doctor" id="service_doctor">
			<input type="date" class="form-control" name="service_date" id="service_date">
		</div>
		<div class="col-md-3 mb-3">
			<label for="service_sponsor_select">Sponsor</label>
			<select class="form-control" name="service_sponsor" id="service_sponsor"> 
		    	<option value="0">Please Select</option>';
		        
		        	$sponsor_option = set_sponsor_list();
		        	echo $sponsor_option;
		        
		    echo '</select>
		</div>
		<div class="col-md-1 mb-1">
			<label for="service_qty">Qty</label>
			<input type="text" class="form-control" name="service_qty" id="service_qty" value="1">
			<input type="hidden" class="form-control" name="service_gdrg" id="service_gdrg">
		</div>
		<div class="col-md-1 mb-1">
			<label for="service_price_cash">Price</label>
			<input type="text" class="form-control" name="service_price_cash" id="service_price_cash" hidden="false">
			<input type="text" class="form-control" name="service_price_prvt" id="service_price_prvt" hidden="true">
			<input type="text" class="form-control" name="service_price_nhis" id="service_price_nhis" hidden="true">
		</div>
		<div class="col-md-1 mb-1">
			<label for="service_amt_cash">Amount</label>
			<input type="text" class="form-control" name="service_amt_cash" id="service_amt_cash" hidden="false">
			<input type="text" class="form-control" name="service_amt_prvt" id="service_amt_prvt" hidden="true">
			<input type="text" class="form-control" name="service_amt_nhis" id="service_amt_nhis" hidden="true">
		</div>
	</div>
	<div class="form-row">
		<div class="col-md-12 mb-12">
			<label for="service_comment">Comment</label>
			<textarea type="textarea" rows="2"  class="form-control" name="service_comment" id="service_comment"></textarea>
		</div>
	</div>
	<hr class="d-none d-md-block">
	<div id="service_save_update">
		<button type="submit" id="service_sheet_save_btn" name="service_sheet_save_btn" class="btn btn-primary">Save</button>
	</div>
</form>	
<hr class="d-none d-md-block">';
};
?>

<div class="table-responsive" id="attend_service_sheet_table">
    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="action-td">Date</th>
                <th class="action-td">Service</th>
                <th class="action-td">Sponsor</th>
                <th class="action-td">Qty</th>
                <th class="action-td">Price</th>
                <th class="action-td">Amount - Cash</th>
                <th class="action-td">Amount - Disc</th>
                <th class="action-td">Amount - Prvt</th>
                <th class="action-td">Amount - NHIS</th>
                <th class="action-td">Action</th>
            </tr>
        </thead>
        <tbody class="pv-table-body">
            <?php
            	$total_cash=0;
            	$total_disc=0;
            	$total_prvt=0;
            	$total_nhis=0;

    			$query = "SELECT * FROM service_list WHERE attend_id='$attend_id' ORDER BY date DESC";
    			$query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                	$amt_cash=0;
                	$amt_disc=0;
                	$amt_prvt=0;
                	$amt_nhis=0;
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                    	$service_id = $row['service_id'];
                    	$query_serv = "SELECT * FROM services WHERE service_id=$service_id";
						$query_run_serv = mysqli_query($con, $query_serv);
						$row_serv=mysqli_fetch_assoc($query_run_serv);

                    	$ledger_id = $row['ledger_id'];
						$query_led = "SELECT * FROM ledgers WHERE ledger_id='$ledger_id'";
						$query_run_led = mysqli_query($con, $query_led);
						$row_led=mysqli_fetch_assoc($query_run_led);

						$service_list_id = $row['service_list_id'];
						$query_disc = "SELECT SUM(amount) AS amount FROM discount WHERE service_list_id='$service_list_id'";
    					$query_run_disc = mysqli_query($con, $query_disc);
    					$row_disc = mysqli_fetch_assoc($query_run_disc);
    					if (isset($row_disc)) {
    						$amt_disc = $row_disc['amount'];
    					} else {
    						$amt_disc = 0;
    					};

						$total_cash+=$row['amount_cash'];
						$total_disc+=$amt_disc;
						$total_prvt+=$row['amount_prvt'];
						$total_nhis+=$row['amount_nhis'];
            ?>
                <tr>
                    <td>
                    <?php
                    	if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Edit_Service_List'] == 'Yes')) 
						{
						  	echo '<a href="#" id="btn_edit_service_list" data-id1="'.$row['service_list_id'].'">'.$row['date'].'</a>';
                    	}else
                    	{
                    		echo $row['date'];
                    	};
                    ?>
                    </td>
                    <td><?php echo $row_serv['service'];?></td>
                    <td><?php echo $row_led['ledger_desc'];?></td>
                    <td class="action-td"><?php echo $row['qty'];?></td>
                    <td class="amt-td"><?php echo $row['price_cash'];?></td>
                    <td class="amt-td"><?php echo $row['amount_cash'];?></td>
                    <td class="amt-td"><?php echo $amt_disc;?></td>
                    <td class="amt-td"><?php echo $row['amount_prvt'];?></td>
                    <td class="amt-td"><?php echo $row['amount_nhis'];?></td>
                    <td class="action-td">
                    	<?php
                    	if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Create_Discount'] == 'Yes')) 
						{
						  	echo '<a href="#" 
								id="btn_discount_service_list" 
								data-id="'.$row['attend_id'].'"
								data-id1="'.$_SESSION['patient_id'].'"
								data-id2="'.$row['service_list_id'].'"
								data-id3="'.$_SESSION['name'].'"
								data-id4="'.$row['amount_cash'].'"
								data-id5="'.$amt_disc.'"
								>Disc.
							</a>';
                    	};
						
                    	if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['Delete_Service_List'] == 'Yes')) 
						{
						  	echo ' | 
								<a href="#" id="btn_delete_service_list" data-id2="'.$row['service_list_id'].'"><i class="fa fa-trash fa-sm"></i></a>';
                    	};

                    ?>
                    </td>
                </tr>
            <?php
                    }
            ?>
        		<tr>
	            	<td class="action-td" colspan="5">TOTAL</td>
	            	<td class="amt-td"><?php echo $total_cash;?></td>
	            	<td class="amt-td"><?php echo $total_disc;?></td>
	            	<td class="amt-td"><?php echo $total_prvt;?></td>
	            	<td class="amt-td"><?php echo $total_nhis;?></td>
	            	<td></td>
                </tr>
            <?php
                };
            ?>
        </tbody>
    </table>
</div>
<div 
	class="modal fade bd-example-modal-xl" 
	id="service_delete_modal" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="service_delete_modal" 
	aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h5 class="modal-title" id="service_delete_modal_title">Service Deletion</h5>
	    	</div>
			<form action="#" method="POST">
			    <div class="modal-body">
					<p id="service_delete_question"></p>
				</div>
			    <div class="modal-footer">
			        <button type="button" id="service_delete_yes" name="service_delete_yes" class="btn btn-danger">Yes</button>
			        <button type="button" id="service_delete_no" name="service_delete_no" class="btn btn-primary" data-dismiss="modal">No</button>
			    </div>
			</form>
	    </div>
	</div>
</div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/layout/vouchers/discount_create_modal.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>