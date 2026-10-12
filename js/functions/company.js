$(document).ready(function()
{
	//SETUP
		//COMPANY
			company_new_modal();
			company_open();
			company_save();
			company_edit();
			company_update();
			company_lock_unlock();
			company_subscription_open();
			company_subscription_modal();
			company_subscription_set_amount();
			company_subscription_set_expiry_date();
			company_subscription_save();
			company_subscription_edit();
			company_subscription_update();
			company_subscription_delete();
	});
	
	//COMPANY
		function company_new_modal()
		{
			$(document).on('click','#new_company_icon',function()
			{
				var user_super_id = $('#session_user_super_id').val();
				$('#user_super_id').val(user_super_id);
				$('#sms').val('No');
				$('#company_create_modal_header').html('Company Setup');
				$('#company_create_form').trigger('reset');
				$('#company_update_btn').hide();
				$('#company_save_btn').show();
				$('#company_status').val('Active');
				$('#company_create_modal').modal('show');
			}) 
		}

		function company_open()
		{
			$(document).on('click','#btn_open_company',function(){
				var company_id = $(this).attr('data-id');
				var company_type_id = $(this).attr('data-id3');
				var company_sms = $(this).attr('data-id4');
				$.ajax({
					url:'/layout/items/company_open.php',
					method:'POST',
					datatype: 'JSON',
					data:{
						company_id:company_id, 
						company_type_id:company_type_id, 
						company_sms:company_sms
					},
					success:function(data)
					{
						var res = $.parseJSON(data);
						if(res[2] == 'Open')
						{
							window.location.href="/welcome.php";
						}
						else if(res[2] == 'Expired_Closed')
						{
							alert('The Company subscription has expired on '+ res[1]+' and login blocked. Please the Administrator!');
						}
						else if(res[2] == 'Expired_Grace')
						{
							alert('The Company subscription has expired '+res[1]+', login will be blocked on '+res[0]+'. Please the Administrator!');
							window.location.href="/welcome.php";
						};
					}
				});	
			});
		}

		function company_save()
		{
			$(document).on('click','#company_save_btn',function(e){
				var user_super_id = $('#session_user_super_id').val();
				var trading_name = $('#trading_name').val();
				var legal_name = $('#legal_name').val();
				var location = $('#location').val();
				var currency = $('#currency').val();
				var email = $('#email').val();
				var telephone = $('#telephone').val();
				var momo_phone = $('#momo_phone').val();
				var company_type_id = $('#company_type_id').val();

				e.preventDefault();
				if (trading_name !== "") 
				{
					if (legal_name !== "") 
					{
						if (location !== "") 
						{
							if (currency !== "") 
							{
								if (telephone !== "") 
								{
									if (company_type_id !== "" && company_type_id > 0) 
									{
										$.ajax({
											url:'/layout/items/company_save.php',
											method:'POST',
											data:$('#company_create_form').serialize(),
											success:function(data)
											{
												$('#company_create_form').trigger('reset');
												$('#company_create_modal').modal('hide');
												window.location.href="/layout/items/company_list.php";
											}
										});	
									} 
									else 
									{
										$('#company_warning_div').html('<h6 style=color:red;>Please the Company Type cannot be EMPTY!</h6>');
										$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
									}
								} 
								else 
								{
									$('#company_warning_div').html('<h6 style=color:red;>Please the Telephone cannot be EMPTY!</h6>');
									$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
								}
							} 
							else 
							{
								$('#company_warning_div').html('<h6 style=color:red;>Please the Currency cannot be EMPTY!</h6>');
								$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
							}
						} 
						else 
						{
							$('#company_warning_div').html('<h6 style=color:red;>Please the Location cannot be EMPTY!</h6>');
							$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
						}
					} 
					else 
					{
						$('#company_warning_div').html('<h6 style=color:red;>Please the Legal Name cannot be EMPTY!</h6>');
						$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
					}
				} 
				else 
				{
					$('#company_warning_div').html('<h6 style=color:red;>Please the Trading Name cannot be EMPTY!</h6>');
					$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
				}
			});
		}

		function company_edit()
		{
			$(document).on('click','#btn_edit_company',function()
			{
				var company_id = $(this).attr('data-id');
				$.ajax({  
						url:'/layout/items/company_edit.php',  
						method:'POST',  
						data:{
							company_id:company_id
						},
						datatype: 'JSON',
						success:function(data){
							var res = $.parseJSON(data);
							$('#company_id').val(res[0]);
							$('#trading_name').val(res[1]);
							$('#legal_name').val(res[2]);
							$('#company_logo_file').val(res[3]);
							$('#address').val(res[4]);
							$('#location').val(res[5]);
							$('#gps').val(res[6]);
							$('#telephone').val(res[7]);
							$('#whatsapp_phone').val(res[8]);
							$('#momo_phone').val(res[9]);
							$('#email').val(res[10]);
							$('#website').val(res[11]);
							$('#admin_username').val(res[12]);
							$('#admin_email').val(res[13]);
							$('#admin_password').val(res[14]);
							$('#currency').val(res[15]);
							$('#company_type_id').val(res[16]);
							$('#company_status').val(res[17]);
							$('#sms').val(res[18]);
							$('#company_create_modal_header').html('Company Edit');
							$('#company_update_btn').show();
							$('#company_save_btn').hide();
							$('#company_create_modal').modal('show');
						}  
					});
			});
		}

		function company_update()
		{
			$(document).on('click','#company_update_btn',function(e){
				e.preventDefault();
				var user_super_id = $('#session_user_super_id').val();
				var trading_name = $('#trading_name').val();
				var legal_name = $('#legal_name').val();
				var location = $('#location').val();
				var currency = $('#currency').val();
				var email = $('#email').val();
				var telephone = $('#telephone').val();
				var momo_phone = $('#momo_phone').val();
				var company_type_id = $('#company_type_id').val();
				if (trading_name !== "") 
				{
					if (legal_name !== "") 
					{
						if (location !== "") 
						{
							if (currency !== "") 
							{
								if (telephone !== "") 
								{
									if (company_type_id !== "" && company_type_id > 0) 
									{
										
										$.ajax({
											url:'/layout/items/company_update.php',
											method:'POST',
											data:$('#company_create_form').serialize(),
											success:function(data)
											{
												$('#company_create_form').trigger('reset');
												$('#company_create_modal').modal('hide');
												window.location.href="/layout/items/company_list.php";
											}
										});	
									} 
									else 
									{
										$('#company_warning_div').html('<h6 style=color:red;>Please the Company Type cannot be EMPTY!</h6>');
										$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
									}
								} 
								else 
								{
									$('#company_warning_div').html('<h6 style=color:red;>Please the Telephone cannot be EMPTY!</h6>');
									$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
								}
							} 
							else 
							{
								$('#company_warning_div').html('<h6 style=color:red;>Please the Currency cannot be EMPTY!</h6>');
								$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
							}
						} 
						else 
						{
							$('#company_warning_div').html('<h6 style=color:red;>Please the Location cannot be EMPTY!</h6>');
							$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
						}
					} 
					else 
					{
						$('#company_warning_div').html('<h6 style=color:red;>Please the Legal Name cannot be EMPTY!</h6>');
						$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
					}
				} 
				else 
				{
					$('#company_warning_div').html('<h6 style=color:red;>Please the Trading Name cannot be EMPTY!</h6>');
					$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
				}
			});
		}

		function company_lock_unlock()
		{
			$(document).on('click','#btn_lock_company, #btn_unlock_company',function(e){
				e.preventDefault();
				var company_id = $(this).attr('data-id');
				var status = $(this).attr('data-id1');
				$.ajax({
					url:'/layout/items/company_lock.php',
					method:'POST',
					data:{company_id:company_id,status:status},
					success:function(data)
					{
						window.location.href="/layout/items/company_list.php";
					}
				});	
			});	
		}

		function company_subscription_open()
		{
			$(document).on('click','#btn_subscription_open',function()
			{
				var company_id = $(this).attr('data-id');
				
				$.ajax({
					url:'/layout/items/company_subscription_modal_show.php',
					method:'POST',
					data:{company_id:company_id},
					success:function(data)
					{
						window.location.href="/layout/items/company_subscription.php";
					}
				});
			}) 
		}

		function company_subscription_modal()
		{
			$(document).on('click','#btn_subscription_company',function()
			{
				var company_id = $(this).attr('data-id');
				$('#company_subscription_modal_header').html('Company Subscription Form');
				$('#company_subscription_form').trigger('reset');
				$('#company_subscription_company_id').val(company_id);
				$('#company_subscription_company_idD').val(company_id);
				$('#company_sub_update_btn').hide();
				$('#company_sub_save_btn').show();
				$('#company_subscription_modal').modal('show');
			}) 
		}

		function company_subscription_set_amount()
		{
			$(document).on('keyup','#price, #no_of_months, #exchange_rate',function()
			{
				var price = $('#price').val();
				var no_of_months = $('#no_of_months').val();
				var exchange_rate = $('#exchange_rate').val();
				var amount_dollar = price *no_of_months;
				var amount_cedi = amount_dollar *exchange_rate;
				$('#amount_dollar').val(amount_dollar);
				$('#amount_dollarD').val(amount_dollar);
				$('#amount_cedi').val(amount_cedi);
				$('#amount_cediD').val(amount_cedi);
			}) 
		}

		function company_subscription_set_expiry_date()
		{
			$(document).on('change','#start_date',function()
			{
				var start_date = $('#start_date').val();
				var no_of_months = $('#no_of_months').val();
				var d = new Date(start_date);
				var day = d.getDate();
				var month = d.getMonth();

				//EXPIRY DATE
				var month = parseInt(month) + parseInt(no_of_months) + parseInt(1);
				var year = d.getFullYear();
				var date = year+'-'+month+'-'+day;
				var datetime = new Date(date);
				var expiry_date = moment(datetime).format("YYYY-MM-DD");
				$('#expiry_date').val(expiry_date);

				//GRACE PERIOD
				var month2 = parseInt(month) + parseInt(1);
				var date2 = year+'-'+month2+'-'+day;
				var datetime2 = new Date(date2);
				var grace_date = moment(datetime2).format("YYYY-MM-DD");
				$('#date_grace').val(grace_date);
			}) 
		}
		
		function company_subscription_save()
		{
			$(document).on('click','#company_sub_save_btn',function(e){
				var price = $('#price').val();
				var no_of_months = $('#no_of_months').val();
				var exchange_rate = $('#exchange_rate').val();
				var start_date = $('#start_date').val();
				var expiry_date = $('#expiry_date').val();
				var date_grace = $('#date_grace').val();

				e.preventDefault();
				if (price !== "") 
				{
					if (no_of_months != "") 
					{
						if (exchange_rate != "") 
						{
							if (start_date != "") 
							{
								if (expiry_date != "") 
								{
									if (date_grace != "") 
									{
										if (expiry_date > start_date) 
										{
											if (date_grace > expiry_date) 
											{
												$.ajax({
													url:'/layout/items/company_subscription_save.php',
													method:'POST',
													data:$('#company_subscription_form').serialize(),
													success:function(data)
													{
														$('#company_subscription_form').trigger('reset');
														$('#company_subscription_modal').modal('hide');
														window.location.href="/layout/items/company_subscription.php";
													}
												});
											} 
											else 
											{
												$('#company_warning_div').html('<h6 style=color:red;>Please the Grace Period cannot be earlier than the Expiry Date!</h6>');
												$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
											}
										} 
										else 
										{
											$('#company_warning_div').html('<h6 style=color:red;>Please the Expiry Date cannot be earlier than the Start Date!</h6>');
											$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
										}
									} 
									else 
									{
										$('#company_warning_div').html('<h6 style=color:red;>Please the Expiry Date cannot be EMPTY!</h6>');
										$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
									}
								} 
								else 
								{
									$('#company_warning_div').html('<h6 style=color:red;>Please the Expiry Date cannot be EMPTY!</h6>');
									$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
								}
							} 
							else 
							{
								$('#company_warning_div').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
								$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
							}
						} 
						else 
						{
							$('#company_warning_div').html('<h6 style=color:red;>Please the Exchange Rate cannot be EMPTY!</h6>');
							$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
						}
					} 
					else 
					{
						$('#company_warning_div').html('<h6 style=color:red;>Please the No Of Months cannot be EMPTY!</h6>');
						$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
					}
				} 
				else 
				{
					$('#company_warning_div').html('<h6 style=color:red;>Please the Bill Rate cannot be EMPTY!</h6>');
					$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
				}
			});
		}

		function company_subscription_edit()
		{
			$(document).on('click','#btn_edit_subscription',function()
			{
				var sub_bill_id = $(this).attr('data-id');
				$.ajax({
						url:'/layout/items/company_subscription_edit.php',  
						method:'POST',  
						data:{sub_bill_id:sub_bill_id},
						datatype: 'JSON',
						success:function(data){
							var res = $.parseJSON(data);
							$('#sub_bill_id').val(res[0]);
							$('#company_subscription_company_id').val(res[1]);
							$('#price').val(res[2]);
							$('#no_of_months').val(res[3]);
							$('#exchange_rate').val(res[4]);
							$('#start_date').val(res[5]);
							$('#amount_dollar').val(res[6]);
							$('#amount_dollarD').val(res[6]);
							$('#amount_cedi').val(res[7]);
							$('#amount_cediD').val(res[7]);
							$('#expiry_date').val(res[8]);
							$('#date_grace').val(res[9]);
							$('#company_subscription_modal_header').html('Edit Subscription');
							$('#company_sub_update_btn').show();
							$('#company_sub_save_btn').hide();
							$('#company_subscription_modal').modal('show');
						}
				});
			});
		}
		
		function company_subscription_update()
		{
			$(document).on('click','#company_sub_update_btn',function(e){
				var price = $('#price').val();
				var no_of_months = $('#no_of_months').val();
				var exchange_rate = $('#exchange_rate').val();
				var start_date = $('#start_date').val();
				var expiry_date = $('#expiry_date').val();
				var date_grace = $('#date_grace').val();

				e.preventDefault();
				if (price !== "") 
				{
					if (no_of_months != "") 
					{
						if (exchange_rate != "") 
						{
							if (start_date != "") 
							{
								if (expiry_date != "") 
								{
									if (date_grace != "") 
									{
										if (expiry_date > start_date) 
										{
											if (date_grace > expiry_date) 
											{
												$.ajax({
													url:'/layout/items/company_subscription_update.php',
													method:'POST',
													data:$('#company_subscription_form').serialize(),
													success:function(data)
													{
														$('#company_subscription_form').trigger('reset');
														$('#company_subscription_modal').modal('hide');
														window.location.href="/layout/items/company_subscription.php";
													}
												});
											} 
											else 
											{
												$('#company_warning_div').html('<h6 style=color:red;>Please the Grace Period cannot be earlier than the Expiry Date!</h6>');
												$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
											}
										} 
										else 
										{
											$('#company_warning_div').html('<h6 style=color:red;>Please the Expiry Date cannot be earlier than the Start Date!</h6>');
											$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
										}
									} 
									else 
									{
										$('#company_warning_div').html('<h6 style=color:red;>Please the Expiry Date cannot be EMPTY!</h6>');
										$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
									}
								} 
								else 
								{
									$('#company_warning_div').html('<h6 style=color:red;>Please the Expiry Date cannot be EMPTY!</h6>');
									$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
								}
							} 
							else 
							{
								$('#company_warning_div').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
								$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
							}
						} 
						else 
						{
							$('#company_warning_div').html('<h6 style=color:red;>Please the Exchange Rate cannot be EMPTY!</h6>');
							$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
						}
					} 
					else 
					{
						$('#company_warning_div').html('<h6 style=color:red;>Please the No Of Months cannot be EMPTY!</h6>');
						$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
					}
				} 
				else 
				{
					$('#company_warning_div').html('<h6 style=color:red;>Please the Bill Rate cannot be EMPTY!</h6>');
					$('#company_warning_div').hide().slideDown().delay(2000).fadeOut();
				}
			});
		}

		function company_subscription_delete()
		{
			$(document).on('click','#btn_delete_subscription',function(){
				var sub_bill_id = $(this).attr('data-id');
				var currentRow=$(this).closest("tr");
				var expiry_date = currentRow.find("td:eq(2)").text();
				//var Supplier = currentRow.find("td:eq(3)").text();
				$('#subscription_delete_question').text('Are you sure you want to delete subscription of ' + expiry_date + '?');
				$('#subscription_delete_modal').modal('show');
				$(document).on('click','#subscription_delete_yes',function(){
					$.ajax({  
						url:'/layout/items/company_subscription_delete.php',  
						type:'POST',  
						data:{sub_bill_id:sub_bill_id},
						success:function()
						{
							$('#subscription_delete_modal').modal('hide');
							window.location.href="/layout/items/company_subscription.php";
						}
					});
				});
				$(document).on('click','#subscription_delete_no',function(){
					$('#subscription_delete_modal').modal('hide');
				});
			});
		}