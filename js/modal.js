var modal_open = false;

function openModal(){
	$("a").addClass('disable-anchor');
	$("#fullpage").css('opacity',0.3);
	$("#fp-nav").css("visibility","hidden");
	modal_open = true;
	$.fn.fullpage.setMouseWheelScrolling(false);
    	$.fn.fullpage.setAllowScrolling(false);
	$("#copyright-modal").fadeIn( 350, "swing");
}
function closeModal(){
	$("a").removeClass('disable-anchor');
	$("#fullpage").css('opacity',1);
	$("#fp-nav").css("visibility","visible");
	modal_open = false;
	$("#copyright-modal").fadeOut( 350, "swing");
	$.fn.fullpage.setMouseWheelScrolling(true);
    	$.fn.fullpage.setAllowScrolling(true);
}

$(document).keyup(function(e) {
	if (modal_open && (e.keyCode == 27) || (e.keyCode == 13)) {
		closeModal();
	}
});

$(document).on('mousedown','#fullpage', function(){
	if(modal_open)
		closeModal();
});