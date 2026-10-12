$(document).ready(function()
{
	//DIAGNOSIS
		go_to_diagnosis_sheet();
		save_attend_diagnosis();
		edit_diagnosis_attend();
		update_diagnosis_attend();
		view_current_diagnosis();
		view_diagnosis_history();
		delete_diagnosis_attend();
		search_diagnosis_list_attend();
		search_diagnosis_list_modal();
		search_diagnosis_list_save();
});

	//DIAGNOSIS
	function go_to_diagnosis_sheet()
	{
		$(document).on('click','#nav_diagnosis',function()
		{
			window.location.href="/layout/attendance/diagnosis_sheet.php";
			$('#diag_update_btn').hide();
			$('#diag_save_btn').show();
			$('#diagnosis_attend_form').trigger('reset');
		}) 
	}

	function save_attend_diagnosis()
	{
		$(document).on('click','#diag_save_btn',function(){
			var diagnosis = $('#diagnosis').val();
			var diag_sponsor = $('#diag_sponsor').val();
			var diag_date = $('#diag_date').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var diag_gdrg = $('#diag_gdrg').val();
			var diag_comment = $('#diag_comment').val();
			var diag_amt = $('#diag_amt').val();
			var age = $('#session_age').val();
			var clinic = $('#session_clinic').val();
			var tos = $('#session_typeofservice_attd').val();
			
			if (diagnosis > 0) 
				{
					if (diag_date !=="") 
						{
							//if (diag_sponsor > 0) 
								//{
									$.ajax({
										 url:'/layout/attendance/diagnosis_check_duplicate.php',
										 method:'POST',
										 data:{
											 attend_id:attend_id,
											 diagnosis:diagnosis
										 },
										 datatype:'JSON',
										 success:function(data)
											 {
												 var res = $.parseJSON(data);
												 if (res[0] == 'duplicate') 
												 {
													 $('#diagnosis_list_duplicate_question').text('The diagnosis:'+ res[1] + ' has been selected earlier! Do you want to duplicate the diagnosis?');
													 $('#diagnosis_list_duplicate_modal').modal('show');
													$(document).on('click','#diagnosis_list_duplicate_yes',function(){
														$.ajax({
															 url:'/layout/attendance/diagnosis_save.php',
															 method:'POST',
															 data:{
																 attend_id:attend_id,
																 patient_id:patient_id,
																 diagnosis:diagnosis,
																 diag_date:diag_date,
																 diag_gdrg:diag_gdrg,
																 diag_comment:diag_comment,
																 diag_amt:diag_amt,
																 diag_sponsor:diag_sponsor,
																clinic:clinic,
																age:age,
																tos:tos
															 },
															 success:function()
																{
																	 $('#diagnosis_attend_form').trigger('reset');
																	 $('#diagnosis_list_duplicate_modal').modal('hide');
																	 view_current_diagnosis();
																	 location.reload();
																}
														});
													});
													$(document).on('click','#diagnosis_list_duplicate_no',function(){
														$('#diagnosis_list_duplicate_modal').modal('hide');
													});
												 } 
												 else if(res[0] == 'none') 
												 {
													 $.ajax({
														 url:'/layout/attendance/diagnosis_save.php',
														 method:'POST',
														 data:{
															 attend_id:attend_id,
															 patient_id:patient_id,
															 diagnosis:diagnosis,
															 diag_date:diag_date,
															 diag_gdrg:diag_gdrg,
															 diag_comment:diag_comment,
															 diag_amt:diag_amt,
															 diag_sponsor:diag_sponsor,
															clinic:clinic,
															age:age,
															tos:tos
														 },
														 success:function()
															{
																 $('#diagnosis_attend_form').trigger('reset');
																 view_current_diagnosis();
															}
													});
												 };
											 }
									});
								/*} 
								else 
								{
									alert('Please select the Sponsor!');
								};*/
						}
						else 
						{
							alert('Please enter the Date!');
						};
					
			} 
			else 
			{
				alert('Please select diagnosis!');
			};
		});
	}

	function edit_diagnosis_attend()
	{
		$(document).on('click','#btn_edit_diag',function(){

			var diagnosis_list_id = $(this).attr('data-id1');

				$.ajax({  
					 url:'/layout/attendance/diagnosis_edit.php',  
					 type:'POST',  
					 data:{diagnosis_list_id:diagnosis_list_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#diag_date').val(res[0]);
						 $('#diagnosis').val(res[1]);
						 $('#diag_attend_id').val(res[2]);
						$('#diag_patient_id').val(res[3]);
						$('#diagnosis_list_id').val(res[4]);
						$('#diag_comment').val(res[5]);
						$('#diag_gdrg').val(res[6]);
						$('#diag_amt').val(res[7]);
						$('#diag_sponsor').val(res[8]);
						$('#diag_save_btn').hide();
						$('#diagnosis_save_update').html('<button type="button" id="diag_update_btn" class="btn btn-primary">Update</button>');
					 }  
				});
		  }); 
	}

	function update_diagnosis_attend()
	{
		$(document).on('click','#diag_update_btn',function(){
			var diagnosis = $('#diagnosis').val();
			if (diagnosis > 0) 
				{
					var diagnosis_list_id = $('#diagnosis_list_id').val();
					var attend_id = $('#session_attend_id').val();
					var patient_id = $('#session_patient_id').val();
					var diag_date = $('#diag_date').val();
					var diag_gdrg = $('#diag_gdrg').val();
					var diag_comment = $('#diag_comment').val();
					var diag_sponsor = $('#diag_sponsor').val();
					var diag_amt = $('#diag_amt').val();
					var age = $('#session_age').val();
					var clinic = $('#session_clinic').val();
					var tos = $('#session_typeofservice_attd').val();
					$.ajax({
						 url:'/layout/attendance/diagnosis_update.php',
						 method:'POST',
						 data:{
							 diagnosis_list_id:diagnosis_list_id,
							 attend_id:attend_id,
							 patient_id:patient_id,
							 diagnosis:diagnosis,
							 diag_date:diag_date,
							 diag_gdrg:diag_gdrg,
							 diag_comment:diag_comment,
							 diag_amt:diag_amt,
							 diag_sponsor:diag_sponsor,
							clinic:clinic,
							age:age,
							tos:tos
						 },
						 success:function(data)
							 {
								 $('#diagnosis_attend_form').trigger('reset');
								 $('#diagnosis_save_update').html('<button type="button" id="diag_save_btn" class="btn btn-primary">Save</button>');
								 view_current_diagnosis();
							 }
						 });
				} 
				else 
				{
					alert('Please select diagnosis!');
				}
			
		});
	}

	function view_current_diagnosis()
	{
		var attend_id = $('#session_attend_id').val();
		var age = $('#session_age').val();
		$.ajax({
			url:'/layout/attendance/diagnosis_current_view.php',
			method:'POST',
			data:{
				attend_id:attend_id,
				age:age
			},
			success:function(data)
			{
				$('#attend_diagnosis_table').html(data);
			}
		});
	}

	function view_diagnosis_history()
	{
		$(document).on('click','#diagnosis_history_icon',function(){
			
			var patient_id = $('#session_patient_id').val();
			$.ajax(
			{
				url: '/layout/attendance/diagnosis_history_view.php',
				method: 'POST',
				data:{
						 patient_id:patient_id
					 },
				success: function(data)
				{
					$('#attend_diagnosis_history_table').html(data);
				}
			});
		});
	}

	function search_diagnosis_list_modal()
	{
		$(document).on('click','#btn_diagnosis_live_search',function()
		{
			$('#diagnosis_list_search_modal_form').trigger('reset');
			$('#diagnosis_list_search').focus();
			$('#diagnosis_list_search_modal').modal('show');
		});
	}

	function search_diagnosis_list_attend()
	{
		$(document).on('keyup','#diagnosis_list_search',function()
		{
			var search = $(this).val();
			$.ajax({
				url:'/layout/attendance/diagnosis_attend_search.php',
				method:"POST",
				data:{search:search},
				success:function(data)
				{
					$('#diagnosis_list_search_table').html(data);
				}
			})
		});
	}

	function search_diagnosis_list_save()
	{
		$(document).on('click','#btn_save_diagnosis_search_item',function()
		{
			var diagnosis = $(this).attr('data-id');
			var diag_sponsor = $('#diag_sponsor').val();
			var diag_date = $('#diag_date').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var diag_gdrg = $('#diag_gdrg').val();
			var diag_comment = $('#diag_comment').val();
			var diag_amt = $('#diag_amt').val();
			var age = $('#session_age').val();
			var clinic = $('#session_clinic').val();
			var tos = $('#session_typeofservice_attd').val();
			$.ajax({
				url:'/layout/attendance/diagnosis_save.php',
				method:'POST',
				data:{
					attend_id:attend_id,
					patient_id:patient_id,
					diagnosis:diagnosis,
					diag_date:diag_date,
					diag_gdrg:diag_gdrg,
					diag_comment:diag_comment,
					diag_amt:diag_amt,
					diag_sponsor:diag_sponsor,
					clinic:clinic,
					age:age,
					tos:tos
				},
				success:function()
				{
					$('#diagnosis_list_search_modal_form').trigger('reset');
					$('#diagnosis_list_search').focus();
					$('#diagnosis_attend_form').trigger('reset');
					view_current_diagnosis();
				}
			});
		});
	}

	function delete_diagnosis_attend()
	{
		$(document).on('click','#btn_delete_diag',function(){
			var attend_id = $('#session_attend_id').val();
			var diagnosis_list_id = $(this).attr('data-id2');
			var currentRow = $(this).closest("tr");
			var diagnosis = currentRow.find("td:eq(1)").text();
			$('#diagnosis_list_delete_question').text('Are you sure you want to delete ' + diagnosis + '?');
			$('#diagnosis_list_delete_modal').modal('show');
			$(document).on('click','#diagnosis_list_delete_yes',function(){
				$.ajax({  
					url:'/layout/attendance/diagnosis_attend_delete.php',  
					type:'POST',  
					data:{diagnosis_list_id:diagnosis_list_id,attend_id:attend_id},
					success:function()
					{
						 $('#diagnosis_list_delete_modal').modal('hide');
						 view_current_diagnosis();
					}
				});
			});
			$(document).on('click','#diagnosis_list_delete_no',function(){
				$('#diagnosis_list_delete_modal').modal('hide');
			});
		});
	}