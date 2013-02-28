<?php

/*
 * ©2012 Croce Rossa Italiana
 */

?>

<?php if ( $sessione->tipoRegistrazione == VOLONTARIO ) { ?>
    <h2>Sei già registrato<span class="muted">, effettua l'accesso.</span></h2>
    <p>Se hai perso la password, puoi chiederne una nuova <a href="?p=recuperaPassword">cliccando qui</a>.</p>
    <p><a href="?p=login" class="btn btn-large"><i class="icon-key"></i> Effettua l'accesso</a></p>
<?php } else { ?>
    <h2>Sei già nei nostri database<span class="muted">.</span></h2>
    <p>Non c'è bisogno iscriversi nuovamente.</p>
    <p><a href="?p=home">Torna alla home</a>.</p>
<?php } ?>
