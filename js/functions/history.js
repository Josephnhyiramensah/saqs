$(document).ready(function()
{
	//HISTORY
		go_to_history_sheet();
		save_history();
		edit_history();
		update_history();
		delete_history();
		view_current_history();
		//view_past_history();
});

	//HISTORY
	function go_to_history_sheet()
	{
		$(document).on('click','#nav_history',function()
		{
			window.location.href="/layout/attendance/history_sheet.php";
			$('#history_update_btn').hide();
			$('#history_save_btn').show();
			$('#add_history_form').trigger('reset');
		}) 
	}

	function save_history()
	{
		$(document).on('click','#history_save_btn',function(e){
			e.preventDefault();
			var date_attend = $('#session_dateofadmission_attd').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var history = $('#history').val();
			var date = $('#h_date').val();
			var time = $('#h_time').val();
			if (date >= date_attend) 
			{
				if (history == "")
				{
					alert('Please type some complaint history!');
				}
				else
				{
					$.ajax({
					 url:'/layout/attendance/history_save.php',
					 method:'POST',
					 data:{
						 attend_id:attend_id,
						 patient_id:patient_id,
						 date:date,
						 history:history,
						time:time
					 },
					 success:function(data)
						 {
							 $('#add_history_form').trigger('reset');
							 view_current_history();
						 }
					 });
				};
			} 
			else 
			{
				alert('Please the date cannot be earlier than the attendance date!')
			};
		});
	}

	function edit_history()
	{
		$(document).on('click','#btn_edit_history',function(){

			var history_id = $(this).attr('data-id');

				$.ajax({  
					 url:'/layout/attendance/history_edit.php',  
					 type:'POST',  
					 data:{history_id:history_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#date').val(res[0]);
						 $('#history_id').val(res[1]);
						 $('#history_attend_id').val(res[2]);
						$('#history_patient_id').val(res[3]);
						$('#history').val(res[4]);
						$('#h_date').val(res[5]);
						$('#h_time').val(res[6]);
						$('#history_save_btn').hide();
						$('#history_save_update').html('<button type="button" id="history_update_btn" class="btn btn-primary">Update</button>');
					 }  
				});
		  }); 
	}

	function update_history()
	{
		$(document).on('click','#history_update_btn',function(e){
			e.preventDefault();
			var date_attend = $('#session_dateofadmission_attd').val();
			var history_id = $('#history_id').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var history = $('#history').val();
			var date = $('#h_date').val();
			var time = $('#h_time').val();
			if (date >= date_attend) 
			{
				if (history !== "")
				{
					$.ajax({
						 url:'/layout/attendance/history_update.php',
						 method:'POST',
						 data:{
							 history_id:history_id,
							 attend_id:attend_id,
							 patient_id:patient_id,
							 date:date,
							 history:history,
							time:time
						 },
						 success:function(data)
						 {
							 $('#add_history_form').trigger('reset');
							 $('#history_save_update').html('<button type="submit" id="history_save_btn" class="btn btn-primary">Save</button>');
							 view_current_history();
						 }
					});
				}
				else
				{
					alert('Please type some complaint history!');
				};
			} 
			else 
			{
				alert('Please the date cannot be earlier than the attendance date!')
			};
		});
	}

	function delete_history()
	{
		$(document).on('click','#btn_delete_history',function(){
			var history_id = $(this).attr('data-id1');
			var currentRow=$(this).closest("tr");
			var historydate = currentRow.find("td:eq(0)").text();
			$('#history_delete_question').text('Are you sure you want to delete this history' + historydate + '?');
			$('#history_delete_modal').modal('show');
			$(document).on('click','#history_delete_yes',function(){
				$.ajax({  
					 url:'/layout/attendance/history_delete.php',  
					 type:'POST',  
					 data:{history_id:history_id},
					 success:function(){
						 $('#history_delete_modal').modal('hide');
						 view_current_history();
					 }  
				});
			  });
			$(document).on('click','#history_delete_no',function(){
				$('#history_delete_modal').modal('hide');
			});
		});
	}

	function view_current_history()
	{
		var attend_id = $('#session_attend_id').val();
		var patient_id = $('#session_patient_id').val();
		$.ajax(
		{
			url: '/layout/attendance/history_current_view.php',
			method: 'POST',
			data:{
					 attend_id:attend_id,
					 patient_id:patient_id
				 },
			success: function(data)
			{
				$('#attend_history_table_div').html(data);
			}
		})
	}

	/*function view_past_history()
	{
		$(document).on('click','#past_history_icon',function(){
			
			var patient_id = $('#session_patient_id').val();
			$.ajax(
			{
				url: '/layout/attendance/history_past_view.php',
				method: 'POST',
				data:{
						 patient_id:patient_id
					 },
				success: function(data)
				{
					$('#attend_pasthistory_table').html(data);
					$('#pasthistorymodal').modal('show');
				}
			})
		});
	}*/	