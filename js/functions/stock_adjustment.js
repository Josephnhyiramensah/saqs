$(document).ready(function()
{
	//STOCK ADJUSTMENT
		new_stock_adjustment_modal();
		add_stock_adjustment_item_row();
		clear_adjustment_qty_in_or_out();
		cancel_stock_adjustment_modal();
		delete_stock_adjustment_item_row();
		save_stock_adjustment_voucher();
		edit_stock_adjustment_voucher();
		update_stock_adjustment_voucher();
		get_stock_adjustment_item_category();
		delete_stock_adjustment();
});

			//STOCK ADJUSTMENT
			function new_stock_adjustment_modal()
			{
				$(document).on('click','#new_stock_adjustment_icon', function()
				{
					$('#stock_adj_update_btn').hide();
					$('#stock_adj_save_btn').show();
					$('#stock_adjustment_create_form').trigger('reset');
					$('#stock_adjustment_create_modal').modal('show');
				});
			}

			function add_stock_adjustment_item_row()
			{
				$(document).on('change','.stk_adj_item_id',function(){ 
					var i = $('#stock_adjustment_items_table tr:last').attr('id');
					i++;
					$.ajax({
						url:'/layout/vouchers/stock_adjustment_item_list.php',
						method:'POST',
						data:{i:i},
						success:function(data)
						{
							$('#stock_adjustment_items_table').append('<tr id="'+i+'">'+data+'</tr>');
						}
					});
				});
			}

			function get_stock_adjustment_item_category()
			{
				$(document).on('change','.stk_adj_item_id',function(){ 
					var category_id = $('option:selected', this).attr('data-value');
					var count = $(this).attr("data-id");
					$('#item_cat_id'+count).val(category_id);
				});
			}

			function clear_adjustment_qty_in_or_out()
			{
				$(document).on('change click','.stk_adj_qty_in',function(){ 
					var i = $(this).closest('tr').attr('id');
					var qty_in = $('#stk_adj_qty_in'+i).val();
					if(qty_in !== "" && qty_in > 0)
					{
						$('#stk_adj_qty_out'+i).val(''); 
						$('#stk_adj_qty_out'+i).attr('hidden',true); 
					}
					else
					{
						$('#stk_adj_qty_out'+i).attr('hidden',false); 
					}
				});

				$(document).on('change click','.stk_adj_qty_out',function(){ 
					var i = $(this).closest('tr').attr('id');
					var qty_out = $('#stk_adj_qty_out'+i).val();
					if(qty_out !== "" && qty_out > 0)
					{
						$('#stk_adj_qty_in'+i).val(''); 
						$('#stk_adj_qty_in'+i).attr('hidden',true); 
					}
					else
					{
						$('#stk_adj_qty_in'+i).attr('hidden',false); 
					}
				});
			}

			function cancel_stock_adjustment_modal()
			{
				$(document).on('click','#stock_adj_cancel_btn',function()
				{
					$('#stock_adjustment_create_form').trigger('reset');
					$('#stock_adjustment_create_modal').modal('hide');
					window.location.href="/layout/vouchers/stock_adjustment_list.php";
				});
			}

			function delete_stock_adjustment_item_row()
			{
				$(document).on('click', '#delete_stk_adj_item', function(){  
					   var button_id = $(this).attr("data-id");
					   $('#'+button_id+'').remove();

				   });
			}

			function save_stock_adjustment_voucher()
			{
				$(document).on('click','#stock_adj_save_btn',function(e){
					e.preventDefault();
					var last_tr_id = $("#stock_adjustment_items_table tr:last").attr("id");
					var last_tr_select = $("#stock_adjustment_items_table tr:last option:selected").val();
					
					var stk_adj_adjusted_by = $('#stk_adj_adjusted_by').val();
					var stk_adj_narration = $('#stk_adj_narration').val();
					var stk_adj_date = $('#stk_adj_date').val();
					if (stk_adj_date !=="") 
					{
						if (stk_adj_adjusted_by !=="") 
						{
							if (stk_adj_narration !== "") 
							{
								if(last_tr_select == "" || last_tr_select == 0)
								{
									$('#'+last_tr_id+'').remove();
								};

								$.ajax({
									 url:'/layout/vouchers/stock_adjustment_save.php',
									 method:'POST',
									 data:$('#stock_adjustment_create_form').serialize(),
									 success:function(data)
										 {
											 $('#stock_adjustment_create_form').trigger('reset');
											 window.location.href="/layout/vouchers/stock_adjustment_list.php";
										 }
								});		
							} 
							else 
							{
								alert('Please the narration this Stock Adjustment Voucher cannot be the empty!');
							}
						} 
						else 
						{
							alert('Please Adjusted by of this Stock Adjustment Voucher cannot be the empty!');
						}
					} 
					else 
					{
						alert('Please select the Date for the Stock Adjustment Voucher is being made!');
					};
				});
			}

			function edit_stock_adjustment_voucher()
			{
				$(document).on('click','#btn_edit_stk_adj',function(){
					var stock_adj_id = $(this).attr('data-id');
					$.ajax({
						 url:'/layout/vouchers/stock_adjustment_edit.php',
						 method:'POST',
						 data:{stock_adj_id:stock_adj_id},
						 datatype:'JSON',
						 success:function(data)
							 {
								 var res = $.parseJSON(data);
								 $('#stock_adj_id').val(res[0]);
								 $('#stk_adj_ref_no').val(res[1]);
								 $('#stk_adj_date').val(res[2]);
								 $('#stk_adj_narration').val(res[3]);
								 $('#stk_adj_adjusted_by').val(res[4]);
								 $.ajax({
									 url:'/layout/vouchers/stock_adjustment_items_edit.php',
									 method:'POST',
									 data:{stock_adj_id:stock_adj_id},
									 success:function(data)
										{
											$('#stock_adjustment_items_list').html(data);
										}
								 });
								 $('#stock_adj_update_btn').show();
								 $('#stock_adj_save_btn').hide();
								$('#stock_adjustment_create_modal').modal('show');
							 }
					});
				});
			}

			function update_stock_adjustment_voucher()
			{
				$(document).on('click','#stock_adj_update_btn',function(e){
					e.preventDefault();
					var last_tr_id = $("#stock_adjustment_items_table tr:last").attr("id");
					var last_tr_select = $("#stock_adjustment_items_table tr:last option:selected").val();
					
					var stk_adj_adjusted_by = $('#stk_adj_adjusted_by').val();
					var stk_adj_narration = $('#stk_adj_narration').val();
					var stk_adj_date = $('#stk_adj_date').val();
					if (stk_adj_date !=="") 
					{
						if (stk_adj_adjusted_by !=="") 
						{
							if (stk_adj_narration !== "") 
							{
								if(last_tr_select == "" || last_tr_select == 0)
								{
									$('#'+last_tr_id+'').remove();
								};
								$.ajax({
									 url:'/layout/vouchers/stock_adjustment_update.php',
									 method:'POST',
									 data:$('#stock_adjustment_create_form').serialize(),
									 success:function(data)
										 {
											 $('#stock_adjustment_create_form').trigger('reset');
											 window.location.href="/layout/vouchers/stock_adjustment_list.php";
										 }
								});		
							} 
							else 
							{
								alert('Please the narration this Stock Adjustment Voucher cannot be the empty!');
							}
						} 
						else 
						{
							alert('Please Adjusted by of this Stock Adjustment Voucher cannot be the empty!');
						}
					} 
					else 
					{
						alert('Please select the Date for the Stock Adjustment Voucher is being made!');
					};
				});
			}

			function delete_stock_adjustment()
			{
				$(document).on('click','#btn_delete_stk_adj',function(){
					var stock_adj_id = $(this).attr('data-id');
					var currentRow=$(this).closest("tr");
					var lab = currentRow.find("td:eq(1)").text();
					$('#stock_adjustment_delete_question').text('Are you sure you want to delete Stock Adjustment No:' + stock_adj_id + '?');
					$('#stock_adjustment_delete_modal').modal('show');
					$(document).on('click','#stk_adj_del_yes',function(){
						$.ajax({  
							 url:'/layout/vouchers/stock_adjustment_delete.php',  
							 type:'POST',  
							 data:{stock_adj_id:stock_adj_id},
							 success:function(){
								 $('#stock_adjustment_delete_modal').modal('hide');
								 window.location.href="/layout/vouchers/stock_adjustment_list.php";
							 }  
						});
					  });
					$(document).on('click','#stk_adj_del_no',function(){
						$('#stock_adjustment_delete_modal').modal('hide');
					});
				});
			}