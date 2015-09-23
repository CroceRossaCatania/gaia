<?php
error_reporting(E_ALL);
/*
 * ©2015 Croce Rossa Italiana
 */
paginaPresidenziale();

$id = intval($_GET['id']);
$c = $organizzatoreId = null;
$luogo = $inizio = $partecipanti = $descrizione = '';

/**
 * 
 *  NESSUNA MODIFICA AI DATI BASE DEL CORSO 
 * 
 **/
if (false && !empty($id) && is_int($id)) {
    /*
    $wizard = false;
    try {
        $c = Corso::id($id);
        if (empty($c)) {
            throw new Errore('Manomissione');
        }
        
        $_organizzatoreId = $c->organizzatore()->id;
        $_certificatoId = $c->certificato()->id;
    } catch(Exception $e) {
        redirect('admin.corsi.crea&err');
    }
    
    if (!$c->modificabile()) {
        redirect('formazione.corsi.riepilogo&id='.$id);
    }
    */
} else {
    $wizard = true;
}

caricaSelettoreComitato();

$comitati = $me->comitati();
$certificati = TipoCorso::elenco();

?>
<script>
var minDateOffset = <?php echo TipoCorso::limiteMinimoPerIscrizione() ?>;
</script>
<div class="row-fluid">

    <div class="span8">
        <h2><i class="icon-plus-square icon-calendar muted"></i> Corso di formazione</h2>
        <form action="?p=formazione.corsi.crea.ok" method="POST">
            <input value="<?php echo @$c->id ?>" name="id" type="hidden">
            <input value="<?php echo empty($wizard) ? 0 : 1 ?>" name="wizard" type="hidden">
            <div class="alert alert-block alert-success">
                <div class="row-fluid">
                    <h4><i class="icon-question-sign"></i> Dati del corso...</h4>
                </div>
                <hr>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="organizzatore"><i class="icon-user-md"></i> Comitato organizzatore</label>
                    </div>
                    <div class="span8">
                        <select name="organizzatore"><?php echo $organizzatoreId ?>
                            <?php foreach ($comitati as $t) { ?>
                                <option value="<?php echo $t->id ?>" <?php echo ($t->id==$_organizzatoreId) ? "selected='selected'" : '' ?>><?php echo $t->nome ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="tipologia"><i class="icon-certificate"></i> Tipologia</label>
                    </div>
                    <div class="span8">
                        <select name="certificato">
                            <?php foreach ($certificati as $t) { ?>
                                <option value="<?php echo $t->id ?>" <?php echo ($t->id==$_certificatoId) ? "selected='selected'" : '' ?>><?php echo $t->nome ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="tipologia"><i class="icon-building"></i> Luogo</label>
                    </div>
                    <div class="span8">
                        <input id="luogo" class="span12" name="luogo" value="<?php echo @$c->luogo ?>" type="text">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="dataInizio"><i class="icon-calendar"></i> Data Di inizio</label>
                    </div>
                    <div class="span8">
                        <input id="dataInizio" class="span12" name="inizio" value="<?php echo ($c) ? (new DT('@'.$c->inizio))->format('d/m/Y H:i') : '' ?>" type="text" required>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="partecipanti"><i class="icon-calendar"></i> Numero Partecipanti</label>
                    </div>
                    <div class="span8">
                        <input id="partecipanti" class="span12 hasDatepicker" name="partecipanti" value="<?php echo @$c->partecipanti ?>" type="text">
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4">
                        <label for="descrizione"><i class="icon-text"></i> Descrizione</label>
                    </div>
                    <div class="span8">
                        <textarea id="descrizione" class="span12" name="descrizione"><?php echo @$c->descrizione ?></textarea>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4 offset4">
                        <button type="submit" class="btn btn-success">
                            <i class="icon-ok"></i>
                            Crea il corso
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="span4">
        <h4 style="line-height:40px">Azioni</h4>
        <nav>
            <ul style="list-style-type: none">
                <li>
                    <a class="btn btn-danger" href="?p=utente.me">
                        <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                        Eliminare
                    </a>
                </li>
                <li>
                    <a class="btn btn-danger" href="?p=utente.me">
                        <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                        Convalidare
                    </a>
                </li>
                <li>
                    <a class="btn btn-danger" href="?p=utente.me">
                        <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                        richiedi iscrizione
                    </a>
                </li>
                <li>
                    <a class="btn btn-danger" href="?p=utente.me">
                        <i class="icon-plus-sign-alt icon-large"></i>&nbsp;
                        chiudi corso -> valutazione
                    </a>
                </li>
            </ul>
        </nav>

    </div>
</div>