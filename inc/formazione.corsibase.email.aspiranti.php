<?php

/*
* ©2014 Croce Rossa Italiana
*/


paginaPrivata();
controllaParametri(['id']);

$corso = CorsoBase::id($_GET['id']);
paginaCorsoBase($corso);

if (!$corso->haPosizione()) {
    redirect('formazione.corsibase.localita&id=' . $corso->id);
}

if (!$corso->daCompletare()) {
    redirect("formazione.corsibase.scheda&id={$corso}");
}

$_titolo = $corso->nome . 'Corso Base CRI su Gaia';
$_descrizione = $corso->luogo
." || Organizzato da " . $corso->organizzatore()->nomeCompleto();

?>

<form action="?p=formazione.corsibase.email.aspiranti.ok" method="POST">
<input type="hidden" name="id" value="<?php echo $corso->id; ?>" />
    
<div class="row-fluid">
    
    <div class="span7">
        <h2><i class="icon-flag-checkered muted"></i> Attivazione Corso Base</h2>
    </div>
    
    <div class="btn-group pull-right">
        <a href="?p=formazione.corsibase.scheda&id=<?= $corso ?>" class="btn btn-large btn-info">
            <i class="icon-mail-reply"></i> Indietro
        </a>
        <a href="?p=formazione.corsibase.modifica&id=<?= $corso ?>" class="btn btn-large btn-info">
            <i class="icon-edit"></i> Modifica
        </a>
        <button type="submit" name="azione" value="salva" class="btn btn-success btn-large">
            <i class="icon-save"></i> Attiva Corso
        </button>
    </div>
    
</div>
    <hr />
<div class="row-fluid">
    <div class="span12">
    
        <div class="alert alert-info">
            <i class="icon-info-sign"></i>
            Presta molta attenzione e rivedi i <strong> dettagli del corso </strong>:</br>
            <ul>
                <li>queste informazioni verranno inviate agli aspiranti che vogliono frequentare
                un corso base per volontari CRI in zona; fornisci loro tutte le indicazioni che ritieni possano 
                essere utili;</li>
                <li>Queste informazioni saranno rese pubbliche ed accessibili a chiunque: <strong>evita</strong>
                di inserire dati personali, numeri di telefono privati o informazioni che non vorresti fossero divulgate;</li>
                <li>Agli aspiranti volontari che si registrano verranno fornite le informazioni per 
                contattare il direttore del corso in caso necessità;</li>
                <li>Non ti sarà più possibile inviare altre comunicazioni via email agli aspiranti volontari della tua
                zona, ma fino alla data di inizio del corso Gaia provvederà a mandare una notifica settimanale
                ad ognuno di loro;</li>
                <li>Per attivare il corso premi <strong>Attiva Corso</strong>.</li>
            </ul>

        </div>
        <hr />
        <h3>Bozza del testo che verrà inviato agli aspiranti</h3>
        <p>Per modificare il testo vai alla sezione di modifica delle informazioni del corso.</p>
        <?php 

        $sostituzioni = [];
        $sostituzioni['_ASPIRANTE'] = "Nome aspirante";
        $sostituzioni['_DESCRIZIONE'] = $corso->descrizione;
        $sostituzioni['_COMITATO'] = $corso->organizzatore()->nomeCompleto();
        $sostituzioni['_INIZIO'] = $corso->inizio()->inTesto(true, false);


        $corpo      = file_get_contents('./core/conf/mail/modelli/corsoBaseAttivato.html');
        foreach ( $sostituzioni as $nome => $valore ) {
            $corpo = str_replace($nome, $valore, $corpo);
        }
        $corpo = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $corpo);
        ?>
        <div class="alert alert-panel">
            <?= $corpo ?>
        </div>