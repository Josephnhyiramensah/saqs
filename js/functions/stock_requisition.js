$(document).ready(function()
{
	//STOCK REQUISITION
		new_stock_requisition_modal();
		add_stock_requisition_item_row();
		cancel_stock_requisition_modal();
		get_stock_requisition_item_category();
		delete_stock_requisition_item_row();
		save_stock_requisition_voucher();
		edit_stock_requisition_voucher();
		update_stock_requisition_voucher();
});

			//STOCK REQUISITION
			function new_stock_requisition_modal()
			{
				$(document).on('click','#new_stock_requisition_icon',function()
				{
					$('#stock_req_update_btn').hide();
					$('#stock_req_save_btn').show();
					$('#stock_requisition_create_form').trigger('reset');
					$('#stock_requisition_create_modal').modal('show');
				});
			}

			function cancel_stock_requisition_modal()
			{
				$(document).on('click','#stock_req_cancel_btn',function()
				{
					$('#stock_requisition_create_form').trigger('reset');
					$('#stock_requisition_create_modal').modal('hide');
					window.location.href="/layout/vouchers/stock_requisition_list.php";
				});
			}

			function add_stock_requisition_item_row()
			{
				$(document).on('change','.stk_req_item_id',function(){ 
					var i = $('#stock_requisition_items_table tr:last').attr('id');
					i++;
					$.ajax({
						url:'/layout/vouchers/stock_requisition_item_list.php',
						method:'POST',
						data:{i:i},
						success:function(data)
						{
							$('#stock_requisition_items_table').append('<tr id="'+i+'">'+data+'</tr>');
						}
					});
				});
			}

			function get_stock_requisition_item_category()
			{
				$(document).on('change','.stk_req_item_id',function(){ 
					var category_id = $('option:selected', this).attr('data-value');
					var count = $(this).attr("data-id");
					$('#item_cat_id'+count).val(category_id);
				});
			}

			function delete_stock_requisition_item_row()
			{
				$(document).on('click', '#delete_stk_req_item', function(){  
					   var button_id = $(this).attr("data-id");
					   $('#'+button_id+'').remove();

				   });
			}

			function save_stock_requisition_voucher()
			{
				$(document).on('click','#stock_req_save_btn',function(e){
					e.preventDefault();
					var last_tr_id = $("#stock_requisition_items_table tr:last").attr("id");
					var last_tr_select = $("#stock_requisition_items_table tr:last option:selected").val();
					if(last_tr_select =="" || last_tr_select ==0)
					{
						$('#'+last_tr_id+'').remove();
					};
					var stock_req_from = $('#stock_req_from').val();
					var stock_req_to = $('#stock_req_to').val();
					var stk_req_date = $('#stk_req_date').val();
					if (stock_req_to !=="") 
					{
						if (stock_req_from !=="") 
						{
							if (stock_req_from !==stock_req_to) 
							{
								$.ajax({
									 url:'/layout/vouchers/stock_requisition_save.php',
									 method:'POST',
									 data:$('#stock_requisition_create_form').serialize(),
									 success:function(data)
										 {
											 $('#stock_requisition_create_form').trigger('reset');
											 window.location.href="/layout/vouchers/stock_requisition_list.php";
										 }
								});		
							} 
							else 
							{
								alert('Please the location this requisition is being made from and location made to cannot be the same!');
							}
						} 
						else 
						{
							alert('Please select the location from which this requisition is being made!');
						}
					} 
					else 
					{
						alert('Please select the location the requisition is being made!');
					};
				});
			}

			function edit_stock_requisition_voucher()
			{
				$(document).on('click','#btn_edit_stock_req',function(){
					var stock_req_id = $(this).attr('data-id');
					$.ajax({
							 url:'/layout/vouchers/stock_requisition_check_transfer.php',
							 method:'POST',
							 data:{stock_req_id:stock_req_id},
							 success:function(data)
								{
									if (data == "transferred") 
									{
										alert("The requisition has been served, editing is therefore not allowed!");
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
													 $('#stock_req_id').val(res[0]);
													 $('#stock_req_from').val(res[1]);
													 $('#stock_req_to').val(res[2]);
													 $('#stk_req_date').val(res[3]);
													 $('#stk_req_requested_by').val(res[4]);
													 //$('#').val(res[5]);
													 $('#stk_req_narration').val(res[6]);
													 $.ajax({
														 url:'/layout/vouchers/stock_requisition_items_edit.php',
														 method:'POST',
														 data:{stock_req_id:stock_req_id},
														 success:function(data)
															{
																$('#stock_requisition_items_list').html(data);
															}
													 });
													 $('#stock_req_update_btn').show();
													 $('#stock_req_save_btn').hide();
													$('#stock_requisition_create_modal').modal('show');
												 }
											 });
									};
								}
						 });
					
				});
			}

			function update_stock_requisition_voucher()
			{
				$(document).on('click','#stock_req_update_btn',function(e){
					e.preventDefault();
					var last_tr_id = $("#stock_requisition_items_table tr:last").attr("id");
					var last_tr_select = $("#stock_requisition_items_table tr:last option:selected").val();
					if(last_tr_select =="" || last_tr_select ==0)
					{
						$('#'+last_tr_id+'').remove();
					};
					var stock_req_from = $('#stock_req_from').val();
					var stock_req_to = $('#stock_req_to').val();
					var stk_req_date = $('#stk_req_date').val();
					if (stock_req_to !=="") 
					{
						if (stock_req_from !=="") 
						{
							if (stock_req_from !==stock_req_to) 
							{
								$.ajax({
									 url:'/layout/vouchers/stock_requisition_update.php',
									 method:'POST',
									 data:$('#stock_requisition_create_form').serialize(),
									 success:function(data)
										 {
											 $('#stock_requisition_create_form').trigger('reset');
											 window.location.href="/layout/vouchers/stock_requisition_list.php";
										 }
								});		
							} 
							else 
							{
								alert('Please the location this requisition is being made from and location made to cannot be the same!');
							}
						} 
						else 
						{
							alert('Please select the location from which this requisition is being made!');
						}
					} 
					else 
					{
						alert('Please select the location the requisition is being made!');
					};
				});
			}