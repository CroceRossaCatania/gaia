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
        <div class="btn-group">
            <a class="btn dropdown-toggle btn-primary" data-toggle="dropdown">
                <i class="icon-list"></i>
                Soci Ordinari
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="?p=us.tesserini.ordinari"><i class="icon-folder-open"></i> Pratiche aperte</a></li>
                <li><a href="?p=us.tesserini.archiviati.ordinari"><i class="icon-folder-close"></i> Pratiche archiviate</a></li>
            </ul>
        </div>
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
  
<div class="row-fluid">
   <div class="span12">

       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">

            <thead>
                <th>Cognome</th>
                <th>Nome</th>
                <th>C. Fiscale</th>
                <th>Comitato</th>
                <th>Tesserino</th>
                <th>Azioni</th>
            </thead>

        <?php
        if ($admin) {
            $elenco = TesserinoRichiesta::elenco();
        } else {
            $elenco = TesserinoRichiesta::filtra([
                ['struttura', $comitato->oid()]
            ]);
        }
        foreach($elenco as $tesserino) {
            if(!$tesserino->praticaAperta()) { continue; }
            $v = $tesserino->utente();
            ?>

            

            <tr>
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
                        <?php if($tesserino->stato != RIFIUTATO || $admin) { ?>
                        <a class="btn btn-small btn-info" href="?p=us.tesserini.p&id=<?php echo $tesserino->id; ?>" title="Stampa Tesserino">
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
