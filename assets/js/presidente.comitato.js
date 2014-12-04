$(document).ready( function () {
    
    $("#pulsanteNuovaArea").click( function() { 
        $("#tabellaAree").hide(400);
        $("#pulsanteNuovaArea").hide(300);
        $("#nuovaArea").show(500);
    });
    
});

function cancellaArea(id) {
    if ( !confirm('Sicuro di voler cancellare l\'area?') ) {
        return;
    }
    $("#area-" + id).addClass('warning');
    api('area:cancella', {id: id}, function() {
       $("#area-" + id).hide(500); 
    });
}