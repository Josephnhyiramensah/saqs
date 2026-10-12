$(document).ready(function()
{
	//WARDS AND BEDS
		new_ward_modal();
		save_ward();
		edit_ward();
		update_ward();
		new_bed_modal();
		save_bed();
		edit_bed();
		update_bed();
		delete_ward();
});

	//SETUP WARD/BEDS
	function new_ward_modal()
	{
		$(document).on('click','#new_ward_icon',function()
		{
			$('#ward_update_btn').hide();
			$('#beds').hide();
			$('#ward_save_btn').show();
			$('#ward_create_form').trigger('reset');
			$('#ward_create_modal_header').html('Ward Setup');
			$('#ward_create_modal').modal('show');
		});
	}

	function save_ward()
	{
		$(document).on('click','#ward_save_btn',function(){
			var ward = $('#ward').val();
			if (ward !=="") 
			{
				$.ajax({
					 url:'/layout/items/ward_save.php',
					 method:'POST',
					 data:$('#ward_create_form').serialize(),
					 success:function(data){
						 $('#ward_create_modal').modal('hide');
						 $('#ward_create_form').trigger('reset');
						 window.location.href="/layout/items/ward_list.php";
						 //$('#ward_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Ward Description cannot be EMPTY!');
			};
		});
	}

	function edit_ward()
	{
		$(document).on('click','#btn_edit_ward',function()
		{
			var ward_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/items/ward_edit.php',
				 method:'POST',
				 data:{ward_id:ward_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $.ajax({
						url:'/layout/items/bed_get_list.php',
						method:'POST',
						data:{ward_id:ward_id},
						success:function(data){
							$('#bed_list_table').html(data);
						}
					 });
					 $('#ward_id').val(res[0]);
					 $('#ward').val(res[1]);
					 $('#price').val(res[2]);
					 $('#ward_update_btn').show();
					$('#ward_save_btn').hide();
					$('#ward_create_modal_header').html('Ward Edit');
					$('#beds').show();
					$('#ward_create_modal').modal('show');
				 }
			 });
		});
	}

	function update_ward()
	{
		$(document).on('click','#ward_update_btn',function(){
			var ward = $('#ward').val();
			if (ward !=="") 
			{
				$.ajax({
					 url:'/layout/items/ward_update.php',
					 method:'POST',
					 data:$('#ward_create_form').serialize(),
					 success:function(data){
						 $('#ward_create_modal').modal('hide');
						 $('#ward_create_form').trigger('reset');
						 window.location.href="/layout/items/ward_list.php";
						 //$('#ward_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Ward Description cannot be EMPTY!');
			};
		});
	}

	function new_bed_modal()
	{
		$(document).on('click','#add_bed_icon',function()
		{
			$('#bed_update_btn').hide();
			$('#bed_save_btn').show();
			$('#bed_create_form').trigger('reset');
			$('#bed_create_modal_header').html('Bed Setup');
			$('#bed_create_modal').modal('show');
		});
	}

	function save_bed()
	{
		$(document).on('click','#bed_save_btn',function(){
			var bed = $('#bed').val();
			var type = $('#type').val();
			var ward_id = $('#ward_id').val();
			if (bed !=="") 
			{
				$.ajax({
					 url:'/layout/items/bed_save.php',
					 method:'POST',
					 data:{bed:bed, type:type, ward_id:ward_id},
					 success:function(data){
						 $('#bed_create_modal').modal('hide');
						 $('#bed_create_form').trigger('reset');
						 $('#bed_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Bed Description cannot be EMPTY!');
			};
		});
	}

	function edit_bed()
	{
		$(document).on('click','#btn_bed_edit',function()
		{
			var bed_id = $(this).attr('data-id');
			$.ajax({
				 url:'/layout/items/bed_edit.php',
				 method:'POST',
				 data:{bed_id:bed_id},
				 datatype: 'JSON',
				 success:function(data){
					 var res = $.parseJSON(data);
					 $('#bed_id').val(res[0]);
					 $('#bed').val(res[2]);
					 $('#ward_id').val(res[1]);
					 $('#type').val(res[3]);
					 $('#bed_update_btn').show();
					$('#bed_save_btn').hide();
					$('#bed_create_modal_header').html('Bed Edit');
					$('#bed_create_modal').modal('show');
				 }
			 });
		});
	}

	function update_bed()
	{
		$(document).on('click','#bed_update_btn',function(){
			var bed_id = $('#bed_id').val();
			var bed = $('#bed').val();
			var type = $('#type').val();
			var ward_id = $('#ward_id').val();
			if (bed !=="") 
			{
				$.ajax({
					 url:'/layout/items/bed_update.php',
					 method:'POST',
					 data:{bed_id:bed_id,bed:bed,type:type,ward_id:ward_id},
					 success:function(data){
						 $('#bed_create_modal').modal('hide');
						 $('#bed_create_form').trigger('reset');
						 $('#bed_list_table').html(data);
					 }
				 });
			} 
			else 
			{
				alert('Please the Bed Description cannot be EMPTY!');
			};
		});
	}
	
	function delete_ward()
	{
		$(document).on('click','#btn_delete_ward',function()
		{
			var ward_id = $(this).attr('data-id');
			var ward = $(this).attr('data-id1');
			$('#item_delete_question').text('Are you sure you want to delete ' + ward + '?');
			$('#item_delete_modal').modal('show');
			$(document).on('click','#item_delete_yes',function()
			{
				$.ajax({  
					url:'/layout/items/ward_delete.php',  
					type:'POST',  
					data:{ward_id:ward_id},
					success:function(data)
					{
						$('#item_delete_modal').modal('hide');
						if(data == 'used')
						{
							alert('Please, '+ ward +' has been used in an attendance sheet, deletion is therefore declined!')
						}
						else if(data == 'deleted')
						{
							window.location.href="/layout/items/ward_list.php";
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