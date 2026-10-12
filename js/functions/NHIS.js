$(document).ready(function()
{
	//NHIS ITEMS
		new_nhis_item_modal();
		save_nhis_item();
		edit_nhis_item();
		update_nhis_item();
		new_nhis_scheme_modal();
		save_nhis_scheme();
		edit_nhis_scheme();
		update_nhis_scheme();
		search_nhis_item();
});

	//SETUP NHIS ITEM
	function new_nhis_item_modal()
	{
		$(document).on('click','#new_nhis_icon',function()
		{
			$('#nhisupdatebtn').hide();
			$('#nhissavebtn').show();
			$('#nhis_create_form').trigger('reset');
			$('#nhiscreatemodal').modal('show');
		});
	}

	function save_nhis_item()
	{
		$(document).on('click','#nhissavebtn',function(){
			var nhisdesc = $('#nhisdesc').val();
			if (nhisdesc !=="") 
			{
				$.ajax({
				 url:'/layout/items/nhis_save.php',
				 method:'POST',
				 data:$('#nhis_create_form').serialize(),
				 success:function(data){
					 $('#nhiscreatemodal').modal('hide');
					 $('#nhis_create_form').trigger('reset');
					 $('#nhis_list_table').html(data);
				 }
				 });
			} 
			else 
			{
				alert('Please the Description cannot be EMPTY!');
			};
		});
	}

	function edit_nhis_item()
	{
		$(document).on('click','#btn_edit_nhis',function()
		{
			var nhis_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/items/nhis_edit.php',
				 method:'POST',
				 data:{nhis_id:nhis_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $('#nhis_id').val(res[0]);
					 $('#category').val(res[1]);
					 $('#nhisdesc').val(res[2]);
					 $('#price').val(res[3]);
					 $('#price_adult').val(res[4]);
					 $('#price_child').val(res[5]);
					 $('#code').val(res[6]);
					 $('#gdrg_adult').val(res[7]);
					 $('#gdrg_child').val(res[8]);
					 $('#price_topup').val(res[9]);
					 $('#nhisupdatebtn').show();
					$('#nhissavebtn').hide();
					$('#nhiscreatemodal').modal('show');
				 }
			 });
		});
	}

	function update_nhis_item()
	{
		$(document).on('click','#nhisupdatebtn',function(){
			var nhisdesc = $('#nhisdesc').val();
			if (nhisdesc !=="") 
			{
				$.ajax({
					 url:'/layout/items/nhis_update.php',
					 method:'POST',
					 data:$('#nhis_create_form').serialize(),
					 success:function(data){
						 $('#nhiscreatemodal').modal('hide');
						 $('#nhis_create_form').trigger('reset');
						 $('#nhis_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Description cannot be EMPTY!');
			};
		});
	}

	function new_nhis_scheme_modal()
	{
		$(document).on('click','#new_nhis_scheme_icon',function()
		{
			$('#nhis_scheme_update_btn').hide();
			$('#nhis_scheme_save_btn').show();
			$('#nhis_scheme_create_form').trigger('reset');
			$('#nhis_scheme_create_modal').modal('show');
		});
	}

	function save_nhis_scheme()
	{
		$(document).on('click','#nhis_scheme_save_btn',function(){
			var scheme_name = $('#scheme_name').val();
			if (scheme_name !=="") 
			{
				$.ajax({
					 url:'/layout/items/nhis_scheme_save.php',
					 method:'POST',
					 data:$('#nhis_scheme_create_form').serialize(),
					 success:function(data){
						 $('#nhis_scheme_create_modal').modal('hide');
						 $('#nhis_scheme_create_form').trigger('reset');
						 $('#nhis_scheme_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Scheme Name cannot be EMPTY!');
			};
		});
	}

	function edit_nhis_scheme()
	{
		$(document).on('click','#btn_edit_nhis_scheme',function()
		{
			var scheme_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/items/nhis_scheme_edit.php',
				 method:'POST',
				 data:{scheme_id:scheme_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $('#scheme_id').val(res[0]);
					 $('#scheme_name').val(res[1]);
					 $('#regional_code').val(res[2]);
					 $('#scheme_code').val(res[3]);
					 $('#nhis_scheme_update_btn').show();
					$('#nhis_scheme_save_btn').hide();
					$('#nhis_scheme_create_modal').modal('show');
				 }
			 });
		});
	}

	function update_nhis_scheme()
	{
		$(document).on('click','#nhis_scheme_update_btn',function(){
			var scheme_name = $('#scheme_name').val();
			if (scheme_name !=="") 
			{
				$.ajax({
					 url:'/layout/items/nhis_scheme_update.php',
					 method:'POST',
					 data:$('#nhis_scheme_create_form').serialize(),
					 success:function(data){
						 $('#nhis_scheme_create_modal').modal('hide');
						 $('#nhis_scheme_create_form').trigger('reset');
						 $('#nhis_scheme_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Scheme Name cannot be EMPTY!');
			};
		});
	}

	function search_nhis_item()
	{
		$(document).on('keyup','#search_nhis_item',function()
		{
			var search = $(this).val();
			
			  if(search != '')
			  {
				  $.ajax({
					url:"/layout/items/nhis_item_search.php",
					method:"POST",
					data:{search:search},
					success:function(data)
					{
						$('#nhis_list_table').html(data);
					}
				});
			}
		}); 
	}