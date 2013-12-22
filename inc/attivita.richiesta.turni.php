<?php

/* 
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaAttivita();

controllaParametri(array('id'));
$t = Turno::id($_GET['id']);


?>
    <div class="row-fluid">
        
        <?php if ( isset($_GET['del']) ) { ?>
            <div class="alert alert-danger">
                <i class="icon-ok"></i> <strong>Titolo richiesto rimosso</strong>.
                Il titolo non sarà più necessario per partecipare all'attività
            </div>
        <?php } ?>
        <?php if ( isset($_GET['gia']) ) { ?>
            <div class="alert alert-info">
                <i class="icon-ok"></i> <strong>Titolo richiesto già inserito</strong>.
                Il titolo che stai cercando di inserire risulta già presente nei requisiti per partecipare all'attività
            </div>
        <?php } ?>

        <div class="span12 allinea-sinistra">
            <h2>
                <i class="icon-pencil muted"></i>
                Richieste particolari di titoli
            </h2>
        </div>

    <div class="span12">
        
        <div id="i1" class="alert alert-block alert-info nascosto">
            <h4><i class="icon-info-sign"></i> <strong>Titoli</strong>.</h4>
            <p>Titoli ti permette di specificare un titolo necessario a fine dello svolgimento del turno.</p>
            <p>In un turno con <strong>richiesta di titoli</strong> potranno partecipare solo i volontari in
                possesso dei titoli specificati.</p>
        </div>

        <table class="table table-striped table-bordered" id="tabellaTurni">
             <thead>
                <th>&nbsp;</th>
                <th>
                    Richieste
                    <a href="#" onclick="$('#i1').toggle(500);">
                        <i class="icon-question-sign"></i>
                    </a>
                </th>
                <th> Azioni</th>
             </thead>
             
             <?php 
             //seleziona tutte le richieste con turno = turno e prende i vari elementi.
             //per ogni elemento stampa una riga
             foreach ( $t->richieste() as $r ) { 
                foreach ( $r->elementi() as $e ) { ?>
             <tr>
                 <td>
                    Titolo necessario
                </td>
                 <td>
                    <?= $e->titolo()->nome; ?>
                </td>
                <td>
                    <a class="btn btn-danger" onClick="return confirm('Vuoi veramente togliere questa rischiesta di titolo ?');" href="?p=attivita.richiesta.turni.cancella&id=<?= $e; ?>">
                            <i class="icon-trash"></i>
                    </a>
                </td>
             </tr>
         <?php }
            } ?>
            <tr>
                <td>
                    <?php if($t->richieste()){ ?> e <?php }else{ ?> Titolo necessario <?php } ?>
                </td>
                <td>
                    <div class="span6">
                        <div id="step1">
                            <div class="row-fluid">
                                <span class="span12">
                                    <input type="text" autofocus required id="cercaTitolo" placeholder="Inserisci un titolo..." class="span12" />
                                </span>
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
                            <form action='?p=attivita.richiesta.turni.ok&t=<?php echo $t; ?>' method="POST">
                                <input type="hidden" name="idTitolo" id="idTitolo" />
                                <div class="alert alert-block alert-success">
                                    <div class="row-fluid">
                                        <div class="span4 offset8">
                                            <button type="submit" class="btn btn-success">
                                                <i class="icon-plus"></i>
                                                    Aggiungi il titolo
                                            </button>
                                        </div>
                                    </div>
                                
                                </div>
                            </form>
                        </div>
                    </div>
                </td>
                <td>
                </td>
            </tr>
        </table>
    </div>
</div>
