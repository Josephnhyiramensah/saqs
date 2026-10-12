$(document).ready(function()
{
	//BRANCH
		branch_new_modal();
		branch_save();
		branch_edit();
		branch_update();
});

//BRANCH
		function branch_new_modal()
		{
			$(document).on('click','#new_branch_icon',function()
			{
				$('#sms').val('No');
				$('#branch_create_modal_header').html('Branch Setup');
				$('#branch_create_form').trigger('reset');
				$('#branch_update_btn').hide();
				$('#branch_save_btn').show();
				$('#beanch_status').val('Active');
				$('#branch_create_modal').modal('show');
			}) 
		}

		function branch_save()
		{
			$(document).on('click','#branch_save_btn',function(e){
				var branch_name = $('#branch_name').val();
				e.preventDefault();
				if (branch_name !== "")
				{
					$.ajax({
						url:'/layout/items/branch_save.php',
						method:'POST',
						data:$('#branch_create_form').serialize(),
						success:function(data)
						{
							$('#branch_create_form').trigger('reset');
							$('#branch_create_modal').modal('hide');
							window.location.href="/layout/items/branch_list.php";
						}
					});	
				} 
				else 
				{
					$('#branch_create_form_msg').html('<h6 style=color:red;>Please the Branch Name cannot be EMPTY!</h6>');
					$('#branch_create_form_msg').hide().slideDown().delay(2000).fadeOut();
				};
			});
		}

		function branch_edit()
		{
			$(document).on('click','#btn_edit_branch',function()
			{
				var branch_id = $(this).attr('data-id');
				$.ajax({  
					url:'/layout/items/branch_edit.php',  
					method:'POST',  
					data:{
					branch_id:branch_id
					},
					datatype: 'JSON',
					success:function(data)
					{
						var res = $.parseJSON(data);
						$('#branch_id').val(res[0]);
						$('#branch_company_id').val(res[1]);
						$('#branch_name').val(res[2]);
						$('#branch_address').val(res[3]);
						$('#branch_location').val(res[4]);
						$('#branch_telephone').val(res[5]);
						$('#branch_email').val(res[6]);
						$('#branch_warehouse').val(res[7]);
						$('#branch_cash_ledger').val(res[8]);
						$('#branch_create_modal_header').html('Branch Edit');
						$('#branch_update_btn').show();
						$('#branch_save_btn').hide();
						$('#branch_create_modal').modal('show');
					}
				});
			});
		}

		function branch_update()
		{
			$(document).on('click','#branch_update_btn',function(e){
				var branch_name = $('#branch_name').val();
				e.preventDefault();
				if (branch_name !== "")
				{
					$.ajax({
						url:'/layout/items/branch_update.php',
						method:'POST',
						data:$('#branch_create_form').serialize(),
						success:function(data)
						{
							$('#branch_create_form').trigger('reset');
							$('#branch_create_modal').modal('hide');
							window.location.href="/layout/items/branch_list.php";
						}
					});	
				} 
				else 
				{
					$('#branch_create_form_msg').html('<h6 style=color:red;>Please the Branch Name cannot be EMPTY!</h6>');
					$('#branch_create_form_msg').hide().slideDown().delay(2000).fadeOut();
				};
			});
		}