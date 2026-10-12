$(document).ready(function()
{
	//DENTAL
		go_to_dental_sheet();
		add_patient_hx();
		save_dental_hx();
		edit_dental_hx();
		update_dental_hx();
		add_extra_assessment();
		save_extra_assessment();
		edit_extra_assessment();
		update_extra_assessment();
		add_intra_assessment();
		save_intra_assessment();
		edit_intra_assessment();
		update_intra_assessment();
		tooth_tooltip();
		tooth_dialog();
		save_dental_chart_entry();
		update_dental_chart_entry();
});

	//DENTAL
	function go_to_dental_sheet()
	{
		$(document).on('click','#nav_dental',function()
		{
			window.location.href="/layout/attendance/dental_sheet.php";
			$('#surgery_attend_form').trigger('reset');
		}) 
	}

	function add_patient_hx()
	{
		$(document).on('click','#add_patient_hx_btn',function()
		{
			$('#patient_hx_update').hide();
			$('#patient_hx_save').show();
			$('#add_patient_hx_form').trigger('reset');
			$('#add_patient_hx_modal').modal('show');
		}) 
	}

	function save_dental_hx()
	{
		$(document).on('click','#patient_hx_save',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				 url:'/layout/attendance/dental_hx_save.php',
				 method:'POST',
				 data:$('#add_patient_hx_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				 success:function(data)
					 {
						 $('#add_patient_hx_form').trigger('reset');
						 $('#add_patient_hx_modal').modal('hide');
						 window.location.href="/layout/attendance/dental_sheet.php";
					 }
				 });
		});
	}

	function edit_dental_hx()
	{
		$(document).on('click','#edit_patient_hx_btn',function(){
			var dent_hx_id  = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/attendance/dental_hx_edit.php',
				 method:'POST',
				 data:{dent_hx_id:dent_hx_id},
				 datatype:'JSON',
				 success:function(data)
					 {
						 var res = $.parseJSON(data);
						 $('#phx_id').val(res[0]);
						 $('#phx1').val(res[3]);
						 $('#phx2').val(res[4]);
						 $('#phx3').val(res[5]);
						 $('#phx4').val(res[6]);
						 $('#phx5').val(res[7]);
						 $('#phx6').val(res[8]);
						 $('#phx7').val(res[9]);
						 $('#phx8').val(res[10]);
						 $('#phx9').val(res[11]);
						 $('#phx10').val(res[12]);
						 $('#phx11').val(res[13]);
						 $('#phx12').val(res[14]);
						 $('#phx13').val(res[15]);
						 $('#phx14').val(res[16]);
						 $('#phx15').val(res[17]);
						 $('#phx16').val(res[18]);
						 $('#phx17').val(res[19]);
						 $('#phx18').val(res[20]);
						 $('#phx19').val(res[21]);
						 $('#phx20').val(res[22]);
						 $('#phx21').val(res[23]);
						 $('#phx22').val(res[24]);
						 $('#phx23').val(res[25]);
						 $('#phx24').val(res[26]);
						 $('#phx25').val(res[27]);
						 $('#phx26').val(res[28]);
						 $('#phx27').val(res[29]);
						 $('#phx28').val(res[30]);
						 $('#phx29').val(res[31]);
						 $('#phx30').val(res[32]);
						 $('#phx31').val(res[33]);
						 $('#phx32').val(res[34]);
						 $('#phx33').val(res[35]);
						 $('#phx34').val(res[36]);
						 $('#phx35').val(res[37]);
						 $('#patient_hx_update').show();
						 $('#patient_hx_save').hide();
						 $('#add_patient_hx_modal_title').html('Edit Patient History');
						$('#add_patient_hx_modal').modal('show');
					 }
				 });
		});
	}

	function update_dental_hx()
	{
		$(document).on('click','#patient_hx_update',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				 url:'/layout/attendance/dental_hx_update.php',
				 method:'POST',
				 data:$('#add_patient_hx_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				 success:function(data)
					 {
						 $('#add_patient_hx_form').trigger('reset');
						 $('#add_patient_hx_modal').modal('hide');
						 window.location.href="/layout/attendance/dental_sheet.php";
					 }
				 });
		});
	}

	function add_extra_assessment()
	{
		$(document).on('click','#add_current_eo_assessment_btn',function()
		{
			$('#add_assess_update').hide();
			$('#add_assess_save').show();
			$('#add_assessment_form').trigger('reset');
			$('#add_assessment_modal').modal('show');
		}) 
	}

	function save_extra_assessment()
	{
		$(document).on('click','#add_assess_save',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				 url:'/layout/attendance/dental_extra_assess_save.php',
				 method:'POST',
				 data:$('#add_assessment_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				 success:function(data)
					 {
						 $('#add_assessment_form').trigger('reset');
						 $('#add_assessment_modal').modal('hide');
						 window.location.href="/layout/attendance/dental_sheet.php";
					 }
				 });
		});
	}

	function edit_extra_assessment()
	{
		$(document).on('click','#edit_current_eo_assessment_btn',function(){
			var dental_aeo_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/attendance/dental_extra_assess_edit.php',
				 method:'POST',
				 data:{dental_aeo_id:dental_aeo_id},
				 datatype:'JSON',
				 success:function(data)
					 {
						 var res = $.parseJSON(data);
						 $('#dental_aeo_id').val(res[0]);
						 $('#Facial_Type').val(res[3]);
						 $('#Profile_Type').val(res[4]);
						 $('#Lower_Facial_Height').val(res[5]);
						 $('#Transverse').val(res[6]);
						 $('#TMJ').val(res[7]);
						 $('#Lip_Competence').val(res[8]);
						 $('#Incisor_Show_at_Rest').val(res[9]);
						 $('#Incisor_Show_when_smiling').val(res[10]);
						 $('#Naso_Labial_Angle').val(res[11]);
						 $('#Labio_Mental_Fold').val(res[12]);
						 $('#Lip_To_E_Line').val(res[13]);
						 $('#Symmetry').val(res[14]);
						 $('#Scars').val(res[15]);
						 $('#Lesions').val(res[16]);
						 $('#Oral_Habit').val(res[17]);
						 $('#Others').val(res[18]);
						 $('#add_assess_update').show();
						 $('#add_assess_save').hide();
						 $('#add_assessment_modal_title').html('Edit Dental Assessment');
						$('#add_assessment_modal').modal('show');
					 }
				 });
		});
	}

	function update_extra_assessment()
	{
		$(document).on('click','#add_assess_update',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				 url:'/layout/attendance/dental_extra_assess_update.php',
				 method:'POST',
				 data:$('#add_assessment_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				 success:function(data)
					 {
						 $('#add_assessment_form').trigger('reset');
						 $('#add_assessment_modal').modal('hide');
						 window.location.href="/layout/attendance/dental_sheet.php";
					 }
				 });
		});
	}

	function add_intra_assessment()
	{
		$(document).on('click','#add_current_io_assessment_btn',function()
		{
			$('#assess_intra_update').hide();
			$('#assess_intra_save').show();
			$('#add_intra_assessment_form').trigger('reset');
			$('#add_intra_assessment_modal').modal('show');
		}) 
	}

	function save_intra_assessment()
	{
		$(document).on('click','#assess_intra_save',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				 url:'/layout/attendance/dental_intra_assess_save.php',
				 method:'POST',
				 data:$('#add_intra_assessment_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				 success:function(data)
					 {
						 $('#add_intra_assessment_form').trigger('reset');
						 $('#add_intra_assessment_modal').modal('hide');
						 window.location.href="/layout/attendance/dental_sheet.php";
					 }
				 });
		});
	}

	function edit_intra_assessment()
	{
		$(document).on('click','#edit_current_io_assessment_btn',function(){
			var dental_aio_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/attendance/dental_intra_assess_edit.php',
				 method:'POST',
				 data:{dental_aio_id:dental_aio_id},
				 datatype:'JSON',
				 success:function(data)
					 {
						 var res = $.parseJSON(data);
						 $('#dental_aio_id').val(res[0]);
						 $('#Tongue').val(res[3]);
						 $('#Gingiva').val(res[4]);
						 $('#Overjet').val(res[5]);
						 $('#Overbite_mm').val(res[6]);
						 $('#Overbite_perc').val(res[7]);
						 $('#Openbite').val(res[8]);
						 $('#Molar_Relation_R').val(res[9]);
						 $('#Molar_Relation_L').val(res[10]);
						 $('#Canine_Relation_R').val(res[11]);
						 $('#Canine_Relation_L').val(res[12]);
						 $('#Incisor_Relation').val(res[13]);
						 $('#Arches_U').val(res[14]);
						 $('#Arches_L').val(res[15]);
						 $('#Crossbites_Anterior').val(res[16]);
						 $('#Crossbites_Posterior').val(res[17]);
						 $('#Curve_of_Spee_R').val(res[18]);
						 $('#Curve_of_Spee_L').val(res[19]);
						 $('#Stage_of_Dentition').val(res[20]);
						 $('#Tooth_Size').val(res[21]);
						 $('#Centerlines').val(res[22]);
						 $('#Deviated_Remarks').val(res[23]);
						 $('#Tonsils').val(res[24]);
						 $('#Lesions').val(res[25]);
						 $('#Akerly_Type').val(res[26]);
						 $('#Symmetry').val(res[27]);
						 $('#Missing_Teeth').val(res[28]);
						 $('#Malformed_Teeth').val(res[29]);
						 $('#Calculus').val(res[30]);
						 $('#Other').val(res[31]);
						 $('#Rotations').val(res[32]);
						 $('#Crowding').val(res[33]);
						 $('#Spacing').val(res[34]);
						 $('#Impacted_Teeth').val(res[35]);
						 $('#Aesthetic').val(res[36]);
						 $('#Dental_nhis').val(res[37]);
						 $('#assess_intra_update').show();
						 $('#assess_intra_save').hide();
						 $('#add_intra_assessment_modal_title').html('Edit Intra Oral Assessment');
						$('#add_intra_assessment_modal').modal('show');
					 }
				 });
		});
	}

	function update_intra_assessment()
	{
		$(document).on('click','#assess_intra_update',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				 url:'/layout/attendance/dental_intra_assess_update.php',
				 method:'POST',
				 data:$('#add_intra_assessment_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				 success:function(data)
					 {
						 $('#add_intra_assessment_form').trigger('reset');
						 $('#add_intra_assessment_modal').modal('hide');
						 window.location.href="/layout/attendance/dental_sheet.php";
					 }
				 });
		});
	}

	function tooth_tooltip()
	{
		$(".tooth").hover(function() 
			{
				var tooth_id = $(this).attr('data-id');
				var patient_id = $('#session_patient_id').val();
				$.ajax({
					 url:'/layout/attendance/dental_tooth_tooltip.php',
					 method:'POST',
					 data:{tooth_id:tooth_id, patient_id:patient_id},
					 success:function(data)
						 {
							 $(".tooth").css('cursor','pointer').attr('title', data);
						 }
					});
			}, 
			function() {$(this).css('cursor','auto');}
		);
	}

	function tooth_dialog()
	{
		$(document).on('click','.tooth',function()
		{
			var tooth_id = $(this).attr('data-id');
			var patient_id = $('#session_patient_id').val();
			var attend_id = $('#session_attend_id').val();
			$.ajax({
				 url:'/layout/attendance/dental_tooth_enquiry.php',
				 method:'POST',
				 data:{tooth_id:tooth_id, patient_id:patient_id, attend_id:attend_id},
				 datatype:'JSON',
				 success:function(data)
					 {
						 var res = $.parseJSON(data);
						 if(res[0] == 'present' && res[1] == 'present')
							 {
								 $('#dialog_dental_chart_new_entry').hide();
								$('#dialog_dental_chart_view_entry').show();
								 $('#dialog_dental_chart_edit_entry').show();
								 $('#dialog_dental_chart_modal_title').html(tooth_id + ' Dental Chart Dialog');
								$('#dialog_question').html('Please click your option!');
								 $('#dialog_dental_chart_modal').modal('show');
							 }
						 else if(res[0] == 'present' && res[1] == 'none')
							 {
								 $('#dialog_dental_chart_new_entry').show();
								$('#dialog_dental_chart_view_entry').show();
								 $('#dialog_dental_chart_edit_entry').hide();
								 $('#dialog_dental_chart_modal_title').html(tooth_id + ' Dental Chart Dialog');
								$('#dialog_question').html('Please click your option!');
								 $('#dialog_dental_chart_modal').modal('show');
							 }
						 else if(res[0] == 'none' && res[1] == 'none')
							 {
								$('#add_dental_chart_modal_title').html(tooth_id +' Chart Entry');
								$('#tooth_id').val(tooth_id);
								$('#dental_chart_update_btn').hide();
								$('#dental_chart_save').show();
								$('#add_dental_chart_form').trigger('reset');
								$('#add_dental_chart_modal').modal('show');
							 }
						 else if(res[0] == 'none' && res[1] == 'present')
							 {
								 $('#dialog_dental_chart_new_entry').hide();
								 $('#dialog_dental_chart_view_entry').show();
								 $('#dialog_dental_chart_edit_entry').show();
								 $('#dialog_dental_chart_modal_title').html(tooth_id + ' Dental Chart Dialog');
								$('#dialog_question').html('Please click your option!');
								 $('#dialog_dental_chart_modal').modal('show');
							 }
						else if(res[0] == 'no_dental_creation' && res[1] == 'no_dental_editing')
							 {
								 $('#dialog_dental_chart_new_entry').hide();
								 $('#dialog_dental_chart_view_entry').show();
								 $('#dialog_dental_chart_edit_entry').hide();
								 $('#dialog_dental_chart_modal_title').html(tooth_id + ' Dental Chart Dialog');
								$('#dialog_question').html('Please click your option!');
								 $('#dialog_dental_chart_modal').modal('show');
							 }
						else if(res[0] == 'dental_creation' && res[1] == 'no_dental_editing')
							 {
								 $('#dialog_dental_chart_new_entry').show();
								 $('#dialog_dental_chart_view_entry').show();
								 $('#dialog_dental_chart_edit_entry').hide();
								 $('#dialog_dental_chart_modal_title').html(tooth_id + ' Dental Chart Dialog');
								$('#dialog_question').html('Please click your option!');
								 $('#dialog_dental_chart_modal').modal('show');
							 }
						else if(res[0] == 'no_dental_creation' && res[1] == 'dental_editing')
							 {
								 $('#dialog_dental_chart_new_entry').hide();
								 $('#dialog_dental_chart_view_entry').show();
								 $('#dialog_dental_chart_edit_entry').show();
								 $('#dialog_dental_chart_modal_title').html(tooth_id + ' Dental Chart Dialog');
								$('#dialog_question').html('Please click your option!');
								 $('#dialog_dental_chart_modal').modal('show');
							 };

						 $(document).on('click','#dialog_dental_chart_new_entry',function()
						{
							$('#dialog_dental_chart_modal').modal('hide');
							$('#add_dental_chart_modal_title').html(tooth_id +' Chart Entry');
							$('#tooth_id').val(tooth_id);
							$('#dental_chart_update_btn').hide();
							$('#dental_chart_save').show();
							$('#add_dental_chart_form').trigger('reset');
							$('#add_dental_chart_modal').modal('show');
						});

						$(document).on('click','#dialog_dental_chart_edit_entry',function()
						{
							$.ajax({
								 url:'/layout/attendance/dental_chart_edit.php',
								 method:'POST',
								 data:{tooth_id:tooth_id, patient_id:patient_id, attend_id:attend_id},
								 datatype:'JSON',
								 success:function(data)
									 {
										 var res = $.parseJSON(data);
										 $('#dental_chart_id').val(res[0]);
										 $('#tooth_id').val(res[3]);
										 $('#chart_date').val(res[4]);
										 $('#chart_remark').val(res[5]);
										 $('#dental_chart_update_btn').show();
										 $('#dental_chart_save').hide();
										 $('#add_dental_chart_modal_title').html('Edit '+ tooth_id + ' Dental Chart Dialog');
										 $('#dialog_dental_chart_modal').modal('hide');
										$('#add_dental_chart_modal').modal('show');
									 }
							});
						});

						$(document).on('click','#dialog_dental_chart_view_entry',function()
						{
							$.ajax({
								 url:'/layout/attendance/dental_chart_view.php',
								 method:'POST',
								 data:{tooth_id:tooth_id, patient_id:patient_id},
								 datatype:'JSON',
								 success:function(data)
									 {

										 $('#add_dental_chart_modal_title').html('Display '+ tooth_id + ' Dental Chart Dialog');
										 $('#dental_chart_modal_div').html(data);
										 $('#dental_chart_save').hide();
										 $('#dental_chart_update_btn').hide();
										 $('#dialog_dental_chart_modal').modal('hide');
										 $('#dental_chart_cancel').show();
										$('#add_dental_chart_modal').modal('show');
									 }
							});
						});
					 }
				});
		}) 
	}

	function save_dental_chart_entry()
	{
		$(document).on('click','#dental_chart_save',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var date_admit = $('#session_dateofadmission_attd').val();
			var tooth_id = $('#tooth_id').val();
			var date = $('#chart_date').val();
			var remarks = $('#chart_remark').val();
			if(date !== '')
			{
				if(date == date_admit)
				{
					if(remarks !== '')
					{
						$.ajax({
							 url:'/layout/attendance/dental_chart_save.php',
							 method:'POST',
							 data:$('#add_dental_chart_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
							 success:function(data)
								 {
									 $('#add_dental_chart_form').trigger('reset');
									 $('#add_dental_chart_modal').modal('hide');
									 window.location.href="/layout/attendance/dental_sheet.php";
								 }
							 });
					}
					else
					{
						alert('Please type the remarks for tooth' +tooth_id+ '!');
					}
				}
				else
				{
					alert('Please the entry date cannot be earlier than or later than the admission date!');
				}
			}
			else
			{
				alert('Please select the date of entry!');
			}
		});
	}

	function update_dental_chart_entry()
	{
		$(document).on('click','#dental_chart_update_btn',function(e)
		{
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var date_admit = $('#session_dateofadmission_attd').val();
			var tooth_id = $('#tooth_id').val();
			var date = $('#chart_date').val();
			var remarks = $('#chart_remark').val();
			var dental_chart_id = $('#dental_chart_id').val();
			if(date !== '')
			{
				if(date == date_admit)
				{
					if(remarks !== '')
					{
						$.ajax({
							 url:'/layout/attendance/dental_chart_update.php',
							 method:'POST',
							 data:$('#add_dental_chart_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
							 success:function(data)
								 {
									$('#add_dental_chart_form').trigger('reset');
									 $('#add_dental_chart_modal').modal('hide');
									 window.location.href="/layout/attendance/dental_sheet.php";
								 }
							 });
					}
					else
					{
						alert('Please type the remarks for tooth' +tooth_id+ '!');
					}
				}
				else
				{
					alert('Please the entry date cannot be earlier than or later than the admission date!');
				}
			}
			else
			{
				alert('Please select the date of entry!');
			}
		})
	}