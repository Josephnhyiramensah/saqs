$(document).ready(function()
{
	//CONSUMABLES
		new_consumable_modal();
		save_new_consumable();
		edit_consumable();
		update_consumable();
});

	//SETUP CONSUMABLES
	function new_consumable_modal()
	{
		$(document).on('click','#new_consum_icon',function()
		{
			$('#consum_update_btn').hide();
			$('#consum_save_btn').show();
			$('#consum_cancel_btn').show();
			$('#consumable_create_form').trigger('reset');
			$('#consumable_create_modal').modal('show');
		});
	}

	function save_new_consumable()
	{
		$(document).on('click','#consum_save_btn',function(){
			var consum_name = $('#consum_name').val();
			if (consum_name !=="") 
			{
				$.ajax({
					 url:'/layout/items/consum_save.php',
					 method:'POST',
					 data:$('#consumable_create_form').serialize(),
					 success:function(data){
						 $('#consumable_create_modal').modal('hide');
						 $('#consumable_create_form').trigger('reset');
						 $('#consum_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Consumable Description cannot be EMPTY!');
			};
		});
	}

	function edit_consumable()
	{
		$(document).on('click','#btn_edit_consum',function()
		{
			var con_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/items/consum_edit.php',
				 method:'POST',
				 data:{con_id:con_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $('#con_id').val(res[0]);
					 $('#consum_name').val(res[2]);
					 $('#type').val(res[1]);
					 $('#price_cash').val(res[3]);
					 $('#price_nhis').val(res[4]);
					 $('#price_prvt').val(res[5]);
					 $('#unit_of_measure').val(res[6]);
					 $('#manufacturer').val(res[7]);
					 $('#block_neg').val(res[8]);
					 $('#expiry_date').val(res[9]);
					 $('#batch').val(res[10]);
					 $('#days_prompt').val(res[11]);
					 $('#eoq').val(res[12]);
					 $('#min_level').val(res[13]);
					 $('#max_level').val(res[14]);
					 $('#re_order_level').val(res[15]);
					 $('#consum_update_btn').show();
					$('#consum_save_btn').hide();
					$('#consumable_create_modal_header').html('Consumable Edit');
					$('#consumable_create_modal').modal('show');
				 }
			 });
		});
	}

	function update_consumable()
	{
		$(document).on('click','#consum_update_btn',function(){
			var consum_name = $('#consum_name').val();
			if (consum_name !=="") 
			{
				$.ajax({
					 url:'/layout/items/consum_update.php',
					 method:'POST',
					 data:$('#consumable_create_form').serialize(),
					 success:function(data){
						 $('#consumable_create_modal').modal('hide');
						 $('#consumable_create_form').trigger('reset');
						 $('#consum_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Consumable Description cannot be EMPTY!');
			};
		});
	}
