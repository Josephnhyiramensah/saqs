$(document).ready(function()
{
	//STOCK_SALES
		new_stock_sales_modal();
		cancel_stock_sales_modal();
		add_stock_sales_item_row();
		get_stock_sales_item_category();
		add_stock_sales_item_price();
		get_stock_sales_item_amount();
		delete_stock_sales_item_row();
		save_stock_sales_invoice();
		edit_stock_sales_invoice();
		update_stock_sales_invoice();
});

			//STOCK_SALES
			function new_stock_sales_modal()
			{
				$(document).on('click','#new_stock_sales_icon',function()
				{
					$('#stock_sales_update_btn').hide();
					$('#stock_sales_save_btn').show();
					$('#stock_sales_create_form').trigger('reset');
					$('#stock_sales_create_modal').modal('show');
				});
			}

			function cancel_stock_sales_modal()
			{
				$(document).on('click','#stock_sales_cancel_btn',function()
				{
					$('#stock_sales_create_form').trigger('reset');
					$('#stock_sales_create_modal').modal('hide');
					window.location.href="/layout/vouchers/stock_sales_list.php";
				});
			}

			function add_stock_sales_item_row()
			{
				$(document).on('change','.stock_sales_desc',function(){ 
					var i = $('#stock_sales_items_table tr:last').attr('id');
					i++;
					$.ajax({
						url:'/layout/vouchers/stock_sales_item_list.php',
						method:'POST',
						data:{i:i},
						success:function(data)
						{
							$('#stock_sales_items_table').append('<tr id="'+i+'">'+data+'<td><input type="text" name="stock_sales_qty[]" class="form-control bg-light stock_sales_qty" id="stock_sales_qty'+i+'" data-id="'+i+'" style="border-width:0px"></td><td><input type="text" name="stock_sales_price[]" class="form-control bg-light stock_sales_price" id="stock_sales_price'+i+'" data-id="'+i+'" style="border-width:0px"></td><td><input type="text" name="stock_sales_amt[]" class="form-control bg-light" id="stock_sales_amt'+i+'" style="border-width:0px"></td><td><input type="text" name="stock_sales_batch[]" class="form-control bg-light" id="stock_sales_batch'+i+'" style="border-width:0px"></td><td><input type="date" name="stock_sales_expiry_date[]" class="form-control bg-light" id="stock_sales_expiry_date'+i+'" style="border-width:0px"></td><td><a href="#" id="delete_stock_sales_item" data-id="'+i+'"><i class="fa fa-trash fa-sm"></i></a></td></tr>');
						}
					});
				});
			}

			function get_stock_sales_item_category()
			{
				$(document).on('change','.stock_sales_desc',function(){ 

					var category_id = $('option:selected', this).attr('data-value');
					var count = $(this).attr("data-id");
					$('#stock_sales_cat_id'+count).val(category_id);
				});
			}

			function add_stock_sales_item_price()
			{
				$(document).on('change','.stock_sales_desc',function(){
					var category_id = $('option:selected', this).attr('data-value');
					var i = $(this).attr("data-id");
					var stock_item_id = $('#stock_sales_desc'+i+'').val();
					$.ajax({
						 url:'/layout/vouchers/stock_sales_item_price.php',
						 method:'POST',
						 data:{stock_item_id:stock_item_id,category_id:category_id},
						 datatype:'JSON',
						 success:function(data)
						 {
							 var res = $.parseJSON(data);
							 $('#stock_sales_price'+i+'').val(res[0]);
						 }
					});
				});
			}

			function get_stock_sales_item_amount()
			{
				$(document).on('change keyup', '.stock_sales_price, .stock_sales_qty', function(){  
					   var total_current = $('#stock_sales_amount').val();
					   var count = $(this).attr("data-id"); 
					   var qty = $('#stock_sales_qty'+count).val();
					   var price = $('#stock_sales_price'+count).val();
					   var amt_earlier = $('#stock_sales_amt'+count).val();
					   var amt = qty * price;
					   $('#stock_sales_amt'+count).val(amt);

					   var amount_item = parseFloat(amt);
					   if(amt_earlier == ''){var amt_previous = 0 }else{var amt_previous = parseFloat(amt_earlier)};
					   if(total_current == ''){var total_previous = 0 }else{var total_previous = parseFloat($('#stock_sales_amount').val())};
					var total = total_previous + amount_item - amt_previous;
					   $('#stock_sales_amount').val(total);
					   $('#stock_sales_amount_2').val(total);
				   });
			}

			function delete_stock_sales_item_row()
			{
				$(document).on('click', '#delete_stock_sales_item', function()
				{  
					   var button_id = $(this).attr("data-id");
					   var total_current = $('#stock_sales_amount').val();
					   var amt = $('#stock_sales_amt'+button_id).val();
					   if(amt == ''){var amount_item = 0 }else{var amount_item = parseFloat($('#stock_sales_amt'+button_id).val())};
					   if(total_current == ''){var total_previous = 0 }else{var total_previous = parseFloat($('#stock_sales_amount').val())};
					var total = total_previous - amount_item;
					   $('#stock_sales_amount').val(total);
					   $('#stock_sales_amount_2').val(total);
					   $('#'+button_id+'').remove();
				   });
			}

			function save_stock_sales_invoice()
			{
				$(document).on('click','#stock_sales_save_btn',function(e){
					e.preventDefault();
					var last_tr_id = $("#stock_sales_items_table tr:last").attr("id");
					var last_tr_select = $("#stock_sales_items_table tr:last option:selected").val();
					if(last_tr_select =="" || last_tr_select ==0)
					{
						$('#'+last_tr_id+'').remove();
					};
					var stock_sales_debit = $('#stock_sales_debit').val();
					var stock_sales_credit = $('#stock_sales_credit').val();
					var stock_sales_amount = $('#stock_sales_amount').val();
					var stock_sales_supplied_by = $('#stock_sales_supplied_by').val();
					var stock_sales_ref_no = $('#stock_sales_ref_no').val();
					var stock_sales_date = $('#stock_sales_date').val();
					var stock_sales_received_by = $('#stock_sales_received_by').val();
					var stock_sales_narration = $('#stock_sales_narration').val();
					var stock_sales_desc = $('#stock_sales_desc').val();
					if (stock_sales_debit !=="") 
					{
						if (stock_sales_credit !=="") 
						{
							if (stock_sales_amount !=="") 
							{
								if (stock_sales_supplied_by !=="") 
								{
									if (stock_sales_ref_no !=="") 
									{
										if (stock_sales_date !=="") 
										{
											if (stock_sales_received_by !=="") 
											{
												if (stock_sales_desc !=="") 
												{
													$.ajax({
														 url:'/layout/vouchers/stock_sales_save.php',
														 method:'POST',
														 data:$('#stock_sales_create_form').serialize(),
														 success:function(data)
															 {
																 $('#stock_sales_create_form').trigger('reset');
																 window.location.href="/layout/vouchers/stock_sales_list.php";
															 }
														 });
												} 
												else 
												{
													alert('Please select an item sold!');
												}
											} 
											else 
											{
												alert('Please type the name of the person receiving the goods!');
											}
										} 
										else 
										{
											alert('Please select the date of sales!');
										}
									} 
									else 
									{
										alert('Please type the supplier invoice number!');
									}
								} 
								else 
								{
									alert('Please type the name of the person/institution from whom the sales was made!');
								}
							} 
							else 
							{
								alert('Please type price for each item sold!');
							}
						} 
						else 
						{
							alert('Please select the ledger from which the sales was made (Supplier or Cash Account)!');
						}
					} 
					else 
					{
						alert('Please select the ledger into which the sales was made (Purchases Account)!');
					};
				});
			}

			function edit_stock_sales_invoice()
			{
				$(document).on('click','#btn_edit_stock_sales',function(){
					var stock_sales_id = $(this).attr('data-id');
					$.ajax({
						 url:'/layout/vouchers/stock_sales_edit.php',
						 method:'POST',
						 data:{stock_sales_id:stock_sales_id},
						 datatype:'JSON',
						 success:function(data)
						 {
							 var res = $.parseJSON(data);
							 $('#stock_sales_id').val(res[0]);
							 $('#stock_sales_date').val(res[1]);
							 $('#stock_sales_debit').val(res[2]);
							 $('#stock_sales_credit').val(res[3]);
							 $('#stock_sales_amount').val(res[4]);
							 $('#stock_sales_amount_2').val(res[4]);
							 $('#stock_sales_ref_no').val(res[5]);
							 $('#stock_sales_supplied_by').val(res[6]);
							 $('#stock_sales_received_by').val(res[7]);
							 $('#stock_sales_narration').val(res[8]);
							 $.ajax({
								url:'/layout/vouchers/stock_sales_items_edit.php',
								method:'POST',
								data:{stock_sales_id:stock_sales_id},
								success:function(data)
								{
									$('#stock_sales_items_list').html(data);
								}
							 });
							 $('#stock_sales_update_btn').show();
							 $('#stock_sales_save_btn').hide();
							$('#stock_sales_create_modal').modal('show');
						 }
					});
				});
			}

			function update_stock_sales_invoice()
			{
				$(document).on('click','#stock_sales_update_btn',function(e){
					e.preventDefault();

					var last_tr_id = $("#stock_sales_items_table tr:last").attr("id");
					var last_tr_select = $("#stock_sales_items_table tr:last option:selected").val();
					if(last_tr_select =="" || last_tr_select ==0)
					{
						$('#'+last_tr_id+'').remove();
					};
					var stock_sales_debit = $('#stock_sales_debit').val();
					var stock_sales_credit = $('#stock_sales_credit').val();
					var stock_sales_amount = $('#stock_sales_amount').val();
					var stock_sales_supplied_by = $('#stock_sales_supplied_by').val();
					var stock_sales_ref_no = $('#stock_sales_ref_no').val();
					var stock_sales_date = $('#stock_sales_date').val();
					var stock_sales_received_by = $('#stock_sales_received_by').val();
					var stock_sales_narration = $('#stock_sales_narration').val();
					var stock_sales_desc = $('#stock_sales_desc').val();
					if (stock_sales_debit !=="") 
					{
						if (stock_sales_credit !=="") 
						{
							if (stock_sales_amount !=="") 
							{
								if (stock_sales_supplied_by !=="") 
								{
									if (stock_sales_ref_no !=="") 
									{
										if (stock_sales_date !=="") 
										{
											if (stock_sales_received_by !=="") 
											{
												if (stock_sales_desc !=="") 
												{
													$.ajax({
														url:'/layout/vouchers/stock_sales_update.php',
														method:'POST',
														data:$('#stock_sales_create_form').serialize(),
														success:function(data)
														{
															$('#stock_sales_create_form').trigger('reset');
															window.location.href="/layout/vouchers/stock_sales_list.php";
														}
													});
												} 
												else 
												{
													alert('Please select an item sold!');
												}
											} 
											else 
											{
												alert('Please type the name of the person receiving the goods!');
											}
										} 
										else 
										{
											alert('Please select the date of sales!');
										}
									} 
									else 
									{
										alert('Please type the supplier invoice number!');
									}
								} 
								else 
								{
									alert('Please type the name of the person/institution from whom the sales was made!');
								}
							} 
							else 
							{
								alert('Please type price for each item sold!');
							}
						} 
						else 
						{
							alert('Please select the ledger from which the sales was made (Supplier or Cash Account)!');
						}
					} 
					else 
					{
						alert('Please select the ledger into which the sales was made (Purchases Account)!');
					};
				});
			}