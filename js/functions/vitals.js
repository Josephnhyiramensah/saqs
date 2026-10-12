$(document).ready(function()
{
	//VTALS
		go_to_vitals_sheet();
		save_vitals();
		edit_vital();
		update_vitals();
		delete_vitals();
		view_current_vitals();
		add_fluid_input();
		add_fluid_output();
		save_fluid();
		edit_fluid();
		delete_fluid();
		update_fluid();
		view_current_fluid();
		view_vitals_history();
		cvd_risk_assessment();
		//chart_temperature();
});

	//VITALS
	function go_to_vitals_sheet()
	{
		$(document).on('click','#nav_vitals',function()
		{
			window.location.href="/layout/attendance/vitals_sheet.php";
			$('#vitals_update_btn').hide();
			$('#vitals_save_btn').show();
			$('#vitals_input_form').trigger('reset');
		}) 
	}

	function save_vitals()
	{
		$(document).on('click','#vitals_save_btn',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var date_attend = $('#session_dateofadmission_attd').val();
			var temp = $('#temp').val();
			var bsystolic = $('#bsystolic').val();
			var bdiastolic = $('#bdiastolic').val();
			var pulse = $('#pulse').val();
			var rrate = $('#rrate').val();
			var weight = $('#weight').val();
			var height = $('#height').val();
			var oxygen = $('#oxygen').val();
			var hipcirc = $('#hipcirc').val();
			var abdcirc = $('#abdcirc').val();
			var date = $('#v_date').val();
			var time = $('#v_time').val();
			var fbs = $('#fbs').val();
			var rbs = $('#rbs').val();
			var vitals_comment = $('#vitals_comment').val();
			if (date >= date_attend) 
			{
				if (temp > 0) 
				{
					$.ajax({
					 url:'/layout/attendance/vitals_save.php',
					 method:'POST',
					 data:{
						 attend_id:attend_id,
						 patient_id:patient_id,
						 temp:temp,
						 bsystolic:bsystolic,
						 bdiastolic:bdiastolic,
						 pulse:pulse,
						 rrate:rrate,
						 weight:weight,
						 height:height,
						 oxygen:oxygen,
						 hipcirc:hipcirc,
						 abdcirc:abdcirc,
						 date:date,
						 time:time,
						 fbs:fbs,
						 rbs:rbs,
						 vitals_comment:vitals_comment
					 },
					 success:function(data)
						 {
							 $('#vitals_input_form').trigger('reset');
							 view_current_vitals();
						 }
					 });} 
				else 
				{
					alert('Please enter Temperature!')
				};
			} 
			else 
			{
				alert('Please the date cannot be earlier than the attendance date!')
			};
		});
	}

	function edit_vital()
	{
		$(document).on('click','#btn_edit_vital',function(){

			var vital_id = $(this).attr('data-id1');
			$.ajax({  
					 url:'/layout/attendance/vitals_edit.php',  
					 type:'POST',  
					 data:{vital_id:vital_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#vital_id').val(res[0]);
						$('#temp').val(res[1]);
						$('#bsystolic').val(res[2]);
						$('#bdiastolic').val(res[3]);
						$('#weight').val(res[4]);
						$('#height').val(res[5]);
						$('#pulse').val(res[6]);
						$('#rrate').val(res[7]);
						$('#hipcirc').val(res[8]);
						$('#abdcirc').val(res[9]);
						$('#oxygen').val(res[10]);
						$('#vitals_comment').val(res[11]);
						$('#v_date').val(res[12]);
						$('#v_time').val(res[13]);
						$('#fbs').val(res[14]);
						$('#rbs').val(res[15]);
						$('#vital_save_update').html('<button type="submit" id="vitals_update_btn" class="btn btn-primary btn-block">Update</button>');
						$('#vitals_save_btn').hide();
					}  
				});
		  }); 
	}

	function delete_vitals()
	{
		$(document).on('click','#btn_delete_vital',function(){
			var vital_id = $(this).attr('data-id2');
			var currentRow=$(this).closest("tr");
			var vitaldate = currentRow.find("td:eq(0)").text();
			$('#vital_delete_question').text('Are you sure you want to delete ' + vitaldate + '?');
			$('#vital_delete_modal').modal('show');
			$(document).on('click','#vital_delete_yes',function(){
				$.ajax({  
					 url:'/layout/attendance/vitals_delete.php',  
					 type:'POST',  
					 data:{vital_id:vital_id},
					 success:function(){
						 $('#vital_delete_modal').modal('hide');
						 view_current_vitals();
					 }  
				});
			  });
			$(document).on('click','#vital_delete_no',function(){
				$('#vital_delete_modal').modal('hide');
			});
		});
	}

	function update_vitals()
	{
		$(document).on('click','#vitals_update_btn',function(e){
			e.preventDefault();
			var date_attend = $('#session_dateofadmission_attd').val();
			var vital_id = $('#vital_id').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var temp = $('#temp').val();
			var bsystolic = $('#bsystolic').val();
			var bdiastolic = $('#bdiastolic').val();
			var pulse = $('#pulse').val();
			var rrate = $('#rrate').val();
			var weight = $('#weight').val();
			var height = $('#height').val();
			var oxygen = $('#oxygen').val();
			var hipcirc = $('#hipcirc').val();
			var abdcirc = $('#abdcirc').val();
			var date = $('#v_date').val();
			var time = $('#v_time').val();
			var fbs = $('#fbs').val();
			var rbs = $('#rbs').val();
			var vitals_comment = $('#vitals_comment').val();
			if (date >= date_attend) 
			{
				if (temp > 0) 
				{
					$.ajax({
						 url:'/layout/attendance/vitals_update.php',
						 method:'POST',
						 data:{
							 vital_id:vital_id,
							 attend_id:attend_id,
							 patient_id:patient_id,
							 temp:temp,
							 bsystolic:bsystolic,
							 bdiastolic:bdiastolic,
							 pulse:pulse,
							 rrate:rrate,
							 weight:weight,
							 height:height,
							 oxygen:oxygen,
							 hipcirc:hipcirc,
							 date:date,
							 time:time,
							 fbs:fbs,
							 rbs:rbs,
							 abdcirc:abdcirc,
							 vitals_comment:vitals_comment
						 },
						 success:function(data)
							 {
								 $('#vitals_input_form').trigger('reset');
								 $('#vital_save_update').html('<button type="submit" id="vitals_save_btn" class="btn btn-primary btn-block">Save</button>');
								$('#vitals_update_btn').hide();
								 view_current_vitals();
							 }
					});
				} 
				else 
				{
					alert('Please enter Temperature!')
				};
			} 
			else 
			{
				alert('Please the date cannot be earlier than the attendance date!')
			};
		});
	}

	function view_current_vitals()
	{
		var attend_id = $('#session_attend_id').val();
		var patient_id = $('#session_patient_id').val();
		$.ajax(
		{
			url: '/layout/attendance/vitals_current_view.php',
			method: 'POST',
			data:{
					 attend_id:attend_id,
					 patient_id:patient_id
				 },
			success: function(data)
			{
				$('#attend-vitals-table').html(data);
			}
		});
	}

	function add_fluid_input()
	{
		$(document).on('keyup','#fb_oral_input_mls, #fb_ivi_input_mls',function(e){
			e.preventDefault();
			var oral_input_mls = $('#fb_oral_input_mls').val();
			var ivi_input_mls = $('#fb_ivi_input_mls').val();
			if(oral_input_mls =='')
			{
				var fb_oral_input_mls = 0;
			}
			else
			{
				var fb_oral_input_mls = parseFloat(oral_input_mls);
			};
			if(ivi_input_mls =='')
			{
				var fb_ivi_input_mls = 0;
			}
			else
			{
				var fb_ivi_input_mls = parseFloat(ivi_input_mls);
			};
			if (fb_oral_input_mls =='' && fb_ivi_input_mls =='') 
			{
				total_input = 0;
				//alert('Please enter either Oral or IVI input!');
			} 
			else
			{
				var total_input = fb_oral_input_mls + fb_ivi_input_mls;
			};
			$('#fb_cum_input').val(total_input);
			$('#fb_cum_inputD').val(total_input);
		});
	}

	function add_fluid_output()
	{
		$(document).on('keyup','#fb_vomit, #fb_urine, #fb_bowels',function(e){
			e.preventDefault();
			var vomit = $('#fb_vomit').val();
			var urine = $('#fb_urine').val();
			var bowels = $('#fb_bowels').val();
			if(vomit =='')
			{
				var fb_vomit = 0;
			}
			else
			{
				var fb_vomit = parseFloat(vomit);
			};
			if(urine =='')
			{
				var fb_urine = 0;
			}
			else
			{
				var fb_urine = parseFloat(urine);
			};
			if(bowels =='')
			{
				var fb_bowels = 0;
			}
			else
			{
				var fb_bowels = parseFloat(bowels);
			};
			if (fb_vomit =='' && fb_urine =='' && fb_bowels =='')
			{
				total_output = 0;
				//alert('Please enter either Vomit, Urine or Bowels Output!');
			}
			else
			{
				var total_output = fb_vomit + fb_urine + fb_bowels;
			};
			$('#fb_cum_output').val(total_output);
			$('#fb_cum_outputD').val(total_output);
		});
	}

	function save_fluid()
	{
		$(document).on('click','#fb_save_btn',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var date_attend = $('#session_dateofadmission_attd').val();
			var oral_input_mls = $('#fb_oral_input_mls').val();
			var ivi_input_mls = $('#fb_ivi_input_mls').val();
			var vomit = $('#fb_vomit').val();
			var urine = $('#fb_urine').val();
			var bowels = $('#fb_bowels').val();
			if (date >= date_attend) 
			{
				if (oral_input_mls ==''&&ivi_input_mls==''&&vomit==''&&urine==''&&bowels=='') 
				{
					alert('Please enter either Orals, IVI, Vomit, Urine or Bowel value!');
				} 
				else 
				{
					$.ajax({
						url:'/layout/attendance/fluid_save.php',
						method:'POST',
						data:$('#fluid_data_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
						success:function(data)
						{
							$('#fluid_data_form').trigger('reset');
							view_current_fluid();
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

	function edit_fluid()
	{
		$(document).on('click','#btn_edit_fluid',function(){

			var fluid_data_id = $(this).attr('data-id1');
			$.ajax({  
					 url:'/layout/attendance/fluid_edit.php',  
					 type:'POST',  
					 data:{fluid_data_id:fluid_data_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#fluid_data_id').val(res[0]);
						$('#fb_oral_input').val(res[1]);
						$('#fb_oral_input_mls').val(res[2]);
						$('#fb_ivi_input').val(res[3]);
						$('#fb_ivi_input_mls').val(res[4]);
						$('#fb_cum_input').val(res[5]);
						$('#fb_cum_inputD').val(res[5]);
						$('#fb_vomit').val(res[6]);
						$('#fb_urine').val(res[7]);
						$('#fb_bowels').val(res[8]);
						$('#fb_cum_output').val(res[9]);
						$('#fb_cum_outputD').val(res[9]);
						$('#fd_date').val(res[10]);
						$('#fb_time').val(res[11]);
						$('#fb_comment').val(res[12]);
						$('#fb_save_update').html('<button type="submit" id="fb_update_btn" class="btn btn-primary btn-block">Update</button>');
						$('#fb_save_btn').hide();
					 }
				});
		  }); 
	}

	function delete_fluid()
	{
		$(document).on('click','#btn_delete_fluid',function(){
			var fluid_data_id = $(this).attr('data-id2');
			var currentRow=$(this).closest("tr");
			var fluiddate = currentRow.find("td:eq(0)").text();
			$('#vital_delete_question').text('Are you sure you want to delete ' + fluiddate + '?');
			$('#vital_delete_modal').modal('show');
			$(document).on('click','#vital_delete_yes',function()
			{
				$.ajax({  
					 url:'/layout/attendance/fluid_delete.php',  
					 type:'POST',  
					 data:{fluid_data_id:fluid_data_id},
					 success:function()
					 {
						 $('#vital_delete_modal').modal('hide');
						 view_current_fluid();
					 }
				});
			  });
			$(document).on('click','#vital_delete_no',function(){
				$('#vital_delete_modal').modal('hide');
			});
		});
	}

	function update_fluid()
	{
		$(document).on('click','#fb_update_btn',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var date_attend = $('#session_dateofadmission_attd').val();
			var oral_input_mls = $('#fb_oral_input_mls').val();
			var ivi_input_mls = $('#fb_ivi_input_mls').val();
			var vomit = $('#fb_vomit').val();
			var urine = $('#fb_urine').val();
			var bowels = $('#fb_bowels').val();
			if (date >= date_attend) 
			{
				if (oral_input_mls ==''&&ivi_input_mls==''&&vomit==''&&urine==''&&bowels=='') 
				{
					alert('Please enter either Orals, IVI, Vomit, Urine or Bowel value!');
				} 
				else 
				{
					$.ajax({
						url:'/layout/attendance/fluid_update.php',
						method:'POST',
						data:$('#fluid_data_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
						success:function(data)
						{
							$('#fluid_data_form').trigger('reset');
							view_current_fluid();
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

	function view_current_fluid()
	{
		var attend_id = $('#session_attend_id').val();
		var patient_id = $('#session_patient_id').val();
		$.ajax(
		{
			url: '/layout/attendance/fluid_current_view.php',
			method: 'POST',
			data:{
					 attend_id:attend_id,
					 patient_id:patient_id
				 },
			success: function(data)
			{
				$('#attend_fluid_data_table').html(data);
			}
		});
	}

	function view_vitals_history()
	{
		$(document).on('click','#vitals_history_icon',function(){
			
			var patient_id = $('#session_patient_id').val();
			$.ajax(
			{
				url: '/layout/attendance/vitals_history_view.php',
				method: 'POST',
				data:{
						 patient_id:patient_id
					 },
				success: function(data)
				{
					$('#attend-vitalshistory-table').html(data);
					$('#vitalshistorymodal').modal('show');
				}
			})
		});
	}

	function cvd_risk_assessment()
	{
		$(document).on('keyup change','#time_period,#cvd_age,#cvd_male,#bsystolic,#smoking,#chol_tc,#diabetes,#chol_hdl,#ivh,#family_hx,#cigarette,#simd',function(){
			var Stat_CV_timeperiod = $('#time_period').val();
			var Stat_CV_age = $('#cvd_age').val();
			var Stat_CV_male = $('#cvd_male').val();
			var BP_Systolic = $('#bsystolic').val();
			var Stat_CV_smoker = $('#smoking').val();
			var Stat_chol_total = $('#chol_tc').val();
			var Stat_CV_diabetes = $('#diabetes').val();
			var Stat_chol_hdl = $('#chol_hdl').val();
			var Stat_CV_lvh = $('#ivh').val();
			var Stat_CV_family_hx = $('#family_hx').val();
			var Stat_CV_cigarettes = $('#cigarette').val();
			var Stat_CV_simd = $('#simd').val();

			/*var chd = 100*(1-Exp(-Exp((Ln(Stat_CV_timeperiod)-(15.5305+(28.4441*(1-Stat_CV_male))+(-1.4792*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age))+(-14.4588*Ln(Stat_CV_age)*(1-Stat_CV_male))+(1.8515*Ln(Stat_CV_age)*Ln(Stat_CV_age)*(1-Stat_CV_male))+(-.9119*Ln(BP_Systolic))+(-.2767*Stat_CV_smoker)+(-.7181*Ln(Stat_chol_total/Stat_chol_hdl))+(-.1759*Stat_CV_diabetes)+(-.1999*Stat_CV_diabetes*(1-Stat_CV_male))+(-.5865*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))/(Exp(.9145)*Exp(-.2784*(15.5305+(28.4441*(1-Stat_CV_male))+(-1.4792*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age))+(-14.4588*Ln(Stat_CV_age)*(1-Stat_CV_male))+(1.8515*Ln(Stat_CV_age)*Ln(Stat_CV_age)*(1-Stat_CV_male))+(-.9119*Ln(BP_Systolic))+(-.2767*Stat_CV_smoker)+(-.7181*Ln(Stat_chol_total/Stat_chol_hdl))+(-0.1759*Stat_CV_diabetes)+(-.1999*Stat_CV_diabetes*(1-Stat_CV_male))+(-.5865*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))))));
			var stroke = 100*(1-Exp(-Exp((Ln(Stat_CV_timeperiod)-(26.5116+(.2019*(1-Stat_CV_male))+(-2.3741*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*(1-Stat_CV_male))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age)*(1-Stat_CV_male))+(-2.4643*Ln(BP_Systolic))+(-.3914*Stat_CV_smoker)+(-.0229*Ln(Stat_chol_total/Stat_chol_hdl))+(-.3087*Stat_CV_diabetes)+(-.2627*Stat_CV_diabetes*(1-Stat_CV_male))+(-.2355*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))/(Exp(-.4312)*Exp(0*(26.5116+(.2019*(1-Stat_CV_male))+(-2.3741*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*(1-Stat_CV_male))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age)*(1-Stat_CV_male))+(-2.4643*Ln(BP_Systolic))+(-.3914*Stat_CV_smoker)+(-.0229*Ln(Stat_chol_total/Stat_chol_hdl))+(-.3087*Stat_CV_diabetes)+(-.2627*Stat_CV_diabetes*(1-Stat_CV_male))+(-.2355*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))))));
			var mi = 100*(1-Exp(-Exp((Ln(Stat_CV_timeperiod)-(11.4712+(10.5109*(1-Stat_CV_male))+(-.7965*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age))+(-5.4216*Ln(Stat_CV_age)*(1-Stat_CV_male))+(.7101*Ln(Stat_CV_age)*Ln(Stat_CV_age)*(1-Stat_CV_male))+(-.6623*Ln(BP_Systolic))+(-.2675*Stat_CV_smoker)+(-.4277*Ln(Stat_chol_total/Stat_chol_hdl))+(-.1534*Stat_CV_diabetes)+(-.1165*Stat_CV_diabetes*(1-Stat_CV_male))+(0*Stat_CV_lvh)+(-.1588*Stat_CV_lvh*Stat_CV_male)))/(Exp(3.4064)*Exp(-.8584*(11.4712+(10.5109*(1-Stat_CV_male))+(-.7965*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age))+(-5.4216*Ln(Stat_CV_age)*(1-Stat_CV_male))+(.7101*Ln(Stat_CV_age)*Ln(Stat_CV_age)*(1-Stat_CV_male))+(-.6623*Ln(BP_Systolic))+(-.2675*Stat_CV_smoker)+(-.4277*Ln(Stat_chol_total/Stat_chol_hdl))+(-.1534*Stat_CV_diabetes)+(-.1165*Stat_CV_diabetes*(1-Stat_CV_male))+(0*Stat_CV_lvh)+(-.1588*Stat_CV_lvh*Stat_CV_male)))))));
			var framingham = 100*(1-Exp(-Exp((Ln(Stat_CV_timeperiod)-(18.8144+(-1.2146*(1-Stat_CV_male))+(-1.8443*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age))+(.3668*Ln(Stat_CV_age)*(1-Stat_CV_male))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age)*(1-Stat_CV_male))+(-1.4032*Ln(BP_Systolic))+(-.3899*Stat_CV_smoker)+(-.539*Ln(Stat_chol_total/Stat_chol_hdl))+(-.3036*Stat_CV_diabetes)+(-.1697*Stat_CV_diabetes*(1-Stat_CV_male))+(-.3362*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))/(Exp(.6536)*Exp(-.2402*(18.8144+(-1.2146*(1-Stat_CV_male))+(-1.8443*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age))+(.3668*Ln(Stat_CV_age)*(1-Stat_CV_male))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age)*(1-Stat_CV_male))+(-1.4032*Ln(BP_Systolic))+(-.3899*Stat_CV_smoker)+(-.539*Ln(Stat_chol_total/Stat_chol_hdl))+(-.3036*Stat_CV_diabetes)+(-.1697*Stat_CV_diabetes*(1-Stat_CV_male))+(-.3362*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))))));
			var cvd_death = 100*(1-Exp(-Exp((Ln(Stat_CV_timeperiod)-(-5.0385+(.2243*(1-Stat_CV_male))+(8.237*Ln(Stat_CV_age))+(-1.2109*Ln(Stat_CV_age)*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*(1-Stat_CV_male))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age)*(1-Stat_CV_male))+(-.8383*Ln(BP_Systolic))+(-.1618*Stat_CV_smoker)+(-.3493*Ln(Stat_chol_total/Stat_chol_hdl))+(-.0833*Stat_CV_diabetes)+(-.2067*Stat_CV_diabetes*(1-Stat_CV_male))+(-.2946*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))/(Exp(.8207)*Exp(-.4346*(-5.0385+(.2243*(1-Stat_CV_male))+(8.237*Ln(Stat_CV_age))+(-1.2109*Ln(Stat_CV_age)*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*(1-Stat_CV_male))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age)*(1-Stat_CV_male))+(-.8383*Ln(BP_Systolic))+(-.1618*Stat_CV_smoker)+(-.3493*Ln(Stat_chol_total/Stat_chol_hdl))+(-.0833*Stat_CV_diabetes)+(-.2067*Stat_CV_diabetes*(1-Stat_CV_male))+(-.2946*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))))));
			if(Stat_CV_male=1){var assign = 100*(1-(.8831^(Exp((Stat_CV_age*.05698)+(Stat_chol_total*.22286)+(Stat_chol_hdl*-.53684)+(BP_Systolic*.01183)+(Stat_CV_diabetes*.81558)+(Stat_CV_family_hx*.275)+(Stat_CV_cigarettes*.02005)+(Stat_CV_simd*.1*.06296)-5.447113))))}else{var assign = 100*(1-(.9365^(Exp((Stat_CV_age*.07203)+(Stat_chol_total*.1272)+(Stat_chol_hdl*-.55836)+(BP_Systolic*.01064)+(Stat_CV_diabetes*.97727)+(Stat_CV_family_hx*.49159)+(Stat_CV_cigarettes*.02724)+(Stat_CV_simd*.1*.09386)-5.418379))))};
			var bnf = chd + stroke;
			var chd_death = 100*(1-Exp(-Exp((Ln(Stat_CV_timeperiod)-(11.2889+(.2332*(1-Stat_CV_male))+(-.944*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*(1-Stat_CV_male))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age)*(1-Stat_CV_male))+(-.588*Ln(BP_Systolic))+(-.1367*Stat_CV_smoker)+(-.3448*Ln(Stat_chol_total/Stat_chol_hdl))+(-.0474*Stat_CV_diabetes)+(-.2233*Stat_CV_diabetes*(1-Stat_CV_male))+(-.1237*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))/(Exp(2.9851)*Exp(-.9142*(11.2889+(.2332*(1-Stat_CV_male))+(-.944*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age))+(0*Ln(Stat_CV_age)*(1-Stat_CV_male))+(0*Ln(Stat_CV_age)*Ln(Stat_CV_age)*(1-Stat_CV_male))+(-.588*Ln(BP_Systolic))+(-.1367*Stat_CV_smoker)+(-.3448*Ln(Stat_chol_total/Stat_chol_hdl))+(-.0474*Stat_CV_diabetes)+(-.2233*Stat_CV_diabetes*(1-Stat_CV_male))+(-.1237*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))))));*/
			
			var chd = 100*(1-Math.exp(-Math.exp((Math.log(Stat_CV_timeperiod)-(15.5305+(28.4441*(1-Stat_CV_male))+(-1.4792*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age))+(-14.4588*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(1.8515*Math.log(Stat_CV_age)*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(-.9119*Math.log(BP_Systolic))+(-.2767*Stat_CV_smoker)+(-.7181*Math.log(Stat_chol_total/Stat_chol_hdl))+(-.1759*Stat_CV_diabetes)+(-.1999*Stat_CV_diabetes*(1-Stat_CV_male))+(-.5865*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))/(Math.exp(.9145)*Math.exp(-.2784*(15.5305+(28.4441*(1-Stat_CV_male))+(-1.4792*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age))+(-14.4588*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(1.8515*Math.log(Stat_CV_age)*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(-.9119*Math.log(BP_Systolic))+(-.2767*Stat_CV_smoker)+(-.7181*Math.log(Stat_chol_total/Stat_chol_hdl))+(-0.1759*Stat_CV_diabetes)+(-.1999*Stat_CV_diabetes*(1-Stat_CV_male))+(-.5865*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))))));
			var stroke = 100*(1-Math.exp(-Math.exp((Math.log(Stat_CV_timeperiod)-(26.5116+(.2019*(1-Stat_CV_male))+(-2.3741*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(-2.4643*Math.log(BP_Systolic))+(-.3914*Stat_CV_smoker)+(-.0229*Math.log(Stat_chol_total/Stat_chol_hdl))+(-.3087*Stat_CV_diabetes)+(-.2627*Stat_CV_diabetes*(1-Stat_CV_male))+(-.2355*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))/(Math.exp(-.4312)*Math.exp(0*(26.5116+(.2019*(1-Stat_CV_male))+(-2.3741*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(-2.4643*Math.log(BP_Systolic))+(-.3914*Stat_CV_smoker)+(-.0229*Math.log(Stat_chol_total/Stat_chol_hdl))+(-.3087*Stat_CV_diabetes)+(-.2627*Stat_CV_diabetes*(1-Stat_CV_male))+(-.2355*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))))));
			var mi = 100*(1-Math.exp(-Math.exp((Math.log(Stat_CV_timeperiod)-(11.4712+(10.5109*(1-Stat_CV_male))+(-.7965*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age))+(-5.4216*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(.7101*Math.log(Stat_CV_age)*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(-.6623*Math.log(BP_Systolic))+(-.2675*Stat_CV_smoker)+(-.4277*Math.log(Stat_chol_total/Stat_chol_hdl))+(-.1534*Stat_CV_diabetes)+(-.1165*Stat_CV_diabetes*(1-Stat_CV_male))+(0*Stat_CV_lvh)+(-.1588*Stat_CV_lvh*Stat_CV_male)))/(Math.exp(3.4064)*Math.exp(-.8584*(11.4712+(10.5109*(1-Stat_CV_male))+(-.7965*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age))+(-5.4216*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(.7101*Math.log(Stat_CV_age)*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(-.6623*Math.log(BP_Systolic))+(-.2675*Stat_CV_smoker)+(-.4277*Math.log(Stat_chol_total/Stat_chol_hdl))+(-.1534*Stat_CV_diabetes)+(-.1165*Stat_CV_diabetes*(1-Stat_CV_male))+(0*Stat_CV_lvh)+(-.1588*Stat_CV_lvh*Stat_CV_male)))))));
			var framingham = 100*(1-Math.exp(-Math.exp((Math.log(Stat_CV_timeperiod)-(18.8144+(-1.2146*(1-Stat_CV_male))+(-1.8443*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age))+(.3668*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(-1.4032*Math.log(BP_Systolic))+(-.3899*Stat_CV_smoker)+(-.539*Math.log(Stat_chol_total/Stat_chol_hdl))+(-.3036*Stat_CV_diabetes)+(-.1697*Stat_CV_diabetes*(1-Stat_CV_male))+(-.3362*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))/(Math.exp(.6536)*Math.exp(-.2402*(18.8144+(-1.2146*(1-Stat_CV_male))+(-1.8443*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age))+(.3668*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(-1.4032*Math.log(BP_Systolic))+(-.3899*Stat_CV_smoker)+(-.539*Math.log(Stat_chol_total/Stat_chol_hdl))+(-.3036*Stat_CV_diabetes)+(-.1697*Stat_CV_diabetes*(1-Stat_CV_male))+(-.3362*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))))));
			var cvd_death = 100*(1-Math.exp(-Math.exp((Math.log(Stat_CV_timeperiod)-(-5.0385+(.2243*(1-Stat_CV_male))+(8.237*Math.log(Stat_CV_age))+(-1.2109*Math.log(Stat_CV_age)*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(-.8383*Math.log(BP_Systolic))+(-.1618*Stat_CV_smoker)+(-.3493*Math.log(Stat_chol_total/Stat_chol_hdl))+(-.0833*Stat_CV_diabetes)+(-.2067*Stat_CV_diabetes*(1-Stat_CV_male))+(-.2946*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))/(Math.exp(.8207)*Math.exp(-.4346*(-5.0385+(.2243*(1-Stat_CV_male))+(8.237*Math.log(Stat_CV_age))+(-1.2109*Math.log(Stat_CV_age)*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(-.8383*Math.log(BP_Systolic))+(-.1618*Stat_CV_smoker)+(-.3493*Math.log(Stat_chol_total/Stat_chol_hdl))+(-.0833*Stat_CV_diabetes)+(-.2067*Stat_CV_diabetes*(1-Stat_CV_male))+(-.2946*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))))));
			if(Stat_CV_male=1){var assign = 100*(1-(Math.pow(.8831,(Math.exp((Stat_CV_age*.05698)+(Stat_chol_total*.22286)+(Stat_chol_hdl*-.53684)+(BP_Systolic*.01183)+(Stat_CV_diabetes*.81558)+(Stat_CV_family_hx*.275)+(Stat_CV_cigarettes*.02005)+(Stat_CV_simd*.1*.06296)-5.447113)))))}else{var assign = 100*(1-(Math.pow(.9365,(Math.exp((Stat_CV_age*.07203)+(Stat_chol_total*.1272)+(Stat_chol_hdl*-.55836)+(BP_Systolic*.01064)+(Stat_CV_diabetes*.97727)+(Stat_CV_family_hx*.49159)+(Stat_CV_cigarettes*.02724)+(Stat_CV_simd*.1*.09386)-5.418379)))))};
			var bnf = chd + stroke;
			var chd_death = 100*(1-Math.exp(-Math.exp((Math.log(Stat_CV_timeperiod)-(11.2889+(.2332*(1-Stat_CV_male))+(-.944*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(-.588*Math.log(BP_Systolic))+(-.1367*Stat_CV_smoker)+(-.3448*Math.log(Stat_chol_total/Stat_chol_hdl))+(-.0474*Stat_CV_diabetes)+(-.2233*Stat_CV_diabetes*(1-Stat_CV_male))+(-.1237*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))/(Math.exp(2.9851)*Math.exp(-.9142*(11.2889+(.2332*(1-Stat_CV_male))+(-.944*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age))+(0*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(0*Math.log(Stat_CV_age)*Math.log(Stat_CV_age)*(1-Stat_CV_male))+(-.588*Math.log(BP_Systolic))+(-.1367*Stat_CV_smoker)+(-.3448*Math.log(Stat_chol_total/Stat_chol_hdl))+(-.0474*Stat_CV_diabetes)+(-.2233*Stat_CV_diabetes*(1-Stat_CV_male))+(-.1237*Stat_CV_lvh)+(0*Stat_CV_lvh*Stat_CV_male)))))));
		
			var chd = parseFloat(chd);
			var stroke = parseFloat(stroke);
			var mi = parseFloat(mi);
			var framingham = parseFloat(framingham);
			var cvd_death = parseFloat(cvd_death);
			var assign = parseFloat(assign);
			var bnf = parseFloat(bnf);
			var chd_death = parseFloat(chd_death);

			$('#cvd_chd').val(chd);
			$('#cvd_chd_d').val(chd);
			$('#cvd_mi').val(mi);
			$('#cvd_mi_d').val(mi);
			$('#cvd_stroke').val(stroke);
			$('#cvd_stroke_d').val(stroke);
			$('#cvd_framingham').val(framingham);
			$('#cvd_framingham_d').val(framingham);
			$('#cvd_chd_death').val(chd_death);
			$('#cvd_chd_death_d').val(chd_death);
			$('#cvd_death').val(cvd_death);
			$('#cvd_death_d').val(cvd_death);
			$('#cvd_bnf').val(bnf);
			$('#cvd_bnf_d').val(bnf);
			$('#cvd_assign').val(assign);
			$('#cvd_assign_d').val(assign);
		});
	}

	/*function chart_temperature()
	{
		  var labels = [
			'January',
			'February',
			'March',
			'April',
			'May',
			'June',
		  ];

		  var data = {
			labels: labels,
			datasets: [{
			  label: 'My First dataset',
			  backgroundColor: 'rgb(255, 99, 132)',
			  borderColor: 'rgb(255, 99, 132)',
			  data: [0, 10, 5, 2, 20, 30, 45],
			}]
		  };

		  var config = {
			type: 'line',
			data: data,
			options: {}
		  };

		  var myChart = new Chart(
			$('#temperature_chart'),
			config
		  );
	}

	function chart_blood_pressure()
	{
		  const DATA_COUNT = 7;
		const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};

		const labels = Utils.months({count: 7});
		const data = {
		  labels: labels,
		  datasets: [
			{
			  label: 'Dataset 1',
			  data: Utils.numbers(NUMBER_CFG),
			  borderColor: Utils.CHART_COLORS.red,
			  backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
			  yAxisID: 'y',
			},
			{
			  label: 'Dataset 2',
			  data: Utils.numbers(NUMBER_CFG),
			  borderColor: Utils.CHART_COLORS.blue,
			  backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),
			  yAxisID: 'y1',
			}
		  ]
		};

		const config = {
		  type: 'line',
		  data: data,
		  options: {
			responsive: true,
			interaction: {
			  mode: 'index',
			  intersect: false,
			},
			stacked: false,
			plugins: {
			  title: {
				display: true,
				text: 'Chart.js Line Chart - Multi Axis'
			  }
			},
			scales: {
			  y: {
				type: 'linear',
				display: true,
				position: 'left',
			  },
			  y1: {
				type: 'linear',
				display: true,
				position: 'right',

				// grid line settings
				grid: {
				  drawOnChartArea: false, // only want the grid lines for one axis to show up
				},
			  },
			}
		  },
		};

		const actions = [
		  {
			name: 'Randomize',
			handler(chart) {
			  chart.data.datasets.forEach(dataset => {
				dataset.data = Utils.numbers({count: chart.data.labels.length, min: -100, max: 100});
			  });
			  chart.update();
			}
		  },
		];

		var myChart = new Chart(
			$('#bp_chart'),
			config
		  );
	}*/
