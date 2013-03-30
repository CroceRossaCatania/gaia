<?php

/*
 * ©2013 Croce Rossa Italiana
 */

if (isset($_GET['t'])) {
    $t = (int) $_GET['t'];
} else {
    $t = 0;
}
$titoli = $conf['titoli'][$t];

paginaPrivata();
 
?>
<hr />
<div class="row-fluid">
    <div class="span12">
        
        <div id="step1">
            

            <div class="alert alert-block alert-success" >
                <div class="row-fluid">
                    <span class="span3">
                        <label for="cercaTitolo">
                            <span style="font-size: larger;">
                                <i class="icon-search"></i>
                                <strong>Cerca</strong>
                            </span>
                        </label>

                    </span>
                    <span class="span9">
                        <input type="text" autofocus required id="cercaTitolo" placeholder="Cerca un titolo..." class="span12" />
                    </span>
                </div>

            </div>

            <table class="table table-striped table-condensed table-bordered" id="risultatiRicerca" style="display: none;">
                <thead>
                    <th>Nome risultato</th>
                    <th>Cerca</th>
                </thead>
                <tbody>

                </tbody>
            </table>
            
          </div>
        
        <div id="step2" style="display: none;">
            <form action='?p=presidente.titoli.ricerca.ok' method="POST">
            <input type="hidden" name="idTitolo" id="idTitolo" />
            <div class="alert alert-block alert-success">
                
                <hr />
                <div class="row-fluid">
                    <div class="span4 offset8">
                        <button type="submit" class="btn btn-success">
                            <i class="icon-plus"></i>
                                Aggiungi il titolo
                        </button>
                    </div>
                </div>
                
            </div>
            
        </div>    
    </div>
</div>
