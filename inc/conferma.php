<?php

/*
* ©2015 Croce Rossa Italiana
*/

paginaPubblica();
controllaBrowser();

/* Registra sulla sessione il tipo della registrazione! */
if ( isset($_GET['tipo'] ) ) {
    if ($_GET['tipo'] == 'volontario') {
        $sessione->tipoRegistrazione = VOLONTARIO;
    }
    elseif ($_GET['tipo'] == 'aspirante') {
        $sessione->tipoRegistrazione = ASPIRANTE;
    }
} elseif ( !$sessione->tipoRegistrazione) {
    $sessione->tipoRegistrazione = VOLONTARIO;
}
?>

<div class="modal fade automodal">
    <div class="modal-header">
        <h3 class="text-success"><i class="icon-user"></i> Sono già un volontario?!</h3>
    </div>
    <div class="modal-body">
        <p class="allinea-centro">
            <a href="?p=riconoscimento&tipo=volontario" class="btn btn-large btn-success">
                <i class="icon-user"></i>
                <strong>Confermo!</strong> <em>sono già un volontario!</em>
            </a>
            <br/>
            <br/>
            <a href="?p=riconoscimento&tipo=aspirante" class="btn btn-primary btn-large">
                <i class="icon-user"></i>
                <strong>No!</strong> <em>vorrei diventare un volontario!</em>
            </a>
        </p>
    </div>
    <div class="modal-footer">
        
        
    </div>
</div>