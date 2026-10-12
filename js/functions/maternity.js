$(document).ready(function()
{
	//MATERNITY
		go_to_pregnancy_anc_sheet();
		go_to_pregnancies_from_anc();
		new_pregnancy();
		disable_new_pregnancy_btn();
		previous_pregnancy();
		set_EDD();
		set_LMP();
		//set_gestation_age();
		preg_thru_specify();
		save_pregnancy();
		edit_pregnancy();
		update_pregnancy();
		cancel_pregnancy();
		view_pregnancies();
		go_to_anc_sheet();
		cancel_anc_form();
		save_anc_form();
		view_anc_list();
		edit_anc_sheet();
		update_anc_sheet();
		anc_maternity_leave_setup();
		anc_maternity_leave_save();
		anc_maternity_leave_edit();
		anc_maternity_leave_update();
		cancel_anc_maternity_leave_setup();
		go_to_delivery_sheet();
		delivery_autofill_input();
		save_delivery();
		cancel_delivery_sheet();
		view_delivery();
		edit_delivery();
		update_delivery();
		new_child_modal();
		new_child_modal_pop();
		apgar_score_at_1min();
		apgar_score_at_5min();
		save_child();
		view_children();
		edit_child();
		update_child();
		//PARTOGRAPH
			parto_fhr_modal();
			parto_fhr_save();
			parto_fhr_view();
			parto_fhr_edit();
			parto_fhr_update();
			/*parto_amniotic_modal();
			parto_amniotic_save();
			parto_amniotic_view();
			parto_moulding_modal();
			parto_moulding_save();
			parto_moulding_view();
			parto_cervix_descent_modal();
			parto_cervix_descent_save();
			parto_cervix_descent_view();
			parto_contractions_modal();
			parto_contractions_save();
			parto_contractions_view();
			parto_oxytocin_modal();
			parto_oxytocin_save();
			parto_oxytocin_view();
			parto_drug_modal();
			parto_drugs_save();
			parto_drugs_view();
			parto_pulse_bp_modal();
			parto_pulse_bp_save();
			parto_pulse_bp_view();
			parto_temp_modal();
			parto_temp_save();
			parto_temp_view();
			parto_urine_modal();
			parto_urine_save();
			parto_urine_view();*/
		go_to_pnc_sheet();
		pnc_child_modal();
		pnc_child_save();
		save_pnc_sheet();
		cancel_pnc_sheet();
		edit_pnc_sheet();
		update_pnc_sheet();
		pnc_child_edit();
		pnc_child_update();
		view_pnc_list();
});

	//MATERNITY
		//PREGNANCIES
		function go_to_pregnancy_anc_sheet()
		{
			$(document).on('click','#nav_maternity',function()
			{
				var attend_id = $('#session_attend_id').val();
				var patient_id = $('#session_patient_id').val();
				$.ajax({
					 url:'/layout/attendance/maternity_pregnancy_search.php',
					 method:'POST',
					 datatype: 'JSON',
					 data:{attend_id:attend_id, patient_id:patient_id},
					 success:function(data)
					 {
						 var res = $.parseJSON(data);
						 if (res[0] == 'exist') 
						 {
							 window.location.href="/layout/attendance/maternity_anc_sheet.php";
							$('#anc_current_form').trigger('reset');
						 } 
						 else if(res[0] == 'none')
						 {
							 window.location.href="/layout/attendance/maternity_pregnancies_sheet.php";
							//$('#pregnancy_form').trigger('reset');
						 };
					 }
				});
			});
		}

		function go_to_pregnancies_from_anc()
		{
			$(document).on('click','#pregnancies_btn',function()
			{
				 window.location.href="/layout/attendance/maternity_pregnancies_sheet.php";
			 });
		}

		function new_pregnancy()
		{
			$(document).on('click','#pregnancy_new_btn',function()
			{
				$('#new_pregnancy_details').show();
				$('#previous_pregnancy_details').hide();
				$('#pregnancy_form').trigger('reset');
				$('#pregnancy_modal_title').text('New Pregnancy Setup Form');
				$('#pregnancy_save_update').html('<button type="submit" id="pregnancy_save_btn" name="pregnancy_save_btn" class="btn btn-primary">Save</button>');
				$('#pregnancy_type').val('new');
				$('#pregnancy_modal').modal('show');
			});
		}

		function previous_pregnancy()
		{
			$(document).on('click','#pregnancy_previous_btn',function()
			{
				$('#new_pregnancy_details').show();
				$('#previous_pregnancy_details').show();
				$('#pregnancy_form').trigger('reset');
				$('#pregnancy_modal_title').text('Previous Pregnancy Setup Form');
				$('#pregnancy_save_update').html('<button type="submit" id="pregnancy_save_btn" name="pregnancy_save_btn" class="btn btn-primary">Save</button>');
				$('#pregnancy_type').val('previous');
				$('#pregnancy_modal').modal('show');
			});
		}

		function set_EDD()
		{
			$(document).on('change keyup','#lmp',function()
			{
				var lmp = $('#lmp').val();
				var pregnancy_type = $('#pregnancy_type').val();
				var someDate = new Date(lmp);
				someDate.setDate(someDate.getDate() + 280); //number  of days to add, e.x. 15 days
				var dateFormated = someDate.toISOString().substr(0,10);
				$('#edd').val(dateFormated);
				if(pregnancy_type =='previous'){$('#date_delivery').val(dateFormated);};
			});
		}

		function set_LMP()
		{
			$(document).on('change keyup','#edd',function()
			{
				var edd = $('#edd').val();
				var pregnancy_type = $('#pregnancy_type').val();
				var someDate = new Date(edd);
				someDate.setDate(someDate.getDate() - 280); //number  of days to add, e.x. 15 days
				var dateFormated = someDate.toISOString().substr(0,10);
				$('#lmp').val(dateFormated);
				if(pregnancy_type =='previous'){$('#date_delivery').val(edd);};
			});
		}

		function preg_thru_specify()
		{
			$(document).on('change keyup','#preg_thru',function()
			{
				var preg_thru = $('#preg_thru').val();
				if(preg_thru =='Others')
				{
					$("#preg_thru_div").prop("class","col-md-2 mb-2");
					$("#preg_thru_specify_div").prop("hidden",false);
				}else
				{
					$('#preg_thru_specify').val('');
					$("#preg_thru_div").prop("class","col-md-6 mb-6");
					$("#preg_thru_specify_div").prop("hidden",true);
				};
			});
		}

		function save_pregnancy_action()
		{
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				 url:'/layout/attendance/maternity_pregnancy_save.php',
				 method:'POST',
				 data:$('#pregnancy_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				 success:function(data)
					{
						$('#pregnancy_modal').modal('hide');
						view_pregnancies();
					}
			});
		}

		function save_pregnancy()
		{
			$(document).on('click','#pregnancy_save_btn',function(e){
				e.preventDefault();
				var lmp = $('#lmp').val();
				var edd = $('#edd').val();
				var risk_factors = $('#risk_factors').val();
				var preg_through = $('#preg_thru').val();
				var preg_thru_specify = $('#preg_thru_specify').val();
				var date_delivery = $('#date_delivery').val();
				var method_delivery = $('#method_delivery').val();
				var labour_type = $('#labour_type').val();
				var gestation_age = $('#gestation_age').val();
				var pregnancy_type = $('#pregnancy_type').val();

				var today = new Date();
				var expected_date = new Date($('#edd').val());
				
				if(pregnancy_type == 'new')
				{
					/*if(lmp !=="")
					{*/
						if(edd !=="")
						{
							if (today <= expected_date)
							{
								/*if(risk_factors !=="")
								{*/
									if(preg_through ==0)
									{
										alert('Select Pregnancy Through!');
									}
									else
									{
										if(preg_through == 'Others' && preg_thru_specify !=="")
										{
											save_pregnancy_action();
										}
										else if(preg_through == 'Others' && preg_thru_specify =="")
										{
											alert('Specify other Pregnancy Through!');
										}
										else if(preg_through !== 'Others' && preg_thru_specify =="")
										{
											save_pregnancy_action();
										};
									};
								/*}
								else
								{
									alert('Risk factor cannot be empty!');
								};*/
							}
							else
							{
								alert('EDD cannot be less than todays date!');
							};
						}
						else
						{
							alert('EDD cannot be empty!');
						};
					/*}
					else
					{
						alert('LMP cannot be empty!');
					};*/
				}
				else if(pregnancy_type == 'previous')
				{
					if(date_delivery !=="")
					{
						if(method_delivery !== 0)
						{
							if(labour_type !== 0)
							{
								if(gestation_age !== 0)
								{
									if(lmp !=="")
									{
										if(edd !=="")
										{
											/*if(risk_factors !=="")
											{*/
												if(preg_through ==0)
												{
													alert('Select Pregnancy Through!');
												}
												else
												{
													if(preg_through == 'Others' && preg_thru_specify !=="")
													{
														save_pregnancy_action();
													}
													else if(preg_through == 'Others' && preg_thru_specify =="")
													{
														alert('Specify other Pregnancy Through!');
													}
													else if(preg_through !== 'Others' && preg_thru_specify =="")
													{
														save_pregnancy_action();
													};
												};
											/*}
											else
											{
												alert('Risk factor cannot be empty!');
											};*/
										}
										else
										{
											alert('EDD cannot be empty!');
										};
									}
									else
									{
										alert('LMP cannot be empty!');
									};
								}
								else
								{
									alert('Gestation age cannot be empty!');
								};
							}
							else
							{
								alert('Labour type cannot be empty!');
							};
						}
						else
						{
							alert('Method of Delivery cannot be empty!');
						};
					}
					else
					{
						alert('Delivery date cannot be empty!');
					};
				};
			});
		}

		function edit_pregnancy()
		{
			$(document).on('click','#btn_edit_preg',function(){
				var preg_id = $(this).attr('data-id');
				$.ajax({  
						 url:'/layout/attendance/maternity_pregnancy_edit.php',  
						 type:'POST',  
						 data:{preg_id:preg_id},
						 datatype: 'JSON',
						 success:function(data){
							 var res = $.parseJSON(data);
							 $('#pregnancy_id').val(res[0]);
							 $('#lmp').val(res[1]);
							 $('#edd').val(res[2]);
							 $('#preg_problem').val(res[3]);
							 $('#preg_outcome').val(res[4]);
							$('#labour_type').val(res[5]);
							$('#post_partum').val(res[6]);
							$('#indication').val(res[7]);
							 $('#preg_comment').val(res[8]);
							 $('#method_delivery').val(res[9]);
							 $('#date_delivery').val(res[10]);
							$('#preg_condition').val(res[11]);
							$('#weight_1').val(res[12]);
							$('#weight_2').val(res[13]);
							$('#weight_3').val(res[14]);
							$('#height_1').val(res[15]);
							$('#height_2').val(res[16]);
							 $('#height_3').val(res[17]);
							 $('#gender_1').val(res[18]);
							 $('#gender_2').val(res[19]);
							$('#gender_3').val(res[20]);
							$('#risk_factors').val(res[21]);
							$('#preg_thru').val(res[22]);
							 $('#preg_thru_specify').val(res[23]);
							 $('#gestation_age').val(res[24]);
							$('#pregnancy_save_update').html('<button type="submit" name="preg_update_btn" id="preg_update_btn" class="btn btn-primary">Update</button>');
							$('#new_pregnancy_details').show();
							$('#previous_pregnancy_details').show();
							$('#pregnancy_modal').modal('show');
						 }  
					});
			  }); 
		}

		function update_pregnancy()
		{
			$(document).on('click','#preg_update_btn',function(e){
				var edd = $('#edd').val();
				if (edd !=="") 
					{
						var attend_id = $('#session_attend_id').val();
						var patient_id = $('#session_patient_id').val();
						$.ajax({
							 url:'/layout/attendance/maternity_pregnancy_update.php',
							 method:'POST',
							 data:$('#pregnancy_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
							 success:function(data)
								 {
									$('#pregnancy_modal').modal('hide');
									 view_pregnancies();
								 }
						});
					} 
					else 
					{
						e.preventDefault();
						alert('Please provide the EDD for the pregnancy!');
					}
			});
		}

		function cancel_pregnancy()
		{
			$(document).on('click','#pregnancy_cancel_btn',function(){
				$('#pregnancy_modal').modal('hide');
			});
		}

		function disable_new_pregnancy_btn()
		{
				var patient_id = $('#session_patient_id').val();
				$.ajax({
					 url:'/layout/attendance/maternity_new_pregnancy_btn_disabled.php',
					 method:'POST',
					 data:{
						 patient_id:patient_id
					 },
					 success:function(data)
						 {
							 if (data == 'exist') 
							 {
								$('#new_pregnancy_div').prop('hidden', true);
							 } 
							 else if(data == 'none')
							 {
								$('#new_pregnancy_div').prop('hidden', false);
							 };
						 }
					 });
		}

		function view_pregnancies()
		{
				var patient_id = $('#session_patient_id').val();
				$.ajax({
					 url:'/layout/attendance/maternity_pregnancy_view.php',
					 method:'POST',
					 data:{
						 patient_id:patient_id
					 },
					 success:function(data)
						 {
							 $('#patient_pregnancy_table').html(data);
							 disable_new_pregnancy_btn();
						 }
					 });
		}
	//ANC
		function go_to_anc_sheet()
		{
			$(document).on('click','#preg_anc_sheet',function()
			{
				var preg_id = $(this).attr('data-id');
				$.ajax({
					 url:'/layout/attendance/maternity_anc_open.php',
					 method:'POST',
					 data:{preg_id:preg_id},
					 success:function()
						 {
							 window.location.href="/layout/attendance/maternity_anc_sheet.php";
							 $('#anc_save_update').html('<button type="submit" name="anc_save_btn" id="anc_save_btn" class="btn btn-primary">Save</button>');
							 $('#anc_current_form').trigger('reset');
						 }
				});
				
			});
		}

		function cancel_anc_form()
		{
			$(document).on('click','#anc_cancel_btn',function()
			{
				$('#anc_current_form').trigger('reset');
				$('#anc_save_update').html('<button type="submit" name="anc_save_btn" id="anc_save_btn" class="btn btn-primary">Save</button>');
			});
		}

		function save_anc_form()
		{
			$(document).on('click','#anc_save_btn',function(e){
				var date = $('#anc_date').val();
				if (date !=="") 
					{
						var attend_id = $('#session_attend_id').val();
						var patient_id = $('#session_patient_id').val();
						var preg_id = $('#session_preg_id').val();
						$.ajax({
							 url:'/layout/attendance/maternity_anc_save.php',
							 method:'POST',
							 data:$('#anc_current_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id + '&preg_id=' + preg_id,
							 success:function(data)
								 {
									 $('#anc_current_form').trigger('reset');
									 view_anc_list();
								 }
							 });
					} 
					else 
					{
						e.preventDefault();
						alert('Please provide the date for the ANC visit!');
					}
			});
		}

		function view_anc_list()
		{
			var preg_id = $('#session_preg_id').val();
			$.ajax({
				 url:'/layout/attendance/maternity_anc_view.php',
				 method:'POST',
				 data:{
					 preg_id:preg_id
				 },
				 success:function(data)
					 {
						 $('#patient_anc_table').html(data);
					 }
			});
		}

		function edit_anc_sheet()
		{
			$(document).on('click','#btn_edit_anc_sheet',function(){
				var anc_id = $(this).attr('data-id1');
				$.ajax({  
						 url:'/layout/attendance/maternity_anc_edit.php',  
						 type:'POST',  
						 data:{anc_id:anc_id},
						 datatype: 'JSON',
						 success:function(data){
							 var res = $.parseJSON(data);
							 $('#anc_id').val(res[0]);
							 $('#preg_id').val(res[1]);
							 $('#anc_weight').val(res[2]);
							 $('#anc_urine_sugar').val(res[3]);
							 $('#anc_urine_protein').val(res[4]);
							$('#anc_bp_systolic').val(res[5]);
							$('#anc_bp_diastolic').val(res[6]);
							$('#anc_gest_age').val(res[7]);
							 $('#anc_fundal_height').val(res[8]);
							 $('#anc_fhr').val(res[9]);
							 $('#anc_present').val(res[10]);
							$('#anc_descent').val(res[11]);
							$('#anc_tt_episode').val(res[12]);
							$('#anc_tt_qty').val(res[13]);
							$('#anc_ifa_given').val(res[14]);
							$('#anc_sp_episode').val(res[15]);
							$('#anc_sp_qty').val(res[16]);
							 $('#anc_g6pd').val(res[17]);
							 $('#anc_hiv_status').val(res[18]);
							 $('#anc_syphillis_status').val(res[19]);
							$('#anc_tb_diagnosed').val(res[20]);
							$('#anc_arv_treat').val(res[21]);
							$('#anc_syphillis_treat').val(res[22]);
							 $('#anc_tb_treat').val(res[23]);
							 $('#anc_date').val(res[24]);
							 $('#anc_hp').val(res[25]);
							$('#anc_itn').val(res[26]);
							$('#anc_comment').val(res[27]);
							$('#anc_fundal_weight').val(res[28]);
							$('#anc_save_update').html('<button type="submit" name="anc_update_btn" id="anc_update_btn" class="btn btn-primary">Update</button>');
						 }  
					});
			  }); 
		}

		function update_anc_sheet()
		{
			$(document).on('click','#anc_update_btn',function(){
				var date = $('#anc_date').val();
				if (date !=="") 
					{
						var attend_id = $('#session_attend_id').val();
						var patient_id = $('#session_patient_id').val();
						var preg_id = $('#session_preg_id').val();
						var anc_id = $('#anc_id').val();
						$.ajax({
							 url:'/layout/attendance/maternity_anc_update.php',
							 method:'POST',
							 data:$('#anc_current_form').serialize() 
									 + '&attend_id=' + attend_id 
									 + '&patient_id=' + patient_id 
									 + '&preg_id=' + preg_id 
									 + '&anc_id=' + anc_id,
							 success:function(data)
								 {
									 $('#anc_current_form').trigger('reset');
									 $('#anc_save_update').html('<button type="submit" name="anc_save_btn" id="anc_save_btn" class="btn btn-primary">Save</button>');
									 view_anc_list();
								 }
							 });
					} 
					else 
					{
						e.preventDefault();
						alert('Please provide the date for the ANC visit!');
					}
			});
		}
	//DELIVERY
		//MOTHER
			//MAIN
				function go_to_delivery_sheet()
				{
					$(document).on('click','#preg_delivery_sheet, #anc_delivery_btn',function()
					{
						open_delivery_sheet();
					});
				}

				function open_delivery_sheet()
				{
					var patient_id = $('#session_patient_id').val();
					var preg_id_1 = $('#session_preg_id').val();
					var preg_id_2 = $(this).attr('data-id1');

					if(preg_id_1 == "" && preg_id_2 == "")
						{
							var preg_id = 0;
						}
						else if(preg_id_1 !== "" && preg_id_2 == "")
						{
							var preg_id = preg_id_1;
						}
						else if(preg_id_1 == "" && preg_id_2 !== "")
						{
							var preg_id = preg_id_2;
						}
						else if(preg_id_1 !== "" && preg_id_2 !== "")
						{
							var preg_id = preg_id_2;
						};

					$.ajax({
						 url:'/layout/attendance/maternity_delivery_open.php',
						 method:'POST',
						 datatype:'JSON',
						 data:{
							 preg_id:preg_id,
							 patient_id:patient_id
						 },
						 success:function(data)
						 {
							 var res = $.parseJSON(data);
							 if (res[0] =='exist') 
							 {	
								 window.location.href="/layout/attendance/maternity_delivery_sheet.php";
								 view_delivery();
							 } 
							 else if(res[0] == 'none')
							 {
								 window.location.href="/layout/attendance/maternity_delivery_sheet.php";
								 delivery_autofill_input();
							 };
						 }
					});	
				}

				function delivery_autofill_input()
				{
					var patient_id = $('#session_patient_id').val();
					var delivery_state = $('#session_delivery_state').val();
					if (delivery_state == 'none') 
					{
						var preg_id = $('#session_preg_id').val();
						var gravida = $('#session_gravida').val();
						var para = $('#session_para').val();
						var abortions = $('#session_abortions').val();
						var induced = $('#session_induced').val();
						var spontaneous = $('#session_spontaneous').val();
						var lmp = $('#session_LMP').val();
						var edd = $('#session_EDD').val();
						var blood_group = $('#session_BloodGroup').val();
						var sickling = $('#session_sickling').val();
						var geno_type = $('#session_geno_type').val();

						$('#delivery_attend_form').trigger('reset');
						$('#gravida').val(gravida);
						$('#para').val(para);
						$('#abortions').val(abortions);
						$('#induced').val(induced);
						$('#spontaneous').val(spontaneous);
						$('#lmp').val(lmp);
						$('#edd').val(edd);
						$('#blood_group').val(blood_group);
						$('#sickling').val(sickling);
						$('#geno_type').val(geno_type);
						$('#deliver_children').hide();
						$('#deliver_labour_chart').hide();
						$('#deliver_partograph').hide();
						$('#children').hide();
						$('#labour_chart').hide();
						$('#partograph').hide();
						$('#delivery_update_btn').hide();
						$('#delivery_edit_btn').hide();
						$('#delivery_save_btn').show();
						$('#delivery_cancel_btn').show();
					};
				}

				function save_delivery()
				{
					$(document).on('click','#delivery_save_btn',function(e){
						e.preventDefault();
						var start_date = $('#delivery_start_date').val();
						var start_time = $('#delivery_start_time').val();
						var end_date = $('#delivery_end_date').val();
						var end_time = $('#delivery_end_time').val();
						if (start_date !=="") 
						{
							if (start_time !=="") 
							{
								var attend_id = $('#session_attend_id').val();
								var patient_id = $('#session_patient_id').val();
								var preg_id = $('#session_preg_id').val();
								$.ajax({
									 url:'/layout/attendance/maternity_delivery_save.php',
									 method:'POST',
									 data:$('#delivery_attend_form').serialize() 
											 + '&attend_id=' + attend_id 
											 + '&patient_id=' + patient_id 
											 + '&preg_id=' + preg_id 
											 + '&start_date=' + start_date 
											 + '&start_time=' + start_time 
											 + '&end_date=' + end_date 
											 + '&end_time=' + end_time,
									 success:function(data)
										 {
											 $('#delivery_attend_form').trigger('reset');
											 open_delivery_sheet();
											 new_child_modal_pop();
										 }
									 });
							} 
							else 
							{
								alert('Please provide the Delivery Time!');
							};
						} 
						else 
						{
							alert('Please provide the Delivery Date!');
						};
					});
				}

				function cancel_delivery_sheet()
				{
					$(document).on('click','#delivery_cancel_btn',function(){
						$('#maternity_leave_form').trigger('reset');
						open_delivery_sheet();
					});
				}

				function view_delivery()
				{
					var patient_id = $('#session_patient_id').val();
					var attend_id= $('#session_attend_id').val();
					var preg_id = $('#session_preg_id').val();
					var delivery_state = $('#session_delivery_state').val();
					if (delivery_state == 'exist') 
					{
						$.ajax({  
								 url:'/layout/attendance/maternity_delivery_view.php',  
								 method:'POST',  
								 datatype:'JSON', 
								 data:{
									 attend_id:attend_id, 
									 patient_id:patient_id,
									 preg_id:preg_id
								 },
								 success:function(data){
									 $('#delivery_mother_table').html(data);
									 $('#delivery_attend_form').hide();
									$('#delivery_mother_table').show();
									$('#delivery_update_btn').hide();
									$('#delivery_edit_btn').show();
									$('#delivery_save_btn').hide();
									$('#delivery_cancel_btn').hide();
								 }  
							});
					}
				}

				function edit_delivery()
				{
					$(document).on('click','#delivery_edit_btn',function(){
						var delivery_state = $('#session_delivery_state').val();
						var patient_id = $('#session_patient_id').val();
						var preg_id = $('#session_preg_id').val();
						if (delivery_state == 'exist') 
						{
							$.ajax({  
								 url:'/layout/attendance/maternity_delivery_edit.php',  
								 type:'POST',  
								 data:{preg_id:preg_id,patient_id:patient_id},
								 datatype: 'JSON',
								 success:function(data)
									 {
										 var res = $.parseJSON(data);
										 $('#delivery_id').val(res[0]);
										 $('#delivery_start_date').val(res[4]);
										 $('#delivery_start_time').val(res[5]);
										 $('#delivery_end_date').val(res[6]);
										 $('#delivery_end_time').val(res[7]);
										$('#gravida').val(res[8]);
										$('#para').val(res[9]);
										$('#abortions').val(res[10]);
										 $('#induced').val(res[11]);
										 $('#spontaneous').val(res[12]);
										 $('#lmp').val(res[13]);
										$('#edd').val(res[14]);
										$('#no_of_anc_visits').val(res[15]);
										$('#blood_group').val(res[16]);
										$('#sickling').val(res[17]);
										$('#geno_type').val(res[18]);
										$('#gestation_age').val(res[19]);
										 $('#syphillis').val(res[20]);
										 $('#heb_b').val(res[21]);
										 $('#pmtct').val(res[22]);
										$('#an_cort').val(res[23]);
										$('#other_interventions').val(res[24]);
										$('#labour_complication').val(res[25]);
										 $('#bp_systolic').val(res[26]);
										 $('#bp_diastolic').val(res[27]);
										 $('#pulse').val(res[28]);
										 $('#temp').val(res[29]);
										 $('#fhr').val(res[30]);
										 $('#lie_present').val(res[31]);
										 $('#cervical_dilitation').val(res[32]);
										$('#partograph_used').val(res[33]);
										$('#perineum').val(res[34]);
										$('#auxilliary_temp').val(res[35]);
										 $('#stillbirth').val(res[36]);
										 $('#apgar_score').val(res[37]);
										 $('#Mode_of_delivery').val(res[38]);
										$('#cs_on_account').val(res[39]);
										$('#oxytocin_10min').val(res[40]);
										$('#oxytocin_time').val(res[41]);
										$('#est_blood_loss').val(res[42]);
										$('#placenta_time').val(res[43]);
										$('#placenta_state').val(res[44]);
										 $('#bp_systolic_post').val(res[45]);
										 $('#bp_diastolic_post').val(res[46]);
										 $('#temp_post').val(res[47]);
										$('#pulse_post').val(res[48]);
										$('#resp_rate_post').val(res[49]);
										$('#vit_a_post').val(res[50]);
										 $('#mother_state').val(res[51]);
										 $('#transferred_to').val(res[52]);
										 $('#transferred_date').val(res[53]);
										 $('#transferred_time').val(res[54]);
										 $('#post_mother_comment').val(res[55]);
										$('#delivered_by').val(res[56]);
										$('#designation').val(res[57]);
										$('#delivered_date').val(res[58]);
										 $('#delivered_time').val(res[59]);
										 $('#final_comment').val(res[60]);
										$('#labour_type').val(res[61]);
										$('#outcome').val(res[62]);
										 $('#condition').val(res[63]);
										 $('#post_partum').val(res[64]);
										$('#delivery_save_btn').hide();
										$('#delivery_edit_btn').hide();
										$('#delivery_update_btn').show();
										$('#delivery_cancel_btn').show();
										$('#delivery_mother_table').hide();
										$('#delivery_attend_form').show();
									 }  
							});
						}
					}); 
				}

				function update_delivery()
				{
					$(document).on('click','#delivery_update_btn',function(e){
						e.preventDefault();
						var start_date = $('#delivery_start_date').val();
						var start_time = $('#delivery_start_time').val();
						var end_date = $('#delivery_end_date').val();
						var end_time = $('#delivery_end_time').val();
						if (start_date !=="") 
						{
							if (start_time !=="") 
							{
								var attend_id = $('#session_attend_id').val();
								var patient_id = $('#session_patient_id').val();
								var preg_id = $('#session_preg_id').val();
								$.ajax({
									 url:'/layout/attendance/maternity_delivery_update.php',
									 method:'POST',
									 data:$('#delivery_attend_form').serialize() 
											 + '&attend_id=' + attend_id 
											 + '&patient_id=' + patient_id 
											 + '&preg_id=' + preg_id 
											 + '&start_date=' + start_date 
											 + '&start_time=' + start_time 
											 + '&end_date=' + end_date 
											 + '&end_time=' + end_time,
									 success:function(data)
										 {
											 $('#delivery_attend_form').trigger('reset');
											 view_delivery();
											 new_child_modal_pop();
										 }
									 });
							} 
							else 
							{
								alert('Please provide the Delivery Time!');
							};
						} 
						else 
						{
							alert('Please provide the Delivery Date!');
						};
					});
				}
			//PARTOGRAPH
				function parto_fhr_modal()
				{
					$(document).on('click','#add_fhr_btn',function()
					{
						$('#parto_fhr_form').trigger('reset');
						$('#parto_fhr_update_btn').hide();
						$('#parto_fhr_modal').modal('show');
					});
				}

				function parto_fhr_save()
				{
					$(document).on('click','#parto_fhr_save_btn',function(e)
					{
						e.preventDefault();
						var delivery_id = $('#session_delivery_id').val();
						var patient_id = $('#session_patient_id').val();
						var attend_id = $('#session_attend_id').val();
						var preg_id = $('#session_preg_id').val();

						var date = $('#parto_fhr_date').val();
						var time = $('#parto_fhr_time').val();
						var value = $('#parto_fhr_value').val();
						var read_by = $('#parto_fhr_read_by').val();
						var remarks = $('#parto_fhr_remarks').val();
						if(date !=="")
						{
							if(time !=="")
							{
								if(read_by !=="")
								{
									$.ajax({
										 url:'/layout/attendance/maternity_delivery_parto_fhr_save.php',
										 method:'POST',
										 data:$('#parto_fhr_form').serialize() 
												 + '&attend_id=' + attend_id + '&patient_id=' 
												 + patient_id + '&delivery_id=' + delivery_id 
												 + '&preg_id=' + preg_id,
										 success:function(data)
											{
												$('#parto_fhr_modal').modal('hide');
												parto_fhr_view();
											}
									});
								}
								else
								{
									alert('Please enter the name of the staff recording!');
								};
							}
							else
							{
								alert('Please select the recording time!');
							};
						}
						else
						{
							alert('Please select the recording date!');
						};
					 });
				}

				function parto_fhr_view()
				{
					var patient_id = $('#session_patient_id').val();
					var attend_id= $('#session_attend_id').val();
					var preg_id = $('#session_preg_id').val();
					var delivery_id = $('#session_delivery_id').val();
					$.ajax({  
							 url:'/layout/attendance/maternity_delivery_parto_fhr_view.php',  
							 method:'POST',  
							 datatype:'JSON', 
							 data:{
								 attend_id:attend_id, 
								 patient_id:patient_id,
								 preg_id:preg_id,
								 delivery_id:delivery_id
							 },
							 success:function(data){
								 $('#parto_fhr_table').html(data);
							 }  
						});
				}
	
				function parto_fhr_edit()
				{
					$(document).on('click','#btn_edit_parto_fhr',function(){
						var parto_fhr_id  = $(this).attr('data-id');
						$.ajax({
							 url:'/layout/attendance/maternity_delivery_parto_fhr_edit.php',
							 method:'POST',
							 data:{parto_fhr_id:parto_fhr_id},
							 datatype:'JSON',
							 success:function(data)
							 {
								 var res = $.parseJSON(data);
								 $('#parto_fhr_id').val(res[0]);
								 $('#parto_fhr_date').val(res[1]);
								 $('#parto_fhr_time').val(res[2]);
								 $('#parto_fhr_value').val(res[3]);
								 $('#parto_moulding_v').val(res[4]);
								 $('#parto_amniotic_v').val(res[5]);
								 $('#parto_cd_cervix_v').val(res[6]);
								 $('#parto_cd_descent_v').val(res[7]);
								 $('#parto_contra_less20_v').val(res[8]);
								 $('#parto_contra_2040_v').val(res[9]);

								 $('#parto_contra_more40_v').val(res[10]);
								 $('#parto_temp_v').val(res[11]);
								 $('#parto_pbp_pulse_v').val(res[12]);
								 $('#parto_pbp_systolic_v').val(res[13]);
								 $('#parto_pbp_diastolic_v').val(res[14]);
								 $('#parto_urine_protein_v').val(res[15]);
								 $('#parto_urine_acetone_v').val(res[16]);
								 $('#parto_urine_sugar_v').val(res[17]);
								 $('#parto_urine_volume_v').val(res[18]);
								 $('#parto_drug_name_v').val(res[19]);
								 
								 $('#parto_drug_qty_v').val(res[20]);
								 $('#parto_oxy_vol_v').val(res[21]);
								 $('#parto_oxy_drops_v').val(res[22]);
								 $('#parto_fhr_read_by').val(res[23]);
								 $('#parto_fhr_remarks').val(res[24]);
								 $('#parto_fhr_update_btn').show();
								 $('#parto_fhr_save_btn').hide();
								 $('#parto_fhr_modal_title').html('Edit Partograph Entry');
								$('#parto_fhr_modal').modal('show');
							 }
						 });
					});
				}

				function parto_fhr_update()
				{
					$(document).on('click','#parto_fhr_update_btn',function(e)
					{
						e.preventDefault();
						var delivery_id = $('#session_delivery_id').val();
						var patient_id = $('#session_patient_id').val();
						var attend_id = $('#session_attend_id').val();
						var preg_id = $('#session_preg_id').val();

						var date = $('#parto_fhr_date').val();
						var time = $('#parto_fhr_time').val();
						var value = $('#parto_fhr_value').val();
						var read_by = $('#parto_fhr_read_by').val();
						var remarks = $('#parto_fhr_remarks').val();
						if(date !=="")
						{
							if(time !=="")
							{
								if(read_by !=="")
								{
									$.ajax({
										 url:'/layout/attendance/maternity_delivery_parto_fhr_update.php',
										 method:'POST',
										 data:$('#parto_fhr_form').serialize() 
												 + '&attend_id=' + attend_id + '&patient_id=' 
												 + patient_id + '&delivery_id=' + delivery_id 
												 + '&preg_id=' + preg_id,
										 success:function(data)
											{
												$('#parto_fhr_modal').modal('hide');
												parto_fhr_view();
											}
									});
								}
								else
								{
									alert('Please enter the name of the staff recording!');
								};
							}
							else
							{
								alert('Please select the recording time!');
							};
						}
						else
						{
							alert('Please select the recording date!');
						};
					 });
				}

				/*function parto_amniotic_modal()
				{
					$(document).on('click','#add_amniotic_btn',function()
					{
						$('#parto_amniotic_form').trigger('reset');
						$('#parto_amniotic_update_btn').hide();
						$('#parto_amniotic_modal').modal('show');
					});
				}

				function parto_amniotic_save()
				{
					$(document).on('click','#parto_amniotic_save_btn',function(e)
					{
						e.preventDefault();
						var delivery_id = $('#session_delivery_id').val();
						var patient_id = $('#session_patient_id').val();
						var attend_id = $('#session_attend_id').val();
						var preg_id = $('#session_preg_id').val();

						var date = $('#parto_amniotic_date').val();
						var time = $('#parto_amniotic_time').val();
						var value = $('#parto_amniotic_value').val();
						var read_by = $('#parto_amniotic_read_by').val();
						var remarks = $('#parto_amniotic_remarks').val();
						if(date !=="")
						{
							if(time !=="")
							{
								if(value ==0)
								{
									alert('Please enter the Amniotic Fluid value!');
									
								}
								else
								{
									if(read_by !=="")
									{
										$.ajax({
											 url:'/layout/attendance/maternity_delivery_parto_amniotic_save.php',
											 method:'POST',
											 data:{
												 delivery_id:delivery_id,
												 patient_id:patient_id,
												 attend_id:attend_id,
												 preg_id:preg_id,
												 date:date,
												 time:time,
												 value:value,
												 read_by:read_by,
												 remarks:remarks
											 },
											 success:function(data)
												{
													$('#parto_amniotic_modal').modal('hide');
													parto_amniotic_view();
												}
										});
									}
									else
									{
										alert('Please enter the name of the staff recording!');
									};
								};
							}
							else
							{
								alert('Please select the recording time!');
							};
						}
						else
						{
							alert('Please select the recording date!');
						};
					 });
				}

				function parto_amniotic_view()
				{
					var patient_id = $('#session_patient_id').val();
					var attend_id= $('#session_attend_id').val();
					var preg_id = $('#session_preg_id').val();
					var delivery_id = $('#session_delivery_id').val();
					$.ajax({  
							 url:'/layout/attendance/maternity_delivery_parto_amniotic_view.php',  
							 method:'POST',  
							 datatype:'JSON', 
							 data:{
								 attend_id:attend_id, 
								 patient_id:patient_id,
								 preg_id:preg_id,
								 delivery_id:delivery_id
							 },
							 success:function(data){
								 $('#parto_amniotic_table').html(data);
							 }  
						});
				}

				function parto_moulding_modal()
				{
					$(document).on('click','#add_moulding_btn',function()
					{
						$('#parto_moulding_form').trigger('reset');
						$('#parto_moulding_update_btn').hide();
						$('#parto_moulding_modal').modal('show');
					});
				}

				function parto_moulding_save()
				{
					$(document).on('click','#parto_moulding_save_btn',function(e)
					{
						e.preventDefault();
						var delivery_id = $('#session_delivery_id').val();
						var patient_id = $('#session_patient_id').val();
						var attend_id = $('#session_attend_id').val();
						var preg_id = $('#session_preg_id').val();

						var date = $('#parto_moulding_date').val();
						var time = $('#parto_moulding_time').val();
						var value = $('#parto_moulding_value').val();
						var read_by = $('#parto_moulding_read_by').val();
						var remarks = $('#parto_moulding_remarks').val();
						if(date !=="")
						{
							if(time !=="")
							{
								if(value !=="")
								{
									if(read_by !=="")
									{
										$.ajax({
											 url:'/layout/attendance/maternity_delivery_parto_moulding_save.php',
											 method:'POST',
											 data:{
												 delivery_id:delivery_id,
												 patient_id:patient_id,
												 attend_id:attend_id,
												 preg_id:preg_id,
												 date:date,
												 time:time,
												 value:value,
												 read_by:read_by,
												 remarks:remarks
											 },
											 success:function(data)
												{
													$('#parto_moulding_modal').modal('hide');
													parto_moulding_view();
												}
										});

									}
									else
									{
										alert('Please enter the name of the staff recording!');
									};
								}
								else
								{
									alert('Please enter the Moulding value!');
								};
							}
							else
							{
								alert('Please select the recording time!');
							};
						}
						else
						{
							alert('Please select the recording date!');
						};
					 });
				}

				function parto_moulding_view()
				{
					var patient_id = $('#session_patient_id').val();
					var attend_id= $('#session_attend_id').val();
					var preg_id = $('#session_preg_id').val();
					var delivery_id = $('#session_delivery_id').val();
					$.ajax({  
							 url:'/layout/attendance/maternity_delivery_parto_moulding_view.php',  
							 method:'POST',  
							 datatype:'JSON', 
							 data:{
								 attend_id:attend_id, 
								 patient_id:patient_id,
								 preg_id:preg_id,
								 delivery_id:delivery_id
							 },
							 success:function(data){
								 $('#parto_moulding_table').html(data);
							 }  
						});
				}

				function parto_cervix_descent_modal()
				{
					$(document).on('click','#add_cervix_descent_btn',function()
					{
						$('#parto_cervix_descent_form').trigger('reset');
						$('#parto_cd_update_btn').hide();
						$('#parto_cervix_descent_modal').modal('show');
					});
				}

				function parto_cervix_descent_save()
				{
					$(document).on('click','#parto_cd_save_btn',function(e)
					{
						e.preventDefault();
						var delivery_id = $('#session_delivery_id').val();
						var patient_id = $('#session_patient_id').val();
						var attend_id = $('#session_attend_id').val();
						var preg_id = $('#session_preg_id').val();

						var date = $('#parto_cd_date').val();
						var time = $('#parto_cd_time').val();
						var cervix = $('#parto_cd_cervix_').val();
						var descent = $('#parto_cd_descent').val();
						var read_by = $('#parto_cd_read_by').val();
						var remarks = $('#parto_cd_remarks').val();
						if(date !=="")
						{
							if(time !=="")
							{
								if(cervix !=="")
								{
									if(descent !=="")
									{
										if(read_by !=="")
										{
											$.ajax({
												 url:'/layout/attendance/maternity_delivery_parto_cervix_descent_save.php',
												 method:'POST',
												 data:{
													 delivery_id:delivery_id,
													 patient_id:patient_id,
													 attend_id:attend_id,
													 preg_id:preg_id,
													 date:date,
													 time:time,
													 cervix:cervix,
													 descent:descent,
													 read_by:read_by,
													 remarks:remarks
												 },
												 success:function(data)
													{
														$('#parto_cervix_descent_modal').modal('hide');
														parto_cervix_descent_view();
													}
											});
										}
										else
										{
											alert('Please enter the name of the staff recording!');
										};
									}
									else
									{
										alert('Please enter the Descent value!');
									};
								}
								else
								{
									alert('Please enter the Cervix Dilitation value!');
								};
							}
							else
							{
								alert('Please select the recording time!');
							};
						}
						else
						{
							alert('Please select the recording date!');
						};
					 });
				}

				function parto_cervix_descent_view()
				{
					var patient_id = $('#session_patient_id').val();
					var attend_id= $('#session_attend_id').val();
					var preg_id = $('#session_preg_id').val();
					var delivery_id = $('#session_delivery_id').val();
					$.ajax({  
							 url:'/layout/attendance/maternity_delivery_parto_cervix_descent_view.php',  
							 method:'POST',  
							 datatype:'JSON', 
							 data:{
								 attend_id:attend_id, 
								 patient_id:patient_id,
								 preg_id:preg_id,
								 delivery_id:delivery_id
							 },
							 success:function(data){
								 $('#parto_cervix_descent_table').html(data);
							 }  
						});
				}

				function parto_contractions_modal()
				{
					$(document).on('click','#add_contractions_btn',function()
					{
						$('#parto_contractions_form').trigger('reset');
						$('#parto_contra_update_btn').hide();
						$('#parto_contractions_modal').modal('show');
					});
				}

				function parto_contractions_save()
				{
					$(document).on('click','#parto_contra_save_btn',function(e)
					{
						e.preventDefault();
						var delivery_id = $('#session_delivery_id').val();
						var patient_id = $('#session_patient_id').val();
						var attend_id = $('#session_attend_id').val();
						var preg_id = $('#session_preg_id').val();

						var date = $('#parto_contra_date').val();
						var time = $('#parto_contra_time').val();
						var contra_less_than_20 = $('#parto_contra_less20').val();
						var contra_20_t0_40 = $('#parto_contra_2040').val();
						var contra_more_than_40 = $('#parto_contra_more40').val();
						var read_by = $('#parto_contra_read_by').val();
						var remarks = $('#parto_contra_remarks').val();
						if(date !=="")
						{
							if(time !=="")
							{
								if(contra_less_than_20 !=="" || contra_20_t0_40 !=="" || contra_more_than_40 !=="")
								{
									if(read_by !=="")
									{
										$.ajax({
											 url:'/layout/attendance/maternity_delivery_parto_contractions_save.php',
											 method:'POST',
											 data:{
												 delivery_id:delivery_id,
												 patient_id:patient_id,
												 attend_id:attend_id,
												 preg_id:preg_id,
												 date:date,
												 time:time,
												 contra_less_than_20:contra_less_than_20,
												 contra_20_t0_40:contra_20_t0_40,
												 contra_more_than_40:contra_more_than_40,
												 read_by:read_by,
												 remarks:remarks
											 },
											 success:function(data)
												{
													$('#parto_contractions_modal').modal('hide');
													parto_contractions_view();
												}
										});
									}
									else
									{
										alert('Please enter the name of the staff recording!');
									};
								}
								else if(contra_less_than_20 =="" && contra_20_t0_40 =="" && contra_more_than_40 =="")
								{
									alert('Please enter a Contraction value!');
								};
							}
							else
							{
								alert('Please select the recording time!');
							};
						}
						else
						{
							alert('Please select the recording date!');
						};
					 });
				}

				function parto_contractions_view()
				{
					var patient_id = $('#session_patient_id').val();
					var attend_id= $('#session_attend_id').val();
					var preg_id = $('#session_preg_id').val();
					var delivery_id = $('#session_delivery_id').val();
					$.ajax({  
							 url:'/layout/attendance/maternity_delivery_parto_contractions_view.php',  
							 method:'POST',  
							 datatype:'JSON', 
							 data:{
								 attend_id:attend_id, 
								 patient_id:patient_id,
								 preg_id:preg_id,
								 delivery_id:delivery_id
							 },
							 success:function(data){
								 $('#parto_contractions_table').html(data);
							 }  
						});
				}

				function parto_oxytocin_modal()
				{
					$(document).on('click','#add_oxytocin_btn',function()
					{
						$('#parto_oxytocin_form').trigger('reset');
						$('#parto_oxy_update_btn').hide();
						$('#parto_oxytocin_modal').modal('show');
					});
				}

				function parto_oxytocin_save()
				{
					$(document).on('click','#parto_oxy_save_btn',function(e)
					{
						e.preventDefault();
						var delivery_id = $('#session_delivery_id').val();
						var patient_id = $('#session_patient_id').val();
						var attend_id = $('#session_attend_id').val();
						var preg_id = $('#session_preg_id').val();

						var date = $('#parto_oxy_date').val();
						var time = $('#parto_oxy_time').val();
						var volume = $('#parto_oxy_vol').val();
						var drops = $('#parto_oxy_drops').val();
						var read_by = $('#parto_oxy_read_by').val();
						var remarks = $('#parto_oxy_remarks').val();
						if(date !=="")
						{
							if(time !=="")
							{
								if(volume !=="" )
								{
									if(drops !=="" )
									{
										if(read_by !=="")
										{
											$.ajax({
												 url:'/layout/attendance/maternity_delivery_parto_oxytocin_save.php',
												 method:'POST',
												 data:{
													 delivery_id:delivery_id,
													 patient_id:patient_id,
													 attend_id:attend_id,
													 preg_id:preg_id,
													 date:date,
													 time:time,
													 volume:volume,
													 drops:drops,
													 read_by:read_by,
													 remarks:remarks
												 },
												 success:function(data)
													{
														$('#parto_oxytocin_modal').modal('hide');
														parto_oxytocin_view();
													}
											});
										}
										else
										{
											alert('Please enter the name of the staff recording!');
										};
									}
									else
									{
										alert('Please enter the drops per minute!');
									};
								}
								else
								{
									alert('Please enter a volume of Oxytocin given!');
								};
							}
							else
							{
								alert('Please select the recording time!');
							};
						}
						else
						{
							alert('Please select the recording date!');
						};
					 });
				}

				function parto_oxytocin_view()
				{
					var patient_id = $('#session_patient_id').val();
					var attend_id= $('#session_attend_id').val();
					var preg_id = $('#session_preg_id').val();
					var delivery_id = $('#session_delivery_id').val();
					$.ajax({  
							 url:'/layout/attendance/maternity_delivery_parto_oxytocin_view.php',  
							 method:'POST',  
							 datatype:'JSON', 
							 data:{
								 attend_id:attend_id, 
								 patient_id:patient_id,
								 preg_id:preg_id,
								 delivery_id:delivery_id
							 },
							 success:function(data){
								 $('#parto_oxytocin_table').html(data);
							 }  
						});
				}

				function parto_drug_modal()
				{
					$(document).on('click','#add_parto_drug_btn',function()
					{
						$('#parto_drugs_form').trigger('reset');
						$('#parto_drug_update_btn').hide();
						$('#parto_drugs_modal').modal('show');
					});
				}

				function parto_drugs_save()
				{
					$(document).on('click','#parto_drug_save_btn',function(e)
					{
						e.preventDefault();
						var delivery_id = $('#session_delivery_id').val();
						var patient_id = $('#session_patient_id').val();
						var attend_id = $('#session_attend_id').val();
						var preg_id = $('#session_preg_id').val();

						var date = $('#parto_drug_date').val();
						var time = $('#parto_drug_time').val();
						var drug = $('#parto_drug_name').val();
						var qty = $('#parto_drug_qty').val();
						var read_by = $('#parto_drug_read_by').val();
						var remarks = $('#parto_drug_remarks').val();
						if(date !=="")
						{
							if(time !=="")
							{
								if(drug !=="" )
								{
									if(qty !=="" )
									{
										if(read_by !=="")
										{
											$.ajax({
												 url:'/layout/attendance/maternity_delivery_parto_drugs_save.php',
												 method:'POST',
												 data:{
													 delivery_id:delivery_id,
													 patient_id:patient_id,
													 attend_id:attend_id,
													 preg_id:preg_id,
													 date:date,
													 time:time,
													 drug:drug,
													 qty:qty,
													 read_by:read_by,
													 remarks:remarks
												 },
												 success:function(data)
													{
														$('#parto_drugs_modal').modal('hide');
														parto_drugs_view();
													}
											});
										}
										else
										{
											alert('Please enter the name of the staff recording!');
										};
									}
									else
									{
										alert('Please enter the quantity of the drug given!');
									};
								}
								else
								{
									alert('Please enter the name of the drug given!');
								};
							}
							else
							{
								alert('Please select the recording time!');
							};
						}
						else
						{
							alert('Please select the recording date!');
						};
					 });
				}

				function parto_drugs_view()
				{
					var patient_id = $('#session_patient_id').val();
					var attend_id= $('#session_attend_id').val();
					var preg_id = $('#session_preg_id').val();
					var delivery_id = $('#session_delivery_id').val();
					$.ajax({  
							 url:'/layout/attendance/maternity_delivery_parto_drugs_view.php',  
							 method:'POST',  
							 datatype:'JSON', 
							 data:{
								 attend_id:attend_id, 
								 patient_id:patient_id,
								 preg_id:preg_id,
								 delivery_id:delivery_id
							 },
							 success:function(data){
								 $('#parto_drugs_table').html(data);
							 }  
						});
				}

				function parto_pulse_bp_modal()
				{
					$(document).on('click','#add_pulse_bp_btn',function()
					{
						$('#parto_pulse_bp_form').trigger('reset');
						$('#parto_pbp_update_btn').hide();
						$('#parto_pulse_bp_modal').modal('show');
					});
				}

				function parto_pulse_bp_save()
				{
					$(document).on('click','#parto_pbp_save_btn',function(e)
					{
						e.preventDefault();
						var delivery_id = $('#session_delivery_id').val();
						var patient_id = $('#session_patient_id').val();
						var attend_id = $('#session_attend_id').val();
						var preg_id = $('#session_preg_id').val();

						var date = $('#parto_pbp_date').val();
						var time = $('#parto_pbp_time').val();
						var pulse = $('#parto_pbp_pulse').val();
						var bp_systolic = $('#parto_pbp_systolic').val();
						var bp_diastolic = $('#parto_pbp_diastolic').val();
						var read_by = $('#parto_pbp_read_by').val();
						var remarks = $('#parto_pbp_remarks').val();
						if(date !=="")
						{
							if(time !=="")
							{
								if(pulse !=="" )
								{
									if(bp_systolic !=="" )
									{
										if(bp_diastolic !=="" )
										{
											if(read_by !=="")
											{
												$.ajax({
													 url:'/layout/attendance/maternity_delivery_parto_pulse_bp_save.php',
													 method:'POST',
													 data:{
														 delivery_id:delivery_id,
														 patient_id:patient_id,
														 attend_id:attend_id,
														 preg_id:preg_id,
														 date:date,
														 time:time,
														 pulse:pulse,
														 bp_systolic:bp_systolic,
														 bp_diastolic:bp_diastolic,
														 read_by:read_by,
														 remarks:remarks
													 },
													 success:function(data)
														{
															$('#parto_pulse_bp_modal').modal('hide');
															parto_pulse_bp_view();
														}
												});
											}
											else
											{
												alert('Please enter the name of the staff recording!');
											};
										}
										else
										{
											alert('Please enter the BP - Diastolic value!');
										};
									}
									else
									{
										alert('Please enter the BP - Systolic value!');
									};
								}
								else
								{
									alert('Please enter the Pulse value!');
								};
							}
							else
							{
								alert('Please select the recording time!');
							};
						}
						else
						{
							alert('Please select the recording date!');
						};
					 });
				}

				function parto_pulse_bp_view()
				{
					var patient_id = $('#session_patient_id').val();
					var attend_id= $('#session_attend_id').val();
					var preg_id = $('#session_preg_id').val();
					var delivery_id = $('#session_delivery_id').val();
					$.ajax({  
							 url:'/layout/attendance/maternity_delivery_parto_pulse_bp_view.php',  
							 method:'POST',  
							 datatype:'JSON', 
							 data:{
								 attend_id:attend_id, 
								 patient_id:patient_id,
								 preg_id:preg_id,
								 delivery_id:delivery_id
							 },
							 success:function(data){
								 $('#parto_pulse_bp_table').html(data);
							 }  
						});
				}

				function parto_temp_modal()
				{
					$(document).on('click','#add_temp_btn',function()
					{
						$('#parto_temp_form').trigger('reset');
						$('#parto_temp_update_btn').hide();
						$('#parto_temp_modal').modal('show');
					});
				}

				function parto_temp_save()
				{
					$(document).on('click','#parto_temp_save_btn',function(e)
					{
						e.preventDefault();
						var delivery_id = $('#session_delivery_id').val();
						var patient_id = $('#session_patient_id').val();
						var attend_id = $('#session_attend_id').val();
						var preg_id = $('#session_preg_id').val();

						var date = $('#parto_temp_date').val();
						var time = $('#parto_temp_time').val();
						var temp = $('#parto_temp').val();
						var read_by = $('#parto_temp_read_by').val();
						var remarks = $('#parto_temp_remarks').val();
						if(date !=="")
						{
							if(time !=="")
							{
								if(temp !=="" )
								{
									if(read_by !=="")
									{
										$.ajax({
											 url:'/layout/attendance/maternity_delivery_parto_temp_save.php',
											 method:'POST',
											 data:{
												 delivery_id:delivery_id,
												 patient_id:patient_id,
												 attend_id:attend_id,
												 preg_id:preg_id,
												 date:date,
												 time:time,
												 temp:temp,
												 read_by:read_by,
												 remarks:remarks
											 },
											 success:function(data)
												{
													$('#parto_temp_modal').modal('hide');
													parto_temp_view();
												}
										});
									}
									else
									{
										alert('Please enter the name of the staff recording!');
									};
										
								}
								else
								{
									alert('Please enter the Temperature value!');
								};
							}
							else
							{
								alert('Please select the recording time!');
							};
						}
						else
						{
							alert('Please select the recording date!');
						};
					 });
				}

				function parto_temp_view()
				{
					var patient_id = $('#session_patient_id').val();
					var attend_id= $('#session_attend_id').val();
					var preg_id = $('#session_preg_id').val();
					var delivery_id = $('#session_delivery_id').val();
					$.ajax({  
							 url:'/layout/attendance/maternity_delivery_parto_temp_view.php',  
							 method:'POST',  
							 datatype:'JSON', 
							 data:{
								 attend_id:attend_id, 
								 patient_id:patient_id,
								 preg_id:preg_id,
								 delivery_id:delivery_id
							 },
							 success:function(data){
								 $('#parto_temp_table').html(data);
							 }  
						});
				}

				function parto_urine_modal()
				{
					$(document).on('click','#add_urine_btn',function()
					{
						$('#parto_urine_form').trigger('reset');
						$('#parto_urine_update_btn').hide();
						$('#parto_urine_modal').modal('show');
					});
				}

				function parto_urine_save()
				{
					$(document).on('click','#parto_urine_save_btn',function(e)
					{
						e.preventDefault();
						var delivery_id = $('#session_delivery_id').val();
						var patient_id = $('#session_patient_id').val();
						var attend_id = $('#session_attend_id').val();
						var preg_id = $('#session_preg_id').val();

						var date = $('#parto_urine_date').val();
						var time = $('#parto_urine_time').val();
						var protein = $('#parto_urine_protein').val();
						var acetone = $('#parto_urine_acetone').val();
						var sugar = $('#parto_urine_sugar').val();
						var volume = $('#parto_urine_volume').val();
						var read_by = $('#parto_urine_read_by').val();
						var remarks = $('#parto_urine_remarks').val();
						if(date !=="")
						{
							if(time !=="")
							{
								if(protein !=="" )
								{
									if(acetone !=="" )
									{
										if(sugar !=="" )
										{
											if(volume !=="" )
											{
												if(read_by !=="")
												{
													$.ajax({
														 url:'/layout/attendance/maternity_delivery_parto_urine_save.php',
														 method:'POST',
														 data:{
															 delivery_id:delivery_id,
															 patient_id:patient_id,
															 attend_id:attend_id,
															 preg_id:preg_id,
															 date:date,
															 time:time,
															 protein:protein,
															 acetone:acetone,
															 sugar:sugar,
															 volume:volume,
															 read_by:read_by,
															 remarks:remarks
														 },
														 success:function(data)
															{
																$('#parto_urine_modal').modal('hide');
																parto_urine_view();
															}
													});
												}
												else
												{
													alert('Please enter the name of the staff recording!');
												};
											}
											else
											{
												alert('Please enter the volume of urine!');
											};
										}
										else
										{
											alert('Please enter the sugar level in the urine!');
										};
									}
									else
									{
										alert('Please enter the acetone of the urine!');
									};
								}
								else
								{
									alert('Please enter the Pprotein in the urine!');
								};
							}
							else
							{
								alert('Please select the recording time!');
							};
						}
						else
						{
							alert('Please select the recording date!');
						};
					 });
				}

				function parto_urine_view()
				{
					var patient_id = $('#session_patient_id').val();
					var attend_id= $('#session_attend_id').val();
					var preg_id = $('#session_preg_id').val();
					var delivery_id = $('#session_delivery_id').val();
					$.ajax({  
							 url:'/layout/attendance/maternity_delivery_parto_urine_view.php',  
							 method:'POST',  
							 datatype:'JSON', 
							 data:{
								 attend_id:attend_id, 
								 patient_id:patient_id,
								 preg_id:preg_id,
								 delivery_id:delivery_id
							 },
							 success:function(data){
								 $('#parto_urine_table').html(data);
							 }  
						});
				}*/
		//CHILD
			function new_child_modal()
			{
				$(document).on('click','#add_children_btn',function()
				{
					var delivery_id = $('#session_delivery_id').val();
					$('#delivery_child_form').trigger('reset');
					$('#delivery_child_modal_title').text('New Child Form');
					$('#delivery_child_save_update').html('<button type="submit" name="delivery_child_save_btn" id="delivery_child_save_btn" class="btn btn-primary">Save</button>');
					$('#delivery_child_update_btn').hide();
					$('#delivery_id_c1').val(delivery_id);
					$('#delivery_child_modal').modal('show');
				});
			}

			function new_child_modal_pop()
			{
				var delivery_state = $('#session_delivery_state').val();
				if (delivery_state == 'exist') 
				{
					var preg_id = $('#session_preg_id').val();
					$.ajax({
						url:'/layout/attendance/maternity_delivery_child_modal_pop.php',
						method:'POST',
						data:{preg_id:preg_id},
						datatype:'JSON',
						success:function(data)
							{
								var res = $.parseJSON(data);
								if(res[0] == 'none')
								{
									var delivery_id = $('#session_delivery_id').val();
									$('#delivery_child_form').trigger('reset');
									$('#delivery_child_modal_title').text('New Child Form');
									$('#delivery_child_save_update').html('<button type="submit" name="delivery_child_save_btn" id="delivery_child_save_btn" class="btn btn-primary">Save</button>');
									$('#delivery_child_update_btn').hide();
									$('#delivery_id_c1').val(delivery_id);
									$('#delivery_child_modal').modal('show');
								};
							}
					 });
				};
			}

			function save_child()
			{
				$(document).on('click','#delivery_child_save_btn',function(e){
					e.preventDefault();
					var delivery_id = $('#session_delivery_id').val();
					var preg_id = $('#session_preg_id').val();
					var patient_id = $('#session_patient_id').val();
					var attend_id = $('#session_attend_id').val();
					var date = $('#date_c1').val();
					var time = $('#time_c1').val();
					if (date !=="") 
					{
						if (time !=="") 
						{
							$.ajax({
								 url:'/layout/attendance/maternity_delivery_child_save.php',
								 method:'POST',
								 data:$('#delivery_child_form').serialize() 
										 + '&attend_id=' + attend_id 
										 + '&patient_id=' + patient_id 
										 + '&preg_id=' + preg_id,
								 success:function(data)
									 {
										 $('#delivery_child_form').trigger('reset');
										 $('#delivery_child_modal').modal('hide');
										 view_children();
									 }
								 });
						} 
						else 
						{
							alert('Please provide the Delivery Time!');
						};
					} 
					else 
					{
						alert('Please provide the Delivery Date!');
					};
				});
			}

			function view_children()
			{
				var patient_id = $('#session_patient_id').val();
				var attend_id= $('#session_attend_id').val();
				var preg_id = $('#session_preg_id').val();
				var delivery_id = $('#session_delivery_id').val();
				var delivery_state = $('#session_delivery_state').val();
				if (delivery_state == 'exist') 
				{
					$.ajax({  
							 url:'/layout/attendance/maternity_delivery_children_view.php',  
							 method:'POST',  
							 datatype:'JSON', 
							 data:{
								 attend_id:attend_id, 
								 patient_id:patient_id,
								 preg_id:preg_id,
								 delivery_id:delivery_id
							 },
							 success:function(data){
								 $('#children_list_div').html(data);
							 }  
						});
				}
			}

			function apgar_score_at_1min()
			{
				$(document).on('change keyup','#apgar_colour_1_c1',function(){
					var colour = $('#apgar_colour_1_c1').val();
					if(colour == 'PINK_ALL_OVER')
					{
						$('#apgar_colour_score_1_c1').val(2);
						$('#apgar_colour_score_1_c1_h').val(2);
					}
					else if(colour == 'PINK_LIPS_BLUE_HANDS_AND_FEET')
					{
						$('#apgar_colour_score_1_c1').val(1);
						$('#apgar_colour_score_1_c1_h').val(1);
					}
					else if(colour == 'BLUE_ALL_OVER')
					{
						$('#apgar_colour_score_1_c1').val(0);
						$('#apgar_colour_score_1_c1_h').val(0);
					};
					if ($('#apgar_colour_score_1_c1').val() !==""){var colour_score = $('#apgar_colour_score_1_c1').val();}else{var colour_score = 0;};
					if ($('#apgar_heart_rate_score_1_c1').val() !==""){var heart_rate_score = $('#apgar_heart_rate_score_1_c1').val();}else{var heart_rate_score = 0;};
					if ($('#apgar_breathing_score_1_c1').val() !==""){var breathing_score = $('#apgar_breathing_score_1_c1').val();}else{var breathing_score = 0;};
					if ($('#apgar_movement_score_1_c1').val() !==""){var movement_score = $('#apgar_movement_score_1_c1').val();}else{var movement_score = 0;};
					if ($('#apgar_response_score_1_c1').val() !==""){var response_score = $('#apgar_response_score_1_c1').val();}else{var response_score = 0;};
				
					var Total = parseInt(colour_score) + parseInt(heart_rate_score) + parseInt(breathing_score) + parseInt(movement_score) + parseInt(response_score);
					$('#apgar_total_1_c1').val(Total);
					$('#apgar_total_1_c1_h').val(Total);
				});

				$(document).on('change keyup','#apgar_heart_rate_1_c1',function(){
					var heart_rate = $('#apgar_heart_rate_1_c1').val();
					if(heart_rate == 'MORE_THAN_100')
					{
						$('#apgar_heart_rate_score_1_c1').val(2);
						$('#apgar_heart_rate_score_1_c1_h').val(2);
					}
					else if(heart_rate == 'LESS_THAN_100')
					{
						$('#apgar_heart_rate_score_1_c1').val(1);
						$('#apgar_heart_rate_score_1_c1_h').val(1);
					}
					else if(heart_rate == 'NONE')
					{
						$('#apgar_heart_rate_score_1_c1').val(0);
						$('#apgar_heart_rate_score_1_c1_h').val(0);
					};
					if ($('#apgar_colour_score_1_c1').val() !==""){var colour_score = $('#apgar_colour_score_1_c1').val();}else{var colour_score = 0;};
					if ($('#apgar_heart_rate_score_1_c1').val() !==""){var heart_rate_score = $('#apgar_heart_rate_score_1_c1').val();}else{var heart_rate_score = 0;};
					if ($('#apgar_breathing_score_1_c1').val() !==""){var breathing_score = $('#apgar_breathing_score_1_c1').val();}else{var breathing_score = 0;};
					if ($('#apgar_movement_score_1_c1').val() !==""){var movement_score = $('#apgar_movement_score_1_c1').val();}else{var movement_score = 0;};
					if ($('#apgar_response_score_1_c1').val() !==""){var response_score = $('#apgar_response_score_1_c1').val();}else{var response_score = 0;};
				
					var Total = parseInt(colour_score) + parseInt(heart_rate_score) + parseInt(breathing_score) + parseInt(movement_score) + parseInt(response_score);
					$('#apgar_total_1_c1').val(Total);
					$('#apgar_total_1_c1_h').val(Total);
				});

				$(document).on('change keyup','#apgar_breathing_1_c1',function(){
					var breathing = $('#apgar_breathing_1_c1').val();
					if(breathing == 'REGULAR')
					{
						$('#apgar_breathing_score_1_c1').val(2);
						$('#apgar_breathing_score_1_c1_h').val(2);
					}
					else if(breathing == 'IRREGULAR_GASPING')
					{
						$('#apgar_breathing_score_1_c1').val(1);
						$('#apgar_breathing_score_1_c1_h').val(1);
					}
					else if(breathing == 'NONE')
					{
						$('#apgar_breathing_score_1_c1').val(0);
						$('#apgar_breathing_score_1_c1_h').val(0);
					};
					if ($('#apgar_colour_score_1_c1').val() !==""){var colour_score = $('#apgar_colour_score_1_c1').val();}else{var colour_score = 0;};
					if ($('#apgar_heart_rate_score_1_c1').val() !==""){var heart_rate_score = $('#apgar_heart_rate_score_1_c1').val();}else{var heart_rate_score = 0;};
					if ($('#apgar_breathing_score_1_c1').val() !==""){var breathing_score = $('#apgar_breathing_score_1_c1').val();}else{var breathing_score = 0;};
					if ($('#apgar_movement_score_1_c1').val() !==""){var movement_score = $('#apgar_movement_score_1_c1').val();}else{var movement_score = 0;};
					if ($('#apgar_response_score_1_c1').val() !==""){var response_score = $('#apgar_response_score_1_c1').val();}else{var response_score = 0;};
				
					var Total = parseInt(colour_score) + parseInt(heart_rate_score) + parseInt(breathing_score) + parseInt(movement_score) + parseInt(response_score);
					$('#apgar_total_1_c1').val(Total);
					$('#apgar_total_1_c1_h').val(Total);
				});

				$(document).on('change keyup','#apgar_movement_1_c1',function(){
					var movement = $('#apgar_movement_1_c1').val();
					if(movement == 'ACTIVE')
					{
						$('#apgar_movement_score_1_c1').val(2);
						$('#apgar_movement_score_1_c1_h').val(2);
					}
					else if(movement == 'LITTLE')
					{
						$('#apgar_movement_score_1_c1').val(1);
						$('#apgar_movement_score_1_c1_h').val(1);
					}
					else if(movement == 'FLOPP_NONE')
					{
						$('#apgar_movement_score_1_c1').val(0);
						$('#apgar_movement_score_1_c1_h').val(0);
					};
					if ($('#apgar_colour_score_1_c1').val() !==""){var colour_score = $('#apgar_colour_score_1_c1').val();}else{var colour_score = 0;};
					if ($('#apgar_heart_rate_score_1_c1').val() !==""){var heart_rate_score = $('#apgar_heart_rate_score_1_c1').val();}else{var heart_rate_score = 0;};
					if ($('#apgar_breathing_score_1_c1').val() !==""){var breathing_score = $('#apgar_breathing_score_1_c1').val();}else{var breathing_score = 0;};
					if ($('#apgar_movement_score_1_c1').val() !==""){var movement_score = $('#apgar_movement_score_1_c1').val();}else{var movement_score = 0;};
					if ($('#apgar_response_score_1_c1').val() !==""){var response_score = $('#apgar_response_score_1_c1').val();}else{var response_score = 0;};
				
					var Total = parseInt(colour_score) + parseInt(heart_rate_score) + parseInt(breathing_score) + parseInt(movement_score) + parseInt(response_score);
					$('#apgar_total_1_c1').val(Total);
					$('#apgar_total_1_c1_h').val(Total);
				});

				$(document).on('change keyup','#apgar_response_1_c1',function(){
					var response = $('#apgar_response_1_c1').val();
					if(response == 'CRIES')
					{
						$('#apgar_response_score_1_c1').val(2);
						$('#apgar_response_score_1_c1_h').val(2);
					}
					else if(response == 'COUGH_WHEN_SUCKED')
					{
						$('#apgar_response_score_1_c1').val(1);
						$('#apgar_response_score_1_c1_h').val(1);
					}
					else if(response == 'NO_RESPONSE_TO_SUCTION_TO_NASAL')
					{
						$('#apgar_response_score_1_c1').val(0);
						$('#apgar_response_score_1_c1_h').val(0);
					};
					if ($('#apgar_colour_score_1_c1').val() !==""){var colour_score = $('#apgar_colour_score_1_c1').val();}else{var colour_score = 0;};
					if ($('#apgar_heart_rate_score_1_c1').val() !==""){var heart_rate_score = $('#apgar_heart_rate_score_1_c1').val();}else{var heart_rate_score = 0;};
					if ($('#apgar_breathing_score_1_c1').val() !==""){var breathing_score = $('#apgar_breathing_score_1_c1').val();}else{var breathing_score = 0;};
					if ($('#apgar_movement_score_1_c1').val() !==""){var movement_score = $('#apgar_movement_score_1_c1').val();}else{var movement_score = 0;};
					if ($('#apgar_response_score_1_c1').val() !==""){var response_score = $('#apgar_response_score_1_c1').val();}else{var response_score = 0;};
				
					var Total = parseInt(colour_score) + parseInt(heart_rate_score) + parseInt(breathing_score) + parseInt(movement_score) + parseInt(response_score);
					$('#apgar_total_1_c1').val(Total);
					$('#apgar_total_1_c1_h').val(Total);
				});
			}

			function apgar_score_at_5min()
			{
				$(document).on('change keyup','#apgar_colour_5_c1',function(){
					var colour = $('#apgar_colour_5_c1').val();
					if(colour == 'PINK_ALL_OVER')
					{
						$('#apgar_colour_score_5_c1').val(2);
						$('#apgar_colour_score_5_c1_h').val(2);
					}
					else if(colour == 'PINK_LIPS_BLUE_HANDS_AND_FEET')
					{
						$('#apgar_colour_score_5_c1').val(1);
						$('#apgar_colour_score_5_c1_h').val(1);
					}
					else if(colour == 'BLUE_ALL_OVER')
					{
						$('#apgar_colour_score_5_c1').val(0);
						$('#apgar_colour_score_5_c1_h').val(0);
					};
					if ($('#apgar_colour_score_5_c1').val() !==""){var colour_score = $('#apgar_colour_score_5_c1').val();}else{var colour_score = 0;};
					if ($('#apgar_heart_rate_score_5_c1').val() !==""){var heart_rate_score = $('#apgar_heart_rate_score_5_c1').val();}else{var heart_rate_score = 0;};
					if ($('#apgar_breathing_score_5_c1').val() !==""){var breathing_score = $('#apgar_breathing_score_5_c1').val();}else{var breathing_score = 0;};
					if ($('#apgar_movement_score_5_c1').val() !==""){var movement_score = $('#apgar_movement_score_5_c1').val();}else{var movement_score = 0;};
					if ($('#apgar_response_score_5_c1').val() !==""){var response_score = $('#apgar_response_score_5_c1').val();}else{var response_score = 0;};
				
					var Total = parseInt(colour_score) + parseInt(heart_rate_score) + parseInt(breathing_score) + parseInt(movement_score) + parseInt(response_score);
					$('#apgar_total_5_c1').val(Total);
					$('#apgar_total_5_c1_h').val(Total);
				});

				$(document).on('change keyup','#apgar_heart_rate_5_c1',function(){
					var heart_rate = $('#apgar_heart_rate_5_c1').val();
					if(heart_rate == 'MORE_THAN_100')
					{
						$('#apgar_heart_rate_score_5_c1').val(2);
						$('#apgar_heart_rate_score_5_c1_h').val(2);
					}
					else if(heart_rate == 'LESS_THAN_100')
					{
						$('#apgar_heart_rate_score_5_c1').val(1);
						$('#apgar_heart_rate_score_5_c1_h').val(1);
					}
					else if(heart_rate == 'NONE')
					{
						$('#apgar_heart_rate_score_5_c1').val(0);
						$('#apgar_heart_rate_score_5_c1_h').val(0);
					};
					if ($('#apgar_colour_score_5_c1').val() !==""){var colour_score = $('#apgar_colour_score_5_c1').val();}else{var colour_score = 0;};
					if ($('#apgar_heart_rate_score_5_c1').val() !==""){var heart_rate_score = $('#apgar_heart_rate_score_5_c1').val();}else{var heart_rate_score = 0;};
					if ($('#apgar_breathing_score_5_c1').val() !==""){var breathing_score = $('#apgar_breathing_score_5_c1').val();}else{var breathing_score = 0;};
					if ($('#apgar_movement_score_5_c1').val() !==""){var movement_score = $('#apgar_movement_score_5_c1').val();}else{var movement_score = 0;};
					if ($('#apgar_response_score_5_c1').val() !==""){var response_score = $('#apgar_response_score_5_c1').val();}else{var response_score = 0;};
				
					var Total = parseInt(colour_score) + parseInt(heart_rate_score) + parseInt(breathing_score) + parseInt(movement_score) + parseInt(response_score);
					$('#apgar_total_5_c1').val(Total);
					$('#apgar_total_5_c1_h').val(Total);
				});

				$(document).on('change keyup','#apgar_breathing_5_c1',function(){
					var breathing = $('#apgar_breathing_5_c1').val();
					if(breathing == 'REGULAR')
					{
						$('#apgar_breathing_score_5_c1').val(2);
						$('#apgar_breathing_score_5_c1_h').val(2);
					}
					else if(breathing == 'IRREGULAR_GASPING')
					{
						$('#apgar_breathing_score_5_c1').val(1);
						$('#apgar_breathing_score_5_c1_h').val(1);
					}
					else if(breathing == 'NONE')
					{
						$('#apgar_breathing_score_5_c1').val(0);
						$('#apgar_breathing_score_5_c1_h').val(0);
					};
					if ($('#apgar_colour_score_5_c1').val() !==""){var colour_score = $('#apgar_colour_score_5_c1').val();}else{var colour_score = 0;};
					if ($('#apgar_heart_rate_score_5_c1').val() !==""){var heart_rate_score = $('#apgar_heart_rate_score_5_c1').val();}else{var heart_rate_score = 0;};
					if ($('#apgar_breathing_score_5_c1').val() !==""){var breathing_score = $('#apgar_breathing_score_5_c1').val();}else{var breathing_score = 0;};
					if ($('#apgar_movement_score_5_c1').val() !==""){var movement_score = $('#apgar_movement_score_5_c1').val();}else{var movement_score = 0;};
					if ($('#apgar_response_score_5_c1').val() !==""){var response_score = $('#apgar_response_score_5_c1').val();}else{var response_score = 0;};
				
					var Total = parseInt(colour_score) + parseInt(heart_rate_score) + parseInt(breathing_score) + parseInt(movement_score) + parseInt(response_score);
					$('#apgar_total_5_c1').val(Total);
					$('#apgar_total_5_c1_h').val(Total);
				});

				$(document).on('change keyup','#apgar_movement_5_c1',function(){
					var movement = $('#apgar_movement_5_c1').val();
					if(movement == 'ACTIVE')
					{
						$('#apgar_movement_score_5_c1').val(2);
						$('#apgar_movement_score_5_c1_h').val(2);
					}
					else if(movement == 'LITTLE')
					{
						$('#apgar_movement_score_5_c1').val(1);
						$('#apgar_movement_score_5_c1_h').val(1);
					}
					else if(movement == 'FLOPP_NONE')
					{
						$('#apgar_movement_score_5_c1').val(0);
						$('#apgar_movement_score_5_c1_h').val(0);
					};
					if ($('#apgar_colour_score_5_c1').val() !==""){var colour_score = $('#apgar_colour_score_5_c1').val();}else{var colour_score = 0;};
					if ($('#apgar_heart_rate_score_5_c1').val() !==""){var heart_rate_score = $('#apgar_heart_rate_score_5_c1').val();}else{var heart_rate_score = 0;};
					if ($('#apgar_breathing_score_5_c1').val() !==""){var breathing_score = $('#apgar_breathing_score_5_c1').val();}else{var breathing_score = 0;};
					if ($('#apgar_movement_score_5_c1').val() !==""){var movement_score = $('#apgar_movement_score_5_c1').val();}else{var movement_score = 0;};
					if ($('#apgar_response_score_5_c1').val() !==""){var response_score = $('#apgar_response_score_5_c1').val();}else{var response_score = 0;};
				
					var Total = parseInt(colour_score) + parseInt(heart_rate_score) + parseInt(breathing_score) + parseInt(movement_score) + parseInt(response_score);
					$('#apgar_total_5_c1').val(Total);
					$('#apgar_total_5_c1_h').val(Total);
				});

				$(document).on('change keyup','#apgar_response_5_c1',function(){
					var response = $('#apgar_response_5_c1').val();
					if(response == 'CRIES')
					{
						$('#apgar_response_score_5_c1').val(2);
						$('#apgar_response_score_5_c1_h').val(2);
					}
					else if(response == 'COUGH_WHEN_SUCKED')
					{
						$('#apgar_response_score_5_c1').val(1);
						$('#apgar_response_score_5_c1_h').val(1);
					}
					else if(response == 'NO_RESPONSE_TO_SUCTION_TO_NASAL')
					{
						$('#apgar_response_score_5_c1').val(0);
						$('#apgar_response_score_5_c1_h').val(0);
					};
					if ($('#apgar_colour_score_5_c1').val() !==""){var colour_score = $('#apgar_colour_score_5_c1').val();}else{var colour_score = 0;};
					if ($('#apgar_heart_rate_score_5_c1').val() !==""){var heart_rate_score = $('#apgar_heart_rate_score_5_c1').val();}else{var heart_rate_score = 0;};
					if ($('#apgar_breathing_score_5_c1').val() !==""){var breathing_score = $('#apgar_breathing_score_5_c1').val();}else{var breathing_score = 0;};
					if ($('#apgar_movement_score_5_c1').val() !==""){var movement_score = $('#apgar_movement_score_5_c1').val();}else{var movement_score = 0;};
					if ($('#apgar_response_score_5_c1').val() !==""){var response_score = $('#apgar_response_score_5_c1').val();}else{var response_score = 0;};
				
					var Total = parseInt(colour_score) + parseInt(heart_rate_score) + parseInt(breathing_score) + parseInt(movement_score) + parseInt(response_score);
					$('#apgar_total_5_c1').val(Total);
					$('#apgar_total_5_c1_h').val(Total);
				});
			}

			function edit_child()
			{
				$(document).on('click','#delivery_child_edit_btn',function(){
					var preg_child_id = $(this).attr('data-id');
					$.ajax({  
						 url:'/layout/attendance/maternity_delivery_child_edit.php',  
						 type:'POST',  
						 data:{preg_child_id:preg_child_id},
						 datatype: 'JSON',
						 success:function(data)
							 {
								 var res = $.parseJSON(data);
								 $('#child_id_c1').val(res[0]);
								 $('#delivery_id_c1').val(res[1]);
								 $('#preg_id_c1').val(res[2]);
								 $('#sex_c1').val(res[3]);
								 $('#weight_c1').val(res[4]);
								$('#head_circ_c1').val(res[5]);
								$('#birth_outcome_c1').val(res[6]);
								$('#breath_cry_c1').val(res[7]);
								 $('#length_c1').val(res[8]);
								 $('#initiated_skin_to_skin_c1').val(res[9]);
								 $('#temp_c1').val(res[10]);
								$('#resuscitation_c1').val(res[11]);
								$('#cord_care_c1').val(res[12]);
								$('#breastfeeding_c1').val(res[13]);
								$('#inj_vit_k_c1').val(res[14]);
								$('#infant_arv_c1').val(res[15]);
								$('#eye_care_c1').val(res[16]);
								 $('#birth_abnormalities_c1').val(res[17]);
								 $('#colour_c1').val(res[18]);
								 $('#heart_rate_c1').val(res[19]);
								$('#resp_rate_c1').val(res[20]);
								$('#state_c1').val(res[21]);
								$('#transferred_to_c1').val(res[22]);
								 $('#transferred_date_c1').val(res[23]);
								 $('#transferred_time_c1').val(res[24]);
								 $('#comment_c1').val(res[25]);
								 $('#Mode_of_delivery_c1').val(res[26]);
								 $('#presentation_c1').val(res[27]);
								 $('#duration_stage_1_c1').val(res[28]);
								 $('#duration_stage_2_c1').val(res[29]);
								$('#vacuum_assisted_c1').val(res[30]);
								$('#maturity_c1').val(res[31]);
								$('#indication_c1').val(res[32]);
								 $('#chest_circ_c1').val(res[33]);
								 $('#meconium_pass_c1').val(res[34]);
								 $('#urine_pass_c1').val(res[35]);
								$('#attendant_c1').val(res[36]);
								$('#date_c1').val(res[37]);
								$('#time_c1').val(res[38]);
								$('#resp_rate_30min_c1').val(res[39]);
								$('#birth_complications_c1').val(res[40]);
								$('#other_complications_c1').val(res[41]);
								 $('#other_abnormalities_c1').val(res[42]);
								 $('#breast_feeding_c1').val(res[43]);
								 $('#remarks_c1').val(res[44]);
								$('#apgar_colour_1_c1').val(res[45]);
								$('#apgar_colour_score_1_c1').val(res[46]);
								$('#apgar_colour_score_1_c1_h').val(res[46]);
								$('#apgar_heart_rate_1_c1').val(res[47]);
								 $('#apgar_heart_rate_score_1_c1').val(res[48]);
								 $('#apgar_heart_rate_score_1_c1_h').val(res[48]);
								 $('#apgar_breathing_1_c1').val(res[49]);
								 $('#apgar_breathing_score_1_c1').val(res[50]);
								 $('#apgar_breathing_score_1_c1_h').val(res[50]);
								 $('#apgar_movement_1_c1').val(res[51]);
								 $('#apgar_movement_score_1_c1').val(res[52]);
								 $('#apgar_movement_score_1_c1_h').val(res[52]);
								$('#apgar_response_1_c1').val(res[53]);
								$('#apgar_response_score_1_c1').val(res[54]);
								$('#apgar_response_score_1_c1_h').val(res[54]);
								$('#apgar_total_1_c1').val(res[55]);
								$('#apgar_total_1_c1_h').val(res[55]);
								 $('#apgar_colour_5_c1').val(res[56]);
								 $('#apgar_colour_score_5_c1').val(res[57]);
								 $('#apgar_colour_score_5_c1_h').val(res[57]);
								$('#apgar_heart_rate_5_c1').val(res[58]);
								$('#apgar_heart_rate_score_5_c1').val(res[59]);
								$('#apgar_heart_rate_score_5_c1_h').val(res[59]);
								$('#apgar_breathing_5_c1').val(res[60]);
								$('#apgar_breathing_score_5_c1').val(res[61]);
								$('#apgar_breathing_score_5_c1_h').val(res[61]);
								$('#apgar_movement_5_c1').val(res[62]);
								$('#apgar_movement_score_5_c1').val(res[63]);
								$('#apgar_movement_score_5_c1_h').val(res[63]);
								$('#apgar_response_5_c1').val(res[64]);
								$('#apgar_response_score_5_c1').val(res[65]);
								$('#apgar_response_score_5_c1_h').val(res[65]);
								$('#apgar_total_5_c1').val(res[66]);
								$('#apgar_total_5_c1_h').val(res[66]);
								$('#delivery_child_save_btn').hide();
								$('#delivery_child_update_btn').show();
								$('#delivery_child_modal').modal('show');
							 }  
					});
				}); 
			}

			function update_child()
			{
				$(document).on('click','#delivery_child_update_btn',function(e){
					e.preventDefault();
					var delivery_id = $('#session_delivery_id').val();
					var preg_id = $('#session_preg_id').val();
					var patient_id = $('#session_patient_id').val();
					var attend_id = $('#session_attend_id').val();
					var date = $('#date_c1').val();
					var time = $('#time_c1').val();
					if (date !=="") 
					{
						if (time !=="") 
						{
							$.ajax({
								 url:'/layout/attendance/maternity_delivery_child_update.php',
								 method:'POST',
								 data:$('#delivery_child_form').serialize() 
										 + '&attend_id=' + attend_id 
										 + '&patient_id=' + patient_id 
										 + '&preg_id=' + preg_id,
								 success:function(data)
									 {
										 $('#delivery_child_form').trigger('reset');
										 $('#delivery_child_modal').modal('hide');
										 view_children();
									 }
								 });
						} 
						else 
						{
							alert('Please provide the Delivery Time!');
						};
					} 
					else 
					{
						alert('Please provide the Delivery Date!');
					};
				});
			}
	//PNC
		function go_to_pnc_sheet()
		{
			$(document).on('click','#preg_pnc_sheet',function()
			{
				var preg_id = $(this).attr('data-id2');
				$.ajax({
					 url:'/layout/attendance/maternity_pnc_open.php',
					 method:'POST',
					 data:{preg_id:preg_id},
					 success:function()
						 {
							 window.location.href="/layout/attendance/maternity_pnc_sheet.php";
							 //$('#pnc_save_update').html('<button type="submit" name="pnc_save_btn" id="pnc_save_btn" class="btn btn-primary">Save</button>');
							 //$('#pnc_current_form').trigger('reset');
							 view_pnc_list();
						 }
				});
				
			});
		}

		function save_pnc_sheet()
		{
			$(document).on('click','#pnc_save_btn',function(e){
				e.preventDefault();
				var date = $('#pnc_date').val();
				var time = $('#pnc_time').val();
				var bp_systolic = $('#pnc_bp_systolic').val();
				var bp_diastolic = $('#pnc_bp_diastolic').val();
				var weight = $('#pnc_weight').val();
				var pulse = $('#pnc_pulse').val();
				var temp = $('#pnc_temp').val();
				if (date !=="") 
				{
					if (time !=="") 
					{
						if (bp_systolic !=="") 
						{
							if (bp_diastolic !=="") 
							{
								if (weight !=="") 
								{
									if (pulse !=="") 
									{
										if (temp !=="") 
										{
											var attend_id = $('#session_attend_id').val();
											var patient_id = $('#session_patient_id').val();
											var preg_id = $('#session_preg_id').val();
											$.ajax({
												 url:'/layout/attendance/maternity_pnc_save.php',
												 method:'POST',
												 data:$('#pnc_current_form').serialize() 
														 + '&attend_id=' + attend_id 
														 + '&patient_id=' + patient_id 
														 + '&preg_id=' + preg_id,
												 success:function(data)
													 {
														 $('#pnc_current_form').trigger('reset');
														 view_pnc_list();
													 }
												 });
										} 
										else 
										{
											alert('Please provide the Temperature value!');
										};
									} 
									else 
									{
										alert('Please provide the Pulse value!');
									};
								} 
								else 
								{
									alert('Please provide the Weight!');
								};
							} 
							else 
							{
								alert('Please provide the BP - Diastolic!');
							};
						} 
						else 
						{
							alert('Please provide the BP - Systolic!');
						};
					} 
					else 
					{
						alert('Please provide the Time!');
					};
				} 
				else 
				{
					alert('Please provide the Date!');
				};
			});
		}

		function cancel_pnc_sheet()
		{
			$(document).on('click','#pnc_cancel_btn',function(){
				$('#pnc_current_form').trigger('reset');
				view_pnc_list();
			});
		}

		function view_pnc_list()
		{
			var patient_id = $('#session_patient_id').val();
			var attend_id= $('#session_attend_id').val();
			var preg_id = $('#session_preg_id').val();
			$.ajax({  
				 url:'/layout/attendance/maternity_pnc_check.php',  
				 method:'POST',  
				 datatype:'JSON', 
				 data:{
					 attend_id:attend_id, 
					 patient_id:patient_id,
					 preg_id:preg_id
				 },
				 success:function(data){
					 var res = $.parseJSON(data);
					if (res[0] == 'pnc_preg_exist') 
					{
						if(res[1] == 'pnc_attend_exist')
						{
							 $('#pnc_current_form').hide();
							$('#patient_pnc_table').show();
						}
						else if(res[1] == 'pnc_attend_none')
						{
							$('#pnc_current_form').show();
							$('#patient_pnc_table').show();
						};
					}
					else if(res[0] == 'pnc_preg_none')
					{
						if(res[1] == 'pnc_attend_exist')
						{
							$('#pnc_current_form').hide();
							$('#patient_pnc_table').show();
						}
						else if(res[1] == 'pnc_attend_none')
						{
							$('#pnc_current_form').show();
							$('#patient_pnc_table').show();
						};
					};
					$.ajax({  
						 url:'/layout/attendance/maternity_pnc_view.php',  
						 method:'POST',  
						 datatype:'JSON', 
						 data:{
							 attend_id:attend_id, 
							 patient_id:patient_id,
							 preg_id:preg_id
						 },
						 success:function(data){
							 $('#patient_pnc_table').html(data);
						 }  
					});
				 }  
			});
		}

		function edit_pnc_sheet()
		{
			$(document).on('click','#btn_edit_pnc',function(){
				var pnc_id = $(this).attr('data-id');
				var patient_id = $('#session_patient_id').val();
				var preg_id = $('#session_preg_id').val();
				$.ajax({  
					 url:'/layout/attendance/maternity_pnc_edit.php',  
					 type:'POST',  
					 data:{pnc_id:pnc_id,patient_id:patient_id},
					 datatype: 'JSON',
					 success:function(data)
						 {
							 var res = $.parseJSON(data);
							 $('#pnc_id').val(res[0]);
							 $('#pnc_date').val(res[1]);
							 $('#pnc_time').val(res[2]);
							 $('#pnc_bp_systolic').val(res[3]);
							 $('#pnc_bp_diastolic').val(res[4]);
							$('#pnc_weight').val(res[5]);
							$('#pnc_pulse').val(res[6]);
							$('#pnc_temp').val(res[7]);
							 $('#pnc_urine_protein').val(res[8]);
							 $('#pnc_urine_sugar').val(res[9]);
							 $('#pnc_fundal_height').val(res[10]);
							$('#pnc_loch_colour').val(res[11]);
							$('#pnc_loch_odour').val(res[12]);
							$('#pnc_incision_per').val(res[13]);
							$('#pnc_breast_nipple').val(res[14]);
							$('#pnc_mood_change').val(res[15]);
							$('#pnc_days_ifa_supp').val(res[16]);
							 $('#pnc_complaint').val(res[17]);
							 $('#pnc_initials').val(res[18]);
							 $('#pnc_hb').val(res[19]);
							 $('#pnc_hiv').val(res[20]);
							 $('#pnc_others').val(res[21]);
							$('#pnc_fp_counsel').val(res[22]);
							$('#pnc_fp_method').val(res[23]);
							$('#pnc_fp_remarks').val(res[24]);
							$('#pnc_save_btn').hide();
							$('#pnc_update_btn').prop('hidden',false);
							$('#pnc_cancel_btn').show();
							$('#patient_pnc_table').hide();
							$('#pnc_current_form').show();
						 } 
				});
			}); 
		}

		function update_pnc_sheet()
		{
			$(document).on('click','#pnc_update_btn',function(e){
				e.preventDefault();
				var date = $('#pnc_date').val();
				var time = $('#pnc_time').val();
				var bp_systolic = $('#pnc_bp_systolic').val();
				var bp_diastolic = $('#pnc_bp_diastolic').val();
				var weight = $('#pnc_weight').val();
				var pulse = $('#pnc_pulse').val();
				var temp = $('#pnc_temp').val();
				if (date !=="") 
				{
					if (time !=="") 
					{
						if (bp_systolic !=="") 
						{
							if (bp_diastolic !=="") 
							{
								if (weight !=="") 
								{
									if (pulse !=="") 
									{
										if (temp !=="") 
										{
											var attend_id = $('#session_attend_id').val();
											var patient_id = $('#session_patient_id').val();
											var preg_id = $('#session_preg_id').val();
											$.ajax({
												 url:'/layout/attendance/maternity_pnc_update.php',
												 method:'POST',
												 data:$('#pnc_current_form').serialize() 
														 + '&attend_id=' + attend_id 
														 + '&patient_id=' + patient_id 
														 + '&preg_id=' + preg_id,
												 success:function(data)
													 {
														 $('#pnc_current_form').trigger('reset');
														 view_pnc_list();
													 }
												 });
										} 
										else 
										{
											alert('Please provide the Temperature value!');
										};
									} 
									else 
									{
										alert('Please provide the Pulse value!');
									};
								} 
								else 
								{
									alert('Please provide the Weight!');
								};
							} 
							else 
							{
								alert('Please provide the BP - Diastolic!');
							};
						} 
						else 
						{
							alert('Please provide the BP - Systolic!');
						};
					} 
					else 
					{
						alert('Please provide the Time!');
					};
				} 
				else 
				{
					alert('Please provide the Date!');
				};
			});
		}

		function pnc_child_modal()
		{
			$(document).on('click','#add_pnc_child_btn',function()
			{
				var delivery_id = $('#session_delivery_id').val();
				var pnc_id = $(this).attr('data-id');
				$('#pnc_child_form').trigger('reset');
				$('#pnc_id_child').val(pnc_id);
				$('#pnc_child_modal_title').text('Postnatal - Child Care');
				$('#pc_save_btn').show();
				$('#pc_update_btn').hide();
				//$('#delivery_id_c1').val(delivery_id);
				$('#pnc_child_modal').modal('show');
			});
		}

		function pnc_child_save()
		{
			$(document).on('click','#pc_save_btn',function(e){
				e.preventDefault();
				var date = $('#pc_date').val();
				var time = $('#pc_time').val();
				var temp = $('#pc_temp').val();
				var resp_rate = $('#pc_resp_rate').val();
				var weight = $('#pc_weight').val();
				var length = $('#pc_length').val();
				var head_circ = $('#pc_head_circ').val();
				var pnc_id = $('#pnc_id_child').val();
				if (date !=="") 
				{
					if (time !=="") 
					{
						if (temp !=="") 
						{
							if (resp_rate !=="") 
							{
								if (weight !=="") 
								{
									if (length !=="") 
									{
										if (head_circ !=="") 
										{
											var attend_id = $('#session_attend_id').val();
											var patient_id = $('#session_patient_id').val();
											var preg_id = $('#session_preg_id').val();
											$.ajax({
												 url:'/layout/attendance/maternity_pnc_child_save.php',
												 method:'POST',
												 data:$('#pnc_child_form').serialize() 
														 + '&attend_id=' + attend_id 
														 + '&patient_id=' + patient_id 
														 + '&preg_id=' + preg_id,
												 success:function(data)
													 {
														 $('#pnc_child_form').trigger('reset');
														$('#pnc_child_modal').modal('hide');
														 view_pnc_list();
													 }
												 });
										} 
										else 
										{
											alert('Please provide the Head Circumference value!');
										};
									} 
									else 
									{
										alert('Please provide the Length!');
									};
								} 
								else 
								{
									alert('Please provide the Weight!');
								};
							} 
							else 
							{
								alert('Please provide the Respiratory Rate!');
							};
						} 
						else 
						{
							alert('Please provide the Temperature!');
						};
					} 
					else 
					{
						alert('Please provide the Time!');
					};
				} 
				else 
				{
					alert('Please provide the Date!');
				};
			});
		}

		function pnc_child_edit()
		{
			$(document).on('click','#btn_edit_pnc_child',function(){

				var pnc_child_id = $(this).attr('data-id');

					$.ajax({  
						 url:'/layout/attendance/maternity_pnc_child_edit.php',  
						 type:'POST',  
						 data:{pnc_child_id:pnc_child_id},
						 datatype: 'JSON',
						 success:function(data){
							 var res = $.parseJSON(data);
							 $('#pnc_child_id').val(res[0]);
							 $('#pnc_id_child').val(res[1]);
							 $('#pc_date').val(res[5]);
							 $('#pc_time').val(res[6]);
							$('#pc_weight').val(res[7]);
							$('#pc_length').val(res[8]);
							$('#pc_head_circ').val(res[9]);
							 $('#pc_resp_rate').val(res[10]);
							 $('#pc_temp').val(res[12]);
							 $('#pc_feeding').val(res[13]);
							$('#pc_activities').val(res[14]);
							$('#pc_pallor').val(res[15]);
							$('#pc_jaundice').val(res[16]);
							$('#pc_head').val(res[17]);
							$('#pc_eye').val(res[18]);
							 $('#pc_abdomen').val(res[19]);
							 $('#pc_limbs').val(res[20]);
							 $('#pc_back').val(res[21]);
							$('#pc_skin').val(res[22]);
							$('#pc_heart_rate').val(res[11]);
							$('#pc_pass_urine').val(res[23]);
							 $('#pc_pass_stool').val(res[24]);
							 $('#pc_attend_type').val(res[25]);
							 $('#pc_hiv_date').val(res[26]);
							$('#pc_hiv_result').val(res[27]);
							$('#pc_hiv_remarks').val(res[28]);
							$('#pc_umbelical_cord').val(res[29]);
							$('#pc_initials').val(res[30]);
							$('#pc_remarks').val(res[31]);
							   $('#pc_save_btn').hide();
							   $('#pc_update_btn').show();
							   $('#pnc_child_modal').modal('show');
						 }  
					});
			  }); 
		}

		function pnc_child_update()
		{
			$(document).on('click','#pc_update_btn',function(e){
				e.preventDefault();
				var date = $('#pc_date').val();
				var time = $('#pc_time').val();
				var temp = $('#pc_temp').val();
				var resp_rate = $('#pc_resp_rate').val();
				var weight = $('#pc_weight').val();
				var length = $('#pc_length').val();
				var head_circ = $('#pc_head_circ').val();
				var pnc_id = $('#pnc_id_child').val();
				if (date !=="") 
				{
					if (time !=="") 
					{
						if (temp !=="") 
						{
							if (resp_rate !=="") 
							{
								if (weight !=="") 
								{
									if (length !=="") 
									{
										if (head_circ !=="") 
										{
											var attend_id = $('#session_attend_id').val();
											var patient_id = $('#session_patient_id').val();
											var preg_id = $('#session_preg_id').val();
											$.ajax({
												 url:'/layout/attendance/maternity_pnc_child_update.php',
												 method:'POST',
												 data:$('#pnc_child_form').serialize() 
														 + '&attend_id=' + attend_id 
														 + '&patient_id=' + patient_id 
														 + '&preg_id=' + preg_id,
												 success:function(data)
													 {
														 $('#pnc_child_form').trigger('reset');
														$('#pnc_child_modal').modal('hide');
														 view_pnc_list();
													 }
												 });
										} 
										else 
										{
											alert('Please provide the Head Circumference value!');
										};
									} 
									else 
									{
										alert('Please provide the Length!');
									};
								} 
								else 
								{
									alert('Please provide the Weight!');
								};
							} 
							else 
							{
								alert('Please provide the Respiratory Rate!');
							};
						} 
						else 
						{
							alert('Please provide the Temperature!');
						};
					} 
					else 
					{
						alert('Please provide the Time!');
					};
				} 
				else 
				{
					alert('Please provide the Date!');
				};
			});
		}
	//MATERNITY LEAVE
		function anc_maternity_leave_setup()
		{
			$(document).on('click','#anc_maternity_leave_btn,#pnc_maternity_leave_btn',function(){
				var name = $('#session_name').val();
				var preg_id = $('#session_preg_id').val();
				var patient_id = $('#session_patient_id').val();
				$.ajax({
				 url:'/layout/attendance/maternity_leave_open.php',
				 method:'POST',
				 datatype:'JSON',
				 data:{
					 preg_id:preg_id,
					 patient_id:patient_id
				 },
				 success:function(data)
					 {
						 var res = $.parseJSON(data)
						 if(res[0] =='none')
						 {
							var date = moment(new Date()).format("YYYY-MM-DD");
							$('#maternity_leave_form').trigger('reset');
							$('#name_of_patient').val(name);
							$('#date_of_delivery').val(date);
							$('#date_of_issue').val(date);
							//$('#medical_officer').val();
							$('#maternity_leave_edit_btn').hide();
							$('#maternity_leave_update_btn').hide();
							$('#maternity_leave_save_btn').show();
							$('#maternity_leave_cancel_btn').show();
							$('#maternity_leave_modal').modal('show');
						 }
						 else if(res[0] =='exist')
						 {
							 $.ajax({
							 url:'/layout/attendance/maternity_leave_view.php',
							 method:'POST',
							 data:{
								 preg_id:preg_id,
								 patient_id:patient_id
							 },
							 success:function(data)
								 {
									 $('#maternity_leave_body_div').html(data);
									$('#maternity_leave_body_div').show();
									$('#maternity_leave_form').hide();
									$('#maternity_leave_edit_btn').prop("data-id",res[1]);
									$('#maternity_leave_edit_btn').show();
									$('#maternity_leave_update_btn').hide();
									$('#maternity_leave_save_btn').hide();
									$('#maternity_leave_cancel_btn').show();
									 $('#maternity_leave_modal').modal('show');
									//window.open('/layout/vouchers/receipt_pdf.php', '_blank');
									 
								 }
							});
						 }
						 
					 }
				});
			  }); 
		}

		function anc_maternity_leave_save()
		{
			$(document).on('click','#maternity_leave_save_btn',function(e)
			{
				e.preventDefault();
				var delivery_id = $('#session_delivery_id').val();
				var patient_id = $('#session_patient_id').val();
				var attend_id = $('#session_attend_id').val();
				var preg_id = $('#session_preg_id').val();

				var patient_name = $('#name_of_patient').val();
				var delivery_date = $('#date_of_delivery').val();
				var remarks = $('#remarks').val();
				var issue_date = $('#date_of_issue').val();
				var medical_officer = $('#medical_officer').val();
				if(patient_name !=="")
				{
					if(delivery_date !=="")
					{
						if(remarks !=="" )
						{
							if(issue_date !=="" )
							{
								if(medical_officer !=="")
								{
									$.ajax({
										 url:'/layout/attendance/maternity_leave_save.php',
										 method:'POST',
										 data:{
											 delivery_id:delivery_id,
											 patient_id:patient_id,
											 attend_id:attend_id,
											 preg_id:preg_id,
											 patient_name:patient_name,
											 delivery_date:delivery_date,
											 remarks:remarks,
											 issue_date:issue_date,
											 medical_officer:medical_officer
										 },
										 success:function(data)
											{
												$('#maternity_leave_modal').modal('hide');
												window.open('/layout/attendnace/maternity_leave_pdf.php', '_blank');
									 
											}
									});
								}
								else
								{
									alert('Please enter the name of the Medical Officer!');
								};
							}
							else
							{
								alert('Please enter the date of issue!');
							};
						}
						else
						{
							alert('Please enter the remarks!');
						};
					}
					else
					{
						alert('Please enter the date of delivery!');
					};
				}
				else
				{
					alert('Please enter the Patient Name');
				};
			 });
		}

		function anc_maternity_leave_edit()
		{
			$(document).on('click','#maternity_leave_edit_btn',function(){
				var mat_leave_id = $('#maternity_leave_edit_btn').prop('data-id');
				var patient_id = $('#session_patient_id').val();
				$.ajax({
				 url:'/layout/attendance/maternity_leave_edit.php',
				 method:'POST',
				 datatype:'JSON',
				 data:{
					 mat_leave_id:mat_leave_id,
					 patient_id:patient_id
				 },
				 success:function(data)
					 {
						 var res = $.parseJSON(data);
						 $('#mat_leave_id').val(res[0]);
						 $('#name_of_patient').val(res[1]);
						$('#date_of_delivery').val(res[2]);
						$('#remarks').val(res[5]);
						$('#date_of_issue').val(res[3]);
						$('#medical_officer').val(res[4]);
						$('#maternity_leave_body_div').hide();
						$('#maternity_leave_form').show();
						$('#maternity_leave_edit_btn').hide();
						$('#maternity_leave_update_btn').show();
						$('#maternity_leave_save_btn').hide();
						$('#maternity_leave_cancel_btn').show();
						$('#maternity_leave_modal').modal('show');
					 }
				});
			  }); 
		}

		function anc_maternity_leave_update()
		{
			$(document).on('click','#maternity_leave_update_btn',function(e)
			{
				e.preventDefault();
				var delivery_id = $('#session_delivery_id').val();
				var patient_id = $('#session_patient_id').val();
				var attend_id = $('#session_attend_id').val();
				var preg_id = $('#session_preg_id').val();

				var patient_name = $('#name_of_patient').val();
				var delivery_date = $('#date_of_delivery').val();
				var remarks = $('#remarks').val();
				var issue_date = $('#date_of_issue').val();
				var medical_officer = $('#medical_officer').val();
				var mat_leave_id = $('#mat_leave_id').val();
				if(patient_name !=="")
				{
					if(delivery_date !=="")
					{
						if(remarks !=="" )
						{
							if(issue_date !=="" )
							{
								if(medical_officer !=="")
								{
									$.ajax({
										 url:'/layout/attendance/maternity_leave_update.php',
										 method:'POST',
										 data:{
											 delivery_id:delivery_id,
											 patient_id:patient_id,
											 attend_id:attend_id,
											 preg_id:preg_id,
											 patient_name:patient_name,
											 delivery_date:delivery_date,
											 remarks:remarks,
											 issue_date:issue_date,
											 medical_officer:medical_officer,
											 mat_leave_id:mat_leave_id
										 },
										 success:function(data)
											{
												$('#maternity_leave_modal').modal('hide');
												window.open('/layout/attendance/maternity_leave_pdf.php', '_blank');
											}
									});
								}
								else
								{
									alert('Please enter the name of the Medical Officer!');
								};
							}
							else
							{
								alert('Please enter the date of issue!');
							};
						}
						else
						{
							alert('Please enter the remarks!');
						};
					}
					else
					{
						alert('Please enter the date of delivery!');
					};
				}
				else
				{
					alert('Please enter the Patient Name');
				};
			 });
		}

		function cancel_anc_maternity_leave_setup()
		{
			$(document).on('click','#maternity_leave_cancel_btn',function(){
				$('#maternity_leave_form').trigger('reset');
				$('#maternity_leave_modal').modal('hide');
			});
		}