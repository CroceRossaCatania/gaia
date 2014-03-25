<?php

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(['area'], 'obiettivo.dash&err');

paginaApp([APP_OBIETTIVO , APP_PRESIDENTE]);
$d = $me->delegazioneAttuale();

if ($d->estensione == EST_UNITA) {
    redirect('errore.permessi&cattivo');
}

if($me->admin() || $me->presidenziante()) {
    $area = $_GET['area'];
} else {
    $area = $d->dominio;
    if($area != $_GET['area']) {
        redirect('errore.permessi&cattivo');
    }
}


$livello = $d->estensione;
$l = [];
for($i = $livello; $i >= 0; $i -= 10) {
    $l[] = $i;
} 

?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">
        <div class="row-fluid">
            <div class="span12">
                <h2><i class="icon-envelope muted"></i> Invio Mail ai Delegati di Area <?= $area ?></h3>
                <div class="alert alert-block alert-info">
                    <h4><i class="icon-question-sign"></i> Pronto a mandare la mail ?</h4>
                    <p>Con questo modulo puoi inviare una email ai Delegati di Area <?= $area ?>. </p>
                    <p>Ricorda che puoi scegliere
                    fino a che livello effettuare l'invio spuntando correttamente il livello. Ad esempio se sei il delegato
                    <strong>Regionale</strong> e selezioni <strong>Fino al livello Locale</strong> manderai questa email
                    ai delegati Provinciali e Locali ma non ai referenti nominati sulle Unità.</p>
                </div>
                <form class="form-horizontal" action="?p=obiettivo.delegati.email.ok&area=<?= $area ?>" method="POST">
                    <div class="control-group">
                        <label class="control-label" for="inputOggetto">Oggetto</label>
                        <div class="controls">
                            <input type="text" class="span6" name="inputOggetto" id="inputOggetto" required>
                        </div>
                    </div>
                        <div class="control-group">
                            <label class="control-label" for="inputLivello">Livello</label>
                            <div class="controls">
                                <?php foreach($l as $_l) { ?>
                                <input type="radio" name="inputLivello" id="inputLivello<?= $_l ?>" value="<?= $_l ?>" required>
                                Fino al livello <?= $conf['est_obj'][$_l] ?> <br />
                                <?php } ?>
                            </div>
                        </div>
                    <div class="control-group">
                        <label class="control-label" for="inputTesto">Testo</label>
                        <div class="controls">
                            <textarea rows="10" class="input-xxlarge conEditor" type="text" id="inputTesto" name="inputTesto" placeholder="Inserisci il testo della tua mail qui..."></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success btn-large">
                            <i class="icon-envelope"></i> Invia mail
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
            
