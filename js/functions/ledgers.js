$(document).ready(function()
{
	//LEDGERS
		save_ledger();
		new_ledger_modal();
		edit_ledger();
		tb_2_list();
		tb_3_list();
		tb_4_list();
		tb_5_list();
		show_ledger_type();
		update_ledger();
});

	//LEDGER
	function save_ledger()
	{
		$(document).on('click','#ledger_save_btn',function(){
			$.ajax({
				 url:'/layout/items/ledger_insert.php',
				 method:'POST',
				 data:$('#ledger_create_form').serialize(),
				 success:function()
				 {
					 window.location.href="/layout/items/ledger_list.php";
				 }
			});
		});
	}

	function tb_2_list()
	{
		$(document).on('change','#tb_1',function()
		{
			var tb_1 = $('#tb_1').val();
			$.ajax(
			{
				url: '/layout/items/tb_2_list.php',
				method: 'POST',
				data: {tb_1:tb_1},
				datatype: 'JSON',
				success: function(data)
				{
					var res = $.parseJSON(data);
					$('#tb_2').html('<option value="0">Please select</option>');
					for (var i=0, l=res.length; i<l;i+=2)
					{
						var oddPositionVal = res[i];
						var evenPositionVal = res[i+1];
						var rowhtml = '<option value=' + oddPositionVal + '>' + evenPositionVal + '</option>';
						$('#tb_2').append(rowhtml);
					}
				}
			});
			
		});
	}

	function tb_3_list()
	{
		$(document).on('change','#tb_2',function()
		{
			var tb_2 = $('#tb_2').val();
			$.ajax(
			{
				url: '/layout/items/tb_3_list.php',
				method: 'POST',
				data: {tb_2:tb_2},
				datatype: 'JSON',
				success: function(data)
				{
					var res = $.parseJSON(data);
					$('#tb_3').html('<option value="0">Please select</option>');
					for (var i=0, l=res.length; i<l;i+=2)
					{
						var oddPositionVal = res[i];
						var evenPositionVal = res[i+1];
						var rowhtml = '<option value=' + oddPositionVal + '>' + evenPositionVal + '</option>';
						$('#tb_3').append(rowhtml);
					}
				}
			});
			
		});
	}

	function tb_4_list()
	{
		$(document).on('change','#tb_3',function()
		{
			var tb_3 = $('#tb_3').val();
			$.ajax(
			{
				url: '/layout/items/tb_4_list.php',
				method: 'POST',
				data: {tb_3:tb_3},
				datatype: 'JSON',
				success: function(data)
				{
					var res = $.parseJSON(data);
					$('#tb_4').html('<option value="0">Please select</option>');
					for (var i=0, l=res.length; i<l;i+=2)
					{
						var oddPositionVal = res[i];
						var evenPositionVal = res[i+1];
						var rowhtml = '<option value=' + oddPositionVal + '>' + evenPositionVal + '</option>';
						$('#tb_4').append(rowhtml);
					}
				}
			});
			
		});
	}

	function tb_5_list()
	{
		$(document).on('change','#tb_4',function()
		{
			var tb_4 = $('#tb_4').val();
			$.ajax(
			{
				url: '/layout/items/tb_5_list.php',
				method: 'POST',
				data: {tb_4:tb_4},
				datatype: 'JSON',
				success: function(data)
				{
					var res = $.parseJSON(data);
					$('#tb_5').html('<option value="0">Please select</option>');
					for (var i=0, l=res.length; i<l;i+=2)
					{
						var oddPositionVal = res[i];
						var evenPositionVal = res[i+1];
						var rowhtml = '<option value=' + oddPositionVal + '>' + evenPositionVal + '</option>';
						$('#tb_5').append(rowhtml);
					}
				}
			});
			
		});
	}

	function show_ledger_type()
	{
		$(document).on('change','#tb_5',function()
		{
			var tb_5 = $('#tb_5').val();
			
			if (tb_5==1){
				$('#ledger_type_div').show();
				$("ledger_type_div").addClass("col-md-4 mb-4");
				$("ledger_code_div").addClass("col-md-2 mb-2");
			}
			else{
				$('#ledger_type_div').hide();
				$("ledger_code_div").addClass("col-md-6 mb-6");
			}
			
		});
	}

	function new_ledger_modal()
	{
		$(document).on('click','#new_ledger_icon',function()
		{
			$('#ledger_create_modal_header').html('Ledger Setup');
			$('#ledger_create_form').trigger('reset');
			$('#ledger_update_btn').hide();
			$('#ledger_save_btn').show();
			$('#ledgercreatemodal').modal('show');
		}) 
	}

	function edit_ledger()
	{
		$(document).on('click','#btn_edit_ledger',function()
		{
			var ledger_id = $(this).attr('data-id');
			$.ajax(
			{
				url: '/layout/items/ledger_get_data.php',
				method: 'POST',
				data: {ledger_id:ledger_id},
				datatype: 'JSON',
				success: function(data)
				{
					var res = $.parseJSON(data);
					$('#ledgerid_up').val(res[0]);
					$('#ledgerdesc_up').val(res[1]);
					$('#ledgerCode_up').val(res[2]);
					$('#tb_1_up').val(res[3]);
					$('#tb_2_up').val(res[5]);
					$('#tb_3_up').val(res[7]);
					$('#tb_4_up').val(res[9]);
					$('#tb_5_up').val(res[11]);
					$('#ledgertype_up').val(res[13]);
					$('#ledgeraddress_up').val(res[14]);
					$('#ledgeremail_up').val(res[15]);
					$('#ledgerphone_up').val(res[16]);
					$('#ledgerstatus_up').val(res[17]);
					$('#ledger_edit_modal_header').html('Ledger Update');
					if (res[11] == 1)
					{
						$('#ledger_type_div_up').show();
						$("ledger_type_div_up").addClass("col-md-4 mb-4");
						$("ledger_code_div_up").addClass("col-md-2 mb-2");
					}
					else{
						$('#ledger_type_div_up').hide();
						$("ledger_code_div_up").addClass("col-md-6 mb-6");
					};
					$('#ledgereditmodal').modal('show');
				}
			})
		}) 
	}

	function update_ledger()
	{
		$(document).on('click','#ledger_update_btn',function(){
			$.ajax({
				 url:'/layout/items/ledger_update.php',
				 method:'POST',
				 data:$('#ledger_edit_form').serialize(),
				 success:function()
				 {
					 window.location.href="/layout/items/ledger_list.php";
				 }
			});
		});
	}
