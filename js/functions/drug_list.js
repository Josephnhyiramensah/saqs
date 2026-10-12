$(document).ready(function()
{
	//DRUGS
		go_to_drug_sheet();
		select_drug_to_prescribe();
		select_attend_drug_from_history();
		save_attend_drug();
		enter_composite_drug_attend();
		edit_drug_attend();
		drug_edit_prescription_qty();
		update_drug_attend();
		drug_bill_status();
		view_current_drugs();
		view_drug_history();
		dispense_drug_modal();
		dispense_drug_modal_cancel();
		select_substitute_drug_to_dispense();
		change_drug_price_and_amount();
		set_drug_price_and_amount();
		drug_price_and_amount();
		dispense_drug_attend();
		drug_dispensed_delete();
		drug_patient_returns_new();
		get_drug_patient_return_amount();
		drug_patient_returns_view();
		drug_patient_returns_save();
		drug_patient_returns_edit();
		drug_patient_returns_update();
		admin_drug_modal();
		admin_drug_save()
		admin_drug_view();
		admin_drug_delete();
		drug_prescription_modal();
		drug_admin_chart_modal();
		drug_mur_modal();
		drug_mur_no_entry();
		drug_mur_save();
		drug_label_modal();
		drug_label_auto_search();
		drug_label_fill();
		drug_label_save();
		drug_attend_delete();
		search_drug_list_modal();
		search_drug_list_attend();
		search_drug_list_save();
});

	//DRUGS
	function go_to_drug_sheet()
	{
		$(document).on('click','#nav_drugs',function()
		{
			window.location.href="/layout/attendance/drugs_sheet.php";
			$('#drug_attend_form').trigger('reset');
		}) 
	}

	function select_drug()
	{
		var drug_id_pr = $('#drug').val();
		var drug_id_dp = $('#drug_id_dp').val();
		if(drug_id_pr > 0 && drug_id_dp > 0)
		{
			var drug_id = $('#drug_id_dp').val();
		}
		else if(drug_id_pr > 0 && drug_id_dp <= 0)
		{
			var drug_id = $('#drug').val();
		}
		else if(drug_id_pr <= 0 && drug_id_dp > 0)
		{
			var drug_id = $('#drug_id_dp').val();
		}
		else if(drug_id_pr <= 0 && drug_id_dp <= 0)
		{
			var drug_id = 0
		};

		$.ajax({
			 url:'/layout/attendance/drugs_select.php',
			 method:'POST',
			 datatype:'JSON',
			 data:{
				 drug_id:drug_id
			 },
			 success:function(data)
				 {
					 var res = $.parseJSON(data);
				 }
			 });
	}

	function select_drug_to_prescribe()
	{
		$(document).on('change','#drug',function(){
			var drug_id = $('#drug').val();
			var today = new Date();
			today = moment(today).format("YYYY-MM-DD");
			$.ajax({
			 url:'/layout/attendance/drugs_select.php',
			 method:'POST',
			 datatype:'JSON',
			 data:{
				 drug_id:drug_id
			 },
			 success:function(data)
				 {
					 var res = $.parseJSON(data);
					 $('#drug_gender').val(res[0]);
					 $('#drug_age_from').val(res[1]);
					 $('#drug_age_to').val(res[2]);
					$('#drug_date').val(today);
				 }
			 });
		});
	}

	function select_attend_drug_from_history()
	{
		$(document).on('click','#btn_drug_ht_list',function(){
			var drug_id = $(this).attr('data-id');
			var qty_presc = $(this).attr('data-id1');
			var dosage = $(this).attr('data-id2');
			$.ajax({
				 url:'/layout/attendance/drugs_select_from_history.php',
				 method:'POST',
				 datatype:'JSON',
				 data:{
					 drug_id:drug_id
				 },
				 success:function(data)
					 {
						 var res = $.parseJSON(data);
						 $('#drug_gender').val(res[0]);
						 $('#drug_age_from').val(res[1]);
						 $('#drug_age_to').val(res[2]);
						 $('#drug_date').val(res[3]);
						 $('#drug').val(drug_id);
						 $('#qty_presc').val(qty_presc);
						 $('#dosage').val(dosage);
						 drug_price_and_amount();
					 }
				 });
				
			
		});
	}

	function save_attend_drug()
	{
		$(document).on('click','#drug_sheet_save_btn',function(e){
			e.preventDefault();
			var drug = $('#drug').val();
			var gender = $('#session_gender').val();
			var age = parseInt($('#session_age').val());
			var drug_gender = $('#drug_gender').val();
			var drug_age_from = parseInt($('#drug_age_from').val());
			var drug_age_to = parseInt($('#drug_age_to').val());
			var dosage = $('#dosage').val();
			var qty_presc = $('#qty_presc').val();
			var drug_sponsor = $('#drug_sponsor').val();
			var drug_price_est = $('#drug_price_est').val();
			var drug_amt_est = $('#drug_amt_est').val();
			var drug_date = $('#drug_date').val();
			var drug_comment = $('#drug_comment').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var date_admitted = $('#session_dateofadmission_attd').val();
			if (drug > 0) 
				{
					if (drug_gender == 3 || drug_gender == gender)
					{
						if(age >= drug_age_from && age <= drug_age_to)
						{
							if(dosage !="")
							{
								/*if(qty_presc !=="")
								{*/
									if(drug_date !="" && drug_date >= date_admitted)
									{
										$.ajax({
										 url:'/layout/attendance/drugs_check_duplicate.php',
										 method:'POST',
										 datatype:'JSON',
										 data:{
											 drug:drug,
											 attend_id:attend_id
										 },
										 success:function(data)
											 {
												 var res = $.parseJSON(data);
												 if(res[0] == 'duplicate')
												 {
													 $('#drug_duplicate_modal_question').text('The drug:'+res[1]+ ' has been prescribed earlier! Do you want to duplicate the presciption?');
													 $('#drug_duplicate_modal').modal('show');
													$(document).on('click','#drug_dup_yes',function(){
														$.ajax({
														 url:'/layout/attendance/drugs_save.php',
														 method:'POST',
														 data:{
															 drug:drug,
															 dosage:dosage,
															 qty_presc:qty_presc,
															 drug_comment:drug_comment,
															 attend_id:attend_id,
															 patient_id:patient_id,
															 drug_sponsor:drug_sponsor,
															 drug_price_est:drug_price_est,
															 drug_amt_est:drug_amt_est,
															 drug_date:drug_date
														 },
														 success:function(data)
															 {
																if(data == 'enter_diagnosis')
																{
																	alert('Please enter diagnosis before prescribing drugs. Thank you.');
																}
																else
																{
																	$('#drug_attend_form').trigger('reset');
																	 //$('#attend_drug_table').html(data);
																	 $('#drug_duplicate_modal').modal('hide');
																	 location.reload();
																};
															 }
														 });
													  });
													$(document).on('click','#drug_dup_no',function(){
														$('#drug_duplicate_modal').modal('hide');
													});
												 }
												 else if(res[0] == 'none')
												 {
													 $.ajax({
													 url:'/layout/attendance/drugs_save.php',
													 method:'POST',
													 data:{
														 drug:drug,
														 dosage:dosage,
														 qty_presc:qty_presc,
														 drug_comment:drug_comment,
														 attend_id:attend_id,
														 patient_id:patient_id,
														 drug_sponsor:drug_sponsor,
														 drug_price_est:drug_price_est,
														 drug_amt_est:drug_amt_est,
														 drug_date:drug_date
													 },
													 success:function(data)
														 {
															if(data == 'enter_diagnosis')
															{
																alert('Please enter diagnosis before prescribing drugs. Thank you.');
															}
															else
															{
																$('#drug_attend_form').trigger('reset');
																//$('#attend_drug_table').html(data);
															};
														 }
													 });
												 }
												 
											 }
										 });
									}
									else
									{
										alert('Please prescription date must not be EMPTY or less than date of attendance!');
									};
								/*}
								else
								{
									alert('Please type the quantity prescibed!');
								};*/
							}
							else
							{
								alert('Please type the dosage!');
							};
						}
						else
						{
							alert('The age of the patient does not qualify him/her to take this drug!');
						};
					}
					else
					{
						alert('The gender of the patient does not qualify him/her to take this drug!');
					};
					
				} 
				else 
				{
					alert('Please select a drug!');
				};
		});
	}

	function enter_composite_drug_attend()
	{
		$(document).on('click','#composite_drug_enter_btn',function(e){
			e.preventDefault();
			var composite_drug_select = $('#composite_drug_select').val();
			var composite_days = $('#composite_days').val();
			var drug_date = $('#drug_date').val();
			var drug_sponsor = $('#drug_sponsor').val();
			var drug_attend_id = $('#session_attend_id').val();
			var drug_patient_id = $('#session_patient_id').val();
			var drug_comment = $('#drug_comment').val();
			
			if (composite_drug_select > 0) 
			{
				if (drug_date !="")
				{
					$.ajax({
						url:'/layout/attendance/drugs_attend_save_composite.php',
						method:'POST',
						data:{
							composite_drug_select:composite_drug_select,
							drug_attend_id:drug_attend_id,
							drug_patient_id:drug_patient_id,
							drug_comment:drug_comment,
							drug_date:drug_date,
							drug_sponsor:drug_sponsor,
							composite_days:composite_days
						},
						success:function(data)
						{
							if(data == 'enter_diagnosis')
							{
								alert('Please enter diagnosis before prescribing drugs. Thank you.');
							}
							else if(data == 'no_ward')
							{
								alert('Please admit patient into a ward first. Thank you.');
							}
							else if(data != 'enter_diagnosis' && data != 'no_ward')
							{
								$('#drug_attend_form').trigger('reset');
								location.reload();
							};
							
						}
					});
				} 
				else 
				{
					alert('Please enter date!');
				};
			} 
			else 
			{
				alert('Please select a Composite Lab test!');
			};
		});
	}

	function edit_drug_attend()
	{
		$(document).on('click','#btn_edit_drug_list',function(){

			var drug_list_id = $(this).attr('data-id1');

				$.ajax({  
					 url:'/layout/attendance/drugs_edit.php',  
					 type:'POST',  
					 data:{drug_list_id:drug_list_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#drug_date').val(res[0]);
						 $('#drug').val(res[1]);
						 $('#drug_list_id').val(res[2]);
						$('#qty_presc').val(res[3]);
						$('#dosage').val(res[4]);
						 $('#drug_price_est').val(res[5]);
						 $('#drug_amt_est').val(res[6]);
						$('#drug_comment').val(res[7]);
						$('#drug_sponsor').val(res[8]);
						$('#drug_save_update').html('<button type="submit" id="drug_sheet_update_btn" name="drug_sheet_update_btn" class="btn btn-primary">Update</button>');
					 }  
				});
		  }); 
	}

	function drug_edit_prescription_qty()
	{
		$(document).on('click','#btn_drug_edit_qty',function(){
			var drug_list_id = $(this).attr('data-id');
			var drug_desc = $(this).attr('data-id1');
			$('#drug_edit_qty_presc_drug').text(drug_desc);
			$('#drug_edit_qty_presc_qty').trigger('reset');
			$('#drug_edit_qty_presc_modal').modal('show');
			$(document).on('click','#drug_edit_qty_presc_save',function(){
				var qty_presc = $('#drug_edit_qty_presc_qty').val();
				$.ajax({  
					 url:'/layout/attendance/drugs_edit_prescription_qty.php',  
					 type:'POST',  
					 data:{drug_list_id:drug_list_id,qty_presc:qty_presc},
					 success:function(){
						 $('#drug_edit_qty_presc_modal').modal('hide');
						 view_drug_dispensed_list();
						 view_current_drugs();
					 }  
				});
			  });
			$(document).on('click','#drug_edit_qty_presc_cancel',function(){
				$('#drug_edit_qty_presc_modal').modal('hide');
			});
		});
	}

	function update_drug_attend()
	{
		$(document).on('click','#drug_sheet_update_btn',function(){
			var drug_id = $('#drug').val();
			if (drug_id > 0) 
				{
					var drug_list_id = $('#drug_list_id').val();
					var dosage = $('#dosage').val();
					var qty_presc = $('#qty_presc').val();
					var drug_price_est = $('#drug_price_est').val();
					var drug_amt_est = $('#drug_amt_est').val();
					var attend_id = $('#session_attend_id').val();
					var patient_id = $('#session_patient_id').val();
					var comment = $('#drug_comment').val();
					var drug_sponsor = $('#drug_sponsor').val();
					var drug_date = $('#drug_date').val();
					$.ajax({
						 url:'/layout/attendance/drugs_update.php',
						 method:'POST',
						 data:{
							 drug_list_id:drug_list_id,
							 drug_id:drug_id,
							 attend_id:attend_id,
							 patient_id:patient_id,
							 dosage:dosage,
							 qty_presc:qty_presc,
							 drug_price_est:drug_price_est,
							 drug_amt_est:drug_amt_est,
							 comment:comment,
							 drug_sponsor:drug_sponsor,
							 drug_date:drug_date
						 },
						 success:function(data)
							 {
								 $('#drug_attend_form').trigger('reset');
								 $('#drug_save_update').html('<button type="submit" id="drug_sheet_save_btn" name="drug_sheet_save_btn" class="btn btn-primary">Save</button>');
								 $('#attend_drug_table').html(data);
							 }
						 });
				} 
				else 
				{
					alert('Please select a drug!');
				}
			
		});
	}

	function drug_bill_status()
	{
		$(document).on('change','.drug_bill',function(){
			var drug_list_id = $(this).closest('tr').attr('id');
			var bill_status = $('#drug_bill'+drug_list_id).val();
			$.ajax({  
				url:'/layout/attendance/drugs_bill_status.php',  
				type:'POST',  
				data:{
					drug_list_id:drug_list_id, 
					bill_status:bill_status
				},
				success:function(data)
				{
					//view_current_lab_attend();
					location.reload();
				}
			});
		}); 
	}

	function view_current_drugs()
	{
		var attend_id = $('#session_attend_id').val();
		var patient_id = $('#session_patient_id').val();
		$.ajax(
		{
			url: '/layout/attendance/drugs_current_view.php',
			method: 'POST',
			data:{
					 attend_id:attend_id,
					 patient_id:patient_id
				 },
			success: function(data)
			{
				$('#attend_drug_table').html(data);
			}
		})
	}

	function view_drug_history()
	{
		$(document).on('click','#drug_history_icon',function(){
			
			var patient_id = $('#session_patient_id').val();
			$.ajax(
			{
				url: '/layout/attendance/drugs_history_view.php',
				method: 'POST',
				data:{
						 patient_id:patient_id
					 },
				success: function(data)
				{
					$('#attend_drug_history_table').html(data);
					$('#drug_history_modal').modal('show');
				}
			})
		});
	}

	function dispense_drug_modal()
	{
		$(document).on('click','#btn_disp_drug_list',function(){
			var patient_id = $('#session_patient_id').val();
			var attend_id = $('#session_attend_id').val();
			var drug_list_id = $(this).attr('data-id1');
			var drug_id = $(this).attr('data-id2');
			var currentRow=$(this).closest("tr");
			var date = currentRow.find("td:eq(0)").text();
			var drug = currentRow.find("td:eq(2)").text();
			var qty_presc = currentRow.find("td:eq(5)").text();
			var dosage = $.trim(currentRow.find("td:eq(4)").text());
			var today = new Date();
			today = moment(today).format("YYYY-MM-DD");
			
			$.ajax({
				url: '/layout/attendance/drugs_dispense_modal_set.php',
				method: 'POST',
				datatype:'JSON',
				data:{
						 drug_id:drug_id,
						 drug_list_id:drug_list_id
					 },
				success: function(data)
				{
					var res = $.parseJSON(data);
					if(parseFloat(res[0]) >= qty_presc)
					{
						$('#btn_drug_dispense').hide();
						$('#drug_dispense_form').hide();
						$('#drug_id_disp').val(drug_id);
						$('#drug_list_id_dp').val(drug_list_id);
						$.ajax(
						{
							url: '/layout/attendance/drug_dispensed_list.php',
							method: 'POST',
							data:{
									 attend_id:attend_id,
									 patient_id:patient_id,
									 drug_id:drug_id,
									 drug_list_id:drug_list_id
								 },
							success: function(data)
							{
								$('#drug_dispensed_table').html(data);
							}
						});
						//view_drug_dispensed_list();
						$('#drug_dispense_modal_title').text(drug +' has been dispensed already!');
						$('#drug_dispense_modal').modal('show');
					}
					else
					{
						$('#drug_negative_dp').val(res[1]);
						$('#drug_batch_dp').val(res[4]);
						$('#drug_expiry_dp').val(res[2]);
						$('#drug_days_dp').val(res[3]);
						$('#drug_id_disp').val(drug_id);
						$('#qty_issue_dp').val(qty_presc - res[0]);
						$('#dosage_disp').val(dosage);
						$('#date_disp').val(today);
						$('#drug_id_dp').val(drug_id);
						$('#drug_id_dp2').val(drug_id);
						$('#dosage_dp').val(dosage);
						$('#dosage_dp2').val(dosage);
						$('#qty_presc_dp').val(qty_presc);
						$('#qty_presc_dp2').val(qty_presc);
						$('#date_presc_dp').val(date);
						$('#date_presc_dp2').val(date);
						$('#drug_list_id_dp').val(drug_list_id);
						drug_price_and_amount();
						//view_drug_dispensed_list();
						$.ajax(
						{
							url: '/layout/attendance/drug_dispensed_list.php',
							method: 'POST',
							data:{
									 attend_id:attend_id,
									 patient_id:patient_id,
									 drug_id:drug_id,
									 drug_list_id:drug_list_id
								 },
							success: function(data)
							{
								$('#drug_dispensed_table').html(data);
							}
						});
						$('#btn_drug_dispense').show();
						$('#drug_dispense_form').show();
						$('#drug_dispense_modal_title').text('Dispensing - '+ drug);
						$('#drug_dispense_modal').modal('show');
					};
				}
			});
		});
	}

	function dispense_drug_modal_cancel()
	{
		$(document).on('click','#btn_cancel_dispense',function()
		{
			 $('#drug_dispense_form').trigger('reset');
			 var drug_id_disp = '';
		});
	}

	function select_substitute_drug_to_dispense()
	{
		$(document).on('change','#drug_id_disp',function(){

			var drug_id = $('#drug_id_disp').val();
			var today = new Date();
			today = moment(today).format("YYYY-MM-DD");
			$.ajax(
			{
				url: '/layout/attendance/drugs_dispense_substitute_set.php',
				method: 'POST',
				datatype:'JSON',
				data:{
						 drug_id:drug_id
					 },
				success: function(data)
				{
					var res = $.parseJSON(data);
					 $('#drug_gender_dp').val(res[0]);
					 $('#drug_age_from_dp').val(res[1]);
					 $('#drug_age_to_dp').val(res[2]);
					 $('#drug_negative_dp').val(res[3]);
					 $('#drug_expiry_dp').val(res[4]);
					 $('#drug_batch_dp').val(res[5]);
					 $('#drug_days_dp').val(res[6]);
					$('#date_disp').val(today);
				}
			});
		});
	}

	function view_drug_dispensed_list()
	{
		var attend_id = $('#session_attend_id').val();
		var patient_id = $('#session_patient_id').val();
		   var drug_id = $('#drug_id_dp').val();
		var drug_list_id = $('#drug_list_id_dp').val();
		$.ajax(
		{
			url: '/layout/attendance/drug_dispensed_list.php',
			method: 'POST',
			data:{
					 attend_id:attend_id,
					 patient_id:patient_id,
					 drug_id:drug_id,
					 drug_list_id:drug_list_id
				 },
			success: function(data)
			{
				$('#drug_dispensed_table').html(data);
			}
		})
	}

	function change_drug_price_and_amount()
	{
		$(document).on('keyup','#drug_price_cash_dp',function()
		{
			var drug_price_cash_dp = $('#drug_price_cash_dp').val();
			var qty_issue_dp = $('#qty_issue_dp').val();
			var amount = qty_issue_dp * drug_price_cash_dp;
			$('#drug_amt_cash_dp').val(amount);
			$('#drug_amt_cash_dp2').val(amount);
		});
	}

	function set_drug_price_and_amount()
	{
		$(document).on('change keyup','#qty_issue_dp,#drug,#qty_presc,#drug_sponsor,#drug_id_disp',function(){
			drug_price_and_amount();
		});
	}

	function drug_price_and_amount()
	{
		var sponsor_id = $('#drug_sponsor').val();
		var drug_id_disp = $('#drug_id_disp').val();
		var drug_id_dp = $('#drug_id_dp').val();
		var drug_id_pr = $('#drug').val();
		var drug_list_id = $('#drug_list_id_dp').val();
		if(drug_id_disp <= 0)
		{
			if(drug_id_dp > 0 && drug_id_pr <= 0)
			{
				var drug_id = $('#drug_id_dp').val();
			}
			else if(drug_id_pr > 0 && drug_id_dp <= 0)
			{
				var drug_id = $('#drug').val();
			};
		}
		else
		{
			var drug_id = $('#drug_id_disp').val();
		};

		var age = $('#session_age').val();
		var qty_disp = $('#qty_issue_dp').val();
		var qty_presc = $('#qty_presc').val();
		$.ajax(
		{
			url: '/layout/attendance/drugs_price_set.php',
			method: 'POST',
			data:{
					sponsor_id:sponsor_id,
					drug_id:drug_id,
					drug_list_id:drug_list_id
			},
			datatype: 'JSON',
			success: function(data)
			{
				var res = $.parseJSON(data);
				if (res[7] == 'cash')
				{
					if(drug_id_disp <= 0)
					{
						$('#drug_price_est').val(res[0]);
						$('#drug_amt_est').val(res[0] * qty_presc);
					}
					else
					{
						$('#drug_price_cash_dp').val(res[0]);
						$('#drug_price_cash_dp2').val(res[0]);
						$('#drug_price_prvt_dp').val(0);
						$('#drug_price_nhis_dp').val(0);
						$('#drug_amt_cash_dp').val(res[0] * qty_disp);
						$('#drug_amt_cash_dp2').val(res[0] * qty_disp);
						$('#drug_amt_prvt_dp').val(0);
						$('#drug_amt_nhis_dp').val(0);
					};
				}
				else if (res[7] == 'nhia') 
				{
					if(drug_id_disp <= 0)
					{
						$('#drug_price_est').val(res[4]);
						$('#drug_amt_est').val(res[4] * qty_presc);
					}
					else
					{
						$('#drug_price_cash_dp').val(res[4]);
						$('#drug_price_cash_dp2').val(res[4]);
						$('#drug_price_prvt_dp').val(0);
						$('#drug_price_nhis_dp').val(res[1]);
						$('#drug_amt_cash_dp').val(res[4] * qty_disp);
						$('#drug_amt_cash_dp2').val(res[4] * qty_disp);
						$('#drug_amt_prvt_dp').val(0);
						$('#drug_amt_nhis_dp').val(res[1] * qty_disp);
					};
				}
				else if (res[7] == 'nhia_na') 
				{
					if(drug_id_disp <= 0)
					{
						$('#drug_price_est').val(res[0]);
						$('#drug_amt_est').val(res[0] * qty_presc);
					}
					else
					{
						$('#drug_price_cash_dp').val(res[0]);
						$('#drug_price_cash_dp2').val(res[0]);
						$('#drug_price_prvt_dp').val(0);
						$('#drug_price_nhis_dp').val(0);
						$('#drug_amt_cash_dp').val(res[0] * qty_disp);
						$('#drug_amt_cash_dp2').val(res[0] * qty_disp);
						$('#drug_amt_prvt_dp').val(0);
						$('#drug_amt_nhis_dp').val(0);
					};
				}
				else if (res[7] == 'private_list') 
				{
					if(drug_id_disp <= 0)
					{
						$('#drug_price_est').val(res[6]);
						$('#drug_amt_est').val(res[6] * qty_presc);
					}
					else
					{
						$('#drug_price_cash_dp').val(res[6]);
						$('#drug_price_cash_dp2').val(res[6]);
						$('#drug_price_prvt_dp').val(res[5]);
						$('#drug_price_nhis_dp').val(0);
						$('#drug_amt_cash_dp').val(res[6] * qty_disp);
						$('#drug_amt_cash_dp2').val(res[6] * qty_disp);
						$('#drug_amt_prvt_dp').val(res[5] * qty_disp);
						$('#drug_amt_nhis_dp').val(0);
					};
				}
				else if (res[7] == 'private_no_list') 
				{
					if(drug_id_disp <= 0)
					{
						$('#drug_price_est').val(res[0]);
						$('#drug_amt_est').val(res[0] * qty_presc);
					}
					else
					{
						$('#drug_price_cash_dp').val(0);
						$('#drug_price_cash_dp2').val(0);
						$('#drug_price_prvt_dp').val(res[0]);
						$('#drug_price_nhis_dp').val(0);
						$('#drug_amt_cash_dp').val(0);
						$('#drug_amt_cash_dp2').val(0);
						$('#drug_amt_prvt_dp').val(res[0] * qty_disp);
						$('#drug_amt_nhis_dp').val(0);
					};
				};
			}
		});
	}

	function dispense_drug_attend_action()
	{
		var drug_id_disp = $('#drug_id_disp').val();
		var dosage_disp = $('#dosage_disp').val();
		var date_disp = $('#date_disp').val();
		var drug_id = $('#drug_id_dp').val();
		var drug_list_id = $('#drug_list_id_dp').val();
		var batch = $('#batch_no_dp').val();
		var ledger = $('#drug_sponsor').val();
		var warehouse = $('#loc_id_dp').val();
		var qty_issue = $('#qty_issue_dp').val();
		var price_cash = $('#drug_price_cash_dp').val();
		var price_nhis = $('#drug_price_nhis_dp').val();
		var price_prvt = $('#drug_price_prvt_dp').val();
		var amt_cash = $('#drug_amt_cash_dp').val();
		var amt_nhis = $('#drug_amt_nhis_dp').val();
		var amt_prvt = $('#drug_amt_prvt_dp').val();
		var attend_id = $('#session_attend_id').val();
		var patient_id = $('#session_patient_id').val();
		var prvt_led_id = $('#session_prvt_led_id').val();
		var comment = $('#drug_comment_dp').val();
	   $.ajax({
			 url:'/layout/attendance/drugs_dispense.php',
			 method:'POST',
			 data:{
					 drug_id_disp:drug_id_disp,
					 dosage_disp:dosage_disp,
					 date_disp:date_disp,
					 drug_list_id:drug_list_id,
					 drug_id:drug_id,
					 attend_id:attend_id,
					 patient_id:patient_id,
					 comment:comment,
					 batch:batch,
					 ledger:ledger,
					 warehouse:warehouse,
					 qty_issue:qty_issue,
					 price_cash:price_cash,
					 price_nhis:price_nhis,
					 price_prvt:price_prvt,
					 amt_cash:amt_cash,
					 amt_nhis:amt_nhis,
					 amt_prvt:amt_prvt,
					 prvt_led_id:prvt_led_id
				 },
			 success:function(data)
				 {
					 $('#drug_dispense_form').trigger('reset');
					 var drug_id_disp = '';
					 $('#drug_dispense_modal').modal('hide');
					 view_current_drugs();
				 }
		});
	}

	function dispense_drug_attend()
	{
		$(document).on('click','#btn_drug_dispense',function(){
			var drug_id_disp = $('#drug_id_disp').val();
			var dosage_disp = $('#dosage_disp').val();
			var drug_id = $('#drug_id_dp').val();
			var qty_issue = $('#qty_issue_dp').val();
			var batch = $('#batch_no_dp').val();
			var warehouse = $('#loc_id_dp').val();
			var negative = $('#drug_negative_dp').val();
			var batch_state = $('#drug_batch_dp').val();
			var expiry_state = $('#drug_expiry_dp').val();
			var days_promt = $('#drug_days_dp').val();
			var qty_total = $('#total_av_qty_dp').val();
			var qty_loc = $('#loc_qty_dp').val();
			var qty_batch = $('#batch_qty_dp').val();
			var expiry_date = new Date($('#drug_expiry_date_dp').val());
			var today = new Date();
			if (drug_id_disp > 0) 
			{
				if (warehouse > 0) 
				{
					if(negative == 1)
					{
						if(qty_total >= qty_issue)
						{
							if(qty_loc >= qty_issue)
							{
								if(batch_state == 1)
								{
									if(batch !== "")
									{
										if(qty_batch >= qty_issue)
										{
											if(expiry_state == 1)
												{
													if(expiry_date >= today)
														{
															dispense_drug_attend_action();
														}
														else
														{
															alert('Please the Batch for the drug has expired!');
														};
												}
												else
												{
													dispense_drug_attend_action();
												};
										}
										else
										{
											alert('Please you do not have quantity of this Batch to dispense!');
										}
									}
									else
									{
										alert('Please provide the Batch No!');
									}
								}
								else
								{
									if(expiry_state == 1)
									{
										if(expiry_date >= today)
										{
											dispense_drug_attend_action();
										}
										else
										{
											alert('Please the Batch for the drug has expired!');
										}
									}
									else
									{
										dispense_drug_attend_action();
									};
								}
							}
							else
							{
								alert('Please you do not have enough quantity of the drug in this location to dispense!');
							};
						}
						else
						{
							alert('Please you do not have enough quantity in the facility to dispense this drug!');
						};
					}
					else
					{
						if(batch_state == 1)
						{
							if(batch !== "")
							{
								if(expiry_state == 1)
								{
									if(expiry_date >= today)
									{
										dispense_drug_attend_action();
									}
									else
									{
										alert('Please the Batch for the drug has expired!');
									}
								}
								else
								{
									dispense_drug_attend_action();
								};
							}
							else
							{
								alert('Please provide the Batch No!');
							}
						}
						else
						{
							if(expiry_state == 1)
							{
								if(expiry_date >= today)
								{
									dispense_drug_attend_action();
								}
								else
								{
									alert('Please the Batch for the drug has expired!');
								}
							}
							else
							{
								dispense_drug_attend_action();
							};
						}
					}
				} 
				else 
				{
					alert('Please select the location from which the drug is being dispensed!');
				};
			} 
			else 
			{
				alert('Please select a drug!');
			};
		});
	}

	function drug_dispensed_delete()
	{
		$(document).on('click','#btn_delete_drug_disp_list',function(){
			var drug_disp_list_id = $(this).attr('data-id1');
			var drug_list_id = $(this).attr('data-id');
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var currentRow=$(this).closest("tr");
			var drug = currentRow.find("td:eq(1)").text();
			$('#drug_dispensed_deletion_modal_question').text('Are you sure you want to delete ' + drug + '?');
			$('#drug_dispensed_deletion_modal').modal('show');
			$(document).on('click','#drug_disp_del_yes',function(){
				$.ajax({  
					 url:'/layout/attendance/drug_dispensed_delete.php',  
					 type:'POST',  
					 data:{drug_disp_list_id:drug_disp_list_id,
						 drug_list_id:drug_list_id,
						 attend_id:attend_id},
					 success:function(){
						 $('#drug_dispensed_deletion_modal').modal('hide');
						 view_drug_dispensed_list();
						 view_current_drugs();
					 }  
				});
			  });
			$(document).on('click','#drug_disp_del_no',function(){
				$('#drug_dispensed_deletion_modal').modal('hide');
			});
		});
	}

	function drug_patient_returns_new()
	{
		$(document).on('click','#btn_patient_drug_returns',function(){
			var attend_id = $(this).attr('data-id');
			var patient_id = $(this).attr('data-id1');
			var drug_list_id = $(this).attr('data-id2');
			var name = $(this).attr('data-id3');
			var price_cash = $(this).attr('data-id4');
			var drug_id = $(this).attr('data-id5');
			var brand_name = $(this).attr('data-id6');
			var category_id = $(this).attr('data-id7');
			var qty_disp = $(this).attr('data-id8');
			var qty_admin = $(this).attr('data-id9');
			var qty_returned = $(this).attr('data-id10');
			var qty_max = qty_disp - qty_admin - qty_returned;
			var today = new Date();
			var today = moment(today).format("YYYY-MM-DD");
			if(qty_max !== '' && qty_max > 0)
			{
				$('#drug_patient_returns_form').trigger('reset');
				$('#dpr_drug_id').val(drug_id);
				$('#dpr_drug_list_id').val(drug_list_id);
				$('#dpr_price').val(price_cash);
				$('#dpr_category').val(category_id);
				$('#dpr_warehouse_id').val(1);
				$('#dpr_date').val(today);
				$('#dpr_max_qty').val(qty_max);
				$('#dpr_max_qty_d').val(qty_max);
				$('#save_drug_patient_returns').show();
				$('#update_drug_patient_returns').hide();
				$("#drug_patient_returns_table").prop("hidden",true);
				$("#drug_patient_returns_inputs").prop("hidden",false);
				$('#drug_patient_returns_modal').modal('show');
			}
			else
			{
				alert('Please there is No Quantity of this drug to be returned by the patient!');
			};
		});
	}

	function drug_patient_returns_view()
	{
		$(document).on('click','#drug_patient_returns_icon',function(){

			var patient_id = $('#session_patient_id').val();
			var attend_id = $('#session_attend_id').val();
			$.ajax(
			{
				url: '/layout/attendance/drugs_patient_return_view.php',
				method: 'POST',
				data:{
						 patient_id:patient_id,attend_id:attend_id
					 },
				success: function(data)
				{
					$('#drug_patient_returns_form').trigger('reset');
					$('#save_drug_patient_returns').hide();
					$('#update_drug_patient_returns').hide();
					$("#drug_patient_returns_table").prop("hidden",false);
					$("#drug_patient_returns_inputs").prop("hidden",true);
					$('#drug_patient_returns_table').html(data);
					$('#drug_patient_returns_modal').modal('show');
				}
			})
		});
	}

	function get_drug_patient_return_amount()
	{
		$(document).on('change keyup', '#dpr_qty, #dpr_price', function(){  
			   var qty = $('#dpr_qty').val();
			   var price = $('#dpr_price').val();
			   var amount = qty * price; 
			   $('#dpr_amount').val(amount);
		   });
	}

	function drug_patient_returns_save()
	{
		$(document).on('click','#save_drug_patient_returns',function(){

			var patient_id = $('#session_patient_id').val();
			var attend_id = $('#session_attend_id').val();
			var category = $('#dpr_category').val();
			var warehouse_id = $('#dpr_warehouse_id').val();
			var date = $('#dpr_date').val();
			var batch_no = $('#dpr_batch_no').val();
			var expiry_date = $('#dpr_expiry_date').val();
			var max_qty = $('#dpr_max_qty').val();
			var max_qty_d = $('#dpr_max_qty_d').val();
			var qty = $('#dpr_qty').val();
			var price = $('#dpr_price').val();
			var amount = $('#dpr_amount').val();
			var narration = $('#dpr_narration').val();
			var maximum_qty = parseInt(max_qty);
			var returned_qty = parseInt(qty);

			if(warehouse_id != '' && warehouse_id > 0)
			{
				if(returned_qty != '' && returned_qty != 0)
				{
					if(returned_qty <= maximum_qty)
					{
						if(date != '')
						{
							if(narration !== '')
							{
								$.ajax(
								{
									url: '/layout/attendance/drugs_patient_return_save.php',
									method: 'POST',
									data:$('#drug_patient_returns_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
									success: function(data)
									{
										$('#drug_patient_returns_form').trigger('reset');
										$('#save_drug_patient_returns').hide();
										$('#update_drug_patient_returns').hide();
										$("#drug_patient_returns_table").prop("hidden",false);
										$("#drug_patient_returns_inputs").prop("hidden",true);
										$('#drug_patient_returns_table').html(data);
										$('#drug_patient_returns_modal').modal('hide');
										location.reload();
									}
								});
							}
							else
							{
								alert('Please provide the reason for returning the item!');
							};
						}
						else
						{
							alert('Please provide the date!');
						};
					}
					else
					{
						alert('Please the quantity cannot be more than the Quantity Left(Dispensed Quantity - Administered Quantity)!');
					};
				}
				else
				{
					alert('Please type the quantity the patient is returning!');
				};
			}
			else
			{
				alert('Please select the Warehouse receiving the item!');
			};
		});
	}

	function drug_patient_returns_edit()
	{
		$(document).on('click','#btn_edit_drug_patient_return',function(){

			var drug_pat_return_id = $(this).attr('data-id');

				$.ajax(
				{
					url: '/layout/attendance/drugs_patient_return_edit.php',
					method: 'POST',
					data:{drug_pat_return_id:drug_pat_return_id},
					datatype: 'JSON',
					success: function(data)
					{
						 var res = $.parseJSON(data);
						$('#drug_patient_returns_form').trigger('reset');
						$('#drug_pat_return_id').val(res[0]);
						$('#dpr_drug_id').val(res[1]);
						$('#dpr_drug_list_id').val(res[2]);
						$('#dpr_qty').val(res[3]);
						$('#dpr_price').val(res[4]);
						$('#dpr_amount').val(res[5]);
						$('#dpr_date').val(res[6]);
						$('#dpr_batch_no').val(res[7]);
						$('#dpr_expiry_date').val(res[8]);
						$('#dpr_warehouse_id').val(res[9]);
						$('#dpr_narration').val(res[10]);
						$('#dpr_category').val(res[11]);
						var qty_disp = res[12];
						var qty_admin = res[13];
						var qty_returned = res[14];
						var qty_max = qty_disp - qty_admin - qty_returned;
						$('#dpr_max_qty').val(qty_max);
						$('#dpr_max_qty_d').val(qty_max);
						$('#save_drug_patient_returns').hide();
						$('#update_drug_patient_returns').show();
						$("#drug_patient_returns_table").prop("hidden",false);
						$("#drug_patient_returns_inputs").prop("hidden",false);
						$('#drug_patient_returns_modal').modal('show');
					}
				});
				
		});
	}

	function drug_patient_returns_update()
	{
		$(document).on('click','#update_drug_patient_returns',function(){
			var patient_id = $('#session_patient_id').val();
			var attend_id = $('#session_attend_id').val();
			var category = $('#dpr_category').val();
			var warehouse_id = $('#dpr_warehouse_id').val();
			var date = $('#dpr_date').val();
			var batch_no = $('#dpr_batch_no').val();
			var expiry_date = $('#dpr_expiry_date').val();
			var max_qty = $('#dpr_max_qty').val();
			var max_qty_d = $('#dpr_max_qty_d').val();
			var qty = $('#dpr_qty').val();
			var price = $('#dpr_price').val();
			var amount = $('#dpr_amount').val();
			var narration = $('#dpr_narration').val();
			if(warehouse_id !== '' && warehouse_id > 0)
			{
				if(qty !== '' && qty !== 0)
				{
					if(qty <= max_qty)
					{
						if(date !== '')
						{
							if(narration !== '')
							{
								$.ajax(
								{
									url: '/layout/attendance/drugs_patient_return_update.php',
									method: 'POST',
									data:$('#drug_patient_returns_form').serialize() + '&attend_id=' + attend_id + '&patient_id=' + patient_id,
									success: function(data)
									{
										$('#drug_patient_returns_form').trigger('reset');
										$('#save_drug_patient_returns').hide();
										$('#update_drug_patient_returns').hide();
										$("#drug_patient_returns_table").prop("hidden",false);
										$("#drug_patient_returns_inputs").prop("hidden",true);
										$('#drug_patient_returns_table').html(data);
										$('#drug_patient_returns_modal').modal('hide');
									}
								});
							}
							else
							{
								alert('Please provide the reason for returning the item!');
							};
						}
						else
						{
							alert('Please provide the date!');
						};
					}
					else
					{
						alert('Please the quantity cannot be more than the Quantity Left(Dispensed Quantity - Administered Quantity)!');
					};
				}
				else
				{
					alert('Please type the quantity the patient is returning!');
				};
			}
			else
			{
				alert('Please select the Warehouse receiving the item!');
			};
		});
	}

	function admin_drug_modal()
	{
		$(document).on('click','#btn_admin_drug_list',function(){
			var patient_id = $('#session_patient_id').val();
			var attend_id = $('#session_attend_id').val();
			var drug_list_id = $(this).attr('data-id1');
			var drug_id = $(this).attr('data-id2');
			var currentRow=$(this).closest("tr");
			var drug = currentRow.find("td:eq(2)").text();
			var qty_presc = currentRow.find("td:eq(5)").text();
			var dosage = currentRow.find("td:eq(4)").text();
			$('#drug_id_da').val(drug_id);
			$('#drug_id_da2').val(drug_id);
			$('#dosage_da').val(dosage);
			$('#dosage_da2').val(dosage);
			$('#qty_presc_da').val(qty_presc);
			$('#qty_presc_da2').val(qty_presc);
			$('#drug_list_id_da').val(drug_list_id);
			$('#drug_admin_modal_title').text('Administering - '+ drug);
			admin_drug_view();
			$('#drug_admin_modal').modal('show');
			
		});
	}
	
	function admin_drug_save()
	{
		$(document).on('click','#btn_drug_admin',function(){
			var patient_id = $('#session_patient_id').val();
			var attend_id = $('#session_attend_id').val();
			var drug_id = $('#drug_id_da').val();
			var drug_list_id = $('#drug_list_id_da').val();
			var route = $('#route_da').val();
			var qty_admin = $('#qty_admin_da').val();
			var initials = $('#initials_da').val();
			var comment = $('#drug_comment_da').val();
			var date = $('#date_admin_da').val();
			var time = $('#time_admin_da').val();
			if (qty_admin !='') 
			{
				if(route > 0)
				{
					if(initials !== "")
					{
						$.ajax(
						{
							url: '/layout/attendance/drugs_admin_save.php',
							method: 'POST',
							datatype:'JSON',
							data:{
									 drug_id:drug_id,drug_list_id:drug_list_id,route:route,
									 qty_admin:qty_admin,initials:initials,comment:comment,date:date,
									 patient_id:patient_id,attend_id:attend_id,time:time
								 },
							success: function(data)
							{
								$('#drug_admin_form').trigger('reset');
								$('#drug_admin_modal').modal('hide');
							}
						});
					}
					else
					{
						alert('Please provide your initials!');
					}
				}
				else
				{
					alert('Please select a route!');
				}
			} 
			else 
			{
				alert('Please type a quantity!');
			}
		});
	}

	function admin_drug_view()
	{
		var drug_id = $('#drug_id_da').val();
		var drug_list_id = $('#drug_list_id_da').val();
		$.ajax(
		{
			url: '/layout/attendance/drugs_admin_view.php',
			method: 'POST',
			data:{
					 drug_id:drug_id,
					 drug_list_id:drug_list_id,
				 },
			success: function(data)
			{
				$('#drug_admin_table').html(data);
			}
		});
	}

	function admin_drug_delete()
	{
		$(document).on('click','#btn_delete_drug_admin',function(){
			var drug_admin_id = $(this).attr('data-id');
			$('#drug_admin_deletion_modal_question').text('Are you sure you want to delete drug administration?');
			$('#drug_admin_deletion_modal').modal('show');
			$(document).on('click','#drug_admin_del_yes',function(){
				$.ajax({  
					 url:'/layout/attendance/drugs_admin_delete.php',  
					 type:'POST',  
					 data:{drug_admin_id:drug_admin_id},
					 success:function(){
						 $('#drug_admin_deletion_modal').modal('hide');
						 admin_drug_view();
					 }  
				});
			  });
			$(document).on('click','#drug_admin_del_no',function(){
				$('#drug_admin_deletion_modal').modal('hide');
			});
		});
	}

	function drug_prescription_modal()
	{
		$(document).on('click','#drug_prescription_icon',function()
		{
			var patient_id = $('#session_patient_id').val();
			var attend_id= $('#session_attend_id').val();
			$.ajax({  
					 url:'/layout/attendance/drugs_prescription.php',  
					 method:'POST',  
					 data:{
						 attend_id:attend_id, 
						 patient_id:patient_id
					 },
					 success:function(data){
						 window.open('/layout/attendance/drugs_prescription_display_pdf.php', '_blank');
					 }
				});
		});
	}

	function drug_admin_chart_modal()
	{
		$(document).on('click','#drug_chart_icon',function()
		{
			var patient_id = $('#session_patient_id').val();
			var attend_id= $('#session_attend_id').val();
			$.ajax({  
					 url:'/layout/attendance/drugs_admin_chart.php',  
					 method:'POST',  
					 data:{
						 attend_id:attend_id, 
						 patient_id:patient_id
					 },
					 success:function(data){
						window.open('/layout/attendance/drugs_admin_chart_pdf.php', '_blank');
						 //$('#drug_admin_chart_table').html(data);
						 //$('#drug_admin_chart_modal').modal('show');
					 }  
				});
		});
	}

	function drug_attend_delete()
	{
		$(document).on('click','#btn_delete_drug_list',function(){
			var drug_list_id = $(this).attr('data-id1');
			var attend_id = $('#session_attend_id').val();
			var currentRow=$(this).closest("tr");
			var drug = currentRow.find("td:eq(1)").text();
			$('#drug_attend_deletion_modal_question').text('Are you sure you want to delete ' + drug + '?');
			$('#drug_attend_deletion_modal').modal('show');
			$(document).on('click','#drug_del_yes',function(){
				$.ajax({  
					 url:'/layout/attendance/drug_attend_delete.php',  
					 type:'POST',  
					 data:{drug_list_id:drug_list_id,attend_id:attend_id},
					 success:function(){
						 $('#drug_attend_deletion_modal').modal('hide');
						 view_current_drugs();
					 }  
				});
			  });
			$(document).on('click','#drug_del_no',function(){
				$('#drug_attend_deletion_modal').modal('hide');
			});
		});
	}

	function drug_mur_modal()
	{
		$(document).on('click','#btn_drug_mur',function()
		{
			var patient_id = $('#session_patient_id').val();
			var attend_id = $('#session_attend_id').val();
			var date = $('#session_dateofadmission_attd').val();
			var drug_id = $(this).attr('data-id');
			var drug_list_id = $(this).attr('data-id1');

			var currentRow=$(this).closest("tr");
			var drug = currentRow.find("td:eq(1)").text();
			$('#drug_mur_modal_title').text('Medicine Utilisation Review - ' + drug);

			$.ajax({  
				 url:'/layout/attendance/drugs_mur_modal.php',  
				 method:'POST',  
				 data:{
					 attend_id:attend_id, 
					 patient_id:patient_id,
					 drug_list_id:drug_list_id,
					 drug_id:drug_id
				 },
				 datatype: 'JSON',
				 success:function(data){
					 $('#drug_mur_form').trigger('reset');
					 var res = $.parseJSON(data);
					 var Q1 = '';
					 var Q1 = res[2];
					 $('#mur_drug_id').val(res[0]);
					 $('#mur_drug_list_id').val(res[1]);
					 if (Q1 == 'Yes') 
					 {
						 $('#mur_q_2_div').prop("hidden", false);
						 $('#mur_q_3_div').prop("hidden", false);
						 $('#mur_q_4_div').prop("hidden", false);
						 $('#mur_q_5_div').prop("hidden", false);
						 $('#mur_q_6_div').prop("hidden", false);
						 $('#mur_q_7_div').prop("hidden", false);
						 $('#mur_q_8_div').prop("hidden", false);
						 $('#mur_q_9_div').prop("hidden", false);
						 $('#mur_q_10_div').prop("hidden", false);
						 $('#mur_q_11_div').prop("hidden", false);
						 $('#mur_q_12_div').prop("hidden", false);
						 $('#mur_q_13_div').prop("hidden", false);
						 $('#mur_q_14_div').prop("hidden", false);
						 $('#mur_q_15_div').prop("hidden", false);
						 $('#mur_q_16_div').prop("hidden", false);
						 $('#mur_q_17_div').prop("hidden", false);
						 $('#mur_q_18_div').prop("hidden", false);
						 $('#mur_q_19_div').prop("hidden", false);
						 $('#mur_q_20_div').prop("hidden", false);
						 $('#mur_q_21_div').prop("hidden", false);
						 $('#mur_action_taken_div').prop("hidden", false);

						 $('#mur_q_1').val(res[2]);
						$('#mur_q_2').val(res[3]);
						$('#mur_q_3').val(res[4]);
						 $('#mur_q_4').val(res[5]);
						 $('#mur_q_5').val(res[6]);
						$('#mur_q_6').val(res[7]);
						$('#mur_q_7').val(res[8]);
						 $('#mur_q_8').val(res[9]);
						$('#mur_q_9').val(res[10]);
						$('#mur_q_10').val(res[11]);
						 $('#mur_q_11').val(res[12]);
						 $('#mur_q_12').val(res[13]);
						$('#mur_q_13').val(res[14]);
						$('#mur_q_14').val(res[15]);
						 $('#mur_q_15').val(res[16]);
						$('#mur_q_16').val(res[17]);
						$('#mur_q_17').val(res[18]);
						 $('#mur_q_18').val(res[19]);
						 $('#mur_q_19').val(res[20]);
						$('#mur_q_20').val(res[21]);
						$('#mur_q_21').val(res[22]);
					 }
					 else
					 {
						 $('#mur_q_1').val(res[2]);
						 $('#mur_q_2_div').prop("hidden", true);
						 $('#mur_q_3_div').prop("hidden", true);
						 $('#mur_q_4_div').prop("hidden", true);
						 $('#mur_q_5_div').prop("hidden", true);
						 $('#mur_q_6_div').prop("hidden", true);
						 $('#mur_q_7_div').prop("hidden", true);
						 $('#mur_q_8_div').prop("hidden", true);
						 $('#mur_q_9_div').prop("hidden", true);
						 $('#mur_q_10_div').prop("hidden", true);
						 $('#mur_q_11_div').prop("hidden", true);
						 $('#mur_q_12_div').prop("hidden", true);
						 $('#mur_q_13_div').prop("hidden", true);
						 $('#mur_q_14_div').prop("hidden", true);
						 $('#mur_q_15_div').prop("hidden", true);
						 $('#mur_q_16_div').prop("hidden", true);
						 $('#mur_q_17_div').prop("hidden", true);
						 $('#mur_q_18_div').prop("hidden", true);
						 $('#mur_q_19_div').prop("hidden", true);
						 $('#mur_q_20_div').prop("hidden", true);
						 $('#mur_q_21_div').prop("hidden", true);
						 $('#mur_action_taken_div').prop("hidden", true);
					 }
					 
					$('#mur_patient_id').val(patient_id);
					$('#mur_attend_id').val(attend_id);
					$('#mur_date').val(date);
					 $('#drug_mur_modal').modal('show');
				 }  
			});
		});
	}

	function drug_mur_no_entry()
	{
		$(document).on('change','#mur_q_1',function()
		{
			var Q1 = '';
			var Q1 = $('#mur_q_1').val();
			if (Q1 == 'Yes') 
			{
				$('#mur_q_2_div').prop("hidden", false);
				 $('#mur_q_3_div').prop("hidden", false);
				 $('#mur_q_4_div').prop("hidden", false);
				 $('#mur_q_5_div').prop("hidden", false);
				 $('#mur_q_6_div').prop("hidden", false);
				 $('#mur_q_7_div').prop("hidden", false);
				 $('#mur_q_8_div').prop("hidden", false);
				 $('#mur_q_9_div').prop("hidden", false);
				 $('#mur_q_10_div').prop("hidden", false);
				 $('#mur_q_11_div').prop("hidden", false);
				 $('#mur_q_12_div').prop("hidden", false);
				 $('#mur_q_13_div').prop("hidden", false);
				 $('#mur_q_14_div').prop("hidden", false);
				 $('#mur_q_15_div').prop("hidden", false);
				 $('#mur_q_16_div').prop("hidden", false);
				 $('#mur_q_17_div').prop("hidden", false);
				 $('#mur_q_18_div').prop("hidden", false);
				 $('#mur_q_19_div').prop("hidden", false);
				 $('#mur_q_20_div').prop("hidden", false);
				 $('#mur_q_21_div').prop("hidden", false);
				 $('#mur_action_taken_div').prop("hidden", false);
			}
			else 
			{
				$('#mur_q_2_div').prop("hidden", true);
				 $('#mur_q_3_div').prop("hidden", true);
				 $('#mur_q_4_div').prop("hidden", true);
				 $('#mur_q_5_div').prop("hidden", true);
				 $('#mur_q_6_div').prop("hidden", true);
				 $('#mur_q_7_div').prop("hidden", true);
				 $('#mur_q_8_div').prop("hidden", true);
				 $('#mur_q_9_div').prop("hidden", true);
				 $('#mur_q_10_div').prop("hidden", true);
				 $('#mur_q_11_div').prop("hidden", true);
				 $('#mur_q_12_div').prop("hidden", true);
				 $('#mur_q_13_div').prop("hidden", true);
				 $('#mur_q_14_div').prop("hidden", true);
				 $('#mur_q_15_div').prop("hidden", true);
				 $('#mur_q_16_div').prop("hidden", true);
				 $('#mur_q_17_div').prop("hidden", true);
				 $('#mur_q_18_div').prop("hidden", true);
				 $('#mur_q_19_div').prop("hidden", true);
				 $('#mur_q_20_div').prop("hidden", true);
				 $('#mur_q_21_div').prop("hidden", true);
				 $('#mur_action_taken_div').prop("hidden", true);
			}
		});
	}

	function drug_mur_save()
	{
		$(document).on('click','#btn_drug_mur_save',function(e){
			e.preventDefault();
				$.ajax({
					 url:'/layout/attendance/drugs_mur_save.php',
					 method:'POST',
					 data:$('#drug_mur_form').serialize(),
					 success:function(data)
						 {
							 $('#drug_mur_form').trigger('reset');
							 $('#drug_mur_modal').modal('hide');
						 }
				});	
		});
	}

	function drug_label_modal()
	{
		$(document).on('click','#btn_label_drug_list',function()
		{
			var name = $('#session_user_full_name').val();
			var drug_list_id = $(this).attr('data-id1');
			var drug_id = $(this).attr('data-id2');
			$.ajax({  
					 url:'/layout/attendance/drugs_label_modal.php',  
					 method:'POST',  
					 data:{
						 drug_list_id:drug_list_id
					 },
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#label_view').val(res[0]);
						 $('#label_drug_list_id').val(res[1]);
						 $('#label_dispensed_by').val(res[2]);
						 $('#label_drug_id').val(drug_id);
						 $('#label_dispensed_by').val(name);
						 $('#drug_label_modal').modal('show');
					 }  
				});
		});
	}

	function drug_label_auto_search()
	{
		$(document).on('keyup','#label_search',function()
		{
			var input = $(this).val();
			$.ajax({  
					 url:'/layout/attendance/drugs_label_search.php',  
					 method:'POST',  
					 data:{
						 input:input
					 },
					 success:function(data){
						 $('#label_search_result').html(data);
					 }  
				});
		});
	}

	function drug_label_fill()
	{
		$(document).on('click','#btn_drug_label_list',function()
		{
			var label = $(this).attr('data-id');
			var content = $('#label_view').val();
			if (content == '') 
			{
				$('#label_view').val(content + '' + label);
			}
			else
			{
				$('#label_view').val(content + ', ' + label);
			};
		});
	}

	function drug_label_save()
	{
		$(document).on('click','#btn_drug_label_save',function(){
			var label_dispensed_by = $('#label_dispensed_by').val();
			var label_view = $('#label_view').val();
			var label_drug_list_id = $('#label_drug_list_id').val();
			var label_drug_id = $('#label_drug_id').val();
			if (label_dispensed_by !== "") 
			{
				if(label_view !== "")
				{
					$.ajax(
					{
						url: '/layout/attendance/drugs_label_save.php',
						method: 'POST',
						data:{
								 label_dispensed_by:label_dispensed_by,
								 label_view:label_view,
								 label_drug_list_id:label_drug_list_id,
								 label_drug_id:label_drug_id
							 },
						success: function(data)
						{
							$('#drug_label_form').trigger('reset');
							$('#drug_label_modal').modal('hide');
							window.open('/layout/attendance/drugs_label_display.php', '_blank');
						}
					});
				}
				else
				{
					alert('Please the label cannot be EMPTY!');
				}
			} 
			else 
			{
				alert('Please The Dispense/Label by cannot be EMPTY!');
			}
		});
	}

	function search_drug_list_modal()
	{
		$(document).on('click','#btn_drug_live_search',function()
		{
			$('#drug_list_search_modal_form').trigger('reset');
			$('#drug_list_search').focus();
			$('#drug_list_search_modal').modal('show');
		});
	}

	function search_drug_list_attend()
	{
		$(document).on('keyup','#drug_list_search',function()
		{
			var search = $(this).val();
			var sponsor_id = $('#drug_list_sponsor_id').val();
			var age = $('#drug_list_age').val();
			$.ajax({
				url:'/layout/attendance/drug_attend_search.php',
				method:"POST",
				data:{search:search,sponsor_id:sponsor_id,age:age},
				success:function(data)
				{
					$('#drug_list_search_table').html(data);
				}
			})
		});
	}

	function search_drug_list_save()
	{
		$(document).on('click','#btn_save_drug_search_item',function()
		{
			var drug = $(this).attr('data-id');
			var drug_gender = $(this).attr('data-id1');
			var drug_age_from = parseInt($(this).attr('data-id2'));
			var drug_age_to = parseInt($(this).attr('data-id3'));
			//var private_price = $(this).attr('data-id5');
			//var private_price_top = $(this).attr('data-id6');
			var sponsor_id = $(this).attr('data-id7');
			//var price_nhis = $(this).attr('data-id8');
			//var price_topup_nhis = $(this).attr('data-id9');
			var row = $(this).closest('tr');
			var dosage = row.find('#drug_search_dosage').val();
			var qty_presc = row.find('#drug_search_qty').val();
			if(sponsor_id == 1)
			{
				var drug_price_est = $(this).attr('data-id4');
				var drug_amt_est = qty_presc * drug_price_est;
			}
			else if(sponsor_id == 2)
			{
				var drug_price_est = $(this).attr('data-id9');
				var drug_amt_est = qty_presc * drug_price_est;
			}
			else if(sponsor_id != 1 && sponsor_id != 2)
			{
				var drug_price_est = $(this).attr('data-id6');
				var drug_amt_est = qty_presc * drug_price_est;
			};
			var gender = $('#session_gender').val();
			var age = parseInt($('#session_age').val());
			var drug_sponsor = $('#drug_sponsor').val();
			var drug_date = $('#drug_date').val();
			var drug_comment = $('#drug_comment').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var date_admitted = $('#session_dateofadmission_attd').val();
			if (drug > 0) 
				{
					if (drug_gender == 3 || drug_gender == gender)
					{
						if(age >= drug_age_from && age <= drug_age_to)
						{
							if(dosage !=="")
							{
								/*if(qty_presc !=="")
								{*/
									if(drug_date !=="" && drug_date >= date_admitted)
									{
										$.ajax({
										 url:'/layout/attendance/drugs_check_duplicate.php',
										 method:'POST',
										 datatype:'JSON',
										 data:{
											 drug:drug,
											 attend_id:attend_id
										 },
										 success:function(data)
											 {
												 var res = $.parseJSON(data);
												 if(res[0] == 'duplicate')
												 {
													 $('#drug_duplicate_modal_question').text('The drug:'+res[1]+ ' has been prescribed earlier! Do you want to duplicate the presciption?');
													 $('#drug_duplicate_modal').modal('show');
													$(document).on('click','#drug_dup_yes',function(){
														$.ajax({
														 url:'/layout/attendance/drugs_save.php',
														 method:'POST',
														 data:{
															 drug:drug,
															 dosage:dosage,
															 qty_presc:qty_presc,
															 drug_comment:drug_comment,
															 attend_id:attend_id,
															 patient_id:patient_id,
															 drug_sponsor:drug_sponsor,
															 drug_price_est:drug_price_est,
															 drug_amt_est:drug_amt_est,
															 drug_date:drug_date
														 },
														 success:function(data)
															 {
																if(data == 'enter_diagnosis')
																{
																	alert('Please enter diagnosis before prescribing drugs. Thank you.');
																}
																else
																{
																	$('#drug_list_search_modal_form').trigger('reset');
																	$('#drug_list_search').focus();
																	$('#drug_attend_form').trigger('reset');
																	 $('#attend_drug_table').html(data);
																	 $('#drug_duplicate_modal').modal('hide');
																};
															 }
														 });
													  });
													$(document).on('click','#drug_dup_no',function(){
														$('#drug_duplicate_modal').modal('hide');
													});
												 }
												 else if(res[0] == 'none')
												 {
													 $.ajax({
													 url:'/layout/attendance/drugs_save.php',
													 method:'POST',
													 data:{
														 drug:drug,
														 dosage:dosage,
														 qty_presc:qty_presc,
														 drug_comment:drug_comment,
														 attend_id:attend_id,
														 patient_id:patient_id,
														 drug_sponsor:drug_sponsor,
														 drug_price_est:drug_price_est,
														 drug_amt_est:drug_amt_est,
														 drug_date:drug_date
													 },
													 success:function(data)
														{
															if(data == 'enter_diagnosis')
															{
																alert('Please enter diagnosis before prescribing drugs. Thank you.');
															}
															else
															{
																$('#drug_list_search_modal_form').trigger('reset');
																$('#drug_list_search').focus();
																$('#drug_attend_form').trigger('reset');
																$('#attend_drug_table').html(data);
															}
														}
													 });
												 }
												 
											 }
										 });
									}
									else
									{
										alert('Please prescription date must not be EMPTY or less than date of attendance!');
									};
								/*}
								else
								{
									alert('Please type the quantity prescibed!');
								};*/
							}
							else
							{
								alert('Please type the dosage!');
							};
						}
						else
						{
							alert('The age of the patient does not qualify him/her to take this drug!');
						};
					}
					else
					{
						alert('The gender of the patient does not qualify him/her to take this drug!');
					};
					
				} 
				else 
				{
					alert('Please select a drug!');
				};
		});
	}
