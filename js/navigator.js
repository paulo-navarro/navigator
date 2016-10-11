$("body").ready(function(){
	$(".image div:first-child").on("click", function(){
		var imageUrl = $(this).parent().data('path');
		var html = "<img src='"+imageUrl+"'/>";
		$("#popContent").html(html);
		$("#popShow").fadeIn();
	});
	$(".video div:first-child").on("click", function(){
	    var src = $(this).parent().data('path');
	    var html = "<video controls><source src='"+src+"'/></video>";
	  	$("#popContent").html(html);
		  $("#popShow").fadeIn();
	});
	$("#fecharPopShow").on("click", function(){
	    $("#popShow").fadeOut();
	    $("#popContent").html('');
	})
});
