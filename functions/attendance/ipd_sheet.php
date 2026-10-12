<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/lead.php');

	date_default_timezone_set("Africa/Accra");
	$date_today = date('Y-m-d');
?>


<?php
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/trail.php');
?>
<script>
	$(document).ready(function()
	{
		/*$.each( res, function( index, value ) 
		{
			var sales_id = value;
			setTimeout(
				function()
				{*/
					$.ajax({
						url:'/layout/attendance/ipd_autobill_processing.php',
						method:'POST',
						data:{sales_id:sales_id},
						success:function()
						{
							//window.open('/afliaaccount/layout/vouchers/sales_sendmail_single.php','_blank');
						}
					});
				/*}, time
			);
				time += 10000;
		});*/
	});
</script>