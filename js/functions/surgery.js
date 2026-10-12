$(document).ready(function()
{
	//SURGERIES AND PROCEDURES
		new_surgery_modal();
		save_surgery();
		edit_surgery();
		update_surgery();
		search_surgery();
		delete_surgery();
});

	//SETUP SURGERIES/PROCEDURES
	function new_surgery_modal()
	{
		$(document).on('click','#new_surgery_icon',function()
		{
			$('#surgery_update_btn').hide();
			$('#surgery_save_btn').show();
			$('#surgery_create_form').trigger('reset');
			$('#surgery_create_modal').modal('show');
		});
	}

	function save_surgery()
	{
		$(document).on('click','#surgery_save_btn',function(){
			var surgery = $('#surgery').val();
			if (surgery !=="") 
			{
				$.ajax({
					 url:'/layout/items/surgery_save.php',
					 method:'POST',
					 data:$('#surgery_create_form').serialize(),
					 success:function(data){
						 $('#surgery_create_modal').modal('hide');
						 $('#surgery_create_form').trigger('reset');
						 //$('#surgery_list_table').html(data);
						 window.location.href="/layout/items/surgery_list.php";
					 }
				 });
			} 
			else 
			{
				alert('Please the Surgery/Procedure Description cannot be EMPTY!');
			};
		});
	}

	function edit_surgery()
	{
		$(document).on('click','#btn_edit_surgery',function()
		{
			var surgery_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/items/surgery_edit.php',
				 method:'POST',
				 data:{surgery_id:surgery_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $('#surgery_id').val(res[0]);
					 $('#surgery').val(res[2]);
					 $('#nhisitem').val(res[1]);
					 $('#icd_10').val(res[4]);
					 $('#price_cash').val(res[3]);
					 $('#price_private').val(res[5]);
					 $('#price_private_topup').val(res[6]);
					 $('#price_nhis_topup').val(res[7]);
					 $('#surgery_update_btn').show();
					$('#surgery_save_btn').hide();
					$('#surgery_create_modal_header').html('Surgery Edit');
					$('#surgery_create_modal').modal('show');
				 }
			 });
		});
	}

	function update_surgery()
	{
		$(document).on('click','#surgery_update_btn',function(){
			var surgery = $('#surgery').val();
			if (surgery !=="") 
			{
				$.ajax({
					 url:'/layout/items/surgery_update.php',
					 method:'POST',
					 data:$('#surgery_create_form').serialize(),
					 success:function(data){
						 $('#surgery_create_modal').modal('hide');
						 $('#surgery_create_form').trigger('reset');
						 //$('#surgery_list_table').html(data);
						window.location.href="/layout/items/surgery_list.php";
					 }
				 });
			} 
			else 
			{
				alert('Please the Surgery/Procedure Description cannot be EMPTY!');
			};
		});
	}

	function search_surgery()
	{
		$(document).on('keyup','#search_procedure',function()
		{
			var search = $(this).val();
			
			  if(search != '')
			  {
				  $.ajax({
					url:"/layout/items/surgery_search.php",
					method:"POST",
					data:{search:search},
					success:function(data)
					{
						$('#surgery_list_table').html(data);
					}
				});
			}
		}); 
	}
			
	function delete_surgery()
	{
		$(document).on('click','#btn_delete_surgery',function()
		{
			var surgery_id = $(this).attr('data-id');
			var surgery = $(this).attr('data-id1');
			$('#item_delete_question').text('Are you sure you want to delete ' + surgery + '?');
			$('#item_delete_modal').modal('show');
			$(document).on('click','#item_delete_yes',function()
			{
				$.ajax({  
					url:'/layout/items/surgery_delete.php',  
					type:'POST',  
					data:{surgery_id:surgery_id},
					success:function(data)
					{
						$('#item_delete_modal').modal('hide');
						if(data == 'used')
						{
							alert('Please, '+ surgery +' has been used in an attendance sheet, deletion is therefore declined!')
						}
						else if(data == 'deleted')
						{
							window.location.href="/layout/items/surgery_list.php";
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
