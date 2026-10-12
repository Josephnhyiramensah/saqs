$(document).ready(function()
{
	//RECEIPT
		/*add_receipt_item();
		delete_receipt_item();
		save_receipt();
		enter_receipt_itemise();
		enter_receipt_deposit();
		receipt_type();*/
		new_receipt_modal_patient();
		receipt_pay_and_unpay_item();
		new_receipt_modal_others();
		receipt_mode_bank_details();
		cancel_receipt_sheet_modal();
		save_receipt_patient();
		edit_receipt_patient();
		update_receipt_patient();
		delete_receipt();
		reprint_receipt();
		search_receipt_by_name();
		search_receipt_by_date()
		//REFUND
			new_refund_modal();
			save_refund();
			edit_refund();
			update_refund();
		//DISCOUNT
			new_lab_discount_modal();
			new_surgery_discount_modal();
			new_service_discount_modal();
			new_consumable_discount_modal();
			new_radiology_discount_modal();
			new_drug_discount_modal();
			save_discount();
			edit_discount();
			update_discount();
});

			//RECEIPT
				/*function enter_receipt_itemise()
				{
					$(document).on('click','#btn_enter_receipt_itemise',function(){

						var attend_id = $(this).attr('data-id');
						var patient_id = $(this).attr('data-id2');
						var page = window.location.pathname;
						var receipt_type = 'Itemise';
						$.ajax({
				             url:'/layout/vouchers/receipt_sheet_go.php',
				             method:'POST',
				             data:{patient_id:patient_id,attend_id:attend_id,page:page,receipt_type:receipt_type},
				             success:function(data){
				             	window.location.href="/layout/vouchers/receipt_sheet.php";
				             }  
			        	});
					});
				}

				function enter_receipt_deposit()
				{
					$(document).on('click','#btn_enter_receipt_deposit',function(){

						var attend_id = $(this).attr('data-id');
						var patient_id = $(this).attr('data-id2');
						var page = window.location.pathname;
						var receipt_type = 'Deposit';
						$.ajax({
				             url:'/layout/vouchers/receipt_sheet_go.php',
				             method:'POST',
				             data:{patient_id:patient_id,attend_id:attend_id,page:page,receipt_type:receipt_type},
				             success:function(data){
				             	window.location.href="/layout/vouchers/receipt_sheet.php";
				             }  
			        	});
					});
				}

				function add_receipt_item()
				{
					var i=0;  
					$(document).on('click','#btn_receipt_enter',function(){ 
						var attend_id = $('#session_attend_id').val();
				    	var patient_id = $('#session_patient_id').val();
						var item_list_id = $(this).attr('data-id');
						var item_id = $(this).attr('data-id2');
						var category_id = $(this).attr('data-id3');
						var currentRow = $(this).closest("tr");
						var bill_list_id = currentRow.attr('id');
						var item = currentRow.find("td:eq(0)").text();
						var amount_billed = currentRow.find("td:eq(3)").text();
						var amount_paid = currentRow.find("td:eq(3)").text();
						var amount_item = parseFloat(amount_paid.replace(/,/g, ''));
						var amount_bill = parseFloat(amount_billed.replace(/,/g, ''));
						var total_current = $('#amount').val();
						if(total_current == ''){var total_previous = 0 }else{var total_previous = parseFloat($('#amount').val())};
						var total = total_previous + amount_item;
						i++;  
						$('#attend_receiptlist_table_body').append('<tr id="row_as'+i+'"><td>'+item+'</td><td class="amt-td">'+amount_billed+'</td><td class="amt-td">'+amount_paid+'</td><td class="action-td"><a href="#"id="btn_delete_receipt_item" data-id="'+i+'" data-id2="'+bill_list_id+'"><i class="fa fa-trash"></i></a></td><input type="hidden" name="item_list_id[]" id="item_list_id" value="'+item_list_id+'"><input type="hidden" name="item_id[]" id="item_id" value="'+item_id+'"><input type="hidden" name="category_id[]" id="category_id" value="'+category_id+'"><input type="hidden" name="amount_bill[]" id="amount_bill" value="'+amount_bill+'"><input type="hidden" name="amount_item[]" id="amount_item" value="'+amount_item+'"><input type="hidden" name="patient_id[]" id="patient_id" value="'+patient_id+'"><input type="hidden" name="attend_id[]" id="attend_id" value="'+attend_id+'"></tr>');
						currentRow.hide();
						$('#amount').val(total);
						$('#amount_2').val(total);
					});
				}

				function delete_receipt_item()
				{
					$(document).on('click', '#btn_delete_receipt_item', function(){  
		       			var button_id = $(this).attr("data-id");  
		       			var bill_list_id = $(this).attr("data-id2"); 
		       			var currentRow=$(this).closest("tr");
						var item = currentRow.find("td:eq(0)").text();
						var amount_bill = currentRow.find("td:eq(1)").text();
						var amount_paid = currentRow.find("td:eq(2)").text();
						var amount_item = parseFloat(amount_paid);
						var total_current = $('#amount').val();
						if(total_current == ''){var total_previous =0}else{var total_previous = parseFloat($('#amount').val())};
						var total = total_previous - amount_item;
						$('#amount').val(total);
						$('#amount_2').val(total);
		           		$('#row_as'+button_id+'').remove();
		           		$('#'+bill_list_id+'').show();
		           	});
				}

				function save_receipt()
				{
					$(document).on('click','#receipt_save_btn',function(e){
						e.preventDefault();
						var receipt_type = $('#receipt_type').val();
						var date = $('#date').val();
						var debit_ledger = $('#debit_ledger').val();
						var credit_ledger = $('#credit_ledger').val();
						var received_from = $('#received_from').val();
						var narration = $('#narration').val();
						var mode = $('#mode').val();
						var amount = $('#amount').val();
						if (date !=="") 
						{
							if (debit_ledger !=="" && debit_ledger > 0) 
							{
								if (credit_ledger !=="" && credit_ledger > 0) 
								{
									if (received_from !=="") 
									{
										if (mode !=="" && mode !== 0) 
										{
											if (amount !=="" && amount > 0) 
											{
												var attend_id = $('#session_attend_id').val();
										    	var patient_id = $('#session_patient_id').val();
												$.ajax({
										             url:'/layout/vouchers/receipt_save.php',
										             method:'POST',
										             data:$('#receipt_setup_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
										             success:function(data)
											             {
															$('#receipt_setup_form').trigger('reset');
											             	var page = $('#session_page').val();
															var typeofservice_attd = $('#session_typeofservice_attd').val();
															if(page !=='')
															{
																window.open('/layout/vouchers/receipt_pdf.php', '_blank');
																window.location.href=page;
															}
															else
															{
																if (typeofservice_attd ==1) 
																{
																	window.open('/layout/vouchers/receipt_pdf.php', '_blank');
																	window.location.href="/layout/attendance/attend_list_opd.php";
																}
																else if(typeofservice_attd ==2)
																{
																	window.open('/layout/vouchers/receipt_pdf.php', '_blank');
																	window.location.href="/layout/attendance/attend_list_ipd.php";
																};
															};
											             }
										             });
											} 
											else 
											{
												if(receipt_type =='Itemise')
												{
													alert('Please select the items being receipted!');
												}
												else
												{
													alert('Please enter the amount being deposited!');
												};
											};
										} 
										else 
										{
											alert('Please select the mode for the receipt!');
										};
									} 
									else 
									{
										alert('Please type the person paying the money!');
									};
								} 
								else 
								{
									alert('Please select the paying ledger for the receipt!');
								};
							} 
							else 
							{
								alert('Please select the cash ledger for the receipt!');
							};
						} 
						else 
						{
							alert('Please select the date for the receipt!');
						};
					});
				}

				function receipt_type()
				{
					var receipt_type = $('#receipt_type').val();
					
					if(receipt_type == 'Itemise')
					{
						$('#receipt_itemise_table').show();
						$('#amount').prop("hidden",true);
						$('#amount_2').prop("hidden",false);
					}
					else
					{
						$('#receipt_itemise_table').hide();
						$('#amount').prop("hidden",false);
						$('#amount_2').prop("hidden",true);
					};
				}*/

				function new_receipt_modal_patient()
				{
					$(document).on('click','#btn_new_receipt',function(){
						var attend_id = $(this).attr('data-id');
						var patient_id = $(this).attr('data-id2');
						var name = $(this).attr('data-id1');
						
						$.ajax({
							url:'/layout/vouchers/receipt_unpaid_list.php',
							method:'POST',
							data:{
								attend_id:attend_id
							},
							success:function(data)
							{
								$('#receipt_setup_form').trigger('reset');
								$('#receipt_type').val('paitent');
								$('#rec_attend_id').val(attend_id);
								$('#rec_patient_id').val(patient_id);
								$('#received_from').val(name);
								$('#mode').val('Cash');
								$('#credit_ledger').val(1);
								$('#unpaid_item_list').html(data);
								$('#receipt_update_btn').hide();
								$('#receipt_save_btn').show();
								$('#receipt_create_modal').modal('show');
							}
						});
					});
				}

				function receipt_pay_and_unpay_item()
				{
					$(document).on('click','#btn_select_unpaid_item',function(){
						var i = $(this).closest('tr').attr('id');
						var status = $('#receipt_unpaid_item_status'+i).val();
						if(status == 'PAY')
						{
							$(this).text('PAY');
							$('#receipt_unpaid_item_status'+i).val('');
							$('#receipt_unpaid_category'+i).attr('name', 'receipt_unpaid_category[]');
							$('#receipt_unpaid_item_list'+i).attr('name', 'receipt_unpaid_item_list[]');
							$('#receipt_unpaid_item_id'+i).attr('name', 'receipt_unpaid_item_id[]');
							$('#receipt_unpaid_item_qty'+i).attr('name', 'receipt_unpaid_item_qty[]');
							$('#receipt_unpaid_item_price'+i).attr('name', 'receipt_unpaid_item_price[]');
							$('#receipt_unpaid_item_amount'+i).attr('name', 'receipt_unpaid_item_amount[]');
							$('#receipt_unpaid_item'+i).attr('class', 'receipt_unpaid_item');
							$('#receipt_unpaid_item_amount'+i).attr('class', 'receipt_unpaid_item_amount');
							var amount = 0;
							var description = '';
							$(".receipt_paid_item_amount").each(
								function(){amount += +$(this).val();}
							);
							$("#amount").val(amount);

							$(".receipt_paid_item").each(
								function()
								{
									description = description + $(this).val() + ', ';
								}
							);
							$("#narration").val(description);
						}
						else
						{
							$(this).text('UNPAY');
							$('#receipt_unpaid_item_status'+i).val('PAY');
							$('#receipt_unpaid_category'+i).attr('name', 'receipt_paid_category[]');
							$('#receipt_unpaid_item_list'+i).attr('name', 'receipt_paid_item_list[]');
							$('#receipt_unpaid_item_id'+i).attr('name', 'receipt_paid_item_id[]');
							$('#receipt_unpaid_item_qty'+i).attr('name', 'receipt_paid_item_qty[]');
							$('#receipt_unpaid_item_price'+i).attr('name', 'receipt_paid_item_price[]');
							$('#receipt_unpaid_item_amount'+i).attr('name', 'receipt_paid_item_amount[]');
							$('#receipt_unpaid_item'+i).attr('class', 'receipt_paid_item');
							$('#receipt_unpaid_item_amount'+i).attr('class', 'receipt_paid_item_amount');
							var amount = 0;
							var description = '';
							$(".receipt_paid_item_amount").each(
								function(){amount += +$(this).val();}
							);
							$("#amount").val(amount);

							$(".receipt_paid_item").each(
								function()
								{
									description = description + $(this).val() + ', ';
								}
							);
							$("#narration").val(description);
						};
					});
				}

				function new_receipt_modal_others()
				{
					$(document).on('click','#new_recipt_icon',function(){
						$('#receipt_update_btn').hide();
						$('#receipt_save_btn').show();
						$('#receipt_setup_form').trigger('reset');
						$('#receipt_type').val('others');
						$('#receipt_create_modal').modal('show');
					});
				}

				function receipt_mode_bank_details()
				{
					$(document).on('change keyup','#mode',function()
					{
						var mode = $('#mode').val();
						if(mode =='Cheque')
						{
							$("#bank_details_div").prop("hidden",false);
						}
						else
						{
							$("#bank_details_div").prop("hidden",true);
						};
					});
				}

				function cancel_receipt_sheet_modal()
				{
					$(document).on('click','#receipt_sheet_cancel_btn',function()
					{
						$('#receipt_setup_form').trigger('reset');
						window.location.href="/layout/attendance/attend_list_revenue.php";
					});
				}

				function save_receipt_patient()
				{
					$(document).on('click','#receipt_save_btn',function(e){
						e.preventDefault();
						var attend_id = $('#rec_attend_id').val();
						var patient_id = $('#rec_patient_id').val();
						var receipt_type = $('#receipt_type').val();
						var date = $('#date').val();
						var debit_ledger = $('#debit_ledger').val();
						var credit_ledger = $('#credit_ledger').val();
						var received_from = $('#received_from').val();
						var narration = $('#narration').val();
						var mode = $('#mode').val();
						var amount = $('#amount').val();
						var type = $('#receipt_type').val();
						if (date !=="") 
						{
							if (debit_ledger !=="" && debit_ledger > 0) 
							{
								if (credit_ledger !=="" && credit_ledger > 0) 
								{
									if (received_from !=="") 
									{
										if (mode !=="" && mode !== 0) 
										{
											if (amount !=="" && amount > 0) 
											{
												$.ajax({
													url:'/layout/vouchers/receipt_save_patient.php',
													method:'POST',
													data:$('#receipt_setup_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
													success:function(data)
													{
														$('#receipt_setup_form').trigger('reset');
														$('#receipt_create_modal').modal('hide');
														window.open('/layout/vouchers/receipt_pos_pdf.php', '_blank');
													}
												});
											} 
											else 
											{
													alert('Please enter the amount being receipt!');
											};
										} 
										else 
										{
											alert('Please select the mode for the receipt!');
										};
									} 
									else 
									{
										alert('Please type the person paying the money!');
									};
								} 
								else 
								{
									alert('Please select the paying ledger for the receipt!');
								};
							} 
							else 
							{
								alert('Please select the cash ledger for the receipt!');
							};
						} 
						else 
						{
							alert('Please select the date for the receipt!');
						};
					});
				}

				function edit_receipt_patient()
				{
					$(document).on('click','#btn_edit_receipt',function(){
						var receipt_id = $(this).attr('data-id');
						$.ajax({
				            url:'/layout/vouchers/receipt_edit_patient.php',
				            method:'POST',
				            data:{receipt_id:receipt_id},
							datatype:'JSON',
				            success:function(data)
				            {
				             	var res = $.parseJSON(data);
				             	$('#receipt_id').val(res[0]);
				             	$('#rec_patient_id').val(res[1]);
				             	$('#rec_attend_id').val(res[2]);
				             	$('#date').val(res[3]);
				             	$('#credit_ledger').val(res[4]);
				             	$('#debit_ledger').val(res[5]);
				             	$('#received_from').val(res[6]);
				             	$('#narration').val(res[7]);
				             	$('#mode').val(res[8]);
				             	$('#amount').val(res[9]);
				             	$('#receipt_type').val(res[10]);
				             	$('#rec_inst_no').val(res[11]);
				             	$('#rec_bank').val(res[12]);
				             	$('#rec_branch').val(res[13]);
				             	if (res[8] == 'Cheque') 
				             	{
				             		$("#bank_details_div").prop("hidden",false);
				             	} 
				             	else 
				             	{
				             		$("#bank_details_div").prop("hidden",true);
				             	};
				             	$('#receipt_update_btn').show();
				             	$('#receipt_save_btn').hide();
								$('#receipt_create_modal').modal('show');
							}
			             });
						
					});
				}

				function update_receipt_patient()
				{
					$(document).on('click','#receipt_update_btn',function(e){
						e.preventDefault();
						var type = $('#receipt_type').val();
						var attend_id = $('#rec_attend_id').val();
						var patient_id = $('#rec_patient_id').val();
						var receipt_type = $('#receipt_type').val();
						var date = $('#date').val();
						var debit_ledger = $('#debit_ledger').val();
						var credit_ledger = $('#credit_ledger').val();
						var received_from = $('#received_from').val();
						var narration = $('#narration').val();
						var mode = $('#mode').val();
						var amount = $('#amount').val();
						if (date !=="") 
						{
							if (debit_ledger !=="" && debit_ledger > 0) 
							{
								if (credit_ledger !=="" && credit_ledger > 0) 
								{
									if (received_from !=="") 
									{
										if (mode !=="" && mode !== 0) 
										{
											if (amount !=="" && amount > 0) 
											{
												$.ajax({
										             url:'/layout/vouchers/receipt_update_patient.php',
										             method:'POST',
										             data:$('#receipt_setup_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
										             success:function(data)
										             {
										             	$('#receipt_setup_form').trigger('reset');
														$('#receipt_create_modal').modal('hide');
														window.open('/layout/vouchers/receipt_pdf.php', '_blank');
														window.location.href="/layout/vouchers/receipt_list.php";
										             }
										        });
											} 
											else 
											{
													alert('Please enter the amount being receipt!');
											};
										} 
										else 
										{
											alert('Please select the mode for the receipt!');
										};
									} 
									else 
									{
										alert('Please type the person paying the money!');
									};
								} 
								else 
								{
									alert('Please select the paying ledger for the receipt!');
								};
							} 
							else 
							{
								alert('Please select the cash ledger for the receipt!');
							};
						} 
						else 
						{
							alert('Please select the date for the receipt!');
						};
					});
				}
				
				function delete_receipt()
				{
					$(document).on('click','#btn_delete_receipt',function()
					{
						var receipt_id = $(this).attr('data-id');
						$('#receipt_delete_question').text('Are you sure you want to delete Receipt No:' + receipt_id);
						$('#receipt_delete_modal').modal('show');
						$(document).on('click','#receipt_delete_yes',function()
						{
							$.ajax({  
								url:'/layout/vouchers/receipt_delete.php',  
								type:'POST',  
								data:{receipt_id:receipt_id},
								success:function()
								{
									$('#receipt_delete_modal').modal('hide');
									window.location.href="/layout/vouchers/receipt_list.php";
								}
							});
						});
						$(document).on('click','#receipt_delete_no',function()
						{
							$('#receipt_delete_modal').modal('hide');
						});
					});
				}
				
				function reprint_receipt()
				{
					$(document).on('click','#btn_receipt_reprint',function(){
						var receipt_id = $(this).attr('data-id');
						$.ajax({
							url:'/layout/vouchers/receipt_reprint.php',
							method:'POST',
							data:{receipt_id:receipt_id},
							success:function()
							{
								window.open('/layout/vouchers/receipt_pos_pdf.php', '_blank');
							}
						});
					});
				}
				
				function search_receipt_by_name()
				{
					$(document).on('change keyup','#receipt_patient_name',function(){
						var search = $(this).val();
						$.ajax({
							url:'/layout/vouchers/receipt_search.php',
							method:'POST',
							data:{search:search},
							success:function(data)
							{
								$('#receipt_list_table').html(data);
							}
						});
					});
				}
				
				function search_receipt_by_date()
				{
					$(document).on('change','#receipt_search_from, #receipt_search_to',function(){
						var start = $('#receipt_search_from').val();
						var end = $('#receipt_search_to').val();
						if(end >= start)
						{
							$.ajax({
								url:'/layout/vouchers/receipt_search_by_date.php',
								method:'POST',
								data:{
									start:start,
									end:end,
								},
								success:function(data)
								{
									$('#receipt_list_table').html(data);
								}
							});
						}
						else
						{
							alert('The End Date cannot be less than the Start Date');
						};
					});
				}

				//REFUND
					function new_refund_modal()
					{
						$(document).on('click','#btn_refund_receipt',function()
						{
							var receipt_id = $(this).attr('data-id');
							var amount = $(this).attr('data-id1');
							var patient_id = $(this).attr('data-id2');
							var attend_id = $(this).attr('data-id3');
							var name = $(this).attr('data-id4');
							var credit_ledger = $(this).attr('data-id5');
							var debit_ledger = $(this).attr('data-id6');
							var amount_refunded = $(this).attr('data-id7');
							var today = new Date();
							today = moment(today).format("YYYY-MM-DD");
							$('#refund_setup_form').trigger('reset');
							$('#refund_debit_ledger').val(credit_ledger);
							$('#refund_credit_ledger').val(debit_ledger);
							$('#refund_receipt_id').val(receipt_id);
							$('#refund_attend_id').val(attend_id);
							$('#refund_patient_id').val(patient_id);
							$('#refund_received_from').val(name);
							$('#refund_max_amount').val(amount - amount_refunded);
							$('#refund_date').val(today);
							$('#refund_update_btn').hide();
							$('#refund_save_btn').show();
							$('#refund_create_modal').modal('show');
						});
					}

					function save_refund()
					{
						$(document).on('click','#refund_save_btn',function(e){
							e.preventDefault();
							var attend_id = $('#refund_attend_id').val();
							var patient_id = $('#refund_patient_id').val();
							var receipt_id = $('#refund_receipt_id').val();
							var date = $('#refund_date').val();
							var debit_ledger = $('#refund_debit_ledger').val();
							var credit_ledger = $('#refund_credit_ledger').val();
							var received_from = $('#refund_received_from').val();
							var reason = $('#refund_reason').val();
							var name = $('#refund_received_from').val();
							var amount = $('#refund_amount').val();
							var max_amount = $('#refund_max_amount').val();
							var max_amount = parseFloat(max_amount);
							if (date !=="") 
							{
								if (debit_ledger !=="" && debit_ledger > 0) 
								{
									if (credit_ledger !=="" && credit_ledger > 0) 
									{
										if (received_from !=="") 
										{
											if (reason !=="") 
											{
												if (amount !=="" && amount > 0) 
												{
													if (amount <= max_amount) 
													{
														$.ajax({
												             url:'/layout/vouchers/refund_save.php',
												             method:'POST',
												             data:$('#refund_setup_form').serialize(),
												             success:function(data)
												             {
												             	$('#refund_setup_form').trigger('reset');
																$('#refund_create_modal').modal('hide');
																//window.open('/layout/vouchers/receipt_pdf.php', '_blank');
																window.location.href="/layout/vouchers/receipt_list.php";
												             }
												        });
													} 
													else 
													{
															alert('Please the refund amount cannot be more than the receipted amount!');
													};
												} 
												else 
												{
														alert('Please enter the amount being refund!');
												};
											} 
											else 
											{
												alert('Please the reason for the refund!');
											};
										} 
										else 
										{
											alert('Please type the person paying the money!');
										};
									} 
									else 
									{
										alert('Please select the paying ledger for the refund!');
									};
								} 
								else 
								{
									alert('Please select the receiving ledger for the refund!');
								};
							} 
							else 
							{
								alert('Please select the date for the refund!');
							};
						});
					}

					function edit_refund()
					{
						$(document).on('click','#btn_edit_refund',function(){
							var refund_id = $(this).attr('data-id');
							$.ajax({
					            url:'/layout/vouchers/refund_edit.php',
					            method:'POST',
					            data:{refund_id:refund_id},
								datatype:'JSON',
					            success:function(data)
					            {
					            	var res = $.parseJSON(data);
					             	$('#refund_id').val(res[0]);
					             	$('#refund_receipt_id').val(res[1]);
					             	$('#refund_patient_id').val(res[2]);
					             	$('#refund_attend_id').val(res[3]);
					             	$('#refund_date').val(res[4]);
					             	$('#refund_credit_ledger').val(res[5]);
					             	$('#refund_debit_ledger').val(res[6]);
					             	$('#refund_amount').val(res[7]);
					             	$('#refund_reason').val(res[8]);
					             	$('#refund_max_amount').val(res[9]);
					             	$('#refund_received_from').val(res[10]);
					             	$('#refund_update_btn').show();
					             	$('#refund_save_btn').hide();
									$('#refund_create_modal').modal('show');
								}
				             });
							
						});
					}

					function update_refund()
					{
						$(document).on('click','#refund_update_btn',function(e){
							e.preventDefault();
							var attend_id = $('#refund_attend_id').val();
							var patient_id = $('#refund_patient_id').val();
							var receipt_id = $('#refund_receipt_id').val();
							var date = $('#refund_date').val();
							var debit_ledger = $('#refund_debit_ledger').val();
							var credit_ledger = $('#refund_credit_ledger').val();
							var received_from = $('#refund_received_from').val();
							var reason = $('#refund_reason').val();
							var name = $('#refund_received_from').val();
							var amount = $('#refund_amount').val();
							var max_amount = $('#refund_max_amount').val();
							var max_amount = parseFloat(max_amount);
							if (date !=="") 
							{
								if (debit_ledger !=="" && debit_ledger > 0) 
								{
									if (credit_ledger !=="" && credit_ledger > 0) 
									{
										if (received_from !=="") 
										{
											if (reason !=="") 
											{
												if (amount !=="" && amount > 0) 
												{
													if (amount <= max_amount) 
													{
														$.ajax({
															url:'/layout/vouchers/refund_update.php',
															method:'POST',
															data:$('#refund_setup_form').serialize(),
															success:function(data)
															{
																$('#refund_setup_form').trigger('reset');
															$('#refund_create_modal').modal('hide');
															//window.open('/layout/vouchers/receipt_pdf.php', '_blank');
															window.location.href="/layout/vouchers/refund_list.php";
															}
												        });
													} 
													else 
													{
															alert('Please the refund amount cannot be more than the receipted amount!');
													};
												} 
												else 
												{
														alert('Please enter the amount being refund!');
												};
											} 
											else 
											{
												alert('Please the reason for the refund!');
											};
										} 
										else 
										{
											alert('Please type the person paying the money!');
										};
									} 
									else 
									{
										alert('Please select the paying ledger for the refund!');
									};
								} 
								else 
								{
									alert('Please select the receiving ledger for the refund!');
								};
							} 
							else 
							{
								alert('Please select the date for the refund!');
							};
						});
					}
				//DISCOUNT
					function new_lab_discount_modal()
					{
						$(document).on('click','#btn_discount_lab_attend',function()
						{
							var lab_list_id = $(this).attr('data-id');
							var attend_id = $(this).attr('data-id1');
							var patient_id = $(this).attr('data-id2');
							var max_amount = $(this).attr('data-id3');
							var name = $(this).attr('data-id4');

							var today = new Date();
							today = moment(today).format("YYYY-MM-DD");
							$('#discount_setup_form').trigger('reset');
							$('#discount_debit_ledger').val(6);
							$('#discount_credit_ledger').val(1);
							$('#discount_type').val('labs');
							$('#discount_item_list_id').val(lab_list_id);
							$('#discount_attend_id').val(attend_id);
							$('#discount_patient_id').val(patient_id);
							$('#discount_received_from').val(name);
							$('#discount_max_amount').val(max_amount);
							$('#discount_date').val(today);
							$('#discount_update_btn').hide();
							$('#discount_save_btn').show();
							$('#discount_create_modal').modal('show');
						});
					}

					function new_surgery_discount_modal()
					{
						$(document).on('click','#btn_discount_surgery_attend',function()
						{
							var surgery_list_id = $(this).attr('data-id2');
							var attend_id = $(this).attr('data-id');
							var patient_id = $(this).attr('data-id1');
							var cash_amount = $(this).attr('data-id4');
							var disc_amount = $(this).attr('data-id5');
							var name = $(this).attr('data-id3');
							var max_amount = cash_amount - disc_amount;

							var today = new Date();
							today = moment(today).format("YYYY-MM-DD");
							$('#discount_setup_form').trigger('reset');
							$('#discount_debit_ledger').val(8);
							$('#discount_credit_ledger').val(1);
							$('#discount_type').val('surgery');
							$('#discount_item_list_id').val(surgery_list_id);
							$('#discount_attend_id').val(attend_id);
							$('#discount_patient_id').val(patient_id);
							$('#discount_received_from').val(name);
							$('#discount_max_amount').val(max_amount);
							$('#discount_date').val(today);
							$('#discount_update_btn').hide();
							$('#discount_save_btn').show();
							$('#discount_create_modal').modal('show');
						});
					}

					function new_service_discount_modal()
					{
						$(document).on('click','#btn_discount_service_list',function()
						{
							var service_list_id = $(this).attr('data-id2');
							var attend_id = $(this).attr('data-id');
							var patient_id = $(this).attr('data-id1');
							var cash_amount = $(this).attr('data-id4');
							var disc_amount = $(this).attr('data-id5');
							var name = $(this).attr('data-id3');
							var max_amount = cash_amount - disc_amount;

							var today = new Date();
							today = moment(today).format("YYYY-MM-DD");
							$('#discount_setup_form').trigger('reset');
							$('#discount_debit_ledger').val(9);
							$('#discount_credit_ledger').val(1);
							$('#discount_type').val('service');
							$('#discount_item_list_id').val(service_list_id);
							$('#discount_attend_id').val(attend_id);
							$('#discount_patient_id').val(patient_id);
							$('#discount_received_from').val(name);
							$('#discount_max_amount').val(max_amount);
							$('#discount_date').val(today);
							$('#discount_update_btn').hide();
							$('#discount_save_btn').show();
							$('#discount_create_modal').modal('show');
						});
					}

					function new_consumable_discount_modal()
					{
						$(document).on('click','#btn_discount_consum_list',function()
						{
							var con_list_id = $(this).attr('data-id2');
							var attend_id = $(this).attr('data-id');
							var patient_id = $(this).attr('data-id1');
							var cash_amount = $(this).attr('data-id4');
							var disc_amount = $(this).attr('data-id5');
							var name = $(this).attr('data-id3');
							var max_amount = cash_amount - disc_amount;

							var today = new Date();
							today = moment(today).format("YYYY-MM-DD");
							$('#discount_setup_form').trigger('reset');
							$('#discount_debit_ledger').val(10);
							$('#discount_credit_ledger').val(1);
							$('#discount_type').val('consumable');
							$('#discount_item_list_id').val(con_list_id);
							$('#discount_attend_id').val(attend_id);
							$('#discount_patient_id').val(patient_id);
							$('#discount_received_from').val(name);
							$('#discount_max_amount').val(max_amount);
							$('#discount_date').val(today);
							$('#discount_update_btn').hide();
							$('#discount_save_btn').show();
							$('#discount_create_modal').modal('show');
						});
					}

					function new_radiology_discount_modal()
					{
						$(document).on('click','#btn_discount_radio_list',function()
						{
							var radio_list_id = $(this).attr('data-id2');
							var attend_id = $(this).attr('data-id');
							var patient_id = $(this).attr('data-id1');
							var cash_amount = $(this).attr('data-id4');
							var disc_amount = $(this).attr('data-id5');
							var name = $(this).attr('data-id3');
							var max_amount = cash_amount - disc_amount;

							var today = new Date();
							today = moment(today).format("YYYY-MM-DD");
							$('#discount_setup_form').trigger('reset');
							$('#discount_debit_ledger').val(7);
							$('#discount_credit_ledger').val(1);
							$('#discount_type').val('radiology');
							$('#discount_item_list_id').val(radio_list_id);
							$('#discount_attend_id').val(attend_id);
							$('#discount_patient_id').val(patient_id);
							$('#discount_received_from').val(name);
							$('#discount_max_amount').val(max_amount);
							$('#discount_date').val(today);
							$('#discount_update_btn').hide();
							$('#discount_save_btn').show();
							$('#discount_create_modal').modal('show');
						});
					}

					function new_drug_discount_modal()
					{
						$(document).on('click','#btn_discount_drug_list',function()
						{
							var drug_list_id = $(this).attr('data-id2');
							var attend_id = $(this).attr('data-id');
							var patient_id = $(this).attr('data-id1');
							var cash_amount = $(this).attr('data-id4');
							var disc_amount = $(this).attr('data-id5');
							var name = $(this).attr('data-id3');
							var max_amount = cash_amount - disc_amount;

							var today = new Date();
							today = moment(today).format("YYYY-MM-DD");
							$('#discount_setup_form').trigger('reset');
							$('#discount_debit_ledger').val(5);
							$('#discount_credit_ledger').val(1);
							$('#discount_type').val('drug');
							$('#discount_item_list_id').val(drug_list_id);
							$('#discount_attend_id').val(attend_id);
							$('#discount_patient_id').val(patient_id);
							$('#discount_received_from').val(name);
							$('#discount_max_amount').val(max_amount);
							$('#discount_date').val(today);
							$('#discount_update_btn').hide();
							$('#discount_save_btn').show();
							$('#discount_create_modal').modal('show');
						});
					}

					function save_discount()
					{
						$(document).on('click','#discount_save_btn',function(e){
							e.preventDefault();
							var type = $('#discount_type').val();
							var attend_id = $('#discount_attend_id').val();
							var patient_id = $('#discount_patient_id').val();
							var item_list_id = $('#discount_item_list_id').val();
							var date = $('#discount_date').val();
							var debit_ledger = $('#discount_debit_ledger').val();
							var credit_ledger = $('#discount_credit_ledger').val();
							var received_from = $('#discount_received_from').val();
							var reason = $('#discount_reason').val();
							var amount = $('#discount_amount').val();
							var max_amount = $('#discount_max_amount').val();
							var max_amount = parseFloat(max_amount);
							if (date !=="") 
							{
								if (debit_ledger !=="" && debit_ledger > 0) 
								{
									if (credit_ledger !=="" && credit_ledger > 0) 
									{
										if (received_from !=="") 
										{
											if (reason !=="") 
											{
												if (amount !=="" && amount > 0) 
												{
													if (amount <= max_amount) 
													{
														$.ajax({
												             url:'/layout/vouchers/discount_save.php',
												             method:'POST',
												             data:$('#discount_setup_form').serialize(),
												             success:function(data)
												             {
												             	$('#discount_setup_form').trigger('reset');
																$('#discount_create_modal').modal('hide');
																//window.open('/layout/vouchers/receipt_pdf.php', '_blank');
																if (type == 'labs') 
																{
																	window.location.href="/layout/attendance/lab_sheet.php";
																} 
																else if(type == 'surgery') 
																{
																	window.location.href="/layout/attendance/surgery_sheet.php";
																} 
																else if(type == 'service') 
																{
																	window.location.href="/layout/attendance/service_sheet.php";
																} 
																else if(type == 'consumable') 
																{
																	window.location.href="/layout/attendance/consumables_sheet.php";
																} 
																else if(type == 'drug') 
																{
																	window.location.href="/layout/attendance/drugs_sheet.php";
																} 
																else if(type == 'radiology') 
																{
																	window.location.href="/layout/attendance/radio_sheet.php";
																};
												             }
												        });
													} 
													else 
													{
															alert('Please the discount amount cannot be more than the billed amount!');
													};
												} 
												else 
												{
														alert('Please enter the amount of discount!');
												};
											} 
											else 
											{
												alert('Please enter the reason for the discount!');
											};
										} 
										else 
										{
											alert('Please type the person receiving the discount!');
										};
									} 
									else 
									{
										alert('Please select the ledger giving the discount!');
									};
								} 
								else 
								{
									alert('Please select the receiving ledger the discount!');
								};
							} 
							else 
							{
								alert('Please select the date for the discount!');
							};
						});
					}

					function edit_discount()
					{
						$(document).on('click','#btn_edit_discount',function(){
							var discount_id = $(this).attr('data-id');
							$.ajax({
					            url:'/layout/vouchers/discount_edit.php',
					            method:'POST',
					            data:{discount_id:discount_id},
								datatype:'JSON',
					            success:function(data)
					            {
					            	var res = $.parseJSON(data);
					             	$('#discount_id').val(res[0]);
					             	$('#discount_item_list_id').val(res[1]);
					             	$('#discount_patient_id').val(res[2]);
					             	$('#discount_attend_id').val(res[3]);
					             	$('#discount_date').val(res[4]);
					             	$('#discount_credit_ledger').val(res[5]);
					             	$('#discount_debit_ledger').val(res[6]);
					             	$('#discount_amount').val(res[7]);
					             	$('#discount_reason').val(res[8]);
					             	$('#discount_max_amount').val(res[9]);
					             	$('#discount_received_from').val(res[10]);
					             	$('#discount_type').val(res[11]);
					             	$('#discount_update_btn').show();
					             	$('#discount_save_btn').hide();
									$('#discount_create_modal').modal('show');
								}
				             });
							
						});
					}

					function update_discount()
					{
						$(document).on('click','#discount_update_btn',function(e){
							e.preventDefault();
							var type = $('#discount_type').val();
							var attend_id = $('#discount_attend_id').val();
							var patient_id = $('#discount_patient_id').val();
							var item_list_id = $('#discount_item_list_id').val();
							var date = $('#discount_date').val();
							var debit_ledger = $('#discount_debit_ledger').val();
							var credit_ledger = $('#discount_credit_ledger').val();
							var received_from = $('#discount_received_from').val();
							var reason = $('#discount_reason').val();
							var amount = $('#discount_amount').val();
							var max_amount = $('#discount_max_amount').val();
							var max_amount = parseFloat(max_amount);
							if (date !=="") 
							{
								if (debit_ledger !=="" && debit_ledger > 0) 
								{
									if (credit_ledger !=="" && credit_ledger > 0) 
									{
										if (received_from !=="") 
										{
											if (reason !=="") 
											{
												if (amount !=="" && amount > 0) 
												{
													if (amount <= max_amount) 
													{
														$.ajax({
												             url:'/layout/vouchers/discount_update.php',
												             method:'POST',
												             data:$('#discount_setup_form').serialize(),
												             success:function(data)
												             {
												             	$('#discount_setup_form').trigger('reset');
																$('#discount_create_modal').modal('hide');
																window.location.href="/layout/vouchers/discount_list.php";
												             }
												        });
													} 
													else 
													{
															alert('Please the discount amount cannot be more than the billed amount!');
													};
												} 
												else 
												{
														alert('Please enter the amount of discount!');
												};
											} 
											else 
											{
												alert('Please enter the reason for the discount!');
											};
										} 
										else 
										{
											alert('Please type the person receiving the discount!');
										};
									} 
									else 
									{
										alert('Please select the ledger giving the discount!');
									};
								} 
								else 
								{
									alert('Please select the receiving ledger the discount!');
								};
							} 
							else 
							{
								alert('Please select the date for the discount!');
							};
						});
					}