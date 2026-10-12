$(document).ready(function()
{
	//PRICELIST
		new_price_list();
		save_price_list();
		edit_price_list();
		update_price_list();
});

	//PRICELIST
	function new_price_list()
	{
		$(document).on('click','#btn_new_pricelist',function(){
			var ledger_id = $(this).attr('data-id2');
			var currentRow=$(this).closest("tr");
			var ledger = currentRow.find("td:eq(2)").text();
			$.ajax({
				 url:'/layout/items/price_list_new.php',  
				 method:'POST',  
				 data:{
					 ledger_id:ledger_id
				 },
				 success:function(data){
					 $('#price_list_modal_title').html('New Price List - '+ledger);
					 $('#price_list_table').html(data);
					 $('#price_list_update_btn').hide();
					$('#price_list_save_btn').show();
					 $('#price_list_modal').modal('show');
				 }  
			});
		});
	}

	function save_price_list()
	{
		$(document).on('click','#price_list_save_btn',function()
		{
			var data = $('#price_list_form').serialize();
			
			$.ajax({
				url:'/layout/items/price_list_save.php',
				method:'POST',
				data:$('#price_list_form').serialize(),
				success:function(data)
				{
					$('#price_list_form').trigger('reset');
					$('#price_list_modal').modal('hide');
					window.location.href="/layout/items/ledger_list.php";
				}
			});
		});
	}

	function edit_price_list()
	{
		$(document).on('click','#btn_edit_pricelist',function(){
			var ledger_id = $(this).attr('data-id2');
			var currentRow = $(this).closest("tr");
			var ledger = currentRow.find("td:eq(2)").text();
			$.ajax({
				 url:'/layout/items/price_list_edit.php',  
				 method:'POST',  
				 data:{
					 ledger_id:ledger_id
				 },
				 success:function(data){
					 $('#price_list_modal_title').html('Edit Price List - '+ledger);
					 $('#price_list_table').html(data);
					 $('#price_list_update_btn').show();
					$('#price_list_save_btn').hide();
					 $('#price_list_modal').modal('show');
				 }  
			});
		});
	}

	function update_price_list()
	{
		$(document).on('click','#price_list_update_btn',function(){
			$.ajax({
				url:'/layout/items/price_list_update.php',  
				method:'POST',  
				data:$('#price_list_form').serialize(),
				success:function(data)
				{
					$('#price_list_form').trigger('reset');
					$('#price_list_modal').modal('hide');
					window.location.href="/layout/items/ledger_list.php";
				}
			});
		});
	}