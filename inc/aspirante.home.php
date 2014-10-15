<?php

paginaPrivata();

if ( $me->stato != ASPIRANTE )
	redirect('utente.me');

$iscritto = false;
$corso = $me->partecipazioniBase(ISCR_CONFERMATA); 
if($corso) {
	$iscritto = true;
	$corso = $corso[0];

} else {
	$a = Aspirante::daVolontario($me);
	$a->trovaRaggioMinimo();
}


// Se non ho ancora registrato il mio essere aspirante
if (!$iscritto && !$a)
	redirect('aspirante.registra');

?>
<div class="row-fluid">
    <div class="span3">
        <?php if($iscritto) {
        		menuOrdinario();
        	} else {
        		menuAspirante();
        	} 
        ?>

    </div>
    <div class="span9">

		<h2><span class="muted">Ciao </span>
            <?= $me->nome; ?>
        </h2>
		<?php if(isset($_GET['err'])) { ?>
			<div class="alert alert-block alert-error">
            <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
            <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
        	</div> 

		<?php } 

		if(!$iscritto) { ?>

		<div class="alert alert-block alert-info">
			<p><i class="icon-info-sign"></i> Riceverai notifica per email (<?php echo $me->email; ?>) 
			quando verranno organizzati nuovi corsi.</p>
			<p>Hai scelto di cercare corsi vicino a <strong><?php echo($a->luogo); ?></strong> se vuoi
			specificare una località differente clicca su <strong><i class="icon-map-marker"></i> Dove ti trovi?</strong> nel menù di sinistra.</p>
	    </div>

	    <div class="row-fluid">

	    	<div class="span4 offset2 allinea-centro">
		    	<div class="well">
		    		<i class="icon-map-marker"></i> Nella tua zona sono presenti<br />
	    			<span class="aspiranti_contatore">
	    				<?php echo $a->numComitati(); ?></span>
	    			<br />
	    			<span class="aspiranti_descrizione">Unit&agrave; CRI</span>
	    			<hr />
	    			<a class="btn btn-block btn-large" href="?p=aspirante.elenco.comitati">
	    				<i class="icon-globe"></i>
	    				Scopri quali sono
    				</a>

		    	</div>
	    	</div>


	    	<div class="span4 allinea-centro">
		    	<div class="well">
		    		<i class="icon-calendar-empty"></i> Attualmente organizzati<br />
	    			<span class="aspiranti_contatore">
	    				<?php echo $a->numCorsiBase(); ?></span>
	    			<br />
	    			<span class="aspiranti_descrizione">Corsi base</span>
	    			<hr />
	    			<a class="btn btn-block btn-success btn-large" href="?p=aspirante.elenco.corsi">
	    				<i class="icon-list"></i> Vedi tutti
    				</a>
		    	</div>
	    	</div>

	    </div>

	    <?php } else { ?>
	    	<div class="row-fluid">
            	<div class="hero-unit" >
                	<h1><i class="icon-flag"></i> Complimenti, sei iscritto ad un Corso per Volontari! </h1>
                	<br />
                	<p>Ora non ti resta che presentarti presso il luogo indicato per lo svolgimento
                	delle lezioni. Se hai bisogno di maggiori informazioni 
                	accedi alla scheda corso.</p>
                	<a href="?p=formazione.corsibase.scheda&id=<?= $corso->corsoBase; ?>" class="btn btn-large btn-info">
                		Scheda corso
                	</a>
            	</div>
        	</div>
	    <?php }?>
		    	

    </div>
</div>



<?php //yeah, funziona. var_dump($a->comitati(), $a->raggio);