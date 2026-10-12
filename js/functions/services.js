$(document).ready(function()
{
	//SERVICES
		new_service_modal();
		save_service();
		edit_service();
		update_service();
		search_service();
		delete_service();
});

	//SETUP SERVICES
	function new_service_modal()
	{
		$(document).on('click','#new_service_icon',function()
		{
			$('#service_update_btn').hide();
			$('#service_save_btn').show();
			$('#service_create_form').trigger('reset');
			$('#service_create_modal').modal('show');
		});
	}

	function save_service()
	{
		$(document).on('click','#service_save_btn',function(){
			var service = $('#service').val();
			if (service !=="") 
			{
				$.ajax({
					 url:'/layout/items/service_save.php',
					 method:'POST',
					 data:$('#service_create_form').serialize(),
					 success:function(data){
						 $('#service_create_modal').modal('hide');
						 $('#service_create_form').trigger('reset');
						 $('#service_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Service Description cannot be EMPTY!');
			};
		});
	}

	function edit_service()
	{
		$(document).on('click','#btn_edit_service',function()
		{
			var service_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/items/service_edit.php',
				 method:'POST',
				 data:{service_id:service_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $('#service_id').val(res[0]);
					 $('#service').val(res[2]);
					 $('#nhisitem').val(res[1]);
					 $('#price_cash').val(res[3]);
					 $('#price_private').val(res[4]);
					 $('#service_update_btn').show();
					$('#service_save_btn').hide();
					$('#service_create_modal_header').html('Service Edit');
					$('#service_create_modal').modal('show');
				 }
			 });
		});
	}

	function update_service()
	{
		$(document).on('click','#service_update_btn',function(){
			var service = $('#service').val();
			if (service !=="") 
			{
				$.ajax({
					 url:'/layout/items/service_update.php',
					 method:'POST',
					 data:$('#service_create_form').serialize(),
					 success:function(data){
						 $('#service_create_modal').modal('hide');
						 $('#service_create_form').trigger('reset');
						 $('#service_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Service Description cannot be EMPTY!');
			};
		});
	}

	function search_service()
	{
		$(document).on('keyup','#search_service',function()
		{
			var search = $(this).val();
			
			  if(search != '')
			  {
				  $.ajax({
					url:"/layout/items/service_search.php",
					method:"POST",
					data:{search:search},
					success:function(data)
					{
						$('#service_list_table').html(data);
					}
				});
			}
		}); 
	}
			
	function delete_service()
	{
		$(document).on('click','#btn_delete_service',function()
		{
			var service_id = $(this).attr('data-id');
			var service = $(this).attr('data-id1');
			$('#item_delete_question').text('Are you sure you want to delete ' + service + '?');
			$('#item_delete_modal').modal('show');
			$(document).on('click','#item_delete_yes',function()
			{
				$.ajax({  
					url:'/layout/items/service_delete.php',  
					type:'POST',  
					data:{service_id:service_id},
					success:function(data)
					{
						$('#item_delete_modal').modal('hide');
						if(data == 'used')
						{
							alert('Please, '+ service +' has been used in an attendance sheet, deletion is therefore declined!')
						}
						else if(data == 'deleted')
						{
							window.location.href="/layout/items/service_list.php";
						};
					}
				});
			});
			$(document).on('click','#item_delete_no',function()
			{
				$('#item_delete_modal').modal('hide');
			});
		});
	}
