$(document).ready(function()
{
	//DIAGNOSIS
		new_diagnosis_modal();
		save_diagnosis();
		save_diagnosis_from_attend();
		edit_diagnosis();
		update_diagnosis();
		search_diagnosis();
		edit_patient_allergies();
		update_patient_allergies();
		delete_diagnosis();
});

	//SETUP DIAGNOSIS
	function new_diagnosis_modal()
	{
		$(document).on('click','#new_diagnosis_icon',function()
		{
			$('#diagnosis_update_btn').hide();
			$('#diagnosis_save_btn').show();
			$('#diagnosis_create_form').trigger('reset');
			$('#diagnosis_create_modal').modal('show');
		});
	}

	function save_diagnosis()
	{
		$(document).on('click','#diagnosis_save_btn',function(){
			var diagnosis = $('#diagnosis').val();
			if (diagnosis !=="") 
			{
				$.ajax({
					 url:'/layout/items/diagnosis_save.php',
					 method:'POST',
					 data:$('#diagnosis_create_form').serialize(),
					 success:function(data){
						 $('#diagnosis_create_modal').modal('hide');
						 $('#diagnosis_create_form').trigger('reset');
						 //$('#diagnosis_list_table').html(data);
						window.location.href="/layout/items/diagnosis_list.php";
					 }
				 });
			} 
			else 
			{
				alert('Please the Diagnosis cannot be EMPTY!');
			};
				
		});
	}

	function save_diagnosis_from_attend()
	{
		$(document).on('click','#diagnosis_list_search_insert_new_diagnosis',function(){
			var diagnosis = $('#diagnosis_list_search').val();
			if (diagnosis !=="") 
			{
				$.ajax({
					 url:'/layout/items/diagnosis_save_from_attend.php',
					 method:'POST',
					 data:{diagnosis:diagnosis},
					 success:function(data)
					 {
						var search = diagnosis;
						 $.ajax({
							url:'/layout/attendance/diagnosis_attend_search.php',
							method:"POST",
							data:{search:search},
							success:function(data)
							{
								$('#diagnosis_list_search_table').html(data);
							}
						});
					 }
				 });
			} 
			else 
			{
				alert('Please the Diagnosis cannot be EMPTY!');
			};
				
		});
	}

	function edit_diagnosis()
	{
		$(document).on('click','#btn_edit_diagnosis',function()
		{
			var diagnosis_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/items/diagnosis_edit.php',
				 method:'POST',
				 data:{diagnosis_id:diagnosis_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $('#diagnosis_id').val(res[0]);
					 $('#diagnosis').val(res[2]);
					 $('#nhisitem').val(res[1]);
					 $('#icd_10').val(res[3]);
					 $('#disease_categroy').val(res[4]);
					 $('#disease_group').val(res[5]);
					 $('#diagnosis_update_btn').show();
					$('#diagnosis_save_btn').hide();
					$('#diagnosis_create_modal_header').html('Diagnosis Edit');
					$('#diagnosis_create_modal').modal('show');
				 }
			 });
		});
	}

	function update_diagnosis()
	{
		$(document).on('click','#diagnosis_update_btn',function(){
			var diagnosis = $('#diagnosis').val();
			if (diagnosis !=="") 
			{
				$.ajax({
					 url:'/layout/items/diagnosis_update.php',
					 method:'POST',
					 data:$('#diagnosis_create_form').serialize(),
					 success:function(data){
						 $('#diagnosis_create_modal').modal('hide');
						 $('#diagnosis_create_form').trigger('reset');
						 //$('#diagnosis_list_table').html(data);
						window.location.href="/layout/items/diagnosis_list.php";
					 }
				 });
			} 
			else 
			{
				alert('Please the Diagnosis cannot be EMPTY!');
			};
				
		});
	}

	function search_diagnosis()
	{
		$(document).on('keyup','#search_diagnosis',function()
		{
			var search = $(this).val();
			
			  if(search != '')
			  {
				  $.ajax({
					url:"/layout/items/diagnosis_search.php",
					method:"POST",
					data:{search:search},
					success:function(data)
					{
						$('#diagnosis_list_table').html(data);
					}
				});
			}
		}); 
	}
			
	function delete_diagnosis()
	{
		$(document).on('click','#btn_delete_diagnosis',function()
		{
			var diagnosis_id = $(this).attr('data-id');
			var diagnosis = $(this).attr('data-id1');
			$('#item_delete_question').text('Are you sure you want to delete ' + diagnosis + '?');
			$('#item_delete_modal').modal('show');
			$(document).on('click','#item_delete_yes',function()
			{
				$.ajax({  
					url:'/layout/items/diagnosis_delete.php',  
					type:'POST',  
					data:{diagnosis_id:diagnosis_id},
					success:function(data)
					{
						$('#item_delete_modal').modal('hide');
						if(data == 'used')
						{
							alert('Please, '+ diagnosis +' has been used in an attendance sheet, deletion is therefore declined!')
						}
						else if(data == 'deleted')
						{
							window.location.href="/layout/items/diagnosis_list.php";
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
