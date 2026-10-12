$(document).ready(function(){	
	$(document).on('click', '.attendcreate', function(){
		var patient_id = $(this).attr('id');
		$.ajax({
			url:"create_attend.php",
			type:"post",
			data:{patient_id:patient_id},
			success:function(data){
				alert("1 Attendance added successfully");
			}
		})
	});
});