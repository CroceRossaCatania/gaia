<?php

/*
 * ©2013 Croce Rossa Italiana
 */

?>

<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-globe muted"></i>
            Cosa fa Croce Rossa attorno a me?
        </h2>
    </div>
    <div class="span4 allinea-centro">
        <span class="muted">
            <i class="icon-info-sign"></i> Attività svolte nell'ultimo mese.<br />
            <strong>Comitati CRI su Gaia: <?php echo count(Comitato::elenco()); ?></strong>.
        </span>
    </div>
 
</div>

<div class="row-fluid">
    
    
    <div id="laMappa" class="span12 mappaGoogle bordo" style="min-height: 700px;">
        
               

    </div>
    
</div>

 <script type="text/javascript">
    function initialize() {
      var opzioni = {
        zoom: 6,
        center: new google.maps.LatLng(41.9,12.4833333),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      var map = new google.maps.Map(document.getElementById("laMappa"), opzioni);
      
      var messaggio = [], marcatore = [];                         
      <?php $i = 0; foreach ( Attivita::elenco() as $a ) { 
        if ( !$a->haPosizione() ) { continue; }  
        ?>
        messaggio.push(new google.maps.InfoWindow({
            content: "<?php echo htmlentities($a->nome); ?><br /><span class='muted'><?php echo $a->comitato()->nomeCompleto(); ?></span>"
        }));
        marcatore.push(new google.maps.Marker({
            position: new google.maps.LatLng(<?php echo $a->latlng(); ?>),
            map: map, animation: google.maps.Animation.DROP
        }));
        google.maps.event.addListener(marcatore[<?php echo $i; ?>], 'click', function() {
            messaggio[<?php echo $i; ?>].open(map, marcatore[<?php echo $i; ?>]);
        });
        <?php $i++; ?>
        
      <?php } ?>
        
    }
    function loadScript() {
      var script = document.createElement("script");
      script.type = "text/javascript";
      script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
      document.body.appendChild(script);
    }
    window.onload = loadScript;
</script>