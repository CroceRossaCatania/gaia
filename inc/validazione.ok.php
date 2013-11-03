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
	
<?php }elseif($_GET['pass']){ ?>

	<h2><i class="icon-ok muted"></i> Hai una nuova email</h2>
	<p>La nuova password ti è stata spedita per email.</p>

<?php }elseif($_GET['mail']){ ?>

	<h2><i class="icon-ok muted"></i> Indirizzo email sostituito</h2>
	<p>Ora puoi accedere utilizzando il tuo nuovo indirizzo email</p>

<?php } ?>
<a href="?p=login" class="btn btn-large"><i class="icon-key"></i> Accedi</a>