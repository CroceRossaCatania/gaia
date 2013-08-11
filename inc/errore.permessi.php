<?php

/*
 * ©2013 Croce Rossa Italiana
 */

if ( !$me instanceof Anonimo ) { 
    // Ricordati che l'utente si è comportato male...
    $me->cattivo = (int) $me->cattivo + 1;
    $me->tCattivo = time();
}
?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9 allinea-centro">
       
        <h3>Accesso negato</h3>
        <p>&nbsp;</p>
        <i class="icon-5x icon-lock text-error"></i> &nbsp; 
        <i class="icon-5x icon-warning-sign text-warning"></i>
        <hr />
        <p>Hai cercato di accedere a dei contenuti che non sono di tua competenza.</p>
        <p>Questo può essere dovuto a dei permessi temporanei che sono scaduti.</p>
        <p><a href="index.php"><i class="icon-home"></i> Torna alla home</a></p>
        <p>&nbsp;</p>
        <p class="text-info">
            <i class="icon-info-sign"></i> Nota che questo evento è stato registrato
            per motivi di sicurezza.
        </p>
        
    </div>
</div>