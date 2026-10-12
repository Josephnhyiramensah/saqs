$(document).ready(function()
{
	//DRUGS
		new_drug_modal();
		save_new_drug();
		edit_drug();
		update_drug();
		search_drug();
		composite_drug_modal();
		composite_drug_save();
		composite_drug_edit();
		composite_drug_update();
		composite_drug_delete();
		composite_drug_list_modal();
		composite_drug_list_save();
		composite_drug_list_edit();
		composite_drug_list_update();
		composite_drug_list_delete();
		delete_drug();
});

	//SETUP DRUGS
	function new_drug_modal()
	{
		$(document).on('click','#new_drug_icon',function()
		{
			$('#drug_update_btn').hide();
			$('#drug_save_btn').show();
			$('#drug_create_form').trigger('reset');
			$('#drug_create_modal').modal('show');
		});
	}

	function save_new_drug()
	{
		$(document).on('click','#drug_save_btn',function(){
			var brand_name = $('#brand_name').val();
			if (brand_name !=="") 
			{
				$.ajax({
				 url:'/layout/items/drug_save.php',
				 method:'POST',
				 data:$('#drug_create_form').serialize(),
				 success:function(data){
					 $('#drug_create_modal').modal('hide');
					 $('#drug_create_form').trigger('reset');
					 //$('#drug_list_table').html(data);
					window.location.href="/layout/items/drug_list.php";
				 }
				 });
			} 
			else 
			{
				alert('Please the Drug cannot be EMPTY!');
			};
		});
	}

	function edit_drug()
	{
		$(document).on('click','#btn_edit_drug',function()
		{
			var drug_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/items/drug_edit.php',
				 method:'POST',
				 data:{drug_id:drug_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $('#drug_id').val(res[0]);
					 $('#brand_name').val(res[2]);
					 $('#nhisitem').val(res[1]);
					 $('#generic_name').val(res[3]);
					 $('#code').val(res[4]);
					 $('#type').val(res[5]);
					 $('#classification').val(res[6]);
					 $('#category').val(res[7]);
					 $('#unit_of_measure').val(res[8]);
					 $('#manufacturer').val(res[9]);
					 $('#price_cash').val(res[10]);
					 $('#price_nhis').val(res[11]);
					 $('#price_prvt').val(res[12]);
					 $('#age_from').val(res[13]);
					 $('#age_to').val(res[14]);
					 $('#gender').val(res[15]);
					 $('#block_neg').val(res[16]);
					 $('#expiry_date').val(res[17]);
					 $('#batch').val(res[18]);
					 $('#days_prompt').val(res[19]);
					 $('#route').val(res[20]);
					 $('#drug_update_btn').show();
					$('#drug_save_btn').hide();
					$('#drug_create_modal_header').html('Drug Edit');
					$('#drug_create_modal').modal('show');
				 }
			 });
		});
	}

	function update_drug()
	{
		$(document).on('click','#drug_update_btn',function(){
			var brand_name = $('#brand_name').val();
			if (brand_name !=="") 
			{
				$.ajax({
					url:'/layout/items/drug_update.php',
					method:'POST',
					data:$('#drug_create_form').serialize(),
					success:function(data){
						$('#drug_create_modal').modal('hide');
						$('#drug_create_form').trigger('reset');
						//$('#drug_list_table').html(data);
						window.location.href="/layout/items/drug_list.php";
					}
				});
			} 
			else 
			{
				alert('Please the Drug cannot be EMPTY!');
			};
		});
	}

	function search_drug()
	{
		$(document).on('keyup','#search_drug',function()
		{
			var search = $(this).val();
			
			  if(search != '')
			  {
				  $.ajax({
					url:"/layout/items/drug_search.php",
					method:"POST",
					data:{search:search},
					success:function(data)
					{
						$('#drug_list_table').html(data);
					}
				});
			}
		}); 
	}

	function composite_drug_modal()
	{
		$(document).on('click','#new_composite_drug_icon',function()
		{
			$('#composite_drug_create_modal_header').html('Composite Drug Setup');
			$('#composite_drug_update_btn').hide();
			$('#composite_drug_save_btn').show();
			$('#composite_drug_create_form').trigger('reset');
			$('#composite_drug_create_modal').modal('show');
		});
	}

	function composite_drug_save()
	{
		$(document).on('click','#composite_drug_save_btn',function(){
			var composite_drug_id = $('#composite_drug_id').val();
			var composite_drug = $('#composite_drug').val();
			var composite_drug_price = $('#composite_drug_price').val();
			if (composite_drug !="") 
			{
				$.ajax({
					 url:'/layout/items/composite_drug_save.php',
					 method:'POST',
					 data:{
						composite_drug_id:composite_drug_id,
						composite_drug:composite_drug,
						composite_drug_price:composite_drug_price
					 },
					 success:function(data)
						 {
							 $('composite_drug_create_form').trigger('reset');
							 window.location.href="/layout/items/composite_drug_list.php";
						 }
					 });
			} 
			else 
			{
				alert('Please the Composite Drug Description cannot be EMPTY!');
			};
				
		});
	}

	function composite_drug_edit()
	{
		$(document).on('click','#btn_edit_composite_drug',function()
		{
			var composite_drug_id = $(this).attr('data-id');
			$.ajax(
			{
				url: '/layout/items/composite_drug_edit.php',
				method: 'POST',
				data: {composite_drug_id:composite_drug_id},
				datatype: 'JSON',
				success: function(data)
				{
					var res = $.parseJSON(data);
					$('#composite_drug_save_btn').hide();
					$('#composite_drug_update_btn').show();
					$('#composite_drug_id').val(res[0]);
					$('#composite_drug').val(res[1]);
					$('#composite_drug_price').val(res[2]);
					$('#composite_drug_create_modal').modal('show');
				}
			});
		});
	}

	function composite_drug_update()
	{
		$(document).on('click','#composite_drug_update_btn',function(){
			var composite_drug_id = $('#composite_drug_id').val();
			var composite_drug = $('#composite_drug').val();
			var composite_drug_price = $('#composite_drug_price').val();
			if (composite_drug !="") 
			{
				$.ajax({
					 url:'/layout/items/composite_drug_update.php',
					 method:'POST',
					 data:{
						composite_drug_id:composite_drug_id,
						composite_drug:composite_drug,
						composite_drug_price:composite_drug_price
					 },
					 success:function(data)
						 {
							 $('composite_drug_create_form').trigger('reset');
							 window.location.href="/layout/items/composite_drug_list.php";
						 }
					 });
			} 
			else 
			{
				alert('Please the Composite Drug Description cannot be EMPTY!');
			};
				
		});
	}

	function composite_drug_delete()
	{
		$(document).on('click','#btn_delete_composite_drug',function(){
			var composite_drug_id = $(this).attr('data-id');
			var currentRow = $(this).closest("tr");
			var test = currentRow.find("td:eq(0)").text();
			$('#item_delete_modal_title').text('Composite Drug Deletion!');
			$('#item_delete_question').text('Are you sure you want to delete Composite Drug: ' + test + '?');
			$('#item_delete_modal').modal('show');
			$(document).on('click','#item_delete_yes',function(){
				$.ajax({
					url:'/layout/items/composite_drug_delete.php',
					method:'POST',
					data:{
						composite_drug_id:composite_drug_id
					},
					success:function(data)
					{
						$('#item_delete_modal').modal('hide');
						window.location.href="/layout/items/composite_drug_list.php";
					}
				});
			});
			$(document).on('click','#item_delete_no',function(){
				$('#item_delete_modal').modal('hide');
			});
		});
	}

	function composite_drug_list_modal()
	{
		$(document).on('click','#btn_add_composite_drug_list',function()
		{
			var composite_drug_id = $(this).attr('data-id');
			$('#composite_drug_list_create_modal_header').html('Composite Drug List Setup');
			$('#composite_drug_list_update_btn').hide();
			$('#composite_drug_list_save_btn').show();
			$('#composite_drug_list_create_form').trigger('reset');
			$('#cll_composite_drug_id').val(composite_drug_id);
			$('#composite_drug_list_create_modal').modal('show');
		});
	}

	function composite_drug_list_save()
	{
		$(document).on('click','#composite_drug_list_save_btn',function(){
			var composite_drug_id = $('#cll_composite_drug_id').val();
			var composite_drug_list_id = $('#composite_drug_list_id').val();
			var composite_drug_list_drug_id = $('#composite_drug_list_drug_id').val();
			var composite_drug_dosage = $('#composite_drug_dosage').val();
			var composite_drug_qty = $('#composite_drug_qty').val();
			if (composite_drug_list_drug_id !="" && composite_drug_list_drug_id > 0) 
			{
				if (composite_drug_dosage !="") 
				{
					if (composite_drug_qty !="") 
					{
						$.ajax({
							url:'/layout/items/composite_drug_list_save.php',
							method:'POST',
							data:{
								composite_drug_id:composite_drug_id,
								composite_drug_list_id:composite_drug_list_id,
								composite_drug_list_drug_id:composite_drug_list_drug_id,
								composite_drug_dosage:composite_drug_dosage,
								composite_drug_qty:composite_drug_qty
							},
							success:function(data)
							{
								$('composite_drug_list_create_form').trigger('reset');
								$('#composite_drug_list_create_modal').modal('hide');
								window.location.href="/layout/items/composite_drug_list.php";
							}
						});
					} 
					else 
					{
						alert('Please the Qty cannot be EMPTY!');
					};
				} 
				else 
				{
					alert('Please the Dosage cannot be EMPTY!');
				};
			} 
			else 
			{
				alert('Please the Drug cannot be EMPTY!');
			};
		});
	}

	function composite_drug_list_edit()
	{
		$(document).on('click','#btn_edit_composite_drug_list',function()
		{
			var composite_drug_list_id = $(this).attr('data-id');
			$.ajax(
			{
				url: '/layout/items/composite_drug_list_edit.php',
				method: 'POST',
				data: {composite_drug_list_id:composite_drug_list_id},
				datatype: 'JSON',
				success: function(data)
				{
					var res = $.parseJSON(data);
					$('#composite_drug_list_save_btn').hide();
					$('#composite_drug_list_update_btn').show();
					$('#composite_drug_list_id').val(res[0]);
					$('#cll_composite_drug_id').val(res[1]);
					$('#composite_drug_list_drug_id').val(res[2]);
					$('#composite_drug_dosage').val(res[3]);
					$('#composite_drug_qty').val(res[4]);
					$('#composite_drug_list_create_modal').modal('show');
				}
			});
		});
	}

	function composite_drug_list_update()
	{
		$(document).on('click','#composite_drug_list_update_btn',function(){
			var composite_drug_id = $('#cll_composite_drug_id').val();
			var composite_drug_list_id = $('#composite_drug_list_id').val();
			var composite_drug_list_drug_id = $('#composite_drug_list_drug_id').val();
			var composite_drug_dosage = $('#composite_drug_dosage').val();
			var composite_drug_qty = $('#composite_drug_qty').val();
			if (composite_drug_list_drug_id !="" && composite_drug_list_drug_id > 0) 
			{
				if (composite_drug_dosage !="") 
				{
					if (composite_drug_qty !="") 
					{
						$.ajax({
							url:'/layout/items/composite_drug_list_update.php',
							method:'POST',
							data:{
								composite_drug_id:composite_drug_id,
								composite_drug_list_id:composite_drug_list_id,
								composite_drug_list_drug_id:composite_drug_list_drug_id,
								composite_drug_dosage:composite_drug_dosage,
								composite_drug_qty:composite_drug_qty
							},
							success:function(data)
								{
									$('composite_drug_list_create_form').trigger('reset');
									$('#composite_drug_list_create_modal').modal('hide');
									window.location.href="/layout/items/composite_drug_list.php";
								}
						});
					} 
					else 
					{
						alert('Please the Qty cannot be EMPTY!');
					};
				} 
				else 
				{
					alert('Please the Dosage cannot be EMPTY!');
				};
			} 
			else 
			{
				alert('Please the Drug cannot be EMPTY!');
			};
				
		});
	}

	function composite_drug_list_delete()
	{
		$(document).on('click','#btn_delete_composite_drug_list',function(){
			var composite_drug_list_id = $(this).attr('data-id');
			var currentRow = $(this).closest("tr");
			var test = currentRow.find("td:eq(1)").text();
			$('#item_delete_modal_title').text('Composite Drug Deletion!');
			$('#item_delete_question').text('Are you sure you want to delete Composite Drug: ' + test + '?');
			$('#item_delete_modal').modal('show');
			$(document).on('click','#item_delete_yes',function(){
				$.ajax({
					url:'/layout/items/composite_drug_list_delete.php',
					method:'POST',
					data:{
						composite_drug_list_id:composite_drug_list_id
					},
					success:function(data)
					{
						$('#item_delete_modal').modal('hide');
						window.location.href="/layout/items/composite_drug_list.php";
					}
				});
			});
			$(document).on('click','#item_delete_no',function(){
				$('#item_delete_modal').modal('hide');
			});
		});
	}
			
	function delete_drug()
	{
		$(document).on('click','#btn_delete_drug',function()
		{
			var drug_id = $(this).attr('data-id');
			var drug = $(this).attr('data-id1');
			$('#item_delete_question').text('Are you sure you want to delete ' + drug + '?');
			$('#item_delete_modal').modal('show');
			$(document).on('click','#item_delete_yes',function()
			{
				$.ajax({  
					url:'/layout/items/drug_delete.php',  
					type:'POST',  
					data:{drug_id:drug_id},
					success:function(data)
					{
						$('#item_delete_modal').modal('hide');
						if(data == 'used')
						{
							alert('Please, '+ drug +' has been used in an attendance sheet, deletion is therefore declined!')
						}
						else if(data == 'deleted')
						{
							window.location.href="/layout/items/drug_list.php";
						};
					}
				});
			});
			$(document).on('click','#item_delete_no',function()
			{
				$('#item_delete_modal').modal('hide');
			});
		});
	}
