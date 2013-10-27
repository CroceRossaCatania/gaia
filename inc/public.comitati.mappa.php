<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$albero = GeoPolitica::ottieniAlbero()[0];
?>

<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-globe text-error"></i>
            Dov'è Croce Rossa attorno a me?
        </h2>
    </div>
    <div class="span4 allinea-centro">
        <i class="icon-bar-chart icon-2x text-error"></i><br />
        <label class="label label-success"><?php echo count(Comitato::elenco()); ?></label>
        <strong>Unità CRI aderiscono al progetto Gaia</strong>
    </div>
 
</div>

<hr />

<div class="row-fluid">
    
    
    <div class="span5">
        
        <p><strong>Elenco e contatti dei comitati che aderiscono al progetto Gaia.</strong></p>
        <hr />
        <p class="text-info">
            <i class="icon-info-sign"></i>
            Clicca sul comitato regionale per poter navigare i comitati provinciali, comitati locali ed unità territoriali.
        </p>
        
        <ul>
        <?php foreach($albero->regionali as $regionale) { ?>
            <li><a class="btn btn-link" onclick="$('#reg_<?php echo $regionale->id; ?>').toggle(500);">
                    <strong><?php echo $regionale->nome; ?></strong>
                </a>
                <ul class="nascosto" id="reg_<?php echo $regionale->id; ?>">
                    <h4>Comitati provinciali</h4>
                    <?php foreach ( $regionale->provinciali as $provinciale ) { ?>
                    <li>
                        <a class="btn btn-link" onclick="$('#prov_<?php echo $provinciale->id; ?>').toggle(500);">
                            <?php echo $provinciale->nome; ?>
                        </a>
                        <ul class="nascosto" id="prov_<?php echo $provinciale->id; ?>">
                            <h4>Comitati locali</h4>
                            <?php foreach ( $provinciale->comitati as $locali ) { ?>
                            <li>
                                <a class="btn btn-link" onclick="$('#loc_<?php echo $locali->id; ?>').toggle(500);">
                                    <?php echo $locali->nome; ?>
                                </a>
                                <ul class="nascosto" id="loc_<?php echo $locali->id; ?>">
                                    <h4>Unità territoriali</h4>
                                <?php foreach ( $locali->unita as $comitato ) { ?>
                                    <li>
                                        <strong><?php echo $comitato->nome; ?></strong>
                                        <?php if ( $t = $comitato->telefono ) { ?>
                                            <br /><i class="icon-phone"></i> <?php echo $t; ?>
                                        <?php } ?>
                                        <?php if ( $t = $comitato->email ) { ?>
                                            <br /><i class="icon-envelope"></i> <?php echo $t; ?>
                                        <?php } ?>
                                        <?php if ( $comitato->indirizzo ) { ?>
                                            <br /><span class="muted"><?php echo $comitato->indirizzo; ?></span>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                                <h4>&nbsp;</h4></ul>
                            </li>
                            <?php } ?>
                        <h4>&nbsp;</h4></ul>
                    </li>
                    <?php } ?>
                <h4>&nbsp;</h4></ul>
            </li>
            <?php } ?>
            
        </ul>
        
    </div>
    
    
    
    <div id="laMappa" class="span7 mappaGoogle bordo" style="min-height: 700px;">
        
               

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
      script.src = "https://maps.google.com/maps/api/js?sensor=false&callback=initialize";
      document.body.appendChild(script);
    }
    window.onload = loadScript;
</script>