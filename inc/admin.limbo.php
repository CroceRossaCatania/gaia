<?php

paginaAdmin();

/*
 * ©2013 Croce Rossa Italiana
 */

set_time_limit (0);

$t = Volontario::elenco();
?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Utente eliminato</strong>.
            L'utente è stato eliminato con successo.
        </div>
<?php } elseif ( isset($_GET['nasp']) )  { ?>
        <div class="alert alert-success">
            <h4><i class="icon-save"></i> Nuovo Volontario assegnato</h4>
        </div>
<?php } ?>
<?php if (isset($_GET['err'])) { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
        <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
    </div> 
<?php } ?>
    <br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-meh muted"></i>
            Limbo (aka cose senza appartenenze)
        </h2>
    </div>

    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Aspiranti..." type="text">
        </div>
    </div>
    </div> 

    <div class="row-fluid">
        <div class="span2">
            <a  onClick="return confirm('Vuoi veramente cancellare tutte le persone senza dati? Solo se senza appartenenze');" href="?p=admin.limbo.pulizia&soft" title="Cancella chi non ha dati" class="btn btn-block btn-danger">
                <i class="icon-trash"></i> Pulizia soft
            </a>
        </div>
        <div class="span2">
            <a  onClick="return confirm('Vuoi veramente cancellare tutte le persone con codice fiscale orfano? Solo se senza appartenenze');" href="?p=admin.limbo.pulizia&hard" title="Cancella chi ha solo CF ma non appartenenze" class="btn btn-block btn-danger">
                <i class="icon-trash"></i> Pulizia meno soft
            </a>
        </div>
        <div class="span2">
            <a  onClick="return confirm('Vuoi veramente cancellare tutte le persone con anagrafica senza stato? Solo se senza appartenenze');" href="?p=admin.limbo.pulizia&extreme" title="Cancella chi ha anagrafica ma non stato" class="btn btn-block btn-danger">
                <i class="icon-trash"></i> Pulizia ancora meno soft
            </a>
        </div>
        <div class="span3">
            <a  onClick="return confirm('Vuoi veramente cancellare tutte le persone con anagrafica senza contatti? Solo se senza appartenenze');" href="?p=admin.limbo.pulizia&contatti" title="Cancella senza appartenenza ne contatti" class="btn btn-block btn-danger">
                <i class="icon-trash"></i> Pulizia contatti
            </a>
        </div>
        <div class="span3">
            <a  onClick="return confirm('Vuoi veramente cambiare stato ?');" href="?p=admin.limbo.cambiastato" title="Sistema gli stati rotti" class="btn btn-block btn-danger">
                <i class="icon-trash"></i> Fix aspiranti
            </a>
        </div>
    </div>
    
     

   <div class="row-fluid"> 
<hr>
</div>
    
<div class="row-fluid">
   <div class="span12">
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Codice Fiscale</th>
                <th>Stato</th>
                <th>Azioni</th>
            </thead>
        <?php
        $totale = 0;
        foreach($t as $_v) {
            $appartenenze = $_v->numAppartenenzeTotali();
            if($appartenenze == 0 || $_v->appartenenzaAttuale()->stato == MEMBRO_APP_NEGATA){
            $totale++;
            ?>
                <tr>
                    <td><?php echo $_v->nome; ?></td>
                    <td><?php echo $_v->cognome; ?></td>                 
                    <td><?php echo $_v->codiceFiscale; ?></td>
                    <td><?php echo $conf['statoPersona'][$_v->stato]; ?></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $_v->id; ?>" title="Dettagli">
                                <i class="icon-eye-open"></i> Dettagli
                            </a>
                            <?php if ($_v->email) {?>
                            <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>" title="Invia Mail">
                                <i class="icon-envelope"></i>
                            </a>
                            <?php } ?>
                            <a class="btn btn-small btn-primary" href="?p=admin.stato.modifica&id=<?php echo $_v->id; ?>" title="Cambia stato">
                                <i class="icon-random"></i> Cambia stato
                            </a>
                            <a class="btn btn-small btn-info" href="?p=admin.limbo.comitato.nuovo&id=<?php echo $_v->id; ?>" title="Assegna a Comitato" target="_new">
                                    <i class="icon-arrow-right"></i> Assegna a Comitato
                            </a>
                            <a  onClick="return confirm('Vuoi veramente cancellare questo utente ?');" href="?p=admin.limbo.cancella&id=<?php echo $_v->id; ?>" title="Cancella Utente" class="btn btn-small btn-warning">
                            <i class="icon-trash"></i> Cancella
                            </a>
                            
                        </div>
                   </td>
                </tr>
                
               
       
        <?php }}
        ?>

        
        </table>

    </div>

    <div class="row-fluid">
        <div class="span12">
            <h2>
                Abbiamo <?php echo $totale; ?> cose nel limbo...                
            </h2>
        </div>
    </div>
</div>
