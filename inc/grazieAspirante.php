<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

/* Invia la mail */
$m = new Email('registrazioneAspirante', 'Grazie futuro volontario');
$m->a = $sessione->utente();
$m->_NOME       = $sessione->utente()->nome;
$m->invia();

?>

<div class="alert alert-block alert-success">
  <h4>Grazie, <?php echo $sessione->utente()->nome; ?>.</h4>
  <p>Ti contatteremo al più presto con informazioni sul prossimo corso base.</p>
</div>

<a href="?p=home">Torna alla home</a>.