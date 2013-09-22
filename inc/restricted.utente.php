<?php

/*
* ©2013 Croce Rossa Italiana
*/

paginaPrivata();

$f = $_GET['id']; 
$t = Utente::by('id',$f);
$g = $v = $t;
$a=TitoloPersonale::filtra([['volontario',$f]]);
?>
<div class="row-fluid">
    <div class="span6">
        <div class="span12">
            <h3><i class="icon-edit muted"></i> Anagrafica</h3>
        </div>
        <div class="span12 allinea-centro">
            <img src="<?php echo $g->avatar()->img(20); ?>" class="img-polaroid" />
            <br/><br/>
        </div>
        <form class="form-horizontal" action="?p=presidente.utente.modifica.ok&t=<?php echo $f; ?>" method="POST">
        <hr />
            <div class="control-group">
                <label class="control-label" for="inputNome">Nome</label>
                <div class="controls">
                    <input type="text" name="inputNome" id="inputNome" readonly value="<?php echo $v->nome; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputCognome">Cognome</label>
                <div class="controls">
                    <input type="text" name="inputCognome" id="inputCognome" readonly value="<?php echo $v->cognome; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputSesso">Sesso</label>
                <div class="controls">
                    <input type="text" name="inputSesso" id="inputSesso" readonly value="<?php echo $conf['sesso'][$v->sesso]; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputDataNascita">Data di Nascita</label>
                <div class="controls">
                    <input type="text" class="input-small" name="inputDataNascita" id="inputDataNascita" readonly value="<?php echo date('d/m/Y', $v->dataNascita); ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputComuneNascita">Comune di Nascita</label>
                <div class="controls">
                    <input type="text" name="inputComuneNascita" id="inputComuneNascita" readonly value="<?php echo $v->comuneNascita; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="ingressoCRI">Data ingresso in CRI</label>
                <div class="controls">
                    <input readonly type="text" name="ingressoCRI" id="ingressoCRI" value="<?php echo date('d/m/Y', $g->primaAppartenenza()->inizio); ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputEmail">Email</label>
                <div class="controls">
                    <input value="<?php echo $v->email; ?>"  type="email" id="inputEmail" name="inputEmail" readonly/>
                </div>
            </div>
            <div class="control-group input-prepend">
                <label class="control-label" for="inputCellulare">Cellulare</label>
                <div class="controls">
                    <span class="add-on">+39</span>
                    <input value="<?php echo $v->cellulare; ?>"  type="text" id="inputCellulare" name="inputCellulare" readonly />
                </div>
            </div>
            <div class="control-group input-prepend">
                <label class="control-label" for="inputCellulareServizio">Cellulare Servizio</label>
                <div class="controls">
                    <span class="add-on">+39</span>
                    <input value="<?php echo $v->cellulareServizio; ?>"  type="text" id="inputCellulareServizio" name="inputCellulareServizio" readonly />
                </div>
            </div>
        </form>    
    </div>
    <?php if ( $v->storicoDelegazioni()) { ?>
    <div class="span6">
        <h2>
            <i class="icon-briefcase muted"></i>
            Incarichi
            </h2>    
    </div>
    <div class="span6">
        <table class="table table-bordered table-striped">
            <thead>
                <th>Stato</th>
                <th>Ruolo</th>
                <th>Comitato</th>
                <th>Inizio</th>
                <th>Fine</th>
            </thead>
            <?php foreach ( $v->storicoDelegazioni() as $app ) { ?>
                <tr<?php if ($app->fine >= time() || $app->fine == 0 ) { ?> class="success"<?php } ?>>
                    <td>
                        <?php if ($app->fine >= time() || $app->fine == 0 ) { ?>
                            Attuale
                            <?php } else { ?>
                            Passato
                            <?php } ?>
                    </td>
                    <td>
                        <?php switch ( $app->applicazione ) { 
                            case APP_PRESIDENTE:
                            ?>
                                <strong>Presidente</strong>
                                <?php
                                break;
                            case APP_ATTIVITA:
                            ?>
                                <strong>Referente</strong>
                                <?php echo $conf['app_attivita'][$app->dominio]; ?>
                                <?php
                                break;
                            case APP_OBIETTIVO:
                            ?>
                                <strong>Delegato</strong>
                                <?php echo $conf['obiettivi'][$app->dominio]; ?>
                                <?php
                                break;
                            default:
                            ?>
                                <strong><?php echo $conf['applicazioni'][$app->applicazione]; ?></strong>
                                <?php
                                break;
                        } ?>
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
                </tr>
            <?php } ?>     
        </table>
    </div>
    <?php }
    $titoli = $conf['titoli']; 
    $ttt = $a; ?>
    <div class="span6">
        <h4><i class="icon-list muted"></i> Curriculum </h4>
        <table class="table table-striped">
            <?php foreach ( $ttt as $titolo ) { ?>
                <tr <?php if (!$titolo->tConferma) { ?>class="warning"<?php } ?>>
                    <td>
                        <?php if ($titolo->tConferma) { ?>
                            <abbr title="Confermato: <?php echo date('d-m-Y H:i', $titolo->tConferma); ?>">
                                <i class="icon-ok"></i>
                            </abbr>
                        <?php } else { ?>
                            <abbr title="Pendente">
                                <i class="icon-time"></i>
                            </abbr>
                        <?php } ?> 
                        <strong><?php echo $titolo->titolo()->nome; ?></strong><br />
                        <small><?php echo $conf['titoli'][$titolo->titolo()->tipo][0]; ?></small>
                    </td>
                    <?php if ( $titolo->inizio ) { ?>
                        <td><small>
                            <i class="icon-calendar muted"></i>
                            <?php echo date('d-m-Y', $titolo->inizio); ?>
                            <?php if ( $titolo->fine ) { ?>
                                <br />
                                <i class="icon-time muted"></i>
                                <?php echo date('d-m-Y', $titolo->fine); ?>
                            <?php } ?>
                            <?php if ( $titolo->luogo ) { ?>
                                <br />
                                <i class="icon-road muted"></i>
                                <?php echo $titolo->luogo; ?>
                            <?php } ?>
                            <?php if ( $titolo->codice ) { ?>
                                <br />
                                <i class="icon-barcode muted"></i>
                                <?php echo $titolo->codice; ?>
                            <?php } ?>
                        </small></td>
                    <?php } else { ?>
                        <td>&nbsp;</td>
                    <?php } ?>
                </tr>
                    <?php } ?>
            </table>
    </div>
</div>