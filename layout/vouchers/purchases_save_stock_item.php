<?php 
include($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    $value = '';
				$stock_item_name = addslashes($_POST['stock_item']);
				$i = $_POST['i'];
				$stock_item_code = '';
				$unit_of_measure = 1;
				$unit_of_measure_retail = 0;
				$unit_secondary_in_primary = 0;
			    $barcode = '';
				$price_cash = 0;
				$price_cash_wholesale = 0;
				$cost_price_retail = 0;
				$cost_price_wholesale = 0;
				$origin = '';
				$usage = '';
				$manufacturer = '';
			    $block_neg = 'No';
			    $batch = 'No';
				$expiry_date = 'No';
			    $days_prompt = 0;
			    $min_level = 0;
				$max_level = 0;
			    $re_order_level = 0;
			    $stock_item_type_id = 0;
			    $eoq = 0;
			    $warning = '';
			    $item_label = '';
			    $company_id = $_SESSION['company_id'];
			    $user_id = $_SESSION['user_id'];

			    $route = 0;
			    $category = 1;
			    $gender = 3;
			    $age_from = 0;
			    $age_to = 200;
			    $price_nhis_topup = 0;
			    $price_prvt = 0;
			    $nhis_id = 0;

			    $query_last_sno = "SELECT `sno` FROM `stock_items` WHERE `company_id` = '$company_id' ORDER BY `sno` DESC";
			    $result_last_sno = mysqli_query($con,$query_last_sno);
			    $row_last_sno = mysqli_fetch_assoc($result_last_sno);
			    if(isset($row_last_sno)){$last_sno = $row_last_sno['sno'];}else{$last_sno = 0;};
			    $next_sno = $last_sno + 1;
			    
			    $query = "INSERT INTO `stock_items`(`sno`,`barcode`,`company_id`, `stock_item`,
				`price_cash`, `unit_id`,`manufacturer`, `block_negative`, `block_expiry`,
				`maintain_batch`, `days_to_prompt`, `eoq`,`min_level`, `max_level`,
				`re_order_level`, `warning`,`label`,`code`,`stock_item_type_id`,`created_by`,
				`created_datetime`, `price_cash_wholesale`, `cost_price_retail`, 
				`cost_price_wholesale`,`origin`,`unit_id_retail`,`unit_id_retail_define`,`used_by`, 
				`route`,`category`,`gender`,`age_from`,`age_to`,`price_nhis_topup`,`price_prvt`,`nhis_id`) VALUES (
				'$next_sno','$barcode','$company_id','$stock_item_name',
				'$price_cash','$unit_of_measure','$manufacturer','$block_neg','$expiry_date','$batch',
				'$days_prompt','$eoq','$min_level','$max_level', '$re_order_level','$warning',
				'$item_label','$stock_item_code','$stock_item_type_id','$user_id',NOW(),
				'$price_cash_wholesale','$cost_price_retail','$cost_price_wholesale','$origin',
				'$unit_of_measure_retail','$unit_secondary_in_primary', '$usage',
				'$route','$category','$gender','$age_from','$age_to', '$price_nhis_topup','$price_prvt', '$nhis_id')";
			    $query_run = mysqli_query($con, $query);

			    if($query_run)
			    {
                    $query_ledger = "SELECT * FROM `stock_items` WHERE `company_id` = '$company_id' 
                    ORDER BY `stock_item_id` DESC";
                    $result_ledger = mysqli_query($con,$query_ledger);
                    if(!empty($result_ledger) && mysqli_num_rows($result_ledger) > 0)
                    {
                        $row_ledger = mysqli_fetch_assoc($result_ledger);
                        $stock_item_id = $row_ledger['stock_item_id'];
                        $stock_item = $row_ledger['stock_item'];
                    }
                    else
                    {
                        $stock_item_id = 0;
                        $stock_item = 'Not Specified';
                    };
                    $value = '<tr id="'.$i.'">
                        <td>
                            <input type="hidden" name="purch_item_list_id[]" class="form-control bg-light" id="purch_item_list_id'.$i.'">
                            <input type="hidden" name="purch_cat_id[]" class="form-control bg-light" id="purch_cat_id'.$i.'">
                            <input type="hidden" name="purch_desc[]" class="form-control bg-light" id="purch_desc'.$i.'" value="'.$stock_item_id.'">'.
                            $stock_item.'
                        </td>
                        <td>
                            <input type="text" name="purch_qty[]" class="form-control bg-light purch_qty text-center" id="purch_qty'.$i.'" data-id="'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="purch_price[]" class="form-control bg-light purch_price text-right" id="purch_price'.$i.'" data-id="'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="purch_amt[]" class="form-control bg-light text-right purch_amt" id="purch_amt'.$i.'" style="border-width:0px" hidden="true">
                            <input type="text" name="purch_amtD[]" class="form-control bg-light text-right" id="purch_amtD'.$i.'" style="border-width:0px" disabled="true">
                        </td>
                        <td>
                            <input type="text" name="purch_selling_price[]" class="form-control bg-light text-right" id="purch_selling_price'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="text" name="purch_batch[]" class="form-control bg-light text-center" id="purch_batch'.$i.'" style="border-width:0px">
                        </td>
                        <td>
                            <input type="date" name="purch_expiry_date[]" class="form-control bg-light text-center" id="purch_expiry_date'.$i.'" style="border-width:0px">
                        </td>
                        <td class="action-td">';
                            if($i > 1)
                            {
                                $value .= '<a href="#" id="delete_purchase_item" data-id="'.$i.'"><i class="fa fa-trash fa-sm"></i></a>';
                            };
                        $value .= '</td>
                    </tr>';
                };
                echo $value;
