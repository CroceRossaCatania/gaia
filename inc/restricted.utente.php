<?php

/*
* ©2013 Croce Rossa Italiana
*/

paginaPrivata();

controllaParametri(array('id'));

$id = $_GET['id']; 
$u = Utente::by('id',$id);

$r = $me->pri_smistatore($u);
if($r == PRIVACY_PUBBLICA){
    redirect('public.utente&id='.$v);
}


$t = TitoloPersonale::filtra([['volontario',$u]]);
?>
<div class="row-fluid">
    <div class="span6">
        <div class="span12">
            <h3><i class="icon-edit muted"></i> Anagrafica</h3>
        </div>
        <div class="span12 allinea-centro">
            <img src="<?php echo $u->avatar()->img(20); ?>" class="img-polaroid" />
            <br/><br/>
        </div>
        <div class="form-horizontal">
        <hr />
            <div class="control-group">
                <label class="control-label" for="inputNome">Nome</label>
                <div class="controls">
                    <input type="text" name="inputNome" id="inputNome" readonly value="<?php echo $u->nome; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputCognome">Cognome</label>
                <div class="controls">
                    <input type="text" name="inputCognome" id="inputCognome" readonly value="<?php echo $u->cognome; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputCodiceFiscale">Codice Fiscale</label>
                <div class="controls">
                    <input type="text" name="inputCodiceFiscale" id="inputCodiceFiscale"  readonly value="<?php echo $u->codiceFiscale; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputSesso">Sesso</label>
                <div class="controls">
                    <input type="text" name="inputSesso" id="inputSesso" readonly value="<?php echo $conf['sesso'][$u->sesso]; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputDataNascita">Data di Nascita</label>
                <div class="controls">
                    <input type="text" class="input-small" name="inputDataNascita" id="inputDataNascita" readonly value="<?php echo date('d/m/Y', $u->dataNascita); ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputComuneNascita">Comune di Nascita</label>
                <div class="controls">
                    <input type="text" name="inputComuneNascita" id="inputComuneNascita" readonly value="<?php echo $u->comuneNascita; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="ingressoCRI">Data ingresso in CRI</label>
                <div class="controls">
                    <input readonly type="text" name="ingressoCRI" id="ingressoCRI" value="<?php echo date('d/m/Y', $u->primaAppartenenza()->inizio); ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputEmail">Email</label>
                <div class="controls">
                    <input value="<?php echo $u->email; ?>"  type="email" id="inputEmail" name="inputEmail" readonly/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputEmail">Email servizio</label>
                <div class="controls">
                    <input value="<?php echo $u->emailServizio; ?>"  type="email" id="inputEmailServizio" name="inputEmailServizio" readonly/>
                </div>
            </div>
            <div class="control-group input-prepend">
                <label class="control-label" for="inputCellulare">Cellulare</label>
                <div class="controls">
                    <span class="add-on">+39</span>
                    <input value="<?php echo $u->cellulare; ?>"  type="text" id="inputCellulare" name="inputCellulare" readonly />
                </div>
            </div>
            <div class="control-group input-prepend">
                <label class="control-label" for="inputCellulareServizio">Cellulare Servizio</label>
                <div class="controls">
                    <span class="add-on">+39</span>
                    <input value="<?php echo $u->cellulareServizio; ?>"  type="text" id="inputCellulareServizio" name="inputCellulareServizio" readonly />
                </div>
            </div>
        </div>    
    </div>
    <div class="span6">
        <div class="row-fluid">
            <h4>
              <i class="icon-time muted"></i>
              Appartenenze attuali
            </h4>
        </div>

        <div class="row-fluid">

            <table class="table table-bordered table-striped">
                  <thead>
                    <th>Ruolo</th>
                    <th>Comitato</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                    <th>Azioni</th>
                  </thead>
                  <?php 
                  if($u->stato == VOLONTARIO) {
                    $appartenenze = $u->appartenenzeAttuali();
                  } else {
                    $appartenenze = $u->appartenenzeAttuali(MEMBRO_ORDINARIO);
                  }
                  foreach ( $appartenenze as $app ) { ?>
                  <tr class="success">
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
                        <?php if($hoPotere) { ?>
                        <a href="?p=us.appartenenza.modifica&a=<?php echo $app; ?>" title="Modifica appartenenza" class="btn btn-small btn-info">
                          <i class="icon-edit"></i>
                        </a>
                        <?php } if($me->admin()){ ?>
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

        <?php if ( $u->storicoDelegazioni()) { ?>

        <div class="row-fluid">
            <h2>
                <i class="icon-briefcase muted"></i>
                Incarichi
                </h2>    
        </div>
        <div class="row-fluid">
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Stato</th>
                    <th>Ruolo</th>
                    <th>Comitato</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                </thead>
                <?php foreach ( $u->storicoDelegazioni() as $app ) { ?>
                <tr>
                    <?php if ($app->fine >= time() || $app->fine == 0 ) { ?> class="success"<?php } ?>>
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
        if ($titolo) {
        $titoli = $conf['titoli'];?>
        <div class="row-fluid">
            <h4><i class="icon-list muted"></i> Curriculum </h4>
            <table class="table table-striped">
                <?php foreach ( $t as $titolo ) { ?>
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
    <?php } ?> 
    </div>
</div>