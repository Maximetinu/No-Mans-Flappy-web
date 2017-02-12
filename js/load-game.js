$(window).load(function(){
	if (window.location.hash != "#ranking" && window.location.hash != "#how-to" && window.location.hash != "#chat" && window.location.hash != "#footer")
		chargeLoader();
	$(window).bind('hashchange', function() {
     if(window.location.hash == "#game"){
   			chargeLoader();
         }
     });
});

//var current_hash = null;
//var has_recovery_focus = false;
var game_loaded = false;
//var long_wait_charge_exected = false;
var load_finish = false;
var focus_off_date = null;
var focus_on_date = null;

function chargeLoader(){
	if (!game_loaded){
		$.getScript("../game/UnityLoader.js");
		waitLoading();
	}
	game_loaded = true;
}

function waitLoading(){
	$.fn.fullpage.setMouseWheelScrolling(false);
    $.fn.fullpage.setAllowScrolling(false);
    $("#fp-nav").css("visibility","hidden");
}

function doGameLoadedStuff(){
	$.fn.fullpage.setMouseWheelScrolling(true);
    $.fn.fullpage.setAllowScrolling(true);
    load_finish = true;
    console.log("CARGA TERMINADA. AL HACER FOCUS A PARTIR DE AHORA NO SE DEBERÍA SALTAR AL GAME");
    $("#loader-wrapper").fadeOut( 850, "swing", function() { $(this).remove(); });
    $("#fp-nav").css("visibility","visible");
        //if (current_hash != null && !has_recovery_focus){
        //	console.log("tenia algun hash al cambiar de pestaña y ademas no ha vuelto mientras tanto. Deberiamos movernos a la seccion de antes");
        	//$.fn.fullpage.moveTo(current_hash);
        //}
    }

/* Visibility API
****************************/
document.addEventListener('visibilitychange', function(){
    if(document.hidden && game_loaded == false){
    	chargeLoader();
    	focus_off_date = new Date();
    }
    if(!document.hidden && !load_finish){
       focus_on_date = new Date();
	// var tiempo = focus_on_date - focus_off_date;
	// alert("han pasado " + tiempo + " ms");
	if ((focus_on_date - focus_off_date) < 5000){ // Arbitrary timeout
		goGameSilent();
	}
}
})

function goGameSilent(){
    $.fn.fullpage.setScrollingSpeed(0); 
    $.fn.fullpage.moveTo('game');
    $.fn.fullpage.setScrollingSpeed(700);    
}