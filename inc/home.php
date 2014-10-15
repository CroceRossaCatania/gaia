<?php

paginaPubblica(); 
?>

    <div class="container">
        <div class="row-fluid centrato">
            <div class="span6">
            	<h2>Già volontario? </h2>
                    <h3 class="muted">Registrati su Gaia.</h3>
                    <div class="well">
                        <a href="?p=riconoscimento&tipo=volontario" class="btn btn-large btn-success btn-block">
                            <i class="icon-user"></i>
                            Registrati ora
                        </a>
                    </div>

                    
                    <p><strong>Gaia è il nuovo sistema informativo</strong> che ti permetterà di venire a conoscenza immediatamente
                        delle attività organizzate e dare la tua disponibilità con un click da pc o smartphone.</p>
                                    
                    <p>È semplice e richiede poco tempo.<br />Clicca qui sopra e segui le istruzioni.</p>
                    
                    <p>&nbsp;</p>

    			
    			
            </div>

            <div class="span6">
            	<h2>Vuoi entrare in Croce Rossa?</h2>
                    <h3 class="muted">Partecipa al prossimo corso base.</h3>
                    <div class="well">
                        <a href="?p=riconoscimento&tipo=aspirante" class="btn btn-large btn-danger btn-block">
                            <i class="icon-hand-right"></i>
                            Iscriviti al prossimo corso base
                        </a>
                    </div>
                    
                    <p>Organizziamo continuamente corsi base per gli aspiranti volontari.</p>
                    <p>Il volontariato in Croce Rossa ti cambierà la vita, <a href="http://www.cri.it/diventavolontario" target="_new" ><i class="icon-link"></i> scopri perché</a>.</p>
                    <p>Clicca sul pulsante qui sopra: verrai richiamato da un volontario ed informato sul prossimo corso base a te vicino.</p>
                    <p>&nbsp;</p>

                    
        	</div>

          </div>
      </div>

      



<div style="background-image: url('./img/HomePage2.jpg');" class="row-fluid blocco-con-sfondo centrato">
    <div class="span6">
        <h3 id="rollerComitati">&nbsp;</h3>
        <h3>&egrave; su Gaia.</h3>
    </div>
    <div class="span6">
        <h3><?= 1240; //Comitato::conta(); ?> unit&agrave; territoriali sono gi&agrave; su Gaia.</h3>
        <p class="grassetto" id=""></p>
        <p>
            <a href="?p=public.comitati.mappa" class="btn btn-large">
                <i class="icon-globe"></i>
                Mappa completa dei comitati con recapiti
            </a>
        </p>
          
    </div>
    
    <script type="text/javascript">
        comitati = <?php
        $c = [];
        foreach ( Comitato::elenco() as $k ) {
            $c[] = $k->nomeCompleto();
        }
        echo json_encode($c);
        ?>;
    </script>
        
    
</div>

<p>&nbsp;</p>

<div class="container">
    <div class="row-fluid centrato">
        
        <div class="span4">
            <h1 style="font-size: 4em;">
                <span style="transform: rotate(10deg); -webkit-transform: rotate(10deg);" class="text-info">
                    - 
                        <i class="icon-time"></i>
                        <i class="icon-file-alt"></i>
                </span>
                
                <br />

                &nbsp; &nbsp; &nbsp;
                
                <span class="text-success">
                    +
                        <i class="icon-group"></i>
                        <i class="icon-bolt"></i>
                </span>
            </h1>

        </div>
        <div class="span4 well well-small sf2">
            <h3 class="muted"><i class="icon-minus-sign"></i> Carte</h3>
            <h2 class="text-error"><i class="icon-plus-sign"></i> Volontariato</h2>
        </div>
        
        <div class="span4">
            <p>&nbsp;</p>
            <p>Gaia nasce per <strong>eliminare carte e tempi morti</strong>.</p>
            <p>Via il superfluo, <big>resta il volontariato</big>.</p>
            <p>Trasparente ed efficiente.</p>
        </div>
        
    </div>
</div>

<hr />

<div class="container">
    <div class="row-fluid centrato">
        
        <div class="span6">
                   
            <h2 class="text-info">Porta Gaia sempre con te.</h2>
            <h3>&Egrave; arrivato Gaia per Android.</h3>

            <a href="https://play.google.com/store/apps/details?id=it.gaiacri.mobile">
                <img src="https://developer.android.com/images/brand/it_generic_rgb_wo_45.png" 
                     alt="Applicazione Gaia per Android disponibile sul Play Store di Google" />
            </a>

            <hr />

            <h1>
                <i class="icon-desktop"></i>
                <i class="icon-laptop"></i>
                
                &nbsp; 
                <i class="icon-plus muted"></i>
                &nbsp; 
                
                <i class="icon-mobile-phone"></i>
                <i class="icon-tablet"></i>
            </h1>
            
            <p>Immagina le potenzialità di Gaia in movimento.</p>
            <p>Stiamo lavorando affinché <strong>Croce Rossa Italiana</strong> sappia <strong>muoversi con te</strong>.</p>
            <p class="text-error">
                <i class="icon-warning-sign"></i> 
                <strong>Cerchiamo gente in gamba</strong>.
                <a href="https://github.com/AlfioEmanueleFresta/gaia-android" target="_new">
                    Scopri il progetto Gaia Mobile
                </a>
            </p>

        </div>
        
        <div class="span6  well small sf3">
            <img src="./img/android.png" />
        </div>
    </div>
</div>


<div class="container"> <!-- rimane aperto, si... -->
<div class="row-fluid">
    <div class="hero-unit span12">
      <h1>Il progetto Gaia</h1>
      <p>Stiamo tutti lavorando per rendere la Croce Rossa Italiana nuova, più efficiente e trasparente.</p>
      <p>
        <a href="?p=public.about" class="btn btn-primary btn-large">
          Scopri come...
        </a>
      </p>
    </div>
    
</div>
