<?php

paginaPrivata(false);

if ( $me->stato != ASPIRANTE )
    redirect('utente.me');

$consenso = $me->consenso();
if ( !$consenso ){ ?>
<div class="modal fade automodal">
    <div class="modal-header">
        <h3 class="text-success"><i class="icon-cog"></i> Aggiornamento condizioni d'uso di Gaia!</h3>
    </div>
    <div class="modal-body">
        <p>Ciao <strong><?php echo $me->nome; ?></strong>, Gaia ha aggiornato le sue condizioni d'uso.</p>
        <p>È importante per noi che tu sia informato riguardo le finalità di questo portale e riguardo
            a come vengono trattati i tuoi dati. Per fare ciò hai due possibilità: </p>
        <ul>
            <li>Leggi la pagina delle <a href="?p=public.privacy" target="_new"> <i>condizioni d'uso</i></a> ; </li>
            <li>Apri una nuova finestra del browser. Digita gaia.cri.it, clicca <i>informazioni</i> in fondo alla pagina e poi <i>condizioni d'uso</i>.</li>
        </ul>
        <p>Ti raccomandiamo di leggere con attenzione il documento perché contiene importanti 
            informazioni su come i tuoi dati sono gestiti.</p>
        <p>Se hai letto premi il pulsante "Ho letto!". Verrai indirizzato ad una pagina
            in cui potrai dare il consenso e gestire le informazioni che ti riguardano.</p>
        <p>Se non sei d'accordo premi il pulsante "Logout": non ti sarà possibile utilizzare i servizi offerti dal portale fino
            a che non accetterai le condizioni d'uso. </p>
        <p>Le condizioni d'uso resteranno valide fino all'entrata in vigore della versione aggiornata. Quando ciò
            accradrà verrai subito informato.</p>
        <p>Grazie per la fiducia, <br />
        Lo staff di Gaia</p>
    </div>
    <div class="modal-footer">
        <a href="?p=logout" class="btn">
            <i class="icon-remove"></i>
            Logout
        </a>
        <a href="?p=utente.privacy&first" class="btn btn-success">
            <i class="icon-ok"></i>
            Ho letto!
        </a>
    </div>
</div>
<?php } 

$a = Aspirante::daVolontario($me);

$iscritto = false;
$corso = $me->partecipazioniBase(ISCR_RICHIESTA); 
if($corso) {
    $iscritto = true;
    $corsoBaseRichiesto = $corso[0];
}

$corsoConfermato = $me->partecipazioniBase(ISCR_CONFERMATA);
if($corsoConfermato) {
    $iscritto = true;
    $corsoBaseConfermato = $corsoConfermato[0];
}

// Se non ho ancora registrato il mio essere aspirante
// però faccio questa cosa PRIMA del raggio minimo
if (!$a && !$iscritto)
    redirect('aspirante.registra');

if ($a) {
    $a->trovaRaggioMinimo();
}
?>
<div class="row-fluid">
    <div class="span3">
        <?php if($corsoBaseConfermato) {
                menuOrdinario(); 
            } else {
                menuAspirante();
            } ?>

    </div>
    <div class="span9">

        <h2><span class="muted">Ciao </span>
            <?= $me->nome; ?>
        </h2>
        <?php if(isset($_GET['err'])) { ?>
            <div class="alert alert-block alert-error">
            <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
            <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
            </div> 

        <?php } ?>

        <?php if ($iscritto && $corsoBaseConfermato) { ?>
            <div class="row-fluid">
                <div class="hero-unit" >
                    <h1><i class="icon-flag"></i> Complimenti, sei iscritto ad un Corso per Volontari! </h1>
                    <br />
                    <p>Ora non ti resta che presentarti presso il luogo indicato per lo svolgimento
                    delle lezioni che puoi vedere premendo il pulsante presente qui sotto.</p>
                    <a href="?p=formazione.corsibase.scheda&id=<?= $corsoBaseConfermato->corsoBase ?>" class="btn btn-large btn-info">
                        Scheda corso
                    </a>
                </div>
            </div>
        <?php } elseif($iscritto && $corsoBaseRichiesto) { ?>
            <div class="row-fluid">
                <div class="hero-unit" >
                    <h1><i class="icon-flag"></i> Complimenti, sei preiscritto* ad un Corso per Volontari! </h1>
                    <br />
                    <p>Ora non ti resta che presentarti presso il luogo indicato per lo svolgimento
                    delle lezioni.</p>
                    <p>Quando inizierà il corso ti verrà richiesta una quota di iscrizione, per avere maggiori dettagli premi il pulsante qui sotto.</p>
                    <p>* Saranno ammesse, a discrizione del Direttore, un massimo di trenta persone per ogni corso base.</p>
                    <a href="?p=formazione.corsibase.scheda&id=<?= $corsoBaseRichiesto->corsoBase ?>" class="btn btn-large btn-info">
                        Scheda corso
                    </a>
                </div>
            </div>
        <?php }?>
        <?php if(count($corsoBaseRichiesto) > 1) { ?>
            <div class="alert alert-block alert-info">
                <p><i class="icon-info-sign"></i> Hai più di una preiscrizione, <a href="?p=aspirante.preiscrizioni">controlla qui</a>. 
                Ricorda che potrai svolgere
                solo un corso, se ci sono preiscrizioni che non ti interessano cancellale, altrimenti quando
                inizierai un corso le altre preiscrizini verrano automaticamente rimosse dal sistema.</p>
            </div>

        <?php } ?>

        <?php if(!$corsoBaseConfermato) { ?>

        <div class="alert alert-block alert-info">
            <p><i class="icon-info-sign"></i> Riceverai notifica per email (<?php echo $me->email; ?>) 
            quando verranno organizzati nuovi corsi.</p>
            <p>Hai scelto di cercare corsi vicino a <strong><?php echo($a->luogo); ?></strong> se vuoi
            specificare una località differente clicca su <strong><i class="icon-map-marker"></i> Dove ti trovi?</strong> nel menù di sinistra.</p>
        </div>

        <div class="row-fluid">

            <div class="span4 offset2 allinea-centro">
                <div class="well">
                    <i class="icon-map-marker"></i> Nella tua zona sono presenti<br />
                    <span class="aspiranti_contatore">
                        <?php echo $a->numComitati(); ?></span>
                    <br />
                    <span class="aspiranti_descrizione">Unit&agrave; CRI</span>
                    <hr />
                    <a class="btn btn-block btn-large" href="?p=aspirante.elenco.comitati">
                        <i class="icon-globe"></i>
                        Scopri quali sono
                    </a>

                </div>
            </div>


            <div class="span4 allinea-centro">
                <div class="well">
                    <i class="icon-calendar-empty"></i> Attualmente organizzati<br />
                    <span class="aspiranti_contatore">
                        <?php echo $a->numCorsiBase(); ?></span>
                    <br />
                    <span class="aspiranti_descrizione">Corsi base</span>
                    <hr />
                    <a class="btn btn-block btn-success btn-large" href="?p=aspirante.elenco.corsi">
                        <i class="icon-list"></i> Vedi tutti
                    </a>
                </div>
            </div>

        </div> 

        <?php } ?>     

    </div>
</div>



<?php //yeah, funziona. var_dump($a->comitati(), $a->raggio);
