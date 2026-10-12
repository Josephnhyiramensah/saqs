$(document).ready(function()
{
	//ADMISSIONS/REFERRALS/DISCHARGES
		go_to_admission_sheet();
		available_bed_list();
		admit_patient();
		save_attend_wardlist();
		edit_wardlist_attend();
		update_wardlist_attend();
		view_current_wardlist();
		view_wardlist_history();
		delete_wardlist_attend();
		transfer_patient();
		transfer_available_bed_list();
		transfer_patient_save();
		discharge_patient();
		discharge_patient_save();
		refer_patient();
		refer_staff_name();
		refer_patient_save();
		refer_patient_edit();
		refer_patient_update();
		refer_note_display();
});

	//ADMISSIONS/REFERRALS/DISCHARGES
	function go_to_admission_sheet()
	{
		$(document).on('click','#nav_admit',function()
		{
			window.location.href="/layout/attendance/admission_sheet.php";
		});
	}

	function admit_patient()
	{
		$(document).on('click','#wardlist_admit_btn',function()
		{
			$('#wardlist_admit_modal_title').html('Admit Patient');
			$('#wardlist_admit_save_btn').show();
			$('#wardlist_admit_update_btn').hide();
			$('#wardlist_admit_cancel_btn').show();
			$('#wardlist_admit_form').trigger('reset');
			$('#wardlist_admit_modal').modal('show');
		});
	}

	function available_bed_list()
	{
		$(document).on('change','#ward_id',function()
		{
			var ward_id = $('#ward_id').val();
			$.ajax(
			{
				url: '/layout/attendance/admission_bed_list.php',
				method: 'POST',
				data: {ward_id:ward_id},
				success: function(data)
				{
					$('#bed_id').html(data);
				}
			});
		});
	}

	function save_attend_wardlist()
	{
		$(document).on('click','#wardlist_admit_save_btn',function(){
			var ward = $('#ward_id').val();
			var bed = $('#bed_id').val();
			var sponsor = $('#wardlist_sponsor').val();
			var date = $('#ward_date_in').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var officer = $('#wardlist_admitting_officer').val();
			var comment = $('#wardlist_comment').val();
			var type = $('#wardlist_type_of_admission').val();
			var age = $('#session_age').val();
			if (ward > 0) 
			{
				if (bed > 0) 
				{
					if (date !=="") 
					{
						if (officer !=="") 
						{
							if (type !=="") 
							{
								if (sponsor > 0) 
								{
									$.ajax({
										 url:'/layout/attendance/admission_check_duplicate.php',
										 method:'POST',
										 data:{
											 attend_id:attend_id,
											 ward:ward,
											 bed:bed
										 },
										 datatype:'JSON',
										 success:function(data)
											 {
												 var res = $.parseJSON(data);
												 if (res[0] == 'duplicate') 
												 {
													 $('#wardlist_duplicate_question').text('The Ward:'+ res[1] + ' has been selected earlier! Do you want to duplicate the Ward?');
													 $('#wardlist_duplicate_modal').modal('show');
													$(document).on('click','#wardlist_duplicate_yes',function(){
														$.ajax({
															 url:'/layout/attendance/admission_save.php',
															 method:'POST',
															 data:{
																 attend_id:attend_id,
																 patient_id:patient_id,
																 ward:ward,
																 bed:bed,
																 date:date,
																 officer:officer,
																 comment:comment,
																 sponsor:sponsor,
																 type:type,
																 age:age
															 },
															 success:function()
																{
																	 $('#wardlist_attend_form').trigger('reset');
																	 $('#wardlist_duplicate_modal').modal('hide');
																	 $('#wardlist_admit_modal').modal('hide');
																	 $('#wardlist_admit_btn').hide();
																	 view_current_wardlist();
																	 location.reload();
																}
														});
													});
													$(document).on('click','#wardlist_duplicate_no',function(){
														$('#wardlist_duplicate_modal').modal('hide');
													});
												 } 
												 else if(res[0] == 'none') 
												 {
													 $.ajax({
														 url:'/layout/attendance/admission_save.php',
														 method:'POST',
														 data:{
															 attend_id:attend_id,
															 patient_id:patient_id,
															 ward:ward,
															 bed:bed,
															 date:date,
															 officer:officer,
															 comment:comment,
															 sponsor:sponsor,
															 type:type
														 },
														 success:function()
															{
																 $('#wardlist_attend_form').trigger('reset');
																$('#wardlist_admit_modal').modal('hide');
																$('#wardlist_admit_btn').hide();
																 view_current_wardlist();
																 location.reload();
															}
													});
												 };
											 }
									});
								} 
								else 
								{
									alert('Please select the Sponsor!');
								};
							} 
							else 
							{
								alert('Please select the Type of Admission!');
							}
						} 
						else 
						{
							alert('Please enter the Admitting Officers name!');
						}
					} 
					else 
					{
						alert('Please enter the Date!');
					}
					
				}
				else 
				{
					alert('Please enter the Bed!');
				};
			} 
			else 
			{
				alert('Please select Ward!');
			};
		});
	}

	function edit_wardlist_attend()
	{
		$(document).on('click','#btn_edit_wardlist',function(){

			var wardlist_id = $(this).attr('data-id1');

				$.ajax({  
					 url:'/layout/attendance/admission_edit.php',  
					 type:'POST',  
					 data:{wardlist_id:wardlist_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#ward_date_in').val(res[0]);
						 $('#ward_id').val(res[1]);
						 $('#wardlist_attend_id').val(res[2]);
						$('#wardlist_patient_id').val(res[3]);
						$('#wardlist_id').val(res[4]);
						$('#wardlist_comment').val(res[5]);
						$('#wardlist_type_of_admission').val(res[6]);
						$('#wardlist_admitting_officer').val(res[7]);
						$('#wardlist_sponsor').val(res[8]);
						$('#bed_id').val(res[9]);
						$('#wardlist_admit_modal_title').html('Edit Patient Admission');
						$('#wardlist_admit_save_btn').hide();
						$('#wardlist_admit_update_btn').show();
						$('#wardlist_admit_cancel_btn').show();
						$('#wardlist_admit_modal').modal('show');
					 }  
				});
		  }); 
	}

	function update_wardlist_attend()
	{
		$(document).on('click','#wardlist_admit_update_btn',function(){
			var ward = $('#ward_id').val();
			if (ward > 0) 
				{
					var wardlist_id = $('#wardlist_id').val();
					var ward = $('#ward_id').val();
					var bed = $('#bed_id').val();
					var sponsor = $('#wardlist_sponsor').val();
					var date = $('#ward_date_in').val();
					var attend_id = $('#session_attend_id').val();
					var patient_id = $('#session_patient_id').val();
					var officer = $('#wardlist_admitting_officer').val();
					var comment = $('#wardlist_comment').val();
					var type = $('#wardlist_type_of_admission').val();
					$.ajax({
						 url:'/layout/attendance/admission_update.php',
						 method:'POST',
						 data:{
							 wardlist_id:wardlist_id,
							 attend_id:attend_id,
							 patient_id:patient_id,
							 ward:ward,
							 bed:bed,
							 date:date,
							 officer:officer,
							 comment:comment,
							 sponsor:sponsor,
							 type:type
						 },
						 success:function(data)
							 {
								 $('#wardlist_attend_form').trigger('reset');
								 $('#wardlist_admit_modal').modal('hide');
								 view_current_wardlist();
							 }
						 });
				} 
				else 
				{
					alert('Please select Ward!');
				}
			
		});
	}

	function view_current_wardlist()
	{
			var attend_id = $('#session_attend_id').val();
			$.ajax({
				 url:'/layout/attendance/admission_current_view.php',
				 method:'POST',
				 data:{
					 attend_id:attend_id
				 },
				 success:function(data)
					 {
						 $('#attend_wardlist_table').html(data);
					 }
				 });
	}

	function view_wardlist_history()
	{
		$(document).on('click','#wardlist_history_icon',function(){
			
			var patient_id = $('#session_patient_id').val();
			$.ajax(
			{
				url: '/layout/attendance/admission_history_view.php',
				method: 'POST',
				data:{
						 patient_id:patient_id
					 },
				success: function(data)
				{
					$('#attend_wardlist_history_table').html(data);
				}
			});
		});
	}

	function transfer_patient()
	{
		$(document).on('click','#btn_transfer_wardlist',function()
		{
			var wardlist_id = $(this).attr('data-id2');

				$.ajax({  
					 url:'/layout/attendance/admission_transfer.php',  
					 type:'POST',  
					 data:{wardlist_id:wardlist_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#ward_id_if').val(res[0]);
						 $('#bed_id_tf').val(res[1]);
						 $('#wardlist_id_tf').val(res[2]);
						 $('#date_in_tf').val(res[3]);
						 $('#officer_tf').val(res[4]);
						 $('#type_of_admission_tf').val(res[5]);
						 $('#wardlist_id_tf').val(res[6]);
						 $('#admission_type_tt').val('transferred_in');
						$('#wardlist_transfer_modal_title').html('Transfer Patient');
						$('#wardlist_transfer_to_form').trigger('reset');
						$('#wardlist_tt_save_btn').show();
						$('#wardlist_tt_cancel_btn').show();
						$('#wardlist_transfer_modal').modal('show');
					 }  
				});
		});
	}

	function transfer_available_bed_list()
	{
		$(document).on('change','#ward_id_tt',function()
		{
			var ward_id = $('#ward_id_tt').val();
			$.ajax(
			{
				url: '/layout/attendance/admission_transfer_bed_list.php',
				method: 'POST',
				data: {ward_id:ward_id},
				success: function(data)
				{
					$('#bed_id_tt').html(data);
				}
			});
			
		});
	}

	function transfer_patient_save()
	{
		$(document).on('click','#wardlist_tt_save_btn',function(){
			var wardlist_id = $('#wardlist_id_tf').val();
			var ward = $('#ward_id_tt').val();
			var bed = $('#bed_id_tt').val();
			var sponsor = $('#sponsor_tt').val();
			var date = $('#date_in_tt').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var officer = $('#admitting_officer_tt').val();
			var comment = $('#comment_tt').val();
			var type = $('#admission_type_tt').val();
			if (ward > 0) 
			{
				if (bed > 0) 
				{
					if (date !=="") 
					{
						if (officer !=="") 
						{
							if (type !=="") 
							{
								$.ajax({
									 url:'/layout/attendance/admission_transfer_save.php',
									 method:'POST',
									 data:{
										 attend_id:attend_id,
										 patient_id:patient_id,
										 wardlist_id:wardlist_id,
										 ward:ward,
										 bed:bed,
										 date:date,
										 officer:officer,
										 comment:comment,
										 sponsor:sponsor,
										 type:type
									 },
									 success:function()
										{
											 $('#wardlist_transfer_to_form').trigger('reset');
											$('#wardlist_transfer_modal').modal('hide');
											$('#wardlist_admit_btn').hide();
											 view_current_wardlist();
											 location.reload();
										}
								});
							} 
							else 
							{
								alert('Please select the Type of Admission!');
							}
						} 
						else 
						{
							alert('Please enter the Admitting Officers name!');
						}
					} 
					else 
					{
						alert('Please enter the Date!');
					}
					
				}
				else 
				{
					alert('Please enter the Bed!');
				};
			} 
			else 
			{
				alert('Please select Ward!');
			};
		});
	}

	function discharge_patient()
	{
		$(document).on('click','#btn_discharge_wardlist',function()
		{
			var wardlist_id = $(this).attr('data-id2');

				$.ajax({  
					 url:'/layout/attendance/admission_discharge.php',  
					 type:'POST',  
					 data:{wardlist_id:wardlist_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#ward_id_discharge').val(res[0]);
						 $('#bed_id_discharge').val(res[1]);
						 $('#wardlist_id_discharge').val(res[2]);
						$('#wardlist_discharge_modal_title').html('Discharge Patient');
						$('#wardlist_discharge_save_btn').show();
						$('#wardlist_discharge_update_btn').hide();
						$('#wardlist_discharge_cancel_btn').show();
						$('#wardlist_discharge_modal').modal('show');
					 }  
				});
			
		});
	}

	function discharge_patient_save()
	{
		$(document).on('click','#wardlist_discharge_save_btn',function()
		{
			var wardlist_id = $('#wardlist_id_discharge').val();
			var date = $('#ward_date_out').val();
			var officer = $('#wardlist_discharging_officer').val();
			var type = $('#wardlist_type_of_discharge').val();
			var comment = $('#wardlist_comment_discharge').val();
			var attend_id = $('#session_attend_id').val();
			if (date !="") 
			{
				if (officer !="")
				{
					if (type !="" && type != 0 && type != "0") 
					{
						$.ajax({
							url:'/layout/attendance/admission_discharge_save.php',
							method:'POST',
							data:{
								wardlist_id:wardlist_id,
								date:date,
								officer:officer,
								type:type,
								comment:comment,
								attend_id:attend_id
							},
							success:function()
							{
								$('#wardlist_discharge_form').trigger('reset');
								$('#wardlist_admit_modal').modal('hide');
								$('#wardlist_admit_btn').hide();
								view_current_wardlist();
								location.reload();
							}
						});
					} 
					else 
					{
						alert('Please select the Type of Discharge!');
					};
				} 
				else 
				{
					alert('Please enter the Discharging Officers name!');
				};
			} 
			else 
			{
				alert('Please enter the Date!');
			};				
		});
	}

	function delete_wardlist_attend()
	{
		$(document).on('click','#btn_delete_wardlist',function(){
			var attend_id = $('#session_attend_id').val();
			var date_admit = $('#session_dateofadmission_attd').val();
			var wardlist_id = $(this).attr('data-id2');
			var currentRow=$(this).closest("tr");
			var ward = currentRow.find("td:eq(0)").text();
			$('#wardlist_delete_question').text('Are you sure you want to delete ' + ward + '?');
			$('#wardlist_delete_modal').modal('show');
			$(document).on('click','#wardlist_delete_yes',function(){
				$.ajax({  
					 url:'/layout/attendance/admission_attend_delete.php',  
					 type:'POST',  
					 data:{wardlist_id:wardlist_id,attend_id:attend_id,date_admit:date_admit},
					 success:function(){
						 $('#wardlist_delete_modal').modal('hide');
						 view_current_wardlist();
						 location.reload();
					 }  
				});
			  });
			$(document).on('click','#wardlist_delete_no',function(){
				$('#wardlist_delete_modal').modal('hide');
			});
		});
	}

	function refer_patient()
	{
		$(document).on('click','#wardlist_refer_btn',function()
		{
			$('#wardlist_referral_modal_title').html('Patient Referral Form');
			$('#referal_save_btn').show();
			$('#referal_update_btn').hide();
			$('#rsn').hide();
			$('#referal_cancel_btn').show();
			$('#wardlist_referral_form').trigger('reset');
			$('#wardlist_referral_modal').modal('show');
		});
	}

	function refer_staff_name()
	{
		$(document).on('change keyup','#accompanied',function()
		{
			var accompanied = $('#accompanied').val();
			if (accompanied =='yes') 
			{
				$('#rsn').show();
			} 
			else 
			{
				$('#referral_staff_name').val('');
				$('#rsn').hide();
			};
		});
	}

	function refer_patient_save()
	{
		$(document).on('click','#referal_save_btn',function(){
			var facility = $('#facility').val();
			var doctor = $('#ref_doctor').val();
			var date = $('#ref_date').val();
			var time = $('#ref_time').val();
			var alertness = $('#alertness').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var walking = $('#walking').val();
			var illness_state = $('#illness_state').val();
			var urgency = $('#urgency').val();
			var accompanied = $('#accompanied').val();
			var staff_name = $('#referral_staff_name').val();
			var reason = $('#reason').val();
			var action_taken = $('#action_taken').val();
			
			if (facility !=="")  
			{
				if (doctor !=="")  
				{
					if (date !=="") 
					{
						if (time !=="") 
						{
							if (alertness !==0) 
							{
								if (walking !==0) 
								{
									if (illness_state !==0) 
									{
										if (urgency !==0) 
										{
											if (reason !=="") 
											{
												if (action_taken !=="") 
												{
													if (accompanied !==0 && staff_name !=="") 
													{
														$.ajax({
															 url:'/layout/attendance/admission_referral_save.php',
															 method:'POST',
															 data:{
																 attend_id:attend_id,
																 patient_id:patient_id,
																 facility:facility,
																 doctor:doctor,
																 time:time,
																 date:date,
																 alertness:alertness,
																 walking:walking,
																 illness_state:illness_state,
																 urgency:urgency,
																 accompanied:accompanied,
																 staff_name:staff_name,
																 reason:reason,
																 action_taken:action_taken
															 },
															 success:function(data)
																{
																	if (data == 0) 
																	{
																		alert('Referral was not entered!');
																		$('#wardlist_referral_modal').modal('hide');
																	} 
																	else if(data == 1)
																	{
																		$('#wardlist_referral_modal').modal('hide');
																		location.reload();
																	};
																}
														});
													} 
													else if(accompanied !==0 && staff_name =="")
													{
														alert('Please provide the name of the staff accompanying the patient!');
													}
													else if(accompanied ==0 && staff_name =="")
													{
														alert('Please select whether the patient was accompanied to the referred facility!');
													};
												} 
												else 
												{
													alert('Please type the action taken so far!');
												};
											} 
											else 
											{
												alert('Please type the reason for referring the patient!');
											};
										} 
										else 
										{
											alert('Please select the urgency state of the referral!');
										};
									} 
									else 
									{
										alert('Please select the patient illness status!');
									};
								} 
								else 
								{
									alert('Please select the patient walking status!');
								};
							} 
							else 
							{
								alert('Please select the patient alertness status!');
							};
						} 
						else 
						{
							alert('Please provide the time of referral!');
						};
					} 
					else 
					{
						alert('Please enter the Date!');
					};
				}
				else 
				{
					alert('Please type the name of the doctor refering the Patient!');
				};
			} 
			else 
			{
				alert('Please type the Facility this is being transferred to!');
			};
		});
	}

	function refer_patient_edit()
	{
		$(document).on('click','#wardlist_refer_edit_btn',function(){

			var attend_id = $('#session_attend_id').val();

				$.ajax({  
					 url:'/layout/attendance/admission_referral_edit.php',  
					 type:'POST',  
					 data:{attend_id:attend_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#facility').val(res[1]);
						 $('#ref_doctor').val(res[4]);
						 $('#ref_date').val(res[5]);
						$('#ref_time').val(res[6]);
						$('#alertness').val(res[7]);
						$('#walking').val(res[8]);
						$('#illness_state').val(res[9]);
						$('#urgency').val(res[2]);
						$('#accompanied').val(res[3]);
						$('#referral_staff_name').val(res[10]);
						$('#reason').val(res[11]);
						$('#action_taken').val(res[12]);
						$('#referral_id').val(res[0]);
						$('#wardlist_referral_modal_title').html('Edit Patient Referral Form');
						$('#referal_save_btn').hide();
						$('#referal_update_btn').show();
						$('#referal_cancel_btn').show();
						$('#wardlist_referral_modal').modal('show');
					 }  
				});
		  }); 
	}

	function refer_patient_update()
	{
		$(document).on('click','#referal_update_btn',function(){
			var referral_id = $('#referral_id').val();
			var facility = $('#facility').val();
			var doctor = $('#ref_doctor').val();
			var date = $('#ref_date').val();
			var time = $('#ref_time').val();
			var alertness = $('#alertness').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var walking = $('#walking').val();
			var illness_state = $('#illness_state').val();
			var urgency = $('#urgency').val();
			var accompanied = $('#accompanied').val();
			var staff_name = $('#referral_staff_name').val();
			var reason = $('#reason').val();
			var action_taken = $('#action_taken').val();
			
			if (facility !=="")  
			{
				if (doctor !=="")  
				{
					if (date !=="") 
					{
						if (time !=="") 
						{
							if (alertness !==0) 
							{
								if (walking !==0) 
								{
									if (illness_state !==0) 
									{
										if (urgency !==0) 
										{
											if (reason !=="") 
											{
												if (action_taken !=="") 
												{
													if (accompanied !==0 && staff_name !=="") 
													{
														$.ajax({
															 url:'/layout/attendance/admission_referral_update.php',
															 method:'POST',
															 data:{
																 referral_id:referral_id,
																 attend_id:attend_id,
																 patient_id:patient_id,
																 facility:facility,
																 doctor:doctor,
																 time:time,
																 date:date,
																 alertness:alertness,
																 walking:walking,
																 illness_state:illness_state,
																 urgency:urgency,
																 accompanied:accompanied,
																 staff_name:staff_name,
																 reason:reason,
																 action_taken:action_taken
															 },
															 success:function(data)
																{
																	if (data == 0) 
																	{
																		alert('Referral was not entered!');
																		$('#wardlist_referral_modal').modal('hide');
																	} 
																	else if(data == 1)
																	{
																		$('#wardlist_referral_modal').modal('hide');
																		location.reload();
																	};
																}
														});
													} 
													else if(accompanied !==0 && staff_name =="")
													{
														alert('Please provide the name of the staff accompanying the patient!');
													}
													else if(accompanied ==0 && staff_name =="")
													{
														alert('Please select whether the patient was accompanied to the referred facility!');
													};
												} 
												else 
												{
													alert('Please type the action taken so far!');
												};
											} 
											else 
											{
												alert('Please type the reason for referring the patient!');
											};
										} 
										else 
										{
											alert('Please select the urgency state of the referral!');
										};
									} 
									else 
									{
										alert('Please select the patient illness status!');
									};
								} 
								else 
								{
									alert('Please select the patient walking status!');
								};
							} 
							else 
							{
								alert('Please select the patient alertness status!');
							};
						} 
						else 
						{
							alert('Please provide the time of referral!');
						};
					} 
					else 
					{
						alert('Please enter the Date!');
					};
				}
				else 
				{
					alert('Please type the name of the doctor refering the Patient!');
				};
			} 
			else 
			{
				alert('Please type the Facility this is being transferred to!');
			};
		});
	}

	function refer_note_display()
	{
		$(document).on('click','#wardlist_refer_print_btn',function()
		{
			var company_id = $('#session_company').val();
			var attend_id = $('#session_attend_id').val();
			$.ajax({
				 url:'/layout/reports/referral_note_processing.php',
				 method:'POST',
				 data:{company_id:company_id, attend_id:attend_id},
				 success:function(data)
				 {
					 window.open('/layout/reports/referral_note_display.php', '_blank');
				 }
			});
		});
	}