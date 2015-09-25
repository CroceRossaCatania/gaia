<?php
/*
 * ©2013 Croce Rossa Italiana
 */

set_time_limit(0);
paginaAnonimo();
caricaSelettore();

controllaParametri(array('id'));

error_reporting(E_ALL);
ini_set('display_errors', true);

$corso = Corso::id($_GET['id']);

$puoPartecipare = false;
//if ($corso->postiLiberi() > 0 && $corso->puoPartecipare($me)) {
    $puoPartecipare = true;
//}
$anonimo = false;
if ($me instanceof Anonimo) {
    $anonimo = true;
}

print "a";
$geoComitato = GeoPolitica::daOid($corso->organizzatore);
print "b";

$modificabile = $corso->modificabileDa($me);
if ($modificabile) {
    $dominio = $me->dominioCompetenzaCorso($corso);
}

$files = array(
    array('url' => '#', 'name' => 'Documento con nome lungo'),
    array('url' => '#', 'name' => 'Documento con nome lungo 2'),
    array('url' => '#', 'name' => 'Documento con nome lungo 3'),
    array('url' => '#', 'name' => 'Documento con nome lungo 4'),
);

$docenti = [];
$partecipazioni = $corso->docenti();
foreach ($partecipazioni as $i) {
    $docenti[] = [ 'url' => '#', 'nome' => $i->volontario()->nomeCompleto()];
};



/*
  $g = Gruppo::by('attivita', $a);

  $apertura = $corso->apertura;
 */

$puoPartecipare = true;
$apertura = true;
$modificabile = false;
$geoComitato = GeoPolitica::daOid($corso->organizzatore);
?>
<div class="row-fluid">
    <div class="span3">
<?php menuVolontario(); ?>


    </div>

    <div class="span9">
        <div class="row-fluid">
<?php /*
  <?php if (isset($_GET['pot'])) { ?>
  <div class='alert alert-block alert-success'>
  <h4>Poteri conferiti con successo &mdash; <?php echo date('d-m-Y H:i:s'); ?></h4>
  </div>
  <?php } ?>
  <?php if (isset($_GET['not'])) { ?>
  <div class='alert alert-block alert-danger'>
  <h4>Poteri già conferiti</h4>
  </div>
  <?php } ?>
  <?php if (isset($_GET['gok'])) { ?>
  <div class='alert alert-block alert-success'>
  <h4>Gruppo di lavoro creato con successo &mdash; <?php echo date('d-m-Y H:i:s'); ?></h4>
  </div>
  <?php } ?>
  <?php if ($sessione->errori) {
  $errori = json_decode($sessione->errori);
  foreach ($errori as $errore) { ?>
  <div class='alert alert-block alert-danger'>
  <h4>Il turno <?= $errore; ?> e' stato creato, ma la data di fine e' antecedente a quella di inzio</h4>
  <h5>Per favore correggi le date!</h5>
  </div>
  <?php } }
  $sessione->errori = null;
  ?>
 */ ?>

            <div class="span8 btn-group">
<?php if ($apertura && $modificabile) { ?>
                    <a href="?p=attivita.modifica&id=<?php echo $corso->id; ?>" class="btn btn-large btn-info">
                        <i class="icon-edit"></i>
                        Modifica
                    </a>
                    <a href="?p=attivita.turni&id=<?= $corso->id ?>" class="btn btn-primary btn-large">
                        <i class="icon-calendar"></i> Turni
                    </a>
                    <a href="?p=attivita.cancella&id=<?= $corso->id; ?>" class="btn btn-large btn-danger" title="Cancella attività e tutti i turni">
                        <i class="icon-trash"></i>
                    </a>
    <?php if (!$g && $corso->comitato()->_estensione() < EST_NAZIONALE) { ?>
                        <a class="btn btn-large btn-success" href="?p=attivita.gruppo.nuovo&id=<?php echo $corso->id; ?>" title="Crea nuovo gruppo di lavoro">
                            <i class="icon-group"></i> Crea gruppo
                        </a>
    <?php }
}
?>
                <a class="btn btn-large btn-primary" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("https://gaia.cri.it/index.php?p=attivita.scheda&id={$corso->id}"); ?>" target="_blank">
                    <i class="icon-facebook-sign"></i> Condividi
                </a>
                <?php if (!$apertura) { ?>
                    <a class="btn btn-large btn-danger disabled" <?php if ($corso->modificabileDa($me)) { ?> onclick="return confirm('Vuoi nuovamente aprire l\'attività?');" href="?p=attivita.apertura.ok&id=<?= $corso->id; ?>&apri" <?php } ?>>
                        <i class="icon-lock"></i>
                        Attività chiusa
                    </a>
                <?php } ?>

            </div>
            <div class="span4 allinea-destra">
                <span class="muted">
                    <strong>Ultimo aggiornamento</strong>:<br />
                    <i class="icon-time"></i> <?php echo date("d/m/Y H:i:s", $corso->timestamp); ?>
                </span>
                <!-- Box Like/Dislike -->
                <div data-like="<?= $corso->oid(); ?>" class="pull-right"></div>
            </div>
        </div>
        <hr />
        <div class="row-fluid allinea-centro">
            <div class="span12">
                <h2 class="text-success"><?php echo $corso->titolo; ?></h2>
                <h4 class="text-info">
                    <i class="icon-map-marker"></i>
                    <a target="_new" href="<?php echo $corso->linkMappa(); ?>">
                        <?php echo $corso->luogo; ?><br/><?php echo $corso->inizio()->inTesto() ?>
                    </a>
                </h4>
            </div>
        </div>
        <hr />
        <?php
        $pl = true;// $corso->postiLiberi();
        if ($puoPartecipare && $pl) {
            ?>
            <div class="span12">
                <div class="alert alert-block alert-error allinea-centro">
                    <h4 class="text-error ">
                        <i class="icon-warning-sign"></i>
                        Ci sono <?php echo $corso->postiLiberi() ?> posti liberi
                    </h4>
                    <p>Iscriviti anche tu al corso!</p>
                </div>
            </div>
            <hr/>
        <?php } ?>

        <div class="row-fluid allinea-centro">
            <div class="span4">
                <span>
                    <i class="icon-home"></i>
                    Organizzato da
                </span><br />
                <span class="text-info">
                    <?php echo $geoComitato->nomeCompleto(); ?>
                </span>
            </div>
            <div class="span4">
                <span>
                    <i class="icon-user"></i>
                    Responsabile
                </span><br />
                <a href="?p=utente.mail.nuova&id=<?php echo $corso->responsabile()->id; ?>">
                    <?php echo $corso->responsabile()->nome . ' ' . $corso->responsabile()->cognome; ?>
                </a>
                <br />
                <?php if ($puoPartecipare && !$anonimo) { ?>
                    <span class="muted">+39</span> <?php echo $corso->responsabile()->cellulare(); ?>
                <?php } ?>
            </div>
            <div class="span4">
                <span>
                    <i class="icon-lock"></i>
                    Partecipazione
                </span><br />
                <span class="text-info">
                    <?php if ($puoPartecipare) { ?>
                        <a id="pulsanteIscriviti" class="btn btn-info pull-right" href="?p=formazione.corsi.iscriviti">
                            <i class="icon-pencil"></i>
                            Richiedi iscrizione
                        </a>
                    <?php } ?>
                </span>
            </div>
        </div>
        <hr />
        <?php if ($puoPartecipare) { ?>
            <div class="row-fluid">
                <div class="span8" style="max-height: 500px; padding-right: 10px; overflow-y: auto;">
                    <h4>
                        <i class="icon-info-sign"></i>
                        Ulteriori informazioni
                    </h4>
                    <?php echo nl2br($corso->descrizione); ?>
                </div>
                <div class="span4">
                    <h4>
                        <i class="icon-comments-alt"></i>
                        Docenti
                    </h4>
                    <div class="row-fluid">
                        <ul>
                            <?php
                            foreach ($docenti as $docente) {
                                ?>
                                <li><a href="<?php echo $docente['url'] ?>"><?php echo $docente['nome'] ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>

                    <h4>
                        <i class="icon-file-text"></i>
                        Risorse
                    </h4>
                    <div class="row-fluid">
                        <p>Questa area si deve vedere solo se l'utente è iscritto e ha quindi il permesso di vedere i file</p>
                        <ul>
                            <?php
                            foreach ($files as $file) {
                                ?>
                                <li><a href="<?php echo $file['url'] ?>"><?php echo $file['name'] ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>

                </div>
            </div>
            <hr />
<?php } ?>

        <div class="row-fluid">
            <div class="span12">
                <h2><i class="icon-time"></i> Note importanti</h2>
            </div>
        </div>
        <div class="row-fluid">
            <div class="alert alert-info">
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. 
            </div>
        </div>
        <hr/>
        <div class="row-fluid">
            <div class="span12">
                <h2><i class="icon-info-sign"></i> Richiedi informazioni</h2>
            </div>
        </div>
        <div class="row-fluid">
            <div class="alert alert-info">
                Richiedi informazioni compilando il modulo qui sotto
            </div>
            <form class="form-horizontal" action="?p=utente.anagrafica.ok" method="POST">
                <div class="control-group">
                    <label class="control-label" for="inputNome">Nome</label>
                    <div class="controls">
                        <input type="text" name="inputNome" id="inputNome" required="" >
                        <!--<acronym title="Per modificare, contatta supporto@gaia.cri.it">&nbsp; <i class="icon-lock icon-large"></i></acronym>-->
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputCognome">Cognome</label>
                    <div class="controls">
                        <input type="text" name="inputCognome" id="inputCognome" required="" >
                        <!--<acronym title="Per modificare, contatta supporto@gaia.cri.it">&nbsp; <i class="icon-lock icon-large"></i></acronym>-->
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputTelefono">Recapito telefonico</label>
                    <div class="controls">
                        <input type="text" id="inputTelefono" name="inputTelefono" pattern="[0-9]{5,}"><br/>
                        <span class="muted">Inserire solo cifre, senza spazi o altri caratteri</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Email</label>
                    <div class="controls">
                        <input type="text" id="inputEmail" name="inputEmail" required="" pattern="[0-9]{5}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputRichiesta">Richiesta</label>
                    <div class="controls">
                        <textarea  id="inputRichiesta" name="inputRichiesta" required="true" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success btn-large">
                        <i class="icon-info-sign"></i>
                        Invia richiesta
                    </button>
                </div>
            </form>        
        </div>

    </div>
</div>

