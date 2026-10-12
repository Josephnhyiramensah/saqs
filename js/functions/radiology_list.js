$(document).ready(function()
{
	//RADIOLOGY
		go_to_radio_sheet();
		save_radio_attend();
		edit_radio_attend();
		update_radio_attend();
		view_current_radio_attend();
		radio_result_enter();
		radio_result_save();
		radio_result_perform_enter();
		radio_result_perform_save();
		radio_result_view();
		radio_result_edit();
		radio_result_update();
		radio_attend_img_upload_modal();
		radio_attend_img_display();
		radio_attend_img_display_clear();
		radio_history();
		radio_report_modal();
		set_radio_price_and_amount();
		radio_attend_delete();
		radio_request_modal();
		radio_request_save();
		radio_request_update();
		search_radio_list_modal();
		search_radio_list_attend();
		search_radio_list_save();
});

	//RADIOLOGY
	function go_to_radio_sheet()
	{
		$(document).on('click','#nav_radio',function()
		{
			window.location.href="/layout/attendance/radio_sheet.php";
			$('#radio_list_update_btn').hide();
			$('#radio_list_save_btn').show();
			$('#radio_attend_form').trigger('reset');
		}) 
	}

	function save_radio_attend()
	{
		$(document).on('click','#radio_list_save_btn',function(e){
			e.preventDefault();
			var radio_id = $('#radio_id').val();
			var radio_list_id = $('#radio_list_id').val();
			var radio_qty = $('#radio_qty').val();
			var radio_sponsor = $('#radio_sponsor').val();
			var radio_date = $('#radio_date').val();
			var radio_price_est = $('#radio_price_est').val();
			var radio_amt_est = $('#radio_amt_est').val();
			var radio_comment = $('#radio_comment').val();
			var radio_attend_id = $('#session_attend_id').val();
			var radio_patient_id = $('#session_patient_id').val();
			if (radio_id > 0) 
				{
					if (radio_date !=="") 
					{
						//if (radio_sponsor > 0) 
							//{
								$.ajax({
									 url:'/layout/attendance/radio_check_duplicate.php',
									 method:'POST',
									 data:{
										 radio_attend_id:radio_attend_id,
										 radio_id:radio_id
									 },
									 datatype:'JSON',
									 success:function(data)
										{
											 var res = $.parseJSON(data);
											 if (res[0] == 'duplicate') 
											 {
												 $('#radio_list_duplicate_question').text('The Radiology Item:'+ res[1] + ' has been selected earlier! Do you want to duplicate the Radiology Item?');
												 $('#radio_list_duplicate_modal').modal('show');
												$(document).on('click','#radio_list_duplicate_yes',function(){
													$.ajax({
														 url:'/layout/attendance/radio_attend_save.php',
														 method:'POST',
														 data:{
															 radio_id:radio_id,
															 radio_list_id:radio_list_id,
															 radio_qty:radio_qty,
															 radio_sponsor:radio_sponsor,
															 radio_date:radio_date,
															 radio_price_est:radio_price_est,
															 radio_amt_est:radio_amt_est,
															 radio_comment:radio_comment,
															 radio_attend_id:radio_attend_id,
															 radio_patient_id:radio_patient_id
														 },
														 success:function(data)
															 {
																 $('#radio_attend_form').trigger('reset');
																 view_current_radio_attend();
																 location.reload();
															 }
													});
												});
												$(document).on('click','#radio_list_duplicate_no',function(){
													$('#radio_list_duplicate_modal').modal('hide');
												});
											 } 
											 else if(res[0] == 'none') 
											 {
												 $.ajax({
													 url:'/layout/attendance/radio_attend_save.php',
													 method:'POST',
													 data:{
														 radio_id:radio_id,
														 radio_list_id:radio_list_id,
														 radio_qty:radio_qty,
														 radio_sponsor:radio_sponsor,
														 radio_date:radio_date,
														 radio_price_est:radio_price_est,
														 radio_amt_est:radio_amt_est,
														 radio_comment:radio_comment,
														 radio_attend_id:radio_attend_id,
														 radio_patient_id:radio_patient_id
													 },
													 success:function(data)
														 {
															 $('#radio_attend_form').trigger('reset');
															 view_current_radio_attend();
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
						alert('Please enter date!');
					};
					
				} 
				else 
				{
					alert('Please select radiology item!');
				};
		});
	}

	function edit_radio_attend()
	{
		$(document).on('click','#btn_edit_radio_attend',function(){

			var radio_list_id = $(this).attr('data-id12');
			var currentRow=$(this).closest("tr");
			var radio = currentRow.find("td:eq(1)").text();
			$.ajax({  
					 url:'/layout/attendance/radio_list_param_count.php',  
					 type:'POST',  
					 data:{radio_list_id:radio_list_id},
					 datatype: 'JSON',
					 success:function(data){
						 if (data==0)
						 {
							 $.ajax({  
								 url:'/layout/attendance/radio_attend_edit.php',  
								 type:'POST',  
								 data:{radio_list_id:radio_list_id},
								 datatype: 'JSON',
								 success:function(data){
									 var res = $.parseJSON(data);
									 $('#radio_date').val(res[0]);
									 $('#radio_id').val(res[1]);
									 $('#radio_attend_id').val(res[2]);
									$('#radio_patient_id').val(res[3]);
									$('#radio_list_id').val(res[4]);
									$('#radio_comment').val(res[5]);
									 $('#radio_qty').val(res[6]);
									$('#radio_price_est').val(res[7]);
									$('#radio_amt_est').val(res[8]);
									$('#radio_sponsor').val(res[9]);
									$('#radio_save_update').html('<button type="submit" name="radio_list_update_btn" id="radio_list_update_btn" class="btn btn-primary">Update</button>');
									$('#radio_list_save_btn').hide();
									$('#radio_list_update_btn').show();
								 }
							 });
						 }
						 else
						 {
							 $('#radio_edit_decline_info').html('Please the Lab:'+radio+' has been performed. Editing is therefore declined!');
							$('#radio_edit_decline_modal').modal('show');
						 }
					 }  
				});
		  }); 
	}

	function update_radio_attend()
	{
		$(document).on('click','#radio_list_update_btn',function(){
			var radio_id = $('#radio_id').val();
			if (radio_id > 0) 
				{
					var radio_id = $('#radio_id').val();
					var radio_list_id = $('#radio_list_id').val();
					var radio_qty = $('#radio_qty').val();
					var radio_sponsor = $('#radio_sponsor').val();
					var radio_date = $('#radio_date').val();
					var radio_price_est = $('#radio_price_est').val();
					var radio_amt_est = $('#radio_amt_est').val();
					var radio_comment = $('#radio_comment').val();
					var radio_attend_id = $('#session_attend_id').val();
					var radio_patient_id = $('#session_patient_id').val();
					$.ajax({
						 url:'/layout/attendance/radio_attend_update.php',
						 method:'POST',
						 data:{
							 radio_id:radio_id,
							 radio_list_id:radio_list_id,
							 radio_qty:radio_qty,
							 radio_sponsor:radio_sponsor,
							 radio_date:radio_date,
							 radio_price_est:radio_price_est,
							 radio_amt_est:radio_amt_est,
							 radio_comment:radio_comment,
							 radio_attend_id:radio_attend_id,
							 radio_patient_id:radio_patient_id
						 },
						 success:function(data)
							 {
								 $('#radio_attend_form').trigger('reset');
								 $('#radio_save_update').html('<button type="submit" name="radio_list_save_btn" id="radio_list_save_btn" class="btn btn-primary">Save</button>');
								 view_current_radio_attend();
							 }
						 });
				} 
				else 
				{
					alert('Please select radiology item!');
				}
			
		});
	}

	function view_current_radio_attend()
	{
		var attend_id = $('#session_attend_id').val();
		var patient_id = $('#session_patient_id').val();
		$.ajax(
		{
			url: '/layout/attendance/radio_attend_current_view.php',
			method: 'POST',
			data:{
					 attend_id:attend_id,
					 patient_id:patient_id
				 },
			success: function(data)
			{
				$('#attend_radio_table').html(data);
			}
		})
	}

	function radio_result_enter()
	{
		$(document).on('click','#btn_radio_result_enter',function(){
				var radio_list_id = $(this).attr('data-id4');
				var radio_id = $(this).attr('data-id5');
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				$.ajax({  
					 url:'/layout/attendance/radio_result_enter.php',  
					 method:'POST',  
					 data:{
						 radio_list_id:radio_list_id, 
						 radio_id:radio_id, 
						 attend_id:attend_id, 
						 patient_id:patient_id
					 },
					 success:function(data){
						 $('#radio_attend_result_enter_table').html(data);
						 $('#radio_attend_result_enter_modal').modal('show');
					 }  
				});
			});
	}

	function radio_result_save()
	{
		$(document).on('click','#radio_attend_result_enter_save_btn',function(){
				var radio_list_id = $(this).attr('data-id4');
				var radio_id = $(this).attr('data-id5');
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				$.ajax({  
					 url:'/layout/attendance/radio_result_save.php',  
					 method:'POST',  
					 data:$('#radio_attend_result_enter_form').serialize(),
					 success:function(data){
						 $('#radio_attend_result_enter_form').trigger('reset');
						 $('#radio_attend_result_enter_modal').modal('hide');
						 view_current_lab_attend();
					 }  
				});
			});
	}

	function radio_result_perform_enter()
	{
		$(document).on('click','#btn_radio_result_perform_enter',function(){
			var radio_list_id = $(this).attr('data-id');
			var radio_id = $(this).attr('data-id1');
			var radio_sponsor = $(this).attr('data-id2');
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var prvt_led_id = $('#session_prvt_led_id').val();
			$.ajax({  
				 url:'/layout/attendance/radio_result_perform_enter.php',  
				 method:'POST',  
				 data:{
					 radio_list_id:radio_list_id, 
					 radio_id:radio_id, 
					 attend_id:attend_id, 
					 patient_id:patient_id,
					 radio_sponsor:radio_sponsor,
					 prvt_led_id:prvt_led_id
				 },
				 success:function(data){
					 $('#radio_attend_result_perform_enter_table').html(data);
					 $('#radio_attend_result_perform_enter_modal').modal('show');
				 }  
			});
		});
	}

	function radio_result_perform_save()
	{
		$(document).on('click','#radio_attend_result_perform_enter_save_btn',function(){
			var radio_list_id = $(this).attr('data-id4');
			var radio_id = $(this).attr('data-id5');
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				 url:'/layout/attendance/radio_result_perform_save.php',
				 method:'POST',
				 data:$('#radio_attend_result_perform_enter_form').serialize(),
				 success:function(data){
					 $('#radio_attend_result_perform_enter_form').trigger('reset');
					 $('#radio_attend_result_perform_enter_modal').modal('hide');
					 view_current_radio_attend();
				 }  
			});
		});
	}

	function radio_result_edit()
	{
		$(document).on('click','#btn_radio_result_perform_edit',function(){
				var radio_list_id = $(this).attr('data-id');
				var radio_id = $(this).attr('data-id1');
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				$.ajax({  
					 url:'/layout/attendance/radio_result_edit.php',  
					 method:'POST',  
					 data:{
						 radio_list_id:radio_list_id, 
						 radio_id:radio_id, 
						 attend_id:attend_id, 
						 patient_id:patient_id
					 },
					 success:function(data){
						 $('#radio_attend_result_edit_table').html(data);
						 $('#radio_attend_result_edit_modal').modal('show');
					 }  
				});
			});
	}

	function radio_result_update()
	{
		$(document).on('click','#radio_attend_result_update_btn',function(){
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				$.ajax({  
					 url:'/layout/attendance/radio_result_update.php',  
					 method:'POST',  
					 data:$('#radio_attend_result_edit_form').serialize(),
					 success:function(data){
						 $('#radio_attend_result_edit_form').trigger('reset');
						 $('#radio_attend_result_edit_modal').modal('hide');
						 view_current_radio_attend();
					 }  
				});
			});
	}

	function radio_result_view()
	{
		$(document).on('click','#btn_radio_result_view',function(){
				var radio_list_id = $(this).attr('data-id');
				var radio_id = $(this).attr('data-id1');
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				$.ajax({  
					 url:'/layout/attendance/radio_result_view.php',  
					 method:'POST',  
					 data:{
						 radio_list_id:radio_list_id, 
						 radio_id:radio_id, 
						 attend_id:attend_id, 
						 patient_id:patient_id
					 },
					 success:function(data){
						 $('#radio_attend_result_view_table').html(data);
						 $('#radio_attend_result_view_modal').modal('show');
					 }  
				});
			});
	}

	function radio_attend_img_upload_modal()
	{
		$(document).on('click','#btn_radio_img_upload',function()
		{
			var radio_list_id = $(this).attr('data-id6');
			var radio_id = $(this).attr('data-id7');
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$('#radio_img_upload_form').trigger('reset');
			$('#radio_list_id_img').val(radio_list_id);
			$('#radio_id_img').val(radio_id);
			$('#attend_id_img').val(attend_id);
			$('#patient_id_img').val(patient_id);
			$('#radio_img_upload_modal_title').html('Upload Radiology Image');
			$('#radio_list_img_update_btn').hide();
			$('#radio_list_img_save_btn').show();
			$('#radio_img_upload_modal').modal('show');
		}); 
	}
	
	function radio_attend_img_display()
	{
		$(document).on('click','#btn_radio_img_view',function()
		{
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var radio_list_id = $(this).attr('data-id2');
			var radio_id = $(this).attr('data-id3');
			$.ajax({  
				url:'/layout/attendance/radio_attend_img_display.php',
				method:'POST',
				datatype: 'JSON',
				data:{
				attend_id:attend_id, 
				patient_id:patient_id, 
				radio_list_id:radio_list_id, 
				radio_id:radio_id
				},
				success:function(data)
				{
					var result = $.parseJSON(data);
					$('#radio_list_img_display').html('');
					for(var i = 0; i < result.length; i += 3) 
					{
						if(result[i+2] == 'pdf')
						{
							$('#radio_list_img_display').append('<iframe src="'+result[i]+'" width="1000" height="1100"></iframe><a href="#" id="delete_radio_image" data-id="'+result[i+1]+'" data-id1="'+attend_id+'" data-id2="'+patient_id+'" data-id3="'+radio_list_id+'" data-id4="'+radio_id+'">Clear</a>');
						}
						else
						{
							$('#radio_list_img_display').append('<img src="'+result[i]+'" width="1000" height="1100"><a href="#" id="delete_radio_image" data-id="'+result[i+1]+'" data-id1="'+attend_id+'" data-id2="'+patient_id+'" data-id3="'+radio_list_id+'" data-id4="'+radio_id+'">Clear</a>');
						};
					};
					$('#radio_img_display_modal').modal('show');
				}
			});
		}); 
	}
	
	function radio_attend_img_display_clear()
	{
		$(document).on('click','#delete_radio_image',function()
		{
			var radio_img_id = $(this).attr('data-id');
			var attend_id = $(this).attr('data-id1');
			var patient_id = $(this).attr('data-id2');
			var radio_list_id = $(this).attr('data-id3');
			var radio_id = $(this).attr('data-id4');
			$('#radio_attend_delete_question').text('Are you sure you want to delete this Radiology Image?');
			$('#radio_attend_delete_modal').modal('show');
			$(document).on('click','#radio_attend_delete_yes',function()
			{
				$('#radio_attend_delete_modal').modal('hide');
				$.ajax({  
					url:'/layout/attendance/radio_attend_img_display_clear.php',
					method:'POST',
					datatype: 'JSON',
					data:{
					radio_img_id:radio_img_id,
					attend_id:attend_id
					},
					success:function(data)
					{
						if(data > 0)
						{
							$.ajax({  
								url:'/layout/attendance/radio_attend_img_display.php',
								method:'POST',
								datatype: 'JSON',
								data:{
								attend_id:attend_id, 
								patient_id:patient_id, 
								radio_list_id:radio_list_id, 
								radio_id:radio_id
								},
								success:function(data)
								{
									var result = $.parseJSON(data);
									$('#radio_list_img_display').html('');
									for(var i = 0; i < result.length; i += 3) 
									{
										if(result[i+2] == 'pdf')
										{
											$('#radio_list_img_display').append('<iframe src="'+result[i]+'" width="1000" height="1100"></iframe><a href="#" id="delete_radio_image" data-id="'+result[i+1]+'" data-id1="'+attend_id+'" data-id2="'+patient_id+'" data-id3="'+radio_list_id+'" data-id4="'+radio_id+'">Clear</a>');
										}
										else
										{
											$('#radio_list_img_display').append('<img src="'+result[i]+'" width="1000" height="1100"><a href="#" id="delete_radio_image" data-id="'+result[i+1]+'" data-id1="'+attend_id+'" data-id2="'+patient_id+'" data-id3="'+radio_list_id+'" data-id4="'+radio_id+'">Clear</a>');
										};
									};
									$('#radio_img_display_modal').modal('show');
								}
							});
						}
						else
						{
							window.location.href="/layout/attendance/radio_sheet.php";
							$('#radio_img_display_modal').modal('hide');
						};
					}
				});
			});
			$(document).on('click','#radio_attend_delete_no',function(){
				$('#radio_attend_delete_modal').modal('hide');
			});
			
		}); 
	}
	
	function radio_history()
	{
		$(document).on('click','#radio_attend_history_icon',function(){
				var patient_id = $('#session_patient_id').val();
				$.ajax({  
					 url:'/layout/attendance/radio_history.php',  
					 method:'POST',  
					 data:{
						 patient_id:patient_id
					 },
					 success:function(data){
						 $('#radio_history_list').html(data);
						 $('#radio_history_modal').modal('show');
					 }  
				});
			});
	}

	function radio_report_modal()
	{
		$(document).on('click','#radio_attend_report_icon',function()
		{
			var patient_id = $('#session_patient_id').val();
			var attend_id= $('#session_attend_id').val();
			$.ajax({  
				 url:'/layout/attendance/radio_report_processing.php',  
				 method:'POST',  
				 data:{
					 attend_id:attend_id, 
					 patient_id:patient_id
				 },
				 success:function(data){
					 window.open('/layout/attendance/radio_report.php', '_blank');
				 }  
			});
		});
	}

	function set_radio_price_and_amount()
	{
		$(document).on('change keyup','#radio_id,#radio_sponsor',function(){
			var sponsor_id = '';
			var sponsor_id = $('#radio_sponsor').val();
			var sponsor_default = $('#session_sponsor').val();
			var radio_id = $('#radio_id').val();
			var age = $('#session_age').val();
			var qty = $('#radio_qty').val();
			$.ajax(
				{
					url: '/layout/attendance/radio_price_set.php',
					method: 'POST',
					data:{
							 sponsor_id:sponsor_id,
							 radio_id:radio_id
						 },
					datatype: 'JSON',
					success: function(data)
					{
						var res = $.parseJSON(data);
						if (res[7] == 'cash')
						{
							//$('#radio_sponsor').val(sponsor_default);
							$('#radio_price_est').val(res[0]);
							$('#radio_amt_est').val(res[0] * qty);
						}
						else if (res[7] == 'nhia') 
						{
							if(age <= 11)
							{
								//$('#radio_sponsor').val(sponsor_default);
								$('#radio_price_est').val(res[4]);
								$('#radio_amt_est').val(res[4] * qty);
							}
							else
							{
								//$('#radio_sponsor').val(sponsor_default);
								$('#radio_price_est').val(res[4]);
								$('#radio_amt_est').val(res[4] * qty);
							}
						}
						else if (res[7] == 'nhia_na') 
						{
							//$('#radio_sponsor').val(1);
							$('#radio_price_est').val(res[0]);
							$('#radio_amt_est').val(res[0] * qty);
						}
						else if (res[7] == 'private_list') 
						{
							//$('#radio_sponsor').val(sponsor_default);
							$('#radio_price_est').val(res[6]);
							$('#radio_amt_est').val(res[6] * qty);
						}
						else if (res[7] == 'private_no_list') 
						{
							//$('#radio_sponsor').val(sponsor_default);
							$('#radio_price_est').val(0);
							$('#radio_amt_est').val(0);
						}
					}
				});
		});
	}

	function radio_attend_delete()
	{
		$(document).on('click','#btn_delete_radio_attend',function(){
			var radio_list_id = $(this).attr('data-id8');
			var attend_id = $('#session_attend_id').val();
			var currentRow=$(this).closest("tr");
			var radio = currentRow.find("td:eq(1)").text();
			$('#radio_attend_delete_question').text('Are you sure you want to delete ' + radio + '?');
			$('#radio_attend_delete_modal').modal('show');
			$(document).on('click','#radio_attend_delete_yes',function(){
				$.ajax({  
					 url:'/layout/attendance/radio_attend_delete.php',  
					 type:'POST',  
					 data:{radio_list_id:radio_list_id,attend_id:attend_id},
					 success:function(){
						 $('#radio_attend_delete_modal').modal('hide');
						 view_current_radio_attend();
					 }  
				});
			  });
			$(document).on('click','#radio_attend_delete_no',function(){
				$('#radio_attend_delete_modal').modal('hide');
			});
		});
	}

	function radio_request_modal()
	{
		$(document).on('click','#radio_attend_request',function()
		{
			var attend_id = $('#session_attend_id').val();
			
			$.ajax({  
				url:'/layout/attendance/radio_request_process.php',  
				method:'POST',
				datatype:'JSON', 
				data:{attend_id:attend_id},
				success:function(data)
				{
					var res = $.parseJSON(data);
					$('#radio_request_id').val(res[0]);
					$('#radio_request_patient').val(res[1]);
					$('#radio_request_patientD').val(res[1]);
					$('#radio_request_doctor').val(res[2]);
					$('#radio_request_diagnosis').val(res[3]);
					$('#radio_request_age').val(res[4]);
					$('#radio_request_test').val(res[5]);
					$('#radio_request_date').val(res[6]);
					$('#radio_request_problem').val(res[7]);
					$('#radio_request_comment').val(res[8]);
					$('#radio_request_clinical_summary').val(res[9]);
					if(res[10] == 'new')
					{
						$('#radio_request_save').show();
						$('#radio_request_update').hide();
					}
					else if(res[10] == 'exist')
					{
						$('#radio_request_save').hide();
						$('#radio_request_update').show();
					};
					$('#radio_request_modal').modal('show');
				}
			});
		});
	}
	
	function radio_request_save()
	{
		$(document).on('click','#radio_request_save',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				url:'/layout/attendance/radio_request_save.php',
				method:'POST',
				data:$('#radio_request_modal_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				success:function(data)
				{
					$('#radio_request_modal_form').trigger('reset');
					$('#radio_request_modal').modal('hide');
					window.open('/layout/attendance/radio_request_pdf.php', '_blank');
				}
			});
		});
	}

	function radio_request_update()
	{
		$(document).on('click','#radio_request_update',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				url:'/layout/attendance/radio_request_update.php',
				method:'POST',
				data:$('#radio_request_modal_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				success:function(data)
				{
					$('#radio_request_modal_form').trigger('reset');
					$('#radio_request_modal').modal('hide');
					window.open('/layout/attendance/radio_request_pdf.php', '_blank');
				}
			});
		});
	}

	function search_radio_list_modal()
	{
		$(document).on('click','#btn_radio_live_search',function()
		{
			$('#radio_list_search_modal_form').trigger('reset');
			$('#radio_list_search').focus();
			$('#radio_list_search_modal').modal('show');
		});
	}

	function search_radio_list_attend()
	{
		$(document).on('keyup','#radio_list_search',function()
		{
			var search = $(this).val();
			$.ajax({
				url:'/layout/attendance/radio_attend_search.php',
				method:"POST",
				data:{search:search},
				success:function(data)
				{
					$('#radio_list_search_table').html(data);
				}
			})
		});
	}

	function search_radio_list_save()
	{
		$(document).on('click','#btn_save_radio_search_item',function()
		{
			var radio_id = $(this).attr('data-id');
			var radio_list_id = $('#radio_list_id').val();
			var radio_qty = $('#radio_qty').val();
			var radio_sponsor = $('#radio_sponsor').val();
			var radio_date = $('#radio_date').val();
			var radio_price_est = $(this).attr('data-id1');
			var radio_amt_est = $(this).attr('data-id1');
			var radio_comment = $('#radio_comment').val();
			var radio_attend_id = $('#session_attend_id').val();
			var radio_patient_id = $('#session_patient_id').val();
			if (radio_id > 0) 
			{
				if (radio_date !=="") 
				{
					//if (radio_sponsor > 0) 
						//{
							$.ajax({
									url:'/layout/attendance/radio_check_duplicate.php',
									method:'POST',
									data:{
									radio_attend_id:radio_attend_id,
									radio_id:radio_id
									},
									datatype:'JSON',
									success:function(data)
									{
										var res = $.parseJSON(data);
										if (res[0] == 'duplicate') 
										{
											$('#radio_list_duplicate_question').text('The Radiology Item:'+ res[1] + ' has been selected earlier! Do you want to duplicate the Radiology Item?');
											$('#radio_list_duplicate_modal').modal('show');
											$(document).on('click','#radio_list_duplicate_yes',function(){
												$.ajax({
														url:'/layout/attendance/radio_attend_save.php',
														method:'POST',
														data:{
														radio_id:radio_id,
														radio_list_id:radio_list_id,
														radio_qty:radio_qty,
														radio_sponsor:radio_sponsor,
														radio_date:radio_date,
														radio_price_est:radio_price_est,
														radio_amt_est:radio_amt_est,
														radio_comment:radio_comment,
														radio_attend_id:radio_attend_id,
														radio_patient_id:radio_patient_id
														},
														success:function(data)
															{
															$('#radio_list_search_modal_form').trigger('reset');
															$('#radio_list_search').focus();
															$('#radio_attend_form').trigger('reset');
															view_current_radio_attend();
															location.reload();
															}
												});
											});
											$(document).on('click','#radio_list_duplicate_no',function(){
												$('#radio_list_duplicate_modal').modal('hide');
											});
										} 
										else if(res[0] == 'none') 
										{
											$.ajax({
													url:'/layout/attendance/radio_attend_save.php',
													method:'POST',
													data:{
													radio_id:radio_id,
													radio_list_id:radio_list_id,
													radio_qty:radio_qty,
													radio_sponsor:radio_sponsor,
													radio_date:radio_date,
													radio_price_est:radio_price_est,
													radio_amt_est:radio_amt_est,
													radio_comment:radio_comment,
													radio_attend_id:radio_attend_id,
													radio_patient_id:radio_patient_id
													},
													success:function(data)
														{
														$('#radio_list_search_modal_form').trigger('reset');
														$('#radio_list_search').focus();
														$('#radio_attend_form').trigger('reset');
														view_current_radio_attend();
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
					alert('Please enter date!');
				};
				
			} 
			else 
			{
				alert('Please select radiology item!');
			};
		});
	}