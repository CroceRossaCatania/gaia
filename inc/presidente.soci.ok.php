<?php

/*
 * ©2013 Croce Rossa Italiana
 */

set_time_limit(0);

paginaApp([APP_SOCI , APP_PRESIDENTE]);

if (isset($_POST['inputData'])) {
    $data = DateTime::createFromFormat('d/m/Y', $_POST['inputData']);
} else {
    $data = new DT();
}

menuElenchiVolontari(
    "Elenco Soci al {$data->format('d/m/Y')}",                  // Nome elenco
    "?p=admin.utenti.excel&soci",   // Link scarica elenco
    false                           // Link email elenco
);


$data = $data->getTimestamp();
$sessione->data = $data; // solo perchè in menù volontari non ho come mettere variabile

$admin = (bool) $me->admin();

$tesseratore = ($admin || $me->delegazioneAttuale()->estensione > EST_PROVINCIALE) ? true : false;
$chiedeTesserini = ($admin || $me->delegazioneAttuale()->estensione < EST_REGIONALE) ? true : false;


if(isset($_GET['nofoto'])) { ?>
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
            <h4><i class="icon-exclamation-sign"></i> Richiesta già effettuata</h4>
            <p>Non è possibile effettuare più richieste di tesserino per lo stesso volontario.</p>
        </div>
    <?php } elseif (isset($_GET['tok'])) { ?>
        <div class="alert alert-block alert-success">
            <h4><i class="icon-exclamation-sign"></i> Richiesta effettuata con successo</h4>
            <p>La tua richiesta di stampa del tesserino è stata correttamente presa in carico.</p>
        </div>
    <?php } elseif (isset($_GET['tdupko'])) { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Impossibile richiedere duplicato</h4>
            <p>La tua richiesta di duplicato del tesserino non è stata presa in caricoin quanto non esiste un tesserino da duplicare.</p>
        </div>
    <?php } elseif (isset($_GET['tdupok'])) { ?>
        <div class="alert alert-block alert-success">
            <h4><i class="icon-exclamation-sign"></i> Richiesta duplicato effettuata con successo</h4>
            <p>La tua richiesta di stampa del duplicato del tesserino è stata correttamente presa in carico.</p>
        </div>
    <?php } ?>

<div class="alert alert-block alert-info">
    <i class="icon-info-sign"></i> La richiesta di tesserino per un volontario può essere effettuata premendo sul pulsante <strong>Tesserino</strong>
    presente nella sezione azioni. <br />
    Il pulsante è presente per i soli soci attivi solamente per i quali la fototessera è stata caricata. È possibile
    caricare la fototessera entrando nella scheda <strong>Dettagli</strong>.
</div>
  
<div class="row-fluid">
   <div class="span12">

       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">

            <thead>
                <th>Cognome</th>
                <th>Nome</th>
                <th>C. Fiscale</th>
                <th>Data Ingresso</th>
                <th>Tesserino</th>
                <th>Azioni</th>
            </thead>

        <?php
        $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $t = $comitato->membriData($data);
                ?>

            <tr class="success">
                <td colspan="7" class="grassetto">
                    <?php echo $comitato->nomeCompleto(); ?>
                    <span class="label label-warning">
                        <?php echo count($t); ?>
                    </span>
                    <a class="btn btn-small pull-right" 
                       href="?p=presidente.utenti.excel&comitato=<?= $comitato->id; ?>&soci&data=<?= $data; ?>"
                       data-attendere="Generazione...">
                            <i class="icon-download"></i> scarica come foglio excel
                    </a>
                </td>
            </tr>
            <?php
            foreach ( $t as $_v ) {
                $modifica = $_v->modificabileDa($me);
                $tesserino = $_v->tesserinoRichiesta();
                $ordinario = (bool) $_v->ordinario();
                $app = $_v->appartenenzaAttuale();
                $fotot = $_v->fototessera();
                $fototessera = ($fotot && $fotot->stato == FOTOTESSERA_OK) ? true : false;
                $inQuestoComitato = ($app && $app->comitato()->id == $comitato->id) ? true : false;
            ?>
                <tr>
                    <td><?php echo $_v->cognome; ?></td>
                    <td><?php echo $_v->nome; ?></td>
                    <td><?php echo $_v->codiceFiscale; ?></td>
                    <td>
                        <?php if ( $_v->ingresso() ){ echo $_v->ingresso()->format("d/m/Y"); } else { echo "<br><i>Errore data ingresso</i></br>"; } ?>
                    </td>
                    <td>
                        <?php 
                        if($tesserino) {
                            echo("{$conf['tesseriniStatoBreve'][$tesserino->stato]} il {$tesserino->data()->format('d/m/y')}");
                        } elseif(!$ordinario && $inQuestoComitato) {
                            echo("Non richiesto");
                        } elseif( $ordinario && $inQuestoComitato) {
                            echo("Non richiesto ordinario");
                        }
                        ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $_v->id; ?>" title="Dettagli">
                                <i class="icon-eye-open"></i> Dettagli
                            </a>
                            <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>" title="Invia Mail">
                                <i class="icon-envelope"></i>
                            </a>
                        </div>
                        <?php if(!$ordinario && $inQuestoComitato && $modifica && $chiedeTesserini && !$tesserino && $fototessera ) { ?>
                            <a class="btn btn-small btn-info" href="?p=us.tesserini.chiedi.ok&id=<?= $_v ?>" title="Richiedi tesserino">
                                <i class="icon-credit-card"></i> Richiedi tesserino
                            </a>                            
                        <?php } elseif(!$ordinario && $inQuestoComitato && $modifica && $chiedeTesserini && $tesserino && $fototessera && $tesserino->stato > STAMPATO ){ ?>
                            <a class="btn btn-small btn-info" href="?p=us.tesserini.duplicato.ok&id=<?= $_v ?>" title="Richiedi duplicato tesserino">
                                <i class="icon-credit-card"></i> Duplicato tesserino
                            </a>
                        <?php } if($tesseratore && $tesserino && $tesserino->stato > STAMPATO){ ?>
                            <a class="btn btn-small btn-info" href="?p=us.tesserini.p&id=<?= $tesserino ?>" title="Tesserino">
                                <i class="icon-credit-card"></i> Tesserino
                            </a>
                        <?php } /* elseif($ordinario && $inQuestoComitato && $modifica && $chiedeTesserini && !$tesserino) { ?>
                            <a class="btn btn-small btn-info" href="?p=us.tesserini.chiedi.ordinario&id=<?= $_v ?>" title="Richiedi tesserino">
                                <i class="icon-credit-card"></i> Tesserino
                            </a> 
                        <?php }elseif($ordinario && $tesseratore && $tesserino && $tesserino->stato > STAMPATO) { ?>
                            <a class="btn btn-small btn-info" href="?p=us.tesserini.duplicato.ordinario&id=<?= $_v ?>" title="Richiedi tesserino">
                                <i class="icon-credit-card"></i> Duplicato tesserino
                            </a> 
                        <?php } */ ?>
                   </td>
                </tr>
        <?php }
        }
        ?>
        </table>

    </div>
    
</div>
