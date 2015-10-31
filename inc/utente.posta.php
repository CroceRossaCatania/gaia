<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata(); 



?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        <h2><i class="icon-envelope-alt muted"></i> Archivio comunicazioni</h2>

        <div class="row-fluid">
            <div id="azioni_posta" class="nascosto">
                <i class="icon-info"></i>
            </div>

            <div class="tabbable row-fluid">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_in" data-toggle="tab">
                        <i class="icon-inbox"></i>
                            In arrivo
                            <span class="badge badge-info" id="contatore_in">...</span>
                    </a></li>
                    <li><a href="#tab_out" data-toggle="tab">
                        <i class="icon-share-alt"></i>
                            Inviata
                            <span class="badge badge-info" id="contatore_out">...</span>
                    </a></li>
                </ul>
            </div>
            <div class="row-fluid">

                <div class="tab-content span4">

                    <div class="tab-pane active" id="tab_in">
                        <div
                             data-posta     ="true"
                             data-perpagina ="10"
                             data-direzione ="ingresso"
                             data-azioni    ="#azioni_posta"
                             data-messaggio ="#boxMessaggio"
                             data-contatore ="#contatore_in"
                        ></div>
                    </div>

                    <div class="tab-pane" id="tab_out">
                        <div
                             data-posta     ="true"
                             data-perpagina ="10"
                             data-direzione ="uscita"
                             data-azioni    ="#azioni_posta"
                             data-messaggio ="#boxMessaggio"
                             data-contatore ="#contatore_out"
                        ></div>
                    </div>
                </div>

                <div class="span8" id="boxMessaggio">
                    
                    <p class="alert alert-info">
                        <i class="icon-info-sign"></i>
                        Seleziona un messaggio per vederne il contenuto. <br>
                        Ti ricordiamo che per poter rispondere dovrai collegarti alla tua casella di posta.
                    </p>

                </div>
            </div>
        </div>

        <hr />

    </div>
</div>
