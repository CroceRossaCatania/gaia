<?php

paginaPrivata();

if ( $me->stato != ASPIRANTE )
	redirect('utente.me');

// Se non ho ancora registrato il mio essere aspirante
if ( !($a = Aspirante::daVolontario($me)) )
	redirect('aspirante.registra');

$a->trovaRaggioMinimo();
?>
<div class="row-fluid">
    <div class="span3">
        <?php menuAspirante(); ?>
    </div>
    <div class="span9">

		<h2>Ciao, <?php echo $me->nome; ?>.</h2>

		<p class="alert alert-block alert-info">
			<i class="icon-info-sign"></i>
			Riceverai notifica per email (<?php echo $me->email; ?>) quando verranno organizzati nuovi corsi.
	    </p>

	    <div class="row-fluid">

	    	<div class="span4 offset2 allinea-centro">
		    	<div class="well">
		    		<i class="icon-map-marker"></i> Nella tua zona sono presenti<br />
	    			<span class="aspiranti_contatore">
	    				<?php echo $a->numComitati(); ?></span>
	    			<br />
	    			<span class="aspiranti_descrizione">Unit&agrave; CRI</span>
	    			<hr />
	    			<a class="btn btn-block btn-large" href="?p=public.comitati.mappa">
	    				<i class="icon-globe"></i>
	    				Mappa dei comitati
    				</a>

		    	</div>
	    	</div>


	    	<div class="span4 allinea-centro">
		    	<div class="well">
		    		<i class="icon-calendar-empty"></i> Attualmente organizzati<br />
	    			<span class="aspiranti_contatore">
	    				<?php echo rand(0,100); ?></span>
	    			<br />
	    			<span class="aspiranti_descrizione">Corsi base</span>
	    			<hr />
	    			<a class="btn btn-block btn-success btn-large">
	    				<i class="icon-list"></i> Vedi tutti
    				</a>
		    	</div>
	    	</div>

	    </div>
		    	

    </div>
</div>



<?php //yeah, funziona. var_dump($a->comitati(), $a->raggio);