$(document).ready(function()
{
	//CREATE AND OPEN
		attend_new();
		attend_sponsor_create_modal();
		change_attend_sponsor_principal();
		add_attend_sponsor_row();
		delete_attend_sponsor_row();
		set_specialty_1();
		set_specialty_2();
		set_specialty_3();
		attend_save();
		attend_cancel();
		open_attend();
		go_home();
		edit_attend();
		attend_update();
		attend_edit_cancel();
		search_attend_opd();
		search_attend_opd_by_name();
		search_attend_ipd();
		search_attend_ipd_by_name();
		search_attend_ipd_by_ward();
		search_attend_cashier();
		search_attend_list_by_date();
		search_attend_list_by_name();
		search_attend_list_discharge_by_date();
		search_attend_list_discharge_by_name();
		search_attend_list_revenue_by_name();
		search_attend_list_revenue_by_date();
		delete_attendance();
});

	//CREATE ATTENDANCE
	function attend_new()
	{
		$(document).on('click','#btn_new_attend',function(){
			var patient_id = $(this).attr('data-id');
			var currentRow=$(this).closest("tr");
			var patient_name = currentRow.find("td:eq(1)").text();
			$.ajax({  
				 url:'/layout/attendance/attend_new.php',  
				 type:'POST',  
				 data:{patient_id:patient_id},
				 success:function(data)
				 {
					 window.location.href="/layout/attendance/attendance_new.php";
				 }  
			});
		}); 
	}

	function set_specialty_1()
	{
		$(document).on('change keyup','.specialty_attd_1',function(){
			var tr_id = $(this).closest('tr').attr('id');
			var specialty_1 = $('#specialty_attd_1'+tr_id).val();
			var age = $('#patient_age').val();
			$.ajax({
					 url:'/layout/attendance/attend_specialty_1.php',
					 method:'POST',
					 datatype:'JSON',
					 data:{specialty_1:specialty_1},
					 success:function(data)
						{
							var res = $.parseJSON(data);
							if (res[0] !=='none') 
							{
								if(age > 11)
								{
									var gdrg = res[1];
								}
								else
								{
									var gdrg = res[2];
								};
								var code = gdrg.substring(0, 4);
								$('#spec_code_1'+tr_id).val(code);
							} 
							else 
							{
								$('#spec_code_1'+tr_id).val('');
							};
						}
				 });
		});
	}

	function set_specialty_2()
	{
		$(document).on('change keyup','.specialty_attd_2',function(){
			var tr_id = $(this).closest('tr').attr('id');
			var specialty_2 = $('#specialty_attd_2'+tr_id).val();
			var age = $('#patient_age').val();
			$.ajax({
					 url:'/layout/attendance/attend_specialty_2.php',
					 method:'POST',
					 datatype:'JSON',
					 data:{specialty_2:specialty_2},
					 success:function(data)
						{
							var res = $.parseJSON(data);
							if (res[0] !=='none') 
							{
								if(age > 11)
								{
									var gdrg = res[1];
								}
								else
								{
									var gdrg = res[2];
								};
								var code = gdrg.substring(0, 4);
								$('#spec_code_2'+tr_id).val(code);
							} 
							else 
							{
								$('#spec_code_2'+tr_id).val('');
							};
						}
				 });
		});
	}

	function set_specialty_3()
	{
		$(document).on('change keyup','.specialty_attd_1',function(){
			var tr_id = $(this).closest('tr').attr('id');
			var Specialty_1 = $('#specialty_attd_1'+tr_id).val();
			var typeofservice_attd = $('#typeofservice_attd').val();
			var age = $('#patient_age').val();

			if(typeofservice_attd == 1 && Specialty_1 == 1)
			{
				$('#specialty_attd_3'+tr_id).val( 'GENERAL OPD' );
			}
			else if(typeofservice_attd == 2 && Specialty_1 == 1 && age > 11)
			{
				$('#specialty_attd_3'+tr_id).val('MEDICAL');
			}
			else if(typeofservice_attd == 2 && Specialty_1 == 1 && age < 12)
			{
				$('#specialty_attd_3'+tr_id).val('PAEDIATRIC');
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 2)
			{
				$('#specialty_attd_3'+tr_id).val('ANTENATAL/POSTNATAL');
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 3)
			{ 
				$('#specialty_attd_3'+tr_id).val( 'CROSS MDC' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 29) 
			{
				$('#specialty_attd_3'+tr_id).val( 'DENTAL' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 30) 
			{
				$('#specialty_attd_3'+tr_id).val( 'ENT' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 31) 
			{
				$('#specialty_attd_3'+tr_id).val( 'OPHTHAMOLOGY' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 36) 
			{
				$('#specialty_attd_3'+tr_id).val( 'UNBUNDLED CONSULTATION ONLY' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 37) 
			{
				$('#specialty_attd_3'+tr_id).val( 'ADULT SURGERY' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 41) 
			{
				$('#specialty_attd_3'+tr_id).val( 'OBSTETRICS & GYNAECOLOGY' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 42) 
			{
				$('#specialty_attd_3'+tr_id).val( 'OPHTHAMOLOGY' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 43) 
			{
				$('#specialty_attd_3'+tr_id).val( 'ORTHOPAEDICS' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 44) 
			{
				$('#specialty_attd_3'+tr_id).val( 'RECONSTRUCTIVE SURGERY' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 45) 
			{
				$('#specialty_attd_3'+tr_id).val( 'CROSS MDC' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 46) 
			{
				$('#specialty_attd_3'+tr_id).val( 'CROSS MDC' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 47) 
			{
				$('#specialty_attd_3'+tr_id).val( 'PHYSIOTHERAPY' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 48) 
			{
				$('#specialty_attd_3'+tr_id).val( 'CROSS MDC' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 49) 
			{
				$('#specialty_attd_3'+tr_id).val( 'CROSS MDC' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 50) 
			{
				$('#specialty_attd_3'+tr_id).val( 'CROSS MDC' );
			}
			else if(typeofservice_attd == 1 && Specialty_1 == 51) 
			{
				$('#specialty_attd_3'+tr_id).val( 'CROSS MDC' );
			};
		});
	}

	function attend_sponsor_create_modal()
	{
		$(document).on('click','#attend_add_sponor_link',function(){
			$('#attend_sponsor_create_form').trigger('reset');
			$('#attend_sponsor_update_btn').hide();
			$('#attend_sponsor_save_btn').show();
			$('#attend_sponsor_create_modal').modal('show');
		});
	}

	function add_attend_sponsor_row()
	{
		$(document).on('change','.attend_sponsor_id',function(){ 
			var i = $('#attend_sponsor_table tr:last').attr('id');
			var current_tr_id = $(this).closest('tr').attr('id');
			var ledger_id = $(this).val();
			var date = $('#session_dateofadmission_attd').val();
			i++;
			$.ajax({
				url:'/layout/attendance/attend_sponsor_list.php',
				method:'POST',
				data:{i:i},
				success:function(data)
				{
					if (ledger_id == 2) 
					{
						$('#ghanacard_div'+current_tr_id+'').attr('style', 'display:inline;');
						$('#ins_category_div'+current_tr_id+'').attr('style', 'display:none;');
						$('#serial_no_div'+current_tr_id+'').attr('style', 'display:inline;');
						$('#relation_div'+current_tr_id+'').attr('style', 'display:none;');
						$('#ins_detail_one'+current_tr_id+'').attr('style', 'display:flex;');
						$('#ins_detail_two'+current_tr_id+'').attr('style', 'display:flex;');
						//$('#specialty_attd_1'+current_tr_id+'').val(1);
						//$('#spec_code_1'+current_tr_id+'').val('OPDC');
						$('input[name="specialty_attd[]"][value="OPDC"]').prop('checked', true);
						$('#type_of_attendnace'+current_tr_id+'').val('emergency_acute_episode');
						$('#date_of_claim'+current_tr_id+'').val(date);
						$('#pharmacy'+current_tr_id+'').val('pharmacy');
						$('#type_of_service_2'+current_tr_id+'').val('all_inclusive');
					}
					else 
					{
						$('#ghanacard_div'+current_tr_id+'').attr('style', 'display:none;');
						$('#ins_category_div'+current_tr_id+'').attr('style', 'display:inline;');
						$('#serial_no_div'+current_tr_id+'').attr('style', 'display:none;');
						$('#relation_div'+current_tr_id+'').attr('style', 'display:inline;');
						$('#ins_detail_one'+current_tr_id+'').attr('style', 'display:none;');
						$('#ins_detail_two'+current_tr_id+'').attr('style', 'display:none;');
					};
					$('#attend_sponsor_table').append(data);
				}
			});
		});
	}

	function delete_attend_sponsor_row()
	{
		$(document).on('click', '#delete_attend_sponsor', function(){  
			   var button_id = $(this).attr("data-id");
			   $('#'+button_id+'').remove();

		   });
	}

	function change_attend_sponsor_principal()
	{
		$(document).on('change', '.attend_sponsor_principal', function(){ 
			var selected_tr_id = $(this).closest('tr').attr('id');
			var selected_principal = $(this).val();
			var selected_sponsor = $('#attend_sponsor_id'+selected_tr_id).val();
			if (selected_sponsor > 0) 
			{
				$('.attend_sponsor_principal').each(function(){
					var current_tr_id = $(this).closest('tr').attr('id');
					var current_principal = $(this).val();
					var current_sponsor = $('#attend_sponsor_id'+current_tr_id).val();
					
					if(selected_tr_id == current_tr_id)
					{
						if(current_sponsor > 0)
						{
						$('#attend_sponsor_principal'+current_tr_id).html('<option value="0">Please Select</option><option value ="Yes" selected="selected">Yes</option><option value ="No">No</option>');
						};
					}
					else
					{
						if(current_sponsor > 0)
						{
							$('#attend_sponsor_principal'+current_tr_id).html('<option value="0">Please Select</option><option value ="Yes">Yes</option><option value ="No" selected="selected">No</option>');
						};
					};
				});
			}
			else
			{
				$('#attend_sponsor_principal'+selected_tr_id).html('<option value="0" selected="selected">Please Select</option><option value ="Yes">Yes</option><option value ="No">No</option>');
				alert('Please select a Sponsor before selecting Principal!');
			};
			
		   });
	}

	function attend_save()
	{
		$(document).on('click','#attend_save_btn_attd',function(e){
			e.preventDefault();
			var attend_id = $('#attend_id').val();
			var clinic_attd = $('#clinic_attd').val();
			var doctor_attd = $('#doctor_attd').val();
			var dateofadmission_attd = $('#dateofadmission_attd').val();
			var dateofdischarge_attd = $('#dateofdischarge_attd').val();
			var sponsor = $('#attend_sponsor_id1').val();
			var type_attd = $('#type_attd').val();
			var state_attd = $('#state_attd').val();
			if (type_attd !== '' && type_attd !== "0") 
			{
				if (state_attd !== '' && state_attd !== "0") 
				{
					if (type_attd == 'Regular' && (clinic_attd !== '' && clinic_attd > "0") || type_attd !== 'Regular' && (clinic_attd == '' || clinic_attd <= "0") ) 
					{
						if (type_attd == 'Regular' && (doctor_attd !== '' && doctor_attd > "0") || type_attd !== 'Regular' && (doctor_attd == '' || doctor_attd <= "0") )
						{
							if (dateofadmission_attd !== '') 
							{
								if (sponsor !== '' && sponsor > 0) 
								{
									var last_tr_id = $("#attend_sponsor_table tr:last").attr("id");
									var last_tr_select = $("#attend_sponsor_table tr:last option:selected").val();
									if(last_tr_select == "" || last_tr_select == 0)
									{
										$('#'+last_tr_id+'').remove();
									};
									$.ajax({
										url:'/layout/attendance/attend_save.php',
										method:'POST',
										data:$('#new_attend_form').serialize(),
										success:function(data)
										{
											if (data == 1) 
											{
												alert('Please Attendance has been created for this patient already!');
											}
											else if(data == 0)
											{
												window.location.href="/layout/attendance/vitals_sheet.php";
												$('#vitals_update_btn').hide();
												$('#vitals_save_btn').show();
												$('#vitals_input_form').trigger('reset');
											}
											else if(data == 2)
											{
												alert('Please Attendance was NOT created, Please contact the administrator!');
											};
										}
									});
								} 
								else 
								{
									$('#attend_create_msg').html('<h4 style=color:red;>Please select a Sponsor!</h4>');
									$('#attend_create_msg').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#attend_create_msg').html('<h4 style=color:red;>Please the Date of Admission cannot be EMPTY!</h4>');
								$('#attend_create_msg').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#attend_create_msg').html('<h4 style=color:red;>Please select a Doctor!</h4>');
							$('#attend_create_msg').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#attend_create_msg').html('<h4 style=color:red;>Please select a Clinic!</h4>');
						$('#attend_create_msg').hide().slideDown().delay(2000).fadeOut();
					};
				} 
				else 
				{
					$('#attend_create_msg').html('<h4 style=color:red;>Please the Attendance Status cannot be EMPTY!</h4>');
					$('#attend_create_msg').hide().slideDown().delay(2000).fadeOut();
				};

			} 
			else 
			{
				$('#attend_create_msg').html('<h4 style=color:red;>Please the Attendance Type cannot be EMPTY!</h4>');
				$('#attend_create_msg').hide().slideDown().delay(2000).fadeOut();
			};
		});
	}

	function attend_cancel()
	{
		$(document).on('click','#attend_cancel_btn_attd',function(){
			//$('#new_attend_form').trigger('reset');
			window.location.href="/layout/patients/patient_list.php";
		});
	}

	function open_attend()
	{
		$(document).on('click','#btn_open_attend',function(){

			var attend_id = $(this).attr('data-id');
			var patient_id = $(this).attr('data-id2');
			var user_type_id = $('#session_user_type_id').val();
			var remember_state = $('#remember_state').prop('checked');
			if (remember_state == true) 
			{
				var search_clinic = $('#search_clinic').val();
				var search_from = $('#search_from').val();
				var search_to = $('#search_to').val();
				var page = window.location.pathname;
			}
			else
			{
				var search_clinic = 0;
				var search_from = '';
				var search_to = '';
				var page = '';
			};
			$.ajax({  
					 url:'/layout/attendance/attend_open.php',  
					 type:'POST',  
					 data:{
						 patient_id:patient_id, 
						 attend_id:attend_id,
						 search_clinic:search_clinic, 
						 search_from:search_from,
						 search_to:search_to,
						 remember_state:remember_state,
						 page:page
					 },
					 success:function(){
						if(user_type_id == 5)/*NURSE*/
						{
							window.location.href="/layout/attendance/vitals_sheet.php";
						}
						else if(user_type_id == 6)/*DOCTOR*/
						{
							window.location.href="/layout/attendance/history_sheet.php";
						}
						else if(user_type_id == 7)/*LAB*/
						{
							window.location.href="/layout/attendance/lab_sheet.php";
						}
						else if(user_type_id == 8)/*DISPENER*/
						{
							window.location.href="/layout/attendance/drugs_sheet.php";
						}
						else if(user_type_id == 9)/*SONOGRAPHER*/
						{
							window.location.href="/layout/attendance/radio_sheet.php";
						}
						else if(user_type_id == 10)/*CASHIER*/
						{
							window.location.href="/layout/attendance/service_sheet.php";
						}
						else if(user_type_id !== 5 && user_type_id !== 6 && user_type_id !== 7 && user_type_id !== 8 && user_type_id !== 9 && user_type_id !== 10)/*NONE*/
						{
							window.location.href="/layout/attendance/history_sheet.php";
						};
					 }  
				});
		  }); 
	}

	function go_home()
	{
		$(document).on('click','#nav_home',function(){
			var page = $('#session_page').val();
			var typeofservice_attd = $('#session_typeofservice_attd').val();
			if(page !=='')
			{
				window.location.href = page;
				search_attend_opd();
			}
			else
			{
				if (typeofservice_attd ==1) 
				{
					window.location.href="/layout/attendance/attend_list_opd.php";
				}
				else if(typeofservice_attd ==2)
				{
					window.location.href="/layout/attendance/attend_list_ipd.php";
				};
			};
		});
	}

	function edit_attend()
	{
		$(document).on('click','#nav_attendance_edit',function(){
			window.location.href="/layout/attendance/attendance_edit.php";
		}); 
	}

	function attend_update()
	{
		$(document).on('click','#attend_edit_update_btn',function(e){
			e.preventDefault();
			var attend_id = $('#attend_id').val();
			var clinic_attd = $('#clinic_attd').val();
			var doctor_attd = $('#doctor_attd').val();
			var dateofadmission_attd = $('#dateofadmission_attd').val();
			var dateofdischarge_attd = $('#dateofdischarge_attd').val();
			var sponsor = $('#attend_sponsor_id1').val();
			var type_attd = $('#type_attd').val();
			var state_attd = $('#state_attd').val();
			if (type_attd !== '' && type_attd !== "0") 
			{
				if (state_attd !== '' && state_attd !== "0") 
				{
					if (type_attd == 'Regular' && (clinic_attd !== '' && clinic_attd > "0") || type_attd !== 'Regular' && (clinic_attd == '' || clinic_attd <= "0") ) 
					{
						if (type_attd == 'Regular' && (doctor_attd !== '' && doctor_attd > "0") || type_attd !== 'Regular' && (doctor_attd == '' || doctor_attd <= "0") )
						{
							if (dateofadmission_attd !== '') 
							{
								if (sponsor !== '' && sponsor > 0) 
								{
									var last_tr_id = $("#attend_sponsor_table tr:last").attr("id");
									var last_tr_select = $("#attend_sponsor_table tr:last option:selected").val();
									if(last_tr_select == "" || last_tr_select == 0)
									{
										$('#'+last_tr_id+'').remove();
									};
									$.ajax({
										url:'/layout/attendance/attend_update.php',
										method:'POST',
										data:$('#new_attend_form').serialize(),
										success:function(data)
										{
											if (data == 1) 
											{
												alert('Please Attendance has been created for this patient already!');
											}
											else if(data == 0)
											{
												window.location.href="/layout/attendance/attend_list_opd.php";
												$('#opd_attend_search_form').trigger('reset');
											}
											else if(data == 2)
											{
												alert('Please Attendance was NOT created, Please contact the administrator!');
											};
										}
									});
								} 
								else 
								{
									$('#attend_create_msg').html('<h4 style=color:red;>Please select a Sponsor!</h4>');
									$('#attend_create_msg').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#attend_create_msg').html('<h4 style=color:red;>Please the Date of Admission cannot be EMPTY!</h4>');
								$('#attend_create_msg').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#attend_create_msg').html('<h4 style=color:red;>Please select a Doctor!</h4>');
							$('#attend_create_msg').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#attend_create_msg').html('<h4 style=color:red;>Please select a Clinic!</h4>');
						$('#attend_create_msg').hide().slideDown().delay(2000).fadeOut();
					};
				} 
				else 
				{
					$('#attend_create_msg').html('<h4 style=color:red;>Please the Attendance Status cannot be EMPTY!</h4>');
					$('#attend_create_msg').hide().slideDown().delay(2000).fadeOut();
				};

			} 
			else 
			{
				$('#attend_create_msg').html('<h4 style=color:red;>Please the Attendance Type cannot be EMPTY!</h4>');
				$('#attend_create_msg').hide().slideDown().delay(2000).fadeOut();
			};
		});
	}

	function attend_edit_cancel()
	{
		$(document).on('click','#attend_edit_cancel_btn',function(){
			window.location.href="/layout/attendance/attend_list_opd.php";
		});
	}

	function search_attend_opd_by_name()
	{
		$(document).on('change keyup','#search_by_name',function()
		{
			var name = $('#search_by_name').val();
			var start = $('#search_from').val();
			var end = $('#search_to').val();
			$.ajax({
				url:"/layout/attendance/attend_search_opd_by_name.php",
				method:"POST",
				data:{
					name:name,
					start:start,
					end:end
				},
				success:function(data)
				{
					$('#attend-table').html(data);
				}
			});
		}); 
	}

	function search_attend_opd()
	{
		$(document).on('change keyup','#search_from, #search_to, #search_clinic',function()
		{
			var company_id = $('#session_company_id').val();
			var date_from = $('#search_from').val();
			var date_to = $('#search_to').val();
			var clinic = $('#search_clinic').val();
			if(date_from !=="" && date_to !=="")
			{
				if (date_to < date_from) 
				{
					alert('The End Date cannot be less than the Start Date!')
				} 
				else 
				{
					if(date_from !== '' && date_to !== '' && clinic > 0)
					  {
						  $.ajax({
						   url:"/layout/attendance/attend_search_opd.php",
						   method:"POST",
						   data:{
							   company_id:company_id,
							   date_from:date_from,
							   date_to:date_to,
							   clinic:clinic},
						   success:function(data)
						   {
							   $('#attend-table').html(data);
						   }
						});
					  }
					  else if(date_from !== '' && date_to !== '' && clinic == 0)
					  {
						  $.ajax({
						   url:"/layout/attendance/attend_search_opd.php",
						   method:"POST",
						   data:{company_id:company_id,date_from:date_from, date_to:date_to, clinic:clinic},
						   success:function(data)
						   {
							   $('#attend-table').html(data);
						   }
						});
					  }
					  else if(date_from == '' && date_to == '' && clinic == 0)
					  {
						  var date_from = 0;
						var date_to = 0;
						  $.ajax({
						   url:"/layout/attendance/attend_search_opd.php",
						   method:"POST",
						   data:{company_id:company_id,date_from:date_from, date_to:date_to, clinic:clinic},
						   success:function(data)
						   {
							   $('#attend-table').html(data);
						   }
						});
					  }
					  else if(date_from == '' && date_to == '' && clinic > 0)
					  {
						  var date_from = 0;
						var date_to = 0;
						  $.ajax({
						   url:"/layout/attendance/attend_search_opd.php",
						   method:"POST",
						   data:{company_id:company_id,date_from:date_from, date_to:date_to, clinic:clinic},
						   success:function(data)
						   {
							   $('#attend-table').html(data);
						   }
						});
					  };
				};
			};
		}); 
	}

	function search_attend_ipd_by_name()
	{
		$(document).on('change keyup','#search_by_name',function()
		{
			var name = $('#search_by_name').val();
			var start = $('#search_from').val();
			var end = $('#search_to').val();
			$.ajax({
				url:"/layout/attendance/attend_search_ipd_by_name.php",
				method:"POST",
				data:{
					name:name,
					start:start,
					end:end
				},
				success:function(data)
				{
					$('#ipd_attend_table').html(data);
				}
			});
		}); 
	}

	function search_attend_ipd_by_ward()
	{
		$(document).on('change keyup','#search_ward',function()
		{
			var ward = $(this).val();
			$.ajax({
				url:"/layout/attendance/attend_search_ipd_by_ward.php",
				method:"POST",
				data:{
					ward:ward,
				},
				success:function(data)
				{
					$('#ipd_attend_table').html(data);
				}
			});
		}); 
	}

	function search_attend_ipd()
	{
		/*$(document).on('change keyup','#search_from, #search_to, #search_ward',function()
		{
			var company_id = $('#session_company_id').val();
			var date_from = $('#search_from').val();
			var date_to = $('#search_to').val();
			var ward = $('#search_ward').val();
			if(date_from !=="" && date_to !=="")
			{
				if (date_to < date_from) 
				{
					alert('The End Date cannot be less than the Start Date!')
				} 
				else 
				{
					if(date_from !== '' && date_to !== '' && ward > 0)
					  {
						  $.ajax({
						   url:"/layout/attendance/attend_search_ipd.php",
						   method:"POST",
						   data:{
							   company_id:company_id,date_from:date_from, date_to:date_to, ward:ward},
						   success:function(data)
						   {
							   $('#ipd_attend_table').html(data);
						   }
						});
					  }
					  else if(date_from !== '' && date_to !== '' && ward == 0)
					  {
						  $.ajax({
						   url:"/layout/attendance/attend_search_ipd.php",
						   method:"POST",
						   data:{company_id:company_id,date_from:date_from, date_to:date_to, ward:ward},
						   success:function(data)
						   {
							   $('#ipd_attend_table').html(data);
						   }
						});
					  }
					  else if(date_from == '' && date_to == '' && ward == 0)
					  {
						  var date_from = 0;
						var date_to = 0;
						  $.ajax({
						   url:"/layout/attendance/attend_search_ipd.php",
						   method:"POST",
						   data:{company_id:company_id,date_from:date_from, date_to:date_to, ward:ward},
						   success:function(data)
						   {
							   $('#ipd_attend_table').html(data);
						   }
						});
					  }
					  else if(date_from == '' && date_to == '' && ward > 0)
					  {
						  var date_from = 0;
						var date_to = 0;
						  $.ajax({
						   url:"/layout/attendance/attend_search_ipd.php",
						   method:"POST",
						   data:{company_id:company_id,date_from:date_from, date_to:date_to, ward:ward},
						   success:function(data)
						   {
							   $('#ipd_attend_table').html(data);
						   }
						});
					  };
				};
			};
		});*/
	}

	function search_attend_cashier()
	{
		$(document).on('change','#name_search, #start_date, #end_date',function()
		{
			var date_from = $('#start_date').val();
			var date_to = $('#end_date').val();
			var name = $('#name_search').val();
			if(date_from !=="" && date_to !=="")
			{
				if (date_to < date_from) 
				{
					alert('The End Date cannot be less than the Start Date!')
				} 
				else 
				{
					if(date_from !== '' && date_to !== '' && name > 0)
					  {
						  $.ajax({
						   url:"/layout/attendance/attend_search_cashier.php",
						   method:"POST",
						   data:{date_from:date_from, date_to:date_to, name:name},
						   success:function(data)
						   {
							   $('#attend-table').html(data);
						   }
						});
					  }
					  else if(date_from !== '' && date_to !== '' && name == 0)
					  {
						  $.ajax({
						   url:"/layout/attendance/attend_search_cashier.php",
						   method:"POST",
						   data:{date_from:date_from, date_to:date_to, name:name},
						   success:function(data)
						   {
							   $('#attend-table').html(data);
						   }
						});
					  }
					  else if(date_from == '' && date_to == '' && name == 0)
					  {
						  var date_from = 0;
						var date_to = 0;
						  $.ajax({
						   url:"/layout/attendance/attend_search_cashier.php",
						   method:"POST",
						   data:{date_from:date_from, date_to:date_to, name:name},
						   success:function(data)
						   {
							   $('#attend-table').html(data);
						   }
						});
					  }
					  else if(date_from == '' && date_to == '' && name > 0)
					  {
						  var date_from = 0;
						var date_to = 0;
						  $.ajax({
						   url:"/layout/attendance/attend_search_cashier.php",
						   method:"POST",
						   data:{date_from:date_from, date_to:date_to, name:name},
						   success:function(data)
						   {
							   $('#attend-table').html(data);
						   }
						});
					  };
				};
			};
		}); 
	}

	function search_attend_list_by_date()
	{
		$(document).on('click','#btn-search-by-date',function()
		{
			var company_id = $('#session_company_id').val();
			var date_from = $('#search_from_attend_list').val();
			var date_to = $('#search_to_attend_list').val();
			$.ajax({
				url:"/layout/attendance/attend_search_by_date.php",
				method:"POST",
				data:{
				company_id:company_id,
				date_from:date_from,
				date_to:date_to},
				success:function(data)
				{
					$('#attend-table').html(data);
				}
			});
		}); 
	}

	function search_attend_list_by_name()
	{
		$(document).on('keyup','#search_attend',function()
		{
			var search = $('#search_attend').val();
			$.ajax({
				url:"/layout/attendance/attend_search_by_name.php",
				method:"POST",
				data:{search:search},
				success:function(data)
				{
					$('#attend-table').html(data);
				}
			});
		}); 
	}

	function search_attend_list_discharge_by_date()
	{
		$(document).on('click','#btn_search_discharge_by_date',function()
		{
			var company_id = $('#session_company_id').val();
			var date_from = $('#search_from_attend_list').val();
			var date_to = $('#search_to_attend_list').val();
			$.ajax({
				url:"/layout/attendance/attend_discharge_search_by_date.php",
				method:"POST",
				data:{
				company_id:company_id,
				date_from:date_from,
				date_to:date_to},
				success:function(data)
				{
					$('#attend-table').html(data);
				}
			});
		}); 
	}

	function search_attend_list_discharge_by_name()
	{
		$(document).on('keyup','#search_attend_discharge',function()
		{
			var search = $('#search_attend_discharge').val();
			$.ajax({
				url:"/layout/attendance/attend_discharge_search_by_name.php",
				method:"POST",
				data:{search:search},
				success:function(data)
				{
					$('#attend-table').html(data);
				}
			});
		}); 
	}

	function search_attend_list_revenue_by_name()
	{
		$(document).on('keyup','#search_attend_revenue_name',function()
		{
			var search = $('#search_attend_revenue_name').val();
			$.ajax({
				url:"/layout/attendance/attend_revenue_search_by_name.php",
				method:"POST",
				data:{search:search},
				success:function(data)
				{
					$('#attend-table').html(data);
				}
			});
		}); 
	}

	function search_attend_list_revenue_by_date()
	{
		$(document).on('change keyup','#search_attend_revenue_from, #search_attend_revenue_to',function()
		{
			var company_id = $('#session_company_id').val();
			var date_from = $('#search_attend_revenue_from').val();
			var date_to = $('#search_attend_revenue_to').val();
			$.ajax({
				url:"/layout/attendance/attend_revenue_search_by_date.php",
				method:"POST",
				data:{
				company_id:company_id,
				date_from:date_from,
				date_to:date_to},
				success:function(data)
				{
					$('#attend-table').html(data);
				}
			});
		}); 
	}
	
	function delete_attendance()
	{
		$(document).on('click','#btn_delete_attend',function(){
			var attend_id = $(this).attr('data-id');
			var page = window.location.pathname;
			$('#delete_question').text('Are you sure you want to delete Attendance No:' + attend_id);
			$('#delete_modal_title').text('Delete Attendance');
			$('#delete_modal').modal('show');
			$(document).on('click','#delete_yes',function()
			{
				$.ajax({  
					url:'/layout/attendance/attend_delete.php',  
					type:'POST',  
					data:{attend_id:attend_id},
					success:function()
					{
						$('#delete_modal').modal('hide');
						window.location.href= page;
					}
				});
			});
			$(document).on('click','#delete_no',function()
			{
				$('#delete_modal').modal('hide');
			});
		});
	}
	