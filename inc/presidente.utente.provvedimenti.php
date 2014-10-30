<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

controllaParametri(array('id'), 'presidente.riserva&err');

$v = $_GET['id'];
$v = Volontario::id($v);
proteggiDatiSensibili($v, [APP_SOCI, APP_PRESIDENTE]);
?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <h2>
                <i class="icon-legal muted"></i>
                Storico Provvedimenti
            </h2>
            <p>Volontario: <strong><?= $v->nomeCompleto(); ?></strong></p>
        </div>
        
        <div class="row-fluid">
            
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Stato</th>
                    <th>Comitato</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                    <th>Prot. Num.</th>
                    <th>Prot. Data</th>            
                    <th>Motivo</th>
                </thead>
                
                <?php foreach ( $v->storicoProvvedimenti() as $prov ) { ?>
                    <tr<?php if ($prov->fine >= time() || $prov->fine == 0) { ?> class="success"<?php } ?>>
                        <td>
                            <?php if ($prov->fine >= time() || $prov->fine == 0 ) { ?>
                                Attuale
                            <?php } else { ?>
                                Passato
                            <?php } ?>
                        </td>
                        
                        <td>
                            <?= $prov->comitato()->nomeCompleto(); ?>
                        </td>
                                
                        <td>
                            <i class="icon-calendar muted"></i>
                            <?= date('d/m/Y', $prov->inizio); ?>
                        </td>
                        
                        <td>
                            <?php if ($prov->fine) { ?>
                                <i class="icon-time muted"></i>
                                <?= date('d/m/Y',$prov->fine); ?>
                            <?php } else { ?>
                                <i class="icon-question-sign muted"></i>
                                Indeterminato
                            <?php } ?>
                        </td>

                        <td>
                            <?= $prov->protNumero; ?>
                        </td>

                        <td>
                            <i class="icon-calendar muted"></i>
                            <?= date('d/m/Y', $prov->protData); ?>
                        </td>

                        <td>
                            <?= $prov->motivo; ?>
                        </td>
                        
                    </tr>
                <?php } ?>
            
            </table>
        </div>        
    </div>
</div>
