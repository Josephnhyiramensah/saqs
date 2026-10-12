$(document).ready(function()
{
	//CONSUMABLES
		go_to_consumble_sheet();
		set_consumable_price_and_amount();
		save_consumable_sheet();
		edit_consumable_sheet();
		update_consumable_sheet();
		view_current_consumable_sheet();
		consumable_sheet_delete();
});

	//CONSUMABLES
	function go_to_consumble_sheet()
	{
		$(document).on('click','#nav_consumables',function()
		{
			window.location.href="/layout/attendance/consumables_sheet.php";
			$('#consum_list_update_btn').hide();
			$('#consum_list_save_btn').show();
			$('#consumables_attend_form').trigger('reset');
		}) 
	}

	function set_consumable_price_and_amount()
	{
		$(document).on('change keyup','#con_id,#consum_sponsor,#consum_qty',function(){
			var sponsor_id = '';
			var sponsor_id = $('#consum_sponsor').val();
			var sponsor_default = $('#session_sponsor').val();
			var con_id = $('#con_id').val();
			var age = $('#session_age').val();
			var qty = $('#consum_qty').val();
			$.ajax(
				{
					url: '/layout/attendance/consumables_price_set.php',
					method: 'POST',
					data:{
							 sponsor_id:sponsor_id,
							 con_id:con_id
						 },
					datatype: 'JSON',
					success: function(data)
					{
						var res = $.parseJSON(data);
						if (res[7] == 'cash')
						{
							$('#consum_price').val(res[0]);
							$('#consum_amt').val(res[0] * qty);
							$('#consum_amt_2').val(res[0] * qty);
						}
						else if (res[7] == 'nhia') 
						{
							if(age <= 11)
							{
								$('#consum_price').val(res[4]);
								$('#consum_amt').val(res[4] * qty);
								$('#consum_amt_2').val(res[4] * qty);
							}
							else
							{
								$('#consum_price').val(res[4]);
								$('#consum_amt').val(res[4] * qty);
								$('#consum_amt_2').val(res[4] * qty);
							}
						}
						else if (res[7] == 'nhia_na') 
						{
							$('#consum_price').val(res[0]);
							$('#consum_amt').val(res[0] * qty);
							$('#consum_amt_2').val(res[0] * qty);
						}
						else if (res[7] == 'private_list') 
						{
							$('#consum_price').val(res[5]);
							$('#consum_amt').val(res[5] * qty);
							$('#consum_amt_2').val(res[5] * qty);
						}
						else if (res[7] == 'private_no_list') 
						{
							$('#consum_price').val(res[0]);
							$('#consum_amt').val(res[0] * qty);
							$('#consum_amt_2').val(res[0] * qty);
						}
					}
				});
		});
	}

	function save_consumable_sheet()
	{
		$(document).on('click','#consum_list_save_btn',function(e){
			e.preventDefault();
			var con_id = $('#con_id').val();
			var date = $('#consum_date').val();
			var sponsor = $('#consum_sponsor').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var comment = $('#consum_comment').val();
			var qty = $('#consum_qty').val();
			var price = $('#consum_price').val();
			var amount = $('#consum_amt').val();
			var warehouse = $('#consum_warehouse').val();
			if (con_id > 0) 
			{
				if (date !=="") 
				{
					if (warehouse > 0) 
					{
						if (qty > 0) 
						{
							$.ajax({
									url:'/layout/attendance/consumables_save.php',
									method:'POST',
									data:{
									con_id:con_id,
									attend_id:attend_id,
									patient_id:patient_id,
									comment:comment,
									price:price,
									amount:amount,
									date:date,
									qty:qty,
									sponsor:sponsor,
									warehouse:warehouse
									},
									success:function(data)
										{
										$('#consumables_attend_form').trigger('reset');
										view_current_consumable_sheet();
										}
							});
						} 
						else 
						{
							alert('Please select the quantity cannot be EMPTY!');
						};
					} 
					else 
					{
						alert('Please select the Warehouse cannot be EMPTY!');
					};
				} 
				else 
				{
					alert('Please enter date!');
				};
			} 
			else 
			{
				alert('Please select consumable item!');
			};
		});
	}

	function edit_consumable_sheet()
	{
		$(document).on('click','#btn_consum_list_edit',function(){

			var con_list_id = $(this).attr('data-id12');
			var currentRow=$(this).closest("tr");
			var lab = currentRow.find("td:eq(1)").text();
				 $.ajax({  
					 url:'/layout/attendance/consumables_edit.php',  
					 type:'POST',  
					 data:{con_list_id:con_list_id},
					 datatype: 'JSON',
					 success:function(data){
						 var res = $.parseJSON(data);
						 $('#consum_date').val(res[0]);
						 $('#con_id').val(res[1]);
						$('#con_list_id').val(res[4]);
						$('#consum_comment').val(res[5]);
						$('#consum_price').val(res[6]);
						 $('#consum_amt').val(res[7]);
						 $('#consum_amt_2').val(res[7]);
						 $('#consum_qty').val(res[8]);
						$('#consum_sponsor').val(res[9]);
						$('#consum_warehouse').val(res[10]);
						$('#consum_save_update').html('<button type="submit" name="consum_list_update_btn" id="consum_list_update_btn" class="btn btn-primary">Update</button>');
						$('#consum_list_save_btn').hide();
					 }
				 });
		  }); 
	}

	function update_consumable_sheet()
	{
		$(document).on('click','#consum_list_update_btn',function(e){
			e.preventDefault();
			var con_list_id = $('#con_list_id').val();
			var con_id = $('#con_id').val();
			var date = $('#consum_date').val();
			var sponsor = $('#consum_sponsor').val();
			var attend_id = $('#session_attend_id').val();
			var patient_id = $('#session_patient_id').val();
			var comment = $('#consum_comment').val();
			var qty = $('#consum_qty').val();
			var price = $('#consum_price').val();
			var amount = $('#consum_amt').val();
			var warehouse = $('#consum_warehouse').val();
			if (con_id > 0) 
				{
					if (date !=="") 
					{
						if (warehouse > 0) 
							{
								$.ajax({
									 url:'/layout/attendance/consumables_update.php',
									 method:'POST',
									 data:{
										 con_list_id:con_list_id,
										 con_id:con_id,
										 attend_id:attend_id,
										 patient_id:patient_id,
										 comment:comment,
										 price:price,
										 amount:amount,
										 date:date,
										 qty:qty,
										 sponsor:sponsor,
									 },
									 success:function(data)
										 {
											 $('#consumables_attend_form').trigger('reset');
											 $('#consum_save_update').html('<button type="submit" name="consum_list_save_btn" id="consum_list_save_btn" class="btn btn-primary">Save</button>');
											view_current_consumable_sheet();
										 }
								});
							} 
							else 
							{
								alert('Please select the Warehouse cannot be EMPTY!');
							};
					} 
					else 
					{
						alert('Please enter date!');
					};
				} 
				else 
				{
					alert('Please select consumable item!');
				};
		});
	}

	function view_current_consumable_sheet()
	{
		var attend_id = $('#session_attend_id').val();
		var patient_id = $('#session_patient_id').val();
		$.ajax(
		{
			url: '/layout/attendance/consumables_current_view.php',
			method: 'POST',
			data:{
					 attend_id:attend_id,
					 patient_id:patient_id
				 },
			success: function(data)
			{
				$('#attend_consumables_list_table').html(data);
			}
		})
	}

	function consumable_sheet_delete()
	{
		$(document).on('click','#btn_delete_lab_attend',function(){
			var lab_list_id = $(this).attr('data-id8');
			var attend_id = $('#session_attend_id').val();
			var currentRow=$(this).closest("tr");
			var lab = currentRow.find("td:eq(1)").text();
			$('#lab_attend_delete_question').text('Are you sure you want to delete ' + lab + '?');
			$('#lab_attend_delete_modal').modal('show');
			$(document).on('click','#lab_attend_delete_yes',function(){
				$.ajax({  
					 url:'/layout/attendance/lab_attend_delete.php',  
					 type:'POST',  
					 data:{lab_list_id:lab_list_id,attend_id:attend_id},
					 success:function(){
						 $('#lab_attend_delete_modal').modal('hide');
						 view_current_lab_attend();
					 }  
				});
			  });
			$(document).on('click','#lab_attend_delete_no',function(){
				$('#lab_attend_delete_modal').modal('hide');
			});
		});
	}
