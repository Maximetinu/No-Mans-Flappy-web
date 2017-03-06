function doGameLoadedStuff(){
    load_finish = true;
    $("#loader-wrapper").fadeOut( 850, "swing", function() { $(this).remove(); });
}