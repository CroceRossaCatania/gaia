<?php

paginaPrivata();

// Se non ho ancora registrato il mio essere aspirante
if ( !($a = Aspirante::daVolontario($me)) )
	redirect('aspirante.registra');

?>
<div class="row-fluid">
    
    <div class="span6">
        <h1>
            <i class="icon-map-marker"></i>
            Localit&agrave; preferita
        </h1>
    </div>
    <div class="span6">
        <div class="alert alert-info">
            <i class="icon-info-sign"></i> <strong>Dove vivi o vorresti fare il corso?</strong>
            Scegli una localit&agrave; come zona presso la quale preferiresti effettuare il Corso.
        </div>
    </div>
            
</div>

<div class="row-fluid">
    
    <div class="span3">
        <h2>
            1. <i class="icon-search"></i> Ricerca
        </h2>
        
        <hr />
        
        <p>Inserisci un indirizzo geografico.</p>
        
        <div class="input-append">
            <input type="text" id="ricercaLuogo" class="input-large" autofocus placeholder="es.: Via Massimo, 50 Roma" value="<?php echo $a->luogo; ?>" />
            <button class="btn btn-success">
                <i class="icon-search"></i>
            </button>
        </div>
    </div>
    
    
    <div class="span4">
        <h2>
            2. <i class="icon-list"></i> Seleziona
        </h2>
        
        <hr />
        
        <p>Seleziona un risultato tra i seguenti:</p>
        
        <div id="quiRisultati">
            <div class="alert alert-info">
                <i class="icon-info-sign"></i>
                Ancora nessuna ricerca effettuata.
            </div>
        </div>
    </div>
    
    
    <div class="span5">
        <h2>
            3. <i class="icon-check"></i> Controlla
        </h2>
        
        <hr />
        
        <p>Controlla che la posizione sulla mappa sia corretta:</p>
        
        <div class="mappaGoogle" id="mappaGeografica" style="height: 500px; width: 100%;"></div>
        
        <hr />
        <form action="?p=aspirante.localita.ok" method="POST">
            <input type="hidden" id="formattato" name="formattato" value="<?php echo $a->luogo; ?>" />
            <button id="pulsanteOk" type="submit" class="btn btn-block btn-success btn-large disabled" disabled="disabled">
                <i class="icon-ok"></i> Accetta questa posizione
            </button>
            
        </form>
    </div>
    
</div>