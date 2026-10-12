<?php
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/navbar_consulting.php');

    date_default_timezone_set("Africa/Accra");
    $date = date('Y-m-d');
    $date_today = date('Y-m-d');
    $time = date('H:i:s');
	$date_amit = $_SESSION['dateofadmission_attd'];
	$dob = $_SESSION['dob'];
	//AGE
		$ts1 = strtotime($dob);
		$ts2 = strtotime($date_amit);
		
		$year1 = date('Y', $ts1);
		$year2 = date('Y', $ts2);
		$years = $year2 - $year1;
		
		$month1 = date('m', $ts1);
		$month2 = date('m', $ts2);
		$months = $month2 - $month1;

		if($years > 0)
		{
			$age = ($year2 - $year1).' years';
		}
		else
		{
			$age = ($month2 - $month1).' months';
		};
    
	if(isset($_SESSION['company_id'])){$company_id = $_SESSION['company_id'];}else{$company_id='N/A';};
	if(isset($_SESSION['attend_id'])){$attend_id = $_SESSION['attend_id'];}else{$attend_id='N/A';};
	if(isset($_SESSION['patient_id'])){$patient_id = $_SESSION['patient_id'];}else{$patient_id='N/A';};
	if(isset($_SESSION['folderno'])){$folderno = $_SESSION['folderno'];}else{$folderno='N/A';};
	if(isset($_SESSION['name'])){$name = $_SESSION['name'];}else{$name='N/A';};
	//if(isset($_SESSION['age'])){$age = $_SESSION['age'];}else{$age='N/A';};
	if(isset($_SESSION['gender'])){$gender = $_SESSION['gender'];}else{$gender='N/A';};
	if(isset($_SESSION['Schname'])){$Schname = $_SESSION['Schname'];}else{$Schname='N/A';};
	if(isset($_SESSION['nhismemberno'])){$nhismemberno = $_SESSION['nhismemberno'];}else{$nhismemberno='N/A';};
	if(isset($_SESSION['nhisexpirydate'])){$nhisexpirydate = $_SESSION['nhisexpirydate'];}else{$nhisexpirydate='N/A';};
	if(isset($_SESSION['serial_no'])){$serial_no = $_SESSION['serial_no'];}else{$serial_no='N/A';};
	if(isset($_SESSION['ghanacard'])){$ghanacard = $_SESSION['ghanacard'];}else{$ghanacard='N/A';};
	if(isset($_SESSION['prtinsname'])){$prtinsname = $_SESSION['prtinsname'];}else{$prtinsname='N/A';};
	if(isset($_SESSION['prtmemberno'])){$prtmemberno = $_SESSION['prtmemberno'];}else{$prtmemberno='N/A';};
	if(isset($_SESSION['prtexpirydate'])){$prtexpirydate = $_SESSION['prtexpirydate'];}else{$prtexpirydate='N/A';};
	if(isset($_SESSION['sponsor'])){$sponsor_attd = $_SESSION['sponsor'];}else{$sponsor_attd='N/A';};
	if(isset($_SESSION['clinic'])){$clinic = $_SESSION['clinic'];}else{$clinic='N/A';};
	if(isset($_SESSION['typeofservice_attd'])){$typeofservice_attd = $_SESSION['typeofservice_attd'];}else{$typeofservice_attd='N/A';};
	if(isset($_SESSION['dateofadmission_attd'])){$dateofadmission_attd = $_SESSION['dateofadmission_attd'];}else{$dateofadmission_attd='N/A';};
	if(isset($_SESSION['dateofdischarge_attd'])){$dateofdischarge_attd = $_SESSION['dateofdischarge_attd'];}else{$dateofdischarge_attd='N/A';};
	if(isset($_SESSION['receipt_id'])){$receipt_id = $_SESSION['receipt_id'];}else{$receipt_id='N/A';};
	if(isset($_SESSION['receipt_id'])){$receipt_id = $_SESSION['receipt_id'];}else{$receipt_id='N/A';};
	if(isset($_SESSION['search_clinic'])){$search_clinic = $_SESSION['search_clinic'];}else{$search_clinic='N/A';};
	if(isset($_SESSION['search_from'])){$search_from = $_SESSION['search_from'];}else{$search_from='N/A';};
	if(isset($_SESSION['search_to'])){$search_to = $_SESSION['search_to'];}else{$search_to='N/A';};
	if(isset($_SESSION['page'])){$page = $_SESSION['page'];}else{$page='N/A';};
	if(isset($_SESSION['remember_state'])){$remember_state = $_SESSION['remember_state'];}else{$remember_state='N/A';};
	if(isset($_SESSION['preg_id'])){$preg_id = $_SESSION['preg_id'];}else{$preg_id='N/A';};
	if(isset($_SESSION['delivery_state'])){$delivery_state = $_SESSION['delivery_state'];}else{$delivery_state='N/A';};
	if(isset($_SESSION['delivery_id'])){$delivery_id = $_SESSION['delivery_id'];}else{$delivery_id='N/A';};
	if(isset($_SESSION['gravida'])){$gravida = $_SESSION['gravida'];}else{$gravida='N/A';};
	if(isset($_SESSION['para'])){$para = $_SESSION['para'];}else{$para='N/A';};
	if(isset($_SESSION['abortions'])){$abortions = $_SESSION['abortions'];}else{$abortions='N/A';};
	if(isset($_SESSION['induced'])){$induced = $_SESSION['induced'];}else{$induced='N/A';};
	if(isset($_SESSION['spontaneous'])){$spontaneous = $_SESSION['spontaneous'];}else{$spontaneous='N/A';};
	if(isset($_SESSION['LMP'])){$LMP = $_SESSION['LMP'];}else{$LMP='N/A';};
	if(isset($_SESSION['EDD'])){$EDD = $_SESSION['EDD'];}else{$EDD='N/A';};
	if(isset($_SESSION['BloodGroup'])){$BloodGroup = $_SESSION['BloodGroup'];}else{$BloodGroup='N/A';};
	if(isset($_SESSION['sickling'])){$sickling = $_SESSION['sickling'];}else{$sickling='N/A';};
	if(isset($_SESSION['geno_type'])){$geno_type = $_SESSION['geno_type'];}else{$geno_type='N/A';};
	if(isset($_SESSION['full_name'])){$full_name = $_SESSION['full_name'];}else{$full_name='N/A';};
	if(isset($_SESSION['date_review'])){$date_review = $_SESSION['date_review'];}else{$date_review='';};
	if(isset($_SESSION['user_type_id'])){$user_type_id = $_SESSION['user_type_id'];}else{$user_type_id='';};
	
	$sql_sponsor="SELECT * FROM ledgers WHERE ledger_id='$sponsor_attd'";
	$result_sponsor = mysqli_query($con,$sql_sponsor);
	$row_sponsor = mysqli_fetch_array($result_sponsor);
	$sponsor_desc = $row_sponsor['ledger_desc'];

	$sql_tos="SELECT * FROM type_of_service WHERE tos_id='$typeofservice_attd'";
	$result_tos=mysqli_query($con,$sql_tos);
	$row_tos=mysqli_fetch_array($result_tos);
	$tos_desc = $row_tos['description'];

	$sql_clinic="SELECT * FROM clinics WHERE  clinic_id='$clinic'";
	$result_clinic=mysqli_query($con,$sql_clinic);
	$row_clinic=mysqli_fetch_array($result_clinic);
	if(isset($row_clinic)){$clinic_desc = $row_clinic['clinic_desc'];}else{$clinic_desc = 'WALK-IN';};
	//$clinic_desc = $row_clinic['clinic_desc'];
		
		$attend_id = $_SESSION['attend_id'];
		$principal_sponsor = "";

		$query_principal_sponsor = "SELECT * FROM payment_type WHERE attend_id='$attend_id'
		AND principal='Yes'";
		$query_run_principal_sponsor = mysqli_query($con, $query_principal_sponsor);
		$row_principal_sponsor = mysqli_fetch_array($query_run_principal_sponsor);
		$principal_sponsor = $row_principal_sponsor['ledger_id'];
		$_SESSION['principal_sponsor'] = $row_principal_sponsor['ledger_id'];
		
	function set_sponsor_list()
	{
		global $con;
		$attend_id = $_SESSION['attend_id'];
		$sponsor_option = "";

		$query_sponsor = "SELECT * FROM payment_type WHERE attend_id='$attend_id'";
		$query_run_sponsor = mysqli_query($con, $query_sponsor);
		while($row_sponsor=mysqli_fetch_array($query_run_sponsor))
		{
			$sponsor_id = $row_sponsor['ledger_id'];
			$sql="SELECT * FROM ledgers WHERE ledger_id='$sponsor_id'";
			$result=mysqli_query($con,$sql);
			$row_led = mysqli_fetch_array($result);
			if ($row_sponsor['principal'] == 'Yes') 
			{
				$sponsor_option.='<option value = "'.$row_sponsor['ledger_id'].'" selected="selected">'.$row_led['ledger_desc'].'</option>';
			} 
			else 
			{
				$sponsor_option.='<option value = "'.$row_sponsor['ledger_id'].'">'.$row_led['ledger_desc'].'</option>';
			};
		};
		return $sponsor_option;
	};

	//OTHER BALANCE
		$query_service_other = "SELECT SUM(amount_cash) AS service_bill FROM service_list WHERE attend_id !='$attend_id' AND patient_id='$patient_id'";
		$query_run_service_other = mysqli_query($con, $query_service_other);
		$row_service_other = mysqli_fetch_assoc($query_run_service_other);
		$bill_service_other = $row_service_other['service_bill'];

		$query_lab_other = "SELECT SUM(amount_cash) AS lab_bill FROM lab_list WHERE attend_id !='$attend_id' AND patient_id='$patient_id'";
		$query_run_lab_other = mysqli_query($con, $query_lab_other);
		$row_lab_other = mysqli_fetch_assoc($query_run_lab_other);
		$bill_labs_other = $row_lab_other['lab_bill'];

		$query_radio_other = "SELECT SUM(amount_cash) AS radio_bill FROM radio_list WHERE attend_id !='$attend_id' AND patient_id='$patient_id'";
		$query_run_radio_other = mysqli_query($con, $query_radio_other);
		$row_radio_other = mysqli_fetch_assoc($query_run_radio_other);
		$bill_radio_other = $row_radio_other['radio_bill'];
		
		$query_drug_other = "SELECT SUM(amount_cash) AS drug_bill FROM drug_list WHERE attend_id !='$attend_id' AND patient_id='$patient_id'";
		$query_run_drug_other = mysqli_query($con, $query_drug_other);
		$row_drug_other = mysqli_fetch_assoc($query_run_drug_other);
		$bill_drugs_other = $row_drug_other['drug_bill'];

		$query_pdr_other = "SELECT SUM(amount) AS pdr_amount FROM drug_patient_returns WHERE attend_id ='$attend_id' AND patient_id='$patient_id'";
		$query_run_pdr_other = mysqli_query($con, $query_pdr_other);
		$row_pdr_other = mysqli_fetch_assoc($query_run_pdr_other);
		$pdr_amount_other = $row_pdr_other['pdr_amount'];
		
		$query_surgery_other = "SELECT SUM(amount_cash) AS surgery_bill FROM surgery_list WHERE attend_id !='$attend_id' AND patient_id='$patient_id'";
		$query_run_surgery_other = mysqli_query($con, $query_surgery_other);
		$row_surgery_other = mysqli_fetch_assoc($query_run_surgery_other);
		$bill_surgery_other = $row_surgery_other['surgery_bill'];
		
		$query_consum_other = "SELECT SUM(amount_cash) AS consum_bill FROM consumable_list WHERE attend_id !='$attend_id' AND patient_id='$patient_id'";
		$query_run_consum_other = mysqli_query($con, $query_consum_other);
		$row_consum_other = mysqli_fetch_assoc($query_run_consum_other);
		$bill_consum_other = $row_consum_other['consum_bill'];
		
		$total_bill_other = $row_service_other['service_bill'] +
		$row_lab_other['lab_bill'] +
		$row_radio_other['radio_bill'] +
		$row_drug_other['drug_bill'] +
		$row_surgery_other['surgery_bill'] +
		$row_consum_other['consum_bill'] -
		$row_pdr_other['pdr_amount'];

		$bill_total_other = $row_service_other['service_bill'] +
		$row_lab_other['lab_bill'] +
		$row_radio_other['radio_bill'] +
		$row_drug_other['drug_bill'] +
		$row_surgery_other['surgery_bill'] +
		$row_consum_other['consum_bill'] -
		$row_pdr_other['pdr_amount'];
		
		$query_discount_other = "SELECT SUM(amount) AS amount_discount FROM discount WHERE attend_id !='$attend_id' AND patient_id='$patient_id'";
		$query_run_discount_other = mysqli_query($con, $query_discount_other);
		$row_discount_other = mysqli_fetch_assoc($query_run_discount_other);
		$discount_total_other = $row_discount_other['amount_discount'];
		
		$query_receipt_other = "SELECT SUM(amount) AS amount_rec FROM receipt WHERE attend_id !='$attend_id' AND patient_id='$patient_id'";
		$query_run_receipt_other = mysqli_query($con, $query_receipt_other);
		$row_receipt_other = mysqli_fetch_assoc($query_run_receipt_other);
		$receipt_total_other = $row_receipt_other['amount_rec'];
		
		$query_refund_other = "SELECT SUM(amount) AS amount_refund FROM refund WHERE attend_id !='$attend_id' AND patient_id='$patient_id'";
		$query_run_refund_other = mysqli_query($con, $query_refund_other);
		$row_refund_other = mysqli_fetch_assoc($query_run_refund_other);
		$refund_total_other = $row_refund_other['amount_refund'];

		$grand_total_other = $total_bill_other - $row_discount_other['amount_discount'] - $row_receipt_other['amount_rec'] + $row_refund_other['amount_refund'];
		$grand_total_other_f = number_format($grand_total_other, 2, '.', ',');

	//CURRENT BALANCE
		$query_service = "SELECT SUM(amount_cash) AS service_bill FROM service_list WHERE attend_id ='$attend_id'";
		$query_run_service = mysqli_query($con, $query_service);
		$row_service=mysqli_fetch_assoc($query_run_service);
		$bill_service = $row_service['service_bill'];

		$query_lab = "SELECT SUM(amount_cash) AS lab_bill FROM lab_list WHERE attend_id ='$attend_id'";
		$query_run_lab = mysqli_query($con, $query_lab);
		$row_lab=mysqli_fetch_assoc($query_run_lab);
		$bill_labs = $row_lab['lab_bill'];

		$query_radio = "SELECT SUM(amount_cash) AS radio_bill FROM radio_list WHERE attend_id ='$attend_id'";
		$query_run_radio = mysqli_query($con, $query_radio);
		$row_radio=mysqli_fetch_assoc($query_run_radio);
		$bill_radio = $row_radio['radio_bill'];
		
		$query_drug = "SELECT SUM(amount_cash) AS drug_bill FROM drug_list WHERE attend_id ='$attend_id'";
		$query_run_drug = mysqli_query($con, $query_drug);
		$row_drug=mysqli_fetch_assoc($query_run_drug);
		$bill_drugs = $row_drug['drug_bill'];

		$query_pdr = "SELECT SUM(amount) AS pdr_amount FROM drug_patient_returns WHERE attend_id ='$attend_id'";
		$query_run_pdr = mysqli_query($con, $query_pdr);
		$row_pdr = mysqli_fetch_assoc($query_run_pdr);
		$pdr_amount = $row_pdr['pdr_amount'];
		
		$query_surgery = "SELECT SUM(amount_cash) AS surgery_bill FROM surgery_list WHERE attend_id='$attend_id'";
		$query_run_surgery = mysqli_query($con, $query_surgery);
		$row_surgery=mysqli_fetch_assoc($query_run_surgery);
		$bill_surgery = $row_surgery['surgery_bill'];
		
		$query_consum = "SELECT SUM(amount_cash) AS consum_bill FROM consumable_list WHERE attend_id='$attend_id'";
		$query_run_consum = mysqli_query($con, $query_consum);
		$row_consum=mysqli_fetch_assoc($query_run_consum);
		$bill_consum = $row_consum['consum_bill'];
		
		$total_bill = $row_service['service_bill'] +
		$row_lab['lab_bill'] +
		$row_radio['radio_bill'] +
		$row_drug['drug_bill'] +
		$row_surgery['surgery_bill'] +
		$row_consum['consum_bill'] -
		$row_pdr['pdr_amount'];

		$bill_total = $row_service['service_bill'] +
		$row_lab['lab_bill'] +
		$row_radio['radio_bill'] +
		$row_drug['drug_bill'] +
		$row_surgery['surgery_bill'] +
		$row_consum['consum_bill'] -
		$row_pdr['pdr_amount'];
		
		$query_discount = "SELECT SUM(amount) AS amount_discount FROM discount WHERE attend_id='$attend_id'";
		$query_run_discount = mysqli_query($con, $query_discount);
		$row_discount=mysqli_fetch_assoc($query_run_discount);
		$discount_total = $row_discount['amount_discount'];
		
		$query_receipt = "SELECT SUM(amount) AS amount_rec FROM receipt WHERE attend_id='$attend_id'";
		$query_run_receipt = mysqli_query($con, $query_receipt);
		$row_receipt=mysqli_fetch_assoc($query_run_receipt);
		$receipt_total = $row_receipt['amount_rec'];
		
		$query_refund = "SELECT SUM(amount) AS amount_refund FROM refund WHERE attend_id='$attend_id'";
		$query_run_refund = mysqli_query($con, $query_refund);
		$row_refund=mysqli_fetch_assoc($query_run_refund);
		$refund_total = $row_refund['amount_refund'];

		$grand_total = $total_bill - $row_discount['amount_discount'] - $row_receipt['amount_rec'] + $row_refund['amount_refund'];
		$grand_total_f = number_format($grand_total, 2, '.', ',');
	
	$patient_total_balance = $grand_total + $grand_total_other;
	$patient_total_balance_f = number_format($patient_total_balance, 2, '.', ',');
?>
<input type='hidden' id='patient_total_balance' value="<?php echo $patient_total_balance;?>">
<input type='hidden' id='session_receipt_id' value="<?php echo $receipt_id;?>">
<input type='hidden' id='session_search_clinic' value="<?php echo $search_clinic;?>">
<input type='hidden' id='session_search_from' value="<?php echo $search_from;?>">
<input type='hidden' id='session_search_to' value="<?php echo $search_to;?>">
<input type='hidden' id='session_page' value="<?php echo $page;?>">
<input type='hidden' id='session_remember_state' value="<?php echo $remember_state;?>">
<input type='hidden' id='session_preg_id' value="<?php echo $preg_id;?>">
<input type='hidden' id='session_delivery_state' value="<?php echo $delivery_state;?>">
<input type='hidden' id='session_delivery_id' value="<?php echo $delivery_id;?>">
<input type='hidden' id='session_gravida' value="<?php echo $gravida;?>">
<input type='hidden' id='session_para' value="<?php echo $para;?>">
<input type='hidden' id='session_abortions' value="<?php echo $abortions;?>">
<input type='hidden' id='session_induced' value="<?php echo $induced;?>">
<input type='hidden' id='session_spontaneous' value="<?php echo $spontaneous;?>">
<input type='hidden' id='session_LMP' value="<?php echo $LMP;?>">
<input type='hidden' id='session_EDD' value="<?php echo $EDD;?>">
<input type='hidden' id='session_BloodGroup' value="<?php echo $BloodGroup;?>">
<input type='hidden' id='session_sickling' value="<?php echo $sickling;?>">
<input type='hidden' id='session_geno_type' value="<?php echo $geno_type;?>">
<input type='hidden' id='session_attend_id' value="<?php echo $attend_id;?>">
<input type='hidden' id='session_patient_id' value="<?php echo $patient_id;?>">
<input type='hidden' id='session_folderno' value="<?php echo $folderno;?>">
<input type='hidden' id='session_name' value="<?php echo $name;?>">
<input type='hidden' id='session_age' value="<?php echo $_SESSION['age'];?>">
<input type='hidden' id='session_gender' value="<?php echo $gender;?>">
<input type='hidden' id='session_Schname' value="<?php echo $Schname;?>">
<input type='hidden' id='session_nhismemberno' value="<?php echo $nhismemberno;?>">
<input type='hidden' id='session_nhisexpirydate' value="<?php echo $nhisexpirydate;?>">
<input type='hidden' id='session_serial_no' value="<?php echo $serial_no;?>">
<input type='hidden' id='session_ghanacard' value="<?php echo $ghanacard;?>">
<input type='hidden' id='session_prtinsname' value="<?php echo $prtinsname;?>">
<input type='hidden' id='session_prtmemberno' value="<?php echo $prtmemberno;?>">
<input type='hidden' id='session_prtexpirydate' value="<?php echo $prtexpirydate;?>">
<input type='hidden' id='session_sponsor' value="<?php echo $sponsor_attd;?>">
<input type='hidden' id='session_clinic' value="<?php echo $clinic;?>">
<input type='hidden' id='session_typeofservice_attd' value="<?php echo $typeofservice_attd;?>">
<input type='hidden' id='session_dateofadmission_attd' value="<?php echo $dateofadmission_attd;?>">
<input type='hidden' id='session_dateofdischarge_attd' value="<?php echo $dateofdischarge_attd;?>">
<input type='hidden' id='session_company' value="<?php echo $company_id;?>">
<input type='hidden' id='session_user_full_name' value="<?php echo $full_name;?>">
<input type='hidden' id='session_date_today' value="<?php echo $date_today;?>">
<input type='hidden' id='session_user_type_id' value="<?php echo $user_type_id;?>">
<style type="text/css">
    .scroll-card-body {
            max-height: 700px;
            overflow-y: auto;
          }
    .scroll_card_body_prescription_history {
            max-height: 700px;
            overflow-y: auto;
          }
    .amt-td {
            text-align:right;
          }
    .action-td {
            text-align:center;
          }
</style>

<div class="container-fluid">
    <div class="card shadow md-4">
        <div class="card-header py-0">
            <!--<h3 class="m-0 font-weight-bold text-primary">
                <?php echo $name.' '.$age;?>
            </h3>-->
        	<div class="table-responsive no-padding">
	        	<table width="100%" cellpadding="3" cellspacing="3">
		            <tr>
		                <td>
		                	<table id="attend_patient_table" width="100%">
			                    <tr>
			                    	<td><u>Age: </u><?php echo '<a href="#" id="btn_edit_patient_age" 
											data-id="'.$attend_id.'" 
											data-id1="'.$patient_id.'">'.$age.'</a>';
										?></td>
			                    	<?php
				                    	$query_gender = "SELECT * FROM gender WHERE gender_id='$gender'";
	                                    $query_gender_run = mysqli_query($con, $query_gender);
	                                    $row_gender=mysqli_fetch_assoc($query_gender_run);
                                    ?>
			                    	<td><u>Gender: </u><?php echo $row_gender['gender'];?></td>
			                    	<td>
										<u>Sponsor: </u>
										<?php 
											if($row_principal_sponsor['ledger_id'] == 2)
											{
											echo '<a id="btn_open_claim_form" href="#"
												data-id="'.$row_principal_sponsor['attend_id'].'"
												data-id1="'.$row_principal_sponsor['patient_id'].'"
												data-id2="'.$row_principal_sponsor['pay_type_id'].'"
												data-id3="'.$dateofadmission_attd.'"
												data-id4="'.$dateofdischarge_attd.'"
												data-id5="'.$name.'"
											>
												'.$sponsor_desc.'
											</a>';
											}
											else
											{
												echo $sponsor_desc;
											};
										?>
									</td>
									<td><strong><u>Previous Balance: </u><?php echo 'GH¢'.$grand_total_other_f;?></strong></td>
									<td><h4><strong><u>Patient Balance: </u><?php echo 'GH¢'.$patient_total_balance_f;?></strong></h4></td>
			                    </tr>
			                    <tr>
			            			<td><u>Folder No: </u><?php echo $_SESSION['folderno'];?></td>
			            			<td><u>Date of Admission: </u><?php echo $dateofadmission_attd;?></td>
			            			<td><u>Type of Service: </u><?php echo $tos_desc;?></td>
			            			<td><u>Clinic: </u><?php echo $clinic_desc;?></td>
									<td>
										<strong><u>Attend. Balance: </u>
											<?php echo '<a href="#" id="btn_cash_statement_attend" 
												data-id="'.$attend_id.'" 
												data-id1="'.$patient_id.'"
												data-id2="'.$dateofadmission_attd.'">GH¢'.
												$grand_total_f.
												'</a>';
											?>
										</strong>
									</td>
			            		</tr>
		                    </table>
		                </td>
		            </tr>
	            </table>
	        </div>
	        <?php
			    $query = "SELECT * FROM vitals WHERE attend_id='$attend_id' ORDER BY date DESC";
			    $query_run = mysqli_query($con, $query);
			?>
			<div class="table-responsive">
			    <table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
			        <thead>
			            <tr>
			                <th class="action-td">Date</th>
			                <th class="action-td">Temp</th>
			                <th class="action-td">BP</th>
			                <th class="action-td">Pulse</th>
			                <th class="action-td">R.Rate</th>
			                <th class="action-td">Weight</th>
			                <th class="action-td">Height</th>
			                <th class="action-td">BMI</th>
			                <th class="action-td">SpO<sub>2</sub></th>
			                <th class="action-td">FBS</th>
			                <th class="action-td">RBS</th>
			                <!--<th>H.Circ.</th>
			                <th>A.Circ.</th>-->
			            </tr>
			        </thead>
			        <tbody class="pv-table-body">
			            <?php
				            if (mysqli_num_rows($query_run) > 0)
				            	{
				            		$row=mysqli_fetch_assoc($query_run);
									if($row['weight'] > 0 && $row['height'] > 0)
									{
										$bmi = round(($row['weight']/($row['height']*$row['height'])),2);
									}
									else
									{
										$bmi = 0;
									};
			            ?>
			                <tr>
			                    <td class="action-td"><?php echo $row['date'];?></td>
			                    <td class="action-td"><?php echo $row['temp'];?></td>
			                    <td class="action-td"><?php echo $row['bp_systolic'];?>/<?php echo $row['bp_diastolic'];?></td>
			                    <td class="action-td"><?php echo $row['pulse'];?></td>
			                    <td class="action-td"><?php echo $row['resp_rate'];?></td>
			                    <td class="action-td"><?php echo $row['weight'];?></td>
			                    <td class="action-td"><?php echo $row['height'];?></td>
				                <td class="action-td"><?php echo $bmi;?></td>
			                    <td class="action-td"><?php echo $row['oxygen_sat'];?></td>
			                    <td class="action-td"><?php echo $row['fbs'];?></td>
			                    <td class="action-td"><?php echo $row['rbs'];?></td>
			                    <!--<td><?php //echo $row['circ_hip'];?></td>
			                    <td><?php //echo $row['circ_abdo'];?></td>-->
			                </tr>
			            <?php
			                }
			                else
			                {
			                    echo '';
			                };
							
							echo'<tr>
			                	<th colspan="12">
									<a href="#" id="allergies_patient_id" data-id="'.$patient_id.'">Allergies<small> - click to update</small></a>
									</th>
							</tr>';
							
							$query_allergies = "SELECT Allergies FROM patients WHERE patient_id='$patient_id'";
							$query_run_allergies = mysqli_query($con, $query_allergies);
							if (mysqli_num_rows($query_run_allergies) > 0)
							{
								$row_allergies = mysqli_fetch_assoc($query_run_allergies);
								$Allergies = $row_allergies['Allergies'];
							}
							else
							{
								$Allergies = '';
							};
							
							echo'<tr>
								<td colspan="8">'.$Allergies.'</td>
								<td colspan="2">Review Date:<input type="date" name="attend_review_date" class="form-control bg-light" id="attend_review_date" value="'.$date_review.'"></td>
								<td colspan="2"><button type="submit" id="nav_home" class="btn btn-danger btn-block">End Consultation</button></td>
							</tr>';
			            ?>
			        </tbody>
			    </table>
			</div>
        </div>
        <div class="card-body">