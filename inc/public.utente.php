<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$f = $_GET['id']; 
$t = Volontario::by('id',$f);
$g = $v = $t;
$a = TitoloPersonale::filtra([['volontario',$f]]);
$mailphone = $me->pri_mailcom($v);
$curriculum = $me->pri_curcom($v);
$incarichi = $me->pri_incom($v);
?>
<!--Visualizzazione e modifica anagrafica utente-->
<div class="row-fluid">
    <!--Visualizzazione e modifica avatar utente-->
    <div class="span6">
        <div class="span12">
            <h2><i class="icon-edit muted"></i> Anagrafica</h2>
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
                    <input readonly type="text" name="inputNome" id="inputNome" value="<?php echo $t->nome; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputCognome">Cognome</label>
                <div class="controls">
                    <input readonly type="text" name="inputCognome" id="inputCognome" value="<?php echo $t->cognome; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputDataNascita">Data di Nascita</label>
                <div class="controls">
                    <input readonly type="text" class="input-small" name="inputDataNascita" id="inputDataNascita" value="<?php echo date('d/m/Y', $t->dataNascita); ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputComuneNascita">Comune di Nascita</label>
                <div class="controls">
                    <input readonly type="text" name="inputComuneNascita" id="inputComuneNascita" value="<?php echo $t->comuneNascita; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="ingressoCRI">Data ingresso in CRI</label>
                <div class="controls">
                    <input readonly type="text" name="ingressoCRI" id="ingressoCRI" value="<?php echo date('d/m/Y', $g->primaAppartenenza()->inizio); ?>">
                </div>
            </div>
            <?php if($mailphone){ ?>
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
            <?php } ?>
        </form>    
    </div>
    <?php if ( $v->storicoDelegazioni() && $incarichi) { ?>
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
<?php } ?>
<!--Visualizzazione e modifica titoli utente-->
<?php if($curriculum){
        $titoli = $conf['titoli']; ?>
        <div class="span6">
            <h3><i class="icon-list muted"></i> Curriculum </h3>  
            <?php $ttt = $a; ?>
            <table class="table table-striped">
                <?php foreach ( $ttt as $titolo ) { ?>
                    <?php if ($titolo->tConferma) { ?>
                        <tr>
                            <td>
                                <strong><?php echo $titolo->titolo()->nome; ?></strong><br />
                                <small><?php echo $conf['titoli'][$titolo->titolo()->tipo][0]; ?></small>
                            </td>
                        </tr>
                    <?php   }
                } ?>
            </table>
            </div>
    <?php } ?>
</div>