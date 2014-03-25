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

$comitato = $d->comitato();
$ramo = new RamoGeoPolitico($comitato);

?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">
        <div class="row-fluid">
            <div class="span12">
                <h3><i class="icon-book"></i> Elenco Delegati di Area <?= $area ?> </h3>
                <br />
                <a href="?p=obiettivo.delegati.email&area=<?= $area?>" class="btn btn-block btn-success">
                    <i class="icon-envelope"></i>
                    Invia email ai delegati
                </a>
                <hr />
                <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
                    <thead>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Azioni</th>
                    </thead>
                    <?php
                    foreach($ramo as $com) { ?>
                        <tr class="success">
                            <td colspan="4" class="grassetto">
                                <?php echo $com->nomeCompleto(); ?>
                            </td>
                        </tr>
                        <?php 
                        $delegati = Delegato::filtra([
                            ['comitato', $com->oid()],
                            ['dominio', $area],
                            ['applicazione', APP_OBIETTIVO]
                            ]);
                        foreach($delegati as $_d) {
                            if($_d->attuale()) {
                                $v = $_d->volontario(); ?>
                                <tr>
                                    <td><img width="50" height="50" src="<?php echo $v->avatar()->img(10); ?>" class="img-polaroid" /></td>
                                    <td><?= $v->nome; ?></td>
                                    <td><?= $v->cognome; ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-small" href="?p=profilo.controllo&id=<?= $v->id; ?>" title="Dettagli">
                                            <i class="icon-eye-open"></i> Dettagli
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
            
