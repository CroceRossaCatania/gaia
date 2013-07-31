<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);
$f = $_GET['id'];
$t = Volontario::by('id', $f);
?>
<STYLE TYPE="text/css">
#fronte{
    width:330px;
    height:200px;
    background-image: url('http://beta.cricatania.it/federico.durso/img/tesserino_fronte.jpg');
    position:relative;
}

#retro{
    width:330px;
    height:200px;
    background-image: url('http://beta.cricatania.it/federico.durso/img/tesserino_retro.png');
    position:relative;
}

#foto{
    width:100px;
    height:200px;
    position:absolute;
    margin-left: 15px;
    margin-top: 80px;
}

#testo{
    width:150px;
    height:170px;
    position:absolute;
    margin-left: 110px;
    margin-top: 110px;
}

#testo2{
    width:150px;
    height:170px;
    position:absolute;
    margin-left: 240px;
    margin-top: 180px;
}

#testo3{
    width:150px;
    height:170px;
    position:absolute;
    margin-left: 10px;
    margin-top: 180px;
}
</STYLE>

<div class="row-fluid">
    <div id="fronte">
        <div id="foto">
            <img src="<?php echo $t->avatar()->img(20); ?>" width="70" height="200" />
        </div>
        <div id="testo">
            <p><?= $t->nome; ?></p>
            <p><?= $t->cognome; ?></p>
            <p><?= $t->comuneNascita; ?> - <?= date( 'd/m/Y' , $t->dataNascita); ?></p>
    </div>
</div>
<div class="row-fluid">
    <div id="retro">
        <div id="testo2">
            <p><?= date( 'd/m/Y' , time()); ?></p>
        </div>
        <div id="testo3">
            <small><p class="text-error"><?= $t->unComitato()->locale()->nome; ?></p></small>
        </div>
</div>