<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);
menuElenchiVolontari(
    "Volontari in estensione",
    "?p=admin.utenti.excel&inestensione",
    "#"
);

?>

<div class="row-fluid">
   <div class="span12">
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Esteso in</th>
                <th>Dal</th>
                <th>Al</th>
                <th>Azioni</th>
            </thead>
        <?php
        foreach($me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE, APP_OBIETTIVO ]) as $comitato) { 
            $estesi = $comitato->membriInEstensione();
            ?>
            <tr class="success">
                <td colspan="7" class="grassetto">
                    <?php echo $comitato->nomeCompleto(); ?>
                    <span class="label label-warning">
                        <?php echo count($estesi); ?>
                    </span>
                    <a class="btn btn-success btn-small pull-right" href="?p=utente.mail.nuova&id=<?php echo $comitato->id; ?>&inestensione">
                           <i class="icon-envelope"></i> Invia mail
                    </a>
                    <a class="btn btn-small pull-right" 
                       href="?p=presidente.utenti.excel&comitato=<?php echo $comitato->id; ?>&estensione"
                       data-attendere="Generazione...">
                            <i class="icon-download"></i> scarica come foglio excel
                    </a>
                </td>
            </tr>
            <?php            
            foreach ( $estesi as $e ) {
                $v = $e->volontario();
            ?>
                <tr>
                    <td><?php echo $v->cognome; ?></td>
                    <td><?php echo $v->nome; ?></td>
                    <td><?php echo $e->appartenenza()->comitato()->nomeCompleto(); ?></td>
                    <td><?php echo date('d/m/Y', $e->appartenenza()->inizio); ?></td>
                    <td><?php echo date('d/m/Y', $e->appartenenza()->fine); ?></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $v->id; ?>" title="Dettagli">
                                <i class="icon-eye-open"></i> Dettagli
                            </a>
                            <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $v->id; ?>" title="Invia Mail">
                                <i class="icon-envelope"></i>
                            </a>
                        </div>
                   </td>
                </tr>
        <?php }
        }
        ?>
        </table>
    </div>
</div>
