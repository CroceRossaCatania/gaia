<?php

paginaPrivata();

if ( $me->stato != ASPIRANTE )
    redirect('utente.me');

$iscritto = false;
$corso = $me->partecipazioniBase(ISCR_RICHIESTA); 
if($corso) {
    $iscritto = true;
    $corsoBase = $corso[0];

}

$a = Aspirante::daVolontario($me);
$a->trovaRaggioMinimo();



// Se non ho ancora registrato il mio essere aspirante
if (!$iscritto && !$a)
    redirect('aspirante.registra');

?>
<div class="row-fluid">
    <div class="span3">
        <?php menuAspirante(); ?>

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

        <?php if($iscritto) { ?>
            <div class="row-fluid">
                <div class="hero-unit" >
                    <h1><i class="icon-flag"></i> Complimenti, sei preiscritto ad un Corso per Volontari! </h1>
                    <br />
                    <p>Ora non ti resta che presentarti presso il luogo indicato per lo svolgimento
                    delle lezioni. Se hai bisogno di maggiori informazioni 
                    accedi alla scheda corso.</p>
                    <a href="?p=formazione.corsibase.scheda&id=<?= $corsoBase->corsoBase; ?>" class="btn btn-large btn-info">
                        Scheda corso
                    </a>
                </div>
            </div>
        <?php }?>
        <?php if(count($corso) > 1) { ?>
            <div class="alert alert-block alert-info">
                <p><i class="icon-info-sign"></i> Hai più di una preiscrizione, <a href="?p=aspirante.preiscrizioni">controlla qui</a>. 
                Ricorda che potrai svolgere
                sono un corso, se ci sono preiscrizioni che non ti interessano cancellale, altrimenti quando
                inizierai un corso le altre preiscrizini verrano automaticamente rimosse dal sistema.</p>
            </div>

        <?php } ?>



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

    </div>
</div>



<?php //yeah, funziona. var_dump($a->comitati(), $a->raggio);