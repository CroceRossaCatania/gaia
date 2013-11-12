<?php

/*
 * ©2013 Croce Rossa Italiana
 */

if($_GET['sca']){ ?>

	<div class="alert alert-block alert-error">
	  <h4><i class="icon-exclamation-sign"></i> Richiesta scaduta o non effettuata</h4>
	  <p>La richiesta di sostituzione della email è scaduta o non è mai stata effettuata, compila i campi qui sotto per effettuarne una nuova</p>
	</div>

<?php }elseif($_GET['gia']) { ?>

	<div class="alert alert-block alert-error">
	  <h4><i class="icon-exclamation-sign"></i> Richiesta già effettuata</h4>
	  <p>La richiesta di sostituzione della email è stata già effettuata controlla la tua email</p>
	</div>
	
<?php }else{ ?>

<h2><i class="icon-ok muted"></i> Indirizzo email sostituito</h2>
<p>La richiesta di variazione dell'indirizzio email che hai è andata a buon fine.</p>
<?php } ?>