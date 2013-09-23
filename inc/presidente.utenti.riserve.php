<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE]);

menuElenchiVolontari(
    "Volontari in riserva",                // Nome elenco
    "?p=admin.utenti.excel&riserva",    // Link scarica elenco
    false                               // Link email elenco
    );
    ?>

    
<div class="row-fluid">
    <div class="span12">
        <div class="btn-group btn-group-vertical span12">
            <?php if ( count($me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ])) > 1 ) { ?>
                <a href="?p=admin.utenti.excel&riserva" class="btn btn-block btn-inverse" data-attendere="Generazione e compressione in corso...">
                    <i class="icon-download"></i>
                    <strong>Ufficio Soci</strong> &mdash; Scarica tutti i fogli dei volontari in riserva in un archivio zip.
                </a>
            <?php } ?>
        </div>
        <hr />
        <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Inizio</th>
                <th>Fine</th>
                <th>Azioni</th>
            </thead>
            <?php
            $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
            foreach( $elenco as $comitato ) {
                $v = $comitato->membriRiserva();
                ?>
                <tr class="success">
                    <td colspan="7" class="grassetto">
                        <?php echo $comitato->nomeCompleto(); ?>
                        <span class="label label-warning">
                            <?php $count = count($v);
                            echo $count; ?>
                        </span>
                        <?php if ($count > 0) { ?>
                        <a class="btn btn-success btn-small pull-right" href="?p=utente.mail.nuova&id=<?php echo $comitato->id; ?>&riserva">
                            <i class="icon-envelope"></i> Invia mail
                        </a>
                        <a class="btn btn-small pull-right" 
                            href="?p=presidente.utenti.excel&comitato=<?php echo $comitato->id; ?>&riserva"
                            data-attendere="Generazione...">
                            <i class="icon-download"></i> scarica come foglio excel
                        </a>
                        <?php } ?>
                    </td>
                </tr>
            <?php
                foreach ( $v as $_v ) {
                    $ris = $_v->unaRiserva();
                    ?>
                        <tr>
                            <td><?php echo $_v->cognome; ?></td>
                            <td><?php echo $_v->nome; ?></td>
                            <td><?php echo date('d/m/Y', $ris->inizio); ?></td>
                            <td><?php echo date('d/m/Y', $ris->fine); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $_v->id; ?>" title="Dettagli">
                                        <i class="icon-eye-open"></i> Dettagli
                                    </a>
                                    <a class="btn btn-small btn-primary" target="_new" href="?p=presidente.riserva.storico&id=<?php echo $_v->id; ?>">
                                        <i class="icon-time"></i> Storico riserve
                                    </a>
                                    <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>" title="Invia Mail">
                                        <i class="icon-envelope"></i>
                                    </a>
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