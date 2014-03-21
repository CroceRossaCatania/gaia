<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE ]);
menuElenchiVolontari(
    "Soci Ordinari Dimessi",
    "?p=admin.utenti.excel&ordinaridimessi",
    "?p=utente.mail.nuova&ordinaridimessicom"
);

?>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Socio Ordinario eliminato</strong>.
            Il Socio Ordinario è stato eliminato con successo.
        </div>
<?php } elseif ( isset($_GET['e']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Impossibile eliminare l'utente</h4>
            <p>Contatta l'amministratore</p>
        </div>
<?php } ?>
    
<div class="row-fluid">
   <div class="span12">
            
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Nascita</th>
                <th>C. Fiscale</th>
                <th>Residenza</th>
                <th>Cellulare</th>
                <th>Data Versamento</th>
                <th>Azioni</th>
            </thead>
        <?php
        $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $t = $comitato->membriOrdinariDimessi();
            ?>
            
            <tr class="success">
                <td colspan="8" class="grassetto">
                    <?php echo $comitato->nomeCompleto(); ?>
                    <span class="label label-warning">
                        <?php echo $comitato->numMembriOrdinariDimessi(); ?>
                    </span>
                    <a class="btn btn-success btn-small pull-right" href="?p=utente.mail.nuova&ordinaridimessiunit&id=<?php echo $comitato->id; ?>">
                           <i class="icon-envelope"></i> Invia mail
                    </a>
                    <a class="btn btn-small pull-right" 
                       href="?p=presidente.utenti.excel&ordinaridimessi&comitato=<?php echo $comitato->id; ?>"
                       data-attendere="Generazione...">
                            <i class="icon-download"></i> scarica come foglio excel
                    </a>
                </td>
            </tr>
            
            <?php
            foreach ( $t as $_v ) {
            ?>
                <tr>
                    <td><?php echo $_v->cognome; ?></td>
                    <td><?php echo $_v->nome; ?></td>
                    <td>
                        <?php echo date('d/m/Y', $_v->dataNascita); ?>, 
                        <?php echo $_v->comuneNascita; ?>
                        <span class="muted">
                            <?php echo $_v->provinciaNascita; ?>
                        </span>
                    </td>
                    <td><?php echo $_v->codiceFiscale; ?></td>
                    <td>
                        <span class="muted">
                            <?php echo $_v->CAPResidenza; ?>
                        </span>
                        <?php echo $_v->comuneResidenza; ?>,
                        <?php echo $_v->provinciaResidenza; ?>
                    </td>
                    
                    <td>
                        <span class="muted">+39</span>
                            <?php echo $_v->cellulare; ?>
                    </td>
                    <td>
                        <?php echo $_v->ingresso()->format("d/m/Y"); ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $_v->id; ?>" title="Dettagli">
                                <i class="icon-eye-open"></i> Dettagli
                            </a>
                            <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>" title="Invia Mail">
                                <i class="icon-envelope"></i>
                            </a>
                            <?php if($me->admin()){ ?>
                                <a class="btn btn-small btn-primary" href="?p=admin.beuser&id=<?= $_v->id; ?>" title="Log in">
                                    <i class="icon-key"></i>
                                </a>
                            <?php } ?>
                        </div>
                   </td>
                </tr>
        <?php 
            }
        }
        ?>

        </table>
       
    </div>
    
</div>
