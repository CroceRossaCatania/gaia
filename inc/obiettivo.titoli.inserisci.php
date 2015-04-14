<?php

/*
 * ©2015 Croce Rossa Italiana
 */

$t = 4;

$titoli = $conf['titoli'][$t];

paginaPrivata();

?>
<div class="row-fluid">
    <div class="span12">
        <h2><i class="icon-plus-sign-alt muted"></i> Titoli CRI</h2>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-warning-sign"></i> Attenzione: revisione dei titoli in corso</h4>
            <p>I titoli CRI sono momentaneamente incompleti data la revisione di tutti i percorsi formativi in atto a livello nazionale.
            <p>Ti preghiamo di pazientare fino a che il processo non sarà concluso. </p>   </p>     
        </div>

        <?php if ( isset($_GET['gia'] ) ) { ?>
        <div class="alert alert-error">
            <i class="icon-warning-sign"></i>
            <strong>Errore</strong> &mdash; Non puoi inserire lo stesso titolo o qualifica due volte.
        </div>
        <?php } ?>
        
        <div id="step1">
            <div class="alert alert-block alert-success" <?php if ($titoli[2]) { ?>data-richiediDate<?php } ?>>
                <!--<div class="row-fluid">
                    <h4>Aggiungi</h4>
                </div>-->
                <div class="row-fluid">
                    <span class="span3">
                        <label for="cercaTitolo">
                            <span style="font-size: larger;">
                                <i class="icon-search"></i>
                                <strong>Aggiungi</strong>
                            </span>
                        </label>

                    </span>
                    <span class="span9">
                        <input type="text" autofocus data-t="<?php echo $t; ?>" required id="cercaTitolo" placeholder="Cerca un titolo..." class="span12" />
                    </span>
                </div>

            </div>

            <table class="table table-striped table-condensed table-bordered" id="risultatiRicerca" style="display: none;">
                <thead>
                    <th>Nome risultato</th>
                    <th>Aggiungi</th>
                </thead>
                <tbody>

                </tbody>
            </table>
            
        </div>
        
        <div id="step2" style="display: none;">
                <div class="alert alert-block alert-success">
                    <div class="row-fluid">
                        <h4><i class="icon-question-sign"></i> Quando è stato ottenuto...</h4>
                    </div>
                    <hr />
                    <div class="row-fluid">
                        <div class="span4 centrato">
                            <label for="dataInizio"><i class="icon-calendar"></i> Ottenimento</label>
                        </div>
                        <div class="span8">
                            <input id="dataInizio" class="span12" name="dataInizio" type="text" <?php if ($titoli[3]) { ?>required<?php } ?> value="" />
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4 centrato">
                            <label for="dataFine"><i class="icon-time"></i> Scadenza</label>
                        </div>
                        <div class="span8">
                            <input id="dataFine" class="span12" name="dataFine" type="text" <?php if ($titoli[3]) { ?>required<?php } ?> value="" />
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4 centrato">
                            <label for="luogo"><i class="icon-road"></i> Luogo</label>
                        </div>
                        <div class="span8">
                            <input id="luogo" class="span12" name="luogo" type="text" required value="" />
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4 centrato">
                            <label for="codice"><i class="icon-barcode"></i> Codice</label>
                        </div>
                        <div class="span8">
                            <input id="codice" class="span12" name="codice" type="text" value="" />
                        </div>
                    </div>
                    
                </div>
                
            </div>

            <div id="step3" style="display: none;">
            <form action='?p=utente.titolo.nuovo' method="POST">
                <input type="hidden" name="idTitolo" id="idTitolo" />
                <div class="alert alert-block alert-success">
                    <div class="row-fluid">
                        <h4><i class="icon-question-sign"></i> Quando è stato ottenuto...</h4>
                    </div>
                    <hr />
                    <div class="row-fluid">
                        <div class="span4 centrato">
                            <label for="dataInizio"><i class="icon-calendar"></i> Ottenimento</label>
                        </div>
                        <div class="span8">
                            <input id="dataInizio" class="span12" name="dataInizio" type="text" <?php if ($titoli[3]) { ?>required<?php } ?> value="" />
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4 centrato">
                            <label for="dataFine"><i class="icon-time"></i> Scadenza</label>
                        </div>
                        <div class="span8">
                            <input id="dataFine" class="span12" name="dataFine" type="text" <?php if ($titoli[3]) { ?>required<?php } ?> value="" />
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4 centrato">
                            <label for="luogo"><i class="icon-road"></i> Luogo</label>
                        </div>
                        <div class="span8">
                            <input id="luogo" class="span12" name="luogo" type="text" required value="" />
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4 centrato">
                            <label for="codice"><i class="icon-barcode"></i> Codice</label>
                        </div>
                        <div class="span8">
                            <input id="codice" class="span12" name="codice" type="text" value="" />
                        </div>
                    </div>
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
