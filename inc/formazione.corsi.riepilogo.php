<?php
/*
 * ©2015 Croce Rossa Italiana
 */

paginaPresidenziale();
controllaParametri(['id'], 'admin.corsi.crea&err');

$c = $err = null;
$id = intval($_GET['id']);
try {
    $c = Corso::id($id);
    if (empty($c)) {
        throw new Exception('Manomissione');
    }
    $certificato = Certificato::by('id', intval($c->certificato));

} catch(Exception $e) {
    redirect('admin.corsi.crea&err');
}

if (!empty($_GET['err']) && is_int($_GET['err'])) {
    if (!empty($conf['errori_corsi'][$_GET['err']])) {
        $err = $conf['errori_corsi'][$_GET['err']];
    } else {
        $err = 'errore sconosciuto';
    }
}


$geoComitato = GeoPolitica::daOid($c->organizzatore);

$modificabile = $c->modificabileDa($me);
if ($modificabile) {
    $dominio = $me->dominioCompetenzaCorso($a);
}

$files = array(
    array('url' => '#', 'name' => 'Documento con nome lungo'),
    array('url' => '#', 'name' => 'Documento con nome lungo 2'),
    array('url' => '#', 'name' => 'Documento con nome lungo 3'),
    array('url' => '#', 'name' => 'Documento con nome lungo 4'),
);

$docenti = $discenti = [];

$partecipazioni = $c->insegnanti();
foreach ($partecipazioni as $i) {
    $docenti[] = [ 'url' => '#', 'nome' => $i->volontario()->nomeCompleto(), 'confermato'=> true];
};
$partecipazioni = $c->insegnantiPotenziali();
foreach ($partecipazioni as $i) {
    $docenti[] = [ 'url' => '#', 'nome' => $i->volontario()->nomeCompleto(), 'confermato'=> false];
};

$partecipazioni = $c->discenti();
foreach ($partecipazioni as $i) {
    $discenti[] = [ 'url' => '#', 'nome' => $i->volontario()->nomeCompleto(), 'confermato'=> true];
};
$partecipazioni = $c->discentiPotenziali();
foreach ($partecipazioni as $i) {
    $discenti[] = [ 'url' => '#', 'nome' => $i->volontario()->nomeCompleto(), 'confermato'=> false];
};
unset($partecipazioni);

$checkDocenti = $c->numeroInsegnantiMancanti();
$checkDiscenti = $c->postiLiberi();




/*
  $g = Gruppo::by('attivita', $a);

  $apertura = $c->apertura;
 */

$geoComitato = GeoPolitica::daOid($c->organizzatore);
?>
<div class="row-fluid">
    <div class="span3">
<?php menuVolontario(); ?>


    </div>

    <div class="span9">
        <div class="row-fluid">

            <div class="span8 btn-group">
                <a href="?p=formazione.corsi.crea&id=<?php echo $c->id; ?>" class="btn btn-small btn-info">
                    <i class="icon-edit"></i>
                    Modifica dati
                </a>
                <a href="?p=formazione.corsi.direttore&id=<?php echo $c->id; ?>" class="btn btn-small btn-info">
                    <i class="icon-edit"></i>
                    Modifica direttore
                </a>
                <a href="?p=formazione.corsi.insegnanti&id=<?php echo $c->id; ?>" class="btn btn-small btn-info">
                    <i class="icon-edit"></i>
                    Modifica docenti
                </a>
                <a href="?p=formazione.corsi.discenti&id=<?php echo $c->id; ?>" class="btn btn-small btn-info">
                    <i class="icon-edit"></i>
                    Modifica discenti
                </a>
                <a href="?p=formazione.corsi.risultati&id=<?php echo $c->id; ?>" class="btn btn-small btn-info">
                    <i class="icon-edit"></i>
                    Inserisci risultati
                </a>
                <a class="btn btn-small btn-primary" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("https://gaia.cri.it/index.php?p=attivita.scheda&id={$c->id}"); ?>" target="_blank">
                    <i class="icon-facebook-sign"></i> Condividi
                </a>

            </div>
            <div class="span4 allinea-destra">
                <span class="muted">
                    <strong>Ultimo aggiornamento</strong>:<br />
                    <i class="icon-time"></i> <?php echo date("d/m/Y H:i:s", $c->timestamp); ?>
                </span>
                <!-- Box Like/Dislike -->
                <div data-like="<?= $c->oid(); ?>" class="pull-right"></div>
            </div>
        </div>
        <hr />
        <div class="row-fluid allinea-centro">
            <div class="span12">
                <h2 class="text-success"><?php echo $c->titolo; ?></h2>
                <h4 class="text-info">
                    <i class="icon-map-marker"></i>
                    <a target="_new" href="<?php echo $c->linkMappa(); ?>">
                        <?php echo $c->luogo; ?><br/><?php echo $c->inizio()->inTesto() ?>
                    </a>
                </h4>
            </div>
        </div>
        <hr />
        <div class="span12">
            <div class="alert alert-block alert-error allinea-centro">
                <h4 class="text-error ">
                    <?php if (!empty($err)) { ?>
                    <div>
                        <i class="icon-warning-sign"></i>
                        <?php echo $err ?> 
                    </div>
                    <?php } ?>
                    <?php if ($checkDocenti) { ?>
                    <div>
                        <i class="icon-warning-sign"></i>
                        Mancano <?php echo $checkDocenti ?> docenti
                    </div>
                    <?php } ?>
                    <?php if ($checkDiscenti) { ?>
                    <div>
                        <i class="icon-warning-sign"></i>
                        Ci sono <?php echo $c->postiLiberi() ?> posti liberi
                    </div>
                    <?php } ?>
                    <div>
                        <i class="icon-warning-sign"></i>
                        Modificabile fino al  <?php echo $c->modificabileFinoAl()->inTesto() ?>
                    </div>
                </h4>
            </div>
        </div>
        <hr/>

        <div class="row-fluid allinea-centro">
            <div class="span6">
                <span>
                    <i class="icon-home"></i>
                    Organizzato da
                </span><br />
                <span class="text-info">
                    <?php echo $geoComitato->nomeCompleto(); ?>
                </span>
            </div>
            <div class="span6">
                <span>
                    <i class="icon-user"></i>
                    Responsabile
                </span><br />
                <a href="?p=utente.mail.nuova&id=<?php echo $c->responsabile()->id; ?>">
                    <?php echo $c->responsabile()->nome . ' ' . $c->responsabile()->cognome; ?>
                </a>
                <br />
                <?php if ($puoPartecipare && !$anonimo) { ?>
                    <span class="muted">+39</span> <?php echo $c->responsabile()->cellulare(); ?>
                <?php } ?>
            </div>
        </div>
        <hr />
        <div class="row-fluid">
            <div class="span6">
                <h4>
                    <i class="icon-graduation-cap"></i>
                    Docenti confermati
                </h4>
                <div class="row-fluid">
                    <ul>
                        <?php
                        foreach ($docenti as $docente) {
                            if (!$docente->confermato) continue;
                            ?>
                            <li><a href="<?php echo $docente['url'] ?>"><?php echo $docente['nome'] ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>

                <h4>
                    <i class="icon-graduation-cap"></i>
                    Docenti non confermati
                </h4>
                <div class="row-fluid">
                    <ul>
                        <?php
                        foreach ($docenti as $docente) {
                            if ($docente->confermato) continue;
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
            <div class="span6">
                <h4>
                    <i class="icon-book"></i>
                    Discenti confermati
                </h4>
                <div class="row-fluid">
                    <ul>
                        <?php
                        foreach ($discenti as $discente) {
                            if (!$docente->confermato) continue;
                            ?>
                            <li><a href="<?php echo $discente['url'] ?>"><?php echo $discente['nome'] ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>

                <h4>
                    <i class="icon-book"></i>
                    Discenti <strong>non</strong> confermati
                </h4>
                <div class="row-fluid">
                    <ul>
                        <?php
                        foreach ($discenti as $discente) {
                            if ($docente->confermato) continue;
                            ?>
                            <li><a href="<?php echo $discente['url'] ?>"><?php echo $discente['nome'] ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>

            </div>
        </div>
        <hr />
        <div class="row-fluid">
            <div class="span12" style="max-height: 500px; padding-right: 10px; overflow-y: auto;">
                <h4>
                    <i class="icon-info-sign"></i>
                    Ulteriori informazioni
                </h4>
                <?php echo nl2br($c->descrizione); ?>
            </div>
        </div>

    </div>
</div>

