<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();
?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Riserva Approvata</strong>.
            Riserva approvata con successo.
        </div>
        <?php } ?>
        <?php if ( isset($_GET['no']) ) { ?>
        <div class="alert alert-error">
            <i class="icon-warning-sign"></i> <strong>Riserva negata</strong>.
            Riserva negata.
        </div>
        <?php } ?>
<?php if ( isset($_GET['prot']) ) { ?>
        <div class="alert alert-info">
            <i class="icon-save"></i> <strong>Richiesta Protocollata</strong>.
            Richiesta di riserva protocollata con successo.
        </div>
<?php } ?>
<br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-pause muted"></i>
            Riserve in attesa
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontari..." type="text">
        </div>
    </div>    
</div>
    
<hr />
<table class="table table-striped table-bordered" id="tabellaUtenti">
    <thead>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Codice Fiscale</th>
        <th>Data richiesta</th>
        <th>Motivo</th>
        <th>Periodo</th>
        <th>Azione</th>
    </thead>
<?php
$comitati= $me->comitatiDiCompetenza();
foreach($comitati as $comitato){
    foreach($comitato->riserve(RISERVA_INCORSO) as $_t){
        $_v = $_t->volontario();
        $c=$_t->comitato();
 ?>
    <tr>
        <td><?php echo $_v->nome; ?></td>
        <td><?php echo $_v->cognome; ?></td>
        <td><?php echo $_v->codiceFiscale; ?></td>
        <td><?php echo date('d/m/Y', $_t->timestamp); ?></td> 
        <td><?php echo $_t->motivo; ?></td>
        <td><small>
                                <i class="icon-calendar muted"></i>
                                <?php echo date('d/m/Y', $_t->inizio); ?>
                                
                                <?php if ( $_t->fine ) { ?>
                                    <br />
                                    <i class="icon-time muted"></i>
                                    <?php echo date('d/m/Y', $_t->fine); ?>
                                <?php } ?>
                </small>
        </td>
        
        <?php if($_t->protNumero){ ?>
        <td>
            <div class="btn-group">
                <a class="btn btn-primary" target="_new" href="?p=presidente.riserva.storico&id=<?php echo $_v->id; ?>">
                    <i class="icon-time"></i> Riserve
                </a>
                <a class="btn btn-success" href="?p=presidente.riserva.ok&id=<?php echo $_t->id; ?>&si">
                    <i class="icon-ok"></i> Conferma
                </a>
                <a class="btn btn-danger" onClick="return confirm('Vuoi veramente negare la riserva a questo utente ?');" href="?p=presidente.riservaNegato&id=<?php echo $_t->id; ?>">
                    <i class="icon-ban-circle"></i> Nega
                </a>
            </div>
        <?php }else{ ?>
        <td>   
            <div class="btn-group">
                <a class="btn btn-info" href="?p=presidente.riservaRichiesta.stampa&id=<?php echo $_t->id; ?>">
                    <i class="icon-print"></i> Stampa richiesta
                </a>
                <a class="btn btn-success" href="?p=presidente.riservaRichiesta&id=<?php echo $_t->id; ?>&si">
                    <i class="icon-ok"></i> Protocolla richiesta
                </a>
            </div>
        <?php } ?>    
        </td>
       
    </tr>
    <?php }
    } ?>
</table>