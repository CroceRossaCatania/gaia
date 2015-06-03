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

$a = Corso::id($_GET['id']);

$puoPartecipare = false;
if ($a->postiLiberi()>0 && $a->puoPartecipare($me)) {
    $puoPartecipare = true;
}
$anonimo = false;
if ($me instanceof Anonimo) {
   $anonimo = true; 
}

$geoComitato = GeoPolitica::daOid($a->organizzatore);

$modificabile = $a->modificabileDa($me);
if ( $modificabile ) {
    $dominio = $me->dominioCompetenzaAttivita($a);
}



/*
$g = Gruppo::by('attivita', $a);

$apertura = $a->apertura;
*/

$puoPartecipare = true;
$apertura = true;
$modificabile = false;
$geoComitato = GeoPolitica::daOid($a->organizzatore);

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
                <?php if ( $apertura && $modificabile ) { ?>
                    <a href="?p=attivita.modifica&id=<?php echo $a->id; ?>" class="btn btn-large btn-info">
                        <i class="icon-edit"></i>
                        Modifica
                    </a>
                    <a href="?p=attivita.turni&id=<?= $a ?>" class="btn btn-primary btn-large">
                        <i class="icon-calendar"></i> Turni
                    </a>
                    <a href="?p=attivita.cancella&id=<?= $a->id; ?>" class="btn btn-large btn-danger" title="Cancella attività e tutti i turni">
                        <i class="icon-trash"></i>
                    </a>
                    <?php if (!$g && $a->comitato()->_estensione() < EST_NAZIONALE){ ?>
                        <a class="btn btn-large btn-success" href="?p=attivita.gruppo.nuovo&id=<?php echo $a->id; ?>" title="Crea nuovo gruppo di lavoro">
                            <i class="icon-group"></i> Crea gruppo
                        </a>
                    <?php }
                } ?>
                <a class="btn btn-large btn-primary" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("https://gaia.cri.it/index.php?p=attivita.scheda&id={$a->id}"); ?>" target="_blank">
                    <i class="icon-facebook-sign"></i> Condividi
                </a>
                <?php if ( !$apertura ){ ?>
                    <a class="btn btn-large btn-danger disabled" <?php if ($a->modificabileDa($me)){ ?> onclick="return confirm('Vuoi nuovamente aprire l\'attività?');" href="?p=attivita.apertura.ok&id=<?=$a->id; ?>&apri" <?php } ?>>
                            <i class="icon-lock"></i>
                            Attività chiusa
                    </a>
                <?php } ?>

            </div>
            <div class="span4 allinea-destra">
                <span class="muted">
                    <strong>Ultimo aggiornamento</strong>:<br />
                    <i class="icon-time"></i> <?php echo date("d/m/Y H:i:s", $a->timestamp); ?>
                </span>
                <!-- Box Like/Dislike -->
                <div data-like="<?= $a->oid(); ?>" class="pull-right"></div>
            </div>
        </div>
        <hr />
        <div class="row-fluid allinea-centro">
            <div class="span12">
                <h2 class="text-success"><?php echo $a->titolo; ?></h2>
                <h4 class="text-info">
                    <i class="icon-map-marker"></i>
                    <a target="_new" href="<?php echo $a->linkMappa(); ?>">
                        <?php echo $a->luogo; ?>
                    </a>
                </h4>
            </div>
        </div>
        <hr />
        <?php
        $pl = $a->postiLiberi();
        if ($puoPartecipare && $pl ) { ?>
        <div class="span12">
            <div class="alert alert-block alert-error allinea-centro">
                <h4 class="text-error ">
                    <i class="icon-warning-sign"></i>
                    Ci sono <?php echo number_format($pl, 0, ',', '.'); ?> posti liberi
                </h4>
                <p>Iscriviti anche tu al corso!</p>
            </div>
        </div>
        <hr/>
        <?php } ?>

        <div class="row-fluid allinea-centro">
            <div class="span3">
                <span>
                    <i class="icon-user"></i>
                    Referente
                </span><br />
                <a href="?p=utente.mail.nuova&id=<?php echo $a->referente()->id;?>">
                    <?php echo $a->referente()->nome . ' ' . $a->referente()->cognome; ?>
                </a>
                <br />
                <?php if ($puoPartecipare && !$anonimo) { ?>
                <span class="muted">+39</span> <?php echo $a->referente()->cellulare(); ?>
                <?php } ?>
            </div>
            <div class="span3">
                <span>
                    <i class="icon-globe"></i>
                    Area d'intervento
                </span><br />
                <span class="text-info">
                    <?php echo $a->area()->nomeCompleto(); ?>
                </span>
            </div>
            <div class="span3">
                <span>
                    <i class="icon-home"></i>
                    Organizzato da
                </span><br />
                <span class="text-info">
                <?php echo $geoComitato->nomeCompleto(); ?>
                </span>
            </div>
            <div class="span3">
                <span>
                    <i class="icon-lock"></i>
                    Partecipazione
                </span><br />
                <span class="text-info">
                    <strong>XXX XXX XXX</strong>
                </span>
            </div>
        </div>
        <hr />
        <?php if($puoPartecipare) { ?>
        <div class="row-fluid">
            <div class="span5" style="max-height: 500px; padding-right: 10px; overflow-y: auto;">
                <h4>
                    <i class="icon-info-sign"></i>
                    Ulteriori informazioni
                </h4>
                <?php echo nl2br($a->descrizione); ?>
            </div>
            <div class="span7">
                <button id="pulsanteIscriviti" class="btn btn-info pull-right">
                    <i class="icon-pencil"></i>
                    Iscriviti
                </button>
                <h4>
                    <i class="icon-comments-alt"></i>
                    Docenti
                </h4>
                <div class="row-fluid">
                    <ul>
                        <li>docente 1</li>
                        <li>docente 2</li>
                        <li>docente 3</li>
                    </ul>
                </div>

                <div class="row-fluid" style="max-height: 450px; padding-right: 10px; overflow: auto;">
                </div>

            </div>
        </div>
        <hr />
        <?php } ?>
                
        <div class="row-fluid">
            <div class="span8">
                <h2><i class="icon-time"></i> Note importanti</h2>
            </div>
            <div class="span4">
            </div>

        </div>
        <?php if($puoPartecipare) { ?>
        <div class="row-fluid">
            <div class="alert alert-info">
                <i class="icon-info-sign"></i> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. 
            </div>
        </div>
        <?php } ?>
                
    </div>
</div>
    
