$(function(){
	$("#estado").change(function(){
		var id= $(this).val();
		$.ajax({
			type: "POST",
			url: "cidades.php?id="+id,
			dataType: "text",
			success: function(res_cidade){
				$("#cidade").children(".cidade").remove();
				$("#cidade").append(res_cidade);
			} 
		});
	});
});