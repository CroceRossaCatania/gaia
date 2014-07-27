<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

controllaParametri(array('id'));

$v = $_GET['id'];
$v = Volontario::id($v);
proteggiDatiSensibili($v, [APP_SOCI, APP_PRESIDENTE]);
?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <h2>
                <i class="icon-time muted"></i>
                Storico Appartenenze
            </h2>
            <p>Volontario: <strong><?= $v->nomeCompleto(); ?></strong></p>
        </div>
        
        <div class="row-fluid">
            
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Stato</th>
                    <th>Ruolo</th>
                    <th>Comitato</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                    <?php if($me->admin() || $v->trasferimenti() ){ ?><th>Azioni</th><?php } ?>
                </thead>
                
                <?php foreach ( $v->storico() as $app ) { ?>
                    <tr<?php if ($app->attuale()) { ?> class="success"<?php } ?>>
                        <td>
                            <?php if ($app->attuale()) { ?>
                                Attuale
                            <?php } else { ?>
                                Passato
                            <?php } ?>
                        </td>
                        
                        <td>
                            <strong><?php echo $conf['membro'][$app->stato]; ?></strong>
                        </td>
                        
                        <td>
                            <?php echo $app->comitato()->nomeCompleto(); ?>
                        </td>
                        
                        <td>
                            <i class="icon-calendar muted"></i>
                            <?php echo $app->inizio()->inTesto(false); ?>
                        </td>
                        
                        <td>
                            <?php if ($app->fine) { ?>
                                <i class="icon-time muted"></i>
                                <?php echo $app->fine()->inTesto(false); ?>
                            <?php } else { ?>
                                <i class="icon-question-sign muted"></i>
                                Indeterminato
                            <?php } ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <?php if ($app->trasferimento()) { ?>
                                    <a class="btn btn-small btn-info" href="?p=presidente.trasferimentoRichiesta.stampa&id=<?php echo $app->trasferimento(); ?>" title="Visualizza ricevuta" data-attendere="Attendere..." >
                                        <i class="icon-paperclip"></i> Richiesta trasferimento
                                    </a>
                                <?php } elseif($app->estensione()) { ?>
                                    <a class="btn btn-small btn-info" href="?p=utente.estensioneRichiesta.stampa&id=<?php echo $app->estensione(); ?>" title="Visualizza ricevuta" data-attendere="Attendere...">
                                        <i class="icon-paperclip"></i> Richiesta estensione
                                    </a>
                                <?php } elseif($app->dimissione()) { ?>
                                    <a class="btn btn-small btn-info" href="?p=presidente.utente.dimissione.dettagli&id=<?php echo $app->dimissione(); ?>" title="Visualizza dettagli dimissione">
                                        <i class="icon-paperclip"></i> Dettagli dimissione
                                    </a>
                                <?php } ?> ?>
                                <?php if ($me->admin()){ ?>
                                    <a href="?p=us.appartenenza.modifica&a=<?php echo $app; ?>" title="Modifica appartenenza" class="btn btn-small btn-info">
                                        <i class="icon-edit"></i>
                                    </a>
                                    <a onClick="return confirm('Vuoi veramente cancellare questa appartenenza ?');" href="?p=us.appartenenza.cancella&a=<?php echo $app; ?>" title="Cancella appartenenza" class="btn btn-small btn-danger">
                                        <i class="icon-trash"></i>
                                    </a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>        
    </div>
</div>

