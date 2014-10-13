<?php

/*
 * ©2013 Croce Rossa Italiana
 */

caricaSelettoreComitato();

controllaParametri(array('a'));

$a = $_GET['a'];
$sessione->a = NULL;
paginaApp([APP_SOCI , APP_PRESIDENTE]);
$app = Appartenenza::id($a);
$v = $app->volontario;
?>
<form action="?p=us.appartenenza.modifica.ok&a=<?php echo $a; ?>" method="POST">
    <div class="modal fade automodal">
        <div class="modal-header">
          <h3>Modifica Appartenenza</h3>
      </div>
      <div class="modal-body">
          <div class="row-fluid">
            <div class="span4 centrato">
                <?php switch($app->stato) {
                    case MEMBRO_VOLONTARIO: ?>
                    <label for="dataInizio"><i class="icon-calendar"></i> Ingresso in CRI</label>
                    <?php break;
                    case MEMBRO_ESTESO: ?>
                    <label for="dataInizio"><i class="icon-calendar"></i> Inizio estensione</label>
                    <?php break;
                    default: ?>
                    <label for="dataInizio"><i class="icon-calendar"></i> Inizio</label>
                    <?php break; ?>
                    <?php } ?>
                </div>
                <div class="span8">
                    <input id="dataInizio" class="span12" name="dataInizio" type="text"  value="<?php echo date('d/m/Y', $app->inizio); ?>" required />
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label for="dataFine"><i class="icon-time"></i> Scadenza</label>
                </div>
                <div class="span8">
                    <input id="dataFine" class="span12" name="dataFine" type="text"  value="<?php if ($app->fine == 0) echo('Indeterminato'); else echo(date('d/m/Y', $app->fine)); ?>" readonly />
                </div>
            </div>
            <?php if($me->admin()){ ?>
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label for="inputStato"><i class="icon-fire-extinguisher"></i> Stato</label>
                </div>
                <div class="control-group span8">
                    <div class="controls">
                        <select name="stato" class="span12">
                            <?php
                            foreach ($conf['membro'] as $const => $fName) {?>
                                <option value='<?= $const; ?>' <?php if($app->stato == $const){echo ("selected='selected'");} ?> > <?= $fName; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label for="inputComitato"><i class="icon-home"></i> Comitato</label>
                </div>
                <?php if($me->admin()){ ?>
                <div class="control-group span8">
                    <div class="controls">
                        <a class="btn btn-inverse" data-selettore-comitato="true" data-input="inputComitato">
                            <?php echo $app->comitato()->nomeCompleto(); ?> <i class="icon-pencil"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="alert alert-error">
                    <i class="icon-warning-sign"></i>
                    <strong>Attenzione</strong> &mdash; Modifica il Comitato <strong>solo se necessario</strong>. Non verranno modificato tutti i dati annessi (Gruppi, Incarichi,...)
                </div>
            </div>
                <?php }else{ ?>
                <div class="span8">
                    <input id="comitato" class="span12" name="comitato" type="text"  value="<?php echo $app->comitato()->nomeCompleto(); ?>" readonly />
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="modal-footer">
          <a href="?p=presidente.utente.visualizza&id=<?php echo $v; ?>" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary">
              <i class="icon-save"></i> Modifica
          </button>
      </div>
  </div>
</form>
