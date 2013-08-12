<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

menuElenchiVolontari(
    "Volontari attivi",         // Nome elenco
    "?p=admin.utenti.excel",    // Link scarica elenco
    "?p=utente.mail.nuova&com"  // Link email elenco
);

?>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Volontario eliminato</strong>.
            Il Volontario è stato eliminato con successo.
        </div>
<?php } elseif ( isset($_GET['e']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Impossibile eliminare l'utente</h4>
            <p>Contatta l'amministratore</p>
        </div>
<?php }elseif ( isset($_GET['dim']) )  { ?>
        <div class="alert alert-block alert-success">
            <h4><i class="icon-exclamation-sign"></i> Volontario dimesso</h4>
            <p>Il Volontario è stato dimesso con successo.</p>
        </div>
<?php } ?>

    
<div class="row-fluid">
   <div class="span12">

       <?php        

        $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        $troppi = false;
        if ( count($elenco) > 10 && !isset($_GET['coraggio']) ) {
            $troppi = true;
        }

       if (!isset($_POST['inputQuery'])) {
            ?>  
                <div class="alert alert-info">
                    <h4>
                        <i class="icon-info-sign"></i>
                        Usa la barra di ricerca per trovare i volontari
                    </h4>
                    <p>Usa la barra di ricerca in alto a destra per cercare i volontari.
                    Puoi cercare per: Nome, cognome, codice fiscale o email.</p>
                </div>


            <?php
        }

        if ( $troppi ) {
            ?>
            <div class="alert alert-danger">
                    <h4>
                        <i class="icon-warning-sign"></i>
                        Ci sono molti volontari in questo elenco
                    </h4>
                    <p>La lista non è stata caricata in automatico perché potrebbe essere
                    molto pesante. Cerca i volontari per nome, cognome, ecc.</p>
                    <a href="?p=presidente.utenti&coraggio" class="btn btn-danger" data-attendere="Avvio caricamento lista...">
                        <i class="icon-cogs"></i> Carica comunque l'elenco completo (può richiedere del tempo)
                    </a>
            </div>
            <?php
        }
        ?>

           <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
                <thead>
                    <th>Cognome</th>
                    <th>Nome</th>
                    <th>Località</th>
                    <th>Cellulare</th>
                    <th>Azioni</th>
                </thead>
        <?php
        


        $risultati = 0;
        foreach($elenco as $comitato) {
            $t = [];
            if ( isset($_POST['inputQuery']) ) { 
                $t = $comitato->cercaVolontari($_POST['inputQuery']);
            } elseif ( !$troppi ) {
                $t = $comitato->tuttiVolontari();
            }
            $risultati += count($t);
                ?>
            
            
            <tr class="success">
                <td colspan="7" class="grassetto">
                    <?php echo $comitato->nomeCompleto(); ?>
                    <span class="label label-warning">
                        <?php echo count($t); ?>
                    </span>

                    <div class="pull-right btn-group">
                        <a class="btn btn-success btn-small" href="?p=utente.mail.nuova&id=<?php echo $comitato->id; ?>&unit">
                               <i class="icon-envelope"></i> Invia messaggio a tutti i volontari
                        </a>
                        <a class="btn btn-small" 
                           href="?p=presidente.utenti.excel&comitato=<?php echo $comitato->id; ?>"
                           data-attendere="Generazione...">
                                <i class="icon-download"></i> Scarica volontari come foglio excel
                        </a>
                    </div>
                </td>
            </tr>
            
            <?php
            if ( $troppi ) { continue; } 
            foreach ( $t as $_v ) {
            ?>
                <tr>
                    <td><?php echo $_v->cognome; ?></td>
                    <td><?php echo $_v->nome; ?></td>
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
                        <div class="btn-group">
                            <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $_v->id; ?>" title="Dettagli">
                                <i class="icon-eye-open"></i> Dettagli
                            </a>
                            <a class="btn btn-small btn-info" href="?p=us.tesserini.p&id=<?php echo $_v->id; ?>" title="Stampa tesserino">
                                    <i class="icon-barcode"></i> Tesserino
                            </a>
                            <a class="btn btn-small btn-danger" href="?p=presidente.utente.dimetti&id=<?php echo $_v->id; ?>" title="Dimetti Volontario">
                                    <i class="icon-ban-circle"></i> Dimetti
                            </a>
                            <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>" title="Invia Mail">
                                <i class="icon-envelope"></i>
                            </a>
                            <?php if ($me->admin) { ?>
                                <a  onClick="return confirm('Vuoi veramente cancellare questo utente ?');" href="?p=presidente.utente.cancella&id=<?php echo $_v->id; ?>" title="Cancella Utente" class="btn btn-small btn-warning">
                                    <i class="icon-trash"></i> Cancella
                                </a>
                                <a class="btn btn-small btn-primary" href="?p=admin.beuser&id=<?php echo $_v->id; ?>" title="Log in">
                                    <i class="icon-key"></i>
                                </a> 
                                <a class="btn btn-small btn-primary" href="?p=admin.password.nuova&id=<?php echo $_v->id; ?>" title="Cambia password">
                                    <i class="icon-eraser"></i>
                                </a>
                                <a class="btn btn-small btn-primary" href="?p=admin.presidente.nuovo&id=<?php echo $_v->id; ?>" title="Nomina Presidente">
                                    <i class="icon-star"></i>
                                </a> 
                                <a class="btn btn-small btn-danger <?php if ($_v->admin) { ?>disabled<?php } ?>" href="?p=admin.admin.nuovo&id=<?php echo $_v->id; ?>" title="Nomina Admin">
                                    <i class="icon-magic"></i>
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

        <?php if ( isset($_POST['inputQuery']) ) { ?>
            <h4 class="allinea-centro"><?php echo $risultati; ?> risultati trovati</h4>
        <?php } ?>

    </div>
    
</div>
