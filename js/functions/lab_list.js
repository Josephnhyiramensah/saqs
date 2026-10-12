$(document).ready(function()
{
	//LABS
		go_to_lab_sheet();
		enter_composite_lab_attend();
		save_lab_attend();
		edit_lab_attend();
		update_lab_attend();
		lab_attend_delete();
		view_current_lab_attend();
		lab_result_enter();
		lab_result_save();
		lab_result_perform_enter();
		lab_result_perform_save();
		lab_result_view();
		lab_doctors_view();
		lab_result_edit();
		lab_result_update();
		lab_attend_img_upload_modal();
		labs_attend_img_upload();
		labs_attend_img_display();
		lab_attend_img_display_clear();
		lab_report_modal();
		lab_history();
		set_lab_price_and_amount();
		lab_print_status();
		lab_bill_status();
		lab_request_modal();
		lab_request_save();
		lab_request_update();
		search_lab_list_modal();
		search_lab_list_attend();
		search_lab_list_save();
});

	//LABS
	function go_to_lab_sheet()
	{
		$(document).on('click','#nav_labs',function()
		{
			window.location.href="/layout/attendance/lab_sheet.php";
			$('#lab_print_status').val('Yes');
			$('#lab_list_update_btn').hide();
			$('#lab_list_save_btn').show();
			$('#labs_attend_form').trigger('reset');
		}) 
	}

	function enter_composite_lab_attend()
	{
		$(document).on('click','#composite_lab_enter_btn',function(e){
			e.preventDefault();
			var composite_lab_select = $('#composite_lab_select').val();
			var lab_date = $('#lab_date').val();
			var lab_sponsor = $('#lab_sponsor').val();
			var lab_attend_id = $('#session_attend_id').val();
			var lab_patient_id = $('#session_patient_id').val();
			var lab_comment = $('#lab_comment').val();
			var lab_print_status = $('#lab_print_status').val();
			var lab_qty = $('#lab_qty').val();
			
			if (composite_lab_select > 0) 
			{
				if (lab_date !="")
				{
					$.ajax({
						url:'/layout/attendance/labs_attend_save_composite.php',
						method:'POST',
						data:{
							composite_lab_select:composite_lab_select,
							lab_attend_id:lab_attend_id,
							lab_patient_id:lab_patient_id,
							lab_comment:lab_comment,
							lab_date:lab_date,
							lab_qty:lab_qty,
							lab_sponsor:lab_sponsor,
							lab_print_status:lab_print_status
						},
						success:function(data)
						{
							$('#labs_attend_form').trigger('reset');
							view_current_lab_attend();
						}
					});
				} 
				else 
				{
					alert('Please enter date!');
				};
			} 
			else 
			{
				alert('Please select a Composite Lab test!');
			};
		});
	}

	function save_lab_attend()
	{
		$(document).on('click','#lab_list_save_btn, #btn_past_lab_request',function(e){
			e.preventDefault();
			var lab_id_search = $('#lab_id').val();
			var lab_id_request = $(this).attr('data-id');
			if(lab_id_search !='' && lab_id_search > 0)
			{
				var lab_id = lab_id_search;
			}
			else if(lab_id_request !='' && lab_id_request > 0)
			{
				var lab_id = lab_id_request;
			};
			var lab_date = $('#lab_date').val();
			var lab_sponsor = $('#lab_sponsor').val();
			var lab_attend_id = $('#session_attend_id').val();
			var lab_patient_id = $('#session_patient_id').val();
			var lab_comment = $('#lab_comment').val();
			var lab_perform = $('#lab_perform').val();
			var lab_amt_est = $('#lab_amt_est').val();
			var lab_price_est = $('#lab_price_est').val();
			var lab_print_status = $('#lab_print_status').val();
			var lab_qty = $('#lab_qty').val();
			if (lab_id > 0) 
			{
				if (lab_date !=="")
				{
					//if (lab_sponsor > 0) 
						//{
							$.ajax({
								 url:'/layout/attendance/lab_check_duplicate.php',
								 method:'POST',
								 data:{
									 lab_attend_id:lab_attend_id,
									 lab_id:lab_id
								 },
								 datatype:'JSON',
								 success:function(data)
									{
										 var res = $.parseJSON(data);
										 if (res[0] == 'duplicate')
										 {
											 $('#lab_list_duplicate_question').text('The Lab Test:'+ res[1] + ' has been selected earlier! Do you want to duplicate the Lab Test?');
											 $('#lab_list_duplicate_modal').modal('show');
											$(document).on('click','#lab_list_duplicate_yes',function(){
												
												$.ajax({
													url:'/layout/attendance/labs_attend_save.php',
													method:'POST',
													data:{
														lab_id:lab_id,
														lab_attend_id:lab_attend_id,
														lab_patient_id:lab_patient_id,
														lab_comment:lab_comment,
														lab_price_est:lab_price_est,
														lab_amt_est:lab_amt_est,
														lab_date:lab_date,
														lab_qty:lab_qty,
														lab_sponsor:lab_sponsor,
														lab_print_status:lab_print_status
													},
													success:function(data)
													{
														$('#labs_attend_form').trigger('reset');
														view_current_lab_attend();
														location.reload();
													}
												});
											});
											$(document).on('click','#lab_list_duplicate_no',function(){
												$('#lab_list_duplicate_modal').modal('hide');
											});
										 } 
										 else if(res[0] == 'none') 
										 {
											 $.ajax({
												url:'/layout/attendance/labs_attend_save.php',
												method:'POST',
												data:{
													lab_id:lab_id,
													lab_attend_id:lab_attend_id,
													lab_patient_id:lab_patient_id,
													lab_comment:lab_comment,
													lab_price_est:lab_price_est,
													lab_amt_est:lab_amt_est,
													lab_date:lab_date,
													lab_qty:lab_qty,
													lab_sponsor:lab_sponsor,
													lab_print_status:lab_print_status
												},
												success:function(data)
												{
													$('#labs_attend_form').trigger('reset');
													view_current_lab_attend();
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
				alert('Please select lab test!');
			};
		});
	}

	function edit_lab_attend()
	{
		$(document).on('click','#btn_lab_edit',function(){

			var lab_list_id = $(this).attr('data-id12');
			var currentRow=$(this).closest("tr");
			var lab = currentRow.find("td:eq(1)").text();
			$.ajax({  
					 url:'/layout/attendance/labs_list_param_count.php',  
					 type:'POST',  
					 data:{lab_list_id:lab_list_id},
					 datatype: 'JSON',
					 success:function(data){
						 var result = $.parseJSON(data);
						 var params = result[0];
						 var imgs = result[1];
						 if (params==0 && imgs==0)
						 {
							 $.ajax({  
								 url:'/layout/attendance/labs_attend_edit.php',  
								 type:'POST',  
								 data:{lab_list_id:lab_list_id},
								 datatype: 'JSON',
								 success:function(data){
									 var res = $.parseJSON(data);
									 $('#lab_date').val(res[0]);
									 $('#lab_id').val(res[1]);
									 $('#lab_attend_id').val(res[2]);
									$('#lab_patient_id').val(res[3]);
									$('#lab_list_id').val(res[4]);
									$('#lab_comment').val(res[5]);
									$('#lab_price_est').val(res[6]);
									 $('#lab_amt_est').val(res[7]);
									 $('#lab_qty').val(res[8]);
									$('#lab_sponsor').val(res[9]);
									$('#lab_print_status').val(res[10]);
									$('#lab_save_update').html('<button type="submit" name="lab_list_update_btn" id="lab_list_update_btn" class="btn btn-primary">Update</button>');
									$('#lab_list_save_btn').hide();
								 }
							 });
						 }
						 else
						 {
							 $('#lab_edit_decline_info').html('Please the Lab:'+lab+' has been performed. Editing is therefore declined!');
							$('#lab_edit_decline_modal').modal('show');
						 }
					 }  
				});
		  }); 
	}

	function update_lab_attend()
	{
		$(document).on('click','#lab_list_update_btn',function(){
			var lab_id = $('#lab_id').val();
			if (lab_id > 0) 
			{
			var lab_list_id = $('#lab_list_id').val();
			var lab_attend_id = $('#session_attend_id').val();
			var lab_patient_id = $('#session_patient_id').val();
			var lab_sponsor = $('#lab_sponsor').val();
			var lab_comment = $('#lab_comment').val();
			var lab_perform = $('#lab_perform').val();
			var lab_date = $('#lab_date').val();
			var lab_amt_est = $('#lab_amt_est').val();
			var lab_price_est = $('#lab_price_est').val();
			var lab_print_status = $('#lab_print_status').val();
			var lab_qty = $('#lab_qty').val();
			$.ajax({
				 url:'/layout/attendance/labs_attend_update.php',
				 method:'POST',
				 data:{
					 lab_list_id:lab_list_id,
					 lab_id:lab_id,
					 lab_attend_id:lab_attend_id,
					 lab_patient_id:lab_patient_id,
					 lab_comment:lab_comment,
					 lab_price_est:lab_price_est,
					 lab_amt_est:lab_amt_est,
					 lab_date:lab_date,
					 lab_qty:lab_qty,
					 lab_sponsor:lab_sponsor,
					lab_print_status:lab_print_status
				 },
				 success:function(data)
					 {
						 $('form').trigger('reset');
						 $('#labs_attend_modal').modal('hide');
						 view_current_lab_attend();
					 }
				 });
			} 
			else 
			{
				alert('Please select lab test!');
			};
		});
	}

	function view_current_lab_attend()
	{
		var attend_id = $('#session_attend_id').val();
		var patient_id = $('#session_patient_id').val();
		$.ajax(
		{
			url: '/layout/attendance/lab_attend_current_view.php',
			method: 'POST',
			data:{
					 attend_id:attend_id,
					 patient_id:patient_id
				 },
			success: function(data)
			{
				$('#attend_lab_table').html(data);
			}
		})
	}

	function lab_result_enter()
	{
		$(document).on('click','#btn_lab_result_enter',function(){
				var lab_list_id = $(this).attr('data-id4');
				var lab_id = $(this).attr('data-id5');
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				$.ajax({  
					 url:'/layout/attendance/lab_result_enter.php',  
					 method:'POST',  
					 data:{
						 lab_list_id:lab_list_id, 
						 lab_id:lab_id, 
						 attend_id:attend_id, 
						 patient_id:patient_id
					 },
					 success:function(data){
						 $('#labs_attend_result_enter_table').html(data);
						 $('#labs_attend_result_enter_modal').modal('show');
					 }  
				});
			});
	}

	function lab_result_perform_enter()
	{
		$(document).on('click','#btn_lab_perform_enter',function(){
				var lab_list_id = $(this).attr('data-id4');
				var lab_id = $(this).attr('data-id5');
				var lab_sponsor = $(this).attr('data-id');
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				var prvt_led_id = $('#session_prvt_led_id').val();
				$.ajax({  
					 url:'/layout/attendance/lab_result_perform_enter.php',  
					 method:'POST',  
					 data:{
						 lab_list_id:lab_list_id, 
						 lab_id:lab_id, 
						 attend_id:attend_id, 
						 patient_id:patient_id,
						 lab_sponsor:lab_sponsor,
						 prvt_led_id:prvt_led_id
					 },
					 success:function(data)
					 {
						 $('#labs_attend_result_perform_enter_table').html(data);
						 $('#labs_attend_result_perform_enter_modal').modal('show');
					 }  
				});
			});
	}

	function lab_result_save()
	{
		$(document).on('click','#labs_attend_result_enter_save_btn',function(){
			var lab_list_id = $(this).attr('data-id4');
			var lab_id = $(this).attr('data-id5');
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				url:'/layout/attendance/lab_result_save.php',
				method:'POST',  
				data:$('#labs_attend_result_enter_form').serialize(),
				success:function(data)
				{
					$('#labs_attend_result_enter_form').trigger('reset');
					$('#labs_attend_result_enter_modal').modal('hide');
					view_current_lab_attend();
				}
			});
		});
	}

	function lab_result_perform_save()
	{
		$(document).on('click','#labs_attend_result_perform_enter_save_btn',function(){
			var lab_list_id = $(this).attr('data-id4');
			var lab_id = $(this).attr('data-id5');
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				 url:'/layout/attendance/lab_result_perform_save.php',
				 method:'POST',
				 data:$('#labs_attend_result_perform_enter_form').serialize(),
				 success:function(data){
					 $('#labs_attend_result_perform_enter_form').trigger('reset');
					 $('#labs_attend_result_perform_enter_modal').modal('hide');
					 view_current_lab_attend();
				 }  
			});
		});
	}

	function lab_result_view()
	{
		$(document).on('click','#btn_lab_result_view, #btn_past_lab_view',function(){
				var lab_list_id = $(this).attr('data-id');
				var lab_id = $(this).attr('data-id1');
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				$.ajax({  
					 url:'/layout/attendance/lab_result_view.php',  
					 method:'POST',  
					 data:{
						 lab_list_id:lab_list_id, 
						 lab_id:lab_id, 
						 attend_id:attend_id, 
						 patient_id:patient_id
					 },
					 success:function(data){
						 $('#labs_attend_result_view_table').html(data);
						 $('#labs_attend_result_view_modal').modal('show');
					 }  
				});
			});
	}

	function lab_doctors_view()
	{
		$(document).on('click','#btn_lab_doc_view',function(){
				var lab_list_id = $(this).attr('data-id');
				var lab_id = $(this).attr('data-id1');
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				$.ajax({  
					 url:'/layout/attendance/lab_result_view.php',  
					 method:'POST',  
					 data:{
						 lab_list_id:lab_list_id, 
						 lab_id:lab_id, 
						 attend_id:attend_id, 
						 patient_id:patient_id
					 },
					 success:function(data){
						 $('#labs_attend_doctors_view_table').html(data);
						 $.ajax({  
							 url:'/layout/attendance/labs_attend_img_display.php',
							 method:'POST',
							 datatype: 'JSON',
							 data:{
								 attend_id:attend_id, 
								 patient_id:patient_id, 
								 lab_list_id:lab_list_id, 
								 lab_id:lab_id
							 },
							 success:function(data){
								 var result = $.parseJSON(data);
								 $('#lab_list_img_display_doctors').html('');
								 for(var i = 0; i < result.length; i++) {
									 $('#lab_list_img_display_doctors').append('<img src="'+result[i]+'" width="650" height="600">');
								};
							 }  
						});
						 $('#labs_attend_doctors_view_modal').modal('show');
					 }  
				});
			});
	}

	function lab_result_edit()
	{
		$(document).on('click','#btn_lab_perform_edit',function(){
				var lab_list_id = $(this).attr('data-id');
				var lab_id = $(this).attr('data-id1');
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				$.ajax({  
					 url:'/layout/attendance/lab_result_edit.php',  
					 method:'POST',  
					 data:{
						 lab_list_id:lab_list_id, 
						 lab_id:lab_id, 
						 attend_id:attend_id, 
						 patient_id:patient_id
					 },
					 success:function(data){
						 $('#labs_attend_result_edit_table').html(data);
						 $('#labs_attend_result_edit_modal').modal('show');
					 }  
				});
			});
	}

	function lab_result_update()
	{
		$(document).on('click','#labs_attend_result_update_btn',function(){
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				$.ajax({  
					 url:'/layout/attendance/lab_result_update.php',  
					 method:'POST',  
					 data:$('#labs_attend_result_edit_form').serialize(),
					 success:function(data){
						 $('#labs_attend_result_edit_form').trigger('reset');
						 $('#labs_attend_result_edit_modal').modal('hide');
						 view_current_lab_attend();
					 }  
				});
			});
	}

	function lab_attend_img_upload_modal()
	{
		$(document).on('click','#btn_lab_img_upload',function()
		{
			var lab_list_id = $(this).attr('data-id6');
			var lab_id = $(this).attr('data-id7');
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$('#labs_img_upload_form').trigger('reset');
			$('#lab_list_id_img').val(lab_list_id);
			$('#lab_id_img').val(lab_id);
			$('#attend_id_img').val(attend_id);
			$('#patient_id_img').val(patient_id);
			$('#labs_img_upload_modal_title').html('Upload Lab Image');
			$('#lab_list_img_update_btn').hide();
			$('#lab_list_img_save_btn').show();
			$('#labs_img_upload_modal').modal('show');
		}); 
	}

	function labs_attend_img_upload()
	{
		$(document).on('click','#lab_list_img_save_btn',function()
		{
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var lab_list_id = $('#lab_list_id_img').val();
			var lab_id = $('#lab_id_img').val();
			var file_size = $('#file_size').val();
			var lab_file_upload = $('#lab_file_upload_id').val();
			var comment = $('#lab_img_comment').val();
			$.ajax({  
					 url:'/layout/attendance/labs_attend_img_upload.php',
					 method:'POST',
					 enctype: 'multipart/form-data',
					 data:{
						 attend_id:attend_id, 
						 patient_id:patient_id, 
						 lab_list_id:lab_list_id, 
						 lab_id:lab_id,
						 file_size:file_size, 
						 lab_file_upload:lab_file_upload, 
						 comment:comment
					 },
					 success:function(data){
						 /*$('#labs_img_upload_form').trigger('reset');
						 $('#labs_img_upload_modal').modal('hide');
						 view_current_lab_attend();*/
					 }  
				});
		});
	}

	function labs_attend_img_display()
	{
		$(document).on('click','#btn_lab_img_view',function()
		{
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var lab_list_id = $(this).attr('data-id2');
			var lab_id = $(this).attr('data-id3');
			$.ajax({  
				 url:'/layout/attendance/labs_attend_img_display.php',
				 method:'POST',
				 datatype: 'JSON',
				 data:{
					 attend_id:attend_id, 
					 patient_id:patient_id, 
					 lab_list_id:lab_list_id, 
					 lab_id:lab_id
				 },
				 success:function(data){
					 var result = $.parseJSON(data);
					 $('#lab_list_img_display').html('');
					 for(var i = 0; i < result.length; i += 3) 
					 {
						 if(result[i+2] == 'pdf')
						 {
							 $('#lab_list_img_display').append('<iframe src="'+result[i]+'" width="1000" height="1100"></iframe><a href="#" id="delete_lab_image" data-id="'+result[i+1]+'" data-id1="'+attend_id+'" data-id2="'+patient_id+'" data-id3="'+lab_list_id+'" data-id4="'+lab_id+'">Clear</a>');
						 }
						 else
						 {
							 $('#lab_list_img_display').append('<img src="'+result[i]+'" width="1000" height="1100"><a href="#" id="delete_lab_image" data-id="'+result[i+1]+'" data-id1="'+attend_id+'" data-id2="'+patient_id+'" data-id3="'+lab_list_id+'" data-id4="'+lab_id+'">Clear</a>');
						 };
					 };
					$('#labs_img_display_modal').modal('show');
				 }  
			});
		}); 
	}
	
	function lab_attend_img_display_clear()
	{
		$(document).on('click','#delete_lab_image',function()
		{
			var lab_img_id = $(this).attr('data-id');
			var attend_id = $(this).attr('data-id1');
			var patient_id = $(this).attr('data-id2');
			var lab_list_id = $(this).attr('data-id3');
			var lab_id = $(this).attr('data-id4');
			$('#lab_attend_delete_question').text('Are you sure you want to delete this Lab Image?');
			$('#lab_attend_delete_modal').modal('show');
			$(document).on('click','#lab_attend_delete_yes',function()
			{
				$('#lab_attend_delete_modal').modal('hide');
				$.ajax({  
					url:'/layout/attendance/lab_attend_img_display_clear.php',
					method:'POST',
					datatype: 'JSON',
					data:{
					lab_img_id:lab_img_id,
					attend_id:attend_id
					},
					success:function(data)
					{
						if(data > 0)
						{
							$.ajax({  
								url:'/layout/attendance/labs_attend_img_display.php',
								method:'POST',
								datatype: 'JSON',
								data:{
									attend_id:attend_id, 
									patient_id:patient_id, 
									lab_list_id:lab_list_id, 
									lab_id:lab_id
								},
								success:function(data)
								{
									var result = $.parseJSON(data);
									$('#lab_list_img_display').html('');
									for(var i = 0; i < result.length; i += 3) 
									{
										if(result[i+2] == 'pdf')
										{
											$('#lab_list_img_display').append('<iframe src="'+result[i]+'" width="1000" height="1100"></iframe><a href="#" id="delete_lab_image" data-id="'+result[i+1]+'" data-id1="'+attend_id+'" data-id2="'+patient_id+'" data-id3="'+lab_list_id+'" data-id4="'+lab_id+'">Clear</a>');
										}
										else
										{
											$('#lab_list_img_display').append('<img src="'+result[i]+'" width="1000" height="1100"><a href="#" id="delete_lab_image" data-id="'+result[i+1]+'" data-id1="'+attend_id+'" data-id2="'+patient_id+'" data-id3="'+lab_list_id+'" data-id4="'+lab_id+'">Clear</a>');
										};
									};
									$('#labs_img_display_modal').modal('show');
								}
							});
						}
						else
						{
							window.location.href="/layout/attendance/lab_sheet.php";
							$('#labs_img_display_modal').modal('hide');
						};
					}
				});
			});
			$(document).on('click','#lab_attend_delete_no',function()
			{
				$('#lab_attend_delete_modal').modal('hide');
			});
			
		}); 
	}

	function lab_history()
	{
		$(document).on('click','#lab_attend_history_icon',function(){
				var patient_id = $('#session_patient_id').val();
				$.ajax({  
					 url:'/layout/attendance/lab_history.php',  
					 method:'POST',  
					 data:{
						 patient_id:patient_id
					 },
					 success:function(data){
						 $('#lab_history_list').html(data);
						 $('#lab_history_modal').modal('show');
					 }  
				});
			});
	}

	function lab_report_modal()
	{
		$(document).on('click','#lab_attend_report_icon',function()
		{
			var patient_id = $('#session_patient_id').val();
			var attend_id= $('#session_attend_id').val();
			$.ajax({  
				 url:'/layout/attendance/lab_report_processing.php',  
				 method:'POST',  
				 data:{
					 attend_id:attend_id, 
					 patient_id:patient_id
				 },
				 success:function(data){
					 window.open('/layout/attendance/lab_report_pdf.php', '_blank');
				 }  
			});
		});
	}

	function set_lab_price_and_amount()
	{
		$(document).on('change keyup','#lab_id,#lab_sponsor',function(){
			var sponsor_id = '';
			var sponsor_id = $('#lab_sponsor').val();
			var sponsor_default = $('#session_sponsor').val();
			var lab_id = $('#lab_id').val();
			var age = $('#session_age').val();
			var qty = $('#lab_qty').val();
			$.ajax(
				{
					url: '/layout/attendance/lab_price_set.php',
					method: 'POST',
					data:{
							 sponsor_id:sponsor_id,
							 lab_id:lab_id
						 },
					datatype: 'JSON',
					success: function(data)
					{
						var res = $.parseJSON(data);
						if (res[7] == 'cash')
						{
							//$('#lab_sponsor').val(sponsor_default);
							$('#lab_price_est').val(res[0]);
							$('#lab_amt_est').val(res[0] * qty);
						}
						else if (res[7] == 'nhia') 
						{
							if(age <= 11)
							{
								//$('#lab_sponsor').val(sponsor_default);
								$('#lab_price_est').val(res[4]);
								$('#lab_amt_est').val(res[4] * qty);
							}
							else
							{
								//$('#lab_sponsor').val(sponsor_default);
								$('#lab_price_est').val(res[4]);
								$('#lab_amt_est').val(res[4] * qty);
							}
						}
						else if (res[7] == 'nhia_na') 
						{
							//$('#lab_sponsor').val(1);
							$('#lab_price_est').val(res[0]);
							$('#lab_amt_est').val(res[0] * qty);
						}
						else if (res[7] == 'private_list') 
						{
							//$('#lab_sponsor').val(sponsor_default);
							$('#lab_price_est').val(res[6]);
							$('#lab_amt_est').val(res[6] * qty);
						}
						else if (res[7] == 'private_no_list') 
						{
							//$('#lab_sponsor').val(sponsor_default);
							$('#lab_price_est').val(0);
							$('#lab_amt_est').val(0);
						}
					}
				});
		});
	}

	function lab_attend_delete()
	{
		$(document).on('click','#btn_delete_lab_attend',function(){
			var lab_list_id = $(this).attr('data-id8');
			var attend_id = $('#session_attend_id').val();
			var currentRow = $(this).closest("tr");
			var lab = currentRow.find("td:eq(1)").text();
			$.ajax({
				url:'/layout/attendance/lab_attend_delete_check_perform.php',  
				type:'POST',
				dataType:'JSON',
				data:{lab_list_id:lab_list_id,attend_id:attend_id},
				success:function(data)
				{
					var result = $.parseJSON(data);
					if(result[0] == 'performed')
					{
						if(result[1] == 'Normal_User')
						{
							$('#lab_attend_delete_yes').hide();
							$('#lab_attend_delete_no').text('OK');
							$('#lab_attend_delete_question').text('The lab test ' + lab + ' has been performed by the Lab Technician, Deletion is therefore DECLINED!');
							$('#lab_attend_delete_modal').modal('show');
							$(document).on('click','#lab_attend_delete_no',function()
							{
								$('#lab_attend_delete_modal').modal('hide');
							});
						}
						else if(result[1] == 'Super_User' || result[1] == 'Ultra_Super_User')
						{
							$('#lab_attend_delete_question').text('Are you sure you want to delete ' + lab + '?');
							$('#lab_attend_delete_modal').modal('show');
							$(document).on('click','#lab_attend_delete_yes',function()
							{
								$.ajax({
									 url:'/layout/attendance/lab_attend_delete.php',  
									 type:'POST',  
									 data:{lab_list_id:lab_list_id,attend_id:attend_id},
									 success:function(data)
									 {
										 $('#lab_attend_delete_modal').modal('hide');
										 view_current_lab_attend();
									 }
								});
							});
							$(document).on('click','#lab_attend_delete_no',function(){
								$('#lab_attend_delete_modal').modal('hide');
							});
						};
					}
					else if(result[0] == 'empty')
					{
						$('#lab_attend_delete_question').text('Are you sure you want to delete ' + lab + '?');
						$('#lab_attend_delete_modal').modal('show');
						$(document).on('click','#lab_attend_delete_yes',function()
						{
							$.ajax({
								url:'/layout/attendance/lab_attend_delete.php',  
								type:'POST',  
								data:{lab_list_id:lab_list_id,attend_id:attend_id},
								success:function(data)
								{
									$('#lab_attend_delete_modal').modal('hide');
									view_current_lab_attend();
								}
							});
						});
						$(document).on('click','#lab_attend_delete_no',function(){
							$('#lab_attend_delete_modal').modal('hide');
						});
					};
				}
			   });
		});
	}

	function lab_print_status()
	{
		$(document).on('change','.lab_print',function(){
			var lab_list_id = $(this).closest('tr').attr('id');
			var print_status = $('#lab_print'+lab_list_id).val();
			$.ajax({  
				url:'/layout/attendance/labs_print_status.php',  
				type:'POST',  
				data:{
					lab_list_id:lab_list_id, 
					print_status:print_status
				},
				datatype: 'JSON',
				success:function()
				{
					view_current_lab_attend();
					location.reload();
				}
			});
		}); 
	}

	function lab_bill_status()
	{
		$(document).on('change','.lab_bill',function(){
			var lab_list_id = $(this).closest('tr').attr('id');
			var bill_status = $('#lab_bill'+lab_list_id).val();
			$.ajax({  
				url:'/layout/attendance/labs_bill_status.php',  
				type:'POST',  
				data:{
					lab_list_id:lab_list_id, 
					bill_status:bill_status
				},
				success:function(data)
				{
					view_current_lab_attend();
					location.reload();
				}
			});
		}); 
	}

	function lab_request_modal()
	{
		$(document).on('click','#nav_new_lab_request',function()
		{
			var attend_id = $('#session_attend_id').val();
			$.ajax({  
				url:'/layout/attendance/lab_request_process.php',  
				method:'POST',
				datatype:'JSON', 
				data:{attend_id:attend_id},
				success:function(data)
				{
					var res = $.parseJSON(data);
					$('#lab_request_id').val(res[0]);
					$('#lab_request_patient').val(res[1]);
					$('#lab_request_patientD').val(res[1]);
					$('#lab_request_doctor').val(res[2]);
					$('#lab_request_diagnosis').val(res[3]);
					$('#lab_request_age').val(res[4]);
					$('#lab_request_test').val(res[5]);
					$('#lab_request_date').val(res[6]);
					$('#lab_request_specimen').val(res[7]);
					$('#lab_request_specimen_date').val(res[8]);
					$('#lab_request_clinical_summary').val(res[9]);
					$('#lab_request_gender').val(res[10]);
					if(res[11] == 'new')
					{
						$('#lab_request_save').show();
						$('#lab_request_update').hide();
					}
					else if(res[11] == 'exist')
					{
						$('#lab_request_save').hide();
						$('#lab_request_update').show();
					};
					$('#lab_request_modal').modal('show');
				}
			});
		});
	}
	
	function lab_request_save()
	{
		$(document).on('click','#lab_request_save',function(e)
		{
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				url:'/layout/attendance/lab_request_save.php',
				method:'POST',
				data:$('#lab_request_modal_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				success:function(data)
				{
					$('#lab_request_modal_form').trigger('reset');
					$('#lab_request_modal').modal('hide');
					window.open('/layout/attendance/lab_request_pdf.php', '_blank');
				}
			});
		});
	}

	function lab_request_update()
	{
		$(document).on('click','#lab_request_update',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				url:'/layout/attendance/lab_request_update.php',
				method:'POST',
				data:$('#lab_request_modal_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				success:function(data)
				{
					$('#lab_request_modal_form').trigger('reset');
					$('#lab_request_modal').modal('hide');
					window.open('/layout/attendance/lab_request_pdf.php', '_blank');
				}
			});
		});
	}

	function search_lab_list_modal()
	{
		$(document).on('click','#btn_lab_live_search',function()
		{
			$('#lab_list_search_modal_form').trigger('reset');
			$('#lab_list_search').focus();
			$('#lab_list_search_modal').modal('show');
		});
	}

	function search_lab_list_attend()
	{
		$(document).on('keyup','#lab_list_search',function()
		{
			var search = $(this).val();
			$.ajax({
				url:'/layout/attendance/lab_attend_search.php',
				method:"POST",
				data:{search:search},
				success:function(data)
				{
					$('#lab_list_search_table').html(data);
				}
			})
		});
	}

	function search_lab_list_save()
	{
		$(document).on('click','#btn_save_lab_search_item',function()
		{
			var lab_id = $(this).attr('data-id');
			var lab_date = $('#lab_date').val();
			var lab_sponsor = $('#lab_sponsor').val();
			var lab_attend_id = $('#session_attend_id').val();
			var lab_patient_id = $('#session_patient_id').val();
			var lab_comment = $('#lab_comment').val();
			var lab_perform = $('#lab_perform').val();
			var lab_amt_est = $(this).attr('data-id1');
			var lab_price_est = $(this).attr('data-id1');
			var lab_print_status = $('#lab_print_status').val();
			var lab_qty = $('#lab_qty').val();
			
			if (lab_id > 0) 
			{
				if (lab_date !="") 
				{
					$.ajax({
						url:'/layout/attendance/lab_check_duplicate.php',
						method:'POST',
						data:{
							lab_attend_id:lab_attend_id,
							lab_id:lab_id
						},
						datatype:'JSON',
						success:function(data)
						{
							var res = $.parseJSON(data);
							if (res[0] == 'duplicate') 
							{
								$('#lab_list_duplicate_question').text('The Lab Test:'+ res[1] + ' has been selected earlier! Do you want to duplicate the Lab Test?');
								$('#lab_list_duplicate_modal').modal('show');
								$(document).on('click','#lab_list_duplicate_yes',function()
								{
									$.ajax({
										url:'/layout/attendance/labs_attend_save.php',
										method:'POST',
										data:{
											lab_id:lab_id,
											lab_attend_id:lab_attend_id,
											lab_patient_id:lab_patient_id,
											lab_comment:lab_comment,
											lab_price_est:lab_price_est,
											lab_amt_est:lab_amt_est,
											lab_date:lab_date,
											lab_qty:lab_qty,
											lab_sponsor:lab_sponsor,
											lab_print_status:lab_print_status
										},
										success:function(data)
										{
											$('#lab_list_search_modal_form').trigger('reset');
											$('#lab_list_search').focus();
											$('#labs_attend_form').trigger('reset');
											view_current_lab_attend();
											location.reload();
										}
									});
									
								});
								$(document).on('click','#lab_list_duplicate_no',function(){
									$('#lab_list_duplicate_modal').modal('hide');
								});
							} 
							else if(res[0] == 'none') 
							{
								$.ajax({
									url:'/layout/attendance/labs_attend_save.php',
									method:'POST',
									data:{
										lab_id:lab_id,
										lab_attend_id:lab_attend_id,
										lab_patient_id:lab_patient_id,
										lab_comment:lab_comment,
										lab_price_est:lab_price_est,
										lab_amt_est:lab_amt_est,
										lab_date:lab_date,
										lab_qty:lab_qty,
										lab_sponsor:lab_sponsor,
										lab_print_status:lab_print_status
									},
									success:function(data)
									{
										$('#lab_list_search_modal_form').trigger('reset');
										$('#lab_list_search').focus();
										$('#labs_attend_form').trigger('reset');
										view_current_lab_attend();
									}
								});
							};
						}
					});
				} 
				else 
				{
					alert('Please enter date!');
				};
			} 
			else 
			{
				alert('Please select lab test!');
			};
		});
	}
