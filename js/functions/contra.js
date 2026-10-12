$(document).ready(function()
{
	//CONTRA
		new_contra_voucher_modal();
		contra_mode_bank_details();
		cancel_contra_voucher_modal();
		save_contra_voucher();
		edit_contra_voucher();
		update_contra_voucher();
		search_contra_by_name();
		search_contra_by_date();
});

			//CONTRA
			function new_contra_voucher_modal()
			{
				$(document).on('click','#new_contra_icon',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					var user_id = $('#session_user_id').val();
					$('#contra_company_id').val(company_id);
					$('#contra_user_super_id').val(user_super_id);
					$('#contra_user_id').val(user_id);
					$('#contra_update_btn').hide();
					$('#contra_save_btn').show();
					$('#contra_create_form').trigger('reset');
					$('#contra_create_modal').modal('show');
				});
			}

			function contra_mode_bank_details()
			{
				$(document).on('change keyup','#contra_mode',function()
				{
					var contra_mode = $('#contra_mode').val();
					if(contra_mode =='cheque')
					{
						$("#bank_details_div").prop("hidden",false);
					}else
					{
						$("#bank_details_div").prop("hidden",true);
					};
				});
			}

			function cancel_contra_voucher_modal()
			{
				$(document).on('click','#contra_cancel_btn',function()
				{
					$('#contra_create_form').trigger('reset');
					$('#contra_create_modal').modal('hide');
					window.location.href="/layout/vouchers/contra_list.php";
				});
			}

			function save_contra_voucher()
			{
				$(document).on('click','#contra_save_btn',function(e){
					e.preventDefault();
					var contra_debit_ledger = $('#contra_debit_ledger').val();
					var contra_credit_ledger = $('#contra_credit_ledger').val();
					var contra_mode = $('#contra_mode').val();
					var contra_date = $('#contra_date').val();
					var contra_name = $('#contra_name').val();
					var contra_amount = $('#contra_amount').val();
					var contra_narration = $('#contra_narration').val();
					if (contra_credit_ledger !=="") 
					{
						if (contra_date !=="") 
						{
							if (contra_mode !=="") 
							{
								if (contra_name !=="") 
								{
									if (contra_amount > 0) 
									{
										if (contra_narration !== "") 
										{
											$.ajax({
												 url:'/layout/vouchers/contra_save.php',
												 method:'POST',
												 data:$('#contra_create_form').serialize(),
												 success:function(data)
													 {
														 $('#contra_create_form').trigger('reset');
														 window.location.href="/layout/vouchers/contra_list.php";
													 }
											});
										} 
										else 
										{
											alert('Please the Narration cannot be EMPTY!');
										}
									} 
									else 
									{
										alert('Please provide amount for debit ledgers selected!');
									}
								} 
								else 
								{
									alert('Please type the name of the person the payment is being made to!');
								}
							} 
							else 
							{
								alert('Please select the mode of contra!');
							}
						} 
						else 
						{
							alert('Please select the date for the contra voucher!');
						}
					} 
					else 
					{
						alert('Please select the ledger from which payment is being made!');
					};
				});
			}

			function edit_contra_voucher()
			{
				$(document).on('click','#btn_edit_contra',function(){
					var contra_id = $(this).attr('data-id');
					$.ajax({
							url:'/layout/vouchers/contra_edit.php',
							method:'POST',
							data:{contra_id:contra_id},
							datatype:'JSON',
							success:function(data)
							{
								 var res = $.parseJSON(data);
								 $('#contra_id').val(res[1]);
								 $('#contra_company_id').val(res[2]);
								 $('#contra_user_id').val(res[3]);
								 $('#contra_user_super_id').val(res[0]);
								 $('#contra_debit_ledger').val(res[5]);
								 $('#contra_credit_ledger').val(res[4]);
								 $('#contra_ref').val(res[10]);
								 $('#contra_date').val(res[7]);
								 $('#contra_amount').val(res[8]);
								 $('#contra_amountD').val(res[8]);
								 $('#contra_mode').val(res[11]);
								 $('#contra_inst_no').val(res[14]);
								 $('#contra_bank').val(res[12]);
								 $('#contra_branch').val(res[13]);
								 $('#contra_name').val(res[6]);
								 $('#contra_narration').val(res[9]);

								 $.ajax({
									url:'/layout/vouchers/contra_dr_edit.php',
									method:'POST',
									data:{contra_id:contra_id},
									success:function(data)
										{
											$('#contra_dr_list').html(data);
										}
								});
								 $('#contra_update_btn').show();
								 $('#contra_save_btn').hide();
								$('#contra_create_modal').modal('show');
								
							}
						 });
					
				});
			}

			function update_contra_voucher()
			{
				$(document).on('click','#contra_update_btn',function(e){
					e.preventDefault();
					var contra_debit_ledger = $('#contra_debit_ledger').val();
					var contra_credit_ledger = $('#contra_credit_ledger').val();
					var contra_mode = $('#contra_mode').val();
					var contra_date = $('#contra_date').val();
					var contra_name = $('#contra_name').val();
					var contra_amount = $('#contra_amount').val();
					var contra_narration = $('#contra_narration').val();
					if (contra_credit_ledger !=="") 
					{
						if (contra_date !=="") 
						{
							if (contra_mode !=="") 
							{
								if (contra_name !=="") 
								{
									if (contra_amount > 0) 
									{
										if (contra_narration !== "") 
										{
											$.ajax({
												 url:'/layout/vouchers/contra_update.php',
												 method:'POST',
												 data:$('#contra_create_form').serialize(),
												 success:function(data)
													 {
														 $('#contra_create_form').trigger('reset');
														 window.location.href="/layout/vouchers/contra_list.php";
													 }
											});
										} 
										else 
										{
											alert('Please the Narration cannot be EMPTY!');
										}
									} 
									else 
									{
										alert('Please provide amount for debit ledgers selected!');
									}
								} 
								else 
								{
									alert('Please type the name of the person the payment is being made to!');
								}
							} 
							else 
							{
								alert('Please select the mode of contra!');
							}
						} 
						else 
						{
							alert('Please select the date for the contra voucher!');
						}
					} 
					else 
					{
						alert('Please select the ledger from which payment is being made!');
					};
				});
			}

			function search_contra_by_name()
			{
				$(document).on('keyup','#contra_search_name',function(e){
					e.preventDefault();
					var company_id = $('#session_company_id').val();
					var contra_search_name = $('#contra_search_name').val();

					$.ajax({
						 url:'/layout/vouchers/contra_search_by_name.php',
						 method:'POST',
						 data:{contra_search_name:contra_search_name,company_id:company_id},
						 success:function(data)
							 {
								 $('#contra_list_card_body').html(data);
							 }
					});
				});
			}

			function search_contra_by_date()
			{
				$(document).on('click','#contra_search_icon',function(e){
					e.preventDefault();
					var company_id = $('#session_company_id').val();
					var start_date = $('#contra_search_from').val();
					var end_date = $('#contra_search_to').val();

					$.ajax({
						 url:'/layout/vouchers/contra_search_by_date.php',
						 method:'POST',
						 data:{start_date:start_date,end_date:end_date,company_id:company_id},
						 success:function(data)
							 {
								 $('#contra_list_card_body').html(data);
							 }
					});
				});
			}