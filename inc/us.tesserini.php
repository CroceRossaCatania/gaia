<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$admin = (bool) $me->admin();

if (!$admin && !($me->delegazioneAttuale()->estensione > EST_PROVINCIALE)) {
    redirect('errore.permessi&cattivo');
}

if(!$admin) {
    $comitato = $me->delegazioneAttuale()->comitato();
} ?>
<script type="text/javascript"><?php require './assets/js/presidente.utenti.js'; ?></script>
<div class="row-fluid">
    <div class="span4">
        <h2>
            <i class="icon-credit-card muted"></i>
            Tesserini
        </h2>
    </div>

    <div class="span4 allinea-centro">
        <div class="btn-group">
            <a class="btn dropdown-toggle btn-success" data-toggle="dropdown">
                <i class="icon-list"></i>
                Volontari   
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="?p=us.tesserini"><i class="icon-folder-open"></i> Pratiche aperte</a></li>
                <li><a href="?p=us.tesserini.archiviati"><i class="icon-folder-close"></i> Pratiche archiviate</a></li>
            </ul>
        </div>
        <!--<div class="btn-group">
            <a class="btn dropdown-toggle btn-primary" data-toggle="dropdown">
                <i class="icon-list"></i>
                Soci Ordinari
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="?p=us.tesserini.ordinari"><i class="icon-folder-open"></i> Pratiche aperte</a></li>
                <li><a href="?p=us.tesserini.archiviati.ordinari"><i class="icon-folder-close"></i> Pratiche archiviate</a></li>
            </ul>
        </div>-->
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontari..." type="text">
        </div>
    </div>    
</div>

<?php if(isset($_GET['nofoto'])) { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-exclamation-sign"></i> Impossibile generare il tesserino</h4>
        <p>Per poter generare il tesserino è necessario che l'utente abbia una fototessera caricata e approvata.</p>
    </div>
    <?php } elseif (isset($_GET['err'])) { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-exclamation-sign"></i> Qualcosa non ha funzionato</h4>
        <p>L'operazione che hai tentato di eseguire non è andata a buon fine. Per favore riprova.</p>
    </div>
    <?php } elseif (isset($_GET['gia'])) { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-exclamation-sign"></i> Operazione già effettuata</h4>
        <p>Non è possibile effettuare più volte la stessa operazione.</p>
    </div>
    <?php } elseif (isset($_GET['multi'])) { ?>
    <div class="alert alert-block alert-success">
        <h4><i class="icon-gears"></i> <?= (int) $_GET['multi']; ?> tesserini emessi</h4>
        <p>L'operazione di emissione multipla &egrave; andata a buon fine.</p>
    </div>
    <?php } elseif (isset($_GET['canc'])) { ?>
    <div class="alert alert-block alert-success">
        <h4><i class="icon-ok"></i> Tesserino cancellato</h4>
        <p>La cancellazione del tesserino è stata effettuata con successo.</p>
    </div>
    <?php } elseif (isset($_GET['stampato'])) { ?>
    <div class="alert alert-block alert-success">
        <h4><i class="icon-ok"></i> Stampa registrata</h4>
        <p>La registrazione della stampa del tesserino è avvenuta con successo.</p>
    </div>
    <?php } elseif (isset($_GET['spedito'])) { ?>
    <div class="alert alert-block alert-success">
        <h4><i class="icon-ok"></i> Spedizione registrata</h4>
        <p>La registrazione della spedizione del tesserino è avvenuta con successo.</p>
    </div>
    <?php } 
?>

<div class="alert alert-block alert-info">
<p><i class="icon-info-sign"></i> In questa pagina sono presenti tutte le richieste di emissione di <strong>tesserini</strong>
per <strong>volontari</strong> in corso di lavorazione.</p>
<p> Per procedere alla stampa di un tesserino premi il pulsante <strong>tesserino</strong> che ti permette di scaricare
un file in formato <strong>PDF</strong> con dimensioni secondo lo standard <strong>CR-80</strong>.</p>
<p> Per ogni tesserino è importante indicare tramite il pulsante <strong>Lavora pratica</strong> quando il tesserino è stato
stampato e quando il tesserino è stato effettivamente inviato al volontario. Se per qualche motivo non ti è possibile
emettere il tesserino potrai registrare questa informazione.</p>
</div>

<script type="text/javascript">
function selezionaTesserini(tipo) {

    $("[data-tesserino]").prop("checked", false);
    if ( tipo == undefined ) {
        selezioneCambiata();
        return;
    }

    $("[data-tesserino=" + tipo + "]").prop("checked", true);
    selezioneCambiata();

}

$(document).ready(function() {
    $("#nRichiesto").text($("[data-tesserino=<?= RICHIESTO; ?>]").length);
    $("#nStampato") .text($("[data-tesserino=<?= STAMPATO; ?>]").length);
    $("[data-tesserino]").change(function() {
        selezioneCambiata();
    });
    selezioneCambiata();

});

function selezioneCambiata() {
    var selezionati = $("[data-tesserino]:checked").length;
    $(".nSelezione").text(selezionati);
    if ( selezionati ) {
        $('.btn-lavorazione').removeAttr('disabled');
    } else {
        $('.btn-lavorazione').attr('disabled', 'disabled');
    }
}

</script>

<form action="?p=us.tesserini.multi" method="POST">
  
<div class="alert alert-success alert-block">
    <h4><i class="icon-magic"></i> Scorciatoie per operazioni multiple</h4>
    <div class="row-fluid">
        <div class="span6">
            <h5>Operazioni di Selezione</h5>
            <a href="#" onclick="javascript:selezionaTesserini(<?= RICHIESTO; ?>);" class="btn btn-block btn-success">
                Seleziona tutti i tesserini con stato <strong>Richiesto</strong> (<span id="nRichiesto">...</span>)
            </a>
            <a href="#" onclick="javascript:selezionaTesserini(<?= STAMPATO; ?>);" class="btn btn-block btn-success">
                Seleziona tutti i tesserini con stato <strong>Stampato</strong> (<span id="nStampato">...</span>)
            </a>
            <a href="#" onclick="javascript:selezionaTesserini();" class="btn btn-block">
                Deseleziona tutti i tesserini
            </a>
        </div>
        <div class="span6">
            <h5>Operazioni di Conferma</h5>
            <button class="btn btn-warning btn-block btn-lavorazione" name="operazione" value="lavora">
                <i class="icon-gears"></i> <strong>Lavora pratica (emissione)</strong> per <span class="nSelezione">0</span> tesserini selezionati
            </button>
            <button class="btn btn-warning btn-block btn-lavorazione" name="operazione" value="scarica">
                <i class="icon-download-alt"></i> <strong>Scarica tutti</strong> i <span class="nSelezione">0</span> tesserini selezionati
            </button>    
            <button class="btn btn-warning btn-block btn-lavorazione" name="operazione" value="lavora-scarica">
                <i class="icon-gears"></i> <i class="icon-download-alt"></i> <strong>Lavora pratica (emissione) e Scarica</strong> i <span class="nSelezione">0</span> tesserini selezionati
            </button>
        </div>

    </div>
</div>

<div class="row-fluid">
   <div class="span12">

       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">

            <thead>
                <th>Sel.</th>
                <th>Cognome</th>
                <th>Nome</th>
                <th>C. Fiscale</th>
                <th>Comitato</th>
                <th>Tesserino</th>
                <th>Azioni</th>
            </thead>

        <?php
        if ($admin) {
            $elenco = TesserinoRichiesta::filtra([
                ['stato', RIFIUTATO, OP_GT],
                ['stato', SPEDITO_CASA, OP_LT]
            ]);
        } else {
            $elenco = TesserinoRichiesta::filtra([
                ['struttura', $comitato->oid()],
                ['stato', RIFIUTATO, OP_GT],
                ['stato', SPEDITO_CASA, OP_LT]
            ]);
        }

        foreach($elenco as $tesserino) {

            $v = $tesserino->utente();

            $ultima = $v->ultimaAppartenenza(MEMBRO_ORDINARIO);
            if ($ultima && $ultima->attuale()) {
                continue;
            }

            $lavorabile = ($tesserino->stato != RIFIUTATO || $admin);
            ?>

            

            <tr>
                <td style="text-align: center;">
                    <input type="checkbox" name="selezione[]" value="<?= $tesserino->id; ?>" 
                        <?php if ( $lavorabile ) { ?>
                            data-tesserino="<?=$tesserino->stato; ?>"
                        <?php } else { ?>
                            disabled="disabled" readonly="readonly"
                        <?php } ?>
                         />
                </td>
                <td><?php echo $v->cognome; ?></td>
                <td><?php echo $v->nome; ?></td>
                <td><?php echo $v->codiceFiscale; ?></td>
                <td>
                    <?php echo $v->unComitato()->nome; ?>
                </td>
                <td>
                    <?= "{$conf['tesseriniStatoBreve'][$tesserino->stato]} il {$tesserino->data()->format('d/m/Y')}" ?>
                </td>
                <td>
                    <div class="btn-group">
                        <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $v->id; ?>" title="Dettagli">
                            <i class="icon-eye-open"></i> Dettagli
                        </a>
                        <?php if($lavorabile) { ?>
                        <a class="btn btn-small btn-info" href="?p=us.tesserini.p&id=<?php echo $tesserino->id; ?>" download title="Stampa Tesserino">
                            <i class="icon-credit-card"></i> Tesserino
                        </a>
                        <a class="btn btn-small btn-success" href="?p=us.tesserini.aggiorna&id=<?php echo $tesserino->id; ?>" title="Lavora Pratica">
                            <i class="icon-gears"></i> Lavora pratica
                        </a>
                        <?php } if($admin) { ?>
                            <a class="btn btn-small btn-danger" href="?p=admin.tesserini.cancella&id=<?php echo $tesserino->id; ?>" title="Cancella Pratica">
                                <i class="icon-trash"></i>
                            </a>
                        <?php } ?>
                    </div>
               </td>
            </tr>
        <?php } ?>
        </table>

    </div>
    
</div>

</form>
