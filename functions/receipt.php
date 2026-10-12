<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//RECEIPT
		/*function go_to_receipt_sheet()
		{
		    global $con;
			$attend_id = $_POST['attend_id'];
			$patient_id = $_POST['patient_id'];
			$page = $_POST['page'];
			$receipt_type = $_POST['receipt_type'];
		    $_SESSION['page'] = $page;
		    $_SESSION['receipt_type'] = $receipt_type;

		        $query = "SELECT * FROM patients WHERE patient_id='$patient_id'";
		        $query_run = mysqli_query($con, $query);
		        $row_p=mysqli_fetch_assoc($query_run);
		        $_SESSION['name'] = $row_p['firstName'].' '.$row_p['lastName'];
		        $_SESSION['folderno'] = $row_p['folderNo'];
				$_SESSION['gender'] = $row_p['gender'];

		        $query = "SELECT * FROM attendance WHERE attend_id='$attend_id'";
		        $query_run = mysqli_query($con, $query);
		        $row_a=mysqli_fetch_assoc($query_run);
		        $_SESSION['attend_id'] = $attend_id;
		        $_SESSION['patient_id'] = $patient_id;
		        $_SESSION['typeofservice_attd'] = $row_a['tos_id'];
		        $_SESSION['age'] = $row_a['age'];
		        $_SESSION['dateofadmission_attd'] = $row_a['date_admit'];
		        $_SESSION['dateofdischarge_attd'] = $row_a['date_disch'];
		        $_SESSION['nhisccc'] = $row_a['nhis_ccc'];
		        $_SESSION['clinic'] = $row_a['clinic_id'];
				$_SESSION['Schname'] = $row_a['nhis_led_id'];
				$_SESSION['nhismemberno'] = $row_a['nhis_no'];
				$_SESSION['serial_no'] = $row_a['serial_no'];
				$_SESSION['ghanacard'] = $row_a['ghanacard'];
				$_SESSION['nhisexpirydate'] = $row_a['nhis_date'];
				$_SESSION['prtinsname'] = $row_a['prvt_led_id'];
		        $_SESSION['prtmemberno'] = $row_a['prvt_no'];
		        $_SESSION['prtexpirydate'] = $row_a['prvt_date'];
		        if ($row_a['nhis_led_id'] > 0 && $row_a['prvt_led_id'] > 0 ) {
		            $_SESSION['sponsor'] = $row_a['nhis_led_id'];
		        }
		        else if ($row_a['nhis_led_id'] > 0 && $row_a['prvt_led_id'] <= 0 ){
		            $_SESSION['sponsor'] = $row_a['nhis_led_id'];
		        }
		        else if ($row_a['nhis_led_id'] <= 0 && $row_a['prvt_led_id'] > 0 ){
		            $_SESSION['sponsor'] = $row_a['prvt_led_id'];
		        }
		        else if ($row_a['nhis_led_id'] <= 0 && $row_a['prvt_led_id'] <= 0 ){
		            $_SESSION['sponsor'] = 1;
		        };
	    }

		function save_receipt()
		{
			global $con;
			$receipt_type = $_POST['receipt_type'];
			$attend_id = $_POST['attend_id'];
			$patient_id = $_POST['patient_id'];
			$receipt_no = $_POST['receipt_no'];
			$date = $_POST['date'];
			$debit_ledger = $_POST['debit_ledger'];
			$credit_ledger = $_POST['credit_ledger'];
			$received_from = $_POST['received_from'];
			$mode = $_POST['mode'];
			$amount = $_POST['amount'];
			$narration = $_POST['received_from'] .':- '. $_POST['narration'];
			$query = "INSERT INTO `receipt`(
				`attend_id`, `patient_id`, `date`, `ledger_debit`, `ledger_credit`, `name`, `narration`, `amount`, `mode`, `type`, `receipt_no`) 
				VALUES ('$attend_id','$patient_id','$date','$debit_ledger','$credit_ledger','$received_from','$narration','$amount','$mode','$receipt_type','$receipt_no')";
		    	$query_run = mysqli_query($con, $query);

		    	if ($query_run) {

		    		//POST TRANSACTION
			    		$query = "SELECT * FROM receipt ORDER BY receipt_id DESC";
						$result = mysqli_query($con,$query);
						$row = mysqli_fetch_assoc($result);
						$receipt_id = $row['receipt_id'];

			    		$query_dr = "INSERT INTO `transactions`(
		                `receipt_id`,`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES ('$receipt_id','$debit_ledger','$credit_ledger','$attend_id','$patient_id','$date','$amount','$amount',0,'$narration')";
		                mysqli_query($con, $query_dr);

		                $query_cr = "INSERT INTO `transactions`(
		                `receipt_id`,`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES ('$receipt_id','$credit_ledger','$debit_ledger','$attend_id','$patient_id','$date','$amount',0,'$amount','$narration')";
		                mysqli_query($con, $query_cr);

		            //RECEIPT_ITEMS
		                if($receipt_type == 'Itemise')
		                {
		                	$number_as = count($_POST["item_id"]);  
							if($number_as > 0)  
							{  
							  for($i=0; $i<$number_as; $i++)  
							  {  
							       if(trim($_POST["item_id"][$i] != ''))  
							       {  
							            $item_id = $_POST['item_id'][$i];
							            $item_list_id = $_POST['item_list_id'][$i];
							            $category_id = $_POST['category_id'][$i];
							            $amount_bill = $_POST['amount_bill'][$i];
							            $amount = $_POST['amount_item'][$i];
							            $query = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,
							            	`attend_id`, `date`, `amount_bill`, `amount_rec`, `type`) 
							            	VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$amount_bill','$amount','itemise')";
										$query_run = mysqli_query($con, $query);
							       }
							  }
							  echo "Receipt Items Inserted";  
							}  
							else  
							{  
							  echo "Receipt Items NOT Inserted";  
							};
		                }
		                else if($receipt_type == 'Deposit')
		                {
		                	//GET SERVICELIST
			                	$query_servicelist = "SELECT * FROM service_list WHERE attend_id='$attend_id'";
							    $query_run_servicelist = mysqli_query($con, $query_servicelist);
							    if (mysqli_num_rows($query_run_servicelist) > 0)
								{
									while($row_servicelist = mysqli_fetch_assoc($query_run_servicelist))
									{
										$item_list_id = $row_servicelist['service_list_id'];
										$item_id = $row_servicelist['service_id'];
										$amount_cash = $row_servicelist['amount_cash'];
										$category_id = 1;
										$query_rsl = "SELECT MAX(amount_bill) AS amount_bill, SUM(amount_rec) AS total_rec FROM receipt_items WHERE item_list_id='$item_list_id' AND item_id='$item_id' AND category_id='$category_id'";
							    		$query_run_rsl = mysqli_query($con, $query_rsl);
							    		$row_rsl=mysqli_fetch_assoc($query_run_rsl);
							    		if($row_rsl['total_rec'] == NULL)
						    			{
											if($amount_cash > $amount)
											{
												$amount_rec = $amount;
											}
											else
											{
												$amount_rec = $amount_cash;
											};
											$query = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,
								            	`attend_id`, `date`, `amount_bill`, `amount_rec`, `type`) 
								            	VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$amount_cash','$amount_rec','itemise')";
											$query_run = mysqli_query($con, $query);
											$amount = $amount - $amount_rec;
						    			}
						    			else if($row_rsl['total_rec'] !== NULL)
						    			{
						    				if($row_rsl['amount_bill'] > $row_rsl['total_rec'])
						    				{
						    					$query_irsl = "SELECT * FROM receipt_items WHERE item_list_id='$item_list_id' AND item_id='$item_id' AND category_id='$category_id'";
							    				$query_run_irsl = mysqli_query($con, $query_irsl);
							    				if (mysqli_num_rows($query_run_irsl) > 0)
												{
													while($row_irsl = mysqli_fetch_assoc($query_run_irsl))
													{
														$amount_left = $row_irsl['amount_bill'] - $row_irsl['amount_rec'];
														if($amount_left > 0)
														{
															if($amount_left > $amount)
															{
																$amount_rec = $amount;
															}
															else
															{
																$amount_rec = $amount_left;
															};
															$query = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,
												            	`attend_id`, `date`, `amount_bill`, `amount_rec`, `type`) 
												            	VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$amount_cash','$amount_rec','itemise')";
															$query_run = mysqli_query($con, $query);
															$amount = $amount - $amount_rec;
														};
													};
												};
						    				};
						    			};
							    	};
				                };
				            //GET DRUGS
			                	$query_ddruglist = "SELECT * FROM drug_dispense_list WHERE attend_id='$attend_id'";
							    $query_run_ddruglist = mysqli_query($con, $query_ddruglist);
							    if (mysqli_num_rows($query_run_ddruglist) > 0)
								{
									while($row_ddruglist = mysqli_fetch_assoc($query_run_ddruglist))
									{
										$item_list_id = $row_ddruglist['drug_disp_list_id'];
										$item_id = $row_ddruglist['drug_id'];
										$amount_cash = $row_ddruglist['amt_cash'];
										$category_id = 2;
										$query_rdl = "SELECT MAX(amount_bill) AS amount_bill, SUM(amount_rec) AS total_rec FROM receipt_items WHERE item_list_id='$item_list_id' AND item_id='$item_id' AND category_id='$category_id'";
							    		$query_run_rdl = mysqli_query($con, $query_rdl);
							    		$row_rdl=mysqli_fetch_assoc($query_run_rdl);
							    		if($row_rdl['total_rec'] == NULL)
						    			{
											if($amount_cash > $amount)
											{
												$amount_rec = $amount;
											}
											else
											{
												$amount_rec = $amount_cash;
											};
											$query = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,
								            	`attend_id`, `date`, `amount_bill`, `amount_rec`, `type`) 
								            	VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$amount_cash','$amount_rec','itemise')";
											$query_run = mysqli_query($con, $query);
											$amount = $amount - $amount_rec;
						    			}
						    			else if($row_rdl['total_rec'] !== NULL)
						    			{
						    				if($row_rdl['amount_bill'] > $row_rdl['total_rec'])
						    				{
						    					$query_irdl = "SELECT * FROM receipt_items WHERE item_list_id='$item_list_id' AND item_id='$item_id' AND category_id='$category_id'";
							    				$query_run_irdl = mysqli_query($con, $query_irdl);
							    				if (mysqli_num_rows($query_run_irdl) > 0)
												{
													while($row_irdl = mysqli_fetch_assoc($query_run_irdl))
													{
														$amount_left = $row_irdl['amount_bill'] - $row_irdl['amount_rec'];
														if($amount_left > 0)
														{
															if($amount_left > $amount)
															{
																$amount_rec = $amount;
															}
															else
															{
																$amount_rec = $amount_left;
															};
															$query = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,
												            	`attend_id`, `date`, `amount_bill`, `amount_rec`, `type`) 
												            	VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$amount_cash','$amount_rec','itemise')";
															$query_run = mysqli_query($con, $query);
															$amount = $amount - $amount_rec;
														};
													};
												};
						    				};
						    			};
							    	};
				                };
				            //GET LABS
			                	$query_lablist = "SELECT * FROM lab_list WHERE attend_id='$attend_id'";
							    $query_run_lablist = mysqli_query($con, $query_lablist);
							    if (mysqli_num_rows($query_run_lablist) > 0)
								{
									while($row_lablist = mysqli_fetch_assoc($query_run_lablist))
									{
										$item_list_id = $row_lablist['lab_list_id'];
										$item_id = $row_lablist['lab_id'];
										$amount_cash = $row_lablist['amount_cash'];
										$category_id = 3;
										$query_rll = "SELECT MAX(amount_bill) AS amount_bill, SUM(amount_rec) AS total_rec FROM receipt_items WHERE item_list_id='$item_list_id' AND item_id='$item_id' AND category_id='$category_id'";
							    		$query_run_rll = mysqli_query($con, $query_rll);
							    		$row_rll=mysqli_fetch_assoc($query_run_rll);
							    		if($row_rll['total_rec'] == NULL)
						    			{
											if($amount_cash > $amount)
											{
												$amount_rec = $amount;
											}
											else
											{
												$amount_rec = $amount_cash;
											};
											$query = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,
								            	`attend_id`, `date`, `amount_bill`, `amount_rec`, `type`) 
								            	VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$amount_cash','$amount_rec','itemise')";
											$query_run = mysqli_query($con, $query);
											$amount = $amount - $amount_rec;
						    			}
						    			else if($row_rll['total_rec'] !== NULL)
						    			{
						    				if($row_rll['amount_bill'] > $row_rll['total_rec'])
						    				{
						    					$query_irll = "SELECT * FROM receipt_items WHERE item_list_id='$item_list_id' AND item_id='$item_id' AND category_id='$category_id'";
							    				$query_run_irll = mysqli_query($con, $query_irll);
							    				if (mysqli_num_rows($query_run_irll) > 0)
												{
													while($row_irll = mysqli_fetch_assoc($query_run_irll))
													{
														$amount_left = $row_irll['amount_bill'] - $row_irll['amount_rec'];
														if($amount_left > 0)
														{
															if($amount_left > $amount)
															{
																$amount_rec = $amount;
															}
															else
															{
																$amount_rec = $amount_left;
															};
															$query = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,
												            	`attend_id`, `date`, `amount_bill`, `amount_rec`, `type`) 
												            	VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$amount_cash','$amount_rec','itemise')";
															$query_run = mysqli_query($con, $query);
															$amount = $amount - $amount_rec;
														};
													};
												};
						    				};
						    			};
							    	};
				                };
				            //GET RADIOLOGY
			                	$query_radiolist = "SELECT * FROM radio_list WHERE attend_id='$attend_id'";
							    $query_run_radiolist = mysqli_query($con, $query_radiolist);
							    if (mysqli_num_rows($query_run_radiolist) > 0)
								{
									while($row_radiolist = mysqli_fetch_assoc($query_run_radiolist))
									{
										$item_list_id = $row_radiolist['radio_list_id'];
										$item_id = $row_radiolist['radio_id'];
										$amount_cash = $row_radiolist['amount_cash'];
										$category_id = 4;
										$query_rrl = "SELECT MAX(amount_bill) AS amount_bill, SUM(amount_rec) AS total_rec FROM receipt_items WHERE item_list_id='$item_list_id' AND item_id='$item_id' AND category_id='$category_id'";
							    		$query_run_rrl = mysqli_query($con, $query_rrl);
							    		$row_rrl=mysqli_fetch_assoc($query_run_rrl);
							    		if($row_rrl['total_rec'] == NULL)
						    			{
											if($amount_cash > $amount)
											{
												$amount_rec = $amount;
											}
											else
											{
												$amount_rec = $amount_cash;
											};
											$query = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,
								            	`attend_id`, `date`, `amount_bill`, `amount_rec`, `type`) 
								            	VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$amount_cash','$amount_rec','itemise')";
											$query_run = mysqli_query($con, $query);
											$amount = $amount - $amount_rec;
						    			}
						    			else if($row_rrl['total_rec'] !== NULL)
						    			{
						    				if($row_rrl['amount_bill'] > $row_rrl['total_rec'])
						    				{
						    					$query_irrl = "SELECT * FROM receipt_items WHERE item_list_id='$item_list_id' AND item_id='$item_id' AND category_id='$category_id'";
							    				$query_run_irrl = mysqli_query($con, $query_irrl);
							    				if (mysqli_num_rows($query_run_irrl) > 0)
												{
													while($row_irrl = mysqli_fetch_assoc($query_run_irrl))
													{
														$amount_left = $row_irrl['amount_bill'] - $row_irrl['amount_rec'];
														if($amount_left > 0)
														{
															if($amount_left > $amount)
															{
																$amount_rec = $amount;
															}
															else
															{
																$amount_rec = $amount_left;
															};
															$query = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,
												            	`attend_id`, `date`, `amount_bill`, `amount_rec`, `type`) 
												            	VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$amount_cash','$amount_rec','itemise')";
															$query_run = mysqli_query($con, $query);
															$amount = $amount - $amount_rec;
														};
													};
												};
						    				};
						    			};
							    	};
				                };
				            //GET SURGERIES/PROCEDURES
			                	$query_surgerylist = "SELECT * FROM surgery_list WHERE attend_id='$attend_id'";
							    $query_run_surgerylist = mysqli_query($con, $query_surgerylist);
							    if (mysqli_num_rows($query_run_surgerylist) > 0)
								{
									while($row_surgerylist = mysqli_fetch_assoc($query_run_surgerylist))
									{
										$item_list_id = $row_surgerylist['surgery_list_id'];
										$item_id = $row_surgerylist['surgery_id'];
										$amount_cash = $row_surgerylist['amount_cash'];
										$category_id = 5;
										$query_rspl = "SELECT MAX(amount_bill) AS amount_bill, SUM(amount_rec) AS total_rec FROM receipt_items WHERE item_list_id='$item_list_id' AND item_id='$item_id' AND category_id='$category_id'";
							    		$query_run_rspl = mysqli_query($con, $query_rspl);
							    		$row_rspl=mysqli_fetch_assoc($query_run_rspl);
							    		if($row_rspl['total_rec'] == NULL)
						    			{
											if($amount_cash > $amount)
											{
												$amount_rec = $amount;
											}
											else
											{
												$amount_rec = $amount_cash;
											};
											$query = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,
								            	`attend_id`, `date`, `amount_bill`, `amount_rec`, `type`) 
								            	VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$amount_cash','$amount_rec','itemise')";
											$query_run = mysqli_query($con, $query);
											$amount = $amount - $amount_rec;
						    			}
						    			else if($row_rspl['total_rec'] !== NULL)
						    			{
						    				if($row_rspl['amount_bill'] > $row_rspl['total_rec'])
						    				{
						    					$query_irspl = "SELECT * FROM receipt_items WHERE item_list_id='$item_list_id' AND item_id='$item_id' AND category_id='$category_id'";
							    				$query_run_irspl = mysqli_query($con, $query_irspl);
							    				if (mysqli_num_rows($query_run_irspl) > 0)
												{
													while($row_irspl = mysqli_fetch_assoc($query_run_irspl))
													{
														$amount_left = $row_irspl['amount_bill'] - $row_irspl['amount_rec'];
														if($amount_left > 0)
														{
															if($amount_left > $amount)
															{
																$amount_rec = $amount;
															}
															else
															{
																$amount_rec = $amount_left;
															};
															$query = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,
												            	`attend_id`, `date`, `amount_bill`, `amount_rec`, `type`) 
												            	VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$amount_cash','$amount_rec','itemise')";
															$query_run = mysqli_query($con, $query);
															$amount = $amount - $amount_rec;
														};
													};
												};
						    				};
						    			};
							    	};
				                };
				            //GET CONSUMABLES
			                	$query_conlist = "SELECT * FROM consumable_list WHERE attend_id='$attend_id'";
							    $query_run_conlist = mysqli_query($con, $query_conlist);
							    if (mysqli_num_rows($query_run_conlist) > 0)
								{
									while($row_conlist = mysqli_fetch_assoc($query_run_conlist))
									{
										$item_list_id = $row_conlist['con_list_id'];
										$item_id = $row_conlist['con_id'];
										$amount_cash = $row_conlist['amount_cash'];
										$category_id = 7;
										$query_rcl = "SELECT MAX(amount_bill) AS amount_bill, SUM(amount_rec) AS total_rec FROM receipt_items WHERE item_list_id='$item_list_id' AND item_id='$item_id' AND category_id='$category_id'";
							    		$query_run_rcl = mysqli_query($con, $query_rcl);
							    		$row_rcl=mysqli_fetch_assoc($query_run_rcl);
							    		if($row_rcl['total_rec'] == NULL)
						    			{
											if($amount_cash > $amount)
											{
												$amount_rec = $amount;
											}
											else
											{
												$amount_rec = $amount_cash;
											};
											$query = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,
								            	`attend_id`, `date`, `amount_bill`, `amount_rec`, `type`) 
								            	VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$amount_cash','$amount_rec','itemise')";
											$query_run = mysqli_query($con, $query);
											$amount = $amount - $amount_rec;
						    			}
						    			else if($row_rcl['total_rec'] !== NULL)
						    			{
						    				if($row_rcl['amount_bill'] > $row_rcl['total_rec'])
						    				{
						    					$query_ircl = "SELECT * FROM receipt_items WHERE item_list_id='$item_list_id' AND item_id='$item_id' AND category_id='$category_id'";
							    				$query_run_ircl = mysqli_query($con, $query_ircl);
							    				if (mysqli_num_rows($query_run_ircl) > 0)
												{
													while($row_ircl = mysqli_fetch_assoc($query_run_ircl))
													{
														$amount_left = $row_ircl['amount_bill'] - $row_ircl['amount_rec'];
														if($amount_left > 0)
														{
															if($amount_left > $amount)
															{
																$amount_rec = $amount;
															}
															else
															{
																$amount_rec = $amount_left;
															};
															$query = "INSERT INTO `receipt_items`(`receipt_id`, `item_list_id`, `item_id`, `patient_id`, `category_id`,
												            	`attend_id`, `date`, `amount_bill`, `amount_rec`, `type`) 
												            	VALUES ('$receipt_id','$item_list_id','$item_id','$patient_id','$category_id','$attend_id','$date','$amount_cash','$amount_rec','itemise')";
															$query_run = mysqli_query($con, $query);
															$amount = $amount - $amount_rec;
														};
													};
												};
						    				};
						    			};
							    	};
				                };
		                };
		            $_SESSION['receipt_id'] = $receipt_id;
		    	}
		}*/

		function receipt_unpaid_list()
		{
			global $con;
            $total_bill = 0;
            $i = 0;
			$attend_id = $_POST['attend_id'];
			echo '<table class="table table-hover table-bordered table-sm" id="patient_cash_statement_list_table" width="100%" cellspacing="0">
				<thead>
					</tr>
						<th class = "action-td">DATE</th>
						<th>PARTICULARS</th>
						<th class = "action-td">QTY</th>
						<th class = "action-td">PRICE</th>
						<th class = "action-td">BILL</th>
						<th class = "action-td">ACTION</th>
					</tr>
				</thead>';
				
				$query_svl = "SELECT * FROM `service_list` WHERE `attend_id` = '$attend_id'";
				$query_run_svl = mysqli_query($con, $query_svl);
				if (mysqli_num_rows($query_run_svl) > 0)
				{   
					echo'<tr>
							<th colspan="8">SERVICE</th>
						</tr>';
					while($row_svl = mysqli_fetch_assoc($query_run_svl))
					{
						$service_list_id = $row_svl['service_list_id'];
						$query_receipt_item = "SELECT * FROM `receipt_items` WHERE `attend_id` = '$attend_id' AND `category_id` = 1 
						AND `item_list_id`='$service_list_id'";
						$query_run_receipt_item = mysqli_query($con, $query_receipt_item);
						if (mysqli_num_rows($query_run_receipt_item) < 1)
						{
							$i++;
							$service_id = $row_svl['service_id'];
							$query_service = "SELECT * FROM `services` WHERE `service_id` = '$service_id'";
							$query_run_service = mysqli_query($con, $query_service);
							if (mysqli_num_rows($query_run_service) > 0)
							{
								$row_service = mysqli_fetch_assoc($query_run_service);
							};
								$amount = $row_svl['amount_cash'];
								$amount = number_format($amount, 2, '.', ',');
							echo '<tr id="'.$i.'">
								<td class="action-td">'.$row_svl['date'].'</td>
								<td>'.$row_service['service'].'</td>
								<td class="action-td">'.$row_svl['qty'].'</td>
								<td class="amt-td">'.$row_svl['price_cash'].'</td>
								<td class="amt-td">'.$amount.'</td>
								<td class="action-td">
									<a href="#" id="btn_select_unpaid_item" 
									data-id="1" 
									data-id1="'.$row_svl['service_list_id'].'"
									data-id2="'.$row_service['service'].'"
									data-id3="'.$row_svl['amount_cash'].'">
									PAY</a>
									<input type="hidden" id="receipt_unpaid_category'.$i.'" name="receipt_unpaid_category[]" value="1">
									<input type="hidden" id="receipt_unpaid_item_list'.$i.'" name="receipt_unpaid_item_list[]" value="'.$row_svl['service_list_id'].'">
									<input type="hidden" id="receipt_unpaid_item_id'.$i.'" name="receipt_unpaid_item_id[]" value="'.$row_svl['service_id'].'">
									<input type="hidden" id="receipt_unpaid_item_qty'.$i.'" name="receipt_unpaid_item_qty[]" value="'.$row_svl['qty'].'">
									<input type="hidden" id="receipt_unpaid_item_price'.$i.'" name="receipt_unpaid_item_price[]" value="'.$row_svl['price_cash'].'">
									<input type="hidden" class="receipt_item_description" id="receipt_unpaid_item'.$i.'" name="receipt_unpaid_item[]" value="'.$row_service['service'].'">
									<input type="hidden" class="receipt_item_amount" id="receipt_unpaid_item_amount'.$i.'" name="receipt_unpaid_item_amount[]" value="'.$row_svl['amount_cash'].'">
									<input type="hidden" id="receipt_unpaid_item_status'.$i.'" name="receipt_unpaid_item_status[]">
								</td>
							</tr>';
							$total_bill = $total_bill + $row_svl['amount_cash'];
						};
					};
				};
	
				$query_ll = "SELECT * FROM `lab_list` WHERE `attend_id` = '$attend_id'";
				$query_run_ll = mysqli_query($con, $query_ll);
				if (mysqli_num_rows($query_run_ll) > 0)
				{
					echo'<tr>
							<th colspan="8">LABORATORY TEST</th>
						</tr>';
					while($row_ll = mysqli_fetch_assoc($query_run_ll))
					{
						$lab_list_id = $row_ll['lab_list_id'];
						$query_receipt_item = "SELECT * FROM `receipt_items` WHERE `attend_id` = '$attend_id' AND `category_id` = 3 
						AND `item_list_id`='$lab_list_id'";
						$query_run_receipt_item = mysqli_query($con, $query_receipt_item);
						if (mysqli_num_rows($query_run_receipt_item) < 1)
						{
							$i++;
							$lab_id = $row_ll['lab_id'];
							$query_lab = "SELECT * FROM `lab` WHERE `lab_id` = '$lab_id'";
							$query_run_lab = mysqli_query($con, $query_lab);
							if (mysqli_num_rows($query_run_lab) > 0)
							{
								$row_lab = mysqli_fetch_assoc($query_run_lab);
							};
								$price_est = $row_ll['price_est'];
								$amount_est = $row_ll['amount_est'];
								$price_cash = $row_ll['price_cash'];
								$amount_cash = $row_ll['amount_cash'];
								if($price_est != '' && $price_est > 0)
								{
									$price = $price_est;
								}
								else
								{
									$price = $price_cash;
								};
								if($amount_est != '' && $amount_est > 0)
								{
									$amount = $amount_est;
								}
								else
								{
									$amount = $amount_cash;
								};
								$amount_f = number_format($amount, 2, '.', ',');
							echo '<tr id="'.$i.'">
								<td class="action-td">'.$row_ll['date'].'</td>
								<td>'.$row_lab['lab'].'</td>
								<td class="action-td">'.$row_ll['qty'].'</td>
								<td class="amt-td">'.$row_ll['price_est'].'</td>
								<td class="amt-td">'.$amount_f.'</td>
								<td class="action-td">
									<a href="#" id="btn_select_unpaid_item" 
									data-id="3" 
									data-id1="'.$row_ll['lab_list_id'].'"
									data-id2="'.$row_lab['lab'].'"
									data-id3="'.$amount.'">
									PAY</a>
									<input type="hidden" id="receipt_unpaid_category'.$i.'" name="receipt_unpaid_category[]" value="3">
									<input type="hidden" id="receipt_unpaid_item_list'.$i.'" name="receipt_unpaid_item_list[]" value="'.$row_ll['lab_list_id'].'">
									<input type="hidden" id="receipt_unpaid_item_id'.$i.'" name="receipt_unpaid_item_id[]" value="'.$row_ll['lab_id'].'">
									<input type="hidden" id="receipt_unpaid_item_qty'.$i.'" name="receipt_unpaid_item_qty[]" value="'.$row_ll['qty'].'">
									<input type="hidden" id="receipt_unpaid_item_price'.$i.'" name="receipt_unpaid_item_price[]" value="'.$price.'">
									<input type="hidden" class="receipt_item_description" id="receipt_unpaid_item'.$i.'" name="receipt_unpaid_item[]" value="'.$row_lab['lab'].'">
									<input type="hidden" class="receipt_item_amount" id="receipt_unpaid_item_amount'.$i.'" name="receipt_unpaid_item_amount[]" value="'.$amount.'">
									<input type="hidden" id="receipt_unpaid_item_status'.$i.'" name="receipt_unpaid_item_status[]">
								</td>
							</tr>';
							$total_bill = $total_bill + $row_ll['amount_est'];
						};
					};
				};
	
	
				$query_rl = "SELECT * FROM `radio_list` WHERE `attend_id` = '$attend_id'";
				$query_run_rl = mysqli_query($con, $query_rl);
				if (mysqli_num_rows($query_run_rl) > 0)
				{
					echo'<tr>
							<th colspan="8">RADIOLOGY</th>
						</tr>';
					while($row_rl = mysqli_fetch_assoc($query_run_rl))
					{
						$radio_list_id = $row_rl['radio_list_id'];
						$query_receipt_item = "SELECT * FROM `receipt_items` WHERE `attend_id` = '$attend_id' AND `category_id` = 4 
						AND `item_list_id`='$radio_list_id'";
						$query_run_receipt_item = mysqli_query($con, $query_receipt_item);
						if (mysqli_num_rows($query_run_receipt_item) < 1)
						{
							$i++;
							$radio_id = $row_rl['radio_id'];
							$query_radio = "SELECT * FROM `radiology` WHERE `radio_id` = '$radio_id'";
							$query_run_radio = mysqli_query($con, $query_radio);
							if (mysqli_num_rows($query_run_radio) > 0)
							{
								$row_radio = mysqli_fetch_assoc($query_run_radio);
							};
							$price_est = $row_rl['price_est'];
							$amount_est = $row_rl['amount_est'];
							$price_cash = $row_rl['price_cash'];
							$amount_cash = $row_rl['amount_cash'];
							if($price_est != '' && $price_est > 0)
							{
								$price = $price_est;
							}
							else
							{
								$price = $price_cash;
							};
							if($amount_est != '' && $amount_est > 0)
							{
								$amount = $amount_est;
							}
							else
							{
								$amount = $amount_cash;
							};
								$amount = $row_rl['amount_est'];
								$amount_f = number_format($amount, 2, '.', ',');
								$price_f = number_format($price, 2, '.', ',');
							echo '<tr id="'.$i.'">
								<td class="action-td">'.$row_rl['date'].'</td>
								<td>'.$row_radio['radiology'].'</td>
								<td class="action-td">'.$row_rl['qty'].'</td>
								<td class="amt-td">'.$price_f.'</td>
								<td class="amt-td">'.$amount_f.'</td>
								<td class="action-td">
									<a href="#" id="btn_select_unpaid_item" 
									data-id="4" 
									data-id1="'.$row_rl['radio_list_id'].'"
									data-id2="'.$row_radio['radiology'].'"
									data-id3="'.$amount.'">
									PAY</a>
									<input type="hidden" id="receipt_unpaid_category'.$i.'" name="receipt_unpaid_category[]" value="4">
									<input type="hidden" id="receipt_unpaid_item_list'.$i.'" name="receipt_unpaid_item_list[]" value="'.$row_rl['radio_list_id'].'">
									<input type="hidden" id="receipt_unpaid_item_id'.$i.'" name="receipt_unpaid_item_id[]" value="'.$row_rl['radio_id'].'">
									<input type="hidden" id="receipt_unpaid_item_qty'.$i.'" name="receipt_unpaid_item_qty[]" value="'.$row_rl['qty'].'">
									<input type="hidden" id="receipt_unpaid_item_price'.$i.'" name="receipt_unpaid_item_price[]" value="'.$price_est.'">
									<input type="hidden" class="receipt_item_description" id="receipt_unpaid_item'.$i.'" name="receipt_unpaid_item[]" value="'.$row_radio['radiology'].'">
									<input type="hidden" class="receipt_item_amount" id="receipt_unpaid_item_amount'.$i.'" name="receipt_unpaid_item_amount[]" value="'.$amount.'">
									<input type="hidden" id="receipt_unpaid_item_status'.$i.'" name="receipt_unpaid_item_status[]">
								</td>
							</tr>';
							$total_bill = $total_bill + $row_rl['amount_cash'];
						};
					};
				};
	
	
				$query_sl = "SELECT * FROM `surgery_list` WHERE `attend_id` = '$attend_id'";
				$query_run_sl = mysqli_query($con, $query_sl);
				if (mysqli_num_rows($query_run_sl) > 0)
				{
					echo'<tr>
							<th colspan="8">SURGERY/PROCEDURE</th>
						</tr>';
					while($row_sl = mysqli_fetch_assoc($query_run_sl))
					{
						$surgery_list_id = $row_sl['surgery_list_id'];
						$query_receipt_item = "SELECT * FROM `receipt_items` WHERE `attend_id` = '$attend_id' AND `category_id` = 5 
						AND `item_list_id`='$surgery_list_id'";
						$query_run_receipt_item = mysqli_query($con, $query_receipt_item);
						if (mysqli_num_rows($query_run_receipt_item) < 1)
						{
							$i++;
							$surgery_id = $row_sl['surgery_id'];
							$query_surgery = "SELECT * FROM `surgery` WHERE `surgery_id` = '$surgery_id'";
							$query_run_surgery = mysqli_query($con, $query_surgery);
							if (mysqli_num_rows($query_run_surgery) > 0)
							{
								$row_surgery = mysqli_fetch_assoc($query_run_surgery);
							};
								$amount = $row_sl['amount_cash'];
								$amount = number_format($amount, 2, '.', ',');
							echo '<tr id="'.$i.'">
								<td class="action-td">'.$row_sl['date'].'</td>
								<td>'.$row_surgery['surgery'].'</td>
								<td class="action-td">'.$row_sl['qty'].'</td>
								<td class="amt-td">'.$row_sl['price_cash'].'</td>
								<td class="amt-td">'.$amount.'</td>
								<td class="action-td">
									<a href="#" id="btn_select_unpaid_item" 
									data-id="5" 
									data-id1="'.$row_sl['surgery_list_id'].'"
									data-id2="'.$row_surgery['surgery'].'"
									data-id3="'.$row_sl['amount_cash'].'">
									PAY</a>
									<input type="hidden" id="receipt_unpaid_category'.$i.'" name="receipt_unpaid_category[]" value="5">
									<input type="hidden" id="receipt_unpaid_item_list'.$i.'" name="receipt_unpaid_item_list[]" value="'.$row_sl['surgery_list_id'].'">
									<input type="hidden" id="receipt_unpaid_item_id'.$i.'" name="receipt_unpaid_item_id[]" value="'.$row_sl['surgery_id'].'">
									<input type="hidden" id="receipt_unpaid_item_qty'.$i.'" name="receipt_unpaid_item_qty[]" value="'.$row_sl['qty'].'">
									<input type="hidden" id="receipt_unpaid_item_price'.$i.'" name="receipt_unpaid_item_price[]" value="'.$row_sl['price_cash'].'">
									<input type="hidden" class="receipt_item_description" id="receipt_unpaid_item'.$i.'" name="receipt_unpaid_item[]" value="'.$row_surgery['surgery'].'">
									<input type="hidden" class="receipt_item_amount" id="receipt_unpaid_item_amount'.$i.'" name="receipt_unpaid_item_amount[]" value="'.$row_sl['amount_cash'].'">
									<input type="hidden" id="receipt_unpaid_item_status'.$i.'" name="receipt_unpaid_item_status[]">
								</td>
							</tr>';
							$total_bill = $total_bill + $row_sl['amount_cash'];
						};
					};
				};
	
				$query_drl = "SELECT * FROM `drug_dispense_list` WHERE `attend_id` = '$attend_id'";
				$query_run_drl = mysqli_query($con, $query_drl);
				if (mysqli_num_rows($query_run_drl) > 0)
				{
					echo'<tr>
							<th colspan="8">DRUGS</th>
						</tr>';
					while($row_drl = mysqli_fetch_assoc($query_run_drl))
					{
						$drug_list_id = $row_drl['drug_list_id'];
						$query_receipt_item = "SELECT * FROM `receipt_items` WHERE `attend_id` = '$attend_id' AND `category_id` = 2 
						AND `item_list_id`='$drug_list_id'";
						$query_run_receipt_item = mysqli_query($con, $query_receipt_item);
						if (mysqli_num_rows($query_run_receipt_item) < 1)
						{
							$i++;
							$drug_id = $row_drl['drug_id'];
							$query_drug = "SELECT * FROM `drugs` WHERE `drug_id` = '$drug_id'";
							$query_run_drug = mysqli_query($con, $query_drug);
							if (mysqli_num_rows($query_run_drug) > 0)
							{
								$row_drug = mysqli_fetch_assoc($query_run_drug);
							};
								$price_cash = $row_drl['price_cash'];
								$amount_cash = $row_drl['amt_cash'];
									$amount_f = number_format($amount_cash, 2, '.', ',');
									$price_f = number_format($price_cash, 2, '.', ',');
							echo '<tr id="'.$i.'">
								<td class="action-td">'.$row_drl['date'].'</td>
								<td>'.$row_drug['brand_name'].'</td>
								<td class="action-td">'.$row_drl['qty'].'</td>
								<td class="amt-td">'.$price_f.'</td>
								<td class="amt-td">'.$amount_f.'</td>
								<td class="action-td">
									<a href="#" id="btn_select_unpaid_item" 
									data-id="2" 
									data-id1="'.$row_drl['drug_list_id'].'"
									data-id2="'.$row_drug['brand_name'].'"
									data-id3="'.$amount_cash.'">
									PAY</a>
									<input type="hidden" id="receipt_unpaid_category'.$i.'" name="receipt_unpaid_category[]" value="2">
									<input type="hidden" id="receipt_unpaid_item_list'.$i.'" name="receipt_unpaid_item_list[]" value="'.$row_drl['drug_list_id'].'">
									<input type="hidden" id="receipt_unpaid_item_id'.$i.'" name="receipt_unpaid_item_id[]" value="'.$row_drl['drug_id'].'">
									<input type="hidden" id="receipt_unpaid_item_qty'.$i.'" name="receipt_unpaid_item_qty[]" value="'.$row_drl['qty'].'">
									<input type="hidden" id="receipt_unpaid_item_price'.$i.'" name="receipt_unpaid_item_price[]" value="'.$price_cash.'">
									<input type="hidden" class="receipt_item_description" id="receipt_unpaid_item'.$i.'" name="receipt_unpaid_item[]" value="'.$row_drug['brand_name'].'">
									<input type="hidden" class="receipt_item_amount" id="receipt_unpaid_item_amount'.$i.'" name="receipt_unpaid_item_amount[]" value="'.$amount_cash.'">
									<input type="hidden" id="receipt_unpaid_item_status'.$i.'" name="receipt_unpaid_item_status[]">
								</td>
							</tr>';
							$total_bill = $total_bill + $row_drl['amt_cash'];
						};
					};
				};
	
				$query_cl = "SELECT * FROM `consumable_list` WHERE `attend_id` = '$attend_id'";
				$query_run_cl = mysqli_query($con, $query_cl);
				if (mysqli_num_rows($query_run_cl) > 0)
				{
					echo'<tr>
							<th colspan="8">CONSUMABLES</th>
						</tr>';
					while($row_cl = mysqli_fetch_assoc($query_run_cl))
					{
						$con_list_id = $row_cl['con_list_id'];
						$query_receipt_item = "SELECT * FROM `receipt_items` WHERE `attend_id` = '$attend_id' AND `category_id` = 7 
						AND `item_list_id`='$con_list_id'";
						$query_run_receipt_item = mysqli_query($con, $query_receipt_item);
						if (mysqli_num_rows($query_run_receipt_item) < 1)
						{
							
							$i++;
							$con_id = $row_cl['con_id'];
							$query_con = "SELECT * FROM `consumable` WHERE `con_id` = '$con_id'";
							$query_run_con = mysqli_query($con, $query_con);
							if (mysqli_num_rows($query_run_con) > 0)
							{
								$row_con = mysqli_fetch_assoc($query_run_con);
							};
								$amount = $row_cl['amount_cash'];
								$amount = number_format($amount, 2, '.', ',');
							echo '<tr id="'.$i.'">
								<td class="action-td">'.$row_cl['date'].'</td>
								<td>'.$row_con['consumable'].'</td>
								<td class="action-td">'.$row_cl['qty_issued'].'</td>
								<td class="amt-td">'.$row_cl['price_cash'].'</td>
								<td class="amt-td">'.$amount.'</td>
								<td class="action-td">
									<a href="#" id="btn_select_unpaid_item" 
									data-id="7" 
									data-id1="'.$row_cl['con_list_id'].'"
									data-id2="'.$row_con['consumable'].'"
									data-id3="'.$row_cl['amount_cash'].'">
									PAY</a>
									<input type="hidden" id="receipt_unpaid_category'.$i.'" name="receipt_unpaid_category[]" value="7">
									<input type="hidden" id="receipt_unpaid_item_list'.$i.'" name="receipt_unpaid_item_list[]" value="'.$row_cl['con_list_id'].'">
									<input type="hidden" id="receipt_unpaid_item_id'.$i.'" name="receipt_unpaid_item_id[]" value="'.$row_cl['con_id'].'">
									<input type="hidden" id="receipt_unpaid_item_qty'.$i.'" name="receipt_unpaid_item_qty[]" value="'.$row_cl['qty'].'">
									<input type="hidden" id="receipt_unpaid_item_price'.$i.'" name="receipt_unpaid_item_price[]" value="'.$row_cl['price_cash'].'">
									<input type="hidden" class="receipt_item_description" id="receipt_unpaid_item'.$i.'" name="receipt_unpaid_item[]" value="'.$row_con['consumable'].'">
									<input type="hidden" class="receipt_item_amount" id="receipt_unpaid_item_amount'.$i.'" name="receipt_unpaid_item_amount[]" value="'.$row_cl['amount_cash'].'">
									<input type="hidden" id="receipt_unpaid_item_status'.$i.'" name="receipt_unpaid_item_status[]">
								</td>
							</tr>';
							$total_bill = $total_bill + $row_cl['amount_cash'];
						};
					};
				};
				$total_bill_f = number_format($total_bill, 2, '.', ',');
				echo '<tr>
						<th class="action-td" colspan="4">TOTAL BILL</th>
						<th class="amt-td">'.$total_bill_f.'</th>
					</tr>';
		}

		function save_receipt_patient()
		{
			global $con;
			$receipt_type = 'patient';
			$attend_id = $_POST['attend_id'];
			$patient_id = $_POST['patient_id'];
			$date = $_POST['date'];
			$debit_ledger = $_POST['debit_ledger'];
			$credit_ledger = $_POST['credit_ledger'];
			$received_from = $_POST['received_from'];
			$mode = $_POST['mode'];
			$amount = $_POST['amount'];
			$rec_inst_no = $_POST['rec_inst_no'];
			$rec_bank = $_POST['rec_bank'];
			$rec_branch = $_POST['rec_branch'];
			$narration = $_POST['narration'];
			$company_id = $_SESSION['company_id'];
			$user_id = $_SESSION['user_id'];
			$branch_id = $_SESSION['branch_id'];

			$query = "INSERT INTO `receipt`(
			`company_id`, `attend_id`, `patient_id`, `date`, `ledger_debit`, `ledger_credit`, `name`, 
			`narration`, `amount`, `mode`, `type`, `inst_no`, `bank`, `branch`, `created_by`, 
			`created_time`,`branch_id`) 
			VALUES ('$company_id','$attend_id','$patient_id','$date','$debit_ledger','$credit_ledger',
			'$received_from','$narration','$amount','$mode','$receipt_type','$rec_inst_no','$rec_bank',
			'$rec_branch','$user_id',NOW(),'$branch_id')";
	    	$query_run = mysqli_query($con, $query);
			//$error = mysqli_error($con);
			//echo $error;

	    	if ($query_run) 
			{
				//POST TRANSACTION
				$query = "SELECT * FROM receipt ORDER BY receipt_id DESC";
				$result = mysqli_query($con,$query);
				$row = mysqli_fetch_assoc($result);
				$receipt_id = $row['receipt_id'];
				$_SESSION['receipt_id'] = $row['receipt_id'];

				$query_dr = "INSERT INTO `transactions`(
				`company_id`,`receipt_id`,`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES ('$company_id','$receipt_id','$debit_ledger','$credit_ledger','$attend_id','$patient_id','$date','$amount','$amount',0,'$narration')";
				mysqli_query($con, $query_dr);

				$query_cr = "INSERT INTO `transactions`(
				`company_id`,`receipt_id`,`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES ('$company_id','$receipt_id','$credit_ledger','$debit_ledger','$attend_id','$patient_id','$date','$amount',0,'$amount','$narration')";
				mysqli_query($con, $query_cr);
	            
				$number_as = count($_POST["receipt_paid_category"]);  
				if($number_as > 0)  
				{  
					for($i = 0; $i < $number_as; $i++)  
					{  
						if(trim($_POST["receipt_paid_category"][$i] != '') && trim($_POST["receipt_paid_category"][$i] != 0))  
						{  
							$category = $_POST['receipt_paid_category'][$i];
							$item_list_id = $_POST['receipt_paid_item_list'][$i];
							$item_id = $_POST['receipt_paid_item_id'][$i];
							$item_qty = $_POST['receipt_paid_item_qty'][$i];
							$item_price = $_POST['receipt_paid_item_price'][$i];
							$item_amount = $_POST['receipt_paid_item_amount'][$i];

							$query = "INSERT INTO `receipt_items`(`company_id`, `attend_id`, `patient_id`, 
							`receipt_id`, `date`, `category_id`, `item_id`, `item_list_id`, `qty`, `price`, `amount_rec`, 
							`created_by`, `created_datetime`) 
							VALUES ('$company_id','$attend_id','$patient_id','$receipt_id','$date','$category',
							'$item_id','$item_list_id','$item_qty','$item_price','$item_amount','$user_id',NOW())";
							
							mysqli_query($con, $query);
					   	};
				  	};
				};
	    	};
		}

		function edit_receipt_patient()
		{
			global $con;
			$receipt_id = $_POST['receipt_id'];
			$receipt_details=array();
			$query = "SELECT * FROM receipt WHERE receipt_id='$receipt_id'";
			$result = mysqli_query($con,$query);
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($receipt_details, 
					$row['receipt_id'],$row['patient_id'],$row['attend_id'],$row['date'],$row['ledger_credit'],
					$row['ledger_debit'],$row['name'],$row['narration'],$row['mode'],$row['amount'],$row['type'],
					$row['inst_no'],$row['bank'],$row['branch']
				);
			}
			 echo json_encode($receipt_details);
		}

		function update_receipt_patient()
		{
			global $con;
			$receipt_id = $_POST['receipt_id'];
			$receipt_type = $_POST['receipt_type'];
			$attend_id = $_POST['attend_id'];
			$patient_id = $_POST['patient_id'];
			$date = $_POST['date'];
			$debit_ledger = $_POST['debit_ledger'];
			$credit_ledger = $_POST['credit_ledger'];
			$received_from = $_POST['received_from'];
			$mode = $_POST['mode'];
			$amount = $_POST['amount'];
			$narration = $_POST['received_from'] .':- '. $_POST['narration'];
			$company_id = $_SESSION['company_id'];
			$user_id = $_SESSION['user_id'];
			$branch_id = $_SESSION['branch_id'];

			$query = "UPDATE `receipt` SET 
			`attend_id`='$attend_id', `patient_id`='$patient_id', `date`='$date', `ledger_debit`='$debit_ledger', 
			`ledger_credit`='$credit_ledger', `name`='$received_from', `narration`='$narration', `amount`='$amount', 
			`mode`='$mode', `type`='$receipt_type', `inst_no`='$rec_inst_no', `bank`='$rec_bank', `branch`='$rec_branch',
			`altered_by`='$user_id',`altered_datetime`=NOW()
			WHERE `receipt_id`='$receipt_id'";
	    	$query_run = mysqli_query($con, $query);

	    	if ($query_run) {

	    		//POST TRANSACTION
	    		$query = "DELETE FROM `transactions` WHERE `receipt_id`='$receipt_id'";
	            mysqli_query($con, $query);

	    		$query_dr = "INSERT INTO `transactions`(
                `receipt_id`,`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES ('$receipt_id','$debit_ledger','$credit_ledger','$attend_id','$patient_id','$date','$amount','$amount',0,'$narration')";
                mysqli_query($con, $query_dr);

                $query_cr = "INSERT INTO `transactions`(
                `receipt_id`,`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES ('$receipt_id','$credit_ledger','$debit_ledger','$attend_id','$patient_id','$date','$amount',0,'$amount','$narration')";
                mysqli_query($con, $query_cr);
            	
            	$_SESSION['receipt_id'] = $receipt_id;
	    	};
		}

		function delete_receipt()
		{
			global $con;
			$receipt_id = $_POST['receipt_id'];
			$query = "DELETE FROM `receipt` WHERE receipt_id='$receipt_id'";
			$query_run = mysqli_query($con, $query);
			if ($query_run)
			{
				$query_trans_del = "DELETE FROM `transactions` WHERE `receipt_id`='$receipt_id'";
				mysqli_query($con, $query_trans_del);
			}
			else
			{
				echo "Receipt NOT Deleted";
			};
		}
		
		function reprint_receipt()
		{
			global $con;
			$_SESSION['receipt_id'] = $_POST['receipt_id'];
		}
		
		function search_receipt_by_name()
		{
			global $con;
			$search = $_POST['search'];
			$value = '';
				if(isset($_POST["search"]))
				{
				 $search = mysqli_real_escape_string($con, $_POST["search"]);
				 $query = "SELECT * FROM receipt 
				  WHERE name LIKE '%".$search."%' 
				  OR amount LIKE '%".$search."%' ORDER BY date DESC";
				}
				else
				{
					$query = "SELECT * FROM receipt ORDER BY date DESC";
				}
				$query_run = mysqli_query($con, $query);
				$value.='<table class="table table-hover table-bordered table-sm" id="receiptTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th class="action-td">Receipt No</th>
						<th class="action-td">Date</th>
						<th class="action-td">Cash/Bank A/C</th>
						<th class="action-td">Received From</th>
						<th class="action-td">Amount</th>
						<th class="action-td">Mode</th>
						<th class="action-td">Refund</th>
						<th class="action-td">Action</th>
					</tr>
				</thead>
				<tbody class="pv-table-body">';
					
						if (mysqli_num_rows($query_run) > 0)
						{
							while($row=mysqli_fetch_assoc($query_run))
							{
								$ledger_id = $row['ledger_debit'];
								$query_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
								$query_run_ledger = mysqli_query($con, $query_ledger);
								$row_ledger = mysqli_fetch_assoc($query_run_ledger);
					
								$value.='<tr>
									<td class="action-td">'.$row['receipt_id'].'</td>
									<td class="action-td">
										<a href="#" id="btn_edit_receipt" data-id="'.$row['receipt_id'].'">'.$row['date'].'</a>
									</td>
									<td>'.$row_ledger['ledger_desc'].'</td>
									<td>'.$row['name'].'</td>
									<td class="amt-td">'.$row['amount'].'</td>';
									
										$receipt_id = $row['receipt_id'];
										$query_refund = "SELECT SUM(amount) AS amount FROM refund WHERE receipt_id = '$receipt_id'";
										$query_run_refund = mysqli_query($con, $query_refund);
										$row_refund = mysqli_fetch_assoc($query_run_refund);
								
										$value.='<td>'.$row['mode'].'</td>
									<td class="amt-td">';
										if(isset($row_refund)){$value.= $row_refund['amount'];}else{$value.='N/A';};
									$value.='</td>
									<td class="action-td">
										<a href="#" id="btn_receipt_reprint" data-id="'.$row['receipt_id'].'">Reprint</a>
										|
										<a href="#" id="btn_edit_receipt" data-id="'.$row['receipt_id'].'"><i class="fa fa-edit fa-sm"></i></a>
										|
										<a href="#" 
											id="btn_refund_receipt" 
											data-id="'.$row['receipt_id'].'" 
											data-id1="'.$row['amount'].'"
											data-id2="'.$row['patient_id'].'"
											data-id3="'.$row['attend_id'].'"
											data-id4="'.$row['name'].'"
											data-id5="'.$row['ledger_credit'].'"
											data-id6="'.$row['ledger_debit'].'"
											data-id7="';
											if(isset($row_refund)){$value.= $row_refund['amount'];}else{$value.= 0;};
											$value.='">
											Refund
										</a>
										|
										<a href="#" id="btn_delete_receipt" data-id="'.$row['receipt_id'].'"><i class="fa fa-trash fa-sm"></i></a>
									</td>
								</tr>';
					
							}
						}
						else
						{
							$value.='No Receipt Not Found';
						};
					
						$value.='</tbody>
			</table>';
		                echo $value;
			
		}
		
		function search_receipt_by_date()
		{
			global $con;
			$start = $_POST['start'];
			$end = $_POST['end'];
			$value = '';
				 $query = "SELECT * FROM receipt 
				  WHERE date BETWEEN '$start' AND '$end' ORDER BY date DESC";
				$query_run = mysqli_query($con, $query);
				$value.='<table class="table table-hover table-bordered table-sm" id="receiptTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th class="action-td">Receipt No</th>
						<th class="action-td">Date</th>
						<th class="action-td">Cash/Bank A/C</th>
						<th class="action-td">Received From</th>
						<th class="action-td">Amount</th>
						<th class="action-td">Mode</th>
						<th class="action-td">Refund</th>
						<th class="action-td">Action</th>
					</tr>
				</thead>
				<tbody class="pv-table-body">';
					
						if (mysqli_num_rows($query_run) > 0)
						{
							while($row=mysqli_fetch_assoc($query_run))
							{
								$ledger_id = $row['ledger_debit'];
								$query_ledger = "SELECT * FROM ledgers WHERE ledger_id = '$ledger_id'";
								$query_run_ledger = mysqli_query($con, $query_ledger);
								$row_ledger = mysqli_fetch_assoc($query_run_ledger);
					
								$value.='<tr>
									<td class="action-td">'.$row['receipt_id'].'</td>
									<td class="action-td">
										<a href="#" id="btn_edit_receipt" data-id="'.$row['receipt_id'].'">'.$row['date'].'</a>
									</td>
									<td>'.$row_ledger['ledger_desc'].'</td>
									<td>'.$row['name'].'</td>
									<td class="amt-td">'.$row['amount'].'</td>';
									
										$receipt_id = $row['receipt_id'];
										$query_refund = "SELECT SUM(amount) AS amount FROM refund WHERE receipt_id = '$receipt_id'";
										$query_run_refund = mysqli_query($con, $query_refund);
										$row_refund = mysqli_fetch_assoc($query_run_refund);
								
										$value.='<td>'.$row['mode'].'</td>
									<td class="amt-td">';
										if(isset($row_refund)){$value.= $row_refund['amount'];}else{$value.='N/A';};
									$value.='</td>
									<td class="action-td">
										<a href="#" id="btn_receipt_reprint" data-id="'.$row['receipt_id'].'">Reprint</a>
										|
										<a href="#" id="btn_edit_receipt" data-id="'.$row['receipt_id'].'"><i class="fa fa-edit fa-sm"></i></a>
										|
										<a href="#" 
											id="btn_refund_receipt" 
											data-id="'.$row['receipt_id'].'" 
											data-id1="'.$row['amount'].'"
											data-id2="'.$row['patient_id'].'"
											data-id3="'.$row['attend_id'].'"
											data-id4="'.$row['name'].'"
											data-id5="'.$row['ledger_credit'].'"
											data-id6="'.$row['ledger_debit'].'"
											data-id7="';
											if(isset($row_refund)){$value.= $row_refund['amount'];}else{$value.= 0;};
											$value.='">
											Refund
										</a>
										|
										<a href="#" id="btn_delete_receipt" data-id="'.$row['receipt_id'].'"><i class="fa fa-trash fa-sm"></i></a>
									</td>
								</tr>';
					
							}
						}
						else
						{
							$value.='No Receipt Not Found';
						};
					
						$value.='</tbody>
			</table>';
		                echo $value;
			
		}
		//REFUND
			function save_refund()
			{
				global $con;
				$receipt_id = $_POST['refund_receipt_id'];
				$attend_id = $_POST['refund_attend_id'];
				$patient_id = $_POST['refund_patient_id'];
				$date = $_POST['refund_date'];
				$debit_ledger = $_POST['refund_debit_ledger'];
				$credit_ledger = $_POST['refund_credit_ledger'];
				$amount = $_POST['refund_amount'];
				$reason = $_POST['refund_reason'];
				$company_id = $_SESSION['company_id'];
				$user_id = $_SESSION['user_id'];
				$branch_id = $_SESSION['branch_id'];

				$query = "INSERT INTO `refund`(`company_id`,`receipt_id`,`attend_id`, `patient_id`, `date`, 
				`ledger_debit`, `ledger_credit`, `reason`, `amount`, `branch_id`, `created_by`, `created_datetime`) 
				VALUES ('$company_id','$receipt_id','$attend_id','$patient_id','$date','$debit_ledger',
				'$credit_ledger','$reason','$amount','$branch_id','$user_id',NOW())";
		    	$query_run = mysqli_query($con, $query);
		    	if ($query_run) {

		    		//POST TRANSACTION
			    		$query = "SELECT * FROM refund ORDER BY refund_id DESC";
						$result = mysqli_query($con,$query);
						$row = mysqli_fetch_assoc($result);
						$refund_id = $row['refund_id'];

			    		$query_dr = "INSERT INTO `transactions`(
		                `company_id`,`refund_id`,`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `date`, `amt`, 
						`amt_debit`, `amt_credit`, `narration`, `branch_id`, `created_by`, `created_datetime`) VALUES (
		                '$company_id','$refund_id','$debit_ledger','$credit_ledger','$attend_id','$patient_id','$date',
						'$amount','$amount',0,'$reason','$branch_id','$user_id',NOW())";
		                mysqli_query($con, $query_dr);

		                $query_cr = "INSERT INTO `transactions`(
		                `company_id`,`refund_id`,`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `date`, `amt`, 
						`amt_debit`, `amt_credit`, `narration`, `branch_id`, `created_by`, `created_datetime`) VALUES (
		                '$company_id','$refund_id','$credit_ledger','$debit_ledger','$attend_id','$patient_id','$date',
						'$amount',0,'$amount','$reason','$branch_id','$user_id',NOW())";
		                mysqli_query($con, $query_cr);
		            $_SESSION['refund_id'] = $refund_id;
		    	};
			}

			function edit_refund()
			{
				global $con;
				$refund_id = $_POST['refund_id'];
				$refund_details=array();
				$query = "SELECT * FROM refund WHERE refund_id='$refund_id'";
				$result = mysqli_query($con,$query);
				while($row = mysqli_fetch_assoc($result))
				{
					$receipt_id = $row['receipt_id'];
	                $query_refund = "SELECT SUM(amount) AS amount FROM refund WHERE receipt_id = '$receipt_id'";
	                $query_run_refund = mysqli_query($con, $query_refund);
	                $row_refund = mysqli_fetch_assoc($query_run_refund);

	                $query_receipt = "SELECT * FROM receipt WHERE receipt_id='$receipt_id'";
					$result_receipt = mysqli_query($con,$query_receipt);
	                $row_receipt = mysqli_fetch_assoc($result_receipt);

	                $max_amount = $row_receipt['amount'] - $row_refund['amount'] + $row['amount'];

					array_push($refund_details, 
						$row['refund_id'],$row['receipt_id'],$row['patient_id'],$row['attend_id'],$row['date'],$row['ledger_credit'],
						$row['ledger_debit'],$row['amount'],$row['reason'],$max_amount,$row_receipt['name']
					);
				}
				 echo json_encode($refund_details);
			}

			function update_refund()
			{
				global $con;
				$refund_id = $_POST['refund_id'];
				$receipt_id = $_POST['refund_receipt_id'];
				$attend_id = $_POST['refund_attend_id'];
				$patient_id = $_POST['refund_patient_id'];
				$date = $_POST['refund_date'];
				$debit_ledger = $_POST['refund_debit_ledger'];
				$credit_ledger = $_POST['refund_credit_ledger'];
				$amount = $_POST['refund_amount'];
				$reason = $_POST['refund_reason'];
				$company_id = $_SESSION['company_id'];
				$user_id = $_SESSION['user_id'];
				$branch_id = $_SESSION['branch_id'];

				$query = "UPDATE `refund` SET 
				`receipt_id`='$receipt_id',`attend_id`='$attend_id', `patient_id`='$patient_id', 
				`date`='$date', `ledger_debit`='$debit_ledger', `ledger_credit`='$credit_ledger', `reason`='$reason', 
				`amount`='$amount', `altered_by`='$user_id',`altered_datetime`=NOW() WHERE `refund_id`='$refund_id'";
		    	$query_run = mysqli_query($con, $query);
		    	if ($query_run) {

		    		//POST TRANSACTION
			    		$query = "DELETE FROM `transactions` WHERE `refund_id`='$refund_id'";
						$result = mysqli_query($con,$query);

			    		$query_dr = "INSERT INTO `transactions`(
		                `refund_id`,`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES ('$refund_id','$debit_ledger','$credit_ledger','$attend_id','$patient_id','$date','$amount','$amount',0,'$reason')";
		                mysqli_query($con, $query_dr);

		                $query_cr = "INSERT INTO `transactions`(
		                `refund_id`,`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `narration`) VALUES ('$refund_id','$credit_ledger','$debit_ledger','$attend_id','$patient_id','$date','$amount',0,'$amount','$reason')";
		                mysqli_query($con, $query_cr);
		            $_SESSION['refund_id'] = $refund_id;
		    	};
		    	//$error = mysqli_error($con);
		    	//echo $error
			}
		//DISCOUNT
			function save_discount()
			{
				global $con;
				$type = $_POST['discount_type'];
				$item_list_id = $_POST['discount_item_list_id'];
				$attend_id = $_POST['discount_attend_id'];
				$patient_id = $_POST['discount_patient_id'];
				$date = $_POST['discount_date'];
				$debit_ledger = $_POST['discount_debit_ledger'];
				$credit_ledger = $_POST['discount_credit_ledger'];
				$amount = $_POST['discount_amount'];
				$reason = $_POST['discount_reason'];
				$company_id = $_SESSION['company_id'];
				$user_id = $_SESSION['user_id'];
				$branch_id = $_SESSION['branch_id'];

				if ($type == 'labs') 
				{
					$query = "INSERT INTO `discount`(
					`company_id`,`lab_list_id`,`attend_id`, `patient_id`, `date`, `ledger_debit`, `ledger_credit`, 
					`reason`, `amount`, `type`, `branch_id`, `created_by`, `created_datetime`) 
					VALUES ('$company_id','$item_list_id','$attend_id','$patient_id','$date','$debit_ledger',
					'$credit_ledger','$reason','$amount','$type','$branch_id','$user_id',NOW())";
				}
				else if($type == 'surgery')
				{
					$query = "INSERT INTO `discount`(
					`company_id`,`surgery_list_id`,`attend_id`, `patient_id`, `date`, `ledger_debit`, `ledger_credit`, 
					`reason`, `amount`, `type`, `branch_id`, `created_by`, `created_datetime`) 
					VALUES ('$company_id','$item_list_id','$attend_id','$patient_id','$date','$debit_ledger',
					'$credit_ledger','$reason','$amount','$type','$branch_id','$user_id',NOW())";
				}
				else if($type == 'service')
				{
					$query = "INSERT INTO `discount`(
					`company_id`,`service_list_id`,`attend_id`, `patient_id`, `date`, `ledger_debit`, `ledger_credit`, 
					`reason`, `amount`, `type`, `branch_id`, `created_by`, `created_datetime`) 
					VALUES ('$company_id','$item_list_id','$attend_id','$patient_id','$date','$debit_ledger',
					'$credit_ledger','$reason','$amount','$type','$branch_id','$user_id',NOW())";
				}
				else if($type == 'consumable')
				{
					$query = "INSERT INTO `discount`(
					`company_id`,`con_list_id`,`attend_id`, `patient_id`, `date`, `ledger_debit`, `ledger_credit`, 
					`reason`, `amount`, `type`, `branch_id`, `created_by`, `created_datetime`) 
					VALUES ('$company_id','$item_list_id','$attend_id','$patient_id','$date','$debit_ledger',
					'$credit_ledger','$reason','$amount','$type','$branch_id','$user_id',NOW())";
				}
				else if($type == 'drug')
				{
					$query = "INSERT INTO `discount`(
					`company_id`,`drug_list_id`,`attend_id`, `patient_id`, `date`, `ledger_debit`, `ledger_credit`, 
					`reason`, `amount`, `type`, `branch_id`, `created_by`, `created_datetime`) 
					VALUES ('$company_id','$item_list_id','$attend_id','$patient_id','$date','$debit_ledger',
					'$credit_ledger','$reason','$amount','$type','$branch_id','$user_id',NOW())";
				}
				else if($type == 'radiology')
				{
					$query = "INSERT INTO `discount`(
					`company_id`,`radio_list_id`,`attend_id`, `patient_id`, `date`, `ledger_debit`, `ledger_credit`, 
					`reason`, `amount`, `type`, `branch_id`, `created_by`, `created_datetime`) 
					VALUES ('$company_id','$item_list_id','$attend_id','$patient_id','$date','$debit_ledger',
					'$credit_ledger','$reason','$amount','$type','$branch_id','$user_id',NOW())";
				};
		    	$query_run = mysqli_query($con, $query);

		    	if ($query_run) {

		    		//POST TRANSACTION
			    		$query = "SELECT * FROM discount ORDER BY discount_id DESC";
						$result = mysqli_query($con,$query);
						$row = mysqli_fetch_assoc($result);
						$discount_id = $row['discount_id'];

			    		$query_dr = "INSERT INTO `transactions`(
		                `company_id`,`discount_id`,`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `date`, 
						`amt`, `amt_debit`, `amt_credit`, `narration`, `branch_id`, `created_by`, `created_datetime`) 
						VALUES ('$company_id','$discount_id','$debit_ledger','$credit_ledger','$attend_id','$patient_id',
						'$date','$amount','$amount',0,'$reason','$branch_id','$user_id',NOW())";
		                mysqli_query($con, $query_dr);

		                $query_cr = "INSERT INTO `transactions`(
		                `company_id`,`discount_id`,`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `date`,
						 `amt`, `amt_debit`, `amt_credit`, `narration`, `branch_id`, `created_by`, `created_datetime`) 
						 VALUES ('$company_id','$discount_id','$credit_ledger','$debit_ledger','$attend_id','$patient_id',
						 '$date','$amount',0,'$amount','$reason','$branch_id','$user_id',NOW())";
		                mysqli_query($con, $query_cr);
		            $_SESSION['discount_id'] = $discount_id;
		    	};
			}

			function edit_discount()
			{
				global $con;
				$discount_id = $_POST['discount_id'];
				$discount_details=array();
				$query = "SELECT * FROM discount WHERE discount_id='$discount_id'";
				$result = mysqli_query($con,$query);
				while($row = mysqli_fetch_assoc($result))
				{
	                $type = $row['type'];
                    if ($type == 'labs') 
                    {
                        $lab_list_id = $row['lab_list_id'];
                        $query_bill = "SELECT * FROM lab_list WHERE lab_list_id = '$lab_list_id'";
                        $query_run_bill = mysqli_query($con, $query_bill);
                        $row_bill = mysqli_fetch_assoc($query_run_bill);
                        $item_list_id = $row_bill['lab_list_id'];
                        $bill_amount = $row_bill['amount_cash'];

                        $query_discount = "SELECT SUM(amount) AS amount FROM discount WHERE lab_list_id = '$lab_list_id'";
	                	$query_run_discount = mysqli_query($con, $query_discount);
	                	$row_discount = mysqli_fetch_assoc($query_run_discount);
	                	$discount_amount = $row_discount['amount'];
                    } 
                    else if($type == 'surgery') 
                    {
                        $surgery_list_id = $row['surgery_list_id'];
                        $query_bill = "SELECT * FROM surgery_list WHERE surgery_list_id = '$surgery_list_id'";
                        $query_run_bill = mysqli_query($con, $query_bill);
                        $row_bill = mysqli_fetch_assoc($query_run_bill);
                        $item_list_id = $row_bill['surgery_list_id'];
                        $bill_amount = $row_bill['amount_cash'];

                        $query_discount = "SELECT SUM(amount) AS amount FROM discount WHERE surgery_list_id = '$surgery_list_id'";
	                	$query_run_discount = mysqli_query($con, $query_discount);
	                	$row_discount = mysqli_fetch_assoc($query_run_discount);
	                	$discount_amount = $row_discount['amount'];
                    } 
                    else if($type == 'service') 
                    {
                        $service_list_id = $row['service_list_id'];
                        $query_bill = "SELECT * FROM service_list WHERE service_list_id = '$service_list_id'";
                        $query_run_bill = mysqli_query($con, $query_bill);
                        $row_bill = mysqli_fetch_assoc($query_run_bill);
                        $item_list_id = $row_bill['service_list_id'];
                        $bill_amount = $row_bill['amount_cash'];

                        $query_discount = "SELECT SUM(amount) AS amount FROM discount WHERE service_list_id = '$service_list_id'";
	                	$query_run_discount = mysqli_query($con, $query_discount);
	                	$row_discount = mysqli_fetch_assoc($query_run_discount);
	                	$discount_amount = $row_discount['amount'];
                    } 
                    else if($type == 'consumable') 
                    {
                        $con_list_id = $row['con_list_id'];
                        $query_bill = "SELECT * FROM consumable_list WHERE con_list_id = '$con_list_id'";
                        $query_run_bill = mysqli_query($con, $query_bill);
                        $row_bill = mysqli_fetch_assoc($query_run_bill);
                        $item_list_id = $row_bill['con_list_id'];
                        $bill_amount = $row_bill['amount_cash'];

                        $query_discount = "SELECT SUM(amount) AS amount FROM discount WHERE con_list_id = '$con_list_id'";
	                	$query_run_discount = mysqli_query($con, $query_discount);
	                	$row_discount = mysqli_fetch_assoc($query_run_discount);
	                	$discount_amount = $row_discount['amount'];
                    } 
                    else if($type == 'drug') 
                    {
                        $drug_list_id = $row['drug_list_id'];
                        $query_bill = "SELECT SUM(amt_cash) AS amount_cash FROM  drug_dispense_list WHERE drug_list_id='$drug_list_id'";
                        $query_run_bill = mysqli_query($con, $query_bill);
                        $row_bill = mysqli_fetch_assoc($query_run_bill);
                        $item_list_id = $row['drug_list_id'];
                        $bill_amount = $row_bill['amount_cash'];

                        $query_discount = "SELECT SUM(amount) AS amount FROM discount WHERE drug_list_id = '$drug_list_id'";
	                	$query_run_discount = mysqli_query($con, $query_discount);
	                	$row_discount = mysqli_fetch_assoc($query_run_discount);
	                	$discount_amount = $row_discount['amount'];
                    } 
                    else if($type == 'radiology') 
                    {
                        $radio_list_id = $row['radio_list_id'];
                        $query_bill = "SELECT * FROM radio_list WHERE radio_list_id = '$radio_list_id'";
                        $query_run_bill = mysqli_query($con, $query_bill);
                        $row_bill = mysqli_fetch_assoc($query_run_bill);
                        $item_list_id = $row_bill['radio_list_id'];
                        $bill_amount = $row_bill['amount_cash'];

                        $query_discount = "SELECT SUM(amount) AS amount FROM discount WHERE radio_list_id = '$radio_list_id'";
	                	$query_run_discount = mysqli_query($con, $query_discount);
	                	$row_discount = mysqli_fetch_assoc($query_run_discount);
	                	$discount_amount = $row_discount['amount'];
                    };

                    $patient_id = $row['patient_id'];
                    $query_patient = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
                    $query_run_patient = mysqli_query($con, $query_patient);
                    $row_patient = mysqli_fetch_assoc($query_run_patient);
                    $name = $row_patient['firstName'].' '.$row_patient['lastName'];
	                $max_amount = $bill_amount - $discount_amount + $row['amount'];

					array_push($discount_details, 
						$row['discount_id'],$item_list_id,$row['patient_id'],$row['attend_id'],$row['date'],$row['ledger_credit'],
						$row['ledger_debit'],$row['amount'],$row['reason'],$max_amount,$name,$row['type']
					);
				}
				 echo json_encode($discount_details);
			}

			function update_discount()
			{
				global $con;
				$discount_id = $_POST['discount_id'];
				$type = $_POST['discount_type'];
				$item_list_id = $_POST['discount_item_list_id'];
				$attend_id = $_POST['discount_attend_id'];
				$patient_id = $_POST['discount_patient_id'];
				$date = $_POST['discount_date'];
				$debit_ledger = $_POST['discount_debit_ledger'];
				$credit_ledger = $_POST['discount_credit_ledger'];
				$amount = $_POST['discount_amount'];
				$reason = $_POST['discount_reason'];
				$company_id = $_SESSION['company_id'];
				$user_id = $_SESSION['user_id'];
				$branch_id = $_SESSION['branch_id'];
				if ($type == 'labs') 
				{
					$query = "UPDATE `discount` SET
					`lab_list_id`='$item_list_id',`attend_id`='$attend_id', `patient_id`='$patient_id', `date`='$date', `ledger_debit`='$debit_ledger', 
					`ledger_credit`='$credit_ledger', `reason`='$reason', `amount`='$amount', `type`='$type',
					`altered_by`='$user_id', `altered_datetime`=NOW()
					 WHERE `discount_id`='$discount_id'";
				}
				else if($type == 'surgery')
				{
					$query = "UPDATE `discount` SET
					`surgery_list_id`='$item_list_id',`attend_id`='$attend_id', `patient_id`='$patient_id', `date`='$date', `ledger_debit`='$debit_ledger', 
					`ledger_credit`='$credit_ledger', `reason`='$reason', `amount`='$amount', `type`='$type',
					`altered_by`='$user_id', `altered_datetime`=NOW() WHERE `discount_id`='$discount_id'";
				}
				else if($type == 'service')
				{
					$query = "UPDATE `discount` SET
					`service_list_id`='$item_list_id',`attend_id`='$attend_id', `patient_id`='$patient_id', `date`='$date', `ledger_debit`='$debit_ledger', 
					`ledger_credit`='$credit_ledger', `reason`='$reason', `amount`='$amount', `type`='$type',
					`altered_by`='$user_id', `altered_datetime`=NOW() WHERE `discount_id`='$discount_id'";
				}
				else if($type == 'consumable')
				{
					$query = "UPDATE `discount` SET
					`con_list_id`='$item_list_id',`attend_id`='$attend_id', `patient_id`='$patient_id', `date`='$date', `ledger_debit`='$debit_ledger', 
					`ledger_credit`='$credit_ledger', `reason`='$reason', `amount`='$amount', `type`='$type',
					`altered_by`='$user_id', `altered_datetime`=NOW() WHERE `discount_id`='$discount_id'";
				}
				else if($type == 'drug')
				{
					$query = "UPDATE `discount` SET
					`drug_list_id`='$item_list_id',`attend_id`='$attend_id', `patient_id`='$patient_id', `date`='$date', `ledger_debit`='$debit_ledger', 
					`ledger_credit`='$credit_ledger', `reason`='$reason', `amount`='$amount', `type`='$type',
					`altered_by`='$user_id', `altered_datetime`=NOW() WHERE `discount_id`='$discount_id'";
				}
				else if($type == 'radiology')
				{
					$query = "UPDATE `discount` SET
					`radio_list_id`='$item_list_id',`attend_id`='$attend_id', `patient_id`='$patient_id', `date`='$date', `ledger_debit`='$debit_ledger', 
					`ledger_credit`='$credit_ledger', `reason`='$reason', `amount`='$amount', `type`='$type',
					`altered_by`='$user_id', `altered_datetime`=NOW() WHERE `discount_id`='$discount_id'";
				};
		    	$query_run = mysqli_query($con, $query);

		    	if ($query_run) 
				{
		    		//POST TRANSACTION
			    		$query = "DELETE FROM `transactions` WHERE `discount_id`='$discount_id'";
						$result = mysqli_query($con,$query);

			    		$query_dr = "INSERT INTO `transactions`(
		                `discount_id`,`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `date`, `amt`, `amt_debit`, 
						`amt_credit`, `narration`, `branch_id`, `created_by`, `created_datetime`) VALUES ('$discount_id',
						'$debit_ledger','$credit_ledger','$attend_id','$patient_id','$date','$amount','$amount',0,
						'$reason','$branch_id','$user_id',NOW())";
		                mysqli_query($con, $query_dr);

		                $query_cr = "INSERT INTO `transactions`(
		                `discount_id`,`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `date`, `amt`, `amt_debit`, 
						`amt_credit`, `narration`, `branch_id`, `created_by`, `created_datetime`) VALUES ('$discount_id',
						'$credit_ledger','$debit_ledger','$attend_id','$patient_id','$date','$amount',0,'$amount',
						'$reason','$branch_id','$user_id',NOW())";
		                mysqli_query($con, $query_cr);
		            $_SESSION['discount_id'] = $discount_id;
		    	};
			}
	
?>
