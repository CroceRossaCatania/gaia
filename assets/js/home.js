var comitati;
$(document).ready( function() {
    
    /* Avvia la slide in home page */
    $("#caroselloHome").carousel();
    
    /* Avvia il roller dei comitati già su Gaia */
    setInterval(function() {
        var m = comitati[Math.floor((Math.random()*comitati.length))];
        $("#rollerComitati").hide('fade', 300, function () {
            $("#rollerComitati").text(m).show('fade', 300);
        });
    }, 2000);
    
});