<?php

/*
 * ©2013 Croce Rossa Italiana
 */

?>

<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-globe muted"></i>
            Dov'è Croce Rossa attorno a me?
        </h2>
    </div>
    <div class="span4 allinea-centro">
        <span class="muted">
            <i class="icon-info-sign"></i> Questi sono i Comitati su Gaia.<br />
            <strong>Comitati CRI su Gaia: <?php echo count(Comitato::elenco()); ?></strong>.
        </span>
    </div>
 
</div>

<div class="row-fluid">
    
    
    <div class="span6">
        
        <ul>
        <?php foreach(Regionale::elenco('nome ASC') as $regionale) { ?>
            <li><h3><?php echo $regionale->nome; ?></h3>
                <ul>
                    <?php foreach ( $regionale->provinciali() as $provinciale ) { ?>
                    <li><h4><?php echo $provinciale->nome; ?></h4>
                        <ul>
                            <?php foreach ( $provinciale->locali() as $locali ) { ?>
                            <li><strong><?php echo $locali->nome; ?></strong>
                                <ul>
                                <?php foreach ( $locali->comitati() as $comitato ) { ?>
                                    <li>
                                        <a href="#"><?php echo $comitato->nome; ?></a><br />
                                        <?php if ( $t = $comitato->telefono ) { ?>
                                            <i class="icon-phone"></i> <?php echo $t; ?>
                                        <?php } ?>
                                        <?php if ( $t = $comitato->email ) { ?>
                                            &mdash; <i class="icon-envelope"></i> <?php echo $t; ?>
                                        <?php } ?>
                                        <?php if ( $comitato->haPosizione() ) { ?>
                                            <br /><span class="muted"><?php echo $comitato->formattato; ?></span>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
        </ul>
        
    </div>
    
    
    
    <div id="laMappa" class="span6 mappaGoogle bordo" style="min-height: 700px;">
        
               

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
      <?php $i = 0; foreach (Comitato::elenco() as $c ) { 
        if ( !$c->haPosizione() ) { continue; }  
        ?>
        messaggio.push(new google.maps.InfoWindow({
            content: "<?php echo htmlentities($c->nomeCompleto()); ?><br /><span class='muted'><?php echo $c->formattato; ?></span><br /><?php echo $c->telefono; ?><br /><?php echo $c->email; ?>"
        }));
        marcatore.push(new google.maps.Marker({
            position: new google.maps.LatLng(<?php echo $c->latlng(); ?>),
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