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

try {
    $corso = Corso::id(intval($_GET['id']));
    
} catch (Exception $e) {
    die($e->getMessage());
    redirect('admin.corsi.crea&err'.CORSO_ERRORE_CORSO_NON_TROVATO);
}


$puoPartecipare = false;
//if ($corso->postiLiberi() > 0 && $corso->puoPartecipare($me)) {
    $puoPartecipare = true;
//}
$anonimo = false;
if ($me instanceof Anonimo) {
    $anonimo = true;
}

$geoComitato = GeoPolitica::daOid($corso->organizzatore);

$modificabile = $corso->modificabileDa($me);
/*
if ($modificabile) {
    $dominio = $me->dominioCompetenzaCorso($corso);
}
*/

$files = array(
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
            <div class="span8 btn-group">
                <?php
                if (intval($me->id) == $corso->direttore && $c->stato == CORSO_S_CONCLUSO) {
                    ?>
                    <a href="?p=formazione.corsi.risultati&id=<?php echo $corso->id; ?>" class="btn btn-small btn-info">
                        <i class="icon-edit"></i>
                        Inserisci risultati corso
                    </a>
                    <?php
                }
                ?>
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
                
                <?php $lezioni = $corso->giornateCorso(); ?>
                <?php if (sizeof($lezioni) > 0) : ?>
                <div class="span8" style="max-height: 500px; padding-right: 10px; overflow-y: auto;">
                    <a href="admin.format.php"></a>
                    <h4>
                        <i class="icon-calendar"></i>
                        Calendario del corso
                    </h4>
                    <ul>
                        <?php foreach($lezioni as $l) : ?>
                        <li><?php print $l->luogo ?>, <?php print $l->data()->inTesto() ?><br/><?php print $l->nome ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <?php endif?>
                
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
                            if (!empty($files)) {
                                foreach ($files as $file) {
                                    ?>
                                    <li><a href="<?php echo $file['url'] ?>"><?php echo $file['name'] ?></a></li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li>Nessun documento disponibile</li>
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

