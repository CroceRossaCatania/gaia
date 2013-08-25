<?php

paginaAdmin();

/*
 * ©2013 Croce Rossa Italiana
 */


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
    
<hr />
    
<div class="row-fluid">
   <div class="span12">
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Località</th>
                <th>Codice Fiscale</th>
                <th>Azioni</th>
            </thead>
        <?php
        $totale = 0;
        foreach($t as $_v) {
            if(count($_v->appartenenze()) == 0){
                $totale++;
            ?>
                <tr>
                    <td><?php echo $_v->nome; ?></td>
                    <td><?php echo $_v->cognome; ?></td>
                    <td>
                        <span class="muted">
                            <?php echo $_v->CAPResidenza; ?>
                        </span>
                        <?php echo $_v->comuneResidenza; ?>,
                        <?php echo $_v->provinciaResidenza; ?>
                    </td>
                    
                    <td>
                        
                            <?php echo $_v->codiceFiscale; ?>
                    </td>

                    <td>
                        <div class="btn-group">
                            <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $_v->id; ?>" title="Dettagli">
                                <i class="icon-eye-open"></i> Dettagli
                            </a>
                            <?php if ($_v->nome && $_v->cognome) {?>
                            <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>" title="Invia Mail">
                                <i class="icon-envelope"></i>
                            </a>
                            <a class="btn btn-small btn-info" href="?p=admin.limbo.comitato.nuovo&id=<?php echo $_v->id; ?>" title="Assegna a Comitato">
                                    <i class="icon-arrow-right"></i> Assegna a Comitato
                            </a>
                            <?php } ?>
                            
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
