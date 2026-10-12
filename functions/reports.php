<?php
	//session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
	//STOCK REPORT
		function stock_report_display()
		{
			global $con;
			$_SESSION['stock_report_company_id'] = $_POST['stock_report_company_id'];
			$_SESSION['stock_report_user_id'] = $_POST['stock_report_user_id'];
			$_SESSION['stock_report_user_super_id'] = $_POST['stock_report_user_super_id'];
			$_SESSION['stock_report_warehouse'] = $_POST['stock_report_warehouse'];
			$_SESSION['stock_report_start_date'] = $_POST['stock_report_start_date'];
			$_SESSION['stock_report_end_date'] = $_POST['stock_report_end_date'];
		}

		function stock_report_item_tally_card()
		{
			global $con;
			$_SESSION['stock_report_item_tally_card_item_id'] = $_POST['item_id'];
			$_SESSION['stock_report_item_tally_card_category_id'] = $_POST['category_id'];
			$_SESSION['stock_report_item_tally_card_warehouse_id'] = $_POST['warehouse_id'];
			$_SESSION['stock_report_item_tally_card_start_date'] = $_POST['start_date'];
			$_SESSION['stock_report_item_tally_card_end_date'] = $_POST['end_date'];
			$_SESSION['stock_report_item_tally_card_company_id'] = $_POST['company_id'];
		}
	//DISPENSED REPORT
		function dispensed_report_display()
		{
			global $con;
			$_SESSION['dispensed_report_warehouse'] = $_POST['dispensed_report_warehouse'];
			$_SESSION['dispensed_report_start_date'] = $_POST['dispensed_report_start_date'];
			$_SESSION['dispensed_report_end_date'] = $_POST['dispensed_report_end_date'];
		}

		function dispensed_report_item()
		{
			global $con;
			$_SESSION['dispensed_report_item_item_id'] = $_POST['item_id'];
			$_SESSION['dispensed_report_item_category_id'] = $_POST['category_id'];
			$_SESSION['dispensed_report_item_warehouse_id'] = $_POST['warehouse_id'];
			$_SESSION['dispensed_report_item_start_date'] = $_POST['start_date'];
			$_SESSION['dispensed_report_item_end_date'] = $_POST['end_date'];
		}
//REPORTS
	//PURCHASE REPORT
		function purchase_report_display()
		{
			global $con;
			$_SESSION['purch_report_company_id'] = $_POST['company_id'];
			$_SESSION['purch_report_user_id'] = $_POST['user_id'];
			$_SESSION['purch_report_user_super_id'] = $_POST['user_super_id'];
			$_SESSION['purch_report_start_date'] = $_POST['start_date'];
			$_SESSION['purch_report_end_date'] = $_POST['end_date'];
		}
	//SALES REPORT
		function sales_report_display()
		{
			global $con;
			$_SESSION['sales_report_company_id'] = $_POST['company_id_sales'];
			$_SESSION['sales_report_user_id'] = $_POST['user_id_sales'];
			$_SESSION['sales_report_user_super_id'] = $_POST['user_super_id_sales'];
			$_SESSION['sales_report_start_date'] = $_POST['start_date_sales'];
			$_SESSION['sales_report_end_date'] = $_POST['end_date_sales'];
		}
	//LEDGER REPORT
		function ledger_report_display()
		{
			global $con;
			$_SESSION['ledger_report_company_id'] = $_POST['ledger_report_company_id'];
			$_SESSION['ledger_report_user_id'] = $_POST['ledger_report_user_id'];
			$_SESSION['ledger_report_user_super_id'] = $_POST['ledger_report_user_super_id'];
			$_SESSION['ledger_report_ledger_id'] = $_POST['ledger_report_ledger_id'];
			$_SESSION['ledger_report_start_date'] = $_POST['ledger_report_start_date'];
			$_SESSION['ledger_report_end_date'] = $_POST['ledger_report_end_date'];
		}
	//LEDGER DETAIL REPORT
		function ledger_detail_report_display()
		{
			global $con;
			$_SESSION['ledger_detail_report_company_id'] = $_POST['ledger_detail_report_company_id'];
			$_SESSION['ledger_detail_report_user_id'] = $_POST['ledger_detail_report_user_id'];
			$_SESSION['ledger_detail_report_user_super_id'] = $_POST['ledger_detail_report_user_super_id'];
			$_SESSION['ledger_detail_report_start_date'] = $_POST['ledger_detail_report_start_date'];
			$_SESSION['ledger_detail_report_end_date'] = $_POST['ledger_detail_report_end_date'];
		}
	//LEDGER SUMMARY REPORT
		function ledger_summary_report_display()
		{
			global $con;
			$_SESSION['ledger_summary_report_company_id'] = $_POST['ledger_summary_report_company_id'];
			$_SESSION['ledger_summary_report_user_id'] = $_POST['ledger_summary_report_user_id'];
			$_SESSION['ledger_summary_report_user_super_id'] = $_POST['ledger_summary_report_user_super_id'];
			$_SESSION['ledger_summary_report_start_date'] = $_POST['ledger_summary_report_start_date'];
			$_SESSION['ledger_summary_report_end_date'] = $_POST['ledger_summary_report_end_date'];
		}
	//ATTENDANCE SUMMARY REPORT
		function attend_summary_report_display()
		{
			global $con;
			$_SESSION['attend_summary_report_company_id'] = $_POST['attend_summary_report_company_id'];
			$_SESSION['attend_summary_report_user_id'] = $_POST['attend_summary_report_user_id'];
			$_SESSION['attend_summary_report_user_super_id'] = $_POST['attend_summary_report_user_super_id'];
			$_SESSION['attend_summary_report_start_date'] = $_POST['attend_summary_report_start_date'];
			$_SESSION['attend_summary_report_end_date'] = $_POST['attend_summary_report_end_date'];
		}

		function attend_detail_report_display()
		{
			global $con;
			$_SESSION['attend_detail_report_attend_id'] = $_POST['attend_id'];
			$_SESSION['attend_detail_report_patient_id'] = $_POST['patient_id'];
			$_SESSION['attend_detail_report_company_id'] = $_POST['company_id'];
			$_SESSION['attend_detail_report_date_admit'] = $_POST['date_admit'];
			$_SESSION['attend_detail_report_date_disch'] = $_POST['date_disch'];
			$_SESSION['attend_detail_report_name'] = $_POST['name'];
			$_SESSION['attend_detail_report_start_date'] = $_POST['start_date'];
			$_SESSION['attend_detail_report_end_date'] = $_POST['end_date'];
		}
	//NHIS SPECIALTY REPORT
		function nhis_specialty_report_display()
		{
			global $con;
			$_SESSION['nhis_specialty_report_company_id'] = $_POST['nhis_specialty_report_company_id'];
			$_SESSION['nhis_specialty_report_user_id'] = $_POST['nhis_specialty_report_user_id'];
			$_SESSION['nhis_specialty_report_user_super_id'] = $_POST['nhis_specialty_report_user_super_id'];
			$_SESSION['nhis_specialty_report_start_date'] = $_POST['nhis_specialty_report_start_date'];
			$_SESSION['nhis_specialty_report_end_date'] = $_POST['nhis_specialty_report_end_date'];
		}
		
		function nhis_specialty_detail_report_display_xml()
		{
			global $con;
			$_SESSION['nhis_specialty_report_xml_company_id'] = $_POST['company_id'];
			$_SESSION['nhis_specialty_report_xml_start_date'] = $_POST['start_date'];
			$_SESSION['nhis_specialty_report_xml_end_date'] = $_POST['end_date'];
		}

		function nhis_specialty_detail_report_display()
		{
			global $con;
			$_SESSION['nhis_specialty_detail_report_company_id'] = $_POST['nhis_specialty_detail_report_company_id'];
			$_SESSION['nhis_specialty_detail_report_user_id'] = $_POST['nhis_specialty_detail_report_user_id'];
			$_SESSION['nhis_specialty_detail_report_user_super_id'] = $_POST['nhis_specialty_detail_report_user_super_id'];
			$_SESSION['nhis_specialty_detail_report_start_date'] = $_POST['nhis_specialty_detail_report_start_date'];
			$_SESSION['nhis_specialty_detail_report_end_date'] = $_POST['nhis_specialty_detail_report_end_date'];
		}

		function nhis_open_claim_form()
		{
			global $con;
			$_SESSION['nhis_claim_payment_type_id'] = $_POST['payment_type_id'];
			$_SESSION['nhis_claim_attend_id'] = $_POST['attend_id'];
			$_SESSION['nhis_claim_patient_id'] = $_POST['patient_id'];
		}

		function nhis_procedure_list_edit()
		{
			global $con;
			$surgery_list_id = $_POST['surgery_list_id'];
			$surgery_list_details = array();
			$query = "SELECT * FROM surgery_list WHERE surgery_list_id ='$surgery_list_id'";
			$result = mysqli_query($con,$query);
			while($row = mysqli_fetch_assoc($result))
			{
				$nhis_id = $row['nhis_id'];
				$query_nhis = "SELECT * FROM nhis WHERE nhis_id ='$nhis_id'";
				$result_nhis = mysqli_query($con,$query_nhis);
				$row_nhis = mysqli_fetch_assoc($result_nhis);

				$surgery_id = $row['surgery_id'];
				$query_surgery = "SELECT * FROM surgery WHERE surgery_id ='$surgery_id'";
				$result_surgery = mysqli_query($con,$query_surgery);
				$row_surgery = mysqli_fetch_assoc($result_surgery);

				array_push($surgery_list_details, 
					$row['surgery_list_id'], $row['date'], $row['is_principal'], $row['amount_nhis'],
					$row['nhis_id'], $row_nhis['nhis_item_desc'], $row['surgery_id'], $row_surgery['icd_10'],
					$row['comment'], $row['amount_cash'], $row['amount_prvt'], $row['attend_id'], $row['patient_id']
				);
			}
			 echo json_encode($surgery_list_details);
		}

		function nhis_procedure_list_change_gdrg()
		{
			global $con;
			$nhis_id = $_POST['nhis_id'];
			$gdrg_details = array();
			$query_nhis = "SELECT * FROM nhis WHERE nhis_id ='$nhis_id'";
			$result_nhis = mysqli_query($con,$query_nhis);
			$row_nhis = mysqli_fetch_assoc($result_nhis);
			array_push($gdrg_details, 
					$row_nhis['nhis_item_desc'],$row_nhis['price_adult'],$row_nhis['price_child']
				);
			echo json_encode($gdrg_details);
		}

		function nhis_procedure_list_change_diagnosis()
		{
			global $con;
			$surgery_id = $_POST['surgery_id'];
			$surgery_details = array();
			$query_surgery = "SELECT * FROM surgery WHERE surgery_id ='$surgery_id'";
			$result_surgery = mysqli_query($con,$query_surgery);
			$row_surgery = mysqli_fetch_assoc($result_surgery);
			array_push($surgery_details, 
					$row_surgery['icd_10']
				);
			echo json_encode($surgery_details);
		}

		function nhis_procedure_list_update()
		{
			global $con;
			$surgery_list_id = $_POST['nhis_surgerylist_id'];
			$payment_type_id = $_POST['nhis_procedure_payment_type_id'];
			$nhis_id = $_POST['nhis_procedure_gdrg'];
			$amount_nhis = $_POST['nhis_procedure_amount'];
			$amount_cash = $_POST['nhis_procedure_amount_cash'];
			$amount_prvt = $_POST['nhis_procedure_amount_prvt'];
			$surgery_id = $_POST['nhis_procedure_diagnosis'];
			$date = $_POST['nhis_procedure_date'];
			$is_principal = $_POST['nhis_procedure_is_principal'];
			$comment = $_POST['nhis_procedure_comment'];
			$attend_id = $_POST['attend_id'];
			$patient_id = $_POST['patient_id'];
			$prvt_led_id = 0;

			if($is_principal == 'Yes')
			{
				$query = "UPDATE `surgery_list` SET `is_principal`='No' WHERE `attend_id`='$attend_id'";
				$query_run = mysqli_query($con, $query);
				$query = "UPDATE `diagnosis_list` SET `is_principal`='No' WHERE `attend_id`='$attend_id'";
				$query_run = mysqli_query($con, $query);
				$query = "UPDATE `payment_type` SET `principal_gdrg`='$nhis_id', `principal_amt`='$amount_nhis' 
				WHERE `payment_type_id`='$payment_type_id'";
				$query_run = mysqli_query($con, $query);
			};

			$query = "UPDATE `surgery_list` SET 
			`surgery_id`='$surgery_id',`comment`='$comment',`price_nhis`='$amount_nhis',
			`amount_nhis`='$amount_nhis',`date`='$date',`nhis_id`='$nhis_id',
			`is_principal`='$is_principal' WHERE `surgery_list_id`='$surgery_list_id'";
			$query_run = mysqli_query($con, $query);
			
			if ($query_run)
			{
				//POST TRANSACTION

					$query_trans = "SELECT * FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=5 
					AND `item_list_id`='$surgery_list_id'";
					$query_run_trans = mysqli_query($con, $query_trans);
					if (mysqli_num_rows($query_run_trans) > 0)
					{
						$query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND 
						`category_id`=5 AND `item_list_id`='$surgery_list_id'";
						mysqli_query($con, $query_trans_del);
						if ($amount_cash > 0)
						{
							$query_dr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (1,8,
							'$attend_id','$patient_id',5,'$date','$amount_cash','$amount_cash',0,'$surgery_list_id',
							'$surgery_list_id','surgery for cash')";
							mysqli_query($con, $query_dr);

							$query_cr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (8,1,
							'$attend_id','$patient_id',5,'$date','$amount_cash',0,'$amount_cash','$surgery_list_id',
							'$surgery_list_id','surgery for cash')";
							mysqli_query($con, $query_cr);
						}
						if ($amount_prvt > 0)
						{
							$query_dr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (
							'$prvt_led_id',8,'$attend_id','$patient_id',5,'$date','$amount_prvt','$amount_prvt',0,
							'$surgery_list_id','$surgery_list_id','surgery for NHIS')";
							mysqli_query($con, $query_dr);

							$query_cr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (8,
							'$prvt_led_id','$attend_id','$patient_id',5,'$date','$amount_prvt',0,'$amount_prvt',
							'$surgery_list_id''$surgery_list_id','surgery for NHIS')";
							mysqli_query($con, $query_cr);
						}
						if ($amount_nhis > 0)
						{
							$query_dr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (2,8,
							'$attend_id','$patient_id',5,'$date','$amount_nhis','$amount_nhis',0,'$surgery_list_id',
							'$surgery_list_id','surgery for NHIS')";
							mysqli_query($con, $query_dr);

							$query_cr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (8,2,
							'$attend_id','$patient_id',5,'$date','$amount_nhis',0,'$amount_nhis','$surgery_list_id',
							'$surgery_list_id','surgery for NHIS')";
							mysqli_query($con, $query_cr);
						};
					}
					else
					{
						if ($amount_cash > 0)
						{
							$query_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
							`patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
							`surgery_list_id`, `narration`) VALUES (1,8,'$attend_id','$patient_id',5,'$date',
							'$amount_cash','$amount_cash',0,'$surgery_list_id','$surgery_list_id','surgery for cash')";
							mysqli_query($con, $query_dr);
							
							$query_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
							`patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
							`surgery_list_id`, `narration`) VALUES (8,1,'$attend_id','$patient_id',5,'$date','$amount_cash',
							0,'$amount_cash','$surgery_list_id','$surgery_list_id','surgery for cash')";
							mysqli_query($con, $query_cr);
						}
						if ($amount_prvt > 0)
						{
							$query_dr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (
							'$prvt_led_id',8,'$attend_id','$patient_id',5,'$date','$amount_prvt','$amount_prvt',0,
							'$surgery_list_id','$surgery_list_id','surgery for NHIS')";
							mysqli_query($con, $query_dr);

							$query_cr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (8,
							'$prvt_led_id','$attend_id','$patient_id',5,'$date','$amount_prvt',0,'$amount_prvt',
							'$surgery_list_id','$surgery_list_id','surgery for NHIS')";
							mysqli_query($con, $query_cr);
						}
						if ($amount_nhis > 0)
						{
							$query_dr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (2,8,
							'$attend_id','$patient_id',5,'$date','$amount_nhis','$amount_nhis',0,'$surgery_list_id',
							'$surgery_list_id','surgery for NHIS')";
							mysqli_query($con, $query_dr);

							$query_cr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (8,2,
							'$attend_id','$patient_id',5,'$date','$amount_nhis',0,'$amount_nhis','$surgery_list_id',
							'$surgery_list_id','surgery for NHIS')";
							mysqli_query($con, $query_cr);
						};
					};
				//view_current_surgery();
			}
			else
			{
				echo "Surgery NOT Updated";
			};
		}

		function nhis_procedure_list_save()
		{
			global $con;
			//$surgery_list_id = $_POST['nhis_surgerylist_id'];
			$payment_type_id = $_POST['nhis_procedure_payment_type_id'];
			$nhis_id = $_POST['nhis_procedure_gdrg'];
			$amount_nhis = $_POST['nhis_procedure_amount'];
			$amount_cash = $_POST['nhis_procedure_amount_cash'];
			$amount_prvt = $_POST['nhis_procedure_amount_prvt'];
			$surgery_id = $_POST['nhis_procedure_diagnosis'];
			$date = $_POST['nhis_procedure_date'];
			$is_principal = $_POST['nhis_procedure_is_principal'];
			$comment = $_POST['nhis_procedure_comment'];
			$attend_id = $_POST['attend_id'];
			$patient_id = $_POST['patient_id'];
			$prvt_led_id = 0;
			$procqty = 1;
			$company_id = $_SESSION['company_id'];
			$user_id = $_SESSION['user_id'];

			if($is_principal == 'Yes')
			{
				$query = "SELECT * FROM `surgery_list` WHERE `attend_id`='$attend_id'";
				$query_run = mysqli_query($con, $query);
				if(mysqli_num_rows($query_run) > 0)
				{
					$query = "UPDATE `surgery_list` SET `is_principal`='No' WHERE `attend_id`='$attend_id'";
					mysqli_query($con, $query);
				};
				$query = "SELECT * FROM `diagnosis_list` WHERE `attend_id`='$attend_id'";
				$query_run = mysqli_query($con, $query);
				if(mysqli_num_rows($query_run) > 0)
				{
					$query = "UPDATE `diagnosis_list` SET `is_principal`='No' WHERE `attend_id`='$attend_id'";
					mysqli_query($con, $query);
				};
				$query = "UPDATE `payment_type` SET `principal_gdrg`='$nhis_id', `principal_amt`='$amount_nhis' 
				WHERE `payment_type_id`='$payment_type_id'";
				mysqli_query($con, $query);
			};

			$query = "INSERT INTO `surgery_list`(`company_id`,`surgery_id`, `attend_id`, 
			`patient_id`, `comment`, `qty`, `price_cash`, `amount_cash`, `date`, 
			`amount_prvt`, `amount_nhis`, `price_prvt`, `price_nhis`, `ledger_id`, `nhis_id`,
			`is_principal`, `user_id`, `created_by`, `created_datetime`) 
			VALUES ('$company_id','$surgery_id','$attend_id','$patient_id','$comment',
			'$procqty','$amount_cash','$amount_prvt','$date','$amount_prvt','$amount_nhis',
			'$amount_prvt','$amount_nhis',2,'$nhis_id','$is_principal','$user_id',
			'$user_id',NOW())";
			$query_run = mysqli_query($con, $query);
			
			if ($query_run)
			{
				$query_surgery_list = "SELECT * FROM `surgery_list` ORDER BY `surgery_list_id` DESC";
				$query_run_surgery_list = mysqli_query($con, $query_surgery_list);
				$row_surgery_list=mysqli_fetch_assoc($query_run_surgery_list);
				$surgery_list_id = $row_surgery_list['surgery_list_id'];

				//POST TRANSACTION
					if ($amount_cash > 0)
					{
						$query_dr = "INSERT INTO `transactions`(
						`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
						`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (1,8,
						'$attend_id','$patient_id',5,'$date','$amount_cash','$amount_cash',0,'$surgery_list_id',
						'$surgery_list_id','surgery for cash')";
						mysqli_query($con, $query_dr);

						$query_cr = "INSERT INTO `transactions`(
						`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
						`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (8,1,
						'$attend_id','$patient_id',5,'$date','$amount_cash',0,'$amount_cash','$surgery_list_id',
						'$surgery_list_id','surgery for cash')";
						mysqli_query($con, $query_cr);
					}
					if ($amount_prvt > 0)
					{
						$query_dr = "INSERT INTO `transactions`(
						`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
						`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (
						'$prvt_led_id',8,'$attend_id','$patient_id',5,'$date','$amount_prvt','$amount_prvt',0,
						'$surgery_list_id','$surgery_list_id','surgery for NHIS')";
						mysqli_query($con, $query_dr);

						$query_cr = "INSERT INTO `transactions`(
						`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
						`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (8,
						'$prvt_led_id','$attend_id','$patient_id',5,'$date','$amount_prvt',0,'$amount_prvt',
						'$surgery_list_id''$surgery_list_id','surgery for NHIS')";
						mysqli_query($con, $query_cr);
					}
					if ($amount_nhis > 0)
					{
						$query_dr = "INSERT INTO `transactions`(
						`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
						`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (2,8,
						'$attend_id','$patient_id',5,'$date','$amount_nhis','$amount_nhis',0,'$surgery_list_id',
						'$surgery_list_id','surgery for NHIS')";
						mysqli_query($con, $query_dr);

						$query_cr = "INSERT INTO `transactions`(
						`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
						`amt_debit`, `amt_credit`, `item_list_id`, `surgery_list_id`, `narration`) VALUES (8,2,
						'$attend_id','$patient_id',5,'$date','$amount_nhis',0,'$amount_nhis','$surgery_list_id',
						'$surgery_list_id','surgery for NHIS')";
						mysqli_query($con, $query_cr);
					};
			}
			else
			{
				echo "Surgery NOT Updated";
			};
		}
		
		function nhis_procedure_list_delete()
		{
			global $con;
			$surgery_list_id = $_POST['surgery_list_id'];
			
			$query_surgery_list = "DELETE FROM `surgery_list` WHERE `surgery_list_id`='$surgery_list_id'";
			mysqli_query($con, $query_surgery_list);
		}

		function nhis_diagnosis_list_edit()
		{
			global $con;
			$diagnosis_list_id = $_POST['diagnosis_list_id'];
			$diagnosis_list_details = array();
			$query = "SELECT * FROM diagnosis_list WHERE diagnosis_list_id ='$diagnosis_list_id'";
			$result = mysqli_query($con,$query);
			while($row = mysqli_fetch_assoc($result))
			{
				$nhis_id = $row['nhis_id'];
				$query_nhis = "SELECT * FROM nhis WHERE nhis_id ='$nhis_id'";
				$result_nhis = mysqli_query($con,$query_nhis);
				$row_nhis = mysqli_fetch_assoc($result_nhis);

				$diagnosis_id = $row['diagnosis_id'];
				$query_diagnosis = "SELECT * FROM diagnosis WHERE diagnosis_id ='$diagnosis_id'";
				$result_diagnosis = mysqli_query($con,$query_diagnosis);
				$row_diagnosis = mysqli_fetch_assoc($result_diagnosis);

				array_push($diagnosis_list_details, 
					$row['diagnosis_list_id'], $row['date'], $row['is_principal'], $row['amount_nhis'],
					$row['nhis_id'], $row_nhis['nhis_item_desc'], $row['diagnosis_id'], $row_diagnosis['icd_10'],
					$row['comment'], $row['amount_cash'], $row['amount_prvt'], $row['attend_id'], $row['patient_id']
				);
			}
			 echo json_encode($diagnosis_list_details);
		}

		function nhis_diagnosis_list_change_gdrg()
		{
			global $con;
			$nhis_id = $_POST['nhis_id'];
			$gdrg_details = array();
			$query_nhis = "SELECT * FROM nhis WHERE nhis_id ='$nhis_id'";
			$result_nhis = mysqli_query($con,$query_nhis);
			$row_nhis = mysqli_fetch_assoc($result_nhis);
			array_push($gdrg_details, 
				$row_nhis['nhis_item_desc'],$row_nhis['price_adult'],$row_nhis['price_child']
			);
			echo json_encode($gdrg_details);
		}

		function nhis_diagnosis_list_change_diagnosis()
		{
			global $con;
			$diagnosis_id = $_POST['diagnosis_id'];
			$diagnosis_details = array();
			$query_diagnosis = "SELECT * FROM diagnosis WHERE diagnosis_id ='$diagnosis_id'";
			$result_diagnosis = mysqli_query($con,$query_diagnosis);
			$row_diagnosis = mysqli_fetch_assoc($result_diagnosis);
			array_push($diagnosis_details, 
					$row_diagnosis['icd_10']
				);
			echo json_encode($diagnosis_details);
		}

		function nhis_diagnosis_list_update()
		{
			global $con;
			$diagnosis_list_id = $_POST['nhis_diagnosislist_id'];
			$payment_type_id = $_POST['nhis_diagnosis_payment_type_id'];
			$nhis_id = $_POST['nhis_diagnosis_gdrg'];
			$amount_nhis = $_POST['nhis_diagnosis_amount'];
			$amount_cash = $_POST['nhis_diagnosis_amount_cash'];
			$amount_prvt = $_POST['nhis_diagnosis_amount_prvt'];
			$diagnosis_id = $_POST['nhis_diagnosis_id'];
			$date = $_POST['nhis_diagnosis_date'];
			$is_principal = $_POST['nhis_diagnosis_is_principal'];
			$comment = $_POST['nhis_diagnosis_comment'];
			$attend_id = $_POST['attend_id'];
			$patient_id = $_POST['patient_id'];
			$prvt_led_id = 0;

			if($is_principal == 'Yes')
			{
				$query = "UPDATE `surgery_list` SET `is_principal`='No' WHERE `attend_id`='$attend_id'";
				mysqli_query($con, $query);
				$query = "UPDATE `diagnosis_list` SET `is_principal`='No' WHERE `attend_id`='$attend_id'";
				mysqli_query($con, $query);
				$query = "UPDATE `payment_type` SET `principal_gdrg`='$nhis_id', `principal_amt`='$amount_nhis' 
				WHERE `payment_type_id`='$payment_type_id'";
				mysqli_query($con, $query);
			};

			$query = "UPDATE `diagnosis_list` SET 
			`diagnosis_id`='$diagnosis_id',`comment`='$comment',`price_nhis`='$amount_nhis',
			`amount_nhis`='$amount_nhis',`date`='$date',`nhis_id`='$nhis_id',
			`is_principal`='$is_principal' WHERE `diagnosis_list_id`='$diagnosis_list_id'";
			$query_run = mysqli_query($con, $query);
			
			if ($query_run)
			{
				//POST TRANSACTION
					$query_trans = "SELECT * FROM `transactions` WHERE `attend_id`='$attend_id' AND `category_id`=5 
					AND `item_list_id`='$diagnosis_list_id'";
					$query_run_trans = mysqli_query($con, $query_trans);
					if (mysqli_num_rows($query_run_trans) > 0)
					{
						$query_trans_del = "DELETE FROM `transactions` WHERE `attend_id`='$attend_id' AND 
						`category_id`=5 AND `item_list_id`='$diagnosis_list_id'";
						mysqli_query($con, $query_trans_del);
						if ($amount_cash > 0)
						{
							$query_dr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `diagnosis_list_id`, `narration`) VALUES (1,9,
							'$attend_id','$patient_id',6,'$date','$amount_cash','$amount_cash',0,'$diagnosis_list_id',
							'$diagnosis_list_id','diagnosis for cash')";
							mysqli_query($con, $query_dr);

							$query_cr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `diagnosis_list_id`, `narration`) VALUES (9,1,
							'$attend_id','$patient_id',6,'$date','$amount_cash',0,'$amount_cash','$diagnosis_list_id',
							'$diagnosis_list_id','diagnosis for cash')";
							mysqli_query($con, $query_cr);
						}
						if ($amount_prvt > 0)
						{
							$query_dr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `diagnosis_list_id`, `narration`) VALUES (
							'$prvt_led_id',9,'$attend_id','$patient_id',6,'$date','$amount_prvt','$amount_prvt',0,
							'$diagnosis_list_id','$diagnosis_list_id','diagnosis for NHIS')";
							mysqli_query($con, $query_dr);

							$query_cr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `diagnosis_list_id`, `narration`) VALUES (9,
							'$prvt_led_id','$attend_id','$patient_id',6,'$date','$amount_prvt',0,'$amount_prvt',
							'$diagnosis_list_id''$diagnosis_list_id','diagnosis for NHIS')";
							mysqli_query($con, $query_cr);
						}
						if ($amount_nhis > 0)
						{
							$query_dr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `diagnosis_list_id`, `narration`) VALUES (2,9,
							'$attend_id','$patient_id',6,'$date','$amount_nhis','$amount_nhis',0,'$diagnosis_list_id',
							'$diagnosis_list_id','diagnosis for NHIS')";
							mysqli_query($con, $query_dr);

							$query_cr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `diagnosis_list_id`, `narration`) VALUES (9,2,
							'$attend_id','$patient_id',6,'$date','$amount_nhis',0,'$amount_nhis','$diagnosis_list_id',
							'$diagnosis_list_id','diagnosis for NHIS')";
							mysqli_query($con, $query_cr);
						};
					}
					else
					{
						if ($amount_cash > 0)
						{
							$query_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
							`patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
							`diagnosis_list_id`, `narration`) VALUES (1,9,'$attend_id','$patient_id',6,'$date',
							'$amount_cash','$amount_cash',0,'$diagnosis_list_id','$diagnosis_list_id','diagnosis for cash')";
							mysqli_query($con, $query_dr);
							
							$query_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
							`patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
							`diagnosis_list_id`, `narration`) VALUES (9,1,'$attend_id','$patient_id',6,'$date','$amount_cash',
							0,'$amount_cash','$diagnosis_list_id','$diagnosis_list_id','diagnosis for cash')";
							mysqli_query($con, $query_cr);
						}
						if ($amount_prvt > 0)
						{
							$query_dr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `diagnosis_list_id`, `narration`) VALUES (
							'$prvt_led_id',9,'$attend_id','$patient_id',6,'$date','$amount_prvt','$amount_prvt',0,
							'$diagnosis_list_id','$diagnosis_list_id','diagnosis for NHIS')";
							mysqli_query($con, $query_dr);

							$query_cr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `diagnosis_list_id`, `narration`) VALUES (9,
							'$prvt_led_id','$attend_id','$patient_id',6,'$date','$amount_prvt',0,'$amount_prvt',
							'$diagnosis_list_id','$diagnosis_list_id','diagnosis for NHIS')";
							mysqli_query($con, $query_cr);
						}
						if ($amount_nhis > 0)
						{
							$query_dr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `diagnosis_list_id`, `narration`) VALUES (2,9,
							'$attend_id','$patient_id',6,'$date','$amount_nhis','$amount_nhis',0,'$diagnosis_list_id',
							'$diagnosis_list_id','diagnosis for NHIS')";
							mysqli_query($con, $query_dr);

							$query_cr = "INSERT INTO `transactions`(
							`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
							`amt_debit`, `amt_credit`, `item_list_id`, `diagnosis_list_id`, `narration`) VALUES (9,2,
							'$attend_id','$patient_id',6,'$date','$amount_nhis',0,'$amount_nhis','$diagnosis_list_id',
							'$diagnosis_list_id','diagnosis for NHIS')";
							mysqli_query($con, $query_cr);
						};
					};
				//view_current_surgery();
			}
			else
			{
				echo "Surgery NOT Updated";
			};
		}

		function nhis_diagnosis_list_save()
		{
			global $con;
			//$diagnosis_list_id = $_POST['nhis_diagnosislist_id'];
			$payment_type_id = $_POST['nhis_diagnosis_payment_type_id'];
			$nhis_id = $_POST['nhis_diagnosis_gdrg'];
			$amount_nhis = $_POST['nhis_diagnosis_amount'];
			$amount_cash = $_POST['nhis_diagnosis_amount_cash'];
			$amount_prvt = $_POST['nhis_diagnosis_amount_prvt'];
			$diagnosis_id = $_POST['nhis_diagnosis_id'];
			$date = $_POST['nhis_diagnosis_date'];
			$is_principal = $_POST['nhis_diagnosis_is_principal'];
			$comment = $_POST['nhis_diagnosis_comment'];
			$attend_id = $_POST['attend_id'];
			$patient_id = $_POST['patient_id'];
			$prvt_led_id = 0;
			$company_id = $_SESSION['company_id'];
			$user_id = $_SESSION['user_id'];

			if($is_principal == 'Yes')
			{
				$query = "UPDATE `surgery_list` SET `is_principal`='No' WHERE `attend_id`='$attend_id'";
				mysqli_query($con, $query);
				$query = "UPDATE `diagnosis_list` SET `is_principal`='No' WHERE `attend_id`='$attend_id'";
				mysqli_query($con, $query);
				$query = "UPDATE `payment_type` SET `principal_gdrg`='$nhis_id', `principal_amt`='$amount_nhis' 
				WHERE `payment_type_id`='$payment_type_id'";
				mysqli_query($con, $query);
			};

			$query = "INSERT INTO `diagnosis_list`(`company_id`,`attend_id`, `patient_id`, 
			`diagnosis_id`, `date`, `amount_nhis`, `comment`, `ledger_id`, `nhis_id`, 
			`is_principal`, `user_id`, `user_create`, `user_create_timestamp`) 
			VALUES ('$company_id','$attend_id','$patient_id','$diagnosis_id','$date',
			'$amount_nhis','$comment',2,'$nhis_id', '$is_principal', '$user_id', 
			'$user_id', NOW())";
			$query_run = mysqli_query($con, $query);
			
			if ($query_run)
			{
				//POST TRANSACTION
					$query_diagnosis_list = "SELECT * FROM `diagnosis_list` ORDER BY `diagnosis_list_id` DESC";
					$query_run_diagnosis_list = mysqli_query($con, $query_diagnosis_list);
					$row_diagnosis_list = mysqli_fetch_assoc($query_run_diagnosis_list);
					$diagnosis_list_id = $row_diagnosis_list['diagnosis_list_id'];
					if ($amount_cash > 0)
					{
						$query_dr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
						`patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
						`diagnosis_list_id`, `narration`) VALUES (1,9,'$attend_id','$patient_id',6,'$date',
						'$amount_cash','$amount_cash',0,'$diagnosis_list_id','$diagnosis_list_id','diagnosis for cash')";
						mysqli_query($con, $query_dr);
						
						$query_cr = "INSERT INTO `transactions`(`ledger_id`,`ledger_id_contra`, `attend_id`, 
						`patient_id`, `category_id`, `date`, `amt`, `amt_debit`, `amt_credit`, `item_list_id`, 
						`diagnosis_list_id`, `narration`) VALUES (9,1,'$attend_id','$patient_id',6,'$date','$amount_cash',
						0,'$amount_cash','$diagnosis_list_id','$diagnosis_list_id','diagnosis for cash')";
						mysqli_query($con, $query_cr);
					}
					if ($amount_prvt > 0)
					{
						$query_dr = "INSERT INTO `transactions`(
						`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
						`amt_debit`, `amt_credit`, `item_list_id`, `diagnosis_list_id`, `narration`) VALUES (
						'$prvt_led_id',9,'$attend_id','$patient_id',6,'$date','$amount_prvt','$amount_prvt',0,
						'$diagnosis_list_id','$diagnosis_list_id','diagnosis for NHIS')";
						mysqli_query($con, $query_dr);

						$query_cr = "INSERT INTO `transactions`(
						`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
						`amt_debit`, `amt_credit`, `item_list_id`, `diagnosis_list_id`, `narration`) VALUES (9,
						'$prvt_led_id','$attend_id','$patient_id',6,'$date','$amount_prvt',0,'$amount_prvt',
						'$diagnosis_list_id','$diagnosis_list_id','diagnosis for NHIS')";
						mysqli_query($con, $query_cr);
					}
					if ($amount_nhis > 0)
					{
						$query_dr = "INSERT INTO `transactions`(
						`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
						`amt_debit`, `amt_credit`, `item_list_id`, `diagnosis_list_id`, `narration`) VALUES (2,9,
						'$attend_id','$patient_id',6,'$date','$amount_nhis','$amount_nhis',0,'$diagnosis_list_id',
						'$diagnosis_list_id','diagnosis for NHIS')";
						mysqli_query($con, $query_dr);

						$query_cr = "INSERT INTO `transactions`(
						`ledger_id`,`ledger_id_contra`, `attend_id`, `patient_id`, `category_id`, `date`, `amt`, 
						`amt_debit`, `amt_credit`, `item_list_id`, `diagnosis_list_id`, `narration`) VALUES (9,2,
						'$attend_id','$patient_id',6,'$date','$amount_nhis',0,'$amount_nhis','$diagnosis_list_id',
						'$diagnosis_list_id','diagnosis for NHIS')";
						mysqli_query($con, $query_cr);
					};
			}
			else
			{
				echo "Surgery NOT Updated";
			};
		}
		
		function nhis_diagnosis_list_delete()
		{
			global $con;
			$diagnosis_list_id = $_POST['diagnosis_list_id'];
			
			$query_diagnosis_list = "DELETE FROM `diagnosis_list` WHERE `diagnosis_list_id`='$diagnosis_list_id'";
			mysqli_query($con, $query_diagnosis_list);
		}

		function nhis_drug_list_edit()
		{
			global $con;
			$drug_disp_list_id = $_POST['drug_disp_list_id'];
			$drug_list_details = array();
			$query = "SELECT * FROM drug_dispense_list WHERE drug_disp_list_id ='$drug_disp_list_id'";
			$result = mysqli_query($con,$query);
			while($row = mysqli_fetch_assoc($result))
			{
				$drug_id = $row['drug_id'];
				$query_drug = "SELECT * FROM drugs WHERE drug_id ='$drug_id'";
				$result_drug = mysqli_query($con,$query_drug);
				$row_drug = mysqli_fetch_assoc($result_drug);

				$nhis_id = $row_drug['nhis_id'];
				$query_nhis = "SELECT * FROM nhis WHERE nhis_id ='$nhis_id'";
				$result_nhis = mysqli_query($con,$query_nhis);
				$row_nhis = mysqli_fetch_assoc($result_nhis);

				if(isset($row_nhis) && $row_nhis !=='')
				{
					$code = $row_nhis['gdrg'];
				}
				else
				{
					$code = 'N/A';
				};

				array_push($drug_list_details, 
					$row['drug_disp_list_id'], $row['drug_id'], $row['qty_nhis'], $row['price_nhis'],
					$row['amt_nhis'],$row['price_cash'],$row['amt_cash'],$row['price_prvt'],
					$row['amt_prvt'],$row['dosage'],$row['date'],$row['comment'], $code, 
					$row['attend_id'], $row['patient_id']
				);
			}
			 echo json_encode($drug_list_details);
		}

		function nhis_drug_list_save()
		{
			global $con;
			$drug_disp_list_id = $_POST['drug_disp_list_id'];
			$price_cash = $_POST['nhis_drug_price_cash'];
			$amount_cash = $_POST['nhis_drug_amount_cash'];
			$price_prvt = $_POST['nhis_drug_price_prvt'];
			$amount_prvt = $_POST['nhis_drug_amount_prvt'];
			$payment_type_id = $_POST['nhis_drug_payment_type_id'];
			$drug_id = $_POST['nhis_drug_id'];
			$code = $_POST['nhis_drug_code'];
			$dosage = $_POST['nhis_drug_dosage'];
			$date = $_POST['nhis_drug_date'];
			$qty = $_POST['nhis_drug_qty'];
			$price = $_POST['nhis_drug_price'];
			$amount = $_POST['nhis_drug_amount'];
			$comment = $_POST['nhis_drug_comment'];
			$attend_id = $_POST['nhis_drug_attend_id'];
			$patient_id = $_POST['nhis_drug_patient_id'];
			$prvt_led_id = 0;

			$query = "UPDATE `drug_dispense_list` SET 
			`drug_id`='$drug_id',`comment`='$comment',`price_nhis`='$price',
			`amt_nhis`='$amount',`date`='$date',`dosage`='$dosage',
			`qty_nhis`='$qty' WHERE `drug_disp_list_id`='$drug_disp_list_id'";
			$query_run = mysqli_query($con, $query);
			
			if ($query_run)
			{
				//POST TRANSACTION
					$query_dr = "UPDATE `transactions`SET
					`ledger_id`=2,`ledger_id_contra`=5, `category_id`=2, `date`='$date', `amt`='$amount', 
					`amt_debit`='$amount', `amt_credit`=0, `item_list_id`='$drug_list_id', 
					WHERE `drug_list_id`='$drug_list_id' AND `amt_debit`> 0";
					mysqli_query($con, $query_dr);

					$query_cr = "UPDATE `transactions`SET
					`ledger_id`=5,`ledger_id_contra`=2, `category_id`=2, `date`='$date', `amt`='$amount', 
					`amt_debit`=0, `amt_credit`='$amount', `item_list_id`='$drug_list_id', 
					WHERE `drug_list_id`='$drug_list_id' AND `amt_credit`> 0";
					
					mysqli_query($con, $query_cr);
			}
			else
			{
				echo "Drug NOT Updated";
			};
		}

		function nhis_set_drug_price_and_code()
		{
			global $con;
			$drug_id = $_POST['drug_id'];
			$drug_nhis_details = array();
			
				$query_drug = "SELECT * FROM drugs WHERE drug_id ='$drug_id'";
				$result_drug = mysqli_query($con,$query_drug);
				$row_drug = mysqli_fetch_assoc($result_drug);

				$nhis_id = $row_drug['nhis_id'];
				$query_nhis = "SELECT * FROM nhis WHERE nhis_id ='$nhis_id'";
				$result_nhis = mysqli_query($con,$query_nhis);
				$row_nhis = mysqli_fetch_assoc($result_nhis);

				if(isset($row_nhis) && $row_nhis !=='')
				{
					$code = $row_nhis['gdrg'];
					$price = $row_nhis['price'];
				}
				else
				{
					$code = 'N/A';
					$price = 0;
				};

				array_push($drug_nhis_details, 
					$price,$code
				);
			echo json_encode($drug_nhis_details);
		}
		
		function nhis_add_drug_save()
		{
			global $con;
			$drug_id = $_POST['nhis_drug_id'];
			$dosage = $_POST['nhis_drug_dosage'];
			$qty_presc = $_POST['nhis_drug_qty'];
			$drug_comment = $_POST['nhis_drug_comment'];
			$attend_id = $_POST['attend_id'];
			$patient_id = $_POST['patient_id'];
			$drug_sponsor = 2;
			$drug_price = $_POST['nhis_drug_price'];
			$drug_amount = $_POST['nhis_drug_amount'];
			$drug_date = $_POST['nhis_drug_date'];
			$company_id = $_SESSION['company_id'];
			$user_id = $_SESSION['user_id'];
			
			$query_drug_list = "INSERT INTO `drug_list`(`company_id`, `attend_id`, `patient_id`, `drug_id`, 
			`qty_presc`, `dosage`, `comment_presc`, `date`, `ledger_id`, `price_est`, `amount_est`,
			`user_id`, `created_by`, `created_datetime`) VALUES ('$company_id','$attend_id','$patient_id',
			'$drug_id','$qty_presc','$dosage','$drug_comment','$drug_date','$drug_sponsor','$drug_price',
			'$drug_amount','$user_id','$user_id',NOW())";
			$query_run_drug_list = mysqli_query($con, $query_drug_list);
			
			$query_select = "SELECT drug_list_id FROM `drug_list` ORDER BY `drug_list_id` DESC";
			$query_run_select = mysqli_query($con, $query_select);
			$row_select = mysqli_fetch_assoc($query_run_select);
			$drug_list_id = $row_select['drug_list_id'];

			$query_dispense = "INSERT INTO `drug_dispense_list`(`company_id`,`drug_list_id`, `drug_presc_id`, 
			`drug_id`, `patient_id`, `attend_id`, `ledger_id`, `date`, `dosage`, `qty_nhis`, `price_nhis`, 
			`amt_nhis`, `comment`, `user_id`, `created_by`, `created_timestamp`) 
			VALUES ('$company_id','$drug_list_id','$drug_id','$drug_id','$patient_id','$attend_id',
			'$drug_sponsor','$drug_date','$dosage','$qty_presc','$drug_price','$drug_amount','$drug_comment','$user_id',
			'$user_id',NOW())";
			mysqli_query($con, $query_dispense);
		}

		function nhis_attend_update()
		{
			global $con;
			$typeofservice_attd = mysqli_real_escape_string($con,$_POST['typeofservice_attd']);
			$dateofadmission_attd = mysqli_real_escape_string($con,$_POST['dateofadmission_attd']);
			$dateofdischarge_attd = mysqli_real_escape_string($con,$_POST['dateofdischarge_attd']);
			$outcome = mysqli_real_escape_string($con,$_POST['outcome']);

			$type_of_attendnace = mysqli_real_escape_string($con,$_POST['type_of_attendnace']);
			$date_of_claim = mysqli_real_escape_string($con,$_POST['date_of_claim']);
			$pharmacy = mysqli_real_escape_string($con,$_POST['pharmacy']);
			$type_of_service_2 = mysqli_real_escape_string($con,$_POST['type_of_service_2']);
			$spell = mysqli_real_escape_string($con,$_POST['spell']);
			$claim_no = '';

			$attend_sponsor_id = mysqli_real_escape_string($con,$_POST['attend_sponsor_id']);
			$attend_sponsor_member_no = mysqli_real_escape_string($con,$_POST['attend_sponsor_member_no']);
			$attend_sponsor_category = mysqli_real_escape_string($con,$_POST['attend_sponsor_category']);
			$attend_sponsor_principal = mysqli_real_escape_string($con,$_POST['attend_sponsor_principal']);
			$attend_sponsor_code = mysqli_real_escape_string($con,$_POST['nhisccc']);
			$attend_sponsor_expiry_date = mysqli_real_escape_string($con,$_POST['attend_sponsor_expiry_date']);
			$ghanacard_attd = mysqli_real_escape_string($con,$_POST['ghanacard_attd']);
			$serial_no = mysqli_real_escape_string($con,$_POST['serial_no']);

			$nhis_attend_specialty_description = mysqli_real_escape_string($con,$_POST['nhis_attend_specialty_description']);
			$nhis_attend_specialty_code = mysqli_real_escape_string($con,$_POST['nhis_attend_specialty_code']);
			$nhis_attend_referral_facility = mysqli_real_escape_string($con,$_POST['nhis_attend_referral_facility']);
			$nhis_attend_referral_facility_code = mysqli_real_escape_string($con,$_POST['nhis_attend_referral_facility_code']);

			$attend_id = mysqli_real_escape_string($con,$_POST['nhis_attend_id']);
			$pay_type_id = mysqli_real_escape_string($con,$_POST['nhis_attend_pay_type_id']);

			$user_id = $_SESSION['user_id'];
			date_default_timezone_set("Africa/Accra");
			$datetime = date('Y/m/d H:i:s');
			
			$query = "UPDATE attendance SET date_admit='$dateofadmission_attd', 
			date_disch='$dateofdischarge_attd', tos_id='$typeofservice_attd', outcome='$outcome', 
			altered_by='$user_id', altered_datetime='$datetime' WHERE attend_id = '$attend_id'";
			$query_run = mysqli_query($con, $query);
			if ($query_run) 
			{
				//SPECIALTY CODE
				$specialty_attd = '';
				if(isset($_POST["specialty_attd"]))
				{
					$specialty_attd = implode(',',$_POST["specialty_attd"]);
				};
				
				$query_pt = "UPDATE `payment_type`SET `member_no`='$attend_sponsor_member_no',
				`code`='$attend_sponsor_code', `expiry_date`='$attend_sponsor_expiry_date',
				`ghanacard`='$ghanacard_attd', `serial_no`='$serial_no', `specialty_1`='$specialty_attd', 
				`type_of_attend`='$type_of_attendnace', `date_of_claim`='$date_of_claim', 
				`pharmacy`='$pharmacy', `type_of_serv_b`='$type_of_service_2', `spell`='$spell', 
				`claim_no`='$claim_no', `date_admit`='$dateofadmission_attd', 
				`date_disch`='$dateofdischarge_attd',`specialty`='$nhis_attend_specialty_description',
				`specialty_code`='$nhis_attend_specialty_code',`referral_facility`='$nhis_attend_referral_facility',
				`referral_gdrg`='$nhis_attend_referral_facility_code'
				WHERE `pay_type_id`='$pay_type_id'";

				mysqli_query($con, $query_pt);
			};
		}

		function nhis_set_specialty_code()
		{
			global $con;
			$pay_type_id = $_POST['pay_type_id'];
			$tos_id = $_POST['tos_id'];
			$nhis_id = $_POST['nhis_id'];
			$age = $_POST['age'];
			$drug_nhis_details = array();
			
				$query_nhis = "SELECT * FROM nhis WHERE nhis_id ='$nhis_id'";
				$result_nhis = mysqli_query($con,$query_nhis);
				$row_nhis = mysqli_fetch_assoc($result_nhis);
				if($age < 12)
				{
					$code = $row_nhis['gdrg_child'];
					$price = $row_nhis['price_child'];
				}
				else
				{
					$code = $row_nhis['gdrg_adult'];
					$price = $row_nhis['price_adult'];
				};
				if($tos_id == 1)
				{
					$query_pt = "UPDATE `payment_type` SET `amt_out_patient`='$price', 
					`gdrg_out_patient`='$code',`amt_in_patient`='', 
					`gdrg_in_patient`='' WHERE `pay_type_id`='$pay_type_id'";
					mysqli_query($con,$query_pt);
				}
				
			echo $code;
		}
		
		function nhis_drug_delete()
		{
			global $con;
			$drug_disp_list_id = $_POST['drug_disp_list_id'];
			$drug_list_id = $_POST['drug_list_id'];
			
			$query_drug_list = "DELETE FROM `drug_list` WHERE `drug_list_id`='$drug_list_id'";
			mysqli_query($con, $query_drug_list);

			$query_dispense = "DELETE FROM `drug_dispense_list` WHERE `drug_disp_list_id`='$drug_disp_list_id'";
			mysqli_query($con, $query_dispense);
		}

	//PAYMENT TYPE REPORT
		function payment_type_report_display()
		{
			global $con;
			$_SESSION['payment_type_report_company_id'] = $_POST['payment_type_report_company_id'];
			$_SESSION['payment_type_report_user_id'] = $_POST['payment_type_report_user_id'];
			$_SESSION['payment_type_report_user_super_id'] = $_POST['payment_type_report_user_super_id'];
			$_SESSION['payment_type_report_ledger_id'] = $_POST['payment_type_report_ledger_id'];
			$_SESSION['payment_type_report_start_date'] = $_POST['payment_type_report_start_date'];
			$_SESSION['payment_type_report_end_date'] = $_POST['payment_type_report_end_date'];
		}
	//PATIENT STATEMENT
		function patient_insurance_statement_display_attend()
		{
			global $con;
			$_SESSION['company_id'] = $_POST['company_id'];
			$_SESSION['user_super_id'] = $_POST['user_super_id'];
			$_SESSION['patient_id'] = $_POST['patient_id'];
			$_SESSION['attend_id'] = $_POST['attend_id'];
			$_SESSION['sponsor_id'] = $_POST['sponsor_id'];
		}

		function patient_cash_statement_display_attend()
		{
			global $con;
			//$_SESSION['company_id'] = $_POST['company_id'];
			$_SESSION['user_super_id'] = $_POST['user_super_id'];
			$_SESSION['patient_id'] = $_POST['patient_id'];
			$_SESSION['attend_id'] = $_POST['attend_id'];
		}

		function patient_cash_statement_display_patient()
		{
			global $con;
			$_SESSION['company_id'] = $_POST['company_id'];
			$_SESSION['user_super_id'] = $_POST['user_super_id'];
			$_SESSION['patient_id'] = $_POST['patient_id'];
		}
//STATISTICS
	//DOCTORS ATTENDANCE REGISTER
		function doctors_attend_register_display()
		{
			global $con;
			//$_SESSION['doctors_attend_register_company_id'] = $_POST['doctors_attend_register_company_id'];
			//$_SESSION['doctors_attend_register_user_id'] = $_POST['doctors_attend_register_user_id'];
			//$_SESSION['doctors_attend_register_user_super_id'] = $_POST['doctors_attend_register_user_super_id'];
			$_SESSION['doctors_attend_register_start_date'] = $_POST['doctors_attend_register_start_date'];
			$_SESSION['doctors_attend_register_end_date'] = $_POST['doctors_attend_register_end_date'];
			$_SESSION['doctors_attend_register_doctor'] = $_POST['doctors_attend_register_doctor'];
		}
	//INCIDENCE OF DISEASE
		function incidence_of_disease_display()
		{
			global $con;
			$_SESSION['incidence_of_disease_start_date'] = $_POST['incidence_of_disease_start_date'];
			$_SESSION['incidence_of_disease_end_date'] = $_POST['incidence_of_disease_end_date'];
		}

		function incidence_of_disease_enter()
		{
			global $con;
			/*$diagnosis_id = $_SESSION['diagnosis_id'];
			$diag_list_id = $_SESSION['diag_list_id'];
			$lab_id = $_SESSION['lab_id'];
			$lab_list_id = $_SESSION['lab_list_id'];
			$category = $_SESSION['item_category_id'];
			$patient_id = $_SESSION['patient_id'];
			$attend_id = $_SESSION['attend_id'];
		    $date = $_SESSION['date_SIOD'];

			$company_id = $_SESSION['company_id'];
			$gender = $_SESSION['gender'];
	    	$dob = $_SESSION['dob'];
	    	$dob = new DateTime($dob);
			$now = new DateTime($date);
			$days  = $now->diff($dob)->format('%a');*/
			
		    $date = $_SESSION['date_SIOD'];
			$gender = $_SESSION['gender'];
			$dob = $_SESSION['dob'];
	    	$dob = new DateTime($dob);
			$now = new DateTime($date);
			$days  = $now->diff($dob)->format('%a');
			if($gender == 1 && ($days > 0 && $days <= 28))
			{
				$m_0_28days = 1;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 1;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 0;$m_f_total = 1;
			}
			else if($gender == 1 && ($days > 28 && $days <= 330))
			{
				$m_0_28days = 0;$m_1_11months = 1;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 1;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 0;$m_f_total = 1;
			}
			else if($gender == 1 && ($days > 330 && $days <= 1440))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 1;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 1;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 0;$m_f_total = 1;
			}
			else if($gender == 1 && ($days > 1440 && $days <= 3240))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 1;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 1;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 0;$m_f_total = 1;
			}
			else if($gender == 1 && ($days > 3240 && $days <= 5040))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 1;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 1;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 0;$m_f_total = 1;
			}
			else if($gender == 1 && ($days > 5040 && $days <= 6120))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 1;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 1;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 0;$m_f_total = 1;
			}
			else if($gender == 1 && ($days > 6120 && $days <= 6840))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 1;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 1;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 0;$m_f_total = 1;
			}
			else if($gender == 1 && ($days > 6840 && $days <= 12240))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 1;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 1;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 0;$m_f_total = 1;
			}
			else if($gender == 1 && ($days > 12240 && $days <= 17640))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 1;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 1;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 0;$m_f_total = 1;
			}
			else if($gender == 1 && ($days > 17640 && $days <= 21240))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 1;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 1;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 0;$m_f_total = 1;
			}
			else if($gender == 1 && ($days > 21240 && $days <= 24840))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 1;$m_70_more = 0;$m_total = 1;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 0;$m_f_total = 1;
			}
			else if($gender == 1 && ($days > 24840))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 1;$m_total = 1;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 0;$m_f_total = 1;
			}
			else if($gender == 2 && ($days > 0 && $days <= 28))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 0;
				$f_0_28days = 1;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 1;$m_f_total = 1;
			}
			else if($gender == 2 && ($days > 28 && $days <= 330))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 0;
				$f_0_28days = 0;$f_1_11months = 1;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 1;$m_f_total = 1;
			}
			else if($gender == 2 && ($days > 330 && $days <= 1440))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 0;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 1;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 1;$m_f_total = 1;
			}
			else if($gender == 2 && ($days > 1440 && $days <= 3240))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 0;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 1;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 1;$m_f_total = 1;
			}
			else if($gender == 2 && ($days > 3240 && $days <= 5040))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 0;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 1;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 1;$m_f_total = 1;
			}
			else if($gender == 2 && ($days > 5040 && $days <= 6120))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 0;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 1;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 1;$m_f_total = 1;
			}
			else if($gender == 2 && ($days > 6120 && $days <= 6840))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 0;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 1;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 1;$m_f_total = 1;
			}
			else if($gender == 2 && ($days > 6840 && $days <= 12240))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 0;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 1;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 1;$m_f_total = 1;
			}
			else if($gender == 2 && ($days > 12240 && $days <= 17640))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 0;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 1;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 1;$m_f_total = 1;
			}
			else if($gender == 2 && ($days > 17640 && $days <= 21240))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 0;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 1;$f_60_69yrs = 0;$f_70_more = 0;$f_total = 1;$m_f_total = 1;
			}
			else if($gender == 2 && ($days > 21240 && $days <= 24840))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 0;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 1;$f_70_more = 0;$f_total = 1;$m_f_total = 1;
			}
			else if($gender == 2 && ($days > 24840))
			{
				$m_0_28days = 0;$m_1_11months = 0;$m_1_4yrs = 0;$m_5_9yrs = 0;$m_10_14yrs = 0;$m_15_17yrs = 0;$m_18_19yrs = 0;$m_20_34yrs = 0;$m_35_49yrs = 0;
				$m_50_59yrs = 0;$m_60_69yrs = 0;$m_70_more = 0;$m_total = 0;
				$f_0_28days = 0;$f_1_11months = 0;$f_1_4yrs = 0;$f_5_9yrs = 0;$f_10_14yrs = 0;$f_15_17yrs = 0;$f_18_19yrs = 0;$f_20_34yrs = 0;$f_35_49yrs = 0;
				$f_50_59yrs = 0;$f_60_69yrs = 0;$f_70_more = 1;$f_total = 1;$m_f_total = 1;
			}
		}

		function incidence_of_disease_entry()
		{
			global $con;
			$diagnosis_id = $_SESSION['diagnosis_id'];
			$diag_list_id = $_SESSION['diag_list_id'];
			$lab_id = $_SESSION['lab_id'];
			$lab_list_id = $_SESSION['lab_list_id'];
			$category = $_SESSION['item_category_id'];
			$patient_id = $_SESSION['patient_id'];
			$attend_id = $_SESSION['attend_id'];
		    $date = $_SESSION['date_SIOD'];

			$company_id = $_SESSION['company_id'];
			$gender = $_SESSION['gender'];
	    	$dob = $_SESSION['dob'];
	    	$dob = new DateTime($dob);
			$now = new DateTime($date);
			$days  = $now->diff($dob)->format('%a');

			incidence_of_disease_enter();

			$query = "INSERT INTO `stat_incidence_of_diseases`(`company_id`,`attend_id`, `patient_id`, `diagnosis_id`, `diag_list_id`, `lab_id`, `lab_list_id`, `date`, 
			`category_id`,`m_0_28days`,`m_1_11months`, `m_1_4yrs`, `m_5_9yrs`, `m_10_14yrs`, `m_15_17yrs`, `m_18_19yrs`, `m_20_34yrs`, `m_35_49yrs`,`m_50_59yrs`,
			`m_60_69yrs`,`m_70_more`, `m_total`,`f_0_28days`,`f_1_11months`, `f_1_4yrs`, `f_5_9yrs`, `f_10_14yrs`, `f_15_17yrs`, `f_18_19yrs`, `f_20_34yrs`, `f_35_49yrs`,
			`f_50_59yrs`,`f_60_69yrs`, `f_70_more`, `f_total`, `m_f_total`) VALUES ('$company_id','$attend_id','$patient_id','$diagnosis_id','$diag_list_id','$lab_id',
			'$lab_list_id','$date','$category','$m_0_28days','$m_1_11months','$m_1_4yrs','$m_5_9yrs','$m_10_14yrs','$m_15_17yrs','$m_18_19yrs','$m_20_34yrs','$m_35_49yrs',
			'$m_50_59yrs','$m_60_69yrs','$m_70_more','$m_total','$f_0_28days','$f_1_11months','$f_1_4yrs','$f_5_9yrs','$f_10_14yrs','$f_15_17yrs','$f_18_19yrs',
			'$f_20_34yrs','$f_35_49yrs','$f_50_59yrs','$f_60_69yrs','$f_70_more','$f_total','$m_f_total')";
	    	$query_run = mysqli_query($con, $query);
		}

		function incidence_of_disease_update_diagnosis()
		{
			global $con;
			$diagnosis_id = $_SESSION['diagnosis_id'];
			$diag_list_id = $_SESSION['diag_list_id'];
			$lab_id = $_SESSION['lab_id'];
			$lab_list_id = $_SESSION['lab_list_id'];
			$category = $_SESSION['item_category_id'];
			$patient_id = $_SESSION['patient_id'];
			$attend_id = $_SESSION['attend_id'];
		    $date = $_SESSION['date_SIOD'];

			$company_id = $_SESSION['company_id'];
			$gender = $_SESSION['gender'];
	    	$dob = $_SESSION['dob'];
	    	$dob = new DateTime($dob);
			$now = new DateTime($date);
			$days  = $now->diff($dob)->format('%a');

			incidence_of_disease_enter();

			$query = "UPDATE `stat_incidence_of_diseases` SET `company_id`='$company_id',`attend_id`='$attend_id',
			`patient_id`='$patient_id', `diagnosis_id`='$diagnosis_id',
			`lab_id`='$lab_id', `lab_list_id`='$lab_list_id', `date`='$date', 
			`category_id`='$category',`m_0_28days`='$m_0_28days',`m_1_11months`='$m_1_11months', 
			`m_1_4yrs`='$m_1_4yrs', `m_5_9yrs`='$m_5_9yrs', `m_10_14yrs`='$m_10_14yrs', 
			`m_15_17yrs`='$m_15_17yrs', `m_18_19yrs`='$m_18_19yrs', `m_20_34yrs`='$m_20_34yrs', 
			`m_35_49yrs`='$m_35_49yrs',`m_50_59yrs`='$m_50_59yrs',
			`m_60_69yrs`='$m_60_69yrs',`m_70_more`='$m_70_more', `m_total`='$m_total',`f_0_28days`='$f_0_28days',
			`f_1_11months`='$f_1_11months', `f_1_4yrs`='$f_1_4yrs', 
			`f_5_9yrs`='$f_5_9yrs', `f_10_14yrs`='$f_10_14yrs', `f_15_17yrs`='$f_15_17yrs', 
			`f_18_19yrs`='$f_18_19yrs', `f_20_34yrs`='$f_20_34yrs', `f_35_49yrs`='$f_35_49yrs',
			`f_50_59yrs`='$f_50_59yrs',`f_60_69yrs`='$f_60_69yrs', `f_70_more`='$f_70_more', 
			`f_total`='$f_total', `m_f_total`='$m_f_total' WHERE `diag_list_id`='$diag_list_id'";
	    	$query_run = mysqli_query($con, $query);
		}

		function incidence_of_disease_update_lab()
		{
			global $con;
			$diagnosis_id = $_SESSION['diagnosis_id'];
			$diag_list_id = $_SESSION['diag_list_id'];
			$lab_id = $_SESSION['lab_id'];
			$lab_list_id = $_SESSION['lab_list_id'];
			$category = $_SESSION['item_category_id'];
			$patient_id = $_SESSION['patient_id'];
			$attend_id = $_SESSION['attend_id'];
		    $date = $_SESSION['date_SIOD'];

			$company_id = $_SESSION['company_id'];
			$gender = $_SESSION['gender'];
	    	$dob = $_SESSION['dob'];
	    	$dob = new DateTime($dob);
			$now = new DateTime($date);
			$days  = $now->diff($dob)->format('%a');

			incidence_of_disease_enter();

			$query = "UPDATE `stat_incidence_of_diseases` SET `company_id`='$company_id',`attend_id`='$attend_id',
			`patient_id`='$patient_id', `diagnosis_id`='$diagnosis_id',
			`lab_id`='$lab_id', `diag_list_id`='$diag_list_id', `date`='$date', 
			`category_id`='$category',`m_0_28days`='$m_0_28days',`m_1_11months`='$m_1_11months', 
			`m_1_4yrs`='$m_1_4yrs', `m_5_9yrs`='$m_5_9yrs', `m_10_14yrs`='$m_10_14yrs', 
			`m_15_17yrs`='$m_15_17yrs', `m_18_19yrs`='$m_18_19yrs', `m_20_34yrs`='$m_20_34yrs', 
			`m_35_49yrs`='$m_35_49yrs',`m_50_59yrs`='$m_50_59yrs',
			`m_60_69yrs`='$m_60_69yrs',`m_70_more`='$m_70_more', `m_total`='$m_total',`f_0_28days`='$f_0_28days',
			`f_1_11months`='$f_1_11months', `f_1_4yrs`='$f_1_4yrs', 
			`f_5_9yrs`='$f_5_9yrs', `f_10_14yrs`='$f_10_14yrs', `f_15_17yrs`='$f_15_17yrs', 
			`f_18_19yrs`='$f_18_19yrs', `f_20_34yrs`='$f_20_34yrs', `f_35_49yrs`='$f_35_49yrs',
			`f_50_59yrs`='$f_50_59yrs',`f_60_69yrs`='$f_60_69yrs', `f_70_more`='$f_70_more', 
			`f_total`='$f_total', `m_f_total`='$m_f_total' WHERE `lab_list_id`='$lab_list_id'";
	    	$query_run = mysqli_query($con, $query);
		}
	//LAB OCCURANCE
		function lab_occurance_display()
		{
			global $con;
			$_SESSION['lab_occurance_start_date'] = $_POST['lab_occurance_start_date'];
			$_SESSION['lab_occurance_end_date'] = $_POST['lab_occurance_end_date'];
		}
	//STATEMENT OF OUT-PATIENT
		function statement_of_out_patient_display()
		{
			global $con;
			$_SESSION['statement_of_out_patient_start_date'] = $_POST['statement_of_out_patient_start_date'];
			$_SESSION['statement_of_out_patient_end_date'] = $_POST['statement_of_out_patient_end_date'];
		}

	//STATEMENT OF IN-PATIENT
		function statement_of_in_patient_display()
		{
			global $con;
			$_SESSION['statement_of_in_patient_start_date'] = $_POST['statement_of_in_patient_start_date'];
			$_SESSION['statement_of_in_patient_end_date'] = $_POST['statement_of_in_patient_end_date'];
		}
?>