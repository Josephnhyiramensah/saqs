$(document).ready(function()
{

	//REPORTS
		//STOCK REPORT
			stock_report_modal();
			stock_report_display();
			stock_report_item_tally_card();
		//TALLY CARD
			stock_item_tally_card_modal();
			stock_ietm_tally_card_get_category();
			stock_item_tally_card_display();
			
		//DISPENSED REPORT
			dispensed_report_modal();
			dispensed_report_display();
			dispensed_report_item();
		//PURCHASE REPORT
			purchase_report_modal();
			purchase_report_display();
		//SALES REPORT
			sales_report_modal();
			sales_report_display();
		//LEDGER REPORT
			ledger_report_modal();
			ledger_report_display();
		//LEDGER DETAIL REPORT
			ledger_detail_report_modal();
			ledger_detail_report_display();
		//LEDGER SUMMARY REPORT
			ledger_summary_report_modal();
			ledger_summary_report_display();
		//ATTENDANCE SUMMARY REPORT
			attend_summary_report_modal();
			attend_summary_report_display();
			attend_detail_report_display();
		//NHIS SPECIALTY REPORT
			nhis_specialty_report_modal();
			nhis_specialty_report_display();
			nhis_specialty_detail_report_modal();
			nhis_specialty_detail_report_display();
			nhis_specialty_detail_report_xml();
			nhis_open_claim_form();
			nhis_procedure_list_edit();
			nhis_procedure_list_change_gdrg();
			nhis_procedure_list_change_diagnosis();
			nhis_procedure_list_update();
			nhis_add_procedure();
			nhis_add_procedure_save();
			nhis_procedure_list_delete();
			nhis_add_diagnosis_list();
			nhis_diagnosis_list_save();
			nhis_diagnosis_list_edit();
			nhis_diagnosis_list_change_gdrg();
			nhis_diagnosis_list_change_diagnosis();
			nhis_diagnosis_list_update();
			nhis_diagnosis_list_delete();
			nhis_drug_list_edit();
			nhis_drug_list_save();
			nhis_add_drug();
			nhis_add_drug_save();
			nhis_drug_delete();
			nhis_set_drug_amount();
			nhis_set_drug_price_and_code();
			nhis_attendance_edit();
			nhis_attendance_update();
			nhis_set_specialty_code();
		//PAYMENT TYPE REPORT
			payment_type_report_modal();
			payment_type_report_display();
		//PATIENT CASH STATEMENT
			patient_insurance_statement_display_attend();
			patient_cash_statement_display_attend();
			patient_cash_statement_display_patient();
		//STATISTICS
			doctors_attend_register_modal();
			doctors_attend_register_display();
			incidence_of_disease_modal();
			incidence_of_disease_display();
		//LAB OCCURANCE REPORT
			lab_occurance_modal();
			lab_occurance_display();
		//STATEMENT OF OUT-PATIENT
			statement_of_out_patient_modal();
			statement_of_out_patient_display();
		//STATEMENT OF IN-PATIENT
			statement_of_in_patient_modal();
			statement_of_in_patient_display();
		//HELP
			sign_in_help();
});

//SETUP

			//STOCK REPORT
				function stock_report_modal()
				{
					$(document).on('click','#stock_report_link',function()
					{
						var stock_report_company_id = $('#session_company_id').val();
						var stock_report_user_id = $('#session_user_super_id').val();
						$('#stock_report_modal_form').trigger('reset');
						$('#stock_report_company_id').val(stock_report_company_id);
						$('#stock_report_user_id').val(stock_report_user_id);
						$('#stock_report_modal').modal('show');
					}) 
				}

				function stock_report_display()
				{
					$(document).on('click','#stock_report_ok_btn',function()
					{
						var stock_report_company_id = $('#session_company_id').val();
						var stock_report_user_id = $('#session_user_super_id').val();
						var stock_report_warehouse = $('#stock_report_warehouse').val();
						var stock_report_start_date = $('#stock_report_start_date').val();
						var stock_report_end_date = $('#stock_report_end_date').val();
						if (stock_report_start_date !== "") 
						{
							if (stock_report_end_date !== "") 
							{
								if (stock_report_end_date >= stock_report_start_date) 
								{
									if (stock_report_warehouse !=="") 
									{
										$.ajax({
								             url:'/layout/reports/stock_report_processing.php',
								             method:'POST',
								             data:$('#stock_report_modal_form').serialize(),
								             success:function(data)
									             {
							             			$('#stock_report_modal').modal('hide');
							             			window.open('/layout/reports/stock_report_display.php', '_blank');
									             }
								        });	
									} 
									else 
									{
										$('#stock_report_modal_warning').html('<h6 style=color:red;>Please the Warehouse cannot be EMPTY!</h6>');
										$('#stock_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
									};
								} 
								else 
								{
									$('#stock_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
									$('#stock_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#stock_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
								$('#stock_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#stock_report_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
							$('#stock_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					}); 
				}

				function stock_report_item_tally_card()
				{
					$(document).on('click','#stock_report_item_tally_card',function()
					{
						var item_id = $(this).attr('data-id');
						var category_id = $(this).attr('data-id1');
						var warehouse_id = $(this).attr('data-id2');
						var start_date = $(this).attr('data-id3');
						var end_date = $(this).attr('data-id4');
						var company_id = $(this).attr('data-id5');
						$.ajax({
				             url:'/layout/reports/stock_report_item_tally_card.php',
				             method:'POST',
				             data:{
				             	item_id:item_id,
				             	category_id:category_id,
				             	warehouse_id:warehouse_id,
				             	start_date:start_date,
				             	end_date:end_date,
				             	company_id:company_id
				             },
				             success:function(data)
					             {
			             			//$('#stock_report_modal').modal('hide');
			             			window.open('/layout/reports/stock_report_item_tally_card_display.php', '_blank');
					             }
				        });	
					}); 
				}
			//TALLY CARD
				function stock_item_tally_card_modal()
				{
					$(document).on('click','#stock_item_tally_card_link',function()
					{
						var stock_item_tally_card_company_id = $('#session_company_id').val();
						var stock_item_tally_card_user_id = $('#session_user_super_id').val();
						$('#stock_item_tally_card_modal_form').trigger('reset');
						$('#stock_item_tally_card_company_id').val(stock_item_tally_card_company_id);
						$('#stock_item_tally_card_user_id').val(stock_report_user_id);
						$('#stock_item_tally_card_modal').modal('show');
					});
				}

				function stock_ietm_tally_card_get_category()
				{
					$(document).on('change','#stock_item_tally_card_item',function(){ 

						var category_id = $('option:selected', this).attr('data-value');
						$('#stock_item_tally_card_category_id').val(category_id);
					});
				}

				function stock_item_tally_card_display()
				{
					$(document).on('click','#stock_item_tally_card_ok_btn',function()
					{
						var company_id = $('#session_company_id').val();
						var user_id = $('#session_user_super_id').val();
						var item_id = $('#stock_item_tally_card_item').val();
						var category_id = $('#stock_item_tally_card_category_id').val();
						var warehouse_id = $('#stock_item_tally_card_warehouse').val();
						var start_date = $('#stock_item_tally_card_start_date').val();
						var end_date = $('#stock_item_tally_card_end_date').val();
						if (start_date !== "") 
						{
							if (end_date !== "") 
							{
								if (end_date >= start_date) 
								{
									if (warehouse_id !=="") 
									{
										if (item_id !=="" && item_id > 0) 
										{
											$.ajax({
									             url:'/layout/reports/stock_report_item_tally_card.php',
									             method:'POST',
									             data:{
									             	company_id:company_id,
									             	item_id:item_id,
									             	category_id:category_id,
									             	warehouse_id:warehouse_id,
									             	start_date:start_date,
									             	end_date:end_date
									             },
									             success:function(data)
										             {
								             			$('#stock_item_tally_card_modal').modal('hide');
								             			window.open('/layout/reports/stock_report_item_tally_card_display.php', '_blank');
										             }
									        });
										} 
										else 
										{
											$('#stock_item_tally_card_modal_warning').html('<h6 style=color:red;>Please the Item cannot be EMPTY!</h6>');
											$('#stock_item_tally_card_modal_warning').hide().slideDown().delay(2000).fadeOut();
										};	
									} 
									else 
									{
										$('#stock_item_tally_card_modal_warning').html('<h6 style=color:red;>Please the Warehouse cannot be EMPTY!</h6>');
										$('#stock_item_tally_card_modal_warning').hide().slideDown().delay(2000).fadeOut();
									};
								} 
								else 
								{
									$('#stock_item_tally_card_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
									$('#stock_item_tally_card_modal_warning').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#stock_item_tally_card_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
								$('#stock_item_tally_card_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#stock_item_tally_card_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
							$('#stock_item_tally_card_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					}); 
				}
			//DISPENSED REPORT
				function dispensed_report_modal()
				{
					$(document).on('click','#dispensed_report_link',function()
					{
						$('#dispensed_report_modal_form').trigger('reset');
						$('#dispensed_report_modal').modal('show');
					}) 
				}

				function dispensed_report_display()
				{
					$(document).on('click','#dispensed_report_ok_btn',function()
					{
						var dispensed_report_warehouse = $('#dispensed_report_warehouse').val();
						var dispensed_report_start_date = $('#dispensed_report_start_date').val();
						var dispensed_report_end_date = $('#dispensed_report_end_date').val();
						
						if (dispensed_report_start_date != "") 
						{
							if (dispensed_report_end_date != "") 
							{
								if (dispensed_report_end_date >= dispensed_report_start_date) 
								{
									if (dispensed_report_warehouse !="") 
									{
										$.ajax({
											url:'/layout/reports/dispensed_report_processing.php',
											method:'POST',
											data:$('#dispensed_report_modal_form').serialize(),
											success:function(data)
											{
												$('#dispensed_report_modal').modal('hide');
												window.open('/layout/reports/dispensed_report_display.php', '_blank');
											}
										});	
									} 
									else 
									{
										$('#dispensed_report_modal_warning').html('<h6 style=color:red;>Please the Warehouse cannot be EMPTY!</h6>');
										$('#dispensed_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
									};
								} 
								else 
								{
									$('#dispensed_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
									$('#dispensed_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#dispensed_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
								$('#dispensed_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#dispensed_report_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
							$('#dispensed_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					}); 
				}

				function dispensed_report_item()
				{
					$(document).on('click','#dispensed_report_item',function()
					{
						var item_id = $(this).attr('data-id');
						var warehouse_id = $(this).attr('data-id2');
						var start_date = $(this).attr('data-id3');
						var end_date = $(this).attr('data-id4');
						$.ajax({
								url:'/layout/reports/dispensed_report_item.php',
								method:'POST',
								data:{
									item_id:item_id,
									warehouse_id:warehouse_id,
									start_date:start_date,
									end_date:end_date
								},
								success:function(data)
								{
									window.open('/layout/reports/dispensed_report_item_display.php', '_blank');
								}
						});	
					}); 
				}
	//REPORTS
		//PURCHASE REPORT
			function purchase_report_modal()
			{
				$(document).on('click','#purchase_report_link',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					var start_date = $('#start_date').val();
					var end_date = $('#end_date').val();
					$('#purchase_report_modal_form').trigger('reset');
					$('#company_id').val(company_id);
					$('#user_super_id').val(user_super_id);
					$('#purchase_report_modal').modal('show');
				}) 
			}

			function purchase_report_display()
			{
				$(document).on('click','#purch_report_ok_btn',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					var start_date = $('#start_date').val();
					var end_date = $('#end_date').val();
					if (start_date !== "") 
					{
						if (end_date !== "") 
						{
							if (end_date >= start_date) 
							{
								$.ajax({
						             url:'/goldchest/layout/reports/purchase_report_processing.php',
						             method:'POST',
						             data:$('#purchase_report_modal_form').serialize(),
						             success:function(data)
							             {
							             	//$('#purchase_report_modal_form').trigger('reset');
					             			$('#purchase_report_modal').modal('hide');
					             			window.open('/goldchest/layout/reports/purchase_report_display.php', '_blank');
							             }
						        });	
							} 
							else 
							{
								$('#purchase_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
								$('#purchase_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#purchase_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
							$('#purchase_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#purchase_report_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
						$('#purchase_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
					};
				}); 
			}
		//SALES REPORT
			function sales_report_modal()
			{
				$(document).on('click','#sales_report_link',function()
				{
					var company_id_sales = $('#session_company_id').val();
					var user_super_id_sales = $('#session_user_super_id').val();
					var start_date_sales = $('#start_date_sales').val();
					var end_date_sales = $('#end_date_sales').val();
					$('#sales_report_modal_form').trigger('reset');
					$('#company_id_sales').val(company_id_sales);
					$('#user_super_id_sales').val(user_super_id_sales);
					$('#sales_report_modal').modal('show');
				}) 
			}

			function sales_report_display()
			{
				$(document).on('click','#sales_report_ok_btn',function()
				{
					var company_id_sales = $('#session_company_id').val();
					var user_super_id_sales = $('#session_user_super_id').val();
					var start_date_sales = $('#start_date_sales').val();
					var end_date_sales = $('#end_date_sales').val();
					if (start_date_sales !== "") 
					{
						if (end_date_sales !== "") 
						{
							if (end_date_sales >= start_date_sales) 
							{
								$.ajax({
						             url:'/goldchest/layout/reports/sales_report_processing.php',
						             method:'POST',
						             data:$('#sales_report_modal_form').serialize(),
						             success:function(data)
							             {
					             			$('#sales_report_modal').modal('hide');
					             			window.open('/goldchest/layout/reports/sales_report_display.php', '_blank');
							             }
						        });	
							} 
							else 
							{
								$('#sales_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
								$('#sales_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#sales_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
							$('#sales_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#sales_report_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
						$('#sales_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
					};
				}); 
			}
		//LEDGER REPORT
			function ledger_report_modal()
			{
				$(document).on('click','#ledger_report_link',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					$('#ledger_report_modal_form').trigger('reset');
					$('#ledger_report_company_id').val(company_id);
					$('#ledger_report_user_super_id').val(user_super_id);
					$('#ledger_report_modal').modal('show');
				}) 
			}

			function ledger_report_display()
			{
				$(document).on('click','#ledger_report_ok_btn',function()
				{
					var company_id = $('#ledger_report_company_id').val();
					var user_super_id = $('#ledger_report_user_super_id').val();
					var ledger_id = $('#ledger_report_ledger_id').val();
					var start_date = $('#ledger_report_start_date').val();
					var end_date = $('#ledger_report_end_date').val();
					if (ledger_id > 0) 
					{
						if (start_date !== "") 
						{
							if (end_date !== "") 
							{
								if (end_date >= start_date) 
								{
									$.ajax({
							             url:'/layout/reports/ledger_report_processing.php',
							             method:'POST',
							             data:$('#ledger_report_modal_form').serialize(),
							             success:function(data)
								             {
						             			$('#ledger_report_modal').modal('hide');
						             			window.open('/layout/reports/ledger_report_display.php', '_blank');
								             }
							        });	
								} 
								else 
								{
									$('#ledger_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
									$('#ledger_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#ledger_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
								$('#ledger_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#ledger_report_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
							$('#ledger_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#ledger_report_modal_warning').html('<h6 style=color:red;>Please the Ledger cannot be EMPTY!</h6>');
						$('#ledger_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
					};
				}); 
			}
		//LEDGER DETAIL REPORT
			function ledger_detail_report_modal()
			{
				$(document).on('click','#ledger_detail_report_link',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					$('#ledger_detail_report_modal_form').trigger('reset');
					$('#ledger_detail_report_company_id').val(company_id);
					$('#ledger_detail_report_user_super_id').val(user_super_id);
					$('#ledger_detail_report_modal').modal('show');
				});
			}

			function ledger_detail_report_display()
			{
				$(document).on('click','#ledger_detail_report_ok_btn',function()
				{
					var company_id = $('#ledger_detail_report_company_id').val();
					var user_super_id = $('#ledger_detail_report_user_super_id').val();
					var start_date = $('#ledger_detail_report_start_date').val();
					var end_date = $('#ledger_detail_report_end_date').val();
					
					if (start_date !== "") 
					{
						if (end_date !== "") 
						{
							if (end_date >= start_date) 
							{
								$.ajax({
						             url:'/layout/reports/ledger_detail_report_processing.php',
						             method:'POST',
						             data:$('#ledger_detail_report_modal_form').serialize(),
						             success:function(data)
							             {
					             			$('#ledger_detail_report_modal').modal('hide');
					             			window.open('/layout/reports/ledger_detail_report_display.php', '_blank');
							             }
						        });	
							} 
							else 
							{
								$('#ledger_detail_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
								$('#ledger_detail_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#ledger_detail_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
							$('#ledger_detail_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#ledger_detail_report_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
						$('#ledger_detail_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
					};
				}); 
			}
		//LEDGER SUMMARY REPORT
			function ledger_summary_report_modal()
			{
				$(document).on('click','#ledger_summary_report_link',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					$('#ledger_summary_report_modal_form').trigger('reset');
					$('#ledger_summary_report_company_id').val(company_id);
					$('#ledger_summary_report_user_super_id').val(user_super_id);
					$('#ledger_summary_report_modal').modal('show');
				});
			}

			function ledger_summary_report_display()
			{
				$(document).on('click','#ledger_summary_report_ok_btn',function()
				{
					var company_id = $('#ledger_summary_report_company_id').val();
					var user_super_id = $('#ledger_summary_report_user_super_id').val();
					var start_date = $('#ledger_summary_report_start_date').val();
					var end_date = $('#ledger_summary_report_end_date').val();
					
					if (start_date !== "") 
					{
						if (end_date !== "") 
						{
							if (end_date >= start_date) 
							{
								$.ajax({
						             url:'/layout/reports/ledger_summary_report_processing.php',
						             method:'POST',
						             data:$('#ledger_summary_report_modal_form').serialize(),
						             success:function(data)
							             {
					             			$('#ledger_summary_report_modal').modal('hide');
					             			window.open('/layout/reports/ledger_summary_report_display.php', '_blank');
							             }
						        });	
							} 
							else 
							{
								$('#ledger_summary_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
								$('#ledger_summary_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#ledger_summary_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
							$('#ledger_summary_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#ledger_summary_report_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
						$('#ledger_summary_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
					};
				}); 
			}
		//ATTENDANCE SUMMARY REPORT
			function attend_summary_report_modal()
			{
				$(document).on('click','#attend_summary_report_link',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					$('#attend_summary_report_modal_form').trigger('reset');
					$('#attend_summary_report_company_id').val(company_id);
					$('#attend_summary_report_user_super_id').val(user_super_id);
					$('#attend_summary_report_modal').modal('show');
				});
			}

			function attend_summary_report_display()
			{
				$(document).on('click','#attend_summary_report_ok_btn',function()
				{
					var company_id = $('#attend_summary_report_company_id').val();
					var user_super_id = $('#attend_summary_report_user_super_id').val();
					var start_date = $('#attend_summary_report_start_date').val();
					var end_date = $('#attend_summary_report_end_date').val();
					
					if (start_date !== "") 
					{
						if (end_date !== "") 
						{
							if (end_date >= start_date) 
							{
								$.ajax({
						             url:'/layout/reports/attend_summary_report_processing.php',
						             method:'POST',
						             data:$('#attend_summary_report_modal_form').serialize(),
						             success:function(data)
							             {
					             			$('#attend_summary_report_modal').modal('hide');
					             			window.open('/layout/reports/attend_summary_report_display.php', '_blank');
							             }
						        });	
							} 
							else 
							{
								$('#attend_summary_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
								$('#attend_summary_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#attend_summary_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
							$('#attend_summary_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#attend_summary_report_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
						$('#attend_summary_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
					};
				}); 
			}

			function attend_detail_report_display()
			{
				$(document).on('click','#btn_open_attend_details',function()
				{
					var attend_id = $(this).attr('data-id');
					var patient_id = $(this).attr('data-id1');
					var company_id = $(this).attr('data-id2');
					var date_admit = $(this).attr('data-id3');
					var date_disch = $(this).attr('data-id4');
					var name = $(this).attr('data-id5');
					var start_date = $(this).attr('data-id6');
					var end_date = $(this).attr('data-id7');
					$.ajax({
			             url:'/layout/reports/attend_detail_report_processing.php',
			             method:'POST',
			             data:{
			             	attend_id:attend_id,
			             	patient_id:patient_id,
			             	company_id:company_id,
			             	date_admit:date_admit,
			             	date_disch:date_disch,
			             	name:name,
							start_date:start_date,
							end_date:end_date
			             },
			             success:function(data)
			             {
	             			window.open('/layout/reports/attend_detail_report_display.php', '_blank');
			             }
			        });	
				}); 
			}
		//NHIS SPECIALTY REPORT
			function nhis_specialty_report_modal()
			{
				$(document).on('click','#nhis_specialty_summary_link',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					$('#nhis_specialty_report_modal_form').trigger('reset');
					$('#nhis_specialty_report_company_id').val(company_id);
					$('#nhis_specialty_report_user_super_id').val(user_super_id);
					$('#nhis_specialty_report_modal').modal('show');
				});
			}

			function nhis_specialty_report_display()
			{
				$(document).on('click','#nhis_specialty_report_ok_btn',function()
				{
					var company_id = $('#nhis_specialty_report_company_id').val();
					var user_super_id = $('#nhis_specialty_report_user_super_id').val();
					var start_date = $('#nhis_specialty_report_start_date').val();
					var end_date = $('#nhis_specialty_report_end_date').val();
					
					if (start_date !== "") 
					{
						if (end_date !== "") 
						{
							if (end_date >= start_date) 
							{
								$.ajax({
						             url:'/layout/reports/nhis_specialty_report_processing.php',
						             method:'POST',
						             data:$('#nhis_specialty_report_modal_form').serialize(),
						             success:function(data)
							             {
					             			$('#nhis_specialty_report_modal').modal('hide');
					             			window.open('/layout/reports/nhis_specialty_report_display.php', '_blank');
							             }
						        });	
							} 
							else 
							{
								$('#nhis_specialty_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
								$('#nhis_specialty_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#nhis_specialty_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
							$('#nhis_specialty_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#nhis_specialty_report_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
						$('#nhis_specialty_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
					};
				}); 
			}

			function nhis_specialty_detail_report_modal()
			{
				$(document).on('click','#nhis_specialty_detail_link',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					$('#nhis_specialty_detail_report_modal_form').trigger('reset');
					$('#nhis_specialty_detail_report_company_id').val(company_id);
					$('#nhis_specialty_detail_report_user_super_id').val(user_super_id);
					$('#nhis_specialty_detail_report_modal').modal('show');
				});
			}

			function nhis_specialty_detail_report_display()
			{
				$(document).on('click','#nhis_specialty_detail_report_ok_btn',function()
				{
					var company_id = $('#nhis_specialty_detail_report_company_id').val();
					var user_super_id = $('#nhis_specialty_detail_report_user_super_id').val();
					var start_date = $('#nhis_specialty_detail_report_start_date').val();
					var end_date = $('#nhis_specialty_detail_report_end_date').val();
					
					if (start_date !== "") 
					{
						if (end_date !== "") 
						{
							if (end_date >= start_date) 
							{
								$.ajax({
						             url:'/layout/reports/nhis_specialty_detail_report_processing.php',
						             method:'POST',
						             data:$('#nhis_specialty_detail_report_modal_form').serialize(),
						             success:function(data)
						             {
				             			$('#nhis_specialty_detail_report_modal').modal('hide');
				             			window.open('/layout/reports/nhis_specialty_detail_report_display.php', '_blank');
						             }
						        });	
							} 
							else 
							{
								$('#nhis_specialty_detail_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
								$('#nhis_specialty_detail_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#nhis_specialty_detail_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
							$('#nhis_specialty_detail_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#nhis_specialty_detail_report_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
						$('#nhis_specialty_detail_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
					};
				}); 
			}

			function nhis_specialty_detail_report_xml()
			{
				$(document).on('click','#btn_convert_to_xml',function()
				{
					//var company_id = $('#nhis_specialty_detail_report_company_id').val();
					var start_date = $(this).attr('data-id');
					var end_date = $(this).attr('data-id1');
					$.ajax({
							url:'/layout/reports/nhis_specialty_detail_report_xml_processing.php',
							method:'POST',
							data:{
								//company_id:company_id,
								start_date:start_date,
								end_date:end_date
							},
							success:function(data)
							{
								window.open('/layout/reports/nhis_claims_generate_xml.php', '_blank');
							}
					});
				}); 
			}

			function nhis_open_claim_form()
			{
				$(document).on('click','#btn_open_claim_form',function()
				{
					var attend_id = $(this).attr('data-id');
					var patient_id = $(this).attr('data-id1');
					var payment_type_id = $(this).attr('data-id2');
					var date_admit = $(this).attr('data-id3');
					var date_disch = $(this).attr('data-id4');
					var name = $(this).attr('data-id5');
					
					$.ajax({
			             url:'/layout/reports/nhis_open_claim_form_processing.php',
			             method:'POST',
			             data:{
							payment_type_id:payment_type_id,
							attend_id:attend_id,
							patient_id:patient_id},
			             success:function(data)
			             {
	             			window.open('/layout/reports/nhis_claim_form.php', '_blank');
			             }
					});	
				}); 
			}

			function nhis_procedure_list_edit()
			{
				$(document).on('click','#btn_nhis_procedure_edit',function()
				{
					var surgery_list_id = $(this).attr('data-id');
					$.ajax({
						url:'/layout/reports/nhis_procedure_list_edit.php',
						method:'POST',
						data:{surgery_list_id:surgery_list_id},
						datatype:'JSON',
						success:function(data)
						{
							var res = $.parseJSON(data);
							$('#nhis_procedure_detail_form').trigger('reset');
							$('#nhis_surgerylist_id').val(res[0]);
							$('#nhis_procedure_gdrg').val(res[4]);
							$('#nhis_procedure_description').val(res[5]);
							$('#nhis_procedure_diagnosis').val(res[6]);
							$('#nhis_procedure_icd_10').val(res[7]);
							$('#nhis_procedure_date').val(res[1]);
							$('#nhis_procedure_is_principal').val(res[2]);
							$('#nhis_procedure_comment').val(res[8]);
							$('#nhis_procedure_amount').val(res[3]);
							$('#nhis_procedure_amountD').val(res[3]);
							$('#nhis_procedure_amount_cash').val(res[9]);
							$('#nhis_procedure_amount_prvt').val(res[10]);
							$('#nhis_procedure_attend_id').val(res[11]);
							$('#nhis_procedure_patient_id').val(res[12]);
							$('#btn_nhis_procedure_save').hide();
							$('#btn_nhis_procedure_update').show();
							$('#nhis_procedure_detail_modal').modal('show');
						}
					});
				}); 
			}

			function nhis_procedure_list_change_gdrg()
			{
				$(document).on('change','#nhis_procedure_gdrg',function()
				{
					var nhis_id = $(this).val();
					var age = $('#session_age').val();
					$.ajax({
						url:'/layout/reports/nhis_procedure_list_change_gdrg.php',
						method:'POST',
						data:{nhis_id:nhis_id},
						datatype:'JSON',
						success:function(data)
						{
							var res = $.parseJSON(data);
							if(age < 12)
							{
								var gdrg = res[2];
							}
							else
							{
								var gdrg = res[1];
							};
							$('#nhis_procedure_description').val(res[0]);
							$('#nhis_procedure_amount').val(gdrg);
						}
					});
				}); 
			}

			function nhis_procedure_list_change_diagnosis()
			{
				$(document).on('change','#nhis_procedure_diagnosis',function()
				{
					var surgery_id = $(this).val();
					$.ajax({
						url:'/layout/reports/nhis_procedure_list_change_diagnosis.php',
						method:'POST',
						data:{surgery_id:surgery_id},
						datatype:'JSON',
						success:function(data)
						{
							var res = $.parseJSON(data);
							$('#nhis_procedure_icd_10').val(res[0]);
						}
					});
				}); 
			}

			function nhis_procedure_list_update()
			{
				$(document).on('click','#btn_nhis_procedure_update',function(e){
					e.preventDefault();
					var nhis_surgerylist_id = $('#nhis_surgerylist_id').val();
					var nhis_procedure_gdrg = $('#nhis_procedure_gdrg').val();
					var nhis_procedure_amount = $('#nhis_procedure_amount').val();
					var nhis_procedure_diagnosis = $('#nhis_procedure_diagnosis').val();
					var nhis_procedure_date = $('#nhis_procedure_date').val();
					var nhis_procedure_is_principal = $('#nhis_procedure_is_principal').val();
					var nhis_procedure_comment = $('#nhis_procedure_comment').val();
					var attend_id = $('#nhis_procedure_attend_id').val();
					var patient_id = $('#nhis_procedure_patient_id').val();
					
					if (nhis_procedure_gdrg !=="") 
					{
						if (nhis_procedure_diagnosis !=="") 
						{
							if (nhis_procedure_date !== "") 
							{
								if (nhis_procedure_is_principal !=="" || nhis_procedure_is_principal == 0) 
								{
									$.ajax({
										url:'/layout/reports/nhis_procedure_list_update.php',
										method:'POST',
										data:$('#nhis_procedure_detail_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
										success:function(data)
										{
											$('#nhis_procedure_detail_form').trigger('reset');
											$('#nhis_procedure_detail_modal').modal('hide');
											window.location.href="/layout/reports/nhis_claim_form.php";
										}
									});	
								} 
								else 
								{
									alert('Please the Principal should be either Yes or No!');
								};
							} 
							else 
							{
								alert('The Date cannot be EMPTY!');
							};
						} 
						else 
						{
							alert('The Procedure/Surgery cannot be EMPTY!');
						};
					} 
					else 
					{
						alert('The G-DRG cannot be EMPTY!');
					};
				});
			}
			
			function nhis_add_procedure()
			{
				$(document).on('click','#btn_nhis_procedure_add',function()
				{
					$('#nhis_procedure_detail_modal_title').text('Add NHIS Procedure');
					$('#nhis_procedure_detail_form').trigger('reset');
					$('#btn_nhis_procedure_update').hide();
					$('#btn_nhis_procedure_save').show();
					$('#nhis_procedure_detail_modal').modal('show');
				}); 
			}

			function nhis_add_procedure_save()
			{
				$(document).on('click','#btn_nhis_procedure_save',function(e){
					e.preventDefault();
					var nhis_procedure_gdrg = $('#nhis_procedure_gdrg').val();
					var nhis_procedure_diagnosis = $('#nhis_procedure_diagnosis').val();
					var nhis_procedure_date = $('#nhis_procedure_date').val();
					var nhis_procedure_is_principal = $('#nhis_procedure_is_principal').val();
					var attend_id = $('#nhis_procedure_attend_id').val();
					var patient_id = $('#nhis_procedure_patient_id').val();
					
					if (nhis_procedure_gdrg !=="") 
					{
						if (nhis_procedure_diagnosis !=="") 
						{
							if (nhis_procedure_date !== "") 
							{
								if (nhis_procedure_is_principal !=="" || nhis_procedure_is_principal == 0) 
								{
									$.ajax({
										url:'/layout/reports/nhis_procedure_list_save.php',
										method:'POST',
										data:$('#nhis_procedure_detail_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
										success:function(data)
										{
											$('#nhis_procedure_detail_form').trigger('reset');
											$('#nhis_procedure_detail_modal').modal('hide');
											window.location.href="/layout/reports/nhis_claim_form.php";
										}
									});	
								} 
								else 
								{
									alert('Please the Principal should be either Yes or No!');
								};
							} 
							else 
							{
								alert('The Date cannot be EMPTY!');
							};
						} 
						else 
						{
							alert('The Procedure/Surgery cannot be EMPTY!');
						};
					} 
					else 
					{
						alert('The G-DRG cannot be EMPTY!');
					};
				});
			}

			function nhis_procedure_list_delete()
			{
				$(document).on('click','#btn_nhis_procedure_delete',function(e){
					e.preventDefault();
					var surgery_list_id = $(this).attr('data-id');
					var currentRow=$(this).closest("tr");
					var surgery = currentRow.find("td:eq(2)").text();
					$('#nhis_delete_question').text('Are you sure you want to delete Procedure/Surgery:' + surgery + '?');
					$('#nhis_delete_modal_title').text('NHIS Procedure/Surgery Deletion');
					$('#nhis_delete_modal').modal('show');
					$(document).on('click','#nhis_del_yes',function(){
						$.ajax({
							url:'/layout/reports/nhis_procedure_list_delete.php',
							method:'POST',
							data:{surgery_list_id:surgery_list_id},
							success:function(data)
							{
								window.location.href="/layout/reports/nhis_claim_form.php";
							}
						});
					});
					$(document).on('click','#nhis_del_no',function()
					{
						$('#nhis_delete_modal').modal('hide');
					});
				});
			}

			function nhis_diagnosis_list_edit()
			{
				$(document).on('click','#btn_nhis_diagnosis_edit',function()
				{
					var diagnosis_list_id = $(this).attr('data-id');
					$.ajax({
						url:'/layout/reports/nhis_diagnosis_list_edit.php',
						method:'POST',
						data:{diagnosis_list_id:diagnosis_list_id},
						datatype:'JSON',
						success:function(data)
						{
							var res = $.parseJSON(data);
							$('#nhis_diagnosis_detail_form').trigger('reset');
							$('#nhis_diagnosislist_id').val(res[0]);
							$('#nhis_diagnosis_gdrg').val(res[4]);
							$('#nhis_diagnosis_description').val(res[5]);
							$('#nhis_diagnosis_id').val(res[6]);
							$('#nhis_diagnosis_icd_10').val(res[7]);
							$('#nhis_diagnosis_date').val(res[1]);
							$('#nhis_diagnosis_is_principal').val(res[2]);
							$('#nhis_diagnosis_comment').val(res[8]);
							$('#nhis_diagnosis_amount').val(res[3]);
							$('#nhis_diagnosis_amountD').val(res[3]);
							$('#nhis_diagnosis_amount_cash').val(res[9]);
							$('#nhis_diagnosis_amount_prvt').val(res[10]);
							$('#nhis_diagnosis_attend_id').val(res[11]);
							$('#nhis_diagnosis_patient_id').val(res[12]);
							$('#btn_nhis_diagnosis_save').hide();
							$('#btn_nhis_diagnosis_update').show();
							$('#nhis_diagnosis_detail_modal').modal('show');
						}
					});
				}); 
			}

			function nhis_diagnosis_list_change_gdrg()
			{
				$(document).on('change','#nhis_diagnosis_gdrg',function()
				{
					var nhis_id = $(this).val();
					var age = $('#session_age').val();
					$.ajax({
						url:'/layout/reports/nhis_diagnosis_list_change_gdrg.php',
						method:'POST',
						data:{nhis_id:nhis_id},
						datatype:'JSON',
						success:function(data)
						{
							var res = $.parseJSON(data);
							if(age < 12)
							{
								var gdrg = res[2];
							}
							else
							{
								var gdrg = res[1];
							};
							$('#nhis_diagnosis_description').val(res[0]);
							$('#nhis_diagnosis_amount').val(gdrg);
						}
					});
				}); 
			}

			function nhis_diagnosis_list_change_diagnosis()
			{
				$(document).on('change','#nhis_diagnosis_id',function()
				{
					var diagnosis_id = $(this).val();
					$.ajax({
						url:'/layout/reports/nhis_diagnosis_list_change_diagnosis.php',
						method:'POST',
						data:{diagnosis_id:diagnosis_id},
						datatype:'JSON',
						success:function(data)
						{
							var res = $.parseJSON(data);
							$('#nhis_diagnosis_icd_10').val(res[0]);
						}
					});
				}); 
			}

			function nhis_diagnosis_list_update()
			{
				$(document).on('click','#btn_nhis_diagnosis_update',function(e){
					e.preventDefault();
					var nhis_diagnosislist_id = $('#nhis_diagnosislist_id').val();
					var nhis_diagnosis_gdrg = $('#nhis_diagnosis_gdrg').val();
					var nhis_diagnosis_amount = $('#nhis_diagnosis_amount').val();
					var nhis_diagnosis = $('#nhis_diagnosis_id').val();
					var nhis_diagnosis_date = $('#nhis_diagnosis_date').val();
					var nhis_diagnosis_is_principal = $('#nhis_diagnosis_is_principal').val();
					var nhis_diagnosis_comment = $('#nhis_diagnosis_comment').val();
					var attend_id = $('#nhis_diagnosis_attend_id').val();
					var patient_id = $('#nhis_diagnosis_patient_id').val();
					
					if (nhis_diagnosis_gdrg !=="")
					{
						if (nhis_diagnosis_id !=="") 
						{
							if (nhis_diagnosis_date !== "") 
							{
								if (nhis_diagnosis_is_principal !=="" || nhis_diagnosis_is_principal == 0) 
								{
									$.ajax({
										url:'/layout/reports/nhis_diagnosis_list_update.php',
										method:'POST',
										data:$('#nhis_diagnosis_detail_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
										success:function(data)
										{
											$('#nhis_diagnosis_detail_form').trigger('reset');
											$('#nhis_diagnosis_detail_modal').modal('hide');
											window.location.href="/layout/reports/nhis_claim_form.php";
										}
									});	
								} 
								else 
								{
									alert('Please the Principal should be either Yes or No!');
								};
							} 
							else 
							{
								alert('The Date cannot be EMPTY!');
							};
						} 
						else 
						{
							alert('The Diagnosis cannot be EMPTY!');
						};
					} 
					else 
					{
						alert('The G-DRG cannot be EMPTY!');
					};
				});
			}
			
			function nhis_add_diagnosis_list()
			{
				$(document).on('click','#btn_nhis_diagnosis_add',function()
				{
					$('#nhis_diagnosis_detail_modal_title').text('Add NHIS Diagnosis');
					$('#nhis_diagnosis_detail_form').trigger('reset');
					$('#btn_nhis_diagnosis_update').hide();
					$('#btn_nhis_diagnosis_save').show();
					$('#nhis_diagnosis_detail_modal').modal('show');
				}); 
			}

			function nhis_diagnosis_list_save()
			{
				$(document).on('click','#btn_nhis_diagnosis_save',function(e){
					e.preventDefault();
					var nhis_diagnosis_gdrg = $('#nhis_diagnosis_gdrg').val();
					var nhis_diagnosis_id = $('#nhis_diagnosis_id').val();
					var nhis_diagnosis_date = $('#nhis_diagnosis_date').val();
					var nhis_diagnosis_is_principal = $('#nhis_diagnosis_is_principal').val();
					var attend_id = $('#nhis_diagnosis_attend_id').val();
					var patient_id = $('#nhis_diagnosis_patient_id').val();
					
					if (nhis_diagnosis_gdrg !="")
					{
						if (nhis_diagnosis_id !="") 
						{
							if (nhis_diagnosis_date != "")
							{
								if (nhis_diagnosis_is_principal !="" || nhis_diagnosis_is_principal == 0) 
								{
									$.ajax({
										url:'/layout/reports/nhis_diagnosis_list_save.php',
										method:'POST',
										data:$('#nhis_diagnosis_detail_form').serialize() + 
										'&attend_id=' + attend_id + '&patient_id=' + patient_id,
										success:function(data)
										{
											$('#nhis_diagnosis_detail_form').trigger('reset');
											$('#nhis_diagnosis_detail_modal').modal('hide');
											window.location.href="/layout/reports/nhis_claim_form.php";
										}
									});	
								} 
								else 
								{
									alert('Please the Principal should be either Yes or No!');
								};
							} 
							else 
							{
								alert('The Date cannot be EMPTY!');
							};
						} 
						else 
						{
							alert('The Diagnosis cannot be EMPTY!');
						};
					} 
					else 
					{
						alert('The G-DRG cannot be EMPTY!');
					};
				});
			}

			function nhis_diagnosis_list_delete()
			{
				$(document).on('click','#btn_nhis_diagnosis_delete',function(e){
					e.preventDefault();
					var diagnosis_list_id = $(this).attr('data-id');
					var currentRow=$(this).closest("tr");
					var diagnosis = currentRow.find("td:eq(0)").text();
					$('#nhis_delete_question').text('Are you sure you want to delete Diagnosis:' + diagnosis + '?');
					$('#nhis_delete_modal_title').text('NHIS Diagnosis Deletion');
					$('#nhis_delete_modal').modal('show');
					$(document).on('click','#nhis_del_yes',function(){
						$.ajax({
							url:'/layout/reports/nhis_diagnosis_list_delete.php',
							method:'POST',
							data:{diagnosis_list_id:diagnosis_list_id},
							success:function(data)
							{
								window.location.href="/layout/reports/nhis_claim_form.php";
							}
						});
						});
					$(document).on('click','#nhis_del_no',function()
					{
						$('#nhis_delete_modal').modal('hide');
					});
				});
			}

			function nhis_drug_list_edit()
			{
				$(document).on('click','#btn_nhis_drug_edit',function()
				{
					var drug_disp_list_id = $(this).attr('data-id');
					$.ajax({
						url:'/layout/reports/nhis_drug_list_edit.php',
						method:'POST',
						data:{drug_disp_list_id :drug_disp_list_id },
						datatype:'JSON',
						success:function(data)
						{
							var res = $.parseJSON(data);
							$('#nhis_drug_detail_form').trigger('reset');
							$('#drug_disp_list_id').val(res[0]);
							$('#nhis_drug_id').val(res[1]);
							$('#nhis_drug_qty').val(res[2]);
							$('#nhis_drug_price').val(res[3]);
							$('#nhis_drug_amount').val(res[4]);
							$('#nhis_drug_amountD').val(res[4]);
							$('#nhis_drug_price_cash').val(res[5]);
							$('#nhis_drug_amount_cash').val(res[6]);
							$('#nhis_drug_price_prvt').val(res[7]);
							$('#nhis_drug_amount_prvt').val(res[8]);
							$('#nhis_drug_dosage').val(res[9]);
							$('#nhis_drug_date').val(res[10]);
							$('#nhis_drug_comment').val(res[11]);
							$('#nhis_drug_code').val(res[12]);
							$('#nhis_drug_attend_id').val(res[13]);
							$('#nhis_drug_patient_id').val(res[14]);
							$('#btn_nhis_drug_save').hide();
							$('#btn_nhis_drug_update').show();
							$('#nhis_drug_detail_modal').modal('show');
						}
					});
				}); 
			}

			function nhis_drug_list_save()
			{
				$(document).on('click','#btn_nhis_drug_update',function(e){
					e.preventDefault();
					var nhis_drug_id = $('#nhis_drug_id').val();
					var nhis_drug_dosage = $('#nhis_drug_dosage').val();
					var nhis_drug_date = $('#nhis_drug_date').val();
					var nhis_drug_qty = $('#nhis_drug_qty').val();
					var attend_id = $('#nhis_drug_attend_id').val();
					var patient_id = $('#nhis_drug_patient_id').val();
					
					if (nhis_drug_id !=="")
					{
						if (nhis_drug_dosage !=="") 
						{
							if (nhis_drug_date !== "") 
							{
								if (nhis_drug_qty !=="") 
								{
									$.ajax({
										url:'/layout/reports/nhis_drug_list_save.php',
										method:'POST',
										data:$('#nhis_drug_detail_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
										success:function(data)
										{
											$('#nhis_drug_detail_form').trigger('reset');
											$('#nhis_drug_detail_modal').modal('hide');
											window.location.href="/layout/reports/nhis_claim_form.php";
										}
									});
								} 
								else 
								{
									alert('Please the Quantity should be either Yes or No!');
								};
							} 
							else 
							{
								alert('The Date cannot be EMPTY!');
							};
						} 
						else 
						{
							alert('The Dosage cannot be EMPTY!');
						};
					} 
					else 
					{
						alert('The Drug cannot be EMPTY!');
					};
				});
			}
			
			function nhis_add_drug()
			{
				$(document).on('click','#btn_nhis_drug_add',function()
				{
					$('#nhis_drug_detail_modal_title').text('Add NHIS Drug');
					$('#nhis_drug_detail_form').trigger('reset');
					$('#btn_nhis_drug_update').hide();
					$('#btn_nhis_drug_save').show();
					$('#nhis_drug_detail_modal').modal('show');
				}); 
			}

			function nhis_add_drug_save()
			{
				$(document).on('click','#btn_nhis_drug_save',function(e){
					e.preventDefault();
					var nhis_drug_id = $('#nhis_drug_id').val();
					var nhis_drug_dosage = $('#nhis_drug_dosage').val();
					var nhis_drug_date = $('#nhis_drug_date').val();
					var nhis_drug_qty = $('#nhis_drug_qty').val();
					var attend_id = $('#nhis_drug_attend_id').val();
					var patient_id = $('#nhis_drug_patient_id').val();
					
					if (nhis_drug_id !="")
					{
						if (nhis_drug_dosage !="") 
						{
							if (nhis_drug_date != "") 
							{
								if (nhis_drug_qty !="") 
								{
									$.ajax({
										url:'/layout/reports/nhis_add_drug_save.php',
										method:'POST',
										data:$('#nhis_drug_detail_form').serialize() + 
										'&attend_id=' + attend_id + '&patient_id=' + patient_id,
										success:function(data)
										{
											$('#nhis_drug_detail_form').trigger('reset');
											$('#nhis_drug_detail_modal').modal('hide');
											window.location.href="/layout/reports/nhis_claim_form.php";
										}
									});
								} 
								else 
								{
									alert('Please the Quantity should be either Yes or No!');
								};
							} 
							else 
							{
								alert('The Date cannot be EMPTY!');
							};
						} 
						else 
						{
							alert('The Dosage cannot be EMPTY!');
						};
					} 
					else 
					{
						alert('The Drug cannot be EMPTY!');
					};
				});
			}

			function nhis_drug_delete()
			{
				$(document).on('click','#btn_nhis_drug_delete',function(e){
					e.preventDefault();
					var drug_disp_list_id = $(this).attr('data-id');
					var drug_list_id = $(this).attr('data-id2');
					var currentRow=$(this).closest("tr");
					var drug = currentRow.find("td:eq(0)").text();
					$('#nhis_delete_question').text('Are you sure you want to delete Drug:' + drug + '?');
					$('#nhis_delete_modal_title').text('NHIS Drug Deletion');
					$('#nhis_delete_modal').modal('show');
					$(document).on('click','#nhis_del_yes',function(){
						$.ajax({
							url:'/layout/reports/nhis_drug_delete.php',
							method:'POST',
							data:{drug_disp_list_id:drug_disp_list_id,drug_list_id:drug_list_id},
							success:function(data)
							{
								window.location.href="/layout/reports/nhis_claim_form.php";
							}
						});
						});
					$(document).on('click','#nhis_del_no',function()
					{
						$('#nhis_delete_modal').modal('hide');
					});
				});
			}

			function nhis_set_drug_amount()
			{
				$(document).on('change keyup','#nhis_drug_qty,#nhis_drug_price',function()
				{
					var qty = $('#nhis_drug_qty').val();
					var price = $('#nhis_drug_price').val();
					var amount = qty * price;
					$('#nhis_drug_amount').val(amount);
					$('#nhis_drug_amountD').val(amount);
				}); 
			}

			function nhis_set_drug_price_and_code()
			{
				$(document).on('change','#nhis_drug_id',function()
				{
					var drug_id = $('#nhis_drug_id').val();
					$.ajax({
						url:'/layout/reports/nhis_set_drug_price_and_code.php',
						method:'POST',
						data:{drug_id:drug_id},
						datatype:'JSON',
						success:function(data)
						{
							var res = $.parseJSON(data);
							$('#nhis_drug_price').val(res[0]);
							$('#nhis_drug_code').val(res[1]);
						}
					});
				}); 
			}

			function nhis_attendance_edit()
			{
				$(document).on('click','#btn_nhis_attend_edit',function()
				{
					$('#btn_nhis_attend_save').hide();
					$('#btn_nhis_attend_update').show();
					$('#nhis_attend_detail_modal').modal('show');
				}); 
			}

			function nhis_attendance_update()
			{
				$(document).on('click','#btn_nhis_attend_update',function(e)
				{
					e.preventDefault();
					$.ajax({
						url:'/layout/reports/nhis_attend_update.php',
						method:'POST',
						data:$('#nhis_attend_detail_form').serialize(),
						success:function(data)
						{
							$('#nhis_attend_detail_form').trigger('reset');
							$('#nhis_attend_detail_modal').modal('hide');
							window.location.href="/layout/reports/nhis_claim_form.php";
						}
					});
				});
			}

			function nhis_set_specialty_code()
			{
				$(document).on('change keyup','#nhis_specialty_description, #nhis_attend_specialty_description',function()
				{
					var nhis_id = $(this).val();
					var pay_type_id = $(this).attr('data-id');
					var tos_id = $(this).attr('data-id2');
					var age = $('#age').val();
					
					$.ajax({
						url:'/layout/reports/nhis_set_specialty_code.php',
						method:'POST',
						data:{nhis_id:nhis_id,age:age,pay_type_id:pay_type_id,tos_id:tos_id},
						success:function(data)
						{
							$('#nhis_specialty_code').val(data);
							$('#nhis_attend_specialty_code').val(data);
						}
					});
				}); 
			}
			
		//PAYMENT TYPE REPORT
			function payment_type_report_modal()
			{
				$(document).on('click','#payment_type_report_link',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					$('#payment_type_report_modal_form').trigger('reset');
					$('#payment_type_report_company_id').val(company_id);
					$('#payment_type_report_user_super_id').val(user_super_id);
					$('#payment_type_report_modal').modal('show');
				});
			}

			function payment_type_report_display()
			{
				$(document).on('click','#payment_type_report_ok_btn',function()
				{
					var company_id = $('#payment_type_report_company_id').val();
					var user_super_id = $('#payment_type_report_user_super_id').val();
					var user_super_id = $('#payment_type_report_user_id').val();
					var ledger_id = $('#payment_type_report_ledger_id').val();
					var type = $('#payment_type_report_type').val();
					var start_date = $('#payment_type_report_start_date').val();
					var end_date = $('#payment_type_report_end_date').val();
					
					if (start_date !== "") 
					{
						if (end_date !== "") 
						{
							if (end_date >= start_date) 
							{
								if (type !=="" && type !== 0) 
								{
									if (ledger_id !=="" && ledger_id > 0) 
									{
										$.ajax({
								             url:'/layout/reports/payment_type_report_processing.php',
								             method:'POST',
								             data:$('#payment_type_report_modal_form').serialize(),
								             success:function(data)
								             {
						             			$('#payment_type_report_modal').modal('hide');
								             	if (type == 'Summary') 
								             	{
								             		window.open('/layout/reports/payment_type_summary_report_display.php', '_blank');
								             	}
								             	else if (type == 'Detail')
								             	{
								             		window.open('/layout/reports/payment_type_detail_report_display.php', '_blank');
								             	};
								             }
								        });	
									} 
									else 
									{
										$('#payment_type_report_modal_warning').html('<h6 style=color:red;>Please select a Ledger from the dropdown!</h6>');
										$('#payment_type_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
									};
								} 
								else 
								{
									$('#payment_type_report_modal_warning').html('<h6 style=color:red;>Please select a Type from the dropdown!</h6>');
									$('#payment_type_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#payment_type_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
								$('#payment_type_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#payment_type_report_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
							$('#payment_type_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#payment_type_report_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
						$('#payment_type_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
					};
				}); 
			}
		//PATIENT STATEMENT
			function patient_insurance_statement_display_attend()
			{
				$(document).on('click','#btn_insurance_statement_attend',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					var attend_id = $(this).attr('data-id');
					var patient_id = $(this).attr('data-id1');
					var sponsor_id = $(this).attr('data-id3');
					$.ajax({
			             url:'/layout/reports/patient_insurance_statement_processing_attend.php',
			             method:'POST',
			             data:{
			             	company_id:company_id,
			             	user_super_id:user_super_id,
			             	attend_id:attend_id,
			             	patient_id:patient_id,
							 sponsor_id:sponsor_id
			             },
			             success:function(data)
			             {
	             			window.open('/layout/reports/patient_insurance_statement_display_attend.php', '_blank');
			             }
			        });
				}); 
			}

			function patient_cash_statement_display_attend()
			{
				$(document).on('click','#btn_cash_statement_attend',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					var attend_id = $(this).attr('data-id');
					var patient_id = $(this).attr('data-id1');
					$.ajax({
			             url:'/layout/reports/patient_cash_statement_processing_attend.php',
			             method:'POST',
			             data:{
			             	company_id:company_id,
			             	user_super_id:user_super_id,
			             	attend_id:attend_id,
			             	patient_id:patient_id
			             },
			             success:function(data)
			             {
	             			window.open('/layout/reports/patient_cash_statement_display_attend.php', '_blank');
			             }
			        });
				}); 
			}

			function patient_cash_statement_display_patient()
			{
				$(document).on('click','#btn_cash_statement_patient',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					var patient_id = $(this).attr('data-id');
					$.ajax({
			             url:'/layout/reports/patient_cash_statement_processing_patient.php',
			             method:'POST',
			             data:{
			             	company_id:company_id,
			             	user_super_id:user_super_id,
			             	patient_id:patient_id
			             },
			             success:function(data)
			             {
	             			window.open('/layout/reports/patient_cash_statement_display_patient.php', '_blank');
			             }
			        });
				}); 
			}
		//STATISTICS
			//DOCTORS ATTENDANCE REGISTER
				function doctors_attend_register_modal()
				{
					$(document).on('click','#doctors_attend_link',function()
					{
						var company_id = $('#session_company_id').val();
						var user_super_id = $('#session_user_super_id').val();
						$('#doctors_attend_register_modal_form').trigger('reset');
						$('#doctors_attend_register_company_id').val(company_id);
						$('#doctors_attend_register_user_super_id').val(user_super_id);
						$('#doctors_attend_register_modal').modal('show');
					});
				}

				function doctors_attend_register_display()
				{
					$(document).on('click','#doctors_attend_register_ok_btn',function()
					{
						var company_id = $('#doctors_attend_register_company_id').val();
						var user_super_id = $('#doctors_attend_register_user_super_id').val();
						var start_date = $('#doctors_attend_register_start_date').val();
						var end_date = $('#doctors_attend_register_end_date').val();
						if (start_date !== "") 
						{
							if (end_date !== "") 
							{
								if (end_date >= start_date) 
								{
									$.ajax({
							             url:'/layout/reports/doctors_attend_register_processing.php',
							             method:'POST',
							             data:$('#doctors_attend_register_modal_form').serialize(),
							             success:function(data)
								             {
						             			$('#doctors_attend_register_modal').modal('hide');
						             			window.open('/layout/reports/doctors_attend_register_display.php', '_blank');
								             }
							        });	
								} 
								else 
								{
									$('#doctors_attend_register_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
									$('#doctors_attend_register_modal_warning').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#doctors_attend_register_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
								$('#doctors_attend_register_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#doctors_attend_register_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
							$('#doctors_attend_register_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					});
				}
			//INCIDENCE OF DISEASE
				function incidence_of_disease_modal()
				{
					$(document).on('click','#diseases_incidence_link',function()
					{
						var company_id = $('#session_company_id').val();
						var user_super_id = $('#session_user_super_id').val();
						$('#incidence_of_disease_modal_form').trigger('reset');
						$('#incidence_of_disease_company_id').val(company_id);
						$('#incidence_of_disease_user_super_id').val(user_super_id);
						$('#incidence_of_disease_modal').modal('show');
					});
				}

				function incidence_of_disease_display()
				{
					$(document).on('click','#incidence_of_disease_ok_btn',function()
					{
						var start_date = $('#incidence_of_disease_start_date').val();
						var end_date = $('#incidence_of_disease_end_date').val();
						if (start_date !== "")
						{
							if (end_date !== "") 
							{
								if (end_date >= start_date) 
								{
									$.ajax({
										url:'/layout/reports/incidence_of_disease_processing.php',
										method:'POST',
										data:$('#incidence_of_disease_report_modal_form').serialize(),
										success:function(data)
										{
											$('#incidence_of_disease_modal').modal('hide');
											window.open('/layout/reports/incidence_of_disease_display.php', '_blank');
										}
							        });
								} 
								else 
								{
									$('#incidence_of_disease_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
									$('#incidence_of_disease_modal_warning').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#incidence_of_disease_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
								$('#incidence_of_disease_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#incidence_of_disease_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
							$('#incidence_of_disease_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					});
				}
			//LAB OCCURANCE REPORT
				function lab_occurance_modal()
				{
					$(document).on('click','#lab_occurance_link',function()
					{
						$('#lab_occurance_modal_form').trigger('reset');
						$('#lab_occurance_modal').modal('show');
					});
				}

				function lab_occurance_display()
				{
					$(document).on('click','#lab_occurance_ok_btn',function()
					{
						var start_date = $('#lab_occurance_start_date').val();
						var end_date = $('#lab_occurance_end_date').val();
						if (start_date !== "")
						{
							if (end_date !== "") 
							{
								if (end_date >= start_date) 
								{
									$.ajax({
										url:'/layout/reports/lab_occurance_processing.php',
										method:'POST',
										data:$('#lab_occurance_modal_form').serialize(),
										success:function(data)
										{
											$('#lab_occurance_modal').modal('hide');
											window.open('/layout/reports/lab_occurance_display.php', '_blank');
										}
									});
								} 
								else 
								{
									$('#lab_occurance_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
									$('#lab_occurance_modal_warning').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#lab_occurance_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
								$('#lab_occurance_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#lab_occurance_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
							$('#lab_occurance_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					});
				}
			//STATEMENT OF OUT-PATIENT
				function statement_of_out_patient_modal()
				{
					$(document).on('click','#OPD_Statement_link',function()
					{
						var company_id = $('#session_company_id').val();
						var user_super_id = $('#session_user_super_id').val();
						$('#statement_of_out_patient_modal_form').trigger('reset');
						$('#statement_of_out_patient_company_id').val(company_id);
						$('#statement_of_out_patient_user_super_id').val(user_super_id);
						$('#statement_of_out_patient_modal').modal('show');
					});
				}

				function statement_of_out_patient_display()
				{
					$(document).on('click','#statement_of_out_patient_ok_btn',function()
					{
						var start_date = $('#statement_of_out_patient_start_date').val();
						var end_date = $('#statement_of_out_patient_end_date').val();
						if (start_date !== "") 
						{
							if (end_date !== "") 
							{
								if (end_date >= start_date) 
								{
									$.ajax({
											url:'/layout/reports/statement_of_out_patient_processing.php',
											method:'POST',
											data:$('#statement_of_out_patient_modal_form').serialize(),
											success:function(data)
											{
												$('#statement_of_out_patient_modal').modal('hide');
												window.open('/layout/reports/statement_of_out_patient_display.php', '_blank');
											}
									});	
								} 
								else 
								{
									$('#statement_of_out_patient_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
									$('#statement_of_out_patient_modal_warning').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#statement_of_out_patient_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
								$('#statement_of_out_patient_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#statement_of_out_patient_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
							$('#statement_of_out_patient_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					});
				}
			//STATEMENT OF IN-PATIENT
				function statement_of_in_patient_modal()
				{
					$(document).on('click','#IPD_Statement_link',function()
					{
						var company_id = $('#session_company_id').val();
						var user_super_id = $('#session_user_super_id').val();
						$('#statement_of_in_patient_modal_form').trigger('reset');
						$('#statement_of_in_patient_company_id').val(company_id);
						$('#statement_of_in_patient_user_super_id').val(user_super_id);
						$('#statement_of_in_patient_modal').modal('show');
					});
				}

				function statement_of_in_patient_display()
				{
					$(document).on('click','#statement_of_in_patient_ok_btn',function()
					{
						var start_date = $('#statement_of_in_patient_start_date').val();
						var end_date = $('#statement_of_in_patient_end_date').val();
						if (start_date !== "") 
						{
							if (end_date !== "") 
							{
								if (end_date >= start_date) 
								{
									$.ajax({
										url:'/layout/reports/statement_of_in_patient_processing.php',
										method:'POST',
										data:$('#statement_of_in_patient_modal_form').serialize(),
										success:function(data)
										{
											$('#statement_of_in_patient_modal').modal('hide');
											window.open('/layout/reports/statement_of_in_patient_display.php', '_blank');
										}
									});	
								} 
								else 
								{
									$('#statement_of_in_patient_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
									$('#statement_of_in_patient_modal_warning').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#statement_of_in_patient_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
								$('#statement_of_in_patient_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#statement_of_in_patient_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
							$('#statement_of_in_patient_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					});
				}
	
		//HELP
		function sign_in_help()
		{
			$(document).on('click','#sign_in_help',function()
			{
				window.open('/help/sign_in.pdf', '_blank');
			});
		}