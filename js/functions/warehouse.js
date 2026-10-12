$(document).ready(function()
{
	//WAREHOUSE
		new_warehouse_modal();
		save_new_warehouse();
		edit_warehouse();
		update_warehouse();
		delete_warehouse();
});

	//WAREHOUSE
	function new_warehouse_modal()
	{
		$(document).on('click','#new_warehouse_icon',function()
		{
			$('#warehouse_update_btn').hide();
			$('#warehouse_save_btn').show();
			$('#warehouse_cancel_btn').show();
			$('#warehouse_create_form').trigger('reset');
			$('#warehouse_create_modal').modal('show');
		});
	}

	function save_new_warehouse()
	{
		$(document).on('click','#warehouse_save_btn',function(){
			var warehouse_name = $('#warehouse_name').val();
			if (warehouse_name !=="") 
			{
				$.ajax({
					 url:'/layout/items/warehouse_save.php',
					 method:'POST',
					 data:$('#warehouse_create_form').serialize(),
					 success:function(data){
						 $('#warehouse_create_modal').modal('hide');
						 $('#warehouse_create_form').trigger('reset');
						 window.location.href="/layout/items/warehouse_list.php";
						 //$('#warehouse_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Warehouse Description cannot be EMPTY!');
			};
		});
	}

	function edit_warehouse()
	{
		$(document).on('click','#btn_edit_warehouse',function()
		{
			var warehouse_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/items/warehouse_edit.php',
				 method:'POST',
				 data:{warehouse_id:warehouse_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $('#warehouse_id').val(res[0]);
					 $('#warehouse_name').val(res[1]);
					 $('#warehouse_location').val(res[2]);
					 $('#warehouse_update_btn').show();
					$('#warehouse_save_btn').hide();
					$('#warehouse_create_modal_header').html('Warehouse Edit');
					$('#warehouse_create_modal').modal('show');
				 }
			 });
		});
	}

	function update_warehouse()
	{
		$(document).on('click','#warehouse_update_btn',function(){
			var warehouse_name = $('#warehouse_name').val();
			if (warehouse_name !=="") 
			{
				$.ajax({
					 url:'/layout/items/warehouse_update.php',
					 method:'POST',
					 data:$('#warehouse_create_form').serialize(),
					 success:function(data){
						 $('#warehouse_create_modal').modal('hide');
						 $('#warehouse_create_form').trigger('reset');
						 window.location.href="/layout/items/warehouse_list.php";
						 //$('#warehouse_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Warehouse Description cannot be EMPTY!');
			};
		});
	}
	
	function delete_warehouse()
	{
		$(document).on('click','#btn_delete_warehouse',function()
		{
			var warehouse_id = $(this).attr('data-id');
			var warehouse = $(this).attr('data-id1');
			$('#item_delete_question').text('Are you sure you want to delete ' + warehouse + '?');
			$('#item_delete_modal').modal('show');
			$(document).on('click','#item_delete_yes',function()
			{
				$.ajax({  
					url:'/layout/items/warehouse_delete.php',  
					type:'POST',  
					data:{warehouse_id:warehouse_id},
					success:function(data)
					{
						$('#item_delete_modal').modal('hide');
						if(data == 'used')
						{
							alert('Please, '+ warehouse +' has been used in an attendance sheet, deletion is therefore declined!')
						}
						else if(data == 'deleted')
						{
							window.location.href="/layout/items/warehouse_list.php";
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