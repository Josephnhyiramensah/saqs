$(document).ready(function()
{
	//STOCK TRANSFER
		stock_transfer_modal_requisition();
		save_stock_transfer_voucher();
		edit_stock_transfer_voucher();
		update_stock_transfer_voucher();
		new_stock_transfer_modal();
		//cancel_stock_transfer_modal();
		add_stock_transfer_item_row();
		get_stock_transfer_item_category();
		delete_stock_transfer_item_row();
		//stock_transfer_modal_direct();
		//stock_transfer_batch_list();
});

			//STOCK TRANSFER
			function stock_transfer_modal_requisition()
			{
				$(document).on('click','#btn_transfer_stock_req',function()
				{
					var stock_req_id = $(this).attr('data-id');
					$.ajax({
							 url:'/layout/vouchers/stock_requisition_check_transfer.php',
							 method:'POST',
							 data:{stock_req_id:stock_req_id},
							 success:function(data)
								{
									if (data == "transferred") 
									{
										alert("The requisition has already been transferred!");
									}
									else if (data == "none")
									{
										$.ajax({
											 url:'/layout/vouchers/stock_requisition_edit.php',
											 method:'POST',
											 data:{stock_req_id:stock_req_id},
											 datatype:'JSON',
											 success:function(data)
												 {
													 var res = $.parseJSON(data);
													 $('#stock_req_id_trans').val(res[0]);
													 $('#stock_trans_to').val(res[1]);
													 $('#stock_trans_from').val(res[2]);
													 $('#stock_req_date').val(res[3]);
													 $('#stk_trans_requested_by').val(res[4]);
													 $.ajax({
														 url:'/layout/vouchers/stock_transfer_items_requested.php',
														 method:'POST',
														 data:{stock_req_id:stock_req_id},
														 success:function(data)
															{
																$('#stock_transfer_items_list').html(data);
															}
													 });
													 $('#stock_trans_update_btn').hide();
													$('#stock_trans_save_btn').show();
													$('#stock_transfer_create_modal').modal('show');
												 }
											 });
									};
								}
						 });
				});
			}

			function save_stock_transfer_voucher()
			{
				$(document).on('click','#stock_trans_save_btn',function(e){
					e.preventDefault();
					var last_tr_id = $("#stock_transfer_items_table tr:last").attr("id");
					var last_tr_select = $("#stock_transfer_items_table tr:last option:selected").val();
					if(last_tr_select =="" || last_tr_select ==0)
					{
						$('#'+last_tr_id+'').remove();
					};
					var stk_trans_date = $('#stk_trans_date').val();
					var stock_trans_from = $('#stock_trans_from').val();
					var stock_trans_to = $('#stock_trans_to').val();
					var stk_trans_date = $('#stk_trans_date').val();
					var stk_trans_transferred_by = $('#stk_trans_transferred_by').val();
					var stk_trans_requested_by = $('#stk_trans_requested_by').val();
					var stk_trans_collected_by = $('#stk_trans_collected_by').val();
					if (stock_trans_to !=="") 
					{
						if (stock_trans_from !=="") 
						{
							if (stock_trans_from !==stock_trans_to) 
							{
								if (stk_trans_transferred_by !=="") 
								{
									if (stk_trans_requested_by !=="") 
									{
										if (stk_trans_date !=="") 
										{
											$.ajax({
												 url:'/layout/vouchers/stock_transfer_save.php',
												 method:'POST',
												 data:$('#stock_transfer_create_form').serialize(),
												 success:function(data)
													 {
														 $('#stock_transfer_create_form').trigger('reset');
														 window.location.href="/layout/vouchers/stock_transfer_list.php";
													 }
											});
										} 
										else 
										{
											alert('Please type the date of the transaction!');
										}
									} 
									else 
									{
										alert('Please type the name of the person making the request!');
									}
								} 
								else 
								{
									alert('Please type name of the person making transfer!');
								}	
							} 
							else 
							{
								alert('Please the location this transfer is being made from and location made to cannot be the same!');
							}
						} 
						else 
						{
							alert('Please select the location from which this transfer is being made!');
						}
					} 
					else 
					{
						alert('Please select the location the transfer is being made!');
					};
				});
			}

			function edit_stock_transfer_voucher()
			{
				$(document).on('click','#btn_edit_stk_trans',function(){
					var stock_trans_id = $(this).attr('data-id');
					$.ajax({
						url:'/layout/vouchers/stock_transfer_edit.php',
						method:'POST',
						data:{stock_trans_id:stock_trans_id},
						datatype:'JSON',
						success:function(data)
							{
							var res = $.parseJSON(data);
							$('#stock_trans_id').val(res[0]);
							$('#stock_req_id_trans').val(res[1]);
							$('#stock_trans_from').val(res[2]);
							$('#stock_trans_to').val(res[3]);
							$('#stk_trans_date').val(res[4]);
							$('#stock_req_date').val(res[5]);
							$('#stk_trans_requested_by').val(res[6]);
							$('#stk_trans_approved_by').val(res[7]);
							$('#stk_trans_transferred_by').val(res[8]);
							$('#stk_trans_collected_by').val(res[9]);
							$('#stk_trans_narration').val(res[10]);
							$.ajax({
									url:'/layout/vouchers/stock_transfer_items_edit.php',
									method:'POST',
									data:{stock_trans_id:stock_trans_id},
									success:function(data)
									{
										$('#stock_transfer_items_list').html(data);
									}
								});
							$('#stock_trans_update_btn').show();
							$('#stock_trans_save_btn').hide();
							$('#stock_transfer_create_modal').modal('show');
							}
						});
				});
			}

			function update_stock_transfer_voucher()
			{
				$(document).on('click','#stock_trans_update_btn',function(e){
					e.preventDefault();
					var last_tr_id = $("#stock_transfer_items_table tr:last").attr("id");
					var last_tr_select = $("#stock_transfer_items_table tr:last option:selected").val();
					if(last_tr_select =="" || last_tr_select ==0)
					{
						$('#'+last_tr_id+'').remove();
					};
					var stock_trans_from = $('#stock_trans_from').val();
					var stock_trans_to = $('#stock_trans_to').val();
					var stk_trans_date = $('#stk_trans_date').val();
					var stk_trans_transferred_by = $('#stk_trans_transferred_by').val();
					var stk_trans_requested_by = $('#stk_trans_requested_by').val();
					var stk_trans_collected_by = $('#stk_trans_collected_by').val();
					if (stock_trans_to !=="") 
					{
						if (stock_trans_from !=="") 
						{
							if (stock_trans_from !==stock_trans_to) 
							{
								if (stk_trans_transferred_by !=="") 
								{
									if (stk_trans_requested_by !=="") 
									{
										$.ajax({
											 url:'/layout/vouchers/stock_transfer_update.php',
											 method:'POST',
											 data:$('#stock_transfer_create_form').serialize(),
											 success:function(data)
												 {
													 $('#stock_transfer_create_form').trigger('reset');
													$('#stock_transfer_create_modal').modal('hide');
													 window.location.href="/layout/vouchers/stock_transfer_list.php";
												 }
										});	
									} 
									else 
									{
										alert('Please type the name of the person making the request!');
									}
								} 
								else 
								{
									alert('Please type name of the person making transfer!');
								}	
							} 
							else 
							{
								alert('Please the location this transfer is being made from and location made to cannot be the same!');
							}
						} 
						else 
						{
							alert('Please select the location from which this transfer is being made!');
						}
					} 
					else 
					{
						alert('Please select the location the transfer is being made!');
					};
				});
			}

			function new_stock_transfer_modal()
			{
				$(document).on('click','#new_stock_transfer_icon',function()
				{
					$('#stock_trans_update_btn').hide();
					$('#stock_trans_save_btn').show();
					$.ajax({
						url:'/layout/vouchers/stock_transfer_item_initial.php',
						method:'POST',
						data:{i:1},
						success:function(data)
						{
							$('#stock_transfer_items_list').html(data);
						}
					});
					$('#stock_transfer_create_form').trigger('reset');
					$('#stock_transfer_create_modal').modal('show');
				});
			}

			/*function cancel_stock_transfer_modal()
			{
				$(document).on('click','#stock_trans_cancel_btn',function()
				{
					$('#stock_transfer_create_form').trigger('reset');
					$('#stock_transfer_create_modal').modal('hide');
					window.location.href="/layout/vouchers/stock_transfer_list.php";
				});
			}*/

			function add_stock_transfer_item_row()
			{
				$(document).on('change','.stk_trans_item_id',function(){ 
					var i = $('#stock_transfer_items_table tr:last').attr('id');
					i++;
					$.ajax({
						url:'/layout/vouchers/stock_transfer_item_list.php',
						method:'POST',
						data:{i:i},
						success:function(data)
						{
							$('#stock_transfer_items_table').append(data);
						}
					});
				});
			}

			function get_stock_transfer_item_category()
			{
				$(document).on('change','.stk_trans_item_id',function(){ 

					var category_id = $('option:selected', this).attr('data-value');
					var count = $(this).attr("data-id");
					$('#item_cat_id'+count).val(category_id);
				});
			}

			function delete_stock_transfer_item_row()
			{
				$(document).on('click', '#delete_stk_trans_item', function(){  
					   var button_id = $(this).attr("data-id");
					   $('#'+button_id+'').remove();

				   });
			}

			/*function stock_transfer_modal_direct()
			{
				$(document).on('click','#new_stock_transfer_icon',function()
				{
					$('#stock_trans_update_btn').hide();
					$('#stock_trans_save_btn').show();
					$('#stock_transfer_create_form').trigger('reset');
					$('#stock_transfer_create_modal').modal('show');
				});
			}*/

			/*function stock_transfer_batch_list()
			{
				$(document).on('change','.stk_trans_item_id',function()
				{
					var count = $(this).val('data-id');
					var item_id = $('#stk_trans_item_id'+count).val();
					var category_id = $('#item_cat_id'+count).val();
					$.ajax(
					{
						url: '/layout/vouchers/stock_transfer_batch_list.php',
						method: 'POST',
						data: {item_id:item_id, category_id:category_id},
						datatype: 'JSON',
						success: function(data)
						{
							var res = $.parseJSON(data);
							$('#stock_trans_batch_no'+count).html('<option value="0">Please select</option>');
							for (var i=0, l=res.length; i<l;i+=2)
							{
								var oddPositionVal = res[i];
								var evenPositionVal = res[i+1];
								var rowhtml = '<option value=' + oddPositionVal + '>' + evenPositionVal + '</option>';
								$('#stock_trans_batch_no'+count).append(rowhtml);
							}
						}
					});
				});
			}*/
		