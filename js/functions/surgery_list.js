$(document).ready(function()
{
	//SURGERIES AND PROCEDURES
		go_to_surgery_sheet();
		save_attend_surgery();
		edit_surgery_attend();
		update_surgery_attend();
		view_current_surgery();
		view_surgery_history();
		open_operation_note_modal();
		add_scrub_nurse();
		add_assist_surgeon();
		delete_scrub_nurse();
		delete_assist_surgeon();
		save_operation_notes();
		edit_operation_notes();
		update_operation_notes();
		open_anesthesia_modal();
		add_anest_technique();
		add_assist_anest();
		delete_anest_technique();
		delete_assist_anest();
		save_anesthesia();
		edit_anesthesia();
		update_anesthesia();
		consent_upload_div();
		consent_form_pdf();
		//consent_img_display();
		open_past_operation_note_modal();
		open_past_anesthesia_modal();
		set_surgery_price_and_amount();
		surgery_attend_delete();
});

	//SURGERY
	function go_to_surgery_sheet()
	{
		$(document).on('click','#nav_surgery',function()
		{
			window.location.href="/layout/attendance/surgery_sheet.php";
			$('#surgery_attend_form').trigger('reset');
		}) 
	}

	function save_attend_surgery()
	{
		$(document).on('click','#surgery_attend_save_btn',function(e){
			e.preventDefault();
			var surgery_id = $('#attend_surgery_id').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var age = $('#session_age').val();
			var clinic = $('#session_clinic').val();
			var tos = $('#session_typeofservice_attd').val();
			var procqty = $('#procqty').val();
			var proc_price_cash = $('#proc_price_cash').val();
			var proc_price_prvt = $('#proc_price_prvt').val();
			var proc_price_nhis = $('#proc_price_nhis').val();
			var proc_amt_cash = $('#proc_amt_cash').val();
			var proc_amt_prvt = $('#proc_amt_prvt').val();
			var proc_amt_nhis = $('#proc_amt_nhis').val();
			var surgery_date = $('#surgery_date').val();
			var surgery_sponsor = $('#surgery_sponsor').val();
			var surgery_comment = $('#surgery_comment').val();
			var prvt_led_id = $('#session_prvt_led_id').val();
			
			if (surgery_id !=="" && surgery_id > 0) 
			{
				//if (surgery_sponsor !=="" && surgery_sponsor > 0) 
				//{
					if (surgery_date !=="") 
					{
						$.ajax({
							url:'/layout/attendance/surgery_check_duplicate.php',
							method:'POST',
							data:{
								attend_id:attend_id,
								surgery_id:surgery_id
							},
							datatype:'JSON',
							success:function(data)
							{
								var res = $.parseJSON(data);
								if (res[0] == 'duplicate') 
								{
									$('#surgery_list_duplicate_question').text('The Surgery:'+ res[1] + ' has been selected earlier! Do you want to duplicate the Surgery?');
									$('#surgery_list_duplicate_modal').modal('show');
									$(document).on('click','#surgery_list_duplicate_yes',function(){
										$.ajax({
											url:'/layout/attendance/surgery_save.php',
											method:'POST',
											data:{
												surgery_id:surgery_id,
												attend_id:attend_id,
												patient_id:patient_id,
												procqty:procqty,
												proc_price_cash:proc_price_cash,
												proc_price_prvt:proc_price_prvt,
												proc_price_nhis:proc_price_nhis,
												proc_amt_cash:proc_amt_cash,
												proc_amt_prvt:proc_amt_prvt,
												proc_amt_nhis:proc_amt_nhis,
												surgery_date:surgery_date,
												surgery_sponsor:surgery_sponsor,
												surgery_comment:surgery_comment,
												prvt_led_id:prvt_led_id,
												clinic:clinic,
												age:age,
												tos:tos
											},
											success:function(data)
											{
											$('#surgery_attend_form').trigger('reset');
											$('#attend_surgery_table').html(data);
											location.reload();
											}
										});
									});
									$(document).on('click','#surgery_list_duplicate_no',function(){
										$('#surgery_list_duplicate_modal').modal('hide');
									});
								} 
								else if(res[0] == 'none') 
								{
									$.ajax({
										url:'/layout/attendance/surgery_save.php',
										method:'POST',
										data:{
											surgery_id:surgery_id,
											attend_id:attend_id,
											patient_id:patient_id,
											procqty:procqty,
											proc_price_cash:proc_price_cash,
											proc_price_prvt:proc_price_prvt,
											proc_price_nhis:proc_price_nhis,
											proc_amt_cash:proc_amt_cash,
											proc_amt_prvt:proc_amt_prvt,
											proc_amt_nhis:proc_amt_nhis,
											surgery_date:surgery_date,
											surgery_sponsor:surgery_sponsor,
											surgery_comment:surgery_comment,
											prvt_led_id:prvt_led_id,
											clinic:clinic,
											age:age,
											tos:tos
										},
										success:function(data)
										{
											$('#surgery_attend_form').trigger('reset');
											$('#attend_surgery_table').html(data);
											location.reload();
										}
									});
								};
							}
						});
					} 
					else 
					{
						alert('Please select the Date this surgery!');
					};
				/*} 
				else 
				{
					alert('Please select the Sponsor this surgery!');
				};*/
			} 
			else 
			{
				alert('Please select a surgery or procedure!');
			};
			
		});
	}

	function edit_surgery_attend()
	{
		$(document).on('click','#btn_edit_surgery_attend',function(){

			var surgery_list_id = $(this).attr('data-id1');

				$.ajax({  
					 url:'/layout/attendance/surgery_edit.php',  
					 type:'POST',  
					 data:{surgery_list_id:surgery_list_id},
					 datatype: 'JSON',
					 success:function(data)
					 {
						 var res = $.parseJSON(data);
						 $('#surgery_list_id').val(res[0]);
						 $('#attend_surgery_id').val(res[1]);
						 $('#surgery_comment').val(res[2]);
						$('#procqty').val(res[3]);
						$('#proc_price_cash').val(res[4]);
						$('#proc_amt_cash').val(res[5]);
						 $('#proc_amt_prvt').val(res[6]);
						$('#proc_amt_nhis').val(res[7]);
						$('#proc_price_prvt').val(res[8]);
						$('#proc_price_nhis').val(res[9]);
						$('#surgery_date').val(res[10]);
						$('#surgery_spondor').val(res[11]);
						$('#surgery_save_update').html('<button id="surgery_attend_update_btn" class="btn btn-primary">Update</button>');
					 }  
				});
		  }); 
	}

	function update_surgery_attend()
	{
		$(document).on('click','#surgery_attend_update_btn',function()
		{
			var surgery_list_id = $('#surgery_list_id').val();
			var surgery_id = $('#attend_surgery_id').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var procqty = $('#procqty').val();
			var proc_price_cash = $('#proc_price_cash').val();
			var proc_price_prvt = $('#proc_price_prvt').val();
			var proc_price_nhis = $('#proc_price_nhis').val();
			var proc_amt_cash = $('#proc_amt_cash').val();
			var proc_amt_prvt = $('#proc_amt_prvt').val();
			var proc_amt_nhis = $('#proc_amt_nhis').val();
			var surgery_date = $('#surgery_date').val();
			var surgery_sponsor = $('#surgery_sponsor').val();
			var surgery_comment = $('#surgery_comment').val();
			var age = $('#session_age').val();
			var clinic = $('#session_clinic').val();
			var tos = $('#session_typeofservice_attd').val();
			
			$.ajax({
				url:'/layout/attendance/surgery_update.php', 
				method:'POST',
				data:{
					surgery_list_id:surgery_list_id,
					surgery_id:surgery_id,
					attend_id:attend_id,
					patient_id:patient_id,
					procqty:procqty,
					proc_price_cash:proc_price_cash,
					proc_price_prvt:proc_price_prvt,
					proc_price_nhis:proc_price_nhis,
					proc_amt_cash:proc_amt_cash,
					proc_amt_prvt:proc_amt_prvt,
					proc_amt_nhis:proc_amt_nhis,
					surgery_date:surgery_date,
					surgery_sponsor:surgery_sponsor,
					surgery_comment:surgery_comment,
					clinic:clinic,
					age:age,
					tos:tos
				},
				success:function(data)
				{
					$('#surgery_attend_form').trigger('reset');
					$('#surgery_save_update').html('<button id="surgery_attend_save_btn" class="btn btn-primary">Save</button>');
					$('#attend_surgery_table').html(data);
				}
			});
		});
	}

	function view_current_surgery()
	{
		var attend_id = $('#session_attend_id').val();
		var age = $('#session_age').val();
		$.ajax(
		{
			url: '/layout/attendance/surgery_current_view.php',
			method: 'POST',
			data:{
					 attend_id:attend_id,
					age:age
				 },
			success: function(data)
			{
				$('#attend_surgery_table').html(data);
			}
		})
	}

	function view_surgery_history()
	{
		$(document).on('click','#surgery_history_icon',function(){
			
			var patient_id = $('#session_patient_id').val();
			$.ajax(
			{
				url: '/layout/attendance/surgery_history_view.php',
				method: 'POST',
				data:{
						 patient_id:patient_id
					 },
				success: function(data)
				{
					$('#attend_surgery_history_table').html(data);
					$('#surgery_history_modal').modal('show');
				}
			})
		});
	}

	function open_operation_note_modal()
	{
		$(document).on('click','#btn_enter_opt_notes',function(){
			var surgery_list_id = $(this).attr('data-id1');
			var surgery_id = $(this).attr('data-id2');
			$('#surgery_list_id_op').val(surgery_list_id);
			$('#surgery_id_op').val(surgery_id);
			$('#surgery_opt_note_save_btn').show();
			$('#surgery_opt_note_update_btn').hide();
			$('#surgery_opt_note_form').trigger("reset");
			$('#assistant_surgeon_table').html('<tr><th colspan="2"><a href="#" id="add_assist_surg_link">Assistant Surgeon</a></th></tr><tr id="row_as1"><td><input type="text" name="assistant_surgeon[]" class="form-control bg-light" id="assistant_surgeon"><input type="hidden" name="op_assist_surg_id[]" class="form-control bg-light" id="op_assist_surg_id"></td><td><a href="#" id="delete_assist_surg_link" data-id="1"><i class="fa fa-trash fa-sm"></i></a></td></tr>');
			$('#scrub_nurse_table').html('<tr><th colspan="2"><a href="#" id="add_scrub_nurse_link">Scrub Nurses</a></th></tr><tr id="row_sn1"><td><input type="text" name="scrub_nurse[]" class="form-control bg-light" id="scrub_nurse"><input type="hidden" name="op_scrub_nurse_id[]" class="form-control bg-light" id="op_scrub_nurse_id"></td><td><a href="#" id="delete_scrub_nurse_link" data-id="1"><i class="fa fa-trash fa-sm"></i></a></td></tr>');
			$('#surgery_opt_notes_modal').modal('show');
		});
	}

	function add_scrub_nurse()
	{
		var i=1;  
		$(document).on('click','#add_scrub_nurse_link',function(){ 
			i++;  
				$('#scrub_nurse_table').append(
				'<tr id="row_sn'+i+'"><td><input type="text" name="scrub_nurse[]" class="form-control bg-light" id="scrub_nurse"><input type="hidden" name="op_scrub_nurse_id[]" class="form-control bg-light" id="op_scrub_nurse_id"></td><td><a href="#" id="delete_scrub_nurse_link" data-id="'+i+'"><i class="fa fa-trash fa-sm"></i></a></td></tr>');
		});
	}

	function delete_scrub_nurse()
	{
		$(document).on('click', '#delete_scrub_nurse_link', function(){  
			   var button_id = $(this).attr("data-id");   
			   $('#row_sn'+button_id+'').remove();
		   });
	}

	function add_assist_surgeon()
	{
		var i=1;  
		$(document).on('click','#add_assist_surg_link',function(){ 
			i++;  
				$('#assistant_surgeon_table').append(
				'<tr id="row_as'+i+'"><td><input type="text" name="assistant_surgeon[]" class="form-control bg-light" id="assistant_surgeon"><input type="hidden" name="op_assist_surg_id[]" class="form-control bg-light" id="op_assist_surg_id"></td><td><a href="#" id="delete_assist_surg_link" data-id="'+i+'"><i class="fa fa-trash fa-sm"></i></a></td></tr>');
		});
	}

	function delete_assist_surgeon()
	{
		$(document).on('click', '#delete_assist_surg_link', function(){  
			   var button_id = $(this).attr("data-id");   
			   $('#row_as'+button_id+'').remove();
		   });
	}

	function save_operation_notes()
	{
		$(document).on('click','#surgery_opt_note_save_btn',function(e){
			e.preventDefault();
			var surgery_procedure = $('#surgery_procedure').val();
			if (surgery_procedure !=="") 
				{
					var attend_id = $('#session_attend_id').val();
					var patient_id = $('#session_patient_id').val();
					$.ajax({
						 url:'/layout/attendance/surgery_save_op_notes.php',
						 method:'POST',
						 data:$('#surgery_opt_note_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
						 success:function(data)
							 {
								 $('#surgery_attend_form').trigger('reset');
								 $('#surgery_opt_notes_modal').modal('hide');
								 view_current_surgery();
							 }
						 });
				} 
				else 
				{
					alert('Please type procedure!');
				}
			
		});
	}

	function edit_operation_notes()
	{
		$(document).on('click','#btn_view_opt_notes',function(){
			var surgery_list_id = $(this).attr('data-id1');
			$.ajax({
				 url:'/layout/attendance/surgery_edit_op_notes.php',
				 method:'POST',
				 data:{surgery_list_id:surgery_list_id},
				 datatype:'JSON',
				 success:function(data)
					 {
						 var res = $.parseJSON(data);
						 $('#surgery_optnote_id').val(res[0]);
						 $('#surgery_date_start').val(res[3]);
						 $('#surgery_date_end').val(res[4]);
						 $('#surgery_time_start').val(res[5]);
						 $('#surgery_time_end').val(res[6]);
						 $('#surgery_head').val(res[7]);
						 $('#surgery_findings').val(res[8]);
						 $('#surgery_procedure').val(res[9]);
						 $('#surgery_id_op').val(res[10]);
						 $('#surgery_list_id_op').val(res[11]);
						 var opnote_id = res[0];
						 $.ajax({
							 url:'/layout/attendance/surgery_edit_assist_surgeon.php',
							 method:'POST',
							 data:{opnote_id:opnote_id},
							 success:function(data)
								{
									$('#assistant_surgeon_table').html(data);
								}
						 });
						 $.ajax({
							 url:'/layout/attendance/surgery_edit_scrub_nurses.php',
							 method:'POST',
							 data:{opnote_id:opnote_id},
							 success:function(data)
								{
									$('#scrub_nurse_table').html(data);
								}
						 });
						 $('#surgery_opt_note_update_btn').show();
						 $('#surgery_opt_note_save_btn').hide();
						$('#surgery_opt_notes_modal').modal('show');
					 }
				 });
		});
	}

	function update_operation_notes()
	{
		$(document).on('click','#surgery_opt_note_update_btn',function(){
			var surgery_procedure = $('#surgery_procedure').val();
			if (surgery_procedure !=="") 
				{
					var attend_id = $('#session_attend_id').val();
					var patient_id = $('#session_patient_id').val();
					$.ajax({
						 url:'/layout/attendance/surgery_update_op_notes.php',
						 method:'POST',
						 data:$('#surgery_opt_note_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
						 success:function(data)
							 {
								 $('#surgery_attend_form').trigger('reset');
								 $('#surgery_opt_notes_modal').modal('hide');
								 view_current_surgery();
							 }
						 });
				} 
				else 
				{
					alert('Please type procedure!');
				}
			
		});
	}

	function open_anesthesia_modal()
	{
		$(document).on('click','#btn_enter_anesthesia',function(){
			var surgery_list_id = $(this).attr('data-id1');
			var surgery_id = $(this).attr('data-id2');
			$('#surgery_list_id_anes').val(surgery_list_id);
			$('#surgery_id_anes').val(surgery_id);
			$('#surgery_anesthesia_update_btn').hide();
			$('#surgery_anesthesia_form').trigger("reset");
			$('#anest_tech_table').html('<tr><th><a href="#" id="add_anest_tech_link">Technique</a></th><th>Tech. Date</th><th colspan="4">Tech. Time</th></tr><tr id="row_at1"><td><select class="form-control bg-light" name="anest_tech_desc[]" id="anest_tech_desc"><option value="0">Please Select</option><option value="Combined">Combined</option><option value="General">General</option><option value="Local">Local</option><option value="Nerve_Blk">Nerve Blk</option><option value="Spinal">Spinal</option></select><input type="hidden" name="anest_tech_id []" class="form-control bg-light" id="anest_tech_id "></td><td><input type="date" name="anest_tech_date[]" class="form-control bg-light" id="anest_tech_date"></td><td><input type="time" name="anest_tech_time[]" class="form-control bg-light" id="anest_tech_time"></td><td><a href="#" id="delete_anest_tech_link" data-id="1"><i class="fa fa-trash fa-sm"></i></a></td></tr>');
			$('#assist_anest_table').html('<tr><th colspan="2"><a href="#" id="add_assist_anest_link">Assistant Anesthetist</a></th></tr><tr id="row_aa1"><td><input type="text" name="assistant_anesthetist[]" class="form-control bg-light" id="assistant_anesthetist"><input type="hidden" name="anest_assist_id []" class="form-control bg-light" id="anest_assist_id "></td><td><a href="#" id="delete_assist_anest_link" data-id="1"><i class="fa fa-trash fa-sm"></i></a></td></tr>');
			$('#surgery_anesthesia_modal').modal('show');
		});
	}

	function add_anest_technique()
	{
		var i=1;  
		$(document).on('click','#add_anest_tech_link',function(){ 
			i++;  
				$('#anest_tech_table').append(
				'<tr id="row_at'+i+'"><td><select class="form-control bg-light" name="anest_tech_desc[]" id="anest_tech_desc"><option value="0">Please Select</option><option value="Combined">Combined</option><option value="General">General</option><option value="Local">Local</option><option value="Nerve_Blk">Nerve Blk</option><option value="Spinal">Spinal</option></select><input type="hidden" name="anest_tech_id []" class="form-control bg-light" id="anest_tech_id "></td><td><input type="date" name="anest_tech_date[]" class="form-control bg-light" id="anest_tech_date"></td><td><input type="time" name="anest_tech_time[]" class="form-control bg-light" id="anest_tech_time"></td><td><a href="#" id="delete_anest_tech_link" data-id="'+i+'"><i class="fa fa-trash fa-sm"></i></a></td></tr>');
		});
	}

	function add_assist_anest()
	{
		var i=1;  
		$(document).on('click','#add_assist_anest_link',function(){ 
			i++;  
				$('#assist_anest_table').append(
				'<tr id="row_aa'+i+'"><td><input type="text" name="assistant_anesthetist[]" class="form-control bg-light" id="assistant_anesthetist"><input type="hidden" name="anest_assist_id []" class="form-control bg-light" id="anest_assist_id "></td><td><a href="#" id="delete_assist_anest_link" data-id="'+i+'"><i class="fa fa-trash fa-sm"></i></a></td></tr>');
		});
	}

	function delete_anest_technique()
	{
		$(document).on('click', '#delete_anest_tech_link', function(){  
			   var button_id = $(this).attr("data-id");   
			   $('#row_at'+button_id+'').remove();
		   });
	}

	function delete_assist_anest()
	{
		$(document).on('click', '#delete_assist_anest_link', function(){  
			   var button_id = $(this).attr("data-id");   
			   $('#row_aa'+button_id+'').remove();
		   });
	}

	function save_anesthesia()
	{
		$(document).on('click','#surgery_anesthesia_save_btn',function(e){
			e.preventDefault();
			var surgery_rscp = $('#surgery_rscp').val();
			if (surgery_rscp !=="") 
				{
					var attend_id = $('#session_attend_id').val();
					var patient_id = $('#session_patient_id').val();
					$.ajax({
						 url:'/layout/attendance/surgery_save_anesthesia.php',
						 method:'POST',
						 data:$('#surgery_anesthesia_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
						 success:function(data)
							 {
								 $('#surgery_anesthesia_form').trigger('reset');
								 $('#surgery_anesthesia_modal').modal('hide');
								 view_current_surgery();
							 }
						 });
				} 
				else 
				{
					alert('Please type Anesthesia!');
				}
			
		});
	}

	function edit_anesthesia()
	{
		$(document).on('click','#btn_edit_anesthesia',function(){
			var surgery_list_id = $(this).attr('data-id1');
			$.ajax({
				 url:'/layout/attendance/surgery_edit_anesthesia.php',
				 method:'POST',
				 data:{surgery_list_id:surgery_list_id},
				 datatype:'JSON',
				 success:function(data)
					 {
						 var res = $.parseJSON(data);
						 $('#surgery_anest_id').val(res[0]);
						 $('#surgery_anesthetist').val(res[1]);
						 $('#surgery_exubated').val(res[2]);
						 $('#surgery_exubated_date').val(res[3]);
						 $('#surgery_exubated_time').val(res[4]);
						 $('#surgery_mask').val(res[5]);
						 $('#surgery_mask_date').val(res[6]);
						 $('#surgery_mask_time').val(res[7]);
						 $('#surgery_blood_req').val(res[8]);
						 $('#surgery_rscp').val(res[9]);
						 $('#surgery_airway').val(res[10]);
						 $('#surgery_etmethod').val(res[11]);
						 $('#surgery_intubation').val(res[12]);
						 $('#surgery_tube_type').val(res[13]);
						 $('#surgery_tube_size').val(res[14]);
						 $('#surgery_taped').val(res[15]);
						 $('#surgery_blade_size').val(res[16]);
						 $('#surgery_blade_type').val(res[17]);
						 $('#surgery_eye').val(res[18]);
						 $('#surgery_circuit').val(res[19]);
						 $('#surgery_crystaloids').val(res[20]);
						 $('#surgery_colloid').val(res[21]);
						 $('#surgery_prbc').val(res[22]);
						 $('#surgery_platelets').val(res[23]);
						 $('#surgery_others').val(res[24]);
						 $('#surgery_ebl').val(res[25]);
						 $('#surgery_urine_output').val(res[26]);
						 $('#surgery_path_req').val(res[27]);
						 $('#surgery_usa').val(res[28]);
						 $('#surgery_id_anes').val(res[29]);
						 $('#surgery_list_id_anes').val(res[30]);
						 $('#surgery_anest_remarks').val(res[31]);
						 var anest_id = res[0];
						 $.ajax({
							url:'/layout/attendance/surgery_edit_assist_anest.php',
							method:'POST',
							data:{anest_id:anest_id},
							success:function(data)
							{
								$('#assist_anest_table').html(data);
							}
						});
						 $.ajax({
							 url:'/layout/attendance/surgery_edit_anest_tech.php',
							 method:'POST',
							 data:{anest_id:anest_id},
							 success:function(data)
								{
									$('#anest_tech_table').html(data);
								}
						 });
						 $('#surgery_anesthesia_update_btn').show();
						 $('#surgery_anesthesia_save_btn').hide();
						$('#surgery_anesthesia_modal').modal('show');
					 }
				 });
		});
	}

	function update_anesthesia()
	{
		$(document).on('click','#surgery_anesthesia_update_btn',function(e){
			e.preventDefault();
			var surgery_rscp = $('#surgery_rscp').val();
			if (surgery_rscp !=="") 
				{
					var attend_id = $('#session_attend_id').val();
					var patient_id = $('#session_patient_id').val();
					$.ajax({
						 url:'/layout/attendance/surgery_update_anesthesia.php',
						 method:'POST',
						 data:$('#surgery_anesthesia_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
						 success:function(data)
							 {
								 $('#surgery_anesthesia_form').trigger('reset');
								 $('#surgery_anesthesia_modal').modal('hide');
								 view_current_surgery();
							 }
						 });
				} 
				else 
				{
					alert('Please type Anesthesia!');
				}
			
		});
	}

	function consent_upload_div()
	{
		$(document).on('click','#consent_form_icon',function()
		{
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var surgery_id = $(this).attr('data-id2');
			var surgery_list_id = $(this).attr('data-id1');
			function consent_img_display()
			{
				$.ajax({  
					 url:'/layout/attendance/surgery_consent_form_img_display.php',
					 method:'POST',
					 datatype: 'JSON',
					 data:{
						 attend_id:attend_id, 
						 patient_id:patient_id,
						 surgery_id:surgery_id,
						 surgery_list_id:surgery_list_id
					 },
					 success:function(data)
					 {
						var result = $.parseJSON(data);
						 $('#consent_img_display').html('');
						 for(var i = 0; i < result.length; i++) 
						 {
							 $('#consent_img_display').append('<img src="'+result[i]+'" width="750" height="800">');
						};
					 }  
				});
			}

			$.ajax(
			{
				url: '/layout/attendance/surgery_consent_upload_div.php',
				method: 'POST',
				data:{
					attend_id:attend_id,
					patient_id:patient_id,
					surgery_id:surgery_id,
					surgery_list_id:surgery_list_id
				},
				success: function(data)
				{
					if (data == 'none') 
					{
						$('#consent_upload_div').show();
						$('#consent_attend_id').val(attend_id);
						$('#consent_patient_id').val(patient_id);
						$('#consent_form_surgery_id').val(surgery_id);
						$('#consent_form_surgery_list_id').val(surgery_list_id);
						$('#consent_form_modal_title').html('Upload Consent Form Image');
						$('#consent_upload_view_div').hide();
						$('#consent_form_modal').modal('show');
					}
					else if (data == 'created')
					{
						consent_img_display();
						$('#consent_uplaod_edit').html('<button type="submit" name="consent_img_edit_btn" id="consent_img_edit_btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>');
						$('#consent_upload_view_div').show();
						$('#consent_img_display').show();
						$('#consent_form_modal_title').html('Display Consent Form Image');
						$('#consent_upload_div').hide();
						$('#consent_form_modal').modal('show');
					}
					else if (data == 'no_surgery')
					{
						$('#consent_upload_div').hide();
						$('#consent_upload_view_div').hide();
						$('#consent_uplaod_edit').hide();
					};
				}
			});
		});
	}

	function consent_form_pdf()
	{
		$(document).on('click','#consent_form_pdf_icon',function(){
			var currentRow=$(this).closest("tr");
			var surgery = currentRow.find("td:eq(1)").text();
			var surgery_list_id = $(this).attr('data-id1');
			var surgery_id = $(this).attr('data-id2');
			var patient_id = $(this).attr('data-id3');
			var attend_id = $(this).attr('data-id4');
			$.ajax({  
				url:'/layout/attendance/surgery_consent_form_pdf_processing.php',  
				type:'POST',  
				data:{
					surgery_list_id:surgery_list_id,
					surgery_id:surgery_id,
					surgery:surgery,
					attend_id:attend_id,
					patient_id:patient_id
				},
				success:function(){
					window.open('/layout/attendance/surgery_consent_form_pdf.php', '_blank');
				}  
			});
		});
	}

	function open_past_operation_note_modal()
	{
		$(document).on('click','#btn_view_opt_notes_sh',function(){
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var surgery_list_id = $(this).attr('data-id1');
			var surgery_id = $(this).attr('data-id2');
			$.ajax({  
				 url:'/layout/attendance/surgery_past_op_notes.php',
				 method:'POST',
				 datatype: 'JSON',
				 data:{
					 attend_id:attend_id, 
					 patient_id:patient_id,
					 surgery_list_id:surgery_list_id,
					 surgery_id:surgery_id
				 },
				 success:function(data){
					 $('#past_surgery_opt_notes_view').html(data);
					$('#past_surgery_opt_notes_modal').modal('show');
				 }  
			});
		});
	}

	function open_past_anesthesia_modal()
	{
		$(document).on('click','#btn_view_anesthesia_sh',function(){
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var surgery_list_id = $(this).attr('data-id1');
			var surgery_id = $(this).attr('data-id2');
			$.ajax({  
				 url:'/layout/attendance/surgery_past_anesthesia.php',
				 method:'POST',
				 datatype: 'JSON',
				 data:{
					 attend_id:attend_id, 
					 patient_id:patient_id,
					 surgery_list_id:surgery_list_id,
					 surgery_id:surgery_id
				 },
				 success:function(data){
					 $('#past_surgery_opt_notes_view').html(data);
					$('#past_surgery_opt_notes_modal').modal('show');
				 }  
			});
		});
	}

	function set_surgery_price_and_amount()
	{
		$(document).on('change keyup','#attend_surgery_id,#surgery_sponsor',function(){
			var sponsor_id = '';
			var sponsor_id = $('#surgery_sponsor').val();
			var sponsor_default = $('#session_sponsor').val();
			var surgery_id = $('#attend_surgery_id').val();
			var age = $('#session_age').val();
			var qty = $('#procqty').val();
			$.ajax(
				{
					url: '/layout/attendance/surgery_price_set.php',
					method: 'POST',
					data:{
							 sponsor_id:sponsor_id,
							 surgery_id:surgery_id
						 },
					datatype: 'JSON',
					success: function(data)
					{
						var res = $.parseJSON(data);
						if (res[7] == 'cash')
						{
							$('#proc_price_cash').val(res[0]);
							$('#proc_amt_cash').val(res[0]);
							//$('#proc_amt_cash').val(res[0] * qty);
							$('#proc_price_prvt').val(0);
							$('#proc_amt_prvt').val(0);
							$('#proc_price_nhis').val(0);
							$('#proc_amt_nhis').val(0);
						}
						else if (res[7] == 'nhia') 
						{
							if(age <= 11)
							{
								$('#proc_price_nhis').val(res[3]);
								$('#proc_amt_nhis').val(res[3]);
								//$('#proc_amt_nhis').val(res[3] * qty);
								$('#proc_price_prvt').val(0);
								$('#proc_amt_prvt').val(0);
								$('#proc_price_cash').val(res[4]);
								$('#proc_amt_cash').val(res[4]);
								//$('#proc_amt_cash').val(res[4] * qty);
							}
							else
							{
								$('#proc_price_nhis').val(res[2]);
								$('#proc_amt_nhis').val(res[2]);
								//$('#proc_amt_nhis').val(res[2] * qty);
								$('#proc_price_prvt').val(0);
								$('#proc_amt_prvt').val(0);
								$('#proc_price_cash').val(res[4]);
								$('#proc_amt_cash').val(res[4]);
								//$('#proc_amt_cash').val(res[4] * qty);
							}
						}
						else if (res[7] == 'nhia_na') 
						{
							$('#proc_price_cash').val(res[0]);
							$('#proc_amt_cash').val(res[0]);
							//$('#proc_amt_cash').val(res[0] * qty);
							$('#proc_price_prvt').val(0);
							$('#proc_amt_prvt').val(0);
							$('#proc_price_nhis').val(0);
							$('#proc_amt_nhis').val(0);
						}
						else if (res[7] == 'private_list') 
						{
							$('#proc_price_prvt').val(res[5]);
							$('#proc_amt_prvt').val(res[5]);
							//$('#proc_amt_prvt').val(res[5] * qty);
							$('#proc_price_cash').val(res[6]);
							$('#proc_amt_cash').val(res[6]);
							//$('#proc_amt_cash').val(res[6] * qty);
							$('#proc_price_nhis').val(0);
							$('#proc_amt_nhis').val(0);
						}
						else if (res[7] == 'private_no_list') 
						{
							$('#proc_price_prvt').val(res[0]);
							$('#proc_amt_prvt').val(res[0]);
							//$('#proc_amt_prvt').val(res[0] * qty);
							$('#proc_price_cash').val(0);
							$('#proc_amt_cash').val(0);
							$('#proc_price_nhis').val(0);
							$('#proc_amt_nhis').val(0);
						}
					}
				});
		});
	}

	function surgery_attend_delete()
	{
		$(document).on('click','#btn_delete_surgery_attend',function(){
			var surgery_list_id = $(this).attr('data-id2');
			var attend_id = $('#session_attend_id').val();
			var currentRow=$(this).closest("tr");
			var surgery = currentRow.find("td:eq(1)").text();
			$('#surgery_attend_delete_question').text('Are you sure you want to delete ' + surgery + '?');
			$('#surgery_attend_delete_modal').modal('show');
			$(document).on('click','#surgery_attend_delete_yes',function(){
				$.ajax({  
					 url:'/layout/attendance/surgery_attend_delete.php',  
					 type:'POST',  
					 data:{surgery_list_id:surgery_list_id,attend_id:attend_id},
					 success:function(){
						 $('#surgery_attend_delete_modal').modal('hide');
						 view_current_surgery();
					 }  
				});
			  });
			$(document).on('click','#surgery_attend_delete_no',function(){
				$('#surgery_attend_delete_modal').modal('hide');
			});
		});
	}
