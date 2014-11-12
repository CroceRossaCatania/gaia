<?php

/*
 * ©2014 Croce Rossa Italiana
 */

if ( !captcha_controlla($_POST['sckey'], $_POST['scvalue']) ) {
    redirect('validaTesserino&captcha');
}

controllaParametri(['inputNum'], 'validaTesserino&err');

$num = $_POST['inputNum'];

$u = Utente::daCodicePubblico($num);


$verificato = false;
$ordinario = false;
//if($u && $u->appartenenzaAttuale()) {
if ($u) {
    $cogn = $u->cognome;
    $t = TesserinoRichiesta::by('codice', $num);
    if ( $t->valido() ){
        $verificato = true;
        $ordinario = $t->utente()->ordinario();
    }
    $l = strlen($cogn);
    $r = rand(1, $l);
    $c = strtoupper(substr($cogn, $r-1, 1));
} 


?>

<div class="row-fluid">
    <div class="span12 centrato">
            <h2><span class="muted">Croce Rossa.</span> Persone in prima persona.</h2>
        <hr />
    </div>
</div>

<div class="row-fluid">
    <div class="span6">
        <div class="row-fluid">
            <div class="span8 offset2"
                <div class="item active altoCento">
                    <?php if($verificato) { ?>
                        <img class="altoCentro" src="./img/tesserino/FronteAttivoEsempioOK.jpg" alt="tesserino verificato">
                    <?php } else { ?>
                        <img class="altoCentro" src="./img/tesserino/FronteAttivoEsempioNO.jpg" alt="tesserino non verificato">
                    <?php } ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="row-fluid">
            <?php if($verificato) { ?>
                <div class="alert alert-block alert-success">
                    <h2><i class="icon-smile"></i> Tesserino valido</h2>
                    <p>Il tesserino di cui hai richiesto la verifica risulta <strong>valido</strong>, e in particolare:</p>
                    <p>
                    <ul>
                        <!-- mettere roba per ordinario -->
                        <li>La lettera in posizione <strong><?= $r ?></strong> del cognome del volontario è <strong><?= $c ?></strong></li>
                        <li>Il tesserino appartiene ad un Volontario della Croce Rossa</li>
                        <li>Il Volontario è in regola con la quota associativa</li>
                        <li>L'immagine a fianco è di esempio e non si riferisce al tesserino che stai verificando</li>
                    </ul>
                    </p>
                </div>
            <?php } else { ?>
                <div class="alert alert-block alert-danger">
                    <h2><i class="icon-frown"></i> Tesserino non valido</h2>
                    <p>Il tesserino di cui hai richiesto la verifica risulta <strong>non valido</strong>. Quale può essere la causa:</p>
                    <p>
                    <ul>
                        <li>Hai inserito in modo errato il numero di tessera</li>
                        <li>Il tesserino appartiene ad una persona non più in Croce Rossa</li>
                        <li>Il tesserino è scaduto (la data di scadenza è riportata sul retro)</li>
                    </ul>
                    </p>
                    <p>L'immagine a fianco è di esempio e non si riferisce al tesserino che stai verificando.</p>
                </div>
            <?php } ?>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <a href="?p=public.tesserino" class="btn btn-block">
                    <i class="icon-reply"></i>
                    Verifica un altro tesserino
                </a>
            </div>
        </div>
    </div>  
</div>

