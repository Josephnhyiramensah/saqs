$(document).ready(function()
{
	//CLINICS
		new_clinic_modal();
		save_clinic();
		edit_clinic();
		update_clinic();
		delete_clinic();
});

	//SETUP CLINIC
	function new_clinic_modal()
	{
		$(document).on('click','#new_clinic_icon',function()
		{
			$('#clinic_update_btn').hide();
			$('#clinic_save_btn').show();
			$('#clinic_create_form').trigger('reset');
			$('#clinic_create_modal_header').html('Clinic Setup');
			$('#clinic_create_modal').modal('show');
		});
	}

	function save_clinic()
	{
		$(document).on('click','#clinic_save_btn',function(){
			var clinic = $('#clinic').val();
			if (clinic !=="") 
			{
				$.ajax({
					 url:'/layout/items/clinic_save.php',
					 method:'POST',
					 data:$('#clinic_create_form').serialize(),
					 success:function(data){
						 $('#clinic_create_modal').modal('hide');
						 $('#clinic_create_form').trigger('reset');
						 window.location.href="/layout/items/clinic_list.php";
						 //$('#clinic_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Clinic cannot be EMPTY!');
			};
		});
	}

	function edit_clinic()
	{
		$(document).on('click','#btn_edit_clinic',function()
		{
			var clinic_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/items/clinic_edit.php',
				 method:'POST',
				 data:{clinic_id:clinic_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $('#clinic_id').val(res[0]);
					 $('#clinic').val(res[1]);
					 $('#service_charge').val(res[2]);
					 $('#clinic_update_btn').show();
					$('#clinic_save_btn').hide();
					$('#clinic_create_modal_header').html('Clinic Edit');
					$('#clinic_create_modal').modal('show');
				 }
			 });
		});
	}

	function update_clinic()
	{
		$(document).on('click','#clinic_update_btn',function(){
			var clinic = $('#clinic').val();
			if (clinic !=="") 
			{
				$.ajax({
					 url:'/layout/items/clinic_update.php',
					 method:'POST',
					 data:$('#clinic_create_form').serialize(),
					 success:function(data){
						 $('#clinic_create_modal').modal('hide');
						 $('#clinic_create_form').trigger('reset');
						 window.location.href="/layout/items/clinic_list.php";
						 //$('#clinic_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Clinic cannot be EMPTY!');
			};
		});
	}
	
	function delete_clinic()
	{
		$(document).on('click','#btn_delete_clinic',function()
		{
			var clinic_id = $(this).attr('data-id');
			var clinic = $(this).attr('data-id1');
			$('#item_delete_question').text('Are you sure you want to delete ' + clinic + '?');
			$('#item_delete_modal').modal('show');
			$(document).on('click','#item_delete_yes',function()
			{
				$.ajax({  
					url:'/layout/items/clinic_delete.php',  
					type:'POST',  
					data:{clinic_id:clinic_id},
					success:function(data)
					{
						$('#item_delete_modal').modal('hide');
						if(data == 'used')
						{
							alert('Please, '+ clinic +' has been used in an attendance sheet, deletion is therefore declined!')
						}
						else if(data == 'deleted')
						{
							window.location.href="/layout/items/clinic_list.php";
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