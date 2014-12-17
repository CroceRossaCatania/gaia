<?php

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(['comitato'], 'us.dash&err');

paginaApp([APP_PRESIDENTE, APP_SOCI]);
$d = $me->delegazioneAttuale();

$admin = (bool) $me->admin();

if (!$admin && $d->estensione == EST_UNITA) {
    redirect('errore.permessi&cattivo');
}

$comitato = $_GET['comitato'];

if ($admin) {
    $comitato = Nazionale::elenco()[0];
} else {
    $comitato = GeoPolitica::daOid($comitato);
}
$ramo = new RamoGeoPolitico($comitato, ESPLORA_RAMI, EST_LOCALE);

?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">
        <div class="row-fluid">
            <div class="span12">
                <h3><i class="icon-book"></i> Elenco Presidenti </h3>
                <br />
                <div class="row-fluid">
                    <div class="span6">
                        <a href="?p=presidente.presidenti.email&comitato=<?= $comitato->oid() ?>" class="btn btn-success btn-block">
                            <i class="icon-envelope"></i>
                            Invia email ai presidenti
                        </a>
                    </div>
                    <div class="span6">
                        <a href="?p=us.utenti.excel&id=<?= $comitato->oid() ?>" class="btn btn-info btn-block">
                            <i class="icon-download-alt"></i>
                            Scarica elenco come excel
                        </a>
                    </div>
                </div>
                <hr />
                <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
                    <thead>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Azioni</th>
                    </thead>
                    <?php
                    foreach($ramo as $com) { 
                        if($com->superiore() && $com->superiore()->nomeCompleto() == $com->nomeCompleto()) {
                            continue;
                        } ?>
                        <tr class="success">
                            <td colspan="4" class="grassetto">
                                <?php echo $com->nomeCompleto(); ?>
                            </td>
                        </tr>
                        <?php 
                        $v = $com->unPresidente();
                        if($v) { ?>
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
                        } else { ?>
                            <tr>
                                <td colspan="4">Nessun presidente nominato</td>
                            </tr>
                        <?php }
                    } ?>
                </table>
            </div>
        </div>
    </div>
</div>
            
