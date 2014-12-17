var mappa     = null;
var prossimo  = false;
$(document).ready( function() {
   
   /* Ricerca */
   $("#ricercaLuogo").keyup(function (i, e) {
      
      $("#quiRisultati").html("<div class='alert alert-info'><i class='icon-spin icon-spinner'></i> <strong>Ricerca in corso...</strong></div>")

      if ( prossimo ) {
        clearTimeout(prossimo);
      }
      prossimo = setTimeout(function() {

        api('geocoding', { query: $("#ricercaLuogo").val() }, function(x) {
           
           if ( x.risposta.length > 0 ){
               $("#quiRisultati").html('');
               for (var i in x.risposta) {
                   $("#quiRisultati").append("<div data-x='" + x.risposta[i].lat +"' data-y='" + x.risposta[i].lng + "' class='mLocalita'>" + x.risposta[i].formattato + "</div>");
                   
               }
               attivaAscoltatori();
           } else {
               $("#quiRisultati").html("<div class='alert alert-error'><i class='icon-warning-sign'></i> Nessun risultato trovato.</div>")
           }
        });

      }, 1000);
       
   });
   
   caricaMapsApi('avviaMappa');
   $("#ricercaLuogo").keyup();
   
});


var finestra = null;
function attivaAscoltatori () {
   $("#quiRisultati div").each( function(i, e) {
       $(e).click( function() {
            $("#quiRisultati div").removeClass('mLocalitaSel');
            $(e).addClass('mLocalitaSel');
            
            $("#formattato").val($(e).text());
            $("#pulsanteOk").removeClass('disabled').removeAttr('disabled');
            
            var posizione = new google.maps.LatLng($(e).data('x'), $(e).data('y'));
            mappa.setCenter(posizione);
            mappa.setZoom(17);
            
            finestra = new google.maps.InfoWindow();
            finestra.setContent($(e).text());
            finestra.setPosition(posizione);
            finestra.open(mappa);
            
            return false;
        });
   });
}

function avviaMappa() {
     var posizioneIniziale = new google.maps.LatLng(37.514262,15.084445);
     var opzioni = {
      zoom: 12,
      center: posizioneIniziale,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    mappa = new google.maps.Map(document.getElementById("mappaGeografica"), opzioni);
    //var coordInfoWindow = new google.maps.InfoWindow();
    //coordInfoWindow.setContent('<?php echo $s->nome; ?>' + "<?php $s->ottieniStelle(); ?>");
    //coordInfoWindow.setPosition(myLatlng);
    //coordInfoWindow.open(map);
    //google.maps.event.addListener(map, 'zoom_changed', function() {
    //  coordInfoWindow.open(map);
    //});
}
