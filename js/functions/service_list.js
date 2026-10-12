$(document).ready(function()
{
	//SERVICE_SHEET
		go_to_service_sheet();
		save_service_attend();
		edit_service_attend();
		update_servcie_attend();
		view_current_service_attend();
		view_service_attend_history();
		set_service_price_and_amount();
		delete_service_attend();
});
	
	//SERVICES
	function go_to_service_sheet()
	{
		$(document).on('click','#nav_service',function()
		{
			window.location.href="/layout/attendance/service_sheet.php";
			$('#service_sheet_form').trigger('reset');
		}) 
	}

	function save_service_attend()
	{
		$(document).on('click','#service_sheet_save_btn',function(e){
			var service_id = $('#service_id').val();
			var service_date = $('#service_date').val();
			var service_sponsor = $('#service_sponsor').val();
			var patient_total_balance = $('#patient_total_balance').val();
			e.preventDefault();
			if (service_id > 0) 
			{
				if (service_date !="")
				{
					if (service_sponsor > 0) 
					{
						var service_doctor = $('#service_doctor').val();
						var service_qty = $('#service_qty').val();
						var service_gdrg = $('#service_gdrg').val();
						var service_price_cash = $('#service_price_cash').val();
						var service_price_prvt = $('#service_price_prvt').val();
						var service_price_nhis = $('#service_price_nhis').val();
						var service_amt_cash = $('#service_amt_cash').val();
						var service_amt_prvt = $('#service_amt_prvt').val();
						var service_amt_nhis = $('#service_amt_nhis').val();
						var service_comment = $('#service_comment').val();
						var attend_id = $('#session_attend_id').val();
						var patient_id = $('#session_patient_id').val();
						var prvt_led_id = $('#session_prvt_led_id').val();
						$.ajax({
								url:'/layout/attendance/service_save.php',
								method:'POST',
								data:{
									service_sponsor:service_sponsor,
									service_id:service_id,
									service_doctor:service_doctor,
									service_date:service_date,
									service_qty:service_qty,
									service_gdrg:service_gdrg,
									service_price_cash:service_price_cash,
									service_price_prvt:service_price_prvt,
									service_price_nhis:service_price_nhis,
									service_amt_cash:service_amt_cash,
									service_amt_prvt:service_amt_prvt,
									service_amt_nhis:service_amt_nhis,
									service_comment:service_comment,
									attend_id:attend_id,
									patient_id:patient_id,
									prvt_led_id:prvt_led_id,
									patient_total_balance:patient_total_balance
								},
								success:function(data)
								{
									$('#service_sheet_form').trigger('reset');
									window.location.href="/layout/attendance/service_sheet.php";
									//view_current_service_attend();
								}
							});
					} 
					else 
					{
						alert('Please select the Sponsor of service!');
					};
				} 
				else 
				{
					alert('Please enter the Date of service!');
				};
			} 
			else 
			{
				alert('Please select a service!');
			};
		});
	}

	function edit_service_attend()
	{
		$(document).on('click','#btn_edit_service_list',function(){

			var service_list_id = $(this).attr('data-id1');

				$.ajax({  
					 url:'/layout/attendance/service_edit.php',  
					 type:'POST',  
					 data:{service_list_id:service_list_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#service_list_id').val(res[0]);
						 $('#service_id').val(res[1]);
						 $('#service_id_old').val(res[1]);
						 $('#service_date').val(res[4]);
						$('#service_qty').val(res[5]);
						$('#service_gdrg').val(res[6]);
						$('#service_price_cash').val(res[7]);
						 $('#service_price_nhis').val(res[8]);
						 $('#service_price_prvt').val(res[9]);
						 $('#service_amt_cash').val(res[10]);
						$('#service_amt_nhis').val(res[11]);
						$('#service_amt_prvt').val(res[12]);
						$('#service_comment').val(res[13]);
						$('#service_doctor').val(res[14]);
						$('#service_sponsor').val(res[15]);
						$('#service_save_update').html('<button type="submit" id="service_sheet_update_btn" name="service_sheet_update_btn" class="btn btn-primary">Update</button>');
						$('#service_sheet_save_btn').hide();
					 }  
				});
		  }); 
	}

	function update_servcie_attend()
	{
		$(document).on('click','#service_sheet_update_btn',function(e){
			e.preventDefault();
			var service_id = $('#service_id').val();
			var service_date = $('#service_date').val();
			var service_sponsor = $('#service_sponsor').val();
			if (service_id > 0) 
				{
					if (service_date !=="") {
						if (service_sponsor > 0) {
							var service_id_old = $('#service_id_old').val();
							var service_list_id = $('#service_list_id').val();
							var service_doctor = $('#service_doctor').val();
							var service_qty = $('#service_qty').val();
							var service_gdrg = $('#service_gdrg').val();
							var service_price_cash = $('#service_price_cash').val();
							var service_price_prvt = $('#service_price_prvt').val();
							var service_price_nhis = $('#service_price_nhis').val();
							var service_amt_cash = $('#service_amt_cash').val();
							var service_amt_prvt = $('#service_amt_prvt').val();
							var service_amt_nhis = $('#service_amt_nhis').val();
							var service_comment = $('#service_comment').val();
							var attend_id = $('#session_attend_id').val();
							var patient_id = $('#session_patient_id').val();
							var prvt_led_id = $('#session_prvt_led_id').val();
							$.ajax({
								 url:'/layout/attendance/service_update.php',
								 method:'POST',
								 data:{
									service_sponsor:service_sponsor,
									 service_id:service_id,
									 service_list_id:service_list_id,
									 service_date:service_date,
									 service_doctor:service_doctor,
									 service_qty:service_qty,
									 service_gdrg:service_gdrg,
									 service_price_cash:service_price_cash,
									 service_price_prvt:service_price_prvt,
									 service_price_nhis:service_price_nhis,
									 service_amt_cash:service_amt_cash,
									 service_amt_prvt:service_amt_prvt,
									 service_amt_nhis:service_amt_nhis,
									 service_comment:service_comment,
									 attend_id:attend_id,
									 patient_id:patient_id,
									 prvt_led_id:prvt_led_id,
									 service_id_old:service_id_old
								 },
								 success:function(data)
									 {
										 $('#service_sheet_form').trigger('reset');
										 $('#service_save_update').html('<button type="submit" id="service_sheet_save_btn" name="service_sheet_save_btn" class="btn btn-primary">Save</button>');
										 view_current_service_attend();
									 }
								 });
						} 
						else 
						{
							alert('Please select the Sponsor of service!');
						};
					} 
					else 
					{
						alert('Please enter the Date of service!');
					};
				} 
				else 
				{
					alert('Please select diagnosis!');
				}
			
		});
	}

	function view_current_service_attend()
	{
			var attend_id = $('#session_attend_id').val();
			$.ajax({
				 url:'/layout/attendance/service_current_view.php',
				 method:'POST',
				 data:{
					 attend_id:attend_id
				 },
				 success:function(data)
					 {
						 $('#attend_service_sheet_table').html(data);
					 }
				 });
	}

	function view_service_attend_history()
	{
		$(document).on('click','#diagnosis_history_icon',function(){
			
			var patient_id = $('#session_patient_id').val();
			$.ajax(
			{
				url: '/layout/attendance/diagnosis_history_view.php',
				method: 'POST',
				data:{
						 patient_id:patient_id
					 },
				success: function(data)
				{
					$('#attend_diagnosis_history_table').html(data);
				}
			});
		});
	}

	function set_service_price_and_amount()
	{
		$(document).on('change keyup','#service_id,#service_sponsor,#service_qty',function(){
			var sponsor_id = $('#service_sponsor').val();
			var service_id = $('#service_id').val();
			var qty1 = $('#service_qty').val();
			var age = $('#session_age').val();
			if(qty1 != '' && qty1 > 0)
			{
				var qty = qty1;
			}
			else
			{
				var qty = 1;
			};
			$.ajax(
				{
					url: '/layout/attendance/service_price_set.php',
					method: 'POST',
					data:{
							 sponsor_id:sponsor_id,
							 service_id:service_id
						 },
					datatype: 'JSON',
					success: function(data)
					{
						var res = $.parseJSON(data);
						if (res[7] == 'cash')
						{
							$('#service_price_cash').val(res[0]);
							$('#service_price_prvt').val(0);
							$('#service_price_nhis').val(0);
							$('#service_amt_cash').val(res[0] * qty);
							$('#service_amt_prvt').val(0);
							$('#service_amt_nhis').val(0);
						}
						else if (res[7] == 'nhia') 
						{
							if(age <= 11)
							{
								$('#service_price_cash').val(res[4]);
								$('#service_price_prvt').val(0);
								$('#service_price_nhis').val(res[3]);
								$('#service_amt_cash').val(res[4] * qty);
								$('#service_amt_cash').val(res[0] * qty);
								$('#service_amt_prvt').val(0);
								$('#service_amt_nhis').val(res[3] * qty);
							}
							else
							{
								$('#service_price_cash').val(res[4]);
								$('#service_price_prvt').val(0);
								$('#service_price_nhis').val(res[2]);
								$('#service_amt_cash').val(res[4] * qty);
								$('#service_amt_prvt').val(0);
								$('#service_amt_nhis').val(res[2] * qty);
							}
						}
						else if (res[7] == 'nhia_na') 
						{
							$('#service_price_cash').val(res[0]);
							$('#service_price_prvt').val(0);
							$('#service_price_nhis').val(0);
							$('#service_amt_cash').val(res[0] * qty);
							$('#service_amt_prvt').val(0);
							$('#service_amt_nhis').val(0);
							//$('#service_sponsor').val(1);
						}
						else if (res[7] == 'private_list') 
						{
							$('#service_price_cash').val(res[6]);
							$('#service_price_prvt').val(res[5]);
							$('#service_price_nhis').val(0);
							$('#service_amt_cash').val(res[6] * qty);
							$('#service_amt_prvt').val(res[5] * qty);
							$('#service_amt_nhis').val(0);

							$('#service_price_cash').prop('hidden', true);
							$('#service_price_prvt').prop('hidden', false);
							$('#service_price_nhis').prop('hidden', true);
							$('#service_amt_cash').prop('hidden', true);
							$('#service_amt_prvt').prop('hidden', false);
							$('#service_amt_nhis').prop('hidden', true);
						}
						else if (res[7] == 'private_no_list') 
						{
							$('#service_price_cash').val(0);
							$('#service_price_prvt').val(res[0]);
							$('#service_price_nhis').val(0);
							$('#service_amt_cash').val(0);
							$('#service_amt_prvt').val(res[0] * qty);
							$('#service_amt_nhis').val(0);
						}
					}
				});
		});
	}

	function delete_service_attend()
	{
		$(document).on('click','#btn_delete_service_list',function(){
			var service_list_id = $(this).attr('data-id2');
			var attend_id = $('#session_attend_id').val();
			var currentRow=$(this).closest("tr");
			var service = currentRow.find("td:eq(1)").text();
			$('#service_delete_question').text('Are you sure you want to delete ' + service + '?');
			$('#service_delete_modal').modal('show');
			$(document).on('click','#service_delete_yes',function(){
				$.ajax({  
					 url:'/layout/attendance/service_attend_delete.php',  
					 type:'POST',  
					 data:{service_list_id:service_list_id,attend_id:attend_id},
					 success:function(){
						 $('#service_delete_modal').modal('hide');
						 view_current_service_attend();
					 }  
				});
			  });
			$(document).on('click','#service_delete_no',function(){
				$('#service_delete_modal').modal('hide');
			});
		});
	}