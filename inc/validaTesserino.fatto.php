<?php

/*
 * ©2014 Croce Rossa Italiana
 */

if ( !captcha_controlla($_POST['sckey'], $_POST['scvalue']) ) {
    redirect('validaTesserino&captcha');
}

controllaParametri(['inputNum'], 'validaTesserino&err');

$num = $_GET['inputNum'];

$u = Utente::by('codice', $num);

$verificato = true;
if($u && $u->appartenenzaAttuale()) {
    $verificato = true;
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
                    <img class="altoCentro" src="./img/esempio_fronte.png" alt="esempio fronte">
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
                        <li>Il tesserino appartiene ad un Volontario della Croce Rossa</li>
                        <li>Il Volontario è in regola con la quota associativa</li>
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
                        <li>Il tesserino appartiene ad una persona che non appartiene più alla Croce Rossa</li>
                        <li>Il tesserino è scaduto (la data di scadenza è riportata sul retro)</li>
                    </ul>
                    </p>
                </div>
            <?php } ?>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <a href="?p=validaTesserino" class="btn btn-block">
                    <i class="icon-reply"></i>
                    Verifica un altro tesserino
                </a>
            </div>
        </div>
    </div>  
</div>

