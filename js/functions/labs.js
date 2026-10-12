$(document).ready(function()
{
	//LABS
		lab_modal();
		save_lab();
		lab_edit();
		update_lab();
		delete_lab();
		lab_param_modal();
		add_lab_param_modal();
		lab_param_save();
		lab_param_cancel_modal();
		update_lab_param();
		lab_param_edit_modal();
		lab_param_delete();
		search_lab();
		add_lab_param_dropdown_modal();
		save_lab_param_dropdown_modal();
		cancel_lab_param_dropdown_modal();
		lab_param_dropdown_edit_modal();
		update_lab_param_dropdown();
		composite_lab_modal();
		composite_lab_save();
		composite_lab_edit();
		composite_lab_update();
		composite_lab_delete();
		composite_lab_list_modal();
		composite_lab_list_save();
		composite_lab_list_edit();
		composite_lab_list_update();
		composite_lab_list_delete();
});

	//SETUP LABS
	function lab_modal()
	{
		$(document).on('click','#new_lab_icon',function()
		{
			$('#labmodaltitle').html('Enter Lab Test');
			$('#lab_update_btn').hide();
			$('#lab_save_btn').show();
			$('form').trigger('reset');
			$('#labcreatemodal').modal('show');
		}) 
	}

	function save_lab()
	{
		$(document).on('click','#lab_save_btn',function(){
			var labdesc = $('#labdesc').val();
			var nhisitem = $('#nhisitem').val();
			var price_cash = $('#price_cash').val();
			var price_nhis = $('#price_nhis').val();
			var price_nhis_topup = $('#price_nhis_topup').val();
			var price_private = $('#price_private').val();
			var price_private_topup = $('#price_private_topup').val();
			if (labdesc !=="") 
			{
				$.ajax({
					 url:'/layout/items/lab_save.php',
					 method:'POST',
					 data:{
						 labdesc:labdesc,
						 nhisitem:nhisitem,
						 price_cash:price_cash,
						 price_nhis:price_nhis,
						 price_nhis_topup:price_nhis_topup,
						 price_private:price_private,
						 price_private_topup:price_private_topup
					 },
					 success:function(data)
						 {
							 $('form').trigger('reset');
							 window.location.href="/layout/items/lab_list.php";
						 }
					 });
			} 
			else 
			{
				alert('Please the Lab Test Description cannot be EMPTY!');
			};
				
		});
	}

	function lab_edit()
	{
		$(document).on('click','#btn_edit_lab',function()
		{
			var lab_id = $(this).attr('data-id1');
			$.ajax(
			{
				url: '/layout/items/lab_edit.php',
				method: 'POST',
				data: {lab_id:lab_id},
				datatype: 'JSON',
				success: function(data)
				{
					var res = $.parseJSON(data);
					$.ajax(
					{
						url: '/layout/items/lab_param_get_data.php',
						method: 'POST',
						data: {lab_id:lab_id},
						success: function(data)
						{
							$('#lab_param_table').html(data);
						}
					})
					$('#lab_edit_modal_header').html('Update Lab Test Parameters');
					$('#lab_edit_form_footer').show();
					$('#lab_save_btn_up').hide();
					$('#labdesc_up').val(res[2]);
					$('#nhisitem_up').val(res[1]).change();
					$('#lab_gdrg_up').val(res[8]);
					$('#price_cash_up').val(res[3]);
					$('#price_nhis_up').val(res[5]);
					$('#price_nhis_topup_up').val(res[7]);
					$('#price_private_up').val(res[4]);
					$('#price_private_topup_up').val(res[6]);
					$('#lab_id_up').val(res[0]);

					$('#labdesc_up').prop( "disabled", false );
					$('#nhisitem_up').prop( "disabled", false );
					$('#lab_gdrg_up').prop( "disabled", false );
					$('#price_cash_up').prop( "disabled", false );
					$('#price_nhis_up').prop( "disabled", false );
					$('#price_nhis_topup_up').prop( "disabled", false );
					$('#price_private_up').prop( "disabled", false );
					$('#price_private_topup_up').prop( "disabled", false );
					$('#labeditmodal').modal('show');
				}
			})
		}) 
	}

	function update_lab()
	{
		$(document).on('click','#lab_update_btn_up',function(){
			var lab_id = $('#lab_id_up').val();
			var labdesc = $('#labdesc_up').val();
			var nhisitem = $('#nhisitem_up').val();
			var price_cash = $('#price_cash_up').val();
			var price_nhis = $('#price_nhis_up').val();``
			var price_nhis_topup = $('#price_nhis_topup_up').val();
			var price_private = $('#price_private_up').val();
			var price_private_topup = $('#price_private_topup_up').val();
			var gdrg = $('#gdrg_up').val();
			if (labdesc !=="") 
			{
				$.ajax({
					 url:'/layout/items/lab_update.php',
					 method:'POST',
					 data:{
						 lab_id:lab_id,
						 labdesc:labdesc,
						 nhisitem:nhisitem,
						 price_cash:price_cash,
						 price_nhis:price_nhis,
						 price_nhis_topup:price_nhis_topup,
						 price_private:price_private,
						 price_private_topup:price_private_topup,
						 gdrg:gdrg
					 },
					 success:function(data)
						 {
							 $('form').trigger('reset');
							 window.location.href="/layout/items/lab_list.php";
						 }
					 });
			} 
			else 
			{
				alert('Please the Lab Test Description cannot be EMPTY!');
			};
		});
	}

	function delete_lab()
	{
		$(document).on('click','#btn_delete_lab',function(){
			var lab_id = $(this).attr('data-id2');
			var lab = $(this).attr('data-id1');
			//var currentRow=$(this).closest("tr");
			//var lab = currentRow.find("td:eq(0)").text();
			$('#lab_delete_question').text('Are you sure you want to delete ' + lab + '?');
			$('#labdeletemodal').modal('show');
			$(document).on('click','#lab_delete_yes',function(){
				$.ajax({  
					url:'/layout/items/lab_delete.php',  
					type:'POST',  
					data:{lab_id:lab_id},
					success:function(data)
					{
						$('#labdeletemodal').modal('hide');
						if(data == 'deleted')
						 {
							window.location.href="/layout/items/lab_list.php";
						}
						else if(data == 'used')
						{
							alert('Please, '+ lab +' has been used in some attendance sheet, deletion is therefore declined')
						};
					}  
				});
			  });
			$(document).on('click','#lab_delete_no',function()
			{
				$('#labdeletemodal').modal('hide');
			});
		});
	}

	function lab_param_modal()
	{
		$(document).on('click','#btn_lab_param',function()
		{
			var lab_id = $(this).attr('data-id');
			$.ajax(
			{
				url: '/layout/items/lab_edit.php',
				method: 'POST',
				data: {lab_id:lab_id},
				datatype: 'JSON',
				success: function(data)
				{
					var res = $.parseJSON(data);
					$.ajax(
					{
						url: '/layout/items/lab_param_get_data.php',
						method: 'POST',
						data: {lab_id:lab_id},
						success: function(data)
						{
							$('#lab_param_table').html(data);
						}
					})
					$('#lab_edit_modal_header').html('Update Lab Test Parameters');
					$('#lab_edit_form_footer').hide();
					$('#labdesc_up').val(res[2]);
					$('#nhisitem_up').val(res[1]).change();
					$('#lab_gdrg_up').val(res[8]);
					$('#price_cash_up').val(res[3]);
					$('#price_nhis_up').val(res[5]);
					$('#price_nhis_topup_up').val(res[7]);
					$('#price_private_up').val(res[4]);
					$('#price_private_topup_up').val(res[6]);
					$('#lab_id_up').val(res[0]);

					$('#labdesc_up').prop( "disabled", true );
					$('#nhisitem_up').prop( "disabled", true );
					$('#lab_gdrg_up').prop( "disabled", true );
					$('#price_cash_up').prop( "disabled", true );
					$('#price_nhis_up').prop( "disabled", true );
					$('#price_nhis_topup_up').prop( "disabled", true );
					$('#price_private_up').prop( "disabled", true );
					$('#price_private_topup_up').prop( "disabled", true );
					$('#labeditmodal').modal('show');
				}
			})
		}) 
	}

	function add_lab_param_modal()
	{
		$(document).on('click','#add_lab_param_icon',function()
		{
			var lab_id = $('#lab_id_up').val();
			$('#lab_param_lab_id').val(lab_id);
			$('#lab_param_save_btn').show();
			$('#lab_param_add_form').trigger('reset');
			$('#labparamaddmodal').modal('show');
		});
	}

	function lab_param_save()
	{
		$(document).on('click','#lab_param_save_btn',function(){
			var lab_id = $('#lab_param_lab_id').val();
			var lab_param = $('#lab_param').val();
			var lab_param_low_range = $('#lab_param_low_range').val();
			var lab_param_high_range = $('#lab_param_high_range').val();
			var lab_param_unit = $('#lab_param_unit').val();
			var lab_param_comment = $('#lab_param_comment').val();
			$.ajax({  
				 url:'/layout/items/lab_param_save.php',  
				 method:'POST',  
				 data:{
					 lab_id:lab_id, 
					 lab_param:lab_param, 
					 lab_param_low_range:lab_param_low_range, 
					 lab_param_high_range:lab_param_high_range, 
					 lab_param_unit:lab_param_unit,
					 lab_param_comment:lab_param_comment
				 },
				 success:function(data){
					 $('#lab_param_add_form').trigger('reset');
					 $('#labparamaddmodal').modal('hide');
					 $('#lab_param_table').html(data);
				 }  
			});
		});
	}

	function lab_param_cancel_modal()
	{
		$(document).on('click','#lab_param_cancel_btn',function(){
				//$('form').trigger('reset');
				$('#labparamaddmodal').modal('hide');
			});
	}

	function lab_param_delete()
	{
		$(document).on('click','#btn_lab_param_delete',function(){
			var lab_param_id = $(this).attr('data-id1');
			var lab_id = $(this).attr('data-id2');
			var currentRow=$(this).closest("tr");
			var lab_param = currentRow.find("td:eq(0)").text();
			$('#lab_param_delete_question').text('Are you sure you want to delete ' + lab_param + '?');
			$('#labparamdeletemodal').modal('show');
				$(document).on('click','#lab_param_delete_yes',function(){
					$.ajax({  
						 url:'/layout/items/lab_param_delete.php',  
						 method:'POST',  
						 data:{
							 lab_id:lab_id,
							 lab_param_id:lab_param_id
						 },
						 success:function(data){
							 $('#lab_param_table').html(data);
							 $('#labparamdeletemodal').modal('hide');
						 }  
						});
				});
				$(document).on('click','#lab_param_delete_no',function(){
					$('#labparamdeletemodal').modal('hide');
				});
		});
	}

	function lab_param_edit_modal()
	{
		$(document).on('click','#btn_lab_param_edit',function()
		{
			var lab_param_id = $(this).attr('data-id');
			$.ajax(
			{
				url: '/layout/items/lab_param_edit.php',
				method: 'POST',
				data: {lab_param_id:lab_param_id},
				datatype: 'JSON',
				success: function(data)
				{
					var res = $.parseJSON(data);
					$.ajax(
					{
						url: '/layout/items/lab_param_dropdown_get_data.php',
						method: 'POST',
						data: {lab_param_id:lab_param_id},
						success: function(data)
						{
							$('#lab_param_dropdown_table').html(data);
						}
					})
					$('#lab_param_edit_modal_header').html('Update Lab Test Parameters');
					$('#lab_param_id_up').val(res[0]);
					$('#lab_param_lab_id_up').val(res[1])
					$('#lab_param_up').val(res[2]);
					$('#lab_param_low_range_up').val(res[3]);
					$('#lab_param_high_range_up').val(res[4]);
					$('#lab_param_comment_up').val(res[5]);
					$('#lab_param_unit_up').val(res[6]);
					$('#labparameditmodal').modal('show');
				}
			})
		}) 
	}

	function update_lab_param()
	{
		$(document).on('click','#lab_param_update_btn_up',function(){
			var lab_param_id = $('#lab_param_id_up').val();
			var lab_param = $('#lab_param_up').val();
			var lab_param_low_range = $('#lab_param_low_range_up').val();
			var lab_param_high_range = $('#lab_param_high_range_up').val();
			var lab_param_unit = $('#lab_param_unit_up').val();
			var lab_param_comment = $('#lab_param_comment_up').val();
			$.ajax({
				 url:'/layout/items/lab_param_update.php',
				 method:'POST',
				 data:{
					 lab_param_id:lab_param_id,
					 lab_param:lab_param,
					 lab_param_low_range:lab_param_low_range,
					 lab_param_high_range:lab_param_high_range,
					 lab_param_unit:lab_param_unit,
					 lab_param_comment:lab_param_comment
				 },
				 success:function(data)
					 {
						 $('#labparameditmodal').modal('hide');
					 }
				 });
		});
	}

	function search_lab()
	{
		$(document).on('keyup','#search_lab',function()
		{
			var search = $(this).val();
			
			if(search != '')
			{
				  $.ajax({
					url:"/layout/items/lab_search.php",
					method:"POST",
					data:{search:search},
					success:function(data)
					{
						$('#lab_item_table').html(data);
					}
				});
			}
		}); 
	}

	function add_lab_param_dropdown_modal()
	{
		$(document).on('click','#add_lab_param_dropdown_icon',function()
		{
			$('#lab_param_dropdown_add_form').trigger('reset');
			$('#labparamdropdownaddmodal').modal('show');
		}) 
	}

	function save_lab_param_dropdown_modal()
	{
		$(document).on('click','#lab_param_save_btn_dd',function(){
			var lab_param_id = $('#lab_param_id_up').val();
			var lab_param_dd = $('#lab_param_dropdown').val();
			$.ajax({  
				 url:'/layout/items/lab_param_dropdown_save.php',  
				 method:'POST',  
				 data:{
					 lab_param_id:lab_param_id, 
					 lab_param_dd:lab_param_dd
				 },
				 success:function(data){
					 $('#lab_param_dropdown_add_form').trigger('reset');
					 $('#labparamdropdownaddmodal').modal('hide');
				 }  
			});
		  });
	}

	function cancel_lab_param_dropdown_modal()
	{
		$(document).on('click','#lab_param_cancel_btn_dd',function(){
				$('#lab_param_dropdown_add_form').trigger('reset');
				$('#labparamdropdownaddmodal').modal('hide');
			});
	}

	function lab_param_dropdown_edit_modal()
	{
		$(document).on('click','#btn_lab_param_dropdown_edit',function()
		{
			var lab_param_dd_id = $(this).attr('data-id');
			$.ajax(
			{
				url: '/layout/items/lab_param_dropdown_edit.php',
				method: 'POST',
				data: {lab_param_dd_id:lab_param_dd_id},
				datatype: 'JSON',
				success: function(data)
				{
					var res = $.parseJSON(data);
					$('#lab_param_dropdown_edit_modal_header').html('Update Lab Test Parameter Dropdown');
					$('#lab_param_dd_id_up').val(res[0]);
					$('#lab_param_dropdown_up').val(res[1])
					$('#labparamdropdowneditmodal').modal('show');
				}
			})
		}) 
	}

	function update_lab_param_dropdown()
	{
		$(document).on('click','#lab_param_update_btn_dd',function()
		{
			var lab_param_dd_id = $('#lab_param_dd_id_up').val();
			var lab_param_dd = $('#lab_param_dropdown_up').val();
				$.ajax({  
					 url:'/layout/items/lab_param_dropdown_update.php',  
					 method:'POST',  
					 data:{
						 lab_param_dd_id:lab_param_dd_id, 
						 lab_param_dd:lab_param_dd
					 },

					 success:function(data){
						 $('#lab_param_dropdown_edit_form').trigger('reset');
						 $('#labparamdropdowneditmodal').modal('hide');
					 }  
				});
		}) 
	}

	function composite_lab_modal()
	{
		$(document).on('click','#new_composite_lab_icon',function()
		{
			$('#composite_lab_create_modal_header').html('Composite Lab Setup');
			$('#composite_lab_update_btn').hide();
			$('#composite_lab_save_btn').show();
			$('#composite_lab_create_form').trigger('reset');
			$('#composite_lab_create_modal').modal('show');
		});
	}

	function composite_lab_save()
	{
		$(document).on('click','#composite_lab_save_btn',function(){
			var composite_lab_id = $('#composite_lab_id').val();
			var composite_lab = $('#composite_lab').val();
			var composite_lab_price = $('#composite_lab_price').val();
			if (composite_lab !="") 
			{
				$.ajax({
					 url:'/layout/items/composite_lab_save.php',
					 method:'POST',
					 data:{
						composite_lab_id:composite_lab_id,
						composite_lab:composite_lab,
						composite_lab_price:composite_lab_price
					 },
					 success:function(data)
						 {
							 $('composite_lab_create_form').trigger('reset');
							 window.location.href="/layout/items/composite_lab_list.php";
						 }
					 });
			} 
			else 
			{
				alert('Please the Composite Lab Description cannot be EMPTY!');
			};
				
		});
	}

	function composite_lab_edit()
	{
		$(document).on('click','#btn_edit_composite_lab',function()
		{
			var composite_lab_id = $(this).attr('data-id');
			$.ajax(
			{
				url: '/layout/items/composite_lab_edit.php',
				method: 'POST',
				data: {composite_lab_id:composite_lab_id},
				datatype: 'JSON',
				success: function(data)
				{
					var res = $.parseJSON(data);
					$('#composite_lab_save_btn').hide();
					$('#composite_lab_update_btn').show();
					$('#composite_lab_id').val(res[0]);
					$('#composite_lab').val(res[1]);
					$('#composite_lab_price').val(res[2]);
					$('#composite_lab_create_modal').modal('show');
				}
			})
		}) 
	}

	function composite_lab_update()
	{
		$(document).on('click','#composite_lab_update_btn',function(){
			var composite_lab_id = $('#composite_lab_id').val();
			var composite_lab = $('#composite_lab').val();
			var composite_lab_price = $('#composite_lab_price').val();
			if (composite_lab !="") 
			{
				$.ajax({
					 url:'/layout/items/composite_lab_update.php',
					 method:'POST',
					 data:{
						composite_lab_id:composite_lab_id,
						composite_lab:composite_lab,
						composite_lab_price:composite_lab_price
					 },
					 success:function(data)
						 {
							 $('composite_lab_create_form').trigger('reset');
							 window.location.href="/layout/items/composite_lab_list.php";
						 }
					 });
			} 
			else 
			{
				alert('Please the Composite Lab Description cannot be EMPTY!');
			};
				
		});
	}

	function composite_lab_delete()
	{
		$(document).on('click','#btn_delete_composite_lab',function(){
			var composite_lab_id = $(this).attr('data-id');
			var currentRow = $(this).closest("tr");
			var test = currentRow.find("td:eq(0)").text();
			$('#item_delete_modal_title').text('Composite Lab Deletion!');
			$('#item_delete_question').text('Are you sure you want to delete Composite Lab: ' + test + '?');
			$('#item_delete_modal').modal('show');
			$(document).on('click','#item_delete_yes',function(){
				$.ajax({
					url:'/layout/items/composite_lab_delete.php',
					method:'POST',
					data:{
						composite_lab_id:composite_lab_id
					},
					success:function(data)
					{
						$('#item_delete_modal').modal('hide');
						window.location.href="/layout/items/composite_lab_list.php";
					}
				});
			});
			$(document).on('click','#item_delete_no',function(){
				$('#item_delete_modal').modal('hide');
			});
		});
	}

	function composite_lab_list_modal()
	{
		$(document).on('click','#btn_add_composite_lab_list',function()
		{
			var composite_lab_id = $(this).attr('data-id');
			$('#composite_lab_list_create_modal_header').html('Composite Lab List Setup');
			$('#composite_lab_list_update_btn').hide();
			$('#composite_lab_list_save_btn').show();
			$('#composite_lab_list_create_form').trigger('reset');
			$('#cll_composite_lab_id').val(composite_lab_id);
			$('#composite_lab_list_create_modal').modal('show');
		});
	}

	function composite_lab_list_save()
	{
		$(document).on('click','#composite_lab_list_save_btn',function(){
			var composite_lab_id = $('#cll_composite_lab_id').val();
			var composite_lab_list_id = $('#composite_lab_list_id').val();
			var composite_lab_list_lab_id = $('#composite_lab_list_lab_id').val();
			if (composite_lab_list_lab_id !="" && composite_lab_list_lab_id > 0) 
			{
				$.ajax({
					 url:'/layout/items/composite_lab_list_save.php',
					 method:'POST',
					 data:{
						composite_lab_id:composite_lab_id,
						composite_lab_list_id:composite_lab_list_id,
						composite_lab_list_lab_id:composite_lab_list_lab_id,
					},
					 success:function(data)
						 {
							 $('composite_lab_list_create_form').trigger('reset');
							 $('#composite_lab_list_create_modal').modal('hide');
							 window.location.href="/layout/items/composite_lab_list.php";
						 }
					 });
			} 
			else 
			{
				alert('Please the Lab Test cannot be EMPTY!');
			};
				
		});
	}

	function composite_lab_list_edit()
	{
		$(document).on('click','#btn_edit_composite_lab_list',function()
		{
			var composite_lab_list_id = $(this).attr('data-id');
			$.ajax(
			{
				url: '/layout/items/composite_lab_list_edit.php',
				method: 'POST',
				data: {composite_lab_list_id:composite_lab_list_id},
				datatype: 'JSON',
				success: function(data)
				{
					var res = $.parseJSON(data);
					$('#composite_lab_list_save_btn').hide();
					$('#composite_lab_list_update_btn').show();
					$('#composite_lab_list_id').val(res[0]);
					$('#cll_composite_lab_id').val(res[1]);
					$('#composite_lab_list_lab_id').val(res[2]);
					$('#composite_lab_list_create_modal').modal('show');
				}
			});
		});
	}

	function composite_lab_list_update()
	{
		$(document).on('click','#composite_lab_list_update_btn',function(){
			var composite_lab_id = $('#cll_composite_lab_id').val();
			var composite_lab_list_id = $('#composite_lab_list_id').val();
			var composite_lab_list_lab_id = $('#composite_lab_list_lab_id').val();
			if (composite_lab_list_lab_id !="" && composite_lab_list_lab_id > 0) 
			{
				$.ajax({
					 url:'/layout/items/composite_lab_list_update.php',
					 method:'POST',
					 data:{
						composite_lab_id:composite_lab_id,
						composite_lab_list_id:composite_lab_list_id,
						composite_lab_list_lab_id:composite_lab_list_lab_id,
					},
					 success:function(data)
						 {
							 $('composite_lab_list_create_form').trigger('reset');
							 $('#composite_lab_list_create_modal').modal('hide');
							 window.location.href="/layout/items/composite_lab_list.php";
						 }
					 });
			} 
			else 
			{
				alert('Please the Lab Test cannot be EMPTY!');
			};
				
		});
	}

	function composite_lab_list_delete()
	{
		$(document).on('click','#btn_delete_composite_lab_list',function(){
			var composite_lab_list_id = $(this).attr('data-id');
			var currentRow = $(this).closest("tr");
			var test = currentRow.find("td:eq(1)").text();
			$('#item_delete_modal_title').text('Composite Lab Deletion!');
			$('#item_delete_question').text('Are you sure you want to delete Composite Lab: ' + test + '?');
			$('#item_delete_modal').modal('show');
			$(document).on('click','#item_delete_yes',function(){
				$.ajax({
					url:'/layout/items/composite_lab_list_delete.php',
					method:'POST',
					data:{
						composite_lab_list_id:composite_lab_list_id
					},
					success:function(data)
					{
						$('#item_delete_modal').modal('hide');
						window.location.href="/layout/items/composite_lab_list.php";
					}
				});
			});
			$(document).on('click','#item_delete_no',function(){
				$('#item_delete_modal').modal('hide');
			});
		});
	}
