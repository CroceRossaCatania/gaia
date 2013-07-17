$(document).ready( function() {
$("#pulsanteScrivi").click( function() {
        $("#boxScrivi").toggle(500, function() {
            $("#boxScrivi textarea").focus().select();
        });
    });
});
