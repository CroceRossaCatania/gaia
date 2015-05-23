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
            <?php 
            $marcatori = [];
            $finestre  = [];
            foreach($albero->regionali as $regionale) {

                if ( $regionale->indirizzo ) {
                    $marcatori[] = [EST_REGIONALE, $regionale->coordinate];
                    $finestre[]  = ["<strong>{$regionale->nome}</strong>", 
                    "{$regionale->indirizzo}<br />" .
                    "{$regionale->telefono}" .
                    "{$regionale->email}"
                    ];

                }
                ?>
                <li><a class="btn btn-link" onclick="$('#reg_<?php echo $regionale->id; ?>').toggle(500);">
                    <strong><?php echo $regionale->nome; ?></strong>
                </a>
                <ul class="nascosto" id="reg_<?php echo $regionale->id; ?>">
                    <?php if ( $t = $regionale->telefono ) { ?>
                    <i class="icon-phone"></i> <?php echo $t; ?>
                    <?php } ?>
                    <?php if ( $t = $regionale->email ) { ?>
                    <br /><i class="icon-envelope"></i> <?php echo $t; ?>
                    <?php } ?>
                    <?php if ( $t = $regionale->indirizzo ) { ?>
                    <br /><span class="muted"><?php echo $t; ?></span>
                    <?php } ?>
                    <h4>Comitati provinciali</h4>
                    <?php foreach ( $regionale->provinciali as $provinciale ) {

                        if ( $provinciale->indirizzo ) {
                            $marcatori[] = [EST_PROVINCIALE, $provinciale->coordinate];
                            $finestre[]  = ["<strong>{$provinciale->nome}</strong>", 
                            "{$provinciale->indirizzo}<br />" .
                            "{$provinciale->telefono}" .
                            "{$provinciale->email}"
                            ];
                        }
                        ?>
                        <li>
                            <a class="btn btn-link" onclick="$('#prov_<?php echo $provinciale->id; ?>').toggle(500);">
                                <?php echo $provinciale->nome; ?>
                            </a>
                            <ul class="nascosto" id="prov_<?php echo $provinciale->id; ?>">
                                <?php if ( $t = $provinciale->telefono ) { ?>
                                <i class="icon-phone"></i> <?php echo $t; ?>
                                <?php } ?>
                                <?php if ( $t = $provinciale->email ) { ?>
                                <br /><i class="icon-envelope"></i> <?php echo $t; ?>
                                <?php } ?>
                                <?php if ( $t = $provinciale->indirizzo ) { ?>
                                <br /><span class="muted"><?php echo $t; ?></span>
                                <?php } ?>
                                <h4>Comitati locali</h4>
                                <?php foreach ( $provinciale->comitati as $locali ) {

                                    if ( $locali->indirizzo ) {
                                        $marcatori[] = [EST_LOCALE, $locali->coordinate];
                                        $finestre[]  = ["<strong>$locali->nome</strong>", 
                                        "{$locali->indirizzo}<br />" .
                                        "{$locali->telefono}<br />" .
                                        "{$locali->email}"
                                        ];
                                    }
                                    ?>
                                    <li>
                                        
                                        <a class="btn btn-link" onclick="$('#loc_<?php echo $locali->id; ?>').toggle(500);">
                                            <?php echo $locali->nome; ?>
                                        </a>
                                        <ul class="nascosto" id="loc_<?php echo $locali->id; ?>">
                                            <?php if ( $t = $locali->telefono ) { ?>
                                            <i class="icon-phone"></i> <?php echo $t; ?>
                                            <?php } ?>
                                            <?php if ( $t = $locali->email ) { ?>
                                            <br /><i class="icon-envelope"></i> <?php echo $t; ?>
                                            <?php } ?>
                                            <?php if ( $t = $locali->indirizzo ) { ?>
                                            <br /><span class="muted"><?php echo $t; ?></span>
                                            <?php } ?>
                                            <?php if(count($locali->unita) > 1) { ?>
                                            <h4>Unità territoriali</h4>
                                            <?php foreach ( $locali->unita as $comitato ) { 
                                                if ($locali->principale != $comitato->id) {
                                                    if ( $comitato->indirizzo ) {
                                                        $marcatori[] = [EST_UNITA, $comitato->coordinate];
                                                        $finestre[]  = ['Unità territoriale', 
                                                        "<strong>{$comitato->nome}</strong><br />" .
                                                        "{$comitato->indirizzo}<br />" .
                                                        "{$comitato->telefono}<br />" 
                                                        ];
                                                    }
                                                    ?>
                                                    <li>
                                                        <strong><?php echo $comitato->nome; ?></strong>
                                                        <?php if ( $t = $comitato->telefono ) { ?>
                                                        <br /><i class="icon-phone"></i> <?php echo $t; ?>
                                                        <?php } ?>
                                                        <?php if ( $comitato->indirizzo ) { ?>
                                                        <br /><span class="muted"><?php echo $comitato->indirizzo; ?></span>
                                                        <?php } ?>
                                                    </li>
                                                    <?php }
                                                } ?>
                                                <h4>&nbsp;</h4>
                                                <?php } ?>
                                            </ul>
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
                        <?php
                        $icone = [
                        EST_REGIONALE     =>  'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
                        EST_PROVINCIALE   =>  'https://maps.google.com/mapfiles/ms/icons/orange-dot.png',
                        EST_LOCALE        =>  'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
                        EST_UNITA         =>  'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                        ];
                        ?>
                        function initialize() {
                          var opzioni = {
                            zoom: 6,
                            center: new google.maps.LatLng(41.9,12.4833333),
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        }
                        var map = new google.maps.Map(document.getElementById("laMappa"), opzioni);
                        
                        var messaggio = [], marcatore = [];                         
                        <?php $i = 0; foreach ($marcatori as $m) { 
                            ?>
                            messaggio.push(new google.maps.InfoWindow({
                                content: "<?php echo $finestre[$i][0]; ?>:<br /><?php echo $finestre[$i][1]; ?>"
                            }));
                            marcatore.push(new google.maps.Marker({
                                position: new google.maps.LatLng(<?php echo $m[1][0] ?>, <?php echo $m[1][1] ?>),
                                map: map, animation: google.maps.Animation.DROP, icon: '<?php echo $icone[$m[0]]; ?>'
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