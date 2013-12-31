<?php

paginaPrivata();

if ( $me->stato != ASPIRANTE )
	redirect('utente.me');

// Se non ho ancora registrato il mio essere aspirante
if ( !($a = Aspirante::daVolontario($me)) )
	redirect('aspirante.registra');


$a->trovaRaggioMinimo();
var_dump( $a->trovaRaggioMinimo() );
?>
<div class="row-fluid">
    <div class="span3">
        <?php menuAspirante(); ?>
    </div>
    <div class="span9">

		<h2>Ciao, <?php echo $me->nome; ?>.</h2>

		<p class="text-info">
			<i class="icon-globe"></i>
			Ci sono <?php echo $a->numComitati(); ?> unit&agrave; CRI nelle tue vicinanze.
		   	Per ulteriori informazioni <a href="?p=public.comitati.mappa">consulta la mappa</a>.
	    </p>
		    	

    </div>
</div>



<?php //yeah, funziona. var_dump($a->comitati(), $a->raggio);