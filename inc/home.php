<?php

paginaPubblica(); 
?>
      <div class="row-fluid centrato">
        <div class="span6">
        	<h2>Già volontario? </h2>
                <h3 class="muted">Registrati su Gaia.</h3>
                <hr />
                <div class="well">
                    <a href="?p=riconoscimento&tipo=volontario" class="btn btn-large btn-success btn-block">
                        <i class="icon-user"></i>
                        Registrati ora
                    </a>
                </div>

                
                <p><strong>Gaia è il nuovo sistema informativo</strong> che ti permetterà di venire a conoscenza immediatamente
                    delle attività organizzate e dare la tua disponibilità con un click da pc o smartphone.</p>
                                
                <p>È semplice e richiede poco tempo.<br />Clicca qui sotto e segui le istruzioni.</p>
                
                <p>&nbsp;</p>

			
			
        </div>

        <div class="span6">
        	<h2>Vuoi entrare in Croce Rossa?</h2>
                <h3 class="muted">Partecipa al prossimo corso base.</h3>
                <hr />
                <div class="well">
                    <a href="?p=riconoscimento&tipo=aspirante" class="btn btn-large btn-danger btn-block">
                        <i class="icon-hand-right"></i>
                        Iscriviti al prossimo corso base
                    </a>
                </div>
                
                <p>Organizziamo continuamente corsi base per gli aspiranti volontari.</p>
                <p>Il volontariato in Croce Rossa ti cambierà la vita, <a href="javascript:" onclick="window.open('/inc/public.scopriperche.php', 'ScopriPerche', 'width=600, height=500, resizable, status, scrollbars=1, location');"><i class="icon-link"></i> scopri perché</a>.</p>
                <p>Clicca sul pulsante qui sotto: verrai richiamato da un volontario ed informato sul prossimo corso base a te vicino.</p>
                <p>&nbsp;</p>

                
    	</div>

      </div>
      

<hr />

<div class="row-fluid centrato">
    <div class="span12">
        <p class="text-info"><strong>Comitati già su Gaia...</strong></p>
   
        <p class="grassetto" id="rollerComitati"></i>
    </div>
    
    <script type="text/javascript">
        comitati = <?php
        $c = [];
        foreach ( Comitato::elenco() as $k ) {
            $c[] = $k->nome;
        }
        echo json_encode($c);
        ?>;
    </script>
        
    
</div>

<hr />

<div class="row-fluid centrato">
    
    <div class="span5 well well-small sf2">
        <h3 class="muted"><i class="icon-minus-sign"></i> Carte</h3>
        <h2 class="text-error"><i class="icon-plus-sign"></i> Volontariato</h3>
    </div>
    
    <div class="span7">
        <h1>
            <span class="text-info">
                - 
                    <i class="icon-time"></i>
                    <i class="icon-file-alt"></i>
            </span>
            
            &nbsp; &nbsp;
            
            <span class="text-success">
                +
                    <i class="icon-group"></i>
                    <i class="icon-bolt"></i>
            </span>
        </h1>
        <p>Gaia nasce per <strong>eliminare carte e tempi morti</strong>.</p>
        <p>Via il superfluo, <big>resta il volontariato</big>.</p>
        <p>Trasparente ed efficiente.</p>
    </div>
    
</div>

<hr />

<div class="row-fluid centrato">
    
    <div class="span7">
                <p>&nbsp;</p><p>&nbsp;</p>

        <h1>
            <i class="icon-desktop"></i>
            <i class="icon-laptop"></i>
            
            &nbsp; 
            <i class="icon-plus muted"></i>
            &nbsp; 
            
            <i class="icon-mobile-phone"></i>
            <i class="icon-tablet"></i>
        </h1>
        
        <p>&nbsp;</p>
        <p>Immagina le potenzialità di Gaia in movimento.</p>
        <p>Siamo lavorando affinché <strong>Croce Rossa Italiana</strong> sappia <strong>muoversi con te</strong>.</p>
        <p><a href="?p=public.about">Cerchiamo gente in gamba</a>.</p>
        
    </div>
    
    <div class="span5  well small sf3">
        <img src="./img/gaiamobile.png" />
    </div>
</div>


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