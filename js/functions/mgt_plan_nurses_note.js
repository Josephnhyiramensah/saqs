$(document).ready(function()
{
	//MGT PLAN AND NURSES NOTES
		go_to_mgt_plan_and_note_sheet();
		save_mgt_plan();
		edit_mgt_plan();
		update_management_plan();
		view_current_mgt_plan();
		view_mgt_plan_history();
		delete_mgt_plan();
		save_nurses_note();
		edit_nurses_note();
		update_nurses_note();
		view_current_nurses_note();
		view_nurses_note_history();
		delete_nurses_note();
});


	//MGT PLAN AND NURSES NOTES
	function go_to_mgt_plan_and_note_sheet()
	{
		$(document).on('click','#nav_mgtplan',function()
		{
			window.location.href="/layout/attendance/plan_and_notes_sheet.php";
			$('#management_plan_form').trigger('reset');
			$('#nnotes_form').trigger('reset');
		}) 
	}

	function save_mgt_plan()
	{
		$(document).on('click','#management_plan_save_btn',function(e){
			e.preventDefault();
			var management_plan = $('#management_plan').val();
			var management_plan_initials = $('#management_plan_initials').val();
			var management_plan_date = $('#management_plan_date').val();
			var management_plan_time = $('#management_plan_time').val();
			if (management_plan !=="" && management_plan_initials !== "") 
			{
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				
				$.ajax({
					url:'/layout/attendance/mgt_plan_save.php',
					method:'POST',
					data:{
						management_plan:management_plan,
						management_plan_initials:management_plan_initials,
						management_plan_date:management_plan_date,
						management_plan_time:management_plan_time,
						attend_id:attend_id,
						patient_id:patient_id
					},
					success:function(data)
					{
						$('#management_plan_form').trigger('reset');
						$('#attend_management_plan_table').html(data);
					}
				});
			} 
			else 
			{
				alert('Please enter a plan and your initials!');
			};
		});
	}

	function edit_mgt_plan()
	{
		$(document).on('click','#btn_edit_management_plan',function(){

			var management_plan_id = $(this).attr('data-id');

				$.ajax({  
					 url:'/layout/attendance/mgt_plan_edit.php',  
					 type:'POST',  
					 data:{management_plan_id:management_plan_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#management_plan_id').val(res[0]);
						 $('#management_plan').val(res[1]);
						 $('#management_plan_initials').val(res[2]);
						 $('#management_plan_date').val(res[3])
						 $('#management_plan_time').val(res[4])
						$('#management_plan_update_btn').prop('hidden', false);
						$('#management_plan_save_btn').prop('hidden', true);
					}  
				});
		}); 
	}

	function update_management_plan()
	{
		$(document).on('click','#management_plan_update_btn',function(e){
			e.preventDefault();
			var management_plan_id = $('#management_plan_id').val();
			var management_plan = $('#management_plan').val();
			var management_plan_initials = $('#management_plan_initials').val();
			var management_plan_date = $('#management_plan_date').val();
			var management_plan_time = $('#management_plan_time').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			if (management_plan !=="" && management_plan_initials !== "") 
			{
				$.ajax({
					url:'/layout/attendance/mgt_plan_update.php',
					method:'POST',
					data:{
						management_plan_id:management_plan_id,
						management_plan:management_plan,
						management_plan_initials:management_plan_initials,
						management_plan_date:management_plan_date,
						management_plan_time:management_plan_time,
						attend_id:attend_id,
						patient_id:patient_id
					},
					success:function(data)
					{
						$('#management_plan_form').trigger('reset');
						$('#management_plan_update_btn').prop('hidden', true);
						$('#management_plan_save_btn').prop('hidden', false);
						$('#attend_management_plan_table').html(data);
					}
				});
			} 
			else 
			{
				alert('Please enter a plan and your initials!');
			};
		});
	}

	function view_current_mgt_plan()
	{
		var attend_id = $('#session_attend_id').val();
		$.ajax(
		{
			url: '/layout/attendance/mgt_plan_current_view.php',
			method: 'POST',
			data:{
					 attend_id:attend_id
				 },
			success: function(data)
			{
				$('#attend_management_plan_table').html(data);
			}
		})
	}

	function view_mgt_plan_history()
	{
		$(document).on('click','#mgtplan_history_icon',function(){
			
			var patient_id = $('#session_patient_id').val();
			$.ajax(
			{
				url: '/layout/attendance/mgt_plan_history_view.php',
				method: 'POST',
				data:{
						 patient_id:patient_id
					 },
				success: function(data)
				{
					$('#attend_mgtplanhistory_table').html(data);
					$('#mgtplan_history_modal').modal('show');
				}
			})
		});
	}

	function delete_mgt_plan()
	{
		$(document).on('click','#btn_delete_management_plan',function(){
			var mp_id = $(this).attr('data-id');
			var attend_id = $('#session_attend_id').val();
			$('#plan_note_delete_question').text('Are you sure you want to delete this management plan?');
			$('#plan_note_delete_modal').modal('show');
			$(document).on('click','#plan_note_delete_yes',function(){
				$.ajax({  
					 url:'/layout/attendance/mgt_plan_delete.php',  
					 type:'POST',  
					 data:{mp_id:mp_id,attend_id:attend_id},
					 success:function(){
						 $('#plan_note_delete_modal').modal('hide');
						 view_current_mgt_plan();
					 }  
				});
			  });
			$(document).on('click','#plan_note_delete_no',function(){
				$('#plan_note_delete_modal').modal('hide');
			});
		});
	}

	function save_nurses_note()
	{
		$(document).on('click','#nnotes_save_btn',function(e){
			e.preventDefault();
			var nurses_notes = $('#nurses_notes').val();
			var nnotes_initials = $('#nnotes_initials').val();
			var nnotes_date = $('#nnotes_date').val();
			var nnotes_time = $('#nnotes_time').val();
			if (nurses_notes !="" && nnotes_initials != "") 
			{
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				
				$.ajax({
					url:'/layout/attendance/nurses_notes_save.php',
					method:'POST',
					data:{
						nurses_notes:nurses_notes,
						nnotes_initials:nnotes_initials,
						nnotes_date:nnotes_date,
						nnotes_time:nnotes_time,
						attend_id:attend_id,
						patient_id:patient_id
					},
					success:function(data)
					{
						$('#nnotes_form').trigger('reset');
						$('#attend_nnotes_table').html(data);
					}
				});
			} 
			else 
			{
				alert('Please enter a nurses notes and your initials!');
			};
		});
	}

	function edit_nurses_note()
	{
		$(document).on('click','#btn_edit_nnotes',function(){

			var nn_id = $(this).attr('data-id1');

				$.ajax({  
					 url:'/layout/attendance/nurses_notes_edit.php',  
					 type:'POST',  
					 data:{nn_id:nn_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#nn_id').val(res[0]);
						 $('#nurses_notes').val(res[1]);
						 $('#nnotes_initials').val(res[2]);
						 $('#nnotes_date').val(res[3]);
						 $('#nnotes_time').val(res[4]);
						$('#nnotes_update_btn').prop('hidden', false);
						$('#nnotes_save_btn').prop('hidden', true);
					}  
				});
		  }); 
	}

	function update_nurses_note()
	{
		$(document).on('click','#nnotes_update_btn',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var nn_id = $('#nn_id').val();
			var nurses_notes = $('#nurses_notes').val();
			var nnotes_initials = $('#nnotes_initials').val();
			var nnotes_date = $('#nnotes_date').val();
			var nnotes_time = $('#nnotes_time').val();
			if (nurses_notes !="" && nnotes_initials != "") 
			{
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				
				$.ajax({
					url:'/layout/attendance/nurses_notes_update.php',
					method:'POST',
					data:{
						nn_id:nn_id,
						nurses_notes:nurses_notes,
						nnotes_initials:nnotes_initials,
						nnotes_date:nnotes_date,
						nnotes_time:nnotes_time,
						attend_id:attend_id,
						patient_id:patient_id
					},
					success:function(data)
					{
						$('#nnotes_form').trigger('reset');
						$('#nnotes_update_btn').prop('hidden', true);
						$('#nnotes_save_btn').prop('hidden', false);
						$('#attend_nnotes_table').html(data);
					}
				});
			} 
			else 
			{
				alert('Please enter a nurses notes and your initials!');
			};
		});
	}

	function view_current_nurses_note()
	{
		var attend_id = $('#session_attend_id').val();
		$.ajax(
		{
			url: '/layout/attendance/nurses_notes_current_view.php',
			method: 'POST',
			data:{
					 attend_id:attend_id
				 },
			success: function(data)
			{
				$('#attend_nnotes_table').html(data);
			}
		})
	}

	function view_nurses_note_history()
	{
		$(document).on('click','#nnotes_history_icon',function(){
			
			var patient_id = $('#session_patient_id').val();
			$.ajax(
			{
				url: '/layout/attendance/nurses_notes_history_view.php',
				method: 'POST',
				data:{
						 patient_id:patient_id
					 },
				success: function(data)
				{
					$('#attend_nnoteshistory_table').html(data);
					$('#nnotes_history_modal').modal('show');
				}
			})
		});
	}

	function delete_nurses_note()
	{
		$(document).on('click','#btn_delete_nnotes',function(){
			var nn_id = $(this).attr('data-id');
			var attend_id = $('#session_attend_id').val();
			$('#plan_note_delete_modal_title').text('Nurses Note Deletion');
			$('#plan_note_delete_question').text('Are you sure you want to delete this nurses note?');
			$('#plan_note_delete_modal').modal('show');
			$(document).on('click','#plan_note_delete_yes',function(){
				$.ajax({  
					 url:'/layout/attendance/nurses_notes_delete.php',  
					 type:'POST',  
					 data:{nn_id:nn_id,attend_id:attend_id},
					 success:function(){
						 $('#plan_note_delete_modal').modal('hide');
						 view_current_nurses_note();
					 }  
				});
			  });
			$(document).on('click','#plan_note_delete_no',function(){
				$('#plan_note_delete_modal').modal('hide');
			});
		});
	}
