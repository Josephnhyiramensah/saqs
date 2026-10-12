$(document).ready(function()
{
	//MISCELLANEOUS
		//MY FOLDER
			//my_folder_modal();
			//my_folder_print();
			patient_folder_display();
			patient_folder_display_from_patient_list();
		//EXCUSE DUTY
			excuse_duty_modal();
			excuse_duty_save();
			excuse_duty_update();
	//APPOINTMENT
		new_appoint_modal();
		calendar_by_appoint_type();
		appoint_show_surgery_div();
		appoint_auto_fill_activity();
		appoint_report_modal();
		appoint_report_display();
		calendar_by_appoint_doctor_theatre();
		appoint_report_by_date_modal();
		appoint_report_by_date_display();
});

	//MISCELLANEOUS
		//MY FOLDER
			/*function my_folder_modal()
			{
				$(document).on('click','#nav_myfolder_1',function()
				{
			    	var patient_id = $('#session_patient_id').val();
			    	$.ajax({  
				             url:'/layout/attendance/my_folder_view.php',  
				             method:'POST',  
				             data:{
				             	patient_id:patient_id
				             },
				             success:function(data){
				             	$('#my_folder_table_main').html(data);
				             	$('#my_folder_modal').modal('show');
				             }  
			        	});
				});
			}

			function my_folder_print()
			{
				$(document).on('click','#my_folder_print',function()
				{
					var patient_id = $('#session_patient_id').val();
			    	$.ajax({  
				             url:'/layout/attendance/my_folder_pdf.php',  
				             method:'POST',  
				             data:{
				             	patient_id:patient_id
				             },
				             success:function(data){
				             	window.open('/layout/attendance/my_folder_pdf_sheet.php', '_blank');
				             }  
			        	});
				});
			}*/

			function patient_folder_display()
			{
				$(document).on('click','#nav_myfolder',function()
				{
			    	var patient_id = $('#session_patient_id').val();
			    	$.ajax({  
				             url:'/layout/reports/patient_folder_processing.php',  
				             method:'POST',  
				             data:{
				             	patient_id:patient_id
				             },
				             success:function(data){
				             	window.open('/layout/reports/patient_folder_display.php', '_blank');
				             }  
			        	});
				});
			}

			function patient_folder_display_from_patient_list()
			{
				$(document).on('click','#nav_myfolder_pl',function()
				{
					var patient_id = $(this).attr('data-id');
			    	$.ajax({  
				             url:'/layout/reports/patient_folder_processing.php',  
				             method:'POST',  
				             data:{
				             	patient_id:patient_id
				             },
				             success:function(data){
				             	window.open('/layout/reports/patient_folder_display.php', '_blank');
				             }  
			        	});
				});
			}

			function excuse_duty_modal()
			{
				$(document).on('click','#nav_new_excuse_duty',function()
				{
			    	var attend_id = $('#session_attend_id').val();
			    	$.ajax({  
						url:'/layout/attendance/excuse_duty_process.php',  
						method:'POST',
						datatype:'JSON', 
						data:{attend_id:attend_id},
						success:function(data)
						{
							var res = $.parseJSON(data);
							$('#excuse_duty_id').val(res[0]);
							$('#excuse_duty_patient').val(res[1]);
							$('#excuse_duty_patientD').val(res[1]);
							$('#excuse_duty_doctor').val(res[2]);
							$('#excuse_duty_diagnosis').val(res[3]);
							$('#excuse_duty_date_admit').val(res[4]);
							$('#excuse_duty_date_discharge').val(res[5]);
							$('#excuse_duty_date').val(res[6]);
							$('#excuse_duty_remarks').val(res[7]);
							if(res[8] == 'new')
							{
								$('#excuse_duty_save').show();
								$('#excuse_duty_update').hide();
							}
							else if(res[8] == 'exist')
							{
								$('#excuse_duty_save').hide();
								$('#excuse_duty_update').show();
							};
							$('#excuse_duty_modal').modal('show');
						}
					});
				});
			}

			function excuse_duty_save()
			{
				$(document).on('click','#excuse_duty_save',function(e){
					e.preventDefault();
					var attend_id = $('#session_attend_id').val();
					var patient_id = $('#session_patient_id').val();
					$.ajax({
						url:'/layout/attendance/excuse_duty_save.php',
						method:'POST',
						data:$('#excuse_duty_modal_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
						success:function(data)
						{
							$('#excuse_duty_modal_form').trigger('reset');
							$('#excuse_duty_modal').modal('hide');
							window.open('/layout/attendance/excuse_duty_pdf.php', '_blank');
						}
					});
				});
			}

			function excuse_duty_update()
			{
				$(document).on('click','#excuse_duty_update',function(e){
					e.preventDefault();
					var attend_id = $('#session_attend_id').val();
					var patient_id = $('#session_patient_id').val();
					$.ajax({
						url:'/layout/attendance/excuse_duty_update.php',
						method:'POST',
						data:$('#excuse_duty_modal_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
						success:function(data)
						{
							$('#excuse_duty_modal_form').trigger('reset');
							$('#excuse_duty_modal').modal('hide');
							window.open('/layout/attendance/excuse_duty_pdf.php', '_blank');
						}
					});
				});
			}
	
	//APPOINTMENT
		function new_appoint_modal()
        {
        	$(document).on('click','#nav_new_appointment',function()
			{
				var name = $('#session_name').val();
				var age = $('#session_age').val();
				var gender = $('#session_gender').val();
	            var dt = new Date();
	            var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
	            $('#ModalAdd #date').val(moment(dt).format('YYYY-MM-DD'));
	            $('#ModalAdd #time').val(time);
	            $('#ModalAdd #name').val(name);
	            $('#ModalAdd #sex').val(gender);
	            $('#ModalAdd #age').val(age);
	            $('#ModalAdd #start').val(moment(dt).format('YYYY-MM-DD HH:mm:ss'));
	            $('#ModalAdd #end').val(moment(dt).format('YYYY-MM-DD HH:mm:ss'));
	            $('#ModalAdd').modal('show');
			});
        }

		function calendar_by_appoint_type()
		{
			$(document).on('click','.btn_appoint_type',function()
			{
				var company_id = $('#appoint_company_id').val();
				var appoint_type = $(this).attr('id');
				var appoint_doctor = 'all_doctors';
				var appoint_theatre = 'all_theatres';
				var d = new Date();
				var startDate = d.getFullYear() + "/" + 1 + "/" + 1;
				var endDate = d.getFullYear() + "/" + 12 + "/" + 31;
				var appoint_start = startDate;
				var appoint_end = endDate;
				$.ajax({
		             url:'/layout/attendance/calendar_by_type_go.php',
		             method:'POST',
		             data:{
		             	company_id:company_id,
		             	appoint_type:appoint_type,
		             	appoint_doctor:appoint_doctor,
		             	appoint_theatre:appoint_theatre,
		             	appoint_start:appoint_start,
		             	appoint_end:appoint_end
		             },
		             success:function(data)
		             {
		             	//window.location.href="/layout/attendance/calendar.php";
             			window.open('/layout/attendance/calendar.php', '_blank');
		             }
		        });
			}); 
		}

		function calendar_by_appoint_doctor_theatre()
		{
			$(document).on('change','#appoint_doctor_cl, #appoint_theatre_cl',function()
			{
				var company_id = $('#appoint_company_id').val();
				var appoint_type = $('#appoint_type_cl').val();
				var appoint_doctor = $('#appoint_doctor_cl').val();
				var appoint_theatre = $('#appoint_theatre_cl').val();
				var d = new Date();
				var startDate = d.getFullYear() + "/" + 1 + "/" + 1;
				var endDate = d.getFullYear() + "/" + 12 + "/" + 31;
				var appoint_start = startDate;
				var appoint_end = endDate;
				$.ajax({
		             url:'/layout/attendance/calendar_by_type_go.php',
		             method:'POST',
		             data:{
		             	company_id:company_id,
		             	appoint_type:appoint_type,
		             	appoint_doctor:appoint_doctor,
		             	appoint_theatre:appoint_theatre,
		             	appoint_start:appoint_start,
		             	appoint_end:appoint_end
		             },
		             success:function(data)
		             {
		             	window.location.href="/layout/attendance/calendar.php";
             			//window.open('/layout/attendance/calendar.php', '_blank');
		             }
		        });
			}); 
		}

		function appoint_show_surgery_div()
		{
			$(document).on('change','#appoint_type',function()
			{
				var appoint_type = $('#appoint_type').val();
				var name = $('#name').val();
				var title = $('#title').val();
				var doctor = $('#doctor').val();
				var surgery = $('#surgery').val();
				if(appoint_type == 1)
				{
					$("#appoint_surgery_div").prop("hidden",false);
				}else
				{
					$("#appoint_surgery_div").prop("hidden",true);
				};


				if(title == '')
				{
					$('#title').val(name +':-'+ doctor +':-'+ surgery);
				};


				if(appoint_type == 1)
				{
					$('#color').val('#FF0000');
				}
				else if(appoint_type == 2)
				{
					$('#color').val('#008000');
				}
				else if(appoint_type == 3)
				{
					$('#color').val('#0071c5');
				}
				else if(appoint_type == 4)
				{
					$('#color').val('#FF8C00');
				};
			});
		}

		function appoint_auto_fill_activity()
		{
			$(document).on('change keyup','#name, #doctor, #surgery',function()
			{
				var appoint_type = $('#appoint_type').val();
				var name = $('#name').val();
				var title = $('#title').val();
				var doctor = $('#doctor').val();
				var surgery = $('#surgery').val();

				$('#title').val(name +':-'+ doctor +':-'+ surgery);
			});
		}

		function appoint_report_modal()
		{
			$(document).on('click','#appoint_report_link',function()
			{
				var company_id = $('#session_company_id').val();
				var user_super_id = $('#session_user_super_id').val();
				$('#appointment_report_modal_form').trigger('reset');
				$('#appoint_company_id').val(company_id);
				$('#appoint_user_super_id').val(user_super_id);
				$('#appointment_report_modal').modal('show');
			});
		}

		function appoint_report_display()
		{
			$(document).on('click','#appointment_report_ok_btn',function()
			{
				var d = new Date();
				var startDate = d.getFullYear() + "/01/01";
				var endDate = d.getFullYear() + "/12/31";
				var appoint_start = startDate;
				var appoint_end = endDate;

				var appoint_type = $('#appoint_type').val();
				var appoint_doctor = $('#appoint_doctor').val();
				var appoint_theatre = $('#appoint_theatre').val();
				if (appoint_type !== "") 
				{
					if (appoint_doctor !== "") 
					{
						if (appoint_theatre !== "") 
						{
							$.ajax({
					             url:'/layout/reports/appointment_report_processing.php',
					             method:'POST',
					             data:{
					             	appoint_type:appoint_type,
					             	appoint_doctor:appoint_doctor,
					             	appoint_theatre:appoint_theatre,
					             	appoint_start:appoint_start,
					             	appoint_end:appoint_end
					             },
					             success:function(data)
						             {
				             			$('#appointment_report_modal').modal('hide');
		             					//window.location.href="/layout/attendance/calendar.php";
				             			window.open('/layout/attendance/calendar.php', '_blank');
						             }
					        });	
						} 
						else 
						{
							$('#appointment_report_modal_warning').html('<h6 style=color:red;>Please the Theatre cannot be EMPTY!</h6>');
							$('#appointment_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#appointment_report_modal_warning').html('<h6 style=color:red;>Please the Doctor cannot be EMPTY!</h6>');
						$('#appointment_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
					};
				} 
				else 
				{
					$('#appointment_report_modal_warning').html('<h6 style=color:red;>Please the Appointment Type cannot be EMPTY!</h6>');
					$('#appointment_report_modal_warning').hide().slideDown().delay(2000).fadeOut();
				};
			});
		}

		function appoint_report_by_date_modal()
		{
			$(document).on('click','#appoint_report_by_date_link',function()
			{
				var company_id = $('#session_company_id').val();
				var user_super_id = $('#session_user_super_id').val();
				$('#appointment_report_by_date_modal_form').trigger('reset');
				$('#appoint_company_id_abd').val(company_id);
				$('#appoint_user_super_id_abd').val(user_super_id);
				$('#appointment_report_by_date_modal').modal('show');
			});
		}

		function appoint_report_by_date_display()
		{
			$(document).on('click','#appointment_report_by_date_ok_btn',function()
			{
				var appoint_start = $('#appoint_start_date_abd').val();
				var appoint_end = $('#appoint_end_date_abd').val();
				var appoint_type = $('#appoint_type_abd').val();
				var appoint_doctor = $('#appoint_doctor_abd').val();
				var appoint_theatre = $('#appoint_theatre_abd').val();
				if (appoint_type !== "") 
				{
					if (appoint_doctor !== "") 
					{
						if (appoint_theatre !== "") 
						{
							if (appoint_start !== "") 
							{
								if (appoint_end !== "") 
								{
									if (appoint_end >= appoint_start) 
									{
										$.ajax({
								             url:'/layout/reports/appointment_report_processing.php',
								             method:'POST',
								             data:{
								             	appoint_type:appoint_type,
								             	appoint_doctor:appoint_doctor,
								             	appoint_theatre:appoint_theatre,
								             	appoint_start:appoint_start,
								             	appoint_end:appoint_end
								             },
								             success:function(data)
									             {
							             			$('#appointment_report_by_date_modal').modal('hide');
					             					//window.location.href="/layout/attendance/calendar.php";
							             			window.open('/layout/reports/appointment_report_by_date_display.php', '_blank');
									             }
								        });	
									} 
									else 
									{
										$('#appointment_report_by_date_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be less than the Start Date!</h6>');
										$('#appointment_report_by_date_modal_warning').hide().slideDown().delay(2000).fadeOut();
									};
								} 
								else 
								{
									$('#appointment_report_by_date_modal_warning').html('<h6 style=color:red;>Please the End Date cannot be EMPTY!</h6>');
									$('#appointment_report_by_date_modal_warning').hide().slideDown().delay(2000).fadeOut();
								};
							} 
							else 
							{
								$('#appointment_report_by_date_modal_warning').html('<h6 style=color:red;>Please the Start Date cannot be EMPTY!</h6>');
								$('#appointment_report_by_date_modal_warning').hide().slideDown().delay(2000).fadeOut();
							};
						} 
						else 
						{
							$('#appointment_report_by_date_modal_warning').html('<h6 style=color:red;>Please the Theatre cannot be EMPTY!</h6>');
							$('#appointment_report_by_date_modal_warning').hide().slideDown().delay(2000).fadeOut();
						};
					} 
					else 
					{
						$('#appointment_report_by_date_modal_warning').html('<h6 style=color:red;>Please the Doctor cannot be EMPTY!</h6>');
						$('#appointment_report_by_date_modal_warning').hide().slideDown().delay(2000).fadeOut();
					};
				} 
				else 
				{
					$('#appointment_report_by_date_modal_warning').html('<h6 style=color:red;>Please the Appointment Type cannot be EMPTY!</h6>');
					$('#appointment_report_by_date_modal_warning').hide().slideDown().delay(2000).fadeOut();
				};
			});
		}