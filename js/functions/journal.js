$(document).ready(function()
{
	//JOURNAL
		new_journal_voucher_modal();
		cancel_journal_voucher_modal();
		save_journal_voucher();
		edit_journal_voucher();
		update_journal_voucher();
		search_journal_by_name();
		search_journal_by_date();
});

			//JOURNAL
			function new_journal_voucher_modal()
			{
				$(document).on('click','#new_journal_icon',function()
				{
					var company_id = $('#session_company_id').val();
					var user_super_id = $('#session_user_super_id').val();
					var user_id = $('#session_user_id').val();
					$('#company_id').val(company_id);
					$('#user_super_id').val(user_super_id);
					$('#user_id').val(user_id);
					$('#journal_update_btn').hide();
					$('#journal_save_btn').show();
					$('#journal_create_form').trigger('reset');
					$('#journal_create_modal').modal('show');
				});
			}

			function cancel_journal_voucher_modal()
			{
				$(document).on('click','#contra_cancel_btn',function()
				{
					$('#contra_create_form').trigger('reset');
					$('#contra_create_modal').modal('hide');
					window.location.href="/layout/vouchers/contra_list.php";
				});
			}

			function save_journal_voucher()
			{
				$(document).on('click','#journal_save_btn',function(e){
					e.preventDefault();
					var journal_debit_ledger = $('#journal_debit_ledger').val();
					var journal_credit_ledger = $('#journal_credit_ledger').val();
					var journal_date = $('#journal_date').val();
					var journal_ref = $('#journal_ref').val();
					var journal_narration = $('#journal_narration').val();
					var journal_amount = $('#journal_amount').val();
					if (journal_debit_ledger !=="") 
					{
						if (journal_credit_ledger !=="") 
						{
							if (journal_credit_ledger !== journal_debit_ledger) 
							{
								if (journal_date !=="") 
								{
									if (journal_amount !=="") 
									{
										if (journal_narration !=="") 
										{
											
											$.ajax({
												url:'/layout/vouchers/journal_save.php',
												method:'POST',
												data:$('#journal_create_form').serialize(),
												success:function(data)
												{
													$('#journal_create_form').trigger('reset');
													window.location.href="/layout/vouchers/journal_list.php";
												}
											});		
											
										} 
										else 
										{
											alert('The Narration cannot be EMPTY!');
										}
									} 
									else 
									{
										alert('The Amount cannot be EMPTY!');
									}
								} 
								else 
								{
									alert('Please select the date for the Journal Voucher!');
								}
							} 
							else 
							{
								alert('The Credit Ledger cannot be the SAME and the Debit Ledger!');
							};
						} 
						else 
						{
							alert('The Credit Ledger cannot be EMPTY!');
						};
					} 
					else 
					{
						alert('The Debit Ledger cannot be EMPTY!');
					};
				});
			}

			function edit_journal_voucher()
			{
				$(document).on('click','#btn_edit_journal',function(){
					var journal_id = $(this).attr('data-id');
					$.ajax({
						url:'/layout/vouchers/journal_edit.php',
						method:'POST',
						data:{journal_id:journal_id},
						datatype:'JSON',
						success:function(data)
						{
							 var res = $.parseJSON(data);
							 $('#journal_id').val(res[1]);
							 $('#company_id').val(res[2]);
							 $('#user_id').val(res[3]);
							 $('#user_super_id').val(res[0]);
							 $('#journal_debit_ledger').val(res[5]);
							 $('#journal_credit_ledger').val(res[4]);
							 $('#journal_ref').val(res[9]);
							 $('#journal_date').val(res[6]);
							 $('#journal_amount').val(res[7]);
							 $('#journal_narration').val(res[8]);
							 $('#journal_update_btn').show();
							 $('#journal_save_btn').hide();
							$('#journal_create_modal').modal('show');
						}
					 });
				});
			}

			function update_journal_voucher()
			{
				$(document).on('click','#journal_update_btn',function(e){
					e.preventDefault();
					var journal_debit_ledger = $('#journal_debit_ledger').val();
					var journal_credit_ledger = $('#journal_credit_ledger').val();
					var journal_date = $('#journal_date').val();
					var journal_ref = $('#journal_ref').val();
					var journal_narration = $('#journal_narration').val();
					var journal_amount = $('#journal_amount').val();
					if (journal_debit_ledger !=="") 
					{
						if (journal_credit_ledger !=="") 
						{
							if (journal_credit_ledger !== journal_debit_ledger) 
							{
								if (journal_date !=="") 
								{
									if (journal_amount !=="") 
									{
										if (journal_narration !=="") 
										{
											
											$.ajax({
												url:'/layout/vouchers/journal_update.php',
												method:'POST',
												data:$('#journal_create_form').serialize(),
												success:function(data)
												{
													$('#journal_create_form').trigger('reset');
													window.location.href="/layout/vouchers/journal_list.php";
												}
											});		
											
										} 
										else 
										{
											alert('The Narration cannot be EMPTY!');
										}
									} 
									else 
									{
										alert('The Amount cannot be EMPTY!');
									}
								} 
								else 
								{
									alert('Please select the date for the Journal Voucher!');
								}
							} 
							else 
							{
								alert('The Credit Ledger cannot be the SAME and the Debit Ledger!');
							};
						} 
						else 
						{
							alert('The Credit Ledger cannot be EMPTY!');
						};
					} 
					else 
					{
						alert('The Debit Ledger cannot be EMPTY!');
					};
				});
			}

			function search_journal_by_name()
			{
				$(document).on('keyup','#journal_search_name',function(e){
					e.preventDefault();
					var company_id = $('#session_company_id').val();
					var journal_search_name = $('#journal_search_name').val();

					$.ajax({
						 url:'/layout/vouchers/journal_search_by_name.php',
						 method:'POST',
						 data:{journal_search_name:journal_search_name,company_id:company_id},
						 success:function(data)
							 {
								 $('#journal_list_card_body').html(data);
							 }
					});
				});
			}

			function search_journal_by_date()
			{
				$(document).on('click','#journal_search_icon',function(e){
					e.preventDefault();
					var company_id = $('#session_company_id').val();
					var start_date = $('#journal_search_from').val();
					var end_date = $('#journal_search_to').val();

					$.ajax({
						 url:'/layout/vouchers/journal_search_by_date.php',
						 method:'POST',
						 data:{start_date:start_date,end_date:end_date,company_id:company_id},
						 success:function(data)
							 {
								 $('#journal_list_card_body').html(data);
							 }
					});
				});
			}