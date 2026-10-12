$(document).ready(function()
{
	//RADIOLOGY
		new_radio_modal();
		save_radio();
		edit_radio();
		radio_nhis_code_price();
		update_radio();
		new_radio_param_modal();
		save_radio_param();
		cancel_radio_param_modal();
		edit_radio_param();
		update_radio_param();
		new_radio_param_dd_modal();
		cancel_radio_param_dd_modal();
		save_radio_param_dd();
		edit_radio_param_dd();
		update_radio_param_dd();
		search_radio();
		delete_radio();
});

	//SETUP RADIOLOGY
	function new_radio_modal()
	{
		$(document).on('click','#new_radio_icon',function()
		{
			$('#radio_update_btn').hide();
			$('#radio_param_table_div').hide();
			$('#radio_save_btn').show();
			$('#radio_form').trigger('reset');
			$('#radio_modal_header').html('Radiology Setup');
			$('#radio_modal').modal('show');
		});
	}

	function save_radio()
	{
		$(document).on('click','#radio_save_btn',function(){
			var radio = $('#radio').val();
			if (radio !=="") 
			{
				$.ajax({
					 url:'/layout/items/radio_save.php',
					 method:'POST',
					 data:$('#radio_form').serialize(),
					 success:function(data){
						 $('#radio_modal').modal('hide');
						 $('#radio_form').trigger('reset');
						 //$('#radio_list_table').html(data);
						 window.location.href="/layout/items/radio_list.php";
					 }
				 });
			} 
			else 
			{
				alert('Please the Radiology cannot be EMPTY!');
			};
		});
	}

	function edit_radio()
	{
		$(document).on('click','#btn_edit_radio',function()
		{
			var radio_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/items/radio_edit.php',
				 method:'POST',
				 data:{radio_id:radio_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $.ajax({
					 url:'/layout/items/radio_get_param_list.php',
					 method:'POST',
					 data:{radio_id:radio_id},
					 datatype: 'JSON',
					 success:function(data){
						 $('#radio_param_table').html(data);
						 }
					 });
					 $('#radio_id').val(res[0]);
					 $('#radio_type').val(res[2]);
					 $('#radio_nhis_id').val(res[3]);
					 $('#radio').val(res[1]);
					 $('#price').val(res[4]);
					 $('#price_private').val(res[5]);
					 $('#price_private_topup').val(res[6]);
					 $('#price_nhis_topup').val(res[7]);
					 $('#radio_update_btn').show();
					 $('#radio_param_table_div').show();
					$('#radio_save_btn').hide();
					$('#radio_modal_header').html('Radiology Edit');
					$('#radio_modal').modal('show');
				 }
			 });
		});
	}

	function update_radio()
	{
		$(document).on('click','#radio_update_btn',function(){
			var radio = $('#radio').val();
			if (radio !=="") 
			{
				$.ajax({
					 url:'/layout/items/radio_update.php',
					 method:'POST',
					 data:$('#radio_form').serialize(),
					 success:function(data){
						 $('#radio_modal').modal('hide');
						 $('#radio_form').trigger('reset');
						 //$('#radio_list_table').html(data);
						window.location.href="/layout/items/radio_list.php";
					 }
				 });
			} 
			else 
			{
				alert('Please the Radiology cannot be EMPTY!');
			};
		});
	}

	function radio_nhis_code_price()
	{
		$(document).on('change','#radio_nhis_id',function()
		{
			var nhis_id = $('#radio_nhis_id').val();
			$.ajax({
				 url:'/layout/items/radio_nhis_code_price.php',
				 method:'POST',
				 data:{nhis_id:nhis_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $('#radio_nhis_code').val(res[1]);
					 $('#radio_nhis_price').val(res[2]);
				 }
			 });
		});
	}

	function new_radio_param_modal()
	{
		$(document).on('click','#add_radio_param_icon',function()
		{
			var radio_id=$('#radio_id').val();
			$('#param_update_btn').hide();
			$('#radio_param_dd_table_div').hide();
			$('#param_radio_id').val(radio_id);
			$('#param_save_btn').show();
			$('#radio_param_form').trigger('reset');
			$('#radio_param_modal_header').html('Radiology Parameter Setup');
			$('#radio_modal').modal('hide');
			$('#radio_param_modal').modal('show');
		});
	}

	function save_radio_param()
	{
		$(document).on('click','#param_save_btn',function(){
			$.ajax({
				 url:'/layout/items/radio_param_save.php',
				 method:'POST',
				 data:$('#radio_param_form').serialize(),
				 success:function(data){
					 $('#radio_param_modal').modal('hide');
					 $('#radio_param_form').trigger('reset');
					 $('#radio_param_table').html(data);
					 $('#radio_modal').modal('show');
				 }
			 });
		});
	}

	function cancel_radio_param_modal()
	{
		$(document).on('click','#param_cancel_btn',function(){
			
					 $('#radio_param_modal').modal('hide');
					 $('#radio_param_form').trigger('reset');
					 $('#radio_modal').modal('show');
		});
	}

	function edit_radio_param()
	{
		$(document).on('click','#btn_edit_radio_param',function()
		{
			var radio_param_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/items/radio_param_edit.php',
				 method:'POST',
				 data:{radio_param_id:radio_param_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $.ajax({
					 url:'/layout/items/radio_get_param_dd_list.php',
					 method:'POST',
					 data:{radio_param_id:radio_param_id},
					 datatype: 'JSON',
					 success:function(data){
						 $('#radio_param_dd_table').html(data);
						 }
					 });
					 $('#radio_param_id').val(res[0]);
					 $('#radio_param').val(res[2]);
					 $('#comment').val(res[3]);
					 $('#param_radio_id').val(res[1]);
					 $('#radio_modal').modal('hide');
					 $('#param_update_btn').show();
					 $('#radio_param_dd_table_div').show();
					$('#param_save_btn').hide();
					$('#radio_param_modal_header').html('Radiology Parameter Edit');
					$('#radio_param_modal').modal('show');
				 }
			 });
		});
	}

	function update_radio_param()
	{
		$(document).on('click','#param_update_btn',function(){
			$.ajax({
				 url:'/layout/items/radio_param_update.php',
				 method:'POST',
				 data:$('#radio_param_form').serialize(),
				 success:function(data){
					 $('#radio_param_modal').modal('hide');
					 $('#radio_param_form').trigger('reset');
					 $('#radio_param_table').html(data);
					 $('#radio_modal').modal('show');
				 }
			 });
		});
	}

	function new_radio_param_dd_modal()
	{
		$(document).on('click','#add_radio_param_dd_icon',function()
		{
			var param_dd_param_id=$('#radio_param_id').val();
			var param_dd_radio_id=$('#radio_id').val();
			$('#param_dd_update_btn').hide();
			$('#param_dd_param_id').val(param_dd_param_id);
			$('#param_dd_radio_id').val(param_dd_radio_id);
			$('#param_dd_save_btn').show();
			$('#radio_param_dd_form').trigger('reset');
			$('#radio_param_dd_modal_header').html('Parameter Dropdown Setup');
			$('#radio_param_modal').modal('hide');
			$('#radio_param_dd_modal').modal('show');
		});
	}

	function cancel_radio_param_dd_modal()
	{
		$(document).on('click','#param_dd_cancel_btn',function(){
			
					 $('#radio_param_dd_modal').modal('hide');
					 $('#radio_param_dd_form').trigger('reset');
					 $('#radio_param_modal').modal('show');
		});
	}

	function save_radio_param_dd()
	{
		$(document).on('click','#param_dd_save_btn',function(){
			$.ajax({
				 url:'/layout/items/radio_param_save_dd.php',
				 method:'POST',
				 data:$('#radio_param_dd_form').serialize(),
				 success:function(data){
					 $('#radio_param_dd_modal').modal('hide');
					 $('#radio_param_dd_form').trigger('reset');
					 $('#radio_param_dd_table').html(data);
					 $('#radio_param_modal').modal('show');
				 }
			 });
		});
	}

	function edit_radio_param_dd()
	{
		$(document).on('click','#btn_edit_radio_param_dd',function()
		{
			var radio_param_dd_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/items/radio_param_dd_edit.php',
				 method:'POST',
				 data:{radio_param_dd_id:radio_param_dd_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $('#param_dd_id').val(res[0]);
					 $('#param_dd_param_id').val(res[1]);
					 $('#param_dd_radio_id').val(res[2]);
					 $('#param_dropdown').val(res[3]);
					 $('#radio_param_modal').modal('hide');
					 $('#param_dd_update_btn').show();
					$('#param_dd_save_btn').hide();
					$('#radio_param_dd_modal_header').html('Parameter Dropdown Edit');
					$('#radio_param_dd_modal').modal('show');
				 }
			 });
		});
	}

	function update_radio_param_dd()
	{
		$(document).on('click','#param_dd_update_btn',function(){
			$.ajax({
				 url:'/layout/items/radio_param_update_dd.php',
				 method:'POST',
				 data:$('#radio_param_dd_form').serialize(),
				 success:function(data){
					 $('#radio_param_dd_modal').modal('hide');
					 $('#radio_param_dd_form').trigger('reset');
					 $('#radio_param_dd_table').html(data);
					 $('#radio_param_modal').modal('show');
				 }
			 });
		});
	}

	function search_radio()
	{
		$(document).on('keyup','#search_radiology',function()
		{
			var search = $(this).val();
			
			if(search != '')
			{
				  $.ajax({
					url:"/layout/items/radio_search.php",
					method:"POST",
					data:{search:search},
					success:function(data)
					{
						$('#radio_list_table').html(data);
					}
				});
			};
		}); 
	}
			
	function delete_radio()
	{
		$(document).on('click','#btn_delete_radio',function()
		{
			var radio_id = $(this).attr('data-id');
			var radiology = $(this).attr('data-id1');
			$('#item_delete_question').text('Are you sure you want to delete ' + radiology + '?');
			$('#item_delete_modal').modal('show');
			$(document).on('click','#item_delete_yes',function()
			{
				$.ajax({  
					url:'/layout/items/radio_delete.php',  
					type:'POST',  
					data:{radio_id:radio_id},
					success:function(data)
					{
						$('#item_delete_modal').modal('hide');
						if(data == 'used')
						{
							alert('Please, '+ radiology +' has been used in an attendance sheet, deletion is therefore declined!')
						}
						else if(data == 'deleted')
						{
							window.location.href="/layout/items/radio_list.php";
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
