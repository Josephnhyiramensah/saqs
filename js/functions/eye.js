$(document).ready(function()
{
	//EYE
		go_to_eye_sheet();
		add_eye_visual_acuity();
		save_eye_visual_acuity();
		edit_eye_visual_acuity();
		update_eye_visual_acuity();
		add_eye_ocular_exam();
		save_eye_ocular_exam();
		edit_eye_ocular_exam();
		update_eye_ocular_exam();
		add_eye_refraction();
		save_eye_refraction();
		edit_eye_refraction();
		update_eye_refraction();
		add_eye_lens();
		save_eye_lens();
		edit_eye_lens();
		update_eye_lens();
});

	//EYE
	function go_to_eye_sheet()
	{
		$(document).on('click','#nav_eye',function()
		{
			window.location.href="/layout/attendance/eye_sheet.php";
		}) 
	}

	function add_eye_visual_acuity()
	{
		$(document).on('click','#add_eye_visual_acuity_btn',function()
		{
			$('#eye_visual_acuity_update').hide();
			$('#eye_visual_acuity_save').show();
			$('#add_eye_visual_acuity_form').trigger('reset');
			$('#add_eye_visual_acuity_modal').modal('show');
		}) 
	}

	function save_eye_visual_acuity()
	{
		$(document).on('click','#eye_visual_acuity_save',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				 url:'/layout/attendance/eye_visual_acuity_save.php',
				 method:'POST',
				 data:$('#add_eye_visual_acuity_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				 success:function(data)
					 {
						 $('#add_eye_visual_acuity_form').trigger('reset');
						 $('#add_eye_visual_acuity_modal').modal('hide');
						 window.location.href="/layout/attendance/eye_sheet.php";
					 }
				 });
		});
	}

	function edit_eye_visual_acuity()
	{
		$(document).on('click','#edit_eye_visual_acuity_btn',function(){
			var eye_va_id  = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/attendance/eye_visual_acuity_edit.php',
				 method:'POST',
				 data:{eye_va_id:eye_va_id},
				 datatype:'JSON',
				 success:function(data)
				 {
					 var res = $.parseJSON(data);
					 $('#eye_visual_acuity_id').val(res[0]);
					 $('#eye_visual_acuity_unaided_right').val(res[1]);
					 $('#eye_visual_acuity_unaided_left').val(res[2]);
					 $('#eye_visual_acuity_pinhole_right').val(res[3]);
					 $('#eye_visual_acuity_pinhole_left').val(res[4]);
					 $('#eye_visual_acuity_aided_right').val(res[5]);
					 $('#eye_visual_acuity_aided_left').val(res[6]);
					 $('#eye_visual_acuity_iop_right').val(res[7]);
					 $('#eye_visual_acuity_iop_left').val(res[8]);
					 $('#eye_visual_acuity_remarks').val(res[9]);
					 $('#eye_visual_acuity_update').show();
					 $('#eye_visual_acuity_save').hide();
					 $('#add_eye_visual_acuity_modal_title').html('Edit Eye Visual Acuity');
					$('#add_eye_visual_acuity_modal').modal('show');
				 }
			 });
		});
	}

	function update_eye_visual_acuity()
	{
		$(document).on('click','#eye_visual_acuity_update',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				 url:'/layout/attendance/eye_visual_acuity_update.php',
				 method:'POST',
				 data:$('#add_eye_visual_acuity_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				 success:function(data)
					 {
						 $('#add_eye_visual_acuity_form').trigger('reset');
						 $('#add_eye_visual_acuity_modal').modal('hide');
						 window.location.href="/layout/attendance/eye_sheet.php";
					 }
				 });
		});
	}

	function add_eye_ocular_exam()
	{
		$(document).on('click','#add_eye_ocular_exam_btn',function()
		{
			$('#eoe_update').hide();
			$('#eoe_save').show();
			$('#add_eye_ocular_examamination_form').trigger('reset');
			$('#add_eye_ocular_examamination_modal').modal('show');
		}) 
	}

	function save_eye_ocular_exam()
	{
		$(document).on('click','#eoe_save',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				url:'/layout/attendance/eye_ocular_exam_save.php',
				method:'POST',
				data:$('#add_eye_ocular_examamination_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				success:function(data)
				{
					$('#add_eye_ocular_examamination_form').trigger('reset');
					$('#add_eye_ocular_examamination_modal').modal('hide');
					window.location.href="/layout/attendance/eye_sheet.php";
				}
			});
		});
	}

	function edit_eye_ocular_exam()
	{
		$(document).on('click','#edit_eye_ocular_exam_btn',function(){
			var eye_oe_id = $(this).attr('data-id');
			$.ajax({
				url:'/layout/attendance/eye_ocular_exam_edit.php',
				method:'POST',
				data:{eye_oe_id:eye_oe_id},
				datatype:'JSON',
				success:function(data)
				{
					var res = $.parseJSON(data);
					$('#eye_ocular_examamination_id').val(res[0]);
					$('#eoe_lid_left').val(res[1]);
					$('#eoe_lid_right').val(res[2]);
					$('#eoe_lid_remarks').val(res[3]);
					$('#eoe_conjunctiva_left').val(res[4]);
					$('#eoe_conjunctiva_right').val(res[5]);
					$('#eoe_conjunctiva_remarks').val(res[6]);
					$('#eoe_cornea_left').val(res[7]);
					$('#eoe_cornea_right').val(res[8]);
					$('#eoe_cornea_remarks').val(res[9]);
					$('#eoe_ac_left').val(res[10]);
					$('#eoe_ac_right').val(res[11]);
					$('#eoe_ac_remarks').val(res[12]);
					$('#eoe_pupil_left').val(res[13]);
					$('#eoe_pupil_right').val(res[14]);
					$('#eoe_pupil_remarks').val(res[15]);
					$('#eoe_lens_left').val(res[16]);
					$('#eoe_lens_right').val(res[17]);
					$('#eoe_lens_remarks').val(res[18]);
					$('#eoe_vitreous_left').val(res[19]);
					$('#eoe_vitreous_right').val(res[20]);
					$('#eoe_vitreous_remarks').val(res[21]);
					$('#eoe_fundus_left').val(res[22]);
					$('#eoe_fundus_right').val(res[23]);
					$('#eoe_fundus_remarks').val(res[24]);
					$('#eoe_vc_d_left').val(res[25]);
					$('#eoe_vc_d_right').val(res[26]);
					$('#eoe_vc_d_remarks').val(res[27]);
					$('#eoe_iop_left').val(res[28]);
					$('#eoe_iop_right').val(res[29]);
					$('#eoe_iop_remarks').val(res[30]);
					$('#eoe_visual_field_result').val(res[31]);
					$('#eoe_update').show();
					$('#eoe_save').hide();
					$('#add_eye_ocular_examamination_modal_title').html('Edit Eye Ocular Examination');
					$('#add_eye_ocular_examamination_modal').modal('show');
				}
			});
		});
	}

	function update_eye_ocular_exam()
	{
		$(document).on('click','#eoe_update',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				url:'/layout/attendance/eye_ocular_exam_update.php',
				method:'POST',
				data:$('#add_eye_ocular_examamination_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				success:function(data)
				{
					$('#add_eye_ocular_examamination_form').trigger('reset');
					$('#add_eye_ocular_examamination_modal').modal('hide');
					window.location.href="/layout/attendance/eye_sheet.php";
				}
			});
		});
	}

	function add_eye_refraction()
	{
		$(document).on('click','#add_eyerefraction_btn',function()
		{
			$('#eye_refraction_update').hide();
			$('#eye_refraction_save').show();
			$('#add_eye_refraction_form').trigger('reset');
			$('#add_eye_refraction_modal').modal('show');
		}) 
	}

	function save_eye_refraction()
	{
		$(document).on('click','#eye_refraction_save',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				 url:'/layout/attendance/eye_refraction_save.php',
				 method:'POST',
				 data:$('#add_eye_refraction_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				 success:function(data)
					 {
						 $('#add_eye_refraction_form').trigger('reset');
						 $('#add_eye_refraction_modal').modal('hide');
						 window.location.href="/layout/attendance/eye_sheet.php";
					 }
				 });
		});
	}

	function edit_eye_refraction()
	{
		$(document).on('click','#edit_eye_refraction_btn',function(){
			var eye_ref_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/attendance/eye_refraction_edit.php',
				 method:'POST',
				 data:{eye_ref_id:eye_ref_id},
				 datatype:'JSON',
				 success:function(data)
					 {
						 var res = $.parseJSON(data);
						 $('#eye_refraction_id').val(res[0]);
						 $('#eye_refraction_sph_left').val(res[1]);
						 $('#eye_refraction_sph_right').val(res[2]);
						 $('#eye_refraction_cyl_left').val(res[3]);
						 $('#eye_refraction_cyl_right').val(res[4]);
						 $('#eye_refraction_axis_left').val(res[5]);
						 $('#eye_refraction_axis_right').val(res[6]);
						 $('#eye_refraction_add_left').val(res[7]);
						 $('#eye_refraction_add_right').val(res[8]);
						 $('#eye_refraction_hgt_left').val(res[9]);
						 $('#eye_refraction_hgt_right').val(res[10]);
						 $('#eye_refraction_pd_left').val(res[11]);
						 $('#eye_refraction_pd_right').val(res[12]);
						 $('#eye_refraction_remarks').val(res[13]);
						 $('#eye_refraction_update').show();
						 $('#eye_refraction_save').hide();
						 $('#add_eye_refraction_modal_title').html('Edit Eye Refraction');
						$('#add_eye_refraction_modal').modal('show');
					 }
				 });
		});
	}

	function update_eye_refraction()
	{
		$(document).on('click','#assess_intra_update',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				 url:'/layout/attendance/eye_refraction_update.php',
				 method:'POST',
				 data:$('#add_intra_assessment_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				 success:function(data)
					 {
						 $('#add_intra_assessment_form').trigger('reset');
						 $('#add_intra_assessment_modal').modal('hide');
						 window.location.href="/layout/attendance/eye_sheet.php";
					 }
				 });
		});
	}

	function add_eye_lens()
	{
		$(document).on('click','#add_eye_lens_btn',function()
		{
			$('#eld_update').hide();
			$('#eld_save').show();
			$('#add_eye_lens_details_modal_form').trigger('reset');
			$('#add_eye_lens_details_modal').modal('show');
		}) 
	}

	function save_eye_lens()
	{
		$(document).on('click','#eld_save',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				url:'/layout/attendance/eye_lens_save.php',
				method:'POST',
				data:$('#add_eye_lens_details_modal_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				success:function(data)
				{
					$('#add_eye_lens_details_modal_form').trigger('reset');
					$('#add_eye_lens_details_modal').modal('hide');
					window.location.href="/layout/attendance/eye_sheet.php";
				}
			});
		});
	}

	function edit_eye_lens()
	{
		$(document).on('click','#edit_eye_lens_btn',function(){
			var eye_lens_id = $(this).attr('data-id');
			$.ajax({
				url:'/layout/attendance/eye_lens_edit.php',
				method:'POST',
				data:{eye_lens_id:eye_lens_id},
				datatype:'JSON',
				success:function(data)
				{
					var res = $.parseJSON(data);
					var lens_others_list_db = res[5];
					var temp = lens_others_list_db.split(',');
					for(i = 0; i < temp.length; i++)
					{
						$('input[name="lens_others[]"][value="'+temp[i]+'"]').prop('checked', true);
					};
					$('#eye_lens_details_id').val(res[0]);
					$('#eld_lens_type').val(res[1]);
					$('#eld_lens_material').val(res[2]);
					$('#eld_lens_index').val(res[3]);
					$('#eld_lens_frame_type').val(res[4]);
					$('#eld_remarks').val(res[6]);
					$('#eld_update').show();
					$('#eld_save').hide();
					$('#add_eye_lens_details_modal_title').html('Edit Eye Lens');
					$('#add_eye_lens_details_modal').modal('show');
				}
			});
		});
	}

	function update_eye_lens()
	{
		$(document).on('click','#eld_update',function(e){
			e.preventDefault();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			$.ajax({
				url:'/layout/attendance/eye_lens_update.php',
				method:'POST',
				data:$('#add_eye_lens_details_modal_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
				success:function(data)
				{
					$('#add_eye_lens_details_modal_form').trigger('reset');
					$('#add_eye_lens_details_modal').modal('hide');
					window.location.href="/layout/attendance/eye_sheet.php";
				}
			});
		});
	}