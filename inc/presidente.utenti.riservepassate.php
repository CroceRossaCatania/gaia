<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE]);

menuElenchiVolontari(
    "Volontari in riserva",                // Nome elenco
    "?p=admin.utenti.excel&riserveold",   // Link scarica elenco
    false                                // Link email elenco
    );
    ?>

    
<div class="row-fluid">
    <div class="span12">
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
            foreach ( $elenco as $comitato ) {
                $r = $comitato->riserve();
                ?>
                <tr class="success">
                    <td colspan="7" class="grassetto">
                        <?php echo $comitato->nomeCompleto(); ?>
                        <a class="btn btn-small pull-right" 
                            href="?p=presidente.utenti.excel&comitato=<?php echo $comitato->id; ?>&riserveold"
                            data-attendere="Generazione...">
                            <i class="icon-download"></i> scarica come foglio excel
                        </a>
                    </td>
                </tr>
            <?php
                foreach( $r as $riserva ){
                    if(!$riserva->attuale()){
                        $_v = $riserva->volontario();
                    ?>
                        <tr>
                            <td><?php echo $_v->cognome; ?></td>
                            <td><?php echo $_v->nome; ?></td>
                            <td><?php echo date('d/m/Y', $riserva->inizio); ?></td>
                            <td><?php echo date('d/m/Y', $riserva->fine); ?></td>
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
    }
            ?>
        </table>
    </div>
</div>