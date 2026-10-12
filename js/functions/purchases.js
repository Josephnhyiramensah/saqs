$(document).ready(function()
{
	//PURCHASES
		new_purchase_modal();
		cancel_purchase_modal();
		add_purchase_item_row();
		get_purchase_item_category();
		get_purchase_item_amount();
		delete_purchase_item_row();
		save_purchase_invoice();
		edit_purchase_invoice();
		update_purchase_invoice();
		delete_purchase_invoice();
});

			//PURCHASES
			function new_purchase_modal()
			{
				$(document).on('click','#new_purchase_icon',function()
				{
					$('#purch_update_btn').hide();
					$('#purch_save_btn').show();
					$('#purchases_create_form').trigger('reset');
					$('#purchase_create_modal').modal('show');
				});
			}

			function cancel_purchase_modal()
			{
				$(document).on('click','#purch_cancel_btn',function()
				{
					$('#purchases_create_form').trigger('reset');
					$('#purchase_create_modal').modal('hide');
					window.location.href="/layout/vouchers/purchases_list.php";
				});
			}

			function add_purchase_item_row()
			{
				$(document).on('change','.purch_item_id',function(){ 
					var i = $('#purchase_items_table tr:last').attr('id');
					i++;
					$.ajax({
						url:'/layout/vouchers/purchases_item_list.php',
						method:'POST',
						data:{i:i},
						success:function(data)
						{
							$('#purchase_items_table').append('<tr id="'+i+'">'+data+'<td><input type="text" name="purch_qty[]" class="form-control bg-light purch_qty" id="purch_qty'+i+'" data-id="'+i+'" style="border-width:0px"></td><td><input type="text" name="purch_price[]" class="form-control bg-light purch_price" id="purch_price'+i+'" data-id="'+i+'" style="border-width:0px"></td><td><input type="text" name="purch_amt[]" class="form-control bg-light" id="purch_amt'+i+'" style="border-width:0px"></td><td><input type="text" name="purch_selling_price[]" class="form-control bg-light" id="purch_selling_price'+i+'" style="border-width:0px"></td><td><input type="text" name="purch_batch[]" class="form-control bg-light" id="purch_batch'+i+'" style="border-width:0px"></td><td><input type="date" name="purch_expiry_date[]" class="form-control bg-light" id="purch_expiry_date'+i+'" style="border-width:0px"></td><td><a href="#" id="delete_purchase_item" data-id="'+i+'"><i class="fa fa-trash fa-sm"></i></a></td></tr>');
						}
					});
				});
			}

			function get_purchase_item_category()
			{
				$(document).on('change','.purch_item_id',function()
				{ 
					var category_id = $('option:selected', this).attr('data-value');
					var count = $(this).attr("data-id");
					$('#purch_cat_id'+count).val(category_id);
					var purch_item_id = $(this).val();
					
					$.ajax({
						url:'/layout/vouchers/purchases_item_price.php',
						method:'POST',
						data:{purch_item_id:purch_item_id, category_id:category_id},
						datatype:'JSON',
						success:function(data)
						{
							var res = $.parseJSON(data);
							$('#purch_selling_price'+count+'').val(res[0]);
						}
					});
				});
			}

			function get_purchase_item_amount()
			{
				$(document).on('change', '.purch_price, .purch_qty', function(){  
					   var total_current = $('#purch_amount').val();
					   var count = $(this).attr("data-id"); 
					   var qty = $('#purch_qty'+count).val();
					   var price = $('#purch_price'+count).val();
					   var amt_earlier = $('#purch_amt'+count).val();
					   var amt = qty * price;
					   $('#purch_amt'+count).val(amt);

					   var amount_item = parseFloat(amt);
					   if(amt_earlier == ''){var amt_previous = 0 }else{var amt_previous = parseFloat(amt_earlier)};
					   if(total_current == ''){var total_previous = 0 }else{var total_previous = parseFloat($('#purch_amount').val())};
					var total = total_previous + amount_item - amt_previous;
					   $('#purch_amount').val(total);
					   $('#purch_amount_2').val(total);
				   });
			}

			function delete_purchase_item_row()
			{
				$(document).on('click', '#delete_purchase_item', function(){  
					   var button_id = $(this).attr("data-id");
					   var total_current = $('#purch_amount').val();
					   var amt = $('#purch_amt'+button_id).val();
					   if(amt == ''){var amount_item = 0 }else{var amount_item = parseFloat($('#purch_amt'+button_id).val())};
					   if(total_current == ''){var total_previous = 0 }else{var total_previous = parseFloat($('#purch_amount').val())};
					var total = total_previous - amount_item;
					   $('#purch_amount').val(total);
					   $('#purch_amount_2').val(total);
					   $('#'+button_id+'').remove();

				   });
			}

			function save_purchase_invoice()
			{
				$(document).on('click','#purch_save_btn',function(e){
					e.preventDefault();
					var last_tr_id = $("#purchase_items_table tr:last").attr("id");
					var last_tr_select = $("#purchase_items_table tr:last option:selected").val();
					if(last_tr_select =="" || last_tr_select ==0)
					{
						$('#'+last_tr_id+'').remove();
					};
					var purch_debit = $('#purch_debit').val();
					var purch_credit = $('#purch_credit').val();
					var purch_amount = $('#purch_amount').val();
					var purch_supplied_by = $('#purch_supplied_by').val();
					var purch_ref_no = $('#purch_ref_no').val();
					var purch_date = $('#purch_date').val();
					var purch_received_by = $('#purch_received_by').val();
					var purch_narration = $('#purch_narration').val();
					var purch_desc = $('#purch_desc').val();
					if (purch_debit !=="") 
					{
						if (purch_credit !=="") 
						{
							if (purch_amount !=="") 
							{
								if (purch_supplied_by !=="") 
								{
									if (purch_ref_no !=="") 
									{
										if (purch_date !=="") 
										{
											if (purch_received_by !=="") 
											{
												if (purch_desc !=="") 
												{
													$.ajax({
														 url:'/layout/vouchers/purchases_save.php',
														 method:'POST',
														 data:$('#purchases_create_form').serialize(),
														 success:function(data)
															 {
																 $('#purchases_create_form').trigger('reset');
																 window.location.href="/layout/vouchers/purchases_list.php";
															 }
														 });
												} 
												else 
												{
													alert('Please select an item purchased!');
												}
											} 
											else 
											{
												alert('Please type the name of the person receiving the goods!');
											}
										} 
										else 
										{
											alert('Please select the date of purchase!');
										}
									} 
									else 
									{
										alert('Please type the supplier invoice number!');
									}
								} 
								else 
								{
									alert('Please type the name of the person/institution from whom the purchase was made!');
								}
							} 
							else 
							{
								alert('Please type price for each item purhased!');
							}
						} 
						else 
						{
							alert('Please select the ledger from which the purchase was made (Supplier or Cash Account)!');
						}
					} 
					else 
					{
						alert('Please select the ledger into which the purchase was made (Purchases Account)!');
					};
				});
			}

			function edit_purchase_invoice()
			{
				$(document).on('click','#btn_edit_purchase',function(){
					var purchase_id = $(this).attr('data-id');
					$.ajax({
						 url:'/layout/vouchers/purchases_edit.php',
						 method:'POST',
						 data:{purchase_id:purchase_id},
						 datatype:'JSON',
						 success:function(data)
							 {
								 var res = $.parseJSON(data);
								 $('#purchase_id').val(res[0]);
								 $('#purch_date').val(res[1]);
								 $('#purch_debit').val(res[2]);
								 $('#purch_credit').val(res[3]);
								 $('#purch_amount').val(res[4]);
								 $('#purch_amount_2').val(res[4]);
								 $('#purch_ref_no').val(res[5]);
								 $('#purch_supplied_by').val(res[6]);
								 $('#purch_received_by').val(res[7]);
								 $('#purch_narration').val(res[8]);
								 $.ajax({
									url:'/layout/vouchers/purchases_items_edit.php',
									method:'POST',
									data:{purchase_id:purchase_id},
									success:function(data)
									{
										$('#purchase_items_list').html(data);
									}
								 });
								 $('#purch_update_btn').show();
								 $('#purch_save_btn').hide();
								$('#purchase_create_modal').modal('show');
							 }
						 });
				});
			}

			function update_purchase_invoice()
			{
				$(document).on('click','#purch_update_btn',function(e){
					e.preventDefault();

					var last_tr_id = $("#purchase_items_table tr:last").attr("id");
					var last_tr_select = $("#purchase_items_table tr:last option:selected").val();
					if(last_tr_select =="" || last_tr_select ==0)
					{
						$('#'+last_tr_id+'').remove();
					};
					var purch_debit = $('#purch_debit').val();
					var purch_credit = $('#purch_credit').val();
					var purch_amount = $('#purch_amount').val();
					var purch_supplied_by = $('#purch_supplied_by').val();
					var purch_ref_no = $('#purch_ref_no').val();
					var purch_date = $('#purch_date').val();
					var purch_received_by = $('#purch_received_by').val();
					var purch_narration = $('#purch_narration').val();
					var purch_desc = $('#purch_desc').val();
					if (purch_debit !=="") 
					{
						if (purch_credit !=="") 
						{
							if (purch_amount !=="") 
							{
								if (purch_supplied_by !=="") 
								{
									if (purch_ref_no !=="") 
									{
										if (purch_date !=="") 
										{
											if (purch_received_by !=="") 
											{
												if (purch_desc !=="") 
												{
													$.ajax({
														 url:'/layout/vouchers/purchases_update.php',
														 method:'POST',
														 data:$('#purchases_create_form').serialize(),
														 success:function(data)
															 {
																 $('#purchases_create_form').trigger('reset');
																 window.location.href="/layout/vouchers/purchases_list.php";
															 }
														 });
												} 
												else 
												{
													alert('Please select an item purchased!');
												}
											} 
											else 
											{
												alert('Please type the name of the person receiving the goods!');
											}
										} 
										else 
										{
											alert('Please select the date of purchase!');
										}
									} 
									else 
									{
										alert('Please type the supplier invoice number!');
									}
								} 
								else 
								{
									alert('Please type the name of the person/institution from whom the purchase was made!');
								}
							} 
							else 
							{
								alert('Please type price for each item purhased!');
							}
						} 
						else 
						{
							alert('Please select the ledger from which the purchase was made (Supplier or Cash Account)!');
						}
					} 
					else 
					{
						alert('Please select the ledger into which the purchase was made (Purchases Account)!');
					};
				});
			}
			
			function delete_purchase_invoice()
			{
				$(document).on('click','#btn_delete_purchase',function(){
					var purchase_id = $(this).attr('data-id2');
					$('#purchase_delete_question').text('Are you sure you want to delete');
					$('#purchase_delete_modal').modal('show');
					$(document).on('click','#purchase_delete_yes',function(){
						$.ajax({  
							url:'/layout/vouchers/purchases_delete.php',  
							type:'POST',  
							data:{purchase_id:purchase_id},
							success:function(){
								$('#purchase_delete_modal').modal('hide');
								window.location.href="/layout/vouchers/purchases_list.php";
							}  
						});
					});
					$(document).on('click','#purchase_delete_no',function(){
						$('#purchase_delete_modal').modal('hide');
					});
				});
			}