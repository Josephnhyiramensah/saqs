$(document).ready(function()
{
	//PAYMENT
		new_payment_voucher_modal();
		payment_mode_bank_details();
		add_payment_item_row();
		//mask_payment_amt();
		sum_payment_item_amount();
		delete_payment_item_row();
		cancel_payment_voucher_modal();
		save_payment_voucher();
		edit_payment_voucher();
		update_payment_voucher();
		search_payment_by_date();
});

			//PAYMENT
			function new_payment_voucher_modal()
			{
				$(document).on('click','#new_payment_icon',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					var user_id = $('#session_user_id').val();
					$('#company_id').val(company_id);
					$('#user_super_id').val(user_super_id);
					$('#user_id').val(user_id);
					$('#payment_update_btn').hide();
					$('#payment_save_btn').show();
					$('#payment_create_form').trigger('reset');
					$('#payment_create_modal').modal('show');
				});
			}

			function payment_mode_bank_details()
			{
				$(document).on('change keyup','#payment_mode',function()
				{
					var payment_mode = $('#payment_mode').val();
					if(payment_mode =='cheque')
					{
						$("#bank_details_div").prop("hidden",false);
					}else
					{
						$("#bank_details_div").prop("hidden",true);
					};
				});
			}

			/*function mask_payment_amt()
				{
					$('.payment_item_amt').mask('#,###,###,###.##',{reverse : true});
				}*/

			function sum_payment_item_amount()
			{
				$(document).on('keyup','.payment_dr_amt',function(){ 
						var sum=0;
						$('.payment_dr_amt').each(function(){
							var num = $(this).val().replace(',','');
							if(num !=0){
								sum += parseFloat(num);
							}
						});
						$('#payment_amount').val(sum);
						$('#payment_amountD').val(sum);
					});
			}

			function add_payment_item_row()
			{
				$(document).on('change','.payment_led_dr',function(){ 
					var company_id = $('#session_company_id').val();
					var i = $('#payment_dr_list_table tr:last').attr('id');
					i++;
					$.ajax({
						url:'/layout/vouchers/payment_dr_list.php',
						method:'POST',
						data:{i:i,company_id:company_id},
						success:function(data)
						{
							$('#payment_dr_list_table').append('<tr id="'+i+'">'+data+'</tr>');
						}
					});
				});
			}

			function delete_payment_item_row()
			{
				$(document).on('click', '#delete_payment_dr', function(){  
					   var button_id = $(this).attr("data-id");
					   $('#'+button_id+'').remove();
					   var sum=0;
					$('.payment_dr_amt').each(function(){
						var num = $(this).val().replace(',','');
						if(num !=0){
							sum += parseFloat(num);
						}
					});
					$('#payment_amount').val(sum);
					$('#payment_amountD').val(sum);
				   });
			}

			function cancel_payment_voucher_modal()
			{
				$(document).on('click','#payment_cancel_btn',function()
				{
					$('#payment_create_form').trigger('reset');
					$('#payment_create_modal').modal('hide');
					window.location.href="/layout/vouchers/payment_list.php";
				});
			}

			function save_payment_voucher()
			{
				$(document).on('click','#payment_save_btn',function(e){
					e.preventDefault();
					var last_tr_id = $("#payment_dr_list_table tr:last").attr("id");
					var last_tr_select = $("#payment_dr_list_table tr:last option:selected").val();
					var payment_credit_ledger = $('#payment_credit_ledger').val();
					var payment_mode = $('#payment_mode').val();
					var payment_date = $('#payment_date').val();
					var payment_payee = $('#payment_payee').val();
					var payment_amount = $('#payment_amount').val();
					if (payment_credit_ledger !=="") 
					{
						if (payment_date !=="") 
						{
							if (payment_mode !=="") 
							{
								if (payment_payee !=="") 
								{
									if (payment_amount > 0) 
									{
										if(last_tr_select =="" || last_tr_select ==0)
										{
											$('#'+last_tr_id+'').remove();
										};
										$.ajax({
											 url:'/layout/vouchers/payment_save.php',
											 method:'POST',
											 data:$('#payment_create_form').serialize(),
											 success:function(data)
												 {
													 $('#payment_create_form').trigger('reset');
													 window.location.href="/layout/vouchers/payment_list.php";
												 }
										});		
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
								alert('Please select the mode of payment!');
							}
						} 
						else 
						{
							alert('Please select the date for the payment voucher!');
						}
					} 
					else 
					{
						alert('Please select the ledger from which payment is being made!');
					};
				});
			}

			function edit_payment_voucher()
			{
				$(document).on('click','#btn_edit_payment',function(){
					var payment_id = $(this).attr('data-id');
					$.ajax({
							url:'/layout/vouchers/payment_edit.php',
							method:'POST',
							data:{payment_id:payment_id},
							datatype:'JSON',
							success:function(data)
							{
								 var res = $.parseJSON(data);
								 $('#payment_id').val(res[1]);
								 $('#company_id').val(res[2]);
								 $('#user_id').val(res[3]);
								 $('#user_super_id').val(res[0]);
								 $('#payment_credit_ledger').val(res[4]);
								 $('#payment_ref').val(res[10]);
								 $('#payment_date').val(res[7]);
								 $('#payment_amount').val(res[8]);
								 $('#payment_amountD').val(res[8]);
								 $('#payment_mode').val(res[11]);
								 $('#payment_inst_no').val(res[14]);
								 $('#payment_bank').val(res[12]);
								 $('#payment_branch').val(res[13]);
								 $('#payment_payee').val(res[6]);
								 $('#payment_narration').val(res[9]);

								 $.ajax({
									url:'/layout/vouchers/payment_dr_edit.php',
									method:'POST',
									data:{payment_id:payment_id},
									success:function(data)
										{
											$('#payment_dr_list').html(data);
										}
								});
								 $('#payment_update_btn').show();
								 $('#payment_save_btn').hide();
								$('#payment_create_modal').modal('show');
								
							}
						 });
					
				});
			}

			function update_payment_voucher()
			{
				$(document).on('click','#payment_update_btn',function(e){
					e.preventDefault();
					var last_tr_id = $("#payment_dr_list_table tr:last").attr("id");
					var last_tr_select = $("#payment_dr_list_table tr:last option:selected").val();
					var payment_credit_ledger = $('#payment_credit_ledger').val();
					var payment_mode = $('#payment_mode').val();
					var payment_date = $('#payment_date').val();
					var payment_payee = $('#payment_payee').val();
					var payment_amount = $('#payment_amount').val();
					if (payment_credit_ledger !=="") 
					{
						if (payment_date !=="") 
						{
							if (payment_mode !=="") 
							{
								if (payment_payee !=="") 
								{
									if (payment_amount > 0) 
									{
										if(last_tr_select =="" || last_tr_select ==0)
										{
											$('#'+last_tr_id+'').remove();
										};
										$.ajax({
											 url:'/layout/vouchers/payment_update.php',
											 method:'POST',
											 data:$('#payment_create_form').serialize(),
											 success:function(data)
												 {
													 $('#payment_create_form').trigger('reset');
													 window.location.href="/layout/vouchers/payment_list.php";
												 }
										});		
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
								alert('Please select the mode of payment!');
							}
						} 
						else 
						{
							alert('Please select the date for the payment voucher!');
						}
					} 
					else 
					{
						alert('Please select the ledger from which payment is being made!');
					};
				});
			}

			function search_payment_by_name()
			{
				$(document).on('keyup','#payment_search_name',function(e){
					e.preventDefault();
					var company_id = $('#session_company_id').val();
					var payment_search_name = $('#payment_search_name').val();

					$.ajax({
						 url:'/layout/vouchers/payment_search_by_name.php',
						 method:'POST',
						 data:{payment_search_name:payment_search_name,company_id:company_id},
						 success:function(data)
							 {
								 $('#payment_list_card_body').html(data);
							 }
					});
				});
			}

			function search_payment_by_date()
			{
				$(document).on('click','#payment_search_icon',function(e){
					e.preventDefault();
					var company_id = $('#session_company_id').val();
					var start_date = $('#payment_search_from').val();
					var end_date = $('#payment_search_to').val();

					$.ajax({
						 url:'/layout/vouchers/payment_search_by_date.php',
						 method:'POST',
						 data:{start_date:start_date,end_date:end_date,company_id:company_id},
						 success:function(data)
						 {
							 $('#payment_list_card_body').html(data);
						 }
					});
				});
			}