<?php
/*
* ©2015 Croce Rossa Italiana
*/
paginaPubblica();
controllaBrowser();
?>

<div class="modal fade automodal">
    <div class="modal-header">
        <h3 class="text-success"><i class="icon-user"></i>Non sei ancora volontario?</h3>
    </div>
    <div class="modal-body">
        <p class="allinea-centro">
            <a href="?p=riconoscimento&tipo=aspirante" class="btn btn-large btn-success">
                <i class="icon-user"></i>
                <strong>Confermo!</strong> <em>Vorrei iscrivermi al prossimo corso base!</em>
            </a>
            <br/>
            <br/>
            <a href="?p=riconoscimento&tipo=volontario" class="btn btn-primary btn-large">
                <i class="icon-user"></i>
                <strong>No!</strong> <em>Sono già un volontario di Croce Rossa!</em>
            </a>
        </p>
    </div>
    <div class="modal-footer">
        
        
    </div>
</div>
