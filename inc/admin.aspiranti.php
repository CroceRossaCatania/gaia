<?php

paginaAdmin();

/*
 * ©2013 Croce Rossa Italiana
 */

set_time_limit (0);

$t = Utente::filtra([['stato', ASPIRANTE]]);
?>
<script type="text/javascript"><?php require './assets/js/presidente.utenti.js'; ?></script>
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
            Aspiranti
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
            $totale++; ?>
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
        <?php } ?>
        </table>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <h2>
                Abbiamo <?php echo $totale; ?> aspiranti                
            </h2>
        </div>
    </div>
</div>
