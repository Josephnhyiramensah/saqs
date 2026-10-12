console.log("(function.js) file");
$(document).ready(function()
{
	console.log("(function.js)")
	$(document).on('click','.attend-btn',function(e)
	{
		e.preventDefault();
		console.log('event obj:');
		console.log(e);
		var patientid = $("#patientid").val();
		var name = $("#name").val();
		var age = $("#age").val();
		var datastring = {"patientid": patientid,"name": name,"age": age};
		if (patientid == "") 
		{
			alert("Patient ID cannot be EMPTY");
		} else if (name == "") 
		{
			alert("Patient Name cannot be EMPTY");
		} else if (age == "") 
		{
			alert("Patient Age cannot be EMPTY");
		} else{
			console.log(datastring);
			$.ajax({
				type:"post",
				url:"create_attend.php",
				data:datastring,
				success:function(data){
					alert("1 Attendance CREATED");
				}, error: function(xhr, error) {
					console.log(error);
				}
			});
		}

	});
});
