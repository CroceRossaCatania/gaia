<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

controllaParametri(array('id'));

$dimissione = Dimissione::id($_GET['id']);
$v = Volontario::id($dimissione->volontario());
proteggiDatiSensibili($v, [APP_SOCI, APP_PRESIDENTE]);
?>
<div class="row-fluid">
    <div class="span12">
        <div class="span9">
            <div class="row-fluid">
                <h2>
                    <i class="icon-time muted"></i>
                    Dettagli dimissione
                </h2>
                <p>Volontario: <strong><?= $v->nomeCompleto(); ?></strong></p>
            </div>
        </div>
        <div class="span3 allinea-destra">
            <div class="row-fluid">
                <a href="?p=presidente.appartenenze.storico&id=<?php echo $v->id; ?>" class="btn btn-block">
                    <i class="icon-reply"></i>
                        Torna indietro
                </a>
            </div>
        </div>

        <div class="row-fluid">
            
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Comitato</th>
                    <th>Data fine</th>
                    <th>Motivo</th>
                    <th>Info</th>
                    <th>Effettuata</th>
                    <th>Registrata il</th>
                </thead>
                <tr>
                    
                    <td>
                        <strong><?php echo $dimissione->appartenenza()->comitato()->nomeCompleto(); ?></strong>
                    </td>
                    
                    <td>
                        <?php echo date('d/m/Y', $dimissione->appartenenza()->fine); ?>
                    </td>
                    
                    <td>
                        <?php echo $conf['dimissioni'][$dimissione->motivo]; ?>
                    </td>
                    
                    <td>
                        <?php echo $dimissione->info; ?>
                    </td>

                    <td>
                        <?php echo $dimissione->dimettente()->nomeCompleto(); ?>
                    </td>

                    <td>
                        <?php echo date('d/m/Y', $dimissione->tConferma); ?>
                    </td>
                </tr>
            </table>
        </div>        
    </div>
</div>

