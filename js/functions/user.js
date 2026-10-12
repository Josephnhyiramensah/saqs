$(document).ready(function()
{
	//USER_ULTRA_SUPER
		user_ultra_super_new_modal();
		user_ultra_super_save();
		user_ultra_super_edit();
		user_ultra_super_update();
	//USER TYPES
		user_type_new_modal();
		user_type_save();
		user_type_edit();
		user_type_update();
	//USER PRIVILEGES
		user_privilege_new_modal();
		user_privilege_save();
		user_privilege_edit();
		user_privilege_update();
	//USERS-PERSONAL
		user_personal_new_modal();
		user_personal_save();
		user_personal_change_password_modal();
		user_personal_change_password_update();
		user_personal_reset_password_modal();
		user_personal_reset_password_update();
	//USERS
		user_sign_in();
		user_new_modal();
		user_save();
		user_edit();
		user_update();
		user_change_user_type();
		add_user_cash_ledger_row();
		delete_user_cash_ledger_row();
		user_change_branch();
	//USERS-ADMIN
		user_admin_new_sheet();
		user_admin_save();
		user_admin_edit();
		user_admin_update();
	
});

	//USER_ULTRA_SUPER
	function user_ultra_super_new_modal()
	{
		$(document).on('click','#new_user_ultra_super_icon',function()
		{
			$('#user_ultra_super_create_form').trigger('reset');
			$('#user_ultra_super_update_btn').hide();
			$('#user_ultra_super_save_btn').show();
			$('#user_ultra_super_create_modal').modal('show');
		});
	}

	function user_ultra_super_save()
	{
		$(document).on('click','#user_ultra_super_save_btn',function(e){
			e.preventDefault();
			var name = $('#user_ultra_super_name').val();
			var email = $('#user_ultra_super_email').val();
			var password = $('#user_ultra_super_password').val();
			if (email !== '') 
			{
				if (name !== '') 
				{
					if (password !== '') 
					{
						$.ajax({
							 url:'/layout/items/user_ultra_super_save.php',
							 method:'POST',
							 data:$('#user_ultra_super_create_form').serialize(),
							 success:function(data)
							 {
								 if (data == 'exist')
								 {
									 $('#user_form_msg').html('<h4 style=color:red;>Email NOT available!</h4>');
									$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
								 } 
								 else if (data == 'inserted')
								 {
									 $('#user_ultra_super_create_form').trigger('reset');
									 $('#user_ultra_super_create_modal').modal('hide');
									 window.location.href="/layout/items/user_ultra_super_list.php";
								 };
							 }
						});
					} 
					else 
					{
						$('#user_ultra_super_form_msg').html('<h6 style=color:red;>The Password cannot be EMPTY!</h6>');
						$('#user_ultra_super_form_msg').hide().slideDown().delay(2000).fadeOut();
					};
				} 
				else 
				{
					$('#user_ultra_super_form_msg').html('<h6 style=color:red;>The Name cannot be EMPTY!</h6>');
					$('#user_ultra_super_form_msg').hide().slideDown().delay(2000).fadeOut();
				};
			} 
			else 
			{
				$('#user_ultra_super_form_msg').html('<h6 style=color:red;>The Email cannot be EMPTY!</h6>');
				$('#user_ultra_super_form_msg').hide().slideDown().delay(2000).fadeOut();
			};
		});
	}

	function user_ultra_super_edit()
	{
		$(document).on('click','#btn_edit_user_ultra_super',function()
		{
			var user_id = $(this).attr('data-id');
			$.ajax({  
					 url:'/layout/items/user_ultra_super_edit.php',  
					 method:'POST',  
					 data:{
						 user_id:user_id
					 },
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#user_ultra_super_id').val(res[0]);
						 $('#user_ultra_super_name').val(res[1]);
						 $('#user_ultra_super_email').val(res[2]);
					 }  
				});
		});
	}

	function user_ultra_super_update()
	{
		$(document).on('click','#user_ultra_super_update_btn',function(e){
			e.preventDefault();
			var user_type = $('#user_type').val();
			var telephone = $('#telephone').val();
			var first_name = $('#first_name').val();
			var email = $('#email').val();
			if (email !== '') 
			{
				if (first_name !== '') 
				{
					if (user_type !== '') 
					{
						if (telephone !== '') 
						{
							$.ajax({
								 url:'/layout/items/user_update.php',
								 method:'POST',
								 data:$('#user_create_form').serialize(),
								 success:function(data)
									 {
										 if (data == 'exist')
										 {
											 $('#user_form_msg').html('<h4 style=color:red;>Email NOT available!</h4>');
											$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
										 } 
										 else if (data == 'inserted')
										 {
											 $('#user_create_form').trigger('reset');
											 $('#user_create_modal').modal('hide');
											 window.location.href="/layout/items/user_list.php";
										 };
									 }
							});
						} 
						else 
						{
							$('#user_form_msg').html('<h4 style=color:red;>Telephone cannot be EMPTY!</h4>');
							$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#user_form_msg').html('<h4 style=color:red;>User Type cannot be EMPTY!</h4>');
						$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
					};
				} 
				else 
				{
					$('#user_form_msg').html('<h4 style=color:red;>First Name cannot be EMPTY!</h4>');
					$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
				};
			} 
			else 
			{
				$('#user_form_msg').html('<h4 style=color:red;>Email cannot be EMPTY!</h4>');
				$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
			};
		});
	}

//USER TYPES
	function user_type_new_modal()
	{
		$(document).on('click','#new_user_type_icon',function()
		{
			var user_type_id = "";
			$.ajax({
				url:'/layout/items/user_type_privilege_list.php',
				method:'POST',
				data:{
					 user_type_id:user_type_id
				 },
				success:function(data)
				{
					 $('#user_type_create_form').trigger('reset');
					 $('#user_type_privileges_div').html(data);
					$('#user_type_update_btn').hide();
					$('#user_type_save_btn').show();
					$('#user_type_create_modal').modal('show');
				}
			});	
		}) 
	}

	function user_type_save()
	{
		$(document).on('click','#user_type_save_btn',function(e){
			e.preventDefault();
			var user_type_desc = $('#user_type_desc').val();
			if (user_type_desc != '') 
			{
				$.ajax({
					 url:'/layout/items/user_type_save.php',
					 method:'POST',
					 data:$('#user_type_create_form').serialize(),
					 success:function(data)
						 {
							 $('#user_type_create_form').trigger('reset');
							 $('#user_type_create_modal').modal('hide');
							 window.location.href="/layout/items/user_type_list.php";
						 }
				});	
			} 
			else 
			{
					$('#user_type_form_msg').html('<h6 style=color:red;>Description cannot be EMPTY!</h6>');
					$('#user_type_form_msg').hide().slideDown().delay(2000).fadeOut();
			};
				
		});
	}

	function user_type_edit()
	{
		$(document).on('click','#btn_edit_user_type',function()
		{
			var user_type_id = $(this).attr('data-id');
			$('#user_type_id').val(user_type_id);
			$.ajax({  
				 url:'/layout/items/user_type_edit.php',  
				 method:'POST',  
				 data:{
					 user_type_id:user_type_id
				 },
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $('#user_type_id').val(res[0]);
					 $('#user_type_desc').val(res[1]);
					 $.ajax({
						url:'/layout/items/user_type_privilege_list.php',
						method:'POST',
						data:{
							 user_type_id:user_type_id
						},
						success:function(data)
						{
							 $('#user_type_privileges_div').html(data);
							 $('#user_type_create_modal_header').html('User Type Edit');
							$('#user_type_update_btn').show();
							$('#user_type_save_btn').hide();
							 $('#user_type_create_modal').modal('show');
						}
					});

				 }  
			});
		});
	}

	function user_type_update()
	{
		$(document).on('click','#user_type_update_btn',function(e){
			e.preventDefault();
			var user_type_desc = $('#user_type_desc').val();
			if (user_type_desc != '') 
			{
				$.ajax({
					 url:'/layout/items/user_type_update.php',
					 method:'POST',
					 data:$('#user_type_create_form').serialize(),
					 success:function(data)
						 {
							 $('#user_type_create_form').trigger('reset');
							 $('#user_type_create_modal').modal('hide');
							 window.location.href="/layout/items/user_type_list.php";
						 }
				});	
			} 
			else 
			{
					$('#user_type_form_msg').html('<h6 style=color:red;>Description cannot be EMPTY!</h6>');
					$('#user_type_form_msg').hide().slideDown().delay(2000).fadeOut();
			};
				
		});
	}

//USER PRIVILEGES
	function user_privilege_new_modal()
	{
		$(document).on('click','#new_user_privilege_icon',function()
		{
			$('#user_privilege_create_form').trigger('reset');
			$('#user_privilege_update_btn').hide();
			$('#user_privilege_save_btn').show();
			$('#user_privilege_create_modal').modal('show');
		}) 
	}

	function user_privilege_save()
	{
		$(document).on('click','#user_privilege_save_btn',function(e){
			e.preventDefault();
			var user_priv_page_id = $('#user_priv_page_id').val();
			var user_privilege_desc = $('#user_privilege_desc').val();
			if (user_privilege_desc != '') 
			{
				if (user_priv_page_id > 0) 
				{
					$.ajax({
						 url:'/layout/items/user_privilege_save.php',
						 method:'POST',
						 data:$('#user_privilege_create_form').serialize(),
						 success:function(data)
							 {
								 $('#user_privilege_create_form').trigger('reset');
								 $('#user_privilege_create_modal').modal('hide');
								 window.location.href="/layout/items/user_privileges_list.php";
							 }
					});	
				} 
				else 
				{
						$('#user_privilege_form_msg').html('<h6 style=color:red;>Page cannot be EMPTY!</h6>');
						$('#user_privilege_form_msg').hide().slideDown().delay(2000).fadeOut();
				};
			} 
			else 
			{
					$('#user_privilege_form_msg').html('<h6 style=color:red;>Privilege Description cannot be EMPTY!</h6>');
					$('#user_privilege_form_msg').hide().slideDown().delay(2000).fadeOut();
			};
				
		});
	}

	function user_privilege_edit()
	{
		$(document).on('click','#btn_user_privilege_edit',function()
		{
			var user_priv_id = $(this).attr('data-id');
			$('#user_privilege_id').val(user_priv_id);
			$.ajax({  
				 url:'/layout/items/user_privilege_edit.php',  
				 method:'POST',  
				 data:{
					 user_priv_id:user_priv_id
				 },
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $('#user_privilege_id').val(res[0]);
					 $('#user_privilege_desc').val(res[1]);
					 $('#user_priv_page_id').val(res[2]);
					 $('#user_privilege_create_modal_header').html('User Privilege Edit');
					$('#user_privilege_update_btn').show();
					$('#user_privilege_save_btn').hide();
					 $('#user_privilege_create_modal').modal('show');
				 }  
			});
		});
	}

	function user_privilege_update()
	{
		$(document).on('click','#user_privilege_update_btn',function(e){
			e.preventDefault();
			var user_priv_page_id = $('#user_priv_page_id').val();
			var user_privilege_desc = $('#user_privilege_desc').val();
			if (user_privilege_desc != '') 
			{
				if (user_priv_page_id > 0) 
				{
					$.ajax({
						 url:'/layout/items/user_privilege_update.php',
						 method:'POST',
						 data:$('#user_privilege_create_form').serialize(),
						 success:function(data)
							 {
								 $('#user_privilege_create_form').trigger('reset');
								 $('#user_privilege_create_modal').modal('hide');
								 window.location.href="/layout/items/user_privileges_list.php";
							 }
					});	
				} 
				else 
				{
						$('#user_privilege_form_msg').html('<h6 style=color:red;>Page cannot be EMPTY!</h6>');
						$('#user_privilege_form_msg').hide().slideDown().delay(2000).fadeOut();
				};
			} 
			else 
			{
					$('#user_privilege_form_msg').html('<h6 style=color:red;>Privilege Description cannot be EMPTY!</h6>');
					$('#user_privilege_form_msg').hide().slideDown().delay(2000).fadeOut();
			};
		});
	}

//USERS-PERSONAL
	function user_personal_new_modal()
	{
		$(document).on('click','#new_user_link',function(e)
		{
			var company_id = $('#session_company_id').val();
			var user_super_id = $('#session_user_super_id').val();
			$('#user_personal_create_modal_header').html('User Setup');
			$('#user_personal_create_form').trigger('reset');
			$('#user_personal_company_id').val(company_id);
			$('#user_personal_company_id_2').val(company_id);
			$('#user_personal_user_super_id').val(user_super_id)
			$('#user_personal_update_btn').hide();
			$('#user_personal_save_btn').show();
			$('#user_personal_create_modal').modal('show');
		}) 
	}

	function user_personal_save()
	{
		$(document).on('click','#user_personal_save_btn',function(e){
			e.preventDefault();
			var name = $('#user_personal_full_name').val();
			var email = $('#user_personal_email').val();
			var password = $('#user_personal_password').val();
			var password_confirm = $('#user_personal_password_confirm').val();
			var telephone = $('#user_personal_telephone').val();
			if (name != '') 
			{
				if (email != '') 
				{
					if (password != '') 
					{
						if (password_confirm != '') 
						{
							if (telephone != '') 
							{
								if (password == password_confirm) 
								{
									$.ajax({
										url:'/layout/items/user_personal_save.php',
										method:'POST',
										data:$('#user_personal_create_form').serialize(),
										success:function(data)
										{
											if (data == 'exist')
											{
												$('#user_personal_form_msg').html('<h6 style=color:red;>Email NOT available!</h6>');
												$('#user_personal_form_msg').hide().slideDown().delay(2000).fadeOut();
											}
											else if (data == 'inserted')
											{
												$('#user_personal_create_form').trigger('reset');
												$('#user_personal_create_modal').modal('hide');
												$('#user_personal_form_msg').html('<h6 style=color:red;>User created successfully!</h6>');
												$('#user_personal_form_msg').hide().slideDown().delay(2000).fadeOut();
											};
										}
									});
								}
								else
								{
									$('#user_personal_form_msg').html('<h6 style=color:red;>Password does NOT match!</h6>');
									$('#user_personal_form_msg').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#user_personal_form_msg').html('<h6 style=color:red;>Telephone cannot be EMPTY!</h6>');
								$('#user_personal_form_msg').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#user_personal_form_msg').html('<h6 style=color:red;>Password Confirm cannot be EMPTY!</h6>');
							$('#user_personal_form_msg').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#user_personal_form_msg').html('<h6 style=color:red;>Password cannot be EMPTY!</h6>');
						$('#user_personal_form_msg').hide().slideDown().delay(2000).fadeOut();
					};
				} 
				else 
				{
					$('#user_personal_form_msg').html('<h6 style=color:red;>Email cannot be EMPTY!</h6>');
					$('#user_personal_form_msg').hide().slideDown().delay(2000).fadeOut();
				};
			} 
			else 
			{
				$('#user_personal_form_msg').html('<h6 style=color:red;>Name cannot be EMPTY!</h6>');
				$('#user_personal_form_msg').hide().slideDown().delay(2000).fadeOut();
			};
				
		});
	}

	function user_personal_change_password_modal()
	{
		$(document).on('click','#change_password_link',function()
		{
			$('#user_personal_change_password_form').trigger('reset');
			$('#user_personal_change_password_update_btn').show();
			$('#user_personal_change_password_modal').modal('show');
		}) 
	}

	function user_personal_change_password_update()
	{
		$(document).on('click','#user_personal_change_password_update_btn',function(e){
			e.preventDefault();
			var password_old = $('#user_personal_change_password_old').val();
			var password_new = $('#user_personal_change_password_new').val();
			var password_confirm = $('#user_personal_change_password_confirm').val();
			if (password_old != '') 
			{
				if (password_new != '') 
				{
					if (password_confirm != '') 
					{
							if (password_new == password_confirm) 
							{
								$.ajax({
									url:'/layout/items/user_personal_change_password_update.php',
									method:'POST',
									data:$('#user_personal_change_password_form').serialize(),
									success:function(data)
									{
										if (data == 'no_user_match')
										{
											$('#user_personal_change_password_form_msg').html('<h6 style=color:red;>User not found!</h6>');
											$('#user_personal_change_password_form_msg').hide().slideDown().delay(2000).fadeOut();
										}
										else if (data == 'old_password_not_match')
										{
											$('#user_personal_change_password_form_msg').html('<h6 style=color:red;>User old password does not match!</h6>');
											$('#user_personal_change_password_form_msg').hide().slideDown().delay(2000).fadeOut();
										}
										else if (data == 'password_not_updated')
										{
											$('#user_personal_change_password_form_msg').html('<h6 style=color:red;>User password not updated!</h6>');
											$('#user_personal_change_password_form_msg').hide().slideDown().delay(2000).fadeOut();
										}
										else if (data == 'password_updated')
										{
											$('#user_personal_change_password_form').trigger('reset');
											$('#user_personal_change_password_form_msg').html('<h6 style=color:red;>Password updated successfully!</h6>');
											$('#user_personal_change_password_form_msg').hide().slideDown().delay(2000).fadeOut();
											$('#user_personal_change_password_modal').modal('hide');
										};
									}
								});
							}
							else
							{
								$('#user_personal_change_password_form_msg').html('<h6 style=color:red;>Password does NOT match!</h6>');
								$('#user_personal_change_password_form_msg').hide().slideDown().delay(2000).fadeOut();
							};
					} 
					else 
					{
						$('#user_personal_change_password_form_msg').html('<h6 style=color:red;>Password Confirm cannot be EMPTY!</h6>');
						$('#user_personal_change_password_form_msg').hide().slideDown().delay(2000).fadeOut();
					};			
				} 
				else 
				{
					$('#user_personal_change_password_form_msg').html('<h6 style=color:red;>New Password cannot be EMPTY!</h6>');
					$('#user_personal_change_password_form_msg').hide().slideDown().delay(2000).fadeOut();
				};
			} 
			else 
			{
				$('#user_personal_change_password_form_msg').html('<h6 style=color:red;>Old Password cannot be EMPTY!</h6>');
				$('#user_personal_change_password_form_msg').hide().slideDown().delay(2000).fadeOut();
			};
				
		});
	}

	function user_personal_reset_password_modal()
	{
		$(document).on('click','#btn_reset_user',function()
		{
			var user_id = $(this).attr('data-id');
			$('#user_personal_reset_password_form').trigger('reset');
			$('#user_personal_reset_password_user_id').val(user_id);
			$('#user_personal_reset_password_email').val(user_id);
			$('#user_personal_reset_password_email_2').val(user_id);
			$('#user_personal_reset_password_update_btn').show();
			$('#user_personal_reset_password_modal').modal('show');
		});
	}

	function user_personal_reset_password_update()
	{
		$(document).on('click','#user_personal_reset_password_update_btn',function(e)
		{
			e.preventDefault();
			var password_new = $('#user_personal_reset_password_new').val();
			var password_confirm = $('#user_personal_reset_password_confirm').val();
			if (password_new != '') 
			{
				if (password_confirm != '') 
				{
						if (password_new == password_confirm) 
						{
							$.ajax({
								url:'/layout/items/user_personal_reset_password_update.php',
								method:'POST',
								data:$('#user_personal_reset_password_form').serialize(),
								success:function(data)
								{
									if (data == 'no_user_match')
									{
										$('#user_personal_reset_password_form_msg').html('<h6 style=color:red;>User not found!</h6>');
										$('#user_personal_reset_password_form_msg').hide().slideDown().delay(2000).fadeOut();
									}
									else if (data == 'password_do_not_match')
									{
										$('#user_personal_reset_password_form_msg').html('<h6 style=color:red;>User old password does not match!</h6>');
										$('#user_personal_reset_password_form_msg').hide().slideDown().delay(2000).fadeOut();
									}
									else if (data == 'password_not_updated')
									{
										$('#user_personal_reset_password_form_msg').html('<h6 style=color:red;>User password not updated!</h6>');
										$('#user_personal_reset_password_form_msg').hide().slideDown().delay(2000).fadeOut();
									}
									else if (data == 'password_updated')
									{
										$('#user_personal_reset_password_form').trigger('reset');
										$('#user_personal_reset_password_form_msg').html('<h6 style=color:red;>Password updated successfully!</h6>');
										$('#user_personal_reset_password_form_msg').hide().slideDown().delay(2000).fadeOut();
										$('#user_personal_reset_password_modal').modal('hide');
									};
								}
							});
						}
						else
						{
							$('#user_personal_reset_password_form_msg').html('<h6 style=color:red;>Password does NOT match!</h6>');
							$('#user_personal_reset_password_form_msg').hide().slideDown().delay(2000).fadeOut();
						};
				} 
				else 
				{
					$('#user_personal_reset_password_form_msg').html('<h6 style=color:red;>Password Confirm cannot be EMPTY!</h6>');
					$('#user_personal_reset_password_form_msg').hide().slideDown().delay(2000).fadeOut();
				};
			} 
			else 
			{
				$('#user_personal_reset_password_form_msg').html('<h6 style=color:red;>New Password cannot be EMPTY!</h6>');
				$('#user_personal_reset_password_form_msg').hide().slideDown().delay(2000).fadeOut();
			};
		});
	}

//USERS
	function user_sign_in()
	{
		$(document).on('click','#user_sign_in',function(e)
		{
			e.preventDefault();
			var email = $('#user_email').val();
			var password = $('#user_password').val();
			if (email != '') 
			{
				if (password != '') 
				{
					$.ajax({
						url:'/layout/items/user_sign_in.php',
						method:'POST',
						data:$('#user_sign_in_form').serialize(),
						datatype: 'JSON',
						success:function(data)
						{
							var res = $.parseJSON(data);
							if (res[2] == 'Normal_User') 
							{
								$('#user_sign_in_form').trigger('reset');
								window.location.href="/welcome.php";
							}
							else if (res[2] == 'Rejected')
							{
								$('#user_sign_in_msg').html('<h6 style=color:red;>User Credential Rejected by the Administrator!</h6>');
								$('#user_sign_in_msg').hide().slideDown().delay(2000).fadeOut();
							}
							else if (res[2] == 'Pending')
							{
								$('#user_sign_in_msg').html('<h6 style=color:red;>User Credential is still Pending Approval by the Administrator!</h6>');
								$('#user_sign_in_msg').hide().slideDown().delay(2000).fadeOut();
							}
							else if (res[2] == 'Revoked')
							{
								$('#user_sign_in_msg').html('<h6 style=color:red;>User Credential has been Revoked by the Administrator!</h6>');
								$('#user_sign_in_msg').hide().slideDown().delay(2000).fadeOut();
							} 
							else if (res[2] == 'Super_User')
							{
								$('#user_sign_in_form').trigger('reset');
								window.location.href="/layout/items/company_list.php";
							} 
							else if (res[2] == 'Ultra_Super_User')
							{
								$('#user_sign_in_form').trigger('reset');
								window.location.href="/layout/items/company_list.php";
							}
							else if (res[2] == 'User_Not_Registered')
							{
								$('#user_sign_in_msg').html('<h6 style=color:red;>Your Email and Password does not match!</h6>');
								$('#user_sign_in_msg').hide().slideDown().delay(2000).fadeOut();
							}
							else if (res[2] == 'Closed')
							{
								$('#user_sign_in_msg').html('<h6 style=color:red;>The Company is closed. Please the Administrator to open!</h6>');
								$('#user_sign_in_msg').hide().slideDown().delay(2000).fadeOut();
							}
							else if (res[2] == 'Expired_Closed')
							{
								$('#user_sign_in_msg').html('<h6 style=color:red;>The Company subscription has expired on '+ res[1]+' and login blocked. Please the Administrator!</h6>');
								$('#user_sign_in_msg').hide().slideDown().delay(2000).fadeOut();
							}
							else if (res[2] == 'Expired_Grace')
							{
								$('#user_sign_in_msg').html('<h6 style=color:red;>The Company subscription has expired '+res[1]+', login will be blocked on '+res[0]+'. Please the Administrator!</h6>');
								$('#user_sign_in_msg').hide().slideDown().delay(2000).fadeOut();
							};
						}
					});
				}
				else 
				{
					$('#user_sign_in_msg').html('<h6 style=color:red;>Password Cannot Be EMPTY!</h6>');
					$('#user_sign_in_msg').hide().slideDown().delay(2000).fadeOut();
				};
			}
			else 
			{
				$('#user_sign_in_msg').html('<h6 style=color:red;>Email Cannot Be EMPTY!</h6>');
				$('#user_sign_in_msg').hide().slideDown().delay(2000).fadeOut();
			};
		}); 
	}

	function user_new_modal()
	{
		$(document).on('click','#new_user_icon',function()
		{
			var company_id = $('#session_company_id').val();
			var user_super_id = $('#session_user_super_id').val();
			var user_id = "";
			$.ajax({
				url:'/layout/items/user_privilege_list.php',
				method:'POST',
				data:{
					 user_id:user_id
				 },
				success:function(data)
				{
					$('#user_create_modal_header').html('User Setup');
					$('#user_create_form').trigger('reset');
					$('#ucm_company_id').val(company_id);
					$('#company_id_2').val(company_id);
					$('#company_id3').val(company_id);
					$('#ucm_user_super_id').val(user_super_id);
					$('#user_privileges_div').html(data);
					$('#user_update_btn').hide();
					$('#user_save_btn').show();
					$('#user_create_modal').modal('show');
				}
			});	
		});
	}

	function user_save()
	{
		$(document).on('click','#user_save_btn',function(e){
			e.preventDefault();
			var user_type = $('#user_type').val();
			var telephone = $('#telephone').val();
			var first_name = $('#first_name').val();
			var email = $('#email').val();
			if (email !== '') 
			{
				if (first_name !== '') 
				{
					if (user_type !== '') 
					{
						if (telephone !== '') 
						{
							$.ajax({
								 url:'/layout/items/user_save.php',
								 method:'POST',
								 data:$('#user_create_form').serialize(),
								 success:function(data)
								 {
									 if (data == 'exist')
									 {
										 $('#user_form_msg').html('<h4 style=color:red;>Email NOT available!</h4>');
										$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
									 } 
									 else if (data == 'inserted')
									 {
										 $('#user_create_form').trigger('reset');
										 $('#user_create_modal').modal('hide');
										 window.location.href="/layout/items/user_list.php";
									 };
								 }
							});
						} 
						else 
						{
							$('#user_form_msg').html('<h4 style=color:red;>Telephone cannot be EMPTY!</h4>');
							$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#user_form_msg').html('<h4 style=color:red;>User Type cannot be EMPTY!</h4>');
						$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
					};
				} 
				else 
				{
					$('#user_form_msg').html('<h4 style=color:red;>First Name cannot be EMPTY!</h4>');
					$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
				};
			} 
			else 
			{
				$('#user_form_msg').html('<h4 style=color:red;>Email cannot be EMPTY!</h4>');
				$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
			};
		});
	}

	function user_edit()
	{
		$(document).on('click','#btn_edit_user',function()
		{
			var user_id = $(this).attr('data-id');
			$.ajax({  
				url:'/layout/items/user_edit.php',  
				method:'POST',  
				data:{
				user_id:user_id
				},
				datatype: 'JSON',
				success:function(data)
				{
				var res = $.parseJSON(data);
				$('#ucm_company_id').val(res[0]);
				$('#company_id_2').val(res[0]);
				$('#ucm_user_id').val(res[1]);
				$('#last_name').val(res[2]);
				$('#user_approval_status').val(res[3]);
				$('#email').val(res[4]);
				$('#telephone').val(res[5]);
				$('#address').val(res[6]);
				$('#location').val(res[7]);
				$('#photo').val(res[8]);
				$('#first_name').val(res[9]);
				$('#ucm_user_super_id').val(res[10]);
				$('#user_type').val(res[11]);
				$('#warehouse_id').val(res[12]);
				$('#user_branch').val(res[13]);
				$.ajax({
					url:'/layout/items/user_privilege_list.php',
					method:'POST',
					data:{
						user_id:user_id
						},
					success:function(data)
					{
						$('#user_create_modal_header').html('User Edit');
						$('#user_privileges_div').html(data);
						$('#user_update_btn').show();
						$('#user_save_btn').hide();
						$.ajax({
							url:'/layout/items/user_cash_ledger_edit.php',
							method:'POST',
							data:{user_id:user_id},
							success:function(data)
							{
								$('#user_cash_ledger_list').html(data);
							}
						});
						$('#user_create_modal').modal('show');
					}
				});
				}  
			});
		});
	}

	function user_update()
	{
		$(document).on('click','#user_update_btn',function(e){
			e.preventDefault();
			var user_type = $('#user_type').val();
			var telephone = $('#telephone').val();
			var first_name = $('#first_name').val();
			var email = $('#email').val();
			if (email !== '') 
			{
				if (first_name !== '') 
				{
					if (user_type !== '') 
					{
						if (telephone !== '') 
						{
							$.ajax({
								 url:'/layout/items/user_update.php',
								 method:'POST',
								 data:$('#user_create_form').serialize(),
								 success:function(data)
									 {
										 if (data == 'exist')
										 {
											 $('#user_form_msg').html('<h4 style=color:red;>Email NOT available!</h4>');
											$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
										 } 
										 else if (data == 'updated')
										 {
											 $('#user_create_form').trigger('reset');
											 $('#user_create_modal').modal('hide');
											 window.location.href="/layout/items/user_list.php";
										 };
									 }
							});
						} 
						else 
						{
							$('#user_form_msg').html('<h4 style=color:red;>Telephone cannot be EMPTY!</h4>');
							$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#user_form_msg').html('<h4 style=color:red;>User Type cannot be EMPTY!</h4>');
						$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
					};
				} 
				else 
				{
					$('#user_form_msg').html('<h4 style=color:red;>First Name cannot be EMPTY!</h4>');
					$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
				};
			} 
			else 
			{
				$('#user_form_msg').html('<h4 style=color:red;>Email cannot be EMPTY!</h4>');
				$('#user_form_msg').hide().slideDown().delay(2000).fadeOut();
			};
		});
	}

	function user_change_user_type()
	{
		$(document).on('change','#user_type',function()
		{
			var user_type_id = $('#user_type').val();
			$.ajax({
				url:'/layout/items/user_change_user_type.php',
				method:'POST',
				data:{
					 user_type_id:user_type_id
				 },
				success:function(data)
				{
					$('#user_privileges_div').html(data);
				}
			});	
		});
	}

	function add_user_cash_ledger_row()
	{
		$(document).on('change','.user_cash_ledger_id',function(){ 
			var i = $('#user_cash_ledger_list_table tr:last').attr('id');
			i++;
			$.ajax({
				url:'/layout/items/user_cash_ledger_list.php',
				method:'POST',
				data:{i:i},
				success:function(data)
				{
					$('#user_cash_ledger_list_table').append('<tr id="'+i+'">'+data+'</tr>');
				}
			});
		});
	}

	function delete_user_cash_ledger_row()
	{
		$(document).on('click', '#delete_user_cash_ledger', function()
		{
			   var button_id = $(this).attr("data-id");
			   $('#'+button_id+'').remove();
		   });
	}

	function user_change_branch()
	{
		$(document).on('change','.user_change_branch',function(){
			var user_id = $(this).attr('data-id');
			var branch_id = $('#user_change_branch'+user_id).val();
			$.ajax({
				url:'/layout/items/user_change_branch.php',
				type:'POST',  
				data:{user_id:user_id, branch_id:branch_id},
				success:function()
				{
					window.location.href="/layout/items/user_list.php";
				}
			});
		}); 
	}

//USERS-ADMIN
	function user_admin_new_sheet()
	{
		$(document).on('click','#u',function(e)
		{
			$('#user_create_modal_header').html('User Setup');
			$('#user_create_form').trigger('reset');
			$('#user_update_btn').hide();
			$('#user_save_btn').show();
			$('#user_create_modal').modal('show');
		}) 
	}

	function user_admin_save()
	{
		$(document).on('click','#user_admin_save_btn',function(e){
			e.preventDefault();
			var name = $('#user_admin_name').val();
			var email = $('#user_admin_email').val();
			var password = $('#user_admin_password').val();
			var password_confirm = $('#user_admin_password_confirm').val();
			var telephone = $('#user_admin_telephone').val();
			if (name != '') 
			{
				if (email != '') 
				{
					/*if (isEmail(email)) 
					{*/
						if (password != '') 
						{
							if (password_confirm != '') 
							{
								if (telephone != '') 
								{
									if (password == password_confirm) 
									{
										$.ajax({
											url:'/layout/items/user_admin_save.php',
											method:'POST',
											data:$('#user_admin_create_form').serialize(),
											success:function(data)
											{
												if (data == 'exist')
												{
													$('#user_admin_form_msg').html('<h4 style=color:red;>Email NOT available!</h4>');
													$('#user_admin_form_msg').hide().slideDown().delay(2000).fadeOut();
												}
												else if (data == 'inserted')
												{
													$('#user_admin_create_form').trigger('reset');
													$('#user_admin_form_msg').html('<h4 style=color:red;>User created successfully!</h4>');
													$('#user_admin_form_msg').hide().slideDown().delay(2000).fadeOut();
													 window.location.href="/layout/items/company_list.php";
													 //window.location.href="/layout/items/user_super_welcome.php";
												};
											}
										});
									}
									else
									{
										$('#user_admin_form_msg').html('<h4 style=color:red;>Password does NOT match!</h4>');
										$('#user_admin_form_msg').hide().slideDown().delay(2000).fadeOut();
									};
								} 
								else 
								{
									$('#user_admin_form_msg').html('<h4 style=color:red;>Telephone cannot be EMPTY!</h4>');
									$('#user_admin_form_msg').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#user_admin_form_msg').html('<h4 style=color:red;>Password Confirm cannot be EMPTY!</h4>');
								$('#user_admin_form_msg').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#user_admin_form_msg').html('<h4 style=color:red;>Password cannot be EMPTY!</h4>');
							$('#user_admin_form_msg').hide().slideDown().delay(2000).fadeOut();
						};
					/*} 
					else 
					{
						$('#user_admin_form_msg').html('<h4 style=color:red;>Email is not a valid address!</h4>');
						$('#user_admin_form_msg').hide().slideDown().delay(2000).fadeOut();
					};*/
				} 
				else 
				{
					$('#user_admin_form_msg').html('<h4 style=color:red;>Email cannot be EMPTY!</h4>');
					$('#user_admin_form_msg').hide().slideDown().delay(2000).fadeOut();
				};
			} 
			else 
			{
				$('#user_admin_form_msg').html('<h4 style=color:red;>Name cannot be EMPTY!</h4>');
				$('#user_admin_form_msg').hide().slideDown().delay(2000).fadeOut();
			};
				
		});
	}

	function user_admin_edit()
	{
		$(document).on('click','#btn_edit_user_admin',function()
		{
			var user_id = $(this).attr('data-id');
			$.ajax({  
					 url:'/layout/items/user_admin_edit.php',  
					 method:'POST',  
					 data:{
						 user_id:user_id
					 },
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#company_id').val(res[0]);
						 $('#user_id').val(res[1]);
						 $('#username').val(res[2]);
						 $('#password').val(res[3]);
						 $('#email').val(res[4]);
						 $('#telephone').val(res[5]);
						 $('#address').val(res[6]);
						 $('#location').val(res[7]);
						 $('#photo').val(res[8]);
						 $('#full_name').val(res[9]);
						 $('#user_create_modal_header').html('User Edit');
						$('#user_update_btn').show();
						$('#user_save_btn').hide();
						 $('#user_create_modal').modal('show');
					 }  
				});
		});
	}

	function user_admin_update()
	{
		$(document).on('click','#user_admin_update_btn',function(e){
			e.preventDefault();
				$.ajax({
					 url:'/layout/items/user_admin_update.php',
					 method:'POST',
					 data:$('#user_create_form').serialize(),
					 success:function(data)
						 {
							 $('#user_create_form').trigger('reset');
							 $('#user_create_modal').modal('hide');
							 window.location.href="/layout/items/user_admin_list.php";
						 }
				});	
		});
	}
