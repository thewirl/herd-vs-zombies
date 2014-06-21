//@license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-V3-or-later
$(document).ready(function(){
	$("#home").on("click", function() {
		$("#H").removeClass("hidden");
		$("#I").addClass("hidden");
		$("#R").addClass("hidden");
		$("#L").addClass("hidden");
		$("#F").addClass("hidden");
		$("#U").addClass("hidden");
	});
	$("#info").on("click", function() {
		$("#H").addClass("hidden");
		$("#I").removeClass("hidden");
		$("#R").addClass("hidden");
		$("#L").addClass("hidden");
		$("#F").addClass("hidden");
		$("#U").addClass("hidden");
	});
	$("#rule").on("click", function() {
		$("#H").addClass("hidden");
		$("#I").addClass("hidden");
		$("#R").removeClass("hidden");
		$("#L").addClass("hidden");
		$("#F").addClass("hidden");
		$("#U").addClass("hidden");
	});
	$("#lore").on("click", function() {
		$("#H").addClass("hidden");
		$("#I").addClass("hidden");
		$("#R").addClass("hidden");
		$("#L").removeClass("hidden");
		$("#F").removeClass("hidden");
		$("#U").addClass("hidden");
	});
	$("#myac").on("click", function() {
		$("#H").addClass("hidden");
		$("#I").addClass("hidden");
		$("#R").addClass("hidden");
		$("#L").addClass("hidden");
		$("#F").addClass("hidden");
		$("#U").removeClass("hidden");
		$.get("res/usercp.html", function( data ) {
			$( "#U" ).html(data);
		});
		$.post("bin/login.php", {team:"team"}, function( data ){
			if(data=='human'){
				$("#killer").addClass("hidden");
			}
		});

	});
	$("#Logout").on("click", function() {
		$.post("bin/login.php", {loggedout:"loggedout"} , function( data ) {
			$( "#U" ).html(data);
			$( "#Logout" ).addClass("hidden");
			$( "#myac" ).addClass("hidden");
			$( "#login" ).removeClass("hidden");			
			$( "#register" ).removeClass("hidden");			
		});
	});
	$("").on("click", function(){
			
	});
	$(".navb").mousedown(function(){
		$(this).css("border-color","purple");
	});
	$(".navb").mouseup(function(){
		$(this).css("border-color","blue");
	});
});
