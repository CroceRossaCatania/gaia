<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE ]);
menuElenchiVolontari(
    "Soci Ordinari",
    "?p=admin.utenti.excel&ordinari",
    "?p=utente.mail.nuova&ordinaricom"
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
<?php }elseif ( isset($_GET['dim']) )  { ?>
        <div class="alert alert-block alert-success">
            <h4><i class="icon-exclamation-sign"></i> Socio Ordinario dimesso</h4>
            <p>Il Socio Ordinario è stato dimesso con successo.</p>
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
                <th>Data Ingresso</th>
                <th>Azioni</th>
            </thead>
        <?php
        $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        $admin = $me->admin();
        foreach($elenco as $comitato) {
            $t = $comitato->membriOrdinari();
            ?>
            
            <tr class="success">
                <td colspan="8" class="grassetto">
                    <?php echo $comitato->nomeCompleto(); ?>
                    <span class="label label-warning">
                        <?php echo $comitato->numMembriOrdinari(); ?>
                    </span>
                    <a class="btn btn-success btn-small pull-right" href="?p=utente.mail.nuova&ordinariunit&id=<?php echo $comitato->id; ?>">
                           <i class="icon-envelope"></i> Invia mail
                    </a>
                    <a class="btn btn-small pull-right" 
                       href="?p=presidente.utenti.excel&ordinari&comitato=<?php echo $comitato->id; ?>"
                       data-attendere="Generazione...">
                            <i class="icon-download"></i> scarica come foglio excel
                    </a>
                </td>
            </tr>
            
            <?php
            foreach ( $t as $_v ) {
                $id = $_v->id;
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
                            <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $id; ?>" title="Dettagli">
                                <i class="icon-eye-open"></i> Dettagli
                            </a>                            
                            <a class="btn btn-small btn-danger" href="?p=presidente.utente.dimetti&ordinario&id=<?php echo $id; ?>" title="Dimetti Volontario">
                                <i class="icon-ban-circle"></i> Dimetti
                            </a>
                            <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $id; ?>" title="Invia Mail">
                                <i class="icon-envelope"></i>
                            </a>
                            <?php if ($admin) { ?>
                            <a  onClick="return confirm('Vuoi veramente cancellare questo utente ?');" href="?p=admin.utente.cancella&id=<?php echo $id; ?>" title="Cancella Utente" class="btn btn-small btn-warning">
                                <i class="icon-trash"></i> Cancella
                            </a>
                            <a class="btn btn-small btn-primary" href="?p=admin.beuser&id=<?php echo $id; ?>" title="Log in">
                                <i class="icon-key"></i>
                            </a> 
                            <a class="btn btn-small btn-primary" href="?p=admin.password.nuova&id=<?php echo $id; ?>" title="Cambia password">
                                <i class="icon-eraser"></i>
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
