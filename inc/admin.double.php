<?php

paginaAdmin();

/*
 * ©2013 Croce Rossa Italiana
 */


$t = Volontario::elenco();
?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-superscript muted"></i>
            Double or more (Volontari con più appartenenze)
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
            <th>Località</th>
            <th>Codice Fiscale</th>
            <th>Stato</th>
            <th>Azioni</th>
        </thead>
        <?php
        $totale = 0;
        foreach($t as $_v) {
            $appartenenze = $_v->appartenenzeAttuali(MEMBRO_VOLONTARIO);
            if(count($appartenenze) >= 2){
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
                    
                    <td><?php echo $_v->codiceFiscale; ?></td>
                    <td><?php echo $conf['statoPersona'][$_v->stato]; ?></td>

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
                    Abbiamo <?php echo $totale; ?> appartenenze double...                
                </h2>
            </div>
        </div>
    </div>
