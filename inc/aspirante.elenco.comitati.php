<?php

paginaPrivata();

if ( $me->stato != ASPIRANTE )
	redirect('utente.me');

// Se non ho ancora registrato il mio essere aspirante
if ( !($a = Aspirante::daVolontario($me)) )
	redirect('aspirante.registra');

?>
<div class="row-fluid">
    <div class="span3">
        <?php menuAspirante(); ?>
    </div>
    <div class="span9">

		<h2><i class="icon-list"></i> Elenco delle unità CRI presenti nella tua zona</h2>
		<?php if(isset($_GET['err'])) { ?>
			<div class="alert alert-block alert-error">
            <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
            <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
        	</div> 

		<?php } ?>


	    <div class="row-fluid">

	    	

	    </div>
		    	

    </div>
</div>
