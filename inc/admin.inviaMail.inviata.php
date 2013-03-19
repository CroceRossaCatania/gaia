<?php

/*
 * ©2013 Croce Rossa Italiana
 */
?>
<div class="row-fluid">
    <div class="span12">
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-ok"></i> <strong>Mail inviata</strong>.
            La tua mail è stata inviata con successo.
        </div>
        <?php } 
        if ( isset($_GET['no']) ) { ?>
        <div class="alert alert-error">
            <i class="icon-warning-sign"></i> <strong>Mail non inviata</strong>.
            La tua mail non è stata inviata, riprova o contattaci <a href="mailto:informatica@cricatania.it">informatica@cricatania.it</a>.
        </div>
        <?php } ?>
    </div>
</div>
