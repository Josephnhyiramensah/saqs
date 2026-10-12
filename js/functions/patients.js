$(document).ready(function()
{
	//PATIENT
		age();
		set_nhis_regional_code();
		save_patient();
		edit_patient();
		cancel_patient_setup();
		update_patient();
		search_patient();
		delete_patient();
		//load_data();
});

	//PATIENT SETUP
	function set_nhis_regional_code()
	{
		$(document).on('change keyup','#sn_scheme_code,#sn_member',function(){

			var scheme_code = $('#sn_scheme_code').val();
			var sn_member = $('#sn_member').val();
				$.ajax({  
					 url:'/layout/patients/set_nhis_regional_code.php',  
					 type:'POST',  
					 data:{scheme_code:scheme_code},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#sn_regional_code').val(res[0]);
						 $('#sn_regional_code_2').val(res[0]);
						 $('#scheme_name').val(res[1]);
						 $('#scheme_id').val(res[2]);
						 $('#serial_no').val(res[0]+scheme_code+sn_member);
						 $('#serial_no_2').val(res[0]+scheme_code+sn_member);
					 }  
				});
		  }); 
	}

	function save_patient()
	{
		$(document).on('click','#patient_save_btn',function(){
			//var patient_id = $('#patient_id').val(); 
			var firstName = $('#firstName').val();
			var folderNo = $('#folderNo').val();
			var DOB = $('#DOB').val();
			var gender = $('#gender').val();
			if(folderNo =="")
			{
				$('#patient_attend_dialogue_question').text('The folder number field is required');
				$('#pad_yes').hide();
				$('#patient_attend_dialogue_modal_title').text('Folder No EMPTY');
				$('#pad_no').text('OK');
				$('#patient_attend_dialogue_modal').modal('show');
				$(document).on('click','#pad_no',function(){
					$('#patient_attend_dialogue_modal').modal('hide');
				});
			}
			else
			{
				if (firstName =="") 
				{
					$('#patient_attend_dialogue_question').text('First Name field is required');
					$('#pad_yes').hide();
					$('#patient_attend_dialogue_modal_title').text('Name EMPTY');
					$('#pad_no').text('OK');
					$('#patient_attend_dialogue_modal').modal('show');
					$(document).on('click','#pad_no',function(){
						$('#patient_attend_dialogue_modal').modal('hide');
					});
				} 
				else 
				{
					if (DOB =="") 
					{
						$('#patient_attend_dialogue_question').text('Date Of Birth field is required');
						$('#pad_yes').hide();
						$('#patient_attend_dialogue_modal_title').text('Date of birth EMPTY');
						$('#pad_no').text('OK');
						$('#patient_attend_dialogue_modal').modal('show');
						$(document).on('click','#pad_no',function(){
							$('#patient_attend_dialogue_modal').modal('hide');
						});
					} 
					else 
					{
						if (gender <= 0) 
						{
							$('#patient_attend_dialogue_question').text('The gender field is required');
							$('#pad_yes').hide();
							$('#patient_attend_dialogue_modal_title').text('Gender EMPTY');
							$('#pad_no').text('OK');
							$('#patient_attend_dialogue_modal').modal('show');
							$(document).on('click','#pad_no',function(){
								$('#patient_attend_dialogue_modal').modal('hide');
							});
						} 
						else 
						{
							$.ajax({  
								url:'/layout/patients/patient_save.php',
								method:'POST',
								data:$('#patient_create_form').serialize(),
								datatype:'JSON',
								success:function(data)
								{
									var res = $.parseJSON(data);
									var patient_id = res[0];
									$.ajax({  
										url:'/layout/attendance/attend_new.php',  
										type:'POST',  
										data:{patient_id:patient_id},
										success:function(data)
										{
											window.location.href="/layout/attendance/attendance_new.php";
										}
									 });
								}
							});
						};
					};
				};
			};
		}); 
	}

	function cancel_patient_setup()
	{
		$(document).on('click','#patient_cancel_btn',function(){
			$('#patient_create_form').trigger('reset');
			window.location.href="/layout/patients/patient_list.php";
		  }); 
	}

	function edit_patient()
	{
		$(document).on('click','#btn_edit_patient',function(){

			var patient_id = $(this).attr('data-id1');
				$.ajax({  
					 url:'/layout/patients/patient_edit.php',  
					 type:'POST',  
					 data:{patient_id:patient_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#patient_id').val(res[0]);
						 $('#folderNo').val(res[1]);
						 $('#firstName').val(res[2]);
						 $('#lastName').val(res[3]);
						 $('#DOB').val(res[4]);
						 $('#gender').val(res[5]);
						 $('#marital_status').val(res[6]);
						 $('#address').val(res[7]);
						 $('#city').val(res[8]);
						 $('#telephone').val(res[9]);
						 $('#email').val(res[10]);
						 $('#Allergies').val(res[11]);
						 $('#MedicalHistory').val(res[12]);
						 $('#FamilyHistory').val(res[13]);
						 $('#BloodGroup').val(res[14]);
						 $('#G6PD').val(res[15]);
						 $('#PreviousBirths').val(res[16]);
						 $('#PreviousAbortions').val(res[17]);
						 $('#relname').val(res[18]);
						 $('#rellocation').val(res[19]);
						 $('#reltelephone').val(res[20]);
						 $('#Schname').val(res[21]);
						 $('#nhismemberno').val(res[22]);
						 $('#nhisexpirydate').val(res[23]);
						 $('#prtinsname').val(res[24]);
						 $('#prtmemberno').val(res[25]);
						 $('#prtexpirydate').val(res[26]);
						 $('#ghanacard').val(res[27]);
						 $('#sn_scheme_code').val(res[28]);
						 $('#sn_member').val(res[29]);
						 $('#sn_regional_code').val(res[30]);
						 $('#sn_regional_code_2').val(res[30]);
						 $('#serial_no').val(res[31]);
						 $('#serial_no_2').val(res[31]);
						 $('#scheme_id').val(res[32]);
						 $('#scheme_name').val(res[33]);
						 $('#patient_save_update').html('<button type="submit" name="patient_update_btn" id="patient_update_btn" class="btn btn-primary">Update</button>');
						 $('#patient_save_btn').hide();
						 $('#patient_create_form_title').text('Patient Edit');
						 $('#patient_edit_modal').modal('show');
					 }  
				});
		  }); 
	}

	function update_patient()
	{
		$(document).on('click','#patient_update_btn',function(){
			//var patient_id = $('#patient_id').val(); 
			var firstName = $('#firstName').val();
			var folderNo = $('#folderNo').val();
			var DOB = $('#DOB').val();
			var gender = $('#gender').val();
			var today = new Date();
			if(folderNo =="")
			{
				$('#patient_attend_dialogue_question').text('The folder number field is required');
				$('#pad_yes').hide();
				$('#patient_attend_dialogue_modal_title').text('Folder No EMPTY');
				$('#pad_no').text('OK');
				$('#patient_attend_dialogue_modal').modal('show');
				$(document).on('click','#pad_no',function(){
					$('#patient_attend_dialogue_modal').modal('hide');
				});
			}
			else
			{
				if (firstName =="") 
				{
					$('#patient_attend_dialogue_question').text('First Name field is required');
					$('#pad_yes').hide();
					$('#patient_attend_dialogue_modal_title').text('Name EMPTY');
					$('#pad_no').text('OK');
					$('#patient_attend_dialogue_modal').modal('show');
					$(document).on('click','#pad_no',function(){
						$('#patient_attend_dialogue_modal').modal('hide');
					});
				} 
				else 
				{
					if (DOB =="") 
					{
						$('#patient_attend_dialogue_question').text('Date Of Birth field is required');
						$('#pad_yes').hide();
						$('#patient_attend_dialogue_modal_title').text('Date of birth EMPTY');
						$('#pad_no').text('OK');
						$('#patient_attend_dialogue_modal').modal('show');
						$(document).on('click','#pad_no',function(){
							$('#patient_attend_dialogue_modal').modal('hide');
						});
					} 
					else 
					{
						if (gender <= 0) 
						{
							$('#patient_attend_dialogue_question').text('The gender field is required');
							$('#pad_yes').hide();
							$('#patient_attend_dialogue_modal_title').text('Gender EMPTY');
							$('#pad_no').text('OK');
							$('#patient_attend_dialogue_modal').modal('show');
							$(document).on('click','#pad_no',function(){
								$('#patient_attend_dialogue_modal').modal('hide');
							});
						} 
						else 
						{
							$.ajax({  
								url:'/layout/patients/patient_update.php',
								method:'POST',
								data:$('#patient_create_form').serialize(),
								success:function(data)
								{
									$('#patient_edit_modal').modal('hide');
									window.location.href="/layout/patients/patient_list.php";
								}  
							});

						};
					};
				};
			};
		}); 
	}

	function search_patient()
	{
		$(document).on('keyup','#search_patient',function()
		{
			var search = $(this).val();
			  if(search != '')
			  {
					  load_data(search);
			  }
			  else
			  {
					  load_data();
			  }
		}); 
	}

	function load_data(query)
	{
		$.ajax({
		   url:"/layout/patients/patient_search.php",
		   method:"POST",
		   data:{query:query},
		   success:function(data)
		   {
				$('#patient-table').html(data);
		   }
		});
	}

	function age()
	{
		$(document).on('change','#DOB',function()
		{
			var dob = $('#DOB').val();
			if(dob != ''){
				var str=dob.split('-');    
				var firstdate=new Date(str[0],str[1],str[2]);
				var today = new Date();        
				var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
				var age = parseInt(dayDiff);
				$('#age').val(age);
			}
		}); 
	}

	function edit_patient_allergies()
	{
		$(document).on('click','#allergies_patient_id',function(){

			var patient_id = $(this).attr('data-id');

				$.ajax({  
					 url:'/layout/patients/patient_allergies_edit.php',  
					 type:'POST',  
					 data:{patient_id:patient_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#allergies').val(res[0]);
						$('#allergies_save_btn').hide();
						$('#allergies_update_btn').show();
						$('#patient_allergies_modal').modal('show');
					}  
				});
		  }); 
	}

	function update_patient_allergies()
	{
		$(document).on('click','#allergies_update_btn',function(e){
			e.preventDefault();
			var allergies = $('#allergies').val();
			if (allergies !== "")
			{
				$.ajax({
					url:'/layout/patients/patient_allergies_update.php',
					method:'POST',
					data:{
					allergies:allergies
					},
					success:function(data)
					{
						$('#patient_allergies_modal').modal('hide');
						location.reload();
					}
				});
			}
			else
			{
				alert('Please the Allergies cannot be EMPTY!');
			};
		});
	}
	
	function delete_patient()
	{
		$(document).on('click','#btn_delete_patient',function()
		{
			var patient_id = $(this).attr('data-id');
			var name = $(this).attr('data-id1');
			$('#item_delete_question').text('Are you sure you want to delete ' + name + '?');
			$('#item_delete_modal').modal('show');
			$(document).on('click','#item_delete_yes',function()
			{
				$.ajax({  
					url:'/layout/patients/patient_delete.php',  
					type:'POST',  
					data:{patient_id:patient_id},
					success:function(data)
					{
						$('#item_delete_modal').modal('hide');
						if(data == 'used')
						{
							alert('Please, '+ name +' has been used in an attendance sheet, deletion is therefore declined!')
						}
						else if(data == 'deleted')
						{
							window.location.href="/layout/patients/patient_list.php";
						};
					}
				});
			});
			$(document).on('click','#item_delete_no',function()
			{
				$('#item_delete_modal').modal('hide');
			});
		});
	}